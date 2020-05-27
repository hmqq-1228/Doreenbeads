<?php
/**
 * header_php.php
 * wishlist
 * dorabeads v1.50 / modified by lvxiaoyong
 *
 */

$zco_notifier->notify('NOTIFY_HEADER_START_WISHLIST');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
if (!isset($_SESSION['customer_id']) || (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == '')){
    zen_redirect(zen_href_link(FILENAME_LOGIN));
}

$all_select_in_cart = false;
$add_cart_success = false;
$_SESSION ['valid_to_checkout'] = true;
//$_SESSION ['cart']->get_isvalid_checkout ( true );
//$_SESSION ['cart']->calculate();
//Tianwen.Wan20160624购物车优化
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();

$wishlist_products_down_note = '';
if (isset($_POST['action']) && $_POST['action'] == 'add'){
    $all_select_in_cart = true;
    $products = $_POST['wish_checkbox'];
    $products_in_cart = explode(',', str_replace(' ', '', $_SESSION['cart']->get_product_id_list()));

    foreach ($products as $product_id => $val){
        if (!in_array($product_id, $products_in_cart) || sizeof($products_in_cart) == 0){
            $all_select_in_cart = false;
            $min_qty = $db->Execute('select p.products_model, p.products_quantity_order_min, pd.products_name from ' . TABLE_PRODUCTS . ' p, ' . TABLE_PRODUCTS_DESCRIPTION . ' pd where p.products_id = ' . $product_id . ' and pd.products_id = p.products_id and pd.language_id = ' . $_SESSION['languages_id']);
            if ($min_qty->RecordCount() > 0){
                $min = $min_qty->fields['products_quantity_order_min'];
                $min_qty->fields['products_quantity'] = zen_get_products_stock($product_id);
                if ($min_qty->fields['products_quantity'] <= 0){
                    $wishlist_products_down_note .= '[' . $min_qty->fields['products_model'] . '] ' . $min_qty->fields['products_name'] . '<br />';
                }else{
                    $_SESSION['cart']->add_cart($product_id, $min);
                    $add_cart_success = true;
                }
            }
        }
    }
    zen_redirect(zen_href_link('wishlist'));
}
if ($wishlist_products_down_note != ''){
    $wishlist_products_down_note = TEXT_OUT_OF_STOCK_NOTE . $wishlist_products_down_note;
}

$is_search = trim(zen_db_prepare_input($_GET['is_search']));
$wishlist_keyword = trim(addslashes(zen_db_prepare_input($_GET['wishlist_keyword'])));
$wishlist_startdate = trim(zen_db_prepare_input($_GET['wishlist_startdate']));
$wishlist_enddate = trim(zen_db_prepare_input($_GET['wishlist_enddate']));

if (isset($_POST['action']) && $_POST['action'] == 'delete'){
    $products = $_POST['wish_checkbox'];
    foreach ($products as $product_id => $val){
        $wishlist_sql = 'select wl_products_id from t_wishlist where wl_products_id = ' .  (int)$product_id. ' and wl_customers_id = ' . (int)$_SESSION['customer_id'] . ' limit 1';
        $wishlist_query = $db->Execute($wishlist_sql);
        if($wishlist_query ->RecordCount() > 0){
            $db->Execute('delete from ' . TABLE_WISH . ' where wl_customers_id = ' . (int)$_SESSION['customer_id'] . ' and wl_products_id = ' . $product_id);
            update_products_add_wishlist(intval($product_id) , 'remove');
        }
    }
    zen_redirect(zen_href_link('wishlist'));
}

$check_invalid = $db->Execute("select w.wl_id, p.products_id, p.products_model, p.products_image, pd.products_name  from ".TABLE_WISH." w inner join ".TABLE_PRODUCTS." p on w.wl_products_id=p.products_id inner join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id=pd.products_id
							where w.wl_customers_id = " . $_SESSION['customer_id'] . " and (p.products_status !=1 or exists (select products_id from " . TABLE_MY_PRODUCTS . " mp where w.wl_products_id=mp.products_id)) and pd.language_id = " . $_SESSION['languages_id'] . "");
$wishlist_products_down_note_line = $wishlist_products_down_note = "";
$products_notify_array = $products_notify_products_id = $products_notify_also_like_array = array();
if($check_invalid->RecordCount()>0){
    while(!$check_invalid->EOF){
        $check_invalid->fields['products_name'] = getstrbylength(htmlspecialchars(zen_clean_html($check_invalid->fields['products_name'])), 100);
        array_push($products_notify_array, $check_invalid->fields);
        array_push($products_notify_products_id, $check_invalid->fields['products_id']);
        $check_invalid->MoveNext();
    }
}

if (isset($_GET['categories']) && $_GET['categories'] != ''){
    $categories_id = $_GET['categories'];
    $subcategory = zen_get_subcategories($subcategories_array, $categories_id);
    $subcategory_id = @implode(',', $subcategory);
    if (zen_not_null($subcategory_id)){
        $subcategory_id .= ',' . $categories_id;
        $filter_str = " and p.master_categories_id in (" . $subcategory_id . ")";
    } else {
        $filter_str = " and p.master_categories_id = " . (int)$categories_id;
    }
} else {
    $filter_str = '';
}

if(!empty($wishlist_keyword)) {
    $filter_str .= " and pd.products_name like '%" . $wishlist_keyword . "%'";
}
if(!empty($wishlist_startdate)) {
    $wishlist_startdate_new = substr($wishlist_startdate, -4, strlen($wishlist_startdate)) . "-" . substr($wishlist_startdate, 0, 5) . " 00:00:00";
    $filter_str .= " and w.wl_date_added>='" . $wishlist_startdate_new . "'";
}
if(!empty($wishlist_enddate)) {
    $wishlist_enddate_new = substr($wishlist_enddate, -4, strlen($wishlist_enddate)) . "-" . substr($wishlist_enddate, 0, 5) . " 23:59:59";
    $filter_str .= " and w.wl_date_added<='" . $wishlist_enddate_new . "'";
}

if (isset($_GET['sortby'])){
    $sortby = $_GET['sortby'];
    switch ($sortby){
        case '1':
            $sort = " order by w.wl_date_added desc";
            break;
        case '2':
            $sort = " order by w.wl_date_added";
            break;
        default:
            $sort = " order by w.wl_date_added desc";
            break;
    }
} else {
    $sort = " order by w.wl_date_added desc";
}

$wishlist_products_down_note = '';
$wishlist_query = "select p.products_id, p.products_model, p.products_image, products_stocking_days,
							pd.products_name, w.wl_id, w.wl_product_num, w.wl_date_added, p.products_status,is_sold_out
							 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, t_wishlist w
							where w.wl_customers_id = " . (int)$_SESSION['customer_id'] . "
							and pd.language_id = " . $_SESSION['languages_id'] . "
							and w.wl_products_id = p.products_id
							and p.products_id = pd.products_id and p.products_status=1 and not exists(select products_id from " . TABLE_MY_PRODUCTS . " mp where w.wl_products_id=mp.products_id)" . $filter_str . $sort;
$wishlist_products = $db->Execute($wishlist_query);
$wishlist_products_count = $wishlist_products->RecordCount();
$wishlist_split = new splitPageResults($wishlist_query, 100);
$wishlist = $db->Execute($wishlist_split->sql_query);

if ($wishlist->RecordCount() > 0){
    $wishlist_array = array();
    while (!$wishlist->EOF){

        $wishlist->fields['products_quantity'] = zen_get_products_stock($wishlist->fields['products_id']);
        $raw_date = $wishlist->fields['wl_date_added'];
        $time = mktime((int)substr($raw_date, 11, 2), (int)substr($raw_date, 14, 2), (int)substr($raw_date, 17, 2), (int)substr($raw_date, 5, 2), (int)substr($raw_date, 8, 2), (int)substr($raw_date, 0, 4));
        $price_area_result = show_products_price_area($wishlist->fields['products_id'] );
        $wishlist_array[] = array('product_id' => $wishlist->fields['products_id'],
            'product_model' => $wishlist->fields['products_model'],
            'product_image' => $wishlist->fields['products_image'],
            //								  'product_price' => $wishlist->fields['products_price'],
            'product_name' => getstrbylength(htmlspecialchars(zen_clean_html($wishlist->fields['products_name'])), 100),
            'product_quantity' => $wishlist->fields['products_quantity'],
            'is_sold_out' => $wishlist->fields['is_sold_out'],
            //								  'wl_product_num' => ($quantity_incart > 0 ? $quantity_incart : 1),
            'wl_id' => $wishlist->fields['wl_id'],
            'date_added' => date('M d, Y\<\b\r\/\>\a\t H:i A', $time),
            'is_simple_price' => $price_area_result['is_simple_price'],
            'price_area' =>  $price_area_result['price_area'],
            'show_content' => $price_area_result['show_content'],
            'products_stocking_days' => $wishlist->fields['products_stocking_days']

        );

        $wishlist->MoveNext();
    }
}

if(!empty($products_notify_array)) {
    $products_notify_also_like_array = get_products_without_catg_relation($products_notify_products_id);
    $wishlist_products_down_note = '<ins></ins>' . TEXT_SHOPPING_CART_DOWN_NOTE . '<a class="btn_show" href="javascript:void(0)">' . TEXT_VIEW_DETAILS . '<ins></ins></a><a class="btn_close" style="display:none;" href="javascript:void(0)">' . TEXT_VIEW_LESS_SHOPPING_CART . '<ins></ins></a>
		      <table class="pro_removed" style="display: none;" cellspacing="0" cellpadding="0"><tbody><tr>
			        <td colspan="3" style="border-top:0px;"></td>
			        <td style="text-align:center; border-top:0px;"><a href="javascript:void(0);" class="jq_products_invalid_all">' . TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS . '</a></td>
			      </tr>
			      <tr>
			        <th>' . TEXT_IMAGE . '</th>
			        <th>' . TEXT_MODEL . '</th>
			        <th class="name">' . TEXT_INFO_SORT_BY_PRODUCTS_NAME . '</th>
			        <th>' . TEXT_ACTION . '</th>
			      </tr>';

    foreach($products_notify_array as $products_notify_value) {
        $also_like_str = "";
        if(isset($products_notify_also_like_array[$products_notify_value['products_id']])) {
            $also_like_str = "<a href='" . zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=similar&products_id=' . $products_notify_value['products_id']) . "' target='_blank'>" . TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS . "</a><br/>";
        }
        $wishlist_products_down_note_line .= '<tr>
														<td><div class="totalimg"><a class="imgborder"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_notify_value['products_image'], 80, 80) . '" alt="' . htmlspecialchars(zen_clean_html($products_notify_value['products_name'])) . '"></a>      </div></td> 
														<td>' . $products_notify_value['products_model'] . '</td>
														<td class="name">' . $products_notify_value['products_name'] . '</td>
														<td>' . $also_like_str . '<a href="javascript:void(0);" class="jq_products_invalid_one" data-id="' . $products_notify_value['wl_id'] . '">' . TEXT_DELETE . '</a></td>
												</tr>';
    }

    $wishlist_products_down_note .= $wishlist_products_down_note_line . '<tr>
			        <td colspan="3" style="text-align:left;"><a class="btn_close" style="display: inline;" href="javascript:void(0)">View Less<ins></ins></a></td>
			        <td style="text-align:center;"><a href="javascript:void(0);" class="jq_products_invalid_all">' . TEXT_VIEW_LESS_SHOPPING_CART . '</a></td>
			      </tr></tbody></table>';


}
$action = (isset($_GET['action']) && zen_not_null($_GET['action'])) ? $_GET['action'] : '';
switch ($action){
    case 'remove':
        $product_id = $_GET['product_id'];
        $db->Execute("delete from t_wishlist where wl_products_id = " . (int)$product_id . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
        update_products_add_wishlist(intval($product_id) , 'remove');
        zen_redirect(zen_href_link('wishlist'));
        break;
    case 'removeselected':
        $prod_ids = trim($_POST['products_id_hidden']);
        $prod_ids_below = trim($_POST['products_id_hidden_below']);
        if (!zen_not_null($prod_ids) && !zen_not_null($prod_ids_below)) {
            zen_redirect(zen_href_link('wishlist'));
            break;
        }

        $prod_ids = (zen_not_null($prod_ids)) ? $prod_ids : $prod_ids_below;
        $prod_ids = substr($prod_ids, 0, -1);

        if (zen_not_null($prod_ids)) {
            @$db->Execute("delete from t_wishlist where wl_customers_id = " . (int)$_SESSION['customer_id'] . " and wl_products_id in (" . $prod_ids . ")");
            $product_arr = explode(',' , $prod_ids );
            foreach ($product_arr as $value){
                update_products_add_wishlist(intval($value) , 'remove');
            }

        }
        zen_redirect(zen_href_link('wishlist'));
        break;
    case 'addwishlist':
        $products_id = $_GET['pid'];
        $customer_id = $_SESSION['customer_id'];
        $wishlist_check = $db->Execute("select wl_id from t_wishlist where wl_products_id = " . (int)$products_id . " and wl_customers_id = " . (int)$customer_id);
        if ($wishlist_check->RecordCount() == 0){
            $db->Execute("insert into t_wishlist (wl_products_id, wl_customers_id, wl_date_added) values (" . $products_id . ", " . $customer_id . ", '" . date('Y-m-d H:i:s') . "')");
            update_products_add_wishlist(intval($product_id));
        }
        zen_redirect(zen_href_link('wishlist'));
        break;
}

$breadcrumb->add(NAVBAR_TITLE2, zen_href_link('wishlist'));

$wishlist_categories_query = "select p.master_categories_id
								  from " . TABLE_PRODUCTS . " p, t_wishlist w
								 where p.products_id = w.wl_products_id
									and wl_customers_id = " . (int)$_SESSION['customer_id'] . "
							  group by p.master_categories_id";
$wishlist_categories_id = $db->Execute($wishlist_categories_query);

$wishlist_categories_array = array();
if ($wishlist_categories_id->RecordCount() > 0){
    $cnt = 0;
    while (!$wishlist_categories_id->EOF){
        $wishlist_categories_array[$cnt] = $wishlist_categories_id->fields['master_categories_id'];
        $cnt++;
        $wishlist_categories_id->MoveNext();
    }
}

if (sizeof($wishlist_categories_array) > 0){
    $wishlist_categories_info = $db->Execute("select categories_id, categories_name 
													from " . TABLE_CATEGORIES_DESCRIPTION . "
												  where categories_id in (" . implode(',', $wishlist_categories_array) . ") and language_id = " . $_SESSION['languages_id']);

    if ($wishlist_categories_info->RecordCount() > 0){
        $cnt = 0;
        $wishlist_categories_info_array = array();
        while (!$wishlist_categories_info->EOF){
            $wishlist_categories_info_array[$cnt] = array('categories_id' => $wishlist_categories_info->fields['categories_id'],
                'categories_name' => $wishlist_categories_info->fields['categories_name']);
            $cnt++;
            $wishlist_categories_info->MoveNext();
        }
    }
}

$zco_notifier->notify('NOTIFY_HEADER_END_WISHLIST');
?>
