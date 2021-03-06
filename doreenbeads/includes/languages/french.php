<?php
@setlocale ( LC_TIME, 'en_US.utf8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

if (! function_exists('zen_date_raw')) {
	function zen_date_raw($date, $reverse = false) {
		if ($reverse) {
			return substr ( $date, 3, 2 ) . substr ( $date, 0, 2 ) . substr ( $date, 6, 4 );
		} else {
			return substr ( $date, 6, 4 ) . substr ( $date, 0, 2 ) . substr ( $date, 3, 2 );
		}
	}
}

define('TEXT_PAYMENT_PROMPT',"Il est préférable de soumettre votre reçu de paiement pour nous aider à confirmer l’information.");
define('TEXT_PAYMENT_HSBS_CHINA','<p>1. Lors du transfert d’argent vers nous, veuillez entrer le numéro de commande dans la colonne des remarques du formulaire de virement bancaire.</p>
<p>2. Veuillez nous <a href="mailto:service_fr@doreenbeads.com" style="color:#008FED;">envoyer les informations de paiement</a> après que vous transférez de l’argent, alors nous pourrions confirmer l’argent que vous avez transféré et expédier votre colis le plus tôt que possible.</p>
<p>3. Nous offrons une réduction de 2% pour toutes les commandes avec le montant total supérieur à 2000 $, les frais de commission doivent être payés par l’auteur de virements.</p>');
// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead
// of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');
define('TEXT_REGULAR_AMOUNT','Regular amount');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'discounted-priced amount');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="en"');
define('TEXT_QUESEMAIL_NAME', 'Nom du Client');
// charset for web pages and emails
define('CHARSET', 'utf-8');
define('TEXT_TIME','fois');
define('DISCRIPTION', 'Description');
define('TEXT_CREATE_MEMO','Memo');
define('TEXT_HEADER_MY_ACCOUNT','Mon Compte');
define('TEXT_NO_WATERMARK_PICTURE', 'Service d\'Images non-filigranées');

define('TEXT_TEL_NUMBER', '(+86) 571-28197839 ');
define('CHECKOUT_ZIP_CODE_ERROR', 'Veuillez vérifier votre code postal. Le format correct(p. ex.):');
define('TEXT_OR', 'ou');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate,
// Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME', 'Coupon de Réduction');
define('TEXT_GV_NAMES', 'Coupon de Réduction');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM', 'Code de Profiter du Coupon');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME );
define('BOX_GV_REDEEM_INFO', 'Code de Profiter du Coupon: ');

// text for gender
define('MALE', 'M.');
define('FEMALE', 'Mlle.');
define('TEXT_MALE','Homme');
define('TEXT_FEMALE','Femme');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Mlle.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// text for sidebox heading links
define('BOX_HEADING_LINKS', '');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Categoriés');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Fabricants');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Nouveatés');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Nouveatés ...');
define('HEADER_TITLE_PACKING_SLIP', 'Liste d’Emballage');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Populaire');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Produits Populaires ...');
define('TEXT_NO_FEATURED_PRODUCTS', '');

define('TEXT_NO_ALL_PRODUCTS', 'Plus de Produits populaires seront bientôt ajoutés. S’il vous plaît revenez plus tard..');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Tous les produits ...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Rechercher');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Recherche avancée');

// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Spécials');
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Spécials ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Avis');
define('BOX_REVIEWS_WRITE_REVIEW', 'Ecrire vos avis sur ce produit.');
define('BOX_REVIEWS_NO_REVIEWS', 'Il n’y a aucune avis sur ce produit en ce moment.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s de 5 Etoiles!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Panier');
define('BOX_SHOPPING_CART_EMPTY', 'Votre Panier est Vide.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Repasser la commande rapidement');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Meilleures Ventes');
define('BOX_HEADING_BESTSELLERS_IN', 'Meilleures Ventes dans<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Notifications');
define('BOX_NOTIFICATIONS_NOTIFY', 'Me notifier des mises à jour de <strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Ne me notifier des mises à jour de<strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Infos de Fabricants');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Accueil');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'D’autres Produits');

// languages box text in sideboxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Languages');

define('TEXT_PROMOTION', 'Promotion');

// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Monnaies');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Informations');
define('BOX_INFORMATION_PRIVACY', 'Confidentialité');
define('BOX_INFORMATION_CONDITIONS', 'Conditions de profiter');
define('BOX_INFORMATION_SHIPPING', 'Livraison &amp; Retours');
define('BOX_INFORMATION_CONTACT', 'Contacter-nous');
define('BOX_BBINDEX', 'Forum');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Se Désabonner la Newsletter');

define('BOX_INFORMATION_SITE_MAP', 'Carte de Site');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'En savoir plus');
define('BOX_INFORMATION_PAGE_2', 'Page 2');
define('BOX_INFORMATION_PAGE_3', 'Page 3');
define('BOX_INFORMATION_PAGE_4', 'Page 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Recommander à un ami');
define('BOX_TELL_A_FRIEND_TEXT', 'Recommander ce produit à un ami.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'Mes Favoris');
define('BOX_WISHLIST_EMPTY', 'Il n’y a pas de produit dans vos Favoris');
define('IMAGE_BUTTON_ADD_WISHLIST', 'Ajouter aux Favoris');
define('TEXT_MOVE_TO_WISHLIST', 'Déplacer à mes favoris');
define('TEXT_WISHLIST_COUNT', 'Actuellement %s produits sont dans vos favoris.');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Montrer les produits dans vos favoris <strong>%de</strong> à <strong>%d</strong> (of <strong>%d</strong> )');

// New billing address text
define('SET_AS_PRIMARY', 'Définir comme adresse par défaut');
define('NEW_ADDRESS_TITLE', 'Adresse de facturation');
// javascript messages
define('JS_ERROR', 'Erreurs se sont produites lors du traitement de votre formulaire.\n\n S’il vous plaît apporter les corrections suivantes:\n\n');

define('JS_REVIEW_TEXT', '* Veuillez ajouter quelques mots à vos avis. Il faut comporter au moins ' . REVIEW_TEXT_MIN_LENGTH . ' caractères.');
define('JS_REVIEW_RATING', '* Veuillez choisir une note pour cet article.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Veuillez sélectionner un mode de paiement pour votre commande.');

define('JS_ERROR_SUBMITTED', 'Ce formulaire a déjà été soumis. S’il vous plaît cliquez sur OK et attendez que ce processus soit achevé.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', ' Veuillez sélectionner un mode de paiement pour votre commande.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Veuillez confirmer les termes et conditions liés à cette commande en cochant la case ci-dessous.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Veuillez confirmer la déclaration de confidentialité en cochant la case ci-dessous.');

define('CATEGORY_COMPANY', 'Infos concernant notre société');
define('CATEGORY_PERSONAL', 'Vos infos privées');
define('CATEGORY_ADDRESS', 'Votre Adresse');
define('CATEGORY_CONTACT', 'Vos informations de contact');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Votre mot de passe');
define('CATEGORY_LOGIN', 'Se Connecter');
define ( 'CREATE_NEW_ACCOUNT', 'Créer un nouveau compte' );
define('TEXT_NEW_CUSTOMER','Nouveau Client');
define('TEXT_RETURN_CUSTOMER','Client de Retour');
define('TEXT_PLACEHOLDER1','Adresse e-mail ou numéro de téléphone');
define('TEXT_PLACEHOLDER2','Entrez votre compte paypal');
define('PULL_DOWN_DEFAULT', 'Pays');
define('PLEASE_SELECT', 'Veuillez Sélectionner ...');
define('TYPE_BELOW', 'Taper un choix ci-dessous ...');

define('ENTRY_COMPANY', 'Nom de votre société:');
define('ENTRY_COMPANY_ERROR', 'Veuillez entrer le nom d’une société.');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Salutation:');
define('ENTRY_GENDER_ERROR', 'Veuillez choisir une salutation.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Prénom:');
define('ENTRY_FIRST_NAME_ERROR', 'Veuillez taper votre prénom (au moins 1 caractère).'); 
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Nom:');
define('ENTRY_LAST_NAME_ERROR', 'Veuillez taper votre nom (au moins 1 caractère).');
define('ENTRY_FL_NAME_SAME_ERROR', 'Vous avez le même nom et prénom, veuillez le modifier.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date de naissance:');

define('ENTRY_DATE_OF_BIRTH_ERROR', 'La date précise et complète (Year-Month-Day) est nécessaire pour l’enregistrement');
define('ENTRY_DATE_OF_BIRTH_TEXT', '*');
define('ENTRY_EMAIL_ADDRESS',  'Adresse E-mail');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Adresse e-mail non valable. Il doit contenir au moins 6 caractères. Veuillez réessayer.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','Désolé, mon système ne comprends pas votre adresse d&acute;email.  Réessayez.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Notre système a déjà un enregistrement de cette adresse e-mail - s’il vous plaît essayez de vous connecter avec cette adresse e-mail. Si vous n’utilisez plus cette adresse vous pouvez le corriger dans la zone Mon Compte.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS_MOBILE', 'Votre E-mail est déjà enregistré sur notre site - <a href="'.zen_href_link(FILENAME_LOGIN).'">Identifiez-vous</a> directement.');  
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', 'Pseudo en Forum:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input
                                   // field
define('ENTRY_NICK_DUPLICATE_ERROR', 'Ce pseudo est déjà utilisé.Veuillez essayer avec un autre.');
define('ENTRY_NICK_LENGTH_ERROR', 'Veuilez essayer de nouveau. Votre pseudo doit contenir au moins ' . ENTRY_NICK_MIN_LENGTH . ' caractères.');
define('ENTRY_STREET_ADDRESS', 'Le nom de la route:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Le nom de la route doit comporter au moins ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caractères.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Adresse Ligne 2:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Zip/Code Postal:');
define('ENTRY_POST_CODE_ERROR', 'Votre Zip/Code Postal Code doit comporter au moins ' . ENTRY_POSTCODE_MIN_LENGTH . ' chiffres.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Ville:');
define('ENTRY_CUSTOMERS_REFERRAL', 'Code de Parrainage:');
define('ENTRY_CITY_ERROR', 'Le nom de votre ville doit comporter au moins ' . ENTRY_CITY_MIN_LENGTH . ' caractères.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Province:');
define('ENTRY_STATE_ERROR', 'Le nom de votre province doit comporter au moins ' . ENTRY_STATE_MIN_LENGTH . ' caractères.');
define('ENTRY_STATE_ERROR_SELECT', 's’il vous plaît sélectionner une province des provinces menu déroulant.');
define('ENTRY_EXISTS_ERROR', 'Cette adresse existe déjà.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- Veuillez séletionner --');
define('ENTRY_COUNTRY', 'Pays:');
define('ENTRY_COUNTRY_ERROR', 'Vous devez sélectionner un pays des pays dans le menu déroulant.');
define('ENTRY_AGREEN_ERROR_SELECT', "Vous n’êtes pas converti<a href=\'page.html?id=137\'target=\'_blank\' style=\'color:#900;text-decoration:underline\'> aux Termes et Conditions de Doreenbeads.com</a>");
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_PUERTORICO_ERROR', 'Vous devez sélectionner "Puerto Rico" des pays dans le menu déroulant en tant que pays, pour votre province est "Puerto Rico".');
define('ENTRY_TELEPHONE_NUMBER', 'Téléphone:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Votre numéro de téléphone doit contenir un minimum de ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caractères.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Numéro de Fax:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Abonnez-vous à notre newsletter.');
define('ENTRY_NEWSLETTER_TEXT', 'S’abonner');
define('ENTRY_NEWSLETTER_YES', 'Abonné');
define('ENTRY_NEWSLETTER_NO', 'Désabonné');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Mot de passe:');
define('ENTRY_PASSWORD_ERROR', "Cela devrait être d’au moins 5 caractères (doit contenir des lettres et des chiffres).");
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'La confirmation de mot de passe doit correspondre à votre mot de passe.');
define('ENTRY_PASSWORD_TEXT', '* (Au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Confirmer le mot de passe:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Mot de passe du moment:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Votre nouveau mot de passe doit comporter au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.');
define('ENTRY_PASSWORD_NEW', 'Nouveau Mode de Passe:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Votre nouveau mot de passe doit comporter au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'La confirmation de passe de passe doit correspondre à votre nouveau mot de passe.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

define('FORM_REQUIRED_INFORMATION', '* Infos demandées');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Montrer <strong>%de</strong> à <strong>%d</strong> ( de<strong>%d</strong>)des produits');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Montrer<strong>%d</strong> à <strong>%d</strong> (de <strong>%d</strong> commandes)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Montrer <strong>%d</strong> à <strong>%d</strong> (de <strong>%d</strong> avis)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Montrer<strong>%d</strong> à <strong>%d</strong> (de <strong>%d</strong> nouveautés)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Montrer <strong>%d</strong> à <strong>%d</strong> (de <strong>%d</strong> spécials)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Montrer <strong>%d</strong> à <strong>%d</strong> (de <strong>%d</strong> produits populaires)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Montrer <strong>%d</strong> à <strong>%d</strong> (de <strong>%d</strong>produits)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Premières Page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Page Précédente');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Page Suivante');
define('PREVNEXT_TITLE_LAST_PAGE', 'Dernière Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Set précédent de Pages%d ');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Set suivant de Pages%d ');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[<< Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next >>]');
define('PREVNEXT_BUTTON_LAST', 'LAST>>');
define('PREVNEXT_BUTTON_NEXT_NEW', 'Suivant');

define('TEXT_BASE_PRICE', 'Commencer avec: ');

define('TEXT_CLICK_TO_ENLARGE', 'Agrandir l’image');

define('TEXT_SORT_PRODUCTS', 'Trier les produits ');
define('TEXT_DESCENDINGLY', 'Décroissant');
define('TEXT_ASCENDINGLY', 'Croissant');
define('TEXT_BY', ' Par ');

define('TEXT_REVIEW_BY', ' %s');
define('TEXT_REVIEW_WORD_COUNT', '%s mots');
define('TEXT_REVIEW_RATING', 'Evaluation: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date ajoutée: %s');
define('TEXT_NO_REVIEWS', 'Il n’y a aucun avis concernant ce produit.');

define('TEXT_NO_NEW_PRODUCTS','Désolé, aucun produit n’a été trouvé. Vous pouvez essayer de filtrer par d’autres conditions.');

define('TEXT_UNKNOWN_TAX_RATE', 'Taxes');

define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Attention: le répertoire d’installation existe à:%s. S’il vous plaît supprimer ce répertoire pour des raisons de sécurité');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Attention: Il est possible d’écrire sur le fichier de configuration:%s. Ceci est un risque potentiel pour la sécurité - s’il vous plaît définir les bonnes permissions sur ce fichier (en lecture seule, avec un CHMOD 644 ou 444). Vous devrez peut-être utiliser votre panneau de contrôle d’hébergeur / gestionnaire de fichiers pour changer les permissions efficacement. Contactez votre hébergeur pour de l’aide. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">Voir les FAQ</a>');

define('ERROR_FILE_NOT_REMOVEABLE', 'Erreur: Impossible de supprimer le fichier spécifié. Vous pourriez avoir à utiliser FTP pour supprimer le fichier, en raison d’une limitation de la configuration serveur-des autorisations.');
define ('WARNING_SESSION_DIRECTORY_NON_EXISTENT',' Attention:il n’existe pas Le répertoire de session : '. zen_session_save_path () . ' Les sessions ne fonctionneront pas tant que ce répertoire est créé . ');
define ('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE',' Attention: je ne suis pas capable d’écrire dans le répertoire de session :'.zen_session_save_path () . '. Les sessions ne fonctionneront pas jusqu’à ce que les bonnes permissions sont définies. . . . ') ;
define ('WARNING_SESSION_AUTO_START',' Attention: session.auto_start est activé - s’il vous plaît désactiver cette fonction PHP dans le fichier php.ini et redémarrez le serveur Web . ');
define ('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT',' Attention: n’existe pas Le répertoire de téléchargement des produits : '. DIR_FS_DOWNLOAD . '. produits téléchargeables ne fonctionnera qu’avec un répertoire valide . . ');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT',' Attention: il n’existe pas le répertoire de cache SQL : ' .DIR_FS_SQL_CACHE . 'cache SQL ne fonctionnera pas tant que ce répertoire est créé . ') ;
define ('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE',' Attention: je ne suis pas capable d’écrire dans le répertoire de cache SQL : ' . '. . . cache SQL ne fonctionnera pas jusqu’à ce que les bonnes permissions sont définies ' . DIR_FS_SQL_CACHE ) ;
define ('WARNING_DATABASE_VERSION_OUT_OF_DATE', '. Votre base de données semble avoir besoin de patcher à un niveau plus élevé Voir Admin-> Outils - > Information Server d’examiner les niveaux de patch . ') ;
define ('WARNING_COULD_NOT_LOCATE_LANG_FILE',' AVERTISSEMENT : Impossible de trouver le fichier de langue :');

define ('TEXT_CCVAL_ERROR_INVALID_DATE', ' La date d’expiration est entré pour la carte de crédit n’est pas valide S’il vous plaît vérifier la date et essayez à nouveau . ') ;
define ('TEXT_CCVAL_ERROR_INVALID_NUMBER', ' Le numéro de carte de crédit indiquée est invalide S’il vous plaît vérifier le nombre et essayez à nouveau . ') ;
define ('TEXT_CCVAL_ERROR_UNKNOWN_CARD', '. Le numéro de carte de crédit à partir de %s n’a pas été entré correctement , ou que nous n’acceptons pas ce genre de carte S’il vous plaît essayer de nouveau ou utiliser une autre carte de crédit . ') ;
define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Coupon de Réduction');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Balance ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Compte');
define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
define('ERROR_REDEEMED_AMOUNT', 'Félicitations, vous en avez profité ');
define('ERROR_NO_REDEEM_CODE', 'Vous n’avez pas entré ' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM );
define('TABLE_HEADING_CREDIT', 'Crédits Disponibles');
define('GV_HAS_VOUCHERA', 'Vous avez des promos dans votre ' . TEXT_GV_NAME . ' Compte. Si vous voulez, <br />vous pouviez envoyer les promos <a class="pageResults" href="');
define('GV_HAS_VOUCHERB', '"><strong>e-mail</strong></a> à quelqu’un');
define('ENTRY_AMOUNT_CHECK_ERROR', 'Vous n’avez pas assez de fonds pour envoyer ce montant.');
define('BOX_SEND_TO_FRIEND', 'Send ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' Profité');
define('CART_COUPON', 'Coupon :');
define('CART_COUPON_INFO', 'En savoir plus');
define('TEXT_SEND_OR_SPEND', 'Vous avez des promos dans votre ' . TEXT_GV_NAME . ' compte. Vous pouvez en profiter ou l’envoyer à quelqu’un d’autre. Pour envoyer cliquez sur le bouton ci-dessous.');
define('TEXT_BALANCE_IS', 'Votre ' . TEXT_GV_NAME . ' Solde est: ');
define('TEXT_AVAILABLE_BALANCE', 'Votre ' . TEXT_GV_NAME . ' Compte');

define('TABLE_HEADING_PAYMENT_METHOD', 'Mode de paiement');
// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Coupon');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Promos Disponibles');

define('TEXT_INVALID_REDEEM_COUPON', 'Code de Coupon Invalid');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Le montant doit atteindre %s pour profiter de ce coupon');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM_1', '%s coupon sera disponible si le montant atteint %s.');
define('TEXT_INVALID_STARTDATE_COUPON', 'Ce coupon n’est pas encore disponible');
define('TEXT_INVALID_FINISHDATE_COUPON', 'Ce coupon est expiré');
define('TEXT_INVALID_USES_COUPON', 'Ce conpon est juste pour en profiter ');
define('TIMES', ' Fois.');
define('TIME', ' Fois.');
define('TEXT_INVALID_USES_USER_COUPON', 'Vous avez utilisé le code coupon:%s le nombre maximum autorisé par client. ');
define('REDEEMED_COUPON', 'Valeur d’un coupon ');
define('REDEEMED_MIN_ORDER', 'Pour le montant atteint');
define('REDEEMED_RESTRICTIONS', ' [Product-Category restrictions apply]');
define('TEXT_ERROR', 'Une erreur s’est produite');
define('TEXT_INVALID_COUPON_PRODUCT', 'Ce code de coupon n’est pas valable pour tout produit actuellement dans votre panier.');
define('TEXT_VALID_COUPON', 'Félicitations! Vous avez profité de ce coupon');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Le code de coupon que vous avez entré n’est pas valide pour l’adresse que vous avez sélectionné.');

// more info in place of buy now
define('MORE_INFO_TEXT', '... En savoir plus');

// IP Address
define('TEXT_YOUR_IP_ADDRESS', 'Votre adresse IP est:');

// Generic Address Heading
define('HEADING_ADDRESS_INFORMATION', 'Infos d’Adresse');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Quantité dans le panier: ');
define('PRODUCTS_ORDER_QTY_TEXT', 'Ajouter au panier: ');

define('TEXT_PRODUCT_WEIGHT_UNIT', 'grammes');

// Shipping
// jessa 2009-08-11
// update define('TEXT_SHIPPING_WEIGHT','lbs');
define('TEXT_SHIPPING_WEIGHT', 'grammes');
define('TEXT_SHIPPING_BOXES', 'Boîtes');
// eof jessa

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Garder: ');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '-%');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', ' Réduction');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE', 'Sale:&nbsp;');

// universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX', 'Sponsors');
define('TEXT_BANNER_BOX', 'Please Visit Our Sponsors ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2', 'Have you seen ...');
define('TEXT_BANNER_BOX2', 'Check this out today!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL', 'Sponsors');
define('TEXT_BANNER_BOX_ALL', 'Veuillez visiter notre Sponsors ...');

// boxes defines
define('PULL_DOWN_ALL', 'Veuillez sélectionner');
define('PULL_DOWN_MANUFACTURERS', '- Reset -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Veuillez sélectionner');

// general Sort By
define('TEXT_INFO_SORT_BY', 'Trier par: ');

// close window image popups
define('TEXT_CLOSE_WINDOW', ' - Cliquez sur l’image pour la fermer');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Close Window ]');

// iii 031104 added: File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Erreur: Type de fichier non autorisé.');
define('WARNING_NO_FILE_UPLOADED', 'Attention: pas de fichier téléchargé.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Succès: fichier enregistré avec succès.');
define('ERROR_FILE_NOT_SAVED', 'Erreur: fichier non enregistré.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Erreur: destination pas inscriptible.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Erreur: Destination non existée.');
define('ERROR_FILE_TOO_BIG', 'Attention: Fichier trop grand pour télécharger <br /> commande peut être placé, mais s’il vous plaît contacter le site à l’aide de téléchargement de photos!');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'NOTICE: Ce site est prévu pour être en maintenance sur: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'NOTICE: Le site est actuellement en maintenance');

define('PRODUCTS_PRICE_IS_FREE_TEXT', 'C’est gratuit!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Contacter pour le prix');
define('TEXT_CALL_FOR_PRICE', 'Contacter pour le prix');

define('TEXT_INVALID_SELECTION', ' Vous avez choisi une sélection invalide: ');
define('TEXT_ERROR_OPTION_FOR', ' Option pour: ');
define('TEXT_INVALID_USER_INPUT', 'Utilisateur Input Demandé<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Min: ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Unités: ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'Dans le Panier:');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Ajouter complémentaires:');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Max:');

define('TEXT_PRODUCTS_MIX_OFF', '*Mix Fermé');
define('TEXT_PRODUCTS_MIX_ON', '*Mix Autorisé');

define ('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br /> * Vous ne pouvez pas mélanger les options sur ce point pour répondre aux exigences de quantité minimale * <br />.'); 
define ('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '* Option Mixte valeurs est ON <br />'); 

define ('ERROR_MAXIMUM_QTY', 'La quantité ajouté à votre panier a été modifié en raison d’une restriction à maximum que vous êtes autorisé Voir cet article:.'); 
define ('ERROR_CORRECTIONS_HEADING', "S’il vous plaît corriger les suivantes: <br /> "); 
define ('ERROR_QUANTITY_ADJUSTED', '. La quantité ajoutée à votre panier a été ajustée L’article que vous vouliez n’est pas disponible en quantités fractionnaires La quantité de l’article:.'); 
define ('ERROR_QUANTITY_CHANGED_FROM', ', a été modifié à partir de:'); 
define ('ERROR_QUANTITY_CHANGED_TO',' à');
// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'REMARQUE: Téléchargements ne sont pas disponibles jusqu’à ce que le paiement a été confirmé');
define('TEXT_FILESIZE_BYTES', ' bytes');
define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
define('ERROR_PRODUCT', 'Le produit: ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br />Nous sommes désolés mais ce produit a été retiré de notre inventaire en ce moment. <br /> Cet article a été retiré de votre panier.');
define('ERROR_PRODUCT_QUANTITY_MIN', ' ...Les erreurs de quantité minimale - ');
define('ERROR_PRODUCT_QUANTITY_UNITS', ' ... Quantité Unités erreurs - ');
define('ERROR_PRODUCT_OPTION_SELECTION', '<br /> ... Les valeurs des options non valides sélectionnés ');
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br /> Vous avez commandé un total de: ');
define('ERROR_PRODUCT_QUANTITY_MAX', ' ... Les erreurs de quantité maximale - ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ', a une restriction de quantité minimum. ');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', ' ...  Quantité Unités erreurs - ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', ' ...Les erreurs de quantité maximale  - ');

define('WARNING_SHOPPING_CART_COMBINED', 'Note: Vous payerez tous les articles dans ce panier, qui a été combiné avec les articles que vous avez ajoutés précédemment. Alors s’il vous plaît vérifier votre panier avant de payer.');

// error on checkout when $_SESSION['customers_id' does not exist in customers
// table
define('ERROR_CUSTOMERS_ID_INVALID', 'Informations client ne peut pas être validé! <br /> S’il vous plaît connecter ou de recréer votre compte ...');

define('TABLE_HEADING_FEATURED_PRODUCTS', '<a href="featured_products.html" id="featured_products">Produits Populaires</a>');

define('TABLE_HEADING_NEW_PRODUCTS', '<a href="products_new.html" id="products_new">New Products For %s</a>');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Produits à l’avenir');
define('TABLE_HEADING_DATE_EXPECTED', 'Date prévu');
// define('TABLE_HEADING_SPECIALS_INDEX', '<a href="specials.html"
// id="specials">Monthly Specials For %s</a>');
define('TABLE_HEADING_SPECIALS_INDEX', '<a href="https://www.doreenbeads.com/40-off-huge-discounts-c-1375.html" id="specials">Réduction Exclusive</a>');
define('CAPTION_UPCOMING_PRODUCTS', 'Ces articles seront en stock bientôt');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS',  'Tableau contient une liste de produits qui sont dues à être bientôt disponible et les dates des articles sont attendus');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'C’est gratuit!');

// customer login
define('TEXT_SHOWCASE_ONLY', 'Contacer Nous');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Prix ​​non disponible');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Connectez-vous pour connaître le prix');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or
                                                      // enter
                                                      // your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'Juste Show Room');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Prix ​​non disponible');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'En Attente');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Connectez-vous pour faire du shopping');

// text pricing
define('TEXT_CHARGES_WORD', 'Frais Calculées:');
define('TEXT_PER_WORD', '<br />Prix ​​par mot: ');
define('TEXT_WORDS_FREE', 'Mot (s) libre ');
define('TEXT_CHARGES_LETTERS', 'Frais Calculées:');
define('TEXT_PER_LETTER', '<br />Prix ​​par lettre: ');
define('TEXT_LETTERS_FREE', ' Letter(s) free ');
define('TEXT_ONETIME_CHARGES', '*onetime charges = ');
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*onetime charges = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Option Réduction Quantité');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'Quantité');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'Prix');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Option Réduction Quantité une fois');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', ' caractères maximum permises');
define('TEXT_REMAINING', 'Restes');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Estimer les frais d’expédition');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Veuillez <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Se Connecter</span></a>, à afficher vos frais d’expédition.');
define('CART_SHIPPING_METHOD_TEXT', 'Modes d’expédition disponibles');
define('CART_SHIPPING_METHOD_RATES', 'Taux');
define('CART_SHIPPING_METHOD_TO', 'Expédier à : ');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Expédier à: <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Livraison Gratuite');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Télécharger');
define('CART_SHIPPING_METHOD_RECALCULATE', 'Re-calculer');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'Vrai');
define('CART_SHIPPING_METHOD_ADDRESS', 'Adresse:');
define('CART_OT', 'Estimer les frais de livraison totals:');
define('CART_OT_SHOW', 'true'); // set to false if you don't want order
                                   // totals
define('CART_ITEMS', 'Produits dans le panier: ');
define('CART_SELECT', 'Sélectionner');
define('ERROR_CART_UPDATE', '<strong>Veuillez continuer le shopping...</strong><br/>');
define('IMAGE_BUTTON_UPDATE_CART', 'Mettre à jour');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Oups! Votre session a expiré ... S’il vous plaît mettre à jour votre panier pour mettre à jour les frais d’expédition ...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Offres d’expédition sont basés sur les informations d’adresse que vous avez sélectionné:');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter: ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter: ');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter: ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter: ');
// moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as
// BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define ( 'TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Prix de réduction(Unité: Lot)' );
define ( 'TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Prix d’escompte par Qté(Unité: Lot)' );
define ( 'TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Prix de réduction(Unité: Lot)' );
define ( 'TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Des réductions peuvent varier en fonction des éléments précités' );
define ( 'TEXT_HEADER_DISCOUNTS_OFF', 'Réductions Non disponible ...' );
// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET', '- RESET - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Nom du produit');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Nom du produit - desc');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Prix - moins cher au plus cher');
define('TEXT_INFO_SORT_BY_QTY_DATE', 'Stock - Du plus au moins');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Prix - du plus cher au moins cher');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'N° de Réf');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Date ajoutée - Des Nouveaux aux anciens');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Date ajoutée- Des anciens aux Nouveaux');
// jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_ORDER', 'Vendu - haut vers bas');
// eof jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Affichage par défaut');
define('TEXT_INFO_SORT_BY_BEST_MATCH','Meilleure Correspondance');
define('TEXT_INFO_SORT_BY_BEST_SELLERS','Best-seller');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Lien Expiré');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Reste');
define('HEADING_DOWNLOAD', 'Pour télécharger vos fichiers, cliquez sur le bouton de téléchargement et choisir "Enregistrer sur le disque" dans le menu contextuel.');
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Nom du fichier');
define('TABLE_HEADING_PRODUCT_NAME', 'Titre d’article');
define('TABLE_HEADING_PRODECT_PRICE', 'Prix');
define('TABLE_HEADING_PRODUCT_IMAGE', 'Photo d’article');
define('TABLE_HEADING_PRODUCT_MODEL', 'N° de réf');
define('TABLE_HEADING_BYTE_SIZE', 'Taille de fichier');
define('TEXT_DOWNLOADS_UNLIMITED', 'Illimité');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Quantité.');
define('TABLE_HEADING_PRODUCTS', 'Titre d’article');
define('TABLE_HEADING_PRICE', 'Prix');
define('TABLE_HEADING_IMAGE', 'Photo d’article');
define('TABLE_HEADING_MODEL', 'N° de réf');
define('TABLE_HEADING_TOTAL', 'Total');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Confidentialité');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'S’il vous plaît reconnaissez que vous êtes d’accord avec notre politique de confidentialité en cochant la case ci-dessous. La déclaration de confidentialité peut être lu <a href="' . zen_href_link ( FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">ici</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'J’ai lu et accepté les à votre déclaration de confidentialité.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Adresse');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Coordonnées supplémentaires');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Vérifiez votre âge');
define('TABLE_HEADING_LOGIN_DETAILS', 'Connexion détails');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Étiez-vous référé à nous?');

define('ENTRY_EMAIL_PREFERENCE', 'Newsletter & Détail d’e-mail');
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY', 'TEXT-Only');
define('EMAIL_SEND_FAILED', 'ERREUR: Impossible d’envoyer un message à: "%s" <%s> avec le sujet: "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Erreur - Impossible de se connecter aux données');

define('TEXT_TRUSTBOX_WIDGET_CONTENT', '<!-- TrustBox widget - Micro Review Count -->
<div style="left: -25px;position: relative;height: 10px;" class="trustpilot-widget" data-locale="fr-FR" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="5742c0810000ff00058d3c5b" data-style-height="50px" data-style-width="100%" data-theme="light">
<a href="https://fr.trustpilot.com/review/doreenbeads.com" target="_blank">Trustpilot</a>
</div>
<!-- End TrustBox widget -->');

// account
define('TEXT_TRANSACTIONS', 'Transactions');
define('TEXT_ORDER_STATUS_PENDING', 'En Attente');
define('TEXT_ALL_ORDERS', 'Toutes les Commandes');
define('TEXT_MY_ORDERS', 'Mes Commandes');
define('TEXT_ORDER_STATUS_PROCESSING', 'Traitement');
define('TEXT_ORDER_STATUS_SHIPPED', 'Expédié');
define('TEXT_UPDATE', 'Mettre à jour');
define('TEXT_ORDER_CANCELED', 'Annulé');
define('TEXT_ORDER_STATUS_UPDATE', 'Mettre à jour');
define('TEXT_DELIVERED', 'Livré');
define('TEXT_ORDER_STATUS_CANCELLED', 'Annulé');
define('TEXT_ORDER_HISTORY', 'Histoire');
define('TEXT_LATESTS', 'Actualités');
define('TEXT_PACKAGE_NUMBER', 'Numéro de Colis');
define('TEXT_RESULT_COST', 'Coût de résultat');
define('TEXT_ACCOUNT_SERVICE', 'Service de Compte');
define('TEXT_MY_TICKETS', 'Messages du système');
define('TEXT_DOWNLOAD_PRICTURES', 'Télécharger les photos');
define('TEXT_ADDRESS_BOOK', 'Carnet d’adresse');
define('TEXT_ACCOUNT_SETTING', 'Installer le Compte');
define('TEXT_ACCOUNT_INFORMATION', 'Installer le Compte');
define('TEXT_ACCOUNT_PASSWORD', 'Mot de passe');
define('TEXT_CASH_ACOUNT', 'Compte de Crédit');
define('TEXT_BLANCE', 'Solde');
define('TEXT_EMAIL_NOTIFICATIONS', 'Notifications d’Email');
define('TEXT_MODIFY_SUBSCRITION', 'Modifier l’abonnement');
define('TEXT_AFFILIATE_PROGRAM', 'Programme d\'affiliation');
define('TEXT_MY_COMMISSION', 'Ma Commission');
define('TEXT_SETTING', 'Einstellung');
define ('TEXT_REQUIRED_FIELDS', 'Indique les champs obligatoires'); 
define ('TEXT_PRODUCTS_NOTIFICATION', 'Notification de produits'); 
define ('ENTRY_SUBURB1', 'Adresse Ligne 1:'); 
define ('TEXT_MAKE_PAYMENT',"Effectuer un paiement "); 
define('TEXT_CART_MOVE_WISHLIST', 'Déplacer à la Liste de Favoris');
define ('TEXT_PAYMENT_QUICK_PEORDER','Réorganiser rapidement'); 
define ('TEXT_PAYMENT_ORDER_INQUIRY', '<a href="mailto:service_fr@doreenbeads.com">Commande Demande</a>'); 
define('TEXT_PAYMENT_TRACK_INFO', 'Informations de suivi');
define ('TEXT_ACTION','Actions'); 
define ('PRODUCTS_QUICK_ORDER_BY_NO', 'Ajouter des Produits Rapidement');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'Attention: EZ-PAGES HEADER - Juste pour IP d’admin');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'Attention: EZ-PAGES FOOTER - Juste pour IP d’admin');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'Attention: EZ-PAGES SIDEBOX - Juste pour IP d’admin');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Articles commencent avec ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '--Remettre--');

define('TEXT_INPUT_RIGHT_CODE', 'Veuillez entrer un code bien valide!');
define('BOX_HEADING_PACKING_SERVICE', 'Service d’emballage');
define('TEXT_PACKING_SERVICE_CONTENT', 'Nous vous offrons l’emballage et le service de traitement pour répondre à vos exigences  spécialex ou des éléments personnalisés.');
define('TEXT_PRODUCT_DETAILS', 'En savoir plus');
define('TEXT_HEADER_MORE', 'Plus');
define('TEXT_HEADER_CLEARANCE', 'Liquidation');
define('TEXT_CLEARANCE', 'Liquidation');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'Il n’y a pas de produit en liquidation');
define('TEXT_CLEARANCE_CATE_HREF', 'Voir tout %s ');
define('TEXT_HEADER_TOP_SELLER', 'Top Ventes');

define('TEXT_PRODUCT_IMAGE', 'Photos de Produits');
define('TEXT_ITEM_NAMES', 'Titre de Produits');
define('TEXT_PRICE_WORDS', 'Prix');
define('TEXT_WEIGHT_WORDS', 'Poids:');
define('TEXT_ADD_WORDS', 'Ajouter:');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'Il n’y a pas de produit en liquidation');

define('TEXT_DHL_REMOTE_FEE', '%s frais supplémentaires à distance via DHL express est nécessaire, SME n’est pas accessible à votre adresse!');
define('TEXT_WIN_POP_TITLE', '');
define('TEXT_WIN_POP_NOTICE', '');

define('NOTE_CHECKOUT_SHIPPING_AIRMAIL', 'Veuillez lire cette note importante >>');
define('NOTE_CHECKOUT_SHIPPING_AIRMAIL_CONTENT', 'A. En raison de la dix-huitième Congrès national du Parti communiste de Chine, colis via la poste aérienne peuvent être retardées pour certains jours. Nous sommes très désolé. Si les articles sont un besoin urgent, s’il vous plaît choisir avec bonté autres méthodes d’expédition. Photos B. Si votre commande contient des montres, s’il vous plaît choisir avec bonté autre type de méthode d’expédition depuis personnalisé ne contrôle très strict sur ​​tout le colis par avion, il n’est pas permis de montres de navires. <br> Pour plus d’informations, contactez-nous via<a href=mailto:service_fr@doreenbeads.com> service_fr@doreenbeads.com</a>.');

// account add items 2013-4-12
define('TEXT_ACCOUNT_SET', 'Modifier le Compte');
define('TEXT_PROFILE_SET', 'Modifier le Profil');
define('TEXT_CHANGE_PASSWORD', 'Modifier le mot de passe');
define('TEXT_CHANGE_EMAIL', 'Modifier l’adresse d’Email');
define('TEXT_AVARTAR', 'Avatar:');
define('TEXT_UPLOAD_FOR_CHECKING', 'Envoyez succès, s’il vous plaît attendre pour examen.');
define('ENTRY_YOUR_BUSINESS_WEB', 'Votre site d’affaires:');
define('ENTRY_CELL_PHONE', 'Téléphone Portable:');
define('TEXT_SUBMIT', 'Soumettre');
define('TEXT_UPLOAD', 'Télécharger');
define('TEXT_CHOOSE_SYSTEM_AVARTAR', 'Choisissez l’image de la base du système');
define('TEXT_UPLOAD_LOCAL_IMG', 'Télécharger des fichiers multimédia à partir de votre ordinateur');
define('TEXT_AVATAR_IS_PUBLIC_TO_OTHERS', 'Note: Votre avatar est visible à d’autres clients sur notre site Web.');
define('TEXT_CROPPED_PICTURE', 'Image recadrée');
define('TEXT_CUT', 'Récolte');
define('TEXT_RECHANGE_PIC', 'RE-sélectionner l’image');
define('ENTRY_YOU_COUNTRY', 'Pays:');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Votre mot de passe actuel ne correspond pas au mot de passe dans nos dossiers. S’il vous plaît essayer à nouveau.');
define('ENTRY_NAME', 'Nom:');

define('TEXT_LANG_YEAR', 'Année');
define('TEXT_LANG_MONTH', 'Mois');
define('TEXT_LANG_DAY', 'Jour');
// END OF account add items 2013-4-12

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'S’enregister à gagner un coupon de <b>US$ 6.01</b> et profiter de la réduction jusqu’à <b>10%</b>');
define('LOGIN_EMAIL_ADDRESS', 'Email:');
define('LENGHT_CHARACTERS', "Cela devrait être d’au moins 5 caractères (doit contenir des lettres et des chiffres).");
define('TEXT_YOUR_COUNTRY', 'Pays: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', "Oui, je souhaite m’abonner à la newsletter pour des offres promotionnelles, top ventes et des nouveautés." );
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'Je me convertis au  <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Termes & Conditions </a> de Doreenbeads.com .');
// end of login items

// account_edit items 2013-4-19
define('TEXT_LANG_YEAR', 'Année');
define('TEXT_LANG_MONTH', 'Mois');
define('SET_AS_RECIPIENT_ADDRESS', 'Définir comme adresse de destinataire par défaut');
// end of account_edit items

// account_order items 2013-4-19
define('TEXT_ORDER_DATE', 'Date de Passer la commande');
define('TEXT_ORDER_DATE_DATE', 'Date de Passer la commande:');
define('TEXT_ORDER_NUMBER', 'N°de Commande');
define('TEXT_ORDER_NUMBER_LABEL', 'N°de Commande:');
define('TEXT_ORDER_TOTAL', 'Toutes les Commandes');
define('TEXT_ORDER_STATUS', 'Etats de Commandes');
define('TEXT_ORDER_STATUS_LABEL', 'Etats de Commandes:');
define('TEXT_ORDER_DETAILS', 'Détails');
define('TEXT_ORDER_PRODUCT_PART', 'Passer la commande rapidement avec le n° de réf.>>');
define('TEXT_ORDER_NO_EXISTS', 'Sans commande actuellement');
define('TEXT_DISCOUNT_OFF_SHOW', 'éteint');
define('TEXT_HANDING_FEE', 'Frais de Traitement');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Montrer<strong>%d de </strong>au<strong>%d</strong> (des <strong>%d</strong> commandes)');
define('SUCCESS_PASSWORD_UPDATED', 'Votre mot de passe a été mis à jour');
define('TEXT_AVATAR_UPLOAD_SUCCESSFULLY', 'Image ont été approuvés. merci !');
// end of account_order items

// bof v1.0, zale 20130424
define('EXTRA_NOTE', '2-3 jours est le délai de livraison à partir de notre entrepôt à votre adresse de Chine agent.');
define ('TEXT_NOTE_SPTYA',' <font color="red"> S’il vous plaît ajoutez votre adresse de Chine agent dans <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments"> Commandez Commentaires . </a> </font> ');
define ('TEXT_DETAILS_SPTYA',' <font color="red"> Détails: < / font> <br />
<font color="red"> 1 , < / font> Choisissez un agent maritime en Chine qui vous avez confiance et que vous êtes familier avec . <br />
<font color="red"> 2 , < / font> Donnez-nous l’adresse et les coordonnées de cet agent d’expédition ( mieux en chinois si possible ) dans <font weight="700" color="blue"> Commandez Commentaires </font> . <br />
<font color="red"> 3 , < / font> Nous livrons vos marchandises à sa place . Vous nous payez seulement des honoraires d’expédition de notre ville à l’adresse de l’agent d’expédition que vous choisissez . Normalement seulement <font color="blue"> 1-2 USD / kg < / font> , vous pourriez payer après vous confirmez l’ordre et de l’agent . Et environ 2-3 jours l’agent peut obtenir le colis . <br /> <br />
<span Remarque style="color:red;"> : < / span > Ne vous inquiétez pas problème de commande, le colis arrivera vous sans perception de la taxe . ') ;

define ('TEXT_DETAILS_TRSTV',' Détails color="red"> <font : < / font> <br />
<font color="red"> 1 , < / font> Votre colis sera expédié à notre agent maritime Suifenhe ( situé dans la province du Heilongjiang , Chine) au premier . <br />
<font color="red"> 2 , < / font> Ensuite, notre agent expédier votre colis à Vladivostok ( Владивосток , situé au sud-est de la Russie ) . <br />
<font color="red"> 3 , < / font> Quand colis arrivant là , l’agent maritime local prendra contact avec vous , vous informer que le colis arrive et puis vous pouvez choisir la méthode d’expédition de votre colis de Vladivostok à votre ville à votre préférence . Aussi, vous devez payer vos frais de transport maritime intérieur . <br /> <br />
<font color="red"> En conclusion : < / font> <br />
Le coût d’expédition = le montant a été démontré par notre société à Vladivostok (facturés par dorabeads ) + paiement à la livraison de Vladivostok à votre place ( facturé par votre opérateur local d’expédition, une estimation est d’environ <font color="blue"> 1 - 3 USD / kg < / font> ) <br/> <br />
  
Comme notre agent maritime Suifenhe , il est un agent expérimenté et de confiance expédition qui ont coopéré avec nous très bien . <br /> <br />
<span Remarque style="color:red;"> : < / span > Ne vous inquiétez pas problème de commande, le colis arrivera vous sans perception de la taxe . ') ;

define ('TEXT_DETAILS_TRSTM',' Détails color="red"> <font : < / font> <br />
<font color="red"> 1 , < / font> Nous embarquerons les marchandises à la société de la Chine et la Russie logistique ( situé à Beijing , Chine ) , qui est responsable pour le transport de marchandises à Moscou . Photos
<font color="red"> 2 , < / font> En arrivant à Moscou , un spécialiste de la logistique vous contactera , informer votre colis arrive et puis vous pouvez choisir la méthode d’expédition de votre colis de Moscou à votre adresse à votre préférence . Cette personne va expédier les marchandises à vous selon votre instruction . Aussi, vous devez payer votre taxe intérieure de l’expédition. <br /> <br />
  
<font color="red"> En conclusion : < / font> <br />
Le coût d’expédition = le montant a été démontré par notre société à Moscou (facturés par dorabeads ) + paiement à la livraison de Moscou à votre place (facturés par l’ entreprise Logistic China - Russie , une estimation est d’environ <font color="blue"> 1 USD / kg < / font> ) <br /> <br />
  
Comme la Chine et la Russie Compagnie Logistique , il est un agent expérimenté et de confiance expédition qui a une grande assurance . <span style="background:yellow;color:black;"> Nos colis expédiés par l’entreprise de transport arrivent toujours en douceur . < / span > <br /> <br />
<span Remarque style="color:red;"> : < / span > Ne vous inquiétez pas problème de commande, le colis arrivera vous sans perception de la taxe . ') ;

define ('TEXT_DETAILS_TRSTMA',' Vos produits seront expédiés à l’une des villes suivantes qui est la plus proche de votre adresse de livraison par air:
  <div style="color:#008FED;margin: 10px 0;"> Moscou , Saint-Pétersbourg , Krasnoïarsk , Novossibirsk , Ekaterinbourg, Irkoutsk , Omsk , Kamtchatka , Sakhaline , Iakoutsk </div>
  une . Quand le colis arrive à la ville qui est près de votre position , notre agent maritime prendra contact avec vous . Ensuite, vous pouvez ramasser le colis par vous-même , dans ce cas , vous n’avez pas à payer de frais supplémentaires d’expédition. ( S’il vous plaît veuillez noter que si vous habitez près de Moscou , vous devez ramasser le colis à la fois depuis frais de stockage seront facturés pour garder colis dans l’entrepôt de Moscou . ) <br>
  b . Si vous êtes incapable de ramasser le colis par vous-même , vous pouvez demander à la personne qui vous contacter pour expédier le colis à votre adresse par la méthode d’expédition que vous aimez . Cette personne va expédier les marchandises à vous selon votre instruction . Aussi, vous devez payer pour vos frais de transport intérieur . <br>
  Le coût d’expédition = le montant a été démontré lorsque vous passez commande (facturés par 8 années ) + paiement à la livraison de la ville à votre place (facturés par l’ entreprise de logistique ) . <br>
  <font color="#ff0000"> Note: < / font> Pour faire votre colis livré avec succès , la photo ou la copie de la carte d’identité du destinataire a été requis par la compagnie maritime . S’il vous plaît de bien vouloir envoyer à <a href="mailto:service_fr@doreenbeads.com"> service_fr@doreenbeads.com </a> . Toute question , s’il vous plaît n’hésitez pas à nous contacter . ') ;
define('TEXT_TRSTM','a. We will ship the goods to the Logistic company who is responsible for carrying goods to Moscow.<br>
b. When arriving in Moscow, a logistics specialist will contact you, inform you that the parcel arrives and then you can choose the shipping method for your parcel from Moscow to your address at your preference. Also you have to pay your domestic shipping fee.<br>
<b>The shipping cost</b> = the amount has been shown when you checkout (charged by 8seasons) + Cash on Delivery from Moscow to your place (charged by Logistic company, an estimate shipping is about 0.3-0.5 USD / kg).');

define ('TEXT_DETAILS_YNKQY',' Vos produits seront expédiés à l’une des villes suivantes qui est la plus proche de votre adresse d’expédition par <b> voiture < / b > :
<div style="color:#008FED;margin: 10px 0;"> Moscou , Saint-Pétersbourg , Krasnoïarsk , Novossibirsk , Ekaterinbourg, Irkoutsk , Omsk , Yakutsk , Oussouri , Khabarovsk , Tioumen , Vladivostok , Yakutsk </div>
une . Quand le colis arrive à la ville , qui est près de votre position , notre agent maritime prendra contact avec vous . Ensuite, vous pouvez aller chercher votre colis par vous-même, dans ce cas , vous n’avez pas à payer de frais supplémentaires d’expédition. ( S’il vous plaît veuillez noter que si vous êtes près de Moscou , vous devez ramasser le colis à la fois depuis frais de stockage seront facturés pour garder colis dans l’entrepôt de Moscou . ) <br>
b . Si vous êtes incapable de ramasser le colis par vous-même , vous pouvez demander à la personne qui vous contacter pour expédier le colis à votre adresse par la manière d’expédition que vous aimez. Cette personne va expédier les marchandises à vous selon votre instruction . Aussi, vous devez payer pour vos frais de transport intérieur . <br>
<b> Le <br> coût d’expédition < / b > = le montant a été démontré lorsque vous passez commande (facturés par doreenbeads ) + paiement à la livraison de la ville à votre place (facturés par l’ entreprise de logistique ) .
<font color="#ff0000"> Note: < / font> Pour faire votre colis livré avec succès , la photo ou la copie de la carte d’identité du destinataire a été requis par la compagnie maritime . S’il vous plaît de bien vouloir envoyer à <a href="mailto:service_fr@doreenbeads.com"> service_fr@doreenbeads.com </a> . Toute question , s’il vous plaît n’hésitez pas à nous contacter . ') ;

define ('TEXT_READ_NOTE',' S’il vous plaît lire cette note . ') ;
define ('TEXT_SPTYA',' vous devriez choisir un navire - agent en Chine et nous dire son adresse de livraison en Chine Espoir pour votre compréhension , l’envoi de notre ville à votre agent est sur ​​votre compte . ') ;

define ('EXTRA_NOTE_CN',' Nous facturons les frais de livraison en fonction de votre emplacement actuel. ') ;

define ('NOTE_EMS',' <font color="red"> Si vous avez acheté <strong> montres quelque chose </strong> ou <strong> forte </strong> Comme ciseaux , s’il vous plaît ne pas choisir le SME, pourquoi? >> </font> ') ;
define ('NOTE_EMS_CONTENT','<span style=color:red;> Pour client qui a acheté Montres ou objet tranchant : </span> Si votre commande contient <strong> montres </strong> ou <strong> quelque chose de pointu </strong> Comme ciseaux ou des pinces à bec pointu , s’il vous plaît ne pas choisir EMS <div style="margin-top:8px; color:#333">Raison: faire personnalisé contrôle strict sur ​​eux, si ils ont trouvé le colis EMS avec la montre ou objet tranchant , colis serait renvoyé de la coutume , aussi poster bureau sera punie par la coutume . <br/>Si vous préférez utiliser EMS ou si les frais de livraison de SME est moins cher , vous pouvez envisager de commander l’article interdit séparément avec d’autres articles , ou vous pourriez vous sentir libre contactez-nous à l’adresse <a href=mailto:service_fr@doreenbeads.com> service_fr@doreenbeads.com </a> , nous allons vous donner meilleure suggestion . </div>');

define ('NOTE_USPS',' <font color="red"> Si vous avez acheté <strong> montres quelque chose </strong> ou <strong> forte </strong> Comme ciseaux , s’il vous plaît ne pas choisir le SME, pourquoi? >> </font> ') ;
define ('NOTE_USPS_CONTENT','<span style=color:red;> Pour client qui a acheté Montres ou objet tranchant : </span> Si votre commande contient <strong> montres </strong> ou <strong> quelque chose de pointu </strong> Comme ciseaux ou des pinces à bec pointu , s’il vous plaît ne pas choisir USPS <div style="margin-top:8px; color:#333">Raison: faire personnalisé contrôle strict sur ​​eux, si ils ont trouvé le colis USPS avec la montre ou objet tranchant , colis serait renvoyé de la coutume , aussi poster bureau sera punie par la coutume . <br/>Si vous préférez utiliser USPS ou si les frais de livraison de SME est moins cher , vous pouvez envisager de commander l’article interdit séparément avec d’autres articles , ou vous pourriez vous sentir libre contactez-nous à l’adresse <a href=mailto:service_fr@doreenbeads.com> service_fr@doreenbeads.com </a> , nous allons vous donner meilleure suggestion . </div>');

define ('TEXT_NOTE_ABOUT_TAX',' S’il vous plaît lire la note sur la fiscalité de détails >> ! ');
define ('TEXT_NOTE_ABOUT_TAX_CONTENT',' Remarque sur l’impôt : Selon notre expérience , TAXfee a une grande chance d’être chargée pour les colis expédiés par Fedex à votre pays , donc nous vous conseillons de mettre cette information dans votre esprit , choisissez la méthode la plus favorable d’expédition . ');

define('NOTE_FEDEX','<font color="red">la commande qui comprend les montres n’est pas proposée de choisir FedEx Pourquoi?>></font>');
define('NOTE_FEDEX_CONTENT','Au client qui a acheté des Montres: Si votre commande contient des Montres, nous ne vous recommandons pas FedEx. Vous pouvez choisir d’autres méthodes d’expédition. <br/><font style="color:red;font-weight:bold;">Raison</font>: Le contrôle des produits électroniques de FedEx est très strict, s’ils trouvaient un colis qui a des montres, le colis serait retenu par la douane. <br/> Si vous préfériez FedEx ou aviez des questions, vous pourriez nous contacter librement à l’adresse <a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com </a>, nous vous donnerons la meilleure suggestion.');

define('TEXT_NOTE_USE_ENGLISH' , 'Fedex requiert une adresse en anglais, pourquoi?');
define('TEXT_NOTE_USE_ENGLISH_DESCRIPTION' , 'Fedex requiert une adresse en anglais, afin de ne pas provoquer de retard dans l’expédition, veuillez laisser un commentaire pour votre adresse en anglais lors de votre paiement. Si vous n’en avez pas, contactez simplement notre service à la clientèle: <a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com</a>, merci.');

define ('TEXT_NOTE_ABOUT_WATCH',' S’il vous plaît n’oubliez pas de lire la note sur les montres de détails >> . ') ;
define('TEXT_NOTE_ABOUT_WATCH_CONTENT', 'S’il comporte 20% en quantité de montres dans votre commande, s’il vous plaît ne pas choisir DHL (direct) depuis DHL faire le contrôle strict sur ​​le colis avec le produit électrique, comme la montre. Colis ne serait pas autorisé à expédiés.');
define('NOTE_TARIFF', 'Note sur la valeur déclarée pour la douane');
define('NOTE_TARIFF_CONTENT', 'Pour cette mode d’expédition, nous marquerons la valeur correcte (environ 15GBP-40GBP) sur le colis, de sorte que vous n’avez pas à payer d’impôt. <br /> Si vous voulez marquer valeur réelle sur la parcelle, 20% de la taxe fiscale est nécessaire, donc nous vous suggérons fortement que juste laissez-nous, nous allons le gérer correctement. '); 
define ('NOTE_TARIFF_CONTENT_US','Pour cette méthode d’expédition, nous marquerons la valeur propre(environ 15GBP - 40GBP ) sur le colis, de sorte que vous n’avez pas besoin à payer aucune taxe. <br /> Si vous voulez marquer une réelle valeur sur le colis , 20% des frais de taxe sont nécessaires,nous vous suggérons donc fortement de le laisser à nous, nous allons le gérer correctement.');

define('TEXT_HOW_DOES_IT_WORKS', 'Comment ça fonctionne?');
define('TEXT_HOW_DOES_IT_WORKS_1', 'Comment ça fonctionne? Une copie de la carte d’identité est nécessaire.');

define('TEXT_POBOX_REMINDER', 'Attenton: Pour vous assurer que votre colis étant livraison en douceur, s’il vous plaît veuillez fournir l’adresse de la rue à la place de l’adresse de boîte postale ne.');

define('TEXT_YOUR_ITEMS_BE_SHIPPED', 'Vos articles seront envoyés ensemble dans');
define('TEXT_BOXES', 'boîtes');

define('TEXT_WOOD_PRODUCTS_NOTICE', 'Produits en bois / bambou ne sont pas recommandé d’expédier par DHL, pourquoi?');

define('NOTE_GREECE', '<a href="' . HTTP_SERVER . '/page.html?id=215' . '" target="_blank">Assurez-vous de lire la note sur la douane >></a>');

define('TEXT_DETAILS_SFHYZXB', 'Il n’est pas un service porte à porte. Vous devez ramasser le colis à votre bureau de poste local. Quand le colis arrive dans le bureau de poste local, vous recevrez une notification vous demandant de venir chercher votre colis avec carte d’identité valide. Ne vous inquiétez pas coutume, nous allons prendre soin de tout. Photos 
Note aimable: Maxim poids: 30 kg par colis. Si votre commande ne pèse plus de 30 kg, nous allons séparer en plusieurs colis.');

define('TEXT_DETAILS_SFHKY', 'Un service porte à porte. Le colis sera envoyé à Уссури d’abord, puis transporté à votre bureau de poste local en avion. Quand il arrive dans le bureau de poste local, l’homme de poste enverra le colis à votre domicile. Pas de soucis personnalisé, nous nous occupons de tout. Photos Avantage: A. gratuit de problème fiscal B. Peut être dépisté en ligne:. <a href=http://www.sfhpost.com> www.sfhpost.com </a> Photos Inconvénient: Nous ne le transport . produits à bureau de poste local <br> Veuillez noter: le poids Maxim: 20 kg. si votre commande ne pèse plus que 20 kg, nous allons séparer en plusieurs colis.');

define('TEXT_NOTE_SPTYA', '<font color="red">S’il vous plaît ajoutez votre adresse de l’agent Chine <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments">dans vos avis.</a></font>');

define('TEXT_NO_AVAILABLE_SHIPPING_METHOD', '<font color="red"><b>NOTE: </b></font>S’il n’y a pas de Modes d’expédition disponibles pour votre adresse de livraison, il serait un meilleur choix pour <a href="mailto:service_fr@doreenbeads.com"> contactez-nous </a> avant de payer la commande.');

define('TEXT_ITEM', 'Article');
define('TEXT_PRICE', 'Prix');
define('TEXT_SHIPPING_METHOD', 'Modes d’expédition');
define('TEXT_SHIPPING_METHODS', 'Modes d’expédition');
define('TEXT_DAYS', 'Jours');
define('TEXT_NOTE', 'Note');
define('TEXT_DAYS_LAN', 'Jours');
define('TEXT_WORKDAYS', 'Jours ouvrables');

define('TEXT_DAYS_ALT_S_Q', 'Délai de livraison du lent to rapide');
define('TEXT_DAYS_ALT_Q_S', 'Délai de livraison du rapide au lent');
define('TEXT_PRICE_ALT_L_H', 'Prix du élevé au bas');
define('TEXT_PRICE_ALT_H_L', 'Prix du bas au élevé');

define ( 'TEXT_SHIPPING_FEE', 'Frais d’envoi a été calculé en la volume et le poids' );
define ( 'TEXT_CLICK_HERE_FOR_MORE_LINK', '<a href="' . HTTP_SERVER . '/page.html?id=160" target="_blank">Cliquer ici pour les détails.</a>' );
define ( 'TEXT_SHIPPING_NOTE','Veuillez savoir que les frais de port ci-dessus ont inclus le supplément pour la livraison de contrée lointaine (requis par %s --- ');
define ( 'TEXT_TOTAL_BOX_NUMBER', 'Nombres de boîte totale' );
define('TEXT_SHIPPING_VIRTUAL_COUPON_ACTIVITY', 'Choisissez ce service maintenant, vous pouvez obtenir un coupon de 2 $ (pas de montant minimum, un coupon chaque client).');

// eof

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'S’enregister à gagner un coupon de <b>US$ 6.01</b> et profiter une réduction VIP jusqu’à<b>10%</b>');
define('LOGIN_EMAIL_ADDRESS', 'Email:');
define('LENGHT_CHARACTERS', 'Cela devrait être au moins 5 caractères. ');
define('TEXT_YOUR_COUNTRY', 'Pays: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Abonnez-vous pour recevoir nos offres spéciales E-mail.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'I agree to Doreenbeads.com Terms and Conditions. ');
// end of login items

define('ENTRY_EMAIL_FORMAT_ERROR', "Le format de votre email n’est pas correct, s’il vous plaît essayer à nouveau.");
define('TEXT_VIEW_INVOICE', 'Voir la facture');

define('TEXT_DISCOUNT_OFF', 'Réduction');
define('TEXT_BE_THE_FIRST', 'Etre le premier');
define('TEXT_WRITE_A_REVIEW', 'Lire les avis');
define('TEXT_READ_REVIEW', 'Lire les avis');
define('TEXT_SHIPPING_WEIGHT_LIST', 'Poids d’expédition:');
define('TEXT_MODEL', 'N° de Réf');
define('TEXT_INFO_SORT_BY_STOCK_LIMIT', 'Stock - Du plus au moins');
define('TEXT_STOCK_HAVE_LIMIT', '%s Stock Disponible');
define('TEXT_PROMOTION_ITEMS', 'pour les produits non réduction');

define('TEXT_PASSWORD_FORGOTTEN', 'Mot de passe oublié?');
define('TEXT_LOGIN_ERROR', 'Pardon, il n’y a pas de compte pour cette adresse e-mail et / ou mot de passe.');

define('TEXT_ADDCART_MIN_COUNT', 'La quantité minimum de commande de %s est %s. La quantité est mise à jour %s automatiquement.');
define('TEXT_ADDCART_MAX_COUNT', 'La quantité maximum de commande de %s est %s. La quantité est mise à jour %s automatiquement.');
define('TEXT_ADDCART_NUM_ERROR', '<img height="20" width="20" title=" Caution " alt="Caution" src="includes/templates/template_default/images/icons/warning.gif">Nous sommes désolés, mais nous n’avons que les paquets de %s disponible de ce moment. S’il vous plaît mettre à jour gentiment la quantité. Pour toute question, veuillez nous contacter via service_fr@doreenbeads.com');
define('TEXT_ADDCART_NUM_ERROR_ALERT', 'La quantité disponible pour cet article sont (%s). S’il vous plaît faire un choix dans la quantité disponible ou vous préférez faire du shopping pour d’autres articles. Merci beaucoup pour votre compréhension!');

define('TEXT_MOVE_TO_WISHLIST_SUCCESS', 'Produits ajoutés à vos favoris avec succès! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">Voir vos favoris.</a>');
define('TEXT_HAD_BEEN_IN_WISHLIST','Ce produit a été dans le wishlist   <a href="'.zen_href_link('wishlist','','SSL').'">Voir les produits dans le wishlist</a>');
define('TEXT_MOVE_TO_WISHLIST_SUCCESS_NOTICE', 'Tous les produits dans vos favoris! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">Voir vos favoris</a>');
define('TEXT_VIEW_SHIPPING_WEIGHT', 'Voir le poids d’expédition');
define('TEXT_PRODUCT_WEIGHT', 'Poids de Produits');
define('TEXT_WORD_PACKAGE_BOX_WEIGHT', 'Poids de boîte d’emballage');
define('TEXT_WORD_SHIPPING_WEIGHT', 'Poids d’expédition');
define('TEXT_WORD_VOLUME_WEIGHT', 'Poids volumétrique');
define('TEXT_CALCULATE_BY_VOLUME','Frais d’envoi a été calculé en fonction du poids de colis volume.');
define('TEXT_SHIPPING_COST_IS_CAL_BY', 'Frais de l’expédition est calculé selon le poids du produit ainsi que le poids du paquet d’emballage.');

define('TEXT_CART_TOTAL_PRODUCT_PRICE', 'Montant total de produits');
define('TEXT_CART_ORIGINAL_PRICE', 'Le montant à prix régulier');
define('TEXT_CART_PRODUCT_DISCOUNT', 'Le montant à prix d’origine ');
define('TEXT_CART_DISCOUNT_PRICE', 'le montant de réduction');
define('TEXT_CART_ORIGINAL_PRICES','Prix d\'origine');
define('TEXT_CART_DISCOUNT','Réduction');
define('TEXT_PROMOTION_SAVE','Economie de Promotion');
define('TEXT_ORDER_DISCOUNT','Réduction de Commande');
define('TEXT_CART_VIP_DISCOUNT','Réduction de VIP');
define('TEXT_RCD','RCD');
define('TEXT_FREE_SHIPPING', 'Livraison Gratuite');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'des prix réduits du montant ');
define('TEXT_CART_QUICK_ADD_NOW', 'Ajouter au panier tout de suite');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Veuillez entrer le Numéro de réf de produit (par exemple B06512) et la quantité que vous souhaitez commander en utilisant le formulaire ci-dessous:');
define('TEXT_CART_ADD_TO_CART', 'Ajouter au panier');
define('TEXT_ADD_TO_CART_SUCCESS', 'Ajouté au panier avec succès!');
define('TEXT_VIEW_CART', 'Voir le panier');

define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Ajouter plus de produits');
define('TEXT_ITEMS_ADDED_SUCCESSFULLY', 'Les éléments ont été ajoutés avec succès.');
define('TEXT_QUICKADD_ERROR_EMPTY', 'S&quot;il vous plaît entrer au moins un n ° de réf produit et Quantité');
define('ERROR_PLEASE_CHOOSE_ONE', 'Veuillez sélectionner au moins un article.');
define('TEXT_QUICKADD_ERROR_WRONG', 'Pardon, certains articles ne sont pas disponibles. S&quot;il vous plaît supprimer la mauvaise n° de Réf / Quantité');

define('TEXT_BY_PART_NO', 'N ° d’article');
define('TEXT_BY_SPREADSHEET', 'Feuille de calcul');
define('TEXT_EXAMPLE', 'Example');
define('TEXT_SAMPLE_FROM_YOUR_SPREADSHEET', 'Exemple:  Copiez et collez dans la zone ombrée de votre feuille de calcul – comme indiqué sur la figure ci-dessus.');
define('TEXT_EXPORT_CART', 'Déplacer');
define('TEXT_PLEASE_ENTER_AT_LEAST', 'Entrez au moins un N ° d’article et QTE.');
define('TEXT_ITEMS_NOT_FOUND', 'Les articles suivants ne sont pas ajoutés à votre panier car les n° d’article n’ont pas été trouvé. %s');
define('TEXT_ITEMS_WAS_REMOVED', 'Les articles suivants ne sont pas ajoutés à votre panier, car ils ont été enlevé. %s');
define('TEXT_ITEMS_WERE_ALREADY_IN_YOUR_CART', 'Les articles suivants étaient déjà dans votre panier et de la QTE est maintenant mise à jour. Vous pouvez vérifier le QTE de l’article si nécessaire. %s');
define('TEXT_ITEMS_QTY_WAT_NOT_FOUND', 'Les articles suivants ne sont pas ajoutés à votre panier car la QTE de l’article n’a pas été trouvé. %s');
define('TEXT_ITEMS_MODIFIED_DUE_TO_LIMITED', 'La QTE d’articles suivants ont été modifiés en raison de la disponibilité limitée. %s');

define('TEXT_CART_JS_WRONG_P_NO', 'N° de réf invalides. Pour continuer, vous devez retirer cet article de votre liste.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'Pardon, certains éléments n’ont pas été trouvés, S’il vous plaît supprimer les n° de réf invalides');
define('TEXT_CART_JS_NO_STOCK', 'Pas de stock. Pour continuer, vous devez supprimer cet article de votre liste.');

define('TEXT_PAYMENT_DOWNLOAD', 'Télécharger');
define('TEXT_PAYMENT_PRINT', 'Imprimer');
define('TEXT_PAYMENT_PROMOTION_DISCOUNT', 'Promotion Réduction');

define('TEXT_EYOUBAO', 'Il est une sorte de service sino-russe logistique lancé par PONY EXPRESS et une société de logistique chinois, caractérisé par la vitesse rapide d’expédition, fret compétitif, et la garantie de sécurité. Il a progressivement devenir le choix préféré par les vendeurs e-commerce transfrontalier sino-russe. <br> 
avantages: <br>
1 produits électroniques autorisés ; <br>
2 Fin de mettre fin à un suivi en ligne : Vous pouvez le suivre sur <a href="http://set.zhy-sz.com/" target="_blank"> http://set.zhy-sz.com/ < / a> ( site officiel ) ou <a href="http://www.ponyexpress.ru/en/trace.php" target="_blank"> http://www.ponyexpress.ru/en/trace.php < / a> ( pays de destination ) pendant tout le voyage ; <br>
3 vieillissement garantie : Si le colis n atteindre la destination dans les 32 jours , le fret total sera remboursé si les frais de livraison que vous avez payé moins de 50USD tout 50USD sera remboursé si les frais de livraison que vous avez payé est plus que 50USD . Photos
( Non compris les causes spéciales : A. Pour la raison des acheteurs tels que l’adresse de livraison erronée , le destinataire n’est pas dans , pas de signature, etc B. Pour la raison de facteurs de force majeure tels que la guerre , les catastrophes , souffle d’air , etc ) ; Photos
4 A propos de l’assurance : L’assurance est facultative . Lorsque votre colis est très grand , vous êtes sincèrement conseillé de souscrire une assurance qui prend 3 % de la valeur déclarée de colis. Par exemple . Si vous voulez déclarer 1000USD pour votre colis, l’assurance sera 30USD . Et si le colis est absent , 1000USD sera remboursé . <br>
Inconvénients : Photos
1 Poids limite: 31 kg . Si votre colis pèse plus de 31 kg , nous allons séparer en plusieurs parcelles ; <br>
2 Taille limitation : 60cmx55cmx45cm ; <br>
3 Pas de contrebandes <br> ') ;

define ('TEXT_XXEUB', 'Un moyen de transport qui prend seulement environ 7-15 jours pour l’expédition Le colis sera remis au destinataire par le bureau de poste local suivi de l’information est disponible sur:.. <a href = "https:// / tools.usps.com / go / TrackConfirmAction_input "target =" _blank "> https://tools.usps.com/go/TrackConfirmAction_input </a>. <br> 
Avantages: Photos 
1 Coût-efficace: Par rapport à la poste aérienne, il ne prend 7-15 jours pour arriver à destination. Parfois, le colis pourrait même atteindre le destinataire dans les 4-6 jours. Photos 
2 Sans problème fiscal; <br> 
3 adresse de BP permis; <br> 
Inconvénients: Photos 
Poids maximum: 2 kg. Si le colis pèse plus de 2 kg, votre commande sera divisé en deux. <br><br>
Note chaude: un numéro de téléphone facilitera grandement la livraison. <br>');
define('TEXT_HMJZ', '(Numéro de boîte total: 1)');
// /////////////////////////////////////////////////////////
// dorabeads v1.5
define('TEXT_AVATAR_UPLOAD_TIPS', '<div style="font-weight:normal;font-size:15px;text-align:left;padding:0px 15px 0px 15px;line-height:23px;color:#ff6600">Si vous sélectionnez un fichier image sur votre ordinateur, s’il vous plaît de bien vouloir noter:<p style="margin-top:5px">1. 50 KB max.<br>2.seulement Jpg, gif, png, bmp.<br>3. Taille récommandée: 50x50, 100x100.<br>4.Votre avatar est visible à d’autres clients on <br>&nbsp;&nbsp;&nbsp;sur notre site.</p></div>');
define('TEXT_CASH_CREATED_MEMO_1', 'Vous avez profité du montant dans votre compte de crédit dans votre commande n° #%s');

define('TEXT_TARIFF_TITLE_1', 'Veuillez écrire votre Numéro de Douanes .. Il aide le dédouanement. <br /><br/>Douane No.:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( champ optionnel )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/>');

define('TEXT_TARIFF_TITLE_2', 'Veuillez écrire votre Numéro de Douanes .. Il aide le dédouanement. <br /><br/><FONT COLOR="RED">*</FONT> CPF/CNPJ No.:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( required field )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your CPF/CNPJ No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/><br /><br/><FONT COLOR="RED"><b>Note：</b></FONT>Tous les colis au Brézil avont besoin de n° CPF/CNPJ. Si vous n’en avez pas, s’il vous plaît choisir d’autres modes d’expédition.');

define('TEXT_TARIFF_TITLE_3', 'Veuillez écrire votre Numéro de Douanes .. Il aide le dédouanement. <br /><br/><FONT COLOR="RED">*</FONT> EORI No. :<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( required field )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your EORI No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/><br /><br/><FONT COLOR="RED"><b>Note：</b></FONT>FedEx(by Agent) EORI No. demandé. Si vous n’en avez pas, s’il vous plaît choisir d’autres modes d’expédition. ');

define('TEXT_TARIFF_TITLE_4', 'Veuillez écrire votre Numéro de Douanes .. Il aide le dédouanement. <br /><br/>N° EORI:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/>');

define('TEXT_TARIFF_TITLE_5', 'Veuillez écrire votre Numéro de Douanes .. Il aide le dédouanement. <br /><br/>N° de douane:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="Custom No."/>');

// bof dorabeads v1.7, zale
define('TEXT_VERIFY_NUMBER', 'Vérifier le numéro');
define('TEXT_TRACKING_NUMBER', 'Numéros de suivie');
define('TEXT_TERMS_CONDITIONS', 'Termes et Conditions');
define('TEXT_PRIVACY_POLICY', 'Politique Confidentialité');
define('TEXT_SHOPPING_CART_OUTSTOCK_NOTE', 'Les produits suivants ont été déplacés de votre panier à vos favoris, car ils sont en rupture de stock pour le moment, qui sera disponible bientôt. Il suffit de cliquer notification de restock pour obtenir des nouvelles dans le temps.');
define('TEXT_SHOPPING_CART_DOWN_NOTE', 'Les produits suivants ont été retirés de votre panier car ils sont en rupture de stock. Si vous en avez besoin, contactez-nous via <a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com</a>.');
define('TEXT_VIEW_LESS_SHOPPING_CART', 'Voir moins ');
define('TEXT_SHOPING_CART_INVALID_ITEMS', 'Invalides Vides');
define('TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS', 'Sélectionnez des produits similaires');
define('TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS', 'Articles Invalides Vides');
define('TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS', 'Confirmez-vous de vider les articles invalides?');
define('PROMOTION_LEFT', 'Left');
define('TEXT_SIMILAR_PRODUCTS', 'Produits Similaires');


define('TEXT_CODE_DAY', 'J');
define('TEXT_CODE_HOUR', 'H');
define('TEXT_CODE_MIN', 'Min');
define('TEXT_CODE_SECOND', 'S');
// eof v1.7

define('TEXT_IMPORTANT_NOTE', 'Important note');
define('TEXT_PAY_SUCCESS_TIP_TiTLE', 'Notification:');
define('TEXT_PAY_SUCCESS_TIP', "Compte tenu de la situation actuelle intensive à cause de l'épidémie mondiale, le nombre des vols diminue sans cesse. donc, il y aura des retards pour la livraison. veuillez votre compréhension aimable. Nous allons aussi faire tous nos efforts de vous laisser recevoir vos articles commandés le plus vite possible.");
define('TEXT_PLEASE_KINDLY_CHECK', 'Veuillez vérifier votre adresse de livraison pour confirmer son exactitude. Normalement, lors de la réception de votre paiement, nous allons expédier votre colis en 1-2 jours. Par conséquent, si vous remarquez que votre adresse de livraison  n’est pas correcte, veuillez <a href="mailto:service_fr@doreenbeads.com" style="color:#008FED;">nous contacter</a> aussi rapidement que possible en les 24 heures.');

define('TEXT_SEARCH_RESULT_TITLE', 'Résultats de Recherche:');
define('TEXT_SEARCH_RESULT_NORMAL', 'Votre recherche: «<span>%s</span>», <span>%d</span>  résultats pour «<span>%s</span>».');
define('TEXT_SEARCH_RESULT_SYNONYM', 'Donc on a recherché «<i>%s</i>» pour vous.');
define('TEXT_RELATED_SEARCH','Voir aussi');

define('TEXT_SEARCH_TIPS','<div class="search_error_cont">
        <dl>
            <dt>Astuces:</dt>
            <dd><span>-</span><p>Vérifiez que chaque mot soit bien orthographié.</p></dd>
            <dd><span>-</span><p>Si le numéro de référence que vous avez cherché n’est pas disponible, veuillez <a href="mailto:service_fr@doreenbeads.com">nous contacter</a>.</p></dd>
            <dd><span>-</span><p>Essayez à nouveau avec d’autres termes similaires.</p></dd>
        </dl>
        <div class="action"><a href="'.zen_href_link(FILENAME_DEFAULT).'" class="continue_shopping">Continuez le Shopping</a><a href="'.zen_href_link(FILENAME_WHO_WE_ARE,'id=99999' ).'" class="contact_us">Contactez-Nous</a></div>
    </div>');
define('TEXT_SEARCH_RESULT_FIND_MORE','Trouvez plus d’articles sur les suivants');

define('TEXT_CART_ARE_U_SURE_DELETE', 'Confirmez-vous de supprimer ce produit?');
define('TEXT_DOWNLOAD', 'Télécharger');
define('TEXT_SHIPPING_CHARGE', 'Frais de Livraison:');
define('TEXT_CART_VIP_DISCOUNT', 'Réduction de VIP');
define('TEXT_CART_JS_WRONG_NO', 'N° de Réf invalide.');
define('TEXT_NO_STOCK', 'Hors Stock');
define('TEXT_YES', 'Oui');
define('TEXT_NO', 'Non');
define('TEXT_PER_PACK', 'chaque lot');
define('TEXT_GRAMS', 'grammes');
define('TEXT_CREDIT_BALANCE','Solde de crédit:');

define('TEXT_UNIT_KG', 'kg');
define('TEXT_UNIT_GRAM', 'gramme');
define('TEXT_UNIT_POUND', 'pound');
//define('TEXT_UNIT_OUNCE', 'ounce');
define('TEXT_UNIT_OUNCE', 'Once');


define('TEXT_VIEW_LIST', 'Liste');
define('TEXT_VIEW_GALLERY', 'Gallerie');

define('HEADER_TITLE_NORMAL', 'Normal');
define('TEXT_SERVICE_EMAIL', 'service_fr@doreenbeads.com');
define('TEXT_SERVICE_SKYPE', 'service.8seasons');

// v2.20
define('TEXT_MY_COUPON', 'coupon');

define('PROMOTION_DAILY_DEALS', 'Offre du Week-end');
define('FACEBOOK_DAILY_DEALS','Facebook Offres Spotlight');
//define('PROMOTION_DAILY_DEALS', 'Offres: $0.79');
define('PROMOTION_SAVED', 'Economiser');

define('TEXT_ESTSHIPPING_TIME', 'Estimation délai de livraison');

define('TEXT_NEWSLETTER_SUCC', 'Parfait! Merci pour votre connection!');
define('TEXT_NEWSLETTER_JOIN', 'Rejoindre');
define('TEXT_NEWSLETTER_EMAIL_ADDRESS', 'Adresse d’e-mail');

define('TEXT_MORE_PRO','Plus');
define('TEXT_VIEW_LESS','Retourner');
define('TEXT_CLEAR_ALL','Supprimer Tous');
define('TEXT_ITEM_FOUND_2','<b>%s</b> Articles Trouvés');
define('TEXT_ITEM_FOUND','<b>%s</b> Article Trouvé');
define('TEXT_REFINE_BY_WORDS','Filtrer');

define('TEXT_SUB_WHICH_TYPE', 'Vous êtes');
define('TEXT_SUB_WHOLESALER', 'Grossiste');
define('TEXT_SUB_RETAILER', 'Débitant');
define('TEXT_SUB_DIY_FANS', 'Fans DIY');
define('TEXT_SUB_OTHERS', 'D’autres');

define('TEXT_SET_COUPON', "Félicitations! Nous avons crédité %s coupon à votre compte, veuillez le vérifier dans.
 <a href='".HTTP_SERVER."/index.php?main_page=my_coupon' style='text-decoration: underline;'> Mon Compte>></a>.");

define('TEXT_JOIN_NOW_COUPON', 'NSCRIVEZ-VOUS POUR OBTENIR <span>$6,01 COUPON</span>');
define('TEXT_JOIN_PASSWORD', 'Mot de Passe');
define('TEXT_JOIN_NOW_DISCOUNT_UP', 'Réduction de VIP jusqu’à -10%');
define('TEXT_JOIN_NOW_SIGN_UP', 'S’ENREGISTRER À CONNAITRE LES OFFRES EXCLUSIVES,<br/> LES TOP VENTES & LES NOUVEAUTÉS. ');
define('TEXT_JOIN_NOW_DEAR_CUSTOMERS', 'cher client');
define('TEXT_JOIN_NOW_RETURN_CUSTOMERS_LOGIN', 'Clients de Retour? <a href="'.zen_href_link(FILENAME_LOGIN).'" class="link_color">Se Connecter</a>');

define('TEXT_SILVER_REPORT', 'Nos produits sont analysé par l’Institution Officielle de Chine qui est reconnu par le ILAC et APLAC. [<a target="_blank" href="silver_report.html">Veuillez cliquer ici pour le rapport d’analyse</a>].');
define('TEXT_SWAROVSKI_CERTIFICATE', 'Comme l’agent Swarovski, nous avons le certificat officiel d’agent, vous allez recevoir les éléments cristals autrichiens authentiques de Swarovski <a target="_blank" href="swarovski_certificate.html">[Cliquez ici pour le certificat]</a>.');
define('EMAIL_PAYMENT_INFORMATION_ADDRESS','fengning.li@panduo.com.cn');
define('TESTIMONIAL_CC_ADDRESS','dan.lin@panduo.com.cn,wujie.miao@panduo.com.cn');
define('AVATAR_CHECK_ADDRESS', 'notification_fr@doreenbeads.com' );
define('AVATAR_CHECK_CC_ADDRESS', 'chahua.wang@panduo.com.cn' );
define('SALES_EMAIL_ADDRESS', 'service_fr@doreenbeads.com');
define('SALES_EMAIL_CC_TO', 'dan.lin@panduo.com.cn,yunan.zhang@panduo.com.cn,chahua.wang@panduo.com.cn');
define('TEXT_PRICE_AS_LOW_AS', 'A partir de');

define('TEXT_BACKORDER', 'Réserver');
define('TEXT_ARRIVAL_DATE','La date de retour estimé: %s.');
define('TEXT_READY_DAYS', 'Cycle de l arrivée estimé: %s jours.');
define('TEXT_ESTIMATE_DAYS', 'Le cycle de retour estimé: %s jours.');
define('TEXT_PREORDER','<font style="color:#ff0000" class="text_preorder_class" title="Cet article est temporairement en rupture de stock et vous l’avez commandé">&lt;Réserver&gt;</font> ');

define('TEXT_CART_ERROR_NOTE_PRODUCT_LESS','Seulement %s paquet (s) de %s sont disponibles maintenant. La quantité est mise à jour %s paquet (s) automatiquement.');
define('TEXT_CART_ERROR_HAS_BUY_FACEBOOKLIKE_PRODUCT','Chacun de nos Fans sur Facebook peut obtenir un échantillon Gratuit %s. Vous l’avez obtenu dans votre commande %s, ainsi cet article a été supprimé de votre panier.');
define('TEXT_GET_COUPON', 'Félicitations! Vous avez obtenu les Coupons Jusqu\'à %s. Veuillez vérifier dans «<a href="'.zen_href_link(FILENAME_MY_COUPON).'">Mon Coupon.</a>».');
define('TEXT_ALREADY_GET', 'Oups, un coupon ne peut être pris qu’une seule fois.');
define('TEXT_GET_COUPON_EXPIRED', 'désolé, cette activité est déjà finie, vous ne pouvez pas prendre les coupons.');

// include email extras
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);
}

// include template specific header defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_HEADER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER);
}

// include template specific footer defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_FOOTER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER);
}

// include template specific button name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);
}

// include template specific icon name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);
}

// include template specific other image name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);
}

// credit cards
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS);
}

// include template specific whos_online sidebox defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');
}

// include template specific meta tags defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/meta_tags.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php');
}
// END OF EXTERNAL LANGUAGE LINKS
/*testimonial  mailto */
define('TESTIMONIAL_EMAILS_TO', 'service_fr@doreenbeads.com');
/*coupon about to expire notice*/
define('TEXT_COUPON_NOTICE_FIRST', '<p class="tleft">Votre coupon sera expiré bientôt. <br />
					Le code de coupon est  <span>%s</span>. Et l’échéance est de  <span>%s</span>.');
define('TEXT_VIEW_MORE', 'En savoir plus');					 
define('TEXT_COUPON_NITICE_SECOND','<br />
		Donc, veuillez en profiter le plus tôt possible.</p>
					<a href="javascript:viod(0)" class="guidebtn">Okay，je sais</a> ');		
/*ask a question*/
define('TEXT_PART_NO','N° de réf:');
define("EMAIL_QUESTION_SUBJECT","Question pour détails d’article");
define('EMAIL_QUESTION_TOP_DESCRIPTION',"Votre quetion pour l’article %s sur dorabeads a été reçue.");

define('EMAIL_QUESTION_MESSAGE_HTML',"%s<br /><br />\n\n Cher %s,<br /><br />\n\nBonne journée! \n\n<br /><br />Merci beaucoup pour contacter dorabeads.Nous avons reçu votre quetion, un(e) des nos représentants de service va prendre contact avec vous le plus vite possible d’ici 24 heures. Attendez patiemment s’il vous plaît.<br /><br />\n\n Si vous avez besoin d’une assitance rapide, nous contactez via le Chat en live ou appelez notre Département de service à la clientèle sur (+86)0571-28197839  pendant notre heures de travail: de 8:30 AM à 6:30 PM (GMT +08:00) Beijing, Chine du lundi au samedi.<br /><br />\n\n Merci pour le temps partagé, nous vous contactons tout de suite!<br /><br />\n\n--------------------------------------Votre quetion---------------------------------------<br />%s<br /><br />%s<div style='clear:both;'>Sincères salutations<br/>\n L'équipe Doreenbeads<br />\n<a href=".HTTP_SERVER.">www.doreenbeads.com</a></div>");
/*address line 1 2 same error*/
define('ENTRY_FS_ADDRESS_SAME_ERROR',"Nous avons remarqué que votre adresse ligne 2 est même que l’adresse ligne 1 , veuillez réécrire l’adresse ligne 2 ou le laisser vide.");
define('TEXT_REMOVED','Indisponible');
define('TEXT_REFUND_BALANCE', 'Le montant crédité pour la commande: #');
/*facebook_coupon*/
define('FACEBOOK_LINK', 'https://www.facebook.com/pages/Doreenbeadscomfr/600109833408040?ref=hl');
/*满减活动*/
define('TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS', 'OFFRE EXCEPTIONNELLE');

/*other package size*/
define('TEXT_OTHER_PACKAGE_SIZE', "D’autre taille d’emballage");
define('TEXT_MAIN_PRODUCT','Produit principal');
define('TEXT_PRODUCTS_WITH_OTHER_PACKAGE_SIZES','Produits avec d’autres dimensions de l’emballage');

define('TEXT_SHIPPING_CALCULATE_TIPS','<span style="color:red;font-weight:bold">Remarque:</span> Veuillez bien noter que le Calculateur de Frais de Livraison ici s’applique uniquement aux commandes <span style="font-weight:bold">supérieures à US$ 19,99.</span> Si la commande est inférieure à US$ 19,99, nous allons prélever au moins US$ 2,99 de frais d’expédition. ');

define('TEXT_PACK_FOR_OTHER_PACKAGE', 'Paquet');
define('TEXT_PRODUCTS_IN_SMALL_PACK', 'Produits de Petit Emballage');
define('TEXT_PRODUCTS_IN_REGULAR_PACK', "Produits d’Emballage Régulier");

define('TEXT_LOGO_TITLE', 'LIVRAISON GRATUITE MONDIALE');

define('TEXT_DEAR_FN','cher(chère) %s' . "\n\n");
define('TEXT_DEAR_CUSTOMER','cher(chère) client');

define('TEXT_AVAILABLE_IN715','Temps de préparation: 7~15 jours de travail');
define('TEXT_AVAILABLE_IN57','Temps de préparation: 3~5 jours de travail');
define('TEXT_PRICE_TITLE_SHOW', 'Prix vente en gros. S’il n’y a pas suffit de stock. Cela fait environ 5-15 jours à préparer votre commande.');
define('TEXT_PRODUCTS_DAYS_FOR_PREPARATION_TIP', 'Cela fait environ 5-15 jours à préparer votre commande');

define('TEXT_NOTE_HOLIDAY_5','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Notification de Vacances:</b><br/>
Cher(es) client(es), le 1er octobre est la Fête Nationale en Chine. Nous serons en vacances du <b>1er au 4 octobre (GMT+8)</b>. Durant cette période, notre bureau sera fermé. Pour éviter le retard de livraison, nous vous conseillons de passer les commandes avant <b>le 29 septembre</b>. Merci !
		<br/>Équipe Doreenbeads</p>');
define('TEXT_NOTE_HOLIDAY_6','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Notification de Vacances:</b><br/>
Cher(es) client(es), nous serons en vacances Fête Nationale du <b>1er au 4 octobre (GMT+8)</b>. Pendant cette période, vous pouvez passer la commande comme d’habitude, et les colis seront expédiés après notre retour de travail <b>le 5 octobre (GMT+8)</b>. Nous allons expédier les colis selon l’ordre de commandes passées. Donc, nous vous conseillons de passer les commandes le plus tôt possible. Merci !
		<br/>Équipe Doreenbeads</p>');

define('ENTRY_EMAIL_ADDRESS_REMOTE_CHECK_ERROR','Adresse email invalid. Veuillez saisir une adresse email valide.');

define('SET_AS_DEFAULT_ADDRESS', 'définie comme adresse par défaut');
define('SET_AS_DEFAULT_ADDRESS_SUCCESS', 'Votre adresse de livraison par défaut mise à jour avec succès.');

define('ALERT_EMAIL', "Entrez votre adresse e-mail, s’il vous plaît. Merci!");
define('ENTER_PASSWORD_PROMPT' , 'Veuillez saisir votre mot de passe.');
define('TEXT_CONFIRM_PASSWORD', 'N’oubliez pas de re-taper votre mot de passe!');
define('TEXT_CONFIRM_PASSWORD_PROMPT' , 'Veuillez confirmer votre mot de passe.');
define('TEXT_ENTER_FIRESTNAME', 'Veuillez taper votre prénom (au moins 1 caractère).');
define('TEXT_ENTER_LASTNAME', 'Veuillez taper votre nom (au moins 1 caractère).');
define('TEXT_EMAIL_NOTE',"Veuillez laisser une adresse email valide.");

define('TEXT_PROMOTION_DISCOUNT_NOTE','Le montant des produits vendus au prix original est de <b>{TOTAL}</b>, vous pouviez profiter une réduction <b>{NEXT}</b> dès <b>{REACH}</b> d’achat.');

define('TEXT_SMALL_PACK','Petit Lot');

define('TEXT_NDDBC_INFO_OUR_WEBSITE', 'Pour retour à notre site, <a href="%s">cliquez ici>></a>');
define('TEXT_NDDBC_INFO_PREVIOUS_PAGE', 'Pour revenir à la page précédente, veuillez <a href="%s">cliquer ici</a>');
define('TEXT_NDDBC_INFO','<p class="STYLE1">Cher(Chère) client,</p> <p class="STYLE1">Bienvenu(e)!</p><p class="STYLE1"> Désolés, il y a une petite erreur sur notre site maintenant. Quand vous le visitez, il peut vous amener à ce page anormal. <br /> Mais, ne vous inquiétez pas; votre information précédente sur notre site a été bien gardée. <br /><br />  <strong>%s</strong><br /><br />  Si vous voyez toujours ce page en visitant notre site, veuillez nous contacter par email : <a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com</a><br />  Merci d’avance pour votre compréhension & Nous sommes désolés de vous apporter tous les inconvénients.<br /><br />  sincères salutations<br /> L’équipe Doreenbeads');

define('TEXT_LOG_OFF','Se Déconncter');
define('TEXT_TO_VIEW', 'Allez-y &gt;&gt;');
define('TEXT_CUSTOM_NO','Douane No.');
define('ENTRY_TARIFF_REQUIRED_TEXT' , 'Veuillez écrire votre Numéro de Douanes .. Il aide le dédouanement.');
define('ENTRY_BACKUP_EMAIL_REQUESTED_TEXT' , 'Veuillez remplir votre boîte de secours, pour que nous pussions vous contacter en temps.');
define('TEXT_EMAIL_HAS_SUBSCRIBED','Vous vous êtes déjà abonné le Newsletter');

define('TEXT_ENTER_BIRTHDAY_ERROR','Veuillez choisir la date de naissance');
define('TEXT_BIRTHDAY_TIPS', 'Remplir votre date de naissance pour obtenir un cadeau spécial lors de votre anniversaire.');
define('TEXT_ENTER_BIRTHDAY_OVER_DATE','La date de naissance ne peut pas être supérieure à la date actuelle.');

define('ERROR_PRODUCT_PRODUCTS_BEEN_REMOVED','Échouer d’ajouter au panier, ce produit a été supprimé de notre inventaire en ce moment.');
define('KEYWORD_FORMAT_STRING', 'Mots-clés');
define('TEXT_DEAR_CUSTOMER_NAME', 'Client');

define('TEXT_CHANGED_YOUR_EMAIL_TITLE','Vous avez réussi de changer votre adresse e-mail pour le compte de doreenbeads.');
define('TEXT_HANDINGFEE_INFO','En raison de l’augmentation des coûts de main-d’œuvre, nous avons ajouté des frais de traitement de 0,99 USD sur certains colis. Les frais de traitement sont uniquement nécessaires si le montant des articles d\'une commande est inférieur à 9,99 USD.');
define('TEXT_CHANGED_YOUR_EMAIL_CONTENT','Bonjour %s,<br/><br/>
Vous avez réussi de changer votre adresse e-mail pour le compte de doreenbeads.<br/><br/>

Votre ancienne adresse e-mail: %s<br/>
Votre nouvelle adresse e-mail: %s<br/>
Temps mis à jour: %s<br/><br/>

Si vous n’avez pas demandé cette modification, veuillez <a href="mailto:service_fr@doreenbeads.com">Contact Us</a>. <br/><br/>

Cordialement,<br/><br/>

Équipe Doreenbeads');
define('KEYWORD_FORMAT_STRING', 'Mots-clés'); 

define('TEXT_SHIPPING_METHOD_DISPLAY_TIPS', 'Nous cachons des moyens d’expédition pas souvent utilisés, <a id="show_all_shipping">montrer tous les moyens d’expédition >></a>');

define('TEXT_BUYER_PROTECTION','Protection de Client');
define('TEXT_BUYER_PROTECTION_TIPS','<p>Remboursement Intégral <span>(votre commande n’arrive pas)</span></p><p>Remboursement Complet ou Partiel <span>(articles défectueux)</span></p>');
define('TEXT_FOOTER_ENTER_EMAIL_ADDRESS','Entrez votre e-mail.');
define('TEXT_IMAGE','Image');
define('TEXT_DELETE', 'Supprimer');
define('TEXT_PRODUCTS_NAME', 'Nom du produit');
define('TEXT_CUSTOMIZED_PRODUCTS_TITLE', 'Ce produit est disponible pour la gravure');
define('TEXT_SHIPPING_RESTRICTION', 'Restriction d’Expédition');
define('TEXT_SHIPPING_RESTRICTION_TIP', 'Ce produit est interdit d’être transporté selon certaines méthodes d’expédition.');
define ( 'TEXT_PAYMENT_BANK_WESTERN_UNION', 'Les informations sur le bénéficiaire de Western Union ' );
define('TEXT_API_LOGIN_CUSTOMER', 'Reliez Votre Compte Existant.');
define('TEXT_API_REGISTE_NEW_ACCOUNT', 'Créez Votre Compte doreenbeads et Connectez-vous avec %s.');
define('TEXT_API_BIND_ACCOUNT', 'Si vous avez déjà un compte Doreenbeads, vous pouvez lier votre compte %s avec les informations du compte.');
define('TEXT_API_REGISTER_ACCOUNT', 'Si vous n’avez pas de compte Doreenbeads, vous pouvez créer un nouveau compte et lier votre compte %s avec les informations du compte.');

define('PROMOTION_DISPLAY_AREA' , 'PROMOS');
define('TEXT_SUBMIT_SUCCESS', 'Soumis avec succès!');

define ( 'TEXT_PAID','Payé ');
define('TEXT_SHIPPING_INVOECE_COMMENTS', 'Livraison & Avis');
define('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE', '<b>Note importante: </b><br/>en raison de la restriction d’expédition, certains produits de votre commande peuvent être expédiés séparément par Poste Aérienne, <a href="'.HTTP_SERVER.'/page.html?id=211" style="color:#008fed;" target="_blank">pourquoi >></a>');

define('TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS', 'Ce prix réduit est limité à %s lots, sinon au prix initial.');

define('TEXT_TWO_REWARD_COUPONS', 'Deux coupons de récompense seulement pour vous, 12 USD peuvent être économisés');
define('TEXT_IN_ORDER_TO_THANKS_FOR_YOU', 'Afin de vous remercier pour votre première commande chez nous, nous vous avons envoyé 2 coupons sur votre compte. <a href="' . zen_href_link(FILENAME_MY_COUPON) . '" target="_blank">Voir mon coupon >></a>');
define('EMAIL_ORDER_TRACK_REMIND_NEW','Veuillez vérifier s\'il y a des informations incorrectes. Si vous voulez corriger l\'adresse d\'expédition, veuillez nous contacter par: <a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com</a> avant que nous expédions votre paquet.');
define('TEXT_HOPE_TO_DO_MORE_KIND_BUSINESS','Nous espérions de faire plus d\'affaires aimables avec vous. Bonne journée ~~<br/><br/>
Cordialement,<br/><br/>
Équipe Doreenbeads');
define('BOTTOM_VIP_POLICY','Voir <a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_HELP_CENTER,'&id=65') . '" >Politique de Réduction</a>');
define('IMAGE_NEW_CATEGORY', 'nouvelle cat&eacute;gorie');
define('TEXT_COUPON_CODE','Code de Coupon');
define('TEXT_COUPON_PAR_VALUE','Par Valeur');
define('TEXT_COUPON_MIN_ORDER','Montant Minimum d’Articles');
define('TEXT_COUPON_DEADLINE','Echéance (GMT+8)');
define('TEXT_DISPATCH_FROM_WAREHOUSE', 'Envoi de l\'Entrepôt');
define('TEXT_ALL', 'tous');
define('TEXT_DATE_ADDED','Jour d’ajouter');
define('TEXT_FILTER_BY', 'Filtrer par');
define('TEXT_REGULAR_PACK','Emballage Normal');
define('TEXT_SMALL_PACK','Petit Lot');
define('TEXT_VIEW_ONLY_SALE_ITEMS', 'Seuls les Articles en Solde');
define('TEXT_EMAIL_REG_TIP', 'Le format de l’adresse e-mail est incorrect, veuillez remplir l’adresse e-mail correcte.');
define('TEXT_DELETE', 'Supprimer');
define('TEXT_NO_UNREAD_MESSAGE', 'Il n\'y a pas de message non lu.');
define('TEXT_SETTINGS', 'Paramètres');
define('TEXT_SEE_ALL_MESSAGES', 'Tous les Messages');
define('TEXT_TITLE', 'Titre');
define('TEXT_MESSAGE', 'Message');
define('TEXT_MY_MESSAGE', 'Mes Messages');
define('TEXT_MESSAGE_SETTING', 'Paramètre des Messages');
define('TEXT_ALL_MARKED_AS_READ', 'Tout marquer comme lu');
define('TEXT_DELETE_ALL', 'Supprimer Tout');
define('TEXT_UNREAD_MESSAGE', 'Non Lus');
define('TEXT_MARKED_AS_READ', 'Lus');
define('TEXT_RECEIVE_ALL_MESSAGES', 'Recevoir tous les messages');
define('TEXT_RECEIVE_THE_SPECIFIED', 'Recevoir le type de message spécifié');
define('TEXT_REJECT_ALL_MESSAGES', 'Rejeter tous les messages');
define('TEXT_PLEASE_CHOOSE_AT_LEAST_MESSAGE', 'Veuillez choisir au moins un type de message.');
define('TEXT_YOU_WILL_NO_LONGER_MESSAGE', 'Vous ne recevrez plus tous nos messages, êtes-vous sûr?');
define('TEXT_ON_SALE', 'En Promotion');
define('TEXT_IN_STOCK', 'En Stock');
define('BY_CREATING_AGREEN_TO_TEAMS_AND_CONDITIONS', 'En créant un compte, vous acceptez les <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Termes et Conditions</a> de Doreenbeads.com.');
// end of login items
define('TEXT_SHIPPING_FROM_USA', 'Ship From USA');
define('TEXT_CHECK_URL','Il y a un lien illégal dans le contenu que vous avez entré. Veuillez le corriger.');
?>