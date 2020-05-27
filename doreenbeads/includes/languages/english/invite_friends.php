<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tell_a_friend.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Invite Friends');

define('HEADING_TITLE', 'Invite Friends ’%s’');
define('FORM_FIELD_CUSTOMER_NAME', 'Your Name:');
define('FORM_TITLE_CUSTOMER_DETAILS', 'Your Details');
define('FORM_TITLE_FRIEND_DETAILS', 'Your Friend’s Details');
define('FORM_TITLE_FRIEND_MESSAGE', 'Your Message:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Your Friend’s Email:');
define('FORM_FIELD_FRIEND_EMAIL', 'Your Friend’s Email:');

define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Your email about <strong>%s</strong> has been successfully sent to <strong>%s</strong>.');

define('EMAIL_TEXT_HEADER','Important Notice!');

define('EMAIL_TEXT_SUBJECT', 'Your friend %s has recommended this great product from %s');
define('EMAIL_TEXT_GREET', 'Hi %s!' . "\n\n");
define('EMAIL_TEXT_INTRO', 'Your friend, %s, thought that you would be interested in %s from %s.');

define('EMAIL_TELL_A_FRIEND_MESSAGE','%s sent a note saying:');

define('EMAIL_TEXT_LINK', 'To view the product, click on the link below or copy and paste the link into your web browser:' . "\n\n" . '%s');
define('EMAIL_TEXT_SIGNATURE', 'Regards,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'Error: Your name must not be empty.');
define('ERROR_TO_ADDRESS', 'Error: Your friend’s email address does not appear to be valid. Please try again.');
define('ERROR_FROM_NAME', 'Error: Your name must not be empty.');
define('ERROR_FROM_ADDRESS', 'Error: Your email address does not appear to be valid. Please try again.');

//	v2.80 2015-04-22
define('INVITE_FRIENDS_TITLE', 'For every friend you invite to DoreenBeads, we will give you a Free Cash Coupon <span>up to USD 15.</span>');
define('INVITE_FRIENDS_BYEMAIL', 'Invite your friends by Email:');
define('INVITE_FRIENDS_EMAIL_ENTER', 'Enter your friends’ emails here. A comma is needed.');
define('INVITE_FRIENDS_BYOTHER', 'Or, Invite your friends by Other Ways:');
define('INVITE_FRIENDS_COPYLINK', 'Copy Link');
define('INVITE_FRIENDS_SEND', 'Send');
define('INVITE_FRIENDS_SHAREFB', 'Share on Facebook');
define('INVITE_FRIENDS_SHARETW', 'Share on Twitter');
define('INVITE_FRIENDS_SHAREVK', 'Поделиться В Контакте');
define('INVITE_FRIENDS_SHAREOD', 'Поделиться в однокласснике');
define('INVITE_FRIENDS_DESCRIPTION', '* After your friend places his or her first order over US$ 10 in DoreenBeads, you’ll get a Free Cash Coupon up to US$ 15.');
define('INVITE_FRIENDS_DESCRIPTION1','<li>Earn US$ 5 when your friend spends US$ 10- US$ 19.99</li><li>Earn US$ 10 when your friend spends US$ 20- US$ 29.99</li><li>Earn US$ 15 when your friend spends US$ 30 or more</li>');
define('INVITE_FRIENDS_MAIL_TITLE', 'Highly Recommend DoreenBeads');
define('INVITE_FRIENDS_MAIL_CONT1', 'Hi, there!'."<br />\n".'I have been shopping in DoreeenBeads for all kinds of jewelry making supplies and crafts. They have huge selections, and all items are free shipping. Highly recommended! Check out via following link:'."<br />\n");
define('INVITE_FRIENDS_MAIL_CONT2', 'Best Regards,'."<br />\n");
define('INVITE_FRIENDS_MAIL_CONT3', 'DoreenBeads Team');
define('INVITE_FRIENDS_EMAIL_EMPTY', 'Invalid Email.');
define('INVITE_FRIENDS_EMAIL_WRONG', 'Invalid Email.');
define('INVITE_FRIENDS_EMAIL_SUCC', 'Email sent successfully.');
?>