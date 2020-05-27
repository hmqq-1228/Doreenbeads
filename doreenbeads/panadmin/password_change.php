<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
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
//$Id: password_forgotten.php 4639 2006-09-30 22:54:30Z wilt $
//

require('includes/application_top.php');
$error = false;
/* print_r($_SESSION);
echo date("Y-m-d H:i:s", time()); */
if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
	$password_current = zen_db_prepare_input($_POST['password_current']);
	$password_new = zen_db_prepare_input($_POST['password_new']);
	$password_confirmation = zen_db_prepare_input($_POST['password_confirmation']);
	$score = 0;
	if(preg_match("/[0-9]+/",$password_new)){
		$score ++;
	}
	if(preg_match("/[a-zA-Z]+/",$password_new)){
		$score ++;
	}
	if ($score < 2 || strlen($password_new) < 3 ){
		$error = true;
		$password_error = '密码必须是字母与数字结合的';
		//$messageStack->add('password_new', '密码必须是字母与数字结合的');
	} elseif ($password_new != $password_confirmation) {
		$error = true;
		$password_diff_error = '两次填写的新密码不一致';
		//$messageStack->add('password_diff', '两次填写的新密码不一致');
	} elseif ($password_new == $password_current) {
		$password_diff_error = '新旧密码一致，请修改';
		$error = true;
	} 
	$check_admin_query = "SELECT admin_name, admin_email, admin_pass,admin_show_customer_email
                         FROM   " . TABLE_ADMIN . "
                         WHERE  admin_id = :admin_id";
	if($_SESSION['admin_id']){
		$admin_id = $_SESSION['admin_id'];
	} else if($_GET['admin_id']){
		$admin_id = $_GET['admin_id'];
	} else {
		zen_redirect(zen_href_link('login', '', 'SSL'));
	}
	
	$check_admin_query = $db->bindVars($check_admin_query, ':admin_id',$admin_id, 'integer');
	$check_admin = $db->Execute($check_admin_query);
	if($check_admin->recordCount() > 0) {
		if(!zen_validate_password($password_current, $check_admin->fields['admin_pass'])) {
			$error = true;
			$current_password_error = '原始密码填写错误';
		}
		
		$check_password_half_year_ago_used_query = "SELECT id,admin_id,password,create_time FROM ".TABLE_ADMIN_PASSWORD_USED." WHERE admin_id = :admin_id AND (unix_timestamp(create_time) + 15552000 ) > unix_timestamp(now()) ";
										  /* half year*/			
		$check_password_half_year_ago_used_query = $db->bindVars($check_password_half_year_ago_used_query, ':admin_id',$admin_id, 'integer');
		
		$password_used = $db->Execute($check_password_half_year_ago_used_query);
		while(!$password_used->EOF){
			if(zen_validate_password($password_new,$password_used->fields['password'])){
				$error = true;
				$password_time_error = '半年内不能使用重复的密码';
				break ;
			}
			$password_used->MoveNext();
		}
		if( !$error ) {
			if (zen_validate_password($password_current, $check_admin->fields['admin_pass'])) {			
				$sql = "UPDATE " . TABLE_ADMIN . "
			           SET admin_pass = :password,latest_login_time = :latest_login_time
			           WHERE admin_id = :admin_id";
				$pwd = zen_encrypt_password($password_new);
				$sql = $db->bindVars($sql, ':admin_id',$admin_id, 'integer');
				$sql = $db->bindVars($sql, ':password',$pwd, 'string');
				$sql = $db->bindVars($sql, ':latest_login_time',date('YmdHis'), 'date');
				$db->Execute($sql);
		
				zen_remember_password_half_year($admin_id,$pwd);
				
				$html_msg['EMAIL_CUSTOMERS_NAME'] = $check_admin->fields['admin_name'];
				$html_msg['EMAIL_MESSAGE_HTML'] = '修改密码成功。<br/>新密码是什么：'.$password_new.'。<br>请保留该邮件以防忘记密码。';
				zen_mail($check_admin->fields['admin_name'], $check_admin->fields['admin_email'], '密码已修改', '修改密码成功。<br/>新密码是什么：'.$password_new.'。<br>请保留该邮件以防忘记密码。', STORE_NAME, EMAIL_FROM, $html_msg, 'password_change_admin');
				$email_message = SUCCESS_PASSWORD_SENT;	
				$_SESSION['admin_id'] = $admin_id;
				if (SESSION_RECREATE == 'True') {
					zen_session_recreate();
				}
				$_SESSION['admin_name'] = $check_admin->fields['admin_name'];
				$_SESSION['admin_email'] = $check_admin->fields['admin_email'];
				$_SESSION['show_customer_email'] = $check_admin->fields['admin_show_customer_email'];
				$lang_id = 0;
				$langs_arr=zen_get_languages();
				$_SESSION['language'] = $langs_arr[$lang_id]['directory'];
				$_SESSION['languages_id'] = $langs_arr[$lang_id]['id'] ;
				$_SESSION['languages_code'] = $langs_arr[$lang_id]['code'];
				zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
			} 
		}
	}
	//}
	//    zen_redirect(zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css" />
<style>
.changeBox{width: 500px;margin: 40px auto;}
.procontent{margin-top:30px;margin-left:10px;width: 400px;}
.content{margin-left:10px;margin-top:16px;}
.content table td{font-size:12px;margin-top:5px;}
.content table td input[type="password"]{
	display: inline-block;
	width: 240px;
	height: 32px;
	line-height: 1.5;
	padding: 4px 7px;
	font-size: 14px;
	border: 1px solid #dcdee2;
	border-radius: 4px;
	color: #515a6e;
	background-color: #fff;
	background-image: none;
	cursor: text;
	outline: none;
	box-sizing: border-box;
	transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
}
.content table td input[type="submit"]{width:100px;height:30px;font-size:13px;border: none;background-color: #19be6b;color: #fff;border-radius: 4px;}
.content table td span{color:red;}
.content table td input[type="button"]{width:100px;height:30px;font-size:13px;border: none;background-color: #ed4014;color: #fff;border-radius: 4px;}
</style>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript">
	function check_form() {
		var reg11=/^[0-9A-z]{6,12}$/;

		var password_current = $.trim($('#password_current').val());
		var password_new = $.trim($('#password_new').val());
		var password_confirm = $.trim($('#password_confirm').val());
		var error = false;
		//alert(1); return false;
		if(password_current == ''){
			error="当前密码不能为空";
		    $('#password_current').parent('td').next('td').children('span').text(error);
		    error = true;
			
		}
		if(password_new == ''){
			error="新密码不能为空";
			$('#password_new').parent('td').next('td').children('span').text(error);
			 error = true;
		}	
		if(password_new == ''){
			error="确认新密码不能为空";
			$('#password_confirm').parent('td').next('td').children('span').text(error);
			error = true;
		}		
		if(error)  return false;
	}
</script>
</head>
<body>
	<div class="changeBox">
		<div class="pageHeading procontent" style="text-align: center;">修改密码</div>
		<div class="content">
			<form name="login" action="<?php echo zen_href_link('password_change', 'admin_id='.$_GET['admin_id'], 'SSL'); ?>" method = "post" onsubmit="return check_form();">
				<input type="hidden" name="action" value="process" />
				<table width="100%">
					<tr><td width="80">旧密码：</td><td width="240"><input type="password" id="password_current" type="password" name="password_current" value="<?php echo $password_current;?>" /></td><td><span><?php echo $current_password_error;?></span></td></tr>
					<tr><td>新密码：</td><td><input type="password"  id="password_new" type="password" name="password_new" value="<?php echo $password_new;?>" /></td><td><span><?php  echo $password_error; echo $password_diff_error;?></span></td></tr>
					<tr><td>确认新密码：</td><td><input type="password" id="password_confirm" type="password" name="password_confirmation" value="<?php echo $password_confirmation;?>" /></td><td><span></span></td></tr>
					<tr><td></td><td><input type="submit" value="确定">&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo zen_href_link('login'); ?>"><input type="button" value="取消"></input></a></td><td></td></tr>
					<tr><td></td><td><span><?php echo $password_time_error?></span></td></tr>
				</table>
			</form>
		</div>
  </div>
</body>
</html>
<?php require('includes/application_bottom.php'); ?>
