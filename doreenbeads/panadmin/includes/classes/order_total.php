<?php
/**
 *order discount amount
 *wei.liang
 *2013-06-17
**/

class order_total{
	var $order_info, $subtotal_old, $subtotal, $promotion_old, $promotion_discount, $coupon, $group_pricing, $tax, $shipping,$cash_account,$discount_amount, $total, $currency_code, $currency_rate;	
	//init
	function order_total($order_id){
		global $db,$order;			
		$order = new order($order_id);
    	$this->order_info=$order;
		$this->currency_code=$this->order_info->info['currency'];
		$this->currency_rate=$this->order_info->info['currency_value'];		
	}	
	//update order total after add discount amount
	function add_extra_amount($order_id, $extra_amount){
		global $db, $order, $currencies;	
		if(!is_numeric($extra_amount)) return false;
		
		$amount_dollar = round($extra_amount/$this->currency_rate, 4);
		$extra_amount_query = $db->Execute("select orders_total_id, text, value
                              from " . TABLE_ORDERS_TOTAL . "
                              where orders_id = '" . (int)$order_id . "' and class='ot_extra_amount'");		
		if($extra_amount_query->RecordCount()==0){
			
			$extra_total_old = 0;
			$extra_total_new = $currencies->format($extra_amount, false, $this->currency_code,  $this->currency_rate);
			if( $amount_dollar >= 0 ) {
			   $extra_text = $currencies->format($extra_amount, false, $this->currency_code,  $this->currency_rate);
			} else {
				$extra_text = '-'.$currencies->format(-$extra_amount, false, $this->currency_code,  $this->currency_rate);
			}
			//if( $amount_dollar < 0 ) {
			$order_extra_data = array(
					'orders_id' => (int)$order_id,
					'title' => 'Adjusted Amount:',
					'text' => $extra_text,
					'value' => $amount_dollar,
					'class' => 'ot_extra_amount',
					'sort_order' => '997'
			);
			//}
			zen_db_perform(TABLE_ORDERS_TOTAL, $order_extra_data);
		}else{
	
			$new_value =  round($extra_amount/$this->currency_rate, 4);
			$amount_dollar = $new_value - $extra_amount_query->fields['value'];
			$extra_total_old = $currencies->format($extra_amount_query->fields['value'], true, $this->currency_code,  $this->currency_rate);
			$extra_total_new = $currencies->format($new_value, true, $this->currency_code,  $this->currency_rate);
			if( $new_value >= 0 ) {
				$extra_text = $currencies->format($new_value, true, $this->currency_code,  $this->currency_rate);
			} else {
				$extra_text = '-'.$currencies->format(-$new_value, true, $this->currency_code,  $this->currency_rate);
			}
			$db->Execute("update ".TABLE_ORDERS_TOTAL." set text='".$extra_text."' , value='".$new_value."'
    					where orders_id='".(int)$order_id."' and class='ot_extra_amount'");
				
		}
		$total_new = $order->info['total'] + $amount_dollar;
		$total_text = $currencies->format($total_new, true, $this->currency_code,  $this->currency_rate);
		$db->Execute("update ".TABLE_ORDERS_TOTAL." set text='".$total_text."' , value='".$total_new."'
    					where orders_id='".(int)$order_id."' and class='ot_total'");
		$db->Execute("update ".TABLE_ORDERS." set order_total='".$total_new."',last_modified=NOW()
    					where orders_id='".(int)$order_id."'");
		 
		$operate_content= '订单 extra amount 变更: from '.$extra_total_old.' to '.$extra_total_new;
		zen_insert_operate_logs($_SESSION['admin_id'],(int)$order_id,$operate_content,1);
		return true;
	}
		
}


?>