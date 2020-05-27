<?php




//$sale_maker_query="select distinct sale_categories_selected , categories_name from ".TABLE_SALEMAKER_SALES." ss, ".TABLE_CATEGORIES_DESCRIPTION." cd
//where cd.categories_id =ss.sale_categories_selected  and cd.language_id= ".$_SESSION['languages_id']." and ss.sale_status=1  ";
//echo $sale_maker_query;

//$sale_maker_query="select p.master_categories_id,cd.categories_name  from ".TABLE_SALEMAKER_SALES." ss,".TABLE_PRODUCTS_TO_CATEGORIES." ptc, ".TABLE_PRODUCTS." p,".TABLE_CATEGORIES_DESCRIPTION." cd
//where  ss.sale_status=1 and ss.sale_categories_selected = ptc.categories_id and ptc.products_id=p.products_id and p.products_status=1 and p.products_quantity>0
// and cd.categories_id=p.master_categories_id and cd.language_id=".$_SESSION['languages_id']." group by p.master_categories_id ";

$sale_maker_query="select c.categories_id,cd.categories_name from ".TABLE_CATEGORIES_DESCRIPTION."  cd , ".TABLE_CATEGORIES." c where 
cd.categories_id=c.categories_id and c.parent_id=".$master_category_id." and c.categories_status=1 and cd.language_id=".$_SESSION['languages_id']." order by c.sort_order  
";
//echo $sale_maker_query;exit;
$sale_maker=$db->Execute($sale_maker_query);
//if($sale_maker->RecordCount()>0){
//	while(!$sale_maker->EOF){
//		print_r($sale_maker->fields);
//		$sale_maker->MoveNext();
//	}
//}
//exit;
//$category_string='';

if($sale_maker->RecordCount()>0){
//	$num=0;
//	while(!$sale_maker->EOF){
//		$num++;
//		if($num==$sale_maker->RecordCount()){
//		$category_string.=$sale_maker->fields['sale_categories_selected'];	
//		}else{
//		$category_string.=$sale_maker->fields['sale_categories_selected'].',';	
//		}
//		$sale_maker->MoveNext();
//	}
	
//$category_array=array_unique(explode(',', $category_string));

$list_num=MAX_DISPLAY_CLEARANCE_PRODUCTS;
$num_columns=SHOW_PRODUCT_INFO_COLUMNS_CLEARANCE_PRODUCTS;
$category_content=array();

while(!$sale_maker->EOF){
	
	
	
	//zen_get_subcategories(&$subcategories_array[$key],$val);
	//$subcategories_array[$key][]=$val;
	//$catids = "(".implode($subcategories_array[$key],',').")";
	//$get_category_name_query="select categories_name from ".TABLE_CATEGORIES_DESCRIPTION." where language_id=".$_SESSION['languages_id']." and categories_id=".$val." ";
//	$get_products_query="select  sum(bs_products_quantity) sum,p.products_id , products_name,p.products_image,p.products_model,p.products_weight from ".TABLE_PRODUCTS." p left join ".TABLE_BEST_SELLER." bs on bs.bs_products_id=p.products_id  left join ".TABLE_PRODUCTS_TO_CATEGORIES." ptc on ptc.products_id=p.products_id left join ".TABLE_PRODUCTS_DESCRIPTION." pd on pd.products_id=p.products_id  where   p.products_status=1    
//	  and  pd.language_id=".$_SESSION['languages_id']." and ptc.categories_id = ".$sale_maker->fields['categories_id']." group by p.products_id  order by 
//	sum ";
	
	$get_products_query="select  p.products_id , products_name,p.products_image,p.products_model,p.products_weight, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight from ".TABLE_PRODUCTS." p  left join ".TABLE_PRODUCTS_DESCRIPTION." pd on pd.products_id=p.products_id , ".TABLE_CLEARANCE_SHOW_PRODUCTS. " cp where   p.products_status=1 and  p.products_model= cp.clearance_products_model and  pd.language_id=".$_SESSION['languages_id']." and  clearance_category_id =".$sale_maker->fields['categories_id']."  ";
	//$get_category_name=$db->Execute($get_category_name_query);
	//echo $get_products_query;
	$get_products = $db->ExecuteRandomMulti($get_products_query,$list_num);
	
	
	
	if($get_products->RecordCount()>0){
		
	if ($get_products->RecordCount() < $num_columns) {
    $col_width = floor(100/$get_products->RecordCount());
  } else {
    $col_width = floor(100/$num_columns);
  }
		$category_title=$sale_maker->fields['categories_name'].' '.TEXT_CLEARANCE;
			
		$row = 0;
		
		$col = 0;
		
		$list_box_contents = array();
		//$num=0;
		while(!$get_products->EOF){
			//$in_clearance=false;
//			$check_clearance_sql="select categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." ptc where products_id=".$get_products->fields['products_id']." and categories_id <> ".$sale_maker->fields['categories_id']." ";
//			$check_clearance=$db->Execute($check_clearance_sql);
//			$check_clearance_arr=array('774','775','776');
//			if($check_clearance->RecordCount()>0){
//				while(!$check_clearance->EOF){
//					if(in_array($check_clearance->fields['categories_id'], $check_clearance_arr)){
//						$in_clearance=true;
//						break;
//					}
//					$check_clearance->MoveNext();
//				}
//			}
			//if($in_clearance){
		$page_name = "featured_products";
		$page_type = 5;
		$save_is_true=1; 
		$products_price = zen_get_products_display_price($get_products->fields['products_id']);
		
		if($_SESSION['cart']->in_cart($get_products->fields['products_id'])){		//if item already in cart
    		$procuct_qty = $_SESSION['cart']->get_quantity($get_products->fields['products_id']);
    		$bool_in_cart = 1;
    	}else {
    		$procuct_qty = 0;
    		$bool_in_cart = 0;
    	}
		
	   $add_to_cart_text = TEXT_ADD_WORDS.' <input type="text" id="' .$page_name.'_'. $get_products->fields['products_id'] . '" name="products_id[' . $get_products->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $get_products->fields['products_quantity_order_min']).'" size="4" /><input type="hidden" id="MDO_' . $get_products->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $get_products->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />' . zen_image_submit('button_quick_add_to_cart.jpg', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $get_products->fields['products_id'] . '" onclick="Addtocart('.$get_products->fields['products_id'].','.$page_type.'); return false;" name="submitp_' .  $get_products->fields['products_id'] . '"') . '<br /><script type="text/javascript">document.write(\'' . zen_image_submit('button_in_wishlist_green.gif', TEXT_ADD_SELECTED_TO_WISHLIST, 'class="addwishlistbutton" id="wishlist_' . $get_products->fields['products_id'] . '" onclick="Addtowishlist(' . $get_products->fields['products_id'] . ','.$page_type.'); return false;"') . '\')</script><noscript><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $get_products->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', 'wishlist') . '</a></noscript>';
	    
    	
		$list_box_contents[$row][$col] = array(
		'width'=>$col_width.'%',
		'product_id'=>$get_products->fields['products_id'],
	    'text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $get_products->fields['products_id']) . '" target="_blank">' . zen_image_quick_view(DIR_WS_IMAGES . $get_products->fields['products_image'], $get_products->fields['products_name'] . '<br />' . '<span style="color:blue;">'.TEXT_WEIGHT_WORDS.' ' . $get_products->fields['products_weight'] . '&nbsp;&nbsp;' . TEXT_GRAMS . '<br />' . TEXT_PRICE_WORDS.': </span>' . zen_display_products_quantity_discounts($get_products->fields['products_id']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, '1') . '</a><br /><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $get_products->fields['products_id']) . '" target="_blank">' . TEXT_MODEL . ':' . $get_products->fields['products_model'] . '</a><br />' . $products_price. '<br />' . $add_to_cart_text);
		$col ++;
	if ($col > ($num_columns-1)) {
      $col = 0;
      $row ++;
    }	
			//}
		
			
			
			$get_products->MoveNextRandom();
		}
		$category_content[$category_title.'---'.$sale_maker->fields['categories_id']]=$list_box_contents;
	}
	
	
	$sale_maker->MoveNext();
}

}


