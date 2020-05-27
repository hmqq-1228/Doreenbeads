<?php
/** 
 * tpl_modules_quick_browse_display.php
 * modified lvxiaoyong 20130802
 */
	if($products_new_split->number_of_rows > 0 || $listing_split->number_of_rows > 0) {
		echo '<ul class="gallery">';
		foreach($show_products_content as $pro_array){
			echo '<li>'.$pro_array['image'].$pro_array['name'].$pro_array['price'].$pro_array['cart'].'</li>';
		}
		echo '</ul>';
	}else{
		echo 'There are no products to list in this category.';
	}
?>
