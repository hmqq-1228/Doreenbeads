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
// $Id: login.php 6525 2007-06-25 21:49:57Z drbyte $
//

require('includes/application_top.php');

$message = false;
if (isset($_POST['submit'])) {
    $admin_name = zen_db_prepare_input($_POST['admin_name']);
    $admin_pass = zen_db_prepare_input($_POST['admin_pass']);
    $sql = "select admin_id, admin_name, admin_email, admin_pass, admin_status, admin_show_customer_email,latest_login_time from " . TABLE_ADMIN . " where admin_name = '" . zen_db_input($admin_name) . "'";
    $result = $db->Execute($sql);
    
    if($result->fields['admin_status'] == 20){
        $message = true;
        $pass_message = 'Sorry, you can’t log in.';
        $_SESSION['admin_forbid'] = true;
    }
    
    if (!($admin_name == $result->fields['admin_name'])) {
        $message = true;
        $pass_message = ERROR_WRONG_LOGIN;
        $_SESSION['admin_forbid'] = false;
    }
    if (!zen_validate_password($admin_pass, $result->fields['admin_pass'])) {
        $message = true;
        $pass_message = ERROR_WRONG_LOGIN;
        $_SESSION['admin_forbid'] = false;
    }
    if ($message == false) {
        $_SESSION['admin_forbid'] = false;
        $latest_login_time = $result->fields['latest_login_time'];
        $password_failed = floor((strtotime(date('Y-m-d'))-strtotime($latest_login_time))/86400)/60 >1 ? true:false;
        if($password_failed){
            //echo 1;exit;
            zen_redirect(zen_href_link('password_change', 'admin_id='. $result->fields['admin_id']));
        } else {
            $_SESSION['admin_id'] = $result->fields['admin_id'];
            $_SESSION['admin_name'] = $result->fields['admin_name'];
            $_SESSION['admin_email'] = $result->fields['admin_email'];
            if (SESSION_RECREATE == 'True') {
                zen_session_recreate();
            }
            $_SESSION['show_customer_email'] = $result->fields['admin_show_customer_email'];
            $lang_id = $_POST['lang_select']-1;
            $langs_arr=zen_get_languages();
            $_SESSION['language'] = $langs_arr[$lang_id]['directory'];
            $_SESSION['languages_id'] = $langs_arr[$lang_id]['id'] ;
            $_SESSION['languages_code'] = $langs_arr[$lang_id]['code'];
            zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body id="login" onload="document.getElementById('admin_name').focus()">
<div class="logo_top">
	<img src="images/logo1.png" alt="">
	<div class="neme_top"> 后台管理系统</div>
</div>
<div class="contbgImage">
<div class="loginLf" style="width: 60%;"></div>
<form name="login" action="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>" method = "post">
  <fieldset>
    <legend class="title_top"><?php echo HEADING_TITLE; ?></legend>
		<div style="margin-top: 10px;">
			<label class="loginLabel" for="admin_name"><span>* </span><?php echo TEXT_ADMIN_NAME; ?></label>
			<input class="inputSty" type="text" id="admin_name" name="admin_name" value="<?php echo zen_output_string($admin_name); ?>" />
    </div>
		<div style="margin-top: 20px;">
			<label  class="loginLabel" for="admin_pass"><span>* </span><?php echo TEXT_ADMIN_PASS; ?></label>
			<input class="inputSty" type="password" id="admin_pass" name="admin_pass" value="<?php echo zen_output_string($admin_pass); ?>" />
    </div>
		<div style="margin-top: 20px;">
			<label class="loginLabel" for="admin_lang"><span style="color: #fff;">* </span> Choose Language:</label>
			<?php 
			$langs = zen_get_languages();
			if (sizeof($langs) > 1) {
				?>
				<select name="lang_select" class="selectTyp">
				<?php
				for ($i = 0, $n = sizeof($langs); $i < $n; $i++) {
					if($langs[$i]['directory']==$_SESSION['language']){
						echo "<option value='".$langs[$i]['id']."' selected='selected'>".$langs[$i]['name']."</option>";
					}else{
						echo "<option value='".$langs[$i]['id']."'>".$langs[$i]['name']."</option>";
					}
			//        $langs_array[] = array('id' => $langs[$i]['code'],
			//                                 'text' => $langs[$i]['name']);
			//        if ($langs[$i]['directory'] == $_SESSION['language']) {
			//          $langs_selected = $langs[$i]['code'];
					}
			  ?>
				</select>
				<?php 
				}
			?>
    </div>
    <div style="color:red;height: 20px;"><?php echo $pass_message; ?></div>
		<?php
		if(!$_SESSION['admin_forbid']){
		   echo '<a style="display:block;text-align:right;color:#666;" href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; 
		}
		?>
		<div style="text-align: center;margin-top: 50px;">
      <input type="submit" name="submit" class="button" value="Login" />
		</div>
  </fieldset>
</form>
</div>
<div class="footerLogin">
	<p>中国浙江义乌市城店南路718号</p>
	<p>版权所有 © 2002-2020义乌市潘多电子商务有限公司，Doreenbeads版权所有</p>
</div>
</body>
</html>
<?php require('includes/application_bottom.php'); ?>
