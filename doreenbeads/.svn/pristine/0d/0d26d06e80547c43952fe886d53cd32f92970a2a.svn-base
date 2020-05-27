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
// $Id: checkout_process.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('EMAIL_TEXT_SUBJECT', 'Confirmación de Pedido');
define('EMAIL_TEXT_HEADER', 'Confirmación de Pedido');
define('EMAIL_TEXT_FROM',' desde');  //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING','¡Muchas gracias por su patrocinio!');
define('EMAIL_THANKS_FOR_PAYMENT','Thanks for shopping with us today! You have made the payment successfully, we will ship your order as soon as possible.');
define('EMAIL_DETAILS_FOLLOW','Los detalles de su pedido');
define('EMAIL_TEXT_ORDER_NUMBER', 'Número del Pedido:');
define('EMAIL_TEXT_INVOICE_URL', 'Factura Detallada:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Haga clic aquí para ver la factrua detallada');
define('EMAIL_TEXT_DATE_ORDERED', 'Fecha del pedido:');
define('EMAIL_TEXT_PRODUCTS', 'Productos');
define('EMAIL_TEXT_SUBTOTAL', 'SubTotal:');
define('EMAIL_TEXT_TAX', 'Impuestos:        ');
define('EMAIL_TEXT_SHIPPING', 'Envío: ');
define('EMAIL_TEXT_TOTAL', 'Total:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Dirección de Entrega');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Dirección de Facturación');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Método de Pago');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'vía');

// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' Número: ');
define('HEADING_ADDRESS_INFORMATION','Información de Dirección');
define('HEADING_SHIPPING_METHOD','Método del Envío');
//define('TEXT_HTML_CHECKOUT_SHIPPING_ADDRESS', '<br /><span style="color:red;">Note:</span> Please make sure this shipping address is correct. After receive your payment, we will swiftly process your order and ship it out. We ship orders frequently. So that if you find this address is not correct, please contact us as soon as possible.<br /><br />');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Nota importante sobre <b>Dirección de Entrega</b>:</span> P Por favor asegúrese de que la  dirección de entrega de arriba es correta. Normalmente al recibir su pago, le enviaremos el paquete ensequida, entonces si usted encuentra que esta dirección no es correcta, por favor póngase en contaco con nosotros dentro de 24 horas.<br /><br />');

//add by zhouliang 2011-09-09
define('EMAIL_ORDER_TRACK_REMIND','<font color="red">Asegúrese de revisar su buzón de correo electrónico de nuestra <b>notificación del envío:</b></font><br />
  Le mantendremos la actualización sobre el estado del pedido en tiempo. Usted va a recibir una notificación del envío dentro de 2 días laborales después de hacer el pago. Así que si usted no ha recibido la notificación del envío en este período, no dude en contactar con nosotros. Vamos a revisar su pedido lo más antes posible, para asegurar que podemos enviar sus paquetes sin demora. Gracias por su tiempo. :)<br /> <br />
  <font color="red">Si hay uno o varios artículos que están fuera de stock, <b>¿podemos contactarnos con usted antes del envío?</b></font><br /><br />
  Normalmente los artículos no están fuera de stock, ya que tenemos suficiente stock en mano,:) pero en algunas ocasiones, algún artículo está agotado inesperadamente. Cuando esto suceda, nuestra política por defecto es arreglar el envío de artículos disponibles en primer momento, y los artículos fuera del stock, se le enviaremos cuando estén disponibles de nuveo, o se le enviaremos juntos con su siguiente orden, o le haremos el igual crédito, y eso depende de usted. Vamos a exponer detalladamente en la notificación del envío.<br /><br />
  <font color="red">Atención:</font> Si tenemos que contactar con usted para hacerle saber cuáles son los artículos que están agotados antes de la expedición, por favor, responda este correo electrónico. Así que podremos ponernos en contacto con usted en tiempo para hablar sobre el intercambio de artículos,etc.<br /><br />
  Gracias por su tiempo. :)
<br /><br />
	(Por favor tenga en cuenta: Usted puede revisar su carpeta de correo no deseado si no se ha recibido el correo electrónico, y a veces, el mensaje puede ser bloqueado por accidente.) 	
	');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Nota importante sobre <b>Dirección de entrega</b>:</span> Por favor asegúrese de que la  dirección de entrega de arriba es correta. Normalmente al recibir su pago, le enviaremos el paquete ensequida, entonces si usted encuentra que esta dirección no es correcta, por favor póngase en contaco con nosotros dentro de 24 horas.<br /><br />');
//end
?>
