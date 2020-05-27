<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Resgistrarse');
define('NAVBAR_TITLE_2', 'Contraseña olvidada');
define('HEADING_TITLE', '¿Ha olvidado la contraseña?');

define('TEXT_MAIN', 'Ingrese su dirección de correo electrónico de registro y le enviaremos un correo electrónico con instrucciones sobre cómo restablecer su contraseña.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Una cuenta con la dirección de correo electrónico no se pudo encontrar.  - Si necesita crear una cuenta, por favor <a href="' .zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'). '">haga clic aquí.</a>');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', 'STORE_NAME .  - Restablecer Contraseña');
define('TEXT_DEAR', 'Estimado');

define('EMAIL_PASSWORD_REMINDER_BODY', '<br />Bienvenido a 8Seasons!<br /><br />' . "\n\n" . 'Si ha olvidado su contraseña, por favor visite la siguiente página  web para restablecer su contraseña (enlace válido por 72 horas):' . '<br /><br />'
 ."\n\n". '<a href="%s">%s</a>' . '<br /><br />' ."\n\n" . 'Si usted no aplica a recuperar su contraseña, por favor haga clic en el siguiente enlace para cancelarlo:' . '<br /><br />' ."\n\n". '<a href="%s">%s</a>' . '<br /><br />' ."\n\n". 'Cualquier pregunta o preblema, no dude en<a href="mailto:' .EMAIL_FROM. '">ponerse en contacto con nosotros</a>, Estamos encantados de ayudarle. ' . '<br /><br />' ."\n\n" . 'Saludos' . '<br />' . "\n" . 'De grupo de servicio de 8seasons' . '<br />' . "\n" . '<a href="' . HTTP_SERVER. '">' . HTTP_SERVER. '</a>');

define('TEXT_SUCCESS_PASSWORD_SENT', 'Vamos a enviar un correo a la dirección de su email: %s en 2-5 minutos , que puede devolver a poner la contraseña en 72 horas.');
define('TEXT_CHECK_CODE', 'Código de validación');
define('TEXT_FORGOT_EMAIL_ADDRESS', 'Si también ha olvidado su dirección de correo electrónico de registro, por favor <a href="mailto:' .EMAIL_FROM. '">póngase en contacto con nosotros</a>');
define('TEXT_INPUT_RIGHT_CODE', 'Por favor ingrese correctamente el código de validación.');

?>
