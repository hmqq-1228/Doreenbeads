<?php 
class checkIpAddress{
	var $ip,$countryCode,$ipno;
	
	function checkIpAddress(){
		$this->ip='';
		$this->ipno='';
		$this->countryCode='';
		if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
			$ips = getenv ( 'HTTP_X_FORWARDED_FOR' );
		} elseif (getenv ( 'HTTP_CLIENT_IP' )) {
			$ips = getenv ( 'HTTP_CLIENT_IP' );
		} else {
			$ips = getenv ( 'REMOTE_ADDR' );
		}
		$this->ip = $ips;
	}

	function changeIpTo($inputIp){
		$this->ip = $inputIp;
	}
	
	function Dot2LongIP () {
		if ($this->ip == "")
		{
			return 0;
		} else {
			$ips = explode('.', $this->ip);
			$this->ipno =($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
		}
	}
	
	function get_country_code(){
		if(isset($_COOKIE['zencountry_code']) && !empty($_COOKIE['zencountry_code'])) {
			$this->countryCode = $_COOKIE['zencountry_code'];
			return $this->countryCode;
		}
		
		$this->Dot2LongIP();
	
		$link = mysql_connect(DB_SERVER_IP, DB_SERVER_USERNAME_IP, DB_SERVER_PASSWORD_IP) or die("Could not connect to MySQL database");
	
		mysql_select_db(DB_DATABASE_IP) or die("Could not select database");
	
		$query = 'SELECT country_code FROM ip_country WHERE ip_to >="'.$this->ipno.'" and ip_from <="'.$this->ipno.'" order  by ip_to LIMIT 1';
	
		$result = mysql_query($query) or die("IP2Location Query Failed");
	
		$row = mysql_fetch_object($result);
	
		$this->countryCode = $row->country_code;
		setcookie("zencountry_code", $row->country_code, time() + 7776000, '/', '.' . BASE_SITE);
	
		mysql_close($link);
		return $this->countryCode;
	}

	function check_ip(){
		//	xiaoyong.lv	20140626
		if(isset($_SESSION['checkIPResult']) && $_SESSION['checkIPResult']){
			return true;
		}
		$my_ip_address = "/(127.0.0.1|localhost|192.168.|10.2.)/i";
		if(preg_match($my_ip_address, $this->ip)){
			$_SESSION['checkIPResult'] = true;
			return true;
		}
		$ip_file = 'log/ip_verification/allowed_cn_ips.txt';
		$allow_from_file = (file_exists($ip_file)) ? @file_get_contents($ip_file) : '';
		if(strstr($this->ip, ",") != "") {
			$ip_array = explode(",", $this->ip);
			foreach($ip_array as $ip_value) {
				if(stristr($allow_from_file, $ip_value) != "") {
					$_SESSION['checkIPResult'] = true;
					return true;
				}
			}
		} else {
			if(stristr($allow_from_file, $this->ip) != "") {
				$_SESSION['checkIPResult'] = true;
				return true;
			}
		}
		//if(stristr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh-') != "") {
		//	return false;
		//}
		$this->get_country_code();
		$denied_code_arr = array ('CN');
		if(!in_array($this->countryCode, $denied_code_arr)){
			$_SESSION['checkIPResult'] = true;
			return true;
		}
		return false;
	}
}
?>