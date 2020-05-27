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
$zco_notifier->notify('NOTIFY_HEADER_START_ADDRESS_BOOK');
//jessa 2010-02-23 �ж��Ƿ��Ǵ�checkout�������ҳ���
if (isset($_GET['action']) && $_GET['action'] == 'checkout_shipping'){
	$_SESSION['checkout_manage_address'] = 'true';
}else{
	$_SESSION['checkout_manage_address'] = 'false';
}
//eof jessa 2010-02-23

if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

$addresses_query = "SELECT address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id, tariff_number , backup_email_address	,                   
						   entry_telephone as telephone
                    FROM   " . TABLE_ADDRESS_BOOK . "
                    WHERE  customers_id = :customersID
                    ORDER BY firstname, lastname";
$addresses_query = $db->bindVars($addresses_query, ':customersID', $_SESSION['customer_id'], 'integer');
$addresses = $db->Execute($addresses_query);

while (!$addresses->EOF) {
  $format_id = zen_get_address_format_id($addresses->fields['country_id']);
  $addressArray[] = array('firstname'=>$addresses->fields['firstname'],
  'lastname'=>$addresses->fields['lastname'],
  'address_book_id'=>$addresses->fields['address_book_id'],
  'format_id'=>$format_id,
  'address'=>$addresses->fields);
  $addresses->MoveNext();
}

/* 
 * $flag_show_pulldown_query
 * 
 * 
 */


$state = '';

$zone_id = 0;

$addressBookId = $_POST['addressBookId'];
$address_listing = $db->Execute("select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_gender as gender, entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,entry_telephone as telephone,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id , tariff_number , backup_email_address
						   from " . TABLE_ADDRESS_BOOK . "
						   where customers_id = " . $_SESSION['customer_id']);

$selectedAddress = array();
if($address_listing->RecordCount()==0){
	$selectedAddress['country'] = '223';
	$selectedAddress['state'] = '';
	$selectedAddress['zone'] = '1';
}
while(!$address_listing->EOF){
	//$selectedAddress['address_book_id'] = $address_listing->fields['address_book_id'];
	$selectedAddress[$address_listing->fields['address_book_id']]['gender'] = $address_listing->fields['gender'];
	$selectedAddress[$address_listing->fields['address_book_id']]['company'] = $address_listing->fields['company'];
	$selectedAddress[$address_listing->fields['address_book_id']]['firstname'] = $address_listing->fields['firstname'];
	$selectedAddress[$address_listing->fields['address_book_id']]['lastname'] = $address_listing->fields['lastname'];
	$selectedAddress[$address_listing->fields['address_book_id']]['streetAddress'] = $address_listing->fields['street_address'];
	$selectedAddress[$address_listing->fields['address_book_id']]['suburb'] = $address_listing->fields['suburb'];
	$selectedAddress[$address_listing->fields['address_book_id']]['city'] = $address_listing->fields['city'];
	$selectedAddress[$address_listing->fields['address_book_id']]['country'] = $address_listing->fields['country_id'];
	$selectedAddress[$address_listing->fields['address_book_id']]['state'] = $address_listing->fields['state'];
	$selectedAddress[$address_listing->fields['address_book_id']]['zone'] = $address_listing->fields['zone_id'];
	$selectedAddress[$address_listing->fields['address_book_id']]['postcode'] = $address_listing->fields['postcode'];
	$selectedAddress[$address_listing->fields['address_book_id']]['telephone'] = $address_listing->fields['telephone'];
	$selectedAddress[$address_listing->fields['address_book_id']]['tariff_number'] = $address_listing->fields['tariff_number'];
	$selectedAddress[$address_listing->fields['address_book_id']]['email_address'] = $address_listing->fields['backup_email_address'];
	//var_dump($selectedAddress);exit;
	$address_listing->MoveNext();
}
$selectedAddress = json_encode($selectedAddress);

$select_country_id = SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY;
if ($_SESSION['languages_id'] == 3) {
	$select_country_id = 176;
}
$flag_show_pulldown_query = $db->Execute('select zone_id from '.TABLE_ZONES.' where zone_country_id='.$select_country_id.' limit 1 ');
$flag_show_pulldown_states = $flag_show_pulldown_query->RecordCount()>0?true:false;

  $entry_query = "SELECT entry_gender, entry_company, entry_firstname, entry_lastname,
                         entry_street_address, entry_suburb, entry_postcode, entry_city,
                         entry_state, entry_zone_id, entry_country_id,entry_telephone , tariff_number , backup_email_address
                  FROM   " . TABLE_ADDRESS_BOOK . "
                  WHERE  customers_id = :customersID
                  AND    address_book_id = :addressBookID";
  $entry_query = $db->bindVars($entry_query, ':customersID', $_SESSION['customer_id'], 'integer');
  $entry_query = $db->bindVars($entry_query, ':addressBookID', $_SESSION['customer_default_address_id'], 'integer');
  $entry = $db->Execute($entry_query);  
  $zco_notifier->notify('NOTIFY_HEADER_END_ADDRESS_BOOK');
?>