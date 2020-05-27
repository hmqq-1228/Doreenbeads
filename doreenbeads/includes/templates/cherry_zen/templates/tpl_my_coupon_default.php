<div class="mycashaccount">
<?php
	if ($messageStack->size('my_coupon') > 0) {
		echo $messageStack->output('my_coupon');
	}
?>
	<p class="mycashtit"><strong><?php echo TEXT_MY_COUPON;?></strong></p>

	<!-- add coupon -->
<style>
.couponcont{height:auto;margin:10px 0;}
.couponform{float:right;}
.couponform .couponform-input{width:265px;height:23px;border:1px solid #bcbcbc;box-shadow:0px 1px 1px #bebebe inset;border-top:1px solid #787878;font-family:Arial, Helvetica, sans-serif;font-size:13px;}
.couponform .couponform-btn{height:28px;font-size:12px;font-family:Arial, Helvetica, sans-serif;}
.couponform #add_coupon_tip{color:red;}
</style>
<form action="index.php?main_page=my_coupon" method ="post" onsubmit="return doAddCoupon();">
<input type="hidden" name="action" value="add_coupon">
<div class="couponform" style="float: left;">
	<input type="text" class="couponform-input" id="add_coupon_code" name="add_coupon_code" value="<?php echo TEXT_ENTER_A_COUPON_CODE; ?>" />
	<input type="submit" class="couponform-btn" value="<?php echo TEXT_ADD_COUPON; ?>" /> <a class="couponterm" href="<?php echo HTTP_SERVER;?>/page.html?id=192"><?php echo TEXT_COUPON_TERMS;?></a>
	<p id="add_coupon_tip"></p>
</div>
</form>
<div class="clearfix"></div>
	<ul class="coupontab">
		<li class="on"><?php echo TEXT_ACTIVE_COUPONS;?></li>
		<li><?php echo TEXT_INACTIVE_COUPONS;?></li>
	</ul>

	<div class="coupondiv">
		<table class="coupontable coupontable-one sh" width="100%">
<?php
	echo $active_coupon_str;		//	contain '</table>'
?>
	</div>

	<div class="coupondiv">
		<table class="coupontable coupontable-two">
<?php
	echo $inactive_coupon_str;
?>
	</div>
</div>

<script>
$(function() { 
	$('.coupondiv').eq(1).hide();
});
<!--
$j(document).ready(function(){
	$j('.coupontab li').each(function(index){
		$j(this).click(function(){
			if(! $j(this).hasClass('on')){
				$j('.coupontab li.on').removeClass('on');
				$j(this).addClass('on');
				$j('.coupondiv').hide().eq(index).show();
				$j('.coupontable.sh').removeClass('sh');
				$j('.coupontable').eq(index).addClass('sh');
			}
		})
	})
	$j('.coupondiv .spilttd a').live('click',function(){
		if(! $j(this).hasClass('current')){
			var page = $j(this).attr('pageid');
			if($j(this).parents('div').hasClass('active')){
				target = 'active';
			}else{
				target = 'inactive';
			}
			$j.post('<?php echo zen_href_link(FILENAME_MY_COUPON)?>',{target:target,cpage:page},function(data){
				if(target == 'active'){
					$j('.coupondiv').eq(0).html('<table class="coupontable coupontable-one sh" width="100%">'+data);
				}else{
					$j('.coupondiv').eq(1).html('<table class="coupontable coupontable-two sh">'+data);
				}
			})
		}
	})
	$j('.coupon-deadlineicon').hover(function(){
		$j(this).next('.coupon-deadline').addClass('sh');
	},function(){
		$j(this).next('.coupon-deadline').removeClass('sh');
	})

	$j("#add_coupon_code").focus(function(){
		var v = $j.trim($j(this).val());
		if(v == '<?php echo TEXT_ENTER_A_COUPON_CODE; ?>') {
			$j(this).val('');
		}
	}).blur(function(){
		var v = $j.trim($j(this).val());
		if(v == ''){
			$j(this).val('<?php echo TEXT_ENTER_A_COUPON_CODE; ?>');
		}
	})
})

function doAddCoupon(){
	var code = $j.trim($j("#add_coupon_code").val());
	if(code == '' || code == '<?php echo TEXT_ENTER_A_COUPON_CODE; ?>'){
		$j('#add_coupon_tip').html("<?php echo TEXT_ENTER_A_COUPON_CODE; ?>").show();
		return false;
	}
	return true;
}
-->
</script>