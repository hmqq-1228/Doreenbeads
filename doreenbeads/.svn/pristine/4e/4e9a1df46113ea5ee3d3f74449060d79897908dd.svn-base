<?php
$zco_notifier->notify('NOTIFY_HEADER_START_MY_COMMISSION_INFO');
if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$commission_sql = 'select a.prometers_commission_info_id,a.customers_dropper_id,a.orders_id,o.delivery_name name,o.orders_status,a.in_orders_total,a.return_commission_total,a.commission_status commission_status from ' . TABLE_PROMETERS_COMMISSION_INFO . ' a,' . TABLE_ORDERS . ' o where customers_dropper_id = ' . $_GET['cid'] . ' and a.orders_id = o.orders_id and commission_status in(0,1,2,3,4) and CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) = ( select CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id = ' . $_GET['pid'].') ORDER BY
    commission_status desc,return_commission_total desc';
$commission_res = $db->Execute($commission_sql);
$commission_query = $db->bindVars ( $commission_sql, ':customersID', $_SESSION ['customer_id'], 'integer' );

$history_split = new splitPageResults ( $commission_query, 15, 'prometers_commission_info_id' );

$commission_res = $db->Execute ( $history_split->sql_query );
if($commission_res->RecordCount() > 0){
       while ( ! $commission_res->EOF ) {
        $commission_status = $commission_res->fields['commission_status'];
        
            if($commission_status == 0 || $commission_status ==1  || $commission_status ==3 ){
                $status = STATUS_1;
            }else if($commission_status == 4){
                $status = STATUS_0;
            }else if($commission_status == 2){
                $status = STATUS_2;
            }

           $commission_method [$commission_res->fields ['prometers_commission_info_id']] = array (
                'prometers_commission_info_id' => $commission_res->fields ['prometers_commission_info_id'],
                'name' => $commission_res->fields ['name'],
                'in_orders_total' => 'USD ' . round($commission_res->fields ['in_orders_total'],2),
                'return_commission_total' => 'USD ' . round($commission_res->fields ['return_commission_total'],2),
                'commission_status' => $status
           );
            $commission_res->MoveNext();
        }
}
$smarty->assign ( 'commission_method', $commission_method );

$message ['account_text_result_page'] = $history_split->display_links_mobile_for_shoppingcart(12, zen_get_all_get_params(array('page', 'info','x', 'y', 'main_page')));
$smarty->assign ( 'message', $message );








?>