<?php

  require('includes/application_top.php');
  
  $action = (isset($_POST['action']) ? $_POST['action'] : '');
  
  if (zen_not_null($action)){
  	switch ($action){
  		case 'update_products_model':
  			$products_model_str = zen_db_prepare_input($_POST['products_model']);
  			$ls_to_add = zen_db_prepare_input($_POST['products_description']);
  			
  			$products_model_str = str_replace(' ', '', $products_model_str);
  			$products_model_str = str_replace(',', "', '", $products_model_str);
			$products_model_str = "'" . $products_model_str . "'";
			$ls_to_add .= '<!--com info adding tag -->';
//			echo '$products_model_str:' . $products_model_str;
			
			$db->Execute("Update " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p 
						     Set pd.products_description = Replace(pd.products_description, '<!--com info adding tag -->', '" . $ls_to_add . "')
						   Where p.products_model in (" . $products_model_str . ")
						     And pd.products_id = p.products_id
						     And pd.products_description Like '%<!--com info adding tag -->%'");
			$ll_replace_cnt = mysql_affected_rows();
			
			$db->Execute("Update " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p 
						     Set pd.products_description = CONCAT(products_description, '" . $ls_to_add . "')
						   Where p.products_model in (" . $products_model_str . ")
						     And pd.products_id = p.products_id
						     And pd.products_description Not Like '%<!--com info adding tag -->%'");
			$ll_add_cnt = mysql_affected_rows();
			
			$messageStack->add_session('(' . $products_model_str . ') Update desc:' . $ll_replace_cnt . '  Add Cnt:' . $ll_add_cnt, 'success');
			zen_redirect(zen_href_link('add_description_info.php'));
			
			break;
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
<?php echo zen_draw_form('add_description_info', 'add_description_info.php', '', 'post'); ?> 
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2" class="pageHeading"><br /><br /><?php echo HEADERING_TITLE; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="products_description"><?php echo PRODUCTS_DESCRIPTION_FORMAT; ?></td>
  </tr>
  <tr>
    <td class="products_left"><?php echo INPUT_PRODUCTS_MODEL; ?></td>
    <td class="products_right"><?php echo zen_draw_textarea_field('products_model', '', '70', '3'); ?></td>
  </tr>
  <tr>
	<td class="products_left"><?php echo PRODUCTS_DESCRIPTION; ?></td>
    <td class="products_right"><?php echo zen_draw_textarea_field('products_description', '', '70', '3'); ?>&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="products_left"><?php echo zen_draw_hidden_field('action', 'update_products_model'); ?></td>
    <td class="products_right"><?php echo zen_image_submit('button_submit.gif', ''); ?></td>
  </tr>
</table>
</form>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
