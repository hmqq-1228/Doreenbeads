<?php
/**
* @package Configuration Settings circa 1.3.8
* @copyright Copyright 2003-2007 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
*/


/*************** NOTE: This file is similar, but DIFFERENT from the "admin" version of configure.php. ***********/
/***************       The 2 files should be kept separate and not used to overwrite each other.      ***********/

// Define the webserver and path parameters
// HTTP_SERVER is your Main webserver: eg-http://www.your_domain.com
// HTTPS_SERVER is your Secure webserver: eg-https://www.your_domain.com
date_default_timezone_set('PRC');

define('ENABLE_SSL', false);
$ssl_array = array(
    'checkout_shipping',
    'checkout_payment',
    'checkout_process',
    'checkout_success',
    'checkout_payment_address',
    'checkout','checkout_confirmation',
    'checkout_shipping_address',
    'myaccount',
    'account_newsletters',
    'cash_account',
    'my_coupon',
    'account_edit',
    'address_book',
    'account',
    'account_history_info', 		
    'order_products_snapshot',
    'login',
    'password_forgotten',
    'password_reset',
    'shopping_cart'
    );
$php_self_array = array(
    'invoice.php', 		
    'downloads.php',
    'ajax_checkout_step.php',
    'shopping_cart_process.php',
    'ajax_quick_reorder.php',
    'add_basket_note.php',
    'address_book_manager.php',
    'ajax_address_book.php',
    'ajax_create_order.php',
    'order_addcart.php',
    'payment1.php',
    'returnUrl.php'
    );
$php_multi_array = array(
    'checkCode.php',
    'ajax_facebook_login.php',
    'ajax_login.php'
    );

if(ENABLE_SSL == true){ 
    define('HTTP_SERVER', 'http://www.doreenbeadslocal.com');
    define('HTTPS_SERVER', 'https://www.doreenbeadslocal.com');
    define('HTTP_IMG_SERVER', 'http://img.doreenbeads.com/');
    define('HTTPS_IMG_SERVER', 'https://img.doreenbeads.com/');
    define('HTTP_MOBILESITE_SERVER', 'https://m.doreenbeadslocal.com');
}else{
    define('HTTP_SERVER', 'http://www.doreenbeadslocal.com');
    define('HTTPS_SERVER', 'https://www.doreenbeadslocal.com');
    define('HTTP_IMG_SERVER', 'http://img.doreenbeads.com/');
    define('HTTPS_IMG_SERVER', 'http://img.doreenbeads.com/');
    define('HTTP_MOBILESITE_SERVER', 'http://m.doreenbeadslocal.com');
}

define('BASE_SITE', 'doreenbeadslocal.com');
define('WEBSITE_CODE', 30);
define('SOLR_HOST', '10.2.1.167');
define('SOLR_PORT', '9999');

define('MEMCACHE_HOST', '10.2.1.167');
define('MEMCACHE_PORT', '11211');
define('MEMCACHE_PREFIX', 'dorabeads_');

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
// these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
define('DIR_WS_CATALOG', '/');
define('DIR_WS_HTTPS_CATALOG', '/');

define('DIR_WS_IMAGES', 'images/');
define('DIR_WS_INCLUDES', 'includes/');
define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
define('DIR_WS_DOWNLOAD_PUBLIC', DIR_WS_CATALOG . 'pub/');
define('DIR_WS_TEMPLATES', DIR_WS_INCLUDES . 'templates/');

define('WEBMONEY_POST_URL','https://ps.gcsip.nl/wdl/wdl');
define('DIR_WS_PHPBB', '/');

// * DIR_FS_* = Filesystem directories (local/physical)
//the following path is a COMPLETE path to your Zen Cart files. eg: /var/www/vhost/accountname/public_html/store/
define('DIR_FS_CATALOG', 'e:/www/doreenbeads/');

define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');
define('DIR_WS_UPLOADS', DIR_WS_IMAGES . 'uploads/');
define('DIR_FS_UPLOADS', DIR_FS_CATALOG . DIR_WS_UPLOADS);
define('DIR_FS_EMAIL_TEMPLATES', DIR_FS_CATALOG . 'email/');
define('DIR_FILE_CACHE_PATH', DIR_FS_CATALOG . 'fileCache/');

define('HTTP_ERP_URL', 'http://10.2.1.170:8092');

define('HTTP_LIVECHAT_URL', 'http://livechat.8seasons.com/phplivefinal');

// define our database connection
define('DB_TYPE', 'mysql');
define('DB_PREFIX', 't_');
define('DB_SERVER', '10.2.1.167');
$db_user_array[] = 'dorabeads_user1';
$db_user_array[] = 'dorabeads_user2';
$db_user_array[] = 'dorabeads_user3';
$db_user_array[] = 'dorabeads_user4';
$db_user_array[] = 'dorabeads_user5';
$db_user = array_rand($db_user_array);
//echo 'user:' .$db_user;
//define('DB_SERVER_USERNAME', $db_user_array[$db_user]);
//define('DB_SERVER_PASSWORD', 'Jiangbin_XLS%');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', 'pan195013');
define('DB_DATABASE', 'doreenbeads_20181019');
define('USE_PCONNECT', 'false');
define('STORE_SESSIONS', 'db'); // for STORE_SESSIONS, use 'db' for best support, or '' for file-based storage

define('DB_SERVER_IP', '10.2.1.167');
define('DB_SERVER_USERNAME_IP', 'root');
define('DB_SERVER_PASSWORD_IP', 'pan195013');
define('DB_DATABASE_IP', 'ip2location');


// The next 2 "defines" are for SQL cache support.
// For SQL_CACHE_METHOD, you can select from:  none, database, or file
// If you choose "file", then you need to set the DIR_FS_SQL_CACHE to a directory where your apache 
// or webserver user has write privileges (chmod 666 or 777). We recommend using the "cache" folder inside the Zen Cart folder
// ie: /path/to/your/webspace/public_html/zen/cache   -- leave no trailing slash  
define('SQL_CACHE_METHOD', 'database'); 
define('DIR_FS_SQL_CACHE', 'e:/www/doreenbeads/cache');

define('BRAINTREE_ENVIRONMENT', 'sandbox');
define('BRAINTREE_MERCHANTID', 'fmvwjh8kwfzpp79x');
define('BRAINTREE_PUBLICKEY', 'g6p5dyvmmy44rskk');
define('BRAINTREE_PRIVATEKEY', 'b3a34c438875c548eb1422a8481acceb');
define('BRAINTREE_MERCHANTACCOUNTID', 'hangzhoupanduo');
define('BRAINTREE_SUPPORT_CURRENCY_PREFIX', 'hangzhoupanduo_');
define('BRAINTREE_SUPPORT_CURRENCY_VALUE', ',EUR,GBP,CAD,AUD,JPY,NZD,RUB,SGD,');
define('BRAINTREE_SSL_VERSION', '6');

define('REMOTE_CHECK_USERNAME', 'pndvfyemail');
define('REMOTE_CHECK_PASSWORD', '5G8CK22lDvxymq5699');
define('REMOTE_CHECK_URL', 'http://api.verify-email.org/api.php?');
// EOF