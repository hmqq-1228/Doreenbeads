<?php
if (! isset ( $_SESSION ['customer_id'] )) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(TEXT_MY_COMMSSION);

$commission_over_sql = 'select a.prometers_commission_info_id,a.customers_dropper_id,a.orders_id,o.delivery_name name,o.orders_status,a.in_orders_total,a.return_commission_total,a.commission_status commission_status from ' . TABLE_PROMETERS_COMMISSION_INFO . ' a,' . TABLE_ORDERS . ' o where customers_dropper_id = ' . $_GET['cid'] . ' and a.orders_id = o.orders_id and commission_status in(4) and CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) = ( select CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id = ' . $_GET['pid'].') ORDER BY
	commission_status ASC,return_commission_total desc';
$commission_over_res = $db->Execute($commission_over_sql);
$commission_over_query = $db->bindVars ( $commission_over_sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
$history_split = new splitPageResults ( $commission_over_query, 15, 'prometers_commission_info_id' );
$commission_over_res = $db->Execute ($history_split->sql_query );
if($commission_over_res->RecordCount() > 0){
	   while ( ! $commission_over_res->EOF ) {
	   	$commission_status = $commission_over_res->fields['commission_status'];
			if($commission_status == 4){
                $status = STATUS_0;
			}

	       $commission_method [$commission_over_res->fields ['prometers_commission_info_id']] = array (
   	            'prometers_commission_info_id' => $commission_over_res->fields ['prometers_commission_info_id'],
				'name' => $commission_over_res->fields ['name'],
				'in_orders_total' => 'USD ' . round($commission_over_res->fields ['in_orders_total'],2),
				'return_commission_total' => 'USD ' . round($commission_over_res->fields ['return_commission_total'],2),
				'commission_status' => $status
	  	   );
	     	$commission_over_res->MoveNext();
	    }
}

?>