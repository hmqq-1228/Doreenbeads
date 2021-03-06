

$(document).ready(function(){
	$("#testimonial_content").keyup(function(){
		var num = 1000;
		var o = $("#testimonial_content").val();
		var length = $("#testimonial_content").val().length;
		if((length-num)>=0){
			$("#testimonial_content").val(o.substr(0,num));
			length = 1000;
		}
		$("#testimonial_content_span").html("("+(1000-length)+"charaters Remaining)");

	});
	$("#testimonial_content").focus(function(){
		if($("#testimonial_content").val() == js_lang.CheckTestimonialContent){
			$("#testimonial_content").val("");
			$("#testimonial_content").css("color","");
		}
	});
	$("#testimonial_4").addClass("bordernone");

});

function check(name){
	form_name = name;
	var error = false;
	if($("#testimonial_content").val().length == 0){
		$("#testimonial_content").val(js_lang.CheckTestimonialContent);
		$("#testimonial_content").css("color","red");
		error = true;
	}else{
		if(checkTextUrl($("#testimonial_content").val())){
			$("#p_error").html(js_lang.TEXT_CHECK_URL);
			error = true;
		}
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

	return !error;
}
