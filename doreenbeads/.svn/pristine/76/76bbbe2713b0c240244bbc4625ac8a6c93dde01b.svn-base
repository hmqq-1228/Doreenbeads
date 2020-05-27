<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: order.php 5784 2007-02-14 04:00:58Z ajeh $
 */

  class order {
  //jessa 2009-11-03 add "$weight_total"
    var $info, $totals, $products, $customer, $delivery, $weight_total;

    function order($order_id) {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();
	  $this->weight_total = array();//jessa 2009-11-03 add '$this->weight_total = array();'
      $this->query($order_id);
    }

    function query($order_id) {
      global $db;
      $order = $db->Execute("select cc_cvv, customers_name, customers_company, customers_street_address,
                                    customers_suburb, customers_city, customers_postcode, customers_id,
                                    customers_state, customers_country, customers_telephone,
                                    customers_email_address, customers_address_format_id, delivery_name,
                                    delivery_company, delivery_street_address, delivery_suburb,
                                    delivery_city, delivery_postcode, delivery_state, delivery_country,
                                    delivery_address_format_id, billing_name, billing_company,
                                    billing_street_address, billing_suburb, billing_city, billing_postcode,
                                    billing_state, billing_country, billing_address_format_id,
                                    coupon_code, payment_method, payment_module_code, shipping_method, shipping_module_code,
                                    cc_type, cc_owner, cc_number, cc_expires, currency,
                                    currency_value, date_purchased, orders_status, last_modified, delivery_tariff_number ,delivery_backup_email,
                                    order_total, order_tax, ip_address, seller_memo, delivery_telephone, shipping_num,order_customers_group_pricing ,payment_info,is_exported
                             from " . TABLE_ORDERS . "
                             where orders_id = " . $order_id);

      $totals = $db->Execute("select title, text, class, value
                              from " . TABLE_ORDERS_TOTAL . "
                              where orders_id = " . $order_id . "
                              order by sort_order");

//jessa 2009-11-03 add the following code 							  
	  $item_count = $db->Execute("select Count(*) as item_count, Sum(products_quantity) as item_sum

                              from " . TABLE_ORDERS_PRODUCTS . "

                              where orders_id = " . $order_id);
//eof jessa 2009-11-03

      while (!$totals->EOF) {
        $this->totals[] = array('title' =>  $totals->fields['title'],
                                'text' => $totals->fields['text'],
                                'class' => $totals->fields['class'],
        						'value' => $totals->fields['value']
       		 	);
        $totals->MoveNext();
      }
      $transaction_id = '';
      $payment_info = json_decode($order->fields['payment_info']);
      if($payment_info->transaction_id != ''){
      	$transaction_id = $payment_info->transaction_id ;
      }
	  
//jessa 2009-11-03 add the following code 	  
      $this->totals[] = array('title' => 'Item-Count:',
                              'text' => $item_count->fields['item_count'],
                              'class' => 'ot_total',
      						  'value' => $item_count->fields['item_count']
      );
							  
//eof jessa 2009-11-03

      $this->info = array('currency' => $order->fields['currency'],
                          'currency_value' => $order->fields['currency_value'],
                          'payment_method' => $order->fields['payment_method'],
                          'payment_module_code' => $order->fields['payment_module_code'],
                          'shipping_method' => $order->fields['shipping_method'],
                          'shipping_module_code' => $order->fields['shipping_module_code'],
                          'coupon_code' => $order->fields['coupon_code'],
                          'cc_type' => $order->fields['cc_type'],
                          'cc_owner' => $order->fields['cc_owner'],
                          'cc_number' => $order->fields['cc_number'],
                          'cc_cvv' => $order->fields['cc_cvv'],
                          'cc_expires' => $order->fields['cc_expires'],
                          'date_purchased' => $order->fields['date_purchased'],
                          'orders_status' => $order->fields['orders_status'],
                          'total' => $order->fields['order_total'],
                          'tax' => $order->fields['order_tax'],
                          'last_modified' => $order->fields['last_modified'],
                          'ip_address' => $order->fields['ip_address'],
						  'seller_memo' => $order->fields['seller_memo'],
						  'shippingNum' => $order->fields['shipping_num'],
						  'order_customers_group_pricing'=>$order->fields['order_customers_group_pricing'],
      					  'transaction_id'=>$transaction_id,
      					  'is_exported'=>$order->fields['is_exported']
                          );

      $this->customer = array('name' => $order->fields['customers_name'],
                              'id' => $order->fields['customers_id'],
                              'company' => $order->fields['customers_company'],
                              'street_address' => $order->fields['customers_street_address'],
                              'suburb' => $order->fields['customers_suburb'],
                              'city' => $order->fields['customers_city'],
                              'postcode' => $order->fields['customers_postcode'],
                              'state' => $order->fields['customers_state'],
                              'country' => $order->fields['customers_country'],
                              'format_id' => $order->fields['customers_address_format_id'],
                              'telephone' => $order->fields['customers_telephone'],
                              'email_address' => $order->fields['customers_email_address']);

      $this->delivery = array('name' => $order->fields['delivery_name'],
                              'company' => $order->fields['delivery_company'],
                              'street_address' => $order->fields['delivery_street_address'],
                              'suburb' => $order->fields['delivery_suburb'],
                              'city' => $order->fields['delivery_city'],
                              'postcode' => $order->fields['delivery_postcode'],
                              'state' => $order->fields['delivery_state'],
                              'country' => $order->fields['delivery_country'],
      						  'telephone' => $order->fields['delivery_telephone'],
                              'format_id' => $order->fields['delivery_address_format_id'],
							  'delivery_telephone' => $order->fields['delivery_telephone'],
      						  'tariff_number' => $order->fields['delivery_tariff_number'],
    						  'backup_email_address' => $order->fields['delivery_backup_email']
      );

      $this->billing = array('name' => $order->fields['billing_name'],
                             'company' => $order->fields['billing_company'],
                             'street_address' => $order->fields['billing_street_address'],
                             'suburb' => $order->fields['billing_suburb'],
                             'city' => $order->fields['billing_city'],
                             'postcode' => $order->fields['billing_postcode'],
                             'state' => $order->fields['billing_state'],
                             'country' => $order->fields['billing_country'],
                             'format_id' => $order->fields['billing_address_format_id']);

      $index = 0;
      $orders_products = $db->Execute( "SELECT orders_products_id, op.products_id, op.products_name, 
      									op.products_model,op.products_price,
      									 op.products_tax, op.products_quantity, 
      									p.products_weight, p.products_volume_weight AS volume_weight, p.products_image,
      									 final_price, onetime_charges, op.product_is_free, op.note, p.products_status 
      									FROM ".TABLE_ORDERS_PRODUCTS." AS op
									LEFT JOIN ".TABLE_PRODUCTS." AS p ON op.products_id = p.products_id
									WHERE op.orders_id = ".$order_id." ORDER BY products_model");

      
//jessa 2009-11-03 add the code "$sum_weight = 0;"									   
      $sum_weight = 0;
//eof jessa 2009-11-03
      $sum_volume_weight = 0;
      while (!$orders_products->EOF) {
// convert quantity to proper decimals - account history
          if (QUANTITY_DECIMALS != 0) {
            $fix_qty = $orders_products->fields['products_quantity'];
            switch (true) {
            case (!strstr($fix_qty, '.')):
              $new_qty = $fix_qty;
              break;
            default:
              $new_qty = preg_replace('/[0]+$/', '', $orders_products->fields['products_quantity']);
              break;
            }
          } else {
            $new_qty = $orders_products->fields['products_quantity'];
          }

          $new_qty = round($new_qty, QUANTITY_DECIMALS);

          if ($new_qty == (int)$new_qty) {
            $new_qty = (int)$new_qty;
          }

          $daily_deal_query = $db->Execute("select dailydeal_products_start_date, dailydeal_products_end_date, 
          									dailydeal_is_forbid, dailydeal_price 
          									from ".TABLE_DAILYDEAL_PROMOTION." zdp INNER JOIN " . TABLE_DAILYDEAL_AREA . " zda on zdp.area_id = zda.dailydeal_area_id 
          									where products_id=".$orders_products->fields['products_id']."
          									and dailydeal_is_forbid = 10
          									and zda.area_status = 1
          									and dailydeal_products_start_date<='".$order->fields['date_purchased']."'
          									and dailydeal_products_end_date>='".$order->fields['date_purchased']."'");
          
        $this->products[$index] = array('qty' => $new_qty,
                                        'id' => $orders_products->fields['products_id'],
                                        'name' => $orders_products->fields['products_name'],
                                        'model' => $orders_products->fields['products_model'],
                                        'tax' => $orders_products->fields['products_tax'],
                                        'price' => $orders_products->fields['products_price'],
                                        'onetime_charges' => $orders_products->fields['onetime_charges'],
                                        'final_price' => $orders_products->fields['final_price'],
										'weight' => $orders_products->fields['products_weight'],
        								'volume_weight' => $orders_products->fields['volume_weight'],
										'image' => $orders_products->fields['products_image'],
                                        'product_is_free' => $orders_products->fields['product_is_free'],
										'status' => $orders_products->fields['products_status'],
        								 'note' => $orders_products->fields['note'],
        								'dailydeal_promotion_start_time' => $daily_deal_query->fields['dailydeal_products_start_date'],	
        								'dailydeal_promotion_end_time' => $daily_deal_query->fields['dailydeal_products_end_date'],
        								'dailydeal_is_forbid' =>$daily_deal_query->fields['dailydeal_is_forbid'],
        								'dailydeal_price' =>$daily_deal_query->fields['dailydeal_price'],
        						);


        
		$sum_weight += $orders_products->fields['products_weight'] * $new_qty;
	    $sum_volume_weight += ( $orders_products->fields['volume_weight']==0 || $orders_products->fields['products_weight'] > $orders_products->fields['volume_weight'] ? $orders_products->fields['products_weight'] : $orders_products->fields['volume_weight'])*$new_qty;
		
//jessa 2009-11-03 add the following code �����װ���ϵ���������̨�������ã�--------------------		
		$configuration_value_array = '';
		
		$max_box_weight = $db->Execute("select configuration_value, configuration_key
										from " . TABLE_CONFIGURATION . "
										where configuration_key in ('SHIPPING_MAX_WEIGHT', 		
										'SHIPPING_BOX_WEIGHT', 'SHIPPING_BOX_PADDING')
										order by configuration_id");
		if ($max_box_weight->RecordCount()>0){
			while (!$max_box_weight->EOF){
				$configuration_value = $configuration_value . $max_box_weight->fields['configuration_value'] . ',';
				$max_box_weight->MoveNext();
			}
		}
		//echo $configuration_value;
		//die();
		
		$configuration_value_array = explode(',', $configuration_value);
		//echo $configuration_value_array[2];
		//die();
		$one_box_max_weight = $configuration_value_array[0];
		$extra_weight_to_small = $configuration_value_array[1];
		$extra_weight_to_large = $configuration_value_array[2];
		
		$extra_weight_to_small_array = explode(':', $extra_weight_to_small);
		$extra_weight_to_large_array = explode(':', $extra_weight_to_large);
		//echo $extra_weight_to_small_array[1];
		//die();
		if ($sum_weight < $one_box_max_weight){
			if ((int)$extra_weight_to_small_array[0] < (int)$extra_weight_to_small_array[1]){
				$extra_weight = (int)$extra_weight_to_small_array[1];
			}
			else{
				$extra_weight = (int)$extra_weight_to_small_array[0]/100 * $sum_weight;
			}
		}
		else{
			if ((int)$extra_weight_to_large_array[0] < (int)$extra_weight_to_large_array[1]){
				$extra_weight = (int)$extra_weight_to_large_array[1];
			}
			else{
				$extra_weight = (int)$extra_weight_to_large_array[0]/100 * $sum_weight;
			}
		}

//eof jessa 2009-11-03--------------------------------------------------------------------------

        $subindex = 0;
        $attributes = $db->Execute("select products_options, products_options_values, options_values_price,
                                           price_prefix,
                                           product_attribute_is_free
                                    from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                                    where orders_id = " . $order_id . "
                                    and orders_products_id = " . $orders_products->fields['orders_products_id']);
        if ($attributes->RecordCount()>0) {
          while (!$attributes->EOF) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options'],
                                                                     'value' => $attributes->fields['products_options_values'],
                                                                     'prefix' => $attributes->fields['price_prefix'],
                                                                     'price' => $attributes->fields['options_values_price'],
                                                                     'product_attribute_is_free' =>$attributes->fields['product_attribute_is_free']);

            $subindex++;
            $attributes->MoveNext();
          }
        }
        $index++;
        $orders_products->MoveNext();
      }
      //获取所有需要计算体积重量的配送方式
    $volume_query = $db->Execute('select code from t_shipping where cal_volume = 1 or (package_type=1 and package_weight_kg>0)');
        if ($volume_query->RecordCount() > 0){
            while (!$volume_query->EOF){
            	$arr_method_volume[] = $volume_query->fields['code'];
            	$volume_query->MoveNext();
            }
      }
      
      if (zen_not_null($arr_method_volume) && in_array($order->fields['shipping_module_code'], $arr_method_volume)){
      	$gross_weight = $sum_weight > $sum_volume_weight ? $sum_weight : $sum_volume_weight;
      	if ($sum_weight == $sum_volume_weight) $sum_volume_weight = 0;
      }else {
      	$gross_weight = $sum_weight;
      	$sum_volume_weight = 0;
      }
     
      $this->weight_total[] = array('title' => '<b>Products weight:</b> ',

	                                'text' => $sum_weight.' grams');
      
      $this->weight_total[] = array('title' => '<b>Volume weight:</b> ',
      
      								'text' => $sum_volume_weight.' grams');
      
      $this->weight_total[] = array('title' => '<b>Gross weight:</b> ',
      
      								'text' => $gross_weight.' grams');

      $this->weight_total[] = array('title' => '<b>Package box weight:</b> ',

	                                'text' => $gross_weight * ($gross_weight > 50000 ? 0.06 : 0.1).' grams');

      $this->weight_total[] = array('title' => '<b>Shipping weight:</b> ',

	                                'text' => $gross_weight * ($gross_weight > 50000 ? 1.06 : 1.1).' grams');
    }
  }
?>