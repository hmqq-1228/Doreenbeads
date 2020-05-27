<?php
/**
 * index category_row.php
 *
 * Prepares the content for displaying a category's sub-category listing in grid format.	
 * Once the data is prepared, it calls the standard tpl_list_box_content template for display.
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce 
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: category_row.php 4084 2006-08-06 23:59:36Z drbyte $
 * @modified	lxy 2013-08-02
 */

if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

$list_box_contents = array();
foreach ($categories as $key => $value){
//while (!$categories->EOF) {
	//jessa 2010-09-26
	if ($value['categories_id'] == '1318'){
		if (! isset($_SESSION['customer_id']) || ! zen_not_null($_SESSION['customer_id']))
			//$categories->MoveNext();
			continue;
	}
	$category_info_array = get_category_info_memcache($value['categories_id']);
	$categoryParam['count'] = $category_info_array['products_count'];

	// Dont display the category that donot have products  add if statement
	if($categoryParam['count'] <= 0){
		//$categories->MoveNext();
		continue;
	}
	if (!$value['categories_image']) $value['categories_image'] = 'pixel_trans.gif';
	//$categoryParam['image'] = zen_image(DIR_WS_IMAGES . $value['categories_image'], $value['categories_name'], MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT);
	$categoryParam['image']	= '<img src="'.DIR_WS_IMAGES . $value['categories_image'].'" title="'.$value['categories_name'].'" alt="'.$value['categories_name'].'" height="120" width="120">';
	$cPath_new = 'cPath=' . $category_info_array['cPath'];
	// strip out 0_ from top level cats
	$categoryParam['link'] = zen_href_link(FILENAME_DEFAULT, $cPath_new);

	$categoryParam['name'] = $value['categories_name'];

	//	if this is category-level-2, show 4&5
	$categoryParam['sub'] = array();
	if($current_category_id == $cPath_array[1]){
		$categoryParam['sub'] = zen_get_category_tree($value['categories_id'], '0', '', null, '0_'.$cPath.'_'.$value['categories_id'], false, true);
	}
	
	$list_box_contents[] = $categoryParam;

	//$categories->MoveNext();
}
?>
