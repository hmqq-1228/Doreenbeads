<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

define('NAVBAR_TITLE', 'Anmeldung Timeout');
define('HEADING_TITLE', 'Whoops! Ihre Session ist abgelaufen.');
define('HEADING_TITLE_LOGGED_IN', 'Whoops! Es tut uns leid. Sie sind nicht nicht erlaubt, die angeforderte Aktion auszuführen. ');
define('TEXT_INFORMATION', '<p>Beim Bestellen anmelden Sie sich bitte und Ihr Warenkorb wird wiederhergestellt. You may then go back to the checkout and complete your final purchases.</p><p>If you had completed an order and wish to review it' . (DOWNLOAD_ENABLED == 'true' ? ', or had a download and wish to retrieve it' : '') . ', please go to your <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">My Account</a> page to view your order.</p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Sie sind schon angemeldet und können weiter kaufen. Bitte wählen Sie einen Zielort aus einem Menü.');

define('HEADING_RETURNING_CUSTOMER', 'Anmelden');
define('TEXT_PASSWORD_FORGOTTEN', 'Passwort vergessen?')
?>