<?php
/**
 * Featured Products
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 */

zen_redirect(zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=new'));

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

//jessa 2010-05-03 �жϹ˿�ѡ���������ģʽ�����ѡ��Ĭ��Ϊ����ģʽ
  if (!isset($_GET['action'])){
  	if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'quick';
  }else{
  	if ($_GET['action'] == 'normal'){
  		$_SESSION['display_mode'] = 'normal';
  	}elseif ($_GET['action'] == 'quick'){
  		$_SESSION['display_mode'] = 'quick';
  	}
  }
//eof jessa 2010-05-03

//jessa 2010-08-31 ����addtowishlist��������ű�
if (isset($_GET['action']) && $_GET['action'] == 'addToWishlist'){
	if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
		$pid = trim($_GET['pid']);
		$products_id_array = $_POST['products_id'];
		foreach ($products_id_array as $key => $value){
		  if ($key == $pid){
		  	$check_product = $db->Execute("select wl_products_id from t_wishlist where wl_products_id = " . (int)$key . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
		  	if ($check_product->RecordCount() == 0){
		  		$db->Execute("insert into t_wishlist (wl_products_id, wl_customers_id, wl_product_num, wl_date_added)
		  					  values (" . (int)$key . ", " . (int)$_SESSION['customer_id'] . ", " . (int)$value . ", '" . date('YmdHis') . "')");
		  		update_products_add_wishlist(intval($key));
		  	}
		  } elseif (($key != $pid) && ((int)$value > 0)){
		  	$check_product = $db->Execute("select wl_products_id from t_wishlist where wl_products_id = " . (int)$key . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
		  	if ($check_product->RecordCount() == 0){
		  		$db->Execute("insert into t_wishlist (wl_products_id, wl_customers_id, wl_product_num, wl_date_added)
		  					  values (" . (int)$key . ", " . (int)$_SESSION['customer_id'] . ", " . (int)$value . ", '" . date('YmdHis') . "')");
		  		update_products_add_wishlist(intval($key));
		  	}
		  }
		}
		$messageStack->add_session('addwishlist', 'Item(s) Added Successfully into Your Wishlist Account!&nbsp;&nbsp;<a href="' . zen_href_link('wishlist', '', 'SSL') . '">View Wishlist Account</a>', 'success');
		$all_params = zen_get_all_get_params(array('action', 'pid'));
		$all_params = str_replace('amp;', '', $all_params);
		zen_redirect(zen_href_link(FILENAME_FEATURED_PRODUCTS, $all_params));
	} else {
		zen_redirect(zen_href_link(FILENAME_LOGIN));
	}
}
//��� 2010-08-31

$breadcrumb->add(NAVBAR_TITLE);
// display order dropdown
$disp_order_default = PRODUCT_FEATURED_LIST_SORT_DEFAULT;

 $solr_str_array = get_listing_display_order($disp_order_default);
 $solr_order_str = $solr_str_array['solr_order_str'];
 $order_by = $solr_str_array['order_by'];

$featured_products_array = array();

$featured_products_query_raw = "SELECT p.products_id, p.products_type, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id, 
								  p.products_date_added, m.manufacturers_name, p.products_model, ps.products_quantity, p.products_weight, p.product_is_call,
                                  p.product_is_always_free_shipping, p.products_qty_box_status,
                                  p.master_categories_id, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                                  FROM (" . TABLE_PRODUCTS . " p
                                  LEFT JOIN " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id), " .
								  TABLE_PRODUCTS_DESCRIPTION . " pd
                                  LEFT JOIN " . TABLE_FEATURED . " f on (pd.products_id = f.products_id), ".TABLE_PRODUCTS_STOCK." ps) 
                                  WHERE p.products_status = 1 and p.products_id = f.products_id and f.status = 1
                                  AND p.products_id = pd.products_id and pd.language_id = :languagesID " .
								$order_by;

$featured_products_query_raw = $db->bindVars($featured_products_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
$featured_products_split = new splitPageResults($featured_products_query_raw, $_SESSION['per_page']);

//check to see if we are in normal mode ... not showcase, not maintenance, etc
$show_submit = zen_run_normal();

// check whether to use multiple-add-to-cart, and whether top or bottom buttons are displayed
if (PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $featured_products_split->number_of_rows > 0) {

  // check how many rows
  $check_products_all = $db->Execute($featured_products_split->sql_query);
  $how_many = 0;
  while (!$check_products_all->EOF) {
    if (zen_has_product_attributes($check_products_all->fields['products_id'])) {
    } else {
      // needs a better check v1.3.1
      if ($check_products_all->fields['products_qty_box_status'] != 0) {
        if (zen_get_products_allow_add_to_cart($check_products_all->fields['products_id']) !='N') {
          if ($check_products_all->fields['product_is_call'] == 0) {
            if ((SHOW_PRODUCTS_SOLD_OUT_IMAGE == 1 and $check_products_all->fields['products_quantity'] > 0) or SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0) {
              if ($check_products_all->fields['products_type'] != 3) {
                if (zen_has_product_attributes($check_products_all->fields['products_id']) < 1) {
                  $how_many++;
                }
              }
            }
          }
        }
      }
    }
    $check_products_all->MoveNext();
  }

  if ( (($how_many > 0 and $show_submit == true and $featured_products_split->number_of_rows > 0) and (PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART == 1 or  PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART == 3)) ) {
    $show_top_submit_button = true;
  } else {
    $show_top_submit_button = false;
  }
  if ( (($how_many > 0 and $show_submit == true and $featured_products_split->number_of_rows > 0) and (PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART >= 2)) ) {
    $show_bottom_submit_button = true;
  } else {
    $show_bottom_submit_button = false;
  }
}
?>