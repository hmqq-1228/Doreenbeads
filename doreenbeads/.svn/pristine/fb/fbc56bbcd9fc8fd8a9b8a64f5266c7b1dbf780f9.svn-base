<?php
require('includes/application_top.php');
if(empty($_SESSION['customer_id'])) {
	die('success');
}
if(isset($_POST['action']) && $_POST['action']=='new_address'){
  $error =false;
  $error_info='';
  if (ACCOUNT_GENDER == 'true') $gender = zen_db_prepare_input($_POST['gender']);
  if (ACCOUNT_COMPANY == 'true') $company = zen_db_prepare_input($_POST['company']);
  $firstname = zen_db_prepare_input($_POST['first']);
  $lastname = zen_db_prepare_input($_POST['last']);
  $street_address = zen_db_prepare_input($_POST['street_address']);
  if (ACCOUNT_SUBURB == 'true') $suburb = zen_db_prepare_input($_POST['suburb']);
  $postcode = zen_db_prepare_input($_POST['postcode']);
  $city = zen_db_prepare_input($_POST['city']);
  $telephone = zen_db_prepare_input($_POST['telephone']);
  $tariff_number = zen_db_prepare_input($_POST['tariff_number']);
  $email_address = zen_db_prepare_input($_POST['email_address']);
  $zip_code_rule = '/' . zen_db_prepare_input($_POST['zip_code_rule']) . '/i';
  $zip_code_example = zen_db_prepare_input($_POST['zip_code_example']);
  $selected_address = intval($_POST['selected_address']);
  if (ACCOUNT_STATE == 'true') {
    $state = zen_db_prepare_input($_POST['state']);
    if (isset($_POST['zone_id'])) {
      $zone_id = zen_db_prepare_input($_POST['zone_id']);
    } else {
      $zone_id = false;
    }
  }
  $country = zen_db_prepare_input($_POST['zone_country_id']);
/*  echo ' I SEE: country=' . $country . '&nbsp;&nbsp;&nbsp;state=' . $state . '&nbsp;&nbsp;&nbsp;zone_id=' . $zone_id
  .'<br/>first:'.$firstname
  .'<br/>last:'.$lastname
  .'<br/>street:'.$street_address
  .'<br/>post:'.$postcode
  .'<br/>ge:'.$gender
  .'<br/>city:'.$city
  .'<br/>tel:'.$telephone
  .'<br/>cod:'.$company
  .'<br/>sub:'.$suburb;*/
  if (ACCOUNT_GENDER == 'true') {
    if ( ($gender != 'm') && ($gender != 'f') ) {
      $error = true;
	  $error_info .= ENTRY_GENDER_ERROR.'<br/>';
      $messageStack->add('addressbook', ENTRY_GENDER_ERROR);
    }
  }
  if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
    $error = true;
	$error_info .= ENTRY_FIRST_NAME_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_FIRST_NAME_ERROR);
  }
  if($firstname == $lastname){
  	$error = true;
  	$error_info .= ENTRY_FL_NAME_SAME_ERROR.'<br/>';
  	$messageStack->add('addressbook',ENTRY_FL_NAME_SAME_ERROR);
  }
  if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
    $error = true;
	$error_info .= ENTRY_LAST_NAME_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_LAST_NAME_ERROR);
  }
  if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
    $error = true;
	$error_info .= ENTRY_STREET_ADDRESS_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_STREET_ADDRESS_ERROR);
  }
  if (ACCOUNT_SUBURB == 'true' && $street_address == $suburb) {
  	$error = true;
  	$error_info .= ENTRY_FS_ADDRESS_SAME_ERROR.'<br/>';
	$messageStack->add('addressbook',ENTRY_FS_ADDRESS_SAME_ERROR);
  }
  if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
    $error = true;
	$error_info .= ENTRY_CITY_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_CITY_ERROR);
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
      $zone = $db->Execute($zone_query);
      //look for an exact match on zone ISO code
      $found_exact_iso_match = ($zone->RecordCount() == 1);
      if ($zone->RecordCount() > 1) {
        while (!$zone->EOF && !$found_exact_iso_match) {
          if (strtoupper($zone->fields['zone_code']) == strtoupper($state) ) {
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
		$error_info .= ENTRY_STATE_ERROR_SELECT.'<br/>';
        $messageStack->add('addressbook', ENTRY_STATE_ERROR_SELECT);
      }
    } else {
      if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
        $error = true;
        $error_state_input = true;
		$error_info .= ENTRY_STATE_ERROR.'<br/>';
        $messageStack->add('addressbook', ENTRY_STATE_ERROR);
      }
    }
  }
  if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
    $error = true;
	$error_info .= ENTRY_POST_CODE_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_POST_CODE_ERROR);
  }else{
  		if($zip_code_rule != '//i'){
  			if(!preg_match($zip_code_rule, $postcode)){
  				$error = true;
  				$error_info .= CHECKOUT_ZIP_CODE_ERROR . str_replace(',', ' ' . TEXT_OR . ' ', $zip_code_example);
  				$messageStack->add('addressbook', CHECKOUT_ZIP_CODE_ERROR . str_replace(',', ' ' . TEXT_OR . ' ', $zip_code_example));
  			}
  		}
  }
  if (!is_numeric($country)) {
    $error = true;
	$error_info .= ENTRY_COUNTRY_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);
  }
/* if(strtolower(str_replace(' ', '', $state))=='puertorico'||strtolower(str_replace(' ', '', $state))=='portrico'){
  	if($country!=172)
  	$error = true;
  	$error_info .= ENTRY_PUEROTORICO_ERROR.'<br/>';
    $messageStack->add('addressbook', ENTRY_PUEROTORICO_ERROR);
  }*/

  if ($selected_address >0) {
        $address_where = ' and address_book_id != ' . $selected_address;
    }
    $address_sql = 'select * from ' . TABLE_ADDRESS_BOOK .' where customers_id = ' . $_SESSION['customer_id'] . $address_where ;
    $address_sql_check = $db->Execute($address_sql);
    while (!$address_sql_check->EOF) {
        if ($error == false) {
            if (
                $address_sql_check->fields['entry_gender'] == $gender 
                && $address_sql_check->fields['entry_company'] == $company 
                && $address_sql_check->fields['entry_firstname'] == $firstname 
                && $address_sql_check->fields['entry_lastname'] == $lastname 
                && $address_sql_check->fields['entry_street_address'] == $street_address 
                && $address_sql_check->fields['entry_postcode'] == $postcode 
                && $address_sql_check->fields['entry_city'] == $city 
                && $address_sql_check->fields['entry_state'] == $state 
                && $address_sql_check->fields['entry_country_id'] == $country
                && $address_sql_check->fields['entry_zone_id'] == $zone_id
                && $address_sql_check->fields['entry_telephone'] == $telephone
            	&& $address_sql_check->fields['tariff_number'] == $tariff_number
            	&& $address_sql_check->fields['backup_email_address'] == $email_address
                ) {
                $error = true;
                $error_info .= ENTRY_EXISTS_ERROR;
                $messageStack->add('addressbook', ENTRY_EXISTS_ERROR);
            }
        }
        $address_sql_check->MoveNext();
    }

  if ($error == false) {
  	/*
    $sql_data_array= array(array('fieldName'=>'entry_firstname', 'value'=>$firstname, 'type'=>'string'),
                           array('fieldName'=>'entry_lastname', 'value'=>$lastname, 'type'=>'string'),
                           array('fieldName'=>'entry_street_address', 'value'=>$street_address, 'type'=>'string'),
                           array('fieldName'=>'entry_postcode', 'value'=>$postcode, 'type'=>'string'),
                           array('fieldName'=>'entry_city', 'value'=>$city, 'type'=>'string'),
                           array('fieldName'=>'entry_country_id', 'value'=>$country, 'type'=>'integer'),
    					   array('fieldName'=>'tariff_number', 'value'=>$tariff_number, 'type'=>'string'),
    					   array('fieldName'=>'backup_email_address', 'value'=>$email_address, 'type'=>'string')
    );
    if (ACCOUNT_GENDER == 'true') $sql_data_array[] = array('fieldName'=>'entry_gender', 'value'=>$gender, 'type'=>'enum:m|f');
    if (ACCOUNT_COMPANY == 'true') $sql_data_array[] = array('fieldName'=>'entry_company', 'value'=>$company, 'type'=>'string');
    if (ACCOUNT_SUBURB == 'true') $sql_data_array[] = array('fieldName'=>'entry_suburb', 'value'=>$suburb, 'type'=>'string');
    if (ACCOUNT_STATE == 'true') {
      if ($zone_id > 0) {
        $sql_data_array[] = array('fieldName'=>'entry_zone_id', 'value'=>$zone_id, 'type'=>'integer');
        $sql_data_array[] = array('fieldName'=>'entry_state', 'value'=>'', 'type'=>'string');
      } else {
        $sql_data_array[] = array('fieldName'=>'entry_zone_id', 'value'=>'0', 'type'=>'integer');
        $sql_data_array[] = array('fieldName'=>'entry_state', 'value'=>$state, 'type'=>'string');
      }
	   $sql_data_array[] = array('fieldName'=>'entry_telephone', 'value'=>$telephone, 'type'=>'string');
    }
    if ($selected_address >0) {
      $where_clause = "address_book_id = :edit and customers_id = :customersID";
      $where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
      $where_clause = $db->bindVars($where_clause, ':edit', $selected_address, 'integer');
      $db->perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', $where_clause);
      $zco_notifier->notify('NOTIFY_HEADER_ADDRESS_BOOK_ENTRY_UPDATE_DONE');
      if ( (isset($_POST['primary']) && ($_POST['primary'] == 'on')) || ($_GET['edit'] == $_SESSION['customer_default_address_id']) ) {
       // $_SESSION['customer_first_name'] = $firstname;
        $_SESSION['customer_country_id'] = $country;
        $_SESSION['customer_zone_id'] = (($zone_id > 0) ? (int)$zone_id : '0');
        $_SESSION['customer_default_address_id'] = $selected_address;
        $sql_data_array = array(  array('fieldName'=>'customers_default_address_id', 'value'=>$_SESSION['customer_default_address_id'], 'type'=>'integer'));
        //if (ACCOUNT_GENDER == 'true') $sql_data_array[] = array('fieldName'=>'customers_gender', 'value'=>$gender, 'type'=>'enum:m|f');
        $where_clause = "customers_id = :customersID";
        $where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
        $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
      }
    } else {
      $sql_data_array[] = array('fieldName'=>'customers_id', 'value'=>$_SESSION['customer_id'], 'type'=>'integer');
      $db->perform(TABLE_ADDRESS_BOOK, $sql_data_array);
      $new_address_book_id = $db->Insert_ID();	  
      $sql = "select count(*) as total FROM " . TABLE_ADDRESS_BOOK . " WHERE  customers_id = :customersID";      
      $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');      
      $result = $db->Execute($sql);      
       if ((isset($_POST['primary']) && ($_POST['primary'] == 'on')) || $result->fields['total']== 1) {
       // $_SESSION['customer_first_name'] = $firstname;
        $_SESSION['customer_country_id'] = $country;
        $_SESSION['customer_zone_id'] = (($zone_id > 0) ? (int)$zone_id : '0');
        $_SESSION['customer_default_address_id'] = $new_address_book_id;
        $sql_data_array = array();
        if (ACCOUNT_GENDER == 'true') $sql_data_array[] = array('fieldName'=>'customers_gender', 'value'=>$gender, 'type'=>'string');
        $sql_data_array[] = array('fieldName'=>'customers_default_address_id', 'value'=>$new_address_book_id, 'type'=>'integer');
        $where_clause = "customers_id = :customersID";
        $where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
        $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
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
    $result_address = add_or_update_address_book($_SESSION['customer_id'], $address_book_info, $selected_address);
    $zco_notifier->notify('NOTIFY_HEADER_ADDRESS_BOOK_ENTRY_UPDATE_DONE');
	echo 'success';
	exit();
  }else{
  	echo $error_info;
  	exit();
  }
}else if(isset($_POST['action']) && $_POST['action']=='delete_address'){
	$result_address = delete_address_book($_SESSION['customer_id'], intval($_POST['customer_addressbook_id']));
	if($result_address) {
		echo "success";
	}
}elseif(isset($_POST['action']) && $_POST['action']=='set_default_address'){
    
    $address_book_id = (int)$_POST['address_book_id'];
    $address_sql = 'select entry_country_id, entry_zone_id from ' . TABLE_ADDRESS_BOOK . ' where address_book_id = ' .$address_book_id;
    $address_result = $db->Execute($address_sql);
    if (!$address_result->EOF) {
        $country = $address_result->fields['entry_country_id'];
        $zone_id = $address_result->fields['entry_zone_id'];
    }
   // $_SESSION['customer_first_name'] = $firstname;
    $_SESSION['customer_country_id'] = $country;
    $_SESSION['customer_zone_id'] = (($zone_id > 0) ? (int)$zone_id : '0');
    $_SESSION['customer_default_address_id'] = $address_book_id;
    $sql_data_array = array(  array('fieldName'=>'customers_default_address_id', 'value'=>$_SESSION['customer_default_address_id'], 'type'=>'integer'));
    //if (ACCOUNT_GENDER == 'true') $sql_data_array[] = array('fieldName'=>'customers_gender', 'value'=>$gender, 'type'=>'enum:m|f');
    $where_clause = "customers_id = :customersID";
    $where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
    $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
    $messageStack->add_session('addressbook_default', SET_AS_DEFAULT_ADDRESS_SUCCESS,'success');
    echo 'success';
  
}
?>