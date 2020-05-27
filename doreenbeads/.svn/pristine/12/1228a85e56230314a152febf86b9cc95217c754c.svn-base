<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$method_code = strtolower($_POST['method_code']);
$method_query = $db->Execute('select id from t_shipping where code = "' . $method_code . '" limit 1');
if ($method_query->RecordCount() == 0){
	$messageStack->add_session('这种运送方式不存在， 更新失败！', 'error');
	zen_redirect(zen_href_link('shipping', 'action=updates'. '&orderby=' . $order_by, 'NONSSL'));
}
$method_id = $method_query->fields['id'];
$method_code_upper = strtoupper($method_code);

//bof process zen_area_postage.xls
if (isset($_FILES['postage_file']) && $_FILES['postage_file']['error'] == 0){
	$new_file_postage = 'download/' . $method_code . '_p.xls';
	
    if (file_exists($new_file_postage)){
    	unlink($new_file_postage);
    }
    move_uploaded_file($_FILES['postage_file']['tmp_name'], $new_file_postage);
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel = PHPExcel_IOFactory::load($new_file_postage);
	
	process_xls_data($method_code, $method_id, $objPHPExcel, 'postage');
	unlink($new_file_postage);
}
//eof process zen_area_postage.xls
//bof process zen_area_country.xls
if (isset($_FILES['country_file']) && $_FILES['country_file']['error'] == 0){
	$new_file_country = 'download/' . $method_code . '_c.xls';
	
	if (file_exists($new_file_country)){
    	unlink($new_file_country);
    }
    move_uploaded_file($_FILES['country_file']['tmp_name'], $new_file_country);
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel = PHPExcel_IOFactory::load($new_file_country);
	
	process_xls_data($method_code, $method_id, $objPHPExcel, 'country');
	unlink($new_file_country);
}
//eof process zen_area_postage.xls

zen_redirect(zen_href_link('shipping', '', 'NONSSL'));

?>