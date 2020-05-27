<?php
/**
 * header_php.php
 * cash account
 */

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(TEXT_MY_MESSAGE);

$action = zen_db_prepare_input($_GET['action']);
$unread = zen_db_prepare_input($_GET['unread']);
$type = zen_db_prepare_input($_GET['type']);
$auto_id = intval(zen_db_prepare_input($_GET['auto_id']));


//	add coupon lvxiaoyong
if(!empty($action) && $action=='update' && in_array($type, array('is_ignore', 'is_delete'))){
	$sql_data_array = array($type => 1, 'customers_last_operation_time' => 'now()');
	$auto_id_filter = !empty($auto_id) ? 'auto_id = ' . $auto_id : '1 = 1';
	if($type == "is_ignore") {
		$auto_id_filter .= " and is_read=0 and is_delete=0";
	}
	zen_db_perform(TABLE_MESSAGE_TO_CUSTOMERS, $sql_data_array, 'update', $auto_id_filter . ' and customers_id=' . $_SESSION['customer_id']);
	zen_redirect(zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'type', 'auto_id'))));
}
//	end

$where = '';
if(!empty($unread)) {
	$where = ' and mtc.is_read = 0 and mtc.is_ignore = 0';
}
//print_r(get_customers_message_memcache($_SESSION['customer_id'], $_SESSION['languages_id'], 0, 5));
$message_sql = "select mtd.title title_type, mld.title title_list, mtc.auto_id, mtc.customers_id, mtc.is_read, mtc.is_ignore, mtc.is_delete, mtc.date_created from " . TABLE_MESSAGE_TO_CUSTOMERS . " mtc inner join " . TABLE_MESSAGE_TYPE_DESCRIPTION . " mtd on mtd.type_id=mtc.type_id inner join " . TABLE_MESSAGE_LIST_DESCRIPTION . " mld on mld.list_id=mtc.list_id where mtc.customers_id=:customers_id and mtd.languages_id=:languages_id and mld.languages_id=:languages_id and mtc.is_delete=0 and is_mobile=:is_mobile" . $where . " order by mtc.auto_id desc";

$message_sql=$db->bindVars($message_sql,':customers_id', $_SESSION['customer_id'],'integer');
$message_sql=$db->bindVars($message_sql,':languages_id', $_SESSION['languages_id'],'integer');
$message_sql=$db->bindVars($message_sql,':is_mobile', 0,'integer');
      	
$message_split = new splitPageResults($message_sql, 10, '1');
$message_result = $db->Execute($message_split->sql_query);
$message_array = array();
while (!$message_result->EOF) {
  $message_array[] = $message_result->fields;
  $message_result->MoveNext();
}
?>