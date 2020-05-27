/*
$(function(){
	if($('.customer_id').length > 0 && $('.customer_id').val() != ''){
		var customer_id = $('.customer_id').val();
		var weight = $('.total_weight_input').val();
		var volume_weight = $('.volume_weight').val();
		//bof 鼠标放上去显示重量
		$('.view_shippping_weight').live('mouseover', function(){
			$(this).children('.successtips_weight').show();
		}).live('mouseout', function(){
			$(this).children('.successtips_weight').hide();
		})
		//eof
		var ocountry = $('input[name="country_name"]').val();
		var ocity = $('.estimate_city').val();
		var opostcode = $('.estimate_postcode').val();
		
		//bof 页面刷新完后计算运费
		$.post('../shopping_cart_process.php', {action: 'cal', country_name: ocountry, city: ocity, postcode: opostcode, page: 1}, function(data){
			var arr = data.split('|||');
			if(typeof(JSON)=='undefined'){
				var returnInfo=eval('('+arr[0]+')');
			}else{
				var returnInfo=JSON.parse(arr[0]);
			}
			$('.shipping_content').html(returnInfo[0]);
		});
		//eof
	}

});
*/