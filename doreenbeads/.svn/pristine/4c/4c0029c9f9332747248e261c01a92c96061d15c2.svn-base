<?php
include 'includes/application_top.php';

$action = $_POST['action'];
$orders_id = (int)$_POST['orders_id'];
$chrCode = addslashes((string)$_POST['chrCode']);
$chrName = addslashes((string)$_POST['chrName']);
$chrVersion = addslashes((string)$_POST['chrVersion']);
$cookiesStatus = addslashes((string)$_POST['cookiesStatus']);
$platform = addslashes((string)$_POST['platform']);
$headerInfo = addslashes((string)$_POST['headerInfo']);
$url = addslashes((string)$_POST['url']);
$position = addslashes((string)$_POST['position']);
$cookies = addslashes(strval($_POST['cookies']));
$languages = addslashes(strval($_POST['languages']));
$java_status = addslashes(strval($_POST['javaEnabled']));

if($action == 'check_order'){
	$sql_data_array = array(
		'orders_id' => $orders_id,
		'chrome_code' => $chrCode,
		'chrome_name' => $chrName,
		'chrome_version' => $chrVersion,
		'cookies_status' => $cookiesStatus,
		'platform' => $platform,
		'header_info' => $headerInfo,
		'url' => $url,
		'send_position' => $position,
		'cookies' => $cookies,
		'create_datetime' => 'now()',
		'languages' => $languages,
		'java_status' => $java_status
	);
	
  	zen_db_perform('t_google_analytics_check_order_temp', $sql_data_array);
}

echo 'success';