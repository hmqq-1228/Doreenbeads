<?php
@set_time_limit(0);
@ini_set('memory_limit','10240M');
require ('includes/application_top.php');
$action = $_GET['action'];
$download = $_GET['download'];
if($action == "get_customers_client_mailbox_conversion_template"){
    $download = 'file/template_customers_client_mailbox_conversion.xls';
    $file = fopen($download, "r");
	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: " . filesize($download));
	$file_name = '客户邮箱数据模板.xls';
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
			header('Content-type: application/octetstream');
		} else {
			header('Content-Type: application/x-octet-stream');
		}
		header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
		echo fread($file, filesize($download));
		fclose($file);
 }else if($action == "import_customers_client_mailbox_conversion") {
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
		$error .= '文件格式有误，请上传xls的文件';
	} else {
		if (file_exists($file['tmp_name'])) {
			$objPHPExcel = $objReader->load($file['tmp_name']);
			$sheet = $objPHPExcel->getActiveSheet();
			$array_customers_id = array();
			for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
				$customers_id = trim(zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue()));
				if (empty($customers_id)) {
					$error_empty .= 'line' . $j . '客户ID不能为空！' . '<br/>';
					continue;
				}
				if(!is_numeric($customers_id)) {
					$error_empty .= 'line' . $j . '客户ID只能是数字！' . '<br/>';
					continue;
				}
				if(in_array($customers_id,$array_customers_id)) {
					$error_has_exist .= 'line' . $j . '客户ID重复' . '<br/>';
					continue;
				}else{
					array_push($array_customers_id, $customers_id);
				}
			}

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1','用户ID');
			$objPHPExcel->getActiveSheet()->setCellValue('B1','用户邮箱');
			$data_index = 2;
			foreach($array_customers_id as $customers_id) {
                 // $email_address = "";
                 $customers_info = $db->Execute("select customers_email_address from " . TABLE_CUSTOMERS . " where customers_id =" . $customers_id);
                 $email_address = $customers_info->fields['customers_email_address'];
                 
                 $objPHPExcel->getActiveSheet()->setCellValue('A' . $data_index,$customers_id);
			     $objPHPExcel->getActiveSheet()->setCellValue('B' . $data_index,$email_address);
			     $data_index++;
			     
			}
				$download = 'download/customers_client_mailbox_conversion_' . $_SESSION['admin_name'] . '_' . date('YmdHis') . '.csv';
	            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	            $objWriter->save($download);
		}else {
			$error .= '未知错误' . '<br/>';
		}
        if (!empty ($error_empty)) {
			$error .= $error_empty;
		}
		if (!empty ($error_has_exist)) {
			$error .= $error_has_exist;
		}
	} 
	if (count($array_customers_id) > 0) {
		$success = '成功导出'. count($array_customers_id) .'条记录';
		$messageStack->add_session($success, 'success');
	}
	if (!empty ($error)) {
		$messageStack->add_session($error, 'error');
	} 
	zen_redirect(zen_href_link(FILENAME_CUSTOMERS_CLIENT_MAILBOX_CONVERSION, zen_get_all_get_params(array ('action')) . 'download=' . $download, 'NONSSL'));
} else if($action == "download") {
	  $file = fopen($download,"r");
	  header("Content-type:text/html;charset=utf-8"); 
	  Header("Content-type: application/octet-stream");
	  Header("Accept-Ranges: bytes");	
	  Header("Accept-Length: " . filesize($download));
	  $file_name = '客户邮箱数据_' .date("Ymd") . '.xls';
	  if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
	  	 header('Content-type: application/octetstream');
	  } else {
	  	header('Content-Type: application/x-octet-stream');
	  } 
	  header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312  ", $file_name));
	  echo fread($file, filesize($download));
	  fclose($file);
  }else{
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	// function submit_order_exproter(){
	// 	order_exporter.submit();
	// }
	// function search_status(){
	// 	document.products_status.action.value = 'search_status';
	// 	document.products_status.submit();
	// }
	// function get_excel(){
	// 	document.products_status.action.value = 'get_excel';
	// 	document.products_status.submit();
	// }
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
		}<a class="btn btn-w-m btn-primary btn-outline" href="{:url('EquipmentList/out')}">
		}
</script>
</head>
<body>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
   <p class="pageHeading">客户邮箱转换</p>
   <p style="margin: 30px 50px 30px 50px;font-size:14px;">将客户ID转换为客户邮箱:</p>
   <div style="padding-left: 100px; font-size:14px;">
   <form  enctype="multipart/form-data" name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_CUSTOMERS_CLIENT_MAILBOX_CONVERSION,zen_get_all_get_params(array('action')) . 'action=import_customers_client_mailbox_conversion');?>" method="post">
   	<input type="hidden" name="action" value="export"/>
    <input type="file" id="xls_file" name="xls_file" style="font-size:14px;" /><span style="color:red;">请务必将Excel文件中的客户ID放在第一位</span>
    <br/><br/>
   	<input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="上传" />
    <?php if(!empty ($download)) { ?>
      <br/><br/><a href="<?php echo zen_href_link(FILENAME_CUSTOMERS_CLIENT_MAILBOX_CONVERSION,zen_get_all_get_params(array('action','download')) . 'action=download&download=' . $download);?>" style="font-size:14px;">点击</a>下载客户邮箱数据
    <?php } ?>
    <a href="<?php echo zen_href_link(FILENAME_CUSTOMERS_CLIENT_MAILBOX_CONVERSION,zen_get_all_get_params(array('action')) . 'action=get_customers_client_mailbox_conversion_template');?>" style="font-size:14px;">下载模版</a>
    </form>
    </div>
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); }?>












