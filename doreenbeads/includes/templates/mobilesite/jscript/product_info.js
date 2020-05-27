$(function(){
	$('.qty_plus').click(function(){
		num = parseFloat($(this).siblings('.addToCart').val());
		$(this).siblings('.addToCart').val(num + 1);
	});
	$('.qty_down').click(function(){
		num = parseFloat($(this).siblings('.addToCart').val());
		if(num > 1){
			$(this).siblings('.addToCart').val(num - 1);
		}
	});
	
	$('.updatecart').click(function(){
		if(typeof(t) == 'number') {
			clearTimeout(t);
		}
		pid = $(this).siblings('.product_id').val();
		num = parseFloat($('#pid_' + pid).val());
		onum = parseFloat($('#incart_' + pid).val());
		if(num == onum && onum > 0){
			return false;
		}
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
					}else if(datearr[1]>0){
						$(".addsuccess-tip").html(js_lang.SuccessAddcart);
						letDivCenter('.addsuccess-content');
						$('.addsuccess-content').show();
						t = setTimeout(function(){$('.addsuccess-content').hide();},3000);
					}
				}
			});
		}
	});
	
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
	$('.addwishilist-btn').click(function(){
		if(typeof(t) == 'number') clearTimeout(t);
		productid = $(this).siblings('.product_id').val();
		number = parseFloat($('#pid_' + productid).val());
		$.post("./addwishlist.php", {productid: ""+productid+"",number: ""+number+""}, function(data){
			if(data.length > 0) {
				var datearr = new Array();
				datearr = data.split("|");
				if(parseInt(datearr[0]) == 1){	// no login
					$(".addsuccess-tip").html(js_lang.LoginToOperation);
				}else if(parseInt(datearr[0]) == 2){	//	exist
					$(".addsuccess-tip").html(js_lang.HasInWishlist);				
				}else if(parseInt(datearr[0]) == 3){	//	success		
					$(".addsuccess-tip").html(js_lang.SuccessAddWishlist);
				}
				letDivCenter('.addsuccess-content');
				$('.addsuccess-content').show();
				t = setTimeout(function(){$('.addsuccess-content').hide();},3000);
			}
		});
	});
	
	$('.restock_notification').click(function(){
		if(typeof(t) == 'number') clearTimeout(t);
		productid = $(this).siblings('.product_id').val();
		$.post("restock_notification.php", {pid: ""+productid+""}, function(data){			
			if(data.length >0) {
				if(data == 0){
					$(".addsuccess-tip").html(js_lang.LoginToOperation);
				}else{
					$(".addsuccess-tip").html(js_lang.SuccessSubscribed);
				}
				letDivCenter('.addsuccess-content');
				$('.addsuccess-content').show();
				t = setTimeout(function(){$('.addsuccess-content').hide();},3000);
			}
		});
	});
	
	$('.matching_content').children('ul').children('li').each(function(index){
		if(index > 3) $(this).addClass('displaynone');
	});
	$('.also_like_content').children('ul').children('li').each(function(index){
		if(index > 3) $(this).addClass('displaynone');
	});
	$('.also_purchased_content').children('ul').children('li').each(function(index){
		if(index > 3) $(this).addClass('displaynone');
	});
	$('p.viewmore').click(function(){
		var i = 0;
		var diaplay = false;
		$(this).parent('div.dlgallery').children('ul').children('li').each(function(index){
			if($(this).hasClass('displaynone') && i < 4){
				$(this).removeClass('displaynone');
				i++;
			}
		});
		$(this).parent('div.dlgallery').children('ul').children('li').each(function(index){
			if($(this).hasClass('displaynone')){
				diaplay = true;
			}
		});
		if(!diaplay) {
			$(this).addClass('displaynone');
		}
	});
	
	//只允许输入数字
	$('.addToCart, .addcart_qty_input').keydown(function(e){
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
	}).focus(function() {
		this.style.imeMode='disabled';   // 禁用输入法,禁止输入中文字符
	});
	
	$('#product_reviews_box').on('click','.btn_review_detail_toggle',function(){
		var iconToggleObj = $('#product_reviews_box .icon_toggle');
		var detailObj = $('#product_reviews_box .reviews_sub_info');
		if(iconToggleObj.is('.icon_arrow_up'))
		{
			detailObj.show();
			iconToggleObj.removeClass('icon_arrow_up').addClass('icon_arrow');
		}
		else
		{
			detailObj.hide();
			iconToggleObj.removeClass('icon_arrow').addClass('icon_arrow_up');
		}
		
		return false;
	});

	$('#product_reviews_box').on('click','.ajax_page_link',function(){
		var jsonData = {product_id:$('#product_id').val(),page:$(this).attr('page')}
		
		$.post("ajax_product_review.php", jsonData, function(data){ 
			$('#product_reviews_box').html(data);
			
			$('#product_reviews_box .btn_review_detail_toggle').click();
		});
		
		return false;
	});

	//	图片轮播
	$('#myCarousel').carousel();
	$('#myCarousel').hammer().on('swipeleft', function(event){
		$(this).carousel('next');
		event.stopPropagation();
	}).on('swiperight', function(event){
		$(this).carousel('prev');
		event.stopPropagation();
	});

	//	其他包装
	$("#pro_detail_otherpackage").on("click", function(){
		var $this = $(this);
		$this.find("ul").toggle();
	});

	//	more 按钮
	$(".btn_more").on("click", function(){
		var $this = $(this),
			$prev = $this.prev();
		$prev.find("li:hidden").show();
		$this.hide();
	});

	$(".jq_products_multi_design_left").click(function(){
		var parent = $(this).parents("div").filter(":first");
		if(parent.find(".jq_products_multi_design_right").hasClass("right_arrow_grey")){
			parent.find(".jq_products_multi_design_right").removeClass("right_arrow_grey");
			parent.find(".jq_products_multi_design_right").addClass("right_arrow");    
		}
		if($(this).hasClass("left_arrow")){
			var num=1;
			var w = parseInt(parent.find("li").css("width")) + parseInt(parent.find("li").css("margin-right"));	
			var tw = w * parent.find("li").length;
			if(!parent.find("ul.jq_products_multi_design_ul").is(":animated")){
				var marLeft = parseInt(parent.find("ul.jq_products_multi_design_ul").css("margin-left"));		
				var l = marLeft + w * num;
				if(l >= 0){
					l = 0;
					parent.find(".jq_products_multi_design_left").removeClass("left_arrow");
					parent.find(".jq_products_multi_design_left").addClass("left_arrow_grey");
				}	
				parent.find("ul.jq_products_multi_design_ul").animate({marginLeft: l+"px"}, 200);	
			}	
	 	}
	});
	
	$(".jq_products_multi_design_right").click(function(){
		var parent = $(this).parents("div").filter(":first");
		if(!parent.find(".jq_products_multi_design_left").hasClass("left_arrow")){
			parent.find(".jq_products_multi_design_left").removeClass("left_arrow_grey");
			parent.find(".jq_products_multi_design_left").addClass("left_arrow");
		}
		if(!$(this).hasClass("right_arrow_grey")){
			var num=1;
			var w = parseInt(parent.find("li").css("width")) + parseInt(parent.find("li").css("margin-right"));
			var tw = w*parent.find("li").length;
			if(!parent.find("ul.jq_products_multi_design_ul").is(":animated")){
				var marLeft = parseInt(parent.find("ul.jq_products_multi_design_ul").css("margin-left"));					
				var l = marLeft - w * num;
				parent.find("ul.jq_products_multi_design_ul").animate({marginLeft: l+"px"}, 200);
				if(-marLeft >= tw - w * num * 5){
					parent.find(".jq_products_multi_design_right").addClass("right_arrow_grey");
				}
			}
		}
	});
});