<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

define('NAVBAR_TITLE', 'Tiempo de inicio de sesión expirado');
define('HEADING_TITLE', '¡Vaya! Su sesión ha expirado.');
define('HEADING_TITLE_LOGGED_IN', '¡Vaya! Lo sentimos, pero no se le permite realizar la acción solicitada. ');
define('TEXT_INFORMATION', '<p>Si estaba cursando la orden, por favor, inicia sesión y su cesta de la compra será restaurada. Puede volver a pagar la orden y completar sus compras .</p><p>Si usted ya ha completado el pedido y desea revisarlo' : '') . ', o tenía una descarga y deseo para recuperarlo' : '') . ', puede ir a<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mi Cuenta</a> para ver su orden.</p></p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Todavía está conectado a su cuenta y puede seguir comprando. Elija un objeto desde el menú.');

define('HEADING_RETURNING_CUSTOMER', 'Inicioar Sesión');
define('TEXT_PASSWORD_FORGOTTEN', '¿Ha olvidado su contraseña?')
?>