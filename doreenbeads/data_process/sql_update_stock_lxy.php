<?php 
chdir("../");
require_once("includes/application_top.php");
require("includes/access_ip_limit.php");
@ini_set('display_errors', '1');
set_time_limit(3600);
ini_set('memory_limit','2048M');
global $db;

if(! isset($_POST['action']) || ! isset($_FILES['csvFile'])) die('please select a type or upload the csv file!');
if(! $_POST['action']) die('please select a type!');
if(! $_FILES['csvFile']) die('please upload the csv file!');
/*if($_FILES['csvFile']['type'] != 'application/vnd.ms-excel' && $_FILES['csvFile']['type'] != 'text/csv' && $_FILES['csvFile']['type'] != 'application/x-octet-stream') die($_FILES['csvFile']['type'].'file type error!please upload a csv file!');
*/
$action = trim($_POST['action']);
$csvFile = $_FILES['csvFile']['tmp_name'];

$handle = fopen($csvFile, 'r');
$products = array();
$n = 0;
while ($data = fgetcsv($handle)) {
	if($n++ == 0) continue;
	$products[] = $data;
}

switch($action){
	case 'normal':
		$cnt=0;
		foreach($products as $i=>$product){
			$model = zen_db_prepare_input($product[0]);
			$qty = 50000;
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 0.6;
			$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10 limit 1");
			if($product_query->fields['products_id']>0){
				$check_promotion = $db->Execute("select pp_promotion_id from ".TABLE_PROMOTION_PRODUCTS." zpp INNER JOIN " . TABLE_PROMOTION . " zp on zpp.pp_promotion_id = zp.promotion_id where pp_products_id='".$product_query->fields['products_id']."' and zp.promotion_status = 1 and pp_is_forbid = 10 and pp_promotion_start_time <= now() and pp_promotion_end_time > now()");
				if($check_promotion->RecordCount() > 0){
						$qty = floor(zen_db_prepare_input($product[1]) * $stock_percent);
				}
				$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1 ,products_limit_stock = 0,is_sold_out=0,products_is_perorder = 0,products_quantity_order_max = 50000 where products_id='".$product_query->fields['products_id']."'");	
				$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");			
				if($product_query->fields['products_status']==0){
					remove_product_memcache($product_query->fields['products_id']); 
				}
				$cnt++;		
			}else{
				echo 'line '.($i+2).' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt.' success';
		break;

	case 'invalid':
		$cnt=0;
		foreach($products as $i=>$product){
			$model = zen_db_prepare_input($product[0]);
			$qty = zen_db_prepare_input($product[1]);
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 0.6;
			$qty = floor($qty * $stock_percent);
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
			if($product_query->RecordCount()>0){
			  while(!$product_query->EOF){
				remove_product_memcache($product_query->fields['products_id']);
				$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
				if($check_s_level->RecordCount()==0){
					$db->Execute("update ".TABLE_PRODUCTS." set products_status = 0  where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");

					if($qty==0){
						$check_products_promotion_status_sql = 'SELECT zpp.pp_id FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zpp.pp_promotion_start_time < now() AND zpp.pp_promotion_end_time > now() and zp.promotion_status = 1 and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . ( int ) $product_query->fields['products_id'];
						$check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);
							
						if($check_products_promotion_status_query->RecordCount() > 0){
							while(!$check_products_promotion_status_query->EOF){
								$pp_id = $check_products_promotion_status_query->fields['pp_id'];
								$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 WHERE pp_id = ' . $pp_id);
									
								$check_products_promotion_status_query->MoveNext();
							}
						}
							
						$check_products_deals_status_sql = 'SELECT zdp.dailydeal_promotion_id from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . ( int ) $product_query->fields['products_id'];
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
					echo $model.' droped <br/>';
					$cnt++;
				}
				$product_query->MoveNext();
			  }
			}else{
				echo 'line '.($i+2).' --- '.$model.' not existed <br/>';
			}
			
		}
		echo $cnt.' success';
		break;

	case 'preorder':
		$cnt=0;
		foreach($products as $i=>$product){
			$model = zen_db_prepare_input($product[0]);
			$qty = zen_db_prepare_input($product[1]);
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 0.6;
			$qty = floor($qty * $stock_percent);
			if($qty<0)$qty=0;
			$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10 limit 1");
			if($product_query->fields['products_id']>0){
				$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
				if($check_s_level->RecordCount()==0){
					$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1,products_limit_stock = 0,products_is_perorder=0 ,is_sold_out=0  where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");				
					$cnt++;
				}
				if($qty==0){
					$check_products_promotion_status_sql = 'SELECT zpp.pp_id FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zpp.pp_promotion_start_time < now() AND zpp.pp_promotion_end_time > now() and zp.promotion_status = 1 and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . ( int ) $product_query->fields['products_id'];
					$check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);
						
					if($check_products_promotion_status_query->RecordCount() > 0){
						while(!$check_products_promotion_status_query->EOF){
							$pp_id = $check_products_promotion_status_query->fields['pp_id'];
							$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 WHERE pp_id = ' . $pp_id);
								
							$check_products_promotion_status_query->MoveNext();
						}
					}
						
					$check_products_deals_status_sql = 'SELECT zdp.dailydeal_promotion_id from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . ( int ) $product_query->fields['products_id'];
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
				echo 'line '.($i+2).' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt.' success';
		break;	

	case 'limit_stock':
		$cnt=0;
		foreach($products as $i=>$product){
			$model = zen_db_prepare_input($product[0]);
			$qty = zen_db_prepare_input($product[1]);
			$stock_percent = 0.3;
			if(substr($model, -1)=='S') $stock_percent = 0.6;
			$qty = floor($qty * $stock_percent);
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
						$check_products_promotion_status_sql = 'SELECT zpp.pp_id FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zpp.pp_promotion_start_time < now() AND zpp.pp_promotion_end_time > now() and zp.promotion_status = 1 and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . ( int ) $product_query->fields['products_id'];
						$check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);
							
						if($check_products_promotion_status_query->RecordCount() > 0){
							while(!$check_products_promotion_status_query->EOF){
								$pp_id = $check_products_promotion_status_query->fields['pp_id'];
								$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 WHERE pp_id = ' . $pp_id);
									
								$check_products_promotion_status_query->MoveNext();
							}
						}
							
						$check_products_deals_status_sql = 'SELECT zdp.dailydeal_promotion_id from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . ( int ) $product_query->fields['products_id'];
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
				echo 'line '.($i+2).' --- '.$model.' not existed <br/>';
			}
		}
		echo $cnt.' success';
		break;	

	default:
		echo 'invalid action';
		break;
}
?>
