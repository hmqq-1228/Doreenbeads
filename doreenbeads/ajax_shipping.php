<?php 
require ('includes/application_top.php');
$action = isset ( $_POST ['action'] ) && $_POST ['action'] != '' ? $_POST ['action'] : '';
switch ($action){
	case 'check_exist':
		$id = zen_db_prepare_input ( $_POST ['id'] );
		$code = zen_db_prepare_input ( $_POST ['code'] );
		if ($id != ''){
			$check_id = $db->Execute('select id from ' . TABLE_SHIPPING . ' where id = ' . (int)$id);
			if ($check_id->RecordCount() > 0){
				echo 1;exit;
			}
		}
		if ($code != ''){
			$check_code = $db->Execute('select id from ' . TABLE_SHIPPING . ' where code = "' . $code . '"');
			if ($check_code->RecordCount() > 0){
				echo 2;exit;
			}
		}
		break;
}
?>