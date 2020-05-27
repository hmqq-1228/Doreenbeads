<?php
if (! isset ( $_SESSION ['customer_id'] )) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(TEXT_MY_COMMSSION);
$commission_sql = 'SELECT orders_pay_time,pay_time,prometers_commission_info_id,customers_dropper_id, sum(round(in_orders_total,2)) in_orders_total,sum(round(return_commission_total,2)) return_commission_total,CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) as time FROM ' . TABLE_PROMETERS_COMMISSION_INFO  . ' t1 left join ' .TABLE_ORDERS. ' o on t1.orders_id = o.orders_id where customers_dropper_id = ' . $_SESSION['customer_id'] . ' and commission_status in(0,1,2,3,4,10) group BY time,customers_dropper_id order by orders_pay_time desc, customers_dropper_id asc';
$commission_res = $db->Execute($commission_sql);
$commission_query = $db->bindVars ( $commission_sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
$history_split = new splitPageResults ( $commission_query, 12, 'YEAR(orders_pay_time),MONTH(orders_pay_time)' );
$commission_res = $db->Execute ($history_split->sql_query );
if($commission_res->RecordCount() > 0){
	   while ( ! $commission_res->EOF ) {
	       $commission_method [$commission_res->fields ['prometers_commission_info_id']] = array (
   	            'prometers_commission_info_id' => $commission_res->fields ['prometers_commission_info_id'],
				'time' => date( 'M , Y', strtotime( $commission_res->fields ['orders_pay_time'] ) ),
				'customers_dropper_id' => $commission_res->fields ['customers_dropper_id'],
				'in_orders_total' => 'USD ' . round($commission_res->fields ['in_orders_total'],2),
				'return_commission_total' => 'USD ' . round($commission_res->fields ['return_commission_total'],2)
	  	   );
	     	$commission_res->MoveNext();
	    }
}



// 已结算佣金
$commission_over_sql = 'SELECT orders_pay_time,pay_time,prometers_commission_info_id,customers_dropper_id, sum(in_orders_total) in_orders_total,sum(round(return_commission_total,2)) return_commission_total,CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) as time,max(date_format(return_commission_time,"%Y-%m-%d")) return_commission_time,max(return_commission_time) return_commission_times,max(t1.payment_method_return_commission) tpm FROM ' . TABLE_PROMETERS_COMMISSION_INFO  . ' t1 left join ' .TABLE_ORDERS. ' o on t1.orders_id = o.orders_id where customers_dropper_id = ' . $_SESSION['customer_id'] . '  and commission_status in(4,10) group BY time,customers_dropper_id order by pay_time desc,customers_dropper_id asc';

$commission_over_res = $db->Execute($commission_over_sql);

$commission_over_query = $db->bindVars ( $commission_over_sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
$history_split2 = new splitPageResults ( $commission_over_query, 12, 'YEAR(orders_pay_time),MONTH(orders_pay_time)' );
$commission_over_res = $db->Execute ($history_split2->sql_query );
if($commission_over_res->RecordCount() > 0){
	   while ( ! $commission_over_res->EOF ) {
	   	$payment_method_sql = "select payment_method_return_commission from " . TABLE_PROMETERS_COMMISSION_INFO . " where return_commission_time = '" .$commission_over_res->fields['return_commission_times'] ."'";
	   	$payment_method_res = $db->Execute($payment_method_sql);
	   	$payment_method = $payment_method_res->fields['payment_method_return_commission'];
	       $commission_over_method [$commission_over_res->fields ['prometers_commission_info_id']] = array (
   	            'prometers_commission_info_id' => $commission_over_res->fields ['prometers_commission_info_id'],
				'time' => date( 'M , Y', strtotime( $commission_over_res->fields ['pay_time'] ) ),
				'customers_dropper_id' => $commission_over_res->fields ['customers_dropper_id'],
				'in_orders_total' => 'USD ' . round($commission_over_res->fields ['in_orders_total'],2),
				'return_commission_total' => 'USD ' . round($commission_over_res->fields ['return_commission_total'],2),
                'return_commission_time' => $commission_over_res->fields ['return_commission_time'],
                'payment_method' => $payment_method
	  	   );
	     	$commission_over_res->MoveNext();
	    }
}
?>