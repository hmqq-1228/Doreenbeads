<?php
/**
 * featured_products module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: featured_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$featured_products_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
//update wei.liang
	$featured_products_count_query = "select count(f.featured_id) as counts
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
  $featured_products_counts = $db->Execute($featured_products_count_query);
  $featured_products_count = intval($featured_products_counts->fields['counts']);//获取featured的个数
  $day_featured_products = $featured_products_count/12;
  //echo $day_featured_products/2;exit;
  if($day_featured_products>0 && $day_featured_products>2){
  	$day_featured_products = intval($day_featured_products);
  }elseif($day_featured_products>1 && $day_featured_products<2){
  	$day_featured_products = 2;
  }
  else{
  	$day_featured_products = intval($day_featured_products);
  }
  
  if($day_featured_products == 0 || $day_featured_products == 1){
  	$limit_start = 0;
  }elseif($day_featured_products == 2){
  	  $date = intval(date("d"));
  	  if($date%$day_featured_products==0){
  	  	 $limit_start = 0;
  	  }else{
  	  	 $limit_start = 12;
  	  }
  }elseif($day_featured_products > 2){
  	  $date = intval(date("d"));
  	  $limit_start = intval($date%intval($day_featured_products));
  	  $limit_start = ($limit_start*12);
  }
//out update wei.liang
  $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_weight, p.products_price, 
  									 p.products_model, ps.products_quantity, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                           from (" . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                            where p.products_id = f.products_id
                           and p.products_id = pd.products_id 
                           and p.products_id = ps.products_id 
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by f.featured_id desc limit ".$limit_start.",12";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? get_category_info_memcache($_GET['filter_id'] , 'cPath') : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
    $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_weight, p.products_price,
    								   p.products_model, ps.products_quantity, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                                from (" . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id 
                                and p.products_id = ps.products_id 
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id in (" . $list_of_products . ") limit 12";
  }
}
if ($featured_products_query != '') $featured_products = $db->ExecuteRandomMulti($featured_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($featured_products_query == '') ? 0 : $featured_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS == 0) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS);
  }
  while (!$featured_products->EOF) {
  	// add by zale 
	$page_name = "featured_products";
    $page_type = 5;    
    if($_SESSION['cart']->in_cart($featured_products->fields['products_id'])){		//if item already in cart
    	$procuct_qty = $_SESSION['cart']->get_quantity($featured_products->fields['products_id']);
    	$bool_in_cart = 1;
    }else {
    	$procuct_qty = 0;
    	$bool_in_cart = 0;
    }
    //eof
    $products_price = zen_get_products_display_price($featured_products->fields['products_id']);
    if ($featured_products->fields['products_quantity']){
    	$add_to_cart_text = 'Add: <input type="text" id="'.$page_name.'_'.$featured_products->fields['products_id'].'" name="products_id[' . $featured_products->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $featured_products->fields['products_quantity_order_min']).'" size="4" /><input type="hidden" id="MDO_' . $featured_products->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $featured_products->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />' . zen_image_submit('button_quick_add_to_cart.jpg', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $featured_products->fields['products_id'] . '" onclick="Addtocart('.$featured_products->fields['products_id'].','.$page_type.'); return false;" name="submitp_' .  $featured_products->fields['products_id'] . '"');
    } else {
    	$add_to_cart_text = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products->fields['products_id'] . '&action=notify&number_of_uploads=0') . '">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a>';
    }
    if (!isset($productsInCategory[$featured_products->fields['products_id']])) $productsInCategory[$featured_products->fields['products_id']] = get_category_info_memcache($featured_products->fields['master_categories_id'] , 'cPath');
      if ($this_is_home_page){
	    $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsFeatured centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
        										'product_id'=>$featured_products->fields['products_id'],	
	    									   'text' => (($featured_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . zen_href_link('product_info', 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($featured_products->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($featured_products->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($featured_products->fields['products_image'], 130, 130) . '"></a><br />') . '<a href="' . zen_href_link('product_info', 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']) . '">' . getstrbylength($featured_products->fields['products_name'],130) . '</a><br />' . $products_price);
      } else {
	    $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsFeatured centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
        										'product_id'=>$featured_products->fields['products_id'],
	    									   'text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products->fields['products_id']) . '" target="_blank"><img alt="' . htmlspecialchars(zen_clean_html($featured_products->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($featured_products->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($featured_products->fields['products_image'], 130, 130) . '"></a><br /><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products->fields['products_id']) . '" target="_blank">' . TEXT_MODEL . ':' . $featured_products->fields['products_model'] . '</a><br />' . zen_get_products_display_price($featured_products->fields['products_id']) . '<br />' . $add_to_cart_text);
      } 
    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $featured_products->MoveNextRandom();
  }

  if ($featured_products->RecordCount() > 0) {
    if (isset($new_products_category_id) && $new_products_category_id !=0) {
      $category_title = get_category_info_memcache((int)$new_products_category_id , 'categories_name');
      $title = '<h2 class="centerBoxHeading">' . TABLE_HEADING_FEATURED_PRODUCTS . ($category_title != '' ? ' - ' . $category_title : '') . '</h2>';
    } else {
      $title = '<h2 class="centerBoxHeading">' . TABLE_HEADING_FEATURED_PRODUCTS . '</h2>';
    }
    $zc_show_featured = true;
  }
}
?>