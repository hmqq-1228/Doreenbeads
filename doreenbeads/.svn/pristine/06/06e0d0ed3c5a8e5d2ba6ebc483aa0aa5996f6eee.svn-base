<style>
.popup_wrap{ display:none; position:fixed; left:50%; top:50%; overflow:hidden; background:#fff; border:#ccc 1px solid; z-index:99999; box-shadow:0px 3px 3px #aaa; webkit-box-shadow:0px 3px 3px #aaa;/*webkit*/ -moz-box-shadow:0px 3px 3px #aaa;/*Firefox*/}
.pop_stw{ width:460px; border-radius: 8px; margin:-200px 0 0 -250px;padding:10px 10px 28px 10px;}
.pop_stw .close1{ background-image:url(https://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/close_f0801.png); width:16px; height:16px; float:right; display:block;}
.pop_stw .spinPopupCont{ padding: 25px 25px 0px; /*text-align:center;*/font-size:17px;}
a.stw_btn{font-family:Arial, Helvetica, sans-serif;display:inline-block;font-size:14px;background:#c25fde;box-shadow:0 1px 0 0 #cd83e6 inset, 0 0 0 1px #bc75d3 inset;background:-moz-linear-gradient(top,#c26ede,#b260cd);background:-webkit-linear-gradient(top,#c26ede,#b260cd);border-radius:3px;border:1px solid #915a9e;color:#fff;padding:4px 15px !important;margin:18px auto 10px 12px;text-align:center;font-weight:bold;cursor:pointer;} 
a.stw_btn:focus{background:#c25fde;background:-moz-linear-gradient(top,#c26ede,#b260cd);background:-webkit-linear-gradient(top,#c26ede,#b260cd);}
a.stw_btn:hover{color:#FFF;text-decoration:none}
a.stw_btn:link{color:#FFF;text-decoration:none}
a.stw_btn:visited{color:#FFF;text-decoration:none}
.pop_stw span{color:#f80000;}
</style>

<?php
if($error){
	echo '<div class="content">'.$error_msg.'</div>';
}else{
	require($define_facebook_like);
?>
<input type="hidden" id="spinLotteryTimes" value="<?php echo $lotteryTimes[1]; ?>" />
<input type="hidden" id="spinCanTimes" value="<?php echo $lotteryTimes[0]; ?>" />
<div class="popup_wrap pop_stw" id="spinPopup">
	<a href="javascript:void(0)" id="spinCloseWindow" class="close1"></a>
	<div class="spinPopupCont" id="spinPopupCont"></div>
	<div class="clearfix"></div>
</div>

<script type="text/javascript" src="includes/templates/cherry_zen/jscript/jQueryRotate.2.2.js"></script>
<!--<script type="text/javascript" src="includes/templates/cherry_zen/jscript/jquery.easing.min.js"></script>-->
<script type="text/javascript">
$j(function(){

var $spinStartBtn = $j("#spinStartBtn"),
	$spinRotate = $j("#spinRotate"),
	$spinLotteryTimes = $j("#spinLotteryTimes"),
	$spinCanTimes = $j("#spinCanTimes"),
	isLogin = $j('.isLogin').val();

$spinStartBtn.click(function() {
	if(isLogin == 'yes'){
		if($spinStartBtn.hasClass("processing")) return false;
		if($spinLotteryTimes.val() >= $spinCanTimes.val()){
			if($spinCanTimes.val() < 2){
				stw_showTips('<?php echo TEXT_SPIN_OUTOF_CHANCES2; ?>');
			}else{
				stw_showTips('<?php echo TEXT_SPIN_OUTOF_CHANCES; ?>');
			}
		}else{
			stw_lottery();
		}
	}else{
		show_login_div('spin_to_win.html');
	}
});

var stw_lottery = function() {
	$spinStartBtn.addClass("processing");
	$j.ajax({
		type: 'POST',
		url: 'spin_to_win.html?action=lottery',
		data: {authCode:'<?php echo $authCode; ?>'},
		dataType: 'json',
		cache: false,
		error: function() {
			stw_showTips('System Error!');
			$spinStartBtn.removeClass("processing");
			return false;
		},
		success: function(json) {
			if(!json.success){
				stw_showTips(json.msg);
				$spinStartBtn.removeClass("processing");
				return false;
			}
			var angle = json.angle,
				prize = json.prize,
				times = json.times;
			//$spinStartBtn.rotate({
			//$j("#spinPointer").rotate({
			$spinRotate.rotate({
				duration: 5000,
				angle: 0,
				animateTo: 1440 + angle,
				//easing: $j.easing.easeInOutSine,
				callback: function() {
					$spinStartBtn.removeClass("processing");
					$spinLotteryTimes.val(times);
					stw_showTips(json.msg);
					if(typeof json.cartcount != 'undefined'){
						$j("#count_cart").html(json.cartcount);
						var $addcart = $j(".cartcontent .addcart");
						if($addcart.hasClass("hasnoitem")){
							$addcart.removeClass("hasnoitem").addClass("hasitem");
						}
					}
				}
			});
		}
	});
}

});

function stw_showTips(h){
	$j('.windowbody').height($j(document).height()+'px').fadeIn();
	$j("#spinPopupCont").html(h);
	$j('#spinPopup').fadeIn();
	$j('#spinPopup #spinCloseWindow, .windowbody').click(function(){
		$j('#spinPopup, .windowbody').fadeOut();
		return false;
	});
}

window.fbSharePluginInit = function() {
	FB.init({
		appId      : '<?php echo FACEBOOK_CONF_APPID; ?>',
		xfbml      : true,
		version    : 'v2.4'
	});
	FB.ui({
		method: 'share',
		href:'<?php echo SPINTOWIN_SHARE_LINK; ?>'
	}, function(response){
		if(typeof response != 'undefined'){
			//console.log(response);
			if(typeof response.error_code == 'undefined'){
				$j('#spinPopup, .windowbody').fadeOut();
				$j.ajax({
					type: 'POST',
					url: 'spin_to_win.html?action=share',
					data: {authCode:'<?php echo $authCode; ?>'},
					dataType: 'json',
					cache: false,
					error: function() {
						stw_showTips('System Error!');
						return false;
					},
					success: function(json) {
						if(!json.success){
							stw_showTips(json.msg);
							return false;
						}
						$j("#spinCanTimes").val(2);
					}
				});
			}
		}
	});
};
(function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) return;
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/es_LA/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
}
?>