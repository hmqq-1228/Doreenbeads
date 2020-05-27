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
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$title = '';
$num_categories = $categories->RecordCount();

$row = 0;
$col = 0;
$list_box_contents = '';
if ($num_categories > 0) {
  if ($num_categories < MAX_DISPLAY_CATEGORIES_PER_ROW || MAX_DISPLAY_CATEGORIES_PER_ROW == 0) {
    $col_width = floor(100/$num_categories);
  } else {
    $col_width = floor(100/MAX_DISPLAY_CATEGORIES_PER_ROW);
  }

  while (!$categories->EOF) {
	//---------------------------
	// Robbie 2009-08-05
	// Dont display the category that donot have products  add if statement
	//----------------------------
  	$products_count = get_category_info_memcache($categories->fields['categories_id'] , 'products_count');
  	if ($products_count > 0)
  	{
	    if (!$categories->fields['categories_image']) !$categories->fields['categories_image'] = 'pixel_trans.gif';
	    $cPath_new = 'cPath=' . get_category_info_memcache($categories->fields['categories_id'] , 'cPath');
	
	    // strip out 0_ from top level cats
	    $cPath_new = str_replace('=0_', '=', $cPath_new);
	
	    //    $categories->fields['products_name'] = zen_get_products_name($categories->fields['products_id']);
		

	    if ($categories->fields['categories_id'] == '1318'){
	    	if (isset($_SESSION['customer_id']) && zen_not_null($_SESSION['customer_id'])){
	    		$list_box_contents[$row][$col] = array('params' => 'class="categoryListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
	                                           		   'text' => '<a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '"><img src="'.DIR_WS_IMAGES . $categories->fields['categories_image'].'" title="'.$categories->fields['categories_name'].'" alt="'.$categories->fields['categories_name'].'" height="120" width="120"><br />' . $categories->fields['categories_name'] . '</a>');
	             $col ++;
			     if ($col > (MAX_DISPLAY_CATEGORIES_PER_ROW -1)) {
			       $col = 0;
			       $row ++;
			     }
	    	}
	    } else {
	    //eof jessa 2010-09-26
		    $list_box_contents[$row][$col] = array('params' => 'class="categoryListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
		                                           'text' => '<a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '"><img src="'.DIR_WS_IMAGES . $categories->fields['categories_image'].'" title="'.$categories->fields['categories_name'].'" alt="'.$categories->fields['categories_name'].'" height="120" width="120"><br />' . $categories->fields['categories_name'] . '</a>');
		
		    $col ++;
		    if ($col > (MAX_DISPLAY_CATEGORIES_PER_ROW -1)) {
		      $col = 0;
		      $row ++;
		    }
	    }
	}
  	//eof robbie
    $categories->MoveNext();
  }
}
?>
