<div class="listmiancont">
<?php
if ($products_new_split->number_of_rows > 0) {
	?>
	<dl class="productlist_title">
		<dd class="productimgtit">Product Image</dd>
		<dt class="productItemtit">Item Name</dt>
		<dt class="productpricetit">Price</dt>
	</dl>
   <?php
		$products_new = $db->Execute ( $products_new_split->sql_query );
		while (!$products_new->EOF) {
		// add by zale 2011-10-17    	
    	$page_name = "product_listing";
		$page_type = 4;
    	
    	if($_SESSION['cart']->in_cart($products_new->fields['products_id'])){		//if item already in cart
    		$procuct_qty = $_SESSION['cart']->get_quantity($products_new->fields['products_id']);
    		$bool_in_cart = 1;
    	}else {
    		$procuct_qty = 0;
    		$bool_in_cart = 0;
    	}
    	//eof
		
		$display_products_image = '<a  href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $products_new->fields['products_id']) . '"><img src="includes/templates/cherry_zen/images/loading2.gif" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_new->fields['products_image'], 130, 130) . '" width="110" height="110" class="lazy" id="anchor' . $products_new->fields['products_id'] . '"></a>';
		
		$display_products_name = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_new->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_new->fields['products_id']) . '"><strong>' . $products_new->fields['products_name'] . '</strong></a>';
		
		if ($products_new->fields['products_discount_type'] == '0') {
			$products_price = zen_get_products_display_price($products_new->fields['products_id']);
		} else {
			$products_price = zen_display_products_quantity_discount($products_new->fields['products_id']);
		}
		$display_products_price = $products_price;
		$display_products_weight = $products_new->fields['products_weight'] . TEXT_SHIPPING_WEIGHT;
		
		if ($products_new->fields['products_qty_box_status'] == 0) {
			$lc_button = '<p class="productadd"><a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_new->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a></p>';
		} else {
			$lc_button = '<p class="productadd">Add:<input type="text" id="' . $page_name  .'_' . $products_new->fields['products_id'] . '" name="products_id[' . $products_new->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $products_new->fields['products_quantity_order_min']) . '" class="addinput" size="6"/><input type="hidden" id="MDO_' . $products_new->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $products_new->fields['products_id'] . '" value="'.$procuct_qty.'" /></p>';
		
			$lc_button .= '<p class="addbtn">' . zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $products_new->fields['products_id'] . '" name="submitp_' .  $products_new->fields['products_id'] . '" onclick="Addtocart('.$products_new->fields['products_id'].','.$page_type.'); return false;" name="submitp_' . $products_new->fields['products_id'] . '" class="addcartbtn"') . '</p>';
		}
		$the_button = $lc_button;
		$products_link = '<a href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
		$display_products_button = zen_get_buy_now_button($products_new->fields['products_id'], $the_button, $products_link) . '<p style="text-align:center;">'.zen_get_products_quantity_min_units_display($products_new->fields['products_id']).'</p>';
		if ($current_page != FILENAME_ADVANCED_SEARCH_RESULT){
			$display_products_button .= '<script type="text/javascript">document.write(\'<p class="addwishlist">' . zen_image_submit('button_in_wishlist_green.gif', 'wishlist', 'class="addwishlistbutton" id="wishlist_' . $products_new->fields['products_id'] . '" name="wishlist_' . $products_new->fields['products_id'] . '" onclick="Addtowishlist(' . $products_new->fields['products_id'] . ','.$page_type.'); return false;"') . '</p>\')</script>' . "\n";
			$display_products_button .= '<noscript><div style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $products_new->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist') . '</a></div></noscript>';
		}
		$display_products_date_added = TEXT_DATE_ADDED . ' ' . zen_date_long($products_new->fields['products_date_added']);
	?>
   	<dl class="productlist_cont">
		     <dd class="productimg"><?php echo $display_products_image;?></dd>
			 <dt class="productItem">
               <div class="proimgdetail">
                  <span class="arrowimg"></span>
                  <p><img></p>
               </div>
			   <p class="productdes"><?php echo $display_products_name;?></p>
			   <?php echo $display_products_price;?>
			   <p>Part No.:<?php echo $products_new->fields['products_model'];?><br /><?php echo $display_products_date_added;?></p>
			 </dt>
			 <dt class="productprice">
			   <p class="productweight">Weight: <?php echo $display_products_weight;?></p>
			   <?php echo $display_products_button;?>
			 </dt>
	</dl>
	<dl id="<?php echo $page_name . $products_new->fields['products_id'];?>"></dl>
	<?php
	$products_new->MoveNext();
		}	
}else{
	echo TEXT_NO_NEW_PRODUCTS;
}
?>   
</div>