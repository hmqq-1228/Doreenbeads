<?php 

define('NAVBAR_TITLE', 'Passwort Vergessen');
define('TEXT_FORGET_PWD','Haben Sie Ihr Passwort vergessen?');
define('TEXT_MAIN','Geben Sie Ihre Register E-Mail-Adresse ein und wir werden Ihnen eine E-Mail mit Anweisungen zum Zurücksetzen Ihres Passwortes zusenden.');
define('TEXT_REQUIRED_INFO','Erforderliche Informationen');
define('TEXT_EMAIL_ADDRESS','Email Adresse:');
define('TEXT_CHECK_CODE', 'Code bestädigen:');
define('TEXT_SUBMIT','Vorlegen');
define('TEXT_BACK','Zurück');
define('TEXT_NOTE','Note:');
define('TEXT_FORGOT_EMAIL_ADDRESS', 'Wenn Sie Ihre Register Email Adresse vergeseen haben, <a href="mailto:'.EMAIL_FROM.'">kontaktieren Sie bitte uns</a>.');
define('TEXT_SUCCESS_PASSWORD_SENT', 'Wir werden eine E-Mail an Ihre E-Mail-Adresse: %s in 2-5 Minuten senden, mit der Sie ein neues Passwort in 72 Stunden festlegen können.');
define('TEXT_DEAR', '<br/>Liebe/Lieber %s,<br/>');
define('EMAIL_PASSWORD_REMINDER_BODY', '<br />Willkommen bei Doreenbeads!<br /><br />' . "\n\n" . 'Wenn Sie Ihr Passwort vergessen haben,besuchen Sie bitte die folgende Seite, um Ihr Passwort zurückzusetzen( link valid for 72 hours):' . '<br /><br />'
."\n\n".'<a href="%s">%s</a>'. '<br /><br />'."\n\n" . 'Wenn Sie Ihr Passwort nicht abfragen möchten, klicken Sie bitte auf den folgenden Link, um das abzubrechen:' . '<br /><br />'."\n\n".'<a href="%s">%s</a>' . '<br /><br />'."\n\n".'Wenn Sie fragen haben, schreiben Sie bitte uns ein Mail unter die Adresse<a href="mailto:'.EMAIL_FROM.'"></a>.Gerne stehen wir Ihnen für weitere Informationen'. '<br /><br />'."\n\n" . 'Mit freundlichen Grüßen' . '<br />' . "\n" . 'Ihr Doreenbeads Service Team' . '<br />' . "\n" .'<a href="'. HTTP_SERVER.'">'. HTTP_SERVER.'</a>');
define('STORE_NAME', 'doreenbeads.com');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Passwort zurücksetzen');
?>
