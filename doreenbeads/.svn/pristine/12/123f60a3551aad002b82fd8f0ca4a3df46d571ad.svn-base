<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | export of orders is based on easypopulate module 2005 by langer      |
// +----------------------------------------------------------------------+
// $Id: ordersExport.php,v0.1 2007 matej $
//


require_once ('includes/application_top.php');

if(isset($_POST['action'])&&$_POST['action']=='insert_ips'){
	$ipstring1 = trim($_POST['ipstring1']);
	$ipstring2 = trim($_POST['ipstring2']);
	if(zen_not_null($ipstring1) || zen_not_null($ipstring2)){
		$ipstring = empty($ipstring1) ? $ipstring2 : $ipstring1;
		$ipstring_array = explode("\n", $ipstring);
		$ipstring_array_new = array();
		foreach($ipstring_array as $ipstring_value) {
			$ipstring_value = trim($ipstring_value);
			if(!empty($ipstring_value)) {
				array_push($ipstring_array_new, $ipstring_value);
			}
		}
		if(!empty($ipstring1)) {
			copy('../log/ip_verification/allowed_cn_ips.txt', '../log/ip_verification/allowed_cn_ips_' . date('YmdHis') . '_' . $_SESSION['admin_email'] . '.log');
			file_put_contents('../log/ip_verification/allowed_cn_ips.txt', implode("\n", $ipstring_array_new));
		}
		if(!empty($ipstring2)) {
			copy('../log/ip_verification/allowed_cn_ips_admin.txt', '../log/ip_verification/allowed_cn_ips_admin_' . date('YmdHis') . '_' . $_SESSION['admin_email'] . '.log');
			file_put_contents('../log/ip_verification/allowed_cn_ips_admin.txt', implode("\n", $ipstring_array_new));
		}
		
		$messageStack->add_session('设置成功!', 'success');
	
	} else {
		$messageStack->add_session('设置失败!', 'error');
	}
	zen_redirect(zen_href_link('ip_verification'));
} else {
	$ipstring1 = file_get_contents('../log/ip_verification/allowed_cn_ips.txt');
	$ipstring2 = file_get_contents('../log/ip_verification/allowed_cn_ips_admin.txt');
}

// THE HTML PAGE IS BELOW HERE 
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php
echo HTML_PARAMS;
?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php
	echo CHARSET;
	?>">
<title><?php
echo TITLE;
?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
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
<?php
require (DIR_WS_INCLUDES . 'header.php');
?>
<!-- header_eof //-->
<!-- body //-->
<!-- body_text //-->
<?php
echo zen_draw_separator ( 'pixel_trans.gif', '1', '10' );
?>
		<table align="center" border="0" width="100%" cellspacing="0"
	cellpadding="0">
	<tr>
		<td class="pageHeading" align="left"><?php
		echo  'IP Verification';
		?></td>
	</tr>
</table>
<?php
echo zen_draw_separator ( 'pixel_trans.gif', '1', '10' );
?>

<table style="width:100%; padding-left:100px; font-size:14px;">
	<tr>
		<td>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
				<input type="hidden" name="action" value='insert_ips'> 
				网站前台IP白名单<br/>
				<textarea name="ipstring1" cols="6" rows="26" style="width:40%;"><?php echo $ipstring1;?></textarea>
				<div style="padding:5px;font-size:14px;">(一行一个IP)</div>
				<div>
					<input type="submit" value="保存">
				</div>
			</form>	
		</td>
		<td>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
				<input type="hidden" name="action" value='insert_ips'> 
				网站后台IP白名单<br/>
				<textarea name="ipstring2" cols="6" rows="26" style="width:40%;"><?php echo $ipstring2;?></textarea>
				<div style="padding:5px;font-size:14px;">(一行一个IP)</div>
				<div>
					<input type="submit" value="保存">
				</div>
			</form>	
		</td>
	</tr>
</table>
	
	
<!-- body_text_eof //-->
<!-- body_eof //-->
<br />

<!-- footer //-->
<?php
require (DIR_WS_INCLUDES . 'footer.php');
?>
<!-- footer_eof //-->
</body>
</html>
<?php
require (DIR_WS_INCLUDES . 'application_bottom.php');
?>