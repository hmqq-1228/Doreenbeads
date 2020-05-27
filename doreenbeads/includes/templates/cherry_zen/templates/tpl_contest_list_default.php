<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Please call pinit.js only once per page : get more from https://business.pinterest.com/en/widget-builder#do_pin_it_button -->
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>

<?php
	$define_contest_list = zen_get_file_directory(DIR_WS_LANGUAGES . 'english/html_includes/', 'define_contest_list.php', 'false');		
	require($define_contest_list);
?>
