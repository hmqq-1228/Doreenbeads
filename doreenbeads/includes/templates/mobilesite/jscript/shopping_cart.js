function get_split_page(){
	var page = '';
	//if($('.split_current_page').length > 0){
		var page = $('.split_current_page').val();
	//}
	return (page != '' ? page : 1);
}

$(function(){
	page = (get_split_page() > 1 ? '&page='+get_split_page() : '');
	
	$('.view_shippping_weight').mouseover(function(){
		$(this).children('.successtips_weight').show();
	}).mouseout(function(){
		$(this).children('.successtips_weight').hide();
	});
	
	function letDivCenterOn(divName){
		var top = ($(window).height() - $(divName).height())/2;
		var left = ($(window).width() - $(divName).width())/2;
		var scrollTop = $(document).scrollTop();
		var scrollLeft = $(document).scrollLeft();
		//	alert(top+"|"+left+"|"+scrollTop+"|"+scrollLeft);
		$(divName).css( { position : 'absolute', 'top' : top - scrollTop/2, left : left + scrollLeft } ).show();
	}	
	$('.empty-btn').click(function() {

		var obj = $(this);
		$.post("./shopping_cart_process.php", {action: 'shopcart_isvalid'},function(data){
			var data = process_json($.trim(data));
			if(data.error > 0) {

				$('.popup_cart_remove p').text(data.message);
				$('.float-show').hide();
				letDivCenter('.jq_shopping_cart_delete_all');
				var bodyHeight=($(document).height()+'px');
				$('body').append('<div class="windowbodyp"></div>');
				$(".windowbodyp").css({"height":bodyHeight});
				$('.windowbodyp').fadeIn();
				$('.jq_del_all_okbtn').click(function() {
					window.location.href = 'index.php?main_page=shopping_cart';
				});

				$('.jq_cancelbtn').click(function() {
					$('.jq_shopping_cart_delete_all').hide();
					$('.jq_shopping_cart_delete_all').removeAttr('style');
					$('.windowbodyp').remove();
				});

			}else{
				if(obj.data('confirm')) {
					$('.popup_cart_remove p').text(obj.data('confirm'));
				}
				$('.float-show').hide();
				letDivCenter('.jq_shopping_cart_delete_all');
				var bodyHeight=($(document).height()+'px');
				$('body').append('<div class="windowbodyp"></div>');
				$(".windowbodyp").css({"height":bodyHeight});
				$('.windowbodyp').fadeIn();
				$('.jq_del_all_okbtn').click(function() {
					window.location.href = 'index.php?main_page=shopping_cart&action=empty';
				});

				$('.jq_cancelbtn').click(function() {
					$('.jq_shopping_cart_delete_all').hide();
					$('.jq_shopping_cart_delete_all').removeAttr('style');
					$('.windowbodyp').remove();
				});
			}
		});


		 
	});
	
	$('.delete-btn').click(function(){
		pid = $(this).parents().find('input[name="product_id"]').val();
		var index_num = $(this).attr('index_num');
		var del_qty = $('#qty_old_'+pid).val();
		$('#delete-pid').val(pid);
		$('#delete-pid').attr('index_num',index_num);
		$('#delete-pid').attr('del_qty',del_qty);

		if($(this).data('confirm')) {
			$('.popup_cart_remove p').text($(this).data('confirm'));
		}
		$('.float-show').hide();
		letDivCenter('.jq_shopping_cart_delete');
		var bodyHeight=($(document).height()+'px');
		$('body').append('<div class="windowbodyp"></div>');
		$(".windowbodyp").css({"height":bodyHeight});
   		$('.windowbodyp').fadeIn();
		$('.jq_shopping_cart_delete').show();
	});

	// 撤销购物车删除20160304
	$('.readd_product').live('click', function() {
		var pro_id = $('.readd_product').attr('data-id');
		var del_qty = $('.readd_product').attr('data-qty');
		window.location.href = 'index.php?main_page=shopping_cart&action=readd&del_qty='+del_qty+'&pid='+pro_id+page;
	});
	
	$('.jq_del_one_okbtn').click(function(){
		pid = $('#delete-pid').val();
		var index_num = $('#delete-pid').attr('index_num');
		var del_qty = $('#delete-pid').attr('del_qty');
		window.location.href = 'index.php?main_page=shopping_cart&action=remove&del_qty='+del_qty+'&index_num='+index_num+'&pid='+pid+page;
	});
	$('.jq_cancelbtn').click(function(){
		$(this).parents('.shopping_cart_bomb').hide();
		$('.windowbodyp').remove();
	});

	$('.jq_addtowishlist').click(function(){
		var pid = $(this).parents().find('input[name="product_id"]').val();
		var qty = $(this).parents().find('input[name="product_qty"]').val();

		if($(this).data('confirm')) {
			$('.popup_cart_remove p').text($(this).data('confirm'));
		}

		$('.float-show').hide();
		letDivCenter('.jq_shopping_cart_add_all_wishlist');
		var bodyHeight=($(document).height()+'px');
		$('body').append('<div class="windowbodyp"></div>');
		$(".windowbodyp").css({"height":bodyHeight});
		$('.windowbodyp').fadeIn();
		$('.jq_add_wishlist_okbtn').click(function() {
			$.post('./shopping_cart_process.php', {action: 'addtowishlist', pid: pid, qty: qty, page: get_split_page()}, function(data){
				window.location.href = 'index.php?main_page=shopping_cart';
			});
		});

		$('.jq_cancelbtn').click(function() {
			$('.jq_shopping_cart_add_all_wishlist').hide();
			$('.jq_shopping_cart_add_all_wishlist').removeAttr('style');
			$('.windowbodyp').remove();
		});
	});

	$('.add_all_wishlist').click(function(){
		var obj = $(this);
		$.post("./shopping_cart_process.php", {action: 'shopcart_isvalid'},function(data){
			var data = process_json($.trim(data));
			if(data.error > 0) {

				$('.popup_cart_remove p').text(data.message);
				$('.float-show').hide();
				letDivCenter('.jq_shopping_cart_delete_all');
				var bodyHeight=($(document).height()+'px');
				$('body').append('<div class="windowbodyp"></div>');
				$(".windowbodyp").css({"height":bodyHeight});
				$('.windowbodyp').fadeIn();
				$('.jq_del_all_okbtn').click(function() {
					window.location.href = 'index.php?main_page=shopping_cart';
				});

				$('.jq_cancelbtn').click(function() {
					$('.jq_shopping_cart_delete_all').hide();
					$('.jq_shopping_cart_delete_all').removeAttr('style');
					$('.windowbodyp').remove();
				});

				
				
			}else{
				
				if(obj.data('confirm')) {
					$('.popup_cart_remove p').text(obj.data('confirm'));
				}
				$('.float-show').hide();
				letDivCenter('.jq_shopping_cart_add_all_wishlist');
				var bodyHeight=($(document).height()+'px');
				$('body').append('<div class="windowbodyp"></div>');
				$(".windowbodyp").css({"height":bodyHeight});
				$('.windowbodyp').fadeIn();
				$('.jq_add_wishlist_okbtn').click(function() {
					$.post('index.php?main_page=shopping_cart&action=mwa', function(data){
						$('.jq_shopping_cart_add_all_wishlist').hide();
						letDivCenter('.jq_shopping_cart_addwishlist');
						var bodyHeight=($(document).height()+'px');
						$('body').append('<div class="windowbodyp"></div>');
						$(".windowbodyp").css({"height":bodyHeight});
						$('.windowbodyp').fadeIn();
						$('.jq_shopping_cart_addwishlist').show();
					});
				});

				$('.jq_cancelbtn').click(function() {
					$('.jq_shopping_cart_add_all_wishlist').hide();
					$('.jq_shopping_cart_add_all_wishlist').removeAttr('style');
					$('.windowbodyp').remove();
				});
			}
		});

		
	});

	//购物车或wishlist页面删除无论商品(单个)
	$(".jq_products_invalid_one").live("click", function() {
		var $this = $(this);
		var customers_basket_id = $this.data("id");
		$.post('ajax/ajax_products_invalid.php',{action:'shopping_cart_delete_one', customers_basket_id:customers_basket_id},function(data){
			var returnInfo = process_json(data);
			if(returnInfo.error == 0) {
				$this.parents("div").filter(":first").parents("div").filter(":first").remove();
				if($(".jq_products_invalid_one").length <= 0) {
					$(".cart_warp").hide();
				}
			}
		});
	});
	//购物车或wishlist页面删除无论商品(所有) 
	$(".jq_products_invalid_all").live("click", function() {
		var title = $(this).data("title");
		
		if(title) {
			$('.popup_cart_remove p').text(title);
		}

		$('.float-show').hide();
		letDivCenter('.jq_shopping_cart_invaild_all');
		var bodyHeight=($(document).height()+'px');
		$('body').append('<div class="windowbodyp"></div>');
		$(".windowbodyp").css({"height":bodyHeight});
		$('.windowbodyp').fadeIn();
		$('.jq_invaild_all_okbtn').click(function() {
			var array = new Array();
			$(".jq_products_invalid_one").each(function(index){
				array.push($(this).data("id"));
			});
			var customers_basket_ids = array.join(",");
			$.post('ajax/ajax_products_invalid.php',{action:'shopping_cart_delete_all', customers_basket_ids:customers_basket_ids},function(data){
				var returnInfo = process_json(data);
				if(returnInfo.error == 0) {
					$(".cart_warp").hide();
					$('.jq_shopping_cart_invaild_all').hide();
					$('.jq_shopping_cart_invaild_all').removeAttr('style');
					window.location.href = 'index.php?main_page=shopping_cart';
				}
			});
		});

		$('.jq_cancelbtn').click(function() {
			$('.jq_shopping_cart_invaild_all').hide();
			$('.jq_shopping_cart_invaild_all').removeAttr('style');
			$('.windowbodyp').remove();
		});
	});
});
/*延时*/
function yanshi(){
	var o = $('input[name="product_qty"], input[name="product_qty[]"], input[name="rp_qty"]');
	if(o.val()<1){
		o.val(o.siblings('input[name="product_qty_old"]').val());
	}
}
$(function(){
	//只允许输入数字
	$('input[name="product_qty"], input[name="product_qty[]"], input[name="rp_qty"]').keydown(function(e){
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

	$('input[name="product_qty"], input[name="product_qty[]"], input[name="rp_qty"]').keyup(function(){
		$(this).val($(this).val().replace(/\D|^0/g,''));
		if($(this).val() < 1){
			if($(this).siblings('input[name="product_qty_old"]').length > 0){
				//original_qty = $(this).siblings('input[name="product_qty_old"]').val();
				setTimeout("yanshi()",1000);
			}else{
				//original_qty = 1;
				//$(this).val($(this).siblings('input[name="product_qty_old"]').val());
				setTimeout("yanshi()",1000);
			}
		}
	});

	$('.jq_products_checked').live('click', function(){
		var type = $(this).data('type');
		var is_checked = 0;
		var customers_basket_id = $(this).val();
		if($(this).attr("checked") == "checked") {
			is_checked = 1;
		}

		if(type == "all") {
			if($(this).attr("checked") == "checked") {
				$('.jq_products_checked').attr('checked', 'checked');
			} else {
				$('.jq_products_checked').removeAttr('checked');
			}
		}

		$.post('./shopping_cart_process.php', {action: 'update_is_checked', type: type, is_checked: is_checked, customers_basket_id:customers_basket_id, page: get_split_page()}, function(data){
			if(typeof(JSON)=='undefined'){
				var returnInfo=eval('('+data+')');
			}else{
				var returnInfo=JSON.parse(data);	
			}
			if(returnInfo.cate_total_arr){	
				$.each(returnInfo.cate_total_arr,function(idx,item){
					$("#cate_total_"+idx).html(item);
				});
			}
			if(returnInfo.error <= 0) {
				var show_weight = returnInfo.show_weight;
				var products_num = returnInfo.products_num;
				var is_checked_count = returnInfo.is_checked_count;
				var show_total_new = returnInfo.show_total_new;		
				var vip_amount = returnInfo.vip_amount;
				var vip_title = returnInfo.vip_title;
				var vip_content = returnInfo.vip_content;
				var current_discount_title = returnInfo.current_discount_title;			
				var current_discount_content = returnInfo.current_discount_content;		
				var shipping_content = returnInfo.shipping_content;
				var shipping_method_by = returnInfo.shipping_method_by;		
				var total_all = returnInfo.total_all;		
				var promotion_discount_usd = returnInfo.promotion_discount_usd;		
				var cal_total_amount_convert = returnInfo.cal_total_amount_convert_mobile;		
				var product_caution = returnInfo.product_caution;
				var special_discount_title = returnInfo.special_discount_title;
				var special_discount_content = returnInfo.special_discount_content;
				var prom_discount = returnInfo.prom_discount;
				var prom_discount_format = returnInfo.prom_discount_format;
				var prom_discount_title = returnInfo.prom_discount_title;
				var prom_discount_note = returnInfo.prom_discount_note;
				var rcd_discount = returnInfo.rcd_discount;
				var show_current_discount = returnInfo.show_current_discount;
				var is_preorder = returnInfo.is_preorder;
				var is_checked_all = returnInfo.is_checked_all;
				var discounts_format = returnInfo.discounts_format;
				var promotion_discount_format = returnInfo.promotion_discount_format;
                var original_prices = returnInfo.original_prices;
                var rcd_discounts = returnInfo.rcd_discounts;
                var handing_fee_format = returnInfo.handing_fee_format;
				var handing_fee = returnInfo.handing_fee;
				var is_handing_fee = returnInfo.is_handing_fee;


                if (is_handing_fee < 0){
                	$('.handing_fee_titles').show();
                	$('.handing_fee_contents').html(handing_fee).show();
                }else{
                	$('.handing_fee_titles').hide();
                	$('.handing_fee_contents').hide();
                };
                $('.rcd_contents').html(rcd_discounts);
                $('.discount_content').html(discounts_format);
                $('.promotion_discount_content').html(promotion_discount_format);
				$('.jq_total_weight').text(show_weight);
				$('.jq_total_items').html(products_num);
				$('.jq_is_checked_count').html(is_checked_count);
				$('.subtotal_amount').html(show_total_new);
				$('.total_amount_original').html(original_prices);
				//$('.vip_amount').html(vip_amount);
				$('.shipping_content').html(shipping_content);
				$('.shippingMethodDd').html(shipping_method_by);
				$('.discountcoupon').html(current_discount_title);
				$('.discountcoupon_content').html(current_discount_content);
				$('.total_amount').html(total_all);
				if ( promotion_discount_usd > 0 ) {
					$('.cal_total_amount_convert').html(cal_total_amount_convert);
				};			
				$('.special_discount_title').html(special_discount_title);
				$('.special_discount_content').html(special_discount_content);			
				$('.promotion_discount_full_set_minus_title').html(returnInfo.full_set_minus_title);
				$('.promotion_discount_full_set_minus_content').html(returnInfo.full_set_minus_content);
				if (prom_discount_note != '') {
					$('.prompt').html(prom_discount_note).show();
				}else{
					$('.prompt').hide();
				}
				

				if(vip_amount && vip_amount != '0.00'){
					$('.vip_title').html(vip_title).show();
					$('.vip_content').html(vip_content).show();
				}else{
					$('.vip_title').hide();
					$('.vip_content').hide();
				}

				if (rcd_discount && rcd_discount > 0) {
					$('.rcd_content').html('(-) '+show_current_discount).show();
					$('.rcd_title').show();
				}else{
					$('.rcd_title').hide();
					$('.rcd_content').hide();
				};	

				if (prom_discount && prom_discount > 0) {
					$('.promotion_title').html(prom_discount_title).show();
					$('.promotion_discount span').html(prom_discount_format);
					$('.promotion_discount').show();
				}else{
					$('.promotion_title').hide();
					$('.promotion_discount').hide();
				};
                
				if(is_checked_all == 1) {
					$('.jq_products_checked').attr('checked', 'checked');
				} else {
					$('.jq_products_checked_all').removeAttr('checked');
				}
			} else {
				alert(returnInfo.message);
			}
			
			
		});
	});

	$('.jq_checkbtn').live('click', function(){
		var obj = $(this);
		$.post("./shopping_cart_process.php", {action: 'shopcart_isvalid'},function(data){
			var data = process_json($.trim(data));
			if(data.error > 0) {

				$('.popup_cart_remove p').text(data.message);
				$('.float-show').hide();
				letDivCenter('.jq_shopping_cart_delete_all');
				var bodyHeight=($(document).height()+'px');
				$('body').append('<div class="windowbodyp"></div>');
				$(".windowbodyp").css({"height":bodyHeight});
				$('.windowbodyp').fadeIn();
				$('.jq_del_all_okbtn').click(function() {
					window.location.href = 'index.php?main_page=shopping_cart';
				});

				$('.jq_cancelbtn').click(function() {
					$('.jq_shopping_cart_delete_all').hide();
					$('.jq_shopping_cart_delete_all').removeAttr('style');
					$('.windowbodyp').remove();
				});
				
			}else{
				window.location.href = obj.data('url');
			}
		});		
		
	});
	
	$('.cart_plus_icon').click(function(){
		_thisVal = parseFloat($(this).prev().val());
		pid = $(this).siblings('input[name="product_id"]').val();
		if(isNaN(_thisVal) || _thisVal == 99999){
			return false;
		}
		$(this).siblings('.cart_decrease_icon').removeClass('gray');
		update_qty = _thisVal + 1;
		if (update_qty >= 99999) {$(this).addClass('gray')};
		$(this).prev().val(update_qty);
		update_product_qty(pid, update_qty);
	});
	
	$('.qty_content').blur(function(){
		_thisVal = parseFloat($(this).val());
		_thisOval = parseFloat($(this).siblings('input[name="product_qty_old"]').val());
		pid = $(this).siblings('input[name="product_id"]').val();
		if(_thisVal != _thisOval){
			if(isNaN(_thisVal) || _thisVal <= 0){
				return false;
			}
			update_product_qty(pid, _thisVal);
		}
	});
	
	$('.cart_decrease_icon').click(function(){
		num = $(this).next().val();
		pid = $(this).siblings('input[name="product_id"]').val();
		if(num <= 1) {
			return false;
		}else{
			update_qty = num - 1;
			$(this).siblings('.cart_plus_icon').removeClass('gray');
			if (update_qty <= 1) {$(this).addClass('gray')};
			$(this).next().val(update_qty);
			update_product_qty(pid, update_qty);
		}
	});
	
	$('.rp_btn').click(function(){
		_thisVal = $(this).siblings('input[name="rp_qty"]').val();
		_thisOval = $(this).siblings('input[name="rp_oqty"]').val();
		pid = $(this).siblings('input[name="rp_pid"]').val();
		if(_thisVal != _thisOval){
			if(isNaN(_thisVal) || _thisVal <= 0){
				return false;
			}
			update_product_qty(pid, _thisVal);
		}
	});
	
	function update_product_qty(pid, num){
		new_qty = num;
		$('.float-show').hide();
		//$('.addsuccess-tip').html('<img src="includes/templates/mobilesite/images/loadbig.gif">').show();
        
		//letDivCenter('.addsuccess-tip');
		if(typeof(timeout) == 'number'){
			clearTimeout(timeout);
		}
		$.post('./shopping_cart_process.php', {action: 'update_qty', pid: pid, qty: new_qty, page: get_split_page()}, function(data){	
			if(typeof(JSON)=='undefined'){
				var returnInfo=eval('('+data+')');
			}else{
				var returnInfo=JSON.parse(data);	
			}
			if(returnInfo.cate_total_arr){	
				$.each(returnInfo.cate_total_arr,function(idx,item){
					$("#cate_total_"+idx).html(item);
				});
			}
			var product_id = returnInfo.product_id;			
			var product_qty = returnInfo.product_qty;		
			var product_price = returnInfo.product_price;			
			var product_oprice = returnInfo.product_oprice;		
			var product_total = returnInfo.product_total;
			var show_weight = returnInfo.show_weight;
			var show_total_new = returnInfo.show_total_new;
			var vip_amount = returnInfo.vip_amount;
			var vip_title = returnInfo.vip_title;
			var vip_content = returnInfo.vip_content;
			var current_discount_title = returnInfo.current_discount_title;			
			var current_discount_content = returnInfo.current_discount_content;		
			var shipping_content = returnInfo.shipping_content;
			var shipping_method_by = returnInfo.shipping_method_by;		
			var total_all = returnInfo.total_all;		
			var promotion_discount_usd = returnInfo.promotion_discount_usd;		
			var cal_total_amount_convert = returnInfo.cal_total_amount_convert_mobile;		
			var product_caution = returnInfo.product_caution;
			var special_discount_title = returnInfo.special_discount_title;
			var special_discount_content = returnInfo.special_discount_content;
			var prom_discount = returnInfo.prom_discount;
			var prom_discount_format = returnInfo.prom_discount_format;
			var prom_discount_title = returnInfo.prom_discount_title;
			var prom_discount_note = returnInfo.prom_discount_note;
			var rcd_discount = returnInfo.rcd_discount;
			var show_current_discount = returnInfo.show_current_discount;
			var is_preorder = returnInfo.is_preorder;
			var is_preorder_tip_mobile = returnInfo.is_preorder_tip_mobile;
			var pp_max_num_per_order = returnInfo.pp_max_num_per_order;
			var max_num_per_order_tips = returnInfo.max_num_per_order_tips;
	        var discounts_format = returnInfo.discounts_format;
	        var discounts_formats = returnInfo.discounts_formats;
			var promotion_discount_format = returnInfo.promotion_discount_format;
			var original_prices = returnInfo.original_prices;
            var rcd_discounts = returnInfo.rcd_discounts
            var handing_fee_format = returnInfo.handing_fee_format;
			var handing_fee = returnInfo.handing_fee;
			var is_handing_fee = returnInfo.is_handing_fee;

			
            if (is_handing_fee < 0){
            	$('.handing_fee_titles').show();
            	$('.handing_fee_contents').html(handing_fee).show();
            }else{
            	$('.handing_fee_titles').hide();
            	$('.handing_fee_contents').hide();
            };
            $('.rcd_contents').html(rcd_discounts);

            if (discounts_formats > 0){
				   $('.discount_title').show();
                   $('.discount_content').html(discounts_format).show();
            }else{
                   $('.discount_title').hide();
                   $('.discount_content').hide();
                   $('.image_down_arrow').hide();
            };
            $('.promotion_discount_content').html(promotion_discount_format);
			$('.price_'+product_id).html(product_price);
			if ( (product_qty > pp_max_num_per_order) && pp_max_num_per_order > 0 ) {
				$('.jq_show_promotiom_tips_'+product_id).text(max_num_per_order_tips).show();
				$('.oprice_'+product_id).html(product_oprice).hide();
				$('.oprice_'+product_id).parent().hide();
			}else{
				$('.jq_show_promotiom_tips_'+product_id).hide();
				if (product_price != product_oprice) {
					$('.oprice_'+product_id).html(product_oprice).show();
					$('.oprice_'+product_id).parent().show();
				};				
			}
            
			//$('.oprice_'+product_id).html(product_oprice);
			$('.total_'+product_id).html(product_total);
			$('.jq_total_weight').html(show_weight);
			$('.subtotal_amount').html(show_total_new);
			$('.total_amount_original').html(original_prices);
			//$('.vip_amount').html(vip_amount);
			$('.shipping_content').html(shipping_content);
			$('.shippingMethodDd').html(shipping_method_by);
			$('.discountcoupon').html(current_discount_title);
			$('.discountcoupon_content').html(current_discount_content);
			$('.total_amount').html(total_all);
			if ( promotion_discount_usd > 0 ) {
				$('.cal_total_amount_convert').html(cal_total_amount_convert);
			};			
			$('.special_discount_title').html(special_discount_title);
			$('.special_discount_content').html(special_discount_content);			
			$('.promotion_discount_full_set_minus_title').html(returnInfo.full_set_minus_title);
			$('.promotion_discount_full_set_minus_content').html(returnInfo.full_set_minus_content);
			if (prom_discount_note != '') {
				$('.prompt').html(prom_discount_note).show();
			}else{
				$('.prompt').hide();
			}
			

			if(vip_amount && vip_amount != '0.00'){
				$('.vip_title').html(vip_title).show();
				$('.vip_content').html(vip_content).show();
			}else{
				$('.vip_title').hide();
				$('.vip_content').hide();
			}

			if (rcd_discount && rcd_discount > 0) {
				$('.rcd_content').html('- '+show_current_discount).show();
				$('.rcd_title').show();
			}else{
				$('.rcd_title').hide();
				$('.rcd_content').hide();
			};	

			if (prom_discount && prom_discount > 0) {
				$('.promotion_title').html(prom_discount_title).show();
				$('.promotion_discount span').html(prom_discount_format);
				$('.promotion_discount').show();
			}else{
				$('.promotion_title').hide();
				$('.promotion_discount').hide();
			};			
			if(num != product_qty){
				$('#qty_'+product_id).val(product_qty);
			}
			$('#qty_old_'+product_id).val(product_qty);
			$('.rp_qty_'+product_id).val(product_qty);
			$('.rp_oqty_'+product_id).val(product_qty);

			if(is_preorder_tip_mobile != null || is_preorder != 0) {
				$('.jq_is_preorder_' + product_id).html(is_preorder_tip_mobile);
			} else {
				$('.jq_is_preorder_' + product_id).html('');
			}
			if(product_caution != null){
				$('.jq_qty_update_tips_'+product_id).html(product_caution).show();
			} else {
				$('.jq_qty_update_tips_'+product_id).hide();
			}
		});
	}
	
	$('.shipmethod-list ins').click(function(){
		
		if($(this).attr('class') == "opentips"){
			$(this).attr('class','closetipsbtn');
		}else{
		    $(this).attr('class','opentips');	
		}

		$(this).next('.shiptips').toggle();
		
	});

		
	$('.discountcoupon').click(function(){
		$('.discounttips').toggle();
	});	
	
	$('.pricetipsicon').click(function(){
		$('.pricetipscont').toggle();
		if($('.pricetipsicon').hasClass('opentips')){
			$('.pricetipsicon').removeClass('opentips').addClass('closetipsbtn');
		}else{
			$('.pricetipsicon').removeClass('closetipsbtn').addClass('opentips');
		}	
	});
	
	$.post('./shopping_cart_process.php', {action: 'cal', page: get_split_page()}, function(data){
		var data = process_json($.trim(data));
		var shipping_info = process_json($.trim(data.shipping_content_str));
		$('.shipping_content').html(shipping_info[0]);
		$('.shippingMethodDd').html(shipping_info[1]);
		
		$('.special_discount_title').html(shipping_info[2]);
		$('.special_discount_content').html(shipping_info[3]).show();
		$('.vip_content').html(shipping_info[4]);
		
		if(shipping_info[4]){
			;$('.vip_title').html(shipping_info[5]);
		}else{
			$('.vip_title').html('')
		}
		
		if(shipping_info[7]){
			$('.promotion_discount_full_set_minus_title').html(shipping_info[6]);
			$('.promotion_discount_full_set_minus_content').html(shipping_info[7]);
		}
		
		$('.total_amount').html(data.total_amount);
	});
	
});

function move_all_to_wishlist(){
	window.location.href = 'index.php?main_page=login';
}

//bof common login select country
$(document).ready(function(){

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
            var num = $('.country_select_drop').index($(this).parent().parent());
            var cListId=$(this).attr('clistid');


            var cText=$(this).text();
            var cId=$(this).attr('id');
            cIdArr=cId.split('_');
            getCId=cIdArr[2];
            $('.choose_single span').text(cText);
            $('#country_name').val(cListId); //used in address_book page 
      
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

	
	
	

	$('.closetips').click(function(){$('.shiptips').hide();});
	
	$('.sc_sort').change(function(){
    	var clickFun = function(type, type1){
	        aCont = [];
	        var sortby = type;
	        var sortby1 = type1;
	        fSetDivCont(sortby, sortby1);
	    }
		var fSetDivCont = function(sortby, sortby1){
			$('.shipmethod-list tr').each(function() {
				var trCont = parseFloat($(this).find('.'+sortby).val() * 10000) + parseFloat($(this).find('.'+sortby1).val());
				aCont.push(trCont);			
			});
	    }
		var compare_down = function(a,b){
			return a-b;
	    }
	   
	    var compare_up = function(a,b){
			return b-a;
	    }
	   
	    var fSort = function(compare){
	        aCont.sort(compare);
	    }
		var setTrIndex = function(sortby, sortby1){
			obj = [];
	        for(i=0;i<aCont.length;i++){
	            var trCont = aCont[i];
	            $('.shipmethod-list tr').each(function() {
					var thisText = parseFloat($(this).find('.'+sortby).val() * 10000) + parseFloat($(this).find('.'+sortby1).val());
	                if(thisText == trCont){
						obj.push($(this));
	                }
				});       
	        }
			for(i=0;i<obj.length;i++){
				$('.shipmethod-list').append(obj[i]);
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
    
    $('.shipmethod-list input').click(function(){
    	
		$('.shipmethod-list tr').removeClass('selected');
		$(this).parents('tr').addClass('selected');
			
		
	/*	var a = $('.shipmethod-list tr').eq(0);
		var b = $(this).parents('tr');
		
		if(b.index() == 0){
			
		}else{
			b.insertBefore(a); 
		}*/
   /* 	var a = $('#w ');
    	var e = $('#e');
    	var d = $('#w tr');

    	if(d.length>0){
    		
    		d.append(e);
    		a.html("");
    	}
    	
    	$('.shipmethod-list tr').removeClass('selected');
    	var b = $(this).parents('tr');
    	
    	b.addClass('selected');			
    	a.append(b);	*/	
	
		
		/*it doesn"t work actually*/
		var	shipping_method = $(this).parent().next().text();
		document.cookie =  "shipping_method_selected" + "=" + shipping_method ;
	
		code = $(this).val();
		$.post('./ajax_checkout.php', {action: 'change_shipping', code: code}, function(data){});
		
		$.post('./shopping_cart_process.php', {action: 'radio', shipping_code: code}, function(data){});
				
	});
/*  function shiptr(){
    	$('.shipmethod-list tr').each(function(){ 
    		if($(this).index()>4){ 
    			$(this).hide();
    		}
    	});
    }		
    shiptr();	
	$('.morecont').click(function(){
		$('.shipmethod-list tr').show();
		$(this).hide();
		$('.lesscont').show();
		$('.ship-type').show();
	});	
    $('.lesscont').click(function(){
    	shiptr();
    	$(this).hide();
    	$('.morecont').show();
    	$('.ship-type').hide();
    });	
    
    $('.shipmethod-list tr').each(function(k,v){
    	if($(this).hasClass('selected')){
    		
    	}   	
    });
*/
    

});


// shopping view details for expired products
$(function(){
	$(document).on('click', '.removealltips .btn_close', function(){
		$('.removealltips  p').hide();
		$('.removealltips .btn_close').hide();
		$('.removealltips .btn_show').show();
	});
	$(document).on('click', '.removealltips .btn_show', function(){
		$('.removealltips  p').show();
		$('.removealltips .btn_show').hide();
		$('.removealltips .btn_close').show();
	});

	//	bof change page of items
	$('.invalid_items_fen_ye div.page a').live('click',function(){
		var page=$(this).attr('pageid');
		$.post('shopping_cart_process.php',{
				action:"invalid_items_fenye",page:page
			},function(data){
				var data = process_json($.trim(data));
				$('.cart_invalid_items').html(data.invalid_items_str);
				$('.invalid_items_fen_ye').html(data.invalid_items_fen_ye);
			
		});
	});
	//	eof change page of items
});