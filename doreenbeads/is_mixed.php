<?php
include('includes/application_top.php');
include(DIR_WS_CLASSES . 'excel/PHPexcel.php');

$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load('excel/mix.xls');

$allRow = $objPHPExcel->getActiveSheet()->getHighestRow();
for ($j = 0; $j < $allRow; $j++){
	$index = $j + 1;
	$excelValue = trim($objPHPExcel->getActiveSheet()->getCell('A' . $index));
	$db->Execute('update ' . TABLE_PRODUCTS . ' set is_mixed = 1 where products_model = "' . $excelValue . '"');
}
?>