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
// $Id: checkout_process.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('EMAIL_TEXT_SUBJECT', 'Nous avons reçu votre paiement pour la commande No. %s'); 
define('EMAIL_TEXT_HEADER', 'Confirmer la Commande');
define('EMAIL_TEXT_PAYMENT_HEADER', 'Payment Confirmation from Doreenbeads');
define('EMAIL_TEXT_FROM',' Venir de ');  //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING','Merci de passer la commande chez nous!');
define('EMAIL_THANKS_FOR_PAYMENT','Merci de faire la commande chez nous! Vous avez fait le paiement avec succès, et nous allons organiser l\'emballage de votre commande et l\'expédition plus tôt possible.');
define('EMAIL_DETAILS_FOLLOW','Ce sont les détails de votre commande.');
define('EMAIL_TEXT_ORDER_NUMBER', 'N°de Commande:');
define('EMAIL_TEXT_INVOICE_URL', 'Facture Détaillée:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Cliquer ici à demander une Facture Détaillée');
define('EMAIL_TEXT_DATE_ORDERED', 'Date de Passer la Commande:');
define('EMAIL_TEXT_PRODUCTS', 'produits');
define('EMAIL_TEXT_SUBTOTAL', 'Sous-total:');
define('EMAIL_TEXT_TAX', 'Taxes:');
define('EMAIL_TEXT_SHIPPING', 'Expédition:');
define('EMAIL_TEXT_TOTAL', 'Total:');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Adresse d’expédition');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Address de Facture');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Modes de Paiement');
define('HEADING_ADDRESS_TITLE', 'Nous allons envoyer votre colis à l\'adresse suivante ');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');

// suggest not using # vs No as some spamm protection block emails with these subjects  proposition: Ne pas utiliser # vs non,comme certains e-mails de blocs de protection de spamm avec ces sujets
define('EMAIL_ORDER_NUMBER_SUBJECT', ' No°: ');
define('HEADING_ADDRESS_INFORMATION','Address Information');
define('HEADING_SHIPPING_METHOD','Modes d’expédition');
//define('TEXT_HTML_CHECKOUT_SHIPPING_ADDRESS', '<br /><span style="color:red;">Note:</span> Please make sure this shipping address is correct. After receive your payment, we will swiftly process your order and ship it out. We ship orders frequently. So that if you find this address is not correct, please contact us as soon as possible.

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Note importante sur<b>Adresse d’expédition</b>:</span> S’il vous plaît assurez cette adresse d’expédition est correcte. Après réception de votre paiement, nous allons commencer à traiter votre commande et de l’expédier rapidement. Alors que si vous trouvez cette adresse n’est pas correcte, s’il vous plaît nous contacter sous 24H.<br /><br />');

//add by zhouliang 2011-09-09
define('EMAIL_ORDER_TRACK_REMIND','<font color="red">Veuillez vérifier votre adresse d’e-mail à recevoir le message sur <b>la livraison de votre commande:</b></font><br />
Nous vous tiendrons au courant sur l’état de votre commande du moment. Normalement,après avoir payé, vous recevrez un message sur la livraison de votre colis sous 2 jours ouvrables. Donc, si vous n’avez pas reçu la notification de l’envoi dans cette période, s’il vous plaît n’hésitez pas à nous contacter. Nous allons vérifier votre commande pour vous, pour s’assurer que nous pouvons expédier votre colis sans retard. Merci pour votre temps. :)
	<br /> <br />
	<font color="red">S’il arrive que l’un ou quelques articles en rupture de stock, <b>devrions-nous vous contacter avant l’expédition?</b></font><br /><br />
	Normalement, les articles ne seront pas en rupture de stock car nous avons un stock suffisant :) mais il arrive dans quelques occasions que certain articles sont épuisée. Lorsque cela arrive, notre politique par défaut est d’expédier des produits disponibles tout d’abord, des articles en rupture de stock, nous les envoyerons dès qu’ils serions disponibles de nouveau, ou les expédier ensemble avec votre prochaine commande, ou vous créditer le montant égal que vous avez payé pour ces produits. Nous allons indiquer en détail dans la notification d’expédtion.
	<br /><br />
	<font color="red">Note:</font> Si nous avons de vous contacter pour vous faire savoir que l’article était en rupture de stock avant de l’envoyer, s’il vous plaît bien vouloir répondre par e-mail à discuter de l’échange d’article etc.
	<br /><br />
	Merci de votre lecture. :)<br /><br />
	(Rappel aimable: Vous pouvez vérifier votre dossier spam si vous n’avez pas reçu la notification, parfois le message peut être bloqué par inadvertance.) 	
	');

define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Important note about <b>Delivery Address</b>:</span> ');
define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', "\n" . '<br /><span style="color:red;">Note importante sur<b>Adresse d’expédition</b>:</span> S’il vous plaît assurez cette adresse d’expédition est correcte. Après réception de votre paiement, nous allons commencer à traiter votre commande et de l’expédier rapidement. Alors que si vous trouvez cette adresse n’est pas correcte, s’il vous plaît nous contacter sous 24H.<br /><br />');
//end
define('TEXT_PAYMENT_FAILURE', 'Nous sommes désolés que vous n’avez pas payé avec succès. C’est peut-être à cause des informations incorrectes de votre carte de crédit. Veuillez essayer avec une autre carte si c’est possible. Si ?a marche pas, contactez-nous via <a href=mailto:sale_fr@doreenbeads.com>sale_fr@doreenbeads.com</a>. Merci!');
?>
