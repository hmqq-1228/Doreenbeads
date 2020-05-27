<?php 
header("Content-Type: text/html; charset=utf-8");
require('includes/application_top.php');
require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'language.php');

$sql = "select categories_id from " . TABLE_CATEGORIES;
$categories_result = $db->Execute($sql);
while (!$categories_result->EOF) {
	remove_categores_memcache_by_categories_id($categories_result->fields['categories_id']);
	$categories_result->MoveNext();
}
remove_all_cate_array_memcache();
echo '清除' . $categories_result->RecordCount() . '个类别缓存!';
?>