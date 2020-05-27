<?php
/**
 * move_products.php
 * 
 */

  require('includes/application_top.php');
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  switch ($action){
  	case 'update1':
  		$product_data = file($_FILES['productfile']['tmp_name']);
  		
  		$ll_update_cnt = 0;
  		foreach ($product_data as $row_num => $row_data){
  			$product = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = '" . trim(zen_db_input($row_data)) . "'");
  			if ($product->RecordCount() == 0) continue;
  			
  			$product_id = $product->fields['products_id'];
  			$check_product = $db->Execute("Select products_id 
  											 From " . TABLE_PRODUCTS_TO_CATEGORIES . " 
  											Where products_id = " . (int)$product_id . " 
  											  And categories_id = 1469");
  			if ($check_product->RecordCount() == 0){
  				$ll_update_cnt++;
  				$db->Execute("Insert Into " . TABLE_PRODUCTS_TO_CATEGORIES . "
  				              (products_id, categories_id) Values (" . $product_id . ", 1469)");
  			}
  		}
  		
  		if ($ll_update_cnt > 0){
  			$messageStack->add_session($ll_update_cnt . ' Products Successed Move to Stock Clearance Categories.', 'success');
  		}
  		zen_redirect(zen_href_link('move_products.php', '', 'NONSSL'));
  		
  		break;
  	case 'update2':
  		$product_data = file($_FILES['productfile']['tmp_name']);
  		
  		$ll_update_cnt = 0;
  		foreach ($product_data as $row_num => $row_data){
  			$product = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = '" . trim(zen_db_input($row_data)) . "'");
  			if ($product->RecordCount() == 0) continue;
  			
  			$product_id = $product->fields['products_id'];
  			$check_product = $db->Execute("Select products_id 
  											 From " . TABLE_PRODUCTS_TO_CATEGORIES . " 
  											Where products_id = " . (int)$product_id . " 
  											  And categories_id = 1478");
  			if ($check_product->RecordCount() == 0){
  				$ll_update_cnt++;
  				$db->Execute("Insert Into " . TABLE_PRODUCTS_TO_CATEGORIES . "
  				              (products_id, categories_id) Values (" . $product_id . ", 1478)");
  			}
  		}
  		
  		if ($ll_update_cnt > 0){
  			$messageStack->add_session($ll_update_cnt . ' Products Successed Move to Categories', 'success');
  		}
  		
  		break;
  }
  $action = (isset($_POST['action']) ? $_POST['action'] : '');
  switch ($action){
   	case 'deleteconfirm':
  		$ls_products_confirm_query = "select p.products_id, p.products_model, p.products_image, pd.products_name
									    from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc
									   where pc.categories_id = 1469 
									     and p.products_id = pc.products_id
									     and pc.products_id = pd.products_id";
		$lds_products_confirm = $db->Execute($ls_products_confirm_query);
		
		$ls_to_del = '356';
		break;
  	case 'deleteconfirm2':
  		$ls_products_confirm_query = "select p.products_id, p.products_model, p.products_image, pd.products_name
									    from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc
									   where pc.categories_id = 1478 
									     and p.products_id = pc.products_id
									     and pc.products_id = pd.products_id";
		$lds_products_confirm = $db->Execute($ls_products_confirm_query);
		
		$ls_to_del = '476';
		break;
  	case 'delete':
  		$ls_sql = "delete from " . TABLE_PRODUCTS_TO_CATEGORIES . "
				   where categories_id = 1469" ;
		$lds_products = $db->Execute($ls_sql);
  		$ll_succ_del = mysql_affected_rows();
  		
  		$messageStack->add_session( $ll_succ_del .' Products Successed ReMove to Stock Clearance Categories', 'success');
  		zen_redirect(zen_href_link('move_products'));
  	    break;
  	case 'delete2':
  		$ls_sql = "delete from " . TABLE_PRODUCTS_TO_CATEGORIES . "
				   where categories_id = 1478";
		$lds_products = $db->Execute($ls_sql);
		$ll_succ_del = mysql_affected_rows();
  		$messageStack->add_session( $ll_succ_del .' Products Successed ReMove to Stock Clearance Categories', 'success');
  		zen_redirect(zen_href_link('move_products'));
  		break;
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
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->


<br />
<br />
<br />
<?php if ($_POST['action'] == 'deleteconfirm' || $_POST['action'] == 'deleteconfirm2'){ ?>
<?php if ($lds_products_confirm->RecordCount() > 0){ ?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
  <form name="delete_products" action="move_products.php" method="POST">
  <input type="hidden" name="category" value=<?php echo $ls_to_del; ?>>
  <?php if ($ls_to_del == 356) {?>
  <input type="hidden" name="action" value="delete">
  <?php } else {?>
   <input type="hidden" name="action" value="delete2">
  <?php } ?> 
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" style="padding:3px 0px;">Products ID</td>
    <td class="dataTableHeadingContent">Products Model</td>
    <td class="dataTableHeadingContent">Products Name</td>
    <td class="dataTableHeadingContent" align="center">Products Image</td>
  </tr>
  <?php 
  	$ll_count = 0;
  	while (!$lds_products_confirm->EOF){ 
  	  if ($ll_count % 2 == 0){
  	  	$class = 'dataTableRowSelected';
  	  }	else {
  	  	$class = 'dataTableRow';
  	  }
  ?>
  <tr class="<?php echo $class; ?>">
    <td style="padding:5px 0px;"><?php echo $lds_products_confirm->fields['products_id']; ?></td>
    <td style="padding:5px 0px;"><?php echo $lds_products_confirm->fields['products_model'];?></td>
    <td style="padding:5px 0px;"><?php echo $lds_products_confirm->fields['products_name'];?></td>
    <td style="padding:5px 0px;" align="center"><?php echo zen_image(HTTP_SERVER . '/' . DIR_WS_IMAGES . $lds_products_confirm->fields['products_image'], '', '50'); ?></td>
  </tr>
  <?php 
  		$ll_count++;
  		$lds_products_confirm->MoveNext();
  	}
  ?>
  <tr>
    <td colspan="4" style="padding:5px 0px; text-align:right;"><input type="submit" value="confirm delete"></td>
  </tr>
</table>
<?php } ?>
<?php } else { ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>
    <td colspan="1"  align="left" style = "font-family:Verdana,sans-serif;font-size:15px;font-size-adjust:none;color:#003D00;
										  font-variant:small-caps;font-weight:bold;">
    	Move to [1469]Discount Catalog(30% off) by TXT file <?php if ($action == 'update1' && $ll_update_cnt > 0) echo ' ::Moved products:' . $ll_update_cnt;?>
    </td>
  </tr>
    <td>
		<form ENCTYPE="multipart/form-data" ACTION="move_products.php?action=update1" METHOD="POST">
			<div align = "left">
				<input TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">
				<input name="productfile" type="file" size="50">
				<input type="submit" name="buttoninsert" value="Update">
				<br />
			</div>
		</form>
    </td>
  <tr>
    
  </tr>
</table>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="1"  align="left" style = "font-family:Verdana,sans-serif;font-size:15px;font-size-adjust:none;color:#003D00;
										  font-variant:small-caps;font-weight:bold;">
    	Remove The Products <?php if ($action == 'delete_products' && $ll_count > 0) echo ' ::ReMoved products:' . $ll_count;?>
    </td>
  </tr>
    <td>
		<form ENCTYPE="multipart/form-data" ACTION="move_products.php" METHOD="POST">
			<input type="hidden" name="action" value="deleteconfirm">
			<div align = "left">
				<input type="submit" name="buttondelete" value="Delete">
			</div>
		</form>
    </td>  
  <tr>  
  </tr>
</table>
<br />
<br />
<br />
<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>
    <td colspan="1"  align="left" style = "font-family:Verdana,sans-serif;font-size:15px;font-size-adjust:none;color:#003D00;
										  font-variant:small-caps;font-weight:bold;">
    	Move to [1478]Special promotion(25% off) <?php if ($action == 'update2' && $ll_update_cnt > 0) echo ' ::Moved products:' . $ll_update_cnt;?>
    </td>
  </tr>
    <td>
		<form ENCTYPE="multipart/form-data" ACTION="move_products.php?action=update2" METHOD="POST">
			<div align = "left">
				<input TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">
				<input name="productfile" type="file" size="50">
				<input type="submit" name="buttoninsert" value="Update">
				<br />
			</div>
		</form>
    </td>
  <tr>
  </tr>
</table>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="1"  align="left" style = "font-family:Verdana,sans-serif;font-size:15px;font-size-adjust:none;color:#003D00;
										  font-variant:small-caps;font-weight:bold;">
    	Remove The Products <?php if ($action == 'delete_products' && $ll_count > 0) echo ' ::ReMoved products:' . $ll_count;?>
    </td>
  </tr>
    <td>
		<form ENCTYPE="multipart/form-data" ACTION="move_products.php" METHOD="POST">
			<input type="hidden" name="action" value="deleteconfirm2">
			<div align = "left">
				<input type="submit" name="buttondelete2" value="Delete">
				<br />
			</div>
		</form>
    </td>  
  <tr>  
  </tr>
</table>
<?php } ?>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>