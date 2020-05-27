$(function(){
	var $move_body = $("#move_body");
	$("#clicklcPopup").on("click", function(){
		$move_body.hide();
		$("#lcPopup").show();
		$("body,html").animate({scrollTop:0}, 500);
	});
	$("#lcPopup #closelcPopup").on("click", function(){
		$("#lcPopup").hide();
		$move_body.show();
	});

	$(document).on('click', '.viewHere', function(){
		var obj = $(this);
		$(".hideThisLi").show();
		obj.parent().remove();
	});
});