<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: paypal.php 7219 2007-10-08 04:54:42Z drbyte $
 */

  define('MODULE_PAYMENT_PAYPAL_TEXT_ADMIN_TITLE', 'PayPal IPN -  PayPal IPN');
  define('MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_TITLE', 'PayPal');
  if (IS_ADMIN_FLAG === true) {
    define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal IPN</strong> (Basic PayPal service)<br /><a href="https://www.paypal.com/mrb/mrb=R-6C7952342H795591R&pal=9E82WJBKKGPLQ" target="_blank">Gérer votre compte PayPal.</a><br /><br /><font color="green">Configuration Instructions:</font><br />1. <a href="http://www.zen-cart.com/partners/paypal" target="_blank">S’enregister sur Paypal - Cliquez ici.</a><br />2. Dans votre compte de Paypal, au dessous "Profile",<ul><li>set your <strong>Notification de Paiement Instantané Instant Payment préfère la </strong> URL à:<br />'.str_replace('index.php?main_page=index','ipn_main_handler.php',zen_catalog_href_link(FILENAME_DEFAULT, '', 'SSL')) . '<br />(Si une autre URL est déjà utilisé, vous pouvez le laisser du côté.)<br /><span class="alert">Assurez-vous que la case à cocher pour activer IPN est cochée!</span></li><li>sur le <strong>Site de paiement de préférence</strong> installez votre URL de Retour <strong>Automatique </strong> à:<br />'.zen_catalog_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL',false).'</li>' . (defined('MODULE_PAYMENT_PAYPAL_STATUS') ? '' : '<li>... et cliquez  "install" pour activer le support de PayPal... et "edit" à dire Zen Cart vos paramètres PayPal.</li>') . '</ul><font color="green"><hr /><strong>Exigences:</strong></font><br /><hr />*<strong>Compte Paypal</strong> (<a href="http://www.zen-cart.com/partners/paypal" target="_blank">cliquez à s’enregistrer</a>)<br />*<strong>*<strong>Port 80</strong> est utilisé pour la communication bidirectionnelle avec la passerelle, elle doit donc être ouvert sur ​​votre pare-feu<br />*<strong>PHP allow_url_fopen</strong> doit être activé<br />*<strong>Settings</strong> doit être configurée de la manière décrite ci-dessus.' );
  } else {
    define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
  }
  // to show the PayPal logo as the payment option name, use this:  https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif
  // to show CC icons with PayPal, use this instead:  https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', 'https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif');
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT', 'Payer par PayPal');
  define('MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT', 'Economiser du temps. Payer avec succès. <br /><div style="clear:both; padding-bottom:10px;">Payer par carte de crédit PayPal, même si vous <strong>n’avez pas de compte de Paypal</strong>,vous pouviez quand même payer, <a href="https://www.doreenbeads.com/index.php?main_page=page&id=44" alt="https://www.doreenbeads.com/index.php?main_page=page&id=44" target="_blank">En savoir plus>></a></div>');

  define('MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" /> &nbsp;' .  '' . MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT . '');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Prénom:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Nom:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Nom de la Société:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Adresse:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Nom de la Route:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Ville:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Nom de la Route:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'Code Postal:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'Pays:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'Payer Adresse d’Email:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', ' ID de Ebay :');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'ID de Payeur :');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Identité de Payeur:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Address:');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Type de Paiement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Etat de Paiement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Raison de dans l’attente:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Facture:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Date de Paiement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Monnaie:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Montant Total:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Frais de Paiement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Taux de change:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Articles dans le Panier:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Type de Trans. :');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'ID de Trans. :');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'Parent Trans. ID:');


  define('MODULE_PAYMENT_PAYPAL_PURCHASE_DESCRIPTION_TITLE', STORE_NAME . ' Acheter');
  define('MODULE_PAYMENT_PAYPAL_PURCHASE_DESCRIPTION_ITEMNUM', 'Réception de magasin');

?>