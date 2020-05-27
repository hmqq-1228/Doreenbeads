<?php
/**
 * module to process a completed checkout
 *
 * @package procedureCheckout
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_process.php 6491 2007-06-15 07:00:52Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEGIN');

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// if the customer is not logged on, redirect them to the time out page
  if (!$_SESSION['customer_id'] || empty($_SESSION['order_number_created'])) {
    zen_redirect(zen_href_link(FILENAME_TIME_OUT));
  } else {
    // validate customer
    if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
      $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_SHIPPING));
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
    }
    // by wangyuan 2011-09-29
    if (isset($_SESSION['cart']->cartID) && $_SESSION['cartID']) {
      if ($_SESSION['cart']->cartID != $_SESSION['cartID'] && !$_SESSION['order_number_created']) {
        zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
      }
    }
    // end
  }

// confirm where link came from
if (!strstr($_SERVER['HTTP_REFERER'], FILENAME_CHECKOUT_CONFIRMATION)) {
  //    zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT,'','SSL'));
}

// load selected payment module
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($_SESSION['payment']);
// load the selected shipping module

require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']['code']);

require(DIR_WS_CLASSES . 'order.php');
if(isset($_SESSION['order_number_created']) && $_SESSION['order_number_created'] != ''){
   $order = new order($_SESSION['order_number_created']);
	$insert_id = $_SESSION['order_number_created'];
}else{
   $order = new order;
}

// prevent 0-entry orders from being generated/spoofed
if (sizeof($order->products) < 1) {
  zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total;

$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PRE_CONFIRMATION_CHECK');

//$order_totals = $order_total_modules->pre_confirmation_check();

$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PROCESS');

//$order_totals = $order_total_modules->process();

$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_TOTALS_PROCESS');

if (!isset($_SESSION['payment']) && !$credit_covers) {
  zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

// load the before_process function from the payment modules
//$payment_modules->before_process();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_BEFOREPROCESS');
// create the order record
if($_SESSION['payment']=='paypalwpp'){
	$order->billing['name'] = $_SESSION['paypal_ec_payer_info']['payer_firstname'] . ' ' . $_SESSION['paypal_ec_payer_info']['payer_lastname'];
	$order->billing['firstname'] = $_SESSION['paypal_ec_payer_info']['payer_firstname'];
	$order->billing['lastname'] = $_SESSION['paypal_ec_payer_info']['payer_lastname'];
	$order->billing['company']          = $_SESSION['paypal_ec_payer_info']['payer_business'];
	$order->billing['street_address']   = $_SESSION['paypal_ec_payer_info']['ship_street_1'];
	$order->billing['suburb']           = $_SESSION['paypal_ec_payer_info']['ship_street_2'];
	$order->billing['city']             = $_SESSION['paypal_ec_payer_info']['ship_city'];
	$order->billing['postcode']         = $_SESSION['paypal_ec_payer_info']['ship_postal_code'];
	$order->billing['state']            = $_SESSION['paypal_ec_payer_info']['ship_state'];
	$order->billing['country']          = array('id' => $_SESSION['paypal_ec_payer_info']['country_id'], 'title' => $_SESSION['paypal_ec_payer_info']['ship_country_name'], 'iso_code_2' => $_SESSION['paypal_ec_payer_info']['ship_country_code'], 'iso_code_3' => $_SESSION['paypal_ec_payer_info']['country_code3']);
	$order->billing['country']['id']    = $_SESSION['paypal_ec_payer_info']['country_id'];
	$order->billing['country']['iso_code_2'] = $_SESSION['paypal_ec_payer_info']['ship_country_code'];
	//$order->billing['format_id']        = $_SESSION['paypal_ec_payer_info']['address_format_id'];
	$order->billing['zone_id']          = $_SESSION['paypal_ec_payer_info']['state_id'];
	/*
	 wei.liang start
	paypal payer status
	2013.03.13
	*/
		 
	$payment_modules->before_process();
	
	$check_high_risk_customer = zen_check_high_risk_customer();
	if($check_high_risk_customer['is_high_risk'] == true){
		$_SESSION['paypal_ec_payer_info']['high_risk_info'] = $check_high_risk_customer['info'];
		$order->info['order_status'] = 42;
	}
	
	$order->order_status_update($_SESSION['order_number_created'],$order->info['order_status'], array('transaction_id' =>$_SESSION['paypal_ec_payer_info']['transaction_id']));
   	if($order->info['order_status'] == 2 || $order->info['order_status'] == 42){
		$order->send_succ_order_email($_SESSION['order_number_created'], 2);
      	$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_SEND_ORDER_EMAIL');
   	}


	/*
	 wei.liang end:
	*/
}else{
	$order->order_status_update($_SESSION['order_number_created'],$order->info['order_status']);
}

/*
$insert_id = $order->create($order_totals, 2);
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE');
$payment_modules->after_order_create($insert_id);
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_AFTER_ORDER_CREATE');
// store the product info to the order
$order->create_add_products($insert_id);
$_SESSION['order_number_created'] = $insert_id;
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE_ADD_PRODUCTS');
//send email notifications
$order->send_order_email($insert_id, 2);
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_SEND_ORDER_EMAIL');
*/

/**
 * Calculate order amount for display purposes on checkout-success page as well as adword campaigns etc
 * Takes the product subtotal and subtracts all credits from it
 */
  $credits_applied = 0;
  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
    if ($order_totals[$i]['code'] == 'ot_subtotal') $order_subtotal = $order_totals[$i]['value'];
    if ($$order_totals[$i]['code']->credit_class == true) $credits_applied += $order_totals[$i]['value'];
    if ($order_totals[$i]['code'] == 'ot_total') $ototal = $order_totals[$i]['value'];
  }
  $commissionable_order = ($order_subtotal - $credits_applied);
  $commissionable_order_formatted = $currencies->format($commissionable_order);
  $_SESSION['order_summary']['order_number'] = $insert_id;
  $_SESSION['order_summary']['order_subtotal'] = $order_subtotal;
  $_SESSION['order_summary']['credits_applied'] = $credits_applied;
  $_SESSION['order_summary']['order_total'] = $ototal;
  $_SESSION['order_summary']['commissionable_order'] = $commissionable_order;
  $_SESSION['order_summary']['commissionable_order_formatted'] = $commissionable_order_formatted;
  $_SESSION['order_summary']['coupon_code'] = $order->info['coupon_code'];
  

?>
