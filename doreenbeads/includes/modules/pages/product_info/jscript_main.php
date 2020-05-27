<script>
    $j(function() {
        var options =
            {
                zoomWidth: 310, //放大镜的宽度
                zoomHeight: 310,//放大镜的高度
                zoomType:'reverse',
                title:false
            };
        $j(".jqzoom").jqzoom(options);

        $j('.closeimgbtn1, .questionbody').click(function(){
            cur_li = $j(".detailimglistup ul li.arrownow");

            if($j(".smallimgshow li").length > 3){
                var w = parseInt($j(".smallimgshow li").css("width"));
                var tw = w * $j(".smallimgshow li").length;
                var l = w * (curIndex-2);
                if(!$j("ul.deimglist").is(":animated")){
                    if(curIndex > 2){
                        $j("ul.deimglist").animate({marginLeft: -l+"px"}, 200);
                    }else{
                        $j("ul.deimglist").animate({marginLeft: "0px"}, 200);
                    }
                    if(curIndex == ($j(".smallimgshow li").length -1)){
                        $j('.arrowright').removeClass('on');
                        $j('.arrowright').removeClass('abled');
                        if(!$j('.arrowright').hasClass('off')){
                            $j('.arrowright').addClass('off');
                            $j('.arrowright').addClass('disabled');
                        }
                        if(!$j('.arrowleft').hasClass('on')){
                            $j('.arrowleft').addClass('on');
                            $j('.arrowleft').addClass('abled');
                        }
                    }else{
                        $j('.arrowright').removeClass('off');
                        $j('.arrowright').removeClass('disabled');
                    }
                    if(curIndex < 3){
                        $j('.arrowleft').removeClass('on');
                        $j('.arrowleft').removeClass('abled');
                    }else{
                        $j('.arrowleft').removeClass('off');
                        $j('.arrowleft').removeClass('disabled');
                    }
                }
            }

            cc = cur_li.children("div").children("img").attr("src");
            bigimgshow_src = cc.replace('_80_80', '_310_310');
            $j('.bigimgshow img').attr("src", bigimgshow_src);
            $j(".detailimglist ul li:eq("+curIndex+")").click();
            $j('.questionbody').fadeOut();
            $j('.imglightbox').fadeOut();
        })
//eof

        $j('.arrowleft').click(function(){
            if($j('.arrowright').hasClass('off')){
                $j('.arrowright').removeClass('off');
                $j('.arrowright').removeClass('disabled');
            }
            if($j(this).hasClass('on')){
                var num=1;
                var w = parseInt($j(".smallimgshow li").css("width"));
                var tw = w*$j(".smallimgshow li").length;
                if(!$j("ul.deimglist").is(":animated")){
                    var marLeft = parseInt($j("ul.deimglist").css("margin-left"));
                    var l = marLeft + w * num;
                    if(l >= 0){
                        l = 0;
                        $j('.arrowleft').removeClass('on');
                        $j('.arrowleft').removeClass('abled');
                    }
                    $j("ul.deimglist").animate({marginLeft: l+"px"}, 200);
                }
            }
        })

        $j('.arrowright').click(function(){
            if(!$j('.arrowleft').hasClass('on')){
                $j('.arrowleft').addClass('on');
                $j('.arrowleft').addClass('abled');
            }
            if(!$j(this).hasClass('off')){
                var num=1;
                var w = parseInt($j(".smallimgshow li").css("width"));
                var tw = w*$j(".smallimgshow li").length;
                if(!$j("ul.deimglist").is(":animated")){
                    var marLeft = parseInt($j("ul.deimglist").css("margin-left"));
                    var l = marLeft - w * num;
                    $j("ul.deimglist").animate({marginLeft: l+"px"}, 200);
                    if(-marLeft >= tw-w*num*4){
                        $j('.arrowright').addClass('off');
                        $j('.arrowright').addClass('disabled');
                    }
                }
            }
        })
    });
    function bigImgshowA(){
			  var lightboximg_src = ''
        var bodyHeight = $j(document).height()+'px';
        var imgurl= $j('.bigimgshow a img').attr("src");
        $j('body').append('<div class="windowbodyp"></div>');
				// console.log('jjjj', imgurl)
        lightboximg_src = imgurl.replace('_310_310', '_500_500');
        // lightboximg_src = imgurl.replace('310.gif', '500.gif');
				// console.log('kkkkk', lightboximg_src)
        $j('.lightboximg img').attr("src", lightboximg_src);
        re_pos('imglightbox');
        $j(".windowbodyp").css({"height":bodyHeight});
        $j('.windowbodyp').fadeIn();
        $j('.imglightbox').fadeIn();

	 	if(imgurl.indexOf('/failed/') == -1){
	 		cur_small_image_src = imgurl.replace('_310_310', '_80_80');
			$j(".detailimglistup ul").css('margin-left', 0);
			cur_small_image = $j(".detailimglistup ul li div img[src='"+cur_small_image_src+"']");
			
			cur_small_image.parent('div').parent('li').addClass('arrownow');
	 	}else{
	 		indexli = $j('.smallimgshow .detailimglist .deimglist .arrownow').index();
	 		cur_small_image_src = imgurl.replace('/310.gif', '/80.gif');
	 		$j('.detailimglistup ul li:eq'+'(' + indexli + ')').addClass('arrownow');
	 		
	 	}
//         cur_small_image_src = imgurl.replace('_310_310', '_80_80');
//         cur_small_image_src = imgurl.replace('310.gif', '80.gif');
//         $j(".detailimglistup ul").css('margin-left', 0);
//         cur_small_image = $j(".detailimglistup ul li div img[src='"+cur_small_image_src+"']");
//         cur_small_image.parent('div').parent('li').addClass('arrownow');
        curIndex = $j(".detailimglistup ul li").index($j(".detailimglistup ul li.arrownow"));
    }
</script>