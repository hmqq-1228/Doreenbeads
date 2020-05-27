<?php

$page_name = "product_listing";
$page_type = 1;
if ($products_new_split->number_of_rows > 0) {
	$is_products_listing=true;
    $rows = 0;
    $column = 0;
   // $customer_basket_products = zen_get_customer_basket();

    foreach($product_res as $prod_val){
		
		$products_id = $prod_val;
		$listing = $db->Execute("select p.products_id, p.products_model, p.products_image, p.products_weight,p.products_limit_stock,p.product_is_call, p.products_type,
							 	p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, p.products_qty_box_status , p.products_date_added
	       						from ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id
	       						where pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
	       						and p.products_id='".$products_id."'");
		if ($listing->RecordCount() == 0) {
			continue;
		}
		$listing->fields['products_quantity'] = zen_get_products_stock($products_id);
		
		if (isset($customer_basket_products[$products_id])) {  //if item already in cart
            $procuct_qty = $customer_basket_products[$products_id];
            $bool_in_cart = 1;
        } else {
            $procuct_qty = 0;
            $bool_in_cart = 0;
        }
		$link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']);
		
		$imgsrc = HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($listing->fields['products_image'],"130","130");
		$pro_array['image'] = '<a href="' . $link . '" class="dlist-img lazy"><img src="' . $imgsrc.'" alt="'. zen_output_string($listing->fields['products_name']) .'" width="143" height="143"></a>';		
		/*other package size check WSL*/
		$other_package_products_array = get_products_package_id_by_products_id($products_id);
		if (sizeof($other_package_products_array) > 0) {
			$pro_array['image'] .= '<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id).'#other_package_size_products'.'" style="position:absolute;bottom:5px;left:15px;text-decoration:underline;text-align:center;">'.TEXT_OTHER_PACKAGE_SIZE.'</a>';
		}
		/*end*/
		$pro_array['name'] = '<h4><a class="listtext" href="'.$link.'">'.$listing->fields['products_name'].' ['.$listing->fields['products_model'].']</a></h4>';
		$pro_array['model'] = '<p>' . TEXT_MODEL . ': ' . $listing->fields['products_model'].'</p>';
		$pro_array['price'] = '<p class="price">'.zen_get_products_display_price_new($listing->fields['products_id'], 'mobile_list').'</p>';
		
		/*正常列表页也显示WSL*/
		//if($_GET['pn']=='promotion'){
		    $discount_amount = zen_show_discount_amount($products_id);
		    if($discount_amount)
		        $pro_array['discount'] = '<div class="floatprice"><span>'.$discount_amount.'%<br/>off</span></div>';
		    else $pro_array['discount']='';
		/* }else{
		    $pro_array['discount']='';
		} */
		$the_button = zen_get_qty_input_and_button($listing->fields,$page_name,$page_type, $bool_in_cart, $procuct_qty);
				
		$pro_array['cart'] = $the_button;

		$list_box_contents_property[] = $pro_array;
		$listing->MoveNext();
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
    	<h1 class="list-change"><a href="javascript:void(0);" class="list-link"></a><a href="'.zen_href_link($current_page_base,zen_get_all_get_params(array('action')).'action=quick', 'NONSSL').'" class="gallery-link"></a></h1>    	
    	<div>'
    	  .$products_new_split->display_links_mobile(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))).'
    	</div>
  	 </div>
     <div class="listcontent-detail">
      <h1 class="line"><span class="top"></span><span class="bot"></span></h1>';
    
    $bottom_content = '<div class="listcontent-head">
      <h1>'.$products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT).'</h1>
      <div>'.$products_new_split->display_links_mobile(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))).'</div>
    </div>';
    
    
}else{
     $list_box_contents_property = array();
     //$list_box_contents_property[0][] = array('params' => 'class="productListing-data"',
    //    							 'text' => TEXT_NO_PRODUCTS);
     $top_content = TEXT_NO_PRODUCTS;
     $bottom_content = '';
     $error_categories = true;
}


$smarty->assign('tabular',$list_box_contents_property);
$smarty->assign('products_top_part',$top_content);
$smarty->assign('products_bottom_part',$bottom_content);

$tpl = DIR_WS_TEMPLATE.'tpl/tpl_index_product_list.html';
?>
