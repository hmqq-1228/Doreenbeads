<?php
$condition2['facet'] = 'true';
$condition2['facet.mincount'] = '1';
$condition2['facet.limit'] = '-1';
$condition2['facet.field'] = 'categories_id';
$condition2['f.categories_id.facet.missing'] = 'true';
$condition2['f.categories_id.facet.method'] = 'enum';

$list_category_array = array();
switch($current_page_base){
	case 'promotion':
		$category_select_solr_query = 'is_promotion:1' . $properties_select; 
		
		if($promotion_area_id)
		{ 
			$promotion_area_id = (isset($_GET['aId']) && intval($_GET['aId']) >0 ? intval($_GET['aId']) : '');
		}
		
		if(!$promotion_area_info && $promotion_area_id)
		{ 
			if($promotion_area_id)
			{
				$promotion_area_query = "select promotion_area_id,promotion_area_type,  related_promotion_ids,  promotion_area_name,  promotion_area_status,  promotion_area_languages,  show_index from " . TABLE_PROMOTION_AREA . "  where promotion_area_id=".$promotion_area_id." order by promotion_area_id desc limit 1";
				$promotion_area_query_result = $db->Execute($promotion_area_query);
			
				if($promotion_area_query_result->RecordCount() >0)
				{
					if (!$promotion_area_query_result->EOF) {
						$promotion_area_info = $promotion_area_query_result ->fields;
					}
				} 
			} 
		}
		
		if($promotion_area_id)
		{  
			$category_select_solr_query.=' AND promotion_area_id:'.$promotion_area_id;
		}
		
		if(!$promotion_off_info && isset ( $_GET ['off'] ) && $_GET ['off'])
		{
			$promotion_off_info = explode('_', $_GET ['off']); 
		}
		
		if($promotion_off_info && count($promotion_off_info)>0 )
		{
			$off_solr_array =array();
			foreach ($promotion_off_info as $item) {
				$off_solr_array[] = 'promotion_type:'.$item;
			}
		
			$category_select_solr_query .= ' AND('.implode(' OR ', $off_solr_array).')';
		}
		
		$current_time = time();
		$extra_time_str = ' AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']';
		
		$category_select_solr_query .= $extra_time_str;
		#var_dump($category_select_solr_query);die();
		//. (isset ( $_GET ['off'] ) ? ' AND promotion_type:' . ( int ) $_GET ['off'] . ' ' : '');
		break;
	case 'products_common_list':
		switch($_GET['pn']){
			case 'new':
				$category_select_solr_query = 'is_new:1 and new_arrivals_display:10' . $properties_select ;
				break;
// 			case 'feature':
// 				$category_select_solr_query = 'is_featured:1' . $properties_select;
// 				break;
			case 'best_seller':
				$category_select_solr_query = 'is_hot_seller:1' . $properties_select;
				break;
			case 'mix':
				$category_select_solr_query = 'is_mixed:1' . $properties_select;
				break;
			case 'subject':
				$category_select_solr_query = 'subject_id:'.intval($_GET['aId']) . $properties_select;
				break;
			case 'matching':
			case 'like':
			case 'purchased':
				$products_mixed_sql = $listing_sql;
				break;
			case 'similar':
				//var_dump($tag_id);
				$category_select_solr_query='tag_id: '. $tag_id .$properties_select ;
				break;
		}
		break;
	case 'advanced_search_result':
		if(!$error){
			$category_select_solr_query=$keywords.$properties_select;
		}
		break;
	case 'non_accessories':
		$category_select_solr_query = 'new_arrivals_display:20' . $properties_select; ;
		break;
}

if($category_select_solr_query) {
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
        $products_display_solr_str = '';
    } else {
        $products_display_solr_str = ' AND is_display:1';
    }
    $category_select_solr_query .= $products_display_solr_str;
	$categories_facet=$solr->search($category_select_solr_query, 0, 0, $condition2)->facet_counts->facet_fields->categories_id;
	$get_all_cate_array = zen_get_all_cate_array();
	//Tianwen.Wan20170619->屏蔽Featured Categories
	$featured_id = "2066";
	foreach($categories_facet as $cate_id=>$cnum){
		if(is_numeric($cate_id)){
			$category_path_info=zen_get_category_id_path($cate_id);
			preg_match_all("/^" . $featured_id . "_/", $category_path_info['cpath'], $featured_matches);
			if($cate_id == $featured_id || !empty($featured_matches[0])) {
				continue;
			}
			if($category_path_info['level']<=2 && isset($get_all_cate_array[$cate_id])){
				$categoryListShowArray[$category_path_info['csort']]=array('id'=>$cate_id,'count'=>$cnum,'catePath'=>$category_path_info['cpath'],'name'=>$get_all_cate_array[$cate_id]['name'],'level'=>$category_path_info['level']);
			}
		}
	}
	ksort($categoryListShowArray,SORT_STRING);
	$list_category_array=array_chunk($categoryListShowArray,sizeof($categoryListShowArray));
}elseif ($products_mixed_sql != ''){
	$list_category_array = zen_get_categories_filter($products_mixed_sql);
}

//	no search result. lvxiaoyong 20131014
if($current_page_base == 'advanced_search_result' && (!$list_category_array || !$list_category_array[0])){
	$my_no_search_result = true;
	require(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/categories.php');
}else{
	require($template->get_template_dir('tpl_category_refine.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_category_refine.php');
}
?>