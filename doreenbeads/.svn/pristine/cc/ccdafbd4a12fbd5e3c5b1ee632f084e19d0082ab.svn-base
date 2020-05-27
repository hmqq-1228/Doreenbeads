<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: orders.php 6864 2007-08-27 16:15:20Z drbyte $
 */
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  require('includes/classes/ipquery.php');
  require('includes/functions/functions_promotion.php');
  
  $iplocal = new ip_query;
  $iplocal -> init();
  
  $currencies = new currencies();
  include(DIR_WS_CLASSES . 'order.php');
  $orders_payment = array(
  		array('id'=>'paypalmanually','text'=>'paypalmanually'),
  		array('id'=>'paypalwpp','text'=>'paypalwpp'),
  		/* array('id'=>'braintree','text'=>'braintree'),
  		array('id'=>'moneygram','text'=>'moneygram'),
  		array('id'=>'westernunion','text'=>'westernunion'),
  		array('id'=>'wire','text'=>'wire'),
  		array('id'=>'gcCreditCard','text'=>'gcCreditCard'),
  		array('id'=>'wirebc','text'=>'wirebc') */);
  $orders_payment_name = array(
  		'paypalmanually' => array(1 => 'Paypal Manually' , 2 => 'Paypal Manuell' , 3 => 'Paypal Вручную' , 4 => 'Paypal Manuellement' ),
  		'paypalwpp' => array(1 => 'PayPal' , 2 => 'PayPal' , 3 => 'PayPal' , 4 => 'PayPal' ),
  		/* 'moneygram' => array(1 => '<strong>Money Gram</strong>' , 2 => '<strong>Money Gram</strong>' , 3 => '<strong>Money Gram</strong>' , 4 => '<strong>Money Gram</strong>' ),
  		'westernunion' => array(1 => '<strong>Western Union Money Transfer</strong>' , 2 => '<strong>Western Union Money Transfer</strong>' , 3 => '<strong>мгновенный денежный перевод Western Union</strong>' , 4 => '<strong>Transfert de l’argent de la Western Union</strong>'),
  		'wire' => array(1 => '<strong>Bank Wire Transfer (HSBC)</strong>' , 2 => '<strong>Banküberweisung (HSBC)</strong>' , 3 => '<strong>Банковский перевод (HSBC)</strong>' , 4 => '<strong>Virement Bancaire (HSBC)</strong>'  ),
  		'gcCreditCard' => array(1 => '<strong>Credit Card (Via Global Collect)</strong>' , 2 => '<strong>Kreditkarte (Per Global Collect)</strong>' , 3 => '<strong>Кредитные карты (Via Global Collect)</strong>' , 4 => '<strong>Carte de Crédit (Via Global Collect)</strong>'  ),
  		'braintree' => array(1 => '<strong>Credit Card (Via Braintree)</strong>' , 2 => '<strong>Kreditkarte (Per Braintree)</strong>' , 3 => '<strong>Кредитные карты (Via Braintree)</strong>' , 4 => '<strong>Carte de Crédit (Via Braintree)</strong>'),
  		'webMoney' => array(1 => '<strong>WebMoney</strong>' , 2 => '<strong>WebMoney</strong>' , 3 => '<strong>WebMoney</strong>' , 4 => '<strong>WebMoney</strong>' ),
  		'QIWI' => array(1 => '<strong>QIWI Wallet</strong>' , 2 => '<strong>QIWI Brieftasche</strong>' , 3 => '<strong>QIWI кошелёк</strong>' , 4 => '<strong>QIWI bourse</strong>' ),
  		'wirebc' => array(1 => '<strong>Bank Wire Transfer (Bank of China)</strong>' , 2 => '<strong>Banküberweisung(Bank of China)</strong>' , 3 => '<strong>Банковский перевод (Банк Китая)</strong>' , 4 => '<strong>Virement Bancaire (Banque de Chine)</strong>') */
  );
  //bof shipping method list
  $module_directory = DIR_FS_CATALOG_MODULES . 'shipping/';
  // echo $module_directory;
  $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
  $i = 0;
//   if ($dir = @dir($module_directory)) {
//   	while ($file = $dir->read()) {
//   		if (!is_dir($module_directory . $file)) {
//   			if (substr($file, strrpos($file, '.')) == $file_extension) {
//   				include($module_directory . $file);
//   				$class = substr($file, 0, strrpos($file, '.'));
//   				echo $class.'---';
//   				//if (zen_class_exists($class)) $module = new $class;
//   				//if ($module->enabled) {
//   					$shipping_methods_enabled[$i]['id'] = $class;
//   					$shipping_methods_enabled[$i]['text'] = $class;
//   					$i++;
//   				//}
//   			}
//   		}
//   	}
//   	$shipping_methods_enabled[$i+1]['id'] = 'ywdhl-dh';
//   	$shipping_methods_enabled[$i+1]['text'] = 'ywdhl-dh';
//   	sort($shipping_methods_enabled);
//   	$dir->close();
//   }
/*  $shipping_methods_query = $db->Execute("select `name` as shipping_method, `code` as shipping_module_code from ".TABLE_SHIPPING." order by shipping_module_code");
  while(!$shipping_methods_query->EOF){
  	if($shipping_methods_query->fields['shipping_module_code'] != "" && !is_numeric($shipping_methods_query->fields['shipping_module_code'])) {
  		//$shipping_methods_enabled[shipping_module_code] = $shipping_methods_query->fields['shipping_method'];
  		//$shipping_methods_enabled[$i] = strip_tags($shipping_methods_query->fields['shipping_method']);
  		$shipping_methods_enabled[$i]['id'] = strip_tags($shipping_methods_query->fields['shipping_module_code']);
  		$shipping_methods_enabled[$i]['text'] = strip_tags($shipping_methods_query->fields['shipping_module_code']);
  		//$shipping_methods_code_enabled[$i] = strip_tags($shipping_methods_query->fields['shipping_module_code']);
  	}
  	$shipping_methods_query->moveNext();
  	$i++;
  }*/

$shipping_methods_enabled = array();
$shipping_method_array = get_shipping_method_conditions_memcache();
for ($i=0; $i < sizeof($shipping_method_array) ; $i++) { 
  $shipping_methods_enabled[$i]['id'] = $shipping_method_array[$i]['code'];
  $shipping_methods_enabled[$i]['text'] = $shipping_method_array[$i]['name'];
}

//   echo "<pre>";
//   print_r($shipping_methods_code_enabled);
//   echo "</pre>";
  //eof
  // prepare order-status pulldown list
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status = $db->Execute("select orders_status_id, orders_status_name
                                 from " . TABLE_ORDERS_STATUS . "
                                 where language_id = " . $_SESSION['languages_id']);
  while (!$orders_status->EOF) {
    $orders_statuses[] = array('id' => $orders_status->fields['orders_status_id'],
                               'text' => $orders_status->fields['orders_status_name'] . ' [' . 	$orders_status->fields['orders_status_id'] . ']');
    $orders_status_array[$orders_status->fields['orders_status_id']] = $orders_status->fields['orders_status_name'];
    //加入自动取消状态
    if($orders_status->fields['orders_status_id'] == '0') {
    	$orders_statuses[] = array('id' => 100,
                               'text' => '自动取消 [01]');
    }
    $orders_status->MoveNext();
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $order_exists = false;
  if (isset($_GET['oID']) && trim($_GET['oID']) == '') unset($_GET['oID']);
  if ($action == 'edit' && !isset($_GET['oID'])) $action = '';
  if (isset($_GET['oID']) && $_GET['oID'] != '') {
  	$oID = intval(zen_db_prepare_input($_GET['oID']));
  	$orders = $db->Execute("select orders_id,customers_id from " . TABLE_ORDERS . "
                            where orders_id = " . $oID);
  	$order_exists = true;
  	if ($orders->RecordCount() <= 0) {
  		$order_exists = false;
  		if ($action != '') $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
  	} else {
  		$customers_id = $orders->fields['customers_id'];
  	}
  }
  if (zen_not_null($action) && $order_exists == true || isset($_POST['ordersCheckbox'])) {
    switch ($action) {
      case 'edit':
      // reset single download to on
        if ($_GET['download_reset_on'] > 0) {
          // adjust download_maxdays based on current date
          $check_status = $db->Execute("select customers_id, customers_name, customers_email_address, orders_status,
                                      date_purchased from " . TABLE_ORDERS . "
                                      where orders_id = " . $oID);
          $zc_max_days = date_diff($check_status->fields['date_purchased'], date('Y-m-d H:i:s', time())) + DOWNLOAD_MAX_DAYS;
          $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='" . $zc_max_days . "', download_count='" . DOWNLOAD_MAX_COUNT . "' where orders_id=" . $oID . " and orders_products_download_id='" . $_GET['download_reset_on'] . "'";
          $db->Execute($update_downloads_query);
          unset($_GET['download_reset_on']);
          $messageStack->add_session(SUCCESS_ORDER_UPDATED_DOWNLOAD_ON, 'success');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
      // reset single download to off
        if ($_GET['download_reset_off'] > 0) {
          // adjust download_maxdays based on current date
          // *** fix: adjust count not maxdays to cancel download
//          $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='0', download_count='0' where orders_id='" . $oID . "' and orders_products_download_id='" . $_GET['download_reset_off'] . "'";
          $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_count='0' where orders_id=" . $oID . " and orders_products_download_id='" . $_GET['download_reset_off'] . "'";
          unset($_GET['download_reset_off']);
          $db->Execute($update_downloads_query);
          $messageStack->add_session(SUCCESS_ORDER_UPDATED_DOWNLOAD_OFF, 'success');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
      break;
//jessa 2009-11-29
	  case 'update_seller_memo':
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
        //$oID = zen_db_prepare_input($_GET['oID']);
        $old_seller_memo = zen_db_prepare_input($_POST['old_seller_memo']);
        $seller_memo = zen_db_prepare_input($_POST['seller_memo']);
        if ($seller_memo <> $old_seller_memo) {
        	$db->Execute("update " . TABLE_ORDERS . "
	                        set last_modified = now(),
	                        	seller_memo = '" . zen_db_input($seller_memo) . "'
	                      where orders_id = " . $oID);
        	$messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        }
        zen_redirect($_SERVER["HTTP_REFERER"]);
        break;
//eof jessa 2009-11-29
      case 'update_order':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
        //$oID = zen_db_prepare_input($_GET['oID']);
        $status = zen_db_prepare_input($_POST['status']);
        $comments = zen_db_prepare_input($_POST['comments']);
        $shippingNum = zen_db_prepare_input($_POST['shippingNum']);
        $payment_method = zen_db_prepare_input($_POST['paymethod']);
        $language_id = zen_db_prepare_input($_SESSION['languages_id']);
        $transaction_id = zen_db_prepare_input($_POST['transaction_id']);
        $order_updated = false;
        $extrme_update = '';
        
        
        /* 2014-09-01*/
		/*if ($status == 5){
			zen_order_to_remove($oID, true);
			include(DIR_WS_CLASSES . 'customers_group.php');
			$customers_group = new customers_group();
			$result  = $db->Execute("select customers_id from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
			$customers_group->correct_group($result->fields['customers_id']);
			zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
		}   */      
        $check_status = $db->Execute("select o.customers_id, customers_name, o.customers_email_address,o.payment_module_code, orders_status,o.language_id, o.shipping_num, o.currency,
                                      date_purchased ,c.customers_gender,c.customers_firstname,c.customers_lastname,order_total,
        							  o.delivery_country,c.is_old_customers
        								from " . TABLE_ORDERS . " o left join ".TABLE_CUSTOMERS."  c on c.customers_id=o.customers_id
                                      where    orders_id = " . $oID);
        $lang=$check_status->fields['language_id']-1;
        if($lang>(sizeof($order_status_config)-1)){
          $lang=0;
        }

        $payment_info = json_decode($check_status->fields['payment_info']);
        $is_old_customers = (int)$check_status->fields['is_old_customers'];
        
        if ( ($check_status->fields['orders_status'] != $status) || zen_not_null($comments) || ($shippingNum != $check_status->fields['shipping_num'] && $shippingNum != '') || $payment_method != $check_status->fields['payment_module_code'] || !isset($payment_info->transaction_id) || $payment_info->transaction_id == '') {
        	if($status == 2){
        		$extrme_update = '';
        		if($payment_method != ''){
        			$extrme_update .= ' , payment_method = "' . $orders_payment_name[$payment_method][$language_id] . '" , payment_module_code = "' . $payment_method . '"';
        		}
        		if($transaction_id != '' && $payment_info->transaction_id == ''){
        			$payment_arr = array(
        					'transaction_id' => $transaction_id,
        					'payment_method' => $payment_method,
        					'date_created' => date('Y-m-d H:i:s')
        			);
        		
        			$payment_info = addslashes(json_encode($payment_arr));
        		
        			$extrme_update .= ' , payment_info ="' . $payment_info . '"';
        		}
        	}
          $db->Execute("update " . TABLE_ORDERS . "
                        set shipping_num ='".$shippingNum."', last_modified = now()" . $extrme_update . "
                        where orders_id = " . $oID);
          $db->Execute("update " . TABLE_ORDERS . "
                        set orders_status = '" . zen_db_input($status) . "', last_modified = now()
                        where orders_id = " . $oID);
          $db->Execute('UPDATE ' . TABLE_ORDERS_PACKING_SLIP . '
          				SET trance_number = ",' . $shippingNum . ',"
          				WHERE orders_id = ' . $oID);
			if($status == 2){
				$order = new order($oID);
				$cu_info = array($check_status->fields['customers_email_address'],$check_status->fields['customers_firstname'],$check_status->fields['customers_lastname']);
				present_promotion_coupon($check_status->fields['customers_id'], $oID, $cu_info);

				//	invite frineds 20150422 xiaoyong.lv
				include('../includes/functions/extra_functions/functions_invite_friends.php');
				$fun_inviteFriends->sendCoupon($oID);
				
				$coupon_customers_array = array('customers_id' => $check_status->fields['customers_id'], 'customers_email_address' => $check_status->fields['customers_email_address'], 'language_id' => $check_status->fields['language_id'], 'customers_name' => $check_status->fields['customers_name']);
				$send_coupon = send_coupon_for_first_order($oID, $status, $coupon_customers_array);
			}
          
          $notify_comments = '';
          if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on') && zen_not_null($comments)) {
            $notify_comments = EMAIL_TEXT_COMMENTS_UPDATE . $comments . "\n\n";
          }
          
          if($is_old_customers === 0 && in_array($status, explode(',', MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP))){
              $db->Execute('update ' . TABLE_CUSTOMERS . ' set is_old_customers = 1 where customers_id= "' . $check_status->fields['customers_id'] . '"' );
          }
          
          /*对这些处理的order进行balance返还         排除2次操作进行的2次返还*/  
          if($check_status->fields['orders_status'] != 0 && $check_status->fields['orders_status'] !=5 && $check_status->fields['orders_status'] != 41){
	          if(($status == 0 || $status == 5 || $status == 41) && $oID > 0){
	          	$check_balance = $db->Execute("select `value` from ".TABLE_ORDERS_TOTAL." where orders_id=".$oID." and class='ot_cash_account'");
	          
	          	if($check_balance->fields['value']){
	          		$check_refund_existed = $db->Execute("select cac_cash_id from ".TABLE_CASH_ACCOUNT." where cac_order_create=2 and from_order=".$oID);

	          		if($check_refund_existed->RecordCount()==0){
	          			$currency_amount = zen_change_currency($check_balance->fields['value'], 'USD', $check_status->fields['currency']);
	          			$refund_balace_data = array(
	          					'cac_customer_id'=>$check_status->fields['customers_id'],
	          					'cac_amount'=>$currency_amount,    
	          					'cac_currency_code'=>$check_status->fields['currency'],
	          					'cac_create_date'=>date('Y-m-d H:i:s'),
	          					'cac_status'=>'A',
	          					'cac_memo'=>TEXT_REFUND_BALANCE.$oID,
	          					'cac_order_create'=>1,
	          					'from_order'=>$oID
	          			);
	          			//var_dump($refund_balace_data);exit;
	          			zen_db_perform(TABLE_CASH_ACCOUNT, $refund_balace_data);
	          		}
	          	}
	        /*   	$sql_declare_id = "select declare_orders_id,orders_id from " . TABLE_DECLARE_ORDERS . " where orders_id = ".$oID;
	          	$sql_declare = $db->Execute($sql_declare_id);
	          	if ($sql_declare->RecordCount() > 0){
	          		$db->Execute('delete from ' . TABLE_DECLARE_ORDERS . '  where orders_id = '.$oID.' ');
	          	} */
	          }
         }

         //delete erp data
         if(intval($check_status->fields['orders_status']) ==2 && in_array(intval($status), array(1,5,0))  ){
         	$check_erp_data = $db->Execute("select id from erp_notice_process where process_type=1 and is_processed=0 and item_id=".$oID);
         	if($check_erp_data->RecordCount()>0){
         		$db->Execute("delete from erp_notice_process where id=".$check_erp_data->fields['id']);
         	}
         }
          //send emails
		  //jessa 2009-11-20 �ж϶�����״̬�Ƿ�Ϊshipped���������������ڣ������������
		  
		  if ($status == 3){
			  $message = STORE_NAME . "\n" . $order_status_config[$lang]['EMAIL_SEPARATOR'] . "\n" .
			  $order_status_config[$lang]['EMAIL_TEXT_ORDER_NUMBER'] . ' ' . $oID . "\n\n" .
			  $order_status_config[$lang]['EMAIL_TEXT_INVOICE_URL'] . ' ' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n\n" .
			  //jessa 2009-11-19 add the following code
			  $order_status_config[$lang]['EMAIL_TEXT_DATE_SHIPPED'] . ' ' . zen_date_long_order(date('Y-m-d H:i:s'),$lang) . "\n\n" .		  
			  //eof jessa 2009-11-20
			  $order_status_config[$lang]['EMAIL_TEXT_DATE_ORDERED'] . ' ' . zen_date_long_order($check_status->fields['date_purchased'],$lang) . "\n\n" .
			  strip_tags($notify_comments) .
			  $order_status_config[$lang]['EMAIL_TEXT_STATUS_UPDATED'] . sprintf($order_status_config[$lang]['EMAIL_TEXT_STATUS_LABEL'], zen_get_orders_status_by_lang($status,($lang+1)) ) .
			  $order_status_config[$lang]['EMAIL_TEXT_STATUS_PLEASE_REPLY'];
		  }
		  else{
		  			  $message = STORE_NAME . "\n" . $order_status_config[$lang]['EMAIL_SEPARATOR'] . "\n" .
			  $order_status_config[$lang]['EMAIL_TEXT_ORDER_NUMBER'] . ' ' . $oID . "\n\n" .
			  $order_status_config[$lang]['EMAIL_TEXT_INVOICE_URL'] . ' ' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n\n" .
			  $order_status_config[$lang]['EMAIL_TEXT_DATE_ORDERED'] . ' ' . zen_date_long_order($check_status->fields['date_purchased'],$lang) . "\n\n" .
			  strip_tags($notify_comments) .
			  $order_status_config[$lang]['EMAIL_TEXT_STATUS_UPDATED'] . sprintf($order_status_config[$lang]['EMAIL_TEXT_STATUS_LABEL'], zen_get_orders_status_by_lang($status,($lang+1)) ) .
			  $order_status_config[$lang]['EMAIL_TEXT_STATUS_PLEASE_REPLY'];
		  }
//eof jessa 2009-11-20
          $html_msg['EMAIL_CUSTOMERS_NAME']    = $order_status_config[$lang]['TEXT_DEAR_WORDS'].' '.$check_status->fields['customers_name'];
          $html_msg['EMAIL_TEXT_ORDER_NUMBER'] = $order_status_config[$lang]['EMAIL_TEXT_ORDER_NUMBER'] . ' ' . $oID;
          $html_msg['EMAIL_TEXT_INVOICE_URL']  = '<a href="' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') .'">'.str_replace(':','',$order_status_config[$lang]['EMAIL_TEXT_INVOICE_URL']).'</a>';
		  //jessa 2009-11-19 add the shipped date
		  if ($status == 3){
			$html_msg['EMAIL_TEXT_DATE_SHIPPED'] = $order_status_config[$lang]['EMAIL_TEXT_DATE_SHIPPED'] . ' ' . zen_date_long_order(date('Y-m-d H:i:s'),$lang) . '(Beijing Time (CST) +0800)';
		  }
		  else{
			$html_msg['EMAIL_TEXT_DATE_SHIPPED'] = str_replace('\n', '', '');
		  }
		  //eof jessa 2009-11-19
          $html_msg['EMAIL_TEXT_DATE_ORDERED'] = $order_status_config[$lang]['EMAIL_TEXT_DATE_ORDERED'] . ' ' . zen_date_long_order($check_status->fields['date_purchased'],$lang) . '(Beijing Time (CST) +0800)';
          $html_msg['EMAIL_TEXT_STATUS_COMMENTS'] = nl2br($notify_comments);
          $html_msg['EMAIL_TEXT_STATUS_UPDATED'] = str_replace('\n','', $order_status_config[$lang]['EMAIL_TEXT_STATUS_UPDATED']);
          $html_msg['EMAIL_TEXT_STATUS_LABEL'] = str_replace('\n','', sprintf($order_status_config[$lang]['EMAIL_TEXT_STATUS_LABEL'], zen_get_orders_status_by_lang($status,($lang+1)) ));
          $html_msg['EMAIL_TEXT_NEW_STATUS'] = zen_get_orders_status_by_lang($status,($lang+1));
          $html_msg['EMAIL_TEXT_STATUS_PLEASE_REPLY'] = str_replace('\n','', $order_status_config[$lang]['EMAIL_TEXT_STATUS_PLEASE_REPLY']);
          $html_msg['EMAIL_STORE_NAME']=$order_status_config[$lang]['STORE_NAME'];
          $html_msg['EMAIL_FOOTER_COPYRIGHT']=$order_status_config[$lang]['EMAIL_FOOTER_COPYRIGHT'];
          $html_msg['EMAIL_DISCLAIMER']=sprintf($order_status_config[$lang]['EMAIL_DISCLAIMER'],'<a href="mailto:' . $order_status_config[$lang]['EMAIL_NOTIFICATIONS_FROM'] . '">'. $order_status_config[$lang]['EMAIL_NOTIFICATIONS_FROM'] .' </a>');
          $html_msg['EMAIL_SPAM_DISCLAIMER']=$order_status_config[$lang]['EMAIL_SPAM_DISCLAIMER'];
          $customer_notified = '0';
          if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
            zen_mail($check_status->fields['customers_name'], $check_status->fields['customers_email_address'], $order_status_config[$lang]['EMAIL_TEXT_SUBJECT'] . ' #' . $oID, $message, $order_status_config[$lang]['STORE_NAME'], $order_status_config[$lang]['EMAIL_NOTIFICATIONS_FROM'], $html_msg, 'order_status');
            $customer_notified = '1';
            //send extra emails
            if (SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_STATUS == '1' and SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO != '') {
              zen_mail('', SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO, EMAIL_TEXT_SUBJECT . ' #' . $oID, $message, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status_extra');
            }
          }
          $operator = zen_db_input($_SESSION["admin_name"]);

       
          $db->Execute("insert into " . TABLE_ORDERS_STATUS_HISTORY . "
                      (orders_id, orders_status_id, date_added, customer_notified, comments, modify_operator)
                      values (" . $oID . ",
                      '" . zen_db_input($status) . "',
                      now(),
                      '" . zen_db_input($customer_notified) . "',
                      '" . zen_db_input($comments)  . "' , 
          		      '" . $operator . "'
          			  )");
        
          $order_updated = true;
        }
		$lds_customers_level = $db->Execute('Select customers_level
										       From ' . TABLE_CUSTOMERS .'
										      Where customers_id = ' . $check_status->fields['customers_id']);
		$customers_level = $lds_customers_level->fields['customers_level']; 
     	if ($status == 3 Or $status == 2 Or $status == 4 Or $status == 1 Or $status == 42){
  			include(DIR_WS_CLASSES . 'customers_group.php');
        	$customers_group = new customers_group();
        	$customers_group->correct_group($check_status->fields['customers_id']);
	    	if ($customers_level < CUSTOMERS_TOP_LEVEL && $customers_level < 20) {
	    		$customers_level = 20;
	    		zen_change_customers_level($check_status->fields['customers_id'], $customers_level);
	    	}
        }
        if ($order_updated == true) {
         if ($status == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) {
            // adjust download_maxdays based on current date
            $zc_max_days = date_diff($check_status->fields['date_purchased'], date('Y-m-d H:i:s', time())) + DOWNLOAD_MAX_DAYS;
            $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='" . $zc_max_days . "', download_count='" . DOWNLOAD_MAX_COUNT . "' where orders_id=" . $oID;
            $db->Execute($update_downloads_query);
          }
          $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }
        //zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        zen_redirect($_SERVER["HTTP_REFERER"]);
        break;
    case 'discount_note':
        $discount_note_text=$_POST['discount_note_text'];
        if($discount_note_text !=''){
        	$order_discount_data = array(
        		'orders_id' => $oID,
        		'orders_discount_value' => zen_db_prepare_input($discount_note_text),
        		'orders_discount_date' => 'now()'
        	);
        	zen_db_perform(TABLE_ORDERS_DISCOUNT_NOTE, $order_discount_data);
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
     case 'extra_amount':
          $extra_amount = (float)strtr($_POST['extra_amount'], [',' => '']);
          $order_total=new order_total($oID);
          $order_total->add_extra_amount($oID, $extra_amount) ;
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
          break;
     case 'deleteconfirm':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')), 'NONSSL'));
        }
        if (isset($_POST['ordersCheckbox'])){
        	include(DIR_WS_CLASSES . 'customers_group.php');
        	$customers_group = new customers_group();        	
        	for ($i = 0, $n = sizeof($_POST['ordersCheckbox']); $i < $n; $i++){
        		$oID = zen_db_prepare_input($_POST['ordersCheckbox'][$i]);
        		zen_order_to_remove($oID, true);
        		$result  = $db->Execute("select customers_id from " . TABLE_ORDERS . " where orders_id = " . $oID);
        		$customers_group->correct_group($result->fields['customers_id']);
        	}
        }elseif (isset($_GET['oID'])){
        	//$oID = zen_db_prepare_input($_GET['oID']);
        	zen_order_to_remove($oID, $_POST['restock']);
        	include(DIR_WS_CLASSES . 'customers_group.php');
        	$customers_group = new customers_group();
        	$result  = $db->Execute("select customers_id from " . TABLE_ORDERS . " where orders_id = " . $oID);
        	$customers_group->correct_group($result->fields['customers_id']);
        }        
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')), 'NONSSL'));
        break;
      case 'delete_cvv':
        $delete_cvv = $db->Execute("update " . TABLE_ORDERS . " set cc_cvv = '" . TEXT_DELETE_CVV_REPLACEMENT . "' where orders_id = " . $oID);
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'mask_cc':
        $result  = $db->Execute("select cc_number from " . TABLE_ORDERS . " where orders_id = " . $oID);
        $old_num = $result->fields['cc_number'];
        $new_num = substr($old_num, 0, 4) . str_repeat('*', (strlen($old_num) - 8)) . substr($old_num, -4);
        $mask_cc = $db->Execute("update " . TABLE_ORDERS . " set cc_number = '" . $new_num . "' where orders_id = " . $oID);
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doRefund':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doRefund')) {
              $module->_doRefund($oID);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doAuth':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doAuth')) {
              $module->_doAuth($oID, $order->info['total'], $order->info['currency']);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doCapture':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doCapt')) {
              $module->_doCapt($oID, 'Complete', $order->info['total'], $order->info['currency']);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doVoid':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doVoid')) {
              $module->_doVoid($oID);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print"
	href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<script language="javascript" type="text/javascript">
function couponpopupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
function check_extra_amount_form(){
	var errorflag = false;
	var errormessage = '';
	var extra_amount= $('#extra_amount').val().replace(',', '').replace('.', '');
	if(extra_amount=='' || extra_amount==0){
	    errorflag = true;
		errormessage += '调节金额不能为空\n';
	}else if(isNaN(extra_amount)){
		errorflag = true;
		errormessage += '调节金额必须是数字\n';
	}
	if(!errorflag){
		$.ajax({
			type:'POST',
			data:"action=check_amount&orders_id="+$('#orders_id').val()+"&adjust_amout="+$('#extra_amount').val()+"&currency="+$('#orders_currency_value').val(),
			url:'../ajax_check_order_amount.php',
			dataType:'json',
			success:function(data){				
				if(data){
					errormessage += '添加数值导致订单金额为负，请调整！\n';
					errorflag = true;
					alert(errormessage);
					return false;
				}else{
				   document.getElementById('extra_amount_form').submit();
				   //errorflag = true;
				   return true;
			   }				           
			}
		});
	} else  {
		alert(errormessage);
		return false;
	}
    return false;
}
function check_update_info(){
	var status = $("select[name=status]").val();
	var paymethod = $("select[name=paymethod]").val();
	var transaction = $("input[name=transaction_id]").val();
	var display_status = false;
	var error = false;
	$(".payment_info").each(function(){
		var display = $(this).css('display');
		if(display != 'none'){
			display_status = true;
		}
	});
	
	if(status == 2 && display_status){
/* 		if(paymethod == '' ){
			alert('请选择付款方式!');
			error = true;
		} */
		if((paymethod=='paypalmanually'||paymethod=='paypalwpp')&& transaction == ''){
			alert('请填写交易ID！');
			error = true; 
		}
	}
 
	return !error;
}

</script>
<style>
.specialCustomerTable ul{padding-left:0px;}
</style>
<script type="text/javascript">
            $(document).ready(function(){
              $("form[name='status']").submit(function(){ $(".order_update_class").attr("disabled","disabled");return true;});
                $(".red_points").bind('click',function(){
                    var did = $(this).attr('did');
                	$(this).remove();
                    $.ajax({
                        type:"POST",
                        url:"response.php",
                        data:"did="+did,
                        success:function(msg){
                            msg = eval('('+msg+')');                          
                            if(msg.status == 1){
                                $(this).remove();
                            }
                        }
                    });
                });
                $('#search_input').change(function(){
            		$('#search_oID').val($('#search_input').val());
            	});
            	$("select[name=status]").change(function(){
            		var status = $(this).val();
            		var class_name = $(this).attr("destinc-class");
            		var css_style = 'table-row';

            		if(class_name == 'payment_info_edit' ){
            			css_style = 'inline-block';
            		}
            		
            		if(status == 2){
            			$('.payment_info').css('display' , css_style);
            			$('.payment_info').removeAttr('disabled');
            			$("input[name=transaction_id]").attr("disabled","disabled");
            			$("input[name=transaction_id]").css("background","#CCCCCC");
            			$("select[name=paymethod]").change(function(){
            			var paymethod = $(this).val();
            				if(paymethod=='paypalmanually'||paymethod=='paypalwpp'){
            					$("input[name=transaction_id]").removeAttr("disabled");
            					$("input[name=transaction_id]").css("background",'');					
            					}
            				else{
            					$("input[name=transaction_id]").attr("disabled","disabled");
            					$("input[name=transaction_id]").css("background","#CCCCCC");
            					$("input[name=transaction_id]").val("");					
            						}				
            				})				
            		}else{
            			$('.payment_info').css('display','none');
            			$('.payment_info').attr({'disabled':'disabled'});
            		}
            	});
            	$('.cart_total_info').live('mouseover', function(){
            		$(this).find('.successtips_total').show();
            	}).live('mouseout', function(){
            		$(this).find('.successtips_total').hide();
            	});

            });
        </script>
<style>
input:read-only{
	background-color: #CFC6C6;
    border: 1px;
}
.alert{
color:red;
}
.icon_question{display:inline-block; width:16px; height:18px; background:url(images/questions.png) no-repeat;position: relative;top: 5px;}
.cart_total_info{position:relative;cursor:pointer;}
.successtips_total{width:300px;padding: 10px; border:1px solid #d0d1a9;position:absolute;background:#FFC;top:23px;z-index:100;text-align:left;color:#333;left:-145px;display:none;}
.successtips_total span{width:0; height:0; font-size:0; overflow:hidden; position:absolute;}
.successtips_total span.bot{border-width:8px;border-style:dashed dashed solid dashed;border-color: transparent transparent #d0d1a9 transparent;left:148px;top:-16px;}
.successtips_total span.top{border-width:8px;border-style: dashed dashed solid dashed;border-color: transparent transparent #ffc transparent;left:148px;top:-14px;}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<div class="header-area">
<?php
  require(DIR_WS_INCLUDES . 'header.php');

?>
</div>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
		<!-- body_text //-->
		<!-- search -->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
     <tr>
	<td>
		<table border="0" width="100%" cellspacing="5" cellpadding="0">
			<?php echo zen_draw_form('search_combine', FILENAME_ORDERS, '', 'get', '', true); ?>
			<tr>
				<td width="50%" class="pageHeading" valign="bottom" style="vertical-align: inherit;font-size:30px;"><?php echo $action == 'edit' ? '<a href="javascript:history.back()">' . zen_image_button('button_back.gif', IMAGE_BACK) . '</a>' : HEADING_TITLE; ?><?php echo $action == 'edit' ? '&nbsp;&nbsp;<a href="' .zen_href_link(FILENAME_ORDERS, 'cID=' . $customers_id, 'NONSSL') . '" class="noprint"><img src="../includes/templates/cherry_zen/images/backorder.jpg"  height="23px"/></a>' : ''; ?></td>
				<td width="25%" align="right">
					
						<table border="0" cellspacing="5" cellpadding="0">
							<tr>
								<td>
									<?php
										echo HEADING_TITLE_STATUS;
									?>
								</td>
								<td class="smallText" align="right">
									<?php
										echo zen_draw_pull_down_menu('st', array_merge(array(array('id' => '', 'text' => 'All')), $orders_statuses), $_GET['st'], 'style="width:163px;"');
										echo zen_hide_session_id();
									?>
								</td>
							</tr>
							<tr>
								<td>
									Payment:
								</td>
								<td class="smallText" align="right">
									<?php
										echo zen_draw_pull_down_menu('py', array_merge(array(array('id' => '', 'text' => 'All')), $orders_payment), $_GET['py'] , 'style="width:163px;"');
										echo zen_hide_session_id();
									?>
								</td>
							</tr>
							<tr>
								<td>
									Time：
								</td>
								<td class="smallText" align="right">
									<?php
									  echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_GET['starttime']))?$_GET['starttime']: '', 'onClick="WdatePicker();"')) . '&nbsp;--';
									?>
									
									<?php
									  echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_GET['stoptime']))?$_GET['stoptime']: '', 'onClick="WdatePicker();"  '))
									?>
								</td>
							</tr>
							<tr>
								<td>
									姓名:
								</td>
								<td align="right">
									<?php echo zen_draw_input_field('customers_name',$_GET['customers_name'], 'id="customers_name" , size="24px" placeholder="对客户姓名进行模糊搜索"' , false, 'text', false)?>
								</td>
							</tr>
							<tr>
								<td>
									地址:
								</td>
								<td align="right">
									<?php echo zen_draw_input_field('address',$_GET['address'], 'id="address" , size="24px" placeholder="对客户地址进行模糊搜索"' , false, 'text', false)?>
								</td>
							</tr>
							<tr>
								<td>订单金额:</td>
								<td align="right">
									<?php
										echo zen_draw_pull_down_menu('ot', array(array('id' => '', 'text' => 'All'), array('id' => 'eq0', 'text' => '=0'), array('id' => 'gt0', 'text' => '>0')), $_GET['ot'], 'style="width:163px;"');
										echo zen_hide_session_id();
									?>

								</td>
							</tr>
						</table>
				</td>
				<td width="25%" align="right">
					<table border="0" cellspacing="5" cellpadding="0">
						<tr>
							<td>Language:</td>
							<td style="text-align: right;">
								<?php 
									$langs = zen_get_languages();
									for ($i = 0, $n = sizeof($langs); $i < $n; $i++) {
										$langs_arr[$i] = array('id' => $langs[$i]['id'],'text' => $langs[$i]['directory']);
									}
									echo zen_draw_pull_down_menu('searchLang', array_merge(array(array('id' => '', 'text' => 'All')), $langs_arr), $_GET['searchLang'], 'style="width:163px;"');
								?>
							</td>
						</tr>
						<tr>
							<td>
								From:
							</td>
							<td style="text-align: right;"><?php 
							$from_arr = array(array('id'=>'0','text'=>'Web'), array('id'=>'1','text'=>'Mobile'));
							echo zen_draw_pull_down_menu('from', array_merge(array(array('id' => '', 'text' => 'All')), $from_arr), $_GET['from'] , 'style="width:163px;"');?></td>
						</tr>
						<tr>
							<td class="smallText">
								<?php
									echo 'Shipping Method:';
								?>
							</td>
							<td align="right">
								<?php
									echo zen_draw_pull_down_menu('sm', array_merge(array(array('id' => '', 'text' => 'All')), $shipping_methods_enabled), $_GET['sm'] , 'style="width:163px;"');
									echo zen_hide_session_id();
								?>
							</td>
						</tr>
						<tr>
							<td>客户ID：</td>
							<td><?php echo zen_draw_input_field('cID',$_GET['cID'], 'id="id_search" , size="24px"' , false, 'text', false)?></td>
						</tr>
						<tr>
							<td>邮箱：</td>
							<td><?php echo zen_draw_input_field('customers_email_address', $_GET['customers_email_address'], 'size="24px" style="color:#999;" placeholder="对客户邮箱进行模糊搜索"');?></td>
						</tr>
						<tr>
							<td></td>
							<td class="smallText" align="right"><button style="CURSOR: pointer; background: url('includes/languages/english/images/buttons/button_search_cn.png') no-repeat; width:70px;height:20px;border:0px;background-size: 70px 20px;"></button><br/></td>
						</tr>
					</table>
				</td>
			</tr>
			<?php echo '</form>';?>
			<?php echo zen_draw_form('search_order', FILENAME_ORDERS, '', 'get', '', true); ?>
			<tr>
				<td></td>
				<td></td>
				<td align="right">订单号：
				<?php  
				  echo zen_draw_input_field('', '', 'id="search_input" size="24px"', false, 'text', false);
				?>
				<?php 
					echo '<input type="hidden" name="action" value="edit">';
				  	echo '<input type="hidden" name="oID" value="" id="search_oID">';
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class="smallText" align="right">
					<?php echo '<button style="CURSOR: pointer; background: url(\'includes/languages/english/images/buttons/button_search_cn.png\') no-repeat; width:70px;height:20px;border:0px;background-size: 70px 20px;"></button>';?>
				</td>
			</tr>
			<?php echo '</form>';?>
		</table>
	</td>
</tr>
<!-- search EOF -->
<?php //} ?>
<?php 
  if (($action == 'edit') && ($order_exists == true)) {
//  var_dump($oID);
    $order = new order($oID);
  //  var_dump($order->products);
    //elseif($order->products[$i]['dailydeal_price']){
    
    /* if( $order->products[$i]['dailydeal_promotion_start_time']<=$order->info['date_purchased']<=$order->products[$i]['dailydeal_promotion_end_time'] && $order->products[$i]['dailydeal_is_forbid'] == 10){
     $product_discount = "$".$order->products[$i]['dailydeal_price'];
    } */
    if ($order->info['payment_module_code']) {
      if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
        require(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
        require(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
        $module = new $order->info['payment_module_code'];
//        echo $module->admin_notification($oID);
      }
    }
    
    $customers_query_raw = "select customers_firstname,customers_lastname,saler_remarks,customers_business_web from " . TABLE_CUSTOMERS ." where customers_id =". $order->customer['id'];
    $customers = $db->Execute($customers_query_raw);
?>
	       <tr>
			   <td width="100%">
				  <table border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
							<td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
						</tr>
				  </table>
			    </td>
		    </tr>
			<tr>
				<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td colspan="3"><?php echo zen_draw_separator(); ?></td>
					</tr>
					<tr>
						<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td class="main" valign="top"><strong><?php echo ENTRY_CUSTOMER; ?></strong></td>
								<td class="main"><?php echo zen_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'); ?></td>
							</tr>
							<tr>
								<td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
							</tr>
							<tr>
								<td class="main"><strong><?php echo ENTRY_TELEPHONE_NUMBER; ?></strong></td>
								<td class="main"><?php echo $order->customer['telephone']; ?></td>
							</tr>
							<tr>
								<td class="main"><strong><?php echo ENTRY_EMAIL_ADDRESS; ?></strong></td>
								<td class="main"><?php echo ($_SESSION['show_customer_email'] ? '<a href="mailto:' . $order->customer['email_address'] . '">' . $order->customer['email_address'] . '</a>' : strstr($order->customer['email_address'] , '@', true) . '@'); ?></td> </td>
							</tr>
							<tr>
                                <td class="main"><strong><?php echo '客户ID:'; ?></strong></td>
                                <td class="main"><?php echo $order->customer['id'];?></td>
                            </tr>
							<tr>
								<td class="main"><strong><?php echo TEXT_INFO_IP_ADDRESS; ?></strong></td>
								<td class="main"><?php echo $order->info['ip_address']; ?> <?php echo iconv("GBK", "UTF-8", $iplocal->getLocation($order->info['ip_address']));?></td>
							</tr>
						</table>
						</td>
						<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td class="main" valign="top"><strong><?php echo ENTRY_SHIPPING_ADDRESS; ?></strong></td>
								<td class="main"><?php echo zen_address_format($order->delivery['format_id'], $order->delivery , 1, '', '<br />'); ?></td>
							</tr>
						</table>
						</td>
						<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td class="main" valign="top"><strong><?php echo ENTRY_BILLING_ADDRESS; ?></strong></td>
								<td class="main"><?php echo zen_address_format($order->billing['format_id'], $order->billing , 1, '', '<br />'); ?></td>
							</tr>
						</table>
						</td>
					</tr>
					<?php 
					$sql_vip_current = "SELECT customers_group_pricing ,group_percentage FROM t_customers c LEFT JOIN t_group_pricing g ON c.customers_group_pricing = g.group_id WHERE customers_id = ".$order->customer['id'];
					$sql_vip_current_result=$db->Execute($sql_vip_current);
					$vip_current = (int)$sql_vip_current_result->fields['group_percentage']."%";
					
					$channel_check_sql = "SELECT channel_id FROM " . TABLE_CHANNEL . " WHERE channel_customers_id = " . $order->customer['id'] . " and channel_status in (10 , 20)";
					$channel_check_query = $db->Execute($channel_check_sql);
					if($channel_check_query->RecordCount() > 0){
						$vip_current = '15%';
					}
					
					$get_vip_amount_sql="select value from ".TABLE_ORDERS_TOTAL." where class='ot_group_pricing' and orders_id = ".$orders->fields['orders_id'];
					$get_vip_amount=$db->Execute($get_vip_amount_sql);
					if($get_vip_amount->RecordCount()>0){
						$get_sub_total = $db->Execute("select gp.group_percentage from ".TABLE_ORDERS." o, ". TABLE_GROUP_PRICING ." gp where orders_id =  ".$orders->fields['orders_id']." and gp.group_id = o.order_customers_group_pricing limit 1");
						if ($get_sub_total->fields['group_percentage']>0) {
							$vip_discount = round($get_sub_total->fields['group_percentage'], 0)."%";
						}elseif ($get_sub_total->fields['group_percentage']==0){						
							$get_total_sql = "select value from ".TABLE_ORDERS_TOTAL." where class='ot_subtotal' and orders_id = ".$orders->fields['orders_id'];
							$get_total = $db->Execute($get_total_sql);
							
							$get_special_discount_sql = "select value from ".TABLE_ORDERS_TOTAL." where class='ot_big_orderd' and orders_id = ".$orders->fields['orders_id'];
							$get_special_discount = $db->Execute($get_special_discount_sql);
							
							if($get_special_discount->RecordCount() == 0){
								$vip_discount = (round($get_vip_amount->fields['value']/$get_total->fields['value'],2)*100)."%";
							}else{
								$vip_discount = (round($get_vip_amount->fields['value']/($get_total->fields['value'] - $get_special_discount->fields['value']),2)*100)."%";
							}
						}else{
							$vip_discount="6.01$";
						}
					}else{
						$vip_discount = "&nbsp";
					}
					?>
					<tr><td colspan="3">该客户当前VIP折扣：<?php echo $vip_current;?></td></tr>
				</table>
				</td>
			</tr>
			 <?php if($customers->fields['customers_business_web'] != ''){
             			$website_str = $customers->fields['customers_business_web'];
             			if(strpos($website_str, 'http') === false){
             				$website_str = 'http://' . $website_str;
             			}
            
             	?>
              <tr>
                <td class="main"><strong><?php echo 'Business Web：'; ?></strong>
                <a target="_blank" href="<?php echo $website_str;?>"><?php echo $customers->fields['customers_business_web'];?></a></td>
              </tr>
             <?php  } ?>
			 <?php 
		      	 	 
		      	if($customers->fields['saler_remarks'] != ''){
					?>
					   <tr>
				           <td class="main"><strong>销售备注:</strong><?php echo '   '.$customers->fields['saler_remarks'];?></td>
				       </tr>
					<?php 
		      	}
		      ?>
			<tr>
				<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
			</tr>
			<tr>
				<td class="main"><strong><?php echo ENTRY_ORDER_ID . $oID; ?></strong></td>
			</tr>
			<tr>
				<td>
				<table border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td class="main"><strong><?php echo ENTRY_DATE_PURCHASED; ?></strong></td>
						<td class="main"><?php echo zen_date_long($order->info['date_purchased']); ?></td>
					</tr>
					<tr>
						<td class="main"><strong><?php echo ENTRY_PAYMENT_METHOD; ?></strong></td>
						<td class="main"><?php echo $order->info['payment_method']; ?></td>
					</tr>
<?php
    if (zen_not_null($order->info['cc_type']) || zen_not_null($order->info['cc_owner']) || zen_not_null($order->info['cc_number'])) {
?>
          <tr>
						<td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
					</tr>
					<tr>
						<td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
						<td class="main"><?php echo $order->info['cc_type']; ?></td>
					</tr>
					<tr>
						<td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
						<td class="main"><?php echo $order->info['cc_owner']; ?></td>
					</tr>
					<tr>
						<td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
						<td class="main"><?php echo $order->info['cc_number'] . (zen_not_null($order->info['cc_number']) && !strstr($order->info['cc_number'],'X') && !strstr($order->info['cc_number'],'********') ? '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_ORDERS, '&action=mask_cc&oID=' . $oID, 'NONSSL') . '" class="noprint">' . TEXT_MASK_CC_NUMBER . '</a>' : ''); ?>
						<td>
					</tr>
					<tr>
						<td class="main"><?php echo ENTRY_CREDIT_CARD_CVV; ?></td>
						<td class="main"><?php echo $order->info['cc_cvv'] . (zen_not_null($order->info['cc_cvv']) && !strstr($order->info['cc_cvv'],TEXT_DELETE_CVV_REPLACEMENT) ? '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_ORDERS, '&action=delete_cvv&oID=' . $oID, 'NONSSL') . '" class="noprint">' . TEXT_DELETE_CVV_FROM_DATABASE . '</a>' : ''); ?>
						<td>
					</tr>
					<tr>
						<td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
						<td class="main"><?php echo $order->info['cc_expires']; ?></td>
					</tr>
<?php
    }
?>
        </table>
				</td>
			</tr>
<?php
      if (method_exists($module, 'admin_notification')) {
?>
      <tr>
				<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
			</tr>
			<tr>
        <?php echo $module->admin_notification($oID); ?>
      </tr>
			<tr>
				<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
			</tr>
<?php
}
?>
      <tr>
				<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr class="dataTableHeadingRow">
						<td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
						<td class="dataTableHeadingContent"><?php echo "Product Image"; ?></td>
						<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
						<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_WEIGHT; ?></td>
						<td class="dataTableHeadingContent" align="right">Original Price</td>
						<td class="dataTableHeadingContent" align="right">Discount</td>
						<td class="dataTableHeadingContent" align="right">Discount Price</td>
			<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
					</tr>
<?php
      
		for($i = 0, $n = sizeof ( $order->products ); $i < $n; $i ++) {
			$product_id = $order->products[$i]['id'];
			$product_name = $order->products[$i]['name'];
			$product_qty = $order->products [$i] ['qty'];
			$product_final_price = $order->products[$i]['final_price'];
      $product_each_price = $currencies->format_cl ( zen_add_tax ( $order->products[$i] ['final_price'], zen_get_tax_rate ( $order->products[$i] ['tax'] ) ),true, $order->info['currency'], $order->info['currency_value'] );
			$product_weight = $order->products [$i] ['weight'];
			//$product_link = ($order->products[$i]['status'] ? '<a target = "_blank" href = "'.HTTP_SERVER.'/index.php?main_page=order_products_snapshot&oID=' . $oID . '&pID='.$product_id.'">'.$product_name.'</a>' : $product_name);/*快照 改为商品详细页*/
			$product_link = ($order->products[$i]['status'] ? '<a target = "_blank" href = "'.HTTP_SERVER.'/index.php?main_page=product_info&products_id=' . $product_id. '">'.$product_name.'</a>' : $product_name);
			//zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $_GET ['products_id'] )
			if ($order->products[$i]['product_is_free'] == '1') $product_price = 0;
			$product_price = zen_get_products_discount_price_qty($product_id, $product_qty);
// 			$original_price = zen_get_products_discount_price_qty($product_id, $product_qty, 0, false);
			$original_price = $order->products[$i]['price'];
			if($product_final_price != $original_price){
				if($order->products[$i]['dailydeal_price'] && $order->products[$i]['dailydeal_promotion_start_time']<=$order->info['date_purchased'] &&$order->info['date_purchased']<=$order->products[$i]['dailydeal_promotion_end_time']&& $order->products[$i]['dailydeal_is_forbid']=='10'){

					$product_discount = "$".round($order->products[$i]['dailydeal_price'],2);
				}else {
					$product_discount = round(100 - round(($product_final_price / $original_price)* 100,2) ).'%';
				}	
			}else{
				$product_discount = "";
			}

			?>
		
		<tr class="dataTableRow">
			<td class="dataTableContent" valign="top" align="right"><?php echo $product_qty;?> x </td>
			<td class="dataTableContent" valign="top"><?php echo $product_link; if($order->products[$i]['note'] != '') echo '<br /><span style="color:red">商品备注:</span> '.$order->products[$i]['note'];?></td>
			<td class="dataTableContent" valign="top"><img src="<?php echo  'http://img.doreenbeads.com/bmz_cache/' . get_img_size($order->products[$i]['image'], 80, 80);?>"></td>
			<td class="dataTableContent" valign="top"><?php echo $order->products[$i]['model'];?></td>
			<td class="dataTableContent" align="right" valign="top"><?php echo $product_weight * $product_qty;?></td>
			<td class="dataTableContent" align="right" valign="top"><strong><?php echo $currencies->format($order->products[$i]['price'], true, $order->info['currency'], $order->info['currency_value']);?></strong></td>
			<td class="dataTableContent" align="right" valign="top"><strong><?php echo $product_discount;?></strong></td>
			<td class="dataTableContent" align="right" valign="top"><strong><?php echo $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']);?></strong></td>
			<td class="dataTableContent" align="right" valign="top"><?php echo $currencies->format(zen_add_tax($product_each_price, $order->products[$i]['tax']) * $order->products[$i]['qty'], false, $order->info['currency'], $order->info['currency_value']) ; ?></td>			
		</tr>	
		<?php 
		}
		?>
          <tr>
						<td align="right" colspan="5">
						<table border="0" cellspacing="0" cellpadding="2">
<?php
  for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
	$str  ='<tr>' . "\n";
	if ($order->totals[$i]['class'] == 'ot_group_pricing'){
	$str .=' <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title'] .'<font color="red">'."(".$vip_discount.")".'</font></td>' . "\n";
	}elseif($order->totals[$i]['class'] == 'ot_discount_coupon'){
      $coupon_query = $db->Execute("SELECT c.coupon_code FROM " . TABLE_COUPON_REDEEM_TRACK . " crt, " . TABLE_COUPONS . " c WHERE crt.order_id = " . $oID . ' AND c.coupon_id = crt.coupon_id LIMIT 1'); 
        if ($coupon_query->RecordCount() > 0) {
            $coupon_code = $coupon_query->fields['coupon_code'];
        }else{
            $coupon_code = '';
        }
        if ($coupon_code != '') {
            $coupon_title = '<a title="'.$coupon_code.'"><font size="1" color="#c89469"> [?] </font></a>';
        }
     $str .=' <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title']. $coupon_title .'</td>' . "\n";
  }elseif ($order->totals[$i]['class'] == 'ot_subtotal'){
		$sql_sum_no_discount = "SELECT products_price,products_quantity,final_price
								FROM " . TABLE_ORDERS_PRODUCTS . " op WHERE op.orders_id = ".$oID." and products_price<=final_price*1.05";
		$sql_sum_no_discount_result = $db->Execute($sql_sum_no_discount);
		while (!$sql_sum_no_discount_result->EOF){
			//$product_each_price = $currencies->format_cl ($order->products[$i]['final_price'],true, $order->info['currency'], $order->info['currency_value'] );
			$products_price =$currencies->format_cl($sql_sum_no_discount_result->fields['final_price'],false,$order->info['currency'], $order->info['currency_value']);
			$products_quantity = $sql_sum_no_discount_result->fields['products_quantity'];
			$sum_num += $products_price*$products_quantity;
			$sql_sum_no_discount_result->MoveNext();
		}
		if($sql_sum_no_discount_result){
			//$sum =$sum;
			//$product_each_price = $currencies->format_cl ($sum,true, $order->info['currency'], $order->info['currency_value'] );
			$sum = $currencies->format($sum_num, true, $order->info['currency'], $order->info['currency_value']);
		}else{
			$sum = "US $0.00";
		}
		
		$str .=' <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title'] . ' <span class="cart_total_info"><a class="icon_question" href="javascript:void(0)"></a>
								<div class="successtips_total">
								<span class="bot" style="padding:0px;"></span>
								<span class="top" style="padding:0px;"></span>
								<div style="margin: 5px;">Sub-Total = 正价商品总金额 + 折扣商品总金额</div>
    							<div style="margin: 5px;">' . $order->totals[$i]['text'] . ' = ' . $sum . ' + ' . $currencies->format($order->totals[$i]['value'] - $sum_num, true, $order->info['currency'], $order->info['currency_value']) . '</div>
								</div>
							</span> </td>' . "\n";
	}else{
	$str .=' <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title']. '</td>' . "\n";
	}
	if ($order->totals[$i]['class'] == 'ot_total' && $i < sizeof($order->totals) -1){
		$order->info['currency'] == 'USD' ? $ordertatal = '' :$ordertatal = '(us$ '.number_format($order->info['total'],2,'.',',').')';
		$str .= '<td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '<br>'.$ordertatal.'</td></tr>' . "\n";
	}else{
		$str .= '<td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '</td></tr>' . "\n";
	}
	$str .='</tr>' . "\n";
	echo $str;
}

?>
            </table>
						</td>
						<td colspan="4">
						<table border="0" cellspacing="0" cellpadding="2">
<?php
  for ($i = 0, $n = sizeof($order->weight_total); $i < $n; $i++) {
    echo '          <tr>' . "\n" .
         '            <td align="right" >' . $order->weight_total[$i]['title'] . '</td>' . "\n" .
         '            <td align="right" >' . $order->weight_total[$i]['text'] . '</td>' . "\n" .
         '          </tr>' . "\n";
  }
?>
        </table>
						</td>
					</tr>
				</table>
				</td>
			</tr>
<?php 
  // show downloads
  require(DIR_WS_MODULES . 'orders_download.php');
?>
      <tr><td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
	  <tr>
		  <td class="main">
			  <table width="100%" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				  <td>
					  <table border="1" cellspacing="0" cellpadding="5">
							<tr>
								<td class="smallText" align="center"><strong><?php echo TABLE_HEADING_DATE_ADDED; ?></strong></td>
								<td class="smallText" align="center"><strong><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></strong></td>
								<td class="smallText" align="center"><strong><?php echo TABLE_HEADING_STATUS; ?></strong></td>
								<td class="smallText" align="center"><strong>Operator</strong></td>
								<td class="smallText" align="center"><strong><?php echo TABLE_HEADING_COMMENTS; ?></strong></td>
							</tr>
							<?php
							    $orders_history = $db->Execute("select orders_status_id, date_added, customer_notified, comments , modify_operator
							                                    from " . TABLE_ORDERS_STATUS_HISTORY . "
							                                    where orders_id = " . zen_db_input($oID) . "
							                                    order by date_added");
							    if ($orders_history->RecordCount() > 0) {
							      while (!$orders_history->EOF) {
							        echo '          <tr>' . "\n" .
							             '            <td class="smallText" align="center">' . zen_datetime_short($orders_history->fields['date_added']) . '</td>' . "\n" .
							             '            <td class="smallText" align="center">';
							        if ($orders_history->fields['customer_notified'] == '1') {
							          echo zen_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
							        } else {
							          echo zen_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
							        }
							        echo '            <td class="smallText">' . $orders_status_array[$orders_history->fields['orders_status_id']] . '</td>' . "\n";
							        echo '            <td class="smallText">' . ($orders_history->fields['modify_operator'] == '' ? '/' : $orders_history->fields['modify_operator'] ) . '</td>' . "\n";
							        echo '            <td class="smallText" style= "word-break:break-all">' . nl2br($orders_history->fields['comments']) . '&nbsp;</td>' . "\n" .
							             '          </tr>' . "\n";
							        $orders_history->MoveNext();
							      }
							    } else {
							        echo '          <tr>' . "\n" .
							             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
							             '          </tr>' . "\n";
							    }
							?>
       					 </table>
        			</td>
			        <td align="left">
			        <input type=hidden value="<?php echo $oID;?>" id="orders_id">
			        <input type=hidden value="<?php echo $order->info['currency'];?>" id="orders_currency">
			        <input type=hidden value="<?php echo $order->info['currency_value'];?>" id="orders_currency_value">
					<?php 
						global $currencies;
					 	$extra_amount_query = $db->Execute("select orders_total_id, text, value,class
			                              from " . TABLE_ORDERS_TOTAL . "
			                              where orders_id = " . $oID);
						$extra_flag = false;
						$extra_amount = '0.00';			
						while (!$extra_amount_query->EOF) {
							$str=trim($extra_amount_query->fields['text']);
							$temp=array('1','2','3','4','5','6','7','8','9','0');			
							if(empty($str)){$extra_amount_query->MoveNext();}
							for($i=0;$i<strlen($str);$i++){
								if(in_array($str[$i],$temp)){
									break;
								}
							}	
              $str = str_replace('&euro;', '', $str);
							if(substr($extra_amount_query->fields['text'],0,1) == '-')	{		
								$amount = -substr($str,$i,strlen($str)-1);	
							}	else {
								$amount = substr($str,$i,strlen($str)-1);
							}		
							//$amount = round($extra_amount_query->fields['value']*$currencies->get_value($order->info['currency']), $currencies->currencies[$order->info['currency']]['decimal_places']);
							$extra_amount_array[] = array(
			                                'text' => $extra_amount_query->fields['text'],
			                                'class' => $extra_amount_query->fields['class'],
											'value' => $extra_amount_query->fields['value']);
							//$extra_amount_query->fields['class'] == 'ot_discount_amount' ? $extra_flag = true:'';
							//$extra_amount_query->fields['class'] == 'ot_discount_amount' ? $diacount_amount = $amount:'0.00';
							$extra_amount_query->fields['class'] == 'ot_extra_amount' ? $extra_flag = true:'';	
							$extra_amount_query->fields['class'] == 'ot_extra_amount' ? $extra_amount = $amount:'0.00';	
							$extra_amount_query->MoveNext();
						}
						//$orders_discount->fields['orders_discount_value']!='' ? $extra_flag = true:'';
					?>
					<?php if($order->info['orders_status'] == 1){ ?>			 
						 <?php  echo zen_draw_form('extra_amount_form', FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=extra_amount', 'post', 'id="extra_amount_form" onsubmit="return  check_extra_amount_form();"', true); ?> 
						 <p style="margin:3px;"><span style="font-weight: bold;padding-left:65px;">调节金额 : </span><?php echo $currencies->get_symbol_left($order->info['currency']); ?>
						 <input id="extra_amount" name="extra_amount" type="text" size="7" value="<?php echo $extra_amount?>"></input>
						 <?php 
							 if($extra_amount==0){
								echo '<button id="extra_amount_submit">提交</button>';
							 }else {
								echo '<button id="extra_amount_submit">更新</button>';
							 }
						 ?>
						 </p>
					 	 <?php echo '</form>'; ?>
					<?php } else {		 	
						 if($extra_amount_query->RecordCount()>0){
							 if($extra_amount){
								 //$amount = round($extra_amount*$currencies->get_value($order->info['currency']), $currencies->currencies[$order->info['currency']]['decimal_places']);
								 echo '<p style="margin:3px;"><span style="font-weight: bold;padding-left:65px;">调节金额: </span>'.$currencies->get_symbol_left($order->info['currency']).' ';
								 echo '<input style="background-color:#EEEEEE;border:1px #DCDCDC solid;" type="text" size="7" value="'.$extra_amount.'" readonly></input></p>';
							 }
						 }	 
					 }?>
					 <?php $orders_discount_sql = 'select orders_discount_value from '.TABLE_ORDERS_DISCOUNT_NOTE.' where orders_id='.$oID.' order by orders_discount_date desc limit 1 ';
						$orders_discount = $db->Execute($orders_discount_sql); ?>
					 	<?php  echo zen_draw_form('discount_note_form', FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=discount_note', 'post', 'onsubmit="return check_discount_note_form(); "', true); ?>
						<span style="font-weight: bold;vertical-align:top;padding-left:87px;">备注 : </span>
						<textarea id="discount_note_text" name="discount_note_text" wrap="soft" style="height: 100px;width: 250px;"><?php echo $orders_discount->fields['orders_discount_value']; ?></textarea>
						<?php 
							  if($orders_discount->RecordCount()==0) {
							  	echo '<p style="margin-left:120px;"><button id="discount_note_submit">提交</button><p></form>';
							  } else {
							  	echo '<p style="margin-left:120px;"><button id="discount_note_submit">更新</button><p></form>';
							  }
							  echo '</form>';
						?>
			        </td>
			    </tr>
			    </table>
			</td>			
			</tr>
			<?php if($order->info['orders_status'] != 0){?>
			<tr>
				<td class="main noprint"><br />
				<strong><?php echo TABLE_HEADING_COMMENTS; ?></strong></td>
			</tr>
			<tr>
				<td class="noprint"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
			</tr>
			<tr><?php echo zen_draw_form('status', FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=update_order', 'post', '', true); ?>
        <td class="main noprint"><?php echo zen_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
			</tr>
			<tr>
				<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
			</tr>
			<tr>
				<td>
				<table border="0" cellspacing="0" cellpadding="2" class="noprint">
					<tr>
						<td>
							<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td class="main"><strong><?php echo ENTRY_STATUS; ?></strong> 
									<?php 
					                unset($orders_statuses[7]); //unset this value for this is auto cancel,shouldn't be operated
					                $orders_statuses = array_values($orders_statuses);
					                echo  zen_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status'] , 'id="edit_status" destinc-class="payment_info_edit"'); 

					                echo '<div class="payment_info" ' . ($order->info['orders_status'] == 2 ? 'style="display:inline-block;"' : 'style="display:none;" disabled="disabled"') . '>';
					                echo '<span class="alert" style="margin-left:10px;"></span><strong >付款方式：</strong>';
					                echo zen_draw_pull_down_menu('paymethod', array_merge(array(array('id' => '', 'text' => '请选择...')), $orders_payment),$order->info['payment_module_code']);
					                echo '<span class="alert" style="margin-left:10px;">*</span><strong >交易ID：</strong>';
					                echo zen_draw_input_field('transaction_id' , $order->info['transaction_id'], (($order->info['is_exported'] == 1 || $order->info['transaction_id'] != '') ?  'readonly="readonly"' : '').'disabled="disabled"');
					                echo '</div>';
					                ?>
									</td><td>&nbsp;&nbsp;<b>跟踪号:</b> <input type="text" name="shippingNum" id="shippingNum" value='<?php echo $order->info["shippingNum"]; ?>' /></td>
								</tr>
								<tr>
									<td class="main"><strong><?php echo ENTRY_NOTIFY_CUSTOMER; ?></strong> <?php echo zen_draw_checkbox_field('notify', '', true); ?></td>
									<td class="main"><strong><?php echo ENTRY_NOTIFY_COMMENTS; ?></strong> <?php echo zen_draw_checkbox_field('notify_comments', '', true); ?></td>
								</tr>
							</table>
						</td>
						<td valign="top"><?php echo zen_image_submit('button_update.gif', IMAGE_UPDATE , ' onclick="return check_update_info();" class="order_update_class" '); ?></td>
					</tr>
				</table>
				</td>
				</form>
			</tr>
			<?php }?>
			<!--jessa 2009-11-29 �������۱�ע-->
			<tr><?php echo zen_draw_form('seller_memo', FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=update_seller_memo', 'post', '', true); ?>
        <td class="main noprint"><br />
				<strong>Seller Memo:</strong></td>
			</tr>
			<tr>
				<td class="main noprint"><?php echo zen_draw_textarea_field('seller_memo', 'soft', '50', '2', $order->info['seller_memo']); ?></td>
			</tr>
			<tr>
      	<?php echo zen_draw_hidden_field('old_seller_memo', $order->info['seller_memo']); ?>
      	<td valign="button" align="left"><?php echo zen_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
			</tr>
			</form>
			<!--eof jessa 2009-11-29-->
			<tr>
				<td colspan="2" align="right" class="noprint"><?php echo '<a href="' . zen_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oID). '&cID=' . $order->customer['id'] . '" TARGET="_blank">' . zen_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oID) . '" TARGET="_blank">' . zen_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action'))) . '">' . zen_image_button('button_orders.gif', IMAGE_ORDERS) . '</a>'; ?></td>
			</tr>
<?php
// check if order has open gv
        $gv_check = $db->Execute("select order_id, unique_id
                                  from " . TABLE_COUPON_GV_QUEUE ."
                                  where order_id = " . $oID . " and release_flag='N' limit 1");
        if ($gv_check->RecordCount() > 0) {
          $goto_gv = '<a href="' . zen_href_link(FILENAME_GV_QUEUE, 'order=' . $oID) . '">' . zen_image_button('button_gift_queue.gif',IMAGE_GIFT_QUEUE) . '</a>';
          echo '      <tr><td align="right"><table width="225"><tr>';
          echo '        <td align="center">';
          echo $goto_gv . '&nbsp;&nbsp;';
          echo '        </td>';
          echo '      </tr></table></td></tr>';
        }
?>
<?php
  } else {
?>
 <?php echo zen_draw_form('orders_list', FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'action=deleteconfirm', 'post', 'onsubmit="return delete_selected_orders();"', true);?>
  <tr><td><input id="deleteSelected" type="submit" value='Delete selected'/></td></tr>     
			<tr>
				<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="smallText"><?php echo TEXT_LEGEND . ' ' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . ' ' . TEXT_BILLING_SHIPPING_MISMATCH; ?>
			          </td>
			          </tr>
					<tr>
						<td valign="top">
						<table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr class="dataTableHeadingRow">
<?php
// Sort Listing
          switch ($_GET['list_order']) {
              case "id-asc":
              $disp_order = "c.customers_id";
              break;
              case "firstname":
              $disp_order = "c.customers_firstname";
              break;
              case "firstname-desc":
              $disp_order = "c.customers_firstname DESC";
              break;
              case "lastname":
              $disp_order = "c.customers_lastname, c.customers_firstname";
              break;
              case "lastname-desc":
              $disp_order = "c.customers_lastname DESC, c.customers_firstname";
              break;
              case "company":
              $disp_order = "a.entry_company";
              break;
              case "company-desc":
              $disp_order = "a.entry_company DESC";
              break;
              default:
              $disp_order = "c.customers_id DESC";
          }
?>
                <td class="dataTableHeadingContent" align="left"><input type="checkbox" onclick="getAllCheck(this,'ordersCheckbox[]')" /><?php echo TABLE_HEADING_ORDERS_ID; ?></td>
                <td class="specialCustomerTable">
                	<ul>
						<li class="dataTableHeadingContent" style="width:90px;">Payment</li>
						<li class="dataTableHeadingContent" style="width:75px;">Shipping</li>
						<li class="dataTableHeadingContent" style="width:140px;"><?php echo TABLE_HEADING_CUSTOMERS; ?></li>
						<li class="dataTableHeadingContent" style="width:70px;">From</li>
						<li class="dataTableHeadingContent" style="width:40px;">L</li>
						<li class="dataTableHeadingContent" style="width:110px;"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></li>
						<li class="dataTableHeadingContent" style="width:100px;"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></li>
						<li class="dataTableHeadingContent" style="width:55px;">VIP Discount</li>
						<li class="dataTableHeadingContent" style="width:100px;"><?php echo TABLE_HEADING_STATUS; ?></li>
						<li class="dataTableHeadingContent" style="width:100px;">Country Diff</li>
						<li class="dataTableHeadingContent" style="width:50px;float:right;"><?php echo TABLE_HEADING_ACTION; ?></li>
					</ul>
				</td>
			</tr>
<?php
// create search filter
  $searchwords = '';
  $from = '';	 
  
  if(isset($_GET['searchLang'])&&$_GET['searchLang']!=0){
  	$searchwords=' and o.language_id= '.$_GET['searchLang'];
  }else{
  	$searchwords = '';
  }
  if (isset($_GET['customers_email_address']) && zen_not_null($_GET['customers_email_address'])) {
   $customers_email_address = zen_db_input(zen_db_prepare_input($_GET['customers_email_address']));

    $searchwords =  $searchLang . $from . "  and (o.customers_email_address like '%" . $customers_email_address . "%' or o.customers_email_address like '%" . $customers_email_address . "%')";
 
  }
  
  if (isset($_GET['customers_name']) && zen_not_null($_GET['customers_name'])) {
  	$customers_name = zen_db_input(zen_db_prepare_input($_GET['customers_name']));
  	$searchwords .= " and (o.customers_name like '%" . $customers_name . "%' or o.delivery_name like '%" . $customers_name . "%' or o.billing_name like '%" . $customers_name . "%')";
  }
  
  if (isset($_GET['address']) && zen_not_null($_GET['address'])) {
  	$address = zen_db_input(zen_db_prepare_input($_GET['address']));
  	$searchwords .= " and (o.customers_street_address like '%" . $address . "%' or o.delivery_street_address like '%" . $address . "%' or o.billing_street_address like '%" . $address . "%')";
  }
  
?>
<?php 
    $new_fields = ", o.order_total, o.customers_company, o.customers_email_address, o.customers_street_address, o.delivery_company, o.delivery_name, o.delivery_street_address, o.delivery_country, o.billing_country, o.billing_company, o.billing_name, o.billing_street_address, o.payment_module_code, o.shipping_module_code, o.ip_address,o.from_mobile";
  		if (isset($_GET['cID']) && $_GET['cID'] != '') {
	      $cID = intval(zen_db_prepare_input($_GET['cID']));
	      $searchwords = " and  o.customers_id = " . $cID;
	    }
	    $contition = '';
	    if((isset($_GET['starttime']) && $_GET['starttime'] != '') &&(isset($_GET['stoptime']) && $_GET['stoptime'] != '')){
	    	if($_GET['starttime'] <= $_GET['stoptime']){
		    	$starttime = $_GET['starttime'];
		    	$stoptime = $_GET['stoptime'];
		    	
		    	$contition .= " and o.date_purchased >= '".$starttime." 00:00:00' 
										and o.date_purchased  <= '".$stoptime." 23:59:59'";
	    	}
	    }
	    if (isset($_GET['st']) && $_GET['st'] != '') {
	      $status = zen_db_prepare_input($_GET['st']);
	      if($_GET['st'] == '100') {
	      	$contition .= ' and o.automatically_canceled = 1';
	      } else {
	      	$contition .= ' and s.orders_status_id = '.(int)$status;
	      }
	    }else{
			$contition .= ' and s.orders_status_id <> 5';
			}
	    if(isset($_GET['py']) && $_GET['py'] != ''){
	       $payment = zen_db_prepare_input($_GET['py']);
	       $contition .= ' and o.payment_module_code = "'.$payment.'"';
	    }
	    if(isset($_GET['sm']) && $_GET['sm'] != ''){
	    	$shipping_method = zen_db_prepare_input($_GET['sm']);
	    	$contition .= ' and o.shipping_module_code = "'.$shipping_method.'"';
	    }
		if(isset($_GET['ot']) && $_GET['ot'] != ''){
	       if($_GET['ot'] == 'eq0'){
			$contition .= ' and o.order_total = 0';
		   }else{
		    $contition .= ' and o.order_total > 0';
		   }
	    }
	    if (isset($_GET['from']) && $_GET['from'] != '') {
	    	$source = zen_db_prepare_input($_GET['from']);
	    	$contition .= ' and o.from_mobile = "'.$source.'"';
	    }
	    
	    $orders_query_raw = "select delivery_city,billing_city,delivery_postcode,billing_postcode,delivery_state,billing_state,  o.orders_id, o.orders_status, o.display,o.delivery_country, o.billing_country, o.customers_id, o.customers_name, o.payment_method, o.shipping_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, o.seller_memo, o.automatically_canceled,o.from_mobile,s.orders_status_name,l.code " . $new_fields . " from " . TABLE_ORDERS . " o , " . TABLE_ORDERS_STATUS . " s, ".TABLE_LANGUAGES." l  where 1 " . $contition . " and  o.orders_status = s.orders_status_id and l.languages_id=o.language_id and s.language_id = " . $_SESSION['languages_id'] . "   " . $searchwords . " order by o.orders_id DESC";
//    }
//echo($orders_query_raw);
// Split Page
// reset page when page is unknown
if (($_GET['page'] == '' or $_GET['page'] <= 1) and $oID != '') {
  $check_page = $db->Execute($orders_query_raw);
  $check_count=1;
  if ($check_page->RecordCount() > MAX_DISPLAY_SEARCH_RESULTS_ORDERS) {
    while (!$check_page->EOF) {
      if ($check_page->fields['orders_id'] == $oID) {
        break;
      }
      $check_count++;
      $check_page->MoveNext();
    }
    $_GET['page'] = round((($check_count/MAX_DISPLAY_SEARCH_RESULTS_ORDERS)+(fmod_round($check_count,MAX_DISPLAY_SEARCH_RESULTS_ORDERS) !=0 ? .5 : 0)),0);
  } else {
    $_GET['page'] = 1;
  }
}
    //$orders_query_numrows = '';
    $orders_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $orders_query_raw, $orders_query_numrows);
    $orders = $db->Execute($orders_query_raw);
    $order_count = $orders->RecordCount();
    if((isset($_GET['starttime']) && $_GET['starttime'] != '') &&(isset($_GET['stoptime']) && $_GET['stoptime'] != '')){
    	if($_GET['starttime'] <= $_GET['stoptime']){
    		if($orders_query_numrows == 0){?>
    		<script>
    		var $addtd = $("<tr><td class=\"smallText\" align=\"right\" style=\"color:red;\">这个时间段内没有订单记录.</td></tr>");
    			$("#search_table").append($addtd);
    		</script>
    		<?php }
    	}
    }
    while (!$orders->EOF) {
    if ((!isset($oID) || (isset($oID) && ($oID == $orders->fields['orders_id']))) && !isset($oInfo)) {
        $oInfo = new objectInfo($orders->fields);
      }
	  if ($orders->fields['from_mobile']=='1') {
         $from_mobile = 'M';
	  }else{
	  	$from_mobile = 'W';
	  }
	//var_dump($oInfo);
      $show_difference = '';
      if((trim($orders->fields['delivery_country']) !=	trim($orders->fields['billing_country'])) 
			or (trim($orders->fields['delivery_postcode']) != trim($orders->fields['billing_postcode']))
			){
		     $order_sql="select orders_id,display
			 from  " . TABLE_ORDERS . " 
			 WHERE customers_id = :customersID
	       	 and orders_status in (" . MODULE_ORDER_SHIPPED_DELIVERED_STATUS_ID_GROUP . ")";
			 $order_sql=$db->bindVars($order_sql,':customersID',$orders->fields['customers_id'],'integer');
			 $order_result = $db->Execute($order_sql);
			 $num=$order_result->RecordCount();	
			 //echo $num;exit;
 			 if($num<3){
				if ($orders->fields['display'] == 0){
					$show_difference='';
				}else{
					//$show_difference = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . '&nbsp;';
					$show_difference = "<img src='".DIR_WS_IMAGES . "icon_status_red.gif' class='red_points' style='cursor:pointer'  did='".$orders->fields['orders_id']."' alt='".TEXT_BILLING_SHIPPING_MISMATCH."'  />";
				}     
			 }
		}
        $show_payment = $orders->fields['payment_module_code'] ;
        $show_type = $orders->fields['shipping_module_code'];
        $get_vip_amount_sql="select value from ".TABLE_ORDERS_TOTAL." where class='ot_group_pricing' and orders_id = ".$orders->fields['orders_id'];
		$get_vip_amount=$db->Execute($get_vip_amount_sql);
		if($get_vip_amount->RecordCount()>0){
			$get_vip_level_result=$db->Execute("select gp.group_percentage from ".TABLE_ORDERS." o, ". TABLE_GROUP_PRICING ." gp where orders_id =  ".$orders->fields['orders_id']." and gp.group_id = o.order_customers_group_pricing limit 1");
			if ($get_vip_level_result->fields['group_percentage']>0) {
				$vip_discount = round($get_vip_level_result->fields['group_percentage'], 0)."%";
			}elseif($get_vip_level_result->fields['group_percentage']==0){					
				$get_sub_total_sql = "select value from ".TABLE_ORDERS_TOTAL." where class='ot_subtotal' and orders_id = ".$orders->fields['orders_id'];
				$get_sub_total = $db->Execute($get_sub_total_sql);
				
				$get_special_discount_sql = "select value from ".TABLE_ORDERS_TOTAL." where class='ot_big_orderd' and orders_id = ".$orders->fields['orders_id'];
        		$get_special_discount = $db->Execute($get_special_discount_sql);
        		
        		if($get_special_discount->RecordCount() == 0){
        			$vip_discount = (round($get_vip_amount->fields['value']/$get_sub_total->fields['value'],2)*100)."%";
        		}else{
        			$vip_discount = (round($get_vip_amount->fields['value']/($get_sub_total->fields['value'] - $get_special_discount->fields['value']),2)*100)."%";
        		}
			}else{
				$vip_discount="6.01$";
			}
		}else{
			$vip_discount="&nbsp";
		}         
?>
								<?php 
								if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) {
									echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
								} else {
									echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
								}
								?>
								<td class="dataTableContent" align="left" style="border-bottom:1px dashed #333333;"><input type="checkbox" name="ordersCheckbox[]" <?php echo $input_check; ?> value="<?php echo $orders->fields['orders_id'];?>"><?php echo $show_difference . $orders->fields['orders_id']; ?></td>
								<td class="specialCustomerTable" style="border-bottom:1px dashed #333333;">
								<?php 
								if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) {
									echo '              <ul>' . "\n";
								} else {
									echo '              <ul >' . "\n";
								}
								
								$orders_total_sql="select `text` from ".TABLE_ORDERS_TOTAL." where class='ot_total' and orders_id = ".$orders->fields['orders_id'];
								$orders_total=$db->Execute($orders_total_sql);
								?>
								<li class="dataTableContent" style="width:90px;"><?php echo $show_payment == '' ? "/":$show_payment; ?></li>
								<li class="dataTableContent" style="width:75px;"><?php echo $show_type == '' ? "/":$show_type; ?></li>
								<li class="dataTableContent" style="width:140px;"><?php echo  $orders->fields['customers_name'] . ($_SESSION['show_customer_email'] ? '<br />' . $orders->fields['customers_email_address'] : '<br />' . strstr($orders->fields['customers_email_address'], '@', true) . '@'); ?></li>
								<li class="dataTableContent" style="width:70px;"><?php echo $from_mobile; ?></li>
								<li class="dataTableContent" style="width:40px;"><?php echo $orders->fields['code']; ?></li>
								<li class="dataTableContent" style="width:110px;"><?php echo $orders_total->fields['text'];?></li>
								<li class="dataTableContent" style="width:100px;"><?php echo zen_datetime_short($orders->fields['date_purchased']); ?></li>
								<li class="dataTableContent" style="width:55px;"><?php echo $vip_discount; ?></li>
								<li class="dataTableContent" style="width:100px;"><?php 
								$orders_status_name = $orders->fields['automatically_canceled'] == '1' ? '自动取消' : $orders->fields['orders_status_name'];
								echo $orders_status_name; ?>
								</li>
								<li class="dataTableContent" style="width:150px;">
									<?php
										if ($orders->fields['delivery_country'] != $orders->fields['billing_country']){
											echo zen_image(DIR_WS_IMAGES . 'country_diff.gif', ' ');
										}else{
											echo '&nbsp;';
										}
									?>
								</li>
								<li class="dataTableContent" style="width:50px;float:right;"><?php echo '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders->fields['orders_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>
                 					 <?php if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID')) . 'oID=' . $orders->fields['orders_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                 				</li>
                  			</ul>
							<?php
							if (zen_not_null($orders->fields['seller_memo'])) echo "<ul style='clear: both;'><li>" . $orders->fields['seller_memo'] . "</li></ul>";
							?>
                  			</td></tr>
							<?php
							      $orders->MoveNext();
							    }
							    echo '<tr><td><input id="deleteSelected" type="submit" value="Delete selected"/></td></tr>';
							    echo '</form>';
							?>
              				<tr>
								<td colspan="5">
								<table border="0" width="100%" cellspacing="0" cellpadding="2">
									<tr>
										<td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
										<td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
									</tr>
									<?php
									  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
									?>
                  					<tr>
										<td class="smallText" align="right" colspan="2">
					                      <?php
					                        echo '<a href="' . zen_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>';
					                        if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
					                          $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
					                          echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
					                        }
					                      ?>                    
					                     </td>
									</tr>
									<?php
									  }
									?>
                				</table>
								</td>
							</tr>
						</table>
					</td>
					<?php
					  $heading = array();
					  $contents = array();
					  switch ($action) {
					    case 'delete':
					      $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_DELETE_ORDER . '</strong>');
					      $contents = array('form' => zen_draw_form('orders', FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm', 'post', '', true));
					//      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br /><br /><strong>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</strong>');
					      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br /><br /><strong>' . ENTRY_ORDER_ID . $oInfo->orders_id . '<br />' . $oInfo->order_total . '<br />' . $oInfo->customers_name . ($oInfo->customers_company != '' ? '<br />' . $oInfo->customers_company : '') . '</strong>');
					      $contents[] = array('text' => '<br />' . zen_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
					      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id, 'NONSSL') . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
					      break;
					    default:
					      if (isset($oInfo) && is_object($oInfo)) {
					        $heading[] = array('text' => '<strong>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . zen_datetime_short($oInfo->date_purchased) . '</strong>');
					        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit', 'NONSSL') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete', 'NONSSL') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
					        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oInfo->orders_id) . '&cID=' . $oInfo->customers_id . '" TARGET="_blank">' . zen_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . zen_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>');
					        if ($_GET['status'] == 5){
					        	$who_delete = $db->Execute('select comments from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = ' . $oInfo->orders_id . ' and orders_status_id = 5 order by orders_status_history_id desc limit 1');
					        	$who_delete_id = substr($who_delete->fields['comments'], strpos($who_delete->fields['comments'], '---')+3);
					        	if ($who_delete_id != ''){
					        		$admin_query = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id = " . $who_delete_id);
									$who_delete_email = $admin_query->fields['admin_email'];
									$contents[] = array('text' => '操作人：' . $who_delete_email);
					        	}        	
					        }
					        $contents[] = array('text' => '<br />' . TABLE_HEADING_DATE_PURCHASED . ': ' . zen_date_short($oInfo->date_purchased));
					      	if ($_SESSION['show_customer_email']){
					        	$contents[] = array('text' => '<br />' .'Email Address:'.' '.$oInfo->customers_email_address);
					        }
					        $contents[] = array('text' => '<br />' . '客户ID:' . ' '  . $oInfo->customers_id);
					        $contents[] = array('text' => '<br />' .TEXT_INFO_IP_ADDRESS . ' ' . $oInfo->ip_address . ' ' . iconv("GBK", "UTF-8", $iplocal->getLocation($oInfo->ip_address)));
					        if (zen_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . zen_date_short($oInfo->last_modified));
					        $contents[] = array('text' => '<br />' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);
					        $contents[] = array('text' => '<br />' . ENTRY_SHIPPING . ' '  . $oInfo->shipping_method);
					        
					    /*     if($oInfo->order_customers_group_pricing > 1 ){
					        	$group_pricing_sql="select group_percentage
									 from  " . TABLE_GROUP_PRICING . "  gp, ".TABLE_GROUP_PRICING_DESCRIPTION." gpd
									 WHERE gp.group_id = gpd.groups_id
									 and gp.group_id = ".$oInfo->order_customers_group_pricing."
									 and gpd.languages_id = 1 group by gp.group_id";
					        	$group_pricing_result = $db->Execute($group_pricing_sql);
					        	if($group_pricing_result->RecordCount() > 0){
					        		$vip_discount = '('.(int)$group_pricing_result->fields['group_percentage'].'%)';
					        	}
					        	if($oInfo->order_customers_group_pricing == 25 ){
					        		$vip_discount = '(25%)';
					        	}
					        }elseif($oInfo->order_customers_group_pricing == 1){
					        	$vip_discount = '(5.01$)';
					        } */
					      				     

					        $get_vip_amount_sql="select value from ".TABLE_ORDERS_TOTAL." where class='ot_group_pricing' and orders_id = ".$oInfo->orders_id;
					        $get_vip_amount=$db->Execute($get_vip_amount_sql);
					        if($get_vip_amount->RecordCount()>0){
					        		
					        	$get_sub_total = $db->Execute("select gp.group_percentage from ".TABLE_ORDERS." o, ". TABLE_GROUP_PRICING ." gp where orders_id =  ".$oInfo->orders_id." and gp.group_id = o.order_customers_group_pricing limit 1");
					        	if ($get_sub_total->fields['group_percentage']>0) {
					        		$vip_discount = round($get_sub_total->fields['group_percentage'], 0)."%";
					        	}elseif ($get_sub_total->fields['group_percentage']==0){
									$get_total = 0;
					        		$get_total_sql = "select value from ".TABLE_ORDERS_TOTAL." where class='ot_subtotal' and orders_id = ".$oInfo->orders_id;
					        		$get_total = $db->Execute($get_total_sql);
					        		
					        		$get_special_discount_sql = "select value from ".TABLE_ORDERS_TOTAL." where class='ot_big_orderd' and orders_id = ".$oInfo->orders_id;
					        		$get_special_discount = $db->Execute($get_special_discount_sql);
					        		
					        		if($get_special_discount->RecordCount() == 0){
					        			$vip_discount = (round($get_vip_amount->fields['value']/$get_total->fields['value'],2)*100)."%";
					        		}else{
					        			$vip_discount = (round($get_vip_amount->fields['value']/($get_total->fields['value'] - $get_special_discount->fields['value']),2)*100)."%";
					        		}
					        	}else{
					        		$vip_discount="6.01$";
					        	}
					        }else{
					        	$vip_discount = "&nbsp";
					        }
					        
					       
					        $sql_vip_current = "SELECT customers_group_pricing ,group_percentage FROM t_customers c LEFT JOIN t_group_pricing g ON c.customers_group_pricing = g.group_id WHERE customers_id = ".$oInfo->customers_id;
					        $sql_vip_current_result=$db->Execute($sql_vip_current);
					        $vip_current = (int)$sql_vip_current_result->fields['group_percentage']."%";
					        
					        $channel_check_sql = "SELECT channel_id FROM " . TABLE_CHANNEL . " WHERE channel_customers_id = " . $oInfo->customers_id . " and channel_status in (10 , 20)";
					        $channel_check_query = $db->Execute($channel_check_sql);
					        if($channel_check_query->RecordCount() > 0){
					        	$vip_current = '15%';
					        	$contents[] = array('text' => '<br />  该客户当前VIP折扣：'.$vip_current );
					        }else{
					        	$contents[] = array('text' => '<br />  该客户当前VIP折扣：'.$vip_current.'【Super'.$sql_vip_current_result->fields['customers_group_pricing'].'】' );
					        }
					        
					// check if order has open gv
					        $gv_check = $db->Execute("select order_id, unique_id
					                                  from " . TABLE_COUPON_GV_QUEUE ."
					                                  where order_id = " . $oInfo->orders_id . " and release_flag='N' limit 1");
					        if ($gv_check->RecordCount() > 0) {
					          $goto_gv = '<a href="' . zen_href_link(FILENAME_GV_QUEUE, 'order=' . $oInfo->orders_id) . '">' . zen_image_button('button_gift_queue.gif',IMAGE_GIFT_QUEUE) . '</a>';
					          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
					          $contents[] = array('align' => 'center', 'text' => $goto_gv);
					        }
					      
					// indicate if comments exist
					      $orders_history_query = $db->Execute("select orders_status_id, date_added, customer_notified, comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = " . $oInfo->orders_id . " and comments !='" . "'" );
					      if ($orders_history_query->RecordCount() > 0) {
					        $contents[] = array('align' => 'left', 'text' => '<br />' . TABLE_HEADING_COMMENTS);
					      }
					      // bof 销售备注
					      if($order_count>0){
						      $order = new order($oInfo->orders_id);
						      $customers_query_raw = "select customers_firstname,customers_lastname,saler_remarks from " . TABLE_CUSTOMERS ." where customers_id =". $order->customer['id'];
						      $customers = $db->Execute($customers_query_raw);
						  }			      
					      if($customers->fields['saler_remarks'] != ''){
					      	$contents[] = array('align' => 'left', 'text' => '<br />' . '销售备注:'.$customers->fields['saler_remarks']);
					      }
					      $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
					      $contents[] = array('text' => 'Products Ordered: ' . sizeof($order->products) );
					      $contents[] = array('text' => 'Order Amount');
					      $str  ='<table width="90%">' . "\n";
					      
					      for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
							  //$vip_discount = '&nbsp;';
								
							if ($order->totals[$i]['class'] == 'ot_group_pricing'){
							$str .= '<tr><td width=70% align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title'] .'<font color="red">'."(".$vip_discount.")".'</font></td>' . "\n";							
							}elseif($order->totals[$i]['class'] == 'ot_discount_coupon'){
                  $coupon_query = $db->Execute("SELECT c.coupon_code FROM " . TABLE_COUPON_REDEEM_TRACK . " crt, " . TABLE_COUPONS . " c WHERE crt.order_id = " . $oInfo->orders_id . ' AND c.coupon_id = crt.coupon_id LIMIT 1'); 
                    if ($coupon_query->RecordCount() > 0) {
                        $coupon_code = $coupon_query->fields['coupon_code'];
                    }else{
                        $coupon_code = '';
                    }
                    if ($coupon_code != '') {
                        $coupon_title = '<a title="'.$coupon_code.'"><font size="1" color="#c89469"> [?] </font></a>';
                    }
                 $str .=' <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title']. $coupon_title .'</td>' . "\n";
              }else{
							$str .= '<tr><td width=70% align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title']. '</td>' . "\n";
							}							
							if ($order->totals[$i]['class'] == 'ot_total' && $i < sizeof($order->totals) -1){
								$order->info['currency'] == 'USD' ? $ordertatal = '' :$ordertatal = '(us$ '.number_format($order->info['total'],2,'.',',').')';
								$str .= '<td width=70% align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '<br>'.$ordertatal.'</td></tr>' . "\n";
							}else{
								$str .= '<td width=70% align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '</td></tr>' . "\n";
							     }
							     
						   }
							$str .='</table>' . "\n";
							$contents[] = array('align' => 'left', 'text' => $str);
							//eof order amount
							//bof shipping weight
							$contents[] = array('text' => $order->weight_total[sizeof($order->weight_total)-1]['title'] . $order->weight_total[sizeof($order->weight_total)-1]['text']);;
							//eof
					      //bof status
							$contents[] = array('text' => 'Status');
							if($oInfo->orders_status != 0){
								$str_status = zen_draw_form('status', FILENAME_ORDERS, zen_get_all_get_params(array('action,oID')) . 'action=update_order&oID=' . $oInfo->orders_id, 'post', '', true);
							}
							$str_status .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
							<tr>
					            <td class="smallText" align="center"><strong>' . TABLE_HEADING_DATE_ADDED . '</strong></td>
					            <td class="smallText" align="center"><strong>' .TABLE_HEADING_CUSTOMER_NOTIFIED . '</strong></td>
					            <td class="smallText" align="center"><strong>' .TABLE_HEADING_STATUS . '</strong></td>
					            <td class="smallText" align="center"><strong>' .TABLE_HEADING_COMMENTS . '</strong></td>
					          </tr>
							';
					      $orders_history = $db->Execute("select orders_status_id, date_added, customer_notified, comments
					                                    from " . TABLE_ORDERS_STATUS_HISTORY . "
					                                    where orders_id = " . zen_db_input($oInfo->orders_id) . "
					                                    order by date_added");
					    if ($orders_history->RecordCount() > 0) {
					      while (!$orders_history->EOF) {
					        $str_status .= '          <tr>' . "\n" .
					             '            <td class="smallText" align="center">' . zen_datetime_short($orders_history->fields['date_added']) . '</td>' . "\n" .
					             '            <td class="smallText" align="center">';
					        if ($orders_history->fields['customer_notified'] == '1') {
					          $str_status .= zen_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
					        } else {
					          $str_status .= zen_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
					        }
					        $str_status .= '            <td class="smallText">' . $orders_status_array[$orders_history->fields['orders_status_id']] . '</td>' . "\n";
					        $str_status .= '            <td class="smallText" style= "word-break:break-all;">' . nl2br($orders_history->fields['comments']) . '&nbsp;</td>' . "\n" .
					             '          </tr>' . "\n";
					        $orders_history->MoveNext();
					      }
					    } else {
					        $str_status .= '          <tr>' . "\n" .
					             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
					             '          </tr>' . "\n";
					    }        
					    $str_status .= '</table>';
					    
					    if($oInfo->orders_status != 0){
						    $str_status .= '<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr>
						                <td class="main noprint"><strong>' . TABLE_HEADING_COMMENTS . '</strong></td>
						                <td class="main noprint" width="70%">' . zen_draw_textarea_field('comments', 'soft', '60', '5') . '</td>
						        </tr>';
						    $str_status .= '</table>';
// 							$get_order_from_sql="select order_from from ".TABLE_ORDERS." where orders_id = ".(int)$oInfo->orders_id." limit 1 ";
// 							$get_order_from=$db->Execute($get_order_from_sql); 
// 							$checked_order_from_0 = '';
// 							$checked_order_from_1 = '';
// 							if($get_order_from->fields['order_from'] == 0) $checked_order_from_0 = 'checked';
// 							if($get_order_from->fields['order_from'] == 1) $checked_order_from_1 = 'checked';
// 							$order_from = '<input type="radio" name="order_from" id="order_from_0" value="0" '.$checked_order_from_0.'><label for="order_from_0">网站订单</label>
// 							<input type="radio" name="order_from" id="order_from_1" value="1" '.$checked_order_from_1.'><label for="order_from_1">平台订单</label>';
							//unset($orders_statuses[6]);
						//	var_dump($orders_statuses);
					        unset($orders_statuses[7]);
							$orders_statuses = array_values($orders_statuses);
							$str_status .= '<table border="0" width="100%" cellspacing="0" cellpadding="0" height="200px">
								<tr>
									<td><span>下单状态：</span></td>
									<td >' . zen_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status'], 'style="width: 150px;" destinc-class="payment_info"') . '</td>
								</tr>
								<tr>
									<td><span>跟踪号:</span></td>
									<td><input type="text" name="shippingNum" id="shippingNum" value="'.$order->info["shippingNum"].'" /><br/></td>
								</tr>	
								<tr class="payment_info" ' . ($order->info['orders_status'] == 2 ? 'style="display:table-row;"' : 'style="display:none;" disabled="disabled"') . '>
									<td><span class="alert"></span><span>付款方式：</span> </td>
									<td>' . zen_draw_pull_down_menu('paymethod', array_merge(array(array('id' => '', 'text' => '请选择...')), $orders_payment),$order->info['payment_module_code']  , 'style="width: 150px;"') . '</td>
								</tr>
								<tr class="payment_info" ' . ($order->info['orders_status'] == 2 ? 'style="display:table-row;"' : 'style="display:none;" disabled="disabled"') . '>
									<td><span class="alert">*</span><span>交易ID：</span></td>
									<td>'.zen_draw_input_field('transaction_id', $order->info['transaction_id'] , (($order->info['is_exported'] == 1 || $order->info['transaction_id'] != '') ?  'readonly="readonly"' : '').'disabled="disabled"').'</td>
								</tr>
								<tr>
									<td class="main"><strong>' . ENTRY_NOTIFY_CUSTOMER . '</strong>' . zen_draw_checkbox_field('notify', '', true) . '</td>
									<td class="main"><strong>' . ENTRY_NOTIFY_COMMENTS . '</strong>' . zen_draw_checkbox_field('notify_comments', '', true) . '</td>
								</tr>
								<tr>
									<td valign="top">' . zen_image_submit('button_update.gif', IMAGE_UPDATE , 'onclick="return check_update_info();" class="order_update_class" ') . '</td>
									<td></td>
								</tr>
							</table>
							</form>';
					    }
							$contents[] = array('text' => $str_status);
							//eof status
							$contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));  // <input type="text" name="shippingNum" id="shippingNum" />
					      //bof comments
					      $customer_comments = $db->Execute("select comments
					                                    from " . TABLE_ORDERS_STATUS_HISTORY . "
					                                    where orders_id = " . zen_db_input($oInfo->orders_id) . " and orders_status_id = 1");
					      $str_comments = zen_draw_form('seller_memo', FILENAME_ORDERS, zen_get_all_get_params(array('action', 'oID')) . 'action=update_seller_memo&oID='.$oInfo->orders_id, 'post', '', true);
					      $str_comments .= '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
					      $str_comments .= '		<tr><td class="main noprint">Seller Memo:</td><td class="main noprint">' . zen_draw_textarea_field('seller_memo', 'soft', '50', '2', $order->info['seller_memo']) . '</td></tr>';
					      $str_comments .= '		<tr>' . zen_draw_hidden_field('old_seller_memo', $order->info['seller_memo']) . '<td align="right" colspan="2"><button>update</button></td></tr>';
					      $str_comments .= '</table></form>';
					      //zen_image_submit('button_update.gif', IMAGE_UPDATE)
					      $contents[] = array('text' => $str_comments);
					      //eof
					      }
					      break;
					  }
					  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
					    echo '            <td width="25%" valign="top">' . "\n";
					    $box = new box;
					    echo $box->infoBox($heading, $contents);
					    echo '            </td>' . "\n";
					  }				  
					?>
					          </tr>
									</table>
									</td>
								</tr>
					<?php
					  }
					?>
    			</table>
			</td>
		<!-- body_text_eof //-->
	</tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<div class="footer-area">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</div>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
