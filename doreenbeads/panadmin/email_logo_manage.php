<?php
/**
 * email_logo_manage.php
 * 
 */

  require('includes/application_top.php');
  $lang=$_SESSION['languages_id']-1;
  $email_logo_image_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_IMAGE'));
  $current_email_logo_image=$email_logo_image_arr[$lang];
  $email_logo_link_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_LINK'));
  $current_email_logo_link=$email_logo_link_arr[$lang];
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $current_image_size = getimagesize('../email/' . $current_email_logo_image);
  $width = (($current_image_size[0] > 450) ? '450' : '');
  
  if (isset($_POST['action']) && $_POST['action'] == 'update'){
  	$link_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_LINK'));
  	$link_arr[$lang]=$_POST['email_link'];
  	$new_str=serialize($link_arr);	
  	$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . zen_db_input($new_str) . "' where configuration_key = 'CURRENT_EMAIL_LOGO_LINK'");
  	zen_redirect(zen_href_link('email_logo_manage'));
  }
  
  if (isset($_POST['action']) && $_POST['action'] == 'changeconfirm'){
  	$link_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_LINK'));
  	$link_arr[$lang]=$_POST['logo_link'];
  	$link_str=serialize($link_arr);
  	$logo_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_IMAGE'));
  	$logo_arr[$lang]=$_POST['logo_image'];
  	$logo_str=serialize($logo_arr);
  	//$logo_link = zen_db_prepare_input($_POST['logo_link']);
  	//$logo_image = zen_db_prepare_input($_POST['logo_image']);
  	$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . zen_db_input($link_str) . "' where configuration_key = 'CURRENT_EMAIL_LOGO_LINK'");
  	$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value = '" . zen_db_input($logo_str) . "' where configuration_key = 'CURRENT_EMAIL_LOGO_IMAGE'");
  	zen_redirect(zen_href_link('email_logo_manage'));
  }
  
  if (isset($_POST['action']) && $_POST['action'] == 'upload'){
  	$logo_tmp = $_FILES['logoimage']['tmp_name'];
  	
  	$logo_name = $_FILES['logoimage']['name'];
  //	echo $logo_name;exit;
  	$logo_size = $_FILES['logoimage']['size'];
  	$logo_type = $_FILES['logoimage']['type'];
  	$logo_error = $_FILES['logoimage']['error'];
  	
//  	require_once(DIR_WS_CLASSES . 'upload.php');
//  	$file_type_array = array('gif', 'jpg', 'png', 'bmp');
//  	$upload = new upload('logoimage', '../email/', '777', $file_type_array);
//  	
  	if (zen_not_null($logo_tmp) && zen_not_null($logo_name) && zen_not_null($logo_size) && zen_not_null($logo_type)){
  		if ($logo_error > 0){
  			$messageStack->add_session('Upload Image unsuccess1', 'error');
  			zen_redirect(zen_href_link('email_logo_manage'));
  		}
  
  		$file_type_array = array('image/gif', 'image/jpeg', 'image/png', 'image/bmp');
  		if (!in_array($logo_type, $file_type_array)){
  			$messageStack->add_session('Upload Image Format Error!');
  			zen_redirect(zen_href_link('email_logo_manage'));
  			exit;
  		} 		
  		if(file_exists(DIR_FS_EMAIL_TEMPLATES.$_SESSION['language'])){
  			$upload_file = DIR_FS_EMAIL_TEMPLATES.$_SESSION['language']."/".$logo_name;
  		}else{
  			$upload_file = DIR_FS_EMAIL_TEMPLATES."/".$logo_name;
  		}
//  		echo $upload_file;exit;
//echo $logo_tmp;exit;
  		//$upload_file = '../email/' . date('YmdHis') . zen_create_random_value(4, 'digits') . substr($logo_name, strrpos($logo_name, '.'));
  		//die($upload_file);
  		if (is_uploaded_file($logo_tmp)){
  			if (!move_uploaded_file($logo_tmp, $upload_file)){
  				$messageStack->add_session('Can not move upload image!', 'error');
  				zen_redirect(zen_href_link('email_logo_manage'));
  				exit;	
  			}
  		} else {
  			$messageStack->add_session('Upload Image unsuccess3', 'error');
  			zen_redirect(zen_href_link('email_logo_manage'));
  			exit;
  		}
  		$messageStack->add_session('Upload Image success', 'success');
  		zen_redirect(zen_href_link('email_logo_manage'));
  	}
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/javascript/jscript_jquery.js"></script>
<script type="text/javascript">
 <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
  $(document).ready(function(){
		$('.delet_eLogo').click(function(){
			if(confirm('Are you sure you want to delete it?')){
					var _index=$('.delet_eLogo').index(this);
					var src=$('.eLogoShow').eq(_index).find('img').attr('src');
					$.post('./delete_email_logo.php',{src:""+src+""},function(data){
						$('.eLogoShow').eq(_index).remove();
					})
					
				}
		})
	  })
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top">
	    <table border="0" width="100%" cellspacing="0" cellpadding="2">
	      <tr>
	        <td>
		        <table border="0" width="100%" cellspacing="0" cellpadding="0">
		          <tr>
		            <td class="pageHeading"><?php echo 'Email Logo Manage'; ?></td>
		            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
		          </tr>
		        </table>
	        </td>
	      </tr>
	      <tr>
	        <td>
	        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	        	  <tr>
	        	    <td>
	        	      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
	        	        <tr class="dataTableHeadingRow">
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="50%" align="left">Current Logo Image</td>
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="30%" align="left">Current Logo Link</td>
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="20%" align="center">Action</td>
	        	        </tr>
	        	        <?php
	        	        	if ($action == 'edit'){
	        	        		echo zen_draw_form('email_logo', 'email_logo_manage.php');
	        	        		echo zen_draw_hidden_field('action', 'update');
	        	        ?>
	        	        <tr>
	        	          <td class="dataTableContent" style="padding:8px 0px;border:1px solid #CCCCCC;"><?php echo zen_image('../email/'.$_SESSION['language']."/" . $current_email_logo_image, '', $width); ?></td>
	        	          <td class="dataTableContent" style="padding:8px 0px;border:1px solid #CCCCCC;"><?php echo '<input type="text" name="email_link" value="' . $current_email_logo_link . '" style="width:280px;">'; ?></td>
	        	          <td class="dataTableContent" style="padding:8px 0px;border:1px solid #CCCCCC;; text-align:center;"><?php echo '<input type="submit" value="submit">'; ?></td>
	        	        </tr>
	        	        </form>
	        	        <?php } else { ?>
	        	        <tr>
	        	          <td class="dataTableContent" style="padding:8px 0px;"><?php echo zen_image('../email/' . $_SESSION['language']."/".$current_email_logo_image, '', $width); ?></td>
	        	          <td class="dataTableContent" style="padding:8px 0px;"><?php echo '<a href="' . $current_email_logo_link . '" target="_blank">' . $current_email_logo_link . '</a>'; ?></td>
	        	          <td class="dataTableContent" style="padding:8px 0px; text-align:center;">
	        	          <?php 
	        	          	echo '<a href="' . zen_href_link('email_logo_manage', 'action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a>';
	        	         ?></td>
	        	        </tr>
	        	        <?php } ?>
	        	        <?php
	        	        	$extra_img_dir = '../email/'.$_SESSION["language"]."/";
	        	        	if(!file_exists($extra_img_dir)){
	        	           		 $extra_img_dir = '../email/';
							}
	        	        	$img_extension_array = array('.jpg', '.JPG', '.gif', '.GIF', '.png', '.PNG');
	        	        	$extra_img_array = array();
	        	        	if ($img_dir = @dir($extra_img_dir)){
	        	        		while ($img_file = $img_dir->read()){
	        	        			if ( (strlen(substr($img_file, strrpos($img_file, '.'))) > 1)){
	        	        				if (in_array(substr($img_file, strrpos($img_file, '.')), $img_extension_array) && $img_file != $current_email_logo_image){
	        	        					$extra_img_array[] = array('name' => $img_file,
	        	        											   'url' => $extra_img_dir . $img_file,
	        	        											   'size' => getimagesize($extra_img_dir . $img_file),
	        	        											   'mtime' =>filemtime($extra_img_dir . $img_file)
	        	        												);
	        	        				}
	        	        			}
	        	        		}
	        	        		$img_dir->close();
	        	        	}
	        	        	foreach ($extra_img_array as $key => $row) {
    								$mtime[$key]  = $row['mtime'];
								}							
							array_multisort($mtime, SORT_DESC, $extra_img_array);
	        	        ?>
	        	        <?php
        	        	 if ($action == 'change'){
        	        	?>
        	        	<tr class="dataTableHeadingRow">
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="50%" align="left">Extra Logo Image</td>
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="30%" align="left">Extra Logo Link</td>
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="20%" align="center">Action</td>
	        	        </tr>
        	        	<?php
	        	        	echo zen_draw_form('email_logo', 'email_logo_manage');
	        	        	echo zen_draw_hidden_field('action', 'changeconfirm');
	        	        	echo zen_draw_hidden_field('logo_image', $_GET['imgname']);
	        	        ?>
	        	        <tr>
	        	          <td class="dataTableContent" style="padding:8px 0px; border:1px solid #CCCCCC;"><?php echo zen_image($extra_img_dir . $_GET['imgname'], '', (($extra_img_array[$i]['size'][0] > 450) ? '450' : '')); ?></td>
	        	          <td class="dataTableContent" style="padding:8px 0px; border:1px solid #CCCCCC;">
	        	          <?php 
	        	          	echo '<input type="text" value="" name="logo_link" style="width:280px;">'; 
	        	          ?>
	        	          </td>
	        	          <td class="dataTableContent" style="padding:8px 0px; text-align:center; border:1px solid #CCCCCC;"><?php echo '<input type="submit" value="submit">'; ?></td>
	        	        </tr>
	        	        </form>
	        	        <?php
	        	         } else {
	        	        ?>
	        	        <tr class="dataTableHeadingRow">
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="50%" align="left" colspan="2">Extra Logo Image</td>
	        	          <td class="dataTableHeadingContent" style="padding:5px 0px;" width="20%" align="center">Action</td>
	        	        </tr>
	        	        <?php
	        	        	for ($i = 0; $i < sizeof($extra_img_array); $i++){
	        	        ?>
	        	        <tr class="eLogoShow">
	        	          <td class="dataTableContent" style="padding:8px 0px; border:1px solid #CCCCCC;" colspan="2" width="80%"><?php echo zen_image($extra_img_array[$i]['url'], '', (($extra_img_array[$i]['size'][0] > 450) ? '450' : '')); ?></td>
	        	          <td class="dataTableContent" style="padding:8px 0px; text-align:center; border:1px solid #CCCCCC;"><?php echo '<a href="' . zen_href_link('email_logo_manage', 'action=change&imgname=' . $extra_img_array[$i]['name']) . '">Use It</a>'; ?><br><span class="delet_eLogo">Delete it</span></td>
	        	        </tr>
	        	        <?php
	        	        	}
	        	         }
	        	        ?>
						<tr class="dataTableHeadingRow">
						  <td class="dataTableHeadingContent" colspan="3" style="padding:5px 0px; border:1px solid #cccccc;">Upload Email Logo</td>
						</tr>
						<tr>
						  <td class="dataTableContent" colspan="3">
						    <?php
						  	  echo zen_draw_form('logo_pic', 'email_logo_manage', '', 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('action', 'upload') . zen_draw_hidden_field('MAX_FILE_SIZE', '1048576') . "\n";
						    ?>
						    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border">
						      <tr>
						        <td style="padding:5px 0px;" width="15%">Upload Logo Image:</td>
						        <td style="padding:5px 0px;" width="40%"><?php echo zen_draw_file_field('logoimage'); ?></td>
						        <td style="padding:5px 0px;"><?php echo '<input type="submit" value="submit">'; ?></td>
						      </tr>
						    </table>
						    </form>
						  </td>
						</tr>
	        	      </table>
	        	    </td>
	        	  </tr>
	        	</table>
	        </td>
	      </tr>
	    </table>
    </td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>