function get_split_page(){
	var page = $('.split_current_page').val();
	return (page != '' ? page : 1);
}
$(function () {
	// order filter
	$('.orderSearchFormShow').click(function(){
		if ($('.orderSearchForm').css('display') == 'none') {
			$('.orderSearchForm').show();
		}else{
			$('.orderSearchForm').hide();
		};
	});

	//购物车或wishlist页面删除无论商品(单个)
	$(".jq_products_invalid_one").live("click", function() {
		var $this = $(this);
		var wl_id = $this.data("id");
		$.post('ajax/ajax_products_invalid.php',{action:'wishlist_delete_one', wl_id:wl_id},function(data){
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
		if(confirm(title)){
			var array = new Array();
			$(".jq_products_invalid_one").each(function(index){
				array.push($(this).data("id"));
			});
			var wl_ids = array.join(",");
			$.post('ajax/ajax_products_invalid.php',{action:'wishlist_delete_all', wl_ids:wl_ids},function(data){
				var returnInfo = process_json(data);
				if(returnInfo.error == 0) {
					$(".cart_warp").hide();
				}
			});
		}
	});

	//心愿单添加购物车
	$('.jq_wishlist_addcart').on('click',function(){
		var $this = $(this);
		//$('.addsuccess-tip').html('').hide();
		var pid = $(this).parent().siblings('.pro_right').find('input[name="product_id"]').val();
		var qty = $(this).parent().siblings('.pro_right').find('input[name="product_qty"]').val();
		/*if(typeof(t) == 'number'){
			clearTimeout(t);
		}*/

		$.post("./addcart.php", {productid: pid, number: qty, action: 'order_detail_add'}, function(data){
			if(data.length >0) {
				if(data == 'soldout'){
					$this.removeClass('jq_wishlist_addcart link_text').text(js_lang.TEXT_CANNOT_ADDED).css({'color': 'black', 'font-size': '14px'});
				}else{
					var dataarr = new Array();
					dataarr = data.split("|");
					if(dataarr[2] != ''){
						$this.text(dataarr[2]);
						$this.removeClass('jq_wishlist_addcart link_text').text(js_lang.TEXT_CANNOT_ADDED).css({'color': 'black', 'font-size': '14px'});
					}else{
						$this.removeClass('jq_wishlist_addcart link_text').text(js_lang.TEXT_ADDED).css({'color': 'black', 'font-size': '14px'});
					}
				}				
			}
		});
	});

	// 心愿单删除
	$('.jq_wishlist_remove').click(function(){
		var pid = $(this).parent().siblings('.pro_right').find('input[name="product_id"]').val();
		$('#delete-pid').val(pid);

		if($(this).data('confirm')) {
			$('.popup_cart_remove p').text($(this).data('confirm'));
		}
		$('.float-show').hide();
		letDivCenter('.jq_wishlist_delete');
		var bodyHeight=($(document).height()+'px');
		$('body').append('<div class="windowbodyp"></div>');
		$(".windowbodyp").css({"height":bodyHeight});
   		$('.windowbodyp').fadeIn();
		$('.jq_wishlist_delete').show();
	});

	$('.jq_del_one_okbtn').click(function(){
		var page = (get_split_page() > 1 ? '&page='+get_split_page() : '');
		pid = $('#delete-pid').val();
		window.location.href = 'index.php?main_page=wishlist&action=remove&product_id='+pid+page;
	});

	$('.jq_cancelbtn').click(function(){
		$(this).parents('.jq_wishlist_delete').hide();
		$('.windowbodyp').remove();
	});

	$(document).on('click', '.wishlist_page .ajax_page_link', function(){
		if ($(this).hasClass('page_grey')) {
			return false;
		};
		var nextPage = $(this).attr('page');

		$.post("ajax/ajax_products_invalid.php", {action:'wishlist_invalid_split', nextPage: nextPage}, function(data){ 
			var returnInfo = process_json(data);
			$('.cart_invalid .cart_invalid_items').html(returnInfo['return_html']);
			$('.invalid_items_fen_ye .page').html(returnInfo['return_fenye']);
		});
	});

	//coupon add
	$('.jq_coupon_add').click(function(){
		var code = $.trim($("#add_coupon_code").val());
		$(".message_tips").html("");

		if (code == '') {
			return false;
		};

		$.post('index.php?main_page=my_coupon',{action:'add_coupon',code:code}, function(data){
			var returnInfo = process_json(data);
			//console.log(returnInfo);
			
			if(returnInfo.is_error){
				$(".message_tips").html(returnInfo.error_info).show();
			}else{
				$('.message_tips').html(returnInfo.success_info).show();
				setTimeout(function(){window.location.reload();}, 1000);
			}
		});
		
		return false;
	});

	// coupon select
	$('.jq_show_cpStatus').on('click', function(){
		if($('.currency_on').css('display') == 'none'){
			$('.currency_on').show();
		}else{
			$('.currency_on').hide();
		}
	});

	// coupon split
	$(document).on('click', '.coupon_add .ajax_page_link', function(){
		if ($(this).hasClass('page_grey')) {
			return false;
		};
		var nextPage = $(this).attr('page');
		var cp_status = $('.jq_show_cpStatus').data('status');console.log(cp_status);

		$.post("index.php?main_page=my_coupon", {action:'coupon_split', nextPage: nextPage, cp_status: cp_status}, function(data){ 
			var returnInfo = process_json(data);
			console.log(returnInfo);
			$('.coupon_list').html(returnInfo['return_html']);
			$('.page').html(returnInfo['return_fenye']);
		});
	});

	// packing slip filter
	$('.packingSearchFormShow').click(function(){
		if ($('.packingSearchForm').css('display') == 'none') {
			$('.packingSearchForm').show();
		}else{
			$('.packingSearchForm').hide();
		};
	});
});