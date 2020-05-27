<?php
/**
 * ipn_main_handler.php callback handler for paypal IPN payment method
 *
 * @package paymentMethod
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ipn_main_handler.php 6528 2007-06-25 23:25:27Z drbyte $
 */

/**
 * handle Express Checkout processing:
 */
//echo $_GET['type'];
//die();
if (isset($_GET['type']) && $_GET['type'] == 'ec') {
  // this is an EC handler request
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'payment.php');
  
  // by wangyuan 2011-09-29
  if (isset($_SESSION['cart']->cartID) && $_SESSION['cartID'] && !$_SESSION['order_number_created']) {
     if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
          zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
      }
  }
  // end
  // See if we were sent a request to clear the session for PayPal.
  if (isset($_GET['clearSess']) || isset($_GET['ec_cancel'])) {
    // Unset the PayPal EC information.
    unset($_SESSION['paypal_ec_temp']);
    unset($_SESSION['paypal_ec_token']);
    unset($_SESSION['paypal_ec_payer_id']);
    unset($_SESSION['paypal_ec_payer_info']);
  }
  // See if the paypalwpp module is enabled.
  if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
    $paypalwpp_module = 'paypalwpp';
    // init the payment object
    $payment_modules = new payment($paypalwpp_module);
    // set the payment, if they're hitting us here then we know
    // the payment method selected right now.
    $_SESSION['payment'] = $paypalwpp_module;
    // check to see if we have a token sent back from PayPal.
    if (!isset($_SESSION['paypal_ec_token']) || empty($_SESSION['paypal_ec_token'])) {
      // We have not gone to PayPal's website yet in order to grab
      // a token at this time.  This will send the user over to PayPal's
      // website to login and return a token
      $$paypalwpp_module->ec_step1($_SESSION['order_number_created']);
    } else {
      // This will push on the second step of the paypalwpp payment
      // module, as we already have a PayPal express checkout token
      // at this point.
        $$paypalwpp_module->ec_step2($_SESSION['order_number_created']);
    }
  }
?>
<html>
Processing...
</html>
<?php		
}elseif(isset($_GET['action']) && $_GET['action'] == 'setexpresscheckout'){
	require('includes/application_top.php');		
	require(DIR_WS_CLASSES . 'payment.php');
	
	// See if we were sent a request to clear the session for PayPal.
	
	if (isset($_GET['clearSess']) || isset($_GET['ec_cancel'])) {
	
		// Unset the PayPal EC information.
	
		unset($_SESSION['paypal_ec_temp']);
	
		unset($_SESSION['paypal_ec_token']);
	
		unset($_SESSION['paypal_ec_payer_id']);
	
		unset($_SESSION['paypal_ec_payer_info']);
	
	}
	// See if the paypalwpp module is enabled.
	
	if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
	
		$paypalwpp_module = 'paypalwpp';
	
		// init the payment object
	
		$payment_modules = new payment($paypalwpp_module);
	
		$_SESSION['payment'] = $paypalwpp_module;
	
		// check to see if we have a token sent back from PayPal.
	
		if (!isset($_SESSION['paypal_ec_token']) || empty($_SESSION['paypal_ec_token'])) {
			require(DIR_WS_CLASSES . 'order.php');
			$order = new order;
			if(isset($order->info['subtotal']) > 0){
				$$paypalwpp_module->express_step1($order->info['subtotal']);
			}
		} else {
			$_SESSION['paypal_ec_step'] = 1;
			zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, 'auto_close=true&paypal_success_url=' . zen_href_link(FILENAME_CHECKOUT_SHIPPING)));
			exit;
		}
	
	}
	?>
	
	<html>
	
	Processing...
	
	</html>
<?php		
}else {
$isECtransaction = ($_POST['txn_type']=='express_checkout' || $_POST['txn_type']=='cart');
/**
 * require general paypal functions
 */
require('includes/modules/payment/paypal/paypal_functions.php');
/**
 * require custom paypal application_top.php
 */
require('includes/modules/payment/paypal/ipn_application_top.php');
/**
 * require language defines
 */
if (!isset($_SESSION['language'])) $_SESSION['language'] = 'english';
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'checkout_process.php')) {
  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'checkout_process.php');
} else {
  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php');
}
//require('includes/languages/english/checkout_process.php');
$extraDebug = (defined('IPN_EXTRA_DEBUG_DETAILS') && IPN_EXTRA_DEBUG_DETAILS == 'All');
/**
 * do confirmation post-back to PayPal and extract the results for subsequent use
 */
$ipnData  = ipn_postback();
$postdata = $ipnData['postdata'];
$info     = $ipnData['info'];
$new_status = 1;
ipn_debug_email('Breakpoint: 1 - Collected data from PayPal notification');

/**
 * validate transaction -- email address, matching txn record, etc
 */
if (!ipn_validate_transaction($info, $_POST) === true) {
  if (!$isECtransaction && $_POST['txn_type'] != '') {
    ipn_debug_email('IPN FATAL ERROR :: Transaction did not validate');
    die();
  }
}
if ($extraDebug) ipn_debug_email('Breakpoint: 2 - Validated transaction components');
/**
 * is this a sandbox transaction?
 */
if (isset($_POST['test_ipn']) && $_POST['test_ipn'] == 1) {
  ipn_debug_email('IPN NOTICE :: Processing SANDBOX transaction.');
}
if (isset($_POST['test_internal']) && $_POST['test_internal'] == 1) {
  ipn_debug_email('IPN NOTICE :: Processing INTERNAL TESTING transaction.');
}
if (isset($_POST['pending_reason']) && $_POST['pending_reason'] == 'unilateral') {
  ipn_debug_email('*** NOTE: TRANSACTION IS IN *unilateral* STATUS pending creation of a PayPal account for this receiver_email address.' . "\n" . 'Please create the account, or make sure the PayPal account is *Verified*.');
}

ipn_debug_email('Breakpoint: 3 - Communication method verified');
/**
 * Lookup transaction history information in preparation for matching and relevant updates
 */
$lookupData  = ipn_lookup_transaction($_POST);
////����Ϊ order_id  robbie 10-11-22
$ordersID    = $lookupData['order_id'];
$paypalipnID = $lookupData['paypal_ipn_id'];
$txn_type    = $lookupData['txn_type'];

if ($extraDebug) ipn_debug_email('Breakpoint: 4 - ' . 'Details:  txn_type=' . $txn_type . '    ordersID = '. $ordersID . '  IPN_id=' . $paypalipnID . "\n\n" . '   Relevant data from POST:' . "\n     " . 'txn_type = ' . $txn_type . "\n     " . 'parent_txn_id = ' . ($_POST['parent_txn_id'] =='' ? 'None' : $_POST['parent_txn_id']) . "\n     " . 'txn_id = ' . $_POST['txn_id']);

// this is used to determine whether a record needs insertion. ie: original echeck notice failed, but now we have cleared, so need parent record established:
$new_record_needed = ($txn_type == 'unique' ? true : false);
/**
 * evaluate what type of transaction we're processing
 */
$txn_type = ipn_determine_txn_type($_POST, $txn_type);
if ($extraDebug) ipn_debug_email('Breakpoint: 5 - Transaction type (txn_type) = ' . $txn_type);

/**
 * take action based on transaction type and corresponding requirements
 */
switch ($txn_type) {
  case ($_POST['txn_type'] == 'send_money'):
  case ($_POST['txn_type'] == 'merch_payment'):
  case ($_POST['txn_type'] == 'new_case'):
    // these types are irrelevant to ZC transactions
    ipn_debug_email('IPN NOTICE :: Transaction txn_type not relevant to Zen Cart processing. IPN handler aborted.');
    die();
    break;
  case (substr($_POST['txn_type'],0,7) == 'subscr_'):
    // For now we filter out subscription payments
    ipn_debug_email('IPN NOTICE :: Subscription payment - Not currently supported by Zen Cart. IPN handler aborted.');
    die();
    break;

  case 'pending-unilateral':
    // cannot process this order because the merchant's PayPal account isn't valid yet
    ipn_debug_email('IPN NOTICE :: Please create a valid PayPal account and follow the steps to *Verify* it. IPN handler aborted.');
    die();
    break;
  case 'pending-address':
  case 'pending-intl':
  case 'pending-multicurrency':
  case 'pending-verify':
    if (!isECtransaction) {
      ipn_debug_email('IPN NOTICE :: '.$txn_type.' transaction -- inserting initial record for reference purposes');
      $paypal_order = ipn_create_order_array($ordersID, $txn_type);
      zen_db_perform(TABLE_PAYPAL, $paypal_order);
      $paypal_order_history = ipn_create_order_history_array($paypalipnID);
      zen_db_perform(TABLE_PAYPAL_PAYMENT_STATUS_HISTORY, $paypal_order_history);
      die();
      break;
    }
  case 'cart':
  case 'express_checkout':
    // This is an express-checkout transaction -- IPN serves no needed purpose
    if ($_POST['payment_status'] == 'Completed') {
      ipn_debug_email('IPN NOTICE :: Express Checkout payment notice on completed order -- IPN Ignored');
      die();
    }
    if (!(substr($txn_type,0,8) == 'pending-' && (int)$ordersID <= 0) && !($new_record_needed && $txn_type == 'echeck-cleared') && $txn_type != 'unique') break;

  case (substr($txn_type,0,8) == 'pending-' && (int)$ordersID <= 0):
  case ($new_record_needed && $txn_type == 'echeck-cleared'):
  case 'unique':
    /**
     * require shipping class
     */
    require(DIR_WS_CLASSES . 'shipping.php');
    /**
     * require payment class
     */
    require(DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment($_SESSION['payment']);
    $shipping_modules = new shipping($_SESSION['shipping']['code']);
    /**
     * require order class
     */
    require(DIR_WS_CLASSES . 'order.php');
    $order = new order();
    /**
     * require order_total class
     */
    if ($extraDebug) ipn_debug_email('From robbie, the program begin at here', 'wei@8season.com', false, 'ipn debug from robbie 1');
    require(DIR_WS_CLASSES . 'order_total.php');
    $order_total_modules = new order_total();
    $order_totals = $order_total_modules->process();

//    if (valid_payment($order->info['total'], $_SESSION['currency']) === false) {
//      ipn_debug_email('From robbie, the program dying at here', 'wei@8season.com', false, 'ipn debug from robbie');
//      die();
//    }
    
    if ($ipnFoundSession === false) {
      ipn_debug_email('IPN NOTICE :: Unique but no session - Assumed to be a personal payment, rather than an IPN transaction. Ignoring.');
      die();
    }
    if ($extraDebug) ipn_debug_email('before insert order', 'wei@8season.com', false, 'ipn debug from robbie 3 order_totals' .  print_r($order_totals, true));
    $insert_id = $order->create($order_totals);
    if ($extraDebug) ipn_debug_email('after insert order ' . $insert_id, 'wei@8season.com', false, 'ipn debug from robbie 4');
    if ($extraDebug) ipn_debug_email('Breakpoint: 5a - built order -- OID:' . $insert_id, 'wei@8season.com', false, 'ipn debug from robbie 4');
    $paypal_order = ipn_create_order_array($insert_id, $txn_type);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5b - PP table OID:' . print_r($paypal_order, true), 'wei@8season.com', false, 'ipn debug from robbie 4');
    zen_db_perform(TABLE_PAYPAL, $paypal_order);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5c - PP table OID saved', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $pp_hist_id = $db->Insert_ID();
    if ($extraDebug) ipn_debug_email('Breakpoint: 5d - PP hist ID:' . $pp_hist_id);
    $paypal_order_history = ipn_create_order_history_array($pp_hist_id);
    ipn_debug_email('Breakpoint: 5e - PP hist_data:' . print_r($paypal_order_history, true), 'wei@8season.com', false, 'ipn debug from robbie 4');
    zen_db_perform(TABLE_PAYPAL_PAYMENT_STATUS_HISTORY, $paypal_order_history);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5f - PP hist saved', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $new_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID;
    if ($extraDebug) ipn_debug_email('Breakpoint: 5g - new status code' . $new_status, 'wei@8season.com', false, 'ipn debug from robbie 4');
    if ($_POST['payment_status'] =='Pending') {
      $new_status = MODULE_PAYMENT_PAYPAL_PROCESSING_STATUS_ID;
    if ($extraDebug) ipn_debug_email('Breakpoint: 5h - newer status code' . $new_status);
      $db->Execute("update " . TABLE_ORDERS  . "
                      set orders_status = " . MODULE_PAYMENT_PAYPAL_PROCESSING_STATUS_ID . "
                      where orders_id = '" . $insert_id . "'");
    if ($extraDebug) ipn_debug_email('Breakpoint: 5i - order table updated');
    }
    $sql_data_array = array('orders_id' => $insert_id,
                            'orders_status_id' => $new_status,
                            'date_added' => 'now()',
                            'comments' => 'PayPal status(code:296): ' . $_POST['payment_status'] . ' ' . $_POST['pending_reason']. ' @ '.$_POST['payment_date'] . (($_POST['parent_txn_id'] !='') ? "\n" . ' Parent Trans ID:' . $_POST['parent_txn_id'] : '') . "\n" . ' Trans ID:' . $_POST['txn_id'] . "\n" . ' Amount: ' . $_POST['mc_gross'] . ' ' . $_POST['mc_currency'],
                            'customer_notified' => false
                            );
    if ($extraDebug) ipn_debug_email('Breakpoint: 5j - order stat hist update:' . print_r($sql_data_array, true), 'wei@8season.com', false, 'ipn debug from robbie 4');
    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5k - OSH update done', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $order->create_add_products($insert_id, 2);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5L - adding products', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $order->send_order_email($insert_id, 2);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5m - emailing customer Order ID:' . $insert_id, 'wei@8season.com', false, 'ipn debug from robbie 4');
    $_SESSION['cart']->reset(true);
    if ($extraDebug) ipn_debug_email('Breakpoint: 5n - emptying cart', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $ordersID = $insert_id;
    $paypalipnID = $pp_hist_id;
    if ($extraDebug) ipn_debug_email('Breakpoint: 6 - Completed IPN order add.' . '    ordersID = '. $ordersID . '  IPN_id =' . $paypalipnID);
  if (!($new_record_needed && $txn_type == 'echeck-cleared'))  break;

  case 'parent':
  case 'cleared-address':
  case 'cleared-multicurrency':
  case 'cleared-echeck':
  case 'cleared-authorization':
  case 'cleared-verify':
  case 'cleared-intl':
  case 'echeck-denied':
  case 'echeck-cleared':
  case 'denied-address':
  case 'denied-multicurrency':
  case 'denied-echeck':
  case 'failed-echeck':
  case 'denied-intl':
  case 'denied':
  case 'express-checkout-cleared':
    if ($txn_type == 'parent') {
      $paypal_order = ipn_create_order_array($ordersID, $txn_type);
      zen_db_perform(TABLE_PAYPAL, $paypal_order);
    } else {
      $paypal_order = ipn_create_order_update_array($txn_type);
      zen_db_perform(TABLE_PAYPAL, $paypal_order, 'update', "txn_id='" . $_POST['txn_id'] . "'");
    }
    $paypal_order_history = ipn_create_order_history_array($paypalipnID);
    zen_db_perform(TABLE_PAYPAL_PAYMENT_STATUS_HISTORY, $paypal_order_history);
    ipn_debug_email('IPN NOTICE :: Updating PP table record status for order #' . $ordersID . ' txn_id: ' . $_POST['txn_id'] . ' PP IPN ID: ' . $paypalipnID);

  switch ($txn_type) {
    case ($_POST['payment_status'] == 'Refunded' || $_POST['payment_status'] == 'Reversed'):
      //payment_status=Refunded
      $new_status = MODULE_PAYMENT_PAYPALWPP_REFUNDED_STATUS_ID;
      if (defined('MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID') && (int)MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID > 0 && !$isECtransaction) $new_status = MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID;
    break;
    case 'echeck-denied':
    case 'denied-echeck':
    case 'failed-echeck':
      //payment_status=Denied or failed
      $new_status = ($isECtransaction ? MODULE_PAYMENT_PAYPALWPP_REFUNDED_STATUS_ID : MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID);
    break;
    case 'echeck-cleared':
      //echeck-cleared
      $new_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID;
    break;
    case ($txn_type=='express-checkout-cleared' || substr($txn_type,0,8) == 'cleared-'):
      //express-checkout-cleared
      $new_status = MODULE_PAYMENT_PAYPALWPP_ORDER_STATUS_ID;
    break;
    case 'pending-auth':
      // pending authorization
      $new_status = ($isECtransaction ? MODULE_PAYMENT_PAYPALWPP_REFUNDED_STATUS_ID : MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID);
    break;
    case (substr($txn_type,0,7) == 'denied-'):
      // denied for any other reason - treat as pending for now
    case (substr($txn_type,0,8) == 'pending-'):
      // pending anything
      $new_status = ($isECtransaction ? MODULE_PAYMENT_PAYPALWPP_ORDER_PENDING_STATUS_ID : MODULE_PAYMENT_PAYPAL_PROCESSING_STATUS_ID);
    break;
  }
  // update order status history with new information
  ipn_debug_email('IPN NOTICE :: Set new status ' . $new_status . " for order ID = " .  $ordersID . ($_POST['pending_reason'] != '' ? '.   Reason_code = ' . $_POST['pending_reason'] : '') );
  if (in_array($_POST['payment_status'], array('Refunded', 'Reversed', 'Denied', 'Failed')) 
      || substr($txn_type,0,8) == 'cleared-' || $txn_type=='echeck-cleared' || $txn_type == 'express-checkout-cleared') {
    if ((int)$new_status == 0) $new_status = 1;
    ipn_update_orders_status_and_history($ordersID, $new_status, $txn_type);
  }
  break;
  case ($txn_type == 'pending-echeck' && (int)$ordersID > 0):
    ipn_debug_email('IPN NOTICE :: Pending echeck transaction for existing order. No action required. Waiting for echeck to clear.');
  break;
  case ($txn_type == 'pending-multicurrency' && (int)$ordersID > 0):
    ipn_debug_email('IPN NOTICE :: Pending multicurrency transaction for existing order. No action required. Waiting for merchant to "accept" the order via PayPal account console.');
  break;
  case ($txn_type == 'pending-address' && (int)$ordersID > 0):
    ipn_debug_email('IPN NOTICE :: "Pending address" transaction for existing order. No action required. Waiting for address approval by store owner via PayPal account console.');
  break;
  default:
    // can't understand result found. Thus, logging and aborting.
    ipn_debug_email('IPN WARNING :: Could not process for txn type: ' . $txn_type . "\n" . ' postdata=' . str_replace('&', " \n&", urldecode($postdata)));
  }
}
?>
