<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tell_a_friend.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Invitar a Amigos');

define('HEADING_TITLE', 'Invitar a Amigos ’%s’');
define('FORM_FIELD_CUSTOMER_NAME', 'Your Name:');
define('FORM_TITLE_CUSTOMER_DETAILS', 'Your Details');
define('FORM_TITLE_FRIEND_DETAILS', 'Your Friend’s Details');
define('FORM_TITLE_FRIEND_MESSAGE', 'Your Message:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Your Friend’s Email:');
define('FORM_FIELD_FRIEND_EMAIL', 'Your Friend’s Email:');

define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Your email about <strong>%s</strong> has been successfully sent to <strong>%s</strong>.');

define('EMAIL_TEXT_HEADER','Important Notice!');

define('EMAIL_TEXT_SUBJECT', 'Your friend %s has recommended this great product from %s');
define('EMAIL_TEXT_GREET', 'Hi %s!' . "\n\n");
define('EMAIL_TEXT_INTRO', 'Your friend, %s, thought that you would be interested in %s from %s.');

define('EMAIL_TELL_A_FRIEND_MESSAGE','%s sent a note saying:');

define('EMAIL_TEXT_LINK', 'To view the product, click on the link below or copy and paste the link into your web browser:' . "\n\n" . '%s');
define('EMAIL_TEXT_SIGNATURE', 'Regards,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'Error: Your name must not be empty.');
define('ERROR_TO_ADDRESS', 'Error: Your friend’s email address does not appear to be valid. Please try again.');
define('ERROR_FROM_NAME', 'Error: Your name must not be empty.');
define('ERROR_FROM_ADDRESS', 'Error: Your email address does not appear to be valid. Please try again.');
//	v2.80 2015-04-22
define('INVITE_FRIENDS_TITLE', 'Por cada amigo que invite a DoreenBeads, vamos a darle un Cupón gratis en efectivo <span>hasta USD15.</span>');
define('INVITE_FRIENDS_BYEMAIL', 'Invite a sus amigos por e-mail:');
define('INVITE_FRIENDS_EMAIL_ENTER', 'Ingrese los correos electrónicos de sus amigos aquí. Se necesita una coma para la lista separada de los correos electrónicos.');
define('INVITE_FRIENDS_BYOTHER', 'O Invite a sus amigos por otras maneras:');
define('INVITE_FRIENDS_COPYLINK', 'Enlace copiado');
define('INVITE_FRIENDS_SEND', 'Enviar');
define('INVITE_FRIENDS_SHAREFB', 'Compartir en Facebook');
define('INVITE_FRIENDS_SHARETW', 'Compartir en Twitter');
define('INVITE_FRIENDS_SHAREVK', 'Поделиться В Контакте');
define('INVITE_FRIENDS_SHAREOD', 'Поделиться в однокласснике');
define('INVITE_FRIENDS_DESCRIPTION', '* Despues de que su amigo haga un pedido más de $10 en Doreenbeads, usted va a obtener un cupón gratis en efectivo hasta USD15. El valor del cupón depende de la cantidad del pedido de sus amigos.');
define('INVITE_FRIENDS_MAIL_TITLE', 'Recomendado altamente el Doreenbeads');
define('INVITE_FRIENDS_MAIL_CONT1', 'Hola'."<br />\n".'He comprado todos tipos de suministros y artesanías de Joyería en Doreenbeads. Ellos tienen gran selección y todos los artículos de envío gratis. ¡Recomendado altamente! Echa un vistazo a través de siguiente enlace:'."<br />\n");
define('INVITE_FRIENDS_MAIL_CONT2', 'Saludos'."<br />\n".'DoreenBeads Equipo');
define('INVITE_FRIENDS_EMAIL_EMPTY', 'E-mail inválido.');
define('INVITE_FRIENDS_EMAIL_WRONG', 'E-mail inválido.');
define('INVITE_FRIENDS_EMAIL_SUCC', 'E-mail enviado con éxito.');
?>
