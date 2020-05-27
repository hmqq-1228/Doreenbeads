<?php
@set_time_limit(0);
@ini_set('memory_limit','10240M');
require ('includes/application_top.php');
$action = $_GET['action'];
$download = $_GET['download'];
if($action == "get_advertisement_customer_order_data_template") {
		$download = 'file/template_advertisement_customer_order_data.xls';
		$file = fopen($download, "r");
		header("Content-type:text/html;charset=utf-8"); 
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: " . filesize($download));
		$file_name = '广告客户订单数据模板.xls';
		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
			header('Content-type: application/octetstream');
		} else {
			header('Content-Type: application/x-octet-stream');
		}
		header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
		echo fread($file, filesize($download));
		fclose($file);
} else if($action == "import_advertisement_customer_order_data") {
		require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
		require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel/Reader/Excel5.php');
		$objReader = new PHPExcel_Reader_Excel5();

		$file = $_FILES['xls_file'];
		$filename = basename($file['name']);
		$ext_name = substr($filename, strrpos($filename, '.') + 1);

		$error = $error_empty = $error_has_exist = '';
		$i = 0;
		if (empty($ext_name)) {
			$error .= '请先选择文件';
		} else if ($ext_name != 'xls') {
			$error .= '文件格式有误，请上传xls格式的文件';
		} else {
			if (file_exists($file['tmp_name'])) {
				$objPHPExcel = $objReader->load($file['tmp_name']);
				$sheet = $objPHPExcel->getActiveSheet();
				
				$array_orders_id = array();
				
				for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
					$orders_id = trim(zen_db_prepare_input($sheet->getCellByColumnAndRow(0, $j)->getValue()));
					if (empty ($orders_id)) {
						$error_empty .= 'line' . $j . '订单ID不能为空!' . '<br/>';
						continue;
					}
					
					if(!is_numeric($orders_id)) {
						$error_empty .= 'line' . $j . '订单ID只能是数字!' . '<br/>';
						continue;
					}
					
					if(in_array($orders_id, $array_orders_id)) {
						$error_has_exist .= 'line' . $j . '订单ID重复!' . '<br/>';
						continue;
					} else {
						array_push($array_orders_id, $orders_id);
					}
				}
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setCellValue('A1', '订单ID');
				$objPHPExcel->getActiveSheet()->setCellValue('B1', '客户ID');
				$objPHPExcel->getActiveSheet()->setCellValue('C1', '下单国家');
				$objPHPExcel->getActiveSheet()->setCellValue('D1', '是否首次下单');
				$objPHPExcel->getActiveSheet()->setCellValue('E1', '排除掉这次上一次的下单时间');
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
				
				
	            
	            $data_index = 2;
				foreach($array_orders_id as $orders_id) {
					$country_name = $customers_id = $is_first = $previous_order_time = "";
					
					$orders_info = $db_slave->Execute("select customers_id, ip_address from " . TABLE_ORDERS . " where orders_id=" . $orders_id);
					if($orders_info->RecordCount() > 0) {
						$customers_id = $orders_info->fields['customers_id'];
						$ips = explode('.', $orders_info->fields['ip_address']);
						$ipno =($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
						
						$country_result = $db_slave->Execute("SELECT country_code, country_name FROM ip_country WHERE ip_to >=" . $ipno . " and ip_from <=" . $ipno . " order  by ip_to LIMIT 1");
						if($country_result->RecordCount() > 0 && $country_result->fields['country_name'] != "-") {
							$country_name = $country_result->fields['country_name'];
						}
						
						$first_result = $db_slave->Execute("select orders_id from " . TABLE_ORDERS . " o where o.customers_id=" . $customers_id . " and o.orders_id<" . $orders_id . " limit 1");
						if($first_result->RecordCount() <= 0) {
							$is_first = "是";
						} else {
							$is_first = "否";
						}
						
						$previous_result = $db_slave->Execute("select max(date_purchased) date_purchased from " . TABLE_ORDERS . " o where o.customers_id=" . $customers_id . " and o.orders_id<" . $orders_id . "");
						if($previous_result->RecordCount() > 0) {
							$previous_order_time = $previous_result->fields['date_purchased'];
						}
					}
										
					$objPHPExcel->getActiveSheet()->setCellValue('A' . $data_index, $orders_id);
					$objPHPExcel->getActiveSheet()->setCellValue('B' . $data_index, $customers_id);
					$objPHPExcel->getActiveSheet()->setCellValue('C' . $data_index, $country_name);
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $data_index, $is_first);
					$objPHPExcel->getActiveSheet()->setCellValue('E' . $data_index, $previous_order_time);
					
					$data_index++;
				}
				
				$download = 'download/advertisement_customer_order_data_' . $_SESSION['admin_name'] . '_' . date('YmdHis') . '.csv';
	          	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	            $objWriter->save($download);
			} else {
				$error .= '未知错误' . '<br/>';
			}
			if (!empty ($error_empty)) {
				$error .= $error_empty;
			}
			if (!empty ($error_has_exist)) {
				$error .= $error_has_exist;
			}
		}
		if (count($array_orders_id) > 0) {
			$success = '成功导出'. count($array_orders_id) .'条记录';
			$messageStack->add_session($success, 'success');
		}
		if (!empty ($error)) {
			$messageStack->add_session($error, 'error');
		}
		zen_redirect(zen_href_link(FILENAME_ADVERTISEMENT_CUSTOMER_ORDER_DATA, zen_get_all_get_params(array ('action')) . 'download=' . $download, 'NONSSL'));
}  else if($action == "download") {
		$file = fopen($download, "r");
		header("Content-type:text/html;charset=utf-8"); 
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: " . filesize($download));
		$file_name = '广告客户订单数据_' . date("Ymd") . '.xls';
		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
			header('Content-type: application/octetstream');
		} else {
			header('Content-Type: application/x-octet-stream');
		}
		header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
		echo fread($file, filesize($download));
		fclose($file);
} else {

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script type="text/javascript">
		<!--
		function init()
		{
		cssjsmenu('navbar');
		if (document.getElementById)
		{
		var kill = document.getElementById('hoverJS');
		kill.disabled = true;
		}
		}
		// -->
</script>

</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">广告客户订单数据</p>
		<div style="padding-left: 50px; font-size:14px;">
			<form  enctype="multipart/form-data" name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_ADVERTISEMENT_CUSTOMER_ORDER_DATA,zen_get_all_get_params(array('action')) . 'action=import_advertisement_customer_order_data');?>" method="post">
			<input type="hidden" name="action" value="export" />
			
			 <input type="file" id="xls_file" name="xls_file" style="font-size:14px;" /> <a href="<?php echo zen_href_link(FILENAME_ADVERTISEMENT_CUSTOMER_ORDER_DATA,zen_get_all_get_params(array('action')) . 'action=get_advertisement_customer_order_data_template');?>" style="font-size:14px;">下载模版</a>
			 <br/><br/>
			<input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="上传" />
			<?php if(!empty($download)) {?>
			<br/><br/><a href="<?php echo zen_href_link(FILENAME_ADVERTISEMENT_CUSTOMER_ORDER_DATA,zen_get_all_get_params(array('action', 'download')) . 'action=download&download=' . $download);?>" style="font-size:14px;">点击</a> 下载广告数据
			<?php }?>
			</form>

		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); }?>