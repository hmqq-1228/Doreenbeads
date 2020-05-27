<?php
/**
 * Header code file for the Account Newsletters page - To change customers Newsletter options
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3162 2006-03-11 01:39:16Z drbyte $
 */
if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$action = zen_db_prepare_input($_GET['action']);
$unread = intval($_GET['unread']);
$type = zen_db_prepare_input($_GET['type']);
$auto_id = intval(zen_db_prepare_input($_GET['auto_id']));
$page = intval($_GET['page']);


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
  $message_result->fields['date_created'] = zen_date_long($message_result->fields['date_created']);
  $message_array[] = $message_result->fields;
  $message_result->MoveNext();
}
$smarty->assign('page', $page);
$smarty->assign('unread', $unread);
$smarty->assign('message_array', $message_array);
$smarty->assign('message_page', $message_split->display_links_mobile_for_shoppingcart(3, zen_get_all_get_params(array('page', 'info','x', 'y', 'main_page'))));
?>