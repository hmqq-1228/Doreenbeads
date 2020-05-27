<?php
require ('includes/application_top.php');

$helper = $facebook->getRedirectLoginHelper();

//	get accessToken
try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

//	get user
try {
	$response = $facebook->get('/me?fields=id,email,first_name,last_name', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}
$user = $response->getGraphUser();

	if(empty($user['email'])){
		$messageStack->add_session('login', 'Login failed because you have not set an email address,or you have not set you email address public.<br/>Set this via Privacy Checkup->Your Profile->Email->Public on Facebook.', 'error');
		zen_redirect(zen_href_link(FILENAME_LOGIN));
	}

	$_SESSION['fb_user'] = $user;
	$user_id = $user['id'];
	$user_email_address = $user['email'];
	$_SESSION['fb_user_id'] = $user_id;
	$_SESSION['fb_email_address'] = $user_email_address;
	if($user){
		$check_sql = "SELECT customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_authorization, customers_referral,register_useragent_language FROM " . TABLE_CUSTOMERS . " WHERE customers_facebookid = :fbid";
		$check_sql = $db->bindVars($check_sql, ':fbid', $user_id, 'string');
		$check_res = $db->Execute($check_sql);
		if($check_res->RecordCount()){	//	if have bind an account, process and goto default page
			facebookLoginProcess($check_res->fields);
			echo '<script type="text/javascript">
				window.opener.location.reload();
				window.close();
				</script>';
			exit;
		}else{
			facebookRegisterProcess($user);
			echo '<script type="text/javascript">
				window.opener.location.reload();
				window.close();
				</script>';
			exit;
		}
	}else{
		echo 4; //fb账户有问题
		exit;
	}

function facebookLoginProcess($rs){
	global $db;

	$ls_old_cookie = $_SESSION['cookie_cart_id'];
	if (SESSION_RECREATE == 'True') {
		zen_session_recreate();
	}

	$check_country_query = "SELECT entry_country_id, entry_zone_id
							  FROM " . TABLE_ADDRESS_BOOK . "
							 WHERE customers_id = :customersID
								AND address_book_id = :adressBookID";
	$check_country_query = $db->bindVars($check_country_query, ':customersID', $rs['customers_id'], 'integer');
	$check_country_query = $db->bindVars($check_country_query, ':adressBookID', $rs['customers_default_address_id'], 'integer');
	$check_country = $db->Execute($check_country_query);

	$_SESSION['customer_id'] = $rs['customers_id'];
	$_SESSION['customer_default_address_id'] = $rs['customers_default_address_id'];
//	$_SESSION['has_valid_order'] = zen_customer_has_valid_order();
	$_SESSION['customers_authorization'] = $rs['customers_authorization'];
	$_SESSION['customer_first_name'] = $rs['customers_firstname'];
	$_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
	$_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];

	if($rs['customers_password'] == '') $_SESSION['customer_facebook_register'] = true;	//	从facebook登陆
	setcookie("zencart_cookie_validate_email", md5($rs['customers_email_address']), time() + 7776000, '/', '.' . BASE_SITE);
	
	add_customers_message($_SESSION ['customer_id']);

	$sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
			SET customers_info_date_of_last_logon = now(),
			customers_info_number_of_logons = customers_info_number_of_logons+1
			WHERE customers_info_id = :customersID";
	$sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
	$db->Execute($sql);

	if($ls_old_cookie) $_SESSION['cart']->restore_contents($ls_old_cookie);
	setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);

	if ($_POST["permLogin"]) {
		unset($c);
		$c[] = $_SESSION['customer_id'];
		$c[] = $_SESSION['customer_default_address_id'];
		$c[] = $_SESSION['customers_authorization'];
		$c[] = $_SESSION['customer_first_name'];
		$c[] = $_SESSION['customer_last_name'];
		$c[] = $_SESSION['customer_country_id'];
		$c[] = $_SESSION['has_valid_order'];
		$c[] = $rs['customers_password'];
		$c_str = implode("~~~", $c);
		setcookie("zencart_cookie_autologin", $c_str, time() + 7776000, '/', '.' . BASE_SITE);
	}

	if (isset($_GET['test'])) {
		zen_redirect($_GET['test']);
	}else{
		zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}	
}

function facebookRegisterProcess($user){
    global $db,$fun_inviteFriends,$is_mobilesite;
	require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/mail_welcome.php');
	require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/create_account.php');
	include_once (DIR_WS_CLASSES . 'MCAPI.class.php');
	include_once (DIR_WS_CLASSES . 'config.inc');
	
	$process = false;
	$error = false;

	$email_address = zen_db_prepare_input ( $user ['email'] );
	$password = zen_encrypt_password(substr( $email_address, 0, strrpos($email_address, '@') ) . date('Ymd'));
	$gender = $user['gender'] ? $user['gender'] : 'm';
	$firstname = $user['first_name'] ? $user['first_name'] : '';
	$lastname  = $user['last_name'] ? $user['last_name'] : '';
	$ip_address = zen_get_ip_address ();
	
	$check_email_query = "select customers_id
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input ( $email_address ) . "'";
	$check_email = $db->Execute ( $check_email_query );
	if ($check_email->RecordCount() > 0) {	//	已经存在这个email了，直接绑定
		$_SESSION ['customer_id'] = $check_email->fields['customers_id'];
		$db->Execute("update ".TABLE_CUSTOMERS." set customers_facebookid= '".$user['id']."' where customers_id='" .$check_email->fields['customers_id']. "'");
	}else{	//	否则新建一个账号
	    $from_mobilesite = $is_mobilesite ? 1 : 0;
		$sql_data_array = array (
			'customers_email_address' => $email_address,
			'customers_password' => $password,
			'signin_ip' => $ip_address,
			'customers_email_format' => 'HTML',
			'customers_newsletter' => 1,
			'customers_default_address_id' => 0,
		    'from_mobile' => $from_mobilesite,
		    'register_entry'=>5//facebook注册入口
		);

		if($fun_inviteFriends->hasRefer()){
			$sql_data_array['referrer_id'] = intval($fun_inviteFriends->getRefer());
		}

		$sql_data_array1 = array (
			'customers_gender' => $gender,
			'customers_firstname' => $firstname,
			'customers_lastname'  => $lastname,
			'customers_dob' => '0001-01-01 00:00:00',
			'customers_nick' => '',
			'customers_telephone' => '',
			'customers_cell_phone' => '',
			'customers_fax' => '',
			'customers_group_pricing' => 0,
			'customers_referral' => '',
			'customers_paypal_payerid' => '',
			'customers_paypal_ec' => '',
			'customers_facebookid' => $user['id'],
			'register_languages_id' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
			'lang_preference' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
			'register_useragent_language' => $_SERVER ['HTTP_ACCEPT_LANGUAGE']
		);
		$sql_data_array = array_merge ( $sql_data_array, $sql_data_array1 );
		zen_db_perform ( TABLE_CUSTOMERS, $sql_data_array );
		$_SESSION ['customer_id'] = $db->Insert_ID ();
	
		$sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created)
              values ('" . ( int ) $_SESSION ['customer_id'] . "', '0', now())";
		$db->Execute ( $sql );

		write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $_SESSION ['customer_id'] . "\n customers_email_address: " . $email_address . "\n firstname: " . $firstname . "\n lastname: " . $lastname ."\n ip: " . zen_get_ip_address () ."\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: ". date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array) . "\n===========================================================\n\n\n");

		//create account success  send register coupon WSL
		add_coupon_code(REGISTER_COUPON_CODE, false);
		
		$name = $firstname . ' ' . $lastname;
		$email_text = sprintf(TEXT_DEAR_FN, $firstname) . ",\n\n";
		$html_msg ['EMAIL_GREETING'] = str_replace ( '\n', '', $email_text );
		$html_msg ['EMAIL_FIRST_NAME'] = $firstname;
		$html_msg ['EMAIL_LAST_NAME'] = $lastname;
		// initial welcome
		$email_text .= EMAIL_WELCOME;
		$html_msg ['EMAIL_WELCOME'] = str_replace ( '\n', '', EMAIL_WELCOME );
		
		$email_text .= EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
		$html_msg ['EMAIL_CUSTOMER_EMAILADDRESS'] = EMAIL_SEPARATOR . '<br />' . EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
		$email_text .= EMAIL_CUSTOMER_PASSWORD . $password;
		$html_msg ['EMAIL_CUSTOMER_PASSWORD'] = EMAIL_CUSTOMER_PASSWORD . $password . '<br />' . EMAIL_SEPARATOR;
		
		$email_text .= EMAIL_KINDLY_NOTE;
		$html_msg ['EMAIL_KINDLY_NOTE'] = str_replace ( '\n', '', EMAIL_KINDLY_NOTE );
		$email_text .= EMAIL_CUSTOMER_REG_DESCRIPTION;
		$html_msg ['EMAIL_CUSTOMER_REG_DESCRIPTION'] = EMAIL_CUSTOMER_REG_DESCRIPTION;
		
		if (NEW_SIGNUP_DISCOUNT_COUPON != '' and NEW_SIGNUP_DISCOUNT_COUPON != '0') {
			$coupon_id = NEW_SIGNUP_DISCOUNT_COUPON;
			$coupon = $db->Execute ( "select * from " . TABLE_COUPONS . " where coupon_id = '" . $coupon_id . "'" );
			$coupon_desc = $db->Execute ( "select coupon_description from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . $_SESSION ['languages_id'] . "'" );
			$db->Execute ( "insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id . "', '0', 'Admin', '" . $email_address . "', now() )" );
			
			$text_coupon_help = sprintf ( TEXT_COUPON_HELP_DATE, zen_date_short ( $coupon->fields ['coupon_start_date'] ), zen_date_short ( $coupon->fields ['coupon_expire_date'] ) );
			
			$email_text .= "\n" . EMAIL_COUPON_INCENTIVE_HEADER . (! empty ( $coupon_desc->fields ['coupon_description'] ) ? $coupon_desc->fields ['coupon_description'] . "\n\n" : '') . $text_coupon_help . "\n\n" . strip_tags ( sprintf ( EMAIL_COUPON_REDEEM, ' ' . $coupon->fields ['coupon_code'] ) ) . EMAIL_SEPARATOR;
			
			$html_msg ['COUPON_TEXT_VOUCHER_IS'] = EMAIL_COUPON_INCENTIVE_HEADER;
			$html_msg ['COUPON_DESCRIPTION'] = (! empty ( $coupon_desc->fields ['coupon_description'] ) ? '<strong>' . $coupon_desc->fields ['coupon_description'] . '</strong>' : '');
			$html_msg ['COUPON_TEXT_TO_REDEEM'] = str_replace ( "\n", '', sprintf ( EMAIL_COUPON_REDEEM, '' ) );
			$html_msg ['COUPON_CODE'] = $coupon->fields ['coupon_code'] . $text_coupon_help;
		} // endif coupon
		
		if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
			$coupon_code = zen_create_coupon_code ();
			$insert_query = $db->Execute ( "insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())" );
			$insert_id = $db->Insert_ID ();
			$db->Execute ( "insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id . "', '0', 'Admin', '" . $email_address . "', now() )" );
			$email_text .= "\n\n" . sprintf ( EMAIL_GV_INCENTIVE_HEADER, $currencies->format ( NEW_SIGNUP_GIFT_VOUCHER_AMOUNT ) ) . sprintf ( EMAIL_GV_REDEEM, $coupon_code ) . EMAIL_GV_LINK . zen_href_link ( FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false ) . "\n\n" . EMAIL_GV_LINK_OTHER . EMAIL_SEPARATOR;
			$html_msg ['GV_WORTH'] = str_replace ( '\n', '', sprintf ( EMAIL_GV_INCENTIVE_HEADER, $currencies->format ( NEW_SIGNUP_GIFT_VOUCHER_AMOUNT ) ) );
			$html_msg ['GV_REDEEM'] = str_replace ( '\n', '', str_replace ( '\n\n', '<br />', sprintf ( EMAIL_GV_REDEEM, '<strong>' . $coupon_code . '</strong>' ) ) );
			$html_msg ['GV_CODE_NUM'] = $coupon_code;
			$html_msg ['GV_CODE_URL'] = str_replace ( '\n', '', EMAIL_GV_LINK . '<a href="' . zen_href_link ( FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false ) . '">' . TEXT_GV_NAME . ': ' . $coupon_code . '</a>' );
			$html_msg ['GV_LINK_OTHER'] = EMAIL_GV_LINK_OTHER;
		} // endif voucher
		  
		// add in regular email welcome text
		$email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;
		
		$html_msg ['EMAIL_MESSAGE_HTML'] = str_replace ( '\n', '', EMAIL_TEXT );
		$html_msg ['EMAIL_CONTACT_OWNER'] = str_replace ( '\n', '', EMAIL_CONTACT );
		
		$html_msg ['EMAIL_CLOSURE'] = nl2br ( EMAIL_GV_CLOSURE );
		
		// include create-account-specific disclaimer
		$email_text .= "\n\n" . sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS ) . "\n\n";
		$html_msg ['EMAIL_DISCLAIMER'] = sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . ' </a>' );
		
		// send welcome email
		zen_mail ( $name, $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome' );
		
		// send additional emails
		if (SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS == '1' and SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO != '') {
			if ($_SESSION ['customer_id']) {
				$account_query = "select customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_fax
                            from " . TABLE_CUSTOMERS . "
                            where customers_id = '" . ( int ) $_SESSION ['customer_id'] . "'";
				
				$account = $db->Execute ( $account_query );
			}
			
			$extra_info = email_collect_extra_info ( $name, $email_address, $account->fields ['customers_firstname'] . ' ' . $account->fields ['customers_lastname'], $account->fields ['customers_email_address'], $account->fields ['customers_telephone'], $account->fields ['customers_fax'] );
			$html_msg ['EXTRA_INFO'] = $extra_info ['HTML'];
			zen_mail ( '', SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO, SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT . ' ' . EMAIL_SUBJECT, $email_text . $extra_info ['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'welcome_extra' );
		} // endif send extra emails
		$subscribe = true;
		if(stristr($email_address,'163.com') || stristr($email_address,'126.com')
						|| stristr($email_address,'qq.com')
						|| stristr($email_address,'sina.com.cn')
						|| stristr($email_address,'sina.cn')
						|| stristr($email_address,'139.com')
						|| stristr($email_address,'souhu.com')
						|| stristr($email_address,'tom.com')){
						$subscribe = false;
		}
		$db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '2',".$_SESSION['languages_id'].");");
		if (1) {
			if (isset ( $_POST ['action'] ) && ($_POST ['action'] == 'create')) {
				$api = new MCAPI ( $apikey );
				if ($api->errorCode != '') {
					// an error occurred while logging in
					//echo "code:" . $api->errorCode . "\n";
					//echo "msg :" . $api->errorMessage . "\n";
					//die ();
				}
				$optin = false; // yes, send optin emails
				$up_exist = true; // yes, update currently subscribed users
				$replace_int = true; // no, add interest, don't replace
				$vals = $api->listInterestGroupings ( $listId );
				$lan = $_SESSION ["languages_id"] - 1;
				$groups = $vals [$lan] ["groups"];
				$groupings = $api->listInterestGroupings ( $listId );
				$grouping_id = $groupings [$lan] ['id']; // exit;
				                                         // echo $grouping_id ;
				$grouplength = sizeof ( $groups );
				$currentgroup = $groups [$grouplength - 1];
				// var_dump($currentgroup);exit;
				// Adding group if the last group subscriber exceeds 3000
				if ($currentgroup ['subscribers'] >= $grouplimit) {
					$partno = $grouplength + 1;
					$group_name = 'Part-' . $_SESSION ['languages_code'] . '-' . $partno;
				}
				$partno = $grouplength;
				$group = array (
						array (
								'id' => $grouping_id,
								'groups' => 'Part-' . $_SESSION ['languages_code'] . '-1' 
						) 
				);
				$batch [0] = array (
						'EMAIL' => $email_address,
						'FNAME' => $firstname,
					 	'LNAME' => $lastname,
						'GROUPINGS' => $group 
				);
				$vals = $api->listBatchSubscribe ( $listId, $batch, $optin, $up_exist, $replace_int );
				if ($api->errorCode) {
				}
			}
		}
	}

	$create_sql = "SELECT customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_authorization, customers_referral,register_useragent_language FROM " . TABLE_CUSTOMERS . " WHERE customers_id = :customers_id";
	$create_sql = $db->bindVars($create_sql, ':customers_id', $_SESSION ['customer_id'], 'integer');
	$create_res = $db->Execute($create_sql);
	facebookLoginProcess($create_res->fields);
}
?>
