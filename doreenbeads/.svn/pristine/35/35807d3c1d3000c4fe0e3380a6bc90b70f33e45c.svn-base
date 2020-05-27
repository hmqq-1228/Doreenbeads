<?php
require ('includes/application_top.php');
/*
统计第一次购买的客户，没有时间限制
$start_time  订单开始时间
$end_time    订单结束时间
$acount_start_time  注册启示时间(为订单开始时间前一个月)
$lang        下单语种
*/
set_time_limit(0);
error_reporting(0);
function get_languages_count($start_time, $end_time, $clicks_type){
	global $db;
	if (empty($start_time) || empty($end_time) || empty($clicks_type)) {
		return;
	}
	$where = ' and clicks_code = '. $clicks_type .' and created_time >= "' . $start_time . ' 00:00:00 " and created_time <= "'. $end_time . ' 23:59:59 "';
	$sql = "select hour(created_time) as hour, created_time,languages_id,count(*) as total_clicks from ". TABLE_COUNT_CLICKS ." where 1 = 1 ". $where ." group by hour(created_time),languages_id";
	//echo $sql;
	$count_clicks_result = $db->Execute($sql);
	while ( ! $count_clicks_result->EOF ) {
		$count_clicks_array[] = array('hour' => $count_clicks_result->fields['hour'],
									'created_time' => $count_clicks_result->fields['created_time'],
									'languages_id' => $count_clicks_result->fields['languages_id'],
									'total_clicks' => $count_clicks_result->fields['total_clicks']);
		$count_clicks_result -> MoveNext();
	}
	

	return $count_clicks_array;
}

function get_click_type($clicks_type){
	global $db;
	$sql = "select * from " . TABLE_COUNT_CLICKS_DESCRIPTION . " where clicks_code = " .$clicks_type;
	$result = $db->Execute($sql);
	return $result->fields['clicks_description'];
}


function outputXlsHeader($data,$file_name = 'export')
{
	ob_end_clean();
    header('Content-Type: text/xls'); 
    header( "Content-type:application/vnd.ms-excel;charset=utf-8" );
    $str = mb_convert_encoding($file_name, 'utf-8', 'utf-8');         
    header('Content-Disposition: attachment;filename="' .$str . '.xls"');      
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');        
    header('Expires:0');         
    header('Pragma:public');
    $encode = mb_detect_encoding($data, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
	$data = mb_convert_encoding($data, $encode, 'utf-8');
      
    echo $data;    
    die();
}


if(isset($_POST['action'])){
	if(isset($_POST['action']) && ($_POST['action'] == 'search_status' || $_POST['action'] == 'get_excel')){
		$starttime = $_POST['starttime'];
		$stoptime = $_POST['stoptime'];
		$clicks_type = $_POST['clicks_type'];
		$error_massage = '';
		$error = false;

		if (empty($starttime)) {
			$starttime = date('Y-m-d',strtotime("-1 day")) .' 00:00:00';
		}
		if (empty($stoptime)) {
			$stoptime = date('Y-m-d',strtotime("-1 day")) .' 23:59:59';
		}
		
		if ($stoptime >= date('Y-m-d') || $starttime > $stoptime) {
			$error_massage .= '请重新选择结束日期<br/>';
			$error = true;
		}

		if (!$error) {
			# code...
		
			$languages = zen_get_languages ();
		
			$count_clicks_array = get_languages_count($starttime, $stoptime,$clicks_type);
			$total_all_clicks_result = $db->Execute("select count(*) as total_clicks from " . TABLE_COUNT_CLICKS . " where created_time >= '". $starttime ." 00:00:00 '  and created_time <= '" . $stoptime . " 23:59:59 ' and clicks_code = ". $clicks_type );
		 	$total_all_clicks_counts = $total_all_clicks_result -> fields['total_clicks'];
//print_r($total_all_clicks_counts);
			$time_array = array();
			for ($i=0; $i < 24; $i++) {
				if ($i%2 == 0) {
					$time_array[$i]['start'] = $i . ':00:00';
				}else{
					$time_array[$i-1]['end'] = $i . ':59:59';
				}
			}
//print_r($time_array);
		//$time_array = array_values($time_array);

			$str = '';
			$str.='<table border="0" class="info_table" valign="top" ><tr><th></th>';
			foreach ($languages as $key => $value) {
				$str .= '<th>'. $value['name'] .'</th>';
			}
			$str.='<th>总计</th><th>占比</th></tr>';

			foreach ($time_array as $key => $time) {
				$total = array();
				foreach ($count_clicks_array as $count_clicks) {
					if ( $count_clicks['hour'] >= $key && $count_clicks['hour'] < ($key+2) ) {
						$total[$count_clicks['languages_id']] += $count_clicks['total_clicks'];
						$total_all_clicks[$count_clicks['languages_id']] += $count_clicks['total_clicks'];
					}
				}
				//var_dump($total);
				$period_total_clicks = (int)($total[1]+$total[2]+$total[3]+$total[4]);
				$str.='<tr>
					<td>'.$time['start'] . ' -- ' . $time['end'] .'</td>
					<td>'.(int)$total[1].'</td>
					<td>'.(int)$total[2].'</td>
					<td>'.(int)$total[3].'</td>
					<td>'.(int)$total[4].'</td>
					<td>'.$period_total_clicks.'</td>
					<td>'.round($period_total_clicks / $total_all_clicks_counts * 100 ,2).'%</td>
					
				    </tr>';
			}

			
			$str .= '<tr>
						<td>总计</td>
						<td>'.(int)$total_all_clicks[1].'</td>
						<td>'.(int)$total_all_clicks[2].'</td>
						<td>'.(int)$total_all_clicks[3].'</td>
						<td>'.(int)$total_all_clicks[4].'</td>
						<td>'.(int)$total_all_clicks_counts.'</td>
						<td> / </td>						
					    </tr>';

			$str .= '<tr>
						<td>占比</td>
						<td>'.round($total_all_clicks[1] / $total_all_clicks_counts * 100 ,2).'%</td>
						<td>'.round($total_all_clicks[2] / $total_all_clicks_counts * 100 ,2).'%</td>
						<td>'.round($total_all_clicks[3] / $total_all_clicks_counts * 100 ,2).'%</td>
						<td>'.round($total_all_clicks[4] / $total_all_clicks_counts * 100 ,2).'%</td>
						<td> / </td>
						<td> / </td>						
					    </tr>';
			$str.='</table>';

			if($_POST['action'] == 'get_excel'){
				
				$name = get_click_type($clicks_type);
				
				outputXlsHeader( $str, $name ."次数统计-" . date('Ymd') );
			}
			//print_r($order_date_tongqi);exit;
		}
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

.info_table{font-size:12px;width:100%;text-align: center;border-spacing: 0px;border: 1px solid #aaa;border-collapse:collapse}
.info_table tr{border: 1px solid #aaa;background-color: #fff;height: 30px;}
.info_table tr td,th{border: 1px solid #aaa;}
</style>
</head>
<body onLoad="init()">
<?php 
	require(DIR_WS_INCLUDES . 'header.php'); 
	$click_type_result = $db->Execute("select * from " . TABLE_COUNT_CLICKS_DESCRIPTION);
	while (! $click_type_result->EOF) {
		$click_type_array[] = array('clicks_code' => $click_type_result->fields['clicks_code'],
									'clicks_description' => $click_type_result->fields['clicks_description']);
		$click_type_result -> MoveNext();
	}
?>
<div style="padding: 10px;">
		<p class="pageHeading">点击次数统计</p>
		<div style="padding-left: 50px;">
			<form  name="products_status" id="products_status" action="count_clicks.php" method="post">
			<input type="hidden" name="action" value=""/>
			统计对象:
			<select name="clicks_type" id="">
				<?php foreach ($click_type_array as $key => $value) { ?>
					<option value="<?php echo $value['clicks_code'] ?>" <?php echo ($clicks_type == $value['clicks_code']) ? selected : '' ?> ><?php echo $value['clicks_description']?></option>
				<?php } ?>				
			</select>
			<br/><br/>
			 开始时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d',strtotime("-1 day")), 'class = "123" onClick="WdatePicker();"  ')) .' 00:00:00'; 
			 //显示时分秒
			 //echo zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d',strtotime("-1 day")).' 00:00:00', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			?>
			 <br/>
			 结束时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d',strtotime("-1 day")), 'onClick="WdatePicker();"  ')).' 23:59:59'; 
			 //显示时分秒
			 //echo zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d',strtotime("-1 day")) .' 23:59:59', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			?>
			<br/><br/>
			<input type="hidden" name="downlaod_sql" value = "<?php echo $order_date_query_raw;?>"/>
			<input type="button" value="查询" onclick="search_status();"/>
			<input type="button" value="下载" onclick="get_excel();"/>
			</form>
			<br/><br/><br/>
			
			<?php  

			if ($error_massage) {
				echo $error_massage;
			}else{
				echo $str;
			}?>
		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>