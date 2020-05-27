<?php
set_time_limit(600);
$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_PAYMENT');

//$_SESSION['cart']->calculate();
//Tianwen.Wan20160624购物车优化
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();

$get_country_code_query = "Select countries_iso_code_2 From " . TABLE_COUNTRIES . ", " . TABLE_ADDRESS_BOOK . "
							Where address_book_id = " . (int)$_SESSION['sendto'] . "
							  And entry_country_id = countries_id";
$get_country_code = $db->Execute($get_country_code_query);
$get_country_code_2 = $get_country_code->fields['countries_iso_code_2'];
if ($_SESSION['shipping']['code'] == 'afexpr' && $get_country_code_2 != 'ZA'){
	zen_redirect(zen_href_link(FILENAME_CHECKOUT, 'pn=sc', 'SSL'));
}
if ($products_array['count'] <= 0 && !$_SESSION['order_number_created']) {
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}
if (!$_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
} else {
	if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
		$_SESSION['navigation']->set_snapshot();
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}
if (!$_SESSION['shipping']) {
	zen_redirect(zen_href_link(FILENAME_CHECKOUT, 'pn=sc', 'SSL'));
}
if (isset($_SESSION['cart']->cartID) && $_SESSION['cartID']) {
	if ($_SESSION['cart']->cartID != $_SESSION['cartID'] && !$_SESSION['order_number_created']) {
		zen_redirect(zen_href_link(FILENAME_CHECKOUT, 'pn=sc', 'SSL'));
	}
}

if ((STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') && !$_SESSION['order_number_created']) {
	$lds_unvalid_stock = $db->Execute("Select p.products_id,cb.customers_basket_quantity 
										 From " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS_BASKET . " cb
										Where p.products_id = cb.products_id
										  And cb.customers_id = " . $_SESSION['customer_id']);
	if ($lds_unvalid_stock->RecordCount() > 0) {
	    $products_quantity = zen_get_products_stock($lds_unvalid_stock->fields['products_id']);
	    if($lds_unvalid_stock->fields['customers_basket_quantity']>$products_quantity) zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
	}
}
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_payment.php');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$_SESSION['has_first_coupon'] = zen_check_first_coupon();
if ($_SESSION['cc_id'] && !zen_customer_has_valid_order() && $order->info['subtotal'] < 30){
	unset($_SESSION['cc_id']);
}
if ($_SESSION['cc_id']) {
	$discount_coupon_query = "SELECT coupon_code FROM " . TABLE_COUPONS . " WHERE coupon_id = :couponID";
	$discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
	$discount_coupon = $db->Execute($discount_coupon_query);
}

if (!$_SESSION['billto']) {
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
} else {
	$check_address_query = "SELECT count(*) AS total FROM " . TABLE_ADDRESS_BOOK . " WHERE customers_id = :customersID AND address_book_id = :addressBookID";
	$check_address_query = $db->bindVars($check_address_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$check_address_query = $db->bindVars($check_address_query, ':addressBookID', $_SESSION['billto'], 'integer');
	$check_address = $db->Execute($check_address_query);
	if ($check_address->fields['total'] != '1') {
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		$_SESSION['payment'] = '';
	}
}

require(DIR_WS_CLASSES . 'order.php');
$order = new order($_SESSION['order_number_created'], $products_array['data']);

$comments = $_SESSION['comments'];
$total_weight = $_SESSION['cart']->show_weight();
$total_count = $products_array['count'];

require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']['code']);

if (isset($_GET['payment_error']) && is_object(${$_GET['payment_error']}) && ($error = ${$_GET['payment_error']}->get_error())) {
	$messageStack->add('checkout_payment', $error['error'], 'error');
}

if(!$_SESSION['order_number_created'] && isset($_SESSION['shipping'])){
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE');
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_AFTER_ORDER_CREATE');
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE_ADD_PRODUCTS');
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_SEND_ORDER_EMAIL');
}

require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment;
$payment_selection = $payment_modules->selection();

if (isset($_SESSION['order_number_created'])) {
	$order_total_show = new order($_SESSION['order_number_created'], $products_array['data']);
}

$order_total = 0;
$order_totals_arr = array();
for ($i = 0, $n = sizeof($order_total_show->totals); $i < $n; $i++) {
	$order_totals_arr[$order_total_show->totals[$i]['class']] = $order_total_show->totals[$i];
	if ($order_total_show->totals[$i]['class'] == 'ot_total') {
		continue;
	}
	if (is_int(stripos($order_total_show->totals[$i]['text'], "-")) && $order_total_show->totals[$i]['class'] != 'ot_cash_account') {
		$order_total = $order_total - $order_total_show->totals[$i]['value'];
	} else if ($order_total_show->totals[$i]['class'] != 'ot_cash_account') {
		$order_total = $order_total + $order_total_show->totals[$i]['value'];
	}
}

$order_total = $currencies->format($order_total, true, $order_total_show->info['currency'], $order_total_show->info['currency_value']);

//	about paypal
unset($_SESSION['paypal_ec_temp']);
unset($_SESSION['paypal_ec_token']);
unset($_SESSION['paypal_ec_payer_id']);
unset($_SESSION['paypal_ec_payer_info']);
$payment_paypal = new payment('paypalwpp');
if (!$payment_paypal->in_special_checkout() && $payment_paypal->enableDirectPayment == false) {
	$message['payment_pal_submit_url'] = zen_href_link('ipn_main_handler.php', "type=ec&markflow=1&clearSess=1&stage=final", 'SSL', true, true, true);
} else {
	$message['payment_pal_submit_url'] = '';
}

$use_all_cash = false;
if (isset($_SESSION['order_number_created']) && $_SESSION['order_number_created'] != '') {
	$message['order_number_created'] = $_SESSION['order_number_created'];
	if ($order_totals_arr['ot_cash_account']['value'] > 0 && $order_totals_arr['ot_total']['value'] == 0) {
		$sql_data_array = array('payment_method' => 'Credit Balance', 'payment_module_code' => 'Credit Balane');
		zen_db_perform(TABLE_ORDERS, $sql_data_array, 'update', "orders_id = '" . (int) $_SESSION['order_number_created'] . "'");
		$use_all_cash = true;
		
		$credit_records = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
							   From " . TABLE_CASH_ACCOUNT . "
						      Where cac_customer_id = " . $_SESSION ['customer_id'] . "
							    And cac_status = 'A'" );
		
		$credit_account_left = 0;
		while ( ! $credit_records->EOF ) {
			$ca_currency_code = $credit_records->fields ['cac_currency_code'];
			$ca_amount = $credit_records->fields ['cac_amount'];
			$credit_account_left += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
			$credit_records->MoveNext ();
		}
		$credit_account_code = $_SESSION['currency'];
		$credit_account_left =zen_change_currency($credit_account_left,  'USD', $credit_account_code);			
		$credit_account_left = number_format($credit_account_left, 2);

		$credit_account_old = number_format($order_totals_arr['ot_cash_account']['value'], 2);
	}elseif($order_totals_arr['ot_cash_account']['value'] != 0 && $order_totals_arr['ot_total']['value'] > 0){
		
	}
}

$order_query = "select orders_status from " . TABLE_ORDERS . " where orders_id = '" . (int)$_SESSION['order_number_created'] . "' limit 1";
$orders_status = $db->Execute($order_query);
if($orders_status->fields['orders_status'] > 1 /*&& !$use_all_cash*/) {
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'order_id=' . (int) $_SESSION['order_number_created'] , 'SSL'));
}
/*fix order_total weishuiliang*/
$cash_account_remaining = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
							   From " . TABLE_CASH_ACCOUNT . "
						      Where cac_customer_id = " . $_SESSION ['customer_id'] . "
							    And cac_status = 'A'" );
$cash_account_remaining_total = 0;
while ( ! $cash_account_remaining->EOF ) {
	$ca_currency_code = $cash_account_remaining->fields ['cac_currency_code'];
	$ca_amount = $cash_account_remaining->fields ['cac_amount'];
	$cash_account_remaining_total += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
	$cash_account_remaining->MoveNext ();
}
$cash_account_primary_total = $cash_account_remaining_total + $order_totals_arr['ot_cash_account']['value'];

/*end*/
$message = array();
$message['order_succ'] = TEXT_PAYMENT_YOUR_ORDER_SUCCESS;
$message['discount_amount'] = $discount_amount_query->fields['value'];
$message['special_coupon_str'] = $special_coupon_str;
$message['currency_symbol_left'] = $currencies->currencies [$order_total_show->info['currency']] ['symbol_left'];
$message['order_total_no_currency_left'] = $order_totals_arr['ot_total']['value'];
$message['order_total_wire_min'] = ORDER_TOTAL_WIRE_MIN;
$message['order_number'] = TEXT_PAYMENT_ORDER_NUMBER;
$message['payment_methods'] = TABLE_HEADING_PAYMENT_METHOD;
$message['payment_credit_card'] = TEXT_CREDIT_CARD_VISA_PAYPAL;
$message['payment_total_amount'] = TEXT_GRAND_TOTAL;
$message['payment_pay_now'] = TEXT_PAYMENT_PAY_NOW;
$message['paid'] = TEXT_PAID;
$message['payment_paypal_directly'] = TEXT_PAYMENT_OR_DIRECTLY_LOGIN;
$message['payment_paypal_clicking'] = TEXT_PAYMENT_PAY_US_CLICK;
$message['payment_credit_account_blance'] = TEXT_YOUR_CREDIT_ACCOUNT_BALANCE;
$message['payment_show_balance_html_or_not'] = isset($order_totals_arr['ot_cash_account']) ? true : false ;
$message['payment_total_balance_old'] = $currencies->format($cash_account_primary_total, true, $order_total_show->info['currency'], $order_total_show->info['currency_value']);
$message['payment_total_balance_remain'] = $currencies->format($cash_account_remaining_total, true, $order_total_show->info['currency'], $order_total_show->info['currency_value']);
$message['payment_balance_left'] = sprintf(TEXT_BALANCE_LEFT, $currencies->format($credit_account_left, true, $order_total_show->info['currency'], $order_total_show->info['currency_value']));
$message['payment_need_to_pay'] = $currencies->format($order_totals_arr['ot_total']['value'], true, $order_total_show->info['currency'], $order_total_show->info['currency_value']);
$message['payment_moneygram_text_head'] = MODULE_PAYMENT_MONEYGRAM_TEXT_HEAD;
$message['payment_pay_for_this_order'] = sprintf(TEXT_PAY_FOR_THIS_ORDER, $order_total);
$message['payment_pay_for_this_order_show'] = $currencies->format($order_totals_arr['ot_cash_account']['value'], true, $order_total_show->info['currency'], $order_total_show->info['currency_value']);
$message['payment_button_submit'] = TEXT_SUBMIT;
$message['payment_order_total_usd'] = $order_totals_arr['ot_cash_account']['value'] + round($order_totals_arr['ot_total']['value'], 2);
$message['payment_show'] = TEXT_PAYMENT_SHOW;
$message['payment_our_paypal_is'] = TEXT_PAYMENT_OUR_PAYPAL_IS;
$message['payment_bank_hsbc'] = TEXT_PAYMENT_BANK_HSBC;
$message['payment_bank_china'] = TEXT_PAYMENT_BANK_CHINA;
$message['payment_bank_western_union'] = TEXT_PAYMENT_BANK_WESTERN_UNION;
$message['payment_credit_card_via_paypal'] = TEXT_PAYMENT_CREDIT_CARD_VIA_PAYPAL;
$message['payment_download'] = TEXT_PAYMENT_DOWNLOAD;
$message['payment_print'] = TEXT_PAYMENT_PRINT;
$message['payment_order_total'] = $currencies->format($order_totals_arr['ot_cash_account']['value'] + $order_totals_arr['ot_total']['value'], true, $order_total_show->info['currency'], $order_total_show->info['currency_value']);
$message['westernunion'] = $GLOBALS['westernunion']->confirmation();
$message['wirebc'] = $GLOBALS['wirebc']->confirmation();
$message['wire'] = $GLOBALS['wire']->confirmation();
$message['moneygram'] = $GLOBALS['moneygram']->confirmation();
$message['account_you_can_pay_us'] = TEXT_YOU_CAN_PAY_US;
$message['account_view_how'] = TEXT_VIEW_HOW;
$message['account_payment_note'] = TEXT_PAYMENT_NOTE;
$message['account_payment_hsbs_china'] = TEXT_PAYMENT_HSBS_CHINA;
$message['account_payment_wumt'] = TEXT_PAYMENT_WUMT;
$message['account_payment_money_gram_2'] = TEXT_PAYMENT_MONEY_GRAM_2;
$message['account_payment_money_gram'] = TEXT_PAYMENT_MONEY_GRAM;
$message['payment_coupon'] = TEXT_COUPON;

if ($messageStack->size('checkout_payment') > 0) {
	$message['checkout_payment_size'] = $messageStack->size('checkout_payment');
	ob_start();
	$messageStack->output('checkout_payment');
	$checkout_payment_content = ob_get_contents();
	$checkout_payment_content = strip_tags($checkout_payment_content, '<a> <span> <br> <br/>');
	ob_end_clean();
	$message['checkout_payment'] = $checkout_payment_content;
}

if (!$payment_paypal->in_special_checkout() && $payment_paypal->enableDirectPayment == false) {
	$message['payment_pal_submit_url'] = zen_href_link('ipn_main_handler.php', 'type=ec&markflow=1&clearSess=1&stage=final', 'SSL', true, true, true);
} else {
	$message['payment_pal_submit_url'] = '';
}

if (isset($_SESSION['order_number_created']) && $_SESSION['order_number_created'] != '') {
	$message['order_number_created'] = $_SESSION['order_number_created'];
}

$message['payment_submit'] = zen_href_link(FILENAME_CHECKOUT_CONFIRMATION);
$message['payment_submit_succ'] = zen_href_link(FILENAME_CHECKOUT_SUCCESS);
$message['account_text_http_server'] = HTTP_SERVER;

if ($order_totals_arr['ot_cash_account']['value'] > 0) {
	$order_totals_arr['ot_cash_account']['text'] = str_replace('-', '', $order_totals_arr['ot_cash_account']['text']);
}
if ($order_totals_arr['ot_cash_account']['value'] < 0) {
	$order_totals_arr['ot_cash_account']['text'] = '- ' . $order_totals_arr['ot_cash_account']['text'];
}

$obj_text = array();

$payment_module_code = '';
$order_payment_query = "select  payment_module_code from " . TABLE_ORDERS . " where customers_id = '" . (int) $_SESSION['customer_id'] . "' and orders_id < ".$_SESSION['order_number_created']." order by orders_id desc limit 1";
$order_payment_result = $db->Execute($order_payment_query);
if($order_payment_result->RecordCount() > 0){
	$payment_module_code = $order_payment_result->fields['payment_module_code'];
}
/*WSL 2015-06-16*/
if ($order_totals_arr['ot_total']['value'] < ORDER_TOTAL_WIRE_MIN && ($payment_module_code == 'wire' || $payment_module_code== 'wirebc')){
	$payment_module_code = 'paypalwpp';
}

if ($payment_module_code == '' || $payment_module_code == 'Credit Balane') {
	$payment_module_code = 'paypalwpp';
}

$message["payment_module_code"] = $payment_module_code;
$obj_text["text_name"] = ENTRY_NAME;
$obj_text["logo_img"] = zen_image(DIR_WS_LANGUAGE_IMAGES . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT);
$obj_text["logo_img_link"] = HTTP_SERVER . (($_SESSION['languages_id'] == 1) ? '' : '/' . $_SESSION['languages_code']) . '/';
$obj_text["checkout_step_1"] = TEXT_CHECKOUT_STEP1;
$obj_text["checkout_step_2"] = TEXT_CHECKOUT_STEP2;
$obj_text["checkout_step_3"] = TEXT_CHECKOUT_STEP3;
$obj_text["checkout_step_4"] = TEXT_CHECKOUT_STEP4;
$obj_text["live_help_img"] = zen_image(DIR_WS_LANGUAGE_IMAGES . 'icon_livechat.png');
$obj_text["text_address_info"] = TEXT_ADDRESS_INFOMATION;
$obj_text["text_required_fields"] = TEXT_REQUIRED_FIELDS;
$obj_text["text_shipping_method"] = TEXT_SHIPPING_METHOD;
$obj_text["text_invoice_comments"] = TEXT_INVOICE_COMMENTS;
$obj_text["text_review_order"] = TEXT_REVIEW_ORDER;
$obj_text["info_customers_id"] = $_SESSION['customer_id'];
$obj_text["text_gender"] = TEXT_GENDER;
$obj_text["text_male"] = TEXT_MALE;
$obj_text["text_female"] = TEXT_FEMALE;
$obj_text["text_firstname"] = ENTRY_FIRST_NAME;
$obj_text["text_lastname"] = ENTRY_LAST_NAME;
$obj_text["text_address_line_1"] = ENTRY_SUBURB1;
$obj_text["text_address_line"] = ENTRY_SUBURB;
$obj_text["text_address_postage"] = SHIPPING_ADDRESS_DETAIL_POSTAGE;
$obj_text["text_country"] = ENTRY_COUNTRY;
$obj_text["text_state"] = ENTRY_STATE;
$obj_text["text_address_state"] = SHIPPING_ADDRESS_DETAIL_STATE;
$obj_text["text_city"] = ENTRY_CITY;
$obj_text["text_zip"] = ENTRY_POST_CODE;
$obj_text["text_telephone"] = ENTRY_TELEPHONE_NUMBER;
$obj_text["text_require_telephone"] = ENTRY_TELEPHONE_REQUIRED_TEXT;
$obj_text["text_shipping_address"] = TABLE_HEADING_SHIPPING_ADDRESS;
$obj_text["text_save_address"] = TABLE_SAVE_ADDRESS;
$obj_text["text_delete"] = TEXT_DELETE;
$obj_text["text_sure_to_delete"] = TEXT_SURE_TO_DELETE;
$obj_text["text_enter_a_address"] = TEXT_ENTER_A_ADDRESS;
$obj_text["text_please_enter"] = CHECKOUT_ADDRESS_BOOK_PLEASE_ENTER;
$obj_text["text_char_at_least"] = CHECKOUT_ADDRESS_BOOK_CHARACTERS_AT_LEAST;
$obj_text["text_right_state"] = CHECKOUT_ADDRESS_BOOK_RIGHT_STATE;
$obj_text["text_cancel"] = TEXT_CANCEL;
$obj_text["text_edit_address_info"] = TEXT_EDIT_ADDRESS_INFO;
$default_select_id = zen_get_selected_country($_SESSION['languages_id']);
$message["text_grand_total"] = TEXT_GRAND_TOTAL;
$message["text_use_it_payment"] = TEXT_USE_IT_PAYMENT;
$message["text_used"] = TEXT_USED;
$message["webmoney_text"] = MODULE_PAYMENT_WEBMONEY_TEXT_DESCRIPTION_CHECKOUT;
$message['success_order_details'] = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . (int) $_SESSION['order_number_created'], 'SSL');

$show_gc_payment = true;
$message["show_gc_payment"] = $show_gc_payment;
$obj_text["zone_list"] = zen_js_zone_list('SelectedCountry', 'theForm', 'zone_id');
$country_select_name = 'zone_country_id';
$obj_text["country_select"] = zen_get_country_select($country_select_name, $default_select_id, $_SESSION['languages_id']);

$smarty->assign('obj_text', $obj_text);
$smarty->assign('coupon_select', $coupon_select);
/* payment_update address */
$smarty->assign('order_total', $order_total);
$smarty->assign('order_totals_arr', $order_totals_arr);
$smarty->assign('javascript_validation', $payment_modules->javascript_validation());
$smarty->assign('message', $message);
$smarty->assign('payment_selection', $payment_selection);
$smarty->assign('count_order', sizeof($order->products));
$smarty->caching = 0;

$tpl_head = DIR_WS_TEMPLATE_TPL . 'tpl_play_order_head.html';
$smarty->assign ( 'tpl_head', $tpl_head );
?>
