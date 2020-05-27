<?php
chdir("../");
require ("includes/application_top.php");
require (DIR_WS_CLASSES . 'order.php');
require (DIR_WS_INCLUDES . 'braintree-php-3.40.0/lib/autoload.php');
require ($language_page_directory . 'checkout_process.php');

$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

/*
$string = str_replace("\\", "", "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n<events merchant=\"601600\" total=\"2\">\n<event>\n  <name>WORKFLOW_NOTES_ADD<\/name>\n  <key order_number=\"362142\" site=\"OPT-IN\">PJNC0Y0Z3WPJ<\/key>\n  <old_value\/>\n  <new_value reason_code=\"\"\/>\n  <agent>hongsheng.xie@panduo.com.cn<\/agent>\n  <occurred>2016-05-09 18:31:21.655904<\/occurred>\n<\/event>\n<event>\n  <name>WORKFLOW_STATUS_EDIT<\/name>\n  <key order_number=\"362142\" site=\"OPT-IN\">PJNC0Y0Z3WPJ<\/key>\n  <old_value>R<\/old_value>\n  <new_value>A<\/new_value>\n  <agent>SYSTEM@KOUNT.NET<\/agent>\n  <occurred>2016-05-09 18:31:21.672301<\/occurred>\n<\/event>\n<\/events>\n");
*/
$string = @ trim($HTTP_RAW_POST_DATA);
//Tianwen.Wan20160510->由于kount不能把数据回调给测试站，我们在正式站的回调日志里把XML数据拷贝到同级目录的response_kount_form.html文本框进行提交
if (empty ($string) && !empty ($_POST['kount_xml'])) {
	$string = trim($_POST['kount_xml']);
}
//echo $string;
//print_r($_POST);exit;
//当XML中有多笔订单时，只输出最后一个订单的message信息
$message = "Order status modification failed";
if (!empty ($string)) {
	$dir = "log/kount/" . date("Ym");
	if (!is_dir($dir)) {
		mkdir($dir);
	}
	
	$_SESSION['payment'] = 'braintree';

	Braintree_Configuration :: environment(BRAINTREE_ENVIRONMENT);
	Braintree_Configuration :: merchantId(BRAINTREE_MERCHANTID);
	Braintree_Configuration :: publicKey(BRAINTREE_PUBLICKEY);
	Braintree_Configuration :: privateKey(BRAINTREE_PRIVATEKEY);

	$dom = new DOMDocument;
	$dom->loadXML($string);
	$events = $dom->getElementsByTagName("event");
	
	$array_orders_id = array();
	foreach ($events as $event) {
		$name = $event->getElementsByTagName("name");
		$status_name = strtoupper($name->item(0)->nodeValue);

		$old_value = $event->getElementsByTagName("old_value");
		$status_old_value = strtoupper($old_value->item(0)->nodeValue);
		$new_value = $event->getElementsByTagName("new_value");
		$status_new_value = strtoupper($new_value->item(0)->nodeValue);

		$keys = $event->getElementsByTagName("key");
		
		//Tianwen.Wan20160510->如果订单审核通过则去关联表查找braintree_id进行扣款
		if ($status_name == "WORKFLOW_STATUS_EDIT" && $status_old_value == "R") {
			$status_key = strtoupper($keys->item(0)->nodeValue);
			include (zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/payment/', 'braintree.php', 'false'));
			$result = $db->Execute("select auto_id, orders_id, braintree_id from " . TABLE_ORDERS_BRAINTREE_KOUNT_RELATION . " where kount_id='" . $status_key . "' order by auto_id desc limit 1");
			if ($result->RecordCount() > 0) {
				$log_record = false;
				if ($status_new_value == "A") {
					//console("确认付款：" . $result->fields['braintree_id']);
					Braintree_Transaction :: submitForSettlement($result->fields['braintree_id']);

					$order = new order($result->fields['orders_id']);
					$kount_callback = 10;
					if ($order->info['orders_status_id'] == 42) {
						$order->info['orders_status_id'] = 2;
						$gc_status = 'Braintree Transaction Id:' . $result->fields['braintree_id'] . ', Kount Id:' . $status_key;
						$sqlOrderHistory = "INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id,orders_status_id,date_added,customer_notified,comments) VALUES (" . $result->fields['orders_id'] . "," . $order->info['orders_status_id'] . ",now(),1,'" . $gc_status . "')";
						$db->Execute($sqlOrderHistory);
						$order->order_status_update($result->fields['orders_id'], $order->info['orders_status_id'], array (
							'transaction_id' => $result->fields['braintree_id']
						), false);
						//$order->send_succ_order_email($result->fields['orders_id']);

						$kount_callback = 20;
						$message = "Order status changes successfully";
					} else {
						$kount_callback = 30;
						$message = "Order status modification failed, reason: The order status has no risk";
					}
					
					$log_record = true;

				}
				elseif ($status_new_value == "D" && !empty ($result->fields['braintree_id'])) {
					$kount_callback = 40;
					$message = "Order has been cancelled in braintree";
					//console("取消付款：" . $result->fields['braintree_id']);
					Braintree_Transaction :: void($result->fields['braintree_id']);
					
					$log_record = true;
				} else {
					//无需进行任何处理
				}
				
				if($log_record == true && !empty($string)) {
					foreach ($keys as $key) {
						$status_order_number = $key->getAttribute('order_number');
						if(!in_array($status_order_number, $array_orders_id)) {
							array_push($array_orders_id, $status_order_number);
						}
					}
					
					$sql_data_array[] = array (
						'fieldName' => 'kount_callback',
						'value' => $kount_callback,
						'type' => 'integer'
					);
					$sql_data_array[] = array (
						'fieldName' => 'kount_callback_xml',
						'value' => $string,
						'type' => 'string'
					);
					$sql_data_array[] = array (
						'fieldName' => 'date_modified',
						'value' => $startdate,
						'type' => 'string'
					);
	
					$where_clause = "auto_id = :autoId";
					$where_clause = $db->bindVars($where_clause, ':autoId', $result->fields['auto_id'], 'integer');
					$db->perform(TABLE_ORDERS_BRAINTREE_KOUNT_RELATION, $sql_data_array, 'update', $where_clause);
				}
				
			}
		}
		//echo $status_name . "-" . $status_key . "-" . $status_order_number . "-" . $status_old_value . "-" . $status_new_value ."<br/>";
		//console($status_name . "-" . $status_key . "-" . $status_order_number . "-[" . $status_old_value . "]-" . $status_new_value);

		file_put_contents($dir . "/response_kount.txt", $status_name . "\t" . $status_key . "\t" . $status_order_number . "\t" . $startdate . "\t" . $status_old_value . "\t" . $status_new_value . "\n", FILE_APPEND);
	}
	
	//一个XML文件中可能会有多笔订单
	foreach($array_orders_id as $orders_id) {
		file_put_contents($dir . "/" . $orders_id . ".txt", $string . "\n\n", FILE_APPEND);
	}
	
	//$test1 = $dom->saveXML(); 
	//$dom->save('test1.xml'); 
	#sleep(5);
} else {
	$message = "Data is not valid";
}
unset($_SESSION['payment']);
echo $message;
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n" . $string . "\r\n\r\n", FILE_APPEND);
?>