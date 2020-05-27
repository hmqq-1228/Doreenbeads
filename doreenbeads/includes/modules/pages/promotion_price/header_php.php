<?php 
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $_SESSION['languages_code']);
if((!empty($_GET['disp_order']) && !in_array($_GET['disp_order'], array(3, 4, 5, 6, 7, 30)) || (!empty($_GET['per_page']) &&!in_array($_GET['per_page'], array(40, 60, 90)))) ) {
	header("HTTP/1.0 404");
    exit();
}

if(!isset($_GET['g']) || $_GET['g'] == 0){
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

$disp_order_default = 30;
$promotion_price_id =  intval($_GET['g']);
$languages_id = intval($_SESSION['languages_id']);
$solr_order_str = 'products_ordered desc, products_date_added desc';
$css_image_path = "includes/templates/cherry_zen/css/".$_SESSION['languages_code']."/images/";
$current_datetime = strtotime(date('Y-m-d H:i:s'));
$promotion_price_name_query = $db->Execute("select dad.area_name , area_status , start_date , end_date from " . TABLE_DAILYDEAL_AREA . " zda INNER JOIN " . TABLE_DAILYDEAL_AREA_DESCRIPTION . " dad on zda.dailydeal_area_id = dad.area_id WHERE dailydeal_area_id = " . $promotion_price_id . " and dad.languages_id = " . zen_db_input($_SESSION['languages_id']));
$start_datetime = strtotime($promotion_price_name_query->fields['start_date']);
$end_datetime = strtotime($promotion_price_name_query->fields['end_date']) != false ? strtotime($promotion_price_name_query->fields['end_date']) : PHP_INT_MAX;

if($promotion_price_name_query->RecordCount() == 0 || $promotion_price_name_query->fields['area_status'] == 0 ||  $current_datetime < $start_datetime || $current_datetime > $end_datetime){
	//记录无效链接
	record_valid_url();
	//eof
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}else{
	$breadcrumb->add ( $promotion_price_name_query->fields['area_name'] );
}

if (isset ( $_SESSION ['per_page'] )) {
	$per_page_num = $_SESSION ['per_page'];
} else {
	$per_page_num = ITEM_PERPAGE_DEFAULT;
}
if (isset ( $_GET ['per_page'] )){
	$per_page_num = $_GET ['per_page'];
}
if (! in_array ( $per_page_num, array (PRODUCT_NAME_MAX_LENGTH,ITEM_PERPAGE_DEFAULT,ITEM_PERPAGE_LARGE))){
	$per_page_num = 60;
}

if (isset ( $_GET ['page'] ) && $_GET ['page'] != '' && is_numeric ( $_GET ['page'] )) {
	$current_page = ( int ) (trim ( $_GET ['page'] ));
} else {
	$current_page = 1;
}

$solr_order_str = '';
$order_by = '';
$solr_str_array = get_listing_display_order($disp_order_default);
$solr_order_str = $solr_str_array['solr_order_str'];
$order_by = $solr_str_array['order_by'];
$disp_order = $_GET['disp_order'];

$extra_select_str = 'is_dailydeal:1' . ' AND daily_deal_id:' . $promotion_price_id;
$search_offset = ($current_page-1) * $per_page_num;

$current_time = time();
$extra_time_str = ' AND +daily_deal_start_time:[0 TO ' . $current_time . ']';
$extra_time_str .= ' AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']';
$solr_select_query .= $extra_select_str . $extra_time_str;

$cate_solr_array = get_product_property_solr($solr, $solr_select_query, $solr_order_str, $search_offset, $per_page_num);
$num_products_count = $cate_solr_array['num_products_count'];
$properties_facet = $cate_solr_array['properties_facet'];
$product_all = $cate_solr_array['product_all'];
$products_new_split = $cate_solr_array['products_new_split'];
$condition = $cate_solr_array['condition'];

$product_res = array ();
foreach ( $product_all as $prod_val ) {
	$product_res [] = $prod_val->products_id;
}

$products_str = implode(',', $product_res);
if(sizeof($product_res) > 0){
	$dailydeal_products_info_query = $db->Execute("SELECT p.products_id, p.products_image, p.products_price,products_quantity_order_min,
				                                    p.products_tax_class_id, p.products_date_added, p.products_model,dp.products_img,dp.dailydeal_products_start_date,
													dp.dailydeal_products_end_date, dp.dailydeal_price
				                             FROM (" . TABLE_PRODUCTS . " p inner join " .TABLE_DAILYDEAL_PROMOTION." dp on dp.products_id = p.products_id) INNER JOIN " . TABLE_DAILYDEAL_AREA . " zda on dp.area_id = zda.dailydeal_area_id
				                             WHERE p.products_status = 1
				                             and zda.area_status = 1
											 AND dp.dailydeal_products_end_date >  '". date('Y-m-d H:i:s') ."'
											 AND dp.area_id= " . zen_db_input($promotion_price_id) . "
											 and dp.products_id in (" . $products_str . ")
											 and dailydeal_is_forbid = 10 
											 order by field(dp.products_id, " . $products_str . ")");
	
	if($dailydeal_products_info_query->RecordCount() > 0){
		while(!$dailydeal_products_info_query->EOF){
			$product_id = $dailydeal_products_info_query->fields['products_id'];
			$promotion_price_split[$product_id] = $dailydeal_products_info_query->fields;
			$original_price = zen_get_products_quantity_discounts($product_id);
			$original_price = round($original_price,2);
			$promotion_price_split[$product_id]['products_price'] = $original_price;
			
			$dailydeal_products_info_query->MoveNext();
		}
	}

}else{
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

$promotion_price_info = get_product_property_solr($solr, $solr_select_query, $solr_order_str, $search_offset, $per_page_num);
$display_area_num = $promotion_price_info['num_products_count'];

$max_page_num = ceil($display_area_num / $per_page_num);
$disp_array = array('3'=>TEXT_INFO_SORT_BY_PRODUCTS_PRICE,
		'4'=>TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC,
		'6'=>TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC,
		'7'=>TEXT_INFO_SORT_BY_PRODUCTS_DATE,
		'30'=>TEXT_INFO_SORT_BY_BEST_SELLERS);
?>