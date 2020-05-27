<?php
/**
 * Checkout Process Page 
 * 
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4276 2006-08-26 03:18:28Z drbyte $
 */ 
// This should be first line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_PROCESS');

  require(DIR_WS_MODULES . zen_get_module_directory('checkout_process.php'));
 
  //2010-12-01 on
  //change cod to paypalmanually
  $pay_ment = $_SESSION['payment'];
  //eof
// load the after_process function from the payment modules
  $payment_modules->after_process();
  $zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES');

  $_SESSION['cart']->reset(true);

// unregister session variables used during checkout
  unset($_SESSION['sendto']);
  unset($_SESSION['billto']);
  //unset($_SESSION['shipping']);
  //unset($_SESSION['payment']);
  unset($_SESSION['comments']);
  unset($_SESSION['current_used_cash']);
  $order_total_modules->clear_posts();//ICW ADDED FOR CREDIT CLASS SYSTEM
	$return_account_order_id = $_SESSION['order_number_created'];
	//unset($_SESSION['order_number_created']);
  // This should be before the zen_redirect:
  $zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_PROCESS');

//paypal_offline
//2010-12-01 on
//change cod to paypalmanually
if($pay_ment == 'cod') $pay_ment = 'paypalmanually';

$auto_close_str = "";
if(empty($_SESSION['paid_by_ec']) && $pay_ment == "paypalwpp") {
	$auto_close_str = "auto_close=true";
}

if($pay_ment == 'paypalmanually')
{
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'payment=paypalmanually&' . $auto_close_str, 'SSL'));  
}
else
{
	if($_SESSION['payment_return_account']){
		zen_redirect(zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $return_account_order_id . '&' .$auto_close_str, 'SSL'));
	}else{
		zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, $auto_close_str, 'SSL'));
	}
}
//eof 

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>