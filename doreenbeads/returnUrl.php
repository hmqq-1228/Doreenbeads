<?php
include './paymentlib.php';
//include './gcConfig.php';
include 'includes/application_top.php';
include 'includes/classes/order.php';
include 'includes/classes/payment.php';
$mid = '7983';

//echo $_REQUEST['EXTERNALREFERENCE'];exit;
if($_REQUEST['REF']) {
//    $xml_data = '
//    <XML>
//            <REQUEST>
//                    <ACTION>GET_ORDERSTATUS</ACTION>
//                    <META>
//                            <MERCHANTID>'. $mid .'</MERCHANTID>
//                            <IPADDRESS>64.150.189.56</IPADDRESS>
//                            <VERSION>2.0</VERSION>
//                    </META>
//                    <PARAMS>
//                            <ORDER>
//                                    <ORDERID>'. $_REQUEST['EXTERNALREFERENCE'] .'</ORDERID>
//                            </ORDER>
//                    </PARAMS>
//            </REQUEST>
//    </XML>
//    ';
    $xml_data = '<XML><REQUEST><ACTION>GET_ORDERSTATUS</ACTION>     <META><MERCHANTID>'. $mid .'</MERCHANTID><IPADDRESS>69.64.82.55</IPADDRESS><VERSION>2.0</VERSION></META>   <PARAMS><ORDER><ORDERID>'. substr($_REQUEST['REF'],10,10) .'</ORDERID></ORDER></PARAMS></REQUEST></XML>';
    $return_data = call_payment2(WEBMONEY_POST_URL, $xml_data);
    $data = simplexml_load_string($return_data);
//    var_dump($return_data);
//    echo '=====';
//    var_dump($data->REQUEST->RESPONSE->STATUS->STATUSID);
//    exit;
//    $host = "http://www.8s.com";
//    $host = "http://192.168.3.220/8seasonsorg";
//    $host = "http://old.8seasons.com";
    $host = HTTP_SERVER;
    $orderIdWeb = explode("#", $_REQUEST['EXTERNALREFERENCE']);
    $type = explode('@',$_REQUEST['EXTERNALREFERENCE']);
    if($type[1] == 'dp') {
        $redirectUrl = $host.'/index.php?main_page=checkout_success';
        $backUrl = $host.'/index.php?main_page=checkout_payment';
    } else {
        $redirectUrl = $host.'/index.php?main_page=account_history_info&order_id='.$orderIdWeb[0];
        $backUrl = $host.'/index.php?main_page=account_history_info&order_id='.$orderIdWeb[0].'&continued_order=payment';
    }
    $messageArr = array('en'=>'We are sorry, the payment was failed to made which may due to card information is incorrect, you could try again by another card if possisble. If it still failed, please kindly contact us at <a href=mailto:service@8seasons.com>service@8seasons.com</a>. Thank you for your time.',
        'fr'=>'Nous sommes désolés que vous n’avez pas payé avec succès. C’est peut-être à cause des informations incorrectes de votre carte de crédit. Veuillez essayer avec une autre carte si c’est possible. Si ?a marche pas, contactez-nous via <a href=mailto:service_fr@8seasons.com>service_fr@8seasons.com</a>. Merci!',
        'de'=>'Es tut uns leid! Die Zahlung ist misslungen vielleicht wegen der unkorrekten Karte-Informationen. Sie k?nnten mit eine andere Karte noch einmal versuchen. Wenn es noch misslungen ist, bitte kontaktieren Sie uns per <a href=mailto:service_de@8seasons.com>service_de@8seasons.com</a>.',
        'ru'=>"Нам очень жаль, что платеж был сделан не смогли, может быть из-за неправильной информации о карте, вы можете попробовать снова другую карту. Если все еще не удалось, пожалуйста, свяжитесь с нами по <a href=mailto:service_ru@8seasons.com>service_ru@8seasons.com</a>. Большое спасибо.");
//        var_dump($_SESSION['languages_code']);exit;
//    $orderIdWeb = substr(substr($_REQUEST['REF'],10,10),0,-10);
    error_log(date('Y-m-d H:i:s')."\r\norderId:".$orderIdWeb[0]."\r\nresult:".(string)$data->REQUEST->RESPONSE->RESULT."\r\nstatusId:".$data->REQUEST->RESPONSE->STATUS->STATUSID."\r\n".var_export($data, true)."\r\n\r\n",3,"log/gcLog/".$orderIdWeb[0].".log");
//    error_log('huhu',3,"log/gcLog/".$orderIdWeb[0].".log");
    if($orderIdWeb[0] > 0){
		$check_status = $db->Execute("select orders_status from " . TABLE_ORDERS . "
                                      where orders_id = '" . (int)$orderIdWeb[0] . "' limit 1");
	}else{
		$check_status->fields['orders_status'] = 0;
	}
    if ($data->REQUEST->RESPONSE->RESULT == 'OK' && ($data->REQUEST->RESPONSE->STATUS->STATUSID >= 800 || $data->REQUEST->RESPONSE->STATUS->STATUSID == 525) && $check_status->fields['orders_status'] == 1) {
//        $sql = "UPDATE zen_orders SET orders_status = 2 WHERE ".orders_id ." = " .$orderIdWeb[0];
        //$sqlOrderHistory = "INSERT INTO zen_orders_status_history (orders_id,orders_status_id,date_added,customer_notified,comments) VALUES (".$orderIdWeb[0].",2,'".date("Y-m-d H:i:s")."',1,'GC PAYMENT')";
//        mysql_query($sql);
        //mysql_query($sqlOrderHistory);
        $_SESSION['payment'] = "gcCreditCard";
        $payment = new payment($_SESSION['payment']);
        $order = new order($orderIdWeb[0]);

		/*
		wei.liang start
		gcCreditCard payer status
		2013.09.10
		*/
		$order->info['order_status'] = 2;
        $orderID = (array)$data->REQUEST->RESPONSE->STATUS->ORDERID;
		$gc_status = 'GC PAYMENT ORDERID '. $orderID[0] .'<br/>(' . TEXT_SUM . ' ' . $data->REQUEST->RESPONSE->STATUS->CURRENCYCODE . ' ' . round($data->REQUEST->RESPONSE->STATUS->AMOUNT / 100, 2) . ')';
		if($data->REQUEST->RESPONSE->STATUS->STATUSID == 525){
			$order->info['order_status'] = 42;
			$gc_status = 'GC PAYMENT ORDERID '. $orderID[0] .' statusID: '.$data->REQUEST->RESPONSE->STATUS->STATUSID;
		}
		
		$check_high_risk_customer = zen_check_high_risk_customer();
		if($check_high_risk_customer['is_high_risk'] == true){
			$order->info['order_status'] = 42;
			$gc_status .= "<br/>" . $check_high_risk_customer['info'];
		}
		$sqlOrderHistory = "INSERT INTO ".TABLE_ORDERS_STATUS_HISTORY." (orders_id,orders_status_id,date_added,customer_notified,comments) VALUES (".$orderIdWeb[0].",".$order->info['order_status'].",now(),1,'".$gc_status."')";
        $db->Execute($sqlOrderHistory);
        
        $order->order_status_update($orderIdWeb[0],$order->info['order_status'],array('transaction_id' => $orderID[0]));
        require($language_page_directory.'checkout_process.php');
        $order->send_succ_order_email($orderIdWeb[0]);
        echo "<script type='text/javascript'>";
        echo "window.parent.location.href = '".$redirectUrl."'";
        echo "</script>";
//        header("Location:".$redirectUrl);
        exit;
    }else{
//        echo 'fail to payment,3 seconds later would be redirect to payment page';
        echo "<script type='text/javascript' charset='UTF-8'>";
        echo 'window.parent.document.getElementById("errorMessage").innerHTML="'.$messageArr[$_SESSION['languages_code']].'";';
//        echo 'window.parent.document.getElementById("gcPayment").checked = false;';
//        echo 'window.parent.document.getElementById("gcPayment").checked = true;';
//        echo "window.parent.location.href = '".$backUrl."'";
        echo "window.parent.document.getElementById('CreditCardType_3').click();";
        echo "window.parent.document.getElementById('CreditCardType_1').click();";
        echo "</script>";
//        header("refresh:3;url=".$backUrl);
        exit;
    }
//    header("refresh:5;url=http://www.baidu.com");
//    var_dump($return_data->REQUEST->RESPONSE->STATUS->STATUSID);
}
?>