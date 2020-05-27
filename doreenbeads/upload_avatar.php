<?php
include('includes/application_top.php');
class ImageResize
{
	var $_img;
	var $_imagetype;
	var $_width;
	var $_height;
	

	function load($img_name, $img_type=''){
		if(!empty($img_type)) $this->_imagetype = $img_type;
		else $this->_imagetype = $this->get_type($img_name);
		//$size=getimagesize($img_name);
		//print_r($size);
		switch ($this->_imagetype){
			case 'gif':
				if (function_exists('imagecreatefromgif'))	$this->_img=imagecreatefromgif($img_name);
				break;
			case 'jpg':
				$this->_img=imagecreatefromjpeg($img_name);
				break;
			case 'png':
				$this->_img=imagecreatefrompng($img_name);
				break;
			default:
				$this->_img=imagecreatefromstring($img_name);
				break;
		}
		$white=imagecolorallocate($this->_img,255,255,255);
		imagecolortransparent($this->_img,$white); 
		//imagefilledrectangle($this->_img, 0, 0, $size[0], $size[1], $black);
		$this->getxy();
	}

	function resize($width, $height, $percent=0)
	{
		if(!is_resource($this->_img)) return false;
		if(empty($width) && empty($height)){
			if(empty($percent)) return false;
			else{
				$width = round($this->_width * $percent);
				$height = round($this->_height * $percent);
			}
		}elseif(empty($width) && !empty($height)){
			$width = round($height * $this->_width / $this->_height );
		}else{
			$height = round($width * $this->_height / $this->_width);
		}
		$tmpimg = imagecreatetruecolor($width,$height);
		if(function_exists('imagecopyresampled')) imagecopyresampled($tmpimg, $this->_img, 0, 0, 0, 0, $width, $height, $this->_width, $this->_height);
		else imagecopyresized($tmpimg, $this->_img, 0, 0, 0, 0, $width, $height, $this->_width, $this->_height);
		$this->destroy();
		$this->_img = $tmpimg;
		$this->getxy();
	}
	function cut($width, $height, $x=0, $y=0){
		if(!is_resource($this->_img)) return false;
		if($width > $this->_width) $width = $this->_width;
		if($height > $this->_height) $height = $this->_height;
		if($x < 0) $x = 0;
		if($y < 0) $y = 0;
		$tmpimg = imagecreatetruecolor($width,$height);
		imagecopy($tmpimg, $this->_img, 0, 0, $x, $y, $width, $height);
		$this->destroy();
		$this->_img = $tmpimg;
		$this->getxy();
	}
	
	
	function display($destroy=true)
	{
		if(!is_resource($this->_img)) return false;
		switch($this->_imagetype){
			case 'jpg':
			case 'jpeg':
				header("Content-type: image/jpeg");
				imagejpeg($this->_img);
				break;
			case 'gif':
				header("Content-type: image/gif");
				imagegif($this->_img);
				break;
			case 'png':
			default:
				header("Content-type: image/png");
				imagepng($this->_img);
				break;
		}
		if($destroy) $this->destroy();
	}

	function save($fname, $destroy=false, $type='')
	{
		if(!is_resource($this->_img)) return false;
		if(empty($type)) $type = $this->_imagetype;
		switch($type){
			case 'jpg':
			case 'jpeg':
				$ret=imagejpeg($this->_img, $fname);
				break;
			case 'gif':
				$ret=imagegif($this->_img, $fname);
				break;
			case 'png':
			default:
				$ret=imagepng($this->_img, $fname);
				break;
		}
		if($destroy) $this->destroy();
		return $ret;
	}
	
	function destroy()
	{
		if(is_resource($this->_img)) imagedestroy($this->_img);
	}
	
	function getxy()
	{
		if(is_resource($this->_img)){
			$this->_width = imagesx($this->_img);
			$this->_height = imagesy($this->_img);
		}
	}
	

	function get_type($img_name)//��ȡͼ���ļ�����
	{
		if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $img_name, $matches)){
			$type = strtolower($matches[1]);
		}else{
			$type = "string";
		}
		return $type;
	}
}
global $num;
$num=0;
$error=1;
$upload_dir = DIR_WS_USER_AVATAR; 				
$max_file = "51200"; 
$valid_exp=array('jpg','gif','png');					
function scandir_image($dir,$exc,$files){
	$file=scandir($dir);
	foreach ($file as $val){
	if($val!='.'&&$val!='..'&&$val!=$exc){
		if(is_dir($dir.'/'.$val)){
			scandir_image($dir.'/'.$val,$exc,$files);
		}else{
			$str=explode('.', $val);
			$exp=end($str);
			if($exp=='jpg'||$exp=='gif'||$exp=='png'){
				$num++;
				if($num>=4){
					echo '<td>'.zen_image($dir.'/'.$val).'</td></tr><tr>';
					$num=0;
				}else{
					echo '<td>'.zen_image($dir.'/'.$val).'</td>';
				}
				
			}
		}
	}
}
}

$action = (isset($_POST['action']) ? $_POST['action'] : '');
if (zen_not_null($action)) {
	$avatar_check_email_arr = array(
			1 => 'sale@doreenbeads.com',
			2 => 'service_de@doreenbeads.com',
			3 => 'service_ru@doreenbeads.com',
			4 => 'service_fr@doreenbeads.com'
	);
  	switch($action){
  		case 'upload_default_avatar':
  		if(isset($_POST['user_avatar'])&&zen_not_null($_POST['user_avatar'])){
  			$user_avatar=$_POST['user_avatar'];
  			$update_avatar_query='update '.TABLE_CUSTOMERS_INFO.' set customers_info_avatar_date_updated="'.date('Y-m-d H:i:s').'" ,customers_info_avatar="'.$user_avatar.'" ,customers_info_avatar_check_status = 1 ,customers_info_avatar_tmp = "" ,customers_info_avatar_check = "" where customers_info_id='.$_SESSION['customer_id'].' ';
  			$db->Execute($update_avatar_query);
  			//zen_redirect(zen_href_link(ACCOUNT_EDIT));
  		}
  		break;
  		case 'upload_local_image'	:
	  	$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$userfile_size = $_FILES['image']['size'];
		$filename = basename($_FILES['image']['name']);
		$file_ext = substr($filename, strrpos($filename, '.') + 1);
		$error_info='';
		if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
			if(!in_array($file_ext, $valid_exp)){
				$error=2;
				$error_info=TEXT_FILE_FOEMAT_NOT_SUPPORTED;
			}elseif($userfile_size > $max_file){
				$error=3;
				$error_info=TEXT_AVATAR_ERROR_MAX;
			}else{
				$error=0;
				$check_tmp_query="select customers_info_avatar_tmp from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$_SESSION['customer_id']." ";
				$check_tmp=$db->Execute($check_tmp_query);
				if($check_tmp->RecordCount()>0){
					unlink(DIR_WS_USER_AVATAR.'tmp/'.$check_tmp->fields['customers_info_avatar_tmp']);
					unlink(DIR_WS_USER_AVATAR.'tmp_s/'.$check_tmp->fields['customers_info_avatar_tmp']);
				}
				$new_avatar='c'.$_SESSION['customer_id'].'_'.randomkeys(3).'.'.$file_ext;
				move_uploaded_file($userfile_tmp,DIR_WS_USER_AVATAR.'tmp/'.$new_avatar);
				$update_tmp_query='update '.TABLE_CUSTOMERS_INFO.' set customers_info_avatar_tmp="'.$new_avatar.'" where customers_info_id='.$_SESSION['customer_id'].' ';
				$db->Execute($update_tmp_query);
			}
		} else {
			$error_info = TEXT_AVATAR_ERROR_MAX;
		}
  		break;
  		case 'upload_final_avatar':
  		$check_tmp_query="select customers_info_avatar_tmp,customers_info_avatar_check from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$_SESSION['customer_id']." ";
		$check_tmp=$db->Execute($check_tmp_query);
		//echo $check_tmp->fields['customers_info_avatar_tmp'];
  		$imgresize = new ImageResize(); 
  		$ext= substr($check_tmp->fields['customers_info_avatar_tmp'], strrpos($check_tmp->fields['customers_info_avatar_tmp'], '.') + 1);
  		$imgresize->load(DIR_WS_USER_AVATAR.'tmp/'.$check_tmp->fields['customers_info_avatar_tmp'],$ext);
		$posary=explode(',', $_REQUEST['cut_pos']);
		  		
		
		foreach($posary as $k=>$v) $posary[$k]=intval($v); 
		if($posary[2]>0 && $posary[3]>0) $imgresize->resize($posary[2], $posary[3]);
		$imgresize->cut(120, 120, intval($posary[0]), intval($posary[1]));
		$imgresize->resize(100, 100);
		$imagerrortips = $imgresize->_width == 100 ?  "" : TEXT_AVATAR_ERROR_MAX;
		$imgresize->save(DIR_WS_USER_AVATAR.'tmp_s/'.$check_tmp->fields['customers_info_avatar_tmp']);
		//if
		//$tips=TEXT_UPLOAD_FOR_CHECKING;
  		break;
  		case 'submit_avatar':
  		$check_tmp_query="select customers_info_avatar_tmp,customers_info_avatar_check from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$_SESSION['customer_id']." ";
		$check_tmp=$db->Execute($check_tmp_query);
		unlink(DIR_WS_USER_AVATAR.$check_tmp->fields['customers_info_avatar_check']);
		$avatar_check='current/'.$check_tmp->fields['customers_info_avatar_tmp'];
		
		$customers_lan_query = $db->Execute("select register_languages_id from " . TABLE_CUSTOMERS . " where customers_id =" . $_SESSION['customer_id']);
		$customers_language = $customers_lan_query->fields['register_languages_id'];
		
		copy(DIR_WS_USER_AVATAR.'tmp_s/'.$check_tmp->fields['customers_info_avatar_tmp'],DIR_WS_USER_AVATAR.$avatar_check);
		$update_avatar_query='update '.TABLE_CUSTOMERS_INFO.' set  customers_info_avatar_date_updated="'.date('Y-m-d H:i:s').'" , customers_info_avatar_check_status =1 , customers_info_avatar="'.$avatar_check.'" where customers_info_id='.$_SESSION['customer_id'].' ';
		$db->Execute($update_avatar_query);
		$tips=TEXT_AVATAR_UPLOAD_SUCCESSFULLY; 
		$html_msg['EMAIL_CONTENT_TEXT']=sprintf(TEXT_AVATAR_CUSTOMER_SUBMIT_TEXT, $_SESSION['customer_first_name'] . $_SESSION['customer_last_name'] ,$_SESSION['customer_email'] , zen_image(DIR_WS_USER_AVATAR.$avatar_check) );
		$html_text=sprintf(TEXT_AVATAR_CUSTOMER_SUBMIT_TEXT, $_SESSION['customer_first_name'] . $_SESSION['customer_last_name'] ,$_SESSION['customer_email'] , zen_image(DIR_WS_USER_AVATAR.$avatar_check) );
		$send_email_address = $_SESSION['customer_email'];
		$send_email_name = $_SESSION['customer_first_name'] . $_SESSION['customer_last_name'];
		zen_mail('',$avatar_check_email_arr[$customers_language],'有客户提交更换头像申请',$html_text,$send_email_name,$send_email_address,$html_msg,'avatar_checking','','false');
  		break;
  	}
  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
body{
	font-family:arial;
	padding:0px;
	margin:0px;
}
#show_default_avatar{
	border:3px dotted #bbb;
margin:10px 0px 20px 0px;
border-radius:3px;
}
#show_default_avatar img{
	border:1px solid #fff;
}

#show_user_current_avatar{
	padding-top:10px;

}
#show_user_current_avatar img{
	border:3px solid orange;
	border-radius:5px;
max-width:100px;
max-height:100px;
_height:100px;
}
#Cropped_picture{
	width:500px;
margin:auto;
margin-top:80px;
}
#cp_div img{
	border:5px solid orange;
border-radius:5px;
padding:2px;
margin-top:20px;
}
</style>
<script type="text/javascript" src="includes/templates/cherry_zen/jscript/jscript_jquery.js"></script>
</head>
<body>
<?php if($error==0||$_POST['had_upload_success']==1){
	?>
<script language="javascript" type="text/javascript" src="includes/templates/cherry_zen/jscript/drag.js"></script>	
	
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td width=25>
<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'step_chose.jpg');?></td>
<td width=35><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'step_chose.jpg');?></td>
<td><?php echo TEXT_UPLOAD_LOCAL_IMG;?></td></tr></table>

<?php 
$select_tmp_query="select customers_info_avatar_tmp from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$_SESSION['customer_id']." ";
$select_tmp=$db->Execute($select_tmp_query);
//echo  '<img  src="'.DIR_WS_USER_AVATAR.'tmp/'.$select_tmp->fields['customers_info_avatar_tmp'].'">'		
?>


<div  style="padding-top:20px;color:#1FA21C;text-align:center;">
	<?php 
	if($tips!=''){
	echo $tips;
	}
	?>
</div>
<div id="Cropped_picture">
<table width="100%" border="0" style="">
  <tr>
    <td  valign="top">

<form name="setavatar" id="setavatar" action="upload_avatar.php" method="post" onsubmit="return getcutpos();">
<input type="hidden" value="1" name="had_upload_success">
<input type="hidden" value="upload_final_avatar" name="action">
 <div id="cut_div" style="border:2px solid #888888; width:284px; height:266px; overflow: hidden; position:relative; top:0px; left:0px; margin:4px; cursor:pointer;">
 <table style="border-collapse: collapse; z-index: 10; filter: alpha(opacity=75); position: relative; left: 0px; top: 0px; width: 284px;  height: 266px; opacity: 0.75;" cellspacing="0" cellpadding="0" border="0" unselectable="on">
 <tr>
   <td style="background: #cccccc; height: 73px;" colspan="3"></td>
 </tr>
 <tr>
   <td style="background: #cccccc; width: 82px;"></td>
   <td style="border: 1px solid #ffffff; width: 120px; height: 120px;"></td>
   <td style="background: #cccccc; width: 82px;"></td>
 </tr>
 <tr>
   <td style="background: #cccccc; height: 73px;" colspan="3"></td>
 </tr>
 </table>
 <img id="cut_img" style="position:relative; top:-266px; left:0px" src="<?php echo DIR_WS_USER_AVATAR.'tmp/'.$select_tmp->fields['customers_info_avatar_tmp'];?>?t=<?php echo time();?>" />
</div>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td><img style="margin-top: 5px; cursor:pointer;"  src="images/Users/images/_h.gif" alt="图片缩小" onmouseover="this.src='images/Users/images/_c.gif'" onmouseout="this.src='images/Users/images/_h.gif'" onclick="imageresize(false)" /></td>
    <td><img id="img_track" style="width: 250px; height: 18px; margin-top: 5px" src="images/Users/images/track.gif" /></td>
    <td><img style="margin-top: 5px; cursor:pointer;" src="images/Users/images/+h.gif" alt="图片放大"  onmouseover="this.src='images/Users/images/+c.gif'" onmouseout="this.src='images/Users/images/+h.gif'" onclick="imageresize(true)" /></td>
  </tr>
</table>
<img id="img_grip" style="position:absolute; z-index:100; left:-1000px; top:-1000px; cursor:pointer;" src="images/Users/images/grip.gif" /> <div style="padding-top:15px; padding-left:5px;">
<input type="hidden" name="cut_pos" id="cut_pos" value="" />
<input type="submit" class="button" name="submit"  id="submit" value=" <?php echo TEXT_CUT;?> " />
</div>
</form>

<div style="margin-top:2px;">
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<input type="hidden" name="action" value='upload_local_image'>
<p style="padding: 8px;margin-top:-1px;margin-bottom:-1px; font-size:14px;"><?php echo " ".TEXT_RECHANGE_PIC.":";?></p>&nbsp;<input type="file" name="image" size="30" /> <input type="submit" name="upload" value="<?php echo TEXT_UPLOAD;?>" />
</form>
</div>
<div style="margin-top:10px; color:red;">
	<?php echo $imagerrortips;?>
</div>
	</td>
    <td valign="top">
	<?php echo TEXT_CROPPED_PICTURE;?> :
	<div id="cp_div">
	<?php 
	if($_POST['had_upload_success']==1){
		?>
		<form action="upload_avatar.php" method="post">
	<?php 
	echo '<img src="'.DIR_WS_USER_AVATAR.'tmp_s/'.$check_tmp->fields['customers_info_avatar_tmp'].'?t='.time().'" style="max-height:100px;" >';
	?>
	<br><br>
	<input type="hidden" name="action" value="submit_avatar" />
	<input type="hidden"  name="had_upload_success" value="1" />
	<input type="submit" value=" <?php echo TEXT_SUBMIT;?> " />
	</form>
	<?php 
	}
	?>
	
	</div>
	</td>
  </tr>
</table>
</div>


<script language="javascript" type="text/javascript">
	var cut_div;  //裁减图片外框div
	var cut_img;  //裁减图片
	var imgdefw;  //图片默认宽度
	var imgdefh;  //图片默认高度
	var offsetx = 82; //图片位置位移x
	var offsety = -193; //图片位置位移y
	var divx = 284; //外框宽度
	var divy = 266; //外框高度
	var cutx = 120;  //裁减宽度
	var cuty = 120;  //裁减高度
	var zoom = 1; //缩放比例

	var zmin = 0.1; //最小比例
	var zmax = 10; //最大比例
	var grip_pos = 5; //拖动块位置0-最左 10 最右
	var img_grip; //拖动块
	var img_track; //拖动条
	var grip_y; //拖动块y值
	var grip_minx; //拖动块x最小值
	var grip_maxx; //拖动块x最大值
	
	
//图片初始化
function imageinit(){
	cut_div = document.getElementById('cut_div');
	cut_img = document.getElementById('cut_img');
	imgdefw = cut_img.width;
	imgdefh = cut_img.height;
	if(imgdefw > divx){
		zoom = divx / imgdefw;
		cut_img.width = divx;
		cut_img.height = Math.round(imgdefh * zoom);
	}

	cut_img.style.left = Math.round((divx - cut_img.width) / 2);
	cut_img.style.top = Math.round((divy - cut_img.height) / 2) - divy;

	if(imgdefw > cutx){
		zmin = cutx / imgdefw;
	}else{
		zmin = 1;
	}
	zmax =  zmin > 0.25 ? 8.0: 4.0 / Math.sqrt(zmin);
	if(imgdefw > cutx){
		zmin = cutx / imgdefw;
		grip_pos = 5 * (Math.log(zoom * zmax) / Math.log(zmax));
	}else{
		zmin = 1;
		grip_pos = 5;
	}

	Drag.init(cut_div, cut_img);
	cut_img.onDrag = when_Drag;
}

//图片逐步缩放
function imageresize(flag){
    if(flag){
		zoom = zoom * 1.5;
	}else{
		zoom = zoom / 1.5;
	}
	if(zoom < zmin) zoom = zmin;
	if(zoom > zmax) zoom = zmax;
	cut_img.width = Math.round(imgdefw * zoom);
	cut_img.height = Math.round(imgdefh * zoom);
	checkcutpos();
	grip_pos = 5 * (Math.log(zoom * zmax) / Math.log(zmax));
	img_grip.style.left = (grip_minx + (grip_pos / 10 * (grip_maxx - grip_minx))) + "px";
}

//获得style里面定位
function getStylepos(e){  
	return {x:parseInt(e.style.left), y:parseInt(e.style.top)}; 
}

//获得绝对定位
function getPosition(e){  
	var t=e.offsetTop;  
	var l=e.offsetLeft;  
	while(e=e.offsetParent){  
		t+=e.offsetTop;  
		l+=e.offsetLeft;  
	}
	return {x:l, y:t}; 
}

//检查图片位置
function checkcutpos(){
	var imgpos = getStylepos(cut_img);
	
	max_x = Math.max(offsetx, offsetx + cutx - cut_img.clientWidth);
	min_x = Math.min(offsetx + cutx - cut_img.clientWidth, offsetx);
	if(imgpos.x > max_x) cut_img.style.left = max_x + 'px';
	else if(imgpos.x < min_x) cut_img.style.left = min_x + 'px';

	max_y = Math.max(offsety, offsety + cuty - cut_img.clientHeight);
	min_y = Math.min(offsety + cuty - cut_img.clientHeight, offsety);

	if(imgpos.y > max_y) cut_img.style.top = max_y + 'px';
	else if(imgpos.y < min_y) cut_img.style.top = min_y + 'px';
}

//图片拖动时触发
function when_Drag(clientX , clientY){
	checkcutpos();
}

//获得图片裁减位置
function getcutpos(){
	var imgpos = getStylepos(cut_img);
	var x = offsetx - imgpos.x;
	var y = offsety - imgpos.y;
	var cut_pos = document.getElementById('cut_pos');
	cut_pos.value = x + ',' + y + ',' + cut_img.width + ',' + cut_img.height;
	return true;
}

//缩放条初始化
function gripinit(){
	img_grip = document.getElementById('img_grip');
	img_track = document.getElementById('img_track');
	track_pos = getPosition(img_track);

	grip_y = track_pos.y;
	grip_minx = track_pos.x + 4;
	grip_maxx = track_pos.x + img_track.clientWidth - img_grip.clientWidth - 5;

	img_grip.style.left = (grip_minx + (grip_pos / 10 * (grip_maxx - grip_minx))) + "px";
	img_grip.style.top = grip_y + "px";

	Drag.init(img_grip, img_grip);
	img_grip.onDrag = grip_Drag;

}

//缩放条拖动时触发
function grip_Drag(clientX , clientY){
	var posx = clientX;
	img_grip.style.top = grip_y + "px";
	if(clientX < grip_minx){
		img_grip.style.left = grip_minx + "px";
		posx = grip_minx;
	}
	if(clientX > grip_maxx){
		img_grip.style.left = grip_maxx + "px";
		posx = grip_maxx;
	}

	grip_pos = (posx - grip_minx) * 10 / (grip_maxx - grip_minx);
	zoom = Math.pow(zmax, grip_pos / 5) / zmax;
	if(zoom < zmin) zoom = zmin;
	if(zoom > zmax) zoom = zmax;
	cut_img.width = Math.round(imgdefw * zoom);
	cut_img.height = Math.round(imgdefh * zoom);
	checkcutpos();
}

//页面载入初始化
function avatarinit(){
	imageinit();
	gripinit();
}

if (document.all){
	window.attachEvent('onload',avatarinit);
}else{
	window.addEventListener('load',avatarinit,false);
} 
</script>


	
	<?php 
}else{
?>	
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td width=35>
<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'step_chose.jpg');?>
</td><td><?php echo TEXT_CHOOSE_SYSTEM_AVARTAR;?></td></tr></table>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td>
<div>
<table cellpadding=5 cellspacing=0 border=0 id="show_default_avatar">
<tr>
<?php 
$dir=DIR_WS_USER_AVATAR.'Default';
scandir_image($dir,'8seasons.jpg');
?>
</tr>
</table>
</div>
</td>
<td valign='top' width=500 align=center>
<div id="show_user_current_avatar">
<?php 
$user_avatar_query='select customers_info_id,customers_info_avatar from '.TABLE_CUSTOMERS_INFO.'  where customers_info_id='.$_SESSION['customer_id'].' ';
$user_avatar=$db->Execute($user_avatar_query);
echo zen_image(DIR_WS_USER_AVATAR.$user_avatar->fields['customers_info_avatar'],'','99','99');
?>
</div>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method='post'>
<input name="user_avatar" type="hidden" value='' id="user_avatar"/>
<div style="padding:20px 0px 0px 0px">
<input type="submit" value="<?php echo TEXT_SUBMIT;?>" >
<input name="action" value='upload_default_avatar' type="hidden">

</div>
</form>
<div style="color:red;padding-top:20px;font-size:16px;font-weight:bold;" id="show_avatar_update_tips">
<?php if($_POST['action']=='upload_default_avatar'&&zen_not_null($_POST['user_avatar'])){
	echo TEXT_AVATAR_UPLOAD_SUCCESSFULLY;
}else{
	echo TEXT_AVATAR_UPLOAD_TIPS;
}
?>
</div>
</td>
</tr>
</table>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td width=25>
<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'step_chose.jpg');?></td>
<td width=35><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'step_chose.jpg');?></td>
<td><?php echo TEXT_UPLOAD_LOCAL_IMG;?></td></tr></table>
<div style="margin-top:10px;">
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<input type="hidden" name="action" value='upload_local_image'>
<input type="file" name="image" size="30" /> <input type="submit" name="upload" value="<?php echo TEXT_UPLOAD;?>" />
</form>
</div>
<?php }?>
<div style="margin-top:10px; color:red;">
	<?php echo $error_info;?>
</div>
<script>
$(document).ready(function(){	
	$('#show_default_avatar td img').click(function(){
		$('#show_avatar_update_tips').text('');
		$('#show_default_avatar td img').css('border', '1px solid #fff');
		$(this).css('border','1px dashed orange');
		cSrc=$(this).attr('src');
		$('#show_user_current_avatar img').attr('src',cSrc);
		pre='<?php echo DIR_WS_USER_AVATAR;?>';
		$('#user_avatar').val(cSrc.substring(pre.length));
	})		
	$('#show_default_avatar td img').hover(function(){
		if($(this).css('borderColor')!='orange'){
			$(this).css('border','1px dashed #ccc');}}
										,function(){
		if($(this).css('borderColor')!='orange'){
			$(this).css('border','1px solid #fff');
		}
	})
})
</script>
</body>
</html>