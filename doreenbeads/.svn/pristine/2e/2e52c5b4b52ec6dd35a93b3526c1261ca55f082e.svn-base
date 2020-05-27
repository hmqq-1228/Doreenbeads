<?php

require_once("includes/application_top.php");
@ini_set('display_errors', '1');
set_time_limit(1800);
ini_set('memory_limit','512M');
global $db;


/*if(!isset($_GET['fpath'])|| $_GET['fpath']=='') die('require param fpath');

$exc_file = $_GET['fpath'];
if(!file_exists($exc_file)) die("can not find file $exc_file");
$filename = basename($exc_file);
$file_ext = substr($filename, strrpos($filename, '.') + 1);
	
include 'Classes/PHPExcel.php';
if($file_ext=='xlsx'){
	include 'Classes/PHPExcel/Reader/Excel2007.php';
	$objReader = new PHPExcel_Reader_Excel2007;
}else{
	include 'Classes/PHPExcel/Reader/Excel5.php';
	$objReader = new PHPExcel_Reader_Excel5;
}
$count = 0;
$name_list = array();
$objPHPExcel = $objReader->load($exc_file);
$sheet = $objPHPExcel->getActiveSheet();
*/
$cate_img = $db->Execute("select categories_image from t_categories where categories_image!='' ");
$i=0;
while(!$cate_img->EOF){
	$img_path = DIR_WS_IMAGES.'/'.$cate_img->fields['categories_image'];
	if(!file_exists($img_path)) {
		$img_name = str_replace('category/', '', $cate_img->fields['categories_image']);
		echo $img_name.'<br/>';
		$i++;
	}
	$cate_img->MoveNext();
}
echo $i;
?>