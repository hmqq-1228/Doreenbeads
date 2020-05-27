function inArray(value, array){
	for(var i = 0; i < array.length; i++){
		if(value != '' && value == array[i]){
			return true;
		}
	}
	return false;
}
$(function(){
	$('.delete_day').live('click', function(){
		if($(this).parent().parent().next('tr.shipping_error').length > 0){
			$(this).parent().parent().next('tr.shipping_error').remove();
		}
		$(this).parent().parent().remove();
		if($('.table_country_time tr').length == 1){
			$('.table_country_time').html('<tr><td>所有:</td><td><input type="text" name="s_day_low[]"> <input type="text" name="s_day_high[]"></td></tr>');
		}
	});
	$('.table_country_time input').live('keyup change', function(){
		value = $(this).val();
		reg = /\D|^0{1,}/g;
		if(reg.test(value)){
			$(this).val(value.replace(reg, ''));
		}		
	});
	$('input[name="s_id"], input[name="s_discount"], input[name="s_extra_oil"], input[name="s_extra_amt"], input[name="s_extra_times"], input[name="currency"]').live('keyup change', function(){
		value = $(this).val();
		reg = /[^\.0-9]/g;
		if(reg.test(value)){
			$(this).val(value.replace(reg, ''));
		}		
	});
	var checkform = function(){
		var sub = true;
		//bof 添加运送方式时验证id, code, title
		if($('input[name="s_id"]').length > 0){
			var id = $.trim($('input[name="s_id"]').val());
			var code = $.trim($('input[name="s_code"]').val());			
			if(id == '' || isNaN(id) || id < 0){
				$('input[name="s_id"]').parent().append('<div class="shipping_error">ID必须为大于0的整数</div>');
				sub = false;
			}
			if(code == ''){
				$('input[name="s_code"]').parent().append('<div class="shipping_error">代码不能为空</div>');
				sub = false;
			}
			if(id != '' && code != ''){
				$.ajax({
					url: '../ajax_shipping.php',
					type: 'post',
					async: false,
					data: {action: 'check_exist', id: id, code: code},
					success: function(data){	//0:都不存在; 1：id存在; 2：code存在
						if(data == 1){
							$('input[name="s_id"]').parent().append('<div class="shipping_error">与既有ID冲突，请更改</div>');
							sub = false;
						}else if(data == 2){
							$('input[name="s_code"]').parent().append('<div class="shipping_error">与既有代码冲突，请更改</div>');
							sub = false;
						}
					}
				});
			}			
		}
		//eof
		//bof 验证汇率
		if($('input[name="currency"]').length > 0){
			currency = $.trim($('input[name="currency"]').val());
			if(currency == '' || isNaN(currency) || currency < 0){
				$('input[name="currency"]').parent().append('<div class="shipping_error">汇率必须为大于0的自然数</div>');
				sub = false;
			}
		}
		//eof
//		var title = $.trim($('input[name="s_title"]').val());
		var discount = $.trim($('input[name="s_discount"]').val());
		var oil = $.trim($('input[name="s_extra_oil"]').val());
		var extra_amt = $.trim($('input[name="s_extra_amt"]').val());
		var extra_times = $.trim($('input[name="s_extra_times"]').val());
		var ask_days = $.trim($('input[name="s_ask_days"]').val());
		var track_url = $.trim($('input[name="s_track_url"]').val());
		var re = /^[1-9]\d*$/g;
		/*if(title == ''){
			$('input[name="s_title"]').parent().append('<div class="shipping_error">前台显示名称不能为空</div>');
			sub = false;
		}*/
		if(discount <= 0){
			$('input[name="s_discount"]').parent().append('<div class="shipping_error">折扣必须大于0</div>');
			sub = false;
		}
		if(oil < 0){
			$('input[name="s_extra_oil"]').parent().append('<div class="shipping_error">燃油率不能小于0</div>');
			sub = false;
		}
		if(extra_amt == '' || extra_amt < 0){
			$('input[name="s_extra_amt"]').parent().append('<div class="shipping_error">额外费用不能小于0</div>');
			sub = false;
		}
		if(extra_times == '' || extra_times < 0){
			$('input[name="s_extra_times"]').parent().append('<div class="shipping_error">额外倍数不能小于0</div>');
			sub = false;
		}
		
		if(ask_days == "" || ask_days == undefined || ask_days == null)
		{	
			$('input[name="s_ask_days"]').parent().append('<div class="shipping_error">请填入回访时间！</div>');
			sub = false;
		}else if(ask_days.match(re) == null){
			$('input[name="s_ask_days"]').parent().append('<div class="shipping_error">只能填入非零的自然数！</div>');
			sub = false;
		}
		if (track_url.length > 0) {
			if (track_url.substring('0', '8') != 'https://' && track_url.substring('0', '7') != 'http://') {
				$('input[name="s_track_url"]').parent().append('<div class="shipping_error">网址格式有误，请重新填写（网址应以"http://"或"https://"开头）</div>');
				sub = false;
			};
		}
		
		//bof 国家不能重复
		var country_list = new Array();
		var country = $('input[name="country_id[]"]');
		for(var i = 0; i < country.length; i++){
			if(country[i].value != ''){
				country_list.push(country[i].value);
			}
		}
		$('select[name="country_id[]"]').each(function(){
			_thisValue = this.options[this.selectedIndex].value;
			if(country_list.length > 0){
				if(inArray(_thisValue, country_list)){
					$(this).parent().parent().after('<tr class="shipping_error"><td>国家重复！</td></tr>');
					sub = false;
				}else{
					country_list.push(_thisValue);
				}
			}else{
				country_list.push(_thisValue);
			}		
		});
		//eof
		
		//bof 所有国家和其他国家天数必填
		if($('.table_country_time tr').length == 1){
			if($('input[name="s_day_low[]"]').val() == '' || $('input[name="s_day_high[]"]').val() == ''){
				$('input[name="s_day_high[]"]').after('<div style="float:right;" class="shipping_error">必须填！</div');
				sub = false;
			}
		}
		if($('.country_time_else input[name="s_day_low[]"]').val() == '' || $('.country_time_else input[name="s_day_high[]"]').val() == ''){
			$('.country_time_else input[name="s_day_high[]"]').after('<div style="float:right;" class="shipping_error">必须填！</div');
			sub = false;
		}
		//eof
		
		return sub;
	};
	$('input[name="s_id"], input[name="s_code"], input[name="s_title"], input[name="s_discount"], input[name="s_extra_oil"], input[name="s_extra_amt"], input[name="s_extra_times"], input[name="currency"], input[name="method_code"]').focus(function(){
		$(this).siblings('div.shipping_error').remove();
	});
	$('input[name="s_day_low[]"], input[name="s_day_high[]"]').focus(function(){
		$(this).siblings('div.shipping_error').remove();
	});
	$('select[name="country_id[]"]').live('change', function (){
		$(this).parent().parent().next('tr.shipping_error').remove();
	});
	$('form[name="shipping"]').submit(function(){
		$('.shipping_error').remove();
		if(checkform()){
			return true;
		}else{
			return false;
		}
	});

	checkform_shipping_data = function(){
		var sub = true;
		var code = $.trim($('input[name="method_code"]').val());
		var p_file = $.trim($('input[name="postage_file"]').val());
		var c_file = $.trim($('input[name="country_file"]').val());
		if(code == ''){
			$('input[name="method_code"]').parent().append('<div class="shipping_error">代码不能为空！</div>');
			sub = false;
		}else if(p_file == '' && c_file == ''){
			alert('请至少上传一个文件！');
			sub = false;
		}
		return sub;
	};
	$('form[name="shipping_data"]').submit(function(){
		$('.shipping_error').remove();
		if(checkform_shipping_data()){
			return true;
		}else{
			return false;
		}
	});
})