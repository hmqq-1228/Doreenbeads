<?php
$time1=microtime();
require('includes/application_top.php');
function get_extension($file){
   return end(explode('.', $file));
}
if($_REQUEST['Action']=='TicketFilePath'){
	if(!isset($_FILES['Filedata'])) exit;
	$fstring = serialize($_FILES);
	$pstring = serialize($_POST);
	$attach_name = $_POST['Filename'];
	$valid_file_list = array('gif','png','jpeg','jpg','bmp','pdf');
	$file_ext = strtolower(get_extension($attach_name));
	if(!in_array($file_ext, $valid_file_list)){
		exit;
	}
	$attach_tmp = $_FILES['Filedata']['tmp_name'];
	//$upload_full_path = '/tmp/'.time().'_'.$attach_name;
	$tmp_dir = DIR_WS_IMAGES.'payment/';
	$f_guid = time();
	if (isset($_SESSION['customer_id'])) {
	  $f_guid = $_SESSION['customer_id'].'_'.$f_guid;
	}
	$upload_full_path = $tmp_dir.$f_guid.$attach_name;
	//file_put_contents('/tmp/flashfile.txt', $upload_full_path."\r\n",FILE_APPEND);
	if(!is_dir($tmp_dir)) mkdir($tmp_dir);
	$res=move_uploaded_file($attach_tmp, $upload_full_path);
	//file_put_contents('/tmp/flashfile.txt', $attach_name.':'."\r\n",FILE_APPEND);
	//file_put_contents('/tmp/flashfile.txt', $string."\r\n",FILE_APPEND);
	if($res){
		$extname = '.'.get_extension($upload_full_path);
		$new_file_name = $tmp_dir.$f_guid.$extname;
		rename($upload_full_path,$new_file_name);
		$time2=microtime();
		//file_put_contents('/tmp/flashfile.txt', ($time2-$time1)."\r\n",FILE_APPEND);
		echo $new_file_name;
	}else{
		echo 'Error';
	}
	exit;
		
}elseif($_REQUEST['action']=='delete_tmp'){
	$del_filename = $_POST['fname'];
	if(file_exists($del_filename)){
		unlink($del_filename);
	}
}elseif($_REQUEST['Action']=='oem_file'){
	$return_data = array();
	if(!isset($_FILES['file'])) {
		$return_data['error'] = true;
		echo json_encode($return_data);
		exit;
	};
	/* $fstring = serialize($_FILES);
	$pstring = serialize($_POST); */
	$attach_name = $_FILES['file']['name'];
	$valid_file_list = array('gif','png','jpeg','jpg','bmp','doc','docx');
	$file_ext = strtolower(get_extension($attach_name));
	if(!in_array($file_ext, $valid_file_list)){
		exit;
	}
	$attach_tmp = $_FILES['file']['tmp_name'];

	//$upload_full_path = '/tmp/'.time().'_'.$attach_name;
	$tmp_dir = DIR_WS_IMAGES.'oem/';

	$f_guid = time();
	if (isset($_SESSION['customer_id'])) {
		$f_guid = $_SESSION['customer_id'].'_'.$f_guid;
	}
	$upload_full_path = $tmp_dir.$f_guid.$attach_name;
	//file_put_contents('/tmp/flashfile.txt', $upload_full_path."\r\n",FILE_APPEND);
	if(!is_dir($tmp_dir)) mkdir($tmp_dir);
	
	$res=move_uploaded_file($attach_tmp, $upload_full_path);

	//file_put_contents('/tmp/flashfile.txt', $attach_name.':'."\r\n",FILE_APPEND);
	//file_put_contents('/tmp/flashfile.txt', $string."\r\n",FILE_APPEND);
	if($res){
		$extname = '.'.get_extension($upload_full_path);
		$new_file_name = $tmp_dir.$f_guid.$extname;
		rename($upload_full_path,$new_file_name);
		$time2=microtime();
		//file_put_contents('/tmp/flashfile.txt', ($time2-$time1)."\r\n",FILE_APPEND);
		$return_data['data'] = array(
				'original_attachment_name'   => $attach_name,
				'attachment_name'            => $f_guid.$extname,
				'attachment_link'            => $new_file_name
		);
		$return_data['error'] = false;
		echo json_encode($return_data);	
	}else{
		$return_data['error'] = true;
		echo json_encode($return_data);	
	}
	exit;
		
}elseif($_REQUEST['Action']=='payment_recepit'){
	$return_data = array();
	if(!isset($_POST['message'])) {
		$return_data['error'] = true;
		echo json_encode($return_data);
		exit;
	};

	$imgtype = array(
  		'gif'=>'gif',
  		'png'=>'png',
  		'jpg'=>'jpeg',
  		'jpeg'=>'jpeg'
	); //图片类型在传输过程中对应的头信息
	$message = $_POST['message']; //接收以base64编码的图片数据
	$ftype = $_POST['filetype']; //接收文件类型
	//首先将头信息去掉，然后解码剩余的base64编码的数据
	$message = base64_decode(substr($message,strlen('data:image/'.$imgtype[strtolower($ftype)].';base64,')));

	$furl = DIR_WS_IMAGES.'payment/';

	$f_guid = time();
	if (isset($_SESSION['customer_id'])) {
		$f_guid = $_SESSION['customer_id'].'_'.$f_guid;
	}

	$filename = $furl . $f_guid.".".$ftype;

	$res = file_put_contents($filename,$message);
	if ($res) {
		$return_data['error'] = false;
		$return_data['data'] = array(
				'name' => $filename
		);
	}else{
		$return_data['error'] = true;
	}
	echo json_encode($return_data);
	exit;
}

?>