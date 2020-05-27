<?php 


require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));



if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
zen_redirect ( zen_href_link ( FILENAME_MYACCOUNT ) );

$breadcrumb->add(NAVBAR_TITLE_WELCOME);


$smarty->assign ( 'messageStack', $messageStack );
$smarty->assign ('tpl','includes/templates/mobilesite/tpl/tpl_welcome.html');







?>