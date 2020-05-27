<?php 
if (!$_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$check_filter = false;


if($_GET['action'] == 'pack_filter'){
	$check_filter = true;
	if(isset($_GET['ordernumber']) && trim($_GET['ordernumber']) != ''){
		$orders_id_str = strval($db->prepare_input($_GET['ordernumber']));
		
		if($orders_id_str != ''){
			$filter_str .= ' and zo.orders_id = "' . $orders_id_str . '"';
		}
	}
	
	if(isset($_GET['trackingnumber']) && trim($_GET['trackingnumber']) != ''){
		$trance_number_str = strval($db->prepare_input($_GET['trackingnumber']));
		
		if($trance_number_str != ''){
			$filter_str .= ' and zops.trance_number like "%,' . $trance_number_str . ',%"';
			$delivery_info_str =' INNER JOIN ' . TABLE_ORDERS_PACKING_SLIP . ' zops ON zop.orders_id = zops.orders_id and zop.products_model = zops.products_model';
		}
	}
	
	if(isset($_GET['pronumber']) && trim($_GET['pronumber']) != ''){
		$products_model_str = strval($db->prepare_input($_GET['pronumber']));
		
		if($products_model_str != ''){
			$filter_str .= ' and zop.products_model = "' . $products_model_str . '"';
		}
	}
	
	if(isset($_GET['datestart']) &&  trim($_GET['datestart']) != ''){
		$datestart = trim($_GET['datestart']) . ' 00:00:00';
		$filter_date_start = zen_db_prepare_input(trim($_GET['datestart']));
	}
	if(isset($_GET['dateend']) &&  trim($_GET['dateend']) != ''){
		$dateend = trim($_GET['dateend']) . ' 23:59:59';
		$filter_date_end = zen_db_prepare_input(trim($_GET['dateend']));
	}
	if(isset($datestart) && $datestart != ''){
		$filter_date_str = ' and zo.date_purchased >= "'.$datestart.'" ';
	}
	if(isset($dateend) && $dateend != ''){
		$filter_date_str = ' and zo.date_purchased <= "'.$dateend.'" ';
	}
	if((isset($datestart) && $datestart != '') && (isset($dateend) && $dateend != '')){
		$filter_date_str = ' and zo.date_purchased > "'.$datestart.'" and  zo.date_purchased < "'.$dateend.'"';
	}
}else{
 	$filter_str = ' and zo.date_purchased > "' . date('Y-m-d H:i:s' , time() - 30*3*24*60*60) . '"';
 	$filter_date_start = (string)date('Y-m-d' , time() - 30*3*24*60*60);
 	$filter_date_end = (string)date('Y-m-d' , time());
}
$limit_last_moment = '2017-05-03';
$filter_date_start = (strtotime($filter_date_start) > strtotime($limit_last_moment) ? $filter_date_start : $limit_last_moment);
//限制只能查看功能上线后的订单发包详情
$packing_slip_query = 'SELECT
						zop.products_model,
						zop.orders_id,
						zop.products_quantity,
						zo.date_purchased
						FROM
							(
								' . TABLE_ORDERS_PRODUCTS . ' zop
								INNER JOIN ' . TABLE_ORDERS . ' zo ON zop.orders_id = zo.orders_id
							)
						' . $delivery_info_str . '
						WHERE
						zo.customers_id = ":customersID"
						and zo.orders_status in (' . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ')
						' . $filter_str . '
						' . $filter_date_str . '
						and zo.date_purchased > "2017-05-03 00:00:00" 
						GROUP BY products_model , orders_id
						order by date_purchased desc , products_model asc';

$packing_slip_query = $db->bindVars($packing_slip_query, ':customersID', $_SESSION['customer_id'], 'integer');

if(!isset($_GET['export']) && $_GET['export'] != 'true'){
	$packing_slip_split = new splitPageResults($packing_slip_query, MAX_DISPLAY_ORDER_HISTORY , 'zop.products_model', 'page' , false , '' , true);
	
	$package = $db->Execute($packing_slip_split->sql_query);
}else{
	$package = $db->Execute($packing_slip_query);
}

$package_info_array = array();
$i = 0;
while (!$package->EOF) {
	$products_image_query = $db->Execute('select products_image , products_id from ' . TABLE_PRODUCTS . ' where products_model ="' . (string)$package->fields['products_model'] . '" limit 1');
	$products_images = (string)$products_image_query->fields['products_image'];
	
	$link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $products_image_query->fields['products_id']);
	$package_info_array[$i] = array(
			'products_model' => (string)$package->fields['products_model'] ,
			'products_images' => '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/'.get_img_size($products_images,130,130). '" alt="" width="130" height="130"/>',
			'products_link' => $link,
			'orders_id' => (int)$package->fields['orders_id'] ,
			'total_quantity' => (float)$package->fields['products_quantity'] ,
			'sent_quantity' => 0,
			'unsent_quantity' => 0,
			'trance_number' => '/',
			'trance_number_str' => '/',
			'date_purchased' => (string)$package->fields['date_purchased']
				
	);
	
	$orders_products_delivery_query = 'SELECT GROUP_CONCAT(trance_number) as trans_id, SUM(products_quantity) as sent_quantity FROM ' . TABLE_ORDERS_PACKING_SLIP . ' WHERE orders_id = "' . (int)$package->fields['orders_id'] . '" and products_model = "' . (string)$package->fields['products_model'] . '" GROUP BY orders_id , products_model LIMIT 1';
	$orders_products_delivery_result = $db->Execute($orders_products_delivery_query);

	$sent_quantity = 0;
	if($orders_products_delivery_result->RecordCount() > 0){
		$package_info_array[$i]['trance_number_str'] = '';
		$sent_quantity = floatval($orders_products_delivery_result->fields['sent_quantity']);
		$package_info_array[$i]['sent_quantity'] = $sent_quantity;
		
		if($orders_products_delivery_result->fields['trans_id'] != ''){
			
			$trance_num_str = $orders_products_delivery_result->fields['trans_id'];
			$trance_num_str = substr($trance_num_str, 1 , strlen($trance_num_str)-1);
			$trance_num_str = str_replace(',,,', ',', $trance_num_str);
			
			$package_info_array[$i]['trance_number'] = explode(',', $trance_num_str);
			
			foreach ($package_info_array[$i]['trance_number'] as $tack){
				$package_info_array[$i]['trance_number_str'] .= '<a class="link_color" href="' . zen_href_link(FILENAME_PACKING_SLIP , 'action=pack_filter&trackingnumber=' . $tack) . '">' . $tack . '</a>';
			}
		}
	}
	$unsent_quantity = floatval($package->fields['products_quantity']) - $sent_quantity;
	$package_info_array[$i]['unsent_quantity'] = $unsent_quantity;
	
	$i++;
	$package->MoveNext();
}

$message ['account_text_result_count'] =  $packing_slip_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS );
$message ['account_text_result_page'] = $packing_slip_split->display_links_mobile_for_shoppingcart(3, zen_get_all_get_params(array('page', 'info','x', 'y', 'main_page')));

$filter['filter_ordernumber'] = $orders_id_str;
$filter['pronumber'] = $products_model_str;
$filter['trackingnumber'] = $trance_number_str;
$filter['filter_date_start'] = $filter_date_start;
$filter['filter_date_end'] = $filter_date_end;

$smarty->assign ( 'message', $message );
$smarty->assign ( 'filter', $filter );
$smarty->assign ( 'check_filter', $check_filter );
$smarty->assign ( 'package_info_array', $package_info_array );
$smarty->caching = 0;
?>