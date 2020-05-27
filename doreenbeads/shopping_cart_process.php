<?php
require ('./includes/application_top.php');
require_once (DIR_WS_CLASSES . 'shipping.php');
require_once (DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'shopping_cart.php');
$_GET['main_page'] = 'shopping_cart';
$page = isset($_POST['page']) && $_POST['page'] != '' ? $_POST['page'] : 1;
$page_size = 100;
$smarty->assign('page', $page);
$is_login = (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '');
$action = $_POST['action'];
$smarty->assign('cart_sort_by', $_SESSION['cart_sort_by']);

$return_array = array(
    'error' => 0,
    'message' => ""
);

if ($action == "shopcart_isvalid") {
    $products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize($page_size, $page);
    if (count($products_array['data']) <= 0) {
        $return_array = array(
            'error' => 1,
            'message' => ERROR_PLEASE_CHOOSE_ONE
        );
    }
    die(json_encode($return_array));
}

if ($action == 'addtowishlist') {
    $product_id = intval($_POST['pid']);
    $product_num = intval($_POST['qty']);
    if ($product_num < 1) {
        $product_num = 1;
    }
    $wishlist_check = $db->Execute('select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $product_id . ' and wl_customers_id = ' . $_SESSION['customer_id']);
    if ($wishlist_check->RecordCount() == 0) {
        $sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id,wl_product_num, wl_date_added) values (' . $product_id . ', ' . $_SESSION["customer_id"] . ', ' . $product_num . ', "' . date('y-m-d H:i:s') . '")';
        $db->Execute($sql);
        update_products_add_wishlist($product_id);
        // $messageStack->add_session ( 'addwishlist_cart', TEXT_MOVE_TO_WISHLIST_SUCCESS, 'success' );
    } else {
        $sql = "update " . TABLE_WISH . ' set wl_product_num = ' . $product_num . ' where wl_products_id=' . $product_id;
        $db->Execute($sql);
        // $messageStack->add_session ( 'addwishlist_cart', TEXT_MOVE_TO_WISHLIST_SUCCESS, 'success' );
    }
    $_SESSION['cart']->remove($product_id, true);
    exit();
}
if ($action == 'remove') {
    $product_id = $_POST['pid'];
    $_SESSION['delete_products'] = array(
        'index_num' => $_POST['index_num'],
        'products_id' => $_POST['pid'],
        'del_qty' => $_POST['del_qty'],
        'pro_name_all' => get_products_description_memcache($product_id, $_SESSION['languages_id']),
        'pro_model' => get_products_info_memcache($product_id, 'products_model'),
        'pro_href' => zen_href_link('product_info', 'products_id=' . $product_id),
        'date_created_unix' => time()
    );
    $_SESSION['cart']->remove($product_id);
    if ($product_id == $_SESSION['gift_id']) {
        $db->Execute("update " . TABLE_CUSTOMERS . " set has_gift=0 where customers_id='" . (int) $_SESSION['customer_id'] . "'");
        $_SESSION['customer_gift'] = 0;
    }
}

if ($action == 'readd') {
    $product_id = $_POST['pid'];
    $qty = $_POST['pro_qty'];
    unset($_SESSION['delete_products']);
    $_SESSION['cart']->add_cart($product_id, $qty);
}

if ($action == 'quick_add_content') {
    
    if ($_SESSION['auto_auth_code_display']['shopping_cart_uploadFile'] >= 3 || ! isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == 0) {
        $show_upload_auth_code = true;
        $show_upload_auth_code_str = zen_draw_input_field('check_code', '', 'size="25" id="check_code_input" class="input_text_wrap" placeholder="' . TEXT_VERIFY_NUMBER . '" style="width: 150px;height: 25px;margin-right:15px;"');
    } else {
        $show_upload_auth_code = false;
        $show_upload_auth_code_str = '';
    }
    $smarty->assign('show_upload_auth_code', $show_upload_auth_code);
    $smarty->assign('show_upload_auth_code_str', $show_upload_auth_code_str);
    $smarty->display(DIR_WS_INCLUDES . 'templates/checkout/tpl_quick_add_products.html');
    exit();
}

if ($action == 'check_model') {
    $product_model = strtoupper(zen_db_prepare_input($_POST['model']));
    $qty = intval($_POST['qty']);
    $check = $db->Execute('select products_id from ' . TABLE_PRODUCTS . ' where products_model = "' . $product_model . '"');
    if ($check->RecordCount() == 0) {
        $return_array = array(
            'error' => 1,
            'message' => "",
            'qty' => 0
        );
    } else {
        $return_array = array(
            'error' => 0,
            'message' => "",
            'qty' => $qty
        );
    }
    die(json_encode($return_array));
}

/*
 * if ($action == 'check_qty') {
 * $product_model = strtoupper ( zen_db_prepare_input ( $_POST ['model'] ) );
 * $qty = intval ( $_POST ['qty'] );
 * if ($product_model != '') {
 * $check = $db->Execute ( 'select products_id, products_quantity_order_min, products_quantity_order_max,is_sold_out,products_limit_stock from ' . TABLE_PRODUCTS . ' where products_model = "' . $product_model . '" and products_status = 1' );
 *
 * $products_quantity = zen_get_products_stock($check->fields['products_id']);
 * $check->fields['products_quantity'] = $products_quantity;
 *
 * $caution = '';
 * if ($check->RecordCount () == 1) {
 * //WSL 促销商品的库存判断 quickadd
 * $is_promotion = false;
 *
 * //临时取消促销限制 xiaoyong.lv20150420
 * // if(zen_is_promotion_time()){
 * $promotion_discount = get_products_discount_by_products_id($check->fields['products_id']);
 * if($promotion_discount>0){
 * $is_promotion = true;
 * }
 * // }
 *
 *
 * $products_quantity = $check->fields ['products_quantity'];
 * $products_order_min = $check->fields ['products_quantity_order_min'];
 * $products_order_max = $check->fields ['products_quantity_order_max'];
 * if ($products_order_min > 1 && $qty < $products_order_min) {
 * $return_array = array('error' => 1, 'message' => sprintf(TEXT_CART_MINIMUM_AMOUNT, $product_model, $products_order_min), 'qty' => $products_order_min);
 * } elseif (($qty > $products_quantity&& ($check->fields ['is_sold_out'] == 1 || $check->fields ['products_limit_stock'] == 1 || $is_promotion )) || $qty == 2147483647) {
 * $return_array = array('error' => 1, 'message' => sprintf(TEXT_CART_ONLY_HAVE, $products_quantity, $product_model), 'qty' => $products_quantity);
 * }
 * }
 * }
 * die(json_encode($return_array));
 * }
 */

$pid = $_POST['pid'];
$qty = intval($_POST['qty']);
if ($qty > 99999) {
    $qty = 99999;
}

$caution = $update_qty_note = array();
if ($pid > 0) { // die("0154");
    
    $sql = 'select products_id, products_model, products_quantity_order_min, products_quantity_order_max,products_limit_stock,products_is_perorder from ' . TABLE_PRODUCTS . ' where products_id=' . $pid . ' limit 1';
    $query_result = $db->Execute($sql);
    
    /* products_stock WSL */
    $products_quantity = zen_get_products_stock($query_result->fields['products_id']);
    $query_result->fields['products_quantity'] = $products_quantity;
    
    if ($query_result->RecordCount() == 1) {
        $query_result->fields['products_quantity'] = zen_get_products_stock($pid);
        $products_quantity = $query_result->fields['products_quantity'];
        $products_model = $query_result->fields['products_model'];
        $products_order_min = $query_result->fields['products_quantity_order_min'];
        $products_order_max = $query_result->fields['products_quantity_order_max'];
        $update = true;
        $is_promotion = false;
        
        // 临时取消促销限制 xiaoyong.lv20150420
        // 取消该判断WSL 2015-1-13
        // if($query_result->fields['products_is_perorder'] == 1){
        // if(zen_is_promotion_time()){
        $promotion_discount_query = 'select p.promotion_discount from ' . TABLE_PROMOTION . ' p , ' . TABLE_PROMOTION_PRODUCTS . ' pp where pp.pp_products_id=' . $pid . ' and pp.pp_promotion_id=p.promotion_id and pp.pp_is_forbid = 10 and p.promotion_status=1 and pp.pp_promotion_start_time<="' . date('Y-m-d H:i:s') . '" and pp.pp_promotion_end_time>"' . date('Y-m-d H:i:s') . '"';
        $promotion_discount = $db->Execute($promotion_discount_query);
        if ($promotion_discount->fields['promotion_discount'] > 0) {
            $is_promotion = true;
        }
        // }
        // }
        
        if ($products_order_min > 1 && $qty < $products_order_min) {
            $update_qty_note[$pid] = sprintf(TEXT_ADDCART_MIN_COUNT, $products_model, $products_order_min, $products_order_min);
            $err = sprintf(TEXT_ADDCART_MIN_COUNT, $products_model, $products_order_min, $products_order_min);
            $qty = $products_order_min;
            $update = true;
        } else if (($products_quantity != 0 && $qty > $products_quantity && ($query_result->fields['products_limit_stock'] == 1)) || $qty == 2147483647) {
            $caution[$pid] = sprintf(TEXT_ADDCART_MAX_NOTE, $products_quantity, $products_model, $products_quantity);
            $err = sprintf(TEXT_CART_ONLY_HAVE, $products_quantity, $products_model);
            $qty = $products_quantity;
            $update = true;
        }
        
        // 添加商品的数量<=20 >0 并超过库存的时候，需要有弹框。
        /*
         * if($action != 'update_qty'){
         * if ($query_result->fields['products_quantity'] <= 20 && $query_result->fields['products_quantity'] > 0 ) {
         * if ( ($qty > $query_result->fields['products_quantity']) && $query_result->fields['products_limit_stock'] == 0 ) {
         * echo $out_of_qty = 'out_of_qty';
         * echo "|||";
         * echo $new_qty = $qty;
         * echo "|||";
         * echo $products_quantity;
         * echo "|||";
         * echo $products_model;
         * //echo "|";
         * //echo $cart_qty = $_SESSION['cart']->get_quantity($pid);
         * exit;
         * }
         * }
         * }
         */
        
        if ($update) {
            if ($_SESSION['cart']->in_cart($pid)) {
                $_SESSION['cart']->update_quantity($pid, $qty, '', false);
            } else {
                if ($qty > 0 && $action != 'remove') {
                    $_SESSION['cart']->add_cart($pid, $qty);
                }
            }
            if (! zen_not_null($caution[$pid])) {
                if ($is_mobilesite) {
                    // $caution[$pid] = sprintf( TEXT_UPDATE_QTY_SUCCESS_MOBILE, $qty ); // 20170220 取消手机站提示 feiyao DB V3.5.7
                } else {
                    $update_qty_note[$pid] = TEXT_UPDATE_QTY_SUCCESS;
                }
            }
        }
    }
}

if ($action == 'update_is_checked') {
    $type = zen_db_prepare_input($_POST['type']);
    $is_checked = intval($_POST['is_checked']);
    $customers_basket_id = intval($_POST['customers_basket_id']);
    $is_checked = intval($_POST['is_checked']);
    $customers_where = " 1=1";
    if (! empty($_SESSION['customer_id'])) {
        $customers_where .= " and customers_id=" . $_SESSION['customer_id'];
    } else {
        $customers_where .= " and cookie_id='" . $_SESSION['cookie_cart_id'] . "'";
    }
    if ($type == "all") {
        $sql_is_checked = "update " . TABLE_CUSTOMERS_BASKET . " set is_checked=" . $is_checked . " where" . $customers_where;
    } else if ($type == "single") {
        $sql_is_checked = "update " . TABLE_CUSTOMERS_BASKET . " set is_checked=" . $is_checked . " where" . $customers_where . " and customers_basket_id=" . $customers_basket_id;
    }
    if (! empty($sql_is_checked)) {
        $db->Execute($sql_is_checked);
    }
}

if (empty($select_country_code)) {
    $select_country_code = $country_code;
}

// $_SESSION['cart']->calculate ();
$_SESSION['valid_to_checkout'] = true;
// $_SESSION['cart']->get_isvalid_checkout ( true );
// Tianwen.Wan20160624购物车优化
$is_mobile = false;
if ($is_mobilesite == 1) {
    $is_mobile = true;
}
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize($page_size, $page, false, $is_mobile, true);
$products = $products_array['data'];
$products_num = $products_array['count'];
$products_removed_array = $products_array['products_removed_array'];
$is_checked_all = $products_array['is_checked_all'];

if ($action == 'invalid_items_fenye') {
    $page = $_POST['page'];
    $invalid_items_str = '';
    $return_array = array();
    $invalid_items_count = sizeof($products_removed_array);
    $products_removed_array = array_slice($products_removed_array, ($page - 1) * 5, 5);
    foreach ($products_removed_array as $key => $value) {
        $invalid_items_str .= '<p><img src="' . $value['products_image_80'] . '" /> <span>' . $value['products_name'] . ',  [' . $value['products_model'] . ']</span> </p>';
    }
    if ($invalid_items_count > 5) {
        $invalid_items_split = new splitPageResults('', '5', '', 'page', false, $invalid_items_count);
        $invalid_items_fen_ye = '<div class="page">' . $invalid_items_split->display_links_mobile_for_shoppingcart(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array(
            'page',
            'info',
            'x',
            'y',
            'main_page'
        )), true) . '</div>';
    } else {
        $invalid_items_fen_ye = '';
    }
    $return_array['invalid_items_str'] = $invalid_items_str;
    $return_array['invalid_items_fen_ye'] = $invalid_items_fen_ye;
    die(json_encode($return_array));
}

if ($action == 'radio' && isset($_POST['shipping_code'])) {
    $shipping_code = zen_db_prepare_input($_POST['shipping_code']);
    $_SESSION['estimate_method'] = $shipping_code;
}

$show_package_box_weight_str = $shipping_total_weight_str = "";

$post_postcode = zen_db_prepare_input($_POST['postcode']);

if ($action == 'estimate') {
    $country_name = zen_db_prepare_input($_POST['country_name']);
    $post_city = zen_db_prepare_input($_POST['city']);
    
    $countries_iso_code_2 = "";
    if (! empty($country_name)) {
        $country_query = $db->Execute('select countries_iso_code_2, countries_id from ' . TABLE_COUNTRIES . ' where countries_name = "' . $country_name . '"');
        if ($country_query->RecordCount() > 0) {
            $countries_iso_code_2 = $_SESSION['cart_country_code'] = $country_query->fields['countries_iso_code_2'];
            $_SESSION['cart_country_id'] = $country_query->fields['countries_id'];
        }
    }
    
    if (empty($countries_iso_code_2)) {
        $countries_iso_code_2 = get_default_country_code(array(
            'customers_id' => $_SESSION['customer_id'],
            'address_book_id' => 0
        ));
    }
}

$countries_iso_code_2 = get_default_country_code(array(
    'customers_id' => $_SESSION['customer_id'],
    'address_book_id' => 0
));

$shipping_modules = new shipping('', $countries_iso_code_2, '', $post_postcode, $post_city);
$shipping_data = $shipping_modules->get_default_shipping_info(array(
    'customers_id' => $_SESSION['customer_id'],
    'countries_iso_code_2' => $countries_iso_code_2,
    'address_book_id' => 0,
    'postcode' => $post_postcode
));

$shipping_list = $shipping_data['shipping_list'];
$shipping_info = $shipping_data['shipping_info'];
$special_discount = $shipping_data['special_discount'];

$special = false;
if (sizeof($special_discount) > 0) {
    $special = true;
}
$smarty->assign('promotion_total', $_SESSION['cart']->show_promotion_total());
$shipping_code = $shipping_info['code'];
$shipping_cost = $currencies->format_cl($shipping_info['final_cost']);
$shipping_cost_usd = $shipping_info['cost'];
$shipping_title = $shipping_info['title'];
$show_package_box_weight_str = $shipping_info['shipping_package_box_weight'];
$shipping_total_weight_str = $shipping_info['shipping_weight'];
$shipping_volume_weight = $shipping_info['shipping_volume_weight'];
$shipping_volume_weight_title = $shipping_info['shipping_volume_weight_title'];
$total_all = $_SESSION['cart']->show_total_new();

$total_weight = $_SESSION['cart']->show_weight();
$total_weight_all = ($total_weight > 50000 ? $total_weight * 1.06 : $total_weight * 1.1);
$volume_shipping_weight = $_SESSION['cart']->show_volume_weight();
$module_id = "";
$show_volume_weight = "";
$discount = 0;

if (! empty($shipping_volume_weight)) {
    $show_volume_weight = '<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;"><a href="index.php?main_page=page&id=21#P5">' . $shipping_volume_weight_title . '</a></td><td style="border-bottom:#d0d1a9 1px solid;"><label title="' . TEXT_CALCULATE_BY_VOLUME . '">' . $shipping_volume_weight . ' ' . TEXT_CART_WEIGHT_UNIT . '</label></td>';
}

$cal_vip_amount = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车没有运费返还
/* 满减活动 */
if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME) {
    if ($cal_vip_amount > $currencies->format_cl(49)) {
        $discount = floor($cal_vip_amount / $currencies->format_cl(49)) * $currencies->format_wei(4);
        $cal_vip_amount = $cal_vip_amount - $discount;
    }
}
/* 阶梯式满减活动 */
if (date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && ! $_SESSION['channel']) {
    if ($cal_vip_amount > $currencies->format_cl(379)) {
        $discount = 25;
    } elseif ($cal_vip_amount > $currencies->format_cl(259)) {
        $discount = 20;
    } elseif ($cal_vip_amount > $currencies->format_cl(149)) {
        $discount = 10;
    } elseif ($cal_vip_amount > $currencies->format_cl(49)) {
        $discount = 5;
    } elseif ($cal_vip_amount > $currencies->format_cl(19)) {
        $discount = 1;
    } else {
        $discount = 0;
    }
    $cal_vip_amount = $cal_vip_amount - $currencies->format_cl($discount);
}
$cVipInfo = getCustomerVipInfo(false, array(), $cal_vip_amount);
$prom_discount_note = '';
if ($is_login) {
    // 订单折扣与 VIP&RCD取大者
    $promInfo = calculate_order_discount();
    $prom_discount = $promInfo['order_discount'];
    $prom_discount_title = $promInfo['order_discount_title'];
    
    $vip_rcd_discount = $cVipInfo['amount'];
    $rcd_discount = 0;
    if ($_SESSION['cart']->show_total_new() > $_SESSION['cart']->show_promotion_total()) {
        // $copuns_display = true;
        $total_amount = $_SESSION['cart']->show_total_new()  - $_SESSION['cart']->show_promotion_total();

        /* 满减活动 */
        if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME) {
            if ($total_amount > $currencies->format_cl(49)) {
                $discount = floor($total_amount / $currencies->format_cl(49)) * $currencies->format_wei(4);
                $total_amount = $total_amount - $discount;
            }
        }

        /* 阶梯式满减活动 */
        if (date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && ! $_SESSION['channel']) {
            if ($total_amount > $currencies->format_cl(379)) {
                $discount = 25;
            } elseif ($total_amount > $currencies->format_cl(259)) {
                $discount = 20;
            } elseif ($total_amount > $currencies->format_cl(149)) {
                $discount = 10;
            } elseif ($total_amount > $currencies->format_cl(49)) {
                $discount = 5;
            } elseif ($total_amount > $currencies->format_cl(19)) {
                $discount = 1;
            } else {
                $discount = 0;
            }

            $total_amount = $total_amount - $discount;
        }

        $total_amount = $total_amount - $cVipInfo['amount'];

        if (! zen_get_customer_create() && ! get_with_channel()) {
            $rcd_discount = round(0.03 * $total_amount, 2);
            $vip_rcd_discount += $rcd_discount;
        }

    }

    if ($prom_discount >= $vip_rcd_discount) {
        $cVipInfo['amount'] = 0;
        $rcd_discount = 0;
        // $copuns_display = false;
        $show_current_discount = '';
        $prom_discount_note = zen_get_discount_note();
    } else {
        $prom_discount = 0;
        $prom_discount_title = '';
        $show_current_discount = $rcd_discount;
    }

    // eof
    $tenoff = 0;
    $smarty->assign('tenoff', $tenoff);
    $smarty->assign('prom_discount', $currencies->format_cl($prom_discount, false));
    $smarty->assign('prom_discount_format', $currencies->format($prom_discount, false));
    $smarty->assign('prom_discount_title', $prom_discount_title);
    $smarty->assign('rcd_discount', $rcd_discount);
    $smarty->assign('show_current_discount', $currencies->format($show_current_discount));
} else {
    $prom_discount_note = zen_get_discount_note();
}
$smarty->assign('prom_discount_note', $prom_discount_note);

$symbol_left = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
if ($action == 'cal' || ($action == 'radio' && isset($_POST['shipping_code']))) {
    unset($_SESSION['delete_products']);
    if ($shipping_cost > 0) {
        $shipping_content_arr[0] = ' <span class="shipping_cost">' . $currencies->format($shipping_cost, false) . '</span>';
    } else {
        $shipping_content_arr[0] = '<span class="shipping_cost">' . TEXT_FREE_SHIPPING . '</span>';
    }

    /* 满减活动WSL */
    // 若需要重新开启此活动，需要给出满减活动对订单折扣的要求，并将订单折扣的代码加入此活动中。
    if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME) {
        // $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $currencies->format_cl ( $special_discount[$shipping_code] ) - $_SESSION['cart']->show_daily_deal_total();
        $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车没有运费返还
        if ($promotion_discount_full_set_minus > $currencies->format_cl(49)) {
            $discount = floor($promotion_discount_full_set_minus / $currencies->format_cl(49)) * $currencies->format_wei(4);
            if ($discount > 0) {
                $shipping_content_arr[6] = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS . ':';
                $shipping_content_arr[7] = '-' . $currencies->format($discount, false);
                // $cal_vip_amount = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl ( $special_discount[$shipping_code] ) - $discount;
                // $cVipInfo = getCustomerVipInfo (false , array(), $cal_vip_amount);
            }
        } else {
            $discount = 0;
            $shipping_content_arr[6] = '';
            $shipping_content_arr[7] = '';
        }
    }
    /* 阶梯式满减活动 */
    if (date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && ! $_SESSION['channel']) {
        $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车没有运费返还
        if ($promotion_discount_full_set_minus > $currencies->format_cl(379)) {
            $discount = 25;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(259)) {
            $discount = 20;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(149)) {
            $discount = 10;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(49)) {
            $discount = 5;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(19)) {
            $discount = 1;
        } else {
            $discount = 0;
            $shipping_content_arr[6] = '';
            $shipping_content_arr[7] = '';
        }
        
        if ($discount > 0) {
            $shipping_content_arr[6] = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS . ':';
            $shipping_content_arr[7] = '- ' . $currencies->format($discount);
        }
    }

    if ($shipping_cost >= 0) {
        $total_all_amount = $_SESSION['cart']->show_total_new() - $cVipInfo['amount'] - $rcd_discount + $shipping_cost - $currencies->value($discount) - $prom_discount;
    } else {
        $total_all_amount = $_SESSION['cart']->show_total_new() - $cVipInfo['amount'] - $rcd_discount - $shipping_cost - $currencies->value($discount) - $prom_discount;
    }
    /* end */
    if ($currencies->format_number($special_discount[$shipping_code], true) > 0) {
        // $shipping_content_arr [0] = '- ' . $symbol_left . ' <span class="shipping_cost">' . $currencies->format_cl ( $special_discount[$shipping_code] ) . '</span>';
        $shipping_content_arr[2] = TEXT_CART_SPECIAL_DISCOUNT . ': ';
        $shipping_content_arr[3] = '-  <span class="special_discount_amount">' . $currencies->format($special_discount[$shipping_code], true) . '</span>';
        $total_all_amount = $total_all_amount - $currencies->format_cl($special_discount[$shipping_code]);
    } else {
        $shipping_content_arr[2] = '';
        $shipping_content_arr[3] = '';
    }

    // 总价减去handing_fee
    if ($shipping_cost >= 0) {
        $pay_total = 9.99;
        $total_all_amount = $total_all_amount - $shipping_cost;

        if ($total_all_amount < $currencies->format_cl($pay_total)) {
            $handing_fee_format = 0.99;
            $handing_fee = $currencies->format_cl($handing_fee_format);
            $total_all_amount = $total_all_amount + $shipping_cost + $handing_fee;
        } else {
            $total_all_amount = $total_all_amount + $shipping_cost;
        }
    } else {
        $pay_total = 9.99;
        if ($total_all_amount < $currencies->format_cl($pay_total)) {
            $handing_fee_format = 0.99;
            $handing_fee = $currencies->format_cl($handing_fee_format);
            $total_all_amount = $total_all_amount + $handing_fee;
        }
    }
    $shipping_content_arr[1] = '(' . $shipping_title . ')';
    $shipping_content_arr[4] = ($cVipInfo['amount'] > 0 ? '- <span class="vip_amount">' . $currencies->format($cVipInfo['amount'], false) . '</span>' : '');
    $shipping_content_arr[5] = TEXT_CART_VIP_DISCOUNT . '(<font color="red">' . $cVipInfo['group_percentage'] . '% ' . TEXT_DISCOUNT_OFF_SHOW . '</font>)' . ':';
    
    $shipping_content_str = json_encode($shipping_content_arr);
    
    $return_array = array(
        'error' => 0,
        'message' => "",
        'body' => $content,
        'shipping_content_str' => $shipping_content_str,
        'total_amount' => $currencies->format($total_all_amount, false),
        'show_weight' => $_SESSION['cart']->show_weight(),
        'show_volume_weight' => $show_volume_weight,
        'show_package_box_weight_str' => $show_package_box_weight_str . " " . TEXT_CART_WEIGHT_UNIT,
        'shipping_total_weight_str' => $shipping_total_weight_str . " " . TEXT_CART_WEIGHT_UNIT
    );
    die(json_encode($return_array));
}

if ($action == 'estimate') {
    
    foreach ($shipping_list as $method => $val) {
        if (! $val['error'] && isset($val['final_cost'])) {
            $shipping_methods[$val['code']] = $val;
        }
    }
    if (isset($_POST['sorttype']) && $_POST['sorttype'] != '') {
        switch ($_POST['sorttype']) {
            case 'drise':
                $sortby = 'day_sum';
                $sort = 'asc';
                $sortby_then = 'cost';
                break;
            case 'ddown':
                $sortby = 'day_sum';
                $sort = 'desc';
                $sortby_then = 'cost';
                break;
            case 'prise':
                $sortby = 'cost';
                $sort = 'asc';
                $sortby_then = 'day_low';
                break;
            case 'pdown':
                $sortby = 'cost';
                $sort = 'desc';
                $sortby_then = 'day_low';
                break;
            default:
                $sortby = 'day_sum';
                $sort = 'asc';
                $sortby_then = 'cost';
        }
    } else {
        $sortby = 'cost';
        $sort = 'asc';
        $sortby_then = 'day_low';
    }
    $shipping_methods = $shipping_modules->array_sort($shipping_methods, $sortby, $sort, $sortby_then);
    include_once (DIR_WS_LANGUAGES . $_SESSION['language'] . '/shopping_cart.php');
    $content = '<table class="shipwaysmall">
					<tr>
						<th width="240"><span style="margin-left:30px;">' . TEXT_SHIPPING_METHOD . '</span></th>
						<th width="180">' . TEXT_CART_SHIPPING_EST_TIME . ' <span class="drise"></span><span class="ddown"></span></th>
						<th width="190">' . TEXT_CART_SHIPPING_EST_COST . ' <span class="prise"></span><span class="pdown"></span></th>' . ($special ? '<th>' . TEXT_CART_SHIPPING_EST_SPECIAL . '</th>' : '') . '</tr>';
    $sizeofmethod = sizeof($shipping_methods);
    foreach ($shipping_methods as $key => $val) {
        if ($val['code'] == 'agent') {
            $display_price = $currencies->format($val['final_cost'], true);
        } else {
            $display_price = $val['final_cost'] == 0 ? TEXT_FREE_SHIPPING : $currencies->format($val['final_cost'], true);
        }
        $time_unit = TEXT_DAYS_LAN;
        if ($val['time_unit'] == 20) {
            $time_unit = TEXT_WORKDAYS;
        }
        $hot_logo = '';
        if ($val['is_virtual']) {
            $hot_logo = '<span style="display:inline-block; position:relative;padding: 0;">
                                            <span style="position:absolute; display:inline-block; top:-11px;padding: 0;">
                                                <img src="/includes/templates/cherry_zen/css/' . $_SESSION['languages_code'] . '/images/db-hot.png" border="0">
                                            </span>
                                        </span>';
        }
        
        $display_note = ($val['box_note'] != '' && $val['remote_note'] != '' ? $val['box_note'] . '<br>' . $val['remote_note'] : $val['box_note'] . $val['remote_note']);
        $display_note = $val['box_note'] == '' && $val['remote_note'] == '' ? '' : $display_note;
        $content .= '<tr style="cursor:pointer;" ' . ($val['code'] == $shipping_info['code'] || $sizeofmethod == 1 ? 'class="bychecked"' : '') . '>
						<td><input type="radio" ' . ($val['code'] == $shipping_info['code'] || $sizeofmethod == 1 ? 'checked' : '') . ' name="ship" id="' . $val['code'] . '"><span class="cal_result_title">' . $val['title'] . '</span>' . $hot_logo . '</td>
						<td>' . $val['days'] . ' ' . $time_unit . '<input type="hidden" class="day" value="' . ($val['day'] * 100 + $val['day_high']) . '"></td>
						<td><span class="cal_result_cost">' . $display_price . '</span>' . ($display_note != '' ? '<strong class="shipping_extra_note">[?]</strong>' : '') . '<input type="hidden" class="cost" value="' . ($val['final_cost'] <= 0 ? ($special_discount[$val['code']] ? '-' . $currencies->format_cl($special_discount[$val['code']]) : 0) : round($val['final_cost'], 2)) . '"></td>
						' . ($special ? '<td>' . ($special_discount[$val['code']] ? '-' . $currencies->format($special_discount[$val['code']]) : '') . '</td>' : '') . '
					</tr>';
        if ($display_note != '') {
            $content .= '<tr class="shownone" ' . ($val['code'] == $shipping_info['code'] || $sizeofmethod == 1 ? 'style="display:block"' : '') . '><td colspan="' . ($special ? 4 : 3) . '"><div class="remotetips"><p>' . $display_note . '</p></div></td></td></tr>';
        }
    }
    $content .= '</table>';
    if ($shipping_methods[$shipping_info['code']]['final_cost'] > 0) {
        $shipping_content_arr[0] = ' ' . $symbol_left . '<span class="shipping_cost">' . $currencies->format_number($shipping_cost) . '</span>';
    } else {
        $shipping_content_arr[0] = '<span class="shipping_cost">' . TEXT_FREE_SHIPPING . '</span>';
    }
    $total_all_amount = $_SESSION['cart']->show_total_new() - $cVipInfo['amount'] + $shipping_cost - $prom_discount;
    if ($special_discount[$shipping_info['code']] > 0) {
        // $shipping_content_arr [0] = '- ' . $symbol_left . ' <span class="shipping_cost">' . $currencies->format_cl ( $special_discount[$shipping_info['code']] ) . '</span>';
        $shipping_content_arr[2] = TEXT_CART_SPECIAL_DISCOUNT . ': ';
        $shipping_content_arr[3] = '- ' . $symbol_left . '<span class="special_discount_amount">' . $currencies->format_number($special_discount[$shipping_code], true) . '</span>';
        $total_all_amount = $total_all_amount - $currencies->format_cl($special_discount[$shipping_info['code']]);
    } else {
        $shipping_content_arr[2] = '';
        $shipping_content_arr[3] = '';
    }
    $shipping_content_arr[1] = '(' . $shipping_info['title'] . ')';
    $shipping_content_arr[4] = ($cVipInfo['amount'] > 0 ? '- <span class="vip_amount">' . $currencies->format($cVipInfo['amount']) . '</span>' : '');
    $shipping_content_arr[5] = TEXT_CART_VIP_DISCOUNT . '(<font color="red">' . $cVipInfo['group_percentage'] . '%</font>)';
    $shipping_content_str = json_encode($shipping_content_arr);
    $return_array = array(
        'error' => 0,
        'message' => "",
        'body' => $content,
        'shipping_content_str' => $shipping_content_str,
        'total_amount' => $currencies->format($total_all_amount, false),
        'vip_amount' => $currencies->format_number($cVipInfo['amount']),
        'show_weight' => $_SESSION['cart']->show_weight(),
        'show_volume_weight' => $shipping_info['shipping_volume_weight'],
        'shipping_volume_weight_title' => $shipping_info['shipping_volume_weight_title'],
        'shipping_total_weight_str' => $shipping_info['shipping_weight'] . " " . TEXT_CART_WEIGHT_UNIT,
        'shipping_total_weight_str' => $shipping_info['shipping_weight'] . " " . TEXT_CART_WEIGHT_UNIT
    );
    die(json_encode($return_array));
}

// Tianwen.Wan20160624购物车优化
// $_SESSION['valid_to_checkout'] = true;
// $_SESSION['cart']->get_isvalid_checkout ( true );

$cart_products_down_errors .= $_SESSION['cart_products_down_errors'];
$cart_products_out_stoct_errors = $_SESSION['cart_products_out_stoct_errors'];
unset($_SESSION['cart_products_down_errors']);
unset($_SESSION['cart_products_out_stoct_errors']);
$smarty->assign('cart_products_down_errors', $cart_products_down_errors);
$smarty->assign('cart_products_out_stoct_errors', $cart_products_out_stoct_errors);
$smarty->assign('cart_has_buy_facebook_like_product_errors', $_SESSION['cart_has_buy_facebook_like_product_errors']);
unset($_SESSION['cart_has_buy_facebook_like_product_errors']);

// $products_num = $_SESSION['cart']->get_products_num ();
$smarty->assign('products_num', $products_num);

if (! $_SESSION['valid_to_checkout']) {
    if ($_SESSION['cart_errors_min'] != '') {
        $messageStack->add('cart_errors_min', ERROR_CART_UPDATE . $_SESSION['cart_errors_min'], 'caution');
    }
    if ($_SESSION['cart_products_errors'] != '') {
        $messageStack->add('cart_products_errors', $_SESSION['cart_products_errors'], 'caution');
    }
}
if (! isset($_SESSION['customer_id']) && $products_num >= 10) {
    $messageStack->add('shopping_cart', ERROR_CART_RECOMMEND_LOGIN, 'caution');
}
$smarty->assign('messageStack', $messageStack);

$smarty->assign('total_weight', $_SESSION['cart']->show_weight());
$smarty->assign('total_items', $products_num);
$smarty->assign('is_checked_count', $products_array['is_checked_count']);
$smarty->assign('total_amount', $currencies->format($_SESSION['cart']->show_total(), false));
$smarty->assign('total_amount_convert', $currencies->format($_SESSION['cart']->show_total_new(), false));
$smarty->assign('show_total_new_cart', $_SESSION['cart']->show_total_new() * 3 / 100);
$smarty->assign('currency_symbol_left', $symbol_left);

// bof fen ye
if ($products_num > $page_size) {
    // $products_split = new splitPageResults ( $basket_products_query, $page_size, 'p.products_id', 'page' );
    $products_split = new splitPageResults('', $page_size, '', 'page', false, $products_array['count']);
    $cart_fen_ye = '<div class="cart_split_page propagelist">' . $products_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array(
        'page',
        'info',
        'x',
        'y',
        'main_page'
    ))) . '</div>';
} else {
    $cart_fen_ye = '';
}
$smarty->assign('cart_fen_ye', $cart_fen_ye);
// eof
// christmas gift
$_SESSION['cart']->check_gift();
// Tianwen.Wan20160624购物车优化
// $smarty->assign ( 'gift_id', $_SESSION['gift_id']);
$smarty->assign('gift_id', 0);
$_SESSION['basket_product_orderby'] = true;

// $products = $_SESSION['cart']->get_products ( false, $page_size );
$promotion_discount = '';
$cate_total = 0;
for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
    $product_name = htmlspecialchars(zen_clean_html($products[$i]['name']));
    $product_link = zen_href_link('product_info', 'products_id=' . $products[$i]['id']);
    $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="jq_products_image_small lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size($products[$i]['image'], 80, 80) . '" alt="' . $product_name . '" data-id="' . $i . '" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products[$i]['image'], 500, 500) . '" />' : '');
    // show promotion max num per order
    $promotion_info = get_product_promotion_info($products[$i]['id']);
    if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
        $pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
        $max_num_per_order_tips = sprintf(TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS, $pp_max_num_per_order);
        if ($products[$i]['quantity'] > $pp_max_num_per_order) {
            $products[$i]['final_price'] = $products[$i]['original_price'];
        }
    } else {
        $pp_max_num_per_order = 0;
        $max_num_per_order_tips = '';
    }
    $product_each_price = $currencies->format_cl(zen_add_tax($products[$i]['final_price'], zen_get_tax_rate($products[$i]['tax_class_id'])));
    $product_each_price_original = $currencies->format_cl(zen_add_tax($products[$i]['original_price'], zen_get_tax_rate($products[$i]['tax_class_id'])));
    $product_total_amount = $currencies->format_cl($product_each_price * $products[$i]['quantity'], false);
    $product_total_amount_original = $currencies->format_cl($product_each_price_original * $products[$i]['quantity'], false);
    $products_model = $products[$i]['model'];
    $discount_amount = zen_show_discount_amount($products[$i]['id']);
    $first_cate_info = zen_get_first_cate($products[$i]['id']);
    
    $productArray[$i] = array(
        'product_link' => $product_link,
        'product_image' => $product_image,
        'product_name' =>  /*($products [$i] ['product_quantity']==0 ? TEXT_PREORDER.' ':'').*/getstrbylength($product_name, 100),
        'product_name_all' => $product_name,
        'id' => $products[$i]['id'],
        'qty' => $products[$i]['quantity'],
        'model' => $products_model,
        'weight' => $products[$i]['weight'],
        'volume_weight' => $products[$i]['volume_weight'],
        'price' => $currencies->format($product_each_price, false),
        'original_price' => $currencies->format($product_each_price_original, false),
        'total' => $currencies->format($product_total_amount, false),
        'total_number' => $product_total_amount,
        'is_checked' => $products[$i]['is_checked'],
        'note' => $products[$i]['note'],
        'customers_basket_id' => $products[$i]['customers_basket_id'],
        'discount' => $discount_amount,
        'product_quantity' => $products[$i]['product_quantity'],
        'cate_id' => $first_cate_info['categories_id'],
        'cate_name' => $first_cate_info['categories_name'],
        'is_preorder' => $products[$i]['product_quantity'] == 0,
        'is_gift' => 0,
        'products_qty_update_auto_note' => $products[$i]['products_qty_update_auto_note'],
        'pp_max_num_per_order' => $pp_max_num_per_order,
        'max_num_per_order_tips' => $max_num_per_order_tips,
        'products_stocking_days' => get_products_info_memcache($products[$i]['id'], 'products_stocking_days'),
        'is_s_level_product' => get_products_info_memcache($products[$i]['id'], 'is_s_level_product')
    );
    if (isset($update_qty_note[$products[$i]['id']])) {
        $productArray[$i]['update_qty_note'] = $update_qty_note[$products[$i]['id']];
    } else {
        $productArray[$i]['update_qty_note'] = '';
    }
    if ($pid == $products[$i]['id']) {
        $update_product_price = $product_each_price;
        $update_product_oprice = $product_each_price_original;
        $update_product_total = $product_total_amount;
        $update_product_note = $productArray[$i]['update_qty_note'];
        $update_pp_max_num_per_order = $pp_max_num_per_order;
        $update_max_num_per_order_tips = $max_num_per_order_tips;
        $products_stocking_days = $productArray[$i]['products_stocking_days'];
        $is_s_level_product = $productArray[$i]['is_s_level_product'];
    }
}
$smarty->assign('is_checked_all', $is_checked_all);
if ($_SESSION['cart_sort_by'] == 'cate') {
    $products_sort = zen_get_shopping_cart_category($productArray);
    $smarty->assign('product_array', $products_sort['productsArr']);
    $smarty->assign('cate_total_arr', $products_sort['cate_total_arr']);
    $cate_total_arr = $products_sort['cate_total_arr'];
} else {
    $smarty->assign('product_array', $productArray);
}
// $cVipInfo = getCustomerVipInfo (false, $cal_vip_amount); // $cal_vip_amount为326行，此处可不赋值，直接调用327行数据。
$cNextVipInfo = getCustomerVipInfo(true);
if ($is_login) {
    $order_total = $db->Execute("Select sum(order_total) as total From " . TABLE_ORDERS . " Where orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . ") And customers_id = " . (int) $_SESSION['customer_id']);
    $declare_total = $db->Execute('Select sum(usd_order_total) as d_total From ' . TABLE_DECLARE_ORDERS . " Where status>0 and customer_id = " . (int) $_SESSION['customer_id']);
    $history_amount = $order_total->fields['total'] + $declare_total->fields['d_total'];
}
$width_vip_li = round($history_amount / $cNextVipInfo['max_amt'], 2) * 100;
$smarty->assign('width_vip_li', $width_vip_li);
$smarty->assign('cVipInfo', $cVipInfo);
$smarty->assign('cNextVipInfo', $cNextVipInfo);
$smarty->assign('history_amount', floor($history_amount));
$smarty->assign('total_amount_original', $currencies->format($_SESSION['cart']->show_total_original(), false));
$promotion_discount = $_SESSION['cart']->show_total_original() - $_SESSION['cart']->show_total_new();
$smarty->assign('promotion_discount', $promotion_discount);
$smarty->assign('promotion_discount_format', $currencies->format($promotion_discount, false));
$total_all = $_SESSION['cart']->show_total_new() - $cVipInfo['amount'] - $cVipInfo['discount_amount'] - $prom_discount;
$original_prices = $_SESSION['cart']->show_origin_amount() + $_SESSION['cart']->show_discount_amount();
$smarty->assign('original_prices', $currencies->format($original_prices, false));
$vip_rcd = $cVipInfo['amount'] + $rcd_discount;

if ($prom_discount >= $vip_rcd) {
    $discounts = $prom_discount + $promotion_discount;
} else {
    $discounts = $vip_rcd + $promotion_discount;
}

$total_all_amount = $total_all + $shipping_cost;
if ($special_discount[$shipping_code] > 0) {
    $total_all_amount = $total_all - $currencies->format_cl($special_discount[$shipping_code]);
}

if (isset($_SESSION['cart_country_id']) && $_SESSION['cart_country_id'] != '') {
    $country_id = $_SESSION['cart_country_id'];
}

$text_countries_list = zen_get_country_select('zone_country_id', $country_id, $_SESSION['languages_id'], 'id="country"');
$country_info = zen_get_countries($country_id);
$text_countries_list .= zen_draw_hidden_field('country_name', $country_info['countries_name']);
$smarty->assign('text_countries_list', $text_countries_list);
if ($shipping_cost > 0) {
    $text_shipping_content = '<span class="shipping_cost">' . $currencies->format($shipping_cost, false) . '</span>';
} else {
    $text_shipping_content = '<span class="shipping_cost">' . TEXT_FREE_SHIPPING . '</span>';
}

if ($currencies->format_number($special_discount[$shipping_code], true) > 0) {
    // $text_shipping_content = '- ' . $symbol_left . ' <span class="shipping_cost">' . $currencies->format_cl ( $special_discount[$shipping_code] ) . '</span>';
    $special_discount_title = TEXT_CART_SPECIAL_DISCOUNT;
    $special_discount_content = '- <span class="special_discount_amount">' . $currencies->format($special_discount[$shipping_code], true) . '</span>';
} else {
    $special_discount_title = '';
    $special_discount_content = '';
}
$smarty->assign('cart_sort_by', $_SESSION['cart_sort_by']);
$smarty->assign('cart_sort_type', $_SESSION['cart_sort_type']);
$smarty->assign('shipping_content', $text_shipping_content);
$smarty->assign('shipping_method_by', '(' . $shipping_title . ')');

$smarty->assign('special_discount_title', $special_discount_title);
$smarty->assign('special_discount_content', $special_discount_content);
// 先定义
$manjian_discount = (int) 0;
/* 满减活动WSL delete 某个商品后的smarty加载 */
// 若需要重新开启此活动，需要给出满减活动对订单折扣的要求，并将订单折扣的代码加入此活动中。
if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME) {
    // $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $currencies->format_cl ( $special_discount[$shipping_code] ) - $_SESSION['cart']->show_daily_deal_total();
    $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车里没有运费返还
    if ($promotion_discount_full_set_minus > $currencies->format_cl(49)) {
        $manjian_discount = floor($promotion_discount_full_set_minus / $currencies->format_cl(49)) * $currencies->format_wei(4);
        if ($manjian_discount > 0) {
            $promotion_discount_full_set_minus_title = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS . ':';
            $promotion_discount_full_set_minus_content = '- ' . $currencies->format($manjian_discount, false);
            // $cal_vip_amount = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl ( $special_discount[$shipping_code] ) - $manjian_discount;
            // $cVipInfo = getCustomerVipInfo (false , array(), $cal_vip_amount);
        }
    } else {
        $manjian_discount = 0;
        $promotion_discount_full_set_minus_title = '';
        $promotion_discount_full_set_minus_content = '';
    }
}

/* 阶梯式满减活动 */
if (date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && ! $_SESSION['channel']) {
    $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车没有运费返还
    if ($promotion_discount_full_set_minus > $currencies->format_cl(379)) {
        $manjian_discount = 25;
    } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(259)) {
        $manjian_discount = 20;
    } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(149)) {
        $manjian_discount = 10;
    } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(49)) {
        $manjian_discount = 5;
    } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(19)) {
        $manjian_discount = 1;
    }  else {
        $manjian_discount = 0;
        $promotion_discount_full_set_minus_title = '';
        $promotion_discount_full_set_minus_content = '';
    }
    
    if ($manjian_discount > 0) {
        $promotion_discount_full_set_minus_title = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS . ':';
        $promotion_discount_full_set_minus_content = '- ' . $currencies->format($manjian_discount);
    }
}
$smarty->assign('promotion_discount_full_set_minus_title', $promotion_discount_full_set_minus_title);
$smarty->assign('promotion_discount_full_set_minus_content', $promotion_discount_full_set_minus_content);

$discounts += $manjian_discount;
$smarty->assign('discounts', $discounts);
$smarty->assign('manjian_discount', $manjian_discount);
$smarty->assign('discounts_format', $currencies->format($discounts, false));
// 没活动就不用减去 $_SESSION['cart']->show_daily_deal_total()
if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME) {
    // $total_all_amount = $_SESSION['cart']->show_total_new () - $currencies->format_cl ( $special_discount[$shipping_code] ) - $_SESSION['cart']->show_daily_deal_total() - $cVipInfo ['amount'] - $shipping_cost - $discount;
    $total_all_amount = $_SESSION['cart']->show_total_new() - $currencies->format_cl($special_discount[$shipping_code]) - $cVipInfo['amount'] - $rcd_discount + abs($shipping_cost) - $discount - $prom_discount;
} else {
    $total_all_amount = $_SESSION['cart']->show_total_new() - $currencies->format_cl($special_discount[$shipping_code]) - $cVipInfo['amount'] - $rcd_discount + abs($shipping_cost) - $discount - $prom_discount;
}

$total_all_handing = $_SESSION ['cart']->show_total_new () - $prom_discount - $cVipInfo ['amount'] -  $rcd_discount ;

$pay_total = 9.99;
$is_handing_fee = $total_all_handing - $currencies->format_cl($pay_total);
if ($total_all_handing < $currencies->format_cl($pay_total)) {
    $handing_fee_format = 0.99;
    $handing_fee = $currencies->format_cl($handing_fee_format);
    $total_all_amount = $total_all_amount + $handing_fee;
}

$smarty->assign('is_handing_fee', $is_handing_fee);
$smarty->assign('handing_fee_format', $handing_fee);
$smarty->assign('handing_fee', $currencies->format($handing_fee, false));
$smarty->assign('total_all', $currencies->format($total_all_amount, false));
$vip_content = '- ' . '<span class="vip_amount">' . $currencies->format($cVipInfo['amount'], false) . '</span>';

$smarty->assign('vip_content', $vip_content);

if (in_array($action, array('update_qty')) || (in_array($action, array('update_is_checked')) && $is_mobilesite)) {
    /* 满减活动WSL */
    // 若需要重新开启此活动，需要给出满减活动对订单折扣的要求，并将订单折扣的代码加入此活动中。
    if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME) {
        // $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $currencies->format_cl ( $special_discount[$shipping_code] ) - $_SESSION['cart']->show_daily_deal_total();
        $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车没有运费满减
        if ($promotion_discount_full_set_minus > $currencies->format_cl(49)) {
            $discount = floor($promotion_discount_full_set_minus / $currencies->format_cl(49)) * $currencies->format_wei(4);
            if ($discount > 0) {
                $return_array['full_set_minus_title'] = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS . ':';
                $return_array['full_set_minus_content'] = '- ' . $currencies->format($discount, false);
            }
        } else {
            $return_array['full_set_minus_title'] = '';
            $return_array['full_set_minus_content'] = '';
        }
    }
    
    /* 阶梯式满减活动 */
    if (date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && ! $_SESSION['channel']) {
        $promotion_discount_full_set_minus = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total() - $currencies->format_cl($special_discount[$shipping_code]);//购物车没有运费返还
        if ($promotion_discount_full_set_minus > $currencies->format_cl(379)) {
            $discount = 25;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(259)) {
            $discount = 20;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(149)) {
            $discount = 10;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(49)) {
            $discount = 5;
        } elseif ($promotion_discount_full_set_minus > $currencies->format_cl(19)) {
            $discount = 1;
        }  else {
            $discount = 0;
            $return_array['full_set_minus_title'] = '';
            $return_array['full_set_minus_content'] = '';
        }
        
        if ($discount > 0) {
            $return_array['full_set_minus_title'] = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS . ':';
            $return_array['full_set_minus_content'] = '- ' . $currencies->format($discount);
        }
    }
    /* end */
    $return_array['cate_total_arr'] = $cate_total_arr;
    $return_array['product_price'] = $currencies->format($update_product_price, false);
    $return_array['product_oprice'] = $currencies->format($update_product_oprice, false);
    $return_array['product_qty'] = $qty;
    $return_array['product_id'] = $pid;
    $return_array['product_total'] = $currencies->format($update_product_total, false);
    $return_array['products_num'] = $products_num;
    $return_array['is_checked_count'] = $products_array['is_checked_count'];
    $return_array['show_total_new'] = $currencies->format($_SESSION['cart']->show_total_new(), false);
    $return_array['show_weight'] = $_SESSION['cart']->show_weight();
    $return_array['show_volume_weight'] = $show_volume_weight;
    $return_array['show_package_box_weight_str'] = $show_package_box_weight_str . " " . TEXT_CART_WEIGHT_UNIT;
    $return_array['shipping_total_weight_str'] = $shipping_total_weight_str . " " . TEXT_CART_WEIGHT_UNIT;
    $return_array['show_weight_total'] = $_SESSION['cart']->show_weight() * ($_SESSION['cart']->show_weight() > 50000 ? 1.06 : 1.1);
    $return_array['vip_amount'] = $cVipInfo['amount'];
    $return_array['vip_title'] = TEXT_CART_VIP_DISCOUNT . '(<font color="red">' . $cVipInfo['group_percentage'] . '% ' . TEXT_DISCOUNT_OFF_SHOW . '</font>):';
    $return_array['special_discount_title'] = $special_discount_title;
    $return_array['special_discount_content'] = $special_discount_content;
    $return_array['shipping_content'] = $text_shipping_content;
    $return_array['shipping_method_by'] = $shipping_title;
    $return_array['total_all'] = $currencies->format($total_all_amount, false);
    $return_array['cal_total_amount_convert'] = $currencies->format($_SESSION ['cart']->show_origin_amount () + $_SESSION ['cart']->show_discount_amount (), false) . ' = ' . $currencies->format($_SESSION['cart']->show_origin_amount(), false) . ' + ' . $currencies->format($_SESSION ['cart']->show_discount_amount (), false);
    $return_array['promotion_discount_usd'] = $promotion_discount;
    $return_array['cal_total_amount_convert_mobile'] = sprintf(TEXT_CART_SAVE_PRICE, $currencies->format($_SESSION['cart']->show_total_original()), $currencies->format($promotion_discount, false));
    $return_array['product_note'] = $update_product_note;
    $return_array['discounts_formats'] = $discounts;
    $return_array['discounts_format'] = '-' . $currencies->format($discounts, false);
    $return_array['promotion_discount_format'] = '-' . $currencies->format($promotion_discount, false);
    $return_array['original_prices'] = $currencies->format($original_prices, false);
    $return_array['rcd_discounts'] = '-' . $currencies->format($rcd_discount, false);
    $return_array['vip_content'] = $vip_content;
    $return_array['product_caution'] = $caution[$pid];
    $return_array['prom_discount'] = $currencies->format_cl($prom_discount, false);
    $return_array['prom_discount_format'] = $currencies->format($prom_discount, false);
    $return_array['prom_discount_title'] = $prom_discount_title;
    $return_array['prom_discount_note'] = $prom_discount_note;
    $return_array['rcd_discount'] = $rcd_discount;
    $return_array['show_current_discount'] = $currencies->format($show_current_discount);
    $return_array['pp_max_num_per_order'] = $update_pp_max_num_per_order;
    $return_array['max_num_per_order_tips'] = $update_max_num_per_order_tips;
    $return_array['is_preorder'] = $products_quantity <= 0 ? 1 : 0;
    $return_array['is_checked_all'] = $is_checked_all;
    $return_array['handing_fee'] = $currencies->format($handing_fee, false);
    $return_array['is_handing_fee'] = $is_handing_fee;
    if ($is_s_level_product == 1) {
        $return_array['is_preorder_tip'] = '';
        $return_array['is_preorder_tip_mobile'] = '';
    } else {
        if ( $return_array['is_preorder'] == 1) {
            if ($products_stocking_days > 7) {
                $return_array['is_preorder_tip'] = TEXT_AVAILABLE_IN715;
                $return_array['is_preorder_tip_mobile'] = TEXT_AVAILABLE_IN715;
            } else {
                $return_array['is_preorder_tip'] = TEXT_AVAILABLE_IN57;
                $return_array['is_preorder_tip_mobile'] = TEXT_AVAILABLE_IN57;
            }
        }
    }
    if ($currencies->format_number($special_discount[$shipping_code], true) > 0) {
        $return_array['special_discount_title'] = TEXT_CART_SPECIAL_DISCOUNT . ': ';
        $return_array['special_discount_content'] = '- <span class="special_discount_amount">' . $currencies->format($special_discount[$shipping_code], true) . '</span>';
    } else {
        $return_array['special_discount_title'] = '';
        $return_array['special_discount_content'] = '';
    }
    if ($_SESSION['cart_sort_by'] == 'cate') {
        $return_array['cate_total_arr'] = $products_sort['cate_total_arr'];
    }
    die(json_encode($return_array));
}

$return_array = array(
    'error' => 0,
    'message' => "",
    'body' => $smarty->fetch(DIR_WS_INCLUDES . 'templates/checkout/tpl_shopping_cart_products.html'),
    'caution' => $caution,
    'qty' => $qty,
    'products_num' => $products_num,
    'show_total_new' => $currencies->format($_SESSION['cart']->show_total_new(), false),
    'show_weight' => $_SESSION['cart']->show_weight(),
    'show_volume_weight' => $show_volume_weight,
    'show_package_box_weight_str' => $show_package_box_weight_str . " " . TEXT_CART_WEIGHT_UNIT,
    'shipping_total_weight_str' => $shipping_total_weight_str . " " . TEXT_CART_WEIGHT_UNIT
);
die(json_encode($return_array));
?>