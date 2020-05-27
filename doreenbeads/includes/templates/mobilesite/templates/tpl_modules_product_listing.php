<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 */
if($_GET['main_page'] == 'advanced_search_result'){
	include(DIR_WS_MODULES . zen_get_module_directory('advanced_search_listing'));
}else{
	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
 		include(DIR_WS_MODULES . zen_get_module_directory('quick_browse_display'));
	} else {
		include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
	}
}
?>
<div class="listcontent">
  	<ul class="listcontent-tit">
	    <li><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT); ?></li>
	    <li><?php require($template->get_template_dir('tpl_modules_display_sort_number.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_display_sort_number.php');?></li>
	    <li><a href="javascript:void(0);" class="refine-by-btn" id="refine-bybtn">Refine by<ins></ins></a></li>
  	</ul>
    <div class="listcontent-head">
	    <h1><a href="<?php echo zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action')).'action=normal', 'NONSSL'); ?>" class="list-link"></a><a href="<?php echo zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action')).'action=quick', 'NONSSL'); ?>" class="gallery-link"></a></h1>
	    <div>
		    <?php 
			    if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
			    	echo $listing_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
			    }
		    ?> 
	    </div>
    </div>
    <div class="listcontent-detail">
	    <h1 class="line <?php if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){ echo "gallery";}?>"><span class="top"></span><span class="bot"></span></h1>
	    <?php 
		    if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
				require($template->get_template_dir('tpl_quick_browse_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_quick_browse_display.php');
			}else{
		    	require($template->get_template_dir('tpl_tabular_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_tabular_display.php'); 
		    }
	    ?>
	    <div class="listcontent-head">
	      <h1><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT); ?></h1>
	      <div>
		      <?php 
			      if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
			    	  echo $listing_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
			      }
		      ?> 
	      </div>
	    </div>
    </div>
</div>

