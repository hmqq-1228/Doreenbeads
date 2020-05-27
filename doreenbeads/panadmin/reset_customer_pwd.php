<?php
require('includes/application_top.php');

$action = $_POST['action'];
switch ($action){
	case 'check_customer_email':
		$customers_id = zen_db_input($_POST['customers_id']);
		$email_query = $db->Execute('select customers_id from ' . TABLE_CUSTOMERS . ' WHERE customers_id = "' . $customers_id . '"');
		if($email_query->RecordCount() > 0){
			echo 1;
		}else{
			echo 0;
		}
		exit;
		break;
	case 'reset_pwd':
		$char_str = '0123456789abcdefghijklmnopqrstuvwxyz';
		$new_password = '';
		$customers_id = zen_db_input($_POST['customers_id']);
		for ($i = 0;$i < 5;$i++){
			$rand_char = $char_str[rand(0,35)];
			$new_password .= $rand_char;
		}
		$password = zen_encrypt_password($new_password);
		$sql = 'update ' . TABLE_CUSTOMERS . ' SET customers_password = "' . $password . '" WHERE customers_id = "' . $customers_id . '"';
		$db->Execute($sql);
		echo $new_password;
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
	$("#reset_pwd").click(function(){
		var customers_id;
		customers_id = $("#customer_id").val();
		$("#tim_email").remove();
		if(customers_id < 0){
			var tim = "<span style='color:red;' id='tim_email'>请输入客户ID！</span>";
			$(".email_address").after(tim);
			return false;
			}
		
		$.post("reset_customer_pwd.php",{action:"check_customer_email", customers_id:customers_id} ,function(data){
			if(data == 1){
				$.post("reset_customer_pwd.php",{action:"reset_pwd", customers_id:customers_id} ,function(data){
					$("input[name=new_password]").val(data);
					});
			}else if(data == 0){
				var tim = "<span style='color:red;' id='tim_email'>ID不存在，请重新输入!</span>";
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
		<span>重置客户密码</span>
	</div>
	<div class="reset_pwd_form">
		<div style="margin-bottom: 15px;">
			<div style="display: inline;margin-left: 10%;"><font>客户ID：</font></div>
			<div style="display: inline-block;margin-right:5px;" class="email_address"><?php echo zen_draw_input_field('customer_id' , '' ,'id="customer_id"')?></div>
		</div>
		<div style="margin-left: 14%;margin-bottom: 15px;"><input type="button" value="重置" id="reset_pwd"></div>
		<div>
			<div style="display: inline;margin-left: 11%;"><font>密码：</font></div>
			<div style="display: inline-block;"><?php echo zen_draw_input_field('new_password' , '' ,'readonly="true"')?></div>
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