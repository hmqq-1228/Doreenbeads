<?php
/**
 * product_listing module
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_listing.php 4655 2006-10-02 01:02:38Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING For Zen Cart v1.3.6 - 10/25/2006
 */
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}
if ($_GET['main_page'] == "advanced_search_result") {
	include_once('advanced_search_listing.php');
} else {
	$number_of_products_per_page = isset($_SESSION['per_page']) ? $_SESSION['per_page'] : 48;
	$listing_split = new splitPageResults($listing_sql, $number_of_products_per_page, 'p.products_id', 'page');
	$list_box_contents = array();
	if ($listing_split->number_of_rows > 0) {
		$listing = $db->Execute($listing_split->sql_query);
		while (!$listing->EOF) {
			// add by zale
			$page_name = "product_listing";
			$page_type = 4;
//			if($_SESSION['cart']->in_cart($listing->fields['products_id'])){		//if item already in cart
//				$procuct_qty = $_SESSION['cart']->get_quantity($listing->fields['products_id']);
//				$bool_in_cart = 1;
//			}else {
				$procuct_qty = 0;
				$bool_in_cart = 0;
//			}
			//eof
			/*$listing_sql 在这组合WSL*/
			$listing->fields = get_products_info_memcache($listing->fields['products_id']);
            $listing->fields['products_quantity'] = zen_get_products_stock($listing->fields['products_id']);
            $listing->fields['products_name'] = get_products_description_memcache($listing->fields['products_id'],$_SESSION ['languages_id']);
                       
			$link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']);
			$pro_array['maximage'] = '<div class="maximg notLoadNow" style="display: none;"><s></s><span></span><img /></div>';
			$discount_amount = zen_show_discount_amount($listing->fields['products_id']);
			$pro_array['image'] = $discount_amount!='' && $discount_amount>0 ? draw_discount_img($discount_amount,'span') : '';
			$pro_array['image'] .= '<a class="proimg" href="'.$link.'"><img src="includes/templates/cherry_zen/images/loading2.gif" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($listing->fields['products_image'], 130, 130) . '" class="lazy" id="anchor' . $listing->fields['products_id'] . '"></a>';
			$pro_array['name'] = '<h4><a href="'.$link.'">'.$listing->fields['products_name'].' ['.$listing->fields['products_model'].']</a></h4>';
			$pro_array['model'] = '<p>' . TEXT_MODEL . ': ' . $listing->fields['products_model'].'</p>';
			$disp_pric = zen_display_products_quantity_discounts_new($listing->fields['products_id'], 'product_listing');
			$pro_array['price'] = $disp_pric != '' ? $disp_pric : zen_get_products_display_price($listing->fields['products_id']);

			//	add cart button
			if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
				$lc_button = '<a href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
			} else {
				if($listing->fields['products_quantity'] > 0){
					$lc_button = '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
					$lc_button .= '<input class="qty addcart_qty_input 3" maxlength="5" type="number" id="' . $page_name  .'_' . $listing->fields['products_id'] . '" name="products_id[' . $listing->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" orig_value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" /><input type="hidden" id="MDO_' . $listing->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $listing->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />';

               $min_units = zen_get_products_quantity_min_units_display($listing->fields['products_id']);
               $lc_button .= '<div class="clearfix"></div>'.($min_units ? '<p>'.$min_units.'</p>' : '') . ($listing->fields['products_limit_stock'] == 1 ? ( '<p>'.sprintf(TEXT_STOCK_HAVE_LIMIT,$listing->fields['products_quantity'])).'</p>' : '');

					$lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
					$lc_button .= '<a class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" href="javascript:void(0);" id="submitp_' . $listing->fields['products_id'] . '" name="submitp_' .  $listing->fields['products_id'] . '" onclick="Addtocart_list('.$listing->fields['products_id'].','.$page_type.',this); return false;">'. ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) .'</a></div>';
				}else{
					$lc_button = '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
					$lc_button .= '<span class="soldout_text"><a id="restock_'.$listing->fields['products_id'].'" onclick="beforeRestockNotification(' . $listing->fields['products_id'] . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$lc_button .= '<input type="hidden" id="MDO_' . $listing->fields['products_id'] . '" value="'.$bool_in_cart.'" />
								   <input type="hidden" id="incart_' . $listing->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />';
					if($listing->fields['is_sold_out']==1)    $lc_button .= '<a class="icon_soldout" href="javascript:void(0);">' . TEXT_SOLD_OUT . '</a>';
                    else{
                        $lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
						$lc_button .= '<a rel="nofollow" class="icon_backorder" id="submitp_' . $listing->fields['products_id'] . '" onclick="makeSureCart('.$listing->fields['products_id'].','.$page_type.',\''.$page_name.'\',\''.get_backorder_info($listing->fields['products_id']).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . '</a></div>';
                    }

				}
			}
			//	add wishlist button
			if ($current_page != FILENAME_ADVANCED_SEARCH_RESULT){
				$lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
				$lc_button .= '<a class="text" href="javascript:void(0);" id="wishlist_' . $listing->fields['products_id'] . '" name="wishlist_' . $listing->fields['products_id'] . '" onclick="beforeAddtowishlist(' . $listing->fields['products_id'] . ','.$page_type.'); return false;">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a></div>';
			}
			$pro_array['cart'] = $lc_button;

			$list_box_contents[] = $pro_array;
			$listing->MoveNext();
		}
	}
}
?>
