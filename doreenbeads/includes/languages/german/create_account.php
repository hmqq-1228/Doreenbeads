<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 5745 2007-02-01 00:52:06Z ajeh $
 */
define('NAVBAR_TITLE', 'Neues Konto erstellen');

define('HEADING_TITLE', 'Mein Konto Information');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTE:</strong> Wenn Sie bereits ein Konto haben, klicken Sie hier an <a href="%s">login page</a>.');

// greeting salutation
define('EMAIL_SUBJECT', 'Herzlich Willkommen bei ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");

define('TEXT_REMEMBER_ME', 'Angemeldet bleiben');
define('EMAIL_WELCOME', 'Welcome to ' . STORE_NAME . ' (Kostenloser Versand Perlen & Ergebnisse & Zubehör Großhandel). Vielen Dank für die Registrierung auf unserer Website, <b>folgende ist Ihre Account-Information:</b>');
define('EMAIL_CUSTOMER_EMAILADDRESS','<strong>Registrierte E-Mail-Adresse:</strong>');
define('EMAIL_CUSTOMER_PASSWORD','<strong>Kennwort:</strong>');
define('EMAIL_CUSTOMER_REG_DESCRIPTION','Sie können auf unserer Website einloggen und mit Ihrem Konto kaufen: <br /><a href="' . zen_href_link(FILENAME_DEFAULT) . '">www.doreenbeads.com</a>');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Herzlich willkommen bei doreenbeads.com!Unten finden Sie einen Gutschein nur für Sie. Wir freuen uns auf Ihren Besuch und wünschen Ihnen viel Spaß beim Kaufen!' . "\n\n");
define('EMAIL_COUPON_REDEEM', 'Jetzt den Gutschein einlösen' . TEXT_GV_REDEEM . ' Code beim Prüfung:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Der Gutschein ist gültig zwischen %s und %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Nur für heutigen Besuch. Wir haben Ihnen einen ' . TEXT_GV_NAME . ' für %s!' . "\n");
define('EMAIL_GV_REDEEM', 'Der ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' ist: %s ' . "\n\n" . 'Sie können ' . TEXT_GV_REDEEM .' nach Ihre Wahl eingeben. ');
define('EMAIL_GV_LINK', ' Or, you may redeem it now by following this link: ' . "\n");

define('EMAIL_GV_LINK_OTHER','Sobald Sie' . TEXT_GV_NAME . 'zu Ihrem Konto hinzugefügt haben, können Sie' . TEXT_GV_NAME . ' für Sie sich selbst einlösen, oder schicken Sie den zu Ihrem Freund!' . "\n\n");

define('EMAIL_TEXT', 'Wir bieten einen Cash Coupon als erstes Geschenk für Ihren Einkauf auf unserer Website. Sie können damit 6.01US$ sparen <span style="color:red">wenn Ihr erster Kauf 30 USD erreicht.</span>.<br /><div style="border:1px dashed #FF99CC; padding:6px;"><b>Enjoy 6.01US$ Cash Coupon</b><br />Coupon code: <span style="color:red;">DoreenBeads</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coupon: <span style="color:red;">6.01US$</span><br /><b>**Tips:</b>Please input DoreenBeads.com in redemption box on our website during step 2 checking out procedure, then 6.01US$ coupon will be subtracted automatically.<br /><span style="color:red;">Please be hurry to use this code, because it will be expired 2 weeks later.</span></div>');
define('EMAIL_CONTACT', 'Wenn Sie Fragen haben, kontaktieren Sie bitte uns:<br />1. Klicken Sie auf Livehelp Button auf unserer Hauptseite<br />2. schicken Sie uns ein Eimal unter dieser Adresse <a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a><br /><br />');
define('EMAIL_KINDLY_NOTE', '<span style="color:red;"><b>** Bitte beachten Sie: </b></span>bitte behalten Sie dies E-Mail. Wenn Sie Ihr Passwort vergessen haben, können Sie das überprüfen.');
define('EMAIL_GV_CLOSURE','Sincerely' . "\n" . 'Doreenbeads Team' . "\n\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Ihre Email Adresse haben wir von Ihnen oder von einem anderen Kunde bekommen. Wenn Sie kein Benutzerkonto bei uns haben oder unser Email nicht mehr bekommen möchten, schicken Sie bitte uns ein Email unter dieser Adresse %s ');
?>