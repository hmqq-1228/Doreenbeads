<?php
include('includes/configure.php');
include('functionsForCallback/regularlySendMailService.php');

class sendMailService{

	public function sendMailService(){
	}

	public function run($pageSize, $authString){
		global $conn1, $conn2;

		if($authString != 'AETHBS9620KFM157LQ6781'){
			return 'OMG';
		}

		$conn1 = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die(mysql_error());
		mysql_select_db(DB_DATABASE, $conn1) or die(mysql_error());

		$conn2 = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die(mysql_error());
		mysql_select_db(DB_DATABASE, $conn2) or die(mysql_error());

		$fun = new regularlySendMailService($pageSize);
		return $fun->run();
	}

}

/*
// create wsdl
include("SoapDiscovery.class.php");
$test = new SoapDiscovery('sendMailService', 'soap');
$test->getWSDL();
die();
*/

$server = new SoapServer('sendMailService.wsdl', array('soap_version' => SOAP_1_2));
$server->setClass("sendMailService");
$server->handle();
?>