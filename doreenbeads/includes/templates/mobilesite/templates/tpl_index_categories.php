<?php

/**

 * Page Template

 *

 * Loaded by main_page=index<br />

 * Displays category/sub-category listing<br />

 * Uses tpl_index_category_row.php to render individual items

 *

 * @package templateSystem

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: tpl_index_categories.php 4678 2006-10-05 21:02:50Z ajeh $

 */

?>
<?php if ($show_welcome == true) { ?>

<h1 id="indexCategoriesHeading" style="display:none;"><?php echo HEADING_TITLE; ?></h1>

<?php if (DEFINE_MAIN_PAGE_STATUS >= 1 and DEFINE_MAIN_PAGE_STATUS <= 2) {	?>
<div id="indexCategoriesMainContent" class="content">
<?php
/**	
 * require the html_define for the index/categories page	
 */
   include($define_page);
?>
</div>
<?php } ?>

<div id="special_categroy_show">
<?php 
  $special_category_array=array(718,690);
  foreach($special_category_array as $key=>$val){
  echo '<span class="special_cate_img" id="special_cate_'.$key.'"><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$val).'">'.get_category_info_memcache($val , 'categories_name').'</a></span>';
  }
  echo "</div>";
} else { ?>

<nav><?php echo $breadcrumb->showbreads(); ?></nav>

<?php } ?>


<?php  
/**
 * require the code to display the sub-categories-grid, if any exist
 */
   require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
?>

<!-- EOF: Display grid of available sub-categories -->

<?php
if(!$this_is_home_page){
	
// 	if ( $show_welcome != true  ){
// 		if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
// 			require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
// 		} else {
// 			require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_product_listing.php');
// 		}
// 	}

    
	
	
}else{
$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_CATEGORY);



while (!$show_display_category->EOF) {

  // //  echo 'I found ' . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS);



?>



<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_FEATURED_PRODUCTS') { ?>

<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>

<?php } ?>



<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_SPECIALS_PRODUCTS') { ?>

<?php

/**

 * display the Special Products Center Box

 */

?>

<?php //require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>

<?php } ?>



<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_NEW_PRODUCTS') { ?>

<?php

/**

 * display the New Products Center Box

 */

?>

<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>

<?php } ?>



<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_UPCOMING') { ?>

<?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS)); ?><?php } ?>

<?php

  $show_display_category->MoveNext();

}	
}
 // !EOF

?>
