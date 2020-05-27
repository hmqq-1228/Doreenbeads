<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>Von:</strong>');
  define('OFFICE_EMAIL','<strong>Email:</strong>');

  define('OFFICE_SENT_TO','<strong>Gesendet an:</strong>');
  define('OFFICE_EMAIL_TO','<strong>To Email:</strong>');

  define('OFFICE_USE','<strong>Office Use Only:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>Login Name:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>Login Email:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>Telefon:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>Fax:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>IP Adresse:</strong>');
  define('OFFICE_HOST_ADDRESS','<strong>Host-Adresse:</strong>');
  define('OFFICE_DATE_TIME','<strong>Datum und Zeit:</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'OFF');

// email disclaimer
  define('EMAIL_DISCLAIMER', 'Diese E-Mail-Adresse wurde von Ihnen oder von unserem Kunden gegeben. Wenn Sie dies Email nicht mehr bekommen möchten, schicken Sie bitte uns ein Email unter %s ');
  define('EMAIL_SPAM_DISCLAIMER','Dies E-Mail wird in Übereinstimmung mit dem US-CAN-SPAM Gesetz in Wirklichkeit 01/01/2004 gesendet. Entfernung-Anfragen können an diese Adresse geschickt, sowie geehrt und respektiert werden.');
  define('EMAIL_FOOTER_COPYRIGHT','Copyright (c) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="https://www.doreenbeads.com/" target="_blank">DoreenBeads</a>');
  define('TEXT_UNSUBSCRIBE', "\n\nUm zukünftige Newsletter und Werbesendungen abzubestellen, klicken Sie einfach auf den folgenden Link: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANT:</strong> Aus Sicherheitsgründen und um Missbrauch zu verhindern werden alle durch diese Website gesendete Emails protokolliert, die Inhalte aufgezeichnet von dem Ladenbesitzer verfügbar. Wenn Sie dies Email nicht mehr bekommen möchten, schicken Sie bitte uns ein Email unter  ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>Diese Nachricht ist in allen E-Mails dieser Seite enthalten:</strong>');
define('TEXT_EMAIL_NEWSLETTER', '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/gq4YqX"><img src="https://img.doreenbeads.com/promotion_photo/de/images/20190812/550X100de.jpg" alt="Abonnieren Sie jetzt unseren Newsletter"/></a></td>
					</tr>
				
				</table>');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT','[CREATE ACCOUNT]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT','[TELL A FRIEND]');
  define('SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT','[GV CUSTOMER SENT]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT','[NEUE BESTELLUNG]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[EXTRA CC ORDER info] #');

// Low Stock Emails
  define('EMAIL_TEXT_SUBJECT_LOWSTOCK','Achtung: Niedriger Lagerbestand');
  define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE','Niedriger Lagerbestand Nachricht: ');

// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Ungültig');
?>