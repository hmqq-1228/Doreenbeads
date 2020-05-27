<?php
/**
 * initialise language handling
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @todo ICW(SECURITY) is it worth having a sanitizer for $_GET['language'] ?
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_languages.php 2753 2005-12-31 19:17:17Z wilt $
 */
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
global $db;

if(!isset($_COOKIE['zenlanguage_code'])) {
	setcookie("zenlanguage_code", 'en', time() + 31536000, '/', '.'.BASE_SITE);
}

$lang_preference_code= "en";
if (isset ( $_SESSION ["customer_id"] )) {
	$get_sql = "select c.lang_preference , c.register_languages_id, l.code from  " . TABLE_CUSTOMERS . " c inner join " . TABLE_LANGUAGES . " l on l.languages_id = c.lang_preference where customers_id = " . $_SESSION ["customer_id"];
	$get_lang = $db->Execute ( $get_sql );
	if (isset($get_lang->fields['register_languages_id']) && isset($get_lang->fields['register_languages_id'])) {
		$_SESSION ['register_languages_id'] = $get_lang->fields["register_languages_id"];
		$lang_preference_code = $_SESSION['languages_code'] = $get_lang->fields["code"];
	}
} 


$lngs = new language();
$lngs->set_language($lang_preference_code);
$_SESSION ['lng'] = $lngs;
$_SESSION ['language'] = (zen_not_null ( $lngs->language ['directory'] ) ? $lngs->language ['directory'] : 'english');
$_SESSION ['languages_id'] = (zen_not_null ( $lngs->language ['id'] ) ? $lngs->language ['id'] : 1);
$_SESSION ['languages_code'] = (zen_not_null ( $lngs->language ['code'] ) ? $lngs->language ['code'] : 'en');

if(isset($_COOKIE['zenchange_language']) && !empty($_COOKIE['zenchange_language'])) {
	if(isset($_SESSION['customer_id'])){
		if($_COOKIE['zenchange_language'] != $_SESSION['languages_code'] && !empty($lngs->catalog_languages[$_COOKIE['zenchange_language']]['id'])){
			$set_sql = "update ".TABLE_CUSTOMERS." set lang_preference = " . $lngs->catalog_languages[$_COOKIE['zenchange_language']]['id'] . " where customers_id = ".$_SESSION["customer_id"];
			$set_lang = $db->Execute($set_sql);
		}
	}
	$lngs = new language();
	$lngs->set_language($_COOKIE['zenchange_language']);
	$_SESSION['lng'] = $lngs;

	$_SESSION['language'] = zen_not_null($lngs->language['directory']) ? $lngs->language['directory'] : 'english';
	$_SESSION['languages_id'] = zen_not_null($lngs->language['id']) ? $lngs->language['id'] : 1;
	$_SESSION['languages_code'] = zen_not_null($lngs->language['code']) ? $lngs->language['code'] : 'en';
	setcookie("zenlanguage_code", $_SESSION['languages_code'], time() + 31536000, '/', '.'.BASE_SITE);
	
}

if(empty($_SESSION['customer_id'])) {
	$lang_prefix = explode("/", $_SERVER['REQUEST_URI']);
	if(isset($lngs->catalog_languages[$_COOKIE['zenchange_language']])) {
		$lang_preference_code = $_COOKIE['zenchange_language'];
		setcookie("zenchange_language", "", time() - 31536000, '/', '.'.BASE_SITE);
	} else if(isset($lngs->catalog_languages[$lang_prefix[1]])) {
		$lang_preference_code = $lang_prefix[1];
	} else if(isset($lngs->catalog_languages[$_COOKIE['zenlanguage_code']])) {
		$lang_preference_code = $_COOKIE['zenlanguage_code'];
	}
	
	if(!empty($lang_preference_code) && $lang_preference_code != $_SESSION['languages_code']) {
		$lngs = new language();
		$lngs->set_language($lang_preference_code);
		$_SESSION['lng'] = $lngs;
		
		$_SESSION['language'] = zen_not_null($lngs->language['directory']) ? $lngs->language['directory'] : 'english';
		$_SESSION['languages_id'] = zen_not_null($lngs->language['id']) ? $lngs->language['id'] : 1;
		$_SESSION['languages_code'] = zen_not_null($lngs->language['code']) ? $lngs->language['code'] : 'en';
		setcookie("zenlanguage_code", $_SESSION['languages_code'], time() + 31536000, '/', '.'.BASE_SITE);
	}
}

if ($_COOKIE ['linkedin'] == 1) {
	$_SESSION ['linkedin'] = 1;
}

//	mobile site. only english. xiaoyong.lv
/*if($is_mobilesite){
	$_SESSION ['language'] = 'english';
	$_SESSION ['languages_id'] = 1;
	$_SESSION ['languages_code'] = 'en';
}*/ 

$match_code = $_SESSION['languages_code'] == 'en' ? BASE_SITE . $_SERVER ['REQUEST_URI'] : '/' . $_SESSION['languages_code'];
if (sizeof ( $_POST ) == 0 && strpos ( BASE_SITE . $_SERVER ['REQUEST_URI'], $match_code ) === false && strpos ( $_SERVER ['REQUEST_URI'], 'show_cart_terms' ) === false && strpos ( $_SERVER ['REQUEST_URI'], 'check_code' ) === false && strpos ( $_SERVER ['REQUEST_URI'], 'returnUrl' ) === false && strpos ( $_SERVER ['REQUEST_URI'], 'invoice' ) === false && isset ( $_GET ['main_page'] )) {
	$redirect_url = zen_href_link($_GET ['main_page'], zen_get_all_get_params (), 'NONSSL', false, true, false, true, $_SESSION['languages_code']);
	zen_redirect($redirect_url, '', 'SSL');
}

foreach($notification_email_array as $key => $val){
	switch ($_SESSION['language']){
		case 'german' : define($key, "notification_de" . strstr($val, "@")); break;
		case 'russian' : define($key, "notification_ru" . strstr($val, "@")); break;
		case 'french' : define($key, "notification_fr" . strstr($val, "@")); break;
		case 'spanish' : define($key, "notification_es" . strstr($val, "@")); break;
		case 'japanese' : define($key, "notification_jp" . strstr($val, "@")); break;
		case 'italian' : define($key, "notification_it" . strstr($val, "@")); break;
		default : define($key, $val); break;
	}
}
?>