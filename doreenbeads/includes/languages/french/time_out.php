<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

define('NAVBAR_TITLE', 'Se connecter échoué');
define('HEADING_TITLE', 'Oups! Votre session a expiré.');
define('HEADING_TITLE_LOGGED_IN', 'Oups! Pardon, mais vous n’êtes pas autorisé à effectuer l’action demandée. ');
define('TEXT_INFORMATION', '<p>Si vous passiez une commande, s’il vous plaît vous connecter et les articles dans votre panier sera été restauré. Vous pouvez alors revenir à le payer et finir vos derniers achats.</p><p>Si vous avez fini une commande et vous voulez la voir' . (DOWNLOAD_ENABLED == 'true' ? ', ou avez un téléchargement et que vous souhaitez le récupérer' : '') . ', veuillez aller à <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mon Compte</a> à voir vos commandes.</p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Vous êtes toujours connecté à votre compte et pouvez continuer vos achats. S’il vous plaît choisir une destination ');

define('HEADING_RETURNING_CUSTOMER', 'Se Connecter');
define('TEXT_PASSWORD_FORGOTTEN', 'Oublié le mot de passe?')
?>