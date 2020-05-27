<?php
/**
 * products_new header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 */

zen_redirect(zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=new'));

  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  
  //jessa 2010-05-03 �жϹ˿�ѡ���������ģʽ�����ѡ��Ĭ��Ϊ����ģʽ
  if (!isset($_GET['action'])){
  	if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'normal';
  }else{
  	if ($_GET['action'] == 'normal'){
  		$_SESSION['display_mode'] = 'normal';
  	}else{
  		$_SESSION['display_mode'] = 'quick';
  	}
  }
  //eof jessa 2010-05-03
  
  $breadcrumb->add(NAVBAR_TITLE);
// display order dropdown
  $disp_order_default = PRODUCT_FEATURED_LIST_SORT_DEFAULT;
	$solr_str_array = get_listing_display_order($disp_order_default);
	$solr_order_str = $solr_str_array['solr_order_str'];
	$order_by = $solr_str_array['order_by'];
  $products_new_array = array();
// display limits
//  $display_limit = zen_get_products_new_timelimit();
  $display_limit = zen_get_new_date_range();

  //jessa 2010-05-07 newproducts��ʾһ�������ڵĲ�Ʒ
  $today_year = date('Y');
  $today_month = date('m');
  $today_day = date('d');
  $today_month_ago = date('Y-m-d', (mktime(0, 0, 0, ($today_month - 1), $today_day, $today_year)));
  //eof jessa 2010-05-07
  //AND p.products_date_added >= '" . $today_month_ago . "'(��ʱȥ���������)
  $products_new_query_raw = "SELECT p.products_id, p.products_type, p.products_level, pd.products_name, p.products_image, p.products_price,
                                    p.products_tax_class_id, p.products_date_added, m.manufacturers_name, p.products_model,
                                    pq.products_quantity, p.products_weight, p.product_is_call,
                                    p.product_is_always_free_shipping, p.products_qty_box_status,
                                    p.master_categories_id, p.products_discount_type,
  									p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                             FROM " . TABLE_PRODUCTS . " p
                             LEFT JOIN " .TABLE_PRODUCTS_QUANTITY. " pq on p.products_id=pq.products_id
                             LEFT JOIN " . TABLE_MANUFACTURERS . " m
                             ON (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             WHERE p.products_status = 1
							 AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
                             AND p.products_id = pd.products_id
                             AND pd.language_id = :languageID " . $display_limit . $order_by;

  $products_new_query_raw = $db->bindVars($products_new_query_raw, ':languageID', $_SESSION['languages_id'], 'integer');
  $products_new_split = new splitPageResults($products_new_query_raw, MAX_DISPLAY_PRODUCTS_NEW);

//check to see if we are in normal mode ... not showcase, not maintenance, etc
  $show_submit = zen_run_normal();

// check whether to use multiple-add-to-cart, and whether top or bottom buttons are displayed
  if (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $products_new_split->number_of_rows > 0) {

    // check how many rows
    $check_products_all = $db->Execute($products_new_split->sql_query);
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

    if ( (($how_many > 0 and $show_submit == true and $products_new_split->number_of_rows > 0) and (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART == 1 or  PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART == 3)) ) {
      $show_top_submit_button = true;
    } else {
      $show_top_submit_button = false;
    }
    if ( (($how_many > 0 and $show_submit == true and $products_new_split->number_of_rows > 0) and (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART >= 2)) ) {
      $show_bottom_submit_button = true;
    } else {
      $show_bottom_submit_button = false;
    }
  }
?>