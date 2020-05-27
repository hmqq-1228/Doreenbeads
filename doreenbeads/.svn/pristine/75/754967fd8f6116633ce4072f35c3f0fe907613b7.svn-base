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

define('EMAIL_TEXT_SUBJECT', 'Мы уже получили ваш платеж за заказ № %s');
define('EMAIL_TEXT_HEADER', 'Подтвежрдить заказ');
define('EMAIL_TEXT_PAYMENT_HEADER', 'Payment Confirmation from Doreenbeads');
define('EMAIL_TEXT_FROM',' from ');  //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING','Спасибо за покупку у нас сегодня!');
define('EMAIL_THANKS_FOR_PAYMENT','Благодарим за покупки с нами!Вы сделали платеж успешно, и мы будем организовать зауаривание и отправку вашего заказа как можно скорее.');
define('EMAIL_DETAILS_FOLLOW','Вот подробность вашего заказа.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Номер заказа:');
define('EMAIL_TEXT_INVOICE_URL', 'Побробный инвойс:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Нажимите здесь для подробного инвойса');
define('EMAIL_TEXT_DATE_ORDERED', 'Дата Заказа:');
define('EMAIL_TEXT_PRODUCTS', 'Товары');
define('EMAIL_TEXT_SUBTOTAL', 'Итого:');
define('EMAIL_TEXT_TAX', 'налог:        ');
define('EMAIL_TEXT_SHIPPING', 'Доставка: ');
define('EMAIL_TEXT_TOTAL', 'Всего:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Адрес доставки');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Платежный Адрес');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Способ оплаты');
define('HEADING_ADDRESS_TITLE', 'Мы отправим посылку до вашего адреса ниже ');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'через');

// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' Нет: ');
define('HEADING_ADDRESS_INFORMATION','Информация Адреса');
define('HEADING_SHIPPING_METHOD','Способ Доставки');
//define('TEXT_HTML_CHECKOUT_SHIPPING_ADDRESS', '<br /><span style="color:red;">Note:</span> Please make sure this shipping address is correct. After receive your payment, we will swiftly process your order and ship it out. We ship orders frequently. So that if you find this address is not correct, please contact us as soon as possible.<br /><br />');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Важное примечание о <b>Адресе Доставки</b>:</span> Проверяйте ваш адрес доставки,чтобы подтверждать его правильность,пожалуйста. Обычно мы будем отправлять вашу посылку в течение 1-2 дней после получения вашей оплаты.Поэтому,если вы замечаете то,что ваш адрес доставки не правильно написан,свяжитесь с нами на протяжении 24 часа как можно скорее<br /><br />');
define('TEXT_DISCOUNT_OFF','скидка');

//add by zhouliang 2011-09-09
define('EMAIL_ORDER_TRACK_REMIND','<font color="red">Не забудьте проверить свой электронный ящик для нашего  <b>сообщения отправки:</b></font><br />
	Мы будем обновлять состояние вашего заказа вовпремя. Вы будете получать сообщение об отправки посылки в течение 2 рабочих дней после оплаты. Поэтому если вы не получили сообшение отправки в это время,пожалуйста,свяжитесь с нами. Мы будем проверять ваш заказ как можно скорее, чтобы обеспечивать,что мы отправим вашу посылку без задержки. Спасибо за ваше время. :)<br /> <br />
	<font color="red">Если там 1 или некоторые товары нет в наличии, <b>Нам нужно ли с вами связаться перед отправкой?</b></font><br /><br />
	Обычно товары не будут распроданы ,потому что у нас достаточный запас под рукой,:) но эта ситуация---некоторые товары неожиаднно распроданы,случилась очень мало. Когда эта ситуация случится,мы будем вам отправлять сначала доступные товары,а для недостающих товаров,мы вам отправим кгода они снова доступеныбили отпраим их в вашим следующим заказом,или вернуем вам равные деньги,все эти завися от вас самого.Об этом мы будем подбрбно написывать в сообщении отправки.<br /><br />
	<font color="red">Внимние:</font> Если нам нужно вам сообщать,чтобы вы узнали,что некоторые товары в вашем заказе распроданы перед отправкой,пожалуйста,любезно отвечайте на наше письмо.Таким образом,мы свяжемся с вами вовремя,чтобы обсудить об обмене товара и т.д. .<br /><br />
	Спасибо за ваше время. :)<br /><br />
	( Доброе примечание: Если вы не получили наше письмо,вы можете проверять папку со спамом,инога сообщение,может быть, заблокировано случайно.) 	
	');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Важное примечание к<b>Адресу Доставки</b>:</span> Проверяйте ваш адрес доставки,чтобы подтверждать его правильность,пожалуйста. Обычно мы будем отправлять вашу посылку полсе получения вашей оплаты. Поэтому,если вы замечаете то,что ваш адрес доставки не правильно написан,свяжитесь с нами на протяжении 24 часа как можно скорее.<br /><br />');
//end
define('TEXT_PAYMENT_FAILURE', 'We are sorry, the payment was failed to made which may due to card information is incorrect, you could try again by another card if possisble. If it still failed, please kindly contact us at <a href=mailto:sale_ru@doreenbeads.com>sale_ru@doreenbeads.com</a>. Thank you for your time.');
?>
