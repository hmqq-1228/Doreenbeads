$j(function() {
	$j("ul.language li a").live('click',function(event) {
		event.preventDefault();
		var code = $j(this).data("code");
		var urlHref = $j(this).attr("href");
		addCookie('zenchange_language', code, '5');
		location.href = urlHref;
	});
	$j('.login_window a.close').live('click',function(){
		$j('.DetBgW').remove();
		$j('.open_window').remove();
		$j('.login_window').remove();
		setCookie_login("login_cookie","false",365);
	})
	$j('.DetBgW').live('click',function(){
		$j('.DetBgW').remove();
		$j('.open_window').remove();
		$j('.login_window').remove();
		$j('.avatar_upload_div').remove();
		$j('.writeInsert').remove();
		$j('.news_right_div').remove();
		$j('.news_error').remove();
		$j('#warmprompt').remove();
		setCookie_login("login_cookie","false",365);
	})
	
	$j('.ShowPackageDetBgW').live('click',function(){
		$j('.ShowPackageDetBgW').remove();
		$j('.package_cont').remove();
		$j('.login_window').remove();
		$j('.avatar_upload_div').remove();
		$j('.writeInsert').remove();
		$j('.news_right_div').remove();
		$j('.news_error').remove();
		$j('#warmprompt').remove();
		setCookie_login("login_cookie","false",365);
	})
	
	$j('#closebtnlogin').live('click',function(){
		$j('.ShowPackageDetBgW').remove();
		$j('.package_cont').remove();
	})
	
	/*contact us*/
	$j('.consult a').click(function(e){
		countClicks(20);
		$j('.helpicon').html('<img src="https://livechatimg.doreenbeads.com/dblivehelp/image.php?nowTime='+parseInt(Math.random()*10000+1)+'&langs='+$j('#c_lan').val()+'&l=HongShengXie&x=1&deptid=1">');
	    $j('.contactuscenwrap').fadeTo(1000,0.5);
		$j('.contactuscen').show();
			 e.stopPropagation();
		    $j('.contactuscenwrap').click(function(){
      		$j('.contactuscenwrap').hide();
		    $j('.contactuscen').hide();
		    $j('.helpicon').html('');
		   });

		    $j('.contactcont_main ul li a').click(function(){
		        $j('.contactuscenwrap').hide();
				$j('.contactuscen').hide();
				 $j('.helpicon').html('');
		     })
		})
        $j(".contact_close").click(function(){
		$j('.contactuscenwrap').hide();
		 $j('.contactuscen').hide();
		 $j('.helpicon').html('');
		 });
	
	
	$j(".products_multi_design div ul li a").hover(function() {
		$j(this).find("img").css("width","42px");
		$j(this).find("img").css("height","42px");
		$j(this).parents("li").filter(":first").css("border", "0px solid #ccc");
		$j(this).parents("li").filter(":first").css("width","42px");
		$j(this).parents("li").filter(":first").css("height","42px");
	}, function() {
		$j(this).find("img").css("width","38px");
		$j(this).find("img").css("height","38px");
		if($j(this).parents("li").filter(":first").hasClass("current")) {
			$j(this).parents("li").filter(":first").css("border", "2px solid #F90");
		} else {
			$j(this).parents("li").filter(":first").css("border", "2px solid #ccc");
		}
		$j(this).parents("li").filter(":first").css("width","38px");
		$j(this).parents("li").filter(":first").css("height","38px");
	});

	$j(".jq_products_multi_design_left").click(function(){
		var parent = $j(this).parents("div").filter(":first");
		if(parent.find(".jq_products_multi_design_right").hasClass("right_arrow_grey")){
			parent.find(".jq_products_multi_design_right").removeClass("right_arrow_grey");
			parent.find(".jq_products_multi_design_right").addClass("right_arrow");    
		}
		if($j(this).hasClass("left_arrow")){
			var num=1;
			var w = parseInt(parent.find("li").css("width")) + parseInt(parent.find("li").css("margin-right"));	
			var tw = w * parent.find("li").length;
			if(!parent.find("ul.jq_products_multi_design_ul").is(":animated")){
				var marLeft = parseInt(parent.find("ul.jq_products_multi_design_ul").css("margin-left"));		
				var l = marLeft + (parseInt(parent.find(".jq_products_multi_design_left").css("margin-right")) * 2) + w * num;
				if(l >= 0){
					l = 0;
					parent.find(".jq_products_multi_design_left").removeClass("left_arrow");
					parent.find(".jq_products_multi_design_left").addClass("left_arrow_grey");
				}	
				parent.find("ul.jq_products_multi_design_ul").animate({marginLeft: l+"px"}, 200);	
			}	
	 	}
	});
	
	$j(".jq_products_multi_design_right").click(function(){
		var parent = $j(this).parents("div").filter(":first");
		if(!parent.find(".jq_products_multi_design_left").hasClass("left_arrow")){
			parent.find(".jq_products_multi_design_left").removeClass("left_arrow_grey");
			parent.find(".jq_products_multi_design_left").addClass("left_arrow");
		}
		if(!$j(this).hasClass("right_arrow_grey")){
			var num=1;
			var w = parseInt(parent.find("li").css("width")) + parseInt(parent.find("li").css("margin-right"));
			var tw = w*parent.find("li").length;
			if(!parent.find("ul.jq_products_multi_design_ul").is(":animated")){
				var marLeft = parseInt(parent.find("ul.jq_products_multi_design_ul").css("margin-left"));					
				var l = marLeft - (parseInt(parent.find(".jq_products_multi_design_left").css("margin-right")) * 2) - w * num;
				parent.find("ul.jq_products_multi_design_ul").animate({marginLeft: l+"px"}, 200);
				if(-marLeft >= tw - w * num * 6){
					parent.find(".jq_products_multi_design_right").addClass("right_arrow_grey");
				}
			}
		}
	});

	
	$j(function(){
		$j(document).on('click', '.shopping_cart_products_error .btn_show', function(){
			$j('.shopping_cart_products_error .pro_removed').show();
			$j('.shopping_cart_products_error .btn_show').hide();
			$j('.shopping_cart_products_error .btn_close').show();
		});
		$j(document).on('click', '.shopping_cart_products_error .btn_close', function(){
			$j('.shopping_cart_products_error .pro_removed').hide();
			$j('.shopping_cart_products_error .btn_show').show();
			$j('.shopping_cart_products_error .btn_close').hide();
		});
	});
	
});

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

$j(function(){
	$j('.typetitle .cate').click(function(){
		$j(this).next('.refine').removeClass('hover1');
		$j(this).addClass('hover1');
		$j('.sidemenu dt:first').css('border-top', '0');
		$j('.sidemenu').show();
		$j('.refinecont').hide();
	});
	$j('.typetitle .refine').click(function(){
		$j(this).prev('.cate').removeClass('hover1');
		$j(this).addClass('hover1');
		$j('.sidemenu').hide();
		$j('.refinecont').show();
	});
	$j('.navlist_refine dd p').click(function(){
		if($j(this).hasClass('navlist_more')){
			$j(this).removeClass('navlist_more').addClass('navlist_less');
			$j(this).find('a').text('Less');
			$j(this).parents('dd').find('li.hiddenLi').slideDown();
		}else{
			$j(this).removeClass('navlist_less').addClass('navlist_more');
			$j(this).find('a').text('More');
			$j(this).parents('dd').find('li.hiddenLi').slideUp();
		}
	});
	$j('.navlist_refine .navlist_list li a input').click(function(event){
		event.preventDefault();
		window.location.href=$j(this).parents('a').attr('href');
	});
	$j('.open_window .close,.open_window .doublebutton .btn_grey').live('click',function(){
		$j('.open_window').remove();
		$j('.DetBgW').remove();
	})
});

function makeSureCart(productsId,pageType,pageName, extraNote){
	var langs = document.getElementById("c_lan").value;
	switch(langs){
	case 'german': 
		var note = 'Dieser Artikel ist vorläufig nicht vorrätig. Aber Sie können es Reservieren. Wir werden es vorbestellen, wenn es wieder auf Lager ist. Unsere Politik ist: Früher kaufen, Früher Senden.';
		var qty = 'Menge:';
		var addtocart = 'In den Warenkorb';
		var cancel = 'Abbrechen'; break;
	case 'russian': 
		var note = 'Товара временно нет в наличии. Вы можете сделать предварительный заказ. Мы собшим вам сразу же, как только он приедет на склад. Чем раньше вы купите, тем раньше мы отправляем.';
		var qty = 'Кол-во.:';
		var addtocart = 'В корзину';
		var cancel = 'Отменить'; break;
	case 'french': 
		var note = "Cet article est temporairement en rupture de stock. Mais commandez-le sans inquiétude, svp. Une fois que nous avons renouvelé le stock, nous vous l’enverrons tout de suite. Notre politique est d’acheter plus tôt, envoyer plus tôt.";
		var qty = 'Quantit:';
		var addtocart = 'Ajouter au panier';
		var cancel = 'Annuler';break;
	case 'spanish': 
		var note = "Este artículo está temporalmente fuera de stock. Pero usted puede reservarlo. Se le enviaremos enseguida cuando lo tengamos en stock. Nuestra política es más antes comprar, más antes preparar el envío.";
		var qty = 'Cantidad:';
		var addtocart = 'Añadir a Cesta';
		var cancel = 'Cancelar';break;
	case 'japanese': 		
		var note = 'この商品は今在庫切れです。それを事前に注文することができます。それが再入荷される場合は、すぐにお客様に送信下します。弊社の方針はより早く購入して、より早く出荷いたします。';
		var qty = '数量：';
		var addtocart = 'カートに追加';
		var cancel = 'キャンセル';break;
	case 'italian': 
		var note = 'Questo articolo èd esaurito temporaneamente. Ma si potrebbe prenotarlo. Ti invieremo appena è rifornito. La nostra politica è che acquisto prima, invio prima.';
		var qty = 'Quantità:';
		var addtocart = 'Aggiungi';//Aggiungi al Carrello
		var cancel = 'Annulla'; break;
	default : 
		var note = 'This item is temporarily out of stock. But you could backorder it. We will send it to you once it is restocked. Our policy is that earlier purchase, earlier sending.';
		var qty = 'Quantity:';
		var addtocart = 'Add to Cart';
		var cancel = 'Cancel';
	}
	var bodyHeight=$j(document).height();
	$j("body").append("<div class='DetBgW'></div>");
	$j(".DetBgW").css({"height":bodyHeight,"opacity":0.35});
	$j(".DetBgW").css({"opacity":0.35});
	$j(".DetBgW").fadeIn();
	var sHeight = $j(document).scrollTop();
	var wHeight=$j(window).height();
	news_err="<div class='open_window'></div>";
	$j("body").append(news_err);
	if(pageType=='shop'){
		var incartNum=$j('.rp_oqty_'+productsId).val();
		incartNum=((incartNum==''||incartNum<=0)?1:incartNum);
		var data='<a href="javascript:void(0)" class="close"></a><div class="center_note_area">'+note+'</div><div class="input_num_div"><span>'+qty+'</span><input type="text" maxlength="5" value='+incartNum+' name="rp_qty" class="rp_qty_'+productsId+'" onpaste="return false;"></div><p class="doublebutton backorder_div"><a rel="nofollow" class="icon_addcart icon_backorder_show" href="javascript:void(0);" id="submitp_'+productsId+'" name="submitp_'+productsId+'" onclick="Addtocart_list('+productsId+','+pageType+',this); return false;">'+addtocart+'</a><button class="btn_grey"><span><strong>'+cancel+'</strong></span></button></p>';
	}else{
		var incartNum=$j('#incart_'+productsId).val();
		incartNum=((incartNum==undefined || incartNum==''||incartNum<=0)?1:incartNum);
		var data='<a href="javascript:void(0)" class="close"></a><div class="center_note_area">'+extraNote+'<br/>'+note+'</div><div class="input_num_div"><span>'+qty+'</span><input type="text" maxlength="5" value='+incartNum+' name="products_id['+productsId+']" id="'+pageName+'_'+productsId+'"></div><p class="doublebutton backorder_div"><a rel="nofollow" class="icon_addcart icon_backorder_show" href="javascript:void(0);"  name="submitp_'+productsId+'" onclick="Addtocart_list('+productsId+','+pageType+',this); return false;">'+addtocart+'</a><button class="btn_grey"><span><strong>'+cancel+'</strong></span></button></p>';
	}	
	$j('.open_window').html(data);	
	rHeight=$j(".open_window").height();
	var box_top=sHeight+(wHeight-rHeight)/2;
	rWidth=$j(".open_window").width();
	var box_left=($j(document).width()-rWidth)/2;
	//$j(".open_window").css({"top":box_top, "left":box_left});
	$j(".open_window").css({"left":box_left});
	$j(".open_window").show();
}

$j(function() {
	$j('.credit_memo_img').click(function(){
			if($j(this).hasClass('credit_memo_img_click')){
				$j(this).removeClass('credit_memo_img_click');
				var _index=$j('.credit_memo_img').index(this);
				$j('.all_c_memo').eq(_index).hide();
			}else{
				$j('.credit_memo_img').removeClass('credit_memo_img_click');
				$j(this).addClass('credit_memo_img_click');
				var _index=$j('.credit_memo_img').index(this);
				$j('.all_c_memo').hide().eq(_index).show();
			}
		});
});


function showOtherPackageSize(that){
	var products_id = $j(that).attr('data-id');
	$j.ajax({
		'url':'show_other_package_size.php',
		'type':'post',
		'data':{'products_id':products_id},
		'success':function(responseData){
			var body = $j('body');
			var bodyHeight = body.height();
			body.append("<div class='ShowPackageDetBgW'></div>");
			$j(".ShowPackageDetBgW").css({"height":bodyHeight,"opacity":0.35});
			$j(".ShowPackageDetBgW").css({"opacity":0.35});
			$j(".ShowPackageDetBgW").fadeIn();
			body.append(responseData);
			lazyload($('.package_cont').find('.lazy-img'));
		}
		
	})
}
/*
 * 关闭站内信，并记录关闭类型。
 * station_letter_status：关闭类型：20关闭，30已读
 */
function closeLetter(station_letter_status){
	var status_arr = [20 , 30];
	var station_letter_id = parseInt($j('.reminder_wrap').attr('station_letter_id'));
	var error = false;
	
	if($j.inArray(station_letter_status , status_arr) < 0){
		station_letter_status = 20;
	}
	$j.ajax({
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
		$j('.reminder_wrap').remove();
	}
	return !error;
}

//windows.open打开窗口并居中 http://www.cnblogs.com/umlzhang/p/3660489.html
//js子窗口与父窗口的调用 http://azrael6619.iteye.com/blog/486079
/*
* 打开paypal付款弹窗(请在页面中指定data-url为jq_paypalwpp的值)
*/
function openPaypalWindow() { 
	var paypalNewWindow;  
	var paypalTimer;
	var url = $j('.jq_paypalwpp').data('url');
	var name = 'newPaypalWindow';
	var iWidth = 490;
	var iHeight = 620;
	var iTop = (window.screen.availHeight - 30 - iHeight) / 2; 
	var iLeft = (window.screen.availWidth - 10 - iWidth) / 2; 

	var bodyObject = document.body;
	var divObject = document.createElement('div');
	divObject.className = 'contactuscenwrap';
	bodyObject.appendChild(divObject);
	divObject.style.display = "block";
	divObject.style.height = document.body.clientHeight + 'px';

	paypalNewWindow = window.open(url, name, 'height=' + iHeight + ',innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=yes,titlebar=no'); 
	paypalTimer = setInterval(function() {
		if(paypalNewWindow.closed == true) {
			clearInterval(paypalTimer);
			try {
				if(paypalNewWindow.document != null && typeof(paypalNewWindow.document) != "undefined" && paypalNewWindow.document.getElementById("paypal_payment_message") != null && typeof(paypalNewWindow.document.getElementById("paypal_payment_message")) != "undefined" && paypalNewWindow.document.getElementById("paypal_payment_message").innerHTML != null && typeof(paypalNewWindow.document.getElementById("paypal_payment_message").innerHTML) != "undefined") {
					self.document.getElementById("paypal_payment_box").style.display = "block";
					self.document.getElementById("paypal_payment_message").innerHTML = paypalNewWindow.document.getElementById("paypal_payment_message").innerHTML;
					divObject.style.display = "none";
				} else {
					if(paypalNewWindow.document != null && typeof(paypalNewWindow.document) != "undefined" && paypalNewWindow.document.getElementById("paypal_success_url") != null && typeof(paypalNewWindow.document.getElementById("paypal_success_url")) != "undefined" && paypalNewWindow.document.getElementById("paypal_success_url").value != null && typeof(paypalNewWindow.document.getElementById("paypal_success_url").value) != "undefined") {
						self.location.href = paypalNewWindow.document.getElementById("paypal_success_url").value;
					} else {
						self.location.reload();
					}
					
				}
			} catch(error) {
				self.location.reload();
			}
			return;  
		} 
	}, 1000);
}

function process_json(data){
//	if(typeof(JSON)=='undefined'){
		var returnInfo=eval('('+data+')');
//	}else{
//		var returnInfo=JSON.parse(data);	
//	}
	return returnInfo;
}

function countClicks(click_code){
	$j.post("ajax/ajax_record_count_clicks_to_log.php", {click_code: click_code}, function(data){
		var returnInfo = process_json(data);
		//console.log(returnInfo);
		return returnInfo;
	});
}