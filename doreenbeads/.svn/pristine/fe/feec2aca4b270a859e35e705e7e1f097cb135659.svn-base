<?php
/**�����ļ�jessa 
 * quick_browse_display.php
 * 2010-03-02
 */
 
 if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
 }
 
 require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
 
 //��������ļ�����products_all��products_newҳ��Ҫ���в�Ʒ������ѡ��
$solr_str_array = get_listing_display_order($disp_order_default);
$solr_order_str = $solr_str_array['solr_order_str'];
$order_by = $solr_str_array['order_by'];
 
// //����ÿҳ��ʾͼƬ������
// $page_size = 100;
// //��õ�ǰ��ҳ��
// if (isset($_GET['page']) && $_GET['page'] != ''){
// 	$current_page = (int)(trim($_GET['page']));
// }else{
// 	$current_page = 1;
// }
 
 $quick_disp_order = "";
 
 if (isset($_GET['disp_order']) && $_GET['disp_order'] != ''){
 	switch ($_GET['disp_order']){
 		case 3:
 			$quick_disp_order = " Order By p.products_price_sorter, pd.products_name";
 		break;
 		case 4:
 			$quick_disp_order = " Order By p.products_price_sorter DESC, pd.products_name";
 		break;
 		case 5:
 			$quick_disp_order = " Order By p.products_model";
 		break;
 		case 6:
 			$quick_disp_order = " Order By p.products_date_added DESC, pd.products_name";
 		break;
 		case 7:
 			$quick_disp_order = " Order By p.products_date_added, pd.products_name";
 		break;
 		case 9:
 			$quick_disp_order = " order by p.products_ordered DESC, pd.products_name";
 			if($_GET['main_page'] == FILENAME_PRODUCTS_COMMON_LIST && $_GET['pn'] == 'best_seller'){
 				$quick_disp_order = " order by pon.products_order_num DESC, p.products_date_added desc";
 			}
 		break;
 		case 40:
 			$quick_disp_order = " order by p.products_limit_stock DESC, p.products_date_added desc";
 		break;
 		default:
 			$quick_disp_order = " Order By p.products_date_added Desc";
 		break;
 	}
 }else{
 	$quick_disp_order = " Order By pcg_create_date Desc, p.products_date_added Desc";
 }
 echo $_GET['main_page'];die;
 if (isset($_GET['main_page']) && $_GET['main_page'] != ''){
     echo $_GET['main_page'];die;
 	if ($_GET['main_page'] == 'index'){
		$current_categories_id = trim($_GET['cPath']);
		switch (count($cPath_array)){
			case 1:
				$categories_str = 'first_categories_id = ' . (int)$current_category_id . '';
				$categories_filter = ' first_categories_id ';
				break;
			case 2:
				$categories_str = 'second_categories_id = ' . (int)$current_category_id . '';
				$categories_filter = ' second_categories_id ';
				break;
			case 3:
				$categories_str = 'three_categories_id = ' . (int)$current_category_id . '';
				$categories_filter = ' three_categories_id ';
				break;
			case 4:
				$categories_str = 'four_categories_id = ' . (int)$current_category_id . '';
				$categories_filter = ' four_categories_id ';
				break;
			case 5:
				$categories_str = 'five_categories_id = ' . (int)$current_category_id . '';
				$categories_filter = ' five_categories_id ';
				break;
			case 6:
				$categories_str = 'six_categories_id = ' . (int)$current_category_id . '';
				$categories_filter = ' six_categories_id ';
				break;
			default:
				$categories_str = 'p2c.categories_id = ' . (int)$current_category_id . '';
				$categories_filter = 'p2c.categories_id ';
				break;
		}
		$products_query = "select p.products_id, ps.products_quantity, p.products_model, p.products_image, p.products_weight,
								  p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
	       from ".TABLE_PRODUCTS_STOCK." ps, ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id  left join  " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p2c.products_id = p.products_id left join ".TABLE_CATEGORIES." c on ".$categories_filter." = c.categories_id
	       where pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
	        and p.products_id = ps.products_id 
	         and  p.products_status = 1
	         and ".$categories_str." And  c.categories_status = 1 group by p.products_id " . $quick_disp_order;
						   
	} elseif ($_GET['main_page'] == 'products_all'){
		$products_query = "Select distinct p.products_id, ps.products_quantity, p.products_model, p.products_image, p.products_weight,
								  p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight From ".TABLE_PRODUCTS_STOCK." ps, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
						    Where p.products_status = 1
						      And p.products_id = pd.products_id
						       and p.products_id = ps.products_id 
						      " . $quick_disp_order;

//						   
//		$products_count = "Select count( distinct p.products_id) prod_cnt
//						     From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, zen_prod_catg
//						    Where p.products_status = 1 
//						      And p.products_id = pd.products_id
//						      And pcg_name = pd.products_name_without_catg";
						   
	} elseif ($_GET['main_page'] == 'products_new'){
		//jessa 2010-05-07 newproducts��ʾһ�������ڵĲ�Ʒ
		$today_year = date('Y');
		$today_month = date('m');
		$today_day = date('d');
		$today_month_ago = date('Y-m-d', (mktime(0, 0, 0, ($today_month - 1), $today_day, $today_year)));
		//eof jessa 2010-05-07
		$products_query = "Select distinct p.products_id, ps.products_quantity, p.products_model, p.products_image, 
								  p.products_weight, p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight From ".TABLE_PRODUCTS_STOCK." ps, " . TABLE_PRODUCTS . " p, ". TABLE_PRODUCTS_DESCRIPTION . " pd
						    Where p.products_status = 1 
						      And p.products_id = pd.products_id 
						       and p.products_id = ps.products_id 
						      And p.products_date_added >= '" . $today_month_ago . "'
						      And pd.language_id = " . (int)$_SESSION['languages_id'] . "
						      " . $quick_disp_order ;

//		$products_count = "Select count(distinct p.products_id) prod_cnt From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, zen_prod_catg
//						    Where p.products_status = 1 
//						      And p.products_id = pd.products_id 
//						      And p.products_date_added >= '" . $today_month_ago . "'
//						      And pcg_name = pd.products_name_without_catg";
	} elseif ($_GET['main_page'] == 'featured_products'){
		$products_query = "Select p.products_id, p.products_type, pd.products_name, p.products_image, 
								  p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name, 			
								  p.products_model, p.sproducts_quantity, p.products_weight, p.product_is_call,
								  p.master_categories_id, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight From (".TABLE_PRODUCTS_STOCK." ps, " . TABLE_PRODUCTS . " p 
								  Left Join " . TABLE_MANUFACTURERS . " m 
							      on (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                        Left Join " . TABLE_FEATURED . " f on pd.products_id = f.products_id )
                            Where p.products_status = 1 and p.products_id = f.products_id and f.status = 1
                              And p.products_id = pd.products_id 
                               and p.products_id = ps.products_id 
							  And pd.language_id = " . (int)$_SESSION['languages_id'] . $quick_disp_order;
//		$products_count = "Select count(distinct p.products_id) as prod_cnt
//                             From (" . TABLE_PRODUCTS . " p Left Join " . TABLE_MANUFACTURERS . " m 
//							      on (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
//                        Left Join " . TABLE_FEATURED . " f on pd.products_id = f.products_id )
//                            Where p.products_status = 1 and p.products_id = f.products_id and f.status = 1
//                              And p.products_id = pd.products_id 
//							  And pd.language_id = " . (int)$_SESSION['languages_id'];
	} elseif ($_GET['main_page'] == 'products_mixed'){
		$products_query = "SELECT p.products_id, pd.products_name, p.products_image, p.products_price, 
				p.products_date_added,  p.products_model, 
				p.products_quantity, p.products_weight, p.products_discount_type, 
				p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight 
				WHERE p.products_status = 1 
				AND p.products_id = pd.products_id 
				AND is_mixed=1 
				AND pd.language_id = " . (int)$_SESSION['languages_id'] . "  group by p.products_id " . $quick_disp_order ;
	} elseif ($_GET['main_page'] == 'promotion'){
  			$products_query = "SELECT p.products_id, pd.products_name, p.products_image, p.products_price,
                                    p.products_date_added,  p.products_model,
                                    ps.products_quantity, p.products_weight, p.products_discount_type,
                                    p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, p.products_limit_stock
                             FROM ".TABLE_PRODUCTS_STOCK." ps, " . TABLE_PRODUCTS . " p , ".TABLE_PRODUCTS_DESCRIPTION . " pd, ".TABLE_PROMOTION." pm , ".TABLE_PROMOTION_PRODUCTS." pp , ".TABLE_PRODUCTS_TO_CATEGORIES." ptc
                             WHERE p.products_status = 1
                             AND ptc.products_id=p.products_id 
                              and p.products_id = ps.products_id 
                             AND p.products_id = pd.products_id
                             AND pp.pp_products_id=p.products_id
                             AND pp.pp_promotion_id=pm.promotion_id
                             AND pp.pp_is_forbid = 10
                             AND p.master_categories_id=ptc.categories_id
                             AND pm.promotion_status=1
                             AND ptc.first_categories_id <> 718
                             AND pp.pp_promotion_start_time<='".date('Y-m-d H:i:s')."'
                             AND pp.pp_promotion_end_time>'".date('Y-m-d H:i:s')."'
                             ".$refine_by_off.$filter_str."
                             AND pd.language_id = ".$_SESSION['languages_id']." group by p.products_id " . $quick_disp_order;
	}
//	elseif ($_GET['main_page'] == 'products_best_seller'){
//		$audit_month = date('Ym',strtotime('-1 month',time()));
//		$products_query = "SELECT p.products_id, p.products_type, p.products_level, pd.products_name, p.products_image, p.products_price,
//                                    p.products_tax_class_id, p.products_date_added, p.products_model,
//                                    p.products_quantity, p.products_weight, p.product_is_call, p.product_is_free,
//                                    p.product_is_always_free_shipping, p.products_qty_box_status, p.products_discount_type, 
//                                    SUM(bs.bs_products_quantity) AS bpq FROM " . TABLE_BEST_SELLER . " bs 
//                             LEFT JOIN ". TABLE_PRODUCTS ." p ON bs.bs_products_id = p.products_id , " . TABLE_PRODUCTS_DESCRIPTION . " pd
//                             WHERE p.products_status = 1
//							 AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
//                             AND p.products_id = pd.products_id
//                             AND bs.bs_audit_month >= ". $audit_month ."
//                             AND pd.language_id = ".$_SESSION['languages_id'] ." 
//                             GROUP BY p.products_id ". $quick_disp_order ;
//		
////		$products_count = "SELECT count(distinct bs.bs_products_id) as prod_cnt FROM " . TABLE_BEST_SELLER . " bs 
////                             LEFT JOIN ". TABLE_PRODUCTS ." p ON bs.bs_products_id = p.products_id , " . TABLE_PRODUCTS_DESCRIPTION . " pd
////                             WHERE p.products_status = 1
////							 AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
////                             AND p.products_id = pd.products_id
////                             AND bs.bs_audit_month >= ". $audit_month ."
////                             AND pd.language_id = ".$_SESSION['languages_id'] ." 
////                             GROUP BY p.products_id ". $order_by ;
////		
//	}
//	echo $products_query;exit;
//	$check_products_all = $db->Execute($products_query);
//	$check_products_all_num = $db->Execute($products_count);
	



  $number_of_products_per_page = isset($_SESSION['per_page']) ? $_SESSION['per_page'] : 48;	
  $products_new_split = new splitPageResults($products_query, $number_of_products_per_page ,'p.products_id');
//   print_r($check_products_all);exit;
//check to see if we are in normal mode ... not showcase, not maintenance, etc
  $show_submit = zen_run_normal();

// check whether to use multiple-add-to-cart, and whether top or bottom buttons are displayed
  if (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $products_new_split->number_of_rows > 0) {

    // check how many rows
    $check_products_all = $db->Execute($products_new_split->sql_query);
//    print_r($check_products_all);exit;
//    echo $check_products_all->sql_query;exit;
    $row = 0;
	$col = 0;
	$show_products_content = array();
    while (!$check_products_all->EOF) {
    	// add by zale 
		$page_name = "quick_view";
	    $page_type = 8;    
	    if($_SESSION['cart']->in_cart($check_products_all->fields['products_id'])){		//if item already in cart
	    	$procuct_qty = $_SESSION['cart']->get_quantity($check_products_all->fields['products_id']);
	    	$bool_in_cart = 1;
	    }else {
	    	$procuct_qty = 0;
	    	$bool_in_cart = 0;
	    }
	    //eof
		$products_quantity = $check_products_all->fields['products_quantity'];		
		$product_image = '<div class="galleryimg"><p class="galleryimgshow"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $check_products_all->fields['products_id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($check_products_all->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($check_products_all->fields['products_name'])) . '" src="includes/templates/cherry_zen/images/loading2.gif" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($check_products_all->fields['products_image'], 80, 80) . '" class="lazy"></a></p></div>';
		if ($products_quantity > 0){
			$str_input = '<p class="pcenter">Add: <input type="text" id="'.$page_name.'_'.$check_products_all->fields['products_id'].'" name="products_id[' . $check_products_all->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $check_products_all->fields['products_quantity_order_min']).'" size="4" /><input type="hidden" id="MDO_' . $check_products_all->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $check_products_all->fields['products_id'] . '" value="'.$procuct_qty.'" /></p>';
			
			$button = '<p class="pcenter">' . zen_image_submit('button_quick_add_to_cart.jpg', TEXT_CART_ADD_TO_CART, 'id="submitp_' . $check_products_all->fields['products_id'] . '" name="submitp_' .  $check_products_all->fields['products_id'] . '" onclick="Addtocart('.$check_products_all->fields['products_id'].','.$page_type.'); return false;"') . '</p>';
			$button .= '<p class="pcenter">' . zen_image_submit('button_in_wishlist_green.gif', 'wishlist', 'id="wishlist_'.$check_products_all->fields['products_id'].'" class="addwishlistbutton" onclick="Addtowishlist(' . $check_products_all->fields['products_id'] . ','.$page_type.'); return false;"') . '</p>';
			
			$show_products_content[$row][$col] = array('params' => 'width="20%" style="text-align:center; padding:10px 5px;"',
														'product_id'=>$check_products_all->fields['products_id'],
													   'text' => $product_image . '<p class="pcenter"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $check_products_all->fields['products_id']) . '">' . TEXT_MODEL . ':' . $check_products_all->fields['products_model'] . '</a><br />' . zen_get_products_display_price($check_products_all->fields['products_id']) . '</p>' . $str_input . $button);
			$col++;
		}else{
			$button = '<p class="pcenter">' . zen_get_buy_now_button_quick_view($check_products_all->fields['products_id']) . '</p>';
			$button .= '<p class="pcenter">' . zen_image_submit('button_in_wishlist_green.gif', 'wishlist', 'id="wishlist_'.$check_products_all->fields['products_id'].'" class="addwishlistbutton" onclick="Addtowishlist(' . $check_products_all->fields['products_id'] . ','.$page_type.'); return false;"') . '</p>';
			$show_products_content[$row][$col] = array('params' => 'width="20%" style="text-align:center; padding:10px 5px;"',
														'product_id'=>$check_products_all->fields['products_id'],
													   'text' => $product_image . '<p class="pcenter"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $check_products_all->fields['products_id']) . '">' . TEXT_MODEL . ':' . $check_products_all->fields['products_model'] . '</a><br />' . zen_get_products_display_price($check_products_all->fields['products_id']) . '</p>' . $button);
			$col++;
			//jessa 2010-09-01 wishlist��ť������
		}
		if ($col > 4){
			$col = 0;
			$row++;
		}
		$check_products_all->MoveNext();
	}
  }	
 }
?>
