<?php
/**
 * checkout_success header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6373 2007-05-25 20:22:34Z drbyte $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_SUCCESS');
$flag_disable_header = false;
$flag_disable_left = true;
$flag_disable_right = true;
$flag_disable_footer = true;
// if the customer is not logged on, redirect them to the shopping cart page
//$breadcrumb->add(NAVBAR_TITLE_1);
//$breadcrumb->add(NAVBAR_TITLE_2);
// find out the last order number generated for this customer account
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_SUCCESS');
?>
