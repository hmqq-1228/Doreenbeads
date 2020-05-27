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
// $Id: email_extras.php 5454 2006-12-29 20:10:17Z drbyte $
//

// office use only
  define('OFFICE_FROM','From:');
  define('OFFICE_EMAIL','E-mail:');

  define('OFFICE_SENT_TO','Sent To:');
  define('OFFICE_EMAIL_TO','E-mail:');
  define('OFFICE_USE','Office Use Only:');
  define('OFFICE_LOGIN_NAME','Login Name:');
  define('OFFICE_LOGIN_EMAIL','Login e-mail:');
  define('OFFICE_LOGIN_PHONE','<strong>Telephone:</strong>');
  define('OFFICE_IP_ADDRESS','IP Address:');
  define('OFFICE_HOST_ADDRESS','Host Address:');
  define('OFFICE_DATE_TIME','Date and Time:');

// email disclaimer
  define('EMAIL_DISCLAIMER', 'Cette adresse E-mail nous a été indiquée par un de nos clients. Si vous pensez que vous recevez cet e-mail par erreur, merci de contacter %s');
  define('EMAIL_SPAM_DISCLAIMER','Cet e-mail est adressé en accord avec la Loi US CAN-SPAM du 01/01/2004. Nous respectons toute demande concernant la gestion de vos informations sur notre site.');
  define('EMAIL_FOOTER_COPYRIGHT','Copyright (c) ' . date('Y') . ' <a href="http://www.doreenbeads.com/" target="_blank">DoreenBeads</a>. Powered by <a href="http://www.doreenbeads.com/" target="_blank">DoreenBeads</a>');
  define('SEND_EXTRA_GV_ADMIN_EMAILS_TO_SUBJECT','[GV ADMIN SENT]');
  define('SEND_EXTRA_DISCOUNT_COUPON_ADMIN_EMAILS_TO_SUBJECT','[DISCOUNT COUPONS]');
  define('SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_SUBJECT','[ORDERS STATUS]');
  define('TEXT_UNSUBSCRIBE', "\n\nTo unsubscribe from future newsletter and promotional mailings, simply click on the following link: \n");
define('TEXT_EMAIL_NEWSLETTER', '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/gq3Ndv"><img src="https://img.doreenbeads.com/promotion_photo/fr/images/20190814/dbfr-abonnerheng.jpg" alt="Abonnez-vous ид notre newsletter maintenant"/></a></td>
					</tr>
				
				</table>');

// for whos_online when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Disabled');
?>