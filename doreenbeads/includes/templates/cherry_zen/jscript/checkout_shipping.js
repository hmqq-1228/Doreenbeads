//bof checkout shipping
$j(function(){
	var stateStatus=$j('#new_address_book #stateZone').hasClass('hiddenField');
	var stateStatusHtml=$j('#new_address_book #stateZone').html();
	var countryId=$j('#new_address_book #zone_country_id').val();
	var countrySelected=$j('#new_address_book #cSelectId').val();
	var countryWords=$j('#new_address_book #country_choose .choose_single span:eq(0)').text();
	
//	show add/edit address box
	showbox = function(aid,bgid,imgid){
		var sheight=$j(window).scrollTop();
		var rheight=$j(window).height();
		var rwidth=$j(window).width();
		var wwidth=$j('.'+aid).width();
		var wheight=$j('.'+aid).height();
		//$j('.'+aid).css("top",(sheight+(rheight-wheight)/2)+"px");
		$j('.'+bgid).fadeTo(1000,0.3);
		$j('.'+aid).show();
		$j('.'+bgid).click(function(){
			$j('.'+bgid).fadeOut();
			$j('.'+aid).hide();
			// reinitInput();
		})
		$j('.'+imgid).click(function(){
			$j('.'+bgid).fadeOut();
			$j('.'+aid).hide();
			// reinitInput();
		})
		$j('#cancel_address').click(function(){
			$j('.'+bgid).fadeOut();
			$j('.'+aid).hide();
			// reinitInput();
			return false;
		})
	}
	
//	init input field
	reinitInput = function(){
		$j('#save_address').removeClass('isEditingAction');
		$j('#save_address').attr('aId','');
		$j("span .error").html('');

		$j('#gender').removeAttr('checked').eq(0).attr('checked','true');
		$j("#firstname").val('');
		$j("#lastname").val('');
		$j("#company").val('');
		$j("#street_address").val('');
		$j("#suburb").val('');
		$j("#city").val('');
		$j('#stateZone').val('');
		$j("input[name='state']").val('');
		$j("#postcode").val('');
		$j("#telephone").val('');
		$j("#tariff_number").val('');
		$j("#email_address").val('');
		$j("#country_choose .choose_single span").html(countryWords);
		$j('#cSelectId').val(countrySelected);
		$j('#zone_country_id').val(countryId);
		if(stateStatus){
			$j("input[name='state']").removeClass('hiddenField').addClass('visibleField');
			$j('#stateZone').addClass('hiddenField');
			$j("input[name='state']").attr('disabled',false);
		}else{
			$j('#stateZone').attr('disabled',false);
			$j('#stateZone').removeClass('hiddenField');
			$j('#stateZone').html(stateStatusHtml);
			$j("input[name='state']").removeClass('visibleField').addClass('hiddenField');
		}
	}
	
	$j('#tariff').live('blur',function(){
		var tariff = $j('#tariff').val();
		var tariff_alert = $j('#tariff_alert').val();
		if($j.trim(tariff) == "" && tariff_alert != ""){
			alert(tariff_alert);
			$j("html,body").animate({scrollTop: $j("#tariff").offset().top}, 800);
		}
		
	});
	
//	bof auto load ajax
var customer_num_val=$j('.caption_shopgray').eq(0).attr('numVal');
var customer_sto=$j('.caption_shopgray').eq(0).attr('sTo');
countClicks(30);
//	ajax address info
$j.post('ajax_checkout_step.php',{action:"address_info",
								  customer_num_val:customer_num_val,
								  customer_sto:customer_sto
								  },function(data){
	if(typeof(JSON)=='undefined'){
		var returnInfo=eval('('+data+')');
	}else{
		var returnInfo=JSON.parse(data);	
	}
	
	if(returnInfo.error){
		window.location.href=returnInfo.link;
	}else{
		$j('#shipping_address_show').fadeIn();
		if(returnInfo.show=='add'){
			$j('.captioncontent').eq(0).removeClass('captionloading');
			$j('#new_address_book').fadeIn();
		}else{
			$j('.captioncontent').eq(0).removeClass('captionloading').append(returnInfo.info);
		}		
	}	
	$j('.addresschioce input:radio[name="address"]').attr('disabled',true);	
	$j('.addresschioce').addClass('underShippingSelect');
	
	//	ajax shipping method
	$j.post('ajax_checkout_step.php',{action:"shipping_method"},function(data){
		if(typeof(JSON)=='undefined'){
			var returnInfo=eval('('+data+')');
		}else{
			var returnInfo=JSON.parse(data);	
		}	
		$j('.captioncontent').eq(1).removeClass('captionloading').html(returnInfo.info);
		$j('.shipway tr td input[name="shipping"]').attr('disabled',true);
		$j('.shipway').addClass('underShippingCaculate');

		//	ajax invoice comment
		$j.post('ajax_checkout_step.php',{action:"invoice_comment"},function(data){
			var data = process_json($j.trim(data));
			if(data.error == 0) {
				$j('.captioncontent').eq(2).removeClass('captionloading').html(data.body);

				//	ajax order review
				$j.post('ajax_checkout_step.php',{action:"review_order"},function(data){
					if(typeof(JSON)=='undefined'){
						var returnInfo=eval('('+data+')');
					}else{
						var returnInfo=JSON.parse(data);	
					}				
					if(returnInfo.error){
						window.location.href=returnInfo.link;
					}else{
						$j('#order_shopcart').removeClass('captionloading').addClass('order_shopcart').html(returnInfo.info);
						$j('.min_main').append(returnInfo.info_below);
						var cIdSto=$j('.caption_shopgray').eq(0).attr('sto');
						//if(cIdSto==''||cIdSto==0){
						//	$j('.min_main .cartftbtn a.nextbtnbig_yellow').addClass('butiswaiting');
						//}
					}
					$j('.addresschioce input:radio[name="address"]').attr('disabled',false);
					$j('.shipway tr td input[name="shipping"]').attr('disabled',false);
					$j('.shipway tr td input[name="shipping"].shipping_method_limit').attr('disabled',true);
					$j('.shipway').removeClass('underShippingCaculate');
					$j('.addresschioce').removeClass('underShippingSelect');
				});
			}
			
			
		});
		if($j('.shipway tr.selected').children().children('input[name="shipping"]').val() == 'chinapost_chinapost' && $j('.addresschioce tr.selected span.cInfo_country_id').attr('cid') == 176){
			var lan = $j('#lang').val();
			if(lan == 1){
				alert('Kind Note: EMS parcel to Russia may be delayed for 1-2 weeks due to excess parcels in Russia Post Office.');
			}
		}
		$j('.shipway tr th a.rise.casc').click();
	});
});
//	eof auto load ajax

//bof change addresschoice
$j('.addresschioce .selectThisTd').live('click',function(){
	$j('#firstname').css('border','1px solid #aaa');

	$j('#lastname').css('border','1px solid #aaa');

	$j('#street_address').css('border','1px solid #aaa');

	$j('#stateZone').css('border','1px solid #aaa');

	$j('#state').css('border','1px solid #aaa');

	$j("#country_choose").css('border','1px solid #aaa');

	$j('#city').css('border','1px solid #aaa');

	$j('#postcode').css('border','1px solid #aaa');

	$j('#telephone').css('border','1px solid #aaa');

	$j('.captioncontent').css('border','0px solid #ff0000');

	if(!$j(this).parents('tr').hasClass('selected') && !$j('.addresschioce').hasClass('underShippingSelect')){
		$j('.addresschioce tr.selected').find('span.spanD').show();
		$j('.addresschioce tr.selected').find('span.edit').hide();
		$j('.addresschioce tr.selected').removeClass('selected');
		$j(this).parents('tr').addClass('selected');
		$j(this).parents('tr').find('span.edit').show();
		$j(this).parents('tr').find('span.spanD').hide();

		$j('.addresschioce').addClass('underShippingSelect');
		$j('.addresschioce input:radio[name="address"]').attr('disabled',true);
		$j('.shipway').addClass('underShippingCaculate');
		$j('.shipway tr td input[name="shipping"]').attr('disabled',true);
		$j('.min_main .cartftbtn a.nextbtnbig_yellow').addClass('butiswaiting');

		$j(this).parents('tr').find('input[name="address"]').attr('checked',true);
		var aid = $j(this).parents('tr').find('input[name="address"]').attr('aId');
		$j('.caption_shopgray').eq(0).attr('sto',aid);

		$j.post("./ajax_address_book.php", {action:'choose_address',aId:''+aid+''},function(data){
			if(typeof(JSON)=='undefined'){
				var return_info=eval('('+data+')');
			}else{
				var return_info=JSON.parse(data);
				var address_info = return_info.address_info;
			}

			if(return_info.error){
				window.location.href=return_info.link;
			}

			$j("#zone_country_id").val(address_info.entry_country_id);
			var formEle=document.getElementsByName('new_address_book');
			update_zone_c_shipping(formEle[0]);

			$j("#firstname").val(address_info.entry_firstname);
			$j("#lastname").val(address_info.entry_lastname);
			$j("#street_address").val(address_info.entry_street_address);
			$j("#stateZone").val(address_info.entry_zone_id);
			$j("#city").val(address_info.entry_city);
			$j("#postcode").val(address_info.entry_postcode);
			$j("#telephone").val(address_info.telephone_number);
			$j("#state").val(address_info.entry_state);

			$j.post("./ajax_checkout_step.php", {action:'shipping_method',extra_info:1},function(data){
				if(typeof(JSON)=='undefined'){
					var returnInfo=eval('('+data+')');
				}else{
					var returnInfo=JSON.parse(data);
				}
				$j('.captioncontent').eq(1).html(returnInfo.info);
				$j('.total_price .details_price dl').html(returnInfo.extra_total);
				$j('.details_price .coupouDt span.arrow').remove();

				$j('.addresschioce').removeClass('underShippingSelect');
				$j('.addresschioce input:radio[name="address"]').attr('disabled',false);
				$j('.shipway').removeClass('underShippingCaculate');
				$j('.shipway tr td input[name="shipping"]').attr('disabled',false);
				$j('.shipway tr td input[name="shipping"].shipping_method_limit').attr('disabled',true);
				var cIdSto=$j('.caption_shopgray').eq(0).attr('sto');
				if(cIdSto!=0&&cIdSto!=''){
					$j('.min_main .cartftbtn a.nextbtnbig_yellow').removeClass('butiswaiting');
				}
				
				$j.post('ajax_checkout_step.php',{action:"invoice_comment"},function(data){
					var data = process_json($j.trim(data));
					if(data.error == 0) {
						$j('.captioncontent').eq(2).removeClass('captionloading').html(data.body);
					}
				});

			});
		});
	}
	$j('.shipway tr th a.rise.casc').click();
});
//	eof change addresschoice
$j(document).on('click','#show_all_shipping',function(){
	countClicks(40);
	$j('.not_show').removeClass('not_show').show();
	$j('.shipping_method_display_tips').remove();
});
//bof change sort of shipping method


$j('.shipway tr th a').live('click',function(){
	if($j(this).hasClass('casc')||$j(this).hasClass('cdes')){
		var shippingArr=new Array();
		var limitMethodArr = new Array();
		var notShowArr = new Array();
		shippingArr.length=0;
		var i=0;
		var countArr=new Array();
		countArr.length=0;
		var inputHtml='';
		var sort=$j(this).hasClass('casc')?'asc':'des';
		$j('.shipway tr').each(function(){
			if(!$j(this).hasClass('isTopTr') && !$j(this).hasClass('notecont')){
				var icost=$j(this).find('input[name="shipping"]').attr('icost');
				icost=Math.round(parseFloat(icost)*100);
				icost=icost*10000+i;
				countArr[i]=icost;
				var cclass = "";
				var hasClass = $j(this).attr("class");
				if(hasClass != undefined && hasClass != "") {
					cclass = " class=" + hasClass;
				}
				if ($j(this).hasClass('shipping_method_limit_class_tr')) {
					limitMethodArr[i] = '<tr '+cclass+'>'+$j(this).html()+'</tr>';
				}else if($j(this).hasClass('not_show')){
					notShowArr[i] = '<tr '+cclass+'>'+$j(this).html()+'</tr>';
				}else{
					shippingArr[icost]='<tr '+cclass+'>'+$j(this).html()+'</tr>';
				};
				i++;
				$j(this).remove();
			}
		});
		countArr.sort(function(a,b){
			return a<b?1:-1
		});
		if(sort=='asc'){
			countArr.reverse();
		}
		for(var j=0;j<countArr.length;j++){
			inputHtml+=shippingArr[countArr[j]];
		}
		for(var n=0;n<notShowArr.length;n++){
			inputHtml+=notShowArr[n];
		}
		for(var z=0;z<limitMethodArr.length;z++){
			inputHtml+=limitMethodArr[z];
		}
		$j('.shipway').append(inputHtml);
	}else if($j(this).hasClass('dasc')||$j(this).hasClass('ddes')){
		var shippingArr=new Array();
		var limitMethodArr = new Array();
		var notShowArr = new Array();
		shippingArr.length=0;
		var i=0;
		var countArr=new Array();
		countArr.length=0;
		var inputHtml='';
		var sort=$j(this).hasClass('dasc')?'asc':'des';
		$j('.shipway tr').each(function(){
			if(!$j(this).hasClass('isTopTr') && !$j(this).hasClass('notecont') && !$j(this).hasClass('shipping_method_limit_class_tr2')){
				var iday=$j(this).find('input[name="shipping"]').attr('iday');
				iday=iday.replace(/-/,'.');
				iday=Math.round(parseFloat(iday)*100);
				iday=iday*10000+i;
				countArr[i]=iday;
				var cclass = "";
				var hasClass = $j(this).attr("class");
				if(hasClass != undefined && hasClass != "") {
					cclass = " class=" + hasClass;
				}
				if ($j(this).hasClass('shipping_method_limit_class_tr')) {
					limitMethodArr[i] = '<tr '+cclass+'>'+$j(this).html()+'</tr>';
				}else if($j(this).hasClass('not_show')){
					notShowArr[i] = '<tr '+cclass+'>'+$j(this).html()+'</tr>';
				}else{
					shippingArr[iday]='<tr '+cclass+'>'+$j(this).html()+'</tr>';
				};
				
				if ($j(this).next().hasClass('shipping_method_limit_class_tr2')) {
					shippingArr[iday] += '<tr class="shipping_method_limit_class_tr2">'+$j(this).next().html()+'</tr>';
					$j(this).next().remove();
				};
				i++;
				$j(this).remove();
			}
		});
		countArr.sort(function(a,b){
			return a<b?1:-1
		});
		if(sort=='asc'){
			countArr.reverse();
		}
		for(var j=0;j<countArr.length;j++){
			inputHtml+=shippingArr[countArr[j]];
		}
		for(var n=0;n<notShowArr.length;n++){
			inputHtml+=notShowArr[n];
		}
		for(var z=0;z<limitMethodArr.length;z++){
			inputHtml+=limitMethodArr[z];
		}
		$j('.shipway').append(inputHtml);
	}
})
//	eof change sort of shipping method

//	bof change page of items
$j('#order_shopcart div.propagelist a').live('click',function(){
	var page=$j(this).attr('pageid');
	$j.post('ajax_checkout_step.php',{
			action:"review_order",page:page
		},function(data){
		if(typeof(JSON)=='undefined'){
			var returnInfo=eval('('+data+')');
		}else{
			var returnInfo=JSON.parse(data);
		}
		if(returnInfo.error){
			window.location.href=returnInfo.link;
		}else{
			$j('#order_shopcart').html(returnInfo.info);
		}
	})
})
//	eof change page of items

//	change shipping method
$j('.shipway tr .selectThisTd').live('click',function(){
	var par = $j(this).parent();
	if(!par.hasClass('selected') && !par.parents('.shipway').hasClass('underShippingCaculate') && !par.find('input[name="shipping"]').hasClass('shipping_method_limit')){
		par.addClass('selected').siblings().removeClass('selected');
		$j('.shipway tr td input[name="shipping"]').attr('checked',false);
		$j('.shipway tr td div.shipway_note_div').hide();
		par.find('input[name="shipping"]').attr('checked',true);
		par.find('div.shipway_note_div').show();
		$j('.shipway tr td input[name="shipping"]').attr('disabled',true);
		$j('.shipway').addClass('underShippingCaculate');
		$j('.min_main .cartftbtn a.nextbtnbig_yellow').addClass('butiswaiting');
		var shipping=par.find('input[name="shipping"]').val();
		
		$j.post("./ajax_checkout_step.php",{
			action:'update_shipping_address',
			shipping:''+shipping+''
		}, function(data){
			if(typeof(JSON)=='undefined'){
				var returnInfo=eval('('+data+')');
			}else{
				var returnInfo=JSON.parse(data);
			}
			if(returnInfo.error){
				window.location.href=returnInfo.link;
			}
			$j('.total_price .details_price dl').html(returnInfo.info);
			$j('.details_price .coupouDt span.arrow').remove();
			$j('.table_shipping_weight').html(returnInfo.weight_info);
			$j('.shipping_weight_total').html(returnInfo.shipping_total_weight);
			$j('.shipway tr td input[name="shipping"]').attr('disabled',false);
			$j('.shipway tr td input[name="shipping"].shipping_method_limit').attr('disabled',true);
			$j('.shipway').removeClass('underShippingCaculate');
			var cIdSto=$j('.caption_shopgray').eq(0).attr('sto');
			if(cIdSto!=0&&cIdSto!=''){
				$j('.min_main .cartftbtn a.nextbtnbig_yellow').removeClass('butiswaiting');
			}
			//	ajax invoice comment
			$j.post('ajax_checkout_step.php',{action:"invoice_comment"},function(data){
				var data = process_json($j.trim(data));
				if(data.error == 0) {
					$j('.captioncontent').eq(2).removeClass('captionloading').html(data.body);

					//	ajax order review
					$j.post('ajax_checkout_step.php',{action:"review_order"},function(data){
						if(typeof(JSON)=='undefined'){
							var returnInfo=eval('('+data+')');
						}else{
							var returnInfo=JSON.parse(data);	
						}				
						if(returnInfo.error){
							window.location.href=returnInfo.link;
						}else{
							$j('.total_price').remove();
							$j('.cartftbtn').remove();
							$j('#order_shopcart').removeClass('captionloading').addClass('order_shopcart').html(returnInfo.info);
							$j('.min_main').append(returnInfo.info_below);
							var cIdSto=$j('.caption_shopgray').eq(0).attr('sto');
							if(cIdSto==''||cIdSto==0){
								$j('.min_main .cartftbtn a.nextbtnbig_yellow').addClass('butiswaiting');
							}
						}
						$j('.addresschioce input:radio[name="address"]').attr('disabled',false);
						$j('.shipway tr td input[name="shipping"]').attr('disabled',false);
						$j('.shipway tr td input[name="shipping"].shipping_method_limit').attr('disabled',true);
						$j('.shipway').removeClass('underShippingCaculate');
						$j('.addresschioce').removeClass('underShippingSelect');
					});
				}

				
			});
		})
	}
});

$j(document).on('mouseover', '.shipping_method_limit_class_tr', function(){
 	$j(this).children('td').find('.pop_wrap .pop_note_tip').show();
}).on('mouseout', '.shipping_method_limit_class_tr', function(){
	$j(this).children('td').find('.pop_wrap .pop_note_tip').hide();
});

$j('.view_weight_detail').live('mouseover', function(){
	$j(this).children('.successtips_weight').show();
}).live('mouseout', function(){
	$j(this).children('.successtips_weight').hide();
});

//use coupon
$j('.total_price .left .btnsmall_yellow').live('click',function(){
	$j(this).attr('disabled',true).css('cursor','wait');
	$j('.min_main .cartftbtn a.nextbtnbig_yellow').addClass('butiswaiting');
	var cnum=0;
	$j.post('ajax_checkout_step.php',{action:'discount_coupou'},function(data){
		if(typeof(JSON)=='undefined'){
			var returnInfo=eval('('+data+')');
		}else{
			var returnInfo=JSON.parse(data);	
		}
		if(returnInfo.error){
			window.location.href=returnInfo.link;
		}else{
			if(returnInfo.error_info){
				$j('.submit_coupou_error').html(returnInfo.error_info);
			}else{
				if(returnInfo.show_select_coupon != ''){
					$j('.coupon-other').html(returnInfo.show_select_coupon);
				}
				$j('.submit_coupou_error').html('');
				/*
				$j('.total_price .left').eq(0).show();
				$j('.total_price .left').eq(1).remove();
				*/
				$j('.total_price .left .btnsmall_yellow').text($j('.total_price .left .btnsmall_yellow').attr('utext')).attr('disabled',false).css('cursor','pointer').removeClass('btnsmall_yellow').addClass('btnsmall_yellow1');
				$j('.details_price dl').html(returnInfo.order_info);
				if(typeof(ntc)!='undefined'){
					clearTimeout(ntc);
				}
				ntc=setTimeout(function(){
					$j('.details_price .coupouDt span.arrow').remove();
					},5000);
			}
		}
		$j('.total_price .left .btnsmall_yellow').attr('disabled',false).css('cursor','pointer');
		var cIdSto=$j('.caption_shopgray').eq(0).attr('sto');
		if(cIdSto!=0&&cIdSto!=''){
			$j('.min_main .cartftbtn a.nextbtnbig_yellow').removeClass('butiswaiting');
		}	
	})
})

//	when coupon select change . lvxiaoyong 20131231
$j(".total_price .left #coupon_select").live('change', function(){
	var sel_c = $j(this).val();
	if(sel_c==0 || sel_c==''){
		setDiscountCoupon(0);
	}else{
		setDiscountCoupon(sel_c);
	}
});
var setDiscountCoupon = function(coupon_id){
	$j.post('ajax_checkout_step.php',{action:'set_discount_coupou',couponId:coupon_id},function(data){
		if(typeof(JSON)=='undefined'){
			var returnInfo=eval('('+data+')');
		}else{
			var returnInfo=JSON.parse(data);	
		}
		if(returnInfo.error){
			window.location.href=returnInfo.link;
		}else{
			if(returnInfo.error_info){
				$j('.submit_coupou_error').html(returnInfo.error_info);
			}else{
				if(returnInfo.hide_first_coupon){
					$j('.btnsmall_yellow').attr('class', 'btnsmall_yellow1 hide_first_coupon');
				}else{
					$j('.hide_first_coupon').attr('class', 'btnsmall_yellow');
				}
				$j('.submit_coupou_error').html('');
				$j('.details_price dl').html(returnInfo.order_info);
				if(typeof(ntc)!='undefined'){
					clearTimeout(ntc);
				}
				ntc=setTimeout(function(){
					$j('.details_price .coupouDt span.arrow').remove();
					},5000);
			}
		}
		$j('.total_price .left .btnsmall_yellow2').attr('disabled',false).css('cursor','pointer');
	})
}

//	address error tips hide
$j('.myrequired').focus(function(){
	$j(this).parent('td').next('td').children('span').text('');
	$j(this).next('.error').text('');
});
$j('select[name=zone_id]').focus(function(){
	$j(this).parent('td').children('span').text('');
	$j(this).next('.error').text('');
});
$j('input[name=state]').focus(function(){
	$j(this).parent('td').children('span').text('');
	$j(this).next('.error').text('');
});
$j('.firstname').focus(function(){
	$j('.firstn_error').text(''); 
});
$j('.lastname').focus(function(){
	$j('.lastn_error').text(''); 
});
$j('.suburb').focus(function(){
	$j('.suburb_error').html('');
});

//	address edit tip hide
$j('.question_icon').live('mouseover',function(){
	$j(this).next('div').show(); 
}).live('mouseout',function(){
	$j(this).next('div').hide(); 
});


$j('.pay_remain_shipping_text').live('mouseover',function(){
	$j(this).next('div').show(); 
}).live('mouseout',function(){
	$j(this).next('div').hide(); 
});
$j(document).ready(function(){

	$j('.image_down_arrow').live('click', function(){
		$j('.image_down_arrow').hide();
		$j('.image_up_arrow').show();
		$j('.price_sub').show();
	});
	$j('.image_up_arrow').live('click', function(){
		$j('.image_down_arrow').show();
		$j('.image_up_arrow').hide();
		$j('.price_sub').hide();
	});
	$j('.image_down_arrows').live('click', function(){
		$j('.image_down_arrows').hide();
		$j('.image_up_arrows').show();
		$j('.price_subs').show();
	});
	$j('.image_up_arrows').live('click', function(){
		$j('.image_down_arrows').show();
		$j('.image_up_arrows').hide();
		$j('.price_subs').hide();
	});
});
//	shipping info tip
$j('.captioncontent span').live('click', function(){
	var _index=$j(this).parents().find('span').index($j(this));
	if($j(this).attr('class')=='close'){
		$j(this).removeClass('close').addClass('open').siblings('span').removeClass('close').addClass('open');
		$j(this).siblings('div.notecontent').find('dl dd p').eq(_index).hide().siblings('p').hide();
		$j(this).siblings('div.notecontent').hide();
		
	}else if($j(this).attr('class')=='open'){
		$j(this).removeClass('open').addClass('close').siblings('span').removeClass('close').addClass('open');
		$j(this).siblings('div.notecontent').find('dl dd p').eq(_index).show().siblings('p').hide();
		$j(this).siblings('div.notecontent').show();
	}
})
$j('.notecontent dl dt ins').live('click',function(){
	$j(this).parents('.notecontent').hide();
	$j(this).parents('.notecontent').parent().children('span.close').attr('class','open');
})

//	comment lenth
$j('.invoiceform #areacomment').live('keyup',function(){
	if($j(this).val().length>1000){
		$j(this).val($j(this).val().substr(0,1000));
	}
	$j(this).next().children("span.len").text(1000-$j(this).val().length);
})

//	pack tips
$j('.packtips .question_icon').live('mouseover',function(){
	$j(this).parent('span').next('.packnotice').show();
}).live('mouseout',function(){
	$j(this).parent('span').next('.packnotice').hide();
});

//	confirm window
$j('.extrawindow .purplecolor_btn').live('click',function(){
	var pack = $j('.extrawindow .packing_title_div :radio:checked').val();
	if(pack){
		var selected = $j('.extrawindow .packing_title_div input').index($j(".extrawindow .packing_title_div :radio:checked"));
		$j('.cartftbtn .packtips').find('input[name="packingway"]').eq(selected).attr('checked','true');
		$j('.extrawindow').hide();
		$j('.windowbody').fadeOut();
		$j('.min_main .cartftbtn a.nextbtnbig_yellow').click();
	}else{
		$j('.extrawindow .error_packing_info').show();
	}
})
$j('.extrawindow .greycolor_btn').live('click',function(){
	$j('.extrawindow').hide();
	$j('.windowbody').fadeOut();
})  
$j('.extra_tips font').live('mouseover',function(){
	$j(this).next('.extratips').show();
}).live('mouseout',function(){
	$j(this).next('.extratips').hide();
})

//	product list show and hide
$j('.shopcart_content .more a').live('click',function(){
	if($j(this).hasClass('close')){
		$j(this).addClass('open').removeClass('close');
		$j('.shopcart_content tr.hideTheTr').hide();
	}else{
		$j(this).addClass('close').removeClass('open');
		$j('.shopcart_content tr.hideTheTr').show();
	}
})

$j(".details_price .subtotal ins").live('mouseover', function(){
	$j(this).next(".subtotal_tips").show();
}).live('mouseout', function(){
	$j(this).next(".subtotal_tips").hide();
});

//country field click
$j('#new_address_book .choose_single').unbind('click').live('click',function(){
	$j('#stateZone').val('');
	var ifshow=$j('#new_address_book .country_select_drop').css('display');
	current=$j("#new_address_book #cSelectId").val();
	if(ifshow=="none"){
		$j('#new_address_book .country_select_drop').show();
		$j(this).removeClass('choose_single_focus');
		$j(this).addClass('choose_single_click');
		$j('#new_address_book .country_select_drop .choose_search input').val('');
		$j('#new_address_book .country_select_drop ul .country_list_item').css('display','block');
		$j('#new_address_book .country_select_drop .choose_search input').focus();
		cNum=$j('#new_address_book #cSelectId').val();
		if($j("#new_address_book #country_list_"+cNum).hasClass('country_list_item_selected')&&!$j("#new_address_book #cSelectId").hasClass('selectNeedList')){			
		}else{
			$j("#new_address_book #cSelectId").removeClass('selectNeedList');
			$j("#new_address_book #country_list_"+cNum).addClass('country_list_item_selected');
			boxTop1=$j("#new_address_book #country_list_1").position().top;
			boxTop2=$j("#new_address_book #country_list_"+cNum).position().top;
			selfHeight=$j("#new_address_book #country_list_"+cNum).height()+8+7;
			boxTop=boxTop2-boxTop1-220+selfHeight;
			$j('#new_address_book .country_select_drop ul').scrollTop((boxTop));
		}
	}else{
		$j('#new_address_book .country_select_drop').hide();
		$j(this).removeClass('choose_single_click');
		$j(this).addClass('choose_single_focus');
	}
})

//	country item hover
$j('#new_address_book .country_list_item').hover(function(){
	$j(this).addClass('country_list_item_hover');
	$j('#new_address_book .country_list_item').removeClass('country_list_item_selected');
},function(){
	$j(this).removeClass('country_list_item_hover');
})	

//	country item click 
$j('#new_address_book .country_list_item').unbind('click').live('click',function(){	
	var cListId=$j(this).attr('clistid');
	var cText=$j(this).text();
	var cId=$j(this).attr('id');
	var zip_code_rule = $j.trim($j(this).attr('zip_code_rule'));
	var zip_code_example = $j.trim($j(this).attr('zip_code_example'));
	cIdArr=cId.split('_');
	getCId=cIdArr[2];
	$j('#select_coutry_zip_code_info').attr('zip_code_rule',zip_code_rule);
	$j('#select_coutry_zip_code_info').attr('zip_code_example',zip_code_example);
	$j('#new_address_book .choose_single span').text(cText);
	$j('#new_address_book #zone_country_id').val(cListId);
	$j('#new_address_book #cSelectId').val(getCId);
	$j(this).addClass('country_list_item_selected');
	$j('#new_address_book .country_select_drop').hide();
	
	$j('#new_address_book .choose_single').removeClass('choose_single_click');
	$j('#new_address_book .choose_single').addClass('choose_single_focus');
	$j('#new_address_book .choose_single').focus();
	formEle=document.getElementsByName('new_address_book');
	update_zone_c_shipping(formEle[0]);
})	

$j('#new_address_book .choose_single').blur(function(){
	$j(this).removeClass('choose_single_focus');
})

$j('#new_address_book .choose_search input').keyup(function(){
	inputVal=$j(this).val();
	inputVals=inputVal.replace(/^\s*|\s*$/g, "");
	if(inputVals!=''){
		$j('#new_address_book .country_select_drop ul').scrollTop(0);
		$j("#new_address_book #cSelectId").addClass('selectNeedList');
		$j("#new_address_book .country_select_drop ul .country_list_item").each(function(){
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
		$j('#new_address_book .country_select_drop ul .country_list_item').css('display','block');
	}
})
// submit order
	$j('.min_main .cartftbtn a.nextbtnbig_yellow').live('click',function(){
		var tariff = $j('#tariff').val();
		var tariff_alert = $j('#tariff_alert').val();
		if($j.trim(tariff) == "" && $j.trim(tariff_alert) != ""){
			alert(tariff_alert);
			$j("html,body").animate({scrollTop: $j("#tariff").offset().top}, 800);
			return false;
		}
		if($j(this).hasClass('butiswaiting')) return false;

		var submiterror=false;
		var address=$j('.caption_shopgray').eq(0).attr('sto');
		var shipping=$j('.shipway	input[name="shipping"]:checked').val();
		var orderComments=$j('.invoiceform #areacomment').val();
		var packingway=$j(".cartftbtn .packtips :radio:checked").val();
		var coupon_customers_id=$j('#coupon_select').val();
		var error_type = '';

		$j('#firstname').on('focus',function(){
			$j('#firstname').css('border','1px solid #aaa');
		});
		
		$j('#lastname').on('focus',function(){
			$j('#lastname').css('border','1px solid #aaa');
		});
		
		$j('#street_address').on('focus',function(){
			$j('#street_address').css('border','1px solid #aaa');
		});
		
		$j('#stateZone').on('focus',function(){
			$j('#stateZone').css('border','1px solid #aaa');
		});
		
		$j('#state').on('focus',function(){
			$j('#state').css('border','1px solid #aaa');
		});

		$j("#country_choose").css('border','1px solid #aaa');
		
		$j('#city').on('focus',function(){
			$j('#city').css('border','1px solid #aaa');
		});
		
		$j('#postcode').on('focus',function(){
			$j('#postcode').css('border','1px solid #aaa');
		});
		
		$j('#telephone').on('focus',function(){
			$j('#telephone').css('border','1px solid #aaa');
		});

		$j('.captioncontent').css('border','0px solid #ff0000');

		var hre = window.location.href.split("#");
		if(orderComments.length>1000){
			$j('.captioncontent').eq(2).css('border','1px solid #ff0000');
			window.location = hre[0]+'#marked3';
			submiterror=true;
		}
		if(!shipping || shipping=='' || shipping==0 || shipping==undefined){
			$j('.captioncontent').eq(1).css('border','1px solid #ff0000');
			window.location = hre[0]+'#marked2';
			submiterror=true;
		}

		// if(!address || address=='' || address==0 || address==undefined){

		var first_name = $j('.addresschioce .selected').find('.cInfo_fname').html();
		var last_name = $j('.addresschioce .selected').find('.cInfo_lname').html();
		var street_address = $j('.addresschioce .selected').find('.cInfo_street').html();
		var state_zone = $j('.addresschioce .selected').find('.cInfo_zone_id').attr('zone_id');
		var country = $j('.addresschioce .selected').find('.cInfo_country_id').html();
		var city = $j('.addresschioce .selected').find('.cInfo_city').html();
		var postcode = $j('.addresschioce .selected').find('.cInfo_postcode').html();
		var telephone = $j('.addresschioce .selected').find('.cInfo_telephone').html();
		// var language = $j("#languages_id").val();
		var state = $j('.addresschioce .selected').find('.cInfo_state').html();
			// }

			if(first_name.length < 1){
				$j("#firstname").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			if(last_name.length < 1){
				$j("#lastname").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			if(street_address.length < 5){
				$j("#street_address").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			
			// if(language == 3){
				if(state.length < 2 && state_zone < 1){
					$j("#state").css('border','1px solid #ff0000');
					$j("#stateZone").css('border','1px solid #ff0000');
					error_type = 'marked1';
					submiterror=true;
				}
			// }else{
			// 	if(){
			// 		$j("#stateZone").css('border','1px solid #ff0000');
			// 	}
			// }

			if(country <= 0){
				$j("#country_choose").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			
			if(city.length < 3){
				$j("#city").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			if(postcode.length < 3){
				$j("#postcode").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			if(telephone.length < 3){
				$j("#telephone").css('border','1px solid #ff0000');
				error_type = 'marked1';
				submiterror=true;
			}
			// window.location = hre[0]+'#marked1';
			// submiterror=true;
		// }
		if(submiterror == true) {
			$j('.captioncontent').eq(0).css('border','1px solid #ff0000');
			window.location = hre[0]+'#'+error_type;

			return false;
		}
		if(!packingway){
			$j('.extrawindow .error_packing_info').hide();
			showbox('extrawindow','windowbody','checkoutclose');
			var h = $j(document).height();
			var packing_choose = $j('#packing_choose').val();
			//alert($j('#packing_choose').val());
			if(packing_choose == 3){
				$j('.extra_tips').hide();
			}
			$j('.packing_title_div').html($j('.packtips').html());
			$j('.packing_title_div').find('span').hide();
			
			//$j('.packingWay').html($j('.packtipstit').html());
			$j(".windowbody").css("height",h);	 
			submiterror=true;
		}

		if(!submiterror){
			$j(this).addClass('butiswaiting').addClass('btn_disablegrey').text($lang.TextProcess);
			$j.post("./ajax_create_order.php", {
				action:'create_order',
				address:address,
				shipping:shipping,
				tariff:tariff, 
				orderComments:orderComments,
				packingway:packingway,
				coupon_customers_id:coupon_customers_id
			},function(data){
				if(typeof(JSON)=='undefined'){
					var returnInfo=eval('('+data+')');
				}else{
					var returnInfo=JSON.parse(data);
				}
				window.location.href=returnInfo.link;
			})
		}
	})
	
	//	bof delete address
	$j('td span.spanD').live('click',function(){		
		var vIndex=$j('.addresschioce tr').index($j(this).parents('tr'));
		var vlength=$j('.addresschioce tr').length;
		var addId=$j('.addresschioce input:radio[name="address"]').eq(vIndex).attr('aId');	
		var sto=$j('.caption_shopgray').eq(0).attr('sto');
		if(confirm($lang.TEXT_SURE_DELETE_ADDRESS)){
			$j('.addresschioce input:radio[name="address"]').attr('disabled',true);
			$j.post("./ajax_address_book.php",{action:'delete_address',aId:''+addId+'',sto:sto},function(data){
				if(typeof(JSON)=='undefined'){
					var return_info=eval('('+data+')');
				}else{
					var return_info=JSON.parse(data);	
				}
				if(return_info.error){
					window.location.href=return_info.link;
				}							
				if(vlength==10){
					$j('.addresschioce').append('<p><a href="javascript:void(0);" class="greybtn addaddress"><span>'+$lang.TEXT_ENTER_A_ADDRESS+'</span></a></p>');
				}
				$j('.addresschioce tr').eq(vIndex).remove();
				$j('.addresschioce input:radio[name="address"]').attr('disabled',false);
				$j.post('ajax_checkout_step.php',{action:"invoice_comment"},function(data){
					var data = process_json($j.trim(data));
					if(data.error == 0) {
						$j('.captioncontent').eq(2).removeClass('captionloading').html(data.body);
					}
				});
			})
		}
	});
	//	eof delete address

	//	bof button to add/edit address
	$j('.addaddress').live('click',function(){
		showbox('windowaddress','windowbody','addressclose');
		var h = $j(document).height();
		$j(".windowbody").css("height",h);
		$j('.windowaddress td .error').text('');
		$j('.windowaddress #firstname').focus();
		$j('#new_address_book.addrform').remove();

		$j('.windowaddress .smallwindowtit strong').text($lang.TEXT_ENTER_A_ADDRESS);
		//	for edit
		if($j(this).hasClass('edit')){
			$j('.windowaddress .smallwindowtit strong').text($lang.TEXT_EDIT_ADDRESS);
			$j('.windowaddress #save_address').addClass('isEditingAction');
			var aId = $j(this).parents('tr').find("input:radio").attr('aId');
			$j('.windowaddress #save_address').attr('aId', aId);
			var nIndex=$j('.addresschioce tr td span.edit').index($j(this));
			var cgender=$j('.addresschioce span.cInfo_fname').eq(nIndex).attr('cgender');
			if(cgender=='m'){
				$j('.windowaddress #gender').removeAttr('checked').eq(0).attr('checked','true');
			}
			else{
				$j('.windowaddress #gender').removeAttr('checked').eq(1).attr('checked','true');
			}

			$j("#firstname").val($j('.addresschioce  span.cInfo_fname').eq(nIndex).text());
			$j("#lastname").val($j('.addresschioce  span.cInfo_lname').eq(nIndex).text());
			$j("#company").val($j('.addresschioce	span.cInfo_company').eq(nIndex).text());
			$j("#street_address").val($j('.addresschioce  span.cInfo_street').eq(nIndex).text());
			$j("#suburb").val($j('.addresschioce  span.cInfo_suburb').eq(nIndex).text());
			$j("#city").val($j('.addresschioce	span.cInfo_city').eq(nIndex).text());
			var cId=$j('.addresschioce  span.cInfo_country_id').eq(nIndex).attr('cId');
			$j('#zone_country_id').val(cId);
			$j(".windowaddress .country_select_drop ul li").each(function(){
				if($j(this).attr('clistid')==cId){
					$j('#country_choose .choose_single span').html($j(this).text());
					$j(".country_select_drop ul .country_list_item").removeClass('country_list_item_selected');
					$j('#cSelectId').val($j(".country_select_drop ul li").index($j(this))+1);
					$j('#select_coutry_zip_code_info').attr('zip_code_rule', $j(this).attr('zip_code_rule'));
					$j('#select_coutry_zip_code_info').attr('zip_code_example', $j(this).attr('zip_code_example'));
					return false;
				}
			})
			var formEle=document.getElementsByName('new_address_book');
			update_zone_c_shipping(formEle[0]);
			if($j('.addresschioce  span.cInfo_state').eq(nIndex).hasClass('cInfo_zone_id')){
				$j('#stateZone').val($j('.addresschioce  span.cInfo_state').eq(nIndex).attr('zone_id'));
			}else{
				$j("input[name='state']").val($j('.addresschioce  span.cInfo_state').eq(nIndex).text());
			}
			$j("#postcode").val($j('.addresschioce  span.cInfo_postcode').eq(nIndex).text());
			$j("#telephone").val($j('.addresschioce  span.cInfo_telephone').eq(nIndex).text());
			$j("#tariff_number").val($j('.addresschioce  span.cInfo_tariff').eq(nIndex).text());
			$j("#email_address").val($j('.addresschioce  span.cInfo_email').eq(nIndex).text());
		}else{
			$j("#gender").val('m');
			$j("#firstname").val('');
			$j("#lastname").val('');
			$j("#street_address").val('');
			$j("#suburb").val('');
			$j("#city").val('');
			$j('#zone_country_id').val(223);
			$j(".country_select_drop ul li").each(function(){
				if($j(this).attr('clistid')==223){
					$j('#country_choose .choose_single span').text($j(this).text());
					$j(".country_select_drop ul .country_list_item").removeClass('country_list_item_selected');
					$j('#cSelectId').val($j(".country_select_drop ul li").index($j(this))+1);
					$j('#select_coutry_zip_code_info').attr('zip_code_rule', $j(this).attr('zip_code_rule'));
					$j('#select_coutry_zip_code_info').attr('zip_code_example', $j(this).attr('zip_code_example'));
					return false;
				}
			});
			var formEle=document.getElementsByName('new_address_book');
			update_zone_c_shipping(formEle[0]);
			$j('#stateZone').val('');
			$j('#state').val('');
			$j("#company").val('');
			$j("#postcode").val('');
			$j("#telephone").val('');
			$j("#tariff_number").val('');
			$j("#email_address").val('');
		}
	})
	//	eof button to add/edit address

	//	bof save address click
	$j("#save_address").live('click',function(){
		var error_data =false;
		var form = $j(this).parents("form");
		var gender=$j(form).find('#gender').val();
		var first_name = $j(form).find('#firstname').val();
		var last_name = $j(form).find('#lastname').val();
		var street_address = $j(form).find('#street_address').val();
		var suburb = $j(form).find('#suburb').val();
		var zone_country_id=$j(form).find("#zone_country_id").val();
		var zone_id=$j(form).find('#stateZone').val();
		var state = $j(form).find("input[name='state']").val();
		var city = $j(form).find('#city').val();	
		var postcode = $j(form).find('#postcode').val();
		var telephone = $j(form).find('#telephone').val();
		var company = $j(form).find('#company').val();
		var tariff_number = $j(form).find('#tariff_number').val();
		var backup_email_address = $j(form).find('#email_address').val();
		var zip_code_rule = $j.trim($j('#select_coutry_zip_code_info').attr('zip_code_rule'));
		var zip_code_rule_reg = new RegExp(zip_code_rule, 'i');
		var zip_code_example = $j.trim($j('#select_coutry_zip_code_info').attr('zip_code_example'));
		
		if(first_name.length<1){
			error_data =true;
			$j(form).find(".firstn_error").html($lang.TEXT_PLEASEENTER_CHARLEAST_2);
		}
		
		if(first_name == last_name && first_name != ''){
			error_data = true;
			$j(form).find(".lastn_error").html($lang.ENTRY_FL_NAME_SAME_ERROR);
		}
		
		if(last_name.length<1){
			error_data =true;
			$j(form).find(".lastn_error").html($lang.TEXT_PLEASEENTER_CHARLEAST_2);
		}

		if(street_address.length<5){
			error_data =true;
			$j(form).find(".street_error").html($lang.TEXT_PLEASEENTER_CHARLEAST_5);
		}
		
		if(city.length<3){
			error_data =true;
			$j(form).find(".city_error").html($lang.TEXT_PLEASEENTER_CHARLEAST_3);
		}
		
		var stateShow =$j('#stateZone').hasClass('hiddenField')?true:false;
		if((state.length<2&&stateShow)||(!stateShow&&zone_id=='')){
			error_data =true;
			$j(form).find(".state_error").html($lang.TEXT_PLEASEENTER_RIGHTSTATE);
		}
		
		if(postcode.length<3){
			error_data =true;
			$j(form).find(".postcode_error").html($lang.TEXT_PLEASEENTER_CHARLEAST_3);
		}else{
			if(zip_code_rule != ''){
				if(!zip_code_rule_reg.test(postcode)){
					error_data =true;
					$j(form).find(".postcode_error").html($lang.CHECKOUT_ZIP_CODE_ERROR + zip_code_example.replace(',' , ' ' + $lang.TEXT_OR + ' '));
				}
			}
		}
		
		if(telephone.length<3){
			error_data =true;
			$j(form).find(".telephone_error").html($lang.TEXT_PLEASEENTER_CHARLEAST_3);
		}
	
		if(street_address == suburb && street_address != ''){
			error_data =true;							
			$j(form).find(".suburb_error").html($lang.ENTRY_FS_ADDRESS_SAME_ERROR);
		}
		zone_id_num=$j(form).find('#stateZone').hasClass('hiddenField')?'0':zone_id;
		
		if(error_data == false){
			$j('.captioncontent').css('border','0px solid #ff0000');
			$j(form).find('#save_address').attr('disabled',true);
			$j('#save_address').css('cursor','wait');
			if($j(form).find('#save_address').hasClass('isEditingAction')){
				aId=$j(form).find('#save_address').attr('aId');
			}else{
				aId='';
			}
			$j.post("./ajax_address_book.php",{
				action:'new_address',
				aId:aId,
				first:first_name,
				last:last_name,
				gender:gender,
				street_address:street_address,
				suburb:suburb,
				city:city,
				zone_country_id:zone_country_id,
				state:state,
				zone_id:zone_id_num,
				postcode:postcode,
				telephone:telephone,
				tariff_number:tariff_number,
				backup_email_address:backup_email_address,
				company:company
				},function(data){
					if(typeof(JSON)=='undefined'){
						var return_info=eval('('+data+')');
					}else{
						var return_info=JSON.parse(data);	
					}
					if(!return_info.error){
						if(return_info.error_info!=''){
							$j(form).find('.error_div_info').remove();
							$j(form).find('#new_address_book').append('<div class="error_div_info">'+return_info.error_info+'</div>');
						}else{
							$j('.addresschioce').remove();
							$j('.windowbody').fadeOut();
							$j('.windowaddress').hide();
							$j("#new_address_book.addrform").fadeOut();
							reinitInput();
							if(return_info.sendto!='undefined'){
								$j('.caption_shopgray').eq(0).attr('sto',return_info.sendto);
							}
							$j('.captioncontent').eq(0).append(return_info.reinfo);
						}
					}
					$j('#save_address').attr('disabled',false);
					$j('#save_address').css('cursor','pointer');
					var sToId=$j('.caption_shopgray').eq(0).attr('sto');
					if((aId==sToId&&aId!='')||aId==''){
						$j('.addresschioce input:radio[name="address"]').attr('disabled',true);
						$j('.min_main .cartftbtn a.nextbtnbig_yellow').addClass('butiswaiting');
						$j('.shipway tr td input[name="shipping"]').attr('disabled',true);
						$j('.shipway').addClass('underShippingCaculate');
						$j('.addresschioce').addClass('underShippingSelect');
						$j.post("./ajax_checkout_step.php", {
							action:'shipping_method',
							extra_info:1
							},function(data){
								if(typeof(JSON)=='undefined'){
									var returnInfo=eval('('+data+')');
								}else{
									var returnInfo=JSON.parse(data);	
								}
								/*
								$j('.captioncontent').eq(1).html(returnInfo.info);
								$j('.total_price .details_price dl').html(returnInfo.extra_total);
								$j('.addresschioce input:radio[name="address"]').attr('disabled',false);
								$j('.shipway tr td input[name="shipping"]').attr('disabled',false);
								$j('.shipway tr td input[name="shipping"].shipping_method_limit').attr('disabled',true);
								$j('.shipway').removeClass('underShippingCaculate');
								$j('.addresschioce').removeClass('underShippingSelect');
								var cIdSto=$j('.caption_shopgray').eq(0).attr('sto');
								if(cIdSto!=0&&cIdSto!=''){
									$j('.min_main .cartftbtn a.nextbtnbig_yellow').removeClass('butiswaiting');
								}
								$j.post('ajax_checkout_step.php',{action:"invoice_comment"},function(data){
									var data = process_json($j.trim(data));
									if(data.error == 0) {
										$j('.captioncontent').eq(2).removeClass('captionloading').html(data.body);
									}
								});
								*/
								window.location.reload();
						});
					}
			});
		}		
		return false;
	});
	//	eof save address click

	$j("#add_coupon_code").live('focus',function(){
		var v = $j.trim($j(this).val());
		if(v == $lang.TEXT_ENTER_A_COUPON_CODE)
			$j(this).val('');
	}).live('blur' , function(){
		var v = $j.trim($j(this).val());
		if(v == '')
			$j(this).val($lang.TEXT_ENTER_A_COUPON_CODE);
	})
		
})

function hideStateField(theForm) {
	theForm.state.disabled = true;
	theForm.state.className = 'hiddenField';
	theForm.zone_id.disabled = false;
	theForm.state.setAttribute('className', 'hiddenField');
	theForm.zone_id.className = 'inputLabel visibleField';
	theForm.zone_id.setAttribute('className', 'visibleField');
}
function showStateField(theForm) {
	theForm.state.disabled = false;
	theForm.zone_id.className = 'hiddenField';
	theForm.zone_id.disabled = true;
	theForm.state.className = 'inputLabel visibleField';
	theForm.state.setAttribute('className', 'visibleField');	
}
function popupWindowPrice(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=400,screenX=150,screenY=150,top=150,left=150')
}

function doAddCoupon(){
	var code = $j.trim($j("#add_coupon_code").val());
	var coupon_show_id = $j(".coupon-other").length + 1;
	
	if($j("#coupon_select_display").length > 0){
		coupon_show_id--;
	}

	$j.post('ajax_checkout_step.php',{action:'add_coupon',code:code,coupon_show_id:coupon_show_id}, function(data){
		var returnInfo = process_json(data);
		$j("#add_coupon_tip").html("");
		
		if(returnInfo.is_error){
			$j("#add_coupon_tip").html(returnInfo.error_info);
			
			if(returnInfo.link != ''){
				window.location.href=returnInfo.link;
			}
		}else{
			if($j("#coupon_select_display").length > 0){
				$j("#coupon_select_display").remove();
			}
			$j(".coupon-other:last").after(returnInfo.coupon_display);
			$j('.details_price dl').html(returnInfo.order_info);
//			$j('.tips_right').html(returnInfo.prom_discount_str);
			$j('#add_coupon_tip').html(returnInfo.success_info);
		}
	});

	return false;
}
//eof
