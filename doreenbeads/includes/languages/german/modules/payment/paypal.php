<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: paypal.php 7219 2007-10-08 04:54:42Z drbyte $
 */

  define('MODULE_PAYMENT_PAYPAL_TEXT_ADMIN_TITLE', 'PayPal IPN - Website-Zahlungslösungen');
  define('MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_TITLE', 'PayPal');
  if (IS_ADMIN_FLAG === true) {
    define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal IPN</strong> (Basic PayPal service)<br /><a href="https://www.paypal.com/mrb/mrb=R-6C7952342H795591R&pal=9E82WJBKKGPLQ" target="_blank">Verwalten Sie Ihr PayPal-Konto.</a><br /><br /><font color="green">Konfigurationsanweisungen:</font><br />1. <a href="http://www.zen-cart.com/partners/paypal" target="_blank">Melden Sie sich Ihr PayPal-Konto - hier klicken.</a><br />2. Stellen Sie under "Profile",<ul><li>Ihre <strong>Sofortige Zahlungsbestätigung Einstellungen </strong> in Ihrem PayPal-Konto URL zu:<br />'.str_replace('index.php?main_page=index','ipn_main_handler.php',zen_catalog_href_link(FILENAME_DEFAULT, '', 'SSL')) . '<br />(Wenn eine andere URL bereits verwendet wird, können Sie es einfach lassen.)<br /><span class="alert">Stellen Sie sicher, dass das Checkbox, das IPN aktiviert, wird überprüft!</span></li><li>in <strong>Website-Zahlungseinstellungen</strong> Stellen Sie Ihr <strong>Automatische Rückgabe-URL</strong> zu:<br />'.zen_catalog_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL',false).'</li>' . (defined('MODULE_PAYMENT_PAYPAL_STATUS') ? '' : '<li>... und klicken Sie auf "Installieren", um PayPal-Unterstützung zu aktivieren ... und "Bearbeiten", um Zen Cart Ihre PayPal-Einstellungen mitzuteilen.</li>') . '</ul><font color="green"><hr /><strong>Anforderungen:</strong></font><br /><hr />*<strong>PayPal Konto</strong> (<a href="http://www.zen-cart.com/partners/paypal" target="_blank">klicken zum Anmelden</a>)<br />*<strong>*<strong>Der Port 80</strong> wird für die bidirektionale Kommunikation mit dem Gateway verwendet, deswegen muss er auf Ihrem Host-Router / Firewall geöffnet sein<br />*<strong>PHP allow_url_fopen</strong> muss aktiviert werden<br />*<strong>Einstellungen</strong> muss wie oben beschrieben konfiguriert werden.' );
  } else {
    define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
  }
  // to show the PayPal logo as the payment option name, use this:  https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif
  // to show CC icons with PayPal, use this instead:  https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', 'https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif');
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT', 'Mit PayPal bezahlen');
  define('MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT', 'Zeit sparen. Sicheres Zahlungsverlauf. <br /><div style="clear:both; padding-bottom:10px;">Zahlen Sie mit Kreditkarte über PayPal, auch wenn Sie <strong>kein PayPal Konto haben</strong>.<a href="https://www.doreenbeads.com/index.php?main_page=page&id=44" alt="https://www.doreenbeads.com/index.php?main_page=page&id=44" target="_blank">Für weitere Informationen klicken Sie bitte hier.>></a></div>');

  define('MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" /> &nbsp;' .  '' . MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT . '');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Vorname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Nachname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Firmenname:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Adresse:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Straße:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Stadt:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Bundesland:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'PLZ:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'Staat:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'Ihr Email:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'Ebay ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'Zahler ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Zahler-Status:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Adresse-Status:');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Zahlungsart:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Zahlungsstatus:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Übersetzt wird:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Rechnung:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Zahlungsdatum:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Währung:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Bruttobetrag:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Zahlungsgebühr:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Wechselkurs:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Produkt im Warenkorb:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Transaktionsart:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'Transaktion ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'Verwandte Transaktionsart:');


  define('MODULE_PAYMENT_PAYPAL_PURCHASE_DESCRIPTION_TITLE', STORE_NAME . ' Kauf');
  define('MODULE_PAYMENT_PAYPAL_PURCHASE_DESCRIPTION_ITEMNUM', 'Kaufnachweis');

?>