<?php
/**
 * register_successfully header_php.php
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
include_once(DIR_WS_CLASSES . 'MCAPI.class.php');
include_once(DIR_WS_CLASSES . 'config.inc'); //contains username & password
//end
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/mail_welcome.php');
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/create_account.php');
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$smarty->assign('homepage_href', zen_href_link(FILENAME_DEFAULT));
$smarty->assign('discount_policy_href', HTTP_FULLSITE_SERVER . '/index.php?main_page=help_center&id=65');
$smarty->assign('my_account_href', zen_href_link(FILENAME_MYACCOUNT));
$smarty->assign('new_arrivals_href', HTTP_SERVER . '/index.php?main_page=products_common_list&pn=new');

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_MODULE_END_CREATE_ACCOUNT');
?>