<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: shopping_cart.php 3183 2006-03-14 07:58:59Z birdbrain $
 */

define('NAVBAR_TITLE', 'The Shopping Cart');
define('HEADING_TITLE', 'Your Shopping Cart Contents');
define('HEADING_TITLE_EMPTY', 'Your Shopping Cart');
//jessa 2009-10-26 删除以下代码，在shopping cart中出现的多余文字 
//多余部分如下：'You may want to add some instructions for using the shopping cart here. (defined in includes/languages/english/shopping_cart.php)'
define('TEXT_INFORMATION', '');
//eof jessa 2009-10-26
define('TABLE_HEADING_REMOVE', 'Remove');
define('TABLE_HEADING_QUANTITY', 'Qty.');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRICE','Unit');
define('TEXT_CART_EMPTY', 'Your Shopping Cart is empty.');
define('SUB_TITLE_SUB_TOTAL', 'Sub-Total:');
define('SUB_TITLE_TOTAL', 'Total:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' are out of stock or there are not enough in stock to fill your order.<br />Please change the quantity of products marked with (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '). Thank you');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' are out of stock.<br />Items not in stock will be placed on backorder.');

define('TEXT_TOTAL_ITEMS', 'Total Items: ');
define('TEXT_TOTAL_WEIGHT', '&nbsp;&nbsp;Weight: ');
define('TEXT_TOTAL_AMOUNT', '&nbsp;&nbsp;Amount: ');

define('TEXT_VISITORS_CART', '<a href="javascript:session_win();">[help (?)]</a>');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
//jessa 2009-09-11 添加以下代码，（安装插件）
// BOF MIN ORDER AMOUNT
define('TEXT_ORDER_UNDER_MIN_AMOUNT', 'A minimum order amount of %s is required in order to checkout.');
// EOF MIN ORDER AMOUNT
//eof jessa 2009-09-11
?>