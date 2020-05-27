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

$promotion_area_id = (isset($_GET['aId']) && intval($_GET['aId']) >0 ? intval($_GET['aId']) : '');
$languages_id = intval($_SESSION['languages_id']);

$has_cate = false;
if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) {
	$has_cate = true;
	$page_link = zen_href_link(FILENAME_PROMOTION);
}

$show_propery = true;

$area_id = (isset($_GET['aId']) && intval($_GET['aId']) >0 ? intval($_GET['aId']) : '');

if($area_id)
{
	$promotion_area_query_result = get_product_promotion_area_info($area_id,$languages_id , 1);

	if($promotion_area_query_result->RecordCount() >0)
	{
		if (!$promotion_area_query_result->EOF) {
			$promotion_area_info = $promotion_area_query_result ->fields;
		}
	}
		
	if($promotion_area_info)
	{
		$promotion_area_info['related_language'] = explode(',', $promotion_area_info['promotion_area_languages']);

		if($promotion_area_info['promotion_area_status'] != 1 || (is_array($promotion_area_info['related_language']) && !in_array($_SESSION['languages_id'], $promotion_area_info['related_language'])))
		{
			//记录无效链接
			record_valid_url();
			//eof
			zen_redirect(zen_href_link(FILENAME_DEFAULT));
		}
	}else
	{
		//记录无效链接
		record_valid_url();
		//eof
		zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}
}

$page_link = $page_link.(isset($_GET['disp_order']) ? '&disp_order='. $_GET['disp_order'] : '');
$page_link = $page_link.(isset($_GET['off']) ? '&off='. $_GET['off'] : '');

if($promotion_area_info)
{
	$base_link_title = $promotion_area_info['promotion_area_name'];
	$page_link .='&aId='.$promotion_area_info['promotion_area_id'];
	$body_header_title = $promotion_area_info['promotion_area_name'];
	$show_promotion_index = $promotion_area_info['show_mobile_index'] == 1;
}else
{
	$base_link_title = TEXT_PROMOTION;
	$body_header_title = TEXT_PROMOTION;
	$show_promotion_index = false;
}

if(isset ( $_GET ['off'] ) && $_GET ['off'])
{
	$promotion_off_info = explode('_', $_GET ['off']);
	$show_promotion_index = false;
}

if ((isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) || isset ( $_GET ['off'] )) {
	$show_promotion_index = false;
}

if(isset ( $_GET ['pcount'] ) && $_GET ['pcount'])
{
	$show_promotion_index = false;
}

$has_cate ? $breadcrumb->add ( $base_link_title, $page_link ) : $breadcrumb->add ( $base_link_title );

$index_html = '';
if($show_promotion_index){
	$index_query_sql = 'select index_content from ' . TABLE_PROMOTION_AREA_MOBILE_INDEX . ' where promotion_area_id =' . $promotion_area_id . ' and languages_id =' . zen_db_input($_SESSION['languages_id']) . ' limit 1';
	$index_content = $db->Execute($index_query_sql);
	
	if($index_content->RecordCount() > 0 && $index_content->fields['index_content'] != ''){
		$index_html = $index_content->fields['index_content'];
	}else{
		$show_promotion_index = false;
	}
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
 
$extra_select_str = 'is_promotion:1' . $extra_select_str;
if($promotion_area_info)
{
	$extra_select_str.=' AND promotion_area_id:'.$promotion_area_info['promotion_area_id'];
}
	
if($promotion_off_info && count($promotion_off_info)>0)
{
	$off_solr_array =array();
	foreach ($promotion_off_info as $item) {
		$off_solr_array[] = 'promotion_type:'.$item;
	}

	$extra_select_str .= ' AND('.implode(' OR ', $off_solr_array).')';
}

if($current_page_base == 'promotion_deals')
{
	if($promotion_area_info)
	{
		$detail_result = get_product_promotion_deals_info($promotion_area_info['promotion_area_id'],$promotion_area_info['related_promotion_ids']);
		
		if($detail_result->RecordCount()>0)
		{
			$product_solr_array =array();
			while (!$detail_result->EOF) {
				$product_id = $detail_result ->fields['pp_products_id'];
				$product_info = get_products_info_memcache($product_id);
				if($product_info['products_status'] == 1){
					$product_solr_array[] = 'products_id:'.$detail_result ->fields['pp_products_id'];   
				}
				$detail_result->MoveNext();
			} 
			
			$extra_select_str .= ' AND('.implode(' OR ', $product_solr_array).')';
		}else
		{
			$extra_select_str .= ' AND products_id:0';
		}
	}else
	{
		$extra_select_str .= ' AND products_id:0';
	} 
} 

$current_time = time();
$extra_time_str = '';
if(in_array($_GET['pack'], array('0', '1', '2'))){
	$extra_time_str .= ' AND package_size:' . $_GET['pack'];
}
//if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
//	$extra_time_str .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
//}
if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
	$extra_time_str .= ' AND -products_quantity:0';
	//$extra_time_str .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
}
if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
	$extra_time_str .= ' AND is_mixed:1';
}

$solr_select_query .= $extra_select_str . $properties_select . $extra_time_str;
$body_header_title = $body_header_title?$body_header_title:TEXT_PROMOTION;

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

$smarty->assign ( 'show_promotion_index', $show_promotion_index );
$smarty->assign ( 'index_html', $index_html );
$smarty->assign ( 'tpl', $tpl );
?>