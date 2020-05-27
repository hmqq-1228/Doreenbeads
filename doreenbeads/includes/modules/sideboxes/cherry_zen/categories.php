<?php
/**
 * categories sidebox - prepares content for the main categories sidebox
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: categories.php 2718 2005-12-28 06:42:39Z drbyte $ 
 */
	$current_category_info = get_category_info_memcache($current_category_id);
    if (isset($current_category_info['categories_status']) && $current_category_info['categories_status'] <= 0) {
        $normal_category_list_show = false;
    }
	if(($current_page_base == 'promotion' && $is_promotion_time && !$this_is_home_page) || ($current_page_base == 'products_common_list'&& !in_array($_GET['pn'], array('matching','like','purchased'))) || ($current_page_base == 'advanced_search_result' && !$my_no_search_result) || ($current_page_base == 'non_accessories')){
		require(DIR_WS_MODULES . 'sideboxes/cherry_zen/category_refine.php');
	}else{
		$box_categories_array = array();
		$referer_from_level2 = false;
		
		if(isset($_GET['referer_level3']) && $_GET['referer_level3']==1){
			$referer_from_level2 = true;
		}
		$cnt_cPath_array = count($cPath_array);
		$is_level_2 = $is_level_3 = false;
		if(!isset($_GET['products_id']) && $cnt_cPath_array==2){
			$current_category_level = intval($cPath_array[0]);
			$my_cate_path = '0_'.$cPath_array[0];
			$is_level_2 = true;
		}else if(!isset($_GET['products_id']) && ($cnt_cPath_array==3 || $referer_from_level2) ){
			$current_category_level = intval($cPath_array[1]);
			$my_cate_path = '0';
			for($n=0; $n<2; $n++){
				$my_cate_path .= '_'.$cPath_array[$n];
			}
			$is_level_3 = true;
		}else{
			//here
			$current_category_level = 0;
			$my_cate_path = '0';
		}
		
		$filename  ='categories_'.$_SESSION['language'].'.php';
		//$time_path 缓存时间 单位为m
		$time_path = 30 ;
		$cache_page = (isset($_GET['cPath']) && $_GET['cPath']!='') ? 0 : 1;
		if($cache_page && $_GET['main_page']=='index'){
			$filename = 'categories_'.$_SESSION['language'].'_index.php';
			$content = file_cache_read($time_path,$filename);
			if(!$content){
				$check_categories = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_status=1 limit 1");
				if ($check_categories->RecordCount() > 0) {
					$extra_condition = ' and c.categories_id not in (1469, 1375, 1211, 1705, 1680) ';
					$box_categories_array = zen_get_category_tree($current_category_level, '0', '', null, $my_cate_path, false, true, $extra_condition);
					require($template->get_template_dir('tpl_categories.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_categories.php');
				}
			}else{
				echo $content;
			}
		}else{
			$box_categories_array = file_cache_read($time_path,$filename);
			if(!$box_categories_array){
				$check_categories = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_status=1 limit 1");
				if ($check_categories->RecordCount() > 0) {
					$extra_condition = ' and c.categories_id not in (1469, 1375, 1211, 1705, 1680) ';
					$box_categories_array = zen_get_category_tree(0, '0', '', null, '0', false, true, $extra_condition);
					$content = file_cache_write($time_path,$filename,serialize($box_categories_array));
				}
			}else{
				$box_categories_array = unserialize($box_categories_array);
				
			}
			
			require($template->get_template_dir('tpl_categories.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_categories.php');
		}
}
?>
