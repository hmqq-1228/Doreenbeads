<?php 
/**
 * ez_pages ("page") header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4881 2006-11-04 17:51:31Z ajeh $
 */
/*
* This "page" page is the display component of the ez-pages module
* It is called "page" instead of "ez-pages" due to the way the URL would display in the browser
* Aesthetically speaking, "page" is more professional in appearance than "ez-page" in the URL
*
* The EZ-Pages concept was adapted from the InfoPages contribution for Zen Cart v1.2.x, with thanks to Sunrom et al.
*/
//require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$auto_id = intval($_GET['auto_id']);
$message_description = $_POST['message_description'];
if((empty($_SESSION['customer_id']) && !empty($auto_id)) || (empty($message_description) && empty($auto_id))) {
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

if(empty($auto_id ) && !empty($message_description)) {
	$message_info_result = new stdClass();
	$message_info_result->fields['description'] = $message_description;
} else {
	$message_info_sql = "select mtc.auto_id, mld.title, mld.description from " . TABLE_MESSAGE_TO_CUSTOMERS . " mtc inner join " . TABLE_MESSAGE_LIST_DESCRIPTION . " mld on mtc.list_id=mld.list_id where mtc.auto_id=:auto_id and mtc.customers_id=:customers_id and mld.languages_id=:languages_id and is_mobile=:is_mobile";
	$message_info_sql = $db->bindVars($message_info_sql, ':auto_id', $auto_id, 'integer');
	$message_info_sql = $db->bindVars($message_info_sql, ':customers_id', $_SESSION['customer_id'], 'integer');
	$message_info_sql = $db->bindVars($message_info_sql, ':is_mobile', 1, 'integer');
	$message_info_sql = $db->bindVars($message_info_sql, ':languages_id', $_SESSION['languages_id'],'integer');
	$message_info_result = $db->Execute($message_info_sql );
	if(!empty($message_info_result->fields['auto_id'])) {
		$message_update_array = array('is_read' => 1, 'customers_last_operation_time' => 'now()');
		zen_db_perform(TABLE_MESSAGE_TO_CUSTOMERS, $message_update_array, 'update', 'auto_id=' . $auto_id . ' and customers_id=' . $_SESSION['customer_id']);
	}
}
$smarty->assign ('message_info_array' , $message_info_result->fields);

?>