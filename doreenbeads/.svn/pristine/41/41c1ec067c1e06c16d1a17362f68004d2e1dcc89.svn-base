<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: checkout_process.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('EMAIL_TEXT_SUBJECT', 'We have received your payment for order No. %s'); 
define('EMAIL_TEXT_HEADER', 'Order Confirmation');
define('EMAIL_TEXT_PAYMENT_HEADER', 'Payment Confirmation from Doreenbeads');
define('EMAIL_TEXT_FROM',' from ');  //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING','Thanks for shopping with us today!');
define('EMAIL_THANKS_FOR_PAYMENT','Thanks for shopping with us! You have made the payment successfully, and we will arrange your order’s packaging and shipment ASAP. ');
define('EMAIL_DETAILS_FOLLOW','The following are the details of your order.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Click here for a Detailed Invoice');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_PRODUCTS', 'Products');
define('EMAIL_TEXT_SUBTOTAL', 'Sub-Total:');
define('EMAIL_TEXT_TAX', 'Tax:        ');
define('EMAIL_TEXT_SHIPPING', 'Shipping: ');
define('EMAIL_TEXT_TOTAL', 'Total:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');
define('HEADING_ADDRESS_TITLE', 'We will ship your parcel to the following shipping address ');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');

// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' No: ');
define('HEADING_ADDRESS_INFORMATION','Address Information');
define('HEADING_SHIPPING_METHOD','Shipping Method');
//define('TEXT_HTML_CHECKOUT_SHIPPING_ADDRESS', '<br /><span style="color:red;">Note:</span> Please make sure this shipping address is correct. After receive your payment, we will swiftly process your order and ship it out. We ship orders frequently. So that if you find this address is not correct, please contact us as soon as possible.<br /><br />');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Important note about <b>Delivery Address</b>:</span> Please make sure that above Delivery Address is correct. Normally upon receiving your payment, we will dispatch your parcel quickly. Therefore if you find this address is incorrect, please contact us within 24 hours.<br /><br />');

//add by zhouliang 2011-09-09
define('EMAIL_ORDER_TRACK_REMIND','<font color="red">Be sure to check your email box for our <b>dispatch notification:</b></font><br />
	We will keep you update about your order status in time. You will expect to receive a dispatch notification within 2 normal business days after making payment. So if you did not receive the dispatch notification in this period, please feel free to contact us. We will check your order for you ASAP, to ensure that we can ship your parcel out without delay. Thank you for your time. :)<br /> <br />
	<font color="red">If it happens that one or a few items out of stock, <b>should we contact you before dispatching?</b></font><br /><br />
	Normally items will not out of stock since we have sufficient stock on hand,:) but it happens in a few occasion that some certain item run out unexpectly. When this happen, our default policy is that arrange shipping of available items at first, for short items, we will ship them when they available again, or ship them out with your next order, or do equal credit which will depends on yourself. We will state detail in dispatach notification.<br /><br />
	<font color="red">Attention:</font> If we have to contact you to let you know which item was out of stock before dispatching, please kindly reply this email. So we will contact you in time to discuss about item exchange etc.<br /><br />
	Thank you for your time. :)<br /><br />
	(Kindly note: You may check your spam folder if you have not received the email, sometimes the message may be blocked by accidently.) 	
	');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Important note about <b>Delivery Address</b>:</span> Please make sure that above Delivery Address is correct. Normally upon receiving your payment, we will dispatch your parcel quickly. Therefore if you find this address is incorrect, please contact us within 24 hours.<br /><br />');
define('TEXT_PAYMENT_FAILURE', 'We are sorry, the payment was failed to made which may due to card information is incorrect, you could try again by another card if possisble. If it still failed, please kindly contact us at <a href=mailto:sale@doreenbeads.com>sale@doreenbeads.com</a>. Thank you for your time.');
//end
?>
