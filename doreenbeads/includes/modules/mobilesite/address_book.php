<?php

/**
 * Header code file for the Address Book page
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 2944 2006-02-02 17:13:18Z wilt $
 */
// This should be first line of the script:
//define('HEADING_TITLE', 'My Personal Address Book');
$zco_notifier->notify('NOTIFY_HEADER_START_ADDRESS_BOOK');
//jessa 2010-02-23
/*if (isset ($_GET['action']) && $_GET['action'] == 'checkout_shipping') {
	$_SESSION['checkout_manage_address'] = 'true';
} else {
	$_SESSION['checkout_manage_address'] = 'false';
}*/
//eof jessa 2010-02-23

if (!$_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require DIR_WS_LANGUAGES . 'mobilesite/' . $_SESSION['language'] . '/address_book.php';

if (isset ($_GET['action']) && ($_GET['action'] == 'add')) {
	$act = 'add';
}
if (isset ($_GET['action']) && ($_GET['action'] == 'del') && isset ($_GET['del']) && is_numeric($_GET['del'])) {
	$act = 'del';

	$del_address_sql = "select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_gender as gender, entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,entry_telephone as telephone,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id,z.zone_name,c.countries_name , tariff_number , backup_email_address 
						   from " . TABLE_ADDRESS_BOOK . " as ab left join " . TABLE_ZONES . " as z on z.zone_id = ab.entry_zone_id left join " . TABLE_COUNTRIES . " as c on c.countries_id = ab.entry_country_id 
						   where customers_id = :customersID AND address_book_id = :addressBookID ";

	$del_address_sql = $db->bindVars($del_address_sql, ':customersID', $_SESSION['customer_id'], 'integer');
	$del_address_sql = $db->bindVars($del_address_sql, ':addressBookID', $_GET['del'], 'integer');

	$del_address_query = $db->Execute($del_address_sql);

	if ($del_address_query->RecordCount() == 0) {
		$selectedAddress['country'] = '223';
		$selectedAddress['state'] = '';
		$selectedAddress['zone'] = '1';
	}

	$del_address_info = array (
		'address_book_id' => $del_address_query->fields['address_book_id'],
		'firstname' => $del_address_query->fields['firstname'],
		'lastname' => $del_address_query->fields['lastname'],
		'gender' => $del_address_query->fields['gender'],
		'company' => $del_address_query->fields['company'],
		'street_address' => $del_address_query->fields['street_address'],
		'suburb' => $del_address_query->fields['suburb'],
		'city' => $del_address_query->fields['city'],
		'postcode' => $del_address_query->fields['postcode'],
		'telephone' => $del_address_query->fields['telephone'],
		'state' => $del_address_query->fields['state'],
		'zone_id' => $del_address_query->fields['zone_id'],
		'country_id' => $del_address_query->fields['country_id'],
		'zone' => $del_address_query->fields['zone_name'],
		'country' => $del_address_query->fields['countries_name'],
		'tariff_number' => $del_address_query->fields['tariff_number'],
		'backup_email' => $del_address_query->fields['backup_email_address']
	);

	$smarty->assign('del_address_info', $del_address_info);
	$smarty->assign('del_address_id', $_GET['del']);
}

if (isset ($_GET['action']) && ($_GET['action'] == 'deleteconfirm') && isset ($_GET['delete']) && is_numeric($_GET['delete'])) {
	$act = 'del';
	$sql = "DELETE FROM " . TABLE_ADDRESS_BOOK . "
	          WHERE  address_book_id = :delete
	          AND    customers_id = :customersID";

	$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
	$sql = $db->bindVars($sql, ':delete', $_GET['delete'], 'integer');
	$db->Execute($sql);

	$zco_notifier->notify('NOTIFY_HEADER_ADDRESS_BOOK_DELETION_DONE');

	$messageStack->add_session('addressbook_success', SUCCESS_ADDRESS_BOOK_ENTRY_DELETED, 'success');

	zen_redirect(zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	//jessa 2010-02-23
	/*if ($_SESSION['checkout_manage_address'] == 'true') {
		$_SESSION['reset_shipping_fee'] = 'false';
		zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
	} else {
		zen_redirect(zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	}*/
	//eof jessa 2010-02-23
}
if (isset ($_GET['edit']) && is_numeric($_GET['edit'])) {
	if ($_GET['edit'] == $_SESSION['customer_default_address_id']) {
		$default = true;
	} else {
		$default = false;
	}
	$smarty->assign('default', $default);
	$act = 'update';
	$entry_query = "SELECT address_book_id,entry_gender, entry_company, entry_firstname, entry_lastname,
							 entry_street_address, entry_suburb, entry_postcode, entry_city,
							 entry_state, entry_zone_id, entry_country_id, entry_telephone, customers_telephone , tariff_number , backup_email_address
					  FROM   " . TABLE_ADDRESS_BOOK . " , " . TABLE_CUSTOMERS . "
					  WHERE  " . TABLE_ADDRESS_BOOK . ".customers_id = :customersID
					  AND    address_book_id = :addressBookID 
					  AND	" . TABLE_ADDRESS_BOOK . ".customers_id = " . TABLE_CUSTOMERS . ".customers_id";

	$entry_query = $db->bindVars($entry_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$entry_query = $db->bindVars($entry_query, ':addressBookID', $_GET['edit'], 'integer');

	$entry = $db->Execute($entry_query);

	while (!$entry->EOF) {
		$edit_arr[] = array (
			'address_book_id' => $entry->fields['address_book_id'],
			'entry_gender' => $entry->fields['entry_gender'],
			'entry_company' => $entry->fields['entry_company'],
			'entry_firstname' => $entry->fields['entry_firstname'],
			'entry_lastname' => $entry->fields['entry_lastname'],
			'entry_street_address' => $entry->fields['entry_street_address'],
			'entry_suburb' => $entry->fields['entry_suburb'],
			'entry_postcode' => $entry->fields['entry_postcode'],
			'entry_city' => $entry->fields['entry_city'],

			'entry_state' => $entry->fields['entry_state'],
			'entry_zone_id' => $entry->fields['entry_zone_id'],
			'entry_country_id' => $entry->fields['entry_country_id'],

			'entry_telephone' => $entry->fields['entry_telephone'],
			'customers_telephone' => $entry->fields['customers_telephone'],
			'tariff_number' => $entry->fields['tariff_number'],
			'backup_email_address' => $entry->fields['backup_email_address']
		);
		$entry->MoveNext();
	}

	//echo $entry->fields['entry_firstname'];
	//var_dump($edit_arr);
	if ($entry->RecordCount() <= 0) {

		$messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

		zen_redirect(zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	}

	if (!isset ($zone_name) || (int) $zone_name == 0)
		$zone_name = zen_get_zone_name($entry->fields['entry_country_id'], $entry->fields['entry_zone_id'], $entry->fields['entry_state']);
	if (!isset ($zone_id) || (int) $zone_id == 0)
		$zone_id = $entry->fields['entry_zone_id'];
	$smarty->assign('edit_arr', $edit_arr);

}
if (isset ($_GET['action']) && (($_GET['action'] == 'process') || ($_GET['action'] == 'update'))) {
	$process = true;

	if (ACCOUNT_GENDER == 'true')
		$gender = zen_db_prepare_input($_POST['gender']);

	if (ACCOUNT_COMPANY == 'true')
		$company = zen_db_prepare_input($_POST['company']);

	$firstname = zen_db_prepare_input($_POST['firstname']);
	$lastname = zen_db_prepare_input($_POST['lastname']);
	$street_address = zen_db_prepare_input($_POST['address1']);
	//$address2 = zen_db_prepare_input($_POST['address2']);echo $address2;
	if (ACCOUNT_SUBURB == 'true')
		$suburb = zen_db_prepare_input($_POST['suburb']);

	$postcode = zen_db_prepare_input($_POST['post']);
	$city = zen_db_prepare_input($_POST['city']);
	$telephone = zen_db_prepare_input($_POST['tel']);
	$tariff_number = zen_db_prepare_input($_POST['tariff']);
	$backup_email = zen_db_prepare_input($_POST['backup_email']);
	$zip_code_rule = '/' . zen_db_prepare_input($_POST['zip_code_rule']) . '/i';
	$zip_code_example = zen_db_prepare_input($_POST['zip_code_example']);
	$primary = zen_db_prepare_input($_POST['primary']);
	/**
	 * error checking when updating or adding an entry
	*/

	if (ACCOUNT_STATE == 'true') {
		$state = zen_db_prepare_input($_POST['state']);

		if (isset ($_POST['zone_id'])) {
			$zone_id = zen_db_prepare_input($_POST['zone_id']);

		} else {
			$zone_id = false;
		}
	}

	//echo $zone_id;
	$country = zen_db_prepare_input($_POST['zone_country_id']);

	//echo ' I SEE: country=' . $country . '&nbsp;&nbsp;&nbsp;state=' . $state . '&nbsp;&nbsp;&nbsp;zone_id=' . $zone_id;

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;
			$messageStack->add('addressbook', ENTRY_GENDER_ERROR);
		}
	}
	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_FIRST_NAME_ERROR);
	}
	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_LAST_NAME_ERROR);
	}

	if ($_SESSION['languages_id'] != '6') {
		if ($firstname == $lastname) {
			$error = true;
			$messageStack->add('addressbook', ENTRY_FL_NAME_SAME_ERROR);
		}
	}

	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_STREET_ADDRESS_ERROR);
	}
	if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_CITY_ERROR);
	}
	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_TELEPHONE_NUMBER_ERROR);
	}

	if (ACCOUNT_STATE == 'true') {
		$check_query = "SELECT count(*) AS total
							FROM " . TABLE_ZONES . "
							WHERE zone_country_id = :zoneCountryID";
		$check_query = $db->bindVars($check_query, ':zoneCountryID', $country, 'integer');
		$check = $db->Execute($check_query);
		$entry_state_has_zones = ($check->fields['total'] > 0);

		if ($entry_state_has_zones == true) {
			$zone_query = "SELECT distinct zone_id, zone_name, zone_code
								 FROM " . TABLE_ZONES . "
								 WHERE zone_country_id = :zoneCountryID
								 AND " .
			 ((trim($state) != '' && $zone_id == 0) ? "(upper(zone_name) like ':zoneState%' OR upper(zone_code) like '%:zoneState%') OR " : "") .
			"zone_id = :zoneID
								 ORDER BY zone_code ASC, zone_name";

			$zone_query = $db->bindVars($zone_query, ':zoneCountryID', $country, 'integer');
			$zone_query = $db->bindVars($zone_query, ':zoneState', strtoupper($state), 'noquotestring');
			$zone_query = $db->bindVars($zone_query, ':zoneID', $zone_id, 'integer');
			//echo $zone_query;exit;
			$zone = $db->Execute($zone_query);

			//look for an exact match on zone ISO code
			$found_exact_iso_match = ($zone->RecordCount() == 1);

			if ($zone->RecordCount() > 1) {
				while (!$zone->EOF && !$found_exact_iso_match) {
					if (strtoupper($zone->fields['zone_code']) == strtoupper($state)) {
						$found_exact_iso_match = true;
						continue;
					}
					$zone->MoveNext();
				}
			}

			if ($found_exact_iso_match) {
				$zone_id = $zone->fields['zone_id'];
				$zone_name = $zone->fields['zone_name'];
			} else {
				$error = true;
				$error_state_input = true;
				$messageStack->add('addressbook', ENTRY_STATE_ERROR_SELECT);
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;
				$error_state_input = true;
				$messageStack->add('addressbook', ENTRY_STATE_ERROR);
			}
		}
	}

	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_POST_CODE_ERROR);
	}else{
  		if($zip_code_rule != '//i'){
  			if(!preg_match($zip_code_rule, $postcode)){
  				$error = true;
  				$messageStack->add('addressbook', CHECKOUT_ZIP_CODE_ERROR . str_replace(',', ' ' . TEXT_OR . ' ', $zip_code_example));
  			}
  		}
  }
	if (!is_numeric($country)) {
		$error = true;
		$messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);
	}

	if (strtolower(str_replace(' ', '', $state)) == 'puertorico' || strtolower(str_replace(' ', '', $state)) == 'portrico') {
		if ($country != 172)
			$error = true;
		$messageStack->add('addressbook', ENTRY_PUERTORICO_ERROR);
	}

	if ($_GET['editing'] > 0) {
		$address_where = ' and address_book_id != ' . $_GET['editing'];
	}
	$address_sql = 'select * from ' . TABLE_ADDRESS_BOOK . ' where customers_id = ' . $_SESSION['customer_id'] . $address_where;
	$address_sql_check = $db->Execute($address_sql);
	while (!$address_sql_check->EOF) {
		if ($error == false) {
			if ($address_sql_check->fields['entry_gender'] == $gender && $address_sql_check->fields['entry_company'] == $company && $address_sql_check->fields['entry_firstname'] == $firstname && $address_sql_check->fields['entry_lastname'] == $lastname && $address_sql_check->fields['entry_street_address'] == $street_address && $address_sql_check->fields['entry_postcode'] == $postcode && $address_sql_check->fields['entry_city'] == $city && $address_sql_check->fields['entry_state'] == $state && $address_sql_check->fields['entry_country_id'] == $country && $address_sql_check->fields['entry_zone_id'] == $zone_id && $address_sql_check->fields['telephone_number'] == $telephone_number && $address_sql_check->fields['tariff_number'] == $tariff_number && $address_sql_check->fields['backup_email_address'] == $backup_email) {
				$error = true;
				//$error_info .= ENTRY_EXISTS_ERROR;
				$messageStack->add('addressbook', ENTRY_EXISTS_ERROR);
			}
		}
		$address_sql_check->MoveNext();
	}

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
				'fieldName' => 'entry_telephone',
				'value' => $telephone,
				'type' => 'string'
			),
			array (
				'fieldName' => 'tariff_number',
				'value' => $tariff_number,
				'type' => 'string'
			),
			array (
				'fieldName' => 'backup_email_address',
				'value' => $backup_email,
				'type' => 'string'
			),
            array(
                'fieldName'=>'last_modify_time',
                'value'=>date('Y-m-d H:i:s'),
                'type'=>'date'
            )
		);

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array[] = array (
				'fieldName' => 'entry_gender',
				'value' => $gender,
				'type' => 'enum:m|f'
			);
		if (ACCOUNT_COMPANY == 'true')
			$sql_data_array[] = array (
				'fieldName' => 'entry_company',
				'value' => $company,
				'type' => 'string'
			);
		if (ACCOUNT_SUBURB == 'true')
			$sql_data_array[] = array (
				'fieldName' => 'entry_suburb',
				'value' => $suburb,
				'type' => 'string'
			);
		if (ACCOUNT_STATE == 'true') {
			if ($zone_id > 0) {
				$sql_data_array[] = array (
					'fieldName' => 'entry_zone_id',
					'value' => $zone_id,
					'type' => 'integer'
				);
				$sql_data_array[] = array (
					'fieldName' => 'entry_state',
					'value' => '',
					'type' => 'string'
				);
			} else {
				$sql_data_array[] = array (
					'fieldName' => 'entry_zone_id',
					'value' => '0',
					'type' => 'integer'
				);
				$sql_data_array[] = array (
					'fieldName' => 'entry_state',
					'value' => $state,
					'type' => 'string'
				);
			}
		}

		if ($_GET['action'] == 'update') {

			$where_clause = "address_book_id = :edit and customers_id = :customersID";
			$where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
			$where_clause = $db->bindVars($where_clause, ':edit', $_GET['editing'], 'integer');

			$db->perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', $where_clause);
			
			$update_default_address = 'update ' . TABLE_CUSTOMERS . ' set customers_default_address_id = :edit where customers_id = :customersID';
			$update_default_address = $db->bindVars($update_default_address, ':customersID', $_SESSION['customer_id'], 'integer');
			$update_default_address = $db->bindVars($update_default_address, ':edit', $_GET['editing'], 'integer');
			$db->Execute($update_default_address);

			$zco_notifier->notify('NOTIFY_MODULE_ADDRESS_BOOK_UPDATED_ADDRESS_BOOK_RECORD', array_merge(array (
				'address_book_id' => $_GET['editing'],
				'customers_id' => $_SESSION['customer_id']
			), $sql_data_array));

		} else {

			$sql_data_array[] = array (
				'fieldName' => 'customers_id',
				'value' => $_SESSION['customer_id'],
				'type' => 'integer'
			);

            $sql_data_array[] = array('fieldName'=>'create_time', 'value'=>date('Y-m-d H:i:s'), 'type'=>'date');
			$db->perform(TABLE_ADDRESS_BOOK, $sql_data_array);

			$new_address_book_id = $db->Insert_ID();
			$zco_notifier->notify('NOTIFY_MODULE_ADDRESS_BOOK_ADDED_ADDRESS_BOOK_RECORD', array_merge(array (
				'address_id' => $new_address_book_id
			), $sql_data_array));

			$sql = "select count(*) as total FROM " . TABLE_ADDRESS_BOOK . " WHERE  customers_id = :customersID";
			$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
			$result = $db->Execute($sql);

		}

		//if ($_SESSION['address_select'] == 'true'){
		/*if ((isset ($_POST['address_checkout']) && $_POST['address_checkout'] == 'edit') || $_SESSION['checkout_manage_address'] == 'true') {
			zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
		} else {
			$messageStack->add_session('addressbook_success', SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED, 'success');
		}*/
		$messageStack->add_session('addressbook_success', SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED, 'success');
		zen_redirect(zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	}

}
if (isset ($_GET['action']) && ($_GET['action'] == 'default') && is_numeric($_GET['id'])) {

	$_SESSION['customer_default_address_id'] = (int) $_GET['id'];

	$sql_data_array = array (
		array (
			'fieldName' => 'customers_default_address_id',
			'value' => $_GET['id'],
			'type' => 'integer'
		)
	);
	$where_clause = "customers_id = :customersID";
	$where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
	$db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);

	zen_redirect(zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));

} else {

	$default_select_id = !empty($_GET['edit']) && !empty($entry->fields['entry_country_id']) ? $entry->fields['entry_country_id'] : zen_get_selected_country($_SESSION['languages_id']);
	$flag_show_pulldown_query = 'select zone_country_id from ' . TABLE_ZONES . ' where zone_country_id="' . $default_select_id . '" limit 1 ';
	$flag_show_pulldown = $db->Execute($flag_show_pulldown_query);
	if ($flag_show_pulldown->RecordCount() > 0) {
		if ($edit_arr[0]['entry_country_id'] > 0) {
			$obj_infomation = zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($edit_arr[0]['entry_country_id']), 0, 'id="stateZone"') . zen_draw_input_field('state', '', 'class="hiddenField"');
		} else {
			$obj_infomation = zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($default_select_id), 0, 'id="stateZone"') . zen_draw_input_field('state', '', 'class="hiddenField"');
		}
	} else {
		$obj_infomation = zen_draw_input_field('state', $edit_arr[0]['entry_state'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"', 'text', 'text') . zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down(223), '', 'id="stateZone" class="hiddenField"');
	
	}
}

$addresses_query = "SELECT address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as zone_country_id,
						   entry_telephone as telephone
                    FROM   " . TABLE_ADDRESS_BOOK . "
                    WHERE  customers_id = :customersID
                    ORDER BY firstname, lastname";
$addresses_query = $db->bindVars($addresses_query, ':customersID', $_SESSION['customer_id'], 'integer');
//echo $addresses_query;
$addresses = $db->Execute($addresses_query);

if (!$addresses->RecordCount()) {

	$act = 'add';
}

if(empty($_GET['edit'])) {
	$addresses->fields['zone_country_id'] = 0;
} else {
	if($addresses->RecordCount() > 0) {
		if ($addresses->fields['zone_country_id'] == '' || $addresses->fields['zone_country_id'] == 0) {
			$addresses->fields['zone_country_id'] = zen_get_selected_country($_SESSION['languages_id']);
		}
		/*used  update*/
		if ($edit_arr[0]['entry_country_id'] > 0) {
			$addresses->fields['zone_country_id'] = $edit_arr[0]['entry_country_id'];
		}
	}
}

$country_select_name = 'zone_country_id';

$country_select = zen_get_country_select($country_select_name, $addresses->fields['zone_country_id'], $_SESSION['languages_id']);
$smarty->assign('country_select', $country_select);
//print_r($country_select);
/*select country above*/

$ad_country_id = $addresses->fields['zone_country_id'];

if (isset ($ad_country_id) && $ad_country_id != '') {
	$zones = zen_get_country_zones($ad_country_id);
}
$obj_info = zen_js_zone_list('SelectedCountry', 'theForm', 'zone_id');


//print_r($obj_infomation);
$smarty->assign('zone', $zones);
$smarty->assign('obj_info', $obj_info);
$smarty->assign('obj_infomation', $obj_infomation);

/* 
 * $flag_show_pulldown_query
 * 
 */

$state = '';

$zone_id = 0;

$addressBookId = $_POST['addressBookId'];
//echo $addressBookId;

$address_listing = $db->Execute("select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_gender as gender, entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,entry_telephone as telephone,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id,z.zone_name,c.countries_name , tariff_number , backup_email_address 
						   from " . TABLE_ADDRESS_BOOK . " as ab left join " . TABLE_ZONES . " as z on z.zone_id = ab.entry_zone_id left join " . TABLE_COUNTRIES . " as c on c.countries_id = ab.entry_country_id 
						   where customers_id = " . $_SESSION['customer_id']);

$selectedAddress = array ();
//var_dump($selectedAddress);
if ($address_listing->RecordCount() == 0) {
	$selectedAddress['country'] = '223';
	$selectedAddress['state'] = '';
	$selectedAddress['zone'] = '1';
}

while (!$address_listing->EOF) {
	$address[] = array (
		'address_book_id' => $address_listing->fields['address_book_id'],
		'firstname' => $address_listing->fields['firstname'],
		'lastname' => $address_listing->fields['lastname'],
		'gender' => $address_listing->fields['gender'],
		'company' => $address_listing->fields['company'],
		'street_address' => $address_listing->fields['street_address'],
		'suburb' => $address_listing->fields['suburb'],
		'city' => $address_listing->fields['city'],
		'postcode' => $address_listing->fields['postcode'],
		'telephone' => $address_listing->fields['telephone'],
		'state' => $address_listing->fields['state'],
		'zone_id' => $address_listing->fields['zone_id'],
		'country_id' => $address_listing->fields['country_id'],
		'zone' => $address_listing->fields['zone_name'],
		'country' => $address_listing->fields['countries_name'],
		'tariff_number' => $address_listing->fields['tariff_number'],
		'backup_email' => $address_listing->fields['backup_email_address']
	);
	$address_listing->MoveNext();
}
//print_r($address);
$length = count($address);
$smarty->assign('length', $length);
$smarty->assign('customers_default_address_id', $_SESSION['customer_default_address_id']);
$smarty->assign('address', $address);

$address_listing = $db->Execute("select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_gender as gender, entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,entry_telephone as telephone,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id
						   from " . TABLE_ADDRESS_BOOK . "
						   where customers_id = " . $_SESSION['customer_id']);

$default_address = $db->Execute("SELECT address_book_id, tariff_number , backup_email_address, entry_firstname as firstname,entry_lastname as lastname,entry_company as company,entry_street_address as street_address,entry_suburb as suburb,entry_city as city,entry_postcode as postcode,entry_telephone as telephone,entry_state as state,entry_country_id as country,z.zone_name,c.countries_name FROM " . TABLE_ADDRESS_BOOK . " as ab left join " . TABLE_ZONES . " as z on z.zone_id = ab.entry_zone_id left join " . TABLE_COUNTRIES . " as c on c.countries_id = ab.entry_country_id 
		WHERE customers_id = " . $_SESSION['customer_id'] . " AND address_book_id = " . $_SESSION['customer_default_address_id']);
while (!$default_address->EOF) {
	$def_address[] = array (
		'address_book_id' => $default_address->fields['address_book_id'],
		'firstname' => $default_address->fields['firstname'],
		'lastname' => $default_address->fields['lastname'],
		'company' => $default_address->fields['company'],
		'street_address' => $default_address->fields['street_address'],
		'suburb' => $default_address->fields['suburb'],
		'city' => $default_address->fields['city'],
		'postcode' => $default_address->fields['postcode'],
		'telephone' => $default_address->fields['telephone'],
		'state' => $default_address->fields['state'],
		'zone' => $default_address->fields['zone_name'],
		'country' => $default_address->fields['countries_name'],
		'tariff_number' => $address_listing->fields['tariff_number'],
		'backup_email' => $default_address->fields['backup_email_address']
	);
	$default_address->MoveNext();
}
//print_r($def_address);
$smarty->assign('def_address', $def_address);

$select_country_id = SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY;
if ($_SESSION['languages_id'] == 3) {
	$select_country_id = 176;
}
$flag_show_pulldown_query = $db->Execute('select zone_id from ' . TABLE_ZONES . ' where zone_country_id=' . $select_country_id . ' limit 1 ');
$flag_show_pulldown_states = $flag_show_pulldown_query->RecordCount() > 0 ? true : false;

//$act=isset($_GET['act'])?$_GET['act']:"";

switch ($act) {
	case 'add' :
		$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_address_book_add.html';
		break;
	case 'del' :
		$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_address_book_del.html';
		break;
	case 'update' :
		$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_address_book_update.html';
		break;
	default :
		$tpl = DIR_WS_TEMPLATE_TPL . 'tpl_address_book_select.html';
}

/* if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
 	$breadcrumb->add(NAVBAR_TITLE_MODIFY_ENTRY);
 } elseif (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
 	$breadcrumb->add(NAVBAR_TITLE_DELETE_ENTRY);
 } else {
 	$breadcrumb->add(NAVBAR_TITLE_ADD_ENTRY);
 }*/

$smarty->assign('tpl', $tpl);
$smarty->assign('messageStack', $messageStack);

$zco_notifier->notify('NOTIFY_HEADER_END_ADDRESS_BOOK');
?>