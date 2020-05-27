<?php
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$write_shopping_log = false;
if(isset($_SESSION['count_cart']) && $_SESSION['count_cart'] >= 50) {
    $write_shopping_log = true;
    $identity_info = $_COOKIE['cookie_cart_id'];
    if(!empty($_SESSION['customer_id'])) {
        $identity_info = $_SESSION['customer_id'];
    }
    if(empty($identity_info)) {
        $identity_info = json_encode($_COOKIE) . "separator" . json_encode($_SESSION);
    }
    write_file("log/shopping_cart_log/", "shopping_cart_mobile_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\r\n");
}
// bof 后台管理员帮顾客下单
if (isset ( $_GET ['admin_id'] ) && $_GET ['admin_id'] != '') {
    $_SESSION ['checkout_admin_for_customer'] = $_GET ['admin_id'];
}


// eof
//$breadcrumb->add(TITLE_SHOPPING_CART);
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
require DIR_WS_LANGUAGES . $_SESSION ['language'] . '/shopping_cart.php';
require DIR_WS_LANGUAGES . '/mobilesite/' . $_SESSION ['language'] . '/play_order.php';
require_once (DIR_WS_CLASSES . 'shipping.php');
$page = isset ( $_GET ['page'] ) && ( int ) $_GET ['page'] > 0 ? ( int ) $_GET ['page'] : '1';
$page_size = 20;
$smarty->assign ( 'page', $page );
$_SESSION ['navigation']->set_snapshot ();

$_SESSION ['cart_sort_by'] = (isset ( $_GET ['sortby'] ) && $_GET ['sortby'] != '' ? $_GET ['sortby'] : (isset ( $_SESSION ['cart_sort_by'] ) && $_SESSION ['cart_sort_by'] != '' ? $_SESSION ['cart_sort_by'] : 'time'));
$smarty->assign ( 'cart_sort_by', $_SESSION ['cart_sort_by'] );

if (zen_not_null($_SERVER['HTTP_REFERER'])) {
    $_SESSION['prev_url'] = $_SERVER['HTTP_REFERER'];
}

// bof move single product to wishlist
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'mws') {
    if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
        $product_id = $_GET ['pid'];
        $wishlist_check = $db->Execute ( 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $product_id . ' and wl_customers_id = ' . $_SESSION ['customer_id'] );
        if ($wishlist_check->RecordCount () == 0) {
            $sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_date_added) values (' . $product_id . ', ' . $_SESSION ["customer_id"] . ', "' . date ( 'y-m-d H:i:s' ) . '")';
            $db->Execute ( $sql );
            update_products_add_wishlist(intval($product_id));
            $messageStack->add_session ( 'addwishlist', TEXT_MOVE_TO_WISHLIST_SUCCESS, 'success' );
        }else{
            $messageStack->add_session ( 'addwishlist', TEXT_HAD_BEEN_IN_WISHLIST, 'success' );
        }
        zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART, $page != '' ? 'page=' . $_GET ['page'] : '' ) );
    }else{
        $_SESSION['navigation']->set_snapshot();
        zen_redirect(zen_href_link(FILENAME_LOGIN));
    }
}
// eof

if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'remove') {
    $product_id = $_GET ['pid'];
    $_SESSION['delete_products'] = array('index_num' => $_GET ['index_num'], 'products_id' => $product_id, 'del_qty' => $_GET['del_qty'],'pro_name_all' => get_products_description_memcache($product_id,$_SESSION['languages_id']), 'pro_model' => get_products_info_memcache($product_id,'products_model'), 'pro_href' => zen_href_link ( 'product_info', 'products_id=' . $product_id ));
    $_SESSION ['cart']->remove ( $product_id );
    if ($product_id == $_SESSION ['gift_id']) {
        $db->Execute ( "update " . TABLE_CUSTOMERS . " set has_gift=0 where customers_id='" . ( int ) $_SESSION ['customer_id'] . "'" );
        $_SESSION ['customer_gift'] = 0;
    }
    zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART, $page != '' ? 'page=' . $_GET ['page'] : '' ) );
}

if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'readd'){
    $product_id = $_GET['pid'];
    $qty = $_GET['del_qty'];
    unset($_SESSION['delete_products']);
    $_SESSION ['cart']->add_cart ( $product_id, $qty );
    zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART, ($page > 1 ? 'page='.$page : '') ) );
}

// bof move all product to wishlist
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'mwa') {
    if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
        //$products = $_SESSION ['cart']->get_products ( false );
        //Tianwen.Wan20160624购物车优化
        $products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize(0, 0, true, true, false);
        $products = $products_array['data'];
        $return_array = array('error'=>false);

        if (zen_not_null ( $products )) {
            $sql = '';
            for($i = 0; $i < sizeof ( $products ); $i ++) {
                $wishlist_check = $db->Execute ( 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $products [$i] ['id'] . ' and wl_customers_id = ' . $_SESSION ['customer_id'] );
                if ($wishlist_check->RecordCount () == 0) {
                    $sql .= '(' . $products [$i] ['id'] . ', ' . $_SESSION ["customer_id"] . ', ' . $products[$i]['quantity'] . ', "' . date ( 'y-m-d H:i:s' ) . '"), ';
                    update_products_add_wishlist(intval($products [$i] ['id']));
                } else{
                    $db->Execute ( 'update ' . TABLE_WISH . ' set wl_product_num = '.$products[$i]['quantity'].' where wl_products_id = ' . $products[$i]['id'] . '  and wl_customers_id = ' . $_SESSION ['customer_id'] . '' );
                }
            }
            $_SESSION ['cart']->remove_all(false);
            if ($sql != '') {
                $sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_product_num, wl_date_added) values ' . substr ( $sql, 0, - 2 );
                $db->Execute ( $sql );
                $return_array['message'] = TEXT_MOVE_TO_WISHLIST_SUCCESS;
            } else {
                $return_array['error'] = true;
                $return_array['message'] = TEXT_MOVE_TO_WISHLIST_SUCCESS_NOTICE;
            }
            echo json_encode($return_array);
            die;
        }
    }
}
// eof

// bof add order to wishlist
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'add_order_to_wishlist' && is_numeric($_GET ['orders_id'])) {
    if (isset($_SESSION ['customer_id']) && $_SESSION['customer_id'] != '') {
        $products = $db->Execute('select o.customers_id, op.products_id, op.products_quantity from ' . TABLE_ORDERS_PRODUCTS . ' op inner join ' . TABLE_ORDERS . ' o on o.orders_id = op.orders_id  where o.orders_id = ' . $_GET ['orders_id']);
        if ($products->RecordCount() > 0) {
            while(!$products->EOF) {
                if($products->fields['customers_id'] == $_SESSION ['customer_id']) {
                    $wishlist_check = $db->Execute('select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $products->fields['products_id'] . ' and wl_customers_id = ' . $_SESSION ['customer_id']);
                    if ($wishlist_check->RecordCount() == 0) {
                        $sql_data_array = array(
                            'wl_products_id' => $products->fields['products_id'],
                            'wl_customers_id' => $products->fields['customers_id'],
                            'wl_product_num' => $products->fields['products_quantity'],
                            'wl_date_added' => date('y-m-d H:i:s')
                        );
                        zen_db_perform(TABLE_WISH, $sql_data_array);
                        update_products_add_wishlist(intval($products->fields['products_id']));
                    } else {
                        $db->Execute("update " . TABLE_WISH . " set wl_product_num = " . $products->fields['products_quantity'] . " where wl_products_id = " . $products->fields['products_id'] . " and wl_customers_id = " . $_SESSION ['customer_id']);
                    }
                }
                $products->MoveNext();
            }
        }
        zen_redirect(zen_href_link(FILENAME_WISHLIST));
    } else {
        zen_redirect(zen_href_link(FILENAME_LOGIN));
    }
}
// eof

// bof empty shopping cart
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'empty') {
    $_SESSION ['cart']->remove_all (false);
    zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART ) );
}
// eof

$is_login = (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '');

$_SESSION ['valid_to_checkout'] = true;

//Tianwen.Wan20160624购物车优化
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize($page_size, $page, false, true, true);
$products = $products_array['data'];
$products_num = $products_array['count'];
$is_checked_all = $products_array['is_checked_all'];

$products_removed_array = $products_array['products_removed_array'];
$products_id_remove_array = $products_array['products_id_remove_array'];
$invalid_items_count = sizeof($products_removed_array);
$products_removed_array = array_slice($products_removed_array, 0, 5);
foreach($products_removed_array as $products_removed_key => $products_removed_value) {
    $products_removed_array[$products_removed_key]['products_name'] = getstrbylength(htmlspecialchars(zen_clean_html($products_removed_value['products_name'])), 60);
}

// bof empty ivalid items in shopping cart
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'empty_invalid') {
    $_SESSION ['cart']->remove($products_id_remove_array);
    zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART ) );
}
// eof

// christmas gift
if ($_SESSION ['cart_errors'] != '') {
    $messageStack->add ( 'cart_errors', $_SESSION ['cart_errors'], 'caution' );
}

$cart_products_down_errors = $_SESSION ['cart_products_down_errors'];
$cart_products_out_stoct_errors = $_SESSION ['cart_products_out_stoct_errors'];
unset ( $_SESSION ['cart_products_down_errors'] );
unset ( $_SESSION ['cart_products_out_stoct_errors'] );
$smarty->assign ( 'cart_products_down_errors', $cart_products_down_errors );
$smarty->assign ( 'cart_products_out_stoct_errors', $cart_products_out_stoct_errors );
$smarty->assign ( 'cart_has_buy_facebook_like_product_errors', $_SESSION['cart_has_buy_facebook_like_product_errors'] );
$smarty->assign ( 'products_removed_array', $products_removed_array );
unset($_SESSION['cart_has_buy_facebook_like_product_errors']);

//shopping cart calculate shipping cost module
if (isset($_GET['pn']) && $_GET['pn'] == 'sc') {
    // bof get customer country iso 2 code
    if ($is_login) {
        $customer = $db->Execute ( 'select ab.entry_country_id, c.customers_country_id, entry_postcode from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $_SESSION ['customer_id'] . ' and ab.address_book_id = c.customers_default_address_id' );
        if ($customer->RecordCount () == 1) {
            $country_id = $customer->fields ['entry_country_id'];
            $customer_default_postcode = $customer->fields ['entry_postcode'];
        } else {
            $country = $db->Execute ( 'select customers_country_id from ' . TABLE_CUSTOMERS . ' where customers_id = ' . $_SESSION ['customer_id'] );
            $country_id = $country->fields ['customers_country_id'];
        }
        $country_id = $country_id != '' ? $country_id : zen_get_selected_country ( $_SESSION ['languages_id'] );
        $country_code_query = $db->Execute ( 'select countries_iso_code_2 from ' . TABLE_COUNTRIES . ' where countries_id = ' . $country_id );
        $country_code = $country_code_query->fields ['countries_iso_code_2'];
    } else {
//        $checkIpAddress = new checkIpAddress ();
        $checkIpAddress->get_country_code ();
        $country_code = ($checkIpAddress->countryCode == '' || $checkIpAddress->countryCode == '-' ? 'US' : $checkIpAddress->countryCode);
        $db->connect ( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false );
        $country_id_query = $db->Execute ( 'select countries_id from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $country_code . '"' );
        $country_id = $country_id_query->fields ['countries_id'];
    }
    if (isset ( $_POST ['country_name'] ) && $_POST ['country_name'] != '') {
        $country_query = $db->Execute ( 'select countries_iso_code_2, countries_id from ' . TABLE_COUNTRIES . ' where countries_id = ' . $_POST ['country_name']  );
        $country_code = $country_query->fields ['countries_iso_code_2'];
        $country_id = $country_query->fields ['countries_id'];
        $post_city = (isset ( $_POST ['city'] ) && $_POST ['city'] != '') ? $_POST ['city'] : '';
        $post_postcode = (isset ( $_POST ['postcode'] ) && $_POST ['postcode'] != '') ? $_POST ['postcode'] : '';
        $cal_country = zen_db_prepare_input ( $country_code );
        $cal_city = zen_db_prepare_input ( $post_city );
        $cal_postcode = zen_db_prepare_input ( $post_postcode );
    }
    // eof
    if (isset ( $_POST ['postcode'] ) && $_POST ['postcode'] != '') {
        $cal_postcode = zen_db_prepare_input ( $_POST ['postcode'] );
        $customer_default_postcode = $cal_postcode;
    }
    $text_countries_list = zen_get_country_select('country_name', $country_id, $_SESSION['languages_id']);
    $country_info = zen_get_countries($country_id);
    $smarty->assign ( 'text_countries_list', $text_countries_list );

    $shipping_modules = new shipping ('', $country_code, '', $post_postcode, $post_city);

    $quotes = $shipping_modules->reduce_result;

    $special_discount = $shipping_modules->special_result;
    $special = false;
    if(sizeof($special_discount) > 0) {
        $special = true;
    }
    $cheapest = $shipping_modules->cheapest ();

    foreach ( $quotes as $method => $val ) {

        if (! $val ['error'] && isset ( $val ['final_cost'] )) {

            $display_note = ($val ['box_note'] != '' && $val ['remote_note'] != '' ? $val ['box_note'] . '<br>' . $val ['remote_note'] : $val ['box_note'] . $val ['remote_note']);

            $display_note = $val ['box_note'] == '' && $val ['remote_note'] == '' ? '' : $display_note;

            if ($special_discount[$val['code']]) {
                $cost_show = '-' . $currencies->format ( $special_discount[$val['code']] );
                $final_cost = '-' . $special_discount[$val['code']];
            }else{
                $cost_show = ($val ['final_cost'] <= 0 ? TEXT_FREE_SHIPPING : $currencies->format ( $val ['final_cost'] ) );
                $final_cost = $val ['final_cost'];
            }
            $time_unit = TEXT_DAYS_LAN;
            if ($val['time_unit'] == 20) {
                $time_unit = TEXT_WORKDAYS;
            }
            $shipping_methods [$val ['code']] = array (
                'code' => $val ['code'],
                'title' => $val ['title'],
                'days' => $val ['days'],
                'day' => $val ['day_low'],
                'day_high' => $val ['day_high'],
                'box' => $val ['box'],
                'box_note' => $val ['box_note'],
                'remote_note' => $val ['remote_note'],
                'remote_fee' => $val ['remote_fee'],
                'final_cost' => $final_cost,
                'day_sum' => $val ['day_low'] * 100 + $val ['day_high'],
                'cost_show' => $cost_show,
                'days_show' => $val ['days'] . ' ' . $time_unit,
                'show_note' => $display_note
            );
        }
    }
    //print_r($shipping_methods);
    $quote = $cheapest;
    $shipping_methods_show = array_sort ( $shipping_methods, 'final_cost', 'asc' );
    reset($shipping_methods_show);
    $default_first_method = current($shipping_methods_show);
    $default_shipping_method = $default_first_method['code'];
    $total_weight = $_SESSION ['cart']->show_weight();
    $volume_shipping_weight = $_SESSION['cart']->show_shipping_volume_weight();
    $smarty->assign ( 'customer_default_postcode', $customer_default_postcode );
    $smarty->assign ( 'default_shipping_method', $default_shipping_method );
    $smarty->assign ( 'shipping_methods_show', $shipping_methods_show );
    $smarty->assign ( 'total_weight', $total_weight );
    $smarty->assign ( 'total_weight_all', $total_weight>50000 ? $total_weight*1.06 : $total_weight*1.1 );
    $smarty->assign ( 'volume_shipping_weight', $volume_shipping_weight );
}else{
    // bof customer vip info
    $history_amount = 0; // customer all orders total amount
    $cVipInfo = getCustomerVipInfo ();
    $cNextVipInfo = getCustomerVipInfo ( true );
    $prom_discount_note = '';
    if ($is_login) {
        //订单折扣与 VIP&RCD取大者
        $promInfo = calculate_order_discount();
        $prom_discount = $promInfo['order_discount'];
        $prom_discount_title = $promInfo['order_discount_title'];

        $vip_rcd_discount = $cVipInfo['amount'];
        $rcd_discount = 0;
        if($_SESSION ['cart']->show_total_new() > $_SESSION['cart']->show_promotion_total()){
            //$copuns_display = true;
            $total_amount = $_SESSION ['cart']->show_total_new() -$_SESSION['cart']->show_promotion_total();
            /*满减活动*/
            if(date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME){
                if ($total_amount > $currencies->format_cl( 49 )) {
                    $discount = floor($total_amount/$currencies->format_cl( 49 ))*$currencies->format_wei( 4 );
                    $total_amount = $total_amount - $discount;
                }
            }
            /*阶梯式满减活动*/
            if(date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel']){
                if ($total_amount > $currencies->format_cl( 379 )) {
                    $discount = 25;
                }elseif($total_amount > $currencies->format_cl( 259 )){
                    $discount = 20;
                }elseif($total_amount > $currencies->format_cl( 149 )){
                    $discount = 10;
                }elseif($total_amount > $currencies->format_cl( 49 )){
                    $discount = 5;
                }elseif($total_amount > $currencies->format_cl( 19 )){
                    $discount = 1;
                }else{
                    $discount = 0;
                }

                $total_amount = $total_amount - $discount;
            }
            $total_amount = $total_amount - $cVipInfo['amount'];

            if (!zen_get_customer_create() && !get_with_channel()) {
                $rcd_discount = round(0.03 * ($total_amount), 2);
                $vip_rcd_discount += $rcd_discount;
            }
        }

        if($prom_discount >= $vip_rcd_discount){
            $cVipInfo['amount'] = 0;
            $rcd_discount = 0;
            //$copuns_display = false;
            $prom_discount_note = zen_get_discount_note();
            $show_current_discount = '';
        }else{
            $prom_discount = 0;
            $prom_discount_title = '';
            $show_current_discount = $currencies->format($rcd_discount,false);

        }
        //eof
        $tenoff = 0;
        $smarty->assign ( 'tenoff', $tenoff );
        $smarty->assign ( 'prom_discount', $currencies->format_cl($prom_discount, false));
        $smarty->assign ( 'prom_discount_format', $currencies->format($prom_discount, false));
        $smarty->assign ( 'prom_discount_title', $prom_discount_title);
        $smarty->assign ( 'rcd_discount', $rcd_discount);
        $smarty->assign ( 'show_current_discount', $show_current_discount);

        $order_total = $db->Execute ( "Select sum(order_total) as total From " . TABLE_ORDERS . " Where orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . ") And customers_id = " . ( int ) $_SESSION ['customer_id'] );
        $declare_total = $db->Execute ( 'Select sum(usd_order_total) as d_total From ' . TABLE_DECLARE_ORDERS . " Where status>0 and customer_id = " . ( int ) $_SESSION ['customer_id'] );
        $history_amount = $order_total->fields ['total'] + $declare_total->fields ['d_total'];
    } else {
        $prom_discount_note = zen_get_discount_note();
    }

    $width_vip_li = round ( $history_amount / $cNextVipInfo ['max_amt'], 2 ) * 100;

    $smarty->assign ( 'cVipInfo', $cVipInfo );
    $smarty->assign ( 'cNextVipInfo', $cNextVipInfo );
    $smarty->assign ( 'history_amount', floor ( $history_amount ) );
    $smarty->assign ( 'width_vip_li', $width_vip_li );
    $smarty->assign ( 'prom_discount_note', $prom_discount_note );
    // eof

    //Tianwen.Wan20160624购物车优化
    //$products_num = $_SESSION ['cart']->get_products_num ();
    $smarty->assign ( 'products_num', $products_num );

    $total_weight = $_SESSION ['cart']->show_weight();
    $volume_shipping_weight = $_SESSION['cart']->show_shipping_volume_weight();
    $smarty->assign ( 'total_weight', $total_weight );
    $smarty->assign ( 'total_weight_all', $total_weight>50000 ? $total_weight*1.06 : $total_weight*1.1 );
    $smarty->assign ( 'volume_shipping_weight', $volume_shipping_weight );
    $smarty->assign ( 'total_items', $products_num );
    $smarty->assign ( 'is_checked_count', $products_array['is_checked_count'] );
    $smarty->assign ( 'total_amount', $currencies->format ( $_SESSION ['cart']->show_total (), false ) );
    $smarty->assign ( 'total_amount_convert', $currencies->format ( $_SESSION ['cart']->show_total_new (), false ) );
    $smarty->assign ( 'show_total_new_cart', $_SESSION ['cart']->show_total_new () * 3 / 100 );
    $smarty->assign ( 'currency_symbol_left', $currencies->currencies [$_SESSION ['currency']] ['symbol_left'] );
    if ($products_num > $page_size) {
        $products_split = new splitPageResults('', $page_size, '', 'page', false, $products_array['count']);
        $cart_fen_ye = '<div class="page">' . $products_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params ( array('page', 'info', 'x', 'y', 'main_page') ) ) . '</div>';
    } else {
        $cart_fen_ye = '';
    }
    $smarty->assign ( 'cart_fen_ye', $cart_fen_ye );
    // eof

    //invalid items fenye
    if ($invalid_items_count > 5) {
        $invalid_items_split = new splitPageResults('', '5', '', 'page', false, $invalid_items_count);
        $invalid_items_fen_ye = '<div class="page">' . $invalid_items_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params ( array('page', 'info', 'x', 'y', 'main_page') ) ,true) . '</div>';
    }else{
        $invalid_items_fen_ye = '';
    }
    $smarty->assign ( 'invalid_items_fen_ye', $invalid_items_fen_ye );

    // christmas gift
    $_SESSION ['cart']->check_gift ();
//	$smarty->assign ( 'gift_id', $_SESSION ['gift_id'] );
    $smarty->assign ( 'gift_id', 0);

    $_SESSION ['basket_product_orderby'] = true;
    //Tianwen.Wan20160624购物车优化
    //$products = $_SESSION ['cart']->get_products ( false, $page_size );

    $promotion_discount = '';
    $cate_total = 0;
    //$products = array_slice($products, ($page -1) * $page_size, $page_size);
    for($i = 0, $n = sizeof ( $products ); $i < $n; $i ++) {
        $product_name = htmlspecialchars ( zen_clean_html ( $products [$i] ['name'] ) );
        //echo $product_name;
        $product_link = zen_href_link ( 'product_info', 'products_id=' . $products [$i] ['id'] );
        //echo $product_link;
        $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $products [$i] ['image'], 130, 130 ) . '" alt="' . $product_name . '" width="110" height="110">' : '');
        $qty = $products [$i] ['quantity'];
        //show promotion max num per order
        $promotion_info = get_product_promotion_info($products[$i]['id']);
        if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
            $pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
            $max_num_per_order_tips = sprintf(TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS, $pp_max_num_per_order);
            if ($qty > $pp_max_num_per_order) {
                $products [$i] ['final_price'] = $products [$i] ['original_price'];
            }
        }else{
            $pp_max_num_per_order = 0;
            $max_num_per_order_tips = '';
        }
        $product_each_price = $currencies->format_cl ( zen_add_tax ( $products [$i] ['final_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ) ) );
        $product_each_price_original = $currencies->format_cl ( zen_add_tax ( $products [$i] ['original_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ) ) );
        $product_total_amount = $currencies->format_cl ( $product_each_price * $products [$i] ['quantity'], false );
        $products_model = $products [$i] ['model'];
        $discount_amount = zen_show_discount_amount ( $products [$i] ['id'] );
        $first_cate_info = zen_get_first_cate ( $products [$i] ['id'] );
        $text_small_pack_length = 0;
        if (check_small_size($products_model)) {
            $text_small_pack_length = strlen(TEXT_SMALL_PACK);
        }
        $productArray [$i] = array (
            'product_link' => $product_link,
            'product_image' => $product_image,
            'product_name' => ($products [$i] ['product_quantity']==0 ? TEXT_PREORDER.' ':'') . getstrbylength ( $product_name, 60-$text_small_pack_length ),   /*products name length set  shopping_cart_normal*/
            'product_name_all' => $product_name,
            'id' => $products [$i] ['id'],
            'qty' => $qty,
            'model' => $products_model,
            'weight' => $products [$i] ['weight'],
            'volume_weight' => $products [$i] ['volume_weight'],
            'price' => $currencies->format ($product_each_price, false),
            'original_price' => $currencies->format ($product_each_price_original, false),
            'total' => $currencies->format ( $product_total_amount, false ),
            'total_number' => $product_total_amount,
            'is_checked' => $products [$i] ['is_checked'],
            'note' => $products [$i] ['note'],
            'customers_basket_id' => $products [$i] ['customers_basket_id'],
            'discount' => $discount_amount,
            'update_qty_note' => '',
            'product_quantity' => $products [$i] ['product_quantity'],
            'cate_id' => $first_cate_info ['categories_id'],
            'cate_name' => $first_cate_info ['categories_name'],
            'inwishlist' => $_SESSION ['cart']->product_in_wishlist ( $products [$i] ['id'] ),
            'is_gift' => 0,
            'is_preorder' => $products[$i]['product_quantity'] <= 0 ? 1 : 0,
            'is_small_pack' => check_small_size($products_model),
            'products_qty_update_auto_note' => $products [$i] ['products_qty_update_auto_note'],
            'pp_max_num_per_order' => $pp_max_num_per_order,
            'max_num_per_order_tips' => $max_num_per_order_tips,
            'products_stocking_days' => $products [$i] ['products_stocking_days'],
            'is_s_level_product' => get_products_info_memcache($products [$i] ['id'], 'is_s_level_product')
        );
    }
    $smarty->assign('is_checked_all', $is_checked_all);
    if ($_SESSION ['cart_sort_by'] == 'cate') {

        $products_sort = zen_get_shopping_cart_category ( $productArray );

        $smarty->assign ( 'product_array', $products_sort ['productsArr'] );
        $smarty->assign ( 'cate_total_arr', $products_sort ['cate_total_arr'] );
    } else {
        $smarty->assign ( 'product_array', $productArray );
    }
    $smarty->assign ( 'total_amount_original', $currencies->format ( $_SESSION ['cart']->show_total_original (), false ) );
    $smarty->assign ( 'total_amount_discount', $currencies->format($_SESSION ['cart']->show_discount_amount (), false) );
    $original_prices = $_SESSION ['cart']->show_origin_amount () + $_SESSION ['cart']->show_discount_amount ();
    $smarty->assign ( 'original_prices', $currencies->format($original_prices, false) );
    $promotion_discount = $_SESSION ['cart']->show_total_original () - $_SESSION ['cart']->show_total_new ();
    $smarty->assign ( 'promotion_discount_usd', $promotion_discount );
    $smarty->assign ( 'promotion_discount', $currencies->format ( $promotion_discount, false ) );

    $cart_save_price_note = sprintf(TEXT_CART_SAVE_PRICE, $currencies->format ( $_SESSION ['cart']->show_total_original (), false ), $currencies->format ( $promotion_discount, false ));
    $smarty->assign ( 'cart_save_price_note', $cart_save_price_note );

    $total_all = $_SESSION ['cart']->show_total_new ();
    $smarty->assign ( 'total_all', $currencies->format ( $total_all, false ) );

    $vip_rcd = $cVipInfo ['amount'] + $rcd_discount;
    if($prom_discount >= $vip_rcd){
        $discounts = $prom_discount + $promotion_discount + $discount;
    }else{
        $discounts = $vip_rcd + $promotion_discount + $discount;
    }  
    $pay_total = 9.99;

    $total_all = $_SESSION ['cart']->show_total_new () - $prom_discount - $cVipInfo ['amount'] -  $rcd_discount ;

    if($total_all < $currencies->format_cl($pay_total)){
       $handing_fee_format = 0.99;
       $handing_fee = $currencies->format_cl($handing_fee_format);
    }

    $is_handing_fee = $total_all - $currencies->format_cl($pay_total);
    $smarty->assign ( 'is_handing_fee',$is_handing_fee );
    $smarty->assign ( 'handing_fee', $currencies->format($handing_fee, false) );
    $smarty->assign ( 'discounts', $discounts );
    $smarty->assign ( 'discounts_format', $currencies->format($discounts, false) );
    // bof get customer country id
    if (isset ( $_SESSION ['cart_country_id'] ) && $_SESSION ['cart_country_id'] != '') {
        $country_id = $_SESSION ['cart_country_id'];
        if ($is_login) {
            $customer = $db->Execute ( 'select ab.entry_country_id, c.customers_country_id, ab.entry_postcode, ab.entry_city from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $_SESSION ['customer_id'] . ' and ab.address_book_id = c.customers_default_address_id and ab.entry_country_id = ' . $country_id );
            if ($customer->RecordCount () == 1) {
                $customer_default_postcode = $customer->fields ['entry_postcode'];
                $customer_default_city = $customer->fields ['entry_city'];
            }
        }
    } else {
        if ($is_login) {
            $customer = $db->Execute ( 'select ab.entry_country_id, c.customers_country_id, ab.entry_postcode, ab.entry_city from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $_SESSION ['customer_id'] . ' and ab.address_book_id = c.customers_default_address_id' );
            if ($customer->RecordCount () == 1) {
                $country_id = $customer->fields ['entry_country_id'];
                $customer_default_postcode = $customer->fields ['entry_postcode'];
                $customer_default_city = $customer->fields ['entry_city'];
            } else {
                $country = $db->Execute ( 'select customers_country_id from ' . TABLE_CUSTOMERS . ' where customers_id = ' . $_SESSION ['customer_id'] );
                $country_id = $country->fields ['customers_country_id'];
            }
        } else {
            // require (DIR_WS_CLASSES . 'check_ip_address.php');
            $checkIpAddress = new checkIpAddress ();
            $checkIpAddress->get_country_code ();
            $country_code = ($checkIpAddress->countryCode == '' ? 'US' : $checkIpAddress->countryCode);
            $db->connect ( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false );
            $country_id_query = $db->Execute ( 'select countries_id from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $country_code . '"' );
            $country_id = $country_id_query->fields ['countries_id'];
        }
    }
    // eof

    $text_countries_list = zen_get_country_select ( 'zone_country_id', $country_id, $_SESSION ['languages_id'], 'id="country"' );
    $country_info = zen_get_countries ( $country_id );
    $text_countries_list .= zen_draw_hidden_field ( 'country_name', $country_info ['countries_name'] );
    $smarty->assign ( 'text_countries_list', $text_countries_list );
    $smarty->assign ( 'customer_default_postcode', $customer_default_postcode );
    $smarty->assign ( 'customer_default_city', $customer_default_city );

    // bof recently viewed products
    $r_products = get_recently_viewed_products ();
    $smarty->assign ( 'r_products', $r_products );
    // eof
    $smarty->assign ( 'messageStack', $messageStack );
    $smarty->assign ( 'shipping_content', '<img src="includes/templates/cherry_zen/images/zen_loader.gif">' );
    $smarty->assign ( 'vip_content', '<img src="includes/templates/cherry_zen/images/zen_loader.gif">' );

    $smarty->assign ( 'special_discount_title', '' );
    $smarty->assign ( 'special_discount_content', '' );
}
// bof choose template
$pn = (isset ( $_GET ['pn'] ) && $_GET ['pn'] != '' ? $_GET ['pn'] : '');
if ($pn == 'vw') {
    $tpl = DIR_WS_TEMPLATE_TPL . 'tpl_shopping_cart_view_weight.html';
} elseif ($pn == 'sc') {
    $tpl = DIR_WS_TEMPLATE_TPL . 'tpl_shopping_cart_calculate.html';
} else {
    if ($products_num <= 0) {
        $tpl = DIR_WS_TEMPLATE_TPL . 'tpl_shopping_cart_empty.html';
    } else {
        $tpl = DIR_WS_TEMPLATE_TPL . 'tpl_shopping_cart_normal.html';
    }
}
$tpl_head = DIR_WS_TEMPLATE_TPL . 'tpl_play_order_head.html';
$smarty->assign ( 'checkout_default_url', zen_href_link ( FILENAME_CHECKOUT ));
$smarty->assign ( 'shoppingcart_default_url', zen_href_link ( FILENAME_SHOPPING_CART ));
$smarty->assign ( 'tpl_head', $tpl_head );
$smarty->assign ( 'tpl', $tpl );
// eof

if($write_shopping_log) {
    write_file("log/shopping_cart_log/", "shopping_cart_mobile_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n");
}
?>