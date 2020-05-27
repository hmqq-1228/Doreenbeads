<?php 
chdir("../");
require_once("includes/application_top.php");
require("includes/access_ip_limit.php");
@ini_set('display_errors', '1');
set_time_limit(7200);
ini_set('memory_limit','1024M');
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
			
	
	case 'update_price':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$net_price = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$price_times = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
				
			$products_query = $db->Execute("select products_id,products_price,products_weight,product_price_times from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
			if(!$products_query->fields['products_id'] || !$net_price || !$price_times){				
				continue;
			}
			
			$res = zen_refresh_products_price_new ( $products_query->fields['products_id'] ,$net_price ,$products_query->fields['products_weight'], $price_times );
			
			if($res)
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
		$price_manager_id = $db->Execute('select products_price,price_manager_id from ' . TABLE_PRODUCTS . ' where products_id = ' . $as_product_id . ' limit 1');
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
		
		if( $ldc_price==0){
			echo $model.'<br/>';
			return false;
		}
				
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
		return true;
	}
?>