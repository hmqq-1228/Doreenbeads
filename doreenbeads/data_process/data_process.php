<?php
chdir("../");
require_once("includes/application_top.php");
zen_redirect(zen_href_link(FILENAME_DEFAULT));
require("includes/access_ip_limit.php");
@ini_set('display_errors', '1');
set_time_limit(3600);
ini_set('memory_limit','512M');

$admin_name = zen_db_prepare_input($_POST['username']);
$admin_pass = zen_db_prepare_input($_POST['password']);
if(empty($_SESSION ['admin_id']) && (empty($admin_pass) || empty($admin_pass))) {
    die("<h1>请输入后台登录的账号和密码</h1><form action='data_process.php' method='post'>用户名：<input type='text' name='username' maxlength='64'><br/><br/>密&nbsp;&nbsp;&nbsp;码：<input type='password' name='password' maxlength='64'><br/><br/><input type='submit' value='submit'></form>");
}
if(!empty($_POST['username']) && !empty($_POST['password'])) {
	$admin_name = zen_db_prepare_input($_POST['username']);
    $admin_pass = zen_db_prepare_input($_POST['password']);
    $message = false;
    $sql = "select admin_id, admin_name, admin_email, admin_pass, admin_show_customer_email,latest_login_time from " . TABLE_ADMIN . " where admin_name = '" . zen_db_input($admin_name) . "'";
    $result = $db->Execute($sql);
    if (!($admin_name == $result->fields['admin_name'])) {
      $message = true;
      $pass_message = "<h1>账号不存在.</h1>";
    }
    if (!$message && !zen_validate_password($admin_pass, $result->fields['admin_pass'])) {
      $message = true;
      $pass_message = "<h1>密码错误.</h1>";
    }
    if ($message == false) {
      
      	$_SESSION['admin_id'] = $result->fields['admin_id'];
		$_SESSION['admin_email'] = $result->fields['admin_email'];
    }
    if($message) {
    	die($pass_message . "<h1><a href='data_process.php'>返回</a></h1>");
    }
}

$action = $_GET['action'];
switch($action){
	//	产品移动产品线
	case 'move_category':
		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a xlsx file!');
		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.xlsx';
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);
 		include 'Classes/PHPExcel.php';
  		include 'Classes/PHPExcel/Reader/Excel2007.php';
  		$objReader = new PHPExcel_Reader_Excel2007;
  		$objPHPExcel = $objReader->load($csvFile);
  		$sheet = $objPHPExcel->getActiveSheet();
		
		$cnt = 0;
		$categoryIds = $categoryPaths = array();
 		for($j=2; $j<=$sheet->getHighestRow(); $j++){
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$old_ccode = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$new_ccode = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());

			if(isset($categoryIds[$old_ccode])){
				$old_cid = zen_db_prepare_input($categoryIds[$old_ccode]);
			}else{
				$c_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$old_ccode."'");
				if($c_query->RecordCount()>0){
					$old_cid = $c_query->fields['categories_id'];
					$categoryIds[$old_ccode] = $c_query->fields['categories_id'];
				}else{
					echo $old_ccode." 不存在<br/>";
					continue;
				}
			}

			if(isset($categoryIds[$new_ccode])){
				$new_cid = zen_db_prepare_input($categoryIds[$new_ccode]);
			}else{
				$c_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$new_ccode."'");
				if($c_query->RecordCount()>0){
					$new_cid = $c_query->fields['categories_id'];
					$categoryIds[$new_ccode] = $c_query->fields['categories_id'];
				}else{
					echo $new_ccode." 不存在<br/>";
					continue;
				}
			}

			$cpid = array_reverse(getParent($new_cid, array()));
			$first = zen_db_prepare_input(isset($cpid[0]) ? $cpid[0] : 0);
			$second = zen_db_prepare_input(isset($cpid[1]) ? $cpid[1] : 0);
			$third = zen_db_prepare_input(isset($cpid[2]) ? $cpid[2] : 0);
//die($first.'a'.$second.'b'.$third.'c'.$new_cid.'d'.$old_cid);
 			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 			if($product_query->fields['products_id']>0 && $new_cid>0){ 				
 				$db->Execute("update ".TABLE_PRODUCTS." set master_categories_id=".(int)$new_cid." where products_id=".$product_query->fields['products_id']);					
 				$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id=".(int)$old_cid);
 				$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id=".(int)$new_cid);
 				remove_product_memcache($product_query->fields['products_id']);
 				if($check_exist->RecordCount()==0){
 					$p2c_data = array(
 						'products_id'=>$product_query->fields['products_id'],
 						'categories_id'=>(int)$new_cid,
 						'first_categories_id'=>(int)$first,
 						'second_categories_id'=>(int)$second,
 						'three_categories_id'=>(int)$third
 					);
 					zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data);
 					$cnt++;
 				}
 			}else{
				echo $model." 不存在<br/>";
				continue;
			}
 		}
		unlink($csvFile);
 		echo $cnt." success<br/>";
		exit();
		break;

	//	产品添加到产品线
	case 'add_category':
		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a xlsx file!');
		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.xlsx';
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);
 		include 'Classes/PHPExcel.php';
  		include 'Classes/PHPExcel/Reader/Excel2007.php';
  		$objReader = new PHPExcel_Reader_Excel2007;
  		$objPHPExcel = $objReader->load($csvFile);
  		$sheet = $objPHPExcel->getActiveSheet();
		
		$cnt = 0;
		$categoryIds = $categoryPaths = array();
 		for($j=2; $j<=$sheet->getHighestRow(); $j++){
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$new_cid= zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());

			$cpid = array_reverse(getParent($new_cid, array()));
			$first = zen_db_prepare_input(isset($cpid[0]) ? $cpid[0] : 0);
			$second = zen_db_prepare_input(isset($cpid[1]) ? $cpid[1] : 0);
			$third = zen_db_prepare_input(isset($cpid[2]) ? $cpid[2] : 0);
 			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 			if($product_query->fields['products_id']>0 && $new_cid>0){ 				
 				$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id=".(int)$new_cid);
 				remove_product_memcache($product_query->fields['products_id']);
 				if($check_exist->RecordCount()==0){
 					$p2c_data = array(
 						'products_id'=>$product_query->fields['products_id'],
 						'categories_id'=>(int)$new_cid,
 						'first_categories_id'=>(int)$first,
 						'second_categories_id'=>(int)$second,
 						'three_categories_id'=>(int)$third
 					);
 					zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data);
 					$cnt++;
 				}
 			}else{
				echo $model." 不存在<br/>";
				continue;
			}
 		}
		unlink($csvFile);
 		echo $cnt." success<br/>";
		exit();
		break;

// 	case 'set_dailydeal':
// 		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a csv file!');
// 		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.csv';
// 		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);

// 		$cnt=0;
// 		$n = 0;
// 		$fp = fopen($csvFile, 'r');
// 		while($data = fgetcsv($fp)){
// 			if($n++ == 0) continue;
// 			$model = trim($data[0]);
// 			$start_time = trim($data[1]);
// 			$end_time = trim($data[2]);
// 			$price = trim($data[3]);
// 			$group = trim($data[4]);
// 			$status = 10;
// 			if($model == '') continue;

// 			if(!$price){
// 				echo $model.' --- invalid price<br/>';
// 				continue;
// 			}
// 			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
// 			if($product_query->RecordCount()>0){
// 				$check_exist = $db->Execute("select dailydeal_promotion_id from ".TABLE_DAILYDEAL_PROMOTION." where products_id=".$product_query->fields['products_id']);
//  				if($check_exist->RecordCount()>0){
//  					$db->Execute("delete from ".TABLE_DAILYDEAL_PROMOTION." where products_id=".$product_query->fields['products_id']);
//  				}
// 				$daily_data = array(
// 					'products_id'=>$product_query->fields['products_id'],
//  					'dailydeal_products_start_date'=>$start_time,
//  					'dailydeal_products_end_date'=>	$end_time,
//  					'products_img'=>'dailydeal_promotion/products_image/'.$model.'.jpg',
//  					'dailydeal_is_forbid'=>$status, 	
//  					'group_id'=>$group,
//  					'dailydeal_price'=>round($price,2)
// 				);
//  				remove_product_memcache($product_query->fields['products_id']);
//  				zen_db_perform(TABLE_DAILYDEAL_PROMOTION, $daily_data);
// 				$cnt++;
// 			}else{
// 				echo $model.' --- 不存在<br/>';
// 			}
// 		}
// 		fclose($fp);
// 		unlink($csvFile);
//  		echo $cnt." success<br/>";
// 		exit();
// 		break;

	//	更新产品属性名
	case 'update_without':
		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a xlsx file!');
		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.xlsx';
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);
 		include 'Classes/PHPExcel.php';
  		include 'Classes/PHPExcel/Reader/Excel2007.php';
  		$objReader = new PHPExcel_Reader_Excel2007;
  		$objPHPExcel = $objReader->load($csvFile);
  		$sheet = $objPHPExcel->getActiveSheet();
		
		$cnt = 0;
 		for($j=3; $j<=$sheet->getHighestRow(); $j++){
 			$products_model = trim ( $sheet->getCellByColumnAndRow ( 1, $j )->getValue () );
			$products_without_desciption = trim ( $sheet->getCellByColumnAndRow ( 3, $j )->getValue () );

 			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$products_model."'");
 			if($product_query->fields['products_id']>0){ 				
 				if($products_without_desciption != '') {
					//是否存在这个tag
					$time = date('Y-m-d H:i:s');
					$result = $db->Execute('select tag_id from ' . TABLE_PRODUCTS_NAME_WITHOUT_CATG . ' where products_name_without_catg="' . zen_db_prepare_input(trim(addslashes($products_without_desciption))) . '"');
					$tag_id = 0;
					if($result->RecordCount() > 0) {
						$tag_id = $result->fields['tag_id'];
					} else {
						$sql_data_tag = array(
							'products_name_without_catg' => zen_db_prepare_input(trim($products_without_desciption)),
							'created' => $time,
						);
						zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG, $sql_data_tag);
						$tag_id = $db->insert_ID();
					}
					
					$db->Execute('update ' . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . ' set tag_id="' . $tag_id . '" where products_id="'.$product_query->fields['products_id'].'"');
					$cnt++;
				}
 			}else{
				echo $products_model." 不存在<br/>";
				continue;
			}
 		}
		unlink($csvFile);
 		echo $cnt." success<br/>";
		exit();
		break;
		
	//	更新产品价格、净重、体积重
	/*case 'update_price_weight':
		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a xlsx file!');
		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.xlsx';
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);
 		include 'Classes/PHPExcel.php';
  		include 'Classes/PHPExcel/Reader/Excel2007.php';
  		$objReader = new PHPExcel_Reader_Excel2007;
  		$objPHPExcel = $objReader->load($csvFile);
  		$sheet = $objPHPExcel->getActiveSheet();
		
		$cnt = 0;
 		for($j=4; $j<=$sheet->getHighestRow(); $j++){
 			$products_model = trim ( $sheet->getCellByColumnAndRow ( 1, $j )->getValue () );
			$products_price = floatval(trim ( $sheet->getCellByColumnAndRow ( 2, $j )->getValue () ));
			$products_weight = floatval(trim ( $sheet->getCellByColumnAndRow ( 5, $j )->getValue () ));
			$products_volume_weight = floatval(trim ( $sheet->getCellByColumnAndRow ( 6, $j )->getValue () ));
			$price_level = trim ( $sheet->getCellByColumnAndRow ( 4, $j )->getValue () );
			if(empty($products_model)) {
				continue;
			}

 			$product_query = $db->Execute("select products_id, products_price from ".TABLE_PRODUCTS." where products_model='".$products_model."'");
 			if($product_query->fields['products_id']>0){ 				
 				if($products_price != '') {
 					if($product_query->fields['products_price'] != $products_price) {
 						$operationLog = "商品 products_price 变更: from " . $product_query->fields['products_price'] . " to " . $products_price . " in " . __FILE__ . " on line: " . __LINE__;
						zen_insert_operate_logs($_SESSION ['admin_id'], $products_model, $operationLog, 2);
 					}					
					$db->Execute('update ' . TABLE_PRODUCTS . ' set products_price=' . $products_price . ', products_weight=' . $products_weight . ', products_volume_weight="' . $products_volume_weight . '" where products_id="'.$product_query->fields['products_id'].'"');
					//$db->Execute('update ' . TABLE_PRODUCTS . ' set products_weight=' . $products_weight . ', products_volume_weight="' . $products_volume_weight . '" where products_id="'.$product_query->fields['products_id'].'"');
					zen_refresh_products_price ( $product_query->fields['products_id'], $products_price, $products_weight, $price_level );
					remove_product_memcache($product_query->fields['products_id']);
					$cnt++;
				}
				
				//更新上货价表
				$chengben_data_array = array();
				$chengben_query = $db->Execute('select chengben_id from ' . TABLE_PRODUCTS_SHANGHUOJIA .' where chengben_id = ' . $product_query->fields['products_id'] .' limit 1');
				if($chengben_query->RecordCount() > 0){
					$chengben_data_array = array(
							'price' => $products_price,
							'date_modified' => date('Y-m-d H:i:s')
					);
					$condition_where_clause = 'chengben_id = :chengben_id';
					$delivery_where_clause = $db->bindVars($condition_where_clause, ':chengben_id', $product_query->fields['products_id'], 'integer');
					zen_db_perform(TABLE_PRODUCTS_SHANGHUOJIA,$chengben_data_array,'update',$delivery_where_clause);
				}else{
					$chengben_data_array = array(
							'chengben_id' => $product_query->fields['products_id'],
							'price' => $products_price,
							'date_created' => date('Y-m-d H:i:s'),
							'date_modified' => date('Y-m-d H:i:s')
					);
					zen_db_perform(TABLE_PRODUCTS_SHANGHUOJIA,$chengben_data_array);
				}
				
 			}else{
				echo $products_model." 不存在<br/>";
				continue;
			}
 		}
		unlink($csvFile);
 		echo $cnt." success<br/>";
		exit();
		break;*/

	//	绑定产品到账号并下货
	case 'my_products':
		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a csv file!');
		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.csv';
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);

		$cnt=0;
		$fp = fopen($csvFile, 'r');
		$customer_query = $db->Execute('select customers_id from '.TABLE_CUSTOMERS.' where customers_email_address="fenghuan.chen@panduo.com.cn"');
		$cid = intval($customer_query->fields['customers_id']);
		while($data = fgetcsv($fp)){
			$model = trim($data[0]);
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 			if($product_query->fields['products_id']>0){ 	
				$coupon_data_array = array(
					'products_id'=>intval($product_query->fields['products_id']),
					'customers_id'=>$cid
				);
				zen_db_perform('t_my_products', $coupon_data_array);
				$db->Execute("update ".TABLE_PRODUCTS." set products_status = 0  where products_id='".$product_query->fields['products_id']."'");
				remove_product_memcache($product_query->fields['products_id']);
				$cnt++;
			}else{
				echo $model.' --- 不存在<br/>';
			}
		}
		fclose($fp);
		unlink($csvFile);
		echo $cnt." success<br/>";
		exit();
		break;
		
	//	更新产品图片数量
	/*case 'update_image_number':
		$models = trim($_POST['models']);
		if(!empty($models)) {
			$cnt=0;
			$modelsArray = explode(",", $models);
			if(count($modelsArray) > 20) {
				echo '货号不能超过20个!';
				exit;
			}
			foreach($modelsArray as $value) {
				$value = trim($value);
				$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$value."' and products_status!=10");
				if($product_query->fields['products_id']>0){
					$image_count = intval(file_get_contents(HTTP_IMG_SERVER . 'count_product_img.php?model='.$value));
					if($image_count > 0) {
						$product_image_count = $db->Execute("select image_total from ".TABLE_PRODUCTS_IMAGE_COUNT." where products_id='".$product_query->fields['products_id']."'");
						if($product_image_count->RecordCount() > 0) {
							if($product_image_count->fields['image_total'] != $image_count) {
								$db->Execute("update ".TABLE_PRODUCTS_IMAGE_COUNT." set image_total=" . $image_count . ", last_modify_time=now() where products_id=".$product_query->fields['products_id']);
								$operationLog = "商品图片数量 变更: from " . $product_image_count->fields['image_total'] . " to " . $image_count . "";
								zen_insert_operate_logs($_SESSION ['admin_id'], $value, $operationLog, 2);
								remove_product_memcache($product_query->fields['products_id']);
								$cnt++;
							} else {
								echo $value.' ---无更新<br/>';
							}
						} else {
							$sql_data_array = array(
								'products_id' => $product_query->fields['products_id'],
								'image_total' => $image_count,
								'last_modify_time' => 'now()'
							);
							zen_db_perform(TABLE_PRODUCTS_IMAGE_COUNT, $sql_data_array);
							$operationLog = "商品图片数量 变更: from 0 to " . $image_count . "";
							zen_insert_operate_logs($_SESSION ['admin_id'], $value, $operationLog, 2);
							$cnt++;
						}
					}	
					
				}else{
					echo $value.' --- 不存在<br/>';
				}
			}
			echo $cnt." success<br/>";
		}
		exit;
		break;*/

	//	清除memcache
	case 'clear_memcache':
		if(! isset($_FILES['csvFile']) || ! $_FILES['csvFile']) die('please upload a csv file!');
		$csvFile = 'data_process/tmp/'.date("YmdHis").rand().'.csv';
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $csvFile);

		$cnt=0;
		$fp = fopen($csvFile, 'r');
		while($data = fgetcsv($fp)){
			$model = trim($data[0]);
			if($model == '') continue;

			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
			if($product_query->fields['products_id']>0){
				remove_product_memcache($product_query->fields['products_id']);				
				$cnt++;
			}else{
				echo $model.' --- 不存在<br/>';
			}
		}
		fclose($fp);
		unlink($csvFile);
		echo $cnt." success<br/>";
		exit();
		break;
		
	//	踢除一口价促销区
// 	case 'clear_dailydeal':
// 		$models = trim($_POST['models']);
// 		if(!empty($models)) {
// 			$cnt=0;
// 			$modelsArray = explode(",", $models);
// 			foreach($modelsArray as $value) {
// 				$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$value."'");
// 				if($product_query->fields['products_id']>0){
// 					$db->Execute("delete from ".TABLE_DAILYDEAL_PROMOTION." where products_id=".$product_query->fields['products_id']);
// 					remove_product_memcache($product_query->fields['products_id']);				
// 					$cnt++;
// 				}else{
// 					echo $model.' --- 不存在<br/>';
// 				}
// 			}
// 			echo $cnt." success<br/>";
// 		}
// 		exit;
// 		break;

	default:
		break;
}

function getParent($cid, $arr){
	global $db;

	if(! $cid) return $arr;

	$c = $db->Execute("select categories_id,parent_id from ".TABLE_CATEGORIES." where categories_id = ".$cid);
	while(!$c->EOF){
		$arr[] = $c->fields['categories_id'];
		return getParent($c->fields['parent_id'], $arr);
	}
	return $arr;
}

?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>日常数据处理系统</title>
	<script language="JavaScript" src="jquery-1.9.1.js"></script>
	<script language="JavaScript" src="jquery.form.js"></script>
	<script type="text/javascript" language="JavaScript">
	$(function() {
		$(".cForm").submit(function(){
			var jqForm = $(this);
			jqForm.ajaxSubmit({
				beforeSubmit:function(){jqForm.find(".show_res").html('<img src="loading.gif" />');jqForm.find('.submitbtn').attr('disabled', true)},
				success:function(result){
					jqForm.find(".show_res").html(result);
					jqForm.find('.submitbtn').attr('disabled', false);
				}
			});
			return false;
		});
	});
	</script>
	<style>
		td{padding:8px}
	</style>
</head>

<body>

<center>

<form class="cForm" name="form1" action="data_process.php?action=move_category" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>产品移动产品线</legend>
	<table border="0" width="100%">
		<tr><td align="right">Excel File: </td><td><input type="file" name="csvFile" /> <a href="template_move_category.xlsx" target="_blank">模板文件</a></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<form class="cForm" name="form1" action="data_process.php?action=add_category" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>产品添加到产品线</legend>
	<table border="0" width="100%">
		<tr><td align="right">Excel File: </td><td><input type="file" name="csvFile" /> <a href="template_add_category.xlsx" target="_blank">模板文件</a></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<form class="cForm" name="form1" action="data_process.php?action=set_dailydeal" enctype="multipart/form-data" method="post" style="display:none; background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>上DailyDeal产品</legend>
	<table border="0" width="100%">
		<tr><td align="right">CSV File: </td><td><input type="file" name="csvFile" /> <a href="template_set_dailydeal.csv" target="_blank">模板文件</a></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<form class="cForm" name="form1" action="data_process.php?action=update_without" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>更新产品属性名</legend>
	<table border="0" width="100%">
		<tr><td align="right">Excel File: </td><td><input type="file" name="csvFile" /> 模板文件同新品上货excel</td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<!-- <form class="cForm" name="form1" action="data_process.php?action=update_price_weight" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>更新产品价格、净重、体积重</legend>
	<table border="0" width="100%">
		<tr><td align="right">Excel File: </td><td><input type="file" name="csvFile" /> 模板文件同新品上货excel</td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form> -->

<form class="cForm" name="form1" action="data_process.php?action=my_products" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>绑定产品到账号并下货</legend>
	<table border="0" width="100%">
		<tr><td align="right">Excel File: </td><td><input type="file" name="csvFile" /> <a href="template_my_products.csv" target="_blank">模板文件</a></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div>绑定到fenghuan.chen@panduo.com.cn下</div></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<form class="cForm" name="form1" action="data_process.php?action=clear_memcache" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>清除memcache</legend>
	<table border="0" width="100%">
		<tr><td align="right">Excel File: </td><td><input type="file" name="csvFile" /> <a href="template_clear_memcache.csv" target="_blank">模板文件</a></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<!-- <form class="cForm" name="form1" action="http://img.doreenbeads.com/upload_img.php?action=update_image_from_data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>更新产品图片</legend>
	<table border="0" width="100%">
		<tr><td align="right">产品编号: </td><td><textarea name="models" cols="40" rows="5"></textarea></td></tr>
		<tr><td colspan="2" align="center"><div>以英文逗号隔开, 如: B00001,B00002,B00003</div></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form>

<form class="cForm" name="form1" action="data_process.php?action=update_image_number" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<fieldset>
	<legend>更新产品图片<font color="red">数量</font></legend>
	<table border="0" width="100%">
		<tr><td align="right">产品编号: </td><td><textarea name="models" cols="40" rows="5"></textarea></td></tr>
		<tr><td colspan="2" align="center"><div>以英文逗号隔开, 如: B00001,B00002,B00003</div></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" class="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div class="show_res"></div></td></tr>
	</table>
	</fieldset>
</form> -->


</center>

</body>

</html>

