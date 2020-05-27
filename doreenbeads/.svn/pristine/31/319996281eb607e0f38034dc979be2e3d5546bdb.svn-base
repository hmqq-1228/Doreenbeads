<p><style type="text/css">
.container, .container img{
	width:660px; 
	height:220px;
	overflow:hidden;
	position:relative;
}
.container ul, .container li{
	list-style:none; /* inherit:upper-roman:§Õ;square: ;circle??*/
	margin:0;
	padding:0;
}
#idSlider li{
	position:absolute;
}
.numsolider{
	position:relative;
	bottom:0px; 
	font:12px/1.5 tahoma, arial; 
	height:18px;

}
#idnumsolider{
  padding:0px;
border:1px solid #d7d7d7;
margin:2px 0px 0px 0px;
height:20px;
line-height:20px;
background-color:#EFEDEE;
}

.numsolider li{
	overflow:hidden;
	float: left;
	color: #000;
	text-align: center;
	font-family: Arial;
	font-size: 12px;
	cursor: pointer;
	height:20px;
	line-height:20px;
}

.numsolider li a{
display: block;
border-left:1px solid #DDDBDC;
color:#9A9898;
text-decoration:none;
}
.numsolider li:first-child a{
	border-left:0px solid #000;
}
.numsolider li.on{
	background-color:#FCFCFC;
	font-weight: bold;
	color:#333333;
}
.numsolider li.on a{
	color:#333333;
}
</style> <script type="text/javascript"> 
$j(document).ready(function(){ 
	var t = n = 0, count;
	var time = 5000;//图片切换时间
	var time1 = 1000;//图片淡入淡出时间
	$j('#idnumsolider').html('');
	count=$j("#idSlider li").length;
	idSlider_li_width=Math.floor($j('#idContainer').width()/count);
	$j('#idnumsolider').css('width',(idSlider_li_width*count));
	$j("#idSlider li").each(function(){
		ahref=$j(this).find("a").attr('href');
		words=$j(this).find("img").attr('alt');
		num=$j("#idSlider li").index(this)+1;
		if(!words){
			words='输入第'+num+'张图片的alt文字';
			}
		$j("#idnumsolider").append("<li style='width:"+idSlider_li_width+"px'><a href='"+ahref+"'>"+words+"</a></li>");
	})
	$j("#idSlider li:not(:first-child)").hide(); 
	$j("#idnumsolider li:first-child").addClass("on");
	$j("#idnumsolider li").hover(function() {
		clearInterval(t);
		var i = $j("#idnumsolider li").index(this) ;
		if(n == i) return false;
		n = i; 
		if (i >= count) return;
		$j("#idSlider li").stop(true,true); 
		$j("#idSlider li").filter(":visible").fadeOut(time1).parent().children().eq(i).fadeIn(time1); 
		$j(this).stop(true,true).addClass("on").siblings().removeClass("on"); 
		
	},function(){
		t = setInterval(showAuto, time);
		});
	t = setInterval(showAuto, time); 
	$j('#idContainer').hover(function(){clearInterval(t)}, function(){t = setInterval(showAuto, time);}); 
	
	function showAuto() {
		n = n >=(count - 1) ? 0 : ++n;
		$j("#idSlider li").filter(":visible").fadeOut(time1).parent().children().eq(n).fadeIn(time1); 
		$j("#idnumsolider li").eq(n).addClass("on").siblings().removeClass("on");
	} 
}) 
</script></p>
<center>
<div id="idContainer" class="container">
<ul id="idSlider">
    <li><a href="http://www.8seasons.com/pendants-cabochon-setting-pendants-c-44_321_746.html?p=Homepage=Slide=CabochonPendants=20130307"><img alt="Cabochon Pendants" src="http://www.8seasons.com/promotion_photo/en/images/20130307/cabochonset0307.jpg" /> </a></li>
    <li><a href="http://www.8seasons.com/beads-seed-beads-c-44_43_246.html?p=Homepage=Slide=Seedbead=20130306"><img alt="Seed Beads" src="http://www.8seasons.com/promotion_photo/en/images/20130306/seedbeads0306.jpg" /></a></li>
    <li><a href="http://www.8seasons.com/featured-categories-easter-charms-findings-c-691_187.html?p=Homepage=Slide4=Easter=20130225"><img alt="Easter Charms" src="http://www.8seasons.com/images/market_images/marketing/english/EasterCharms0225.jpg" /></a></li>
    <li><a href="http://www.8seasons.com/shop-by-subject-religious-charms-findings-c-339_157.html?p=Homepage=Slide1=Religious=20130222"><img src="http://www.8seasons.com/images/market_images/marketing/english/Religious0220.jpg" alt="Religious Findings" /></a></li>
    
</ul>
</div>
<ul id="idnumsolider" class="numsolider">&nbsp;</ul>
    </center>