<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'download') {
	
	$date_now = date("Ymd");
	$hour = date("H");
	$extract_dir = "file/products_stock/";
	
	if($hour < 16){
	    $suffix = '11';
	}else{
	    $suffix = '17';
	}

    if(!isset($_GET['debug']) || $_GET['debug'] != 'true') {
        $filename = download_file(HTTP_ERP_URL . "/download/erp_products_stock_doreenbeads_" . $date_now . $suffix . ".zip", $extract_dir, "erp_products_stock_doreenbeads_" . $date_now . $suffix . ".zip", true);
    }

	$zip = new ZipArchive;
	if($zip->open($extract_dir . "erp_products_stock_doreenbeads_" . $date_now . $suffix . ".zip") === true) {
		$zip->extractTo($extract_dir);
	}

	if(is_file($extract_dir . "doreenbeads_erp_products_stock_" . $date_now . $suffix . ".txt")) {
		$db->begin();
		
		$prod_group = file_get_contents($extract_dir . "doreenbeads_erp_products_stock_" . $date_now . $suffix . ".txt");

		$prod_group_array = explode("\r\n", $prod_group);
		//Tianwen.Wan20170908->如果用truncate事务会失效

		for($index = 1; $index < count($prod_group_array); $index++) {
			$product = explode("|^", $prod_group_array[$index]);
			$model = zen_db_prepare_input($product[0]);
			$qty = zen_db_prepare_input($product[1]);
			if($product[2] == "A") {
				$qty = 50000;

                if (substr($model, 0, 1) != 'D'){
                    if(substr($model, -1)=='S'){
                        $stock_percent = 0.6;
                        $qty = floor(zen_db_prepare_input($product[1]) * $stock_percent);
                    }
                }else{
                    $stock_percent = 0.3;
                    $qty = floor(zen_db_prepare_input($product[1]) * $stock_percent);
                }

				$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10 limit 1");
				if($product_query->fields['products_id']>0){
					$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1 ,products_limit_stock = 0,is_sold_out=0,products_is_perorder = 0,products_quantity_order_max = 50000 where products_id='".$product_query->fields['products_id']."'");
					$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");

					if($qty != 0){
                        zen_auto_update_promotion_products_status($product_query->fields['products_id'] , true);
                    }else{
					    //backorder商品 不更新pp_is_forbid为20 cm add
                       // zen_auto_update_promotion_products_status($product_query->fields['products_id']);
                    }
					if($product_query->fields['products_status']==0){
						remove_product_memcache($product_query->fields['products_id']); 
					}
					$cnt++;		
				}
			
			} else if($product[2] == "S") {
				$stock_percent = 0.3;
                if (substr($model, 0, 1) != 'D'){
                    if(substr($model, -1)=='S') {
                        $stock_percent = 0.6;
                    }else{
                        if(substr($model, -1) == 'H' || substr($model, -1) == 'Q'){
                            $stock_percent = 1;
                        }
                    }
                }

				$qty = floor($qty * $stock_percent);
				if($qty<0)$qty=0;
				$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10 limit 1");
				if($product_query->fields['products_id']>0){
					$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
					if($check_s_level->RecordCount()==0){
						$db->Execute("update ".TABLE_PRODUCTS." set products_status = 1,products_limit_stock = 0,products_is_perorder=0 ,is_sold_out=0  where products_id='".$product_query->fields['products_id']."'");
						$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");

						if($qty != 0){
                            zen_auto_update_promotion_products_status($product_query->fields['products_id'] , true);
                        }else{
                            //backorder商品 不更新pp_is_forbid为20 cm add
                            //zen_auto_update_promotion_products_status($product_query->fields['products_id']);
                        }
						$cnt++;
					}

					if($product_query->fields['products_status']==0){
						remove_product_memcache($product_query->fields['products_id']);
					}
				}
			} else if($product[2] == "U") {
				$stock_percent = 0.3;
                if (substr($model, 0, 1) != 'D') {
                    if(substr($model, -1) == 'H' || substr($model, -1) == 'Q'){
                        $stock_percent = 1;
                    }else{
                        if ($qty <= 3) {
                            $stock_percent = 1;
                        } else {
                            if (substr($model, -1) == 'S') {
                                $stock_percent = 0.6;
                            }
                        }
                    }

                }
				
				$qty = floor($qty * $stock_percent);
				if($qty>0){
					$status=1;
				}else{
					$status=0;
					$qty = 0;
				}
				$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10 limit 1");
				if($product_query->fields['products_id']>0){	
					$check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
					if($check_s_level->RecordCount()==0){				
						$db->Execute("update ".TABLE_PRODUCTS." set products_limit_stock = 1,products_is_perorder=1,products_status = ".$status.", products_quantity_order_max=".(int)$qty."  where products_id='".$product_query->fields['products_id']."'");
						$db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");

						if($qty != 0){
                            zen_auto_update_promotion_products_status($product_query->fields['products_id'] , true);
                        }else{
                            zen_auto_update_promotion_products_status($product_query->fields['products_id']);
                        }
						if($product_query->fields['products_status']==0 && $status==1){
							remove_product_memcache($product_query->fields['products_id']);
						}
						$cnt++;
					}
				}
			} else if($product[2] == "R") {
				$stock_percent = 0.3;
                if (substr($model, 0, 1) != 'D'){
                    if(substr($model, -1)=='S'){
                        $stock_percent = 0.6;
                    }
                }

				$qty = floor($qty * $stock_percent);
				$product_query = $db->Execute("select products_id,products_limit_stock from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10");
				if($product_query->RecordCount()>0){
				  while(!$product_query->EOF){
                      remove_product_memcache($product_query->fields['products_id']);

                      /*
                      * 需求编号：1303
                      * 需求内容：
                      * 在网站执行更新库存定时任务时，根据获取到的ERP库存更新文件中的数据，将【不更新库存管理】需要下架商品状态更新为R。
                      * 例如：ERP给出的库存同步文件中A商品状态为R（下架），A在【不更新库存管理】中，此时，更新A的状态为R，使A从前台下架，同时将A自动从【不更新库存管理】中删除。
                      */

                      $db->Execute("update ".TABLE_PRODUCTS." set products_status = 0  where products_id='".$product_query->fields['products_id']."'");
                      $db->Execute("update ".TABLE_PRODUCTS_STOCK." set products_quantity = ".(int)$qty.", modify_time='".time()."' where products_id='".$product_query->fields['products_id']."'");

                      if($qty != 0){
                          zen_auto_update_promotion_products_status($product_query->fields['products_id'] , true);
                      }else{
                          //backorder商品 不更新pp_is_forbid为20 cm add
                          //zen_auto_update_promotion_products_status($product_query->fields['products_id']);
                          if($product_query->fields['products_limit_stock']  == 1 ){
                              zen_auto_update_promotion_products_status($product_query->fields['products_id']);
                          }

                      }
                      echo $model.' droped <br/>';
                      $cnt++;

                      //防止不必要的操作记录入库 故先查询一次也无妨
                      $check_s_level = $db->Execute("select products_model from t_products_s_level where products_id=".$product_query->fields['products_id']);
                      if($check_s_level->RecordCount() !=0){
                          $sql = "delete FROM " . TABLE_PRODUCTS_S_LEVEL . " WHERE products_model = :products_model limit 1";
                          $sql = $db->bindVars($sql, ':products_model', $model, 'string');
                          $result = $db->Execute($sql);
                          $operate_content = '更新库存定时任务时状态为R则删除不更新库存商品: ' . $model;
                          zen_insert_operate_logs(0, $model, $operate_content, 2);
                      }
                      $product_query->MoveNext();
				  }
				}
			}
		}
		
		$db->commit();
		unlink($extract_dir . "doreenbeads_erp_products_stock_" . $date_now . $suffix . ".txt");
	}
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>