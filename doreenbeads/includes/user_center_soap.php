<?php
/**
 * 
 * Init user center api soap connect, authorized by soap header
 * @author zhanghongliang
 * @version allwebs V1.00 2013-04-07
 */
//$cli = new SoapClient(null, array('uri' => 'http://userapi/accountService/', 'location' => 'http://userapi/api_user_center.php', 'trace' => true));
$cli = new SoapClient(null, array('uri' => 'http://localhost/userCenter/accountService/', 'location' => 'http://localhost/userCenter/api_user_center.php', 'trace' => true));
$authvalues = new SoapVar(array('username'=>'my_site','password' => '12345678',), SOAP_ENC_OBJECT); //soap authorize

$sh = new SoapHeader('namespace', 'apiAccessAuth', $authvalues, false, SOAP_ACTOR_NEXT);
$cli->__setSoapHeaders(array($sh));

?>