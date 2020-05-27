<?php
@set_time_limit(0);
@ini_set('memory_limit','10240M');
require ('includes/application_top.php');

if(isset($_POST['action']) && $_POST['action'] == 'export'){
	$date_period = intval($_POST['date_period']);
	/*数据量太大时excel生成文件过大，下载会失败，所以采用csv
	require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
	
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '客户邮箱');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'VIP等级');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '注册时间');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', '付款订单总数');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', '付款订单总金额');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', '是否CLUB');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', '是否渠道商');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Coupon使用情况');
	$objPHPExcel->getActiveSheet()->setCellValue('I1', '是否订阅Newsletter');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', '最近一次下单站点');
	$objPHPExcel->getActiveSheet()->setCellValue('K1', '最近一次下单时间');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(24);
	*/
	
	$keyword_index = 2;

	$customers_loss_sql = "select customers_id, group_percentage, customers_info_date_account_created, orders_count, orders_amount, coupons_use_status_str, is_subscribe, last_order_languages_id, last_order_time 
			from " . TABLE_CUSTOMERS_LOSS . " where date_period=" . $date_period ." and customers_id>0";
	$customers_loss_result = $db_export->Execute($customers_loss_sql);

	$download = 'download/customers_loss_' . $_SESSION['admin_name'] . '_' . date('YmdHis') . '.csv';
	$fp = fopen($download, 'w');
	$array_head = array('客户ID', 'VIP等级', '注册时间', '付款订单总数', '付款订单总金额', 'Coupon使用情况', '是否订阅Newsletter', '最近一次下单站点', '最近一次下单时间');
	foreach($array_head as $array_head_key => $array_head_value) {
		$array_head[$array_head_key] = iconv("utf-8", "gb2312", $array_head_value);
	}
	fputcsv($fp, $array_head);
	while (!$customers_loss_result->EOF) {
		/*
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $keyword_index, $customers_loss_result->fields['customers_email_address']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $keyword_index, $customers_loss_result->fields['group_percentage']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $keyword_index, $customers_loss_result->fields['customers_info_date_account_created']);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $keyword_index, $customers_loss_result->fields['orders_count']);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $keyword_index, $customers_loss_result->fields['orders_amount']);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $keyword_index, $customers_loss_result->fields['is_club']);
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $keyword_index, $customers_loss_result->fields['is_channel']);
		$objPHPExcel->getActiveSheet()->setCellValue('H' . $keyword_index, $customers_loss_result->fields['coupons_use_status_str']);
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $keyword_index, $customers_loss_result->fields['is_subscribe']);
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $keyword_index, $customers_loss_result->fields['last_order_languages_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $keyword_index, $customers_loss_result->fields['last_order_time']);
		$keyword_index++;
		*/
		$subscribe_status = '是';
		switch ($customers_loss_result->fields['is_subscribe']){
			case 0: $subscribe_status = '否';break;
			case 1: $subscribe_status = '是';break;
			case 10: $subscribe_status = '已退订';break;
			default: $subscribe_status = '是';
		}
		$customers_loss_result->fields['group_percentage'] = $customers_loss_result->fields['group_percentage'] . "%";
		$customers_loss_result->fields['coupons_use_status_str'] = str_replace("/", "|", $customers_loss_result->fields['coupons_use_status_str']);
		$customers_loss_result->fields['is_subscribe'] = iconv("utf-8", "gb2312", $subscribe_status);
		fputcsv($fp, $customers_loss_result->fields);
		
		$customers_loss_result->MoveNext();
	}
	fclose($fp);
	
	/*
	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	$file_name = '8S流失客户数据_' . $date_period . '期.xlsx';
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
		header('Content-type: application/octetstream');
	} else {
		header('Content-Type: application/x-octet-stream');
	}
	header('Content-Disposition: attachment; filename=' . $file_name);
  	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    //$objWriter->save('php://output'); //文件通过浏览器下载
    */

	$file = fopen($download, "r");
	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: " . filesize($download));
	$file_name = 'DB流失客户数据_' . $date_period . '期.csv';;
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
		header('Content-type: application/octetstream');
	} else {
		header('Content-Type: application/x-octet-stream');
	}
	header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
	echo fread($file, filesize($download));
	fclose($file);
	exit;
}else{
	
	$sql = "select date_period from " . TABLE_CUSTOMERS_LOSS . " group by date_period order by auto_id desc limit 5";
	$result = $db_export->Execute($sql);
	$customers_loss_array = array();
	while (!$result->EOF) {
		$customers_loss_array[] = $result->fields;
		$result->MoveNext();
	}
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	function submit_order_exproter(){
		order_exporter.submit();
	}
	function search_status(){
		document.products_status.action.value = 'search_status';
		document.products_status.submit();
	}
	function get_excel(){
		document.products_status.action.value = 'get_excel';
		document.products_status.submit();
	}
</script>
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
		<p class="pageHeading">流失客户数据</p>
		<div style="padding-left: 50px; font-size:14px;">
			<form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_CUSTOMERS_LOSS,zen_get_all_get_params(array('action')) . 'action=export');?>" method="post">
			<input type="hidden" name="action" value="export" />
			
			 流失客户数据&nbsp;:&nbsp;<select name="date_period">
			 	<?php foreach($customers_loss_array as $customers_loss_value) {?>
			 	<option value="<?php echo $customers_loss_value['date_period'];?>"><?php echo $customers_loss_value['date_period'];?>期</option>
			 	<?php }?>
			 </select>
			 <br/><br/>
			<input type="submit" value="导出" />
			</form>
			<br/><br/>
			备注：
			<br/>1、近<span style="font-size:20px; color:red;">18个月</span>有下过已付款订单，但<b>最近两个月</b>没有下过已付款订单的客户
			<br/>2、此处导出的数据都已排除了panduo.com.cn、163.com、qq.com的邮箱

		</div>
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>