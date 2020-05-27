
function isEmail(str){
	strRegex = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}

function checkValidateCode(forms){
	$('#emailnotice').hide();
	$('#codenotice').hide();
	err = false;
	var form_code = $.trim($('#check_code_input').val().toLowerCase());
	var email = $.trim($('.forgetaddress').val());
	if(!isEmail(email)){
		$('#emailnotice').html(js_lang.CheckEmail).show();
		 err = true;
	}
	if(form_code.length == 0){
		 $('#codenotice').html(js_lang.CheckValidate).show();
		 err = true;
	}
	if (err) {
		return false;
	};
	$.ajax({
		'url':'checkCode.php',
		'type':'post',
		'data':{'code_suffix':'password', 'form_code':form_code},
		'async':false,
		'success':function(data){
			if(data.length > 0){
				err = true;
				$('#codenotice').html(data).show();
				$('.Code img').attr('src', './check_code.php?'+Math.random());
			}else{
				$('#codenotice').html('').hide();			
			}
		}
	}); 
	if(!err){
		//forms.submit();
		return true;
	}else{
		return false;
	}
}

