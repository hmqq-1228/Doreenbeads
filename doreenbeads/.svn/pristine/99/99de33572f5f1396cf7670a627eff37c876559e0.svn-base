<?php
require('includes/application_top.php');

$action = $_POST['action'];
switch ($action){
	case 'check_customer_email':
		$customers_id = zen_db_input($_POST['customers_id']);
		$email_query = $db->Execute('select customers_id from ' . TABLE_CUSTOMERS . ' WHERE customers_id = ' . $customers_id);
		if($email_query->RecordCount() > 0){
			echo 1;
		}else{
			echo 0;
		}
		exit;
		break;
	case 'get_auth_code':
		$char_str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$auth_code = '';
		$customers_id = zen_db_input($_POST['customers_id']);
		$opertor = zen_db_input($_SESSION['admin_email']);
		for ($i = 0;$i < 6;$i++){
			$rand_char = $char_str[rand(0,35)];
			$auth_code .= $rand_char;
		}
		
		$customers_email_query = $db->Execute('select customers_email_address from ' . TABLE_CUSTOMERS . ' where customers_id =' . $customers_id);
		$email_address = $customers_email_query->fields['customers_email_address'];
		
		$db->Execute('INSERT into ' . TABLE_CUSTOMERS_AUTH_CODE . ' (`auth_code` , `admin_email` , `customers_email_address` , `acquire_date` , `expire_date`) VALUES("' . $auth_code . '" , "' . $opertor . '" , "' . $email_address . '" , now() , FROM_UNIXTIME(UNIX_TIMESTAMP() + 300))');
		echo $auth_code;
		exit;
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
<script language="javascript" src="includes/jquery.js"></script>
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
<script type="text/javascript">
$(document).ready(function(){
	$("#get_auth_code").click(function(){
		var customers_id;
		customers_id = $("#customer_id").val();
		$("#tim_email").remove();
		if(customers_id < 0){
			var tim = "<span style='color:red;' id='tim_email'>请输入客户ID！</span>";
			$(".email_address").after(tim);
			return false;
			}
		
		$.post("auth_code.php",{action:"check_customer_email", customers_id:customers_id} ,function(data){
			if(data == 1){
				$.post("auth_code.php",{action:"get_auth_code", customers_id:customers_id} ,function(data){
					$("input[name=auth_code]").val(data);
					});
			}else{
				var tim = "<span style='color:red;' id='tim_email'>客户ID不存在，请重新输入!</span>";
				$("#tim_email").remove();
				$(".email_address").after(tim);
				return false;
				}
			
			});
		});
	
// 	$("input[name=auth_code]").keydown(function(){
// 		return false;
// 	});

});
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div class="content">
	<div class="title" style="height: 80px;font-size: 25px;font-weight: bold;margin-left: 40px;margin-top: 30px;">
		<span>获取授权码</span>
	</div>
	<div class="auth_form">
		<div style="margin-bottom: 15px;">
			<div style="display: inline;margin-left: 10%;"><font>客户ID：</font></div>
			<div style="display: inline-block;margin-right:5px;" class="email_address"><?php echo zen_draw_input_field('customer_id' , '' ,'id="customer_id"')?></div>
		</div>
		<div style="margin-left: 14%;margin-bottom: 15px;"><input type="button" value="获取授权码" id="get_auth_code"></div>
		<div>
			<div style="display: inline;margin-left: 10.5%;"><font>授权码：</font></div>
			<div style="display: inline-block;"><?php echo zen_draw_input_field('auth_code', '' ,'readonly="true"')?></div>
		</div>
	</div>

</div>




<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>