<?php
/**
 * continued payment for order header
 * @author wei.liang
 * @version 2.0
*/
set_time_limit ( 600 );
$zco_notifier->notify ( 'NOTIFY_HEADER_START_CONTINUED_ORDER' );

if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ( array (
			'mode' => 'SSL',
			'page' => FILENAME_CHECKOUT_PAYMENT
	) );
	zen_redirect ( zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
} else {
	// validate customer
	if (zen_get_customer_validate_session ( $_SESSION ['customer_id'] ) == false) {
		$_SESSION ['navigation']->set_snapshot ();
		zen_redirect ( zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) );
	}
}
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
require (DIR_WS_LANGUAGES . $_SESSION['language'] .  '/account_history_info.php');
require (DIR_WS_CLASSES . 'order.php');

$orders_id = intval(zen_db_prepare_input($_GET['orders_id']));
$payment = zen_db_prepare_input($_GET['payment']);
if(empty($orders_id)) {
	$orders_id = intval(zen_db_prepare_input($_POST['orders_id']));
}
if(empty($payment)) {
	$payment = intval(zen_db_prepare_input($_POST['payment']));
}

if (!empty ( $orders_id )) {
	$order = new order ( $orders_id );
	$_SESSION ['order_number_created'] = $orders_id;
	//$_SESSION ['payment_return_account'] = true;
}

if (! isset ( $_SESSION ['shipping'] ) && isset ( $order ))
	$_SESSION ['shipping'] = $order->info ['shipping_module_code'];

if (!empty ( $payment )) {
	$_SESSION ['payment'] = $payment;
}
$emai_array = explode ( ",", EMAIL_PAYMENT_INFORMATION );
$send_to_email = $emai_array [( int ) $_SESSION ['languages_id'] - 1];
if ($send_to_email == "") {
	$send_to_email = $emai_array [0];
}
require (DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment ( $_SESSION ['payment'] );
$payment_modules->update_status ();
if (is_array ( $payment_modules->modules )) {
	$payment_modules->pre_confirmation_check ();
}
$html_msg ['EMAIL_SUBJECT'] = (preg_match ( '/@panduo.com.cn/', $order->customer ['email_address'] ) ? '测试邮件' : '') . "（订单号: " . $orders_id . "）有客户提交（" . strip_tags ( $$_SESSION ['payment']->title ) . "）支付信息 注意联系客户沟通付款事宜 - ".$_SESSION['languages_code'];
$str_bottom = '<div style="background:#f9f9f9;">' . TEXT_CONTINUED_EMAIL_BOTTOM . '</div>';
//$email_to_sales = EMAIL_PAYMENT_INFORMATION_ADDRESS;
$email_to_sales = SALES_EMAIL_ADDRESS;
$email_cc_to_sales = SALES_EMAIL_CC_TO;
$email_from = EMAIL_FROM;
switch ($_SESSION ['payment']) {
	case 'wire' : // hsbs
		$sql_data_array = array (
				'full_name' => $db->prepare_input ( zen_db_prepare_input($_POST ['hsbs_yname']) ),
				'currency' => $db->prepare_input ( $_POST ['hsbs_Currency_input']?zen_db_prepare_input($_POST ['hsbs_Currency_input']):zen_db_prepare_input($_POST ['hsbs_Currency']) ),
				'amount' => $db->prepare_input ( zen_db_prepare_input($_POST ['hsbs_amout']) ),
				'payment_file' => $db->prepare_input ( zen_db_prepare_input($_POST ['hsbs_file']) ),
				'payment_type' => $_SESSION ['payment'],
				'payment_date' => $db->prepare_input ( zen_db_prepare_input($_POST ['hsbs_date']) ),
				'create_date' => 'now()',
				'orders_id' => $orders_id
		);
		zen_db_perform ( TABLE_PAYMENT_RECORDS, $sql_data_array );
		$attachments_list ['file'] = $_POST ['hsbs_file'];

		$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_CONTINUED_EMAIL_CONTENT, $order->customer ['name'], 'hsbc_1.png', TEXT_CONTINUED_NAME_HSBC);
		$html_msg ['EMAIL_MESSAGE_HTML'] .= '<br><table class="orderinfo_table">
												  <tr class="color_one"><th>' . TEXT_ACOOUNT_ORDER_NO . ':</th><th>' . $sql_data_array ['orders_id'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_ACOOUNT_YOUR_NAME . ':</th><th>' . $sql_data_array ['full_name'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_CURRENCY . ':</th><th>' . $sql_data_array ['currency'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_SUM . ':</th><th>' . $sql_data_array ['amount'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_PAYMENT_DATE . ':</th><th>' . $sql_data_array ['payment_date'] . '</th></tr>
												</table><br>';
		if ($db->prepare_input ( $_POST ['hsbs_file'] ) != '') {
			if (strtolower(substr($_POST ['hsbs_file'], strrpos($_POST ['hsbs_file'], '.'))) == '.pdf'){

			}else{
				$html_msg ['EMAIL_MESSAGE_HTML'] .= '<strong>Attachment: </strong><img src="' . $_POST ['hsbs_file'] . '" style="max-width:100px;max-height:100px;"/><br><br>';
			}
		}

		$html_msg ['EMAIL_MESSAGE_HTML'] .= $str_bottom;

		zen_mail ( '', $email_to_sales, $html_msg ['EMAIL_SUBJECT'], "", $order->customer ['name'], $order->customer ['email_address'], $html_msg, 'default1', '', 'false', $email_cc_to_sales );
		$html_msg ['EMAIL_SUBJECT'] = TEXT_CONTINUED_SUBMITTED_SUCCESSFULLY;
		zen_mail ( '', $order->customer ['email_address'], $html_msg ['EMAIL_SUBJECT'], "", 'Doreenbeads Team', $email_from, $html_msg, 'default1' );
		break;
	case 'wirebc' : // (Bank of China)
		$sql_data_array = array (
				'full_name' => $db->prepare_input ( zen_db_prepare_input($_POST ['china_yname']) ),
				'currency' => $db->prepare_input ( $_POST ['china_Currency_input']?zen_db_prepare_input($_POST ['china_Currency_input']):zen_db_prepare_input($_POST ['china_Currency']) ),
				'amount' => $db->prepare_input ( zen_db_prepare_input($_POST ['china_amout']) ),
				'payment_file' => $db->prepare_input ( zen_db_prepare_input($_POST ['china_file']) ),
				'payment_type' => $_SESSION ['payment'],
				'payment_date' => $db->prepare_input ( zen_db_prepare_input($_POST ['china_date']) ),
				'create_date' => 'now()',
				'orders_id' => $orders_id
		);
		zen_db_perform ( TABLE_PAYMENT_RECORDS, $sql_data_array );
		$attachments_list ['file'] = $_POST ['china_file'];

		$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_CONTINUED_EMAIL_CONTENT, $order->customer ['name'], 'china_bank_1.png', TEXT_CONTINUED_NAME_BC);
		$html_msg ['EMAIL_MESSAGE_HTML'] .= '<br><table class="orderinfo_table">
												  <tr class="color_one"><th>' . TEXT_ACOOUNT_ORDER_NO . ':</th><th>' . $sql_data_array ['orders_id'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_ACOOUNT_YOUR_NAME . ':</th><th>' . $sql_data_array ['full_name'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_CURRENCY . ':</th><th>' . $sql_data_array ['currency'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_SUM . ':</th><th>' . $sql_data_array ['amount'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_PAYMENT_DATE . ':</th><th>' . $sql_data_array ['payment_date'] . '</th></tr>
												</table><br>';

		if ($db->prepare_input ( $_POST ['china_file'] ) != '') {
			if (strtolower(substr($_POST ['china_file'], strrpos($_POST ['china_file'], '.'))) == '.pdf'){

			}else{
				$html_msg ['EMAIL_MESSAGE_HTML'] .= '<strong>Attachment: </strong><img src="' . $_POST ['china_file'] . '" style="max-width:100px;max-height:100px;"/><br><br>';
			}
		}

		$html_msg ['EMAIL_MESSAGE_HTML'] .= $str_bottom;

		zen_mail ( '', $email_to_sales, $html_msg ['EMAIL_SUBJECT'], "", $order->customer ['name'], $order->customer ['email_address'], $html_msg, 'default1', '', 'false', $email_cc_to_sales );
		$html_msg ['EMAIL_SUBJECT'] = TEXT_CONTINUED_SUBMITTED_SUCCESSFULLY;
		zen_mail ( '', $order->customer ['email_address'], $html_msg ['EMAIL_SUBJECT'], "", 'Doreenbeads Team', $email_from, $html_msg, 'default1' );
		break;
	case 'westernunion' : // Western Union Money Transfer
		$sql_data_array = array (
				'full_name' => $db->prepare_input ( zen_db_prepare_input($_POST ['western_yname']) ),
				'currency' => $db->prepare_input ( $_POST ['western_Currency_input']?zen_db_prepare_input($_POST ['western_Currency_input']):zen_db_prepare_input($_POST ['western_Currency']) ),
				'amount' => $db->prepare_input ( zen_db_prepare_input($_POST ['western_amout']) ),
				'control_no' => $db->prepare_input ( zen_db_prepare_input($_POST ['western_control_no']) ),
				'payment_file' => $db->prepare_input ( zen_db_prepare_input($_POST ['western_file']) ),
				'create_date' => 'now()',
				'payment_type' => $_SESSION ['payment'],
				'orders_id' => $orders_id
		);
		zen_db_perform ( TABLE_PAYMENT_RECORDS, $sql_data_array );
		$attachments_list ['file'] = $_POST ['western_file'];

		$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_CONTINUED_EMAIL_CONTENT, $order->customer ['name'], 'western.png', TEXT_CONTINUED_NAME_WU);
		$html_msg ['EMAIL_MESSAGE_HTML'] .= '<br><table class="orderinfo_table">
												  <tr class="color_one"><th>' . TEXT_ACOOUNT_ORDER_NO . ':</th><th>' . $sql_data_array ['orders_id'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_ACOOUNT_YOUR_NAME . ':</th><th>' . $sql_data_array ['full_name'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_CURRENCY . ':</th><th>' . $sql_data_array ['currency'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_SUM . ':</th><th>' . $sql_data_array ['amount'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_CONTROL_NO . ':</th><th>' . $sql_data_array ['control_no'] . '</th></tr>
												</table><br>';
		if ($db->prepare_input ( $_POST ['western_file'] ) != '') {
			if (strtolower(substr($_POST ['western_file'], strrpos($_POST ['western_file'], '.'))) == '.pdf'){

			}else{
				$html_msg ['EMAIL_MESSAGE_HTML'] .= '<strong>Attachment: </strong><img src="' . $_POST ['western_file'] . '" style="max-width:100px;max-height:100px;"/><br><br>';
			}
		}

		$html_msg ['EMAIL_MESSAGE_HTML'] .= $str_bottom;

		zen_mail ( '', $email_to_sales, $html_msg ['EMAIL_SUBJECT'], "", $order->customer ['name'], $order->customer ['email_address'], $html_msg, 'default1', '', 'false', $email_cc_to_sales );
		$html_msg ['EMAIL_SUBJECT'] = TEXT_CONTINUED_SUBMITTED_SUCCESSFULLY;
		zen_mail ( '', $order->customer ['email_address'], $html_msg ['EMAIL_SUBJECT'], "", 'Doreenbeads Team', $email_from, $html_msg, 'default1' );
		break;
	case 'moneygram' : // Western Union Money Transfer
		$country = zen_get_countries(zen_db_prepare_input($_POST ['zone_country_id']));
		$country_name = $country['countries_name'];
		$sql_data_array = array (
				'full_name' => $db->prepare_input ( zen_db_prepare_input($_POST ['moneygram_full_name']) ),
				'address' => $country_name,
				'currency' => $db->prepare_input ( $_POST ['moneygram_Currency_input']?zen_db_prepare_input($_POST ['moneygram_Currency_input']):zen_db_prepare_input($_POST ['moneygram_Currency']) ),
				'amount' => $db->prepare_input ( zen_db_prepare_input($_POST ['moneygram_amout']) ),
				'control_no' => $db->prepare_input ( zen_db_prepare_input($_POST ['moneygram_control_no']) ),
				'payment_file' => $db->prepare_input ( zen_db_prepare_input($_POST ['moneygram_file']) ),
				'create_date' => 'now()',
				'payment_type' => $_SESSION ['payment'],
				'orders_id' => $orders_id
		);
		zen_db_perform ( TABLE_PAYMENT_RECORDS, $sql_data_array );
		$attachments_list ['file'] = $_POST ['moneygram_file'];

		$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_CONTINUED_EMAIL_CONTENT, $order->customer ['name'], 'moneygram_1.png', TEXT_CONTINUED_NAME_MG);
		$html_msg ['EMAIL_MESSAGE_HTML'] .= '<br><table class="orderinfo_table">
												  <tr class="color_one"><th>' . TEXT_ACOOUNT_ORDER_NO . ':</th><th>' . $sql_data_array ['orders_id'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_YOUR_FULL_NAME . ':</th><th>' . $sql_data_array ['full_name'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_YOUR_COUNTRY . ':</th><th>' . $country_name . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_CURRENCY . ':</th><th>' . $sql_data_array ['currency'] . '</th></tr>
												  <tr class="color_three"><th>' . TEXT_SUM . ':</th><th>' . $sql_data_array ['amount'] . '</th></tr>
												  <tr class="color_two"><th>' . TEXT_CONTROL_NO . ':</th><th>' . $sql_data_array ['control_no'] . '</th></tr>
												</table><br>';
		if ($db->prepare_input ( $_POST ['moneygram_file'] ) != '') {
			if (strtolower(substr($_POST ['moneygram_file'], strrpos($_POST ['moneygram_file'], '.'))) == '.pdf'){

			}else{
				$html_msg ['EMAIL_MESSAGE_HTML'] .= '<strong>Attachment: </strong><img src="' . $_POST ['moneygram_file'] . '" style="max-width:100px;max-height:100px;"/><br><br>';
			}
		}

		$html_msg ['EMAIL_MESSAGE_HTML'] .= $str_bottom;

		zen_mail ( '', $email_to_sales, $html_msg ['EMAIL_SUBJECT'], "", $order->customer ['name'], $order->customer ['email_address'], $html_msg, 'default1', '', 'false', $email_cc_to_sales );
		$html_msg ['EMAIL_SUBJECT'] = TEXT_CONTINUED_SUBMITTED_SUCCESSFULLY;
		zen_mail ( '', $order->customer ['email_address'], $html_msg ['EMAIL_SUBJECT'], "", 'Doreenbeads Team', $email_from, $html_msg, 'default1' );
		break;
	default :
		break;
}

global $db;
$order_query = "select orders_status,delivery_company,delivery_street_address,delivery_city,delivery_postcode,delivery_state
                        from " . TABLE_ORDERS . "
                        where orders_id = '" . $orders_id . "' limit 1";
$orders_status = $db->Execute ( $order_query );

if ($orders_status->fields ['orders_status'] == 1) {
	if (isset ( $_POST ['coupon'] ) && ( int ) $_POST ['coupon'] > 0) {
		$coupon_value = get_coupon_value ( zen_db_prepare_input($_POST ['coupon']) );
		if ($coupon_value > 0) {
			if (add_discount_amount ( (int) $orders_id, $coupon_value )) {
				$coupon_track_data = array (
						'cr_coupon_id' => zen_db_prepare_input($_POST ['coupon']),
						'cr_customers_id' => $_SESSION ['customer_id'],
						'cr_orders_id' => zen_db_prepare_input($orders_id),
						'cr_use_value' => $coupon_value,
						'cr_use_date' => 'now()'
				);
				// var_dump($order_discount_data);exit;
				zen_db_perform ( TABLE_COUPON_TRACK, $coupon_track_data );
			}
		}
	}
	if ($_SESSION ['payment'] == 'paypalwpp') {
		$sendto_query = "select  address_book_id
                        from " . TABLE_ADDRESS_BOOK . "
                        where customers_id = '" . ( int ) $_SESSION ['customer_id'] . "'
						and entry_company  like '" . $db->prepare_input ( $orders_status->fields ['delivery_company'] ) . "%'
						and entry_street_address like '" . $db->prepare_input ( $orders_status->fields ['delivery_street_address'] ) . "%'
						and entry_city like '" . $db->prepare_input ( $orders_status->fields ['delivery_city'] ) . "%'
						and entry_postcode like '" . $db->prepare_input ( $orders_status->fields ['delivery_postcode'] ) . "%'
						and entry_state like '" . $db->prepare_input ( $orders_status->fields ['delivery_state'] ) . "%'";
		$sendto = $db->Execute ( $sendto_query );

		if ($sendto->RecordCount () > 0 && $sendto->fields ['address_book_id'] > 0) {
			$_SESSION ['sendto'] = $sendto->fields ['address_book_id'];
		} else {
			$_SESSION ['sendto'] = $_SESSION ['customer_default_address_id'];
		}
		unset ( $_SESSION ['paypal_ec_temp'] );
		unset ( $_SESSION ['paypal_ec_token'] );
		unset ( $_SESSION ['paypal_ec_payer_id'] );
		unset ( $_SESSION ['paypal_ec_payer_info'] );
		if (! $payment_modules->in_special_checkout () && $payment_modules->enableDirectPayment == false) {
			zen_redirect ( zen_href_link ( 'ipn_main_handler.php', 'type=ec&markflow=1&clearSess=1&stage=final', 'SSL', true, true, true ) );
		} else {
			zen_redirect ( zen_href_link ( FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, 'SSL' ) );
		}
	} else {
		zen_redirect ( zen_href_link ( FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, 'SSL' ) );
	}
} else {
	zen_redirect ( zen_href_link ( FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, 'SSL' ) );
}

$zco_notifier->notify ( 'NOTIFY_HEADER_END_CONTINUED_ORDER' );
?>