<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: paypaldp.php 7334 2007-10-31 11:58:58Z drbyte $
 */

  define('MODULE_PAYMENT_PAYPALDP_TEXT_ADMIN_TITLE_WPP', 'Payer par Paypal');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_ADMIN_TITLE_PRO20', 'PayPal Website Payments Pro Payflow Edition (UK)');

  if (IS_ADMIN_FLAG === true) {
    define('MODULE_PAYMENT_PAYPALDP_TEXT_ADMIN_DESCRIPTION', '<strong>Payer par Paypal</strong>%s<br />' . '<a href="http://www.zen-cart.com/partners/paypal" target="_blank">Gérez votre compte PayPal.</a>' . '<br /><br /><font color="green">Instructions Configuration :</font><br /><span class="alert">1. </span><a href="http://www.zen-cart.com/partners/paypal" target="_blank">Inscrivez-vous à votre compte PayPal - cliquez ici.</a><br />' . 
(defined('MODULE_PAYMENT_PAYPALDP_STATUS') ? '' : '... et cliquez sur "installer" ci-dessus pour activer le support PayPal Express Paiement.</br>') . 
(!defined('MODULE_PAYMENT_PAYPALWPP_APISIGNATURE') || MODULE_PAYMENT_PAYPALWPP_APISIGNATURE == '' ? '<span class="alert">2. </span><strong>Informations d’authentification API </strong> de l’option de vérification des pouvoirs de l’API dans votre région Paramètres du profil PayPal. Ce module utilise l’API <strong> Signature </strong> option - vous aurez besoin du nom d’utilisateur, mot de passe et la signature d’entrer dans les champs ci-dessous. ' : '<span Class="alert"> 2. </span> Vérifiez que vous avez entré les données de sécurité appropriées pour nom d’utilisateur / pwd etc, ci-dessous. '). 
'<font color=\"green\"> <HR /> <strong> Exigences: </strong> </font> <br /> <hr /> * <strong> Exprimez Commander </strong> doit être installé et activé pour utiliser Website Payments Pro, selon Conditions générales d’utilisation de PayPal. <br /> <hr /> ');
  }

  define('MODULE_PAYMENT_PAYPALDP_TEXT_DESCRIPTION', 'Carte de Crédit');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_TITLE', 'Carte de Crédit');
  define('MODULE_PAYMENT_PAYPALDP_DP_TEXT_TYPE', 'Carte de Crédit(WPP)');
  define('MODULE_PAYMENT_PAYPALDP_PF_TEXT_TYPE', 'Carte de Crédit (PF)');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_HEADING', 'Nous sommes désolés, mais nous n’avons pas pu traiter votre carte de crédit.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CARD_ERROR', 'Les informations de carte de crédit que vous avez saisi contient une erreur. S’il vous plaît vérifier et essayer à nouveau.');
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
  define('MODULE_PAYMENT_PAYPALDP_CANNOT_BE_COMPLETED', 'Nous n’avons pas pu traiter votre commande. Veuillez sélectionner un autre mode de paiement, ou contacter le propriétaire de la boutique à demander des aides.');
  define('MODULE_PAYMENT_PAYPALDP_INVALID_RESPONSE', 'Nous n’avons pas pu traiter votre commande. S’il vous plaît essayer de nouveau, sélectionnez un autre mode de paiement, ou contacter le propriétaire de la boutique à demander des aides .');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_GEN_ERROR', 'Une erreur s’est produite lorsque nous avons essayé de contacter le processeur de paiement. S’il vous plaît essayer de nouveau, sélectionnez un autre mode de paiement, ou communiquer avec le propriétaire de la boutique à demander des aides.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_EMAIL_ERROR_MESSAGE', 'Propriétaire de la boutique' . "\n". "Une erreur s’est produite lors de la tentative d’ouverture de la transaction de paiement-validation. Par courtoisie, que l’erreur \"nombre\" a été montré à votre client. Les détails de l’erreur sont affichés ci-dessous." . "\n\n");
  define('MODULE_PAYMENT_PAYPALDP_TEXT_EMAIL_ERROR_SUBJECT', 'Attention: PayPal Paiement Direct Erreur');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_ADDR_ERROR', 'Les informations d’adresse que vous avez saisi ne semble pas être valide ou ne peut être égalé. S’il vous plaît sélectionner ou ajouter une adresse différente et essayez à nouveau.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'PayPal a été incapable de financer cette transaction avec succès. S’il vous plaît choisir une autre option de paiement ou des options de financement de l’examen de votre compte PayPal avant de poursuivre.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_ERROR', 'Une erreur s’est produite lorsque nous avons essayé de traiter votre carte de crédit. S’il vous plaît essayer de nouveau, sélectionnez un autre mode de paiement, ou communiquer avec le propriétaire du magasin de l’aide.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_BAD_CARD', 'Nous nous excusons pour la gêne occasionnée, mais la carte de crédit que vous avez entré n’est pas celui que nous acceptons. S’il vous plaît utiliser une carte de crédit différente ou vérifier que les détails que vous avez inscrits sont correctes, ou communiquer avec le propriétaire du magasin de l’aide.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_BAD_LOGIN', 'Il y avait un problème de validation de votre compte. S’il vous plaît essayer à nouveau.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_JS_CC_OWNER', '* ;Le nom de titulaire doit comporter au moins ' . CC_OWNER_MIN_LENGTH . ' caractères.\n');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_JS_CC_NUMBER', '* Le numéro de la carte doit comporter au moins ' . CC_NUMBER_MIN_LENGTH . ' caractères.\n');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_JS_CC_CVV', '* le numéro CVV 3 ou 4 chiffres doit être entré à l’arrière de la carte de crédit.\n');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_AVS_FAILURE_TEXT', 'Attention: Échec de vérification d’adresse. ');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_CVV_FAILURE_TEXT', 'Attention: Échec de la vérification le code CVV de la carte. ');
  define('MODULE_PAYMENT_PAYPALDP_ERROR_AVSCVV_PROBLEM_TEXT', ' La commande est en attente par le Propriétaire du magasin.');

  define('MODULE_PAYMENT_PAYPALDP_TEXT_STATE_ERROR', 'L’état attribué à votre compte n’est pas valide. S’il vous plaît aller dans vos paramètres de compte et changer.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'Nous sommes désolés pour ce désagrément. Le paiement ne pourrait être engagée parce que le compte PayPal configuré par le propriétaire du magasin n’est pas un compte PayPal Pro Website Payments ou services de passerelle PayPal n’a pas été acheté. S’il vous plaît sélectionner un autre mode de paiement pour votre commande.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_US_WPP_ACCOUNT_ERROR', 'Nous sommes désolés pour ce désagrément. Le paiement ne pourrait être engagée parce que le compte PayPal configuré par le propriétaire du magasin n’est pas un pro compte des États-Unis PayPal Website Payments ou services de passerelle PayPal n’a pas été acheté. S’il vous plaît sélectionner un autre mode de paiement pour votre commande.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_UKWPP_ACCOUNT_ERROR', 'Nous sommes désolés pour ce désagrément. Le paiement ne pourrait être engagée parce que le compte PayPal configuré par le propriétaire du magasin n’est pas un Pro 2.0 (Royaume-Uni) compte PayPal Website Payments ou services de passerelle PayPal n’a pas été acheté. S’il vous plaît sélectionner un autre mode de paiement pour votre commande.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_SANDBOX_VS_LIVE_ERROR', 'Nous sommes désolés pour ce désagrément. Les paramètres d’authentification de compte PayPal ne sont pas encore mis en place, ou les informations de sécurité de l’API est incorrect. Nous sommes incapables de compléter votre transaction. S’il vous plaît aviser le propriétaire du magasin afin qu’ils puissent corriger ce problème.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_WPP_BAD_COUNTRY_ERROR', 'Nous sommes désolés - le compte PayPal configuré par l’administrateur du site est basé dans un pays qui n’est pas pris en charge pour les paiements sur site Pro à l’heure actuelle. S’il vous plaît choisir une autre méthode de paiement pour compléter votre commande ..');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(REMARQUE: Le module n’est pas encore configuré)</span>');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_GETDETAILS_ERROR', 'Il y avait un problème concernant les détails de la transaction. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_TRANSSEARCH_ERROR', 'Il y avait un problème de localisation des transactions correspondant aux critères que vous avez spécifiés. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_VOID_ERROR', 'Il y avait un problème d’annuler la transaction. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUND_ERROR', 'Il y avait un problème de rembourser le montant de la transaction spécifiée. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_AUTH_ERROR', 'il y avait un problème autorisant la transaction. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPT_ERROR', 'Il y avait un problème de capturer la transaction. ');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUNDFULL_ERROR', 'Votre demande de remboursement a été rejetée par PayPal.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_REFUND_AMOUNT', 'Vous avez demandé un remboursement partiel mais ne spécifiez pas un montant.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUND_FULL_CONFIRM_ERROR', 'Vous avez demandé un remboursement complet mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_AUTH_AMOUNT', 'Vous avez demandé une autorisation, mais ne spécifiez pas un montant.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_CAPTURE_AMOUNT', 'Vous avez demandé une capture mais n’avez pas spécifié un montant.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', 'Confirmer');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_VOID_CONFIRM_ERROR', 'Vous avez demandé d’annuler une transaction mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', 'Confirmer');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_AUTH_CONFIRM_ERROR', 'Vous avez demandé une autorisation mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', 'Vous avez demandé des fonds-Capture mais n’avez pas coché la case de confirmation pour vérifier votre intention.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_REFUND_INITIATED', 'Remboursement PayPal pour %s initiées. Transaction ID:%s. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande / Commentaires.s');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_AUTH_INITIATED', 'PayPal autorisation pour %s initiées. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande /Commentaires.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_CAPT_INITIATED', 'PayPal capture pour %s initiées. Réception ID:%s. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande /Commentaires.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_VOID_INITIATED', 'PayPal demande Void lancé. Transaction ID:%s. Rafraîchir l’écran pour voir les détails de confirmation de mise à jour dans la section Histoire État de la commande / Commentaires.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_GEN_API_ERROR', 'Il y avait une erreur dans la tentative d’opération. S’il vous plaît voir le guide de référence de l’API ou les journaux de transactions pour des informations détaillées.');
  define('MODULE_PAYMENT_PAYPALDP_TEXT_INVALID_ZONE_ERROR', 'Nous sommes désolés pour ce désagrément, mais à l’heure actuelle nous ne pouvons pas utiliser cette méthode pour traiter les commandes de la région géographique que vous avez sélectionné comme votre adresse de compte. S’il vous plaît continuer à utiliser la caisse normale et choisir parmi les méthodes de paiement disponibles pour compléter votre commande.');
 // Ceux-ci sont utilisés pour afficher les détails des transactions premières dans le domaine administratif:
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
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', 'Do Void');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', '');

  define('MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'Etat de transcation:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', 'Auth. Code:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'AVS Adresse match:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'AVS ZIP match:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'CVV2 match:');
  define('MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', 'Jours à Installer:');




?>