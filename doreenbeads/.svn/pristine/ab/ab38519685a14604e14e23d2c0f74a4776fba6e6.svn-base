<?php
//改变目录
chdir("../");

require_once("includes/application_top.php");
require("includes/access_ip_limit.php");
@ini_set('display_errors', '1');
set_time_limit(3600);
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
global $db;
$cnt=0;

if(isset($_GET['action']) && $_GET['action'] == 'expired'){
	$channel_query = $db->Execute('SELECT channel_id , channel_start_datetime , channel_end_datetime from t_channel where channel_status in (10 , 20)');

	while(!$channel_query->EOF){
		$expire_time = strtotime($channel_query->fields['channel_end_datetime']);
		if(time() >= $expire_time){
			$db->Execute('update ' . TABLE_CHANNEL . ' set channel_status = 30 where channel_id = "' . $channel_query->fields['channel_id'] . '"');
			$cnt++;
		}
		$channel_query->MoveNext();
	}
}

echo $cnt;
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>