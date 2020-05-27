<?php
/*
 * author gaoxueping local cache
 */
if (isset($_GET ['id']) && $_GET ['id'] == 99999) {
	require('includes/languages/'.$_SESSION['language'].'/contact_us.php');
	$error = false;
	if (CONTACT_US_LIST !=''){
		foreach(explode(",", CONTACT_US_LIST) as $k => $v) {
			$send_to_array[] = array('id' => $k, 'text' => preg_replace('/\<[^*]*/', '', $v));
		}
	}
	if(isset ( $_GET ['action'] ) && ($_GET ['action'] == 'send')){
		$name = zen_db_prepare_input ( $_POST ['contactname'] );
		$email_address = zen_db_prepare_input ( $_POST ['email'] );
		$enquiry = zen_db_prepare_input ( strip_tags ( $_POST ['enquiry'] ) );
		
		if (! zen_customer_exit ( $email_address ) && ! zen_potential_customer_exist ( $email_address )) {
			$db->Execute ( "insert into t_potential_customer (pcu_full_name, pcu_email, pcu_create_date)
	  				  values ('" . $name . "', '" . $email_address . "', '" . date ( 'YmdHis' ) . "')" );
		}
		
		$zc_validate_email = zen_validate_email ( $email_address );

		if ($zc_validate_email and ! empty ( $enquiry ) and ! empty ( $name )) {
			// auto complete when logged in
			if ($_SESSION ['customer_id']) {
				$sql = "SELECT customers_id, customers_firstname, customers_lastname, customers_password, customers_email_address, customers_default_address_id 
	              FROM " . TABLE_CUSTOMERS . " 
	              WHERE customers_id = :customersID";
				
				$sql = $db->bindVars ( $sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
				$check_customer = $db->Execute ( $sql );
				$customer_email = $check_customer->fields ['customers_email_address'];
				$customer_name = $check_customer->fields ['customers_firstname'] . ' ' . $check_customer->fields ['customers_lastname'];
			} else {
				$customer_email = NOT_LOGGED_IN_TEXT;
				$customer_name = NOT_LOGGED_IN_TEXT;
			}
			
			// use contact us dropdown if defined
			if (CONTACT_US_LIST != '') {
				$send_to_array = explode ( ",", CONTACT_US_LIST );
				preg_match ( '/\<[^>]+\>/', $send_to_array [$_POST ['send_to']], $send_email_array );
				$send_to_email = eregi_replace ( ">", "", $send_email_array [0] );
				$send_to_email = eregi_replace ( "<", "", $send_to_email );
				$send_to_name = preg_replace ( '/\<[^*]*/', '', $send_to_array [$_POST ['send_to']] );
			} else { // otherwise default to EMAIL_FROM and store name
				$send_to_email = EMAIL_FROM;
				$send_to_name = STORE_NAME;
			}
			
			// Prepare extra-info details
			$extra_info = email_collect_extra_info ( $name, $email_address, $customer_name, $customer_email );
			// Prepare Text-only portion of message
			$text_message = OFFICE_FROM . "\t" . $name . "\n" . OFFICE_EMAIL . "\t" . $email_address . "\n\n" . '------------------------------------------------------' . "\n\n" . strip_tags ( $_POST ['enquiry'] ) . "\n\n" . '------------------------------------------------------' . "\n\n" . $extra_info ['TEXT'];
			// Prepare HTML-portion of message
			$html_msg ['EMAIL_MESSAGE_HTML'] = strip_tags ( $_POST ['enquiry'] ) . '<div style="color: grey;">###Contact Us2###</div>';
			$html_msg ['CONTACT_US_OFFICE_FROM'] = OFFICE_FROM . ' ' . $name . '<br />' . OFFICE_EMAIL . '(' . $email_address . ')';
			$html_msg ['EXTRA_INFO'] = $extra_info ['HTML'];
			
			if ($_SESSION['auto_auth_code_display']['contact_us'] > 0){
				$_SESSION['auto_auth_code_display']['contact_us']+= 1;
			}else{
				$_SESSION['auto_auth_code_display']['contact_us'] = 1;
			}
			
			// Send message
			zen_mail ( STORE_NAME, SALES_EMAIL_ADDRESS, EMAIL_SUBJECT, $text_message, $name, $email_address, $html_msg, 'contact_us', '', 'false' );
// 			zen_mail ( $name, $email_address, EMAIL_SUBJECT, $text_message, STORE_NAME, EMAIL_FROM, $html_msg, 'contact_us', '', 'false' );
			zen_redirect ( zen_href_link ( FILENAME_CONTACT_US, 'action=success' ) );
		} else {
			$error = true;
			if (empty ( $name )) {
				$messageStack->add ( 'contact', ENTRY_EMAIL_NAME_CHECK_ERROR );
			}
			if ($zc_validate_email == false) {
				$messageStack->add ( 'contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR );
			}
			if (empty ( $enquiry )) {
				$messageStack->add ( 'contact', ENTRY_EMAIL_CONTENT_CHECK_ERROR );
			}
		}
	}
} else {
	header ( 'Cache-Control: public,max-age=86400' );
	header ( 'Pargma: cache' );
	$offset = 24 * 60 * 60;
	$expires = "Expires: " . gmdate ( 'D, d M Y H:i:s', time () + $offset ) . " GMT";
	header ( $expires );
}
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$breadcrumb->add ( TEXT_ABOUT_US );
$breadcrumb->add ( NAVBAR_TITLE_1 );

?>