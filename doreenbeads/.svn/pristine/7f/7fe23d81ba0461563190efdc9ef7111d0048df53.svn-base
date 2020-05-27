<?php
/**
 * Page Template - Featured Products listing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_featured_products_default.php 2603 2005-12-19 20:22:08Z wilt $
 */
?>
<div class="centerColumn" id="allProductsDefault">

<h1 id="featuredDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<div id="allproducts">
<div style="padding:0px 10px;">
 <?php
  /**
   * require code to display the list-display-order dropdown
   */
//  require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php'); 
?>
</div>

<?php
//if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
//	require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
//} else {
  if (PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $featured_products_split->number_of_rows > 0) {

?>
<div id="allproduct_content">
<div style="padding:0px 10px;">
<?php
    if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
    }
  }
?>
<?php
// only show button when there is something to submit
  if ($show_top_submit_button == true) {
?>
<div>
<?php //require($template->get_template_dir('/tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php'); ?>


</div>
<?php
  } // end show top button
?>

<?php

  if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div style="clear:both;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="pagelistlinks">
  <tr>
    <td  align="left" style="padding:5px 0px; border-bottom:1px solid #CCCCCC;">
		<?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
	</td>
    <td  align="right" style="padding:5px 0px; border-bottom:1px solid #CCCCCC;">
		<?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?>
			
	</td>
  </tr><!--
  <tr>  
  	<td colspan="2">
		<table width="100%"><tr>
			<td width="200">
				<?php //require($template->get_template_dir('tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php');?>
			</td>	
			<td  width="230">
				<?php 
				//require_once($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php');
				?>
			</td>
			<td align="right"><?php //echo $featured_products_split->display_jump_page(0, zen_get_all_get_params(array('page', 'info', 'main_page')));?>	
			</td>
		</tr></table>
	</td>
  </tr>
--></table>
</div>
<!--
<div id="featuredProductsListingTopNumber" class="navSplitPagesResult back"><?php //echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS); ?></div>
<div id="featuredProductsListingTopLinks" class="navSplitPagesLinks forward"><?php //echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
-->

<?php
   echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_FEATURED_PRODUCTS, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data" id="addform"');
  }
?>

<?php
/**
 * display the featured products
 */
//echo 'test <br />';
//echo $template->get_template_dir('/tpl_modules_products_featured_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates') . '<br />';
//echo $template->get_template_dir('/tpl_modules_products_featured_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_featured_listing.php <br />';
require($template->get_template_dir('/tpl_modules_products_featured_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_featured_listing.php'); ?>
<?php
  if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="pagelistlinks">
  <tr>
    <td width="50%" align="left" style="padding:5px 0px; border-bottom:1px solid #CCCCCC;">
		<?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
	</td>
    <td width="50%" align="right" style="padding:5px 0px; border-bottom:1px solid #CCCCCC;">
		<?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?>
			
	</td>
  </tr>
  <!--<tr>  
  	<td width="50%" style="padding:5px 0px; border-bottom:1px solid #CCCCCC;">
  	<?php //require($template->get_template_dir('tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php');?>
	</td>	
  	<td width="50%" align="right" style="padding:5px 0px; border-bottom:1px solid #CCCCCC;"><?php //echo $featured_products_split->display_jump_page(1, zen_get_all_get_params(array('page', 'info', 'main_page')));?>	</td>
  </tr>
--></table>
</div>
<!--
<div id="featuredProductsListingBottomNumber" class="navSplitPagesResult back"><?php //echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS); ?></div>
<div id="featuredProductsListingBottomLinks" class="navSplitPagesLinks forward"><?php //echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
-->
<?php
  }
?>

<?php
  if ($show_bottom_submit_button == true) {
// only show button when there is something to submit
?>
  <div class="all_products_submit"><?php //echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"'); ?></div>
<?php
  } // end show bottom button
?>
<?php
// only end form if form is created
    if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
?>
</form>
<?php } // end if form is made ?>
</div>
</div>
<?php //} ?>
</div>
</div>