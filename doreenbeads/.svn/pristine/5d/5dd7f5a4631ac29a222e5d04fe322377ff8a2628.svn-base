<?php 
chdir("../");
require_once("includes/application_top.php");
require("includes/access_ip_limit.php");
@ini_set('display_errors', '1');
set_time_limit(3600);
ini_set('memory_limit','2048M');
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
	case 'remove_cache_by_id':
		if($_GET['pid']){
			remove_product_memcache($_GET['pid']);
			echo 'success';
		}
		break;
	case 'clear_memcache':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
			if($product_query->fields['products_id']>0){
				remove_product_memcache($product_query->fields['products_id']);
				$cnt++;
			}
		}
		echo $cnt;
	
		break;
	case 'level_s':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
			if($product_query->fields['products_id']>0){
				$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1 ,products_limit_stock = 0,is_sold_out=0,products_is_perorder = 0,products_quantity_order_max = 50000 where products_model='".$model."'");	
				$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = 50000, modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");
				
				$cnt++;
				$s_data = array('products_id'=>$product_query->fields['products_id'], 'products_model'=>$model);
				zen_db_perform('t_products_s_level', $s_data);
			}else{
				echo 'line '.$j.' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt;
		break;
	case 'normal':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			//$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$qty = 50000;
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 1;
			$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
			if($product_query->fields['products_id']>0){
				$check_promotion = $db->Execute("select pp_promotion_id from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id='".$products_query->fields['products_id']."' and pp_is_forbid = 10");
				if($check_promotion->fields['pp_promotion_id']>0){
					$promotion_time = $db->Execute("select promotion_start_time,promotion_end_time from ".TABLE_PROMOTION." where promotion_id=".$check_promotion->fields['pp_promotion_id']);
					if($promotion_time->fields['promotion_end_time']>date('Y-m-d H:i:s'))
						$qty = round(zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue()) * $stock_percent);
				}
				$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1 ,products_limit_stock = 0,is_sold_out=0,products_is_perorder = 0,products_quantity_order_max = 50000 where products_id='".$product_query->fields['products_id']."'");	
				$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");			
				if($product_query->fields['products_status']==0){
					remove_product_memcache($product_query->fields['products_id']);
				}
				$cnt++;		
			}else{
				echo 'line '.$j.' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt;
		break;
	case 'invalid':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 1;
			$qty = round($qty * $stock_percent);
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
			if($product_query->RecordCount()>0){
			  while(!$product_query->EOF){
				remove_product_memcache($product_query->fields['products_id']);
				$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
				if($check_s_level->RecordCount()==0){
					$db->Execute("update ".TABLE_PRODUCTS." set products_status = 0  where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("delete from ".TABLE_PROMOTION_PRODUCTS."  where pp_products_id=".$product_query->fields['products_id']);
					echo $model.' droped <br/>';
					$cnt++;
				}
				$product_query->MoveNext();
			  }
			}else{
				echo 'line '.$j.' --- '.$model.' not existed <br/>';
			}
			
		}
		echo $cnt;
		
		break;
	case 'preorder':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 1;
			$qty = round($qty * $stock_percent);
			if($qty<0)$qty=0;
			$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
			if($product_query->fields['products_id']>0){
				$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
				if($check_s_level->RecordCount()==0){
					$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1,products_limit_stock = 0,products_is_perorder=0 ,is_sold_out=0  where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");				
					$cnt++;
				}
				if($qty==0){
					$check_products_promotion_status_sql = 'SELECT zpp.* FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zp.promotion_create_time < now() AND zp.promotion_end_time > now() and zp.promotion_status = 1 and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . ( int ) $product_query->fields['products_id'];
					$check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);
						
					if($check_products_promotion_status_query->RecordCount() > 0){
						while(!$check_products_promotion_status_query->EOF){
							$pp_id = $check_products_promotion_status_query->fields['pp_id'];
							$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 WHERE pp_id = ' . $pp_id);
								
							$check_products_promotion_status_query->MoveNext();
						}
					}
						
					$check_products_deals_status_sql = 'SELECT zdp.* from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . ( int ) $product_query->fields['products_id'];
					$check_products_deals_status_query = $db->Execute($check_products_deals_status_sql);
						
					if($check_products_deals_status_query->RecordCount() > 0){
						while (!$check_products_deals_status_query->EOF){
							$dailydeal_promotion_id = $check_products_deals_status_query->fields['dailydeal_promotion_id'];
							$db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 where dailydeal_promotion_id = ' . $dailydeal_promotion_id);
								
							$check_products_deals_status_query->MoveNext();
						}
					}
					remove_product_memcache($product_query->fields['products_id']);
				}
				if($product_query->fields['products_status']==0){
					remove_product_memcache($product_query->fields['products_id']);
				}
			}else{
				echo 'line '.$j.' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt;
		
		break;	
	case 'limit_stock':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
						
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 1;
			$qty = round($qty * $stock_percent);
			if($qty>0){
				$status=1;
			}else{
				$status=0;
				$qty = 0;
			}
			$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
			if($product_query->fields['products_id']>0){	
				$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
				if($check_s_level->RecordCount()==0){				
					$db->Execute("update ".TABLE_PRODUCTS." set products_limit_stock = 1,products_is_perorder=1,products_status = ".$status.", products_quantity_order_max=".(int)$qty."  where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");				
					if($status==0){
						$check_products_promotion_status_sql = 'SELECT zpp.* FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zp.promotion_create_time < now() AND zp.promotion_end_time > now() and zp.promotion_status = 1 and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . ( int ) $product_query->fields['products_id'];
						$check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);
							
						if($check_products_promotion_status_query->RecordCount() > 0){
							while(!$check_products_promotion_status_query->EOF){
								$pp_id = $check_products_promotion_status_query->fields['pp_id'];
								$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 WHERE pp_id = ' . $pp_id);
									
								$check_products_promotion_status_query->MoveNext();
							}
						}
							
						$check_products_deals_status_sql = 'SELECT zdp.* from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . ( int ) $product_query->fields['products_id'];
						$check_products_deals_status_query = $db->Execute($check_products_deals_status_sql);
							
						if($check_products_deals_status_query->RecordCount() > 0){
							while (!$check_products_deals_status_query->EOF){
								$dailydeal_promotion_id = $check_products_deals_status_query->fields['dailydeal_promotion_id'];
								$db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 where dailydeal_promotion_id = ' . $dailydeal_promotion_id);
									
								$check_products_deals_status_query->MoveNext();
							}
						}
						remove_product_memcache($product_query->fields['products_id']);
					}
					if($product_query->fields['products_status']==0 && $status==1){
						remove_product_memcache($product_query->fields['products_id']);
					}
					$cnt++;
				}
			}else{
				echo 'line '.$j.' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt;
		
		break;	
	case 'check_my_product':
			$cnt=0;
			$product_query = $db->Execute("select products_id from ".TABLE_MY_PRODUCTS." group by products_id");
			while(!$product_query->EOF){
				$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id=".$product_query->fields['products_id']);
				remove_product_memcache($product_query->fields['products_id']);
				$cnt++;
				$product_query->MoveNext();
			}
			echo $cnt;
			break;
	case 'unrelated':
			$cnt=0;
			$products_query = $db->Execute("select products_id,products_model,master_categories_id from ".TABLE_PRODUCTS." where products_status=1 order by products_id");
			while(!$products_query->EOF){
				$get_category = $db->Execute("select categories_id,first_categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$products_query->fields['products_id']."'");
				if($get_category->RecordCount()==0){
					echo $products_query->fields['products_model'].'<br/>';
					$cnt++;
				}elseif($get_category->RecordCount()==1&&($get_category->fields['first_categories_id']==2066||$get_category->fields['first_categories_id']==1705)){
					echo $products_query->fields['products_model'].'<br/>';
					$cnt++;
				}
				$products_query->MoveNext();
			}
			echo $cnt;
			break;
	case 'pandora':
				$cnt=0;
				for($j=2;$j<=$sheet->getHighestRow();$j++){
			
					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
					$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
					if($qty>30) {
						$qty = round($qty*0.5);
					}else{
						$qty = 0;
					}
					if($qty>0){
						$status=1;
					}else{
						$status=0;
						$qty = 0;
					}
						
					$db->Execute("update ".TABLE_PRODUCTS." set products_limit_stock = 1,products_status = ".$status.", products_quantity_order_max=".(int)$qty.",products_quantity=".(int)$qty."   where products_model='".$model."'");
					$cnt++;
				}
				echo $cnt;
			
				break;
	case 'stay':
				$cnt=0;
				for($j=2;$j<=$sheet->getHighestRow();$j++){
			
					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
					$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
					$erp_status = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
					$qty = round($qty*0.3);
					if($qty>0){
						$status=1;
					}else{
						$status=0;
						$qty = 0;
					}
					if($erp_status=="报废"){
						$status=0;
					}
					$db->Execute("update ".TABLE_PRODUCTS." set products_limit_stock = 1,products_status = ".$status.", products_quantity_order_max=".(int)$qty.",products_quantity=".(int)$qty."   where products_model='".$model."'");
					$cnt++;
				}
				echo $cnt;
			
		break;
		case 'p2c':
			$cnt=0;
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$c_arr = array();
				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
				$code = trim(zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue()));
				$pid = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
				$cid = $db->Execute("select parent_id,categories_id from ".TABLE_CATEGORIES." where categories_code='".$code."' and categories_code!=''");
				$cate_id = $cid->fields['categories_id'];
				$level = 1;
				$c_arr[] = $cate_id;
				if($cid->fields['parent_id']>0){
					$level++;
					$c_arr[] = $cid->fields['parent_id'];
					$top_query = $db->Execute("select parent_id from ".TABLE_CATEGORIES." where categories_id='".$cid->fields['parent_id']."'");
					if($top_query->fields['parent_id']>0){
						$level++;
						$c_arr[] = $top_query->fields['parent_id'];
					}
				}
				$first_level = $c_arr[sizeof($c_arr)-1];
				$second_level = $c_arr[sizeof($c_arr)-2];
				if($level==3)$third_level = $c_arr[sizeof($c_arr)-3];
				
				$check_exist = $db->Execute("select first_categories_id,products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$pid->fields['products_id']."' and categories_id='".$cate_id."'");
				if($pid->fields['products_id']>0 && ($check_exist->RecordCount()==0||($check_exist->RecordCount()==1&&$check_exist->fields['first_categories_id']==1705)||($check_exist->RecordCount()==1&&$check_exist->fields['first_categories_id']==2066))){
					$p2c_data = array(
							'products_id'=>$pid->fields['products_id'],
							'categories_id'=>$cate_id,
							'first_categories_id'=>$first_level,
							'second_categories_id'=>$second_level,
							'three_categories_id'=>$third_level
								
					);
					zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data);
					$db->Execute("update ".TABLE_PRODUCTS." set master_categories_id='".$cate_id."' where products_id='".$pid->fields['products_id']."'");
					$cnt++;
				}
			}
			echo $cnt;
		
			break;
		case "check_promotion":
				$cnt=0;
				$backorder_query = $db->Execute("select products_id,products_model from ".TABLE_PRODUCTS." where products_quantity=0 and products_status=1");
				while(!$backorder_query->EOF){
					$promotion_query = $db->Execute("select pp_id,pp_promotion_id from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id='".$backorder_query->fields['products_id']."'");
					if($promotion_query->RecordCount()>0){
						$db->Execute("delete from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id='".$backorder_query->fields['products_id']."'");
						$db->Execute("update ".TABLE_PRODUCTS." set products_is_perorder=0 where products_id=".$backorder_query->fields['products_id']);
						
						echo $backorder_query->fields['products_model'].'<br/>';
						$cnt++;
					}
					$backorder_query->MoveNext();
				}
			echo $cnt;
			break;
		case 'move_promotion':
				$cnt=0;
				for($j=2;$j<=$sheet->getHighestRow();$j++){
			
					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
					$promotion_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
					$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
					if($products_query->RecordCount()==0 || $promotion_id==0) continue;
					//echo "update ".TABLE_PROMOTION_PRODUCTS." set pp_promotion_id=".(int)$promotion_id."  where pp_products_id='".$products_query->fields['products_id']."';".'<br/>';
					//$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where first_categories_id=1705 and products_id=".$products_query->fields['products_id']);
					$db->Execute("update ".TABLE_PROMOTION_PRODUCTS." set pp_promotion_id=".(int)$promotion_id."  where pp_products_id='".$products_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS." set products_limit_stock=1 where products_id='".$products_query->fields['products_id']."'");
						
					$cnt++;
				}
				echo $cnt;
		break;
		case 'promotion_status':
			$cnt=0;
			for($j=2;$j<=$sheet->getHighestRow();$j++){
					
				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
					
				$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
				$status = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
				switch($status){
					case '活动':
						$products_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
						if($products_query->RecordCount()==0 ||$products_query->fields['products_status']>0) continue;
						$db->Execute("update ".TABLE_PRODUCTS." set products_status=1   where products_id='".$products_query->fields['products_id']."'");
							
				
					case '滞留':
				
					case '待报废':
					case '滞销':
				
						break;
				}
				/*
				$product_is_preorder = 0;
				$product_is_limit = 0;
				switch($status){
					case '活动':
					case '滞留':
						$product_is_preorder=1;
						break;
					case '待报废':
					case '滞销':
						$product_is_limit = 1;
						break;
				}
				$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
				if($products_query->RecordCount()==0) continue;
				if($qty<=0){
					$db->Execute("delete from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id=".$products_query->fields['products_id']);
		
				}
				$db->Execute("update ".TABLE_PRODUCTS." set products_limit_stock='".$product_is_limit."', products_is_perorder='".$product_is_preorder."'   where products_id='".$products_query->fields['products_id']."'");
				*/
				$cnt++;
			}
			echo $cnt;
				
			break;
		case 'move_seed':
				$cnt=0;
				$category_id =(int) $_GET['cid'];
				if(!$category_id){
					die('need category id');
				}
				for($j=2;$j<=$sheet->getHighestRow();$j++){
			
					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
					$old_category = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
					$new_category = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
					$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
					if(!$products_query->fields['products_id']) continue;
					$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$products_query->fields['products_id']."' and categories_id='".$category_id."'");
					if($check_exist->RecordCount()==0){
						$p2c_data_arr = array(
								'products_id'=>$products_query->fields['products_id'],
								'categories_id'=>$category_id,
								'first_categories_id'=>'1729',
								'second_categories_id'=>'1730',
								'three_categories_id'=>$category_id
						);
			
						zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data_arr);
			
					}
					$db->Execute("update ".TABLE_PRODUCTS." set master_categories_id = ".$category_id." where products_id='".$products_query->fields['products_id']."'");
			
					$cnt++;
				}
				echo $cnt;
				break;
			case 'mix_sale':
					for($j=2;$j<=$sheet->getHighestRow();$j++){
						$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
						$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
						if(!$products_query->fields['products_id']) continue;
						$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$products_query->fields['products_id']."' and categories_id='2376'");
						if($check_exist->RecordCount()==0){
							$p2c_data_arr = array(
									'products_id'=>$products_query->fields['products_id'],
									'categories_id'=>2376,
									'first_categories_id'=>'2066',
									'second_categories_id'=>'2376'
				
							);
								
							zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data_arr);
							$cnt++;
						}
					}
					echo $cnt;
					break;
			case 'promotion_qty':
						$cnt=0;
						for($j=2;$j<=$sheet->getHighestRow();$j++){
					
							$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
							$qty = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
					
							$qty = round($qty*0.3);
								
							$db->Execute("update ".TABLE_PRODUCTS." set products_quantity_order_max=".(int)$qty.",products_quantity=".(int)$qty.",products_is_perorder=1   where products_model='".$model."'");
							$cnt++;
						}
						echo $cnt;
					
						break;
						case 'is_preorder':
							$cnt=0;
							$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where  products_is_perorder=1");
							while(!$products_query->EOF){
								$check_promotion = $db->Execute("select pp_promotion_id from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id='".$products_query->fields['products_id']."'");
								if($check_promotion->RecordCount()==0){
									$db->Execute("update ".TABLE_PRODUCTS." set products_is_perorder=0 where products_id='".$products_query->fields['products_id']."'");
									$cnt++;
								}
									
								$products_query->MoveNext();
							}
							echo $cnt;
							break;
		case 'move_rhine':
								$cnt=0;
								for($j=2;$j<=$sheet->getHighestRow();$j++){
							
									$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
									$old_category = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
									$new_category = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
									$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
									$old_cate_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$old_category."'")	;
									$new_cate_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$new_category."'")	;
							
									if(!$products_query->fields['products_id'] || !$new_cate_query->fields['categories_id']) continue;
									$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id='".$old_cate_query->fields['categories_id']."' and products_id='".$products_query->fields['products_id']."'");
									$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$products_query->fields['products_id']."' and categories_id='".$new_cate_query->fields['categories_id']."'");
									if($check_exist->RecordCount()==0){
										$p2c_data_arr = array(
												'products_id'=>$products_query->fields['products_id'],
												'categories_id'=>$new_cate_query->fields['categories_id'],
												'first_categories_id'=>'1729',
												'second_categories_id'=>'2386',
												'three_categories_id'=>$new_cate_query->fields['categories_id']
							
										);
							
										zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data_arr);
							
									}
									$db->Execute("update ".TABLE_PRODUCTS." set master_categories_id =".(int)$new_cate_query->fields['categories_id']."  where products_id='".$products_query->fields['products_id']."'");
							
									$cnt++;
								}
								echo $cnt;
								break;
		case 'move_pandora':
									$cnt=0;
									for($j=2;$j<=$sheet->getHighestRow();$j++){
								
										$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
										$old_category = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
										$new_category = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
										$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
										$old_cate_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$old_category."'")	;
										$new_cate_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$new_category."'")	;
								
										if(!$products_query->fields['products_id'] || !$new_cate_query->fields['categories_id']) continue;
										$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id='".$old_cate_query->fields['categories_id']."' and products_id='".$products_query->fields['products_id']."'");
										$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id='".$products_query->fields['products_id']."' and categories_id='".$new_cate_query->fields['categories_id']."'");
										if($check_exist->RecordCount()==0){
											$p2c_data_arr = array(
													'products_id'=>$products_query->fields['products_id'],
													'categories_id'=>$new_cate_query->fields['categories_id'],
													'first_categories_id'=>'1729',
													'second_categories_id'=>'1762',
													'three_categories_id'=>$new_cate_query->fields['categories_id']
											);
												
											zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data_arr);
								
										}
										$db->Execute("update ".TABLE_PRODUCTS." set master_categories_id =".(int)$new_cate_query->fields['categories_id']."  where products_id='".$products_query->fields['products_id']."'");
								
										$cnt++;
									}
									echo $cnt;
									break;
		case 'remove_repeat':
			$cnt=0;
			for($j=2;$j<=$sheet->getHighestRow();$j++){			
				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
				$product_query = $db->Execute("select products_id,master_categories_id from ".TABLE_PRODUCTS." where products_model='".$model."' order by master_categories_id,products_id desc");
				$p_count=$product_query->RecordCount();
				if($product_query->RecordCount()>1){					
					while(!$product_query->EOF){
						remove_product_memcache($product_query->fields['products_id']);
						if($product_query->fields['master_categories_id']==0){
							$check_categ = $db->Execute("select categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']);
							if($check_categ->RecordCount()==0){
								$sql = "delete from ".TABLE_PRODUCTS." where products_id=".$product_query->fields['products_id'];
								$db->Execute($sql);
								echo $sql.';<br>';						
								$p_count = $p_count-1;
								$cnt++;
							}else{
								$categ_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_id=".$check_categ->fields['categories_id']);
								if($categ_query->RecordCount()==0){
									$sql = "delete from ".TABLE_PRODUCTS." where products_id=".$product_query->fields['products_id'];
									$db->Execute($sql);
									echo $sql.';<br>';
									$p_count = $p_count-1;
									$cnt++;
								}
							}
							
						}elseif($p_count>1){
							$sql = "delete from ".TABLE_PRODUCTS." where products_id=".$product_query->fields['products_id'];
							$db->Execute($sql);
							echo $sql.';<br>';
							$p_count = $p_count-1;
							$cnt++;
						}
						$product_query->MoveNext();
					}
					
				}				
			}
			echo $cnt;
			break;
	default:
			echo 'invalid action';
			break;
}
?>