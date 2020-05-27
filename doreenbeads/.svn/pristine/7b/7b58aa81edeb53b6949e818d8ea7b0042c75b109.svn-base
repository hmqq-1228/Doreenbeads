<?php
/**
 * ot_cash_account.php
 */

  class ot_cash_account {
  	var $title;
  	
  	var $output;
  	
  	function ot_cash_account(){
  		$this->code = 'ot_cash_account';
  		$this->title = MODULE_ORDER_TOTAL_BALANCE_CASH_ACCOUNT_TITLE;
  		$this->current_balance_title = MODULE_ORDER_TOTAL_BALANCE_CASH_ACCOUNT_TITLE;
  		$this->current_deducted_title = MODULE_ORDER_TOTAL_BALANCE_CASH_ACCOUNT_TITLE;
  		$this->description = MODULE_ORDER_TOTAL_CASH_ACCOUNT_DESCRIPTION;
  		$this->enabled = ((MODULE_CASH_ACCOUNT_STATUS == 'True') ? true : false);
  		$this->sort_order =  MODULE_CASH_ACCOUNT_SORT_ORDER;
  		$this->output = array();
  	}
  	
  		function process(){
  		global $order, $currencies, $current_page;
  		
  		unset($_SESSION['current_used_cash']);
		unset($_SESSION['cash_account_addnum']);

		//if ($this->get_active_cash_account($_SESSION['customer_id'], $_SESSION['currency'], $ls_id_list, $ldc_amount) == 0) return 0;
		if ($this->get_active_cash_account($_SESSION['customer_id'], $_SESSION['currency'], $ls_id_list, $ldc_amount,$cash_currency_code) == 0) return 0;
  		$ldc_amount_usd = zen_change_currency($ldc_amount, $cash_currency_code, 'USD');
  		$order_total=$order->info['total'];
  		//echo $order->info['total']."___info[total]<br>";
  		//echo $order_total."___order_total<br>";
		if ($ldc_amount_usd < $order->info['total']){
  			//$this->credit_class = true;
  			$_SESSION['current_used_cash'] = $ldc_amount_usd;
  			//$order->info['total'] = $order->info['total'] - $ldc_amount;
  			$order->info['total'] = $order->info['total'] - $ldc_amount_usd;
  		} else {
  			//$this->credit_class = false;
  			$_SESSION['current_used_cash'] = $order->info['total'];
  			$order->info['total'] = 0;
  		}
  		
  		if ($ldc_amount > 0){ 
 			if ($ldc_amount_usd > $order_total){
 				$cashlist=zen_get_cash_array($ls_id_list);
  				$cash_num=0;
  				$cash_str='(';
  		        foreach($cashlist as $vals){
  		        	 $cash_str.=$vals['id'].","; 		        	
  		        	 $cash_num+=zen_change_currency($vals['amount'], $vals['currency_code'], 'USD') ;
                     if($cash_num >= $order_total){
                     	//unset($_SESSION["cash_account_addnum"]);
                     	$_SESSION["cash_account_addnum"]=round($cash_num-$order_total,2);
//                     	$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status)
//  						  values (" . $_SESSION["customer_id"] . ", '" . round($cash_num-$order_total,2) . "', 'USD', 'system', '" . date('Y-m-d H:i:s') . "', 'A')");
                     	break;      	
                     }
  		        }
  		        $cash_str=substr($cash_str,0,(strlen($cash_str)-1));
  		        $cash_str.=")";
  		        // echo $cash_num."___cash_num<br>"; 
  		     //echo $order_total."___order_total<br>";  
  		    // echo $_SESSION["cash_account_addnum"]."<br>";
  		     //exit; 
 			$this->output[] = array('title' => $this->current_balance_title . ': ',
	  								'text' => '-' . $currencies->format($order_total, true, $_SESSION['currency']),
	  								'value' => zen_change_currency($ldc_amount, $cash_currency_code, 'USD'),
	  								'over_arg' => $cash_str);}	
  			else{
	  		$this->output[] = array('title' => $this->current_balance_title . ': ',
	  								'text' => '-' . $currencies->format($ldc_amount_usd, true, $_SESSION['currency']),
	  								//'value' => $ldc_amount,
	  								'value' => zen_change_currency($ldc_amount, $cash_currency_code, 'USD'),
	  								'over_arg' => $ls_id_list);}
  		} else {
  			$this->output[] = array('title' => $this->current_balance_title . ':',
  									'text' => $currencies->format(-$ldc_amount_usd, true, $_SESSION['currency']),
  									//'value' => $ldc_amount,
  									'value' => zen_change_currency($ldc_amount, $cash_currency_code, 'USD'),
	  								'over_arg' => $ls_id_list);
  		}
  		
  		return 1;
  	}
  	
  	//function get_active_cash_account($as_customer_id, $as_currency, &$as_cash_id, &$adc_cash_amount){
  	function get_active_cash_account($as_customer_id, $as_currency, &$as_cash_id, &$adc_cash_amount,&$cash_currency_code){
  		global $db;
  		
	  	$ls_sql = "Select cac_cash_id, cac_amount, cac_currency_code
					 From " . TABLE_CASH_ACCOUNT . "
					Where cac_customer_id = " . (int)$as_customer_id . "
					  And cac_status = 'A'";
	  	$lds_cash_account = $db->Execute($ls_sql);
	  	if ($lds_cash_account->RecordCount() == 0) return 0;
	 	
  		$as_cash_id = '(';
  		/*while (!$lds_cash_account->EOF){
  			$cash_currency_code = $lds_cash_account->fields['cac_currency_code'];
//  			if ($lds_cash_account->fields['cac_currency_code'] == $as_currency) {
//  				$ldc_amount = $lds_cash_account->fields['cac_amount'];
//  			}else{
//  				$ldc_amount = zen_change_currency($lds_cash_account->fields['cac_amount'], $lds_cash_account->fields['cac_currency_code'], $as_currency);
//  			}
  			$ldc_amount = $lds_cash_account->fields['cac_amount'];
  			$as_cash_id .= $lds_cash_account->fields['cac_cash_id'] . ', ';
			$adc_cash_amount = $adc_cash_amount + $ldc_amount;
  			$lds_cash_account->MoveNext();
  		}*/
  		while (!$lds_cash_account->EOF){
  			$cash_currency_code = $lds_cash_account->fields['cac_currency_code'];
			$cash_record_amount = $lds_cash_account->fields['cac_amount'];
  			$ldc_amount = ($cash_currency_code == 'USD')? $cash_record_amount : zen_change_currency($cash_record_amount, $cash_currency_code, 'USD');
  			$as_cash_id .= $lds_cash_account->fields['cac_cash_id'] . ', ';
			$adc_cash_amount = $adc_cash_amount + $ldc_amount;
  			$lds_cash_account->MoveNext();
  		}
  		$as_cash_id = substr($as_cash_id, 0, -2);
  		$as_cash_id .= ')';
	  	$cash_currency_code = 'USD';
	   return 1;
  	}
  	
  	function over($as_cash_id){
  		global $db;
  		
  		$db->Execute("Update " . TABLE_CASH_ACCOUNT . "
  						 Set cac_status = 'C',cac_who_modify = 1 ,cac_modify_date = '".date('Y-m-d H:i:s')."'
  					   Where cac_cash_id in " . $as_cash_id);
  		
  		return 1;
  	}
  	
  	function check(){
  		global $db;
  		if (!isset($this->_check)){
  			$check_query = $db->Execute("Select configuration_value 
										   From " . TABLE_CONFIGURATION . "
										  Where configuration_key = 'MODULE_CASH_ACCOUNT_STATUS'");
  			$this->_check = $check_query->RecordCount();
  		}
  		return $this->_check;
  	}
  	
  	function keys(){
  		return array('MODULE_CASH_ACCOUNT_STATUS', 'MODULE_CASH_ACCOUNT_SORT_ORDER');
  	}
  	
  	function install(){
  		global $db;
  		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Big Order Discount', 'MODULE_CASH_ACCOUNT_STATUS', 'True', '', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
  		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Sort Order', 'MODULE_CASH_ACCOUNT_SORT_ORDER', '280', 'Sort Order of Display.', '6', '0', '', now())");
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
