<?php
set_time_limit(600);
$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_PAYMENT');
$paypal_payment_message = zen_db_prepare_input($_GET['paypal_payment_message']);
//$_SESSION['cart']->calculate();
$_SESSION['valid_to_checkout'] = true;
$_SESSION['cart_errors'] = '';
//$_SESSION['cart']->get_isvalid_checkout(true);
//Tianwen.Wan20160624购物车优化
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();

require(DIR_WS_CLASSES . 'order.php');

if(isset($_SESSION['order_number_created'])) {
	$order = new order($_SESSION['order_number_created']);
	if($order->info['orders_status_id'] != "1") {
		zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS));
	} 
}

$get_country_code_query = "Select countries_iso_code_2 From " . TABLE_COUNTRIES . ", " . TABLE_ADDRESS_BOOK . "
							Where address_book_id = " . (int)$_SESSION['sendto'] . "
							  And entry_country_id = countries_id";
$get_country_code = $db->Execute($get_country_code_query);
$get_country_code_2 = $get_country_code->fields['countries_iso_code_2'];
if ($_SESSION['shipping']['id'] == 'afexpr_afexpr' && $get_country_code_2 != 'ZA'){
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() <= 0 && !$_SESSION['order_number_created']) {
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}
// if the customer is not logged on, redirect them to the login page
if (!$_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
} else {
// validate customer
	if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
		$_SESSION['navigation']->set_snapshot();
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!$_SESSION['shipping']) {
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}
// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset($_SESSION['cart']->cartID) && $_SESSION['cartID']) {
	if ($_SESSION['cart']->cartID != $_SESSION['cartID'] && !$_SESSION['order_number_created']) {
		zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
	}
}


if (!$_SESSION['valid_to_checkout']  && !$_SESSION['order_number_created']) {
	$messageStack->add_session('shopping_cart', ERROR_CART_UPDATE . $_SESSION['cart_errors'] , 'caution');
	zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

// Stock Check
if ((STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') && !$_SESSION['order_number_created']) {
	$lds_unvalid_stock = $db->Execute("Select p.products_id ,cb.customers_basket_quantity  
										 From " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS_BASKET . " cb
										Where p.products_id = cb.products_id 
										  And cb.customers_id = " . $_SESSION['customer_id']);
	if ($lds_unvalid_stock->RecordCount() > 0) {
	    $products_quantity = zen_get_products_stock($lds_unvalid_stock->fields['products_id']);
	    if($lds_unvalid_stock->fields['customers_basket_quantity']>$products_quantity){
	    	$out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    		zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
	    }
	}
}

// get coupon code
$_SESSION['has_first_coupon']=zen_check_first_coupon();
if ($_SESSION['cc_id'] && !zen_customer_has_valid_order() && $order->info['subtotal'] < 30){
	unset($_SESSION['cc_id']);
}
if ($_SESSION['cc_id']) {
	$discount_coupon_query = "SELECT coupon_code
										FROM " . TABLE_COUPONS . "
									  WHERE coupon_id = :couponID";

	$discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
	$discount_coupon = $db->Execute($discount_coupon_query);
}

// if no billing destination address was selected, use the customers own address as default
if (!$_SESSION['billto']) {
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
} else {
	// verify the selected billing address
	$check_address_query = "SELECT count(*) AS total FROM " . TABLE_ADDRESS_BOOK . "
									WHERE customers_id = :customersID
									  AND address_book_id = :addressBookID";

	$check_address_query = $db->bindVars($check_address_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$check_address_query = $db->bindVars($check_address_query, ':addressBookID', $_SESSION['billto'], 'integer');
	$check_address = $db->Execute($check_address_query);

	if ($check_address->fields['total'] != '1') {
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		$_SESSION['payment'] = '';
	}
}

function calc_order_amount_payment($amount, $paypalCurrency, $applyFormatting = true) {
	global $currencies;
	$amount = ($amount) * $currencies->get_value($paypalCurrency);
	return ($applyFormatting ? round($amount, $currencies->get_decimal_places($paypalCurrency)) : $amount);
}

if (isset($_SESSION['paypal_ec_token']) && $_SESSION['paypal_ec_token'] != '' && $_SESSION['paypal_ec_step']) {
	unset($_SESSION['paypal_ec_step']);
	if($order->info['total'] > 0){
		$_SESSION['paid_by_ec'] = true;
		zen_redirect(zen_href_link('ipn_main_handler.php', 'type=ec', 'SSL', true, true, true));exit;
	}else{
		unset($_SESSION['paypal_ec_temp']);
	
		unset($_SESSION['paypal_ec_token']);
	
		unset($_SESSION['paypal_ec_payer_id']);
	
		unset($_SESSION['paypal_ec_payer_info']);
	}
	
}

$comments = $_SESSION['comments'];
$total_weight = $_SESSION['cart']->show_weight();
$total_count = $products_array['count'];

require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']['code']);

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (isset($_GET['payment_error']) && is_object(${$_GET['payment_error']}) && ($error = ${$_GET['payment_error']}->get_error())) {
	$messageStack->add('checkout_payment', $error['error'], 'error');
}

if(!empty($paypal_payment_message)) {
	$messageStack->add('checkout_payment', $paypal_payment_message, 'error');
}

/**
* about smarty
*/
if(!$_SESSION['order_number_created'] && isset($_SESSION['shipping'])){
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE');
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_AFTER_ORDER_CREATE');
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE_ADD_PRODUCTS');
	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_SEND_ORDER_EMAIL');
}

require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment;
$payment_selection = $payment_modules->selection();

$order_total = 0;
$order_totals_arr = array();
for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
	$order_totals_arr[$order->totals[$i]['class']] = $order->totals[$i];
	if (is_int(stripos($order->totals[$i]['text'], "-")) && $order->totals[$i]['class'] != 'ot_cash_account') {
		$order_total = $order_total - $order->totals[$i]['value'];
	} else if ($order->totals[$i]['class'] != 'ot_cash_account') {
		$order_total = $order_total + $order->totals[$i]['value'];
	}
}
$order_total = $currencies->format($order_total, true, $order->info['currency'], $order->info['currency_value']);

$message['order_total_no_currency_left'] = $order_totals_arr['ot_total']['value'];
$message['order_total_wire_min'] = ORDER_TOTAL_WIRE_MIN;

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
/*
$show_gc_payment = false;
if(isset($order->delivery['country'])){
			$countries = $db->Execute("select c.countries_id from ".TABLE_CUSTOMERS_GC_COUNTRY." cw ,".TABLE_COUNTRIES." c where c.countries_id = cw.countries_id and c.countries_name = '".trim($order->delivery['country'])."'");
			 if($countries->RecordCount() > 0){
				$gc_payment_customers = $db->Execute("select c.customers_id,c.customers_email_address,cw.create_time,operator from ".TABLE_CUSTOMERS_GC." cw ,".TABLE_CUSTOMERS." c where c.customers_id = cw.customers_id and  cw.customers_id = " . (int)$_SESSION['customer_id'] . "");
				if($gc_payment_customers->RecordCount() > 0){
					$show_gc_payment = true;
				}
			 }else{
				$show_gc_payment = true;
			 }
}
*/
$show_gc_payment = true;
$message["show_gc_payment"] = $show_gc_payment;
//	blance pay
$message['payment_pay_for_this_order_show'] = sprintf(TEXT_PAY_FOR_THIS_ORDER, '<span class="font_red">' . $currencies->format($order_totals_arr['ot_cash_account']['value'], true, $order->info['currency'], $order->info['currency_value']) . '</span>');
$message['payment_pay_for_this_order_left'] = sprintf(TEXT_PAY_FOR_THIS_ORDER_TOTAL, '<strong class="font_red">' . $currencies->format($order_totals_arr['ot_total']['value'], true, $order->info['currency'], $order->info['currency_value']) . '</strong>');
//	order total
$message['payment_order_total'] = $currencies->format($order_totals_arr['ot_cash_account']['value'] + $order_totals_arr['ot_total']['value'], true, $order->info['currency'], $order->info['currency_value']);
//	bank account info
$message['westernunion'] = $GLOBALS['westernunion']->confirmation();

if($order_totals_arr['ot_subtotal']['value'] < ORDER_TOTAL_WIRE_MIN){
	foreach($payment_selection as $payment_selection_k=>$payment_selection_v){
		if($payment_selection_v['id'] == 'wirebc' || $payment_selection_v['id'] == 'wire')
			unset($payment_selection[$payment_selection_k]);
	}
//	sort($payment_selection);
}else{
	$message['wirebc'] = $GLOBALS['wirebc']->confirmation();
	$message['wire'] = $GLOBALS['wire']->confirmation();
}

$message['moneygram'] = $GLOBALS['moneygram']->confirmation();

if ($messageStack->size('checkout_payment') > 0) {
	 $message['checkout_payment_size'] = $messageStack->size('checkout_payment');
	 ob_start();
	 $messageStack->output('checkout_payment');
	 $checkout_payment_content = ob_get_contents();
	 $checkout_payment_content = strip_tags($checkout_payment_content, '<a> <span> <br> <br/>');
	 ob_end_clean();
	 $message['checkout_payment'] = $checkout_payment_content;
}

//	use blance
$use_all_cash = false;
if (isset($_SESSION['order_number_created']) && $_SESSION['order_number_created'] != '') {
	 $message['order_number_created'] = $_SESSION['order_number_created'];
	 if ($order_totals_arr['ot_cash_account']['value'] > 0 && $order_totals_arr['ot_total']['value'] == 0) {
		  $sql_data_array = array('payment_method' => 'Credit Balance',
				'payment_module_code' => 'Credit Balane');
		  zen_db_perform(TABLE_ORDERS, $sql_data_array, 'update', "orders_id = '" . (int) $_SESSION['order_number_created'] . "'");
		  $use_all_cash = true;
	 }
}

//	bof. check if already make payment, then redirect to success page
$order_query = "select  orders_status
                        from " . TABLE_ORDERS . "
                        where orders_id = '" . (int)$_SESSION['order_number_created'] . "' limit 1";
$orders_status = $db->Execute($order_query);
if($orders_status->fields['orders_status'] > 1 && !$use_all_cash)
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
//	eof

$message['payment_submit'] = zen_href_link(FILENAME_CHECKOUT_CONFIRMATION,'','SSL');
$message['payment_submit_succ'] = zen_href_link(FILENAME_CHECKOUT_SUCCESS,'','SSL');
$default_payment = zen_customer_preorder_payment();
if(! $default_payment || $default_payment == 'Credit Balane' || $default_payment == 'gcCreditCard' || $default_payment == '/') $default_payment = 'paypalwpp';

/*WSL 2015-06-16*/
if ($order_totals_arr['ot_total']['value'] < ORDER_TOTAL_WIRE_MIN && ($default_payment == 'wire' || $default_payment== 'wirebc')){
	$default_payment = 'paypalwpp';
}


$smarty->assign('default_payment', $default_payment);
$use_new_template = true;

if ($order_totals_arr['ot_cash_account']['value'] > 0) {
	 $order_totals_arr['ot_cash_account']['text'] = str_replace('-', '', $currencies->format($order_totals_arr['ot_cash_account']['value']));
}
if ($order_totals_arr['ot_cash_account']['value'] < 0) {
	 $order_totals_arr['ot_cash_account']['text'] = '- ' . $order_totals_arr['ot_cash_account']['text'];
}
if ($order->info ['currency'] == 'JPY') {
	$smarty->assign ( 'price', floor ( round ( $order->info ['total'] * $order->info ['currency_value'], 2 ) ) );
} else {
	$smarty->assign ( 'price', round ( $order->info ['total'] * $order->info ['currency_value'], 2 ) );
}
$sqlOrderInfo = "SELECT c.countries_iso_code_2,o.delivery_name,o.delivery_street_address,o.delivery_state,o.delivery_postcode FROM ".
        TABLE_ORDERS ." o JOIN ".TABLE_COUNTRIES." c ON o.delivery_country = c.countries_name WHERE orders_id = ".$_SESSION['order_number_created'];
$shippingAddressInfo = $db->Execute($sqlOrderInfo);
while (!$shippingAddressInfo->EOF) {
    $nameFull = explode(" ",$shippingAddressInfo->fields['delivery_name']);
    $order->customer['shippingFirstName'] = $nameFull[1];
    $order->customer['shippingLastName'] = $nameFull[0];
    $order->customer['shippingStreet'] = $shippingAddressInfo->fields['delivery_street_address'];
    $order->customer['shippingState'] = $shippingAddressInfo->fields['delivery_state'];
    $order->customer['shippinCountryCode'] = $shippingAddressInfo->fields['countries_iso_code_2'];
    $order->customer['shippinZip'] = $shippingAddressInfo->fields['delivery_postcode'];
    $shippingAddressInfo->MoveNext();
}

$codeInfo = $db->Execute("SELECT c.customers_firstname, c.customers_lastname, ct.countries_iso_code_2, l.code FROM ".TABLE_CUSTOMERS ." c JOIN ".TABLE_COUNTRIES." ct ON c.customers_country_id = ct.countries_id JOIN ".TABLE_LANGUAGES." l ON c.register_languages_id = l.languages_id WHERE c.customers_email_address = '".$order->customer['email_address']."' LIMIT 1");
$order->customer['lanuageCode'] = 'en';
while (!$codeInfo->EOF) {
    $order->customer['lanuageCode'] = $codeInfo->fields['code'];
    //$order->customer['countryCode'] = $codeInfo->fields['countries_iso_code_2'];
    $order->customer['firstName'] = $codeInfo->fields['customers_firstname'];
    $order->customer['lastName'] = $codeInfo->fields['customers_lastname'];
    $codeInfo->MoveNext();
}
$order->customer['countryCode'] = $order->customer['shippinCountryCode'];
/*fix order_total*/

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
//$credit_account_code = $_SESSION['currency'];

$cash_account_remaining_total = $order_totals_arr['ot_cash_account']['value']+$cash_account_remaining_total;
$cash_account_remaining_total = $currencies->format($cash_account_remaining_total, true, $order->info['currency']);
$smarty->assign('cash_account_remaining_total',$cash_account_remaining_total);
/*end*/
$smarty->assign('countryCode', $order->customer['countryCode']);
$smarty->assign('lanuageCode', $order->customer['lanuageCode']);
$smarty->assign('currencyCode', $order->info['currency']);
$smarty->assign('orderId', date("yW"));
$smarty->assign('paymentOrderId', $_SESSION['order_number_created']);
$smarty->assign('lastName', $order->customer['lastName']);
$smarty->assign('firstName', substr($order->customer['firstName'],0,15));
$smarty->assign('shippingFirstName', substr($order->customer['shippingFirstName'],0,15));
$smarty->assign('shippingLastName', $order->customer['shippingLastName']);
$smarty->assign('shippingStreet', substr($order->customer['shippingStreet'],0,50));
$smarty->assign('shippinCountryCode', $order->customer['shippinCountryCode']);
$smarty->assign('shippingState', $order->delivery['state']);
$smarty->assign('shippinZip', $order->customer['shippinZip']);
$smarty->assign('merchantRef', $_SESSION['order_number_created']);
$smarty->assign('shippingCity', $order->delivery['city']);
$smarty->assign('phoneNumber', $order->customer['telephone']);
$smarty->assign('email', $order->customer['email_address']);
$smarty->assign('city', $order->customer['city']);
$smarty->assign('state', $order->customer['state']);
$smarty->assign('street', substr($order->customer['street_address'],0,50));
$smarty->assign('type', 'dp');
$smarty->assign('order_total', $order_total);
$smarty->assign('order_totals_arr', $order_totals_arr);
//print_r($order_totals_arr);
$smarty->assign('javascript_validation', $payment_modules->javascript_validation());
$smarty->assign('message', $message);
$smarty->assign('payment_selection', $payment_selection);
$smarty->caching = 0;

$zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_PAYMENT');
?>