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
// $Id: jscript_main.php 1969 2005-09-13 06:57:21Z drbyte $
//
?>
<script language="javascript" type="text/javascript">
var pwd_error = true;
var fname_error = true;
var lname_error = true;
var email_error = true;
var confirm_error = true;
var country_error = true;
var terms_error = true;
var check_code_error = false;
var email_min_len = "<?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH;?>";
var firstname_min_len = "<?php echo ENTRY_FIRST_NAME_MIN_LENGTH;?>";
var lastname_min_len = "<?php echo ENTRY_LAST_NAME_MIN_LENGTH;?>";
var password_min_len = "<?php echo ENTRY_PASSWORD_MIN_LENGTH;?>";
var password_pattern = /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/g;

function session_win() {
  window.open("<?php echo zen_href_link(FILENAME_INFO_SHOPPING_CART); ?>","info_shopping_cart","height=460,width=430,toolbar=no,statusbar=no,scrollbars=yes").focus();
}
function isEmail(str){
	strRegex = /^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}
$j(document).ready(function(){
	$j("#login-emailaddress").focus(function(){
		$j("#login_email_error").html('');
	});
	$j("#login-passwd").focus(function(){
		$j("#login_passwd_error").html('');
	});
	$j("#email-address").focus(function(){
		$j("#reg_email_error").html('');
	});
	$j("#firstname").focus(function(){
		$j("#reg_firstname_error").html('');
	});
	$j("#lastname").focus(function(){
		$j("#reg_lastname_error").html('');
	});
	$j("#password-new").focus(function(){
		$j("#reg_password_error").html('');
	});
	$j("#password-confirm").focus(function(){
		$j("#reg_confirm_error").html('');
	});
	$j("#country").focus(function(){
		$j("#reg_country_error").html('');
	});
//	$j("#agree_to").focus(function(){
//		$j("#reg_agree_error").html('');
//	});
	$j("#check_code_input").focus(function(){
		$j("#login_checkcode_error").html('');
	});
	$j("#reg_check_code_input").focus(function(){
		$j("#reg_checkcode_error").html('');
	});

	$j("#email-address").on("blur",function(){
		var reg_email =$j.trim($j("#email-address").val());
		if(reg_email.length < email_min_len ){
			email_error =true;
			if(reg_email.length != 0){
				$j("#reg_email_error").html('<?php echo ENTRY_EMAIL_ADDRESS_ERROR;?>').addClass("alert");
			}else{
				$j("#reg_email_error").html('<?php echo ALERT_EMAIL;?>').addClass("alert");
			}
		}else if (!isEmail(reg_email)){
			email_error =true;
			$j("#reg_email_error").html('<?php echo TEXT_EMAIL_REG_TIP;?>').addClass("alert");
		}else{
			email_error = false;
			$j("#reg_email_error").html('');
		}
	});
	
	$j('#firstname').on("blur",function(){
		var firstname = $j('#firstname').val();
		
		if(firstname.length < firstname_min_len){
			fname_error =true;
			$j("#reg_firstname_error").html('<?php echo TEXT_ENTER_FIRESTNAME;?>').addClass("alert");
		}else{
			fname_error = false;
			$j("#reg_firstname_error").html('');
		}
	});

	$j('#lastname').on("blur",function(){
		var lastname = $j('#lastname').val();
		if(lastname.length<lastname_min_len){
			lname_error =true;
			$j("#reg_lastname_error").html('<?php echo TEXT_ENTER_LASTNAME;?>').addClass("alert");
		}else{
			lname_error =false;
			$j("#reg_lastname_error").html('');
		}
	});

	$j("#password-new").on("blur",function(){
		var password_new = $j('#password-new').val();
		$j(this).next("span").text('');
		if(password_new.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?> || !password_new.match(password_pattern)){
			if(password_new.length != 0){
				$j("#reg_password_error").html('<?php echo ENTRY_PASSWORD_ERROR;?>');
			}else{
				$j("#reg_password_error").html('<?php echo ENTER_PASSWORD_PROMPT;?>');
			}
			pwd_error = true;
		}else{
			$j("#reg_password_error").html('');
			pwd_error = false;
		}
	});

	$j("#password-new").on("keyup" , function(){
		var password_new = $j('#password-new').val();
		if($j("#reg_password_error").html() != ""){
			if(password_new.length >= <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?>){
				$j("#reg_password_error").html('');
				pwd_error = false;
			}
		}
	});

	$j("#password-confirm").on("blur",function(){
		var password_new = $j('#password-new').val();
		var password_confirm = $j('#password-confirm').val();

		$j(this).next("span").text("");
		if(password_confirm.length == 0){
			$j("#reg_confirm_error").html(' <?php echo TEXT_CONFIRM_PASSWORD;?>');
			confirm_error = true;
			return false;
		}
		
		if(password_confirm != password_new){
			$j("#reg_confirm_error").html(' <?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING;?>');
			confirm_error = true;
		}else{
			$j("#reg_confirm_error").html("");
			confirm_error = false;
		}
	});

	$j("#agreeterm").on("change" , function(){
		if(!document.getElementById("agreeterm").checked) {
			$j("#reg_agree_error").html('<?php echo ENTRY_AGREEN_ERROR_SELECT;?>');
			terms_error =  true;
		}else{
			$j("#reg_agree_error").html('');
			terms_error =  false;
		}
	});

	$j('#zone_country_id').on("change" , function(){
		var zone_country_id=$j('#zone_country_id').val();

		if(zone_country_id.length<1){
			country_error = true;
			$j("#reg_country_error").html('<?php echo ENTRY_COUNTRY_ERROR;?>');
		}else{
			country_error = false;
			$j("#reg_country_error").html('');
		}
	});

	if($j('#reg_check_code_input').length > 0){
		check_code_error = true;
		
		$j('#reg_check_code_input').on('blur' , function(){
			var form_code = $j('#reg_check_code_input').val().toLowerCase();
			$j.ajax({
				url: './checkCode.php',
				type: 'POST',
				async: false,
				data: {code_suffix: 'login', form_code: form_code},
				success: function(data){
					if(data.length > 0){
						check_code_error = true;
						$j("#reg_checkcode_error").html('<?php echo TEXT_INPUT_RIGHT_CODE;?>');
					}else{
						check_code_error = false;
						$j("#reg_checkcode_error").html('');
					}
				}
			});
		});
	
	}
	
});
function check_register_form(form_name){
	if(!email_error && !pwd_error && !fname_error && !lname_error && !confirm_error && !country_error && !terms_error && !check_code_error){
		return true;
	}else{	
		form = form_name;
		error_data=false;
		
		var reg_email =$j.trim(form.email_address.value);
		var password = $j.trim(form.password.value);
		var confirmation = $j.trim(form.confirmation.value);
		//var agree_to = form.agree_to.checked;
		
		if($j('#reg_check_code_input').length > 0){
			var form_code = $j('#reg_check_code_input').val().toLowerCase();
			$j.ajax({
				url: './checkCode.php',
				type: 'POST',
				async: false,
				data: {code_suffix: 'login', form_code: form_code},
				success: function(data){
					if(data.length > 0){
						error_data = true;
						$j("#reg_checkcode_error").html('<?php echo TEXT_INPUT_RIGHT_CODE;?>');
					}
				}
			});
		}
		
		if(reg_email.length<email_min_len ){
			error_data =true;
			if(reg_email.length != 0){
				$j("#reg_email_error").html('<?php echo ENTRY_EMAIL_ADDRESS_ERROR;?>').addClass("alert");
			}else{
				$j("#reg_email_error").html('<?php echo ALERT_EMAIL;?>').addClass("alert");
			}
		}else if (!isEmail(reg_email)){
			error_data =true;
			$j("#reg_email_error").html('<?php echo ENTRY_EMAIL_ADDRESS_ERROR;?>');
		}else{
			$j("#reg_email_error").html('');
		}
		if(password.length<password_min_len || !password.match(password_pattern)){
			error_data =true;
			$j("#password-new").next("span").text('');
			if(password.length != 0){
				$j("#reg_password_error").html('<?php echo ENTRY_PASSWORD_ERROR;?>');
			}else{
				$j("#reg_password_error").html('<?php echo ENTER_PASSWORD_PROMPT;?>');
			}
		}else{
			$j("#password-new").next("span").text('');
			$j("#reg_password_error").html('');
		}
		
		if(password!=confirmation){
			error_data =true;
			$j("#password-confirm").next("span").text("");
			$j("#reg_confirm_error").html('<?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING;?>');
		}else if(confirmation.length == 0){
			error_data =true;
			$j("#password-confirm").next("span").text("");
			$j("#reg_confirm_error").html('<?php echo TEXT_CONFIRM_PASSWORD;?>');
		}else{
			$j("#password-confirm").next("span").text("");
			$j("#reg_confirm_error").html('');
		}	
//		if(agree_to==false){
//			error_data =true;
//			$j("#reg_agree_error").html('<?php echo ENTRY_AGREEN_ERROR_SELECT;?>');
//		}else{
//			$j("#reg_agree_error").html('');
//		}
		if(error_data==false){
			//create_account.submit();
			return true;
		}
		return false;
	}
}
function check_login_form(form_name){
	form = form_name;
	error_data=false;
	var auth_code = '';
	var is_master = false;
	
	var email = document.getElementsByName('email_address')[0].value;	
	var password = document.getElementsByName('password')[0].value; 
	if($j('#check_code_input').length > 0){
		var form_code = $j('#check_code_input').val().toLowerCase();
		$j.ajax({
			url: './checkCode.php',
			type: 'POST',
			async: false,
			data: {code_suffix: 'login', form_code: form_code},
			success: function(data){
				if(data.length > 0){
					error_data = true;
					$j("#login_checkcode_error").html('<?php echo TEXT_INPUT_RIGHT_CODE;?>');
					$j("#check_code").attr("src", '/check_code.php?code_suffix=login&' + Math.random());
				}
			}
		});
	}
	
	if($j("tr.auth_tr").length == 0){
		$j.ajax({  
	         type : "post",  
	          url : "./ajax_login.php",  
	          data : {action:"check_is_skeleton_key",password:password},  
	          async : false,  
	          success : function(data){
	        	  returnInfo = process_json(data);
	        	  if(returnInfo.is_master_pass == 1){
	        		is_master = true;
	        		if($j('#check_code_input').length > 0){
						$j("#check_code_tr").remove();
		        	}
	  				$j("tr.password_tr").after(returnInfo.auth_content);
	  				error_data = true;
	  			}
	          }  
	     }); 

		if(!is_master){
			var email_min_len = "<?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH;?>";	
			var password_min_len = "<?php echo ENTRY_PASSWORD_MIN_LENGTH;?>";
						
			if(email.length<email_min_len){
				error_data =true;
				if(email.length != 0 ){
					$j("#login_email_error").html('<?php echo ENTRY_EMAIL_ADDRESS_ERROR;?>');
				}else{
					$j("#login_email_error").html('<?php echo ALERT_EMAIL;?>');
				}
			}else if (!isEmail(email)){
				error_data =true;
				$j("#login_email_error").html('<?php echo ENTRY_EMAIL_FORMAT_ERROR;?>');
			}else{
				$j("#login_email_error").html('');
			}
	
			if(password.length<password_min_len){
				error_data =true;
				$j("#login_passwd_error").html('<?php echo ENTRY_PASSWORD_ERROR;?>');
			}else{
				$j("#login_passwd_error").html('');
			}
		}
	}else{
		auth_code = $j("#auth_key").val();
		if(auth_code != ''){
			error_data = false;
			$j("#auth_code_error").html('');
		}else{
			var tim = '<font>Warning: Please enter the authorization code.</font>';
			if($j("#auth_code_error").html().length == 0){
				$j("#auth_code_error").html(tim);
				error_data = true;
			}
		}
	}
	
	if(error_data==false){		
		return true;
	}
	return false;
	
}

</script>