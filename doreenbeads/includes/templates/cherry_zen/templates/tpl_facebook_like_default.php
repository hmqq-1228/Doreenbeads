<?php
if($error){
	echo '<div class="content">'.$error_msg.'</div>';
}else{
	require($define_facebook_like);
?>
<script type="text/javascript">
$j(function(){
	/*
	$j('.windowbody').height($j(document).height()+'px').fadeIn();
	$j('#pop_fblike').fadeIn();
	$j('#pop_fblike #closebtnfblike, .windowbody').click(function(){
		$j('#pop_fblike, .windowbody').fadeOut();
		return false;
	});
	*/
	<?php if($isActiveTime){ ?>
	$j(".fb_page .fb_banner .botton a").click(function(){
		var $this = $j(this);
		$j.post("./addcart.php", {ac: "facebook_like_add"}, function(data){
			var $tipObj = $j(".fb_page .successtips_add");
			if(data.length >0) {
				var datearr = new Array();
				datearr = data.split("|");
				if(datearr[2] != ''){
					alert(datearr[2]);
				}else{
					$tipObj.show();
				}

				$this.html("Added");
				$j("#count_cart").html(datearr[0]);
				var $addcart = $j(".cartcontent .addcart");
				if($addcart.hasClass("hasnoitem")){
					$addcart.removeClass("hasnoitem").addClass("hasitem");
				}
				setTimeout("$j('.fb_page .successtips_add').hide();", 3000);
			}
		});
		return false;
	});
	<?php } ?>
});
</script>
<?php
}
?>