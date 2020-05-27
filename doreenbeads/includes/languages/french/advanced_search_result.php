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
// $Id: advanced_search_result.php 1969 2005-09-13 06:57:21Z drbyte $
// +----------------------------------------------------------------------+
// | Traduction française de Zen Cart 1.3.9 par Zen Cart France.                  |
// | Auteur : Damien Desrousseaux : http://www.zencart-france.com             |
// | Package : zen-cart-v1.3.9-FR                                        |
// +----------------------------------------------------------------------+
//


  define('NAVBAR_TITLE_1', 'Recherche Avanc&eacute;e');
  define('NAVBAR_TITLE_2', 'R&eacute;sultats de recherche');

//  define('HEADING_TITLE_1', 'Recherche Avanc&eacute;e');
  define('HEADING_TITLE', 'Recherche Avanc&eacute;e');

  define('HEADING_SEARCH_CRITERIA', 'Crit&egrave;res de Recherche');

  define('TEXT_SEARCH_IN_DESCRIPTION', 'Chercher dans les descriptions de produits');
  define('ENTRY_CATEGORIES', 'Cat&eacute;gories :');
  define('ENTRY_INCLUDE_SUBCATEGORIES', 'Inclure les Sous-Cat&eacute;gories');
  define('ENTRY_MANUFACTURERS', 'Fabricants :');
  define('ENTRY_PRICE_FROM', 'Prix depuis :');
  define('ENTRY_PRICE_TO', 'Prix maximum :');
  define('ENTRY_DATE_FROM', 'Depuis la date :');
  define('ENTRY_DATE_TO', 'Date maximum :');

  define('TEXT_SEARCH_HELP_LINK', '<u>Aide</u> [?]');

  define('TEXT_ALL_CATEGORIES', 'Toutes les cat&eacute;gories');
  define('TEXT_ALL_MANUFACTURERS', 'Tous les fabricants');

  define('HEADING_SEARCH_HELP', 'Aide &agrave; la recherche');
  define('TEXT_SEARCH_HELP', 'Les mots-cl&eacute;s peuvent &ecirc;tre s&eacute;par&eacute;s par les liaisons AND et/ou OR pour des recherche avanc&eacute;es.<br /><br />Par exemple, Microsoft AND souris donnera les r&eacute;sultats qui contiennent les deux mots. Par contre, pour souris OR clavier, les r&eacute;sultats contiendront l’un des deux mots ou les deux.<br /><br />Vous pouvez chercher des occurences de mots exactes en mettant des guillemets.<br /><br />Par exemple, "ordinateur portable" ne trouvera que les r&eacute;sultats qui contiennent cette chaine de caract&egrave;res exacte.<br /><br />Des parenth&egrave;ses peuvent &ecirc;tre utlis&eacute; pour faire des recherches encore plus pr&eacute;cises.<br /><br />Par exemple, Microsoft AND (clavier OR souris OR "visual basic").');
  define('TEXT_CLOSE_WINDOW', '[ Fermer la fen&ecirc;tre [x] ]');

  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Mod&egrave;le');
  define('TABLE_HEADING_PRODUCTS', 'Nom du Produit');
  define('TABLE_HEADING_MANUFACTURER', 'Fabricant');
  define('TABLE_HEADING_QUANTITY', 'Quantit&eacute;');
  define('TABLE_HEADING_PRICE', 'Prix');
  define('TABLE_HEADING_WEIGHT', 'poids');
  define('TABLE_HEADING_BUY_NOW', 'Acheter');

  define('TEXT_NO_PRODUCTS', 'Aucun Produit ne correspond aux crit&egrave;res de recherche...');

  define('ERROR_AT_LEAST_ONE_INPUT', 'Veuillez remplir au moins un des champs du formulaire de recherche.');
  define('ERROR_INVALID_FROM_DATE', 'Date invalide.'); 
  define('ERROR_INVALID_TO_DATE', 'Date invalide.'); 
  define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', 'La date maximum doit &ecirc;tre sup&eacute;rieure &agrave; "Depuis la date".'); 
  define('ERROR_PRICE_FROM_MUST_BE_NUM', 'Le prix doit &ecirc;tre un nombre !'); 
  define('ERROR_PRICE_TO_MUST_BE_NUM', 'Le prix doit &ecirc;tre un nombre !'); 
  define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 'Le prix maximum doit &ecirc;tre plus grand ou &eacute;gal au prix de d&eacute;part.');
  define('ERROR_INVALID_KEYWORDS', 'Mots-clefs invalides.');
?>