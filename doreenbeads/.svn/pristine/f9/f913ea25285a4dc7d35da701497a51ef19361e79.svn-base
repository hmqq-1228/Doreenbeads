<?php
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MATCHING_PRODCUTS));
?>

<?php
 if ($zc_show_matching_products == true){
?>
 <div class="detailcont">
	<?php echo $title;?>
	<ul class="detailitem product_list">
	<?php for ($i = 0; $i < 10; $i++) {?>
	<?php if(!empty($matching_products_content[$i])):?>
    	<li>
    		<?php 
    			echo $matching_products_content[$i]['discount'];
    			echo $matching_products_content[$i]['img'];
    			echo $matching_products_content[$i]['name'];
    			echo $matching_products_content[$i]['price'];
    			echo $matching_products_content[$i]['button'];			
    		?>		
    	</li>
	<?php endif;?>
	<?php } ?>      
	<div class="clearfix"></div>
	</ul>
</div>
<?php } ?>