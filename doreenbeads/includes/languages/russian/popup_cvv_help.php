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
// $Id: popup_cvv_help.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('HEADING_CVV', 'Что такое CVV?');
define('TEXT_CVV_HELP1', 'Visa, Mastercard, Discover 3 цифры идентификационного номера<br /><br />
                    Для вашей безопасности и безопасности оформления заказа, вы должны ввести последние цифры вашего идентификационного номера для проверки кредитной карты.<br /><br />
                    Этот номер состоит из 3-х последних цифр на обороте вашей кредитной карты. 
                    Этот номер находится справа, после последних цифр вашего номера кредитной карты.<br />' .
                    zen_image(DIR_WS_TEMPLATE_ICONS . 'cvv2visa.gif'));

define('TEXT_CVV_HELP2', 'American Express имеет 4 цифры такого номера.<br /><br />
                    Для вашей безопасности и безопасности оформления заказа, вы должны ввести последние цифры вашего идентификационного номера для проверки кредитной карты.<br /><br />
                    Кредитная карта American Express. Этот номер состоит из 4-х последних цифр на обороте вашей кредитной карты, находящейся рядом с подписью.
                    Этот номер находится справа, после промежутка, после последних цифр вашего номера кредитной карты.<br />' .
                    zen_image(DIR_WS_TEMPLATE_ICONS . 'cvv2amex.gif'));

define('TEXT_CLOSE_CVV_WINDOW', 'Закрыть Окно [x]');
?>