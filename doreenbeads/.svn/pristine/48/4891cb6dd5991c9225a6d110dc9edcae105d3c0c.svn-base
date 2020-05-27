<?php 
/**
limit access by ip for some files to deal with data,
like solr, product...

 */
$allowed_ips = array(
		'127.0.0.1',
		'69.64.82.228',
		'69.64.82.55',
		'69.64.70.182',
		'69.64.82.192',
		'101.68.66.206',
		'216.55.138.234',
		'122.226.200.174',
		'103.243.92.140',
		'122.225.242.154',  //dianxin
		'122.225.242.154',
		'122.225.242.155',
		'122.225.242.156',
		'122.225.242.157',
		'122.225.242.158',
		'123.157.19.142',
		'123.157.18.30',
		'123.157.18.50',
		'123.157.18.118'
);

$access_ip = $checkIpAddress->ip;
$ip_arr = explode('.', $access_ip);
if(($ip_arr[0]=='192' && $ip_arr[1]=='168') || ($ip_arr[0]=='10' && $ip_arr[1]=='2')){
	
}elseif(!in_array($access_ip, $allowed_ips)){
	header("Location: http://".$_SERVER['HTTP_HOST']."/404.html");exit;
}
?>