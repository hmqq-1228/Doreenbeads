<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: jscript_main.php 1105 2005-04-04 22:05:35Z birdbrain $
//
?>
<script language="javascript" type="text/javascript">

$j(document).ready(function(){
	$j('.require').focus(function(){
		 $j(this).parent('td').next('td').children('span').html('');
	});
	$j('#add_new_address #state').focus(function(){
		 $j(this).parent('td').next('td').children('span').html('');
	});
	$j('#edit_address_book #state').focus(function(){
		 $j(this).parent('td').next('td').children('span').html('');
	});
	$j('#add_new_address #stateZone').focus(function(){
		 $j(this).parent('td').next('td').children('span').html('');
	});
	$j('#edit_address_book #stateZone').focus(function(){
		 $j(this).parent('td').next('td').children('span').html('');
	});
	$j('.suburb').focus(function(){
		 $j(this).parent('td').next('td').children('span').html('');
	});
	$j('.outsidetips ins').mouseover(function(){
		$j('.outsidetips .tips').show();
	}).mouseout(function(){
		$j('.outsidetips .tips').hide();
    });
	if('<?php echo $_GET["update"]?>'!=null && "<?php echo $_GET["update"]?>" == "true"){
		$j('.updateshow').show();
		setTimeout(function(){
		  $j('.updateshow').hide()},4000);	
	}
});
$j(".country_choose b").click(function(){
	$j(".country_select_drop").show();
	
})
var updateshowing = function(){
	
   $j('.updateshow').show();
  // alert($j('.updateshow').text()); 
     setTimeout(function(){
		  $j('.updateshow').hide()},4000);
}


function edit_address_book(addressBookId,divName){
	var inputtext = $j("input[type=text]");
	for (var i = 0; i < inputtext.length; i++){
		$j(inputtext[i]).parent('td').next('td').children('span').html('');
	}
	
	var addressBookList = '<?php echo addslashes($selectedAddress);?>';
	var jobj = eval('('+addressBookList+')'); 
	if (divName == "#defalut_addressbook") {
		$j('#add_new_address #state').parent('td').next('td').children('span').html('');
		$j('#edit_address_book #state').parent('td').next('td').children('span').html('');
		$j(".addbutton").hide();
		$j(".requiredfiled:eq(0)").show();
		$j("#add_new_address #checkprimary").hide();
		var addressBookId = addressBookId;		
 		var param = {"addressBookId":addressBookId};    
	 		$j("#add_new_address #tariff_number").val(jobj[addressBookId].tariff_number);
			$j("#add_new_address #backup_email_address").val(jobj[addressBookId].email_address);             	 	
 			$j("#add_new_address #company").val(jobj[addressBookId].company);
 			$j("#add_new_address #street_address").val(jobj[addressBookId].streetAddress);
 			$j("#add_new_address #suburb").val(jobj[addressBookId].suburb);
 			$j("#add_new_address #city").val(jobj[addressBookId].city);
 			$j("#add_new_address #states").val(jobj[addressBookId].state);
 			$j("#add_new_address #postcode").val(jobj[addressBookId].postcode);
 			$j("#add_new_address #telephone").val(jobj[addressBookId].telephone);
 			$j("#add_new_address #firstname").val(jobj[addressBookId].firstname);
 			$j("#add_new_address #lastname").val(jobj[addressBookId].lastname);
 			radio_arr=document.getElementsByName('gender');
 			for(var i=0;i<2;i++){
 				if(radio_arr[i].value == jobj[addressBookId].gender) radio_arr[i].selected = true;
 				break;
 			} 
 	 		$j("#add_new_address .addresssubmit").attr("onclick","save_address_book('#add_new_address'," + addressBookId + ")"); 
 	 		$j("#defalut_addressbook .btn_yellow").attr("disabled","disabled");
 	 		$j('#add_new_address #zone_country_id').val(jobj[addressBookId].country);
			$j("#add_new_address .country_select_drop ul li").each(function(){
				if($j(this).attr('clistid')==jobj[addressBookId].country){
					$j('#country_choose .choose_single span').text($j(this).text());
					$j(".country_select_drop ul .country_list_item").removeClass('country_list_item_selected');
					$j('#cSelectId').val($j(".country_select_drop ul li").index($j(this))+1);
					$j('#add_new_address #select_coutry_zip_code_info').attr('zip_code_rule', $j(this).attr('zip_code_rule'));
					$j('#add_new_address #select_coutry_zip_code_info').attr('zip_code_example', $j(this).attr('zip_code_example'));
					return false;
				}
			})
			var formEle=document.getElementsByName('address_book');
			update_zone_c(formEle[0]);
			if (jobj[addressBookId].zone> 0){
				$j("#add_new_address #stateZone option[value="+jobj[addressBookId].zone+"]").attr("selected","selected");
			}			
			if(jobj[addressBookId].state !=' '){
				$j('#add_new_address #state').val(jobj[addressBookId].state);
			}
		$j("#edit_address_book").hide();
		$j(".requiredfiled:eq(1)").hide();
		$j("#addressbooklist").show();
		$j("#add_new_address").show();
		$j(divName).hide();	
		//$j("#addressbooklist .defaultedit").attr("disabled","disabled");
	}else if(divName == ".addbutton"){
		//$j("#add_new_address #checkprimary").show();
		$j('#edit_address_book #state').parent('td').next('td').children('span').html('');
		$j('#add_new_address #state').parent('td').next('td').children('span').html('');		
		var inputtext = $j("#edit_address_book input[type=text]");
		for (var i = 0; i < inputtext.length; i++){
			$j(inputtext[i]).attr("value","");
		}
 		$j("#edit_address_book .addresssubmit").attr("onclick","save_address_book('#edit_address_book'," + 0 + ")"); 
 		$j(".requiredfiled:eq(1)").show();
		$j("#addressbooklist").hide();
		$j(".addbutton").hide();
		$j("#defalut_addressbook .defaultedit").attr("disabled","disabled");
		radio_arr=document.getElementsByName('gender');
		/* for(var i=2;i<4;i++){
			if(radio_arr[i].value == 'm') radio_arr[i].checked = true;
			break;
		} */ 
		$j('#edit_address_book .checkprimary').show();	
		$j("#edit_address_book").show();
	}else if (divName == "#addressbooklist") {	
		$j('#edit_address_book #state').parent('td').next('td').children('span').html('');
		$j('#edit_address_book #state').parent('td').next('td').children('span').html('');	
		$j(".addbutton").hide();
		$j(".neccesary").show();
		var addressBookId = addressBookId;	
 		var param = {"addressBookId":addressBookId};                 		 	
	 		radio_arr=document.getElementsByName('gender');
			/* for(var i=2;i<4;i++){			
				if(radio_arr[i].value == jobj[addressBookId].gender) {radio_arr[i].checked = true;break;}
			}  */
			$j("#edit_address_book #tariff_number").val(jobj[addressBookId].tariff_number);
			$j("#edit_address_book #backup_email_address").val(jobj[addressBookId].email_address);
 	 		$j("#edit_address_book #company").val(jobj[addressBookId].company);
 	 		$j("#edit_address_book #street_address").val(jobj[addressBookId].streetAddress);
 	 		$j("#edit_address_book #suburb").val(jobj[addressBookId].suburb);
 	 		$j("#edit_address_book #city").val(jobj[addressBookId].city);
 	 		$j("#edit_address_book #states").val(jobj[addressBookId].state);
 	 		$j("#edit_address_book #postcode").val(jobj[addressBookId].postcode);
 	 		$j("#edit_address_book #telephone").val(jobj[addressBookId].telephone);
 	 		$j("#edit_address_book #firstname").val(jobj[addressBookId].firstname);
 	 		$j("#edit_address_book #lastname").val(jobj[addressBookId].lastname);
 	 		$j("#edit_address_book #stateZone").val(jobj[addressBookId].lastname);
 	 		$j('#edit_address_book #zone_country_id').val(jobj[addressBookId].country);
			$j(".country_select_drop ul li").each(function(){
				if($j(this).attr('clistid')==jobj[addressBookId].country){
					$j('#country_choose .choose_single span').text($j(this).text());
					$j(".country_select_drop ul .country_list_item").removeClass('country_list_item_selected');
					$j('#cSelectId').val($j(".country_select_drop ul li").index($j(this))+1);
					$j('#edit_address_book #select_coutry_zip_code_info').attr('zip_code_rule', $j(this).attr('zip_code_rule'));
					$j('#edit_address_book #select_coutry_zip_code_info').attr('zip_code_example', $j(this).attr('zip_code_example'));
					return false;
				}
			})
			var formEle=document.getElementsByName('address_book');
			update_zone_c(formEle[1]);
			if (jobj[addressBookId].zone> 0){
				$j("#edit_address_book #stateZone option[value="+jobj[addressBookId].zone+"]").attr("selected","selected");
			}	
			if(jobj[addressBookId].state !=' '){
				$j('#edit_address_book #state').val(jobj[addressBookId].state);
			}
 	 		$j("#edit_address_book .addresssubmit").attr("onclick","save_address_book('#edit_address_book'," + addressBookId + ")"); 
 	 		$j("#defalut_addressbook .btn_yellow").attr("disabled","disabled");	 	
 	 	 	if(addressBookId == '<?php echo $_SESSION['customer_default_address_id'];?>'){$j('.checkprimary').css("display","none");}else{$j('.checkprimary').show();}
 	 	//$j("#defalut_addressbook .defaultedit").attr("disabled","disabled");
 	 	$j(".requiredfiled:eq(0)").hide();
		$j("#defalut_addressbook").show();
		$j("#add_new_address").hide();	
 	 	$j("#edit_address_book").show();	
		$j(divName).hide();		
	}
}

function cancel_edit(divName,countAddress){
	if (divName == "#defalut_addressbook") {
		$j("#add_new_address").hide();
		$j(".requiredfiled:eq(0)").hide();
		if(countAddress < 10){
			$j('.addbutton').show();
		}
		$j(divName).show();
		$j("#defalut_addressbook .defaultedit").removeAttr("disabled");
		$j("#addressbooklist .defaultedit").removeAttr("disabled");	
	}else if (divName == "#addressbooklist") {
		$j("#edit_address_book").hide();
		$j(".requiredfiled:eq(1)").hide();
		if(countAddress < 10){
			$j('.addbutton').show();
		}
		$j(divName).show();	
		$j("#defalut_addressbook .defaultedit").removeAttr("disabled");
		$j("#addressbooklist .defaultedit").removeAttr("disabled");	
	}
}


var check = function(divName) {
    var checked = true;
	var rega=/^.{1,}$/;
    var regb=/^.{3,}$/;
	var regc=/^.{5,}$/;
	var telval=$j.trim($j(divName + ' .telnum').val());
	var fnameval=$j.trim($j(divName + ' .firstname').val());
	var lnameval=$j.trim($j(divName + ' .lastname').val());
	var cityval=$j.trim($j(divName + ' .city').val());
	var tel=$j.trim($j(divName + ' .tel').val());
	var postalval=$j.trim($j(divName + ' .postal').val());
	var streetval=$j.trim($j(divName + ' .street').val());
    var provinceval=$j.trim($j(divName + ' .province').val());
    var state1 = $j.trim($j(divName + ' #stateZone').val());
    var state2 = $j.trim($j(divName + ' #state').val());
    var suburb = $j.trim($j(divName + ' #suburb').val());
	var zip_code_rule = $j.trim($j(divName + ' #select_coutry_zip_code_info').attr('zip_code_rule'));
	var zip_code_rule_reg = new RegExp(zip_code_rule, 'i');
	var zip_code_example = $j.trim($j(divName + ' #select_coutry_zip_code_info').attr('zip_code_example'));

	$j(divName + ' #firstname').text('');
	$j(divName + ' #lastname').text('');
	$j(divName + ' #states').text('');
	$j(divName + ' #scity').text('');
	$j(divName + ' #telnumber').text('');
	$j(divName + ' #postCode').text('');
	$j(divName + ' #street').text('');
	
    if(state1=='') state1=0;
    //alert("telphone:"+telval + "firstname:"+fnameval + "lastname:"+lnameval +"city:"+ cityval + "tel:"+tel + "postal:"+postalval + "street:"+streetval + "province:"+provinceval)
	if(!rega.test(fnameval)){
		$j(divName + ' #firstname').text("<?php echo sprintf(TEXT_PLEASEENTER_CHARLEAST, ENTRY_FIRST_NAME_MIN_LENGTH); ?>");
	  	checked = false;
	}
	if(fnameval == lnameval){
		$j(divName + ' #lastname').text("<?php echo ENTRY_FL_NAME_SAME_ERROR; ?>");
		checked = false;
	}

	if(!rega.test(lnameval)){
		$j(divName + ' #lastname').text("<?php echo sprintf(TEXT_PLEASEENTER_CHARLEAST, ENTRY_LAST_NAME_MIN_LENGTH); ?>");
	  	checked = false;
	}
	if(state1 ==0 && !rega.test(state2)){
		$j(divName + ' #states').text('<?php echo TEXT_PLEASEENTER_RIGHTSTATE; ?>');
	  	checked = false;
	}
	if(!regb.test(cityval)){
		$j(divName + ' #scity').text("<?php echo sprintf(TEXT_PLEASEENTER_CHARLEAST, 3); ?>");
		checked = false;
    }
	if(!regb.test(tel)){
		$j(divName + ' #telnumber').text("<?php echo sprintf(TEXT_PLEASEENTER_CHARLEAST, 3); ?>");
		checked = false;
    }
	if(!regb.test(postalval)){
		$j(divName + ' #postCode').text("<?php echo sprintf(TEXT_PLEASEENTER_CHARLEAST, 3); ?>");
		checked = false;
    }else{
		if(zip_code_rule != ''){
			if(!zip_code_rule_reg.test(postalval)){
				error_data =true;
				$j(divName + ' #postCode').html("<?php echo CHECKOUT_ZIP_CODE_ERROR; ?>" + zip_code_example.replace(',' , ' ' + '<?php echo TEXT_OR;?>' + ' '));
			}
		}
    }
    if(!regc.test(streetval)){
		$j(divName + ' #street').text("<?php echo sprintf(TEXT_PLEASEENTER_CHARLEAST, 5); ?>");
		checked = false;
    }
    if(streetval == suburb ){
    	$j(divName + ' #sub').text("<?php echo ENTRY_FS_ADDRESS_SAME_ERROR; ?>");
    	checked = false;
    }
	return checked;
}
		  
function save_address_book(divName,customer_addressbook_id){

	if(!check(divName)) {
		return false;
	}
	var first_name = $j(divName + " #firstname").val();
	var last_name = $j(divName + " #lastname").val();
	radio_arr = document.getElementsByName('gender');
	gender='';

	if(divName == "#add_new_address"){		
		gender=radio_arr[0].value;
	} else{		
		gender=radio_arr[1].value;
	}
	
	var company = $j(divName + " #company").val();
	var street_address = $j(divName + " #street_address").val();
	var suburb = $j(divName + " #suburb").val();
	var city = $j(divName + " #city").val();		
	var zone_country_id=$j(divName + " #zone_country_id").val();
	var zone_state_list = $j(divName + " #stateZone"); 
	var zone_id = $j(divName + " #stateZone").val();
	var state = $j(divName + " #state").val();
	var postcode = $j(divName + " #postcode").val();		
	var telephone = $j(divName + " #telephone").val();
	var tariff_number = $j(divName + " #tariff_number").val();
	var email_address = $j(divName + " #backup_email_address").val();
	var zip_code_rule = $j.trim($j(divName + ' #select_coutry_zip_code_info').attr('zip_code_rule'));
	var zip_code_example = $j.trim($j(divName + ' #select_coutry_zip_code_info').attr('zip_code_example'));
	var primary = '';
	var selected_address;
	customer_addressbook_id != '' ? selected_address = customer_addressbook_id : selected_address = 0;
	if($j(divName + " #primary").is(":checked"))	primary = $j(divName + " #primary").val();	
	var param = { action:'new_address', 
			      first:first_name, 
			      last:last_name, 
			      gender:gender, 
			      company:company,
			      street_address:street_address, 
			      suburb:suburb, city:city, 
			      zone_country_id:zone_country_id,
				  zone_id:zone_id, 
				  state:state, 
				  postcode:postcode,
				  telephone:telephone,
				  tariff_number:tariff_number,
				  email_address:email_address,
				  primary:primary,
			      selected_address:selected_address,
				  zip_code_rule:zip_code_rule,
			      zip_code_example:zip_code_example  };				
	$j.post("./address_book_manager.php", param, function(data){		
		//alert(returnInfo.message);
		//console.log(data);
		data = $j.trim(data);
		if(data=='success'){			
			setTimeout('window.location.href="index.php?main_page=address_book&update=true"',1);
		}else{
// 			$j(divName + " #error_same_address").html(data);
			//window.location.href="index.php?main_page=address_book";
		}							
	})	
}

function delete_address_book(action,customer_addressbook_id){
	if(confirm("Are you sure to delete this shipping address?")){
		var param = { action:action,customer_addressbook_id:customer_addressbook_id }
		$j.post("./address_book_manager.php", param, function(data){			
			if(data=='success'){		
				setTimeout('window.location.href="index.php?main_page=address_book&update=true"',1);
			}else{
				window.location.href="index.php?main_page=address_book";
			}					
		})
	
	} else return false;
	
}
function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

function set_default_address(addressBookId){
	$j.post("./address_book_manager.php", {action:'set_default_address', address_book_id:addressBookId}, function(data){		
		//alert(returnInfo.message);
		//console.log(data);
		if(data){			
			window.location.href="index.php?main_page=address_book";
		}else{
			//alert(123);
		}

	})	
}
</script>