<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE_1,HTTP_SERVER.'/page.html?id=218');

$solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $_SESSION['languages_code']);
if (! isset ( $_GET ['action'] )) {
	if (! isset ( $_SESSION ['display_mode'] ))
		$_SESSION ['display_mode'] = 'normal';
} else {
	if ($_GET ['action'] == 'normal') {
		$_SESSION ['display_mode'] = 'normal';
	} elseif ($_GET ['action'] == 'quick') {
		$_SESSION ['display_mode'] = 'quick';
	}
}
if((!empty($_GET['disp_order']) && !in_array($_GET['disp_order'], array(3, 4, 5, 6, 7, 30)) || (!empty($_GET['per_page']) &&!in_array($_GET['per_page'], array(30, 60, 90)))) ) {
	header("HTTP/1.0 404");
    exit();
}

$disp_order_default = PRODUCT_FEATURED_LIST_SORT_DEFAULT;

if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != '') {
	$top_cate = $_GET ['cId'];
	$subcategory = zen_get_subcategories ( $subcategories_array, $top_cate );
	$subcategory_id = @implode ( ',', $subcategories_array );
	if (zen_not_null ( $subcategory_id )) {
		$subcategory_id .= ',' . $top_cate;
		$filter_str = " AND ptc.categories_id in (" . $subcategory_id . ") ";
	} else {
		$filter_str = " AND ptc.categories_id = '" . $top_cate . "' ";
	}
} else {
	$filter_str = '';
}

$normal_category_list_show = true;

$do_not_show_products_listing = false ;

$solr_order_str = 'products_ordered desc, products_date_added desc';
if (isset ( $_SESSION ['per_page'] )) {
	$item_per_page = $_SESSION ['per_page'];
} else {
	$item_per_page = ITEM_PERPAGE_SMALL;
}
if (isset ( $_GET ['per_page'] )){
	$item_per_page = $_GET ['per_page'];
}
if (! in_array ( $item_per_page, array (ITEM_PERPAGE_SMALL,ITEM_PERPAGE_DEFAULT,ITEM_PERPAGE_LARGE))){
	$item_per_page = ITEM_PERPAGE_SMALL;
}

if (isset ( $_GET ['page'] ) && $_GET ['page'] != '' && is_numeric ( $_GET ['page'] )) {
	$current_page = ( int ) (trim ( $_GET ['page'] ));
} else {
	$current_page = 1;
}

if (! isset ( $_GET ['action'] )) {
	if (! isset ( $_SESSION ['display_mode'] )){
		$_SESSION ['display_mode'] = 'normal';
	}
} else {
	if ($_GET ['action'] == 'quick') {
		$_SESSION ['display_mode'] = 'quick';
	} else {
		$_SESSION ['display_mode'] = 'normal';
	}
}

$solr_order_str = '';
$order_by = '';
$solr_str_array = get_listing_display_order($disp_order_default);
$solr_order_str = $solr_str_array['solr_order_str'];
$order_by = $solr_str_array['order_by'];

$result_array = zen_product_property_display($item_per_page, $current_page);
$delArray = $result_array['delArray'];
$propertyGet = $result_array['propertyGet'];
$getsInfoArray = $result_array['getsInfoArray'];
$extra_select_str = $result_array['extra_select_str'];
$search_offset = $result_array['search_offset'];
$properties_select = $result_array['properties_select'];
$property_by_group = $result_array['property_by_group'];

$extra_select_str = 'is_new:1 and new_arrivals_display:20' . $extra_select_str;

$solr_select_query .= $extra_select_str . $properties_select;

$solr_result_array = get_product_property_solr($solr, $solr_select_query, $solr_order_str, $search_offset, $item_per_page);
$num_products_count = $solr_result_array['num_products_count'];
$properties_facet = $solr_result_array['properties_facet'];
$product_all = $solr_result_array['product_all'];
$products_new_split = $solr_result_array['products_new_split'];
$condition = $solr_result_array['condition'];

$product_res = array ();
$display_product_cnt = 0;
foreach ( $product_all as $prod_val ) {
	$product_res [] = $prod_val->products_id;
	$display_product_cnt ++;
}
//记录无效链接
record_valid_url(true , $display_product_cnt , 0);

$breadcrumb->add(NAVBAR_TITLE_2,zen_href_link(FILENAME_NON_ACCESSORIES));
if ($_SESSION ['display_mode'] == 'normal') {
	$result_array = get_product_list_by_property($products_new_split, $product_res);
	$list_box_contents_property = $result_array['list_box_contents_property'];
	$error_categories = $result_array['error_categories'];
} else {
	$result_array = get_products_gallery_by_property($products_new_split, $product_res);
	$show_products_content = $result_array['show_products_content'];
}

$normal_category_list_show = true;
$show_matched_property_listing = true;

$result_array = zen_get_property($solr, $properties_facet, $current_page_base, $delArray, $getsInfoArray, $property_by_group, $extra_select_str, $normal_category_list_show, $show_matched_property_listing, $search_offset, $item_per_page, $condition);
$pcontents = $result_array['content'];
$getsProInfo = $result_array['getsProInfo'];
?>