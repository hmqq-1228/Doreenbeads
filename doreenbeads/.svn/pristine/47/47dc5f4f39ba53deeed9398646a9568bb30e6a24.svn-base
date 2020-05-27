<?php 
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays category/sub-category listing<br />
 * Uses tpl_index_category_row.php to render individual items
 *
 * @package templateSystem 
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_categories.php 4678 2006-10-05 21:02:50Z ajeh $
 */

?>
<?php
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
		?>
		<?php if(!isset($_GET['pcount'])){ ?>
				<h2 id="indexCategoriesHeading">
				<?php 
					echo $breadcrumb->last();
				?>
				</h2>
		<?php } ?>
		<?php if($_SESSION ['languages_id'] == 1 && $_GET['cPath'] == '2066_2119' && $_GET['landing_page'] == 'show'){?>
				<img style="margin-top:5px;" src="includes/templates/cherry_zen/images/<?php echo $_SESSION ['language'] ?>/dorabeads_landing_page.jpg" />
		<?php }?>
		
		<?php if(!isset($_GET['pcount'])){ ?>
				<div class="category_description"><?php echo $current_categories_description;?></div>
		<?php } ?>
		<?php 
			
			$static_file = DIR_WS_TEMPLATES.'static/common/pop_categories.html';
			if(zen_check_static($static_file, 1800)){
				include($static_file);
			}else{
				ob_start();
				if (!isset($_GET['pcount'])) {
					require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
				}		
				
				$static_contents=ob_get_flush();
				file_put_contents($static_file, $static_contents);
				if($cPathLength>1){
				 	require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
				 }
			}
	}
	
?>