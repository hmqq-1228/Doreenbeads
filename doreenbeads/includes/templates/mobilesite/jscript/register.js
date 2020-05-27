var pwd_error = true;
var fname_error = true;
var lname_error = true;
var email_error = true;
var confirm_error = true;
var terms_error = true;
var password_pattern = /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/g;

var email_min_len = 6;
var firstname_min_len = 1;
var lastname_min_len = 1;
var password_min_len = 5;

$(document).ready(function(){
	$('#reg_email_address').on('focus',function(){
		$(this).parent().next(".reg-notice").html('<span id="reg_email_error"></span>');
	});
	$('#reg_email_address').on('blur',function(){
		var reg_email = $('#reg_email_address').val();
		if(reg_email.length < email_min_len ){
			email_error =true;
			if(reg_email.length != 0){
				$("#reg_email_error").html(js_lang.WrongEmail);
			}else{
				$("#reg_email_error").html(js_lang.TEXT_EMAIL_EMPTY);
			}
		}else if (!isEmail(reg_email)){
			email_error =true;
			$("#reg_email_error").html(js_lang.WrongEmail);
		}else{
			email_error = false;
			$("#reg_email_error").html('');
		}
	});
	
	$('#reg_firstname').on('focus',function(){
		$(this).parent().next(".reg-notice").html('<span id="reg_fn_error"></span>');
	});
	
	
	$('#reg_firstname').on('blur',function(){
		var first_name = $('#reg_firstname').val();
		if(first_name.length < firstname_min_len){
			fname_error = true;
			$("#reg_fn_error").html(js_lang.WrongFirstName);
		}else{
			fname_error = false;
			$("#reg_fn_error").html('');
		}
	});
	
	$('#reg_lastname').on('focus',function(){
		$(this).parent().next(".reg-notice").html('<span id="reg_ln_error"></span>');
	});
	
	$('#reg_lastname').on('blur',function(){
		var last_name = $('#reg_lastname').val();
		if(last_name.length < lastname_min_len){
			lname_error = true;
			$("#reg_ln_error").html(js_lang.WrongLastName);
		}else{
			lname_error = false;
			$("#reg_ln_error").html("");
		}
	});
	$('#reg_password').on('focus',function(){
		$(this).parent().next(".reg-notice").html('<span id="reg_password_error"></span>');
	});
	$('#reg_password').on('blur',function(){
		var password = $('#reg_password').val();
		if(password.length < password_min_len || !password.match(password_pattern)){
			pwd_error = true;
			if(password.length != 0){
				$("#reg_password_error").html(js_lang.WrongPassword);
			}else{
				$("#reg_password_error").html(js_lang.ENTER_PASSWORD_PROMPT);
			}
			
		}else{
			pwd_error = false;
			$("#reg_password_error").html('');
		}
	});
	
	$('#reg_password').on('keyup',function(){
		var password = $('#reg_password').val();
		
		if($("#reg_password_error").html() != ""){
			if(password.length >= password_min_len){
				$("#reg_password_error").html('') ;
				pwd_error = false;
			}
		}
	});
	
	$('#confirmpass').on('focus',function(){
		$(this).parent().next(".reg-notice").html('<span id="reg_confpwd_error"></span>');
	});
	
	$('#confirmpass').on('blur',function(){
		var confirmpass = $('#confirmpass').val();
		var password = $('#reg_password').val();
		
		if(confirmpass.length == 0){
			confirm_error = true;
			$("#reg_confpwd_error").html(js_lang.TEXT_CONFIRM_PASSWORD);
			return false;
		}
		
		if(confirmpass!=password){
			confirm_error = true;
			$("#reg_confpwd_error").html(js_lang.WrongPwdConf);
		}else{
			confirm_error = false;
			$("#reg_confpwd_error").html('');
		}
	});
	
	$("#agree_span").on("click" , function(){
		if($("#agree_span").attr('class')=="check select"){
			terms_error = false;
			$("#agree_terms_error").html('');
		}else{
			terms_error = true;
			$("#agree_terms_error").html(js_lang.NotAgreeTC);
		}
	});
	
});

function country_select_choose(cName){
	$(document).ready(function(){
		$('.choose_single').click(function(){	
				var ifshow=$('.country_select_drop').css('display');
				current=$("#cSelectId").val();
				if(ifshow=="none"){
					$('.country_select_drop').show();
					$(this).removeClass('choose_single_focus');
					$(this).addClass('choose_single_click');
					$('.country_select_drop .choose_search input').val('');
					$('.country_select_drop ul .country_list_item').css('display','block');
					$('.country_select_drop .choose_search input').focus();
					cNum=$('#cSelectId').val();
					if($("#country_list_"+cNum).hasClass('country_list_item_selected')&&!$("#cSelectId").hasClass('selectNeedList')){
						
						}else{
							$("#cSelectId").removeClass('selectNeedList');
							$("#country_list_"+cNum).addClass('country_list_item_selected');
							boxTop1=$("#country_list_1").position().top;
							boxTop2=$("#country_list_"+cNum).position().top;
							selfHeight=$("#country_list_"+cNum).height()+8+7;
							boxTop=boxTop2-boxTop1-220+selfHeight;
							$('.country_select_drop ul').scrollTop((boxTop));
							}
					}else{
						$('.country_select_drop').hide();
						$(this).removeClass('choose_single_click');
						$(this).addClass('choose_single_focus');
						}
			})

		$('.country_list_item').hover(function(){
			$(this).addClass('country_list_item_hover');
			$('.country_list_item').removeClass('country_list_item_selected');
			},function(){
				$(this).removeClass('country_list_item_hover');
				})	

		$('.country_list_item').click(function(){	
			var cListId=$(this).attr('clistid');
			var cText=$(this).text();
			var cId=$(this).attr('id');
			cIdArr=cId.split('_');
			getCId=cIdArr[2];
			$('.choose_single span').text(cText);
			$('#'+cName).val(cListId);
			$('#cSelectId').val(getCId);
			$(this).addClass('country_list_item_selected');
			$('.country_select_drop').hide();
			
			$('.choose_single').removeClass('choose_single_click');
			$('.choose_single').addClass('choose_single_focus');
			$('.choose_single').focus();
			})	

		$('.choose_single').blur(function(){
			$(this).removeClass('choose_single_focus');
			})

		$('.choose_search input').keyup(function(){
		    inputVal=$(this).val();
		    inputVals=inputVal.replace(/^\s*|\s*$/g, "");
			if(inputVals!=''){
					$('.country_select_drop ul').scrollTop(0);
					$("#cSelectId").addClass('selectNeedList');
					$(".country_select_drop ul .country_list_item").each(function(){
						cTextVal=$(this).text();
						re = new RegExp("^"+inputVals,'i');  
						re2= new RegExp("\\s+"+inputVals,'i')
						if(cTextVal.match(re)||cTextVal.match(re2)){
									$(this).css('display','block');
								}else{
									$(this).css('display','none');
									}
						});
				}else{
					$('.country_select_drop ul .country_list_item').css('display','block');
					}
			})
				
		});	
}


function isEmail(str){
	strRegex = /^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}
/*$(document).ready(function(){
	$("#login-email-address").focus(function(){
		$("#login_email_error").html('');
	});
	$("#login-passwd").focus(function(){
		$("#login_passwd_error").html('');
	});
});*/

function Toggle(id){
	$("#"+id).toggleClass("select");
	if ($("#"+id).hasClass("select")) {
		$('#newsletter').attr("checked","checked");
	}else{
		$('#newsletter').removeAttr("checked","checked");
	};
}
function loading_show(){
	$(".loading").removeClass("hiddenField");
}
function loading_hide(){

	$(".loading").addClass("hiddenField");
}

function check_reg_form(form_name){
	if(!pwd_error && !fname_error && !lname_error && !email_error && !confirm_error && !terms_error){
		return true;
	}else{
		form = form_name;
		error_data=false;
		//alert($("#agree_span").attr('class'));
		
		var reg_email  = $.trim(form.reg_email_address.value);
		var first_name = $.trim(form.reg_firstname.value);
		var last_name  = $.trim(form.reg_lastname.value);
		var password   = $.trim(form.password.value); 
		var confirmpass = $.trim(form.confirmpass.value);
		var customers_country_id = $.trim(form.customers_country_id.value);
		//var agree_email = $.trim(form.agree_email.value);
		var agree_terms = $.trim(form.agree_terms_value);
		
		var email_min_len = 6;
		var firstname_min_len = 1;
		var lastname_min_len = 1;
		var password_min_len = 5;	
		
		$('#reg_email_address').parent().next(".reg-notice").html('<span id="reg_email_error"></span>');
		$('#reg_password').parent().next(".reg-notice").html('<span id="reg_password_error"></span>');
		$('#confirmpass').parent().next(".reg-notice").html('<span id="reg_confpwd_error"></span>');
		$('#reg_firstname').parent().next(".reg-notice").html('<span id="reg_fn_error"></span>');
		$('#reg_lastname').parent().next(".reg-notice").html('<span id="reg_ln_error"></span>');
		
		if(reg_email.length == 0 ){
			error_data =true;
			$("#reg_email_error").html(js_lang.TEXT_EMAIL_EMPTY);
		}else if (!isEmail(reg_email) || reg_email.length<email_min_len){
			error_data =true;
			$("#reg_email_error").html(js_lang.WrongEmail);
		}else{
			$("#reg_email_error").html('');
		}
		if(first_name.length<firstname_min_len){
			error_data = true;
			$("#reg_fn_error").html(js_lang.WrongFirstName);
		}else{
			$("#reg_fn_error").html('');
		}
		if(last_name.length<lastname_min_len){
			error_data = true;
			$("#reg_ln_error").html(js_lang.WrongLastName);
		}else{
			$("#reg_ln_error").html("");
		}
		if(password.length == 0){
			error_data =true;
			$("#reg_password_error").html(js_lang.ENTER_PASSWORD_PROMPT);
		}else if(password.length<password_min_len || !password.match(password_pattern)){
			error_data =true;
			$("#reg_password_error").html(js_lang.WrongPassword);
		}else{
			$("#reg_password_error").html('');
		}
		if(confirmpass.length == 0){
			error_data = true;
			$("#reg_confpwd_error").html(js_lang.TEXT_CONFIRM_PASSWORD);
		}else if(confirmpass!=password){
			error_data = true;
			$("#reg_confpwd_error").html(js_lang.WrongPwdConf);
		}else{
			$("#reg_confpwd_error").html('');
		}
		if($("#agree_span").attr('class')=="check select"){
		
		}else{
			error_data = true;
			$("#agree_terms_error").html(js_lang.NotAgreeTC);
		}
		if(error_data==false){
			loading_show();
			return true;
		}
		loading_hide();
		return false;
	}
}


