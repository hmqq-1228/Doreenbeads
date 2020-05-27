<?php
require ('includes/application_top.php');
$languages = zen_get_languages();
$language_count = sizeof($languages);
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

    if(isset($_POST['action']) && ($_POST['action'] == 'search_status' || $_POST['action'] == 'get_excel')){
		$from_mobile = $_POST['from_mobile'];
		$starttime = $_POST['starttime'];
		$stoptime = $_POST['stoptime'];
		$starttime_order = $_POST['starttime_order'];
		$stoptime_order = $_POST['stoptime_order'];
		$from = '';
		if($from_mobile == 0){
			$from = 'doreenbeads';
		}else{
			$from = 'doreenbeads-mobilesite';
		}
		$customers_order_array = array();
		$customers_register_query_raw = "SELECT c.register_entry, count(DISTINCT (c.customers_email_address)) as count_customer,c.register_languages_id,l.code FROM  
										".TABLE_CUSTOMERS." c, ".TABLE_CUSTOMERS_INFO." ci,".TABLE_LANGUAGES." l WHERE 
										ci.customers_info_id = c.customers_id
										and c.register_languages_id = l.languages_id
										AND ci.customers_info_date_account_created  >= '".$starttime." 00:00:00' 
										and ci.customers_info_date_account_created  <= '".$stoptime." 23:59:59' 
										AND c.customers_email_address NOT LIKE '%panduo.com.cn%'
										and c.from_mobile = ".$from_mobile."
										group by c.register_languages_id,c.register_entry 
                                        ORDER BY c.register_languages_id";
		$customers_register = $db->Execute($customers_register_query_raw);
		
		if($customers_register->RecordCount() > 0){
		    while (!$customers_register->EOF){
		        for ($i=1; $i <= 7; $i++){
		            if($customers_register->fields['register_languages_id'] == $i){
		                $customers_order_array[$i]['count_customer'] += $customers_register->fields['count_customer'];
		                if($customers_register->fields['register_entry'] == 1){
		                    $customers_order_array[$i]['index_register_count'] = $customers_register->fields['count_customer'];
		                }elseif($customers_register->fields['register_entry'] == 2){
		                    $customers_order_array[$i]['login_register_count'] = $customers_register->fields['count_customer'];
		                }elseif($customers_register->fields['register_entry'] == 3){
		                    $customers_order_array[$i]['windows_register_count'] = $customers_register->fields['count_customer'];
		                }elseif($customers_register->fields['register_entry'] == 4){
		                    $customers_order_array[$i]['share_register_count'] = $customers_register->fields['count_customer'];
		                }elseif(in_array($customers_register->fields['register_entry'], array(5,6,7))){
		                    $customers_order_array[$i]['api_register_count'] += $customers_register->fields['count_customer'];
		                }elseif($customers_register->fields['register_entry'] == 10){
		                    $customers_order_array[$i]['other_register_count'] = $customers_register->fields['count_customer'];
		                }
		            }
		        }
		        $customers_register->MoveNext();
		    }
		}
		
		$customers_order_query_raw = "select l.`languages_id`, count(1) count from " . TABLE_CUSTOMERS . " c INNER JOIN 
				" . TABLE_LANGUAGES . " l on l.languages_id=c.register_languages_id 
                where c.customers_id in(
                    SELECT customers_id FROM " . TABLE_CUSTOMERS . " c, ".TABLE_CUSTOMERS_INFO . " ci 
                    WHERE ci.customers_info_id = c.customers_id 
                    AND ci.customers_info_date_account_created >= '".$starttime." 00:00:00' 
                    and ci.customers_info_date_account_created <= '".$stoptime." 23:59:59' 
                    AND c.customers_email_address NOT LIKE '%panduo.com.cn%' 
                    and c.from_mobile = " . $from_mobile . ") 
                    and customers_id in
                    (select customers_id from " . TABLE_ORDERS . "
                     where orders_status in(" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") 
                     and date_purchased >= '".$starttime_order." 00:00:00' and date_purchased <= '".$stoptime_order." 23:59:59') GROUP BY c.register_languages_id";
		$customers_order = $db->Execute($customers_order_query_raw);
		
		while(!$customers_order->EOF) {
			$customers_order_array[$customers_order->fields['languages_id']]['orders_count'] = $customers_order->fields['count'];
			$customers_order->MoveNext();
		}
		
		if($_POST['action'] == 'get_excel'){
		    if($customers_register->RecordCount() > 0){
		        $all_count_register = $all_count_order = 0;
		        $str = '<table border="1" valign="top" style="font-size:15px;width:1600px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>注册时间</th>
					<th>注册站点</th>
					<th>注册数</th>
					<th>首页弹窗注册数</th>
					<th>注册页面注册数</th>
					<th>注册弹窗注册数</th>
					<th>8seasons注册数</th>
					<th>第三方账号注册数</th>
					<th>其他入口注册数</th>
					<th>注册且下单客户数</th>
				</tr>';
		        
		        $total_array = array();
		        foreach ($customers_order_array as $key => $info){
		            $str .= '<tr  style="background-color: #fff;height: 40px;">
							<td>' . $starttime .'--'. $stoptime . '</td>
							<td>' . $from.'-'.$languages[$key-1]['code'] . '</td>
							<td>' . ($info['count_customer'] > 0 ? $info['count_customer'] : 0) . '</td>
							<td>' . ($info['index_register_count'] > 0 ? $info['index_register_count'] : 0) . '</td>
							<td>' . ($info['login_register_count'] > 0 ? $info['login_register_count'] : 0) . '</td>
							<td>' . ($info['windows_register_count'] > 0 ? $info['windows_register_count'] : 0) . '</td>
							<td>' . ($info['share_register_count'] > 0 ? $info['share_register_count'] : 0) . '</td>
							<td>' . ($info['api_register_count'] > 0 ? $info['api_register_count'] : 0) . '</td>
							<td>' . ($info['other_register_count'] > 0 ? $info['other_register_count'] : 0) . '</td>
							<td>' . ($info['orders_count'] > 0 ? $info['orders_count'] : 0) . '</td>
						</tr>';
		            
		            $total_array['count_customer'] += $info['count_customer'];
		            $total_array['index_register_count'] += $info['index_register_count'];
		            $total_array['login_register_count'] += $info['login_register_count'];
		            $total_array['windows_register_count'] += $info['windows_register_count'];
		            $total_array['share_register_count'] += $info['share_register_count'];
		            $total_array['api_register_count'] += $info['api_register_count'];
		            $total_array['other_register_count'] += $info['other_register_count'];
		            $total_array['orders_count'] += $info['orders_count'];
		        }
		        
		        $str .= '<tr  style="background-color: #fff;height: 40px;">
									<td>' . $starttime .'--'. $stoptime . '</td>
									<td>' . $from.'--all'. '</td>
									<td>' . $total_array['count_customer'] . '</td>
									<td>' . $total_array['index_register_count'] . '</td>
									<td>' . $total_array['login_register_count'] . '</td>
									<td>' . $total_array['windows_register_count'] . '</td>
									<td>' . $total_array['share_register_count'] . '</td>
									<td>' . $total_array['api_register_count'] . '</td>
									<td>' . $total_array['other_register_count'] . '</td>
									<td>' . $total_array['orders_count'] . '</td>
					   </tr>
		             </table>';
		    }else{
		        $str = '<table><tr><td>没有记录！！</td></tr></table>';
		    }
		    outputXlsHeader($str,"(". $from.'--' . $starttime .'--'. $stoptime . "-customers_register)");exit();
		}
	}else{
		/*
		$from_mobile = 0;
		$customers_register_query_raw = "SELECT count(DISTINCT (c.customers_email_address)),c.register_languages_id,l.code FROM  
										".TABLE_CUSTOMERS." c, ".TABLE_CUSTOMERS_INFO." ci,".TABLE_LANGUAGES." l WHERE 
										ci.customers_info_id = c.customers_id
										and c.register_languages_id = l.languages_id
										AND ci.customers_info_date_account_created  > '".date('Y-m-d')." 00:00:00' 
										and ci.customers_info_date_account_created  < '".date('Y-m-d')." 23:59:59' 
										AND c.customers_email_address NOT LIKE '%panduo.com.cn%'
										and c.from_mobile = ".$from_mobile."
										group by  c.register_languages_id  asc";
										*/
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
		<p class="pageHeading">查询客户注册情况（不包含panduo.com.cn邮箱结尾的账号）</p>
		<div style="padding-left: 50px;">
			<form  name="products_status" id="products_status" action="customers_register_total.php" method="post">
			<input type="hidden" name="action" value=""/>
			请选择网站类型：
			<input type="radio" name="from_mobile" id="web"  value="0" <?php if(!$from_mobile) echo 'checked';?> /><label for="web">网站</label>
			&nbsp;
			<input type="radio" name="from_mobile" id="mobile" <?php if($from_mobile) echo 'checked';?> value="1"/><label for="mobile">手机站</label>
			<br/><br/>
			注册时间：<br/>
			  &nbsp;&nbsp;&nbsp;&nbsp;开始时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d'), 'onClick="WdatePicker();"  ')) .' 00:00:00'; 
			?>
			 <br/>
			&nbsp;&nbsp;&nbsp; 结束时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d'), 'onClick="WdatePicker();"  ')).' 23:59:59'; 
			?>
			<br/><br/>
			下单时间：<br/>
			  &nbsp;&nbsp;&nbsp;&nbsp;开始时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime_order', (isset($_POST['starttime_order']))?$_POST['starttime_order']: date('Y-m-d'), 'onClick="WdatePicker();"  ')) .' 00:00:00'; 
			?>
			 <br/>
			&nbsp;&nbsp;&nbsp; 结束时间:&nbsp;<?php 
			 echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime_order', (isset($_POST['stoptime_order']))?$_POST['stoptime_order']: date('Y-m-d'), 'onClick="WdatePicker();"  ')).' 23:59:59'; 
			?>
			<br/><br/><br/>
			<input type="hidden" name="downlaod_sql" value = "<?php echo $customers_register_query_raw;?>"/>
			<input type="hidden" name="downlaod_sql_order" value = "<?php echo $customers_order_query_raw;?>"/>
			<input type="button" value="查询" onclick="search_status();"/>
			<?php if(!empty($_POST['downlaod_sql'])) {?>
			<input type="button" value="下载该数据" onclick="get_excel();"/>
			<?php }?>
			</form>
			<div style="line-height: 20px;position:relative;top:10px;">各注册入口在2017-12-15之后才有记录。</div>
			<br/><br/><br/>
			<?php if(isset($_POST['action']) && $customers_register->RecordCount() > 0){
				  $all_count_register = $all_count_order = 0;?>
			<table border="1" valign="top" style="font-size:15px;width:1600px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>注册时间</th>
					<th>注册站点</th>
					<th>注册数</th>
					<th>首页弹窗注册数</th>
					<th>注册页面注册数</th>
					<th>注册弹窗注册数</th>
					<th>8seasons注册数</th>
					<th>第三方账号注册数</th>
					<th>其他入口注册数</th>
					<th>注册且下单客户数</th>
				</tr>
				<?php 
				    $total_array = array();
				    foreach ($customers_order_array as $key => $info){
				?>
						<tr  style="background-color: #fff;height: 40px;">
							<td><?php echo $starttime .'--'. $stoptime; ?></td>
							<td><?php echo $from.'-'.$languages[$key-1]['code']; ?></td>
							<td><?php echo $info['count_customer'] > 0 ? $info['count_customer'] : 0;?></td>
							<td><?php echo $info['index_register_count'] > 0 ? $info['index_register_count'] : 0;?></td>
							<td><?php echo $info['login_register_count'] > 0 ? $info['login_register_count'] : 0;?></td>
							<td><?php echo $info['windows_register_count'] > 0 ? $info['windows_register_count'] : 0;?></td>
							<td><?php echo $info['share_register_count'] > 0 ? $info['share_register_count'] : 0;?></td>
							<td><?php echo $info['api_register_count'] > 0 ? $info['api_register_count'] : 0;?></td>
							<td><?php echo $info['other_register_count'] > 0 ? $info['other_register_count'] : 0;?></td>
							<td><?php echo $info['orders_count'] > 0 ? $info['orders_count'] : 0;?></td>
						</tr>
				
				<?php   
    				$total_array['count_customer'] += $info['count_customer'];
    				$total_array['index_register_count'] += $info['index_register_count'];
    				$total_array['login_register_count'] += $info['login_register_count'];
    				$total_array['windows_register_count'] += $info['windows_register_count'];
    				$total_array['share_register_count'] += $info['share_register_count'];
    				$total_array['api_register_count'] += $info['api_register_count'];
    				$total_array['other_register_count'] += $info['other_register_count'];
    				$total_array['orders_count'] += $info['orders_count'];
					  } ?>
					   <tr  style="background-color: #fff;height: 40px;">
									<td><?php echo $starttime .'--'. $stoptime; ?></td>
									<td><?php echo $from.'--all' ?></td>
									<td><?php echo $total_array['count_customer'];?></td>
									<td><?php echo $total_array['index_register_count'];?></td>
									<td><?php echo $total_array['login_register_count'];?></td>
									<td><?php echo $total_array['windows_register_count'];?></td>
									<td><?php echo $total_array['share_register_count'];?></td>
									<td><?php echo $total_array['api_register_count'];?></td>
									<td><?php echo $total_array['other_register_count'];?></td>
									<td><?php echo $total_array['orders_count'];?></td>
					   </tr>
			</table>
			<div style="margin-top: 10px;">
				<div>* 首页弹窗，指的是客户首次访问我们网站时，出现的快速注册弹窗</div>
				<div>* 注册页面，指的是网站的登录注册页面</div>
				<div>* 注册弹窗，指的是进行需要登录状态下才能进行的操作时，出现的登录/注册弹窗</div>
				<div>* 8seasons注册数，指的是客户用8seasons的注册邮箱直接登录Doreenbeads（该邮箱未在Doreenbeads注册过），系统自动以该邮箱为客户注册的Doreenbeads账号数。</div>
				<div>* 第三方账号注册数，指的是客户使用Facebook等第三方账号直接登录网站时，网站自动注册的账号数量。</div>
				<div>* 其它注册入口，除以上注册入口外，其他未知的会自动生成账号的入口。</div>
			</div>
			<?php }else{?>
				没有记录！！
			<?php }?>
		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>