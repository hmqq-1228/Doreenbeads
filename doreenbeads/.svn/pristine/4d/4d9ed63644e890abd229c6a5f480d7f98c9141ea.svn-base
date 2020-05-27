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
	
if($_GET['model']=='') die('need product model');
$products_query = $db->Execute("select products_id,products_image from t_products where products_model='".$_GET['model']."'");
if($products_query->RecordCount()==0) {echo 0;exit;}
$img_total = list_file($_GET['model'],$products_query->fields['products_image']);
	
echo $img_total;

function list_file($products_model, $products_img){
	$str_reg = '/(.*)(s|h|q)$/i';
	if($products_img=='') return 0;
	$path_arr = explode('/', $products_img);
	$path_level = sizeof($path_arr);
	if($path_level<1){
		return 0;
	}
	
	$products_model = preg_replace($str_reg, '$1', $products_model);
	$dir = DIR_FS_DOWNLOAD. str_replace($path_arr[$path_level-1], '', $products_img);
	$list = scandir($dir); //get all files and directories
	$match_count = 0;
	foreach($list as $file){
		$file_location=$dir.$file;//file path
		if(is_dir($file_location) && $file!="." &&$file!=".."){ //dir or not			
			//list_file($file_location);
		}else{
			if(fnmatch($products_model."[A-Za-z].JPG", strtoupper($file))){
				$match_count++;
				//echo $file.'<br/>';
			}
		}
	}
	return $match_count;
}

	
?>