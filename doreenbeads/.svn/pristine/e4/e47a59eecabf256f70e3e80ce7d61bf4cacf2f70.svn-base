<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require_once ("includes/application_top.php");
//error_reporting(E_ALL);


$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");


$currency_refresh_time_query = $db->Execute ('select last_modified from ' . TABLE_CONFIGURATION . ' where configuration_key = "CURRENT_CURRENCY" limit 1');
$currency_refresh_time = $currency_refresh_time_query->fields['last_modified'];

$update_option_array = array('insert' => false, 'record_log' => false, 'batch_update' => true, 'currrency_last_modified' => $currency_refresh_time);
if(isset ($_GET['action']) && $_GET['action'] == 'update1') {
	$select_all_products = $db->Execute('select products_id, products_net_price, products_weight, product_price_times from '. TABLE_PRODUCTS .' where products_status = 1');
	while ( ! $select_all_products->EOF ) {
		zen_refresh_products_price($select_all_products->fields['products_id'], $select_all_products->fields['products_net_price'], $select_all_products->fields['products_weight'], $select_all_products->fields['product_price_times'], false, '', $update_option_array);
		remove_product_memcache($select_all_products->fields['products_id']);
		$select_all_products->MoveNext();
	}
	// 更新MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY状态，状态为30-不在架商品待更新
	$updateSql = "update " . TABLE_CONFIGURATION . " z set z.configuration_value = 30 , z.last_modified = now() where z.configuration_key = 'MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY'";
	$db->Execute ( $updateSql );

	$operate_content = '【在架】商品t_products_discount_quantity 已更新 in ' . __FILE__ . ' on line: ' . __LINE__;
  	zen_insert_operate_logs ( 0, '在架', $operate_content, 2 );

}elseif (isset ($_GET['action']) && $_GET['action'] == 'update2') {
	$select_all_products = $db->Execute('select products_id, products_net_price, products_weight, product_price_times from '. TABLE_PRODUCTS .' where products_status != 1');
	while ( ! $select_all_products->EOF ) {
		zen_refresh_products_price($select_all_products->fields['products_id'], $select_all_products->fields['products_net_price'], $select_all_products->fields['products_weight'], $select_all_products->fields['product_price_times'], false, '', $update_option_array);
		remove_product_memcache($select_all_products->fields['products_id']);
		$select_all_products->MoveNext();
	}

	$operate_content = '【非在架】商品t_products_discount_quantity 已更新 in ' . __FILE__ . ' on line: ' . __LINE__;
  	zen_insert_operate_logs ( 0, '非在架', $operate_content, 2 );

	// 检测是否全部成功
	$count_failed_update_query = $db->Execute('select COUNT(DISTINCT products_id) as total from '. TABLE_PRODUCTS_DISCOUNT_QUANTITY .' WHERE last_modified <  "' . $currency_refresh_time . '" and products_id in ( select products_id from ' . TABLE_PRODUCTS . ' )');
	$count_failed_update = $count_failed_update_query->fields['total'];

	$configuration_value = 20;
	if($count_failed_update <= 0) {
		$configuration_value = 10;
	}

	// 更新MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY状态，状态为10-全部更新成功,20 未成功
	$updateSql = "update " . TABLE_CONFIGURATION . " z set z.configuration_value = " . $configuration_value . " , z.last_modified = now() where z.configuration_key = 'MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY'";
	$db->Execute ( $updateSql );
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>