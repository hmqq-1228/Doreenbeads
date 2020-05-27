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
// $Id: popup_coupon_help.php 4591 2006-09-23 04:25:15Z ajeh $
//

define('HEADING_COUPON_HELP', 'Помощь для купона на скидку');
define('TEXT_CLOSE_WINDOW', 'Закрыть окно [x]');
define('TEXT_COUPON_HELP_HEADER', 'Поздравляем, что вы выкупили Купон на Скидку.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />Имя Купона : %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />Этот купон стоит %s скидки для вашего заказа');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />Вам нужно тратить %s для использования этого купона');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />Этот купон дает вам бесплатную доставку для вашего заказа');
define('TEXT_COUPON_HELP_DESC', '<br /><br />Описание Купона : %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />Этот купон действует с %s до %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />Товар/Ограничение Категории');
define('TEXT_COUPON_HELP_CATEGORIES', 'Категория');
define('TEXT_COUPON_HELP_PRODUCTS', 'Товар');
define('TEXT_ALLOW', 'Разрешать');
define('TEXT_DENY', 'Запретить');

define('TEXT_ALLOWED', ' (Разрешён)');
define('TEXT_DENIED', ' (Запрещён)');

// подарочные сертификаты не могут быть приобретены с купонами на скидку
define('TEXT_COUPON_GV_RESTRICTION','Купон на скидку не может быть применен на покупку ' . TEXT_GV_NAMES . '.');

define('TEXT_COUPON_GV_RESTRICTION_ZONES', 'Ограничение адреса для выставления счета к применению.');
?>