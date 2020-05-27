<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: index.php 6550 2007-07-05 03:54:54Z drbyte $
 */

define('TEXT_MAIN','C’est la principale déclaration de définir la page en anglais quand il n’existe pas de modèle de ficher pour définir. Il se trouve dans: <strong>/inclus/langues/anglais/index.php</strong>');

// Vitrine vs magasin
if (STORE_STATUS == '0') {
  define('TEXT_GREETING_GUEST', 'Bienvenue <span class="greetUser">Client!</span> Voulez-vous <a href="%s">vous connecter à</a>?');
} else {
  define('TEXT_GREETING_GUEST', 'Bienvenue, veuillez bien profiter de notre vitrine en ligne.');
}

define('TEXT_GREETING_PERSONAL', 'Bonjour <span class="greetUser">%s</span>! Voulez-vous consulter nos <a href="%s">nouveaux arrivés</a>?');

define('TEXT_INFORMATION', 'Définissez la copie de la page de votre index principal ici');

//Déplacé vers anglais
//define('TABLE_HEADING_FEATURED_PRODUCTS','Produits recommandés');

//define('TABLE_HEADING_NEW_PRODUCTS', 'Nouveux produits pour %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Produits prochains');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date prévue');

if ( ($category_depth == 'produits') || (zen_check_url_get_terms()) ) {
  // Cette section concerne la page de la liste des produits.
  define('HEADING_TITLE', 'Produits disponibles');
  define('TABLE_HEADING_IMAGE', 'Image du produit');
  define('TABLE_HEADING_MODEL', 'Numéro de référence');
  define('TABLE_HEADING_PRODUCTS', 'Nom du produit');
  define('TABLE_HEADING_MANUFACTURER', 'Fabricant');
  define('TABLE_HEADING_QUANTITY', 'Quantité');
  define('TABLE_HEADING_PRICE', 'Prix');
  define('TABLE_HEADING_WEIGHT', 'Poids');
  define('TABLE_HEADING_BUY_NOW', 'Acheter maintenant');
  define('TEXT_NO_PRODUCTS', 'Il n’a y pas de produit dans cette catégorie.');
  define('TEXT_NO_PRODUCTS2', 'Il n’y a pas de produit disponible chez ce fabricant.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Nombre des produits: ');
  define('TEXT_SHOW', 'Filtrer les résultats par:');
  define('TEXT_BUY', 'Acheter 1 ’');
  define('TEXT_NOW', '’ maintenant');
  define('TEXT_ALL_CATEGORIES', 'Toutes les catégorie');
  define('TEXT_ALL_MANUFACTURERS', 'Tous les fabricants');
} elseif ($category_depth == 'top') {
  // Cette section concerne la page d'accueil haut niveau  sans les options / produits sélectionnés.
  /*Remplacez ce texte avec le titre que vous souhaitez pour votre boutique. Par exemple: 'Bienvenue dans ma boutique!'*/
  define('HEADING_TITLE', '');
} elseif ($category_depth == 'nested') {
  //Cette section concerne l'affichage d'une sous-catégorie
  /*Remplacez ce lien avec le titre que vous souhaitez pour votre boutique. Par exemple: 'Bienvenue dans ma boutique!'*/
  //---------------------------
  // Robbie 2009-08-05
  // Supprimer l'affichage sur la page principale "Félicitation!......" 
  //----------------------------
  //define('HEADING_TITLE', 'Félicitation!......'); 
  define('HEADING_TITLE', ''); 
  //eof robbie
}
?>