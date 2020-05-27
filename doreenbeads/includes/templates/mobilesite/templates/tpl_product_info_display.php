<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 16242 2010-05-08 16:05:40Z ajeh $
 */
 //require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
?>
<div class="detailcontent">
	<div class="detail_info">
		<p class="product-descript"><?php echo $products_name; ?></p>
        <p class="product-price">
        <!-- <strong>US$ 1.89 ~ US$ 3.78 </strong>per Pack -->
        	<?php
			// base price
			  if ($show_onetime_charges_description == 'true') {
			    $one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
			  } else {
			    $one_time = '';
			  }
			  echo "<strong>".$one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price_new((int)$_GET['products_id'],'product_info')."</strong>";
			?>
        </p>
        <?php if (zen_not_null($products_image)) {  require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); }  ?>	
		<?php if ($products_discount_type != 0) { require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); }?>
		<?php		
			if($_SESSION['cart']->in_cart($_GET['products_id'])){		
		    	$procuct_qty = $_SESSION['cart']->get_quantity($_GET['products_id']);
		    	$bool_in_cart = 1;
		    }else {
		    	$procuct_qty = 0;
		    	$bool_in_cart = 0;
		    }
		    $input_num=($bool_in_cart?$procuct_qty:1);
		
		    //$display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p><span class="cartNumHas">' . PRODUCTS_ORDER_QTY_TEXT_IN_CART .''. $_SESSION['cart']->get_quantity($_GET['products_id']) . '</span></p>' : '<p><span class="cartNumHas"></span></p>');
		            if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
		              // hide the quantity box and default to 1
		             $button_img = $bool_in_cart ? 'but_update.png' : 'but_submit.png';
		              // show the quantity box
		    			$the_qty =   '<input type="text" id="product_listing_'.(int)$_GET['products_id'].'" name="products_id[\''.(int)$_GET['products_id'].'\']" value="' . $input_num . '" maxlength="6" size="4" class="addToCart"/>'.zen_draw_hidden_field('products_id',$bool_in_cart,'id="MDO_'.(int)$_GET['products_id'].'"') . zen_draw_hidden_field('products_in_cart', ($bool_in_cart ? $procuct_qty : 0),'id="incart_'.(int)$_GET['products_id'].'"');
		    			$the_button =  '<a id="submitp_' . (int)$_GET['products_id'] . '" href="javascript:void(0)" onclick="Addtocart(' .(int)$_GET['products_id'] . ',\''.$_SESSION['language'].'\'); return false;" class="addtocart-btn"><strong></strong>Add To Cart</a>';
				 } else {
		            	$button_img = $bool_in_cart ? 'but_update.png' : 'but_submit.png';
		              // show the quantity box
		            	$the_qty =   '<input type="text" id="product_listing_'.(int)$_GET['products_id'].'" name="products_id[\''.(int)$_GET['products_id'].'\']" value="' . $input_num . '" maxlength="6" size="4" class="addToCart"/>'.zen_draw_hidden_field('products_id',$bool_in_cart,'id="MDO_'.(int)$_GET['products_id'].'"').zen_draw_hidden_field('products_id',$bool_in_cart,'id="MDO_'.(int)$_GET['products_id'].'"') . zen_draw_hidden_field('products_in_cart', ($bool_in_cart ? $procuct_qty : 0),'id="incart_'.(int)$_GET['products_id'].'"');
		    			$the_button =  '<a id="submitp_' . (int)$_GET['products_id'] . '" href="javascript:void(0)" onclick="Addtocart(' .(int)$_GET['products_id'] . ',\''.$_SESSION['language'].'\'); return false;" class="addtocart-btn"><strong></strong>Add To Cart</a>';
		            }
		    //$display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
		?>
		<div class="detail-input"><?php echo PRODUCTS_ORDER_QTY_TEXT;?>:<a href="">-</a><?php echo $the_qty;?><a href="">+</a></div>
        <div class="detailproduct-btn"><?php echo $the_button;?><a href="" class="addwishilist-btn"><strong></strong>Add to Wishlist</a></div>
		<?php if ($products_description != '') {
			$products_description = str_replace('width="473"', 'width="270"', $products_description);
			$products_description = str_replace('width="109"', 'width="55"', $products_description);
			$products_description = str_replace('height="31"', 'height="18"', $products_description);
			$products_description = str_replace('height="30"', 'height="18"', $products_description);
			$products_description = str_replace('height="55"', 'height="18"', $products_description);
		?>
		<div class="detail-descript">
		<?php if ( (($flag_show_product_info_model == 1 and $products_model != '') or ($flag_show_product_info_weight == 1 and $products_weight !=0) or ($flag_show_product_info_quantity == 1) or ($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name))) ) { ?>
			<?php echo (($flag_show_product_info_model == 1 and $products_model !='') ? '<p>' . TEXT_PRODUCT_MODEL . $products_model . '</p>' : '') ; ?>
  			<?php echo (($flag_show_product_info_weight == 1 and $products_weight !=0) ? '<p>' . TEXT_PRODUCT_WEIGHT .  $products_weight . TEXT_PRODUCT_WEIGHT_UNIT . '</p>'  : ''); ?>
  			<?php echo (($flag_show_product_info_quantity == 1) ? '<p>' . $products_quantity . TEXT_PRODUCT_QUANTITY . '</p>'  : '') ; ?>
  			<?php echo (($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name)) ? '<p>' . TEXT_PRODUCT_MANUFACTURER . $manufacturers_name . '</p>' : '') ; ?>
<!-- 			<p>Transaction: 3 Times</p> -->
<!-- 			<p>Shipping Weight: 90 grams</p> -->
  		<?php }?>
			<?php echo stripslashes($products_description); ?>
		</div>
		<ul class="detail-descript-list">
           <li><a href="">Write a Review (2)<span class="goldstar"></span><span class="goldstar"></span><span class="goldstar"></span><span class="goldstar"></span><span class="greystar"></span></a></li>
           <li><a href="">Ask  a question <ins></ins></a></li>
         </ul>
		<?php } ?>
		<!--bof matching products module add by jessa-->
		<!--begin_center_matching_products-->
		  <?php require($template->get_template_dir('tpl_modules_matching_products.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_matching_products.php'); ?>
		<!--end_center_matching_products-->
		  <!--eof matching products module add by jessa-->
		  <!--bof also like products module add by robbie-->
		<!--begin_center_also_like_products-->
		  <?php require($template->get_template_dir('tpl_modules_also_like_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_like_products.php');?>
		<!--end_center_also_like_products-->
		  <!--eof also like products module-->
		  <!--bof also purchased products module-->
		<!--begin_center_also_purchased_products-->
		  <?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
	</div>
</div>
<div class="centerColumn" id="productGeneral">
<!--bof Form start-->
<?php echo zen_draw_form('cart_quantity_form', zen_href_link('product_info', zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
<!--eof Form start-->
<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>
<!--bof Product Price block -->
<h2 id="productPrices" class="productGeneral">
</h2>
<!--eof Product Price block -->

<!--bof Main Product Image -->

<!--eof Main Product Image-->
<br class="clearBoth" />
<!--bof Additional Product Images -->
<?php
/**
 * display the products additional images
 */
  require($template->get_template_dir('/tpl_modules_additional_images.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images.php'); ?>
<!--eof Additional Product Images -->

<!--bof free ship icon  -->
<?php if(zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) { ?>
<div id="freeShippingIcon"><?php echo TEXT_PRODUCT_FREE_SHIPPING_ICON; ?></div>
<?php } ?>
<!--eof free ship icon  -->


<!--bof Attributes Module -->
<?php
  if ($pr_attr->fields['total'] > 0) {
?>
<?php
/**
 * display the product atributes
 */
  require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); ?>
<?php
  }
?>
<!--eof Attributes Module -->

<!--bof Add to Cart Box -->

<!--eof Add to Cart Box-->
</form>

<?php
  if ($flag_show_product_info_reviews == 1) {
    // if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
    if ($reviews->fields['count'] > 0 ) { ?>
<div id="productReviewLink" class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_REVIEWS, BUTTON_REVIEWS_ALT) . '</a>'; ?></div>
<br class="clearBoth" />
<p class="reviewCount"><?php echo ($flag_show_product_info_reviews_count == 1 ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : ''); ?></p>
<?php } else { ?>
<div id="productReviewLink" class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array())) . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?></div>
<br class="clearBoth" />
<?php
  }
}
?>
<!--eof Reviews button and count -->


<!--bof Product date added/available-->
<?php
  if ($products_date_available > date('Y-m-d H:i:s')) {
    if ($flag_show_product_info_date_available == 1) {
?>
  <p id="productDateAvailable" class="productGeneral centeredContent"><?php echo sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)); ?></p>
<?php
    }
  } else {
    if ($flag_show_product_info_date_added == 1) {
?>
      <p id="productDateAdded" class="productGeneral centeredContent"><?php echo sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)); ?></p>
<?php
    } // $flag_show_product_info_date_added
  }
?>
<!--eof Product date added/available -->

<!--bof also purchased products module-->
<?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
<!--eof also purchased products module-->

<!--bof Form close-->
<!--bof Form close-->
</div>