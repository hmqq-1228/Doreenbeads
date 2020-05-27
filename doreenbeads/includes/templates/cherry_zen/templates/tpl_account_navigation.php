<?php
	$orders_query = "SELECT orders_status , count(orders_id) as orders_num
		                 FROM   " . TABLE_ORDERS . " o
		                 WHERE  o.customers_id = :customersID
		                 and o.orders_status != 5
		                 group by orders_status";
	$orders_query = $db->bindVars($orders_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$orders = $db->Execute($orders_query);
	
	$orders_array = array('orders_num' => 0 , 'pending' => 0 , 'processing' => 0 , 'shipping' => 0 , 'update' => 0 , 'delivered' => 0 , 'cancel' => 0);
	$all_orders_num = 0;
	while (!$orders->EOF) {
		$orders_status = strval($orders->fields['orders_status']);
		if(in_array($orders_status, explode(',', MODULE_ORDER_PENDING_UNDER_CHECKING_STATUS_ID_GROUP))){
			$orders_array['pending'] += $orders->fields['orders_num'];
		}elseif($orders_status == '2'){
			$orders_array['processing'] = $orders->fields['orders_num'];
		}elseif($orders_status == '3'){
			$orders_array['shipping'] += $orders->fields['orders_num'];
		}elseif($orders_status == '4'){
			$orders_array['update'] += $orders->fields['orders_num'];
		}elseif($orders_status == '10'){
			$orders_array['delivered'] = $orders->fields['orders_num'];
		}elseif($orders_status == '0'){
			$orders_array['cancel'] = $orders->fields['orders_num'];
		}
		
		$all_orders_num += $orders->fields['orders_num'];
		$orders->MoveNext();
	}

	$orders_array['all_orders'] = $all_orders_num;

/*coupon一周内提醒*/
$expire_coupon_in_week_sql = ('SELECT coupon_id,coupon_code,coupon_type,coupon_start_date,coupon_expire_date,uses_per_user,coupon_usage,cc_coupon_start_time,cc_coupon_end_time FROM '.TABLE_COUPONS.' c,'.TABLE_COUPON_CUSTOMER.' cc WHERE coupon_active="Y" AND cc.cc_coupon_id=c.coupon_id AND cc_customers_id ='.$_SESSION['customer_id'].' ORDER BY coupon_expire_date ASC');

 $expire_coupon_in_week_result = $db->Execute($expire_coupon_in_week_sql);
 $coupon_wei = array();
 while (!$expire_coupon_in_week_result->EOF){
	$coupon_id = $expire_coupon_in_week_result->fields['coupon_id'];
	if ($expire_coupon_in_week_result->fields['coupon_usage'] == 'ru_only' && $_SESSION['languages_id'] != 3) {
		
	}else{
		if($expire_coupon_in_week_result->fields['coupon_type']=='C'){
			$coupon_start_date = $expire_coupon_in_week_result->fields['cc_coupon_start_time'];
			$coupon_end_date = $expire_coupon_in_week_result->fields['cc_coupon_end_time'];
		}else{
			$coupon_start_date = $expire_coupon_in_week_result->fields['coupon_start_date'];
			$coupon_end_date = $expire_coupon_in_week_result->fields['coupon_expire_date'];
		}
		$now = strtotime(date('Y-m-d H:i:s'));
		$now_in_week = strtotime('+1 week');
		if(strtotime($coupon_end_date)>$now && $now_in_week>strtotime($coupon_end_date)){			
			$coupon_track_query = 'select order_id, redeem_date from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id='.$_SESSION['customer_id'].' and coupon_id='.$coupon_id.' order by redeem_date desc ';
			$coupon_track = $db->Execute($coupon_track_query);
			if($coupon_track->RecordCount()>0){
				$used_coupon_times = $coupon_track->RecordCount();
			}else{
				$used_coupon_times = 0 ;
			}
			if($expire_coupon_in_week_result->fields['uses_per_user']>$used_coupon_times||$expire_coupon_in_week_result->fields['uses_per_user'] == 0){				
				
			//	var_dump($expire_coupon_in_week_result->fields['coupon_code']);
				//var_dump($expire_coupon_in_week_result->fields['coupon_id']);
				
				$coupon_wei[] = array(
						'coupon_code' => $expire_coupon_in_week_result->fields['coupon_code'],
						'coupon_expire_date' => $coupon_end_date
				);
			}		
		}	
	}
	$expire_coupon_in_week_result->MoveNext();
}

if(sizeof($coupon_wei)>0){
	$coupon_num = sizeof($coupon_wei);
	$link = ($coupon_num>1)?'<a href="'.zen_href_link(FILENAME_MY_COUPON).'">'.TEXT_VIEW_MORE.'</a>':'';
	$coupon_code_wei = $coupon_wei[0]['coupon_code'];
	$coupon_expire_date_wei = zen_date_long($coupon_wei[0]['coupon_expire_date']);
}

//var_dump($coupon_code);
//var_dump($coupon_expire_date);
?>

<dl class="account_sidemenu">
	<dd><?php ECHO TEXT_TRANSACTIONS;?></dd>
	<dt>
		<ul>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && !isset($_GET['status_id'])) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT,'','SSL');?>"><?php ECHO TEXT_ALL_ORDERS;if($orders_array['all_orders']>0)echo '<span style="color:gray;" class="index_count"> ('.$orders_array['all_orders'].')</span>'?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && ($_GET['status_id'] == 1 || $_GET['status_id'] == 42)) echo ' class="current"'; ?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, 'status_id=1','SSL');?>"><?php echo TEXT_ORDER_STATUS_PENDING;if($orders_array['pending']>0)echo '<span style="color:red;" class="index_count"> ('.$orders_array['pending'].')</span>'?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && $_GET['status_id'] == 2) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, 'status_id=2','SSL');?>"><?php echo TEXT_ORDER_STATUS_PROCESSING;if($orders_array['processing']>0)echo '<span class="index_count" style="color:gray;"> ('.$orders_array['processing'].')</span>';?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && $_GET['status_id'] == 3) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, 'status_id=3','SSL');?>"><?php echo TEXT_ORDER_STATUS_SHIPPED;if($orders_array['shipping']>0)echo '<span style="color:gray;" class="index_count"> ('.$orders_array['shipping'].')</span>'?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && $_GET['status_id'] == 4) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, 'status_id=4','SSL');?>"><?php echo TEXT_ORDER_STATUS_UPDATE;if($orders_array['update'] >0)echo '<span style="color:gray;" class="index_count"> ('.$orders_array['update'] .')</span>'?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && $_GET['status_id'] == 10) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, 'status_id=10','SSL');?>"><?php echo TEXT_DELIVERED;if($orders_array['delivered']>0)echo '<span style="color:gray;" class="index_count"> ('.$orders_array['delivered'].')</span>'?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT && $_GET['status_id'] === 0) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, 'status_id=0','SSL');?>"><?php echo TEXT_ORDER_STATUS_CANCELLED;if($orders_array['cancel']>0)echo '<span style="color:gray;" class="index_count"> ('.$orders_array['cancel'].')</span>'?></a></li>
		</ul>
	</dt>
	<dd  style="border-bottom: 1px dotted #bdbdbd;" <?php if($_GET['main_page'] == FILENAME_PACKING_SLIP) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_PACKING_SLIP,'','SSL');?>"><?php ECHO HEADER_TITLE_PACKING_SLIP;?></a></dd>
	<dd><?php ECHO TEXT_ACCOUNT_SERVICE;?></dd>
	<dt>	
		<ul>
			<li<?php if($_GET['main_page'] == FILENAME_ADDRESS_BOOK) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK,'','SSL');?>"><?php ECHO TEXT_ADDRESS_BOOK;?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_ACCOUNT_EDIT) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_EDIT,'','SSL');?>"><?php ECHO TEXT_ACCOUNT_INFORMATION;?></a></li>
	    <?php 
	   
	    if(!$_COOKIE['do_not_show_new_function_guide'] && $coupon_num>0){
	    	echo '<div class="guidemain">
			<div class="guidearrow"> <img src="includes/templates/cherry_zen/images/arrow_guide.png" border="0" /> </div>
			<div class="guidebody">
			<div><span>X</span></div>
				<!--<h3>N</h3><p>ss</p>-->
	            '. sprintf(TEXT_COUPON_NOTICE_FIRST,$coupon_code_wei,$coupon_expire_date_wei).$link.TEXT_COUPON_NITICE_SECOND.'  		
			</div>
	     </div>'  ;
	    }?>
		
			<li<?php if($_GET['main_page'] == FILENAME_MY_COUPON) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_MY_COUPON,'','SSL');?>"><?php ECHO TEXT_MY_COUPON;?></a>	
			</li>
		</ul>
	</dt>
	<dd><?php ECHO TEXT_MESSAGE;?></dd>
	<dt>
		<ul>
			<li<?php if($_GET['main_page'] == FILENAME_MESSAGE_LIST) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST,'','SSL');?>"><?php ECHO TEXT_MY_MESSAGE;?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_MESSAGE_SETTING) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_MESSAGE_SETTING,'','SSL');?>"><?php ECHO TEXT_MESSAGE_SETTING;?></a></li>
		</ul>
	</dt>
	<dd><?php ECHO TEXT_CASH_ACOUNT;?></dd>
	<dt>
		<ul><li<?php if($_GET['main_page'] == FILENAME_CASH_ACCOUNTS) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_CASH_ACCOUNTS,'','SSL');?>"><?php ECHO TEXT_BLANCE;?></a></li></ul>
	</dt>
	<dd><?php ECHO TEXT_EMAIL_NOTIFICATIONS;?></dd>
	<dt>
		<ul><li<?php if($_GET['main_page'] == FILENAME_ACCOUNT_NEWSLETTERS) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS,'','SSL');?>"><?php ECHO TEXT_MODIFY_SUBSCRITION;?></a></li></ul>
	</dt>
	<?php $sql = $db->Execute("select customers_dropper_id from " .  TABLE_PROMETERS_COMMISSION . "  where customers_dropper_id = " . $_SESSION['customer_id']); 
	    $customers_dropper_id = $sql->fields['customers_dropper_id'];
	    if(!empty($customers_dropper_id)){
	 ?>
	<dd><?php ECHO TEXT_AFFILIATE_PROGRAM;?></dd>
	<dt>
		<ul>
			<li<?php if($_GET['main_page'] == FILENAME_MY_COMMISSION) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_MY_COMMISSION,'','SSL');?>"><?php ECHO TEXT_MY_COMMISSION;?></a></li>
			<li<?php if($_GET['main_page'] == FILENAME_COMMISSION_SET) echo ' class="current"';?>><a href="<?php echo zen_href_link(FILENAME_COMMISSION_SET,'','SSL');?>"><?php ECHO TEXT_SETTINGS;?></a></li>
		</ul>
	</dt>
	<?php } ?>
</dl>
