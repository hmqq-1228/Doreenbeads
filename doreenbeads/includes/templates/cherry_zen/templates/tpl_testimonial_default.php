<div class="mainwrap_r">
	<p><img src="includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>/testimonial.jpg"></p>
	<p class="testimonial_word"><?php echo TEXT_TESTIMONIAL_DESCRIPTION;?></p>
	<a class="footer_write_a_testimonial commonbtn" href="javascript:void(0);"><?php echo FOOTER_LINE1_WRITE_TESTIMONIALS;?></a>
</div>
<div class="mainwrap_l">
	<div class="menu_aboutus">
		<h3><?php echo TEXT_WHO_WE_ARE;?></h3>
		<ul>
			<li><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=162';?>"><?php echo TEXT_ABOUT_US;?></a></li>
			<li><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=163';?>"><?php echo TEXT_OUR_TEAM;?></a></li>
			<li><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=164';?>"><?php echo TEXT_QUALITY_CONTROL;?></a></li>
			<li><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=165';?>"><?php echo TEXT_SHIPPING_INFO;?></a></li>
			<li class="current"><a href="javascript:void(0);"><?php echo NAVBAR_TITLE;?></a></li>
			<li><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=157';?>"><?php echo TEXT_TERMS_AND_CONDITIONS;?></a></li>
         	<li><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=9';?>"><?php echo FOOTER_LINE2_PRIVACY_POLICY;?></a></li>
			<li><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>contact_us.html"><?php echo TEXT_CONTACT_US;?></a></li>
		</ul>
	</div>
</div>
<div class="clearfix"></div>
<div class="customer_testimonial" id="testimon_mid_txt">
	<div class="customer_testimonial_tit">
		<h3><?php echo TEXT_CUSTOMERS_TESTIMONIALS;?></h3>
		<?php echo zen_draw_form('testimonial', zen_href_link(testimonial, '', 'SSL'), 'post','id="testimonial"') ; ?>
		<div  align="right" width="80px" onchange="document.getElementById('testimonial').submit();">
		<select id="lan" name="lan" >
		  <option value ="99" <?php if($_SESSION['testimoniallan'] == 99){echo "selected";}?>>All</option>
		  <option value ="1" <?php if($_SESSION['testimoniallan'] == 1){echo "selected";}?>>English</option>
		  <option value="2" <?php if($_SESSION['testimoniallan'] == 2){echo "selected";}?>>Deutsch</option>
		  <option value="3" <?php if($_SESSION['testimoniallan'] == 3){echo "selected";}?>>Русский</option>
		  <option value="4" <?php if($_SESSION['testimoniallan'] == 4){echo "selected";}?>>Français</option>
		</select>
		</div>
		</form>
		<div class="propagelist" style='float:right;'><?php echo $testimonial_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
	</div>	
	
	<div class="customer_testimonial_inner">
<?php for ($i = 0; $i < sizeof($testimonial_array); $i++){ ?>
		<div class="avatar_l" id="testimonial_id_<?php echo $testimonial_array[$i]['id']; ?>">
			<img width="50px" src="images/Users/<?php echo $testimonial_array[$i]['avatar']; ?>" />
		</div>
		<div class="avatar_comment">
			<p class="avatarname"><strong><?php echo $testimonial_array[$i]['customer_name']. '</strong>&nbsp;' .$testimonial_array[$i]['customer_country']. ' &nbsp; ' .$testimonial_array[$i]['date_added']; ?></p>
			<dl class="avatartext"><dd><img src="includes/templates/cherry_zen/images/left_quote.png" alt="quote"></dd>
				<dt><?php echo $testimonial_array[$i]['content']; ?></dt><dd class="rightquote"></dd>
			</dl>
		</div>
		<div class="clearfix"></div>
		<dl class="avatar_reply">
	<?php if($testimonial_array[$i]['reply'] != ''){ ?>
			<dt><?php echo TEXT_INFO_REPLY;?></dt>
			<dd><?php echo $testimonial_array[$i]['reply']; ?></dd>
	<?php } ?>
		</dl>
<?php } ?>
	</div>
	<div class="customer_testimonial_tit">
		<div class="propagelist"><?php echo $testimonial_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
	</div>	
</div>
<script>
function goto_testimonial(){
	get_id='<?php echo $_GET["tm_id"];?>';
	if(get_id){
		box_top=$j('#testimonial_id_'+get_id).offset().top;
		$j(document).scrollTop(box_top);
	}else{
		box_top=$j('#testimon_mid_txt').offset().top;
		$j(document).scrollTop(box_top);
	}
}
goto_testimonial();
$j(document).ready(function(){
	$j('.customer_testimonial_tit .propagelist a').each(function(){
		href=$j(this).attr('href');
		if(href != 'javascript:void(0);'){
			new_href=href+'#testimon_mid_txt';
			$j(this).attr('href',new_href);
		}
	})
})
</script>
