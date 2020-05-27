$j(function(){  
	$j(".trends_side .list .more").click(function(){
		var li = $j(this).clone(true);
		$j(this).fadeOut("fast");
		$j(this).siblings(".hidden_date").each(function(i,eledom){
			$j(eledom).attr("class","show_date");
			if(i >= 4){
				return false;
			}
		});
		$j(this).remove();
		if($j(".trends_side .list").find(".hidden_date").length > 0){
			$j(".trends_side .list .show_date:last").after(li).fadeIn("slow");
		}
	});
	
});

function showSubscribe(lang,error,first,last,email){
	
	var $entry_email=document.getElementById("newsletter_bot_input").value;
		
		check_format = isEmail($entry_email);
		
		if(!check_format){
			show_error(lang,error);
		}else{
			show_right_div(lang,first,last,email);
		}
	}
function isEmail(str){
	strRegex = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
	var re = new RegExp(strRegex);
	return !(str.match(re) == null);
}


function show_error(lang,error){
	var bodyHeight=$j(document).height();
	var sHeight = $j(document).scrollTop();
	var wHeight=$j(window).height();
	var box_top=sHeight+(wHeight-145)/2;
	$j("body").append("<div class='DetBgW'></div>");
	$j(".DetBgW").css({"opacity":0.35});
	news_err="<div class='news_error'>";
	
	news_err+="<table width='100%' cellspacing='15px'><tr><td height='40px'>"+error+"</td></tr>"
	     +"<tr><td align='right' valign='bottom'><div id='close_error'><img src='includes/templates/cherry_zen/buttons/"+lang+"/subscribe_close.gif'></div></td></tr></table>";
	news_err+="</div>";
	$j("body").append(news_err);
	rWidth=$j(".news_error").width()+30;
	var box_left=(1020-rWidth)/2;
	//$j(".news_error").css({ "left":box_left});
	$j(".DetBgW").fadeIn();
	$j(".news_error").show();
	$j("#close_error").click(function(){
		$j(".DetBgW").fadeOut(200,function(){
			  $j(this).remove();
		});
		$j(".news_error").fadeOut(200,function(){
			 $j(this).remove();
		});
	});
	}
function show_right_div(lang,first,last,email){
	var bodyHeight=$j(document).height();
	var sHeight = $j(document).scrollTop();
	var wHeight=$j(window).height();
	var input=$j("#newsletter_bot_input").val();
	$j("body").append("<div class='DetBgW'></div>");
	
	$j(".DetBgW").css({"opacity":0.35});
	news_err="<div class='news_right_div'>";
	news_err+="<div style='text-align:right'><img  id='close_error' src='includes/templates/cherry_zen/images/error_tips.gif' style='cursor:pointer'></div>";
	news_err+="<table width='100%' cellspacing='15'><tr><td><font style='color:red'>*</font> "+first+"</td><td><input type='text' id='subscibe_first_name'></td></tr>"+"<tr><td><font style='color:red'>*</font> "+email+"</td><td><input type='text' value='"+input+"' id='subscibe_email'></td></tr>"
	     +"</table>";
	news_err+='<div style="text-align:center;color:#ff0000;padding-bottom:20px;" id="input_error_info"></div>';
	news_err+="<div style='text-align:right;padding-right:50px;'><img style='cursor:pointer' onclick='checkSubcribe(\""+lang+"\")' id='subscribe_show_image'  src='includes/templates/cherry_zen/buttons/"+lang+"/subscribe_sub.png'></div>"
	news_err+="</div>";
	$j("body").append(news_err);
	rHeight=$j(".news_right_div").height()+30;
	var box_top=sHeight+(wHeight-rHeight)/2;
	rWidth=$j(".news_right_div").width()+30;
	var box_left=(1020-rWidth)/2;
	//$j(".news_right_div").css({"top":box_top, "left":box_left});
	$j(".DetBgW").fadeIn();
	$j(".news_right_div").show();
	$j('.news_right_div table tr td input').focus(function(){
		$j(this).css('border','1px solid #7F9DB9');
	})
	$j("#close_error").click(function(){
		$j(".DetBgW").fadeOut(200,function(){
			  $j(this).remove();
		});
		$j(".news_right_div").fadeOut(200,function(){
			 $j(this).remove();
		});
	});
	}

function checkSubcribe(lang){
	//var first=$j("#subscibe_first_name").val();
	var email=$j('#newsletter_bot_input').val();
	//console.log(email);
	check_format = isEmail(email);
	/*if(first==''){
		$j("#subscibe_first_name").css('border','1px solid #ff0000');	
		return false;
	}else */if(email==''||!check_format){
		$j("#subscibe_email").css('border','1px solid #ff0000');
		return false;
	}else{
		//var last=$j("#subscibe_last_name").val();
		var last='';
		$j('#subscribe_show_image').attr('src','includes/templates/cherry_zen/images/loading_waiter.gif');
		$j.post('./subscribe.php',{email:""+email+""},function(data){
			var return_info = process_json(data);
			if (!return_info.error) {
				$j('#input_error_info').html($lang.TEXT_SUBSCRIBR_SUCCESS).show();
			}else{
				$j('#input_error_info').html(return_info.error_message).show();
			}
			setTimeout(subscribe_close(),3000);
		})
		
	}
	
}
function subscribe_close(){
	$j(".DetBgW").fadeOut(1000,function(){
		  $j(this).remove();
	});
	$j(".news_right_div").fadeOut(1000,function(){
		 $j(this).remove();
	});
}