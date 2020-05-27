<?php

/**

 * functions_customers

 *

 * @package functions

 * @copyright Copyright 2003-2005 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: functions_customers.php 4793 2006-10-20 05:25:20Z ajeh $

 */

  // TABLES: countries;
  function zen_get_address_format_id($country_id) {
    global $db;
    $address_format_query = "select address_format_id as format_id
                             from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'";
    $address_format = $db->Execute($address_format_query);
    if ($address_format->RecordCount() > 0) {
      return $address_format->fields['format_id'];
    } else {
      return '1';
    }
  }

  // TABLES: address_format
  function zen_address_format($address_format_id, $address, $html, $boln, $eoln) {
    global $db;
    if(empty($address_format_id)) {
		$address_format_id = 1;
	}
    $address_format_query = "select address_format as format
                             from " . TABLE_ADDRESS_FORMAT . "
                             where address_format_id = '" . (int)$address_format_id . "'";
    $address_format = $db->Execute($address_format_query);
    $company = zen_output_string_protected($address['company']);
    if (isset($address['firstname']) && zen_not_null($address['firstname'])) {
      $firstname = zen_output_string_protected($address['firstname']);
      $lastname = zen_output_string_protected($address['lastname']);
    } elseif (isset($address['name']) && zen_not_null($address['name'])) {
      $firstname = zen_output_string_protected($address['name']);
      $lastname = ''; 
    } else {
      $firstname = '';
      $lastname = '';
    }
    $street = zen_output_string_protected($address['street_address']);
    $suburb = zen_output_string_protected($address['suburb']);
    $city = zen_output_string_protected($address['city']);
    $state = zen_output_string_protected($address['state']);
    if (isset($address['country_id']) && zen_not_null($address['country_id'])) {
      $country = zen_get_country_name($address['country_id']);
      if (isset($address['zone_id']) && zen_not_null($address['zone_id'])) {
        $state = zen_get_zone_name($address['country_id'], $address['zone_id'], $state);
      }
    } elseif (isset($address['country']) && zen_not_null($address['country'])) {
      if (is_array($address['country'])) {
        $country = zen_output_string_protected($address['country']['countries_name']);
      } else {
      $country = zen_output_string_protected($address['country']);
      }
    } else {
      $country = '';
    }
    $postcode = zen_output_string_protected($address['postcode']);
    $zip = $postcode;
    if ($html) {
	  // HTML Mode
      $HR = '<hr />';
      $hr = '<hr />';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br />';
        $cr = '<br />';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
	  // Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }
    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($country == '') {
      if (is_array($address['country'])) {
        $country = zen_output_string_protected($address['country']['countries_name']);
      } else {
      $country = zen_output_string_protected($address['country']);
      }
    }
    if ($state != '') $statecomma = $state . ', ';
    
    if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {

      $company = $cr . $company;

    }
    $telephone = $address['telephone'];
    $fmt = $address_format->fields['format'];
    eval("\$address_out = \"$fmt\";");
    /*if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {
      $address_out = $company . $cr . $address_out;
    }*/
    
    $extra_info = '';
    
    if(zen_not_null($address['tariff_number'] )){
    	$extra_info .=   $address['tariff_number'] . '<br>';
    }
    
    if(zen_not_null($address['backup_email_address'])){
    	$extra_info .=  $address['backup_email_address'] . '<br>';
    }
    
    $address_out .= $extra_info;
    
    return $address_out;
  }
  function zen_address_format1($address_format_id, $address, $html, $boln, $eoln) {

  	global $db;

  	$address_format_query = "select address_format1 as format

                             from " . TABLE_ADDRESS_FORMAT . "

                             where address_format_id = '" . (int)$address_format_id . "'";


  	$address_format = $db->Execute($address_format_query);

  	$company = zen_output_string_protected($address['company']);

  	if (isset($address['firstname']) && zen_not_null($address['firstname'])) {

  		$firstname = zen_output_string_protected($address['firstname']);

  		$lastname = zen_output_string_protected($address['lastname']);

  	} elseif (isset($address['name']) && zen_not_null($address['name'])) {

  		$firstname = zen_output_string_protected($address['name']);

  		$lastname = '';

  	} else {

  		$firstname = '';

  		$lastname = '';

  	}

  	$street = zen_output_string_protected($address['street_address']);

  	$suburb = zen_output_string_protected($address['suburb']);

  	$city = zen_output_string_protected($address['city']);
  	
  	$state = zen_output_string_protected($address['state']);
  	
  	$telephone = zen_output_string_protected($address['telephone']);

  	if (isset($address['country_id']) && zen_not_null($address['country_id'])) {

  		$country = zen_get_country_name($address['country_id']);


  		
  		if (isset($address['zone_id']) && zen_not_null($address['zone_id'])) {

  			$state = zen_get_zone_name($address['country_id'], $address['zone_id'], $state);

  		}
  		
  	} elseif (isset($address['country']) && zen_not_null($address['country'])) {

  		if (is_array($address['country'])) {

  			$country = zen_output_string_protected($address['country']['countries_name']);

  		} else {

  			$country = zen_output_string_protected($address['country']);

  		}

  	} else {

  		$country = '';

  	}

  	$postcode = zen_output_string_protected($address['postcode']);

  	$zip = $postcode;



  	if ($html) {

  		// HTML Mode

  		$HR = '<hr />';

  		$hr = '<hr />';

  		if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults

  			$CR = '<br />';

  			$cr = '<br />';

  			$eoln = $cr;

  		} else { // Use values supplied

  			$CR = $eoln . $boln;

  			$cr = $CR;

  		}

  	} else {

  		// Text Mode

  		$CR = $eoln;

  		$cr = $CR;

  		$HR = '----------------------------------------';

  		$hr = '----------------------------------------';

  	}

  	$statecomma = '';

  	$streets = $street;

  	if ($suburb != '') $streets = $street . $cr . $suburb;

  	if ($country == '') {

  		if (is_array($address['country'])) {

  			$country = zen_output_string_protected($address['country']['countries_name']);

  		} else {

  			$country = zen_output_string_protected($address['country']);

  		}

  	}

  	$country = '<strong>'.$country.'</strong>';
  	if ($state != '') $statecomma = $state . ', ';
  	
    if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {

      $company = $cr . $company;

    }
    
  	$fmt = $address_format->fields['format'];
  	eval("\$address_out = \"$fmt\";");
  	


  	//     if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {

  	//       $address_out = $company . $cr . $address_out;

  	//     }
  	
  	$extra_info = '';
  	
  	if(zen_not_null($address['tariff_number'] )){
  		$extra_info .= '<br/>' . $address['tariff_number'];
  	}
  	
  	if(zen_not_null($address['backup_email_address'])){
  		$extra_info .= '<br/>' . $address['backup_email_address'];
  	}
  	
  	$address_out .= $extra_info;
  	
  	$address_out = explode($cr, $address_out);
  	
  	return $address_out;

  }
  // TABLES: customers, address_book
  function zen_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n") {
    global $db;
    $address_query = "select entry_firstname as firstname, entry_lastname as lastname,
                             entry_company as company, entry_street_address as street_address,
                             entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                             entry_state as state, entry_zone_id as zone_id,tariff_number , backup_email_address ,
                             entry_country_id as country_id, entry_telephone as telephone
                      from " . TABLE_ADDRESS_BOOK . "
                      where customers_id = '" . (int)$customers_id . "'
                      and address_book_id = '" . (int)$address_id . "'";
    $address = $db->Execute($address_query);
    
    $format_id = zen_get_address_format_id($address->fields['country_id']);

    return zen_address_format($format_id, $address->fields, $html, $boln, $eoln);
  }
  function zen_address_label1($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n") {
  	global $db;
  	$address_query = "select entry_firstname as firstname, entry_lastname as lastname,
                             entry_company as company, entry_street_address as street_address,
                             entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                             entry_state as state, entry_zone_id as zone_id,tariff_number , backup_email_address ,
                             entry_country_id as country_id, entry_telephone as telephone
                      from " . TABLE_ADDRESS_BOOK . "
                      where customers_id = '" . (int)$customers_id . "'
                      and address_book_id = '" . (int)$address_id . "'";
  	$address = $db->Execute($address_query);
  	$format_id = zen_get_address_format_id($address->fields['country_id']);

  	return zen_address_format1($format_id, $address->fields, $html, $boln, $eoln);
  }
	function zen_address_format_new($address) {
	$extra_str = '';
	$fname = '<span class="cInfo_fname" cgender="'.($address['entry_gender']==''?'m':$address['entry_gender']).'">'.zen_output_string_protected($address['entry_firstname']).'</span>';
	$lname = '<span class="cInfo_lname">'.zen_output_string_protected($address['entry_lastname']).'</span>';
	$company = '<span class="cInfo_company">'.zen_output_string_protected($address['entry_company']).'</span>';
	$street_address = '<span class="cInfo_street">'.zen_output_string_protected($address['entry_street_address']).'</span>';
	$suburb = '<span class="cInfo_suburb">'.zen_output_string_protected($address['entry_suburb']).'</span>';
	$city = '<span class="cInfo_city">'.zen_output_string_protected($address['entry_city']).'</span>';
	$country_id = '<span class="cInfo_country_id" cId="'.$address['entry_country_id'].'">'.zen_get_country_name($address['entry_country_id']).'</span>';
	$postcode = '<span class="cInfo_postcode">'.zen_output_string_protected($address['entry_postcode']).'</span>';
	$telephone_number = '<span class="cInfo_telephone">'.zen_output_string_protected($address['entry_telephone']).'</span>';
	$tariff_number = (zen_output_string_protected($address['tariff_number']) == '' ? '' : ',') . '<span class="cInfo_tariff">'.zen_output_string_protected($address['tariff_number']).'</span>';
	$backup_email = (zen_output_string_protected($address['backup_email_address']) == '' ? '' : ',') . '<span class="cInfo_email">'.zen_output_string_protected($address['backup_email_address']).'</span>';
	
	$state = '<span class="cInfo_state">'.zen_output_string_protected($address['entry_state']).'</span>';
	if (isset($address['entry_zone_id']) && $address['entry_zone_id']!=0)
		$state = '<span class="cInfo_state cInfo_zone_id" zone_id="'.$address['entry_zone_id'].'">'.zen_get_zone_name($address['entry_country_id'], $address['entry_zone_id'], $state).'</span>';

	return $fname.' '.$lname.(($address['entry_firstname'] == '' && $address['entry_lastname'] == '') ? '' : ', '). (trim($address['entry_company'])!='' ? $company.', ' : $company) .$street_address.' '.$suburb.(($address['entry_street_address'] == '' && $address['entry_suburb'] == '') ? '' : ', ').$city.($address['entry_city'] == '' ? '' : ', ').$state.(($address['entry_state'] == '' && $address['entry_zone_id'] == 0) ? '' : ', ').$country_id.', '.$postcode.($address['entry_postcode'] == '' ? '' :', ').$telephone_number.$tariff_number.$backup_email;
}

  // Return a customer greeting
  function zen_customer_greeting() {
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_first_name']) {
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, zen_output_string_protected($_SESSION['customer_first_name']), zen_href_link(FILENAME_PRODUCTS_NEW));
    } else {
      $greeting_string = sprintf(TEXT_GREETING_GUEST, zen_href_link(FILENAME_LOGIN, '', 'SSL'), zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    }
    return $greeting_string;
  }

  function zen_count_customer_orders($id = '', $check_session = true) {
    global $db;

    if (is_numeric($id) == false) {
      if ($_SESSION['customer_id']) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( ($_SESSION['customer_id'] == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $orders_check_query = "select count(*) as total
                           from " . TABLE_ORDERS . "
                           where customers_id = '" . (int)$id . "'";
    $orders_check = $db->Execute($orders_check_query);

    return $orders_check->fields['total'];
  }



  function zen_count_customer_address_book_entries($id = '', $check_session = true) {
    global $db;

    if (is_numeric($id) == false) {
      if ($_SESSION['customer_id']) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( ($_SESSION['customer_id'] == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $addresses_query = "select count(*) as total
                        from " . TABLE_ADDRESS_BOOK . "
                        where customers_id = '" . (int)$id . "'";
    $addresses = $db->Execute($addresses_query);

    return $addresses->fields['total'];
  }

  // validate customer matches session
  function zen_get_customer_validate_session($customer_id) {
    global $db, $messageStack;
    $zc_check_customer = $db->Execute("SELECT customers_id from " . TABLE_CUSTOMERS . " WHERE customers_id=" . (int)$customer_id);
    if ($zc_check_customer->RecordCount() <= 0) {
      $db->Execute("DELETE from " . TABLE_CUSTOMERS_BASKET . " WHERE customers_id= " . $customer_id);
      $db->Execute("DELETE from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " WHERE customers_id= " . $customer_id);
      unset($_SESSION['customer_id']);
      $messageStack->add_session('header', ERROR_CUSTOMERS_ID_INVALID, 'error');
      return false;
    }
    return true;
  }

  /**
   * jessa �������������жϵ�¼�����Ĺ˿��Ƿ����processing��shipped
   */
  function zen_customer_has_valid_order(){
  	global $db;

  	if (!isset($_SESSION['customer_id'])) return false;

  	$sql_query = "Select shipping_module_code 
  					From " . TABLE_ORDERS . "
  				   Where customers_id = " . (int)$_SESSION['customer_id'] . "
  				     And orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ")";
  	
  	$valid_order = $db->Execute($sql_query);
  	
  	if ($valid_order->RecordCount() > 0) {
  		return $valid_order->fields['shipping_module_code'];
  	}

  	return "";
  }

  //��ݿͻ�ID�ҳ��ÿͻ�����Ϣ
  function zen_get_customers_info($customer_id){
  	global $db;

  	$customer_info_query = "select c.customers_firstname, c.customers_lastname, c.customers_email_address,
  								   ab.entry_postcode, ab.entry_city, ab.entry_state, ct.countries_name
  							  from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_COUNTRIES . " ct
  							 where c.customers_id = " . (int)$customer_id . "
  							   and c.customers_id = ab.customers_id
  							   and c.customers_default_address_id = ab.address_book_id
  							   and ab.entry_country_id = ct.countries_id";
  	$customer_info = $db->Execute($customer_info_query);

  	if ($customer_info->RecordCount() > 0){
  		$customer_info_array = array('firstname' => $customer_info->fields['customers_firstname'],
  									 'lastname' => $customer_info->fields['customers_lastname'],
  									 'email' => $customer_info->fields['customers_email_address'],
  									 'default_postcode' => $customer_info->fields['entry_postcode'],
  									 'default_city' => $customer_info->fields['entry_city'],
  									 'default_state' => $customer_info->fields['entry_state'],
  									 'default_country' => $customer_info->fields['countries_name']);
  	}

  	return $customer_info_array;
  }
  /*add by WSL*/
  function zen_get_customers_info_WSL($customer_id){
  	global $db;
  
  	$customer_info_query = "select c.customers_id , c.customers_firstname, c.customers_country_id , c.customers_lastname, c.customers_email_address , ct.countries_name  from " . TABLE_CUSTOMERS . " c, " . TABLE_COUNTRIES . " ct
where c.customers_id = " . $customer_id . " and c.customers_country_id = ct.countries_id";
  	$customer_info = $db->Execute($customer_info_query);
  
  	if ($customer_info->RecordCount() > 0){
  		$customer_info_array = array(
  				'customers_id' => $customer_info->fields['customers_id'],
  				'firstname' => $customer_info->fields['customers_firstname'],
  				'customers_country_id' =>$customer_info->fields['customers_country_id'],
  				'lastname' => $customer_info->fields['customers_lastname'],
  				'email' => $customer_info->fields['customers_email_address'],
  				
  				'default_country' => $customer_info->fields['countries_name']);
  	}
  
  	return $customer_info_array;
  }

  //�жϿͻ��Ƿ�Ϊ��վ��ע��ͻ�
  function zen_customer_exit($email){
  	global $db;
  	$customer_query = "select * from " . TABLE_CUSTOMERS . " where customers_email_address = '" . $email . "'";
  	$customer = $db->Execute($customer_query);
  	if ($customer->RecordCount() > 0){
  		return true;
  	} else {
  		return false;
  	}
  }

  function zen_potential_customer_exist($email){
  	global $db;
  	$customer_query = "select * from t_potential_customer where pcu_email = '" . $email . "'";
  	$customer = $db->Execute($customer_query);
  	if ($customer->RecordCount() > 0){
  		return true;
  	} else {
  		return false;
  	}
  }

  /*wishlist��غ���*/
  function zen_get_product_incart_num($customer_id, $product_id){
  	global $db;

  	$product_num_query = "select customers_basket_quantity
  							from " . TABLE_CUSTOMERS_BASKET . "
  						   where customers_id = " . (int)$customer_id . "
  						     and products_id = " . (int)$product_id;
  	$product_num = $db->Execute($product_num_query);

  	if ($product_num->RecordCount() > 0){
  		return (int)($product_num->fields['customers_basket_quantity']);
  	} else {
  		return false;
  	}
  }

  //�ֽ��˻���أ� ����ת��
  function zen_change_currency($ldc, $ls_from_code, $ls_to_code){
  	global $currencies;

  	//�����ֻ���ת��Ϊͬһ�ֻ���
  	$currencies_value = $currencies->currencies;
  	$currency_code_value = $currencies_value[$ls_from_code]['value'];
  	$currency_code_to_value = $currencies_value[$ls_to_code]['value'];
  	$rate = (float)($currency_code_to_value / $currency_code_value);

  	$result_value = (float)($ldc * $rate);

  	return $result_value;
  }

   function zen_get_current_cash_account($id_string){
  	global $db, $currencies;

  	$cash_account_value = 0;
  	$cash_account_query = "select cac_amount, cac_currency_code
  							 from " . TABLE_CASH_ACCOUNT . "
  							where cac_cash_id in " . $id_string;
  	$cash_account = $db->Execute($cash_account_query);

  	$cash_account_array = array();
  	if ($cash_account->RecordCount() > 0){
  		while (!$cash_account->EOF){
  			$cash_account_array[] = array('amount' => (float)$cash_account->fields['cac_amount'],
  										  'currency' => $cash_account->fields['cac_currency_code']);
  			$cash_account->MoveNext();
  		}
  	}

  	if (sizeof($cash_account_array) > 0){
  		$first_amount = $cash_account_array[0]['amount'];
  		$currency = $cash_account_array[0]['currency'];
  		$cash_account_value = $first_amount;
  		for ($i = 1; $i < sizeof($cash_account_array); $i++){
			if ($cash_account_array[$i]['currency'] == $currency){
				$cash_account_value = $cash_account_value + $cash_account_array[$i]['amount'];
			} else {
				$amount = zen_change_currency($cash_account_array[$i]['amount'], $cash_account_array[$i]['currency'], $currency);
				$cash_account_value = $cash_account_value + $amount;
			}
  		}
  	}

  	$cash_account_value_array = array('amount' => $cash_account_value,
  									  'currency' => $currency);

  	return $cash_account_value_array;
  }

  function zen_deduct_cash_amount($number, $id_string, $currency_code){
  	global $db;
  	$current_used_amount = (float)$number;
  	//���ͻ��˻��е��ܽ��Ϊ�����ʱ�򣬽�����˻���״̬����Ϊ��ɣ��������?
  	if ($current_used_amount <= 0){
  		$db->Execute("update " . TABLE_CASH_ACCOUNT . "
  						 set cac_status = 'C'
  					   where cac_cash_id in " . $id_string);
  	} else {
  		$cash_amount_query = "select cac_cash_id, cac_amount, cac_currency_code
  								from " . TABLE_CASH_ACCOUNT . "
  							   where cac_cash_id in " . $id_string;
  		$cash_amount = $db->Execute($cash_amount_query);

  		$cash_amount_array = array();
  		if ($cash_amount->RecordCount() > 0){
  			while (!$cash_amount->EOF){
  				$cash_amount_array[] = array('id' => (int)$cash_amount->fields['cac_cash_id'],
  											 'amount' => (float)$cash_amount->fields['cac_amount'],
  											 'currency_code' => $cash_amount->fields['cac_currency_code']);
  				$cash_amount->MoveNext();
  			}

  			for ($i = 0; $i < sizeof($cash_amount_array); $i++){
  				if ((float)$cash_amount_array[$i]['amount'] <= 0){
  					$db->Execute("update " . TABLE_CASH_ACCOUNT . "
  					                 set cac_status = 'C'
  					               where cac_cash_id = " . $cash_amount_array[$i]['id']);
  				} else {
  					$cash_currency_code = $cash_amount_array[$i]['currency_code'];
  					$current_used_amount = zen_change_currency($current_used_amount, $currency_code, $cash_currency_code);
					if ($current_used_amount >= $cash_amount_array[$i]['amount']){
						$db->Execute("update " . TABLE_CASH_ACCOUNT . "
									     set cac_status = 'C'
									   where cac_cash_id = " . $cash_amount_array[$i]['id']);
						$current_used_amount = $current_used_amount - $cash_amount_array[$i]['amount'];
					} else {
						$db->Execute("update " . TABLE_CASH_ACCOUNT . "
										 set cac_amount = " . ($cash_amount_array[$i]['amount'] - $current_used_amount) . "
									   where cac_cash_id = " . $cash_amount_array[$i]['id']);
						$current_used_amount = 0;
					}
  				}
  			}
  		}
  	}
  }
   function zen_get_cash_array($id_string){
 	global $db;
  	$cash_amount_query = "select cac_cash_id, cac_amount, cac_currency_code
  								from " . TABLE_CASH_ACCOUNT . "
  							   where cac_amount<=0 and cac_cash_id in " . $id_string;
    $cash_amount = $db->Execute($cash_amount_query);
    $cash_amount_array = array();
    if ($cash_amount->RecordCount() > 0){
  			while (!$cash_amount->EOF){
  				$cash_amount_array[] = array(
  				                             'id' => (int)$cash_amount->fields['cac_cash_id'],
  											 'amount' => (float)$cash_amount->fields['cac_amount'],
  											 'currency_code' => $cash_amount->fields['cac_currency_code']);
  				$cash_amount->MoveNext();
  			}
    }
    $cash_amount_query2 = "select cac_cash_id, cac_amount, cac_currency_code
  								from " . TABLE_CASH_ACCOUNT . "
  							   where cac_amount>0 and cac_cash_id in " . $id_string . " order by cac_amount desc";

     $cash_amount2 = $db->Execute($cash_amount_query2);
    if ($cash_amount2->RecordCount() > 0){
  			while (!$cash_amount2->EOF){
  				$cash_amount_array[] = array(
  				  				             'id' => (int)$cash_amount2->fields['cac_cash_id'],
  											 'amount' => (float)$cash_amount2->fields['cac_amount'],
  											 'currency_code' => $cash_amount2->fields['cac_currency_code']);
  				$cash_amount2->MoveNext();
  			}

    }
    return $cash_amount_array;
  }

  function zen_get_customer_basket(){
  	$products = array();
  	if (isset($_SESSION['cart']) && is_object($_SESSION['cart'])){
  		$customer_basket_products = $_SESSION['cart']->customers_basket();
  		if ($customer_basket_products->RecordCount() > 0) {
  			while (!$customer_basket_products->EOF){
  				$products[$customer_basket_products->fields['products_id']] = $customer_basket_products->fields['customers_basket_quantity'];
  				$customer_basket_products->MoveNext();
  			}
  		}
  	}
  	return $products;
  }

	//get customers information from 8seasons
	function get_customer_info_remote($emailaddress, $passwd){
    	global $db;
    	$db->close();
		if (!$db->connect(DB_SERVER_SHAREACCOUNT, DB_SERVER_USERNAME_SHAREACCOUNT, DB_SERVER_PASSWORD_SHAREACCOUNT, DB_DATABASE_SHAREACCOUNT, USE_PCONNECT_SHAREACCOUNT, false)){
    		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
    		return false;
    	}
		$pre = DB_PREFIX_SHAREACCOUNT;
    	if($emailaddress=='' || $passwd=='') return false;
    	$emailaddress = zen_db_prepare_input($emailaddress);
    	$passwd = zen_db_prepare_input($passwd);
    	$customer_query = $db->Execute("select * from ".$pre."customers where customers_email_address=\"".$emailaddress."\"");
    	if($customer_query->RecordCount()==0){
    		return false;
    	}
    	if(!zen_validate_password($passwd, $customer_query->fields['customers_password']))
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
    		'address_book' =>$address_arr
    	);
    	return $customers_info;
	}

 	//add customers information to 8seasons
	function add_customer_info_remote($cus_info){
    	global $db;
    	$db->close();
		if (!$db->connect(DB_SERVER_SHAREACCOUNT, DB_SERVER_USERNAME_SHAREACCOUNT, DB_SERVER_PASSWORD_SHAREACCOUNT, DB_DATABASE_SHAREACCOUNT, USE_PCONNECT_SHAREACCOUNT, false)){
    		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
    		return false;
    	}
		$pre = DB_PREFIX_SHAREACCOUNT;

		$check_customer_exist = $db->Execute("SELECT customers_id FROM ".$pre."customers WHERE customers_email_address = \"".$cus_info['email_address']."\"");
		if($check_customer_exist->RecordCount()==0 && $cus_info['email_address']!=''){
			$currency_preference=isset($_SESSION['currency'])?$_SESSION['currency']:'USD';
  			$get_currency_sql="select currencies_id from ".$pre."currencies where code='".$currency_preference."' ";
  			$get_currency_id=$db->Execute($get_currency_sql);
			$ip_address = zen_get_ip_address();
			$sql_data_array = array(
				'customers_gender'=>$cus_info['gender'],
				'customers_firstname' => $cus_info['first_name'],
				'customers_lastname' => $cus_info['last_name'],
				'customers_dob' => $cus_info['birthday'],
				'customers_email_address' => $cus_info['email_address'],
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
    			'register_useragent_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
				'customers_country_id' => $cus_info['country_id']
			);
  			zen_db_perform($pre."customers", $sql_data_array);
    		$new_customer_id = $db->Insert_ID();

			$db->Execute("insert into ".$pre."customers_info
						(customers_info_id, customers_info_number_of_logons,customers_info_date_account_created)
						values ('" . $new_customer_id . "', '0', now())");
		}
	}

	/**
	* get customer's pre order.payment_module_code
	* @athor lvxiaoyong
	*/
	function zen_customer_preorder_payment(){
		global $db;

		if (!isset($_SESSION['customer_id'])) return false;

		$sql_query = "Select payment_module_code
					From " . TABLE_ORDERS . "
					Where customers_id = '" . (int)$_SESSION['customer_id'] . "'
					ORDER BY date_purchased DESC LIMIT 1,1";
		$valid_order = $db->Execute($sql_query);

		if($valid_order->fields['payment_module_code']) return $valid_order->fields['payment_module_code'];
		else return false;

	}
	function zen_customer_is_new(){
		global $db;

		if (!isset($_SESSION['customer_id'])) return false;

		$sql_query = "Select orders_id
  					  From " . TABLE_ORDERS . "
  				   	  Where customers_id = " . (int)$_SESSION['customer_id'] . "
  				      limit 1";

		$valid_order = $db->Execute($sql_query);

		if ($valid_order->RecordCount()==0) return true;

		return false;
	}

	function zen_address_format_order($address_format_id, $address, $html, $boln, $eoln, $is_mobile = false) {
		global $db;
		$address_format_query = "select address_format as format
                             from " . TABLE_ADDRESS_FORMAT . "
                             where address_format_id = '" . (int)$address_format_id . "'";
		$address_format = $db->Execute($address_format_query);
		
		$company = zen_output_string_protected($address['company']);
		if (isset($address['firstname']) && zen_not_null($address['firstname'])) {
			$firstname = zen_output_string_protected($address['firstname']);
			$lastname = zen_output_string_protected($address['lastname']);
		} elseif (isset($address['name']) && zen_not_null($address['name'])) {
			$firstname = zen_output_string_protected($address['name']);
			$lastname = '';
		} else {
			$firstname = '';
			$lastname = '';
		}
		$street = zen_output_string_protected($address['street_address']);
		$suburb = zen_output_string_protected($address['suburb']);
		$city = zen_output_string_protected($address['city']);
		$state = zen_output_string_protected($address['state']);
		if (isset($address['country_id']) && zen_not_null($address['country_id'])) {
			$country = zen_get_country_name($address['country_id']);
			if (isset($address['zone_id']) && zen_not_null($address['zone_id'])) {
				$state = zen_get_zone_code($address['country_id'], $address['zone_id'], $state);
			}
		} elseif (isset($address['country']) && zen_not_null($address['country'])) {
			if (is_array($address['country'])) {
				$country = zen_output_string_protected($address['country']['countries_name']);
			} else {
				$country = zen_output_string_protected($address['country']);
			}
		} else {
			$country = '';
		}
		$postcode = zen_output_string_protected($address['postcode']);
		$zip = $postcode;
		if ($html) {
			$HR = '<hr />';
			$hr = '<hr />';
			if ( ($boln == '') && ($eoln == "\n") ) {
				$CR = '<br />';
				$cr = '<br />';
				$eoln = $cr;
			} else {
				$CR = $eoln . $boln;
				$cr = $CR;
			}
		} else {
			$CR = $eoln;
			$cr = $CR;
			$HR = '----------------------------------------';
			$hr = '----------------------------------------';
		}
		$statecomma = '';
		$streets = $street;
		if ($suburb != '') $streets = $street . $cr . $suburb;
		if ($country == '') {
			if (is_array($address['country'])) {
				$country = zen_output_string_protected($address['country']['countries_name']);
			} else {
				$country = zen_output_string_protected($address['country']);
			}
		}
		if ($state != '') $statecomma = $state . ', ';
		
    if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {
      $company = $cr . $company;
    }

		$fmt = $address_format->fields['format'];
		eval("\$address_out = \"$fmt\";");
		/*if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {
			$address_out = $company . $cr . $address_out;
		}*/
		
		$telephone = $address['telephone_number'];
		if(zen_not_null($telephone) == false) {
			$telephone_query = "select customers_telephone
 		                from " . TABLE_CUSTOMERS . "
 		                where customers_id = '" . (int)$address['customers_id'] . "'";
			$customers_telephone = $db->Execute($telephone_query);
			$telephone = $customers_telephone->fields['customers_telephone'];
		}
		
		$extra_info = '';
		
		if(zen_not_null($address['tariff_number'] )){
			$extra_info .= ' ' . $address['tariff_number'];
		}
		
		if(zen_not_null($address['backup_email_address'])){
			$extra_info .= ' ' . $address['backup_email_address'];
		}

    if($telephone != ''){
      if ($is_mobile) {
        $extra_info .= ' ' .'Tel: '.$telephone;
      }else{
        $extra_info .= ' ' .'<br/><br/><b style="color:black;">Tel</b>: '.$telephone;
      }      
    }
		
		$address_out .= $extra_info;
		return $address_out;

	}

	function zen_get_customer_cartid(){
		global $db;
		if (isset($_SESSION['customer_id'])){
			$customer_cartid = $db->Execute('select cartid from ' . TABLE_CUSTOMERS_INFO . ' where customers_info_id = ' . $_SESSION['customer_id']);
			return $customer_cartid->fields['cartid'];
		}else {
			return false;
		}
	}
	function zen_get_customer_create(){
        global $db;
        if(!isset($_SESSION['customer_id'])){
	 		return false;
	 	}
	 	if(intval($_SESSION['customers_is_rcd']) === 1){
	 		return false;
	 	}
	 	return true;
 		/*
        if (isset($_SESSION['customer_id'])){
                $customer_create = $db->Execute('select customers_info_date_account_created from ' . TABLE_CUSTOMERS_INFO . ' where customers_info_id = ' . $_SESSION['customer_id']);
                if($customer_create->fields['customers_info_date_account_created'] > '2014-04-15 11:00:00'){
                        return true;
                }else{
                        return false;
                }
                //return $customer_cartid->fields['cartid'];
        }else {
                return false;
        }
        */
	}
	
	function randomkeys($length)
	{
		$pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
		for($i=0;$i<$length;$i++)
		{
			$key .= $pattern{mt_rand(0,35)};    //生成php随机数
		}
		return $key;
	}
	

	/**
	* lvxiaoyong
	* check if this is high_risk_customer
	* @return array 数组里的info所有语种都采用英语即可
	*/
	function zen_check_high_risk_customer(){
		global $db, $order;
		
		$data = array('is_high_risk' => false, 'info' => "");
		$array_high_risk = array();
		
		$hrc_email = zen_get_high_risk_customer('email');
		if(in_array($order->customer['email_address'], $hrc_email)){
			array_push($array_high_risk, "high-risk email");
		}
		
		$hrc_name = zen_get_high_risk_customer('name');
		if(in_array($order->customer['name'], $hrc_name) || in_array($order->delivery['name'], $hrc_name)){
			array_push($array_high_risk, "high-risk name");
		}
		
		$hrc_city = zen_get_high_risk_customer('city');
		if(in_array(strtolower($order->customer['city']), $hrc_city) || in_array(strtolower($order->delivery['city']), $hrc_city)){
			array_push($array_high_risk, "high-risk city");
		}
		
		$hrc_postcode = zen_get_high_risk_customer('postcode');
		if(in_array($order->customer['postcode'], $hrc_postcode) || in_array($order->delivery['postcode'], $hrc_postcode)){
			array_push($array_high_risk, "high-risk postcode");
		}
		
		$hrc_address = zen_get_high_risk_customer('address');
		if(in_array(strtolower($order->customer['street_address']), $hrc_address) || in_array(strtolower($order->delivery['street_address']), $hrc_address)){
			array_push($array_high_risk, "high-risk street");
		}
		
		$hrc_telephone = zen_get_high_risk_customer('telephone');
		if(in_array($order->customer['telephone'], $hrc_telephone) || in_array(strtolower($order->delivery['delivery_telephone']), $hrc_telephone)){
			array_push($array_high_risk, "high-risk Tel");
		}
		
		$order_sql="select orders_id  from  " . TABLE_ORDERS . " WHERE customers_id = :customersID and orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ")";
		$order_sql=$db->bindVars($order_sql,':customersID',$_SESSION['customer_id'],'integer');
		$order_result = $db->Execute($order_sql);
		$num=$order_result->RecordCount();
	
		if($num < 2){
			 $billing_query = "";
			 if(!empty($order->billing['country']['title'])) {
			 	$billing_query .= " or  high_risk_country = '".$db->prepare_input($order->billing['country']['title'])."'";
			 }
			 $delivery_country_sql="select high_risk_country_id from  " . TABLE_PAYMENT_HIGH_RISK_COUNTRY . " WHERE high_risk_country = '".$db->prepare_input($order->customer['country'])."' or  high_risk_country = '".$db->prepare_input($order->delivery['country'])."'" . $billing_query . " limit 1";
			 $delivery_country_result = $db->Execute($delivery_country_sql);
			 $delivery_country_result_num = $delivery_country_result->RecordCount();
			
			 if($delivery_country_result_num > 0){
				 array_push($array_high_risk, "high-risk country");
			 }
			 
			 if(!empty($order->billing['country']['title']) && strtolower($order->delivery['country']) != strtolower($order->billing['country']['title'])){
				array_push($array_high_risk, "Country Diff");
			}
		}
		
		if(!empty($array_high_risk)) {
			$data = array('is_high_risk' => true, 'info' => "Status source:Website(" . implode("、", $array_high_risk) . ")");
		}
		return $data;
	}
	
	function zen_get_high_risk_customer($type=''){
		global $db;
		$chk_c = $db->Execute('select hrc_value from ' . TABLE_HIGH_RISK_CUSTOMER . ' where hrc_type="'.$type.'"');
		if($chk_c->RecordCount() <= 0)
			return array();
			else{
				if($type == 'city' || $type == 'address') $chk_c->fields['hrc_value'] = strtolower($chk_c->fields['hrc_value']);
				return unserialize($chk_c->fields['hrc_value']);
			}
	}
	
	/**
	 * 修改客户邮箱(通过客户ID)
	 * @param int $customers_id
	 * @param array $data
	 * @return array
	 */
	function update_customers_email_address_by_customers_id($customers_id, $data) {
		global $db;
		$array = array('success' => 0, 'data' => array());

		if(empty($data['customers_email_address']) || empty($data['customers_email_address_old']) || empty($data['ip_address'])) {
			return $array;
		}
		$customers_email_address = $data['customers_email_address'];
		
		$db->begin();
		zen_db_perform(TABLE_CUSTOMERS, array('customers_email_address' => $customers_email_address), "update", "customers_id = " . $customers_id);
		
		//zen_db_perform(TABLE_ORDERS, array('customers_email_address' => $customers_email_address), "update", "customers_id = " . $customers_id);
		
		zen_db_perform(TABLE_CUSTOMER_FEEDBACK, array('customer_email' => $customers_email_address), "update","customer_id = " . $customers_id);

		zen_db_perform(TABLE_CUSTOMERS_SUBSCRIBE, array('subscribe_email' => $customers_email_address), "update", "subscribe_email = '" . $customers_email_address . "'");
		
		zen_db_perform(TABLE_TESTIMONIAL, array('tm_customer_email' => $customers_email_address), "update", "tm_customer_id = " . $customers_id);
		
		zen_db_perform(TABLE_CUSTOMERS_UNSUBSCRIBE, array('session_customers_email_address' => $customers_email_address), "update", "session_customers_id = " . $customers_id);
		
		zen_db_perform(TABLE_CUSTOMERS_UNSUBSCRIBE_LOG, array('session_customers_email_address' => $customers_email_address), "update", "session_customers_id = " . $customers_id);
		
		$data_change_log = array(
    		'website_code' => WEBSITE_CODE,
    		'customers_id' => $_SESSION['customer_id'],
    		'customers_email_address_old' => $data['customers_email_address_old'],
    		'customers_email_address_new' => $data['customers_email_address'],
    		'ip_address' => $data['ip_address'],
    		'browser_user_agent' => $_SERVER['HTTP_USER_AGENT'],
    		'date_created' => "now()"
    	);
    	zen_db_perform(TABLE_CUSTOMERS_EMAIL_ADDRESS_CHANGE_LOG, $data_change_log);
		
		$db->commit();
		
		$array['success'] = 1;
		
		return $array;
	}
	
  /**
   * 用户订阅Mailchimp
   * @param string $email
   * @param array $param
   * @return array
   */
  function customers_for_mailchimp_subscribe_event($email, $event_type, $from, $param){
    global $db;
    $response = array();
    $response['error'] = false;
    $new_status = $subscribe_status = 0;

    if ($email == '') {
        $response['error'] = true;
        $response['error_message'] = 'Email is empty.';
    }

    if ($event_type == 10) { // 订阅subscribe
        if(stristr($email,'163.com') || stristr($email,'126.com') || stristr($email,'qq.com') || stristr($email,'sina.com.cn') || stristr($email,'sina.cn') || stristr($email,'139.com') || stristr($email,'souhu.com') || stristr($email,'tom.com')) {   
            $response['error'] = true;
            $response['error_message'] = 'Email error.';
        }
    }
    
    if (!$response['error']) {

        include_once(DIR_WS_CLASSES . 'config.inc');

        if (isset($param['list_id']) && $param['list_id'] != '') {
            $listId = $param['list_id'];
        }

        $customers_id_query = $db->Execute("SELECT customers_id, customers_newsletter FROM " . TABLE_CUSTOMERS ." WHERE customers_email_address = '" . $email . "' LIMIT 1");
        if ($customers_id_query->fields['customers_id'] != '') {
            $customers_id = $customers_id_query->fields['customers_id'];
            $customers_newsletter = $customers_id_query->fields['customers_newsletter'];

            if ($event_type == 20) { // unsubscribe
                if ($customers_newsletter == 1) {
                    $new_status = 10; // 取消订阅                   
                }
                $subscribe_status = 20;
            }elseif($event_type == 10) { // subscribe
                $new_status = 1; // 订阅状态
                $subscribe_status = 10;
            }

            $db->Execute("UPDATE " . TABLE_CUSTOMERS ." SET customers_newsletter = ". $new_status ." where customers_id = " . $customers_id);

        }else{
            $customers_id = 0;
            if ($event_type == 20) { // unsubscribe
                $subscribe_status = 20;
            }elseif($event_type == 10) { // subscribe
                $subscribe_status = 10;
            }
        }

        $firstname = isset($param['firstname']) ? $param['firstname'] : '' ;
        $lastname = isset($param['lastname']) ? $param['lastname'] : '' ;
        $languages_id = 0;

        $subscribe_sql_data = array('customers_for_mailchimp_email' => $email,
            'customers_for_mailchimp_id' => $customers_id,
            'session_customers_email_address' => $_SESSION['customer_email'],
            'session_customers_id' => $_SESSION['customer_id'],
            'list_id' => $listId,
            'website_code' => WEBSITE_CODE,
            'languages_id' => $_SESSION['languages_id'],
            'customers_firstname' => $firstname,
            'customers_lastname' => $lastname,
            'subscribe_status' => $subscribe_status,
            'subscribe_from' => $from,
            'browser_user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip_address' => zen_get_ip_address()
            );

        $update_sql_array = array('last_modified' => date('Y-m-d H:i:s'));

        $insert_sql_array = array('date_created' => date('Y-m-d H:i:s'));

        $customer_check_query = $db->Execute("SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP ." WHERE customers_for_mailchimp_email = '" . $email . "' LIMIT 1");

        if ($customer_check_query->RecordCount() >0) {

//             $subscribe_sql_data['languages_id'] = $customer_check_query->fields['languages_id'];
//             $languages_id = $customer_check_query->fields['languages_id'];

            $subscribe_sql_data_all = array_merge($subscribe_sql_data, $update_sql_array);

            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP, $subscribe_sql_data_all, 'update', "customers_for_mailchimp_email = '" . $email . "'");
        }else{

            $subscribe_sql_data_all = array_merge($subscribe_sql_data, $insert_sql_array);

            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP, $subscribe_sql_data_all);            
        }

        if ($event_type == 10) {
            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_SUBSCRIBE_LOG, array_merge($subscribe_sql_data, $insert_sql_array));
        }elseif($event_type == 20) {
            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_UNSUBSCRIBE_LOG, array_merge($subscribe_sql_data, $insert_sql_array));
        }
        
        $subscribe_event_check_query = $db->Execute("SELECT customers_email_address FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT ." WHERE customers_email_address = '" . $email . "' and event_status = 10 and event_type = ". $event_type ." and list_id != '' LIMIT 1");

        if ($subscribe_event_check_query->RecordCount() == 0) {
            $subscribe_event_data = array('customers_email_address' => $email,
                'customers_firstname' => $firstname,
                'customers_lastname' => $lastname,
                'list_id' => $listId,
                'languages_id' => $languages_id != 0 ? $languages_id : $_SESSION['languages_id'],
                'event_type' => $event_type,
                'event_status' => 10,
                'date_created' => date('Y-m-d H:i:s')
                );
            zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT, $subscribe_event_data);
        }

        $response['success_message'] = 'success';

    }

    return $response;
    
  }
  
/**
   * 用户订单数据传到Mailchimp
   * @param string $email
   * @param string $orders_id
   * @param array $param
   * @return array
   */
  function customers_for_mailchimp_order_event($email, $orders_id, $event_type, $param){
    global $order, $insert_id, $db;
    $response = array();
    $response['error'] = false;
    if ($email == '' || (int)$orders_id <= 0) {
        $response['error'] = true;
        $response['error_message'] = 'Email or order is empty.';
    }
    if (!$response['error']) {

        include_once(DIR_WS_CLASSES . 'config.inc');

        $order_event_data = array('customers_email_address' => $email,
                'languages_id' => $languages_id != 0 ? $languages_id : $_SESSION['languages_id'],
                'event_type' => $event_type,
                'campaign_id' => $_COOKIE['mailchimp_campaign_id'],
                'mc_eid' => $_COOKIE['mailchimp_email_id'],
                'store_id' => $storeId,
                'orders_id' => $orders_id,
                'event_status' => 10,
                'date_created' => date('Y-m-d H:i:s')
            );

        zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT, $order_event_data);
        $response['success_message'] = 'success';
    }

    return $response;

  }


  /**
   * 得到发邮件时Dear后面的客户名称，如Dear Larry Page
   * @param array $datas
   * @return string
   */
  function get_customers_email_dear_name($datas) {
  	$customers_email_dear_name = "";
  	if(!empty($datas)) {
  		if(!empty($datas['customer_first_name'])) {
  			$customer_first_name = $datas['customer_first_name'];
  		}
  		
  		if(!empty($datas['customer_last_name'])) {
  			$customer_last_name = $datas['customer_last_name'];
  		}
  		
  		if(!empty($datas['customer_email'])) {
  			$customer_email = $datas['customer_email'];
  		}
  		
  		if(!empty($datas['languages_id'])) {
  			$languages_id = $datas['languages_id'];
  		}
  		
  	}
  	if(empty($customer_first_name)) {
  		$customer_first_name = $_SESSION['customer_first_name'];
  	}
  	
  	if(empty($customer_last_name)) {
  		$customer_last_name = $_SESSION['customer_last_name'];
  	}
  	
  	if(empty($customer_email)) {
  		$customer_email = $_SESSION['customer_email'];
  	}
  	
  	if(empty($languages_id)) {
  		$languages_id = $_SESSION['languages_id'];
  	}
  	
  	if(!empty($customer_first_name) || !empty($customer_last_name)) {
  		if(!empty($customer_first_name) && !empty($customer_last_name)) {
  			$customers_email_dear_name = $customer_first_name . " " . $customer_last_name;
		  	if($languages_id == "6") {
		  		$customers_email_dear_name = $customer_last_name . " " . $customer_first_name;
		  	}
  		} else if(!empty($customer_first_name)) {
  			$customers_email_dear_name = $customer_first_name;
  		} else if(!empty($customer_last_name)) {
  			$customers_email_dear_name = $customer_last_name;
  		}
  		
  	} else if(!empty($customer_email)) {
  		$customers_email_dear_name = strchr($customer_email, "@", true);;
  	}
  	if(empty($customers_email_dear_name)) {
  		$customers_email_dear_name = TEXT_DEAR_CUSTOMER_NAME;
  	}
  	return $customers_email_dear_name;
  }
  
  function add_coupon_code($cp_code, $addable = true){
  	global $db;
  	$date = date("Y-m-d H:i:s");
  	$error_info = array('is_error' => false , 'error_info' => '');
  	
  	if($addable){
  		$coupon_exist = $db->Execute('select coupon_id,coupon_type, coupon_code, coupon_status, coupon_start_date, coupon_expire_date, coupon_start_time_pickup, coupon_end_time_pickup, coupon_usage, day_after_add, coupon_number_of_times, coupon_number_of_times_total from '. TABLE_COUPONS .' where coupon_code="'.$cp_code.'" and coupon_active="Y" and coupon_addable=1');
  	}else{
  		$coupon_exist = $db->Execute('select coupon_id,coupon_type, coupon_code, coupon_status, coupon_start_date, coupon_expire_date, coupon_start_time_pickup, coupon_end_time_pickup, coupon_usage, day_after_add, coupon_number_of_times, coupon_number_of_times_total from '. TABLE_COUPONS .' where coupon_code="'.$cp_code.'" and coupon_active="Y"');
  	}
  	
  	if($coupon_exist->RecordCount() <= 0){
  		$error_info['error_info'] = TEXT_WRONG_COUPON_CODE;
  		$error_info['is_error'] = true;
  	}else if($coupon_exist->fields['coupon_start_time_pickup'] > $date && $addable){
  		$error_info['error_info'] = TEXT_COUPON_NOT_YET_TIME;
  		$error_info['is_error'] = true;
  	}else if(($coupon_exist->fields['coupon_end_time_pickup'] < $date || $coupon_exist->fields['coupon_status'] == 0) && $addable){
  		$error_info['error_info'] = TEXT_EXPIRED_COUPON_CODE;
  		$error_info['is_error'] = true;
  	}else if($coupon_exist->fields['coupon_usage'] == 'ru_online' && ($_SESSION['languages_id'] != 3 || !zen_customer_is_new()) && $addable){
  		$error_info['error_info'] = TEXT_WRONG_COUPON_CODE;
  		$error_info['is_error'] = true;
  	}else{
  		$insert = true;
  		$cp_id = $coupon_exist->fields['coupon_id'];
  		if($coupon_exist->fields['coupon_number_of_times_total'] > 0 && $addable) {
  			$coupon_customer_count = $db->Execute("select count(1) count from " . TABLE_COUPON_CUSTOMER . " where cc_coupon_id=" . $cp_id);
  			if($coupon_customer_count->fields['count'] >= $coupon_exist->fields['coupon_number_of_times_total']) {
  				$error_info['error_info'] = TEXT_COUPON_HAS_BEEN_BROUGHT;
  				$error_info['is_error'] = true;
  				$insert = false;
  			}
  		}
  		if ($coupon_exist->fields['coupon_number_of_times'] == 10 && $addable) {
  			$coupon_customer = $db->Execute('select cc_id from '. TABLE_COUPON_CUSTOMER .' where cc_coupon_id='.$cp_id.' and cc_customers_id ='.intval($_SESSION['customer_id']));
  			if($coupon_customer->RecordCount() > 0){
  				$error_info['error_info'] = TEXT_OWNED_COUPON_CODE;
  				$error_info['is_error'] = true;
  				$insert = false;
  			}
  		}
  		if ($insert) {
  			/*该coupon为手动添加，coupon_type为C,插入t_coupon_customer需要添加日期*/
  			if ($coupon_exist->fields['coupon_code'] == 'FBCP20141126') {
  				$start = date('Y-m-d H:i:s',time());
  				$end = date('Y-m-d H:i:s',strtotime("$time + 10 day"));
  				/*当激活时间加10天后，比过期时间还要大，取过期时间插入*/
  				if($end > $coupon_exist->fields['coupon_expire_date']){
  					$end = $coupon_exist->fields['coupon_expire_date'];
  				}
  				$db->Execute('insert into '. TABLE_COUPON_CUSTOMER .' (`cc_coupon_id`,`cc_customers_id`,`cc_coupon_start_time`,`cc_coupon_end_time`,`cc_coupon_status`,`admin_email_or_customers_email_address`,`date_created`) values ('.$cp_id.','.intval($_SESSION['customer_id']).',"'.$start.'","'.$end.'", 10, "' . $_SESSION['customer_email'] . '",now())');
  			}else if($coupon_exist->fields['day_after_add'] > 0){
  				$start = date('Y-m-d H:i:s',time());
  				$end = date('Y-m-d H:i:s',strtotime("$time + ".$coupon_exist->fields['day_after_add']." day"));
  				$db->Execute('insert into '. TABLE_COUPON_CUSTOMER .' (`cc_coupon_id`,`cc_customers_id`,`cc_coupon_start_time`,`cc_coupon_end_time`,`cc_coupon_status`,`admin_email_or_customers_email_address`,`date_created`) values ('.$cp_id.','.intval($_SESSION['customer_id']).',"'.$start.'","'.$end.'", 10, "' . $_SESSION['customer_email'] . '", now())');
  			}else{
  				$db->Execute('insert into '. TABLE_COUPON_CUSTOMER .' (`cc_coupon_id`,`cc_customers_id`,`cc_coupon_status`,`admin_email_or_customers_email_address`,`date_created`) values ('.$cp_id.','.intval($_SESSION['customer_id']).', 10, "' . $_SESSION['customer_email'] . '", now())');
  			}
                    $error_info['coupon_id'] =  $db->insert_ID();
  		}
  	}
  	
  	return $error_info;
  }

/*
 * my coupon page get customer's all coupons
 * @param  $status coupon is active(1) or inactive(0)
 * @return array or false
*/
function get_customer_coupons($status=1){
    global $db, $currencies;
    $extra_condition = '';
    if ( $status == 1) {
        $extra_condition .= ' and cc.cc_coupon_status = 10';
    }else{
        $extra_condition .= ' and cc.cc_coupon_status != 10';
    }
    $customers_coupon_query = 'SELECT c.coupon_id, coupon_type, coupon_code, coupon_amount, coupon_minimum_order, coupon_start_date, coupon_expire_date, uses_per_user, coupon_usage,cc_id,cc.cc_coupon_start_time,cc.cc_coupon_end_time,cc.cc_coupon_status,cc.date_created, cd.coupon_description  FROM  '.TABLE_COUPONS.' c INNER JOIN ' . TABLE_COUPON_CUSTOMER . ' cc ON cc.cc_coupon_id=c.coupon_id LEFT JOIN ' . TABLE_COUPONS_DESCRIPTION . ' cd ON (cd.coupon_id = c.coupon_id and cd.language_id = '.$_SESSION['languages_id'].') where coupon_active="Y"  and cc_customers_id ='.$_SESSION['customer_id']. $extra_condition .' order by cc.cc_id desc';
    $customers_coupon = $db->Execute($customers_coupon_query);
    $i = 0;
    $coupon_code_array = array();
    $coupon_use_array = array();
    $coupon_array = array();
    $coupon_show_array = array();
    //  all coupon_customer list
    while(!$customers_coupon->EOF){
        if ($customers_coupon->fields['coupon_usage'] == 'ru_only' && $_SESSION['languages_id'] != 3) {
    
        }else{
            if($customers_coupon->fields['coupon_type']=='P'){
                $conpon_type = TEXT_DISCOUNT_COUPONS;
                $conpon_value = number_format($customers_coupon->fields['coupon_amount'],2) . '%&nbsp;off';
            }elseif($customers_coupon->fields['coupon_type']=='F'||$customers_coupon->fields['coupon_type']=='C'){
                $conpon_type = TEXT_CASH_COUPONS;
                $conpon_value = $currencies->format($customers_coupon->fields['coupon_amount']);
            }
            $coupon_id = $customers_coupon->fields['coupon_id'];
            $coupon_code = $customers_coupon->fields['coupon_code'];
            if($customers_coupon->fields['coupon_minimum_order'] > 0){
                $min_order = $currencies->format($customers_coupon->fields['coupon_minimum_order']);
            }else{
                $min_order = '/';
            }
            $used_this_coupon = false;
            $used_coupon_times = 0;
            if($customers_coupon->fields['coupon_type']=='C'){
                $coupon_start_date = $customers_coupon->fields['cc_coupon_start_time'];
                $coupon_expire_date = $customers_coupon->fields['cc_coupon_end_time'];
            }else{
                $coupon_start_date = $customers_coupon->fields['coupon_start_date'];
                $coupon_expire_date = $customers_coupon->fields['coupon_expire_date'];
            }
            //$coupon_date_format = date('M d, Y H:i', strtotime($coupon_start_date)).' - '.date('M d, Y H:i', strtotime($coupon_expire_date));
            $coupon_date_format = zen_date_long($coupon_start_date).' - '.zen_date_long($coupon_expire_date);
                            
            if($coupon_expire_date == '2019-02-28 00:00:00'){
                $coupon_date_format = '';
            }
            $uses_per_user = $customers_coupon->fields['uses_per_user'];
            if((in_array($coupon_code, array('CP2014040901','CP2014040902','CP2014040903')))){
    
                $coupon_use = $db->Execute('select coupon_id,order_id from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id = ' . $_SESSION ['customer_id'] . ' and coupon_id = '.$customers_coupon->fields['coupon_id'].'');
                $order_coupon = $db->Execute("select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where  cc_customers_id =  ".$_SESSION['customer_id']." and cc_coupon_id = ".$customers_coupon->fields['coupon_id']."");
    
                if($order_coupon->RecordCount() > 0 && !isset($coupon_array[$order_coupon->fields['cc_orders_id']])){
                    $coupon_array[$order_coupon->fields['cc_orders_id']] = $order_coupon->RecordCount();
                }
    
                if($coupon_use->RecordCount() > 0){
                    if(!isset($coupon_use_array[$coupon_use->fields['coupon_id']])){
                        $coupon_use_array[$coupon_use->fields['coupon_id']] = $coupon_use->RecordCount();
                    }
                }else{
                    $coupon_use_array[$coupon_use->fields['coupon_id']] = 0;
                }
    
                if($coupon_array[$order_coupon->fields['cc_orders_id']] > $coupon_use_array[$coupon_use->fields['coupon_id']]){
                    $coupon_use_array[$coupon_use->fields['coupon_id']]++;
                }else{
                    $uses_per_user = 1;
                }
    
            }
            
            $ordersId = $usedTime = $status = "";
            if($customers_coupon->fields['cc_coupon_status'] == '10') {
                
            } else if($customers_coupon->fields['cc_coupon_status'] == '20') {
                $status = TEXT_USED_COUPON;
                $coupon_track=$db->Execute('select order_id, redeem_date from '.TABLE_COUPON_REDEEM_TRACK.' where coupon_customer_id=' . $customers_coupon->fields['cc_id']);
                if($coupon_track->RecordCount()>0){
                    $ordersId = '<a href="'.zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO,'order_id='.$coupon_track->fields['order_id']).'" style="color:#0481DB">'.'#'.$coupon_track->fields['order_id'].'</a>';
                    $usedTime = $coupon_track->fields['redeem_date'] != '0000-00-00 00:00:00' ? zen_date_long($coupon_track->fields['redeem_date']) : '';
                }
            } else if($customers_coupon->fields['cc_coupon_status'] == '30') {
                $status = TEXT_EXPIRED_COUPON; 
            } else if($customers_coupon->fields['cc_coupon_status'] == '40') {
                $status = TEXT_DELETED;
            }
        
            $coupon_show_array[] = array('id'=>$coupon_id,
                    'coupon_code'=>$coupon_code,
                    'type'=>$conpon_type,
                    'value'=>$conpon_value,
                    'status'=>$status,
                    'min_order'=>$min_order,
                    'orders_id'=>$ordersId,
                    'used_time'=>$usedTime,
                    'date_format'=>$coupon_date_format,
                    'date_created'=>$customers_coupon->fields['date_created'] != '0000-00-00 00:00:00' ? zen_date_long($customers_coupon->fields['date_created']) : '/'
            );
            $i++;
        }
        $customers_coupon->MoveNext();
    }
    return $coupon_show_array;
}

/**
  * 添加或修改配送地址
  * @param $customers_id 客户ID int
  * @param $address_book_info 地址信息 array
  * @param $address_book_id 地址薄ID int
  * @return array
  */
function add_or_update_address_book($customers_id, $address_book_info, $address_book_id = 0, $is_set_default = 0) {
	global $db;
	$data = array('success' => 0, 'id' => 0);
	if(empty($customers_id) || empty($address_book_info['firstname']) || empty($address_book_info['lastname']) || empty($address_book_info['street_address']) || empty($address_book_info['postcode']) || empty($address_book_info['city']) || empty($address_book_info['telephone'])) {
		return $data;
	}
	$sql_data_array= array(
			array('fieldName' => 'customers_id', 'value' => $customers_id, 'type' => 'integer'),
			array('fieldName' => 'entry_firstname', 'value' => $address_book_info['firstname'], 'type' => 'string'),
			array('fieldName' => 'entry_lastname', 'value' => $address_book_info['lastname'], 'type' => 'string'),
			array('fieldName' => 'entry_street_address', 'value' => $address_book_info['street_address'], 'type' => 'string'),
			array('fieldName' => 'entry_postcode', 'value' => $address_book_info['postcode'], 'type' => 'string'),
			array('fieldName' => 'entry_city', 'value' => $address_book_info['city'], 'type' => 'string'),
			array('fieldName' => 'entry_country_id', 'value' => $address_book_info['country'], 'type' => 'integer'),
			array('fieldName' => 'tariff_number', 'value' => $address_book_info['tariff_number'], 'type' => 'string'),
			array('fieldName' => 'entry_telephone', 'value' => $address_book_info['telephone'], 'type' => 'string'),
			array('fieldName' => 'backup_email_address', 'value' => $address_book_info['email_address'], 'type' => 'string'),
            array('fieldName'=>'last_modify_time', 'value'=>date('Y-m-d H:i:s'), 'type'=>'date'),
    );
    
    if (!empty($address_book_info['gender'])) {
    	$sql_data_array[] = array('fieldName'=>'entry_gender', 'value'=>$address_book_info['gender'], 'type'=>'enum:m|f');
    }
    if (!empty($address_book_info['company'])) {
    	$sql_data_array[] = array('fieldName'=>'entry_company', 'value'=>$address_book_info['company'], 'type'=>'string');
    } else {
    	$sql_data_array[] = array('fieldName'=>'entry_company', 'value'=>'', 'type'=>'string');
    }
    if (!empty($address_book_info['suburb'])) {
    	$sql_data_array[] = array('fieldName'=>'entry_suburb', 'value'=>$address_book_info['suburb'], 'type'=>'string');
    } else {
    	$sql_data_array[] = array('fieldName'=>'entry_suburb', 'value'=>'', 'type'=>'string');
    }
    if (!empty($address_book_info['zone_id'])) {
        $sql_data_array[] = array('fieldName'=>'entry_zone_id', 'value'=>$address_book_info['zone_id'], 'type'=>'integer');
        $sql_data_array[] = array('fieldName'=>'entry_state', 'value'=>'', 'type'=>'string');
    } else {
    	$sql_data_array[] = array('fieldName'=>'entry_zone_id', 'value'=>'0', 'type'=>'integer');
        $sql_data_array[] = array('fieldName'=>'entry_state', 'value'=>$address_book_info['state'], 'type'=>'string');
    }
    
    if($address_book_id > 0) {
    	$where_clause = "address_book_id = :address_book_id and customers_id = :customers_id";
		$where_clause = $db->bindVars($where_clause, ':customers_id', $customers_id, 'integer');
		$where_clause = $db->bindVars($where_clause, ':address_book_id', $address_book_id, 'integer');
    	$db->perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', $where_clause);
    	$data = array('success' => 1, 'id' => $address_book_id);
    } else {
        $sql_data_array[] = array('fieldName'=>'create_time', 'value'=>date('Y-m-d H:i:s'), 'type'=>'date');

    	$db->perform(TABLE_ADDRESS_BOOK, $sql_data_array);
    	$data = array('success' => 1, 'id' => $db->Insert_ID());
    }
    
    if($data['success'] == 1 && $data['id'] > 0) {
    	check_remote_area_byID($data['id']);
    	if($is_set_default == 1) {
    		$sql_data_array= array(
				array('fieldName' => 'customers_default_address_id', 'value' => $data['id'], 'type' => 'integer')
		    );
		    $where_clause = "customers_id = :customers_id";
			$where_clause = $db->bindVars($where_clause, ':customers_id', $customers_id, 'integer');
		    $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
    	} else {
    		$sql = "select address_book_id FROM " . TABLE_ADDRESS_BOOK . " WHERE  customers_id = :customers_id";      
		    $sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
		    $result = $db->Execute($sql);      
		    if ($result->RecordCount() <= 1) {
				$sql_data_array= array(
					array('fieldName' => 'customers_default_address_id', 'value' => $data['id'], 'type' => 'integer')
			    );
			    $where_clause = "customers_id = :customers_id";
				$where_clause = $db->bindVars($where_clause, ':customers_id', $customers_id, 'integer');
			    $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
		    }
    	}
    	
    }
	return $data;
}

/**
  * 删除配送地址
  * @param $customers_id 客户ID int
  * @param $address_book_id 地址薄ID int
  * @return boolean
  */
function delete_address_book($customers_id, $address_book_id) {
	global $db;
	$sql = "select customers_default_address_id FROM " . TABLE_CUSTOMERS . " WHERE  customers_id = :customers_id";
    $sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
    $result = $db->Execute($sql);
    if ($result->RecordCount() >= 1 && $result->fields['customers_default_address_id'] == $address_book_id) {
    	return false;
    }
    
   
	$sql = "delete from " . TABLE_ADDRESS_BOOK . " where customers_id = :customers_id and address_book_id = :address_book_id";
	$sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
    $sql = $db->bindVars($sql, ':address_book_id', $address_book_id, 'integer');
    $result = $db->Execute($sql);
    
    $sql = "select address_book_id FROM " . TABLE_ADDRESS_BOOK . " WHERE  customers_id = :customers_id";
    $sql = $db->bindVars($sql, ':customers_id', $customers_id, 'integer');
    $result = $db->Execute($sql);
    
    $sql = "delete from " . TABLE_REMOTE_AREA . " where ra_address_book_id = :address_book_id";
    $sql = $db->bindVars($sql, ':address_book_id', $address_book_id, 'integer');
    $db->Execute($sql);
    if ($result->RecordCount() == 1) {
		$sql_data_array= array(
			array('fieldName' => 'customers_default_address_id', 'value' => $result->fields['address_book_id'], 'type' => 'integer')
	    );
	    $where_clause = "customers_id = :customers_id";
		$where_clause = $db->bindVars($where_clause, ':customers_id', $customers_id, 'integer');
	    $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
    }
	return true;
}

function get_customer_address_info($customer_id, $address_id){
    global $db;
    $address_info = array();

    $address_info_query = $db->Execute("select address_book_id, entry_firstname, entry_company, entry_lastname, entry_gender, entry_street_address,  entry_suburb, entry_city, entry_postcode ,
                           entry_state, entry_zone_id,  entry_country_id, entry_telephone as telephone_number , tariff_number, backup_email_address
						   from  ".TABLE_ADDRESS_BOOK."
						   where customers_id = " . $customer_id ." and address_book_id=" . $address_id );

    if($address_info_query->RecordCount() > 0){
        $address_info = $address_info_query->fields;
    }

    return $address_info;
}

function get_customers_address_num($customer_id){
    global $db;
    $num = 0;

    $address_info_query = $db->Execute("select count(address_book_id) as cab
						   from  ".TABLE_ADDRESS_BOOK."
						   where customers_id = " . $customer_id  );

    if($address_info_query->RecordCount() > 0){
        $num = (int)$address_info_query->fields['cab'];
    }

    return $num;
}
?>