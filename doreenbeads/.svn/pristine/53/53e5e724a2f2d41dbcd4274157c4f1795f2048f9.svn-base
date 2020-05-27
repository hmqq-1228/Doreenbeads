<?php
/**
 * session handling
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_sessions.php 5164 2006-12-10 19:01:25Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * require the session handling functions
 */
require(DIR_WS_FUNCTIONS . 'sessions.php');
/**
 * set the session name and save path
 */
zen_session_name('zenid');
zen_session_save_path(SESSION_WRITE_DIRECTORY);
/**
 * set the session cookie parameters
 */
//session_set_cookie_params(0, '/', (zen_not_null($current_domain) ? $current_domain : ''));
session_set_cookie_params(7200, '/', '.' . BASE_SITE);
zen_setcookie('zenid', $_COOKIE['zenid'], time() + 7200, '/', '.' . BASE_SITE);//Tianwen.Wan20160323->类似session永远是当前的时间往后推2个小时
/**
 * set the session ID if it exists
 */
if (isset($_POST[zen_session_name()])) {
  zen_session_id($_POST[zen_session_name()]);
} elseif ( ($request_type == 'SSL') && isset($_GET[zen_session_name()]) ) {
  zen_session_id($_GET[zen_session_name()]);
}
/**
 * need to tidy up $_SERVER['REMOTE_ADDR'] here beofre we use it any where else
 * one problem we don't address here is if $_SERVER['REMOTE_ADDRESS'] is not set to anything at all
 */
$ipAddressArray = explode(',', $_SERVER['REMOTE_ADDR']);
$ipAddress = (sizeof($ipAddressArray) > 0) ? $ipAddressArray[0] : '';
$_SERVER['REMOTE_ADDR'] = $ipAddress;
/**
 * start the session
 */
$session_started = false;
if (SESSION_FORCE_COOKIE_USE == 'True') {
  zen_setcookie('cookie_test', 'please_accept_for_session', time()+60*60*24*30, '/', '.' . BASE_SITE);
  $_COOKIE['cookie_test'] = 'please_accept_for_session';	//	xiaoyong.lv 20150801 cookie can be read only when page reloaded, so we must set it.
  if (isset($_COOKIE['cookie_test'])) {
    zen_session_start();
    $session_started = true;
  }
} elseif (SESSION_BLOCK_SPIDERS == 'True') {
  $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
  $spider_flag = false;
  if (zen_not_null($user_agent)) {
    $spiders = file(DIR_WS_INCLUDES . 'spiders.txt');
    for ($i=0, $n=sizeof($spiders); $i<$n; $i++) {
      if (zen_not_null($spiders[$i])) {
        if (is_integer(strpos($user_agent, trim($spiders[$i])))) {
          $spider_flag = true;
          break;
        }
      }
    }
  }
  if ($spider_flag == false) {
    zen_session_start();
    $session_started = true;
  }
} else {
  zen_session_start();
  $session_started = true;
}
/**
 * set host_address once per session to reduce load on server
 */
if (!isset($_SESSION['customers_host_address'])) {
  if (SESSION_IP_TO_HOST_ADDRESS == 'true') {
    $_SESSION['customers_host_address']= @gethostbyaddr($_SERVER['REMOTE_ADDR']);
  } else {
    $_SESSION['customers_host_address'] = OFFICE_IP_TO_HOST_ADDRESS;
  }
}
/**
 * verify the ssl_session_id if the feature is enabled
 */
if ( ($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == 'true') && ($session_started == true) ) {
  $ssl_session_id = $_SERVER['SSL_SESSION_ID'];
  if (!$_SESSION['SSL_SESSION_ID']) {
    $_SESSION['SSL_SESSION_ID'] = $ssl_session_id;
  }
  if ($_SESSION['SSL_SESSION_ID'] != $ssl_session_id) {
    zen_session_destroy();
    zen_redirect(zen_href_link(FILENAME_SSL_CHECK));
  }
}
/**
 * verify the browser user agent if the feature is enabled
 */
if (SESSION_CHECK_USER_AGENT == 'True') {
  $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
  if (!$_SESSION['SESSION_USER_AGENT']) {
    $_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
  }
  if ($_SESSION['SESSION_USER_AGENT'] != $http_user_agent) {
    zen_session_destroy();
    zen_redirect(zen_href_link(FILENAME_LOGIN));
  }
}
/**
 * verify the IP address if the feature is enabled
 */
if (SESSION_CHECK_IP_ADDRESS == 'True') {
  $ip_address = zen_get_ip_address();
  if (!$_SESSION['SESSION_IP_ADDRESS']) {
    $_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
  }
  if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
    zen_session_destroy();
    zen_redirect(zen_href_link(FILENAME_LOGIN));
  }
}


////robbie
if (PERMANENT_LOGIN == 'true' && substr_count($_COOKIE["zencart_cookie_autologin"], "~~~") > 1) {
	if (empty($_SESSION['customer_id'])) {
		$c = explode("~~~", $_COOKIE["zencart_cookie_autologin"]);

		$q = "SELECT customers_password, customers_email_address FROM " . TABLE_CUSTOMERS . " WHERE customers_id=" . $c[0];
		$r = $db->Execute($q);

		$pw_cookie = zen_db_prepare_input($c[7]);
		$pw_zencart = $r->fields['customers_password'];

		$auto_login_success = "Auto login failed";
		if ((isset($_COOKIE['zencart_cookie_validate_email']) && $_COOKIE['zencart_cookie_validate_email'] == md5($r->fields['customers_email_address']) && $pw_cookie == $pw_zencart) || (!isset($_COOKIE['zencart_cookie_validate_email']) && $pw_cookie == $pw_zencart)) {
			$_SESSION['customer_id'] = $c[0];
			$_SESSION['customer_default_address_id'] = $c[1];
			$_SESSION['customers_authorization'] = $c[2];
			$_SESSION['customer_first_name'] = $c[3];
			$_SESSION['customer_last_name'] = $c[4];
			$_SESSION['customer_country_id'] = $c[5];
			$_SESSION['has_valid_order'] = $c[6];
			
			$auto_login_success = "Auto login success";
			setcookie("zencart_cookie_validate_email", md5($r->fields['customers_email_address']), time() + 7776000, '/', '.' . BASE_SITE);
			
			add_customers_message($_SESSION['customer_id']);
//			$_SESSION['cart']->restore_contents();
//    		zen_redirect( zen_href_link($_GET['main_page'], zen_get_all_get_params()));
		}
		
		file_put_contents("log/auto_login/auto_login_" . date("Ymd") . ".txt", date("Y-m-d H:i:s") . "\t" . $_COOKIE["zencart_cookie_autologin"] . "\tzencart_cookie_validate_email:" . $_COOKIE["zencart_cookie_validate_email"] . "\t" . $auto_login_success  . "\t" . $_SERVER['HTTP_USER_AGENT'] . "\n", FILE_APPEND);
	}
}

if(isset($_COOKIE['zencart_cookie_validate_email']) &&  isset($_SESSION['customer_email']) && md5($_SESSION['customer_email']) != $_COOKIE['zencart_cookie_validate_email']) {
	file_put_contents("log/auto_login/email_failed_" . date("Ymd") . ".txt", date("Y-m-d H:i:s") . "\n" . var_export($_COOKIE, true) . "\n" . var_export($_SESSION, true)  . "\n" . var_export($_SERVER, true)  . "\n\n", FILE_APPEND);
	session_unset();
	zen_session_destroy();
}

if(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=''){
	$get_email = $db->Execute('Select  	customers_email_address, is_old_customers, customers_firstname,customers_lastname,customers_default_address_id,customers_group_pricing, customers_default_shipping, customers_is_rcd
								     From ' . TABLE_CUSTOMERS . '
								  Where  customers_id = ' . $_SESSION['customer_id']);
	$_SESSION['customer_email']=$get_email->fields['customers_email_address'];
	$_SESSION['customer_first_name']=$get_email->fields['customers_firstname'];
	$_SESSION['customer_last_name']=$get_email->fields['customers_lastname'];
	$_SESSION['customer_default_address_id'] = $get_email->fields['customers_default_address_id'];
	$_SESSION['customers_group_pricing'] = $get_email->fields['customers_group_pricing'];
	$_SESSION['customers_default_shipping'] = $get_email->fields['customers_default_shipping'];
	$_SESSION['customers_is_rcd'] = $get_email->fields['customers_is_rcd'];
	$_SESSION['is_old_customers'] = $get_email->fields['is_old_customers'];
	
	if(get_with_channel()){
		$_SESSION['channel'] = true;		
	}else{
		$_SESSION['channel'] = false;		
	}

}

if (strlen($_COOKIE["cookie_cart_id"]) >= 8 && empty($_SESSION['customer_id']))
	$_SESSION['cookie_cart_id'] = $_COOKIE["cookie_cart_id"];

///
///bof 2010-12-09 on
///

if(empty($_SESSION['customers_level']) or empty($_SESSION['customer_id'])) $_SESSION['customers_level'] = 0;
if ($_SESSION['customers_level'] < CUSTOMERS_TOP_LEVEL && !empty($_SESSION['customer_id'])) {
	$lds_customer_level = $db->Execute("Select customers_level
									    From " . TABLE_CUSTOMERS . "
									   Where customers_id ='" . ($_SESSION['customer_id']) . "'");
	$_SESSION['customers_level'] = $lds_customer_level->fields['customers_level'];
}
///eof 2010-12-09
//gift for Christmas
//	goodbye christmas lvxiaoyong20150707
/*
if(empty($_SESSION['customer_gift']) or empty($_SESSION['customer_id'])) $_SESSION['customer_gift'] = 0;
$_SESSION['gift_id'] = '42827';
$_SESSION['gift_model'] = 'T03382';
if (!empty($_SESSION['customer_id'])) {
	$lds_customer_level = $db->Execute("Select has_gift
									    From " . TABLE_CUSTOMERS . "
									   Where customers_id ='" . ($_SESSION['customer_id']) . "'");
	$_SESSION['customer_gift'] = $lds_customer_level->fields['has_gift'];

}
*/

$per_page_num = isset($_GET['per_page']) && $_GET['per_page'] != '' ? $_GET['per_page'] : (isset($_SESSION['per_page']) && $_SESSION['per_page'] != '' ? $_SESSION['per_page'] : ITEM_PERPAGE_DEFAULT);
$_SESSION['per_page'] = $per_page_num;

if(isset($_GET['ifpc']) && $_GET['ifpc']==1 && !isset($_COOKIE['zen_ifpc'])){
	//$_SESSION['VIEW_IN_PC']=1;
	zen_setcookie('zen_ifpc', '1', time() + (86400 * 7), '/', '.' . BASE_SITE);
}
?>
