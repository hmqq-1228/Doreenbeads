<script>
function answer_appear(x){
var idNameArr=x.id.split('_');
var ansId="faq_ans"+"_"+idNameArr[2];
var ansImg="faq_img"+"_"+idNameArr[2];
var idAttr=document.getElementById(ansId);
var imgAttr=document.getElementById(ansImg);
if(idAttr.style.display=='none'){
	idAttr.style.display='block';
	imgAttr.src="http://www.8seasons.com/images/market_images/marketing/faq_disappear1.gif";
	x.title="hide the answer";
}else{
	idAttr.style.display='none';
	imgAttr.src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif";
	x.title="click here for the answer";
}
}
</script>
<p>
	<style type="text/css">
#FAQ_list_body{
 width:660px;
 float:left;
 border:0px solid #000;
 font-family:Arial, Helvetica, sans-serif;
 font-size:14px;
 }
 #faq_title{
 font-size:16px;
 font-weight:bold;
 margin-left:10px;
 margin-bottom:20px;
 }
 .faq_ques{
 padding-left:20px;
 line-height:22px;
 float:left;
 max-width:600px;
 }
 .faq_img{
 width:22px;
 height:22px;
 float:left;
 margin-left:8px;
 }
 .faq_ans{
 padding-left:20px;
 margin-top:5px;
 	display:none;
	color:#5F5F5F;
 }
.faq_header{
margin-top:5px;
}
 .faq_img img{
width:14px;
height:14px;
margin-top:3px;
}
 .faq_ans table tr{
 border:1px solid #000000;
 border-collapse:collapse;
 text-align:center;
 }
 .faq_null{
 height:1px;
 }
 #faq_back{
 float:right;
 }	</style>
</p>
<div id="FAQ_list_body">
		<div class="faq_header" id="faq_ques_1" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q1:</b> Is there any Terms and Conditions for club members?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_1" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_1" style="display:none;">
		<p style="line-height:20px;">
			<b>A:</b> Yes, please <a href="http://www.8seasonsorg.com/index.php?main_page=help_center&id=268">click here</a> for details.</p>
	</div>
    <div class="faq_header" id="faq_ques_2" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q2:</b>Are all the items on 8seasons.com applicable for free express delivery for Club members?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_2" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_2" style="display:none;">
		<p>
			<b>A:</b> All of the items listed on our web can apply to the club free shipping, but due to the increasing labor cost, you will pay US$ 2.49/kg for warehouse handling and packing fee. When total product price reaches $99, you can enjoy it.</p>
	</div>
	<div class="faq_header" id="faq_ques_3" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q3:</b> Which shipping methods are applicable for the free express delivery?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_3" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_3" style="display:none;">
		<p>
			<b>A:</b> Club members are entitled to free express delivery. Availability of shipping privilege depends on inventory availability and, in some cases, the shipping address.</p>
		<p>
			* The website would assign one or several shipping methods for you according to the weight, size, and address of your parcel, perhaps including the FedEx, UPS, DHL, etc.</p>
		<p>
			* If you would like to use another shipping method instead of what we've chosen for you, we might charge you part of the price difference according to the specific conditions of your parcel.</p>
            <p>
			* If the items you has ordered is out of stock or unavailable to ship, we will get it to you by airmail after it's back in stock.</p>
	</div>
	<div class="faq_header" id="faq_ques_4" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q4:</b>What address is applicable for the free express delivery?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_4" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_4" style="display:none;">
		<p>
			<b>A:</b> This service now is only available to customers whose address belongs to the United States, United Kingdom, Germany, France, Norway, Luxembourg, Japan, Australia, Singapore, Mexico, Slovakia, Puerto Rico, Ireland, Italy, Belgium, Netherlands, Sweden, South Korea, Malaysia, India, Poland, Hungary, Canada, Austria, Spain, Denmark, Switzerland, Finland, Thailand, Philippines, Indonesia, Czech Republic, Portugal and Russia.</p>
		<p>
			* For the remote area, we still need to charge part of Extended Area Surcharge.</p>
		<p>
			* For other countries, customers need to pay shipping fees at normal price.</p>
	</div>
		<div class="faq_header" id="faq_ques_5" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q5:</b> Which kind of shipping method you will use for out of stock items? </div>
		<div class="faq_img">
			<img alt="" id="faq_img_5" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_5" style="display:none;">
		<p style="line-height:20px;">
			<b>A:</b> If the items you ordered was out of stock or unavailable to ship, normally we will get it to you by airmail after its back in stock. If you are prefer to ship them with your next order or do exchange, it is OK too. Just feel free to let us know.</p>
	</div>
    <div class="faq_header" id="faq_ques_6" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q6:</b>I really like your free express delivery service, but I couldn't find some items I need on your 8seasons.com website, what can I do?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_6" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_6" style="display:none;">
		<p style="line-height:20px;">
			<b>A:</b> For the Club members, we offer special <a href="http://www.8seasons.com/page.html?id=9">Product Sourcing Service</a>.We could help you find the items you need, especially for items like jewelry accessories and crafts. Once we found them in the market,We will communicate with you about the price and MOQ,and then customize them for you according to your requirements.</p>
	</div>
	<div class="faq_header" id="faq_ques_7" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q7:</b> How can I sign up for the 8seasons club?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_7" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_7" style="display:none;">
		<p style="line-height:20px;">
			<b>A:</b> 1) Log into your account, you will see the following page, click the "For details" link</p>
		<p>
			<img src="http://img.8seasons.com/promotion_photo/en/images/20140613/8seasons_Club_2.png" /></p>
		<p style="line-height:20px;">
			2) Then you will reach this page, click the "Join 8seasons club"</p>
		<p>
			<img src="http://img.8seasons.com/promotion_photo/en/images/20140613/8seasons-Club-3.png" /></p>
		<p style="line-height:20px;">
			3) You will see as follows, then you could make your payment now</p>
		<p>
			<img src="http://img.8seasons.com/promotion_photo/en/images/20140613/8seasons-Club-4.png" /></p>
		<p style="line-height:20px;">
			Just go ahead and join us. Then you will experience our excellent and thoughtful Club member service, and the best shopping experience you've ever had.</p>
	</div>
    <div class="faq_header" id="faq_ques_8" onclick="answer_appear(this)" title="click here for the answer">
		<div class="faq_ques">
			<b>Q8:</b> Can I cancel my Club membership?</div>
		<div class="faq_img">
			<img alt="" id="faq_img_8" src="http://www.8seasons.com/images/market_images/marketing/faq_appear1.gif" /></div>
	</div>
	<div class="faq_null" style="clear:both;">
		 </div>
	<div class="faq_ans" id="faq_ans_8" style="display:none;">
		<p style="line-height:20px;">
			<b>A:</b>Absolutely. We will refund your full membership fee if you cancel your Club membership before you have made any applicable purchases or used any coupons.  <br />
            * If you need to cancel your Club membership, you just need to contact with your personal customer service manager.</p>
	</div>
</div>
<script>
var from_url_arr=document.URL.split('#');
if(from_url_arr[1]){
var idNameArr=from_url_arr[1].split('_');
var ansId="faq_ans"+"_"+idNameArr[2];
var ansImg="faq_img"+"_"+idNameArr[2];
var idAttr=document.getElementById(ansId);
var imgAttr=document.getElementById(ansImg);
var quesAttr=document.getElementById(from_url_arr[1]);
	idAttr.style.display='block';
	imgAttr.src="http://www.8seasons.com/images/market_images/marketing/faq_disappear1.gif";
	quesAttr="hide the answer";
}
</script>