<?php
chdir("../");
require('includes/application_top.php');
$action=isset($_POST['action'])?$_POST['action']:'';
$returnArray = array('error' => false);

switch ($action){
	case 'record_letter_status':
		$station_letter_status = intval($_POST['station_letter_status']);
		$customers_id = zen_db_input($_SESSION['customer_id']);
		$station_letter_id = intval($_POST['station_letter_id']);
		
		if(in_array($station_letter_status, array( 20 , 30)) && $customers_id > 0 &&  $station_letter_id> 0){
			try {
				$check_letter_sql = 'select station_letter_type from ' . TABLE_STATION_LETTER_CUSTOMERS . ' where station_letter_status = 10 and customers_id =' . $customers_id . ' and station_letter_id =' . $station_letter_id;
				$check_letter_result = $db->Execute($check_letter_sql);
				
				if($check_letter_result->RecordCount() > 0){
					$station_letter_type = zen_db_input($check_letter_result->fields['station_letter_type']);
					$update_letter_sql = 'update ' . TABLE_STATION_LETTER_CUSTOMERS . ' set station_letter_status = ' . $station_letter_status . ' , operating_datetime = now() where customers_id = ' . $customers_id . ' and station_letter_type = ' . $station_letter_type . '  and station_letter_status = 10';
					$db->Execute($update_letter_sql);
				}else{
					$returnArray['error'] = true;
				}
			} catch (Exception $e) {
				$returnArray['error'] = true;
			}
		}else{
			$returnArray['error'] = true;
		}
		echo json_encode($returnArray);
	break;
}

