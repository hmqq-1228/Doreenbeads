<?php
$f = 'lxy.csv';
$fp = fopen($f, 'r');
$imgdownConf = '../images/download/';
$imgdownDir = './';

while($data = fgetcsv($fp)){
	$img = trim($data[0]);
	if($img == '') continue;

	$img = str_replace(array('S','H'),array('',''),$img);

	if(! myGetProductImg($img, 'A')){
		file_put_contents('lxy.txt', $img.'A failed'."\n", FILE_APPEND);
	}
	if(! myGetProductImg($img, 'B')){
		file_put_contents('lxy.txt', $img.'B failed'."\n", FILE_APPEND);
	}
	if(! myGetProductImg($img, 'C')){
		file_put_contents('lxy.txt', $img.'C failed'."\n", FILE_APPEND);
	}
}

function myGetProductImg($p_code, $p_n){
	global $imgdownConf, $imgdownDir;

	$code = trim($p_code);
	if($code == '') return false;

	$remote_image = myGetImagePath($code, $p_n);
	$local_image = $imgdownDir . $code . $p_n . '.jpg';
	if(file_exists($local_image)) return true;
	if(! file_exists($remote_image)) return false;
	if(! copy($remote_image, $local_image))
		return false;
	
	return true;
}

function myGetImagePath($p_code, $p_n){
	global $imgdownConf;

	$code = trim($p_code);
	if($code == '') return false;
	$path = '';

	$dir = substr($code, 0, 1) . '/' . substr($code, 0, 3) . '/';
	$path = $imgdownConf . $dir . $code . $p_n . '.jpg';

	return $path;
}
