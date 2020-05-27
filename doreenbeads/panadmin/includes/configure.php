<?php
/**
 * @package Configuration Settings circa 1.3.8
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */


/*************** NOTE: This file is similar, but DIFFERENT from the "store" version of configure.php. ***********/
/***************       The 2 files should be kept separate and not used to overwrite each other.      ***********/

// Define the webserver and path parameters
  // Main webserver: eg-http://www.your_domain.com - 
  // HTTP_SERVER is your Main webserver: eg-http://www.your_domain.com
  // HTTPS_SERVER is your Secure webserver: eg-https://www.your_domain.com
  // HTTP_CATALOG_SERVER is your Main webserver: eg-http://www.your_domain.com
  // HTTPS_CATALOG_SERVER is your Secure webserver: eg-https://www.your_domain.com
  /* 
   * URLs for your site will be built via:  
   *     HTTP_SERVER plus DIR_WS_ADMIN or
   *     HTTPS_SERVER plus DIR_WS_HTTPS_ADMIN or 
   *     HTTP_SERVER plus DIR_WS_CATALOG or 
   *     HTTPS_SERVER plus DIR_WS_HTTPS_CATALOG
   * ...depending on your system configuration settings
   *
   * If you desire your *entire* admin to be SSL-protected, make sure you use a "https:" URL for all 4 of the following:
   */
  date_default_timezone_set('PRC');
//   define('HTTP_SERVER', 'http://www.dorabeads.com');
//   define('HTTPS_SERVER', 'http://www.dorabeads.com');
//   define('HTTP_CATALOG_SERVER', 'http://www.dorabeads.com');
//   define('HTTPS_CATALOG_SERVER', 'http://www.dorabeads.com');
  define('HTTP_SERVER', 'http://www.doreenbeadslocal.com'); 
  define('HTTPS_SERVER', 'http://www.doreenbeadslocal.com');
  define('HTTP_CATALOG_SERVER', 'http://www.doreenbeadslocal.com');
  define('HTTPS_CATALOG_SERVER', 'http://www.doreenbeadslocal.com');

  // Use secure webserver for catalog module and/or admin areas?
  define('ENABLE_SSL_CATALOG', 'false');
  define('ENABLE_SSL_ADMIN', 'false');
  define('HTTP_IMG_SERVER', 'http://www.doreenbeadslocal.com/');

  //define('MEMCACHE_HOST', '127.0.0.1');
  //define('MEMCACHE_PORT', '11211');
define('WEBSITE_CODE', 30);
  
  define('MEMCACHE_HOST', '10.2.1.167');
  define('MEMCACHE_PORT', '11211');
  define('MEMCACHE_PREFIX', 'dorabeads_');
  
// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
  // these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
  define('DIR_WS_ADMIN', '/panadmin/');
  define('DIR_WS_CATALOG', '/');
  define('DIR_WS_HTTPS_ADMIN', '/panadmin/');
  define('DIR_WS_HTTPS_CATALOG', '/');

  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_CATALOG_IMAGES', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'images/');
  define('DIR_WS_CATALOG_TEMPLATE', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'includes/templates/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_CATALOG_LANGUAGES', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'includes/languages/');

// * DIR_FS_* = Filesystem directories (local/physical)
  //the following path is a COMPLETE path to your Zen Cart files. eg: /var/www/vhost/accountname/public_html/store/
  define('DIR_FS_ADMIN', 'e:/www/doreenbeads/panadmin/');
  define('DIR_FS_CATALOG', 'e:/www/doreenbeads/');

  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_CATALOG_TEMPLATES', DIR_FS_CATALOG . 'includes/templates/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');
  define('DIR_FS_EMAIL_TEMPLATES', DIR_FS_CATALOG . 'email/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');

// define our database connection
  define('DB_TYPE', 'mysql');
  define('DB_PREFIX', 't_');
  define('DB_SERVER', '10.2.1.167');
  $db_user_array[] = 'dorabeads_8admin';
  $db_user_array[] = 'dorabeads_9admin';
  $db_user = array_rand($db_user_array);
  //echo 'user:' .$db_user;
  //define('DB_SERVER_USERNAME', $db_user_array[$db_user]);
  //define('DB_SERVER_PASSWORD', 'Jiangbin_XLS%');
  define('DB_SERVER_USERNAME', 'root');
  define('DB_SERVER_PASSWORD', 'pan195013');
  define('DB_DATABASE', 'doreenbeads_20181019');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'db');
  // for STORE_SESSIONS, use 'db' for best support, or '' for file-based storage
  define('DB_SERVER_SLAVE', '10.2.1.167');
  define('DB_SERVER_USERNAME_SLAVE', 'root');
  define('DB_SERVER_PASSWORD_SLAVE', 'pan195013');
  define('DB_DATABASE_SLAVE', 'doreenbeads_20181019');
  
  define('DB_SERVER_EXPORT', '10.2.1.167');
  define('DB_SERVER_USERNAME_EXPORT', 'root');
  define('DB_SERVER_PASSWORD_EXPORT', 'pan195013');
  define('DB_DATABASE_EXPORT', 'doreenbeads_export');
  
  define('DB_SERVER_IP', '10.2.1.167');
  define('DB_SERVER_USERNAME_IP', 'root');
  define('DB_SERVER_PASSWORD_IP', 'pan195013');
  define('DB_DATABASE_IP', 'ip2location');
  
  /*define('DB_SERVER_SLAVE', '69.64.82.192');
  define('DB_SERVER_USERNAME_SLAVE', 'feiyao');
  define('DB_SERVER_PASSWORD_SLAVE', 'feiyao20150811');
  define('DB_DATABASE_SLAVE', 'dorabeads');*/
  // The next 2 "defines" are for SQL cache support.
  // For SQL_CACHE_METHOD, you can select from:  none, database, or file
  // If you choose "file", then you need to set the DIR_FS_SQL_CACHE to a directory where your apache 
  // or webserver user has write privileges (chmod 666 or 777). We recommend using the "cache" folder inside the Zen Cart folder
  // ie: /path/to/your/webspace/public_html/zen/cache   -- leave no trailing slash  
  define('SQL_CACHE_METHOD', 'database'); 
  define('DIR_FS_SQL_CACHE', 'e:/www/doreenbeads/cache');

define('CURRENCY_API_KEY', '51043');
define('CURRENCY_API_SIGN', '4b9516cd4f437bf5a6cb9b3846a161d4');

// EOF
?>