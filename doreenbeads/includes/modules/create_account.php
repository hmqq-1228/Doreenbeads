<?php
/**
 * create_account header_php.php
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 6772 2007-08-21 12:33:29Z drbyte $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_MODULE_START_CREATE_ACCOUNT');

/*
chimp_robbie wei
*/
//include_once(DIR_WS_CLASSES . 'MCAPI.class.php');
//include_once(DIR_WS_CLASSES . 'config.inc'); //contains username & password
//end
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/mail_welcome.php');
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/create_account.php');

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * Set some defaults
 */
  $process = false;
  $zone_name = '';
  $entry_state_has_zones = '';
  $error_state_input = false;
  $state = '';
  $zone_id = 0;
  $error = false;
  $email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
  $newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' ? false : true);

/**
 * Process form contents
 */
if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
  $process = true;
  
  $email_address = zen_db_prepare_input($_POST['email_address']);
  $firstname = strchr($email_address, "@", true);
  $password = zen_db_prepare_input($_POST['password']);
  $confirmation = zen_db_prepare_input($_POST['confirmation']);
  //$agree_term = zen_db_prepare_input($_POST['agree_to']);
  $twitter_customers_id = '';
  $vk_customers_id = '';
  
  if(isset($_SESSION['api_login_type'])){
      if($_SESSION['api_login_type'] == 'Twitter'){
          $register_entry = 7;
          $twitter_customers_id = $_SESSION['api_customers_id'];
      }else{
          $register_entry = 6;
          $vk_customers_id = $_SESSION['api_customers_id'];
      }
  }else{
      $register_entry = (int)$_POST['register_entry'];
  }
  
  $ip_address = zen_get_ip_address();
  $password_pattern = '/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/';
  if (isset($_POST['newsletter']) && is_numeric($_POST['newsletter'])) {
  	$newsletter = zen_db_prepare_input($_POST['newsletter']);
  }else{
  	$newsletter = '0';
  }

  if (strlen($email_address) == 0) {
      $error = true;
      $messageStack->add('create_account', ALERT_EMAIL);
  } elseif(strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH){
      $error = true;
      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
  }elseif (zen_validate_email($email_address) == false) {
      $error = true;
      $messageStack->add('create_account', TEXT_EMAIL_REG_TIP);
  } else {
    $check_email_query = "select count(*) as total
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input($email_address) . "'";
	$check_email_query = "select customers_id,customers_password,customers_facebookid 
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input ( $email_address ) . "'";
	$check_email = $db->Execute($check_email_query);
 //   if ($check_email->fields['total'] > 0) {
	 if ($check_email->RecordCount() > 0) {
		if($check_email->fields['customers_facebookid'] != ''){
			$error = true;
			$error_facebook_register = true;
		}else{
		$error = true;
		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
		}
    }/*else{
		$result = remote_check_email($email_address);
		$check_error = '';
		$allow_pass = 20;
		
		if($result['authentication_status'] == 1 && $result['limit_status'] == 0){	
			if($result['verify_status'] == 0){
				if(strpos($result['verify_status_desc'],'does not exist') ){
					$allow_pass = 10;
					$error = true;
					$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_REMOTE_CHECK_ERROR);
				}
				
				$check_error = $result['verify_status_desc'];
				
			}
		}
		if($result['authentication_status'] == 0 || $result['authentication_status'] == '' || ($result['limit_status'] == 0 && $result['verify_status_desc'] == '')){
			$check_error = 'An error occurred during verification.';
		}elseif ($result['limit_status'] == 1){
			$check_error = $result['limit_desc'];
		}
			
		if ($check_error != '' && $email_address != ''){
			$check_result_query = 'insert into ' . TABLE_CHECK_EMAIL_RESULT . ' (email_address , error_info , create_date , allow_pass) values ("'.zen_db_input($email_address).'", "'.zen_db_input($check_error).'", "'.date('Y-m-d H:i:s').'" , ' . $allow_pass. ')';
			$db->Execute($check_result_query);
		}
	}*/
  }

  if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH  || !preg_match($password_pattern , $password)) {
    $error = true;
  if (strlen($password) == 0) {
    	 $messageStack->add('create_account', ENTER_PASSWORD_PROMPT);
    }else{
    	$messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
    }
  } 
  
if (strlen($confirmation) != 0) {
    if($confirmation != $password){
    	$error = true;
    	$messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }
  }else{
  		$error = true;
    	$messageStack->add('create_account', TEXT_CONFIRM_PASSWORD);
   }

//  if($agree_term != 1){
//  	$error = true;
//  	$messageStack->add('create_account', ENTRY_AGREEN_ERROR_SELECT);
//  }

  if ($error == true) {
    // hook notifier class
    $zco_notifier->notify('NOTIFY_FAILURE_DURING_CREATE_ACCOUNT');
  } else {
   $currency_preference=isset($_SESSION['currency'])?$_SESSION['currency']:'USD';
   $get_currency_sql="select currencies_id from ".TABLE_CURRENCIES." where code='".$currency_preference."' ";
   $get_currency_id=$db->Execute($get_currency_sql);
   $currency_id=$get_currency_id->fields['currencies_id'] != '' ? $get_currency_id->fields['currencies_id'] : 1;

    $sql_data_array = array('customers_firstname' => $firstname,
                            'customers_email_address' => $email_address,
                            'customers_newsletter' => (int)$newsletter,
                            'customers_email_format' => $email_format,
                            'customers_default_address_id' => 0,
                            'customers_password' => zen_encrypt_password($password),
                            'customers_authorization' => (int)CUSTOMERS_APPROVAL_AUTHORIZATION,
                            'customers_twitter_id' => $twitter_customers_id,
                            'customers_vk_id' => $vk_customers_id,
                            'signin_ip' => $ip_address,
                            'from_mobile'=>$is_mobilesite ? 1 : 0,
    						'register_languages_id' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
    						'register_useragent_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
							'currencies_preference' => $currency_id,
                            'register_entry'=>$register_entry
    );

	if($fun_inviteFriends->hasRefer()){
		$sql_data_array['referrer_id'] = intval($fun_inviteFriends->getRefer());
	}

    if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != '')) $sql_data_array['customers_referral'] = $customers_referral;
//     if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
    //jessa 2009-12-20 ���¸�ʽ���������
	
	$sql_data_array1 = array(
			'customers_gender'=>'m',
			'customers_dob' => '0001-01-01 00:00:00',
			'customers_nick' => '',
			'customers_telephone' => '',
			'customers_cell_phone' =>'',
			'customers_fax' => '',
			'customers_group_pricing' => 0,
			'customers_referral' =>'',
			'customers_paypal_payerid' => '',
			'customers_paypal_ec' => ''
	);
	$sql_data_array = array_merge($sql_data_array, $sql_data_array1);
    zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);

    $_SESSION['customer_id'] = $db->Insert_ID();

    $sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created)
              values ('" . (int)$_SESSION['customer_id'] . "', '0', now())";

    $db->Execute($sql);

    write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $_SESSION ['customer_id'] . "\n customers_email_address: " . $email_address ."\n ip: " . zen_get_ip_address () ."\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: ". date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array) . "\n===========================================================\n\n\n");
    
	//create account success  send register coupon WSL
    add_coupon_code(REGISTER_COUPON_CODE, false);

    $_SESSION['customer_first_name'] = $firstname;
    $_SESSION['customer_default_address_id'] = $address_id;
    $_SESSION['customer_zone_id'] = $zone_id;
    $_SESSION['customers_authorization'] = $customers_authorization;
    
    setcookie("zencart_cookie_validate_email", md5($email_address), time() + 7776000, '/', '.' . BASE_SITE);
	
    //2011-1-3 on
    // restore cart contents
    $ls_old_cookie = $_SESSION['cookie_cart_id'];
    if (SESSION_RECREATE == 'True') {
      zen_session_recreate();
    }
    $_SESSION['cart']->restore_contents($ls_old_cookie);
	setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
	
	add_customers_message($_SESSION['customer_id']);
    //eof 2010-1-3
    // hook notifier class
    $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS_VIA_CREATE_ACCOUNT');

    // build the message content
    $name = $firstname;

    /* if (ACCOUNT_GENDER == 'true' && $gender != '') {
      if ($gender == 'm') {
        $email_text = sprintf(EMAIL_GREET_MR, $lastname);
      } else {
        $email_text = sprintf(EMAIL_GREET_MS, $lastname);
      }
    } else {
      $email_text = sprintf(EMAIL_GREET_NONE, $firstname);
    } */
    $email_text = sprintf(TEXT_DEAR_FN, $firstname) . ",\n\n";
    $html_msg['EMAIL_GREETING'] = str_replace('\n','',$email_text);
    $html_msg['EMAIL_FIRST_NAME'] = $firstname;
    $html_msg['EMAIL_LAST_NAME']  = $lastname;

    // initial welcome
    $email_text .=  EMAIL_WELCOME;
    $html_msg['EMAIL_WELCOME'] = str_replace('\n','',EMAIL_WELCOME);

	$email_text .= EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
	$html_msg['EMAIL_CUSTOMER_EMAILADDRESS'] = EMAIL_SEPARATOR . '<br />' . EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
	$email_text .= EMAIL_CUSTOMER_PASSWORD . $password;
	$html_msg['EMAIL_CUSTOMER_PASSWORD'] = EMAIL_CUSTOMER_PASSWORD . $password . '<br />' . EMAIL_SEPARATOR;
	
	$email_text .= EMAIL_KINDLY_NOTE;
	$html_msg['EMAIL_KINDLY_NOTE'] = str_replace('\n', '', EMAIL_KINDLY_NOTE);
	
	$email_text .= EMAIL_CUSTOMER_REG_DESCRIPTION;
	$html_msg['EMAIL_CUSTOMER_REG_DESCRIPTION'] = EMAIL_CUSTOMER_REG_DESCRIPTION;

    if (NEW_SIGNUP_DISCOUNT_COUPON != '' and NEW_SIGNUP_DISCOUNT_COUPON != '0') {
      $coupon_id = NEW_SIGNUP_DISCOUNT_COUPON;
      $coupon = $db->Execute("select * from " . TABLE_COUPONS . " where coupon_id = '" . $coupon_id . "'");
      $coupon_desc = $db->Execute("select coupon_description from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . $_SESSION['languages_id'] . "'");
      $db->Execute("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id ."', '0', 'Admin', '" . $email_address . "', now() )");

      $text_coupon_help = sprintf(TEXT_COUPON_HELP_DATE, zen_date_short($coupon->fields['coupon_start_date']),zen_date_short($coupon->fields['coupon_expire_date']));

      // if on, add in Discount Coupon explanation
      //        $email_text .= EMAIL_COUPON_INCENTIVE_HEADER .
      $email_text .= "\n" . EMAIL_COUPON_INCENTIVE_HEADER .
      (!empty($coupon_desc->fields['coupon_description']) ? $coupon_desc->fields['coupon_description'] . "\n\n" : '') . $text_coupon_help  . "\n\n" .
      strip_tags(sprintf(EMAIL_COUPON_REDEEM, ' ' . $coupon->fields['coupon_code'])) . EMAIL_SEPARATOR;

      $html_msg['COUPON_TEXT_VOUCHER_IS'] = EMAIL_COUPON_INCENTIVE_HEADER ;
      $html_msg['COUPON_DESCRIPTION']     = (!empty($coupon_desc->fields['coupon_description']) ? '<strong>' . $coupon_desc->fields['coupon_description'] . '</strong>' : '');
      $html_msg['COUPON_TEXT_TO_REDEEM']  = str_replace("\n", '', sprintf(EMAIL_COUPON_REDEEM, ''));
      $html_msg['COUPON_CODE']  = $coupon->fields['coupon_code'] . $text_coupon_help;
    } //endif coupon

    if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
      $coupon_code = zen_create_coupon_code();
      $insert_query = $db->Execute("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");
      $insert_id = $db->Insert_ID();
      $db->Execute("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $email_address . "', now() )");

      // if on, add in GV explanation
      $email_text .= "\n\n" . sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) .
      sprintf(EMAIL_GV_REDEEM, $coupon_code) .
      EMAIL_GV_LINK . zen_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false) . "\n\n" .
      EMAIL_GV_LINK_OTHER . EMAIL_SEPARATOR;
      $html_msg['GV_WORTH'] = str_replace('\n','',sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) );
      $html_msg['GV_REDEEM'] = str_replace('\n','',str_replace('\n\n','<br />',sprintf(EMAIL_GV_REDEEM, '<strong>' . $coupon_code . '</strong>')));
      $html_msg['GV_CODE_NUM'] = $coupon_code;
      $html_msg['GV_CODE_URL'] = str_replace('\n','',EMAIL_GV_LINK . '<a href="' . zen_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false) . '">' . TEXT_GV_NAME . ': ' . $coupon_code . '</a>');
      $html_msg['GV_LINK_OTHER'] = EMAIL_GV_LINK_OTHER;
    } // endif voucher

    // add in regular email welcome text
    $email_text .= "\n\n"  . EMAIL_TEXT . EMAIL_CONTACT  . EMAIL_GV_CLOSURE;

    $html_msg['EMAIL_MESSAGE_HTML']  = str_replace('\n','',EMAIL_TEXT);
    $html_msg['EMAIL_CONTACT_OWNER'] = str_replace('\n','',EMAIL_CONTACT);
    
    $html_msg['EMAIL_CLOSURE']       = nl2br(EMAIL_GV_CLOSURE);

      $html_msg['TEXT_EMAIL_NEWSLETTER'] = TEXT_EMAIL_NEWSLETTER;
      $email_order .= TEXT_EMAIL_NEWSLETTER;

    // include create-account-specific disclaimer
    $email_text .= "\n\n" . sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS). "\n\n";
    $html_msg['EMAIL_DISCLAIMER'] = sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS .' </a>');

  	// send welcome email
    zen_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome');
    
    $db->Execute('INSERT INTO ' . TABLE_CHECK_EMAIL_RESULT . ' (`email_address`, `create_date`) VALUES ("' . $email_address . '", "' . date('Y-m-d H:i:s') . '")');

    // send additional emails
    if (SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS == '1' and SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO !='') {
      if ($_SESSION['customer_id']) {
        $account_query = "select customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_fax
                            from " . TABLE_CUSTOMERS . "
                            where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

        $account = $db->Execute($account_query);
      }

      $extra_info=email_collect_extra_info('',$email_address, $account->fields['customers_firstname'] . ' ' . $account->fields['customers_lastname'], $account->fields['customers_email_address'], $account->fields['customers_telephone'], $account->fields['customers_fax']);
      $html_msg['EXTRA_INFO'] = $extra_info['HTML'];
      zen_mail($name, SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO, SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT . ' ' . EMAIL_SUBJECT,
      $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'welcome_extra');
    } //endif send extra emails

    /*
    chimp_robbie wei
    $email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT'); deal this
    */
	/*$subscribe = true;
	if(stristr($email_address,'163.com') || stristr($email_address,'126.com')
					|| stristr($email_address,'qq.com')
					|| stristr($email_address,'sina.com.cn')
					|| stristr($email_address,'sina.cn')
					|| stristr($email_address,'139.com')
					|| stristr($email_address,'souhu.com')
					|| stristr($email_address,'tom.com')){
					$subscribe = false;
	}*/
	$db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '3',".$_SESSION['languages_id'].");");
    //if ($newsletter && $subscribe) {
    	if (isset($_POST['action']) && ($_POST['action'] == 'process'))
    	{

        $subscribe_param = array(
          'firstname' => $firstname,
          'lastname' => ''
        );

        if ($newsletter) {
            $event_type = 10;
            $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param );
        }else{
            $event_type = 20;
            $check_mailchimp_email_query = $db->Execute("SELECT * FROM ". TABLE_CUSTOMERS_FOR_MAILCHIMP. " WHERE customers_for_mailchimp_email = '" . $email_address . "'");
            if ($check_mailchimp_email_query->RecordCount() > 0) {
              $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param );
            }
        }

        
    	/*$api = new MCAPI ( $apikey );
				if ($api->errorCode != '') {
					// an error occurred while logging in
					//echo "code:" . $api->errorCode . "\n";
					//echo "msg :" . $api->errorMessage . "\n";
					//die ();
				}		
				$optin = false; //yes, send optin emails
				$up_exist = true; // yes, update currently subscribed users
				$replace_int = false; // no, add interest, don't replace
				$groupings = $api->listInterestGroupings ( $listId );	
				$user_comes_from=$checkIpAddress->countryCode;
				$shielding_ips=array('CN');
				$chinese_people=in_array($user_comes_from,$shielding_ips)?true:false;
				
				$lan = $chinese_people ? 1 : 0;
				
				$groups = $groupings [$lan] ["groups"];
				$grouping_id = $groupings[$lan]['id'];//exit;
				$grouplength = sizeof ( $groups );
				$currentgroup = $groups [$grouplength - 1];
				//Adding group if the last group subscriber exceeds 3000
				if ($currentgroup ['subscribers'] >= $grouplimit) {
					$partno = $grouplength + 1;
					$group_name = 'Part-' .$_SESSION['languages_code'].'-'. $partno;
					
					if ($api->listInterestGroupAdd ( $listId, $group_name, $grouping_id )) {
						$grouplength += 1;
					} else if ($api->errorCode) {
						echo "Batch Subscribe failed!\n";
						echo "code:" . $api->errorCode . "\n";
						echo "msg :" . $api->errorMessage . "\n";
						die ();
					}
					
				}
				$partno = $grouplength;
				if($chinese_people){
					if($partno==1){
						$group = array (array ('id' => $grouping_id, 'groups' => 'Normal') );
					}else{
						$group = array (array ('id' => $grouping_id, 'groups' => 'Normal-'. $partno ) );
					}
				}else{
					    $group = array (array ('id' => $grouping_id, 'groups' => 'Part-' .$_SESSION['languages_code'].'-1') );
				}
				$batch [0] = array ('EMAIL' => $email_address, 'FNAME' => $firstname, 'LNAME' => $lastname, 'GROUPINGS' => $group );
				$vals = $api->listBatchSubscribe ( $listId, $batch, $optin, $up_exist, $replace_int );
				if ($api->errorCode) {
					//echo "Batch Subscribe failed!\n";
					//echo "code:" . $api->errorCode . "\n";
					//echo "msg :" . $api->errorMessage . "\n";
					//die ();
				}*/
    	}
    //}
    //end
    zen_redirect(zen_href_link('welcome', 'src=register', 'SSL'));

  } //endif !error
}


// This should be last line of the script:
$zco_notifier->notify('NOTIFY_MODULE_END_CREATE_ACCOUNT');
?>