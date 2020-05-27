<?php
if($is_promotion_time){
	if(!$show_promotion_index){
		if (1==2 && file_exists($include_file))
		{
			require($include_file);
		}
?>
<h2 id="productListHeading">
<?php echo $breadcrumb->last();?>
<span>(<?php echo $products_new_split->number_of_rows;?>)</span>
<?php echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) . '</div>'; ?>
</h2>

<?php require($template->get_template_dir('tpl_modules_mode_product_filter.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_product_filter.php');?>

<div class="product_nav">
   <div class="fleft product_nav_l">
      <?php require($template->get_template_dir('tpl_modules_mode_change.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_mode_change.php');?>
      <?php require($template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php');?>
   </div>
   <div class="fright product_nav_r">
      <?php require($template->get_template_dir('/tpl_modules_listing_per_page.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_per_page.php');?>
   </div>
</div>

<div class="product_list">
<?php
if ($products_new_split->number_of_rows > 0){
	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
		$smarty->assign('tabular',$show_products_content);
		isset($_GET['page']) ? $sPage = $_GET['page'] : $sPage = 1;
		$smartyId = $_GET['cPath'].'__'.$sPage; 
		$smarty->display(DIR_WS_INCLUDES.'templates/products_gallery.html',$smartyId);
	}else{
		$smarty->assign('tabular',$list_box_contents_property);
		isset($_GET['page']) ? $sPage = $_GET['page'] : $sPage = 1;
		$smartyId = $_GET['cPath'].'__'.$sPage;  
		$smarty->display(DIR_WS_INCLUDES.'templates/products_list.html',$smartyId);
	}
}else{
	if($is_advance_result_listing){
		echo '<h1 id="advSearchResultsDefaultHeading">'.TEXT_LOOK;
		echo '<div id="continue_shopping"><a href='.zen_href_link(FILENAME_DEFAULT).'>'.CONTINUE_SHOPPING.'</a></div>';
		echo SEARCH_TIPS.'</h1>';
	}else{
		?>
			<div class="main_c_pagelist">
				<p class='itemfound'><?php echo TEXT_NO_NEW_PRODUCTS;?><?php //echo sprintf(TEXT_ITEM_FOUND,'0'); ?></p>
			</div>
		<?php
	}
}

echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) . '</div>';
?>
</div>

<?php
	}else{
		if (file_exists($include_file))
		{
			require($include_file);
		}
		//require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PROMOTION_INDEX, 'false'));
	}
}else{
	require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PROMOTION_EXPIRED, 'false'));
}
?> 