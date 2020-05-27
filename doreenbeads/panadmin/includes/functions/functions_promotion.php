<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: general.php 14753 2009-11-07 19:58:13Z drbyte $
 */

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

function zen_auto_update_promotion_products_status($products_id, $reback = false, $is_preorder = false, $preorder_status_change = false){
    global $db, $memcache;

    $products_s_level_sql = 'select auto_id from ' . TABLE_PRODUCTS_S_LEVEL . ' where products_id = :products_id';
    $products_s_level_sql = $db->bindVars($products_s_level_sql, ':products_id', $products_id, 'integer');
    $products_s_level_query = $db->Execute($products_s_level_sql);

    if($products_s_level_query->RecordCount() > 0){
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