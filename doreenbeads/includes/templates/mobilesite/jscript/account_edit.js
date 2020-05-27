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
			});

		$('.country_list_item').hover(function(){
			$(this).addClass('country_list_item_hover');
			$('.country_list_item').removeClass('country_list_item_selected');
			},function(){
				$(this).removeClass('country_list_item_hover');
				});	

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
			});	

		$('.choose_single').blur(function(){
			$(this).removeClass('choose_single_focus');
			});

		$('.choose_search input').keyup(function(){
		    inputVal=$(this).val();
		    inputVals=inputVal.replace(/^\s*|\s*$/g, "");
			if(inputVals!=''){
					$('.country_select_drop ul').scrollTop(0);
					$("#cSelectId").addClass('selectNeedList');
					$(".country_select_drop ul .country_list_item").each(function(){
						cTextVal=$(this).text();
						re = new RegExp("^"+inputVals,'i');  
						re2= new RegExp("\\s+"+inputVals,'i');
						if(cTextVal.match(re)||cTextVal.match(re2)){
									$(this).css('display','block');
								}else{
									$(this).css('display','none');
									}
						});
				}else{
					$('.country_select_drop ul .country_list_item').css('display','block');
					}
			});
				
		});	
}


function check_account_edit_form(form_name){
	form = form_name;
	error_data=false;
	
	var url_reg=/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/;
	var reg11=/^.{1,}$/;
	var first_name = $.trim($('#firstname').val());
	var last_name = $.trim($('#lastname').val());
	var dob_year = $.trim($('.sel_year').val());
	var dob_month = $.trim($('.sel_month').val());
	var dob_day = $.trim($('.sel_day').val());
	var customers_business_web=$.trim($('#customers_business_web').val());	
	var myDate = new Date(); 
	var date_now = myDate.toLocaleDateString();
	if( !(dob_year <= 0 && dob_month <= 0 && dob_day <= 0) ){
	    if ( !(dob_year > 0 && dob_month > 0 && dob_day > 0) ) {
	    	$('#birth_error').html(js_lang.TEXT_ENTER_BIRTHDAY_ERROR);
	      	error_data = true;
	    }else if( parseInt(Date.parse(dob_year+"/"+dob_month+"/"+dob_day)) > parseInt(Date.parse(date_now)) ){
	    	$('#birth_error').html(js_lang.TEXT_ENTER_BIRTHDAY_OVER_DATE);
	      	error_data = true;
		}else{
			$('#birth_error').html('');
		}   
	}
	
	
	if(!reg11.test(first_name)){
		error_data = true;
		$("#fn_error").html(js_lang.WrongFirstName);
	}else{
		$("#fn_error").html('');
	}
	if(!reg11.test(last_name)){
		error_data = true;
		$("#ln_error").html(js_lang.WrongLastName);
	}else{
		$("#ln_error").html("");
	}
	if(!url_reg.test(customers_business_web) && customers_business_web!=''){
		error_data = true;
		$("#web_error").html(js_lang.WEBSITE_ADDRESS_FORMAT);
	}else{
		$("#web_error").html('');
	}

	if(error_data==false){
		return true;
	}
	return false;
}
function  change_password(form_name){
	form = form_name;
	error_data=false;

	var reg11=/^.{5,}$/;
	var password_current = $.trim(form.password_current.value);
	var password_new 	 = $.trim(form.password_new.value);
	var password_confirmation = $.trim(form.password_confirmation.value);
	
	if(!reg11.test(password_current)){
		error_data = true;
		$("#password_current_span").html(js_lang.WrongPassword);
	}else{
		$("#password_current_span").html('');
	}
	if(!reg11.test(password_new)){
		error_data = true;
		$("#password_new_span").html(js_lang.WrongPassword);
	}else{
		$("#password_new_span").html('');
	}
	if(password_confirmation!==password_new){
		error_data = true;
		$("#password_conf_span").html(js_lang.WrongPwdConf);
	}else{
		$("#password_conf_span").html('');
	}
	if(error_data==false){
		return true;
	}
	return false;
}
function isEmail(str){
	strRegex = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}
function change_email(form_name){
	form = form_name;
	error_data=false;
	var email_address = $.trim(form.email_address.value);
	if (!isEmail(email_address)){
		error_data =true;
		$("#email_error").html(js_lang.errWrongEmail);
	}else{
		$("#email_error").html('');
	}
	if(error_data==false){
		return true;
	}
	return false;
}
	
$(document).ready(function(){
	setTimeout('hidden()',5000);	
});

function hidden(){
	$(".messageStackSuccess").css('display','none');
}

// 生日下拉菜单插件
(function($){ 
$.extend({ 
ms_DatePicker: function (options) { 
   var defaults = { 
         YearSelector: "#sel_year", 
         MonthSelector: "#sel_month", 
         DaySelector: "#sel_day", 
         FirstYearText: js_lang.TEXT_LANG_YEAR, 
         FirstMonthText: js_lang.TEXT_LANG_MONTH, 
         FirstDayText: js_lang.TEXT_LANG_DAY, 
         FirstValue: 0 
   }; 
   var opts = $.extend({}, defaults, options); 
   var $YearSelector = $(opts.YearSelector); 
   var $MonthSelector = $(opts.MonthSelector); 
   var $DaySelector = $(opts.DaySelector); 
   var FirstYearText = opts.FirstYearText; 
   var FirstMonthText = opts.FirstMonthText; 
   var FirstDayText = opts.FirstDayText; 
   var FirstValue = opts.FirstValue; 
 
   // 初始化 
   var str_year = "<option value=\"" + FirstValue + "\">"+FirstYearText+"</option>"; 
   var str_month = "<option value=\"" + FirstValue + "\">"+FirstMonthText+"</option>"; 
   var str_day = "<option value=\"" + FirstValue + "\">"+FirstDayText+"</option>"; 
   $YearSelector.html(str_year); 
   $MonthSelector.html(str_month); 
   $DaySelector.html(str_day); 
 
   // 年份列表 
   var yearNow = new Date().getFullYear(); 
   var yearSel = $YearSelector.attr("rel"); 
   for (var i = 1900; i <= yearNow; i++) { 
        var sed = yearSel==i?"selected":""; 
        var yearStr = "<option value=\"" + i + "\" " + sed+">"+i+"</option>"; 
        $YearSelector.append(yearStr); 
   } 
 
    // 月份列表 
    var monthSel = $MonthSelector.attr("rel"); 
    for (var i = 1; i <= 12; i++) { 
        var sed = monthSel==i?"selected":""; 
        var monthStr = "<option value=\"" + i + "\" "+sed+">"+i+"</option>"; 
        $MonthSelector.append(monthStr); 
    } 
 
    // 日列表(仅当选择了年月) 
    function BuildDay() { 
        if ($YearSelector.val() == 0 || $MonthSelector.val() == 0) { 
            // 未选择年份或者月份 
            //$DaySelector.html(str); 
        } else { 
            $DaySelector.html(str_day); 
            var year = parseInt($YearSelector.val()); 
            var month = parseInt($MonthSelector.val()); 
            var dayCount = 0; 
            switch (month) { 
                 case 1: 
                 case 3: 
                 case 5: 
                 case 7: 
                 case 8: 
                 case 10: 
                 case 12: 
                      dayCount = 31; 
                      break; 
                 case 4: 
                 case 6: 
                 case 9: 
                 case 11: 
                      dayCount = 30; 
                      break; 
                 case 2: 
                      dayCount = 28; 
                      if ((year % 4 == 0) && (year % 100 != 0) || (year % 400 == 0)) { 
                          dayCount = 29; 
                      } 
                      break; 
                 default: 
                      break; 
            } 
            
            var daySel = $DaySelector.attr("rel");
            if ($DaySelector.val() != "" && $DaySelector.val() != "0") {daySel = $DaySelector.val()};
            for (var i = 1; i <= dayCount; i++) { 
                var sed = daySel==i?"selected":""; 
                var dayStr = "<option value=\"" + i + "\" "+sed+">" + i + "</option>"; 
                $DaySelector.append(dayStr); 
             } 
         } 
      } 
      $MonthSelector.change(function () { 
         BuildDay(); 
      }); 
      $YearSelector.change(function () { 
         BuildDay(); 
      }); 
      if($DaySelector.attr("rel")!=""){ 
         BuildDay(); 
      } 
   } // End ms_DatePicker 
}); 
})(jQuery); 

$(function () { 
    $.ms_DatePicker({ 
            YearSelector: ".sel_year", 
            MonthSelector: ".sel_month", 
            DaySelector: ".sel_day" 
    }); 
});

$(function(){
	$('#infosubmit').click(function(){		
		
			
	});
});