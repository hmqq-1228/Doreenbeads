<?php 
if(! $products_new_split->number_of_rows || $products_new_split->number_of_rows < 0){
	echo '

<script language="javascript">
$j(document).ready(function(){
	$j(".mainwrap .current_nav").html(\'<a href="'.HTTP_SERVER.'">'.HEADER_TITLE_CATALOG.'</a> >> <span>'.NAVBAR_TITLE_2.'</span>\');
})
</script>				
    <div class="search_title">
        <b>' . sprintf(TEXT_SEARCH_RESULT_NORMAL, $keyword_input, $num_products_count, $keyword_input) . '</b>';
	if(!empty($related_str)) {
        echo '<p><b>' . TEXT_RELATED_SEARCH . ':</b> ' . $related_str . '</p>';
    }
    echo '</div>';

    
    echo TEXT_SEARCH_TIPS;
    
	$define_page_system_page_baner_content = trim(file_get_contents($define_page_system_page_baner));
	if(!empty($define_page_system_page_baner) && is_file($define_page_system_page_baner) && !empty($define_page_system_page_baner_content)) {
		echo '<h2 class="search_error_title">' . TEXT_SEARCH_RESULT_FIND_MORE . '</h2>';
		echo '<div>';
		require($define_page_system_page_baner);
		echo '</div>';
	}
}else{
	if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
		$is_quick = true;
	}else{
		$is_quick = false;
	}
	if ($_GET['main_page'] == 'advanced_search_result'){
		echo '<div class="search_title"><b>' . TEXT_SEARCH_RESULT_TITLE . '</b> ' . sprintf(TEXT_SEARCH_RESULT_NORMAL, $keyword_input, $num_products_count, $keyword_input) . ' ';
		
		if($is_search_synonym && $num_products_count > 0) {
			echo sprintf(TEXT_SEARCH_RESULT_SYNONYM, implode(",&nbsp;", $search_keywords));
		}
		if(!empty($related_str)) {
			echo '<p><b>' . TEXT_RELATED_SEARCH . ':</b> <span class="jq_related_item">' . $related_str . '</span></p>';
		}
		echo '</div>';
	}
	if(sizeof($getsProInfo)){
		ksort($getsProInfo);
	?>
		<div class="filterProDiv"><b><?php echo $current_category_name?>:</b>
		<?php
			$getsProInfoInputStr=zen_draw_hidden_field('pcount',$_GET['pcount']);
			foreach($getsProInfo as $kkey=>$kstr){
				$getsProInfoStr='&'.$kkey.'='.$kstr['id'].$getsProInfoStr;
				$getsProInfoInputStr.=zen_draw_hidden_field($kkey, $kstr['id']);
				?>
				<a href="<?php echo $kstr['link']?>"><span><?php echo $kstr['name']?></span><ins>X</ins></a>
				<?php			
			}
			$getsProInfoStr.='&pcount='.$_GET['pcount'];
		?>
		</div>
		<?php
	}
?>
<h2 id="productListHeading">	
	<?php echo $breadcrumb->last(); ?>
	<span>(<?php echo $products_new_split->number_of_rows;?>)</span>
	<?php echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))). '</div>'; ?>
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
// if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
// 	require($template->get_template_dir('tpl_modules_quick_browse_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_quick_browse_display.php');
// } else {
// 	require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
// }

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

echo '<div class="propagelist">'. $products_new_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))). '</div>';
?>
</div>
<?php } ?>
