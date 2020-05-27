<?php
/**
 * header_php.php
 * 锟铰诧拷品锟侥帮拷
 */
 zen_redirect(zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=new&'.zen_get_all_get_params(array('main_page','pn'))));

 if (!isset($_GET['action'])){
  	if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'normal';
//   	$_SESSION['display_mode'] = 'quick';
  }else{
  	if ($_GET['action'] == 'normal'){
  		$_SESSION['display_mode'] = 'normal';
  	}elseif ($_GET['action'] == 'quick'){
  		$_SESSION['display_mode'] = 'quick';
  	}
  }
  $zco_notifier->notify('NOTIFY_HEADER_START_PRODUCTS_NEWS');
  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  
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
		zen_redirect(zen_href_link(FILENAME_PRODUCTS_NEW, $all_params));
	} else {
		zen_redirect(zen_href_link(FILENAME_LOGIN));
	}
}
//锟斤拷锟?2010-08-31
  
  $show_all_catg = false;
  $show_all_prod = false;
  
  //锟斤拷锟絡oindate锟斤拷锟斤拷
  if (!isset($_GET['joindate']) || (isset($_GET['joindate']) && $_GET['joindate'] == '')){
  	$joindate = 30;
  } else {
	$joindate = trim($_GET['joindate']);
  }
  
//   $today_date = date('Y-m-d');
//   $current_joindate_ago = date('Y-m-d', (time() - (int)$joindate * 24 * 60 * 60));
  
  $today_year = date('Y');
  $today_month = date('m');
  $today_day = date('d');
  $current_joindate_ago = date('Y-m-d', (mktime(0, 0, 0, ($today_month - 1), $today_day, $today_year)));
  
  if (isset($_GET['change_catg']) && $_GET['change_catg'] != ''){
  	$show_all_prod = true;
  	
  	$page_size = 100;
	if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == '')){
	  $curr_page = 1;
	} else {
	  $curr_page = trim($_GET['page']);
	}
	
  	//锟斤拷锟斤拷锟斤拷锟斤拷锟斤拷碌锟斤拷锟斤拷锟斤拷虏锟狡凤拷锟斤拷椋拷锟斤拷锟斤拷锟绞?  	$catg_id = trim($_GET['change_catg']);
  	$prod_in_this_catg = zen_get_categories_products_list($catg_id);
  	
  	$prod_list = '';
  	if (is_array($prod_in_this_catg)){
  		foreach ($prod_in_this_catg as $prod_key => $prod_value){
  			$prod_list .= $prod_key . ', ';
  		}
  	}
  	$prod_list = substr($prod_list, 0, -2);
  	
  	$new_prod_query = "Select distinct p.products_id, p.products_level, ps.products_quantity, p.products_model, p.products_image, 
  						  	  p.products_weight, p.products_price, pd.products_name
  						 From " . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p, ". TABLE_PRODUCTS_DESCRIPTION . " pd
  						Where p.products_id in (" . $prod_list . ")
  						  And p.products_status = 1
					      And p.products_id = pd.products_id 
					      and p.products_id = ps.products_id 
						  AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
					      And p.products_date_added >= '" . $current_joindate_ago . "'
					 	Order By p.products_id DESC
					 	Limit " . (($curr_page - 1) * $page_size) . ', ' . $page_size;
  	$new_prod_num_query = "Select distinct p.products_id
  						     From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
  						    Where p.products_id in (" . $prod_list . ")
  						      And p.products_status = 1
						      And p.products_id = pd.products_id
						      And p.products_date_added >= '" . $current_joindate_ago . "'";
  	$new_prod = $db->Execute($new_prod_query);
  	$new_prod_num = $db->Execute($new_prod_num_query);
  	
  	$new_prod_array = array();
  	$row = 0;
  	$col = 0;
  	while (!$new_prod->EOF){
  		$new_prod_array[$row][$col] = array('id' => $new_prod->fields['products_id'],
  											'name' => $new_prod->fields['products_name'],
  											'model' => $new_prod->fields['products_model'],
  											'image' => $new_prod->fields['products_image'],
  											'weight' => $new_prod->fields['products_weight'],
  											'price' => $new_prod->fields['products_price']);
  		$col++;
  		if ($col > 4){
  			$col = 0;
  			$row++;
  		}
  		$new_prod->MoveNext();
  	}
  	
  	$total_prod_num = $new_prod_num->RecordCount();
  	$total_page_num = ceil($total_prod_num / $page_size);
  	
  	$start_num = ($curr_page - 1) * $page_size + 1;
  	if (($curr_page * $page_size) < $total_prod_num){
  		$end_num = $curr_page * $page_size;
  	} else {
  		$end_num = $total_prod_num;
  	}
  	$link = $_GET['main_page'] . '&change_catg=' . $_GET['change_catg'];
  }
  
  if (!isset($_GET['change_catg']) || (isset($_GET['change_catg']) && $_GET['change_catg'] == '')){
  	$show_all_catg = true;
  	
  	$page_size = 10;
  	if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == '')){
  		$curr_page = 1;
  	} else {
  		$curr_page = trim($_GET['page']);
  	}
  	$display_limit = zen_get_new_date_range();
  	$products_new_query_raw = "SELECT p.products_id, p.products_type, p.products_level, pd.products_name, p.products_image, p.products_price,
                                    p.products_tax_class_id, p.products_date_added, m.manufacturers_name, p.products_model,
                                    pa.products_quantity, p.products_weight, p.product_is_call, p.product_is_free,
                                    p.product_is_always_free_shipping, p.products_qty_box_status, p.products_discount_type, 
  									p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
                             FROM " . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p
                             LEFT JOIN " . TABLE_MANUFACTURERS . " m
                             ON (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             WHERE p.products_status = 1
							 AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
                             AND p.products_id = pd.products_id
                             AND p.products_date_added >= '" . $current_joindate_ago . "'
                             AND pd.language_id = :languageID " . $display_limit . "order by p.products_id desc";

  $products_new_query_raw = $db->bindVars($products_new_query_raw, ':languageID', $_SESSION['languages_id'], 'integer');
  $products_new_split = new splitPageResults($products_new_query_raw, $_SESSION['per_page']);
  $show_submit = zen_run_normal();
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
  
  $solr_order_str = 'products_date_added desc';

  }
  if (isset($_GET['change_catg']) && $_GET['change_catg'] != ''){
  	$breadcrumb->add('New Arrivals', zen_href_link(FILENAME_PRODUCTS_NEW));
  	$breadcrumb->add(zen_get_curr_categories_name(trim($_GET['change_catg'])));
  } else {
  	$breadcrumb->add('New Arrivals');
  }
  $zco_notifier->notify('NOTIFY_HEADER_END_PRODUCTS_NEWS');
?>