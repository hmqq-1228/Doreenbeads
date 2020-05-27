<?php
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
$matching_products_content = '';
$disp_sum = 0;
if (isset ( $_GET ['products_id'] )) {
	$main_products_id = trim ( $_GET ['products_id'] );
	//$match_model = $db->Execute ( "select match_prod_list, products_model from " . TABLE_PRODUCTS . " where products_id = " . ( int ) $main_products_id );
	$match_products_query = $db->Execute ( "select zpm.match_products_id from ".TABLE_PRODUCTS_MATCH_PROD_LIST . " zpm inner join " . TABLE_PRODUCTS . " zp on zpm.match_products_id = zp.products_id where zpm.products_id = ".(int)$main_products_id . " and zp.products_status != 10");
	//$main_products_model = $match_model->fields ['products_model'];
	if ($match_products_query->RecordCount () > 0) {
		$page_name = "product_listing";
		$page_type = 0;
		//$match_model_str = $match_products_query->fields ['match_prod_list'];
		//if (zen_not_null ( $match_model_str )) {
			//$match_model_array = explode ( ',', $match_model_str );

			//$sql_match_query = '';
			//$customer_basket_products = zen_get_customer_basket ();
			/* for($i = 0; $i < sizeof ( $match_model_array ); $i ++) {
				$sql_match_query .= '\'' . $match_model_array [$i] . '\',';
			} */
			//$sql_match_query = substr ( $sql_match_query, 0, - 1 );
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
			
			$match_products = $db->Execute ( "select distinct p.products_id, p.products_image, pd.products_name, p.products_price,
											p.products_model, p.products_weight, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
											from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
											where p.products_id in (" . $sql_match_query . ")
											and p.products_id = pd.products_id
											and p.products_id <> '" . $main_products_id . "'
											and products_type = 1
											And p.products_status = 1
											and pd.language_id = " . $_SESSION ['languages_id']."
											order by p.products_model" );
			while ( ! $match_products->EOF ) {
				$product_id = $match_products->fields ['products_id'];
				$match_products->fields ['products_quantity'] = zen_get_products_stock($product_id);
				$product_quantity = $match_products->fields ['products_quantity'];
				$product_image = $match_products->fields ['products_image'];
				$product_name = $match_products->fields ['products_name'];
				$product_min_order = $match_products->fields ['products_quantity_order_min'];
				$product_max_order = $match_products->fields ['products_quantity_order_max'];

//				if (isset ( $customer_basket_products [$product_id] )) {
//					$procuct_qty = $customer_basket_products [$product_id];
//					$bool_in_cart = 1;
//				} else {
					$procuct_qty = 0;
					$bool_in_cart = 0;
//				}

				$matching_products_content[$disp_sum]['img'] = '<a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '" class="dlgallery-img lazy"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 130, 130) . '" alt="' . htmlspecialchars(zen_clean_html($product_name)) . '"/></a>';
				$matching_products_content[$disp_sum]['price'] = zen_get_products_display_price_new($product_id, 'matching');
				$matching_products_content[$disp_sum]['button'] = '<div class="cartcont">';
				if ($product_quantity > 0) {
					$matching_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="'.($bool_in_cart ? $procuct_qty : 1).'" id="pid_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="'. ($bool_in_cart ? 'updatecart' : 'addcart') .'" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '">' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '</a>';
				} else {
					$matching_products_content[$disp_sum]['button'] .= '<a href="javascript:void(0);" class="restock_notification">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$matching_products_content[$disp_sum]['button'] .= '<a class="soldtext" title="' . TEXT_SOLD_OUT . '" href="javascript:void(0);"></a>';
				}
				$matching_products_content[$disp_sum]['button'] .= '<a class="text addwishilist-btn addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" href="javascript:void(0);">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a><input type="hidden" class="product_id" value="' . $product_id . '">';
				$matching_products_content[$disp_sum]['button'] .= '</div>';
				$disp_sum++;
				$match_products->MoveNext ();
			}
		//}
	}
}
$smarty->assign('disp_num_best_match' , $disp_sum);
$smarty->assign('matching_products_content', $matching_products_content);
?>
