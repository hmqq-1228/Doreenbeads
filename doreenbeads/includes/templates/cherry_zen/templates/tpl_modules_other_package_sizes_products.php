<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}
$page_name = "product_listing";
$page_type = 4;

$other_size_product_id_result = get_products_package_id_by_products_id($_GET['products_id']);
$products_num = sizeof($other_size_product_id_result);

$main_products_info = get_products_info_memcache($_GET['products_id']);
$last_word_main_products_info = substr($main_products_info['products_model'],- 1 );
if ($last_word_main_products_info == 'S') {
	$main_products_title = TEXT_PRODUCTS_IN_SMALL_PACK;
	$other_package_products_title = TEXT_PRODUCTS_IN_REGULAR_PACK;
}else{
	$main_products_title = TEXT_PRODUCTS_IN_REGULAR_PACK;
	$other_package_products_title = TEXT_PRODUCTS_IN_SMALL_PACK;
}
if ($products_num > 0) {
	//$is_products_listing=true;
	//$rows = 0;
	//$column = 0;
	//$customer_basket_products = zen_get_customer_basket();

	foreach($other_size_product_id_result as $prod_val){
		//$products_id = $prod_val->products_id;
		$products_id = $prod_val;

		$listing = new stdClass();
		$products_info = get_products_info_memcache($products_id);
		$products_info['products_name'] = get_products_description_memcache($products_id,(int)$_SESSION['languages_id']) ;
		$listing->fields = $products_info;
		if (sizeof($listing->fields) == 0) {
			continue;
		}
		$listing->fields['products_quantity'] = zen_get_products_stock($products_id);
		/*always be 1 0*/
		$procuct_qty = 1;
		$bool_in_cart = 0;

		$link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']);
		$unit_price = '';
		/* if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB'){
			$unit_price = '<span class="unit_price_list">'.zen_get_unit_price($products_id).'</span>';
		} */		
		$pro_array = array();
		$pro_array['maximage'] = '<div class="maximg notLoadNow" style="display: none;"><s></s><span></span><img /></div>';
		$discount_amount = zen_show_discount_amount($products_id);
		$pro_array['image'] = ($discount_amount!='' && $discount_amount>0) ? draw_discount_img($discount_amount,'span') : '';
		$pro_array['image'] .= '<a class="proimg" href="'.$link.'"><img src="includes/templates/cherry_zen/images/loading2.gif" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($listing->fields['products_image'], 130, 130) . '" class="lazy" id="anchor' . $listing->fields['products_id'] . '"></a>';
		$pro_array['name'] = '<h4><a href="'.$link.'">'.$listing->fields['products_name'].' ['.$listing->fields['products_model'].']</a></h4>';
		
		$product_number_unit = get_product_unit_memcache($products_info['products_id']);
		$product_number_unit_string = $product_number_unit['unit_number'] . $product_number_unit['unit_name'] . '/' . TEXT_PACK_FOR_OTHER_PACKAGE;

		$pro_array['model'] = '<p>' . TEXT_MODEL . ': ' . $listing->fields['products_model'].'<span>'.$product_number_unit_string.'</span></p>';
		$disp_pric = $unit_price.zen_display_products_quantity_discounts_new($listing->fields['products_id'], 'product_listing');		
		$pro_array['price'] = $disp_pric != '' ? $disp_pric : zen_get_products_display_price($listing->fields['products_id']);

		//	add cart button
		if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
			$lc_button = '<a rel="nofollow" href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
		} else { 
			if(empty($listing->fields['products_status'])) {
				$lc_button = '<p class="addwishlist"><div style="background: none repeat scroll 0% 0% rgb(232, 232, 232); width: 75%; margin:  80px auto; border: 1px solid rgb(211, 211, 211); height: 28px; line-height: 28px;  border-radius: 5px; text-align: center;">' . TEXT_REMOVED . '</div></p>';
			} else {
				if($listing->fields['products_quantity'] > 0){
					$lc_button = '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
					$lc_button .= '<input class="qty addcart_qty_input" min="1" max="99999" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" type="number" id="' . $page_name  .'_' . $listing->fields['products_id'] . '" name="products_id[' . $listing->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" orig_value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" /><input type="hidden" id="MDO_' . $listing->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $listing->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />';
					$min_units = zen_get_products_quantity_min_units_display($listing->fields['products_id']);
					$lc_button .= '<div class="clearfix"></div>'.($min_units ? '<p>'.$min_units.'</p>' : '') . ($listing->fields['products_limit_stock'] == 1 ? ( '<p>'.sprintf(TEXT_STOCK_HAVE_LIMIT,$listing->fields['products_quantity'])).'</p>' : '');
					$lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
					$lc_button .= '<a rel="nofollow" class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" href="javascript:void(0);" id="submitp_' . $listing->fields['products_id'] . '" name="submitp_' .  $listing->fields['products_id'] . '" onclick="Addtocart_list('.$listing->fields['products_id'].','.$page_type.',this); return false;">'. ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) .'</a></div>';
				}else{
					$lc_button = '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
						
					$lc_button .= '<span class="soldout_text"><a rel="nofollow" id="restock_'.$listing->fields['products_id'].'" onclick="beforeRestockNotification(' . $listing->fields['products_id'] . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$lc_button .= '<input type="hidden" id="MDO_' . $listing->fields['products_id'] . '" value="'.$bool_in_cart.'" />
								   <input type="hidden" id="incart_' . $listing->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />';
					if($listing->fields['is_sold_out'] == 1){
						$lc_button .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">' . TEXT_SOLD_OUT . '</a>';
					}else{
						$lc_button .= '<input class="qty addcart_qty_input" min="1" max="99999" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" type="number" id="' . $page_name  .'_' . $listing->fields['products_id'] . '" name="products_id[' . $listing->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" orig_value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" />';
						$lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
						$lc_button .= '<a rel="nofollow" class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" href="javascript:void(0);" id="submitp_' . $listing->fields['products_id'] . '" name="submitp_' .  $listing->fields['products_id'] . '" onclick="Addtocart_list('.$listing->fields['products_id'].','.$page_type.',this); return false;">'. ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_BACKORDER) .'</a></div>';
						$backtips = '<span style="color:#999;float:right;position:relative;text-align:right;line-height:12px;">'.($listing->fields['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</span>';
						//$lc_button .= '<a rel="nofollow" class="icon_backorder" id="submitp_' . $listing->fields['products_id'] . '" onclick="makeSureCart('.$listing->fields['products_id'].','.$page_type.',\''.$page_name.'\',\''.get_backorder_info($listing->fields['products_id']).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . '</a></div>';
					}
				}
				//	add wishlist button
				if ($current_page != FILENAME_ADVANCED_SEARCH_RESULT){
					$lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
					$lc_button .= '<a rel="nofollow" class="text" href="javascript:void(0);" id="wishlist_' . $listing->fields['products_id'] . '" name="wishlist_' . $listing->fields['products_id'] . '" onclick="beforeAddtowishlist(' . $listing->fields['products_id'] . ','.$page_type.'); return false;">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a></div>';
				}
			}
				
		}
		$pro_array['cart'] = $lc_button.$backtips;
		$backtips = '';

		$list_box_contents_property[] = $pro_array;
		//$listing->MoveNext();
	}
	//$error_categories = false;
}
	if($products_num > 0){
		echo '<div class="detailcont">';
			echo '<p id="other_package_size_products" class="detailconttit"><strong>'.$other_package_products_title.'</strong></p>';			
			echo '<div class="product_list">';
				echo '<ul class="list">';
				foreach($list_box_contents_property as $key => $value){
					echo '<li>';
					echo $value['maximage'];
					echo $value['image'];
					echo '<div class="product_info">';
					echo $value['name'];
					echo $value['price'];
					echo $value['model'];
					echo '</div><div class="product_btn">';
					echo $value['cart'];
					echo '</div><div class="clearfix"></div></li>';
				}
				echo '</ul>' ;
			echo '</div>';
		echo '</div>';	
	}	
?>

