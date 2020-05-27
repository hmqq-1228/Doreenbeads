<?php

  class ot_promotion {
    var $title, $output;

    function ot_promotion() {
      $this->code = 'ot_promotion';
      
      $this->title = MODULE_ORDER_TOTAL_PROMOTION_TITLE;
      $this->sort_order = MODULE_ORDER_TOTAL_PROMOTION_SORT_ORDER;

      $this->output = array();
    }

    function process() {
		global $order, $currencies, $db;
		
		$show_total = $this->get_order_total() - $order->info ['promotion_total'];
		/*满减活动*/
		if (date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') <= PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME && $show_total > 49) {
			if (MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_STATUS) {
				$discount = floor($show_total/49)*4;
			}
		}
		
    	/*阶梯式满减活动*/
		if(date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel'] && $_SESSION['use_coupon'] != 'Y'){
			if ($show_total > 379 ) {
				$discount = 25;
			}elseif($show_total > 259){
				$discount = 20;
			}elseif($show_total > 149){
				$discount = 10;
			}elseif($show_total > 49){
				$discount = 5;
			}elseif($show_total > 19){
                $discount = 1;
            }else{
				$discount = 0;
			}
			
		}		
		
		if ($discount >　0) {
			$_SESSION ['promotion_discount'] = $discount;
			$promotion_discount_title = TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS;
			$order->info ['total'] -= $discount;
			$this->output [] = array (
					'title' => $promotion_discount_title . ': ',
					'text' => '-' . $currencies->format ( $discount, true, $order->info ['currency'], $order->info ['currency_value'] ),
					'value' => $discount
			);
		}
	}
    
   function get_order_total() {
		global $order;
		$order_total = $order->info['total'];
		/* if ($order->info ['promotion_total'] > 0) {
			$order_total -= $order->info ['promotion_total'];
		} */

		return $order_total;
	}
	
    function check() {
	  global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_STATUS', 'MODULE_ORDER_TOTAL_PROMOTION_SORT_ORDER', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE1', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE1', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE2', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE2', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE3', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE3', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE4');
    }

    function install() {
	  global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Allow Promotion Discount?', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_STATUS', 'true', 'Do you want to allow Promotion Discount?', '6', '3', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now())");      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_PROMOTION_SORT_ORDER', '250', 'Sort order of display.', '6', '2', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade1', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE1', '800', 'All products added up', '6', '5', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Promotion Discount Grade1', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE1', '6', '0 for no discount, 10 for 10% discount', '6', '5', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade2', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE2', '1500', 'All products added up', '6', '5', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Promotion Discount Grade2', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE2', '10', '0 for no discount, 10 for 10% discount', '6', '5', now())");
      
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Subtotal Grade3', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_SUBTOTAL_GRADE3', '5000', 'All products added up', '6', '5', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Promotion Discount Grade3', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE3', '15', '0 for no discount, 10 for 10% discount', '6', '5', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Promotion Discount Grade4', 'MODULE_ORDER_TOTAL_PROMOTION_DISCOUNT_GRADE4', '0', '0 for no discount, 10 for 10% discount', '6', '5', now())");      
    }

    function remove() {
	  global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>