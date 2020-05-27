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
// $Id: advanced_search_result.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('NAVBAR_TITLE_1', 'Erweiterte Suche');
define('NAVBAR_TITLE_2', 'Suchergebnisse');

//define('HEADING_TITLE_1', 'Advanced Search');
define('HEADING_TITLE', 'Erweiterte Suche');

define('HEADING_SEARCH_CRITERIA', 'Suchkriterien');

define('TEXT_SEARCH_IN_DESCRIPTION', 'Suchen nach Beschreibungen');
define('ENTRY_CATEGORIES', 'Kategorien:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Unterkategorien');
define('ENTRY_MANUFACTURERS', 'Herstell:');
define('ENTRY_PRICE_FROM', 'Niedrigster Preis:');
define('ENTRY_PRICE_TO', 'Höchster Preis:');
define('ENTRY_DATE_FROM', 'Anfangsdatum:');
define('ENTRY_DATE_TO', 'Das Enddatum:');

define('TEXT_SEARCH_HELP_LINK', 'Suchhilfe [?]');

define('TEXT_ALL_CATEGORIES', 'Alle Kategorien');
define('TEXT_ALL_MANUFACTURERS', 'Alle Hersteller');

define('HEADING_SEARCH_HELP', 'Suchhilfe');
define('TEXT_SEARCH_HELP', 'Keywords können durch AND und / oder OR-Anweisungen für eine bessere Kontrolle über den Suchergebnissen auseinandergehalten werden.<br /><br />Zum Beispiel, Microsoft AND Maus wird Ergebnisse, die die beide Wörter enthalten, erzeugen. Maus ODER Tastatur wird beide Wörter oder eines davon enthalten.<br /><br />Exakte Übereinstimmung kann durch eingeschlossene Keywords in Anführungszeichen gesucht werden.<br /><br />Zum Beispiel, "Notebook" würde Ergebnisse, die die genaue Zeichenfolge entsprechen, generieren<br /><br />Desweiteren können die Klammern für die Ergebnisse Kontrolle verwendet werden.<br /><br />Zum Beispiel, Microsoft und (Tastatur oder Maus oder "Visual Basic"). ');
define('TEXT_CLOSE_WINDOW', 'Fenster schließen [x]');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Artikel Nr.');
define('TABLE_HEADING_PRODUCTS', 'Produkt Name');
define('TABLE_HEADING_MANUFACTURER', 'Hersteller');
define('TABLE_HEADING_QUANTITY', 'Menge');
define('TABLE_HEADING_PRICE', 'Preise');
define('TABLE_HEADING_WEIGHT', 'Gewicht');
define('TABLE_HEADING_BUY_NOW', 'Jetzt Kaufen');
?>
