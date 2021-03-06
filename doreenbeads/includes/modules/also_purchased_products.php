<?php
/*
 * also purchased products
 */

if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
$zc_show_matching_products = false;

if (isset ( $_GET ['products_id'] )) {
	if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
		$products_display_solr_str = ' and is_display = 1 ';
	}
	$also_purchased_products_id_sql = 'select distinct ap.also_purchased_id from ' . TABLE_ALSO_PURCHASED . ' ap inner join ' . TABLE_PRODUCTS . ' zp on ap.also_purchased_id = zp.products_id where ap.origin_products_id='.(int)$_GET['products_id'] . '  and zp.products_status != 10 ' . $products_display_solr_str . ' order by ap.also_purchased_id desc limit ' . MAX_DISPLAY_ALSO_PURCHASED;
    $also_purchased_products_id = $db->Execute($also_purchased_products_id_sql);
	if ($also_purchased_products_id->RecordCount () > 0) {
		$num_products_alsolike = $also_purchased_products_id->RecordCount ();
		$main_products_id = trim ( $_GET ['products_id'] );
		$page_name = "product_listing";
		$page_type = 1;
		$matching_products_content = array ();
		$disp_sum = 0;
		/*
		$customer_basket_products = zen_get_customer_basket ();
		*/
		while ( ! $also_purchased_products_id->EOF ) {
		    $product_id = $also_purchased_products_id->fields ['also_purchased_id'];
		    $also_purchased_products = new stdClass();
		    $also_purchased_products->fields = get_products_info_memcache($product_id);
		    if($also_purchased_products->fields['products_status']!=1){
		        $also_purchased_products_id->MoveNext();
		        continue;
		    }
		    $also_purchased_products->fields['products_name'] = get_products_description_memcache($product_id,$_SESSION['languages_id']);
		    $also_purchased_products->fields ['products_quantity'] = zen_get_products_stock($product_id);
			$product_quantity = $also_purchased_products->fields ['products_quantity'];
			$product_image = $also_purchased_products->fields ['products_image'];
			$product_name = $also_purchased_products->fields ['products_name'];
			$product_min_order = $also_purchased_products->fields ['products_quantity_order_min'];
			$product_max_order = $also_purchased_products->fields ['products_quantity_order_max'];
			/*
			if (isset ( $customer_basket_products [$product_id] )) {
				$procuct_qty = $customer_basket_products [$product_id];
				$bool_in_cart = 1;
			} else {
				$procuct_qty = 0;
				$bool_in_cart = 0;
			}
			*/
			$procuct_qty = 0;
			$bool_in_cart = 0;
			
			$unit_price = zen_get_unit_price($product_id);
			if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){
				$text_price = '<p class="unit_price_also_like">'.$unit_price.'</p>';
			}else{
				$text_price =  zen_get_products_display_price_new ( $product_id, 'matching' );
			}
			$discount_amount = zen_show_discount_amount ( $product_id );
			$matching_products_content[$disp_sum]['discount'] = $discount_amount > 0 ? draw_discount_img($discount_amount,'div') : '';
    		$matching_products_content [$disp_sum] ['img'] = '<div class="hovercont"><a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $product_id ) . '" class="similarimg"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $product_image, 130, 130 ) . '" alt="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '"></a></div>';
			$matching_products_content [$disp_sum] ['name'] = '<p class="des"><a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $product_id ) . '">' . getstrbylength ( htmlspecialchars ( zen_clean_html ( $product_name ) ), 32 ) . '</a></p>';
			$matching_products_content [$disp_sum] ['price'] = $text_price;
			$matching_products_content [$disp_sum] ['button'] = '<div class="detailinput protips"><p>';
			if ($product_quantity > 0) {
				$matching_products_content [$disp_sum] ['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" id="' . $page_name . '_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="' . $bool_in_cart . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" />
																<a rel="nofollow" href="javascript:void(0);" class="' . ($bool_in_cart ? 'icon_updates' : 'icon_addcart') . '" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '" onclick="Addtocart_list(' . $product_id . ',' . $page_type . ', this); return false;"></a>';
			} else {
				
				if($also_purchased_products->fields['is_sold_out'] == 1){
					$matching_products_content [$disp_sum] ['button'] .= '<span class="soldout_text"><a rel="nofollow" id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$matching_products_content [$disp_sum] ['button'] .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">'.TEXT_SOLD_OUT.'</a>';
				}else{
					/*
					$matching_products_content [$disp_sum] ['button'] .= '<input type="hidden" id="MDO_' . $product_id . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $product_id . '" value="'.$procuct_qty.'" />';
							
					$matching_products_content [$disp_sum] ['button'] .= '<span class="soldout_text"><a rel="nofollow" id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$matching_products_content [$disp_sum] ['button'] .='<a rel="nofollow" class="icon_backorder" id="submitp_' . $product_id . '" onclick="makeSureCart('.$product_id.','.$page_type.',\''.$page_name.'\',\''.get_backorder_info($product_id).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . '</a>';
					*/
					$matching_products_content [$disp_sum] ['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" id="' . $page_name . '_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="' . $bool_in_cart . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" />
																<a rel="nofollow" href="javascript:void(0);" class="' . ($bool_in_cart ? 'icon_updates' : 'icon_addcart') . '" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '" onclick="Addtocart_list(' . $product_id . ',' . $page_type . ', this); return false;"></a>';
					$backtip = '<div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999">'.($also_purchased_products->fields['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</div>';
				}
			}
			$matching_products_content [$disp_sum] ['button'] .= '<a rel="nofollow" class="addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" id="wishlist_' . $product_id . '" class="addwishlistbutton" onclick="beforeAddtowishlist(' . $product_id . ',' . $page_type . '); return false;" href="javascript:void(0);"></a>';
			$matching_products_content [$disp_sum] ['button'] .= '</p>';
			$matching_products_content [$disp_sum] ['button'] .= '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
			$matching_products_content [$disp_sum] ['button'] .= '<div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
			$matching_products_content [$disp_sum] ['button'] .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div></div>';
			$matching_products_content [$disp_sum] ['button'] .= $backtip;
			$backtip = '';
			$disp_sum ++;
			$also_purchased_products_id->MoveNext ();
		}
		
		if ($num_products_alsolike > 0) {
			$title = '<p class="detailconttit"><strong>' . TEXT_ALSO_PURCHASED_PRODUCTS . '</strong></p>';
			$zc_show_matching_products = true;
		}
	}
}
?>
