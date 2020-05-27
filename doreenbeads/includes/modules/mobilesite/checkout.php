<?php
require_once (DIR_WS_CLASSES . 'http_client.php');
require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/checkout.php');
require ('includes/languages/mobilesite/' . $_SESSION ['language'] . '/play_order.php');

if(isset($_SESSION['coupon_amount_orders_total']) && $_SESSION['coupon_amount_orders_total'] != $_SESSION['cart']->show_total_new()){
    unset ( $_SESSION ['coupon_id'] );
    unset ( $_SESSION ['use_coupon'] );
    unset ( $_SESSION ['use_coupon_amount'] );
    unset ( $_SESSION ['order_number_created'] );
}

$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$write_shopping_log = false;
if(isset($_SESSION['count_cart']) && $_SESSION['count_cart'] >= 50) {
	$write_shopping_log = true;
	$identity_info = $_COOKIE['cookie_cart_id'];
	if(!empty($_SESSION['customer_id'])) {
		$identity_info = $_SESSION['customer_id'];
	}
	if(empty($identity_info)) {
		$identity_info = json_encode($_COOKIE) . "separator" . json_encode($_SESSION);
	}
	write_file("log/shopping_cart_log/", "checkout_mobile_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\r\n");
}

//$_SESSION ['cart']->calculate ();
$_SESSION ['valid_to_checkout'] = true;
//$_SESSION ['cart']->get_isvalid_checkout ( true );
//Tianwen.Wan20160624购物车优化
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize(0, 0, false, true);
$products = $products_array['data'];
$products_num = $products_array['count'];

if ($products_array['count'] <= 0) {
	zen_redirect ( zen_href_link ( FILENAME_TIME_OUT ) );
}
if (! isset ( $_SESSION ['customer_id'] ) || ! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ();
	zen_redirect ( zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
} else {
	if (zen_get_customer_validate_session ( $_SESSION ['customer_id'] ) == false) {
		$_SESSION ['navigation']->set_snapshot ( array (
				'mode' => 'SSL',
				'page' => FILENAME_CHECKOUT_SHIPPING
		) );
		zen_redirect ( zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
	}
}

if ($_SESSION ['valid_to_checkout'] == false) {
	zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART ) );
}

// bof delete address
if ($_GET ['action'] == 'delete' && ( int ) $_GET ['aId'] > 0) {
	$check_default_address = $db->Execute ( 'select customers_id from ' . TABLE_CUSTOMERS . ' where customers_id ="' . ( int ) $_SESSION ['customer_id'] . '" and customers_default_address_id="' . $_GET ['aId'] . '" limit 1 ' );
	if ($check_default_address->RecordCount () == 0) {
		$db->Execute ( 'delete from  ' . TABLE_ADDRESS_BOOK . '  where address_book_id ="' . $_GET ['aId'] . '" ' );
	}
	zen_redirect ( zen_href_link ( FILENAME_CHECKOUT, 'pn=lt'));
}
// eof

if (isset ( $_POST ['action'] ) && $_POST ['action'] != '') {
	switch ($_POST ['action']) {
		case 'edit' :
		case 'new' : // edit or new shipping address
			require (DIR_WS_MODULES . 'mobilesite/checkout/checkout_address.php');
			break;
		/*
		case 'comment' : // order comment
			$_SESSION ['comments'] = zen_db_prepare_input ( $_POST ['orderComments'] );
			$_SESSION ['tariff'] = zen_db_prepare_input ( $_POST ['tariff'] );
			$_SESSION ['tariff_title'] = zen_db_prepare_input ( $_POST ['tariff_title'] );
			zen_redirect ( zen_href_link ( FILENAME_CHECKOUT, 'pn=rv' ) );
			break;
		*/
	}
}

$obj_text = array ();
$obj_info = array ();
$obj_text ["text_address_info"] = TEXT_SHIPPING_ADDRESS;
$obj_text ["text_required_fields"] = TEXT_REQUIRED_FIELDS;
$obj_text ["text_shipping_method"] = TEXT_SHIPPING_METHOD;
$obj_text ["text_invoice_comments"] = TEXT_INVOICE_COMMENTS;
$obj_info ["info_customers_id"] = $_SESSION ['customer_id'];
$obj_text ["text_gender"] = TEXT_GENDER;
$obj_text ["text_male"] = TEXT_MALE;
$obj_text ["text_female"] = TEXT_FEMALE;
$obj_text ["text_firstname"] = ENTRY_FIRST_NAME;
$obj_text ["text_lastname"] = ENTRY_LAST_NAME;
$obj_text ["text_address_line_1"] = ENTRY_SUBURB1;
$obj_text ["text_address_line"] = ENTRY_SUBURB;
//$obj_text ["text_address_postage"] = SHIPPING_ADDRESS_DETAIL_POSTAGE;
$obj_text ["text_use_english_info"] = TEXT_ADDRESS_USE_ENGLISH;
$obj_text ["text_country"] = ENTRY_COUNTRY;
$obj_text ["text_state"] = ENTRY_STATE;
//$obj_text ["text_address_state"] = SHIPPING_ADDRESS_DETAIL_STATE_NEW;
$obj_text ["text_city"] = ENTRY_CITY;
$obj_text ["text_zip"] = ENTRY_POST_CODE;
$obj_text ["text_telephone"] = ENTRY_TELEPHONE_NUMBER;
$obj_text ["text_require_telephone"] = ENTRY_TELEPHONE_REQUIRED_TEXT;
$obj_text ["text_company"] = ENTRY_COMPANY;
$obj_text ["text_shipping_address"] = TABLE_HEADING_SHIPPING_ADDRESS;
$obj_text ["text_save_address"] = TABLE_SAVE_ADDRESS;
$obj_text ["text_delete"] = TEXT_DELETE;
$obj_text ["text_sure_to_delete"] = TEXT_SURE_TO_DELETE;
$obj_text ["text_enter_a_address"] = TEXT_ENTER_A_ADDRESS;
$obj_text ["text_submit"] = TEXT_SUBMIT;
$obj_text ["text_back"] = TEXT_BACK;
$obj_text["text_tariff_number"]=TEXT_CUSTOM_NO;
$obj_text["text_tariff_required"]=ENTRY_TARIFF_REQUIRED_TEXT;
$obj_text["backup_email_address"]=ENTRY_EMAIL_ADDRESS;
$obj_text["backup_email_required"]=ENTRY_BACKUP_EMAIL_REQUESTED_TEXT;

$default_select_id = zen_get_selected_country ( $_SESSION ['languages_id'] );
$ip_country_array = get_country_info_by_ip_address(zen_get_ip_address());
//$ip_country_array = get_country_info_by_ip_address('91.248.14.176'); //test
if ($ip_country_array['success']) {
	$ip_country_code = $ip_country_array['data']['country_code'];
	$ip_country_query = $db->Execute('SELECT countries_id FROM ' . TABLE_COUNTRIES . ' WHERE countries_iso_code_2 = "' . $ip_country_code .'" LIMIT 1');
	if ($ip_country_query->RecordCount() > 0) {
		$default_select_id = $ip_country_query->fields['countries_id'];
	}
}
$obj_info ["default_select_id"] = $default_select_id;
$obj_info ["default_address_id"] = $_SESSION ['customer_default_address_id'];
$country_select_name = 'zone_country_id';
$obj_info ["country_select"] = zen_get_country_select_new ( $country_select_name, $default_select_id, $_SESSION ['languages_id'] );
$obj_info ["zone_list"] = zen_js_zone_list ( 'SelectedCountry', 'theForm', 'zone_id' );

$flag_show_pulldown_query = 'select zone_country_id from ' . TABLE_ZONES . ' where zone_country_id="' . $default_select_id . '" limit 1 ';
$flag_show_pulldown = $db->Execute ( $flag_show_pulldown_query );

if ($flag_show_pulldown->RecordCount () > 0) {
	$obj_info ["pulldown_states"] = zen_draw_pull_down_menu ( 'zone_id', zen_prepare_country_zones_pull_down ( $default_select_id ), 0, 'id="stateZone"' ) . zen_draw_input_field ( 'state', '', 'class="hiddenField"' );
} else {
	$obj_info ["pulldown_states"] = zen_draw_input_field ( 'state', '', zen_set_field_length ( TABLE_ADDRESS_BOOK, 'entry_state', '40' ) . ' id="state"' ) . zen_draw_pull_down_menu ( 'zone_id', zen_prepare_country_zones_pull_down ( 223 ), '', 'id="stateZone" class="hiddenField"' );
}

$customer_address_query = $db->Execute ( "select  customers_default_address_id  from " . TABLE_CUSTOMERS . " where customers_id='" . $_SESSION ['customer_id'] . "'" );
$default_select_address_id = $customer_address_query->fields ['customers_default_address_id'];
$smarty->assign ( 'default_select_address_id', $default_select_address_id );

if (! $_SESSION ['sendto']) {
    $_SESSION ['sendto'] = $default_select_address_id;
}
$obj_info ['sendto'] = $_SESSION ['sendto'];
$obj_info ['langs'] = $_SESSION ['language'];
$obj_info ['add_show'] = $_SESSION ['sendto'] > 0 ? 1 : 0;
$obj_text ["text_please_enter"] = CHECKOUT_ADDRESS_BOOK_PLEASE_ENTER;
$obj_text ["text_char_at_least"] = CHECKOUT_ADDRESS_BOOK_CHARACTERS_AT_LEAST;
$obj_text ["text_right_state"] = CHECKOUT_ADDRESS_BOOK_RIGHT_STATE;
$obj_text ["text_cancel"] = TEXT_CANCEL;
$obj_text ["text_edit_address_info"] = TEXT_EDIT_ADDRESS_INFO;
$obj_text ["text_alert_max_address"] = TEXT_ALERT_MAX_ADDRESS;
$obj_info ['curreny'] = $_SESSION ['currency'];

switch ($_GET ['pn']) {
	case 'sc' : // shipping method module
		require (DIR_WS_MODULES . 'mobilesite/checkout/checkout_shipping.php');
		break;
	case 'edit' :
	case 'new' : // shipping address module
		if (( int ) $_GET ['aId'] > 0) {
			$entry_query = "SELECT entry_gender, entry_company, entry_firstname, entry_lastname,
	                         entry_street_address, entry_suburb, entry_postcode, entry_city,
	                         entry_state, entry_zone_id, entry_country_id,entry_telephone , tariff_number , backup_email_address
	                  FROM   " . TABLE_ADDRESS_BOOK . "
	                  WHERE  customers_id = :customersID
	                  AND    address_book_id = :addressBookID";
			$entry_query = $db->bindVars ( $entry_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
			$entry_query = $db->bindVars ( $entry_query, ':addressBookID', $_GET ['aId'], 'integer' );
			$entry = $db->Execute ( $entry_query );

			$country_id = $entry->fields ['entry_country_id'];
			$zone_id = $entry->fields ['entry_zone_id'];
			$state = $entry->fields ['entry_state'];
			$country_select_name = 'zone_country_id';

			$default_country_en = "'223','13','222','38','81','176','73','195','150','153','103','203','105','72','160','107'";
			$default_country_de = "'81','14','204','150','176','73','33','97','124','105','195','222','117','56','72'";
			$default_country_ru = "'176','20','220','109','123','117','11','67','80','140'";
			switch ($_SESSION ['languages_id']) {
				case 1 :
					$priority_country = $default_country_en;
					break;
				case 2 :
					$priority_country = $default_country_de;
					break;
				case 3 :
					$priority_country = $default_country_ru;
					break;
				default :
					$priority_country = $default_country_en;
			}
			$priority_country_array = zen_get_priority_country ( $priority_country );
			$countries_all_array = zen_get_countries ();
			$selected = ($selected != '') ? $selected : '223';
			$selected_country = zen_get_country_name ( $selected );


			$obj_info ["country_select"] = zen_get_country_select_new ( $country_select_name, $country_id, $_SESSION ['languages_id'] );
			$obj_info ["zone_list"] = zen_js_zone_list ( 'SelectedCountry', 'theForm', 'zone_id' );
			$flag_show_pulldown_query = 'select zone_country_id from ' . TABLE_ZONES . ' where zone_country_id="' . $country_id . '" limit 1 ';
			$flag_show_pulldown = $db->Execute ( $flag_show_pulldown_query );
			if ($flag_show_pulldown->RecordCount () > 0) {
				$obj_info ["pulldown_states"] = zen_draw_pull_down_menu ( 'zone_id', zen_prepare_country_zones_pull_down ( $country_id ), 0, 'id="stateZone"' ) . zen_draw_input_field ( 'state', '', 'class="hiddenField"' );
			} else {
				$obj_info ["pulldown_states"] = zen_draw_input_field ( 'state', $state, zen_set_field_length ( TABLE_ADDRESS_BOOK, 'entry_state', '40' ) . ' id="state"' ) . zen_draw_pull_down_menu ( 'zone_id', zen_prepare_country_zones_pull_down ( 223 ), '', 'id="stateZone" class="hiddenField"' );
			}
			$address_info_array = $entry->fields;
		} else {
			$address_info_array = array ();
		}
		$smarty->assign ( 'ainfo', $address_info_array );
		break;
	case 'cm' : 
	    if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
	        require_once(DIR_WS_CLASSES . 'order.php');
	        $order = new order(0, $products_array['data']);
	        $order_totals = $order->info ['subtotal'];
	        $coupon_array = get_coupon_select (true);
	        $coupon_select = $coupon_array['coupon_select'];
	        $coupon_unselect = $coupon_array['coupon_unselect'];
	        
	        if (sizeof ( $coupon_select ) > 0 && !isset($_SESSION['coupon_id'])) {
	            $first_coupon_info =  reset($coupon_select);
	            $_SESSION['coupon_id'] = $first_coupon_info['coupon_id'];
	            $_SESSION['coupon_to_customer_id'] = $first_coupon_info['coupon_to_customer_id'];
	        }
	        
	        $smarty->assign ( 'coupon_select', $coupon_select );
	        $smarty->assign ( 'coupon_unselect', $coupon_unselect );
	    }else{
	        zen_redirect ( zen_href_link ( 'checkout' ) );
	    }
	    break;
	case 'lt':
	    $_SESSION ['cartID'] = zen_get_customer_cartid ();
	    $address_array = array ();
	    $address_listing = $db->Execute ( "select address_book_id, entry_firstname , entry_lastname ,entry_gender , entry_street_address ,  entry_suburb , entry_city , entry_postcode ,
                           entry_state , entry_zone_id , entry_country_id, tariff_number , backup_email_address
						   from  " . TABLE_ADDRESS_BOOK . "
						   where customers_id = " . ( int ) $_SESSION ['customer_id'] . " order by address_book_id" );
	    $address_num = $address_listing->RecordCount ();
	    if ($address_num > 0) {
	        $count_num = 0;
	        $i = 1;
	        
	        while ( ! $address_listing->EOF && $count_num < 10 ) {
	            $count_num ++;
	            $address_listing_address = zen_address_label ( $_SESSION ['customer_id'], $address_listing->fields ['address_book_id'], true, '', '<br />' );
	            
	            if($_SESSION['customer_default_address_id'] != $address_listing->fields ['address_book_id']){
	                $address_array [$i] = array (
	                    'address_id' => $address_listing->fields ['address_book_id'],
	                    'address_info' => $address_listing_address
	                );
	            }else{
	                $address_array [0] = array (
	                    'address_id' => $address_listing->fields ['address_book_id'],
	                    'address_info' => $address_listing_address
	                );
	            }
	            $i++;
	            $address_listing->MoveNext ();
	        }
	    }
	    ksort($address_array);
	    
	    $smarty->assign ( 'address_array', $address_array );
	    $smarty->assign ( 'address_num', $address_num );
	    break;
	default : 
		$_SESSION ['cartID'] = zen_get_customer_cartid ();
		$address_array = array ();
		$address_listing = $db->Execute ( "select address_book_id, entry_firstname , entry_company, entry_lastname ,entry_gender , entry_street_address ,  entry_suburb , entry_city , entry_postcode ,
                           entry_state , entry_zone_id , entry_telephone as telephone_number , entry_country_id, tariff_number , backup_email_address
						   from  " . TABLE_ADDRESS_BOOK . " zab inner join " . TABLE_COUNTRIES . " zc on zab.entry_country_id = zc.countries_id
						   where customers_id = " . ( int ) $_SESSION ['customer_id'] . " and address_book_id = " . $_SESSION ['sendto'] . " limit 1" );
		$address_num = $address_listing->RecordCount ();
        $address_info = $address_listing->fields;

		if ($address_num > 0) {
		    $address_listing_address = zen_address_label ( $_SESSION ['customer_id'], $address_listing->fields ['address_book_id'], true, '', '<br />' );
		    
		    if($address_listing->fields ['address_book_id'] == $_SESSION ['sendto']){
		        $address_checked = array(
		            'address_id' => $address_listing->fields ['address_book_id'],
		            'address_info' => $address_listing_address
		        );
		        $tariff_value = $address_listing->fields ['tariff_number'];
		        $select_country_id = $address_listing->fields ['entry_country_id'];
		        $select_country_code = $address_listing->fields ['countries_iso_code_2'];
		    }
		    
		    $smarty->assign ( 'address_checked', $address_checked );
		}
		
		$smarty->assign ( 'address_num', $address_num );
        $smarty->assign ( 'address_info', $address_info );
		
		if (zen_not_null ( $_SESSION['sendto'] ) && $_SESSION['sendto'] > 0) {
    		$header_shipping_note = '';
    		
    		unset ( $_SESSION['dhl_rm'] );
    		unset ( $_SESSION['hmdpd_rm'] );
    		unset ( $_SESSION['fedex_rm'] );
    		unset ( $_SESSION['kdups_rm'] );
    		require_once(DIR_WS_CLASSES . 'order.php');
    		require_once(DIR_WS_CLASSES . 'shipping.php');
    		
    		$order = new order ();
    		$countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => $_SESSION['sendto']));
    		$shipping_modules = new shipping ('', $countries_iso_code_2, '', $post_postcode, $post_city);
    		$shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => $_SESSION['sendto']));
    		$shipping_list = $shipping_data['shipping_list'];
    		$shipping_info = $shipping_data['shipping_info'];
    		$special_discount = $shipping_data['special_discount'];
    		
    		$product_model_list = $_SESSION['cart']->get_product_model_list();
    		$products_watch = $db->Execute("select pw_model from " . TABLE_PRODUCTS_WATCH . " where pw_model in(" . $product_model_list . ")");
    		$show_watch_note = $products_watch->RecordCount() == 0 ? false : true;
    		
    		$country_id_array = array('BE', 'FR', 'DE', 'IE', 'LU', 'NL', 'GB');
    		$show_tax_note = false;
    		if (isset($select_country_id) && in_array($countries_iso_code_2, $country_id_array)){
    		    $show_tax_note = true;
    		}
    		
    		if (! $shipping_info['error'] && isset ( $shipping_info['final_cost'] )) {
    		    $display_note = ($shipping_info['box_note'] != '' && $shipping_info['remote_note'] != '' ? $shipping_info['box_note'] . '<br>' . $shipping_info['remote_note'] : $shipping_info['box_note'] . $shipping_info['remote_note']);
    		    $display_note = $shipping_info['box_note'] == '' && $shipping_info['remote_note'] == '' ? '' : $display_note;
    		    if ($special_discount[$shipping_info['code']]) {
    		        $cost_show = '-' . $currencies->format ( $special_discount[$shipping_info['code']] );
    		        $final_cost = '-' . $special_discount[$shipping_info['code']];
    		        $_SESSION['special_cost'] = $special_discount[$shipping_info['code']];
    		    }else{
    		        $cost_show = ($shipping_info['final_cost'] <= 0 ? TEXT_FREE_SHIPPING : $currencies->format ( $shipping_info['final_cost'] ) );
    		        $final_cost = $shipping_info['final_cost'];
    		    }
    		    $time_unit = TEXT_DAYS_LAN;
    		    if ($shipping_info['time_unit'] == 20) {
    		        $time_unit = TEXT_WORKDAYS;
    		    }
    		    
    		    $note = '';
    		    
    		    switch ($shipping_info['code']) {
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
    		    
    		    $display_note = ($shipping_info['box_note'] != '' && $shipping_info['remote_note'] != '' ? $shipping_info['box_note'] . '<br>' . $shipping_info['remote_note'] : $shipping_info['box_note'] . $shipping_info['remote_note']);
    		    $display_note = $shipping_info['box_note'] == '' && $shipping_info['remote_note'] == '' ? '' : $display_note;
    		    if ($shipping_info['volume_note'] != '') $display_note .= ($display_note != '' ? '<br>' . $shipping_info['volume_note'] . '<br>' : $shipping_info['volume_note']);
    		    
    		    if ($note != '') {
    		        $display_note = ($display_note != '' ? $display_note . '<br>' : '') . $note;
    		    }
    		    
    		    $shipping_info['day'] = $shipping_info['day_low'];
    		    $shipping_info['final_cost'] = $final_cost;
    		    $shipping_info['day_sum'] = $shipping_info['day_low'] * 100 + $shipping_info['day_high'];
    		    $shipping_info['cost_show'] = $cost_show;
    		    $shipping_info['days_show'] = $shipping_info['days'] . ' ' . $time_unit;
    		    $shipping_info['show_note'] = $display_note;
    		    
    		}
    		$smarty->assign ( 'shipping_info', $shipping_info );
    		
    		if ($_SESSION ['languages_id'] == 1) {
    		    if ($select_country_code == 'BR' || $select_country_code == 'CL') {
    		        if ($_SESSION ['shipping'] ['id'] == 'airmail_airmail' || $_SESSION ['shipping'] ['id'] == 'airmaillp_airmaillp' || $_SESSION ['shipping'] == 'airmail_airmail' || $_SESSION ['shipping'] == 'airmaillp_airmaillp' || $_SESSION['shipping']['code'] == 'airmail' || $_SESSION['shipping']['code'] == 'airmaillp') {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_1;
    		            }
    		        } else {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_2 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_2;
    		            }
    		        }
    		    } elseif ($select_country_code == 'DE' || $select_country_code == 'ES' || $select_country_code == 'FR') {
    		        if ($_SESSION ['shipping'] ['id'] == 'kdfedex_kdfedex' || $_SESSION ['shipping'] == 'kdfedex_kdfedex' || $_SESSION ['shipping']['code'] == 'kdfedex') {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_3 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_3;
    		            }
    		        } else {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_4 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_4;
    		            }
    		        }
    		    } else {
    		        if ($tariff_value != '' && $tariff_value > 0) {
    		            $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_5 );
    		        } else {
    		            $tariff_text = TEXT_TARIFF_TITLE_5;
    		        }
    		    }
    		} elseif ($_SESSION ['languages_id'] == 2) {
    		    if ($select_country_code == 'DE' || $select_country_code == 'ES') {
    		        if ($_SESSION ['shipping'] ['id'] == 'kdfedex_kdfedex' || $_SESSION ['shipping'] == 'kdfedex_kdfedex') {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_1;
    		            }
    		        } else {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_1;
    		            }
    		        }
    		    } else {
    		        if ($tariff_value != '' && $tariff_value > 0) {
    		            $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		        } else {
    		            $tariff_text = TEXT_TARIFF_TITLE_1;
    		        }
    		    }
    		} elseif ($_SESSION ['languages_id'] == 3) {
    		    if ($tariff_value != '' && $tariff_value > 0) {
    		        $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		    } else {
    		        $tariff_text = TEXT_TARIFF_TITLE_1;
    		    }
    		} elseif ($_SESSION ['languages_id'] == 4) {
    		    if ($select_country_code == 'FR') {
    		        if ($_SESSION ['shipping'] ['id'] == 'kdfedex_kdfedex' || $_SESSION ['shipping'] == 'kdfedex_kdfedex') {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_2 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_2;
    		            }
    		        } else {
    		            if ($tariff_value != '' && $tariff_value > 0) {
    		                $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		            } else {
    		                $tariff_text = TEXT_TARIFF_TITLE_1;
    		            }
    		        }
    		    } else {
    		        if ($tariff_value != '' && $tariff_value > 0) {
    		            $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1 );
    		        } else {
    		            $tariff_text = TEXT_TARIFF_TITLE_1;
    		        }
    		    }
    		} elseif ($_SESSION ['languages_id'] == 5) { // lvxiaoyong spanish
    		    if ($select_country_code == 'ES' && ($_SESSION ['shipping'] ['id'] == 'kdfedex_kdfedex' || $_SESSION ['shipping'] == 'kdfedex_kdfedex')) {
    		        if ($tariff_value != '' && $tariff_value > 0) {
    		            $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_3 );
    		        } else {
    		            $tariff_text = TEXT_TARIFF_TITLE_3;
    		        }
    		    } else {
    		        if ($tariff_value != '' && $tariff_value > 0) {
    		            $tariff_text = str_replace ( 'name="tariff"', ' name="tariff" maxlength="30" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_4 );
    		        } else {
    		            $tariff_text = TEXT_TARIFF_TITLE_4;
    		        }
    		    }
    		}
    		$smarty->assign ( 'tariff_text', $tariff_text );
    		
    		$page_size = 40;
    		$total_num = $products_array['count'];
    		//Tianwen.Wan20160624购物车优化
    		//$products = $_SESSION ['cart']->get_products ( false, $page_size );
    		
    		$total_page = ceil ( $total_num / $page_size );
    		
    		if(isset($_GET ['page']) && $_GET ['page'] > 0){
    		    $current_page_num = $_GET ['page'];
    		}else{
    		    $current_page_num = $_GET ['page'] = 1;
    		}
    		
    		$products = array_slice($products, ($current_page_num -1) * $page_size, $page_size);
    		if ($total_num > $page_size) {
    		    $products_split = new splitPageResults ( '', $page_size, '', 'page', false, $total_num );
    		    
    		    $cart_fen_ye_bottom = '<div class="page">' . $products_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params ( array('page', 'info', 'x', 'y', 'main_page') ) ,true) . '</div>';
    		} else {
    		    $cart_fen_ye_bottom = '';
    		}
    		
    		$smarty->assign ( 'cart_fen_ye_bottom', $cart_fen_ye_bottom );
    		$products = array_sort ( $products, 'price' );
    		$smarty->assign('total_price',$total_price);
    		$smarty->assign('total_promotion_price',$total_promotion_price);
    		for($i = 0, $n = sizeof ( $products ); $i < $n; $i ++) {
    		    $productsName = getstrbylength ( $products [$i] ['name'], 25 );
    		    $productsImage = '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $products [$i] ['image'], 130, 130 ) . '" width="110" height="110"/>';
    		    $product_quantity = $products [$i] ['quantity'];
    		    $productsPriceEach = $currencies->display_price ( $products [$i] ['final_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ), 1 );
    		    $productsPrice = $currencies->format ( $currencies->format_cl ( zen_add_tax ( $products [$i] ['final_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ) ) ) * $product_quantity, false );
    		    $productsPriceEachOriginal = $currencies->display_price ( $products [$i] ['original_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ), 1 );
    		    $products_model = $products [$i] ['model'];
    		    $discount_amount = zen_show_discount_amount($products [$i] ['id']);
    		    $productsVolumetricWeight = $products [$i] ['volume_weight'] == 0 ? '' : TEXT_VOLUMETRIC_WEIGHT . $products [$i] ['volume_weight'] . TEXT_GRAM_WORD;
    		    $productsShowPrice = ($productsPriceEach == $productsPriceEachOriginal) ? $productsPriceEach : ('<del>' . $productsPriceEachOriginal . '</del>' . $productsPriceEach);
    		    $pinfo [$i] = array (
    		        'name' => $productsName,
    		        'image' => $productsImage,
    		        'qty' => $product_quantity,
    		        'price' => $productsPriceEach,
    		        'weight' => $products [$i] ['weight'],
    		        'vweight' => $products [$i] ['volume_weight'],
    		        'total' => $productsPrice,
    		        'model' => $products_model,
    		        'oprice' => $productsPriceEachOriginal,
    		        'discount' => $discount_amount,
    		        'is_preorder' => $products[$i]['product_quantity']==0,
    		        'products_stocking_days' => $products[$i]['products_stocking_days'],
    		    );
    		}
    		$smarty->assign ( 'pinfo', $pinfo );
    		$smarty->assign ( 'total_num', $total_num );
    		
    		unset ( $_SESSION ['cc_id'] );
    		unset ( $_SESSION ['use_special_coupon'] );
    		unset ( $_SESSION ['show_rcd'] );
    		
    		$coupon_display = false;
    		
    		$order = new order(0, $products_array['data']);
    		require (DIR_WS_CLASSES . 'order_total.php');
    		$order_total_modules = new order_total ();
    		$order_total_array = $order_total_modules->process ();
    		
    		$is_first_coupon = false;
    		$coupon_code = '80214';
    		
    		if($_SESSION['channel']) {
    		    $coupon_err = true;
    		} else {
    		    $sql = "select coupon_id, coupon_amount, coupon_minimum_order from " . TABLE_COUPONS . " where coupon_code= :couponCodeEntered and coupon_active='Y'";
    		    $sql = $db->bindVars ( $sql, ':couponCodeEntered', $coupon_code, 'string' );
    		    $coupon_result = $db->Execute ( $sql );
    		    if ($order->info ['subtotal'] < $coupon_result->fields ['coupon_minimum_order']) {
    		        if ($coupon_result->fields ['coupon_amount'] == '6.01') {
    		            $coupon_err = true;
    		        }
    		    }
    		    if ($order->info ['subtotal'] <= $order->info ['promotion_total'] /* && ! zen_customer_is_new () */) {
    		        $coupon_err = true;
    		    }
    		}
    		
    		if (!$coupon_err) {
    		    $coupon_str .= '<div class="discounttext"><p class="discounttit">' . ($is_first_coupon ? TEXT_FIRST_COUPON_TITLE : TEXT_COUPON_RETURN_TITLE) . '</p>' . TEXT_YOUR_COUPOU . ' <strong>' . $coupon_code . '</strong></p><a href="javascript:void(0);" class="useitbtn">' . TEXT_USE_IT . '</a></div>';
    		}
    		
    		$total_price = $_SESSION['cart']->show_total_new();
    		$total_promotion_price = $_SESSION['cart']->show_promotion_total();
    		if( (!zen_get_customer_create()) && $total_price!=$total_promotion_price && !$_SESSION ['order_discount']  && !get_with_channel()/* && !zen_customer_is_new () */){
    		    $_SESSION['cc_id'] = $coupon_result->fields['coupon_id'];
    		    $order->cart();
    		    $order_total_modules = new order_total;
    		    $order_total_array = $order_total_modules->process ();
    		}
    		$order_totals = 0;
    		$promotion_discount = 0;
    		if (isset ( $order_total_array )) {
    		    for($i = 0, $n = sizeof ( $order_total_array ); $i < $n; $i ++) {
    		        if ($order_total_array [$i] ['code'] == 'ot_subtotal') {
    		            $order_totals = $order_total_array [$i] ['value'];
    		        } elseif ($order_total_array [$i] ['code'] == 'ot_promotion') {
    		            $promotion_discount = $order_total_array [$i] ['value'];
    		        }
    		    }
    		}
    		
    		$add_coupon_str = '<div class="couponAdd">+' . TEXT_ADD_COUPON_BUTTON . '</div><div class="couponAddInput" style="display:none;">
                                    <span style="MARGIN-LEFT: 4px;font-size: 14px; margin-top: 6px;display: block;">'
		                          . zen_draw_input_field('add_coupon_code' , TEXT_ENTER_A_COUPON_CODE , 'style="margin-top: 3px;padding-left: 5px;color: darkgray;" id="add_coupon_code"') . '</span>
								<button class="add_coupon_describe" onclick="return doAddCoupon();"><span><strong>'.TEXT_ADD_COUPON.'</strong></span></button>
								<p style="color:red;" id="add_coupon_tip"></strong></p></div>';
		                          
    		if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
    		    $use_coupon_str = '';
    		    $order_totals = $order->info ['subtotal'];
    		    $coupon_array = get_coupon_select (true);
    		    $coupon_select = $coupon_array['coupon_select'];
    		    
    		    if(sizeof($coupon_select) > 0){
    		        if (sizeof ( $coupon_select ) > 0 && !isset($_SESSION['coupon_id'])) {
    		            if(date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME || date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME || $_SESSION['channel']){
    		                $first_coupon_info =  reset($coupon_select);
    		                $_SESSION['coupon_id'] = $first_coupon_info['coupon_id'];
    		                $_SESSION['coupon_to_customer_id'] = $first_coupon_info['coupon_to_customer_id'];
    		                $_SESSION['use_coupon'] = 'Y';
    		                
    		                $_SESSION['coupon_amount_orders_total'] = $_SESSION['cart']->show_total_new();
    		            }
    		        }
    		    }else{
    		        unset($_SESSION['coupon_id']);
    		        unset($_SESSION['coupon_to_customer_id']);
    		    }
    		    
    		    $order = new order(0, $products_array['data']);
    		    $order_total_modules = new order_total;
    		    $order_total_array = $order_total_modules->process();
    		    if (isset($_SESSION['coupon_id'])&& $coupon_select[$_SESSION['coupon_id']]) {
    		        $show_coupon = $coupon_select[$_SESSION['coupon_id']];
    		    }
    		    if(sizeof($coupon_select) > 0 || sizeof($coupon_array['coupon_unselect']) > 0){
    		        $coupon_display = true;
    		    }
    		}
    		
    		$smarty->assign('add_coupon_str', $add_coupon_str);
    		$smarty->assign('show_coupon', $show_coupon );
    		$smarty->assign ( 'coupon_display', $coupon_display );
    		$smarty->assign('coupon_select', $coupon_select);
    		$order_total_str = '<table class="totalprice">';
            if($order_total_array[0]['value'] > 379){
            	$fixed = 25;
            }elseif($order_total_array[0]['value'] > 179){
            	$fixed = 12;
            }elseif($order_total_array[0]['value'] > 79){
            	$fixed = 6;
            }elseif($order_total_array[0]['value'] > 29){
            	$fixed = 3;
            }else{
            	$fixed = 0;
            }
           
           //  $promInfo = calculate_order_discount();
           //  $prom_discount = $promInfo['order_discount'];
           //  $cVipInfo = getCustomerVipInfo (false , array(), $cal_vip_amount);
           //  $vip_discounts = $cVipInfo['amount'];
           //  $vip_discount = round($cVipInfo['amount'],2);
           //  $total_amount = $_SESSION['cart']->show_total_new();
           //  $total_amount = $total_amount - $fixed-$cVipInfo['amount']-$_SESSION['cart']->show_promotion_total();
           // if (!zen_get_customer_create() && !get_with_channel()) {
           //  $rcd_discount = round(0.03 * $total_amount, 2);
           // }
           // $discounts =$fixed + $vip_discount +$rcd_discount;
            $order_discount = 0;
  $vip = 0 ;
  $rcd = 0;
  $special_discount = 0;
  $coupon_amount = 0;
  $manjian_discount = 0;
  for ($i = 0, $n = sizeof($order_total_array); $i < $n; $i++){
        if($order_total_array[$i]['code'] == 'ot_order_discount'){
            $order_discount += $currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $order_discount += 0;
        }
        if($order_total_array[$i]['code'] == 'ot_group_pricing'){
            $vip +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $vip +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_coupon'){
            $rcd +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $rcd +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_big_orderd'){
            $special_discount +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $special_discount +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_discount_coupon'){
            $coupon_amount +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $coupon_amount +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_promotion'){
            $manjian_discount +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $manjian_discount +=0;
        }
  }
  $vip_rcd = $vip + $rcd;
  if($order_discount >= $vip_rcd){
     $discounts = $order_discount + $special_discount + $manjian_discount;
  }else{
     $discounts = $vip_rcd +$special_discount + $manjian_discount;
  }
     //       $shipping_modules = new shipping ('', $countries_iso_code_2, '', $post_postcode, $post_city);
    	//    $shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => $_SESSION['sendto']));
		   // $special_discount = $shipping_data['special_discount'];
		   $original_prices = $_SESSION ['cart']->show_total_original();
    		foreach($order_total_array as $key => $val){
    		    if($key == 0){		//	subtotal
    		        $total_price = $order->info['subtotal_show'];//$currencies->format_cl($val['value']);
    		        $order_total_str .= '<tr><th>' . TEXT_CART_ORIGINAL_PRICES . ':</th><td class="total_pice price_color">'.$currencies->format(($currencies->format_cl($val['value'])+$original_prices-$total_price), false). '</td></tr>';
    		        if($discounts+$original_prices-$total_price >0){
    		        $order_total_str .= '<tr><th>'.TEXT_CART_DISCOUNT.':</th><td class="total_pice price_color">-'.$currencies->format($discounts+$original_prices-$total_price,false).'<span class="image_down_arrow">'.'</span><span class="image_up_arrow" style="display:none;"></span></td></tr>';	
    		        }
    		        if($original_prices-$total_price >0){
    		        	$order_total_str .= '<tr><td colspan="2" ><table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none;"><tr><th>'.TEXT_PROMOTION_SAVE.':</th><td class="total_pice price_color">- '.$currencies->format($original_prices-$total_price,false).'</td></tr></table></td></tr>';
    		        }
    		        
    		        $grand_total = $total_price;
    		    }elseif($val['code'] == 'ot_cash_account'){		//	not show cash
    		        if($val['value']!=0 || $val['value']!=''){
    		            $cash_account = $currencies->format_cl($val['value']);
    		        }
    		        continue;
    		    }elseif($key == (sizeof($order_total_array)-1)){	//	total
    		        if($grand_total<0) $grand_total = 0;
    		        $show_grand_total = ($cash_account!=0 ? $currencies->format($grand_total, false) : $currencies->format($val['value']));
    		        $order_total_str.='<tr><th>' . TABLE_HEADING_TOTAL . ':</th><td class="total_pice price_color">'.$show_grand_total.'</td></tr>';
    		    }elseif($val['code'] == 'ot_coupon'){		//	coupon
    		        //if($coupon){
    		        $trail = zen_not_null($val['percentage_discount']) ? ' (<font color="red">'.round($val['percentage_discount'],2).'% ' . TEXT_DISCOUNT_OFF_SHOW . '</font>)' : '';
    		        if(substr($val['text'],0,1) == '-'){
    		            $grand_total -= $currencies->format_cl($val['value']);
    		            //rcd
    		            $order_total_str .= '<tr><td colspan="2" ><table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none;"><tr><th>'.str_replace(':', $trail, $val['title']).':</th><td class="total_pice price_color">- '.substr($val['text'],1).'</td></tr></table></td></tr>';
    		        }else{
    		            $grand_total += $currencies->format_cl($val['value']);
    		            $order_total_str .= '<tr><td colspan="2" ><table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none;"><tr><th>'.str_replace(':', $trail, $val['title']).':</th><td class="total_pice price_color">(+) '.$val['text'].'</td></tr></table></td></tr>';
    		        }
    		        //}
    		    }elseif ($val['code'] == 'ot_promotion'){
    		        
    		        $grand_total -= $currencies->format_cl($val['value']);
    		        // $order_total_str .= '<tr><th>'.$val['title'].'</th>';
    		        $order_total_str .= '<tr><td colspan="2" ><table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none;"><tr><th>'.$val['title'].'</th><td class="total_pice price_color">- '.substr($val['text'],1).'</td></tr></table></td></tr>';
    		        
    		    }elseif($val['code']=='ot_discount_coupon'){
                    $grand_total -= $currencies->format_cl($val['value']);
    		    	  $order_total_str .='<tr><th>'.TEXT_MY_COUPON.':</th><td class="total_pice price_color">- '.$currencies->format($coupon_amount,false).'</td></tr>';
    		    }else{	//	others
    		        $title = $trail = '';
    		        if($val['code']=='ot_shipping')	
    		            $title = TEXT_SHIPPING_CHARGE;
    		            else if($val['code']=='ot_group_pricing'){
    		                $title = TEXT_CART_VIP_DISCOUNT .' (<font color="red">'.round($val['percentage_discount'],2).'% ' . TEXT_DISCOUNT_OFF_SHOW . '</font>):';
    		            }else
    		                $title = $val['title'];
    		                if(substr($val['text'],0,1) == '-'){
    		                    $grand_total -= $currencies->format_cl($val['value']);
    		                    $val['text'] = '- '.substr($val['text'],1);
    		                    $order_total_str .= '<tr><td colspan="2" ><table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none;"><tr><th>'.$title.$trail.'</th><td class="total_pice price_color">'.$val['text'].'</td></tr></table></td></tr>';
    		                }else{
    		                    $grand_total += $currencies->format_cl($val['value']);
    		                    $val['text'] = $val['text']==TEXT_FREE_SHIPPING ? $val['text'] : ' '.$val['text'];
    		                    $order_total_str .= '<tr><th>'.$title.$trail.'</th><td class="total_pice price_color">'.$val['text'].'</td></tr>';
    		                }
    		                // $order_total_str .= '<tr><th>'.$title.$trail.'</th><td class="total_pice price_color">'.$val['text'].'</td></tr>';
    		    }
    		}
    		$order_total_str .= '</table>';
    		$smarty->assign ( 'order_total_str', $order_total_str );
    		$smarty->assign ( 'total_price', $currencies->format( $total_price, false ));
    		
		}
}
$smarty->assign ( 'obj_text', $obj_text );
$smarty->assign ( 'obj_info', $obj_info ); 


$pn = (isset ( $_GET ['pn'] ) && $_GET ['pn'] != '' ? $_GET ['pn'] : '');
if ($pn == 'edit' || $pn == 'new') {
	$tpl = DIR_WS_TEMPLATE_TPL . 'checkout/tpl_checkout_address.html';
} elseif ($pn == 'sc') {
	$tpl = DIR_WS_TEMPLATE_TPL . 'checkout/tpl_checkout_shipping.html';
} elseif ($pn == 'cm') {
	$tpl = DIR_WS_TEMPLATE_TPL . 'checkout/tpl_checkout_comment.html';
} elseif ($pn == 'lt') {
	$tpl = DIR_WS_TEMPLATE_TPL . 'checkout/tpl_checkout_address_list.html';
} else {
	$tpl = DIR_WS_TEMPLATE_TPL . 'checkout/tpl_checkout_normal.html';
}

$tpl_head = DIR_WS_TEMPLATE_TPL . 'tpl_play_order_head.html';
$smarty->assign ( 'checkout_default_url', zen_href_link ( FILENAME_CHECKOUT ));
$smarty->assign ( 'shoppingcart_default_url', zen_href_link ( FILENAME_SHOPPING_CART ));
$smarty->assign ( 'tpl_head', $tpl_head );
$smarty->assign ( 'tpl', $tpl );
$smarty->assign ( 'pn',$pn);
$smarty->assign ( 'messageStack', $messageStack );

if($write_shopping_log) {
	write_file("log/shopping_cart_log/", "checkout_mobile_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n");
}
?>