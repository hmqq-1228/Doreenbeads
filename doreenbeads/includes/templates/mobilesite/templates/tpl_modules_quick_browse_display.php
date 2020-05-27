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
	if($_GET['main_page'] == 'advanced_search_result')
 	include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
}
?>
<div class="listcontent">
    <ul class="listcontent-tit">
	    <li><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT); ?></li>
	    <li><select><option>Sort by</option><option>Price &uarr;</option><option>Price &darr;</option><option>New-Old</option><option>Old-New</option></select></li>
	    <li><a href="javascript:void(0);" class="refine-by-btn" id="refine-bybtn">Refine by<ins></ins></a></li>
  	</ul>
    <div class="listcontent-head">
	    <h1><a href="<?php echo zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action')).'action=quick', 'NONSSL'); ?>" class="list-link"></a><a href="<?php echo zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action')).'action=quick', 'NONSSL'); ?>" class="gallery-link"></a></h1>
	    <div>
		    <?php 
			    if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
			    	echo $listing_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
			    }
		    ?> 
	    </div>
    </div>       
    <div class="listcontent-detail">
        <h1 class="line"><span class="top"></span><span class="bot"></span></h1>           
           <div class="dlgallery">
               <ul>
                  <li class="dlgallery_left">
                    <a href="" class="dlgallery-img"><img src="images/productimg.jpg" alt="product"/></a>
                    <a href="" class="dlgallery-text">Cloisonne Spacer Beads Rectangle Multicolor 2 Holes 19x13mm, 5PCs</a>
                    <p class="oldprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="nowprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="cartcont"><input type="text"/><a href="" class="addcart-icon"></a><a href="" class="addcollect-icon"></a></p> 
                  </li>   
                  <li class="dlgallery_right">
                    <a href="" class="dlgallery-img"><img src="images/productimg1.jpg" alt="product"/></a>
                    <a href="" class="dlgallery-text">Cloisonne Spacer Beads Rectangle Multicolor 2 Holes 19x13mm, 5PCs</a>
                    <p class="oldprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="nowprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="cartcont"><input type="text"/><a href="" class="addcart-icon"></a><a href="" class="addcollect-icon"></a></p> 
                  </li>   
               </ul>
               <ul>
                  <li class="dlgallery_left">
                    <a href="" class="dlgallery-img"><img src="images/productimg.jpg" alt="product"/></a>
                    <a href="" class="dlgallery-text">Cloisonne Spacer Beads Rectangle Multicolor 2 Holes 19x13mm, 5PCs</a>
                    <p class="oldprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="nowprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="cartcont"><input type="text"/><a href="" class="addcart-icon"></a><a href="" class="addcollect-icon"></a></p> 
                  </li>
                  <li class="dlgallery_right">
                    <a href="" class="dlgallery-img"><img src="images/productimg1.jpg" alt="product"/></a>
                    <a href="" class="dlgallery-text">Cloisonne Spacer Beads Rectangle Multicolor 2 Holes 19x13mm, 5PCs</a>
                    <p class="oldprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="nowprice">US$ 2.13 ~ US$ 4.26</p>
                    <p class="cartcont"><a href="" class="preorder-icon"><ins>+</ins>Preorder</a><a href="" class="addcollect-icon"></a></p> 
                    <p class="cartcont-restock"><a href="" class="restock-btn">Restock Notification</a></p> 
                  </li>  
               </ul>
                <div class="clearfix"></div>
           </div>
  
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
<div class="listcontent">
  	<ul class="listcontent-tit">
	    <li><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW_CONTENT); ?></li>
	    <li><select><option>Sort by</option><option>Price &uarr;</option><option>Price &darr;</option><option>New-Old</option><option>Old-New</option></select></li>
	    <li><a href="javascript:void(0);" class="refine-by-btn" id="refine-bybtn">Refine by<ins></ins></a></li>
  	</ul>
    <div class="listcontent-head">
	    <h1><a href="<?php echo zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action')).'action=quick', 'NONSSL'); ?>" class="list-link"></a><a href="<?php echo zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action')).'action=quick', 'NONSSL'); ?>" class="gallery-link"></a></h1>
	    <div>
		    <?php 
			    if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
			    	echo $listing_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));
			    }
		    ?> 
	    </div>
    </div>
    <div class="listcontent-detail">
	    <h1 class="line"><span class="top"></span><span class="bot"></span></h1>
	    <?php require($template->get_template_dir('tpl_tabular_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_tabular_display.php');?>   
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

