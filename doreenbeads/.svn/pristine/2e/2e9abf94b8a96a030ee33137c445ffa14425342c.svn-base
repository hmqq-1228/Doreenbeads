<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_password_forgotten_default.php 3712 2006-06-05 20:54:13Z drbyte $
 */
?>
<script type="text/javascript">
$j(function(){
	$j('.submit-btn').click(function(){
		$j('.resetpass-form').submit();
	})
})
 function checkPwd(type){
	var password = $j.trim($j('#new-password').val());
	var confirm_password = $j.trim($j('#confirm-password').val());
	if(type==1){
		if(password == ''){
			$j('#pwd_alert').html('');	
			$j('#confirm_pwd_alert').html('');
		}else if(password.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH;?>){	
			$j('#pwd_alert').html('<?php echo CAUTION_AT_LEAST_WORDS;?>');	
			$j('#confirm_pwd_alert').html('');
			return false;
		}else if(confirm_password == ''){
			$j('#pwd_alert').html('');	
			$j('#confirm_pwd_alert').html('');
		}else if(password != confirm_password){
			$j('#pwd_alert').html('');	
			$j('#confirm_pwd_alert').html('<?php echo CAUTION_PWD_NOT_SAME;?>');
			return false;
		}else{
			$j('#pwd_alert').html('');	
			$j('#confirm_pwd_alert').html('');
		}
	}	
	if(type==0){
		if($j('#pwd_alert').html() == '' && $j('#confirm_pwd_alert').html() == '' && password.length != 0 && confirm_password.length != 0){ //submit
			return true;
		}else{	//can't submit
			if($j('#pwd_alert').html() != '' || password == ''){
				$j('#pwd_alert').html('<?php echo CAUTION_AT_LEAST_WORDS;?>');
			}else if($j('#confirm_pwd_alert').html() != ''){
				$j('#confirm_pwd_alert').html('<?php echo CAUTION_PWD_NOT_SAME;?>');
			}else if(password.length == 0){
				$j('#pwd_alert').html('<?php echo CAUTION_AT_LEAST_WORDS;?>');
			}else if(confirm_password.length == 0){
				$j('#confirm_pwd_alert').html('<?php echo CAUTION_PWD_NOT_SAME;?>');
			}
			return false;
		}
	}
 }
 function jump(count) {
     window.setTimeout(function(){
         count--;  
         if(count >= 0) {  
             jump(count);  
         } else {  
             location.href="<?php echo zen_href_link(FILENAME_DEFAULT);?>";  
         }  
     }, 1000);  
 }  
</script>
<?php if ($messageStack->size('link') > 0) echo $messageStack->output('link'); ?>
<?php 
	if ($autoJump){
		echo '<script type="text/javascript">window.onload=jump(3);</script>';
	}
?>
<div class="forgetpass">
	<h3><ins><?php echo RESET_PASSWORD;?></ins></h3>
	<p class="tit_notice"><?php echo YOUR_ACCOUNT_IS;?><span style="color:#008FED;"><?php echo $reset_password->fields['rp_email_address'];?></span></p>
	<form name="password_reset" class="resetpass-form" action="<?php echo zen_href_link(FILENAME_PASSWORD_RESET, 'action=process&p=' . $p_tmp, 'SSL');?>" method="POST" onsubmit="return checkPwd(0);">
		<table>
			<tr>
				<td width="160"><label>*</label><?php echo ENTER_NEW_PWD; ?></td>
				<td>
					<input name="new_password" value="" type="password" class="forgetaddress" id="new-password" onblur="checkPwd(1);"/>
					<p id="pwd_alert"></p>
				</td>
			</tr>
			<tr>
				<td><label>*</label><?php echo CONFIRM_ENTER_NEW_PWD; ?></td>
				<td>
					<input name="confirm_password" value="" type="password" class="check_code_input" id="confirm-password" onblur="checkPwd(1);"/>
					<p id="confirm_pwd_alert"></p>
				</td>
			</tr>
			<tr>
				<td></td><td><input type="button" class="submit-btn" value="Submit"/></td>
			</tr>
		</table>
	</form>
	<div class="forgetpass-require"><label><?php echo FORM_REQUIRED_INFORMATION;?></label></div>
	<div class="clearfix"></div>
</div>