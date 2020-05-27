<?php

/**

 * Header code file for the customer's Account-Edit page

 *

 * @package page

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: header_php.php 4825 2006-10-23 22:25:11Z drbyte $

 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT_EDIT');
if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
//$class_now = isset($_POST['class_now']) ? $_POST['class_now'] : 0;
//echo $class_now;exit;
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
 if ($_GET['edit'] == 'password'){

  	$password_current = zen_db_prepare_input($_POST['password_current']);
    $password_new = zen_db_prepare_input($_POST['password_new']);
    $password_confirmation = zen_db_prepare_input($_POST['password_confirmation']);    
    if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;
      $messageStack->add_session('account_password', ENTRY_PASSWORD_CURRENT_ERROR);
    } elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;
      $messageStack->add_session('account_password', ENTRY_PASSWORD_NEW_ERROR);
    } elseif ($password_new != $password_confirmation) {
      $error = true;
      $messageStack->add_session('account_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
    } elseif($password_new == MASTER_PASS){
    	$error = true;
    }

    if ($error == false) {		
	    $check_customer_query = "SELECT customers_password, customers_nick
	                             FROM   " . TABLE_CUSTOMERS . "
	                             WHERE  customers_id = :customersID";
	
	    $check_customer_query = $db->bindVars($check_customer_query, ':customersID',$_SESSION['customer_id'], 'integer');
	    $check_customer = $db->Execute($check_customer_query);
	    if (zen_validate_password($password_current, $check_customer->fields['customers_password'])) {
	      $nickname = $check_customer->fields['customers_nick'];
	      $sql = "UPDATE " . TABLE_CUSTOMERS . "
	              SET customers_password = :password 
	              WHERE customers_id = :customersID";	
	      $sql = $db->bindVars($sql, ':customersID',$_SESSION['customer_id'], 'integer');
	      $sql = $db->bindVars($sql, ':password',zen_encrypt_password($password_new), 'string');
	      $db->Execute($sql);	
	      $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
	              SET    customers_info_date_account_last_modified = now()
	              WHERE  customers_info_id = :customersID";
	
	      $sql = $db->bindVars($sql, ':customersID',$_SESSION['customer_id'], 'integer');
	      $db->Execute($sql);		  
	        if ($phpBB->phpBB['installed'] == true) {
	          if (zen_not_null($nickname) && $nickname != '') {
	            $phpBB->phpbb_change_password($nickname, $password_new);
	          }
	        }	
	      $messageStack->add_session('account_password', SUCCESS_PASSWORD_UPDATED, 'success');
	    } else {	   
	      $error = true;
	      $messageStack->add_session('account_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
	    }  
	}

	zen_redirect(zen_href_link(FILENAME_ACCOUNT_EDIT, '&edit=password'));

  }elseif($_GET['edit'] == 'email'){
  	$email_address = zen_db_prepare_input($_POST['email_address']);  	
    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
	    $error = true;
	    $messageStack->add_session('account_email', ENTRY_EMAIL_ADDRESS_ERROR);
    }
  
  	if (!zen_validate_email($email_address)) {
	    $error = true;
	    $messageStack->add_session('account_email', TEXT_EMAIL_REG_TIP);
  	}

  	$check_email_query = "SELECT count(*) AS total
                        FROM   " . TABLE_CUSTOMERS . "
                        WHERE  customers_email_address = :emailAddress
                        AND    customers_id != :customersID";
  	$check_email_query = $db->bindVars($check_email_query, ':emailAddress', $email_address, 'string');
  	$check_email_query = $db->bindVars($check_email_query, ':customersID', $_SESSION['customer_id'], 'integer');
  	$check_email = $db->Execute($check_email_query);

  	if ($check_email->fields['total'] > 0) {
    	$error = true;
    	$messageStack->add_session('account_email', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
    	// check phpBB for duplicate email address
	    if ($phpBB->phpbb_check_for_duplicate_email(zen_db_input($email_address)) == 'already_exists' ) {
	      $error = true;
	      $messageStack->add_session('account_email', 'phpBB-'.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
	    }
  	}
  
  	if (!$error){
	  	//update phpBB with new email address  	
	  	$old_addr_check=$db->Execute("select customers_email_address, customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id='".(int)$_SESSION['customer_id']."'"); 

	  	$old_email_address = $old_addr_check->fields['customers_email_address'];

	  	$ip_address = zen_get_ip_address();

	  	if ($old_email_address != $email_address) {
		  	include_once(DIR_WS_CLASSES . 'config.inc');

		  	// 客户订阅
		    $customer_mailchimp_query = $db->Execute("SELECT * from " . TABLE_CUSTOMERS_FOR_MAILCHIMP . " WHERE customers_for_mailchimp_email = '" .  $old_email_address . "' LIMIT 1");
		    $list_id = $customer_mailchimp_query->fields['list_id'];

		    if ($list_id != '') { $listId = $list_id; }

		    if ($customer_mailchimp_query->RecordCount() > 0) { // 表中有记录，只需更新
		        $update_array = array(
		            'customers_for_mailchimp_email' => $email_address,
		            'session_customers_email_address' => $email_address,
		            'session_customers_id' => $_SESSION['customer_id'],
		            'list_id' => $listId,
		            'website_code' => WEBSITE_CODE,
		            'languages_id' => $customer_mailchimp_query->fields['languages_id'],
		            'customers_firstname' => $_SESSION['customer_first_name'],
		            'customers_lastname' => $_SESSION['customer_last_name'],
		            'subscribe_status' => $customer_mailchimp_query->fields['subscribe_status'],
		            'subscribe_from' => $customer_mailchimp_query->fields['subscribe_from'],
		            'browser_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		            'ip_address' => $ip_address
		          );

		        $update_sql_array = array_merge($update_array, array('last_modified' => date('Y-m-d H:i:s')));

		        $insert_sql_array = array_merge($update_array, array('date_created' => date('Y-m-d H:i:s')));

		        zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP, $update_sql_array, 'update', "customers_for_mailchimp_email = '" .  $old_email_address . "'");
		        zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_SUBSCRIBE_LOG, $insert_sql_array);
		        $insert_sql_array['customers_for_mailchimp_email'] = $old_email_address;
		        zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_UNSUBSCRIBE_LOG, $insert_sql_array);

		        if ($customer_mailchimp_query->fields['subscribe_status'] == 10) {
		            
		            $subscribe_event_data = array('customers_email_address' => $email_address,
		                'customers_firstname' => $_SESSION['customer_first_name'],
		                'customers_lastname' => $_SESSION['customer_last_name'],
		                'list_id' => $listId,
		                'languages_id' => $customer_mailchimp_query->fields['languages_id'],
		                'event_type' => 10,
		                'event_status' => 10,
		                'date_created' => date('Y-m-d H:i:s')
		                );
		            $unsubscribe_event_data = array('customers_email_address' => $old_email_address,
		                'customers_firstname' => $_SESSION['customer_first_name'],
		                'customers_lastname' => $_SESSION['customer_last_name'],
		                'list_id' => $listId,
		                'languages_id' => $customer_mailchimp_query->fields['languages_id'],
		                'event_type' => 20,
		                'event_status' => 10,
		                'date_created' => date('Y-m-d H:i:s')
		                );
		            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT, $subscribe_event_data);
		            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT, $unsubscribe_event_data);
		        }
		    }
		}

	  	$phpBB->phpbb_change_email(zen_db_input($old_addr_check->fields['customers_email_address']),zen_db_input($email_address));
	  	//$db->Execute('update ' . TABLE_CUSTOMERS . ' set customers_email_address = "' . $email_address . '" where customers_id= ' . (int)$_SESSION['customer_id']);
	  	$data_update = array('customers_email_address_old' => $old_email_address, 'customers_email_address' => $email_address, 'ip_address' => $ip_address);
	  	$email_update_result = update_customers_email_address_by_customers_id($_SESSION['customer_id'], $data_update);
	  	if($email_update_result['success'] == 1) {
			$email_to_name = get_customers_email_dear_name(null);
	  		$html_msg['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_CHANGED_YOUR_EMAIL_CONTENT, $email_to_name, $old_email_address, $email_address, date("Y-m-d H:i:s"));
	  		zen_mail($email_to_name, $old_email_address, TEXT_CHANGED_YOUR_EMAIL_TITLE, strip_tags($html_msg['EMAIL_MESSAGE_HTML']), STORE_NAME, EMAIL_FROM, $html_msg, 'default');
	  		$messageStack->add_session('account_email', SUCCESS_ACCOUNT_UPDATED, 'success');
	  	} else {
	  		$messageStack->add_session('account_email', ENTRY_EMAIL_ADDRESS_ERROR);
	  	}

	  	//zen_redirect(zen_href_link(FILENAME_ACCOUNT_EDIT, '&edit=email'));

	  	/*if (zen_db_input($old_addr_check->fields['customers_email_address']) != zen_db_input($email_address)){
	  		$html_msg ['EMAIL_MESSAGE_HTML'] = '客户 ' . $old_addr_check->fields['customers_firstname'] . ' ' . $old_addr_check->fields['customers_lastname'] . '(' . $old_addr_check->fields['customers_email_address'] . ')' . ' 更换了注册Email，新的Email是：' . $email_address . '，请在CRM或ERP合并这2个Email';
	  		zen_mail('', 'xiaoying.zheng@panduo.com.cn', 'Notice 有客户修改登录邮箱', '', STORE_NAME, EMAIL_FROM, $html_msg);
	  	}*/	  	
	  
  	 }
  	}else{

	  	if (ACCOUNT_GENDER == 'true') $gender = zen_db_prepare_input($_POST['gender']);
		$firstname = zen_db_prepare_input($_POST['firstname']);
		$lastname = zen_db_prepare_input($_POST['lastname']);
	  	if (ACCOUNT_DOB == 'true'){
		  	$dob_year = zen_db_prepare_input($_POST['sel_year']);
	  		$dob_month = zen_db_prepare_input($_POST['sel_month']);
	  		$dob_day = zen_db_prepare_input($_POST['sel_day']);
	  	}

	  	$telephone = zen_db_prepare_input($_POST['telephone']);  
	  	$customers_cell_phone = zen_db_prepare_input($_POST['customers_cell_phone']);  
	  	$customers_business_web = zen_db_prepare_input($_POST['customers_business_web']);  
	  	$customers_country_id = zen_db_prepare_input($_POST['customers_country_id']);
	  	$customers_dob = zen_db_prepare_input($_POST['customers_dob']);

	 	 //$fax = zen_db_prepare_input($_POST['fax']);
	  	$email_format = zen_db_prepare_input($_POST['email_format']);

	  	if (CUSTOMERS_REFERRAL_STATUS == '2' and $_POST['customers_referral'] != '') $customers_referral = zen_db_prepare_input($_POST['customers_referral']);
	  	$error = false;
	
	  	if (ACCOUNT_GENDER == 'true') {
		    if ( ($gender != 'm') && ($gender != 'f') ) {
		      $error = true;
		      $messageStack->add_session('account_profile', ENTRY_GENDER_ERROR);
		    }
	  	}
	  	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		    $error = true;
		    $messageStack->add_session('account_profile', ENTRY_FIRST_NAME_ERROR);
	  	}
	  	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		    $error = true;
		    $messageStack->add_session('account_profile', ENTRY_LAST_NAME_ERROR);
	  	}

// 	  	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
// 	    $error = true;
// 	    $messageStack->add('account_profile', ENTRY_TELEPHONE_NUMBER_ERROR);
	
// 	  	}
	  
	  	if ($customers_country_id == '') {
	    $error = true;
	    $messageStack->add_session('account_profile', ENTRY_COUNTRY_ERROR);
	  	} 

	  	if( !($dob_year <= 0 && $dob_month <= 0 && $dob_day <= 0) ){
		    if ( !($dob_year > 0 && $dob_month > 0 && $dob_day > 0) ) {
		      	$error = true;
		      	$messageStack->add_session('account_profile',TEXT_ENTER_BIRTHDAY_ERROR);
		    }elseif(strtotime($dob_year."-".$dob_month."-".$dob_day) > strtotime(date('Y-m-d'))){
		      	$error = true;
		      	$messageStack->add_session('account_profile', TEXT_ENTER_BIRTHDAY_OVER_DATE);
		    }    
		}

	  	if ($error == false) {  	
	    	$sql_data_array = array(array('fieldName'=>'customers_firstname', 'value'=>$firstname, 'type'=>'string'),
	                            array('fieldName'=>'customers_lastname', 'value'=>$lastname, 'type'=>'string'),
	//                          array('fieldName'=>'customers_email_address', 'value'=>$email_address, 'type'=>'string'),
	                            array('fieldName'=>'customers_telephone', 'value'=>$telephone, 'type'=>'string'),                            
	                            array('fieldName'=>'customers_cell_phone', 'value'=>$customers_cell_phone, 'type'=>'string'),
	                           // array('fieldName'=>'customers_fax', 'value'=>$fax, 'type'=>'string'),
	                            array('fieldName'=>'customers_email_format', 'value'=>$email_format, 'type'=>'string'),                            
	                            array('fieldName'=>'customers_business_web', 'value'=>$customers_business_web, 'type'=>'string'),                            
	                            array('fieldName'=>'customers_country_id', 'value'=>$customers_country_id, 'type'=>'integer')
	    	);
		    if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != '')) {
		      $sql_data_array[] = array('fieldName'=>'customers_referral', 'value'=>$customers_referral, 'type'=>'string');
		    }
		    if (ACCOUNT_GENDER == 'true') {
		      $sql_data_array[] = array('fieldName'=>'customers_gender', 'value'=>$gender, 'type'=>'string');
		    }
		    if (ACCOUNT_DOB == 'true') {
		    	if ($dob_year != '' && $dob_year != 0){
		    		$cus_dob = $dob_year."-".$dob_month."-".$dob_day;
		            $sql_data_array[] = array('fieldName'=>'customers_dob', 'value'=>date('Y-m-d H:i:s', strtotime($cus_dob)), 'type'=>'date');
		    	}   
	    	}

	    	$where_clause = "customers_id = :customersID";
	    	$where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
	    	$db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
	    	$sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
	            SET    customers_info_date_account_last_modified = now()
	            WHERE  customers_info_id = :customersID";
	    	$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
	    	$db->Execute($sql);

	    	write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $_SESSION ['customer_id'] . "\n customers_email_address: " . $email_address . "\n firstname: " . $firstname . "\n lastname: " . $lastname ."\n ip: " . zen_get_ip_address () ."\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: ". date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array) . "\n===========================================================\n\n\n"); 	

	    	$messageStack->add_session('account_profile', SUCCESS_ACCOUNT_UPDATED, 'success');
	    	//$smarty->assign('arr',$sql_data_array);
	    	//print_r($sql_data_array);
	    	$zco_notifier->notify('NOTIFY_HEADER_ACCOUNT_EDIT_UPDATES_COMPLETE'); 
  		}
  		zen_redirect(zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
  }
}

$account_query = "SELECT customers_gender, customers_firstname, customers_lastname,
                         customers_dob, customers_email_address, customers_telephone,customers_cell_phone,
                         customers_fax, customers_email_format, customers_referral,customers_country_id,customers_business_web,customers_info_avatar
                  FROM   " . TABLE_CUSTOMERS . " c, ".TABLE_CUSTOMERS_INFO." ci
                  WHERE  customers_id = :customersID and ci.customers_info_id=c.customers_id";
$account_query = $db->bindVars($account_query, ':customersID', $_SESSION['customer_id'], 'integer');
$account = $db->Execute($account_query);

while (!$account->EOF){
	$firstname    = $account->fields['customers_firstname'];
	$lastname     = $account->fields['customers_lastname'];
	$gender        = $account->fields['customers_gender'];
	$business_web = $account->fields['customers_business_web'];
	$tel		  = $account->fields['customers_telephone'];
	$cell		  = $account->fields['customers_cell_phone'];
	$email		  = $account->fields['customers_email_address'];
	$account->MoveNext();	
}

$smarty->assign('firstname',$firstname);
$smarty->assign('lastname',$lastname);
$smarty->assign('gender',$gender);
$smarty->assign('business_web',$business_web);
$smarty->assign('tel',$tel);
$smarty->assign('cell',$cell);
$smarty->assign('email',$email);


$country_select_name='customers_country_id';
/*if($account->fields['customers_country_id']==''||$account->fields['customers_country_id']==0){
	$account->fields['customers_country_id']=zen_get_selected_country($_SESSION['languages_id']);
}*/

$country_select = zen_get_country_select($country_select_name, '223',$_SESSION['languages_id']);
//var_dump($country_select);

$sel_year = $sel_month = $sel_day = 0;
$customer_dob = $account->fields['customers_dob'];
if ($customer_dob >= '1900-01-01 00:00:00') {
  $sel_year = date('Y',strtotime($customer_dob));
  $sel_month = date('m',strtotime($customer_dob));
  $sel_day = date('d',strtotime($customer_dob));
}

if (ACCOUNT_GENDER == 'true') {
	if ($entry->fields['entry_gender'] == 'm'){
		$male = true;
	} else {
		$male = false;
	}
	$female = !$male;
}


$customers_referral = $account->fields['customers_referral'];
if (isset($customers_email_format)) {
  $email_pref_html = (($customers_email_format == 'HTML') ? true : false);
  $email_pref_none = (($customers_email_format == 'NONE') ? true : false);
  $email_pref_optout = (($customers_email_format == 'OUT')  ? true : false);
  $email_pref_text = (($email_pref_html || $email_pref_none || $email_pref_out) ? false : true);  // if not in any of the others, assume TEXT
} else {
  $email_pref_html = (($account->fields['customers_email_format'] == 'HTML') ? true : false);
  $email_pref_none = (($account->fields['customers_email_format'] == 'NONE') ? true : false);
  $email_pref_optout = (($account->fields['customers_email_format'] == 'OUT')  ? true : false);
  $email_pref_text = (($email_pref_html || $email_pref_none || $email_pref_out) ? false : true);  // if not in any of the others, assume TEXT
}



$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2, zen_href_link(FILENAME_MYACCOUNT.'#myaccountsetting','','SSL'));

if ($_GET['edit'] == 'email'){
	$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_account_edit_email.html';
	$breadcrumb->add(NAVBAR_TITLE_EMAIL);
}elseif ($_GET['edit'] == 'password'){
	$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_account_edit_password.html';
	$breadcrumb->add(NAVBAR_TITLE_PASSWORD);
}else{
	$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_account_edit_profile.html';
	$breadcrumb->add(NAVBAR_TITLE_PROFILE);
}

$smarty->assign('tpl',$tpl);
$smarty->assign('country_select',$country_select);
$smarty->assign('sel_year',$sel_year);
$smarty->assign('sel_month',$sel_month);
$smarty->assign('sel_day',$sel_day);
$smarty->assign('messageStack',$messageStack);


$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_EDIT');

?>