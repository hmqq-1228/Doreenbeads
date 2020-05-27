<?php
$returnArray = array();
$action = $_POST['action'];
if($action == ''){
	$returnArray['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
	echo json_encode($returnArray);
	exit;
}

switch($action){
	case 'create_order':
		require('includes/application_top.php');
		set_time_limit(600);
		if(! $_SESSION['customer_id']) {
			$returnArray['link'] = zen_href_link(FILENAME_TIME_OUT);
			echo json_encode($returnArray);
			exit;
		}else{
			if(zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
				if ($is_mobilesite) {
					$_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => 'checkout'));
				}else{
					$_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_SHIPPING));
				}
				$returnArray['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
				echo json_encode($returnArray);
				exit;
			}
			if (isset($_SESSION['cart']->cartID) && $_SESSION['cartID'] && $_SESSION['cart']->cartID != $_SESSION['cartID']) {
				if ($is_mobilesite) {
					$returnArray['link'] = zen_href_link('checkout', 'pn=sc', 'SSL');
				}else{
					$returnArray['link'] = zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
				}
				echo json_encode($returnArray);
				exit;
			}
			$_SESSION['valid_to_checkout'] = true;
			$_SESSION['cart_errors'] = '';
			//$_SESSION['cart']->get_isvalid_checkout(true);
			//Tianwen.Wan20160624购物车优化
			$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
			if (!$_SESSION['valid_to_checkout']) {
				$returnArray['link']=zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');
				echo json_encode($returnArray);
				exit;
			}
		}

		$address = zen_db_prepare_input($_POST['address']);
		$shipping_input = zen_db_prepare_input($_POST['shipping']);
		$orderComments = zen_db_prepare_input($_POST['orderComments']);
		$tariff = addslashes(zen_db_prepare_input($_POST['tariff']));
		$packingway = zen_db_prepare_input($_POST['packingway'])=='' ? 1 : zen_db_prepare_input($_POST['packingway']);
		$couponCustomersId = intval($_POST['coupon_customers_id']);
		$orderComments = str_replace(TABLE_BODY_COMMENTS , '', $orderComments);
		$_SESSION['comments'] = $orderComments;
		$_SESSION['packing_way'] = $packingway;
		if(!$address || !$shipping_input){
			if ($is_mobilesite) {
				$returnArray['link'] = zen_href_link('checkout', 'pn=sc', 'SSL');
			}else{
				$returnArray['link'] = zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
			}
			echo json_encode($returnArray);
			exit;
		}

		if($_SESSION['sendto'] != $address || $_SESSION['shipping']['id'] != $shipping_input){
			$_SESSION['sendto'] = $address;
			unset($_SESSION['dhl_rm']);
			unset($_SESSION['hmdpd_rm']);
			unset($_SESSION['shipping']);
			require(DIR_WS_CLASSES . 'order.php');
			require(DIR_WS_CLASSES . 'shipping.php');
			$order = new order;
			$_SESSION['cartID'] = $_SESSION['cart']->cartID;
			//$shipping_modules = new shipping;
			//$shipping_result = $shipping_modules->reduce_result;
			
			$countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => $_SESSION['sendto']));
			$shipping_modules = new shipping ('', $countries_iso_code_2, '', '', '');
			$shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => $_SESSION['sendto']));
			$shipping_list = $shipping_data['shipping_list'];
			$shipping_info = $shipping_data['shipping_info'];
			$special_discount = $shipping_data['special_discount'];

			if ( (sizeof($shipping_list) > 0) || ($free_shipping == true) ) {
				if ((strpos($shipping_input, '_')) ) {
					//$_SESSION['shipping'] = $_POST['shipping'];
					list($module, $method) = explode('_', $shipping_input);
					if ( isset($shipping_list[$module]) || ($_SESSION['shipping']['id'] == 'free_free') ) {
						if ($_SESSION['shipping']['id'] == 'free_free') {
							$quote['title'] = FREE_SHIPPING_TITLE;
							$quote['cost'] = '0';
						} else {
							$quote = $shipping_list[$module];
						}
						if ($quote['error']) {
							$_SESSION['shipping'] = null;
						} else {
							if ( (isset($quote['title'])) && (isset($quote['final_cost'])) ) {
								$_SESSION['shipping'] = $quote;
							}
						}
					}else{
						$_SESSION['shipping'] = null;
					}
				}
			}
		}

		if(!isset($_SESSION['sendto']) || !isset($_SESSION['shipping']) || (isset($_SESSION['shipping']['id']) && strstr($_SESSION['shipping']['id'], "_") == "")){
			if ($is_mobilesite) {
				$returnArray['link'] = zen_href_link('checkout', 'pn=sc', 'SSL');
			}else{
				$returnArray['link'] = zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
			}
			die(json_encode($returnArray));
		}


		if (!$_SESSION['billto']) {
			$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		}
		
		if(isset($tariff) && trim($tariff) != ""){
			$db->Execute("UPDATE " . TABLE_ADDRESS_BOOK . " SET tariff_number = '" . $tariff . "' where address_book_id = " . $address);
		}

		require_once(DIR_WS_CLASSES . 'order.php');
		$order = new order;
		if (sizeof($order->products) < 1) {
			$returnArray['link']=zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');
			echo json_encode($returnArray);
			exit;
		}

		if ($_SESSION['cc_id']) {
			$discount_coupon_query = "SELECT coupon_code FROM " . TABLE_COUPONS . " WHERE coupon_id = :couponID";
			$discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
			$discount_coupon = $db->Execute($discount_coupon_query);
		}

		require(DIR_WS_CLASSES . 'order_total.php');
		$order_total_modules = new order_total;
		$order_total_modules->collect_posts();
		$order_totals = $order_total_modules->pre_confirmation_check();
		$order_totals = $order_total_modules->process();
		$order_data_success = $order->create_add_products(0);
		if($order_data_success['success'] == 1 && isset($_SESSION['order_guid']) && $_SESSION['order_guid'] != ''){
			$insert_id = $order->create($order_totals, $order_data_success);
			if($insert_id <= 0) {
				if ($is_mobilesite) {
					$returnArray['link'] = zen_href_link('checkout', 'pn=sc', 'SSL');
				}else{
					$returnArray['link'] = zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
				}
				die(json_encode($returnArray));
			}
			$order_total_modules->apply_credit();
			$order->reset_orderID($_SESSION['order_guid'],$insert_id);
			unset($_SESSION['order_guid']);
			$order->reset_cart($order_data_success);
			$_SESSION['order_number_created'] = $insert_id;
			//$fun_inviteFriends->canSendCoupon($insert_id);	//	invite friends
			
			// lvxiaoyong 20131231
			//if($_SESSION['use_coupon'] == 'Y' && isset($_SESSION['coupon_id']) && (int)$_SESSION['coupon_id'] > 0 && isset($_SESSION['customer_id'])){
			if($_SESSION['use_coupon'] == 'Y' && !empty($couponCustomersId) && isset($_SESSION['coupon_id']) && (int)$_SESSION['coupon_id'] > 0 && isset($_SESSION['customer_id'])){
				$coupon_track_data = array(
    				'coupon_id' => (int)$_SESSION['coupon_id'],
    				'customer_id' => $_SESSION['customer_id'],
    		        'order_id' => $_SESSION['order_number_created'],
    				'redeem_ip' => $_SERVER['REMOTE_ADDR'],
    				'redeem_date' => 'now()',
					'coupon_to_customer_id'=>$_SESSION['coupon_to_customer_id'],
					'coupon_customer_id'=>$couponCustomersId
    			);
				
    			zen_db_perform(TABLE_COUPON_REDEEM_TRACK, $coupon_track_data);
    			$db->Execute("update " . TABLE_COUPON_CUSTOMER . " set cc_coupon_status=20 where cc_id=" . $couponCustomersId);
			}//end
			unset($_SESSION['coupon_id']);
			unset($_SESSION['use_coupon']);
			unset($_SESSION['use_coupon_amount']);

			require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php');
			$order->send_order_email($insert_id, 2);
		}else{
			$returnArray['link']=zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');
			echo json_encode($returnArray);
			exit;
		}

		$_SESSION['cart']->reset(true);
		unset($_SESSION['comments']);
//		unset($_SESSION['packing_way']);
		$order_total_modules->clear_posts();
		$returnArray['link']=zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');
		echo json_encode($returnArray);
		exit;
		break;

	default:
		break;
}
?>
