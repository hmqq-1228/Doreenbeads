<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 4942 2006-11-17 06:21:37Z ajeh $
 */
?>
<script language="javascript" type="text/javascript"><!--

function couponpopupWindow(url) {
  window.open(url,'couponpopupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function show_description(divid, text, startX){
	/*startX = document.getElementById("mouseposX").value;
	startY = document.getElementById("mouseposY").value;*/
	document.getElementById(divid).style.display = "block";
	document.getElementById(divid).innerHTML = text;
	document.getElementById(divid).className = "show_description";
	document.getElementById(divid).style.left = startX + "px";
	//document.getElementById("show_description").style.top = "-100px";
}

function close_description(divid){
	document.getElementById(divid).innerHTML = "";
	document.getElementById(divid).className = "close_description";
}

function select(){
	var select = document.getElementsByName('select')[0].checked;
	var selectson = document.getElementsByName('selectson[]');
	for (var i = 0; i < selectson.length; i++){
		selectson[i].checked = select;
	}
}

function checkselect(){
	var selectson = document.getElementsByName('selectson[]');
	for (var i = 0; i < selectson.length; i++){
		if(selectson[i].checked == true){
			return true;
		}			
	}
	return false;
}

function del_file(UploadingTipId){
		$j("#" + UploadingTipId).html('');
		$j("#payment_file_" + UploadingTipId).show();
		file_name = $j("#payment_" + UploadingTipId).val();
		$j.post('./image_upload.php',{action:""+"delete_tmp"+"",fname:""+file_name+""},function(data){
			if(data == ''){
				
			}
		});
		
}

function check_form() {
	var payment =  $j('input[name="payment"]:checked').val();	
	if(payment == 'wire'){
		var hsbs_buttoncss = false;
		var hsbs_amout 			= $j('input[name="hsbs_amout"]').val();
		var hsbs_date			= $j('input[name="hsbs_date"]').val();
		var hsbs_yname 			= $j('input[name="hsbs_yname"]').val();
		var hsbs_currency		= $j('input[name="hsbs_Currency"]').val();
		var hsbs_currency_input = $j('input[name="hsbs_Currency_input"]').val();	
		if($j.trim(hsbs_yname).length < 2){
			hsbs_buttoncss = true;
			$j('input[name="hsbs_yname"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_YNAME_ERROR;?>');
		}
		if($j.trim(hsbs_amout) == ''){
			hsbs_buttoncss = true;
			$j('input[name="hsbs_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT;?>');
		}else if(isNaN($j.trim(hsbs_amout))){
			hsbs_buttoncss = true;
			$j('input[name="hsbs_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT_TYPE;?>');
		}
		if($j.trim(hsbs_date) == ''){
			hsbs_buttoncss = true;
			$j('input[name="hsbs_date"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_PAYMNET_DATE;?>');
		}
		if($j.trim(hsbs_currency) == '<?php echo TEXT_OTHERS?>' && $j.trim(hsbs_currency_input) == ''){
			hsbs_buttoncss = true;
			$j('input[name="hsbs_Currency_input"]').siblings('span.error_payment').html('<?php echo TEXT_FILL_IN_CURRENCY_YOU_USED;?>');
		}	
		if(hsbs_buttoncss){
			 return false;
		}		
	}else if(payment == 'wirebc'){
		var wirebc_buttoncss = false;
		var china_amout 		 = $j('input[name="china_amout"]').val();
		var china_date			 = $j('input[name="china_date"]').val();
		var china_yname 		 = $j('input[name="china_yname"]').val();
		var china_currency       = $j('input[name="china_Currency"]').val();
		var china_currency_input = $j('input[name="china_Currency_input"]').val();
		if($j.trim(china_yname).length < 2){
			wirebc_buttoncss = true;
			$j('input[name="china_yname"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_YNAME_ERROR;?>');
		}
		if($j.trim(china_amout) == ''){
			wirebc_buttoncss = true;
			$j('input[name="china_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT;?>');
		}else if(isNaN($j.trim(china_amout))){
			wirebc_buttoncss = true;
			$j('input[name="china_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT_TYPE;?>');
		}
		if($j.trim(china_date) == ''){
			wirebc_buttoncss = true;
			$j('input[name="china_date"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_PAYMNET_DATE;?>');
		}
		if($j.trim(china_currency) == '<?php echo TEXT_OTHERS?>' && $j.trim(china_currency_input) == ''){
			wirebc_buttoncss = true;
			$j('input[name="china_Currency_input"]').siblings('span.error_payment').html('<?php echo TEXT_FILL_IN_CURRENCY_YOU_USED;?>');
		}
		if(wirebc_buttoncss){
			 return false;
		}
	}else if(payment == 'westernunion'){
		var westernunion_buttoncss = false;
		var western_amout =  $j('input[name="western_amout"]').val();
		var western_control_no =  $j('input[name="western_control_no"]').val();
		var western_yname = $j('input[name="western_yname"]').val();
		var western_currency = $j('input[name="western_Currency"]').val();
		var western_currency_input = $j('input[name="western_Currency_input"]').val();
		
		if($j.trim(western_yname).length < 2){
			westernunion_buttoncss = true;
			$j('input[name="western_yname"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_YNAME_ERROR;?>');
		}
		if($j.trim(western_amout) == ''){
			westernunion_buttoncss = true;
			$j('input[name="western_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT;?>');
		}else if(isNaN($j.trim(western_amout))){
			westernunion_buttoncss = true;
			$j('input[name="western_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT_TYPE;?>');
		}
		if($j.trim(western_control_no) == ''){
			westernunion_buttoncss = true;
			$j('input[name="western_control_no"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_CONTROL_NO;?>');
		}else if(isNaN($j.trim(western_control_no))){
			westernunion_buttoncss = true;
			$j('input[name="western_control_no"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_CONTROL_NO_TYPE;?>');
		}else if($j.trim(western_control_no).length != 10){
			westernunion_buttoncss = true;
			$j('input[name="western_control_no"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_CONTROL_NO_10;?>');
		}
		if($j.trim(western_currency) == '<?php echo TEXT_OTHERS?>' && $j.trim(western_currency_input) == ''){
			westernunion_buttoncss = true;
			$j('input[name="western_Currency_input"]').siblings('span.error_payment').html('<?php echo TEXT_FILL_IN_CURRENCY_YOU_USED;?>');
		}																							
		if(westernunion_buttoncss){
			 return false;
		}
	}else if(payment == 'moneygram'){
		var moneygram_buttoncss = false;
		var moneygram_full_name = $j('input[name="moneygram_full_name"]').val();
		var moneygram_amout = $j('input[name="moneygram_amout"]').val();
		var moneygram_control_no = $j('input[name="moneygram_control_no"]').val();
		var moneygram_currency = $j('input[name="moneygram_Currency"]').val();
		var moneygram_currency_input = $j('input[name="moneygram_Currency_input"]').val();
		if($j.trim(moneygram_full_name) == ''){        
			moneygram_buttoncss = true;			
		}
		if($j.trim(moneygram_amout) == ''){
			moneygram_buttoncss = true;
			$j('input[name="moneygram_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT;?>');
		}else if(isNaN($j.trim(moneygram_amout))){
			moneygram_buttoncss = true;
			$j('input[name="moneygram_amout"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_AMOUNT_TYPE;?>');
		}
		if($j.trim(moneygram_control_no) == ''){
			moneygram_buttoncss = true;
			$j('input[name="moneygram_control_no"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_CONTROL_NO;?>');
		}else if(isNaN($j.trim(moneygram_control_no))){
			moneygram_buttoncss = true;
			$j('input[name="moneygram_control_no"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_CONTROL_NO_TYPE;?>');
		}else if($j.trim(moneygram_control_no).length != 8){
			moneygram_buttoncss = true;
			$j('input[name="moneygram_control_no"]').siblings('span.error_payment').html('<?php echo TEXT_ACCONT_ENTER_CONTROL_NO_8;?>');
		}
		if($j.trim(moneygram_currency) == '<?php echo TEXT_OTHERS?>' && $j.trim(moneygram_currency_input) == ''){
			moneygram_buttoncss = true;
			$j('input[name="moneygram_Currency_input"]').siblings('span.error_payment').html('<?php echo TEXT_FILL_IN_CURRENCY_YOU_USED;?>');
		}
		if(moneygram_buttoncss){
			 return false;
		}
	} else if(payment == 'paypalwpp') {
		openPaypalWindow();
		return false;
	}
}
$j(function(){
	$j('.fill_info input').focus(function(){
		$j(this).siblings('.error_payment').html('');
	})
})

$j(function(){
	$j('.shopcart_content .more a').live('click',function(){
		if($j(this).hasClass('close1')){
			$j(this).addClass('open').removeClass('close1');
			$j('.shopcart_content tr.hideTheTr').show();
		}else{
			$j(this).addClass('close1').removeClass('open');
			$j('.shopcart_content tr.hideTheTr').hide();
		}
	})
})

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
			$j('.windowbody').css('height', bodyHeight).fadeTo(1000, 0.5);
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

	/*$j(".jq_cart_spreadsheet .paynow_btn").live("click", function() {
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
		
	});*/

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
					//console.log(data);//return false;
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
    var host = $j("#http_server").val();
    $j("#paymentInfo").hide();
        var orderId = $j("#orderId").val();
        var paymentOrderId = $j("#paymentOrderId").val();
        var lastName = $j("#lastName").val();
        var firstName = $j("#firstName").val();
        var shippingFirstName = $j("#shippingFirstName").val();
        var shippingLastName = $j("#shippingLastName").val();
        var shippingStreet = $j("#shippingStreet").val();
        var shippinCountryCode = $j("#shippinCountryCode").val();
        var shippinZip = $j("#shippinZip").val();
        var merchantRef = $j("#merchantRef").val();
        var countryCode = $j("#countryCode").val();
        var lanuageCode = $j("#lanuageCode").val();
        var currencyCode = $j("#currencyCode").val();
        var price = $j("#price").val();
        var shippingCity = $j("#shippingCity").val();
        var shippingState = $j("#shippingState").val();
        var phoneNumber = $j("#phoneNumber").val();
        var email = $j("#email").val();
        var city = $j("#city").val();
        var state = $j("#state").val();
        var street = $j("#street").val();
        var type = $j("#type").val();
        $j("#loading").show();
        $j("#payIframe").hide();
        
        $j("#gcCreditCard").change(function(){
        $j("#loading").show();
        $j("#payIframe").hide();
        $j.ajax({
            type:"POST",
            url:"/payment1.php",
            data:"payCode=1&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
                    +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
                                    merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+shippingCity
                                    +"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
            success:function(msg){
                var response = eval('('+msg+')');
                if(response.status == 1){
                    $j("#gcFormActionUrl").ready(function(){
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#gcFormActionUrl").attr("src",response.response);
                    }
                );
                } else if(response.status == 0 && response.response == '410120'){
                    $j("#loading").hide();
                    $j("#payIframe").show();
                        $j("#errorMessage").html(response.message);

                }
            }
        });
});
        $j(".gcPayment").change(function(){
            $j("#loading").show();
            $j("#payIframe").hide();
            var payCode = $j(this).val();
            $j.ajax({
                type:'POST',
                url:"/payment1.php",
                data:"payCode="+payCode+"&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
                        +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
                        merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+
                        shippingCity+"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
                success:function(msg){
                    var response = eval('('+msg+')');
                    if(response.status == 1) {
                        $j("#gcFormActionUrl").ready(function(){
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#gcFormActionUrl").attr("src",response.response);
//                    alert(eval('(' + msg + ')'));
//                    alert(JSON.parse(msg));
                        });
                    } else if(response.status == 0 && response.response == '410120') {
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#errorMessage").html(response.message);
                    }
                }
            });
        });
		$j("#webMoney_button").click(function(){
	        $j("#loadingWM").show();
	        //$j("#payIframeWM").hide();
	        $j.ajax({
	            type:"POST",
	            url:"<?php echo HTTP_SERVER;?>/paymentWM.php",
	            data:"payCode=841&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
	                    +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
	                                    merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+shippingCity
	                                    +"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
	            success:function(msg){
	                var response = eval('('+msg+')');
	                if(response.status == 1){
		                window.location.href = response.response;
		                return false;
	                    $j("#gcFormActionUrlWM").ready(function(){
	                    $j("#loadingWM").hide();
	                    $j("#payIframeWM").show();
	                    $j("#gcFormActionUrlWM").attr("src",response.response);
	                });
	                } else if(response.status == 0){
		                if (response.response == '410120'){
		                    $j("#loadingWM").hide();
		                    $j("#payIframeWM").show();
	                        $j("#errorMessage").html(response.message);
		                }else{
		                    $j("#loadingWM").hide();
		                    $j("#payIframeWM").show();
	                        $j("#errorMessage").html(response.messageOriginal);
		                }
	                }
	            }
	        });
    	});
        $j("#use_coupon").click(function(){
            $j("#loading").show();
            $j("#payIframe").hide();
    		if($j(".gcPayment").checked = "checked"){
    			var payCode = $j(".gcPayment").val();
    		}
            $j.ajax({
                type:'POST',
                url:'/payment1.php',
                data:"payCode="+payCode+"&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
                        +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
                        merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+
                        shippingCity+"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
                success:function(msg){
                    var response = eval('('+msg+')');
                    if(response.status == 1) {
                        $j("#gcFormActionUrl").ready(function(){
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#gcFormActionUrl").attr("src",response.response);
//                    alert(eval('(' + msg + ')'));
//                    alert(JSON.parse(msg));
                    });
                    } else if(response.status == 0 && response.response == '410120') {
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#errorMessage").html(response.message);
                    }
                }
            });
        });
		$j(".redclose").click(function(){
			   $j(this).next(".successtips2").hide(); 
			   })
			   
		$j(".icon_question").mouseover(function(){
			$j(this).next(".successtips2").show();
			})
	    $j(".icon_question").mouseout (function(){
			$j(this).next(".successtips2").hide();
			})

	    $j(".remark_order").mouseover(function(){
			products_id = $j(this).attr('aid');
			$j("#show_note_"+products_id).show();
		})
	    $j(".remark_order").mouseout(function(){
			products_id = $j(this).attr('aid');
			$j("#show_note_"+products_id).hide();
		})
})

$j(function(){
	$j('.quick_reorder').click(function(){
		var order_id = $j(this).attr('oid');
		$j.post('./ajax_quick_reorder.php', {order_id: order_id}, function(data){
			if(data != ''){
				alert(data);
			}
			window.location.href = 'index.php?main_page=shopping_cart';
		})
	})

	$j('.propagelist a').live('click', function(){
		page = $j(this).attr('pageid');
		order_id = $j('.order_details_oid').html();
		$j.post('./ajax_order_products_review_split.php', {page: page, order_id: order_id, action: 'web'}, function(data){
			$j('.table_order_products_review').html(data);
		})
	})


	$j('.order_detail_addcart').live('click', function(){
		var pid = $j(this).siblings('input[name="product_id"]').val();
		var qty = $j(this).siblings('input[name="product_qty"]').val();
		tipObj = $j(this).siblings('div.successtips_collect1');

		$j.post("./order_addcart.php", {productid: pid, number: qty, action: 'order_detail_add'}, function(data){
			if(data.length >0) {
				if(data == 'incart'){
					alert('<?php echo TEXT_ALREADY_INCART; ?>');
				}else if(data == 'soldout'){
					alert("<?php echo TEXT_CANT_ADDCART; ?>");
				}else{
					var dataarr = new Array();
					dataarr = data.split("|");
					if(dataarr[2] != ''){
						alert(dataarr[2]);
					}else{
						tipObj.show();
						setTimeout(function(){
							tipObj.hide();
						}, 5000);
					}
					$j("#count_cart").html(dataarr[0]);	
					//$j("#header_cart_total").html(dataarr[3]);
				}				
			}
		});
	})

	$j('.successtips_collect_close').live('click', function(){
		$j('.successtips_collect').hide();
	})

	$j('.arrow_right7').click(function(e){
		$j('.selectlist7').toggle();
		e.stopPropagation();
		$j('body').click(function(){
			$j('.selectlist7').hide();
		})
	})
		   
	$j('.selectlist7 li').click(function(){
		$j('.text_left7').text(($j(this).text())); 
		$j('input[name="hsbs_Currency"]').val(($j(this).text()));
		$j('input[name="china_Currency"]').val(($j(this).text())); 
		$j('input[name="western_Currency"]').val(($j(this).text()));
		$j('input[name="moneygram_Currency"]').val(($j(this).text()));
		if($j(this).text()=="<?php echo TEXT_OTHERS?>"){
			$j('input[name="hsbs_Currency_input"]').parent().show();
			$j('input[name="china_Currency_input"]').parent().show();
			$j('input[name="western_Currency_input"]').parent().show();
			$j('input[name="moneygram_Currency_input"]').parent().show();
		}else{
			$j('input[name="hsbs_Currency_input"]').parent().hide();	
			$j('input[name="hsbs_Currency_input"]').val('');
			$j('input[name="china_Currency_input"]').parent().hide();
			$j('input[name="china_Currency_input"]').val('');
			$j('input[name="western_Currency_input"]').parent().hide();	
			$j('input[name="western_Currency_input"]').val('');
			$j('input[name="moneygram_Currency_input"]').parent().hide();
			$j('input[name="moneygram_Currency_input"]').val();
		}
	});

	$j('.payment_cont .left li').click(function(){
		if($j(this).hasClass('chose')) return;
		if($j(this).attr('type')=='wirebc')  $j('.text_left7').text('US $');  //还原selectlist7
		$j('.payment_cont .left li.chose').removeClass('chose');
		$j(this).addClass('chose');
		$j('.right_cont_chinabank.sh').removeClass('sh');
		$j('.right_cont_chinabank.right_cont_'+$j(this).attr('type')).addClass('sh');
		$j('.paynotes.sh').removeClass('sh');
		$j('.paynotes.paynotes_'+$j(this).attr('type')).addClass("sh");
	})

	$j('.orderprocess ul li .qustion_icontips').hover(function(){
		$j(this).next('div').find('div.orderprocess_tips').show();
	}, function(){
		$j(this).next('div').find('div.orderprocess_tips').hide();
	});

	$j(document).on('click', '.jq_showBigImg', function(){
		if ($j(this).attr('height') == '80px') {
			$j(this).attr({'height': '', width: ''});
		}else{
			$j(this).attr({'height': '80px', width: '80px'});
		}
	})
});

//--></script>