<?php
	require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  
	if (!isset($_SESSION['customer_id']) || (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == '')){
		$_SESSION ['navigation']->set_snapshot ();
		zen_redirect(zen_href_link(FILENAME_LOGIN));
	}
	/*$breadcrumb->add(NAVBAR_TITLE1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
	$breadcrumb->add(NAVBAR_TITLE2);*/
	$action = (isset($_GET['action']) && zen_not_null($_GET['action'])) ? $_GET['action'] : '';
	$page = isset ( $_GET ['page'] ) && ( int ) $_GET ['page'] > 0 ? ( int ) $_GET ['page'] : '1';
	switch ($action){
		case 'remove':
			$product_id = $_GET['product_id'];
			$wishlist_sql = 'select wl_products_id from t_wishlist where wl_products_id = ' .  (int)$product_id. ' and wl_customers_id = ' . (int)$_SESSION['customer_id'] . ' limit 1';
			$wishlist_query = $db->Execute($wishlist_sql);
			if($wishlist_query ->RecordCount() > 0){
				$db->Execute("delete from ".TABLE_WISH." where wl_products_id = " . (int)$product_id . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
				update_products_add_wishlist(intval($product_id) , 'remove');
				$_SESSION['count_wishlist'] = zen_get_wishlist_item_count($_SESSION['customer_id']);
				$messageStack->add('account', TEXT_UPDATE_SUCCESSFULLY, 'success');
				zen_redirect(zen_href_link('wishlist', zen_get_all_get_params(array('action','product_id'))));
			}
			break;

		case 'addwishlist':
			$products_id = $_GET['pid'];
			$customer_id = $_SESSION['customer_id'];
			$wishlist_check = $db->Execute("select wl_id from ".TABLE_WISH." where wl_products_id = " . (int)$products_id . " and wl_customers_id = " . (int)$customer_id);
			if ($wishlist_check->RecordCount() == 0){
				$db->Execute("insert into ".TABLE_WISH." (wl_products_id, wl_customers_id, wl_date_added) values (" . $products_id . ", " . $customer_id . ", '" . date('Y-m-d H:i:s') . "')");
				update_products_add_wishlist(intval($product_id));
			}
			zen_redirect(zen_href_link(FILENAME_WISHLIST));
			break;
	}
	//$page_type =5 ;
	$check_invalid = $db->Execute("select w.wl_id, p.products_id, p.products_model, p.products_image, pd.products_name  from ".TABLE_WISH." w inner join ".TABLE_PRODUCTS." p on w.wl_products_id=p.products_id inner join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id=pd.products_id
							where w.wl_customers_id = " . $_SESSION['customer_id'] . " and (p.products_status !=1 or exists (select products_id from " . TABLE_MY_PRODUCTS . " mp where w.wl_products_id=mp.products_id)) and pd.language_id = " . $_SESSION['languages_id'] . "");
	$products_notify_array = $products_notify_products_id = $products_notify_also_like_array = array();
	if($check_invalid->RecordCount()>0){
		while(!$check_invalid->EOF){
			$check_invalid->fields['products_image'] = HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($check_invalid->fields['products_image'], 80, 80);
			$check_invalid->fields['products_name'] = getstrbylength(htmlspecialchars(zen_clean_html($check_invalid->fields['products_name'])), 60);
			array_push($products_notify_array, $check_invalid->fields);
			array_push($products_notify_products_id, $check_invalid->fields['products_id']);
			$check_invalid->MoveNext();
		}
	}

	$invalid_items_count = sizeof($products_notify_array);
	$products_notify_array = array_slice($products_notify_array, 0, 5);

	if(!empty($products_notify_products_id)) {
	  $products_notify_also_like_array = get_products_without_catg_relation($products_notify_products_id);
	}
	
	
	foreach ($products_notify_array as $products_notify_key => $products_notify_value) {
		$products_notify_array[$products_notify_key]['also_like_str'] = "";
		if(isset($products_notify_also_like_array[$products_notify_value['products_id']])) {
			$products_notify_array[$products_notify_key]['also_like_str'] = $also_like_str = "<a href='" . zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=similar&products_id=' . $products_notify_value['products_id']) . "' target='_blank'>" . TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS . "</a>&nbsp;&nbsp;";
		}
		//$_SESSION['cart_products_down_errors'] .= '<span class="fontblue">[' . $products_notify_value['products_model'] . ']</span> ' . $products_notify_value['products_name'] . '<br>';;
	}

	$sort = " order by w.wl_date_added desc";
	$wishlist_query = "select p.products_id, p.products_model, p.products_image, p.products_price, p.products_weight, p.is_sold_out,
                            pd.products_name, w.wl_id, w.wl_product_num, w.wl_date_added,p.products_status, p.products_stocking_days,
                            p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight,ps.products_quantity 
  					   from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, ".TABLE_WISH." w, ".TABLE_PRODUCTS_STOCK." ps 
  					  where w.wl_customers_id = " . (int)$_SESSION['customer_id'] . "
  					  	and pd.language_id = " . $_SESSION['languages_id'] . "
  					    and w.wl_products_id = p.products_id 
  					    and ps.products_id = p.products_id 
  					    and p.products_id = pd.products_id and p.products_status=1 and not exists(select products_id from " . TABLE_MY_PRODUCTS . " mp where w.wl_products_id=mp.products_id)"  . $sort;

	$wishlist_split = new splitPageResults($wishlist_query, MAX_DISPLAY_ORDER_HISTORY,'p.products_id');

	$current_page = $wishlist_split->current_page_number;

	$wishlist = $db->Execute($wishlist_split->sql_query);
	$message ['wishlist_result_page'] = $wishlist_split->display_links_mobile_for_shoppingcart(MAX_DISPLAY_ORDER_HISTORY, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
	$message ['wishlist_result_count'] =  $wishlist_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT);
	
	$wishlist_total = $wishlist_split->number_of_rows;

	if ($wishlist->RecordCount() > 0){
				
		$wishlist_array = array();
		while (!$wishlist->EOF){
			$content='';
			
			$products_link = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$wishlist->fields['products_id']);
			
			//$the_button = zen_get_qty_input_and_button_detail($wishlist->fields, $bool_in_cart, $procuct_qty);
			if ($_SESSION['cart']->in_cart($wishlist->fields['products_id'])){
				$procuct_qty = $_SESSION['cart']->get_quantity($wishlist->fields['products_id']);
				$bool_in_cart = 1;
			} else {
				$procuct_qty = 1;
				$bool_in_cart = 0;
			}
			//$procuct_qty=($bool_in_cart?$procuct_qty:1);	
			//$sold_out = $wishlist->fields['is_sold_out']==0 ? true : false;	
			/*if($wishlist->fields['products_quantity'] > 0 || ($wishlist->fields['products_quantity'] <=0 && $wishlist->fields['is_sold_out'] == 0)){
				
				$the_qty = '<span class="box"><input type="text" maxlength="5"  class="addToCart" id="product_listing_' . $wishlist->fields['products_id']. '" name="products_id[' . $wishlist->fields['products_id']. ']" value="' . $procuct_qty. '" size="4" /></span>';
				
				$the_qty .= '<input type="hidden" id="MDO_' . $wishlist->fields['products_id'] . '" value="' . $bool_in_cart . '" />
  				<input type="hidden" id="incart_' . $wishlist->fields['products_id'] . '" value="' . ($bool_in_cart ? $procuct_qty : 0) . '" />';
				$products_removed = '<span id="swith_button_' .$wishlist->fields['products_id'] . '" style="display:none; vertical-align:middle; background: none repeat scroll 0% 0% rgb(232, 232, 232); width: 75%; border: 1px solid rgb(211, 211, 211); width:86px; height: 16px; border-radius: 5px; text-align: center; padding:5px; margin-top:-16px; margin-left:4px;">' . TEXT_REMOVED . '</span>';
				if($bool_in_cart){
					$content .= $the_qty.'<a  class="update" id="submitp_' .$wishlist->fields['products_id'] . '" onclick="Addtocart(' .$wishlist->fields['products_id']. ', '.$page_type.',\''. $_SESSION['language'].'\'); return false;" href="javascript:void(0)"></a>' . $products_removed;
				} else {
					$content .= $the_qty.'<a  class="cart" id="submitp_' . $wishlist->fields['products_id'] . '" onclick="Addtocart(' . $wishlist->fields['products_id'] . ','.$page_type.', \''. $_SESSION['language'].'\'); return false;" href="javascript:void(0)"></a>' . $products_removed;
				}
				$content.='<a href="'.HTTP_SERVER.'/index.php?main_page=wishlist&action=remove&product_id='.$wishlist->fields['products_id'].'&page='.$current_page.'"  class="delete" onclick=" return confirm(\''.TEXT_CONFIRM_DELETE_WORD.'\');"></a>';
				
				if($wishlist->fields['products_quantity'] <= 0) {
					$content .= '<br/>' . TEXT_AVAILABLE_IN715;
				}
				
			}else{
				if($wishlist->fields['is_sold_out'] == 1) {
					$content='<span class="sold" id="wishlist_'.$wishlist->fields['products_id'].'">'.TEXT_SOLD_OUT.'</span>'.'<a href="'.HTTP_SERVER.'/index.php?main_page=wishlist&action=remove&product_id='.$wishlist->fields['products_id'].'&page='.$current_page.'"  class="delete" onclick=" return confirm(\''.TEXT_CONFIRM_DELETE_WORD.'\');"></a></li><li>';
				
					$content.= '<a class="restock-btn" href="javascript:void(0);" onclick="restockNotification(\''.$wishlist->fields['products_id'].'\', \''.$page_type.'\', \''.$_SESSION['language'].'\');">'.TEXT_RESTOCK_NOTIFY.'</a>';
				}	
			}	*/
			$price_area_result = show_products_price_area($wishlist->fields['products_id'], true );
			$wishlist_array[] = array(
				'products_id' => $wishlist->fields['products_id'],
				'products_quantity' => $wishlist->fields['products_quantity'],
				'products_model' => $wishlist->fields['products_model'],
				'products_link' => $products_link,
				'procuct_qty' => $procuct_qty,
				'products_image' => '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($wishlist->fields['products_image'],"130","130").'" alt="'. zen_output_string($listing->fields['products_name']) .'">',
				'products_price' => $price_area_result['price_area'],
				'products_price_promotion' => isset($price_area_result['price_area_promotion']) ? $price_area_result['price_area_promotion'] : '' ,
				'products_price_discount' => zen_show_discount_amount ( $wishlist->fields['products_id'] ) ,
				'products_name' => getstrbylength(htmlspecialchars(zen_clean_html($wishlist->fields['products_name'])), 40),
				'wl_product_num' => $wishlist->fields['wl_product_num'],
				'wl_id' => $wishlist->fields['wl_id'],
				'products_quantity_order_min' => $wishlist->fields['products_quantity_order_min'],
				'date_added' => date('Y-m-d',strtotime($wishlist->fields['wl_date_added'])),				
				'lc_text' => $content,
				'products_stocking_days' => $wishlist->fields['products_stocking_days']
				);
			$wishlist->MoveNext();
		}
		
		/*if(!empty($products_notify_array)) {
      	  $products_notify_str = implode(",", $products_notify_products_id);
	      $products_also_like_sql = "select t1.products_id, count(t1.products_id) count from (select products_id, tag_id from " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " where products_id in(" . $products_notify_str . ")) t1 inner join " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " pnwcr on pnwcr.tag_id=t1.tag_id where exists(select products_id from " . TABLE_PRODUCTS . " p where p.products_id=pnwcr.products_id and products_status=1) group by t1.products_id";
	      $products_also_like_result = $db->Execute($products_also_like_sql);
	      while(!$products_also_like_result->EOF) {
	      	if($products_also_like_result->fields['count'] > 0) {
	      		$products_notify_also_like_array[$products_also_like_result->fields['products_id']] = 1;
	      	}
	      	$products_also_like_result->MoveNext();
	      }
		}*/

		//invalid items fenye
		if ($invalid_items_count > 5) {
			$invalid_items_split = new splitPageResults('', '5', '', '', false, $invalid_items_count);
			$invalid_items_fen_ye = '<div class="page">' . $invalid_items_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params ( array('page', 'info', 'x', 'y', 'main_page') ) ,true) . '</div>';
		}else{
			$invalid_items_fen_ye = '';
		}
		$smarty->assign ( 'invalid_items_fen_ye', $invalid_items_fen_ye );
	}

	$smarty->assign ( 'products_notify_array', $products_notify_array );
	$smarty->assign ( 'message', $message );
	$smarty->assign ( 'page', $page );
	$smarty->assign ( 'wishlist_total', $wishlist_total );
	$smarty->assign ( 'wishArray', $wishlist_array );
?>