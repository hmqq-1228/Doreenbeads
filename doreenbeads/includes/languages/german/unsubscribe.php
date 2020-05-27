<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @copyright Originally Programmed By: Christopher Bradley (www.wizardsandwars.com) for OsCommerce
 * @copyright Modified by Jim Keebaugh for OsCommerce
 * @copyright Adapted for Zen Cart
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: unsubscribe.php 3159 2006-03-11 01:35:04Z drbyte $
 */
define('NAVBAR_TITLE', 'Stornieren');
define('HEADING_TITLE', 'Newsletter Stornieren');

define('UNSUBSCRIBE_TEXT_INFORMATION', '<br />Es tut uns leid, dass Sie unseren Newsletter stornieren möchten. Wenn Sie Sorge um Ihre Privatsphäre haben, lesen Sie bitte  <a href="' . zen_href_link(FILENAME_PRIVACY,'','NONSSL') . '"><span class="pseudolink">Datenschutz</span></a>.<br /><br />Von unserer Newsletters bekommen Sie Informationen über neue Produkte, Preissenkungen und Neuerungen.<br /><br />Wenn Sie unseren Newsletter nicht mehr erhalten möchten, klicken Sie bitte auf die Schaltfläche unten. ');
define('UNSUBSCRIBE_TEXT_NO_ADDRESS_GIVEN', '<br />Es tut uns leid, dass Sie unseren Newsletter stornieren möchten. Wenn Sie Sorge um Ihre Privatsphäre haben, lesen Sie bitte  <a href="' . zen_href_link(FILENAME_PRIVACY,'','NONSSL') . '"><span class="pseudolink">Datenschutz</span></a>.<br /><br />Von unserer Newsletters bekommen Sie Informationen über neue Produkte, Preissenkungen und Neuerungen.<br /><br />Wenn Sie unseren Newsletter nicht mehr erhalten möchten, klicken Sie bitte auf die Schaltfläche unten. Sie werden zu der Seite Konto-Einstellungen geleitet, wo Sie Ihre Abonnements bearbeiten können. Bitte melden Sie sich zuerst an.');
define('UNSUBSCRIBE_DONE_TEXT_INFORMATION', '<br />Wie Sie verlangen haben wir Ihre E-Mail-Adresse unten aus unserer Newsletter-Liste entfernt. <br /><br />');
define('UNSUBSCRIBE_ERROR_INFORMATION', '<br />Die von Ihnen angegebene E-Mail-Adresse wurde in unserer Newsletter Datenbank nicht gefunden, oder wurde bereits aus unserer Newsletter Abo-Liste entfernt. <br /><br />');
?>