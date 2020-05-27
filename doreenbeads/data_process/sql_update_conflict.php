<?php
	header("Content-type: text/html; charset=utf-8");
	@ini_set('display_errors', '1');
	error_reporting(E_ERROR);
	set_time_limit(1800);
	define('IS_ADMIN_FLAG',false);
	include('includes/configure.php');
	include('includes/classes/class.base.php');
	include('includes/classes/db/mysql/query_factory.php');
	include('includes/functions/functions_general.php');
	
	global $db;
	if (! is_object ( $db )) {
	     $db = new queryFactory ();
	     $db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, '', false);
	}
	
if(!isset($_GET['action'])|| $_GET['action']!='update' ) die('need action');

$cate_desc_query = $db->Execute("select categories_id,language_id,categories_description from t_categories_description");

while(!$cate_desc_query->EOF){
	if(stristr($cate_desc_query->fields['categories_description'], 'pandora')!=false){
		$new_desc = str_replace(array('Pandora','pandora',"'"), array('European', 'european',"\'"), $cate_desc_query->fields['categories_description']);
		$sql = "update t_categories_description set categories_description='".$new_desc."' where categories_id='".$cate_desc_query->fields['categories_id']."';";
		$db->Execute($sql);
		echo $sql.'<br/>';
	}
	$cate_desc_query->MoveNext();
}


	
?>