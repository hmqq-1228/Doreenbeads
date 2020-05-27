<?php
 /**新增文件 Jessa
  * matching_products_manager.php
  *
  * 2010-02-26 Jessa
  */
  
  require('includes/application_top.php');
  
  if (isset($_POST['action']) && $_POST['action'] == 'update_match_model'){
  	$match_model_str = trim($_POST['matching_products_model']);
	if (!empty($match_model_str)){
		$match_model_str_array = explode(',', $match_model_str);
		$match_model_num = sizeof($match_model_str_array);
		if ($match_model_num > 0){
			$check_model_err = false;
			$check_count = 0;
			while($check_count < $match_model_num){
				$check_model = $db->Execute("select products_model
						   					 from " . TABLE_PRODUCTS . " 
											 where products_model = '" . $match_model_str_array[$check_count] . "'");
				if ($check_model->RecordCount() <= 0){
					$input_match_model_err = true;
					$check_model_err = true;
					break;
				}
				$check_count++;
			}

			if (!$check_model_err){
				reset($match_model_str_array);
				$count = 0;
				while($count < $match_model_num){
					$db->Execute("update " . TABLE_PRODUCTS . " 
								  set match_prod_list = '" . $match_model_str . "' 
								  where products_model = '" . $match_model_str_array[$count] . "'");
					$count++;
				}
			}
		}else{
			$input_match_model_err = true;
		}
	}else{
		$input_match_model_err = true;
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
</script>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<?php echo zen_draw_form('matching_porducts', FILENAME_MATCHING_PRODCUTS_MANAGER, '', 'post'); ?> 
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2" class="pageHeading"><br /><br /><?php echo HEADERING_TITLE; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="match_products_description"><?php echo MATCHING_PRODUCTS_DESCRIPTION; ?></td>
  </tr>
<?php
	if (isset($_POST['action']) && $_POST['action'] == 'update_match_model'){
		if ($input_match_model_err == true){
			if ($check_model_err == true){
?>
  <tr>
    <td colspan="2" class="match_products_error"><?php echo TEXT_CHECK_MODEL_ERROR . $match_model_str; ?></td>
  </tr>
<?php
			}else{
?>
  <tr>
    <td colspan="2" class="match_products_error"><?php echo TEXT_NO_PRODUCTS_MODEL_INPUT; ?></td>
  </tr>
<?php
			}
		}else{
?>
  <tr>
    <td colspan="2" class="match_products_success"><?php echo TEXT_UPDATE_MATCHING_PRODUCTS_SUCCESS . $match_model_str; ?></td>
  </tr>
<?php
		}	
	}
?>
  <tr>
    <td class="match_products_left"><?php echo TEXT_INPUT_PRODUCTS_MODEL; ?></td>
    <td class="match_products_right"><?php echo zen_draw_textarea_field('matching_products_model', '', '70', '3'); ?></td>
  </tr>
  <tr>
    <td class="match_products_left"><?php echo zen_draw_hidden_field('action', 'update_match_model'); ?></td>
    <td class="match_products_right"><?php echo zen_image_submit('button_submit.gif', ''); ?></td>
  </tr>
</table>
</form>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
