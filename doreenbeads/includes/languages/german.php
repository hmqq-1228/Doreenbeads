<?php
@setlocale(LC_TIME, 'de_DE.UTF-8', 'de_AT.UTF-8', 'de_CH.UTF-8', 'de_DE.ISO_8859-1','de_DE@euro', 'de_DE', 'de', 'ge', 'deu.deu'); 
define('DATE_FORMAT_SHORT', '%d.%m %Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

  if (!function_exists('zen_date_raw')) {
function zen_date_raw($date, $reverse = false){
     if ($reverse){
         return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
         }else{
        // edit by cyaneo for german Date support - thx to hugo13
        // return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
        return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
         }
    }
  }
  
define('TEXT_PAYMENT_PROMPT',"Es wäre sehr nett von Ihnen, wenn Sie uns Ihren Zahlungsbeleg angeben können, damit wir Ihre Zahlungsinfo überprüfen können.");
define('TEXT_PAYMENT_HSBS_CHINA','<p>1. Bei der Überweisung schreiben Sie bitte Ihre Bestellnummer in der Erläuterung von Bank-Transfer Formular. </p>
<p>2. Bitte vergessen Sie nicht, uns Ihre Überweisungsbestätigung <a href="mailto:serivce_de@doreenbeads.com" style="color:#008FED;">per E-Mail schicken</a>, nachdem Sie uns Geld übergewiesen haben. Nur damit wir Ihre Überweisung bestätigen und Ihr Paket richtzeitig versenden können.</p>
<p>3. Wenn Ihr Gesamtbetrag inkl.Versandkosten 2000USD erreicht, wird 2% Rabatt angeboten sein. Die Provision soll vom Zahler bezahlt wird.</p>');

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead
// of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');
define('CHECKOUT_ZIP_CODE_ERROR', 'Bitte überprüfen Sie Ihre Postleitzahl, das richtige Format(z.B.): ');
define('TEXT_OR', 'oder');
define('TEXT_REGULAR_AMOUNT','Regular amount');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'discounted-priced amount');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="de"');
define('TEXT_QUESEMAIL_NAME', 'Name des Kunden');
// charset for web pages and emails
define('CHARSET', 'utf-8');
define('TEXT_TIME','mal');
define('DISCRIPTION', 'Beschreibung');
define('TEXT_CREATE_MEMO','Vermerk');
define('TEXT_HEADER_MY_ACCOUNT','Mein Konto');
define('TEXT_NO_WATERMARK_PICTURE', 'Service von Bildern ohne Wasserzeichen');

define('TEXT_TEL_NUMBER', '(+86) 571-28197839 ');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate,
// Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME', 'Geschenkgutschein');
define('TEXT_GV_NAMES', 'Geschenkgutschein');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM', 'Gutscheincode');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME );
define('BOX_GV_REDEEM_INFO', 'Gutscheincode: ');

// text for gender
define('MALE', 'Herr');
define('FEMALE', 'Frau');
define('TEXT_MALE','männlich');
define('TEXT_FEMALE','weiblich');
define('MALE_ADDRESS', 'Herr');
define('FEMALE_ADDRESS', 'Frau');

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt/mm/jjjj');

// text for sidebox heading links
define('BOX_HEADING_LINKS', '');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Kategorien');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Hersteller');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Neue Produkte');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Neue Produkte ...');

define('HEADER_TITLE_PACKING_SLIP', 'Packzettel');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Ausgewählte');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Ausgewählte Artikel ...');
define('TEXT_NO_FEATURED_PRODUCTS', 'Weitere ausgewählte Artikel werden in Kürze hinzugefügt. Bitte versuchen Sie es später.');

define('TEXT_NO_ALL_PRODUCTS', 'Weitere Artikel werden in Kürze hinzugefügt. Bitte versuchen Sie es später.');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Alle Produkte ...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Suchen');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Profisuche');

// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Angebote');
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Angebote ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Bewertungen');
define('BOX_REVIEWS_WRITE_REVIEW', 'Schreiben Sie eine Bewertung zu diesem Artikel.');
define('BOX_REVIEWS_NO_REVIEWS', 'Es gibt momentan keine Bewertungen.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s von 5 Sternen!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Warenkorb');
define('BOX_SHOPPING_CART_EMPTY', 'Ihr Warenkorb ist leer.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Schnelle Nachbestellung');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bestseller');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestseller in<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Benachrichtigungen');
define('BOX_NOTIFICATIONS_NOTIFY', 'Informieren Sie mich über Aktuelles zu <strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Informieren Sie mich nicht über Aktuelles zu <strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Hersteller Info');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Mehre Produkte');

// languages box text in sideboxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Sprache');

// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Währungen');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_PRIVACY', 'Privatsphäre und Datenschutz');
define('BOX_INFORMATION_CONDITIONS', 'Benutzungsbedingungen');
define('BOX_INFORMATION_SHIPPING', 'Versand &amp; Retouren');
define('BOX_INFORMATION_CONTACT', 'Kontaktieren Sie uns');
define('BOX_BBINDEX', 'Forum');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Newsletter abbestellen');

define('BOX_INFORMATION_SITE_MAP', 'Sitemap');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'Mehre Information');
define('BOX_INFORMATION_PAGE_2', 'Seite 2');
define('BOX_INFORMATION_PAGE_3', 'Seite 3');
define('BOX_INFORMATION_PAGE_4', 'Seite 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Weiterempfehlen');
define('BOX_TELL_A_FRIEND_TEXT', 'Empfehlen Sie diesen Artikel.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'Mein Wunschzettel');
define('BOX_WISHLIST_EMPTY', 'Sie haben keine Artikel auf Ihrer Wunschliste');
define('IMAGE_BUTTON_ADD_WISHLIST', 'Zur Wunschliste');
define('TEXT_MOVE_TO_WISHLIST', 'in die Wunschliste');
define('TEXT_WISHLIST_COUNT', 'Zur Zeit sind % s Artikel auf Ihrem Wunschzettel.');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Produkte auf Ihrem Wunschzettel)');

// New billing address text
define('SET_AS_PRIMARY', 'Als Primäradresse');
define('NEW_ADDRESS_TITLE', 'Rechnungsadresse');

// javascript messages
define('JS_ERROR', 'Fehler wurden bei der Bearbeitung des Formulars aufgetreten.\n\nBitte nehmen Sie die folgende Korrekturen:\n\n');

define('JS_REVIEW_TEXT', '* Bitte fügen mehre Wörter zu Ihrem Kommentar ein. Der Kommentar muss mindestens' . REVIEW_TEXT_MIN_LENGTH . ' Charaktere sein.');
define('JS_REVIEW_RATING', '* Bitte wählen Sie eine Bewertung für diesen Artikel.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte wählen Sie eine Zahlungsart für Ihre Bestellung.');

define('JS_ERROR_SUBMITTED', 'Dieses Formular wurde bereits vorgelegt. Bitte drücken Sie OK und warten Sie, bis dieser Prozess abgeschlossen ist.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Bitte wählen Sie eine Zahlungsart für Ihre Bestellung.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Bitte bestätigen Sie die Allgemeinen Geschäftsbedingungen dieser Bestellung, indem Sie das Feld unten klicken.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Bitte bestätigen Sie die Datenschutzerklärung, indem Sie das Feld unten klicken.');

define('CATEGORY_COMPANY', 'Firmendetails');
define('CATEGORY_PERSONAL', 'Ihre persönliche Daten');
define('CATEGORY_ADDRESS', 'Ihre Adresse');
define('CATEGORY_CONTACT', 'Ihre Kontaktinformation');
define('CATEGORY_OPTIONS', 'Optionen');
define('CATEGORY_PASSWORD', 'Ihr Passwort');
define('CATEGORY_LOGIN', 'Anmelden');
define ( 'CREATE_NEW_ACCOUNT', 'Neues Konto erstellen' );
define('TEXT_NEW_CUSTOMER','Neue Kunden');
define('TEXT_RETURN_CUSTOMER','Stammkunden');
define('TEXT_PLACEHOLDER1','Geben Sie Ihre E-Mail oder Telefonnummer ein');
define('TEXT_PLACEHOLDER2','Geben Sie Ihr Paypal-Konto ein');
define('PULL_DOWN_DEFAULT', 'Bitte wählen Sie Ihr Land');
define('PLEASE_SELECT', 'Bitte wählen Sie ...');
define('TYPE_BELOW', 'Tippen Sie die Auswahl unten ...');

define('ENTRY_COMPANY', 'Firmenname:');
define('ENTRY_COMPANY_ERROR', 'Bitte geben Sie einen Firmennamen.');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Anrede:');
define('ENTRY_GENDER_ERROR', 'Bitte wählen Sie eine Anrede.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Vorname:');
define('ENTRY_FIRST_NAME_ERROR', 'Bitte geben Sie Ihren Vorname ein(Mindestens 1 Zeichen).');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:'); 
define('ENTRY_LAST_NAME_ERROR', 'Bitte geben Sie Ihren Nachname ein(Mindestens 1 Zeichen).');
define('ENTRY_FL_NAME_SAME_ERROR', 'Ihr Nachname ist gleich wie Ihr Vorname. Bitte verändern.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');

define('ENTRY_DATE_OF_BIRTH_ERROR', 'Das ganze Geburtsdatum (Jahr-Monat-Tag) ist für die Anmeldung erforderlich');
define('ENTRY_DATE_OF_BIRTH_TEXT', '*');
define('ENTRY_EMAIL_ADDRESS', 'Email Adresse');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Bitte noch mal bestätigen, ob Ihre E-Mail Adresse richtig oder nicht. Sie sollen mindestens 6 Zeichen eingeben.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Es tut uns Leid. Ihre Email Adresse wurde nicht akzeptiert. Bitte versuchen Sie es erneut.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Ihre Email Adresse wurde bereits bei uns angemeldet - bitte melden Sie sich mit dieser Email Adresse.Wenn Sie diese Adresse nicht mehr benutzen, können Sie es bei Mein Konto korrigieren.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS_MOBILE', 'Ihre E-Mail Adresse ist bereits registriert. Bitte <a href="'.zen_href_link(FILENAME_LOGIN).'">loggen</a> Sie sich direkt ein.'); 
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', 'Forum Nickname:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input
                                   // field
define('ENTRY_NICK_DUPLICATE_ERROR', 'Der Nickname wird bereits angemeldet. Bitte versuchen Sie einen anderen.');
define('ENTRY_NICK_LENGTH_ERROR', 'Bitte versuchen Sie es erneut. Ihr Nichname muss mindestens ' . ENTRY_NICK_MIN_LENGTH . ' Charaktere enthalten.');
define('ENTRY_STREET_ADDRESS', 'Strasse:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Ihre Straße muss mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Charaktere enthalten.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Lieferanschrift 2:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'PLZ:');
define('ENTRY_POST_CODE_ERROR', 'Ihre PLZ muss mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Charaktere enthalten.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_CUSTOMERS_REFERRAL', 'Referenzcode:');

define('ENTRY_CITY_ERROR', 'Ihr Stadt muss mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Charaktere enthalten.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Region/Provinz:');
define('ENTRY_STATE_ERROR', 'Ihr Region muss mindestens ' . ENTRY_STATE_MIN_LENGTH . 'Charaktere enthalten.');
define('ENTRY_STATE_ERROR_SELECT', 'Bitte wählen Sie einen Zustand aus dem Staaten Pull-Down-Menü.');
define('ENTRY_EXISTS_ERROR', 'Diese Adresse ist bereits vorhanden.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- Bitte wählen Sie --');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_COUNTRY_ERROR', 'Sie müssen ein Land von den Länder Pulldown-Menü wählen.');
define('ENTRY_AGREEN_ERROR_SELECT', 'Sie stimme nicht zu Doreenbeads.com <a href="page.html?id=137" target="_blank" style="color:#900;text-decoration:underline">Allgemeine Geschäftsbedingungen</a>');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_PUERTORICO_ERROR', 'Sie müssen "Puerto Rico" aus den Ländern Pulldown-Menü als Land wählen, und Ihr Staat ist "Puerto Rico".');
define('ENTRY_TELEPHONE_NUMBER', 'Telefon:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Ihre Telefonnummer muss mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Charaktere enthalten.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Fax Nummer:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Abonnieren Sie unseren Newsletter.');
define('ENTRY_NEWSLETTER_TEXT', 'Bestellen');
define('ENTRY_NEWSLETTER_YES', 'Abonniert');
define('ENTRY_NEWSLETTER_NO', 'Nicht abonniert');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Passwort:');
define('ENTRY_PASSWORD_ERROR', 'Sie sollten mindestens 5 Zeichen (Buchstaben und Zahlen) eingeben.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Die Passwortbestätigung stimmt nicht mit dem eingegebenen Passwort überein.');
define('ENTRY_PASSWORD_TEXT', '* (mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Charaktere)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Passwort bestätigen:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Aktuelles Passwort:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Sie sollten mindestens 5 Zeichen (Buchstaben und Zahlen) eingeben.');
define('ENTRY_PASSWORD_NEW', 'Neu Passwort:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ihr neues Passwort muss mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Charaktere enthalten.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Die Passwort Bestätigung muss Ihr Passwort übereinstimmen.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

define('FORM_REQUIRED_INFORMATION', '* Erforderliche Informationen');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Produkten)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Bestellungen)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Bewertungen)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'v <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> neuen Produkten)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Angeboten)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (of <strong>%d</strong> ähnlichen Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Produkten)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Erste Seite');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Vorherige Seite');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Nächste Seite');
define('PREVNEXT_TITLE_LAST_PAGE', 'Letzte Seite');
define('PREVNEXT_TITLE_PAGE_NO', 'Seite %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Vorherige %d Seiten');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Reihe von %d Seiten');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[<< Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next >>]');
define('PREVNEXT_BUTTON_LAST', 'LAST>>');
define('PREVNEXT_BUTTON_NEXT_NEW', 'Nächste');

define('TEXT_BASE_PRICE', 'Beginn vom: ');

define('TEXT_CLICK_TO_ENLARGE', 'Größeres Bild');

define('TEXT_SORT_PRODUCTS', 'Artikel sortieren ');
define('TEXT_DESCENDINGLY', 'absteigend');
define('TEXT_ASCENDINGLY', 'aufsteigend');
define('TEXT_BY', ' durch ');

define('TEXT_REVIEW_BY', ' %s');
define('TEXT_REVIEW_WORD_COUNT', '%s Wörter');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Hinzugefügtes Datum: %s');
define('TEXT_NO_REVIEWS', 'Es gibt momentan keine Bewertungen.');

define('TEXT_NO_NEW_PRODUCTS', 'Oops, es gibt kein Treffer, versuchen Sie mal unter eine andere Option.');

define('TEXT_UNKNOWN_TAX_RATE', 'Umsatzsteuer');

define('TEXT_REQUIRED', '<span class="errorText">Benötigt</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warnung: Das Installationverzeichnis ist bei %s vorhanden. Bitte löschen Sie das Verzeichnis aus Sicherheitsgründen.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warnung: Ich kann in die Konfigurationsdatei schreiben: %s. Das stellt ein mögliches Sicherheitsrisiko - bitte korrigieren Sie die Benutzerberechtigungen zu dieser Datei (schreibgeschützt, CHMOD 644 oder 444 sind typisch). Sie sollten bei Ihrer Web-Host-Systemsteuerung / Datei-Manager die Berechtigungen effektiv ändern. Kontaktieren Sie bitte Ihren Webhoster für Unterstützung. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">Sehen Sie diese FAQ</a>');
define('ERROR_FILE_NOT_REMOVEABLE', 'Fehler: Die angegebene Datei kann nicht entfernt werden. Aufgrund einer Server-Berechtigungen Konfiguration Einschränkung müssen Sie FTP verwenden, um die Datei zu entfernen.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis für die Sessionen existiert nicht: ' . zen_session_save_path () . '. Die Sessionen funktionieren nicht, bis das Verzeichnis erstellt wird.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warnung: Ich kann das Session Verzeichnis nicht schreiben: ' . zen_session_save_path () . '. Die Sessionen werden nicht funktionieren bis die richtige Benutzerberechtigungen gesetzt werden.');
define('WARNING_SESSION_AUTO_START', 'Warnung: session.auto_start ist aktiviert - deaktivieren Sie bitte diese PHP Feature in php.ini und neustarten den Web-Server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warnung: Das Produkte Verzeichnis zum Downloaden existiert nicht: ' . DIR_FS_DOWNLOAD . '. Produkte zum Downloaden funktionieren nicht bis das Verzeichnis erstellt wird.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Achtung: Das SQL-Cache-Verzeichnis existiert nicht: ' . DIR_FS_SQL_CACHE . '. SQL-Caching funktioniert nicht bis das Verzeichnis erstellt wird.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Warnung: Ich kann auf dem SQLCache-Verzeichnis nicht schreiben: ' . DIR_FS_SQL_CACHE . '. SQL-Caching wird nicht funktionieren bis die richtige Benutzerberechtigungen gesetzt werden.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Ihre Datenbank muss man auf eine höhere Ebene patchen. Finden Sie Admin->Tools->Server Information, um Patch-Levels zu bewerten.');
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'WARNUNG: Sprache Datei kann nicht gefunden werden: ');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Das Verfallsdatum der Kreditkarte ist ungültig. Bitte überprüfen Sie das Datum und versuchen Sie es erneut.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Die eingegebene Kreditkartennummer ist ungültig. Bitte überprüfen Sie die Nummer und versuchen Sie es erneut.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Die mit %s beginnende Kreditkartennummer wurde nicht korrekt eingegeben, oder wir haben diese Karteart nicht akzeptiert. Bitte versuchen Sie es erneut, oder verwenden Sie eine andere Kreditkarte.');

define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Rabatt-Gutscheine');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Balance ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Konto');
define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
define('ERROR_REDEEMED_AMOUNT', 'Herzlichen Glückwunsch, Sie haben den eingelöst ');
define('ERROR_NO_REDEEM_CODE', 'Sie haben ' . TEXT_GV_REDEEM . 'nicht eingegeben.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Ungültig ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM );
define('TABLE_HEADING_CREDIT', 'Credits verfügbar');
define('GV_HAS_VOUCHERA', 'Sie haben Geld auf dem ' . TEXT_GV_NAME . ' Konto. Wenn Sie möchten <br />können Sie das Geld durch <a class="pageResults" href="abbuchen');

define('GV_HAS_VOUCHERB', '"><strong>email</strong></a> zu jemanden');
define('ENTRY_AMOUNT_CHECK_ERROR', 'Sie haben keine ausreichende Mittel, um diese Menge abzubuchen.');
define('BOX_SEND_TO_FRIEND', 'Send ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' Eingelöst');
define('CART_COUPON', 'Gutschein:');
define('CART_COUPON_INFO', 'Weitere Infos');
define('TEXT_SEND_OR_SPEND', 'Sie haben ein  verfügbares Guthaben auf Ihrem ' . TEXT_GV_NAME . ' Konto. Sie können es ausgeben oder senden Sie es an jemand anderen. Zum Senden klicken Sie auf die Schaltfläche unten.');
define('TEXT_BALANCE_IS', 'Ihr ' . TEXT_GV_NAME . ' Guthaben ist: ');
define('TEXT_AVAILABLE_BALANCE', 'Ihr' . TEXT_GV_NAME . ' Konto');

define('TABLE_HEADING_PAYMENT_METHOD', 'Zahlungsart');
// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Geschenkgutschein / Coupon');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Credits verfügbar');

define('TEXT_INVALID_REDEEM_COUPON', 'Ungültige Gutscheincode');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Sie müssen mindestens %s ausgeben, um diese Gutschein einzulösen');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM_1', '%s coupon ist einlösbar wenn Ihre Auftragsmenge %s erreicht.');
define('TEXT_INVALID_STARTDATE_COUPON', 'Dieser Gutschein ist noch nicht verfügbar');
define('TEXT_INVALID_FINISHDATE_COUPON', 'Dieser Gutschein ist abgelaufen');
define('TEXT_INVALID_USES_COUPON', 'Dieser Gutschein kann nur verwendet werden ');
define('TIMES', 'Male.');
define('TIME', ' Mal.');
define('TEXT_INVALID_USES_USER_COUPON', 'Sie haben Gutscheincode benutzt: %s die maximale Anzahl pro Kunde erlaubt. ');
define('REDEEMED_COUPON', 'ein Gutschein im Wert von ');
define('REDEEMED_MIN_ORDER', 'für Bestellungen über ');
define('REDEEMED_RESTRICTIONS', ' [Artikel-Kategorie Beschränkungen]');
define('TEXT_ERROR', 'Ein Fehler ist aufgetreten');
define('TEXT_INVALID_COUPON_PRODUCT', 'Dieser Gutscheincode gilt nicht für jedes Produkt in Ihrem Einkaufswagen.');
define('TEXT_VALID_COUPON', 'Herzlichen Glückwunsch. Sie haben den Rabatt-Coupon eingelöst.');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Der von Ihnen eingegebene Gutscheincode ist nicht gültig für die ausgewählte Adresse.');

// more info in place of buy now
define('MORE_INFO_TEXT', '... weitere Infos');

// IP Address
define('TEXT_YOUR_IP_ADDRESS', 'Ihre IP Adresse ist:');

// Generic Address Heading
define('HEADING_ADDRESS_INFORMATION', 'Lieferinformationen');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Menge im Warenkorb: ');
define('PRODUCTS_ORDER_QTY_TEXT', 'Zum Warenkorb hinzufügen: ');

define('TEXT_PRODUCT_WEIGHT_UNIT', 'Gramm');

// Shipping
// jessa 2009-08-11
// update define('TEXT_SHIPPING_WEIGHT','lbs');
define('TEXT_SHIPPING_WEIGHT', 'Gramm');
define('TEXT_SHIPPING_BOXES', 'Boxen');
// eof jessa

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Speichern: ');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '% off');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', ' off');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE', 'Sale:&nbsp;');

// universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX', 'Sponsoren');
define('TEXT_BANNER_BOX', 'Bitte besuchen Sie unsere Sponsoren ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2', 'Haben Sie ... gesehen');
define('TEXT_BANNER_BOX2', 'Das ist heute echt toll!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL', 'Sponsoren');
define('TEXT_BANNER_BOX_ALL', 'Bitte besuchen Sie unsere Sponsoren ...');

// boxes defines
define('PULL_DOWN_ALL', 'Bitte wählen Sie');
define('PULL_DOWN_MANUFACTURERS', '- Reset -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Bitte wählen Sie');

// general Sort By
define('TEXT_INFO_SORT_BY', 'Sortieren nach: ');

// close window image popups
define('TEXT_CLOSE_WINDOW', ' - Klicken Sie zum Bild Schließen');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Fenster schließen ]');

// iii 031104 added: File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Fehler: Dateityp nicht erlaubt.');
define('WARNING_NO_FILE_UPLOADED', 'Achtung: keine Datei hochgeladen.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Erfolg: Datei erfolgreich gespeichert.');
define('ERROR_FILE_NOT_SAVED', 'Fehler: File nicht gespeichert.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Fehler: Ziel nicht beschreibbar');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Fehler: Ziel nicht vorhanden.');
define('ERROR_FILE_TOO_BIG', 'Warnung: Datei zu groß zum Hochladen!<br />Bestellung wird angeordnet werden, aber kontaktieren Sie bitte die Website für die Hilfe beim Hochladen');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'HINWEIS: Diese Website wird am: wegen Wartungsarbeiten heruntergefahren');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'HINWEIS: Die Website ist derzeit wegen Wartungsarbeiten heruntergefahren');

define('PRODUCTS_PRICE_IS_FREE_TEXT', 'Es ist kostenlos!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Preis erfragen');
define('TEXT_CALL_FOR_PRICE', 'Preis erfragen');

define('TEXT_INVALID_SELECTION', ' Sie haben eine ungültige Selection gewählt: ');
define('TEXT_ERROR_OPTION_FOR', ' Auf der Option für: ');
define('TEXT_INVALID_USER_INPUT', 'Benutzereingabe erforderlich<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Min: ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Einheiten: ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'Im Warenkorb:');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Zusätzliche hinzufügen:');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Max:');

define('TEXT_PRODUCTS_MIX_OFF', '*Gemischt OFF');
define('TEXT_PRODUCTS_MIX_ON', '*Gemischt ON');

define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br />*Sie können die Optionen zu diesem Artikel nicht vermischen, um die Mindestmenge zu erfüllen.*<br />');
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '*Gemischter Optionswert ist ON<br />');

define('ERROR_MAXIMUM_QTY', 'Die zu Ihrem Warenkorb hinzugefügte Menge wurde aufgrund einer maximal zulässigen Beschränkung angepasst. Sehen Sie diesen Artikel: ');
define('ERROR_CORRECTIONS_HEADING', 'Bitte korrigieren Sie die folgende: <br />');
define('ERROR_QUANTITY_ADJUSTED', 'Die zu Ihrem Warenkorb hinzugefügte Menge wurde angepasst. Der ausgewälte Artikel ist in Bruchteile nicht verfügbar. Die Menge der Artikel: ');
define('ERROR_QUANTITY_CHANGED_FROM', ', wurde aus: geändert');
define('ERROR_QUANTITY_CHANGED_TO', ' zu ');

// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'HINWEIS: Downloads sind nicht verfügbar, bis die Zahlung bestätigt wird');
define('TEXT_FILESIZE_BYTES', ' Bytes');
define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
define('ERROR_PRODUCT', 'Das Item: ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br />Es tut uns leid. Dieses Produkt ist zur Zeit aus unserem Bestand entfernt.<br />Dieser Artikel wurde aus dem Warenkorb entfernt.');
define('ERROR_PRODUCT_QUANTITY_MIN', ' ... Mindestbestellmenge Fehler - ');
define('ERROR_PRODUCT_QUANTITY_UNITS', ' ... Mengeneinheiten Fehler - ');
define('ERROR_PRODUCT_OPTION_SELECTION', '<br /> ... Ungültige ausgewählte Option Werte ');
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br /> Sie bestellten insgesamt: ');
define('ERROR_PRODUCT_QUANTITY_MAX', ' ... Maximum Menge Fehler - ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ', hat eine Mindestmengenbeschränkung. ');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', ' ... Mengeneinheiten Fehler - ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', ' ... Maximum Menge Fehler - ');

define('WARNING_SHOPPING_CART_COMBINED', 'HINWEIS: Sie können alle Artikel in diesem Warenkorb überprüfen, die mit den von Ihnen zuvor hinzugefügten Artikeln kombiniert wurden. Bitte überprüfen Sie Ihr Warenkorb vor dem Zahlen.');

// error on checkout when $_SESSION['customers_id' does not exist in customers
// table
define('ERROR_CUSTOMERS_ID_INVALID', 'Kundendaten können nicht validiert werden!<br />Bitte melden Sie sich an oder erstellen Sie Ihr Konto erneut ...');

define('TABLE_HEADING_FEATURED_PRODUCTS', '<a href="featured_products.html" id="featured_products">Ausgewählte Artikel</a>');

define('TABLE_HEADING_NEW_PRODUCTS', '<a href="products_new.html" id="products_new">Neue Produkte im %s</a>');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Kommende Artikel');
define('TABLE_HEADING_DATE_EXPECTED', 'Verfügbar Datum');
// define('TABLE_HEADING_SPECIALS_INDEX', '<a href="specials.html"
// id="specials">Monthly Specials For %s</a>');
define('TABLE_HEADING_SPECIALS_INDEX', '<a href="https://www.doreenbeads.com/40-off-huge-discounts-c-1375.html" id="specials">Exklusive Riesige Rabatte</a>');
define('CAPTION_UPCOMING_PRODUCTS', 'Diese Artikel sind in Kürze lieferbar');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS', 'Die Tabelle ist eine Liste der Produkte, die bald wieder auf Lager sind');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'Es ist kostenlos!');

// customer login
define('TEXT_SHOWCASE_ONLY', 'Uns kontaktieren');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Preis nicht verfügbar');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Login für Preis');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or
                                                      // enter
                                                      // your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'Nur Ausstellungsraum');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Preis nicht verfügbar');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'APPROVAL PENDING');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Zum Shop anmelden');

// text pricing
define('TEXT_CHARGES_WORD', 'Berechnete Gebühr:');
define('TEXT_PER_WORD', '<br />Preis pro Wort: ');
define('TEXT_WORDS_FREE', ' Wort/Wörte frei ');
define('TEXT_CHARGES_LETTERS', 'Berechnete Gebühr:');
define('TEXT_PER_LETTER', '<br />Preis pro Buchstabe: ');
define('TEXT_LETTERS_FREE', ' Buchstabe(n) frei ');
define('TEXT_ONETIME_CHARGES', '*einmalige Aufwendung = ');
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*Einmalige Aufwendung = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Option Mengenrabatte');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'Menge');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'PRICE');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Option Mengenrabatte Einmalige Aufwendung');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', ' maximale Buchstaben erlaubt');
define('TEXT_REMAINING', 'übrig');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Geschätzte Versandkosten');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Bitte <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">melden Sie sich an</span></a>, um Ihre persönliche Versandkosten zu berechnen.');
define('CART_SHIPPING_METHOD_TEXT', 'Verfügbare Versandarten');
define('CART_SHIPPING_METHOD_RATES', 'Tarife');
define('CART_SHIPPING_METHOD_TO', 'Versand an: ');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Versand an: <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Login</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Kostenloser Versand');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Downloads');
define('CART_SHIPPING_METHOD_RECALCULATE', 'Neuberechnen');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'wahr');
define('CART_SHIPPING_METHOD_ADDRESS', 'Adresse:');
define('CART_OT', 'Gesamtkostenschätzung:');
define('CART_OT_SHOW', 'wahr'); // set to false if you don't want order
                                   // totals
define('CART_ITEMS', 'Artikel im Warenkorb: ');
define('CART_SELECT', 'Wählen');
define('ERROR_CART_UPDATE', '<strong>Bitte weiter kaufen...</strong><br/>');
define('IMAGE_BUTTON_UPDATE_CART', 'Aktualisieren');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Whoops! Ihre Sitzung ist abgelaufen ... Bitte aktualisieren Sie Ihr Warenkorb für Versand Quote ...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Versand Quoten sind auf der von Ihnen gewählten Adresse basierend:');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'hinzufügen: ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'hinzufügen: ');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'hinzufügen: ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'hinzufügen: ');
// moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as
// BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define ( 'TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Mengenrabatt (Einheit: Packung)' );
define ( 'TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Abzug für Mengenrabatt(Einheit: Packung)' );
define ( 'TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Mengenrabatt (Einheit: Packung)' );
define ( 'TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Rabatte können wegen unteren Optionen variieren' );
define ( 'TEXT_HEADER_DISCOUNTS_OFF', 'Mengenrabatt nicht verfügbar ...' );
// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET', '- RESET - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Produktname');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Produktname - desc');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Preis - aufsteigend');
define('TEXT_INFO_SORT_BY_QTY_DATE', 'Lager - mehr zu weniger');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Preis - hoch zu niedrig');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Art.-Nr.');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Hinzugefügtes Datum - aufsteigend');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Hinzugefügtes Datum - absteigend');
// jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_ORDER', 'Verkauft - absteigend');
// eof jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Standardanzeige');
define('TEXT_INFO_SORT_BY_BEST_MATCH', '﻿mehr anpassend');
define('TEXT_INFO_SORT_BY_BEST_SELLERS', 'Bestseller');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Link Verfällt');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Übrig');
define('HEADING_DOWNLOAD', 'Zum Herunterladen der Dateien klicken Sie auf die Download-Taste und wählen Sie "Save to Disk" aus dem Popup-Menü.');
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Dateiname');
define('TABLE_HEADING_PRODUCT_NAME', 'Artikelname');
define('TABLE_HEADING_PRODECT_PRICE', 'Preis');
define('TABLE_HEADING_PRODUCT_IMAGE', 'Produktbild');
define('TABLE_HEADING_PRODUCT_MODEL', 'Art.-Nr.');
define('TABLE_HEADING_BYTE_SIZE', 'Größe der Datei');
define('TEXT_DOWNLOADS_UNLIMITED', 'Unbegrenzt');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Menge');
define('TABLE_HEADING_PRODUCTS', 'Artikelname');
define('TABLE_HEADING_PRICE', 'Preis');
define('TABLE_HEADING_IMAGE', 'Produktbild');
define('TABLE_HEADING_MODEL', 'Art.-Nr.');
define('TABLE_HEADING_TOTAL', 'Gesamtsumme');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Datenschutzerklärung');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Bitte bestätigen Sie unsere Datenschutzerklärung, indem Sie das folgende Feld klicken. Die Datenschutzerklärung kann <a href="' . zen_href_link ( FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">hier</span></a>gelesen werden .');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'Ich habe die Datenschutzerklärung einverstanden.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Adressdetails');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Weitere Kontaktdetails');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Überprüfen Sie Ihr Alter');
define('TABLE_HEADING_LOGIN_DETAILS', 'Anmeldedaten');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Haben Sie bei uns angemeldet?');

define('ENTRY_EMAIL_PREFERENCE', 'Newsletter und E-Mail Details');
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY', 'TEXT-Only');
define('EMAIL_SEND_FAILED', 'Fehler: Fehler beim Senden von E-Mail an: "%s" <%s> mit dem Betreff: "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Fehler - kann nicht mit Datenbank verbindet werden');

// account
define('TEXT_TRANSACTIONS', 'Transaktionen');
define('TEXT_ORDER_STATUS_PENDING', 'Unbezahlt');
define('TEXT_ALL_ORDERS', 'Alle Bestellungen');
define('TEXT_MY_ORDERS', 'Meine Bestellungen');
define('TEXT_ORDER_STATUS_PROCESSING', 'Beim bearbeiten');
define('TEXT_ORDER_STATUS_SHIPPED', 'Versand');
define('TEXT_UPDATE', 'Aktualisiert');
define('TEXT_ORDER_CANCELED', 'Storniert');
define('TEXT_ORDER_STATUS_UPDATE', 'Aktualisiert');
define('TEXT_DELIVERED', 'Zugestellt');
define('TEXT_ORDER_STATUS_CANCELLED', 'Storniert');
define('TEXT_ORDER_HISTORY', 'Historie');
define('TEXT_LATESTS', 'Aktuelle News');
define('TEXT_PACKAGE_NUMBER', 'Paket Nummer');
define('TEXT_RESULT_COST', 'Ergebnis Kosten');
define('TEXT_ACCOUNT_SERVICE', 'Konto Service');
define('TEXT_MY_TICKETS', 'Systemnachrichten');
define('TEXT_DOWNLOAD_PRICTURES', 'Bilder herunterladen');
define('TEXT_ADDRESS_BOOK', 'Adressbuch');
define('TEXT_ACCOUNT_SETTING', 'Konto-Einstellung');
define('TEXT_ACCOUNT_INFORMATION', 'Konto-Einstellung');
define('TEXT_ACCOUNT_PASSWORD', 'Konto Passwort');
define('TEXT_CASH_ACOUNT', 'Kreditkonto');
define('TEXT_BLANCE', 'Balance');
define('TEXT_EMAIL_NOTIFICATIONS', 'E-Mail Benachrichtigungen');
define('TEXT_MODIFY_SUBSCRITION', 'Abonnement ändern');
define('TEXT_AFFILIATE_PROGRAM', 'Affiliate-Programm');
define('TEXT_MY_COMMISSION', 'Meine Provision');
define('TEXT_SETTING', 'Einstellung');
define('TEXT_REQUIRED_FIELDS', 'Pflichtfelder');
define('TEXT_PRODUCTS_NOTIFICATION', 'Produkt Benachrichtigung');
define('ENTRY_SUBURB1', 'Lieferanschrift 1:');
define('TEXT_MAKE_PAYMENT', 'Zahlen');
define('TEXT_CART_MOVE_WISHLIST', 'Auswahl auf Wunschliste Verschieben');
define('TEXT_PAYMENT_QUICK_PEORDER', 'Schnelle Nachbestellung ');
define('TEXT_PAYMENT_ORDER_INQUIRY', '<a href="mailto:sale_de@doreenbeads.com">Bestellung Anfrage</a>');
define('TEXT_PAYMENT_TRACK_INFO', 'Tracking-Informationen');
define('TEXT_ACTION', 'Actions');
define('PRODUCTS_QUICK_ORDER_BY_NO', 'Artikel schnell hinzufügen');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - Nur für Admin IP Ein');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - Nur für Admin IP Ein');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - Nur für Admin IP Ein');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Artikelname beginnt mit ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Neustellen --');

define('TEXT_INPUT_RIGHT_CODE', 'Geben Sie bitte den richtigen Code zu validieren!');
define('BOX_HEADING_PACKING_SERVICE', 'Verpackungsservice');
define('TEXT_PACKING_SERVICE_CONTENT', 'Wir bieten Ihnen die Verpackung und Verarbeitung Service an, um Ihre Anforderungen für spezielle Pakete oder Einzelanfertigungen zu erfüllen.');
define('TEXT_PRODUCT_DETAILS', 'Details anzeigen');
define('TEXT_HEADER_MORE', 'Mehr');
define('TEXT_HEADER_CLEARANCE', 'Räumungsverkauf');
define('TEXT_CLEARANCE', 'Räumungsverkauf');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'Es gibt kein Produkt zum Entfernen');
define('TEXT_CLEARANCE_CATE_HREF', 'Alle %s anzeigen');
define('TEXT_HEADER_TOP_SELLER', 'Best Seller');

define('TEXT_PRODUCT_IMAGE', 'Produktbild');
define('TEXT_ITEM_NAMES', 'Artikelname');
define('TEXT_PRICE_WORDS', 'Preis');
define('TEXT_WEIGHT_WORDS', 'Gewicht:');
define('TEXT_ADD_WORDS', 'hinzufügen:');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'Es gibt kein Produkt zum Entfernen');

define('TEXT_DHL_REMOTE_FEE', '%s Ferngebühr per DHL Express wird benötigt. Per EMS ist es an Sie nicht lieferbar!');
define('TEXT_WIN_POP_TITLE', '');
define('TEXT_WIN_POP_NOTICE', '');

define('NOTE_CHECKOUT_SHIPPING_AIRMAIL', 'Bitte lesen Sie diesen wichtigen Hinweis >>');
define('NOTE_CHECKOUT_SHIPPING_AIRMAIL_CONTENT', 'A. Wegen einem chinesichen Fest können Pakete per Luftpost bei bestimmten Tagen verzögert werden. Wir entschuldigen uns dafür. Wenn die Artikel dringend benötigt werden, bitte wählen Sie eine weitere Versandart. <br>B. Wenn Ihre Bestellung Uhren enthält, bitte wählen Sie eine andere Art von Versand, da alle Luftpostpakete streng überprüft werden und es nicht erlaubt ist, durch diese Versandart Uhren zu schicken.<br><br>Für weitere Informationen schicken Sie bitte uns ein Email unter die Adresse<a href=mailto:service_de@doreenbeads.com> service_de@doreenbeads.com</a>.');

// account add items 2013-4-12
define('TEXT_ACCOUNT_SET', 'Konto Einstellung');
define('TEXT_PROFILE_SET', 'Mein Profil Einstellung');
define('TEXT_CHANGE_PASSWORD', 'Passwort ändern');
define('TEXT_CHANGE_EMAIL', 'Email Adresse ändern');
define('TEXT_AVARTAR', 'Avatar:');
define('TEXT_UPLOAD_FOR_CHECKING', 'Erfolgreich hochgeladen. Warten Sie bitte auf die Überprüfung');
define('ENTRY_YOUR_BUSINESS_WEB', 'Ihre Business-Website:');
define('ENTRY_CELL_PHONE', 'Handynummer:');
define('TEXT_SUBMIT', 'Eingeben');
define('TEXT_UPLOAD', 'Hochladen');
define('TEXT_CHOOSE_SYSTEM_AVARTAR', 'Wählen Sie Bild aus dem Systembasis');
define('TEXT_UPLOAD_LOCAL_IMG', 'Hochladen Mediendateien von Ihrem Computer');
define('TEXT_AVATAR_IS_PUBLIC_TO_OTHERS', 'Hinweis: Ihr Avatar ist von anderen Kunden auf unserer Website sichtbar.');
define('TEXT_CROPPED_PICTURE', 'Freigestelltes Bild');
define('TEXT_CUT', 'Ernte');
define('TEXT_RECHANGE_PIC', 'Wählen Sie neues Bild');
define('ENTRY_YOU_COUNTRY', 'Ihr Land:');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Ihr Aktuelles Passwort ist kein vorher von Ihnen angegebenes Passwort. Bitte versuchen Sie es erneut.');
define('ENTRY_NAME', 'Name:');

define('TEXT_TRUSTBOX_WIDGET_CONTENT', '<!-- TrustBox widget - Micro Review Count -->
<div style="left: -25px;position: relative;height: 10px;" class="trustpilot-widget" data-locale="de-DE" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="5742c0810000ff00058d3c5b" data-style-height="50px" data-style-width="100%" data-theme="light">
<a href="https://de.trustpilot.com/review/doreenbeads.com" target="_blank">Trustpilot</a>
</div>
<!-- End TrustBox widget -->');

define('TEXT_LANG_YEAR', 'Jahr');
define('TEXT_LANG_MONTH', 'Monat');
define('TEXT_LANG_DAY', 'Tag');
// END OF account add items 2013-4-12

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'Registrieren Sie sich um <b>US$ 6.01</b> Bargeld auf dem Konto und VIP-Vorteil bis zu <b>10%</b> zu bekommen');
define('LOGIN_EMAIL_ADDRESS', 'Email:');
define('LENGHT_CHARACTERS', 'Sie sollten mindestens 5 Zeichen (Buchstaben und Zahlen) eingeben.');
define('TEXT_YOUR_COUNTRY', 'Ihr Land: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Abonnieren Sie, um Sonderangebote per Email zu bekommen.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'Ich stimme Doreenbeads.com <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">llgemeine Geschäftsbedingungen zu</a>.');
// end of login items

// account_edit items 2013-4-19
define('TEXT_LANG_YEAR', 'Jahr');
define('TEXT_LANG_MONTH', 'Monat');
define('SET_AS_RECIPIENT_ADDRESS', 'Als Standard-Empfänger-Adresse');
// end of account_edit items

// account_order items 2013-4-19
define('TEXT_ORDER_DATE', 'Bestelldatum');
define('TEXT_ORDER_DATE_DATE', 'Bestelldatum:');
define('TEXT_ORDER_NUMBER', 'Bestellnummer');
define('TEXT_ORDER_NUMBER_LABEL', 'Bestelldatum:');
define('TEXT_ORDER_TOTAL', 'Gesamtbestellung');
define('TEXT_ORDER_STATUS', 'Bestellstatus');
define('TEXT_ORDER_STATUS_LABEL', 'Bestellstatus:');
define('TEXT_ORDER_DETAILS', 'Details');
define('TEXT_ORDER_PRODUCT_PART', 'Schnelle Bestellung nach Produkt Art.-Nr.>>');
define('TEXT_ORDER_NO_EXISTS', 'Keine Bestellung');
define('TEXT_DISCOUNT_OFF_SHOW', 'rabatt');
define('TEXT_HANDING_FEE', 'Handling Fee');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Anzeige <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Bestellungen)');
define('SUCCESS_PASSWORD_UPDATED', 'Ihr Passwort wurde erfolgreich aktualisiert');
define('TEXT_AVATAR_UPLOAD_SUCCESSFULLY', 'Bild wurde genehmigt. Vielen Dank!');
// end of account_order items

// bof v1.0, zale 20130424
define('EXTRA_NOTE', 'Es dauert 2-3 Tagen von unserer Lager zu Ihrer chinesischen Agent-Adresse.');
define('TEXT_NOTE_SPTYA', '<font color="red">Bitte addieren Sie Ihre chinesische Agent-Adresse <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments">Bestellung Kommentare.</a></font>');
define('TEXT_DETAILS_SPTYA', '<font color="red">Details:</font><br />
<font color="red">1、</font>Wählen Sie einen Spediteur in China, denen Sie vertrauen.<br />
<font color="red">2、</font>Geben Sie uns die Adresse und Kontaktinformationen des Spediteurs ( besser auf Chinesisch wenn möglich) auf <font weight="700" color="blue"> Bestellung Kommentare</font>.<br />
<font color="red">3、</font>Wir liefern Ihre Waren an diesen Ort. Sie zahlen nur die Versandgebühr von unserer Stadt zu die Adresse des gewählten Spediteurs. Normalerweise ist es ungefähr nur <font color="blue">1-2 USD/kg</font>, und Sie können es erst zahlen, nachdem Sie die Bestellung und den Agent bestätigen. 2-3 Tagen nach der Bestellung kann der Agent das Paket erhalten.<br /><br />
<span style="color:red;">Note:</span> Sorgen Sie bitte nicht um die Zollprobleme, und Sie können das Paket ohne Steuererhebung bekommen.');

define('TEXT_DETAILS_TRSTV', '<font color="red">Details:</font><br />
<font color="red">1、</font>Ihre Sendung wird zuerst an unseren Suifenhe Spediteur versendet(in der Provinz Heilongjiang, China).<br />
<font color="red">2、</font>Dann wird unser Agent Ihr Paket nach Wladiwostok versenden (Владивосток, in südöstlich von Russland). <br />
<font color="red">3、</font>Wenn das Paket dort angekommen ist, wird der lokale Spediteur Ihnen kontaktieren, Ihre Paketinformation informieren und dann können Sie die Versandart wählen, wie Ihr Paket von Wladiwostok nach Ihrer Stadt schicken soll. Sie sollen die inländische Versandgebühr bezahlen.<br /><br />
<font color="red">Zum Schluss:</font><br />
Die Versandkosten = der gezeigte Betrag von unserem Unternehmen nach Wladiwostok(von dorabeads berechnet) + Nachnahme von Wladiwostok zu Ihrem Platz (von Ihrer lokalen Spedition berechnet, und eine Schätzung ist<font color="blue">1-3 USD / kg</font>)<br/><br />
  
Der Suifenhe Spediteur ist ein erfahrener und vertrauensvoller Spediteur, der mit uns sehr gut zusammengearbeitet hat.<br /><br />
<span style="color:red;">Note:</span> Sorgen Sie bitte nicht um die Zollprobleme, und Sie können das Paket ohne Steuererhebung bekommen.');

define('TEXT_DETAILS_TRSTM', '<font color="red">Details:</font> <br />
<font color="red">1、</font>Wir werden die Waren nach China-Russland-Logistic Unternehmen versenden（ in Beijing, china）, der zur Güterbeförderung nach Moskau verantwortlich ist. <br>
<font color="red">2、</font>Wenn das Paket in Moskau angekommen ist, wird der lokale Spediteur Ihnen kontaktieren, Ihre Paketinformation informieren und dann können Sie die Versandart wählen, wie Ihr Paket von Moskau nach Ihrer Stadt schicken soll. Der Mitarbeiter wird die Ware nach Ihrer Anweisung an Sie versenden. Sie sollen die inländische Versandgebühr bezahlen. <br /><br />
  
<font color="red">Zum Schluss:</font><br />
Die Versandkosten = der gezeigte Betrag von unserem Unternehmen nach Moskau(von dorabeads berechnet) + Nachnahme von Moskau zu Ihrem Platz (von China-Russland-Logistic Gesellschaft  berechnet, und eine Schätzung ist <font color="blue">1 USD / kg</font>)<br /><br />
  
China-Russland-Logistic Company ist ein erfahrener und vertrauensvoller Spediteur, der gute Versicherungspolitik hat.  <span style="background:yellow;color:black;">Die von diesem Spediteur gelieferte Waren sind normalerweise gut angekommen .</span><br /><br />
<span style="color:red;">Note:</span> Sorgen Sie bitte nicht um die Zollprobleme, und Sie können das Paket ohne Steuererhebung bekommen.');

define('TEXT_DETAILS_TRSTMA', 'Ihre Waren werden zu einer der folgenden Städte, die in der Nähe Ihrer Lieferadresse ist, per Luft versendet:
  <div style="color:#008FED;margin: 10px 0;">Moscow, St. Petersburg, Krasnoyarsk, Novosibirsk, Ekaterinburg, Irkutsk, Omsk, Kamchatka, Sakhalin, Yakutsk</div>
  a. Wenn das Paket in der Stadt, die in Ihrer Nähe ist kommt, wird unser Spediteur Ihnen kontaktieren.Dann können Sie das Paket selbst abholen. In diesem Fall müssen Sie keine zusätzliche Versandgebühr bezahlen. (Bitte beachten Sie, wenn Sie in der Nähe von Moskau leben, bitte holen Sie das Paket rechtzeitlich ab, und sonst haben Sie Lagergebühr zu bezahlen.)<br><br>
  b. Wenn Sie das Paket nicht selbst abholen können, kann das Paket durch eine von Ihnen ausgewählte Versandart zu Ihnen schicken. Der Mitarbeiter wird die Ware nach Ihrer Anweisung an Sie versenden. Sie sollen die inländische Versandgebühr bezahlen.<br><br>
 Die Versandkosten = der gezeigte Betrag wenn Sie zur Kasse gehen (von 8years berechnet) + Nachnahme von dieser Stadt zu Ihrem Platz (vom Logistik-Unternehmen berechnet).<br><br>
  <font color="#ff0000">Hinweis:</font> Um Ihr Paket erfolgreich zugestellt zu werden, wurde das Foto oder Kopie des Empfänger Personalausweises von Transportgesellschaft benötigt. Bitte schicken Sie das an <a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a>. Bei weiterer Fragen bitte kontaktieren Sie uns.');
define('TEXT_TRSTM','a. We will ship the goods to the Logistic company who is responsible for carrying goods to Moscow.<br>
b. When arriving in Moscow, a logistics specialist will contact you, inform you that the parcel arrives and then you can choose the shipping method for your parcel from Moscow to your address at your preference. Also you have to pay your domestic shipping fee.<br>
<b>The shipping cost</b> = the amount has been shown when you checkout (charged by 8seasons) + Cash on Delivery from Moscow to your place (charged by Logistic company, an estimate shipping is about 0.3-0.5 USD / kg).');

define('TEXT_DETAILS_YNKQY', 'Ihre Waren werden zu einer der folgenden Städte, die in der Nähe von Ihrer Lieferadresse ist, mit dem <b>Auto</b> versendet:
<div style="color:#008FED;margin: 10px 0;">Moscow, St. Petersburg, Krasnoyarsk, Novosibirsk, Ekaterinburg, Irkutsk, Omsk, Yakutsk, Ussuri, Khabarovsk, Tyumen, Vladivostok, Yakutsk</div>
a. Wenn das Paket in der Stadt, die in Ihrer Nähe ist kommt, wird unser Spediteur Ihnen kontaktieren.Dann können Sie das Paket selbst abholen. In diesem Fall müssen Sie keine zusätzliche Versandgebühr bezahlen.(Bitte beachten Sie, wenn Sie in der Nähe von Moskau leben, bitte holen Sie das Paket rechtzeitlich ab, und sonst haben Sie Lagergebühr zu bezahlen.)<br><br>
b. Wenn Sie das Paket nicht selbst abholen können, kann das Paket durch eine von Ihnen ausgewählte Versandart zu Ihnen schicken. Der Mitarbeiter wird die Ware nach Ihrer Anweisung an Sie versenden. Sie sollen die inländische Versandgebühr bezahlen.<br><br>
<b>Die Versandkosten</b> = der gezeigte Betrag wenn Sie zur Kasse gehen (von doreenbeads berechnet) + Nachnahme von dieser Stadt zu Ihrem Platz (vom Logistik-Unternehmen berechnet).<br><br>
<font color="#ff0000">Hinweis:</font> Um Ihr Paket erfolgreich zugestellt zu werden, wurde das Foto oder Kopie des Empfänger Personalausweises von Transportgesellschaft benötigt. Bitte schicken Sie das an<a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a>. Bei weiterer Fragen bitte kontaktieren Sie uns.');

define('TEXT_READ_NOTE', 'Bitte lesen Sie diesen Hinweis.');
define('TEXT_SPTYA', 'Sie sollten einen chinesischen Spediteur wählen und dann sagen uns seine Lieferadresse in China Bescheid. Die Versandkosten, die aus unserer Stadt zu den Spediteur berechnet werden, sollen von Ihnen bezahlt werden. Wir bitte um Ihr Verständnis');

define('EXTRA_NOTE_CN', 'Wir berechnen die Versandkosten basierend auf Ihrem aktuellem Standort.');

define('NOTE_EMS', '<font color="red">Wenn Sie <strong>Uhren</strong> oder <strong>etwas scharf</strong> wie Scheren kaufen, wählen Sie bitte EMS nicht. Warum?>></font>');
define('NOTE_EMS_CONTENT', '<span style=color:red;>Zur Kunden, die Uhren oder scharfe Artikel gekauft haben:</span> Enthält Ihre Bestellung <strong>Uhren</strong> oder <strong>etwas scharf</strong> wie z.B. Scheren oder scharfe Zangen, wählen Sie bitte EMS nicht.<div style="margin-top:8px; color:#333">Grund: Das Zollamt macht strenge Kontrolle an die Artikel, und wenn Sie beim EMS Paket Uhren oder scharfe Artikel finden, wird das Paket zurück geschickt, und wird die Post auch vom Zollamt bestraft. <br/>Wenn Sie EMS bevorzugen oder wenn die Versandkosten von EMS am billigsten ist, können Sie die verbotene Artikel mit anderen Artikel getrennt bestellen, oder schicken Sie uns ein Email unter die Adresse <a href=mailto:service_de@doreenbeads.com>service_de@doreenbeads.com</a>.Wir bieten Ihnen den besten Vorschlag an.</div>');

define('NOTE_USPS', '<font color="red">Wenn Sie <strong>Uhren</strong> oder <strong>etwas scharf</strong> wie Scheren kaufen, wählen Sie bitte USPS nicht. Warum?>></font>');
define('NOTE_USPS_CONTENT', '<span style=color:red;>Zur Kunden, die Uhren oder scharfe Artikel gekauft haben:</span> Enthält Ihre Bestellung <strong>Uhren</strong> oder <strong>etwas scharf</strong> wie z.B. Scheren oder scharfe Zangen, wählen Sie bitte USPS nicht.<div style="margin-top:8px; color:#333">Grund: Das Zollamt macht strenge Kontrolle an die Artikel, und wenn Sie beim USPS Paket Uhren oder scharfe Artikel finden, wird das Paket zurück geschickt, und wird die Post auch vom Zollamt bestraft. <br/>Wenn Sie USPS bevorzugen oder wenn die Versandkosten von USPS am billigsten ist, können Sie die verbotene Artikel mit anderen Artikel getrennt bestellen, oder schicken Sie uns ein Email unter die Adresse <a href=mailto:service_de@doreenbeads.com>service_de@doreenbeads.com</a>.Wir bieten Ihnen den besten Vorschlag an.</div>');

define('TEXT_NOTE_ABOUT_TAX', 'Bitte lesen Sie den Hinweis zur Steuer! Details>>');
define('TEXT_NOTE_ABOUT_TAX_CONTENT', 'Hinweis zur Steuer: Nach unserer Erfahrung gibt es große Risiken vom Gebührensatz beim Paket, der durch Fedex zu Ihnen geschickt wird.  Bitte merken Sie auf der Information und wählen Sie eine beste Versandart.');

define('NOTE_FEDEX','<font color="red">Bestellungen mit Uhren sind nicht empfohlen,per FedEx versendet zu werden! Warum?>></font>');
define('NOTE_FEDEX_CONTENT','Für Kunden, die Uhren kaufen: Wenn Ihre Bestellung Uhr enthält, empfehlen wir Ihnen, nicht FedEx auszuwählen. Sie können andere Versandarten wählen.<br/><font style="color:red;font-weight:bold;">Grund</font>: FedEx überprüft ernst diese elektronischen Produkte. Wenn sie das Paket mit Uhr fänden, wird das Paket von Zollamt abgefangen.<br/>Wenn Sie gern FedEx benutzen oder irgende Frage haben, kontaktieren Sie bitte frei uns unter: <a href=mailto:service_de@doreenbeads.com>service_de@doreenbeads.com</a>. Wir werden Ihnen den besten Vorschlag geben.');
define('TEXT_NOTE_USE_ENGLISH' , 'Fedex erfordert Adresse auf Englisch, warum?');
define('TEXT_NOTE_USE_ENGLISH_DESCRIPTION' , 'Fedex erfordert Adresse auf Englisch, um keine Verzögerung beim Versand zu verursachen, hinterlassen Sie bitte Ihre Adresse auf Englisch beim Auschecken. Wenn Sie keine haben, kontaktieren Sie bitte unseren Kundenservice: <a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a>');

define('TEXT_NOTE_ABOUT_WATCH', 'Bitte lesen Sie den Hinweis über Uhren. Details>>');
define('TEXT_NOTE_ABOUT_WATCH_CONTENT', 'Wenn in Ihrem Paket mehr als 20% Artikel Uhren sind, wählen Sie bitte DHL(direkt) nicht, da DHL strenge Kontrolle auf elektrischen Produkte, wie z.B. die Uhr, macht. Das Paket wird nicht erlaubt, nach Ausländer zu schicken.');

define('NOTE_TARIFF', 'Benachrichtigung über die von der Zollbehörde verkündeten Preise');
define('NOTE_TARIFF_CONTENT', 'Mit dieser Versandart schreiben wir passenden Wert (ca. 15GBP-40GBP)auf dem Paket, damit Sie keinen Gebührensatz zahlen müssen. <br />Wenn Sie echten Wert auf dem Paket schreiben lassen möchten, müssen Sie 20% Gebührensatz bezahlen. Damit empfehlen wir Ihnen, dass sie uns es bearbeiten lassen.');
define('NOTE_TARIFF_CONTENT_US', 'Über diese Versandart werden wir für diese Paketen den angemessenen Preis (gegen 15GBP- 40GBP) angeben, sodass Sie keine Steuer bezahlen können. <br />Wenn Sie den echten Preis für diese Pakete angeben möchten, brauchen Sie 20% der Steuer zu zahlen. So schlagen wir stark vor, Sie lassen uns den passenden Preis festsetzen. Wir werden richtig es behandeln.');

define('TEXT_HOW_DOES_IT_WORKS', 'Wie funktioniert es?');
define('TEXT_HOW_DOES_IT_WORKS_1', 'Wie funktioniert es? Eine Kopie des Personalausweises ist erforderlich.');

define('TEXT_POBOX_REMINDER', 'Hinweis: Um Ihr Paket an Sie gut zustellen zu dürfen, geben Sie uns bitte die richtige Straße statt nur Postfachadresse.');

define('TEXT_YOUR_ITEMS_BE_SHIPPED', 'Ihre Artikel werden zusammen versendet in');
define('TEXT_BOXES', 'Boxen');

define('TEXT_WOOD_PRODUCTS_NOTICE', 'Holz / Bambus Produkte werden nicht durch DHL zu verschicken empfehlen, warum?');

define('NOTE_GREECE', '<a href="' . HTTP_SERVER . '/page.html?id=215' . '" target="_blank">Bitte beachten Sie auf dem Zoll-Hinweis. >></a>');

define('TEXT_DETAILS_SFHYZXB', 'Es ist NICHT Tür zu Tür Service. Sie sollten das Paket bei Ihrem lokalen Postamt abholen. Wenn das Paket beim lokalen Postamt ankommt, werden Sie eine Benachrichtigung bekommen. Dann können Sie mit Ihrer gültigen ID Ihr Paket abholen. Sorgen Sie bitte nicht um Zoll, und wir kümmern uns um alles. <br>
Freundliche Anmerkung: Maxim Gewicht: 30kg pro Paket. Wenn Ihre Bestellung mehr als 30 kg wiegt, werden wir es in einige Pakete einpacken.');

define('TEXT_DETAILS_SFHKY', 'Tür zu Tür Service. Paket wird zu Уссури zuerst gesendet werden, dann an Ihren örtlichen Postamt mit dem Flugzeug transportiert. Wenn es bei der lokalen Postamt ankommt, wird der Briefträger das Paket zu Ihnen nach Hause bringen. Sorgen Sie bitte nicht um Zoll, und wir kümmern uns um alles. <br>Vorteile: A. Kein Steuerproblem B. Online Verfolgung: <a href=http://www.sfhpost.com>www.sfhpost.com</a>.<br>Nachteile: Wir schicken Waren nur zur lokalen Post.<br>Bitte beachten Sie: Maxim Gewicht: 20kg. Wenn Ihre Bestellung mehr als 20 kg wiegt, werden wir es in einige Pakete einpacken.');

define('TEXT_NOTE_SPTYA', '<font color="red">Bitte tippen Sie die Adresse Ihrer chinesichen Spediteur auf <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#Kommentare">Bestellung Kommentare.</a></font>');

define('TEXT_NO_AVAILABLE_SHIPPING_METHOD', '<font color="red"><b>HINWEIS: </b></font>Wenn es keine verfügbare Versandmethode zu Ihrer Lieferadresse gibt, es wäre besser wenn Sie <a href="mailto:service_de@doreenbeads.com">Uns kontaktieren</a> bevor Sie zur Kasse gehen.');

define('TEXT_ITEM', 'Artikel');
define('TEXT_PRICE', 'Preis');
define('TEXT_SHIPPING_METHOD', 'Versandart');
define('TEXT_SHIPPING_METHODS', 'Versandarten');
define('TEXT_DAYS', 'Tagen');
define('TEXT_NOTE', 'Note');
define('TEXT_DAYS_LAN', 'Tagen');
define('TEXT_WORKDAYS', 'Werktagen');

define('TEXT_DAYS_ALT_S_Q', '	Tagen von mehr zu wenig');
define('TEXT_DAYS_ALT_Q_S', 'Tagen von wenig zu mehr');
define('TEXT_PRICE_ALT_L_H', 'Preis von niedrig zu hoch');
define('TEXT_PRICE_ALT_H_L', 'Preis von noch zu niedrig');

define ( 'TEXT_SHIPPING_FEE', 'Versandkosten wurden durch Volumen und Gewicht berechnet' );
define ( 'TEXT_CLICK_HERE_FOR_MORE_LINK', '<a href="' . HTTP_SERVER . '/page.html?id=160" target="_blank">Klicken Sie hier für Details.</a>' );
define ( 'TEXT_SHIPPING_NOTE','Bitte achten Sie darauf, die oben Versandgebühr sind die zusätzliche Gebühr für entlegenes Gebiet Anlieferung enthaltend. ( Erfordert von %s --- ');
define ( 'TEXT_TOTAL_BOX_NUMBER', 'Gesamt Kasten' );
define('TEXT_SHIPPING_VIRTUAL_COUPON_ACTIVITY', 'Wenn Sie diesen Service wählen, erhalten Sie einen $2 Gutschein (kein Mindestbestellwert, ein Gutschein pro Kunde).');

// eof

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'Registrieren Sie sich um <b>US$ 6.01</b> Bargeld auf Ihrem Konto und VIP-Vorteil bis zum <b>10%</b> zu bekommen');
define('LOGIN_EMAIL_ADDRESS', 'Email:');
define('LENGHT_CHARACTERS', 'Dies sollte mindestens fünf Zeichen sein. ');
define('TEXT_YOUR_COUNTRY', 'Ihr Land: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Abonnieren Sie, um unsere Sonderangebote per Email zu erhalten.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'Ich stimme Doreenbeads.com Allgemeine Geschäftsbedingungen zu. ');
// end of login items

define('ENTRY_EMAIL_FORMAT_ERROR', 'Ihre E-Mail-Format ist nicht korrekt, bitte versuchen Sie es erneut.');
define('TEXT_VIEW_INVOICE', 'Rechnung anzeigen');

define('TEXT_DISCOUNT_OFF', 'Rabatt');
define('TEXT_BE_THE_FIRST', 'Werden Sie die erste');
define('TEXT_WRITE_A_REVIEW', 'eine Rezension zu schreiben');
define('TEXT_READ_REVIEW', 'Bewertung lesen');
define('TEXT_SHIPPING_WEIGHT_LIST', 'Versandgewicht:');
define('TEXT_MODEL', 'Artikel Nr.');
define('TEXT_INFO_SORT_BY_STOCK_LIMIT', 'Auf Lager - mehr bis weniger');
define('TEXT_STOCK_HAVE_LIMIT', 'Nur noch %s auf Lager');
define('TEXT_PROMOTION_ITEMS', 'für Nicht-werbeaktion Artikel');

define('TEXT_PASSWORD_FORGOTTEN', 'Haben Sie Ihr Passwort vergessen?');
define('TEXT_LOGIN_ERROR', 'Es tut uns Leid. Es passt Ihre Email Adresse oder Ihr Passwort nicht.');

define('TEXT_ADDCART_MIN_COUNT', 'Die Mindestbestellmenge von %s ist  %s. Die Menge wird auf %s automatisch aktualisiert.');
define('TEXT_ADDCART_MAX_COUNT', 'Die maximale Bestellmenge von %s ist  %s. Die Menge wird auf %s automatisch aktualisiert.');
define('TEXT_ADDCART_NUM_ERROR', '<img height="20" width="20" title=" Caution " alt="Caution" src="includes/templates/template_default/images/icons/warning.gif">Es tut uns Leid. Wir haben zurzeit nur %s Packungen von %s auf Lager. Bitte aktualisieren Sie die Menge. Haben Sie Fragen, schicken Sie bitte uns ein Email unter die Adresse sale@doreenbeads.com');
define('TEXT_ADDCART_NUM_ERROR_ALERT', 'Die verfügbare Menge für diesen Artikel ist (%s). Bitte geben Sie eine verfügbare Menge oder kaufen Sie weitere Artikel. Vielen Dank für Ihr Verständnis!');

define('TEXT_MOVE_TO_WISHLIST_SUCCESS', 'Artikel wurde erfolgreich auf Ihrer Wunschliste hinzugefügt! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">Wunschliste anzeigen</a>');
define('TEXT_HAD_BEEN_IN_WISHLIST','Die Waren war schon in der Wunschliste  <a href="'.zen_href_link('wishlist','','SSL').'">Artikel der Wunschliste sehen</a>');
define('TEXT_MOVE_TO_WISHLIST_SUCCESS_NOTICE', 'Alle Artikel wurden erfolgreich auf Ihrer Wunschliste hinzugefügt! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">Wunschliste anzeigen</a>');
define('TEXT_VIEW_SHIPPING_WEIGHT', 'Versandgewicht anzeigen');
define('TEXT_PRODUCT_WEIGHT', 'Produktgewicht');
define('TEXT_WORD_PACKAGE_BOX_WEIGHT', 'Verpackung Gewicht');
define('TEXT_WORD_SHIPPING_WEIGHT', 'Versandgewicht');
define('TEXT_WORD_VOLUME_WEIGHT', 'Volumen');
define('TEXT_CALCULATE_BY_VOLUME','Versandgebühr wurde nach Volumengewicht berechnet.');
define('TEXT_SHIPPING_COST_IS_CAL_BY', 'Versandkosten=Produktgewicht+Verpackung Gewicht.');

define('TEXT_CART_TOTAL_PRODUCT_PRICE', 'Warenwert');
define('TEXT_CART_ORIGINAL_PRICE', 'Gesamtbetrag der Waren zum üblichen Preis');
define('TEXT_CART_PRODUCT_DISCOUNT', 'Ursprünglicher Betrag der rabattierten Waren');
define('TEXT_CART_DISCOUNT_PRICE', 'Rabattbetrag der rabattierten Waren');
define('TEXT_CART_ORIGINAL_PRICES','Neupreis');
define('TEXT_CART_DISCOUNT','Rabatt');
define('TEXT_PROMOTION_SAVE','Durch Promotion Sparen');
define('TEXT_ORDER_DISCOUNT',' Bestellrabatt');
define('TEXT_CART_VIP_DISCOUNT','VIP-Rabatt');
define('TEXT_RCD','RCD');
define('TEXT_FREE_SHIPPING', 'Kostenloser Versand');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'Diskontierter Preisbetrag ');
define('TEXT_CART_QUICK_ADD_NOW', 'Jetzt Schnell hinzufügen');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Einfach die Artikelnr. und Menge eingeben, dann werden die gewünschten Sachen ohne Umwege in den Warenkorb gelegt.');
define('TEXT_CART_ADD_TO_CART', 'In den Warenkorb');
define('TEXT_ADD_TO_CART_SUCCESS', 'Zum Warenkorb erfolgreich hinzugefügt!');
define('TEXT_VIEW_CART', 'Warenkorb anzeigen');

define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Fügen Sie weitere Artikel ein');
define('TEXT_ITEMS_ADDED_SUCCESSFULLY', 'Neue Artikel wurden erfolgreich hinzugefügt.');
define('TEXT_QUICKADD_ERROR_EMPTY', 'Bitte geben Sie mindestens ein Produkt Nr. und Menge');
define('ERROR_PLEASE_CHOOSE_ONE', 'Bitte wählen Sie mindestens einen Artikel aus.');
define('TEXT_QUICKADD_ERROR_WRONG', 'Es tut uns Leid. Einige Artikel sind nicht verfügbar. Bitte entfernen Sie den falschen Artikelnummer / Menge');

define('TEXT_BY_PART_NO', 'Per Artikelnr.');
define('TEXT_BY_SPREADSHEET', 'Per Tabelle');
define('TEXT_EXAMPLE', 'Beispiel');
define('TEXT_SAMPLE_FROM_YOUR_SPREADSHEET', 'Beispiel: Kopieren und pastieren den schattigen Bereich aus Ihrer Tabellenkalkulation - wie oben.');
define('TEXT_EXPORT_CART', 'Warenkorb exportieren');
define('TEXT_PLEASE_ENTER_AT_LEAST', 'Bitte geben Sie wenigstens eine Artikelnummer und Menge ein.');
define('TEXT_ITEMS_NOT_FOUND', 'Die folgenden Artikel werden nicht in den Warenkorb hinzugefügt, weil die Artikelnr. nicht gefunden werden. %s');
define('TEXT_ITEMS_WAS_REMOVED', 'Die folgenden Artikel werden nicht in den Warenkorb hinzugefügt, weil sie entfernt wurden. %s');
define('TEXT_ITEMS_WERE_ALREADY_IN_YOUR_CART', 'Die folgenden Artiken wurden in Ihrem Warenkorb hinzugefügt und die Menge sind schon aktualisiert. Sie können diese Menge der Artikel wenn notwendig prüfen. %s');
define('TEXT_ITEMS_QTY_WAT_NOT_FOUND', 'Die folgenden Artikel werden nicht in den Warenkorb hinzugefügt, weil die Menge der Artikel nicht gefunden werden. %s');
define('TEXT_ITEMS_MODIFIED_DUE_TO_LIMITED', 'Die Menge der folgenden Artikel wurden aufgrund der begrenzten Vorräte modifiziert. %s');

define('TEXT_CART_JS_WRONG_P_NO', 'Falsche Artikelnummer. Um fortzufahren sollten Sie diesen Artikel aus der Liste entfernen.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'Es tut uns Leid. Einige Gegenstände wurden nicht gefunden. Bitte entfernen Sie die falsche Artikel Nr.');
define('TEXT_CART_JS_NO_STOCK', 'Nicht auf Lager. Um fortzufahren, sollten Sie diesen Artikel aus der Liste entfernen.');

define('TEXT_PAYMENT_DOWNLOAD', 'herunterladen');
define('TEXT_PAYMENT_PRINT', 'drucken');
define('TEXT_PAYMENT_PROMOTION_DISCOUNT', 'Rabatte');

define('TEXT_EYOUBAO', 'Es ist eine Art der chinesisch-russischen Logistikdienstleister, der von PONY EXPRESS und einem chinesischen Logistikunternehmen gestartet wurde und durch schnelle Lieferung Geschwindigkeit, wettbewerbsfähigen Güterverkehr und Sicherheitsgarantie gekennzeichnet wird. Es wird die bevorzugte Wahl von chinesisch-russischen Grenzüberschreitende E-Commerce-Anbietern.<br><br>
Vorteile: <br>
1 Elektronische Produkte erlaubt;<br>
2 End-to-end Online Verfolgung: Verfolgen Sie das bitte auf <a href="http://set.zhy-sz.com/" target="_blank">http://set.zhy-sz.com/</a> (offizielle Website) oder <a href="http://www.ponyexpress.ru/en/trace.php" target="_blank">http://www.ponyexpress.ru/en/trace.php</a> (Zielland) während der gesamten Reise;<br>
3 Aging-Garantie: Wenn das Paket innerhalb von 32 Tagen nicht angekommen ist, wird die Gesamtfracht erstattet, wenn Sie für die Versandkosten weniger als 50USD bezahlt haben. Oder wird 50 USD erstattet, wenn Sie für die Versandkosten mehr als 50USD bezahlt haben. <br>
(Ausnahmebedingungen nicht einschließlich: A. Aus dem Grund der Kunden wie falsche Lieferadresse, der Empfänger nicht gefunden, keine Unterschrift, etc. B. Aus dem Grund höherer Gewalt Faktoren wie Krieg, Katastrophen, Luftstoß, etc.. );<br>
4 Über Versicherung: Die Versicherung ist optional. Wenn Ihr Paket sehr groß ist sind Sie herzlich empfohlen, eine Versicherung, die 3% des angegebenen Paketwertes berechnet, zu kaufen. Zum Beispiel, wenn Sie 1000USD auf Ihrem Paket schreiben lassen, beträgt die Versicherung 30USD. Wenn das Paket verloren ist, bekommen Sie 1000USD zurück.<br><br>
Nachteile: <br>
1 Gewichtsbeschränkung: 31kg. Wenn Ihre Bestellung mehr als 31 kg wiegt, werden wir es in einige Pakete einpacken;<br>
2 Größenbeschränkung: 60cmx55cmx45cm;<br>
3 Keine Konterbande.<br>');

define('TEXT_XXEUB', 'Eine Transportart, die nur ungefähr 7-15 Tagen dauert. Das Paket wird an den Empfänger von dem lokalen Postamt geliefert. Tracking-Informationen finden Sie auf: <a href="https://tools.usps.com/go/TrackConfirmAction_input" target="_blank">https://tools.usps.com/go/TrackConfirmAction_input</a>.<br><br>
Vorteile: <br>
1 Kosteneffizient: Es dauert nur 7-15 Tagen, um das Ziel zu erreichen. Manchmal kann das Paket an den Empfänger innerhalb von 4-6 Tagen erreichen. <br>
2 Kein Zollproblem;<br>
3 PO BOX Adresse erlaubt;<br><br>
Nachteile:<br>
Höchstgewicht: 2kg. Wenn Ihre Bestellung mehr als 2 kg wiegt, werden wir es in einige Pakete einpacken. <br><br>
Hinweis: Eine Telefonnummer ist für die Zustellung erfordlich. <br>');
define('TEXT_HMJZ', '(Gesamtzahl der Boxen: 1)');
// /////////////////////////////////////////////////////////
// dorabeads v1.5
define('TEXT_AVATAR_UPLOAD_TIPS', '<div style="font-weight:normal;font-size:15px;text-align:left;padding:0px 15px 0px 15px;line-height:23px;color:#ff6600">Wenn Sie eine Bilddatei von Ihrem Computer auswählen, bitte beachten Sie, :<p style="margin-top:5px">1. 50 KB max.<br>2. Jpg, gif, png, bmp only.<br>3. Size Recommended: 50x50, 100x100.<br>4.Ihr Avatar ist für andere Kunden auf<br>&nbsp;&nbsp;&nbsp;unserer Webseite sichtbar.</p></div>');
define('TEXT_CASH_CREATED_MEMO_1', 'Ihr Kreditbetrag wurde für Ihre Bestellung Nummer #%s verwendet');

define('TEXT_TARIFF_TITLE_1', 'Die deutsche Zollkontrolle ist sehr streng. Am Besten schreiben Sie Ihre Zollnummer /EORI Nummer auf. Es hilft bei der Zollabfertigung. <br /><br/>EORI Nummer:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( wahrbar )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/>');

define('TEXT_TARIFF_TITLE_2', 'Die deutsche Zollkontrolle ist sehr streng. Am Besten schreiben Sie Ihre Zollnummer /EORI Nummer auf. Es hilft bei der Zollabfertigung. <br /><br/><FONT COLOR="RED">*</FONT> EORI Nummer:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( notwendig )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your CPF/CNPJ No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/><br /><br/><FONT COLOR="RED"><b>Note：</b></FONT>Alle Pakete durch Express nach Brazil brauchen CPF/CNPJ Nr.. Wenn Sie keine haben, wählen Sie bitte Airmail.');

define('TEXT_TARIFF_TITLE_3', 'Die deutsche Zollkontrolle ist sehr streng. Am Besten schreiben Sie Ihre Zollnummer /EORI Nummer auf. Es hilft bei der Zollabfertigung. <br /><br/><FONT COLOR="RED">*</FONT> EORI Nummer :<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( notwendig )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your EORI No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/><br /><br/><FONT COLOR="RED"><b>Hinweis：</b></FONT>FedEx(by Agent) braucht EORI Nr.. Wenn Sie keine haben, wählen Sie bitte eine andere Versandart. ');

define('TEXT_TARIFF_TITLE_4', 'Die deutsche Zollkontrolle ist sehr streng. Am Besten schreiben Sie Ihre Zollnummer /EORI Nummer auf. Es hilft bei der Zollabfertigung. <br /><br/>EORI Nummer:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( wahrbar )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/>');

define('TEXT_TARIFF_TITLE_5', 'Die deutsche Zollkontrolle ist sehr streng. Am Besten schreiben Sie Ihre Zollnummer /EORI Nummer auf. Es hilft bei der Zollabfertigung. <br /><br/>Custom Nummer:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( wahrbar )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="Custom No."/>');

// bof dorabeads v1.7, zale
define('TEXT_VERIFY_NUMBER', 'Überprüfung-snummer');
define('TEXT_TRACKING_NUMBER', 'Verfolgungsnummer');
define('TEXT_TERMS_CONDITIONS', 'Allgemeine Geschäftsbedingungen');
define('TEXT_PRIVACY_POLICY', 'Datenschutzerklärung');
define('TEXT_SHOPPING_CART_OUTSTOCK_NOTE', 'Folgende Produkte wurden aus dem Warenkorb zur Wunschliste verschoben da sie zurzeit ausverkauft sind. Sie werden bald wieder verfügbar. Klicken Sie einfach auf Auffüllung Benachrichtigung, um die Auffüllung Neuigkeiten zu bekommen.');
define('TEXT_SHOPPING_CART_DOWN_NOTE', 'Folgende Produkte wurden aus Ihrem Warenkorb entfernt, da sie nicht auf Lager sind. Wenn Sie es benötigen, kontaktieren Sie uns bitte über <a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a>.');
define('TEXT_VIEW_LESS_SHOPPING_CART', 'Verbergen ');
define('TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS', 'Ähnliche Gegenstände Wählen');
define('TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS', 'ungültige Artikel leeren');
define('TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS', 'Bestätigen Sie, ungültige Artikel zu leeren?');
define('PROMOTION_LEFT', '');
define('TEXT_SIMILAR_PRODUCTS', 'Ähnliche Produkte');

define('TEXT_CODE_DAY','Tag');
define('TEXT_CODE_HOUR','Std.');
define('TEXT_CODE_MIN','Min.');
define('TEXT_CODE_SECOND','Sek.');
// eof v1.7
define('EMAIL_GREET_MR', 'Hallo  %s' . "\n\n");
define('EMAIL_GREET_MS', 'Hallo  %s' . "\n\n");
define('TEXT_PAY_SUCCESS_TIP_TiTLE', 'Warmer Hinweis:');
define('TEXT_PAY_SUCCESS_TIP', 'Angesichts der derzeit angespannten Situation in der globalen Epidemie werden die Flüge immer enger, so dass es zu Verzögerungen bei der Schifffahrt kommen kann.
Wir werden unser Bestes tun, damit Sie die Ware so schnell wie möglich erhalten.');
define('TEXT_IMPORTANT_NOTE', 'Wichtiger Hinweis auf <b>Versandadresse</b>');
define('TEXT_PLEASE_KINDLY_CHECK', 'Sollten Sie einen Fehler oder Schreibfehler im Zusammenhang mit Ihrer Lieferadresse entdeckt haben,<a href="mailto:service_de@doreenbeads.com" style="color:#008FED;">kontaktieren Sie uns bitte</a> umgehen, am besten innerhalb der folgenden 24 Stunden. Da wir Ihre Sendung,und als Service unseres Hauses, bevorzugt behandeln möchten, schicken wir üblicherweise direkt nach der Bestellung Ihre Ware zu Ihnen.');

define('TEXT_SEARCH_RESULT_TITLE', 'Suchergebnisse:');
define('TEXT_SEARCH_RESULT_NORMAL', 'Deine Suche nach: <span>%s</span>, <span>%d</span> Suchergebisse für <span>%s</span> gefunden wird.');
define('TEXT_SEARCH_RESULT_SYNONYM', 'Daher können Sie suchen nach <i>%s</i> als Ersatz.');
define('TEXT_RELATED_SEARCH','Verwandt');

define('TEXT_SEARCH_TIPS','<div class="search_error_cont">
        <dl>
            <dt>Warme Hinweise:</dt>
            <dd><span>-</span><p>Bevor Sie das Wort eingeben, überprüfen Sie mal, ob das Wort richtig geschrieben wird.</p></dd>
            <dd><span>-</span><p>Wenn die von Ihnen gestöberten Teilnummer nicht verfügbar ist, <a href="mailto:service_de@doreenbeads.com">kontaktieren Sie uns bitte</a>.</p></dd>
            <dd><span>-</span><p>Suchen Sie durch ähnliche Wörter, die gleiche Bedeutung haben.</p></dd>
        </dl>
        <div class="action"><a href="'.zen_href_link(FILENAME_DEFAULT).'" class="continue_shopping">Weiter Kaufen</a><a href="'.zen_href_link(FILENAME_WHO_WE_ARE,'id=99999' ).'" class="contact_us">Uns Kontakt</a></div>
    </div>');
define('TEXT_SEARCH_RESULT_FIND_MORE','Mehr aus der folgenden suchen');

define('TEXT_CART_ARE_U_SURE_DELETE', 'Möchten Sie die Artikel löschen?');
define('TEXT_DOWNLOAD', 'herunterladen');
define('TEXT_SHIPPING_CHARGE', 'Versandkosten:');
define('TEXT_CART_VIP_DISCOUNT', 'VIP-Rabatt');
define('TEXT_CART_JS_WRONG_NO', 'Falsche Artikel Nummer');
define('TEXT_NO_STOCK', 'Nicht auf Lager');
define('TEXT_YES', 'Ja');
define('TEXT_NO', 'Nein');
define('TEXT_PER_PACK', 'pro Packung');
define('TEXT_GRAMS', 'Gramm');
define('TEXT_CREDIT_BALANCE','Kontostand:');

define('TEXT_UNIT_KG', 'kg');
define('TEXT_UNIT_GRAM', 'Gramm');
define('TEXT_UNIT_POUND', 'Pfund');
define('TEXT_UNIT_OUNCE', 'Unze');


define('TEXT_UBI_NOTE', 'Es ist verboten, die Holz oder Bambus Produkte per UBI Linie zu verschicken. Details》');
define('TEXT_UBI_NOTE_CONTENT', 'Wenn diese aus Holz oder Bambus bestehende Artikel in Ihrer Bestellung enthaltend sind, bitte wählen Sie nicht UBI Linie, weil es verboten ist, diese Holz oder Bambus-Produkten per UBI Linie zu schicken. Sie können entweder andere Versandarte für ganze Bestellung ändern oder diese Artikel separat über andere Versandarte bestellen. Falls Sie weitere Hilfe oder Beratung brauchen, klicken Sie bitte Live-Chat oder E-Mail an <a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a>.');

define('TEXT_VIEW_LIST', 'Liste');
define('TEXT_VIEW_GALLERY', 'Galerie');

define('HEADER_TITLE_NORMAL', 'Normal');
define('TEXT_SERVICE_EMAIL', 'service_de@doreenbeads.com');
define('TEXT_SERVICE_SKYPE', 'service.8seasons');

// v2.20
define('TEXT_MY_COUPON', 'Coupon');

define('TEXT_ESTSHIPPING_TIME', 'Lieferzeit');

define('PROMOTION_DAILY_DEALS', 'Wochenende Deals');
define('FACEBOOK_DAILY_DEALS','Facebook Deals des Tages');
//define('PROMOTION_DAILY_DEALS', '$0.79 Daily Deals');
define('PROMOTION_SAVED', 'Sparen');

define('TEXT_NEWSLETTER_SUCC', 'Erfolg! Vielen Dank für Ihre Anmeldung!');
define('TEXT_NEWSLETTER_JOIN', 'BEITRETEN');
define('TEXT_NEWSLETTER_EMAIL_ADDRESS', 'Emailadresse');

define('TEXT_MORE_PRO','Mehr');
define('TEXT_VIEW_LESS','Weniger');
define('TEXT_CLEAR_ALL','Alle löschen');
define('TEXT_ITEM_FOUND','<b>%s</b> Artikel gefunden');
define('TEXT_ITEM_FOUND_2','<b>%s</b> Artikel gefunden');
define('TEXT_REFINE_BY_WORDS','Verfeinern');

define('TEXT_SUB_WHICH_TYPE', 'Welcher Typ gehört zu Ihnen?');
define('TEXT_SUB_WHOLESALER', 'Großhändler');
define('TEXT_SUB_RETAILER', 'Kleinhändler');
define('TEXT_SUB_DIY_FANS', 'DIY-Fans');
define('TEXT_SUB_OTHERS', 'Sonstiges');

define('TEXT_SET_COUPON', "Es gelingt，dass der %s Gutschein in Ihre Konto hinzugefügt hat. <a href='".HTTP_SERVER."/index.php?main_page=my_coupon' style='text-decoration: underline;'>Ihren Gutschein ansehen ></a>");

define('TEXT_JOIN_NOW_COUPON', 'REGISTRIEREN FÜR <span>$6.01 GUTSCHEIN</span>');
define('TEXT_JOIN_PASSWORD', 'Passwort');
define('TEXT_JOIN_NOW_DISCOUNT_UP', 'VIP-RABATT BIS ZU 10% REDUZIERT');
define('TEXT_JOIN_NOW_SIGN_UP', 'JETZT BEITRETEN UND SPEZIELLE ANGEBOTE, HOT SALES,<br/> NEUE ARTIKEL & MEHR GENIESSEN.');
define('TEXT_JOIN_NOW_DEAR_CUSTOMERS', 'Liebe Kunden');
define('TEXT_JOIN_NOW_RETURN_CUSTOMERS_LOGIN', 'Wiederkehrende Kunden? <a href="'.zen_href_link(FILENAME_LOGIN).'" class="link_color">Einloggen</a>');

define('TEXT_SILVER_REPORT', 'Die Sterlingsilber Anlässe bei doreenbeads sind günstig und mit hohe Qualität. Unsere Sterlingsilber Produkte sind von offiziellen Institutionen in China getestet worden. die als Mitglieder von beiden ILAC und APLAC anerkannt werden. [<a target="_blank" href="silver_report.html">Testreport sehen</a>].');
define('TEXT_SWAROVSKI_CERTIFICATE', 'Als Swarovski Kaufvertreter, besitzen wir schon offizielles Agentur Zertifikat, daher können Sie sicher echte österreichischen Swaroski kristall Elemente bekommen <a target="_blank" href="swarovski_certificate.html">[Klicken Sie hier um das Zertifikat zu sehen]</a>.');
define('EMAIL_PAYMENT_INFORMATION_ADDRESS','xiaoqian.hao@panduo.com.cn');
define('TESTIMONIAL_CC_ADDRESS','dan.lin@panduo.com.cn,xiaoqian.hao@panduo.com.cn');
define('AVATAR_CHECK_ADDRESS', 'notification_de@doreenbeads.com' );
define('AVATAR_CHECK_CC_ADDRESS', 'chahua.wang@panduo.com.cn' );
define('SALES_EMAIL_ADDRESS', 'service_de@doreenbeads.com');
define('SALES_EMAIL_CC_TO', 'dan.lin@panduo.com.cn,yunan.zhang@panduo.com.cn,chahua.wang@panduo.com.cn');
define('TEXT_PRICE_AS_LOW_AS', 'ab');

define('TEXT_BACKORDER', 'Reservieren');
define('TEXT_ARRIVAL_DATE','Das Datum der geschätzte Lieferzeit: %s.');
define('TEXT_READY_DAYS', 'Voraussichtliche Lieferzeit-Periode: %s Tage.');
define('TEXT_ESTIMATE_DAYS', 'Die geschätzte Periode der Lieferzeit: %s Tage.');
define('TEXT_PREORDER','<font style="color:#ff0000" class="text_preorder_class" title="Dieser Artikel ist vorläufig nicht vorrätig, und Sie haben es schon vorbestellt.">&lt;Reservieren&gt;</font> ');

define('TEXT_CART_ERROR_NOTE_PRODUCT_LESS','Nur noch %s Packung(en) von %s sind nun auf Lager. Die Menge wird auf %s automatisch aktualisiert.');
define('TEXT_CART_ERROR_HAS_BUY_FACEBOOKLIKE_PRODUCT','Jeder Facebook Fan kann eine Packung KOSTENLOS Probe-Kits %s bekommen, die schon in Ihrer Bestellung %s gekauft werden. Daher werde es aus Ihrer Einkaufslist ausgenommen.');
define('TEXT_GET_COUPON', 'Herzliche Glückwünsche!  Sie haben Gutscheine Bis zu %s bekommen. Sie können sie in <a href="'.zen_href_link(FILENAME_MY_COUPON).'">Mein Gutschein</a> überprüfen.');
define('TEXT_ALREADY_GET', 'Oops, leider kann man nur einmal den Gutschein nehmen.');
define('TEXT_GET_COUPON_EXPIRED', 'Leider kann man nicht mehr den Gutschein nehmen, weil man schon den gültigen Zeitraum verpassen hat.');

// include email extras
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);
}

// include template specific header defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_HEADER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER);
}
// include template specific footer defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_FOOTER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER);
}

// include template specific button name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);
}

// include template specific icon name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);
}

// include template specific other image name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);
}

// credit cards
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS);
}

// include template specific whos_online sidebox defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');
}

// include template specific meta tags defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/meta_tags.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php');
}
// END OF EXTERNAL LANGUAGE LINKS
/*testimonial  mailto */
define('TESTIMONIAL_EMAILS_TO', 'service_de@doreenbeads.com');
/*coupon about to expire notice*/
define('TEXT_COUPON_NOTICE_FIRST', '<p class="tleft">Ihr Gutschein läuft bald ab. <br />
					Gutscheincode ist <span>%s</span>. Die Fristablauf ist am <span>%s</span>.');
define('TEXT_VIEW_MORE', 'Mehr blicken');					
define('TEXT_COUPON_NITICE_SECOND', '<br />	
		Wir empfehlen, dass Sie diesen Gutschein so früh wie möglich einlösen.</p>
					<a href="javascript:viod(0)" class="guidebtn">Ja, ich weiß</a>');

/*ask a question*/
define('TEXT_PART_NO','Artikelnr. :');
define("EMAIL_QUESTION_SUBJECT","Frage auf die Details über die Artikel");
define('EMAIL_QUESTION_TOP_DESCRIPTION',"Ihre Frage über diesen Artike %s bei dorabeads hat schon akzeptiert.");

define('EMAIL_QUESTION_MESSAGE_HTML',"%s<br /><br />\n\nLiebe %s,<br /><br />\n\nLass es Ihnen gut gehen!\n\n<br /><br />Vielen Dank für Ihren Kontakt mit dorabeads! Wir haben schon Ihre Frage angenommen, ein unserer Verkäufer werden Ihnen so schnell wie möglich innerhalb 24 Stunden kontaktieren. Warten Sie bitte geduldig!<br /><br />\n\nWenn Sie Erste Hilfe benötigen,kontaktieren Sie bitte uns per Live Chat oder Telefonieren mit unserer Kundenserviceabteilung unter: (+86)0571-28197839 zwischen unserer Arbeitszeit: 8:30 AM to 6:30 PM (GMT +08:00) Beijing, China Montag bis Samstag.<br /><br />\n\nDanke sehr für Ihre Zeit, wir werden bald Ihnen kontaktieren!<br /><br />\n\n--------------------------------------Ihre Frage---------------------------------------<br />%s<br /><br />%s<div style='clear:both;'>Mit freundlichen Grüßen,<br />\nDoreenbeads Team<br />\n<a href=".HTTP_SERVER.">www.doreenbeads.com</a></div>");
/*address line 1 2 same error*/
define('ENTRY_FS_ADDRESS_SAME_ERROR','Wir haben darauf geachtet, dass Ihre Adresse Linie 2 gleich mit Adresse Linie 1 ist. Korrigieren Sie bitte die Adresse Linie 2 oder lassen Sie es einfach leer. ');
define('TEXT_REMOVED','Entfernt');
define('TEXT_REFUND_BALANCE', 'Zurückgegebene Guthaben für die Bestellung: #');
/*facebook_coupon*/
define('FACEBOOK_LINK', 'https://www.facebook.com/Doreenbeadscom');
/*满减活动*/
define('TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS', 'Bestellrabatt');

/*other package size*/
define('TEXT_OTHER_PACKAGE_SIZE', "Andere Packungsgrößen");
define('TEXT_MAIN_PRODUCT','Hauptprodukt');
define('TEXT_PRODUCTS_WITH_OTHER_PACKAGE_SIZES','Produkte mit anderen Packungsgrößen');

define('TEXT_SHIPPING_CALCULATE_TIPS','<span style="color:red;font-weight:bold">Note:</span> Versandkostenrechner hier eignet nur für die Bestellungen <span style="font-weight:bold">ab US$ 19,99.</span> Ist die Bestellung unter US $19,99, werden wir mindestens US $2,99 Versandkosten einziehen.');

define('TEXT_PACK_FOR_OTHER_PACKAGE', 'Packung');
define('TEXT_PRODUCTS_IN_SMALL_PACK', 'Artikel mit Kleiner Stückzahl');
define('TEXT_PRODUCTS_IN_REGULAR_PACK', "Artikel mit normaler Stückzahl");

define('TEXT_LOGO_TITLE', 'WELTWEIT GRATIS VERSAND');
define('TEXT_DEAR_FN','Hallo %s' . "\n\n");
define('TEXT_DEAR_CUSTOMER', 'Liebe Kunden');

define('TEXT_AVAILABLE_IN715','Vorbereitungszeit: 7~15 Werktage');
define('TEXT_AVAILABLE_IN57','Vorbereitungszeit: 3~5 Werktage');
define('TEXT_PRICE_TITLE_SHOW', 'Goßhandelspreis. Wenn die Vorräte ist nicht genug, mittlere 5-15 Tagen ist benötigt für die Vorbereitung.');
define('TEXT_PRODUCTS_DAYS_FOR_PREPARATION_TIP', 'mittlere 5-15 Tagen ist benötigt für die Vorbereitung');

define('TEXT_NOTE_HOLIDAY_5','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Feiertag Achtung:</b><br/>
Am 1. Oktober ist unser Nationalfeiertag. Und von <b>1. Okt. bis zu 4 Okt. (GMT+8)</b> arbeiten wir nicht, daher um Ihr Paket rechtzeitig zu bekommen, würden wir Ihnen vorschlagen, besser die Bestellung bevor <b>29. Sept</b>. zu vergeben. 
		<br/>Doreenbeads Team</p>');
define('TEXT_NOTE_HOLIDAY_6','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Feiertag Achtung:</b><br/>
Liebe Kunde, unser Nationalfeiertag dauert von  <b>1. Okt. bis zu 4 Okt. (GMT+8)</b>. Dazwischen können Sie noch neue Bestellung vergeben wie gewohnt. Wenn wir am <b>5. Okt</b>. zurück vom Feiertag gehen, werden wir gleich arrangieren, Ihr Paket zu behandeln und so schnell wie möglich zu versenden. Je früh ist die Bestellung, desto früherer wird es behandelt. Daher würden wir vorschlagen, so früh wie möglich eine Bestellung zu vergeben.
		<br/>Doreenbeads Team</p>');

define('ENTRY_EMAIL_ADDRESS_REMOTE_CHECK_ERROR','Ungültige E-Mail Adresse. Bestätigen Sie noch mal und geben die richtige E-Mail ein.');

define('SET_AS_DEFAULT_ADDRESS', 'Als Standardversandadresse Einstellen');
define('SET_AS_DEFAULT_ADDRESS_SUCCESS', 'Ihre Standardversandadresse ist erfolgreich erneuert eingestellt.');

define('ALERT_EMAIL', 'Geben Sie bitte Ihre Email-Adress ein. Danke!');
define('ENTER_PASSWORD_PROMPT' , 'Bitte Ihr Passwort eingeben.');
define('TEXT_CONFIRM_PASSWORD', 'Vergessen nicht, das Passwort wieder einzugeben!');
define('TEXT_CONFIRM_PASSWORD_PROMPT' , 'Bitte bestätigen noch mal Ihr Passwort.');
define('TEXT_ENTER_FIRESTNAME', 'Bitte geben Sie Ihren Vorname ein(Mindestens 1 Zeichen).');
define('TEXT_ENTER_LASTNAME', 'Bitte geben Sie Ihren Nachname ein(Mindestens 1 Zeichen).');
define('TEXT_EMAIL_NOTE','Bitte geben Sie Ihre E-Mail korrekt ein.');

define('TEXT_PROMOTION_DISCOUNT_NOTE','Ihr Bestellwert (exkl. Discount-Artikel) ist jetzt {TOTAL}. Sie können {NEXT} Bestellrabatt genießen, wenn Ihr Bestellwert (exkl. Discount-Artikel) ab {REACH}.');

define('TEXT_SMALL_PACK','Kleine Stückzahl');

define('TEXT_NDDBC_INFO_OUR_WEBSITE', 'Zurück auf unsere Website, bitte <a href="%s">klicken Sie hier >></a>');
define('TEXT_NDDBC_INFO_PREVIOUS_PAGE', 'Um zur vorherigen Seite zurückzukehren, klicken Sie <a href="%s">bitte hier</a>');
define('TEXT_NDDBC_INFO','<p class="STYLE1">Liebe Kunden,</p>
<p class="STYLE1">
Dank schön für Ihren Besuch bei unserer Webseite <br /><br />
Es kommt immer eine Fehlermeldung vor, dass die Seite immer auf eine unnormale Seite geblieben ist, wenn Sie die Seite browsen. <br />
Machen Sie sich darum keine Sorge; Ihre vorherige Informationen auf unserer Webseite wurde schon sehr gut gespeichert.
<br /><br />

<strong>%s</strong><br /><br />
Wenn Sie während Ihres Besuches schon die Seite gesehen haben, mailen Sie bitte uns unter:<a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a><br />

Vielen Dank für Ihr freundliches Verständnis & Entschuldigen Sie bitte jede Unannehmlichkeit.<br /><br />

Mit besten Grüßen <br />
Doreenbeads Team
</div>');

define('TEXT_LOG_OFF','Abmelden');
define('TEXT_TO_VIEW', 'Sehen nach &gt;&gt;'); 

define('TEXT_CUSTOM_NO','Kundennummer');
define('ENTRY_TARIFF_REQUIRED_TEXT' , 'Falls Sie EORI Nummer haben, bitte schreiben Sie Ihre EORI Nummer auf.Es hilft Zollabfertigung.');
define('ENTRY_BACKUP_EMAIL_REQUESTED_TEXT' , 'Bitte füllen Sie Ihre gängige E-Mail-Adresse aus. Daher können wir Sie rechtzeitig erreichen.');

define('TEXT_EMAIL_HAS_SUBSCRIBED','Diese E-Mail-Adresse ist bereits abonniert.');

define('TEXT_ENTER_BIRTHDAY_ERROR','Wählen Sie bitte Ihr Geburtsdatum.');
define('TEXT_BIRTHDAY_TIPS', 'Füllen Sie bitte Ihren Geburtstag aus, um am Geburtstag ein besonderes Geschenk zu bekommen.');
define('TEXT_ENTER_BIRTHDAY_OVER_DATE','Das Geburtsdatum kann nicht größer als das aktuelle Datum sein.');

define('ERROR_PRODUCT_PRODUCTS_BEEN_REMOVED','Es scheitert, den Artikel Ihrem Warenkorb hinzuzufügen. Der Artikel wurde von unserem Sortiment entfernt.');
define('KEYWORD_FORMAT_STRING', 'Schlüsselworte');
define('TEXT_DEAR_CUSTOMER_NAME', 'Kunde');

define('TEXT_CHANGED_YOUR_EMAIL_TITLE','Sie haben Ihre E-Mail-Adressedes doreenbeads-Kontos geändert');
define('TEXT_HANDINGFEE_INFO','Aufgrund der gestiegenen Arbeitskosten berechnen wir für einige Pakete eine Bearbeitungsgebühr von 0,99 USD. Nur wenn der Bestellwert weniger als 9,99 USD beträgt, ist die Bearbeitungsgebühr erforderlich.');
define('TEXT_CHANGED_YOUR_EMAIL_CONTENT','Hallo %s,<br/><br/>
Sie haben Ihre E-Mail-Adresse des doreenbeads-Kontos erfolgreich geändert.<br/><br/>

Ihre alte E-Mail-Adresse ist: %s<br/>
Ihre neue E-Mail-Adresse ist: %s<br/>
Aktualisierungszeit: %s<br/><br/>

Wenn Sie diese Änderungsanforderung nicht stellen, fühlen Sie bitte sich frei <a href="mailto:service_de@doreenbeads.com">uns zu kontaktieren</a>. <br/><br/>

Mit freundlichen Grüßen,<br/><br/>

Doreenbeads Team');

define('TEXT_SHIPPING_METHOD_DISPLAY_TIPS', 'Wir verstecken einige nicht oft verwendete Versandmethoden, <a id="show_all_shipping">Zeigen alle Versandmethoden >></a>');

define('TEXT_BUYER_PROTECTION','Käuferschutz');
define('TEXT_BUYER_PROTECTION_TIPS','<p>Volle Erstattung<span>(Wenn Sie Ihre Ware nicht erhalten)</span></p><p>Volle oder Teilerstattung<span>(Wenn die Ware defekt sind)</span></p>');
define('TEXT_FOOTER_ENTER_EMAIL_ADDRESS','Bitte geben Sie Ihre Emailadresse hier ein.');
define('TEXT_IMAGE','Image');
define('TEXT_DELETE', 'Löschen');
define('TEXT_PRODUCTS_NAME', 'Produktname');
define('TEXT_SHIPPING_RESTRICTION', 'Versandbeschränkung');
define('TEXT_SHIPPING_RESTRICTION_TIP', 'Für dieses Produkt ist einige bestimmte Versandmethoden verboten.');
define ( 'TEXT_PAYMENT_BANK_WESTERN_UNION', 'Unser Western Union Konto Info ' );

define('PROMOTION_DISPLAY_AREA' , 'Sale');
define('TEXT_SUBMIT_SUCCESS', 'Erfolgreich eingereicht!');
define('TEXT_API_LOGIN_CUSTOMER', 'Binden Sie Ihr bestehendes Konto.');
define('TEXT_API_REGISTE_NEW_ACCOUNT', 'Erstellen Sie Ihr doreenbeads Konto und verbinden Sie es mit %s');
define('TEXT_API_BIND_ACCOUNT', 'Wenn Sie bereits ein Doreenbeads-Konto haben, können Sie Ihr %s-Konto mit den Kontoinformationen binden.');
define('TEXT_API_REGISTER_ACCOUNT', 'Wenn Sie kein Doreenbeads-Konto haben, können Sie ein neues Konto erstellen und Ihr %s-Konto mit den Kontoinformationen binden.');

define ( 'TEXT_PAID','Bezahlt');
define('TEXT_SHIPPING_INVOECE_COMMENTS', 'Versand Bemerkungen');
define('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE', '<b>Wichtiger Hinweis: </b><br/>Aufgrund der Versandbeschränkung können einige Produkte in Ihrer Bestellung separat per Luftpost versandt werden, <a href="'.HTTP_SERVER.'/page.html?id=211" style="color:#008fed;" target="_blank">warum >></a>');

define('TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS', 'Dieser Rabattpreis wird nur auf %s Packungen beschränkt, sonst sollten Sie alle zum ursprünglichen Preis bezahlen.');

define('TEXT_TWO_REWARD_COUPONS', 'Zwei Gutscheine nur für Sie, USD 12 können eingespart werden');
define('TEXT_IN_ORDER_TO_THANKS_FOR_YOU', 'Vielen Dank für Ihre erste Bestellung bei uns. Wir haben Ihnen 2 Gutscheine auf Ihr Konto gesendet. <a href="' . zen_href_link(FILENAME_MY_COUPON) . '" target="_blank">Gutschein Anzeigen>></a>');
define('EMAIL_ORDER_TRACK_REMIND_NEW','Bitte prüfen Sie, ob es falsche Informationen gibt. Wenn Sie die Lieferadresse korrigieren möchten, schreiben Sie uns bitte eine E-Mail an <a href="mailto:service_de@doreenbeads.com">service_de@doreenbeads.com</a>, bevor wir Ihr Paket ausschicken.');
define('TEXT_HOPE_TO_DO_MORE_KIND_BUSINESS','Wir hoffen, dass wir mit Ihnen zu einer angenehmen Geschäftsverbindung kommen werden. Viel Glück~~<br/><br/>
Freundliche Grüße,<br/><br/>
Doreenbeads Team');
define('BOTTOM_VIP_POLICY','View <a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_HELP_CENTER,'&id=65') . '" >Rabatt Politik</a>');
define('IMAGE_NEW_CATEGORY', 'Neue Kategorie');
define('TEXT_COUPON_CODE','Couponcode');
define('TEXT_COUPON_PAR_VALUE','Nennwert');
define('TEXT_COUPON_MIN_ORDER','Mindestbetrag der Produkte');
define('TEXT_COUPON_DEADLINE','Frist (GMT+8)');
define('TEXT_DISPATCH_FROM_WAREHOUSE', 'Unser Lager verlassen');
define('TEXT_ALL', 'alle');
define('TEXT_DATE_ADDED','Datum hinzufügen');
define('TEXT_FILTER_BY', 'Filtern von');
define('TEXT_REGULAR_PACK','Normale Stückzahl');
define('TEXT_SMALL_PACK','Kleine Stückzahl');
define('TEXT_VIEW_ONLY_SALE_ITEMS', 'Sale-Artikel Anzeigen');
define('TEXT_EMAIL_REG_TIP', 'Das Format der E-Mail-Adresse ist falsch. Bitte geben Sie die richtige E-Mail-Adresse ein.');
define('TEXT_DELETE', 'Löschen');
define('TEXT_NO_UNREAD_MESSAGE', 'Es gibt keine ungelesene Nachricht.');
define('TEXT_SETTINGS', 'Einstellung');
define('TEXT_SEE_ALL_MESSAGES', 'Alle Nachrichten');
define('TEXT_TITLE', 'Titel');
define('TEXT_MESSAGE', 'Nachricht');
define('TEXT_MY_MESSAGE', 'Meine Nachrichten');
define('TEXT_MESSAGE_SETTING', 'Nachrichteneinstellung');
define('TEXT_ALL_MARKED_AS_READ', 'Alle als gelesen markieren');
define('TEXT_DELETE_ALL', 'Alle löschen');
define('TEXT_UNREAD_MESSAGE', 'Ungelesene Nachrichten');
define('TEXT_MARKED_AS_READ', 'Als gelesen markieren');
define('TEXT_RECEIVE_ALL_MESSAGES', 'Alle Nachrichten empfangen');
define('TEXT_RECEIVE_THE_SPECIFIED', 'Angegebenen Nachrichtentyp empfangen');
define('TEXT_REJECT_ALL_MESSAGES', 'Alle Nachrichten ablehnen');
define('TEXT_PLEASE_CHOOSE_AT_LEAST_MESSAGE', 'Bitte wählen Sie mindestens eine Art von Nachricht.');
define('TEXT_YOU_WILL_NO_LONGER_MESSAGE', 'Sie werden nicht mehr alle unsere Nachrichten erhalten, sind Sie sicher?');
define('TEXT_ON_SALE', 'Im Sale');
define('TEXT_IN_STOCK', 'Auf Lager');
define('BY_CREATING_AGREEN_TO_TEAMS_AND_CONDITIONS', 'Durch das Erstellen eines Kontos stimmen <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Sie den Geschäftsbedingungen</a> von Doreenbeads.com zu.');
define('TEXT_SHIPPING_FROM_USA', 'Ship From USA');
define('TEXT_CHECK_URL','Der von Ihnen eingegebene Inhalt enthält illegale Links. Bitte korrigieren Sie es.');
?>