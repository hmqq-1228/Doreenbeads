<?php
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
$disp_sum = 0;
if (isset ( $_GET ['products_id'] )) {
	$also_purchased_products = $db->Execute("select p.products_id, p.products_image, p.products_price, p.products_model, products_weight, pd.products_name
                     	from " . TABLE_ALSO_PURCHASED . " ap, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
  						where ap.also_purchased_id=p.products_id
						and ap.also_purchased_id = pd.products_id
  						and ap.origin_products_id='".(int)$_GET['products_id']."'
  						and p.products_status=1
						and pd.language_id = " . $_SESSION ['languages_id']."
  						group by p.products_id
                     	order by p.products_date_added desc
                     	limit " . MAX_DISPLAY_ALSO_PURCHASED );

	if ($also_purchased_products->RecordCount () > 0) {
	
		while ( ! $also_purchased_products->EOF ) {
			$product_id = $also_purchased_products->fields ['products_id'];
			$also_purchased_products->fields ['products_quantity'] = zen_get_products_stock($product_id);
//			if($also_purchased_products->fields ['products_quantity']<=0){
//			    $also_purchased_products->MoveNext();
//			    continue;
//			}
			$product_quantity = $also_purchased_products->fields ['products_quantity'];
			$product_image = $also_purchased_products->fields ['products_image'];
			$product_name = $also_purchased_products->fields ['products_name'];
			$product_min_order = $also_purchased_products->fields ['products_quantity_order_min'];
			$product_max_order = $also_purchased_products->fields ['products_quantity_order_max'];

//			if (isset ( $customer_basket_products [$product_id] )) {
//				$procuct_qty = $customer_basket_products [$product_id];
//				$bool_in_cart = 1;
//			} else {
				$procuct_qty = 0;
				$bool_in_cart = 0;
//			}

			$also_purchased_products_content[$disp_sum]['img'] = '<a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '" class="dlgallery-img"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 130, 130) . '" alt="' . htmlspecialchars(zen_clean_html($product_name)) . '"/></a>';
			$also_purchased_products_content[$disp_sum]['price'] = zen_get_products_display_price_new($product_id, 'matching');
			$also_purchased_products_content[$disp_sum]['button'] = '<div class="cartcont">';
			if ($product_quantity > 0) {
				$also_purchased_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" maxlength="5" orig_value="'.($bool_in_cart ? $procuct_qty : 1).'" type="text" id="pid_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="'. ($bool_in_cart ? 'updatecart' : 'addcart') .'" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '">' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '</a>';
			} else {
				$also_purchased_products_content[$disp_sum]['button'] .= '<a href="javascript:void(0);" class="restock_notification">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
				$also_purchased_products_content[$disp_sum]['button'] .= '<a class="soldtext" title="' . TEXT_SOLD_OUT . '" href="javascript:void(0);"></a>';
			}
			$also_purchased_products_content[$disp_sum]['button'] .= '<a class="text addwishilist-btn addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" href="javascript:void(0);">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a><input type="hidden" class="product_id" value="' . $product_id . '">';
			$also_purchased_products_content[$disp_sum]['button'] .= '</div>';
			$disp_sum++;
			$also_purchased_products->MoveNext ();
		}
	}
}
$smarty->assign('disp_num_also_purchased' , $disp_sum);
$smarty->assign('also_purchased_products_content', $also_purchased_products_content);
?>
