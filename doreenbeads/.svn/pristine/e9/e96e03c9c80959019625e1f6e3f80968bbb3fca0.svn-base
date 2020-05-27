// JavaScript Document
$j(function(){
	$j('.consult').click(function(){
		$j('.windowbody').height($j(document).height()+'px').fadeIn();
		re_pos('contactuscen');
		$j('#contactuscen').show();
	})

	$j('.contact_close, .windowbody').bind('click', function(){
		$j('#contactuscen, .windowbody').fadeOut();
	})

	   $j('.currency').mouseover(function(){
			$j(this).children('dd').addClass('hover');
			$j('#currency_type').show();	
	    })	  
		 $j('.currency').mouseout(function(){
			$j(this).children('dd.hover').removeClass('hover');
			$j('#currency_type').hide();	
	    })	 
			   
      $j('#help').hover(function(){
       $j(this). children('.helpHover').addClass('helplink');
        $j(this).children('.helpcont').show();
       },
      function(){
      $j(this). children('.helpHover').removeClass('helplink');
        $j(this).children('.helpcont').hide();
      })
	  
	$j('#myAccount').hover(function(){
		var isLogin = $j('.isLogin').val();
		if(isLogin == 'yes'){
			$j(this). children('.helpHover').addClass('helplink');
		}		
        $j(this).children('.helpcont').show();
	},
	function(){
		$j(this). children('.helpHover').removeClass('helplink');
		$j(this).children('.helpcont').hide();
	}) 
		
		/*------- click level one, change show/hide level two --------*/
		$j('.sidemenu dt p.menufirst').click(function(){  
			if($j(this).hasClass('menufirstopen')){ 
				$j(this).removeClass('menufirstopen').addClass('menufirstclose'); 
				$j(this).find('a').removeClass('morehover');
			}else{ 
				$j('.sidemenu dt').find('p a').removeClass('morehover');
				$j('.sidemenu dt').find('p.menufirst').removeClass('menufirstopen').addClass('menufirstclose');
				$j('.sidemenu dt').find('.navmore').hide();
				$j(this).removeClass('menufirstclose').addClass('menufirstopen'); 
				$j(this).find('a').addClass('morehover');
			} 
			$j(this).next('.navmore').toggle(); 

			if($j(window).scrollTop() > $j(this).offset().top){
				if($j(this).offset().top >= $j(window).height())
					var totop = $j(this).offset().top;
				else
					var totop = 0;
				$j(window).scrollTop(totop);
			}
		}) 

		$j('.navmore .more').mouseover(function(){ 	
			$j(this).addClass('morehover'); 
			$j(this).children('.threemore').show();
			var index = $j(this).index();
			var len =$j(this).siblings().length;
			if(index == len){
				$j(this).parents('dt').next('dt').addClass('noneborder'); 
			}
			$j(this).parents('dt').css('z-index', '103');
		})
		$j('.navmore .more').mouseout(function(){ 
			$j(this).removeClass('morehover'); 
			$j(this).children('.threemore').hide();
			var index = $j(this).index();
			var len =$j(this).siblings().length;
			if(index == len){ 
				$j(this).parents('dt').next('dt').removeClass('noneborder'); 
			}
			$j(this).parents('dt').css('z-index', '102');
		})
	    $j('.clearancemore').mouseover(function(){
			$j(this).addClass('hover');
			$j(this).children('.clearancecont').show();
			})
	    $j('.clearancemore').mouseout(function(){
			$j(this).removeClass('hover');
			$j(this).children('.clearancecont').hide();
			})
		
		$j('.menuNavcen li').click(function(){
			$j('.menuNavcen li.current').removeClass('current');
			$j(this).addClass('current');
			
			})	
			
		$j('.product_list .list li .proimg').mouseover(function(){
			$j(this).parent('li').addClass('current');
			$j(this).parent('li').find('.maximg').show();
			})	
	    	
		$j('.product_list .list li .proimg').mouseout(function(){
			$j(this).parent('li').removeClass('current');
			$j(this).parent('li').find('.maximg').hide();
			})
			
			
	   		
	$j('p.selectnum').click(function(e){
		$j(this).next('.numlist').toggle();
		e.stopPropagation();
		  $j('body').click(function(){
			$j('.numlist').hide();
			  })
		})	
	$j('.numlist li').click(function(){
	     $j(this).parent('.numlist').prev('.selectnum').children('.text_left1').text($j(this).text()); 
		 $j("#pagenum").val($j(this).text());
		 $j("#sortby").val($j(this).text());
		 	
		})	
		
	$j('#searchinput').focus(function(){
		var va=$j(this).val();
		if(va == $lang.errEnterKeywords){
		  $j(this).val('');	
				}else{
		  $j(this).val();
			}
		
    })	
	$j('#searchinput').blur(function(){
		var va=$j(this).val();
		if(va == ""){
		  $j(this).val($lang.errEnterKeywords);	
				}else{
		  $j(this).val();
			}
    })
	 
	$j('.gallery li').each(function(index){	
		if(index>0 && (index+1)%3==0){
			$j(this).css('padding-right','0');  
		}
	})
})

//bof common login and register
$j(function(){
	$j('.logintit li').each(function(index){
		$j(this).click(function(){
			$j('.logintit li.in').removeClass('in');
			$j(this).addClass('in');
			$j('.logincont.sh').removeClass('sh');
			$j('.logincont').eq(index).addClass('sh');
	     })		
	})
			 
	$j('.common_login_register').click(function(){
		$j('.logintit li.in').removeClass('in');
		$j('.logincont.sh').removeClass('sh');
		$j('.logintit li').eq(1).addClass('in');
		$j('.logincont').eq(1).addClass('sh');
	})

	var logchecking = function(){
		var checked = true;
		var reg_email = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var reg_pass=/^.{5,}$/;
		var emailval=$j.trim($j('#loginbody .emailvalue').val());
		var passval=$j.trim($j('#loginbody .passvalue').val());
		if(!reg_email.test(emailval)){
			$j('#loginbody .emailvalue').next('span').text($lang.errWrongEmail);
		  	checked = false;
		}
		if(!reg_pass.test(passval)){
			$j('#loginbody .passvalue').next('span').text($lang.errPassword);
			checked = false;
		}
		return checked;
	}
	
	$j('.required').focus(function(){
		$j(this).next('span').text('');
		$j(this).next('ins').next('span').text('')
	});
	
	$j('#loginbody #agreecheck').click(function(){
		agreecheck = $j(this).attr('checked');
		agreecheck = (agreecheck == 'checked' ? 1 : 0);
		if(agreecheck == 0){
			$j(this).next().next('span').text($lang.errNotAgree);
		}else{
			$j(this).next().next('span').text('');
		}
	})
		
	var regchecking = function(){
		var checked = true;
		var reg_email = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
	    var reg_pass=/^.{5,}$/;
		var reg_na= /^.{2,}$/;
		var emailval=$j.trim($j('#loginbody .emailval').val());
		var passval=$j.trim($j('#loginbody .passval').val());
		var conpassval=$j.trim($j('#loginbody .con_passval').val());
		var firstval=$j.trim($j('#loginbody .firstval').val());
		var lastval=$j.trim($j('#loginbody .lastval').val());
		var agreecheck = $j('#loginbody #agreecheck').attr('checked');
		agreecheck = (agreecheck == 'checked' ? 1 : 0);
		if(!reg_email.test(emailval)){
			$j('#loginbody .emailval').next('span').text($lang.errWrongEmail);
		  	checked = false;
		}
		if(emailval.length < 6){
			$j('#loginbody .emailval').next('span').text($lang.errEmailContain);
		  	checked = false;
		}
		if(!reg_pass.test(passval)){
			$j('#loginbody .passval').next('ins').next('span').text($lang.errPassword);
			checked = false;
		}
		if(passval != conpassval){
			$j('#loginbody .con_passval').next('span').text($lang.errConfirmPassword);
			checked = false;
		}
		if(!reg_na.test(firstval)){
			$j('#loginbody .firstval').next('span').text($lang.errEnter2Char);
			checked = false;
		}
		if(!reg_na.test(lastval)){
			$j('#loginbody .lastval').next('span').text($lang.errEnter2Char);
			checked = false;
		}
		if(agreecheck == 0){
			$j('#loginbody #agreecheck').next().next('span').text($lang.errNotAgree);
			checked = false;
		}
		return checked;
	}

	//bof login
	$j('#loginbtn').click(function(){
		if(!logchecking()){
			return false;
		}else{
			var email = $j.trim($j('#loginbody .emailvalue').val());
			var password = $j.trim($j('#loginbody .passvalue').val());
			var permLogin = $j('#loginbody #remember').attr('checked');
			permLogin = (permLogin == 'checked' ? 1 : 0);
			$j.post('./ajax_login.php', {action: 'login', email: email, password: password, permLogin: permLogin}, function(data){
				if(data != ''){
					alert(data);
				}else{
					doAfterAjaxLogin(data);					
				}
			})
		}
	})
	//eof

	//bof register
	$j('#loginbody #registerbtn').click(function(){
		if(!regchecking()){
			return false;
		}else{
			email = $j.trim($j('#loginbody .emailval').val());
			fname = $j.trim($j('#loginbody .firstval').val());
			lname = $j.trim($j('#loginbody .lastval').val());
			password = $j.trim($j('#loginbody .passval').val());
			c_password = $j.trim($j('#loginbody .con_passval').val());
			country = $j('#loginbody #zone_country_id').val();
			subscribe = $j('#loginbody #subcheck').attr('checked');
			subscribe = (subscribe == 'checked' ? 1 : 0);
			$j.post('./ajax_login.php', {action: 'create', firstname: fname, lastname: lname, email_address: email, zone_country_id: country, password: password, confirmation: c_password, subscribe: subscribe}, function(data){
				doAfterAjaxLogin(data);
			})
		}
	})
	//eof
	//bof press enter button then submit
	$j("#loginbody input").live('keydown',function(evt) {
		evt = window.event || evt;
		var key = evt.keyCode;
		if(key == 13 && navigator.userAgent.indexOf('MSIE') < 0){
			$j("#loginbody div.logincont.sh input[type='submit']").click();
		}
	})
	//eof
})
//eof

//bof zale
function show_login_div(href,param){
	$j('.windowbody').height($j(document).height()+'px').fadeIn();
	$j('.loginbody').fadeIn();
	var href = (href == '' ? 'index.php?main_page=login.php' : href);
	$j('#login_linkinto').val(href);
	var param = param ? param : '';
	$j('#login_linkparam').val(param);
	re_pos('loginbody');
	$j('#closebtnlogin, .windowbody').bind('click', function(){
		$j('.loginbody, .windowbody').fadeOut();
	})
}
function doAfterAjaxLogin(data){
	switch($j('#login_linkinto').val()){
		case 'testimonial':
			testimonial_process();
			break;
			
		case 'reviews':
			$j('.loginbody, .windowbody').fadeOut();
			var starval = $j.trim($j("#review input").val());
			var name = $j.trim($j("#review_name").val());
			var reviewtext = $j.trim($j("#review_text").val()); 
			var pid = $j('.product_id').val();
			$j.post('./ajax_login.php', {action: 'reviews', starval: starval, reviewtext: reviewtext, name: name, pid: pid}, function(data){		
				window.location.reload();
			})
			break;	
									
		case 'addtowishlist':
			if(typeof(JSON)=='undefined'){
				var param = eval('('+$j('#login_linkparam').val()+')');
			}else{
				var param = JSON.parse($j('#login_linkparam').val());
			}
			Addtowishlist_list(param.productid, param.pageName, true);
			break;
					
		case 'restocknotification':
			if(typeof(JSON)=='undefined'){
				var param = eval('('+$j('#login_linkparam').val()+')');
			}else{
				var param = JSON.parse($j('#login_linkparam').val());
			}
			restockNotification_list(param.productid, true);
			break;
		case 'addsingletowishlist':
			$j.post('./ajax_login.php', {action: 'addsingletowishlist', pid: $j('#login_linkparam').val()}, function(data){		
				window.location.reload();
			});
			break;
		case 'addalltowishlist':
			$j.post('./ajax_login.php', {action: 'addalltowishlist'}, function(data){		
				window.location.reload();
			});
			break;
		default:
			window.location.href = $j('#login_linkinto').val();
	}
}
function testimonial_process(){
	$j('.loginbody, .windowbody').fadeOut();
	$j.post('./ajax_login.php', {action: 'getinfo'}, function(data){		
		if(data != ''){
			var dataArr = data.split('||');
			cname = dataArr[0];
			email = dataArr[1];
			$j('.footer_testimonial_name').val(cname);
			$j('.footer_testimonial_email').val(email);
			show_testimonial();
		}
	})
	
	$j('#closebtnlogin, .windowbody, #testimonialbody .closetest').bind('click', function(){
		window.location.reload();
	})
}

function show_testimonial(){
	$j('.testform').show();
	$j('.success_tips').hide();
	$j('.testimonials_cont').css('color','#000000').css('background-color','#ffffff').val('');
	$j('.windowbody').height($j(document).height()+'px').fadeTo(1000,0.2);
	re_pos('testimonialbody');
	$j('#testimonialbody').show();
}

//bof footer testimonial
$j(function(){
	var tips =$lang.ReviewTips;
	$j('#testimonial_btn').click(function(){
		var check = true;
		var testval=$j.trim($j('.testimonials_cont').val());
		var checkcode = $j.trim($j('.ts_input_checkcode').val().toLowerCase());
		if(testval == '' || testval == tips){
			$j('.testimonials_cont').val(tips);
			$j('.testimonials_cont').css('color','#cb0000').css('background-color','#fffdea');
			check = false;
		}
		if(checkcode == ''){
			$j('.ts_input_checkcode').siblings('div.ts_error').text($lang.InputValidCode);
			check = false;
		}
		$j.ajax({
			url: "./checkCode.php",
			type: "post",
			async: false,
			data: {form_code: checkcode},
			success: function(data){
				if(data.length > 0){
					$j('.ts_input_checkcode').siblings('div.ts_error').text($lang.InputValidCode);
					check = false;
				}else{
					$j('.ts_input_checkcode').siblings('div.ts_error').text('');						
				}
			}
		})
			
		if(check){
			$j.post('./ajax_login.php', {action: 'testimonial', content: testval}, function(data){
				if(data != ''){
					alert(data);
				}else{
					$j('.testform').hide();
					$j('.success_tips').show();
				}
				setTimeout(function(){
					$j('#testimonialbody, .windowbody').fadeOut();
					window.location.reload();
				}, 5000)
			})
		}
		return false;
	})	
	
	$j('.testimonials_cont').focus(function(){
		if($j(this).val() == tips ){
			$j(this).val('');
			$j(this).css("background","#fff");
			$j(this).css("color","#333");
		}else{
			$j(this).val();
		}
	})
	$j('.testimonials_cont').blur(function(){
		if($j(this).val() == '' ){
			$j('.testimonials_cont').css('color','#cb0000').css('background-color','#fffdea');
			$j(this).val(tips);
		}else{
			$j(this).val();  
		}
	})
		 
	$j(".testimonials_cont").keyup(function(){		
		if($j(this).val().length>1000){
			$j('#leftext').text(0);
			$j(this).val($j(this).val().substr(0,1000));
		}else{
			$j('#leftext').text(1000-($j(this).val().length));
		}
	})

	$j('#testimonialbody .closetest, .windowbody').click(function(){
		$j('#testimonialbody, .windowbody').fadeOut();
	})
})
//eof

// bof 未登录则弹出登陆框操作
$j(function(){
	$j('#myWishlist a').click(function(){
		var isLogin = $j('.isLogin').val();
		var linkinto = 'index.php?main_page=wishlist';
		if(isLogin == 'yes'){
			window.location.href = linkinto;
		}else{
			show_login_div(linkinto);
		}
	})

	$j('.footer_write_a_testimonial').click(function(){
		$j('div.ts_error').text('');
		$j('.ts_input_checkcode').val('');
		$j('#ts_check_code').attr('src', './check_code.php?'+Math.random());
		var isLogin = $j('.isLogin').val();
		if(isLogin == 'yes'){
			show_testimonial();
		}else{
			show_login_div('testimonial');
		}
	})
	
	$j('.checkbtnline .check').live('click', function(){
		var linkinto = 'index.php?main_page=checkout_shipping';
		var isLogin = $j('.isLogin').val();
		if(isLogin == 'yes'){
			window.location.href = linkinto;
		}else{
			show_login_div(linkinto);
		}
	})

	$j('#myAccount').click(function(){
		var linkinto = 'index.php?main_page=account';
		var isLogin = $j('.isLogin').val();
		if(isLogin == 'yes'){
			window.location.href = linkinto;
		}else{
			show_login_div(linkinto);
		}
	})
})
//eof

$j(function(){
	$j('.addcart').mouseover(function(){
		$j('.addcart').addClass('addcarthover');
		$j('.addcartcont').show();
		$j.post('./show_cart_terms.php', {action: 'getcarcontent'}, function(data){
			$j('.addcartcont').html(data);
		})
	})

	$j('.cartcontent').mouseleave(function(){
		$j('.addcart').removeClass('addcarthover');
		$j('.addcartcont').hide();
	})

	//bof 删除商品，刷新页面
	$j('.deletethis').live('click', function(){
		var pid = $j.trim($j(this).children().val());
		$j.post('./show_cart_terms.php', {action: 'remove', pid: pid}, function(data){
			//window.location.reload();
			$j('.addcartcont').html(data);
			$j('#count_cart').html($j('#minicart_total_terms').val());
			$j('#header_cart_total').html($j('#minicart_total_amount').val());
		})		
	})
	//eof

	//bof 跳到前一页
	$j('.checkbtnline a.hasprevious').live('click', function(){
		var page = $j('.cart_current_page').val() - 1;
		$j.post('./show_cart_terms.php', {page: page}, function(data){
			$j('.addcartcont').html(data);
		})
	})
	//eof

	//bof 跳到后一页
	$j('.checkbtnline a.hasnext').live('click', function(){
		var page = parseFloat($j('.cart_current_page').val()) + 1;
		$j.post('./show_cart_terms.php', {page: page}, function(data){
			$j('.addcartcont').html(data);
		})
	})
	//eof
})
//eof

//bof common login select country
$j(document).ready(function(){
	$j('.choose_single').click(function(){
		var select_drop = $j(this).next('.country_select_drop');
		var cSelectId = $j(this).parent().siblings('#cSelectId');
		var cListNum = select_drop.children().find("#country_list_"+cSelectId.val());
		var cListItem = select_drop.children('ul').children('.country_list_item')

		var ifshow=select_drop.css('display');
		current=$j(this).parent().siblings("#cSelectId").val();
		if(ifshow=="none"){
			select_drop.show();
			$j(this).removeClass('choose_single_focus');
			$j(this).addClass('choose_single_click');
			select_drop.children('.choose_search input').val('');
			cListItem.css('display','block');
			select_drop.children('.choose_search').children('input').focus();
			
			
			if(cListNum.hasClass('country_list_item_selected')&&!cSelectId.hasClass('selectNeedList')){
				
			}else{
				cSelectId.removeClass('selectNeedList');
				cListNum.addClass('country_list_item_selected');
				boxTop1=select_drop.children().find("#country_list_1").position().top;
				boxTop2=cListNum.position().top;
				selfHeight=cListNum.height()+8+7;
				boxTop=boxTop2-boxTop1-220+selfHeight;
				select_drop.children('ul').scrollTop((boxTop));
			}
		}else{
			select_drop.hide();
			$j(this).removeClass('choose_single_click');
			$j(this).addClass('choose_single_focus');
		}
	})

	$j('.country_list_item').hover(function(){
		$j(this).addClass('country_list_item_hover');
		$j(this).removeClass('country_list_item_selected');
	},function(){
		$j(this).removeClass('country_list_item_hover');
	})	

	$j('.country_list_item').click(function(){
		var choose_single = $j(this).parent().parent().siblings('.choose_single');
		var cListId=$j(this).attr('clistid');
		var cText=$j(this).text();
		var cId=$j(this).attr('id');
		cIdArr=cId.split('_');
		getCId=cIdArr[2];
		choose_single.children('span').text(cText);
		choose_single.parent().siblings('#cSelectId').prev('input').val(cListId);
		choose_single.parent().siblings('#cSelectId').val(getCId);
		$j(this).addClass('country_list_item_selected');
		choose_single.siblings('.country_select_drop').hide();
		
		choose_single.removeClass('choose_single_click');
		choose_single.addClass('choose_single_focus');
		choose_single.focus();
	})	

	$j('.choose_single').blur(function(){
		$j(this).removeClass('choose_single_focus');
	})

	$j('.choose_search input').keyup(function(){
		inputVal=$j(this).val();
		inputVals=inputVal.replace(/^\s*|\s*$/g, "");
		if(inputVals!=''){
			$j(this).parent().siblings('ul').scrollTop(0);
			$j(this).parent().parent().siblings('#cSelectId').addClass('selectNeedList');
			$j(this).parent().siblings('ul').children('.country_list_item').each(function(){
				cTextVal=$j(this).text();
				re = new RegExp("^"+inputVals,'i');  
				re2= new RegExp("\\s+"+inputVals,'i')
				if(cTextVal.match(re)||cTextVal.match(re2)){
					$j(this).css('display','block');
				}else{
					$j(this).css('display','none');
				}
			});
		}else{
			$j(this).parent().siblings('ul').children('.country_list_item').css('display','block');
		}
	})
})

$j(document).ready(function(){
	document.onclick = function (event){
	if($j(".country_select_drop").css('display')=='block'){
		var e = event || window.event;  
		var elem = e.srcElement||e.target;  
		while(elem){
			if(elem.id == "curSelectorDt"||elem.id == "country_choose"){
				return true;
			}  
			elem = elem.parentNode; 
		}  
		$j(".country_select_drop").hide();
		$j('.choose_single').removeClass('choose_single_click');
	}}
});
//eof

//bof bottom subscribe Newsletter
$j(function(){
	/*$j('#subscribebtn').click(function(){
		var subaddress = $j.trim($j('.subaddress').val());
		var reg_address = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var mail = $j('.subaddress').val();
		if(subaddress == ''){
			$j('.subscribebody .info_error').show();
			$j('.subscribebody .info_error .when_email_empty').show();
			$j('.subscribebody .info_error .when_email_wrong').hide();
		}else{
			$j('.subscribebody .info_error .when_email_empty').hide();
			$j('.subscribebody .info_error .when_email_wrong').show();
			if(!reg_address.test(subaddress)){
				$j('.subscribebody .info_error').show();
				$j('.subscribebody .info_right').hide(); 
			}else{
				$j('.subemail').val(mail);
				$j('.subscribebody .info_right').hide(); 
				$j('.subscribebody .info_error').hide();
				$j('.subscribebody form.subform').show();
			}
		}
		
		$j('.windowbody').height($j(document).height()+'px').fadeIn();
		re_pos('subscribebody');
		$j('#subscribebody').show();
	});		*/
	$j('.windowbody, .subscribebody a, .subscribebody .subclose').click(function(){
		$j('.windowbody, .subscribebody').fadeOut();
	})		   
		
	var subchecking = function(){
		subcheck =  true;
		var reg_address = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var subemail = $j.trim($j('.subemail').val());
		var subname = $j.trim($j('.subname').val());
		if(subemail == ''){
			$j('.subemail').next('span').text($lang.EnterEmailAddress);
			subcheck = false;
		}
		if(!reg_address.test(subemail)){
			$j('.subemail').next('span').text($lang.CheckEmailAddress);
			subcheck = false;
		}
		if(subname == ''){
			$j('.subname').next('span').text($lang.EnterName);
			subcheck = false;  	  
		}
		return subcheck;
	}
		  
	$j('#subscribebtn').click(function(){
		if(!subchecking()){
			return false;
		}else{
			email = $j.trim($j('.subemail').val());
			fname = $j.trim($j('.subname').val());

			$j.post('./ajax_login.php', {action: 'subscribe', email_address: email, firstname: fname}, function(data){
				$j('.subscribebody .info_error').hide();
				$j('.subscribebody form.subform').hide();
				$j('.subscribebody .info_right').show();
				setTimeout(function(){
					$j('#subscribebody, .windowbody').hide();
				}, 5000)
			})
		}
		return false;
	})
})
//eof

//bof 产品详细页第五个产品margin-right 0
$j(function(){
	var hovercont_num=$j('.detailitem li').length;
	$j('.detailitem li').each(function(index){
		var i=index+1;
		var c=i%5;
		if(c==0){
			$j('.detailitem li').eq(i-1).css('margin-right','0');
		}
	})
})
//eof

//bof tell a friend
$j(function(){
	$j('.tellfriend').click(function(){
		$j('.emailbody dl').hide();
		$j('.emailbody .emailform').show();
		$j('.toemail, .toname, .fromemail, .fromname, .toemail').next('span').hide();
		$j('.windowbody').height($j(document).height()+'px').fadeIn();
		re_pos('emailbody');
		$j('#emailbody').fadeIn();
	})
	   
	$j('.closeemail, .windowbody, .emailbody dl dt a, .closebtn_email').click(function(){
		$j('#emailbody, .windowbody').fadeOut();
		return false;
	})
		
	var emailchecking = function(){
		var emailcheck = true;
		var reg_address = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var toemail = $j('.toemail').val();
		var fromemail = $j('.fromemail').val();
		var fromname = $j('.fromname').val();
		var toname = $j('.toname').val();	
		var code = $j('.emailform input[name=form_code]').val();	
		if(toemail == ''){
			$j('.toemail').next('span').text($lang.EnterFriendEmail).show();
			emailcheck = false;
		}else if(!reg_address.test($j.trim(toemail))){
			$j('.toemail').next('span').text($lang.CheckFriendEmail).show();
			emailcheck = false;
		}		
		if(fromemail == ''){
			$j('.fromemail').next('span').text($lang.EnterEmailAddress).show();
			emailcheck = false;
		}else if(!reg_address.test($j.trim(fromemail))){
			$j('.fromemail').next('span').text($lang.CheckYourEmail).show();
			emailcheck = false;
		}
		if(fromname == ''){
			$j('.fromname').next('span').text($lang.EnterName).show();
			emailcheck = false;
		}
		if(toname == ''){
			$j('.toname').next('span').text($lang.EnterFriendName).show();
			emailcheck = false;
		}
		if(code == ''){
			$j('.error_code').text($lang.InputValidCode).show();
			emailcheck = false;
		}
		return  emailcheck;
	}
	$j('.emailform input[name=form_code]').click(function(){
		$j('.error_code').text('').hide();
	})
	$j('.emailbody .send').click(function(){
		if(!emailchecking()){
			return false;
		}else{
			fromname = $j.trim($j('.fromname').val());
			fromemail = $j.trim($j('.fromemail').val());
			toname = $j.trim($j('.toname').val());
			toemail = $j.trim($j('.toemail').val());			
			note = $j.trim($j('.email_cont').val());
			pid = $j('.product_id').val();
			var code=$j('.emailform input[name=form_code]').val();
			$j.ajax({
				'url':'checkCode.php',
				'type':'post',
				'data':{'form_code':code},
				'async':false,
				'success':function(data){
					if(data){
						$j('.error_code').text($lang.InputValidCode).show();
					}else{
						$j.post('./ajax_product_info.php', {action: 'tellfriend', pid: pid, fromname: fromname, fromemail: fromemail, toname:toname, toemail: toemail, note: note,form_code:code}, function(){
							$j('.emailbody dl').show();
							$j('.emailbody .emailform').hide();
							$j('.success_to').html(toemail);
							setTimeout(function(){
								$j('.windowbody').fadeOut();
								$j('.emailbody').hide();
							}, 5000);
						})
					}
				}
			}); 

			return false;
		}
	})
	limit_word($j('.email_cont'), 255);
})

function limit_word(obj, max){
	obj.bind('keyup change', function(){
		length = obj.val().length;
		left_number = max - length;
		if(left_number <= 0){
			left_number = 0;
			obj.val(obj.val().substring(0, max));
		}
		$j('#leftext').text(left_number);
	})	
}
//eof tell a friend

//bof product question
var question_content_error = $lang.ReviewTips;
$j(function(){
	$j('.ask_quest_btn').click(function(e){		
		$j('.quessuccess').hide();
		$j('p.pq_error').hide();
		$j('.pq_input_checkcode').val('');
		$j('#pq_check_code').attr('src', './check_code.php?'+Math.random());
		$j('textarea.pq_textarea').val(question_content_error).css('color', '#999');
		$j('.windowbody').height($j(document).height()+'px').fadeIn();
		$j('.quesform').show();
		re_pos('questioncont');
		$j('#questioncont').fadeIn();
	})
	   
	$j('.p_select').click(function(e){
		$j('.selectlist').toggle();
		e.stopPropagation();
		$j('.questioncont').click(function(){
			$j('.selectlist').hide();
		})
	});
	  	  
	$j('.selectlist li').each(function(index){
		$j(this).click(function(){
			$j('#selecttext').text($j(this).text());
		})
	})	
	
	var pqchecking = function(){
		var pq = true;
		var reg_address = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var email = $j('.emailinput').val();
		var fname = $j('.firstinput').val();
		var lname = $j('.lastinput').val();
		var question = $j('.pq_textarea').val();
		var checkcode = $j.trim($j('.pq_input_checkcode').val().toLowerCase());

		if(!reg_address.test($j.trim(email))){
			$j('.emailinput').parent().next('p.pq_error').text($lang.CheckYourEmail).show();
			pq = false;
		}
		if(email == ''){
			$j('.emailinput').parent().next('p.pq_error').text($lang.EnterEmailAddress).show();
			pq = false;
		}
		if(fname == ''){
			$j('.firstinput').parent().next('p.pq_error').text($lang.EnterFirstName).show();
			pq = false;
		}
		if(lname == ''){
			$j('.lastinput').parent().next('p.pq_error').text($lang.EnterLastName).show();
			pq = false;
		}
		if(question == '' || question == question_content_error){
			$j('.pq_textarea').css('color', '#ff0000');
			pq = false;
		}
		if(checkcode == ''){
			$j('.pq_input_checkcode').parent().next('p.pq_error').text($lang.InputValidCode).show();
			pq = false;
		}else{
			$j.ajax({
				url: "./checkCode.php",
				type: "post",
				async: false,
				data: {form_code: checkcode},
				success: function(data){
					if(data.length > 0){
						$j('.pq_input_checkcode').parent().next('p.pq_error').text($lang.InputValidCode).show();
						pq = false;
					}
				}
			})
		}
		return pq;
	}

	$j('.textinput input, .textinput textarea').focus(function(){
		$j(this).parent().next('p.pq_error').hide();
	})
	
	$j('textarea.pq_textarea').focus(function(){
		$j(this).css('color', '#333');
		if($j(this).val() == question_content_error){
			$j(this).val('');
		}
	}).blur(function(){
		if($j.trim($j(this).val()) == ''){
			$j(this).css('color', '#ff0000');
			$j(this).val(question_content_error);
		}
	})

	$j('#questsubbtn').click(function(){
		if(!pqchecking()){
			return false;
		}else{
			var topic = $j.trim($j('#selecttext').text());
			var email = $j.trim($j('.emailinput').val());
			var fname = $j.trim($j('.firstinput').val());
			var lname = $j.trim($j('.lastinput').val());
			var question = $j.trim($j('.pq_textarea').val());
			pid = $j('.product_id').val();
			$j.post('./ajax_product_info.php', {action: 'pq', topic: topic, email: email, fname: fname, lname:lname, question: question, pid: pid}, function(){
				$j('.quesform').hide();
				$j('.quessuccess').show();
				setTimeout(function(){
					$j('.windowbody').fadeOut();
					$j('.questioncont').hide();
				}, 55000);
			})
			return false;
		}
	})
	$j('.closepro, .windowbody, .quessuccess p a').click(function(){
		$j('#questioncont, .windowbody').fadeOut();
	})
})
//eof

//bof reviews
$j(function(){
	var reviewlevel = $lang.ReviewLevel;
    var star = $j("#review img");
    var a = "includes/templates/cherry_zen/images/star_grey.png";
    var b = "includes/templates/cherry_zen/images/star_gold.png";
    var curvalue=-1; //鼠标离开的时候

    function full(index){
        for( var i=0;i<star.length; i++ ){
            if(i<=index)
                $j(star[i]).attr('src',b);
            else
                $j(star[i]).attr('src',a);
        }
        $j("#review ins").text( reviewlevel[index]);
		$j("#review label").text('');
    }

	star.each(function(index){
		$j(star[index]).click(function(){
		curvalue=index;
		$j("#review input").attr("value",index+1);
			full(index);
		})
		$j(star[index]).mouseover(function(){
			full(index);
		})
		$j(star[index]).mouseout(function(){
			full(curvalue);
			if(curvalue ==-1){
				$j("#review ins").text( "");
			}
		})
	})		
	
	
	var review_tips=$lang.ReviewTips;
    $j("#review_text").blur(function(){
		if($j(this).val() == '')
			$j(this).val(review_tips);
		else
		    $j(this).val();
	})
    $j("#review_text").focus(function(){
		if($j(this).val() == review_tips){
			$j(this).val('');
			$j("#review_text").css("background","#fff");
			$j("#review_text").css("color","#959595")
		}else{
			$j(this).val();
		}
	})	
	
	$j("#review_text").keyup(function(){
		if($j(this).val() == review_tips){
			$j(this).val('');
		}else{
			$j('#remaintext').text(1000-($j(this).val().length));
			if($j(this).val().length>1000){
				$j(this).val($j(this).val().substr(0,1000))
			}
		}
	})

    var reviewchecking = function(){
		var checking = true;
		var starval = $j.trim($j("#review input").val());
		var reviewtext = $j.trim($j("#review_text").val());
		var checkcode = $j.trim($j('.wr_input_checkcode').val().toLowerCase());
		if(starval == ""){
		    $j("#review label").text($lang.ChooseRating);	
			$j("#review label").css("color","#c50000").css("font-weight","normal");
			checking = false;
		}else{
			$j("#review label").text("");	
		}		
        if(reviewtext == "" || reviewtext == review_tips ){
		    $j("#review_text").css("background","#fffdea").css("color","#c70006");
			checking = false;
		}
		if(checkcode == ''){
			$j('.wr_input_checkcode').siblings('div.wr_error').text($lang.InputValidCode);
			checking = false;
		}else{
			$j.ajax({
				url: "./checkCode.php",
				type: "post",
				async: false,
				data: {form_code: checkcode},
				success: function(data){
					if(data.length > 0){
						$j('.wr_input_checkcode').siblings('div.wr_error').text($lang.InputValidCode);
						checking = false;
					}else{
						$j('.wr_input_checkcode').siblings('div.wr_error').text('');
					}
				}
			})
		}
		return checking;		
	}
		
    $j("#reviewsubmit").click(function(){
		var isLogin = $j('.isLogin').val();
		if(!reviewchecking()) {
			return false;
		}else{
			if(isLogin == 'no'){
				show_login_div('reviews');
				return false;
			}
		}				
	})
	$j('.wr_input_checkcode').keydown(function(){
		$j('div.wr_error').val('');
	})
		
	$j('.write_review').click(function(){
		$j('div.wr_error').text('');
		$j('.wr_input_checkcode').val('');
		$j('#wr_check_code').attr('src', './check_code.php?'+Math.random());
		$j(this).hide();
		$j(this).parents('.reviewcont_tit').children('form').show();		
	})
	$j('.pro_btn_cancelgrey').click(function(){
		$j('.write_review').show();
		$j('.write_review').parents('.reviewcont_tit').children('form').hide();
		return false;
	})

	$j('.detailcont .propagelist a').live('click', function(){
		var page = $j(this).attr('pageid');
		var pid = $j('.product_id').val();
		$j.post('./ajax_product_info.php', {action: 'splitpage', pid: pid, page: page}, function(data){
			obj = JSON.parse(data)
			$j('.reviewcont_list').html(obj.review_list_html);
			$j('.propagelist').html(obj.review_split_html);
		})
	})
})
//eof

$j(function(){
	var link = window.location.href;
	if(link.indexOf('#reviewcontent') > 0){
		link = link.substr(0, link.indexOf('#reviewcontent'));
		if($j('.reviewlist').length == 0){
			$j('.write_review').click();
		}
	}
	$j('.junptowritereview').click(function(){
		window.location.href = link+'#reviewcontent';
		$j('.write_review').click();
	})
})

$j(function(){
	var gotops=$j('#goTopBtn');
	backTopLeft();
	$j(window).resize(backTopLeft);
	function backTopLeft(){
		var btLeft=$j(window).width()/2+500;
		if(btLeft<=1002){
			gotops.css({'left':($j(window).width()-45)})
		}else{
			gotops.css({'left':(btLeft+13)})
		}
	}
	$j(window).scroll(function(){
		var sc=$j(window).scrollTop();
		var rwidth=$j(window).width()
		if(sc>0){
			$j("#goTopBtn").css("display","block");
		}else{
			$j("#goTopBtn").css("display","none");
		}
	})
			  	
	$j("#goTopBtn").click(function(){
		var sc=$j(window).scrollTop();
		$j('body,html').animate({scrollTop:0},500);
	})
})
