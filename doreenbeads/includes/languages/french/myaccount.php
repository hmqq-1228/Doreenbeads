<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */

define('NAVBAR_TITLE', 'Mon Compte');
define('HEADING_TITLE', 'Mon Compte');
define('TEXT_SAY_HI','Bonjour %s!');
define('TEXT_CART_QUICK_ORDER_BY', 'Ajouter des Produits Rapidement');
define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Ajouter plus d’articles');
define('TEXT_CART_QUICK_ADD_NOW', 'Ajouter rapidement');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Veuillez entrer le numéro de référence(par exemple B06512)et la quantité de produits que vous voulez dans le formulaire ci-dessous:');
define('TEXT_CART_P_NUMBER', ' Numéro de référence');
define('TEXT_CART_P_QTY', 'Quantité');
define('TEXT_WORD_UPDATE', 'Mettre à jour');
define('TEXT_WORD_ALREADY_UPDATE', 'Gardé');
define('TEXT_CART_JS_WRONG_P_NO', 'Ce produit n’existe pas sur notre site, pour continuer, vueillez supprimer cet article de votre liste.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'Pardon, quelques articles dans le formulaire n’existe pas, veuillez le supprimer.');
define('TEXT_CART_JS_NO_STOCK', 'Hors stock. Pour continuer, veuillez le supprimer.');
define('TEXT_DISCOUNT_TABLE_INFO','<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">La réduction au</th><th width="80"> montant total de produits</th><th>Comment profiter de la réduction?</th></tr>
		<tr><td>US $30 - US$ 800</td><td><b>6.01 USD</b></td><td rowspan=4 class="rowspanTd">profitez de la réduction correspondant juste en cliquant le bouton"J’en profite" avant de "confirmer la commande".</td></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>');
define('TEXT_DISCOUNT_TABLE_INFO_2','<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">La réduction au</th><th width="80"> montant total de produits</th><th>Comment profiter de la réduction?</th></tr>
		<tr><td>US $30 - US$ 800</td><td><b>5€</b></td><td rowspan=4 class="rowspanTd">profitez de la réduction correspondante juste en cliquant le bouton"J’en profite" avant de "confirmer la commande".</td></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>');
define('TEXT_TOTAL_CONSUMPTION','Montant total d’achats historiques:');
define('TEXT_WHAT_YOU_CAN_ENJOY','Vous pouviez profiter de la réduction suivante pour votre première commande:');
define('TEXT_NOW_YOU_CAN','<p><strong>Maintenant vous pouviez:</strong></p>
       <p>Acheter:  <a href="'.zen_href_link(FILENAME_PRODUCTS_NEW).'">Nouveautés</a></p>
       <p>Vous avez reçu votre colis? On vous invite d’<a href="javascript:void(0);" class="footer_write_a_testimonial">Ecrire vos avis sur nos produits et nos services</a></p>');
define('BEST_SELLER','Top Ventes'); 
define('TEXT_CART_MY_VIP', 'Mon Niveau de VIP');
define('TEXT_CART_OFF', 'Réduction');
define('TEXT_CREDIT_BALANCE','Promos de Crédit:');
?>