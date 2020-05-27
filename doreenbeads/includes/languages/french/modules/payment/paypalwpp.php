<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: paypalwpp.php 7218 2007-10-08 04:51:45Z drbyte $
 */

  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_EC', 'Payer par PayPal');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_WPP', 'Payer par PayPal (WPP)');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PRO20', 'Payer par PayPal (Pro 2.0 Payflow Edition) (UK)');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_EC', 'PayPal Payflow Pro - Gateway');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_GATEWAY', 'Payer par PayPal Express Paiement via Payflow Pro');

  if (IS_ADMIN_FLAG === true) {
    define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_DESCRIPTION', '<strong>PayPal Express Checkout</strong>%s<br />' . (substr(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE,0,7) == 'Payflow' ? '<a href="https://manager.paypal.com/loginPage.do?partner=ZenCart" target="_blank">Gérez votre compte PayPal.</a>' : '<a href="http://www.zen-cart.com/partners/paypal" target="_blank">Manage your PayPal account.</a>') . '<br /><br /><font color="green">Instructions de configuration:</font><br /><span class="alert">1. </span><a href="http://www.zen-cart.com/partners/paypal" target="_blank">Inscrivez-vous à votre compte PayPal - cliquez ici.</a><br />' . 
(defined('MODULE_PAYMENT_PAYPALWPP_STATUS') ? '' : '... et cliquez sur "installer" ci-dessus pour activer le support PayPal Express Paiement.</br>') . 
(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'PayPal' && (!defined('MODULE_PAYMENT_PAYPALWPP_APISIGNATURE') || MODULE_PAYMENT_PAYPALWPP_APISIGNATURE == '') ? '<span class="alert">2. </span><strong>Informations d’authentification API </strong> fde l’option de vérification des pouvoirs de l’API dans votre région Paramètres du profil PayPal. Ce module utilise   <strong>l’authentification API </strong> option -- vous aurez besoin du nom d’utilisateur, mot de passe et la signature d’entrer dans les champs ci-dessous.' : (substr(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE,0,7) == 'Payflow' && (!defined('MODULE_PAYMENT_PAYPALWPP_PFUSER') || MODULE_PAYMENT_PAYPALWPP_PFUSER == '') ? '<span class="alert">2. </span><strong>Lettres de créance PAYFLOW </strong> Ce module a besoin de mettre votre <strong>PAYFLOW Partner+Vendor+Utilisateur+Mot de passe </strong> entré dans les 4 champs ci-dessous. Ceux-ci seront utilisés pour communiquer avec le système Payflow et autoriser les opérations à votre compte.' : '<span class="alert">2. </span>Vérifiez que vous avez entré les données de sécurité appropriées pour nom d’utilisateur / pwd etc, ci-dessous.') ) . 
(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'PayPal' ? '<br /><span class="alert">3. </span>Dans votre compte de Paypal, permettre <strong>Notification instantanée de paiement</strong>:<br />sous la rubrique «Profil», sélectionnez <em> conditions notification instantanée Préférences</em><ul style="margin-top: 0.5;"><li>cliquez sur la case pour activer IPN </li> <li> s’il n’y a pas déjà une URL spécifiée, définissez l’URL:<br />'.str_replace('index.php?main_page=index','ipn_main_handler.php',zen_catalog_href_link(FILENAME_DEFAULT, '', 'SSL')) . '</li></ul>' : '') . 
'<font color="green"><hr /><strong>Requirements:</strong></font><br /><hr />*<strong>CURL</strong> est utilisé pour la communication bidirectionnelle avec la passerelle, elle doit donc être actif sur votre serveur d’hébergement (si vous avez besoin d’utiliser un proxy CURL, définissez les paramètres de proxy CURL sous Admin-> Configuration-> Ma boutique.)<br /><hr />' );
  }

  define('MODULE_PAYMENT_PAYPALWPP_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_TITLE', 'Carte de Crédit');
  define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TITLE', 'PayPal');
  define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TYPE', 'PayPal Express Paiement');
  define('MODULE_PAYMENT_PAYPALWPP_DP_TEXT_TYPE', 'PayPal Direct Paiement');
  define('MODULE_PAYMENT_PAYPALWPP_PF_TEXT_TYPE', 'Carte de Crédit');  //(used for payflow transactions)
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_HEADING', 'Nous sommes désolés, mais nous n’avons pas pu traiter votre carte de crédit.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CARD_ERROR', 'Les informations de carte de crédit que vous avez saisi contient une erreur. S’il vous plaît vérifier et essayer à nouveau.');
   define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_FIRSTNAME', 'Prénom de Titulaire:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_LASTNAME', 'Nom de Titulaire:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_OWNER', 'Nom Complet de Titulaire:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_TYPE', 'Type de Carte:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_NUMBER', 'Numéros de Carte:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_EXPIRES', 'Date d’Expiration:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_ISSUE', 'Date d’émission:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_MAESTRO_ISSUENUMBER', 'N° d’émission Maestro:');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_CHECKNUMBER', 'N° CVV:');
 define('MODULE_PAYMENT_PAYPALDP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(sur le dos de la carte de crédit)');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_DECLINED', 'Votre carte de crédit a été refusée. Veuillez essayer une autre carte ou contactez votre banque pour plus d’informations.');
  define('MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE', 'Nous n’avons pas pu traiter votre commande. Veuillez sélectionner un autre mode de paiement, ou contacter le propriétaire de la boutique à demander des aides.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_ERROR', 'Nous n’avons pas pu traiter votre commande. S’il vous plaît essayer de nouveau, sélectionnez un autre mode de paiement, ou contacter le propriétaire de la boutique à demander des aides .');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_MESSAGE', 'Bonjour Propriétaire  de la boutique'. "\ n". "Une erreur s’est produite lors de la tentative d’ouvrir une transaction PayPal Express Checkout. Par courtoisie, que l’erreur \"nombre\" a été montré à votre client. Les détails de l’erreur sont affichés ci-dessous." . "\n\n");
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_SUBJECT', 'Attention: PayPal Express paiement erreur');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR', 'Les informations d’adresse que vous avez saisi ne semble pas être valide ou ne peut être égalé. S’il vous plaît sélectionner ou ajouter une adresse différente et essayez à nouveau.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CONFIRMEDADDR_ERROR', 'L’adresse que vous avez sélectionné à PayPal n’est pas une adresse confirmée. S’il vous plaît revenir à PayPal et sélectionner ou ajouter une adresse confirmée et essayez à nouveau.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'PayPal a été incapable de financer cette transaction avec succès. S’il vous plaît choisir une autre option de paiement ou des options de financement de l’examen de votre compte PayPal avant de procéder.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ERROR', 'Une erreur s’est produite lorsque nous avons essayé de traiter votre carte de crédit. S’il vous plaît essayer de nouveau, sélectionnez un autre mode de paiement, ou communiquer avec le propriétaire du magasin à l’aide.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_CARD', 'Nous nous excusons pour la gêne occasionnée, mais la carte de crédit que vous avez entré n’est pas celui que nous acceptons. S’il vous plaît utiliser une carte de crédit différente.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_LOGIN', 'Il y avait un problème de valider votre compte. S’il vous plaît essayer à nouveau.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_OWNER', '* Le nom de titulaire doit comporter au moins ' . CC_OWNER_MIN_LENGTH . ' caractères.\n');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_NUMBER', '* Le numéro de la carte doit comporter au moins ' . CC_NUMBER_MIN_LENGTH . ' caractères.\n');
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVS_FAILURE_TEXT', 'Attention: Échec de vérification d’adresse. ');
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_CVV_FAILURE_TEXT', 'Attention: Échec de la vérification le code CVV de la carte. ');
  define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVSCVV_PROBLEM_TEXT', ' La commande est en attente par le Propriétaire du magasin.');
  
  define('MODULE_PAYMENT_PAYPALWPP_PALPAYERID_NULL', 'La transmission Express Checkout PayerID a échoué, veuillez payer à nouveau.');
  
  define('MODULE_PAYMENT_PAYPALWPP_RISK_CUSTOMER', 'Votre carte n’est pas conforme à la politique de contrôle des risques et le paiement a échoué. Veuillez modifier le mode de paiement. Pour plus d’informations, veuillez contacter le service clientèle Paypal ou votre banque émettrice.');
  
  define('MODULE_PAYMENT_PAYPALWPP_NOT_MONEY', 'Votre compte est sous-financé. Veuillez modifier le mode de paiement. Pour plus d’informations, veuillez contacter le service clientèle Paypal ou votre banque émettrice.');
  
  define('MODULE_PAYMENT_PAYPALWPP_NOT_PAYPALMENT', 'Votre carte a expiré/solde insuffisant, veuillez modifier le mode de paiement. Pour plus d’informations, veuillez contacter le service clientèle Paypal ou votre banque émettrice.');
  
  define('MODULE_PAYMENT_PAYPALWPP_TOTAL_ZERO', 'Le paiement a échoué en raison d’un problème de transfert de données, veuillez payer à nouveau.');
  
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR_FOR_SHIPPING_ADDRESS', 'Les informations relatives à votre adresse postale sont incorrectes. Veuillez vérifier si le pays, la ville, le code postal, etc. de votre adresse postale correspondent.');
  
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_EC_HEADER', 'Rapide, Payer par paypal avec sécurité:');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_STATE_ERROR', 'L’état attribué à votre compte n’est pas valide. S’il vous plaît aller dans vos paramètres de compte et changer.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'Nous sommes désolés pour ce désagrément. Le paiement ne pourrait être engagée parce que le compte PayPal configuré par le propriétaire du magasin n’est pas un compte PayPal Pro Website Payments ou services de passerelle PayPal n’a pas été acheté. S’il vous plaît sélectionner un autre mode de paiement pour votre commande.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_SANDBOX_VS_LIVE_ERROR', 'Nous sommes désolés pour ce désagrément. Les paramètres d’authentification de compte PayPal ne sont pas encore mis en place, ou les informations de sécurité de l’API est incorrect. Nous sommes incapables de compléter votre transaction. S’il vous plaît aviser le propriétaire du magasin afin qu’ils puissent corriger ce problème.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_WPP_BAD_COUNTRY_ERROR', 'Nous sommes désolés - le compte PayPal configuré par l’administrateur du magasin est basé dans un pays qui n’est pas pris en charge pour les paiements sur site Pro à l’heure actuelle. S’il vous plaît choisir une autre méthode de paiement pour compléter votre commande.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(REMARQUE: Le module n’est pas encore configuré)</span>');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_GETDETAILS_ERROR', 'Il y avait un problème d’annuler la transaction. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_TRANSSEARCH_ERROR', 'Il y avait un problème de localisation des transactions correspondant aux critères que vous avez spécifiés. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_ERROR', 'Il y avait un problème d’annuler la transaction. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_ERROR', 'Il y avait un problème de rembourser le montant de la transaction spécifiée. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_ERROR', 'Il y avait un problème autorisant la transaction. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_ERROR', 'Il y avait un problème de capturer la transaction. ');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUNDFULL_ERROR', 'Your Refund Request was rejected by PayPal.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_REFUND_AMOUNT', 'Votre demande de remboursement a été rejetée par PayPal.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_ERROR', 'Vous avez demandé un remboursement complet mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_AUTH_AMOUNT', 'Vous avez demandé une autorisation, mais ne spécifiez pas un montant.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_CAPTURE_AMOUNT', 'Vous avez demandé une capture mais n’avez pas spécifié un montant.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', 'Confirmer');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_ERROR', 'Vous avez demandé d’annuler une transaction mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', 'Confirmer');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_CONFIRM_ERROR', 'Vous avez demandé une autorisation mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', 'Vous avez demandé des fonds-Capture mais n’avez pas coché la case de confirmation pour vérifier votre intention..');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_INITIATED', 'Remboursement PayPal pour %s les initiées. Transaction ID:%s. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande / Commentaires.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_INITIATED', 'PayPal autorisation pour %s initiées. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande / Commentaires.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_INITIATED', 'PayPal capture pour %s initiées. Réception ID:%s. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande /Commentaires.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_INITIATED', 'PayPal demande Void lancé. Transaction ID:%s. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande / Commentaires.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_API_ERROR', 'Il y avait une erreur dans la tentative d’opération. S’il vous plaît voir le guide de référence de l’API ou les journaux de transactions pour des informations détaillées');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_ZONE_ERROR', 'Nous sommes désolés pour ce désagrément, mais à l’heure actuelle nous ne pouvons pas utiliser cette méthode pour traiter les commandes de la région géographique que vous avez sélectionné comme votre adresse de compte. S’il vous plaît continuer à utiliser la caisse normale et choisir parmi les méthodes de paiement disponibles pour compléter votre commande.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_ORDER_ALREADY_PLACED_ERROR', 'Il semble que votre commande a été soumis à deux fois. S’il vous plaît vérifier la zone Mon compte pour voir les détails de la commande réels. S’il vous plaît utiliser le formulaire Contactez-nous si votre commande ne semble pas ici mais est déjà payé à partir de votre compte PayPal afin que nous puissions vérifier nos dossiers et concilier cela avec vous.');

  //define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', 'Payer par Paypay. Le mode plus facile et en bonne sécurité');
  //jessa 2010-04-29 
  define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', 'Payer avec sécurité. <br /><div style="clear:both; padding-bottom:10px;">Ppayer par carte de crédit via Paypal, même si vous <strong> n’avez pas de compte PayPal </strong>, vous pouvez toujours payer, <a href="https://www.doreenbeads.com/index.php?main_page=page&id=44" alt="https://www.doreenbeads.com/index.php?main_page=page&id=44" target="_blank">En savoir plus>></a></div>');
  //eof jessa 2010-04-29
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_ALTTEXT', 'Cliquez ici pour payer par PayPal Express Paiement');

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
  define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Prénom:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Nom:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Affaires:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Adresse:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Nom de la Route:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Ville:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Province:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'Code Postal:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'pays:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'E-mail de payeur:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'Ebay ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'Payeur ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Etat payeur:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Adresse:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Mode de Paiement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Etat de Paiement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Raison d’en Attente:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Facture:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Date de Payer:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Monnaie:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Montant Brut:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Payer gratuitement:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Taux d’échange:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Produits dans le panier:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Type de Trans.:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'ID de trans.:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'Parent Trans. ID:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TITLE', '<strong>Remboursement de Commande</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_FULL', 'Si vous souhaitez rembourser cette commande dans son intégralité, cliquez ici:');
   define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_FULL', 'Rembourser Complètement');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_PARTIAL', 'Rembourser partiellement');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_FULL_OR', '<br />... our entrer le montant partiel ');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PAYFLOW_TEXT', 'Entrer ');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PARTIAL_TEXT', 'rembourser le montant ici et cliquez sur Remboursement Partiel');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_SUFFIX', '*Un remboursement complet ne peut être délivré après un remboursement partiel a été appliqué. <br /> * Plusieurs remboursements partielles sont autorisées jusqu’au solde non remboursé restant.');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Remarque pour afficher à la clientèle:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Remboursés par l’administrateur de site.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_CHECK','Confirmer: ');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_TITLE', '<strong>Authorizations de Commandes</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_PARTIAL_TEXT', 'Si vous souhaitez autoriser partie de cette commande, entrez le montant ici:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_BUTTON_TEXT_PARTIAL', 'Faire l’autorisation');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_SUFFIX', '');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Remarque pour afficher à la clientèle:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Remboursés par l’administrateur de site.');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TITLE', '<strong>Capture d’autorisations</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FULL', 'Si vous souhaitez capturer tout ou partie des montants autorisés en circulation pour cette commande, entrez le montant de capture et sélectionnez si ce n’est la capture finale pour cette commande. Cochez la case de confirmation avant de soumettre votre demande de capture.<br />');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_BUTTON_TEXT_FULL', 'Capturer');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_AMOUNT_TEXT', 'Montant pour capturer:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FINAL_TEXT', 'Est-ce la capture finale?');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_SUFFIX', '');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TEXT_COMMENTS', '<strong>Remarque pour afficher à la clientèle:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'Merci de passer la commande chez nous.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPTURE_FULL_CONFIRM_CHECK','Confirmer: ');

 define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TITLE', '<strong>Miction ordonner autorisations</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID', 'Si vous souhaitez annuler une autorisation, entrez l’ID d’autorisation ici, et confirmer:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TEXT_COMMENTS', '<strong>Remarque pour afficher à la clientèle:</strong>');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_DEFAULT_MESSAGE', 'Merci pour votre soutien.Veuillez retourner.');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', 'Annuler');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', '');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'Etat de transcation:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', 'Auth. Code:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'AVS Adresse match:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'AVS ZIP match:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'CVV2 match:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', 'Jours à Installer:');

// this text is used to announce the username/password when the module creates the customer account and emails data to them:
  define('EMAIL_EC_ACCOUNT_INFORMATION', 'Vos informations de connexion de compte, que vous pouvez utiliser pour examiner votre achat sont les suivants:');



?>