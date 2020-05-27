<?php
/**big_order_dist.php
 * jessa
 * 2010-03-25
 */

class ot_big_orderd extends base {
	var $title, $output;
	
	function ot_big_orderd(){
		$this->code = 'ot_big_orderd';
		$this->title = MODULE_BIG_ORDER_DIST_TITLE;
		$this->description = MODULE_BIG_ORDER_DIST_DESCRIPTION;
		$this->enabled = ((MODULE_BIG_ORDER_DIST_STATUS == 'True') ? true : false);
		$this->sort_order = MODULE_BIG_ORDER_DIST_SORT_ORDER;
		$this->output = array();
	}
	
	function get_cost(){
		global $order, $currencies;
		if (!class_exists('shipping')){
			require(DIR_WS_CLASSES . 'shipping.php');
		}
		/*
		//$shipping_cost_airmail = 105 * 0.7 / 1000 * $_SESSION['cart']->airmail_weight() * 1.1 / MODULE_SHIPPING_CHIANPOST_CURRENCY;
		//$shipping_cost_airmail = 105 * 0.7 / 1000 * $_SESSION['cart']->show_weight() * 1.1 / MODULE_SHIPPING_CHIANPOST_CURRENCY;
	    $shipping_method = $order->info['shipping_module_code'];
	    $shipping = new shipping($shipping_method);
		$shipping->get_all_shipping();
		$shipping_cost_airmail = MODULE_SHIPPING_AIRMAIL_ARGUMENT * $shipping->all_shipping_method['airmail']['discount'] / 1000 * $_SESSION['cart']->show_weight() * 1.1 / MODULE_SHIPPING_CHIANPOST_CURRENCY;
	    $shipping_result = $shipping->cal_result[$shipping_method];
	    $shipping_cost = $shipping_result['cost'];
		if($shipping_cost>=$shipping_cost_airmail){
			$discount = $shipping_cost_airmail - $shipping_cost;
		}else{
			//$shipping_cost_airmail = 105 * 0.7 / 1000 * $_SESSION['cart']->not_promotion_weight() * 1.1 / MODULE_SHIPPING_CHIANPOST_CURRENCY;

			$discount = $shipping_cost_airmail - $shipping_cost;
			$discount = $discount * (1 - $_SESSION['cart']->promotion_weight() / $_SESSION['cart']->show_weight());
		}

	    
	    //bof 由于航空小包运费上涨,返回金额改为原来返回金额的85%; by zale 20130619
	    //change to 0.77, by zale 20131101
	    //change to 0.70, by tianwen.wan 20150918
	    $discount *= 0.70;
	    //eof
	    
		if ($discount <= 0) $discount = 0;
		if($order->info['subtotal']<=0) $discount = 0;	
	    return $discount;
	    */
	    $shipping = new shipping();
	    $discount = 0;

	    if(isset($shipping->special_result[$order->info['shipping_module_code']])) {
	    	$discount = $shipping->special_result[$order->info['shipping_module_code']];
	    }
	    if($order->info['is_virtual']){
            if(isset($shipping->special_result[$order->info['virtual_code']])){
                $discount = $shipping->special_result[$order->info['virtual_code']];
            }
        }
	    return $discount;
	}
	
	function process(){
		global $order, $currencies;
		if (MODULE_BIG_ORDER_DIST_STATUS == 'True'){
			$discount = $this->get_cost();
			$order->info['total'] -= $discount;
			if ($discount > 0){
				$this->output[] = array('title' => $this->title . ':',
						'text' => '-' . $currencies->format($discount),
						'value' => $discount);
			}			
		}		
	}
	
	function check(){
		global $db;
		
		if (!isset($this->_check)){
			$check_query = $db->Execute("Select configuration_value 
										   From " . TABLE_CONFIGURATION . "
										  Where configuration_key = 'MODULE_BIG_ORDER_DIST_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		
		return $this->_check;
	}
	
	function keys(){
		return array('MODULE_BIG_ORDER_DIST_STATUS', 'MODULE_BIG_ORDER_DIST_SORT_ORDER');
	}
	
	function install(){
		global $db;
		
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Big Order Discount', 'MODULE_BIG_ORDER_DIST_STATUS', 'True', '', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Sort Order', 'MODULE_BIG_ORDER_DIST_SORT_ORDER', '710', 'Sort Order of Display.', '6', '0', '', now())");
	}
	
	function remove(){
		global $db;
		
		$keys = '';
		$keys_array = $this->keys();
		$keys_size = sizeof ($keys_array);
		for ($i = 0; $i < $keys_size; $i++){
			$keys .= "'" . $keys_array[$i] . "',";
		}
		$keys = substr($keys, 0, -1);
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
	} 
}
?>