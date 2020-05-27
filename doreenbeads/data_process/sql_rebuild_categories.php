<?php
require_once("includes/application_top.php");
@ini_set('display_errors', '1');
set_time_limit(1200);
ini_set('memory_limit','512M');
global $db;

if(is_numeric($_GET['pcid'])){
	$sub_categories = array();
	get_sub_categories($sub_categories,$_GET['pcid']);
	$c_list = '';
	foreach ($sub_categories as $val){
		$c_list.=$val.',';
	}
	echo $c_list;exit;
	
}

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
$table_category = DB_PREFIX.'categories';
$table_category_description = DB_PREFIX.'categories_description';
$table_category_redirect = DB_PREFIX.'category_redirect';
$table_product_to_category = DB_PREFIX.'products_to_categories';
$count = 0;
$name_list = array();
$objPHPExcel = $objReader->load($exc_file);
$sheet = $objPHPExcel->getActiveSheet();

switch($_GET['action']){
	case 'new_categories':
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			
			$first_level_id = '';
			$second_level_id = '';
			$third_level_id = '';
			
			$max_level = 1;
			$first_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$first_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$first_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$first_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			//$first_level_image = 'category/'.str_replace(' ','',$data->sheets[0]['cells'][$i][2]);
			$first_level_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$first_level_sort = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
			
			$second_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$second_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$second_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$second_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
			//$second_level_image = 'category/'.str_replace(' ','',$data->sheets[0]['cells'][$i][9]);
			$second_level_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(5,$j)->getValue());
			$second_level_sort = zen_db_prepare_input($sheet->getCellByColumnAndRow(6,$j)->getValue());
			
			$third_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue());
			$third_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue());
			$third_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue());
			$third_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue());
			
			//$third_level_image = 'category/'.str_replace(' ','',$data->sheets[0]['cells'][$i][16]);
			$third_level_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(9,$j)->getValue());
			$third_level_sort = zen_db_prepare_input($sheet->getCellByColumnAndRow(10,$j)->getValue());
			
			$old_first_categories = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
			$old_second_categories = zen_db_prepare_input($sheet->getCellByColumnAndRow(7,$j)->getValue());
			$old_third_categories = zen_db_prepare_input($sheet->getCellByColumnAndRow(11,$j)->getValue());

			
			$check_first_exist = $db->Execute("select categories_id from t_categories where categories_code='".$first_level_code."'");
			if($check_first_exist->RecordCount()==0 && $first_level_code!=''){
				$sql_data_first = array(
						'categories_code'=>$first_level_code,
						'parent_id'=>'0',
						//'categories_image' => $first_level_image,
						'date_added' => date('Y-m-d H:i:s'),
						'sort_order' => $first_level_sort,
						//'chinese_info' => $first_level_name_cn
				);
				zen_db_perform($table_category, $sql_data_first);
				$first_level_id = $db->insert_ID();
				//en
				$first_description_data = array(
						'categories_id'=>$first_level_id,
						'language_id'=>1,
						'categories_name'=>zen_db_prepare_input($first_level_name_en)
				);
				zen_db_perform($table_category_description, $first_description_data);
				//de
				$first_description_data_de = array(
						'categories_id'=>$first_level_id,
						'language_id'=>2,
						'categories_name'=>zen_db_prepare_input($first_level_name_de)
				);
				zen_db_perform($table_category_description, $first_description_data_de);
				//ru
				$first_description_data_ru = array(
						'categories_id'=>$first_level_id,
						'language_id'=>3,
						'categories_name'=>zen_db_prepare_input($first_level_name_ru)
				);
				zen_db_perform($table_category_description, $first_description_data_ru);
				//fr
				 $first_description_data_fr = array(
						'categories_id'=>$first_level_id,
						'language_id'=>4,
						'categories_name'=>zen_db_prepare_input($first_level_name_fr)
				); 
				zen_db_perform($table_category_description, $first_description_data_fr);
			}else{
				$first_level_id = $check_first_exist->fields['categories_id'];
			}
			
			if($second_level_code!=''){
				$check_second_exist = $db->Execute("select categories_id from t_categories where categories_code='".$second_level_code."'");
				if($check_second_exist->RecordCount()==0){
					$sql_data_second = array(
							'categories_code'=>$second_level_code,
							'parent_id'=>$first_level_id,
							//'categories_image' => $second_level_image,
							'date_added' => date('Y-m-d H:i:s'),
							'sort_order' => $second_level_sort,
							//'chinese_info' => $second_level_name_cn
					);
					zen_db_perform($table_category, $sql_data_second);
					$second_level_id = $db->insert_ID();
					//en
					$second_description_data = array(
							'categories_id'=>$second_level_id,
							'language_id'=>1,
							'categories_name'=>zen_db_prepare_input($second_level_name_en)
					);
					zen_db_perform($table_category_description, $second_description_data);
					//de
					$second_description_data_de = array(
							'categories_id'=>$second_level_id,
							'language_id'=>2,
							'categories_name'=>zen_db_prepare_input($second_level_name_de)
					);
					zen_db_perform($table_category_description, $second_description_data_de);
					//ru
					$second_description_data_ru = array(
							'categories_id'=>$second_level_id,
							'language_id'=>3,
							'categories_name'=>zen_db_prepare_input($second_level_name_ru)
					);
					zen_db_perform($table_category_description, $second_description_data_ru);
					//fr
					 $second_description_data_fr = array(
							'categories_id'=>$second_level_id,
							'language_id'=>4,
							'categories_name'=>zen_db_prepare_input($second_level_name_fr)
					);
					zen_db_perform($table_category_description, $second_description_data_fr); 
				}else{
					$second_level_id = $check_second_exist->fields['categories_id'];
				}
			}
			if($second_level_id!='') $max_level=2;
			if($third_level_code!=''){
				$check_third_exist = $db->Execute("select categories_id from t_categories where categories_code='".$third_level_code."'");
				if($check_third_exist->RecordCount()==0){
					$sql_data_third = array(
							'categories_code'=>$third_level_code,
							'parent_id'=>$second_level_id,
							//'categories_image' => $third_level_image,
							'date_added' => date('Y-m-d H:i:s'),
							'sort_order' => $third_level_sort,
							//'chinese_info' => $third_level_name_cn
					);
					zen_db_perform($table_category, $sql_data_third);
					$third_level_id = $db->insert_ID();
					//en
					$third_description_data = array(
							'categories_id'=>$third_level_id,
							'language_id'=>1,
							'categories_name'=>zen_db_prepare_input($third_level_name_en)
					);
					zen_db_perform($table_category_description, $third_description_data);
					//de
					$third_description_data_de = array(
							'categories_id'=>$third_level_id,
							'language_id'=>2,
							'categories_name'=>zen_db_prepare_input($third_level_name_de)
					);
					zen_db_perform($table_category_description, $third_description_data_de);
					//ru
					$third_description_data_ru = array(
							'categories_id'=>$third_level_id,
							'language_id'=>3,
							'categories_name'=>zen_db_prepare_input($third_level_name_ru)
					);
					zen_db_perform($table_category_description, $third_description_data_ru);
					//fr
					$third_description_data_fr = array(
							'categories_id'=>$third_level_id,
							'language_id'=>4,
							'categories_name'=>zen_db_prepare_input($third_level_name_fr)
					);
					zen_db_perform($table_category_description, $third_description_data_fr); 
				}else{
					$third_level_id = $check_third_exist->fields['categories_id'];
				}
			}
			if($third_level_id!='') $max_level=3;
			switch($max_level){
				case 2:
					$redirect_category = $second_level_id;
					break;
				case 3:
					$redirect_category = $third_level_id;
					break;
				default:
					$redirect_category = $first_level_id;
					break;
			}
			if($old_first_categories!=''){
				$old_first_categ_list1 = explode(',',$old_first_categories);		
				foreach($old_first_categ_list1 as $key1=>$val1){
					if(is_numeric($val1)){
						$redirct_data_arr1 = array(
							'new_category_id'=>$first_level_id,
							'old_category_id'=>$val1
			
						);
						zen_db_perform($table_category_redirect, $redirct_data_arr1);
					}
				}
			}
			if($old_second_categories!=''){
				$old_second_categ_list2 = explode(',',$old_second_categories);
				foreach($old_second_categ_list2 as $key2=>$val2){
					if(is_numeric($val2)){
						$redirct_data_arr2 = array(
								'new_category_id'=>$second_level_id,
								'old_category_id'=>$val2
									
						);
						zen_db_perform($table_category_redirect, $redirct_data_arr2);
					}
				}
			}
			if($old_third_categories!=''){
				$old_third_categ_list3 = explode(',',$old_third_categories);
				foreach($old_third_categ_list3 as $key3=>$val3){
					if(is_numeric($val3)){
						$redirct_data_arr3 = array(
								'new_category_id'=>$third_level_id,
								'old_category_id'=>$val3
									
						);
						zen_db_perform($table_category_redirect, $redirct_data_arr3);
					}
				}
			}
			$count++;
		}
		break;
	case 'category_name':
		for($j=2;$j<=$sheet->getHighestRow();$j++){
				
			$category_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$first_level_name_cn = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$first_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
			$first_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
			$first_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$first_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(5,$j)->getValue());
			$category_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$category_code."'");
			if($category_query->fields['categories_id']>0){
				$db->Execute("update ".TABLE_CATEGORIES." set chinese_info='".$first_level_name_cn."' where categories_id='".$category_query->fields['categories_id']."'");
				//$db->Execute("update ".TABLE_CATEGORIES_DESCRIPTION." set categories_name='".$first_level_name_en."' where categories_id='".$category_query->fields['categories_id']."' and language_id=1");
				//$db->Execute("update ".TABLE_CATEGORIES_DESCRIPTION." set categories_name='".$first_level_name_de."' where categories_id='".$category_query->fields['categories_id']."' and language_id=2");
				//$db->Execute("update ".TABLE_CATEGORIES_DESCRIPTION." set categories_name='".$first_level_name_ru."' where categories_id='".$category_query->fields['categories_id']."' and language_id=3");
				//$db->Execute("update ".TABLE_CATEGORIES_DESCRIPTION." set categories_name='".$first_level_name_fr."' where categories_id='".$category_query->fields['categories_id']."' and language_id=4");
				
				$data_en = array('categories_name'=>$first_level_name_en);
				zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $data_en,'update', "categories_id='".$category_query->fields['categories_id']."' and language_id=1");
				$data_de = array('categories_name'=>$first_level_name_de);
				zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $data_de,'update', "categories_id='".$category_query->fields['categories_id']."' and language_id=2");
				$data_ru = array('categories_name'=>$first_level_name_ru);
				zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $data_ru,'update', "categories_id='".$category_query->fields['categories_id']."' and language_id=3");
				
				$data_fr = array('categories_name'=>$first_level_name_fr);
				zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $data_fr,'update', "categories_id='".$category_query->fields['categories_id']."' and language_id=4");
				
			}
			$count++;
		}
		break;
		
	case 'ptc':
		for($j=2;$j<=$sheet->getHighestRow();$j++){
		
			$product_model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$product_model = str_ireplace('XB', 'B', $product_model);
			$category_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$category_query = $db->Execute("select categories_id from ".$table_category." where categories_code='".$category_code."'");
			$category_id = $category_query->fields['categories_id'];
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$product_model."'");
			$product_id = $product_query->fields['products_id'];
			if($category_id>0 && $product_id>0){
				$check_exist = $db->Execute("select first_categories_id from ".$table_product_to_category." where products_id=".$product_id." and categories_id=".$category_id);
				if($check_exist->RecordCount()==0){
					$categories = array();
      				get_parent_categories($categories, $category_id);
      				$categories = array_reverse($categories);
      				if(sizeof($categories)==1){
      					$categories[1]=0;
      					$categories[2]=0;
      				}elseif(sizeof($categories)==2){
      					$categories[2]=0;
      				}
      				$sql_data_arr = array(
      				'products_id'=>$product_id,
      				'categories_id'=>$category_id,
      				'first_categories_id'=>$categories[0],
      				'second_categories_id'=>$categories[1],
      				'three_categories_id'=>$categories[2]
      				);
      				zen_db_perform($table_product_to_category, $sql_data_arr);
      				$count++;
				}
				
			}
		}
		break;
	case 'delete_old':
		$mix_list = '1680,1681,1682,1683,1684,1685,1686,1687,1688,1689,1690,1691,1692,1693,1694,1695,1696,1697,1698,1699,1700';
		$clear_list = '1705,1211,1375,1469,1587,1588,1589,1590,1606,1618,1619,1718';
		$chunk_list = '1711,1712,1713,1714,1715,1716,1717';
		$shamb_list = '1527,1529,1537,1528,1538,1539,1541,1547,1548,1553';
		$europ_list = '239,135,137,146,147,148,149,150,151,152,193,212,215,222,225,332,1388,1389,1390,1395,1453,153,118,154,156,158,174,155,160,161,185,203,1287,132,1288,1289,1290,1291,162,1292,1293,175,117,176,177,191,192,195,204,232,233,205,206,207,238,209,210,213,214,216,217,218,219,226,221,223,224,227,229,230,330,136,331,1297,1283,164,235,236,237,1284,1285,1298,1316,1450,1462,1300,1301,1302,1303,1357,1491,1306,1330,1331,1332,1335,1336,1355,1366,1376,1377,1383,138,1384,1385,1386,1474,1391,1399,211,1400,1480,1422,1434,1444,1445,1446,1447,1448,1449,1482,1479,1484';
		$extra_categories = $mix_list.','. $clear_list.','.$chunk_list.','.$shamb_list.','.$europ_list;
		$sql1 = "delete from ".TABLE_CATEGORIES." where categories_id<1710 and categories_id not in (".$extra_categories.");";
		$sql2 = "delete from ".TABLE_CATEGORIES_DESCRIPTION." where categories_id<1710 and categories_id not in (".$extra_categories.");";
		$sql3 = "delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id<1710 and categories_id not in (".$extra_categories.");";
		echo $sql1.'<br/>'.$sql2.'<br/>'.$sql3.'<br/>';
		break;
	case 'category_img':
		$img_query = $db->Execute("select categories_code, categories_image from zen_categories where categories_code!=''");
		while(!$img_query->EOF){
			if($img_query->fields['categories_image']!=''){
				$db->Execute("update ".TABLE_CATEGORIES." set categories_image='".$img_query->fields['categories_image']."' where categories_code='".$img_query->fields['categories_code']."'");
				$count++;
			}			
			$img_query->MoveNext();
			
		}
		break;
	case 'featured':
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			
			$first_level_id = '';
			$second_level_id = '';
			$third_level_id = '';
			
			$max_level = 1;
			$first_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
			$first_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$first_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(5,$j)->getValue());
			$first_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(6,$j)->getValue());
			$first_level_image = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
			$first_level_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$first_level_sort = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			
			$second_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(10,$j)->getValue());
			$second_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(11,$j)->getValue());
			$second_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(12,$j)->getValue());
			$second_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(13,$j)->getValue());
			$second_level_image = zen_db_prepare_input($sheet->getCellByColumnAndRow(9,$j)->getValue());
			$second_level_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(7,$j)->getValue());
			$second_level_sort = zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue());
			
			$third_level_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(17,$j)->getValue());
			$third_level_name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(18,$j)->getValue());
			$third_level_name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(19,$j)->getValue());
			$third_level_name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(20,$j)->getValue());
			
			$third_level_image = zen_db_prepare_input($sheet->getCellByColumnAndRow(16,$j)->getValue());
			$third_level_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(14,$j)->getValue());
			$third_level_sort = zen_db_prepare_input($sheet->getCellByColumnAndRow(15,$j)->getValue());
			
		
			
			$check_first_exist = $db->Execute("select categories_id from t_categories where categories_code='".$first_level_code."'");
			if($check_first_exist->RecordCount()==0 && $first_level_code!=''){
				$sql_data_first = array(
						'categories_code'=>$first_level_code,
						'parent_id'=>'0',
						'categories_image' => $first_level_image,
						'date_added' => date('Y-m-d H:i:s'),
						'sort_order' => $first_level_sort,
						//'chinese_info' => $first_level_name_cn
				);
				zen_db_perform($table_category, $sql_data_first);
				$first_level_id = $db->insert_ID();
				//en
				$first_description_data = array(
						'categories_id'=>$first_level_id,
						'language_id'=>1,
						'categories_name'=>zen_db_prepare_input($first_level_name_en)
				);
				zen_db_perform($table_category_description, $first_description_data);
				//de
				$first_description_data_de = array(
						'categories_id'=>$first_level_id,
						'language_id'=>2,
						'categories_name'=>zen_db_prepare_input($first_level_name_de)
				);
				zen_db_perform($table_category_description, $first_description_data_de);
				//ru
				$first_description_data_ru = array(
						'categories_id'=>$first_level_id,
						'language_id'=>3,
						'categories_name'=>zen_db_prepare_input($first_level_name_ru)
				);
				zen_db_perform($table_category_description, $first_description_data_ru);
				//fr
				 $first_description_data_fr = array(
						'categories_id'=>$first_level_id,
						'language_id'=>4,
						'categories_name'=>zen_db_prepare_input($first_level_name_fr)
				); 
				zen_db_perform($table_category_description, $first_description_data_fr);
			}else{
				$first_level_id = $check_first_exist->fields['categories_id'];
			}
			
			if($second_level_code!=''){
				$check_second_exist = $db->Execute("select categories_id from t_categories where categories_code='".$second_level_code."'");
				if($check_second_exist->RecordCount()==0){
					$sql_data_second = array(
							'categories_code'=>$second_level_code,
							'parent_id'=>$first_level_id,
							'categories_image' => $second_level_image,
							'date_added' => date('Y-m-d H:i:s'),
							'sort_order' => $second_level_sort,
							//'chinese_info' => $second_level_name_cn
					);
					zen_db_perform($table_category, $sql_data_second);
					$second_level_id = $db->insert_ID();
					//en
					$second_description_data = array(
							'categories_id'=>$second_level_id,
							'language_id'=>1,
							'categories_name'=>zen_db_prepare_input($second_level_name_en)
					);
					zen_db_perform($table_category_description, $second_description_data);
					//de
					$second_description_data_de = array(
							'categories_id'=>$second_level_id,
							'language_id'=>2,
							'categories_name'=>zen_db_prepare_input($second_level_name_de)
					);
					zen_db_perform($table_category_description, $second_description_data_de);
					//ru
					$second_description_data_ru = array(
							'categories_id'=>$second_level_id,
							'language_id'=>3,
							'categories_name'=>zen_db_prepare_input($second_level_name_ru)
					);
					zen_db_perform($table_category_description, $second_description_data_ru);
					//fr
					 $second_description_data_fr = array(
							'categories_id'=>$second_level_id,
							'language_id'=>4,
							'categories_name'=>zen_db_prepare_input($second_level_name_fr)
					);
					zen_db_perform($table_category_description, $second_description_data_fr); 
				}else{
					$second_level_id = $check_second_exist->fields['categories_id'];
				}
			}
			if($second_level_id!='') $max_level=2;
			if($third_level_code!=''){
				$check_third_exist = $db->Execute("select categories_id from t_categories where categories_code='".$third_level_code."'");
				if($check_third_exist->RecordCount()==0){
					$sql_data_third = array(
							'categories_code'=>$third_level_code,
							'parent_id'=>$second_level_id,
							'categories_image' => $third_level_image,
							'date_added' => date('Y-m-d H:i:s'),
							'sort_order' => $third_level_sort,
							//'chinese_info' => $third_level_name_cn
					);
					zen_db_perform($table_category, $sql_data_third);
					$third_level_id = $db->insert_ID();
					//en
					$third_description_data = array(
							'categories_id'=>$third_level_id,
							'language_id'=>1,
							'categories_name'=>zen_db_prepare_input($third_level_name_en)
					);
					zen_db_perform($table_category_description, $third_description_data);
					//de
					$third_description_data_de = array(
							'categories_id'=>$third_level_id,
							'language_id'=>2,
							'categories_name'=>zen_db_prepare_input($third_level_name_de)
					);
					zen_db_perform($table_category_description, $third_description_data_de);
					//ru
					$third_description_data_ru = array(
							'categories_id'=>$third_level_id,
							'language_id'=>3,
							'categories_name'=>zen_db_prepare_input($third_level_name_ru)
					);
					zen_db_perform($table_category_description, $third_description_data_ru);
					//fr
					$third_description_data_fr = array(
							'categories_id'=>$third_level_id,
							'language_id'=>4,
							'categories_name'=>zen_db_prepare_input($third_level_name_fr)
					);
					zen_db_perform($table_category_description, $third_description_data_fr); 
				}else{
					$third_level_id = $check_third_exist->fields['categories_id'];
				}
			}
			if($third_level_id!='') $max_level=3;
			
			
			$count++;
		}
		break;
	case 'featured_301':
		$i=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$max_level=1;
			$top_new = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$second_new = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
			$second_old = explode('_',zen_db_prepare_input($sheet->getCellByColumnAndRow(5,$j)->getValue()));
			
			$third_new = zen_db_prepare_input($sheet->getCellByColumnAndRow(6,$j)->getValue());
			$third_old = explode('_',zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue()));
			if(sizeof($second_old)>0){
				$max_level=2;
				foreach($second_old as $second_cid){
				  if($second_cid>0 && $second_new>0){
				  	$ptc_query = $db->Execute("select products_id from t_products_to_categories where categories_id=".$second_cid);
				  	while(!$ptc_query->EOF){
				  		$check_new = $db->Execute("select products_id from t_products_to_categories where categories_id=".$second_new." and products_id=".$ptc_query->fields['products_id']);
				  		if($check_new->RecordCount()==0){
				  			$db->Execute("update ".TABLE_PRODUCTS_TO_CATEGORIES." set 
							categories_id='".$second_new."',
							first_categories_id='".$top_new."',
							second_categories_id='".$second_new."',
							three_categories_id=0
							where categories_id='".$second_cid."' and products_id=".$ptc_query->fields['products_id']);
					
					 		 echo $ptc_query->fields['products_id'].'------2nd:'.$second_cid.'->'.$second_new.'<br/>';
				  		}
				  		$ptc_query->MoveNext();
				  	}
				  	
					/*$second_redirect_data = array('new_category_id'=>$second_new,'old_category_id'=>$second_cid);
					$check_second = $db->Execute("select redirect_id from t_category_redirect where new_category_id=".$second_new." and old_category_id=".$second_cid);
					if($check_second->RecordCount()==0){
					zen_db_perform('t_category_redirect', $second_redirect_data);
					$db->Execute("update ".TABLE_PRODUCTS_TO_CATEGORIES." set 
							categories_id='".$second_new."',
							first_categories_id='".$top_new."',
							second_categories_id='".$second_new."',
							three_categories_id=0
							where categories_id='".$second_cid."'");
					
					  echo '2nd:'.$second_cid.'->'.$second_new.'<br/>';
					}*/
				  }
				}
				
			}
			if(sizeof($third_old)>0){
				$max_level=3;
				foreach($third_old as $third_cid){
				  if($third_cid>0 && $third_new>0){
				  	$ptc_query = $db->Execute("select products_id from t_products_to_categories where categories_id=".$third_cid);
				  	while(!$ptc_query->EOF){
				  		$check_new = $db->Execute("select products_id from t_products_to_categories where categories_id=".$third_new." and products_id=".$ptc_query->fields['products_id']);
				  		if($check_new->RecordCount()==0){
				  			$db->Execute("update ".TABLE_PRODUCTS_TO_CATEGORIES." set
							categories_id='".$third_new."',
							first_categories_id='".$top_new."',
							second_categories_id='".$second_new."',
							three_categories_id='".$third_new."'
							where categories_id='".$third_cid."' and products_id=".$ptc_query->fields['products_id']);
					  		echo $ptc_query->fields['products_id'].'---3rd:'.$third_cid.'->'.$third_new.'<br/>';
				  		}
				  		$ptc_query->MoveNext();
				  	}
				  	/*
					$third_redirect_data = array('new_category_id'=>$third_new,'old_category_id'=>$third_cid);
					$check_third = $db->Execute("select redirect_id from t_category_redirect where new_category_id=".$third_new." and old_category_id=".$third_cid);
					if($check_third->RecordCount()==0){
					zen_db_perform('t_category_redirect', $third_redirect_data);
					$db->Execute("update ".TABLE_PRODUCTS_TO_CATEGORIES." set
							categories_id='".$third_new."',
							first_categories_id='".$top_new."',
							second_categories_id='".$second_new."',
							three_categories_id='".$third_new."'
							where categories_id='".$third_cid."'");
					  echo '3rd:'.$third_cid.'->'.$third_new.'<br/>';
					
					}*/
				  }
				}
				$i++;
			}
			
			
		}
		break;
	default:
		echo 'Invalid action';
		break;
}
echo $count;
$master_catg='update t_products set master_categories_id = (select p2c.categories_id from t_products_to_categories p2c where p2c.products_id=t_products.products_id limit 1)';
function get_parent_categories(&$categories, $categories_id) {
	global $db;
	$parent_categories_query = "select parent_id
                                from ".TABLE_CATEGORIES."
                                where categories_id = '" . (int)$categories_id . "'";

	$parent_categories = $db->Execute($parent_categories_query);
	if(!in_array($categories_id, $categories))$categories[]=$categories_id;
	while (!$parent_categories->EOF) {
		if ($parent_categories->fields['parent_id'] == 0) return true;
		$categories[sizeof($categories)] = $parent_categories->fields['parent_id'];
		if ($parent_categories->fields['parent_id'] != $categories_id) {
			get_parent_categories($categories, $parent_categories->fields['parent_id']);
		}
		$parent_categories->MoveNext();
	}
}

function get_sub_categories(&$sub_categories,$parent_cate){
	global $db;
	$child_category_query = $db->Execute("select categories_id
                                from ".TABLE_CATEGORIES."
                                where parent_id = '" . (int)$parent_cate . "'");
	if(!in_array($parent_cate, $sub_categories))$sub_categories[]=$parent_cate;
	while(!$child_category_query->EOF){
		$sub_categories[sizeof($sub_categories)] = $child_category_query->fields['categories_id'];
		get_sub_categories($sub_categories,$child_category_query->fields['categories_id']);
		$child_category_query->MoveNext();
	}
}

?>