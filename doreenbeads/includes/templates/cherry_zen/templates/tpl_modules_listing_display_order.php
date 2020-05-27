<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_listing_display_order.php 3369 2006-04-03 23:09:13Z drbyte $
 */
?>
<?php
// NOTE: to remove a sort order option add an HTML comment around the option to be removed
//eof jessa 2010-04-02

	$disp_array = array('3'=>TEXT_INFO_SORT_BY_PRODUCTS_PRICE,
			'4'=>TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC,
			//'5'=>TEXT_INFO_SORT_BY_PRODUCTS_MODEL,
			'6'=>TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC,
			'7'=>TEXT_INFO_SORT_BY_PRODUCTS_DATE, 
			'30'=>WEBSITE_PRODUCTS_SORT_TYPE == 'score' ? TEXT_INFO_SORT_BY_BEST_MATCH : TEXT_INFO_SORT_BY_BEST_SELLERS);
	if((($_GET['main_page'] == 'products_common_list' && $_GET['pn'] == 'best_seller') || $_GET['main_page'] == 'advanced_search_result') && $_SESSION['has_valid_order'] ){
		$disp_array['10'] = TEXT_INFO_SORT_BY_BEST_SELLERS;
	}
	//if($_GET['main_page'] == 'promotion') $disp_array['40'] = TEXT_INFO_SORT_BY_STOCK_LIMIT;
?>

<div class="sort">
	<div class="selectlike">
		<label><?php echo TEXT_INFO_SORT_BY; ?></label>
		<p class="selectnum">
			<span class="text_left1"><?php echo $disp_array[$_GET['disp_order']];?></span>
			<span class="arrow_right1"></span>
		</p>
		<ul class="numlist" style="display: none;">
		<?php
			if($disp_order != $disp_order_default)
				echo '<li><a rel="nofollow" href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'&disp_order='.$disp_order_default).'">'.PULL_DOWN_ALL_RESET.'</a></li>';
			foreach($disp_array as $key=>$val)
				echo '<li><a rel="nofollow" href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'&disp_order='.$key).'">'.$val.'</a></li>';
		?>
		</ul>
	</div>
</div>
