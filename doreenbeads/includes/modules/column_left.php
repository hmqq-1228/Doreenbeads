<?php
/**
 * column_left module
 *
 * @package templateStructure
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: column_left.php 4274 2006-08-26 03:16:53Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$column_box_default='tpl_box_default_left.php';
$showCategoryProperty=array('featured_products','products_new','products_best_seller','products_new_list','advanced_search_result','products_mixed');
$dontshowCategory=array('products_also_like_list','products_matched_list','product_info');
// Check if there are boxes for the column
$column_left_display= $db->Execute("select layout_box_name from " . TABLE_LAYOUT_BOXES . " where layout_box_location = 0 and layout_box_status= '1' and layout_template ='" . $template_dir . "'" . ' order by layout_box_sort_order');
// safety row stop
$box_cnt=0;
while (!$column_left_display->EOF and $box_cnt < 100) {
  $box_cnt++;
  if ( file_exists(DIR_WS_MODULES . 'sideboxes/' . $column_left_display->fields['layout_box_name']) or file_exists(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']) ) {
//$column_box_spacer = 'column_box_spacer_left';
	$column_width = BOX_WIDTH_LEFT;
	if($column_left_display->fields['layout_box_name']=='categories.php'){
		if($current_page_base == 'promotion' && $is_promotion_time && !$this_is_home_page){
			if ( file_exists(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']) ){
				require(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']);
			}else{
				require(DIR_WS_MODULES . 'sideboxes/' . $column_left_display->fields['layout_box_name']);
			}
		}else{
			$static_file = DIR_WS_TEMPLATES.'static/'.$_SESSION['languages_code'].'/common/categories_list'.$_GET['cPath'].'.html';
			if(zen_check_static($static_file, 7200)){
				include($static_file);
			}else{
				ob_start();
				$box_id = zen_get_box_id($column_left_display->fields['layout_box_name']);
				if ( file_exists(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']) ){			
					require(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']);
				}else{
					require(DIR_WS_MODULES . 'sideboxes/' . $column_left_display->fields['layout_box_name']);
				}
				$static_contents=ob_get_flush();
				file_put_contents($static_file, $static_contents);
			}
		}
		require(DIR_WS_TEMPLATE . 'sideboxes/tpl_property.php');
		
  	}else{
		if ( file_exists(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']) ) {
  			$box_id = zen_get_box_id($column_left_display->fields['layout_box_name']);
  			require(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_left_display->fields['layout_box_name']);
		} else {
  			$box_id = zen_get_box_id($column_left_display->fields['layout_box_name']);
  			require(DIR_WS_MODULES . 'sideboxes/' . $column_left_display->fields['layout_box_name']);
		}
  	}
  } // file_exists
  $column_left_display->MoveNext();
} // while column_left
$box_id = '';

?>