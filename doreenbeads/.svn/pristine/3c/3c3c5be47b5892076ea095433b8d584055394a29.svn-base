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
 * @modified   lxy 2013-08-02 
 */

	$list_box_contents = get_categories_row($categories, $current_category_id, $cPath_array, $cPath);

	if(isset($_GET['referer_level2']) && $_GET['referer_level2']==1 || isset($cPath_array[1]) && ! isset($cPath_array[2])){
		$my_expram = '?referer_level2=1';
	}else{
		$my_expram = '';
	}

	echo '<div class="category_list">';
	$col = 0;
	$cnt = count($list_box_contents);
	foreach($list_box_contents as $categoryParam){
		if($col > 0 && $col%4 == 0) echo "</ul>";
		if($col%4 == 0) echo "<ul>";
		echo '<li><a href="'.$categoryParam['link'].'">'.$categoryParam['image'].'</a><p><a href="'.$categoryParam['link'].$my_expram.'">'.$categoryParam['name'].'</a>'.'</p>';

// 		if($categoryParam['sub']){
// 			echo '<p class="list">';
// 			foreach($categoryParam['sub'] as $categoryParamSub){
// 				echo $categoryParamSub['level'] == 1 ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '';
// 				echo '<a href="'.zen_href_link(FILENAME_DEFAULT , $categoryParamSub['cPath']).'">>&nbsp;&nbsp;'.$categoryParamSub['text'] . '</a><br />';
// 			}
// 			echo '</p>';
// 		}

		echo '</li>';

		if($col++ > $cnt) echo '</ul>';
	}
	echo '</div>';
?>
