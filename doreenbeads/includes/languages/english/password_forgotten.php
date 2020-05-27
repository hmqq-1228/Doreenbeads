<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Login');
define('NAVBAR_TITLE_2', 'Password Forgotten');
define('HEADING_TITLE', 'Forgot your password?');
define('TEXT_MAIN', 'Enter your register email address and we will send you an email with instructions on resetting your password.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'An account with this email address could not be found.  - If you need to create an account, please <a href="'.zen_href_link(FILENAME_LOGIN, '', 'SSL').'">click here.</a>');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Password Reset');
define('TEXT_DEAR', 'Dear ');
define('EMAIL_PASSWORD_REMINDER_BODY', '<br />Welcome to Doreenbeads!<br /><br />' . "\n\n" . 'If you forgot your password, please visit the following web page to reset your password ( link valid for 72 hours):' . '<br /><br />'
."\n\n".'<a href="%s">%s</a>'. '<br /><br />'."\n\n" . 'If you do not apply retrieve your password, please click the following link to cancel:' . '<br /><br />'."\n\n".'<a href="%s">%s</a>' . '<br /><br />'."\n\n".'Any question or problem, please feel free to <a href="mailto:'.EMAIL_FROM.'">contact us</a>, we are happy to assist.'. '<br /><br />'."\n\n" . 'Best Wishes' . '<br />' . "\n" . 'From Doreenbeads Service Team' . '<br />' . "\n" .'<a href="'. HTTP_SERVER.'">'. HTTP_SERVER.'</a>');
define('TEXT_SUCCESS_PASSWORD_SENT', 'We will send an email to your email address: %s in 2-5 minutes,which allows you to reset your password in 72 hours.');
define('TEXT_CHECK_CODE', 'Validate Code:');
define('TEXT_FORGOT_EMAIL_ADDRESS', 'If you also forgot your register email address, please <a href="mailto:'.EMAIL_FROM.'">contact us</a>.');
define('TEXT_INPUT_RIGHT_CODE', 'please input right validate code!');
?>
