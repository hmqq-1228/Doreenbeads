<?php 
if ($_SESSION['languages_id'] == 3) {
	zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
}
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));













?>