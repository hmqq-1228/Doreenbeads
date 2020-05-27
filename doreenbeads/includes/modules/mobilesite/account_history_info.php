<?php
$zco_notifier->notify ( 'NOTIFY_HEADER_START_ACCOUNT_HISTORY_INFO' );
require (DIR_WS_LANGUAGES . 'mobilesite/' . $_SESSION ['language'] . '/account_history_info.php');
require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/account_history_info.php');
require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/shopping_cart.php');
if (!isset($_SESSION['customer_id']) || (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == '')){
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect(zen_href_link(FILENAME_LOGIN));
}
if (! isset ( $_GET ['order_id'] ) || (isset ( $_GET ['order_id'] ) && ! is_numeric ( $_GET ['order_id'] ))) {
	zen_redirect ( zen_href_link ( FILENAME_ACCOUNT_HISTORY, '', 'SSL' ) );
}
//error_reporting(E_ALL^E_NOTICE);
require (DIR_WS_CLASSES . 'order.php');
$order = new order ( $_GET ['order_id'] );

$breadcrumb->add ( NAVBAR_TITLE, zen_href_link ( FILENAME_MYACCOUNT, '', 'SSL' ) );
$breadcrumb->add ( NAVBAR_TITLE_3, zen_href_link ( FILENAME_ACCOUNT ) );
$breadcrumb->add ( '#' . $_GET ['order_id'] );
$order_query = "select orders_status from " . TABLE_ORDERS . " where orders_id = '" . ( int ) $_GET ['order_id'] . "' and customers_id = " . $_SESSION ['customer_id'] . " limit 1";
$orders_status = $db->Execute ( $order_query );
if ($orders_status->RecordCount () == 0) {
	zen_redirect ( zen_href_link ( FILENAME_ACCOUNT, '', 'SSL' ) );
}
$orders ['order_id'] = $_GET ['order_id'];
$orders ['order_status'] = $orders_status->fields ['orders_status'];
$orders ['date_purchased_format'] = date ( 'M d, Y', strtotime ( $order->info ['date_purchased'] ) );

$payment_records = $db->Execute ( "select payment_records_id, payment_type from " . TABLE_PAYMENT_RECORDS . " where orders_id = '" . ( int ) $_GET ['order_id'] . "' order by payment_records_id desc limit 1" );
if ($payment_records->RecordCount () == 1) {
	$payment_type = $payment_records->fields ['payment_type'];
} else {
	if ($order->info ['payment_method'] != '') {
		$payment_type = $order->info ['payment_method'];
	} else {
		$payment_type = 'Paypal';
	}
}

if((isset($_SESSION['is_old_customers']) && $_SESSION['is_old_customers'] == 0 ) && in_array($orders_status->fields['orders_status'], explode(',', MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP))){
    $db->Execute('update ' . TABLE_CUSTOMERS . ' set is_old_customers = 1 where customers_id= "' . $_SESSION['customer_id'] . '"' );
}

$make_payment = false;
$make_payment_file = '';
if (isset ( $_GET ['continued_order'] ) && $_GET ['continued_order'] == 'payment' && $orders ['order_status'] == 1 && $payment_records->RecordCount () == 0) {
	$make_payment = true;
	$make_payment_file = DIR_WS_TEMPLATE_TPL . 'tpl_make_payment.html';
}
$smarty->assign('make_payment', $make_payment);
$smarty->assign('make_payment_file', $make_payment_file);

if($orders ['order_status']==2 && $_SESSION['payment_return_account']){
	//	invite frineds 20150422 xiaoyong.lv
	$fun_inviteFriends->sendCoupon($_GET['order_id']);
	unset($_SESSION['payment_return_account']);
}

$statuses_query = "SELECT os.orders_status_name, osh.date_added, osh.comments
                   FROM " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh
                   WHERE osh.orders_id = :ordersID
                   AND os.language_id = " . $_SESSION ['languages_id'] . "
                   AND osh.orders_status_id = os.orders_status_id
                   AND osh.orders_status_id = 1
                   ORDER BY osh.date_added";

$statuses_query = $db->bindVars ( $statuses_query, ':ordersID', $_GET ['order_id'], 'integer' );
$statuses = $db->Execute ( $statuses_query );
$orders ['order_comments'] = '';
while ( ! $statuses->EOF ) {
	$statuses->fields ['comments'] = str_replace("#D5#",TEXT_REORDER_PACKING_WAY_ONE.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#BD#",TEXT_REORDER_PACKING_WAY_TWO.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#D15#",TEXT_REORDER_PACKING_WAY_THREE.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#D#",TEXT_REORDER_PACKING_WAY_FOUR.'<br/>',$statuses->fields ['comments']);
	$statuses->fields ['comments'] = str_replace("#15FA#",TEXT_REORDER_PACKING_WAY_FIVE.'<br/>',$statuses->fields ['comments']);
	$orders ['order_comments'] .= $statuses->fields ['comments'];
	$orders ['orders_status_name'] .= $statuses->fields ['orders_status_name'] . '&nbsp;';
	$statusArray [] = array (
			'date_added' => date ( 'M d, Y', strtotime ( $statuses->fields ['date_added'] ) ),
			'orders_status_name' => $statuses->fields ['orders_status_name'],
			'comments' => (empty ( $statuses->fields ['comments'] ) ? '&nbsp;' : nl2br ( $statuses->fields ['comments'] ))
	);

	$statuses->MoveNext ();
}
$order->delivery['telephone_number'] = $order->customer['telephone'];
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION ['language'] . '/';
require ($language_page_directory . 'account.php');
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_payment.php');

$orders ['account_order_date'] = date('M d, Y',strtotime ( $order->info ['date_purchased'] ));
$order_query = "select  orders_status
                        from " . TABLE_ORDERS . "
                        where orders_id = '" . ( int ) $_GET ['order_id'] . "' limit 1";
$orders_status = $db->Execute ( $order_query );
$orders ['order_status'] = $orders_status->fields ['orders_status'];
$orders ['account_continued_order'] = $db->prepare_input ( $_GET ['continued_order'] );
$orders ['account_order_telephone'] = $order->customer ['telephone'];
$orders ['account_order_shipping_address'] = zen_address_format ( $order->delivery ['format_id'], $order->delivery, 1, '', ' ' );
$order_totals_arr = array ();
$order_total_show = array ();
if (isset ( $orders ['order_id'] )) {
	$order_total_show = $order;
}
$order_total = 0;
for($i = 0, $n = sizeof ( $order_total_show->totals ); $i < $n; $i ++) {
	$order_totals_arr [$order_total_show->totals [$i] ['class']] = $order_total_show->totals [$i];
	if (is_int ( stripos ( $order_total_show->totals [$i] ['text'], "-" ) ) && $order_total_show->totals [$i] ['class'] != 'ot_cash_account') {
		$order_total = $order_total - $order_total_show->totals [$i] ['value'];
	} else if ($order_total_show->totals [$i] ['class'] != 'ot_cash_account') {
		$order_total = $order_total + $order_total_show->totals [$i] ['value'];
	}
}

// echo $order_total;exit;
$order_total = $currencies->format ( $order_total, true, $order_total_show->info ['currency'], $order_total_show->info ['currency_value'] );
$orders ['payment_order_total'] = $currencies->format ( $order_totals_arr ['ot_total'] ['value'], true, $order->info ['currency'], $order->info ['currency_value'] );

$show_payment = 0;
$payment_records = $db->Execute ( "select payment_records_id from " . TABLE_PAYMENT_RECORDS . " where orders_id = '" . ( int ) $_GET ['order_id'] . "'" );
if ($payment_records->RecordCount () > 0) {
	$show_payment = $payment_records->RecordCount ();
}
$orders ['account_show_payment'] = $show_payment;

require (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping ( $order->info ['shipping_module_code'] );
if (is_object ( $GLOBALS [$order->info ['shipping_module_code']] )) {
	$quotes = $GLOBALS [$order->info ['shipping_module_code']]->quote ();
	$time_unit = TEXT_DAYS_LAN;
	if ($quotes['time_unit'] == 20) {
		$time_unit = TEXT_WORKDAYS;
	}
	$orders ['shipping_days'] = $quotes ['days'] . '&nbsp;' . $time_unit;
} else {
	$orders ['shipping_days'] = '';
}
$payment_module_code = $order->info ['payment_module_code'];
$orders ['payment_code'] = $payment_module_code;
$orders ['order_total_no_currency_left'] = $order_totals_arr['ot_total']['value'];
$orders['order_total_wire_min'] = ORDER_TOTAL_WIRE_MIN;

$orders ['currency_symbol_left'] = $currencies->currencies [$order_total_show->info ['currency']] ['symbol_left'];
$orders ['currency'] = $order_total_show->info ['currency'];
$cash_account = $currencies->format ( $order_totals_arr ['ot_cash_account'] ['value'], true, $order_totals_arr->info ['currency'], $order_totals_arr->info ['currency_value'] );
$orders ['payment_pay_for_this_order_show'] = sprintf ( TEXT_PAY_FOR_THIS_ORDER, $currencies->format ( $order_totals_arr ['ot_cash_account'] ['value'], true, $order_totals_arr->info ['currency'], $order_totals_arr->info ['currency_value'] ) );

if ( in_array($orders ['order_status'], explode(',', MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP))){
	$is_made_payment = true;
}else{
	$is_made_payment = false;
}

if ((in_array($payment_type, array('westernunion', 'wire', 'wirebc', 'moneygram')) && $orders ['order_status'] ==1)  || $orders ['order_status'] == 42){
	$is_underchecking = true;
}else{
	$is_underchecking = false;
}

$orders ['is_made_payment'] = $is_made_payment;
$orders ['is_underchecking'] = $is_underchecking;

$total_original = 0;
for($j = 0, $m = sizeof ( $order->products ); $j < $m; $j ++) {
	$products_tax = $order->products [$j] ['tax'];
	$products_price = $db->Execute ( "select products_id,products_price,products_priced_by_attribute,products_discount_type from " . TABLE_PRODUCTS . " where products_id = " . $order->products [$j] ['id'] . " limit 1" );
	$original_price = $products_price->fields ['products_price'];
	if ($products_price->fields ['products_priced_by_attribute'] == '1' and zen_has_product_attributes ( $products_price->fields ['products_id'], 'false' )) {
	} else {
		// discount qty pricing
		if ($products_price->fields ['products_discount_type'] != '0') {
			$original_price = zen_get_products_discount_price_qty ( $products_price->fields ['products_id'], $order->products [$j] ['qty'], 0, false );
		}
	}
	$total_original += $currencies->format_cl ( zen_add_tax ( $original_price, $products_tax ), true, $order->info ['currency'] ) * $order->products [$j] ['qty'];
	// var_dump($total_original);exit;
}
$discount = 0;
$vip = 0;
$rcd = 0;
$orders_discounts = 0;
$special_discount = 0;
for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
    if(in_array($order->totals[$i]['class'], array('ot_group_pricing'))){
        $vip += $currencies->format_cl($order->totals[$i]['value']);
    }else{
        $vip += 0;
    }
    if(in_array($order->totals[$i]['class'], array('ot_coupon'))){
        $rcd += $currencies->format_cl($order->totals[$i]['value']);
    }else{
        $rcd += 0;
    }
    if(in_array($order->totals[$i]['class'], array('ot_order_discount'))){
        $orders_discounts += $currencies->format_cl($order->totals[$i]['value']);
    }else{
        $orders_discounts += 0;
    }
    if(in_array($order->totals[$i]['class'], array('ot_big_orderd'))){
        $special_discount +=$currencies->format_cl($order->totals[$i]['value']);
    }else{
        $special_discount +=0;
    }
}
$vip_rcd = $vip+$rcd;
if($orders_discounts >= $vip_rcd){
    $discount  = $orders_discounts+$special_discount;
}else{
    $discount = $vip_rcd+$special_discount;
}

$a = true;
$is_discount = false;
$is_use_balance = false;
for($i = 0, $n = sizeof ( $order->totals ); $i < $n; $i ++) {
	$str .= '<tr>' . "\n";
	//$str1 .= '<tr>' . "\n";
	if ($order->totals [$i] ['class'] == 'ot_total') {
		if ($is_discount) {
			$title = '<th>' . TEXT_CART_ORIGINAL_PRICES . ':</th>' . "\n";
			$order_total_value = $order->totals [$i] ['value'];
			$grand_total = $currencies->format ( $currencies->format_cl ( $order->totals [$i] ['value'], false, $order->info ['currency'] ) + $is_discount_value, true, $order->info ['currency'], $order->info ['currency_value'] );
			$str .= $title . ' <td class="total_pice price_color">' . $grand_total . '</td></tr>' . "\n" . $discountstr . ' <tr><th>' . TEXT_FINAL_TOTAL_AMOUNT . ':</th>' . "\n" . ' <td class="total_pice price_color">' . $currencies->format($order->totals[$i]['value'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n";
		} else {
			$order_total_value = $order->totals [$i] ['value'];
			$title = ' <th>' . HEADING_TOTAL . ':</th>' . "\n";
			$str .= $title . ' <td class="total_pice price_color">' . $currencies->format($order->totals[$i]['value'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . '</td>' . "\n";
		}
	} else {
		if ($order->totals [$i] ['class'] == 'ot_subtotal') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_subtotal.php');
			$ot_subtotal = $order->totals [$i] ['text'];
			$order->totals [$i] ['title'] = TEXT_CART_ORIGINAL_PRICES . ':';
            $promotion_discount = $total_original - $currencies->format_cl ( $order->totals [$i] ['value'], true, $order->info ['currency'] );
            
            $original_prices = $currencies->format_cl($order->totals[$i]['value'])+ $promotion_discount;
            // var_dump( $currencies->format_cl($order->totals[$i]['value']));exit;
			$order->totals[$i]['text'] = $currencies->format($original_prices, false, $order->info['currency'], $order->info['currency_value']);
			
		}
		if ($order->totals [$i] ['class'] == 'ot_shipping') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_shipping.php');
			$order->totals [$i] ['title'] = TEXT_SHIPPING_FEE_ACOUNT . ':';
		}
		if ($order->totals [$i] ['class'] == 'ot_discount_coupon') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_discount_coupon.php');
			$order->totals [$i] ['title'] = TEXT_COUPON_REDEMPTION;
		}
		if ($order->totals [$i] ['class'] == 'ot_special_coupon') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_special_coupon.php');
			$order->totals [$i] ['title'] = TEXT_SPECIAL_COUPON . ':';
		}
		if ($order->totals [$i] ['class'] == 'ot_discount_amount') {
			$order->totals [$i] ['title'] = TEXT_DISCOUNT_AMOUNT_TEXT . ':';
		}
		if ($order->totals [$i] ['class'] == 'ot_group_pricing') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_group_pricing.php');
			$order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_GROUP_PRICING_TITLE . ':';
		}
		if ($order->totals [$i] ['class'] == 'ot_extra_amount') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_extra.php');
			$order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_EXTRA_PRICING_TITLE . ':';
		}
		if ($order->totals [$i] ['class'] == 'ot_coupon') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_coupon.php');
			// $order->totals[$i]['title'] = MODULE_ORDER_TOTAL_COUPON_TITLE;
		}
		if ($order->totals [$i] ['class'] == 'ot_cash_account') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_cash_account.php');
			$order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_BALANCE_CASH_ACCOUNT_TITLE . ':';
			$is_use_balance = true;
			$balance_use = $order->totals [$i] ['value'];
		}
		if ($order->totals [$i] ['class'] == 'ot_shipping_fee_discount') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_shipping_fee_discount.php');
			$order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_SHIPPING_FEE_DISCOUNT_TITLE . ':';
		}
		if ($order->totals [$i] ['class'] == 'ot_promotion') {
			require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_promotion.php');
			// if (MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_STATUS == 'true'){
			if(zen_not_null($order->info ['promotion_total_usd'])){ 
				$ot_subtotal_promotion = $ot_subtotal - $order->info ['promotion_total_usd'];
				if ($ot_subtotal_promotion >= MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE1 && $ot_subtotal_promotion < MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE2) {
					$promotion_discount_grade = MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE1;
				} elseif ($ot_subtotal_promotion >= MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE2 && $ot_subtotal_promotion < MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE3) {
					$promotion_discount_grade = MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE2;
				} elseif ($ot_subtotal_promotion >= MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE3) {
					$promotion_discount_grade = MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE3;
				} else {
					$promotion_discount_grade = MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE4;
				}
				$promotion_discount = $order_total * $promotion_discount_grade / 100;
                
				$promotion_discount_title = sprintf ( TEXT_PROMOTION_DISCOUNT_RCD, $promotion_discount_grade . '%' );
			}
			// }
			if (! isset ( $promotion_discount_title )) {
				$promotion_discount_title = $order->totals [$i] ['title'];
			}
			$order->totals [$i] ['title'] = $promotion_discount_title . ':';
		}
		if (substr ( $order->totals [$i] ['text'], 0, 1 ) == '-') {
			if ($order->totals [$i] ['class'] == 'ot_discount_amount') {
				$orders_discount_sql = 'select orders_discount_value from ' . TABLE_ORDERS_DISCOUNT_NOTE . ' where orders_id=' . ( int ) $_GET ['order_id'] . ' order by orders_discount_date desc limit 1 ';
				$orders_discount = $db->Execute ( $orders_discount_sql );
				if (isset ( $orders_discount->fields ['orders_discount_value'] ) && $orders_discount->fields ['orders_discount_value'] != '') {
					$discount_alt = '<ins title="' . $orders_discount->fields ['orders_discount_value'] . '" style="display: inline-block;width: 16px;height: 18px;background: url(./includes/templates/cherry_zen/css/en/images/icon_shopcart.png) 0 -17px no-repeat;cursor: pointer;"></ins>';
				}
				$is_discount = true;
				$is_discount_value = $currencies->format_cl ( $order->totals [$i] ['value'], false, $order->info ['currency'] );
				$discount_title = '<tr><th>' . $order->totals [$i] ['title'] . '</th>' . "\n";
				$discountstr = $discount_title . ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . $discount_alt . '</td></tr>' . "\n";
			} else if ($order->totals [$i] ['class'] == 'ot_group_pricing') {
				$title = ' <th>' . TEXT_VIP_GROUNP_DISCOUNT . ':</th>' . "\n";
				// $str .= $title . ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
			} else if ($order->totals [$i] ['class'] == 'ot_coupon') {
				$title = ' <th>' . $order->totals [$i] ['title'] . ' </th>' . "\n";
				// $str .= $title . ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
			} else if ($order->totals [$i] ['class'] == 'ot_shipping_discount') {
				require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_shipping_discount.php');
				preg_match ( '/\d+%/', $order->totals [$i] ['title'], $match );
				$title = ' <th>' . MODULE_ORDER_TOTAL_SHIPPING_DISCOUNT_TITLE . '(<font color="#0000FF">' . $match [0] . '</font>): </th>' . "\n";
				$str .= $title . ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
			} else if($order->totals [$i] ['class'] == 'ot_big_orderd'){
				$title = ' <th>' . $order->totals [$i] ['title'] . '</th>' . "\n";
				// $str .= $title . ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
			}else if($order->totals [$i] ['class'] == 'ot_discount_coupon'){
				$title = ' <th>' . $order->totals [$i] ['title'] . '</th>' . "\n";
				$str .= $title . ' <td class="total_pice price_color">- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
			}
		} else if ($order->totals [$i] ['class'] == 'ot_extra_amount') {
			$title = ' <th>' . $order->totals [$i] ['title'] . ' </th>' . "\n";
			$orders_discount_sql = 'select orders_discount_value from ' . TABLE_ORDERS_DISCOUNT_NOTE . ' where orders_id=' . ( int ) $_GET ['order_id'] . ' order by orders_discount_date desc limit 1 ';
			$orders_discount = $db->Execute ( $orders_discount_sql );
			if (isset ( $orders_discount->fields ['orders_discount_value'] ) && $orders_discount->fields ['orders_discount_value'] != '') {
				$discount_alt = '&nbsp;&nbsp;<ins title="' . $orders_discount->fields ['orders_discount_value'] . '" style="display: inline-block;width: 16px;height: 18px;background: url(./includes/templates/cherry_zen/css/en/images/icon_shopcart.png) 0 -17px no-repeat;cursor: pointer;"></ins>';
			}
			$str .= $title . ' <td class="total_pice price_color"> ' . $order->totals [$i] ['text'] . $discount_alt . '</td>' . "\n";
		} else {
			$title = ' <th>' . $order->totals [$i] ['title'] . '</th>' . "\n";
			$str .= $title . ' <td class="total_pice price_color">  ' . $order->totals [$i] ['text'] . '</td>' . "\n";
		}
		if($a){

			if($discount+$promotion_discount > 0){
               $title = '<tr> <th>' . TEXT_CART_DISCOUNT . ':</th>' . "\n";
               // var_dump($discount+$promotion_discount);exit;	
				$str .= $title . ' <td class="total_pice price_color">- ' .  $currencies->format($discount+$promotion_discount, false, $order->info ['currency'], $order->info ['currency_value']) . '</td></tr>' . "\n";
			}
		 $a = false;
		}
	}
	$str .= '</tr>' . "\n";
}
$orders ['str'] = $str;
$orders ['is_use_balance'] = $is_use_balance;

if($is_use_balance){
	$cash_account_remaining = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
							   From " . TABLE_CASH_ACCOUNT . "
						      Where cac_customer_id = " . $_SESSION ['customer_id'] . "
							    And cac_status = 'A'" );
	$cash_account_remaining_total = 0;
	while ( ! $cash_account_remaining->EOF ) {
		$ca_currency_code = $cash_account_remaining->fields ['cac_currency_code'];
		$ca_amount = $cash_account_remaining->fields ['cac_amount'];
		$cash_account_remaining_total += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
		$cash_account_remaining->MoveNext ();
	}
	$balance_total = $cash_account_remaining_total + $balance_use;
	$orders ['balance_total'] = $currencies->format($balance_total, true, $order->info['currency'], $order->info['currency_value']);
	$orders ['balance_remain'] = $cash_account_remaining_total;
	$orders ['balance_use'] = sprintf(TEXT_BALANCE_USE_FOR_ORDER, $currencies->format($balance_use, true, $order->info['currency'], $order->info['currency_value']));
	$orders ['balance_need_to_pay'] = sprintf(TEXT_STILL_NEED_TO_PAY, $currencies->format($order_total_value, true, $order->info['currency'], $order->info['currency_value']));
}

$page_size = 20;
$orders_products_query = "select orders_products_id, products_id, products_name,
                                 products_model, products_price, products_tax,
                                 products_quantity, final_price,
                                 onetime_charges,
                                 products_priced_by_attribute, product_is_free, products_discount_type,note,
                                 products_discount_type_from
                                  from " . TABLE_ORDERS_PRODUCTS . "
                                  where orders_id = '" . $orders ['order_id'] . "'
                                  order by products_model";
$history_split = new splitPageResults ( $orders_products_query, $page_size, 'products_id', 'page' );
$orders_products = $db->Execute ( $history_split->sql_query );

$cart_fen_ye = '<div class="cart_split_page page">' . $history_split->display_links_mobile_for_shoppingcart ( 20, '', true ) . '</div>';


$i = 0;
$orders_array = array ();
while ( ! $orders_products->EOF ) {
	//$product_info = $db->Execute ( "select products_image, products_discount_type, products_weight, products_volume_weight from " . TABLE_PRODUCTS . " where products_id = " . $orders_products->fields ['products_id'] );
	$product_info = get_products_info_memcache($orders_products->fields ['products_id']);
	$productsName = getstrbylength ( strip_tags($orders_products->fields ['products_name']), PRODUCT_NAME_MAX_LENGTH );
	$productsImage = '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $product_info ['products_image'], 130, 130 ) . '" width="110" height="110"/>';
	$product_quantity = $orders_products->fields ['products_quantity'];
	$productsPriceEach = $currencies->display_price ( $orders_products->fields ['final_price'] );
	$productsPrice = $currencies->format ( $currencies->format_cl ( $orders_products->fields ['final_price'] ) * $product_quantity, false );
	if ($product_info ['products_discount_type'] != '0') {
		$productsPriceEachOriginal = $currencies->display_price ( zen_get_products_discount_price_qty ( $product_info ['products_id'], $product_quantity, 0, false ) );
	} else {
		$productsPriceEachOriginal = $productsPrice;
	}
	$products_model = $orders_products->fields ['products_model'];
	$productsVolumetricWeight = $product_info ['products_volume_weight'] <= $product_info ['products_weight'] ? '' : TEXT_VOLUMETRIC_WEIGHT . $product_info ['products_volume_weight'] . TEXT_GRAM_WORD;
	$productsShowPrice = ($productsPriceEach == $productsPriceEachOriginal) ? $productsPriceEach : ('<del>' . $productsPriceEachOriginal . '</del>' . $productsPriceEach);
	$products_link = HTTP_SERVER.'/index.php?main_page=order_products_snapshot&oID=' . $orders ['order_id'] . '&pID=' . $orders_products->fields['products_id'];
	$discount_amount = zen_show_discount_amount($orders_products->fields ['products_id']);
	$product_info['product_quantity'] = zen_get_products_stock($orders_products->fields ['products_id']);

	$orders_array [$i] = array (
			'id' => $orders_products->fields ['products_id'],
			'name' => $productsName,
			'image' => $productsImage,
			'qty' => $product_quantity,
			'price' => $productsPriceEach,
			'weight' => $product_info ['products_weight'],
			'vweight' => $product_info ['products_volume_weight'],
			'total' => $productsPrice,
			'model' => $products_model,
			'oprice' => $productsPriceEachOriginal,
			'link' => $products_link,
			'discount' => $discount_amount,
			'is_preorder' => $product_info['product_quantity'] ==0,
			'status' => $product_info['products_status'],
			'products_stocking_days' => $product_info['products_stocking_days']
	);
	$i ++;
	$orders_products->MoveNext ();
}

if (isset ( $_GET ['continued_order'] ) && $db->prepare_input ( $_GET ['continued_order'] ) == 'payment' && $orders ['order_status'] == 1) {
	require (DIR_WS_CLASSES . 'payment.php');
	$payment_modules = new payment ();
	global $GLOBALS;
	$payment_selection = array ();
	$confirmation = array ();
	if (! isset ( $GLOBALS ['paypalwpp'] )) {
		for($i = 0, $n = sizeof ( $payment_modules->modules ); $i < $n; $i ++) {
			include (zen_get_file_directory ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/payment/', $payment_modules->modules [$i], 'false' ));
			include_once (DIR_WS_MODULES . 'payment/' . $payment_modules->modules [$i]);
			$payment_modules->modules [$i] = str_replace ( '.php', '', $payment_modules->modules [$i] );
			$GLOBALS [$payment_modules->modules [$i]] = new $payment_modules->modules [$i] ();
			$confirmation [$payment_modules->modules [$i]] = $GLOBALS [$payment_modules->modules [$i]]->confirmation ();
			$payment_selection [] = $GLOBALS [$payment_modules->modules [$i]]->selection ();
		}
	} else {
		$payment_selection = $payment_modules->selection ();
		$confirmation ['westernunion'] = $GLOBALS ['westernunion']->confirmation ();
		$confirmation ['wirebc'] = $GLOBALS ['wirebc']->confirmation ();
		$confirmation ['wire'] = $GLOBALS ['wire']->confirmation ();
		$confirmation ['moneygram'] = $GLOBALS ['moneygram']->confirmation ();
	}
	// $smarty->assign('payment_selection', $payment_selection);
}
reset ( $currencies->currencies );

$currencies_array = array ();
while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
	$currencies_array [] = array (
			'id' => $key,
			'symbol_left' => $value ['symbol_left']
	);
}
// lvxiaoyong v2.91 coutry pull-down
$country_sel = $db->Execute ( "select countries_id from " . TABLE_COUNTRIES . " where countries_name=\"" . trim ( $order->delivery ['country'] ) . "\" limit 1" );
$moneygram_country = zen_get_country_select ( 'moneygram_country', $country_sel->fields ['countries_id'], $_SESSION ['languages_id'] ) . '<script>country_select_choose("moneygram_country");</script>';
// end

// view info details
if ($orders ['account_show_payment'] > 0) {
	$payment_check_record = $db->Execute ( "select p.first_name,p.control_no,p.currency,p.amount,p.payment_date,p.create_date from " . TABLE_PAYMENT_RECORDS . " p where orders_id=" . $orders ['order_id'] );
	if ($payment_check_record > 0) {
		$payment_record ['name'] = $payment_check_record->fields ['first_name'];
		$payment_record ['currency'] = $payment_check_record->fields ['currency'];
		$payment_record ['amount'] = $payment_check_record->fields ['amount'];
		$payment_record ['control_no'] = $payment_check_record->fields ['control_no'];
		$payment_record ['payment_date'] = $payment_check_record->fields ['payment_date'];
		$payment_record ['create_date'] = date ( 'M d, Y', strtotime ( $payment_check_record->fields ['create_date'] ) );
		zen_not_null ( $payment_record ['payment_date'] ) ? $payment_record ['date'] = $payment_record ['payment_date'] : $payment_record ['date'] = $payment_record ['create_date'];
	}
} else if ($order->info ['payment_method'] != '' && $orders ['order_status'] >= 2) {
	$payment_check_record = $db->Execute ( "select p.currency,p.order_total,p.date_purchased from " . TABLE_ORDERS . " p where orders_id=" . $orders ['order_id'] );
	if ($payment_check_record > 0) {
		$payment_record ['name'] = '';
		$payment_record ['control_no'] = '';
		$payment_record ['currency'] = $currencies->currencies [$payment_check_record->fields ['currency']] ['symbol_left'];
		;
		$payment_record ['amount'] = $payment_check_record->fields ['order_total'];
		$payment_record ['date'] = date ( 'M d, Y', strtotime ( $payment_check_record->fields ['date_purchased'] ) );
	}
}

$smarty->assign ( 'currencies_array', $currencies_array );
$smarty->assign ( 'confirmation', $confirmation );
$smarty->assign ( 'order_totals_arr', $order_totals_arr );
$smarty->assign ( 'order_total', $order_total );
$smarty->assign ( 'ot_subtotal', $ot_subtotal );
$smarty->assign ( 'filter', $filter );
$smarty->assign ( 'message', $message );
$smarty->assign ( 'orders', $orders );
$smarty->assign ( 'order', $order );
$smarty->assign ( 'orders_array', $orders_array );
$smarty->assign ( 'total_products', sizeof ( $order->products ) );
$smarty->assign ( 'statusArray', $statusArray );
$smarty->assign ( 'count_order', sizeof ( $order->products ) );
$smarty->assign ( 'coupon_select', $coupon_select );
$smarty->assign ( 'cart_fen_ye', $cart_fen_ye );
$smarty->assign ( 'payment_record', $payment_record );

$text_countries_list = zen_get_country_select('zone_country_id', 223, $_SESSION['languages_id'], 'id="country"');
$smarty->assign ( 'text_countries_list', $text_countries_list );

$zco_notifier->notify ( 'NOTIFY_HEADER_END_ACCOUNT_HISTORY_INFO' );
?>