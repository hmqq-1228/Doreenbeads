<?php
	chdir("../");
	require('includes/application_top.php');
	$click_code = zen_db_prepare_input($_POST['click_code']) ? zen_db_prepare_input($_POST['click_code']) : '' ;
	$return_array = array();
	if (empty($click_code)) {
		$return_array['message'] = 'error';
	}else{
		$insert_languages_id = ($_SESSION['languages_id']) ? $_SESSION['languages_id'] : 0;
		$insert_user_id = ($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
		$ip_address = zen_get_ip_address();
		$content = $insert_languages_id . "\t" . $insert_user_id . "\t" . $click_code . "\t" . $ip_address . "\t" . date("Y-m-d H:i:s") . "\n";
		write_file('log/count_clicks/', date("Y-m-d") . '.txt', $content);
		$return_array['message'] = 'success';
	}
	echo json_encode($return_array);
?>