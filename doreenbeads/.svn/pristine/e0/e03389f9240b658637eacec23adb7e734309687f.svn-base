<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: index.php 6550 2007-07-05 03:54:54Z drbyte $
 */

define('TEXT_MAIN','Dies ist die Haupt Definition-Anweisung für die Seite auf Englisch, wenn keine Template-Definitionsdatei existiert. Es befindet sich in: <strong>/includes/languages/english/index.php</strong>');

// Showcase vs Store
if (STORE_STATUS == '0') {
  define('TEXT_GREETING_GUEST', 'Herzlick Willkommen! <span class="greetUser"></span> Melden Sie sich <a href="%s">jezt an in</a>?');
} else {
  define('TEXT_GREETING_GUEST', 'Willkommen! Viel Spaß beim Schauen unserer Online-Schaukästen.');
}

define('TEXT_GREETING_PERSONAL', 'Guten Tag <span class="greetUser">%s</span>! Möchten Sie unsere <a href="%s">neueste Informationen</a>bekommen?');

define('TEXT_INFORMATION', 'Definieren Sie Ihre Haupt Index Seite Kopie hier.');

//moved to english
//define('TABLE_HEADING_FEATURED_PRODUCTS','Featured Products');

//define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

if ( ($category_depth == 'products') || (zen_check_url_get_terms()) ) {
  // This section deals with product-listing page contents
  define('HEADING_TITLE', 'Verfügbare Produkte');
  define('TABLE_HEADING_IMAGE', 'Produktbild');
  define('TABLE_HEADING_MODEL', 'Artikel Nr.');
  define('TABLE_HEADING_PRODUCTS', 'Produktname');
  define('TABLE_HEADING_MANUFACTURER', 'Hersteller');
  define('TABLE_HEADING_QUANTITY', 'Menge');
  define('TABLE_HEADING_PRICE', 'Preis');
  define('TABLE_HEADING_WEIGHT', 'Gewicht');
  define('TABLE_HEADING_BUY_NOW', 'Jetzt kaufen');
  define('TEXT_NO_PRODUCTS', 'Es gibt kein Produkt in dieser Kategorie.');
  define('TEXT_NO_PRODUCTS2', 'Es gibt kein Produkt von diesem Hersteller.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Anzahl der Produkte: ');
  define('TEXT_SHOW', 'Filtern Sie nach:');
  define('TEXT_BUY', 'Kaufen 1 ’');
  define('TEXT_NOW', '’ jetzt');
  define('TEXT_ALL_CATEGORIES', 'Alle Kategorien');
  define('TEXT_ALL_MANUFACTURERS', 'Alle Hersteller');
} elseif ($category_depth == 'Top') {
  // This section deals with the "home" page at the top level with no options/products selected
  /*Replace this text with the headline you would like for your shop. For example: 'Welcome to My SHOP!'*/
  define('HEADING_TITLE', '');
} elseif ($category_depth == 'verschachtelt') {
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