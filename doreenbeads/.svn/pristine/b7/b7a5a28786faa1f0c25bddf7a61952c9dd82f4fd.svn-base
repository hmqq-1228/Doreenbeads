<?php 
/**
 * 2014-08-19 by zhanghongliang
 * Aug. promotion
 **/
function present_promotion_coupon_bak20150713($orders_id=0){
	global $db,$order;
	if(!$_SESSION['customer_id']) return false;
	$vip_discount = 0;
	$rcd_discount = 0;
	$ot_subtotal = 0;
	for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
		if($order->totals[$i]['class'] == 'ot_subtotal'){
			$ot_subtotal = $order->totals[$i]['value'];			
		}elseif($order->totals[$i]['class'] == 'ot_group_pricing'){
			$vip_discount = $order->totals[$i]['value'];	
		}elseif($order->totals[$i]['class'] == 'ot_coupon'){
			$rcd_discount = $order->totals[$i]['value'];	
		}
	}
	//$item_total = $ot_subtotal - $vip_discount - $rcd_discount;
	$item_total = $ot_subtotal;
	/*
	if($item_total>=111 && $item_total<222){
		$coupon_code = 'CP2014111101';
	}elseif($item_total>=222 && $item_total<444){
		$coupon_code = 'CP2014111102';
	}elseif($item_total>=444 && $item_total<555){
		$coupon_code = 'CP2014111103';
	}elseif($item_total>=555 && $item_total<888){
		$coupon_code = 'CP2014111104';
	}elseif($item_total>=888 && $item_total<999){
		$coupon_code = 'CP2014111105';
	}elseif($item_total>=999){
		$coupon_code = 'CP2014111106';
	}else{
		return false;
	}
	*/
	if($item_total>=300){
		$coupon_code = 'CP20141121';
	}else{
		return false;
	}

	$check_from_order = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_customers_id='".$_SESSION['customer_id']."' and coupon_from='".$orders_id."'");
	if($check_from_order->RecordCount()==0){
		$coupon_query = $db->Execute("select coupon_id,coupon_amount from ".TABLE_COUPONS." where coupon_code='".$coupon_code."' limit 1");
		$coupon_data_array = array(
			'cc_coupon_id'=>(int)$coupon_query->fields['coupon_id'],
			'cc_customers_id'=>$_SESSION['customer_id'],
			'cc_amount'=>$coupon_query->fields['coupon_amount'],
			'cc_coupon_start_time'=>date('Y-m-d H:i:s'),
			'cc_coupon_end_time'=>date('Y-m-d H:i:s', strtotime("+15 day")),
			'coupon_from'=>$orders_id,
			'cc_coupon_status'=>10,
			'date_created'=>'now()'
		);
		zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		return true;
	}else{
		return false;
	}
}

/**
* 201507营销活动。网购送coupon
* 20150713 lvxiaoyong
*/
function present_promotion_coupon($orders_id=0){
	global $db,$order,$currencies;
	if(!$_SESSION['customer_id']) return false;

	$date = date('Y-m-d H:i:s');
	if($date<PRESENT_COUPON_START_TIME || $date>PRESENT_COUPON_END_TIME) return false;
	
	/*$ot_balance = 0;	
	for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
		if($order->totals[$i]['class'] == 'ot_cash_account'){
			$ot_balance = $order->totals[$i]['value'];
		}
	}
	if($ot_balance>0){
		$pay_total = $order->info['total'] + $ot_balance;
	}else{
		$pay_total = $order->info['total'];
	}*/
	$pay_total = $order->info['total'];
	
	if($pay_total>=35 && $pay_total<80){
		$coupon_code = 'CP2015071505';
	}elseif($pay_total>=80 && $pay_total<150){
		$coupon_code = 'CP2015071512';
	}elseif($pay_total>=150){
		$coupon_code = 'CP2015071525';
	}else{
		return false;
	}
	
	$check_from_order = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_customers_id='".$_SESSION['customer_id']."' and coupon_from='".$orders_id."'");
	$coupon_query = $db->Execute("select coupon_id,coupon_amount from ".TABLE_COUPONS." where coupon_code='".$coupon_code."'");
		
	if($check_from_order->RecordCount()==0 && $coupon_query->RecordCount()>0){
		$coupon_data_array = array(
			'cc_coupon_id'=>(int)$coupon_query->fields['coupon_id'],
			'cc_customers_id'=>$_SESSION['customer_id'],
			'cc_amount'=>$coupon_query->fields['coupon_amount'],
			'cc_coupon_start_time'=>date('Y-m-d H:i:s'),
			'cc_coupon_end_time'=>date('Y-m-d H:i:s', strtotime("+20 day")),
			'coupon_from'=>$orders_id,
			'cc_coupon_status'=>10,
			'date_created'=>'now()'
		);
		zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		
		$coupon_name = $currencies->format($coupon_query->fields['coupon_amount'], true, $order->info['currency']);
		$email_subject = str_replace('&euro;', '€', sprintf(EMAIL_CURRENCY_SUBJECT, $coupon_name));
		$email_name =  $_SESSION['customer_first_name']!='' ? $_SESSION['customer_first_name'] : TEXT_CUSTOMER;	
		$email_text = sprintf(EMAIL_CURRENCY_BODY, $email_name, $coupon_name);
		$html_msg['EMAIL_MESSAGE_HTML'] = $email_text;
		$first_name = ucfirst($_SESSION['customer_first_name']);
		$last_name = ucfirst($_SESSION['customer_last_name']);
		zen_mail($first_name . ' ' . $last_name, $_SESSION['customer_email'], $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'default');
		return $coupon_query->fields['coupon_amount'];
	}else{
		return $coupon_query->fields['coupon_amount'];
	}
}

/**
 * 首单送coupon
 * @author Tianwen.Wan->20170316
 * @param int $orders_id
 * @param int $customers_id
 * @param array $coupon_customers_array
 * @return boolean
 */
function send_coupon_for_first_order($orders_id = 0, $orders_status, $coupon_customers_array){
	global $db, $currencies;
	$customers_id = $coupon_customers_array['customers_id'];
	$customers_email_address = $coupon_customers_array['customers_email_address'];
	if($orders_id <= 0 || $orders_status <= 0 || $customers_id <= 0 || empty($customers_email_address)) {
		return false;
	}
	if(!defined("CUSTOMERS_FIRST_ORDER_COUPON_CODE")) {
		return false;
	}
	if(CUSTOMERS_FIRST_ORDER_COUPON_STATUS == "true" && in_array($orders_status, explode(",", MODULE_ORDER_PAID_UNDER_CHECKING_STATUS_ID_GROUP))) {
		$has_paid_order_sql = "select orders_id from " . TABLE_ORDERS . " where customers_id=" . $customers_id . " and orders_id != " . $orders_id . " and orders_status not in(" . MODULE_ORDER_CANCELED_PENDING_UNDER_CHECKING_STATUS_ID_GROUP . ")";
		$has_paid_order_result = $db->Execute($has_paid_order_sql);
		if($has_paid_order_result->RecordCount() <= 0) {
			
			$coupon_array = array();
			if(strstr(CUSTOMERS_FIRST_ORDER_COUPON_CODE, ",") != "") {
				$coupon_array = explode(",", CUSTOMERS_FIRST_ORDER_COUPON_CODE);
			} else {
				$coupon_array[] = CUSTOMERS_FIRST_ORDER_COUPON_CODE;
			}
			
			$coupon_string = "'" . implode("','", $coupon_array) . "'";
			
			$coupon_sql = "select coupon_id, coupon_code, coupon_amount, coupon_minimum_order, coupon_type, coupon_expire_date, day_after_add from " . TABLE_COUPONS . " where coupon_code in (" . $coupon_string . ")";
			$coupon_result = $db->Execute($coupon_sql);
			$send_index = 0;
			$active_coupon_array = array();
			while(!$coupon_result->EOF) {
				$cc_coupon_start_time = $cc_coupon_end_time = null;
				if($coupon_result->fields['coupon_type'] == "C" && !empty($coupon_result->fields['day_after_add'])) {
					$cc_coupon_start_time = date("Y-m-d H:i:s");
					$cc_coupon_end_time = date("Y-m-d H:i:s", time() + (86400 * $coupon_result->fields['day_after_add']));
				}
				if($coupon_result->fields['coupon_type'] == "F") {
					$cc_coupon_start_time = null;
					$cc_coupon_end_time = null;
				}
				$save_sql_array = array(
					  'cc_coupon_id' => $coupon_result->fields['coupon_id'],
					  'cc_customers_id' => $customers_id,
					  'cc_amount' => $coupon_result->fields['coupon_amount'],
					  'cc_coupon_start_time' => $cc_coupon_start_time,
					  'cc_coupon_end_time' => $cc_coupon_end_time,
					  'coupon_from' => $orders_id,
					  'cc_coupon_status' => 10,
					  'website_code' => WEBSITE_CODE,
					  'date_created' => "now()"
					  
				);
				zen_db_perform(TABLE_COUPON_CUSTOMER, $save_sql_array);

				$active_coupon_array[$send_index] = $coupon_result->fields;
				
				if($coupon_result->fields['coupon_minimum_order']){
					$min_order = $currencies->format($coupon_result->fields['coupon_minimum_order']);
				}else{
					$min_order = '/';
				}
				if($coupon_result->fields['coupon_type']=='P'){
					$conpon_value = number_format($coupon_result->fields['coupon_amount'],2) . '%&nbsp;off';
				}elseif($coupon_result->fields['coupon_type']=='F'||$coupon_result->fields['coupon_type']=='C'){
					$conpon_value = $currencies->format($coupon_result->fields['coupon_amount']);
				}
				$active_coupon_array[$send_index]['min_order'] = $min_order;
				$active_coupon_array[$send_index]['conpon_value'] = $conpon_value;
				$active_coupon_array[$send_index]['deadline'] = zen_date_long($cc_coupon_end_time);

				$send_index++;
				$coupon_result->MoveNext();
			}
			
			if($send_index > 0) {
				//$customers_name = "";
				//if(!empty($coupon_customers_array['firstname'])) {
				//	$customers_name = $coupon_customers_array['firstname'] . ' ' . $coupon_customers_array['lastname'];
				//	if($coupon_customers_array['language_id'] == 6) {
				//		$customers_name = $coupon_customers_array['lastname'] . ' ' . $coupon_customers_array['firstname'];
				//	}
				//}

				$html_msg['EMAIL_MESSAGE_HTML'] = $coupon_customers_array['customers_name'] . " ,<br/>&nbsp;&nbsp;&nbsp;&nbsp;" . TEXT_IN_ORDER_TO_THANKS_FOR_YOU . "<br/><br/>";
				$html_msg['EMAIL_MESSAGE_HTML'] .= '<table border="1" rules="all" style="background-color:#E4E8F3; width:540px; font-size:12px;">
					  <tbody>
						<tr height="38">
						  <td width="20%" align="left">' . TEXT_COUPON_CODE . '</td>
						  <td width="25%" align="left">' . TEXT_COUPON_PAR_VALUE . '</td>
						  <td width="30%" align="left">' . TEXT_COUPON_MIN_ORDER . '</td>
						  <td width="35%" align="left">' . TEXT_COUPON_DEADLINE . '</td>
						</tr>';
				foreach($active_coupon_array as $coupon_info) {
					$html_msg['EMAIL_MESSAGE_HTML'] .= '<tr height="30">
						  <td align="left">' . $coupon_info['coupon_code'] . '</td>
						  <td align="left">' . $coupon_info['conpon_value'] . '</td>
						  <td align="left">' . $coupon_info['min_order'] . '</td>
						  <td align="left">' . $coupon_info['deadline'] . '</td>
						</tr>';
				}

				$html_msg['EMAIL_MESSAGE_HTML'] .= '</tbody></table>';
				$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>" . TEXT_HOPE_TO_DO_MORE_KIND_BUSINESS;

				
				
				zen_mail($coupon_customers_array['customers_name'], $customers_email_address, TEXT_TWO_REWARD_COUPONS, strip_tags($html_msg['EMAIL_MESSAGE_HTML']), STORE_NAME, EMAIL_FROM, $html_msg, 'default');
				return true;
			}
		}
	}
	return false;
}

function calculate_order_discount(){
	global $currencies;
	$order_discount = 0;
	$discount = 0;
	$order_discount_title = '';
	$output_html = '';
	$arr = array();

	if (MODULE_ORDER_TOTAL_ORDER_DISCOUNT_STATUS == 'true'){
		require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/ot_order_discount.php');
		$show_total = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total();

		/*满减活动*/
		if(date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME){
			$promotion_discount_full_set_minus = $show_total;
			if ($promotion_discount_full_set_minus > $currencies->format_cl( 49 )) {
				$discount = floor($promotion_discount_full_set_minus/$currencies->format_cl( 49 ))*$currencies->format_wei( 4 );
				$show_total = $show_total - $discount;
			}
		}
		/*阶梯式满减活动*/
		if(date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel']){
			if ($show_total > $currencies->format_cl( 379 )) {
				$discount = 25;
			}elseif($show_total > $currencies->format_cl( 259 )){
				$discount = 20;
			}elseif($show_total > $currencies->format_cl( 149 )){
				$discount = 10;
			}elseif($show_total > $currencies->format_cl( 49 )){
				$discount = 5;
			}elseif($show_total > $currencies->format_cl( 19 )){
                $discount = 1;
            }else{
				$discount = 0;
			}

			$show_total -= $currencies->format_cl($discount);
		}
		$order_total = $currencies->value($show_total, true, 'USD');
		
		$order_discount_grade = 0;
		if($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE1 && $order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2) {
			$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE1;
		}elseif($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2 && $order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3) {
			$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE2;
		}elseif($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3 && $order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4) {
			$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE3;
		}elseif($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4) {
			$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE4;
		}
		
		if($order_discount_grade>0){	
			$order_discount = round($show_total * $order_discount_grade / 100, 2);
			$order_discount_title = sprintf(TEXT_ORDER_DISCOUNT, $order_discount_grade . '%');
		
			$output_html = $order_discount_title . ' : -' . $order_discount;
		}
	
	}

	$arr = array('order_discount' => $order_discount,
			'order_discount_title' => $order_discount_title,
			'output_html' => $output_html);
	return $arr;
	
}

function zen_auto_update_promotion_products_status($products_id, $reback = false, $is_preorder = false, $preorder_status_change = false){
    global $db, $memcache;

    $is_s_level_products = get_products_info_memcache($products_id, 'is_s_level_product');
    if(!is_array($is_s_level_products) && $is_s_level_products === 1 ){
        return false;
    }

    $promotion_preorder_str = '';
    $dailydeal_preorder_str = '';
//    if($is_preorder){
//        $promotion_preorder_str = 'and promotion_is_preorder = 20';
//        $dailydeal_preorder_str = 'and area_is_preorder = 20';
//    }else{
//        $promotion_preorder_str = 'and promotion_is_preorder = 10';
//        $dailydeal_preorder_str = 'and area_is_preorder = 10';
//    }

    if(!$preorder_status_change){
        $promotion_time_limit = 'AND zpp.pp_promotion_start_time < now()';
        $dailydeal_time_limit = 'and dailydeal_products_start_date < now()';
    }

    if(!$reback){
        $check_products_promotion_status_sql = 'SELECT zpp.pp_id, zpp.sale_while_stock_lasts FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zpp.pp_promotion_end_time > now() ' . $promotion_time_limit . ' and zp.promotion_status = 1 ' . $promotion_preorder_str . ' and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . $products_id;
        $check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);

        if($check_products_promotion_status_query->RecordCount() > 0){
            while(!$check_products_promotion_status_query->EOF){
                $pp_id = $check_products_promotion_status_query->fields['pp_id'];
                $db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 , pp_forbid_admin = "system" , pp_forbid_time = now() WHERE pp_id = ' . $pp_id);

                $check_products_promotion_status_query->MoveNext();
            }
        }

        $check_products_deals_status_sql = 'SELECT zdp.dailydeal_promotion_id, zdp.sale_while_stock_lasts from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_end_date > NOW() ' . $dailydeal_time_limit . ' ' . $dailydeal_preorder_str . ' and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . $products_id;
        $check_products_deals_status_query = $db->Execute($check_products_deals_status_sql);

        if($check_products_deals_status_query->RecordCount() > 0){
            while (!$check_products_deals_status_query->EOF){
                $dailydeal_promotion_id = $check_products_deals_status_query->fields['dailydeal_promotion_id'];
                $db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 , dailydeal_forbid_admin = "system" , dailydeal_forbid_time = now() where dailydeal_promotion_id = ' . $dailydeal_promotion_id);

                $check_products_deals_status_query->MoveNext();
            }
        }
    }else{
        $reback_promotion_products_sql = 'SELECT zpp.pp_id, zpp.pp_products_id FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zpp.pp_promotion_start_time < now() AND zpp.pp_promotion_end_time > now() ' . $promotion_preorder_str . ' and zp.promotion_status = 1 and zpp.pp_is_forbid = 20 and pp_forbid_admin = "system" AND zpp.sale_while_stock_lasts = 20 and zpp.pp_products_id = ' . $products_id;
        $reback_promotion_products_query = $db->Execute($reback_promotion_products_sql);

        if($reback_promotion_products_query->RecordCount() > 0){
            while(!$reback_promotion_products_query->EOF){
                $pp_id = $reback_promotion_products_query->fields['pp_id'];
                $db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 10 , pp_forbid_admin = "system" , pp_forbid_time = now() WHERE pp_id = ' . $pp_id);

                $reback_promotion_products_query->MoveNext();
            }
        }

        $reback_dailydeal_products_sql = 'SELECT zdp.dailydeal_promotion_id, zdp.products_id from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() ' . $dailydeal_preorder_str . ' and dailydeal_is_forbid = 20 and dailydeal_forbid_admin = "system" and zda.area_status = 1 AND sale_while_stock_lasts = 20 and zdp.products_id = ' . $products_id;
        $reback_dailydeal_products_query = $db->Execute($reback_dailydeal_products_sql);

        if($reback_dailydeal_products_query->RecordCount() > 0){
            while(!$reback_dailydeal_products_query->EOF){
                $dailydeal_promotion_id = $reback_dailydeal_products_query->fields['dailydeal_promotion_id'];
                $db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 10 , dailydeal_forbid_admin = "system" , dailydeal_forbid_time = now() where dailydeal_promotion_id = ' . $dailydeal_promotion_id);

                $reback_dailydeal_products_query->MoveNext();
            }
        }

    }
    remove_product_memcache($products_id);
}

?>