<body>
<?php
	if($_GET['main_page'] == 'invite_friends'){
		$smarty->display(DIR_WS_INCLUDES . 'templates/mobilesite/tpl/tpl_'.$_GET['main_page'].'.html');
	}else{
		//记录无效链接
		record_valid_url(true , $_GET['main_page'] , 'page_not_found');
		//eof
		
	$template_dir = $template->get_template_dir('tpl_header_new.php',DIR_WS_TEMPLATE, $current_page_base,'common');

	$new_template_pages = array('index',
								'product_info',
								'advanced_search_result', 
								'products_common_list',
								'facebook_like',
								'spin_to_win',
								'learning_center',
								'get_coupon',
								'promotion',
								'non_accessories',
								'promotion_deals',
								'promotion_price',
								'page_not_found',
								'promotion_display_area'
						   );
	//$new_template_pages_202 = array('shopping_cart', 'site_map', 'logoff', 'login', 'forgetpwd', 'register_successfully', 'password_reset', 'checkout', 'checkout_payment', 'checkout_success', 'account_history_info', 'myaccount', 'account', 'wishlist', 'my_coupon', 'cash_account', 'packing_slip', 'address_book');
	$has_no_footer = array('login', 'forgetpwd', 'password_reset', 'account_edit');
	$has_no_menu = array('login', 'forgetpwd', 'password_reset');
	
	//$is_new_template = in_array($_GET['main_page'], $new_template_pages);
		
	$tpl_body_header = "/tpl_body_header_202.php";
	$tpl_body_footer = "/tpl_body_footer_202.php";
	$tpl_body_footer_googleanalytics = "/tpl_footer_googleanalytics.php";
	
	$is_new_template = false;
	//$is_new_template_202 = false;
	// m V2.0.2 shopping_cart change
	/*if (in_array($_GET['main_page'], $new_template_pages_202)) {
		$tpl_body_header = "/tpl_body_header_202.php";
		$tpl_body_footer = "/tpl_body_footer_202.php";		
		$is_new_template_202 = true;		
	}else */if (in_array($_GET['main_page'], $new_template_pages)) {
		$is_new_template = true;
	}

	if ($is_new_template){
		echo '<div id="move_sidebar">';
		require($template_dir. '/tpl_body_sidebar.php');
		echo '</div><div id="move_body">';
		//采用新模板的页面 
		$tpl_body_header = "/tpl_body_header.php";
		$tpl_body_footer = "/tpl_body_footer.php";
		$tpl_body_footer_googleanalytics = "/tpl_body_footer_googleanalytics.php";
	}
	
	require($template_dir.'/tpl_announcement.php');
	
	require($template_dir. $tpl_body_header);
	
	echo '<div class="wrap-page">';
	
	if (file_exists(DIR_WS_INCLUDES . 'templates/mobilesite/tpl/tpl_'.$_GET['main_page'].'.html')) {
		$smarty->display(DIR_WS_INCLUDES . 'templates/mobilesite/tpl/tpl_'.$_GET['main_page'].'.html');
	}

	if (!in_array($_GET['main_page'], $has_no_footer)) {
		if ( $_GET['pn'] == 'edit' || $_GET['pn'] == 'new' || $_GET['tag'] != '' || ($_GET['main_page'] == 'address_book' && ($_GET['edit'] !='' || $_GET['del'] != '')) ) {	
		    echo '</div>';
		}else{
		    require($template_dir. $tpl_body_footer);
		}
	}else{
	    echo '</div>';
	}

	
?>

<?php
	if(!$is_new_template){ 
		echo '<a id="goTopBtn"></a>';
	}
	echo '</div>';
	require($template_dir. '/tpl_body_popup.php');

/*	if ($is_new_template_202 && !in_array($_GET['main_page'], $has_no_footer)) {
		echo '</div>';
		echo '</div>';
		require($template_dir. '/tpl_body_popup.php');
	}*/

	}
	include($template_dir. $tpl_body_footer_googleanalytics);
?>
</body>
