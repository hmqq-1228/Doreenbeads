$(function() {
   if($('#pay').val() != ''){
   	 $('#paypal').attr('checked','checked');
   }else{
   	 $('#banlance').attr('checked','checked');
     $('#pay').attr('disabled','disabled');
   }
   $('#contact_way').on("blur",function(){
		   var contact_way = $('#contact_way').val();
		   if( contact_way == ''){
              $('#error_info1').html(js_lang.TEXT_AFFILIATE_ERROR1);
		   }else{
		   	  $('#error_info1').html('');
		   }
		});
		$('#pay').on("blur",function(){
		   var pay = $('#pay').val();
		   if( pay == ''){
              $('#error_info2').html(js_lang.TEXT_AFFILIATE_ERROR2);
		   }else{
		   	  $('#error_info2').html('');
		   }
		});
});

function checkboxOnclick(checkbox){
			if(checkbox.value == 10){
				$('#pay').val('');
				$('#pay').attr('disabled','disabled');
				$('#error_info2').html('');
			}else{
				$('#pay').removeAttr('disabled');

			}
}
function check_submit_form(){
	    
	    error_data=false;
	    if($('#contact_way').val() == ''){
	    	$('#error_info1').html(js_lang.TEXT_AFFILIATE_ERROR1);
	    	error_data =true;
	    }else{
	    	$('#error_info1').html('');
	    	error_data=false;
	    }
	    
	    if($('.radio:checked').val() == 10 ){
               
	    }else if($('.radio:checked').val() == 20 ){
               if($('#pay').val() == ''){
               	 $('#error_info2').html(js_lang.TEXT_AFFILIATE_ERROR2);
               	  error_data=true;
               }
	    }

        if(error_data == false){
        	return true;
        }
        return false;
        
}
