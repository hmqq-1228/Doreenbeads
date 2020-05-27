<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */
define('NAVBAR_TITLE_1', 'Se Connecter');
define('NAVBAR_TITLE_2', 'Mot de pass oublié?');
define('HEADING_TITLE', 'Mot de pass oublié?');
define('TEXT_MAIN', 'Veuillez entrer l’adresse d’e-mail de vous enregistrer, nous vous envoyerons les instructions à remetter le mot de passe.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'An account with this email address could not be found.  - If you need to create an account, please <a href="'.zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL').'">click here.</a>');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Remettre le mot de passe');
define('TEXT_DEAR', 'Bonjour ');
define('EMAIL_PASSWORD_REMINDER_BODY', '<br />Welcome to Doreenbeads!<br /><br />' . "\n\n" . 'Si vous avez oublié le mot de passe, vueillez visiter la page suivante è le remettre( le lien est valide valid pendant 72H):' . '<br /><br />'
."\n\n".'<a href="%s">%s</a>'. '<br /><br />'."\n\n" . 'Si vous n’avez pas demandé à remettre le mot de passe, If you do not apply retrieve your password, veuillez cliquer le lien suivant à supprimer:' . '<br /><br />'."\n\n".'<a href="%s">%s</a>' . '<br /><br />'."\n\n".'Si vous avez des problèmes, n’hésitez pas à<a href="mailto:'.EMAIL_FROM.'">nous contacter</a>, c’est notre plaisir de vous aider.'. '<br /><br />'."\n\n" . 'Cordialement' . '<br />' . "\n" . 'Equipe Doreenbeads' . '<br />' . "\n" .'<a href="'. HTTP_SERVER.'">'. HTTP_SERVER.'</a>');
define('TEXT_SUCCESS_PASSWORD_SENT', 'Nous vous enverrons un courriel à votre adresse mail: %s en 2 à 5 minutes, ce qui vous permet de réinitialiser votre mot de passe en 72 heures.');
define('TEXT_CHECK_CODE', 'Code valide:');
define('TEXT_FORGOT_EMAIL_ADDRESS', 'Si vous avez aussi oublié la boîte d’e-mail de vous enregister,<a href="mailto:'.EMAIL_FROM.'">contactez nous!</a>.');
define('TEXT_INPUT_RIGHT_CODE', 'Veuillez entrer le code valide correct!');
?>
