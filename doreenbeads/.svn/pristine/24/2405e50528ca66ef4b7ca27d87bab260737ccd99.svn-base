<?php 

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$sql = "SELECT pages_html_text_mobile FROM ".TABLE_EZPAGES." ze inner join " . TABLE_EZPAGES_DESCRIPTION. " zed on zed.pages_id = ze.pages_id WHERE ze.pages_id = 157  AND languages_id = ".$_SESSION['languages_id'];

$html = $db->Execute($sql)->fields['pages_html_text_mobile'];

$smarty->assign('html',$html);






?>