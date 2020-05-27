<?php
require ('includes/application_top.php');
$type = $_GET ['type'];
if ($type == '') {
	exit ();
}

/*if ($type == 'process_coupon') {
	$coupon = $db->Execute ( 'select cc.cc_customers_id, c.coupon_id, cu.customers_email_address, cu.lang_preference from ' . TABLE_COUPONS . ' c, ' . TABLE_COUPON_CUSTOMER . ' cc left join ' . TABLE_CUSTOMERS . ' cu on cu.customers_id = cc.cc_customers_id where c.coupon_active="Y" and c.coupon_id = cc.cc_coupon_id and c.coupon_expire_date > "' . date('Y-m-d H:i:s') . '" and c.coupon_expire_date <= "' . date ( 'Y-m-d H:i:s', strtotime ( '+1 week' ) ) . '"' );
	if ($coupon->RecordCount () > 0) {
		while ( ! $coupon->EOF ) {
			$customer_id = $coupon->fields ['cc_customers_id'];
			$email = $coupon->fields ['customers_email_address'];
			$lang = ($coupon->fields ['lang_preference'] == '' ? 1 : $coupon->fields ['lang_preference']);
			$coupon_id = $coupon->fields ['coupon_id'];

			$coupon_track = $db->Execute('select order_id, redeem_date from '.TABLE_COUPON_REDEEM_TRACK.' where customer_id='.$customer_id.' and coupon_id='.$coupon_id);
			if($coupon_track->RecordCount() <= 0){			
				$check = $db->Execute ( 'select queue_id from t_email_auto_send where customers_id = ' . $customer_id . ' and email_address = "' . $email . '" and type = "coupon" and language_id = ' . $lang . ' and code = ' . $coupon_id );
				if ($email != '' && $check->RecordCount () == 0) {
					$db->Execute ( 'insert into t_email_auto_send values (NULL, ' . $customer_id . ', "' . $email . '", "coupon", ' . $lang . ', 0, now(), NULL, ' . $coupon_id . ')' );
				}
			}
			$coupon->MoveNext ();
		}
	}
} elseif ($type == 'auto_coupon') {
	$record = $db->Execute ( 'select ea.queue_id, cu.customers_email_address, ea.language_id, c.coupon_code, c.coupon_expire_date, cu.customers_firstname, cu.customers_lastname, l.directory 
									 from t_email_auto_send ea, ' . TABLE_COUPONS . ' c, ' . TABLE_CUSTOMERS . ' cu, ' . TABLE_LANGUAGES . ' l 
									 where ea.code = c.coupon_id
									 and cu.customers_id = ea.customers_id 
									 and ea.language_id = l.languages_id 
									 and ea.is_sended = 0 and ea.type = "coupon" order by ea.queue_id limit 10' );
	if ($record->RecordCount () > 0) {
		include 'includes/languages/english/auto_sent_mail.php';
		while ( ! $record->EOF ) {
			$queue_id = $record->fields ['queue_id'];
			$email = $record->fields ['customers_email_address'];
			$lang = 'auto_lang_' . ($record->fields ['directory'] == '' ? 'english' : $record->fields ['directory']);
			$lanArray = $$lang;
			$coupon_code = $record->fields ['coupon_code'];
			$deadline = $record->fields ['coupon_expire_date'];
			$show_deadtime = date ( 'M.d, Y', strtotime ( $deadline ) );
			$fname = $record->fields ['customers_firstname'];
			$lname = $record->fields ['customers_lastname'];
			$full_name = $fname . ' ' . $lname;
			$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf ( $lanArray['AUTO_COUPON_MAIL_CONTENT'], $full_name, $coupon_code, $show_deadtime );
			zen_mail ( $full_name, $email, $lanArray['AUTO_COUPON_MAIL_SUBJECT'], '', $lanArray['AUTO_ORDER_STORE_NAME'], $lanArray['AUTO_NOTIFICATION_ADDRESS'], $html_msg, 'content_only' );
			$db->Execute ( 'update t_email_auto_send set is_sended = 1, date_finished = now() where queue_id = ' . $queue_id );
			$record->MoveNext ();
		}
	}
} else*/
if ($type == 'process_order') {
	$order = $db->Execute ( 'select c.customers_id, c.customers_email_address, o.language_id, o.orders_id from ' . TABLE_ORDERS . ' o, ' . TABLE_CUSTOMERS . ' c where o.date_purchased < "' . date ( 'Y-m-d H:i:s', strtotime ( '-1 month' ) ) . '" and o.orders_status = 1 and c.customers_id = o.customers_id' );
	if ($order->RecordCount () > 0) {
		while ( ! $order->EOF ) {
			$customer_id = $order->fields ['customers_id'];
			$email = $order->fields ['customers_email_address'];
			$lang = ($order->fields ['language_id'] == '' ? 1 : $order->fields ['language_id']);
			$order_id = $order->fields ['orders_id'];
			
			$check = $db->Execute ( 'select queue_id from t_email_auto_send where customers_id = ' . $customer_id . ' and email_address = "' . $email . '" and type = "order" and language_id = ' . $lang . ' and code = ' . $order_id );
			if ($email != '' && $check->RecordCount () == 0) {
				$db->Execute ( 'insert into t_email_auto_send values (NULL, ' . $customer_id . ', "' . $email . '", "order", ' . $lang . ', 0, now(), NULL, ' . $order_id . ')' );
			}
			$order->MoveNext ();
		}
	}
} elseif ($type == 'auto_order') {
	$record = $db->Execute ( 'select cu.customers_id,o.currency,ea.queue_id, cu.customers_email_address, ea.language_id, o.orders_id, o.date_purchased, cu.customers_firstname, cu.customers_lastname, l.directory, l.code, cu.customers_id
									 from t_email_auto_send ea, ' . TABLE_ORDERS . ' o, ' . TABLE_CUSTOMERS . ' cu, ' . TABLE_LANGUAGES . ' l 
									 where ea.code = o.orders_id
									 and cu.customers_id = ea.customers_id 
									 and ea.language_id = l.languages_id
									 and ea.is_sended = 0 and ea.type = "order" order by ea.queue_id limit 10' );
	if ($record->RecordCount () > 0) {
		include 'includes/languages/english/auto_sent_mail.php';
		while ( ! $record->EOF ) {
			$queue_id = $record->fields ['queue_id'];
			$customer_id = $record->fields ['customers_id'];
			$email = $record->fields ['customers_email_address'];
			$lang = ($record->fields ['directory'] == '' ? 'english' : $record->fields ['directory']);
			$lang_code = ($record->fields ['code'] == '' ? 'en' : $record->fields ['code']);
			$lang = 'auto_lang_' . ($record->fields ['directory'] == '' ? 'english' : $record->fields ['directory']);
			$lanArray = $$lang;
			$order_id = $record->fields ['orders_id'];
			$purchased = $record->fields ['date_purchased'];
			$show_purchased = date ( 'l d F, Y', strtotime ( $purchased ) );
			$fname = $record->fields ['customers_firstname'];
			$lname = $record->fields ['customers_lastname'];
			$full_name = $fname . ' ' . $lname;
			$currency = $record->fields ['currency'];
			
			$html_msg ['EMAIL_CUSTOMERS_NAME'] = $lanArray['AUTO_ORDER_DEAR'] . ' ' . $full_name;
			$html_msg ['EMAIL_STORE_NAME'] = $lanArray['AUTO_ORDER_STORE_NAME'];
			$html_msg ['EMAIL_TEXT_ORDER_NUMBER'] = $lanArray['AUTO_ORDER_NUMBER'] . ' ' . $order_id;
			$html_msg ['EMAIL_TEXT_INVOICE_URL'] = '<a target="_blank" href="index.php?main_page=account_history_info&order_id=' . $order_id . '&language=' . $lang_code . '">' . $lanArray['AUTO_ORDER_DETAILED_INVOICE'] . '</a>';
			$html_msg ['EMAIL_TEXT_DATE_SHIPPED'] = '';
			$html_msg ['EMAIL_TEXT_DATE_ORDERED'] = $lanArray['AUTO_ORDER_DATE_ORDERED']. ' ' . $show_purchased;
			$html_msg ['EMAIL_TEXT_STATUS_COMMENTS'] = '';
			$html_msg ['EMAIL_TEXT_STATUS_UPDATED'] = $lanArray['AUTO_ORDER_UPDATED'];
			$html_msg ['EMAIL_TEXT_STATUS_LABEL'] = sprintf ( $lanArray['AUTO_ORDER_NEW_STATUS'], $lanArray['AUTO_ORDER_CANCELED'] ).'<br/><br/>';
			$html_msg ['EMAIL_TEXT_STATUS_PLEASE_REPLY'] = $lanArray['AUTO_ORDER_REPLY'];
			$html_msg ['EMAIL_MESSAGE_HTML'] = 'not null';
			$html_msg ['EMAIL_DISCLAIMER'] = $lanArray['EMAIL_DISCLAIMER'];
			$html_msg ['EMAIL_SPAM_DISCLAIMER'] = $lanArray['EMAIL_SPAM_DISCLAIMER'];
			//zen_mail ( $full_name, $email, $lanArray['AUTO_ORDER_SUBJECT'] . ' #' . $order_id, '', $lanArray['AUTO_ORDER_STORE_NAME'], $lanArray['AUTO_NOTIFICATION_ADDRESS'], $html_msg, 'order_status' );
			
			/*automatically_canceled if it used balance then return it*/
			
			$check_balance = $db->Execute("select `value` from ".TABLE_ORDERS_TOTAL." where orders_id='".$order_id."' and class='ot_cash_account'");
			if($check_balance->fields['value']){
				$check_refund_existed = $db->Execute("select cac_cash_id from ".TABLE_CASH_ACCOUNT." where cac_order_create=2 and from_order='".$order_id."'");
				if($check_refund_existed->RecordCount()==0){
					
					$currency_amount = zen_change_currency($check_balance->fields['value'], 'USD', $currency);
					$refund_balace_data = array(
							'cac_customer_id'=>$customer_id,
							'cac_amount'=>$currency_amount,
							'cac_currency_code'=>$currency,
							'cac_create_date'=>date('Y-m-d H:i:s'),
							'cac_status'=>'A',
							'cac_memo'=>$lanArray['TEXT_REFUND_BALANCE'].$order_id,
							'cac_order_create'=>1,
							'from_order'=>$order_id
					);
					zen_db_perform(TABLE_CASH_ACCOUNT, $refund_balace_data);
				}
			}
			/*end */
			$db->Execute ( "update " . TABLE_ORDERS . " set orders_status = 0, automatically_canceled = 1, last_modified = now()  where orders_id = $order_id" );
			$db->Execute ( 'update t_email_auto_send set is_sended = 1, date_finished = now() where queue_id = ' . $queue_id );
			$db->Execute ( 'insert into ' . TABLE_ORDERS_STATUS_HISTORY . ' (orders_id, orders_status_id, date_added, customer_notified, comments) values (' . $order_id . ', 0, now(), 1, "' . $lanArray['AUTO_ORDER_HISTORY_COMMENTS'] . '")');
			
			$record->MoveNext ();
		}
	}
}
?>