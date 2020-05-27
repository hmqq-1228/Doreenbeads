<?php 
require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE));

$products_image_01 = DIR_WS_IMAGES . $products_image_base . '_01' . $products_image_extension;
$products_image_02 = DIR_WS_IMAGES . $products_image_base . '_02' . $products_image_extension;
$img0 = addslashes('<img src="http://img.8seasons.com/bmz_cache/images/' . get_img_size($products_image, 310, 310) . '"  width="110" height="110" />');

$img1 = addslashes('<img src="http://img.8seasons.com/bmz_cache/images/' . get_img_size(str_replace('.','_01.',$products_image), 310, 310) . '"  width="110" height="110" />');

$img2 = addslashes('<img src="http://img.8seasons.com/bmz_cache/images/' . get_img_size(str_replace('.','_02.',$products_image), 310, 310) . '"  width="110" height="110" />');

?>
<div class="prodcutPageprImg proImgSizeB" id="porductInfoPrImage">
	<div class="canvas" id="canvas">
		<div class="slider" id="slider">
	  		<ul></ul>
		</div>
		<nav class="nav" id="nav">
			<a class="back textbtn" id="back">&lt;&nbsp;Back</a>
			<a class="bigImg" id="bigImg"></a>
			<em class="page" id="page">1/3</em> 
			<em onclick="slider.prev();" class="prev" id="prev"></em> 
			<em onclick="slider.next();" class="next" id="next"></em>
		</nav>
	</div>
</div>

<script type="text/javascript">
window.Swipe = function(element, options) {
	if (!element) return null;
	var _this = this;
	this.options = options || {};
	this.index = this.options.startSlide || 0;
	this.speed = this.options.speed || 300;
	this.callback = this.options.callback || function() {};
	this.delay = this.options.auto || 0;
	this.container = element;
	this.page = this.options.page;
	this.bigImg = this.options.bigImg;
	this.element = this.container.children[0];
	this.container.style.overflow = 'hidden';
	this.element.style.listStyle = 'none';
	this.scroll = this.options.scroll || false;
	this.image = this.options.image;
	this.init();
	this.setup();
	this.begin();
	if (this.element.addEventListener) {
		this.element.addEventListener('touchstart', this, false);
		this.element.addEventListener('touchmove', this, false);
		this.element.addEventListener('touchend', this, false);
		this.element.addEventListener('webkitTransitionEnd', this, false);
		this.element.addEventListener('msTransitionEnd', this, false);
		this.element.addEventListener('oTransitionEnd', this, false);
		this.element.addEventListener('transitionend', this, false);
		window.addEventListener('resize', this, false)
	}
};
Swipe.prototype = {
	setup: function() {
		this.slides = this.element.children;
		this.length = this.slides.length;
		if (this.length < 2) return null;
		this.width = this.container.getBoundingClientRect().width;
		if (!this.width) return null;
		this.container.style.visibility = 'hidden';
		this.element.style.width = (this.slides.length * this.width) + 'px';
		var index = this.slides.length;
		while (index--) {
			var el = this.slides[index];
			el.style.width = this.width + 'px';
			el.style.display = 'table-cell';
			el.style.verticalAlign = 'top'
		}
		this.slide(this.index, 0);
		this.container.style.visibility = 'visible'
	},
	slide: function(index, duration) {
		var style = this.element.style;
		this.getWidth();
		style.webkitTransitionDuration = style.MozTransitionDuration = style.msTransitionDuration = style.OTransitionDuration = style.transitionDuration = duration + 'ms';
		style.webkitTransform = 'translate3d(' + -(index * this.width) + 'px,0,0)';
		style.msTransform = style.MozTransform = style.OTransform = 'translateX(' + -(index * this.width) + 'px)';
		this.index = index
	},
	getPos: function() {
		return this.index
	},
	prev: function(delay) {
		this.delay = delay || 0;
		clearTimeout(this.interval);
		if (this.index) this.slide(this.index - 1, this.speed);
		this.showPage()
	},
	next: function(delay) {
		this.delay = delay || 0;
		clearTimeout(this.interval);
		this.imgLoad(this.index + 1);
		if (this.index < this.length - 1) this.slide(this.index + 1, this.speed);
		this.showPage()
	},
	begin: function() {
		var _this = this;
		if (!this.scroll) {
			this.interval = (this.delay) ? setTimeout(function() {
				_this.next(_this.delay)
			},
			this.delay) : 0
		}
	},
	stop: function() {
		this.delay = 0;
		clearTimeout(this.interval)
	},
	resume: function() {
		this.delay = this.options.auto || 0;
		this.begin()
	},
	handleEvent: function(e) {
		switch (e.type) {
		case 'touchstart':
			this.onTouchStart(e);
			break;
		case 'touchmove':
			this.onTouchMove(e);
			break;
		case 'touchend':
			this.onTouchEnd(e);
			break;
		case 'webkitTransitionEnd':
		case 'msTransitionEnd':
		case 'oTransitionEnd':
		case 'transitionend':
			this.transitionEnd(e);
			break;
		case 'resize':
			this.setup();
			break
		}
	},
	transitionEnd: function(e) {
		if (this.delay) this.begin();
		this.callback(e, this.index, this.slides[this.index])
	},
	onTouchStart: function(e) {
		this.start = {
			pageX: e.touches[0].pageX,
			pageY: e.touches[0].pageY,
			time: Number(new Date())
		};
		this.isScrolling = undefined;
		this.deltaX = 0;
		this.element.style.webkitTransitionDuration = 0
	},
	onTouchMove: function(e) {
		if (e.touches.length > 1 || e.scale && e.scale !== 1) return;
		this.deltaX = e.touches[0].pageX - this.start.pageX;
		if (typeof this.isScrolling == 'undefined') {
			this.isScrolling = !!(this.isScrolling || Math.abs(this.deltaX) < Math.abs(e.touches[0].pageY - this.start.pageY))
		}
		if (!this.isScrolling) {
			e.preventDefault();
			this.getWidth();
			clearTimeout(this.interval);
			this.deltaX = this.deltaX / ((!this.index && this.deltaX > 0 || this.index == this.length - 1 && this.deltaX < 0) ? (Math.abs(this.deltaX) / this.width + 1) : 1);
			this.imgLoad(this.index + 1);
			this.element.style.webkitTransform = 'translate3d(' + (this.deltaX - this.index * this.width) + 'px,0,0)'
		}
	},
	onTouchEnd: function(e) {
		this.getWidth();
		var isValidSlide = Number(new Date()) - this.start.time < 250 && Math.abs(this.deltaX) > 20 || Math.abs(this.deltaX) > this.width / 2,
		isPastBounds = !this.index && this.deltaX > 0 || this.index == this.length - 1 && this.deltaX < 0;
		if (!this.isScrolling) {
			this.slide(this.index + (isValidSlide && !isPastBounds ? (this.deltaX < 0 ? 1 : -1) : 0), this.speed)
		}
		this.showPage()
	},
	init: function() {
		var _html = "";
		for (i = 0; i < this.image.length; i++) {
			_html += "<li></li>"
		}
		this.element.innerHTML = _html;
		this.imgLoad(0);
		this.showPage()
	},
	imgLoad: function(n) {
		if (!this.element.getElementsByTagName("li")[n].getAttribute("name")) {
			this.element.getElementsByTagName("li")[n].innerHTML = this.image[n][0];
			if (n < (this.image.length - 1)) this.element.getElementsByTagName("li")[n + 1].innerHTML = this.image[n + 1][0];
			this.element.getElementsByTagName("li")[n].setAttribute("name", this.image[n][1])
		}
	},
	showPage: function() {
		if(this.image.length == 1){
			this.page.style.display = "none";
			document.getElementById("prev").style.display = "none";
			document.getElementById("next").style.display = "none";
		}else{
			this.page.innerHTML = (this.index + 1) + "/" + this.image.length;
			if (this.index == 0) {
				document.getElementById("prev").style.display = "none";
				document.getElementById("next").style.display = "block";
			} else if (this.image.length == 2) {
				document.getElementById("next").style.display = "none";
				document.getElementById("prev").style.display = "block";
			} else if (this.index == (this.image.length - 1)) {
				document.getElementById("next").style.display = "none"
			} else {
				document.getElementById("prev").style.display = "block";
				document.getElementById("next").style.display = "block"
			}
		}
		
	},
	getWidth: function() {
		this.width = this.container.getBoundingClientRect().width
	}
};
if("<?php echo $img1;?>" != '' && "<?php echo $img2;?>" != ''){
	var jsonImages = [["<?php echo $img0;?>","<?php echo addslashes($products_name);?>"],["<?php echo $img1;?>","<?php echo addslashes($products_name);?>"],["<?php echo $img2;?>","<?php echo addslashes($products_name);?>"]];
}else if("<?php echo $img1;?>" == '' && "<?php echo $img2;?>" == ''){
	var jsonImages = [["<?php echo $img0;?>","<?php echo addslashes($products_name);?>"]];
}else{
	if("<?php echo $img1;?>" == ''){
		jsonImages = [["<?php echo $img0;?>","<?php echo addslashes($products_name);?>"],["<?php echo $img2;?>","<?php echo addslashes($products_name);?>"]];
	}
	if("<?php echo $img2;?>" == ''){
		jsonImages = [["<?php echo $img0;?>","<?php echo addslashes($products_name);?>"],["<?php echo $img1;?>","<?php echo addslashes($products_name);?>"]];
	}
}
var noImg = 0;
var slider = new Swipe($('#slider')[0], {
   	auto: 1000,
	image:jsonImages,
	scroll: true,
	page:$('#page')[0],
	bigImg:$('#bigImg')[0],
	callback: function(e, pos) {noImg = pos;}
});

$("#slider").bind("click",showOverlay);
$("#back").bind("click",hideOverlay);

function showOverlay(){
	$("body>section").addClass("sectionCss");
	$("#porductInfoPrImage").prevAll().hide(); 
	$("body").prepend('<div id="boxOverlay"></div>');
	$("#nav a").show();
	$("body").addClass("bodyCss");
	$("#boxOverlay").css({'height':Math.max($("body").height(),pageHeight()),'width':$("body").width()}).show();
	$("#slider").unbind( "click" );
	$("#canvas").addClass("canvasBig");
	sizeAuto(300);
}
function hideOverlay(){
	$("#porductInfoPrImage").prevAll().show();
	$("#boxOverlay").remove();
	$("#nav a").hide(); 
	$("#slider").bind("click",showOverlay);
	$("#canvas").removeClass("canvasBig");
	$("body").removeClass("bodyCss");
	sizeAuto(260);
	return false;
}

function sizeAuto(s){
	$("#slider ul")[0].style.msTransform = $("#slider ul")[0].style.MozTransform = $("#slider ul")[0].style.OTransform = 'translateX(' + -(noImg* s) + 'px)';
	$("#slider ul")[0].style.webkitTransform = 'translate3d(' + -(noImg* s) + 'px,0,0)';
	$("#slider li").css({"width":s});
	$("#slider ul").css({"width":s*jsonImages.length});
}

function pageHeight() {
    if ($.browser.msie) {
        return document.compatMode == "CSS1Compat" ? document.documentElement.clientHeight: document.body.clientHeight
    } else {
        return self.innerHeight
    }
}
$(window).resize(function() {
	$("#boxOverlay").css({'height':Math.max($("body").height(),pageHeight()),'width':$("body").width()});
});

</script>