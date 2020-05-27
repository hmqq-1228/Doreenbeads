<?php
$zco_notifier->notify('NOTIFY_HEADER_START_AFFILIATE_PROGRAMER');
if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}

require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$customer_id = $_SESSION['customer_id'];

$dropper_url = $db->Execute("select dropper_url from " . TABLE_PROMETERS_COMMISSION . " where customers_dropper_id = " .$customer_id);
$url = HTTP_SERVER .$dropper_url->fields['dropper_url'];
$smarty->assign ( 'url', $url );










?>