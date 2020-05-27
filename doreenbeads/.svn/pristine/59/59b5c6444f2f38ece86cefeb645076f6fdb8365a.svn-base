$(function(){
	$('.image_down_arrow').click(function(){
          $('.price_sub').show();
          $('.image_up_arrow').show();
          $('.image_down_arrow').hide();
	});
	$('.image_up_arrow').click(function(){
          $('.price_sub').hide();
          $('.image_down_arrow').show();
          $('.image_up_arrow').hide();
	});
	$('#refine-bybtn').click(function(){
		var dheight = $(document).height();
		$('.windowbg').css('height',dheight);
		$('.windowbg').show('fast');
		$('.refine-right').show('fast');	
	});

    $(window).scroll(function(){ 
    	var wheight = $(window).height(); 
    	$('.refine-arrow').css('top',((wheight-30)/2)+'px'); 
    	$('.refine-arrow').css('position','fixed'); 
    });
	
	$("div.languagues ul li a").live('click',function(event) {
		event.preventDefault();
		var code = $(this).data("code");
		var urlHref = $(this).attr("href");
		addCookie('zenchange_language', code, '5');
		location.href = urlHref;
	});
	
    $('.refine-tit').click(function(){
			var ch = $('.refine-right ul.current').height();
			if($(this).hasClass('choose')){
				$(this).removeClass('choose');
				$(this).next('ul').slideUp('200').removeClass('current');
		     }else{
			    $('.refine-tit.choose').removeClass('choose');
			    $(this).addClass('choose');
				$('.refine-right ul.current').slideUp('200').removeClass('current');
				$(this).next('ul').slideDown('200').addClass('current');				
			 }
			
			var topoffset = $(this).offset().top;
			if(ch == ''){
				$(window).scrollTop(topoffset);
			}else if(ch > topoffset){
				$(window).scrollTop(topoffset);
				}else{
					$(window).scrollTop(topoffset-ch);
				}
       	});
	$('.refine-arrow').click(function(){
		$('.windowbg').hide('fast');
		$('.refine-right').hide('fast');
	});	
	$('.windowbg').click(function(){
		$('.windowbg').hide();
		$('.refine-right').hide();
		$('.mainmenu').hide();
		});
				
    $('.refine-right ul li.more').click(function(){
		$(this).parents('ul').children('.morelist').slideDown();
	    $(this).hide();
		$(this).next('li.less').show();
	});	
	$('.refine-right ul li.less').click(function(){
		var settop = $(this).parent('ul').prev('.choose').offset().top; 
		$(this).parent('ul').children('.morelist').slideUp(); 
		$(this).hide(); 
		$(this).prev('li.more').show(); 
		$(window).scrollTop(settop);
	});	
	
	$('.menushow').click(function() {
		$('.windowbg').height($(document).height());
		$('.windowbg').show();
		$('.mainmenu').show();
	});
	$('.menuclose').click(function() {
		$('.windowbg').hide();
		$('.mainmenu').hide();
	});
	
	$('.usermenulist p').click(function(){
		//$('.viplevel').hide();
		if($(this).hasClass('now')){
			$(this).next('ul').slideUp('500');
			$(this).removeClass('now');
		}else{
			$('.usermenulist p.now').removeClass('now');
		    $('.usermenulist p').next('ul').slideUp('500');
			$(this).next('ul').slideDown('500');	
		    $(this).addClass('now');
		}			
	 });

	$('#searchbtn').click(function(){
		if($(this).attr('class')=='back-button1'){
			    $(this).attr('class','back-button2');
			}else{
				$(this).attr('class','back-button1')	
				}
		$('.Order').toggle();
	});
	
	$('.head_menu').click(function(){
		var divCategorymenuObj = $('#categorymenu');
		if(!divCategorymenuObj) return;
		
		if(divCategorymenuObj.is(':visible'))
		{
			divCategorymenuObj.hide();
		}
		else{
			divCategorymenuObj.show();
		} 

		return false;
	}); 

	//	1. back to top
	var $wrapPage = $(".wrap-page");
	$(".back-to-top").click(function(){
		//$("body,html").animate({scrollTop:0}, 500);
		$wrapPage.animate({scrollTop:0}, 500);
	});
	var backTopLeft = function(){
		//if($(document).scrollTop() === 0){
		if($wrapPage.scrollTop() === 0){
			$(".back-to-top").hide(200);
		}else{
			$(".back-to-top").show(200);
//			$("#headSearchDiv").hide(300);
		}
	}
	backTopLeft();
	//$(window).resize(backTopLeft);
	//$(window).scroll(backTopLeft);
	$wrapPage.resize(backTopLeft);
	$wrapPage.scroll(backTopLeft);

	//	2. subscribe
	$('.subscribesubmit').click(function(){
		var o = $('#subscribeinput');
		var email = $.trim(o.val());
		var resetPlaceholder = function(){
			o.attr("placeholder", js_lang.TEXT_SUBSCRIBE_FOR).removeClass("tip");
		}

		o.removeClass("fblack");

		if(email.length == 0 || email == js_lang.TEXT_SUBSCRIBE_FOR){
			o.val("").attr("placeholder", js_lang.TEXT_ENTER_YOUR_EMAIL_ADDRESS).addClass("tip");
			o.one("focus", function(){resetPlaceholder()});
		}else if(!isEmail(email)){
			o.val("").attr("placeholder", js_lang.TEXT_EMAIL_FORMAT).addClass("tip");
			o.one("focus", function(){resetPlaceholder()});
		}else{
			$.post('ajax_login.php', {action: 'subscribe', email_address: email}, function(data) {
				var return_info = process_json(data);
				if (!return_info['error']) {
					o.val("").attr("placeholder", js_lang.TEXT_SUBSCRIBE_SUCCESS).addClass("fblack")
				}else{
					o.val("").attr("placeholder", return_info['error_message']).addClass("fblack");
				}
				o.one("focus", function(){o.removeClass("fblack");});
			});
		}
	});
	$('#subscribeinput').on("focus", function(){	//	输入情况下加大z-index层级
		$(this).parent().addClass("zindex");
	}).on("blur", function(){
		$(this).parent().removeClass("zindex");
	});

	/*$('#subscribeSubmitForm').submit(function() {
		var o = $('#subscribeinput');
		var email = $.trim(o.val());
		var resetPlaceholder = function(){
			o.attr("placeholder", js_lang.TEXT_SUBSCRIBE_FOR).removeClass("tip");
		}

		o.removeClass("fblack");

		if(email.length == 0 || email == js_lang.TEXT_SUBSCRIBE_FOR){
			o.val("").attr("placeholder", js_lang.TEXT_ENTER_YOUR_EMAIL_ADDRESS).addClass("tip");
			o.one("focus", function(){resetPlaceholder()});
		}else if(!isEmail(email)){
			o.val("").attr("placeholder", js_lang.TEXT_EMAIL_FORMAT).addClass("tip");
			//o.one("focus", function(){resetPlaceholder()});
		}else{
		  	$j(this).ajaxSubmit({
				type: 'post',
				url: 'ajax_login.php',
				dataType: 'text',
				success: function(data){
					//console.log(data);
					o.val("").attr("placeholder", js_lang.TEXT_SUBSCRIBE_SUCCESS).addClass("fblack");
					o.one("focus", function(){o.removeClass("fblack");});
				}
			});
			return false;
		}
	});*/


	//	3. search
	$('.toggle_search').click(function(){
		$("#headSearchDiv").toggle(300);
		return false;
	});
	$('#btnSearch').click(function(){
		var txtSearchObj = $('#inputString');
		var defaultVal = $('#inputString').attr('placeholder');
		var txtSearchVal = $.trim(txtSearchObj.val());

		txtSearchVal = txtSearchVal.replace(/(^\s*)|(\s*$)/g, "");
    	txtSearchVal = txtSearchVal.replace(/&/g, "");
    	txtSearchObj.val(txtSearchVal);

		if(txtSearchVal.length > 0 && txtSearchVal != defaultVal)
		{ 
			$("[name='quick_find']").submit();
		}
		return false;
	});
	
	//	4. refine by
	$(".btn_propery_refine_by").click(function(){
		var parentObj = $(this).parent(".button");
		var dlObj = parentObj.prev("dl"); 
		var moreDtObj = $("dd.property_more",dlObj);
		
		if($(this).attr('data-text-current')=='m')
		{
			moreDtObj.show();
			$(this).attr('data-text-current','l');
			$(this).text($(this).attr('data-text-less'));
		}
		else
		{
			moreDtObj.hide();
			$(this).attr('data-text-current','m');
			$(this).text($(this).attr('data-text-more'));
		}
		
		//parentObj.hide();
		
		return false;
	});
	$("#move_sidebar .btn_propery_apply").click(function(){
		var base_url = $("#title_tab_refine_by .btn_property_clear_all").attr('href');
		var checked_property_objs = $("#title_tab_refine_by :checkbox[name='property_value']:checked");
		var property_qs = "";
		var checked_property_count = checked_property_objs.size();
		
		if(checked_property_count > 0 )
		{
			property_qs = checked_property_objs.map(function(index){
				  return 'p'+(index+1).toString()+'='+$(this).val();
			}).get().join("&");
		}
		
		if(property_qs.length >0)
		{
			if(base_url.indexOf("?") <= 0)
			{
				base_url +="?" + property_qs;
			}else
			{
				base_url +="&" + property_qs;
			}
			
			base_url += '&pcount='+checked_property_count.toString();
			
			base_url = base_url.replace(/&?page=\d+/gi,'');
		}

		window.location.href = base_url;
		return false;
	});
	$('.title_tab [data-toggle="tab"]').click(function(){
		var tar = $(this).data("target"),
			$btn = $("#move_sidebar .btn_propery_apply");

		if(tar == "#title_tab_refine_by"){
			$btn.show();
		}else{
			$btn.hide();
		}
	});

	//	7. show sidebar
	var $move_sidebar = $("#move_sidebar"),
		$move_body = $("#move_body"),
		$header = $(".header");
	var //move_body_left = $move_body.css("left"),
		//move_body_top = $move_body.css("top"),
		//move_sidebar_position = $move_sidebar.css("position"),
		//move_body_postion = $move_body.css("position"),
		wh = $(window).height();
	$move_sidebar.css({"height":wh});
	$("body").hammer().on('swipeleft', function(){
		$move_body.removeClass("showNav").addClass("closeNav");
		$move_sidebar.removeClass("showNav").addClass("closeNav");
	}).on('swiperight', function(){
		$move_body.removeClass("closeNav").addClass("showNav");
		$move_sidebar.removeClass("closeNav").addClass("showNav");
		$("#headSearchDiv").hide();
		if($header.css("left") == "0px" || $header.css("left") == "auto"){
			$move_sidebar.css("z-index", 10000);
		}
	});
	$("#headShowSidebar").on("touchstart", function(){
		if(!$move_body.hasClass("showNav")){
			$move_body.removeClass("closeNav").addClass("showNav");
			$move_sidebar.removeClass("closeNav").addClass("showNav");
			if($header.css("left") == "0px" || $header.css("left") == "auto"){
				$move_sidebar.css("z-index", 10000);
			}
		}else{
			$move_body.removeClass("showNav").addClass("closeNav");
			$move_sidebar.removeClass("showNav").addClass("closeNav");
		}
		$("#headSearchDiv").hide();

		return false;
	});

	//	5. change currency
	$("#footChangeCuurency").on("click", function(){
		$move_body.hide();
		$("#popupChangeCurrency").show();
		$('.order_header .menu_subnav').hide();
		$('.windowbodyp').remove();
		$("body,html").animate({scrollTop:0}, 500);
	});
	$("#popupChangeCurrency #closeChangeCurrency").on("click", function(){
		$("#popupChangeCurrency").hide();
		$move_body.show();
	});

	//	5.5 change language
	$("#footChangeLanguage").on("click", function(){
		$move_body.hide();
		$("#popupChangeLanguage").show();
		$('.order_header .menu_subnav').hide();
		$('.windowbodyp').remove();
		$("body,html").animate({scrollTop:0}, 500);
	});
	$("#popupChangeLanguage #closeChangeLanguage").on("click", function(){
		$("#popupChangeLanguage").hide();
		$move_body.show();
	});

	//	6. change sort by
	$("#btnChangeSortBy").on("click", function(){
		$move_body.hide();
		$("#popupChangeSortBy").show();
		$("body,html").animate({scrollTop:0}, 500);
		$("#popupChangeSortBy #closeChangeSortBy").one("click", function(){
			$("#popupChangeSortBy").hide();
			$move_body.show();
		});
	});

	$("#btnChangeFilterBy").on("click", function(){
		$move_body.hide();
		$("#popupChangeFilterBy").show();
		$("body,html").animate({scrollTop:0}, 500);
		$("#popupChangeFilterBy #closeChangFilterBy").one("click", function(){
			$("#popupChangeFilterBy").hide();
			$move_body.show();
		});
	});

	//	8. addto cart
	var $popAddtoCart = $("#proddetailAddtoCart");
	if($popAddtoCart.length <= 0) $popAddtoCart = $("#popupAddtoCart");
	$(".btnProductListBuy").click(function(){	//	open pop
		var $this = $(this),
			pId = $this.data("id"),
			oldQty = $this.data("oldqty"),
			$close = $("#closeAddtoCart"),
			ww = $(window).width(),
			pw = $popAddtoCart.width();

		if(oldQty <= 1){
			$popAddtoCart.find("#minusAddtoCart").addClass("grey");
		}else{
			$popAddtoCart.find("#minusAddtoCart").removeClass("grey");
		}
		$popAddtoCart.find("#iptAddtoCart").val(oldQty);
		$popAddtoCart.find("#btnAddtoCart").data("pid", pId);
		$popAddtoCart.find("#tipsAddtoCart").html("");
		$.post('addcart.php', {'ac':'loadprice', 'productId':pId}, function(data){	//	load price
			var arr = data.split("|||");
			$popAddtoCart.find("#plusAddtoCart").data("max", arr[0]);
			$popAddtoCart.find("#priceAddtoCart").html(arr[1]);
			if(arr[2] == '1') {
				$popAddtoCart.find("#availableAddtoCart").html(arr[3]).show();$popAddtoCart.find("#btnAddtoCart").html(js_lang.TEXT_BACKORDER);
			}else{
				$popAddtoCart.find("#availableAddtoCart").hide();$popAddtoCart.find("#btnAddtoCart").html(js_lang.TEXT_ADD_TO_CART);
			}
		});
		$popAddtoCart.modal("show");
		/*
		$popAddtoCart.show().css({"position":"fixed", "top":"70px", "left":((ww-pw)/2)+"px"});
		$close.one("click", function(){
			$popAddtoCart.hide();
		});
		*/
	});
	$($popAddtoCart).on("click", "#minusAddtoCart", function(){	//	minus
		var $ipt = $popAddtoCart.find("#iptAddtoCart"),
			v = parseInt($.trim($ipt.val()));
		if(v == '' || isNaN(v)){
			v = 1;
			$ipt.val(v);
		}
		if(v <= 1){
			$(this).addClass("grey");
			return false;
		}else{
			$(this).removeClass("grey");
		}
		if(v <= 2) $(this).addClass("grey");
		$ipt.val(v-1);
	});
	$($popAddtoCart).on("click", "#plusAddtoCart", function(){	//	plus
		var $ipt = $popAddtoCart.find("#iptAddtoCart"),
			max = parseInt($(this).data("max")),
			v = parseInt($.trim($ipt.val()));
		if(v == '' || isNaN(v)){
			v = 1;
			$ipt.val(v);
		}
		if(max > 0 && v >= max) return false;
		if(v+1 >= 1){
			$popAddtoCart.find("#minusAddtoCart").removeClass("grey");
		}
		$ipt.val(v+1);
	});
	$($popAddtoCart).on("keydown", "#iptAddtoCart", function(e){	//	input
		if ($.browser.msie) {
			var key = event.keyCode;			
        } else {
			var key = e.which;
        }
		if (key == 8 || (key >= 35 && key <= 39 && key != 38) || (key >= 46 && key <= 57 && key != 47) || (key >= 96 && key <= 105)) {
			return true; 
		} else {
			return false; 
		}
	}).on("focus", "#iptAddtoCart", function(){
		this.style.imeMode='disabled';
	});
	$($popAddtoCart).on("click", "#btnAddtoCart", function(){	//	add button
		var $this = $(this),
			pid = $this.data("pid");

		if(typeof(t) == 'number') clearTimeout(t);
		var num = parseFloat($popAddtoCart.find("#iptAddtoCart").val());
		$popAddtoCart.find("#tipsAddtoCart").html("");
		if(!isNaN(num) && num > 0){
			$.post("addcart.php", {productid: ""+pid+"",number: ""+num+""}, function(data){
				if(data.length > 0) {
					var datearr = new Array();
					datearr = data.split("|");
					if(datearr[2] != ''){
						$popAddtoCart.find("#tipsAddtoCart").html(datearr[2]);
						if($($popAddtoCart).attr("id") == "proddetailAddtoCart"){
							$this.html(""+js_lang.TextUpdate+"");
							//t = setTimeout(function(){$this.removeClass("btn_success").addClass("btn_orange").html(""+js_lang.TextUpdate+"");},3000);
						}else{
							t = setTimeout(function(){$($popAddtoCart).modal("hide");},5000);
							$("#btnProductListBuy_"+pid).data("oldqty", datearr[1]).find("ins").removeClass("btn_cart");
							t = setTimeout(function(){$("#btnProductListBuy_"+pid).removeClass("btn_success").addClass("btn_orange").find("ins").addClass("btn_update");},300);
						}
					}else if(datearr[1] > 0){ 
						if($($popAddtoCart).attr("id") == "proddetailAddtoCart"){
							$this.html(""+js_lang.TextUpdate+"");
							//t = setTimeout(function(){$this.removeClass("btn_success").addClass("btn_orange").html(""+js_lang.TextUpdate+"");},3000);
						}else{
							$($popAddtoCart).modal("hide");
							$("#btnProductListBuy_"+pid).data("oldqty", datearr[1]).find("ins").removeClass("btn_cart");
							t = setTimeout(function(){$("#btnProductListBuy_"+pid).removeClass("btn_success").addClass("btn_orange").find("ins").addClass("btn_update");},300);
						}
					}
				}
			});
		}
	});

	//	9. 打开modal后，调整位置
	$("div.popup_shop").each(function () {
		var $this = $(this);
		$this.on('shown',function(){
			var s = parseInt($(window).scrollTop());
			var m = s+80;			//80为原样式中的top
			$this.css({'top':m});				
		});
	});

	//	10. add to wishlist
	$(".btnProductWishlist").on("click", function(){
		var $this = $(this),
			pid = $this.data("id"),
			number = 1,
			langs = $("#c_lan").val(),
			language_addWishlist_url = '';

		switch(langs){
			case 'english': language_addWishlist_url = '/en'; break;
			case 'german': language_addWishlist_url = '/de'; break;           
			case 'russian': language_addWishlist_url = '/ru'; break; 
			case 'french': language_addWishlist_url = '/fr'; break;
			default : language_addWishlist_url = '/en';
		}

		$.post("."+language_addWishlist_url+"/addwishlist.php", {productid: ""+pid+"",number: ""+number+""}, function(data){
			if(data.length >0) {
				var datearr = new Array();
				datearr = data.split("|");
				if(parseInt(datearr[0]) == 1){ //not login
					window.location.href = "index.php?main_page=login";
				}else{
					$this.removeClass("btn_wishlist").addClass("btn_wishlist_red");
				}				
			}
		});
	});
	//商品详情页添加购物车
	$(".btnProductinfoWishlist").on("click", function(){
		var $this = $(this),
			pid = $this.data("id"),
			number = 1,
			langs = $("#c_lan").val(),
			language_addWishlist_url = '';

		switch(langs){
			case 'english': language_addWishlist_url = '/en'; break;
			case 'german': language_addWishlist_url = '/de'; break;           
			case 'russian': language_addWishlist_url = '/ru'; break; 
			case 'french': language_addWishlist_url = '/fr'; break;
			default : language_addWishlist_url = '/en';
		}

		$.post("."+language_addWishlist_url+"/addwishlist.php", {productid: ""+pid+"",number: ""+number+""}, function(data){
			if(data.length >0) {
				var datearr = new Array();
				datearr = data.split("|");
				if(parseInt(datearr[0]) == 1){ //not login
					window.location.href = "index.php?main_page=login";
				}else{
					$this.unbind("click");
					$this.removeClass("btnProductinfoWishlist").addClass("btn_success").html(""+js_lang.TextSuccess+"");
					t = setTimeout(function(){$this.removeClass("btn_success").addClass("btnProductWishlist_success").html("<strong></strong>"+js_lang.TEXT_CART_MOVE_TO_WISHLIST+"");},3000);
					
				}				
			}
		});
	});

	$(".jq_related_item").find("a").live("click", function() {
		var type = 20;
		var keyword = $(this).text();
		addSearchKeywordStatistic(type, keyword);
	});

	$(".jq_cart_invalid_notebook").click(function(){
		var toggle = $(this).data("toggle");
		$(this).toggleClass("current");
		if(typeof(toggle) != "undefined") {
			$(".jq_cart_invalid_tip_msg_" + toggle).toggle();
		}
		
	});
	generatepopup();
});

/**
 * 添加搜索关键词统计信息
 * @param string type 搜索位置(10:下拉提示点击、Related点击)
 * @param string keyword 搜索词
 */
function addSearchKeywordStatistic(type, keyword) {
	$.ajax({
		'url':'/ajax/ajax_search_keyword_statistic.php',
		'dataType':'json',
		'type':'post',
		'data':{'type':type, 'keyword':keyword},
		'success':function(responseJSON){}
	});
}


function clearTips(id,words){
	if(id.value==words){
		id.value='';
	}
}
function onkeynone(thisValue,words) {
	if(thisValue==''){
		$('#inputString').val(words);
	}else{
		$('#inputString').val(thisValue);
	}
	setTimeout("$('#suggestions').hide();", 200);
}

function generatepopup(){
	if (getCookie($('.head-notice').attr('id'))) {$('.head-notice').hide()};
}

function noteclose(){
	if($('.head-notice').attr('id')){
		$('.head-notice').hide();
		setCookie($('.head-notice').attr('id'),"true",7);
	}
}

function setCookie(c_name,value,expiredays)
{
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}
function getCookie(c_name)
{
	if (document.cookie.length>0)
		{
			c_start=document.cookie.indexOf(c_name + "=")
		if (c_start!=-1)
	{ 
		c_start=c_start + c_name.length+1 
		c_end=document.cookie.indexOf(";",c_start)
		if (c_end==-1) c_end=document.cookie.length
		return unescape(document.cookie.substring(c_start,c_end))
		} 
		}
	return ""
}

function letDivCenter(divName){
	var top = ($(window).height() - $(divName).height())/2;
	var left = ($(window).width() - $(divName).width())/2;
	var scrollTop = $(document).scrollTop();
	var scrollLeft = $(document).scrollLeft();
//	alert(top+"|"+left+"|"+scrollTop+"|"+scrollLeft);
	$(divName).css( { position : 'absolute', 'top' : top + scrollTop, left : left + scrollLeft } ).show();
}

/*function isEmail(value){
	var reg_email = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
	if(!reg_email.match($.trim(value))){
		return false;
	}
	return true;
}*/

function isEmail(value){
	var reg_email = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
	if(!$.trim(value).match(reg_email)){
		return false;
	}
	return true;
}

function process_json(data){
//	if(typeof(JSON)=='undefined'){
		var returnInfo=eval('('+data+')');
//	}else{
//		var returnInfo=JSON.parse(data);	
//	}
	return returnInfo;
}

$(document).ready(function(){
	document.onclick = function (event){
	if($(".country_select_drop").css('display')=='block'){
		var e = event || window.event;  
		var elem = e.srcElement||e.target;  
		while(elem){
			if(elem.id == "curSelectorDt"||elem.id == "country_choose"){
				return true;
			}  
			elem = elem.parentNode; 
		}  
		$(".country_select_drop").hide();
		$('.choose_single').removeClass('choose_single_click');
	}};	
	
	$('.addcart').click(function(){
		
		if(typeof(t) == 'number') clearTimeout(t);
		_this = $(this);
		pid = _this.siblings('.product_id').val();
		num = parseFloat($('#pid_' + pid).val());
		if(!isNaN(num) && num > 0){
			$.post("addcart.php", {productid: ""+pid+"",number: ""+num+""}, function(data){
				if(data.length > 0) {
					var datearr = new Array();
					datearr = data.split("|");
					if(datearr[2] != ''){
						$(".addsuccess-tip").html(datearr[2]);
						letDivCenter('.addsuccess-content');
						$('.addsuccess-content').show();
						t = setTimeout(function(){$('.addsuccess-content').hide();},3000);
						$("#pid_"+ pid).val(datearr[1]);
					}else if(datearr[1] > 0){
						_this.attr('class', 'updatecart').html(js_lang.TEXT_UPDATE);
						$('.shopcart').attr('class', 'shopcart1');
						$(".addsuccess-tip").html(js_lang.SuccessAddcart);
						letDivCenter('.addsuccess-content');
						$('.addsuccess-content').show();
						t = setTimeout(function(){$('.addsuccess-content').hide();},3000);
					}
				}
			});
		}
	});
/*
		$.post("check_basket.php",{},function(data){
			if(data){
				$(".shopcart").removeClass('shopcart').addClass('shopcart1');
			}else{
				$(".shopcart").removeClass('shopcart1').addClass('shopcart');
			}
		});
*/	
});

$(function(){
	$('.order_header .menu').click(function(){
		if ($('.order_header .menu_subnav').is(':visible')) {
			$('.order_header .menu_subnav').hide();
			$('.shopping_cart_bomb').hide();
			$('.windowbodyp').remove();
			return;
		};
		var bodyHeight=($(document).height()+'px');
		$('body').append('<div class="windowbodyp"></div>');
		$(".windowbodyp").css({"height":bodyHeight});
   		$('.windowbodyp').fadeIn();
		$('.order_header .menu_subnav').show();
	});
	$(document).on('click', '.windowbodyp', function(){
		$('.order_header .menu_subnav').hide();
		$('.shopping_cart_bomb').hide();
		$('.windowbodyp').remove();
		
	});
	
});

function re_pos(id){
	var box = document.getElementById(id);
	if(null != box){
		var w = parseInt($('#'+id).css('width'));
		var h = parseInt($('#'+id).css('height'));
		$('#'+id).css("left",get_left(w)+"px").css("top",get_top(h)+"px");
		box.style.left = get_left(w)+"px";
		box.style.top = get_top(h)+"px";
	}
}
function truebody(){
	  return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
	}
function get_left(w){
	var bw = document.all ? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth;
	w = parseFloat(w);
	return (bw/2-w/2 + (document.body.scrollLeft != 0 ? document.body.scrollLeft : document.documentElement.scrollLeft));
}
function get_top(h){
	var bh = document.all ? Math.min(truebody().scrollHeight, truebody().clientHeight) : Math.min(window.innerHeight);
	h = parseFloat(h);
	return (bh/2-h/2 + (document.body.scrollTop != 0 ? document.body.scrollTop : document.documentElement.scrollTop));
}

function setCookie_login_new(c_name,value,expiredays){
  	var exdate=new Date()
  	exdate.setDate(exdate.getDate()+expiredays)
  	document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
}

function getCookie_login(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=")
      	if (c_start!=-1){ 
	      	c_start=c_start + c_name.length+1 
	      	c_end=document.cookie.indexOf(";",c_start)
	      	if (c_end==-1) c_end=document.cookie.length
	      	return unescape(document.cookie.substring(c_start,c_end))
	    } 
    }
    return ""
}

function setCookie_login(c_name,value,expiredays){
    var exdate=new Date()
    exdate.setDate(exdate.getDate()+expiredays)
    document.cookie=c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
}

function show_index_login_window(){
	//console.log($('#jq_index_login_window').html());
    if(getCookie_login("login_cookie")!="false"){
      	var bodyHeight=$(document).height();
      	$("body").append("<div class='windowbodyp'></div>");
      	$(".windowbodyp").css({"height":bodyHeight+572,"opacity":0.35});
      	$(".windowbodyp").fadeIn();
      	var sHeight = $(document).scrollTop();
      	var wHeight=$(window).height();
      	//news_err="<div class='login_window' id='login_window' style='position:fixed;z-index:100000;'></div>";
      	//$("body").append(news_err);
      	//$('.login_window').html($('#jq_index_login_window').html()).show();
      	$('#jq_index_login_window').css({'position': 'fixed', 'z-index' : '100000', 'width': '100%', 'max-width': '465px'}).show();
      	re_pos('jq_index_login_window');
      	setCookie_login("login_cookie","false",365);
    }
}

function show_auth_code(){
	$.post('./ajax_login.php' , {action:'show_auth_code'} , function(data){
		returnInfo = process_json(data);
		if(returnInfo.is_display == true){
			$("#reserved_auth_code_tr").html(returnInfo.show_content);
		}
	});
}

/*
 * 关闭站内信，并记录关闭类型。
 * station_letter_status：关闭类型：20关闭，30已读
 */
function closeLetter(station_letter_status){
	var status_arr = [20 , 30];
	var station_letter_id = parseInt($('.reminder_wrap').attr('station_letter_id'));
	var error = false;
	
	if($.inArray(station_letter_status , status_arr) < 0){
		station_letter_status = 20;
	}
	$.ajax({
		'url'  : './ajax/ajax_record_customers_station_letter_status.php',
		'type' : 'post',
		'data' : {'action' : 'record_letter_status' , 'station_letter_status' : station_letter_status , 'station_letter_id' : station_letter_id},
		'async': false,
		'success' : function(data){
			var returnInfo = process_json(data);
			if(returnInfo.error == true){
				error = true;
			}
		}
	});
	
	if(error == false){
		$('.reminder_wrap').remove();
		$('.order_main').css('margin-top', '45px');
	}
	return !error;
}


$(function(){
	$('.popup_sign_up .close_black').click(function(){
		$('#jq_index_login_window').hide();
		$('.windowbodyp').remove();
	});
	$('.windowbodyp').click(function(){
		$('#jq_index_login_window').hide();
		$('.windowbodyp').remove();
	});
});

function countClicks(click_code){
	$.post("ajax/ajax_record_count_clicks_to_log.php", {click_code: click_code}, function(data){
		var returnInfo = process_json(data);
		//console.log(returnInfo);
		return returnInfo;
	});
}

function addCookie(objName, objValue, objHours) {
	var str = objName + "=" + escape(objValue);
	if (objHours > 0) {
		var date = new Date();
		var ms = objHours * 3600 * 1000;
		date.setTime(date.getTime() + ms);
		str += "; expires=" + date.toGMTString() + "; path=/";
	}
	document.cookie = str;
}

function checkTextUrl(text){
	var error = false;
	var pattern1 = /(https?:\/\/)?(www)?([a-z0-9\-\_]*[\.])+(com|cn|top|net|wang|xin|shop|beer|art|luxe|ltd|co|cc|club|vip|fun|online|tech|store|red|pro|kim|ink|group|work|ren|link|biz|mobi|site|org|govcn|name|info|tv|asia|cloud|fit|yoga|pub|live|wiki|design)/ig
	var pattern2 = /((https?:\/\/)|(www\.))([a-z0-9\-\_]+(\.)?)*/i;
	var pattern3 = /([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/i;

	if(pattern1.test(text) || pattern2.test(text) || pattern3.test(text)){
		error = true;
	}

	return error;
}
//eof