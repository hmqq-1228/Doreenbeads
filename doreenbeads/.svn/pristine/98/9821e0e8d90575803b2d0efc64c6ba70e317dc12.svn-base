<?php 
require('includes/application_top.php');
require(DIR_WS_CLASSES . 'language.php');
$action =  isset($_GET['action']) ? $_GET['action'] : '';

switch ($action){
	case 'delete':
		//$pid = $_POST['pID'];
		$file = $_FILES['promotion_products_file'];
		$type = $_POST['type'];
		
		if($file['error']||empty($file)){
			$messageStack->add_session('Fail: 请上传文件！','error');
			zen_redirect(zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS));
		}
		$filename = basename($file['name']);
		$file_ext = substr($filename, strrpos($filename, '.') + 1);
		if($file_ext!='xlsx'&&$file_ext!='xls'){
			$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
			zen_redirect(zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS));
		}else{
			set_time_limit(0);
			$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');
			
			$error_info_array=array();
			$file_from=$file['tmp_name'];
			$update_all=false;
			$success_num = 0;
			set_include_path('../Classes/');
			include 'PHPExcel.php';
			if($file_ext=='xlsx'){
				include 'PHPExcel/Reader/Excel2007.php';
				$objReader = new PHPExcel_Reader_Excel2007;
			}else{
				include 'PHPExcel/Reader/Excel5.php';
				$objReader = new PHPExcel_Reader_Excel5;
			}
			$objPHPExcel = $objReader->load($file_from);
			$sheet = $objPHPExcel->getActiveSheet();
			
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$an = $sheet->getCellByColumnAndRow(0,$j)->getValue();
				$bn = $sheet->getCellByColumnAndRow(1,$j)->getValue();
				
				if(trim($an)==''){
					$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不能为空。';
				}else{
					$products_model_query = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = '" . zen_db_input($an) ."' and products_status = 1");
					
					if($products_model_query->RecordCount() > 0){
						$products_id = $products_model_query->fields['products_id'];
							
						if($type == 'promotion_delete'){
							$check_products_sql = 'SELECT pp_id , zpp.pp_promotion_start_time , zpp.pp_promotion_end_time  from ' . TABLE_PROMOTION_PRODUCTS . ' zpp , ' . TABLE_PROMOTION . ' zp  where pp_products_id = ' . $products_id . ' and pp_promotion_id = ' . zen_db_input($bn) . ' and promotion_id = ' . zen_db_input($bn) . ' and zpp.pp_is_forbid = 10';
							$check_products_result = $db->Execute($check_products_sql);
							
							if($check_products_result->RecordCount() > 0 ){
								$current_time = date('Y-m-d H:i:s');
								
								if($current_time < $check_products_result->fields['pp_promotion_start_time']){
									$db->Execute('delete from ' . TABLE_PROMOTION_PRODUCTS . ' where pp_products_id = ' . $products_id . ' and pp_promotion_id = ' . zen_db_input($bn) . '  and pp_is_forbid = 10');
								}else{
									$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 , pp_forbid_admin = "' . zen_db_input($_SESSION['admin_email']) . '" , pp_forbid_time = "' . $current_time . '" where pp_products_id = ' . $products_id . ' and pp_promotion_id = ' . zen_db_input($bn) . '  and pp_is_forbid = 10');
								}
								remove_product_memcache($products_id);
								$success_num++;
							}else{
								$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，在ID ' . $bn . '区中商品' . $an . '不存在。';
							}
						
						}else{
							$check_products_sql = 'SELECT dailydeal_products_start_date , dailydeal_products_end_date from ' . TABLE_DAILYDEAL_PROMOTION . ' where products_id = ' . $products_id . ' and dailydeal_products_start_date = "' . zen_db_input($bn) . '"' ;
							$check_products_result = $db->Execute($check_products_sql);
							
							if($check_products_result->RecordCount() > 0 ){
								$current_time = date('Y-m-d H:i:s');
							
								if($current_time < $check_products_result->fields['dailydeal_products_start_date']){
									$db->Execute('delete from ' . TABLE_DAILYDEAL_PROMOTION . ' where products_id = ' . $products_id . ' and dailydeal_products_start_date = "' . zen_db_input($bn) . '"');
								}else{
									$db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 , dailydeal_forbid_admin = "' . zen_db_input($_SESSION['admin_email']) . '" , dailydeal_forbid_time = "' . $current_time . '" where products_id = ' . $products_id . ' and dailydeal_products_start_date = "' . zen_db_input($bn) . '"') ;
								}
								remove_product_memcache($products_id);
								$success_num++;
							}else{
								$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，在指定的开始时间下商品' . $an . '不存在。';
							}
						}
					}else{
						$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不存在。';
					}
					
				}
			}
		}
		
		if(sizeof($error_info_array)>=1){
			$messageStack->add_session($success_num . ' 个商品删除成功','caution');
			foreach($error_info_array as $val){
				$messageStack->add_session($val,'error');
			}
			zen_redirect(zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS));
		}else{
			$messageStack->add_session('所有商品删除成功','success');
			zen_redirect(zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS));
		}
		exit;
		break;
	
}


$common_arr = array(array('id' => 0 , 'text' => '请选择...'));
$sql_query_promotion_deals = "select promotion_area_id,promotion_area_name,  related_promotion_ids from " . TABLE_PROMOTION_AREA . " where promotion_area_status = 1  order by promotion_area_id desc ";
$sql_query_promotion_deals_result = $db->Execute($sql_query_promotion_deals);
	
$querypromotion_deals_array = array();
	
if($sql_query_promotion_deals_result->RecordCount() >0){
	while(!$sql_query_promotion_deals_result->EOF){
		$querypromotion_deals_array[] = array(
				'id' => $sql_query_promotion_deals_result->fields['promotion_area_id'],
				'text' => '[ID:' . $sql_query_promotion_deals_result->fields['promotion_area_id'].']  ' . $sql_query_promotion_deals_result->fields['promotion_area_name']
		);
			
		$sql_query_promotion_deals_result->MoveNext();
	}
}
$querypromotion_deals_array = array_merge($common_arr , $querypromotion_deals_array);

$sql_query_dailydeal_deals_sql = "select `dailydeal_area_id`, `area_name`, `start_date`, `end_date`, `expire_interval`, `area_status` from " . TABLE_DAILYDEAL_AREA . " where area_status = 1 and `end_date` >=now() order by dailydeal_area_id desc ";
$sql_query_dailydeal_deals_result = $db->Execute($sql_query_dailydeal_deals_sql);
	
$sql_query_dailydeal_deals_array = array();
if($sql_query_dailydeal_deals_result->RecordCount() >0)
{
	while(!$sql_query_dailydeal_deals_result->EOF){
		$sql_query_dailydeal_deals_array[] = array(
				'id' => $sql_query_dailydeal_deals_result->fields['dailydeal_area_id'],
				'text' => '[ID:' . $sql_query_dailydeal_deals_result->fields['dailydeal_area_id'].']  ' . $sql_query_dailydeal_deals_result->fields['area_name']
		);
			
		$sql_query_dailydeal_deals_result->MoveNext();
	}
}
$sql_query_dailydeal_deals_array = array_merge($common_arr , $sql_query_dailydeal_deals_array);

?>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>移除促销产品</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script> 
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
	
	function check_form(form){
		//var id = form.pID.value;
		var file = form.promotion_products_file.value;
		var $form = $(form);
		var error = false;

		$form.find(".prompt").html("");
		
// 		if(id == 0 || id == null || id == ''){
// 			$form.find(".prompt").html("请选择区号！");
// 			error = true;
// 		}else 
		if(file == '' || file == null){
			$form.find(".prompt").html("请选择文件！");
			error = true;
		}else{
			error = false;
		}
		
		return !error;
	}
</script>
<style type="text/css">
.area_title{
    height: auto;
}
.area_title span{
	font-size: 20px;
    font-weight: bold;
    margin: 30px 50px 20px;
    display: block;
    width: 250px;
}
.form_area{
    margin-left: 70px;
    font-size: 14px;
}
.form_item{
    margin-bottom: 10px;
}
</style>
</head>

<body onLoad="init()">
	<div id="spiffycalendar" class="text"></div>
	<?php 
		require(DIR_WS_INCLUDES . 'header.php'); 
	?>
	<form name="delete_form" enctype="multipart/form-data" onsubmit="return check_form(this , 'promotion')" action="<?php echo zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS,'action=delete')?>" method="post">
		<div id="promotion_area">
			<div class="area_title"><span>移除促销产品</span></div>
			<div class="form_area">
				<!-- <div class="form_item"><span>1、选择促销区：</span><span><?php echo zen_draw_pull_down_menu('pID' , $querypromotion_deals_array ,  '' , 'style="width:100px;height:20px;" ')?></span></div> -->
				<div class="form_item"><span>移除商品：</span><span><?php echo zen_draw_file_field('promotion_products_file')?></span></div>
				<div class="form_item"><span><?php echo zen_draw_hidden_field('type' , 'promotion_delete')?></span><span><a href="file/remove_promotion_products_template.xls">下载模板</a></span></div>
				<div class="form_item" style="display:inline-block;"><input type="submit" name="upload" value="" style="CURSOR: pointer; background: url('images/button_upload_cn.png') no-repeat; width:107px;height:30px;border:0px;" /></div>
				<span class="prompt" style="color: red;"></span>
			</div>
		</div>
	</form>
	<hr style="color:black;">
	
	<form name="delete_form" enctype="multipart/form-data" onsubmit="return check_form(this , 'deals')" action="<?php echo zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS,'action=delete')?>" method="post">
		<div id="promotion_area">
			<div class="area_title"><span>移除一口价DEALS产品</span></div>
			<div class="form_area">
				<!-- <div class="form_item"><span>1、选择一口价DEALS区：</span><span><?php echo zen_draw_pull_down_menu('pID' , $sql_query_dailydeal_deals_array , '' , 'style="width:100px;height:20px;" ')?></span></div> -->
				<div class="form_item"><span>移除商品：</span><span><?php echo zen_draw_file_field('promotion_products_file')?></span></div>
				<div class="form_item"><span><?php echo zen_draw_hidden_field('type' , 'deals_delete')?></span><span><a href="file/remove_deals_products_template.xls">下载模板</a></span></div>
				<div class="form_item" style="display:inline-block;"><input type="submit" name="upload" value="" style="CURSOR: pointer; background: url('images/button_upload_cn.png') no-repeat; width:107px;height:30px;border:0px;" /></div>
				<span class="prompt" style="color: red;"></span>
			</div>
		</div>
	</form>
</body>
</html>