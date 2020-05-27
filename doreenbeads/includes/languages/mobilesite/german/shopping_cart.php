<?php
// bof 2.0

define ('TEXT_SHIPPING_CALCULATOR','Shopping Calculator');
define('HEADING_TITLE','Warenkorb');
define ( 'TEXT_CART_IS_EMPTY_DO_SHOPPING', 'Ihr Warenkorb ist jetzt leer.  <a href="'.zen_href_link(FILENAME_DEFAULT).'">Weiter einkaufen.</a>' );
define ( 'TEXT_CART_IS_EMPTY_DO_SHOPPING_NO_LOGIN', 'Oder, wenn Sie bereits ein Konto besitzen, so <a href="'.zen_href_link(FILENAME_LOGIN).'">anmelden Sie sich</a> , die Produkte in Ihrem Warenkorb anzusehen.' );
define('TEXT_CART_IS_EMPTY_SHOP','Fangen Sie bitte an!');
define('TEXT_CART_GO_HOMEPAGE', 'Zur Startseite.');
define('TEXT_CART_CONTINUE_SHOPPING', 'Weiter Kaufen');
define('TEXT_CART_CHECKOUT', 'Zur Kasse gehen');
define('TEXT_CART_MY_CART', 'Mein Warenkorb');
define('TEXT_CART_MY_VIP', 'Mein VIP Level');
define('TEXT_CART_OFF', 'Rabatt');
define ( 'TEXT_CART_MOVE_WISHLIST', 'Auswahl auf Wunschliste Verschieben' );
define('TEXT_CART_EMPTY_CART', 'Auswahl Löschen');
define('TEXT_CART_P_IMG', 'Image');
define('TEXT_CART_P_NUMBER', 'Artikelnummer');
define('TEXT_CART_P_WEIGHT', 'Gewicht');
define('TEXT_CART_P_V_WEIGHT', 'Volumetric Weight');
define('TEXT_CART_P_NAME', 'Produkt Name');
define('TEXT_CART_P_PRICE', 'Preis');
define('TEXT_CART_P_QTY', 'Menge');
define('TEXT_CART_P_SUBTOTAL', 'Zwischensumme');
define('TEXT_CART_WORD_TOTAL', 'Gesamt');
define('TEXT_CART_WORD_TOTAL1', 'Gesamtsumme');
define('TEXT_CART_WORD_SELECTED', 'Ausgewählt');
define('TEXT_CART_ITEM', 'Artikel');
define('TEXT_CART_ITEMS', 'Artikel');
define('TEXT_CART_AMOUNT', 'Menge');

define('TEXT_CART_QUICK_ORDER_BY', 'Artikel schnell hinzufügen');
define('TEXT_CART_QUICK_ORDER_BY_CONTENT', 'Sie können Artikelnr. und die Quantität eingeben oder Tabellenkalkulation machen, dann werden alle Einzelteile in den Warenkorb zur gleichen Zeit hinzugefügt.');

define('TEXT_CART_JS_MOVE_ALL', 'Möchten Sie wirklich alle ausgewählten Produkte auf Wunschliste verschieben?');
define('TEXT_CART_JS_MOVE_TO_WISHLIST', 'Bestätigen Sie es, diesen Artikel nach Wunschliste zu verschieben?');
define('TEXT_CART_JS_EMPTY_CART', 'Möchten Sie wirklich alle ausgewählten Produkte aus dem Warenkorb löschen?');

define('TEXT_WORD_UPDATE', 'Aktualisiert');
define('TEXT_WORD_ALREADY_UPDATE', 'speichert');

define('TEXT_CART_ORIGINAL_PRICE', 'Ursprünglicher Preis');
define('TEXT_CART_PROMOTION_DISCOUNT', 'Promotion Rabatt');
define('TEXT_CART_VIP_DISCOUNT', 'VIP Rabatt');
define('TEXT_CART_SHIPPING_COST', 'Versandkosten');

/* bof shipping calculator */
define('TEXT_CART_SHIPPING_INFO', 'Versand Information');
define('TEXT_CART_SHIPPING_COUNTRY', 'Land');
define('TEXT_CART_SHIPPING_CITY', 'Stadt / Ort');
define('TEXT_CART_SHIPPING_POSTCODE', 'PLZ/Postleitzahl');
define('TEXT_CART_SHIPPING_CAL', 'berechnen');
define('TEXT_CART_SHIPPING_COMPANY', 'Shipping Company');
define('TEXT_CART_SHIPPING_EST_TIME', 'Geschätzte Lieferzeit');
define('TEXT_CART_SHIPPING_EST_COST', 'Geschätzte Versandkosten');
define('TEXT_CART_SHIPPING_EST_SPECIAL', 'Sonderrabatt');

define('TEXT_CART_SHIPPING_EST_TIME_CODE', '<font title="Das folgende Zustelldatum ist nur eine Referenz.Die tatsächliche Lieferzeit kann in verschiedenen Länder unterschiedlich sein. Es wird durch den Abstand von China und der Politik der lokalen Gewohnheiten beeinflusst.">Geschätzte Lieferzeit</font>');
/* eof */

/* bof recently viewed products */
define('TEXT_CART_RECENTLY_VIEWED', 'Histry Anzeige');
define('TEXT_CART_RECENTLY_VIEWED_NO_P', 'Sie haben keine Waren gelesen.');
define('TEXT_CART_RECENTLY_ADD_SUCCESSFULLY', 'In den Warenkorb erfolgreich hinzugefügt');
define('TEXT_CART_RECENTLY_ITEMS_TOTALLY', 'Alle Artikel');
define('TEXT_CART_RECENTLY_VIEW_CART', 'Warenkorb anzeigen');
define('TEXT_CART_RECENTLY_CLOSE', 'schließen');

/* eof */

define('ERROR_CART_RECOMMEND_LOGIN', 'Um die Artikel, die in Ihrem Warenkorb bereits hinzugefügt haben zu sparen, empfehlen wir Ihnen <a href="' . zen_href_link(FILENAME_LOGIN) . '">Anmeldung</a> or <a href="' . zen_href_link(FILENAME_LOGIN) . '">Register</a> zuerst.');

define('TEXT_CART_REMOVE_THIS_ITEM', 'Produkt entfernen?');
define('TEXT_CART_DELETE', 'Löschen');

define('TEXT_CART_WEIGHT_UNIT', 'g');

define('TEXT_SERVICE','Service');
define('TEXT_SHIPPING_COST_INOF','Versandkosten wird so berechnet: Produktgewicht plus Packungsgewicht');
define('TEXT_CART_EST_SHIPPING_COST','Sie könnten Versandmethode auf der nächsten Seite ändern.');
define('Text_CART_NEXT_PAGE','Dieser Rabatt wird durch Anklicken der Schaltfläche "Use it" auf der nächsten Seite aufgebracht werden.');
define('Text_CART_COUPON_AMOUNT','Rabatt-Coupon:');

// eof

define('TEXT_UPDATE_QTY_SUCCESS', 'Kaufmenge wurde erforglich aktualisiert!');
define ( 'TEXT_UPDATE_QTY_SUCCESS_MOBILE', 'Die Menge wird auf %s aktualisiert.' );
define('TEXT_ADDCART_MAX_NOTE', 'Nur noch %s Packung(en) von %s sind nun auf Lager. Die Menge wird auf %s automatisch aktualisiert.');
define('TEXT_ADDCART_MAX_NOTE_ALERT', 'Es tut uns Leid!Jetzt haben wir nur %s packungen von %s auf Lager. Bitte aktualisieren Sie die Menge. Wenn Sie Fragen haben, schicken Sie bitte uns Email unter der Adresse service_de@doreenbeads.com');

define('TEXT_CART_SPECIAL_DISCOUNT', 'Est.Special Rabatt');

define('TEXT_CART_ADD_WISHLIST_SUCCESS', 'Artikel wurden erfolgreich in Ihre Merkliste hinzugefügt!');
define('TEXT_CART_VIEW_WISHLIST', 'Wunschliste anzeigen');
define('TEXT_CART_AVAILABLE_PAYMENT', 'Verfügbare Zahlungsarten');

define('TEXT_QUESTION_SUBMIT','Einreichen');
define('CHECKOUT_ADDRESS_BOOK_CANCEL','Abbrechen');
define('TEXT_NOTE_MAXCHAAR','<b id="rest_characters">254</b> Zeichen übrig');
define('TEXT_MORE', 'More');
define('TEXT_LESS', 'Less');

// readd deleted products into the cart
define('HAS_BEEN_REMOVED', '  wurde schon erfolgreich aus dem Warenkorb entfernt.');
define('RE_ADD', 'Zurücknehmen');

define('TEXT_CART_GO_SHOPPING', 'Einkaufen');
define('TEXT_CART_SAVE_PRICE', 'Der Originale Preis ist %s.Sie sparen %s.');
//define('TEXT_ORDER_SUMMARY', 'Bestellübersicht');
define('TEXT_HANDING_FEE_WORDS','Handling Fee');
define('TEXT_SHIPPING_FEE_WORDS','Versandgebühr');
define('TEXT_SHIPPING_FEE_CHANGE_METHOD_TIPS','Sie können Versandmethoden auf der Kasse ändern.');
?>