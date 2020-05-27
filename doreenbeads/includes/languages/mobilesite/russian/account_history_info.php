<?php

/**

 * @package languageDefines

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: account_history_info.php 3027 2006-02-13 17:15:51Z drbyte $

 */

define('NAVBAR_TITLE', 'Мои настройки');

define('NAVBAR_TITLE_1', 'Мои настройки');

define('NAVBAR_TITLE_2', 'История');

define('NAVBAR_TITLE_3', 'Мои Заказы');



define('HEADING_DOWNLOAD_INTRODUCTION', 'Советы: Для перечней смешанных, отдельные фотографии каждого предмета (разных цветов / стиля) будут также <br/> скачаются ,нажав <img  style="vertical-align: middle;"  alt="" src="includes/templates/cherry_zen/buttons/'.$_SESSION['language'].'/button_download_pic.gif"><br/>
Если вы не можете скачать любую картинку, которой вы заинтересованы, пожалуйста, не стесняйтесь <a href ="'.HTTP_SERVER.'/ contact_us.html">связаться с нами. </a>');

define('HEADING_TITLE', 'Информация о заказах');

define('HEADING_ORDER_NUMBER', 'Заказ № %s');
define('HEADING_ORDER_DATE', 'Дата:');
define('HEADING_ORDER_TOTAL', 'Стоимость заказа:');

define('HEADING_DELIVERY_ADDRESS', 'Адрес доставки');
define('HEADING_SHIPPING_METHOD', 'Способ доставки');

define('HEADING_PRODUCTS', 'Товар');
define('HEADING_TAX', 'Налог');
define('HEADING_TOTAL', 'Всего');
define('HEADING_QUANTITY', 'Кол-во');



define('HEADING_BILLING_ADDRESS', 'Адрес плательщика');

define('HEADING_PAYMENT_METHOD', 'Способ оплаты');
define('HEADING_PAYMENT_METHODS', 'Способ оплаты');
define('BUTTON_QUICK_REORDER_ALT','Быстро вновь заказать продукты  в этом заказе');


define('HEADING_ORDER_HISTORY', 'История заказа');
define('TEXT_NO_COMMENTS_AVAILABLE', 'Нет комментариев.');
define('TABLE_HEADING_STATUS_DATE', 'Дата');
define('TABLE_HEADING_STATUS_ORDER_STATUS', 'Статус заказа');
define('TABLE_HEADING_STATUS_COMMENTS', 'Комментарии');
define('QUANTITY_SUFFIX', '&nbsp;шт.  ');
define('ORDER_HEADING_DIVIDER', '&nbsp;-&nbsp;');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');

//JESSA 2010-03-14
define('HEADING_MODEL','Номер Продукта');
define('HEADING_IMAGE','Картина');
//eof jessa 2010-03-14

//jessa 2010-05-10
define('DOWNLOAD_PIC','Скачать картины');
//eof jessa 2010-05-10
//define('TEXT_DOWNLOAD_PICTURE','Download Non-watermarked Picture');
//update wei.liang
define('TEXT_DOWNLOAD_PICTURE','Скачать картины без водяных знаков.Для перечней смешанных, отдельные фотографии каждого предмета (разных цветов / стиля) будут также скачаются.');
//out update wei.liang
define('TEXT_SEE_OUR_PICTURE','<strong>Смотреть Нашу <a href="' . zen_href_link(FILENAME_EZPAGES, 'id=97&chapter=0') . '" target="_blank">Авторизацию Картин>></a></strong>');

define('TEXT_VIEW_INVOICE_TITLE', 'Вы можете скачать счет-фактура здесь.');
define('TRACKING_PARCELS', 'Отслеживание Посылки');
//2.0
define('TEXT_PAYMENT_DETAILS', 'Реквизиты платежа');
define('TEXT_MAKE_PAYMENT', 'Сделайте оплату');
define('TEXT_YOU_VE_MADE_PAYMENT', 'Вы сделали оплату.');
define('TEXT_ORDER_DETAIL', 'Реквизиты заказа');
define('TEXT_INVOICE_VALUE', 'Фактурная стоимость');
define('TEXT_INVOICE_SHIPPING_FEE', 'Фактурная стоимость доставки');
define('TEXT_ITEM_DESCRIPTION', 'Описание товара помечены как');
define('TEXT_SHIPPING_ADDRESS','Адрес доставки');
define('TEXT_TRACKING_NUMBER','Трек номер');
define('TEXT_ORDER_CUMMENTS','Комментарии заказа');
define('TABLE_HEADING_WEIGHT', 'Вес');
define('TEXT_CREDIT_CARD_VISA_PAYPAL','<strong>Кредитная Карта Через PayPal</strong>'); 

define('TEXT_PACKET','упаковка');
define('TEXT_PACKET_2','упаковки');
define('TEXT_PACKET_3','упаковок');
define('TEXT_ACCOUNT_PERSONAL_INFORMATION','Личная Информация');
define('TEXT_ACCOUNT_TELEPHONE_NUMBER','Номер Телефона:');
define('TEXT_ACCOUNT_SHIPPING_ACCOUNT','Адрес Доставки:');
//2.1
define('TEXT_ACCONT_ENTER_AMOUNT','Пожалуйста, введите сумму.');
define('TEXT_ACCONT_ENTER_PAYMNET_DATE','Пожалуйста, введите даты оплаты.');
define('TEXT_ACCONT_ENTER_FIRST_NAME','Пожалуйста, введите имя.');
define('TEXT_ACCONT_ENTER_LAST_NAME','Пожалуйста, введите фамилию.');
define('TEXT_ACCONT_ENTER_ADDRESS','Пожалуйста, введите адрес.');
define('TEXT_ACCONT_ENTER_CONTROL_NO','Пожалуйста, введите контрольный номер.');
define('TEXT_ACCONT_ENTER_REMITTER','Пожалуйста, введите ФИО плательщика.');
define('TEXT_ACCONT_ENTER_PAYEE','Пожалуйста, введите полное имя получателя платежа.');
define('TEXT_ACCONT_ENTER_COUNTRY','Пожалуйста, введите вашу страну.');
define('TEXT_ACCONT_VIEW_INFO','Посмотреть инфо.');
define('TEXT_ACOOUNT_ORDER_NO','Номер Заказа:');
define('TEXT_ACOOUNT_DISCOUNT_COUPON','Купон на скидку');
define('TEXT_DISCOUNT_AMOUNT_TEXT','Сумма скидки');
//2.61
define('TEXT_PRODUCT_QUANTITY_UPDATED','Количество успешно обновилось.');
define('TEXT_ALREADY_EXISTED','Уже в корзине. Кол.');
define('TEXT_UPDATE_SUCCESSFULLY','успешно обновилось.');

define('TEXT_REORDER_PACKING_WAY_ONE','Если все распроданные товары будут в наличии в течении 5дней после оплаты, мне понравится ждить.');
define('TEXT_REORDER_PACKING_WAY_TWO','Отправляйте товары в наличии впервые.');
define('TEXT_REORDER_PACKING_WAY_THREE','Мне понравится ждить, если товары будут в наличии в течении 15 днейпосле оплаты. ');
define('TEXT_REORDER_PACKING_WAY_FOUR','Отправьте товары вместе, когда все в наличии.');
define('TEXT_REORDER_PACKING_WAY_FIVE','После 15 дней ожидания, сначала отправьте товары в наличии. Остальные отправьте потом.');
define('TEXT_ITEMS_REVIEW', 'Отзывы о Товарах');
define('TEXT_TOTAL_AMOUNT', 'Общая сумма');
?>