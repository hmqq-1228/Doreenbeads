

$(document).ready(function(){
	

	if(location.hash=='#myaccountemail'){
		$(".email + ul").css('display','block');
	}else if(location.hash=='#myaccountsetting'){

		$(".setting + ul").css('display','block');
	}else if(location.hash == '#myaccountcoupon'){
	
		$(".coupon + ul").css('display','block');
	}
	
});
