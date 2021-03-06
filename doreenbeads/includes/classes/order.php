<?php
/**
 * File contains the order-processing class ("order")
 *
 * @package classes
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: order.php 7129 2007-09-29 03:03:04Z drbyte $
 */
/**
 * order class
 *
 * Handles all order-processing functions
 *
 * @package classes
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
class order extends base {
  var $info, $totals, $products, $customer, $delivery, $content_type, $email_low_stock, $products_ordered_attributes,
  $products_ordered, $products_ordered_email, $attachArray;
  //Tianwen.Wan20160624购物车优化，定义这样一个属性以方便传值，这样可以变量重复利用
  var $cart_products;
  function order($order_id = 0, $cart_products) {
    $this->info = array();
    $this->totals = array();
    $this->products = array();
    $this->customer = array();
    $this->delivery = array();
    
    if($cart_products != null) {
		$this->cart_products = $cart_products;
	}

    if (zen_not_null($order_id)) {
      $this->query($order_id);
    } else {
      $this->cart();
    }
  }

  /*
  function order_status_update
  paypal succ return
  author wei.liang
  version 2.0
  @param orders_id create orders id
  @param stauts succ return status
  */
   function order_status_update($order_id, $status, $payment_array=array(), $braintree_change_payment = true) {
      global $db;

      if (empty ( $order_id ))
         return;
      else {
         $order_query = "select orders_status, customers_id, customers_email_address, language_id, customers_name
                        from " . TABLE_ORDERS . "
                        where orders_id = " . $order_id . "";
         $result = $db->Execute ( $order_query );
         $class =& $_SESSION['payment'];
         
		if($_SESSION['payment'] == "gcCreditCard"){
			$GLOBALS[$class]->title = MODULE_PAYMENT_GCCREDITCARD_TEXT_HEAD;
			$GLOBALS[$class]->code = 'gcCreditCard';
		}
		
		if($_SESSION['payment'] == "QIWI"){
			$GLOBALS[$class]->title = MODULE_PAYMENT_QIWI_TEXT_HEAD;
			$GLOBALS[$class]->code = 'QIWI';
		}
		
		if($_SESSION['payment'] == "braintree"){
			$GLOBALS[$class]->title = MODULE_PAYMENT_BRAINTREE_TEXT_HEAD;
			$GLOBALS[$class]->code = $_SESSION['payment'];
		}

      if(isset($payment_array['payment_code']) && $payment_array['payment_code'] == "braintree"){
          $class = $payment_array['payment_code'];

          $GLOBALS[$class]->title = '<strong>Braintree ' . $payment_array['braintree_detail_code'] . '</strong>';
          $GLOBALS[$class]->code = $_SESSION['payment'] . '-' . $payment_array['braintree_detail_code'];
      }

         if($result->RecordCount()>0 && $status > 0){
             if(((int)$status == 2 || (int)$status == 42) && $_SESSION['payment'] == 'paypalwpp'){
                $sql_data_array = array('billing_name' => $this->billing['firstname'] . ' ' . $this->billing['lastname'],
                            'billing_company' => $this->billing['company'],
                            'billing_street_address' => $this->billing['street_address'],
                            'billing_suburb' => $this->billing['suburb'],
                            'billing_city' => $this->billing['city'],
                            'billing_postcode' => $this->billing['postcode'],
                            'billing_state' => $this->billing['state'],
                            'billing_country' => $this->billing['country']['title'],
                     'payment_method' => $GLOBALS[$class]->title,
                     'payment_module_code' => $GLOBALS[$class]->code,
                     'orders_status' => $status);
             }else{
                 $sql_data_array = array('orders_status' => $status);
                 if($braintree_change_payment){
                     $sql_data_array_temp = array('payment_method' => $GLOBALS[$class]->title,
                         'payment_module_code' => $GLOBALS[$class]->code);

                     $sql_data_array = array_merge($sql_data_array, $sql_data_array_temp);
                 }
             }
             // 增加字段，payment_info
             if((in_array($status, array(2, 42))) && !empty($payment_array['transaction_id'])) {
                $payment_info_array = array('payment_info'=>json_encode(array('transaction_id' => $payment_array['transaction_id'],'payment_method' => $GLOBALS[$class]->code, 'date_created' => date('Y-m-d H:i:s'))));
                $sql_data_array = array_merge($sql_data_array, $payment_info_array);
              }
             zen_db_perform(TABLE_ORDERS, $sql_data_array, 'update', "orders_id = " . $order_id . "");
             $now_time = date('Y-m-d H:i:s');
             $compare_time =  date('Y-m-10 00:00:00');
             if($now_time > $compare_time){
                $pay_time = date("Y-m-d H:i:s",strtotime("+2months"));
             }else{
                $pay_time = date("Y-m-d H:i:s",strtotime("+1months"));
             }
             $db->Execute("update " . TABLE_PROMETERS_COMMISSION_INFO . " set orders_pay_time ='" . $now_time . "',pay_time='" . $pay_time . "', commission_status = 1 where orders_id = " . $order_id);
             
             $coupon_customers_array = array('customers_id' => $result->fields['customers_id'], 'customers_email_address' => $result->fields['customers_email_address'], 'language_id' => $result->fields['language_id'], 'customers_name' => $result->fields['customers_name']);
             $send_coupon = send_coupon_for_first_order($order_id, $status, $coupon_customers_array);
         }else{
            if(!isset($status)){
               $sql_data_array = array('payment_method' => $GLOBALS[$class]->title,
                     'payment_module_code' => $GLOBALS[$class]->code);
             zen_db_perform(TABLE_ORDERS, $sql_data_array, 'update', "orders_id = " . $order_id . "");
            }

         }
     	include(DIR_WS_CLASSES . 'customers_group.php');
     	$customers_group = new customers_group();
     	$customers_group->correct_group($result->fields['customers_id']);
      }
   }

  function query($order_id) {
    global $db;

    $order_id = zen_db_prepare_input($order_id);

    $order_query = "select customers_id, customers_name, customers_company,
                         customers_street_address, customers_suburb, customers_city,
                         customers_postcode, customers_state, customers_country,
                         customers_telephone, customers_email_address, customers_address_format_id,
                         delivery_name, delivery_company, delivery_street_address, delivery_suburb,
                         delivery_city, delivery_postcode, delivery_state, delivery_country,
                         delivery_address_format_id, billing_name, billing_company,
                         billing_street_address, billing_suburb, billing_city, billing_postcode,
                         billing_state, billing_country, billing_address_format_id,
                         payment_method, payment_module_code, shipping_method, shipping_module_code,
                         coupon_code, cc_type, cc_owner, cc_number, cc_expires, currency, currency_value,delivery_tariff_number ,delivery_backup_email,
                         date_purchased, orders_status, last_modified, order_total, order_tax, ip_address, shipping_num,order_customers_group_pricing, 
                         customers_country_iso_code_2, delivery_country_iso_code_2, billing_country_iso_code_2, shipping_restriction_total 
                        from " . TABLE_ORDERS . "
                        where orders_id = " . $order_id . "";

    $order = $db->Execute($order_query);
    
    $totals_query = "select title, text, class, value
                         from " . TABLE_ORDERS_TOTAL . "
                         where orders_id = " . $order_id . "
                         order by sort_order";

    $totals = $db->Execute($totals_query);
    
    while (!$totals->EOF) {


      if ($totals->fields['class'] == 'ot_coupon') {
        $coupon_link_query = "SELECT coupon_id
                from " . TABLE_COUPONS . "
                where coupon_code ='" . $order->fields['coupon_code'] . "'";
        $coupon_link = $db->Execute($coupon_link_query);
        $zc_coupon_link = '<a href="javascript:couponpopupWindow(\'' . zen_href_link(FILENAME_POPUP_COUPON_HELP, 'cID=' . $coupon_link->fields['coupon_id']) . '\')">';
      }
//       $this->totals[] = array('title' => ($totals->fields['class'] == 'ot_coupon' ? $zc_coupon_link . $totals->fields['title'] . '</a>' : $totals->fields['title']),
//                               'text' => $totals->fields['text'],
//                               'class' => $totals->fields['class'],
// 										'value' => $totals->fields['value']);
            $this->totals[] = array('title' => $totals->fields['title'],
                                    'text' => $totals->fields['text'],
                                    'class' => $totals->fields['class'],
      										'value' => $totals->fields['value']);
      $totals->MoveNext();
    }

    $order_total_query = "select text, value
                             from " . TABLE_ORDERS_TOTAL . "
                             where orders_id = " . $order_id . "
                             and class = 'ot_total'";


    $order_total = $db->Execute($order_total_query);

    $shipping_method_query = "select title, value
                                from " . TABLE_ORDERS_TOTAL . "
                                where orders_id = " . $order_id . "
                                and class = 'ot_shipping'";
    $shipping_method = $db->Execute($shipping_method_query);
    $order_status_query = "select orders_status_name
                             from " . TABLE_ORDERS_STATUS . "
                             where orders_status_id = " . $order->fields['orders_status'] . "
                             and language_id = " . $_SESSION['languages_id'] . "";

    $order_status = $db->Execute($order_status_query);

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
                        'cc_expires' => $order->fields['cc_expires'],
                        'date_purchased' => $order->fields['date_purchased'],
                        'orders_status' => $order_status->fields['orders_status_name'],
                        'last_modified' => $order->fields['last_modified'],
                        'total' => $order->fields['order_total'],
                        'tax' => $order->fields['order_tax'],
                        'ip_address' => $order->fields['ip_address'],
                        'shippingNum' => $order->fields['shipping_num'],
    					'order_customers_group_pricing'=>$order->fields['order_customers_group_pricing'],
    					'orders_status_id'=>$order->fields['orders_status'],
    					'order_status'=>$order->fields['orders_status'],
    					'shipping_restriction_total' => $order->fields['shipping_restriction_total'],
                        );

    $this->customer = array('id' => $order->fields['customers_id'],
                            'name' => $order->fields['customers_name'],
                            'company' => $order->fields['customers_company'],
                            'street_address' => $order->fields['customers_street_address'],
                            'suburb' => $order->fields['customers_suburb'],
                            'city' => $order->fields['customers_city'],
                            'postcode' => $order->fields['customers_postcode'],
                            'state' => $order->fields['customers_state'],
							'country_iso_code_2' => $order->fields['customers_country_iso_code_2'],                            
							'country' => $order->fields['customers_country'],
                            'format_id' => $order->fields['customers_address_format_id'],
                            'telephone' => $order->fields['customers_telephone'],
                            'email_address' => $order->fields['customers_email_address']
    );

    $this->delivery = array('name' => $order->fields['delivery_name'],
                            'company' => $order->fields['delivery_company'],
                            'street_address' => $order->fields['delivery_street_address'],
                            'suburb' => $order->fields['delivery_suburb'],
                            'city' => $order->fields['delivery_city'],
                            'postcode' => $order->fields['delivery_postcode'],
                            'state' => $order->fields['delivery_state'],
                            'country_iso_code_2' => $order->fields['customers_country_iso_code_2'],
                            'country' => $order->fields['delivery_country'],
                            'format_id' => $order->fields['delivery_address_format_id'],
                            'telephone' => $order->fields['delivery_telephone'],
				    		'tariff_number' => $order->fields['delivery_tariff_number'],
				    		'backup_email_address' => $order->fields['delivery_backup_email']
    );

    if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
      $this->delivery = false;
    }

    $this->billing = array('name' => $order->fields['billing_name'],
                           'company' => $order->fields['billing_company'],
                           'street_address' => $order->fields['billing_street_address'],
                           'suburb' => $order->fields['billing_suburb'],
                           'city' => $order->fields['billing_city'],
                           'postcode' => $order->fields['billing_postcode'],
                           'state' => $order->fields['billing_state'],
                           'country_iso_code_2' => $order->fields['billing_country_iso_code_2'],
                           'country' => $order->fields['billing_country'],
                           'format_id' => $order->fields['billing_address_format_id']);

    $index = 0;
    $orders_products_query = "select orders_products_id, products_id, products_name,
                                 products_model, products_price, products_tax,
                                 products_quantity, final_price,
                                 onetime_charges,
                                 products_priced_by_attribute, product_is_free, products_discount_type,note,
                                 products_discount_type_from
                                  from " . TABLE_ORDERS_PRODUCTS . "
                                  where orders_id = " . $order_id . "
                                  order by products_model";

    $orders_products = $db->Execute($orders_products_query);

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

      $this->products[$index] = array('qty' => $new_qty,
                                      'id' => $orders_products->fields['products_id'],
                                      'name' => $orders_products->fields['products_name'],
                                      'model' => $orders_products->fields['products_model'],
                                      'tax' => $orders_products->fields['products_tax'],
                                      'price' => $orders_products->fields['products_price'],
                                      'final_price' => $orders_products->fields['final_price'],
                                      'onetime_charges' => $orders_products->fields['onetime_charges'],
                                      'products_priced_by_attribute' => $orders_products->fields['products_priced_by_attribute'],
                                      'product_is_free' => $orders_products->fields['product_is_free'],
      								  'note' => $orders_products->fields['note'],
                                      'products_discount_type' => $orders_products->fields['products_discount_type'],
                                      'products_discount_type_from' => $orders_products->fields['products_discount_type_from']);

      $subindex = 0;
      $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
                              options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                               where orders_id = " . $order_id . "
                               and orders_products_id = " . $orders_products->fields['orders_products_id'] . "";

      $attributes = $db->Execute($attributes_query);
      if ($attributes->RecordCount()) {
        while (!$attributes->EOF) {
          $this->products[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options'],
                                                                   'value' => $attributes->fields['products_options_values'],
                                                                   'prefix' => $attributes->fields['price_prefix'],
                                                                   'price' => $attributes->fields['options_values_price']);

          $subindex++;
          $attributes->MoveNext();
        }
      }

      $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

      $index++;
      $orders_products->MoveNext();
    }
  }

  function cart() {
    global $db, $currencies;

    $this->content_type = $_SESSION['cart']->get_content_type();

    $customer_address_query = "select c.customers_firstname, c.customers_lastname, c.customers_telephone,
                                    c.customers_email_address, ab.entry_company, ab.entry_street_address,
                                    ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id,
                                    z.zone_name, co.countries_id, co.countries_name,
                                    co.countries_iso_code_2, co.countries_iso_code_3,saler_remarks,
                                    co.address_format_id, ab.entry_state , ab.tariff_number , ab.backup_email_address
                                   from (" . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab )
                                   left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                   left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)
                                   where c.customers_id = " . $_SESSION['customer_id'] . "
                                   and ab.customers_id = " . $_SESSION['customer_id'] . "
                                   and c.customers_default_address_id = ab.address_book_id";

    $customer_address = $db->Execute($customer_address_query);
    
    //if no default address
    if($customer_address->RecordCount()==0){
        $customer_address_query = "select c.customers_firstname, c.customers_lastname, c.customers_gender,c.customers_telephone,
																		c.customers_email_address, ab.entry_company, ab.entry_street_address,
																		ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id,
																		z.zone_name, co.countries_id, co.countries_name,
																		co.countries_iso_code_2, co.countries_iso_code_3,saler_remarks,
																		co.address_format_id, ab.entry_state, ab.tariff_number , ab.backup_email_address 
																	 from (" . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab )
																	 left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
																	 left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)
																	 where c.customers_id = " . $_SESSION['customer_id'] . "
																	 and ab.customers_id = " . $_SESSION['customer_id'] . " limit 1";
        $customer_address = $db->Execute($customer_address_query);
    }

    $shipping_address = new stdClass();
    $shipping_address->fields = array();
    if(!empty($_SESSION['sendto'])) {
    	$shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,
                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,
                                    ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id,
                                    c.countries_id, c.countries_name, c.countries_iso_code_2,
                                    c.countries_iso_code_3, c.address_format_id, ab.entry_state,ab.entry_telephone , ab.tariff_number , ab.backup_email_address
                                   from " . TABLE_ADDRESS_BOOK . " ab
                                   left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                   left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)
                                   where ab.customers_id = " . $_SESSION['customer_id'] . "
                                   and ab.address_book_id = " . $_SESSION['sendto'];

    	$shipping_address = $db->Execute($shipping_address_query);
    }
    
	
	//Tianwen.Wan20160624购物车优化，$billing_address_query加入查询限制
	$billing_address = new stdClass();
	$billing_address->fields = array();
	if(!empty($_SESSION['billto'])) {
	    $billing_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,
	                                   ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,
	                                   ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id,
	                                   c.countries_id, c.countries_name, c.countries_iso_code_2,
	                                   c.countries_iso_code_3, c.address_format_id, ab.entry_state , ab.tariff_number , ab.backup_email_address
	                                  from " . TABLE_ADDRESS_BOOK . " ab
	                                  left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
	                                  left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)
	                                  where ab.customers_id = " . $_SESSION['customer_id'] . "
	                                  and ab.address_book_id = " . $_SESSION['billto'] . "";
	
	    $billing_address = $db->Execute($billing_address_query);
	}
    //STORE_PRODUCT_TAX_BASIS

    //Tianwen.Wan20160720->购物车优化，去掉税费
	/*
    switch (STORE_PRODUCT_TAX_BASIS) {
      case 'Shipping':

      $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                              from " . TABLE_ADDRESS_BOOK . " ab
                              left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                              where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                              and ab.address_book_id = '" . (int)($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'";
      $tax_address = $db->Execute($tax_address_query);
      break;
      case 'Billing':

      $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                              from " . TABLE_ADDRESS_BOOK . " ab
                              left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                              where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                              and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";
      $tax_address = $db->Execute($tax_address_query);
      break;
      case 'Store':
      if ($billing_address->fields['entry_zone_id'] == STORE_ZONE) {

        $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";
      } else {
        $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'";
      }
      $tax_address = $db->Execute($tax_address_query);
    }
    */


    $class =& $_SESSION['payment'];
    
    if($_SESSION['payment'] == "braintree"){
		$GLOBALS[$class]->title = MODULE_PAYMENT_BRAINTREE_TEXT_HEAD;
		$GLOBALS[$class]->code = $_SESSION['payment'];
	}

	$coupon_code = new stdClass();
	$coupon_code->fields = array();
	if (isset($_SESSION['cc_id']) && !empty($_SESSION['cc_id'])) {
		$coupon_code_query = "select coupon_code from " . TABLE_COUPONS . " where coupon_id = " . $_SESSION['cc_id'];
		$coupon_code = $db->Execute($coupon_code_query);
	}

    $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
                        'currency' => $_SESSION['currency'],
                        'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],
                        'payment_method' => $GLOBALS[$class]->title,
                        'payment_module_code' => $GLOBALS[$class]->code,
                        'coupon_code' => $coupon_code->fields['coupon_code'],
    //                          'cc_type' => (isset($GLOBALS['cc_type']) ? $GLOBALS['cc_type'] : ''),
    //                          'cc_owner' => (isset($GLOBALS['cc_owner']) ? $GLOBALS['cc_owner'] : ''),
    //                          'cc_number' => (isset($GLOBALS['cc_number']) ? $GLOBALS['cc_number'] : ''),
    //                          'cc_expires' => (isset($GLOBALS['cc_expires']) ? $GLOBALS['cc_expires'] : ''),
    //                          'cc_cvv' => (isset($GLOBALS['cc_cvv']) ? $GLOBALS['cc_cvv'] : ''),
                        'shipping_method' => $_SESSION['shipping']['title'] . ($_SESSION['shipping']['box_note'] != '' ? $_SESSION['shipping']['box_note'] : ''),
                        'shipping_module_code' => !$_SESSION['shipping']['is_virtual'] ? $_SESSION['shipping']['code'] : $_SESSION['shipping']['virtual_code'],
                        'shipping_cost' => $_SESSION['shipping']['final_cost'],
                        'is_remote' => $_SESSION['shipping']['is_remote'],
                        'subtotal' => 0,
                        'tax' => 0,
                        'total' => 0,
                        'tax_groups' => array(),
                        'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''),
                        'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . $_SERVER['REMOTE_ADDR'],
                        'is_virtual' => $_SESSION['shipping']['is_virtual'],
                        'virtual_code' => $_SESSION['shipping']['code']
                        );

    //print_r($GLOBALS[$class]);
    //echo $class;
    //print_r($GLOBALS);
    //echo $_SESSION['payment'];
    /*
    // this is set above to the module filename it should be set to the module title like Checks/Money Order rather than moneyorder
    if (isset($_SESSION['payment']) && is_object($_SESSION['payment'])) {
    $this->info['payment_method'] = $_SESSION['payment']->title;
    }
    */

/*
// bof: move below calculations
    if ($this->info['total'] == 0) {
      if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {
        $this->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;
      } else {
        $this->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;
      }
    }
    if (isset($GLOBALS[$class]) && is_object($GLOBALS[$class])) {
      if ( isset($GLOBALS[$class]->order_status) && is_numeric($GLOBALS[$class]->order_status) && ($GLOBALS[$class]->order_status > 0) ) {
        $this->info['order_status'] = $GLOBALS[$class]->order_status;
      }
    }
// eof: move below calculations
*/
    /* $telephone_number = $shipping_address->fields['entry_telephone'];
    $customers_telephone = $customer_address->fields['customers_telephone'];
    if(isset($customers_telephone) && zen_not_null($customers_telephone)){
    	if(isset($telephone_number) && zen_not_null($telephone_number)){
    		$customers_telephone_number = $telephone_number;
    	}else{
    		$customers_telephone_number = $customers_telephone;
    	}
    }else{
    	if(isset($telephone_number) && zen_not_null($telephone_number)){
    		$customers_telephone_number = $telephone_number;
    	}
    } */

    $customers_telephone_number = $customer_address->fields['customers_telephone'];
    //Tianwen.Wan20161122->仿照8seasons逻辑
    if(!empty($shipping_address->fields['entry_telephone'])) {
    	$customers_telephone_number = $shipping_address->fields['entry_telephone'];
    }
    $this->customer = array('firstname' => $customer_address->fields['customers_firstname'],
                            'lastname' => $customer_address->fields['customers_lastname'],
                            'company' => $customer_address->fields['entry_company'],
                            'street_address' => $customer_address->fields['entry_street_address'],
                            'suburb' => $customer_address->fields['entry_suburb'],
                            'city' => $customer_address->fields['entry_city'],
                            'postcode' => $customer_address->fields['entry_postcode'],
                            'state' => ((zen_not_null($customer_address->fields['entry_state'])) ? $customer_address->fields['entry_state'] : $customer_address->fields['zone_name']),
                            'zone_id' => $customer_address->fields['entry_zone_id'],
                            'country' => array('id' => $customer_address->fields['countries_id'], 'title' => $customer_address->fields['countries_name'], 'iso_code_2' => $customer_address->fields['countries_iso_code_2'], 'iso_code_3' => $customer_address->fields['countries_iso_code_3']),
                            'format_id' => (int)$customer_address->fields['address_format_id'],
                            'telephone' => $customers_telephone_number,
                            'email_address' => $customer_address->fields['customers_email_address'],
    						'saler_remarks' => $customer_address->fields['saler_remarks']
    );

    $this->delivery = array('firstname' => $shipping_address->fields['entry_firstname'],
                            'lastname' => $shipping_address->fields['entry_lastname'],
                            'company' => $shipping_address->fields['entry_company'],
                            'street_address' => $shipping_address->fields['entry_street_address'],
                            'suburb' => $shipping_address->fields['entry_suburb'],
                            'city' => $shipping_address->fields['entry_city'],
                            'postcode' => $shipping_address->fields['entry_postcode'],
                            'state' => ((zen_not_null($shipping_address->fields['entry_state'])) ? $shipping_address->fields['entry_state'] : $shipping_address->fields['zone_name']),
                            'zone_id' => $shipping_address->fields['entry_zone_id'],
                            'country' => array('id' => $shipping_address->fields['countries_id'], 'title' => $shipping_address->fields['countries_name'], 'iso_code_2' => $shipping_address->fields['countries_iso_code_2'], 'iso_code_3' => $shipping_address->fields['countries_iso_code_3']),
                            'country_id' => $shipping_address->fields['entry_country_id'],
                            'format_id' => (int)$shipping_address->fields['address_format_id'],
    						'delivery_telephone' => $shipping_address->fields['entry_telephone'],
				    		'tariff_number' => $shipping_address->fields['tariff_number'],
				    		'backup_email_address' => $shipping_address->fields['backup_email_address']);

    $this->billing = array('firstname' => $billing_address->fields['entry_firstname'],
                           'lastname' => $billing_address->fields['entry_lastname'],
                           'company' => $billing_address->fields['entry_company'],
                           'street_address' => $billing_address->fields['entry_street_address'],
                           'suburb' => $billing_address->fields['entry_suburb'],
                           'city' => $billing_address->fields['entry_city'],
                           'postcode' => $billing_address->fields['entry_postcode'],
                           'state' => ((zen_not_null($billing_address->fields['entry_state'])) ? $billing_address->fields['entry_state'] : $billing_address->fields['zone_name']),
                           'zone_id' => $billing_address->fields['entry_zone_id'],
                           'country' => array('id' => $billing_address->fields['countries_id'], 'title' => $billing_address->fields['countries_name'], 'iso_code_2' => $billing_address->fields['countries_iso_code_2'], 'iso_code_3' => $billing_address->fields['countries_iso_code_3']),
                           'country_id' => $billing_address->fields['entry_country_id'],
                           'format_id' => (int)$billing_address->fields['address_format_id']);
                                                                                                    
    $index = 0;
	$promotion_total = 0;
	$stock_products = 0;
    //Tianwen.Wan20160624购物车优化
	//$products = $_SESSION['cart']->get_products();
	if($this->cart_products != null) {
		$products = $this->cart_products;
	} else {
		$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
		$products = $products_array['data'];
	}
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (($i/2) == floor($i/2)) {
        $rowClass="rowEven";
      } else {
        $rowClass="rowOdd";
      }
	  if($products[$i]['product_quantity']==0){
      	$stock_products++;
      }
      $this->products[$index] = array(
									  'customers_basket_id' => intval($products[$i]['customers_basket_id']),
									  'qty' => $products[$i]['quantity'],
									  'stock' => $products[$i]['product_quantity'],
                                      'name' => $products[$i]['name'],
                                      'model' => $products[$i]['model'],
                                      'tax' => zen_get_tax_rate($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']),
                                      'tax_description' => zen_get_tax_description($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']),
                                      'price' => $products[$i]['price'],
                                      'final_price' => $products[$i]['price'],
                                      'onetime_charges' => 0,
                                      'weight' => $products[$i]['weight'],
                                      'products_priced_by_attribute' => $products[$i]['products_priced_by_attribute'],
                                      'product_is_free' => $products[$i]['product_is_free'],
                                      'products_discount_type' => $products[$i]['products_discount_type'],
                                      'products_discount_type_from' => $products[$i]['products_discount_type_from'],
                                      'id' => $products[$i]['id'],
      								  'note' => $products[$i]['note'],
                                      'rowClass' => $rowClass);

      if ($products[$i]['attributes']) {
        $subindex = 0;
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          /*
          //clr 030714 Determine if attribute is a text attribute and change products array if it is.
          if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID){
          $attr_value = $products[$i]['attributes_values'][$option];
          } else {
          $attr_value = $attributes->fields['products_options_values_name'];
          }
          */

          $attributes_query = "select popt.products_options_name, poval.products_options_values_name,
                                          pa.options_values_price, pa.price_prefix
                                   from " . TABLE_PRODUCTS_OPTIONS . " popt,
                                        " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval,
                                        " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                   where pa.products_id = " . $products[$i]['id'] . "
                                   and pa.options_id = '" . (int)$option . "'
                                   and pa.options_id = popt.products_options_id
                                   and pa.options_values_id = '" . (int)$value . "'
                                   and pa.options_values_id = poval.products_options_values_id
                                   and popt.language_id = " . $_SESSION['languages_id'] . "
                                   and poval.language_id = " . $_SESSION['languages_id'];

          $attributes = $db->Execute($attributes_query);

          //clr 030714 Determine if attribute is a text attribute and change products array if it is.
          if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID){
            $attr_value = $products[$i]['attributes_values'][$option];
          } else {
            $attr_value = $attributes->fields['products_options_values_name'];
          }

          $this->products[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options_name'],
                                                                   'value' => $attr_value,
                                                                   'option_id' => $option,
                                                                   'value_id' => $value,
                                                                   'prefix' => $attributes->fields['price_prefix'],
                                                                   'price' => $attributes->fields['options_values_price']);

          $subindex++;
        }
      }

      // add onetime charges here
      //$_SESSION['cart']->attributes_price_onetime_charges($products[$i]['id'], $products[$i]['quantity'])

      /*********************************************
       * Calculate taxes for this product
       *********************************************/
//      $shown_price = (zen_add_tax($this->products[$index]['final_price'], $this->products[$index]['tax']) * $this->products[$index]['qty'])
//      + zen_add_tax($this->products[$index]['onetime_charges'], $this->products[$index]['tax']);
//      $this->info['subtotal'] += $shown_price;
//		$shown_price = (zen_add_tax($this->products[$index]['final_price'] * $this->info['currency_value'], $currencies->currencies[$_SESSION['currency']]['decimal_places'], $this->products[$index]['tax']) * $this->products[$index]['qty']) + zen_add_tax($this->products[$index]['onetime_charges'], $this->products[$index]['tax']);
      $shown_price = $currencies->format_cl(zen_add_tax ( $this->products [$index] ['final_price'], $this->products [$index] ['tax'] )) * $this->products[$index]['qty'];
		$this->info['subtotal'] += $currencies->format_cl($shown_price, true, 'USD' , 1/($this->info['currency_value']));
    
		$this->info['subtotal_show'] += $shown_price;

      // find product's tax rate and description
      $products_tax = $this->products[$index]['tax'];

      if(!get_with_vip($products[$i]['id'])){
      	$promotion_info = get_product_promotion_info($products[$i]['id']);
      	if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
      		$pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
      		if ($this->products[$index]['qty'] <= $pp_max_num_per_order) {
      			$promotion_total += $currencies->format_cl($shown_price, true, 'USD' , 1/($this->info['currency_value']));
      		}
      	}else{
      		$promotion_total += $currencies->format_cl($shown_price, true, 'USD' , 1/($this->info['currency_value']));
      	}
      }
      $products_tax_description = $this->products[$index]['tax_description'];

      if (DISPLAY_PRICE_WITH_TAX == 'true') {
        // calculate the amount of tax "inc"luded in price (used if tax-in pricing is enabled)
        $tax_add = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
      } else {
        // calculate the amount of tax for this product (assuming tax is NOT included in the price)
        $tax_add = zen_round(($products_tax / 100) * $shown_price, $currencies->currencies[$this->info['currency']]['decimal_places']);
      }
      $this->info['tax'] += $tax_add;
      if (isset($this->info['tax_groups'][$products_tax_description])) {
        $this->info['tax_groups'][$products_tax_description] += $tax_add;
      } else {
        $this->info['tax_groups'][$products_tax_description] = $tax_add;
      }
      /*********************************************
       * END: Calculate taxes for this product
       *********************************************/
      $index++;
    }
    /*订单分包 1为没有预定商品 2为部分预定商品 3为全部为预定商品*/
	unset($_SESSION['packing_tips_choose']);
    if($stock_products==0){
    	$_SESSION['packing_tips_choose']=1;
    }elseif($stock_products<$index){
    	$_SESSION['packing_tips_choose']=2;
    }elseif($stock_products==$index){
    	$_SESSION['packing_tips_choose']=3;
    }
    $this->info['promotion_total'] = $promotion_total;

    // Update the final total to include tax if not already tax-inc
    //姹澃淇敼锛岃繍璐逛笌鎶樻墸鍚堝苟
    if (DISPLAY_PRICE_WITH_TAX == 'true') {
      //$this->info['total'] = $this->info['subtotal']+ $this->info['shipping_cost'];
      $this->info['total'] = $this->info['subtotal'];

    } else {
      //$this->info['total'] = $this->info['subtotal'] + $this->info['tax'] + $this->info['shipping_cost'];
      $this->info['total'] = $this->info['subtotal'] + $this->info['tax'];
    }

/*
// moved to function create
    if ($this->info['total'] == 0) {
      if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {
        $this->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;
      } else {
        $this->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;
      }
    }
*/
    if (isset($GLOBALS[$class]) && is_object($GLOBALS[$class])) {
      if ( isset($GLOBALS[$class]->order_status) && is_numeric($GLOBALS[$class]->order_status) && ($GLOBALS[$class]->order_status > 0) ) {
        $this->info['order_status'] = $GLOBALS[$class]->order_status;
      }
    }

  }

  function create($zf_ot_modules, $order_data_success = array()) {
    global $db, $zco_notifier,$is_mobilesite;
    if ($this->info['total'] == 0) {
      if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {
        $this->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;
      } else {
        if ($_SESSION['payment'] != 'freecharger') {
          $this->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;
        }
      }
    }

    //if ($_SESSION['shipping'] == 'free_free') {
    //  $this->info['shipping_module_code'] = $_SESSION['shipping'];
    //}
	if(empty($this->info['shipping_module_code'])) {
		write_file("log/shopping_cart_log/", "create_order_" . date("Ymd") . ".txt",  date("Y-m-d H:i:s") . "\r\n" . var_export($_SESSION, true) . "\r\n-----------------------------\r\n\r\n");
		return 0;
	}
    if(!$_SESSION['channel']){
	    if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0){       
	    		$sql_group_pricing="select customers_group_pricing from ".TABLE_CUSTOMERS." where customers_id = ".$_SESSION['customer_id']."  limit 1";
	    		$res_group_pricing=$db->Execute($sql_group_pricing);
	    		$customers_group_pricing = $res_group_pricing->fields['customers_group_pricing'];
	    }
    }else{
    	$customers_group_pricing = 15;
    }
    
    $shipping_restriction_total = 0;
	if(isset($order_data_success['shipping_restriction_total'])) {
		$shipping_restriction_total = $order_data_success['shipping_restriction_total'];
	}

    $sql_data_array = array('customers_id' => $_SESSION['customer_id'],
                            'customers_name' => $this->customer['firstname'] . ' ' . $this->customer['lastname'],
                            'customers_company' => $this->customer['company'],
                            'customers_street_address' => $this->customer['street_address'],
                            'customers_suburb' => $this->customer['suburb'],
                            'customers_city' => $this->customer['city'],
                            'customers_postcode' => $this->customer['postcode'],
                            'customers_state' => $this->customer['state'],
                            'customers_country' => $this->customer['country']['title'],
                            'customers_country_iso_code_2' => $this->customer['country']['iso_code_2'],
                            'customers_telephone' => $this->customer['telephone'],
                            'customers_email_address' => $this->customer['email_address'],
                            'customers_address_format_id' => $this->customer['format_id'],
                            'delivery_name' => $this->delivery['firstname'] . ' ' . $this->delivery['lastname'],
                            'delivery_company' => $this->delivery['company'],
                            'delivery_street_address' => $this->delivery['street_address'],
                            'delivery_suburb' => $this->delivery['suburb'],
                            'delivery_city' => $this->delivery['city'],
                            'delivery_postcode' => $this->delivery['postcode'],
                            'delivery_state' => $this->delivery['state'],
                            'delivery_country' => $this->delivery['country']['title'],
                            'delivery_country_iso_code_2' => $this->delivery['country']['iso_code_2'],
                            'delivery_telephone' => $this->delivery['delivery_telephone'],
                            'delivery_address_format_id' => $this->delivery['format_id'],
                            'delivery_address_remote' => $this->info['is_remote'],
				    		'delivery_tariff_number' => $this->delivery['tariff_number'],
				    		'delivery_backup_email' => $this->delivery['backup_email_address'],
                            'billing_name' => $this->billing['firstname'] . ' ' . $this->billing['lastname'],
                            'billing_company' => $this->billing['company'],
                            'billing_street_address' => $this->billing['street_address'],
                            'billing_suburb' => $this->billing['suburb'],
                            'billing_city' => $this->billing['city'],
                            'billing_postcode' => $this->billing['postcode'],
                            'billing_state' => $this->billing['state'],
                            'billing_country' => $this->billing['country']['title'],
                            'billing_country_iso_code_2' => $this->billing['country']['iso_code_2'],
                            'billing_address_format_id' => $this->billing['format_id'],
                            'payment_method' => (($this->info['payment_module_code'] == '' and $this->info['payment_method'] == '') ? '' : $this->info['payment_method']),
                            'payment_module_code' => (($this->info['payment_module_code'] == '' and $this->info['payment_method'] == '') ? '' : $this->info['payment_module_code']),
                            'shipping_method' => $this->info['shipping_method'],
                            'shipping_module_code' => $this->info['shipping_module_code'],
                            'coupon_code' => $this->info['coupon_code'],
                            'cc_type' => $this->info['cc_type'],
                            'cc_owner' => $this->info['cc_owner'],
                            'cc_number' => $this->info['cc_number'],
                            'cc_expires' => $this->info['cc_expires'],
                            'date_purchased' => 'now()',
                            'orders_status' => $this->info['order_status'],
                            'order_total' => $this->info['total'],
                            'order_tax' => $this->info['tax'],
    						'order_customers_group_pricing'=>$customers_group_pricing,
                            'currency' => $this->info['currency'],
                            'currency_value' => $this->info['currency_value'],
                            'ip_address' => zen_get_ip_address(),
							'order_guid' => $_SESSION['order_guid'],
    						'seller_memo' => $this->customer['saler_remarks'],
                            'language_id' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
    						'from_mobile' => ($is_mobilesite ? 1 : 0),
    						'shipping_restriction_total' => $shipping_restriction_total
                            );
    zen_db_perform(TABLE_ORDERS, $sql_data_array);
    
    $insert_id = $db->Insert_ID();
    $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_HEADER', array_merge(array('orders_id' => $insert_id, 'shipping_weight' => $_SESSION['cart']->weight), $sql_data_array));


    // 联盟活动引入客户下单逻辑 --begin
    if(!empty($_SESSION['pliID'])){
         $sql = 'select is_old_customers from ' . TABLE_CUSTOMERS . ' where customers_id = ' . $_SESSION['customer_id'];
         $res = $db->Execute($sql);
         $is_old_customers = $res->fields['is_old_customers'];  
         $dropper_url = '?pli='.$_SESSION['pliID'];
         $customers_dropper_id_res = $db->Execute("select customers_dropper_id,payment_method,paypal from " . TABLE_PROMETERS_COMMISSION . " WHERE dropper_url ='" .$dropper_url."'");
         $in_customers_id_res = $db->Execute("select customers_dropper_id,in_customers_id from " .TABLE_PROMETERS_IN_CUSTOMERS . " where in_customers_id =" .$_SESSION['customer_id']);
         $in_customers_id = $in_customers_id_res->fields['in_customers_id'];
         $customers_dropper_id = $customers_dropper_id_res->fields['customers_dropper_id'];
         $payment_method = $customers_dropper_id_res->fields['payment_method'];
         $paypal = $customers_dropper_id_res->fields['paypal'];
         $commission_total_sql = 'select sum(return_commission_total) return_commission_total from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where customers_dropper_id = ' . $customers_dropper_id . ' and commission_status in(0,1,3,4)';
         $commission_total_res = $db->Execute($commission_total_sql);  
         $commission_total = $commission_total_res->fields['return_commission_total'];
         if($customers_dropper_id != $_SESSION['customer_id'] && $customers_dropper_id>0 && $is_old_customers == 0 && $commission_total <= 100000){
          if($in_customers_id == '') {
             $customers_sql = array('customers_dropper_id' => $customers_dropper_id,
                                    'in_customers_id' => $_SESSION['customer_id']
                                   );
             zen_db_perform(TABLE_PROMETERS_IN_CUSTOMERS, $customers_sql);
          
             $sql = array('customers_dropper_id' => $customers_dropper_id,
                          'orders_id' => $insert_id,
                          'in_orders_customers_name' => $this->delivery['firstname'] . ' ' . $this->delivery['lastname'],
                          'in_orders_total' => $this->info['total'],
                          'return_commission_total' => $this->info['total']*0.06,
                          'create_time' => 'now()',
                          'payment_method' => $payment_method,
                          'paypal' => $paypal
                         ); 
            zen_db_perform(TABLE_PROMETERS_COMMISSION_INFO, $sql);
          }
         }
     }

     $in_customers_id_res = $db->Execute("select customers_dropper_id,in_customers_id from " .TABLE_PROMETERS_IN_CUSTOMERS . " where in_customers_id =" .$_SESSION['customer_id']);
     $in_customers_id = $in_customers_id_res->fields['in_customers_id'];
     $customers_dropper_id = $in_customers_id_res->fields['customers_dropper_id'];
     $pay_sql = $db->Execute("select payment_method,paypal from " . TABLE_PROMETERS_COMMISSION . " WHERE customers_dropper_id ='" .$customers_dropper_id."'");
     $payment_method = $pay_sql->fields['payment_method'];
     $paypal = $pay_sql->fields['paypal'];
     if($customers_dropper_id > 0 ){
     $commission_total_sql = 'select sum(return_commission_total) return_commission_total from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where customers_dropper_id = ' . $customers_dropper_id . ' and commission_status in(0,1,3,4)';
         $commission_total_res = $db->Execute($commission_total_sql);  
         $commission_total = $commission_total_res->fields['return_commission_total'];
     }
     if($in_customers_id > 0  && empty($_SESSION['pliID']) && $commission_total < 100000){
       $sql = array('customers_dropper_id' => $customers_dropper_id,
                      'orders_id' => $insert_id,
                      'in_orders_customers_name' => $this->delivery['firstname'] . ' ' . $this->delivery['lastname'],
                      'in_orders_total' => $this->info['total'],
                      'return_commission_total' => $this->info['total']*0.06,
                      'create_time' => 'now()',
                      'payment_method' => $payment_method,
                      'paypal' => $paypal
                     );
        zen_db_perform(TABLE_PROMETERS_COMMISSION_INFO, $sql);
     }
   
    // 联盟活动引入客户下单逻辑--over

     
    for ($i=0, $n=sizeof($zf_ot_modules); $i<$n; $i++) {

      //update wei.liang
// 	  if($zf_ot_modules[$i]['code'] == 'ot_shipping'){
// 	    		$zf_ot_modules[$i]['value'] = 0;
// 	    		$zf_ot_modules[$i]['text'] = '';
// 	  }
	  //update wei.liang
	  /*add by weishuiliang fix ot_cash_account value not equal to text  start*/
	  if ($zf_ot_modules[$i]['code'] == 'ot_cash_account') {
	  	$zf_ot_modules[$i]['value'] = $_SESSION['current_used_cash'];
	  }
	  /*end*/
      $sql_data_array = array('orders_id' => $insert_id,
                              'title' => $zf_ot_modules[$i]['title'],
                              'text' => $zf_ot_modules[$i]['text'],
                              'value' => $zf_ot_modules[$i]['value'],
      						  //'value' => $_SESSION['current_used_cash'],
      		
                              'class' => $zf_ot_modules[$i]['code'],
                              'sort_order' => $zf_ot_modules[$i]['sort_order']);

      zen_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
	  if($zf_ot_modules[$i]['code'] == 'ot_cash_account'){
		  if ($zf_ot_modules[$i]['over_arg'] <> '' and zen_not_null($zf_ot_modules[$i]['over_arg'])) {
			 	 //$_SESSION["cash_account_addnum"];
	      	  $GLOBALS[$zf_ot_modules[$i]['code']]->over($zf_ot_modules[$i]['over_arg']);
	      	  if($_SESSION['current_used_cash']!='0'){
	      	  	$current_used_cash = zen_change_currency($_SESSION['current_used_cash'], 'USD', $_SESSION['currency']);
	      	  	$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create,from_order)
						  values (" . $_SESSION["customer_id"] . ", '" . (-$current_used_cash) . "', '" . $_SESSION['currency'] . "', 1, '" . date('Y-m-d H:i:s') . "', 'C','".sprintf(TEXT_CASH_CREATED_MEMO_1,$insert_id)."','1',$insert_id)");
	      	  }
			  if(isset($_SESSION["cash_account_addnum"])&&$_SESSION["cash_account_addnum"]>0){
			  	$cash_account_addnum = zen_change_currency($_SESSION["cash_account_addnum"], 'USD', $_SESSION['currency']);
	      	  	$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create)
							  values (" . $_SESSION["customer_id"] . ", '" . $cash_account_addnum . "',  '" . $_SESSION['currency'] . "', 1, '" . date('Y-m-d H:i:s') . "', 'A','created when place order','2')");
	      	  	unset($_SESSION["cash_account_addnum"]);
	      	  }
		  }
	  }
      $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDERTOTAL_LINE_ITEM', $sql_data_array);
    }
	switch($_SESSION['packing_way']){
      case 1:
         $comments_tips='#D5#';
         break;
      case 2:
         $comments_tips='#BD#';
         break;
      case 3:
         $comments_tips='#D15#';
         break;
      case 4:
         $comments_tips='#D#';
         break;
      case 5:
         $comments_tips='#15FA#';
         break;
      default:
         $comments_tips='#D5#';
	}
    $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
    $sql_data_array = array('orders_id' => $insert_id,
                            'orders_status_id' => $this->info['order_status'],
                            'date_added' => 'now()',
                            'customer_notified' => $customer_notification,
                            'comments' => $comments_tips.' '.$this->info['comments']);
    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
    
    if(get_with_channel()){
    	$db->Execute('update ' . TABLE_CHANNEL . ' set channel_status = 20 where channel_customers_id = ' . $_SESSION['customer_id']);
    }
	////锟斤拷锟斤拷状态为Processing时锟斤拷锟睫改客伙拷锟斤拷锟斤拷 customers_level
	////2010-12-10 on
    if ($this->info['order_status'] == 2 Or $this->info['order_status'] == 3 Or $this->info['order_status'] == 4 Or $this->info['order_status'] == 10){
    	if ($_SESSION['customers_level'] < CUSTOMERS_TOP_LEVEL && $_SESSION['customers_level'] < 20) {
    		$_SESSION['customers_level'] = 20;
    		zen_change_customers_level($_SESSION['customer_id'], $_SESSION['customers_level']);
    	}
    	//eof on
    }
    if ($this->info['order_status'] == 2){
		include(DIR_WS_CLASSES . 'customers_group.php');
    	$customers_group = new customers_group();
    	$customers_group->correct_group($_SESSION['customer_id']);
    }
    $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_COMMENT', $sql_data_array);
    return($insert_id);
  }

  function  create_add_products($zf_insert_id, $zf_mode = false) {
    global $db, $currencies, $order_total_modules, $order_totals, $zco_notifier;

	require_once('includes/modules/payment/paypal/paypal_functions.php');
    // initialized for the email confirmation
//	ipn_debug_email('Breakpoint: 51ak - OSH update done', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $this->products_ordered = '';
    $this->products_ordered_html = '';
    $this->subtotal = 0;
    $this->total_tax = 0;

    // lowstock email report
    $this->email_low_stock='';

		$_SESSION['order_guid'] = create_guid();
//    ipn_debug_email('Breakpoint: 52ak - for products', 'wei@8season.com', false, 'ipn debug from robbie 4');
    $products_bak = array();
    $customers_basket_id_array = array();
    foreach ($this->products as $products_bbb) {
        $products_bak[] = $products_bbb['model'];
    }     
    array_multisort($products_bak, SORT_ASC, $this->products);
    $products_shipping_restriction = get_products_shipping_restriction();
    $shipping_restriction_total = 0;
    for ($i=0, $n=sizeof($this->products); $i<$n; $i++) {
      if($this->products[$i]['qty'] <= 0) {
	    continue;
      }
      $custom_insertable_text = '';
      // Stock Update - Joao Correia
      // config STOCK_LIMITED==false
      if (STOCK_LIMITED == 'true') {
//	  	ipn_debug_email('Breakpoint: 521ak -Stock Limit = True', 'wei@8season.com', false, 'ipn debug from robbie 4');
//      config DOWNLOAD_ENABLED == false
        if (DOWNLOAD_ENABLED == 'true') {
		//jessa 2009-11-09 add "p.products_limit_stock"
          $stock_query_raw = "select  p.products_limit_stock,  pad.products_attributes_filename, p.product_is_always_free_shipping
                              from " . TABLE_PRODUCTS . " p
                              left join " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                               on p.products_id=pa.products_id
                              left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                               on pa.products_attributes_id=pad.products_attributes_id
                              WHERE p.products_id = " . zen_get_prid($this->products[$i]['id']);
//eof jessa 2009-11-09
          // Will work with only one option for downloadable products
          // otherwise, we have to build the query dynamically with a loop
          $products_attributes = $this->products[$i]['attributes'];
          if (is_array($products_attributes)) {
            $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
          }
          $stock_values = $db->Execute($stock_query_raw);
          $stock_values->fields['products_quantity'] = zen_get_products_stock($this->products[$i]['id']);
        } else {
          $stock_values = $db->Execute("select * from " . TABLE_PRODUCTS . " where products_id = " . zen_get_prid($this->products[$i]['id']));
          $stock_values->fields['products_quantity'] = zen_get_products_stock($this->products[$i]['id']);
        }

        $zco_notifier->notify('NOTIFY_ORDER_PROCESSING_STOCK_DECREMENT_BEGIN');

        if ($stock_values->RecordCount() > 0) {
          // do not decrement quantities if products_attributes_filename exists
		if ((DOWNLOAD_ENABLED != 'true') || $stock_values->fields['product_is_always_free_shipping'] == 2 || (!$stock_values->fields['products_attributes_filename']) )
		  {
            $stock_left = $stock_values->fields['products_quantity'] - $this->products[$i]['qty'];
            $this->products[$i]['stock_reduce'] = $this->products[$i]['qty'];
          } else {
            $stock_left = $stock_values->fields['products_quantity'];
          }
          //            $this->products[$i]['stock_value'] = $stock_values->fields['products_quantity'];
		 /*  if ($stock_values->fields['products_limit_stock'] == 1)
		  {
             $stock_left = $stock_values->fields['products_quantity'] - $this->products[$i]['qty'];
			 if ($stock_left <= $stock_values->fields['products_quantity_order_max']){
		  		$db->Execute("update " . TABLE_PRODUCTS . " set products_quantity_order_max = '" . $stock_left . "' where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");
			 }
          } */
          $db->Execute("update " . TABLE_PRODUCTS_STOCK . " set products_quantity = " . $stock_left . " where products_id = " . zen_get_prid($this->products[$i]['id']));
          //        if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
          if ($stock_left <= 0) {
            // only set status to off when not displaying sold out
            if (SHOW_PRODUCTS_SOLD_OUT == '0') {
              $db->Execute("update " . TABLE_PRODUCTS . " set products_status = 0 where products_id = " . zen_get_prid($this->products[$i]['id']));
            }
          }

          // for low stock email
          if ( $stock_left <= STOCK_REORDER_LEVEL ) {
            // WebMakers.com Added: add to low stock email
            $this->email_low_stock .=  'ID# ' . zen_get_prid($this->products[$i]['id']) . "\t\t" . $this->products[$i]['model'] . "\t\t" . $this->products[$i]['name'] . "\t\t" . ' Qty Left: ' . $stock_left . "\n";
          }
        }
      }

//jessa 2009-11-09 add the following code
	  else{
//	  	ipn_debug_email('Breakpoint: 53ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 4');
        if (DOWNLOAD_ENABLED == 'true') {
		//jessa 2009-11-09 add "p.products_limit_stock"
          $stock_query_raw = "select  p.products_limit_stock, pad.products_attributes_filename, p.product_is_always_free_shipping
                              from " . TABLE_PRODUCTS . " p
                              left join " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                               on p.products_id=pa.products_id
                              left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                               on pa.products_attributes_id=pad.products_attributes_id
                              WHERE p.products_id = " . zen_get_prid($this->products[$i]['id']);


          $products_attributes = $this->products[$i]['attributes'];
          if (is_array($products_attributes)) {
            $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
          }
          $stock_values = $db->Execute($stock_query_raw);
          $stock_values->fields['products_quantity'] = zen_get_products_stock($this->products[$i]['id']);
        } else {
          $stock_values = $db->Execute("select * from " . TABLE_PRODUCTS . " where products_id = " . zen_get_prid($this->products[$i]['id']));
          $stock_values->fields['products_quantity'] = zen_get_products_stock($this->products[$i]['id']);
        }

        $zco_notifier->notify('NOTIFY_ORDER_PROCESSING_STOCK_DECREMENT_BEGIN');

        if ($stock_values->RecordCount() > 0) {
          // do not decrement quantities if products_attributes_filename exists
		if ($stock_values->fields['products_limit_stock'] == 1 || $stock_values->fields['products_quantity']!=50000)
		  {
            $stock_left = $stock_values->fields['products_quantity'] - $this->products[$i]['qty'];
            $this->products[$i]['stock_reduce'] = $this->products[$i]['qty'];
          } else {
            $stock_left = $stock_values->fields['products_quantity'];
            $this->products[$i]['stock_reduce'] = $this->products[$i]['qty'];
          }
          /*Tianwen.Wan20150617，库存数量放在products_stock表了，该字段无需修改
		  if ($stock_left <= $stock_values->fields['products_quantity_order_max']){
		  	$db->Execute("update " . TABLE_PRODUCTS . " set products_quantity_order_max = '" . $stock_left . "' where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");
		  }
		  */
		  $stock_left=$stock_left<=0?0:$stock_left;
		  $db->Execute("update " . TABLE_PRODUCTS_STOCK . " set products_quantity = " . $stock_left . " where products_id = " . zen_get_prid($this->products[$i]['id']));
		  remove_product_memcache( zen_get_prid($this->products[$i]['id']));
          //        if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {

          if ($stock_left <= 0) {
            // only set status to off when not displaying sold out
            if (SHOW_PRODUCTS_SOLD_OUT == '0' || $stock_values->fields['products_limit_stock']==1) {
				$db->Execute("update " . TABLE_PRODUCTS . " set products_status = 0 where products_id = " . zen_get_prid($this->products[$i]['id']));
            }

             //backorder商品 不更新pp_is_forbid为20 cm add
            //zen_auto_update_promotion_products_status((int)$this->products[$i]['id']);
            if($stock_values->fields['products_limit_stock']==1){
                zen_auto_update_promotion_products_status((int)$this->products[$i]['id']);
            }

            	
            remove_product_memcache( $this->products[$i]['id']);
          }

          // for low stock email
          if ( $stock_left <= STOCK_REORDER_LEVEL ) {
            // WebMakers.com Added: add to low stock email
            $this->email_low_stock .=  'ID# ' . zen_get_prid($this->products[$i]['id']) . "\t\t" . $this->products[$i]['model'] . "\t\t" . $this->products[$i]['name'] . "\t\t" . ' Qty Left: ' . $stock_left . "\n";
          }
        }
	  }

      $zco_notifier->notify('NOTIFY_ORDER_PROCESSING_STOCK_DECREMENT_END');
	  $products_catetories_id = get_products_info_memcache(zen_get_prid($this->products[$i]['id']) , 'master_categories_id');
    $is_preorder = get_products_info_memcache(zen_get_prid($this->products[$i]['id']) , 'is_preorder');
      $is_shipping_restriction = 0;
	  if(isset($products_shipping_restriction[$this->products[$i]['id']]) && strstr($products_shipping_restriction[$this->products[$i]['id']]['shipping_code_str'], "," . $_SESSION['shipping']['code'] . ",") != "") {
		  $is_shipping_restriction = 1;
		  $shipping_restriction_total++;
	  }
      $sql_data_array = array('orders_id' => $zf_insert_id,
                              'products_id' => zen_get_prid($this->products[$i]['id']),
                              'products_model' => $this->products[$i]['model'],
                              'products_name' => ($this->products[$i]['stock']==0 ? TEXT_PREORDER.' ':'').$this->products[$i]['name'],
//                              'products_price' => $this->products[$i]['price'],
										'products_price' => zen_get_products_discount_price_qty(zen_get_prid($this->products[$i]['id']),$this->products[$i]['qty'],0,false),
                              'final_price' => $this->products[$i]['final_price'],
                              'products_weight_quick' =>  $this->products[$i]['weight'],
                              'products_categories_id' => $products_catetories_id,
                              'products_categories_name' => trim(get_category_info_memcache($products_catetories_id , 'categories_name')),
                              'products_description' => trim(zen_get_products_description(zen_get_prid($this->products[$i]['id']))),
                              'onetime_charges' => 0,
                              'products_tax' => $this->products[$i]['tax'],
                              'products_quantity' => $this->products[$i]['qty'],
                              'products_priced_by_attribute' => $this->products[$i]['products_priced_by_attribute'],
                              'product_is_free' => $this->products[$i]['product_is_free'],
                              'products_discount_type' => $this->products[$i]['products_discount_type'],
                              'products_discount_type_from' => $this->products[$i]['products_discount_type_from'],
							  'order_guid' => $_SESSION['order_guid'],
      						   'note' => $this->products[$i]['note'],
                              'products_prid' => $this->products[$i]['id'],
                              'is_shipping_restriction' => $is_shipping_restriction,
                            'is_backorder'  => ($this->products[$i]['stock']==0 ? 1 : 0),
                              'is_preorder' => $is_preorder
                    );
      zen_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
      get_deals_sold_info(zen_get_prid($this->products[$i]['id']), $this->products[$i]['qty']); // dailydeal 产品增加下单个数*3的sold值
      //chritmas gift
//	  if($this->products[$i]['id']==$_SESSION['gift_id']){
//	  	$db->Execute("update ".TABLE_CUSTOMERS." set has_gift=0 where customers_id='".(int)$_SESSION['customer_id']."'");
//	  	$_SESSION['customer_gift']=0;
//	  }
	  array_push($customers_basket_id_array, $this->products[$i]['customers_basket_id']);
	  
//	  ipn_debug_email('Breakpoint: 55ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 4');
      $order_products_id = $db->Insert_ID();

      $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_PRODUCT_LINE_ITEM', array_merge(array('orders_products_id' => $order_products_id), $sql_data_array));

      $zco_notifier->notify('NOTIFY_ORDER_PROCESSING_CREDIT_ACCOUNT_UPDATE_BEGIN');
      $order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM

      $zco_notifier->notify('NOTIFY_ORDER_PROCESSING_ATTRIBUTES_BEGIN');

      //------ bof: insert customer-chosen options to order--------
      $attributes_exist = '0';
      $this->products_ordered_attributes = '';
      if (isset($this->products[$i]['attributes'])) {
        $attributes_exist = '1';
        for ($j=0, $n2=sizeof($this->products[$i]['attributes']); $j<$n2; $j++) {
          if (DOWNLOAD_ENABLED == 'true') {
            $attributes_query = "select popt.products_options_name, poval.products_options_values_name,
                                 pa.options_values_price, pa.price_prefix,
                                 pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,
                                 pa.attributes_discounted, pa.attributes_price_base_included, pa.attributes_price_onetime,
                                 pa.attributes_price_factor, pa.attributes_price_factor_offset,
                                 pa.attributes_price_factor_onetime, pa.attributes_price_factor_onetime_offset,
                                 pa.attributes_qty_prices, pa.attributes_qty_prices_onetime,
                                 pa.attributes_price_words, pa.attributes_price_words_free,
                                 pa.attributes_price_letters, pa.attributes_price_letters_free,
                                 pad.products_attributes_maxdays, pad.products_attributes_maxcount, pad.products_attributes_filename
                                 from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " .
            TABLE_PRODUCTS_ATTRIBUTES . " pa
                                  left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                  on pa.products_attributes_id=pad.products_attributes_id
                                 where pa.products_id = " . zen_db_input($this->products[$i]['id']) . "
                                  and pa.options_id = '" . $this->products[$i]['attributes'][$j]['option_id'] . "'
                                  and pa.options_id = popt.products_options_id
                                  and pa.options_values_id = '" . $this->products[$i]['attributes'][$j]['value_id'] . "'
                                  and pa.options_values_id = poval.products_options_values_id
                                  and popt.language_id = " . $_SESSION['languages_id'] . "
                                  and poval.language_id = " . $_SESSION['languages_id'] . "";

            $attributes_values = $db->Execute($attributes_query);
          } else {
            $attributes_values = $db->Execute("select popt.products_options_name, poval.products_options_values_name,
                                 pa.options_values_price, pa.price_prefix,
                                 pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,
                                 pa.attributes_discounted, pa.attributes_price_base_included, pa.attributes_price_onetime,
                                 pa.attributes_price_factor, pa.attributes_price_factor_offset,
                                 pa.attributes_price_factor_onetime, pa.attributes_price_factor_onetime_offset,
                                 pa.attributes_qty_prices, pa.attributes_qty_prices_onetime,
                                 pa.attributes_price_words, pa.attributes_price_words_free,
                                 pa.attributes_price_letters, pa.attributes_price_letters_free
                                 from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                 where pa.products_id = " . $this->products[$i]['id'] . " and pa.options_id = '" . (int)$this->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$this->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = " . $_SESSION['languages_id'] . " and poval.language_id = " . $_SESSION['languages_id']);
          }

//	  	  ipn_debug_email('Breakpoint: 56ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 4');
          //clr 030714 update insert query.  changing to use values form $order->products for products_options_values.
          $sql_data_array = array('orders_id' => $zf_insert_id,
                                  'orders_products_id' => $order_products_id,
                                  'products_options' => $attributes_values->fields['products_options_name'],
          //                                 'products_options_values' => $attributes_values->fields['products_options_values_name'],
                                  'products_options_values' => $this->products[$i]['attributes'][$j]['value'],
                                  'options_values_price' => $attributes_values->fields['options_values_price'],
                                  'price_prefix' => $attributes_values->fields['price_prefix'],
                                  'product_attribute_is_free' => $attributes_values->fields['product_attribute_is_free'],
                                  'products_attributes_weight' => $attributes_values->fields['products_attributes_weight'],
                                  'products_attributes_weight_prefix' => $attributes_values->fields['products_attributes_weight_prefix'],
                                  'attributes_discounted' => $attributes_values->fields['attributes_discounted'],
                                  'attributes_price_base_included' => $attributes_values->fields['attributes_price_base_included'],
                                  'attributes_price_onetime' => $attributes_values->fields['attributes_price_onetime'],
                                  'attributes_price_factor' => $attributes_values->fields['attributes_price_factor'],
                                  'attributes_price_factor_offset' => $attributes_values->fields['attributes_price_factor_offset'],
                                  'attributes_price_factor_onetime' => $attributes_values->fields['attributes_price_factor_onetime'],
                                  'attributes_price_factor_onetime_offset' => $attributes_values->fields['attributes_price_factor_onetime_offset'],
                                  'attributes_qty_prices' => $attributes_values->fields['attributes_qty_prices'],
                                  'attributes_qty_prices_onetime' => $attributes_values->fields['attributes_qty_prices_onetime'],
                                  'attributes_price_words' => $attributes_values->fields['attributes_price_words'],
                                  'attributes_price_words_free' => $attributes_values->fields['attributes_price_words_free'],
                                  'attributes_price_letters' => $attributes_values->fields['attributes_price_letters'],
                                  'attributes_price_letters_free' => $attributes_values->fields['attributes_price_letters_free'],
                                  'products_options_id' => (int)$this->products[$i]['attributes'][$j]['option_id'],
                                  'products_options_values_id' => (int)$this->products[$i]['attributes'][$j]['value_id'],
                                  'products_prid' => $this->products[$i]['id']
                                  );

//	  	  ipn_debug_email('Breakpoint: 57ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 4');
          zen_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

          $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ATTRIBUTE_LINE_ITEM', $sql_data_array);

          if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values->fields['products_attributes_filename']) && zen_not_null($attributes_values->fields['products_attributes_filename'])) {
            $sql_data_array = array('orders_id' => $zf_insert_id,
                                    'orders_products_id' => $order_products_id,
                                    'orders_products_filename' => $attributes_values->fields['products_attributes_filename'],
                                    'download_maxdays' => $attributes_values->fields['products_attributes_maxdays'],
                                    'download_count' => $attributes_values->fields['products_attributes_maxcount'],
                                    'products_prid' => $this->products[$i]['id']
                                    );

            zen_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);

            $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ATTRIBUTE_DOWNLOAD_LINE_ITEM', $sql_data_array);
          }
          //clr 030714 changing to use values from $orders->products and adding call to zen_decode_specialchars()
          //        $this->products_ordered_attributes .= "\n\t" . $attributes_values->fields['products_options_name'] . ' ' . $attributes_values->fields['products_options_values_name'];
          $this->products_ordered_attributes .= "\n\t" . $attributes_values->fields['products_options_name'] . ' ' . zen_decode_specialchars($this->products[$i]['attributes'][$j]['value']);
        }
      }
      //------eof: insert customer-chosen options ----

//	ipn_debug_email('Breakpoint: 58ak -$custom_insertable_text' . $custom_insertable_text, 'wei@8season.com', false, 'ipn debug from robbie 5');
    $zco_notifier->notify('NOTIFY_ORDER_DURING_CREATE_ADD_PRODUCTS', $custom_insertable_text);
//	ipn_debug_email('Breakpoint: 582ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 5');

/* START: ADD MY CUSTOM DETAILS
 * 1. calculate/prepare custom information to be added to this product entry in order-confirmation.
 * 2. Add that data to the $this->products_ordered_attributes variable, using this sort of format:
 *      $this->products_ordered_attributes .=  {INSERT CUSTOM INFORMATION HERE};
 */
    $this->products_ordered_attributes .= ''; // $custom_insertable_text;
//	ipn_debug_email('Breakpoint: 583ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 5');

/* END: ADD MY CUSTOM DETAILS */
      // update totals counters
      $this->total_weight += ($this->products[$i]['qty'] * $this->products[$i]['weight']);
      $this->total_tax += zen_calculate_tax($total_products_price, $products_tax) * $this->products[$i]['qty'];
      $this->total_cost += $total_products_price;

      $zco_notifier->notify('NOTIFY_ORDER_PROCESSING_ONE_TIME_CHARGES_BEGIN');

      // build output for email notification
      $this->products_ordered .=  $this->products[$i]['qty'] . ' x ' . $this->products[$i]['name'] . ($this->products[$i]['model'] != '' ? ' (' . $this->products[$i]['model'] . ') ' : '') . ' = ' .
      $currencies->display_price($this->products[$i]['final_price'], $this->products[$i]['tax'], $this->products[$i]['qty']) .
      ($this->products[$i]['onetime_charges'] !=0 ? "\n" . TEXT_ONETIME_CHARGES_EMAIL . $currencies->display_price($this->products[$i]['onetime_charges'], $this->products[$i]['tax'], 1) : '') .
      $this->products_ordered_attributes . "\n";

//	  ipn_debug_email('Breakpoint: 585ak -product_id:'. $this->products[$i]['id'], 'wei@8season.com', false, 'ipn debug from robbie 5');
	  //jessa 2009-11-05 锟绞硷拷锟斤拷锟斤拷锟接诧拷品锟斤拷图片锟斤拷锟斤拷锟斤拷
	  $product_image_qry = $db->Execute("select products_image from " . TABLE_PRODUCTS . " where products_id = " . $this->products[$i]['id']);

//	  ipn_debug_email('Breakpoint: 586ak -image:' . $product_image_qry->recordCount(), 'wei@8season.com', false, 'ipn debug from robbie 5');
	  $product_image = $product_image_qry->fields['products_image'];

	  $products_info = get_products_info_memcache($this->products[$i]['id']);
	  $products_stocking_days = $products_info['products_stocking_days'];
	  ////paypal wps时锟斤拷锟斤拷锟缴帮拷锟斤拷睾锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷全锟斤拷锟斤拷锟斤拷锟斤拷
      $this->products_ordered_html .= '<tr>' . "\n" .
	  '<td align="center" width="30"><a href="' . HTTP_SERVER .'/index.php?main_page=product_info&products_id=' . $this->products[$i]['id'] . '" target="_bank">'
	  	  . '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 80, 80) . '"' . " alt='" . $this->products[$i]['model'] . "' title='" . $this->products[$i]['model']
	  . "' width='40' height='40'></a></td>" .
      '<td class="product-details" align="right" valign="top" width="30">' . $this->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
      '<td class="product-details" valign="top"><a href="' . HTTP_SERVER .'/index.php?main_page=product_info&products_id=' . $this->products[$i]['id'] . '" target="_bank">' . /*(($this->products[$i]['stock']==0&&!strstr($this->products[$i]['name'], 'text_preorder_class'))?TEXT_PREORDER.' ':'').*/nl2br($this->products[$i]['name']) . ($this->products[$i]['model'] != '' ? ' (' . nl2br($this->products[$i]['model']) . ') ' : '') . '</a>' . "\n" .
      '<nobr><small><em> '. nl2br($this->products_ordered_attributes) .'</em></small></nobr>'.($this->products[$i]['stock']==0 ? ($products_stocking_days > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57) : '').'</td>' . "\n" .
      '<td class="product-details-num" valign="top" align="right">' .
      $currencies->display_price($this->products[$i]['final_price'], $this->products[$i]['tax'], $this->products[$i]['qty']) .
      ($this->products[$i]['onetime_charges'] !=0 ?
      '</td></tr>' . "\n" . '<tr><td class="product-details">' . nl2br(TEXT_ONETIME_CHARGES_EMAIL) . '</td>' . "\n" .
      '<td>' . $currencies->display_price($this->products[$i]['onetime_charges'], $this->products[$i]['tax'], 1) : '') .
      '</td></tr>' . "\n";
//	  $this->products_ordered_html .= '<tr>' . "\n" .
//      '<td class="product-details" align="right" valign="top" width="30">' . $this->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
//      '<td class="product-details" valign="top">' . nl2br($this->products[$i]['name']) . ($this->products[$i]['model'] != '' ? ' (' . nl2br($this->products[$i]['model']) . ') ' : '') . "\n" .
//      '<nobr><small><em> '. nl2br($this->products_ordered_attributes) .'</em></small></nobr></td>' . "\n" .
//      '<td class="product-details-num" valign="top" align="right">' .
//      $currencies->display_price($this->products[$i]['final_price'], $this->products[$i]['tax'], $this->products[$i]['qty']) .
//      ($this->products[$i]['onetime_charges'] !=0 ?
//      '</td></tr>' . "\n" . '<tr><td class="product-details">' . nl2br(TEXT_ONETIME_CHARGES_EMAIL) . '</td>' . "\n" .
//      '<td>' . $currencies->display_price($this->products[$i]['onetime_charges'], $this->products[$i]['tax'], 1) : '') .
//      '</td></tr>' . "\n";
//	  ipn_debug_email('Breakpoint: 59ak -Stock Limit = false', 'wei@8season.com', false, 'ipn debug from robbie 7');
    }
//    $order_total_modules->apply_credit();//ICW ADDED FOR CREDIT CLASS SYSTEM
/*
	@$_SESSION['cart']->reset(false);
    if (isset($_SESSION['customer_id'])) {
    	//echo "delete shopping cart exit";exit;
	      $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
	               where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

	      $db->Execute($sql);

	      $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
	               where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

	      $db->Execute($sql);
    }
*/
    $zco_notifier->notify('NOTIFY_ORDER_AFTER_ORDER_CREATE_ADD_PRODUCTS');
    
    $return_data = array('success'=>1, 'customers_basket_id_array' => $customers_basket_id_array, 'shipping_restriction_total' => $shipping_restriction_total);
    return $return_data;
  }

 function reset_orderID($order_guid,$orders_id){
    global $db;
    $db->Execute("update  ".TABLE_ORDERS_PRODUCTS."  set orders_id = ".$orders_id." where order_guid = '".$order_guid."'");

 }
 function reset_cart($data = array()){
   global $db;
   @$_SESSION['cart']->reset(false);
    if (isset($_SESSION['customer_id'])) {
		$customers_basket_id_str = "";
		if(!empty($data) && !empty($data['customers_basket_id_array'])) {
			$customers_basket_id_str .= " and customers_basket_id in(" . implode($data['customers_basket_id_array'], ",") . ")";
		}
		//echo "delete shopping cart exit";exit;
		$sql = "delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = " . $_SESSION['customer_id'] . $customers_basket_id_str;

		$db->Execute($sql);

		/*
		$sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
						 where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

		$db->Execute($sql);
		*/
	}
 }


  function send_order_email($zf_insert_id, $zf_mode) {
    global $currencies, $order_totals, $db;

    //      print_r($this);
    //      die();
    if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL=='1') {

      // send an email

      $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;

      zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, array('EMAIL_MESSAGE_HTML' => nl2br($email_low_stock)),'low_stock');

    }

    // lets start with the email confirmation

    // make an array to store the html version

    $html_msg=array();

    //robbie 锟斤拷锟斤拷Email Subscribe锟斤拷息

    $is_book_email = $db->Execute('Select c.customers_newsletter From ' . TABLE_ORDERS . ' as o, ' . TABLE_CUSTOMERS . ' as c

    		Where o.orders_id = ' . zen_db_prepare_input($zf_insert_id) . ' And o.customers_id = c.customers_id');

   	if ($is_book_email->recordCount() == 1 and $is_book_email->fields['customers_newsletter'] == 0) {

    	$html_msg['EMAIL_SUBSCRIBE'] = '<font color="red"><b>*Kindly Note:</b></font> You are recommended to subscribe to our newsletter for our <b>Latest Sales, Holiday Promotions,

    		New Products Announcemets</b> and more before anyone else.<a href="http://eepurl.com/bbtJ" name = "subscribe_newsletter">Click to Subscribe>></a>';

   	}else{

   		$html_msg['EMAIL_SUBSCRIBE'] = '';

   	}

   	$html_msg['ORDER_TRACK_REMIND'] = EMAIL_ORDER_TRACK_REMIND;

    //intro area

    $email_order = EMAIL_TEXT_HEADER . EMAIL_TEXT_FROM . STORE_NAME . "\n\n" .

    $this->customer['firstname'] . ' ' . $this->customer['lastname'] . "\n\n" .

    EMAIL_THANKS_FOR_SHOPPING . "\n" . EMAIL_DETAILS_FOLLOW . "\n" .

    EMAIL_SEPARATOR . "\n" .

    EMAIL_TEXT_ORDER_NUMBER . ' ' . $zf_insert_id . "\n" .

    EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n" .

    EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";

    $html_msg['EMAIL_TEXT_HEADER']     = EMAIL_TEXT_HEADER;

    $html_msg['EMAIL_TEXT_FROM']       = EMAIL_TEXT_FROM;

    if($_SESSION['languages_id'] == 2){
		$html_msg['INTRO_STORE_NAME']      = '('.EMAIL_ORDER_NUMBER_SUBJECT.' '.$zf_insert_id.')' ;
	}else{
		$html_msg['INTRO_STORE_NAME']      = STORE_NAME;
	}

    $html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_SHOPPING;

/*

	paypal_offline_robbie wei

	display some extra information when use paypal offline

	2008-12-06

	*/

    $html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_SHOPPING;

    if ($this->info['payment_module_code'] == 'paypalmanually') {

    	$html_msg['EMAIL_THANKS_FOR_SHOPPING'] .= '<p class="important"><font color="red">And congratulations,

    	 	your order has been generated and listed in our back-end system. Hit on <a href="http://www.doreenbeads.com/index.php?main_page=page&id=103" target="_blank">PayPal

    	 	Manually Instruction</a>  to complete your payment if you have not

    	 	paid this order yet. </font></p>';

    }

    $html_msg['EMAIL_DETAILS_FOLLOW']  = EMAIL_DETAILS_FOLLOW;

    $html_msg['INTRO_ORDER_NUM_TITLE'] = EMAIL_TEXT_ORDER_NUMBER;

    $html_msg['INTRO_ORDER_NUMBER']    = $zf_insert_id;

    $html_msg['INTRO_DATE_TITLE']      = EMAIL_TEXT_DATE_ORDERED;

    $html_msg['INTRO_DATE_ORDERED']    = strftime(DATE_FORMAT_LONG) . '(Beijing Time (CST) +0800)';

    $html_msg['INTRO_URL_TEXT']        = EMAIL_TEXT_INVOICE_URL_CLICK;

    $html_msg['INTRO_URL_VALUE']       = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false);

    //comments area

    if ($this->info['comments']) {

      $email_order .= zen_db_output($this->info['comments']) . "\n\n";

      $html_msg['ORDER_COMMENTS'] = nl2br(zen_db_output($this->info['comments']));

    } else {

      $html_msg['ORDER_COMMENTS'] = '';

    }

    //products area

    $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .

    EMAIL_SEPARATOR . "\n" .

    $this->products_ordered .

    EMAIL_SEPARATOR . "\n";

    $html_msg['PRODUCTS_TITLE'] = EMAIL_TEXT_PRODUCTS;

    $html_msg['PRODUCTS_DETAIL']='<table class="product-details" border="0" width="100%" cellspacing="0" cellpadding="2">' . $this->products_ordered_html . '</table>';

    //order totals area

    $html_ot .= '<td class="order-totals-text" align="right" width="100%">' . '&nbsp;' . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' . '---------' .'</td> </tr>' . "\n" . '<tr>';
//   	if($order_totals[1]["code"]=='ot_shipping'){
//    unset($order_totals[1]);
//    var_dump($order_totals);
//   	}
//var_dump($order_totals);
    for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
// 	  if($order_totals[$i]['code']=='ot_shipping') continue;
      $email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";

      $html_ot .= '<td class="order-totals-text" align="right" width="100%">' . $order_totals[$i]['title'] . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' .($order_totals[$i]['text']) .'</td> </tr>' . "\n" . '<tr>';

    }
	//echo $html_ot; exit;
    $html_msg['ORDER_TOTALS'] = '<table border="0" width="100%" cellspacing="0" cellpadding="2">' . $html_ot . '</table>';

    //addresses area: Delivery

    $html_msg['HEADING_ADDRESS_INFORMATION']= HEADING_ADDRESS_INFORMATION;

    $html_msg['ADDRESS_DELIVERY_TITLE']     = EMAIL_TEXT_DELIVERY_ADDRESS;

    $html_msg['ADDRESS_DELIVERY_DETAIL']    = ($this->content_type != 'virtual') ? zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, '', "<br />") : 'n/a';
    
    $customers_telephone = new stdClass();
	$customers_telephone->fields = array();
	if(!empty($zf_insert_id)) {
		$customers_telephone=$db->Execute("SELECT customers_telephone FROM ".TABLE_ORDERS." WHERE orders_id=".$zf_insert_id);
	}
    
    $html_msg['ADDRESS_DELIVERY_DETAIL']      .="Tel:".$customers_telephone->fields['customers_telephone'];
    
    $html_msg['CHECKOUT_SHIPPING_ADDRESS'] = '<br /><span style="color:red;">' . TEXT_IMPORTANT_NOTE . ': </span>' . TEXT_PLEASE_KINDLY_CHECK . '<br /><br />';

    $html_msg['SHIPPING_METHOD_TITLE']      = HEADING_SHIPPING_METHOD;

    $html_msg['SHIPPING_METHOD_DETAIL']     = (zen_not_null($this->info['shipping_method'])) ? $this->info['shipping_method'] : 'n/a';


     if ($this->content_type != 'virtual') {

      $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .

      EMAIL_SEPARATOR . "\n" .

      zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], 0, '', "\n") ."Tel:".$customers_telephone->fields['customers_telephone']. "\n" . TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS;

    }



////addresses area: Billing

    ////Paypal_Offline_robbie wei

    ////20081205

    ////do not contain billing information in the mail when use paypal offline

    if ($this->info['payment_module_code'] != 'paypalmanually'){

    	//jessa 2010-02-08 delete about billing info

	    //$email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .

	    //EMAIL_SEPARATOR . "\n" .

	    //zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], 0, '', "\n") . "\n\n";

	    //$html_msg['ADDRESS_BILLING_TITLE']   = EMAIL_TEXT_BILLING_ADDRESS;

	    //$html_msg['ADDRESS_BILLING_DETAIL']  = zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, '', "<br />");

    }

    else {

    	//$html_msg['ADDRESS_BILLING_TITLE'] = "";

    	//$html_msg['ADDRESS_BILLING_DETAIL'] = "";

    	//eof jessa 2010-02-08
    }



    ////Paypal_Offline_robbie wei

    ////20081205

    ////do not contain payment information in the mail when use paypal offline

    global $db;

   	if ($this->info['payment_module_code'] == 'paypalmanually'){

   		//$email_order .= 'You pay the order from the offline paypal, as soon as we receive your money, we will mail you and deliver your item quickly! Thank you for your shopping.';

   		$email_order .= EMAIL_SEPARATOR . "\n";

   		$html_msg['PAYMENT_METHOD_TITLE']  = "";

   		$html_msg['PAYMENT_METHOD_DETAIL'] = "";

   		$html_msg['PAYMENT_METHOD_FOOTER'] = "";

   		$total_sql = "Select text from " . TABLE_ORDERS_TOTAL .

					 " Where orders_id = " . $zf_insert_id . " and class = 'ot_total'";

		$order_total = $db->Execute($total_sql);

		$total_text = $order_total->fields['text'];

		$ship = "Select shipping_method from " . TABLE_ORDERS .

				 " Where orders_id = " . $zf_insert_id . "";

		$ship = $db->Execute($ship);

		$ship_method = $ship->fields['shipping_method'];



		$html_msg['PAYPAL_OFFLINE_INFO'] = '<div id="congratulation" style="font:12px"><strong><a href name="PAYPAL_ERROR"></a>Congratulations!</strong></div>
<p class="importnat">Your order has been generated and listed in our back-end system.
  You can also check the order details by go to &quot;My Account&quot;, which is on the top-right of this page.
  <br />
  We also have sent an email with order detail to your registered email address.<br />
  <br />
</p>

<div id="orderinformation" style="background-color:#CCCCFF;font:12px">
	<strong>Your Order:Total Amount&Shiping Method </strong></div>
	<p>Total Amount for this order:<strong><font color="red">' . $total_text . '</font></strong><br />
	Shipping Method for this order:<strong><font color="red">' . $ship_method . '</font></strong><br />
	Now you need to send payment to us using PayPal manually! <br /><br />
</p>

<div id="payment" style="background-color:#CCCCFF;font:12px"><strong>Instructions for Payment by Paypal Manually</strong></div>

<p class="importnat">

	<font color="red"><strong>Firstly</strong></font>, log into your paypal account at

	 <a href="http://www.paypal.com" target="_blank"><font color="Green">www.paypal.com</font></a>. Click the button

	 <img src="/images/offline/send_money.bmp" alt="Send Money" width="77.5" height="18" />

	 in your account page.<br /><br />

	 <img src="/images/offline/send_money_main.bmp" alt="Paypal Main Page"

			width="387.9" height="172.8" /></p>

	 <br /><p class="importnat"> <font color="red"><strong>Secondly</strong></font>, you now come to the &quot;send money&quot; page.

	 Please put <strong>sale@doreenbeads.com</strong>in the To (email) box and fill out your total amount.

	 Choose the &quot;Goods&quot; option in &quot;Send money for&quot; frame. And then hit &quot;Continue&quot;

	 to the next page.<br /><br />

  <img src="/images/offline/send_money_content.bmp" alt="Paypal-Send Money Page" width="299.7"

  	height="421.2" /><br />

  <br /><font color="red"><strong>Thirdly</strong></font>, in this new page, please scroll your screen down to Email to recipient option. Input your order No. and our website in the Subject box (You can input the information here like this: Payment for my order No. -- on doreenbeads.com ). Lastly click "Send Money" button to complete your payment. <br /><br />

  <img src="/images/offline/send_money_email.bmp" alt="Paypal-Email Content"

  	width="565.2" height="238.5" />

  </p>

  <br /><p class="importnat"><font color="red"><strong>Finally</strong></font>, after checking successfully, please advise us with an

  email titled your subject information as soon as possible

  (My email address: <strong><a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a></strong>).

  Therefore we can arrange to send out your parcel promptly as our Finance Officer check the bill.

  <br /><p class="importnat">

  		<strong>If you still meet some problems, please feel free to contact us at sale@doreenbeads.com.

  			We are happy to assist. </strong><br /><br />

</p><br />';

	    //print_r($html_msg);

	    //die();

   	}
   	else
   	{
   		$html_msg['PAYPAL_OFFLINE_INFO'] = "";

   		if (is_object($GLOBALS[$_SESSION['payment']])) {

   			$email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .

   			EMAIL_SEPARATOR . "\n";

   			$payment_class = $_SESSION['payment'];

   			$email_order .= $GLOBALS[$payment_class]->title . "\n\n";

   			$email_order .= (isset($this->info['cc_type']) && $this->info['cc_type'] != '') ? $this->info['cc_type']
   								. "\n\n" : '';
   			$email_order .= ($GLOBALS[$payment_class]->email_footer) ? $GLOBALS[$payment_class]->email_footer
   								. "\n\n" : '';

    } else {

      $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .
      EMAIL_SEPARATOR . "\n";
      $email_order .= "\n\n";



    }

    $html_msg['PAYMENT_METHOD_TITLE']  = EMAIL_TEXT_PAYMENT_METHOD;

    $html_msg['PAYMENT_METHOD_DETAIL'] = (is_object($GLOBALS[$_SESSION['payment']]) ? $GLOBALS[$payment_class]->title : '' );

    $html_msg['PAYMENT_METHOD_FOOTER'] = (is_object($GLOBALS[$_SESSION['payment']]) && $GLOBALS[$payment_class]->email_footer != '') ? nl2br($GLOBALS[$payment_class]->email_footer) : $this->info['cc_type'];


}

      $html_msg['TEXT_EMAIL_NEWSLETTER'] = TEXT_EMAIL_NEWSLETTER;
      $email_order .= TEXT_EMAIL_NEWSLETTER;
   	////end of robbie wei

    // include disclaimer

    $email_order .= "\n-----\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";

    // include copyright

    $email_order .= "\n-----\n" . EMAIL_FOOTER_COPYRIGHT . "\n\n";
    while (strstr($email_order, '&nbsp;')) $email_order = str_replace('&nbsp;', ' ', $email_order);


	if($_SESSION ['languages_id']==2){
		$html_msg['EMAIL_FIRST_NAME'] = '';
		$html_msg['EMAIL_LAST_NAME'] = sprintf(EMAIL_GREET_MR, ucfirst($this->customer['lastname']));
    }else{

		$html_msg['EMAIL_FIRST_NAME'] = $this->customer['firstname'];
	    $html_msg['EMAIL_LAST_NAME'] = $this->customer['lastname'];

    }

    //  $html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;

    $html_msg['EXTRA_INFO'] = '';

//    echo('111Customer Name:' . $this->customer['firstname'] . ' ' . $this->customer['lastname']);
//    echo('<br/>222Email Addr:' . $this->customer['email_address']);
//    echo('<br/>333Subject:' . EMAIL_TEXT_SUBJECT . EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id);
//    echo('<br/>444$email_order:' . $email_order);
//    echo('<br/>555store_name:' . STORE_NAME);
//    echo('<br/>666EMAIL_FROM:' . EMAIL_FROM);
//    echo('<br/>777html:');
//    print_r($html_msg);
//    die();
    
    zen_mail($this->customer['firstname'] . ' ' . $this->customer['lastname'], $this->customer['email_address'], SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT .EMAIL_TEXT_HEADER. EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id, $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_confirm');
//zen_mail($this->customer['firstname'] . ' ' . $this->customer['lastname'], 'sale@doreenbeads.com', EMAIL_TEXT_SUBJECT . EMAIL_ORDER_NUMBER_SUBJECT . $email_display_id, $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout');
    // send additional emails

    if (SEND_EXTRA_ORDER_EMAILS_TO != '') {

      $extra_info=email_collect_extra_info('','', $this->customer['firstname'] . ' ' . $this->customer['lastname'], $this->customer['email_address'], $this->customer['telephone']);
      $html_msg['EXTRA_INFO'] = $extra_info['HTML'];

      if ($GLOBALS[$_SESSION['payment']]->auth_code || $GLOBALS[$_SESSION['payment']]->transaction_id) {
        $pmt_details = 'AuthCode: ' . $GLOBALS[$_SESSION['payment']]->auth_code . '  TransID: ' . $GLOBALS[$_SESSION['payment']]->transaction_id . "\n\n";
        $email_order = $pmt_details . $email_order;
        $html_msg['EMAIL_TEXT_HEADER'] = nl2br($pmt_details) . $html_msg['EMAIL_TEXT_HEADER'];
      }
	  $emai_array = explode(",", EMAIL_ARRAY);
  	  $send_to_email = $emai_array[(int)$_SESSION['languages_id']-1];
  	  if($send_to_email==""){
  	  	$send_to_email = $emai_array[0];
  	  }
  	  //Tianwen.Wan20160415->以前发给SEND_EXTRA_ORDER_EMAILS_TO
      zen_mail('', $send_to_email, SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT . ' ' . EMAIL_TEXT_HEADER . EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id,
     $email_order . $extra_info['TEXT'], STORE_NAME, $this->customer['email_address']/*EMAIL_FROM*/, $html_msg, 'checkout_service');
    }
  }

/*
send_succ_order_email
add: wei.liang
payment succ send order
$zf_insert_id (order_id)
**/
  function send_succ_order_email($zf_insert_id, $zf_mode) {
    global $currencies, $order_totals, $db;

    if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL=='1') {

      // send an email

      $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;


      zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, array('EMAIL_MESSAGE_HTML' => nl2br($email_low_stock)),'low_stock');

    }

    // lets start with the email confirmation

    // make an array to store the html version

    $html_msg=array();

    //robbie 锟斤拷锟斤拷Email Subscribe锟斤拷息

//     $is_book_email = $db->Execute('Select c.customers_newsletter From ' . TABLE_ORDERS . ' as o, ' . TABLE_CUSTOMERS . ' as c

//     		Where o.orders_id = ' . zen_db_prepare_input($zf_insert_id) . ' And o.customers_id = c.customers_id');

//    	if ($is_book_email->recordCount() == 1 and $is_book_email->fields['customers_newsletter'] == 0) {

//     	$html_msg['EMAIL_SUBSCRIBE'] = '';

//    	}else{

//    		$html_msg['EMAIL_SUBSCRIBE'] = '';

//    	}

   	$html_msg['ORDER_TRACK_REMIND'] = EMAIL_ORDER_TRACK_REMIND_NEW . "<br/><br/>" . TEXT_HOPE_TO_DO_MORE_KIND_BUSINESS;

    //intro area

     if($_SESSION['languages_id']==2){
    if ($this->customer['customers_gender']=='m' ) {
    	$email_name= sprintf(EMAIL_GREET_MR, ucfirst($this->customer['name']));
    }elseif($this->customer['customers_gender']=='f' ){
    	$email_name = sprintf(EMAIL_GREET_MS, ucfirst($this->customer['name']));
    }else{
    	$email_name= sprintf(EMAIL_GREET_MR, ucfirst($this->customer['name']));
    }
    }else{

  $email_name= $this->customer['name'];

    }



    $email_order = EMAIL_TEXT_HEADER . EMAIL_TEXT_FROM . 'Doreenbeads' . "\n\n" .

    $email_name. "\n\n" .

    EMAIL_THANKS_FOR_PAYMENT . "\n" . EMAIL_DETAILS_FOLLOW . "\n" .

    EMAIL_SEPARATOR . "\n" .

    EMAIL_TEXT_ORDER_NUMBER . ' ' . $zf_insert_id . "\n" .

    EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n" .

    EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";

    $html_msg['EMAIL_TEXT_HEADER']     = EMAIL_TEXT_PAYMENT_HEADER;

    $html_msg['EMAIL_TEXT_FROM']       = EMAIL_TEXT_FROM;

    $html_msg['INTRO_STORE_NAME']      = 'Doreenbeads';

    $html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_PAYMENT;

/*

	paypal_offline_robbie wei

	display some extra information when use paypal offline

	2008-12-06

	*/

//     $html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_PAYMENT;

//     if ($this->info['payment_module_code'] == 'paypalmanually') {

//     	$html_msg['EMAIL_THANKS_FOR_SHOPPING'] .= '';

//     }

//     $html_msg['EMAIL_DETAILS_FOLLOW']  = EMAIL_DETAILS_FOLLOW;

//     $html_msg['INTRO_ORDER_NUM_TITLE'] = EMAIL_TEXT_ORDER_NUMBER;

//     $html_msg['INTRO_ORDER_NUMBER']    = $zf_insert_id;

//     $html_msg['INTRO_DATE_TITLE']      = EMAIL_TEXT_DATE_ORDERED;

//     $html_msg['INTRO_DATE_ORDERED']    = strftime(DATE_FORMAT_LONG);

//     $html_msg['INTRO_URL_TEXT']        = EMAIL_TEXT_INVOICE_URL_CLICK;

//     $html_msg['INTRO_URL_VALUE']       = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false);

    //comments area

//     if ($this->info['comments']) {

//       $email_order .= zen_db_output($this->info['comments']) . "\n\n";

//       $html_msg['ORDER_COMMENTS'] = nl2br(zen_db_output($this->info['comments']));

//     } else {

//       $html_msg['ORDER_COMMENTS'] = '';

//     }

//     //products area
// 	for($i = 0; $i < sizeof($this->products); $i++){
// 		$product_image_qry = $db->Execute("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $this->products[$i]['id'] . "'");

// 	    $product_image = $product_image_qry->fields['products_image'];
// 		$this->products_ordered_html .= '<tr>' . "\n" .
// 			  '<td align="center" width="30"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,"products_id=".$this->products[$i]['id']."").'" target="_bank" ><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . DIR_WS_IMAGES . get_img_size($product_image, 80, 80) . '"' . " alt='" . $this->products[$i]['model'] . "' title='" . $this->products[$i]['model']  . "' width='40'></a></td>" .
// 			  '<td class="product-details" align="right" valign="top" width="30">' . $this->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
// 			  '<td class="product-details" valign="top"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,"products_id=".$this->products[$i]['id']."").'" target="_bank" >' .nl2br($this->products[$i]['name']) . ($this->products[$i]['model'] != '' ? ' (' . nl2br($this->products[$i]['model']) . ') ' : '') . '</a>' . "\n" .
// 			  '<nobr><small><em> '. nl2br($this->products_ordered_attributes) .'</em></small></nobr></td>' . "\n" .
// 			  '<td class="product-details-num" valign="top" align="right">' .
// 			  $currencies->display_price($this->products[$i]['final_price'], $this->products[$i]['tax'], $this->products[$i]['qty']) .
// 			  ($this->products[$i]['onetime_charges'] !=0 ?
// 			  '</td></tr>' . "\n" . '<tr><td class="product-details">' . nl2br(TEXT_ONETIME_CHARGES_EMAIL) . '</td>' . "\n" .
// 			  '<td>' . $currencies->display_price($this->products[$i]['onetime_charges'], $this->products[$i]['tax'], 1) : '') .
// 			  '</td></tr>' . "\n";
// 	}


    $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .

    EMAIL_SEPARATOR . "\n" .

    $this->products_ordered .

    EMAIL_SEPARATOR . "\n";

//     $html_msg['PRODUCTS_TITLE'] = EMAIL_TEXT_PRODUCTS;

//     $html_msg['PRODUCTS_DETAIL']='<table class="product-details" border="0" width="100%" cellspacing="0" cellpadding="2">' . $this->products_ordered_html . '</table>';

//     //order totals area

//     $html_ot .= '<td class="order-totals-text" align="right" width="100%">' . '&nbsp;' . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' . '---------' .'</td> </tr>' . "\n" . '<tr>';

//     for ($i=0, $n=sizeof($this->totals); $i<$n; $i++) {

//       $email_order .= strip_tags($this->totals[$i]['title']) . ' ' . strip_tags($this->totals[$i]['text']) . "\n";


// 	if($this->totals[$i]['class'] == 'ot_shipping'){
// 		 if ($this->info['subtotal'] < MODULE_ORDER_TOTAL_SHIPPING_DISCOUNT_SUBTOTAL){
// 			$shipping_discount_title = sprintf(TEXT_SHIPPING_DISCOUNT, MODULE_ORDER_TOTAL_SHIPPING_DISCOUNT_BELOW . '%');
// 		 }else {
// 			$shipping_discount_title = sprintf(TEXT_SHIPPING_DISCOUNT, MODULE_ORDER_TOTAL_SHIPPING_DISCOUNT_BEYOND . '%');
// 		 }
// 		 if($this->totals[$i]['title'] == $shipping_discount_title . ': '){
// 			$order_totals_title = '<font color="red">' . $this->totals[$i]['title'] . '</font>';
// 			$order_totals_text = '<font color="red">' . $this->totals[$i]['text'] . '</font>';
// 		 }else{
// 			$order_totals_title = $this->totals[$i]['title'];
// 			$order_totals_text = $this->totals[$i]['text'];
// 		 }
// 	}else{
// 		$order_totals_title = $this->totals[$i]['title'];
// 		$order_totals_text = $this->totals[$i]['text'];
// 	}

//       $html_ot .= '<td class="order-totals-text" align="right" width="100%">' . $order_totals_title . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' .($order_totals_text) .'</td> </tr>' . "\n" . '<tr>';

//     }

//     $html_msg['ORDER_TOTALS'] = '<table border="0" width="100%" cellspacing="0" cellpadding="2">' . $html_ot . '</table>';
    //addresses area: Delivery

    $html_msg['HEADING_ADDRESS_INFORMATION']= HEADING_ADDRESS_TITLE . ':';

    $html_msg['ADDRESS_DELIVERY_TITLE']     = EMAIL_TEXT_DELIVERY_ADDRESS;

    $html_msg['ADDRESS_DELIVERY_DETAIL']    = ($this->content_type != 'virtual') ? zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, '', "<br />") : 'n/a';
    
	$customers_telephone = new stdClass();
	$customers_telephone->fields = array();
	if(!empty($zf_insert_id)) {
		$customers_telephone=$db->Execute("SELECT customers_telephone FROM ".TABLE_ORDERS." WHERE orders_id=".$zf_insert_id);
	}
    
    $html_msg['ADDRESS_DELIVERY_DETAIL']      .="Tel:".$customers_telephone->fields['customers_telephone'];

//     $html_msg['CHECKOUT_SHIPPING_ADDRESS'] = TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS;

//     $html_msg['SHIPPING_METHOD_TITLE']      = HEADING_SHIPPING_METHOD;

//     $html_msg['SHIPPING_METHOD_DETAIL']     = (zen_not_null($this->info['shipping_method'])) ? $this->info['shipping_method'] : 'n/a';


     if ($this->content_type != 'virtual') {

      $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .

      EMAIL_SEPARATOR . "\n" .

      zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], 0, '', "\n") ."Tel:".$customers_telephone->fields['customers_telephone']. "\n" . TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS;

    }



////addresses area: Billing

    ////Paypal_Offline_robbie wei

    ////20081205

    ////do not contain billing information in the mail when use paypal offline

    //if ($this->info['payment_module_code'] != 'paypalmanually'){

	    //$email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .

	    //EMAIL_SEPARATOR . "\n" .

	    //zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], 0, '', "\n") . "\n\n";

	    //$html_msg['ADDRESS_BILLING_TITLE']   = EMAIL_TEXT_BILLING_ADDRESS;

	    //$html_msg['ADDRESS_BILLING_DETAIL']  = zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, '', "<br />");

    //}

    //else {

    	//$html_msg['ADDRESS_BILLING_TITLE'] = "";

    	//$html_msg['ADDRESS_BILLING_DETAIL'] = "";

    //}



    ////Paypal_Offline_robbie wei

    ////20081205

    ////do not contain payment information in the mail when use paypal offline

    global $db;

   	if ($this->info['payment_module_code'] == 'paypalmanually'){

   		//$email_order .= 'You pay the order from the offline paypal, as soon as we receive your money, we will mail you and deliver your item quickly! Thank you for your shopping.';

   		$email_order .= EMAIL_SEPARATOR . "\n";

//    		$html_msg['PAYMENT_METHOD_TITLE']  = "";

//    		$html_msg['PAYMENT_METHOD_DETAIL'] = "";

//    		$html_msg['PAYMENT_METHOD_FOOTER'] = "";

   		$total_sql = "Select text from " . TABLE_ORDERS_TOTAL .

					 " Where orders_id = " . $zf_insert_id . " and class = 'ot_total'";

		$order_total = $db->Execute($total_sql);

		$total_text = $order_total->fields['text'];

		$ship = "Select shipping_method from " . TABLE_ORDERS .

				 " Where orders_id = " . $zf_insert_id;

		$ship = $db->Execute($ship);

		$ship_method = $ship->fields['shipping_method'];



// 		$html_msg['PAYPAL_OFFLINE_INFO'] = sprintf('',$total_text,$ship_method);

	    //print_r($html_msg);

	    //die();

   	}

   	else

   	{

   		$html_msg['PAYPAL_OFFLINE_INFO'] = "";

   		if (is_object($GLOBALS[$_SESSION['payment']])) {



   			$email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .



   			EMAIL_SEPARATOR . "\n";



   			$payment_class = $_SESSION['payment'];



   			$email_order .= $GLOBALS[$payment_class]->title . "\n\n";



   			$email_order .= (isset($this->info['cc_type']) && $this->info['cc_type'] != '') ? $this->info['cc_type']

   								. "\n\n" : '';



   			$email_order .= ($GLOBALS[$payment_class]->email_footer) ? $GLOBALS[$payment_class]->email_footer

   								. "\n\n" : '';



    } else {



      $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .



      EMAIL_SEPARATOR . "\n";



      //$email_order .= PAYMENT_METHOD_GV . "\n\n";
	  $email_order .= "\n\n";


    }

//     $html_msg['PAYMENT_METHOD_TITLE']  = EMAIL_TEXT_PAYMENT_METHOD;



//     $html_msg['PAYMENT_METHOD_DETAIL'] = (is_object($GLOBALS[$_SESSION['payment']]) ? $GLOBALS[$payment_class]->title : '' );



//     $html_msg['PAYMENT_METHOD_FOOTER'] = (is_object($GLOBALS[$_SESSION['payment']]) && $GLOBALS[$payment_class]->email_footer != '') ? nl2br($GLOBALS[$payment_class]->email_footer) : $this->info['cc_type'];


}

      $html_msg['TEXT_EMAIL_NEWSLETTER'] = TEXT_EMAIL_NEWSLETTER;
      $email_order .= TEXT_EMAIL_NEWSLETTER;
   	////end of robbie wei

    // include disclaimer

    $email_order .= "\n-----\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";

    // include copyright

    $email_order .= "\n-----\n" . EMAIL_FOOTER_COPYRIGHT . "\n\n";

    while (strstr($email_order, '&nbsp;')) $email_order = str_replace('&nbsp;', ' ', $email_order);

    if($_SESSION['languages_id']==2){
		$html_msg['EMAIL_FIRST_NAME'] = '';
		if ($this->customer['customers_gender']=='m' ) {
			$html_msg['EMAIL_LAST_NAME'] = sprintf(EMAIL_GREET_MR, ucfirst($this->customer['name']));
		}elseif($this->customer['customers_gender']=='f' ){
			$html_msg['EMAIL_LAST_NAME'] = sprintf(EMAIL_GREET_MS, ucfirst($this->customer['name']));
		}else{
			$html_msg['EMAIL_FIRST_NAME'] = $this->customer['name'];
			$html_msg['EMAIL_LAST_NAME'] = '';
		}
	}else{

    $html_msg['EMAIL_FIRST_NAME'] = $this->customer['name'];
	$html_msg['EMAIL_LAST_NAME'] = '';

    }


    //  $html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;

//     $html_msg['EXTRA_INFO'] = '';

    zen_mail($this->customer['name'], $this->customer['email_address'], sprintf(EMAIL_TEXT_SUBJECT  , $zf_insert_id), $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout');

    // send additional emails

    if (SEND_EXTRA_ORDER_EMAILS_TO != '') {

//       $extra_info=email_collect_extra_info('','', $this->customer['name'], $this->customer['email_address'], $this->customer['telephone']);

//       $html_msg['EXTRA_INFO'] = $extra_info['HTML'];

      if ($GLOBALS[$_SESSION['payment']]->auth_code || $GLOBALS[$_SESSION['payment']]->transaction_id) {

        $pmt_details = 'AuthCode: ' . $GLOBALS[$_SESSION['payment']]->auth_code . '  TransID: ' . $GLOBALS[$_SESSION['payment']]->transaction_id . "\n\n";

        $email_order = $pmt_details . $email_order;

        $html_msg['EMAIL_TEXT_HEADER'] = nl2br($pmt_details) . $html_msg['EMAIL_TEXT_HEADER'];

      }
	  $emai_array = explode(",",EMAIL_ARRAY);
  	  $send_to_email = $emai_array[(int)$_SESSION['languages_id']-1];
	    if($send_to_email==""){
	  		$send_to_email = $emai_array[0];
	  	}
      zen_mail('', TEXT_SERVICE_EMAIL, sprintf(EMAIL_TEXT_SUBJECT  , $zf_insert_id), $email_order . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_extra');

    }


  }
}


?>