<?php
class ot_handing_fee {
	var $title, $output;
	function ot_handing_fee() {
		$this->code = 'ot_handing_fee';
		$this->title = MODULE_ORDER_TOTAL_HANDING_FEE_TITLE;
		$this->description = MODULE_ORDER_TOTAL_HANDING_FEE_DESCRIPTION;
		$this->sort_order = MODULE_ORDER_TOTAL_HANDING_FEE_SORT_ORDER;
		$this->output = array ();
	}
	function process() {
		global $order, $currencies;
		$handing_fee = 0;
		if($order->info ['total'] < 9.99){
            $handing_fee = 0.99;
		}
		
		if ($handing_fee> 0) {
				$order->info ['total'] += $handing_fee;
				$this->output [] = array (
							'title' => $this->title . ': ',
							'text' => $currencies->format ( $handing_fee, true),
							'value' => $handing_fee
				);				
		}
		
	}
	function check() {
		global $db;
		if (! isset ( $this->_check )) {
			$check_query = $db->Execute ( "select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_HANDING_FEE_STATUS'" );
			$this->_check = $check_query->RecordCount ();
		}
		return $this->_check;
	}
	function keys() {
		return array (
				'MODULE_ORDER_TOTAL_HANDING_FEE_STATUS',
				'MODULE_ORDER_TOTAL_HANDING_FEE_SORT_ORDER'
		);
	}
	function install() {
		global $db;

		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Allow Handing Fee?', 'MODULE_ORDER_TOTAL_HANDING_FEE_STATUS', 'True', 'Do you want to allow Handing Fee?', '6', '875', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())" );
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_HANDING_FEE_SORT_ORDER', '875', 'Sort order of display.', '6', '875', now())" );
	}
	function remove() {
		global $db;
		$db->Execute ( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode ( "', '", $this->keys () ) . "')" );
	}
}
