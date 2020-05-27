$(function() {
    $(".loginform div .check").bind("click", function() {
        if($(this).hasClass("select")) {
            $(this).removeClass("select");
            $("#permLogin").val(0);
        } else {
            $(this).addClass("select");
            $("#permLogin").val(1);
        }
    });

    var email_min_len = 6;
    var password_min_len = 5;
    var password_pattern = /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/g;

    /*$('#reg_email_address').on('focus',function(){
        $(this).parent().next(".reg-notice").html('<span id="reg_email_error"></span>');
    });*/
    $('#reg_email_address').on('blur',function(){
        var reg_email = $('#reg_email_address').val();
        if(reg_email.length < email_min_len ){
            email_error =true;
            if(reg_email.length != 0){
                $("#reg_email_error").html(js_lang.WrongEmail).show();
            }else{
                $("#reg_email_error").html(js_lang.TEXT_EMAIL_EMPTY).show();
            }
        }else if (!isEmail(reg_email)){
            email_error =true;
            $("#reg_email_error").html(js_lang.RegEmail).show();
        }else{
            email_error = false;
            $("#reg_email_error").html('').hide();
        }
    });

    /*$('#reg_password').on('focus',function(){
        $(this).parent().next(".reg-notice").html('<span id="reg_password_error"></span>');
    });*/
    $('#reg_password').on('blur',function(){
        var password = $('#reg_password').val();
        if(password.length < password_min_len || !password.match(password_pattern)){
            pwd_error = true;
            if(password.length != 0){
                $("#reg_password_error").html(js_lang.WrongPassword).show();
            }else{
                $("#reg_password_error").html(js_lang.ENTER_PASSWORD_PROMPT).show();
            }

        }else{
            pwd_error = false;
            $("#reg_password_error").html('').hide();
        }
    });

    $('#reg_password').on('keyup',function(){
        var password = $('#reg_password').val();

        if($("#reg_password_error").html() != ""){
            if(password.length >= password_min_len){
                $("#reg_password_error").html('').hide();
                pwd_error = false;
            }
        }
    });

    /*$('#confirmpass').on('focus',function(){
        $(this).parent().next(".reg-notice").html('<span id="reg_confpwd_error"></span>');
    });*/

    $('#confirmpass').on('blur',function(){
        var confirmpass = $('#confirmpass').val();
        var password = $('#reg_password').val();

        if(confirmpass.length === 0){
            confirm_error = true;
            $("#reg_confpwd_error").html(js_lang.TEXT_CONFIRM_PASSWORD).show();
            return false;
        }

        if(confirmpass !== password){
            confirm_error = true;
            $("#reg_confpwd_error").html(js_lang.WrongPwdConf).show();
        }else{
            confirm_error = false;
            $("#reg_confpwd_error").html('').hide();
        }
    });
});

/*
function session_win() {
  window.open("<?php echo zen_href_link(FILENAME_INFO_SHOPPING_CART); ?>","info_shopping_cart","height=460,width=430,toolbar=no,statusbar=no,scrollbars=yes").focus();
}*/
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
function loading_show(){
    $(".loading").removeClass("hiddenField");
}
function loading_hide(){

    $(".loading").addClass("hiddenField");
}

function check_login_form(form_name){
    form = form_name;
    error_data=false;
    var is_master = false;

    $('.remove_messageStack_css').hide();

    var login_email =$.trim(form.login_email_address.value);
    var password = $.trim(form.login_password.value);

    var email_min_len = 6;
    var password_min_len = 5;

    /* check code*/
    if($('#check_code_input').length > 0){
        var form_code = $('#check_code_input').val().toLowerCase();
        $.ajax({
            url: './checkCode.php',
            type: 'POST',
            async: false,
            data: {code_suffix: 'login', form_code: form_code},
            success: function(data){
                if(data.length > 0){
                    error_data = true;
                    $("#codenotice").html(js_lang.TEXT_INPUT_RIGHT_CODE).show();
                    $('.loginCode img').attr('src', './check_code.php?code_suffix=login&' + Math.random());
                }else{
                    $("#codenotice").html('').hide();
                }
            }
        });
    }
    if($(".auth_tr").length == 0){
        $.ajax({
            type : "post",
            url : "./ajax_login.php",
            data : {action:"check_is_skeleton_key",password:password,is_mobilesite:true},
            async : false,
            success : function(data){
                returnInfo = process_json(data);
                if(returnInfo.is_master_pass == 1){
                    is_master = true;
                    $(".password_tr").after(returnInfo.auth_content);
                    error_data = true;
                    return false;
                }
            }
        });

        if(!is_master){
            if(login_email.length<email_min_len ){
                error_data = true;
                $("#login_email_error").html(js_lang.WrongEmail).show();
            }else if (!isEmail(login_email)){
                error_data = true;
                $("#login_email_error").html(js_lang.errWrongEmail).show();
            }else{
                $("#login_email_error").html('').hide();
            }
            if(password.length<password_min_len){
                error_data = true;
                $("#login_passwd_error").html(js_lang.WrongPassword).show();
            }else{
                $("#login_passwd_error").html('').hide();
            }
        }
    }else{
        auth_code = $("#auth_key").val();
        if(auth_code != ''){
            error_data = false;
            $("#auth_code_error").html('');
        }else{
            var tim = '<font>Warning: Please enter the authorization code.</font>';
            if($("#auth_code_error").html().length == 0){
                $("#auth_code_error").html(tim);
                error_data = true;
            }
        }
    }

    if(error_data==false){
        loading_show();
        return true;
    }
    return false;
}

function check_reg_form(){
    var password_pattern = /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/g;
    var error_data = 0;
    //alert($("#agree_span").attr('class'));
    var reg_email  = $.trim($('#reg_email_address').val());
    //var first_name = $.trim(form.reg_firstname.value);
    //var last_name  = $.trim(form.reg_lastname.value);
    var password   = $.trim($('#reg_password').val());
    var	no_password_confirm = false;

    if ($('input[name=no_password_confirm]').length > 0 && $('#confirmpass').length <= 0) {
        var confirmpass = password;
        no_password_confirm = true;
    }else{
        var confirmpass = $.trim($('#confirmpass').val());
    }

    //var customers_country_id = $.trim(form.customers_country_id.value);
    //var agree_email = $.trim(form.agree_email.value);
    var agree_terms = $.trim($('#newsletter').val());

    var email_min_len = 6;
    var firstname_min_len = 1;
    var lastname_min_len = 1;
    var password_min_len = 5;

    /*$('#reg_email_address').parent().next(".reg-notice").html('<span id="reg_email_error"></span>');
    $('#reg_password').parent().next(".reg-notice").html('<span id="reg_password_error"></span>');
    $('#confirmpass').parent().next(".reg-notice").html('<span id="reg_confpwd_error"></span>');
    $('#reg_firstname').parent().next(".reg-notice").html('<span id="reg_fn_error"></span>');
    $('#reg_lastname').parent().next(".reg-notice").html('<span id="reg_ln_error"></span>');*/
    if(reg_email.length == 0 ){
        error_data ++;
        $("#reg_email_error").html(js_lang.TEXT_EMAIL_EMPTY).show();
    }else if(reg_email.length<email_min_len){
        error_data ++;
        $("#reg_email_error").html(js_lang.WrongEmail).show();
    }else if (!isEmail(reg_email) ){
        error_data ++;
        $("#reg_email_error").html(js_lang.RegEmail).show();
    }else{
        $("#reg_email_error").html('').hide();
    }
    /*if(first_name.length<firstname_min_len){
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
    }*/
    
    if(password.length == 0){
        error_data ++;
        $("#reg_password_error").html(js_lang.ENTER_PASSWORD_PROMPT).show();
    }else if(password.length<password_min_len || !password.match(password_pattern)){
        error_data ++;
        $("#reg_password_error").html(js_lang.WrongPassword).show();
    }else{
        $("#reg_password_error").html('').hide();
    }
    if(confirmpass.length == 0 && !no_password_confirm) {
        error_data ++;
        $("#reg_confpwd_error").html(js_lang.TEXT_CONFIRM_PASSWORD).show();
    } else if(!no_password_confirm && confirmpass !== password) {
        // 当网站设置需要验证重复密码时，如果两次密码输入不同，返回错误信息
        error_data ++;
        $("#reg_confpwd_error").html(js_lang.WrongPwdConf).show();
    }else{
        $("#reg_confpwd_error").html('').hide();
    }
    /*if($("#agree_span").attr('class')=="check select"){

    }else{
        error_data = true;
        $("#agree_terms_error").html(js_lang.NotAgreeTC);
    }*/

    if($('#reg_check_code_input').length > 0) {
        var form_code = $('#reg_check_code_input').val().toLowerCase();
        $.ajax({
            url: './checkCode.php',
            type: 'POST',
            async: false,
            data: {code_suffix: 'login', form_code: form_code},
            success: function(data){
                if(data.length > 0){
                    error_data ++;
                    $("#reg_checkcode_error").html(js_lang.TEXT_INPUT_RIGHT_CODE).show();
                    $('.registerCode img').attr('src', './check_code.php?code_suffix=login&' + Math.random());
                }else{
                    $("#reg_checkcode_error").html('').hide();
                }
            }
        });
    }
   // alert(error_data));
    if(error_data){
        loading_hide();
        return false;
    }else{
        loading_show();
        return true;
    }
}

$(function(){
    var url = window.location.href;
    var is_register = url.indexOf('is_register');
    if (is_register > 0) {
        $('.jq_regiser_li').addClass('active');
        $('.jq_signin_li').removeClass('active');
        $('.jq_register_div').show();
        $('.jq_signin_div').hide();
    };

    $('.jq_signin_li').click(function(){
        if ($(this).hasClass('active')) {
            return false;
        }else{
            $(this).addClass('active');
            $('.jq_regiser_li').removeClass('active');
            $('.jq_signin_div').show();
            $('.jq_register_div').hide();
        }
    });

    $('.jq_regiser_li').click(function(){
        if ($(this).hasClass('active')) {
            return false;
        }else{
            $(this).addClass('active');
            $('.jq_signin_li').removeClass('active');
            $('.jq_register_div').show();
            $('.jq_signin_div').hide();
        }
    });

    $('.jq_register_submit').click(function(){
        var url = $(this).data('url');
        // var pass = $()
        var options = {
            type: 'post',
            url: url,
            dataType: 'text',
            beforeSubmit:function(){return check_reg_form()},
            success: function(data){
                //console.log(data);
                if(typeof(JSON)=='undefined'){
                    var returnInfo=eval('('+data+')');
                }else{
                    var returnInfo=JSON.parse(data);
                }
                if(returnInfo['error_info'] != '' && returnInfo['error_info'] != null){
                    $('#reg_email_error').html(returnInfo['error_info']['reg_email_error']).show();
                }else{
                    if (returnInfo['success_info']['register_success_href'] == '') {
                        window.location.reload();
                    }else{
                        window.location.href = returnInfo['success_info']['register_success_href'];
                    }
                }
            }
        };
        $('.registerform').ajaxSubmit(options);
        return false;
    });
});
