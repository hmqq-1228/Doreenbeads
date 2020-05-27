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

<br />
<!--jessa 2009-10-27��<h2 class = "centerBoxHeading">All products in this Category</h2>�Ƶ�div����-->

<div class="centerColumn" id="categoryProductList">
<h2 class = "centerBoxHeading centerBoxHeading1">
<?php
//jessa 2009-12-17 �ж��Ƿ���bestsellersҳ�棬����������������
	if ($_GET['sort'] == '21d'){
		echo TEXT_PRODUCT_LIST_BESTSELLERS_IN_CATEGORY;
	}else{
		echo TEXT_PRODUCT_LIST_ALL_IN_CATEGORY;
	}
//eof jessa 2009-12-17
?>
</h2>
<!--eof jessa 2009-10-27-->

<?php

/**
 * require the code for listing products
 */
//jessa 2010-05-03 �������
if ($_SESSION['display_mode'] == 'quick'){
	require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
} else {
	require($template->get_template_dir('tpl_modules_category_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_category_product_listing.php');
}
//eof jessa 2010-05-03
 //require($template->get_template_dir('tpl_modules_category_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_category_product_listing.php');
?>
</div>
