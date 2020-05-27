<?php
chdir("../");
require ("includes/application_top.php");

$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$language_code_array = array(
    1 => 'en',
    2 => 'de',
    3 => 'ru',
    4 => 'fr',
    5 => 'es',
    6 => 'jp',
    7 => 'it'
);

if(isset($_GET['action']) && $_GET['action'] == 'apportion'){
    $where = '';

    $synch_order_id_query = $db->Execute('SELECT MAX(order_id) moi FROM ' . TABLE_APPORTION_SYNCH_LOG);

    if($synch_order_id_query->RecordCount() > 0 && $synch_order_id_query->fields['moi'] > 0){
        $where = ' AND orders_id not in (
            select order_id
            from ' . TABLE_APPORTION_SYNCH_LOG . '
        )';
    }

    $order_info_query = $db->Execute('SELECT
                                        orders_id,
                                        from_mobile,
                                        customers_id,
                                        customers_email_address,
                                        delivery_name,
                                        delivery_street_address,
                                        delivery_suburb,
                                        delivery_country,
                                        delivery_state,
                                        delivery_city,
                                        delivery_postcode,
                                        delivery_address_remote,
                                        delivery_company,
                                        delivery_tariff_number,
                                        customers_telephone,
                                        order_total,
                                        currency,
                                        currency_value,
                                        shipping_module_code,
                                        g.group_percentage,
                                        seller_memo,
                                        payment_module_code,
                                        payment_info,
                                        language_id
                                    FROM
                                        ' . TABLE_ORDERS . ' o left join ' . TABLE_GROUP_PRICING . ' g on o.order_customers_group_pricing = g.group_id
                                    WHERE
                                        date_purchased >= "' . MODULE_APPORTION_START_DATETIME . '"
                                    ' . $where . '
                                    AND
                                        orders_status in (' . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ')');

    if($order_info_query->RecordCount() > 0){
        while (!$order_info_query->EOF){
            $order_info_array = array();
            $customers_id = $order_info_query->fields['customers_id'];
            $order_id = $order_info_query->fields['orders_id'];
            $currency = $order_info_query->fields['currency'];
            $currency_value = $order_info_query->fields['currency_value'];
            $payment_info = json_decode($order_info_query->fields['payment_info']);
            $club_id = $order_info_query->fields['club_id'];
            $language_id = $order_info_query->fields['language_id'];
            $language_code = $language_code_array[$language_id];
            $have_coupon = false;
            $order_subtotal = 0;
            $origin_shipping_fee = 0;
            $shipping_discount = 0;
            $coupon_discount = 0;
            $RCD_discount = 0;
            $VIP_discount = 0;
            $balance_discount = 0;
            $handing_fee = 0;
            $order_products_info = array();
            $products_final_price_sum = 0;
            $order_coupon_info = array();
            $order_regular_products_sum = 0;
            $order_preorder_products_sum = 0;
            $order_preorder_regular_products_sum = 0;
            $special_discount = 0;
            $order_subtotal = 0;
            $order_total = 0;
            $order_discount = 0;
            $manjian_discount = 0;
            $order_total_show = 0;
            $origin_shipping_fee_show = 0;
            $balance_discount_show = 0;
            $handing_fee_show = 0;

            $order_info_array = $order_info_query->fields;
            $order_info_array['payment_datetime'] = $payment_info->date_created;

            if($order_id > 0){
                $order_total_detail_query = $db->Execute('SELECT text, `value`, class FROM ' . TABLE_ORDERS_TOTAL . ' WHERE orders_id = "' . $order_id . '"');
                if($order_total_detail_query->RecordCount() > 0){
                    while(!$order_total_detail_query->EOF){
                        $order_total_value = round($order_total_detail_query->fields['value'] * $currency_value, 2);
                        $order_total_text = $order_total_detail_query->fields['text'];
                        $order_total_text_array = explode(' ', $order_total_text, 2);

                        if($currency != 'EUR'){
                            $order_total_text_value = trim($order_total_text_array[1]);
                            $order_total_text_value = str_replace(',', '', $order_total_text_value);
                        }else{
                            $order_total_text_value = trim($order_total_text_array[0]);
                            $order_total_text_value = str_replace(',', '.', $order_total_text_value);
                        }

                        $order_total_text_value = ltrim($order_total_text_value, '-');

                        switch ($order_total_detail_query->fields['class']){
                            case 'ot_subtotal':
                                $order_subtotal = $order_total_value;
                                break;
                            case 'ot_total':
                                $order_total = $order_total_value;
                                $order_total_show = $order_total_text_value;
                                break;
                            case 'ot_shipping':
                                $origin_shipping_fee = $order_total_value;
                                $origin_shipping_fee_show = $order_total_text_value;
                                break;
                            case 'ot_shipping_discount':
                                $shipping_discount = $order_total_value;
                                break;
                            case 'ot_discount_coupon'://coupon折扣
                                $coupon_discount = $order_total_value;
                                $have_coupon = true;
                                break;
                            case 'ot_order_discount'://订单折扣
                                $order_discount = $order_total_value;
                                break;
                            case 'ot_coupon'://RCD折扣
                                $RCD_discount = $order_total_value;
                                break;
                            case 'ot_group_pricing'://vip折扣
                                $VIP_discount = $order_total_value;
                                break;
                            case 'ot_cash_account'://balance折扣
                                $balance_discount = $order_total_value;
                                if($balance_discount > 0){
                                    $balance_discount_show = 0 - $order_total_text_value;
                                }else{
                                    $balance_discount_show = $order_total_text_value;
                                }
                                break;
                            case 'ot_handing_fee'://手续费
                                $handing_fee = $order_total_value;
                                $handing_fee_show = $order_total_text_value;
                                break;
                            case 'ot_promotion'://满减折扣
                                $manjian_discount = $order_total_value;
                                break;
                            case 'ot_big_orderd':
                                $special_discount = $order_total_value;;
                                break;
    //                        case 'ot_discount_amount':
    //                            $shipping_discount = $order_total_detail_query->fields['value'];
    //                            break;
                        }

                        $order_total_detail_query->MoveNext();
                    }

                    $final_shipping_fee = $origin_shipping_fee - $shipping_discount;

                    $order_package = '';
                    $order_package_query = $db->Execute('select comments from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_status_id = 1 and orders_id = ' . $order_id);
                    if($order_package_query->RecordCount() > 0){
                        $order_package = $order_package_query->fields['comments'];
                    }

                    $apportion_data_array = array(
                        'order_id' => $order_id,
                        'order_from' => $order_info_array['from_mobile'],
                        'customers_id' => $customers_id,
                        'customers_email_address' => $order_info_array['customers_email_address'],
                        'customers_group_pricing' => $order_info_array['group_percentage'],
                        'customers_fullname' => $order_info_array['delivery_name'],
                        'customers_telephone' => $order_info_array['customers_telephone'],
                        'order_delivery_address1' => $order_info_array['delivery_street_address'],
                        'order_delivery_address2' => $order_info_array['delivery_suburb'],
                        'order_delivery_company' => $order_info_array['delivery_company'],
                        'order_delivery_country' => $order_info_array['delivery_country'],
                        'order_delivery_state' => $order_info_array['delivery_state'],
                        'order_delivery_city' => $order_info_array['delivery_city'],
                        'order_delivery_postcode' => $order_info_array['delivery_postcode'],
                        'order_delivery_tariff_number' => $order_info_array['delivery_tariff_number'],
                        'order_delivery_is_remote' => $order_info_array['delivery_address_remote'],
                        'order_total' => $order_total_show,
                        'order_currency' => $currency,
                        'order_shipping_method' => $order_info_array['shipping_module_code'],
                        'seller_memo' => $order_info_array['seller_memo'],
                        'order_memo' => $order_package,
                        'order_shipping_fee' => $final_shipping_fee,
                        'order_balance' => $balance_discount_show,
                        'order_payment_info' => $order_info_array['payment_info'],
                        'order_payment_method_code' => $order_info_array['payment_module_code'],
                        'order_payment_datetime' => $order_info_array['payment_datetime'],
                        'language_id' => $language_code,
                        'order_handing_fee' => $handing_fee_show,
                        'order_special_discount' => $special_discount
                    );

                    $order_products_info_query = $db->Execute('SELECT
                                                                    orders_id,
                                                                    products_id,
                                                                    products_model,
                                                                    products_name,
                                                                    final_price,
                                                                    products_price,
                                                                    products_quantity,
                                                                    note,
                                                                    is_backorder,
                                                                    is_preorder
                                                                FROM
                                                                    ' . TABLE_ORDERS_PRODUCTS . '
                                                                WHERE
                                                                    orders_id = "' . $order_id . '"');

                    if($order_products_info_query->RecordCount() > 0){
                        while(!$order_products_info_query->EOF){
                            $xiaoshoumoshi = 0;
                            $products_id = $order_products_info_query->fields['products_id'];
                            $products_quantity = $order_products_info_query->fields['products_quantity'];
                            $order_products_info[$products_id] = $order_products_info_query->fields;
                            $final_price = $order_products_info_query->fields['final_price'];
                            $products_price = round($order_products_info_query->fields['products_price'], 2);
                            $products_final_sum_currency = $final_price * $products_quantity * $currency_value;
                            $products_name = get_products_description_memcache($products_id, $language_id);
                            $is_backorder = $order_products_info_query->fields['is_backorder'];
                            $is_preorder = $order_products_info_query->fields['is_preorder'];

//                            if($is_preorder == 1){
//                                $xiaoshoumoshi = 10;
//                            }else{
                                if($is_backorder == 1){
                                    $xiaoshoumoshi = 1;
                                }
//                            }

                            $order_products_info[$products_id]['xiaoshoumoshi'] = $xiaoshoumoshi;
                            $order_products_info[$products_id]['products_name'] = $products_name;

                            if($products_price != $final_price){
                                $order_products_info[$products_id]['is_promotion'] = true;
                            }else{
                                $order_products_info[$products_id]['is_promotion'] = false;
                                $order_regular_products_sum += $products_final_sum_currency;
                            }

                            if($order_products_info_query->fields['is_preorder'] == 1){
                                $order_preorder_products_sum += $products_final_sum_currency;
                            }

                            if($order_products_info_query->fields['is_preorder'] == 1 && !$order_products_info[$products_id]['is_promotion']){
                                $order_preorder_regular_products_sum += $products_final_sum_currency;
                            }

                            $order_products_info[$products_id]['final_sum'] = $products_final_sum_currency;
                            $products_final_price_sum += $products_final_sum_currency;


                            $order_products_info_query->MoveNext();
                        }

                        if($have_coupon){
                            $order_coupon_query = $db->Execute('SELECT
                                                                zc.with_promotion
                                                            FROM
                                                                ' . TABLE_COUPON_REDEEM_TRACK . ' zct
                                                            INNER JOIN ' . TABLE_COUPONS . ' zc ON zct.coupon_id = zc.coupon_id
                                                            WHERE
                                                                zct.order_id = "' . $order_id . '"
                                                            AND
                                                                zct.customer_id = "' . $customers_id . '"
                                                                ');
                            $coupon_genre = 10;
                            if($order_coupon_query->RecordCount() > 0){
//                                $coupon_genre = $order_coupon_query->fields['coupon_genre'];
                                $with_promotion = $order_coupon_query->fields['with_promotion'];
                            }
                        }

                        try{
                            foreach ($order_products_info as $pro_id => $pro_info){
                                $coupon_apportion_value = 0;
                                $order_apportion_proportion = 0;
                                $manjian_discount_approtion = 0;
                                $orders_discount_apportion = 0;
                                $vip_discount_apportion = 0;
                                $rcd_discount_apportion = 0;

                                if($have_coupon){
                                    if($coupon_genre == 10 && $with_promotion == 1){
                                        $coupon_apportion_value = $coupon_discount * ($pro_info['final_sum'] / $products_final_price_sum);
                                    }elseif ($coupon_genre == 10 && $with_promotion == 0){
                                        if(!$pro_info['is_promotion']){
                                            $coupon_apportion_value = $coupon_discount * ($pro_info['final_sum'] / $order_regular_products_sum);
                                        }
                                    }elseif ($coupon_genre == 20 && $with_promotion == 1){
                                        if($pro_info['is_preorder']){
                                            $coupon_apportion_value = $coupon_discount * ($pro_info['final_sum'] / $order_preorder_products_sum);
                                        }
                                    }elseif ($coupon_genre == 20 && $with_promotion == 0){
                                        if($pro_info['is_preorder'] && !$pro_info['is_promotion']){
                                            $coupon_apportion_value = $coupon_discount * ($pro_info['final_sum'] / $order_preorder_regular_products_sum);
                                        }
                                    }
                                }

                                if (!$pro_info['is_promotion']){
                                    $order_apportion_proportion = $pro_info['final_sum'] / $order_regular_products_sum;
                                    $manjian_discount_approtion = $manjian_discount * $order_apportion_proportion;
                                    $orders_discount_apportion = $order_discount * $order_apportion_proportion;
                                    $vip_discount_apportion = $VIP_discount * $order_apportion_proportion;
                                    $rcd_discount_apportion = $RCD_discount * $order_apportion_proportion;
                                }

                                $actual_price = ($pro_info['final_sum'] - $coupon_apportion_value - $manjian_discount_approtion - $orders_discount_apportion - $vip_discount_apportion - $rcd_discount_apportion) / $pro_info['products_quantity'];

                                $order_products_sql_data = array(
                                    'order_id' => $pro_info['orders_id'],
                                    'products_id' => $pro_info['products_id'],
                                    'products_model' => $pro_info['products_model'],
                                    'products_name' => addslashes($pro_info['products_name']),
                                    'final_price' => round($pro_info['final_price'] * $currency_value, 2),
                                    'actual_price' => substr(sprintf("%.3f",$actual_price),0,-1),
                                    'products_price' => round($pro_info['products_price'] * $currency_value, 2),
                                    'products_quantity' => $pro_info['products_quantity'],
                                    'products_remark' => $pro_info['note'],
                                    'is_backorder' => $pro_info['is_backorder'],
                                    'is_preorder' => $pro_info['is_preorder'],
                                    'sale_type' => $pro_info['xiaoshoumoshi']
                                );

                                zen_db_perform(TABLE_APPORTION_ORDER_PRODUCTS, $order_products_sql_data);
                            }

                            $order_apportion_log_data_array = array(
                                'order_id' => $order_id,
                                'synch_status' => 10,
                                'add_datetime' => 'now()'
                            );
                            zen_db_perform(TABLE_APPORTION_ORDER, $apportion_data_array);

                            zen_db_perform(TABLE_APPORTION_SYNCH_LOG, $order_apportion_log_data_array);

                            $db->commit();
                        }catch (Exception $e){
                            $db->rollback();
                        }
                    }
                }
            }

            $order_info_query->MoveNext();
        }


    }
}

echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>