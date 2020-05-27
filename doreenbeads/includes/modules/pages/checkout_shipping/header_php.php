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
  $zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_SHIPPING');
  
  require_once(DIR_WS_CLASSES . 'http_client.php');
  require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
  
  $paypal_success_url = zen_db_prepare_input($_GET['paypal_success_url']);
  unset($_SESSION['coupon_id']);
  unset($_SESSION['use_coupon']);
  unset($_SESSION['use_coupon_amount']);
  unset($_SESSION['order_number_created']);
  //$_SESSION['cart']->calculate();

$_SESSION ['valid_to_checkout'] = true;
$default_select_id = SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY;
//Tianwen.Wan20160624购物车优化
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
  
// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($products_array['count'] <= 0) {
    zen_redirect(zen_href_link(FILENAME_TIME_OUT));
  }
// if the customer is not logged on, redirect them to the login page
  if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  } else {
    // validate customer
    if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
      $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_SHIPPING));
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
    }
  }

// Validate Cart for checkout
  
  //$_SESSION ['cart']->get_isvalid_checkout ( true );
  //$_SESSION ['cart']->calculate();
//  $_SESSION['cart']->get_products(true);
  if ($_SESSION['valid_to_checkout'] == false) {
    zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
  }
  
// Stock Check
//  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
//    $products = $_SESSION['cart']->get_products();
//    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
//      if (zen_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
//        zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
//        break;
//      }
//    }
//  }
// if no shipping destination address was selected, use the customers own address as default

if (!$_SESSION['sendto']) {
    $customers_address_query = $db->Execute("select customers_default_address_id  from ". TABLE_CUSTOMERS . " where customers_id='".(int)$_SESSION['customer_id']."'");
    $_SESSION['sendto'] = intval($customers_address_query->fields['customers_default_address_id']);

    if(! $_SESSION['sendto'] || $_SESSION['sendto'] == 0){
        $address_listing = $db->Execute("select address_book_id from  ".TABLE_ADDRESS_BOOK." where customers_id = " . (int)$_SESSION['customer_id']." limit 1");
        if($address_listing->RecordCount()>0) $_SESSION['sendto'] = intval($address_listing->fields['address_book_id']);
        else $_SESSION['sendto'] = 0;
    }

    $_SESSION['customer_default_address_id'] = $_SESSION['sendto'];
}

$address_info = get_customer_address_info($_SESSION['customer_id'], $_SESSION['sendto']);
$default_select_id = $address_info['entry_country_id'];

$address_num = get_customers_address_num($_SESSION['customer_id']);

$obj_info["info_customers_id"]=$_SESSION['customer_id'];

//	get the default country by language
//$default_select_id=zen_get_selected_country($_SESSION['languages_id']);
//	gen the country select field
$obj_info["country_select"]=zen_get_country_select('zone_country_id', $default_select_id,$_SESSION['languages_id']);
//	gen the zone js
$obj_info["zone_list"]=zen_js_zone_list('SelectedCountry', 'theForm', 'zone_id');

$flag_show_pulldown_query='select zone_country_id from '.TABLE_ZONES.' where zone_country_id="'.$default_select_id.'" limit 1 ';
$flag_show_pulldown=$db->Execute($flag_show_pulldown_query);
if($flag_show_pulldown->RecordCount()>0){
	$flag_show_pulldown_states=true;
}
if ($flag_show_pulldown_states == true) {
	$obj_info["pulldown_states"] = zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($default_select_id), $address_info['entry_zone_id'], 'id="stateZone"').zen_draw_input_field('state', $address_info['entry_state'],'class="hiddenField" id="state"');
}else{
	$obj_info["pulldown_states"] = zen_draw_input_field('state', $address_info['entry_state'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"').zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($default_select_id), $address_info['entry_zone_id'], 'id="stateZone" class="hiddenField"');
}


  
$obj_info['sendto']=$_SESSION['sendto'];
$obj_info['langs']=$_SESSION['language'];
$obj_info['add_show']=$_SESSION['sendto']>0?1:0;
$obj_info['curreny']=$_SESSION['currency'];

//	smarty assign
$smarty->assign('paypal_success_url', $paypal_success_url);
$smarty->assign('obj_image',$obj_image);
$smarty->assign('obj_text',$obj_text);
$smarty->assign('obj_info',$obj_info);
$smarty->assign('address_info', $address_info);
    $smarty->assign('address_num', $address_num);
// This should be last line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_SHIPPING');
?>