<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */

define('NAVBAR_TITLE', 'Mein Konto');
define('HEADING_TITLE', 'Mein Kontoinformation');

define('OVERVIEW_TITLE', 'Überblick');
define('OVERVIEW_SHOW_ALL_ORDERS', '(alle Bestellungen zeigen)');
define('OVERVIEW_PREVIOUS_ORDERS', 'Vorherige Bestellungen');
define('TABLE_HEADING_DATE', 'Bestelldatum');
define('TABLE_HEADING_ORDER_NUMBER', 'Bestellungsnummer');
define('TABLE_HEADING_SHIPPED_TO', 'Versand an');
define('TABLE_HEADING_STATUS', 'Status der Bestellung');
define('TABLE_HEADING_TOTAL', 'Gesamt');
define('TABLE_HEADING_VIEW', 'Anzeigen');

define('MY_ACCOUNT_TITLE', 'Mein Konto');
define('MY_ACCOUNT_INFORMATION', 'Meine Kontoinformationen zeigen oder verändern.');
define('MY_ACCOUNT_ADDRESS_BOOK', 'Einträgen in meinem Adressbuch zeigen oder verändern.');
define('MY_ACCOUNT_PASSWORD', 'Mein Konto-Passwort verändern.');

define('MY_ORDERS_TITLE', 'Meine Bestellungen');
define('MY_ORDERS_VIEW', 'Meine Bestellungen zeigen.');

define('EMAIL_NOTIFICATIONS_TITLE', 'E-Mail Benachrichtigungen');
define('EMAIL_NOTIFICATIONS_NEWSLETTERS', 'Newsletter abonnieren oder abbestellen.');
define('EMAIL_NOTIFICATIONS_PRODUCTS', 'Meine Produkt Benachrichtigungsliste zeigen oder verändern.');

//�ͻ�дreviews�йصĳ�������
define('TEXT_INVITED_WRITE_REVIEWS', 'Lieber Kunde/Liebe Kundin,<br />Bitte klicken Sie die folgende Bestellungen' . zen_image_button(BUTTON_IMAGE_VIEW_SMALL, BUTTON_VIEW_SMALL_ALT) . ' um Ihre Bestellungen zu sehen und die Bewertung schreiben. Ihre Meinung ist uns sehr wichtig. Vielen Dank!');

define('TEXT_CREDIT_ACCOUNT','<b><font color="#FF6600">Wegen Ihrer vorhertigern Bestellungen bekommen Sie<big>%s%.2f</big> in Iherm Credit Konto!!</font></b>Bitte hier anklicken  <a href="' . zen_href_link('cash_account', '', 'SSL') . '">Meine Kreditkonto</a> für mehr Details.</b>');
define('TEXT_CREDIT_ACCOUNT1','<b>Hooray!</b> Alle Ihre frühere Käufen betragen: US $%.2f .');
define('TEXT_CREDIT_ACCOUNT2','Herzlichen Glückwunsch! Sie sind jetzt <b>%s</b> unserer VIP Kunde. <b>%.2f</b>%% Rabatt kann auf Ihrer nächsten Bestellung angewendet werden. Kombiniert mit RCD wird der Gesamt Rabatt <b>%.2f</b>%%.<br />');
define('TEXT_GROUP_ACCOUNT1', 'Kumulieren Sie %.2f US$ mehr Bestellmenge um die Rabatte vom nächsten Level <b>%s</b>, <b>%.2f</b>%%  zu erreichen . Sehen Sie hier <a target="_blank" href="' . zen_href_link(FILENAME_EZPAGES, 'id=65') . '">VIP Vorteile</a>.<br /><br />');
define('TEXT_GROUP_ACCOUNT2', '<br/>Sie werden unser VIP Kunde sein. Viel Spaß beim <a target="_blank" href="' . zen_href_link(FILENAME_EZPAGES, 'id=65') . '">VIP Rabatt</a> so lange Sie neuen Bestellwert erreichen %.2f US$.<br /><br />');

define('TEXT_ALREADY_INCART0', 'Alle Artikel dieser Bestellung sind bereits im Warenkorb, können Sie die Menge direkt im Warenkorb ändern.');
define('TEXT_ALREADY_INCART1', 'Artikel %s ist bereits in Ihrem Warenkorb, können Sie die Menge direkt im Warenkorb ändern.');
define('TEXT_ALREADY_INCART2', 'Artikel %s bereits im Warenkorb, können Sie die Menge direkt im Warenkorb ändern.');

define('TEXT_REORDER_REMOVED_TIPS', '%s wurde entfernt und konnte nicht zum Warenkorb hinzugefügt werden. Für weitere Fragen kontaktieren Sie uns bitte über service_de@doreenbeads.com.');
?>