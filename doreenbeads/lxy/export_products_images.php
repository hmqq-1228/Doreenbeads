<?php
header('Access-Control-Allow-Origin:http://www.doreenbeads.com');

ini_set('memory_limit','256M');
@set_time_limit(52000);
chdir("../");
require ("includes/application_top.php");
chdir("lxy/");
$action = $_GET['action'];

$imgdownConf = '../download/';
$imgdownDir = './';

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
	
	if (substr($code, 0, 1) == 'B') {
		$dir = ((int) substr($code, 1, 2) + 1) . '/';
	} else {
		$dir = substr($code, 0, 3) . '/';
	}

	$path = $imgdownConf . $dir . $code . $p_n . '.jpg';

	return $path;
}

switch($action){
	case 'export_images':
		$data = explode(',', $_POST['models']);
		$return_array = array(
			'is_error' => false,
			'error_info' => '',
			'images_url' => ''
		);
		foreach ($data as $model){
			$img = trim($model);
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
		$images_dir = date('YmdH');
		
	@exec('rm -rf picture' . $images_dir . ' && rm -rf picture' . $images_dir . '.tar.gz && mkdir picture' . $images_dir . ' && mv *.jpg picture' . $images_dir . ' && tar -zcvf picture' . $images_dir . '.tar.gz picture' . $images_dir);	
		$url = 'http://download.doreenbeads.com/lxy/picture' . $images_dir . '.tar.gz';
		
		$return_array['images_url'] = $url;
		echo json_encode($return_array);
		exit;
		break;
}

