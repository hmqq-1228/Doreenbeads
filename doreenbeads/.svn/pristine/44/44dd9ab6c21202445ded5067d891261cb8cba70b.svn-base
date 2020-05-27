<?php
chdir("../");
require ("includes/application_top.php");
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'download') {
	
	$date_now = date("Ymd");
	$extract_dir = "file/products_group/";
	
	//if(is_file($extract_dir . "erp_products_group_" . $date_now . ".zip")) {
	//	die("file already exists");
	//}
	
	$filename = download_file(HTTP_ERP_URL . "/download/erp_products_group_" . $date_now . ".zip", $extract_dir, "erp_products_group_" . $date_now . ".zip", true);
	$zip = new ZipArchive;
	if($zip->open($extract_dir . "erp_products_group_" . $date_now . ".zip") === true) {
		$zip->extractTo($extract_dir);
	}
	if(is_file($extract_dir . "t_prod_group.txt") && is_file($extract_dir . "t_prod_group_dets.txt")) {
		$db->begin();
		
		$prod_group = file_get_contents($extract_dir . "t_prod_group.txt");
		$prod_group_dets = file_get_contents($extract_dir . "t_prod_group_dets.txt");
		
		$prod_group_array = explode("\r\n", $prod_group);
		$prod_group_dets_array = explode("\r\n", $prod_group_dets);
		
		$insert_prod_group = "insert into " . TABLE_PRODUCTS_GROUP . " (pg_group_id, pg_group_no, pg_status, pg_type) values ";
		for($index = 1; $index < count($prod_group_array); $index++) {
			$prod_group_value_array = explode("|^", $prod_group_array[$index]);
			if(!empty($prod_group_value_array[0]) && is_numeric($prod_group_value_array[0])) {
				$insert_prod_group .= "(" . $prod_group_value_array[0] . ", '" . trim($prod_group_value_array[1]) . "', '" . $prod_group_value_array[5] . "', '" . $prod_group_value_array[11] . "'),";
			}
		}
		$insert_prod_group = substr($insert_prod_group, 0, strlen($insert_prod_group) - 1);
		//Tianwen.Wan20170908->如果用truncate事务会失效
		$db->Execute("delete from " . TABLE_PRODUCTS_GROUP);
		$db->Execute($insert_prod_group);
		
		$insert_prod_group_dets = "insert into " . TABLE_PRODUCTS_GROUP_DET . " (pgd_det_id, pgd_group_id, pgd_prod_no) values ";
		for($index = 1; $index < count($prod_group_dets_array); $index++) {
			$insert_prod_group_dets_array = explode("|^", $prod_group_dets_array[$index]);
			if(!empty($insert_prod_group_dets_array[0]) && is_numeric($insert_prod_group_dets_array[0])) {
				$insert_prod_group_dets .= "(" . $insert_prod_group_dets_array[0] . ", " . $insert_prod_group_dets_array[1] . ", '" . trim($insert_prod_group_dets_array[6]) . "'),";
			}
		}
		$insert_prod_group_dets = substr($insert_prod_group_dets, 0, strlen($insert_prod_group_dets) - 1);
		$db->Execute("delete from " . TABLE_PRODUCTS_GROUP_DET);
		$db->Execute($insert_prod_group_dets);
		
		$db->commit();
		
		unlink($extract_dir . "t_prod_group.txt");
		unlink($extract_dir . "t_prod_group_dets.txt");
	}
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>