$(function(){
	function initbox(){
		$('.review-box').each(function(){
			var box = $(this);
			if(box.index() > 19){
				box.addClass('none');
			}
		});
	}
	initbox();
	$('.itemshow').click(function(){
		if($(this).attr('class') == 'itemshow'){
			$(this).attr('class','itemhide');
			$('.review-box.none').removeClass('none');
		}else{
			$(this).attr('class','itemshow');
			initbox();
		}
	});
	
	$('.propagelist a').live('click', function(){
		if(!$(this).hasClass('current')){
			page = $(this).html();
			order_id = $('#order_id').html();
			if(isNaN(page)){
				page = $(this).attr('pageid');
			}
			$.post('./ajax_checkout.php', {action:'split_order_detail', page: page, order_id: order_id}, function(data){
				$('.review-boxcont').html(data);
			});
		}
		return false;
	});


	$('.cart-button').live('click', function(){
		var $this = $(this);
		//$('.addsuccess-tip').html('').hide();
		var pid = $(this).siblings('input[name="product_id"]').val();
		var qty = $(this).siblings('input[name="product_qty"]').val();
		/*if(typeof(t) == 'number'){
			clearTimeout(t);
		}*/

		$.post("./addcart.php", {productid: pid, number: qty, action: 'order_detail_add'}, function(data){
			if(data.length >0) {
				if(data == 'soldout'){
					$this.removeClass('cart-button link_text').text(js_lang.TEXT_CANNOT_ADDED).css({'color': 'black', 'font-size': '14px'});
				}else{
					var dataarr = new Array();
					dataarr = data.split("|");
					if(dataarr[2] != ''){
						$this.text(dataarr[2]);
						$this.removeClass('cart-button link_text').text(js_lang.TEXT_CANNOT_ADDED).css({'color': 'black', 'font-size': '14px'});
					}else{
						$this.removeClass('cart-button link_text').text(js_lang.TEXT_ADDED).css({'color': 'black', 'font-size': '14px'});
					}
				}				
			}
		});
	});
	
	$('.successtips_collect_close').live('click', function(){
		if(typeof(t) == 'number'){
			clearTimeout(t);
		}
		$('.addsuccess-tip').hide();
	});
	
	$('.quick_reorder').click(function(){
		var order_id = $(this).attr('oid');
		$.post('./ajax_quick_reorder.php', {order_id: order_id}, function(data){
			if($.trim(data) != '' && data.length > 1 ){
				letDivCenter('.jq_order_history_tips');
				$('.jq_order_history_tips .popup_products_tips p').html(data);
				$('.jq_order_history_tips').show();
			}else{
				window.location.href = 'index.php?main_page=shopping_cart';
			}			
		});
	});

	$('.jq_order_history_tips .jq_cancelbtn').click(function() {
		$('.jq_order_history_tips').hide();
		window.location.href = 'index.php?main_page=shopping_cart';
	});

	$(document).on('click', '.page .ajax_page_link', function(){
		if ($(this).hasClass('page_grey')) {
			return false;
		};
		var nextPage = $(this).attr('page');
		order_id = $('#current_order_id').val();

		$.post("ajax_order_products_review_split.php", {action:'mobile', nextPage: nextPage, order_id: order_id}, function(data){ 
			var returnInfo = process_json(data);
			$('.shopcart_ul').html(returnInfo['return_html']);
			$('.jq_detail_items .page').html(returnInfo['return_fenye']);
		});
	});

	$('.jq_show_payment_li li').click(function(){
		if ($(this).find('.payment_show').is(":hidden")){
			$('.payment_show').hide();
			$(this).find('.payment_show').show();
			$(this).find('.payment_show input[type="radio"]').attr('checked');
		}
	});
	
	$('.methodlist li label').click(function(){
		$('.submethods').hide();
		$(this).next('.submethods').show();
		var ttop = $(this).offset().top;
		$(window).scrollTop(ttop-20);
	});
			
	$('.methodlist li input[type="radio"]').click(function(){
		$('.submethods').hide();
		$(this).parent('li').find('.submethods').show();
		var ttop = $(this).offset().top;
		$(window).scrollTop(ttop-20);
	});
	
	//bof common login select country
	$(document).ready(function(){
		$('.choose_single').click(function(){
			var select_drop = $(this).next('.country_select_drop');
			var cSelectId = $(this).parent().siblings('#cSelectId');
			var cListNum = select_drop.children().find("#country_list_"+cSelectId.val());
			var cListItem = select_drop.children('ul').children('.country_list_item')

			var ifshow=select_drop.css('display');
			current=$(this).parent().siblings("#cSelectId").val();
			if(ifshow=="none"){
				select_drop.show();
				$(this).removeClass('choose_single_focus');
				$(this).addClass('choose_single_click');
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
				$(this).removeClass('choose_single_click');
				$(this).addClass('choose_single_focus');
			}
		})

		$('.country_list_item').hover(function(){
			$(this).addClass('country_list_item_hover');
			$(this).removeClass('country_list_item_selected');
		},function(){
			$(this).removeClass('country_list_item_hover');
		})	

		$('.country_list_item').click(function(){
			var choose_single = $(this).parent().parent().siblings('.choose_single');
			var cListId=$(this).attr('clistid');
			var cText=$(this).text();
			var cId=$(this).attr('id');
			cIdArr=cId.split('_');
			getCId=cIdArr[2];
			choose_single.children('span').text(cText);
			choose_single.parent().siblings('#cSelectId').prev('input').val(cListId);
			choose_single.parent().siblings('#cSelectId').val(getCId);
			$(this).addClass('country_list_item_selected');
			choose_single.siblings('.country_select_drop').hide();
			
			choose_single.removeClass('choose_single_click');
			choose_single.addClass('choose_single_focus');
			choose_single.focus();
		})	

		$('.choose_single').blur(function(){
			$(this).removeClass('choose_single_focus');
		})

		$('.choose_search input').keyup(function(){
			inputVal=$(this).val();
			inputVals=inputVal.replace(/^\s*|\s*$/g, "");
			if(inputVals!=''){
				$(this).parent().siblings('ul').scrollTop(0);
				$(this).parent().parent().siblings('#cSelectId').addClass('selectNeedList');
				$(this).parent().siblings('ul').children('.country_list_item').each(function(){
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
				$(this).parent().siblings('ul').children('.country_list_item').css('display','block');
			}
		})
	})

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
		}}
	});
	//eof
});

function check_form() {
	var payment =  $('input[name="payment"]:checked').val();
	var submit = true;
	if(payment == 'wire'){
		var hsbs_amout = $('input[name="hsbs_amout"]').val();
		var hsbs_date = $('input[name="hsbs_date"]').val();
		var hsbs_yname = $('input[name="hsbs_yname"]').val();
		var hsbs_Currency = $('select[name="hsbs_Currency"]').val();
		var hsbs_Currency_input = $('input[name="hsbs_Currency_input"]').val();
		if($.trim(hsbs_yname).length < 2){
			submit = false;
			$('input[name="hsbs_yname"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_YNAME_ERROR);
		}
		if($.trim(hsbs_amout) == ''){
			submit = false;
			$('input[name="hsbs_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT);
		}else if(isNaN($.trim(hsbs_amout))){
			submit = false;
			$('input[name="hsbs_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT_TYPE);
		}
		if($.trim(hsbs_date) == ''){
			submit = false;
			$('input[name="hsbs_date"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_PAYMNET_DATE);
		}	
		if($.trim(hsbs_Currency) == js_lang.TEXT_OTHERS && $.trim(hsbs_Currency_input) == ''){
			submit = false;
			$('input[name="hsbs_Currency_input"]').next().next('p').html(js_lang.TEXT_FILL_IN_CURRENCY_YOU_USED);
		}
	}else if(payment == 'wirebc'){
		var china_amout = $('input[name="china_amout"]').val();
		var china_date = $('input[name="china_date"]').val();
		var china_yname = $('input[name="china_yname"]').val();
		var china_Currency = $('select[name="china_Currency"]').val();
		var china_Currency_input = $('input[name="china_Currency_input"]').val();
		if($.trim(china_yname).length < 2){
			submit = false;
			$('input[name="china_yname"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_YNAME_ERROR);
		}
		if($.trim(china_amout) == ''){
			submit = false;
			$('input[name="china_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT);
		}else if(isNaN($.trim(china_amout))){
			submit = false;
			$('input[name="china_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT_TYPE);
		}
		if($.trim(china_date) == ''){
			submit = false;
			$('input[name="china_date"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_PAYMNET_DATE);
		}
		if($.trim(china_Currency) == js_lang.TEXT_OTHERS && $.trim(china_Currency_input) == ''){
			submit = false;
			$('input[name="china_Currency_input"]').next().next('p').html(js_lang.TEXT_FILL_IN_CURRENCY_YOU_USED);
		}
	}else if(payment == 'westernunion'){
		var western_amout = $('input[name="western_amout"]').val();
		var western_control_no = $('input[name="western_control_no"]').val();
		var western_yname = $('input[name="western_yname"]').val();
		var western_Currency = $('select[name="western_Currency"]').val();
		var western_Currency_input = $('input[name="western_Currency_input"]').val();
		if($.trim(western_yname).length < 2){
			submit = false;
			$('input[name="western_yname"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_YNAME_ERROR);
		}
		if($.trim(western_amout) == ''){
			submit = false;
			$('input[name="western_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT);
		}else if(isNaN($.trim(western_amout))){
			submit = false;
			$('input[name="western_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT_TYPE);
		}
		if($.trim(western_control_no) == ''){
			submit = false;
			$('input[name="western_control_no"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_CONTROL_NO);
		}else if(isNaN($.trim(western_control_no))){
			submit = false;
			$('input[name="western_control_no"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_CONTROL_NO_TYPE);
		}else if($.trim(western_control_no).length != 10){
			submit = false;
			$('input[name="western_control_no"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_CONTROL_NO_10);
		}
		if($.trim(western_Currency) == js_lang.TEXT_OTHERS && $.trim(western_Currency_input) == ''){
			submit = false;
			$('input[name="western_Currency_input"]').next().next('p').html(js_lang.TEXT_FILL_IN_CURRENCY_YOU_USED);
		}
	}else if(payment == 'moneygram'){
		var moneygram_full_name = $('input[name="moneygram_full_name"]').val();
		var moneygram_amout = $('input[name="moneygram_amout"]').val();
		var moneygram_control_no = $('input[name="moneygram_control_no"]').val();
		var moneygram_Currency = $('select[name="moneygram_Currency"]').val();
		var moneygram_Currency_input = $('input[name="moneygram_Currency_input"]').val();
		if($.trim(moneygram_full_name) == ''){
			submit = false;
			$('input[name="moneygram_full_name"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_REMITTER);
		}
		if($.trim(moneygram_amout) == ''){
			submit = false;
			$('input[name="moneygram_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT);
		}else if(isNaN($.trim(moneygram_amout))){
			submit = false;
			$('input[name="moneygram_amout"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_AMOUNT_TYPE);
		}
		if($.trim(moneygram_control_no) == ''){
			submit = false;
			$('input[name="moneygram_control_no"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_CONTROL_NO);
		}else if(isNaN($.trim(moneygram_control_no))){
			submit = false;
			$('input[name="moneygram_control_no"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_CONTROL_NO_TYPE);
		}else if($.trim(moneygram_control_no).length != 8){
			submit = false;
			$('input[name="moneygram_control_no"]').next('p').html(js_lang.TEXT_ACCONT_ENTER_CONTROL_NO_8);
		}
		if($.trim(moneygram_Currency) == js_lang.TEXT_OTHERS && $.trim(moneygram_Currency_input) == ''){
			submit = false;
			$('input[name="moneygram_Currency_input"]').next().next('p').html(js_lang.TEXT_FILL_IN_CURRENCY_YOU_USED);
		}
	}
	return submit;
}

$(function(){
	$('.submethods input').focus(function(){
		if($(this).next('p').length > 0){
			$(this).next('p').html('');			
		}
		if($(this).next().next('p').length > 0){
			$(this).next().next('p').html('');
		}
	});
	$('.select_currency').change(function(){console.log($(this).val());
		if($(this).val() == js_lang.TEXT_OTHERS){
			$(this).parent().next('.other_currency').show();
		}else{
			$(this).parent().next('.other_currency').hide();
			$(this).parent().parent().next('tr').children('td').children('input').val('');
		}
	});

	// 缩略图 suolvetu
	$(".fileUpload").on("change", function(){
		var $this = $(this);
    // Get a reference to the fileList
	    var files = !!this.files ? this.files : [];
	 
	    // If no files were selected, or no FileReader support, return
	    if (!files.length || !window.FileReader) return;
	 	
	    // Only proceed if the selected file is an image
	    if (/^image/.test( files[0].type)){

	    	var filetype = ['jpg','jpeg','png','gif'];
	    	var fname = files[0].name.split('.');
      		if(filetype.indexOf(fname[1].toLowerCase()) == -1){
        		return ;
      		}
    
	        var reader = new FileReader();
	        reader.readAsDataURL(files[0]);
	        reader.onloadend = function(e){
            	$this.parent().next('ul').find('.uploadPreview').html('<ins class="active"></ins><img src="' + e.target.result + '">');
            	$.post('./image_upload.php?Action=payment_recepit', {
	            	message:e.target.result,
	           		filesize:files[0].size,
	           		filetype:fname[1]
	          	}, function(data){
	          		var returnInfo = process_json(data);
	          		if (returnInfo['error']) {
	          			alert('error');
	          		}else{
						$this.next('input').val(returnInfo['data']['name']);
	          		};
	          	});
	        }
	    }
	 
	});
	$(document).on('click', '.uploadPreview .active', function(){
		$(".uploadPreview").html('');
		$(".fileUpload").next('input').val('');
	});
});

