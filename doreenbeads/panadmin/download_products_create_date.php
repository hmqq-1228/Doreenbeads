<?php
require ('includes/application_top.php');
function outputXlsHeader($data,$file_name = 'export')
{
	ob_end_clean();
    header('Content-Type: text/xls'); 
    header ( "Content-type:application/vnd.ms-excel;charset=utf-8" );
    $str = mb_convert_encoding($file_name, 'gbk', 'utf-8');         
    header('Content-Disposition: attachment;filename="' .$str . '.xls"');      
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');        
    header('Expires:0');         
    header('Pragma:public');
    $encode = mb_detect_encoding($data, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
	$data = mb_convert_encoding($data, $encode, 'utf-8'); 
      
    echo $data;    
    die();
}
if(isset($_POST['action']) && $_POST['action'] == 'get_excel'){
	$from_mobile = $_POST['from_mobile'];
	$starttime = $_POST['starttime'];
	$stoptime = $_POST['stoptime'];
	$from = '';
	if($from_mobile == 0){
		$from = 'dorabeads';
	}else{
		$from = 'dorabeads-mobilesite';
	}
	$products_create_date_query_raw =  $_POST['downlaod_sql'];
	$products_create_date = $db->Execute($products_create_date_query_raw);
	if($products_create_date->RecordCount() > 0){
			$all_count_register = 0;
			$str = '<table border="1" valign="top" style="font-size:15px;width:700px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>查询时间</th>
					<th>网站</th>
					<th>产品编号</th>
					<th>中文名称</th>
					<th>产品线</th>
					<th>上架时间</th>
				</tr>';
			while(!$products_create_date->EOF){
					$str.='<tr  style="background-color: #fff;height: 40px;">
							<td>'.$starttime .'--'. $stoptime.'</td>
							<td>'.$from.'</td>
							<td>'.$products_create_date->fields['products_model'].'</td>
							<td>'.$products_create_date->fields['chinese_info'].'</td>
							<td>’'.(string)$products_create_date->fields['categories_code'].'</td>
							<td>'.(string)$products_create_date->fields['products_date_added'].'</td>
						</tr>';
					$products_create_date->MoveNext();
			}
			$str.= '</table>';
		outputXlsHeader($str,"(".$from."-". $starttime .'-'. $stoptime . "-download_products_create_date)");
	}
}else{
	if(isset($_POST['action']) && $_POST['action'] == 'search_status'){
		$from_mobile = $_POST['from_mobile'];
		$starttime = $_POST['starttime'];
		$stoptime = $_POST['stoptime'];
		$from = '';
		if($from_mobile == 0){
			$from = 'dorabeads';
		}else{
			$from = 'dorabeads-mobilesite';
		}
		$products_create_date_query_raw = "select p.products_model,c.chinese_info,c.categories_code,p.products_date_added from ".TABLE_PRODUCTS." p,".TABLE_CATEGORIES." c where p.master_categories_id = c.categories_id and products_date_added > '".$starttime." 00:00:00' and products_date_added < '".$stoptime." 00:00:00' ";
		$products_create_date = $db->Execute($products_create_date_query_raw);
	}else{
		
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
<style>
#products_upload_main {
	padding: 10px;
}

#products_upload_main p {
	margin: 0px;
}

.inputdiv {
	margin: 20px 0 30px 20px;
}

.headertitle {
	font-size: 15px;
	padding: 0 0 5px;
}

.inputdiv {
	font-size: 12px;
}

.inputdiv  .filetips {
	color: #FF6600;
	font-size: 12px;
	padding: 5px 0;
}

.inputdiv  .filetips a {
	color: #0000ff;
	text-decoration: underline;
}

.submitdiv {
	margin-top: 8px;
}

.submitdiv input {
	font-size: 16px;
	width: 100px;
}
</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">产品状态数据</p>
		<br/><br/>

		
		<div style="padding-left: 50px;">
			
			<form  name="products_status" id="products_status" action="download_products_create_date.php" method="post">
			请选择网站类型：
			<input type="radio" name="from_mobile" id="web"  value="0" <?php if(!$from_mobile) echo 'checked';?> /><label for="web">网站</label>
			<br/><br/>
			<input type="hidden" name="action" value=""/>
			  查询开始时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d'), 'onClick="WdatePicker();"  ')) .' 00:00:00'; 
			?>
			 <br/>
			 查询结束时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d'), 'onClick="WdatePicker();"  ')).' 23:59:59'; 
			?>
			<input type="hidden" name="downlaod_sql" value = "<?php echo $products_create_date_query_raw;?>"/>
			<input type="button" value="查询" onclick="search_status();"/>
			<input type="button" value="下载" onclick="get_excel();"/>
			</form>
			<br/><br/><br/>
			<?php if(isset($products_create_date) && $products_create_date->RecordCount() > 0){?>
			<table border="1" valign="top" style="font-size:15px;width:700px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>查询时间</th>
					<th>网站</th>
					<th>产品编号</th>
					<th>中文名称</th>
					<th>产品线</th>
					<th>上架时间</th>
				</tr>
				<?php while(!$products_create_date->EOF){?>
						<tr  style="background-color: #fff;height: 40px;">
							<td><?php echo $starttime .'--'. $stoptime; ?></td>
							<td><?php echo $from?></td>
							<td><?php echo $products_create_date->fields['products_model']?></td>
							<td><?php echo $products_create_date->fields['chinese_info']?></td>
							<td><?php echo (string)$products_create_date->fields['categories_code']?></td>
							<td><?php echo (string)$products_create_date->fields['products_date_added']?></td>
							
						</tr>
				
				<?php   
					$products_create_date->MoveNext();
				} ?>
			</table>
			<?php }else{?>
				没有记录！！
			<?php }?>
		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>