<?php
if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
$page_account = true;
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

if ($_POST ['orderfilter'] || $_GET ['orderfilter']) {
	if($_POST ['orderfilter']) $_GET ['orderfilter'] = zen_db_prepare_input($_POST ['orderfilter']);
	$filter_order_number_str = '';
	$filter_order_status_str = '';
	$filter_pronumber_str = '';
	$filter_pronumber_table_str = '';

	if (isset ( $_POST ['ordernumber'] ) && trim ( $_POST ['ordernumber'] ) != '') {
		$ordernumber = $db->prepare_input ( zen_db_prepare_input($_POST ['ordernumber']) );
		if ($ordernumber != '') {
			$filter_order_number_str = ' and o.orders_id = "' . $ordernumber . '" ';
		}
		$_GET ['ordernumber'] = $ordernumber;
	}else if (isset ( $_GET ['ordernumber'] ) && trim ( $_GET ['ordernumber'] ) != '') {
		$ordernumber = $db->prepare_input ( zen_db_prepare_input($_GET ['ordernumber']) );
		if ($ordernumber != '') {
			$filter_order_number_str = ' and o.orders_id = "' . $ordernumber . '" ';
		}
	}

	if (isset ( $_POST ['orderstatus'] ) && trim ( $_POST ['orderstatus'] ) != '') {
		$orderstatus = ( int ) $db->prepare_input ( zen_db_prepare_input($_POST ['orderstatus']) );
		if ($orderstatus != 99) {
			if ($orderstatus == 1) {
				$filter_order_status_str = ' and o.orders_status in( ' . $orderstatus . ' ,42)';
			} else {
				$filter_order_status_str = ' and o.orders_status = ' . $orderstatus . ' ';
			}
		}
		$_GET ['status_id'] = $orderstatus;
	}else if (isset ( $_GET ['status_id'] ) && trim ( $_GET ['status_id'] ) != '') {
		$orderstatus = ( int ) $db->prepare_input ( zen_db_prepare_input($_GET ['status_id']) );
		if ($orderstatus != 99) {
			if ($orderstatus == 1) {
				$filter_order_status_str = ' and o.orders_status in( ' . $orderstatus . ' ,42)';
			} else {
				$filter_order_status_str = ' and o.orders_status = ' . $orderstatus . ' ';
			}
		}
	}

	if (isset ( $_POST ['pronumber'] ) && trim ( $_POST ['pronumber'] ) != '') {
		$pronumber = $db->prepare_input ( zen_db_prepare_input($_POST ['pronumber']) );
		//$filter_pronumber_str = ' and o.orders_id = op.orders_id and op.products_model = "' . $pronumber . '" ';
		//$filter_pronumber_table_str = ', ' . TABLE_ORDERS_PRODUCTS . ' op';
		$_GET ['pronumber'] = $pronumber;
	}else if (isset ( $_GET ['pronumber'] ) && trim ( $_GET ['pronumber'] ) != '') {
		$pronumber = $db->prepare_input ( zen_db_prepare_input($_GET ['pronumber']) );
		//$filter_pronumber_str = ' and o.orders_id = op.orders_id and op.products_model = "' . $pronumber . '" ';
		//$filter_pronumber_table_str = ', ' . TABLE_ORDERS_PRODUCTS . ' op';
	}
	if($pronumber!=''){
		$check_product_id = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$pronumber."'");
		if($check_product_id->fields['products_id']>0){
			$filter_pronumber_str = ' and o.orders_id = op.orders_id and op.products_id = "'.$check_product_id->fields['products_id'].'" ';
			$filter_pronumber_table_str = ', '.TABLE_ORDERS_PRODUCTS.' op';
		}else{
			$filter_pronumber_str = ' and o.orders_id=0 ';
		}
	}
	if (isset ( $_POST ['datestart'] ) && trim ( $_POST ['datestart'] ) != '') {
		$datestart = substr ( zen_db_prepare_input($_POST ['datestart']), 0, 4 ) . '-' . substr ( zen_db_prepare_input($_POST ['datestart']), 5, 2 ) . '-' . substr ( zen_db_prepare_input($_POST ['datestart']), 8, 2 ) . ' 00:00:00';
		$filter_date_start = zen_db_prepare_input(trim ( $_POST ['datestart'] ));
		$_GET ['datestart'] = zen_db_prepare_input($_POST ['datestart']);
	}else if (isset ( $_GET ['datestart'] ) && trim ( $_GET ['datestart'] ) != '') {
		$datestart = substr ( zen_db_prepare_input($_GET ['datestart']), 0, 4 ) . '-' . substr ( zen_db_prepare_input($_GET ['datestart']), 5, 2 ) . '-' . substr ( zen_db_prepare_input($_GET ['datestart']), 8, 2 ) . ' 00:00:00';
		$filter_date_start = zen_db_prepare_input(trim ( $_GET ['datestart'] ));
	}
	if (isset ( $_POST ['dateend'] ) && trim ( $_POST ['dateend'] ) != '') {
		$dateend = substr ( zen_db_prepare_input($_POST ['dateend']), 0, 4 ) . '-' . substr ( zen_db_prepare_input($_POST ['dateend']), 5, 2 ) . '-' . substr ( zen_db_prepare_input($_POST ['dateend']), 8, 2 ) . ' 23:59:59';
		$filter_date_end = zen_db_prepare_input(trim ( $_POST ['dateend'] ));
		$_GET ['dateend'] = zen_db_prepare_input($_POST ['dateend']);
	}else if (isset ( $_GET ['dateend'] ) && trim ( $_GET ['dateend'] ) != '') {
		$dateend = substr ( zen_db_prepare_input($_GET ['dateend']), 0, 4 ) . '-' . substr ( zen_db_prepare_input($_GET ['dateend']), 5, 2 ) . '-' . substr ( zen_db_prepare_input($_GET ['dateend']), 8, 2 ) . ' 23:59:59';
		$filter_date_end = zen_db_prepare_input(trim ( $_GET ['dateend'] ));
	}

	if (isset ( $datestart ) && $datestart != '') {
		$filter_date_str = ' and o.date_purchased > "' . $datestart . '" ';
	}
	if (isset ( $dateend ) && $dateend != '') {
		$filter_date_str = ' and o.date_purchased < "' . $dateend . '" ';
	}
	if ((isset ( $datestart ) && $datestart != '') && (isset ( $dateend ) && $dateend != '')) {
		$filter_date_str = ' and o.date_purchased > "' . $datestart . '" and  o.date_purchased < "' . $dateend . '"';
	}
	$orders_query = "SELECT o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name,o.orders_status,o.shipping_num
                 FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s " . $filter_pronumber_table_str . "
                 WHERE  o.customers_id = :customersID
                 AND    o.orders_id = ot.orders_id
                 AND    ot.class = 'ot_total'
                 AND    o.orders_status = s.orders_status_id
                 AND   s.language_id = :languagesID
				  " . $filter_pronumber_str . "
				  " . $filter_order_status_str . "  and  o.orders_status != 5
				  " . $filter_order_number_str . "
				  " . $filter_date_str . "
				  group by o.orders_id
                  order by o.orders_id DESC";
	$orders_query = $db->bindVars ( $orders_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
	$orders_query = $db->bindVars ( $orders_query, ':languagesID', $_SESSION ['languages_id'], 'integer' );
	// echo $orders_query;exit;
	$history_split = new splitPageResults ( $orders_query, MAX_DISPLAY_ORDER_HISTORY, 'o.orders_id' );
} else {
	$filter_order_status_str = '';
	if (isset ( $_GET ['status_id'] ) && trim ( $_GET ['status_id'] ) != '') {
		$status_id = ( int ) $_GET ['status_id'];
		if ($status_id != 99) {
			if ($status_id == 1) {
				$filter_order_status_str = ' and o.orders_status in( ' . $status_id . ' ,42)';
			} else {
				$filter_order_status_str = ' and o.orders_status = ' . $status_id . ' ';
			}
		}
		$_GET ['status_id'] = $status_id;
	}
	$orders_query = "SELECT o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name,o.orders_status,o.shipping_num
					 FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s
					 WHERE  o.customers_id = :customersID
					 AND    o.orders_id = ot.orders_id
					 AND    ot.class = 'ot_total'
					 AND    o.orders_status = s.orders_status_id
					  " . $filter_order_status_str . "  and  o.orders_status != 5
					 AND   s.language_id = :languagesID
					  order by o.orders_id DESC";
	
	$orders_query = $db->bindVars ( $orders_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
	$orders_query = $db->bindVars ( $orders_query, ':languagesID', $_SESSION ['languages_id'], 'integer' );
	// echo $orders_query;exit;
	$history_split = new splitPageResults ( $orders_query, MAX_DISPLAY_ORDER_HISTORY, 'o.orders_id' );
}

$status_id = ( int ) $_GET ['status_id'];
if (! isset ( $_GET ['status_id'] )) {
	$status_id = 1;
}
$breadcrumb->add ( NAVBAR_TITLE, zen_href_link ( FILENAME_MYACCOUNT ,'','SSL') );
if (isset ( $_GET ['status_id'] )) {
	if ($status_id == 1 || $status_id == 42) {
		$orders_status_title = TEXT_ORDER_STATUS_PENDING;
		$breadcrumb->add ( TEXT_ORDER_STATUS_PENDING );
	} else if ($status_id == 2) {
		$orders_status_title = TEXT_ORDER_STATUS_PROCESSING;
		$breadcrumb->add ( TEXT_ORDER_STATUS_PROCESSING );
	} else if ($status_id == 3) {
		$orders_status_title = TEXT_ORDER_STATUS_SHIPPED;
		$breadcrumb->add ( TEXT_ORDER_STATUS_SHIPPED );
	} else if ($status_id == 4) {
		$orders_status_title = TEXT_ORDER_STATUS_UPDATE;
		$breadcrumb->add ( TEXT_ORDER_STATUS_UPDATE );
	} else if ($status_id == 10) {
		$orders_status_title = TEXT_DELIVERED;
		$breadcrumb->add ( TEXT_DELIVERED );
	}else if ($status_id == 0) {
		$orders_status_title = TEXT_ORDER_CANCELED;
		$breadcrumb->add ( TEXT_ORDER_CANCELED );
	}
} else {
	$breadcrumb->add ( TEXT_ALL_ORDERS );
}

$order = $db->Execute ( $history_split->sql_query );
$ordersArray = array ();
$i = 0;
while ( ! $order->EOF ) {
	$show_payment = 0;
	$payment_records = $db->Execute ( "select payment_records_id from " . TABLE_PAYMENT_RECORDS . " where orders_id = '" . $order->fields ['orders_id'] . "'" );
	if ($payment_records->RecordCount () > 0) {
		$show_payment = $payment_records->RecordCount ();
	}
	if ($order->fields ['orders_status'] == 42) {
		$orders_status_query = "SELECT  s.orders_status_name
					 FROM   " . TABLE_ORDERS_STATUS . " s
					 WHERE  s.language_id = :languagesID
					 and orders_status_id = 1";
		
		$orders_status_query = $db->bindVars ( $orders_status_query, ':languagesID', $_SESSION ['languages_id'], 'integer' );
		$order_status_shipped = $db->Execute ( $orders_status_query );
		$order->fields ['orders_status_name'] = $order_status_shipped->fields ['orders_status_name'];
	}
	
	$orders_tracking_flag = false;
// 	if(in_array($order->fields['orders_status'], explode(',', MODULE_ORDER_SHIPPED_DELIVERED_STATUS_ID_GROUP))){
		if($order->fields['shipping_num'] != '' && $order->fields['shipping_num'] != ','){
			$orders_tracking_flag = true;
		}
// 	}
	
	$ordersArray [$i] = array (
			'orders_id' => $order->fields ['orders_id'],
			'date_purchased' => date ( 'M j, Y', strtotime ( $order->fields ['date_purchased'] ) ),
			'order_total' => $order->fields ['order_total'],
			'orders_status_name' => $order->fields ['orders_status_name'],
			'orders_status' => $order->fields ['orders_status'],
			'show_payment' => $show_payment,
			'orders_products_id' => $orders_products->fields ['products_id'],
			'show_track_info' => $orders_tracking_flag
	);
	$i ++;
	$order->MoveNext ();
}
switch (( int ) $_GET ['status_id']) {
	case 1 :
	case 42:
		$message ['account_status_text'] = TEXT_ORDER_STATUS_PENDING;
		break;
	case 2 :
		$message ['account_status_text'] = TEXT_ORDER_STATUS_PROCESSING;
		break;
	case 3 :
		$message ['account_status_text'] = TEXT_ORDER_STATUS_SHIPPED;
		break;
	case 4 :
		$message ['account_status_text'] = TEXT_ORDER_STATUS_UPDATE;
		break;
	case 10 :
		$message ['account_status_text'] = TEXT_DELIVERED;
		break;
	default :
		$message ['account_status_text'] = TEXT_ALL_ORDERS;
		break;
}
if (isset ( $_GET ['status_id'] ) && ( int ) $_GET ['status_id'] === 0) {
	$message ['account_status_text'] = TEXT_ORDER_CANCELED;
}

$message ['account_text_all_orders'] = TEXT_ALL_ORDERS;
$message ['account_text_pendding'] = TEXT_ORDER_STATUS_PENDING;
$message ['account_text_processing'] = TEXT_ORDER_STATUS_PROCESSING;
$message ['account_text_shipped'] = TEXT_ORDER_STATUS_SHIPPED;
$message ['account_text_update'] = TEXT_ORDER_STATUS_UPDATE;
$message['account_text_delivered'] = TEXT_DELIVERED;
$message ['account_text_canceled'] = TEXT_ORDER_CANCELED;
$message ['account_text_transactions'] = TEXT_TRANSACTIONS;
$message ['account_text_account_service'] = TEXT_ACCOUNT_SERVICE;
$message ['account_text_address_book'] = TEXT_ADDRESS_BOOK;
$message ['account_text_account_setting'] = TEXT_ACCOUNT_SETTING;
$message ['account_text_my_coupon'] = TEXT_MY_COUPON;
$message ['account_text_cash_acount'] = TEXT_CASH_ACOUNT;
$message ['account_text_blance'] = TEXT_BLANCE;
$message ['account_text_email_notificatons'] = TEXT_EMAIL_NOTIFICATIONS;
$message ['account_text_modify_subscrition'] = TEXT_MODIFY_SUBSCRITION;
$message ['account_text_products_notification'] = TEXT_PRODUCTS_NOTIFICATION;
$message ['account_text_http_server'] = HTTP_SERVER;
$message ['account_text_products_order_by_no'] = PRODUCTS_QUICK_ORDER_BY_NO;
$message ['account_text_order_number'] = TABLE_HEADING_ORDER_NUMBER;
$message ['account_text_status'] = TABLE_HEADING_STATUS;
$message ['account_text_date'] = TABLE_HEADING_DATE;
$message ['account_text_pro_number'] = TEXT_MODEL;
$message ['account_text_filter'] = TEXT_FILTER;
$message ['account_text_total'] = TABLE_HEADING_TOTAL;
$message ['account_text_action'] = TEXT_ACTION;
$message ['account_product_details'] = TEXT_PRODUCT_DETAILS;
$message ['account_make_payment'] = TEXT_MAKE_PAYMENT;
$message ['payment_quick_peorder'] = TEXT_PAYMENT_QUICK_PEORDER;
$message ['account_text_result_page'] = TEXT_RESULT_PAGE . ' ' . $history_split->display_links_new ( MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params ( array ( 'page', 'info', 'x', 'y',	'main_page' ) ) );
$message ['account_payment_order_inquiry'] = TEXT_PAYMENT_ORDER_INQUIRY;
$message ['account_view_invoice'] = TEXT_VIEW_INVOICE;
$message ['account_text_to'] = TEXT_TO;
$message ['account_text_filter'] = TEXT_SUBMIT;
$message ['account_text_view_details'] = TEXT_VIEW_DETAILS;
$message ['account_text_no_order'] = TEXT_ORDER_NO_EXISTS;
$message['account_packing_slip'] = HEADER_TITLE_PACKING_SLIP;

$filter ['filter_ordernumber'] = $ordernumber;
$filter ['filter_pronumber'] = $pronumber;
$filter ['filter_languages_code'] = $_SESSION ['languages_code'];
$filter ['filter_date_start'] = $filter_date_start;
$filter ['filter_date_end'] = $filter_date_end;
$message ['status_id'] = $_GET ['status_id'];
$use_new_template = true; // new templates for smarty
$account = true;
$smarty->assign ( 'message', $message );
$smarty->assign ( 'filter', $filter );
$smarty->assign ( 'ordersarray', $ordersArray );
$smarty->caching = 0;
?>