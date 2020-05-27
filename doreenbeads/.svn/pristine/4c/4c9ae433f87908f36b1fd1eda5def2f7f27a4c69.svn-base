<?php
if (zen_not_null ( $_SESSION['sendto'] ) && $_SESSION['sendto'] > 0) {
	$_SESSION['cartID'] = $_SESSION['cart']->cartID;

	$select_country_id_query = "select entry_country_id, countries_iso_code_2 from " . TABLE_ADDRESS_BOOK . ", " . TABLE_COUNTRIES . " where address_book_id = :addressBookID and entry_country_id = countries_id";
	$select_country_id_query = $db->bindVars ( $select_country_id_query, ':addressBookID', $_SESSION['sendto'], 'integer' );
	$select_country_id_return = $db->Execute ( $select_country_id_query );

	if ($select_country_id_return->RecordCount () == 1) {
		$select_country_id = $select_country_id_return->fields['entry_country_id'];
		$select_country_code = $select_country_id_return->fields['countries_iso_code_2'];
	}

	$header_shipping_note = '';

	unset ( $_SESSION['dhl_rm'] );
	unset ( $_SESSION['hmdpd_rm'] );
	unset ( $_SESSION['fedex_rm'] );
	unset ( $_SESSION['kdups_rm'] );
	require (DIR_WS_CLASSES . 'order.php');
	require(DIR_WS_CLASSES . 'shipping.php');
	
	$order = new order ();
	
	$countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => $_SESSION['sendto']));
	$shipping_modules = new shipping ('', $countries_iso_code_2, '', $post_postcode, $post_city);
	$shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => $_SESSION['sendto']));
	$shipping_list = $shipping_data['shipping_list'];
	$shipping_info = $shipping_data['shipping_info'];
	$special_discount = $shipping_data['special_discount'];

	/*
	$shipping_modules = new shipping;
	$shipping_result = $shipping_modules->reduce_result;
	$special_discount = $shipping_modules->special_result;
	$shipping_method_limit = $shipping_modules->shipping_method_limit;
  	$shipping_method_limit_description = $shipping_modules->shipping_method_limit_description;
	foreach ($shipping_method_limit as $key => $value) {
		unset($shipping_modules->reduce_result[$key]);
	}
	$cheapest = $shipping_modules->cheapest ();
	$shipping_modules->reduce_result = $shipping_result;
	*/

	$product_model_list = $_SESSION['cart']->get_product_model_list();
	$products_watch = $db->Execute("select pw_model from " . TABLE_PRODUCTS_WATCH . " where pw_model in(" . $product_model_list . ")");
	$show_watch_note = $products_watch->RecordCount() == 0 ? false : true;

	$country_id_array = array('BE', 'FR', 'DE', 'IE', 'LU', 'NL', 'GB');
	$show_tax_note = false;
	if (isset($select_country_id) && in_array($countries_iso_code_2, $country_id_array)){
		$show_tax_note = true;
	}

	foreach ( $shipping_list as $method => $val ) {
		if (! $val['error'] && isset ( $val['final_cost'] )) {
			$display_note = ($val['box_note'] != '' && $val['remote_note'] != '' ? $val['box_note'] . '<br>' . $val['remote_note'] : $val['box_note'] . $val['remote_note']);
			$display_note = $val['box_note'] == '' && $val['remote_note'] == '' ? '' : $display_note;
			if ($special_discount[$val['code']]) {
				$cost_show = '-' . $currencies->format ( $special_discount[$val['code']] );
				$final_cost = '-' . $special_discount[$val['code']];
				$_SESSION['special_cost'] = $special_discount[$val['code']];
			}else{
				$cost_show = ($val['final_cost'] <= 0 ? TEXT_FREE_SHIPPING : $currencies->format ( $val['final_cost'] ) );
				$final_cost = $val['final_cost'];
			}
			$time_unit = TEXT_DAYS_LAN;
	    	if ($val['time_unit'] == 20) {
	    		$time_unit = TEXT_WORKDAYS;
	    	}

	    	$note = '';
	    	
			switch ($method) {
				case 'chinapost':
				case 'etk': $note .= NOTE_EMS_CONTENT; break;
// 				case 'kdfedex' :
// 				case 'zyfedex' :
// 					$note = $show_tax_note ? TEXT_NOTE_ABOUT_TAX_CONTENT : '';
// 					if ($show_watch_note) {
// 						$note .= ($note != '' ? '<br>' . NOTE_FEDEX_CONTENT : NOTE_FEDEX_CONTENT);
// 					}
// 					break;
				case 'ywfedex' :
				case 'ywlbip' :
					$note .= $show_tax_note ? TEXT_NOTE_ABOUT_TAX_CONTENT : '';
					if ($show_watch_note) {
						$note .= ($note != '' ? '<br>' . NOTE_FEDEX_CONTENT : NOTE_FEDEX_CONTENT);
					}
					if($select_country_id == 107){
						$note .= TEXT_NOTE_USE_ENGLISH_DESCRIPTION;
					}
					break;
				case 'ywdhl' :
				case 'ywdhl-dh' :
					if ($show_watch_note) {
						$note .= TEXT_NOTE_ABOUT_WATCH_CONTENT; 
					}
					break;
// 				case 'ukeurline' :
				case 'hmjz' :
				case 'cnezx' : 
				case 'hmdpd' : $note .= NOTE_TARIFF_CONTENT; break;
				case 'usexpr' : $note .= NOTE_TARIFF_CONTENT_US; break; 
				case 'sfhyzxb' :
					if($_SESSION['languages_id']==1 || $_SESSION['languages_id']==3){
						$note .= TEXT_DETAILS_SFHYZXB; 
					}
					break;
				case 'sfhky' : 
					if($_SESSION['languages_id']==1 || $_SESSION['languages_id']==3){
						$note .= TEXT_DETAILS_SFHKY; 
					}
					break;
				case 'ynkqy' : 
					if($_SESSION['languages_id']==1 || $_SESSION['languages_id']==3) {
						$note .= TEXT_DETAILS_YNKQY;
					}
					break;
				case 'trstma' :
					if($_SESSION['languages_id']==1 || $_SESSION['languages_id']==3) {
						$note .= TEXT_DETAILS_TRSTMA; 
					}
					break;
				case 'trstm' :
					if($_SESSION['languages_id']==1 || $_SESSION['languages_id']==3) {
						$note .= TEXT_TRSTM; 
					}
					break;
				case 'agent' : $note .= TEXT_SPTYA; break;
// 				case 'eyoubao': $note = TEXT_EYOUBAO; break;
				case 'xxeub' : $note .= NOTE_USPS_CONTENT; break;
				case 'ubi': $note .= TEXT_UBI_NOTE_CONTENT;break;
				default: $note .= '';
			}
			
			$display_note = ($val['box_note'] != '' && $val['remote_note'] != '' ? $val['box_note'] . '<br>' . $val['remote_note'] : $val['box_note'] . $val['remote_note']);
			$display_note = $val['box_note'] == '' && $val['remote_note'] == '' ? '' : $display_note;
			if ($val['volume_note'] != '') $display_note .= ($display_note != '' ? '<br>' . $val['volume_note'] . '<br>' : $val['volume_note']);
			
			if ($note != '') {
				$display_note = ($display_note != '' ? $display_note . '<br>' : '') . $note;
				//$shipping_methods[$val['code']]['show_note'] = $note;
			}
			
			if(($method == $shipping_info['code'] || ($val['code'] == 'agent' && count($shipping_list) <= 1)) && !isset($shipping_method_limit[$val['code']])){
				$sChecked = 'checked="checked"';
				$sClass = 'class="selected"';
				//$quote = $quotes;
				$val['is_display'] = 1;
			}
			
			$val['day'] = $val['day_low'];
			$val['final_cost'] = $final_cost;
			$val['day_sum'] = $val['day_low'] * 100 + $val['day_high'];
			$val['cost_show'] = $cost_show;
			$val['days_show'] = $val['days'] . ' ' . $time_unit;
			$val['show_note'] = $display_note;

			if ($val['is_display']) {
				$shipping_methods[$val['code']] = $val;
	  			
		  	}else{
	  			$shipping_methods_not_display[$val['code']] = $val;
		  	}
		}
	}

	/*
	if(zen_customer_has_valid_order()){
		$order_query = $db->Execute('select shipping_module_code from ' . TABLE_ORDERS . ' where customers_id = ' . $_SESSION['customer_id'] . ' order by orders_id desc limit 1');
		$last_shipping_method = $order_query->fields['shipping_module_code'];
		if (isset($shipping_modules->reduce_result[$last_shipping_method]) && empty($shipping_modules->cal_result[$last_shipping_method]['error'])) {
			$_SESSION['shipping'] = $shipping_modules->reduce_result[$last_shipping_method];
		}else{
			$_SESSION['shipping'] = $shipping_modules->cheapest();
		}
	}
	$quote = $cheapest;
	*/
	$shipping_methods_show = $shipping_methods;
	$default_first_method = current($shipping_methods_show);

	/*
	if ($order->delivery['country']['iso_code_2'] =='CN' ) {
		$cheapest = $default_first_method;
		$cheapest['shipping_package_box_weight'] = 0;
		$cheapest['shipping_weight'] = 0;
	}

	$default_shipping_method = $cheapest['code'];  //this is code

	$select_customers_default_shipping = "select customers_default_shipping from " . TABLE_CUSTOMERS . " where customers_id  = ".$_SESSION['customer_id']." ";
	$select_customers_default_shipping_query = $db->Execute($select_customers_default_shipping);
	if( $select_customers_default_shipping_query->RecordCount() > 0 && isset($select_customers_default_shipping_query->fields['customers_default_shipping']) && $select_customers_default_shipping_query->fields['customers_default_shipping'] != ''){
		list($module, $method) = explode('_', $select_customers_default_shipping_query->fields['customers_default_shipping']);
		if ( isset($shipping_methods_show[$method]) && !$shipping_methods_show[$method]['error'] ) {
			$default_shipping_method = $method;
		}
	}
	
	//$_SESSION['shipping'] = $default_first_method;
	$_SESSION['shipping'] = $shipping_methods_show[$default_shipping_method];
	*/

	

	$time_unit = TEXT_DAYS_LAN;
	if ($val['time_unit'] == 20) { $time_unit = TEXT_WORKDAYS;}
	$shipping_info['days_show'] = $shipping_methods_show[$default_shipping_method]['days'] . ' ' . $time_unit;
	if ($shipping_info['final_cost'] < 0) {
		$shipping_info['final_cost'] = 0;
	}

	$smarty->assign ( 'default_shipping_method', $shipping_info['code'] );	
	$smarty->assign ( 'shipping_methods_show', $shipping_methods_show );
	$smarty->assign ( 'shipping_methods_unshow', $shipping_methods_not_display );
	$smarty->assign ( 'shipping_method_limit', $shipping_method_limit );
	$smarty->assign ( 'shipping_method_limit_description', $shipping_method_limit_description );
	$smarty->assign ( 'package_box_weight', $shipping_info['shipping_package_box_weight'] );
	$smarty->assign ( 'shipping_weight', $shipping_info['shipping_weight'] );
	$smarty->assign ( 'shipping_info', $shipping_info );

} else {
	zen_redirect ( zen_href_link ( 'checkout' ) );
}
?>