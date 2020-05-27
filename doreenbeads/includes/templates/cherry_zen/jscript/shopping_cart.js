//bof shopping cart
function keypress(customers_basket_id){
	   var text1=document.getElementById("basket_note_"+customers_basket_id).value;       //\"review_text\",\"rest_characters\"
	   var len;
	   if(text1.length>=254){
	    document.getElementById("basket_note_"+customers_basket_id).value=text1.substr(0,254);
	    len=0;
	   }
	   else{
	     len=254-text1.length;
	   }
	   var show=len;
	   $j(".save_note_tpis_"+customers_basket_id+ " #rest_characters").text(show);
	   //document.getElementById("save_note_tpis_").innerText=show;
	   //document.getElementById("rest_characters").innerHTML=show;
}
$j(function(){
	$j(".jq_move_all_to_wishlist").live('click', function(){
		var isLogin = $j('.isLogin').val();
		var obj = $j(this);
		if(isLogin == 'yes'){
			
			$j.post("./shopping_cart_process.php", {action: 'shopcart_isvalid'},function(data){
				var data = process_json($j.trim(data));
				if(data.error > 0) {
					var text_yes = obj.data('yes');
					var text_no = obj.data('no');
					
					$j.confirm({
						'message'	: data.message,
						'buttons'	: {
							'&nbsp;'	: {
								'text'  : text_yes,
								'class'	: 'paynow_btn sureremove',
								'action': function(){
									window.location.href = 'index.php?main_page=shopping_cart';
								}
							},
							' '	: {
								'text'  : text_no ,
								'class'	: 'cancelremove',
								'action': function(){}
							}
						}
					});		
				}else{
					
					var text_yes = $lang.TextYes;
					var text_no = $lang.TextNo;
					$j.confirm({
						'message'	: obj.data("confirm"),
						'buttons'	: {
							'&nbsp;'	: {
								'text'  : text_yes,
								'class'	: 'paynow_btn sureremove',
								'action': function(){
									document.shopping_cart_form.setAttribute("action", "index.php?main_page=shopping_cart&action=mwa");
									document.shopping_cart_form.submit();
								}
							},
							' '	: {
								'text'  : text_no ,
								'class'	: 'cancelremove',
								'action': function(){}
							}
						}
					});
				}
			});

			
		}else{
			show_login_div('addalltowishlist');
		}
	});

	$j('.jq_icon_collect').live('click', function(){
		$j('.successtips_collect').hide();
		var isLogin = $j('.isLogin').val();
		_this = $j(this);
		var product_id = _this.attr('id');
		var product_id = product_id.substr(5);
		var qty = $j('#qty_' + product_id).val();

		$j.confirm({
			'message'	: $j(this).data("confirm"),
			'buttons'	: {
				'Yes'	: {
					'class'	: 'paynow_btn sureremove',
					'action': function(){
						$j.post('./shopping_cart_process.php', {action: 'addtowishlist', pid: product_id, qty: qty}, function(data){
							window.location.href="index.php?main_page=shopping_cart";
						});
					}
				},
				'No'	: {
					'class'	: 'cancelremove',
					'action': function(){}
				}
			}
		});
	});

	$j('.successtips_collect_close').live('click', function(){
		$j(this).parent().hide();
	});

	$j(".jq_products_image_small").live("mouseover", function() {
		$j(".jq_products_image_src_" + $j(this).data("id")).attr("src", $j(this).data("original"));
		$j(".jq_products_image_detail_" + $j(this).data("id")).show();
	}).live("mouseout",function(){
		$j(".jq_products_image_detail_" + $j(this).data("id")).hide();
	});
});


function empty_cart(){
	document.shopping_cart_form.setAttribute("action", "index.php?main_page=shopping_cart&action=empty");
	document.shopping_cart_form.submit();
}

function get_split_page(){
	var page = $j('.cart_split_page a.current').html();
	return (page != '' ? page : 1);
}

function remove_product(product_id,index_num){
	var del_qty = $j('#qty_'+product_id).val();
	$j.post('./shopping_cart_process.php', {action: 'remove', pid: product_id, index_num: index_num, del_qty: del_qty, page: get_split_page()}, function(data){
		//解决php，json_encode bug，如对俄语站货号为B0080422商品进行删除时
		try {
			data = process_json($j.trim(data));
		}
		catch (err) {
			location.href = location.href;
			return false;
		}
		if(data.body == null) {
			location.href = location.href;
			return false;
		}
		if(data.error == 0) {
			$j('.rp_qty_'+product_id).val('1');
			$j('.rp_oqty_'+product_id).val('0');
			$j('button#rp_'+product_id).attr('class', 'addbtnmin rp_btn');
			$j('.shopping_cart_main_content').html(data.body);
			var aWidth=$j('.estShippingCost').width();
			$j('.shippingMethodDd').css({'paddingLeft':(240-aWidth)+'px'});
		}
		
	});
}

// 撤销购物车删除20160304
function readd_product(product_id,qty){
	$j.post('./shopping_cart_process.php', {action: 'readd', pid: product_id, page: get_split_page(), pro_qty: qty}, function(data){
			//解决php，json_encode bug，如对俄语站货号为B0080422商品进行删除时
			try {
				data = process_json($j.trim(data));
			}
			catch (err) {
				location.href = location.href;
				return false;
			}
			$j('.del_cart_product').remove();
			$j('.rp_qty_'+product_id).val('1');
			$j('.rp_oqty_'+product_id).val('0');
			$j('button#rp_'+product_id).attr('class', 'addbtnmin rp_btn');
			$j('.shopping_cart_main_content').html(data.body);
			var aWidth=$j('.estShippingCost').width();
			$j('.shippingMethodDd').css({'paddingLeft':(240-aWidth)+'px'});
		});		
}

$j(function(){
	$j('.shopcart_content .jq_icon_delete').live('click', function(){
        
		product_id = $j(this).attr('pid');
		var index_num = $j(this).attr('data-index');
		
		text_yes = $lang.TextYes;
		text_no = $lang.TextNo;
		$j.confirm({
			'message'	: $lang.CartAreYouSureDelete,
			'buttons'	: {
				'Yes'	: {
					'class'	: 'paynow_btn sureremove',
					'action': function(){
						remove_product(product_id,index_num);
					}
				},
				'No'	: {
					'class'	: 'cancelremove',
					'action': function(){}
				}
			}
		});	
	});

	$j('.shopcart_operate .empty_cart').live('click', function(){
		var obj = $j(this);
		$j.post("./shopping_cart_process.php", {action: 'shopcart_isvalid'},function(data){
			var data = process_json($j.trim(data));
			if(data.error > 0) {
				var text_yes = obj.data('yes');
				var text_no = obj.data('no');
				
				$j.confirm({
					'message'	: data.message,
					'buttons'	: {
						'&nbsp;'	: {
							'text'  : text_yes,
							'class'	: 'paynow_btn sureremove',
							'action': function(){
								window.location.href = 'index.php?main_page=shopping_cart';
							}
						},
						' '	: {
							'text'  : text_no ,
							'class'	: 'cancelremove',
							'action': function(){}
						}
					}
				});		
			}else{
				
				var text_yes = $lang.TextYes;
				var text_no = $lang.TextNo;
				$j.confirm({
					'message'	: $lang.CartAreYouSureDeleteAll,
					'buttons'	: {
						'&nbsp;'	: {
							'text'  : text_yes,
							'class'	: 'paynow_btn sureremove',
							'action': function(){
								empty_cart();
							}
						},
						' '	: {
							'text'  : text_no ,
							'class'	: 'cancelremove',
							'action': function(){}
						}
					}
				});
			}
		});		
		
	});
	/*$j('#products_notes').live('click', function(){
		$j('.pricetips').live('click', function(){
			return false;
		});
		if($j(this).children('.pricetips').css('display') == 'none'){
			$j('.pricetips').hide();
			$j(this).children('.products_note_tips').hide();
			//$j(this).parents('td').css('z-index','10001');
			$j(this).children('.pricetips').show();			
		}else{
			$j(this).children('.pricetips').hide();
			//$j('.shopcart_content td').css('z-index',' ');
		}
	}).live('mouseover',function(){
		if($j(this).children('.products_note_in').attr('id')){
			if($j(this).children('.pricetips').css('display') == 'none'){
				//$j(this).parents('td').css('z-index','10001');
				$j(this).children('.products_note_tips').show();				
			}		
		}
	}).live('mouseout',function(){
		$j(this).children('.products_note_tips').hide();
		//$j('.shopcart_content td').css('z-index',' ');
	});
	$j('.btn_grey').live('click', function(){
		$j('.pricetips').hide();
		//$j('.shopcart_content td').css('z-index',' ');
	});*/
	
	$j('#products_notes').live('click', function(){ 
		$j('.pricetips').live('click', function(){ 
			return false; 
		}); 
		if($j(this).children('.pricetips').css('display') == 'none'){ 
			$j('.pricetips').hide(); 
			$j(this).children('.products_note_tips').hide(); 
			$j(this).children('.pricetips').show(); 
			$j('.shopcart_content td').removeClass('iindex')
			$j(this).parents('td').addClass('iindex')
	
		}else{ 
			$j(this).children('.pricetips').hide(); 
			$j('.shopcart_content td').removeClass('iindex');
		} 
	}).live('mouseover',function(){ 
		if($j(this).children('.products_note_in').attr('id')){ 
			if($j(this).children('.pricetips').css('display') == 'none') 
				$j(this).children('.products_note_tips').show(); 
		} 
	}).live('mouseout',function(){ 
		$j(this).children('.products_note_tips').hide(); 
	});
	$j('.btn_grey').live('click', function(){
		$j('.pricetips').hide();
		$j('.shopcart_content td').removeClass('iindex');
	});

	
	$j('.save_note').live('click', function(){
		basket_notes = $j('#basket_note_'+$j(this).attr('aid')).val();
		basket_id = $j(this).attr('aid');
		basket_notes = $j.trim(basket_notes);
		if(basket_notes != ''){
			$j.post('./add_basket_note.php', {basket_note:basket_notes, basket_id: basket_id}, function(data){
				if(data == 'true'){
					$j('.pricetips').hide();
					$j('#products_note_'+basket_id).removeClass("products_note");
					$j('#products_note_'+basket_id).addClass("products_note_in");
					$j('#products_notes #products_note_tips_'+basket_id).html(basket_notes);
				}
			});
		}else{
			$j.post('./add_basket_note.php', {basket_note:basket_notes, basket_id: basket_id}, function(data){
				if(data == 'true'){
					$j('.pricetips').hide();
					$j('#products_note_'+basket_id).removeClass("products_note_in");
					$j('#products_note_'+basket_id).addClass("products_note");
					$j('#products_notes #products_note_tips_'+basket_id).html('');
				}
			});
		}
	});
});

$j(function(){
	$j('.cart_total_info').live('mouseover', function(){
		$j(this).find('.successtips_total').show();
	}).live('mouseout', function(){
		$j(this).find('.successtips_total').hide();
	});
	$j('.cart_total_infos').live('mouseover', function(){
		$j(this).find('.successtips_total').show();
	}).live('mouseout', function(){
		$j(this).find('.successtips_total').hide();
	});
	//只允许输入数字
	$j('input[name="product_qty"], input[name="product_qty[]"], input[name="rp_qty"]').live('keydown', function(e){
		if ($j.browser.msie) {
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

	$j('input[name="product_qty[]"], input[name="rp_qty"]').live('keyup', function(){
		if($j(this).val() != ''){
			$j(this).val($j(this).val().replace(/\D/g,''));
		}
		if($j(this).val() < 1 && $j(this).val() != ''){
			if($j(this).siblings('input[name="product_qty_old"]').length > 0){
				original_qty = $j(this).siblings('input[name="product_qty_old"]').val();
			}else{
				original_qty = 1;
			}
			$j(this).val(original_qty);
		}
	});

	$j('input[name="product_qty[]"]').live('keyup', function(){
		$j(this).val($j(this).val().replace(/\D|^0{0,}/g,''));
	});	

	$j('.jq_products_checked').live('click', function(){
		var type = $j(this).data('type');
		var is_checked = 0;
		var customers_basket_id = $j(this).val();
		if($j(this).attr("checked") == "checked") {
			is_checked = 1;
		}

		$j.post('./shopping_cart_process.php', {action: 'update_is_checked', type: type, is_checked: is_checked, customers_basket_id:customers_basket_id, page: get_split_page()}, function(data){
			//解决php，json_encode bug，如对俄语站货号为B0080422商品进行删除时
			try {
				data = process_json($j.trim(data));
			} catch (err) {
				location.href = location.href;
				return false;
			}
			if(data.error <= 0) {
				$j('.shopping_cart_main_content').html(data.body);
				$j('.total_weight_input').val(data.show_weight);
				var aWidth=$j('.estShippingCost').width();
				$j('.shippingMethodDd').css({'paddingLeft':(240-aWidth)+'px'});
			} else {
				alert(data.message);
			}
			
		});
	});
	
	$j('.icon_increase').live('click', function(){
		_thisVal = parseFloat($j(this).siblings('input[name="product_qty"]').val());
		_thisOval = parseFloat($j(this).siblings('input[name="product_qty_old"]').val());
		_thisProQuantity = parseFloat($j(this).siblings('input[name="product_quantity"]').val());
		if(isNaN(_thisVal)){
			if(typeof(timeID) == 'number'){
				clearTimeout(timeID);
			}			
			$j('.successtips_update').hide();
			$j(this).parent().siblings('.successtips_update').show().find('.update_qty_note').html($lang.EnterRightQty);
			$j(this).siblings('input[name="product_qty"]').val(_thisOval);
			timeID = setTimeout(function(){
				$j('.update_num .successtips_update').hide();
			}, 3000);
			return false;
		}
		update_qty = _thisVal + 1;	
		$j(this).siblings('input[name="product_qty"]').val(update_qty);
		update_product_qty($j(this), update_qty);
	});
	
	$j('.qty_content input[name="product_qty"]').live('blur', function(){
		_thisVal = parseFloat($j(this).val());
		_thisOval = parseFloat($j(this).siblings('input[name="product_qty_old"]').val());
		_thisProQuantity = parseFloat($j(this).siblings('input[name="product_quantity"]').val());
		if(_thisVal != _thisOval){
			if(isNaN(_thisVal) || _thisVal <= 0){
				if(typeof(timeID) == 'number'){
					clearTimeout(timeID);
				}			
				$j('.successtips_update').hide();
				$j(this).parent().siblings('.successtips_update').show().find('.update_qty_note').html($lang.EnterRightQty);
				$j(this).val(_thisOval);
				timeID = setTimeout(function(){
					$j('.update_num .successtips_update').hide();
				}, 3000);
				return false;
			}
			update_product_qty($j(this), _thisVal);
		}		
	});
	
	$j('.icon_decrease').live('click', function(){
		num = $j(this).next().val();
		if(num <= 1) {
			pid = $j(this).siblings('input[name="product_id"]').val();
			$j.confirm({
				'message'	: $lang.CartAreYouSureDelete,
				'buttons'	: {
					'Yes'	: {
						'class'	: 'paynow_btn sureremove',
						'action': function(){
							remove_product(pid);
						}
					},
					'No'	: {
						'class'	: 'cancelremove',
						'action': function(){}
					}
				}
			});	
			//return false;
		}else{
			update_qty = num - 1;
			update_product_qty($j(this), update_qty);
			$j(this).siblings('input[name="product_qty"]').val(update_qty);
		}
	});
	function update_product_qty(obj, num){
		pid = obj.siblings('input[name="product_id"]').val();
		var postcode = $j('.estimate_postcode').val();
		new_qty = num;
		if(typeof(timeID) == 'number'){
			clearTimeout(timeID);
		}
		$j('.successtips_update').hide();
		$j.post('./shopping_cart_process.php', {action: 'update_qty', pid: pid, qty: new_qty,postcode:postcode, page: get_split_page()}, function(data){
			//解决php，json_encode bug，如对俄语站货号为B0080422商品进行删除时
			try {
				data = process_json($j.trim(data));
			}
			catch (err) {
				location.href = location.href;
				return false;
			}
			if(data.error == 0) {
				var product_id = data.product_id;
				var product_qty = data.product_qty;
				var product_price = data.product_price;
				var product_oprice = data.product_oprice;
				var product_total = data.product_total;
				var products_num = data.products_num;
				var is_checked_count = data.is_checked_count;
				var show_total_new = data.show_total_new;
				var show_weight = data.show_weight;
				var show_weight_bag = data.show_weight_bag;
				var show_weight_total = data.show_weight_total;
				var vip_amount = data.vip_amount;
				var vip_title = data.vip_title;
				var vip_content = data.vip_content;
				var special_discount_title = data.special_discount_title;
				var special_discount_content = data.special_discount_content;
				var shipping_content = data.shipping_content;
				var shipping_method_by = data.shipping_method_by;
				var total_all = data.total_all;
				var cal_total_amount_convert = data.cal_total_amount_convert;
				var product_note = data.product_note;
				var product_caution = data.product_caution;
				var tenoff = data.tenoff;
				var prom_discount = data.prom_discount;
				var prom_discount_format = data.prom_discount_format;
				var prom_discount_title = data.prom_discount_title;
				var prom_discount_note = data.prom_discount_note;
				var rcd_discount = data.rcd_discount;
				var show_current_discount = data.show_current_discount;
				var pp_max_num_per_order = data.pp_max_num_per_order;
				var max_num_per_order_tips = data.max_num_per_order_tips;
				var is_preorder = data.is_preorder;
				var is_preorder_tip = data.is_preorder_tip;
				var discounts_formats = data.discounts_formats;
				var discounts_format = data.discounts_format;
				var promotion_discount_format = data.promotion_discount_format;
				var original_prices = data.original_prices;
				var handing_fee_format = data.handing_fee_format;
				var handing_fee = data.handing_fee;
				var is_handing_fee = data.is_handing_fee;
				if(data.cate_total_arr){
					var x;
					for (x in data.cate_total_arr){
						$j('#cate_total_'+x).text(data.cate_total_arr[x]);
					}
				}
				$j('.promotion_discount_full_set_minus_title').html(data.full_set_minus_title);
				$j('.promotion_discount_full_set_minus_content').html(data.full_set_minus_content);
				
				$j('.estimate_content').html('<div class="estshipping_loading"><img src="includes/templates/cherry_zen/images/zen_loader.gif"></div>');
				
				$j('.price_'+product_id).html(product_price);

				if ( (product_qty > pp_max_num_per_order) && pp_max_num_per_order > 0 ) {
					$j('.jq_show_promotiom_tips_'+product_id).text(max_num_per_order_tips).show();
					$j('.oprice_'+product_id).html(product_oprice).hide();
				}else{
					$j('.jq_show_promotiom_tips_'+product_id).hide();
					if (product_price != product_oprice) {
						$j('.oprice_'+product_id).html(product_oprice).show();
					};				
				}

				//$j('.oprice_'+product_id).html(product_oprice);
				$j('.total_'+product_id).html(product_total);

				$j('.total_weight').html(show_weight);
				$j('.view_shippping_weight .view_weight_1').html(show_weight);
				$j('.view_shippping_weight .view_weight_2').html(show_weight_bag);
				$j('.view_shippping_weight .view_weight_3').html(show_weight_total);

				if(data.show_volume_weight){
					$j('.show_volume_weight_tr').html(data.show_volume_weight);
				}

				if(data.show_package_box_weight_str){
					$j('.show_package_box_weight_td').html(data.show_package_box_weight_str);
				}

				if(data.shipping_total_weight_str){
					$j('.shipping_total_weight_td').html(data.shipping_total_weight_str);
					$j('.total_weight_input').val(data.shipping_total_weight_str);
				}

				$j('.jq_total_items').html(products_num);
				$j('.jq_is_checked_count').html(is_checked_count);
				$j('.subtotal_amount').html(show_total_new);
				$j('.total_amount_original').html(original_prices);
				/*当vip_amount 超过一千 会显示 1,111 为string类型*/	
				if(vip_amount && vip_amount != '0.00'){
					$j('.vip_title').html(vip_title).show();
					$j('.vip_content').html(vip_content).show();
				}else{
					$j('.vip_title').hide();
					$j('.vip_content').hide();
				}
				if (prom_discount && prom_discount > 0) {
					$j('.promotion_title').html(prom_discount_title).show();
					$j('.promotion_discount span').html(prom_discount_format);
					$j('.promotion_discount').show();
				}else{
					$j('.promotion_title').hide();
					$j('.promotion_discount').hide();
				};

				if (rcd_discount && rcd_discount > 0) {
					$j('.rcd_content span').html(show_current_discount).show();
					$j('.rcd_title').show();
					$j('.rcd_content').show();
				}else{
					$j('.rcd_title').hide();
					$j('.rcd_content').hide();
				};		
				if (discounts_formats && discounts_formats > 0){
				   // $j('.image_down_arrow').show();
				   $j('.discount_title').show();
                   $j('.discount_content').html(discounts_format).show();
                }else{
                   $j('.discount_title').hide();
                   $j('.discount_content').hide();
                   // $j('.image_down_arrow').hide();
                };
                if (is_handing_fee < 0){
                	$j('.handing_fee_title').show();
                	$j('.handing_fee_content').html(handing_fee).show();
                	$j('.cart_total_infos').show();
					$j('.handing_fee_dd').show();
                }else{
                	$j('.handing_fee_title').hide();
                	$j('.handing_fee_content').html(handing_fee).hide();
                	$j('.cart_total_infos').hide();
					$j('.handing_fee_dd').hide();
                };
                $j('.promotion_discount_content').html(promotion_discount_format);
				$j('.shipping_content').html(shipping_content);
				$j('.shippingMethodDd').html(shipping_method_by);
				$j('.special_discount_title').html(special_discount_title);
				$j('.special_discount_content').html(special_discount_content);
				$j('.total_amount').html(total_all);
				$j('.cal_total_amount_convert').html(cal_total_amount_convert);

				var aWidth=$j('.estShippingCost').width();
				$j('.shippingMethodDd').css({'paddingLeft':(240-aWidth)+'px'});
				if(product_note != "") {
					obj.parent().siblings('.successtips_update').show().find('.update_qty_note').html(product_note);
				}
				if(num != product_qty){
					$j('#qty_'+product_id).val(product_qty);
				}
				$j('#qty_old_'+product_id).val(product_qty);
				$j('.rp_qty_'+product_id).val(product_qty);
				$j('.rp_oqty_'+product_id).val(product_qty);

				if(is_preorder_tip != null || is_preorder != 0) {
					$j('.jq_is_preorder_' + product_id).html(is_preorder_tip);
				} else {
					$j('.jq_is_preorder_' + product_id).html('');
				}
				if(product_caution != null){
					$j('.jq_qty_update_tips_'+product_id).html(product_caution).show();
				} else {
					$j('.jq_qty_update_tips_'+product_id).hide();
				}
			}

			
		});
		timeID = setTimeout(function(){
			$j('.update_num .successtips_update').hide();
		}, 3000);
	}
});
$j(function(){
	$j('.quickadd_btn').live('click', function(){
		$j.post('./shopping_cart_process.php', {action:'quick_add_content', page: get_split_page()}, function(data){
			$j('#quick_add_content').html(data);
			re_pos('quickaddsmallwindow');
			var bodyHeight=($j(document).height()+'px');
			$j('.windowbody').css('height', bodyHeight).fadeTo(1000, 0.5);
			$j('.quickfind').css('display', 'block');
			$j(".quickaddcont .quickadd input[type='text']").eq(0).focus();
		});
	});
	$j('.smallwindowtit .addressclose').live('click', function(){
		$j('.quickfind').hide();
		$j('.windowbody').fadeOut();
	});
	$j('.windowbody').click(function(){
		$j('.quickfind').hide();
		$j('.windowbody').fadeOut();
	});
	$j('.jq_cart_normal .greybtn').live('click', function(){
		var oneline="<tr><td><input type='text' name='product_model[]'/></td><td><input type='text' name='product_qty[]' /></td></tr><tr><td><input type='text' name='product_model[]'/></td><td><input type='text' name='product_qty[]' /></td></tr>";
		$j('.quickadd').append(oneline);
	});
	$j('.shipping_extra_note').live('click', function(){
		$j('tr.shownone').not($j(this).parents('tr').next('tr.shownone')).hide();
		$j(this).parents('tr').next('tr.shownone').toggle();
	});
});

function check_model(obj){
	var bl = false;	
	var model = obj.val();
	var qty = obj.parent().siblings('td').children('input[name="product_qty[]"]').val();
	if(qty == '') qty = 1;
	var thisone = obj;
	if($j.trim(model) != ''){
		$j.ajax({
			url: './shopping_cart_process.php',
			type: 'POST',
			async:false,
			data:{model:model, action:'check_model', qty:qty, page: get_split_page()},
			success: function(data){
				var data = process_json($j.trim(data));
				if(data.error == 1) {
					thisone.parent().siblings('td').html('<input type="text" name="product_qty[]" class="inputdisable" disabled="disabled">');
					thisone.parent().html('<input type="text" name="product_model[]" class="inputwrong" value="'+model+'"><span class="textwrongicon1" title="'+$lang.CartJsWrongNumber+'"></span><p style="color:#ff0000;">'+$lang.CartJsWrongNumber+'</p>');
				} else {
					thisone.parent().siblings('td').html('<input type="text" name="product_qty[]" value="'+data.qty+'"><span class="textrighticon1"></span>');
					thisone.parent().html('<input type="text" name="product_model[]" value="'+model+'"><span class="textrighticon1"></span>');
					bl = true;
				}
			}

		});
	}else{
		thisone.parent().siblings('td').html('<input type="text" name="product_qty[]">');
		thisone.parent().html('<input type="text" name="product_model[]">');
	}
	return bl;
}


$j(function(){
	$j(".quickfind .choose_tab li").live("click", function() {
		$j(".quickfind .choose_tab li").removeClass("current");
		$j(this).addClass("current");
		$j(".jq_cart_normal").hide();
		$j(".jq_cart_spreadsheet").hide();
		$j($j(this).data("target")).show();

	});

	$j('.quickadd input[name="product_model[]"]').live('focus', function(){
		var qty = $j(this).parent().siblings('td').children('input[name="product_qty[]"]').val();
		$j(this).parent().siblings('td').html('<input type="text" name="product_qty[]" value="'+qty+'">');
		$j(this).siblings('span').remove();
		$j(this).siblings('p').remove();
		$j(this).removeClass('inputwrong');
	});

	$j('.quickadd input[name="product_model[]"]').live('blur', function(){
		if($j(this).val()!=''){
			check_model($j(this));
		}
	});


	$j('.jq_cart_normal .paynow_btn').live('mousedown', function(){
		setTimeout(function() {
			var sub = false;
			var empty = true;
			$j('input[name="product_model[]"]').each(function(){
				var model = $j.trim($j(this).val());
				var qty = $j.trim($j(this).parent().siblings('td').children('input[name="product_qty[]"]').val());
				if(model != ''){
					empty = false;
					var bl = check_model($j(this));
					if(!bl) {
						sub = false;
						return false;
					}else{
						sub = true;
					}
				}
				if($j(this).siblings('span.textrighticon1').length == 1){
					sub = true;
				}
				
				if(model != '' && qty == ''){
					sub = false;
				}
			});
				
			if($j('span.deleteicon_part').length > 0){
				sub = false;
			}
			
			if(!empty){
				if(sub){
					document.quick_add.submit();
				}else{
					$j('#quickaddsmallwindow .quickadd_sub .quickadd_sub_note').html($lang.CartQuickAddWrong);
					$j('#quickaddsmallwindow .quickadd_sub').show();
				}
			}else{
				$j('#quickaddsmallwindow .quickadd_sub .quickadd_sub_note').html($lang.CartQuickAddEmpty);
				$j('#quickaddsmallwindow .quickadd_sub').show();
			}
		}, 100);
		setTimeout(function(){
			$j('#quickaddsmallwindow .quickadd_sub').hide();
		}, 5000)
	});

	$j(".jq_cart_spreadsheet .paynow_btn").live("click", function() {
		$j('.jq_error_authsode_tips').hide();
		var file = $j("#filePath").val();
		if ($j('#check_code_input').length > 0) {
			var code = $j('#check_code_input').val();
			if (code == '') {
				return false;
			};
		};
		
		if(file != '') {
			$j('#quick_add_spreadsheet').ajaxSubmit({
				type: 'post',
				url: './index.php?main_page=shopping_cart',
				dataType: 'form',
				success: function(data){
					returnInfo = process_json(data);
					if (returnInfo['msg'] != '') {
						$j('.jq_error_authsode_tips').text(returnInfo['msg']).show();
					}else{
						location.href = "index.php?main_page=shopping_cart";
					}					
				}
			});
		}else{
			return false;
		}
	});

	$j(".jq_cart_spreadsheet .greybtn").live("click", function() {
		document.jq_export.submit();
	});
});

$j(function(){
	$j('a.estShippingCost').live('click', function(){
		var bodyHeight=($j(document).height()+'px');
		$j('.windowbody').css('height', bodyHeight).fadeTo(1000, 0.35);
		var country = $j('input[name="country_name"]').val();
		var city = $j('.estimate_city').val();
		var postcode = $j('.estimate_postcode').val();
		re_pos('estimatewindow');
		$j('#estimatewindow').show();
		if($j('.estimate_content .estshipping_loading').length == 0){
			return false;
		}
		$j.post('./shopping_cart_process.php', {action: 'estimate', country_name: country, city: city, postcode: postcode, page: get_split_page()}, function(data){
			var data = process_json($j.trim(data));
			if(data.error <= 0) {
				var shipping_info = process_json($j.trim(data.shipping_content_str));
				$j('.estimate_content').html(data.body);
				$j('.shipping_content').html(shipping_info[0]);
				var aWidth=$j('.estShippingCost').width();
				$j('.shippingMethodDd').html(shipping_info[1]).css({'paddingLeft':(240-aWidth)+'px'});
				
				$j('.special_discount_title').html(shipping_info[2]);
				$j('.special_discount_content').html(shipping_info[3]).show();
				$j('.vip_content').html(shipping_info[4]);

				$j('.total_amount').html(data.total_amount);
				re_pos('estimatewindow');

				if(data.show_volume_weight){
					$j('.show_volume_weight_tr').html(data.show_volume_weight);
				}

				if(data.show_package_box_weight_str){
					$j('.show_package_box_weight_td').html(data.show_package_box_weight_str);
				}

				if(data.shipping_total_weight_str){
					$j('.shipping_total_weight_td').html(data.shipping_total_weight_str);
				}
				$j("input[name='ship']:checked").click();
			} else {
				alert(data.message);
			}
		});		
	});
	$j('.windowbody, .smallwindowtit .shipclose_btn').click(function(){
		$j('.windowship').hide();
		$j('.windowbody').fadeOut();
	});
});


$j(function(){
	var ocountry = $j('input[name="country_name"]').val();	
	var ocity = $j('.estimate_city').val();
	var opostcode = $j('.estimate_postcode').val();

	$j.post('./shopping_cart_process.php', {action: 'cal', country_name: ocountry, city: ocity, postcode: opostcode, page: get_split_page()}, function(data){
		var data = process_json($j.trim(data));
		var shipping_info = process_json($j.trim(data.shipping_content_str));
		$j('.shipping_content').html(shipping_info[0]);
		var aWidth=$j('.estShippingCost').width();
		$j('.shippingMethodDd').html(shipping_info[1]).css({'paddingLeft':(240-aWidth)+'px'});
		
		$j('.special_discount_title').html(shipping_info[2]);
		$j('.special_discount_content').html(shipping_info[3]).show();
		$j('.vip_content').html(shipping_info[4]);
		
		if(shipping_info[4] == ''){
			$j('.vip_title').html('');
		}else{
			$j('.vip_title').html(shipping_info[5]);
		}
		if(shipping_info[7]){
			$j('.promotion_discount_full_set_minus_title').html(shipping_info[6]);
			$j('.promotion_discount_full_set_minus_content').html(shipping_info[7]);
		}

		$j('.total_amount').html(data.total_amount);

		if(data.show_volume_weight){
			$j('.show_volume_weight_tr').html(data.show_volume_weight);
		}

		if(data.show_package_box_weight_str){
			$j('.show_package_box_weight_td').html(data.show_package_box_weight_str);
		}

		if(data.shipping_total_weight_str){
			$j('.shipping_total_weight_td').html(data.shipping_total_weight_str);
			$j('.total_weight_input').val(data.shipping_total_weight_str);
		}
	});

	$j('.estimate_btn').click(function(){
		var country = $j('.choose_single span').html();
		var city = $j('.estimate_city').val();
		var postcode = $j('.estimate_postcode').val();
		
		if(ocountry != country || ocity != city || opostcode != postcode){
			$j('.estimate_content').html('<div class="estshipping_loading"><img src="includes/templates/cherry_zen/images/zen_loader.gif"></div>');
			$j.post('./shopping_cart_process.php', {action: 'estimate', city: city, postcode: postcode, country_name: country, page: get_split_page()}, function(data){
				var data = process_json($j.trim(data));
				var shipping_info = process_json($j.trim(data.shipping_content_str));
				$j('.estimate_content').html(data.body);
				$j('input[name="country_name"]').val(country);
				$j('.shipping_content').html(shipping_info[0]);
				var aWidth=$j('.estShippingCost').width();
				$j('.shippingMethodDd').html(shipping_info[1]).css({'paddingLeft':(240-aWidth)+'px'});
				$j('.total_amount').html(data.total_amount);
				
				$j('.special_discount_title').html(shipping_info[2]);
				$j('.special_discount_content').html(shipping_info[3]).show();
				$j('.vip_content').html(shipping_info[4]);

				ocountry = country;	
				ocity = city;
				opostcode = postcode;
				if(data.vip_amount){
					var data='<div class="successtips1"><span class="bot"></span><span class="top"></span><img src="includes/templates/cherry_zen/css/english/images/redclose.gif">'+data.vip_amount+'</div>';
					$j('.cartftbtn .tips_right .successtips1').remove();
					$j('.cartftbtn .tips_right').append(data);
				}

				$j('.shipwaysmall').find("input").each(function() {
					if($j(this).attr("checked") == "checked") {
						$j(this).trigger("click");
					}
				});
			});
		}
	});	
});

//bof 排序
$j(document).ready(function(){
	var aCont;
	var type;
	var type1;

	$j('.ddown').live('click', function(){
		type = 'day';
		type1 = 'cost';
		clickFun(type, type1);
		fSort(compare_up);
        setTrIndex(type, type1);
	});
	$j('.drise').live('click', function(){
		type = 'day';
		type1 = 'cost';
		clickFun(type, type1);
		fSort(compare_down);
        setTrIndex(type, type1);
	});
	$j('.pdown').live('click', function(){
		type = 'cost';
		type1 = 'day';
		clickFun(type, type1);
		fSort(compare_up);
        setTrIndex(type, type1);
	});
	$j('.prise').live('click', function(){
		type = 'cost';
		type1 = 'day';
		clickFun(type, type1);
		fSort(compare_down);
        setTrIndex(type, type1);
	});
	
    var clickFun = function(type, type1){
        aCont = [];
        var sortby = type;
        var sortby1 = type1;
        fSetDivCont(sortby, sortby1);
    }
	var fSetDivCont = function(sortby, sortby1){
		$j('.shipwaysmall tr:not(:first)').not('.shownone').each(function() {			
			var trCont = parseFloat($j(this).find('.'+sortby).val() * 10000) + parseFloat($j(this).find('.'+sortby1).val());
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
            $j('.shipwaysmall tr:not(:first)').not('.shownone').each(function() {
				var thisText = parseFloat($j(this).find('.'+sortby).val() * 10000) + parseFloat($j(this).find('.'+sortby1).val());
                if(thisText == trCont){
					obj.push($j(this));
					obj.push($j(this).next('.shownone'));
                }
			});       
        }
		for(i=0;i<obj.length;i++){
			$j('.shipwaysmall').append(obj[i]);
		}
    }
});
//eof

$j(function(){
	$j('input[type="text"]').live('keydown', function(e){
		if ($j.browser.msie) {
			var key = event.keyCode;			
		} else {
			var key = e.which;
		}
		/*if (key == 13) {
			return false; 
		}*/
	});
	
	$j('table.shipwaysmall').find('tr:gt(0)').live('click', function(){
		$j('.shipwaysmall tr.bychecked').removeClass('bychecked');
		$j(this).addClass('bychecked');
		$j(this).next('tr.shownone').show();
		$j('tr.shownone').not($j(this).next('tr.shownone')).hide();
		$j(this).children().children().attr('checked', 'true');

		var shipping_code = $j(this).children().children('input').attr('id');
		var ocountry = $j('input[name="country_name"]').val();	
		var ocity = $j('.estimate_ocity').val();
		var opostcode = $j('.estimate_postcode').val();
		
		$j.post('./shopping_cart_process.php', {action: 'radio', shipping_code: shipping_code, city: ocity, postcode: opostcode, country_name: ocountry, page: get_split_page()}, function(data){
			//解决php，json_encode bug，如对俄语站货号为B0080422商品进行删除时
			try {
				data = process_json($j.trim(data));
			}
			catch (err) {
				location.href = location.href;
				return false;
			}
			var shipping_info = process_json($j.trim(data.shipping_content_str));
			$j('.shipping_content').html(shipping_info[0]);
			var aWidth=$j('.estShippingCost').width();
			$j('.shippingMethodDd').html(shipping_info[1]).css({'paddingLeft':(240-aWidth)+'px'});
			$j('.total_amount').html(data.total_amount);
			
			$j('.special_discount_title').html(shipping_info[2]);
			$j('.special_discount_content').html(shipping_info[3]).show();
			$j('.vip_content').html(shipping_info[4]);
			
			if(shipping_info[4] == ''){
				$j('.vip_title').html('');
			}else{
				$j('.vip_title').html(shipping_info[5]);
			}
			
			if(shipping_info[7]){
				$j('.promotion_discount_full_set_minus_title').html(shipping_info[6]);
				$j('.promotion_discount_full_set_minus_content').html(shipping_info[7]);
			}

			if(data.show_volume_weight){
				$j('.show_volume_weight_tr').html(data.show_volume_weight);
			} else {
				$j('.show_volume_weight_tr').html("");
			}
			
			if(data.show_package_box_weight_str){
				$j('.show_package_box_weight_td').html(data.show_package_box_weight_str);
			}
			
			if(data.shipping_total_weight_str){
				$j('.shipping_total_weight_td').html(data.shipping_total_weight_str);
				$j('.total_weight_input').val(data.shipping_total_weight_str);
			}
		});
	});

	$j(".successtips1 img").live('click', function(){
		$j(".successtips1").hide();
	});
 
	$j('.view_shippping_weight').live('mouseover', function(){
		$j(this).children('.successtips_weight').show();
	}).live('mouseout', function(){
		$j(this).children('.successtips_weight').hide();
	});

	$j('.jq_show_successtips_coupon').live('mouseover', function(){
		$j('.successtips_coupon').show();
	}).live('mouseout', function(){
		$j('.successtips_coupon').hide();
	});

	$j(".quickaddcont .quickadd input[type='text']").live('keydown',function(event) {
		var key = event.keyCode;
		switch (key) {
			case 37: //left
			{
				if ($j(this).parent().prev().length >= 1) {
					$j(this).parent().prev().find("input").focus();
				}
				break;
			}
			case 38: //up
			{
				if ($j(this).parent().parent().prev().length >= 1) {
				$j(this).parent().parent().prev().children().children().eq($j(this).parent().prevAll().length).focus();
			}
				break;
			}
			case 39: //right
			{
				if ($j(this).parent().next().length >= 1) {
				$j(this).parent().next().find("input").focus();
			}
				break;
			}
			case 40: //down
			{
				if ($j(this).parent().parent().next().length >= 1) {
				$j(this).parent().parent().next().children().children().eq($j(this).parent().prevAll().length).focus();
			}
				break;
			}
			case 13: //回车
			{
				event.keyCode=9;
				break;
			}
			default:
			{
				break;
			}
		}
	});
}); 

$j(function(){
	if($j('.success_add_all_to_wishlist').length > 0){
		setTimeout(function(){
			$j('.success_add_all_to_wishlist').remove();
		}, 5000)
	}
});

$j(function(){
	$j('.jq_paypal_quick_payment').live('click', function(){
		var isLogin = $j('.isLogin').val();
		var link = 'index.php?main_page=shopping_cart';
		if(isLogin == 'yes'){
			openPaypalWindow();
			//window.location.href = './ipn_main_handler.php?action=setexpresscheckout&ec_cancel=1';
		}else{
			show_login_div(link);
		}
	});
	$j('.jq_checkbtn').live('click', function(){
		var isLogin = $j('.isLogin').val();
		var link = 'index.php?main_page=shopping_cart';
		var obj = $j(this);
		if(isLogin == 'yes'){
			$j.post("./shopping_cart_process.php", {action: 'shopcart_isvalid'},function(data){
				var data = process_json($j.trim(data));
				if(data.error > 0) {
					var text_yes = obj.data('yes');
					var text_no = obj.data('no');
					
					$j.confirm({
						'message'	: data.message,
						'buttons'	: {
							'&nbsp;'	: {
								'text'  : text_yes,
								'class'	: 'paynow_btn sureremove',
								'action': function(){
									window.location.href = 'index.php?main_page=shopping_cart';
								}
							},
							' '	: {
								'text'  : text_no ,
								'class'	: 'cancelremove',
								'action': function(){}
							}
						}
					});		
				}else{
					window.location.href = 'index.php?main_page=checkout_shipping';
				}
			});
		}else{
			show_login_div(link);
		}
	});
});
//eof
