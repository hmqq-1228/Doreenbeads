<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/tell_a_friend.php');

$product_id = ( int )$_GET ['products_id'];
$sql = "select count(p.products_id) as total
          from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
          where p.products_id = '" . $product_id . "'
          and p.products_status = 1
          and pd.products_id = p.products_id
          and pd.language_id = '" . ( int )$_SESSION ['languages_id'] . "'";
$res = $db->Execute($sql);
$product_count = $res->fields ['total'];
$smarty->assign('product_count', $product_count);

$product_info = new stdClass();
$product_info->fields = get_products_info_memcache($product_id);
if (isset($product_info->fields['is_display'])) {
    if ($product_info->fields['is_display'] == 0 && !(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
    }
}
$product_info->fields['products_name'] = get_products_description_memcache($product_id, $_SESSION ['languages_id']);
if ($product_count >= 1) {
    $description_query = $db->Execute("select products_description from " . TABLE_PRODUCTS_INFO . " 
  				where products_id='" . (int)$product_id . "'
  				and language_id='" . (int)$_SESSION['languages_id'] . "'");
    if ($description_query->RecordCount() == 0 || trim($description_query->fields['products_description']) == '') {
        $description_query = $db->Execute("select products_description from " . TABLE_PRODUCTS_INFO . "
  				where products_id='" . (int)$product_id . "'
  				and language_id=1");
    }

    $p = $product_info->fields;
    //var_dump($product_info->fields);die();

    $p ['id'] = $product_id;
    $p ['name'] = $product_info->fields ['products_name'];
    $p ['show_name'] = htmlspecialchars(zen_clean_html($product_info->fields['products_name']));
    $p ['model'] = $product_info->fields ['products_model'];
    $p ['price'] = zen_get_products_display_price_new(( int )$product_id, 'product_info');
    $product_info->fields ['products_quantity'] = zen_get_products_stock($product_id);
    $p ['qty'] = $product_info->fields ['products_quantity'];
    $p ['products_quantity'] = $product_info->fields ['products_quantity'];
    $p ['weight'] = $product_info->fields ['products_weight'];
    $p ['vweight'] = $product_info->fields ['products_volume_weight'];
    $p ['shipping_weight'] = $p ['vweight'] > $p ['weight'] ? $p ['vweight'] : $p ['weight'];

    $p ['per_pack_qty'] = $product_info->fields ['per_pack_qty'];
    $p ['products_limit_stock'] = $product_info->fields ['products_limit_stock'];
    $p ['products_status'] = $product_info->fields ['products_status'];
    $p ['addtocart_max'] = 0;
    if ($product_info->fields['products_limit_stock'] == 1 && $product_info->fields ['products_quantity'] != 0) {
        $p ['addtocart_max'] = $product_info->fields ['products_quantity'];
    }

    $unit_info = get_product_unit_memcache($product_id);

    $p ['unit_number'] = $unit_info['unit_number'];
    $p ['unit_name'] = $unit_info['unit_name'];

    $products_description = $description_query->fields ['products_description'];
    if ($products_description != '') {
        $products_description = str_replace('width="473"', 'width="270"', $products_description);
        $products_description = str_replace('width="109"', 'width="55"', $products_description);
        $products_description = str_replace('height="31"', 'height="18"', $products_description);
        $products_description = str_replace('height="30"', 'height="18"', $products_description);
        $products_description = str_replace('height="55"', 'height="18"', $products_description);
    }
    $p ['description'] = $products_description;

    //$pdate = $product_info->fields ['products_date_added'];
    $display_data = floor((strtotime(date('Y-m-d')) - strtotime($pdate)) / 86400) / 365 > 1 ? false : true;
    $p ['date'] = $display_data ? sprintf(TEXT_DATE_ADDED, zen_date_long($pdate)) : '';
    $p ['date_add'] = $display_data ? zen_date_long($pdate) : null;

    $p ['image'] = $product_info->fields ['products_image'];
    $img_ext = substr($p ['image'], strrpos($p ['image'], '.'));
    $img_base = str_replace($img_ext, '', $p ['image']);
    $img_text [0] = "<img src='" . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($p ['image'], 500, 500) . "' width='620' height='620' alt='" . zen_clean_html($p ['name']) . "' />";

    $p ['main_image_src'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($p ['image'], 500, 500);
    $img_total = 1;
    $image_srcs[] = $p ['main_image_src'];

    if ($p ['image'] != '') {
        $img_total = get_img_count($product_id);
        if ($img_total > 6) {
            $img_total = 6;
        }

        for ($i = 1; $i < $img_total; $i++) {
            $img = $img_base . '_0' . $i . $img_ext;
            $img_text [$i] = '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 500, 500) . '" width="620" height="620" />';

            $image_srcs[] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 500, 500);
        }
    }

    //var_dump($image_srcs);die();
    $p ['image_count'] = $img_total;
    $p ['image_srcs'] = $image_srcs;

    $p ['images'] = $img_text;

    //$p ['ptable'] = zen_display_products_quantity_discounts_mobile ( $product_id );
    $p ['price_table'] = zen_display_products_quantity_discounts_mobile($product_id, $smarty);
//	if ($_SESSION ['cart']->in_cart ( $product_id )) {
//		$procuct_qty = $_SESSION ['cart']->get_quantity ( $product_id );
//		$bool_in_cart = 1;
//	} else {
    $procuct_qty = 0;
    $bool_in_cart = 0;
//	}
    if ($p ['qty'] <= 0) {
        $button = '<div class="detailproduct-btn"><button class="addwishilist-btn">' . TEXT_SOLD_OUT . '</button><button class="addwishilist-btn">' . IMAGE_BUTTON_ADD_WISHLIST . '</button></div>';
    } else {
        $button = '<div class="detail-input">QTY:<button class="qty_down">-</button><input type="text" class="addToCart" id="pid_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : $product_info->fields['products_quantity_order_min']) . '" size="4" /><button class="qty_plus">+</button></div>';
        $button .= '<input type="hidden" id="incart_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 0) . '" />';
        if ($bool_in_cart) {
            $button .= '<div class="detailproduct-btn"><button class="updatecart">' . TEXT_UPDATE . '</button><button class="addwishilist-btn">' . IMAGE_BUTTON_ADD_WISHLIST . '</button><input type="hidden" class="product_id" value="' . $product_id . '"></div>';
        } else {
            $button .= '<div class="detailproduct-btn"><button class="addcart">' . TEXT_CART_ADD_TO_CART . '</button><button class="addwishilist-btn">' . IMAGE_BUTTON_ADD_WISHLIST . '</button><input type="hidden" class="product_id" value="' . $product_id . '"></div>';
        }
    }

    $p ['button'] = $button;

    $reviews_query = 'select count(r.reviews_id) as count from ' . TABLE_REVIEWS . ' r, ' . TABLE_REVIEWS_DESCRIPTION . ' rd where r.products_id = ' . $product_id . ' and r.reviews_id = rd.reviews_id and r.status = 1';
    $reviews = $db->Execute($reviews_query);
    $reviews_count = $reviews->fields ['count'];
    $rate = ceil(zen_get_product_rating($product_id));
    $p ['rcount'] = $reviews_count;
    $p ['rate'] = $rate;

//    if($_GET['pn']=='promotion'){
    $discount_amount = zen_show_discount_amount($product_id);
    if ($discount_amount) {
        $p['discount'] = '<div class="floatprice"><span>' . $discount_amount . '%<br/>off</span></div>';
    }

    $p['discount_amount'] = $discount_amount;

//	}else{
//	    $pro_array['discount']='';
//	}

    $products_group_of_products = get_products_group_of_products($_SESSION['languages_id'], $product_info->fields['products_model']);
    //print_r($products_group_of_products);
    $show_products_group_of_products = "";
    if (!empty($products_group_of_products)) {
        //echo "999";exit;
        $left_cursor = $right_cursor = "";
        if (count($products_group_of_products['data']) > 4) {
            $left_cursor = '<a href="javascript:void(0);"><ins class="left_arrow_grey' . $right_color . ' jq_products_multi_design_left"></ins></a>';
            $right_cursor = '<a href="javascript:void(0);"><ins class="right_arrow' . $right_color . ' jq_products_multi_design_right"></ins></a>';
        }
        $show_products_group_of_products .= '<div style="width:100%; border-top:1px solid #ededed; margin-bottom:10px;"></div><div class="products_multi_design">' . $left_cursor . '<div><ul class="jq_products_multi_design_ul">';
        foreach ($products_group_of_products['data'] as $products_group_value) {
            $current = "";
            if ($product_info->fields['products_model'] == $products_group_value['products_model']) {
                $current .= " current";
            }
            $show_products_group_of_products .= '<li class="multi' . $current . '"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_group_value['products_id']) . '"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_group_value['products_image'], 80, 80) . '" /></a></li>';
        }

        $show_products_group_of_products .= '</ul></div>' . $right_cursor . '</div><div class="clearfix"></div>';
    }

    $other_package_products_array = get_products_package_id_by_products_id($product_id);
    if ($other_package_products_array && is_array($other_package_products_array)) {
        foreach ($other_package_products_array as $other_product_id) {
            $unit_info = get_product_unit_memcache($other_product_id);

            $other_package_products[] = array(
                "product_id" => $other_product_id,
                "link" => zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $other_product_id),
                "product_info" => get_products_info_memcache($other_product_id),
                "product_name" => htmlspecialchars(zen_clean_html(get_products_description_memcache($other_product_id))),
                "unit_number" => $unit_info['unit_number'],
                "unit_name" => $unit_info['unit_name']
            );
        }
    }

    $product_related_properties = get_product_related_properties($product_id, '');

    $product_reviews = get_product_reviews_by_page($product_id, $smarty);

    $matching_products = get_matching_products($product_id, $smarty);

    $also_like_products = get_also_like_products($product_id, $smarty);

    $also_purchased_products = get_also_purchased_products($product_id, $smarty);

    $recently_viewed_products = '';//get_recently_viewed_products_html($smarty);

    //获取改商品被添加wishlist的次数
    $wish_add_num = 0;
    if (zen_not_null($_GET['products_id'])) {
        $products_id = intval($_GET['products_id']);
        $add_num_sql = 'select products_id , show_num from ' . TABLE_PRODUCTS_ADD_WISHLIST . ' where products_id = ' . $products_id . ' limit 1';
        $add_num_query = $db->Execute($add_num_sql);

        if ($add_num_query->RecordCount() != 0) {
            $wish_add_num = $add_num_query->fields['show_num'];
        }
    }
    $wishlist_num_str = sprintf(TEXT_SHOW_WISHLIST_NUM, $wish_add_num);

    //var_dump($other_package_products_array);die();

    $promotion_info = get_product_promotion_info($products_id);
    if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
        $pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
        $max_num_per_order_tips = sprintf(TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS, $pp_max_num_per_order);
    } else {
        $pp_max_num_per_order = 0;
        $max_num_per_order_tips = '';
    }

    $smarty->assign('product_related_properties', $product_related_properties);
    $smarty->assign('show_products_group_of_products', $show_products_group_of_products);
    $smarty->assign('other_package_products', $other_package_products);
    $smarty->assign('product_reviews', $product_reviews);
    $smarty->assign('matching_products', $matching_products);
    $smarty->assign('also_like_products', $also_like_products);
    $smarty->assign('also_purchased_products', $also_purchased_products);
    $smarty->assign('recently_viewed_products', $recently_viewed_products);
    $smarty->assign('wish_add_num', $wish_add_num);
    $smarty->assign('wishlist_num_str', $wishlist_num_str);
    $smarty->assign('max_num_per_order_tips', $max_num_per_order_tips);
    $smarty->assign('p', $p);

    $customer_basket_products = zen_get_customer_basket();
    //require ($code_page_directory . 'other_package_size_products.php');
    //require ($code_page_directory . 'matching_products.php');
    //require ($code_page_directory . 'also_like_products.php');
    //require ($code_page_directory . 'also_purchased_products.php');
} else {
    $smarty->assign('text_product_not_found_tips', sprintf(TEXT_PRODUCT_NOT_FOUND_TIPS, "<font color='red'>" . (isset($product_info->fields['products_model']) ? $product_info->fields['products_model'] : $products_id) . "</font>"));
    //记录无效链接
    record_valid_url();
    //eof
}