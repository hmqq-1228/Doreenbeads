<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=advanced_search_result.<br />
 * Displays results of advanced search
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_advanced_search_result_default.php 4182 2006-08-21 02:11:37Z ajeh $
 */
?>
<div class="centerColumn" id="advSearchResultsDefault">

<h1 id="advSearchResultsDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php
/**
 * Used to collate and display products from advanced search results
 */
 require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
?>

</div>