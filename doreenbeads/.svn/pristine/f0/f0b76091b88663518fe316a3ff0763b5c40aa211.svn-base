<?php
/**
 * header_php.php
 * cash account
 */

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
$show_credit_detial=false;
//  $credit_total = $db->Execute("Select cac_cash_id, sum(cac_amount) as total, cac_currency_code
//							   From " . TABLE_CASH_ACCOUNT . "
//						      Where cac_customer_id = " . $_SESSION['customer_id'] . "
//							    And cac_status = 'A'");
$credit_detial_query =  "Select cac_cash_id,cac_amount,cac_currency_code,cac_create_date,cac_memo,cac_order_create
							   From " . TABLE_CASH_ACCOUNT . "
						      Where cac_customer_id = " . $_SESSION ['customer_id'] . "  and cac_status!='X' and cac_order_create!=2 order by cac_cash_id desc" ;
$max_display = MAX_DISPLAY_ORDER_HISTORY;           
$credit_detial_split = new splitPageResults($credit_detial_query,$max_display);
$number_of_pages = $credit_detial_split->number_of_pages;	  //
$number_of_rows = $credit_detial_split->number_of_rows;       //total_rows
$current_page_number = $credit_detial_split->current_page_number;
//var_dump($credit_detial_split);exit;
$credit_detial =$db->Execute($credit_detial_split->sql_query);
//var_dump($credit_detial);exit;
if($credit_detial->RecordCount()>0){
	$show_credit_detial=true;
	$credit_detial_array=array();
	while(!$credit_detial->EOF){
		$credit_detial_array[]=array('cac_amount'=>$credit_detial->fields['cac_amount'],
									 'cac_amount_abs'=>number_format(abs($credit_detial->fields['cac_amount']),2),
									 'cac_currency_code'=>$credit_detial->fields['cac_currency_code'],
									 'cac_create_date'=>date('M d,Y',strtotime($credit_detial->fields['cac_create_date'])),
									 'cac_memo'=>$credit_detial->fields['cac_memo'],
									 'cac_order_create'=>$credit_detial->fields['cac_order_create']);
		$credit_detial->MoveNext();
	}
}

//var_dump($credit_detial_array);

$credit_records = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
							   From " . TABLE_CASH_ACCOUNT . "
						      Where cac_customer_id = " . $_SESSION ['customer_id'] . "
							    And cac_status = 'A'" );
$credit_account_total = 0;
while ( ! $credit_records->EOF ) {
	$ca_currency_code = $credit_records->fields ['cac_currency_code'];
	$ca_amount = $credit_records->fields ['cac_amount'];
	$credit_account_total += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
	$credit_records->MoveNext ();
}

$credit_account_total =$currencies->format($credit_account_total);

$fenye = $credit_detial_split->display_links_mobile_for_shoppingcart(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')) );

$smarty->assign('fenye',$fenye);
$smarty->assign('credit_detail_array',$credit_detial_array);
$smarty->assign('credit_account_code',$credit_account_code);   
$smarty->assign('credit_account_total',$credit_account_total);  


?>
