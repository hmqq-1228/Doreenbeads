<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: paypaldp.php 7334 2007-10-31 11:58:58Z drbyte $
 */

  define('MODULE_PAYMENT_PAYPALDP_TEXT_ADMIN_TITLE_WPP', 'PayPal Website Payments Pro');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_ADMIN_TITLE_PRO20', 'PayPal Website Payments Pro Payflow Edition (UK)');

  if (IS_ADMIN_FLAG === true) {
    define('MODULE_PAYMENT_PAYPALDP_TEXT_ADMIN_DESCRIPTION', '<strong>PayPal Website Payments Pro</strong>%s<br />' . '<a href="http://www.zen-cart.com/partners/paypal" target="_blank">Verwalten Ihr PayPal Konto.</a>' . '<br /><br /><font color="green">Konfigurationsanweisungen:</font><br /><span class="alert">1. </span><a href="http://www.zen-cart.com/partners/paypal" target="_blank">Melden Sie sich für Ihr PayPal-Konto - hier klicken.</a><br />' . 
(defined('MODULE_PAYMENT_PAYPALDP_STATUS') ? '' : '... und klicken Sie auf "Installieren", um PayPal Express Checkout-Unterstützung zu aktivieren.</br>') . 
(!defined('MODULE_PAYMENT_PAYPALWPP_APISIGNATURE') || MODULE_PAYMENT_PAYPALWPP_APISIGNATURE == '' ? '<span class="alert">2. </span><strong>API Zeugnisse</strong> aus der API-Anmeldeinformationen in Ihrem PayPal-Profil Einstellungensbereich. Dieses Modul nutzt die <strong>API Unterschrift</strong> Option -- Sie müssen den Benutzernamen, Passwort und Unterschrift im folgenden Felder eingeben.' : '<span class="alert">2. </span>Stellen Sie sicher, dass Sie die entsprechende Sicherheitsdaten Nutzername / Passwort usw. unten eingegeben haben.') .
'<font color="green"><hr /><strong>Anforderungen:</strong></font><br /><hr />*<strong>Express Checkout</strong> muss nach PayPal AGB zur Nutzung werdenWebsite Payments Pro installiert und aktiviert werden. <br /><hr />' );
  }

  define('MODULE_PAYMENT_PAYPALDP_TEXT_DESCRIPTION', 'Kreditkarte');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_TITLE', 'Kreditkarte');
  define('MODULE_PAYMENT_PAYPALDP_DP_TEXT_TYPE', 'Kreditkarte (WPP)');
  define('MODULE_PAYMENT_PAYPALDP_PF_TEXT_TYPE', 'Kreditkarte(PF)');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_HEADING', 'Es tut uns leid. Wir können Ihre Kreditkarte nicht verarbeiten.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CARD_ERROR', 'Die eingegebene Kreditkartendaten enthält einen Fehler. Bitte überprüfen Sie es und versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_FIRSTNAME', 'Vorname des Karteninhabers:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_LASTNAME', 'Nachname des Karteninhabers:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_OWNER', 'Name des Karteninhabers:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_TYPE', 'Kartentyp:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_NUMBER', 'Kartenummer:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_EXPIRES', 'Kartenablaufdatum:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_ISSUE', 'Karte Ausgabetag:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_MAESTRO_ISSUENUMBER', 'Maestro Ausgabe Nr.:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_CHECKNUMBER', 'CVV Nummer:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(auf der Rückseite der Kreditkarte)');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_DECLINED', 'Ihre Kreditkarte wurde abgelehnt. Bitte versuchen Sie eine andere Karte oder kontaktieren Sie Ihre Bank für weitere Informationen.');
  define('MODULE_PAYMENT_PAYPALDP_CANNOT_BE_COMPLETED', 'Wir könnten Ihren Auftrag nicht verarbeiten.Bitte wählen Sie eine alternative Zahlungsmethode, oder kontaktieren Sie die Ladenbesitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALDP_INVALID_RESPONSE', 'Wir könnten Ihren Auftrag nicht verarbeiten.Bitte wählen Sie eine alternative Zahlungsmethode, oder kontaktieren Sie die Ladenbesitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_GEN_ERROR', 'Ein Fehler ist aufgetreten, als wir versuchten, die Zahlung Prozessor zu kontaktieren. Bitte versuchen Sie nochmal, wählen Sie eine alternative Zahlungsmethode, oder kontaktieren Sie die Ladenbesitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_EMAIL_ERROR_MESSAGE', 'Sehr geehrter Shopbetreiber,' . "\n" . 'Ein Fehler ist aufgetreten, wenn wir versuchen, die Zahlung Validierung Transaktion einzuleiten. Als unverbindlichen Service wurden Ihren Kunden nur der Fehler "Anzahl" gezeigt.  Die Einzelheiten der Fehler sind unten dargestellt.' . "\n\n");
  define('MODULE_PAYMENT_PAYPALDP_TEXT_EMAIL_ERROR_SUBJECT', 'ALERT: PayPal Direktzahlung Fehler');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_ADDR_ERROR', 'Die eingegebene Adresse Informationen scheint nicht gültig zu sein, oder kann nicht zugeordnet werden. Bitte wählen Sie oder fügen Sie eine andere Adresse ein und versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'PayPal war nicht in der Lage, diese Transaktion erfolgreich finden. Bitte wählen Sie eine andere Zahlungsart oder überprüfen Sie die Fördermöglichkeiten in Ihrem PayPal-Konto bevor Sie fortfahren.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_ERROR', 'Ein Fehler ist aufgetreten, als wir versuchten, Ihre Kreditkarte zu verarbeiten. Bitte versuchen Sie nochmal, wählen Sie eine alternative Zahlungsmethode, oder kontaktieren Sie die Ladenbesitzer um Hilfe.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_BAD_CARD', 'Wir entschuldigen uns für die Unannehmlichkeiten, aber die von Ihnen eingegebene Kreditkarte kann nicht von uns akzeptiert werden. Bitte versuchen Sie eine andere Kreditkarte oder überprüfen Sie, ob die eingegebenen Daten korrekt sind, oder kontaktieren Sie die Shopbetreiber um Hilfe.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_BAD_LOGIN', 'Es gab ein Problem bei der Validierung von Ihrem Konto. Bitte versuchen Sie es erneut.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_JS_CC_OWNER', '* Name des Karteninhabers muss mindestens ' . CC_OWNER_MIN_LENGTH . ' Charaktere sein.\n');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_JS_CC_NUMBER', '* Die Kreditkartennummer muss mindestens ' . CC_NUMBER_MIN_LENGTH . ' Charaktere sein.\n');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_JS_CC_CVV', '* Die 3 oder 4-stellige CVV-Nummer finden Sie auf der Rückseite der Kreditkarte.\n');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_AVS_FAILURE_TEXT', 'WARNUNG: Adressüberprüfung Fehler. ');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_CVV_FAILURE_TEXT', 'WARNUNG: CVV-Code Überprüfung Fehler. ');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_AVSCVV_PROBLEM_TEXT', ' Bestellung ist Bei der Überprüfung vom Shop-Besitzer.');

  define('MODULE_PAYMENT_PAYPALDP_TEXT_STATE_ERROR', 'Der auf Ihr Konto zugeordnete Staat ist ungültig.  Bitte ändern Sie den in Ihrer Account-Einstellungen.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten. Die Zahlung konnte nicht durchgeführt werden, weil das PayPal-Konto, das von dem Ladenbesitzer konfiguriert, ist kein PayPal Website Payments Pro Konto oder PayPal-Gateway-Dienste wurden noch nicht gekauft. Bitte wählen Sie eine alternative Zahlungsart für Ihre Bestellung.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_US_WPP_ACCOUNT_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten.  Die Zahlung konnte nicht durchgeführt werden, weil das PayPal-Konto, das von dem Ladenbesitzer konfiguriert, ist kein PayPal Website Payments Pro Konto oder PayPal-Gateway-Dienste wurden noch nicht gekauft. Bitte wählen Sie eine alternative Zahlungsart für Ihre Bestellung.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_UKWPP_ACCOUNT_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten.  Die Zahlung konnte nicht durchgeführt werden, weil das PayPal-Konto, das von dem Ladenbesitzer konfiguriert, ist kein PayPal Website Payments Pro Konto oder PayPal-Gateway-Dienste wurden noch nicht gekauft. Bitte wählen Sie eine alternative Zahlungsart für Ihre Bestellung.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_SANDBOX_VS_LIVE_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten. Die Authentifizierungseinstellungen des PayPal-Kontos wurde noch nicht eingerichtet, oder die API-Sicherheits-Informationen waren falsch. Wir konnten die Transaktion nicht abschließen. Bitte informieren Sie den Shopbetreiber, so dass er dieses Problem lösen kann.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_WPP_BAD_COUNTRY_ERROR', 'Es tut uns Leid -- das PayPal-Konto, das von dem Shop-Administrator konfiguriert wird, ist in einem Land, das die Website Payments Pro derzeit nicht erlaubt. Bitte wählen Sie eine andere Zahlungsart, um Ihre Bestellung abzuschließen.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(NOTE: Modul ist noch nicht konfiguriert)</span>');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_GETDETAILS_ERROR', 'Es gab ein Problem beim Transaktionsdetails Abrufen. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_TRANSSEARCH_ERROR', 'Es gab ein Problem bei der Lokalisierung der Transaktionen, die die von Ihnen angegebenen Kriterien entsprechen. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_VOID_ERROR', 'Es gab ein Problem: Transaktion ungültig. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUND_ERROR', 'Es gab ein Problem ber der Erstattung des angegebenen Transaktionswertes. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_AUTH_ERROR', 'Es gab ein Problem bei der Transaktion Autorisierung. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPT_ERROR', 'Es gab ein Problem bei der Transaktion Erfassung. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUNDFULL_ERROR', 'Ihr Rückerstattung-Antrag wurde von PayPal abgelehnt.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_REFUND_AMOUNT', 'Sie haben eine Rückerstattung beantragt, aber keinen Betrag angegeben.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUND_FULL_CONFIRM_ERROR', 'Sie haben eine volle Rückerstattung gefordert, aber das Kontrollkästchen nicht bestätigt, um Ihre Absicht überzuprüfen.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_AUTH_AMOUNT', 'Sie haben eine Ermächtigung beantragt, aber keinen Betrag angegeben.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_CAPTURE_AMOUNT', 'Sie haben eine Erfassung beantragt, aber keinen Betrag angegeben.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', 'Bestätigen');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_VOID_CONFIRM_ERROR', 'Sie haben beantragt, eine Transaktion zu stornieren, aber das Kontrollkästchen nicht bestätigt, um Ihre Absicht überzuprüfen.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', 'Bestätigen');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_AUTH_CONFIRM_ERROR', 'Sie haben eine Ermächtigung beantragt, aber das Kontrollkästchen nicht bestätigt, um Ihre Absicht überzuprüfen.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', 'Sie haben Fonds-Aufnahme angefordert, aber das Kontrollkästchen nicht bestätigt, um Ihre Absicht überzuprüfen.');

  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUND_INITIATED', 'PayPal Rückerstattung für% s durchgeführt. Transaktion ID: %s. Aktualisieren Sie das Fenster, um Bestätigungsdetails, die in den Status der Bestellung Geschichte / Kommentare Abschnitt aktualisiert werden, zu sehen.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_AUTH_INITIATED', 'PayPal Berechtigung für% s gestartet. Aktualisieren Sie das Fenster, um Bestätigungsdetails, die in den Status der Bestellung Geschichte / Kommentare Abschnitt aktualisiert werden, zu sehen..');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPT_INITIATED', 'PayPal Aufnahme% s gestartet. Erhalt ID: %s. Aktualisieren Sie das Fenster, um Bestätigungsdetails, die in den Status der Bestellung Geschichte / Kommentare Abschnitt aktualisiert werden, zu sehen..');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_VOID_INITIATED', 'PayPal ungültige Anfrage durchgeführt. Transaction ID: %s. Aktualisieren Sie das Fenster, um Bestätigungsdetails, die in den Status der Bestellung Geschichte / Kommentare Abschnitt aktualisiert werden, zu sehen..');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_GEN_API_ERROR', 'Es gab einen Fehler bei der Transaktionsversuchung. Bitte beachten Sie die API Reference Anleitung oder Transaktionsprotokolle für die detaillierte Informationen.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_ZONE_ERROR', 'Wir entschuldigen uns für die Unannehmlichkeiten; aber zur Zeit können wir nicht, diese Methode zu akzeptieren, um Aufträge von der geographischen Region, die Sie als Ihre Konto-Adresse gewählt haben, zu verarbeiten. Bitte fahren Sie mit normaler Kasse fort und wählen Sie eine der verfügbaren Zahlungsarten aus, um Ihre Bestellung abzuschließen.');


  // These are used for displaying raw transaction details in the Admin area:
  define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Vorname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Nachname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Firmenname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Adresse:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Staße:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Stadt:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Bundesland:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'BLZ:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'Ihr Land:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'Ihr Email:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'Ebay ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'Zahler ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Zahler-Status:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Adresse Status:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Zahlungsart:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Zahlungsstatus:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Pending Reason:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Rechnung:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Zahlungsdatum:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Währung:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Bruttobetrag:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Zahlungsgebühr:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Wechselkurs:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Produkte im Warenkorb:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Art der Transaktion:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'Transaktion ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'Verwandte Trans. ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TITLE', '<strong>Bestellung Rückerstattungen</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_FULL', 'Wenn Sie alle Auftrage zurückerstatten möchten, klicken Sie bitte hier:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_FULL', 'Alle zum Rückerstatten');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_PARTIAL', 'Teilweise Rückerstattung');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_FULL_OR', '<br />... oder geben Sie den Teil ');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PAYFLOW_TEXT', 'Geben Sie die');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PARTIAL_TEXT', 'Betrag hier erstatten und klicken Sie auf Teilweise Rückerstattung');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_SUFFIX', '*Eine volle Rückerstattung nicht möglich nach einer Teilweiser Rückerstattung ausgestellt werden.<br />*Multiple Partial refunds are permitted up to the remaining unrefunded balance.');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Von Shop-Administrator zurückerstattet.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_CHECK','Bestätigen: ');


  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_TITLE', '<strong>Bestellung Autorisierungen</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_PARTIAL_TEXT', 'Wenn Sie einen Teil dieses Auftrags bevollmächtigen möchten, geben Sie den Betrag hier:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_BUTTON_TEXT_PARTIAL', 'Authorization erlauben');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_SUFFIX', '');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Von Shop-Administrator zurückerstattet.');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TITLE', '<strong> Autorisierungen Erfassung</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FULL', 'Wenn Sie alle oder einen Teil der hervorragend zugelassenen Aufwandmenge für diesen Auftrag erfassen möchten, geben Sie bitte den AufnahmeBetrag und wählen Sie, ob es die letzte Erfassung dieser Bestellung ist. Überprüfen Sie das Bestätigungsfeld bevor Sie Ihre Aufnahmesanfrage absenden.<br />');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_BUTTON_TEXT_FULL', 'Aufnahme');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_AMOUNT_TEXT', 'Aufnahmesmenge:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FINAL_TEXT', 'Ist es die letzte Aufnahme?');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_SUFFIX', '');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TEXT_COMMENTS', '<strong>Note to display to customer:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'Thank you for your order.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPTURE_FULL_CONFIRM_CHECK','Confirm: ');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TITLE', '<strong>Voiding Order Authorizations</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID', 'If you wish to void an authorization, enter the authorization ID here, and confirm:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TEXT_COMMENTS', '<strong>Hinweis an den Kunden:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_DEFAULT_MESSAGE', 'Vielen Dank für Ihr Besuch. Bis bald!');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', 'Ungültig');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', '');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'Transaktionsstatus:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', 'Authorizationscode:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'AVS Adresse bestätigen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'AVS PLZ bestätigen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'CVV2 bestätigen:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', 'Abwicklungszeit:');




?>