<?php
require ('includes/application_top.php');
set_time_limit ( 600 );
$action = zen_db_prepare_input ( $_POST ['action'] );
$order_id = zen_db_prepare_input ( $_POST ['order_id'] );
switch ($action) {
	case 'web':		
		$page = $_POST ['page'] > 0 ? $_POST ['page'] : 1;
		$_GET['page'] = $page;

		$order_query = "select orders_status
		                        from " . TABLE_ORDERS . "
		                        where orders_id = '" . $order_id . "' limit 1";
		$orders_status = $db->Execute ( $order_query );
		$order_status = $orders_status->fields ['orders_status'];

		$orders_products_query = "select orders_products_id, products_id, products_name,
		                                 products_model, products_price, products_tax,
		                                 products_quantity, final_price,
		                                 onetime_charges,
		                                 products_priced_by_attribute, product_is_free, products_discount_type,
		                                 products_discount_type_from
		                                  from " . TABLE_ORDERS_PRODUCTS . "
		                                  where orders_id = '" . $order_id . "'
		                                  order by orders_products_id";
		$order_products_review_split = new splitPageResults($orders_products_query, 100);
		$order_products_review_split_str = $order_products_review_split->display_links_for_review(100);
		$orders_products = $db->Execute($order_products_review_split->sql_query);
		$index = 0;
		while (!$orders_products->EOF) {
			$products[$index] = array('qty' => $orders_products->fields['products_quantity'],
					'id' => $orders_products->fields['products_id'],
					'name' => $orders_products->fields['products_name'],
					'model' => $orders_products->fields['products_model'],
					'tax' => $orders_products->fields['products_tax'],
					'price' => $orders_products->fields['products_price'],
					'final_price' => $orders_products->fields['final_price'],
					'onetime_charges' => $orders_products->fields['onetime_charges'],
					'products_priced_by_attribute' => $orders_products->fields['products_priced_by_attribute'],
					'product_is_free' => $orders_products->fields['product_is_free'],
					'products_discount_type' => $orders_products->fields['products_discount_type'],
					'products_discount_type_from' => $orders_products->fields['products_discount_type_from']);
			$index++;
			$orders_products->MoveNext();
		}
		$orders_array = array ();
		$size = sizeof($products);
		for($i = 0; $i < $size; $i++) {
			$image = $db->Execute ( "select products_id,products_image,products_weight,products_price,products_volume_weight,products_discount_type,products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = " . $products [$i] ['id'] );
			$productsPriceEach = $currencies->display_price ( $products [$i] ['final_price'], zen_get_tax_rate ( $products [$i] ['tax'] ), 1 );
			$original_price = $image->fields ['products_price'];
			if ($image->fields ['products_priced_by_attribute'] == '1' and zen_has_product_attributes ( $image->fields ['products_id'], 'false' )) {
			} else {
				if ($image->fields ['products_discount_type'] != '0') {
					$original_price = zen_get_products_discount_price_qty ( $image->fields ['products_id'], $products [$i] ['qty'], 0, false );
				}
			}

			$productsPriceOriginal = $currencies->display_price ( $original_price, zen_get_tax_rate ( $products [$i] ['tax'] ), 1 );
			$productsShowPrice = $productsPriceEach;
			$product_each_price = $currencies->format_cl ( zen_add_tax ( $products [$i] ['final_price'], zen_get_tax_rate ( $products [$i] ['tax'] ) ), true, $order->info ['currency'], $order->info ['currency_value'] );

			$products_link = zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $products [$i] ['id'] );
			$orders_array [$i] = array (
					'products_name' => '<a href="' . $products_link . '" target="_blank">' . $products [$i] ["name"] . '</a>',
					'products_id' => $products [$i] ['id'],
					'products_qty' => $products [$i] ['qty'],
					'products_link' => $products_link,
					'products_qty_text' => $products [$i] ['qty'] . ' ' . zen_get_words ( 'text_packet', $products [$i] ['qty'], $_SESSION ['languages_id'] ),
					'products_img' => '<a class="orderimg" href="' . $products_link . '" target="_blank"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $image->fields ['products_image'], 80, 80 ) . '"/></a>',
					'products_model' => $products [$i] ['model'],
					'products_weight' => $image->fields ['products_weight'],
					'products_volume_weight' => $image->fields ['products_volume_weight'],
					'products_price' => $currencies->format ( zen_add_tax ( $products [$i] ['final_price'], $products [$i] ['tax'] ), true, $order->info ['currency'], $order->info ['currency_value'] ),
					'products_price_total' => $currencies->format ( zen_add_tax ( $product_each_price, $products [$i] ['tax'] ) * $products [$i] ['qty'], false, $order->info ['currency'], $order->info ['currency_value'] )
			);
		}

		$return_str = '';
		for ($i = 0; $i < sizeof($orders_array); $i++){
			$hideTheTrClass = $i >= 3 ? ' class="hideTheTr"' : '';
			$return_str .= '<tr' . $hideTheTrClass . '>
		            <td width="105">' . ($i+1) . '.' . $orders_array[$i]['products_img'] . '</td>
		            <td width="60">' . $orders_array[$i]['products_model'] . '</td>
		            <td width="100" class="volweightwap">' . $orders_array[$i]['products_weight'] . 'g</td>
		            <td width="230" style="text-align:left;">' . $orders_array[$i]['products_name'] . '</td>
		            <td width="95">' . $orders_array[$i]['products_price'] . '</td>
		            <td width="80">' . $orders_array[$i]['products_qty'] . ' ' . ($orders_array[$i]['products_qty'] > 1 ? 'packs' : 'pack') . '</td>
		            <td width="95"><span class="font_red">' . $orders_array[$i]['products_price_total'] . '</span></td>
		            <td width="100">
		            	<a href="javascript:void(0);" class="order_detail_addcart">Add to Cart</a>
		            	<input type="hidden" name="product_id" value="' . $orders_array[$i]['products_id'] . '">
			            <input type="hidden" name="product_qty" value="' . $orders_array[$i]['products_qty'] . '">
		            	<div class="successtips_collect" style="left:-32px;top:-58px;">
		            		<span class="bot"></span>
		            		<span class="top"></span>
		            		Add to cart successfully!<br/>
		            		<a href="index.php?main_page=shopping_cart" style="padding-right: 0px;">View Cart</a> / <a href="javascript:void(0);" class="successtips_collect_close">Close</a>
		            	</div>
		            	' . (($order_status == 2 or $order_status == 3 or $order_status == 4  or $order_status == 10) ? '<br/><a href="downloads.php?product_id=' . $orders_array[$i]['products_id'] . '">Download Pic</a>' : '') . '
		            </td>
		          </tr>';
		}
		$return_str .= '<tr><td colspan="8" class="more"><a href="javascript:void(0);" class="close1"></a></td></tr>';
		$return_str .= '<tr><td colspan="8"><div class="propagelist">' . $order_products_review_split_str . '</div></td></tr>';
		echo $return_str;
		break;
	
	case 'mobile':
		require (DIR_WS_LANGUAGES . 'mobilesite/' . $_SESSION ['language'] . '/account_history_info.php');
		
		$page =zen_db_prepare_input ( $_POST ['nextPage'] ) > 0 ? zen_db_prepare_input ( $_POST ['nextPage'] ) : 1;
		$_GET['page'] = $page;

		$page_size = 20;
		$orders_products_query = "select orders_products_id, products_id, products_name,
		                                 products_model, products_price, products_tax,
		                                 products_quantity, final_price,
		                                 onetime_charges,
		                                 products_priced_by_attribute, product_is_free, products_discount_type,note,
		                                 products_discount_type_from
		                                  from " . TABLE_ORDERS_PRODUCTS . "
		                                  where orders_id = '" . $order_id . "'
		                                  order by products_model";
		$history_split = new splitPageResults ( $orders_products_query, $page_size, 'products_id', 'page' );
		$orders_products = $db->Execute ( $history_split->sql_query );

		$cart_fen_ye = '<div class="cart_split_page page">' . $history_split->display_links_mobile_for_shoppingcart ( 20, '', true ) . '</div>';


		$i = 0;
		$return_array = array();
		$return_html = '';
		while ( ! $orders_products->EOF ) {
			//$product_info = $db->Execute ( "select products_image, products_discount_type, products_weight, products_volume_weight from " . TABLE_PRODUCTS . " where products_id = " . $orders_products->fields ['products_id'] );
			$product_info = get_products_info_memcache($orders_products->fields ['products_id']);
			$productsName = getstrbylength ( strip_tags($orders_products->fields ['products_name']), PRODUCT_NAME_MAX_LENGTH );
			$productsImage = '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $product_info ['products_image'], 130, 130 ) . '" width="110" height="110"/>';
			$product_quantity = $orders_products->fields ['products_quantity'];
			$productsPriceEach = $currencies->display_price ( $orders_products->fields ['final_price'] );
			$productsPrice = $currencies->format ( $currencies->format_cl ( $orders_products->fields ['final_price'] ) * $product_quantity, false );
			if ($product_info ['products_discount_type'] != '0') {
				$productsPriceEachOriginal = zen_get_products_discount_price_qty ( $product_info ['products_id'], $product_quantity, 0, false );
			} else {
				$productsPriceEachOriginal = $productsPrice;
			}
			$discount_amount = zen_show_discount_amount($product_info['id']);
		    $discount_amount_html = $discount_amount ? '<span class="cart_discount">'. $discount_amount .'% '. TEXT_OFF .'</span>' : '';
			$products_model = $orders_products->fields ['products_model'];
			$productsVolumetricWeight = $product_info ['products_volume_weight'] <= $product_info ['products_weight'] ? '' : TEXT_VOLUMETRIC_WEIGHT . $product_info ['products_volume_weight'] . TEXT_GRAM_WORD;
			$productsShowPrice = ($productsPriceEach == $productsPriceEachOriginal) ? $productsPriceEach : ('<del>' . $productsPriceEachOriginal . '</del>' . $productsPriceEach);
			$products_link = zen_href_link ( 'product_info', 'products_id=' . $orders_products->fields ['products_id'] );
			$product_info['product_quantity'] = zen_get_products_stock($orders_products->fields ['products_id']);
			$is_preorder = $product_info['product_quantity'] == 0 ? '<p class="avalaible">'.($product_info['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</p>' : '' ;

			$return_html .= '<li>
								<p class="cartpro_name"><a href="'.$products_link.'">' . $productsName . '['. $products_model .']</a></p>
								<div class="pro_img"><a href="'.$products_link.'">'. $productsImage . $discount_amount_html .'</a></div>
								<div class="pro_price">
					                <p>
					                	<span>'.TEXT_PRICE_WORDS.': </span>
					                	'.($productsPriceEachOriginal != $productsPriceEach ? '<del>' . $productsPriceEachOriginal . '</del><br />' : '') . $productsPriceEach .'
					                </p>
					                <p><span>'. TABLE_HEADING_QUANTITY .': </span> <span>'. $product_quantity . TEXT_PACKET_2 .'</span> </p>
					                <p><span>'. TEXT_ORDER_INFO_SUBTOTAL .': </span>'. $productsPrice .'</p></div>
				              	<div class="clearfix"></div>
				              	'. $is_preorder .'</li>';
			$i ++;
			$orders_products->MoveNext ();
		}

		$return_array['return_html'] = $return_html;
		$return_array['return_fenye'] = $cart_fen_ye;
		echo json_encode($return_array);
		exit;
		break;
	default:
		# code...
		break;
}

?>