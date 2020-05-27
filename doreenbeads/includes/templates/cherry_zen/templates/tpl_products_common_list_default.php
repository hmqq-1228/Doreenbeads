<?php
if($show_index){
    if(file_exists(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/subject_area/', 'subject_area_index_'.$aid.'.php', 'false'))){
        require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/subject_area/', 'subject_area_index_'.$aid.'.php', 'false'));
    }
}
if($show_list){
	if ($normal_category_list_show) {
		require($template->get_template_dir('tpl_products_common_list_property_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_common_list_property_default.php');
	}else{
		if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
			$is_quick = true;
		}else{
			$is_quick = false;
		}
	?>
	<h2 id="productListHeading">
		<?php if($_GET['pn'] == 'like'){
			$my_number_of_rows = $is_quick ? $products_new_split->number_of_rows : $listing_split->number_of_rows;
			echo $my_number_of_rows . ($my_number_of_rows>1 ? ' items' : ' item') . ' found';
		}else{
			echo $breadcrumb->last(); ?>
		<span>(<?php echo $is_quick ? $products_new_split->number_of_rows : $listing_split->number_of_rows;?>)</span>
		<?php } ?>
		<?php echo '<div class="propagelist">'. ($is_quick ? $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) : $listing_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')))) . '</div>'; ?>
	<?php
	?>
	</h2>
	<?php
	$extra_params = '';
	if (isset($_GET['cPath'])) $extra_params .= '&cPath=' . $_GET['cPath'];
	if (isset($_GET['inc_subcat'])) $extra_params .= '&inc_subcat=' . $_GET['inc_subcat'];
	if (isset($_GET['search_in_description'])) $extra_params .= '&search_in_description=' . $_GET['search_in_description'];
	if (isset($_GET['keyword'])) $extra_params .= '&keyword=' . $_GET['keyword'];
	if (isset($_GET['categories_id'])) $extra_params .= '&categories_id=' . $_GET['categories_id'];
	if (isset($_GET['pn'])) $extra_params .= '&pn=' . $_GET['pn'];
	if (isset($_GET['pid'])) $extra_params .= '&pid=' . $_GET['pid'];
	?>

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
	/**
	 * require the code for listing products
	 */
	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
		require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
	} else {
		require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
	}
	echo '<div class="propagelist">'. ($is_quick ? $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) : $listing_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')))) . '</div>';
	?>
	</div>
<?php }
}
?>
