<script language="javascript" type="text/javascript">
function receive_coupon(){
	$j('.Close').click(function(){
		$j('.Anniversary-2018_error').hide();
	});
	
	$.ajax({
		type : 'post',
		url : 'index.php?main_page=new_customers_receive_coupon',
		data : {action : 'receive_coupon'},
		async : false,
		success : function(result){
			var returnInfo = process_json(result);
			var lang = $('input[name=c_lan]').val();

			if(returnInfo.error == true){
    			switch(returnInfo.error_type){
    				case 1:
						window.location.href = returnInfo.redirect_url;
            			break;
    				case 2:
						$j('.Anniversary-2018_error p').html(returnInfo.error_info);
						$j('.Anniversary-2018_error').show();
            			break;
    				case 3:
    					$j('.receive_button').attr('src', '/includes/templates/cherry_zen/css/' + lang + '/images/new_customers_receive_coupon_button_grey.gif');
    					$j('.receive_button').removeAttr('usemap');
        				break;
    			}
			}else{
				$j('.receive_button').attr('src', '/includes/templates/cherry_zen/css/' + lang + '/images/new_customers_receive_coupon_button_grey.gif');
				$j('.Anniversary-2018_error p').html(returnInfo.error_info);
				$j('.Anniversary-2018_error').show();
				$j('.receive_button').removeAttr('usemap');
			}
		}
	});

	return false;
}

$(document).ready(function(){
	$j('.Close').click(function(){
		$j('.Anniversary-2018_error').hide();
	});
});
</script>