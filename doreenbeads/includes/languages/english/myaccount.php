<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */

define('NAVBAR_TITLE', 'My Account');
define('HEADING_TITLE', 'My Account');
define('TEXT_SAY_HI','Hi, %s!');
define('TEXT_CART_QUICK_ORDER_BY', 'Quick Add Products');
define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Add more items');
define('TEXT_CART_QUICK_ADD_NOW', 'Quick add now');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Please enter our porduct Part No.(for example B06512) and Quantity you want to order by using the below form:');
define('TEXT_CART_P_NUMBER', 'Part No.');
define('TEXT_CART_P_QTY', 'Qty');
define('TEXT_WORD_UPDATE', 'update');
define('TEXT_WORD_ALREADY_UPDATE', 'Saved');
define('TEXT_CART_JS_WRONG_P_NO', 'Wrong Part No.. To continue, you should remove this from your list.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'Sorry, some items were not found, Please remove the wrong Part No.');
define('TEXT_CART_JS_NO_STOCK', 'No Stock. To continue, you should remove this item from your list.');
define('TEXT_DISCOUNT_TABLE_INFO','<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">Total Product Price</th><th width="80">Discount</th><th>How to get my discount?</th></tr>
		<tr><td>US $30 - US$ 800</td><td><b>6.01 USD</b></td><td rowspan=4 class="rowspanTd">Get corresponding discount easily just by clicking "Use it" button before clicking "confirm order".</td></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>');
define('TEXT_DISCOUNT_TABLE_INFO_2','<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">Total Product Price</th><th width="80">Discount</th><th>How to get my discount?</th></tr>
		<tr><td>US $30 - US$ 800</td><td><b>5€</b></td><td rowspan=4 class="rowspanTd">Get corresponding discount easily just by clicking "Use it" button before clicking "confirm order".</td></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>');
define('TEXT_TOTAL_CONSUMPTION','Total Consumption:');
define('TEXT_WHAT_YOU_CAN_ENJOY','You can enjoy the following discount for your first order:');
define('TEXT_NOW_YOU_CAN','<p><strong>Now you can:</strong></p>
       <p>Shop on:  <a href="'.zen_href_link(FILENAME_PRODUCTS_NEW).'">New Arrivals</a></p>
       <p>Just got your parcel? You are ordially invited to <a href="javascript:void(0);" class="footer_write_a_testimonial">Write an Order Review</a></p>');
define('BEST_SELLER','Best Sellers');
define('TEXT_CART_MY_VIP', 'My VIP Level');
define('TEXT_CART_OFF', 'OFF');
?>