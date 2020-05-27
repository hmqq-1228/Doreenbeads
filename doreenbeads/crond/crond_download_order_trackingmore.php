<?php
chdir("../");
require ("includes/application_top.php");
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'download') {
	
	$date_now = date("YmdH");
	$extract_dir = "file/order_trackingmore/";

	
	$filename = download_file(HTTP_ERP_URL . "/download/erp_products_transinfo_website_code_" . WEBSITE_CODE . "_" . $date_now . ".zip", $extract_dir, "erp_order_transinfo_website_code_" . WEBSITE_CODE . "_" . $date_now . ".zip", true);
	$zip = new ZipArchive;
	if($zip->open($extract_dir . "erp_order_transinfo_website_code_" . WEBSITE_CODE . "_" . $date_now . ".zip") === true) {
		$zip->extractTo($extract_dir);
	}
	if(is_file($extract_dir . "erp_order_transinfo_website_code_" . WEBSITE_CODE . "_" . $date_now . ".txt")) {
		$db->begin();
		
		$prod_group = file_get_contents($extract_dir . "erp_order_transinfo_website_code_" . WEBSITE_CODE . "_" . $date_now . ".txt");
		
		$prod_group_array = explode("\r\n", $prod_group);
		//Tianwen.Wan20170908->如果用truncate事务会失效
		for($index = 1; $index < count($prod_group_array); $index++) {
			$prod_group_value_array = explode("|^", $prod_group_array[$index]);
			if(is_numeric($prod_group_value_array[0]) && is_numeric($prod_group_value_array[9])) {
				$trackingmore_sql = "select tracking_id from " . TABLE_ORDERS_TRACKIMGMORE . " where tracking_id = " . $prod_group_value_array[0] . " and orders_id = " . $prod_group_value_array[9];
				$trackingmore_result = $db->Execute($trackingmore_sql);
				if($trackingmore_result->RecordCount() <= 0) {
					$insert_prod_group = "insert into " . TABLE_ORDERS_TRACKIMGMORE . " (tracking_id, tracking_create_id, tracking_last_update_time, tracking_status, tracking_get_date, tracking_description, tracking_details, tracking_shipping_code, tracking_number, orders_id, date_created) values (" . $prod_group_value_array[0] . ", " . $prod_group_value_array[1] . ", '" . $prod_group_value_array[2] . "', '" . $prod_group_value_array[3] . "', '" . $prod_group_value_array[4] . "', '" . addslashes(trim($prod_group_value_array[5])) . "', '" . addslashes(trim($prod_group_value_array[6])) . "', '" . $prod_group_value_array[7] . "', '" . $prod_group_value_array[8] . "', " . $prod_group_value_array[9] . ", now())";
					$db->Execute($insert_prod_group);
				}
			}
		}
		
		$db->commit();
		unlink($extract_dir . "erp_order_transinfo_website_code_" . WEBSITE_CODE . "_" . $date_now . ".txt");
	}
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>