<?php
/**
 * functions_gvcoupons.php
 * Functions related to processing Gift Vouchers/Certificates and coupons
 *
 * @package functions
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_gvcoupons.php 4135 2006-08-14 04:25:02Z drbyte $
 */

////
// Update the Customers GV account
  function zen_gv_account_update($c_id, $gv_id) {
    global $db;
    $customer_gv_query = "select amount
                          from " . TABLE_COUPON_GV_CUSTOMER . "
                          where customer_id = '" . (int)$c_id . "'";

    $customer_gv = $db->Execute($customer_gv_query);
    $coupon_gv_query = "select coupon_amount
                        from " . TABLE_COUPONS . "
                        where coupon_id = '" . (int)$gv_id . "'";

    $coupon_gv = $db->Execute($coupon_gv_query);

    if ($customer_gv->RecordCount() > 0) {

      $new_gv_amount = $customer_gv->fields['amount'] + $coupon_gv->fields['coupon_amount'];
      $gv_query = "update " . TABLE_COUPON_GV_CUSTOMER . "
                   set amount = '" . $new_gv_amount . "' where customer_id = '" . (int)$c_id . "'";

      $db->Execute($gv_query);

    } else {

      $gv_query = "insert into " . TABLE_COUPON_GV_CUSTOMER . "
                                   (customer_id, amount)
                          values ('" . (int)$c_id . "', '" . $coupon_gv->fields['coupon_amount'] . "')";

      $db->Execute($gv_query);
    }
  }

    function zen_user_has_gv_account($c_id) {
      global $db;
      if ($_SESSION['customer_id']) {
        $gv_result = $db->Execute("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . (int)$c_id . "'");
        if ($gv_result->RecordCount() > 0) {
          if ($gv_result->fields['amount'] > 0) {
            return $gv_result->fields['amount'];
          }
        }            
        return '0.00';
      } else {
        return '0.00';
      }
    }

////
// Create a Coupon Code. length may be between 1 and 16 Characters
// $salt needs some thought.

  function zen_create_coupon_code($salt="secret", $length = SECURITY_CODE_LENGTH) {
    global $db;
    $ccid = md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    srand((double)microtime()*1000000); // seed the random number generator
    $random_start = @rand(0, (128-$length));
    $good_result = 0;
    while ($good_result == 0) {
      $id1=substr($ccid, $random_start,$length);
      $query = "select coupon_code
                from " . TABLE_COUPONS . "
                where coupon_code = '" . $id1 . "'";

      $rs = $db->Execute($query);

      if ($rs->RecordCount() == 0) $good_result = 1;
    }
    return $id1;      
  }
  
 
  function zen_get_current_rcd_code(){
  	$current_rcd_code = '';
    if(!zen_customer_has_valid_order()){
    	$current_rcd_code = 'dorabeads';
    }else{
    	global $db;
	  	$date = date('Y-m-d H:i:s');
	  	$rcd_code_query = "Select coupon_code, coupon_start_date, coupon_expire_date
	  						 From " . TABLE_COUPONS . " 
	  						Where coupon_amount = 3
	  						And coupon_type = 'P' 
	  						  And coupon_start_date <= '" . $date . "'
	  						  And coupon_expire_date >= '" . $date . "' 
	  						  order by coupon_start_date desc limit 1";
	  	$rcd_code = $db->Execute($rcd_code_query);
	  	
	  	$current_rcd_code = $rcd_code->fields['coupon_code'];
	  	
//	  	$rcd_code_array = array();
//	  	while (!$rcd_code->EOF){
//	  		$rcd_code_array[] = array('code' => $rcd_code->fields['coupon_code'],
//	  								  'start_date' => $rcd_code->fields['coupon_start_date'],
//	  								  'expire_date' => $rcd_code->fields['coupon_expire_date']);
//	  		$rcd_code->MoveNext();
//	  	}
//	  	//echo $rcd_code->RecordCount();
//	  	$current_rcd_code = '';
//	  	if (sizeof($rcd_code_array) > 0){
//		  	$current_rcd_code = $rcd_code_array[0]['code'];
//		  	for ($i = 0; $i < sizeof($rcd_code_array); $i++){
//		  		if ($i > 0 && $rcd_code_array[$i]['start_date'] > $rcd_code_array[$i - 1]['start_date']){
//		  			$current_rcd_code = $rcd_code_array[$i]['code'];
//		  		}
//		  	}
//	  	}
    }
  		$special_coupon_start='2011-12-15 15:00:00';
    		$special_coupon_end='2012-01-08 16:00:00';
    		$pst_time=time();
    		if($pst_time<strtotime($special_coupon_start) || $pst_time>strtotime($special_coupon_end))
    		{
    			
    		}
    		else
    		{
    			$current_rcd_code = "2012";
    		}
  	return $current_rcd_code;
  }

//check customer whether used first coupon
  function zen_check_first_coupon(){
  	global $db;
  	if(isset($_SESSION['customer_id'])){
  		
  		$check_used_coupon = $db->Execute("select crt.coupon_id,crt.redeem_date,crt.redeem_ip,crt.order_id from " .TABLE_COUPONS ." c,". TABLE_COUPON_REDEEM_TRACK . " crt
                                               where c.coupon_id = crt.coupon_id
                                               and c.coupon_code in('dorabeads','2010Dora')
                                               and crt.customer_id = '" . (int)$_SESSION['customer_id'] . "'");
  	
  		if($check_used_coupon->RecordCount()>0){
			while (!$check_used_coupon->EOF) {
				$order_id = $check_used_coupon->fields['order_id'];
				if(! $order_id){	// important
					$order_id_query = $db->Execute("select coupon_id,order_id from ".TABLE_COUPON_REDEEM_TRACK." where coupon_id=0 and customer_id = '" . (int)$_SESSION['customer_id'] . "' and redeem_date='".$check_used_coupon->fields['redeem_date']."' and redeem_ip='".$check_used_coupon->fields['redeem_ip']."'");
					$order_id = $order_id_query->fields['order_id'];
				}
				$order_stat_query = $db->Execute("select orders_status from ".TABLE_ORDERS." where orders_id='".intval($order_id)."'");
				if($order_stat_query->fields['orders_status']!=0 && $order_stat_query->fields['orders_status']!=5)	//	delete/cancel
					return false;
				$check_used_coupon->MoveNext();
			}
			return true;
  		}else{
  			return true;
  		}
  	}else{
  		return false;
  	}
  } 
?>
