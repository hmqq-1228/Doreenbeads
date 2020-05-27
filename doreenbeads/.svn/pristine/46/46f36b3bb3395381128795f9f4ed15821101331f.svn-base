<?php
$zco_notifier->notify('NOTIFY_HEADER_START_AFFILIATE_PROGRAM');
if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
$customer_id = $db->Execute("select customers_dropper_id from " . TABLE_PROMETERS_COMMISSION ." where customers_dropper_id =" .$_SESSION['customer_id']);
if($customer_id->RecordCount() > 0){
	zen_redirect ( zen_href_link ( FILENAME_COMMISSION_SET ) );
}
if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
  $email_address = $_POST['email_address'];
  $customers_dropper_id = $_SESSION['customer_id'];	
  $dropper_url = '?pli='.$customers_dropper_id;
  if(isset($_POST['paypal'])){
  	$paypal = $_POST['paypal'];
  	$payment = 'paypal';
  }else{
  	$paypal = '';
  	$payment = 'balance';
  }
  $creat_time = date('Y-m-d h:i:s');
  
  $email = false ;
  if(isset($email_address) && isset($customers_dropper_id)){
  	 $email = true;
  	$customer_dropper = $db->Execute("insert into " . TABLE_PROMETERS_COMMISSION . "(`customers_dropper_id`,`contact_way`,`dropper_url`,`paypal`,`payment_method`,`create_time`) values('".$customers_dropper_id."','".$email_address."','".$dropper_url."','".$paypal."','".$payment."','".$creat_time."')");
  	if($email){
	  	$customers_res =$db->Execute("select customers_firstname,customers_lastname,customers_email_address from " .TABLE_CUSTOMERS . " where customers_id = " . $customers_dropper_id); 
        
        $customers_name = $customers_res->fields['customers_firstname'] . $customers_res->fields['customers_lastname'];
        $customers_address = $customers_res->fields['customers_email_address'];
        $email_subject = TEXT_EMAIL_SUBJECT;
        $email_text = '';
        $html_msg['EMAIL_MESSAGE_HTML'] = sprintf(EMAIL_CURRENCY_BODY, HTTP_SERVER .$dropper_url);
        
        zen_mail($customers_name, $customers_address, $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'default');

    }
  		zen_redirect ( zen_href_link ( FILENAME_AFFILIATE_PROGRAMER ) );
   	
  }
 }










?>