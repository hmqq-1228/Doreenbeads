<?php
@set_time_limit(0);
@ini_set('memory_limit','10240M');
require ('includes/application_top.php');
if(isset($_POST['action']) && $_POST['action'] == 'export'){
	$coupons = $_POST['coupons'];
	require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
	
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '使用coupon的订单号');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Coupon Code');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '订单金额(USD)');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', '下单站点');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', '订单来源（W代表网站，M代表手机站）');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', '客户ID');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'VIP等级');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(38);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
	
	$coupons[0] = trim($coupons[0]);
	if(empty($coupons) || empty($coupons[0])) {
		$messageStack->add_session("请输入COUPON编号!" . $coupons_error_str, "error");
		zen_redirect(zen_href_link(FILENAME_CUSTOMERS_LOSS_COUPON_USE, zen_get_all_get_params(array ('action', 'coupons')), 'NONSSL'));
	}
	
	$coupon_id_success = array();
	$coupon_code_error = array();
	foreach($coupons as $coupon) {
		$coupon = trim($coupon);
		if(!empty($coupon)) {
			$coupon_exist = "select coupon_id from " . TABLE_COUPONS . " where coupon_code=:coupon";
			$coupon_exist = $db->bindVars($coupon_exist, ':coupon', $coupon, 'string');
			$coupon_result = $db->Execute($coupon_exist);
			if(!empty($coupon_result->fields['coupon_id'])) {
				array_push($coupon_id_success, $coupon_result->fields['coupon_id']);
			} else {
				array_push($coupon_code_error, $coupon);
			}
		}
	}
	$coupon_id_success = array_unique($coupon_id_success);
	if(!empty($coupon_code_error)) {
		$coupons_error_str = implode(",", $coupon_code_error);
		$coupons_all_str = implode(",", $coupons);
		$messageStack->add_session("COUPON编号不存在：" . $coupons_error_str, "error");
		zen_redirect(zen_href_link(FILENAME_CUSTOMERS_LOSS_COUPON_USE, zen_get_all_get_params(array ('action', 'coupons')) . 'coupons=' . $coupons_all_str, 'NONSSL'));
	}
	
	$last_month = date("Y-m-d H:i:s", strtotime("-1 month"));
	$data_index = 2;

	$customers_loss_sql = "select o.orders_id, c.coupon_code, o.order_total, o.language_id, if(o.from_mobile = 1, 'M', 'W') web_or_mobile, o.customers_id, concat(if(gp.group_percentage is null, 0, gp.group_percentage), '%') group_percentage from " . TABLE_COUPON_REDEEM_TRACK . " cr INNER JOIN " . TABLE_ORDERS . " o on o.orders_id=cr.order_id INNER JOIN " . TABLE_COUPONS . " c on c.coupon_id=cr.coupon_id inner join " . TABLE_CUSTOMERS . " cs on cs.customers_id=o.customers_id left join " . TABLE_GROUP_PRICING . " gp  on gp.group_id=cs.customers_group_pricing where o.orders_status in( " . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . " ) and  cr.coupon_id in(" . implode(",", $coupon_id_success) . ") and o.customers_email_address not like '%@panduo.com.cn%' and o.customers_email_address not like '%@163.com%' and o.customers_email_address not like '%@qq.com%' order by order_total desc";
	$customers_loss_result = $db_slave->Execute($customers_loss_sql);

	while (!$customers_loss_result->EOF) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $data_index, $customers_loss_result->fields['orders_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $data_index, $customers_loss_result->fields['coupon_code']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $data_index, $customers_loss_result->fields['order_total']);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $data_index, $customers_loss_result->fields['language_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $data_index, $customers_loss_result->fields['web_or_mobile']);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $data_index, $customers_loss_result->fields['customers_id']);
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $data_index, $customers_loss_result->fields['group_percentage']);
		$data_index++;
		
		$customers_loss_result->MoveNext();
	}

	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	$file_name = 'DB流失客户coupon效果统计_' . date('Ymd_H') . '.xls';;
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
}else{
	$coupons = zen_db_prepare_input(trim($_GET['coupons']));
	$coupons_array = array();
	if(!empty($coupons)) {
		$coupons_array = explode(",", $coupons);
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
<script language="javascript" src="includes/jquery.js"></script>
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
<style type="text/css">
td{line-height:280%;}
</style>
<body onLoad="init()">
<script language="javascript">
$(function() {
	$(".jq_coupon_add").click(function() {
		var row = $(".jq_coupon tr").eq(0).clone(true);
		$(row).find("input").val("");
		$(row).find(".jq_coupon_delete").show();
		$(".jq_coupon").append(row);
	});
	
	$(".jq_coupon_delete").click(function() {
		$(this).parent().parent().remove();
	});
});
</script>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">流失客户Coupon使用效果</p>
		<div style="padding-left: 50px; font-size:14px;">
			<form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_CUSTOMERS_LOSS_COUPON_USE,zen_get_all_get_params(array('action')) . 'action=export');?>" method="post">
			<input type="hidden" name="action" value="export" />
			 <table>
			 	<tr>
			 		<td>Coupon Code</td>
			 		<td>
			 			  <table class="jq_coupon">
			 			  	<?php if(empty($coupons_array)) {?>
						 	<tr>
						 		<td><input type="text" maxlength="40" size="24" name="coupons[]" /> <a style="text-decoration: underline; display: none;" href="javascript:void(0);" class="jq_coupon_delete">删除</a></td>
						 	</tr>
						 	<?php }else {?>
						 	<?php foreach($coupons_array as $coupon) {?>
						 		<?php if (!empty($coupon)) {?>
						 		<tr>
							 		<td><input type="text" maxlength="40" size="24" name="coupons[]" value="<?php echo $coupon;?>" /> <a style="text-decoration: underline;" href="javascript:void(0);" class="jq_coupon_delete">删除</a></td>
							 	</tr>
							 	<?php }?>
						 	<?php }}?>
						 </table>
			 		</td>
			 	</tr>
			 	<tr>
			 		<td></td>
			 		<td><a style="text-decoration: underline; display: inline;" href="javascript:void(0);" class="jq_coupon_add">添加一行</a></td>
			 	</tr>
			 	<tr>
			 		<td></td>
			 		<td><br/><input type="submit" value="导出" />
						<br/>此处导出的数据已排除了panduo.com.cn、163.com、qq.com的邮箱</td>
			 	</tr>
			 </table>
			 <br/><br/>
			
			</form>

		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>