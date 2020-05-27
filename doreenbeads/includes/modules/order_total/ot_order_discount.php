<?php
/*
 * 长期订单折扣， 与VIP+RCD比较，哪个高取哪个
 * 2014-12-04 by zhanghongliang
 * 
 */
class ot_order_discount {
	
	var $title, $output;
	
	function ot_order_discount() {
		$this->code = 'ot_order_discount';		
		$this->title = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_TITLE;
		$this->sort_order = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SORT_ORDER;		
		$this->output = array ();
	}
	
	function process() {
		global $order, $currencies, $db;
		unset ( $_SESSION ['order_discount'] );
		if ($_SESSION['channel']) {
			return;
		}
		if (MODULE_ORDER_TOTAL_ORDER_DISCOUNT_STATUS == 'true') {
			$order_total = $this->get_order_total ();
			$order_discount_grade = 0;
			if($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE1 && $order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2) {
				$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE1;
			}elseif($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2 && $order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3) {
				$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE2;
			}elseif($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3 && $order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4) {
				$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE3;
			}elseif($order_total >= MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4) {
				$order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE4;
			}
			
			if($order_discount_grade>0){	
				$order_discount =  round($order_total * $order_discount_grade / 100, 2);				
				$vip_rcd_discount = $this->calculate_vip_rcd_discount();
				
				if($order_discount >= $vip_rcd_discount){
					$_SESSION ['order_discount'] = $order_discount;
					$order_discount_title = sprintf ( TEXT_ORDER_DISCOUNT, $order_discount_grade . '%' );
					$order->info ['total'] -= round($order_discount,2);
					$this->output [] = array (
						'title' => $order_discount_title . ': ',
						'text' => '-' . $currencies->format ( $order_discount, true, $order->info ['currency'], $order->info ['currency_value'] ),
						'value' => $order_discount 
					);
				}
			}
		}
		
	}
	
	function calculate_vip_rcd_discount(){
		global $db,$order,$currencies;
		$vip_discount = 0;
		$discount = 0;
		$order_total = $this->get_order_total ();
		
		/*满减活动*/ 
		if(date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME){
			if ($order_total > $currencies->format_cl( 49 )) {
				$discount = floor($order_total/$currencies->format_cl( 49 ))*$currencies->format_wei( 4 );
				$order_total = $order_total - $discount;
			}
		}
		/*阶梯式满减活动*/
		if(date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel'] && $_SESSION['use_coupon'] != 'Y'){
			if ($order_total > $currencies->format_cl( 379 )) {
				$discount = 25;
			}elseif($order_total > $currencies->format_cl( 259 )){
				$discount = 20;
			}elseif($order_total > $currencies->format_cl( 149 )){
				$discount = 10;
			}elseif($order_total > $currencies->format_cl( 49 )){
				$discount = 5;
			}elseif($order_total > $currencies->format_cl( 19 )){
                $discount = 1;
            }else{
				$discount = 0;
			}

			$order_total = $order_total - $discount;
		}
		$group_query = $db->Execute("select customers_group_pricing from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "'");
		if ($group_query->fields['customers_group_pricing'] != 0) {
			$group_discount = $db->Execute("select g.group_name, g.group_percentage from " . TABLE_GROUP_PRICING . " g, " .TABLE_GROUP_PRICING_DESCRIPTION. " gp
										where g.group_id = gp.group_id
										and gp.language_id= " . $_SESSION['languages_id'] . "
										and g.group_id = '" . (int)$group_query->fields['customers_group_pricing'] . "'");
			$vip_discount = round($order_total  * $group_discount->fields['group_percentage'] / 100, 2);
		}
		$rcd_discount = 0;
		if(!zen_get_customer_create() && !get_with_channel()){			
			$rcd_discount = round(($order_total-$vip_discount)*0.03, 2);			
		}
		return $vip_discount + $rcd_discount;
	}
	
	
	function get_order_total() {
		global $order;
		$order_total = $order->info['total'];
		if($order->info['promotion_total'] > 0){$order_total -= $order->info['promotion_total'];}
		return $order_total;
	}
	
	function check() {
		global $db;
		if (! isset ( $this->_check )) {
			$check_query = $db->Execute ( "select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_STATUS'" );
			$this->_check = $check_query->RecordCount ();
		}
		return $this->_check;
	}
	
	function keys() {
		return array (
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_STATUS',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SORT_ORDER',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE1',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE1',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE2',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE3',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4',
				'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE4'
		);
	}
	
	function install() {
		global $db;
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Allow Order Discount?', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_STATUS', 'true', 'Do you want to allow Order Discount?', '6', '3', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now())" );
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SORT_ORDER', '110', 'Sort order of display.', '6', '2', now())" );
		
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade1', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE1', '49', 'All products added up', '6', '5', now())" );
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Order Discount Grade1', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE1', '3', '0 for no discount, 10 for 10% discount', '6', '5', now())" );
		
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade2', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2', '199', 'All products added up', '6', '5', now())" );
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Order Discount Grade2', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE2', '5', '0 for no discount, 10 for 10% discount', '6', '5', now())" );
		
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade3', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3', '499', 'All products added up', '6', '5', now())" );
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Order Discount Grade3', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE3', '8', '0 for no discount, 10 for 10% discount', '6', '5', now())" );
		
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade4', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4', '999', 'All products added up', '6', '5', now())" );
		$db->Execute ( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Order Discount Grade4', 'MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE4', '10', '0 for no discount, 10 for 10% discount', '6', '5', now())" );
		
	}
	
	function remove() {
		global $db;
		$db->Execute ( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode ( "', '", $this->keys () ) . "')" );
	}
}
?>