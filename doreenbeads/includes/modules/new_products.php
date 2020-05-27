<?php
/**
 * new_products.php module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: new_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$new_products_query = '';
$display_limit = zen_get_new_date_range();

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $new_products_query = "select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, p.products_weight, ps.products_quantity,
                                p.products_date_added, p.products_price, p.products_type, p.master_categories_id, p.products_model, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                           from " . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id 
                           and p.products_id = ps.products_id 
                           and p.products_id = ps.products_id		
                           and p.products_status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.products_status = 1 
						   order by p.products_date_added desc limit 0, 35"; //. $display_limit;
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? get_category_info_memcache($_GET['filter_id'] , 'cPath') : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma

    $new_products_query = "select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, p.products_weight,
                                  p.products_date_added, p.products_price, p.products_type, p.master_categories_id, p.products_model, ps.products_quantity, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                           from " . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id 
                           and p.products_id = ps.products_id 
                           and p.products_id = ps.products_id	
                           and p.products_status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.products_id in (" . $list_of_products . ") 
						   order by p.products_date_added desc limit 0, 35";
  }
}

if ($new_products_query != '') $new_products = $db->ExecuteRandomMulti($new_products_query, MAX_DISPLAY_NEW_PRODUCTS);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($new_products_query == '') ? 0 : $new_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS == 0 ) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS);
  }

  while (!$new_products->EOF) {
  	// add by zale 
	$page_name = "new_products";
    $page_type = 3;    
    if($_SESSION['cart']->in_cart($new_products->fields['products_id'])){		//if item already in cart
    	$procuct_qty = $_SESSION['cart']->get_quantity($new_products->fields['products_id']);
    	$bool_in_cart = 1;
    }else {
    	$procuct_qty = 0;
    	$bool_in_cart = 0;
    }
    //eof
    $products_price = zen_get_products_display_price($new_products->fields['products_id']);
    if (!isset($productsInCategory[$new_products->fields['products_id']])) $productsInCategory[$new_products->fields['products_id']] = get_category_info_memcache($new_products->fields['master_categories_id'] , 'cPath');
	  if ($this_is_home_page){
	    $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsNew centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
        										'product_id'=>$new_products->fields['products_id'],	
	    									   'text' => (($new_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . zen_href_link('product_info', 'cPath=' . $productsInCategory[$new_products->fields['products_id']] . '&products_id=' . $new_products->fields['products_id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($new_products->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($new_products->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($new_products->fields['products_image'], 130, 130) . '"></a><br />') . '<a href="' . zen_href_link('product_info', 'cPath=' . $productsInCategory[$new_products->fields['products_id']] . '&products_id=' . $new_products->fields['products_id']) . '">' . getstrbylength($new_products->fields['products_name'],130) . '</a><br />' . $products_price);
	  } else {
		if ($new_products->fields['products_quantity'] > 0){
			$add_to_cart_text = 'Add: <input type="text" id="'.$page_name.'_'.$new_products->fields['products_id'].'" name="products_id[' . $new_products->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $new_products->fields['products_quantity_order_min']).'" size="4" /><input type="hidden" id="MDO_' . $new_products->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $new_products->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />' . zen_image_submit('button_quick_add_to_cart.jpg', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $new_products->fields['products_id'] . '" name="submitp_' .  $new_products->fields['products_id'] . '" onclick="Addtocart('.$new_products->fields['products_id'].','.$page_type.'); return false;"');
		} else {
			$add_to_cart_text = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products->fields['products_id'] . '&action=notify&number_of_uploads=0') . '">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a>';
		}
	    $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsNew centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
        										'product_id'=>$new_products->fields['products_id'],	
	    									   'text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products->fields['products_id']) . '" target="_blank"><img alt="' . htmlspecialchars(zen_clean_html($new_products->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($new_products->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($new_products->fields['products_image'], 130, 130) . '"></a><br /><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products->fields['products_id']) . '" target="_blank">' . TEXT_MODEL . ':' . $new_products->fields['products_model'] . '</a><br />' . zen_get_products_display_price($new_products->fields['products_id']) . '<br />' . $add_to_cart_text);
	  }
    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $new_products->MoveNextRandom();
  }

  if ($new_products->RecordCount() > 0) {
    if (isset($new_products_category_id) && $new_products_category_id != 0) {
      $category_title = get_category_info_memcache((int)$new_products_category_id , 'categories_name');
      $title = '<h2 class="centerBoxHeading">' . sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')) . ($category_title != '' ? ' - ' . $category_title : '' ) . '</h2>';
    } else {
      $title = '<h2 class="centerBoxHeading">' . sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')) . '</h2>';
    }
    $zc_show_new_products = true;
  }
}
?>
