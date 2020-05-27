<?php
/**
 * page_not_found header_php.php 
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6288 2007-05-09 04:29:00Z drbyte $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_PAGE_NOT_FOUND');

// tell the browser that this page is showing as a result of a 404 error:
header('HTTP/1.1 404 Not Found');

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'site_map.php');
// include template-specific file name defines
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PAGE_NOT_FOUND, 'false');
$define_page_system_page_baner = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_SYSTEM_PAGE_BANNER, 'false');

//记录无效链接
record_valid_url();
//eof

$breadcrumb->add(NAVBAR_TITLE);


// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_PAGE_NOT_FOUND');
?>