<script type="text/javascript">
<!--
$j(function(){
	$j(".getCouponLogin").on("click", function(){
		show_login_div('index.php?main_page=get_coupon');
	});
});
-->
</script>
<?php
	if ($messageStack->size('get_coupon') > 0) {
		echo $messageStack->output('get_coupon');
	}
?>
<?php
	$define_get_coupon = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', 'define_get_coupon.php', 'false');	
	require($define_get_coupon);
?>