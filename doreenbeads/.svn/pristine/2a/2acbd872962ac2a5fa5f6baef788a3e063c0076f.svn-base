<?php
require('includes/application_top.php');
global $db;
@set_time_limit(3600);
$process_type = 'status';
if(isset($_GET['action']) && $_GET['action']!=''){
	$process_type = $_GET['action'];
}
switch($process_type){
	case 'status':
		$task_query = $db->Execute("select log_id, receive_file from t_products_status_logs where status=0");
		while(!$task_query->EOF){
			$file_data = @file_get_contents($task_query->fields['receive_file']);
      
	  		$xml = simplexml_load_string($file_data);
		
			$pid_list = '';
			$i = 0;
			foreach($xml->product as $product){
				$products_model = $product->model;
				$check_product = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$products_model."'");
				if($check_product->RecordCount()==0) continue;
				$product_id = $check_product->fields['products_id'];
				$action = $product->action;
				//0:inactive, 1:preorder, 2:sold out
				switch ($action){
					case 0:
						$sql = "update ".TABLE_PRODUCTS." set products_status=0 where products_id='".$product_id."'";
						break;
					case 1:
						$sql = "update ".TABLE_PRODUCTS." set products_status=1,  products_limit_stock=0,is_sold_out=0 where products_id='".$product_id."'";
						$sql_stock = "update " .TABLE_PRODUCTS_STOCK. " set products_quantity=0, modify_time = :now where products_id = " . $product_id;
						$sql_stock = $db->bindVars($sql_stock, ':now', strtotime('now'), 'integer');
						$db->Execute($sql_stock);						
						break;
					case 2:
						$sql = "update ".TABLE_PRODUCTS." set products_status=1,  products_limit_stock=0,is_sold_out=1 where products_id='".$product_id."'";
						$sql_stock = "update " .TABLE_PRODUCTS_STOCK. " set products_quantity=0, modify_time = :now where products_id = " . $product_id;
						$sql_stock = $db->bindVars($sql_stock, ':now', strtotime('now'), 'integer');
						$db->Execute($sql_stock);
						break;
				}
				$db->Execute($sql);
		
				$solr_task_data = array(
					'products_id' => $product_id,
					'type' => 'status',
					'weight' => 100,
					'status' => 0,
					'date_added' => date('Y-m-d H:i:s')							
				);
				zen_db_perform('t_solr_logs', $solr_task_data);
				$pid_list.=$products_model.', ';
				$i++;
			}
	
		$db->Execute("update t_products_status_logs set status=1, process_time='".date('Y-m-d H:i:s')."' where log_id='".$task_query->fields['log_id']."'");
		$task_query->MoveNext();
	}
	break;
	
	case 'quantity':
		$task_query = $db->Execute("select data_id, products_model, products_quantity, products_status, ready_days, arrival_date from t_stock_manager where is_processed=0 order by data_id limit 1000");
		while(!$task_query->EOF){
			$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$task_query->fields['products_model']."' limit 1");
			//$check_exist = $db->Execute("select products_id from zen_products_autorun where products_model='".$task_query->fields['products_model']."' limit 1");
	
			if($check_exist->fields['products_id']>0){
				$release_qty = 0;
				$products_id = $check_exist->fields['products_id'];
				$products_status = strtoupper($task_query->fields['products_status']);
				$product_available = 1;
				//check if binded to customers
				$check_binded = $db->Execute("select customers_id from ".TABLE_MY_PRODUCTS." where products_id='".$products_id."'");
				if($check_binded->fields['customers_id']>0){
					$products_status = 'X';
					$product_available = 0;
				}
				switch ($products_status){
					case 'A':
					case 'V':
						//$release_qty = get_release_quantity($products_id);
						$processing_qty = get_quantity_processing($products_id);
						$available_quantity = $task_query->fields['products_quantity']+$release_qty-$processing_qty;
						if($available_quantity>0){
							//$db->Execute("update ".TABLE_PRODUCTS." set products_quantity='".$available_quantity."', products_status=1, products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
							$db->Execute("update t_products_autorun set products_quantity='".$available_quantity."', products_status=1, products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
								
						}else{
							$available_quantity = 0;
							if($task_query->fields['arrival_date']!='' && strtotime($task_query->fields['arrival_date'])>time()){
								if(strtotime($task_query->fields['arrival_date'])-time()<=86400*2){
									$available_quantity = 50000;
								}elseif(strtotime($task_query->fields['arrival_date'])-time()>86400*120){
									$product_available = 0;
								}
							}
							/*elseif($task_query->fields['ready_days']>0){
							 if($task_query->fields['ready_days']<2){
							$available_quantity = 5000;
							}elseif($task_query->fields['ready_days']>30){
							$product_available = 0;
							}
							}*/
								
								
							//$db->Execute("update ".TABLE_PRODUCTS." set products_quantity='".$available_quantity."', products_status='".$product_available."', products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
							$db->Execute("update t_products_autorun set products_quantity='".$available_quantity."', products_status='".$product_available."', products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
								
						}
						break;
					case 'X':
					case 'R':
					case 'N':
						$product_available = 0;
						$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id='".(int)$products_id."'");
						$db->Execute("update t_products_autorun set products_quantity='".$available_quantity."', products_status='".$product_available."', products_limit_stock=0 where products_id='".(int)$products_id."'");
							
						break;
					case 'U':
					case 'P':
						//$release_qty = get_release_quantity($products_id);
						$processing_qty = get_quantity_processing($products_id);
						$available_quantity = $task_query->fields['products_quantity']+$release_qty-$processing_qty;
						if($available_quantity>0){
							$db->Execute("update ".TABLE_PRODUCTS." set products_quantity='".$available_quantity."', products_status=1, products_limit_stock=1,is_sold_out=0 where products_id='".(int)$products_id."'");
							$db->Execute("update t_products_autorun set products_quantity='".$available_quantity."', products_status='".$product_available."', products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
								
						}else{
							$product_available = 0;
							//$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id='".(int)$products_id."'");
							$db->Execute("update t_products_autorun set products_quantity='".$available_quantity."', products_status='".$product_available."', products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
	
						}
						break;
					case 'L':
						$available_quantity = 0;
						if($task_query->fields['arrival_date']!='' && strtotime($task_query->fields['arrival_date'])-time()>86400*120){
							$product_available = 0;
						}
						//$db->Execute("update ".TABLE_PRODUCTS." set products_quantity=0, products_status='".$product_available."', products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
						$db->Execute("update t_products_autorun set products_quantity='".$available_quantity."', products_status='".$product_available."', products_limit_stock=0,is_sold_out=0 where products_id='".(int)$products_id."'");
							
						break;
					default:
						break;
				}
	
				$solr_task_data = array(
						'products_id' => $products_id,
						'type' => 'status',
						'weight' => 100,
						'status' => 0,
						'date_added' => date('Y-m-d H:i:s')
	
				);
				//zen_db_perform('zen_solr_logs', $solr_task_data);
	
			}
			$db->Execute("update t_stock_manager set products_id='".$products_id."', is_processed=1, processed_time='".date('Y-m-d H:i:s')."' where  data_id='".$task_query->fields['data_id']."'");
			$task_query->MoveNext();
		}
		break;
	case 'collect':
		$i=0;
		//uncollected orders
		$paid_order_query = $db->Execute("select orders_id,customers_email_address,is_exported from ".TABLE_ORDERS." where orders_status=2 and data_process=0 limit 100");
		while(!$paid_order_query->EOF){
			if(!stristr($paid_order_query->fields['customers_email_address'], 'panduo.com')){
				$process_type=1;
				if($paid_order_query->fields['is_exported']==1){
					$process_type=2;
				}
				$order_products_query = $db->Execute("select products_id, products_model,products_quantity from ".TABLE_ORDERS_PRODUCTS." where orders_id='".$paid_order_query->fields['orders_id']."'");
				while(!$order_products_query->EOF){
					$paid_qty = $order_products_query->fields['products_quantity'];
					if($paid_order_query->fields['is_exported']==1){
						$exported_qty=$order_products_query->fields['products_quantity'];
					}else{
						$exported_qty=0;
					}
					$check_existed = $db->Execute("select data_id from t_stock_correct where products_id='".$order_products_query->fields['products_id']."'");
					if($check_existed->fields['data_id']>0){
						$db->Execute("update t_stock_correct set paid_qty=paid_qty+".$paid_qty.", exported_qty=exported_qty+".$exported_qty." where products_id='".$order_products_query->fields['products_id']."'");
					}else{
						$sql_data_arr = array(
								'products_id'=>$order_products_query->fields['products_id'],
								'products_model'=>$order_products_query->fields['products_model'],
								'paid_qty'=>$paid_qty,
								'exported_qty'=>$exported_qty
						);
						zen_db_perform('t_stock_correct', $sql_data_arr);
					}
					$i++;
					$order_products_query->MoveNext();
				}
				$db->Execute("update ".TABLE_ORDERS." set data_process='".$process_type."' where orders_id='".$paid_order_query->fields['orders_id']."'");
			}else{
				$db->Execute("update ".TABLE_ORDERS." set data_process=2 where orders_id='".$paid_order_query->fields['orders_id']."'");
			}
			$paid_order_query->MoveNext();
		}
		//exported orders
		$export_order_query = $db->Execute("select orders_id,customers_email_address from ".TABLE_ORDERS." where orders_status=2 and is_exported=1 and data_process=1 limit 100");
		while(!$export_order_query->EOF){
			if(!stristr($export_order_query->fields['customers_email_address'], 'panduo.com')){
	
				$order_products_query = $db->Execute("select products_id,products_quantity from ".TABLE_ORDERS_PRODUCTS." where orders_id='".$export_order_query->fields['orders_id']."'");
				while(!$order_products_query->EOF){
					$db->Execute("update t_stock_correct set exported_qty=exported_qty+".$order_products_query->fields['products_quantity']." where products_id='".$order_products_query->fields['products_id']."'");
					$i++;
					$order_products_query->MoveNext();
				}
			}
			$db->Execute("update ".TABLE_ORDERS." set data_process=2 where orders_id='".$export_order_query->fields['orders_id']."'");
	
			$export_order_query->MoveNext();
		}
		echo $i;
		break;
	case 'reset':
		if(date('H')<17){
			$db->Execute("update t_stock_correct set paid_qty=0,exported_qty=0");
			$paid_order_query = $db->Execute("select orders_id,customers_email_address,is_exported from ".TABLE_ORDERS." where orders_status=2 and is_exported=0 and data_process<2 limit 1000");
			while(!$paid_order_query->EOF){
				if(!stristr($paid_order_query->fields['customers_email_address'], 'panduo.com')){
						
					$order_products_query = $db->Execute("select products_id, products_model,products_quantity from ".TABLE_ORDERS_PRODUCTS." where orders_id='".$paid_order_query->fields['orders_id']."'");
					while(!$order_products_query->EOF){
						$paid_qty = $order_products_query->fields['products_quantity'];
	
						$check_existed = $db->Execute("select data_id from t_stock_correct where products_id='".$order_products_query->fields['products_id']."'");
						if($check_existed->fields['data_id']>0){
							$db->Execute("update t_stock_correct set paid_qty=paid_qty+".$paid_qty." where products_id='".$order_products_query->fields['products_id']."'");
						}else{
							$sql_data_arr = array(
									'products_id'=>$order_products_query->fields['products_id'],
									'products_model'=>$order_products_query->fields['products_model'],
									'paid_qty'=>$paid_qty,
									'exported_qty'=>0
							);
							zen_db_perform('t_stock_correct', $sql_data_arr);
						}
						$order_products_query->MoveNext();
					}
					$db->Execute("update ".TABLE_ORDERS." set data_process=1 where orders_id='".$paid_order_query->fields['orders_id']."'");
				}else{
					$db->Execute("update ".TABLE_ORDERS." set data_process=2 where orders_id='".$paid_order_query->fields['orders_id']."'");
				}
				$paid_order_query->MoveNext();
			}
		}
		break;
}

function get_release_quantity($products_id){
	global $db;
	$exlude_str = " and o.customers_email_address not like '%panduo.com.cn'";
	$orders_query = $db->Execute("select o.orders_id,o.customers_id,date_purchased ,op.products_quantity
					from t_orders o, t_orders_products op
					where o.orders_id=op.orders_id
					and  op.products_id =".(int)$products_id."
					and o.orders_status=1".$exlude_str);
	$release_qty=0;
	while(!$orders_query->EOF){
		$check_valid_order = $db->Execute("select orders_id from t_orders where customers_id='".$orders_query->fields['customers_id']."' and orders_status>1 limit 1");
		if($check_valid_order->fields['orders_id']>0){
			$restore_day = 5;
		}else{
			$restore_day = 3;
		}
		if(strtotime($orders_query->fields['date_purchased'])+86400*$restore_day < time()) $release_qty+=$orders_query->fields['products_quantity'];
		$orders_query->MoveNext();
	}

	return $release_qty;
}

function get_quantity_processing($products_id){
	global $db;
	$correct_query = $db->Execute("select paid_qty,exported_qty from t_stock_correct where products_id='".(int)$products_id."'");

	$process_qty = 0;
	if($correct_query->fields['paid_qty']>0){
		$process_qty = $correct_query->fields['paid_qty']-$correct_query->fields['exported_qty'];
	}

	return $process_qty;
}
?>