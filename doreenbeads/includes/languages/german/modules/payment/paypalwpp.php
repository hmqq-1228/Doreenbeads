<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: paypalwpp.php 7218 2007-10-08 04:51:45Z drbyte $
 */

  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_EC', 'PayPal Express Abrechnen');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_WPP', 'PayPal Express Abrechnen (WPP)');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PRO20', 'PayPal Express Abrechnen (Pro 2.0 Payflow Edition) (UK)');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_EC', 'PayPal Payflow Pro - Gateway');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_GATEWAY', 'PayPal Express Abrechnen durch Payflow Pro');

  if (IS_ADMIN_FLAG === true) {
    define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_DESCRIPTION', '<strong>PayPal Express Abrechnen</strong>%s<br />' . (substr(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE,0,7) == 'Payflow' ? '<a href="https://manager.paypal.com/loginPage.do?partner=ZenCart" target="_blank">Ihr PayPal-Konto verwalten</a>' : '<a href="http://www.zen-cart.com/partners/paypal" target="_blank">Ihr PayPal Konto verwalten.</a>') . '<br /><br /><font color="green">Konfigurationsanweisungen:</font><br /><span class="alert">1. </span><a href="http://www.zen-cart.com/partners/paypal" target="_blank">Melden Sie sich für Ihr PayPal-Konto - hier klicken.</a><br />' . 
(defined('MODULE_PAYMENT_PAYPALWPP_STATUS') ? '' : '... und klicken Sie auf "Installieren", um PayPal Express Abrechnung zu aktivieren.</br>') . 
(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'PayPal' && (!defined('MODULE_PAYMENT_PAYPALWPP_APISIGNATURE') || MODULE_PAYMENT_PAYPALWPP_APISIGNATURE == '') ? '<span class="alert">2. </span><strong>API-Zeugnisse</strong> aus der API-Anmeldeinformationen in Ihrem PayPal-Profil Einstellungensbereich. Dieses Modul nutzt die <strong>API Unterschrift</strong> Option -- Sie müssen den Benutzernamen, Passwort und Unterschrift im folgenden Felder eingeben.' : (substr(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE,0,7) == 'Payflow' && (!defined('MODULE_PAYMENT_PAYPALWPP_PFUSER') || MODULE_PAYMENT_PAYPALWPP_PFUSER == '') ? '<span class="alert">2. </span><strong>PAYFLOW Anmeldedaten</strong> Dieses Modul benoetigt Ihre <strong>PayFlow Partner + Hersteller + + User-Passwort-Einstellungen</strong>,in den 4 Feldern einzugeben. Sie werden verwendet, um das Payflow System zu kommunizieren und Transaktionen Ihr Kontos zu autorisieren.' : '<span class="alert">2. </span>Stellen Sie sicher, dass Sie die entsprechende Sicherheitsdaten Nutzername / Passwort usw. unten eingegeben haben.') ) . 
(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'PayPal' ? '<br /><span class="alert">3. </span>Auf Ihrem PayPal-Konto bitte aktivieren Sie <strong>Sofortige Zahlungsbestätigung</strong>:<br />unter "Profil", und wählen Sie <em>Sofortige Zahlungsbestätigung Einstellungen</em><ul style="margin-top: 0.5;"><li>klicken Sie auf das Kontrollkästchen, um die PIN Nummer zu aktivieren.</li><li>Wenn es keine angegebene URL, stellen Sie die URL:<br />'.str_replace('index.php?main_page=index','ipn_main_handler.php',zen_catalog_href_link(FILENAME_DEFAULT, '', 'SSL')) . '</li></ul>' : '') . 
'<font color="green"><hr /><strong>Anforderungen:</strong></font><br /><hr />*<strong>CURL</strong> wird zur bidirektionalen Kommunikation mit dem Gateway verwendet, deswegen muss es auf Ihrem Hosting-Server aktiv sein (wenn Sie einen Proxy-CURL verwenden müssen, setzen Sie die CURL Proxy-Einstellungen unter Administration->Konfiguration->Mein Shop.)<br /><hr />' );
  }

  define('MODULE_PAYMENT_PAYPALWPP_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_TITLE', 'Kreditkarte');
  define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TITLE', 'PayPal');
  define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TYPE', 'PayPal Express Abrechnen');
  define('MODULE_PAYMENT_PAYPALWPP_DP_TEXT_TYPE', 'PayPal Direktzahlung');
  define('MODULE_PAYMENT_PAYPALWPP_PF_TEXT_TYPE', 'Kreditkarte');  //(used for payflow transactions)
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_HEADING', 'Es tut uns leid! Wir können Ihre Kreditkarte nicht bearbeiten.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CARD_ERROR', 'Die eingegebene Kreditkarteninformationen enthält einen Fehler. Bitte überprüfen Sie es und versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_FIRSTNAME', 'Kreditkarte Vorname:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_LASTNAME', 'Kreditkarte Nachname:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_OWNER', 'Name des Karteninhabers:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_TYPE', 'Kreditkartentyp:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_NUMBER', 'Kreditkartennummer:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_EXPIRES', 'Kreditkarte Ablaufdatum:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_ISSUE', 'Kreditkarte Ausgabetag:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER', 'CVV Nummer:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(auf der Rückseite der Kreditkarte)');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_DECLINED', 'Ihre Kreditkarte wurde abgelehnt. Bitte versuchen Sie eine andere Karte oder kontaktieren Sie Ihre Bank für weitere Informationen.');
  define('MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE', 'Wir können Ihren Auftrag nicht bearbeiten. Bitte versuchen Sie es erneut, wählen Sie eine andere Zahlungsart oder kontaktieren Sie den Shop-Besitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_ERROR', 'Ein Fehler ist aufgetreten, als wir versuchten, den Zahlung Prozessor zu kontaktieren. Bitte versuchen Sie es erneut, wählen Sie eine andere Zahlungsart oder kontaktieren Sie den Shop-Besitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_MESSAGE', 'Sehr geehrter Shopbetreiber,' . "\n" . 'Beim Versuch, ein PayPal-Express-Kaufabwicklung Transaktion einzuleiten, ist ein Fehler aufgetreten. Als unverbindliches Service wurden Ihre Kunden nur den Fehler "Anzahl" gezeigt.  Die Details der Fehler finden Sie unten.' . "\n\n");
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_SUBJECT', 'WARNUNG: PayPal Express Abrechnungsfehler');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR', 'Die eingegebene Adressinformationen sind nicht gültig, oder können nicht zugeordnet werden. Bitte wählen Sie oder fügen Sie eine andere Adresse ein, dann versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CONFIRMEDADDR_ERROR', 'Die von Ihnen gewählte Adresse ist bei PayPal keine bestätigte Adresse. Bitte gehen Sie zur PayPal zurück, wählen Sie oder fügen Sie eine bestätigte Adresse ein, und dann versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'PayPal konnte diese Transaktion nicht erfolglich bearbeiten. Bitte wählen Sie eine andere Zahlungsart oder überprüfen Sie die Fördermöglichkeiten in Ihrem PayPal-Konto bevor Sie fortfahren.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ERROR', 'Ein Fehler ist aufgetreten, als wir versuchten, Ihre Kreditkarte zu bearbeiten. Bitte versuchen Sie es erneut, wählen Sie eine andere Zahlungsart oder kontaktieren Sie den Shop-Besitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_CARD', 'Wir entschuldigen uns für die Unannehmlichkeiten. Die von Ihnen eingegebene Kreditkarte konnte von uns nicht akzeptieren. Bitte versuchen Sie eine andere Kreditkarte.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_LOGIN', 'Es gab ein Problem bei der Validierung von Ihrem Konto. Bitte versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_OWNER', '* Name des Karteninhabers muss mindestens ' . CC_OWNER_MIN_LENGTH . ' Charaktere sein.\n');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_NUMBER', '* Die Kreditkartennummer muss mindestens ' . CC_NUMBER_MIN_LENGTH . ' characters sein.\n');
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVS_FAILURE_TEXT', 'WARNUNG: Adressüberprüfung Failure. ');
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_CVV_FAILURE_TEXT', 'WARNUNG: Karten CVV-Code Überprüfung Fehler. ');
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVSCVV_PROBLEM_TEXT', ' Ihre Bestellung ist bei der Überprüfung vom Shop-Besitzer.');
  
  define('MODULE_PAYMENT_PAYPALWPP_RISK_CUSTOMER', 'Ihre Karte entspricht nicht der Risikokontrollpolitik, die Zahlung ist fehlgeschlagen. Wählen Sie bitte eine andere Zahlungsweise. Für weitere Informationen bitte wenden Sie sich an den Paypal-Kundendienst oder Ihre ausstellende Bank.');
  
  define('MODULE_PAYMENT_PAYPALWPP_NOT_MONEY', 'Ihr Konto ist unterfinanziert. Wählen Sie bitte eine andere Zahlungsweise. Für weitere Informationen bitte wenden Sie sich an den Paypal-Kundendienst oder Ihre ausstellende Bank.');
  
  define('MODULE_PAYMENT_PAYPALWPP_PALPAYERID_NULL', 'Die Übertragung der Express-Checkout-PayerID ist fehlgeschlagen, bitte versuchen Sie erneut, die Zahlung zu leisten.');
  
  define('MODULE_PAYMENT_PAYPALWPP_NOT_PAYPALMENT', 'Ihre Karte ist abgelaufen/hat kein ausreichendes Guthaben, bitte ändern Sie die Zahlungsmethode. Für weitere Informationen bitte wenden Sie sich an den Paypal-Kundendienst oder Ihre ausstellende Bank.');
  
  define('MODULE_PAYMENT_PAYPALWPP_TOTAL_ZERO', 'Aufgrund eines Datenübertragungsproblems ist Ihre Zahlung fehlgeschlagen, bitte versuchen Sie erneut, die Zahlung zu leisten.');
  
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR_FOR_SHIPPING_ADDRESS', 'Ihre Postanschrift ist falsch. Bitte überprüfen Sie, ob das Land, der Ort, die Postleitzahl usw. in Ihrer Postanschrift übereinstimmen.');
  
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_EC_HEADER', 'Schnelles, sicheres Abrechnen mit PayPal:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_STATE_ERROR', 'Der von Ihnen gegebenen Staat ist ungültig.  Bitte ändern Sie den in Ihrer Account-Einstellungen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten. Die Zahlung konnte nicht eingeleitet werden, weil das von dem Ladenbesitzer konfigurierte PayPal-Konto kein PayPal Websitezahlungen Pro-Account ist, oder Gateway Services noch nicht gekauft wurden.  Bitte wählen Sie eine andere Zahlungsart für Ihre Bestellung.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_SANDBOX_VS_LIVE_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten. Die Authentifizierungseinstellungen des PayPal-Kontos wurde noch nicht eingerichtet, oder die API-Sicherheits-Informationen waren falsch. Wir können Ihre Transaktion nicht abschließen. Bitte teilen Sie den Shop-Besitzer mit, so dass er dieses Problem lösen kann.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_WPP_BAD_COUNTRY_ERROR', 'Es tut uns Leid -- das von dem Shop-Administrator konfigurierte PayPal-Konto ist in einem Land, das nicht für die Website Payments Pro derzeit unterstützt wird. Bitte wählen Sie eine andere Zahlungsart, um Ihre Bestellung abzuschließen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(NOTE: Modul ist noch nicht konfiguriert)</span>');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_GETDETAILS_ERROR', 'Es gab ein Problem beim Abrufen der Transaktionsdetails. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_TRANSSEARCH_ERROR', 'Es gab ein Problem bei der Lokalisierung von Transaktionen, die die von Ihnen angegebene Kriterien entsprechen. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_ERROR', 'Es gab ein Problem: eine ungültige Transaktion. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_ERROR', 'Es gab ein Problem bei der Rückerstattung des angegebenen Transaktionsbetrags. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_ERROR', 'Es gab ein Problem bei der Ermächtigung der Transaktion. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_ERROR', 'Es gab ein Problem bei der Transaktionserfassung. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUNDFULL_ERROR', 'Ihre Rückerstattung-Antrag wurde von PayPal abgelehnt.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_REFUND_AMOUNT', 'Sie haben eine teilweise Rückerstattung beantragt, aber keinen Betrag angeben.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_ERROR', 'Sie haben eine volle Rückerstattung beantragt, aber das Kontrollkästchen nicht zum Überprüfen bestätigt.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_AUTH_AMOUNT', 'Sie haben eine Ermächtigung beantragte, aber keinen Betrag angegeben.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_CAPTURE_AMOUNT', 'Sie eine Capture beantragt, aber keinen Betrag angegeben.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', 'Bestätigen');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_ERROR', 'Sie versuchte eine Transaktion zu stornieren, aber das Kontrollkästchen nicht zum Überprüfen bestätigt.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', 'Bestätigen');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_CONFIRM_ERROR', 'Sie haben eine Ermächtigung beantragte, aber das Kontrollkästchen nicht zum Überprüfen bestätigt.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', 'Sie haben ein Fonds-Capture beantragt, aber das Kontrollkästchen nicht zum Überprüfen bestätigt.');

  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_INITIATED', 'PayPal Rückerstattung für % s eingeleitet. Transaktion ID: %s. Aktualisieren Sie das Fenster, um aktualisierte Bestätigung Informationen über Bestellungsübersicht Status / Kommentare zu sehen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_INITIATED', 'PayPal Ermächtigung für% s eingeleitet. Aktualisieren Sie das Fenster, um aktualisierte Bestätigung Informationen über Bestellungsübersicht Status / Kommentare zu sehen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_INITIATED', 'PayPal Capture von % s gestartet. Receipt ID: %s. Aktualisieren Sie das Fenster, um aktualisierte Bestätigung Informationen über Bestellungsübersicht Status / Kommentare zu sehen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_INITIATED', 'PayPal ungültige Anfrage eingegeben. Transaction ID: %s. Aktualisieren Sie das Fenster, um aktualisierte Bestätigung Informationen über Bestellungsübersicht Status / Kommentare zu sehen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_API_ERROR', 'Es gab einen Fehler beim Versuchen von der Transaktion. Bitte beachten Sie die API Reference Anleitung oder Transaktionsprotokolle für detaillierte Informationen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_ZONE_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten. Derzeit können wir die Paypal Aufträge von der geographischen Region nicht bearbeiten, die Sie als Ihre PayPal-Adresse ausgewählt haben.  Bitte verwenden Sie normale Abrechnung weiter und eine der verfügbaren Zahlungsarten auswählen, um Ihre Bestellung abzuschließen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ORDER_ALREADY_PLACED_ERROR', 'Ihre Bestellung wurde zweimal vorgelegen. Bitte überprüfen Sie die tatsächliche Details bei Mein Konto.  Bitte wählen Sie das Kontakt Formular wenn Sie Ihre Bestellung hier nicht finden können und das bereits durch Ihr PayPal Konto bezahlt haben, damit wir die Unterlagen überprüfen und eine Lösung für Ihnen finden können.');

  //define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', 'Checkout with PayPal. The safer, easier way to pay.');
  //jessa 2010-04-29 �޸�paypal�����������ʾ��˵������
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', 'Sichere Bezahlung. <br /><div style="clear:both; padding-bottom:10px;">Bezahlen Sie bitte mit Kreditkarte über PayPal. Wenn Sie <strong>kein PayPal Konto</strong>haben, gilt die Bezahlung auch. <a href="https://www.doreenbeads.com/index.php?main_page=page&id=44" alt="https://www.doreenbeads.com/index.php?main_page=page&id=44" target="_blank">Klicken Sie für Details>></a></div>');
  //eof jessa 2010-04-29
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_ALTTEXT', 'Klicken Sie hier und zahlen Sie mit PayPal Express Checkout');

// EC buttons -- Do not change these values:
  define('MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_IMG', 'includes/templates/cherry_zen/buttons/english/btn_xpressCheckout.gif');
  define('MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_SM_IMG', 'https://www.paypal.com/en_US/i/btn/btn_xpressCheckoutsm.gif');
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', 'https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif');

////////////////////////////////////////
// Styling of the PayPal Payment Page. Uncomment to customize.  Otherwise, simply create a Custom Page Style at PayPal and mark it as Primary or name it in your Zen Cart PayPal WPP settings.
  //define('MODULE_PAYMENT_PAYPALWPP_HEADER_IMAGE', '');  // this should be an HTTPS URL to the image file
  //define('MODULE_PAYMENT_PAYPALWPP_PAGECOLOR', '');  // 6-digit hex value
  //define('MODULE_PAYMENT_PAYPALWPP_HEADER_BORDER_COLOR', '');  // 6-digit hex value
  //define('MODULE_PAYMENT_PAYPALWPP_HEADER_BACK_COLOR', ''); // 6-digit hex value
////////////////////////////////////////


  // These are used for displaying raw transaction details in the Admin area:
  define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Vorname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Nachname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Firmenname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Adresse:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Straße:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Stadt:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Bundesland:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'PLZ:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'Staat:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'Zahler Email:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'Ebay ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'Zahler ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Zahler Stand:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Adresse Stand:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Zahlungsart:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Zahlungsstatus:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Pending Reason:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Rechnung:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Zahlungsdatum:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Währung:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Bruttobetrag:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Zahlungsgebühr:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Wechselkurs:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Warenkorb Produkt:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Art der Transaktion:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'Transaktion ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'Übergeordnete Transaktion ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TITLE', '<strong>Bestellung Rückerstattungen</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_FULL', 'Wenn Sie diesen Auftrag vollständig zurückerstatten möchten, klicken Sie bitte hier:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_FULL', 'Volle Rückerstattung beantragen');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_PARTIAL', 'Teilweise Rückerstattung beantragen');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_FULL_OR', '<br />... oder geben Sie den Teil ');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PAYFLOW_TEXT', 'Geben Sie den ');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PARTIAL_TEXT', 'Rückerstattung Betrag hier und klicken Sie auf teilweise Rückerstattung');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_SUFFIX', '*Eine volle Rückerstattung wird nicht bearbeitet, nachdem eine teilweise Rückerstattung beantragt wird.<br />*Mehrere Teilerstattungen sind bis zu den verbleibenden Bilanz erlaubt.');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Wurde vom Shop-Administrator zurückerstattet.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_CHECK','Bestätigen: ');


  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_TITLE', '<strong>Bestellung Autorisierungen</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_PARTIAL_TEXT', 'Wenn Sie einen Teil dieses Auftrags bevollmächtigen möchten, geben Sie den Betrag hier:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_BUTTON_TEXT_PARTIAL', 'Autorisierung bestätigen');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_SUFFIX', '');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Wurde vom Shop-Administrator zurückerstattet.');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TITLE', '<strong>Autorisierungen Erfassung</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FULL', 'Wenn Sie alle oder einen Teil des ausstehenden zugelassenen Betrags für diesen Auftrag erfassen möchten, geben Sie den Betrag und bestätigen Sie, ob der der Endbetrag dieser Bestellung ist.  Prüfen Sie bitte die Eingabe bevor Sie Ihre Anfrage bestätigen.<br />');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_BUTTON_TEXT_FULL', 'Erfassen');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_AMOUNT_TEXT', 'Betrag zum erfassen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FINAL_TEXT', 'Ist der ein Endbetrag?');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_SUFFIX', '');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'Vielen Dank für Ihre Bestellung.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_CHECK','Bestätigen: ');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TITLE', '<strong>Bestellung Autorisierungen entwerten</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID', 'Wenn Sie eine Autorisierung entwerten möchten, geben Sie bitte Ihr Autorisierung ID hier und bestätigen Sie es:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_DEFAULT_MESSAGE', 'Vielen Dank für Ihr Besuch. Wir freuen uns auf Ihr nächstem Besuch!');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', 'Entwerten');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', '');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'Transaktionstatus:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', 'Autorisierungscode:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'AVS Adresse übereinstimmen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'AVS PLZ übereinstimmen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'CVV2 übereinstimmen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', 'Dauerzeit zum Bearbeiten:');

// this text is used to announce the username/password when the module creates the customer account and emails data to them:
  define('EMAIL_EC_ACCOUNT_INFORMATION', 'Unten finden Sie Ihre Login-Daten, die Sie zur Überprüfung Ihres Auftrags benutzen können:');



?>