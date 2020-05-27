<?php
if (! $_SESSION ['customer_id']) {
	zen_redirect ( zen_href_link ( FILENAME_TIME_OUT ) );
}

$notify_string = '';
if (isset ( $_GET ['action'] ) && ($_GET ['action'] == 'update')) {
	$notify_string = 'action=notify&';
	$notify = $_POST ['notify'];

	if (is_array ( $notify )) {
		for($i = 0, $n = sizeof ( $notify ); $i < $n; $i ++) {
			$notify_string .= 'notify[]=' . $notify [$i] . '&';
		}
		if (strlen ( $notify_string ) > 0)
			$notify_string = substr ( $notify_string, 0, - 1 );
	}
	if ($notify_string == 'action=notify&') {
		zen_redirect ( zen_href_link ( FILENAME_CHECKOUT_SUCCESS, '', 'SSL' ) );
	} else {
		zen_redirect ( zen_href_link ( FILENAME_DEFAULT, $notify_string ) );
	}
}

require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/checkout_success.php');
require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/account_history_info.php');

$orders_query = "SELECT * FROM " . TABLE_ORDERS . " WHERE customers_id = :customersID ORDER BY date_purchased DESC LIMIT 1";
$orders_query = $db->bindVars ( $orders_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
$orders = $db->Execute ( $orders_query );
$orders_id = $orders->fields ['orders_id'];
$ls_payment_module = $orders->fields ['payment_module_code'];

if (isset($_GET['order_id']) && $_GET['order_id'] != '') {
	$orders_id = $_GET['order_id'];
}
$zv_orders_id = (isset ( $_SESSION ['order_number_created'] ) && $_SESSION ['order_number_created'] >= 1) ? $_SESSION ['order_number_created'] : $orders_id;
$orders_id = $zv_orders_id;
unset ( $_SESSION ['order_number_created'] );

$global_query = "SELECT global_product_notifications FROM " . TABLE_CUSTOMERS_INFO . " WHERE customers_info_id = :customersID";

$global_query = $db->bindVars ( $global_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
$global = $db->Execute ( $global_query );
$flag_global_notifications = $global->fields ['global_product_notifications'];

if ($flag_global_notifications != '1') {
	$products_array = array ();
	$counter = 0;
	$products_query = "SELECT products_id, products_name FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id = :ordersID ORDER BY products_name";
	$products_query = $db->bindVars ( $products_query, ':ordersID', $orders_id, 'integer' );
	$products = $db->Execute ( $products_query );

	while ( ! $products->EOF ) {
		$notificationsArray [] = array (
				'counter' => $counter,
				'products_id' => $products->fields ['products_id'],
				'products_name' => $products->fields ['products_name']
		);
		$counter ++;
		$products->MoveNext ();
	}
}

$flag_show_products_notification = (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1' and sizeof ( $notificationsArray ) > 0 and $flag_global_notifications != '1') ? true : false;

$gv_query = "SELECT amount FROM " . TABLE_COUPON_GV_CUSTOMER . " WHERE customer_id = :customersID ";
$gv_query = $db->bindVars ( $gv_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
$gv_result = $db->Execute ( $gv_query );
if ($gv_result->fields ['amount'] > 0) {
	$customer_has_gv_balance = true;
	$customer_gv_balance = $currencies->format ( $gv_result->fields ['amount'] );
}
$define_page = zen_get_file_directory ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/html_includes/', FILENAME_DEFINE_CHECKOUT_SUCCESS, 'false' );

$_SESSION ['reset_shipping_fee'] = 'false';
require (DIR_WS_CLASSES . 'order.php');
$order = new order ( $orders_id );

$use_all_balance = false;
if ((int)$order->info['total'] == 0 && $order->info['payment_module_code'] == 'Credit Balane') {
	$use_all_balance = true;
}

/*$get_vip_amount_sql = "select value from " . TABLE_ORDERS_TOTAL . " where class='ot_group_pricing' and orders_id = " . $orders_id;
$get_vip_amount = $db->Execute ( $get_vip_amount_sql );var_dump($get_vip_amount->fields);
if ($get_vip_amount->RecordCount () > 0) {
	$get_sub_total_sql = "select value from " . TABLE_ORDERS_TOTAL . " where class='ot_subtotal' and orders_id = " . $orders_id;
	$get_sub_total = $db->Execute ( $get_sub_total_sql );var_dump($get_vip_amount->fields ['value'] / $get_sub_total->fields ['value']);
	$vip_discount = "(" . (round ( $get_vip_amount->fields ['value'] / $get_sub_total->fields ['value'] * 100, 2 ) ) . "% ".TEXT_DISCOUNT_OFF.")";echo $vip_discount;
} else {
	$vip_discount = "";
}*/

for($i = 0, $n = sizeof ( $order->totals ); $i < $n; $i ++) {
	$str .= '<tr>' . "\n";
	if ($order->totals [$i] ['class'] == 'ot_total') {
		$title = ' <th>' . TABLE_HEADING_TOTAL . ':</th>';
		$str .= $title . ' <td class="total_pice price_color">' . $order->totals [$i] ['text'] . '</td>';
		if (!$use_all_balance) {
			$order_total_text = $order->totals [$i] ['text'];
			$order_total_value = $order->totals [$i] ['value'];
		}		
	} else {
		if ($order->totals [$i] ['class'] == 'ot_subtotal') {
			$order->totals [$i] ['title'] = TEXT_CART_TOTAL_PRODUCT_PRICE . ':';
			$order->totals [$i] ['text'] = $currencies->format ( $order->totals [$i] ['value'], true, $order->info ['currency'] );
		}
		if ($order->totals [$i] ['class'] == 'ot_shipping') {
			$order->totals [$i] ['title'] = TEXT_SHIPPING_CHARGE;
		}
		if ($order->totals [$i] ['class'] == 'ot_coupon') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_coupon.php');
			$title_discoupon = $order->totals [$i] ['title'];
			$first_order = false;
			if (in_array ( preg_replace ( "/(\s|\&nbsp\;|　|\xc2\xa0)/", "", $title_discoupon ), array (
					'NewCustomerCoupon:',
					'RabattderersteBestellung:',
					'Скидкадляпервогозаказа:',
					'Discountde1èrecommande:'
			) )) {
				$first_order = true;
				$order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_COUPON_TITLE_FIRST . ':';
			} else {
				$order->totals [$i] ['title'] = 'RCD <span class="grey_9">(3% '.TEXT_DISCOUNT_OFF.' )</span>:';
			}
		}
		if ($order->totals [$i] ['class'] == 'ot_cash_account') {
			$order->totals [$i] ['title'] = TEXT_CREDIT_BALANCE;
			if ($use_all_balance) {
				$order_total_text = trim($order->totals [$i] ['text'], '-');
				$order_total_value = $order->totals [$i] ['value'];
			}
		}
		if ($order->totals [$i] ['class'] == 'ot_promotion') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_promotion.php');
			$order->totals [$i] ['title'] = TEXT_PROMOTION_DISCOUNT;
		}
		if ($order->totals [$i] ['class'] == 'ot_group_pricing') {
			$order->totals [$i] ['title'] = TEXT_CART_VIP_DISCOUNT;
		}
		if (substr ( $order->totals [$i] ['text'], 0, 1 ) == '-') {
			if ($order->totals [$i] ['class'] == 'ot_group_pricing') {
				$text = ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>';
			} else {
				$text = ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>';
			}
			if ($order->totals [$i] ['class'] == 'ot_coupon' && ! $first_order) {
				$text = ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 )  . '</td>';
			} else {
				$text = ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>';
			}
		} else {
			$text = ' <td class="total_pice price_color">' . $order->totals [$i] ['text'] . '</td>';
		}
		$str .= ' <th>' . $order->totals [$i] ['title'] . '</th>' . $text;
	}
}

if($use_all_balance){
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
	$balance_total = $cash_account_remaining_total + $order_total_value;
}
$order_query = "select orders_status,order_total from " . TABLE_ORDERS . " where orders_id = '" . ( int ) $orders_id . "' limit 1";
$orders_status = $db->Execute ( $order_query );

$message = array();
$message['use_all_balance'] = $use_all_balance;
$message['balance_remain'] = $currencies->format($cash_account_remaining_total, true, $order->info['currency'], $order->info['currency_value']);
$message['balance_total'] = $currencies->format($balance_total, true, $order->info['currency'], $order->info['currency_value']);
$message['balance_use'] = sprintf(TEXT_BALANCE_USE_FOR_ORDER, $currencies->format($order_total_value, true, $order->info['currency'], $order->info['currency_value']));
$message['success_date'] = date('M d, Y',strtotime(date('Y-m-d')));
$message['success_orders_id'] = $orders_id;
$message['success_order_number'] = TEXT_SUCC_ORDER_NUMBER;
$message['success_payment_method'] = TEXT_SUCC_PAYMENT_METHOD;
$message['success_payment_method_text'] = $order->info['payment_method'];
$message['success_shipping_method_text'] = $order->info['shipping_method'];
$message['success_order_status'] = $orders_status->fields ['orders_status'];
$message['success_order_total_text'] = $order_total_text;

if((isset($_SESSION['is_old_customers']) && $_SESSION['is_old_customers'] == 0 ) && in_array($orders_status->fields['orders_status'], explode(',', MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP))){
    $db->Execute('update ' . TABLE_CUSTOMERS . ' set is_old_customers = 1 where customers_id= "' . $_SESSION['customer_id'] . '"' );
}

if ($orders_status->fields ['orders_status'] == 2 || $orders_status->fields ['orders_status'] == 42) {
	$message ['success_successfully'] = TEXT_USE_ALL_BALANCE_SUCCESSFULLY;
	if (date ( 'Y-m-d H:i:s' ) < '2014-04-24 16:00:00') {
		$coupon_code = '';
		if ($orders_status->fields ['order_total'] > 99 && $orders_status->fields ['order_total'] < 999) {
			$coupon_code = 'CP2014040901';
		} elseif ($orders_status->fields ['order_total'] > 999 && $orders_status->fields ['order_total'] < 1999) {
			$coupon_code = 'CP2014040902';
		} elseif ($orders_status->fields ['order_total'] > 1999) {
			$coupon_code = 'CP2014040903';
		}
		if ($coupon_code != '') {
			$sql_coupon = 'select coupon_id,coupon_amount from  ' . TABLE_COUPONS . '  where coupon_code = "' . $coupon_code . '" limit 1';
			$result_coupon = $db->Execute ( $sql_coupon );
			if ($result_coupon->RecordCount () > 0) {
				$order_coupon = $db->Execute ( "select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where cc_orders_id = " . ( int ) $orders_id . " and cc_customers_id =  " . $_SESSION ['customer_id'] . " and cc_coupon_id = " . $result_coupon->fields ['coupon_id'] . " limit 1" );
				if ($order_coupon->RecordCount () == 0) {
					$db->Execute ( "INSERT INTO  " . TABLE_COUPON_CUSTOMER . " (`cc_coupon_id` ,`cc_customers_id` ,`cc_amount`,`cc_orders_id`,`cc_coupon_status`,`date_created`)VALUES (" . $result_coupon->fields ['coupon_id'] . ",  " . $_SESSION ['customer_id'] . ",  '', " . ( int ) $orders_id . ", 10, now());" );
				}
			}
			$message ['set_coupon'] .= sprintf ( TEXT_SET_COUPON, '$' . ( int ) $result_coupon->fields ['coupon_amount'] );
		}
	}
	
	//	20150422 xiaoyong.lv
	if($orders_status->fields['orders_status'] == 2){
		$send_res = present_promotion_coupon($orders_id);
		if($send_res>0){
			$message['success_successfully'] .= '<br/>'.sprintf(TEXT_PRESENT_COUPON, $order->info['currency'].' '.$currencies->format_number($send_res, false, $order->info['currency']));
		}
	}

	//	invite frineds 20150422 xiaoyong.lv
	$fun_inviteFriends->sendCoupon($orders_id);
} else {
	$message ['success_successfully'] = TEXT_SUCC_THANK_PAYMENT . '<strong>' . $message ['success_payment_method_text'] . '</strong>';
}

$order->delivery ['telephone_number'] = $order->customer ['telephone'];

$statuses_query = "SELECT os.orders_status_name, osh.date_added, osh.comments
                   FROM " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh
                   WHERE osh.orders_id = :ordersID
                   AND os.language_id = " . $_SESSION ['languages_id'] . "
                   AND osh.orders_status_id = os.orders_status_id
                   AND osh.orders_status_id = 1
                   ORDER BY osh.date_added";

$statuses_query = $db->bindVars ( $statuses_query, ':ordersID', ( int ) $orders_id, 'integer' );
$statuses = $db->Execute ( $statuses_query );
$message ['order_comments'] = '';
while ( ! $statuses->EOF ) {
	$statuses->fields ['comments'] = str_replace("#D5#",TEXT_REORDER_PACKING_WAY_ONE.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#BD#",TEXT_REORDER_PACKING_WAY_TWO.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#D15#",TEXT_REORDER_PACKING_WAY_THREE.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#D#",TEXT_REORDER_PACKING_WAY_FOUR.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#15FA#",TEXT_REORDER_PACKING_WAY_FIVE.'<br/>',$statuses->fields ['comments']);
	$message ['order_comments'] .= nl2br ( $statuses->fields ['comments'] );
	$statuses->MoveNext ();
}

$message['success_invoice_value'] = TEXT_SUCC_INVOICE_VALUE;
$message['success_invoice_shipping_fee'] = TEXT_SUCC_INVOICE_SHIPPING_FEE;
$message['success_invoice_item_description'] = TEXT_SUCC_ITEM_DESCRIPTION;
$message['success_shipping_address'] = TEXT_SHIPPING_ADDRESS;
$message['success_order_cumments'] = TEXT_ORDER_COMMONTS;
$message['success_order_details'] = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, 'SSL');
$message['success_order_shipping_address'] = zen_address_format_order($order->delivery['format_id'], $order->delivery, 1, '', '&nbsp;', true);
$message['success_order_total'] = $str;
$message['success_view_invoice'] = TEXT_ORDER_DETAIL;
$message['success_unpaid'] = TEXT_SUCC_UNPAID;
$message['success_shipping_invoece_comments'] = TEXT_SHIPPING_INVOECE_COMMENTS;
$message['success_you_ve_made_payment'] = TEXT_PAID;
$message['success_payment_under_checking'] = TEXT_PAYMENT_UNDER_CHECKING;
$message['success_shipping_method'] = TEXT_SHIPPING_METHOD;

require (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping ( $order->info ['shipping_module_code'] );
$time_unit = TEXT_DAYS_LAN;
if ($shipping_modules->shipping_method[$order->info['shipping_module_code']]['time_unit'] == 20) {
	$time_unit = TEXT_WORKDAYS;
}
$message ['shipping_days'] = $shipping_modules->shipping_method [$order->info ['shipping_module_code']] ['days'] . '&nbsp;' . $time_unit;

$smarty->assign ( 'order', $order );
$smarty->assign ( 'message', $message );
$tpl_head = DIR_WS_TEMPLATE_TPL . 'tpl_play_order_head.html';

$smarty->assign ( 'tpl_head', $tpl_head );
$smarty->caching = 0;
?>
