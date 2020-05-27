<?php
if (substr_count($_COOKIE["zencart_cookie_cart"], ";") >= 1 && empty($_SESSION['customer_id']) && $_SESSION["cart"]->count_contents() < 1) {
	$cart_str = $_COOKIE["zencart_cookie_cart"];
	$cart = explode(';', $cart_str);
	for ($i = 0; $i < sizeof($cart) - 1; $i = $i + 2){
		$_SESSION['cart']->add_cart($cart[$i], $cart[$i + 1]);
	}

	setcookie("zencart_cookie_cart", "expired", time() - 3600);
}

if (!isset($_GET['action'])){
	if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'normal';
} else {
	if ($_GET['action'] == 'normal'){
		$_SESSION['display_mode'] = 'normal';
	} elseif ($_GET['action'] == 'quick') {
		$_SESSION['display_mode'] = 'quick';
	}
}

if ($this_is_home_page) {	
	$this_is_product_list_page = false;
	$home_link['new_arrival']=zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=new');
	$home_link['promotion']=zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=promotion');
	$home_link['promotion_status'] = zen_is_promotion_display() ? true : false; // && zen_is_promotion_time()
	$home_link['feature']=zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=feature');
	$home_link['top_seller']=zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=best_seller');
	$home_link['site_map']=zen_href_link(FILENAME_SITE_MAP);
	$home_link['my_account']=zen_href_link(FILENAME_MYACCOUNT);
	$smarty->assign ( 'home_link', $home_link );
			
	$define_page = zen_get_file_directory(DIR_WS_LANGUAGES  . $_SESSION['language'] .'/html_includes/', 'define_mobile_homepage.php', 'false');
	$smarty->assign ( 'define_page', $define_page );
	$tpl = DIR_WS_TEMPLATE.'tpl/tpl_index_homepage.html';
	
} else {
	$category_depth = 'top';	
	$category_close_num = 0;
	$check_sub_category = $db->Execute("select categories_id , left_display, categories_status from ".TABLE_CATEGORIES." where parent_id='".$current_category_id."'");
	if($check_sub_category->RecordCount()>0){
		$display_products_flag = true;
		while(!$check_sub_category->EOF){
			if($check_sub_category->fields['left_display'] == 10){
				$display_products_flag = false;
			}
			if($check_sub_category->fields['categories_status'] != 1){
				$category_close_num++;
			}
			$check_sub_category->MoveNext();
		}
		
		if($category_close_num < $check_sub_category->RecordCount()){
			if(count($cPath_array)>2){
				$category_depth = 'products';
			}else{
				if(count($cPath_array) > 1){
					if(!$display_products_flag ){
						$check_normal_subcate_query = $db->Execute("select categories_id , left_display, categories_status from ".TABLE_CATEGORIES." where parent_id='".$current_category_id."' and categories_status = 1 and left_display = 10");
						
						if($check_normal_subcate_query->RecordCount() > 0){
							$category_depth = 'nested';
						}else{
							$category_depth = 'products';
						}
					}else{
						$category_depth = 'products';
					}
				}else{
					$category_depth = 'nested';
				}
			}
		}else{
			$category_depth = 'nested';
		}
	}else{
		$category_depth = 'products';
	}
	
	$current_category_info = get_category_info_memcache($current_category_id);
	if ($current_category_info['categories_status'] > 0) {
		if($category_depth=='nested'){
			require(DIR_WS_MODULES . zen_get_module_directory('category_row'));
// 			var_dump($list_box_contents);exit;
			$tpl = DIR_WS_TEMPLATE.'tpl/tpl_index_category_list.html';
		}else{
			$this_is_product_list_page = true;
			$current_time = time();

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
		  	
		  	$extra_select_str = 'categories_id:' . ( int ) $current_category_id;
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
		  	//best match
		  	if($current_page_base==FILENAME_DEFAULT && $_GET['disp_order']==30){
		  		require(DIR_WS_MODULES.'product_best_match.php');
		  	}
		  	require(DIR_WS_MODULES . zen_get_module_directory('property.php'));
		  	require(DIR_WS_MODULES . zen_get_module_directory('display_sort_number.php'));
		  	include(DIR_WS_MODULES . zen_get_module_directory('product_gallery_by_property'));
		}
	}else{
		$tpl = DIR_WS_TEMPLATE.'tpl/define_categories_not_found.html';
	}
}

$helper = $facebook->getRedirectLoginHelper();
$permissions = ['email', 'public_profile'];
$loginUrl = $helper->getLoginUrl(HTTP_SERVER.'/ajax_facebook_login.php', $permissions);

$smarty->assign ( 'tpl', $tpl );
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
?> 