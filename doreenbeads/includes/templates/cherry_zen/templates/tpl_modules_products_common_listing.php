<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING 04/04/2006
 */
	if($listing_split->number_of_rows > 0){
		echo '<ul class="list">';
		foreach($list_box_contents as $pro_array){
			echo '<li>'.$pro_array['maximage']. $pro_array['image'].'<div class="product_info">'.$pro_array['name']. $pro_array['price']. $pro_array['model'].'</div><div class="product_btn">'.$pro_array['cart'].'</div><div class="clearfix"></div></li>';
		}
		echo '</ul>';
	}else{
		echo TEXT_NO_PRODUCTS;
	}
?>
