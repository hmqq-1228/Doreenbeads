<?php
if (!defined('IS_ADMIN_FLAG')) {
    die ('Illegal Access');
}
$zc_show_matching_products = false;

if (isset ($_GET ['products_id'])) {
    $main_products_id = trim($_GET ['products_id']);
	if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
		$products_display_solr_str = ' and is_display = 1 ';
	}
    $match_model = $db->Execute("select zpm.match_products_id from " . TABLE_PRODUCTS_MATCH_PROD_LIST . " zpm inner join " . TABLE_PRODUCTS . " zp on zpm.match_products_id = zp.products_id where zpm.products_id = " . (int)$main_products_id . " and zp.products_status != 10" . $products_display_solr_str);

    if ($match_model->RecordCount() > 0) {
        $page_name = "product_listing";
        $page_type = 0;

        $sql_match_query = '';

        $match_products_num = 0;

        $matching_products_content = array();
        $disp_sum = 0;
        while (!$match_model->EOF) {
            $match_products = new stdClass();
            $match_products->fields = get_products_info_memcache($match_model->fields['match_products_id']);
            $match_products->fields['products_name'] = get_products_description_memcache($match_model->fields['match_products_id'], $_SESSION['languages_id']);
            $match_products->fields ['products_quantity'] = zen_get_products_stock($match_model->fields['match_products_id']);
            if ($match_products->fields['products_status'] != 1) {
                $match_model->MoveNext();
                continue;
            }

            $product_id = $match_products->fields ['products_id'];
            $product_quantity = $match_products->fields ['products_quantity'];
            $product_image = $match_products->fields ['products_image'];
            $product_name = $match_products->fields ['products_name'];
            $product_min_order = $match_products->fields ['products_quantity_order_min'];
            $product_max_order = $match_products->fields ['products_quantity_order_max'];
            $match_products_num++;

            $procuct_qty = 0;
            $bool_in_cart = 0;
            $unit_price = zen_get_unit_price($product_id);
            if ($_SESSION['languages_id'] == 3 && $_SESSION['currency'] == 'RUB' && $unit_price != '') {
                $text_price = '<p class="unit_price_also_like">' . $unit_price . '</p>';
            } else {
                $text_price = zen_get_products_display_price_new($product_id, 'matching');
            }

            $discount_amount = get_products_discount_by_products_id($product_id);
            $matching_products_content[$disp_sum]['discount'] = $discount_amount > 0 ? draw_discount_img($discount_amount, 'div') : '';
            $matching_products_content[$disp_sum]['img'] = '<div class="hovercont"><a title="' . htmlspecialchars(zen_clean_html($product_name)) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '" class="similarimg"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 130, 130) . '" alt="' . htmlspecialchars(zen_clean_html($product_name)) . '"></a></div>';
            $matching_products_content[$disp_sum]['name'] = '<p class="des"><a title="' . htmlspecialchars(zen_clean_html($product_name)) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '">' . getstrbylength(htmlspecialchars(zen_clean_html($product_name)), 32) . '</a></p>';
            $matching_products_content[$disp_sum]['price'] = $text_price;
            $matching_products_content[$disp_sum]['button'] = '<div class="detailinput protips"><p>';
            if ($product_quantity > 0) {
                $matching_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" id="' . $page_name . '_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="' . $bool_in_cart . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" />
																	<a rel="nofollow" href="javascript:void(0);" class="' . ($bool_in_cart ? 'icon_updates' : 'icon_addcart') . '" title="' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '" id="submitp_' . $product_id . '" onclick="Addtocart_list(' . $product_id . ',' . $page_type . ', this); return false;"></a>';
            } else {
                if ($match_products->fields['is_sold_out'] == 1) {
                    $matching_products_content[$disp_sum]['button'] .= '<span class="soldout_text"><a rel="nofollow" id="restock_' . $product_id . '" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
                    $matching_products_content[$disp_sum]['button'] .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">' . TEXT_SOLD_OUT . '</a>';
                } else {
                    $matching_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" id="' . $page_name . '_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="' . $bool_in_cart . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" />
																	<a rel="nofollow" href="javascript:void(0);" class="' . ($bool_in_cart ? 'icon_updates' : 'icon_addcart') . '" title="' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '" id="submitp_' . $product_id . '" onclick="Addtocart_list(' . $product_id . ',' . $page_type . ', this); return false;"></a>';
                    $backtip = '<div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999">' . ($match_products->fields['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57) . '</div>';
                }
            }
            $matching_products_content[$disp_sum]['button'] .= '<a rel="nofollow" class="text addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" id="wishlist_' . $product_id . '" class="addwishlistbutton" onclick="beforeAddtowishlist(' . $product_id . ',' . $page_type . '); return false;" href="javascript:void(0);"></a>';
            $matching_products_content[$disp_sum]['button'] .= '</p>';
            $matching_products_content[$disp_sum]['button'] .= '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
            $matching_products_content[$disp_sum]['button'] .= '<div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
            $matching_products_content[$disp_sum]['button'] .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div></div>';
            $matching_products_content[$disp_sum]['button'] .= $backtip;
            $backtip = '';
            $disp_sum++;
            $match_model->MoveNext();
        }

        if ($match_products_num > 0) {
            //if ($match_products_num > 10) {
            //	$title = '<p class="detailconttit"><strong>' . TEXT_MATCHED_ITEMS . '</strong><a href="' . zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=matching&pid=' . $_GET ['products_id']) . '">' . TEXT_HEADER_MORE . '<ins></ins></a></p>';
            //} else {
            $title = '<p class="detailconttit"><strong>' . TEXT_MATCHED_ITEMS . '</strong></p>';
            //}
            $zc_show_matching_products = true;
        }
        //}
    }
}
?>	
