<?php
if(!isset($_GET['img']) || $_GET['img'] == ''){
	header('HTTP/1.1 404 Not Found'); 
	header('status: 404 Not Found');
	exit();
}

$img = urldecode($_GET['img']);

$auth = substr($img, 0, 9);
if($auth != 'pan195013'){
	header('HTTP/1.1 404 Not Found'); 
	header('status: 404 Not Found');
	exit();
}

$img = substr($img, 9);
if(! $str = @file_get_contents($img)){
	header('HTTP/1.1 404 Not Found'); 
	header('status: 404 Not Found');
	exit();
}

header('Content-type: image/jpg');
echo $str;
exit();