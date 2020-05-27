$(function() {
 $('.affiliate-bt li').each(function(index){
		$(this).click(function(){
			if(! $(this).hasClass('on')){
				$('.affiliate-bt li.on').removeClass('on');
				$(this).addClass('on');
				$('.affiliate-program').hide().eq(index).show();
				$('.commissiontable.sh').removeClass('sh');
				$('.commissiontable').eq(index).addClass('sh');
			}
		})
	})
});



