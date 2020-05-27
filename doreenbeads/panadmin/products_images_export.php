<?php
require('includes/application_top.php');

$action = $_POST['action'];

switch ($action){
	case 'export_images':
		$file = $_FILES['products_mode'];
		$customers_email = $_POST['customers_email'];

		if($customers_email != ''){
			$check_email_query = $db->Execute('select customers_id from ' . TABLE_CUSTOMERS . ' where customers_email_address = "' . $customers_email . '"');
			if($check_email_query->RecordCount() > 0){
				if($file['error'] || empty($file)){
					$messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
					zen_redirect(zen_href_link('products_images_export'));
				}
			
				$filename = basename($file['name']);
				if(substr($filename, '-4') != 'xlsx' && substr($filename, '-3') != 'xls'){
					$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
					zen_redirect(zen_href_link('products_images_export'));
				}else{
					set_time_limit(0);
					
					unset($_SESSION['images_url']);
					$error = false;
					$error_info_array = array();
					$file_from = $file['tmp_name'];
					
					set_include_path('../Classes/');
					include 'PHPExcel.php';
					if(substr($filename, '-4') == 'xlsx'){
						include 'PHPExcel/Reader/Excel2007.php';
						$objReader = new PHPExcel_Reader_Excel2007;
					}else{
						include 'PHPExcel/Reader/Excel5.php';
						$objReader = new PHPExcel_Reader_Excel5;
					}
					$objPHPExcel = $objReader->load($file_from);
					$sheet = $objPHPExcel->getActiveSheet();
					
					for($j = 2; $j <= $sheet->getHighestRow (); $j ++) {
						$error = false;
						$products_model = strtoupper(trim ( $sheet->getCellByColumnAndRow ( 0, $j )->getValue () ));
						
						if ($products_model == '') {
							$error = true;
							$error_info_array[] = "第". $j ."行产品编号为空";
							continue;
						}
						
						$check_products_model_query = $db->Execute("SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_model = '". $products_model ."' ORDER BY products_id DESC LIMIT 1");
						if ($check_products_model_query->RecordCount() <= 0) {
							$error = true;
							$error_info_array[] = "第". $j ."行数据有误，商品编号【". $products_model ."】不存在";
							continue;
						}
						
						if (!$error) {
							$products_model_array[] = $products_model;
						}
					}
					
					if (sizeof($products_model_array) > 0) {
						$success_num = sizeof($products_model_array);
						$messageStack->add_session($success_num . ' 件商品导入成功','caution');
						
						$sql_data = array(
							'products_model' => implode(',', $products_model_array),
							'operator_email' => $_SESSION['admin_email'],
							'customers_email' => $customers_email,
							'export_datetime' => 'now()'
						);
						
						zen_db_perform(TABLE_NO_WATERMARK_PICTURE_EXPORT, $sql_data);
						
						$products_model_str = implode(',', $products_model_array);
						$url = HTTP_IMG_SERVER . 'lxy/export_products_images.php?action=export_images';
						$header = array();
						$data = 'models='.$products_model_str;
						
						$ret = curl_post($header, $data, $url);
						$result = json_decode($ret);
						
						if(!$result->is_error){
							$_SESSION['images_url'] = $result->images_url;
						}
					}
				}
			}else{
				$error_info_array[] = '该邮箱未在网站中注册过。';
			}
		}else{
			$error_info_array[] = '请填写客户邮箱。';
		}
		
		if(sizeof($error_info_array)>=1){
			foreach($error_info_array as $val){
				$messageStack->add_session($val,'error');
			}
		}
		
		
		
		zen_redirect(zen_href_link('products_images_export'));
		break;
}

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
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/javascript/ZeroClipboard.min.js"></script>
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
<script type="text/javascript">
$(function(){ 
	//复制文本到剪切板  
    if (window.clipboardData){
    	$(".copytoclipboard").click(function(){ 
			window.clipboardData.setData("Text",$('#products_images_url').val()); 
			alert('复制成功!');
		});
	}else{  
		if($(".copytoclipboard").size()>0)
		{
			 ZeroClipboard.config({swfPath: "includes/javascript/ZeroClipboard.swf"});
			 
			$(".copytoclipboard").each(function(){ 
			     var client = new ZeroClipboard($(this));
			     
				 client.on("ready", function(readyEvent){ 
				    client.on("beforecopy", function(event){
				    	
					});
					client.on("aftercopy", function(event){
						//复制成功后事件
						alert('复制成功!');
					});
				 }); 
			});
		}
	}
});
</script>
<style type="text/css">
.simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;
    height: 28px;
    }
#products_images_url{
 	width: 600px;
    height: 28px;
    background-color: darkgray;
    border: 1px;
}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div class="content" style="height:400px">
	<div class="title" style="height: 80px;font-size: 20px;font-weight: bold;margin-left: 40px;margin-top: 30px;color:#416041;">
		<span>商品无水印图片导出功能</span>
	</div>
	
	<div class="auth_form">
		<?php echo zen_draw_form('products_mode_file', 'products_images_export' , '' , 'post' , 'enctype="multipart/form-data"');?>
		<?php echo zen_draw_hidden_field('action' , 'export_images');?>
		<div style="margin-bottom: 15px; line-height: 30px;">
			<div style="display: inline;margin-left: 10%;font-weight: bold;margin-right: 18px;"><font>客户邮箱：</font></div>
			<div style="display: inline-block;margin-right:5px;" class="email_address"><?php echo zen_draw_input_field('customers_email' , '' ,'id="products_mode"')?></div>
		</div>
		<div style="margin-bottom: 15px; line-height: 30px;">
			<div style="display: inline;margin-left: 10%;font-weight: bold;margin-right: 40px;"><font>文件：</font></div>
			<div style="display: inline-block;margin-right:5px;" class="email_address"><?php echo zen_draw_file_field('products_mode' , '' ,'id="products_mode"')?></div>
			<div style="display: inline;margin-right: 20px;"><a href="./file/products_images_mode.xlsx">下载模板</a></div>
			<div style="display: inline;"><button class="simple_button">导入</button></div>
		</div>
		<?php echo '</form>';?>
		<div>
			<div style="display: inline;margin-left: 10%;font-weight: bold;"><font>生成的URL：</font></div>
			<div style="display: inline-block;"><?php echo zen_draw_input_field('products_images_url' , $_SESSION['images_url'] ? $_SESSION['images_url'] : '' ,'readonly="true" id="products_images_url"')?></div>
			<div style="display: inline;margin-left: 0.5%;"><input type="button" data-clipboard-target="products_images_url" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
		</div>
	</div>

</div>




<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>