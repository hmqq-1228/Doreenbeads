<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_payment.php 4087 2006-08-07 04:46:08Z drbyte $
 */
define('HEADING_TITLE', 'Payer la commande');
define('HEADING_TOTAL', 'Total');

//2.0 languages
define ( 'TEXT_PAY','Payer');
define ( 'TEXT_FOR_THIS_ORDER','pour votre commande');

define('TEXT_PAYMENT_YOUR_ORDER_SUCCESS',' Vous avez confirmé votre commande, veuillez la payer tout de suite pour qu’elle soit envoyée le plus tôt possible.'); 
define('TEXT_PAYMENT_ORDER_NUMBER','N°de Commande:'); 
define('TEXT_PAYMENT_PAYPAL_DIRECTLY','Vous pouviez se connectter directment <a href="http://www.paypal.com"><u>www.paypal.com</u></a> et payer votre commande'); 
define('TEXT_PAYMENT_PAUYPAL_CLICKING','Ou nous payer en cliquant le bouton ci-dessous. Tous les deux modes sont en sécurité.');
define('TEXT_PAYMENT_PAY_NOW','Payer');


define('TEXT_PAYMENT_TOTAL_AMOUNT','Montant total:');
define('TEXT_PAYMENT_NOTE','Note');

define('TEXT_PAYMENT_WUMT','<p>1. Nous offrons une réduction de 2% pour toutes les commandes avec le montant total supérieur à 2000 $, les frais de commission doivent être payés par le payeur. <a href="'.HTTP_SERVER.'/page.html?id=146" target="_blank">Cliquer ici pour plus d’informations>></a></p>
<p>2. Veuillez nous <a href="mailto:service_fr@doreenbeads.com">envoyer les informations de paiement</a> après que vous transférez de l’argent, alors nous pourrions confirmer l’argent que vous avez transféré et expédier votre colis le plus tôt que possible.</p> ');

define('TEXT_PAYMENT_MONEY_GRAM_2','<p>2.&nbsp;2% Nous offrons une réduction de 2% pour toutes les commandes avec le montant total supérieur à $2000, les frais de commission doivent être payés par l’auteur de virements..</p>');
define('TEXT_PAYMENT_MONEY_GRAM','Veuillez nous <a href="mailto:service_fr@doreenbeads.com">envoyer les informations de paiement</a> après que vous transférez de l’argent, alors nous pourrions confirmer l’argent que vous avez transféré et expédier votre colis le plus tôt que possible.');

define('TEXT_CREDIT_ACCOUNT_BALANCE','Solde de Compte de Crédit');
define('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE','Solde de votre compte de crédit');
define('TEXT_PAY_FOR_THIS_ORDER',"Payer %s pour cette commande");
define('TEXT_PAY_FOR_THIS_ORDER_TOTAL',"Payer %s pour cette commande");
define('TEXT_PAYPAL','PayPal');
define('TEXT_BANK_ACCOUNT_HSBC','Notre compte de banque (Citibank)');
define('TEXT_BANK_ACCOUNT_BC','Notre compte de banque (Banque de Chine)');
define('TEXT_WESTERN_UNION','Western Union');
define('TEXT_BRAINTREE', 'Braintree');
define('TEXT_CREDIT_DEBIT_CARD','Carte de Crédit /Débit');
define('TEXT_MONEY_GRAM_INFO','Infos de notre bénéficiaire ');
define('TEXT_STILL_NEED_TO_PAY', 'Encore besoin de payer: <span class="price_color">%s</span>');
define ( 'TEXT_PAYMENT_CHECK_ADDRESS','Veuillez vérifier votre adresse de livraison pour confirmer son exactitude. Normalement, lors de la réception de votre paiement, nous allons expédier votre colis en 1-2 jours. Par conséquent, si vous remarquez que votre adresse de livraison  n’est pas correcte, veuillez nous contacter aussi rapidement que possible en les 24 heures.');
define('TEXT_BALANCE_LEFT' ,'Solde disponible: %s');
?>