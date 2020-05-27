<?php

$page_name = "product_gallery";
$page_type = 1;

$product_info_list = array();
$split_page_link_info = '';
$split_page_count_info = '';

if ($products_new_split->number_of_rows > 0) {
	$is_products_listing=true;
    $rows = 0;
    $column = 0;
    $customer_basket_products = zen_get_customer_basket();
    
    if(sizeof($product_res) > 0){
	    $products_id_str = implode(',', $product_res);
	    $product_info_pre = array();
	    $products_quantity_array = array();
	    
	    $products_info_query = $db->Execute("select p.products_id,p.products_model, p.products_image, p.products_weight,p.products_limit_stock,p.product_is_call, p.products_type,
								 	p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, p.products_qty_box_status , p.products_date_added,p.products_status
		       						from ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id
		       						where pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
		       						and p.products_id in (".$products_id_str.")");
	    
	    if($products_info_query->RecordCount() > 0){
		    while(!$products_info_query->EOF){
		    	$product_info_pre[$products_info_query->fields['products_id']] = $products_info_query->fields;
		    	
		    	$products_info_query->MoveNext();
		    }
	    }
	    
	    $products_quantity_query = $db->Execute("select products_id, products_quantity
                    from " . TABLE_PRODUCTS_STOCK . "
                    where products_id in (" . $products_id_str . ")");
	    
	    if($products_quantity_query->RecordCount() > 0){
	    	while(!$products_quantity_query->EOF){
	    		$products_quantity_array[$products_quantity_query->fields['products_id']] = $products_quantity_query->fields['products_quantity'];
	    		
	    		$products_quantity_query->MoveNext();
	    	}
	    }
	    
	    foreach($product_res as $prod_val){
			$products_id = $prod_val;
			
			$listing = $product_info_pre[$products_id];
			
			if (sizeof($listing) == 0) {
				continue;
			}
			$listing['products_quantity'] = $products_quantity_array[$products_id];
	
			if (isset($customer_basket_products[$products_id])) {  //if item already in cart
	            $procuct_qty = $customer_basket_products[$products_id];
	            $bool_in_cart = 1;
	        } else {
	            $procuct_qty = 0;
	            $bool_in_cart = 0;
	        }
	        
			$link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing['products_id']);
			
			$imgsrc = HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($listing['products_image'],"310","310");
			$pro_array['image'] = '<a href="' . $link . '" class="dlgallery-img lazy"><img src="' . $imgsrc.'" alt="'. zen_output_string($listing['products_name']) .'" width="143" height="143"></a>';	
			/*other package size check WSL*/
			$other_package_products_array = get_products_package_id_by_products_id($products_id);
			if (sizeof($other_package_products_array) > 0) {
				$pro_array['image'] .= '<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id).'#other_package_size_products'.'" style="display:block;bottom:8px;text-decoration:underline;text-align:center;">'.TEXT_OTHER_PACKAGE_SIZE.'</a>';
			}
			/*end*/
			$pro_array['name'] = '<a class="dlgallery-text" href="'.$link.'">'.zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($listing['products_name']) ), 35 )).'</a>';
			$pro_array['price'] = zen_get_products_display_price_new($listing['products_id'], 'mobile_gallery');
			//*正常列表页也显示WSL*/
	        //if($_GET['pn']=='promotion'){
			    $discount_amount = zen_show_discount_amount($products_id);
			    if($discount_amount)
			        $pro_array['discount'] = '<div class="floatprice"><span>'.$discount_amount.'%<br/>off</span></div>';
			    else $pro_array['discount']='';
			/* }else{
			    $pro_array['discount']='';
			} */
			
			$the_button = zen_get_qty_input_and_button_gallery($listing, $bool_in_cart, $procuct_qty, $page_type);
					
			$pro_array['cart'] = $the_button;
			
			$product_info = $listing;
			$product_info['discount_amount'] = $discount_amount;
			$product_info['show_name'] = zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($listing['products_name']) ), 80 ));
			$product_info['is_in_cart'] = $bool_in_cart;
			$product_info['cart_qty'] = $procuct_qty;
			$product_info['link'] = $link;
			$product_info['main_image_src'] = $imgsrc;
			$product_info['other_package_products'] = $other_package_products_array;
			$product_info['price_html'] = $pro_array['price'];
			
			$product_info_list[] = $product_info;
			$list_box_contents_property[] = $pro_array;
	    }
	}
    $error_categories = false;
    
    $top_content = '
      <div class="listcontent-tit">
    	<ul >
           <li>'.$products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT).'</li>
           <li>'.$display_sort_content.'</li>
     	</ul>
     	<div class="refinebtn">
  	 	<a href="javascript:void(0);" class="refine-by-btn" id="refine-bybtn">'.TEXT_REFINE_BY_WORDS.'<ins></ins></a>
     	</div>
  
  	  </div>
  	  <div class="listcontent-head">
    	<h1 class="gallery-change"><a href="'.zen_href_link($current_page_base,zen_get_all_get_params(array('action')).'action=normal', 'NONSSL').'" class="list-link"></a><a href="javascript:void(0);" class="gallery-link"></a></h1>    	
    	<div>'
    	  .$products_new_split->display_links_mobile(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))).'
    	</div>
  	 </div>
     <div class="listcontent-detail">
     <h1 class="line gallery"><span class="top"></span><span class="bot"></span></h1>';
    
    $bottom_content = '<div class="listcontent-head">
      <h1>'.$products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT).'</h1>
      <div>'.$products_new_split->display_links_mobile(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))).'</div>
    </div>';
    
    $split_page_count_info = $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT);
    $split_page_link_info = $products_new_split->display_links_mobile(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
}else{
     $list_box_contents_property = array();
     //$list_box_contents_property[0][] = array('params' => 'class="productListing-data"',
     //   							 'text' => TEXT_NO_PRODUCTS);
     $top_content = TEXT_NO_PRODUCTS;
     $bottom_content = '';
     $error_categories = true;
}


$smarty->assign('current_page',$current_page);
$smarty->assign('split_page_link_info',$split_page_link_info);
$smarty->assign('split_page_count_info',$split_page_count_info);
$smarty->assign('product_info_list',$product_info_list);

$smarty->assign('tabular',$list_box_contents_property);
$smarty->assign('products_top_part',$top_content);
$smarty->assign('products_bottom_part',$bottom_content);

$tpl = DIR_WS_TEMPLATE.'tpl/tpl_index_product_gallery.html';
?>
