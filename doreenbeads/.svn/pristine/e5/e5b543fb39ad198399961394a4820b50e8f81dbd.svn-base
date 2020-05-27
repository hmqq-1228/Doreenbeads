<?php 

chdir("../");
	require_once("includes/application_top.php");
	//require("includes/access_ip_limit.php");
	@ini_set('display_errors', '1');	
	//error_reporting(E_ALL);
	set_time_limit(7200);
	ini_set('memory_limit','512M');
	global $db;
	
	
	if(!isset($_GET['fpath'])|| $_GET['fpath']=='') die('require param fpath');
	
	$exc_file = $_GET['fpath'];
	if(!file_exists($exc_file)) die("can not find file $exc_file");
	$filename = basename($exc_file);
  	$file_ext = substr($filename, strrpos($filename, '.') + 1);
 				
  	include 'Classes/PHPExcel.php';
  	if($file_ext=='xlsx'){		
  		include 'Classes/PHPExcel/Reader/Excel2007.php';
  		$objReader = new PHPExcel_Reader_Excel2007;
  	}else{
  		include 'Classes/PHPExcel/Reader/Excel5.php';
  		$objReader = new PHPExcel_Reader_Excel5;
  	}
  	$count = 0;
  	$name_list = array();
  	$objPHPExcel = $objReader->load($exc_file);
  	$sheet = $objPHPExcel->getActiveSheet();

switch($_GET['action']){
	case 'upload_products_data':
		$cnt=0;
		$error_array = array ();
		$category_array = array ();
		$category_path_array = array ();
		$all_cate_array = array ();
		$all_cate_array = zen_get_all_cate_array_new ();
		for($j = 4; $j <= $sheet->getHighestRow (); $j ++) {
			$update_data = true;
			$products_name=array();
			
			$category_code = trim ( $sheet->getCellByColumnAndRow ( 0, $j )->getValue () );
			$category_code = str_replace("'", "", $category_code);
			$products_model = trim ( $sheet->getCellByColumnAndRow ( 1, $j )->getValue () );
			$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$products_model."'");
			if($check_exist->RecordCount()>0){
				echo $products_model.' exist <br/>';
				continue;
			}
//			echo $products_model.'<br/>';
			
			$products_price = trim ( $sheet->getCellByColumnAndRow ( 2, $j )->getValue () );
			$products_without_desciption = trim ( $sheet->getCellByColumnAndRow ( 3, $j )->getValue () );
			$price_level = trim ( $sheet->getCellByColumnAndRow ( 4, $j )->getValue () );
			$products_weight = trim ( $sheet->getCellByColumnAndRow ( 5, $j )->getValue () );
			$products_weight_volume = zen_db_prepare_input ( trim ( $sheet->getCellByColumnAndRow ( 6, $j )->getValue () ) );
			$products_property = trim ( $sheet->getCellByColumnAndRow ( 7, $j )->getValue () );
			$products_name[1] = trim ( $sheet->getCellByColumnAndRow ( 8, $j )->getValue () );
			$products_name[2] = trim ( $sheet->getCellByColumnAndRow ( 10, $j )->getValue () );
			$products_name[3] = trim ( $sheet->getCellByColumnAndRow ( 12, $j )->getValue () );
			$products_name[4] = trim ( $sheet->getCellByColumnAndRow ( 14, $j )->getValue () );
			$products_name[5] = trim ( $sheet->getCellByColumnAndRow ( 16, $j )->getValue () );
			$limit_stock = trim ( $sheet->getCellByColumnAndRow ( 22, $j )->getValue () );
			$products_quantity = trim ( $sheet->getCellByColumnAndRow ( 23, $j )->getValue () );
			$per_pack_qty = trim ( $sheet->getCellByColumnAndRow ( 24, $j )->getValue () );
			$unit_code = str_replace("'", "", trim ( $sheet->getCellByColumnAndRow ( 25, $j )->getValue () ));
				
			if ($category_code == '') {
				$update_data = false;
				$error_array [] = '第' . $j . '行 ，产品线号为空' . "\n";
			} else {
				if (! isset ( $category_array [$category_code] )) {
					$getCidQuery = $db->Execute ( 'select categories_id,categories_status from ' . TABLE_CATEGORIES . ' where categories_code="' . $category_code . '" limit 1' );
					if ($getCidQuery->RecordCount () > 0) {
						if ($getCidQuery->fields ['categories_status'] == 1) {
							$category_array [$category_code] = $getCidQuery->fields ['categories_id'];
							$category_path_array [$category_code] = zen_get_products_to_categories_path_new ( $getCidQuery->fields ['categories_id'] );
						} else {
							$category_array [$category_code] = - 1;
							$category_path_array [$category_code] = '';
						}
					} else {
						$category_array [$category_code] = 0;
						$category_path_array [$category_code] = '';
					}
				}
		
				$cid = $category_array [$category_code];
				
				$category_path = $category_path_array [$category_code];
				if ($cid == 0) {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，产品线号不存在' . "\n";
				} elseif ($cid == - 1) {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，产品线号状态有问题' . "\n";
				}
			}
				
			$image_name = $products_model;
			if(substr($products_model, -1)=='S' || substr($products_model, -1)=='H'){
				$image_name  = substr($products_model, 0, -1);
			}
			if( substr($products_model, 0, 1) == 'B'){
				$products_image = ((int)substr($products_model, 1, 2) + 1) . '/' . $image_name . '.JPG';
			}else{
				$products_image = substr($products_model, 0, 3) . '/' . $image_name . '.JPG';
			}
		
			if ($update_data) {
				$products_sql = 'select products_id from  ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '"  limit 1';
				$products = $db->Execute ( $products_sql );
				if ($products->RecordCount () > 0) {
					
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，产品编号已存在' . "\n";
				}
			}
				
			if ($update_data) {
				if (! $products_price || $products_price < 0.1) {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，上货价格有问题' . "\n";
				} else {
					//$products_price = $products_price * 1.04;
				}
			}
				
			if ($update_data) {
				if (! $price_level) {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，价格梯段有问题' . "\n";
				}
			}
				
			if ($update_data) {
				if (! $products_weight) {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，产品重量有问题' . "\n";
				}
			}
				
			if ($update_data) {
				if ($products_property == '') {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，产品属性值为空' . "\n";
				} else {
					$products_property_array = explode ( ';', $products_property );
					foreach ( $products_property_array as $key => $val ) {
						$products_property_array [$key] = "'" . $val . "'";
					}
					$products_property_str = implode ( ',', $products_property_array );
					$get_all_pro = $db->Execute ( "select property_id,property_group_id from t_property where property_code in (" . $products_property_str . ") " );
					if ($get_all_pro->RecordCount () > 0) {
					} else {
						$update_data = false;
						$error_array [] = '第' . $j . '行 ，产品属性值均不存在' . "\n";
					}
				}
			}
				
			if ($update_data) {
				if ($products_name[1]=='') {
					$update_data = false;
					$error_array [] = '第' . $j . '行 ，英语产品名字为空' . "\n";
				}
			}
								
				
			if ($update_data) {
				if ($limit_stock == 1) {
					$products_quantity = $products_quantity;
				} else {
					$limit_stock = 0;
					$products_quantity = '50000';
				}
								
				$sql_data_array = array (
						
						'products_model' => $products_model,
						'products_price' => $products_price,
						'products_weight' => $products_weight,
						'products_volume_weight' => $products_weight_volume,
						'products_status' => 1,
						'products_quantity_order_min' => 1,
						'products_limit_stock' => $limit_stock,
						'products_quantity_mixed' => 1,
						'products_discount_type' => 1,
						'products_discount_type_from' => 1,
						'products_sort_order' => 1000,
						'product_price_times' => $price_level,
						'products_price_sorter' => $products_price,
						'products_date_added' => date ( 'Y-m-d H:i:s' ),
						'master_categories_id' => $cid,
						'products_image' => $products_image,
						'price_manager_id' => 42
				);
				
				zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
				$products_id=$db->insert_ID();
				$sql_data_array_products_stock = array(
						'products_id'		=> $products_id,
						'products_quantity' => $products_quantity,
						'create_time'		=> strtotime(date('Y-m-d H:i:s')),
						'modify_time'		=> strtotime(date('now'))
				);
				zen_db_perform(TABLE_PRODUCTS_STOCK,$sql_data_array_products_stock);
			
		
				$ptc_insert_sql = "insert into " . TABLE_PRODUCTS_TO_CATEGORIES . "
							(products_id, categories_id,
							first_categories_id,second_categories_id,
		
								three_categories_id,four_categories_id,
							five_categories_id,six_categories_id)
							values ('" . $products_id . "', '" . $cid . "'," . $category_path . ")";
				
				$db->Execute($ptc_insert_sql);
				zen_refresh_products_price_new ( $products_id, $products_price, $products_weight, $price_level );
				while(!$get_all_pro->EOF){
					$property_insert_sql='insert into  t_products_to_property (product_id,property_id,property_group_id) values ('.$products_id.','.$get_all_pro->fields['property_id'].','.$get_all_pro->fields['property_group_id'].') ';
					
					$db->Execute($property_insert_sql);
					$get_all_pro->MoveNext();
				}
		
				$unit_id = $db->Execute("select unit_id from ".TABLE_PRODUCTS_UNIT." where unit_code='".$unit_code."'");
				$unit_data_array = array(
						'products_id'=>$products_id,
						'products_unit_id'=>(int)$unit_id->fields['unit_id'],
						'unit_number'=>(int)$per_pack_qty
				);
				zen_db_perform('t_products_to_unit', $unit_data_array);
		
				for($lang=1;$lang<=4;$lang++){
					switch($lang){
						case 1:
							$lang_code='EN';
							break;
						case 2:
							$lang_code='DE';
							break;
						case 3:
							$lang_code='RU';
							break;
						case 4:
							$lang_code='FR';
						
							break;
					}
					$products_name_str=$products_name[$lang];
					if($products_name_str==''){
						$products_name_str=$products_name[1];
					}
										
					$sql_data_array_description = array('products_id'=>$products_id,
							'products_name' => zen_db_prepare_input($products_name_str),
		
							'language_id' => $lang,
							'products_name_without_catg' => '');
					zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array_description);
					
					if($lang == 1 && $products_without_desciption != ''){
						if(stristr($products_without_desciption,"'")){
							$result = $db->Execute('select tag_id from ' . TABLE_PRODUCTS_NAME_WITHOUT_CATG . ' where products_name_without_catg = "' .zen_db_prepare_input($products_without_desciption) . '"');
						}else{
							$result = $db->Execute("select tag_id from " . TABLE_PRODUCTS_NAME_WITHOUT_CATG . " where products_name_without_catg = '" .zen_db_prepare_input($products_without_desciption) . "'");
								
						}
						$tag_id = 0;
						if($result->RecordCount() > 0) {
							$tag_id = $result->fields['tag_id'];
						}else{
							$sql_data_array_catg = array(
									'products_name_without_catg' => zen_db_prepare_input($products_without_desciption),
									'created'					 => date('Y-m-d H:i:s'),
									'modified'					 => date('Y-m-d H:i:s')
							);
							zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG, $sql_data_array_catg);
							$tag_id = $db->insert_ID();
						}
						$sql_data_relation = array(
								'tag_id' => $tag_id,
								'products_id' => $products_id,
								'created' => date('Y-m-d H:i:s')
						);
						zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION, $sql_data_relation);
					}
					
					
				}
				$cnt++;
			}
			
		}
		foreach($error_array as $error_a){
			echo $error_a.'<br/>';
		}
		
		echo $cnt;
		break;
	case 'upload_product_desc':
		$cnt=0;
		$folder= 'products/description/';
		$date_str = $_GET['date'];
		if(!$date_str){
			die('need date str');
		}
		
		for($j=4;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$pid_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
			if($model=='' || $pid_query->RecordCount()==0){
				continue;
			}
			$check_exist = $db->Execute("select language_id from ".TABLE_PRODUCTS_INFO." where products_id=".$pid_query->fields['products_id']);
			if($check_exist->RecordCount()>0){
				continue;
			}
			$products_description_en =  file_get_contents($folder.$date_str.'-EN/'.trim($model).'.txt');
			$products_description_de =  file_get_contents($folder.$date_str.'-DE/'.trim($model).'.txt');
			$products_description_ru =  file_get_contents($folder.$date_str.'-RU/'.trim($model).'.txt');
			$products_description_fr =  file_get_contents($folder.$date_str.'-FR/'.trim($model).'.txt');
			
			if($products_description_de == ''){
				$products_description_de = $products_description_en;
			}
			if($products_description_ru == ''){
				$products_description_ru = $products_description_en;
			}
			if($products_description_fr == ''){
				$products_description_fr = $products_description_en;
			}
			
			if($products_description_en != ''){
				$sql_data_array_info = array(
									'products_id'=>$pid_query->fields['products_id'],
									'products_description' => trim($products_description_en),
									'language_id' => 1
						);
				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);
			}else{
				
			}
			unset($sql_data_array_description);
			
			if($products_description_de != ''){
				$sql_data_array_info = array(
									'products_id'=>$pid_query->fields['products_id'],
									'products_description' => trim($products_description_en),
									'language_id' => 2
						);
				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);			
			}
			unset($sql_data_array_description);
			
				
			if($products_description_ru != ''){
				$sql_data_array_info = array(
									'products_id'=>$pid_query->fields['products_id'],
									'products_description' => trim($products_description_en),
									'language_id' => 3
						);
				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);
			}
			
			unset($sql_data_array_description);
			
			if($products_description_fr != ''){
			
				$sql_data_array_info = array(
									'products_id'=>$pid_query->fields['products_id'],
									'products_description' => trim($products_description_en),
									'language_id' => 4
						);
				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);
			}			
			unset($sql_data_array_description);			
			
			$cnt++;
		}

		echo $cnt;
		break;
	
	default:
		echo 'invalid action';
		break;	
}

function zen_refresh_products_price_new($as_product_id, $adc_net_price, $adc_product_weight, $adc_price_times, $ab_special = false, $old_price = ''){
		global $db;
		$price_manager_id = $db->Execute('select products_price,price_manager_id,products_model from ' . TABLE_PRODUCTS . ' where products_id = ' . $as_product_id . ' limit 1');
		if ($price_manager_id->RecordCount() == 1 && $price_manager_id->fields['price_manager_id'] > 0){
			$price_manager = $price_manager_id->fields['price_manager_id'];
			$price_manager_value = $db->Execute("SELECT price_manager_value FROM ".TABLE_PRICE_MANAGER." where price_manager_id = ".$price_manager." order by price_manager_id desc ");
			$price_after_manager = $adc_net_price * ($price_manager_value->fields['price_manager_value'] / 100 + 1);
		}else{
			$price_after_manager = $adc_net_price;
		}
		
		$airmail_info = get_airmail_info();
		$ldc_perg_fee = MODULE_SHIPPING_AIRMAIL_ARGUMENT * $airmail_info['discount'] / 1000 / MODULE_SHIPPING_CHIANPOST_CURRENCY;		
		
		$ldc_shipping_fee = $ldc_perg_fee * $adc_product_weight * $airmail_info['extra_times'];
		$ldc_price = $price_after_manager + $ldc_shipping_fee;		
		
	
				
		$update = true;
		switch (true) {
			case ($adc_price_times>=8) :
				$p1 = 0; $p2 = 0.125; $p3 = 0.25; break;
			case ($adc_price_times>=4 && $adc_price_times<8) : 
				$p1 = 0.2; $p2 = 0.3; $p3 = 0.35; break;
			case ($adc_price_times>=3.2 && $adc_price_times<4) :
				$p1 = 0.13; $p2 = 0.19; $p3 = 0.31; break;
			case ($adc_price_times>=2.8 && $adc_price_times<3.2) :
				$p1 = 0; $p2 = 0.07; $p3 = 0.1; break;
			case ($adc_price_times>=2.6 && $adc_price_times<2.8) :
				$p1 = 0; $p2 = 0.08; $p3 = 0.15; break;
			case ($adc_price_times>=2.4 && $adc_price_times<2.6) :
				$p1 = 0; $p2 = 0.08; $p3 = 0.17; break;
			case ($adc_price_times>=2.2 && $adc_price_times<2.4) :
				$p1 = 0.09; $p2 = 0.18; $p3 = 0.2; break;
			case ($adc_price_times>=2 && $adc_price_times<2.2) :
				$p1 = 0.09; $p2 = 0.1; $p3 = 0.15; break;
			default: 
				$p1 = 0; $p2 = 0; $p3 = 0; $update = false;
		}
		

		$db->Execute('Delete from ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ' Where products_id = ' . $as_product_id);
		if ($update){
			$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
				 (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . "),
				 (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . "),
				 (3, " . $as_product_id . ", 5, " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . ")");
		}
		
		if ($adc_price_times == 0) {
			$db->Execute("Update " . TABLE_PRODUCTS . "
						 Set products_quantity_order_min = 1,
						 	 products_discount_type_from = 1,
						 	 products_price = " . $ldc_price . ",
						 	 products_net_price = " . $adc_net_price . ",
						 	 product_price_times = " . $adc_price_times . ",
							 products_last_modified='".date('Y-m-d H:i:s')."'
					   Where products_id = " . $as_product_id);
		}else {
			$db->Execute("Update " . TABLE_PRODUCTS . "
							 Set products_quantity_order_min = 1,
							 	 products_discount_type = 2,
							 	 products_discount_type_from = 1,
							 	 products_price = " . $ldc_price . ",
							 	 products_net_price = " . $adc_net_price . ",
							 	 product_price_times = " . $adc_price_times . ",
								 products_price_sorter = ".$ldc_price.",
							 	 products_last_modified='".date('Y-m-d H:i:s')."'
						   Where products_id = " . $as_product_id);
			if ($ab_special) {
				//zen_update_products_price_sorter($as_product_id);
			}
		}
		$operate_content = '商品 products_price 变更: from '. $price_manager_id->fields['products_price'] .' to '. $ldc_price .' and products_net_price 变更: from ... '. $adc_net_price .' in ' . __FILE__ . ' on line: ' . __LINE__;
        zen_insert_operate_logs ( $_SESSION ['admin_id'], $price_manager_id->fields['products_model'], $operate_content, 2 );
		return true;
	}
	
	function zen_get_products_to_categories_path_new($cid, $array = array()) {
		global $db;
		global $all_cate_array;
		$array [] = $cid;
		if ($all_cate_array [$cid] ['parent']) {
			return zen_get_products_to_categories_path_new ( $all_cate_array [$cid] ['parent'], $array );
		} else {
			$array = array_reverse ( $array );
			$length = 5;
			for($i = sizeof ( $array ); $i <= $length; $i ++) {
				$array [$i] = 0;
			}
			return implode ( ',', $array );
		}
	}
	function zen_get_all_cate_array_new() {
		global $db;
		$get_all_cate_array = array ();
		$get_all_cate_query = "select c.categories_id,c.parent_id from " . TABLE_CATEGORIES . " c   where  categories_status=1 order by  categories_id ";
		$get_all_cate = $db->Execute ( $get_all_cate_query );
		if ($get_all_cate->RecordCount () > 0) {
			while ( ! $get_all_cate->EOF ) {
				$get_all_cate_array [$get_all_cate->fields ['categories_id']] = array (
						'id' => $get_all_cate->fields ['categories_id'],
						'parent' => $get_all_cate->fields ['parent_id']
				);
				$get_all_cate->MoveNext ();
			}
		}
		return $get_all_cate_array;
	}	

?>
