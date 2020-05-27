<?php
/**
 * Password Forgotten
 * 
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 2982 2006-02-07 07:56:41Z birdbrain $
 */

// This should be first line of the script:
$zco_notifier->notify ( 'NOTIFY_HEADER_START_PASSWORD_FORGOTTEN' );

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

// remove from snapshot
$_SESSION ['navigation']->remove_current_page ();

if (isset ( $_GET ['action'] ) && ($_GET ['action'] == 'process')) {
	$email_address = zen_db_prepare_input ( $_POST ['email_address'] );	
	$check_customer_query = "SELECT customers_firstname, customers_lastname
, customers_password, customers_facebookid FROM " . TABLE_CUSTOMERS . "
 WHERE customers_email_address = :emailAddress";	
	$check_customer_query = $db->bindVars ( $check_customer_query, ':emailAddress', $email_address, 'string' );
	$check_customer = $db->Execute ( $check_customer_query );
	
	if ($check_customer->RecordCount () > 0) {
		if($check_customer->fields ['customers_password']=='' && $check_customer->fields ['customers_facebookid']!=''){	//	由facebook注册的，没有密码，不提供修改密码
			$messageStack->add_session ( 'password_forgotten', 'Oops! Our records show that you use Facebook to login, and therefore you don\'t have a password. Please use Login With Facebook, or contact us for help.', 'caution' );
			zen_redirect ( zen_href_link ( FILENAME_PASSWORD_FORGOTTEN, '', 'SSL' ) );
		}else{
		$get_email_id_query = "SELECT rp_id,status FROM " . TABLE_RESET_PASSWORD . "
                           WHERE rp_email_address = :emailAddress
                           AND status=1";
		$get_email_id_query = $db->bindVars ( $get_email_id_query, ':emailAddress', $email_address, 'string' );
		$get_email_id = $db->Execute ( $get_email_id_query );		
		$date_now = date ( 'Y-m-d H:i:s' );		
		if ($get_email_id->RecordCount () > 0) {
			$db->Execute ( 'update ' . TABLE_RESET_PASSWORD . ' set rp_modify_time="' . $date_now . '",status=0 where rp_id=' . $get_email_id->fields ['rp_id'] );
		}
		$reset_password_query = "insert into " . TABLE_RESET_PASSWORD . '(rp_email_address,rp_create_time,rp_modify_time,status) values("' . $email_address . '", "' . $date_now . '", "' . $date_now . '", 1)';
		$db->Execute ( $reset_password_query );
		
		$get_email_id1 = $db->Execute ( $get_email_id_query );
		$str_encrypt = base64_encode ( rc4 ( 'panduo', $get_email_id1->fields ['rp_id'] ) . '8seasons' );
		$str_encrypt = str_replace ( array ( '+', '/' ), array ( '%', '-' ), $str_encrypt );
		$email_reset_pwd_link = zen_href_link ( FILENAME_PASSWORD_RESET, '', 'SSL' ) . '&p=' . $str_encrypt;
		$email_reset_pwd_link_cancel = zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) . '&p=' . $str_encrypt;
		
		$html_msg ['EMAIL_CUSTOMERS_NAME'] = '<br />' . TEXT_DEAR . $check_customer->fields ['customers_firstname'] . ' ' . $check_customer->fields ['customers_lastname'] . ',';
		
		$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf ( EMAIL_PASSWORD_REMINDER_BODY, $email_reset_pwd_link, $email_reset_pwd_link, $email_reset_pwd_link_cancel, $email_reset_pwd_link_cancel );
		// send the email
		zen_mail ( $check_customer->fields ['customers_firstname'] . ' ' . $check_customer->fields ['customers_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, $html_msg ['EMAIL_MESSAGE_HTML'], STORE_NAME, EMAIL_FROM, $html_msg, 'password_forgotten' );
		
		$messageStack->add_session ( 'login', sprintf(TEXT_SUCCESS_PASSWORD_SENT, $email_address), 'success' );
		zen_redirect ( zen_href_link ( FILENAME_PASSWORD_FORGOTTEN, '', 'SSL' ) );
		}
	} else {
		$messageStack->add_session ( 'login', TEXT_NO_EMAIL_ADDRESS_FOUND, 'caution' );
		zen_redirect ( zen_href_link ( FILENAME_PASSWORD_FORGOTTEN, '', 'SSL' ) );
	}
}

$breadcrumb->add ( NAVBAR_TITLE_1, zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
$breadcrumb->add ( NAVBAR_TITLE_2 );

// This should be last line of the script:
$zco_notifier->notify ( 'NOTIFY_HEADER_END_PASSWORD_FORGOTTEN' );
?>