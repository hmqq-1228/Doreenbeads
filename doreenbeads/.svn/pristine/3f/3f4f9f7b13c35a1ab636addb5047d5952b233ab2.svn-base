<?php
chdir("../");
ini_set('soap.wsdl_cache_enabled','0');//关闭缓存
include('includes/application_top.php');
include('functionsForCallback/Functions_lxy.php');

class orders_status_update{

	public function orders_status_update(){}

	public function run($str_xml){
		$conn = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die(mysql_error());
		mysql_select_db(DB_DATABASE, $conn) or die(mysql_error());

		$fun = new Functions($str_xml, 'flow');
		$fun->orders_status_update();

		return $fun->success;
	}

}
$client = new orders_status_update;
$str_xml = file_get_contents("web_services/orders_status_update_request.xml");
$ret = $client->run($str_xml);
print_r($ret);
// $server = new SoapServer('web_services/orders_status_update.wsdl', array('soap_version' => SOAP_1_2));
// $server->setClass("orders_status_update");
// $server->handle();
?>