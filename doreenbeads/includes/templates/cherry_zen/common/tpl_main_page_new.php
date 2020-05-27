<?php
$body_id = ($this_is_home_page) ? 'indexHome' : str_replace ( '_', '', $_GET ['main_page'] );
$show_page_array = array (
		'login',
		'affiliate_program',
		'affiliate_programer',
		'who_we_are',
		'testimonial',
		'customer_service',
		'help_center',
		'site_map',
		'shopping_cart',
		'account_history_info',
		'order_products_snapshot',
		'checkout_shipping',
		'checkout_payment',
		'checkout_success',
		'club_list',
		'facebook_coupon',
		'contest',
		'contest_list',
		'promotion_price',
		'promotion_deals',
		'learning_center',
		'learning_center_details',
		'engraving_service',
		'promotion_display_area',
		'welcome',
		'message_info'
);

$show_page_array_right = array (
		'login',
		'who_we_are',
		'site_map',
		'promotion' ,
		'non_accessories',
		'club_list',
		'facebook_coupon',
		'promotion_price',
		'promotion_deals',
		'learning_center',
		'learning_center_details'
);
$display_navBreadCrumb = array(
		'login',
		'affiliate_program',
		'affiliate_programer',
		'order_products_snapshot',
		'club_list',
		'facebook_coupon',
        'new_customers_receive_coupon',
        'all_customers_receive_coupon',
        'receive_coupon'
);
$checkout_page_array = array(
		'shopping_cart',
		'checkout_shipping',
		'checkout_payment',
		'checkout_success'
);
$account_array = array(
		'account',
		'address_book',
		'account_edit',
		'my_commission',
		'my_commission_info',
		'my_commission_over_info',
		'commission_set',
		'account_password',
		'cash_account',
		'account_newsletters',
		'account_notifications',
		'address_book_process',
		'myaccount',
		'my_coupon',
		'packing_slip',
		'track_info',
		'message_list',
		'message_setting'

);
switch ($_GET['main_page']){
	case 'login' :
	case 'affiliate_program' :
	case 'affiliate_programer' :
	case 'site_map' :
	case 'shopping_cart' :
	case 'who_we_are' :
	case 'testimonial' :
	case 'customer_service' :
	case 'help_center' :
	case 'account_history_info' :
	case 'club_list' :
	case 'order_products_snapshot':
	case 'facebook_coupon':	
	case 'contest':
	case 'contest_list':
	case 'promotion_deals': 	
	case 'promotion_price':
	case 'learning_center':
	case 'learning_center_details':
	case 'engraving_service':
	case 'promotion_display_area':
	case 'welcome':
	case 'message_info':
	$extra_style_mainwrap_r = 'style="width:1000px;"'; break;
	default : $extra_style_mainwrap_r = '';
}

$ezpages_no_display_left_sidebox = zen_ezpages_display_style('left_sidebox');

if($_GET['main_page'] == 'oem_sourcing' || $_GET['main_page'] == 'oem_sourcing_success' || $_GET['main_page'] == 'no_watermark_picture'){
	require($body_code);
	require($template->get_template_dir('tpl_footer_new.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_new.php');
	include($template->get_template_dir('tpl_footer_googleanalytics.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_googleanalytics.php');
}else{
	if($_GET['main_page'] == 'invite_friends'){
		$smarty->display(DIR_WS_INCLUDES . 'templates/account/tpl_'.$_GET['main_page'].'.html');
	}else{
		if($_GET['main_page']=='page' && in_array($_GET['id'],$ezpages_no_display_left_sidebox)){
			$extra_style_mainwrap_r = 'style="width:1000px;"';
		}
	?>
	<script type="text/javascript" src="includes/templates/cherry_zen/jscript/jscript_jquery.js"></script>	
	<script type="text/javascript">
			function show_search(http_prefix){
			$j("#float_header_div").load("/<?php echo ($_SESSION['languages_code'])?>/float_header.php");
			$j("#header_box").show();
			$j("#float_header_div").show();
			$j('#header_close').show();
			}	
	</script>
		<body id="<?php echo $body_id . 'Body'; ?>" <?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?>>
	<?php
		require(DIR_WS_TEMPLATE .'/common/tpl_top_nav.php');
		if (in_array($_GET['main_page'], $checkout_page_array)){
			//bof checkout step head
			switch ($_GET['main_page']){
				case 'shopping_cart' : 
					$checkout_step = 0; 
					$style_step1 = 'current';
					$style_step2 = 'future';
					$style_step3 = 'place';
					$style_step4 = 'future_last';
					break;
				case 'checkout_shipping' : 
					$checkout_step = 1; 
					$style_step1 = 'current arrive';
					$style_step2 = 'future current';
					$style_step3 = 'place future';
					$style_step4 = 'future_last';
					break;
				case 'checkout_payment' : 
					$checkout_step = 2; 
					$style_step1 = 'current arrive';
					$style_step2 = 'future arrive';
					$style_step3 = 'place arrive';
					$style_step4 = 'future_last';
					break;
				case 'checkout_success' : 
					$checkout_step = 3; 
					$style_step1 = 'current arrive';
					$style_step2 = 'future arrive';
					$style_step3 = 'place current';
					$style_step4 = 'future_last arrive';
					break;
			}
			$smarty->assign('checkout_step', $checkout_step);
			$smarty->assign('style_step1', $style_step1);
			$smarty->assign('style_step2', $style_step2);
			$smarty->assign('style_step3', $style_step3);
			$smarty->assign('style_step4', $style_step4);
			
			if(isset($_SESSION['customer_id']) && $_SESSION['customer_id']!=''){
				$customer_info = zen_get_customer_info($_SESSION['customer_id']);
				$url_email = $customer_info['email'];
			}else{
				$url_email = '';
			}
			$open_live_chat_url="onclick=\"window.open('" . HTTP_LIVECHAT_URL . "/request.php?langs=" . $_SESSION['language'] . "&uname=" . $_SESSION['customer_first_name'] . "&uemail=" . $url_email . "&l=Dorabeads.com&x=1&deptid=1&pagex=http%3A///','unique','scrollbars=no,menubar=no,resizable=0,location=no,screenX=50,screenY=0,width=500,height=400')\"";
			$smarty->assign('open_live_chat_url', $open_live_chat_url);
			//eof
			
			$smarty->display(DIR_WS_INCLUDES . 'templates/checkout/tpl_'.$_GET['main_page'].'.html');
		}else{
			if (!in_array($_GET['main_page'], $checkout_page_array)){
				require($template->get_template_dir('tpl_header_new.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header_new.php');
			}
		?>
			
		<div id="contentMainWrapper" class="mainwrap">
		<?php 
			if (!in_array($_GET['main_page'], $display_navBreadCrumb) && !$this_is_home_page) {
				if(isset($_GET['referer_level3']) && $_GET['referer_level3']==1){
					$referer_from_level2 = true;
				}
				if($current_page_base == 'promotion' && $is_promotion_time && !$this_is_home_page || $current_page_base == 'products_common_list' || $current_page_base == 'advanced_search_result'){
					$referer_from_level2 = true;
				}
				// add sitemap to $breadcrumb
				if(!isset($_GET['products_id']) && (count($cPath_array)==2 || count($cPath_array)==3 || $referer_from_level2) ){
					$my_trail = array();
				    foreach($breadcrumb->_trail as $k=>$v){
				   	    if($k==0){
				   	      	$my_trail[$k] = $v;
				   	    }else if($k==1){
				         	$my_trail[$k] = array('title'=>TEXT_ALL_CATEGORIES, 'link'=>zen_href_link(FILENAME_SITE_MAP));
				         	$my_trail[$k+1] = $v;
				        }else{
				         	$my_trail[$k+1] = $v;
				        }
				    }
					$breadcrumb->_trail = $my_trail;
				}
				
				echo '<div class="current_nav">' . $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR) . '</div>';
			}
			
			echo '<div class="mainwrap_r" ' . $extra_style_mainwrap_r . '>';
			if ($page_account){
				$smarty->display(DIR_WS_INCLUDES . 'templates/account/tpl_'.$_GET['main_page'].'.html');
			}else{
				require($body_code);
			}	
			echo '</div>';
			
			if (!in_array ( $current_page_base, $show_page_array ) && ($_GET['main_page']=='page' && in_array($_GET['id'],$ezpages_no_display_left_sidebox)) == false) {
				echo '<div class="mainwrap_l">';
				if (in_array ( $current_page_base, $account_array )){
					require(DIR_WS_TEMPLATE . 'templates/tpl_account_navigation.php');
				}else{
					require(DIR_WS_MODULES . zen_get_module_directory('column_left.php'));
				}	
				
				echo '</div>';
				
			} 
		
		?>
		</div>
	<?php }?>

	<div class="clearfix"></div>
	<div id="header_box" style="z-index:99999;width:100%;height:80px;position:fixed;top:0px;display:none;">
    <div id="float_header_div"></div>
    <?php echo zen_image(DIR_WS_LANGUAGE_IMAGES."close_btn.png",'','','','style="cursor:pointer;float:right;margin-top:15px;right:3%;top:10%;padding-top:0px;position:relative;z-index:99999;" id="header_close"');?>
    </div>
	<?php
		require($template->get_template_dir('tpl_footer_new.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_new.php');
		include($template->get_template_dir('tpl_footer_googleanalytics.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_googleanalytics.php');
	?>
	<div id="searchBtn" onclick="show_search('<?php echo ENABLE_SSL == true ? 'https' : 'http';?>')" style="z-index: 100;"></div>
	<a id="goTopBtn" style="z-index: 100;"></a>
	</body>
<?php }
}?>
