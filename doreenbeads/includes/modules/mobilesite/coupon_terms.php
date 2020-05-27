<?php 
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}






?>