<div style="margin:0 auto;width:100%;max-width:640px;">
<div id="move_body">
	<script>show_auth_code();</script>
	<div class="order_header">
	  	<div class="cart_top"><a onclick="window.history.back()" class="back"></a>
		    <h3 class="title">
		    	<?php 
		    	$page_array =  ['shopping_cart' => strtoupper(HEADER_PROCESS1) . ' ( ' . $_SESSION['count_cart'].'  '.TEXT_CART_ITEMS . ' ) ',
							 'sitemap' => strtoupper(TEXT_SITEMAP),
							 'logoff' => strtoupper(TEXT_LOG_OFF),
							 'forgetpwd' => strtoupper(TEXT_PASSWORD_FORGOTTEN),
							 'register_successfully' => strtoupper(TEXT_REGISTER_SUCCESSFULLY),
							 'password_reset' => strtoupper(TEXT_RESET_PASSWORD),
							 'checkout_payment' => strtoupper(TEXT_CHECKOUT_STEP3),
							 'checkout_success' => strtoupper(TEXT_CHECKOUT_STEP4),
							 'account_history_info' => strtoupper(zen_get_order_status($_GET['order_id'])),
							 'wishlist' => strtoupper(TEXT_WISHLIST),
							 'my_coupon' => strtoupper(TEXT_WORD_COUPON),
							 'cash_account' => strtoupper(TEXT_WORD_CREDIT_BALANCE),
							 'packing_slip' => strtoupper(TEXT_PACKING_SLIP),
							 'account_newsletters' => strtoupper(TEXT_WORD_NEWSLETTER_SUBSCRIPTION),
							 'order_products_snapshot' => strtoupper(TEXT_WORD_ITEM_SNAPSHOT),
							 'message_info' => strtoupper(TEXT_MESSAGE),
							 'message_list' => strtoupper(TEXT_MY_MESSAGE),
							 'message_setting' => strtoupper(TEXT_MESSAGE_SETTING),
							];

		    	if ($_GET['main_page'] == 'checkout') {
					if ($_GET['pn'] == 'edit') {
						echo strtoupper(TEXT_EDIT_ADDRESS); 
					}elseif($_GET['pn'] == 'new'){
						echo strtoupper(TEXT_ADD_NEW_ADDRESS); 
					}else{	
						echo strtoupper(TEXT_PLACE_ORDER); 
					}
				} elseif($_GET['main_page'] == 'myaccount') {
					if ($_GET['tag'] == 'order' ) {
						echo strtoupper(TEXT_ORDERS); 
					}elseif($_GET['tag'] == 'settings'){
						echo strtoupper(TEXT_WORD_SETTINGS); 
					}elseif($_GET['tag'] == 'message'){
						echo strtoupper(TEXT_MESSAGE); 
					}else{
						echo strtoupper(HEADER_TITLE_MY_ACCOUNT); 
					}
				} elseif($_GET['main_page'] == 'account') {
					if (isset($_GET['status_id']) && $_GET['status_id'] >= 0 ) {
						echo strtoupper(zen_get_orders_status_by_lang($_GET['status_id'], $_SESSION['languages_id']));
					}else{
						echo strtoupper(TEXT_ALL_ORDERS); 
					}	
				} elseif($_GET['main_page'] == 'address_book') {
					if (isset($_GET['edit']) && $_GET['edit'] > 0 ) {
						echo strtoupper(TEXT_EDIT_ADDRESS);
					}elseif(isset($_GET['del']) && $_GET['del'] > 0 ){
						echo strtoupper(TEXT_WORD_DELETE_ADDRESS);
					}else{
						echo strtoupper(TEXT_ADDRESS_BOOK); 
					}	
				} elseif($_GET['main_page'] == 'account_edit') {
					if (isset($_GET['edit']) && $_GET['edit'] > 0 ) {
						echo strtoupper(TEXT_EDIT_ADDRESS);
					}elseif(isset($_GET['del']) && $_GET['del'] > 0 ){
						echo strtoupper(TEXT_WORD_DELETE_ADDRESS);
					}elseif(isset($_GET['edit']) && $_GET['edit'] == 'email' ){
						echo strtoupper(TEXT_CHANG_EMAIL_ADDRESS);
					}else{
						echo strtoupper(TEXT_PROFILE_SET); 
					}	
				} else {
					
					foreach ($page_array as $key => $val) {
						if ($key === $_GET['main_page']) {
						echo $val;
						break;
						}
					}
				}
		    	?>
		    	
		    </h3>
		    <?php if(!in_array($_GET['main_page'], $has_no_menu)) {?>
		    	<?php if($_GET['pn'] != 'edit') { ?>
		    		<a class="menu"></a>
		    	<?php } ?>
		    <?php } ?>
	    </div>
		<?php
			$my_message_data = get_customers_message_memcache($_SESSION['customer_id'], $_SESSION['languages_id'], 0, 5);
		?>
	    <div class="menu_subnav_warp">
		  	<ul class="menu_subnav">
			    <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT); ?>"><ins class="home_icons"></ins><?php echo HEADER_MENU_HOME; ?></a></li>
			    <li><a <?php echo $_GET['main_page'] == 'site_map' ? 'class="current"' : 'href="site_map.html"' ?>><ins class="search_icons"></ins><?php echo BOX_HEADING_SEARCH; ?></a></li>
			    <li><a <?php echo $_GET['main_page'] == 'myaccount' ? 'class="current"' : 'href="index.php?main_page=myaccount"' ?>><ins class="account_icons"></ins><?php echo HEADER_TITLE_MY_ACCOUNT; ?><?php if(!empty($my_message_data)) {?>(<span class="message_total"><?php echo ($my_message_data['count'] > 99 ? 99 : $my_message_data['count']);?></span>)<?php }?></a></li>
			    <li><a <?php echo $_GET['main_page'] == 'shopping_cart' ? 'class="current"' : 'href="index.php?main_page=shopping_cart"' ?> ><ins class="cart_icons"></ins><?php echo HEADER_PROCESS1; ?></a></li>
			    <li><a href="javascript:void(0);" id="footChangeLanguage"><ins class="language_icons"></ins><?php echo ucfirst($_SESSION ['lng']->language['name']); ?></a></li>
			    <li><a href="javascript:void(0);" id="footChangeCuurency"><ins class="currency_icons"></ins><?php echo $_SESSION ['currency']; ?></a></li>
			</ul>
		</div>
	</div>
	<?php
	if(!($_GET['main_page'] == 'index' && $_GET['cPath'] == '')){
		echo show_coupon_letter('mobiesite');
	}
	?>
</header>
