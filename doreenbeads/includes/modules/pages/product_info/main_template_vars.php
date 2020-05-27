<?php
  //require 'includes/extra_configures/times_language.php';
  // This should be first line of the script:
  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_START_PRODUCT_INFO');

  $module_show_categories = PRODUCT_INFO_CATEGORIES;
  $products_id = (int)$_GET['products_id'];
  /*
  $sql_status = "select products_status
          from " . TABLE_PRODUCTS . " p
          where     p.products_id = '" . (int)$_GET['products_id'] . "'";
  $res_status = $db->Execute($sql_status);
  */
  $product_info = new stdClass();
  $product_info->fields = get_products_info_memcache($products_id);
  $product_info->fields['products_quantity'] = zen_get_products_stock($products_id);
  $products_status_str = " p.products_status = '1'  and ";
  //echo $_GET['products_id'];
  //echo $_SESSION['customer_id'];
  $customer_available = check_my_product($_SESSION['customer_id'], $products_id);
  //var_dump($customer_available);
  if($product_info->fields['products_status'] == 0){
		if(strpos($_SERVER['HTTP_REFERER'],'google') > 0){
			$products_status_str = "";
		}elseif($customer_available){
			$products_status_str = " (p.products_limit_stock=0 or ".$product_info->fields['products_quantity'].">0) and ";
		}
  }
  $product_info->fields['products_name'] = get_products_description_memcache($products_id,$_SESSION['languages_id']);
  /*
  $sql = "select count(*) as total
          from " . TABLE_PRODUCTS . " p, " .
                   TABLE_PRODUCTS_DESCRIPTION . " pd
          where   ".$products_status_str."       p.products_id = '" . (int)$_GET['products_id'] . "'
          and      pd.products_id = p.products_id
          and      pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";


  $res = $db->Execute($sql);

  $check_binded = $db->Execute("select myid from ".TABLE_MY_PRODUCTS." where products_id='".(int)$_GET['products_id']."' limit 1");
  if(!$customer_available && $check_binded->fields['myid']>0){
  	$res->fields['total']=0;
  }
  */
  $check_binded = $db->Execute("select myid from ".TABLE_MY_PRODUCTS." where products_id='".(int)$_GET['products_id']."' limit 1");
  if(!$customer_available && ($check_binded->fields['myid']>0 || empty($product_info->fields['products_model'])  || $product_info->fields['products_status'] != 1)) {
      $define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PRODUCT_NOT_FOUND, 'false');
      $define_page_system_page_baner = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_SYSTEM_PAGE_BANNER, 'false');
      
      $tpl_page_body = '/tpl_product_info_noproduct.php';
      
      //记录无效链接
	  record_valid_url();
	 //eof

  } else {
    $tpl_page_body = '/tpl_product_info_display.php';
    /*
    $res = $db->Execute($sql);
    
    $sql = "select p.products_id, pd.products_name,
                   p.products_model,
                  p.products_quantity, p.products_image,
                  pd.products_url, p.products_price,
                  p.products_tax_class_id, p.products_date_added,
                  p.products_date_available, p.manufacturers_id,
                  p.products_weight, p.products_priced_by_attribute, p.product_is_free,
                  p.products_qty_box_status,
                  p.products_quantity_order_max,
                  p.products_discount_type, p.products_discount_type_from, p.products_sort_order, p.products_price_sorter, 
    			  p.products_quantity_order_min, p.products_volume_weight, p.products_limit_stock
           from   " . TABLE_PRODUCTS . " p, ". TABLE_PRODUCTS_DESCRIPTION . " pd
           where  ".$products_status_str."  p.products_id = '" . (int)$_GET['products_id'] . "'
           and    pd.products_id = p.products_id
           and    pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";

    $product_info = $db->Execute($sql);
    */
    $products_shipping_restriction = get_products_shipping_restriction();
    
    $sql_select_description = "select products_description from ".TABLE_PRODUCTS_INFO." where products_id = ".(int)$_GET['products_id']." and language_id = ".(int)$_SESSION['languages_id'];
    $sql_select_description_result = $db->Execute($sql_select_description);
    if($sql_select_description_result->RecordCount()==0 || strlen(trim($sql_select_description_result->fields['products_description']))<10){
    	$sql_select_description_result = $db->Execute("select products_description from ".TABLE_PRODUCTS_INFO."
  				where products_id='".(int)$_GET['products_id']."'
  				and language_id=1");
    }
    $products_price_sorter = $product_info->fields['products_price_sorter'];

    $products_price = $currencies->display_price($product_info->fields['products_price'],
                      zen_get_tax_rate($product_info->fields['products_tax_class_id']));
    if ($new_price = zen_get_products_special_price($product_info->fields['products_id'],false,$product_info->fields['products_price'])) {
      $specials_price = $currencies->display_price($new_price,zen_get_tax_rate($product_info->fields['products_tax_class_id']));
    }
    $unit_price = zen_get_unit_price((int)$_GET['products_id']);
    // if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){

    // 	$ls_price = '<p class="unit_price_detail">'.$unit_price.'</p>';
    // }else{  
    	$ls_price = '<p class="detailprice">'.zen_get_products_display_price_new((int)$_GET['products_id'], 'product_info').'</p>';
    // }
// if review must be approved or disabled do not show review
    $review_status = " and r.status = '1'";

    /*
    $reviews_query = "select count(*) as count from " . TABLE_REVIEWS . " r, "
                                                       . TABLE_REVIEWS_DESCRIPTION . " rd
                       where r.products_id = '" . (int)$_GET['products_id'] . "'
                       and r.reviews_id = rd.reviews_id
                       and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'" .
                       $review_status;

    $reviews = $db->Execute($reviews_query);
    */
    
    $reviews_query1 = "select r.customers_id, r.reviews_rating, r.customers_name, r.date_added, rd.reviews_text, rd.reviews_reply_text from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                       where r.products_id = '" . (int)$_GET['products_id'] . "'
                       and r.reviews_id = rd.reviews_id "./*
		           	   and  rd.languages_id=" . (int)$_SESSION["languages_id"] ." ".*/
    		           	   $review_status .' order by r.reviews_id desc';
     
    $reviews_split = new splitPageResults($reviews_query1, 5, 'r.reviews_id');
    $count = $reviews_split->number_of_rows;
    $reviews_array = $db->Execute($reviews_split->sql_query);
    $customer_reviews = array();
    while (!$reviews_array->EOF){
    	$customer_reviews[]=array("reviews_rating"=> $reviews_array->fields['reviews_rating'],
    			'custormer_name'=>$reviews_array->fields['customers_name'],
    			'custormer_country' => zen_get_customer_country_name($reviews_array->fields['customers_id']),
    			'date_added'=>$reviews_array->fields['date_added'],
    			'reviews_text'=>$reviews_array->fields['reviews_text'],
    			'reviews_reply_text'=>$reviews_array->fields['reviews_reply_text']
    
    	);
    	 
    	$reviews_array->MoveNext();
    }
    $reviews_number = 0;
    $reviews_total = 0;
    foreach($customer_reviews as $key=>$value){
        $reviews_number ++;
        $reviews_total+=$value['reviews_rating'];
    }
    $review_rate = $reviews_number==0?0:round($reviews_total/$reviews_number);
  }

  $products_name = $product_info->fields['products_name'];
  $products_model = $product_info->fields['products_model'];
  $products_description = $sql_select_description_result->fields['products_description'];

  if ($product_info->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
    $products_image = PRODUCTS_IMAGE_NO_IMAGE;
  } else {
    $products_image = $product_info->fields['products_image'];
  }

  //$products_url = $product_info->fields['products_url'];
  $products_url = '';
  $products_date_available = $product_info->fields['products_date_available'];
  //$products_date_added = $product_info->fields['products_date_added'];
  $products_date_years_ago = date('Y-m-d',strtotime($products_date_added.'-1 year')); 
  $display_data = floor((strtotime(date('Y-m-d'))-strtotime($products_date_added))/86400)/365 >1 ? false:true;
  $products_weight = $product_info->fields['products_weight'];
  $products_volume_weight = $product_info->fields['products_volume_weight'];
  $products_quantity = $product_info->fields['products_quantity'];
  $products_qty_box_status = $product_info->fields['products_qty_box_status'];
  $products_quantity_order_max = $product_info->fields['products_quantity_order_max'];
  $products_quantity_order_min = $product_info->fields['products_quantity_order_min'];
  $products_base_price = $currencies->display_price($product_info->fields['products_price'], zen_get_tax_rate($product_info->fields['products_tax_class_id']));
  $product_is_free = $product_info->fields['product_is_free'];
  $products_tax_class_id = $product_info->fields['products_tax_class_id'];
  $module_show_categories = PRODUCT_INFO_CATEGORIES;
  $module_next_previous = PRODUCT_INFO_PREVIOUS_NEXT;
  $products_id_current = (int)$_GET['products_id'];
  $products_discount_type = $product_info->fields['products_discount_type'];
  $products_discount_type_from = $product_info->fields['products_discount_type_from'];
/**
 * Load product-type-specific main_template_vars
 */
  $prod_type_specific_vars_info = DIR_WS_MODULES . 'pages/' . $current_page_base . '/main_template_vars_product_type.php';
  if (file_exists($prod_type_specific_vars_info)) {
    include_once($prod_type_specific_vars_info);
  }
  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_PRODUCT_TYPE_VARS_PRODUCT_INFO');

// build show flags from product type layout settings
/*
  $flag_show_product_info_starting_at = zen_get_show_product_switch($_GET['products_id'], 'starting_at');
  $flag_show_product_info_model = zen_get_show_product_switch($_GET['products_id'], 'model');
  $flag_show_product_info_weight = zen_get_show_product_switch($_GET['products_id'], 'weight');
  $flag_show_product_info_quantity = zen_get_show_product_switch($_GET['products_id'], 'quantity');
  $flag_show_product_info_manufacturer = zen_get_show_product_switch($_GET['products_id'], 'manufacturer');
  $flag_show_product_info_in_cart_qty = zen_get_show_product_switch($_GET['products_id'], 'in_cart_qty');
  $flag_show_product_info_tell_a_friend = zen_get_show_product_switch($_GET['products_id'], 'tell_a_friend');
  $flag_show_product_info_reviews = zen_get_show_product_switch($_GET['products_id'], 'reviews');
  $flag_show_product_info_reviews_count = zen_get_show_product_switch($_GET['products_id'], 'reviews_count');
  $flag_show_product_info_date_available = zen_get_show_product_switch($_GET['products_id'], 'date_available');
  $flag_show_product_info_date_added = zen_get_show_product_switch($_GET['products_id'], 'date_added');
  $flag_show_product_info_url = zen_get_show_product_switch($_GET['products_id'], 'url');
  $flag_show_product_info_additional_images = zen_get_show_product_switch($_GET['products_id'], 'additional_images');
  $flag_show_product_info_free_shipping = zen_get_show_product_switch($_GET['products_id'], 'always_free_shipping_image_switch');
  */
  
  $flag_show_product_info_starting_at = 1;
  $flag_show_product_info_model = 1;
  $flag_show_product_info_weight = 1;
  $flag_show_product_info_quantity = 1;
  $flag_show_product_info_manufacturer = 1;
  $flag_show_product_info_in_cart_qty = 1;
  $flag_show_product_info_tell_a_friend = 1;
  $flag_show_product_info_reviews = 1;
  $flag_show_product_info_reviews_count = 1;
  $flag_show_product_info_date_available = 1;
  $flag_show_product_info_date_added = 1;
  $flag_show_product_info_url = 1;
  $flag_show_product_info_additional_images = 1;
  $flag_show_product_info_free_shipping = 0;
  
  $display_qty = (($cancel_btn_update && $flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? PRODUCTS_ORDER_QTY_TEXT_IN_CART . '<font color="#ff0000" id="qty_in_cart">' . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</font>' : '<br />');
  $page_name="product_listing";
  $page_type=7;
  //cancel btn_update button
  $cancel_btn_update = 1;
//  if (!$cancel_btn_update && $_SESSION['cart']->in_cart($_GET['products_id'])){
//  	$procuct_qty = $_SESSION['cart']->get_quantity($_GET['products_id']);
//  	$bool_in_cart = 1;
//  	$btn_class = 'btn_update';
//  	$btn_text = TEXT_UPDATE;
//  }else{
  	$procuct_qty = 1;
  	$bool_in_cart = 0;
  	$btn_class = 'btn_addcart';
    if ($products_quantity > 0) {
      $btn_text = TEXT_CART_ADD_TO_CART;
    }else{
      $btn_text = TEXT_BACKORDER;
    }
  	
//  }
  if ($products_qty_box_status == 0) {
  	$the_button = '';
  } else {
  	$the_button = '<ul class="product_info_qty_input list"><li>';
  	$the_button .= '<div><div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
  	$the_button .= 'QTY: <input type="number" min="1" max="99999" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" id="'.$page_name.'_'.$_GET['products_id'].'" name="cart_quantity" orig_value="' . ($bool_in_cart ? $procuct_qty : $product_info->fields['products_quantity_order_min']) . '" value="'.($bool_in_cart ? $procuct_qty : $products_quantity_order_min).'" class="inputbg addcart_qty_input"/>' .'&nbsp;&nbsp;&nbsp;' . zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . ' ' . $display_qty . ' ' . ($product_info->fields['products_limit_stock'] == 1 ? ('<br><div>' . sprintf(TEXT_STOCK_HAVE_LIMIT,$products_quantity)) : '') . '</div><input type="hidden" id="MDO_'.$_GET['products_id'].'"  value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $_GET['products_id'] . '" value="'.$procuct_qty.'" />';
  	$the_button .= '<div class="btn_cart_wish"><div><a rel="nofollow" class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" href="javascript:void(0);" id="submitp_' . $product_info->fields['products_id'] . '" name="submitp_' .  $product_info->fields['products_id'] . '" onclick="Addtocart_list('.$product_info->fields['products_id'].','.$page_type.',this); return false;">'. ($bool_in_cart ? TEXT_UPDATE : $btn_text) .'</a></div>';
  	$the_button .= '<div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div><div class="clearfix behind_add"></div></div>';
  	$the_button .= '<div style="position:relative;display: inline-block;"><a rel="nofollow" class="text btn_addwishlist" href="javascript:void(0);" id="wishlist_' . $product_info->fields['products_id'] . '" name="wishlist_' . $product_info->fields['products_id'] . '" onclick="beforeAddtowishlist(' . $product_info->fields['products_id'] . ','.$page_type.'); return false;">' . IMAGE_BUTTON_ADD_WISHLIST . '</a>';
  	$the_button .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
  	
  	if ($wish_add_num > 0){
  		$the_button .= '<div class="wishlist_num">'.sprintf(TEXT_SHOW_WISHLIST_NUM , $wish_add_num) . '</div><div class="clearfix"></div></div>';
  	}else{
  		$the_button .= '<div class="clearfix"></div></div>';
  	}
  	$the_button .= '</li></ul>';
  }
  $display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
  if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
  	$customer_info = zen_get_customer_info($_SESSION['customer_id']);
  	$customer_email = $customer_info['email'];
  }else{
  	$customer_email = '';
  }

  $promotion_info = get_product_promotion_info($_GET['products_id']);
  if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0 ) {
    $promotion_has_max_num = $promotion_info['pp_max_num_per_order'];
  }else{
    $promotion_has_max_num = 0;
  }

  $is_silver_flag = false;
  $check_silver = $db->Execute("select property_group_id from ".TABLE_PRODUCTS_TO_PROPERTY." where product_id='".(int)$_GET['products_id']."' and property_id='117' limit 1");
  if($check_silver->RecordCount()>0){
  	$is_silver_flag = true;
  }
  $is_swarovski_flag = $product_info->fields['master_categories_id'] == 2441;
  require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCTS_QUANTITY_DISCOUNTS));
  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_EXTRA_PRODUCT_INFO');

  require ($template->get_template_dir($tpl_page_body,DIR_WS_TEMPLATE, $current_page_base,'templates'). $tpl_page_body);

  //require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ALSO_PURCHASED_PRODUCTS));

  // This should be last line of the script:
  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_INFO');
?>