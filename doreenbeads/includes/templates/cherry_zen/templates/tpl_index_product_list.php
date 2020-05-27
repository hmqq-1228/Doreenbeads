<?php
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays product-listing when a particular category/subcategory is selected for browsing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_product_list.php 6009 2007-03-13 23:56:45Z ajeh $
 */
// if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
// 	include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_QUICK_BROWSE_DISPLAY));
// }else{
// 	include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
// 	$products_new_split = $listing_split;
// }
	$current_category_info = get_category_info_memcache($current_category_id);
	if ($current_category_info['categories_status'] <= 0 && isset($current_category_info['categories_status'])) {
		require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CATEGORIES_NOT_FOUND, 'false'));
		$define_page_system_page_baner = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_SYSTEM_PAGE_BANNER, 'false');
		$define_page_system_page_baner_content = trim(file_get_contents($define_page_system_page_baner));
		if(!empty($define_page_system_page_baner) && is_file($define_page_system_page_baner) && !empty($define_page_system_page_baner_content)) {
			echo '<h2 class="search_error_title">' . TEXT_SEARCH_RESULT_FIND_MORE . '</h2>';
			echo '<div>';
			require($define_page_system_page_baner);
			echo '</div>';
		}
	}else{ 
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
		<?php
		// categories_description
		    if ($current_categories_description != '') {
		?>
		<div id="categoryDescription" class="catDescContent"><?php echo $current_categories_description;  ?></div>
		<?php 
		    }
		?>
		<h2 id="productListHeading">
			<?php echo $breadcrumb->last(); ?>
			<span>(<?php echo $products_new_split->number_of_rows;?>)</span>
			<?php echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))). '</div>'; ?>
		</h2>
		<?php
		$extra_params = '';
		if (isset($_GET['cPath'])) $extra_params .= '&cPath=' . $_GET['cPath'];
		if (isset($_GET['inc_subcat'])) $extra_params .= '&inc_subcat=' . $_GET['inc_subcat'];
		if (isset($_GET['search_in_description'])) $extra_params .= '&search_in_description=' . $_GET['search_in_description'];
		if (isset($_GET['keyword'])) $extra_params .= '&keyword=' . $_GET['keyword'];
		if (isset($_GET['categories_id'])) $extra_params .= '&categories_id=' . $_GET['categories_id'];
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
		echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))). '</div>';
		?>
		</div>
<?php }?>
