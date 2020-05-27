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
class dhl {

  var $code;

  var $title;

  var $description;

  var $icon;

  var $enabled;

  function dhl() {
    global $order, $db;

    $this->code = 'dhl';
    $this->title = MODULE_SHIPPING_DHL_TEXT_TITLE;
    $this->description = MODULE_SHIPPING_DHL_TEXT_DESCRIPTION;
    $this->sort_order = MODULE_SHIPPING_DHL_SORT_ORDER;
    $this->icon = '';
    $this->tax_class = MODULE_SHIPPING_DHL_TAX_CLASS;
    $this->tax_basis = MODULE_SHIPPING_DHL_TAX_BASIS;
    
    // disable only when entire cart is free shipping
    if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_DHL_STATUS == 'True') ? true : false);
    }
    
  }
  /**
   * Enter description here...
   *
   * @param unknown_type $method
   * @return unknown
   */
   
  function quote($method = '') {
    global $shipping_weight, $shipping_num_boxes;

    $order_total = $shipping_weight;

    $table_cost = split("[:,]" , MODULE_SHIPPING_DHL_COST);
    $size = sizeof($table_cost);
   // echo $shipping_cost;
    
    if($size == 2){
    	$weight = $shipping_weight;
		$base = $weight>0?$table_cost[0]:0;
		
		if($weight > 0 && $weight <= 500){
			$shipping_cost = $table_cost[0];
		}else{
    		$addNum = $weight>0?ceil($weight/500 - 1):0;
    		$shipping_cost = $base + $addNum*$table_cost[1]*$shipping_num_boxes*MODULE_SHIPPING_DHL_DISCOUNT/MODULE_SHIPPING_DHL_CURRENCY/100;
		}
    }

    $show_box_weight = 'Max weight Per Box: 20 Kgs, Total Box Number: '.$shipping_num_boxes;
    $this->quotes = array('id' => $this->code,
						    'module' => MODULE_SHIPPING_DHL_TEXT_TITLE,
						    'methods' => array(array(
						                            'id' => $this->code,
												    'title' => $show_box_weight,
												    'cost' => $shipping_cost + MODULE_SHIPPING_DHL_HANDLING
												    )));

    if ($this->tax_class > 0) {
      $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
    }

    if (zen_not_null($this->icon)) 
    	$this->quotes['icon'] = zen_image($this->icon, $this->title);

    return $this->quotes;
  }
  /**
   * Enter description here...
   *
   * @return unknown
   */
  function check() {
    global $db;
    if (!isset($this->_check)) {
      $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DHL_STATUS'");
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

    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable dhl Method', 'MODULE_SHIPPING_DHL_STATUS', 'True', 'Do you want to offer table rate shipping?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Shipping Table', 'MODULE_SHIPPING_DHL_COST', '0.1:26,15', 'The shipping cost', '6', '0', 'zen_cfg_textarea(', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_DHL_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_DHL_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('US dollar to RMB Curreny','MODULE_SHIPPING_DHL_CURRENCY', '7.35','Currency from US to RMB','6','0',now())");
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Discount for shipping cost','MODULE_SHIPPING_DHL_DISCOUNT', '100','100 for no discount, 90 allows 10% discount','6','0',now())");  	
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
    return array('MODULE_SHIPPING_DHL_STATUS', 'MODULE_SHIPPING_DHL_COST','MODULE_SHIPPING_DHL_HANDLING',  'MODULE_SHIPPING_DHL_SORT_ORDER','MODULE_SHIPPING_DHL_CURRENCY','MODULE_SHIPPING_DHL_DISCOUNT');
  }
}
?>
