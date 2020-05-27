<?php
require('includes/application_top.php');
global $db;
$notify = $_POST['pid'];
if ($_SESSION['customer_id']) {	
	$check_query = "select count(*) as count
                          from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                          where products_id = '" . $notify . "'
                          and customers_id = '" . $_SESSION['customer_id'] . "'";
	$check = $db->Execute($check_query);
	if ($check->fields['count'] < 1) {
		$sql = "insert into " . TABLE_PRODUCTS_NOTIFICATIONS . "
                    (products_id, customers_id, date_added)
                     values ('" . $notify . "', '" . $_SESSION['customer_id'] . "', now())";
		$db->Execute($sql);
	}	
	$string = TEXT_ACCOUNT_NOTICE_SUCCESS_JS;
} else {
	$string = 0;
}
echo $string;
?>
