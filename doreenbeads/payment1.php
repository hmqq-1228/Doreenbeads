<?php
include './paymentlib.php';
//include './gcConfig.php';
include 'includes/application_top.php';

//mysql_connect(ConfigGc::HOST, ConfigGc::USERNAME, ConfigGc::PASSWORD) or die('db err');
//mysql_connect('localhost', 'root', 'gxp195013') or die('db err');
//mysql_select_db(ConfigGc::DATABASE) or die("tb err");

//echo '<font color=blue> REQUEST KEY/VALUES </font><br>';
//foreach($_REQUEST as $iKey => $iValue)
//{
//	echo $iKey . '=>' . $iValue . '<br>';
//}

if(!isset($_REQUEST['price'])) {
	$productPrice='100';
} else {
	if($_REQUEST['currencyCode']=='UAH'){
		$productPrice=$_REQUEST['price']/$GLOBALS['currencies']->currencies['UAH']['value'];
		$productPrice = round($productPrice,0);
	}else{
		$productPrice=$_REQUEST['price'];
	}
}

if(!isset($_REQUEST['runEnv'])) {
	$runEnv=0; // test
} else {
	$runEnv=$_REQUEST['runEnv'];
}

if(!isset($_REQUEST['lanuageCode'])) {
	$languageCode='en';
} else {
	$languageCode=$_REQUEST['lanuageCode'];
}

if(!isset($_REQUEST['countryCode'])) {
	$countryCode='NL';
} else {
	$countryCode=$_REQUEST['countryCode'];
}

if(!isset($_REQUEST['currencyCode'])) {
	$currencyCode='EUR';
} else {
	if($_REQUEST['currencyCode']=='UAH'){
		$currencyCode = 'USD';
	}else{
		$currencyCode=$_REQUEST['currencyCode'];
	}
}
if(!isset($_REQUEST['popup'])) {
	$popup='CC';
} else {
	$popup=$_REQUEST['popup'];
}
$popup = '0';
if(!isset($_REQUEST['orderId'])) {
	$orderid='2009100706';
} else {
	/*Tianwen.Wan20151216->废弃查数据库取随机数
	$sqlGetRandom = "SELECT value FROM rand_value WHERE status = 0 LIMIT 1";
	$resourceRandom = mysql_query($sqlGetRandom);
	while ($rows = mysql_fetch_array($resourceRandom, MYSQL_ASSOC)) {
			$random = $rows['value'];
			$sqlUpdateRadomStatus = "UPDATE rand_value SET status = 1,`date`='".date('Ymd')."' WHERE value = ".$random;
			mysql_query($sqlUpdateRadomStatus);
	}
	if((int)$_REQUEST['merchantRef'] > 0){
		$check_gcid = $db->Execute("select gcid,random from ".DB_DATABASE."." . TABLE_ORDERS_GCID . "
                                      where orders_id = '" . (int)$_REQUEST['merchantRef'] . "' limit 1");
		if($check_gcid->fields['gcid'] > 0){
			$orderid = $check_gcid->fields['gcid'];
		}else{
			$orderid=$_REQUEST['orderId'].$random;
			$db->Execute("INSERT INTO  ".DB_DATABASE."." . TABLE_ORDERS_GCID . "(`orders_id` ,`gcid` ,`gcid_create_time` ,`gcid_modify_time`,random)VALUES (" . (int)$_REQUEST['merchantRef'] . ",  ".$orderid.",  now(),  now(),".$random.");");
		}
	}else{
			$orderid=$_REQUEST['orderId'].$random;
	}
	*/
	$random = date("is") . (mt_rand(10, 90) + mt_rand(0, 9));
	if((int)$_REQUEST['merchantRef'] > 0){
		$check_gcid = $db->Execute("select gcid,random from " . TABLE_ORDERS_GCID . "
                                      where orders_id = '" . (int)$_REQUEST['merchantRef'] . "' limit 1");
		if($check_gcid->fields['gcid'] > 0){
			$orderid = $check_gcid->fields['gcid'];
		}else{
			$orderid=$_REQUEST['orderId'].$random;
			$db->Execute("INSERT INTO  " . TABLE_ORDERS_GCID . "(`orders_id` ,`gcid` ,`gcid_create_time` ,`gcid_modify_time`,random)VALUES (" . (int)$_REQUEST['merchantRef'] . ",  ".$orderid.",  now(),  now(),".$random.");");
		}
	}else{
			$orderid=$_REQUEST['orderId'].$random;
	}
}

if(!isset($_REQUEST['merchantid'])) {
	$merchantid='9943';
} else {
	$merchantid=$_REQUEST['merchantid'];
}
//$merchantid = '4758'; // ccr test
//$merchantid = '9943'; // paul test
 
//if(!isset($_REQUEST['paymentOrderId'])) {
//	$paymentProductId='1'; // visa
//} else {
//	$paymentProductId=$_REQUEST['paymentOrderId'];
//}

if(!isset($_REQUEST['payCode'])) {
	$paymentProductId='1'; // visa
} else {
	$paymentProductId=$_REQUEST['payCode'];
}

if(!isset($_REQUEST['merchantRef'])) {
	$merchantRef ='12345678932432';
} else {
//	$merchantRef =$_REQUEST['merchantRef'];
	$merchantRef = $_REQUEST['merchantRef'].'#'.$random.'@'.$_REQUEST['type'];
}
$shippingFirstName=$_REQUEST['shippingFirstName'];
$shippingLastName=$_REQUEST['shippingLastName'];
$shippingStreet=$_REQUEST['shippingStreet'];
$shippingCity=$_REQUEST['shippingCity'];
$shippinCountryCode=$_REQUEST['shippinCountryCode'];
$shippingState=$_REQUEST['shippingState'];
$shippinZip=$_REQUEST['shippinZip'];
$phoneNumber=$_REQUEST['phoneNumber'];
$email=$_REQUEST['email'];
$firstName=$_REQUEST['firstName'];
$lastName=$_REQUEST['lastName'];
$city=$_REQUEST['city'];
$state=$_REQUEST['state'];
$street = $_REQUEST['street'];

//$payment_method='1'; // visa card
$merchantid = '7983';
//$merchantRef = "12345678932432";

//$xml_data = '<XML><REQUEST><ACTION>INSERT_ORDERWITHPAYMENT</ACTION>     <META><MERCHANTID>'. $merchantid .'</MERCHANTID><IPADDRESS>69.64.82.55</IPADDRESS><VERSION>2.0</VERSION></META>   <PARAMS><ORDER><ORDERID>'. $orderid .'</ORDERID><AMOUNT>'. $productPrice .'</AMOUNT><CURRENCYCODE>'. $currencyCode .'</CURRENCYCODE><LANGUAGECODE>'. $languageCode .'</LANGUAGECODE>               <COUNTRYCODE>'. $countryCode .'</COUNTRYCODE><SURNAME>Cruijff</SURNAME><CITY>Barcelona</CITY><FIRSTNAME>Johan</FIRSTNAME><STREET>Nou Camp</STREET><HOUSENUMBER>14</HOUSENUMBER><ZIP>1000 AA</ZIP><STATE>Catalunie</STATE><STATECODE>NL-NH</STATECODE><MERCHANTREFERENCE>'. $merchantRef .'</MERCHANTREFERENCE></ORDER><PAYMENT><PAYMENTPRODUCTID>'. $paymentProductId .'</PAYMENTPRODUCTID><AMOUNT>'. $productPrice .'</AMOUNT><CURRENCYCODE>'. $currencyCode .'</CURRENCYCODE><COUNTRYCODE>'. $countryCode .'</COUNTRYCODE><LANGUAGECODE>'. $languageCode .'</LANGUAGECODE><HOSTEDINDICATOR>1</HOSTEDINDICATOR><RETURNURL>http://www.8seasons.com/gcPayment/returnUrl.php</RETURNURL></PAYMENT></PARAMS></REQUEST></XML>';
$xml_data = '<XML><REQUEST><ACTION>INSERT_ORDERWITHPAYMENT</ACTION>     <META><MERCHANTID>'. $merchantid .'</MERCHANTID><IPADDRESS>69.64.70.182</IPADDRESS><VERSION>2.0</VERSION></META>   <PARAMS><ORDER><ORDERID>'. $orderid .'</ORDERID><AMOUNT>'. $productPrice .'</AMOUNT><SHIPPINGFIRSTNAME>'.$shippingFirstName.'</SHIPPINGFIRSTNAME><SHIPPINGSURNAME>'.$shippingLastName.'</SHIPPINGSURNAME><SHIPPINGSTREET>'.$shippingStreet.'</SHIPPINGSTREET><SHIPPINGCITY>'.$shippingCity.'</SHIPPINGCITY><SHIPPINGSTATE>'.$shippingState.'</SHIPPINGSTATE><SHIPPINGCOUNTRYCODE>'.$shippinCountryCode.'</SHIPPINGCOUNTRYCODE><SHIPPINGZIP>'.$shippinZip.'</SHIPPINGZIP><PHONENUMBER>'.$phoneNumber.'</PHONENUMBER><EMAIL>'.$email.'</EMAIL><CURRENCYCODE>'. $currencyCode .'</CURRENCYCODE><LANGUAGECODE>'. $languageCode .'</LANGUAGECODE>               <COUNTRYCODE>'. $countryCode .'</COUNTRYCODE><SURNAME>'.$lastName.'</SURNAME><CITY>'.$city.'</CITY><FIRSTNAME>'.$firstName.'</FIRSTNAME><STREET>'.$street.'</STREET><STATE>'.$state.'</STATE><STATECODE></STATECODE><MERCHANTREFERENCE>'. $merchantRef .'</MERCHANTREFERENCE></ORDER><PAYMENT><PAYMENTPRODUCTID>'. $paymentProductId .'</PAYMENTPRODUCTID><AMOUNT>'. $productPrice .'</AMOUNT><CURRENCYCODE>'. $currencyCode .'</CURRENCYCODE><COUNTRYCODE>'. $countryCode .'</COUNTRYCODE><LANGUAGECODE>'. $languageCode .'</LANGUAGECODE><HOSTEDINDICATOR>1</HOSTEDINDICATOR><RETURNURL>'.HTTPS_SERVER.'/returnUrl.php</RETURNURL></PAYMENT></PARAMS></REQUEST></XML>';
//$handle = fopen('log/sendXml.log','a');
//fwrite($handle, $xml_data."\r\n");
//$url = 'https://ps.gcsip.nl/hpp/hpp';
// test env
//$url = WEBMONEY_POST_URL;
//$url = 'https://ps.gcsip.nl/wdl/wdl'; //sandbox url
//$url = 'https://ps.gcsip.com/wdl/wdl';
//if($runEnv) { // test on Production
//	$url = 'https://ps.gcsip.com/wdl/wdl';
//}
//$url = 'http://localhost/info.php';

$return_data = call_payment2(WEBMONEY_POST_URL, $xml_data);

$responseData = simplexml_load_string($return_data);
$errorArr = array('en'=>'We\'re sorry, this payment exceeds your credit card maximum transaction limit. Please contact your bank or contact 
    <a href=mailto:service@8seasons.com>service@8seasons.com</a> for separating the order',
        'fr'=>'Nous sommes désolés que le montant que vous devez payé a dépassé la limite maximale de votre carte de crédit. Veuillez contacter la banque ou contacter notre vendeur via 
            <a href=mailto:service_fr@8seasons.com>service_fr@8seasons.com</a> à demander la séparation de la commande.',
        'de'=>'Entschuldigung! Diese Zahlung überschreitet das maximale Limit Ihrer Kreditkarte. Bitte kontaktieren Sie Ihre Bank, oder kontaktieren Sie uns per
            <a href=mailto:service_de@8seasons.com>service_de@8seasons.com</a>, wir werden Ihnen helfen, Ihre Bestellung zu trennen.',
        'ru'=>'К сожалению, этот платеж превышает максимальный предел торговли вашей кредитной карты. Пожалуйста, 
            свяжитесь со своим банком или свяжитесь с нами <a href=mailto:service_ru@8seasons.com>service_ru@8seasons.com</a> для разделения заказа.');

if ($responseData->REQUEST->RESPONSE->RESULT == 'OK') {
    echo json_encode(array('status'=>1,'response'=>(string)$responseData->REQUEST->RESPONSE->ROW->FORMACTION,'message'=>''));
    exit;
} else {
    error_log(date('Y-m-d H:i:s')."\r\norderId:".$_REQUEST['paymentOrderId']."\r\nresult:".(string)$responseData->REQUEST->RESPONSE->RESULT."\r\nerrorCode:".(string)$responseData->REQUEST->RESPONSE->ERROR->CODE."\r\n".var_export($responseData, true)."\r\n\r\n",3,"log/gcLog/".$_REQUEST['paymentOrderId'].".log");
//    echo json_encode(array('status'=>0,'response'=>(string)$responseData->REQUEST->RESPONSE->ERROR->CODE,'message'=>(string)$responseData->REQUEST->RESPONSE->ERROR->MESSAGE));
    echo json_encode(array('status'=>0,'response'=>(string)$responseData->REQUEST->RESPONSE->ERROR->CODE,'message'=>$errorArr[$_SESSION['languages_code']]));
    exit;
}
exit;
//echo $responseData->REQUEST->RESPONSE->ROW->FORMACTION;
//exit;
/***
$return_data = "<XML><REQUEST><ACTION>INSERT_ORDERWITHPAYMENT</ACTION> <META><MERCHANTID>9943</MERCHANTID><IPADDRESS>117.20.136.15</IPADDRESS><VERSION>1.0</VERSION><REQUESTIPADDRESS>192.168.41.12</REQUESTIPADDRESS></META> <PARAMS><ORDER><ORDERID>2009100605</ORDERID><AMOUNT>2345</AMOUNT> <CURRENCYCODE>SGD</CURRENCYCODE><LANGUAGECODE>en</LANGUAGECODE> <COUNTRYCODE>SG</COUNTRYCODE><SURNAME>Cruijff</SURNAME><CITY>Barcelona</CITY> <FIRSTNAME>Johan</FIRSTNAME><STREET>Nou Camp</STREET><HOUSENUMBER>14</HOUSENUMBER><ZIP>1000 AA</ZIP> <STATE>Catalunie</STATE><STATECODE>NL-NH</STATECODE><MERCHANTREFERENCE>2009100605</MERCHANTREFERENCE></ORDER><PAYMENT><PAYMENTPRODUCTID>1</PAYMENTPRODUCTID> <AMOUNT>2345</AMOUNT><CURRENCYCODE>SGD</CURRENCYCODE><COUNTRYCODE>SG</COUNTRYCODE> <LANGUAGECODE>en</LANGUAGECODE><HOSTEDINDICATOR>1</HOSTEDINDICATOR> <RETURNURL>http://www.java.kr/gc/thankyou.html</RETURNURL></PAYMENT></PARAMS><RESPONSE><RESULT>OK</RESULT><META><REQUESTID>807320</REQUESTID><RESPONSEDATETIME>20091006085510</RESPONSEDATETIME></META><ROW><REF>000000994320091006050000100001</REF><EFFORTID>1</EFFORTID><PAYMENTREFERENCE>0</PAYMENTREFERENCE><MAC>1IhcH2f1c2std1ZRiUUTCM1rCNDYEZR63fzBo3k+308=</MAC><STATUSDATE>20091006085510</STATUSDATE><STATUSID>20</STATUSID><ADDITIONALREFERENCE>2009100605</ADDITIONALREFERENCE><FORMMETHOD>GET</FORMMETHOD><EXTERNALREFERENCE>2009100605</EXTERNALREFERENCE><ATTEMPTID>1</ATTEMPTID><ORDERID>2009100605</ORDERID><RETURNMAC>YZmz6FDHTuU3MVFmrA14K2c6ACG0BMISV4a4suzLAkM=</RETURNMAC><FORMACTION>https://ps.gcsip.nl/orb/orb?ACTION=DO_START&amp;REF=000000994320091006050000100001&amp;MAC=1IhcH2f1c2std1ZRiUUTCM1rCNDYEZR63fzBo3k%2B308%3D</FORMACTION><MERCHANTID>9943</MERCHANTID></ROW></RESPONSE></REQUEST></XML>";
***/

$doc = new DOMDocument();
$doc->loadXML($return_data);

if(($response_result = $doc->getElementsByTagName('RESULT')->item(0)->nodeValue) == 'NOK'){
	echo 'ERROR_RETURNED::==>' ; 
	echo '<xmp>';
	print_r($return_data);
	echo '</xmp>';
	exit;
};

?>
<html>
<head>
<Script>
var newwindow;
function runpopup(url)
{
	newwindow=window.open(url,'_payment','toolbar=no,menubar=no,location=no,directories=no');
	if (window.focus) {newwindow.focus()}
}
</Script>
</head>
<body>
<?php
//echo '<BR><BR><font color=blue> XML RESPONSE FROM GC ::: </font><br>';
//echo "RESPONSE::RESULT:: " . $doc->getElementsByTagName('RESULT')->item(0)->nodeValue . "<BR>";
//echo "RESPONSE::REF:: " . $doc->getElementsByTagName('REF')->item(0)->nodeValue . "<BR>";
//echo "RESPONSE::RETURNMAC:: " . $doc->getElementsByTagName('RETURNMAC')->item(0)->nodeValue . "<BR>";
$formaction = $doc->getElementsByTagName('FORMACTION')->item(0)->nodeValue;
//echo "RESPONSE::FORMACTION:: " . $formaction . "<BR>";


/*************
$p = xml_parser_create_ns();
xml_parse_into_struct($p, $return_data, $vals, $index);
xml_parser_free($p);
echo "Index array\n";
echo '<xmp>';
print_r($index);
echo "\nVals array\n";
print_r($vals);
echo '</xmp>';
****************/

?>
<?php



if($popup == '0') { // in parent brwoser
//echo '<BR><BR><font color=blue> IFRAME WILL BE SHOWING ::: </font></br>';
	?>
<iframe width="100%" height="1000" FrameBorder="0"  src="<?php echo $formaction; ?>" ></iframe>
<?php
} else { // popup browser
?>

<a href="javascript:runpopup('<?php echo urlencode($formaction); ?>');">Click here for Pop-up Redirection</a> <br><br>
<a href="javascript:runpopup('./popupiframe.php?url=<?php echo urlencode(urlencode($formaction)); ?>');">Click here for Pop-up Iframe</a><br>

<?php
}
?>

</body>
</html>