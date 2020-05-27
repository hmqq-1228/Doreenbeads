<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: credit_cards.php 6119 2007-04-05 08:20:16Z drbyte $
 */
/*

La carte de crédit definit déclarations qui correspondent aux données réelles dans le tableau de configuration.

Par exemple, pour Visa:
TEXT_CC_ENABLED_VISA ou IMAGE_CC_ENABLED_VISA est destiné pour CC_ENABLED_VISA qui est listé dans le tableau de configuration

Si c’est une nouvelle carte de crédit ajoutée,mais sans une correspondance définie, elle ne peut pas être utilisée par la fonction zen_get_cc_enabled ()

Pour obtenir une liste de la carte de crédit acceptée, il faut utiliser la fonction de  To obtain a list of accepted credit cards use the function zen_get_cc_enabled()

Par exemple:

echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();

*/

define('TEXT_ACCEPTED_CREDIT_CARDS', '<strong>On accepte:</strong> ');

// cc enabled text
define('TEXT_CC_ENABLED_VISA','Visa');
define('TEXT_CC_ENABLED_MC','MC');
define('TEXT_CC_ENABLED_AMEX','AmEx');
define('TEXT_CC_ENABLED_DINERS_CLUB','Club de dîneurs');
define('TEXT_CC_ENABLED_DISCOVER','Découvrir');
define('TEXT_CC_ENABLED_JCB','JCB');
define('TEXT_CC_ENABLED_AUSTRALIAN_BANKCARD','Carte Bancaire d’Australie');
define('TEXT_CC_ENABLED_SOLO','Solo');
define('TEXT_CC_ENABLED_SWITCH','commutateur');
define('TEXT_CC_ENABLED_MAESTRO','professeur');

// pour définir ces images comme:
// define('IMAGE_CC_ENABLED_VISA',zen_image(DIR_WS_IMAGES . 'filename.jpg');
// utiliser la fonction
// echo zen_get_cc_enabled('IMAGE_');

// cc enabled image
define('IMAGE_CC_ENABLED_VISA', zen_image($template->get_template_dir('cc1.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc1.gif'));
define('IMAGE_CC_ENABLED_MC', zen_image($template->get_template_dir('cc2.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc2.gif'));
define('IMAGE_CC_ENABLED_AMEX', zen_image($template->get_template_dir('cc3.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc3.gif'));
define('IMAGE_CC_ENABLED_DINERS_CLUB', zen_image($template->get_template_dir('cc4.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc4.gif'));
define('IMAGE_CC_ENABLED_DISCOVER', zen_image($template->get_template_dir('cc5.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc5.gif'));
define('IMAGE_CC_ENABLED_JCB', zen_image($template->get_template_dir('cc6.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc6.gif'));
define('IMAGE_CC_ENABLED_AUSTRALIAN_BANKCARD', zen_image($template->get_template_dir('cc7.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc7.gif'));
define('IMAGE_CC_ENABLED_SOLO', zen_image($template->get_template_dir('cc8.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc8.gif'));
define('IMAGE_CC_ENABLED_SWITCH', zen_image($template->get_template_dir('cc9.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc9.gif'));
define('IMAGE_CC_ENABLED_MAESTRO', zen_image($template->get_template_dir('cc10.gif', DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . 'cc10.gif'));
?>