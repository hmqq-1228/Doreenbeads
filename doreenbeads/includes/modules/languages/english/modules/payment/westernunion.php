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
// $Id: westernunion.php,v 1.0 2004/05/02 Farrukh Saeed
//
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', 'Receiver ');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', 'Sender ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', 'Amount : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', 'Currency : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', 'First Name : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', 'Last Name : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', 'Address : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', 'Zip Code : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', 'City : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', 'Country : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', 'Phone : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', 'Question : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', 'Answer : ');
  
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', '862163023611');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_TITLE', 'Western Union Order');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', 'Make Payable To:<br><br>' .  '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "\n" .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "\n" .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "\n"  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "\n"  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY .   '</b>'.  MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "\n"  .  '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "\n"  .   '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '');
  
  
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "Western Union Money Instant Transfer Make Payable To:\n\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . "\n\n" . "After sending money, please email us (sale@doreenbeads.com) with following information:\n\n1.your login name, order#,\n2.10-digits Western Union Money Instant Transfer Control Number\n3.Total amount you sent with currency\n4.Your firstname, last name, address, telephone number\n\nOnce receive your payment, we will begin processing your order and ship it out immediately.");

?>
