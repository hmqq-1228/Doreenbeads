<?php
/**
 * @package shippingMethod
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: table.php 4184 2006-08-21 03:36:36Z ajeh $
 */
/**
 * Enter description here...
 *
 */
class airmail {

  var $code;
  var $title;
  var $description;
  var $icon;
  var $enabled;

  function airmail() {
    global $order, $db;

    $this->code = 'airmail';
    $this->title = MODULE_SHIPPING_AIRMAIL_TEXT_TITLE;
    $this->description = MODULE_SHIPPING_AIRMAIL_TEXT_DESCRIPTION;
    $this->sort_order = MODULE_SHIPPING_AIRMAIL_SORT_ORDER;
    $this->icon = '';
    $this->tax_class = MODULE_SHIPPING_AIRMAIL_TAX_CLASS;
    $this->tax_basis = MODULE_SHIPPING_AIRMAIL_TAX_BASIS;
    
    // disable only when entire cart is free shipping
    if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_AIRMAIL_STATUS == 'True') ? true : false);
    }
    
  }
  /**
   * Enter description here...
   *
   * @param unknown_type $method
   * @return unknown
   */
  function quote($method = '', $adc_shipping_weight = 0, $dest_zone_id = '') {
    global $db, $order, $shipping_weight, $shipping_num_box, $shipping_total_weight;

    // echo $shipping_cost;
    if ($adc_shipping_weight == 0) $adc_shipping_weight = $shipping_total_weight;
    if ($dest_zone_id == '') $dest_zone_id = $order->delivery['country']['iso_code_2'];

	if($dest_zone_id == 'RU') return;

    $check_Record = $db->Execute ( "Select country_id 
										   From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "  
										  Where country_iso_code_2 = '" . $dest_zone_id . "' 
										    And (trans_type = 'airmail' or trans_type = 'airmail-zj')
										    And country_area_id = postage_area_id 
										    And (postage_trans_type = 'airmail' or postage_trans_type = 'airmail-zj') ");
     if($check_Record->RecordCount () ==0) return null;
	$shipping_cost= $this->calculate($dest_zone_id, $adc_shipping_weight, $shipping_num_box);
    $ems_recv_amt = $adc_shipping_weight * EMS_UK2KG_FEE * EMS_DISCOUNT / 2000;
    include_once(DIR_WS_MODULES . 'shipping/chinapost.php');
    $ems = new chinapost();
    
    $quotes_array = array();
    $quotes_array = $ems->quote();
    $ems_fee = $quotes_array['methods'][0]['cost'];

//	大于3公斤的包裹 挪SHIPPING_GIVE_BIG_ORDERD到大订单折扣中   0.1
	if ($adc_shipping_weight > MODULE_BIG_ORDER_DIST_MIN_WEIGHT) {
		$shipping_cost = $shipping_cost * (1 + SHIPPING_GIVE_BIG_ORDERD) - $ems_recv_amt;
	} else {
		$shipping_cost = $shipping_cost - $ems_recv_amt;
	}
    $deduction =0;
	// robbie 在指定重量下，如果客户选择该运送方式，可以得到的大订单折扣
	if ($adc_shipping_weight >= MODULE_BIG_ORDER_DIST_MIN_WEIGHT) {
		include_once(DIR_WS_MODULES . 'order_total/ot_big_orderd.php');
		$big_order_distd = new ot_big_orderd;
		
		$big_order_amt = $big_order_distd->calculate_deductions($dest_zone_id, $adc_shipping_weight, $this->code . '_' . $this->code, $errmsg);
		if ($big_order_amt > 0 ) $big_order_amt = 0;
		$deduction = $_SESSION['cart']->show_deduct_shippingfee();
	}
	
    $show_box_weight = ' Total Box Number: ' . $shipping_num_box;
	
	switch ($dest_zone_id){
    	case 'US' : $days = '18-28'; break;
    	case 'RU' : $days = '15-25'; break;
    	default : $days = '10-19';
    }

	$days = '15-25';
    
    $module_title = MODULE_SHIPPING_AIRMAIL_TEXT_TITLE . sprintf(MODULE_SHIPPING_AIRMAIL_SHIPPING_DAYS, $days);
    if($shipping_num_box>1) $module_title = str_replace(')',', ship in '.$shipping_num_box.' boxes)',$module_title);
  	
      if($deduction>0){
      	if(($shipping_cost+$deduction+$big_order_amt)>0&&($shipping_cost+$deduction+$big_order_amt)<5)
      	$cost = 0-$big_order_amt;
      	else 
      	$cost = $shipping_cost+$deduction;
      }
      else{
      		$cost = $shipping_cost+$deduction;
      }
    $this->quotes = array('id' => $this->code,
						  'module' => $module_title,
						  'methods' => array(array(
						                            'id' => $this->code,
												    'title' => '',
												    'cost' => $cost,
    												'big_orderd' => $big_order_amt
												    )));

    if ($this->tax_class > 0) {
      $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
    }

    if (zen_not_null($this->icon)) 
    	$this->quotes ['icon'] = zen_image ( $this->icon, $this->title );
    	//var_dump($this->quotes); exit;
		return $this->quotes;
		
	}
	/**
	 * calculate shipping fee here
	 *
	 * @return unknown
	 */
	function calculate($country = '', $shipping_total_weight, &$num_boxes = 1) {
		global $db;
		$err = false;
		$dest_zone_id = ($country == '') ? $order->delivery ['country'] ['iso_code_2'] : $country;
		$total_weight_kg = $shipping_total_weight / 1000;
		$big_airmail = $db->Execute("select * from t_bam_area where bam_country_iso2 = '" . $dest_zone_id . "'");

		//bof for airmail-zhejiang
		$trans_type = 'airmail';
		$airmail_discount = MODULE_SHIPPING_AIRMAIL_DISCOUNT;
		
		$method_query = $db->Execute("Select country_id  
										   From " . TABLE_AREA_COUNTRY . "
										  Where country_iso_code_2 = '" . $dest_zone_id ."' 
									    And trans_type = 'airmail-zj'");
		if ($method_query->RecordCount() > 0){
			$trans_type = 'airmail-zj';
			$airmail_discount = 70;
		}
		//eof

		$lds_max_weight = $db->Execute ( "Select shipping_weight  
										   From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "  
										  Where country_iso_code_2 = '" . $dest_zone_id . "' 
										    And trans_type = '" . $trans_type . "' 
										    And country_area_id = postage_area_id 
										    And postage_trans_type = '" . $trans_type . "' 
									   Order By shipping_weight desc limit 0, 1" );
		
		if ($lds_max_weight->RecordCount () == 1) {
			$ldc_pre_max_weight = $lds_max_weight->fields ['shipping_weight'];
		} else {
			$err = true; //没国家
		}
		if ($ldc_pre_max_weight > 0) {
			if ($total_weight_kg > $ldc_pre_max_weight) {
				$num_boxes = ceil ( $total_weight_kg / $ldc_pre_max_weight );
				$ldc_perbox_kgs = $total_weight_kg / $num_boxes;
			} else {
				$num_boxes = 1;
				$ldc_perbox_kgs = $total_weight_kg;
			}
		}
		
		$max_weight = $db->Execute ( "Select shipping_weight  
										   From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "  
										  Where country_iso_code_2 = '" . $dest_zone_id . "' 
										    And trans_type = '" . $trans_type . "' 
										    And country_area_id = postage_area_id 
										    And shipping_weight < '" . $ldc_perbox_kgs . "' 
										    And postage_trans_type = '" . $trans_type . "' 
									   Order By shipping_weight desc limit 0, 1" );
		
		if ($max_weight->RecordCount () == 1) {
			$ldc_max_weight = $max_weight->fields ['shipping_weight'];
		} else {
			$ldc_max_weight = 0;
		}
		
		$lds_shipping = $db->Execute ( "Select shipping_amount, postage_add_type, postage_increment, postage_add_price ,postage_area_id
										   From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "  
										  Where country_iso_code_2 = '" . $dest_zone_id . "' 
										    And trans_type = '" . $trans_type . "' 
										    And country_area_id = postage_area_id 
										    And shipping_weight >= '" . $ldc_perbox_kgs . "' 
										    And postage_trans_type = '" . $trans_type . "' 
									   Order By shipping_weight asc limit 0, 1" );
		$ldc_shipping_amount = $lds_shipping->fields ['shipping_amount'];
		$li_add_type = $lds_shipping->fields ['postage_add_type'];
		$ldc_increment = $lds_shipping->fields ['postage_increment'];
		$ldc_add_price = $lds_shipping->fields ['postage_add_price'];
		$post_area_id = $lds_shipping->fields['postage_area_id'];
//		if($post_area_id>=5)
//			$airmail_discount=100;
//		else $airmail_discount = MODULE_SHIPPING_AIRMAIL_DISCOUNT;
//		$airmail_discount = MODULE_SHIPPING_AIRMAIL_DISCOUNT;
		if ($lds_shipping->RecordCount () == 1) {
			if ($li_add_type == 0) {
				$ldc_shipping_cost = $ldc_shipping_amount;
			} elseif ($li_add_type == 1) {
				$li_weight_num = ceil ( ($ldc_perbox_kgs - $ldc_max_weight) / $ldc_increment );
				$ldc_shipping_cost = $ldc_shipping_amount + $li_weight_num * $ldc_add_price;
			} elseif ($li_add_type == 2) {
				if ($ldc_increment == 0) {
					$ldc_shipping_cost = $ldc_perbox_kgs * $ldc_add_price;
				} else {
					$ldc_shipping_cost = ceil ( $ldc_perbox_kgs / $ldc_increment ) * $ldc_add_price;
				}
			} else {
				$err = true; //出错
			}
		} else {
			$err = true; //没运费数据 
		}
		
		$shipping_cost = ($num_boxes * ($ldc_shipping_cost * (1 + MODULE_SHIPPING_AIRMAIL_OIL_EXTAR / 100) * ($airmail_discount / 100) + MODULE_SHIPPING_AIRMAIL_EXTRA)) / MODULE_SHIPPING_CHIANPOST_CURRENCY;
		$shipping_cost = $shipping_cost * 1.15;
		return $shipping_cost;
	
  }
  /**
   * Enter description here...
   *
   * @return unknown
   */
  function check() {
    global $db;
    
    if (!isset($this->_check)) {
      $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_AIRMAIL_STATUS'");
      $this->_check = $check_query->RecordCount();
    }
    
    return $this->_check;
  }
  /**
   * Enter description here...
   *
   */
  function install() {
    global $db;

    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable AIRMAIL Method', 'MODULE_SHIPPING_AIRMAIL_STATUS', 'True', 'Do you want to offer table rate shipping?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_AIRMAIL_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_AIRMAIL_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('US dollar to RMB Curreny','MODULE_SHIPPING_AIRMAIL_CURRENCY', '6.38680','Currency from US to RMB','6','0',now())");
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Discount for shipping cost','MODULE_SHIPPING_AIRMAIL_DISCOUNT', '38','100 for no discount, 90 allows 10% discount','6','0',now())");  
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Oil Rebates', 'MODULE_SHIPPING_AIRMAIL_OIL_EXTAR', '0', '6 for add 6% Oil Rebates.', '0', '0', now())");
  }
  /**
   * Enter description here...
   *
   */
  function remove() {
    global $db;
    $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
  }
  /**
   * Enter description here...
   *
   * @return unknown
   */
  function keys() {
    return array('MODULE_SHIPPING_AIRMAIL_STATUS','MODULE_SHIPPING_AIRMAIL_HANDLING',  'MODULE_SHIPPING_AIRMAIL_SORT_ORDER','MODULE_SHIPPING_AIRMAIL_CURRENCY','MODULE_SHIPPING_AIRMAIL_DISCOUNT', 'MODULE_SHIPPING_AIRMAIL_OIL_EXTAR');
  }
}         
?>