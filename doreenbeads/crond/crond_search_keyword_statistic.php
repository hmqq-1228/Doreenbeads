<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'update') {
	
	$sql ="update " . TABLE_SEARCH_HOT . " sh set sh.search_count_all=0, search_count_month=0";
	$result = $db->Execute($sql);
	
	$sql ="update " . TABLE_SEARCH_HOT . " sh INNER JOIN (select languages_id, keyword, count(1) count from " . TABLE_SEARCH_KEYWORD_STATISTIC . " group by languages_id, keyword) t1 on sh.keyword=t1.keyword and sh.languages_id=t1.languages_id set sh.search_count_all=t1.count";
	$result = $db->Execute($sql);
	
	$sql ="update " . TABLE_SEARCH_HOT . " sh INNER JOIN (select languages_id, keyword, count(1) count from " . TABLE_SEARCH_KEYWORD_STATISTIC . " where date_created>FROM_UNIXTIME(UNIX_TIMESTAMP()-(86400 * 30)) group by languages_id, keyword) t1 on sh.keyword=t1.keyword and sh.languages_id=t1.languages_id set sh.search_count_month=t1.count";
	$result = $db->Execute($sql);
	
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>