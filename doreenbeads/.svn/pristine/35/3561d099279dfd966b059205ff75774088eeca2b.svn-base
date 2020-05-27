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

if(isset($_GET['pcount'])){
	if(sizeof($getsProInfo)){
		ksort($getsProInfo);
		$get_all_cate_array=zen_get_all_cate_array();
		$current_category_name=$get_all_cate_array[$current_category_id]['name'];
		echo '<div class="filterProDiv"><strong>' . $current_category_name . ': </strong>';
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
<div class = "productinfo">
<?php if(isset($_GET['pcount'])){ ?>
		<h2 id="productListHeading">
			<?php echo $breadcrumb->last(); ?>
			<span>(<?php echo $products_new_split->number_of_rows;?>)</span>
			<?php echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))). '</div>'; ?>
		</h2>
<?php } ?>

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
			echo TEXT_NO_NEW_PRODUCTS;
	}
}
echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))). '</div>';
?>
</div>
</div>
