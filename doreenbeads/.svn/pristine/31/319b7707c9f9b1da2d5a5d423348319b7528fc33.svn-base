<?php
/**
* get a zip file, upload the files in it to the FTP; return html;
* author: lvxiaoyong 20140221
* version: 1.0
*/

set_time_limit(300);	//	limit time 5 mins

if(! isset($_FILES['ulFile'])) die('请上传ZIP文件!');
$fileName = $_FILES['ulFile']['name'];
if(substr($fileName, strrpos($fileName, '.')+1) != 'zip') die('请上传正确的ZIP(*.zip)文件!');

//move_uploaded_file($_FILES['ulFile']['tmp_name'], $ulFile);

$zip = new ZipArchive;
$zipFile = $_FILES['ulFile']['tmp_name'];
if($zip->open($zipFile) === true) {
	include('lib/classes/ftp.class.php');
	$ftp_conf = 'ftp_'.$_SESSION['site'];
	$ftp = new Ftp($$ftp_conf);

	if(! $ftp->connect())
		die('FTP连接错误!');
	if(! $ftp->chgdir($langArr[$_SESSION['lang']].'/edm'))
		die('FTP切换目录 '.$langArr[$_SESSION['lang']].'/edm 错误!');
	if(! $ftp->isdir(date('Ymd'))){
		if(! $ftp->mkdir(date('Ymd')))
			die('FTP创建目录 '.date('Ymd').' 错误!');
	}
	if(! $ftp->chgdir(date('Ymd')))
		die('FTP切换目录 '.date('Ymd').' 错误!');

	for($i = 0; $i < $zip->numFiles; $i++) {
		$filename = $zip->getNameIndex($i);
		$fileinfo = pathinfo($filename);
		$extarr = explode('.', $fileinfo['basename']);
		if(! in_array(end($extarr), $ftpAllow)){
			echo $fileinfo['basename'].' 文件格式错误,没有上传!';
			continue;
		}

		copy("zip://".$zipFile."#".$filename, 'tmp/'.$fileinfo['basename']);
		if(! $ftp->upload('tmp/'.$fileinfo['basename'], $fileinfo['basename']))
			echo 'FTP上传文件 '.$fileinfo['basename'].' 错误!';
		unlink('tmp/'.$fileinfo['basename']);
	}

	$ftp->close();
	$zip->close(); 
	echo '上传图片至FTP完成.';
}else{
	echo 'ZIP文件错误!';
}

//unlink($zipFile);
?>