<?php
require ('includes/application_top.php');
require (DIR_WS_CLASSES . 'customers_group.php');
require (DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');

$action = zen_db_prepare_input($_POST['action']);
$amount_array = array();
if($action == 'search_status' || $action == 'get_excel'){
	$starttime = zen_db_prepare_input($_POST['starttime']);
	$stoptime = zen_db_prepare_input($_POST['stoptime']);
	
	$error = "";
	if(strtotime($stoptime) - strtotime($starttime) > 183 * 86400) {
		$error .= "开始时间和结束时间最大间隔半年!";
		$messageStack->add_session($error, 'error');
		zen_redirect(zen_href_link(FILENAME_BRAINTREE_AMOUNT_OF_PAYMENT, zen_get_all_get_params(array ('action')), 'NONSSL'));
	}
		
	$amount_sql = "select language_id, sum(order_total) order_total, CONCAT(YEAR(date_purchased), LPAD(MONTH(date_purchased), 2, 0)) as date_purchased_day from " . TABLE_ORDERS . " where orders_status in(" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . " ) and date_purchased>='" . $starttime . "' and date_purchased<'" . $stoptime . "' and customers_email_address not like '%@panduo.com.cn%' and customers_email_address not like '%@163.com%' and customers_email_address not like '%@qq.com%' and (payment_module_code='braintree' or orders_id in (select orders_id from " . TABLE_ORDERS_STATUS_HISTORY . " where date_added>='" . $starttime . "' and date_added<'" . $stoptime . "' and comments like 'Braintree%')) GROUP BY language_id";
	$amount_result = $db->Execute($amount_sql);
	$amount_array = array();
	while(!$amount_result->EOF) {
		$amount_array[$amount_result->fields['language_id']] = array('order_total' => $amount_result->fields['order_total']);
		$amount_result->MoveNext();
	}
	$languages = zen_get_languages();
	if($action == 'get_excel') {
		$array_title = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
		$array_title = array_splice($array_title, 0, count($array_title) - 1);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', '时间');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', $starttime . "/" . $stoptime);
		foreach($array_title as $title_key => $title) {
			foreach($languages as $language_key => $lanauge_value) {
				if($title_key + 1 == $lanauge_value['id']) {
					$languages[$language_key]['excel_title'] = $title;
					
				}
			}
		}
		
		
		foreach($languages as $language_key => $lanauge_value) {
			$objPHPExcel->getActiveSheet()->setCellValue($lanauge_value['excel_title'] . '1', $languages[$language_key]['chinese_name']);
			$objPHPExcel->getActiveSheet()->getColumnDimension($lanauge_value['excel_title'])->setWidth(20);
			$objPHPExcel->getActiveSheet()->getStyle($lanauge_value['excel_title'] . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$amout_money = "0";
			foreach($amount_array as $amount_key => $amount_value) {
				if($amount_key == $lanauge_value['id']) {
					$amout_money = $amount_value['order_total'];
				}
			}
			$objPHPExcel->getActiveSheet()->setCellValue($lanauge_value['excel_title'] . '2', $amout_money);
		}
	
		header("Content-type:text/html;charset=utf-8"); 
		Header("Content-type: application/octet-stream");
		$file_name = 'Braintree付款金额_' . date('Ymd_H') . '.xls';;
		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
			header('Content-type: application/octetstream');
		} else {
			header('Content-Type: application/x-octet-stream');
		}
		header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
	  	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	  	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	    $objWriter->save('php://output'); //文件通过浏览器下载
		
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
	function merge(){
		var customers_id_1 = $.trim($("#customers_id_1").val());
		var customers_id_2 = $.trim($("#customers_id_2").val());
		if(customers_id_1 == "") {
			alert("客户ID1不能为空!");
			return false;
		}
		if(customers_id_2 == "") {
			alert("客户ID2不能为空!");
			return false;
		}
		if(customers_id_1 == customers_id_2) {
			alert("客户ID1与客户ID2相同，请重新核对!");
			return false;
		}
		if(confirm("是否将客户ID：" + customers_id_1 + "与客户ID：" + customers_id_2 + "进行合并？") == true) {
			return true;
		}
		return false;
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
<style>
.info_table{font-size:12px;width:80%;text-align: center;border-spacing: 0px;border: 1px solid #aaa;border-collapse:collapse}
.info_table tr{border: 1px solid #aaa;background-color: #fff;height: 30px;}
.info_table tr td,th{border: 1px solid #aaa;}
</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">Braintree付款金额</p>
		<div style="padding-left: 50px; font-size:14px;">
			<form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_BRAINTREE_AMOUNT_OF_PAYMENT,zen_get_all_get_params(array('action')));?>" method="post">
			<input type="hidden" name="action" value=""/>
			 开始时间:&nbsp;<?php echo zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d',strtotime("-1 month")).' 00:00:00', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");?> <br/><br/>
			 结束时间:&nbsp;<?php echo zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d',strtotime("-1 day")) .' 23:59:59', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");?> (开始时间和结束时间最大间隔<b>半年</b>)
			 </select>
			 <br/><br/>
			<input type="button" value="查询" onclick="search_status();"/>
			<input type="button" value="导出" onclick="get_excel();"/>
			</form>
			<br/>
			<?php if(!empty($amount_array)) {?>
			<br/>
			<table class="info_table">
				<tr>
					<td>时间</td>
					<?php foreach($languages as $lanauge_value) {?>
					<td><?php echo $lanauge_value['chinese_name'];?></td>
					<?php }?>
				</tr>
				<tr>
					<td><?php echo $starttime;?> / <?php echo $stoptime;?></td>
					<?php foreach($languages as $lanauge_value) {?>
					<td><?php
						$amout_money = 0;
						foreach($amount_array as $amount_key => $amount_value) {
							if($amount_key == $lanauge_value['id']) {
								$amout_money = $amount_value['order_total'];
							}
						}
						echo $amout_money;
					?></td>
					<?php }?>
				</tr>
			</table>
			<?php } else if($_POST['action'] == 'search_status'){?>
			<br/>
			没有记录！
			<?php }?>
			
			<br/><br/>备注：1、此处金额为<b>美元</b> 2、此处导出的数据已排除了panduo.com.cn、163.com、qq.com的邮箱

		</div>
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>