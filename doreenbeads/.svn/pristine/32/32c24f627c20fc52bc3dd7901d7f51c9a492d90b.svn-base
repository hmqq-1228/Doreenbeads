
$(function() {
		$('#email_address').on("blur",function(){
		   var email_address = $('#email_address').val();
		   if( email_address == ''){
              $('#error_info1').html(js_lang.TEXT_AFFILIATE_ERROR1);
		   }else{
		   	  $('#error_info1').html('');
		   }
		});

		$('#paypal').on("blur",function(){
		   var paypal = $('#paypal').val();
		   if( paypal == ''){
              $('#error_info2').html(js_lang.TEXT_AFFILIATE_ERROR2);
		   }else{
		   	  $('#error_info2').html('');
		   }
		});

});
function checkboxOnclick(checkbox){
			if (checkbox.checked == true){
			      $('#paypal').val('');
                  $('#paypal').attr('disabled','disabled');
                  $('#error_info2').html('');	
			}else{
			      $('#paypal').removeAttr('disabled');
			}
}
function check_submit_form(form_name){
	
	    form = form_name;
	    error_data=false;
	    if($('#email_address').val() == ''){
	    	$('#error_info1').html(js_lang.TEXT_AFFILIATE_ERROR1);
	    	error_data =true;
	    }else{
	    	$('#error_info1').html('');
	    	error_data=false;
	    }
        if(checkbox.checked){
        	
        }else{
        	
        	if($('#paypal').val() == ''){
        		$('#error_info2').html(js_lang.TEXT_AFFILIATE_ERROR2);
        		error_data = true;
        	}else{
        		$('#error_info2').html('');
        	}
        }

        if(error_data == false){
        	return true;
        }
        return false;
        
}
