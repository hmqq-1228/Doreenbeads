// JavaScript Document
$(function(){	
	$('#refine-bybtn').click(function(){
		var dheight = $(document).height();
		$('.windowbg').css('height',dheight);
		$('.windowbg').show('fast');
		$('.refine-right').show('fast');	
		})

  
	var wheight = $(window).height();
   $('.refine-arrow').css('top',((wheight-30)/2)+'px');
    $(window).scroll(function(){
	 	var wheight = $(window).height();
		$('.refine-arrow').css('top',((wheight-30)/2)+'px');
	    $('.refine-arrow').css('position','fixed');
		})
	
	    $('.refine-tit').click(function(){
			var ch = $('.refine-right ul.current').height();
			if($(this).hasClass('choose')){
				$(this).removeClass('choose');
				$(this).next('ul').slideUp('500').removeClass('current');
		     }else{
			    $('.refine-tit.choose').removeClass('choose');
			    $(this).addClass('choose');
				$('.refine-right ul.current').slideUp('500').removeClass('current');
				$(this).next('ul').slideDown('500').addClass('current');				
			 }
			
			var topoffset = $(this).offset().top;
			if(ch == ''){
				$(window).scrollTop(topoffset);
			}else if(ch > topoffset){
				$(window).scrollTop(topoffset);
				}else{
					$(window).scrollTop(topoffset-ch);
				}
       	})
		
		
		
		
		
	$('.refine-arrow').click(function(){
		$('.windowbg').hide('slow');
		$('.refine-right').hide('slow');
		})
		
    $('.windowbg').click(function(){
		$('.windowbg').hide('slow');
		$('.refine-right').hide('slow');
		})
		
			
    $('.back-to-top').click(function(){
		  $('body,html').animate({scrollTop: 0},0);
		})
		
    $('.refine-right ul li.more').click(function(){
		$(this).parents('ul').children('.morelist').slideDown();
	    $(this).hide();
		$(this).next('li.less').show();
		})	
	  $('.refine-right ul li.less').click(function(){
		var settop = $(this).parent('ul').prev('.choose').offset().top;		
		$(this).parent('ul').children('.morelist').slideUp();
	    $(this).hide();
		$(this).prev('li.more').show();
		$(window).scrollTop(settop);
		})	
		
	  $('.category-list .morebtn').click(function(){
		 $(this).parent('ul').children('.more').slideDown();
		 $(this).hide();
		 $(this).next('.lessbtn').show();
		  })
	   $('.category-list .lessbtn').click(function(){
		 $(this).parent('ul').children('.more').slideUp();
		 $(this).hide();
		  $(this).prev('.morebtn').show();
		  })
	 
	   $('.product-type-tit li').each(function(index){
	   $(this).click(function(){
		   $('.product-type-tit li.choose').removeClass('choose');
		   $(this).addClass('choose'); 
		   $('.product-show.sh').removeClass('sh');
		   $('.product-show').eq(index).addClass('sh');
		   if($(this).index()==2){
			   $('.product-type-tit').addClass('initcolor');
		   }else{
			   $('.product-type-tit').removeClass('initcolor');
			   }
		   }) 	
		  })
		  
		  $('.searchinput').focus(function(){
			  var initvalue = 'Search Products';
			  if($(this).attr('value')== initvalue){
				 $(this).attr('value',''); 
				 $(this).addClass('writefocus');
				  }
			  })
		$('#subscribeinput').focus(function(){
			  var initvalue = 'Enter Email Address';
			  if($(this).attr('value')== initvalue){
				 $(this).attr('value',''); 
				 $(this).addClass('writefocus');
				  }
			  })	  
		
		
		
	

		
      var len = $('.slider-list li').length;
	   var swidth = $('.slider-list li').width(); 
	   var index=0;
	   
	  
	   $('.slider-list').css('width',len*swidth);
	   function showimg(index){
		   $('.slider-list').attr('imgindex',index);
		   var nowleft = -index*swidth;
		   $('.slider-list').animate({left:nowleft},300);
		   }
		   
		 $('#prev').click(function(){
		      index -=1 ;
			  if(index==0){
				  $(this).hide()
			  }
				  showimg(index);	
				  $('#next').show();	
			  })  
			 
		$("#next").click(function() { 
           	index += 1;
		    if(index == len-1) {
			  $(this).hide();
			}
		      showimg(index);    
		     $('#prev').show();	
	});
	   
	   
	   	 function initarrow(){
		  var l=$('.slider-list li').length-1;
		  var n = $('.slider-list').attr('imgindex');
		   $('#next').show();
		   $('#prev').show();
		      if(n==0){
			  $('#prev').hide();
			  }
			  if(n==l){
			    $('#next').hide();
			  }
		}
         initarrow();
		
	
	var reviewlevel = ["(Poor)","(Fair)","(Average)","(Good)","(Excellent)"] ;
    var star = $("#review span");
    var a = "greystar";
    var b = "goldstar";
    var curvalue=-1; //鼠标离开的时候
	star.each(function(index){
            $(star[index]).click(function(){
		       curvalue=index;
                $("#review input").attr("value",index+1);
                full(index);
            })
            $(star[index]).mouseover(function(){
                full(index);
            })
            $(star[index]).mouseout(function(){
                full(curvalue);
                if(curvalue ==-1)
                    $("#review ins").text( "");
            })
        })
		
		 
   
    function full(index){
        for( var i=0;i<star.length; i++ ){
            if(i<=index)
                $(star[i]).attr('class',b);
            else
                $(star[i]).attr('class',a);
        }
        $("#review ins").text( reviewlevel[index]);
		$("#review label").text('');
    }
		
		
    var review_tips="Please add a few more words to your comments. The review needs to have at least 1 character.";	
	$("#review-text").val(review_tips);	
    $("#review-text").blur(function(){
		if($(this).val() == '')
			$(this).val(review_tips);
		else
		    $(this).val();
	})
    $("#review-text").focus(function(){
		if($(this).val() == review_tips){
			$(this).val('');
			$("#review-text").css("background","#fff");
			$("#review-text").css("color","#959595")
			}else{
					$(this).val();
				}
	})	
	
	
	$("#review-text").keyup(function(){
	      if($(this).val() == review_tips){
			$(this).val('');
		  }else{
			    $("#review-text").css("color","#333");
			    $('#remaintext').text(1000-($(this).val().length));
				if($(this).val().length>1000){
				$(this).val($(this).val().substr(0,1000))
				
					}
			  }
	   
	   })	
	   
	    var reviewchecking = function(){
		var checking = true;
		var starval = $.trim($("#review input").attr("value"));
		var reviewname = $.trim($("#review_text").val()); 
		if(starval == ""){
		    $("#review label").text("Please choose a rating for this item");	
			$("#review label").css("color","#c50000").css("font-weight","normal");
			checking = false;
			}else{
				$("#review label").text("");	
			}		
        if(reviewname == "" || reviewname == review_tips ){
		    $("#review-text").css("background","#fffdea").css("color","#c70006");
			checking = false;
			}	
			return checking;		
		}


    $("#reviewsubmit").click(function(){
		if(!reviewchecking())
		   return false;
		})	
		
		
		
	var question_checking= function(){
		var q_checking = true;
		var emailvalue = $('#question-email').val();
		var firstname = $('#first-name').val();
		var lastname = $('#last-name').val();
	    var questionvalue = $('#question-text').val();
		var reg=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		if(!reg.test(emailvalue)){
			$('#question-email').next('p').text('Your email address does not appear to be valid.please try again');
			q_checking = false;
			}
	     if(firstname == ''){
			$('#first-name').next('p').text('Your first name must not be empty');
			q_checking = false;
			} 
		 if(lastname == ''){
			$('#last-name').next('p').text('Your last name must not be empty');
			q_checking = false;
			}  
		 if(questionvalue == ''){
			$('#question-text').next('p').text('Your question must not be empty');
			q_checking = false;
			}   
			return q_checking;	
		}	
	
	
	 $("#question-submit").click(function(){
		if(!question_checking())
		   return false;
		})	
			
			
	$('.questionform .required').focus(function(){
		$(this).next('p').text('');
		})		
	
	$('.dlgallery-list .addcart-icon').click(function(){
	     var offset =$(this).offset();
		 var wheight=($('#addsuccess-tip').height()+45);
         var top = offset.top;
		 var wtop = top - wheight;
        $('#addsuccess-tip').css('top',wtop);
		})	
		
 
 
  //下单过程JS
  $('.getdiscount').mousedown(function(){$(this).hide();$('#discounttab').show();})
  $('#subcribe-email').click(function(){
	  $(this).children('.check').toggleClass('select');
	  })
  $('#agree').click(function(){
	  $(this).children('.check').toggleClass('select');
	  })				
	  
  $('.deletebtn').click(function(){
	 $('.addressedittips').hide() 
	$(this).parents('.addresslist').next('.addressedittips').show();
     $('.cancelbtn').click(function(){
		$(this).parents('.addressedittips').hide();
	 })
     $('.okbtn').click(function(){
		 	$(this).parents('.addressedittips').prev('.addresslist').remove();
			 $(this).parents('.addressedittips').remove();
		 })
  }) 	  
	
	
	$('.addresslist.selected').find('.deletebtn').hide();
	$('.addresslist input').click(function(){
		$('.addresslist').removeClass('selected');
		$('.addresslist .deletebtn').show();
		$(this).parents('.addresslist').addClass('selected');
		$(this).parents('.addresslist').find('.deletebtn').hide();
	
	})
		
		
	$('.required').focus(function(){
		 $(this).next('span').text('');
		
	
		})
	$('.telephone').focus(function(){$('#tell').text(''); })	
  	$('.addresstext').focus(function(){$('#address1').text(''); })	
	$('.newemail').focus(function(){ $('#emailtext').text('');})

	$('.viewallbtn').click(function(){
		$(this).next('.alldetails').toggle();
		})	
	$('.closedetail').click(function(){
		$(this).parents('.alldetails').hide();
		})
		
	$('#usecoupon').click(function(){
		if( $(this).attr('checked') ==  "checked"){
          	$('.couponselect').show();
			}else{
			$('.couponselect').hide();
				}
		})		
	$('#usebtn2').click(function(){
		$(this).parent('.selectcont1').hide();
		$('.selectcont2').show();
		})	
		
	$('#usebtn1').click(function(){
		$('.discounttext-cont').hide();
		$('.discounttext-success').show();
		})
		
	
	function shiptr(){
	$('.shipmethod-list tr').each(function(){ if($(this).index()>4){ $(this).hide();} }) }		
	shiptr();	
	
	
	$('.morecont').click(function(){$('.shipmethod-list tr').show();$(this).hide();$('.lesscont').show();$('.ship-type').show();})	
    $('.lesscont').click(function(){shiptr();$(this).hide();$('.morecont').show();$('.ship-type').hide();})	

    $('.shipmethod-list input').click(function(){
      $('.shipmethod-list tr').removeClass('selected');
	  $(this).parents('tr').addClass('selected');
	})
	
	$('.opentips').click(function(){
		$('.shiptips').hide();
		$(this).next('.shiptips').toggle();})
    $('.closetips').click(function(){$('.shiptips').hide();})
	
	$('.pricetipsicon').click(function(){
		$('.pricetipscont').toggle();
		})
		
	$('.discountcoupon').click(function(){
		$('.discounttips').toggle();
		})
	   
	 
	   
	
		
			
			
	   function  bombwindow(nowbtn,confirmwindow,okbtn,cancelbtn,cont){
		   $('.'+nowbtn).click(function(){
		    $('.'+confirmwindow).show(); 
			 $('.'+okbtn).click(function(){
				 $('.'+cont).remove();
					$('.'+confirmwindow).hide();
				})
				
		 $('.'+cancelbtn).click(function(){
					$('.'+confirmwindow).hide();
					})
		   })
		   }
		   
		   
    bombwindow('empty-btn','emptytips-move','okbtn','cancelbtn','shopcart-cont');
	bombwindow('moveall-btn','confirmtips-move','okbtn','cancelbtn','shopcart-cont');
	
   
   
   $('.delete-btn').click(function(){
	   $(this).parents('.shopcart-list').next('.deletetips').show();
	   $('.okbtn').click(function(){
		   $(this).parents('.deletetips').hide();
		    $(this).parents('.deletetips').prev('.shopcart-list').remove();
		   })
	  $('.cancelbtn').click(function(){
		   $(this).parents('.deletetips').hide();
		   })
	   })
	   
	   
	   
	$('#searchbtn').click(function(){
		if($(this).attr('class')=='back-button1'){
			    $(this).attr('class','back-button2');
			}else{
				$(this).attr('class','back-button1')	
				}
		$('.Order').toggle();
		})   
		
/*	$('.methodlist li label').click(function(){
		var ttop = $(this).offset().top; 
		$('.submethods').hide();
		$(this).next('.submethods').show();
		$(window).scrollTop(ttop-20); 
		})
	$('.methodlist li label input').click(function(){
		var ttop = $(this).offset().top; 
		$('.submethods').hide();
		$(this).next('.submethods').show();
		$(window).scrollTop(ttop-20); 
	})*/
	$('.methodlist li').click(function(){
		var ttop = $(this).children('label').offset().top; 
		$(this).children('label').children('input').attr('checked','true');
		$('.submethods').hide();
		$(this).children('label').next('.submethods').show();
		$(window).scrollTop(ttop-20); 
		})
	$('.methodlist li label input').click(function(){
		var ttop = $(this).offset().top; 
		$('.submethods').hide();
		$(this).next('.submethods').show();
		$(window).scrollTop(ttop-20); 
	})	
	
	$('.jq_show_payment_li li').click(function(){
		if ($(this).find('.payment_show').is(":hidden")){
			$('.payment_show').hide();
			$(this).find('.payment_show').show();
		}
	});
		
	$('.usermenulist p').click(function(){
		$('.viplevel').hide();
		if($(this).hasClass('now')){
			$(this).next('ul').slideUp('500');
			$(this).removeClass('now');
		}else{
			$('.usermenulist p.now').removeClass('now');
		    $('.usermenulist p').next('ul').slideUp('500');
			$(this).next('ul').slideDown('500');	
		    $(this).addClass('now');
				}
		
		
		})	
		
		
		  var checking = function() {
	        var checked = true;
		   	var rega=/^.{2,}$/;
		    var regb=/^.{3,}$/;
			var regc=/^.{5,}$/;
			var telval=$.trim($('.telephone').val());
			var fnameval=$.trim($('.firstname').val());
			var lnameval=$.trim($('.lastname').val());
			var cityval=$.trim($('.citytext').val());
			var tel=$.trim($('.telephone').val());
			var postalval=$.trim($('.posttext').val());
			var streetval=$.trim($('.addresstext').val());
			var zip_code_rule = $.trim($('#select_coutry_zip_code_info').attr('zip_code_rule'));
			var zip_code_rule_reg = new RegExp(zip_code_rule, 'i');
			var zip_code_example = $.trim($('#select_coutry_zip_code_info').attr('zip_code_example'));
		
		   if(!rega.test(fnameval)){
			$('.firstname').next('span').text('please enter 2 characters at least');
		  	checked = false;
		    }
		    if(!rega.test(lnameval)){
			$('.lastname').next('span').text('please enter 2 characters at least');
			checked = false;
	      	}
			 if(!regb.test(cityval)){
			$('.citytext').next('span').text('please enter 3 characters at least');
			checked = false;
	      	}
			 if(!regb.test(tel)){
			$('#tell').text('please enter 3 characters at least');
			checked = false;
	      	}
			if(!regb.test(postalval)){
				$('.posttext').next('span').text('please enter 3 characters at least');
				checked = false;
	      	}else{
				if(zip_code_rule != ''){
					if(!zip_code_rule_reg.test(postalval)){
						checked = false;
						$('.posttext').next('span').text($lang.CHECKOUT_ZIP_CODE_ERROR + zip_code_example.replace(',' , ' ' + $lang.TEXT_OR + ' '));
					}
				}
			}
	        if(!regc.test(streetval)){
			$('#address1').text('please enter 5 characters at least');
			checked = false;
	      	}
		  
		}	
	
	$('.addresscheck').click(function(){
		if(!checking()) {return false;}})


    var infochecking = function() {
	    var checked1 = true;
		var rega=/^.{2,}$/;
	    var regb=/^.{3,}$/;
		var regc=/^.{5,}$/;
		var telval=$.trim($('.tell').val());
		var fnameval=$.trim($('.firstname').val());
		var lnameval=$.trim($('.lastname').val());
		   if(!rega.test(fnameval)){
			$('.firstname').next('span').text('please enter 2 characters at least');
		  	checked1 = false;
		    }
		    if(!rega.test(lnameval)){
			$('.lastname').next('span').text('please enter 2 characters at least');
			checked1 = false;
	      	}
		   if(!regb.test(telval)){
			$('.tell').next('span').text('please enter 3 characters at least');
			checkedl = false;
	      	}  
		   
		 return checked1;
		}	
	
	  $('#infosubmit').click(function(){		
	   if(!infochecking()){
		   return false;
		   }
	  })
	  
	  
	   $('.emailValidate').click(function(){
		 var reg=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		 emailval=$.trim($('.newemail').val());
		 if(!reg.test(emailval)){
			 $('#emailtext').text('please enter the right email');
			 return false;
			 }
		 })
		 
		 
		 
       $('#passwordchange').click(function(){
	    var reg11=/^.{5,}$/;
		var passval=$.trim($('.currentpass').val());
		if(!reg11.test(passval)){
			error=" Your Password must contain a minimum of 5 characters.";
		  $('.currentpass').next('span').text(error);
			return false;
		}else{
			  $('.currentpass').next('span').text('');
			}
		var newpass=$.trim($('.newpass').val());
		if(!reg11.test(newpass)){
			error=" Your new Password must contain a minimum of 5 characters.";
		  $('.newpass').next('span').text(error);
			return false;
		
		}else{
			  $('.currentpass').next('span').text('');
			}
		var confirm1 = $('.confirmpass').val();
		if( newpass != confirm1){
			error=" The Password Confirmation must match your new Password.";
	        $('.confirmpass').next('span').text(error);
				return false;
			}
	}) 
	

	})
	
   
  