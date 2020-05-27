<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 5745 2007-02-01 00:52:06Z ajeh $
 */

define('NAVBAR_TITLE', 'Crear cuenta');

define('HEADING_TITLE', 'Información de mi cuenta');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTA:</strong> Si ya tiene una cuenta con nosotros, por favor, entre en <a href="%s">su cuenta</a>.');


// greeting salutation
define('EMAIL_SUBJECT', 'Bienvenido a ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Estimado Sr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Estimada Sra. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Estimado %s' . "\n\n");

define('TEXT_REMEMBER_ME', 'Recordarme');
define('EMAIL_WELCOME', 'Bienvenido a ' . STORE_NAME . ' (Envío Gratis Proveedor de Cuentas& Abalorios& Accesorios). Muchas gracias por registrarse en nuestro sitio web <b>Su información de Cuenta es:</b>');
define('EMAIL_CUSTOMER_EMAILADDRESS','<strong>Dirección Registrada de Email:</strong>');
define('EMAIL_CUSTOMER_PASSWORD','<strong>Cotraseña:</strong>');
define('EMAIL_CUSTOMER_REG_DESCRIPTION','Puede iniciar sesión en  nuestro sitio web y empezar a hacer compras con su cuenta ahora: <br /><a href="' . zen_href_link(FILENAME_DEFAULT) . '">www.doreenbeads.com</a>');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', '¡Felicidades! Para hacer de su próxima visita a nuestra tienda online una experiencia más gratificante, ¡Aquí tiene un cupón de descuento creado para usted!' . "\n\n");
define('EMAIL_COUPON_REDEEM', 'Para usar el cupón de descuento, ingrese el ' . TEXT_GV_REDEEM . 'código en el proceso del pago:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>El cupón es válido entre %s y %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Sólo por hacer las compras de hoy, ¡le enviamos un ' . TEXT_GV_NAME . ' por %s!' . "\n\n");

define('EMAIL_GV_REDEEM', 'El ' . TEXT_GV_REDEEM . ' del ' . TEXT_GV_NAME . ' es: %s ' . "\n\n" . 'Puede ingresar el ' . TEXT_GV_REDEEM . ' durante el pago, después de haber elegido productos en la tienda.');
define('EMAIL_GV_LINK', 'o puede canjearlo ahora siguiendo este link: ' . "\n");


define('EMAIL_GV_LINK_OTHER', 'Una vez que haya agregado el ' . TEXT_GV_NAME . ' a su cuenta, puede usar el ' . TEXT_GV_NAME . ' para usted, ¡o enviárselo a un amigo!' . "\n\n");

define('EMAIL_TEXT', 'En particular, ahora ofrecemos especialmente un cupón de efectivo como el primer regalo para su compra en nuestro sitio web. Puede utilizarlo para guardar 6.01US $ <span style = "color: red"> cuando su primera compra alcanza a 30 USD </span> <br /> <div style = "border: 1px discontinua # FF99CC; padding:. 6px ; "> <b> Disfrutará del cupón de 6.01US $. </ b> <br />El código de cupón es: <span style="color:red;">DoreenBeads</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coupon: <span style = "color: red;"> 6.01US $ </span> <br /> <b> ** Extremidades: </ b> Por favor introduce DoreenBeads.com en caja redención en nuestro sitio web durante el paso 2 de cheques a cabo el procedimiento ., entonces 6.01US $ cupón se resta automáticamente. <br /> <span style = "color: red;"> Por favor tenga prisa para utilizar este código, ya que será vencido después de 2 semanas. </span> </ div. > ');
define('EMAIL_CONTACT', 'Si necesita nuestra ayuda, puede contactarnos por:<br />1. Hacer clic en el botón de Chat en Vivo en la página principal<br />2. o enviarnos un email a<a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a><br /><br />');
define('EMAIL_KINDLY_NOTE', '<span style="color:red;"><b>** Nota: </b></span>Por favor, mantenga este email bien. Si olvida su contraseña en el futuro, puede encontrarla con este email..');
define('EMAIL_GV_CLOSURE','Atentamente' . "\n" . 'Equipo Doreenbeads' . "\n\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Este email nos ha sido facilitado por usted o por alguien que se ha registrado en nuestra tienda. Si no ha sido usted, o piensa que ha recibido este mensaje por error, por favor, envíe un email a %s ');
?>
