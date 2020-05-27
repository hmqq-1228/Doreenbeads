<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_new.<br />
 * Displays listing of New Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_new_listing.php 4629 2006-09-28 15:29:18Z ajeh $
 */
?>
<div class="viewtab">
<?php
  if ($products_new_split->number_of_rows > 0) {
    $products_new = $db->Execute($products_new_split->sql_query);
    $customer_basket_products = zen_get_customer_basket();
    while (!$products_new->EOF) {
    	// add by zale 2011-10-17    	
    	$page_name = "product_listing";
		$page_type = 4;
    	
    	if(isset($customer_basket_products[$products_new->fields['products_id']])){		//if item already in cart
    		$procuct_qty = $customer_basket_products[$products_new->fields['products_id']];
    		$bool_in_cart = 1;
    	}else {
    		$procuct_qty = 0;
    		$bool_in_cart = 0;
    	}
// more info in place of buy now
      if (PRODUCT_NEW_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($products_new->fields['products_id']) == 'Y') {
      	
      } else {
        $link = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_new->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($products_new->fields['products_id']) . str_repeat('', substr(PRODUCT_NEW_BUY_NOW, 3, 1));
      }
?>
		  <dl class="productlist_cont">
          <?php 
          $discount_amount=zen_show_discount_amount($products_new->fields['products_id']);
          $show_discount=$discount_amount?'<div class="discountyellowbg">'.(($_SESSION['languages_id']==4||$_SESSION['languages_id']==2)?'<strong>-'.$discount_amount.'<font>%</font></strong>':'<strong>-'.$discount_amount.'<font>%</font></strong><em></em>').'</div>':'';
          
          $display_products_image = '<a  href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '"><img src="includes/templates/cherry_zen/images/loading2.gif" data-original="'.HTTP_IMG_SERVER.'bmz_cache/'.get_img_size($products_new->fields['products_image'],130,130).'" alt="" width="130" height="130" class="lazy" id="anchor'.$products_new->fields['products_id'].'"></a>';
        
          $display_products_name = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '" title="'.htmlspecialchars(zen_clean_html($products_new->fields['products_name'])).'">' . $products_new->fields['products_name']  . '&nbsp;&nbsp;('.$products_new->fields['products_model'].')</a>';
     
      	if ($products_new->fields['products_discount_type'] == '0') {
			$products_price = '<div class="pro_dis_type0">'.zen_get_products_display_price($products_new->fields['products_id']).'</div>';
		} else {
			$products_price = zen_display_products_quantity_discount($products_new->fields['products_id']);
		} 
		
      	$display_products_model = TEXT_MODEL.':' . $products_new->fields['products_model'] ;
      
        $display_products_weight = TEXT_SHIPPING_WEIGHT_LIST.' '.$products_new->fields['products_weight'] . TEXT_SHIPPING_WEIGHT;
        
        if ($products_new->fields['products_qty_box_status'] == 0) {
        	$lc_button = '<p class="productadd"><a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_new->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a></p>';
        } else {
        	$lc_button = '<p class="productadd">Add:<input type="text" id="' . $page_name  .'_' . $products_new->fields['products_id'] . '" name="products_id[' . $products_new->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $products_new->fields['products_quantity_order_min']) . '" class="addinput" size="6"/><input type="hidden" id="MDO_' . $products_new->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $products_new->fields['products_id'] . '" value="'.$procuct_qty.'" /></p>';
        	
        	$lc_button .= ($products_new->fields['products_limit_stock'] == 1 ? '<span class="text">' . sprintf(TEXT_STOCK_HAVE_LIMIT, $products_new->fields['products_quantity']) . '</span><br>' : '');
        	
        	$lc_button .= '<p class="addbtn">' . zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $products_new->fields['products_id'] . '" name="submitp_' .  $products_new->fields['products_id'] . '" onclick="Addtocart('.$products_new->fields['products_id'].','.$page_type.'); return false;" name="submitp_' . $products_new->fields['products_id'] . '" class="addcartbtn"') . '</p>';
        }
        $the_button = $lc_button;
        $products_link = '<a href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_new->fields['products_id'], $the_button, $products_link) . '<p style="text-align:center;">'.zen_get_products_quantity_min_units_display($products_new->fields['products_id']).'</p>';
        
        
        //$display_products_date_added = TEXT_DATE_ADDED . ' ' . zen_date_long($products_new->fields['products_date_added']);
          ?>
          <dd class="productimg productimg_promotion">
          <?php echo $display_products_image;?>
          </dd>                      
          <dt class="productItem productItem_promotion">
                 <div class="proimgdetail">
                  <span class="arrowimg"></span>
                  <p class="notLoadNow"><img src="includes/templates/cherry_zen/images/loading2.gif"  data-original="<?php echo HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_new->fields['products_image'], 500, 500);?>"></p>
               </div>
			   <p class="productdes"><?php echo $display_products_name;?></p>
			   <div class="display_pro_price">
			   <?php echo $show_discount;?>
			   <?php echo $products_price;?>			    
			   </div>
			   <p>
			   <?php echo $display_products_model;?>
		  	   <span class="shippingWeight"><?php echo $display_products_weight;?></span></p>
			 </dt>
          
          <dt class="productprice productprice_promotion">
          <?php echo $display_products_button;?>
          <p class="addwishlist">
          <?php 
          	echo zen_image_submit('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT, 'class="addwishlistbutton" id="wishlist_' . $products_new->fields['products_id'] . '" onclick="Addtowishlist(' . $products_new->fields['products_id'] . ','.$page_type.'); return false;"');
          ?>
          </p>
          <?php 
          if (zen_get_product_rating($products_new->fields['products_id'],true)) {
          	?>
          	<center>
          	<p class="text"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new->fields['products_id']);?>#reviewsWritemodule"><?php echo TEXT_READ_REVIEW;?></a></p>
          	<p class="text"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new->fields['products_id']);?>#write_review_show_div"><?php echo TEXT_WRITE_A_REVIEW;?></a></p>
          	</center>
		  <?php
          } else {
			?>
          	<center>
          	<p class="text"><?php echo TEXT_BE_THE_FIRST ;?></p>
          	<p class="text"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new->fields['products_id']);?>#write_review_show_div"><?php echo TEXT_WRITE_A_REVIEW;?></a></p>
          	</center>
  		  <?php
			}
          ?>
          </dt>               				               
          </dl>
           <dl id="<?php echo $page_name.$products_new->fields['products_id'];?>" class="messageStackSuccess hideDiv"></dl> 
<?php
      $products_new->MoveNext();
    }
  } else {
 echo TEXT_NO_NEW_PRODUCTS; 
  }
?>
</div>