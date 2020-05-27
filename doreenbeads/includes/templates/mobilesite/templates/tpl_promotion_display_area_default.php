<h3 class="trends"><?php echo strtoupper(PROMOTION_DISPLAY_AREA);?></h3>
<div class="trends_intro"> <?php echo SALES_DESCRIPTION;?> </div>
<div class="trends_wrapper">
<?php 
	$i = 0;
	if(sizeof($display_area_data) > 0){
		foreach ($display_area_data as $value){
			$i++;
			echo '<div class="trends_banner"><a href="' . $value['picture_href'] . '"><img src="' . $value['picture_url'] . '" /></a></div>';
			echo '<div class="trends_cont">
			<p class="time"><ins></ins>' . $value['promotion_time'] . '</p>
			<p>' . $value['area_name']  . '</p>
			</div>';
		
			echo '</div>' . '<div class="trends_num" style="display:none;"value="' . $i . '"></div>';
		} 
	}else{
		echo '<div>' . SALES_EMPTY . '</div>';
	}

?>

<div style="display:none;" class="show_explore" value="5"><p><?php echo TEXT_VIEW_MORE; ?> </p></div>

<div class="max_trends_num" style="display:none;" value="<?php echo $max_trends;?>"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var trends_num = parseInt($(".trends_num:last").attr("value"));
	var max_trends_num = parseInt($(".max_trends_num").attr("value"));
	$(".cartcont").each(function(){
		$(this).find("input").first().val("10");
		});
	$(".floatprice").remove();
	if(trends_num < max_trends_num){
		$(".show_explore").show();
	}
	
	
	$(".dlgallery-list li").each(function(i , eledom){
		var top = '<ins class="top' + (i+1) + '"></ins>'
		$(eledom).children("a").prepend(top);
	});
	
	$(".show_explore").click(function(){
		var offset = $(this).attr("value");
		$.post(window.location.href , {
		"action":"view_more",
		"offset":offset,
			},
		function(data){
	 		$(".trends_num:last").after(data);
	 		$(".show_explore").attr("value",parseInt(offset)+5);
	 		var show_trends_num = parseInt($(".trends_num:last").attr("value"));
			var new_offset = parseInt($(".show_explore").attr("value"));
	 		if(new_offset >= max_trends_num){
	 			$(".show_explore").remove();
		 	}
		}
		);
	});
});
</script>