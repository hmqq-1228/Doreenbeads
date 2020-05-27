<header>
	<div class="header-top">
		<?php require($template->get_template_dir('tpl_currency_lang.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_currency_lang.php');?>
		<span class="menushow"><?php echo TEXT_HEADER_MENU;?><ins></ins></span>
	</div>
	<?php
	if(!($_GET['main_page'] == 'index' && $_GET['cPath'] == '')){
		echo show_coupon_letter('mobiesite', true);
	}
	?>
	<div class="header-logo">
		<table>
			<tr>
				<td><a href="<?php echo zen_href_link(FILENAME_DEFAULT)?>" class="logo"></a></td>
				<td><a href="<?php echo zen_href_link(FILENAME_MYACCOUNT)?>"><span class="head-portrait"></span></a></td>
				<td><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>" class="shopcart<?php echo ($_SESSION['count_cart'] > 0 ? 1 : '');?>"></a></td>
				<td><a href="<?php echo zen_href_link(FILENAME_WISHLIST)?>" class="like-collect"></a></td>
			</tr>
		</table>
	</div>
	<?php require($template->get_template_dir('tpl_search_form.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_search_form.php');?>
</header>

<nav>
<?php
$hide_nav_page_array = array('product_reviews', 'product_question','coupon_terms','help_center','about_us','terms','privacy','checkout');
if($current_page_base!=FILENAME_DEFAULT){
	if (!in_array($current_page_base, $hide_nav_page_array)) {
		echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR);
	}	
}elseif(!$this_is_home_page){
	echo $breadcrumb->showbreads();
}

?>
</nav>