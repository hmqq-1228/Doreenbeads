<?php
require('includes/application_top.php');

require_once(DIR_WS_CLASSES . 'excel/PHPExcel.php');
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load("excel/t_promotion_products.xls");
$allSheet = $objPHPExcel->getSheetCount();
for ($i = 0; $i < $allSheet; $i++){
$objPHPExcel->setActiveSheetIndex($i);
switch ($i){
	case 0 : $type = 4;break;
	case 1 : $type = 3;break;
	case 2 : $type = 2;break;
}
/*取得一共有多少列*/
$allColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();

/*取得一共有多少行*/
$allRow = $objPHPExcel->getActiveSheet()->getHighestRow();
global $db;
// $sql = 'Insert Into tmp_price_refresh (tpr_model, tpr_net_price, tpr_price_time) Values ';
$sql = 'insert into t_promotion_products values ';
for($x = 0; $x <= $allRow; $x++){
	$a = $objPHPExcel->getActiveSheet()->getCell('A'.$x)->getValue();
	$b = $objPHPExcel->getActiveSheet()->getCell('B'.$x)->getValue();
	$c = $objPHPExcel->getActiveSheet()->getCell('C'.$x)->getValue();
	$d = $objPHPExcel->getActiveSheet()->getCell('D'.$x)->getValue();
	$e = $objPHPExcel->getActiveSheet()->getCell('E'.$x)->getValue();
	$f = $objPHPExcel->getActiveSheet()->getCell('F'.$x)->getValue();
	$pid = $db->Execute('select products_id from t_products where products_model = "' . $a . '" limit 1');
	if ($pid->RecordCount() == 1){
		$sql .= '(NULL, ' . $pid->fields['products_id'] . ', ' . $type . ', 1), ';
	}else{
		echo $a . '<br>';
	}
}
$sql = substr($sql, 0 ,-2);
$db->Execute($sql);
}
?>