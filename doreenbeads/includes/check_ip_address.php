<?php
function check_ip() {
	$url_refer = $_SERVER ['HTTP_REFERER'];
	$browser_lang = strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
		$ips = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'HTTP_CLIENT_IP' )) {
		$ips = getenv ( 'HTTP_CLIENT_IP' );
	} else {
		$ips = getenv ( 'REMOTE_ADDR' );
	}

	//$ips = "101.68.70.186";
	//$ips='61.244.148.166';
	$ip_file = 'log/ip_verification/allowed_cn_ips.txt';
	$allow_from_file = (file_exists($ip_file)) ? @file_get_contents($ip_file) : '';
		
	$denied_code_arr = array ('CN');
	
	$ip_data_dir = 'php_db/';
	$ip = floatval ( sprintf ( "%u\n", ip2long ( $ips ) ) );
	$piece = substr ( $ip, 0, 3 );
	$countryCode = '';
	if (! file_exists ( $ip_data_dir . $piece . '.php' )) {
		$countryCode = '?';
	} else {
		include $ip_data_dir . $piece . '.php';
		foreach ( $entries as $e ) {
			$e [0] = floatval ( $e [0] );
			if ($e [0] <= $ip and $e [1] >= $ip) {
				$countryCode = $e [2];
				break;
			}
		}
	}
	//echo $ips.$countryCode;exit;
	if(!in_array($countryCode, $denied_code_arr) || stristr($url_refer,HTTP_SERVER.'/8admin') != false || stristr($allow_from_file, $ips) != false
	    || $countryCode=='TW' || $countryCode=='HK'){
		return true;
	}else{
		return false;
	}
}
?>