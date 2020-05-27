<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$breadcrumb->add(NAVBAR_TITLE);

if(isset($_GET['AID']) && $_GET['AID'] > 0){
	$an_sql = "select za.an_id,an_starttime,an_endtime, zad.an_mobile_content from ".TABLE_ANNOUNCEMENT." za INNER JOIN " . TABLE_ANNOUNCEMENT_DESCRIPTION . " zad on za.an_id = zad.an_id where an_starttime <= '".date('Y-m-d H:i:s',time())."' and an_endtime >= '".date('Y-m-d H:i:s',time())."' and zad.an_language = " . $_SESSION['languages_id'] . " and an_status = 20 and za.an_id = " . (int)$_GET['AID'] . " order by an_id DESC limit 1";
	$an_query = $db->Execute($an_sql);
	if($an_query->RecordCount() > 0 && $an_query->fields['an_mobile_content'] != ''){
		$an_mobile_content = $an_query->fields['an_mobile_content'];
	}else{
		zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}
}else{
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}
$smarty->assign('back_href',zen_href_link(FILENAME_DEFAULT));
$smarty->assign('an_mobile_content',$an_mobile_content);
?>