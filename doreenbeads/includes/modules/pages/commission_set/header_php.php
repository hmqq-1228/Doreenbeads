<?php
if (! isset ( $_SESSION ['customer_id'] )) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(TEXT_COMMISSION_SET);	

if (isset($_GET['action']) && ($_GET['action'] == 'edit')) {
   $contact_way = $_POST['contact_way'];
   if(isset($_POST['paypal'])){
  	$paypal = $_POST['paypal'];
  	$payment = 'paypal';
   }else{
  	$paypal = '';
  	$payment = 'balance';
   }
   $db->Execute("update  " . TABLE_PROMETERS_COMMISSION . " set contact_way = '" . $contact_way . "',payment_method ='" . $payment. "',paypal= '" . $paypal. "',last_modify_time= now() where customers_dropper_id = " . $_SESSION['customer_id']);

   zen_redirect(zen_href_link('commission_set'));
}


$sql = "select prometers_commission_id,dropper_url,contact_way,payment_method,paypal from " . TABLE_PROMETERS_COMMISSION . " where customers_dropper_id = " . $_SESSION['customer_id'];
$res = $db->Execute($sql);












?>