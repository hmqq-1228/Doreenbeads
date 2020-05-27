// JavaScript Document
$(function() {
		//	lvxiaoyong 1.30
	$j('.list .proimg').each(function(index) {
		$j(this).mouseover(function() {
			var imgurl = $j('.list .proimg img').eq(index).attr("src");
			var newSrc = $j('.list .proimg img').eq(index).attr('data-original');
	    	var oldSrc = imgurl;
			imgurl = imgurl.replace('_130_130', '_500_500');
			imgurl = imgurl.replace('dailydeal_promotion/products_image', 'dailydeal_promotion/products_image_large');

			if(newSrc == oldSrc){
    			$j('.list .maximg img').eq(index).addClass('hasLoadOver');
				$j('.list .maximg').eq(index).removeClass('notLoadNow');
			}else if(! $j('.list .maximg img').eq(index).hasClass('hasLoadOver')){		
				$j('.list .maximg img').eq(index).attr('src',newSrc).load(function(){
					$j(this).addClass('hasLoadOver');
					$j('.list .maximg').eq(index).removeClass('notLoadNow');
				});
			}

			$j('.list .maximg').eq(index).show();
			$j('.list .maximg img').eq(index).attr("src", imgurl);
			$j('.list .maximg').eq(index).css('z-index', $j('.list .maximg').eq(index).css('z-index')+1);
		});
		$j(this).mouseout(function() {
			$j('.list .maximg').eq(index).hide();
		});
	});

	$j('.productimg').each(function(index) {
		// $j('.proimgdetail p img').eq(index).attr("src","images/loading2.gif");
		$j(this).mouseover(function() {
			var imgurl = $j('.productimg img').eq(index).attr("src");
			var newSrc = $j('.productimg img').eq(index).attr('data-original');
	    	var oldSrc = $j('.productimg img').eq(index).attr('src');
			imgurl = imgurl.replace('_130_130', '_500_500');

			if(newSrc == oldSrc){
    			$j('.productItem .proimgdetail p img').eq(index).addClass('hasLoadOver');
				$j('.productItem .proimgdetail p').eq(index).removeClass('notLoadNow');
			}else if(!$j('.productItem .proimgdetail p img').eq(index).hasClass('hasLoadOver')){		
				$j('.productItem .proimgdetail p img').eq(index).attr('src',newSrc).load(function(){
					$j(this).addClass('hasLoadOver');
					$j('.productItem .proimgdetail p').eq(index).removeClass('notLoadNow');
				});
			}

			$j('.proimgdetail').eq(index).show();
			$j('.proimgdetail p img').eq(index).attr("src", imgurl);
		});
		$j(this).mouseout(function() {
			$j('.proimgdetail').eq(index).hide();
		});
	});
	
	$j("img.lazy").lazyload({
		effect:"show",
	    threshold : 400
	});
});

function re_pos(id){
	var box = document.getElementById(id);
	if(null != box){
		var w = parseInt($j('#'+id).css('width'));
		var h = parseInt($j('#'+id).css('height'));
		$j('#'+id).css("left",get_left(w)+"px").css("top",get_top(h)+"px");
//		box.style.left = get_left(w)+"px";
//		box.style.top = get_top(h)+"px";
	}
}
function truebody(){
	  return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
	}
function get_left(w){
	var bw = document.all ? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth;
	w = parseFloat(w);
	return (bw/2-w/2 + (document.body.scrollLeft != 0 ? document.body.scrollLeft : document.documentElement.scrollLeft));
}
function get_top(h){
	var bh = document.all ? Math.min(truebody().scrollHeight, truebody().clientHeight) : Math.min(window.innerHeight);
	h = parseFloat(h);
	return (bh/2-h/2 + (document.body.scrollTop != 0 ? document.body.scrollTop : document.documentElement.scrollTop));
}

//bof image
$(function() {
 	var bodyHeight = $j(document).height()+'px';
	var curIndex = 0;
	$j(".smallimgshow .detailimglist ul li").click(function(){
		$j(".detailimglist ul li.arrownow").removeClass("arrownow");
		$j(this).addClass('arrownow');		
		var cc = $j(this).children("div").children("img").attr("src");
		bigimgshow_src = cc.replace('_80_80', '_310_310').replace('80.gif', '310.gif');
		var jqzoom_img = cc.replace('_80_80', '_500_500').replace('80.gif', '500.gif');
		$j('.bigimgshow img').attr("src", bigimgshow_src);
		$j('.jqzoom').attr("href", jqzoom_img);
	})

	function change(curIndex){
		change_li = $j(".detailimglistup ul li:eq("+curIndex+")");
		cc = change_li.children("div").children("img").attr("src");
		
		if(cc.indexOf('/failed/') == -1){
			lightboximg_src = cc.replace('_80_80', '_500_500');
		}else{
			lightboximg_src = cc.replace('/80.gif', '/500.gif');
		}
		$j('.lightboximg img').attr("src", lightboximg_src);
		re_pos('imglightbox');
		$j(".detailimglistup ul li.arrownow").removeClass("arrownow");
		change_li.addClass('arrownow');
  	}
  	function float_arrow(curIndex){
  		li_num = $j(".detailimglistup ul li").length;
  		lightboximg_width = $j('.lightboximg img').width();
  		lightboximg_height = $j('.lightboximg img').height();
  		arrow_left = Math.floor(lightboximg_width - 0);
  		arrow_top = Math.floor(lightboximg_height / 2);
		$j('.imglightboxcont span.pre, .imglightboxcont span.next').css('top',arrow_top+'px');
		$j('.imglightboxcont span.next').css('left',arrow_left+'px');
  		if(li_num >= 2 && curIndex >= 1){
			$j('.imglightboxcont span.pre').show();
	 	}else{
	 		$j('.imglightboxcont span.pre').hide();
 		}
 		if(li_num >= 2 && curIndex < li_num - 1){
			$j('.imglightboxcont span.next').show();
	 	}else{
	 		$j('.imglightboxcont span.next').hide();
 		}
  	}
	
	//bof onclick change black and show big image
//	$j('.bigimgshow a').click(function(){
//		var imgurl= $j('.bigimgshow a img').attr("src");
//		$j('body').append('<div class="windowbodyp"></div>');
//		lightboximg_src = imgurl.replace('_310_310', '_500_500');
//		lightboximg_src = imgurl.replace('/310.gif', '/500.gif');
//	 	$j('.lightboximg img').attr("src", lightboximg_src);
//	 	re_pos('imglightbox');
//		$j(".windowbodyp").css({"height":bodyHeight});
//   		$j('.windowbodyp').fadeIn();
//	 	$j('.imglightbox').fadeIn();
//	 	
//	 	if(imgurl.indexOf('/failed/') == -1){
//	 		cur_small_image_src = imgurl.replace('_310_310', '_80_80');
//			$j(".detailimglistup ul").css('margin-left', 0);
//			cur_small_image = $j(".detailimglistup ul li div img[src='"+cur_small_image_src+"']");
//			
//			cur_small_image.parent('div').parent('li').addClass('arrownow');
//	 	}else{
//	 		indexli = $j('.smallimgshow .detailimglist .deimglist .arrownow').index();
////	 		cur_small_image_src = imgurl.replace('/310.gif', '/80.gif');
//	 		$j('.detailimglistup ul li:eq'+'(' + indexli + ')').addClass('arrownow');
//	 		
//	 	}
//	 	
//	 	curIndex = $j(".detailimglistup ul li").index($j(".detailimglistup ul li.arrownow"));
//	})


	$j(".imglightboxcont").hover(function(){
		float_arrow(curIndex);
	}, function(){
		$j('.imglightboxcont span.pre').hide();
		$j('.imglightboxcont span.next').hide();
	})
	
	$j(".detailimglistup ul li").click(function(){
		curIndex = $j(".detailimglistup ul li").index($j(this));
		change(curIndex);
	})
	
	$j('.imglightboxcont span.pre').click(function(){
		curIndex = curIndex - 1;
		change(curIndex);
		float_arrow(curIndex)
	});
	$j('.imglightboxcont span.next').click(function(){
		curIndex = curIndex + 1;
		change(curIndex);
		float_arrow(curIndex)
	});
  		
	$j('.closeimgbtn1, .windowbodyp').live('click', function(){
		/*
		cur_li = $j(".detailimglistup ul li.arrownow");
		cc = cur_li.children("div").children("img").attr("src");
		bigimgshow_src = cc.replace('_80_80', '_310_310');
		$j('.bigimgshow img').attr("src", bigimgshow_src);
		$j(".detailimglist ul li:eq("+curIndex+")").click();
		*/
		$j('.windowbodyp').remove();
		$j('.imglightbox').fadeOut();
	})
	//eof
});
$(function() {
	$j(window).resize(function(){
		re_pos('imglightbox');
		re_pos('product_question');
		re_pos('tellfriend');
	});
	$j(window).scroll(function(){
		re_pos('imglightbox');
		re_pos('product_question');
		re_pos('tellfriend');
	});
});
//eof

$(function(){
	$j.confirm = function(params){		
		if($j('#confirmOverlay').length){
			// A confirm is already shown on the page:
			return false;
		}		
		var buttonHTML = '';
		$j.each(params.buttons,function(name,obj){
			if(obj['text']){
				buttonHTML += '<a href="javascript:void(0);" class="'+obj['class']+'">'+name+'<span></span>'+obj['text']+'</a>';
			}else{
				buttonHTML += '<a href="javascript:void(0);" class="'+obj['class']+'">'+name+'<span></span></a>';
			}	
			if(!obj.action){
				obj.action = function(){};
			}
		});		
		var markup = [
			'<div class="removewindow" id="confirmOverlay">',
			'<p><a href="javascript:void(0);" class="removeclose">X</a></p>',
			'<h3>',params.message,'</h3>',
			'<div id="confirmButtons">',
			buttonHTML,
			'</div></div>'
		].join('');

		var bodyHeight=($j(document).height()+'px');
		$j('.windowbody').css('height', bodyHeight).fadeTo(1000, 0.5);
		$j(markup).hide().appendTo('body');
		re_pos('confirmOverlay');
		$j('#confirmOverlay').fadeIn();

		var buttons = $j('#confirmButtons a'),
			i = 0;

		$j.each(params.buttons,function(name,obj){
			buttons.eq(i++).click(function(){				
				obj.action();
				$j.confirm.hide();
				return false;
			});
		});
	}

	$j('.windowbody').click(function(){
		$j.confirm.hide();
	})

	$j('#confirmOverlay .removeclose').live('click', function(){
		$j.confirm.hide();
	})

	$j.confirm.hide = function(){
		$j('#confirmOverlay').fadeOut(function(){
			$j(this).remove();
		});
		$j('.windowbody').hide();
	}	
});

$(function(){
	$j('.orderstatus .select1').click(function(e){
		$j('.selectlist1').toggle();
		e.stopPropagation();
		$j('body').click(function(){
			$j('.selectlist1').hide();
		})
	})
		   
	$j('.selectlist1 li').click(function(){
		$j('#text_left1').text(($j(this).text()));  
		$j('input[name="orderstatus"]').val(($j(this).val()));
	})  
})