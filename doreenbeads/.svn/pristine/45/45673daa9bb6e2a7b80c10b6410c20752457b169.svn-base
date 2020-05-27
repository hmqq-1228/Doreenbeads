function check_pwd(form){
	var form_name = form;
	var password = $.trim($('#new_password').val());
	var confirm_password = $.trim($('#confirm_password').val());
	var error = false;
	if(password.length<5){
		error = true;
		$('#pwd_error').html(js_lang.WrongPassword).show();	
	}else{
		$('#pwd_error').html('').hide();	
	}
	if(password!==confirm_password){
		error = true;
		$('#confirm_pwd_error').html(js_lang.WrongPwdConf).show();
	}else{
		$('#confirm_pwd_error').html('').hide();
	}
	return !error;
}

/*
function checkPwd(type){
	var password = $.trim($('#new-password').val());
	var confirm_password = $.trim($('#confirm-password').val());
	if(type==1){
		if(password == ''){
			$('#pwd_alert').html('');	
			$('#confirm_pwd_alert').html('');
		}else if(password.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH;?>){	
			$('#pwd_alert').html('<?php echo CAUTION_AT_LEAST_WORDS;?>');	
			$('#confirm_pwd_alert').html('');
			return false;
		}else if(confirm_password == ''){
			$('#pwd_alert').html('');	
			$('#confirm_pwd_alert').html('');
		}else if(password != confirm_password){
			$('#pwd_alert').html('');	
			$('#confirm_pwd_alert').html('<?php echo CAUTION_PWD_NOT_SAME;?>');
			return false;
		}else{
			$('#pwd_alert').html('');	
			$('#confirm_pwd_alert').html('');
		}
	}	
	if(type==0){
		if($('#pwd_alert').html() == '' && $('#confirm_pwd_alert').html() == '' && password.length != 0 && confirm_password.length != 0){ //submit
			return true;
		}else{	//can't submit
			if($('#pwd_alert').html() != '' || password == ''){
				$('#pwd_alert').html('<?php echo CAUTION_AT_LEAST_WORDS;?>');
			}else if($('#confirm_pwd_alert').html() != ''){
				$('#confirm_pwd_alert').html('<?php echo CAUTION_PWD_NOT_SAME;?>');
			}else if(password.length == 0){
				$('#pwd_alert').html('<?php echo CAUTION_AT_LEAST_WORDS;?>');
			}else if(confirm_password.length == 0){
				$('#confirm_pwd_alert').html('<?php echo CAUTION_PWD_NOT_SAME;?>');
			}
			return false;
		}
	}
 }*/