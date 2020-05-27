<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: discount_coupon.php 4591 2006-09-23 04:25:15Z ajeh $
//

define('NAVBAR_TITLE', 'Cupones de descuento');
define('HEADING_TITLE', 'Cupones de descuento');

define('TEXT_INFORMATION', '');
define('TEXT_COUPON_FAILED', '<span class="alert important">%s</span> no parece ser un código de canje de cupón válido. Por favor, pruebe a ingresar de nuevo.');
define('HEADING_COUPON_HELP', 'Ayuda de Cupón de descuento');
define('TEXT_CLOSE_WINDOW', 'Cerrar Ventana[x]');
define('TEXT_COUPON_HELP_HEADER', '<p class="bold">El código de canje de cupón de descuento que ha ingresado es para');
define('TEXT_COUPON_HELP_NAME', '’%s’. </p>');
define('TEXT_COUPON_HELP_FIXED', '');
define('TEXT_COUPON_HELP_MINORDER', '');
define('TEXT_COUPON_HELP_FREESHIP', '');
define('TEXT_COUPON_HELP_DESC', '<p><span class="bold">Oferta de Descuentos:</span> %s</p><p class="smallText">Es posible que se apliquen otras restricciones. Consulte debajo para más detalles.</p>');
define('TEXT_COUPON_HELP_DATE', '<p> El cupón es válido entre% s y% s </ p>');
define('TEXT_COUPON_HELP_RESTRICT', '<p class="biggerText bold">Restricciones de cupones de descuento</p>');
define('TEXT_COUPON_HELP_CATEGORIES', '<p class="bold">Limitaciones de categorías:</p>');
define('TEXT_COUPON_HELP_PRODUCTS', '<p class="bold">Producto con restricciones:</p>');
define('TEXT_ALLOW', 'permitir');
define('TEXT_DENY', 'negar');
define('TEXT_NO_CAT_RESTRICTIONS', '<p> Este cupón es válido para todas las categorías. </ p>');
define('TEXT_NO_PROD_RESTRICTIONS', '<p> Este cupón es válido para todos los productos. </ p>');
define('TEXT_CAT_ALLOWED', '(Válido para esta categoría)');
define('TEXT_CAT_DENIED', '(No se permite en esta categoría)');
define('TEXT_PROD_ALLOWED', '(Válido para este producto)');
define('TEXT_PROD_DENIED', '(Producto no autorizado)');

// gift certificates cannot be purchased with Discount Coupons
define('TEXT_COUPON_GV_RESTRICTION', '<p class="smallText">Cupones de descuento no se pueden aplicar a la compra de ' . TEXT_GV_NAMES . ' . Límite de 1 cupón por orden.</p>');
define('TEXT_DISCOUNT_COUPON_ID_INFO', 'Encontrar cupón de descuento ...');
define('TEXT_DISCOUNT_COUPON_ID', 'Su Código:');
define('TEXT_COUPON_GV_RESTRICTION_ZONES', 'Se aplican restricciones de dirección de facturación');

?>