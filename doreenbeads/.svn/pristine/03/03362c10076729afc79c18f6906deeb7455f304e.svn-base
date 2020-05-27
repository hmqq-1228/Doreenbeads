<div class="centerColumn" id="allProductsDefault">
	<h1 id="mixedDefaultHeading"><?php echo HEADING_TITLE; ?></h1>
	<div id="allproducts">

<?php
if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
	require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
} else {
  if ($products_mixed_split->number_of_rows > 0) {

?>
<div id="allproduct_content">
<div style="padding:0px 10px;">
<?php
  }
?>

<?php

  if ($products_mixed_split->number_of_rows > 0) {
?>

<div style="clear:both;">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="navSplitPagesResult_top">
	  	<?php 
			if ($products_mixed_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) == ''){
				echo "&nbsp;";
			}
			else{
				echo $products_mixed_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
			}
		?>
	  </td>
      <td class="navSplitPagesLinks_top perpage">
	  	<?php 
	  	require($template->get_template_dir('/tpl_modules_listing_per_page.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_per_page.php');
		?>
		</td>
    </tr>
  </table>
  <?php require($template->get_template_dir('tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php');?>
  <?php require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php');?>
  <div style="padding:10px 0;float:right">
  <?php 
	  if (TEXT_RESULT_PAGE . ' ' . $products_mixed_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) == ''){
	  	echo "&nbsp;";
	  }
	  else{
	  	echo TEXT_RESULT_PAGE . ' ' . $products_mixed_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
	  }
  ?>
  </div>  
  <br class="clearBoth"> <hr>
</div>
<?php
  }
?>

<?php
/**
 * display the new products
 */
require($template->get_template_dir('/tpl_modules_products_mixed_listing.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_mixed_listing.php'); ?>

<?php
  if (($products_mixed_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div style="clear:both;border-top:1px solid #CCCCCC">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="navSplitPagesResult_top">
	  	<?php 
			if ($products_mixed_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) == ''){
				echo "&nbsp;";
			}
			else{
				echo $products_mixed_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
			}
		?>
	  </td>
      <td class="navSplitPagesLinks_top perpage">
	  	<?php 
	  	require($template->get_template_dir('/tpl_modules_listing_per_page.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_per_page.php');
		?>
		</td>
    </tr>
  </table>
  <?php require($template->get_template_dir('tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php');?>
  <?php require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php');?>
  <div style="padding:10px 0;float:right">
  <?php 
	  if (TEXT_RESULT_PAGE . ' ' . $products_mixed_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) == ''){
	  	echo "&nbsp;";
	  }
	  else{
	  	echo TEXT_RESULT_PAGE . ' ' . $products_mixed_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
	  }
  ?>
  </div>  
  <br class="clearBoth">
</div>
<?php
  }
?>
<?php 
if ($products_mixed_split->number_of_rows > 0) {

	?>
</div>
</div>
<?php
  }
?>
<?php } ?>
</div>
</div>
