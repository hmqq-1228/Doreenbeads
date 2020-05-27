<?php
$nua = strToLower ( $_SERVER ['HTTP_USER_AGENT'] );
// echo '<pre>';
// print_r($_SERVER);exit;
$agent ['http'] = isset ( $_SERVER ["HTTP_USER_AGENT"] ) ? strtolower ( $_SERVER ["HTTP_USER_AGENT"] ) : "";
$agent ['version'] = 'unknown';
$agent ['browser'] = 'unknown';
$agent ['b_version'] = 0;
$agent ['platform'] = 'unknown';

$oss = array (
		'win',
		'mac',
		'linux',
		'unix' 
);
foreach ( $oss as $os ) {
	if (strstr ( $agent ['http'], $os )) {
		$agent ['platform'] = $os;
		break;
	}
}

$browsers = array (
		"mozilla",
		"msie",
		"gecko",
		"firefox",
		"konqueror",
		"safari",
		"netscape",
		"navigator",
		"opera",
		"mosaic",
		"lynx",
		"amaya",
		"omniweb" 
);

$l = strlen ( $nua );
for($i = 0; $i < count ( $browsers ); $i ++) {
	if (strlen ( stristr ( $nua, $browsers [$i] ) ) > 0) {
		$agent ["b_version"] = "";
		$agent ["browser"] = $browsers [$i];
		$j = strpos ( $nua, $agent ["browser"] ) + $n + strlen ( $agent ["browser"] ) + 1;
		for(; $j <= $l; $j ++) {
			$s = substr ( $nua, $j, 1 );
			if (is_numeric ( $agent ["b_version"] . $s ))
				$agent ["b_version"] .= $s;
			else
				break;
		}
	}
}

// http://en.wikipedia.org/wiki/List_of_user_agents_for_mobile_phones - list of
// useragents
$devices = array (
		"iphone",
		"android",
		"blackberry",
		"ipod",
		"htc",
		"symbian",
		"webos",
		"opera mini",
		"windows phone os",
		"iemobile" 
);

for($i = 0; $i < count ( $devices ); $i ++) {
	if (stristr ( $nua, $devices [$i] )) {
		$agent ["device_type"] = $devices [$i];
		break;
	}
}