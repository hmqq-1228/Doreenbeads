<?php 
if ($check_result){
?>
<div class="follow-us">
<dl class="sidemenu"><dd><?php echo FOOTER_LINE2_LIKE_FACEBOOK;?></dd>
<dt><div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.async = 1;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" data-href="https://www.facebook.com/Doreenbeadscom" data-width="180" data-height="290" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
</dt>
</dl>
</div>
<?php } ?>