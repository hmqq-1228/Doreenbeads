<?php
/**
* invite friends
* @author	xiaoyong.lv
* @date		2015-04-22
*/
class inviteFriends{

	//	推荐人cookie名
	public $cookieKeyRefer = 'invite_friends_referer';
	//	注册cookie名
	public $cookieKeyRegister = 'invite_friends_register';
	//	cookie过期时间
	private $_cookieExpired = 0;

	//	构造函数
	public function inviteFriends(){
		$this->_cookieExpired = time() + 60*60*5;	//	5h
		$this->_init();
	}

	//	初始化
	private function _init(){
		if(isset($_GET['utm_campaign']) && $_GET['utm_campaign'] == 'referrals' && isset($_GET['referrer_id']) && $_GET['referrer_id'] !=''){
			setcookie($this->cookieKeyRefer, trim($_GET['referrer_id']), $this->_cookieExpired, '/');
		}
	}

	//	设置注册cookie
	public function setRegisterCookie($str){
		$str_crypt = $this->encode($this->getRefer().'_'.$str);
		setcookie($this->cookieKeyRegister, trim($str_crypt), $this->_cookieExpired, '/');
	}

	//	是否有推荐人
	public function hasRefer(){
		return isset($_COOKIE[$this->cookieKeyRefer]) && $_COOKIE[$this->cookieKeyRefer] != '';
	}

	//	是否有注册
	public function hasRegister(){
		return isset($_COOKIE[$this->cookieKeyRegister]) && $_COOKIE[$this->cookieKeyRegister] != '';
	}

	//	获取推荐人cookie
	public function getRefer(){
		return $this->decode($_COOKIE[$this->cookieKeyRefer]);
	}

	//	获取注册cookie
	public function getRegister(){
		return $this->decode($_COOKIE[$this->cookieKeyRegister]);
	}

	//	加密
	public function encode($str){
		$str = (string)$str;
		$str = base64_encode($this->_rc4('panduo', $str).'panduo');
		return str_replace(array('+','/'), array('%','-'), $str);
	}

	//	加密
	public function decode($str){
		$str = str_replace(array('%','-'), array('+','/'), $str);
		return $this->_rc4('panduo', substr(base64_decode($str), 0, -6));
	}

	//	设置cookie过期
	public function expireCookie(){
		setcookie ($this->cookieKeyRefer, "", time() - 3600, '/');
		setcookie ($this->cookieKeyRegister, "", time() - 3600, '/');
	}

	//	验证cookie信息是否正确
	public function validCookie($customerId){
		if(! $customerId) return false;

		$referId = intval($this->getRefer());
		if($referId == $customerId){
			$this->_writeLog('referId is '.$referId.' and customerId is '.$customerId);
			return false;
		}

		$register = explode('_', $this->getRegister());
		if($referId != $register[0]) {
			$this->_writeLog('referId is '.$referId.' and register0 is '.$register[0]);
			return false;
		}
		if($customerId != $register[1]){
			$this->_writeLog('customerId is '.$customerId.' and register1 is '.$register[1]);
			return false;
		}

		return true;
	}

	//	验证地址是否合法
	public function validAddress($address1, $address2){
		$flag = false;

		$this->_writeLog($address1);
		$this->_writeLog($address2);

		if(! is_array($address1) || ! is_array($address2)) return $flag;

		foreach($address1 as $key=>$val){
			if(! isset($address2[$key]) || $address2[$key] != $val){
				$flag = true;
			}
		}

		return $flag;
	}

	//	验证当前客户的订单是否只有一个
	public function validOrder(){
		return zen_count_customer_orders() <= 1;
	}

	//	下单后检查是否满足条件
	public function canSendCoupon($orders_id=0){
		global $db;

		if(!$_SESSION['customer_id']) return false;

		if(! $this->hasRefer() || ! $this->hasRegister()){
			$this->_writeLog('Step 1 Error.');
			return false;
		}

		if(! $this->validCookie($_SESSION['customer_id'])){
			$this->_writeLog('Step 2 Error.');
			return false;
		}
		
		if(! $this->validOrder()){
			$this->_writeLog('Step 3 Error.');
			return false;
		}

		$order = new order($orders_id);
		unset($order->delivery['country']);
		unset($order->delivery['format_id']);
		$address_query = $db->Execute("select entry_firstname as firstname, entry_lastname as lastname,
							entry_company as company, entry_street_address as street_address,
							entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
							entry_state as state, entry_zone_id as zone_id,
							entry_country_id as country_id, entry_telephone as telephone 
							from ".TABLE_ADDRESS_BOOK." where customers_id=".intval($this->getRefer()));
		while (! $address_query->EOF){
			$address_query->fields['name'] = $address_query->fields['firstname'].' '.$address_query->fields['lastname'];
			if(! $this->validAddress($order->delivery, $address_query->fields)){
				$this->_writeLog('Step 4 Error.');
				return false;
			}
			$address_query->MoveNext();
		}
		
		$ot_subtotal = $ot_total = $vip_discount = $cou_discount = 0;
		for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
			if($order->totals[$i]['class'] == 'ot_subtotal'){
				$ot_subtotal = $order->totals[$i]['value'];			
			}elseif($order->totals[$i]['class'] == 'ot_group_pricing'){
				$vip_discount = $order->totals[$i]['value'];	
			}elseif($order->totals[$i]['class'] == 'ot_coupon'){
				$cou_discount = $order->totals[$i]['value'];	
			}elseif($order->totals[$i]['class'] == 'ot_total'){
				$ot_total = $order->totals[$i]['value'];	
			}
		}
		//$item_total = $ot_subtotal - $vip_discount - $cou_discount;
		$item_total = $ot_total;
		if($item_total>=10 && $item_total<20){
			$coupon_code = 'IFCP2015042205';
		}elseif($item_total>=20 && $item_total<30){
			$coupon_code = 'IFCP2015042210';
		}elseif($item_total>=30){
			$coupon_code = 'IFCP2015042215';
		}else{
			$this->_writeLog('Step 5 Error. item_total is '.$item_total);
			return false;
		}

		$referrers_data_array = array(
			'orders_id' => $orders_id,
			'register_cookie' => $_COOKIE[$this->cookieKeyRegister],
			'coupon_code' => $coupon_code,
			'status' => 1,
			'date_created' => date('Y-m-d H:i:s')
		);
		zen_db_perform('t_order_referrers', $referrers_data_array);

		$this->expireCookie();
		return true;
	}

/*
	//	发送coupon
	public function sendCoupon($orders_id=0){
		global $db, $order;

		$referrers_query = $db->Execute("select * from t_order_referrers where orders_id='".$orders_id."' and status=1 limit 1");
		if($referrers_query->RecordCount()==0) return false;

		$register = explode('_', $this->decode($referrers_query->fields['register_cookie']));
//		if($referId != $register[0]) return false;
		if($order->customer['id'] != $register[1]) return false;

		$check_from_order = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_customers_id='".intval($register[0])."' and coupon_from='".$orders_id."'");
		if($check_from_order->RecordCount()==0){
			$coupon_query = $db->Execute("select coupon_id,coupon_amount,day_after_add from ".TABLE_COUPONS." where coupon_code='".$referrers_query->fields['coupon_code']."' limit 1");
			$coupon_data_array = array(
				'cc_coupon_id' => (int)$coupon_query->fields['coupon_id'],
				'cc_customers_id' => intval($register[0]),
				'cc_amount' => $coupon_query->fields['coupon_amount'],
				'cc_coupon_start_time' => date('Y-m-d H:i:s'),
				'cc_coupon_end_time' => date('Y-m-d H:i:s', strtotime("+".$coupon_query->fields['day_after_add']." day")),
				'coupon_from' => $orders_id,
				'cc_coupon_status'=>10,
				'date_created'=>'now()'
			);
			zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		}

		$db->Execute("update t_order_referrers set status=0 where id='".$referrers_query->fields['id']."'");
		return true;
	}
*/

	//	发送coupon
	public function sendCoupon($orders_id=0){
		global $db;

		$order = new order($orders_id);
		$cid = intval($order->customer['id']);

		$customer_query = $db->Execute("select referrer_id from ".TABLE_CUSTOMERS." where customers_id='".$cid."'");
		if(! intval($customer_query->fields['referrer_id']) || $customer_query->fields['referrer_id'] <= 0){
//			$this->_writeLog($customer_query->fields['referrer_id'].'Step 11 Error.'.$cid);
			return false;	//	no referrer_id or used
		}
		$rid = intval($customer_query->fields['referrer_id']);

		unset($order->delivery['country']);
		unset($order->delivery['format_id']);
		$address_query = $db->Execute("select entry_firstname as firstname, entry_lastname as lastname,
							entry_company as company, entry_street_address as street_address,
							entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
							entry_state as state, entry_zone_id as zone_id,
							entry_country_id as country_id, entry_telephone as telephone 
							from ".TABLE_ADDRESS_BOOK." where customers_id=".$rid);
		while (! $address_query->EOF){
			$address_query->fields['name'] = $address_query->fields['firstname'].' '.$address_query->fields['lastname'];
			if(! $this->validAddress($order->delivery, $address_query->fields)){
				$this->_writeLog('Step 44 Error.');
				return false;
			}
			$address_query->MoveNext();
		}
		
		$ot_subtotal = $ot_total = $vip_discount = $cou_discount = 0;
		for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
			if($order->totals[$i]['class'] == 'ot_subtotal'){
				$ot_subtotal = $order->totals[$i]['value'];			
			}elseif($order->totals[$i]['class'] == 'ot_group_pricing'){
				$vip_discount = $order->totals[$i]['value'];	
			}elseif($order->totals[$i]['class'] == 'ot_coupon'){
				$cou_discount = $order->totals[$i]['value'];	
			}elseif($order->totals[$i]['class'] == 'ot_total'){
				$ot_total = $order->totals[$i]['value'];
				break;
			}
		}
		//$item_total = $ot_subtotal - $vip_discount - $cou_discount;
		$item_total = $ot_total;
		if($item_total>=10 && $item_total<20){
			$coupon_code = 'IFCP2015042205';
		}elseif($item_total>=20 && $item_total<30){
			$coupon_code = 'IFCP2015042210';
		}elseif($item_total>=30){
			$coupon_code = 'IFCP2015042215';
		}else{
			$this->_writeLog('Step 55 Error. item_total is '.$item_total);
			return false;
		}

		$check_from_order = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_customers_id='".$rid."' and coupon_from='".$orders_id."'");
		if($check_from_order->RecordCount()==0){
			$coupon_query = $db->Execute("select coupon_id,coupon_amount,day_after_add from ".TABLE_COUPONS." where coupon_code='".$coupon_code."' limit 1");
			$coupon_data_array = array(
				'cc_coupon_id' => (int)$coupon_query->fields['coupon_id'],
				'cc_customers_id' => $rid,
				'cc_amount' => $coupon_query->fields['coupon_amount'],
				'cc_coupon_start_time' => date('Y-m-d H:i:s'),
				'cc_coupon_end_time' => date('Y-m-d H:i:s', strtotime("+".$coupon_query->fields['day_after_add']." day")),
				'coupon_from' => $orders_id,
				'cc_coupon_status'=>10,
				'date_created'=>'now()'
			);
			zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		}

		$db->Execute("update ".TABLE_CUSTOMERS." set referrer_id='-".$rid."' where customers_id='".$cid."'");
		return true;
	}

	//	rc4加密算法
	private function _rc4 ($pwd, $data){
		$key[] ="";
		$box[] ="";
  
		$pwd_length = strlen($pwd);
		$data_length = strlen($data);
  
		for ($i = 0; $i < 256; $i++){
			$key[$i] = ord($pwd[$i % $pwd_length]);
			$box[$i] = $i;
		}
  
		for ($j = $i = 0; $i < 256; $i++){
			$j = ($j + $box[$i] + $key[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
  
		for ($a = $j = $i = 0; $i < $data_length; $i++){
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
  
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
  
			$k = $box[(($box[$a] + $box[$j]) % 256)];
			$cipher .= chr(ord($data[$i]) ^ $k);
		}
  
		return $cipher;
	}

	//	write to log file
	private function _writeLog($p_str){
		$logFile = 'invite-'.date("Ym").".log";
		if(is_array($p_str)){
			error_log(date("Y-m-d H:i:s")." : \n", 3, $logFile);
			foreach($p_str as $k=>$v){
				error_log(" ".$k." => ".$v."\n", 3, $logFile);
			}
		}else{
			error_log(date("Y-m-d H:i:s")." : ".$p_str."\n", 3, $logFile);
		}
	}

}

//	global variable
$fun_inviteFriends = new inviteFriends();