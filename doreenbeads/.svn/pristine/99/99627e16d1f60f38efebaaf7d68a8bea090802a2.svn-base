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
//	$products_query_raw =  'select products_model from '.TABLE_PRODUCTS.'';
	$products_query_raw = "
select p.products_model,
case when p.products_status=0 then '下货' when p.products_status=1 and p.products_limit_stock=0 then '正常销售' when p.products_status=1 and p.products_limit_stock=1 then '绑定库存' else '' end as stats,
ps.products_quantity,
case when pp.pp_products_id>0 and pp.pp_is_forbid != 20 and pp.pp_promotion_start_time <= '". date('Y-m-d H:i:s') ."' and pp.pp_promotion_end_time >= '". date('Y-m-d H:i:s') ."' AND ppp.promotion_status = 1 then '1' else '0' end as is_promotion
from t_products p 
left join " . TABLE_PRODUCTS_STOCK . " ps on p.products_id=ps.products_id
left join " . TABLE_PROMOTION_PRODUCTS ." pp on pp.pp_products_id=p.products_id
left join " . TABLE_PROMOTION . " ppp on ppp.promotion_id=pp.pp_promotion_id
where p.products_status != 10 ";
	$products = $db->Execute($products_query_raw);
	if($products->RecordCount() > 0){
			$str = '<table border="1" valign="top" style="font-size:14px;width:50px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;">
					<th>产品编号</th>
					<th>状态</th>
					<th>库存</th>
					<th>是否促销</th>
				</tr>';
			while(!$products->EOF){
				if(trim($products->fields['products_model']) != ''){
					$str.='<tr  style="background-color: #fff;">
							<td>'.$products->fields['products_model'].'</td>
							<td>'.$products->fields['stats'].'</td>
							<td>'.$products->fields['products_quantity'].'</td>
							<td>'.$products->fields['is_promotion'].'</td>
						</tr>';
				}
					$products->MoveNext();
			}
			$str.= '</table>';
		outputXlsHeader($str,"(products_model_".date('Y-m-d').")");
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
		<p class="pageHeading">导出网站所有产品编号</p>
		<br/><br/>

		
		<div style="padding-left: 50px;">
			
			<form  name="products_status" id="products_status" action="download_products_model.php" method="post">
			<input type="hidden" name="action" value=""/>
			<input type="button" style="height:30px;width:50px;" value="下载" onclick="get_excel();"/>
			</form>
		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>