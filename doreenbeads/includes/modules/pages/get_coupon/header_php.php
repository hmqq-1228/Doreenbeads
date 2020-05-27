<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/my_coupon.php');

$breadcrumb->add(NAVBAR_TITLE);

$time = date('Y-m-d H:i:s');
if(GET_COUPON_EVENT_START_TIME > $time || GET_COUPON_EVENT_END_TIME < $time || GET_COUPON_EVENT_IDS == ''){
	zen_redirect ( zen_href_link ( FILENAME_DEFAULT ) );
}

//Tianwen.Wan20160614
$array_coupon_active = array('CP2018071002' => 1, 'CP2018071005' => 1, 'CP2018071010' => 1, 'CP2018071015' => 1);
if(!empty($_SESSION['customer_id'])) {
	$array_coupon_customer = $db->Execute('select c.coupon_code from ' . TABLE_COUPONS . ' c inner join ' . TABLE_COUPON_CUSTOMER . ' cc on cc.cc_coupon_id=c.coupon_id and cc_customers_id=' . $_SESSION['customer_id'] . ' and c.coupon_code in("CP2018071002", "CP2018071005", "CP2018071010", "CP2018071015")');
	while(!$array_coupon_customer->EOF){
		$array_coupon_active[$array_coupon_customer->fields['coupon_code']] = 0;
		$array_coupon_customer->MoveNext();
	}

}else {
	$array_coupon_active = array('CP2018071002' => 1, 'CP2018071005' => 1, 'CP2018071010' => 1, 'CP2018071015' => 1);
}
//print_r($array_coupon_active);exit;

/*
//	bof get coupon
if(isset($_GET['action']) && $_GET['action']=='get_coupon' && isset($_GET['c_id']) && $_GET['c_id']!=''){
	if (! isset ( $_SESSION ['customer_id'] )) {
		zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
	}
	$error = '';
	$cp_id = intval($_GET['c_id']);
	$coupon_exist = $db->Execute('select coupon_id, coupon_type, coupon_code, coupon_start_date, coupon_expire_date, day_after_add from '. TABLE_COUPONS .' where coupon_id="'.$cp_id.'" and coupon_active="Y" and coupon_addable=1');
	if($coupon_exist->RecordCount() <= 0){
		$error = TEXT_WRONG_COUPON_CODE;
	}else if($coupon_exist->fields['coupon_start_date'] > $time || $coupon_exist->fields['coupon_expire_date'] < $time){		//	未开始/已过期
		$error = TEXT_EXPIRED_COUPON_CODE;
	}else{
		$coupon_customer = $db->Execute('select cc_id from '. TABLE_COUPON_CUSTOMER .' where cc_coupon_id='.$cp_id.' and cc_customers_id ='.intval($_SESSION['customer_id']));
		if($coupon_customer->RecordCount() > 0){	//	已经领取过
			$error = TEXT_OWNED_COUPON_CODE;
		}else{
			if($coupon_exist->fields['day_after_add'] > 0){
				$start = $time;
				$end = date('Y-m-d H:i:s', strtotime("+ ".$coupon_exist->fields['day_after_add']." day"));
				$db->Execute('insert into '. TABLE_COUPON_CUSTOMER .' (`cc_coupon_id`,`cc_customers_id`,`cc_coupon_start_time`,`cc_coupon_end_time`,`cc_coupon_status`,`date_created`) values ('.$cp_id.','.intval($_SESSION['customer_id']).',"'.$start.'","'.$end.'", 10, now())');
			}else{
				$db->Execute('insert into '. TABLE_COUPON_CUSTOMER .' (`cc_coupon_id`,`cc_customers_id`,`cc_coupon_status`,`date_created`) values ('.$cp_id.','.intval($_SESSION['customer_id']).', 10, now())');
			}
		}
	}

	if($error != '')
		$messageStack->add_session('get_coupon', $error, 'error');
//	else
//		$messageStack->add_session('get_coupon', TEXT_COUPON_ADD_SUCCESS, 'success');
	zen_redirect(zen_href_link('get_coupon'));
}
//	eof

$coupon = $db->Execute('select coupon_id from '.TABLE_COUPONS.' where coupon_active = "Y" and coupon_addable=1 and coupon_id in ('.GET_COUPON_EVENT_IDS.')');
if($coupon->RecordCount() > 0) while(!$coupon->EOF){
	$class_str = 'class'.$coupon->fields['coupon_id'];
	$href_str = 'href'.$coupon->fields['coupon_id'];
	if(!$_SESSION['customer_id']){
		$$class_str = ' getCouponLogin ';
		$$href_str = 'javascript:void(0)';
	}else{
		$coupon_customer = $db->Execute('select cc_coupon_id from '.TABLE_COUPON_CUSTOMER.' where cc_customers_id ='.intval($_SESSION['customer_id']).' and cc_coupon_id='.intval($coupon->fields['coupon_id']));
		$$class_str = $coupon_customer->RecordCount() > 0 ? ' grey ' : '';
		$$href_str = $coupon_customer->RecordCount() > 0 ? 'javascript:void(0)' : zen_href_link('get_coupon', 'action=get_coupon&c_id='.intval($coupon->fields['coupon_id']));
	
	}

	$coupon->MoveNext();
}
*/
?>