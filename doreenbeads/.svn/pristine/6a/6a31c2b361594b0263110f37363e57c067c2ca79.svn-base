function indexJqueryLoad(selector,finds,action,type,time,another,style){
	if(action=='hover'){
		
		$j(selector).each(function(){
			
			
			$j(this).hoverDelay({
					
					hoverEvent:	function(){
				if(type=='height'){
					$j(this).find(finds).stop(true,true).slideDown(time);
					if(another=='this'){
						$j(this).addClass(style);	
						}else if(another!=''){
							$j(this).find(another).addClass(style);	
						}
				}else if(type=='visible'){
					$j(this).find(finds).stop(true,true).fadeIn(time);
					if(another=='this'){
						$j(this).addClass(style);	
						}else if(another!=''){
							$j(this).find(another).addClass(style);	
						}
				}else{
					$j(this).find(finds).stop(true,true).show(time);
					if(another=='this'){
						$j(this).addClass(style);	
						}else if(another!=''){
							$j(this).find(another).addClass(style);	
						}
				}
				
			},
			outEvent:function(){
				if(type=='height'){
					$j(this).find(finds).slideUp(time);	
					if(another=='this'){
						$j(this).removeClass(style);	
						}else if(another!=''){
							$j(this).find(another).removeClass(style);	
						}
				}else if(type=='visible'){
					$j(this).find(finds).fadeOut(time);
					if(another=='this'){
						$j(this).removeClass(style);	
						}else if(another!=''){
							$j(this).find(another).removeClass(style);	
						}
				}else{
					$j(this).find(finds).hide(time);
					if(another=='this'){
						$j(this).removeClass(style);	
						}else if(another!=''){
							$j(this).find(another).removeClass(style);	
						}
				}
			}})	
			
		})
		
	
	
	
	
	}else{
		$j(selector).toggle(function(){			
			if(type=='height'){
				$j(this).find(finds).stop(true,true).slideDown(time);
				if(another=='this'){
					$j(this).addClass(style);	
					}else if(another!=''){
						$j(this).find(another).addClass(style);	
					}
			}else if(type=='visible'){
				$j(this).find(finds).stop(true,true).fadeIn(time);
				if(another=='this'){
					$j(this).addClass(style);	
					}else if(another!=''){
						$j(this).find(another).addClass(style);	
					}
			}else{
				$j(this).find(finds).stop(true,true).show(time);
				if(another=='this'){
					$j(this).addClass(style);	
					}else if(another!=''){
						$j(this).find(another).addClass(style);	
					}
			}
		},function(){
			if(type=='height'){
				$j(this).find(finds).stop(true,true).slideUp(time);	
				if(another=='this'){
					$j(this).removeClass(style);	
					}else if(another!=''){
						$j(this).find(another).removeClass(style);	
					}
			}else if(type=='visible'){
				$j(this).find(finds).fadeOut(time);
				if(another=='this'){
					$j(this).removeClass(style);	
					}else if(another!=''){
						$j(this).find(another).removeClass(style);	
					}
			}else{
				$j(this).find(finds).hide(time);
				if(another=='this'){
					$j(this).removeClass(style);	
					}else if(another!=''){
						$j(this).find(another).removeClass(style);	
					}
			}
		})	
	}
	
}
function notIndexJqueryLoad(selector,finds,action,another,style){
	if(action=='hover'){
		$j(selector).each(function(){
			$j(this).hoverDelay({
			    hoverEvent: function(){
			    	$j(this).find(finds).show();
					if(another=='this'){
						$j(this).addClass(style);	
						}else if(another!=''){
							$j(this).find(another).addClass(style);	
						}
			    },
				outEvent:function(){
					
					$j(this).find(finds).hide();
					if(another=='this'){
						$j(this).removeClass(style);	
						}else if(another!=''){
							$j(this).find(another).removeClass(style);	
						}
				}
			})
			
		})
	}else{
		$j(selector).toggle(function(){
			$j(this).find(finds).show();
			if(another=='this'){
			$j(this).addClass(style);	
			}else if(another!=''){
				$j(this).find(another).addClass(style);	
			}
		},function(){
			$j(this).find(finds).hide();
			if(another=='this'){
				$j(this).removeClass(style);	
				}else if(another!=''){
					$j(this).find(another).removeClass(style);	
				}
		})		
	}
}


function clearTips(id,words){
	if(id.value==words){
		id.value='';
		}
}


function showTips(id,words){
	if(id.value==''){
		id.value=words;
		}
}
function changeBread(){
	$j("#navBreadCrumb ul li").hover(function(){
		indexs=$j("#navBreadCrumb ul li").index(this)-1;
		$j("#navBreadCrumb ul li div").eq(indexs).addClass('changedivbg');
		$j(this).addClass("navBreadCrumbLiHover");
		$j(this).find("div").addClass("navBreadCrumbLiHoverDiv");
		},function(){
			$j("#navBreadCrumb ul li div").eq(indexs).removeClass('changedivbg');
		$j(this).removeClass("navBreadCrumbLiHover");
		$j(this).find("div").removeClass("navBreadCrumbLiHoverDiv");
	})
	$j(".normalBread").hover(function(){
		$j(this).addClass("normalBreadHover");
		$j(this).find("div").addClass("normalBreadHoverDiv");
	},function(){
		$j(this).removeClass("normalBreadHover");
		$j(this).find("div").removeClass("normalBreadHoverDiv");
	})
	$j(".normalbreadHome").hover(function(){
		$j(this).addClass("normalbreadHomeHover");
		$j(this).find("div").addClass("normalbreadHomeHoverDiv");
	},function(){
		$j(this).removeClass("normalbreadHomeHover");
		$j(this).find("div").removeClass("normalbreadHomeHoverDiv");
	})
	$j(".home_also_before").hover(function(){
		$j(this).addClass("home_also_beforeHover");
		$j(this).find("div").addClass("home_also_beforeHoverDiv");
	},function(){
		$j(this).removeClass("home_also_beforeHover");
		$j(this).find("div").removeClass("home_also_beforeHoverDiv");
	})
	$j(".breadtrailHome").hover(function(){
		$j(this).addClass("breadtrailHomeHover");
		$j(this).find("div").addClass("breadtrailHomeHoverDiv");
	},function(){
		$j(this).removeClass("breadtrailHomeHover");
		$j(this).find("div").removeClass("breadtrailHomeHoverDiv");
	})
	
	$j(".beforelastone").hover(function(){
		$j(this).addClass("beforelastoneHover");
		$j(this).find('div').addClass("beforelastoneHoverDiv");
	},function(){
		$j(this).removeClass("beforelastoneHover");
		$j(this).find('div').removeClass("beforelastoneHoverDiv");
	})
	
	$j('.breadtrail').hover(function(){
		$j(this).addClass("breadtrailHover");
		$j(this).find("div").addClass("breadtrailHoverDiv");
		$j('.beforelastone').find("div").addClass("beforelastHover");
		$j('.home_also_before').find("div").addClass("beforelastHover");
	},function(){
		$j(this).removeClass("breadtrailHover");
		$j(this).find("div").removeClass("breadtrailHoverDiv");
		$j('.beforelastone').find("div").removeClass("beforelastHover");
		$j('.home_also_before').find("div").removeClass("beforelastHover");
	})
}
/*
function showContactUs(lang,url,from,isIeSix){
	var livechat,emailinfo,suggestinfo,cellphone,faqinfo;
	switch(lang){
	case 'english': 
	livechat='<h1>Live Chat</h1><p>The Quickest way to get help.</p><p class="faux-link"><span>Chat with a customer care agent</span></p>';
	cellphone='<h1>Call Us On (+86 )579-85335690</h1>We’re available from Monday to Saturday（BeiJing Time）, 6 days a week.<br>';
	emailinfo='<h1>Email</h1><p>Send us an email. We will reply promptly within one business day.</p><p class="faux-link"><span>Email your question or comment</span></p>';
	faqinfo='<h1>Customer Help Center</h1><p>Find information like how to place or track an order.</p><p class="faux-link"><span>Visit our Customer Help Center</span></p>';
	suggestinfo='<h1>Have a Suggestion?</h1><p>Tell us what brands you’d like to see, or let us know how you think we can improve.</p><p class="faux-link"><span>Send us your suggestion</span></p>';
		break;
	default:
		livechat=emailinfo=suggestinfo=cellphone=faqinfo='';
	}
	contact_us="<div id='show_contact_us'>" +
			"<table border=0 cellspacing=0 cellpadding=0 width='100%'>" +
			"<tr>" +
				"<td class='contact_bg contact_bg_tl'></td>" +
				"<td class='contact_us_bg'></td>" +
				"<td class='contact_bg contact_bg_tr'></td>" +
			"</tr>" +
				"<tr>" +
				"<td class='contact_us_bg'></td>" +
				"<td id='contact_us_main_body'>" +
					"<div id='contact_us_close'><a href='javascript:void(0)' onclick='close_contact_us()'><img src='includes/templates/cherry_zen/images/"+lang+"/box_close.gif' border=0 alt=''></a></div>"  +
					"<div style='clear:both'>&nbsp;</div>" +
					"<div id='show_contact_info'>" +
					"<div class='contact-div' onclick='close_contact_us()'>" +
					"<a href='JavaScript:void(0)' onclick=\"window.open(\'http://72.14.190.244/phplivefinal8years/request.php?langs="+lang+"&amp;l=HongShengXie&amp;x=1&amp;deptid=1&amp;pagex=http%3A//"+from+"','unique','scrollbars=no,menubar=no,resizable=0,location=no,screenX=50,screenY=100,width=500,height=400\')\"><span class='contact_info_img'>" +
					"<img src='includes/templates/cherry_zen/images/"+lang+"/icon_live_chat.gif' alt='' border=0></span>" +
					"<span class='contact_info_words'>"+livechat+"</span>" +
					"</a></div>" +
					"<div class='contact_hr'></div>" +
					"<div class='contact-div'  onclick='close_contact_us()'>" +
					"<a href='mailto:service@8years.com'><span class='contact_info_img' >" +
					"<img src='includes/templates/cherry_zen/images/icon_eamil.png' alt='' border=0></span>" +
					"<span class='contact_info_words'>"+emailinfo+"</span>" +
					"</a></div>" +
					"<div class='contact_hr'></div>" +
					"<div class='contact-div'>" +
					"<span class='contact_info_img'>" +
					"<img src='includes/templates/cherry_zen/images/icon_cellphone.png' alt='' border=0></span>" +
					"<span class='contact_info_words'>"+cellphone+"</span>" +
					"</div>" +
					"<div class='contact_hr'></div>" +
					"<div class='contact-div'>" +
					"<a href='"+url+"/faq-ezpage-5.html'><span class='contact_info_img'>" +
					"<img src='includes/templates/cherry_zen/images/icon_faq.png' alt='' border=0></span>" +
					"<span class='contact_info_words'>"+faqinfo+"</span>" +
					"</a></div>" +
					"<div class='contact_hr'></div>" +
					"<div class='contact-div'>" +
					"<a href='"+url+"/testimonial.html'><span class='contact_info_img'>" +
					"<img src='includes/templates/cherry_zen/images/icon_suggest.png' alt='' border=0></span>" +
					"<span class='contact_info_words'>"+suggestinfo+"</span>" +
					"</a></div>" +
					"</div>" +
				"</td>" +
				"<td class='contact_us_bg'></td>" +
			"</tr>" +
			"<tr>" +
				"<td class='contact_bg contact_bg_bl'></td>" +
				"<td class='contact_us_bg'></td>" +
				"<td class='contact_bg contact_bg_br'></td>" +
			"</tr>" +
			"</table>" +
			"</div>";
	$j('body').append("<div id='allDocumentBd'></div>");
	$j("#allDocumentBd").css({"height":($j(document).height()+'px')});
	$j("#allDocumentBd").css({"filter":'alpha(opacity=60)'});
	$j("body").append(contact_us);
	box_left=($j(document).width()-$j("#show_contact_us").width())/2;
	$j("#show_contact_us").css({"left":box_left});
	$j("#allDocumentBd").stop(true,true).fadeIn(500,function(){
		$j("#show_contact_us").show();
	});
	if(isIeSix=='1'){
		$j("#show_contact_us").append('<iframe frameborder="0" scrolling="no"  ></iframe>');	
		iframeWidth=$j("#show_contact_us").width();
		iframeHeight=$j("#show_contact_us").height();
		$j("#show_contact_us").find("iframe").width(iframeWidth);
		$j("#show_contact_us").find("iframe").height(iframeHeight);
	}
}
*/
function close_contact_us(){
	$j("#show_contact_us").fadeOut(500,function(){
		$j(this).remove();
		$j("#allDocumentBd").remove();
	})
}
function ieSix_select(){
//	$j(".clearanceUl").hover(function(){
//		$j(this).find(".clearanceDiv").append('<iframe frameborder="0" scrolling="no"  ></iframe>');
//		iframeWidth=$j(this).find(".clearanceDiv").width()+1;
//		iframeHeight=$j(this).find(".clearanceDiv").height()+15;
//		$j(this).find("iframe").width(iframeWidth);
//		$j(this).find("iframe").height(iframeHeight);
//	},function(){
//		$j(this).find("iframe").remove();
//	})
//	
//	$j('#inputString').blur(function(){
//		$j('.suggestionsBox').find("iframe").remove();
//	})
//	
//	$j(".sub_more").hover(function(){
//		$j(this).find(".cate_sub_part").append('<iframe frameborder="0" scrolling="no"  ></iframe>');
//		iframeWidth=$j(this).find(".cate_sub_part").width()+1;
//		iframeHeight=$j(this).find(".cate_sub_part").height()+1;
//		$j(this).find("iframe").width(iframeWidth);
//		$j(this).find("iframe").height(iframeHeight);
//	},function(){
//		$j(this).find("iframe").remove();
//	})
//	
}
function cateListDo(){
  	ul_height=$j("#cate_list_ul").height();
	if(ul_height<=180){
		$j("#cate_list_ul").css({'height':((ul_height+3)+'px')});
	}else{
		$j("#cate_list_ul").css({'height':'183px'});
	}
    $j("#searchButTd").click(function(){
    	 var if_show=$j("#cate_list_ul").css('display');
    	if(if_show=='none'){
    	var select_id=$j("#categories_id_hid").val();
    	$j("#cate_list_ul li").each(
    	function(){
    		if($j(this).attr('cateId')==select_id){
    			$j(this).addClass("currentLiOn");
    		}
    	}		
    	)
    	$j("#cate_list_ul").show();	
    	}else{
    		$j("#cate_list_ul").hide();
    		$j("#cate_list_ul li").removeClass("currentLiOn");
    	}
    })
	$j("#cate_list_ul li").hover(function(){
		$j(this).addClass("currentLiOn");
	},function(){
		$j(this).removeClass("currentLiOn");
	})
	$j("#cate_list_ul li").click(function(){
		var getText=$j(this).text();
		var getCateId=$j(this).attr('cateId');
		$j("#category_select").val(getText);
		$j("#categories_id_hid").val(getCateId);
	})
}
function see_more(element){
	_index=$j('.see_more_more span').index(element);
	$j(element).hide();
	$j('.refine_see_more').eq(_index).slideDown(500,function(){
		$j('.see_less').eq(_index).show();
	});
	
}
function see_less(element){
	_index=$j('.see_less span').index(element);
	$j('.refine_see_more').eq(_index).slideUp(500,function(){
		$j('.see_less').eq(_index).hide();
		$j('.see_more_more span').eq(_index).show();
	});
	
}
function show_cart_terms(){
	$j('#nav_cart').hover(function(){
		$j.post('./show_cart_terms.php','',function(data){
			$j('.show_shopping_cart_content').html(data);
		})
	},function(){
		//$j('.show_shopping_cart_content').html('');
	})
}
function show_currency(){
	$j('.mycurrencySpan').hover(function(){
		$j(this).addClass('mycurrencySpanHover');
	},function(){
		$j(this).removeClass('mycurrencySpanHover');
	});
	
	$j('#curSelector dt').click(function(){
		display=$j("#curSelector dd").css('display');
		if(display=='none'){
			$j("#curSelector dd").show();
		}else if(display=='block'){
			$j("#curSelector dd").hide();
		}
	})
	 document.onclick = function (event)  
	    {     
		 if($j("#curSelector dd").css('display')=='block'){
			 var e = event || window.event;  
		     var elem = e.srcElement||e.target;  
		     while(elem)  
		        {   
		    	 if(elem.id == "curSelectorDd"||elem.id == "curSelectorDt")  
		            {  
		                    return true;  
		            }  
		    	 elem = elem.parentNode; 
		        }  
				 $j("#curSelector dd").hide();
			   
		 }
		 

	    }  
}
/*customer edit avatar*/
function modify_user_photo(lang){
	var bodyHeight=$j(document).height();
	var sHeight = $j(document).scrollTop();
	var wHeight=$j(window).height();
	var lang = $j("#c_lan").val();
	switch(lang){
		case 'english': lang = 'en'; break;
		case 'german': lang = 'de'; break;
		case 'russian': lang = 'ru'; break;
		case 'french': lang = 'fr'; break;
		default:
			lang = 'en';
	}
	$j("body").append("<div class='DetBgW'></div>");
	$j(".DetBgW").css({"height":bodyHeight,"opacity":0.35});
	news_err="<div class='avatar_upload_div'>";
	news_err+="<div style='text-align:right'><img  id='close_error' src='includes/templates/cherry_zen/images/error_tips.gif' style='cursor:pointer'></div>";
	news_err+="<div style=''><iframe src='"+lang+"/upload_avatar.php' frameborder=0  width=800 scrolling='no'></iframe></div>";
	news_err+="</div>";
	$j("body").append(news_err);
	rHeight=$j(".avatar_upload_div").height()+30;
	var box_top=sHeight+(wHeight-rHeight)/2;
	if(wHeight<rHeight){
		box_top=sHeight;
	}
	rWidth=$j(".avatar_upload_div").width()+30;
	var box_left=(1020-rWidth)/2;
	$j(".avatar_upload_div").css({"top":box_top, "left":box_left});
	$j(".avatar_upload_div iframe").height($j(".avatar_upload_div").height()-10);
	$j(".DetBgW").fadeIn();
	$j(".avatar_upload_div").show();
	$j("#close_error").click(function(){
		$j(".DetBgW").fadeOut(200,function(){
			  $j(this).remove();
		});
		$j(".avatar_upload_div").fadeOut(200,function(){
			 $j(this).remove();
		});
		$j.post('./'+lang+'/update_user_avatar.php','',function(data){
			$j('#show_user_avatar_img img').attr('src',data);
			$j('.headportrait img').attr('src',data);
		})
	});
}

function checkSearchForm(text){
	var inputtext = $j.trim($j('#searchinput').val());
	inputtext = inputtext.replace(/(^\s*)|(\s*$)/g, "");
    inputtext = inputtext.replace(/&/g, "");
	if(inputtext == '' || inputtext == text){
		alert($lang.ErrorPleaseKeyword);
		return false;
	}
	$j('#searchinput').val(inputtext);
	return true;
}
function check_email(str){
	strRegex = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}