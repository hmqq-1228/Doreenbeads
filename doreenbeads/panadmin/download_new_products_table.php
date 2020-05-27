<?php
	require_once ('includes/application_top.php');
	
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
<!--bof body-->

<div id="download_new_products_heading_wrapper">
	<div class="pageHeading" id="download_new_products_page_heading">
		<?php echo PAGE_HEADING . ' ' . strtoupper(date('F')); ?>
	</div>
  <div id="download_new_products_form">
		<?php echo '<form method="post" action="' . HTTP_SERVER . DIR_WS_CATALOG . 'index.php?main_page=download_new_products" target="_blank">'; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="12%" height="30" align="left"><?php echo NEW_PRODUCTS_MODEL; ?></td>
			<td height="30" align="left"><?php echo '<input type="text" name="models" size="90">'; ?>&nbsp;&nbsp;<?php echo '<span style="color:red;">' . NEW_PRODUCTS_MODEL_FORMAT . '</span>'; ?></td>
	      </tr>
		  <tr>
		    <td height="30" align="left"></td>
		    <td height="30" align="left"><?php echo '<input type="submit" value="submit">'; ?></td>
	      </tr>
	  </table>
		<?php echo '</form>'; ?>
	  
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="60">&nbsp;</td>
            <td height="30">&nbsp;</td>
          </tr>
          <tr>
            <td width="50%" height="30" style="font-size:14px; font-weight:bold;"><?php echo 'Find New Products'; ?></td>
            <td width="50%" height="30" style="font-size:14px; font-weight:bold;"><?php echo 'Find Bestseller Products'; ?></td>
          </tr>
          <tr>
            <td width="50%" height="30">
			<?php echo '<form name="find_prod" action="' . HTTP_SERVER . '/index.php?main_page=find_prod&action=new" method="post" target="_blank">'; ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="35%" height="30"><?php echo 'Categories Name: '; ?></td>
                <td width="65%" height="30"><?php echo '<input type="text" name="catg_name" size="20">'; ?></td>
              </tr>
              <tr>
                <td width="35%" height="30"><?php echo 'Products Num: '; ?></td>
                <td width="65%" height="30"><?php echo '<input type="text" name="prod_num" size="20">'; ?></td>
              </tr>
              <tr>
                <td width="35%" height="30"><?php echo 'Background Select: '; ?></td>
                <td width="65%" height="30">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td width="50%" align="left" height="30"><?php echo '<input type="radio" name="bg_select" value="1"><image src="images/1.jpg">'; ?></td>
                      <td width="50%" align="left" height="30"><?php echo '<input type="radio" name="bg_select" value="2"><image src="images/2.jpg">'; ?></td>
                    </tr>
                    <tr>
                      <td width="50%" align="left" height="30"><?php echo '<input type="radio" name="bg_select" value="3"><image src="images/3.jpg">'; ?></td>
                      <td width="50%" align="left" height="30"><?php echo '<input type="radio" name="bg_select" value="4"><image src="images/4.jpg">'; ?></td>
                    </tr>
                    <tr>
                      <td width="50%" align="left" height="30"><?php echo '<input type="radio" name="bg_select" value="5"><image src="images/5.jpg">'; ?></td>
                      <td width="50%" align="left" height="30"><?php echo '<input type="radio" name="bg_select" value="6"><image src="images/6.jpg">'; ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td width="35%" height="30">&nbsp;</td>
                <td width="65%" height="30"><?php echo '<input type="submit" value="submit">'; ?></td>
              </tr>
            </table>
			</form>
			</td>
            <td width="50%" height="30">&nbsp;</td>
          </tr>
          <tr>
            <td width="50%" height="30">&nbsp;</td>
            <td width="50%" height="30">&nbsp;</td>
          </tr>
        </table>
	</div>
</div>

<!--eof body-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>