<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(TEXT_MY_COUPON);

if (! isset ( $_SESSION ['customer_id'] )) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}

//	bof add coupon

if(isset($_POST['action']) && $_POST['action']=='add_coupon'){
	$cp_code = zen_db_prepare_input($_POST['add_coupon_code']);
	$error_info = add_coupon_code($cp_code);

	if($error_info['is_error']){
		$error = $error_info['error_info'];
	}
	if($error != ''){
		$messageStack->add_session('my_coupon', $error, 'error');
	}else{
		$messageStack->add_session('my_coupon', TEXT_COUPON_ADD_SUCCESS, 'success');
	}
	zen_redirect(zen_href_link(FILENAME_MY_COUPON));
}
//	eof

$active_coupon_array = array();
$inactive_coupon_array = array();
$current_pst_date = date('Y-m-d H:i:s');
/*
$customers_coupon_query = 'select coupon_id, coupon_type, coupon_code, coupon_amount, coupon_minimum_order, coupon_start_date, coupon_expire_date, uses_per_user, coupon_usage,cc_id,cc.cc_coupon_start_time,cc.cc_coupon_end_time from '.TABLE_COUPONS.' c,'.TABLE_COUPON_CUSTOMER.' cc where coupon_active="Y" and cc.cc_coupon_id=c.coupon_id and cc_customers_id ='.$_SESSION['customer_id'].' order by cc.cc_id desc';
$customers_coupon = $db->Execute($customers_coupon_query);
$i = 0;
$coupon_code_array = array();
$coupon_use_array = array();
$coupon_array = array();
//	all coupon_customer list
while(!$customers_coupon->EOF){
	if ($customers_coupon->fields['coupon_usage'] == 'ru_only' && $_SESSION['languages_id'] != 3) {

	}else{
		if($customers_coupon->fields['coupon_type']=='P'){
			$conpon_type = TEXT_DISCOUNT_COUPONS;
			$conpon_value = number_format($customers_coupon->fields['coupon_amount'],2) . '%&nbsp;off';
		}elseif($customers_coupon->fields['coupon_type']=='F'||$customers_coupon->fields['coupon_type']=='C'){
			$conpon_type = TEXT_CASH_COUPONS;
			$conpon_value = $currencies->format($customers_coupon->fields['coupon_amount']);
		}
		$coupon_id = $customers_coupon->fields['coupon_id'];
		$coupon_code = $customers_coupon->fields['coupon_code'];
		if($customers_coupon->fields['coupon_minimum_order'] > 0){
			$min_order = $currencies->format($customers_coupon->fields['coupon_minimum_order']);
		}else{
			$min_order = '/';
		}
		$used_this_coupon = false;
		$used_coupon_times = 0;
		if($customers_coupon->fields['coupon_type']=='C'){
			$coupon_start_date = $customers_coupon->fields['cc_coupon_start_time'];
			$coupon_expire_date = $customers_coupon->fields['cc_coupon_end_time'];
		}else{
			$coupon_start_date = $customers_coupon->fields['coupon_start_date'];
			$coupon_expire_date = $customers_coupon->fields['coupon_expire_date'];
		}
		$coupon_date_format = date('M d, Y H:i', strtotime($coupon_start_date)).' - '.date('M d, Y H:i', strtotime($coupon_expire_date));
						
		if($coupon_expire_date == '2019-02-28 00:00:00'){
			$coupon_date_format = '';
		}
		$uses_per_user = $customers_coupon->fields['uses_per_user'];
		if((in_array($coupon_code, array('CP2014040901','CP2014040902','CP2014040903')))){

			$coupon_use = $db->Execute('select coupon_id,order_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id = ' . $_SESSION ['customer_id'] . ' and coupon_id = '.$customers_coupon->fields['coupon_id'].'');
			$order_coupon = $db->Execute("select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where  cc_customers_id =  ".$_SESSION['customer_id']." and cc_coupon_id = ".$customers_coupon->fields['coupon_id']."");

			if($order_coupon->RecordCount() > 0 && !isset($coupon_array[$order_coupon->fields['cc_orders_id']])){
				$coupon_array[$order_coupon->fields['cc_orders_id']] = $order_coupon->RecordCount();
			}

			if($coupon_use->RecordCount() > 0){
				if(!isset($coupon_use_array[$coupon_use->fields['coupon_id']])){
					$coupon_use_array[$coupon_use->fields['coupon_id']] = $coupon_use->RecordCount();
				}
			}else{
				$coupon_use_array[$coupon_use->fields['coupon_id']] = 0;
			}

			if($coupon_array[$order_coupon->fields['cc_orders_id']] > $coupon_use_array[$coupon_use->fields['coupon_id']]){
				$coupon_use_array[$coupon_use->fields['coupon_id']]++;
			}else{
				$uses_per_user = 1;
			}

		}
		
		$coupon_track=$db->Execute('select order_id, redeem_date,coupon_to_customer_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id='.$_SESSION['customer_id'].' and coupon_to_customer_id='.$customers_coupon->fields['cc_id'].' order by redeem_date  desc ');
		if($coupon_track->RecordCount()==0){
			$coupon_track=$db->Execute('select order_id, redeem_date from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id='.$_SESSION['customer_id'].' and coupon_to_customer_id=0 and coupon_id='.$coupon_id.' order by redeem_date desc ');
		}
		if($coupon_track->RecordCount()>0){
			$used_this_coupon = true;
			$used_coupon_times = $coupon_track->RecordCount();
		}
		if(! $uses_per_user){
			if($current_pst_date<=$coupon_expire_date ){
				if($coupon_expire_date == '2019-02-28 00:00:00'){
					$coupon_expire_date = '/';
				}
				$active_coupon_array[$i] = array('id'=>$coupon_id,
						'coupon_code'=>$coupon_code,
						'type'=>$conpon_type,
						'value'=>$conpon_value,
						'min_order'=>$min_order,
						'deadline'=>$coupon_expire_date,
						'date_format'=>$coupon_date_format
				);
			}else{
				if(!$used_this_coupon){
					$inactive_coupon_array[] = array('id'=>$coupon_id,
							'coupon_code'=>$coupon_code,
							'type'=>$conpon_type,
							'value'=>$conpon_value,
							'status'=>TEXT_EXPIRED_COUPON,
							'min_order'=>$min_order,
							'orders_id'=>' ',
							'used_time'=>' ',
							'date_format'=>$coupon_date_format
					);
				}
			}
		}else{
			if($current_pst_date<=$coupon_expire_date && $used_coupon_times<$uses_per_user){
				if($coupon_expire_date == '2019-02-28 00:00:00'){
					$coupon_expire_date = '/';
				}
				$active_coupon_array[$i]= array('id'=>$coupon_id,
						'coupon_code'=>$coupon_code,
						'type'=>$conpon_type,
						'value'=>$conpon_value,
						'min_order'=>$min_order,
						'deadline'=>$coupon_expire_date,
						'date_format'=>$coupon_date_format
				);
			}else if($current_pst_date>$coupon_expire_date){
				$inactive_coupon_array[]= array('id'=>$coupon_id,
						'coupon_code'=>$coupon_code,
						'type'=>$conpon_type,
						'value'=>$conpon_value,
						'status'=>TEXT_EXPIRED_COUPON,
						'min_order'=>$min_order,
						'orders_id'=>' ',
						'used_time'=>' ',
						'date_format'=>$coupon_date_format
				);
			}else if($used_coupon_times>=$uses_per_user){
				if((in_array($coupon_id, $coupon_code_array))){
					$customers_coupon->MoveNext();
					continue;
				}
				if((in_array($coupon_code, array('CP2014040901','CP2014040902','CP2014040903')))){
					$coupon_code_array[] = $coupon_id;
				}

				while(!$coupon_track->EOF){
					$inactive_coupon_array[] = array('id'=>$coupon_id,
							'coupon_code'=>$coupon_code,
							'type'=>$conpon_type,
							'value'=>$conpon_value,
							'status'=>TEXT_USED_COUPON,
							'min_order'=>$min_order,
							'orders_id'=>'<a href="'.zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO,'order_id='.$coupon_track->fields['order_id']).'" target="_blank" style="color:#0481DB">'.'#'.$coupon_track->fields['order_id'].'</a>',
							'used_time'=>date('M d, Y',strtotime($coupon_track->fields['redeem_date'])),
							'date_format'=>$coupon_date_format
					);
					$coupon_track->MoveNext();
				}
			}
		}
		$i++;
	}
	$customers_coupon->MoveNext();
}
*/

$customers_coupon_query = 'select coupon_id, coupon_type, coupon_code, coupon_amount, coupon_minimum_order, coupon_start_date, coupon_expire_date, uses_per_user, coupon_usage,cc_id,cc.cc_coupon_start_time,cc.cc_coupon_end_time,cc.cc_coupon_status,cc.date_created from '.TABLE_COUPONS.' c,'.TABLE_COUPON_CUSTOMER.' cc where coupon_active="Y" and cc.cc_coupon_id=c.coupon_id and cc_customers_id ='.$_SESSION['customer_id'].' and cc.cc_coupon_status=10 order by cc.cc_id desc';
$customers_coupon = $db->Execute($customers_coupon_query);
$i = 0;
$coupon_code_array = array();
$coupon_use_array = array();
$coupon_array = array();
//	all coupon_customer list
while(!$customers_coupon->EOF){
	if ($customers_coupon->fields['coupon_usage'] == 'ru_only' && $_SESSION['languages_id'] != 3) {

	}else{
		if($customers_coupon->fields['coupon_type']=='P'){
			$conpon_type = TEXT_DISCOUNT_COUPONS;
			$conpon_value = number_format($customers_coupon->fields['coupon_amount'],2) . '%&nbsp;off';
		}elseif($customers_coupon->fields['coupon_type']=='F'||$customers_coupon->fields['coupon_type']=='C'){
			$conpon_type = TEXT_CASH_COUPONS;
			$conpon_value = $currencies->format($customers_coupon->fields['coupon_amount']);
		}
		$coupon_id = $customers_coupon->fields['coupon_id'];
		$coupon_code = $customers_coupon->fields['coupon_code'];
		if($customers_coupon->fields['coupon_minimum_order'] > 0){
			$min_order = $currencies->format($customers_coupon->fields['coupon_minimum_order']);
		}else{
			$min_order = '/';
		}
		$used_this_coupon = false;
		$used_coupon_times = 0;
		if($customers_coupon->fields['coupon_type']=='C'){
			$coupon_start_date = $customers_coupon->fields['cc_coupon_start_time'];
			$coupon_expire_date = $customers_coupon->fields['cc_coupon_end_time'];
		}else{
			$coupon_start_date = $customers_coupon->fields['coupon_start_date'];
			$coupon_expire_date = $customers_coupon->fields['coupon_expire_date'];
		}
		//$coupon_date_format = date('M d, Y H:i', strtotime($coupon_start_date)).' - '.date('M d, Y H:i', strtotime($coupon_expire_date));
		$coupon_date_format = zen_date_long($coupon_start_date).' - '.zen_date_long($coupon_expire_date);
						
		if($coupon_expire_date == '2019-02-28 00:00:00'){
			$coupon_date_format = '';
		}
		$uses_per_user = $customers_coupon->fields['uses_per_user'];
		if((in_array($coupon_code, array('CP2014040901','CP2014040902','CP2014040903')))){

			$coupon_use = $db->Execute('select coupon_id,order_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id = ' . $_SESSION ['customer_id'] . ' and coupon_id = '.$customers_coupon->fields['coupon_id'].'');
			$order_coupon = $db->Execute("select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where  cc_customers_id =  ".$_SESSION['customer_id']." and cc_coupon_id = ".$customers_coupon->fields['coupon_id']."");

			if($order_coupon->RecordCount() > 0 && !isset($coupon_array[$order_coupon->fields['cc_orders_id']])){
				$coupon_array[$order_coupon->fields['cc_orders_id']] = $order_coupon->RecordCount();
			}

			if($coupon_use->RecordCount() > 0){
				if(!isset($coupon_use_array[$coupon_use->fields['coupon_id']])){
					$coupon_use_array[$coupon_use->fields['coupon_id']] = $coupon_use->RecordCount();
				}
			}else{
				$coupon_use_array[$coupon_use->fields['coupon_id']] = 0;
			}

			if($coupon_array[$order_coupon->fields['cc_orders_id']] > $coupon_use_array[$coupon_use->fields['coupon_id']]){
				$coupon_use_array[$coupon_use->fields['coupon_id']]++;
			}else{
				$uses_per_user = 1;
			}

		}
		
		$active_coupon_array[$i] = array('id'=>$coupon_id,
				'coupon_code'=>$coupon_code,
				'type'=>$conpon_type,
				'value'=>$conpon_value,
				'min_order'=>$min_order,
				'deadline'=>zen_date_long($coupon_expire_date),
				'date_format'=>$coupon_date_format,
				'date_created'=>$customers_coupon->fields['date_created'] != '0000-00-00 00:00:00' ? zen_date_long($customers_coupon->fields['date_created']) : '/'
		);
		$i++;
	}
	$customers_coupon->MoveNext();
}

$customers_coupon_query = 'select coupon_id, coupon_type, coupon_code, coupon_amount, coupon_minimum_order, coupon_start_date, coupon_expire_date, uses_per_user, coupon_usage,cc_id,cc.cc_coupon_start_time,cc.cc_coupon_end_time,cc.cc_coupon_status,cc.date_created from '.TABLE_COUPONS.' c,'.TABLE_COUPON_CUSTOMER.' cc where coupon_active="Y" and cc.cc_coupon_id=c.coupon_id and cc_customers_id ='.$_SESSION['customer_id'].' and cc.cc_coupon_status!=10 order by cc.cc_id desc';
$customers_coupon = $db->Execute($customers_coupon_query);
$i = 0;
$coupon_code_array = array();
$coupon_use_array = array();
$coupon_array = array();
//	all coupon_customer list
while(!$customers_coupon->EOF){
	if ($customers_coupon->fields['coupon_usage'] == 'ru_only' && $_SESSION['languages_id'] != 3) {

	}else{
		if($customers_coupon->fields['coupon_type']=='P'){
			$conpon_type = TEXT_DISCOUNT_COUPONS;
			$conpon_value = number_format($customers_coupon->fields['coupon_amount'],2) . '%&nbsp;off';
		}elseif($customers_coupon->fields['coupon_type']=='F'||$customers_coupon->fields['coupon_type']=='C'){
			$conpon_type = TEXT_CASH_COUPONS;
			$conpon_value = $currencies->format($customers_coupon->fields['coupon_amount']);
		}
		$coupon_id = $customers_coupon->fields['coupon_id'];
		$coupon_code = $customers_coupon->fields['coupon_code'];
		if($customers_coupon->fields['coupon_minimum_order'] > 0){
			$min_order = $currencies->format($customers_coupon->fields['coupon_minimum_order']);
		}else{
			$min_order = '/';
		}
		$used_this_coupon = false;
		$used_coupon_times = 0;
		if($customers_coupon->fields['coupon_type']=='C'){
			$coupon_start_date = $customers_coupon->fields['cc_coupon_start_time'];
			$coupon_expire_date = $customers_coupon->fields['cc_coupon_end_time'];
		}else{
			$coupon_start_date = $customers_coupon->fields['coupon_start_date'];
			$coupon_expire_date = $customers_coupon->fields['coupon_expire_date'];
		}
		//$coupon_date_format = date('M d, Y H:i', strtotime($coupon_start_date)).' - '.date('M d, Y H:i', strtotime($coupon_expire_date));
		$coupon_date_format = zen_date_long($coupon_start_date).' - '.zen_date_long($coupon_expire_date);
						
		if($coupon_expire_date == '2019-02-28 00:00:00'){
			$coupon_date_format = '';
		}
		$uses_per_user = $customers_coupon->fields['uses_per_user'];
		if((in_array($coupon_code, array('CP2014040901','CP2014040902','CP2014040903')))){

			$coupon_use = $db->Execute('select coupon_id,order_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id = ' . $_SESSION ['customer_id'] . ' and coupon_id = '.$customers_coupon->fields['coupon_id'].'');
			$order_coupon = $db->Execute("select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where  cc_customers_id =  ".$_SESSION['customer_id']." and cc_coupon_id = ".$customers_coupon->fields['coupon_id']."");

			if($order_coupon->RecordCount() > 0 && !isset($coupon_array[$order_coupon->fields['cc_orders_id']])){
				$coupon_array[$order_coupon->fields['cc_orders_id']] = $order_coupon->RecordCount();
			}

			if($coupon_use->RecordCount() > 0){
				if(!isset($coupon_use_array[$coupon_use->fields['coupon_id']])){
					$coupon_use_array[$coupon_use->fields['coupon_id']] = $coupon_use->RecordCount();
				}
			}else{
				$coupon_use_array[$coupon_use->fields['coupon_id']] = 0;
			}

			if($coupon_array[$order_coupon->fields['cc_orders_id']] > $coupon_use_array[$coupon_use->fields['coupon_id']]){
				$coupon_use_array[$coupon_use->fields['coupon_id']]++;
			}else{
				$uses_per_user = 1;
			}

		}
		
		$ordersId = $usedTime = $status = "";
		if($customers_coupon->fields['cc_coupon_status'] == '10') {
			
		} else if($customers_coupon->fields['cc_coupon_status'] == '20') {
			$status = TEXT_USED_COUPON;
			$coupon_track=$db->Execute('select order_id, redeem_date from '.TABLE_COUPON_REDEEM_TRACK.' where coupon_customer_id=' . $customers_coupon->fields['cc_id']);
			if($coupon_track->RecordCount()>0){
				$ordersId = '<a href="'.zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO,'order_id='.$coupon_track->fields['order_id']).'" style="color:#0481DB">'.'#'.$coupon_track->fields['order_id'].'</a>';
				$usedTime = $coupon_track->fields['redeem_date'] != '0000-00-00 00:00:00' ? zen_date_long($coupon_track->fields['redeem_date']) : '';
			}
		} else if($customers_coupon->fields['cc_coupon_status'] == '30') {
			$status = TEXT_EXPIRED_COUPON; 
		} else if($customers_coupon->fields['cc_coupon_status'] == '40') {
			$status = TEXT_DELETED;
		}
	
		$inactive_coupon_array[] = array('id'=>$coupon_id,
				'coupon_code'=>$coupon_code,
				'type'=>$conpon_type,
				'value'=>$conpon_value,
				'status'=>$status,
				'min_order'=>$min_order,
				'orders_id'=>$ordersId,
				'used_time'=>$usedTime,
				'date_format'=>$coupon_date_format,
				'date_created'=>$customers_coupon->fields['date_created'] != '0000-00-00 00:00:00' ? zen_date_long($customers_coupon->fields['date_created']) : '/'
		);
		$i++;
	}
	$customers_coupon->MoveNext();
}

$inactive_coupon_str = $active_coupon_str = '';
$active_page = 1;
$page_size = 20;
$inactive_page = 1;
if(isset($_POST['cpage']) && $_POST['target']=='inactive'){
	$inactive_page = $_POST['cpage'];
}
if(isset($_POST['cpage']) && $_POST['target']=='active'){
	$active_page = $_POST['cpage'];
}
$inactive_total_page = ceil(sizeof($inactive_coupon_array) / $page_size);
$active_total_page = ceil(sizeof($active_coupon_array) / $page_size);

$inactive_coupon_str = '<tr><th width="140">'.TEXT_COUPON_CODE.'</th><th width="120">'.TEXT_COUPON_PAR_VALUE.'</th><th width="120">'.TEXT_COUPON_MIN_ORDER.'</th><th width="100">'.TEXT_COUPON_STATUS.'</th><th width="120">'.TEXT_DATE_ADDED.'</th><th width="140">'.TEXT_COUPON_ORDER_NUMBER.'</th><th width="120">'.TEXT_COUPON_USED_TIME.'</th></tr>';
if(sizeof($inactive_coupon_array)){
	for($i=$page_size*($inactive_page-1);($i<=($inactive_page*$page_size-1)&&$i<sizeof($inactive_coupon_array));$i++){
		$val = $inactive_coupon_array[$i];
		$coupon_name_que = $db->Execute('select coupon_name,coupon_description from '.TABLE_COUPONS_DESCRIPTION.' where coupon_id='.intval($val['id']).' and language_id in ('.intval($_SESSION['languages_id']).',1) order by language_id desc limit 1');
		$dateAdded = $inactive_coupon_array[$i]['date_created'];
		$coupin_info = '';
		if(!empty($coupon_name_que->fields['coupon_name'])) {
			$coupin_info .= $coupon_name_que->fields['coupon_name'] . '<br/>';
		}
		if(!empty($coupon_name_que->fields['coupon_description']) && $coupon_name_que->fields['coupon_description'] != $coupon_name_que->fields['coupon_name']) {
			$coupin_info .= $coupon_name_que->fields['coupon_description'] . '<br/>';
		}
		$inactive_coupon_str .= '<tr><td>'.$val['coupon_code'].'</td><td>'.$val['value'].'</td><td>'.$val['min_order'].'</td><td>'.$val['status'].'</td><td>'.$dateAdded.'</td><td>'.$val['orders_id'].'</td><td>'.$val['used_time'].'<div class="coupon-deadlinecont"><ins class="coupon-deadlineicon"></ins><div class="coupon-deadline"><span class="bot"></span><span class="top"></span>'.$coupin_info.$val['date_format'].'</div></div></td></tr>';
	}
	$inactive_coupon_str .= '</table>';
	$mycoupon_split = new splitPageResults('', $page_size, '', 'cpage', false, sizeof($inactive_coupon_array));
	$inactive_coupon_str .= '<div class="propagelist spilttd">'.$mycoupon_split->display_links_for_review().'</div>';
}else{
	$inactive_coupon_str .= '<tr><td colspan="7"><strong>'.TEXT_NO_RECORD.'</strong></td></tr></table>';
}
if($_POST['target']=='inactive'&&isset($_POST['cpage'])){
	echo $inactive_coupon_str;
	exit;
}

$active_coupon_str = '<tr><th width="160">'.TEXT_COUPON_CODE.'</th><th width="135">'.TEXT_COUPON_PAR_VALUE.'</th><th width="140">'.TEXT_COUPON_MIN_ORDER.'</th><th width="160">'.TEXT_DATE_ADDED.'</th><th width="165">'.TEXT_COUPON_DEADLINE.'</th></tr>';
if(sizeof($active_coupon_array)){
	$active_coupon_array = array_merge($active_coupon_array);	//	lvxiaoyong 20131107 re-sort array, key start from 0
	for($i=$page_size*($active_page-1);($i<=($active_page*$page_size-1)&&$i<sizeof($active_coupon_array));$i++){
		$val = $active_coupon_array[$i];
		$coupon_name_que = $db->Execute('select coupon_name,coupon_description from '.TABLE_COUPONS_DESCRIPTION.' where coupon_id='.intval($val['id']).' and language_id in ('.intval($_SESSION['languages_id']).',1) order by language_id desc limit 1');
		$dateAdded = $active_coupon_array[$i]['date_created'];
		$coupin_info = '';
		if(!empty($coupon_name_que->fields['coupon_name'])) {
			$coupin_info .= $coupon_name_que->fields['coupon_name'] . '<br/>';
		}
		if(!empty($coupon_name_que->fields['coupon_description']) && $coupon_name_que->fields['coupon_description'] != $coupon_name_que->fields['coupon_name']) {
			$coupin_info .= $coupon_name_que->fields['coupon_description'] . '<br/>';
		}
		$active_coupon_str .= '<tr><td>'.$val['coupon_code'].'</td><td>'.$val['value'].'</td><td>'.$val['min_order'].'</td><td>'.$dateAdded.'<td>'.$val['deadline'].'<div class="coupon-deadlinecont"><ins class="coupon-deadlineicon"></ins><div class="coupon-deadline"><span class="bot"></span><span class="top"></span>'.$coupin_info.$val['date_format'].'</div></div></td></tr>';
	}
	$active_coupon_str .= '</table>';
	$mycoupon_split = new splitPageResults('', $page_size, '', 'cpage', false, sizeof($active_coupon_array));
	$active_coupon_str .= '<div class="propagelist spilttd active">'.$mycoupon_split->display_links_for_review().'</div>';
}else{
	$active_coupon_str .= '<tr><td colspan="6"><strong>'.TEXT_NO_RECORD.'</strong></td></tr></table>';
}
if($_POST['target']=='active'&&isset($_POST['cpage'])){
	echo $active_coupon_str;
	exit;
}
?>