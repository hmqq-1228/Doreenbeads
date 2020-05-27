<?php
/**
 * header_php.php
 * cash account
 */

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add('Balance');

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
$max_display = 10;
$credit_detial_split = new splitPageResults($credit_detial_query,$max_display);
$credit_detial =$db->Execute($credit_detial_split->sql_query);
if($credit_detial->RecordCount()>0){
	$show_credit_detial=true;
	$credit_detial_array=array();
	while(!$credit_detial->EOF){
		$credit_detial_array[]=array('cac_amount'=>$credit_detial->fields['cac_amount'],
									 'cac_currency_code'=>$credit_detial->fields['cac_currency_code'],
									 'cac_create_date'=>$credit_detial->fields['cac_create_date'],
									 'cac_memo'=>$credit_detial->fields['cac_memo'],
									 'cac_order_create'=>$credit_detial->fields['cac_order_create']);
		$credit_detial->MoveNext();
	}
}
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
$credit_account_code = $_SESSION['currency'];
$credit_account_total =zen_change_currency($credit_account_total,  'USD', $credit_account_code);


?>
