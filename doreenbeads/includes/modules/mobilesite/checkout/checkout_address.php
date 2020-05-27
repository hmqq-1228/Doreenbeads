<?php
global $db;
$error = false;
$error_info = '';
$aid = zen_db_prepare_input ( $_POST ['aId'] );
$gender = zen_db_prepare_input ( $_POST ['gender'] );
$firstname = zen_db_prepare_input ( $_POST ['firstname'] );
$lastname = zen_db_prepare_input ( $_POST ['lastname'] );
$street_address = zen_db_prepare_input ( $_POST ['street_address'] );
$suburb = zen_db_prepare_input ( $_POST ['suburb'] );
$postcode = zen_db_prepare_input ( $_POST ['postcode'] );
$city = zen_db_prepare_input ( $_POST ['city'] );
$telephone = zen_db_prepare_input ( $_POST ['entry_telephone'] );
$company = zen_db_prepare_input ( $_POST ['company'] );
$state = zen_db_prepare_input ( $_POST ['state'] );
$zone_id = zen_db_prepare_input ( $_POST ['zone_id'] );
$country = zen_db_prepare_input ( $_POST ['zone_country_id'] );
$tariff_number = zen_db_prepare_input($_POST['tariff_number']);
$email_address = zen_db_prepare_input($_POST['backup_email']);
$set_default = zen_db_prepare_input($_POST['set_default']);
$zip_code_rule = '/' . zen_db_prepare_input($_POST['zip_code_rule']) . '/i';
$zip_code_example = zen_db_prepare_input($_POST['zip_code_example']);

if (($gender != 'm') && ($gender != 'f')) {
	$error = true;
	$error_info .= ENTRY_GENDER_ERROR;
	$messageStack->add_session('add_address', ENTRY_GENDER_ERROR, 'error');
}
if (strlen ( $firstname ) < ENTRY_FIRST_NAME_MIN_LENGTH) {
	$error = true;
	$error_info .= ENTRY_FIRST_NAME_ERROR;
	$messageStack->add_session('add_address', ENTRY_FIRST_NAME_ERROR, 'error');
}
if ($zone_id == 0 && strlen ( $lastname ) < ENTRY_LAST_NAME_MIN_LENGTH) {
	$error = true;
	$error_info .= ENTRY_LAST_NAME_ERROR;
	$messageStack->add_session('add_address', ENTRY_LAST_NAME_ERROR, 'error');
}
if (strlen ( $street_address ) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
	$error = true;
	$error_info .= ENTRY_STREET_ADDRESS_ERROR;
	$messageStack->add_session('add_address', ENTRY_STREET_ADDRESS_ERROR, 'error');
}
if($street_address == $suburb){
	$error = true;
	$error_info .= ENTRY_FL_NAME_SAME_ERROR;
	$messageStack->add_session('add_address', ENTRY_FL_NAME_SAME_ERROR, 'error');
}
if (strlen ( $city ) < ENTRY_CITY_MIN_LENGTH) {
	$error = true;
	$error_info .= ENTRY_CITY_ERROR;
	$messageStack->add_session('add_address', ENTRY_CITY_ERROR, 'error');
}
if (strlen ( $postcode ) < ENTRY_POSTCODE_MIN_LENGTH) {
	$error = true;
	$error_info .= ENTRY_POST_CODE_ERROR;
	$messageStack->add_session('add_address', ENTRY_POST_CODE_ERROR, 'error');
}else{
  	if($zip_code_rule != '//i'){
  		if(!preg_match($zip_code_rule, $postcode)){
  			$error = true;
  			$error_info .= CHECKOUT_ZIP_CODE_ERROR . str_replace(',', ' ' . TEXT_OR . ' ', $zip_code_example);
  			$messageStack->add('addressbook', CHECKOUT_ZIP_CODE_ERROR . str_replace(',', ' ' . TEXT_OR . ' ', $zip_code_example));
  		}
  	}
}
if (! is_numeric ( $country )) {
	$error = true;
	$error_info .= ENTRY_COUNTRY_ERROR;
	$messageStack->add_session('add_address', ENTRY_COUNTRY_ERROR, 'error');
}

//echo $error_info;die;
/*if (strtolower ( str_replace ( ' ', '', $state ) ) == 'puertorico' || strtolower ( str_replace ( ' ', '', $state ) ) == 'portrico') {
	if ($country != 172)
		$error = true;
	$error_info .= ENTRY_PUEROTORICO_ERROR;
}*/
if ($error == false) {
	$sql_data_array = array (
			array (
					'fieldName' => 'entry_firstname',
					'value' => $firstname,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_lastname',
					'value' => $lastname,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_company',
					'value' => $company,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_street_address',
					'value' => $street_address,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_postcode',
					'value' => $postcode,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_city',
					'value' => $city,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_country_id',
					'value' => $country,
					'type' => 'integer'
			),
			array (
					'fieldName' => 'entry_gender',
					'value' => $gender,
					'type' => 'enum:m|f'
			),
			array (
					'fieldName' => 'entry_suburb',
					'value' => $suburb,
					'type' => 'string'
			),
			array (
					'fieldName' => 'entry_telephone',
					'value' => $telephone,
					'type' => 'string'
			),
			array(
					'fieldName'=>'tariff_number', 
					'value'=>$tariff_number,
					'type'=>'string'
			),
			array(
					'fieldName'=>'backup_email_address', 
					'value'=>$email_address, 
					'type'=>'string'
			)
	);
	if ($zone_id > 0) {
		$sql_data_array [] = array (
				'fieldName' => 'entry_zone_id',
				'value' => $zone_id,
				'type' => 'integer'
		);
		$sql_data_array [] = array (
				'fieldName' => 'entry_state',
				'value' => '',
				'type' => 'string'
		);
	} else {
		$sql_data_array [] = array (
				'fieldName' => 'entry_zone_id',
				'value' => '0',
				'type' => 'integer'
		);
		$sql_data_array [] = array (
				'fieldName' => 'entry_state',
				'value' => $state,
				'type' => 'string'
		);
	}
	/*
	if ($aid) {
		$where_clause = "address_book_id = :edit and customers_id = :customersID";
		$where_clause = $db->bindVars ( $where_clause, ':customersID', $_SESSION ['customer_id'], 'integer' );
		$where_clause = $db->bindVars ( $where_clause, ':edit', $aid, 'integer' );
		$db->perform ( TABLE_ADDRESS_BOOK, $sql_data_array, 'update', $where_clause );
		check_remote_area_byID ( $aid );
		$_SESSION ['reset_shipping_fee'] = 'true';
		unset ( $_SESSION ['shipping'] );
		$zco_notifier->notify ( 'NOTIFY_HEADER_ADDRESS_BOOK_ENTRY_UPDATE_DONE' );
		if ($set_default) {
			$_SESSION ['customer_country_id'] = $country;
			$_SESSION ['customer_zone_id'] = (($zone_id > 0) ? ( int ) $zone_id : '0');
			$_SESSION ['customer_default_address_id'] = $aid;
			$sql_data_array_default_address_id [] = array (
					'fieldName' => 'customers_default_address_id',
					'value' => $aid,
					'type' => 'integer'
			);
			$where_clause = "customers_id = :customersID";
			$where_clause = $db->bindVars ( $where_clause, ':customersID', $_SESSION ['customer_id'], 'integer' );
			$db->perform ( TABLE_CUSTOMERS, $sql_data_array_default_address_id, 'update', $where_clause );
		}
	} else {
		$sql_data_array [] = array (
				'fieldName' => 'customers_id',
				'value' => $_SESSION ['customer_id'],
				'type' => 'integer'
		);
		
		$db->perform ( TABLE_ADDRESS_BOOK, $sql_data_array );
		$new_address_book_id = $db->Insert_ID ();

		if (isset ( $new_address_book_id )) {
			check_remote_area_byID ( $new_address_book_id );
			$_SESSION ['sendto'] = $new_address_book_id;
			$input_info_arr ['sendto'] = $new_address_book_id;
			$_SESSION ['reset_shipping_fee'] = 'true';
			unset ( $_SESSION ['shipping'] );
		}

		$sql = "select address_book_id, entry_firstname , entry_lastname ,entry_gender , entry_street_address ,  entry_suburb , entry_city , entry_postcode ,entry_state , entry_zone_id , entry_country_id ,entry_telephone from " . TABLE_ADDRESS_BOOK . " where customers_id = :customersID  order by address_book_id";
		$sql = $db->bindVars ( $sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
		$result = $db->Execute ( $sql );
		if ($result->RecordCount () == 1) {
			$_SESSION ['customer_country_id'] = $country;
			$_SESSION ['customer_zone_id'] = (($zone_id > 0) ? ( int ) $zone_id : '0');
			$_SESSION ['customer_default_address_id'] = $new_address_book_id;
			$sql_data_array_default_address_id [] = array (
					'fieldName' => 'customers_default_address_id',
					'value' => $new_address_book_id,
					'type' => 'integer'
			);
			$where_clause = "customers_id = :customersID";
			$where_clause = $db->bindVars ( $where_clause, ':customersID', $_SESSION ['customer_id'], 'integer' );
			$db->perform ( TABLE_CUSTOMERS, $sql_data_array_default_address_id, 'update', $where_clause );
		}
	}
	*/
	
	$address_book_info = array(
    	'firstname' => $firstname,
    	'lastname' => $lastname,
    	'street_address' => $street_address,
    	'postcode' => $postcode,
    	'city' => $city,
    	'country' => $country,
    	'tariff_number' => $tariff_number,
    	'telephone' => $telephone,
    	'email_address' => $email_address,
    	'gender' => $gender,
    	'company' => $company,
    	'suburb' => $suburb,
    	'zone_id' => $zone_id,
    	'state' => $state
    );
	
	$result_address = add_or_update_address_book($_SESSION['customer_id'], $address_book_info, $aid, $set_default);
	if(empty($aid) && $result_address['id'] > 0) {
		$_SESSION['sendto'] = $result_address['id'];
	}
	$zco_notifier->notify('NOTIFY_HEADER_ADDRESS_BOOK_ENTRY_UPDATE_DONE' );
}
zen_redirect ( zen_href_link ( 'checkout', 'pn=lt' ) );
?>