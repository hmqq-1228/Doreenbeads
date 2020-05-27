<?php
	date_default_timezone_set('PRC');
	ini_set('memory_limit','2048M');
	$startime = microtime(true);
	$startdate = date("Y-m-d H:i:s");

	$match_string = "index.php?main_page=login&action=process";
	$match_string_second = "script>";
	//$match_string = "ProductSearch.html";
	$match_time = 8;
	//$match_time = 100;
	//$allowed_cn_ips = file_get_contents("../log/ip_verification/allowed_cn_ips.txt");
	//$ip_white_array = explode("\n", $allowed_cn_ips);
	$ip_white_array = array('69.64.70.77','68.168.111.205','69.64.82.228','69.64.70.182','216.55.138.234','69.64.82.192','52.6.201.28','101.68.66.206','103.243.92.140','118.193.132.166','118.193.132.179','114.113.241.143','118.193.179.152','118.193.222.116','115.200.233.79','60.191.58.170','123.157.18.30','123.157.18.50','123.157.18.118','123.157.19.142','122.225.242.154','122.225.242.155','122.225.242.156','122.225.242.157','122.225.242.158','172.68.54.27','172.68.133.130','172.68.10.225','172.68.133.83','173.71.74.95','172.68.11.63','172.68.65.10','172.68.65.53','172.68.11.52','172.68.34.45','172.68.46.82');
	foreach($ip_white_array as $ip_white_key => $ip_white_value) {
		$ip_white_value = trim($ip_white_value);
		if(empty($ip_white_value)) {
			unset($ip_white_array[$ip_white_key]);
		}
	}
	$ip_white_array = array_values($ip_white_array);
	
	$log_dir = "../log/serverlog/under_attack";
	$htaccess_content = file_get_contents("/var/log/httpd/access_doreenbeads_log");
	//$htaccess_content = file_get_contents("D:/access_doreenbeads_log");
	$htaccess_content_array = explode("\n", $htaccess_content);
	$htaccess_content_array_count = count($htaccess_content_array);
	$htaccess_content_array_300 = array_splice($htaccess_content_array, $htaccess_content_array_count - 300, 300);
	
	$matched_numbers = 2000;
	$date_hour = date("H");
	if(in_array($date_hour, array('06', '07', '19', '20'))) {
		$matched_numbers = 700;
	} else if(in_array($date_hour, array('03', '04', '05', '16', '17', '18'))) {
		$matched_numbers = 3000;
	}
	$matched_numbers_300 = 40;

	$hack_array = array();
	$hack_array_number = array();
	$match_char = "/(OPTIONS |ajax_|.jpg|.jpeg|.png|.gif|.bmp|.js|.css)/i";
	$date_hour = intval(date("H"));
	//白天上班时间时白名单可以多一些
	if($date_hour >= 9 && $date_hour <= 19) {
		//google 104.224.133.76 66.249.73.154 66.249.73.178 104.198.118.123 66.249.65.105 66.249.65.88 66.249.65.124 66.249.65.64 66.249.79.185
		$match_char = "/(OPTIONS |ajax_|.jpg|.jpeg|.png|.gif|.bmp|.js|.css|104.224.133|104.198.118|66.249.65|66.249.73|66.249.79)/i";
	}
	foreach($htaccess_content_array as $htaccess_value) {
		$line_array = explode(" - - ", $htaccess_value);
		if(!preg_match($match_char, $htaccess_value)) {
			array_push($hack_array_number, $line_array[0]);
		} else if(strstr($htaccess_value, $match_string)) {
			array_push($hack_array, $line_array[0]);
		} else if(strstr($htaccess_value, $match_string_second)) {
			array_push($hack_array, $line_array[0]);
		}
	}
	
	$hack_array_300 = array();
	$hack_array_number_300 = array();
	foreach($htaccess_content_array_300 as $htaccess_value_300) {
		$line_array_300 = explode(" - - ", $htaccess_value_300);
		if(!preg_match($match_char, $htaccess_value_300)) {
			array_push($hack_array_number_300, $line_array_300[0]);
		} else {
			array_push($hack_array_300, $line_array_300[0]);
		}
	}
	
	$under_attack_ips_insert = "";
	$under_attack_log = "";
	
	$hack_total = array();

	foreach($hack_array_number as $hack_value) {
		if(!in_array($hack_value, $ip_white_array)) {
			if(!isset($hack_total[$hack_value])) {
				$hack_total[$hack_value] = 1;
			} else {
				$hack_total[$hack_value] = $hack_total[$hack_value] + 1;
			}
		}
	}
	
	foreach($hack_total as $total_key => $total_value) {
		if($total_value < $matched_numbers) {
			unset($hack_total[$total_key]);
		}
	}
		
	foreach($hack_array as $hack_value) {
		if(!in_array($hack_value, $ip_white_array)) {
			if(!isset($hack_total[$hack_value])) {
				$hack_total[$hack_value] = 1;
			} else {
				$hack_total[$hack_value] = $hack_total[$hack_value] + 1;
			}
		}
	}

	foreach($hack_total as $hack_key => $hack_time) {
		if($hack_time >= $match_time) {
			$under_attack_ips_insert .= "Deny from " . $hack_key . "\n";
			$under_attack_log .= $hack_key . "\t" . $hack_time . "\n";
		}
	}
	
	
	/***********取倒数300行数据进行分析开始************/
	
	$hack_total_300 = array();

	foreach($hack_array_number_300 as $hack_value_300) {
		if(!in_array($hack_value_300, $ip_white_array)) {
			if(!isset($hack_total_300[$hack_value_300])) {
				$hack_total_300[$hack_value_300] = 1;
			} else {
				$hack_total_300[$hack_value_300] = $hack_total_300[$hack_value_300] + 1;
			}
		}
	}
	
	foreach($hack_total_300 as $total_key => $total_value) {
		if($total_value < $matched_numbers) {
			unset($hack_total_300[$total_key]);
		}
	}
		
	foreach($hack_array_300 as $hack_value_300) {
		if(!in_array($hack_value_300, $ip_white_array)) {
			if(!isset($hack_total_300[$hack_value_300])) {
				$hack_total_300[$hack_value_300] = 1;
			} else {
				$hack_total_300[$hack_value_300] = $hack_total_300[$hack_value_300] + 1;
			}
		}
	}
	
	foreach($hack_total_300 as $hack_key_300 => $hack_time_300) {
		if($hack_time_300 >= $matched_numbers_300) {
			$under_attack_ips_insert .= "Deny from " . $hack_key_300 . "\n";
			$under_attack_log .= $hack_key_300 . "\t" . $hack_time_300 . "\texceed " . $matched_numbers_300 . " in line " . count($hack_array_number_300) . "/300\n";
		}
	}
	
	/***********取倒数300行数据进行分析结束***********/
	
	$under_attack_split = "#under_attack_ips";
	$under_attack_htaccess = file_get_contents("../.htaccess_under_attack");
	$under_attack_htaccess_array = explode($under_attack_split, $under_attack_htaccess);
	$under_attack_htaccess_content = $under_attack_htaccess_array[0] . $under_attack_split . "\n" . $under_attack_ips_insert . $under_attack_split . $under_attack_htaccess_array[2];
	file_put_contents("../.htaccess_under_attack", $under_attack_htaccess_content);
	file_put_contents($log_dir . "/under_attack_log_" . date("YmdHis") . "_" . $htaccess_content_array_count . ".txt", $under_attack_log);
	//file_put_contents("../.htaccess", $under_attack_htaccess_content);
	//print_r($under_attack_htaccess_array);
	//echo $under_attack_htaccess_content;
	
	file_put_contents("../log/crond_log/crond_under_attack_" . date("Ymd") . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\r\n", FILE_APPEND);
?>