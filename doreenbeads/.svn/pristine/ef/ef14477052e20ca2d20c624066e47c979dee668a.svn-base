<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$time = date('Y-m-d H:i:s');
if(GET_COUPON_EVENT_START_TIME > $time || GET_COUPON_EVENT_END_TIME < $time || GET_COUPON_EVENT_IDS == ''){
	zen_redirect ( zen_href_link ( FILENAME_DEFAULT ) );
}

//登录完成后返回到这里
if(empty($_SESSION['customer_id'])) {
	$_SESSION['navigation']->set_snapshot();
}

//Tianwen.Wan20160615
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

$smarty->assign('array_coupon_active', $array_coupon_active );
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES  . $_SESSION['language'] .'/html_includes/', 'define_mobile_get_coupon.php', 'false');
//echo $define_page;exit;
$smarty->assign ( 'define_page', $define_page );
$tpl = DIR_WS_TEMPLATE.'tpl/tpl_get_coupon.html';

?>