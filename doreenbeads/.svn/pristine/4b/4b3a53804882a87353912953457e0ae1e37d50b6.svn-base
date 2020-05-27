<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'update') {
	
	$date_now = date("Y-m-d", strtotime("-1 days", time()));
	$file_url = "log/count_clicks/" . $date_now . ".txt";
	$file_content = file_get_contents($file_url);
	$line_array = explode("\n", $file_content);
	foreach($line_array as $line_value) {
		$column_array = explode("\t", $line_value);
		$languages_id = $column_array[0];
		$customers_id = $column_array[1];
		$clicks_code = $column_array[2];
		$ip_address = $column_array[3];
		$created_time = $column_array[4];
		$cc_country_code = $cc_country_name = "";
		if(empty($languages_id)) {
			continue;
		}
		
		if(strstr($ip_address, ".") != "") {
			$ip_address_array =  explode(".", $ip_address);		
			$ip_number = $ip_address_array[3] + $ip_address_array[2] * 256 + $ip_address_array[1] * 256 * 256 + $ip_address_array[0] * 256 * 256 * 256;
			$ip_sql = "select country_code, country_name FROM ip_country where ip_to >= :ip_number and ip_from <= :ip_number order by ip_to LIMIT 1";
			$ip_sql = $db->bindVars($ip_sql, ':ip_number', $ip_number, 'integer');
			$ip_result = $db->Execute($ip_sql);
			if($ip_result->RecordCount() > 0) {
				$cc_country_code = $ip_result->fields['country_code'];
				$cc_country_name = $ip_result->fields['country_name'];
			}
		}
		
		$sql_data_array = array(
			'clicks_code' => $clicks_code,
			'languages_id' => $languages_id,
			'customers_id' => $customers_id,
			'customers_firstname' => '',
			'customers_lastname' => '',
			'customers_name' => '',
			'customers_email_address' => '',
			'created_time' => $created_time,
			'cc_ip_address' => $ip_address,
			'cc_country_code' => $cc_country_code,
			'cc_country_name' => $cc_country_name,
		);
		
		zen_db_perform(TABLE_COUNT_CLICKS, $sql_data_array);
	}
	$db->Execute("update " . TABLE_COUNT_CLICKS . " sk INNER JOIN " . TABLE_CUSTOMERS . " c on sk.customers_id=c.customers_id set sk.customers_firstname=c.customers_firstname, sk.customers_lastname=c.customers_lastname, customers_name=concat(c.customers_firstname, ' ', c.customers_lastname), sk.customers_email_address=c.customers_email_address");
	$db->Execute("delete from " . TABLE_COUNT_CLICKS . " where customers_email_address like '%panduo.com.cn%' or customers_email_address like '%163.com%' or customers_email_address like '%qq.com%'");
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>