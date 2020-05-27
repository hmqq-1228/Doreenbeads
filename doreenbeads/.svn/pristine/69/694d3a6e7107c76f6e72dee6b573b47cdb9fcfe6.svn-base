<script language="javascript" type="text/javascript">
function receive_coupon(){
	$j('.Close').click(function(){
		$j('.Anniversary-2018_error').hide();
	});
	
	$.ajax({
		type : 'post',
		url : 'index.php?main_page=all_customers_receive_coupon',
		data : {action : 'receive_coupon'},
		async : false,
		success : function(result){
			var returnInfo = process_json(result);
			console.log(returnInfo);
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
    			}
			}else{
				$j('.receive_button').attr('src', '/includes/templates/cherry_zen/css/' + lang + '/images/all_customers_receive_coupon4.gif');
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