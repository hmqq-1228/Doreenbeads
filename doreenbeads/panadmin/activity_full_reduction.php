<?php
require ('includes/application_top.php');
if(isset($_POST['action']) && ($_POST['action'] == 'search_status' || $_POST['action'] == 'get_excel')){
	
	require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
	
	$starttime_activity = zen_db_prepare_input($_POST['starttime_activity']);
	$stoptime_activity = zen_db_prepare_input($_POST['stoptime_activity']);
	$starttime_contrast = zen_db_prepare_input($_POST['starttime_contrast']);
	$stoptime_contrast = zen_db_prepare_input($_POST['stoptime_contrast']);
	
	if(empty($starttime_activity) || empty($stoptime_activity) || empty($starttime_contrast) || empty($stoptime_contrast)) {
		$messageStack->add_session("请先选择时间!", 'error');
		zen_redirect(zen_href_link(FILENAME_ACTIVITY_FULL_REDUCTION, zen_get_all_get_params(array())));
	}
	if(strtotime($starttime_activity) - strtotime($stoptime_activity) > 86400 * 31) {
		$messageStack->add_session("活动时间跨度不能超过31天!", 'error');
		zen_redirect(zen_href_link(FILENAME_ACTIVITY_FULL_REDUCTION, zen_get_all_get_params(array())));
	}
	
	if(strtotime($starttime_contrast) - strtotime($stoptime_contrast) > 86400 * 31) {
		$messageStack->add_session("参考时间跨度不能超过31天!", 'error');
		zen_redirect(zen_href_link(FILENAME_ACTIVITY_FULL_REDUCTION, zen_get_all_get_params(array())));
	}
	
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('享受满减的订单');
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', '订单总金额');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '满减的金额');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', '下单站点');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', '订单来源（W代表网站，M代表手机站）');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', '最近一次下单时间');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', '最近一次下单金额');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', '客户ID');
	$objPHPExcel->getActiveSheet()->setCellValue('I1', '客户VIP等级');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', '  客户类型');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(38);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
	
	
	$data_index = 2;
	$customers_loss_sql = "select *, if(temp3.order_total_last > 0, '老', '新') as customers_new from (select temp1.orders_id, temp1.order_total, ot.`value`, temp1.language_id, if(temp1.from_mobile > 0, 'M', 'W') web_or_mobile, ifnull((select date_purchased from t_orders where customers_id=temp1.customers_id and orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ") and date_purchased<'" . $starttime_activity . "' order by orders_id desc limit 1), 0) date_purchased_last, ifnull((select order_total from t_orders where customers_id=temp1.customers_id and orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ") and date_purchased<'" . $starttime_activity . "' order by orders_id desc limit 1), 0) order_total_last, temp1.customers_id, concat(ifnull(gp.group_percentage, 0), '%') group_percentage from (select orders_id, order_total, language_id, from_mobile, customers_id from t_orders where orders_id in(select orders_id from t_orders_total where orders_id in (select orders_id from t_orders where orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ") and date_purchased>='" . $starttime_activity . "' and date_purchased<='" . $stoptime_activity . "' and customers_email_address not like '%panduo.com.cn%' and customers_email_address not like '%qq.com%' and customers_email_address not like '%163%') and class='ot_promotion' and value>0)) temp1 inner join t_orders_total ot on ot.orders_id=temp1.orders_id and ot.class='ot_promotion' left join t_customers c on temp1.customers_id=c.customers_id left join t_group_pricing gp on gp.group_id=c.customers_group_pricing) temp3";
	$customers_loss_result = $db_slave->Execute($customers_loss_sql);

	while (!$customers_loss_result->EOF) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $data_index, $customers_loss_result->fields['orders_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $data_index, $customers_loss_result->fields['order_total']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $data_index, $customers_loss_result->fields['value']);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $data_index, $customers_loss_result->fields['language_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $data_index, $customers_loss_result->fields['web_or_mobile']);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $data_index, $customers_loss_result->fields['date_purchased_last']);
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $data_index, $customers_loss_result->fields['order_total_last']);
		$objPHPExcel->getActiveSheet()->setCellValue('H' . $data_index, $customers_loss_result->fields['customers_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $data_index, $customers_loss_result->fields['group_percentage']);
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $data_index, $customers_loss_result->fields['customers_new']);
		$data_index++;
		
		$customers_loss_result->MoveNext();
	}
	
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(1);
	$objPHPExcel->getActiveSheet()->setTitle('活动期间下单情况');
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', '购买的物品金额');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '下单站点');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	
	
	$data_index = 2;
	$customers_loss_sql = "select temp1.orders_id, temp1.value, o.language_id from (select orders_id, `value` from t_orders_total where class='ot_subtotal' and orders_id in(select orders_id from t_orders where orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ") and date_purchased>='" . $starttime_activity . "' and date_purchased<='" . $stoptime_activity . "' and customers_email_address not like '%panduo.com.cn%' and customers_email_address not like '%qq.com%' and customers_email_address not like '%163%')) temp1 inner join t_orders o on o.orders_id=temp1.orders_id";
	$customers_loss_result = $db_slave->Execute($customers_loss_sql);

	while (!$customers_loss_result->EOF) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $data_index, $customers_loss_result->fields['orders_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $data_index, $customers_loss_result->fields['value']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $data_index, $customers_loss_result->fields['language_id']);
		$data_index++;
		
		$customers_loss_result->MoveNext();
	}
	
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(2);
	$objPHPExcel->getActiveSheet()->setTitle('非活动期间下单情况');
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', '购买的物品金额');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '下单站点');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	
	
	$data_index = 2;
	$customers_loss_sql = "select temp1.orders_id, temp1.value, o.language_id from (select orders_id, `value` from t_orders_total where class='ot_subtotal' and orders_id in(select orders_id from t_orders where orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ") and date_purchased>='" . $starttime_contrast . "' and date_purchased<='" . $stoptime_contrast . "' and customers_email_address not like '%panduo.com.cn%' and customers_email_address not like '%qq.com%' and customers_email_address not like '%163%')) temp1 inner join t_orders o on o.orders_id=temp1.orders_id";
	$customers_loss_result = $db_slave->Execute($customers_loss_sql);

	while (!$customers_loss_result->EOF) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $data_index, $customers_loss_result->fields['orders_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $data_index, $customers_loss_result->fields['value']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $data_index, $customers_loss_result->fields['language_id']);
		$data_index++;
		
		$customers_loss_result->MoveNext();
	}

	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	$file_name = '满减活动数据统计_' . date('Ymd_H') . '.xls';;
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
		header('Content-type: application/octetstream');
	} else {
		header('Content-Type: application/x-octet-stream');
	}
	header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
  	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    $objWriter->save('php://output'); //文件通过浏览器下载
	exit;
	
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
<script language="javascript" src="includes/jquery.js"></script>
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>

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
<style>

</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">满减活动情况（不包含panduo.com.cn、163.com、qq.com邮箱结尾的数据）</p>
		<div style="padding-left: 50px;">
			<form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_ACTIVITY_FULL_REDUCTION,zen_get_all_get_params(array()));?>" method="post">
			<input type="hidden" name="action" value="get_excel"/>
			
			
			活动时间:&nbsp;<?php 
			 echo zen_draw_input_field('starttime_activity', '', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			 echo " 到 " . zen_draw_input_field('stoptime_activity', '', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			?>
			 <br/><br/>
			参考时间:&nbsp;<?php 
			 echo zen_draw_input_field('starttime_contrast', '', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			 echo " 到 " . zen_draw_input_field('stoptime_contrast', '', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			 echo " (<font color=red>非活动参考时间</font>)";
			?>
			<input type="hidden" name="downlaod_sql" value = "<?php echo $order_date_query_raw;?>"/>
			<br/><br/>
			<input type="submit" value="导出" />
			</form>
			<br/>
		</div>
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>