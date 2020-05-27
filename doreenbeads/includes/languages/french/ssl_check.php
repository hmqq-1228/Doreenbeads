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
// $Id: ssl_check.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('NAVBAR_TITLE', 'Contrôle de sécurité');
define('HEADING_TITLE', 'Contrôle de sécurité');

define('TEXT_INFORMATION', 'Nous avons détecté que votre navigateur a généré un autre ID de session SSL a été utilisé tout au long de nos pages sécurisées.');
define('TEXT_INFORMATION_2', 'Pour des raisons de sécurité, vous devrez vous connecter à votre compte de nouveau pour continuer les achats en ligne.');
define('TEXT_INFORMATION_3','Certains navigateurs, comme Konqueror 3.1, n’ont pas la capacité de générer de la session SSL ID nécessaire automatiquement. Si vous utilisez un tel navigateur, nous recommandons de passer à un autre navigateur pour continuer vos achats en ligne avec nous. Si vous n’avez pas un autre navigateur installé sur votre ordinateur, vous pouvez télécharger un compatible à partir de: <a href="http://www.microsoft.com/ie/" target="_blank">Microsoft Internet Explorer</a>, <a href="http://channels.netscape.com/ns/browsers/download_other.jsp" target="_blank">Netscape</a>, or <a href="http://www.mozilla.org/releases/" target="_blank">Mozilla</a>.');
define('TEXT_INFORMATION_4','Nous avons pris cette mesure de sécurité pour votre avantage et faisons des excuses pour tout inconvénient que cela provoque.');
define('TEXT_INFORMATION_5','S’il vous plaît contacter le propriétaire du magasin si vous avez des questions touchant à cette condition, ou continuez vos achats en ligne.');

define('BOX_INFORMATION_HEADING', 'Confidentialité et Sécurité');
define('BOX_INFORMATION', 'Nous validons la session SSL ID généré automatiquement par votre navigateur à chaque requête de page sécurisée faite à ce serveur.<br /><br />Cette validation assure que c’est vous qui naviguez sur ce site avec votre compte et pas quelqu’un d’autre.');
?>
