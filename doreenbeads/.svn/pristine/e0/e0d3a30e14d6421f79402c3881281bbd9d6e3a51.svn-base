<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_products_all_default.php 2603 2005-12-19 20:22:08Z wilt $
 */
?>
<br />
<div class="centerColumn" id="allProductsDefault">
<!--jessa 2009-12-21 �ж��Ƿ�Ҫ���bestsellers-->
<h1 id="allProductsDefaultHeading">
	<?php
		if ($_GET['disp_order'] == 9){
			echo 'Bestsellers In All Products';
		}else{
    		echo HEADING_TITLE;
		}
    ?>
</h1>
<!--eof jessa 2009-12-21-->
<div id="allproducts">

<?php
	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
		require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
	}else{
?>

<?php
  if (($products_all_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div style="clear:both;">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="navSplitPagesResult_top">
	  	<?php 
			if ($products_all_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) == ''){
				echo "&nbsp;";
			}
			else{
				echo $products_all_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
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
	  if (TEXT_RESULT_PAGE . ' ' . $products_all_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) == ''){
	  	echo "&nbsp;";
	  }
	  else{
	  	echo TEXT_RESULT_PAGE . ' ' . $products_all_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
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
require($template->get_template_dir('/tpl_modules_products_all_listing_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_all_listing_new.php'); ?>

<?php
  if (($products_all_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="navSplitPagesResult_bott">
	  	<?php 
			if ($products_all_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) == ''){
				echo "&nbsp;";
			}
			else{
				echo $products_all_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
			}
		?>
	  </td>
      <td class="navSplitPagesLinks_bott perpage">
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
	  if (TEXT_RESULT_PAGE . ' ' . $products_all_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) == ''){
	  	echo "&nbsp;";
	  }
	  else{
	  	echo TEXT_RESULT_PAGE . ' ' . $products_all_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
	  }
  ?>
  </div>
  <br class="clearBoth">

</div>
<?php
  }
}
?>
</div>
</div>