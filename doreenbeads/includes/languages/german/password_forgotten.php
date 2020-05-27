<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */
define('NAVBAR_TITLE_1', 'Anmelden');
define('NAVBAR_TITLE_2', 'Passwort Vergessen');
define('HEADING_TITLE', 'Haben Sie Ihr Passwort vergessen?');
define('TEXT_MAIN', 'Geben Sie Ihre Register E-Mail-Adresse ein und wir werden Ihnen eine E-Mail mit Anweisungen zum Zurücksetzen Ihres Passwortes zusenden.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Ein Konto mit dieser E-Mail-Adresse konnte nicht gefunden werden.  - Wenn Sie ein neues Konto haben möchten, <a href="'.zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL').'">klicken Sie bitte hier an.</a>');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Passwort zurücksetzen');
define('TEXT_DEAR', 'Liebe/Lieber ');
define('EMAIL_PASSWORD_REMINDER_BODY', '<br />Willkommen bei Doreenbeads!<br /><br />' . "\n\n" . 'Wenn Sie Ihr Passwort vergessen haben,besuchen Sie bitte die folgende Seite, um Ihr Passwort zurückzusetzen( link valid for 72 hours):' . '<br /><br />'
."\n\n".'<a href="%s">%s</a>'. '<br /><br />'."\n\n" . 'Wenn Sie Ihr Passwort nicht abfragen möchten, klicken Sie bitte auf den folgenden Link, um das abzubrechen:' . '<br /><br />'."\n\n".'<a href="%s">%s</a>' . '<br /><br />'."\n\n".'Wenn Sie fragen haben, schreiben Sie bitte uns ein Mail unter die Adresse<a href="mailto:'.EMAIL_FROM.'"></a>.Gerne stehen wir Ihnen für weitere Informationen'. '<br /><br />'."\n\n" . 'Mit freundlichen Grüßen' . '<br />' . "\n" . 'Ihr Doreenbeads Service Team' . '<br />' . "\n" .'<a href="'. HTTP_SERVER.'">'. HTTP_SERVER.'</a>');
define('TEXT_SUCCESS_PASSWORD_SENT', 'Wir werden eine E-Mail an Ihre E-Mail-Adresse: %s in 2-5 Minuten senden, mit der Sie ein neues Passwort in 72 Stunden festlegen können.');
define('TEXT_CHECK_CODE', 'Code bestädigen:');
define('TEXT_FORGOT_EMAIL_ADDRESS', 'Wenn Sie Ihre Register Email Adresse vergeseen haben, <a href="mailto:'.EMAIL_FROM.'">kontaktieren Sie bitte uns</a>.');
define('TEXT_INPUT_RIGHT_CODE', 'Bitte das Bestätigen-Code einben!');
?>
