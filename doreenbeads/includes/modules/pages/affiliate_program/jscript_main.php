<script language="javascript" type="text/javascript">

$j(document).ready(function(){
		$j('#email_address').on("blur",function(){
		   var email_address = $j('#email_address').val();
		   if( email_address == ''){
              $j('#error_info1').html('<?php echo TEXT_AFFILIATE_ERROR1;?>');
		   }else{
		   	  $j('#error_info1').html('');
		   }
		});

		$j('#paypal').on("blur",function(){
		   var paypal = $j('#paypal').val();
		   if( paypal == ''){
              $j('#error_info2').html('<?php echo TEXT_AFFILIATE_ERROR2;?>');
		   }else{
		   	  $j('#error_info2').html('');
		   }
		});

});
function checkboxOnclick(checkbox){
		 
			if (checkbox.checked == true){
			      $j('#paypal').val('');
                  $j('#paypal').attr('disabled','disabled');
                  $j('#error_info2').html('');
			}else{
			      
			      $j('#paypal').removeAttr('disabled');
			}
}
function check_submit_form(form_name){
	    form = form_name;
	    error_data=false;
	    if($j('#email_address').val() == ''){
	    	$j('#error_info1').html('<?php echo TEXT_AFFILIATE_ERROR1;?>');
	    	error_data =true;
	    }else{
	    	$j('#error_info1').html('');
	    	error_data=false;
	    }
        if(checkbox.checked){
        	
        }else{
        	
        	if($j('#paypal').val() == ''){
        		$j('#error_info2').html('<?php echo TEXT_AFFILIATE_ERROR2;?>');
        		error_data = true;
        	}else{
        		$j('#error_info2').html('');
        	}
        }

        if(error_data == false){
        	return true;
        }
        return false;
        
}
</script>