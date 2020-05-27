<?php
	/**
	* auto send email;
	* the email read from file that has been created;
	* called by a crontab job;
	* author lvxiaoyong 20130916
	* @version 1.0
	*/

	include('includes/application_top.php');
	include('functionsForCallback/erpCron.php');
	$startime = microtime(true);
	$startdate = date("Y-m-d H:i:s");
	
	$erpCron = new erpCron();
	$erpCron->cron();
	file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>