<?php
/**
 * Time out page
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6350 2007-05-20 21:00:41Z drbyte $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_LOGIN');
$zco_notifier->notify('NOTIFY_HEADER_START_LOGIN_TIMEOUT');

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));


$link = zen_href_link(FILENAME_LOGIN,'','SSL');
$smarty->assign('link',$link);

$breadcrumb->add(NAVBAR_TITLE);
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_LOGIN_TIMEOUT');
$zco_notifier->notify('NOTIFY_HEADER_END_LOGIN');
?>