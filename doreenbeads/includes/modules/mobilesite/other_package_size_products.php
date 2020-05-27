<?php
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
$other_package_size_products_content = '';
$disp_sum = 0;

if (isset ( $_GET ['products_id'] )) {
	$pid = $_GET ['products_id'];
	$other_package_products_array = get_products_package_id_by_products_id($pid);
	
	$main_products_info = get_products_info_memcache($pid);
	$last_word_main_products_info = substr($main_products_info['products_model'],- 1 );
	if ($last_word_main_products_info == 'S') {
		$main_products_title = TEXT_PRODUCTS_IN_SMALL_PACK;
		$other_package_products_title = TEXT_PRODUCTS_IN_REGULAR_PACK;
	}else{
		$main_products_title = TEXT_PRODUCTS_IN_REGULAR_PACK;
		$other_package_products_title = TEXT_PRODUCTS_IN_SMALL_PACK;
	}

	if (sizeof($other_package_products_array) > 0) {

		
		foreach($other_package_products_array as $key=>$value){

				$other_products_info = get_products_info_memcache($value);
				$other_products_info['products_name'] = get_products_description_memcache($value);
				$other_products_info['products_quantity'] = zen_get_products_stock($value);

				$product_id = $value;
				//var_dump($product_id);
				$product_quantity = $other_products_info['products_quantity'];
				//var_dump($product_quantity);
				$product_image = $other_products_info['products_image'];
				//var_dump($product_image);
				$product_name = $other_products_info['products_name'];
				//var_dump($product_name);
				$procuct_qty = 1;
				$bool_in_cart = 0;
	
				$other_package_size_products_content[$disp_sum]['img'] = '<a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '" class="dlgallery-img lazy"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 130, 130) . '" alt="' . htmlspecialchars(zen_clean_html($product_name)) . '"/></a>';
				$other_package_size_products_content[$disp_sum]['price'] = zen_get_products_display_price_new($product_id, 'matching');
				$other_package_size_products_content[$disp_sum]['button'] = '<div class="cartcont">';
				if ($product_quantity > 0) {
					$other_package_size_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="'.($bool_in_cart ? $procuct_qty : 1).'" id="pid_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="'. ($bool_in_cart ? 'updatecart' : 'addcart') .'" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '">' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '</a>';
				} else {

					$other_package_size_products_content[$disp_sum]['button'] .= '<a class="soldtext" title="' . TEXT_SOLD_OUT . '" href="javascript:void(0);"></a>';
				}
				$other_package_size_products_content[$disp_sum]['button'] .= '<a class="text addwishilist-btn addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" href="javascript:void(0);">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a><input type="hidden" class="product_id" value="' . $product_id . '">';
				$other_package_size_products_content[$disp_sum]['button'] .= '</div>';
				$disp_sum++;
			
		}
	}
}

$smarty->assign('disp_num_other_package_size' , $disp_sum);
$smarty->assign('other_package_size_products_content', $other_package_size_products_content);
$smarty->assign('other_package_products_title',$other_package_products_title);
?>

