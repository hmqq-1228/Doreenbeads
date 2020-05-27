<?php
/**
* 更新COUPON状态
* @author	WanTianwen
* @version	1.0 20151206
*/
require('includes/application_top.php');
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$action = $_GET['action'];
$suffix = "";
if($action == "update") {
	$sql1 = "update " . TABLE_COUPON_CUSTOMER . $suffix . " set cc_coupon_status=30 where cc_coupon_status=10 and cc_coupon_end_time<'" . date("Y-m-d H:i:s", time()) . "' and cc_coupon_end_time is not null and cc_coupon_end_time!='0000-00-00 00:00:00'";
	$sql2 = "update " . TABLE_COUPON_CUSTOMER . $suffix . " set cc_coupon_status=30 where cc_coupon_status=10 and (cc_coupon_end_time is null or cc_coupon_end_time='0000-00-00 00:00:00') and cc_coupon_id in(select coupon_id from t_coupons" . $suffix . " where coupon_expire_date is not null and coupon_expire_date!='0000-00-00 00:00:00' and coupon_expire_date<'" . date("Y-m-d H:i:s", time()) . "')";
    
    $db->Execute($sql1);
    $db->Execute($sql2);
    //$db->Execute("update " . TABLE_COUPON_CUSTOMER . $suffix . " set cc_coupon_status=40 where cc_coupon_status=10 and cc_coupon_id not in(select coupon_id from t_coupons" . $suffix . ")");
    //header("Location:temp_coupon_update.php?action=update4");
    echo 'success';
}

file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>