
  function hideStateField(theForm) {
    theForm.state.disabled = true;
    theForm.state.className = 'hiddenField';
    theForm.zone_id.disabled = false;
    theForm.state.setAttribute('className', 'hiddenField');
    theForm.zone_id.className = 'inputLabel visibleField';
    theForm.zone_id.setAttribute('className', 'visibleField');
    
  }

  function showStateField(theForm) {
    theForm.state.disabled = false;
    theForm.zone_id.className = 'hiddenField';
    theForm.zone_id.disabled = true;
    theForm.state.className = 'inputLabel visibleField';
   
    theForm.state.setAttribute('className', 'visibleField');
    //theForm.state.type = 'text';
    
  }

  function country_select_choose(cName,fun){
      $('body').click(function(e){
         var elem = e.srcElement||e.target;
         if(elem.tagName == 'FIELDSET' || elem.tagName == 'TD' || elem.tagName == 'DIV'){
             $(".country_select_drop").hide();
             $('.choose_single').removeClass('choose_single_click');
             $('.choose_single').addClass('choose_single_focus');
         }
      });          
      $(document).ready(function(){
          $('.choose_single').click(function(){
                  var ifshow=$('.country_select_drop').css('display');
                  //var ifshow = $(this).parent('a').next('div.country_select_drop').css('display');
                  //alert(ifshow);
                  current=$("#cSelectId").val();
                  if(ifshow=="none"){
                      $('.country_select_drop').show();
                      $(this).removeClass('choose_single_focus');
                      $(this).addClass('choose_single_click');
                      $('.country_select_drop .choose_search input').val('');
                      $('.country_select_drop ul .country_list_item').css('display','block');
                      $('.country_select_drop .choose_search input').focus();
                      cNum=$('#cSelectId').val();
                      if($("#country_list_"+cNum).hasClass('country_list_item_selected')&&!$("#cSelectId").hasClass('selectNeedList')){
                          
                      }else{
                          $("#cSelectId").removeClass('selectNeedList');
                          $("#country_list_"+cNum).addClass('country_list_item_selected');
                          boxTop1=$("#country_list_1").position().top;
                          boxTop2=$("#country_list_"+cNum).position().top;
                          selfHeight=$("#country_list_"+cNum).height()+8+7;
                          boxTop=boxTop2-boxTop1-220+selfHeight;
                          $('.country_select_drop ul').scrollTop((boxTop));
                      }
                  }else{
                      $('.country_select_drop').hide();
                      $(this).removeClass('choose_single_click');
                      $(this).addClass('choose_single_focus');
                  }
              })
          $('.country_list_item').hover(function(){
              $(this).addClass('country_list_item_hover');
              $('.country_list_item').removeClass('country_list_item_selected');
              },function(){
                  $(this).removeClass('country_list_item_hover');
                  });    

          $('.country_list_item').click(function(){    
              var num = $('.country_select_drop').index($(this).parent().parent());
              var cListId=$(this).attr('clistid');
              var cText=$(this).text();
              var cId=$(this).attr('id');
      		  var zip_code_rule = $.trim($(this).attr('zip_code_rule'));
    		  var zip_code_example = $.trim($(this).attr('zip_code_example'));
    		
              cIdArr=cId.split('_'); 
              getCId=cIdArr[2];
      		  $('#select_coutry_zip_code_info').attr('zip_code_rule',zip_code_rule);
    		  $('#select_coutry_zip_code_info').attr('zip_code_example',zip_code_example);
              $('.choose_single span').text(cText);
              $('#'+cName).val(cListId);
              $('#cSelectId').val(getCId);
              $(this).addClass('country_list_item_selected');
              $('.country_select_drop').hide();
              if(num == 0){
                  $('#add_new_address #'+cName).val(cListId);
              }else if(num == 1){
                  $('#edit_address_book #'+cName).val(cListId);
              }
              $('.choose_single').removeClass('choose_single_click');
              $('.choose_single').addClass('choose_single_focus');
              $('.choose_single').focus();
              //alert($("li").index(this));
              if(fun){
                  formEle=document.getElementsByName(fun);
                  update_zone_c(formEle[num]);
                  }
              });    

          $('.choose_single').blur(function(){
              $(this).removeClass('choose_single_focus');
              });

          $('.choose_search input').keyup(function(){
              inputVal=$(this).val();
              inputVals=inputVal.replace(/^\s*|\s*$/g, "");
              if(inputVals!=''){
                      $('.country_select_drop ul').scrollTop(0);
                      $("#cSelectId").addClass('selectNeedList');
                      $(".country_select_drop ul .country_list_item").each(function(){
                          cTextVal=$(this).text();
                          re = new RegExp("^"+inputVals,'i');  
                          re2= new RegExp("\\s+"+inputVals,'i');
                          if(cTextVal.match(re)||cTextVal.match(re2)){
                                      $(this).css('display','block');
                                  }else{
                                      $(this).css('display','none');
                                      }
                          });
                  }else{
                      $('.country_select_drop ul .country_list_item').css('display','block');
                  }
              });     
          });       
}


function check_addressform(form_name){

	form = form_name;
	error_data=false;
	
	//var title =$.trim(form.Title.value);
	var title = $('input[name="Title"]:checked').val();
	var firstname = $.trim(form.firstname.value);	
	var lastname = $.trim(form.lastname.value);
	var company	 = $.trim(form.company.value);
	var address1 = $.trim(form.address1.value);
	var address2 = $.trim(form.suburb.value);
	var country_id = $.trim(form.zone_country_id.value);
	var province = $.trim(form.zone_id.value);
	//alert(province);
	var city = $.trim(form.city.value); 
	var post = $.trim(form.post.value);
	var tel  = $.trim(form.tel.value);
	var zip_code_rule = $.trim($('#select_coutry_zip_code_info').attr('zip_code_rule'));
	var zip_code_rule_reg = new RegExp(zip_code_rule, 'i');
	var zip_code_example = $.trim($('#select_coutry_zip_code_info').attr('zip_code_example'));
	
	var email_min_len = 6;
	var password_min_len = 5;	
	
	$('.firstname').next('span').text('');
	$('.lastname').next('span').text('');
	$('#address1').text('');
	$('#suburb').text('');
	$('.citytext').next('span').text('');
	$('.posttext').next('span').text('');
	$('#tell').text('');
			
	if(firstname.length<1){
		error_data=true;
		$('.firstname').next('span').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_2);		
	}	
	
	if(firstname == lastname && firstname != ''){
		error_data = true;
		$('.lastname').next('span').text(js_lang.ENTRY_FL_NAME_SAME_ERROR);
	}
	
	if(lastname.length<1){
		error_data=true;
		$('.lastname').next('span').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_2);
	}
	if(address1.length<5){
		error_data=true;
		$('#address1').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_5);
	}
	if(address1 == address2){
		error_data= true;
		$('#suburb').text(js_lang.ENTRY_FS_ADDRESS_SAME_ERROR);
	}
	
	if(city.length<3){
		error_data=true;
		$('.citytext').next('span').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_3);
	}
	if(post.length<3){
		error_data=true;
		$('.posttext').next('span').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_3);
	}else{
		if(zip_code_rule != ''){
			if(!zip_code_rule_reg.test(post)){
				error_data=true;
				$('.posttext').next('span').text(js_lang.CHECKOUT_ZIP_CODE_ERROR + zip_code_example.replace(',' , ' ' + js_lang.TEXT_OR + ' '));
			}
		}
	}
	if(tel.length<3){
		error_data=true;
		$('#tell').text(js_lang.TEXT_PLEASEENTER_CHARLEAST_3);
	}
	
	if(error_data==false){	
		return true;
	}
	return false;
	
}



