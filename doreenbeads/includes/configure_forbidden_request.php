<?php
//Tianwen.Wan20160704->防sql注入
$forbidden_request = array(
	array("select ", "from"),
	array("update", "set"),
	array("insert", "into"),
	array("replace", "into"),
	array("delete", "from"),
	array("truncate"),
	array("create", "database"),
	array("create", "table"),
	array("drop", "database"),
	array("drop", "table"),
	array("grant", "to"),
	array("show", "variables"),
	array("set", " global", "="),
	array("alter", "table"),
	array("rename", "table"),
	array("repair", "table"),
	array("optimize", "table")
);
foreach($_REQUEST as $get_key => $get_value) {
	$get_value = strtolower($get_value);
	$get_value = str_replace("  ", " ", $get_value);
	foreach($forbidden_request as $forbidden_array) {
		$match_count = count($forbidden_array);
		$match_index = 0;
		foreach($forbidden_array as $forbidden_value) {
			if(strstr($get_value, $forbidden_value) != "") {
                $get_value = str_replace($forbidden_value, '', $get_value);
				$match_index++;
			}
		}
		if($match_index >= $match_count) {
			header("http/1.1 403 Forbidden");
			file_put_contents("log/sql_injection/" . date("Ymd") . ".txt", date("Y-m-d H:i:s") . "\t" . $_SERVER['HTTP_HOST'] . urldecode($_SERVER['REQUEST_URI']) . "\t" . $get_key . "\t" . $get_value . "\t" . (!empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : json_encode($_SERVER)) . "\n", FILE_APPEND);
			echo file_get_contents("403.html");
			exit();
		}
	}
}
?>