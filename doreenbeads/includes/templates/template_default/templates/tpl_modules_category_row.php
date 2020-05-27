<?php
/**
 * index category_row.php
 *
 * Prepares the content for displaying a category's sub-category listing in grid format.  
 * Once the data is prepared, it calls the standard tpl_list_box_content template for display.
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_category_row.php 2986 2006-02-07 22:27:29Z drbyte $
 */
  //jessa 2010-05-03 �������
//$master_category_array=explode('_', $cPath);
//$master_category_id=$master_category_array[sizeof($master_category_array)-1];
if(in_array($master_category_id, $clearance_categorise_array) && DISPLAY_SHOW_CLEARANCE_CATEGORIES_STATUS){ 
	$define_clearance_area = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CLEARANCE_AREA, 'false');
	require ($define_clearance_area);
}else{
  if ($_SESSION['display_mode'] == 'quick' && !$this_is_home_page){
	require(DIR_WS_MODULES . zen_get_module_directory('category_row_noimg.php'));
	require($template->get_template_dir('tpl_quick_columnar_display.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_quick_columnar_display.php');
  }else{
	$list_box_contents = get_categories_row($categories, $current_category_id, $cPath_array, $cPath);
	if (!$this_is_home_page){
		echo '<h2 class="centerBoxHeading">SubCategory</h2>';
	}
	require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
  }
}

  //eof jessa 2010-05-03
?>