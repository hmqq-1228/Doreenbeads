<?php
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT');
if (!$_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE);
require(DIR_WS_INCLUDES . 'classes/customers_group.php');
$customers_group = new customers_group;
$customers_group->correct_group($_SESSION['customer_id']);

$customer_new=zen_customer_is_new();
$declare_total = $db->Execute('Select sum(usd_order_total) as d_total
									   From ' . TABLE_DECLARE_ORDERS ."
									  Where status>0 and customer_id = " . $_SESSION['customer_id']);	
if($customer_new && !isset($declare_total->fields['d_total'])){
	//$cNextVipInfo['customer_group'] = $cNextVipInfo['customer_group']?$cNextVipInfo['customer_group']:'Steel';
	//$cVipInfo['customer_group'] = $cVipInfo['customer_group']?$cVipInfo['customer_group']:'Normal';
	$cVipInfo = getCustomerVipInfo ();
	$cNextVipInfo = getCustomerVipInfo ( true );
	$customers_orders_total=0;
}else{
	$order_total = $db->Execute('Select sum(order_total) as total
									   From ' . TABLE_ORDERS . "
									  Where orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . ")
									    And customers_id = " . $_SESSION['customer_id']);
	$customers_orders_total = $order_total->fields['total'] + $declare_total->fields['d_total'];
	if(isset($order_total_integral)  && $order_total_integral->fields['total'] != ''){
		$old_customers_orders_total = $customers_orders_total;
		$customers_orders_total = $customers_orders_total + $order_total_integral->fields['total'];
	}
	$cVipInfo = getCustomerVipInfo ();
	$cNextVipInfo = getCustomerVipInfo ( true );
	$history_amount=$customers_orders_total;
	$width_vip_li = round ( $history_amount / $cNextVipInfo ['max_amt'], 2 ) * 100;
	
	$credit_records = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
							   From " . TABLE_CASH_ACCOUNT . "
						       Where cac_customer_id = " . $_SESSION ['customer_id'] . "
							   And cac_status = 'A'" );
	$credit_account_total = 0;
	while ( ! $credit_records->EOF ) {
		$ca_currency_code = $credit_records->fields ['cac_currency_code'];
		$ca_amount = $credit_records->fields ['cac_amount'];
		$credit_account_total += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
		$credit_records->MoveNext ();
	}
	$credit_account_total_display =$currencies->format($credit_account_total);
}
$display_orders_total=$currencies->format($customers_orders_total);

//	ru����coupon��ȡ/ʹ����ʾ��
$show_ru_get_coupon = false;
$show_ru_use_coupon = false;
if($_SESSION['register_languages_id']==3 && $_SESSION['languages_id']==3){
	if( (! isset($_COOKIE['hide_ru_get_coupon']) || $_COOKIE['hide_ru_get_coupon']!='true') && date('Y-m-d H:i:s') <= '2014-02-08 23:59:59'){
		$coupon = $db->Execute('select coupon_expire_date from '.TABLE_COUPONS.' where coupon_active = "Y" and coupon_usage="ru_online" and coupon_start_date <= "'. date('Y-m-d H:i:s') .'" and coupon_expire_date > "'. date('Y-m-d H:i:s') .'" and coupon_id not in (select cc_coupon_id from '.TABLE_COUPON_CUSTOMER.' where cc_customers_id ='.$_SESSION['customer_id'].') order by coupon_expire_date desc limit 1');
		if($coupon->RecordCount() > 0){
			$show_ru_get_coupon = true;
			$show_ru_cookie_day = ceil( (strtotime($coupon->fields['coupon_expire_date'])-strtotime(date("Y-m-d H:i:s")))/86400 );
		}
	}
	if(! isset($_COOKIE['hide_ru_use_coupon']) || $_COOKIE['hide_ru_use_coupon']!='true'){
		$show_ru_use_from = date('Y-m-d',strtotime('+15 day',time()));
		$coupon = $db->Execute('select coupon_id, coupon_type, coupon_amount, coupon_expire_date from '.TABLE_COUPONS.' c,'.TABLE_COUPON_CUSTOMER.' cc where coupon_active="Y" and coupon_usage="ru_online" and cc.cc_coupon_id=c.coupon_id and cc_customers_id ='.$_SESSION['customer_id'].' and coupon_start_date <= "'. date('Y-m-d H:i:s') .'" and coupon_expire_date >= "'. $show_ru_use_from .' 00:00:00" and coupon_expire_date <= "'. $show_ru_use_from .' 23:59:59" order by coupon_id desc');
		if($coupon->RecordCount() > 0){
			$show_ru_use_amount = 0;
			while(!$coupon->EOF){
				$coupon_track = $db->Execute('select order_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id='.$_SESSION['customer_id'].' and coupon_id='.$coupon->fields['coupon_id'].' order by redeem_date desc');
				if($coupon_track->RecordCount() <= 0){
					$show_ru_use_coupon = true;
					$show_ru_ucookie_day = 9;
					$show_ru_day_type = 15;
					if($coupon->fields['coupon_type'] == 'F') $show_ru_use_amount += $coupon->fields['coupon_amount'];
				}
				$coupon->MoveNext();
			}
		}
		if(!$show_ru_use_coupon){
			$show_ru_use_from = date('Y-m-d',strtotime('+5 day',time()));
			$coupon = $db->Execute('select coupon_id, coupon_type, coupon_amount, coupon_expire_date from '.TABLE_COUPONS.' c,'.TABLE_COUPON_CUSTOMER.' cc where coupon_active="Y" and coupon_usage="ru_online" and cc.cc_coupon_id=c.coupon_id and cc_customers_id ='.$_SESSION['customer_id'].' and coupon_start_date <= "'. date('Y-m-d H:i:s') .'" and coupon_expire_date >= "'. $show_ru_use_from .' 00:00:00" and coupon_expire_date <= "'. $show_ru_use_from .' 23:59:59" order by coupon_id desc');
			if($coupon->RecordCount() > 0){
				$show_ru_use_amount = 0;
				while(!$coupon->EOF){
					$coupon_track = $db->Execute('select order_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id='.$_SESSION['customer_id'].' and coupon_id='.$coupon->fields['coupon_id'].' order by redeem_date desc');
					if($coupon_track->RecordCount() <= 0){
						$show_ru_use_coupon = true;
						$show_ru_ucookie_day = 5;
						$show_ru_day_type = 5;
						if($coupon->fields['coupon_type'] == 'F') $show_ru_use_amount += $coupon->fields['coupon_amount'];
					}
					$coupon->MoveNext();
				}
			}		
		}
	}
}
// end

$products_new_array = array();
$audit_month = date('Ym',strtotime('-1 month',time()));
$products_best_seller_query_raw = "SELECT p.products_id, ps.products_quantity,pd.products_name, p.products_image,  p.products_price,p.products_quantity_order_min,p.products_quantity_order_max,pon.products_order_num as order_sum,is_sold_out,products_stocking_days
							 FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_ORDER_NUM . " pon
							 WHERE p.products_id = pon.products_id
							 and p.products_status = 1
							 and pd.language_id = " . $_SESSION ['languages_id']."
							 AND ps.products_quantity>0
                             and p.products_id = pd.products_id 
                             and ps.products_id = p.products_id 
							 AND p.products_status =1  order by pon.products_order_num desc limit 5";
$products_best_seller = $db->Execute($products_best_seller_query_raw);
if ($products_best_seller->RecordCount () > 0) {
	$num_products_alsolike = $products_best_seller->RecordCount ();
	$main_products_id = trim ( $_GET ['products_id'] );
	$page_name = "product_listing";
	$page_type = 1;
	$matching_products_content = array ();
	$disp_sum = 0;
	$customer_basket_products = zen_get_customer_basket ();
	while ( ! $products_best_seller->EOF ) {
		$product_id = $products_best_seller->fields ['products_id'];
		$product_quantity = $products_best_seller->fields ['products_quantity'];
		$product_image = $products_best_seller->fields ['products_image'];
		$product_name = $products_best_seller->fields ['products_name'];
		$product_min_order = $products_best_seller->fields ['products_quantity_order_min'];
		$product_max_order = $products_best_seller->fields ['products_quantity_order_max'];
			
//		if (isset ( $customer_basket_products [$product_id] )) {
//			$procuct_qty = $customer_basket_products [$product_id];
//			$bool_in_cart = 1;
//		} else {
			$procuct_qty = 0;
			$bool_in_cart = 0;
//		}
			
		$discount_amount = 0;
		$matching_products_content [$disp_sum] ['discount'] = $discount_amount > 0 ? draw_discount_img($discount_amount,'div') : '';
		$matching_products_content [$disp_sum] ['img'] = '<div class="hovercont"><a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $product_id ) . '" class="similarimg"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $product_image, 130, 130 ) . '" alt="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '"></a></div>';
		$matching_products_content [$disp_sum] ['name'] = '<p class="des"><a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $product_id ) . '">' . getstrbylength ( htmlspecialchars ( zen_clean_html ( $product_name ) ), 32 ) . '</a></p>';
			
		$unit_price = zen_get_unit_price($product_id);
		if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){
			$matching_products_content [$disp_sum] ['price'] = $unit_price;
		}else{
			$matching_products_content [$disp_sum] ['price'] = zen_get_products_display_price_new ( $product_id, 'matching' );
		}
		
		$matching_products_content [$disp_sum] ['button'] = '<div class="detailinput protips"><p>';
		if ($product_quantity > 0) {
			$matching_products_content [$disp_sum] ['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" id="' . $page_name . '_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="' . $bool_in_cart . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="' . ($bool_in_cart ? 'icon_updates' : 'icon_addcart') . '" title="'.($bool_in_cart ? TEXT_UPDATE : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '" onclick="Addtocart_list(' . $product_id . ',' . $page_type . ', this); return false;"></a>';
		} else {
			
			if($products_best_seller->fields['is_sold_out'] == 1){
					$matching_products_content [$disp_sum] ['button'] .= '<span class="soldout_text"><a href="javascript:void(0);" id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$matching_products_content [$disp_sum] ['button'] .= '<a class="icon_soldout" href="javascript:void(0);">'.TEXT_SOLD_OUT.'</a>';
			}else{
				/*
					$matching_products_content [$disp_sum] ['button'] .= '<input type="hidden" id="MDO_' . $product_id . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $product_id . '" value="'.$procuct_qty.'" /><br />';
								
					$matching_products_content [$disp_sum] ['button'] .= '<span class="soldout_text"><a href="javascript:void(0);" id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
					$matching_products_content [$disp_sum] ['button'] .='<a rel="nofollow" class="icon_backorder" id="submitp_' . $product_id . '" onclick="makeSureCart('.$product_id.','.$page_type.',\''.$page_name.'\',\''.get_backorder_info($product_id).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . '</a>';
				*/
				$matching_products_content [$disp_sum] ['button'] .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" id="' . $page_name . '_' . $product_id . '" name="products_id[' . $product_id . ']" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="' . $bool_in_cart . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="' . ($bool_in_cart ? 'icon_updates' : 'icon_addcart') . '" title="'.($bool_in_cart ? TEXT_UPDATE : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '" onclick="Addtocart_list(' . $product_id . ',' . $page_type . ', this); return false;"></a>';
				$backtip = '<div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999">'.($products_best_seller->fields['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</div>';
			}
		}
		$matching_products_content [$disp_sum] ['button'] .= '<a class="addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" id="wishlist_' . $product_id . '" class="addwishlistbutton" onclick="beforeAddtowishlist(' . $product_id . ',' . $page_type . '); return false;" href="javascript:void(0);"></a>';
		$matching_products_content [$disp_sum] ['button'] .= '</p>';
		$matching_products_content [$disp_sum] ['button'] .= '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
		$matching_products_content [$disp_sum] ['button'] .= '<div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
		$matching_products_content [$disp_sum] ['button'] .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div></div>';
		$matching_products_content [$disp_sum] ['button'] .= $backtip;
		$backtip = '';
		$disp_sum ++;
		$products_best_seller->MoveNext ();
	}
	
}
if (isset($_SESSION['customer_id'])) {
			$order_sql="select orders_id
			 from  " . TABLE_ORDERS . " 
			 WHERE customers_id = :customersID";
			$order_sql=$db->bindVars($order_sql,':customersID',$_SESSION['customer_id'],'integer');
			$order_result = $db->Execute($order_sql);
			$num = $order_result->RecordCount();
			if($num == 0){
				$text_value = '';
			}else{
				$text_value = '';
			}
}
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT');
?>