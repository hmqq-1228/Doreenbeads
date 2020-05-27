<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$solr = new Apache_Solr_service ( SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $_SESSION ['languages_code'] );

if (! isset ( $_GET ['action'] )) {
    if (! isset ( $_SESSION ['display_mode'] )) $_SESSION ['display_mode'] = 'normal';
} else {
    if ($_GET ['action'] == 'normal') {
        $_SESSION ['display_mode'] = 'normal';
    } else {
        $_SESSION ['display_mode'] = 'quick';
    }
}

$show_index = false;
$show_list = true;

$myhref = FILENAME_PRODUCTS_COMMON_LIST;
$mypara = '&pn='.$_GET['pn'];
if($_GET['pn'] == 'matching' || $_GET['pn'] == 'like' || $_GET['pn'] == 'purchased') $mypara .= '&pid='.trim ( $_GET ['pid'] );
if($_GET['pn'] == 'subject') $mypara .= '&aId='.trim ( $_GET ['aId'] );
if($_GET['pn'] == 'disp_order') $mypara .= '&disp_order='.trim ( $_GET ['disp_order'] );
if($_GET['pn'] == 'similar') $mypara .= '&products_id='.trim ( $_GET ['products_id'] );

$show_matched_property_listing = false;
if(isset($_GET['pcount']) || !empty($_GET['cId'])) {
    $show_matched_property_listing = true;
}

$pagename = $_GET['pn'];
$show_propery = false;

$has_cate = false;
if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) {
    $has_cate = true;
    $page_link = zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=' . $pagename);
}

if($pagename == 'subject')
{
    $aid = intval($_GET['aId']);
    if(! $aid){
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
    }

    $check_exists = $db->Execute("SELECT * FROM ".TABLE_SUBJECT_AREAS." WHERE id='".$aid."' LIMIT 1");
    if($check_exists->RecordCount() <= 0){
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
    }

    if(! defined('NAVBAR_TITLE') || NAVBAR_TITLE == ''){
        $name = unserialize($check_exists->fields['name']);
        $subject_name = $name[$_SESSION['languages_id']];
    }else{
        $subject_name = $name[NAVBAR_TITLE];
    }

    $show_subject_index = $check_exists->fields['showIndex'];
    $show_subject_index_type = $check_exists->fields['indexTypeWeb'];
    $is_subject_time = $check_exists->fields['status'];
    $is_subject_listiing = true;
    
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
    
    if($show_index ){
        $flag_disable_right = true;
    }
    if(!$show_list){
        $do_not_show_products_listing = true;
    }
    
    if(!$is_subject_time)
    {
        //记录无效链接
        record_valid_url();
        //eof
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
    }

    $page_link .= '&aId='.$aid;
}

if($pagename == 'similar'){
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
    $page_link .= '&products_id='.$similar_products_id;
}

$disp_order_default = SORT_COMMON_LIST;
$referer_from_level2 = true;

switch ($pagename){
    case 'new':
        $show_propery = true;
        $has_cate ? $breadcrumb->add ( TEXT_NEW_ARRIVALS, $page_link ) : $breadcrumb->add ( TEXT_NEW_ARRIVALS );
        $disp_order_default = SORT_NEW_ARRIVAL;
        break;
    case 'feature':
        $show_propery = true;
        $has_cate ? $breadcrumb->add ( TEXT_FEATURED_PRODUCTS, $page_link ) : $breadcrumb->add ( TEXT_FEATURED_PRODUCTS );
        $disp_order_default = SORT_FEATURED_PRODUCTS;
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
        $disp_order_default = SORT_BEST_SELLER;
        break;
    case 'mix':
        $show_propery = true;
        $has_cate ? $breadcrumb->add ( TEXT_MIXED_PRODUCTS, $page_link ) : $breadcrumb->add ( TEXT_MIXED_PRODUCTS );
        $disp_order_default = SORT_MIXED_PRODUCTS;
        break;
    case 'subject':
        $show_propery = true;
        $has_cate ? $breadcrumb->add ( $subject_name, $page_link ) : $breadcrumb->add ( $subject_name );
        break;
    case 'similar':
        $show_propery = true;
        $has_cate ? $breadcrumb->add ( TEXT_SIMILAR_PRODUCTS, $page_link ) : $breadcrumb->add ( TEXT_SIMILAR_PRODUCTS );
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
    if(empty($cate_name)) {
        header("HTTP/1.0 404");
        exit();
    }
    $breadcrumb->add ( $cate_name );
}
if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
    if (!in_array($_GET['pn'], array('matching', 'like', 'purchased'))) {
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
        $normal_category_list_show = true;

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

        switch ($_GET ['pn']) {
            case 'new' :
                $extra_select_str =  'is_new:1 and new_arrivals_display:10' . $extra_select_str;
                $solr_select_query .=  $extra_select_str . $properties_select;
                break;
            // 		case 'feature' :
            // 			$extra_select_str = 'is_featured:1' . $extra_select_str;
            // 			$solr_select_query .= $extra_select_str . $properties_select;
            // 			break;
            case 'best_seller' :
                $extra_select_str = 'is_hot_seller:1' . $extra_select_str;
                $solr_select_query .= $extra_select_str . $properties_select;
                break;
            case 'mix' :
                $extra_select_str = 'is_mixed:1' . $extra_select_str;
                $solr_select_query .= $extra_select_str . $properties_select;
                break;
            case 'subject':
                $extra_select_str = 'subject_id:'.(int)($_GET['aId']) . $extra_select_str;
                $solr_select_query .= $extra_select_str . $properties_select;
                break;
            case 'similar':
                $extra_select_str = 'tag_id:'. $tag_id . $extra_select_str;
                $solr_select_query .= $extra_select_str.$properties_select.$package_filter;
                break;
            default :
                $solr_select_query .= 'categories_id:' . ( int ) $current_category_id . $properties_select;
        }

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

        $result_array = zen_get_property($solr, $properties_facet, $current_page_base, $delArray, $getsInfoArray, $property_by_group, $extra_select_str, $normal_category_list_show, $show_matched_property_listing, $search_offset, $item_per_page, $condition);
        $pcontents = $result_array['content'];
        $getsProInfo = $result_array['getsProInfo'];
    }else{
        require (DIR_WS_MODULES . zen_get_module_directory ( 'quick_browse_display' ));
    }
}else{
    $solr_str_array = get_listing_display_order($disp_order_default);
    $solr_order_str = $solr_str_array['solr_order_str'];
    $order_by = $solr_str_array['order_by'];

    if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != '') {
        $top_cate = zen_db_prepare_input($_GET ['cId']);
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
    $filter_str.=" AND p.products_id!='".$_SESSION['gift_id']."'";
    $table_ptc = "(select * from " . TABLE_PRODUCTS_TO_CATEGORIES . "	group by products_id) ";
    switch ($pagename){
        case 'matching':
            $main_products_id = trim ( $_GET ['pid'] );
            //$match_model = $db->Execute ( "select match_prod_list, products_model from " . TABLE_PRODUCTS . " where products_id = " . ( int ) $main_products_id );
            $match_products_query = $db->Execute ( "select zpm.match_products_id from ".TABLE_PRODUCTS_MATCH_PROD_LIST . " zpm inner join " . TABLE_PRODUCTS . " zp on zpm.match_products_id = zp.products_id where zpm.products_id = ".(int)$main_products_id . " and zp.products_status != 10 order by match_products_id desc limit 20");
            while (!$match_products_query->EOF){
                $match_products_id_arr[] = array(
                    'match_products_id' => $match_products_query->fields['match_products_id'],
                );
                $match_products_query->MoveNext();
            }
            $sql_match_query = '';
            foreach ($match_products_id_arr as $key => $value){
                $sql_match_query .= $value['match_products_id'].',';
            }
            $sql_match_query = substr ( $sql_match_query, 0, - 1 );
            if($sql_match_query=='') $sql_match_query = '0';

            $listing_sql = "select distinct p.products_id							
											 from " . TABLE_PRODUCTS . " p 
											 where p.products_id in (" . $sql_match_query . ") 
												and products_type = 1
												And p.products_status = 1 group by p.products_id "  . $order_by ;
            break;
        case 'like':
            $products_title = $db->Execute("select distinct tag_id from " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " where products_id = " .(int)$_GET ['pid'] . " limit 1");

            $listing_sql = "Select distinct p.products_id										
										    From " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " pr, " . TABLE_PRODUCTS . " p
										    Where pr.tag_id = '" . zen_db_input ( $products_title->fields ['tag_id'] ) . "'
										    and p.products_id = pr.products_id		
									        And p.products_id != " . ( int ) $_GET ['pid'] . "
									        And p.products_status = 1"  . $order_by;

            break;
        case 'purchased':break;/*没有进到这一块WSL*/
            $procucts_orders_query = "select orders_id from " . TABLE_ORDERS_PRODUCTS . " where products_id=" . zen_db_prepare_input($_GET ['pid']) . " order by orders_id desc limit 15";
            $procucts_orders = $db->Execute ( $procucts_orders_query );
            $order_len = 0;
            if ($procucts_orders->RecordCount () > 0) {
                $order_str = '(';
                while ( ! $procucts_orders->EOF ) {
                    $order_len ++;
                    if ($order_len == $procucts_orders->RecordCount ()) {
                        $order_str .= $procucts_orders->fields ['orders_id'] . ")";
                    } else {
                        $order_str .= $procucts_orders->fields ['orders_id'] . ",";
                    }
                    $procucts_orders->MoveNext ();
                }
            } else {
                $order_str = "(' ')";
            }
            $listing_sql = "select distinct p.products_id
	                     from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p
	                     where op.products_id != '" . ( int ) $_GET ['pid'] . "'
	                     and orders_id in " . $order_str . "
	                     and op.products_id = p.products_id 
	                     and p.products_status = 1 
	                     group by p.products_id" . $order_by;
            break;
        default :break;
            $today_last_month = date('Y-m-d', (mktime(0, 0, 0, (date('m') - 1), date('d'), date('Y'))));
            $listing_sql = "SELECT distinct p.products_id, p.products_type, p.products_level, pd.products_name, p.products_image, p.products_price,
			                                    p.products_tax_class_id, p.products_date_added, p.products_model,
			                                    p.products_weight, p.product_is_call, p.product_is_free,
			                                    p.product_is_always_free_shipping, p.products_qty_box_status, p.products_discount_type,
			  									p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, products_limit_stock
			                             FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . $table_ptc . " ptc
			                             WHERE p.products_status = 1
										 AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
			                             AND p.products_id = pd.products_id 
                             		 	 AND ptc.products_id=p.products_id
			                             AND p.products_date_added >= '" . $today_last_month . "'
			                             AND pd.language_id = " . (int)$_SESSION ['languages_id'] . $filter_str . $order_by;
    }
    if($show_propery){
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
        $normal_category_list_show = true;

        $result_array = zen_product_property_display($item_per_page, $current_page);
        $delArray = $result_array['delArray'];
        $propertyGet = $result_array['propertyGet'];
        $getsInfoArray = $result_array['getsInfoArray'];
        $extra_select_str = $result_array['extra_select_str'];
        $search_offset = $result_array['search_offset'];
        $properties_select = $result_array['properties_select'];
        $property_by_group = $result_array['property_by_group'];

        switch ($_GET ['pn']) {
            case 'new' :
                $extra_select_str =  'is_new:1 and new_arrivals_display:10' . $extra_select_str;
                $solr_select_query .=  $extra_select_str . $properties_select;
                break;
            // 		case 'feature' :
            // 			$extra_select_str = 'is_featured:1' . $extra_select_str;
            // 			$solr_select_query .= $extra_select_str . $properties_select;
            // 			break;
            case 'best_seller' :
                $extra_select_str = 'is_hot_seller:1' . $extra_select_str;
                $solr_select_query .= $extra_select_str . $properties_select;
                break;
            case 'mix' :
                $extra_select_str = 'is_mixed:1' . $extra_select_str;
                $solr_select_query .= $extra_select_str . $properties_select;
                break;
            case 'subject':
                $extra_select_str = 'subject_id:'.(int)($_GET['aId']) . $extra_select_str;
                $solr_select_query .= $extra_select_str . $properties_select;
                break;
            case 'similar':
                $extra_select_str = 'tag_id:'. $tag_id . $extra_select_str;
                $solr_select_query .= $extra_select_str.$properties_select.$package_filter;
                break;
            default :
                $solr_select_query .= 'categories_id:' . ( int ) $current_category_id . $properties_select;
        }

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

        $result_array = zen_get_property($solr, $properties_facet, $current_page_base, $delArray, $getsInfoArray, $property_by_group, $extra_select_str, $normal_category_list_show, $show_matched_property_listing, $search_offset, $item_per_page, $condition);
        $pcontents = $result_array['content'];
        $getsProInfo = $result_array['getsProInfo'];
    }else{
        require (DIR_WS_MODULES . zen_get_module_directory ( 'product_listing' ));
    }
}