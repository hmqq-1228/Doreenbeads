
<script language="javascript" type="text/javascript"><!--
$j(function(){


	$j(document).on('click', '.imageChange', function(){
		var obj = $j(this);
		var url = obj.find('img').attr('src');
		
		$j('.getImage').find('img').attr({src:url});
	});
	

	$j(document).on('click', '.clicktocat', function(){
		var obj = $j(this);
		var cate_id = obj.attr('cate_id');
		var view = obj.data('viewall');
		//alert(pid);
		
		$j('.menu_cont .clicktocat').removeClass("current");
		$j('.menu_cont .clicktocat_'+cate_id).addClass('current');
		$j('.menu_cont .second_click').removeClass("current");

		$j.post("/index.php?main_page=learning_center",{cate_id:cate_id,view:view},
			function(data){
				if (data) {
					$j("body,html").animate({scrollTop:0}, 0);
					$j('#first_list').html(data).show();
					$j(".current_nav").html($j("#current_nav_hidethis").html());
					$j('#lc_index').hide();
					$j('#second_list').hide();
					$j('#article_details').hide();
					$j('#third_list').hide();
				};
			});
		
		return false;
		
	});

	$j(document).on('click', '.second_click', function(){
		var obj = $j(this);
		var second_id = obj.attr('second_id'),
			first_id = obj.attr('first_id');
		var view = obj.data('viewall');

		$j('.menu_cont .second_click').removeClass("current");
		$j('.menu_cont .second_click_'+second_id).addClass('current');
		$j('.menu_cont .clicktocat').removeClass("current");
		//$j('.menu_cont .clicktocat_'+first_id).addClass('current');

		$j.post("/index.php?main_page=learning_center",{second_id:second_id,view:view},
			function(data){
				if (data) {
					$j("body,html").animate({scrollTop:0}, 0);
					$j('#second_list').html(data).show();
					$j(".current_nav").html($j("#current_nav_hidethis_second").html());
					$j('#lc_index').hide();
					$j('#first_list').hide();
					$j('#article_details').hide();
					$j('#third_list').hide();
		
				};
			});
		
		return false;

	});
	

	/*$j(document).on('click', '.img_click', function(){
		var obj = $j(this);
		var second_id = obj.attr('second_id');

		obj.parent().siblings().children('.second_click').removeClass("current");
		obj.parent().parent().siblings('ul').children().children('.second_click').removeClass("current");
		obj.parent().parent().siblings('h4').children('.current').removeClass("current");
		obj.addClass('current');

		$j.post("/index.php?main_page=learning_center",{second_id:second_id},
			function(data){
				if (data) {
					$j('#second_list').html(data).show();
					$j(".current_nav").html($j("#current_nav_hidethis_second").html());
					$j('#lc_index').hide();
					$j('#first_list').hide();
					$j('#article_details').hide();
					$j('#third_list').hide();
		
				};
			});
		
		return false;

	});*/

	$j(document).on('click', '.article_click', function(){
		var obj = $j(this);
		var	cid = obj.attr('cid');
		var second_id = obj.attr('second_id'),
			first_id = obj.attr('first_id');
		var	article_id = obj.attr('aid');

		$j('.menu_cont .second_click').removeClass("current");
		$j('.menu_cont .second_click_'+second_id).addClass('current');
		$j('.menu_cont .clicktocat').removeClass("current");
		//$j('.menu_cont .clicktocat_'+first_id).addClass('current');

		$j.post("/index.php?main_page=learning_center",{article_id:article_id},
			function(data){
				if (data) {
					$j("body,html").animate({scrollTop:0}, 0);
					$j('#article_details').html(data).show();
					$j(".current_nav").html($j("#current_nav_hidethis_detail").html());
					$j('#lc_index').hide();
					$j('#first_list').hide();
					$j('#second_list').hide();
					$j('#third_list').hide();

					jQuery.getScript("http://w.sharethis.com/button/buttons.js")
			 			.done(function() {
					    stLight.options({publisher: "8c9fa0f5-056b-4e6c-91ed-b8398b2cbe74"}); 
					});
					
				};
			});
		
		return false;
	});

	$j('.hover_li.more').hover(function(){
		var obj = $j(this);
		obj.addClass('morehover').css('padding','0');
		obj.children('div').css('display','block');
	},function(){
		var obj = $j(this);
		obj.removeClass('morehover').css('padding', '1px 0');
		obj.children('div').css('display','none');
	});

	
	$j(document).on('click', '.third_click', function(){
		var obj = $j(this);
		var third_id = obj.attr('tid');
		var second_id = obj.attr('second_id'),
			first_id = obj.attr('first_id');
		
		$j('.menu_cont .second_click').removeClass("current");
		$j('.menu_cont .second_click_'+second_id).addClass('current');
		$j('.menu_cont .clicktocat').removeClass("current");
		//$j('.menu_cont .clicktocat_'+first_id).addClass('current');

		$j.post("/index.php?main_page=learning_center",{third_id:third_id},
			function(data){
				if (data) {
					$j("body,html").animate({scrollTop:0}, 0);
					$j('#third_list').html(data).show();
					$j(".current_nav").html($j("#current_nav_hidethis_third").html());
					$j('#lc_index').hide();
					$j('#first_list').hide();
					$j('#second_list').hide();
					$j('#article_details').hide();
		
				};
			});
		
		return false;
	});
	

	$j(document).on('click', '.viewHere', function(){
		var obj = $j(this);
		$j(".hideThisLi").show();
		obj.parent().remove();
	});


	$j(document).on('click', '.partsadd', function(){
		var aid = $j(this).attr('aid');
		var type = $j(this).attr('type');
		$j.post('./ajax_add_all_to_cart.php', {aid: aid, type: type}, function(data){
			if(data != ''){
				alert(data);
			}
			window.location.href = 'index.php?main_page=shopping_cart';
		});
	});
});
//--></script>