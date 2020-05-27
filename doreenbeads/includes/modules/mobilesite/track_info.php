<?php 
if (! $_SESSION ['customer_id']) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$breadcrumb->add ( TEXT_HEADER_MY_ACCOUNT, zen_href_link ( FILENAME_MYACCOUNT ,'','SSL') );
$breadcrumb->add ( TEXT_ORDER_HISTORY, zen_href_link ( FILENAME_ACCOUNT ,'','SSL') );

if (isset($_GET['order_id']) && $_GET['order_id'] != ''){
	$orders_id = zen_db_prepare_input($_GET['order_id']);
	$breadcrumb->add(sprintf(NAVBAR_TITLE, $orders_id));
	$shipping_num_query = $db->Execute('select shipping_num_json from ' . TABLE_ORDERS . ' where orders_id = ' . $orders_id . ' and orders_status > 0');
	if($shipping_num_query->RecordCount() > 0){
		$shipping_num_array = json_decode($shipping_num_query->fields['shipping_num_json'], true);
		$shipping_num_array = array_reverse($shipping_num_array);
		if(!empty($shipping_num_query->fields['shipping_num_json'])){
			$track_info_array = array();
			if(sizeof($shipping_num_array) > 0){
				foreach ($shipping_num_array as $shipping_num){
					$shipping_num['shipping_num'] = trim($shipping_num['shipping_num']);
					if(empty($shipping_num['shipping_num'])){
						continue;
					}
					$track_info_array[$shipping_num['shipping_num']] = array();
					$trach_info_query = $db->Execute('select tracking_get_date, tracking_description, tracking_details, tracking_shipping_code from ' . TABLE_ORDERS_TRACKIMGMORE . ' where tracking_number = "' . $shipping_num['shipping_num'] . '" and orders_id =' . $orders_id . ' order by tracking_get_date desc');
					$i = 1;
					while (!$trach_info_query->EOF){
						if($i == 1){
							$track_info_array[$shipping_num['shipping_num']]['shipping_code'] = $trach_info_query->fields['tracking_shipping_code'];
							
							$shipping_title = $db->Execute('select title from ' . TABLE_SHIPPING_INFO . ' where code = "' . $trach_info_query->fields['tracking_shipping_code'] . '" and language_id = ' . $_SESSION['languages_id']);
							$track_info_array[$shipping_num['shipping_num']]['shipping_title'] = $shipping_title->fields['title'];
							$tracking_info_url_query=$db->Execute("SELECT track_url FROM ".TABLE_SHIPPING." WHERE code='".$trach_info_query->fields['tracking_shipping_code']."'");
							if(isset($track_url->fields['track_url'])){
							    $track_info_array[$shipping_num['shipping_num']]['track_url'] = $tracking_info_url_query->fields['track_url'];
							}
						}
						
						$track_info_array[$shipping_num['shipping_num']]['track_detail'][] = array(
							'tracking_get_date' => date('d F,Y H:i:s' , strtotime($trach_info_query->fields['tracking_get_date'])),
							'tracking_description' => $trach_info_query->fields['tracking_description'],
							'tracking_detail' => $trach_info_query->fields['tracking_details']
						);
						
						$trach_info_query->MoveNext();
					}
					if(!empty($shipping_num['shipping_datetime'])) {
						$track_info_array[$shipping_num['shipping_num']]['track_detail'][] = array(
							'tracking_get_date' => date('d F,Y H:i:s' , strtotime($shipping_num['shipping_datetime'])),
							'tracking_description' => TEXT_DISPATCH_FROM_WAREHOUSE,
							'tracking_detail' => ''
						);
					}
				}
			}
		}else{
			zen_redirect(zen_href_link(FILENAME_ACCOUNT));
		}
	}else{
		zen_redirect(zen_href_link(FILENAME_ACCOUNT));
	}
}else{
	zen_redirect(zen_href_link(FILENAME_ACCOUNT));
}

$smarty->assign('track_info_array' , $track_info_array);
$smarty->caching = 0;
?>