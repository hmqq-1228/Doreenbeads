<?php
$check_customer_exist = $db->Execute("SELECT customers_id FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address = \"".$email_address."\"");
if($check_customer_exist->RecordCount()==0 && $email_address!='' && $password!=''){
	require_once("includes/configure_share_account.php");
	$cus_info = get_customer_info_remote($email_address, $password);
	$db->close();
	$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
	if(!$cus_info || !is_array($cus_info)){
		$error = true;		
	}else{		
		$currency_preference=isset($_SESSION['currency'])?$_SESSION['currency']:'USD';
  		$get_currency_sql="select currencies_id from ".TABLE_CURRENCIES." where code='".$currency_preference."' ";
  		$get_currency_id=$db->Execute($get_currency_sql);
		$ip_address = zen_get_ip_address();
		$check_mailchimp_email_query = $db->Execute("SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP . " WHERE customers_for_mailchimp_email = '" . $email_address . "' LIMIT 1");
		if ($check_mailchimp_email_query->RecordCount() > 0) {
		    if ($check_mailchimp_email_query->fields['subscribe_status'] == 10) {
		        $cus_info['newsletter'] = 1;
		    }
		}
		$twitter_customers_id = '';
		$vk_customers_id = '';
		
		if(isset($_SESSION['api_login_type'])){
		    if($_SESSION['api_login_type'] == 'Twitter'){
		        $register_entry = 7;
		        $twitter_customers_id = $_SESSION['api_customers_id'];
		    }else{
		        $register_entry = 6;
		        $vk_customers_id = $_SESSION['api_customers_id'];
		    }
		}else{
		    $register_entry = 4;
		}
		
		$sql_data_array = array(
			'customers_gender'=>$cus_info['gender'],
			'customers_firstname' => $cus_info['first_name'],
			'customers_lastname' => $cus_info['last_name'],
			'customers_dob' => $cus_info['birthday'],
			'customers_email_address' => $email_address,
			'customers_nick' => $cus_info['nick'],
			'customers_telephone' => $cus_info['telephone'],
			'customers_cell_phone' => $cus_info['cellphone'],
			'customers_fax' => $cus_info['fax'],
			'customers_newsletter' => $cus_info['newsletter'],
			'customers_email_format' => $cus_info['email_format'],							
			'customers_default_address_id' => 0,
			'customers_password' => $cus_info['password'],
			'customers_group_pricing' => 0,
            'customers_authorization' => (int)CUSTOMERS_APPROVAL_AUTHORIZATION,
			'customers_referral' =>$cus_info['referral'],
			'customers_paypal_payerid' => $cus_info['paypal_payerid'],
			'customers_paypal_ec' => $cus_info['paypal_ec'],
            'signin_ip' => $ip_address,
		    'from_mobile' => ($is_mobilesite ? 1 : 0),
//         'lang_preference' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
//         'register_languages_id' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
//    		'currencies_preference' => $get_currency_id->fields['currencies_id'],
    		'register_useragent_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
			'customers_country_id' => $cus_info['country_id'],
//			'customers_business_web' => $cus_info['business_web']
		    'register_entry'=>$register_entry
		);
  		zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);
        $_SESSION['customer_id'] = $new_customer_id = $db->Insert_ID();
        $_SESSION['customer_email'] = $email_address;

        add_coupon_code(REGISTER_COUPON_CODE, false);
    	
    	if($cus_info['newsletter']==1){
    	    $db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '5',".$_SESSION['languages_id'].");");
    	    $subscribe_param = array(
    	        'firstname' => $cus_info['first_name'],
    	        'lastname' => $cus_info['last_name']
    	    );
    	    $event_type = 10;
    	    $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param );
    	}else{
    	    $event_type = 20;
    	    if($check_mailchimp_email_query->RecordCount() > 0) {
    	        $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param );
    	    }
    	}

    	write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $new_customer_id . "\n customers_email_address: " . $email_address . "\n firstname: " . $cus_info['first_name'] . "\n lastname: " . $cus_info['last_name'] ."\n ip: " . zen_get_ip_address () ."\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: ". date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array) . "\n===========================================================\n\n\n");
    	
    	foreach($cus_info['address_book'] as $address){
			$address_book_sql = array(
  				'customers_id' => $new_customer_id,
  				'entry_gender' => $address['entry_gender'],
  				'entry_company' => $address['entry_company'],
  				'entry_firstname' => $address['entry_firstname'],
  				'entry_lastname' => $address['entry_lastname'],
  				'entry_street_address' => $address['entry_street_address'],
  				'entry_suburb' => $address['entry_suburb'],
  				'entry_postcode' => $address['entry_postcode'],
  				'entry_city' => $address['entry_city'],
  				'entry_state' => $address['entry_state'],
  				'entry_country_id' => $address['entry_country_id'],
  				'entry_zone_id' => $address['entry_zone_id'],
  				'entry_telephone' => $address['telephone_number'],
                'last_modify_time' => $address['last_modify_time'],
                'create_time' => $address['create_time']
			);
  			if($address['entry_country_id']=='') continue;
    		zen_db_perform(TABLE_ADDRESS_BOOK, $address_book_sql);
    		$new_address_id = $db->Insert_ID();
    		if($address['is_default'] || sizeof($address_datas)==1) {
    			$default_shipping_address = $new_address_id;
    			$default_country_id = $address_book_sql['entry_country_id'];
    		}
		}
		
    	if($default_shipping_address>0){
    		$db->Execute("update ".TABLE_CUSTOMERS." set customers_default_address_id='".$default_shipping_address."'	
    						where customers_id='".$new_customer_id."'");
    	}
		$db->Execute("insert into " . TABLE_CUSTOMERS_INFO . "
						(customers_info_id, customers_info_number_of_logons,customers_info_date_account_created)
						values ('" . $new_customer_id . "', '0', now())");
	}
}
?>