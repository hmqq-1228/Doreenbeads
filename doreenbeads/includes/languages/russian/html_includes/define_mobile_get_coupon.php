{literal}
<style type="text/css">
	.wrap-page{width: 100%;height: 100%;flex-grow: 1;overflow: auto;max-width: 640px;margin: 0 auto; -webkit-overflow-scrolling: touch;}
	.coupon2018{padding-top:44px; width:100%;margin: 0 auto;background:url(https://img.doreenbeads.com/promotion_photo/ru/images/20180704/discount_bg.gif) repeat-y;font-family: arial;}
	.coupon2018 img{border: 0;display:inline-block;margin:0;padding:0;width: 100%; vertical-align:bottom;}
	.coupon2018 p{ text-align:center; padding:3% 0 4%;}
	.coupon2018 p img{ width:65%;}
	.ny_discount{display: block;}
	.coupon2018 ol,.coupon2018 h2{margin: 0;padding:0;}
	.coupon2018 h2{font-weight: normal;}
	.ny_warning{color:#333; border:#d2d2d2 2px solid; margin:0 4% 4%; padding:20px;}
	.ny_warning h2{font-size: 20px;margin-bottom: 10px;}
	.ny_warning ol{font-size: 16px; list-style: decimal; list-style-position:outside; padding-left:20px;}
	.ny_warning li{line-height: 18px; padding-bottom:8px;}
	.ny_warning li span{color:#e94c1f;}
	.ny_warning li a{ text-decoration:none; color:#cf42e8;}
</style>
{/literal}
<div class="wrap-page">
	<div class="coupon2018">
		<img src="https://img.doreenbeads.com/promotion_photo/ru/images/20180704/banner.gif" />
		<div class="ny_discount">
			<img src="https://img.doreenbeads.com/promotion_photo/ru/images/20180704/discount_1.gif" />
			<img src="https://img.doreenbeads.com/promotion_photo/ru/images/20180704/discount_2.gif" />
		</div>
		<p><a><img class="jq_get_coupon" data-code="CP2018071002,CP2018071005,CP2018071010,CP2018071015" src="https://img.doreenbeads.com/promotion_photo/ru/images/20180704/btn_{if $array_coupon_active.CP2018071002 == 0}02{else}01{/if}.gif" border="0"></a></p>
		<div class="ny_warning">
			<h2>Теплое уведомление:</h2>
			<ol>
				<li>Вы можете бесплатно получать купоны до<span> 24 июля </span>, просто нажав кнопку «<span>Получить все купоны</span>».</li>
        <li>Получаемый вами купонный доход действителен в течение 1 месяца.</li>
        <li>Дисконтные товары также имеют право на купоны.</li>
        <li>Купоны можно взять только один раз за покупателя.</li>
   			<li>Когда ваша квалифицированная покупка достигает определенной  суммы, вы можете использовать  купоны. </li>
				<li>Пожалуйста, свяжитесь с нами  по любым вопросам.</li>
			</ol>
		</div>
	</div>
</div>
{literal}
<script language="javascript">
$(function() {
	$(".coupon2018").on("click", ".jq_get_coupon", function(e){
		var code = $(this).data("code");
		var thisObj = $(this);
		
		$.post("./ajax/ajax_send_coupon.php", {action: 'send_coupon', coupon: code},function(data){
			if(data.length >0) {
				if(typeof(JSON)=='undefined'){
					var returnInfo=eval('('+data+')');
				}else{
					var returnInfo=JSON.parse(data);	
				}
				if(returnInfo.error == 0) {
					thisObj.attr("src", thisObj.attr("src").replace("_01.gif", "_02.gif"));
					alert(returnInfo.message_mobile);
				} else {
					if(returnInfo.error_code != 'login') {
						alert(returnInfo.message_mobile);
					} else {
						window.location.href="index.php?main_page=login";
					}
				}
			}
		});	
	});
});
</script>
{/literal} 
