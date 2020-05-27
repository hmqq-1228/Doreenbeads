<?php
/**
 * specials_index module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: specials_index.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$specials_index_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
//update wei.liang
	$specials_index_count_query = "select count(s.status) as counts
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                            where p.products_id = s.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = '1' and s.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
  $specials_index_counts = $db->Execute($specials_index_count_query);
  $specials_index_count = intval($specials_index_counts->fields['counts']);//获取specials的个数
  $day_specials_index = $specials_index_count/9;
  if($day_specials_index>0 && $day_specials_index>2){
  	$day_specials_index = intval($day_specials_index) + 1;
  }
  elseif($day_specials_index>1 && $day_specials_index<2){
  	$day_specials_index = 2;
  }
  else{
  	$day_specials_index = intval($day_specials_index);
  }
  
  if($day_specials_index == 0 || $day_specials_index ==1){
  	$limit_start_specials = 0;
  }elseif($day_specials_index == 2){
  	  $dates = intval(date("d"));
  	  if($dates%$day_specials_index==0){
  	  	 $limit_start_specials = 0;
  	  }else{
  	  	 $limit_start_specials = 9;
  	  }
  }elseif($day_specials_index > 2){
  	  $dates = intval(date("d"));
  	  $limit_start_specials = intval($dates%intval($day_specials_index));
  	  $limit_start_specials = ($limit_start_specials*9);
  }
//out update wei.liang
	
	/*
	$specials_index_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_model, 
  								  p.products_price, p.products_weight, ps.products_quantity, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                           from (".TABLE_PRODUCTS_STOCK." ps, " . TABLE_PRODUCTS . " p
                           left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = s.products_id
                           and p.products_id = pd.products_id 
                            and p.products_id = ps.products_id 
                           and p.products_status = '1' and s.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.time_sort_order limit ".$limit_start_specials.",9";
    */

	$specials_index_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_model,   
  								  p.products_price, p.products_weight, ps.products_quantity, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
							  from " . TABLE_PRODUCTS . " p left join ".TABLE_PRODUCTS_STOCK." ps on p.products_id=ps.products_id
							  inner join " . TABLE_SPECIALS . " s on p.products_id = s.products_id 
							  inner join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id
							  where  p.products_status = 1 and s.status = 1 and pd.language_id = " . (int)$_SESSION['languages_id'] . " order by p.time_sort_order limit ".$limit_start_specials.",9";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? get_products_info_memcache($_GET['filter_id'] , 'cPath') : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
    $specials_index_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_model, 
    								p.products_price, products_weight, ps.products_quantity, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                             from (".TABLE_PRODUCTS_STOCK." ps, " . TABLE_PRODUCTS . " p
                             left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                             left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                             where p.products_id = s.products_id
                             and p.products_id = pd.products_id 
                              and p.products_id = ps.products_id 
                             and p.products_status = '1' and s.status = '1'
                             and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                             and p.products_id in (" . $list_of_products . ")  limit 9";
  }
}
if ($specials_index_query != '') $specials_index = $db->ExecuteRandomMulti($specials_index_query, MAX_DISPLAY_SPECIAL_PRODUCTS_INDEX);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($specials_index_query == '') ? 0 : $specials_index->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS == 0 ) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS);
  }

  $list_box_contents = array();
  while (!$specials_index->EOF) {
  	// add by zale 
	$page_name = "specisals_index";
    $page_type = 6;    
    if($_SESSION['cart']->in_cart($specials_index->fields['products_id'])){		//if item already in cart
    	$procuct_qty = $_SESSION['cart']->get_quantity($specials_index->fields['products_id']);
    	$bool_in_cart = 1;
    }else {
    	$procuct_qty = 0;
    	$bool_in_cart = 0;
    }
    //eof
    $products_price = zen_get_products_display_price($specials_index->fields['products_id']);
    if (!isset($productsInCategory[$specials_index->fields['products_id']])) $productsInCategory[$specials_index->fields['products_id']] = get_products_info_memcache($specials_index->fields['master_categories_id'] , 'cPath');
	 	if ($specials_index->fields['products_quantity'] > 0){
	 		$add_to_cart_text = 'Add: <input type="text" id="'.$page_name.'_'.$specials_index->fields['products_id'].'" name="products_id[' . $specials_index->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $specials_index->fields['products_quantity_order_min']).'" size="4" /><input type="hidden" id="MDO_' . $specials_index->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $specials_index->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />' . zen_image_submit('button_quick_add_to_cart.jpg', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $specials_index->fields['products_id'] . '" onclick="Addtocart('.$specials_index->fields['products_id'].','.$page_type.'); return false;" name="submitp_' .  $specials_index->fields['products_id'] . '"');
	 	} else {
	 		$add_to_cart_text = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials_index->fields['products_id'] . '&action=notify&number_of_uploads=0') . '">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a>';
	 	}
    	$specials_index->fields['products_name'] = zen_get_products_name($specials_index->fields['products_id']);
    	
    	if ($this_is_home_page){
		    $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsSpecials centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
        											'product_id'=>$specials_index->fields['products_id'],	
		    									   'text' => (($specials_index->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . zen_href_link('product_info', 'cPath=' . $productsInCategory[$specials_index->fields['products_id']] . '&products_id=' . (int)$specials_index->fields['products_id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($specials_index->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($specials_index->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($specials_index->fields['products_image'], 130, 130) . '"></a><br />') . '<a href="' . zen_href_link('product_info', 'cPath=' . $productsInCategory[$specials_index->fields['products_id']] . '&products_id=' . $specials_index->fields['products_id']) . '">' . getstrbylength($specials_index->fields['products_name'],130) . '</a><br />' . $products_price);
    	} else {
	    	$list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsSpecials centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
        											'product_id'=>$specials_index->fields['products_id'],	
	    									   	   'text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials_index->fields['products_id']) . '" target="_blank">' . zen_image_quick_view(DIR_WS_IMAGES . $specials_index->fields['products_image'], $specials_index->fields['products_name'] . '<br />' . '<span style="color:blue;">Weight: ' . $specials_index->fields['products_weight'] . '&nbsp;&nbsp;' . TEXT_GRAMS . '<br />' . TEXT_PRICE_WORDS . ': </span>' . zen_display_products_quantity_discounts($specials_index->fields['products_id']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, '1') . '</a><br /><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials_index->fields['products_id']) . '" target="_blank">' . TEXT_MODEL . ':' . $specials_index->fields['products_model'] . '</a><br />' . zen_get_products_display_price($specials_index->fields['products_id']) . '<br />' . $add_to_cart_text);
    	}
    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $specials_index->MoveNextRandom();
  }

  if ($specials_index->RecordCount() > 0) {
    $title = '<h2 class="centerBoxHeading">' . sprintf(TABLE_HEADING_SPECIALS_INDEX, strftime('%B')) . '</h2>';
    $zc_show_specials = true;
  }
}
?>