
function isEmail(str){
	strRegex = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}

function check(name){

	var error = false;
	var first_name = $.trim($("#first-name").val());
	var email 	   = $.trim($("#question-email").val());
	var message    = $.trim($("#message").val());


	if(first_name.length<2){
		error = true;
		$("#first_name_span").html(js_lang.TEXT_NAME_SHORT);
	}
	if(first_name.length == 0){
		error = true;
		$("#first_name_span").html(js_lang.TEXT_NAME_EMPTY)
	}
		
	if(email.length<6 ){
		error =true;
		$("#email_span").html(js_lang.WrongEmail);
	}else if (!isEmail(email)){
		error =true;
		$("#email_span").html(js_lang.TEXT_EMAIL_FORMAT);
	}
	if(email.length == 0 ){
		error =true;
		$("#email_span").html(js_lang.TEXT_EMAIL_EMPTY);
	}
	
	if(message.length == 0){
		error = true;
		$("#message_span").html(js_lang.TEXT_MESSAGE_EMPTY);
	}
	
	if($('#check_code_input').length > 0){
		var form_code = $('#check_code_input').val().toLowerCase();
		
		if(form_code.length == 0){
			error = true;
			$("#login_checkcode_error").text(js_lang.TEXT_AUTH_CODE_ERROR);
		}else{
			$.ajax({
				url: './checkCode.php',
				type: 'POST',
				async: false,
				data: {form_code: form_code},
				success: function(data){
					if(data.length > 0){
						$("#login_checkcode_error").text(js_lang.TEXT_AUTH_CODE_ERROR);
						error = true;
					}
				}
			});
		}
	}
	if(error){
		return false;
	}else{
		return true;
	}
	
}

$(document).ready(function(){
	$("#first-name").keydown(function(){
		$("#first_name_span").html("");
	});	
	$("#question-email").keydown(function(){
		$("#email_span").html("");
	});
	$("#message").keydown(function(){
		$("#message_span").html("");
	});
});


$(document).ready(function(){

	setTimeout('hidden()',5000);		
});

function hidden(){
	$(".messageStackSuccess").css('display','none');
}














