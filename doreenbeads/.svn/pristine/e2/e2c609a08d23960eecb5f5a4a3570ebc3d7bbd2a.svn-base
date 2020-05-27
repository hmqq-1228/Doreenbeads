$(function(){
	//customer review
	var reviewlevel = js_lang.reviewlevel;
    var star = $("#review span");
    var a = "greystar";
    var b = "goldstar";
    curvalue = -1; //鼠标离开的时候
	star.each(function(index){
		$(star[index]).click(function(){
			curvalue=index;
			$("#review input").attr("value",index+1);
			full(index);
		});
	});
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
    
	$("#review-text").val(js_lang.ReviewTips);	
    $("#review-text").blur(function(){
		if($(this).val() == '') {
			$(this).val(js_lang.ReviewTips);
		}
	});
    $("#review-text").focus(function(){
		if($(this).val() == js_lang.ReviewTips){
			$(this).val('');
			$("#review-text").css("background","#fff");
			$("#review-text").css("color","#959595");
		}
	});	
	
	$("#review-text").keyup(function(){
		if($(this).val() == js_lang.ReviewTips){
			$(this).val('');
		}else{
			$("#review-text").css("color","#333");
			if($(this).val().length>1000){
				$(this).val($(this).val().substr(0,1000));
			}
			$('#remaintext').text(1000-($(this).val().length));
			
		}
	});
	
	var reviewchecking = function(){
		var checking = true;
		var starval = $.trim($("#review input").val());
		var reviewname = $.trim($("#review-text").val()); 
		if(starval == ""){
		    $("#review label").text(js_lang.ChooseRating);	
			$("#review label").css("color","#c50000").css("font-weight","normal");
			checking = false;
		}else{
			$("#review label").text("");	
		}		
        if(reviewname == "" || reviewname == js_lang.ReviewTips ){
		    $("#review-text").css("background","#fffdea").css("color","#c70006");
			checking = false;
		}	
		return checking;
	};

	$("#reviewsubmit").click(function(){
		if(!reviewchecking()) {
			return false;
		}
	});
});