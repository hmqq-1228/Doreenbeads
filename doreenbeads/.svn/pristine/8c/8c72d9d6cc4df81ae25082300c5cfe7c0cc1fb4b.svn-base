<?php	
	require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
	
	if (!$_SESSION['customer_id']) {
		 $_SESSION['navigation']->set_snapshot();
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
	
	if (isset($_GET['tag']) && $_GET['tag'] != '') {
		$tag_page = $_GET['tag'];
	}else{
		$tag_page = '';
	}
    $sql = $db->Execute("select customers_dropper_id from " .  TABLE_PROMETERS_COMMISSION . "  where customers_dropper_id = " . $_SESSION['customer_id']); 
	$customers_dropper_id = $sql->fields['customers_dropper_id'];
	//$greeting_str = sprintf(TEXT_GREETING,$_SESSION['customer_first_name']);
	$greeting_str = $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name'];
		
	$orders_query = "SELECT orders_status , count(orders_id) as orders_num
		                 FROM   " . TABLE_ORDERS . " o
		                 WHERE  o.customers_id = :customersID
		                 and o.orders_status != 5
		                 group by orders_status";
	$orders_query = $db->bindVars($orders_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$orders = $db->Execute($orders_query);
	
	$orders_array = array('orders_num' => 0 , 'pending' => 0 , 'processing' => 0 , 'shipping' => 0 , 'update' => 0 , 'delivered' => 0 , 'cancel' => 0);
	$all_orders_num = 0;
	while (!$orders->EOF) {
		$orders_status = strval($orders->fields['orders_status']);
		if(in_array($orders_status, explode(',', MODULE_ORDER_PENDING_UNDER_CHECKING_STATUS_ID_GROUP))){
			$orders_array['pending'] += $orders->fields['orders_num'];
		}elseif($orders_status == '2'){
			$orders_array['processing'] = $orders->fields['orders_num'];
		}elseif($orders_status == '3'){
			$orders_array['shipping'] += $orders->fields['orders_num'];
		}elseif($orders_status == '4'){
			$orders_array['update'] += $orders->fields['orders_num'];
		}elseif($orders_status == '10'){
			$orders_array['delivered'] = $orders->fields['orders_num'];
		}elseif($orders_status == '0'){
			$orders_array['cancel'] = $orders->fields['orders_num'];
		}
		
		$all_orders_num += $orders->fields['orders_num'];
		$orders->MoveNext();
	}

	$orders_array['all_orders'] = $all_orders_num;
	
	$customer_new=zen_customer_is_new();
	$declare_total = $db->Execute('Select sum(usd_order_total) as d_total
										   From ' . TABLE_DECLARE_ORDERS ."
										  Where status>0 and customer_id = " . $_SESSION['customer_id']);	
	if($customer_new && !isset($declare_total->fields['d_total'])){
		$customers_orders_total=0;
		$history_amount=$customers_orders_total;
		$cVipInfo = getCustomerVipInfo ();
		$cNextVipInfo = getCustomerVipInfo ( true );
		//$credit_account_total_display =$currencies->format(0);
	}else{
		$order_total = $db->Execute('Select sum(order_total) as total
										   From ' . TABLE_ORDERS . "
										  Where orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . ")
										    And customers_id = " . $_SESSION['customer_id']);
		$customers_orders_total = $order_total->fields['total'] + $declare_total->fields['d_total'];
		   
		$cVipInfo = getCustomerVipInfo ();
		$cNextVipInfo = getCustomerVipInfo ( true );
		$history_amount=$customers_orders_total;

		$width_vip_li = round ( $history_amount / $cNextVipInfo ['max_amt'], 2 ) * 100;
		
		$credit_records = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
								   From " . TABLE_CASH_ACCOUNT . "
							       Where cac_customer_id = " . $_SESSION ['customer_id'] . "
								   And cac_status = 'A'" );
		$credit_account_total = 0;
		while ( ! $credit_records->EOF ) {
			$ca_currency_code = $credit_records->fields ['cac_currency_code'];
			$ca_amount = $credit_records->fields ['cac_amount'];
			$credit_account_total += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
			$credit_records->MoveNext ();
		}
		$credit_account_total_display =$currencies->format($credit_account_total);
	}
	
	$credit_records = $db->Execute ( "Select cac_cash_id, cac_amount, cac_currency_code
								   From " . TABLE_CASH_ACCOUNT . "
							       Where cac_customer_id = " . $_SESSION ['customer_id'] . "
								   And cac_status = 'A'" );
	$credit_account_total = 0;
	while ( ! $credit_records->EOF ) {
		$ca_currency_code = $credit_records->fields ['cac_currency_code'];
		$ca_amount = $credit_records->fields ['cac_amount'];
		$credit_account_total += ($ca_currency_code == 'USD')? $ca_amount : zen_change_currency($ca_amount, $ca_currency_code, 'USD');
		$credit_records->MoveNext ();
	}
	$credit_account_total_display =$currencies->format($credit_account_total);

	if ($_SESSION['channel']) {
		$vip_content = $cVipInfo['group_percentage'] . '% ' . TEXT_OFF;
	}else{
		$vip_content = $cVipInfo['customer_group'] . ' (' .$cVipInfo['group_percentage'] . '% ' . TEXT_OFF . ')';
	}
	
	$account_page_link['wishlist'] = zen_href_link(FILENAME_WISHLIST);
	$account_page_link['balance'] = zen_href_link(FILENAME_CASH_ACCOUNTS);
	$account_page_link['address_book'] = zen_href_link(FILENAME_ADDRESS_BOOK);
	$account_page_link['my_orders'] = zen_href_link(FILENAME_ACCOUNT);
	$account_page_link['account_setting'] = zen_href_link(FILENAME_ACCOUNT_EDIT);
	$account_page_link['my_coupon'] = zen_href_link(FILENAME_MY_COUPON);
	$account_page_link['sub_notify'] = zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS);
	$account_page_link['product_notify'] = zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS);
	$account_page_link['packing_slip'] = zen_href_link(FILENAME_PACKING_SLIP);
	$account_page_link['myaccount'] = zen_href_link(FILENAME_MYACCOUNT);
	$account_page_link['message_list'] = zen_href_link(FILENAME_MESSAGE_LIST);
	$account_page_link['message_setting'] = zen_href_link(FILENAME_MESSAGE_SETTING);
	$account_page_link['my_commission'] = zen_href_link(FILENAME_MY_COMMISSION);
	$account_page_link['commission_setting'] = zen_href_link(FILENAME_COMMISSION_SET);

	$smarty->assign ( 'account_page_link', $account_page_link);
	$smarty->assign ( 'greeting', $greeting_str );
	$smarty->assign ( 'history_amount', $history_amount );
	$smarty->assign ( 'next_level_total', $cNextVipInfo['max_amt'] );
	$smarty->assign ( 'next_level', $cNextVipInfo['customer_group'] );
	$smarty->assign ( 'next_discount', $cNextVipInfo['group_percentage'].'%' );
	$smarty->assign ( 'all_total', $orders_array['all_orders'] );
	$smarty->assign ( 'pending_total', $orders_array['pending'] );
	$smarty->assign ( 'processing_total', $orders_array['processing'] );
	$smarty->assign ( 'shipped_total', $orders_array['shipping'] );
	$smarty->assign ( 'delivered_total', $orders_array['delivered'] );
	$smarty->assign ( 'update_total', $orders_array['update'] );
	$smarty->assign ( 'cancel_total', $orders_array['cancel'] );
	$smarty->assign ( 'balance', $credit_account_total_display );
	$smarty->assign ( 'vip_content', $vip_content );
	$smarty->assign ( 'tag_page', $tag_page );
	$smarty->assign ( 'customers_dropper_id', $customers_dropper_id );
    

$account_query = "SELECT customers_gender, customers_firstname, customers_lastname,
                         customers_dob, customers_email_address, customers_telephone,customers_cell_phone,customers_password,customers_facebookid,
                         customers_fax, customers_email_format, customers_referral,customers_country_id,customers_business_web,customers_info_avatar
                  FROM   " . TABLE_CUSTOMERS . " c, ".TABLE_CUSTOMERS_INFO." ci
                  WHERE  customers_id = :customersID and ci.customers_info_id=c.customers_id";
$account_query = $db->bindVars($account_query, ':customersID', $_SESSION['customer_id'], 'integer');
$account = $db->Execute($account_query);
$if_from_facebook = $account->fields['customers_facebookid']!='' && $account->fields['customers_password']=='';

$head_picture = $account->fields['customers_info_avatar'] !='' ?  zen_image(DIR_WS_USER_AVATAR.$account->fields['customers_info_avatar'],'','60','60') : zen_image(DIR_WS_USER_AVATAR.'8seasons.jpg','','62','62');

$smarty->assign ( 'if_from_facebook', $if_from_facebook );
$smarty->assign ( 'head_picture', $head_picture );
?>