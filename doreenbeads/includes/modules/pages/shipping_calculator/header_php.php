<?php
/**
 * Checkout Shipping Page
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6669 2007-08-16 10:05:49Z drbyte $
 */
// This should be first line of the script:

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_shipping.php');

require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping;
$show_method = $shipping_modules->shipping_method;

//eof jessa 2010-04-09
if (isset($_GET['action']) && ($_GET['action'] == 'calc')) {
  	$net_weight = (float)zen_db_prepare_input($_POST['net_weight']);
  	$country = zen_db_prepare_input($_POST['zone_country_id']);
	$country_id = $country;
	unset($_GET['country_id']);
	$_GET['country_id'] = $country_id;
  	$weight = $net_weight;
  	$quick_zone_id = $db->Execute("select countries_iso_code_2 from " . TABLE_COUNTRIES . " where countries_id = " . (int)$country);
	$countries_iso_code_2 = $quick_zone_id->fields['countries_iso_code_2'];
	
	if(!empty($countries_iso_code_2)) {
		$countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => 0));
	}
	
	$shipping_modules = new shipping ('', $countries_iso_code_2, '', $post_postcode, $post_city);
	$shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => 0));
	$shipping_list = $shipping_data['shipping_list'];
	$shipping_info = $shipping_data['shipping_info'];
	$special_discount = $shipping_data['special_discount'];

	$result_code = "<fieldset id='message'>
	  	 				  <legend>" . TEXT_COMPARE_RESULT . "</legend>
	  						<table align = 'center' border = '0' width = '100%' cellspacing='0' cellpadding='0' style='border:1px solid #CCCCCC' class='table_cal_result'>
				  				<tr style = 'background: #bfbfbf; font-size:14px; font-weight:bold' align = center>
				  					<td width = '30%'>" . TEXT_SHIPPING_METHOD . "</td>
				  					<td width = '13%'><a href='javascript:void(0)' class='sorttype' type='day' style='color:#000000;'>" . TEXT_DAYS . "<img src='includes/templates/cherry_zen/images/hui_asc.jpg' style='vertical-align: middle;padding-bottom:2px;cursor:pointer;'></a></td>
				  					<td width = '10%'>" . TEXT_PACKAGE_NUMBER . "</td>
				  					<td width = '13%'>" . TEXT_SERVER . "</td>
				  					<td width = '18%'><a href='javascript:void(0)' class='sorttype' type='cost' style='color:#000000;'>" . TEXT_RESULT_COST . "<img src='includes/templates/cherry_zen/images/hui_asc.jpg' style='vertical-align: middle;padding-bottom:2px;cursor:pointer;'></a></td>
									" . (sizeof($special_discount) > 0 ? '<td><a href="javascript:void(0);" style="color:#000000;" title="' . TEXT_SINCE_SHIPPING_COST . '">' . TEXT_SPECIAL_DISCOUNT . '</a></td>' : '') . "			
				  				</tr>";
	foreach ($shipping_list as $type => $val){
		if (!isset($_POST[$type])){
			continue;
		}
		$select_bool[$type] = true;
		switch ($type){
			case 'trstma' : $to_door = TEXT_NOT_DOOR_TO_DOOR . '<a title="' . TEXT_MOSCOW_ST . '"><font size="1" color="#c89469" style="cursor:pointer;">[?]</font></a>'; break;
			case 'trstm' : $to_door = TEXT_NOT_DOOR_SHIP_TO_MOSCOW; break;
			case 'sfhyzxb' : $to_door = TEXT_NOT_DOOR_SHIP_TO_LOCAL; break;
			case 'ynkqy' : $to_door = TEXT_NOT_DOOR_TO_DOOR . '<a title="' . TEXT_ST_PETERSBURG . '"><font size="1" color="#c89469" style="cursor:pointer;">[?]</font></a>'; break;
			default : $to_door = TEXT_DOOR_TO_DOOR;
		}
	  	$time_unit = TEXT_DAYS_LAN;
    	if ($val['time_unit'] == 20) {
    		$time_unit = TEXT_WORKDAYS;
    	}
	  	$result_code .= 		'<tr cost="'.round($val['final_cost'], 2).'" day="'.($val['day_low']*10+$val['day_high']).'">
									<td align = "left" style="padding:8px 8px;">'.$val['title'].'</td>
									<td align = "center" style="padding:8px 8px;">'.$val['days'].' ' . zen_get_text_days($type, $val['day_high']) .'</td>
									<td align = "center" style="padding:8px 8px;">' . $val['box'] . '</td>
									<td align = "center" style="padding:8px 8px;">'.$to_door.'</td>
									<td align = "center" style="padding:8px 8px;">'. ($val['final_cost'] == 0 ? 'free shipping' : $currencies->format($val['final_cost'])) .'</td>
									' . (sizeof($special_discount) > 0 ? '<td align="center" style="color:#ff0000;">' . ($special_discount[$val['code']] > 0 ? '-' . $currencies->format($special_discount[$val['code']]) : '') . '</td>' : '') . '
								 </tr>';	  	
	}
	$result_code .= '</table></fieldset>
	  					<div style="text-align:right;margin-top:20px">
	  					  <a style="color:#008FED;" target="_blank" href = "index.php?main_page=who_we_are&id=99999" >[' . SHIPPING_CONTACT_US . ']</a>
	  					</div>';
}

$breadcrumb->add(NAVBAR_TITLE);
?>