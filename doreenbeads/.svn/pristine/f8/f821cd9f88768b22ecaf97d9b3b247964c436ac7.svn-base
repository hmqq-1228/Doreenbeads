<?php 
if ($_GET['pagename'] == 'shipping_calculator')
	require(DIR_WS_MODULES . 'pages/shipping_calculator/jscript_main.php');
?>
<script type="text/javascript">
<!--
$j(function(){
	$j('#searchwords').focus(function(){
		var v = $j(this).val();
		if(v == '<?php echo TEXT_ENTER_THE_KEYWORD; ?>')
			$j(this).val('');
	}).blur(function(){
		var v = $j(this).val();
		if(v == '')
			$j(this).val('<?php echo TEXT_ENTER_THE_KEYWORD; ?>');
	});

	$j('.questionsearch ins').click(function(){
		if($j(this).attr('class') == 'closecont'){
			$j(this).attr('class','opencont');
		}else{
			$j(this).attr('class','closecont');	
		}
		$j(this).parent().next('.answersearch').toggle();
	}) 
})
function chk_faq_search_form(){
	var v = $j('#searchwords').val();
//	var reg = /^[0-9a-zA-Z]*$/g;
	var reg = /^([0-9A-Za-z]+\s*)*[0-9A-Za-z]*$/g;
	if(! reg.test(v)){
		alert("<?php echo TEXT_KEYWORD_ERROR; ?>");
		return false;
	}else
		return true;
}
// -->
</script>

<div class="mainwrap_l">
	<div class="menu_aboutus">
		<h3><?php echo TEXT_HELP_CENTER; ?></h3>
		<ul>
			<li <?php if(($_GET['id'] == '' || in_array($_GET['id'], $customer_care_arr)) && $_GET['action'] != 'search') echo 'class="current"';?>>
				<a href="<?php echo zen_href_link(FILENAME_HELP_CENTER);?>"><?php echo TEXT_CUSTOMER_CARE; ?></a>
<?php if(($_GET['id'] == '' || in_array($_GET['id'], $customer_care_arr)) && $_GET['action'] != 'search') {?>
				<div class="submenu_aboutus">
					<p <?php if($_GET['pagename'] == 'shipping_calculator') echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'pagename=shipping_calculator');?>"><?php echo TEXT_SHIPPING_CALCULATOR; ?></a></p>
					<p <?php if($_GET['id'] == 181) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=181');?>"><?php echo TEXT_SHIPPING_METHODS; ?></a></p>
					<p <?php if($_GET['id'] == 15) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=15');?>"><?php echo TEXT_PAYMENT_METHODS; ?></a></p>
					<p <?php if($_GET['id'] == 46) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=46');?>"><?php echo TEXT_TRACKING_PARCELS; ?></a></p>
					<p <?php if($_GET['id'] == 65) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=65');?>"><?php echo TEXT_DISCOUNT_VIP; ?></a></p>
					<p <?php if($_GET['id'] == 138) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=138');?>"><?php echo TEXT_CUSTOMIZE_SERVICE; ?></a></p>
					<!-- <p <?php if($_GET['id'] == 18) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=18');?>"><?php echo TEXT_LEARNING_CENTER; ?></a></p> -->
					<!-- <p <?php if($_GET['id'] == 64) echo 'class="now"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=64');?>"><?php echo TEXT_LASTEST_NEWS; ?></a></p> -->
				</div>
<?php } ?>
			</li>
			<li <?php if($_GET['id'] == 227) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=227');?>"><?php echo TEXT_SHIPPING_FROM_USA; ?></a></li>
			<li <?php if($_GET['id'] == 182) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=182');?>"><?php echo TEXT_ACOUT_DORABEADS; ?></a></li>
			<li <?php if($_GET['id'] == 183) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=183');?>"><?php echo TEXT_ORDERING_INFO; ?></a></li>
			<li <?php if($_GET['id'] == 184) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=184');?>"><?php echo TEXT_MYACCOUNT_INFO; ?></a></li>
			<li <?php if($_GET['id'] == 185) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=185');?>"><?php echo TEXT_CUSTOMER_SERVICE; ?></a></li>
			<li <?php if($_GET['id'] == 186) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=186');?>"><?php echo TEXT_CUSTOM_DUTY; ?></a></li>
			<li <?php if($_GET['id'] == 187) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=187');?>"><?php echo TEXT_ITEM_PRICE; ?></a></li>
			<li <?php if($_GET['id'] == 188) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=188');?>"><?php echo TEXT_PRODUCT_QUESTIONS; ?></a></li>
			<li <?php if($_GET['id'] == 189) echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=189');?>"><?php echo TEXT_WEBSITE_QUESTIONS; ?></a></li>
			<!--Tianwen.Wan20170523
			<li <?php if($_GET['id'] == 180 || $_GET['action'] == 'search') echo 'class="current"';?>><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=180');?>"><?php echo TEXT_CUSTOMER_QUESTIONS; ?></a></li>
			-->
		</ul>
	</div>
</div>

<div class="mainwrap_r">
	<div class="searchpart">
		<div class="searchpart_l">
<?php if ($action == 'search'){
			echo '<p class="searchfor">'.TEXT_SEARCH_FOR.' '.$search_word.'</p>';
	if($result_split->number_of_rows > 0)
			echo '<p class="searchresult">'.$result_split->number_of_rows.' '.TEXT_RESULT_FOUND.'</p>';
	else
			echo '<p class="searchresult">'.TEXT_NO_RESULT.'</p>';
}else{
			echo '<h3><ins class="'.$pageDetails_img.'"></ins>'.$pageDetails_head.'</h3>';
}?>
		</div>
		<div class="searchpart_r">
			<form class="searchform" name="faq_search_form" action="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'action=search'); ?>" method="post" onsubmit="return chk_faq_search_form();">
				<input type="text" name="faq_search" value="<?php echo TEXT_ENTER_THE_KEYWORD; ?>" id="searchwords"/>
				<input type="submit" class="searchsubmit" value="&nbsp;"/> 
			</form>
		</div>
		<div class="clearfix"></div>
	</div>
<?php
if (isset($ezpage_id) && $ezpage_id != '' && $ezpage_id != 180){
	echo '<div class="resultcont">'.$pageDetails.'</div>';
}else if($action == 'search' || $ezpage_id == 180){
	$extra_para = ($action == 'search' ? '&sw='.$search_word : '');
?>
	<div class="resultcont">
		<div class="propagelist"><?php echo TEXT_RESULT_PAGE . ' ' . $result_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page', 'sw')) . $extra_para); ?></div>
	<?php
		if (zen_not_null($search_result_content)){
			for ($i = 0, $n = sizeof($search_result_content); $i < $n; $i++){
				echo '<div class="questionsearch">Q: '.$search_result_content[$i]['question_content'];
				if ($search_result_content[$i]['reply'] != ''){
					echo '<ins class="closecont"></ins></div>';
					echo '<div class="answersearch">A: '.$search_result_content[$i]['reply'].'</div>';
				}else
					echo '</div>';
			}
		}
	?>
<!--
		<div class="propagelist"><?php echo TEXT_RESULT_PAGE . ' ' . $result_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page', 'sw')) . $extra_para); ?></div>
-->
	</div>
<?php }elseif ($_GET['pagename'] == 'shipping_calculator'){
	require($template->get_template_dir('tpl_shipping_calculator_default.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_shipping_calculator_default.php');
}else{
?>
	<div class="helpcenter-list"><ul>
		<li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'pagename=shipping_calculator');?>"><?php echo TEXT_SHIPPING_CALCULATOR; ?></a></li>
		<li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=181');?>"><?php echo TEXT_SHIPPING_METHODS; ?></a></li>
		<li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=15');?>"><?php echo TEXT_PAYMENT_METHODS; ?></a></li>
		<li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=46');?>"><?php echo TEXT_TRACKING_PARCELS; ?></a></li>
		<li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=65');?>"><?php echo TEXT_DISCOUNT_VIP; ?></a></li>
		<li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=138');?>"><?php echo TEXT_CUSTOMIZE_SERVICE; ?></a></li>
		<!-- <li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=18');?>"><?php echo TEXT_LEARNING_CENTER; ?></a></li> -->
		<!-- <li><ins></ins><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=64');?>"><?php echo TEXT_LASTEST_NEWS; ?></a></li> -->
	</ul></div>	
<?php };?>
</div>
