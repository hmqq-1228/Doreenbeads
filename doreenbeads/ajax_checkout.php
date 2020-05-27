<?php
if (isset ( $_POST['action'] )) {
	require ('includes/application_top.php');
	global $db;
	require 'includes/languages/mobilesite/' . $_SESSION['language'] . '/play_order.php';
	switch ($_POST['action']) {
		case 'choose_address' :
			$return_array = array('error'=>false);
			if (isset ( $_POST['aId'] ) && ( int ) $_POST['aId'] > 0 && isset ( $_SESSION['customer_id'] ) && $_SESSION['customer_id'] != 0) {
				check_remote_area_byID ( $_POST['aId'] );
				$_SESSION['sendto'] = $_POST['aId'];
				//unset ( $_SESSION['shipping'] );
			}else{
				$return_array['error'] = true;
			}
			echo json_encode($return_array);
			break;
		case 'choose_shipping' :
			$return_array = array('error'=>false, 'data'=>array('package_box_weight'=>'', 'shipping_weight'=>''));
			unset ( $_SESSION['dhl_rm'] );
			unset ( $_SESSION['hmdpd_rm'] );
			unset ( $_SESSION['fedex_rm'] );
			unset ( $_SESSION['kdups_rm'] );
			//unset ( $_SESSION['shipping'] );
			$code = $_POST['code'];
			$_SESSION['estimate_method'] = $code;
			
			require (DIR_WS_CLASSES . 'order.php');
			require(DIR_WS_CLASSES . 'shipping.php');
			$order = new order ();
			
			$db->Execute("update " . TABLE_CUSTOMERS . " set customers_default_shipping = '" . $code . "_" . $code . "' where customers_id  = ".$_SESSION['customer_id']." ");
			$_SESSION['customers_default_shipping'] = $code . "_" . $code;
			
			$countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => 0));
			$shipping_modules = new shipping ('', $country_code, '', $post_postcode, $post_city);
			$shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => 0));
			$shipping_list = $shipping_data['shipping_list'];
			$shipping_info = $shipping_data['shipping_info'];
			$special_discount = $shipping_data['special_discount'];

			if ( sizeof($shipping_list) > 0 ) {
				$return_array = array('error' => 0, 'message' => "", 'show_weight' => $_SESSION['cart']->show_weight(), 'shipping_volume_weight_title' => $shipping_info['shipping_volume_weight_title'], 'shipping_volume_weight' => $shipping_info['shipping_volume_weight'], 'show_volume_weight' => $shipping_info['shipping_volume_weight'] . " " . TEXT_GRAMS, 'show_package_box_weight_str' => $shipping_info['shipping_package_box_weight'] . " " . TEXT_GRAMS, 'shipping_total_weight_str' => $shipping_info['shipping_weight'] . " " . TEXT_GRAMS);
			}else{
				$return_array['error'] = true;
			}
			$order->cart();
			echo json_encode($return_array);
			break;
		case 'split':
			require 'includes/languages/' . $_SESSION['language'] . '/checkout.php';
			$page = zen_db_input($_POST['nextPage']) >= 1 ? zen_db_input($_POST['nextPage']) : 1;
			$page_size = 40;
			
			//$total_num = $_SESSION['cart']->get_products_num();
			//$products = $_SESSION['cart']->get_products(false, $page_size);
			//Tianwen.Wan20160624购物车优化
			$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
			$products = array_slice($products_array['data'], ($page -1) * $page_size, $page_size);
			$total_num = $products_array['count'];

			$return_array = array();
			$return_html = $return_fenye = '';
			for($i=0, $n=sizeof($products); $i<$n; $i++){
				$productsName = getstrbylength ( $products[$i]['name'], 25 );
				$productsImage = '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $products[$i]['image'], 130, 130 ) . '" width="110" height="110"/>';
				$product_quantity = $products[$i]['quantity'];
				$productsPriceEach = $currencies->display_price ( $products[$i]['final_price'], zen_get_tax_rate ( $products[$i]['tax_class_id'] ), 1 );
				$productsPrice = $currencies->format ( $currencies->format_cl ( zen_add_tax ( $products[$i]['final_price'], zen_get_tax_rate ( $products[$i]['tax_class_id'] ) ) ) * $product_quantity, false );
				$productsPriceEachOriginal = $currencies->display_price ( $products[$i]['original_price'], zen_get_tax_rate ( $products[$i]['tax_class_id'] ), 1 );
				$products_model = $products[$i]['model'];
				$productsVolumetricWeight = $products[$i]['volume_weight'] == 0 ? '' : TEXT_VOLUMETRIC_WEIGHT . $products[$i]['volume_weight'] . TEXT_GRAM_WORD;
				//$productsShowPrice = ($productsPriceEach == $productsPriceEachOriginal) ? $productsPriceEach : ('<del>' . $productsPriceEachOriginal . '</del>' . $productsPriceEach);
                $discount_amount = zen_show_discount_amount($products[$i]['id']);
                $discount_amount_html = $discount_amount ? '<span class="cart_discount">'. $discount_amount .'% '. TEXT_OFF .'</span>' : '';
                $is_preorder = $products[$i]['product_quantity']==0 ? '<p class="avalaible">'.($products[$i]['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</p>' : '' ;

				$return_html .= '<li>
									<p class="cartpro_name">' . $productsName . '['. $products_model .']</p>
									<div class="pro_img">'. $productsImage . $discount_amount_html .'</div>
									<div class="pro_price">
						                <p>
						                	<span>'.TEXT_PRICE_WORDS.': </span>
						                	'.($productsPriceEachOriginal != $productsPriceEach ? '<del>' . $productsPriceEachOriginal . '</del><br />' : '') . $productsPriceEach .'
						                </p>
						                <p><span>'. TABLE_HEADING_QUANTITY .': </span> <span>'. $product_quantity . TEXT_PACKET_2 .'</span> </p>
						                <p><span>'. TEXT_ORDER_INFO_SUBTOTAL .': </span>'. $productsPrice .'</p></div>
					              	<div class="clearfix"></div>
					              	'. $is_preorder .'</li>';
			}
			if($total_num > $page_size){
				$_GET['page']=$page;
				$products_split = new splitPageResults ( '', $page_size, '', 'page', false, $total_num );
				$return_fenye = $products_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, '', true );
			}
			//$return_html .= '<div class="itemhide"><span></span></div>';
			$return_array['return_html'] = $return_html;
			$return_array['return_fenye'] = $return_fenye;
			echo json_encode($return_array);
			break;
		case 'usecoupon':
			unset($_SESSION['cc_id']);
			require(DIR_WS_CLASSES . 'order.php');
			$order = new order;
			$order_total = array('totalFull'=>$order->info['subtotal']);
			/* $is_first_coupon = zen_check_first_coupon();
			if($is_first_coupon){
				$coupon_code = 'dorabeads';
			}else{
				$coupon_code = '80214';
			} */
			$is_first_coupon = false;
			$coupon_code = '80214';
			
			$order_total_str = '';
			$sql = "select coupon_id, coupon_amount, coupon_type, coupon_minimum_order, uses_per_coupon, uses_per_user,
						restrict_to_products, restrict_to_categories, coupon_zone_restriction
						from " . TABLE_COUPONS . "
						where coupon_code= :couponCodeEntered
						and coupon_active='Y' and coupon_type != 'G' and coupon_start_date <= now() and coupon_expire_date >= now()";
			$sql = $db->bindVars($sql, ':couponCodeEntered', $coupon_code, 'string');
			$coupon_result=$db->Execute($sql);
			if ($coupon_result->RecordCount() > 0) {
				$coupon_count = $db->Execute("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . "
										where coupon_id = '" . (int)$coupon_result->fields['coupon_id']."'");
				$coupon_count_customer = $db->Execute("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . "
												  where coupon_id = '" . $coupon_result->fields['coupon_id']."' and
												  customer_id = '" . (int)$_SESSION['customer_id'] . "'");
				if ($coupon_count->RecordCount() >= $coupon_result->fields['uses_per_coupon'] && $coupon_result->fields['uses_per_coupon'] > 0) {

				}elseif($coupon_count_customer->RecordCount() >= $coupon_result->fields['uses_per_user'] && $coupon_result->fields['uses_per_user'] > 0){

				}else{
					$_SESSION['cc_id'] = $coupon_result->fields['coupon_id'];				
					$order->cart();
					require(DIR_WS_CLASSES . 'order_total.php');
					$order_total_modules = new order_total;
					$order_total_array = $order_total_modules->process(array('ot_cash_account.php'));
					$order_total_str = zen_get_order_total_str_mobilesite($order_total_array);
				}
			}
			echo $order_total_str;
			break;
		case 'set_coupon':
		case 'unset_coupon':
			$_POST['couponID'] = (int)$_POST['couponID'];
			$_SESSION['coupon_to_customer_id'] = $_POST['couponID'];
			
			$coupon_query = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_id='".$_POST['couponID']."' limit 1");
			$coupon_id = $coupon_query->fields['cc_coupon_id'];
			$_SESSION['coupon_id'] = $coupon_id;
			$_SESSION['use_coupon'] = 'Y';
			if($_POST['couponID'] <= 0){
			    $_SESSION['coupon_id'] = 0;
				$_SESSION['use_coupon'] = 'N';
			}
			$_SESSION['coupon_amount_orders_total'] = $_SESSION['cart']->show_total_new();
			
			echo $_SESSION['coupon_id'];
			break;
		case 'change_shipping':
			$code = $_POST['code'];
			if ($code == 'ywdhl-dh') {
				$code = 'ywdhl';
			}
			if($code != "" && $_SESSION['customer_id'] != 0){
				$db->Execute("update " . TABLE_CUSTOMERS . " set customers_default_shipping = '" . $code . '_' . $code . "' where customers_id  = " . $_SESSION['customer_id']);
				echo 'success';
			}
			break;
		case 'split_order_detail':
			require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/account_history_info.php');
			require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/shopping_cart.php');
			$page = (int)$_POST['page'] >= 1 ? $_POST['page'] : 1;
			$order_id = $_POST['order_id'];

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
			$cart_fen_ye = '<div class="cart_split_page propagelist">' . $history_split->display_links_for_review ( MAX_DISPLAY_PAGE_LINKS ) . '</div>';

			$return_html = '';
			while ( ! $orders_products->EOF ) {
				$product_info = $db->Execute ( "select products_image, products_discount_type, products_weight, products_volume_weight from " . TABLE_PRODUCTS . " where products_id = " . $orders_products->fields['products_id'] );
				$productsName = getstrbylength ( $orders_products->fields['products_name'], PRODUCT_NAME_MAX_LENGTH );
				$productsImage = '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $product_info->fields['products_image'], 130, 130 ) . '" width="143" height="143"/>';
				$product_quantity = $orders_products->fields['products_quantity'];
				$productsPriceEach = $currencies->display_price ( $orders_products->fields['final_price'] );
				$productsPrice = $currencies->format ( $currencies->format_cl ( $orders_products->fields['final_price'] ) * $product_quantity, false );
				if ($product_info->fields['products_discount_type'] != '0') {
					$productsPriceEachOriginal = zen_get_products_discount_price_qty ( $product_info->fields['products_id'], $product_quantity, 0, false );
				}else{
					$productsPriceEachOriginal = $productsPrice;
				}
				$products_model = $orders_products->fields['products_model'];
				$productsVolumetricWeight = $product_info->fields['products_volume_weight'] <= $product_info->fields['products_weight'] ? '' : TEXT_VOLUMETRIC_WEIGHT . $product_info->fields['products_volume_weight'] . TEXT_GRAM_WORD;
				$productsShowPrice = ($productsPriceEach == $productsPriceEachOriginal) ? $productsPriceEach : ('<del>' . $productsPriceEachOriginal . '</del>' . $productsPriceEach);
				$products_link = zen_href_link ( 'product_info', 'products_id=' . $orders_products->fields['products_id'] );

				$return_html .= '<div class="review-box">
									<div class="review">
										<a href="' . $products_link . '">' . $productsImage . '</a>
										<ul>
											<li><span><a href="' . $products_link . '">' . $productsName . ' (' . $products_model . ')</a></span></li>
											<li><span>' . TEXT_CART_P_WEIGHT . '：' . $product_info->fields['products_weight'] . ' ' . TEXT_GRAMS . '</span></li>
											' . ($product_info->fields['products_volume_weight'] > $product_info->fields['products_weight'] ? '<li><span>' . TEXT_CART_P_V_WEIGHT . '：' . $product_info->fields['products_volume_weight'] . ' ' . TEXT_GRAMS . '</span></li>' : '') . '
											<li><span>' . TEXT_CART_UNIT_PRICE . ': ' . $productsPriceEach . '</span></li>
											<li><span>' . TEXT_CART_P_QTY . ': ' . $product_quantity . ' ' . ($product_quantity > 1 ? TEXT_PACKS : TEXT_PACK) . '</span></li>
											<li><span>' . HEADING_TOTAL . ':<span class="pice">' . $productsPrice . '</span></span></li>
										</ul>
									</div>
									<a class="cart-button" href="javascript:void(0);">' . TEXT_CART_ADD_TO_CART . '</a>
									<input type="hidden" name="product_id" value="' . $orders_products->fields['products_id'] . '">
									<input type="hidden" name="product_qty" value="' . $product_quantity . '">
								</div>';

				$i++;
				$orders_products->MoveNext ();
			}

			$return_html .= '<br class="clear"><div class="propagelist pagelist">' . $cart_fen_ye . '</div>';
			echo $return_html;
			break;
		case 'add_coupon':
			$result_info_array = array('is_error' => false , 'error_info' => '' , 'link' => '' , 'coupon_display' => '' , 'order_info' => '' ,  'success_info' => TEXT_ADD_COUPON_DESCRIPTION);
			$code = zen_db_prepare_input($_POST['code']);
			
			if($code == '' || $code == TEXT_ENTER_A_COUPON_CODE){
				$result_info_array['error_info'] = TEXT_ENTER_A_COUPON_CODE;
				$result_info_array['is_error'] = true;
			}
			
			if(!$result_info_array['is_error']){
			    unset($_SESSION['coupon_id']);
			    unset($_SESSION['coupon_to_customer_id']);
			    
			    $error_info_array = add_coupon_code($code);
			    $result_info_array['error_info'] = $error_info_array['error_info'];
			    $result_info_array['is_error']   = $error_info_array['is_error'];
                            $result_info_array['coupon_id']  = $error_info_array['coupon_id'];
			    
				if(isset($_SESSION['customer_id']) && $_SESSION['customer_id']!=0){
					require (DIR_WS_CLASSES . 'order.php');
					$order = new order(0, $products_array['data']);
					require (DIR_WS_CLASSES . 'order_total.php');
					$order_total_modules = new order_total ();
					$order_total_array = $order_total_modules->process ();
			
					$total_price = $_SESSION['cart']->show_total_new();
					$total_promotion_price = $_SESSION['cart']->show_promotion_total();
					if( (!zen_get_customer_create()) && $total_price!=$total_promotion_price && !$_SESSION['order_discount']  && !get_with_channel()/* && !zen_customer_is_new () */){
						$_SESSION['cc_id'] = 20;	//RCD			
						$order->cart();
						$order_total_modules = new order_total;
						$order_total_array = $order_total_modules->process ();
					}
					$order_totals = 0;
					$promotion_discount = 0;
					if (isset ( $order_total_array )) {
						for($i = 0, $n = sizeof ( $order_total_array ); $i < $n; $i ++) {
							if ($order_total_array[$i]['code'] == 'ot_subtotal') {
								$order_totals = $order_total_array[$i]['value'];
							} elseif ($order_total_array[$i]['code'] == 'ot_promotion') {
								$promotion_discount = $order_total_array[$i]['value'];
							}
						}
					}
		
				$coupon_array = get_coupon_select (true);
				$coupon_select = $coupon_array['coupon_select'];
				
				if(sizeof($coupon_select) > 0){
				    if (sizeof ( $coupon_select ) > 0 && !isset($_SESSION['coupon_id'])) {
				        if(date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME || date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME || $_SESSION['channel']){
				            $first_coupon_info =  reset($coupon_select);
				            $_SESSION['coupon_id'] = $first_coupon_info['coupon_id'];
				            $_SESSION['coupon_to_customer_id'] = $first_coupon_info['coupon_to_customer_id'];
				            $_SESSION['use_coupon'] = 'Y';
				            
				            $_SESSION['coupon_amount_orders_total'] = $_SESSION['cart']->show_total_new();
				        }
				    }
				}else{
				    unset($_SESSION['coupon_id']);
				    unset($_SESSION['coupon_to_customer_id']);
				}
				
				$order = new order(0, $products_array['data']);
				$order_total_modules = new order_total ();
				$order_total_array = $order_total_modules->process ();
				if (isset($_SESSION['coupon_id'])&& $coupon_select[$_SESSION['coupon_id']]) {
				    $show_coupon = $coupon_select[$_SESSION['coupon_id']];
				}
				if(sizeof($coupon_select) > 0 || sizeof($coupon_array['coupon_unselect']) > 0){
				    $coupon_display = true;
				}
				
				if ($coupon_display){
				    if (sizeof($coupon_select) > 0){
				        if (sizeof($show_coupon) > 0){
				            $show_coupon_str = '<div class="couponSelect" conpon_id="' . $show_coupon['coupon_to_customer_id'] . '" onclick="saveAddressInfo(\'index.php?main_page=checkout&pn=cm\');">
        					<span class="couponContent">
        					<span class="couponDesc">' . $show_coupon['coupon_description'] . '</span>
        					<span class="couponDate" align="center">' . $show_coupon['coupon_start_time_format'] . ' - ' . $show_coupon['deadlineformat'] . '</span>
        					</span>
        					<span class="couponArrow">
        					<img class="" src="/includes/templates/mobilesite/css/' . $_SESSION['languages_code'] . '/images/method_arrow.png" />
        					</span>
        					</div>';
				        }else{
				            $show_coupon_str = '<div class="couponSelect"  onclick="saveAddressInfo(\'index.php?main_page=checkout&pn=cm\');">
        					<span class="couponContent">
        					<span class="couponDesc">' . TEXT_DISCOUNT_COUPON_NULL . '</span>
        					<span class="couponDate" align="center">&nbsp;</span>
        					</span>
        					<span class="couponArrow">
        					<img class="" src="/includes/templates/mobilesite/css/' . $_SESSION['languages_code'] . '/images/method_arrow.png" />
        					</span>
        					</div>';
    					}
				    }else{
				        $show_coupon_str = '<div class="no_use_coupon"  onclick="saveAddressInfo(\'index.php?main_page=checkout&pn=cm\');">
    					<span class="couponContent">
    					<span class="couponDesc">' .TEXT_DISCOUNT_COUPON_NO_USE . '</span>
    					<span class="couponDate" align="center">&nbsp;</span>
    					</span>
    					<span class="couponArrow">
    					<img class="" src="/includes/templates/mobilesite/css/' . $_SESSION['languages_code'] . '/images/method_arrow.png" />
    					</span>
    					</div>';
					}
				}
					
				$order_total_str = '<table class="totalprice">';
				foreach($order_total_array as $key => $val){//var_dump($order_total_array);
					if($key == 0){		//	subtotal
						$total_price = $order->info['subtotal_show'];//$currencies->format_cl($val['value']);
						$order_total_str .= '<tr><th>' . TEXT_CART_TOTAL_PRODUCT_PRICE . ':</th><td class="total_pice price_color">'.$val['text'] . '</td></tr>';
						$grand_total = $total_price;
					}elseif($val['code'] == 'ot_cash_account'){		//	not show cash
						if($val['value']!=0 || $val['value']!=''){
							$cash_account = $currencies->format_cl($val['value']);
						}
						continue;
					}elseif($key == (sizeof($order_total_array)-1)){	//	total
						if($grand_total<0) $grand_total = 0;
						$show_grand_total = ($cash_account!=0 ? $currencies->format($grand_total, false) : $currencies->format($val['value']));
						$order_total_str.='<tr><th>' . TABLE_HEADING_TOTAL . ':</th><td class="total_pice price_color">'.$show_grand_total.'</td></tr>';
					}elseif($val['code'] == 'ot_coupon'){		//	coupon
						//if($coupon){
						$trail = zen_not_null($val['percentage_discount']) ? ' (<font color="red">'.round($val['percentage_discount'],2).'% ' . TEXT_DISCOUNT_OFF_SHOW . '</font>)' : '';
						if(substr($val['text'],0,1) == '-'){
							$grand_total -= $currencies->format_cl($val['value']);
							$order_total_str .= '<tr><th>'.str_replace(':', $trail, $val['title']).':</th><td class="total_pice price_color">(-) '.substr($val['text'],1).'</td></tr>';
						}else{
							$grand_total += $currencies->format_cl($val['value']);
							$order_total_str .= '<tr><th>'.str_replace(':', $trail, $val['title']).':</th><td class="total_pice price_color">(+) '.$val['text'].'</td></tr>';
						}
						//}
					}elseif ($val['code'] == 'ot_promotion'){
						$grand_total -= $currencies->format_cl($val['value']);
						$order_total_str .= '<tr><th>'.$val['title'].'</th>';
						$order_total_str .= '<td class="total_pice price_color">(-) '.substr($val['text'],1).'</td></tr>';
				
					}else{	//	others
						$title = $trail = '';
						if($val['code']=='ot_shipping')
							$title = TEXT_SHIPPING_CHARGE;
							else if($val['code']=='ot_group_pricing'){
								$title = TEXT_CART_VIP_DISCOUNT .' (<font color="red">'.round($val['percentage_discount'],2).'%' . TEXT_DISCOUNT_OFF_SHOW . '</font>):';
								//$trail = zen_not_null($val['percentage_discount']) ? '' : '';
								//$trail .= '<a href="page.html?id=65" target="_blank"><ins class="question_icon"></ins></a>';
							}else
								$title = $val['title'];
								if(substr($val['text'],0,1) == '-'){
									$grand_total -= $currencies->format_cl($val['value']);
									$val['text'] = '(-) '.substr($val['text'],1);
								}else{
									$grand_total += $currencies->format_cl($val['value']);
									$val['text'] = $val['text']==TEXT_FREE_SHIPPING ? $val['text'] : '(+) '.$val['text'];
								}
								$order_total_str .= '<tr><th>'.$title.$trail.'</th><td class="total_pice price_color">'.$val['text'].'</td></tr>';
					}
				}
				$order_total_str .= '</table>';
				
				$result_info_array['coupon_display'] = $show_coupon_str;
				$result_info_array['order_info'] = '<h3>' .TEXT_ORDER_SUMMARY . '</h3>' . $order_total_str;
			}else{
				$result_info_array['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
				$result_info_array['is_error'] = true;
			}
		}
		
		echo json_encode($result_info_array);
		break;
	}
}
?>