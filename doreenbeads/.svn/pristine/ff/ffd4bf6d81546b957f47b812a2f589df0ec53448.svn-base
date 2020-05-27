<?php
chdir("../");
require('includes/application_top.php');
$action=isset($_POST['action'])?$_POST['action']:'';
$website=isset($_POST['website'])?$_POST['website']:'';
$returnArray = array('error' => 1, 'error_info' => "");
switch($action){
	case 'all_status':
		$returnArray['error'] = 0;
		$returnArray['station_letter_content'] = '';
		if($website == "mobiesite") {
			$returnArray['count_cart'] = !empty($_SESSION['count_cart']) ? $_SESSION['count_cart'] : $_SESSION['cart']->get_products_items();
			$returnArray['customer_info'] = $returnArray['customers_currency'] = '';
			if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') {
				$returnArray['customer_info'] .= '<p>'. TEXT_HI . ', ' . $_SESSION['customer_first_name'] . ' ! &nbsp;<a style="color: #3b5998;text-decoration: underline;" href="index.php?main_page=logoff">' . HEADER_TITLE_LOGOFF . '</a></p>';
		    }else{
				$returnArray['customer_info'] .= '<p><a style="color: #3b5998;text-decoration: underline;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' . TEXT_SIGN_IN . '</a> ' . TEXT_OR . ' <a style="color: #3b5998;text-decoration: underline;" href="index.php?main_page=register">' . TEXT_REGISTER . '</a></p>';
		    }
		    $returnArray['customers_currency'] .= isset($_SESSION['currency']) ? $_SESSION['currency'] : 'USD';
		    
			$station_letter_content = show_coupon_letter('mobiesite');
			$returnArray['station_letter_content'] = $station_letter_content;
		    
		} else {
			include_once($language_page_directory . 'cherry_zen/header.php');
			$returnArray['count_cart'] = !empty($_SESSION['count_cart']) ? $_SESSION['count_cart'] : $_SESSION['cart']->get_products_items();
			$returnArray['customer_info'] = $returnArray['customer_navigation'] = $returnArray['customers_currency'] = $returnArray['customers_language'] = $returnArray['customers_recently_products'] = '';
				
			if((isset($_SESSION["customer_id"])&&$_SESSION["customer_id"]!="")){
				$customer_name = $_SESSION['customer_first_name'] !='' ? (strlen($_SESSION['customer_first_name']) > 15 ? substr($_SESSION['customer_first_name'], 0, 12).'...' : $_SESSION['customer_first_name'] ) : (strlen(strstr($_SESSION['customer_email'], '@', true)) > 15 ? substr(strstr($_SESSION['customer_email'], '@', true), 0, 12).'...' : strstr($_SESSION['customer_email'], '@', true) );
				$returnArray['customer_info'] .= TEXT_HEADER_WELCOME .', <a rel="nofollow" href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL'). '">' . $customer_name . '</a> (<a rel="nofollow" href="' . zen_href_link(FILENAME_LOGOFF, '', 'SSL') .'">' . HEADER_TITLE_LOGOFF . '</a>)';
				$returnArray['customer_navigation'] .= '<a rel="nofollow" class="helpHover" href="' . zen_href_link('myaccount', '', 'SSL') . '>" >' . HEADER_TITLE_MY_ACCOUNT . '<ins></ins></a>
					<div class="helpcont">
						<p class="helplist"><a rel="nofollow" href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '" >' . HEADER_TITLE_MY_ORDERS. '</a></p>
						<p class="helplist"><a rel="nofollow" href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '" >' . HEADER_TITLE_ADDRESS_BOOK . '</a></p>
					</div><input type="hidden" class="isLogin" value="yes"></li>';
				$returnArray['customers_firstname'] = $_SESSION['customer_first_name'];
				$returnArray['customers_email'] = $_SESSION['customer_email'];
			} else {
				$returnArray['customer_info'] .= TEXT_HEADER_WELCOME . ', ' . TEXT_HEADER_LOGIN_AND_REGISTER;
				$returnArray['customer_navigation'] .= '<li id="myAccount" class="help"><a rel="nofollow" class="helpHover" href="' . zen_href_link(FILENAME_ACCOUNT, '&return=myaccount', 'SSL') . '" >' . HEADER_TITLE_MY_ACCOUNT . '</a><input type="hidden" class="isLogin" value="no"></li>';
			}
			
			$my_message_data = get_customers_message_memcache($_SESSION['customer_id'], $_SESSION['languages_id'], 0, 5);
			$message_li = '';
			if(!empty($my_message_data)) {
				foreach($my_message_data['list'] as $my_message_value) {
					$message_li .= '<li>&nbsp;<a href="' . zen_href_link(FILENAME_MESSAGE_INFO) . '&auto_id=' . $my_message_value['auto_id'] .'">[<font class="my_message_type">' . $my_message_value['title_type'] . '</font>] ' . $my_message_value['title_list'] . '</a></li>';
				}
			} else {
				$message_li .= '<li>' . TEXT_NO_UNREAD_MESSAGE . '</li>';
			}
			
			$returnArray['my_message_notice'] .= '<li class="jq_my_message_notice my_message_notice'. (empty($my_message_data) ? " my_message_notice_empty" : "") .'"> <a rel="nofollow" class="helpHover" >' . (!empty($my_message_data) ? '(<font id="my_message_count" class="my_message_count">' . ($my_message_data['count'] > 99 ? 99 : $my_message_data['count']) . '</font>)' : "") . '<span class="my_message_notice_icon"></span></a>
				<div class="helpcont helpcen">         
					<ul>' . $message_li . '</ul>
					<div>
						<div class="my_message_setting">&nbsp;<a href="' . zen_href_link(FILENAME_MESSAGE_SETTING) . '">' . TEXT_SETTING . '</a></div>
						<div class="my_message_see"><a href="' . zen_href_link(FILENAME_MESSAGE_LIST) . '">' . TEXT_SEE_ALL_MESSAGES . '</a>&nbsp;</div>
					</div>
				</div>					
			</li>';
			//ob_start();
			//require(DIR_WS_TEMPLATE . '/common/tpl_currency.php');
			//$info = ob_get_contents();
			/*
			ob_start();
			require(DIR_WS_TEMPLATE . '/common/tpl_top_nav.php');
			$returnArray['customer_info'] .= ob_get_contents();
			*/
			if (isset ( $currencies ) && is_object ( $currencies )) {
				reset ( $currencies->currencies );
				$currencies_array = array ();
				
				while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
					$currencies_array [] = array (
							'id' => $key,
							'title' => $value ['title'] 
					);
				}
				$returnArray['customers_currency'] .= '<dd class="">' . $currencies->get_symbol_left((isset($_SESSION['currency']) ? $_SESSION['currency'] : 'USD')) . '<span></span></dd>
						<dt>
							<ul id="currency_type">';		
									foreach ( $currencies_array as $val ) {
										if($val['id'] == $_SESSION['currency']){
											$returnArray['customers_currency'] .= "<li class='cur" . $val['id'] . "'><a rel='nofollow' href='" . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('currency', 'generate_index')) . 'currency=' . $val['id'], $request_type)."' >" . $val['title'] . "</a></li>";
										}else{
											$returnArray['customers_currency'] .= "<li class='cur" . $val['id'] . "'><a rel='nofollow' href='" . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('currency', 'generate_index')) . 'currency=' . $val['id'], $request_type) . "'  >" . $val['title'] . "</a></li>";
										}
									}
							$returnArray['customers_currency'] .= '</ul>
						</dt>';
			}
			
			if (!isset($lng) || (isset($lng) && !is_object($lng))) {
				$lng = new language;
			}
			reset($lng->catalog_languages);
			$languages_html = "";
			$languages_html_head = "";
			while (list($key, $value) = each($lng->catalog_languages)) {
				$lang_url = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency', 'generate_index'))  . 'currency=' . $_SESSION['currency'] . '&language=' . $key, $request_type);
				if($value['id']==$_SESSION['languages_id']){
					$languages_html_head =  '<li><b><a data-code="' . $key . '" rel="nofollow" href="' . $lang_url . '" >'.$value['name'].'</a></b></li>';
				}else{
					$languages_html .= '<li> · <a data-code="' . $key . '" rel="nofollow" href="' . $lang_url . '" >'.$value['name'].'</a></li>';
				}
				$lng_cnt ++;
			}
			
			$recently_products_arr = get_recently_viewed_products(true);
			
			if(sizeof($recently_products_arr) > 0){
				$returnArray['customers_recently_products'] .= '<div class="sidesafe_icon" style="padding-top:0px;float: inherit;" >
			<h4>' . TEXT_RECENTLY_VIEWED . '</h4>';
				foreach ($recently_products_arr as $values){
					$returnArray['customers_recently_products'] .= '<div class="recently_pic"><a class="imglist" href="' . $values['product_link'] . '">' . $values['product_image'] . '</a></div>';
				}
				$returnArray['customers_recently_products'] .= '</div>';
			}
			$returnArray['customers_language'] .= $languages_html_head . $languages_html;
			
			$station_letter_content = show_coupon_letter('web');
			$returnArray['station_letter_content'] = $station_letter_content;
			
		}
		
		break;
	case 'show':
		break;
}
echo json_encode($returnArray);
?>