<script language="javascript" type="text/javascript">

$j(document).ready(function(){
		$j('#contact_way').on("blur",function(){
		   var contact_way = $j('#contact_way').val();
		   if( contact_way == ''){
              $j('#error_info1').html('<?php echo TEXT_AFFILIATE_ERROR1;?>');
		   }else{
		   	  $j('#error_info1').html('');
		   }
		});
		$j('#pay').on("blur",function(){
		   var pay = $j('#pay').val();
		   if( pay == ''){
              $j('#error_info2').html('<?php echo TEXT_AFFILIATE_ERROR2;?>');
		   }else{
		   	  $j('#error_info2').html('');
		   }
		});
		

});

function checkboxOnclick(checkbox){
			if(checkbox.value == 10){
				$j('#pay').val('');
				$j('#pay').attr('disabled','disabled');
				$j('#error_info2').html('');
			}else{
				$j('#pay').removeAttr('disabled');

			}
}
function check_submit_form(){
	    
	    error_data=false;
	    if($j('#contact_way').val() == ''){
	    	$j('#error_info1').html('<?php echo TEXT_AFFILIATE_ERROR1;?>');
	    	error_data =true;
	    }else{
	    	$j('#error_info1').html('');
	    	error_data=false;
	    }
	    if($j('.radio:checked').val() == 10 ){
               
	    }else if($j('.radio:checked').val() == 20 ){
               if($j('#pay').val() == ''){
               	 $j('#error_info2').html('<?php echo TEXT_AFFILIATE_ERROR2;?>');
               	  error_data=true;
               }
	    }

        if(error_data == false){
        	return true;
        }
        return false;
        
}

</script>