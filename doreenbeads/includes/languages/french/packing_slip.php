<?php
define('NAVBAR_TITLE_1', 'Mon Compte');
define('NAVBAR_TITLE_2', 'Liste d’Emballage');
define('TEXT_PACKING_SLIP' , 'Liste d’Emballage');
define('PRODUCTS_NO_ALT','Artikel schnell hinzufügen');
define('TABLE_HEADING_ORDER_NUMBER', 'N° de commande');
define('TABLE_HEADING_TACKING_NUMBER', 'Numéro de suivi');
define('TABLE_HEADING_DATE', 'Date de passer la commande');
define('HEADING_ITEM', 'Articles');
define('TEXT_BOUNGHT_QUANTITY', 'Quantité Achetée');
define('TEXT_SENT_QUANTITY', 'Quantité Envoyée');
define('TEXT_UNSENT_QUANTITY', 'Quantité Non Envoyée');
define('TEXT_NO_RESULT_PACKING_SLIP', 'Aucun résultat! Veuillez réinitialiser vos informations. ');

define('TEXT_DOWNLOAD_PACKINGLIST_INFO', '<span style="font-family:verdana;font-size:12px;">Télécharger la <a href="' . HTTP_SERVER . $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] . '&export=true' . '" style="text-decoration:underline">Pliste d’emballage</a> (.xlsx) ici.</span>');
define('TEXT_PACKAGE_SLIP_TIP_1', 'Vous pouvez rechercher une liste d’emballage. Veuillez remplir les informations requises et cliquer sur le bouton "Soumettre".<br/>(Remarque: en raison de la fonction du système, seul le bordereau d’emballage après le 3 mai, 2017 pourrait être recherché)');
define('TEXT_PACKAGE_SLIP_TIP_2', 'Si vous avez besoin des détails des articles non expédiés, <a class="link_text" href="' . zen_href_link(FILENAME_ACCOUNT) . '">cliquez ici</a> pour trouver la commande que vous désirez dans la liste de commandes, et consultez la page de détail de la commande.');
?>