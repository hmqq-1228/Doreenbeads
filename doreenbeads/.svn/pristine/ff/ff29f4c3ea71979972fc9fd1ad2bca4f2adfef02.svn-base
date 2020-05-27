<?php 
if ($checkIpAddress){
	if ($_SESSION['languages_id'] == 3) {
		?>
		<div style="width: 150px;margin-top:5px;">
			<!-- VK Widget -->
			<div id="vk_groups"></div>			
		</div>
		<script type="text/javascript" async="async" src="https://userapi.com/js/api/openapi.js?52"></script>
		<script type="text/javascript">
			//VK Widget
			if(document.getElementById("vk_groups")){
				VK.Widgets.Group("vk_groups", {mode: 0, width: "210", height: "400"}, '42161117');
			}
		</script>
		<?php 
	}else{
		?>
		<div class="follow-us">
			<dl class="sidemenu">
				<dd><?php echo FOOTER_LINE2_LIKE_FACEBOOK;?></dd>
				<dt>
					<div id="fb-root"></div>		
					
					<?php
						switch($_SESSION['languages_id']){
							case 1:
								$data_href = "https://www.facebook.com/doreenbeads";
								$fb_src = '//connect.facebook.net/en_US/all.js#xfbml=1';
								break;
							case 2:
								$data_href = "https://www.facebook.com/doreenbeads";
								$fb_src = '//connect.facebook.net/de_DE/all.js#xfbml=1';
								break;
							case 4:
								$data_href = "https://www.facebook.com/pages/DoreenBeadscomfr/600109833408040?ref=hl";
								$fb_src = '//connect.facebook.net/fr_FR/all.js#xfbml=1';
								break;
							default:
								$data_href = "https://www.facebook.com/doreenbeads";
								$fb_src = '//connect.facebook.net/en_US/all.js#xfbml=1';
								break;

						}												
					?>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.async = 1;
					  js.src = "<?php echo $fb_src;?>";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
					</script>
					<div class="fb-like-box" data-href="<?php echo $data_href;?>" data-width="180" data-height="290" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
				</dt>
			</dl>
		</div>
		<?php 
	}
}
?>