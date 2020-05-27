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
	$order_avg_query_raw =  $_POST['downlaod_sql'];
	if(isset($order_avg_query_raw)){
		$order_avg = $db->Execute($order_avg_query_raw);
	}
	
	if(isset($order_avg) && $order_avg->RecordCount() > 0){
			$order_avg_all_query_raw = "select  avg(o.order_total) order_avg,l.code
										from ".TABLE_ORDERS." o,".TABLE_LANGUAGES." l
										where o.date_purchased > '".$starttime." 00:00:00' 
										and o.date_purchased  < '".$stoptime." 23:59:59' 
										and o.language_id  = l.languages_id
										and o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
										and o.customers_email_address not like '%panduo.com.cn%' and o.from_mobile = ".$from_mobile
										;
			$order_avg_all = $db->Execute($order_avg_all_query_raw);
			$all_order_avg = 0;
			$str = '<table border="1" valign="top" style="font-size:15px;width:400px;text-align: center;border-spacing: 0px;">
					<tr  style="background-color: #fff;height: 40px;">
					<th>时间</th>
					<th>网站</th>
					<th>平均订单金额</th>
				</tr>';
			while(!$order_avg->EOF){
					$str.='<tr  style="background-color: #fff;height: 40px;">
						<td>'.$starttime .'--'. $stoptime.'</td>
						<td>'.$from.'-'.$order_avg->fields['code'].'</td>
						<td>$'.round($order_avg->fields['order_avg'],2).'</td>
					</tr>';
					$all_order_avg = $all_order_avg + $order_avg->fields['order_avg'];
					$order_avg->MoveNext();
			}
			$str.='<tr  style="background-color: #fff;height: 40px;">
						<td>'.$starttime .'--'. $stoptime.'</td>
						<td>'.$from.'-all</td>
						<td>$'.round($order_avg_all->fields['order_avg'],2).'</td>
					</tr>';
			$str.= '</table>';
		outputXlsHeader($str,"(". $from.'--'  . $starttime .'--'. $stoptime . "-order_avg_total)");
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
		$order_avg_query_raw = "select  avg(o.order_total) order_avg,l.code
										from ".TABLE_ORDERS." o,".TABLE_LANGUAGES." l
										where o.date_purchased > '".$starttime." 00:00:00' 
										and o.date_purchased  < '".$stoptime." 23:59:59' 
										and o.language_id  = l.languages_id
										and o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
										and o.customers_email_address not like '%panduo.com.cn%' and o.from_mobile = ".$from_mobile." 
										group by  o.language_id asc";
		$order_avg = $db->Execute($order_avg_query_raw);

		$order_avg_all_query_raw = "select  avg(o.order_total) order_avg,l.code
										from ".TABLE_ORDERS." o,".TABLE_LANGUAGES." l
										where o.date_purchased > '".$starttime." 00:00:00' 
										and o.date_purchased  < '".$stoptime." 23:59:59' 
										and o.language_id  = l.languages_id
										and o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
										and o.customers_email_address not like '%panduo.com.cn%' and o.from_mobile = ".$from_mobile
										;
		$order_avg_all = $db->Execute($order_avg_all_query_raw);
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
		<p class="pageHeading">网站整体平均订单金额统计（不包含panduo.com.cn邮箱结尾的数据）</p>
		<div style="padding-left: 50px;">
			<form  name="products_status" id="products_status" action="order_avg_total.php" method="post">
			<input type="hidden" name="action" value=""/>
			请选择网站类型：
			<input type="radio" name="from_mobile" id="web"  value="0" <?php if(!$from_mobile) echo 'checked';?> /><label for="web">网站</label>
			&nbsp;
			<input type="radio" name="from_mobile" id="mobile" <?php if($from_mobile) echo 'checked';?> value="1"/><label for="mobile">手机站</label>
			<br/><br/>
			
			  开始时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d'), 'onClick="WdatePicker();"  ')) .' 00:00:00'; 
			?>
			 <br/>
			 结束时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d'), 'onClick="WdatePicker();"  ')).' 23:59:59'; 
			?>
			<input type="hidden" name="downlaod_sql" value = "<?php echo $order_avg_query_raw;?>"/>
			<input type="button" value="查询" onclick="search_status();"/>
			<input type="button" value="下载" onclick="get_excel();"/>
			</form>
			<br/><br/><br/>
			<?php if(isset($order_avg) && $order_avg->RecordCount() > 0){
				  $all_order_avg = 0;?>
			<table border="1" valign="top" style="font-size:15px;width:500px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>时间</th>
					<th>网站</th>
					<th>平均订单金额</th>
				</tr>
				<?php while(!$order_avg->EOF){?>
						<tr  style="background-color: #fff;height: 40px;">
							<td><?php echo $starttime .'--'. $stoptime; ?></td>
							<td><?php echo $from.'-'.$order_avg->fields['code'] ?></td>
							<td><?php echo '$'.round($order_avg->fields['order_avg'],2)?></td>
						</tr>
				
				<?php   $all_order_avg = $all_order_avg + $order_avg->fields['order_avg'];
						$order_avg->MoveNext();
					  } ?>
					   <tr  style="background-color: #fff;height: 40px;">
									<td><?php echo $starttime .'--'. $stoptime; ?></td>
									<td><?php echo $from.'--all' ?></td>
									<td><?php echo '$'.round($order_avg_all->fields['order_avg'],2)?></td>
					   </tr>
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