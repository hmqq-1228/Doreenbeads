<?php 
if(isset($_GET['pcount'])){
	if(sizeof($getsProInfo)){
		ksort($getsProInfo);
		echo '<div class="filterProDiv"><strong>' . TEXT_ALL_CATEGORIES . ': </strong>';
		$getsProInfoInputStr=zen_draw_hidden_field('pcount',$_GET['pcount']);
		foreach($getsProInfo as $kkey=>$kstr){
			$getsProInfoStr='&'.$kkey.'='.$kstr['id'].$getsProInfoStr;
			$getsProInfoInputStr.=zen_draw_hidden_field($kkey, $kstr['id']);
			echo '<a rel="nofollow" href="' . $kstr['link'] . '"><span>' . $kstr['name'] . '</span><ins>&times;</ins></a>';
		}
		$getsProInfoStr.='&pcount='.$_GET['pcount'];
		echo '</div>';
	}
}
?>

<h2 id="productListHeading">
	<?php if($_GET['pn'] == 'like'){
		$my_number_of_rows = $products_new_split->number_of_rows;
		echo $my_number_of_rows . ($my_number_of_rows>1 ? ' items' : ' item') . ' found';
	}else{
		echo $breadcrumb->last(); ?>
	<span>(<?php echo $products_new_split->number_of_rows;?>)</span>
	<?php } ?>
	<?php echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) . '</div>'; ?>
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
