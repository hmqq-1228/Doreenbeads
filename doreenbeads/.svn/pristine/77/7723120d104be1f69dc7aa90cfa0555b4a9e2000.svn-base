<?php
@set_time_limit(0);
@ini_set('memory_limit','10240M');
require ('includes/application_top.php');
if(isset($_POST['action']) && $_POST['action'] == 'export'){
	$date_period = trim($_POST['date_period']);
	$download = 'download/products/' . $date_period;
	$file = fopen($download, "r");
	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: " . filesize($download));
	//$file_name = 'doreenbeads商品数据_20170602_' . $date_period . '期.csv';;
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
		header('Content-type: application/octetstream');
	} else {
		header('Content-Type: application/x-octet-stream');
	}
	header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $date_period));
	echo fread($file, filesize($download));
	fclose($file);
	exit;
}else{
	
	$handle = opendir("download/products");
	$file_array = array();
	while(false !== ($file = readdir($handle))){
		if($file == "." || $file == ".." || $file == ".svn" || strstr($file, ".zip") == ""){
			continue;
		}
		$key = $file;
		$file_explode = explode("_", $file);
		$name = str_replace(strstr($file_explode[2], "."), "", $file_explode[2]);
		array_push($file_array, array('key' => $key, 'name' => $name));
	}
	closedir($handle);
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
		<p class="pageHeading">下载doreenbeads商品数据</p>
		<div style="padding-left: 50px; font-size:14px;">
			<form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_DOWNLOAD_PRODUCT_CSV,zen_get_all_get_params(array('action')) . 'action=export');?>" method="post">
			<input type="hidden" name="action" value="export" />
			
			 doreenbeads商品数据&nbsp;:&nbsp;<select name="date_period">
			 	<?php 
			 	$number = 0;
			 	$date_ymd = date("Ymd");
			 	for($index = count($file_array) - 1; $index >=0; $index--) {
			 		$selected = "";
			 		if($file_array[$index]['name'] == $date_ymd) {
			 			$selected = " selected";
			 		}
			 	?>
			 	<option value="<?php echo $file_array[$index]['key'];?>"<?php echo $selected;?>><?php echo $file_array[$index]['name'];?>期</option>
			 	<?php 
			 		$number++;
			 		if($number > 4) {
			 			break;
			 		}
			 	}?>
			 </select>
			 <br/><br/>
			<input type="submit" value="导出" />
			</form>
			<br/><br/>
			备注：
			<br/>该数据会在每天<span style="font-size:20px; color:red;">14点55</span>左右生成

		</div>
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>