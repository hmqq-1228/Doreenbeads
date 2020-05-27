<?php
/**
 * header_php.php
 * 查找现产品和bestseller产品
 * 各找出300个排在最前面的产品
 */

  $zco_notifier->notify('NOTIFY_HEADER_START_FIND_PROD');
  
  $show_new_products = false;
  $show_bestseller_products = false;
  if (isset($_GET['action']) && $_GET['action'] == 'new'){
  	$show_new_products = true;
  	
  	$catg_name = trim($_POST['catg_name']);
  	$prod_num = trim($_POST['prod_num']);
  	$bg_select = ((int)trim($_POST['bg_select']) - 1);
  	
  	$bg_img_array = array('bg_1.jpg','bg_2.jpg','bg_3.jpg','bg_4.jpg','bg_5.jpg','bg_6.jpg');
  	
  	$find_new_prod_query = "Select p.products_image, p.products_model
  							  From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES_DESCRIPTION . " cd 
  							 Where cd.categories_name like '%" . $catg_name . "%'
  							   And cd.categories_id = p2c.categories_id
  							   And p2c.products_id = p.products_id
  							   And p.products_status = 1
  							   And p.products_quantity > 0
  						  Order By p.products_date_added Desc
  						     Limit 0, " . (int)$prod_num;
  	$find_new_prod = $db->Execute($find_new_prod_query);

  	$find_new_prod_array = array();
  	$row = 0;
  	$col = 0;
  	if ($find_new_prod->RecordCount() > 0){
  		while (!$find_new_prod->EOF){
  			$find_new_prod_array[$row][$col] = array('image' => $find_new_prod->fields['products_image'],
  										   			 'model' => $find_new_prod->fields['products_model']);
  			$col++;
  			if ($col > 5){
  				$col = 0;
  				$row++;
  			}
  			$find_new_prod->MoveNext();		
  		}
  	}
  } elseif (isset($_GET['action']) && $_GET['action'] == 'bestseller'){
  	$show_bestseller_products = true;
  	
  	$month = date('m');
  	$year = date('Y');
  	$start_month_day = date('Y-m-d', mktime(0, 0, 0, ($month - 1), 1, $year));
  	$end_month_day = date('Y-m-d', mktime(0, 0, 0, $month, 0, $year));

  	$prev_month_order_query = "Select orders_id 
  	                             From " . TABLE_ORDERS . "
  	                            Where date_purchased >= '" . $start_month_day . "'
  	                              And date_purchased <= '" . $end_month_day . "'";
  	$prev_month_order = $db->Execute($prev_month_order_query);
  	
  	$list_order_id = '';
  	if ($prev_month_order->RecordCount() > 0){
  		while (!$prev_month_order->EOF){
  			$list_order_id .= $prev_month_order->fields['orders_id'] . ', ';
  			$prev_month_order->MoveNext();
  		}
  	}
  	$list_order_id = substr($list_order_id, 0, -2);

  	$bestseller_prod_query = "Select count(op.products_id) as order_num, p.products_image, p.products_model
  								   From " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p
  								  Where op.orders_id in (" . $list_order_id . ")
  								    And op.products_id = p.products_id
  							   Group By op.products_id
  							   Order By order_num Desc
  							      Limit 0, 96";
  	$bestseller_prod = $db->Execute($bestseller_prod_query);
  	
  	$bestseller_prod_array = array();
  	$row = 0;
  	$col = 0;
  	while (!$bestseller_prod->EOF){
  		$bestseller_prod_array[$row][$col] = array('order_num' => (100 + (int)$bestseller_prod->fields['order_num']),
  												   'image' => $bestseller_prod->fields['products_image'],
  												   'model' => $bestseller_prod->fields['products_model']);
  		$col++;
  		if ($col > 5){
  			$col = 0;
  			$row++;
  		}
  		$bestseller_prod->MoveNext();
  	}
  }
  
  $zco_notifier->notify('NOTIFY_HEADER_END_FIND_PROD');
?>