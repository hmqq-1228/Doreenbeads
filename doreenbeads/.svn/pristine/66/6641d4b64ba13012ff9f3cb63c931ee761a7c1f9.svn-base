<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'update') {
	
	$date_now = date("Y-m-d", strtotime("-1 days", time()));
	$file_url = "log/search_keyword/" . $date_now . ".txt";
	$file_content = file_get_contents($file_url);
	$file_url_mobile = "log/search_keyword_mobile/" . $date_now . ".txt";
	$file_content_mobile = file_get_contents($file_url_mobile);
	$file_content .= $file_content_mobile;
	$line_array = explode("\n", $file_content);
	foreach($line_array as $line_value) {
		$column_array = explode("\t", $line_value);
		$languages_id = $column_array[0];
		$user_id = $column_array[1];
		$keywords = trim(str_replace("\t", "", addslashes($column_array[2])));
		$categories_id = $column_array[3];
		$ip_address = $column_array[4];
		$date_created = $column_array[5];
		$sk_country_code = $sk_country_name = "";
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
				$sk_country_code = $ip_result->fields['country_code'];
				$sk_country_name = $ip_result->fields['country_name'];
			}
		}
		
		$sql_data_array = array(
			'languages_id' => $languages_id,
			'sk_user_id' => $user_id,
			'customers_firstname' => '',
			'customers_lastname' => '',
			'customers_name' => '',
			'customers_email_address' => '',
			'sk_key_word' => $keywords,
			'sk_categories' => $categories_id,
			'sk_ip_address' => $ip_address,
			'sk_country_code' => $sk_country_code,
			'sk_country_name' => $sk_country_name,
			'sk_search_date' => $date_created
		);
		
		zen_db_perform(TABLE_SEARCH_KEYWORD, $sql_data_array);
	}
	$db->Execute("update " . TABLE_SEARCH_KEYWORD . " sk INNER JOIN " . TABLE_CUSTOMERS . " c on sk.sk_user_id=c.customers_id set sk.customers_firstname=c.customers_firstname, sk.customers_lastname=c.customers_lastname, customers_name=concat(c.customers_firstname, ' ', c.customers_lastname), sk.customers_email_address=c.customers_email_address where sk.sk_user_id>0");
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>