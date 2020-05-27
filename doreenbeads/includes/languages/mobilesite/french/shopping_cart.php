<?php
// bof 2.0

define('HEADING_TITLE','Panier');
define ( 'TEXT_CART_IS_EMPTY_DO_SHOPPING', 'Votre panier est vide maintenant. <a href="'.zen_href_link(FILENAME_DEFAULT).'">Commencez à faire des achats.</a>' );
define ( 'TEXT_CART_IS_EMPTY_DO_SHOPPING_NO_LOGIN', 'Si vous avez déjà un compte, <a href="'.zen_href_link(FILENAME_LOGIN).'">Connectez-vous</a>  pour voir vos produits dans le panier svp.' );
define('TEXT_CART_IS_EMPTY_SHOP','Aller!');
define('TEXT_CART_GO_HOMEPAGE', 'Aller à l’accueil.');
define('TEXT_CART_CONTINUE_SHOPPING', 'Continuer les achats');
define('TEXT_CART_CHECKOUT', 'Passer à payer');
define('TEXT_CART_MY_CART', 'Mon Panier');
define('TEXT_CART_MY_VIP', 'Mon Niveau de VIP');
define('TEXT_CART_OFF', 'Réduction');
define ( 'TEXT_CART_MOVE_WISHLIST', 'Déplacer à la Liste de Favoris' );
define('TEXT_CART_EMPTY_CART', 'Supprimer le Sélectionné');
define('TEXT_CART_P_IMG', 'Image');
define('TEXT_CART_P_NUMBER', 'N° de réf');
define('TEXT_CART_P_WEIGHT', 'Poids');
define('TEXT_CART_P_V_WEIGHT', 'Poids de volume');
define('TEXT_CART_P_NAME', 'Titre de produits');
define('TEXT_CART_P_PRICE', 'Prix');
define('TEXT_CART_P_QTY', 'Quantité');
define('TEXT_CART_P_SUBTOTAL', 'Sous-total');
define('TEXT_CART_WORD_TOTAL', 'Total');
define('TEXT_CART_WORD_TOTAL1', 'Total');
define('TEXT_CART_WORD_SELECTED', 'Sélectionné');
define('TEXT_CART_ITEM', 'Article');
define('TEXT_CART_ITEMS', 'Articles');
define('TEXT_CART_AMOUNT', 'Montant');


define('TEXT_CART_QUICK_ORDER_BY', 'Ajouter des Produits Rapidement');
define('TEXT_CART_QUICK_ORDER_BY_CONTENT', 'Vous pouvez ajouter des produits au panier en entrant directement le N ° d’article ou sous forme de feuille de calcul.');
define('TEXT_CART_JS_MOVE_ALL', 'Confirmez-vous le déplacement des articles sélectionnés vers la liste de favoris?');
define('TEXT_CART_JS_MOVE_TO_WISHLIST', 'Confirmez-vous de déplacer cela au wishlist?');
define('TEXT_CART_JS_EMPTY_CART', 'Confirmez-vous la suppression des articles sélectionnés dans le panier?');
define('TEXT_CART_JS_WRONG_NO', 'N° de réf invalide');
define('TEXT_CART_JS_NO_STOCK', 'Hors Stock');

define('TEXT_WORD_UPDATE', 'Mettre à jour');
define('TEXT_WORD_ALREADY_UPDATE', 'Gardé');

define('TEXT_CART_ORIGINAL_PRICE', 'Prix d’original');
define('TEXT_CART_PROMOTION_DISCOUNT', 'Promotion');
define('TEXT_CART_VIP_DISCOUNT', 'Réduction VIP');
define('TEXT_CART_SHIPPING_COST', 'Estimation des frais d’expédition');

/* bof shipping calculator */
define('TEXT_CART_SHIPPING_INFO', 'Infos de livraison');
define('TEXT_CART_SHIPPING_COUNTRY', 'Pays');
define('TEXT_CART_SHIPPING_CITY', 'Ville/Village');
define('TEXT_CART_SHIPPING_POSTCODE', 'Zip /code Postal');
define('TEXT_CART_SHIPPING_CAL', 'Calculer');
define('TEXT_CART_SHIPPING_COMPANY', 'Sociétés de transports');
define('TEXT_CART_SHIPPING_EST_TIME', 'Délai de livraison estimé');
define('TEXT_CART_SHIPPING_EST_COST', 'Frais de livraison');
define('TEXT_CART_SHIPPING_EST_SPECIAL', 'Réduction Spéciale');

define('TEXT_CART_SHIPPING_EST_TIME_CODE', '<font title="The following shipping day is just for reference.The actual shipping time may be different for different countries. It will be affected by the distance from China and the local customs policy. ">Est. Shipping Time</font>');
/* eof */

/* bof recently viewed products */
define('TEXT_CART_RECENTLY_VIEWED', 'Articles vus récemment');
define('TEXT_CART_RECENTLY_VIEWED_NO_P', 'Vous n’avez pas vu aucuns produits.');
define('TEXT_CART_RECENTLY_ADD_SUCCESSFULLY', 'Ajouté au panier avec succès');
define('TEXT_CART_RECENTLY_ITEMS_TOTALLY', 'Article(s) total(s)');
define('TEXT_CART_RECENTLY_VIEW_CART', 'Voir le panier');
define('TEXT_CART_RECENTLY_CLOSE', 'Fermer');

/* eof */

define('ERROR_CART_RECOMMEND_LOGIN', 'À garder les articles dans le panier, nous vous proposons fortement de <a href="' . zen_href_link(FILENAME_LOGIN) . '">login</a> or <a href="' . zen_href_link(FILENAME_LOGIN) . '">S’enregister tout de suite!register</a> first.');

define('TEXT_CART_REMOVE_THIS_ITEM', 'Supprimer cet article?');
define('TEXT_CART_DELETE', 'Supprimer');
define('TEXT_CART_ARE_U_SURE_DELETE', 'Confirmez-vous de supprimer cet article?');

define('TEXT_CART_WEIGHT_UNIT', 'g');

define('TEXT_SERVICE','Service');
define('TEXT_SHIPPING_COST_INOF','Les frais de livraison sont calculés selon le poids de produits plus le poids de boîte d’emballage..');
define('TEXT_CART_EST_SHIPPING_COST','Vous pouviez changer la mode de livraison à la page suivante.');
define('Text_CART_NEXT_PAGE','Vous pouviez profiter de la réduction à la page suivante en cliquant le bouton"J’en profite".');
define('Text_CART_COUPON_AMOUNT','Coupon de Réduction:');

// eof

define('TEXT_UPDATE_QTY_SUCCESS', 'Vous avez mis à jour la quantité de cet article avec succès.!');
define ( 'TEXT_UPDATE_QTY_SUCCESS_MOBILE', 'La quantité est mise à jour %s.' );
define('TEXT_ADDCART_MAX_NOTE', 'Seulement %s paquet (s) de %s sont disponibles maintenant. La quantité est mise à jour %s paquet (s) automatiquement.');
define('TEXT_ADDCART_MAX_NOTE_ALERT', 'Pardon, mais on a que %s paquet(s) produit %s en ce moment, veuillez mettre à jour la quantité!. Si vous avez des questions, n’hésitez pas à nous contacter par<a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com');

define('TEXT_CART_SPECIAL_DISCOUNT', 'Réduction Spéciale Estimée');

define('TEXT_CART_ADD_WISHLIST_SUCCESS', 'Produit (s) ajouté(s) à votre liste de favoris avec succès! ');
define('TEXT_CART_VIEW_WISHLIST', 'Voir la liste de favoris');
define('TEXT_CART_AVAILABLE_PAYMENT', 'Modes de paiement disponibles');

define('TEXT_QUESTION_SUBMIT','Soumettre');
define('CHECKOUT_ADDRESS_BOOK_CANCEL','Cancel');
define('TEXT_NOTE_MAXCHAAR','<b id="rest_characters">254</b> caractères restants');
define('TEXT_MORE', 'More');
define('TEXT_LESS', 'Less');

// readd deleted products into the cart
define('HAS_BEEN_REMOVED', ' a été supprimé de votre panier.');
define('RE_ADD', 'Rajoutez-le');

define('TEXT_CART_GO_SHOPPING', 'Continuer les achats');
define('TEXT_CART_SAVE_PRICE', 'Le prix original est %s. Remise %s.');
//define('TEXT_ORDER_SUMMARY', 'Résumé de la Commande');
define('TEXT_HANDING_FEE_WORDS','Frais de Traitement');
define('TEXT_SHIPPING_FEE_WORDS','Frais de livraison');
define('TEXT_SHIPPING_FEE_CHANGE_METHOD_TIPS','Vous pouvez modifier les moyens de livraison dans la page de Confirmation.');
?>