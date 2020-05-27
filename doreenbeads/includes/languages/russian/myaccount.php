<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */

define('NAVBAR_TITLE', 'Мой Счёт');
define('HEADING_TITLE', 'Мой Счёт');
define('TEXT_SAY_HI','Здравствуйте, %s!');
define('TEXT_CART_QUICK_ORDER_BY', 'Быстро добавлять товары');
define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Добавлять больше товары');
define('TEXT_CART_QUICK_ADD_NOW', 'Сейчас быстро добавлять');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Пожалуйста, введите артикул нашего товара(например, B06512) и количество, которое вы хотите заказать, используя форму ниже:');
define('TEXT_CART_P_NUMBER', 'Артикул');
define('TEXT_CART_P_QTY', 'Количество');
define('TEXT_WORD_UPDATE', 'обновлять');
define('TEXT_WORD_ALREADY_UPDATE', 'Сохранили');
define('TEXT_CART_JS_WRONG_P_NO', 'Неправильный артикул. Чтобы продолжать, вы должны удалять это из вашего списка.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'К сожалению, некоторые товары не были найдены, удаляйте неправильный артикул, пожалуйста');
define('TEXT_CART_JS_NO_STOCK', 'Нет запасов склада. Чтобы продолжать, вы должны удалять это из вашего списка.');
define('TEXT_DISCOUNT_TABLE_INFO','<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">Обшая Цена Товара</th><th width="80">Скидка</th><th>Как получить мою скидку?</th></tr>
		<tr><td>US $30 - US$ 800</td><td><b>6.01 USD</b></td><td rowspan=4 class="rowspanTd">Получить соответствующую скидку легко, просто нажав кнопку "Использовать её", прежде чем нажать "подтвердить заказ".</td></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>');
define('TEXT_DISCOUNT_TABLE_INFO_2','<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">Обшая Цена Товара</th><th width="80">Скидка</th><th>Как получить мою скидку?</th></tr>
		<tr><td>US $30 - US$ 800</td><td><b>5€</b></td><td rowspan=4 class="rowspanTd">Получить соответствующую скидку легко, просто нажав кнопк "Использовать её", прежде чем нажать "подтвердить заказ".</td></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>');
define('TEXT_TOTAL_CONSUMPTION','общее потребление:');
define('TEXT_WHAT_YOU_CAN_ENJOY','Вы можете наслаждаться следующей скидкой для вашего первого заказа:');
define('TEXT_NOW_YOU_CAN','<p><strong>Сейчас вы можете:</strong></p>
       <p>Shop on:  <a href="'.zen_href_link(FILENAME_PRODUCTS_NEW).'">Новинки</a></p>
       <p>Получили вашу посылку? Вы предложены <a href="javascript:void(0);" class="footer_write_a_testimonial">Написать отзыв для заказа</a></p>');
define('BEST_SELLER','Лидер продажи');
define('TEXT_CART_MY_VIP', 'Мой VIP Скидка');
define('TEXT_CART_OFF', 'скидка');
?>