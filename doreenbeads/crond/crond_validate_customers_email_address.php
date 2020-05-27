<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'validate') {
	$check_time = intval($_GET['check_time']) - 1;
	$creat_date_str = "";
	if($check_time == 0) {
		$creat_date_str = "and check_time = 0";
	}
	elseif($check_time == 1) {
		$creat_date_str = "and check_time = 1 and create_date < '" . date("Y-m-d H:i:s", time() - (86400 * 2)) . "'";
	}
// 	else if($check_time == 2) {
// 		$creat_date_str = "and check_time = 2 and create_time < " . date("Y-m-d H:i:s", time() - (86400 * 5));
// 	}
	$sql = 'SELECT distinct email_address , check_time , is_error FROM ' . TABLE_CHECK_EMAIL_RESULT . ' WHERE is_error = 10 ' . $creat_date_str . ' ORDER BY check_id asc limit 400';
	$email_query = $db->Execute($sql);
	while(!$email_query->EOF){
		$email_address = $email_query->fields['email_address'];
		
		$result = remote_check_email($email_address);
		if($result['verify_status'] == 1){
			$email_pass_sql = 'DELETE FROM `' . TABLE_CHECK_EMAIL_RESULT . '` WHERE (`email_address` = "' . $email_address . '")';
			$db->Execute($email_pass_sql);
		}else{
			$is_error_str = "";
			if($check_time == 1) {
				if($result['limit_status'] == 0){
					$is_error_str = ", `is_error` = 20 , `error_info` = '" . addslashes($result['verify_status_desc']) . "'";
				}elseif($result['limit_status'] == 1){
					$is_error_str = ", `is_error` = 20 , `error_info` = '" . addslashes($result['limit_desc']) . "'";
				}
			}
			$email_no_pass_sql = 'UPDATE `' . TABLE_CHECK_EMAIL_RESULT . '` SET `check_time` = `check_time` + 1' . $is_error_str . ' WHERE `email_address` = "' . $email_address . '"';
			
			$db->Execute($email_no_pass_sql);
		}
		$email_query->MoveNext();
	}

}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>