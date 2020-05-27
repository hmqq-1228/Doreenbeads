<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'check_record') {
	$repeat_order_sql = 'select DISTINCT orders_id FROM t_orders_status_history WHERE orders_status_id = 0 AND date_added > "2016-07-06 00:00:00" AND customer_notified = 0 AND  modify_operator = ""';
	$repeat_order = $db->Execute($repeat_order_sql);
	if($repeat_order->RecordCount() > 0){
		while(!$repeat_order->EOF){
			$orders_id = zen_db_input($repeat_order->fields['orders_id']);
			$bak_repeat_order_status_history_record_sql = 'INSERT INTO t_orders_status_history_bak SELECT * from t_orders_status_history WHERE orders_id = ' . $orders_id . ' and orders_status_id = 0 and modify_operator = "" AND customer_notified = 0';
			$db->Execute($bak_repeat_order_status_history_record_sql);
			
			$db->Execute('DELETE from t_orders_status_history where orders_id = ' . $orders_id . ' and orders_status_id = 0 and modify_operator = "" AND customer_notified = 0');
			$repeat_order->MoveNext();
		}
	}
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>