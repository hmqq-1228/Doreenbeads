<?php
/** airmail Large-size Parcel
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
class airmaillp {

  var $code;

  var $title;

  var $description;

  var $icon;

  var $enabled;

  function airmaillp() {
    global $order, $db;

    $this->code = 'airmaillp';
    $this->title = MODULE_SHIPPING_AIRMAILLP_TEXT_TITLE;
    $this->description = MODULE_SHIPPING_AIRMAILLP_TEXT_DESCRIPTION;
    $this->sort_order = MODULE_SHIPPING_AIRMAILLP_SORT_ORDER;
    $this->icon = '';
    $this->tax_class = MODULE_SHIPPING_AIRMAILLP_TAX_CLASS;
    $this->tax_basis = MODULE_SHIPPING_AIRMAILLP_TAX_BASIS;
//    $this->credit_class = true;
    // disable only when entire cart is free shipping
    if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_AIRMAILLP_STATUS == 'True') ? true : false);
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
	if ($dest_zone_id == '') $dest_zone_id = $order->delivery['country']['iso_code_2'];
    // echo $shipping_cost;
    if ($adc_shipping_weight == 0) $adc_shipping_weight = $shipping_total_weight;
    $big_airmail = $db->Execute("select * from t_bam_area where bam_country_iso2 = '" . $dest_zone_id . "'");
    if($big_airmail->RecordCount () ==0 || $adc_shipping_weight<=2000) return null;
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
    
	// robbie 在指定重量下，如果客户选择该运送方式，可以得到的大订单折扣
	if ($adc_shipping_weight >= MODULE_BIG_ORDER_DIST_MIN_WEIGHT) {
		include_once(DIR_WS_MODULES . 'order_total/ot_big_orderd.php');
		$big_order_distd = new ot_big_orderd;
		
		$big_order_amt = $big_order_distd->calculate_deductions($dest_zone_id, $adc_shipping_weight, $this->code . '_' . $this->code, $errmsg);
		if ($big_order_amt > 0 ) $big_order_amt = 0;
	}
	
    $show_box_weight = ' Total Box Number: ' . $shipping_num_box;
    $module_title = MODULE_SHIPPING_AIRMAILLP_TEXT_TITLE;
    if($shipping_num_box>1) $module_title = str_replace(')',', ship in '.$shipping_num_box.' boxes)',$module_title);
  	$deduction = $_SESSION['cart']->show_deduct_shippingfee();
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
		$weight = ceil($shipping_total_weight / 1000);
		
		$fprice = $big_airmail->fields['bam_fprice'];
		$oprice = $big_airmail->fields['bam_oprice'];
		$box_max_weight = $big_airmail->fields['bam_box_weight'];
	    $num_boxes = ceil($weight / $box_max_weight);
	    $shipping_weight = $weight / $num_boxes;
		$shipping_cost = (($fprice + $oprice * ($shipping_weight - 1)) * MODULE_SHIPPING_AIRMAILLP_DISCOUNT/ 100 + 8) * $num_boxes
		/ MODULE_SHIPPING_AIRMAILLP_CURRENCY;
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
      $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_AIRMAILLP_STATUS'");
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

    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable AIRMAILLP Method', 'MODULE_SHIPPING_AIRMAILLP_STATUS', 'True', 'Do you want to offer table rate shipping?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
    //$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Shipping Table', 'MODULE_SHIPPING_AIRMAILLP_COST', '0.1:26,15', 'The shipping cost', '6', '0', 'zen_cfg_textarea(', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_AIRMAILLP_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_AIRMAILLP_SORT_ORDER', '1', 'Sort order of display.', '6', '0', now())");
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('US dollar to RMB Curreny','MODULE_SHIPPING_AIRMAILLP_CURRENCY', '6.38680','Currency from US to RMB','6','0',now())");
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Discount for shipping cost','MODULE_SHIPPING_AIRMAILLP_DISCOUNT', '85','100 for no discount, 90 allows 10% discount','6','0',now())");  	
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
    return array('MODULE_SHIPPING_AIRMAILLP_STATUS','MODULE_SHIPPING_AIRMAILLP_HANDLING',  'MODULE_SHIPPING_AIRMAILLP_SORT_ORDER','MODULE_SHIPPING_AIRMAILLP_CURRENCY','MODULE_SHIPPING_AIRMAILLP_DISCOUNT');
  }
}
?>