$(function(){
	var question_checking= function(){
		var q_checking = true;
		var emailvalue = $.trim($('#question-email').val());
		var firstname = $.trim($('#first-name').val());
		var lastname = $.trim($('#last-name').val());
	    var questionvalue = $.trim($('#question-text').val());
		if(!isEmail(emailvalue)){
			$('#question-email').next('p').text(js_lang.TEXT_EMAIL_WRONG);
			q_checking = false;
		}
	    if(firstname == ''){
			$('#first-name').next('p').text(js_lang.TEXT_FNAME_CANNOT_EMPTY);
			q_checking = false;
		}
		if(lastname == ''){
			$('#last-name').next('p').text(js_lang.TEXT_LNAME_CANNOT_EMPTY);
			q_checking = false;
		}
		if($('#check_code_input').length > 0){
			var form_code = $('#check_code_input').val().toLowerCase();
			$.ajax({
				url: './checkCode.php',
				type: 'POST',
				async: false,
				data: {form_code: form_code},
				success: function(data){
					if(data.length > 0){
						q_checking = false;
						$("#verify_code_note").html(js_lang.CheckValidate);
					}
				}
			});
		}
		if(questionvalue == ''){
			$('#question-text').next('p').text(js_lang.TEXT_QUESTION_CANNOT_EMPTY);
			q_checking = false;
		}
		return q_checking;
	};
	$("#question-submit").click(function(){
		if(!question_checking()) {
			 return false;
		}
	});	
	$('.questionform .required').focus(function(){
		$(this).next('p').text('');
	});
	$('#check_code_input').focus(function(){
		$('#verify_code_note').text('');
	});
});