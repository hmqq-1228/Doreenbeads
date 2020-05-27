/**
 * 图片懒加载
 * @author yifei.wang
 * @version DB 3.8.9
 */
if ($ === undefined) {
    $ = $j;
}
$(function () {
    // 调用预加载函数
    lazyload($('.lazy-img'), 600);
    // 监听购物车的变化，如果购物车发生变化，调用预加载函数进行图片处理
    $('.shopping_cart_main_content').bind('DOMNodeInserted', function () {
        lazyload($(this).find('.lazy-img'));
    });
});

/**
 * 对图片进行预加载并且在无法加载到正确的图片时使用一张failed图片占位
 * @param lazy 要处理的对象集合
 * @param isFadeIn fadeIn的动效速度(ms)，如果不使用，不传值或者是传入false、null等值
 */
function lazyload (lazy, isFadeIn) {
    // 循环需要处理的图片元素
    for (var i = 0, n = lazy.length; i < n; i++) {
        // 创建一个Image类用来模拟img标签
        var imgObj = new Image();
        // 将想要加载的图片链接写入Image
        imgObj.src = lazy[i].dataset.lazyload;
        // 使用Image的data-effect属性保存isFadeIn参数信息
        imgObj.dataset.effect = isFadeIn ? isFadeIn : '';
        // 注册图片加载成功事件
        imgObj.onload = function () {
        	var imginfo = this;
            // 获取页面上所有data-lazyload为该链接的img标签
            var img = $(".lazy-img[data-lazyload*='"+ decodeURIComponent(imginfo.src.replace(location.origin + '/', '').replace(/%20/g, ' ') ) + "']");
            // 将img标签的src替换成该图片的链接
            
            img.each(function(){
            	$(this).attr('src', decodeURIComponent(imginfo.src));
            	
            	// 判断Image的data-effect的值
            	 if (imginfo.dataset.effect) {
                 	if(this.dataset.display != 'undefined'){
                 		$(this).css('display', this.dataset.display);
                     }else{
                 		// 如果data-effect的布尔值为真，设置fadeIn动效
                     	$(this).hide().fadeIn(parseInt(imginfo.dataset.effect));
                 	}
                 }
            });
            
        };
        // 注册图片加载错误事件
        imgObj.onerror = function () {
        	var imginfo = this;
        	
            // 获取所有data-lazyload等于该图片路径的img标签
        	var img = $(".lazy-img[data-lazyload*='"+ decodeURIComponent(imginfo.src.replace(location.origin + '/', '').replace(/%20/g, ' ')) + "']");
            
            // 循环img符合条件的img标签
            img.each(function(){
            	// 声明failed图片的链接
                var src = location.protocol + '//' + document.domain + '/includes/templates/cherry_zen/images/failed/'+ imginfo.dataset.size+'.gif';
                // 将img标签的src替换成该图片的链接
                $(this).attr('src', src);
                // 判断Image的data-effect的值
	            if (imginfo.dataset.effect) {
	            	if(this.dataset.display != 'undefined'){
	            		$(this).css('display', this.dataset.display);
	                }else{
	            		// 如果data-effect的布尔值为真，设置fadeIn动效
	                    $(this).hide().fadeIn(parseInt(imginfo.dataset.effect));
	            	}
	            }
            });
        };
    }
}
// End