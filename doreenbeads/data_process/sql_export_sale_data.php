<?php 
chdir("../");
require('includes/application_top.php');
require("includes/access_ip_limit.php");
if(!isset($_GET['dest_file'])||!isset($_GET['action'])|| $_GET['action']=='' ) die('need action or file');
set_time_limit(7200);
@ini_set('memory_limit','2012M');
$dest_path = $_GET['dest_file'];
$filename = basename($dest_path);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

include 'Classes/PHPExcel.php';
if($file_ext=='xlsx'){
	include 'Classes/PHPExcel/Reader/Excel2007.php';
	include 'Classes/PHPExcel/Writer/Excel2007.php';
	$objReader = new PHPExcel_Reader_Excel2007;
}else{
	include 'Classes/PHPExcel/Reader/Excel5.php';
	include 'Classes/PHPExcel/Writer/Excel5.php';
	$objReader = new PHPExcel_Reader_Excel5;
}


if($_GET['src_file']!=''){
	$src_path = $_GET['src_file'];
	$objSrc = $objReader->load($src_path);
	$src_sheet = $objSrc->getActiveSheet();
}

$objPHPExcel = $objReader->load($dest_path);
$sheet = $objPHPExcel->getActiveSheet();
//$objPHPExcel = $objReader->load("F:/8seasons_data/sale_data.xlsx");

global $db;
switch($_GET['action']){

	case 'update_price':
		$cnt=0;
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$model = zen_db_prepare_input($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$j)->getValue());
			$net_price = zen_db_prepare_input($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1,$j)->getValue());
			$price_times = zen_db_prepare_input($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2,$j)->getValue());
				
			$products_query = $db->Execute("select products_id,products_price,products_weight,product_price_times from ".TABLE_PRODUCTS." where products_model='".$model."'")	;
			if(!$products_query->fields['products_id']){				
				continue;
			}
			$old_price_query = $db->Execute("select discount_price from ".TABLE_PRODUCTS_DISCOUNT_QUANTITY." where products_id=".$products_query->fields['products_id']." order by discount_qty limit 1");
			$new_price = zen_refresh_products_price_new ( $products_query->fields['products_id'] ,$net_price ,$products_query->fields['products_weight'], $price_times );
			//echo $new_price.'<br/>';
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$j,$old_price_query->fields['discount_price']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$j,$products_query->fields['product_price_times']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$j,$new_price);
						
				$cnt++;
		}
		echo $cnt;
	
		break;
		case 'customer_name':
			$cnt=0;
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$email = zen_db_prepare_input($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$j)->getValue());
				$customers_query = $db->Execute("select customers_id,customers_group_pricing from ".TABLE_CUSTOMERS." where customers_email_address='".trim($email)."'");
				if($customers_query->RecordCount()>0){
					$vip_query = $db->Execute("select group_percentage from ".TABLE_GROUP_PRICING." where group_id=".$customers_query->fields['customers_group_pricing']);
					if($vip_query->fields['group_percentage']>0){
						$vip_discount = $vip_query->fields['group_percentage'].'%';
					}else{
						$vip_discount = 0;
					}
		
					
					$last_order_query = $db->Execute("select date_purchased,language_id from ".TABLE_ORDERS." where customers_id='".$customers_query->fields['customers_id']."'
								and orders_status>1	order by date_purchased desc limit 1");
					$order_total_query = $db->Execute("select count(orders_id) as total_cnt, sum(order_total) as total_amt from ".TABLE_ORDERS."
										where customers_id='".$customers_query->fields['customers_id']."'
											and orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ")");
					$register_query = $db->Execute("select customers_info_date_account_created,customers_info_date_of_last_logon  from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$customers_query->fields['customers_id']);
							
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$j,$vip_discount);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$j,$register_query->fields['customers_info_date_account_created']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$j,$order_total_query->fields['total_cnt']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$j,$order_total_query->fields['total_amt']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$j,$last_order_query->fields['date_purchased']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$j,$register_query->fields['customers_info_date_of_last_logon']);
						
					$cnt++;
				}
			}
			echo $cnt;
			break;
		case 'active_customers';
			$i=2;
			$customers_query =$db->Execute("select c.customers_id, c.customers_email_address,c.customers_group_pricing
					from ".TABLE_CUSTOMERS." c,".TABLE_ORDERS." o
					where c.customers_id=o.customers_id
					and c.customers_email_address not like '%@panduo.com%'
					and o.orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ") and o.date_purchased>='2014-07-06 00:00:00' and o.date_purchased<='2015-07-07 23:59:59'
					group by o.customers_id");
			$fp = fopen('lxy.csv', 'w');
			while(!$customers_query->EOF){
			
				$vip_query = $db->Execute("select group_percentage from ".TABLE_GROUP_PRICING." where group_id=".$customers_query->fields['customers_group_pricing']);
				if($vip_query->fields['group_percentage']>0){
					$vip_discount = $vip_query->fields['group_percentage'].'%';
				}else{
					$vip_discount = 0;
				}
//				$last_order_query = $db->Execute("select date_purchased from ".TABLE_ORDERS." where customers_id='".$customers_query->fields['customers_id']."'
//								and orders_status in (2,3,4) order by date_purchased desc limit 1");
				$order_total_query = $db->Execute("select max(date_purchased) as date_purchased, count(orders_id) as total_cnt, sum(order_total) as total_amt from ".TABLE_ORDERS."
										where customers_id='".$customers_query->fields['customers_id']."' and orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ")");
				$register_query = $db->Execute("select customers_info_date_account_created,	customers_info_date_of_last_logon from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$customers_query->fields['customers_id']);

				$arr = array(
					$customers_query->fields['customers_email_address'],
					$vip_discount,
					$register_query->fields['customers_info_date_account_created'],
					$order_total_query->fields['date_purchased'],
					$order_total_query->fields['total_cnt'],
					$order_total_query->fields['total_amt'],
				);
				fputcsv($fp, $arr);
/*								
				$cart_amount = 0;
				$item_total = 0;
				$cart_query = $db->Execute("select products_id,customers_basket_quantity from ".TABLE_CUSTOMERS_BASKET." where customers_id=".$customers_query->fields['customers_id']);
				while(!$cart_query->EOF){
					//$product_price = zen_get_products_base_price($cart_query->fields['products_id']);
					if( $cart_query->fields['customers_basket_quantity']>0) {
						$item_total+=$cart_query->fields['customers_basket_quantity'];
						$products_discounts_query = $db->Execute("select discount_price from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . (int)$cart_query->fields['products_id'] . "' and discount_qty <='" . $cart_query->fields['customers_basket_quantity'] . "' order by discount_qty desc");
						if($products_discounts_query->RecordCount()>0){
							$product_price = round( $product_price * (1 - ($products_discounts_query->fields['discount_price']/100)) ,2);
						}
						$item_price = $product_price * (int)$cart_query->fields['customers_basket_quantity']	;
						$cart_amount+=$item_price;
					}
					$cart_query->MoveNext();
				}
*/
/*
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$customers_query->fields['customers_email_address']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$vip_discount);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$register_query->fields['customers_info_date_account_created']);		
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$order_total_query->fields['total_cnt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$order_total_query->fields['total_amt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$last_order_query->fields['date_purchased']);
//				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$register_query->fields['customers_info_date_of_last_logon']);				
//				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$item_total);
*/

				$i++;
				$customers_query->MoveNext();
			}

			
			break;
		case 'small_pack_sold':
			$cnt=0;
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$product_discount = 0;
				$model = zen_db_prepare_input($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0,$j)->getValue());
				$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".trim($model)."'");
				if($products_query->RecordCount()>0){
					$sold_query = $db->Execute("select sum(products_quantity) as qty, sum(final_price*products_quantity) as amt from ".TABLE_ORDERS_PRODUCTS." op,".TABLE_ORDERS." o  
							where o.orders_id=op.orders_id
							and o.orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )
							and o.customers_email_address not like '%panduo.com%'
							and op.products_id=".$products_query->fields['products_id']);
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$j,$sold_query->fields['qty']?$sold_query->fields['qty']:'0');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$j,$sold_query->fields['amt']?$sold_query->fields['amt']:'0');
						
					$cnt++;
				}
			}
			echo $cnt;
			
			break;

	case 'lost_customers':
		$i=2;
		$customers_query =$db->Execute("select c.customers_id, c.customers_email_address,c.customers_group_pricing,c.register_languages_id
					from ".TABLE_CUSTOMERS." c
					where c.customers_email_address not like '%@panduo.com%'");
		while(!$customers_query->EOF){
			$last_order_query = $db->Execute("select date_purchased from ".TABLE_ORDERS." where customers_id='".$customers_query->fields['customers_id']."'
								and orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )	order by date_purchased desc limit 1");
			if($last_order_query->fields['date_purchased']<'2015-04-10 00:00:00'){
				$vip_query = $db->Execute("select group_percentage from ".TABLE_GROUP_PRICING." where group_id=".$customers_query->fields['customers_group_pricing']);
				if($vip_query->fields['group_percentage']>0){
					$vip_discount = $vip_query->fields['group_percentage'].'%';
				}else{
					$vip_discount = 0;
				}
				$register_query = $db->Execute("select customers_info_date_account_created from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$customers_query->fields['customers_id']);
//				$lang_code = $db->Execute("select code from ".TABLE_LANGUAGES." where languages_id=".$customers_query->fields['register_languages_id']);
				
				$order_total_query = $db->Execute("select count(orders_id) as total_cnt, sum(order_total) as total_amt from ".TABLE_ORDERS."
										where customers_id='".$customers_query->fields['customers_id']."' and orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$customers_query->fields['customers_email_address']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$vip_discount);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$register_query->fields['customers_info_date_account_created']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$order_total_query->fields['total_cnt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$order_total_query->fields['total_amt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$last_order_query->fields['date_purchased']);
//				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$lang_code->fields['code']);
				$i++;
			}
			$customers_query->MoveNext();
		}
		break;

		case 'fb_coupon':
			
			$i=2;
			$order_query = $db->Execute("SELECT ct.redeem_date, o.customers_id , o.order_total FROM `t_coupon_redeem_track` ct, t_orders o
				where ct.order_id=o.orders_id
				and o.orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )
				AND coupon_id=46");
			while(!$order_query->EOF){
				$register_query = $db->Execute("select customers_info_date_account_created,	customers_info_date_of_last_logon from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$order_query->fields['customers_id']);
				$customers_query = $db->Execute("select customers_country_id, customers_default_address_id from ".TABLE_CUSTOMERS." where customers_id=".$order_query->fields['customers_id']);
				if($customers_query->fields['customers_country_id']>0){
					$country_query = $db->Execute("select countries_iso_code_2,countries_name from ".TABLE_COUNTRIES." where countries_id=".$customers_query->fields['customers_country_id']);
					$country_name = $country_query->fields['countries_name'];
					$country_code = $country_query->fields['countries_iso_code_2'];
				}elseif($customers_query->fields['customers_default_address_id']>0){
					$country_query = $db->Execute("select c.countries_iso_code_2,c.countries_name from ".TABLE_COUNTRIES." c,".TABLE_ADDRESS_BOOK." a
										where a.address_book_id=".$customers_query->fields['customers_default_address_id']."
										and a.entry_country_id=c.countries_id");
					$country_name = $country_query->fields['countries_name'];
					$country_code = $country_query->fields['countries_iso_code_2'];
				
				}else{
					$country_name = '';
					$country_code = '';
				}
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$country_name);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$register_query->fields['customers_info_date_account_created']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$order_query->fields['redeem_date']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$order_query->fields['order_total']);
				$i++;
				$order_query->MoveNext();
			}
			echo $i;
			break;
		case 'small_customers';
			$i=2;
			$customers_query =$db->Execute("select c.customers_id, c.customers_email_address,c.customers_group_pricing
					from ".TABLE_CUSTOMERS." c,".TABLE_ORDERS." o
					where c.customers_id=o.customers_id

					and c.customers_email_address not like '%@panduo.com%'
					and o.orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )
					and o.date_purchased>='2014-10-01 00:00:00'
					and o.date_purchased<='2015-01-31 23:59:59'
					group by o.customers_id");
			while(!$customers_query->EOF){
				$order_total_query = $db->Execute("select count(orders_id) as total_cnt, sum(order_total) as total_amt from ".TABLE_ORDERS."
										where customers_id='".$customers_query->fields['customers_id']."'
											and orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )");
				$order_avg = $order_total_query->fields['total_amt'] / $order_total_query->fields['total_cnt'];
				if($order_total_query->fields['total_cnt']<10 || $order_avg>19.99){
					$customers_query->MoveNext();
					continue;
				}
				$vip_query = $db->Execute("select group_percentage from ".TABLE_GROUP_PRICING." where group_id=".$customers_query->fields['customers_group_pricing']);
				if($vip_query->fields['group_percentage']>0){
					$vip_discount = $vip_query->fields['group_percentage'].'%';
				}else{
					$vip_discount = 0;
				}
				
			
				$last_order_query = $db->Execute("select date_purchased from ".TABLE_ORDERS." where customers_id='".$customers_query->fields['customers_id']."'
								and orders_status>1	order by date_purchased desc limit 1");
				$register_query = $db->Execute("select customers_info_date_account_created,	customers_info_date_of_last_logon from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$customers_query->fields['customers_id']);
			
				$recent_total_query = $db->Execute("select count(orders_id) as total_cnt, sum(order_total) as total_amt from ".TABLE_ORDERS."
										where customers_id='".$customers_query->fields['customers_id']."'
											and orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . " )
											and date_purchased>='2015-02-02 00:00:00'
											and date_purchased<='2015-03-11 23:59:59'");
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$customers_query->fields['customers_email_address']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$vip_discount);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$register_query->fields['customers_info_date_account_created']);			
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$order_total_query->fields['total_cnt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$order_total_query->fields['total_amt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$last_order_query->fields['date_purchased']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$recent_total_query->fields['total_cnt']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$recent_total_query->fields['total_amt']);
				$i++;
				$customers_query->MoveNext();
			}
			 
			break;


	case 'customers_no_order':
		$cnt=0;
		$cu_query = $db->Execute("select * from t_currencies");
		$currency = array();
		while(!$cu_query->EOF){
			$currency[$cu_query->fields['currencies_id']] = $cu_query->fields['code'];
			$cu_query->MoveNext();
		}
		$c_query = $db->Execute("select a.customers_id,a.customers_email_address,concat(a.customers_firstname,' ',a.customers_lastname) as name,a.customers_country_id,a.currencies_preference,a.register_languages_id,c.customers_info_date_account_created 
			from t_customers a,t_customers_info c 
			where a.customers_id=c.customers_info_id
			and c.customers_info_date_account_created>='2013-07-01 00:00:00'
			and a.customers_id not in (select distinct b.customers_id from t_orders b)");
		$fp = fopen('lxy.csv', 'w');
		while(!$c_query->EOF){
			$data = array();
			$data[] = $c_query->fields['customers_email_address'];
			$data[] = $c_query->fields['name'];
			$country = '';
			if($c_query->fields['customers_country_id'] > 0){
				$country_query = $db->Execute("select * from t_countries where countries_id=".intval($c_query->fields['customers_country_id']));
				$country = $country_query->fields['countries_name'];
			}
			$data[] = $country;
			$cu = isset($currency[$c_query->fields['currencies_preference']]) ? $currency[$c_query->fields['currencies_preference']] : 'USD';

			$total_query = $db->Execute('select cb.final_price, cb.customers_basket_quantity, cb.products_id, p.products_priced_by_attribute, p.product_is_free, p.products_discount_type, p.products_tax_class_id from ' . TABLE_CUSTOMERS_BASKET . ' cb, ' . TABLE_PRODUCTS . ' p where cb.customers_id = ' . $c_query->fields['customers_id'] . ' and p.products_id = cb.products_id and p.products_status = 1');
			$total = 0;
			while (!$total_query->EOF){
				$products_price = $total_query->fields['final_price'];
				$qty = $total_query->fields['customers_basket_quantity'];
				$prid = $total_query->fields['products_id'];
			
				$special_price = zen_get_products_special_price($prid);
				if ($special_price && $total_query->fields['products_priced_by_attribute'] == 0) {
					$products_price = $special_price;
				}
				if ($total_query->fields['product_is_free'] == '1') $products_price = 0;
				if ($total_query->fields['products_priced_by_attribute'] == '1' and zen_has_product_attributes($prid, 'false')) {
					$products_price = ($special_price ? $special_price : $total_query->fields['products_price']);
				} elseif ($total_query->fields['products_discount_type'] != '0') {
					$products_price = zen_get_products_discount_price_qty($prid, $qty);
				}
				$cal_currencicy_price = $currencies->format_cl(zen_add_tax ($products_price, zen_get_tax_rate ( $total_query->fields['products_tax_class_id'] )), true, $cu);
				$total += $cal_currencicy_price * $qty;
			
				$total_query->MoveNext();
			}
			$data[] = $total;
			$data[] = $cu;
			$l = '';
			switch($c_query->fields['register_languages_id']){
				case 2: $l = 'de';break;
				case 3: $l = 'ru';break;
				case 4: $l = 'fr';break;
				case 5: $l = 'es';break;
				case 6: $l = 'jp';break;
				case 7: $l = 'it';break;
				default: $l = 'en';break;			
			}
			$data[] = $l;
			$data[] = $c_query->fields['customers_info_date_account_created'];
			fputcsv($fp, $data);

			$cnt++;
			$c_query->MoveNext();
		}
		echo $cnt;
		break;
}

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save($dest_path);
//$objWriter->save("F:/8seasons_data/sale_data.xlsx");


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

	switch (true) {
		case ($adc_price_times>=4) :
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
	
	$new_price = round($price_after_manager* (1 - $p1)+$ldc_shipping_fee, 4);
	return $new_price;

}

echo $i;
exit;



?>