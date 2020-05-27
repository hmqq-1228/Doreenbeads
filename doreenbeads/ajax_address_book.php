<?php
require('includes/application_top.php');
$input_info_arr=array();
if(isset($_POST['action']) && $_POST['action']=='new_address'){
	if(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=0){
		$error =false;
		$error_info='';
		$aid = zen_db_prepare_input($_POST['aId']);
		$gender = zen_db_prepare_input($_POST['gender']);
		$firstname = zen_db_prepare_input($_POST['first']);
		$lastname = zen_db_prepare_input($_POST['last']);
		$street_address = zen_db_prepare_input($_POST['street_address']);
		$suburb = zen_db_prepare_input($_POST['suburb']);
		$postcode = zen_db_prepare_input($_POST['postcode']);
		$city = zen_db_prepare_input($_POST['city']);
		$telephone = zen_db_prepare_input($_POST['telephone']);
		$state = zen_db_prepare_input($_POST['state']);
		$zone_id = zen_db_prepare_input($_POST['zone_id']);
		$country = zen_db_prepare_input($_POST['zone_country_id']);
		$company = zen_db_prepare_input($_POST['company']);
		$tariff_number = zen_db_prepare_input($_POST['tariff_number']);
		$email_address = zen_db_prepare_input($_POST['backup_email_address']);
		$zip_code_rule = '/' . zen_db_prepare_input($_POST['zip_code_rule']) . '/i';
		$zip_code_example = zen_db_prepare_input($_POST['zip_code_example']);
	
		if ( ($gender != 'm') && ($gender != 'f') ) {
			$error = true;
			$error_info .= ENTRY_GENDER_ERROR;
		}
	
		if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
			$error = true;
			$error_info .= ENTRY_FIRST_NAME_ERROR;
		}
	
		if ($zone_id==0&&strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
			$error = true;
			$error_info .= ENTRY_LAST_NAME_ERROR;
		}
		
		if($_SESSION['languages_id'] != '6'){
			if($firstname == $lastname){
				$error = true;
				$error_info .= ENTRY_FL_NAME_SAME_ERROR;
			}
		}
		
		if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
			$error = true;
			$error_info .= ENTRY_STREET_ADDRESS_ERROR;
		}
	
		if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
			$error = true;
			$error_info .= ENTRY_CITY_ERROR;
		}
	
		if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
			$error = true;
			$error_info .= ENTRY_POST_CODE_ERROR;
		}else{
	  		if($zip_code_rule != '//i'){
	  			if(!preg_match($zip_code_rule, $postcode)){
	  				$error = true;
	  				$error_info .= CHECKOUT_ZIP_CODE_ERROR . str_replace(',', ' ' . TEXT_OR . ' ', $zip_code_example);
	  			}
	  		}
	  	}
		
		if (!is_numeric($country)) {
			$error = true;
			$error_info .= ENTRY_COUNTRY_ERROR;
		}
	
		/*if(strtolower(str_replace(' ', '', $state))=='puertorico'||strtolower(str_replace(' ', '', $state))=='portrico'){
			if($country!=172)
				$error = true;
			$error_info .= ENTRY_PUEROTORICO_ERROR;
		}*/
	
		if ($error == false) {
			require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
			$sql_data_array= array(array('fieldName'=>'entry_firstname', 'value'=>$firstname, 'type'=>'string'),
				array('fieldName'=>'entry_lastname', 'value'=>$lastname, 'type'=>'string'),
				array('fieldName'=>'entry_street_address', 'value'=>$street_address, 'type'=>'string'),
				array('fieldName'=>'entry_postcode', 'value'=>$postcode, 'type'=>'string'),
				array('fieldName'=>'entry_city', 'value'=>$city, 'type'=>'string'),
				array('fieldName'=>'entry_country_id', 'value'=>$country, 'type'=>'integer'),
				array('fieldName'=>'entry_gender', 'value'=>$gender, 'type'=>'enum:m|f'),
				array('fieldName'=>'entry_suburb', 'value'=>$suburb, 'type'=>'string'),
				array('fieldName'=>'entry_company', 'value'=>$company, 'type'=>'string'),
				array('fieldName'=>'entry_telephone', 'value'=>$telephone, 'type'=>'string'),
				array('fieldName'=>'tariff_number', 'value'=>$tariff_number, 'type'=>'string'),
				array('fieldName'=>'backup_email_address', 'value'=>$email_address, 'type'=>'string')
			);
			if ($zone_id > 0) {
				$sql_data_array[] = array('fieldName'=>'entry_zone_id', 'value'=>$zone_id, 'type'=>'integer');
				$sql_data_array[] = array('fieldName'=>'entry_state', 'value'=>'', 'type'=>'string');
			} else {
				$sql_data_array[] = array('fieldName'=>'entry_zone_id', 'value'=>'0', 'type'=>'integer');
				$sql_data_array[] = array('fieldName'=>'entry_state', 'value'=>$state, 'type'=>'string');
			}
	
			/*
			if ($aid) {
				$where_clause = "address_book_id = :edit and customers_id = :customersID";
				$where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
				$where_clause = $db->bindVars($where_clause, ':edit', $aid, 'integer');
				$db->perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', $where_clause);
				check_remote_area_byID($aid);
			
				$_SESSION ['reset_shipping_fee'] = 'true';
	
				$sql = "select address_book_id, entry_firstname , entry_lastname ,entry_gender , entry_street_address ,	entry_suburb , entry_city , entry_postcode , entry_state , entry_zone_id , entry_country_id ,entry_telephone, entry_company, tariff_number , backup_email_address 
						from " . TABLE_ADDRESS_BOOK . "
						where customers_id = :customersID  order by address_book_id";
				$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
				$result = $db->Execute($sql);
			} else {
				$sql_data_array[] = array('fieldName'=>'customers_id', 'value'=>$_SESSION['customer_id'], 'type'=>'integer');
				$db->perform(TABLE_ADDRESS_BOOK, $sql_data_array);
				$new_address_book_id = $db->Insert_ID();
	
				if(isset($new_address_book_id)){
					check_remote_area_byID($new_address_book_id);
					$_SESSION['sendto'] = $new_address_book_id;
					$input_info_arr['sendto'] = $new_address_book_id;
					$_SESSION ['reset_shipping_fee'] = 'true';
				}
	
				$sql = "select address_book_id, entry_firstname , entry_lastname ,entry_gender , entry_street_address ,	entry_suburb , entry_city , entry_postcode , entry_state , entry_zone_id , entry_country_id ,entry_telephone,entry_company , tariff_number , backup_email_address
						from " . TABLE_ADDRESS_BOOK . "
						where customers_id = :customersID  order by address_book_id";
				$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
				$result = $db->Execute($sql);
	
				if ($result->RecordCount()== 1) {
					if(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=''){
					
							if($_SESSION['customer_first_name'] == ''){
								$sql_data_array_default_address_id[] = array('fieldName'=>'customers_firstname', 'value'=>$firstname, 'type'=>'string');
								$_SESSION['customer_first_name'] = $firstname;
							}
							if($_SESSION['customer_last_name'] == ''){
								$sql_data_array_default_address_id[] = array('fieldName'=>'customers_lastname', 'value'=>$lastname, 'type'=>'string');
								$_SESSION['customer_last_name'] = $lastname;
							}
						}
					$_SESSION['customer_country_id'] = $country;
					$_SESSION['customer_zone_id'] = (($zone_id > 0) ? (int)$zone_id : '0');
					$_SESSION['customer_default_address_id'] = $new_address_book_id;
					$sql_data_array_default_address_id[] = array('fieldName'=>'customers_default_address_id', 'value'=>$new_address_book_id, 'type'=>'integer');
					$where_clause = "customers_id = :customersID";
					$where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
					$db->perform(TABLE_CUSTOMERS, $sql_data_array_default_address_id, 'update', $where_clause);

					write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $_SESSION ['customer_id'] . "\n customers_email_address: " . $_SESSION ['customers_email_address'] . "\n firstname: " . $firstname . "\n lastname: " . $lastname ."\n ip: " . zen_get_ip_address () ."\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: ". date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array_default_address_id) . "\n===========================================================\n\n\n");

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
			
			$result_address = add_or_update_address_book($_SESSION['customer_id'], $address_book_info, $aid);
			if(empty($aid) && $result_address['id'] > 0) {
				$_SESSION['sendto'] = $result_address['id'];
			}
	
			$customers_address_query = $db->Execute("select customers_default_address_id  from ". TABLE_CUSTOMERS . " where customers_id='".$_SESSION['customer_id']."'");
			$customers_default_address_id = $customers_address_query->fields['customers_default_address_id'];

			$sql = "select address_book_id, entry_firstname , entry_lastname ,entry_gender , entry_street_address ,	entry_suburb , entry_city , entry_postcode , entry_state , entry_zone_id , entry_country_id ,entry_telephone,entry_company , tariff_number , backup_email_address
					from " . TABLE_ADDRESS_BOOK . "
					where customers_id = :customersID  order by address_book_id";
			$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
			$result = $db->Execute($sql);
			
			$add_input_info='<form class="addresschioce"><table><tbody>';
			while(!$result->EOF){
				$count_num++;
				
				if (!zen_not_null($result->fields['entry_telephone'])){
					$phone_note = '<div style="display:inline-block;position:relative;"><ins class="question_icon"></ins><div style="display: none;left:-145px;" class="pricetips"><span class="bot"></span><span class="top"></span>' . TEXT_ADD_ADDRESS_PHONE . '</div></div>';
				}else{
					$phone_note = '';
				}
				
				if($_SESSION['sendto']==$result->fields['address_book_id']){
					if($result->fields['address_book_id'] == $customers_default_address_id) $text_delete = '&nbsp;';
					else $text_delete = '<span class="spanD" style="display:none">' . TEXT_DELETE . '</span>';
					$add_input_info.='<tr class="selected"><td class="selectThisTd"><input type="radio" name="address" id="address_'.$result->fields['address_book_id'].'" checked="checked" aId="'.$result->fields['address_book_id'].'"></td><td class="selectThisTd"><label for="address_'.$result->fields['address_book_id'].'"><strong>'.zen_address_format_new($result->fields).'</strong>' . $phone_note . '</label></td><td><span class="edit addaddress" edit="1">' . TEXT_EDIT . '</span>'.$text_delete.'</td></tr>';
				}else{
					if($result->fields['address_book_id'] == $customers_default_address_id) $text_delete = '&nbsp;';
					else $text_delete = '<span class="spanD">' . TEXT_DELETE . '</span>';
					$add_input_info.='<tr><td class="selectThisTd"><input type="radio" name="address" id="address_'.$result->fields['address_book_id'].'" aId="'.$result->fields['address_book_id'].'"></td><td class="selectThisTd"><label for="address_'.$result->fields['address_book_id'].'"><strong>'.zen_address_format_new($result->fields).'</strong>' . $phone_note . '</label></td><td><span class="edit addaddress" edit="1" style="display:none">' . TEXT_EDIT . '</span>'.$text_delete.'</td></tr>';
				}
				$result->MoveNext();
			}
			$add_input_info.='</tbody></table>';
			if($result->RecordCount() < MAX_ADDRESS_BOOK_ENTRIES){
				$add_input_info.='<p><a href="javascript:void(0);" class="greybtn addaddress"><span>' . TEXT_ENTER_A_ADDRESS . '</span></a></p>';
			}
			$add_input_info.='</form>';
			$input_info_arr['reinfo']=$add_input_info;
			$input_info_arr['error_info']='';
		}else{
			$input_info_arr['error_info']=$error_info;
		}
	}else{
		$input_info_arr['error']=true;
	}
}elseif(isset($_POST['action']) && $_POST['action']=='choose_address'){
	if(isset($_POST['aId']) && $_POST['aId']!='' && $_POST['aId']!=0 && isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=0){
		check_remote_area_byID($_POST['aId']);
		$_SESSION['sendto'] = $_POST['aId'];
		$_SESSION ['reset_shipping_fee'] = 'true';
        $address_info = get_customer_address_info($_SESSION['customer_id'], $_SESSION['sendto']);
		$input_info_arr['error']=false;
		$input_info_arr['link']='';
        $input_info_arr['address_info'] = $address_info;
	}else{
		$input_info_arr['link']=zen_href_link(FILENAME_LOGIN, '', 'SSL');
		$input_info_arr['error']=true;
	}
}elseif(isset($_POST['action']) && $_POST['action']=='delete_address'){
	if(isset($_POST['aId']) && $_POST['aId']!='' && $_POST['aId']!=0 && isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=0){
		$result_address = delete_address_book($_SESSION['customer_id'], intval($_POST['aId']));
		$input_info_arr['error']=false;
		$input_info_arr['link']='';
	}else{
		$input_info_arr['link']=zen_href_link(FILENAME_LOGIN, '', 'SSL');
		$input_info_arr['error']=true;
	}
}else{
	$input_info_arr['error']=true;
}
echo json_encode($input_info_arr);
?>