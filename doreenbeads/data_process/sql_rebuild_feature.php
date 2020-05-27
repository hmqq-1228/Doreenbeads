<?php 
require_once("includes/application_top.php");
@ini_set('display_errors', '1');
set_time_limit(1200);
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
$cnt=0;
$name_list = array();
$objPHPExcel = $objReader->load($exc_file);
$sheet = $objPHPExcel->getActiveSheet();
switch($_GET['action']){
	case 'feature_by_property':
		
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$feature_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());						
			$property_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(6,$j)->getValue());
			if(!$feature_id || !$property_id) continue;
			$top_category = $db->Execute("select parent_id from ".TABLE_CATEGORIES." where categories_id='".$feature_id."'");
			$top_cid = $top_category->fields['parent_id'];
			$db->Execute("delete from ".TABLE_CATEGORIES." where parent_id='".$feature_id."'");
			$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where second_categories_id='".$feature_id."'");
					
			$products_query = $db->Execute("select product_id from ".TABLE_PRODUCTS_TO_PROPERTY." where property_id='".$property_id."' group by product_id");
			$products_group = array();
			while(!$products_query->EOF){
				$master_category_query = $db->Execute("select master_categories_id from ".TABLE_PRODUCTS." where products_id='".$products_query->fields['product_id']."'");
				$origin_cid = $master_category_query->fields['master_categories_id'];
				if(!$origin_cid){
					$ptc_query = $db->Execute("select categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$products_query->fields['product_id']."' limit 1");
					$origin_cid = $ptc_query->fields['categories_id'];
				}
				
				$products_group[$origin_cid][] = $products_query->fields['product_id'];
				
				
				$products_query->MoveNext();
				
			}
			foreach($products_group as $key=>$val){
				$new_cid = '';
				$category_info = $db->Execute("select * from ".TABLE_CATEGORIES." where categories_id='".$key."'");
				$category_desc = $db->Execute("select * from ".TABLE_CATEGORIES_DESCRIPTION." where categories_id='".$key."'");
				if($category_info->fields['categories_id']>0 && $category_desc->RecordCount()>0){
					//create categories
					$new_data_array = array(
						'categories_image'=>zen_db_prepare_input($category_info->fields['categories_image']),
						'parent_id'=>$feature_id,
						'sort_order'=>$category_info->fields['sort_order'],
						'date_added'=>date('Y-m-d H:i:s'),
						'categories_status'=>$category_info->fields['categories_status'],
						'categories_level'=>$category_info->fields['categories_level'],
						'chinese_info'=>$category_info->fields['chinese_info'],
						'display_pic'=>$category_info->fields['display_pic']
							
					);
					zen_db_perform(TABLE_CATEGORIES, $new_data_array);
					$new_cid = $db->Insert_ID();
					while(!$category_desc->EOF){
						$name_data = array(
								'categories_id'=>$new_cid,
								'language_id'=>$category_desc->fields['language_id'],
								'categories_name'=>zen_db_prepare_input($category_desc->fields['categories_name']),
								'categories_description'=>($category_desc->fields['categories_description'])
						);
						zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $name_data);
						$category_desc->MoveNext();
					}
					
					//add products
					foreach ($val as $pid){
						$add_ptc_data = array(
								'products_id'=>$pid,
								'categories_id'=>$new_cid,
								'first_categories_id'=>$top_cid,
								'second_categories_id'=>$feature_id,
								'three_categories_id'=>$new_cid
						);
						zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $add_ptc_data);						
						$cnt++;
					}
				}
				
			}
			
		}
		$seed_beads =$db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id='1747'");
		while(!$seed_beads->EOF){
			$add_seed_data = array(
					'products_id'=>$seed_beads->fields['products_id'],
					'categories_id'=>2141,
					'first_categories_id'=>2066,
					'second_categories_id'=>2141,
					'three_categories_id'=>0
			);
			zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $add_seed_data);
			$cnt++;
			$seed_beads->MoveNext();
		}
		echo $cnt;
		break;
	case 'featured_european':
			$top_cate = 2066;
			$second_cate = 2067;
			$db->Execute("delete from ".TABLE_CATEGORIES." where parent_id='".$second_cate."'");
			$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where second_categories_id='".$second_cate."'");
			
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$origin_cate_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
				$property_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
				if(!$origin_cate_id) continue;
				
				$new_cid = '';
				$category_info = $db->Execute("select * from ".TABLE_CATEGORIES." where categories_id='".$origin_cate_id."'");
				$category_desc = $db->Execute("select * from ".TABLE_CATEGORIES_DESCRIPTION." where categories_id='".$origin_cate_id."'");
				if($category_info->fields['categories_id']>0 && $category_desc->RecordCount()>0){
					//create categories
					$new_data_array = array(
							'categories_image'=>zen_db_prepare_input($category_info->fields['categories_image']),
							'parent_id'=>$second_cate,
							'sort_order'=>$category_info->fields['sort_order'],
							'date_added'=>date('Y-m-d H:i:s'),
							'categories_status'=>$category_info->fields['categories_status'],
							'categories_level'=>$category_info->fields['categories_level'],
							'chinese_info'=>$category_info->fields['chinese_info'],
							'display_pic'=>$category_info->fields['display_pic']
								
					);
					zen_db_perform(TABLE_CATEGORIES, $new_data_array);
					$new_cid = $db->Insert_ID();
					while(!$category_desc->EOF){
						$name_data = array(
								'categories_id'=>$new_cid,
								'language_id'=>$category_desc->fields['language_id'],
								'categories_name'=>zen_db_prepare_input($category_desc->fields['categories_name']),
								'categories_description'=>($category_desc->fields['categories_description'])
						);
						zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $name_data);
						$category_desc->MoveNext();
					}
					
					$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id='".$origin_cate_id."'");
					while(!$products_query->EOF){
						if($property_id>0){
								$check_property = $db->Execute("select products_to_property_id from ".TABLE_PRODUCTS_TO_PROPERTY." where product_id='".$products_query->fields['products_id']."' and property_id='".$property_id."' limit 1");
								if($check_property->RecordCount()==0){
									$products_query->MoveNext();
									continue;
								}
						}
						$add_ptc_data = array(
								'products_id'=>$products_query->fields['products_id'],
								'categories_id'=>$new_cid,
								'first_categories_id'=>$top_cate,
								'second_categories_id'=>$second_cate,
								'three_categories_id'=>$new_cid
						);
						zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $add_ptc_data);
						$cnt++;
						$products_query->MoveNext();
					}
				}
					
			}
		echo $cnt;
		break;
	default:
 		echo 'Invalid action';
 		break;
}



?>