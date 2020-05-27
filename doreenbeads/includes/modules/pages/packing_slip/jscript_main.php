<script>
$j(function(){
	//只允许输入数字
	$j('input[name="product_qty[]"]').live('keydown', function(e){
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

	$j('input[name="product_qty[]"]').live('keyup', function(){
		$j(this).val($j(this).val().replace(/\D/g,''));
		if($j(this).val() < 1){
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
	})

	$j('.quickadd_btn').live('click', function(){
		$j.post('./shopping_cart_process.php', {action:'quick_add_content'}, function(data){
			$j('#quick_add_content').html(data);
			re_pos('quickaddsmallwindow');
			var bodyHeight=($j(document).height()+'px');
			$j('.windowbody').css('height', bodyHeight).fadeTo(1000, 0.3);
			$j('.quickfind').css('display', 'block');
			$j(".quickaddcont .quickadd input[type='text']").eq(0).focus();
		})
	});
	$j('.smallwindowtit .addressclose').live('click', function(){
		$j('.quickfind').hide();
		$j('.windowbody').fadeOut();
	})
	$j('.windowbody').click(function(){
		$j('.quickfind').hide();
		$j('.windowbody').fadeOut();
	})
	$j('.jq_cart_normal .greybtn').live('click', function(){
		var oneline="<tr><td><input type='text' name='product_model[]'/></td><td><input type='text' name='product_qty[]' /></td></tr><tr><td><input type='text' name='product_model[]'/></td><td><input type='text' name='product_qty[]' /></td></tr>";
		$j('.quickadd').append(oneline);
	});
})

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
			data:{model:model, action:'check_model', qty:qty},
			success: function(data){
				//0 : wrong model; 2 : right model but no stock; default : right model and have stock;
				switch(data){
					case '0' : 
						thisone.parent().siblings('td').html('<input type="text" name="product_qty[]" class="inputdisable" disabled="disabled">');
						thisone.parent().html('<input type="text" name="product_model[]" class="inputwrong" value="'+model+'"><span class="textwrongicon1" title="<?php echo TEXT_CART_JS_WRONG_P_NO;?>"></span><p style="color:#ff0000;"><?php echo TEXT_CART_JS_WRONG_NO;?></p>');
					break;
					case '2' :
						thisone.parent().siblings('td').html('<input type="text" name="product_qty[]" class="inputdisable" disabled="disabled">');
						thisone.parent().html('<input type="text" name="product_model[]" class="inputwrong" value="'+model+'"><span class="warnicon1" title="<?php echo TEXT_CART_JS_NO_STOCK;?>"></span><p style="color:#ff0000;"><?php echo TEXT_NO_STOCK;?></p>');
					break;
					default : 
						var arr = data.split('|||');
						qty = arr[1];
						caution = arr[0];
						if(caution != ''){
							alert(caution);
						}
						thisone.parent().siblings('td').html('<input type="text" name="product_qty[]" value="'+qty+'"><span class="textrighticon1"></span>');
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

function check_qty(obj){
	var thisone = obj;
	var qty = $j.trim(thisone.val());
	var model = $j.trim(thisone.parent().siblings('td').children('input[name="product_model[]"]').val());
	if(qty > 0){
		$j.ajax({
			url: './shopping_cart_process.php',
			type: 'POST',
			async:false,
			data:{model:model, action:'check_qty', qty:qty},
			success: function(data){
				if(data != ''){
					var arr = data.split('|||');
					qty = arr[1];
					caution = arr[0];
					alert(caution);
					thisone.val(qty);
				}else{
					thisone.parent().html('<input type="text" name="product_qty[]" value="'+qty+'"><span class="textrighticon1"></span>');
				}				
			}
		});
	}
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

	$j('.quickadd input[name="product_qty[]"]').live('blur', function(){
		if($j(this).val()!=''){
			check_qty($j(this));
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
			})
				
			if($j('span.deleteicon_part').length > 0){
				sub = false;
			}
			
			if(!empty){
				if(sub){
					document.quick_add.submit();
				}else{
					$j('#quickaddsmallwindow .quickadd_sub .quickadd_sub_note').html('<?php echo TEXT_QUICKADD_ERROR_WRONG; ?>');
					$j('#quickaddsmallwindow .quickadd_sub').show();
				}
			}else{
				$j('#quickaddsmallwindow .quickadd_sub .quickadd_sub_note').html('<?php echo TEXT_QUICKADD_ERROR_EMPTY; ?>');
				$j('#quickaddsmallwindow .quickadd_sub').show();
			}
		}, 100);
		setTimeout(function(){
			$j('#quickaddsmallwindow .quickadd_sub').hide();
		}, 5000)
	});

	$j(".jq_cart_spreadsheet .paynow_btn").live("click", function() {
		var contentSpreadsheet = $j.trim($j("#content_spreadsheet").val());
		$j.post('./index.php?main_page=shopping_cart', {action: 'add_spreadsheet', content_spreadsheet: contentSpreadsheet}, function(data){
			$j("#content_spreadsheet").val("");
			var returnInfo = JSON.parse(data);
			if(returnInfo.msg != '') {
				$j(".jq_tips").html(returnInfo.msg);
			}
			if(returnInfo.error == true) {
				$j.post("./shopping_cart_process.php", {action: 'content', page: get_split_page()},function(data){
					var arr = data.split('|||');
					var data = arr[0];
					$j('.shopping_cart_main_content').html(data);
				});
			} else {
				setTimeout(function() {
					location.href = "index.php?main_page=shopping_cart";
				}, 3000);
			}
		});
		
	});

	$j(".jq_cart_spreadsheet .greybtn").live("click", function() {
		document.jq_export.submit();
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
</script>