<?php
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
$also_like_products_content = '';
$disp_sum = 0;
if (isset ( $_GET ['products_id'] )) {
	/* $products_title = $db->Execute ( "select products_name_without_catg
									  from " . TABLE_PRODUCTS_DESCRIPTION . "
									 Where products_id = " . ( int ) $_GET ['products_id'] . " and language_id = " . $_SESSION['languages_id'] ); */
	$products_title = $db->Execute("select distinct tag_id from " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " where products_id = " .(int)$_GET ['products_id'] . " limit 1");
	if ($products_title->RecordCount () == 1) {

		$also_like_products = $db->Execute ( "Select distinct p.products_id, p.products_image, pd.products_name, p.products_price,
											p.products_model, p.products_weight, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
													     From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " pr, " . TABLE_PRODUCTS_DESCRIPTION . " pd
													     Where pr.tag_id = '" . zen_db_input ( $products_title->fields ['tag_id'] ) . "'
													      And p.products_id = pd.products_id
														  and p.products_id = pr.products_id
													      And p.products_id != " . ( int ) $_GET ['products_id'] . "
													      And p.products_status = 1
														  and pd.language_id = " . $_SESSION ['languages_id'] . " order by pr.created desc , products_id desc limit 40" ) ;
		

		if ($also_like_products->RecordCount () > 0) {
			
			while ( ! $also_like_products->EOF ) {
				$product_id = $also_like_products->fields ['products_id'];
				$also_like_products->fields ['products_quantity'] = zen_get_products_stock($product_id);
				$product_quantity = $also_like_products->fields ['products_quantity'];
				$product_image = $also_like_products->fields ['products_image'];
				$product_name = $also_like_products->fields ['products_name'];
				$product_min_order = $also_like_products->fields ['products_quantity_order_min'];
				$product_max_order = $also_like_products->fields ['products_quantity_order_max'];

				/* if (isset ( $customer_basket_products [$product_id] )) {
					$procuct_qty = $customer_basket_products [$product_id];
					$bool_in_cart = 1;
				} else { */
					$procuct_qty = 1;
					$bool_in_cart = 0;
				//}

				$also_like_products_content[$disp_sum]['img'] = '<a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '" class="dlgallery-img lazy"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 130, 130) . '" alt="' . htmlspecialchars(zen_clean_html($product_name)) . '"/></a>';
				$also_like_products_content[$disp_sum]['price'] = zen_get_products_display_price_new($product_id, 'matching');
				$also_like_products_content[$disp_sum]['button'] = '<div class="cartcont">';
				if ($product_quantity > 0) {
					$also_like_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" maxlength="5" orig_value="'.($bool_in_cart ? $procuct_qty : 1).'" type="text" id="pid_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="'. ($bool_in_cart ? 'updatecart' : 'addcart') .'" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '">' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '</a>';
				} else {
					$also_like_products_content[$disp_sum]['button'] .= '<a href="javascript:void(0);" class="restock_notification">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$also_like_products_content[$disp_sum]['button'] .= '<a class="soldtext" title="' . TEXT_SOLD_OUT . '" href="javascript:void(0);"></a>';
				}
				$also_like_products_content[$disp_sum]['button'] .= '<a class="text addwishilist-btn addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" href="javascript:void(0);">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a><input type="hidden" class="product_id" value="' . $product_id . '">';
				$also_like_products_content[$disp_sum]['button'] .= '</div>';
				$disp_sum++;
				$also_like_products->MoveNext ();
			}
		}
	}
}
$smarty->assign('disp_num_also_like' , $disp_sum);
$smarty->assign('also_like_products_content', $also_like_products_content);
?>
