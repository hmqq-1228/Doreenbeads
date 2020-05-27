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
$show_propery = false;

$this_is_product_list_page = true;
$this_is_best_match_category = true;

$languages_id = intval($_SESSION['languages_id']);

$has_cate = false;
if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) {
	$has_cate = true;
	$page_link = zen_href_link(FILENAME_PROMOTION_PRICE, 'pn=' . $pagename);
}

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

if($promotion_area_info){
	$detail_info = get_product_dailydeal_product_info($promotion_area_info['dailydeal_area_id']);
	$current_datetime = strtotime(date('Y-m-d H:i:s'));

	foreach ($detail_info['promotion_price_info'] as $products_promotion_info ){
		if(strtotime($products_promotion_info['dailydeal_products_start_date']) < $current_datetime && strtotime($products_promotion_info['dailydeal_products_end_date']) >= $current_datetime){
			$detail_result[] = $products_promotion_info;
		}
	}
	
	if(sizeof($detail_result)>0){
		$product_solr_array =array();
		foreach ($detail_result as $product_info_detail) {
			$product_solr_array[] = 'products_id:'.$product_info_detail['products_id'];
		}

		$extra_select_str = implode(' OR ', $product_solr_array) . $extra_select_str;
	}else{
		$extra_select_str = 'products_id:0' . $extra_select_str;
	}

}else{
	$extra_select_str = 'products_id:0' . $extra_select_str;
}

if(!empty($extra_select_str)) {
	$extra_select_str = '(' . $extra_select_str . ')';
}

$current_time = time();
if(in_array($_GET['pack'], array('0', '1', '2'))){
	$extra_select_str .= ' AND package_size:' . $_GET['pack'];
}
//if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
//	$extra_select_str .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
//}
if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
	$extra_select_str .= ' AND -products_quantity:0';
	//$extra_select_str .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
}
if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
	$extra_select_str .= ' AND is_mixed:1';
}
	
$solr_select_query .= $extra_select_str . $properties_select;
$body_header_title = $body_header_title?$body_header_title:TEXT_DEALS;

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

$smarty->assign ( 'tpl', $tpl );