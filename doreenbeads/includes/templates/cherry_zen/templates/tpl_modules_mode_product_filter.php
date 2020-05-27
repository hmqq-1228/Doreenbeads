<?php if(!in_array($_GET['aId'], array("1"))) {?>
<div class="jq_product_filter product_filter">
		<span>Package Size:&nbsp;&nbsp;</span>

		<a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('pack', 'page')));?>"><input type="radio" name="pack" value="-1" <?php if(!isset($_GET['pack']) || (isset($_GET['pack']) && $_GET['pack'] == '-1')){echo 'checked="checked"';} ?>> <?php echo TEXT_ALL;?></a>
		
		<a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('pack', 'page')) . 'pack=0');?>"><input type="radio" name="pack" value="0"  <?php if(isset($_GET['pack']) && $_GET['pack'] == '0'){echo 'checked="checked"';} ?>> <?php echo TEXT_REGULAR_PACK;?></a>
		
		<a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('pack', 'page')) . 'pack=2');?>"><input type="radio" name="pack" value="1"  <?php if(isset($_GET['pack']) && $_GET['pack'] == '2'){echo 'checked="checked"';} ?>> <?php echo TEXT_SMALL_PACK;?></a>
</div>
<?php }?>

<div class="jq_product_filter product_filter">
		<span>Filter By:&nbsp;&nbsp;</span>

		<?php if(!in_array($_GET['main_page'], array('promotion'))) {?>
		<a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('products_filter_onsale', 'page')) . (!isset($_GET['products_filter_onsale']) ? 'products_filter_onsale=1' : ''));?>"><input type="checkbox" name="products_filter_onsale" value="1" <?php if(isset($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == '1'){echo 'checked="checked"';} ?>/> <?php echo TEXT_ON_SALE;?></a>
		<?php }?>

		
		<a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('products_filter_in_stock', 'page')) . (!isset($_GET['products_filter_in_stock']) ? 'products_filter_in_stock=1' : ''));?>"><input type="checkbox" name="products_filter_in_stock" value="1" <?php if(isset($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == '1'){echo 'checked="checked"';} ?>/> <?php echo TEXT_IN_STOCK;?></a>
		
		<?php if(!in_array($_GET['pn'], array("mix"))) {?>
		<a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('products_filter_mixed', 'page')) . (!isset($_GET['products_filter_mixed']) ? 'products_filter_mixed=1' : ''));?>"><input type="checkbox" name="products_filter_mixed" value="1" <?php if(isset($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1){echo 'checked="checked"';} ?>/> <?php echo HEADER_MENU_MIX;?></a>
		<?php }?>
</div>