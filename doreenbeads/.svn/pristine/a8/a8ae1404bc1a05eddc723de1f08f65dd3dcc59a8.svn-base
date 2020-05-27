<?php
/**
 * index header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4371 2006-09-03 19:36:11Z ajeh $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_INDEX');

if (substr_count($_COOKIE["zencart_cookie_cart"], ";") >= 1 && empty($_SESSION['customer_id']) && $_SESSION["cart"]->count_contents() < 1) {
		$cart_str = $_COOKIE["zencart_cookie_cart"];
		$cart = explode(';', $cart_str);
		for ($i = 0; $i < sizeof($cart) - 1; $i = $i + 2){
			$_SESSION['cart']->add_cart($cart[$i], $cart[$i + 1]);
		}
		
		setcookie("zencart_cookie_cart", "expired", time() - 3600);
	}

	////jessa 2010-04-26��ֹ�û�ֱ�Ӵӵ�ַ�������ַ���bestseller��Ʒ
	if (isset($_GET['sort']) && $_GET['sort'] == '21d'){
		if (!$_SESSION['has_valid_order']){
			zen_redirect(zen_href_link(FILENAME_PRODUCTS_ALL));
		}
	}
	////eof jessa 2010-04-26
	
	//jessa 2010-05-03 �жϹ˿�ѡ���������ģʽ�����ѡ��Ĭ��Ϊ����ģʽ
	if (!isset($_GET['action'])){
		if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'normal';
	} else {
		if ($_GET['action'] == 'normal'){
			$_SESSION['display_mode'] = 'normal';
		} elseif ($_GET['action'] == 'quick') {
			$_SESSION['display_mode'] = 'quick';
		}
	}
	//eof jessa 2010-05-03
	
	//jessa 2010-08-31 ����addtowishlist��������ű�
	if (isset($_GET['action']) && $_GET['action'] == 'addToWishlist'){
		if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
			$pid = trim($_GET['pid']);
			$products_id_array = $_POST['products_id'];
			
			foreach ($products_id_array as $key => $value){
			  if ($key == $pid){
			  	zen_products_add_wishlist($_SESSION['customer_id'] , $key , $value);
			  } elseif (($key != $pid) && ((int)$value > 0)){
			  	zen_products_add_wishlist($_SESSION['customer_id'] , $key , $value);
			  }
			}
			$messageStack->add_session('header', 'Item(s) Added Successfully into Your Wishlist Account!&nbsp;&nbsp;<a href="' . zen_href_link('wishlist', '', 'SSL') . '">View Wishlist Account</a>', 'success');
			$all_params = zen_get_all_get_params(array('action', 'pid'));
			$all_params = str_replace('amp;', '', $all_params);
			zen_redirect(zen_href_link(FILENAME_DEFAULT, $all_params));
		} else {
			zen_redirect(zen_href_link(FILENAME_LOGIN));
		}
	}
	//��� 2010-08-31
// the following cPath references come from application_top/initSystem
$category_depth = 'top';
if (isset($cPath) && zen_not_null($cPath) && $cPath!=0) {
//	lvxiaoyong 20130802: category level 1&2:show sub-category, others show product list
	if($current_category_id == $cPath_array[0] || $current_category_id == $cPath_array[1]){
		$check_subcate_result = sizeof(get_category_info_memcache($current_category_id , 'subcate')) > 0 ? true : false;
		if ($check_subcate_result)
			$category_depth = 'nested';		//	display sub-category
		else		//	if has not sub-category, display products
			$category_depth = 'products';		//	display products
	}else
		$category_depth = 'products';		//	display products
}

// include template specific file name defines
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_MAIN_PAGE, 'false');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$solr = new Apache_Solr_service ( SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $_SESSION ['languages_code'] );

if($category_depth == 'products' || $cPathLength > 1){
	$normal_category_list_show=true;
	$show_matched_property_listing = true;

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
	
	$extra_select_str = 'categories_id:' . ( int ) $current_category_id;
	$current_time = time();
	if(in_array($_GET['pack'], array('0', '1', '2'))){
		$extra_select_str .= ' AND package_size:' . $_GET['pack'];
	}
	if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
		$extra_select_str .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
	}
	if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
		$extra_select_str .= ' AND -products_quantity:0';
		//$extra_select_str .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
	}
	if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
		$extra_select_str .= ' AND is_mixed:1';
	}

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
	
	if (! $do_not_show_products_listing) {
		if ($_SESSION ['display_mode'] == 'normal') {
			$result_array = get_product_list_by_property($products_new_split, $product_res);
			$list_box_contents_property = $result_array['list_box_contents_property'];
			$error_categories = $result_array['error_categories'];
		} else {
			$result_array = get_products_gallery_by_property($products_new_split, $product_res);
			$show_products_content = $result_array['show_products_content'];
		}
	}
	
	$category_info = get_category_info_memcache($current_category_id);
	if(isset($category_info['categories_status']) && $category_info['categories_status'] != 1){
		$show_matched_property_listing = false;
	}
	
	$result_array = zen_get_property($solr, $properties_facet, $current_page_base, $delArray, $getsInfoArray, $property_by_group, $extra_select_str, $normal_category_list_show, $show_matched_property_listing, $search_offset, $item_per_page, $condition);
	$pcontents = $result_array['content'];
	$getsProInfo = $result_array['getsProInfo'];
	
}

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_INDEX');

?>
