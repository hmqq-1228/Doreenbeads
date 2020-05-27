<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: index.php 6550 2007-07-05 03:54:54Z drbyte $
 */

define('TEXT_MAIN','Это заявление для английской страницы, когда не существует файл . Он расположен в:<strong>/includes/languages/english/index.php</strong>');

// Showcase vs Store
if (STORE_STATUS == '0') {
  define('TEXT_GREETING_GUEST', 'ДОбро пожаловать <span class="greetUser">Guest!</span> Хотите ли вы <a href="%s">войти в</a>?');
} else {
  define('TEXT_GREETING_GUEST', 'Добро пожаловать, пожалуйста, наслаждайтесь нашей интернет-витриной.');
}

define('TEXT_GREETING_PERSONAL', 'Здравствуйте <span class="greetUser">%s</span>! Вы хотите, чтобы увидеть наши <a href="%s">самые новые дополнения</a>?');

define('TEXT_INFORMATION', 'Определите вашу копию индекса основной страницы здесь.');

//moved to english
//define('TABLE_HEADING_FEATURED_PRODUCTS','Featured Products');

//define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

if ( ($category_depth == 'products') || (zen_check_url_get_terms()) ) {
  // This section deals with product-listing page contents
  define('HEADING_TITLE', 'Доступные Товары');
  define('TABLE_HEADING_IMAGE', 'Изображение Товара');
  define('TABLE_HEADING_MODEL', 'Артикул');
  define('TABLE_HEADING_PRODUCTS', 'Название Товара');
  define('TABLE_HEADING_MANUFACTURER', 'Производитель');
  define('TABLE_HEADING_QUANTITY', 'Количество');
  define('TABLE_HEADING_PRICE', 'Цена');
  define('TABLE_HEADING_WEIGHT', 'Вес');
  define('TABLE_HEADING_BUY_NOW', 'Купить Сейчас');
  define('TEXT_NO_PRODUCTS', 'Нет товара в этой категории.');
  define('TEXT_NO_PRODUCTS2', 'нет продукта доступно из этого производителя.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Номер Товаров: ');
  define('TEXT_SHOW', 'Результаты фильтрации по:');
  define('TEXT_BUY', 'Покупать 1 ’');
  define('TEXT_NOW', '’ сейчас');
  define('TEXT_ALL_CATEGORIES', 'Все Категории');
  define('TEXT_ALL_MANUFACTURERS', 'Все производители');
} elseif ($category_depth == 'топ') {
  // This section deals with the "home" page at the top level with no options/products selected
  /*Replace this text with the headline you would like for your shop. For example: 'Welcome to My SHOP!'*/
  define('HEADING_TITLE', '');
} elseif ($category_depth == 'nested') {
  // This section deals with displaying a subcategory
  /*Replace this line with the headline you would like for your shop. For example: 'Welcome to My SHOP!'*/
  //---------------------------
  // Robbie 2009-08-05
  // Delete the display on main page "Congratulation!......" 
  //----------------------------
  //define('HEADING_TITLE', 'Congratulation!......'); 
  define('HEADING_TITLE', ''); 
  //eof robbie
}
?>