<?php
/**
 * header_php.php
 * cash account
 */

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(TEXT_MESSAGE_SETTING);

if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
$action = zen_db_prepare_input($_GET['action']);
$message_receive_type = zen_db_prepare_input($_POST['message_receive_type']);
$message_receive_appoint = zen_db_prepare_input($_POST['message_receive_appoint']);

//	add coupon lvxiaoyong
if(!empty($action) && $action=='update'){
	if(in_array($message_receive_type, array('10', '20', '30'))) {
		$sql_data_array = array();
		if($message_receive_type == "20" && !empty($message_receive_appoint)) {
			$message_receive_appoint_str = "," . implode(",", $message_receive_appoint) . ",";
			$sql_data_array = array('customers_info_message_receive_type' => $message_receive_type, 'customers_info_message_receive_appoint' => $message_receive_appoint_str);
		} else {
			$sql_data_array = array('customers_info_message_receive_type' => $message_receive_type);
		}
		
		if(!empty($sql_data_array)) {
			zen_db_perform(TABLE_CUSTOMERS_INFO, $sql_data_array, 'update', 'customers_info_id=' . $_SESSION['customer_id']);
		}
	}
	
	zen_redirect(zen_href_link(FILENAME_MESSAGE_SETTING, zen_get_all_get_params(array('action'))));
}

$message_setting_sql = "select customers_info_message_receive_type, customers_info_message_receive_appoint from " . TABLE_CUSTOMERS_INFO . " where customers_info_id=:customers_id";
$message_setting_sql=$db->bindVars($message_setting_sql,':customers_id', $_SESSION['customer_id'],'integer');
$message_setting_result = $db->Execute($message_setting_sql);

$type_sql = "select mt.auto_id, mtd.title from ". TABLE_MESSAGE_TYPE ." mt inner join " . TABLE_MESSAGE_TYPE_DESCRIPTION . " mtd on mtd.type_id=mt.auto_id where mt.type_status=:type_status and mtd.languages_id=:languages_id order by mt.auto_id desc";
$type_sql=$db->bindVars($type_sql,':type_status', 10,'integer');
$type_sql=$db->bindVars($type_sql,':languages_id', $_SESSION['languages_id'],'integer');
$type_result = $db->Execute($type_sql);
$type_array = array();
while (!$type_result->EOF) {
  $type_array[] = $type_result -> fields;
  $type_result->MoveNext();
}
?>