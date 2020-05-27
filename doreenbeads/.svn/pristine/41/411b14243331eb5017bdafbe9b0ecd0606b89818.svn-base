<?php
require (DIR_WS_MODULES . 'checkout_process.php');
$pay_ment = $_SESSION ['payment'];
$payment_modules->after_process ();
$zco_notifier->notify ( 'NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES' );

$_SESSION ['cart']->reset ( true );
unset ( $_SESSION ['sendto'] );
unset ( $_SESSION ['billto'] );
unset ( $_SESSION ['shipping'] );
unset ( $_SESSION ['payment'] );
unset ( $_SESSION ['comments'] );
unset ( $_SESSION ['current_used_cash'] );
$order_total_modules->clear_posts (); // ICW ADDED FOR CREDIT CLASS SYSTEM
$return_account_order_id = $_SESSION ['order_number_created'];
unset ( $_SESSION ['order_number_created'] );
$zco_notifier->notify ( 'NOTIFY_HEADER_END_CHECKOUT_PROCESS' );


if($pay_ment == 'cod') $pay_ment = 'paypalmanually';

if($pay_ment == 'paypalmanually')
{
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'payment=paypalmanually', 'SSL'));  
}
else
{
	if($_SESSION['payment_return_account']){
		zen_redirect(zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . (int)$return_account_order_id, 'SSL'));
	}else{
		zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
	}
}

require (DIR_WS_INCLUDES . 'application_bottom.php');
?>
