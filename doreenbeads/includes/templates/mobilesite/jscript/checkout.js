$(function() {
	var messageTip = $('#ordermessage').attr('origin-tip');
	var message = $('#ordermessage').val();
	var tariff = $('#tariff').val();
	var cookieMessage = getCookie('checkoutMessage');
	var cookieTariff = getCookie('checkoutTariff');
	
	if((messageTip == message || message == '') && cookieMessage != ''){
		$('#ordermessage').val(cookieMessage);
	}
	
	if(tariff == '' && cookieTariff != '' && cookieTariff != 'undefined' ){
		$('#tariff').val(cookieTariff);
	}
	
	var checking = function() {
		//var first_min_len = 1;
		//var last_min_len = 1;
		var street_min_len = 5;
		var city_min_len = 3;
		var state_min_len = 2;
		var postcode_min_len = 3;
		var telephone_min_len = 3;
		var checked = true;
		var rega = /^.{1,}$/;
		var regb = /^.{3,}$/;
		var regc = /^.{5,}$/;
		var telval = $.trim($('.telephone').val());
		var fnameval = $.trim($('.firstname').val());
		var lnameval = $.trim($('.lastname').val());
		var cityval = $.trim($('.citytext').val());
		var tel = $.trim($('.telephone').val());
		var postalval = $.trim($('.posttext').val());
		var streetval = $.trim($('.addresstext').val());
		var suburb    = $.trim($('.suburb').val());
		var zone_id=$('#stateZone').val();
		var state = $("input[name='state']").val();
		var tariff_number = $("#tariff_number").val();
		var email_address = $("#email_address").val();
		var zip_code_rule = $.trim($('#select_coutry_zip_code_info').attr('zip_code_rule'));
		var zip_code_rule_reg = new RegExp(zip_code_rule, 'i');
		var zip_code_example = $.trim($('#select_coutry_zip_code_info').attr('zip_code_example'));
		
		if (!rega.test(fnameval)) {
			$('.firstname').next('span').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_2);
			checked = false;
		}
		if (!rega.test(lnameval)) {
			$('.lastname').next('span').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_2);
			checked = false;
		}
		if(fnameval == lnameval && fnameval != ''){
			$('.lastname').next('span').text(js_lang.ENTRY_FL_NAME_SAME_ERROR);
			checked = false;
		}
		var stateShow =$('#stateZone').hasClass('hiddenField')?true:false;
		if((!regb.test(state)&&stateShow)||(!stateShow&&zone_id=='')){
			checked = false;
			$("#state_error").html(js_lang.CHECKOUT_ADDRESS_BOOK_RIGHT_STATE);
		}else{
			$("#state_error").html('');
		}
		if (!regb.test(cityval)) {
			$('.citytext').next('span').text(js_lang.CHECKOUT_ADDRESS_BOOK_PLEASE_ENTER+' '+city_min_len+' '+js_lang.CHECKOUT_ADDRESS_BOOK_CHARACTERS_AT_LEAST);
			checked = false;
		}
		if (!regb.test(tel)) {
			$('#tell').text(js_lang.CHECKOUT_ADDRESS_BOOK_PLEASE_ENTER+' '+telephone_min_len+' '+js_lang.CHECKOUT_ADDRESS_BOOK_CHARACTERS_AT_LEAST);
			checked = false;
		}
		if (!regb.test(postalval)) {
			$('.posttext').next('span').text(js_lang.CHECKOUT_ADDRESS_BOOK_PLEASE_ENTER+' '+postcode_min_len+' '+js_lang.CHECKOUT_ADDRESS_BOOK_CHARACTERS_AT_LEAST);
			checked = false;
		}else{
			if(zip_code_rule != ''){
				if(!zip_code_rule_reg.test(postalval)){
					checked = false;
					$('.posttext').next('span').text(js_lang.CHECKOUT_ZIP_CODE_ERROR + zip_code_example.replace(',' , ' ' + js_lang.TEXT_OR + ' '));
				}
			}
		}
		if (streetval.length<5) {
			$('#address1').text(js_lang.CHECKOUT_ADDRESS_BOOK_PLEASE_ENTER+' '+street_min_len+' '+js_lang.CHECKOUT_ADDRESS_BOOK_CHARACTERS_AT_LEAST);
			checked = false;
		}
		if (streetval == suburb) {
			$('#suburb_span').text(js_lang.ENTRY_FS_ADDRESS_SAME_ERROR);
			checked = false;
		}
		return checked;
	}
	$('.firstname, .lastname, .citytext, .posttext,#stateZone , .suburb').focus(function(){
		$(this).next('span').html('');
	});
	$('#stateZone').focus(function(){
		$('#state_error').html('');
	});
	
	$('.addresstext').focus(function(){
		$('#address1').text('');
	});
	$('.telephone').focus(function(){
		$('#tell').text('');
	});
	$('.addresscheck').click(function() {
		if (!checking()) {
			return false;
		}else{
			$('form.addressform').submit();
		}
	});

	$('.choose_single').click(function() {
		var ifshow = $('.country_select_drop').css('display');
		current = $("#cSelectId").val();
		if (ifshow == "none") {
			$('.country_select_drop').show();
			$(this).removeClass('choose_single_focus');
			$(this).addClass('choose_single_click');
			$('.country_select_drop .choose_search input').val('');
			$('.country_select_drop ul .country_list_item').css('display', 'block');
			$('.country_select_drop .choose_search input').focus();
			cNum = $('#cSelectId').val();
			if ($("#country_list_" + cNum).hasClass('country_list_item_selected') && !$("#cSelectId").hasClass('selectNeedList')) {

			} else {
				$("#cSelectId").removeClass('selectNeedList');
				$("#country_list_" + cNum).addClass('country_list_item_selected');
				boxTop1 = $("#country_list_1").position().top;
				boxTop2 = $("#country_list_" + cNum).position().top;
				selfHeight = $("#country_list_" + cNum).height() + 8 + 7;
				boxTop = boxTop2 - boxTop1 - 220 + selfHeight;
				$('.country_select_drop ul').scrollTop((boxTop));
			}
		} else {
			$('.country_select_drop').hide();
			$(this).removeClass('choose_single_click');
			$(this).addClass('choose_single_focus');
		}
	})

	$('.country_list_item').hover(function() {
		$(this).addClass('country_list_item_hover');
		$('.country_list_item').removeClass('country_list_item_selected');
	},
	function() {
		$(this).removeClass('country_list_item_hover');
	})
	
	if($('form.addressform').length > 0){
		var formEle=document.getElementsByName('addressform');
		update_zone_c(formEle[0]);
	}
	
	$('#zone_country_id').change(function() {
		var zip_code_rule = $.trim($(this).find("option:selected").attr('zip_code_rule'));
		var zip_code_example = $.trim($(this).find("option:selected").attr('zip_code_example'));

		$('#select_coutry_zip_code_info').attr('zip_code_rule',zip_code_rule);
		$('#select_coutry_zip_code_info').attr('zip_code_example',zip_code_example);
		$('#zip_code_rule').val(zip_code_rule);
		$('#zip_code_example').val(zip_code_example);
		$('#stateZone').val('');
		$('#cSelectId').val($(this).val());
		var formEle=document.getElementsByName('addressform');
		update_zone_c(formEle[0]);
	});
	$('.opentips').click(function(event){
		$('.shiptips').not($(this).next('.shiptips')).hide();
		$(this).next('.shiptips').toggle();
		event.stopPropagation();
	});
	$('.closetips').click(function(event){$('.shiptips').hide();event.stopPropagation();});
	$('.shipping_method_limit_tr').click(function(){
		$(this).children('td').find('.pop_wrap .pop_note_tip').toggle();
	});
	
	$("#add_coupon_code").live('focus',function(){
		var v = $.trim($(this).val());
		if(v == js_lang.TEXT_ENTER_A_COUPON_CODE)
			$(this).val('');
	}).live('blur' , function(){
		var v = $.trim($(this).val());
		if(v == '')
			$(this).val(js_lang.TEXT_ENTER_A_COUPON_CODE);
	});
});
function hideStateField(theForm) {
    theForm.state.disabled = true;
    theForm.state.className = 'hiddenField';
    theForm.zone_id.disabled = false;
    theForm.state.setAttribute('className', 'hiddenField');
    theForm.zone_id.className = 'inputLabel visibleField';
    theForm.zone_id.setAttribute('className', 'visibleField');
}

function saveAddressInfo(dirctHref){
	var messageTip = $('#ordermessage').attr('origin-tip');
	var message = $('#ordermessage').val();
	var tariff = $('#tariff').val();
	
	if(messageTip != message && message != ''){
		setCookie('checkoutMessage', message, 1);
	}
	
	if(tariff != ''){
		setCookie('checkoutTariff', tariff, 1);
	}
	
	window.location.href = dirctHref;
}
function showStateField(theForm) {
    theForm.state.disabled = false;
    theForm.zone_id.className = 'hiddenField';
    theForm.zone_id.disabled = true;
    theForm.state.className = 'inputLabel visibleField';
    theForm.state.setAttribute('className', 'visibleField');   
}

/*function shiptr(){
	$('.shipmethod-list tr').each(function(){ if($(this).index()>4){ $(this).hide();} });
}*/

//bof 排序
$(document).ready(function(){
/*	  shiptr();	
	$('.morecont').click(function(){$('.shipmethod-list tr').show();$(this).hide();$('.lesscont').show();$('.ship-type').show();});
    $('.lesscont').click(function(){shiptr();$(this).hide();$('.morecont').show();$('.ship-type').hide();});*/
    
    $('.shippingcontContent .methodInfo').toggle(function(){
    	var lang = $('html').attr('lang');
    	var orgin_png = '/includes/templates/mobilesite/css/' + lang + '/images/addr_info.png';
    	var click_png = '/includes/templates/mobilesite/css/' + lang + '/images/addr_info_click.png';
    	
    	$('.shippingcont .shippingTipContent').hide();
    	$('.shippingTip .methodInfo').attr({src:orgin_png});
    	$(this).parent().parent('.shippingcontContent').siblings('.shippingTipContent').show();
    	$(this).attr({src:click_png});
    	return false;
    },function(){
    	var lang = $('html').attr('lang');
    	var orgin_png = '/includes/templates/mobilesite/css/' + lang + '/images/addr_info.png';
    	
    	$(this).attr({src:orgin_png});
    	$('.shippingTipContent').hide();
    	return false;
    });
	
    $('.sc_sort').click(function(){
    	var clickFun = function(type, type1){
	        aCont = [];
	        var sortby = type;
	        var sortby1 = type1;
	        fSetDivCont(sortby, sortby1);
	    };
		var fSetDivCont = function(sortby, sortby1){
			$('.shipping_ul li').each(function() {
				var trCont = parseFloat($(this).find('.'+sortby).val() * 10000) + parseFloat($(this).find('.'+sortby1).val());
				aCont.push(trCont);
			});
	    };
		var compare_down = function(a,b){
			return a-b;
	    };
	   
	    var compare_up = function(a,b){
			return b-a;
	    };
	   
	    var fSort = function(compare){
	        aCont.sort(compare);
	    }

	    var limitMethodArr = new Array();	
	    var notShowArr = new Array();    
		var setTrIndex = function(sortby, sortby1){
			obj = [];
	        for(i=0;i<aCont.length;i++){
	            var trCont = aCont[i];
	            $('.shipping_ul li').each(function() {
					var thisText = parseFloat($(this).find('.'+sortby).val() * 10000) + parseFloat($(this).find('.'+sortby1).val());
	                if(thisText == trCont){
	                	if ($(this).hasClass('shipping_method_limit_tr')) {
	                		limitMethodArr.push($(this));
	                	}else if($(this).hasClass('not_show')){
	                		notShowArr.push($(this));
	                	}else{
	                		obj.push($(this));
	                	}
		            };
				});       
	        }
			for(i=0;i<obj.length;i++){
				$('.shipping_ul').append(obj[i]);
			}
			for(z=0;z<notShowArr.length;z++){
				$('.shipping_ul').append(notShowArr[z]);
			}
			for(j=0;j<limitMethodArr.length;j++){
				$('.shipping_ul').append(limitMethodArr[j]);
			}
	    }
    	sort = $(this).val();
    	switch(sort){
			case 'ddown' : type = 'day'; type1 = 'cost'; clickFun(type, type1); fSort(compare_down); setTrIndex(type, type1); break;
			case 'drise' : type = 'day'; type1 = 'cost'; clickFun(type, type1); fSort(compare_up); setTrIndex(type, type1); break;
    		case 'pdown' : type = 'cost'; type1 = 'day'; clickFun(type, type1); fSort(compare_up); setTrIndex(type, type1); break;
    		case 'prise' : type = 'cost'; type1 = 'day'; clickFun(type, type1); fSort(compare_down); setTrIndex(type, type1); break;
    	}    	
    });

	$(document).on('click','#show_all_shipping',function(){
		countClicks(40);
		$('.not_show').removeClass('not_show').show();
		$('.shipping_method_display_tips').remove();
	});
    
	$('.deletebtn').click(function(){
		$('.addressedittips').hide();
		aId = $(this).attr('aId');
		$('#delete-aid').val(aId);
		letDivCenter('.addressedittips');
		$('.addressedittips').show();
	});
    $('.cancelbtn').click(function(){
		$(this).parents('.addressedittips').hide();
	});
	$('.okbtn').click(function(){
		aId = $('#delete-aid').val();
		window.location.href = 'index.php?main_page=checkout&action=delete&aId='+aId;
	});
    /*$('.addresslist input').click(function(){		
    	if(!$(this).parents('.addresslist').hasClass('selected')){
    		$('.checkout-default .button-now').addClass('butiswaiting');
    		$('.addresslist').removeClass('selected');
    		$(this).parents('.addresslist').addClass('selected');
    		$('.addresslist').find('.editor').hide();
    		$('.addresslist').find('.deletebtn').css('display', 'inline-block');
    		$(this).parents('.addresslist').find('.editor').css('display', 'inline-block');
    		$(this).parents('.addresslist').find('.deletebtn').hide();
    		$.post("./ajax_checkout.php", {action:'choose_address', aId:$(this).attr('aId')}, function(data){
    			$('.checkout-default .button-now').removeClass('butiswaiting');
    		});
    	}    	
	});*/
	$('.addresslist .current').click(function(){
		$('.addresslist').removeClass('selected');
		$('.addresslist .deletebtn').show();
		$(this).parents('.addresslist').addClass('selected');
		$(this).parents('.addresslist').find('.deletebtn').hide();
		$.post("./ajax_checkout.php", {action:'choose_address', aId:$(this).attr('aId')}, function(data){
			window.location.href = 'index.php?main_page=checkout#addressAnchor';
		});
	});
	$('.jq_address_line').click(function(){	
    	if(!$(this).children('ins').hasClass('active')){
    		var thisIns = $(this).children('ins');
    		$.post("./ajax_checkout.php", {action:'choose_address', aId:$(this).attr('aId')}, function(data){
    			var returnInfo = process_json(data);
    			if (!returnInfo['error']) {
    				$('.jq_address_line').children('ins').removeClass('active');
	    			thisIns.addClass('active');
    			};	    		
    		});
    	}    	
	});

    $('.shipping_ul li').click(function(){ 
    	var code = $(this).find('.code').val();
		$(this).siblings().children('div').removeClass('shippingcontContentSelect');
		$(this).children('div').addClass('shippingcontContentSelect');
		
		$.post("./ajax_checkout.php", {action:'choose_shipping', code:code}, function(data){
			window.location.href = 'index.php?main_page=checkout#shippingAnchor';
		});
	});

	$('.shipping_ul .notebook').click(function(){
		var lang = $('html').attr('lang');
    	var orgin_png = '/includes/templates/mobilesite/css/' + lang + '/images/addr_info.png';
    	var click_png = '/includes/templates/mobilesite/css/' + lang + '/images/addr_info_click.png';
    	
		if ($(this).hasClass('on')) {
			$(this).attr('src', orgin_png);
			$(this).parent('div').next('div').find('.tip_wrap').hide();
			$(this).removeClass('on');
			return false;
		}else{
			$(this).attr('src', click_png);
			$('.notebook').removeClass('on');
			$('.tip_wrap').hide();
			$(this).parent('div').next('div').find('.tip_wrap').show();
			$(this).addClass('on');
			return false;
		}
	});

    $('.butiswaiting').click(function(){
		return false;
	});
});


//bof shipping comment
$(function(){
	$('#ordermessage').keyup(function(){
		if($(this).val().length>1000){
			$(this).val($(this).val().substr(0,1000));
		}
		$('#message-byte .textWordsLeft').text(1000-$(this).val().length);
	});
	$('#ordermessage').focus(function(){
		var orginStr = $(this).attr('origin-tip');
		var content = $(this).val();
		
		if(orginStr == content){
			$(this).val('');
		}
		
	});
	$('.commentform .jq_comment_submit').click(function(){
		var tariff = $('#tariff').val();
		var tariff_alert = $('#tariff_alert').val();
		var tariff_title = $('#tariff_title').val();
		if($.trim(tariff) == "" && $.trim(tariff_alert) != ""){
			//alert(tariff_alert);
			//console.log($('#tariff_alert').next('p').length);
			if($('#tariff_title').next('br').next('p').length <= 0){
				$('.ordermessage .warning_color').remove();
				$('#tariff_title').next('br').after('<p style="color: #E12020;font-size:12px;">'+tariff_alert+'</p>');
			}			
		}else{
			$('form.commentform').submit();
		}
	});
});
//eof

//bof order review
$(function(){
	$('.viewlessbtn').hide();
	$('.viewallbtn').click(function(){
		$(this).hide();
		$('.viewlessbtn').show();
		$('.alldetails').show();
	});
	$('.viewlessbtn').click(function(){
		$(this).hide();
		$('.viewallbtn').show();
		$('.alldetails').hide();
	})
	$('.itemhide').live('click', function(){
		$(this).parents('.alldetails').hide();
		$('.viewlessbtn').hide();
        $('.viewallbtn').show();
	})
	
	/*$('.alldetails .pagelist a').live('click', function(){
		if(!$(this).hasClass('current')){
			page = $(this).html();
			if(isNaN(page)){
				page = $(this).attr('pageid');
			}
			$.post('./ajax_checkout.php', {action:'split', page: page}, function(data){
				$('.alldetails').html(data);
			});
		}
		return false;
	});*/
	$('.useitbtn').click(function(){
		$.post('ajax_checkout.php',{action:'usecoupon'},function(data){
			$('.totalprice').html(data);
			$('.useitbtn').removeClass('useitbtn').addClass('useitbtn1');
		});
	});
	$("#coupon_select").change(function(){
		coupon_id=$("#coupon_select").find("option:selected").attr('value');		
		use_coupon_select = $("#coupon_select").find("option:selected").text();
		if(coupon_id > 0){
			$.post('./ajax_checkout.php', {couponID:""+coupon_id+"",action:"set_coupon"}, function(data){
				$('.totalprice').html(data);
			});
		}else{
			$.post('./ajax_checkout.php', {couponID:""+coupon_id+"",action:"unset_coupon"}, function(data){
				$('.totalprice').html(data);
			});
		}
	});
	$('.packchoice_tips').click(function(){
		$('.packchoicetips').show();
		t = setTimeout(function(){
			$('.packchoicetips').hide();
		}, 3000);
	});

	$('.jq_show_order_message').click(function(){
		//console.log($(this).parents('p'));
		$(this).parents('p').html(localStorage.getItem('orderCommentMessage'));
	});

	$('.checkout-review > .jq_order_submit').click(function(){
		localStorage.clear();

		var first_name = $("#firstname").val();
		var last_name = $("#lastname").val();
		var street_address = $("#street_address").val();
		var state_zone = $("#stateZone").val();
		var country = $("#zone_country_id").val();
		var city = $("#city").val();
		var postcode = $("#postcode").val();
		var telephone = $("#telephone").val();
		var state = $("#state").val();
		var error_type = '';
		var submiterror = false;

		if(first_name.length < 1 || last_name.length < 1 || street_address.length < 5 || (state.length < 2 && state_zone < 1) || country <= 0 || city.length < 3 || postcode.length < 3 || telephone.length < 3){
			error_type = 'addressAnchor';
			submiterror=true;
		}

		if(!submiterror){
			if($('input[name="packingway"]:checked').length == 0){
				letDivCenter('.packchoice-tips');
				$('.packchoice-tips').show();
				t = setTimeout(function(){
					$('.packchoice-tips').hide();
				}, 3000);
			}else{
				if($(this).hasClass('butiswaiting')){
					return false;
				}
				$(this).removeClass('button-now').addClass('butiswaiting');
				//$(this).addClass('butiswaiting');

				var packingway	  = $('input[name="packingway"]:checked').val();
				var address_id 	  = $('input[name="address_id"]').val();
				var shipping_code = $('input[name="shipping_code"]').val();
				var tariff 		  = $('input[name="tariff"]').val();
				var orderComments  =  $('#ordermessage').val();
				var coupon_customers_id=$('.couponSelect').attr('conpon_id');

				$.post("./ajax_create_order.php", {
					action		: 'create_order',
					address		: address_id,
					shipping	: shipping_code + '_' + shipping_code,
					packingway  : packingway,
					tariff		: tariff,
					orderComments	: orderComments,
					coupon_customers_id:coupon_customers_id
				},function(data){
					if(typeof(JSON)=='undefined'){
						var returnInfo=eval('('+data+')');
					}else{
						var returnInfo=JSON.parse(data);
					}
					switch (returnInfo.err){
						case 'time out': break;
						case 'valid': break;
						case 'diff': alert(js_lang.CHECKOUT_NOT_SAME_INFORMATION); break;
						case 'limit':
						case 'zero':
						case 'already checkout': break;
						default:
					};
					setCookie('checkoutMessage', '', -1);
					setCookie('checkoutTariff', '', -1);
					window.location.href=returnInfo.link;
				});
			}
		}else{
			var link = window.location.href;
			var link_arr = link.split('#');
			link  = link_arr[0];

			$('#addressbox').css('border-color', 'red').css('background', '#feeff7');
			window.location.href = link + '#' + error_type;
		}
	});
	
	/*$('.items .view_details').click(function(){
		console.log($(this).removeClass('view_details').addClass('view_details_up'));
		$(this).removeClass('view_details');
		$(this).children('ins').removeClass('icon_arrow').addClass('icon_arrow_up');
		$('.jq_detail_items').show();
	});*/
	$(document).on('click', '.view_details', function(){
		$(this).removeClass('view_details').addClass('view_details_up');
		$(this).children('ins').removeClass('icon_arrow_up').addClass('icon_arrow');
		$('.jq_detail_items').show();
	})
	$(document).on('click', '.view_details_up', function(){
		$(this).removeClass('view_details_up').addClass('view_details');
		$(this).children('ins').removeClass('icon_arrow').addClass('icon_arrow_up');
		$('.jq_detail_items').hide();
	});
	
	$(document).on('click', '.bottom_arrow ins', function(){
		$('.view_details_up').removeClass('view_details_up').addClass('view_details').children('ins').removeClass('icon_arrow').addClass('icon_arrow_up');
		$('.jq_detail_items').hide();
	});

	$(document).on('click', '.page .ajax_page_link', function(){
		if ($(this).hasClass('page_grey')) {
			return false;
		};
		var nextPage = $(this).attr('page');

		$.post("ajax_checkout.php", {action:'split', nextPage: nextPage}, function(data){ 
			var returnInfo = process_json(data);
			$('.shopcart_ul').html(returnInfo['return_html']);
			$('.jq_detail_items .page').html(returnInfo['return_fenye']);
		});
	}); 
	
	$('.couponAdd').click(function(){
		$(this).hide();
		$('.couponAddInput').show();
	});
	
	$(".coupon_no_use").click(function(){
		var coupon_id=$(this).attr('coupon_id');
		$.post('./ajax_checkout.php', {couponID:""+coupon_id+"",action:"unset_coupon"}, function(data){
			window.location.href = 'index.php?main_page=checkout#couponAnchor';
		});
	});
	
	$(".couponOption").click(function(){
		var coupon_id=$(this).attr('coupon_id');
		$(this).siblings('.couponSel').removeClass('couponSel').addClass('couponAva');
		$(this).removeClass('couponAva').addClass('couponSel');
		
		if(coupon_id > 0){
			$.post('./ajax_checkout.php', {couponID:""+coupon_id+"",action:"set_coupon"}, function(data){
				window.location.href = 'index.php?main_page=checkout#couponAnchor';
			});
		}else{
			$.post('./ajax_checkout.php', {couponID:""+coupon_id+"",action:"unset_coupon"}, function(data){
				window.location.href = 'index.php?main_page=checkout#couponAnchor';
			});
		}
	});

});

//eof

$(function(){
	$('.current').click(function(){
		$(this).parent().find('input[name="address"]').click();
	})
	
	$('#payitems').click(function(){
		$('.packchoicetips').toggle();
	})
});

$(function(){
	$('.addr_choose').click(function(){
		if ($(this).find('ins').hasClass('up')) {
			$(this).find('ins').removeClass('up').addClass('down');
			$('.address').show();
		}else{
			$(this).find('ins').removeClass('down').addClass('up');
			$('.address').hide();
		}
		
	});
});

function doAddCoupon(){
	var code = $.trim($("#add_coupon_code").val());

	$.post('./ajax_checkout.php',{action:'add_coupon',code:code}, function(data){
		var returnInfo = process_json(data);
		$("#add_coupon_tip").html("");
		
		if(returnInfo.is_error){
			if(returnInfo.link != ''){
				window.location.href=returnInfo.link;
			}
			$("#add_coupon_tip").html(returnInfo.error_info);
		}else{
			if($(".couponSelect").length > 0){
				$(".couponSelect").remove();
			}
			
			if($('.no_use_coupon').length > 0){ 
				$('.no_use_coupon').remove();
			}
			
			$(".couponAddInput").after(returnInfo.coupon_display);
			$('.bottom_total').html(returnInfo.order_info);
			$('#add_coupon_tip').html(returnInfo.success_info);
                        
                        //使用当前添加的coupon
                        $.post('ajax_checkout.php',{action:'set_coupon',couponID:returnInfo.coupon_id},function(data){
                            window.location.href = location.href;
                        },'json');
		}
	});

	return false;
}