<?php
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays product-listing when a particular category/subcategory is selected for browsing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_product_list.php 5369 2006-12-23 10:55:52Z drbyte $
 */
?>

<h2 class = "centerBoxHeading">
<?php	
		echo TEXT_ALL_PRODUCTS_IN_CATEGORY;
?>
</h2>
<div class="centerColumn" id="categoryProductList" >

<div style="padding:0px 10px; clear:both;">
<?php
/**
 * require the code for listing products
 */
	require($template->get_template_dir('tpl_modules_category_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_category_product_listing.php');
 
 //require($template->get_template_dir('tpl_modules_category_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_category_product_listing.php');
?>
</div>

