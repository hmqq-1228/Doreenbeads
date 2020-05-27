<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_products_new_default.php 2677 2005-12-24 22:30:12Z birdbrain $
 */
?>
<div class="centerColumn" id="allProductsDefault">

<h1 id="allProductsDefaultHeading"><?php echo HEADING_TITLE; ?></h1>


<div id="allproducts">
<div style="padding:0px 10px;">
<?php
/**
 * display the product order dropdown
 */
	require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php'); 
?>
</div>
<?php
	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
		require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
	} else {
  		if (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $products_new_split->number_of_rows > 0) {
?>
<div id="allproduct_content">
<div style="padding:0px 10px;">
<?php
    if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
      echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_PRODUCTS_NEW, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data"');
    }
  }
?>

<?php
  if ($show_top_submit_button == true) {
// only show when there is something to submit
?>
<div>
	<?php require($template->get_template_dir('/tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php')?>
	<div class="add_to_cart" align="right">
		<?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit1" name="submit1"'); ?>
	</div>
</div>
<?php
  } // top submit button
?>

<?php
  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div style="clear:both;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="navSplitPagesResult_top">
		<?php echo $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL); ?>
	</td>
    <td class="navSplitPagesLinks_top">
		<?php echo TEXT_RESULT_PAGE . ' ' . $products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?>
	</td>
  </tr>
</table>
</div>
<?php
  }
?>

<?php
/**
 * display the new products
 */
require($template->get_template_dir('/tpl_modules_products_new_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_new_listing.php'); ?>

<?php
  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="navSplitPagesResult_bott">
		<?php echo $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL); ?>
	</td>
    <td class="navSplitPagesLinks_bott">
		<?php echo TEXT_RESULT_PAGE . ' ' . $products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?>
	</td>
  </tr>
</table>
</div>
<?php
  }
?>

<?php
  if ($show_bottom_submit_button == true) {
// only show when there is something to submit
?>
  <div class="all_products_submit"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"'); ?></div>
<?php
  }  // bottom submit button
?>

<?php
// only end form if form is created
    if ($show_top_submit_button == true or $show_bottom_submit_button == true) {
?>
</form>
<?php } // end if form is made ?>
</div>
</div>
<?php
	}
?>
</div>
</div>