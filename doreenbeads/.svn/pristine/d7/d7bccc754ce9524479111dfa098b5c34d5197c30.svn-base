<?php
include('includes/application_top.php');
include('includes/configure_share_account.php');
set_time_limit(0);
ini_set('memory_limit', '512M');

$all_customer = get_all_customer_info_remote();
if(! $all_customer) die();

$db->close();
$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);

foreach($all_customer as $email_address){
	$email_address = zen_db_prepare_input($email_address);
	$check_customer_exist = $db->Execute("SELECT customers_id FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address = \"".$email_address."\"");
	if($check_customer_exist->RecordCount()==0 && $email_address!=''){
		$cus_info = get_share_customer_info_remote($email_address);

		$db->close();
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);

		if(!$cus_info || !is_array($cus_info)) continue;
	
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
								'signin_ip' => $cus_info['signin_ip'],
//								'lang_preference' => $cus_info['lang_preference'],
//								'register_languages_id' => $cus_info['register_languages_id'],
//								'currencies_preference' => $cus_info['currencies_preference'],
								'register_useragent_language' => $cus_info['register_useragent_language'],
								'customers_country_id' => $cus_info['country_id']
//								'customers_business_web' => $cus_info['business_web']
		);
		zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);
		$new_customer_id = $db->Insert_ID();

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
  						'entry_telephone' => $address['telephone_number'],//todo
                        'last_modify_time' => $address['last_modify_time'],
                        'create_time' => $address['create_time']
			);
			if($address['entry_country_id']=='') continue;
			zen_db_perform(TABLE_ADDRESS_BOOK, $address_book_sql);
			$new_address_id = $db->Insert_ID();
			if($address['is_default'] || sizeof($address_datas)==1) {
				$default_shipping_address = $new_address_id;
			}
		}

		if($default_shipping_address>0){
			$db->Execute("update ".TABLE_CUSTOMERS." set customers_default_address_id='".$default_shipping_address."'	
    						where customers_id='".$new_customer_id."'");
		}
		$db->Execute("insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created)
              values ('" . $new_customer_id . "', '0', now())");
	}
}

function get_all_customer_info_remote(){
	global $db;

	$pre = DB_PREFIX_SHAREACCOUNT;

	$db->close();
	if (!$db->connect(DB_SERVER_SHAREACCOUNT, DB_SERVER_USERNAME_SHAREACCOUNT, DB_SERVER_PASSWORD_SHAREACCOUNT, DB_DATABASE_SHAREACCOUNT, USE_PCONNECT_SHAREACCOUNT, false)){
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
		return false;
	}

	$customer_query = $db->Execute("select customers_email_address from ".$pre."customers");
	if($customer_query->RecordCount()==0)
		return false;
	$address_arr = array();
	while(!$customer_query->EOF){
		$address_arr[] = $customer_query->fields['customers_email_address'];
		$customer_query->MoveNext();
	}

	return $address_arr;
}

function get_share_customer_info_remote($emailaddress){
	global $db;

	$pre = DB_PREFIX_SHAREACCOUNT;

	$db->close();
	if (!$db->connect(DB_SERVER_SHAREACCOUNT, DB_SERVER_USERNAME_SHAREACCOUNT, DB_SERVER_PASSWORD_SHAREACCOUNT, DB_DATABASE_SHAREACCOUNT, USE_PCONNECT_SHAREACCOUNT, false)){
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
		return false;
	}

	if($emailaddress=='') return false;
	$emailaddress=zen_db_prepare_input($emailaddress);
	$customer_query = $db->Execute("select * from ".$pre."customers where customers_email_address=\"".$emailaddress."\"");
	if($customer_query->RecordCount()==0)
		return false;

	$address_book_query = $db->Execute("select * from ".$pre."address_book where customers_id='".$customer_query->fields['customers_id']."'");
	$address_arr = array();
	while(!$address_book_query->EOF){
		$address_arr[]=array(
            'is_default' =>( ($address_book_query->fields['address_book_id']==$customer_query->fields['customers_default_address_id']) ? 1 : 0),
            'entry_gender' => $address_book_query->fields['entry_gender'],
            'entry_company' => $address_book_query->fields['entry_company'],
            'entry_firstname' => $address_book_query->fields['entry_firstname'],
            'entry_lastname' => $address_book_query->fields['entry_lastname'],
            'entry_street_address' => $address_book_query->fields['entry_street_address'],
            'entry_suburb' => $address_book_query->fields['entry_suburb'],
            'entry_postcode' => $address_book_query->fields['entry_postcode'],
            'entry_city' => $address_book_query->fields['entry_city'],
            'entry_state' => $address_book_query->fields['entry_state'],
            'entry_country_id' => $address_book_query->fields['entry_country_id'],
            'entry_zone_id' => $address_book_query->fields['entry_zone_id'],
            'telephone_number' => $address_book_query->fields['telephone_number'],
            'last_modify_time' => $address_book_query->fields['last_modify_time'],
            'create_time' => $address_book_query->fields['create_time']
		);

		$address_book_query->MoveNext();
	}

	$customers_info = array(
         'gender'=>$customer_query->fields['customers_gender'],
         'first_name'=>$customer_query->fields['customers_firstname'],
         'last_name'=>$customer_query->fields['customers_lastname'],
         'birthday'=>$customer_query->fields['customers_dob'],
         'nick'=>$customer_query->fields['customers_nick'],
         'telephone'=>$customer_query->fields['customers_telephone'],
         'cellphone'=>$customer_query->fields['customers_cell_phone'],
         'fax'=>$customer_query->fields['customers_fax'],
         'password' =>$customer_query->fields['customers_password'],
         'newsletter'=>$customer_query->fields['customers_newsletter'],
         'email_format'=>$customer_query->fields['customers_email_format'],
         'authorization'=>$customer_query->fields['customers_authorization'],
         'referral'=>$customer_query->fields['customers_referral'],
         'paypal_payerid'=>$customer_query->fields['customers_paypal_payerid'],
         'paypal_ec'=>$customer_query->fields['customers_paypal_ec'],
         'country_id'=>$customer_query->fields['customers_country_id'],
         'business_web'=>$customer_query->fields['customers_business_web'],
			'signin_ip'=>$customer_query->fields['signin_ip'],
			'lang_preference'=>$customer_query->fields['lang_preference'],
			'register_languages_id'=>$customer_query->fields['register_languages_id'],
			'currencies_preference'=>$customer_query->fields['currencies_preference'],
			'register_useragent_language'=>$customer_query->fields['register_useragent_language'],
         'address_book' =>$address_arr
	);

	return $customers_info;
}
?>