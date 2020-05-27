<?php
/**
* add a new account to 8seasons(when no exist) after dorabeads register success
* lvxiaoyong 20130819
*/

	$customer_query = $db->Execute("select * from " . TABLE_CUSTOMERS . " where customers_id=\"".$_SESSION ['customer_id']."\"");
	if($customer_query->RecordCount()>0){
		$customers_info = array(
			'email_address'=>$customer_query->fields['customers_email_address'],
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
			'register_useragent_language'=>$customer_query->fields['register_useragent_language']
		);

		require_once("includes/configure_share_account.php");
		add_customer_info_remote($customers_info);
		$db->close();
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
	}
?>