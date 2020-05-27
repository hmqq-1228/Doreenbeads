<script type="text/javascript">
function checkValidateCode(forms){
	err = false;
	var form_code = $j.trim($j('#check_code_input').val().toLowerCase());
	var email = $j.trim($j('.forgetaddress').val());
	if(!check_email(email)){
		$j('#emailnotice').html("<?php echo ENTRY_EMAIL_FORMAT_ERROR;?>");
		 err = true;
	}
	if(form_code.length == 0){
		 $j('#codenotice').html("<?php echo TEXT_INPUT_RIGHT_CODE;?>");
		 err = true;
	}

	$j.ajax({
		'url':'checkCode.php',
		'type':'post',
		'data':{'code_suffix':'password', 'form_code':form_code},
		'async':false,
		'success':function(data){
			if(data.length > 0){
				$j('#codenotice').html(data);
			}else{
				$j('#codenotice').html('');
				if(!err){
					forms.submit();
				}
			}
		}
	}); 
}
</script>
<?php if ($messageStack->size('login') > 0) echo $messageStack->output('login'); ?>
<?php if ($messageStack->size('password_forgotten') > 0) echo $messageStack->output('password_forgotten'); ?>
<div class="forgetpass">
	<h3><?php echo HEADING_TITLE;?></h3>
	<p class="tit_notice"><?php echo TEXT_MAIN;?></p>
	<form name="password_forgotten" class="forgetpass-form" action="<?php echo zen_href_link(FILENAME_PASSWORD_FORGOTTEN, 'action=process', 'SSL');?>" method="post">
		<table>
			<tr>
				<td width="120"><label>*</label><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
				<td><input type="text" class="forgetaddress" name="email_address" id="email-address" /><p id="emailnotice"></p></td>
			</tr>
			<tr>
				<td><label>*</label><?php echo TEXT_CHECK_CODE;?></td>
				<td><input type="text" name="check_code" class="check_code_input" id="check_code_input"/><img id="check_code" src="./check_code.php?code_suffix=password"  onClick="this.src='./check_code.php?code_suffix=password&'+Math.random();" /><p id="codenotice"></p></td>
			</tr>
			<tr>
				<td></td><td><input type="button" class="submit-btn" value="Submit" onclick="checkValidateCode(this.form);"/></td>
			</tr>
		</table>
		<p class="contact-us"><?php echo TEXT_FORGOT_EMAIL_ADDRESS;?></p>
	</form>
	<div class="forgetpass-require"><label><?php echo FORM_REQUIRED_INFORMATION; ?></label></div>
	<div class="clearfix"></div>
</div>