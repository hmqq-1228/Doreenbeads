<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_reviews_default.php 4852 2006-10-28 06:47:45Z drbyte $
 */
?>
<div class="centerColumn" id="reviewsDefault">
<div style="padding-bottom:10px;">

<div class="forward">
<div style="text-align:center;"><?php echo '<a href="' . zen_href_link('product_info', zen_get_all_get_params(array('reviews_id'))) . '">' . zen_image_button(BUTTON_IMAGE_GOTO_PROD_DETAILS , BUTTON_GOTO_PROD_DETAILS_ALT) . '</a>'; ?></div>
</div>
<br class="clearBoth">

<?php
  if (zen_not_null($products_image)) {
  /**
   * require the image display code
   */
?>
<div id="productReviewsDefaultProductImage"><?php require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?></div>
<?php
  }
?>
 <?php
// base price
  if ($show_onetime_charges_description == 'true') {
    $one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
  } else {
    $one_time = '';
  }
  $ls_price = $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') 
  	. zen_get_products_display_price((int)$_GET['products_id']);
  if (strpos($ls_price, '</span><span class="productPriceDiscount">')) {
  	$ls_price = str_replace('</span><span class="productPriceDiscount">',
  		 '</span><span class="productPriceDiscountUnit">&nbsp;&nbsp;&nbsp;&nbsp;per Packet</span><span class="productPriceDiscount">', $ls_price);
  } else {
  	$ls_price = $ls_price . '<span class="productPriceDiscountUnit">&nbsp;&nbsp;&nbsp;&nbsp;per Packet</span>';
  }
//  echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$_GET['products_id']);
?>

<div id="rightFloat">
<div style="padding-top:8px;"><?php echo '<h1>'.'<a href="' . zen_href_link('product_info', zen_get_all_get_params(array('reviews_id'))) . '">'  . $products_name . '</a></h1>'; ?></div>
<div><h2 class="productGeneral" id="productPrices">
Price: <?php echo $ls_price; ?></h2></div>
  <!--bof Product details list  -->
  <b>
  <ul id="productDetailsList">
    <?php 
       echo  '<li>' . TEXT_PRODUCT_MODEL . $products_model . '</li>' . "\n"; 	
    ?> 
    <?php
       echo  '<li>' . TEXT_PRODUCT_WEIGHT .  $products_weight . TEXT_PRODUCT_WEIGHT_UNIT . '</li>' . "\n"; 
    ?>
  </ul></b><br /><br />
  <?php
  echo zen_display_products_quantity_discounts($_GET['products_id']);
   ?>

<br class="clearBoth" />
<div id="cartAdd">
<?php
	$page_name="succs_";
	$page_type=7;
	if ($_SESSION['cart']->get_quantity($_GET['products_id'])){
		$procuct_qty = $_SESSION['cart']->get_quantity($_GET['products_id']);
		$bool_in_cart = 1;
	}else{
		$procuct_qty = 0;
    	$bool_in_cart = 0;
	}
        // more info in place of buy now
        echo zen_draw_form('cart_quantity', zen_href_link('product_info', zen_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'enctype="multipart/form-data"') . "\n";
        
        $the_button = PRODUCTS_ORDER_QTY_TEXT . '<input type="text" id="'.$page_name.'_'.$_GET['products_id'].'" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])+5) . '" maxlength="6" size="2" /><input type="hidden" id="MDO_'.$_GET['products_id'].'"  value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $_GET['products_id'] . '" value="'.$procuct_qty.'" />' . zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . '' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . '<br />' . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT,'id="submitp_' . $_GET['products_id'] . '" onclick="Addtocart(' . $_GET['products_id'] . ','.$page_type.'); return false;"');
        $display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
        echo $display_button;
      ?>
      </div>
  </form>
   <!-- zale 2011-10-10 adjust the position of four buttons-->  

<div id="friendReview">

	<div id="addtowishlist"><?php echo '<a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $_GET['products_id']) . '">' . zen_image_button('button_add_to_wishlist.gif', 'add to wishlist', 'id="wishlist_' . $_GET['products_id'] . '" onclick="Addtowishlist(' . $_GET['products_id'] . ','.$page_type.'); return false;"') . '</a>'; ?></div>
	
	<div id=productquestion><a style="cursor:pointer" onclick="popUpProductQuestion('productquestion.php?pid=<?php echo $_GET['products_id'];?>')"><?php echo zen_image_button('button_ask_a_question.gif','ask a question')?></a></div>
	  

	  
	<div id="productReviewLink"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(array('reviews_id'))) . '#reviewsWritemodule' . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?></div>

</div>

<!-- eof adjust the position of four buttons -->
  </div>
</div>
<br class="clearBoth" />
<br />
 <div id="succs_<?php echo $_GET['products_id'];?>" class="messageStackSuccess larger" style="display:none;"></div>
<?php
  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="navSplitPagesResult_top">
		<?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL); ?>
	</td>
    <td class="navSplitPagesLinks_top">
		<?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?>
	</td>
  </tr>
</table>
</div>
<!--
<div id="productReviewsDefaultListingTopNumber" class="navSplitPagesResult"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>

<div id="productReviewsDefaultListingTopLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
-->
<?php
    }
    foreach ($reviewsArray as $reviews) {
?>
<div style="margin-top:8px;border-bottom:1px solid #CCCCCC;padding-bottom:8px;">

<div class="rating"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews['reviewsRating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviewsRating'])), sprintf(TEXT_OF_5_STARS, $reviews['reviewsRating']); ?></div>
<div class="productReviewsDefaultReviewer bold"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, zen_date_short($reviews['dateAdded'])); ?>&nbsp; by &nbsp;<?php echo $reviews['customersName']; ?></div>

<div><?php echo $reviews['reviewsText'] . ($reviews['reviews_reply_text'] != '' ? '<br /><font color="#FF0000"><strong>Reply by Doreenbeads: </strong>' . $reviews['reviews_reply_text'] . '</font>' :'');?></div>
</div>
<?php
    }
?>
<?php
  } else {
?>
<hr />
<div id="productReviewsDefaultNoReviews" class="content"><?php echo TEXT_NO_REVIEWS . (REVIEWS_APPROVAL == '1' ? '<br />' . TEXT_APPROVAL_REQUIRED: ''); ?></div>
<br class="clearBoth" />
<?php
  }

  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="">
		<?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL); ?>
	</td>
    <td class="">
		<?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?>
	</td>
  </tr>
</table>
</div>
<!--
<div id="productReviewsDefaultListingBottomNumber" class="navSplitPagesResult"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>
<div id="productReviewsDefaultListingBottomLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
-->
<?php
  }
?>
	<!--jessa 2010-07-30-->
    <div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(array('reviews_id'))) . '#reviewsWritemodule' . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?></div>
	<!--eof jessa 2010-07-30-->
</div>
