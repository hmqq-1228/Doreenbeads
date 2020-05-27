<?php
/**
 * ot_discount_coupon.php
 */

  class ot_discount_coupon {
  	var $title;

  	var $output;

  	function ot_discount_coupon(){
  		$this->code = 'ot_discount_coupon';
  		$this->title = TEXT_COUPON_REDEMPTION;
  		$this->current_balance_title = TEXT_COUPON_REDEMPTION;
  		$this->current_deducted_title = TEXT_COUPON_REDEMPTION;
  		$this->description = TEXT_COUPON_REDEMPTION;
  		$this->enabled = ((MODULE_DISCOUNT_COUPON_STATUS == 'True') ? true : false);
  		$this->sort_order =  MODULE_DISCOUNT_COUPON_SORT_ORDER;
  		$this->output = array();
  	}

  	function process(){
  		global $order, $currencies, $current_page;
		if($_SESSION['use_coupon'] == 'Y' && isset($_SESSION['coupon_id']) && (int)$_SESSION['coupon_id'] > 0 && isset($_SESSION['customer_id'])){
			$coupon_value =  get_coupon_value((int)$_SESSION['coupon_id']);
			if($coupon_value > 0){
				$order->info['total'] = $order->info['total'] - $coupon_value;
				if($order->info['total'] <= 0){
					$order->info['total'] = 0;
				}
				$discount_text = '-'.$currencies->format($coupon_value, true, $order->info['currency'], $order->info['currency_value']);
				$this->output[] = array('title' => $this->title,
								  'text' => $discount_text,
								  'value' => round($coupon_value,4),
								  'class' => $this->code,
								  'code' => $this->code,
								  'sort_order' =>  '300');
			}
		}
  	}

    function check(){
  		global $db;
  		if (!isset($this->_check)){
  			$check_query = $db->Execute("Select configuration_value
										   From " . TABLE_CONFIGURATION . "
										  Where configuration_key = 'MODULE_DISCOUNT_COUPON_STATUS'");
  			$this->_check = $check_query->RecordCount();
  		}
  		return $this->_check;
  	}

  	function keys(){
  		return array('MODULE_DISCOUNT_COUPON_STATUS', 'MODULE_DISCOUNT_COUPON_SORT_ORDER');
  	}

  	function install(){
  		global $db;
  		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Big Order Discount', 'MODULE_DISCOUNT_COUPON_STATUS', 'True', '', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
  		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Sort Order', 'MODULE_DISCOUNT_COUPON_SORT_ORDER', '970', 'Sort Order of Display.', '6', '0', '', now())");
  	}

  	function remove(){
  		global $db;
  		$keys = '';
  		$keys_array = $this->keys();
  		$keys_size = sizeof($keys_array);
  		for ($i = 0; $i < $keys_size; $i++){
			$keys .= "'" . $keys_array[$i] . "',";
		}
		$keys = substr($keys, 0, -1);
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
  	}
  }
?>