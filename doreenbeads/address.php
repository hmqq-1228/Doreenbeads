<?php
require ('includes/application_top.php');
$action = $_POST ['action'];
switch ($action){
	case 'getzone':
		$cid = intval ( $_POST ['cid'] );
		if ($cid != ''){
			$zones = zen_get_country_zones ( $cid );
			$result = '';
			for($i = 0; $i < sizeof ( $zones ); $i ++) {
				$result .= $zones [$i] ['id'] . ',' . $zones [$i] ['text'] . '||';
			}
			echo substr ( $result, 0, - 2 );
		}
		break;
	case 'edit':
	case 'add' :
		if (isset($_POST ['addid']) && $_POST ['addid'] != ''){
			$addid = $_POST ['addid'];
			$entry_query = "SELECT entry_gender, entry_company, entry_firstname, entry_lastname,
	                         entry_street_address, entry_suburb, entry_postcode, entry_city,
	                         entry_state, entry_zone_id, entry_country_id, entry_telephone, customers_telephone
	                  FROM   " . TABLE_ADDRESS_BOOK . " ab , " . TABLE_CUSTOMERS . " c
	                  WHERE ab.customers_id = :customersID
	                  AND ab.address_book_id = :addressBookID
	                  AND ab.customers_id = c.customers_id";
			
			$entry_query = $db->bindVars($entry_query, ':customersID', $_SESSION['customer_id'], 'integer');
			$entry_query = $db->bindVars($entry_query, ':addressBookID', $addid, 'integer');
			$entry = $db->Execute($entry_query);
			
			$gender = $entry->fields['entry_gender'];
			$ad_firstname = $entry->fields['entry_firstname'];
			$ad_lastname = $entry->fields['entry_lastname'];
			$ad_company = $entry->fields['entry_company'];
			$ad_street = $entry->fields['entry_street_address'];
			$ad_street1 = $entry->fields['entry_suburb'];
			$ad_city = $entry->fields['entry_city'];
			$ad_state = $entry->fields['entry_state'];
			$ad_postcode = $entry->fields['entry_postcode'];
			$ad_phone = $entry->fields['customers_telephone'];
			$ad_country_id = $entry->fields['entry_country_id'];
			$ad_zone_id = $entry->fields['entry_zone_id'];
			$ad_telephone = $entry->fields['entry_telephone'];
			
			$countries = zen_get_countries($entry->fields['entry_country_id']);
			$ad_country_name = $countries['countries_name'];
			$primary = $db->Execute('select customers_id from ' . TABLE_CUSTOMERS .' where customers_default_address_id = ' . $addid . ' and customers_id = ' . $_SESSION['customer_id']);
			if ($primary->RecordCount() == 1){
				$ad_checkbox_checked = true;
			}
			$edit = '&edit=' . $addid;
			$update = 'update';
		}
		require 'includes/templates/cherry_zen/templates/tpl_add_address.php';
		break;
}
?>
