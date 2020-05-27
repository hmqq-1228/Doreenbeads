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
<div class="centerColumn" id="indexCategories">
<?php if ($show_welcome == true) { ?>

<?php if (SHOW_CUSTOMER_GREETING == 1) { ?>
<h2 class="greeting"><?php echo zen_customer_greeting(); ?></h2>
<?php } ?>

<!-- deprecated - to use - uncomment
<?php if (TEXT_MAIN) { ?>
<div id="" class="content"><?php echo TEXT_MAIN; ?></div>
<?php } ?>-->

<!-- deprecated - to use - uncomment
<?php if (TEXT_INFORMATION) { ?>
<div id="" class="content"><?php echo TEXT_INFORMATION; ?></div>
<?php } ?>-->

<?php if (DEFINE_MAIN_PAGE_STATUS >= 1 and DEFINE_MAIN_PAGE_STATUS <= 2) { ?>
<div id="indexCategoriesMainContent" class="content"><?php
/**
 * require the html_define for the index/categories page
 */
  include($define_page);
?></div>
<?php require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_WEBSITE_INTRODUCE, 'false'));?>

<!--eof jessa 2010-01-17-->

<?php } ?>

<?php } else { ?>
<h1 id="indexCategoriesHeading"><?php echo $breadcrumb->last(); ?></h1>
<?php
$master_category_array=explode('_', $cPath);
$master_category_id=$master_category_array[sizeof($master_category_array)-1];
$clearance_categorise_array=explode(',', CLEARANCE_CATEGORY_ID);
  ////jessa 2010-05-03 �������back to
  $extra_params = '';
  if (isset($_GET['cPath'])) $extra_params .= '&cPath=' . $_GET['cPath'];
  if (isset($_GET['inc_subcat'])) $extra_params .= '&inc_subcat=' . $_GET['inc_subcat'];
  if (isset($_GET['search_in_description'])) $extra_params .= '&search_in_description=' . $_GET['search_in_description'];
  if (isset($_GET['keyword'])) $extra_params .= '&keyword=' . $_GET['keyword'];
  if (isset($_GET['categories_id'])) $extra_params .= '&categories_id=' . $_GET['categories_id'];  
  ////eof jessa 2010-05-03
?>
<?php } ?>

<?php

if ( ((isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'normal') || !isset($_SESSION['display_mode'])) && !$this_is_home_page && (!in_array($master_category_id, $clearance_categorise_array)||DISPLAY_SHOW_CLEARANCE_CATEGORIES_STATUS==0)){
	if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS_TOP == 'true') {
// categories_image
  		if ($categories_image = get_category_info_memcache($current_category_id , 'categories_image')) {
?>
<div id="categoryImgListing" class="categoryImg"><?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', SUBCATEGORY_IMAGE_TOP_WIDTH, SUBCATEGORY_IMAGE_TOP_HEIGHT); ?></div>
<?php
  }
?>
<br />
<?php
} // categories_image
?>

<?php
// categories_description
    if ($current_categories_description != '') {
?>
<div id="categoryDescription" class="catDescContent"><?php echo $current_categories_description;  ?></div>
<?php 
    }
}
//eof jessa 2010-05-03
// categories_description ?>
<!-- BOF: Display grid of available sub-categories, if any -->
<?php
if(isset($_SESSION['currency']) && zen_not_null($_SESSION['currency'])){		
	$static_currency = $_SESSION['currency'];			
}else{
	$static_currency = 'USD';
}

  if (PRODUCT_LIST_CATEGORY_ROW_STATUS == 0) {
    // do nothing
  } else {
    // display subcategories
/**
 * require the code to display the sub-categories-grid, if any exist
 */
  	if($this_is_home_page){
  		$static_file = DIR_WS_TEMPLATES.'static/common/pop_categories.html';
		if(zen_check_static($static_file, 1800)){
			include($static_file);
		}else{
			ob_start();		
  			require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
			$static_contents=ob_get_flush();
			file_put_contents($static_file, $static_contents);
			//var_dump($static_contents);exit;
		}
  	}else{
		$static_file = DIR_WS_TEMPLATES.'static/common/pop_categories.html';
		if(zen_check_static($static_file, 1800)){
			include($static_file);
		}else{
			ob_start();		
  			require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
			$static_contents=ob_get_flush();
			file_put_contents($static_file, $static_contents);
			//var_dump($static_contents);exit;
		}
  	}
  }
  // if($_GET['main_page'] != 'index')
  //robbie
 if ( $show_welcome != true  ){
 	if(in_array($master_category_id, $clearance_categorise_array) && DISPLAY_SHOW_CLEARANCE_CATEGORIES_STATUS){
 	require($template->get_template_dir('tpl_modules_clearance.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_clearance.php');
 	}else{
 	require($template->get_template_dir('tpl_category_product_list.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_category_product_list.php');
 	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick' && !$this_is_home_page){
 	}	
} }else { 
$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_CATEGORY);

while (!$show_display_category->EOF) {
  // //  echo 'I found ' . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS);

?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_NEW_PRODUCTS') {

/**
 * display the New Products Center Box
 */
	if($this_is_home_page){
//   		$static_file = DIR_WS_TEMPLATES.'static/common/index_new_products_'.$static_currency.'.html';
// 		if(zen_check_static($static_file, 1800)){
// 			include($static_file);
// 		}else{
// 			ob_start();		
//   			require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php');
// 			$static_contents=ob_get_flush();
// 			file_put_contents($static_file, $static_contents);			
// 		}
  	}else{
 		require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php');
  	}
  } 
?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_FEATURED_PRODUCTS') {

/**
 * display the Featured Products Center Box
 */
	if($this_is_home_page){
//   		$static_file = DIR_WS_TEMPLATES.'static/common/index_featured_products_'.$static_currency.'.html';
// 		if(zen_check_static($static_file, 1800)){
// 			include($static_file);
// 		}else{
// 			ob_start();		
//   			require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php');
// 			$static_contents=ob_get_flush();
// 			file_put_contents($static_file, $static_contents);			
// 		}
		require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_INDEX_FEATURED_PRODUCTS, 'false'));
  	}else{
 		require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php');
  	}
  } 
?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_SPECIALS_PRODUCTS') {

/**
 * display the Special Products Center Box
 */
	if($this_is_home_page){
  		$static_file = DIR_WS_TEMPLATES.'static/common/index_specials_products_'.$static_currency.'.html';
		if(zen_check_static($static_file, 1200)){
			include($static_file);
		}else{
			ob_start();		
  			require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php');
			$static_contents=ob_get_flush();
			file_put_contents($static_file, $static_contents);			
		}
  	}else{
 		require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php');
  	}
 } 
?>


<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_UPCOMING') { ?>
<?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS)); ?><?php } ?>
<?php
  $show_display_category->MoveNext(); 
 } // !EOF

 	}
 
 
  
?>
<!-- EOF: Display grid of available sub-categories -->
<?php

?>
</div>
