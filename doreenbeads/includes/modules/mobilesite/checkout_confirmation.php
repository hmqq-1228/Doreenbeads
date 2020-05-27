<?php
set_time_limit ( 600 );
if ($_SESSION ['cart']->count_contents () <= 0 && ! $_SESSION ['order_number_created']) {
	zen_redirect ( zen_href_link ( FILENAME_TIME_OUT ) );
}
if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ( array (
			'mode' => 'SSL',
			'page' => FILENAME_CHECKOUT_PAYMENT
	) );
	zen_redirect ( zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
} else {
	if (zen_get_customer_validate_session ( $_SESSION ['customer_id'] ) == false) {
		$_SESSION ['navigation']->set_snapshot ();
		zen_redirect ( zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
	}
}
if (isset ( $_SESSION ['cart']->cartID ) && $_SESSION ['cartID']) {
	if ($_SESSION ['cart']->cartID != $_SESSION ['cartID'] && ! $_SESSION ['order_number_created']) {
		zen_redirect ( zen_href_link ( FILENAME_CHECKOUT_SHIPPING, '', 'SSL' ) );
	}
}

if (! $_SESSION ['shipping']) {
	zen_redirect ( zen_href_link ( FILENAME_CHECKOUT_SHIPPING, '', 'SSL' ) );
}

if (isset ( $_POST ['payment'] )) {
	$_SESSION ['payment'] = $_POST ['payment'];
}

if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
	if (! isset ( $_POST ['conditions'] ) || ($_POST ['conditions'] != '1')) {
		$messageStack->add_session ( 'checkout_payment', ERROR_CONDITIONS_NOT_ACCEPTED, 'error' );
	}
}

unset($_SESSION['payment_return_account']);

require (DIR_WS_CLASSES . 'order.php');
$order = new order ( $_SESSION ['order_number_created'] );

if ($_POST ['payment'] == 'paypalwpp') {
	zen_redirect ( $_POST ['paypal_url'], '', 'SSL' );
	exit ();
}

require (DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total ();
$order_total_modules->collect_posts ();
$order_total_modules->pre_confirmation_check ();

require (DIR_WS_CLASSES . 'payment.php');

$payment_modules = new payment ( $_SESSION ['payment'] );
$payment_modules->update_status ();
if (($_SESSION ['payment'] == '' && ! $credit_covers) || (is_array ( $payment_modules->modules )) && (sizeof ( $payment_modules->modules ) > 1) && (! is_object ( $$_SESSION ['payment'] )) && (! $credit_covers)) {
	$messageStack->add_session ( 'checkout_payment', ERROR_NO_PAYMENT_MODULE_SELECTED, 'error' );
}

if (is_array ( $payment_modules->modules )) {
	$payment_modules->pre_confirmation_check ();
}

if ($messageStack->size ( 'checkout_payment' ) > 0) {
	zen_redirect ( zen_href_link ( FILENAME_CHECKOUT_PAYMENT, '', 'SSL' ) );
}

require (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping ( $_SESSION ['shipping']['code'] );

$flagAnyOutOfStock = false;
$stock_check = array ();
if ($_SESSION ['cc_id']) {
	$discount_coupon_query = "SELECT coupon_code
                            FROM " . TABLE_COUPONS . "
                            WHERE coupon_id = :couponID";

	$discount_coupon_query = $db->bindVars ( $discount_coupon_query, ':couponID', $_SESSION ['cc_id'], 'integer' );
	$discount_coupon = $db->Execute ( $discount_coupon_query );

	$customers_referral_query = "SELECT customers_referral
                               FROM " . TABLE_CUSTOMERS . "
                               WHERE customers_id = :customersID";

	$customers_referral_query = $db->bindVars ( $customers_referral_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
	$customers_referral = $db->Execute ( $customers_referral_query );

	if ($customers_referral->fields ['customers_referral'] == '' and CUSTOMERS_REFERRAL_STATUS == 1) {
		$sql = "UPDATE " . TABLE_CUSTOMERS . "
            SET customers_referral = :customersReferral
            WHERE customers_id = :customersID";

		$sql = $db->bindVars ( $sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
		$sql = $db->bindVars ( $sql, ':customersReferral', $discount_coupon->fields ['coupon_code'], 'string' );
		$db->Execute ( $sql );
	}
}

if (isset ( $$_SESSION ['payment']->form_action_url )) {
	$form_action_url = $$_SESSION ['payment']->form_action_url;
} else {
	$form_action_url = zen_href_link ( FILENAME_CHECKOUT_PROCESS, '', 'SSL' );
}

if (isset ( $_SESSION ['order_number_created'] ) && ( int ) $_SESSION ['order_number_created'] > 0) {
	zen_redirect ( zen_href_link ( FILENAME_CHECKOUT_PROCESS, '', 'SSL' ) );
}
$editShippingButtonLink = zen_href_link ( FILENAME_CHECKOUT, 'pn=sc', 'SSL' );
if (method_exists ( $$_SESSION ['payment'], 'alterShippingEditButton' )) {
	$theLink = $$_SESSION ['payment']->alterShippingEditButton ();
	if ($theLink) {
		$editShippingButtonLink = $theLink;
	}
}
// deal with billing address edit button
$flagDisablePaymentAddressChange = false;
if (isset ( $$_SESSION ['payment']->flagDisablePaymentAddressChange )) {
	$flagDisablePaymentAddressChange = $$_SESSION ['payment']->flagDisablePaymentAddressChange;
}

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
$breadcrumb->add ( NAVBAR_TITLE_1, zen_href_link ( FILENAME_CHECKOUT_SHIPPING, '', 'SSL' ) );
$breadcrumb->add ( NAVBAR_TITLE_2 );

// This should be last line of the script:
$zco_notifier->notify ( 'NOTIFY_HEADER_END_CHECKOUT_CONFIRMATION' );
?>
