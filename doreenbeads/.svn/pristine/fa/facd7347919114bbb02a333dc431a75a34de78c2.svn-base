<?php
include('includes/application_top.php');
include('functionsForCallback/Functions_lxy.php');

class trackingno{

	public function trackingno(){}

	public function run($str_xml){
		$conn = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die(mysql_error());
		mysql_select_db(DB_DATABASE, $conn) or die(mysql_error());

		$fun = new Functions($str_xml, 'flow');
		$fun->checkForEmail();

		return $fun->success;
	}

}

/**
// create wsdl
include("SoapDiscovery.class.php");
$test = new SoapDiscovery('trackingno', 'soap');
$test->getWSDL();
die();
*/

$server = new SoapServer('trackingno.wsdl', array('soap_version' => SOAP_1_2));
$server->setClass("trackingno");
$server->handle();
?>