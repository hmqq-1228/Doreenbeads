<?php
require('includes/application_top.php');
if(!isset($_GET['action'])|| $_GET['action']!='update' ) die('need action');
set_time_limit(0);
@ini_set('memory_limit','2012M');
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel.php';
include 'PHPExcel/Reader/Excel2007.php';
include 'PHPExcel/Writer/Excel2007.php';
$objReader = new PHPExcel_Reader_Excel2007;
//$objPHPExcel = $objReader->load("F:/property.xlsx");
$objPHPExcel = $objReader->load("F:/dorabeads_data/featured_categ.xlsx");
//$objPHPExcel = $objReader->load("products/new_featured.xlsx");
global $db;

$i=2;

$top_category_query = $db->Execute("select c.categories_id, c.categories_code,c.chinese_info,cd.categories_name,c.categories_image ,c.sort_order
								from zen_categories c, zen_categories_description cd 
								where  c.categories_id=cd.categories_id
								and cd.language_id=1
								and c.categories_id=691");

while(!$top_category_query->EOF){
	$level_1 = $top_category_query->fields['categories_id'];
	$top_de_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_1." and language_id=2");
	$top_ru_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_1." and language_id=3");
	$top_fr_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_1." and language_id=4");
	
	$second_category_query = $db->Execute("select c.categories_id, c.categories_code,c.chinese_info,cd.categories_name,c.categories_image,c.sort_order 
								from zen_categories c, zen_categories_description cd 
								where  c.categories_id=cd.categories_id
								and cd.language_id=1
								and c.parent_id='".$level_1."'");

	while(!$second_category_query->EOF){
		$level_2 = $second_category_query->fields['categories_id'];
		$second_de_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_2." and language_id=2");
		$second_ru_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_2." and language_id=3");
		$second_fr_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_2." and language_id=4");
		
		$third_category_query = $db->Execute("select c.categories_id, c.categories_code,c.chinese_info,cd.categories_name,c.categories_image,c.sort_order
								from zen_categories c, zen_categories_description cd
								where  c.categories_id=cd.categories_id
								and cd.language_id=1
								and c.parent_id='".$level_2."' order by c.categories_code");
		while(!$third_category_query->EOF){
			$level_3 = $third_category_query->fields['categories_id'];
			$third_de_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_3." and language_id=2");
			$third_ru_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_3." and language_id=3");
			$third_fr_query = $db->Execute("select categories_name from zen_categories_description where categories_id=".$level_3." and language_id=4");
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$level_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$top_category_query->fields['sort_order']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$top_category_query->fields['categories_image']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$top_category_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$top_de_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$top_ru_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$top_fr_query->fields['categories_name']);

			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$level_2);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$second_category_query->fields['sort_order']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$second_category_query->fields['categories_image']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$second_category_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,$second_de_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$second_ru_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$second_fr_query->fields['categories_name']);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$level_3);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,$third_category_query->fields['sort_order']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i,$third_category_query->fields['categories_image']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i,$third_category_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i,$third_de_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i,$third_ru_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i,$third_fr_query->fields['categories_name']);
				
			
			$i++;
			$third_category_query->MoveNext();
		}
		
		$second_category_query->MoveNext();
	}
		//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$product_query->fields['products_model']);
		
	
	
	$top_category_query->MoveNext();
}
/*
$top_category_query = $db->Execute("select c.categories_id, c.categories_code,c.chinese_info,cd.categories_name,c.categories_image ,c.sort_order
								from t_categories c, t_categories_description cd
								where  c.categories_id=cd.categories_id
								and cd.language_id=1
								and c.categories_id=2007");
while(!$top_category_query->EOF){
	$level_1 = $top_category_query->fields['categories_id'];
	
	$second_category_query = $db->Execute("select c.categories_id, c.categories_code,c.chinese_info,cd.categories_name,c.categories_image,c.sort_order 
								from t_categories c, t_categories_description cd 
								where  c.categories_id=cd.categories_id
								and cd.language_id=1
								and c.parent_id='".$level_1."'");
	
	while(!$second_category_query->EOF){
		$level_2 = $second_category_query->fields['categories_id'];
		
		$third_category_query = $db->Execute("select c.categories_id, c.categories_code,c.chinese_info,cd.categories_name,c.categories_image,c.sort_order
								from t_categories c, t_categories_description cd
								where  c.categories_id=cd.categories_id
								and cd.language_id=1
								and c.parent_id='".$level_2."' order by c.categories_code");
		while(!$third_category_query->EOF){
			$level_3 = $third_category_query->fields['categories_id'];
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$level_1);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$top_category_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$level_2);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$second_category_query->fields['categories_name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$level_3);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$third_category_query->fields['categories_name']);
				
			$i++;
			$third_category_query->MoveNext();
		}
		
		$second_category_query->MoveNext();
	}
		
	
	
	$top_category_query->MoveNext();
}
*/

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save("F:/dorabeads_data/featured_categ.xlsx");
//$objWriter->save("products/new_featured.xlsx");

echo $i;
exit;

?>