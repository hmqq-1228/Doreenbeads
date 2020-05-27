<?php
if (! isset ( $_GET ['action'] )) {
	if (! isset ( $_SESSION ['display_mode'] )) $_SESSION ['display_mode'] = 'normal';
} else {
	if ($_GET ['action'] == 'normal') {
		$_SESSION ['display_mode'] = 'normal';
	} else {
		$_SESSION ['display_mode'] = 'quick';
	}
}
$pagename = $_GET['pn'];
$show_propery = false;
$show_index = false;
$show_list = true;

$this_is_product_list_page = true;
$this_is_best_match_category = true;

$languages_id = intval($_SESSION['languages_id']);

$has_cate = false;
if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) {
	$has_cate = true;
	$page_link = zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=' . $pagename);
}

if (isset ( $_GET ['products_id'] ) && $_GET ['products_id'] != 0) {
	$similar_products_id = zen_db_input($_GET['products_id']);
	if (!$similar_products_id) {
		zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}

	$tag_id_query = $db->Execute("SELECT tag_id FROM " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " WHERE products_id = " . $similar_products_id . " LIMIT 1");

	if ($tag_id_query->RecordCount() <= 0 ) {
		zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}else{
		$tag_id = $tag_id_query->fields['tag_id'];
	}
}

switch ($pagename){
	case 'new':
		$show_propery = true;
		$has_cate ? $breadcrumb->add ( TEXT_NEW_ARRIVALS, $page_link ) : $breadcrumb->add ( TEXT_NEW_ARRIVALS );
		break;
	case 'feature':
		$show_propery = true;
		$has_cate ? $breadcrumb->add ( TEXT_FEATURED_PRODUCTS, $page_link ) : $breadcrumb->add ( TEXT_FEATURED_PRODUCTS );
		break;
	case 'matching':
		$has_cate ? $breadcrumb->add ( TEXT_MATCHED_ITEMS, $page_link ) : $breadcrumb->add ( TEXT_MATCHED_ITEMS );
		break;
	case 'like':
		$has_cate ? $breadcrumb->add ( TEXT_ALSO_LIKE, $page_link ) : $breadcrumb->add ( TEXT_ALSO_LIKE );
		break;
	case 'purchased':
		$has_cate ? $breadcrumb->add ( TEXT_PURCHASED_PRODUCTS, $page_link ) : $breadcrumb->add ( TEXT_PURCHASED_PRODUCTS );
		break;
	case 'best_seller':
		$show_propery = true;
		$has_cate ? $breadcrumb->add ( TEXT_BEST_SELLER, $page_link ) : $breadcrumb->add ( TEXT_BEST_SELLER );
		break;
	case 'promotion_price':
		$show_propery = true;
		$area_id = (isset($_GET['g']) && intval($_GET['g']) >0 ? intval($_GET['g']) : '');
		
		if($area_id)
		{
			$promotion_area_query_result =get_product_dailydeal_area_info($area_id,$languages_id);
			
			if($promotion_area_query_result->RecordCount() >0)
			{
				if (!$promotion_area_query_result->EOF) {
					$promotion_area_info = $promotion_area_query_result ->fields;
				}
			}
		
			if(!$promotion_area_info)
			{  
				//记录无效链接
				record_valid_url();
				//eof
				zen_redirect(zen_href_link(FILENAME_DEFAULT));
			}
		}
		
		$page_link = $page_link.(isset($_GET['disp_order']) ? '&disp_order='. $_GET['disp_order'] : ''); 
		if($promotion_area_info)
		{
			$base_link_title = $promotion_area_info['area_name'];
			$page_link .='&g='.$promotion_area_info['dailydeal_area_id']; 
			$body_header_title = $promotion_area_info['area_name']; 
		}else
		{
			$base_link_title = TEXT_DEALS;
			$body_header_title = TEXT_DEALS;
		} 
		
		$has_cate ? $breadcrumb->add ( $base_link_title, $page_link ) : $breadcrumb->add ( $base_link_title );
		break;
	case 'mix':
		$show_propery = true;
		$has_cate ? $breadcrumb->add ( HEADER_MENU_MIX, $page_link ) : $breadcrumb->add ( HEADER_MENU_MIX );
		break;
	case 'similar':
		$show_propery = true;
		$has_cate ? $breadcrumb->add ( TEXT_SIMILAR_PRODUCTS, $page_link ) : $breadcrumb->add ( TEXT_SIMILAR_PRODUCTS );
		$body_header_title = TEXT_SIMILAR_PRODUCTS;
		break;
	default :
		$breadcrumb->add ( TEXT_NEW_ARRIVALS );
}

if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) {
	$category_id = $_GET ['cId'];
	$result_array = array();
	zen_get_parent_categories_new($result_array, $category_id);
	$all_parents_cate_id = $result_array['categories_arr'];
	if (sizeof($all_parents_cate_id) > 0) {
		for ($i = 0, $n = sizeof($all_parents_cate_id); $i < $n; $i++){
			$cate_name = get_category_info_memcache($all_parents_cate_id[$i] , 'categories_name');
			$breadcrumb->add ( $cate_name, zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, zen_get_all_get_params(array('cId')) . 'cId=' . $all_parents_cate_id[$i]) );
		}
	}
	$cate_name = get_category_info_memcache($category_id , 'categories_name');
	$breadcrumb->add ( $cate_name );
}

if (!in_array($_GET['pn'], array('matching', 'like', 'purchased'))) {
	$current_time = time();
	$normal_category_list_show = true;
	$solr_str_array = get_listing_display_order($disp_order_default);
	$solr_order_str = $solr_str_array['solr_order_str'];
	$order_by = $solr_str_array['order_by'];
	$solr = new Apache_Solr_service(SOLR_HOST , SOLR_PORT ,'/solr/dorabeads_'.$_SESSION['languages_code']);
		
	if(is_numeric(ITEM_PERPAGE_MOBILE)){
		$item_per_page = ITEM_PERPAGE_MOBILE;
	}else{
		$item_per_page = 20;
	}
	 
	if (isset ( $_GET ['page'] ) && $_GET ['page'] != '' && is_numeric($_GET['page']) ) {
		$current_page = ( int ) (trim ( $_GET ['page'] ));
	} else {
		$current_page = 1;
	}
	 
	$search_offset = ($current_page - 1) * $item_per_page;
	 
	$result_array = zen_get_product_row_solr_str();
	$properties_select = $result_array['properties_select'];
	$delArray = $result_array['delArray'];
	$getsInfoArray = $result_array['getsInfoArray'];
	$propertyGet = $result_array['propertyGet'];
	$extra_select_str = $result_array['extra_select_str'];
	$property_by_group = $result_array['property_by_group'];
	 
	switch ($_GET ['pn']) {
		case 'new' :
			$extra_select_str =  'is_new:1 and new_arrivals_display:10' . $extra_select_str;
			$solr_select_query .= $extra_select_str . $properties_select;
			$body_header_title = TEXT_NEW_ARRIVALS;
			break;
// 		case 'feature' :
// 			$extra_select_str = 'is_featured:1' . $extra_select_str;
// 			$solr_select_query .= $extra_select_str . $properties_select;
// 			$body_header_title = TEXT_FEATURED_PRODUCTS;
// 			break;
		case 'best_seller' :
			$extra_select_str = 'is_hot_seller:1' . $extra_select_str;
			$solr_select_query .= $extra_select_str . $properties_select;
			$body_header_title = TEXT_BEST_SELLER;
			break;
		case 'mix' :
			$extra_select_str = 'is_mixed:1' . $extra_select_str;
			$solr_select_query .= $extra_select_str . $properties_select;
			$body_header_title = TEXT_MIXED_PRODUCTS;
			break;
		case 'subject' : 
			if (!($_GET['aId'] && is_numeric($_GET['aId']))) {
				zen_redirect(zen_href_link(FILENAME_DEFAULT));
			}
			
			$subject_info = get_subject_area_info($_GET['aId']);
			
			$show_subject_index = $subject_info['showIndexMobile'];
			$show_subject_index_type = $subject_info['indexTypeMobile'];
			
			if($show_subject_index){
			    if($show_subject_index_type == 10){
			        $show_index = true;
			        $show_list = false;
			        $show_subject_index = true;
			    }else{
			        $show_index = true;
			        $show_list = true;
			        $show_subject_index = false;
			    }
			}
			
			if((isset($_GET['cId'])&&$_GET['cId']!=0)||isset($_GET['pcount'])){
			    if($show_subject_index && $show_subject_index_type == 10){
			        $show_index = false;
			    }
			    $show_subject_index = false;
			    $show_list = true;
			}
			
			if($show_index){
			    $index_content_query = $db->Execute('select area_index from ' . TABLE_SUBJECT_AREA_DESCRIPTION_MOBILE . ' where subject_id = ' . (int)$_GET['aId'] . ' and language_id = ' . $_SESSION['languages_id']);
			    
			    if($index_content_query->RecordCount() > 0 && $index_content_query->fields['area_index'] != ''){
			        $area_index = $index_content_query->fields['area_index'];
			    }
			}
			
			if (!$subject_info || $subject_info['status'] != 1) {
				//记录无效链接
				record_valid_url();
				//eof
				
				zen_redirect(zen_href_link(FILENAME_DEFAULT));
			}
			
			$extra_select_str = 'subject_id:'.(int)($_GET['aId']) . $extra_select_str;
			$solr_select_query .= $extra_select_str . $properties_select; 
			$body_header_title = $subject_info['language_name'][$_SESSION ['languages_id']];
			break;
		case 'similar':
			$extra_select_str = 'tag_id:'. $tag_id . $extra_select_str;
			$solr_select_query .= $extra_select_str.$properties_select;
			break;
		default :
			$solr_select_query .= 'categories_id:' . ( int ) $current_category_id . $properties_select;
	}

	if(in_array($_GET['pack'], array('0', '1', '2'))){
		$solr_select_query .= ' AND package_size:' . $_GET['pack'];
	}
	if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
		$solr_select_query .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
	}
	if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
		$solr_select_query .= ' AND -products_quantity:0';
		//$solr_select_query .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
	}
	if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
		$solr_select_query .= ' AND is_mixed:1';
	}
	
	$products_row_array = zen_get_product_row_solr($solr, $solr_order_str, $solr_select_query, $search_offset, $item_per_page);
	$count_res = $products_row_array['count_res'];
	$num_products_count = $products_row_array['num_products_count'];
	$products_new_split = $products_row_array['products_new_split'];
	$properties_facet = $products_row_array['properties_facet'];
	$categories_facet = $products_row_array['categories_facet'];
	$categories_refine_by = $products_row_array['categories_refine_by'];
	$product_all = $products_row_array['product_all'];
	$condition = $products_row_array['condition'];
	 
	$product_res = array();
	$display_product_cnt = 0;
	foreach($product_all as $prod_val){
		$product_res[] = $prod_val->products_id;
		$display_product_cnt++;
	}
	 
	if (empty($body_header_title) && $current_category_id && is_numeric($current_category_id)) {
		$current_category = get_category_info_memcache($current_category_id,'detail');
		 
		if ($current_category) {
			$body_header_title = $current_category['categories_name'];
		}
	}
	 
	$this_is_search_action = false;
	$smarty->assign ( 'this_is_search_action', $this_is_search_action );
	$smarty->assign ( 'body_header_title', $body_header_title );
	$smarty->assign ( 'result_count', $num_products_count );
	$smarty->assign ( 'view_only_sale_url', zen_href_link($_GET['main_page'], zen_get_all_get_params(array('products_filter_onsale', 'page')) . (!isset($_GET['products_filter_onsale']) ? 'products_filter_onsale=1' : '')) );
	 
	//记录无效链接
	record_valid_url(true , $num_products_count , 0);
	//eof
	//best match
	if($current_page_base==FILENAME_DEFAULT && $_GET['disp_order']==30){
		require(DIR_WS_MODULES.'product_best_match.php');
	}
	require(DIR_WS_MODULES .  zen_get_module_directory('property.php'));
	require(DIR_WS_MODULES .  zen_get_module_directory('display_sort_number.php'));
	include(DIR_WS_MODULES . zen_get_module_directory('product_gallery_by_property'));
}else{
	
}

$smarty->assign ( 'show_index', $show_index );
$smarty->assign ( 'show_list', $show_list );
$smarty->assign ( 'area_index', $area_index );

if (!$has_cate && $_GET['aId'] == 31) {
	$smarty->assign ( 'tpl', DIR_WS_LANGUAGES  . $_SESSION['language'] .'/html_includes/define_mobile_products_common_list.php' );
}else{
	$smarty->assign ( 'tpl', $tpl );
}

?>
