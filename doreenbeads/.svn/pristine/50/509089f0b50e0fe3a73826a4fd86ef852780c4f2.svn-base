<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<style> 
	.btn_blue{cursor:pointer;font-size:16px; border-radius:5px; background-color:#5579c3;color:#fff; line-height:40px; padding:0 20px; height:40px; display:inline-block; text-align:center; font-size:16px; width:60%; border: none;}
	</style>
    <script src="https://js.braintreegateway.com/web/dropin/1.18.0/js/dropin.min.js"></script>
</head>
<body> 

<?php
/**
 * checkout_braintree header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4793 2015-12-11 10:25:20Z Tianwen.Wan $
 */
define('DEBUG_MODE_PANDUO', true);
//require($language_page_directory.'checkout_process.php');
$orderId = (int)$_GET['order_id'];
$paymentMethodNonce = $_POST['payment_method_nonce'];
$go = $_GET['go'];
$action = $_GET['action'];

require_once(DIR_WS_INCLUDES . 'braintree-php-3.40.0/lib/autoload.php');
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_payment.php');
require(DIR_WS_CLASSES . 'order.php');

$merchantAccountId = BRAINTREE_MERCHANTACCOUNTID;

if($orderId > 0){
    $order = new order($orderId);
    if(intval($order->info['orders_status_id']) != 1) {
        echo "<script>window.parent.location.href='" . str_replace("&amp;", "&", zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orderId . '', 'SSL', false)) . "';</script>";
        exit;
    }

    $braintreeAmount = $order->info['total'];
    $currencyCode = $order->info['currency'];

    if(strstr(BRAINTREE_SUPPORT_CURRENCY_VALUE, ',' . $currencyCode . ',') != "") {
        $merchantAccountId = BRAINTREE_SUPPORT_CURRENCY_PREFIX . substr(strstr(BRAINTREE_SUPPORT_CURRENCY_VALUE, ',' . $order->info['currency'] . ','), 1, 3);
        $braintreeAmount = $currencies->format_cl($order->info['total'], true, $order->info['currency'], $order->info['currency_value']);
    }
}

Braintree_Configuration::environment(BRAINTREE_ENVIRONMENT);
Braintree_Configuration::merchantId(BRAINTREE_MERCHANTID);
Braintree_Configuration::publicKey(BRAINTREE_PUBLICKEY);
Braintree_Configuration::privateKey(BRAINTREE_PRIVATEKEY);

$paymentClientToken = Braintree_ClientToken::generate(['merchantAccountId' => $merchantAccountId]);


if(!empty($paymentMethodNonce) && $orderId > 0 && $braintreeAmount > 0) {
	$_SESSION['payment'] = 'braintree';
	require(DIR_WS_CLASSES . 'payment.php');
	$payment = new payment('braintree');

	$deviceData = $_POST["device_data"];

	$result = Braintree_Transaction::sale([
	  'amount' => $braintreeAmount,
	  'orderId' => $orderId,
	  'merchantAccountId' => $merchantAccountId,
	  //'paymentMethodNonce' => 'fake-valid-visa-nonce',
	  'paymentMethodNonce' => $paymentMethodNonce,
	  'customer' => [
		'firstName' => $order->delivery['name'],
		'lastName' => '',
		'company' => $order->delivery['company'],
		'phone' => $order->delivery['telephone'],
		'fax' => '',
		'website' => '',
		'email' => $order->customer['email_address']
	  ],
	  'billing' => [
		'firstName' => $order->delivery['name'],
		'lastName' => '',
		'company' => $order->delivery['company'],
		'streetAddress' => $order->delivery['street_address'],
		'extendedAddress' => $order->delivery['suburb'],
		'locality' => '',
		'region' => '',
		'postalCode' => $order->delivery['postcode'],
		'countryCodeAlpha2' => $order->delivery['country_iso_code_2']
	  ],
	  'shipping' => [
		'firstName' => $order->delivery['name'],
		'lastName' => '',
		'company' => $order->delivery['company'],
		'streetAddress' => $order->delivery['street_address'],
		'extendedAddress' => $order->delivery['suburb'],
		'locality' => '',
		'region' => '',
		'postalCode' => $order->delivery['postcode'],
		'countryCodeAlpha2' => $order->delivery['country_iso_code_2']
	  ],
	  'options' => [
		'submitForSettlement' => false
	  ],
	  'customFields' => [
		'fraud_site_id' => FRAUD_SITE_ID
	  ],
	  'deviceData' => $deviceData,
	  'channel' => 'MyShoppingCartProvider'
	]);
	
	$dir = "log/braintree/" . date("Ym", time());
	if(!is_dir($dir)) {
		mkdir($dir);
	}
	$handle = fopen($dir . "/" . $orderId . ".txt", "a");
	fwrite($handle, date("Y-m-d H:i:s") . "\n" . var_export($result, true) . "\n\n");
	fclose($handle);
	
	include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php');
	if($result->success == true) {
		//授权成功，检查Kount结果
		if($result->transaction->status == "authorized") {
			$handle = fopen($dir . "/" . $orderId . ".txt", "a");
			fwrite($handle, date("Y-m-d H:i:s") . "\n" . var_export($result->transaction->riskData, true) . "\n\n");
			fclose($handle);
	
			$kount_id = strtoupper($result->transaction->riskData->id);
			$decision = strtolower($result->transaction->riskData->decision);
			
			$is_risk = true;
			//批准交易，进行扣款
			if(in_array($decision, array('approve', 'not evaluated'))) {
				$is_risk = false;
			//人工审查交易
			} else if(in_array($decision, array('review', 'escalate'))) {
				
			/*处理无效状态
             * Kount Decision = 'Declined'的情况不应该出现，因为交易结果会失败
             * Kount Decision 为空可能出现，因为某些支付方式，比如Apple Pay不支持Kount
            */
			} else {
				
			}
			include(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/payment/', '' . $_SESSION['payment'] . '.php', 'false'));
			$order->info['orders_status_id'] = 1;
			
			if(!$is_risk || $result->transaction->paymentInstrumentType == 'paypal_account') {
				$settlement_result = Braintree_Transaction::submitForSettlement($result->transaction->id);
				$handle = fopen($dir . "/" . $orderId . ".txt", "a");
				fwrite($handle, date("Y-m-d H:i:s") . "\n" . var_export($result->transaction->riskData, true) . "\n\n");
				fclose($handle);
				if($settlement_result->success == true) {
					$order->info['orders_status_id'] = 2;
					$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES');
				}
			} else {
				$order->info['orders_status_id'] = 42;
				$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES');
				
				//Tianwen.Wan20160510->如果kount返回的id不为空，插入关联表，下次kount回调数据时通过kount_id找到braintree_id通知braintree进行扣款
				if(!empty($kount_id)) {
					$sql_data_array = array (
						'orders_id' => $orderId,
						'kount_id' => $kount_id,
						'braintree_id' => $result->transaction->id,
						'kount_callback' => 10,
						'kount_callback_xml' => "",
						'date_created' => 'now()'
					);
					zen_db_perform(TABLE_ORDERS_BRAINTREE_KOUNT_RELATION, $sql_data_array);
				}
				
			}
			
			if(intval($order->info['orders_status_id']) != 1) {
				$check_high_risk_customer = zen_check_high_risk_customer();
				$gc_status = 'Braintree Transaction Id:' . $result->transaction->id;
				if($check_high_risk_customer['is_high_risk'] == true) {
					$order->info['orders_status_id'] = 42;
					$gc_status .= "<br/>" . $check_high_risk_customer['info'];
				}else if($order->info['orders_status_id'] == 42) {
					$gc_status .= "<br/>" . "Status source:Braintree";
				}

                if($result->transaction->paymentInstrumentType == 'credit_card'){
                    $braintree_detail_code = 'credit';
                }elseif($result->transaction->paymentInstrumentType == 'android_pay_card'){
                    $braintree_detail_code = 'google';
                }elseif($result->transaction->paymentInstrumentType == 'apple_pay_card'){
                    $braintree_detail_code = 'apple';
                }else{
                    $braintree_detail_code = 'credit';
                }
				
				$sqlOrderHistory = "INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id,orders_status_id,date_added,customer_notified,comments) VALUES (".$result->transaction->orderId.",".$order->info['orders_status_id'].",now(),1,'".$gc_status."')";
			    $db->Execute($sqlOrderHistory);
			    $order->order_status_update($result->transaction->orderId,$order->info['orders_status_id'], array('transaction_id' => $result->transaction->id, 'payment_code' => "braintree", 'braintree_detail_code' => $braintree_detail_code));
			    $order->send_succ_order_email($result->transaction->orderId);
			}
			//unset($_SESSION['payment']);
			$goPage = !empty($go) ? $go : FILENAME_ACCOUNT_HISTORY_INFO;
			echo "<script>window.parent.location.href='" . str_replace("&amp;", "&", zen_href_link($goPage, 'order_id=' . $orderId . '', 'SSL', false)) . "';</script>";
		}
		
	} else {
		//echo "<h1>Order Id:" . $orderId . " " . $result->_attributes['message'] . "</h1>";
		echo "<script>window.parent.document.getElementById('errorMessage').scrollIntoView();window.parent.document.getElementById('errorMessage').display = 'block';window.parent.document.getElementById('errorMessage').innerHTML = '" . TEXT_PAYMENT_FAILURE . "';window.location.href='" . HTTP_SERVER . "/index.php?main_page=checkout_braintree&order_id=" . $orderId . "&go=" . $go . "';</script>";
	}
	unset($_SESSION['payment']);
} else {
    switch($action){
        case 'google':
            $payment_extra = 'googlePay: {
            merchantId: "' . GOOGLE_PAYMENT_MERCHANT_ID . '",
            googlePayVersion: 2,
                transactionInfo: {
                totalPriceStatus: "FINAL",
                    totalPrice: "' . $braintreeAmount . '",
                    currencyCode: "' . $currencyCode . '"
            }
        }';
            break;
        case 'apple':
            $payment_extra = 'applePay: {
            displayName: "8seasons",
                paymentRequest: {
                total: {
                    label: "8seasons",
                        amount: "' . $braintreeAmount . '"
                }
            }
        }';
            break;
        default:

            break;
    }
    echo '<form id="checkout_form" method="post" action="' . HTTP_SERVER . '/index.php?main_page=checkout_braintree&order_id=' . $orderId . '&go=' . $go . '">
            <div id="payment-form"></div>
            <input type="hidden" id="device_data" name="device_data">
            <input type="hidden" id="payment_method_nonce" name="payment_method_nonce">
            <button id="braintree_button" class="btn_blue" type="button">
							  <span>
                    <strong>Pay now</strong>
                </span>
            </button>
		   </form>
	<script>
	// We generated a client token for you so you can test out this code
	// immediately. In a production-ready integration, you will need to
	// generate a client token on your server (see section below).
	var button = document.querySelector("#braintree_button");

    braintree.dropin.create({
        authorization: "' . $paymentClientToken . '",
        container: "#payment-form",
        dataCollector: {
            kount: true
        },
    ' . $payment_extra .'

    }, function (createErr, instance) {
        button.addEventListener("click", function () {
            instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
              document.getElementById("payment_method_nonce").value = payload.nonce;
              document.getElementById("device_data").value = payload.deviceData;
              
              var form = document.getElementById("checkout_form");
              form.submit();
            });
        });
        
        if (instance.isPaymentMethodRequestable()) {
          // This will be true if you generated the client token
          // with a customer ID and there is a saved payment method
          // available to tokenize with that customer.
          button.removeAttribute("disabled");
        }
        
        instance.on("paymentMethodRequestable", function (event) {
            if(event.paymentMethodIsSelected  == true){
                button.click();
            }
        });
        
        instance.on("noPaymentMethodRequestable", function () {
          button.setAttribute("disabled", true);
        });
    });
	</script>';
}

?>
</body>
</html>
<?php
exit;
?>