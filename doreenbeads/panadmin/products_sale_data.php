<?php
require('includes/application_top.php');
set_time_limit(0);
@ini_set('memory_limit','2012M');
if (isset($_POST['action']) && $_POST['action']!='') {
	$action = $_POST['action'];
}else{
	$action = '';
}

switch ($action){
	case 'upload':
		$file = $_FILES['file'];		
		if($file['error']||empty($file)){
			$messageStack->add_session('Fail: File upload unsuccessfully '.$file['name'],'error');
			zen_redirect(zen_href_link('products_sale_data'));
		}
		//var_dump($_FILES);
		$path = dirname($_FILES['file']['tmp_name']);
		
		$lang = $_POST['lang'];
		if (!$lang) {
			$messageStack->add_session('Fail: 没有选择语言！ 请重新上传文件与选择语言','error');
			zen_redirect(zen_href_link('products_sale_data'));
		}
		$start_date = $_POST['startdate_year'].'-'.$_POST['startdate_month'].'-'.$_POST['startdate_day'].' '.$_POST['startdate_hour'].':00:00';
		$end_date   = $_POST['enddate_year'].'-'.$_POST['enddate_month'].'-'.$_POST['enddate_day'].' '.$_POST['enddate_hour'].':00:00';
			
		if (strtotime($start_date) >= strtotime($end_date)) {
			$messageStack->add_session('Fail: 选择时间区间有误，请确认时间选择是否正确。','error');
			zen_redirect(zen_href_link('products_sale_data'));
		}
		
		$filename = basename($file['name']);
		$ext_name = substr($filename, strrpos($filename, '.') + 1);
		if($ext_name!='xlsx'&&$ext_name!='xls'){
			$messageStack->add_session('文件格式有误，请上传xlsx或者xls格式的文件','error');
			zen_redirect(zen_href_link('products_sale_data'));
		}else{
			$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');
					
			set_include_path('../Classes/');
			include 'PHPExcel.php';
			if($ext_name=='xlsx'){
				include 'PHPExcel/Reader/Excel2007.php';
				include 'PHPExcel/Writer/Excel2007.php';
				$objReader = new PHPExcel_Reader_Excel2007;		
			}else{
				include 'PHPExcel/Reader/Excel5.php';
				include 'PHPExcel/Writer/Excel5.php';
				$objReader = new PHPExcel_Reader_Excel5;			
			}
			$file_from=$file['tmp_name'];
			$objPHPExcel = $objReader->load($file_from);
			$sheet = $objPHPExcel->getActiveSheet();
			
			
			for($j = 0;$j < count($lang);$j++){
  				if($lang[$j] == ''){  					
  				}			
	  			else{					
	  				$objPHPExcel->setActiveSheetIndex($lang[$j]-1);
	  				$sheet = $objPHPExcel->getActiveSheet();
					for ($i = 2;$i<=$sheet->getHighestRow();$i++){
						$products_model = zen_db_prepare_input($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$i)->getValue());
						if(isset($products_model)&&$products_model!=''){
							$products_sql = "SELECT count(DISTINCT customers_id) as customers_count,count(DISTINCT o.orders_id) as orders_acount, sum(products_quantity) as products_quantity_total, sum(final_price*products_quantity) as products_amount FROM  ".TABLE_ORDERS." o LEFT JOIN ".TABLE_ORDERS_PRODUCTS." op ON op.orders_id = o.orders_id WHERE products_model = '$products_model' and o.language_id = ".$lang[$j]." and o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") and o.date_purchased between '$start_date' and '$end_date' and o.customers_email_address NOT LIKE '%panduo.com.cn%' ";
							$products_result = $db->Execute($products_sql);
							
							while (!$products_result->EOF){
								$products_quantity_total = intval($products_result->fields['products_quantity_total']);
								$products_amount =  round($products_result->fields['products_amount'],2);
								$customers_count = $products_result->fields['customers_count'];
								$orders_acount   = $products_result->fields['orders_acount'];
								$products_result->MoveNext();
							}
							if($products_result->RecordCount()>0){
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$products_quantity_total);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$products_amount);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$customers_count);
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$orders_acount);
							}else {
								if ($products_model) {
									$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,0);
									$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,0);
									$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,0);
									$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,0);
								}
							}
						}			
					}				
				}
			}
		
			if($ext_name=='xlsx'){
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);					
			}else{
				$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);						
			}
			
			$objWriter->save($path."/dorabeads_销售_数据.".$ext_name);

			//rename($path."/darabeads_products_sale_data.".$ext_name, $path."/darabeads销售数据.".$ext_name);
			$path_new = $path."/dorabeads_销售_数据.".$ext_name;
			
			//$filename_new = "products_data.".$ext_name;
			zen_redirect(zen_href_link("down_excel",'pn='.$path_new));
		//	header("Content-type:application/vnd.ms-excel");		
		//	header("Content-Disposition:attachment;filename=products_data.".$ext_name);	
		}
		break;
	default:break;
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
<style>
	body{
		margin:opx auto;
	}
	ol li{
		padding:20px;font-size:14px
		
	}
</style>
<script type="text/javascript">
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }    
  }
  function checkall(){
	  var o = document.getElementById('allchecked');
	  var l = document.getElementsByName('lang[]');	
	  for(var i=0;i<l.length;i++){
		  if(o.checked == true){
			l[i].checked = true;
	      }else{
			l[i].checked = false;
		  }	      			
	  }
  }	
  function check(){
	  var o = document.getElementById('allchecked');
	  var l = document.getElementsByName('lang[]');
	  for(var i=0;i<l.length;i++){
		  if(l[i].checked == true){
			var c = true;
	      }else{
			c = false;
			break;
		  }	      			
	  }
	  if(c){
		  o.checked = true; 
	  }else{
		  o.checked = false;
	  }
  }	  	


  
</script>


</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 20px 20px 0px 80px;">
		<div class="pageHeading">商品销售数据导出    &nbsp;&nbsp;&nbsp; <a href="file/dorabeads_products_data.xls"><span style="color:#3260B6;font-size:14px;text-decoration:underline "> 点击下载表格模板</span></a></div>
		<br/><br/>
		<form action="products_sale_data.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="upload">
			<ol>
				<li>导入商品编号：
					
						<input type="file" id="file" name="file"><span>(.xls .xlsx)</span>
											
				</li>
				<li>选择语言站点：
					<input id="allchecked" type="checkbox" value="1" onclick="checkall()">All<br/>
					<br/>
					<span style="padding: 52px"></span>
					<?php $languages = zen_get_languages();$num = sizeof($languages);
					for($i=0;$i<$num;$i++){
						echo "<input onclick='check()' name='lang[]' type='checkbox' value='".$languages[$i]['id']."'>".$languages[$i]['code']."&nbsp;";
					}
					?>
					
				</li>
				<li>选择时间段：
					  &nbsp;&nbsp;&nbsp;<span>开始时间：</span>
					  <span><?php echo zen_draw_date_selector('startdate',mktime(date("H d m Y" ,time()))); ?>
					 
					  </span>
	        		  <br/>
	      			  <br/>
	   				  <br/>
	   				  
	      			  <span style="padding: 52px"></span><span>结束时间：</span>
	     		      <span><?php echo zen_draw_date_selector('enddate',mktime(date("H d m Y" ,time()))); ?></span>	  
				</li>
				<br/>
				
			</ol>
			<div><input style="padding:5px 60px;font-size:14px" size="200" type="submit" value="导出"></div>
			<div><p style="color:red;font-size:14px">*请上传好文件，选择好语言，选择好时间段，再点击导出按钮，左上角会有相关提示。</p></div>
		</form> 
		
</div>		
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
