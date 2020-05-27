<?php
	chdir("../");
	require('includes/application_top.php');
	require_once(DIR_WS_FUNCTIONS . "functions_search.php");
	$type = zen_db_prepare_input($_POST['type']);
	$keyword = zen_db_prepare_input($_POST['keyword']);
	$return_array = array('error' => 1, 'error_info' => "");
	if(!empty($type) && !empty($keyword)) {
		$data['type'] = $type;
		$data['keyword'] = $keyword;
		$data['ip_address'] = zen_get_ip_address();
		$country_info = get_country_info_by_ip_address($ip_address);
		$data['country_code'] = $country_info['data']['country_code'];
		$data['country_name'] = $country_info['data']['country_name'];
		add_search_keyword_statistic($data);
		$return_array = array('error' => 0, 'error_info' => "");
	}
	echo json_encode($return_array);
?>