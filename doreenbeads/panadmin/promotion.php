<?php
require_once ('includes/application_top.php');
@set_time_limit ( 300 ); // if possible, let's try for 5 minutes before timeouts

$file_en = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . 'english/html_includes/', 'define_promotion_index.php', 'false');
$file_de = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . 'german/html_includes/', 'define_promotion_index.php', 'false');
$file_ru = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . 'russian/html_includes/', 'define_promotion_index.php', 'false');
$file_fr = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . 'french/html_includes/', 'define_promotion_index.php', 'false');
$file_es = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . 'spanish/html_includes/', 'define_promotion_index.php', 'false');

if ( $_SESSION['language'] ) {
	if (file_exists($file_en)) {
		$file_array = @file($file_en);
		$file_contents_en = @implode('', $file_array);
		$file_writeable = true;
		if (!is_writeable($file_en)) {
			$file_writeable = false;
			$messageStack->reset();
			$messageStack->add(sprintf(ERROR_FILE_NOT_WRITEABLE, $file_en), 'error');
			echo $messageStack->output();
		}
	}
	if (file_exists($file_de)) {
		$file_array = @file($file_de);
		$file_contents_de = @implode('', $file_array);
		$file_writeable = true;
		if (!is_writeable($file_de)) {
			$file_writeable = false;
			$messageStack->reset();
			$messageStack->add(sprintf(ERROR_FILE_NOT_WRITEABLE, $file_de), 'error');
			echo $messageStack->output();
		}
	}
	if (file_exists($file_ru)) {
		$file_array = @file($file_ru);
		$file_contents_ru = @implode('', $file_array);
		$file_writeable = true;
		if (!is_writeable($file_ru)) {
			$file_writeable = false;
			$messageStack->reset();
			$messageStack->add(sprintf(ERROR_FILE_NOT_WRITEABLE, $file_ru), 'error');
			echo $messageStack->output();
		}
	}
	if (file_exists($file_fr)) {
		$file_array = @file($file_fr);
		$file_contents_fr = @implode('', $file_array);
		$file_writeable = true;
		if (!is_writeable($file_fr)) {
			$file_writeable = false;
			$messageStack->reset();
			$messageStack->add(sprintf(ERROR_FILE_NOT_WRITEABLE, $file_fr), 'error');
			echo $messageStack->output();
		}
	}
	if (file_exists($file_es)) {
		$file_array = @file($file_es);
		$file_contents_es = @implode('', $file_array);
		$file_writeable = true;
		if (!is_writeable($file_es)) {
			$file_writeable = false;
			$messageStack->reset();
			$messageStack->add(sprintf(ERROR_FILE_NOT_WRITEABLE, $file_es), 'error');
			echo $messageStack->output();
		}
	}
}
if($_POST['action']!=''){
	switch ($_POST['action']) {
		case 'save':							
			if (file_exists($file_en)) {				
				if (file_exists('bak' . $file_en)) {
					@unlink('bak' . $file_en);
				}
				@rename($file, 'bak' . $file_en);
				$new_file = fopen($file_en, 'w');
				$file_contents_en = stripslashes($_POST['promotion_en']);
				fwrite($new_file, $file_contents_en, strlen($file_contents_en));
				fclose($new_file);
			}
			if (file_exists($file_de)) {
				if (file_exists('bak' . $file_de)) {
					@unlink('bak' . $file_de);
				}
				@rename($file, 'bak' . $file_de);
				$new_file = fopen($file_de, 'w');
				$file_contents_de = stripslashes($_POST['promotion_de']);
				fwrite($new_file, $file_contents_de, strlen($file_contents_de));
				fclose($new_file);
			}
			if (file_exists($file_ru)) {
				if (file_exists('bak' . $file_ru)) {
					@unlink('bak' . $file_ru);
				}
				@rename($file, 'bak' . $file_ru);
				$new_file = fopen($file_ru, 'w');
				$file_contents_ru = stripslashes($_POST['promotion_ru']);
				fwrite($new_file, $file_contents_ru, strlen($file_contents_ru));
				fclose($new_file);
			}
			if (file_exists($file_fr)) {
				if (file_exists('bak' . $file_fr)) {
					@unlink('bak' . $file_fr);
				}
				@rename($file, 'bak' . $file_fr);
				$new_file = fopen($file_fr, 'w');
				$file_contents_fr = stripslashes($_POST['promotion_fr']);
				fwrite($new_file, $file_contents_fr, strlen($file_contents_fr));
				fclose($new_file);
			}
			if (file_exists($file_es)) {
				if (file_exists('bak' . $file_es)) {
					@unlink('bak' . $file_es);
				}
				@rename($file, 'bak' . $file_es);
				$new_file = fopen($file_es, 'w');
				$file_contents_es = stripslashes($_POST['promotion_es']);
				fwrite($new_file, $file_contents_es, strlen($file_contents_es));
				fclose($new_file);
			}
			//zen_href_link('promotion');	
			break;
	}
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS;?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo TITLE;?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function init(){
	cssjsmenu('navbar');
	if (document.getElementById){
		var kill = document.getElementById('hoverJS');
		kill.disabled = true;
	}
}
</script>
<style>
	.procontent{margin:10px 20px;}
	.procontent textarea{width:600px;height:160px;}
</style>
</head>
<body onLoad="init()">
<!-- header //-->

<?php
	if(zen_not_null($_POST['action']) && $_POST['action'] == 'save'){
		?><div class="messageStackSuccess"><img border="0" title=" Success " alt="Success" src="images/icons/success.gif">Update successfully !</div><?php
	}
require (DIR_WS_INCLUDES . 'header.php');
?>
<!-- header_eof //-->
<!-- body //-->
<div class="pageHeading procontent">PROMOTION > Home-page Promotion</div>
<!-- body_text //-->
<!-- footer //-->
<?php echo zen_draw_form('promotion_index', 'promotion', '', 'post') .
            zen_draw_hidden_field('action', 'save') .zen_draw_hidden_field('page', 'define_promotion_index') . '&nbsp;&nbsp;';?>
<div class="procontent"><button>update</button>&nbsp;&nbsp;&nbsp;&nbsp;<button>cancel</button></div>
<div class="procontent">
	<img border="0" title=" English " alt="English" src="<?php echo HTTP_SERVER.'/'?>includes/languages/english/images/icon.gif" ><br/>
	<textarea name="promotion_en"><?php echo $file_contents_en;?></textarea>
</div>
<div class="procontent">
	<img border="0" title=" Germany " alt="Germany" src="<?php echo HTTP_SERVER.'/'?>includes/languages/german/images/icon.gif" ><br/>
	<textarea  name="promotion_de"><?php echo $file_contents_de;?></textarea>
</div>
<div class="procontent">
	<img border="0" title=" Russia " alt="Russia" src="<?php echo HTTP_SERVER.'/'?>includes/languages/russian/images/icon.gif" ><br/>
	<textarea  name="promotion_ru"><?php echo $file_contents_ru;?></textarea>
</div>
<div class="procontent">
	<img border="0" title=" french " alt="french" src="<?php echo HTTP_SERVER.'/'?>includes/languages/french/images/icon.gif" ><br/>
	<textarea  name="promotion_fr"><?php echo $file_contents_fr;?></textarea>
</div>
<div class="procontent">
	<img border="0" title=" Spanish " alt="Spanish" src="<?php echo HTTP_SERVER.'/'?>includes/languages/spanish/images/icon.gif" ><br/>
	<textarea  name="promotion_es"><?php echo $file_contents_es;?></textarea>
</div>
<div class="procontent"><button>update</button>&nbsp;&nbsp;&nbsp;&nbsp;<button>cancel</button></div>
</form>
<?php
require (DIR_WS_INCLUDES . 'footer.php');
?>
<!-- footer_eof //-->
</body>
</html>
<?php
require (DIR_WS_INCLUDES . 'application_bottom.php');
?>