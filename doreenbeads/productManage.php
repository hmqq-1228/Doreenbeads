<?php
@set_time_limit ( 600 );
require('includes/application_top.php');
define('RESULT_SUCCESS', '1');
define('RESULT_FAILED', '0');
class productManage {
	
	public function apiUpdateProductStatus ( $xmlFile ) {
		global $db;
		try{
			if($xmlFile=='') return RESULT_FAILED;
			$file_name = 'log/erpProductStatus/'.time().'_'.rand(1,1000).'.xml';
			file_put_contents($file_name, $xmlFile);

			if(filesize($file_name)>0){
				$task_data = array(
						'receive_file'=>$file_name,
						'status'=>0,
						'receive_time'=> date('Y-m-d H:i:s')				
				);
				zen_db_perform('t_products_status_logs', $task_data);
				return RESULT_SUCCESS;
			}else{
				return RESULT_FAILED;
			}
			/*
			$xml = simplexml_load_string($xmlFile);
			
			$pid_list = '';
			$i = 0;
			foreach($xml->product as $product){
				$products_model = $product->model;
				$check_product = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$products_model."'");
				if($check_product->RecordCount()==0) continue;
				$action = $product->action; 
				switch ($action){
					case 0:
						$sql = "update ".TABLE_PRODUCTS." set products_status=0 where products_id='".$check_product->fields['products_id']."'";
						break;
					case 1:
						$sql = "update ".TABLE_PRODUCTS." set products_status=1, products_quantity=0, products_limit_stock=0 where products_id='".$check_product->fields['products_id']."'";
						break;
					case 2:
						$sql = "update ".TABLE_PRODUCTS." set products_status=1, products_quantity=0, products_limit_stock=0 where products_id='".$check_product->fields['products_id']."'";
						break;
				}
				//$db->Execute($sql);
				$pid_list.=$products_model.', ';
				$i++;
			}
			if($i>0){
				$res = RESULT_SUCCESS;
			}else{
				$res = RESULT_FAILED;
			}
			return $res;
			*/
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	
	public function apiProductStock($xmlData){
		global $db;
		try{
			if($xmlData=='') return RESULT_FAILED;
			$task_data = array(
					'receive_data'=>$xmlData,
					'status'=>0,
					'receive_time'=> date('Y-m-d H:i:s'),
					'type' => 'quantity'
	
			);
			//zen_db_perform('t_products_status_logs', $task_data);
			//$check_exist = $db->Execute("select log_id from t_products_status_logs where receive_data='".$xmlData."'");
					
			$xml = simplexml_load_string($xmlData);
				
			$pid_list = '';
			$i = 0;
			$get_time = $xml->createTime;
			foreach($xml->products->product as $product){
				$products_model = $product->productNo;
				$product_quantity = $product->quantity;
				$status = $product->status;
				$alarmStock = $product->alarmStock;
				$readyTime = $product->readyDays;
				$arrivalDate = $product->arriveDate;
				$stock_data_arr = array(
						'products_model'=>$products_model,
						'products_quantity'=>$product_quantity,
						'products_status'=>$status,
						'is_processed'=>0,
						'alarm_stock'=>$alarmStock,
						'ready_days'=>$readyTime,
						'arrival_date' => $arrivalDate,
						'date_added' => date('Y-m-d H:i:s')
				);
				$check_exist = $db->Execute("select data_id from t_stock_manager where products_model='".$products_model."'");
				if($check_exist->fields['data_id']>0){
					zen_db_perform('t_stock_manager', $stock_data_arr,'update',"data_id='".$check_exist->fields['data_id']."'");
				}else{
					zen_db_perform('t_stock_manager', $stock_data_arr);
				}
				//$pid_list.=$products_model.', ';
				$i++;
			}
			if($i>0){
				$res = RESULT_SUCCESS;
			}else{
				$res = RESULT_FAILED;
			}
			return $res;
				
		}catch(Exception $e){
			return $e->getMessage();
		}
			
	}
		
	public function helloWorld(){
		return 'Hello dorabeads';
	}
	
}
ini_set ('soap.wsdl_cache_enabled', 0);
$server = new SoapServer('productManage.wsdl', array('soap_version' => SOAP_1_2));

$server->setClass("productManage");
$server->handle();
?>