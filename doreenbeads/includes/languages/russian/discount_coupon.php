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

define('NAVBAR_TITLE', 'Купон на Скидку');
define('HEADING_TITLE', 'Купон на Скидку');

define('TEXT_INFORMATION', '');
define('TEXT_COUPON_FAILED', '<span class="alert important">%s</span> не является допустимым Кодом Купона Выкупа. Пожалуйста, попробуйте ввести его снова.');

define('HEADING_COUPON_HELP', 'Помощь для Купона на Скидку');
define('TEXT_CLOSE_WINDOW', 'Закрыть окно [x]');
define('TEXT_COUPON_HELP_HEADER', '<p class="bold">Код Купона Выкупа, который вы ввели, для ');
define('TEXT_COUPON_HELP_NAME', '’%s’. </p>');
define('TEXT_COUPON_HELP_FIXED', '');
define('TEXT_COUPON_HELP_MINORDER', '');
define('TEXT_COUPON_HELP_FREESHIP', '');
define('TEXT_COUPON_HELP_DESC', '<p><span class="bold">Скидка:</span> %s</p><p class="smallText">Некоторые другие ограничения могут быть доступны. Пожалуйста, смотрите следующие другие товары.</p>');
define('TEXT_COUPON_HELP_DATE', '<p>Купон действует с %s до %s</p>');
define('TEXT_COUPON_HELP_RESTRICT', '<p class="biggerText bold">Ограничения купона на скидку</p>');
define('TEXT_COUPON_HELP_CATEGORIES', '<p class="bold">Ограничения категории:</p>');
define('TEXT_COUPON_HELP_PRODUCTS', '<p class="bold">Ограничения категории:</p>');
define('TEXT_ALLOW', 'Разрешать');
define('TEXT_DENY', 'Запретить');
define('TEXT_NO_CAT_RESTRICTIONS', '<p>Этот купон действует для всех категорий.</p>');
define('TEXT_NO_PROD_RESTRICTIONS', '<p>Этот купон действует для всех товаров.</p>');
define('TEXT_CAT_ALLOWED', ' (Действителен для этой категории)');
define('TEXT_CAT_DENIED', ' (Не разрешен на эту категорию)');
define('TEXT_PROD_ALLOWED', ' (Действителен для этого товара)');
define('TEXT_PROD_DENIED', ' (Не разрешенный продукт)');
// подарочные сертификаты не могут быть приобретены с купонами на скидку
define('TEXT_COUPON_GV_RESTRICTION','<p class="smallText">Купон на скидку не может быть применен на покупку ' . TEXT_GV_NAMES . '. Ограничение: 1 купон за каждый заказ.</p>');

define('TEXT_DISCOUNT_COUPON_ID_INFO', 'Посмотреть купон на скидку ... ');
define('TEXT_DISCOUNT_COUPON_ID', 'Ваш Код: ');

define('TEXT_COUPON_GV_RESTRICTION_ZONES', 'Ограничения на адрес для выставления счёта применены.');
?>