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
		$date = date('Y-m-d');
		$starttime = date('Y-m-d',strtotime("$date - 3 month")).' 00:00:00';
		$stoptime = date('Y-m-d',strtotime("$date - 1 day")).' 23:59:59';
		$from = '';
		if($from_mobile == 0){
			$from = 'dorabeads';
		}else{
			$from = 'dorabeads-mobilesite';
		}

		$sale_date_query_raw = "select count(DISTINCT c.customers_id) as count_customer,customers_group_pricing from ".TABLE_CUSTOMERS." c where c.customers_email_address NOT LIKE '%panduo.com.cn%' GROUP BY c.customers_group_pricing asc";
		$sale_date = $db->Execute($sale_date_query_raw);
		
		$three_order_query = "select count(DISTINCT o.customers_id) count_customer,sum(o.order_total) as sum_order_total,avg(o.order_total),c.customers_group_pricing from ".TABLE_ORDERS." o,".TABLE_CUSTOMERS." c where o.customers_id = c.customers_id and o.date_purchased > '".$starttime."' and o.date_purchased < '".$stoptime."' AND o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") AND o.customers_email_address NOT LIKE '%panduo.com.cn%' GROUP BY c.customers_group_pricing ORDER BY c.customers_group_pricing";
		$three_order = $db->Execute($three_order_query);
		$three_order_array = array();
		while(!$three_order->EOF){
			$three_order_array[$three_order->fields['customers_group_pricing']] = array('count_customer'=>$three_order->fields['count_customer'],
																						'sum_order_total'=>$three_order->fields['sum_order_total']);
			$three_order->MoveNext();
		}
		
		$register_no_order_query = "select count(DISTINCT c.customers_id) as count_customer,customers_group_pricing from ".TABLE_CUSTOMERS." c where c.customers_email_address NOT LIKE '%panduo.com.cn%' and customers_group_pricing = 0 and customers_level = 0";
		$register_no_order = $db->Execute($register_no_order_query);
		$register_no_order_text = $register_no_order->fields['count_customer'];

		$register_in_order_query = "select count(DISTINCT c.customers_id) as count_customer,customers_group_pricing from ".TABLE_CUSTOMERS." c where c.customers_email_address NOT LIKE '%panduo.com.cn%' and customers_group_pricing = 0 and customers_level = 20";
		$register_in_order = $db->Execute($register_in_order_query);
		$register_in_order_text = $register_in_order->fields['count_customer'];
		

		$group_pricing = $db->Execute("SELECT group_id,group_percentage FROM  ".TABLE_GROUP_PRICING." LIMIT 0 , 30");
		$group_pricing_array = array();
		while(!$group_pricing->EOF){
			$group_pricing_array[$group_pricing->fields['group_id']] = $group_pricing->fields['group_percentage'];
			$group_pricing->MoveNext();
		}
		if(isset($sale_date) && $sale_date->RecordCount() > 0){
			$all_count_register = 0;
			$str = '<table border="1" valign="top" style="font-size:15px;width:900px;text-align: center;border-spacing: 0px;">
					<tr  style="background-color: #fff;height: 40px;">
						<th>网站</th>
						<th>VIP等级</th>
						<th>客户数量</th>
						<th>三个月内有订单记录的客户数量</th>
						<th>三个月内订单总额</th>
						<th>5.01注册未下单</th>
						<th>5.01注册有下单</th>
					</tr>';
			$customers_group_pricing = '';
			while(!$sale_date->EOF){
						$register_no_order_text_1 = '';
						$register_in_order_text_1 = '';
						if((int)$group_pricing_array[$sale_date->fields['customers_group_pricing']] > 0){
							$customers_group_pricing =  (int)$group_pricing_array[$sale_date->fields['customers_group_pricing']].'%';
						}else{
							$customers_group_pricing = 	'$5.01';
							$register_no_order_text_1 = $register_no_order_text;
							$register_in_order_text_1 = $register_in_order_text;
						}
						$str.='<tr  style="background-color: #fff;height: 40px;">
							<td>'.$from.'</td>
							<td>'.$customers_group_pricing.'</td>
							<td>'.$sale_date->fields['count_customer'].'</td>
							<td>'.$three_order_array[$sale_date->fields['customers_group_pricing']]['count_customer'].'</td>
							<td>'.'$'.$three_order_array[$sale_date->fields['customers_group_pricing']]['sum_order_total'].'</td>
							<td>'.$register_no_order_text_1.'</td>
							<td>'.$register_in_order_text_1.'</td>
						</tr>';
					$sale_date->MoveNext();
				}
			$str.= '</table>';
			//echo $str;exit;
		outputXlsHeader($str,"(".$from."-". $starttime .'-'. $stoptime . "-download_sale_date)");
	}
}else{
	if(isset($_POST['action']) && $_POST['action'] == 'search_status'){
		$from_mobile = $_POST['from_mobile'];
		$date = date('Y-m-d');
		$starttime = date('Y-m-d',strtotime("$date - 3 month")).' 00:00:00';
		$stoptime = date('Y-m-d',strtotime("$date - 1 day")).' 23:59:59';
		$from = '';
		if($from_mobile == 0){
			$from = 'dorabeads';
		}else{
			$from = 'dorabeads-mobilesite';
		}

		$sale_date_query_raw = "select count(DISTINCT c.customers_id) as count_customer,customers_group_pricing from ".TABLE_CUSTOMERS." c where c.customers_email_address NOT LIKE '%panduo.com.cn%' GROUP BY c.customers_group_pricing asc";
		$sale_date = $db->Execute($sale_date_query_raw);
		
		$three_order_query = "select count(DISTINCT o.customers_id) count_customer,sum(o.order_total) as sum_order_total,avg(o.order_total),c.customers_group_pricing from ".TABLE_ORDERS." o,".TABLE_CUSTOMERS." c where o.customers_id = c.customers_id and o.date_purchased > '".$starttime."' and o.date_purchased < '".$stoptime."' AND o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") AND o.customers_email_address NOT LIKE '%panduo.com.cn%' GROUP BY c.customers_group_pricing ORDER BY c.customers_group_pricing";
		$three_order = $db->Execute($three_order_query);
		$three_order_array = array();
		while(!$three_order->EOF){
			$three_order_array[$three_order->fields['customers_group_pricing']] = array('count_customer'=>$three_order->fields['count_customer'],
																						'sum_order_total'=>$three_order->fields['sum_order_total']);
			$three_order->MoveNext();
		}
		
		$register_no_order_query = "select count(DISTINCT c.customers_id) as count_customer,customers_group_pricing from ".TABLE_CUSTOMERS." c where c.customers_email_address NOT LIKE '%panduo.com.cn%' and customers_group_pricing = 0 and customers_level = 0";
		$register_no_order = $db->Execute($register_no_order_query);
		$register_no_order_text = $register_no_order->fields['count_customer'];

		$register_in_order_query = "select count(DISTINCT c.customers_id) as count_customer,customers_group_pricing from ".TABLE_CUSTOMERS." c where c.customers_email_address NOT LIKE '%panduo.com.cn%' and customers_group_pricing = 0 and customers_level = 20";
		$register_in_order = $db->Execute($register_in_order_query);
		$register_in_order_text = $register_in_order->fields['count_customer'];
		

		$group_pricing = $db->Execute("SELECT group_id,group_percentage FROM  ".TABLE_GROUP_PRICING." LIMIT 0 , 30");
		$group_pricing_array = array();
		while(!$group_pricing->EOF){
			$group_pricing_array[$group_pricing->fields['group_id']] = $group_pricing->fields['group_percentage'];
			$group_pricing->MoveNext();
		}
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
		<p class="pageHeading">销售数据导出</p>
		<br/><br/>

		
		<div style="padding-left: 50px;">
			
			<form  name="products_status" id="products_status" action="sale_date.php" method="post">
			
			<input type="hidden" name="action" value=""/>
			
			<input type="hidden" name="downlaod_sql" value = "<?php echo $sale_date_query_raw;?>"/>
			<input type="button" value="查询" onclick="search_status();"/>
			<input type="button" value="下载" onclick="get_excel();"/>
			</form>
			<br/><br/><br/>
			<?php if(isset($sale_date) && $sale_date->RecordCount() > 0){?>
			<table border="1" valign="top" style="font-size:15px;width:900px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>网站</th>
					<th>VIP等级</th>
					<th>客户数量</th>
					<th>三个月内有订单记录的客户数量</th>
					<th>三个月内订单总额</th>
					<th>5.01注册未下单</th>
					<th>5.01注册有下单</th>
				</tr>
				<?php while(!$sale_date->EOF){?>
						<tr  style="background-color: #fff;height: 40px;">
							
							<td><?php echo $from?></td>
							<td><?php 
								if((int)$group_pricing_array[$sale_date->fields['customers_group_pricing']] > 0){
									echo (int)$group_pricing_array[$sale_date->fields['customers_group_pricing']].'%';
								}else{
									echo '$5.01';
								}
							?></td>
							<td><?php echo $sale_date->fields['count_customer']?></td>
							<td><?php echo $three_order_array[$sale_date->fields['customers_group_pricing']]['count_customer']?></td>
							<td><?php echo '$'.$three_order_array[$sale_date->fields['customers_group_pricing']]['sum_order_total']?></td>
							<td><?php 
								if($sale_date->fields['customers_group_pricing'] == 0){
									echo $register_no_order_text;
								}?></td>
							<td><?php 
								if($sale_date->fields['customers_group_pricing'] == 0){
									echo $register_in_order_text;
								}?></td>
							
						</tr>
				
				<?php   
					$sale_date->MoveNext();
				} ?>
			</table>
			<?php }else{?>
				
			<?php }?>
		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>