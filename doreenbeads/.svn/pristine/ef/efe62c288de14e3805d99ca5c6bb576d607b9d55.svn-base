<!---- header_top start---->
 <div class="header_top">
 	<div class="header_top_cen">
 		<?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
 		<span style="width:240px;"><?php echo TEXT_HEADER_WELCOME;?>, <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>">
 			<?php echo $_SESSION['customer_first_name'] !='' ? (strlen($_SESSION['customer_first_name']) > 15 ? substr($_SESSION['customer_first_name'], 0, 12).'...' : $_SESSION['customer_first_name'] ) : (strlen(strstr($_SESSION['customer_email'], '@', true)) > 15 ? substr(strstr($_SESSION['customer_email'], '@', true), 0, 12).'...' : strstr($_SESSION['customer_email'], '@', true) )  ;?></a> 
 			(<a rel="nofollow" href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a>)</span>
 		<?php } else { ?>
 		<span style="width:240px;"><?php echo TEXT_HEADER_WELCOME;?>, <?php echo TEXT_HEADER_LOGIN_AND_REGISTER;?></span>
 		<?php } ?>
 		
		<dl class="go_mobilesite">
			<dd><a href="<?php echo 'http://m.'.BASE_SITE.'/'.$_SESSION['languages_code'].'/index.php?currency='.$_SESSION['currency'];?>"><span><img style="margin:auto 10px;padding:3.5px" alt="<?php echo str_replace('www', 'm', HTTP_SERVER)?>" src="includes/templates/cherry_zen/images/phone.png"></span></a></dd>
			<dt>
				<ul class="go_mobilesite_ul">
					<li class="go_mobilesite_tip"><?php echo HEAD_VIEW_MOBILE_SITE;?></li>
					<li><img src="<?php echo DIR_WS_LANGUAGE_IMAGES . 'mobile_code.png';?>"></li>
				</ul>
			</dt>
		</dl>
 		<!-- bof currency -->
		<?php require(DIR_WS_TEMPLATE . '/common/tpl_currency.php'); ?>
		<!-- eof currency -->
		
		<ul class="language fleft">
    	<?php 
		if (!isset($lng) || (isset($lng) && !is_object($lng))) {
			$lng = new language;
		}
		reset($lng->catalog_languages);
		$languages_html = "";
		$languages_html_head = "";
		while (list($key, $value) = each($lng->catalog_languages)) {
//			if($value['id']==1 || $value['id']==3 || $value['id']==2){
			$lang_url = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency', 'generate_index')) . 'currency=' . $_SESSION['currency'] . 'language=' . $key, $request_type);
			if($value['id']==$_SESSION['languages_id']){
				$languages_html_head =  '<li><b><a data-code="' . $key . '" rel="nofollow" href="' . $lang_url . '" >'.$value['name'].'</a></b></li>';
			}else{
				$languages_html .= '<li> · <a data-code="' . $key . '" rel="nofollow" href="' . $lang_url . '" >'.$value['name'].'</a></li>';
			}
			$lng_cnt ++;
//			}
		}
		echo $languages_html_head . $languages_html;
		?>
		</ul>
		<input type="hidden" id="c_lan" value="<?php echo $_SESSION['language'];?>">
		
		<ul class="top_right">
			<?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
			<li id="myAccount" class="help"><a rel="nofollow" class="helpHover" href="<?php echo zen_href_link('myaccount', '', 'SSL');?>" ><?php echo HEADER_TITLE_MY_ACCOUNT;?><ins></ins></a>
				<div class="helpcont">
					<p class="helplist"><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>" ><?php echo HEADER_TITLE_MY_ORDERS;?></a></p>
					<p class="helplist"><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');?>" ><?php echo HEADER_TITLE_ADDRESS_BOOK;?></a></p>
				</div>
				<input type="hidden" class="isLogin" value="yes">
			</li>
			<?php } else {?>
			<li id="myAccount" class="help"><a rel="nofollow" class="helpHover" href="<?php echo zen_href_link(FILENAME_LOGIN, '&return=myaccount', 'SSL');?>" ><?php echo HEADER_TITLE_MY_ACCOUNT;?></a><input type="hidden" class="isLogin" value="no"></li>
			<?php } ?>
			<li>|</li>
			
			<li id="myWishlist"><a rel="nofollow" href="javascript:void(0);" ><?php echo HEADER_TITLE_WISHLIST;?></a></li>
			<li>|</li>
			
			<li class="help" id="help"> <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_CUSTOMER_SERVICE);?>" class="helpHover" ><?php echo HEADER_TITLE_HELP;?><ins></ins></a>
				<div class="helpcont helpcen">
					<p class="helplist"><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'pagename=shipping_calculator');?>" ><?php echo HEADER_TITLE_SHIPPING_CALCULATOR;?></a></p>
					<p class="helplist"><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=15');?>" ><?php echo HEADER_TITLE_PAYMENT_METHODS;?></a></p>
					<p class="helplist"><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=65');?>" ><?php echo HEADER_TITLE_DISCOUNT_POLICY;?></a></p>
					<!--<p class="helplist"><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=18');?>" ><?php echo HEADER_TITLE_LEARNING_CENTER;?></a></p>-->
					<p class="helplist"><a rel="nofollow" href="page.html?id=69" ><?php echo HEADER_TITLE_DOWNLOAD_PICTURES;?></a></p>
					
				</div>
			</li>
			<li>|</li>
			<?php
				$my_message_data = get_customers_message_memcache($_SESSION['customer_id'], $_SESSION['languages_id'], 0, 5);
			?>

			<li class="jq_my_message_notice my_message_notice <?php if(empty($my_message_data)) {?> my_message_notice_empty<?php }?>"> <a rel="nofollow" class="helpHover" ><?php if(!empty($my_message_data)) {?>(<font id="my_message_count" class="my_message_count"><?php echo ($my_message_data['count'] > 99 ? 99 : $my_message_data['count']);?></font>)<?php }?><span class="my_message_notice_icon"></span></a>
				<div class="helpcont helpcen">
					<ul>
						<?php if(!empty($my_message_data)) {?>
						<?php foreach($my_message_data['list'] as $my_message_value) {?>
						<li>&nbsp;<a href="<?php echo zen_href_link(FILENAME_MESSAGE_INFO) . '&auto_id=' . $my_message_value['auto_id'];?>">[<font class="my_message_type"><?php echo $my_message_value['title_type'];?></font>] <?php echo $my_message_value['title_list'];?></a></li>
						<?php }?>
						<?php } else {?>
						<li>&nbsp;<?php echo TEXT_NO_UNREAD_MESSAGE;?></li>
						<?php }?>
					</ul>
					<div class="my_message_setting">&nbsp;<a href="<?php echo zen_href_link(FILENAME_MESSAGE_SETTING);?>"><?php echo TEXT_SETTING;?></a></div>
					<div class="my_message_see"><a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST);?>"><?php echo TEXT_SEE_ALL_MESSAGES;?></a>&nbsp;</div>
				</div>
			</li>
			<!-- 临时需求20180118暂时关闭 -->
      		<!-- <li>|</li> -->
      		<!-- <li class="pleft" id="btnInviteFriends"><a rel="nofollow" href="javascript:void(0);" title="<?php /* echo HEADER_TITLE_INVITE_FRIENDS_TITLE; */?>"><?php /* echo HEADER_TITLE_INVITE_FRIENDS; */?></a></li> -->
		</ul>
	</div>
</div>
<!---- header_top end  ---->

<!-- bof holiday note -->
<?php 
/*$display_holiday_note = (  date('Y-m-d H:i:s') < '2015-03-02 16:00:00');
if(date('Y-m-d H:i:s') < '2015-02-02 16:00:00'){
	$holiday_notice = TEXT_HEADER_HOLIDAY_NOTE;
	$holiday_num = 1;
}elseif(date('Y-m-d H:i:s') >= '2015-02-02 16:00:00' && date('Y-m-d H:i:s') < '2015-02-15 16:00:00'){
	$holiday_notice = TEXT_HEADER_HOLIDAY_NOTE_2;
	$holiday_num = 2;
}elseif(date('Y-m-d H:i:s') >= '2015-02-15 16:00:00' && date('Y-m-d H:i:s') < '2015-02-24 16:00:00'){
	$holiday_notice = TEXT_HEADER_HOLIDAY_NOTE_3;
	$holiday_num = 3;
}elseif(date('Y-m-d H:i:s') >= '2015-02-24 16:00:00' && date('Y-m-d H:i:s') < '2015-03-02 16:00:00'){
	$holiday_notice = TEXT_HEADER_HOLIDAY_NOTE_4;
	$holiday_num = 4;
}*/
$have_show_message = false;
$an_sql = "select an_id,an_starttime,an_endtime from ".TABLE_ANNOUNCEMENT." where an_starttime <= '".date('Y-m-d H:i:s',time())."' and an_endtime >= '".date('Y-m-d H:i:s',time())."' and an_status = 20 order by an_id DESC limit 1";
$an_sql_query = $db->Execute($an_sql) ;
if( $an_sql_query->RecordCount() > 0) {	
	$an_id = $an_sql_query->fields['an_id'];
	$an_starttime = $an_sql_query->fields['an_starttime'];
	$an_endtime = $an_sql_query->fields['an_endtime'];
	$an_desc_query = $db->Execute("select an_language,an_content from t_announcement_description where an_id = ".$an_id);
	while(!$an_desc_query->EOF){
  		$an_desc_array[$an_desc_query->fields['an_language']] = stripslashes($an_desc_query->fields['an_content']);
		$an_desc_query->MoveNext();
	}
}
if (isset($an_desc_array[$_SESSION['languages_id']]) && $an_desc_array[$_SESSION['languages_id']] != ''){
	$have_show_message = true;
?>
<div id="holidaynote<?php echo $an_id ?>" class="announceClass" style="font-family: Arial; font-size:14px; width:1000px; background:#fbf8e8; margin: 0px auto; border: 0; line-height:26px;">
<div  style="font-family: Arial; font-size:14px;  background:#F9F7BA; margin: 10px 0 10px; border: 1px solid #e0e8d6; line-height:14px; padding:10px;color:#333;" >
	<img src="includes/templates/cherry_zen/images/warmclose.gif" width="11" height="12" style="float:right;cursor:pointer;margin-left:10px;" onclick="noteclose();">	
    <?php echo $an_desc_array[$_SESSION['languages_id']]; ?>
</div>
</div>
<!-- eof holiday note -->
<?php 
}elseif ($_GET['main_page'] != 'checkout_shipping' && isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '' && $_SESSION['customer_default_address_id'] != '') {
	$address_telephone = $db->Execute("select entry_telephone from " . TABLE_ADDRESS_BOOK . " where address_book_id = " . $_SESSION['customer_default_address_id']);
	if($address_telephone->RecordCount() > 0) {
		if($address_telephone->fields['entry_telephone'] == '') {
			$have_show_message = true;
			?>
			<div id="phoneNote" style="font-family: Arial; font-size:14px; width:1000px; background:#FEEDF3; margin: 0px auto; border: 0; line-height:26px;">
			<div style="font-family: Arial; font-size:14px; margin: 0 0 10px; border: 1px solid #F0D7E2; line-height:26px; padding:0px 10px;color:#333;" >
				<img src="includes/templates/cherry_zen/images/warmclose.gif" width="11" height="12" style="float:right;cursor:pointer;margin:10px 0 0 10px;">	
			    <?php echo TEXT_HEADER_ADDRESS_PHONE_NOTE;?>
			</div>
			</div>
			<?php 
		}
	}
}
if(!$have_show_message){
	if(!($_GET['main_page'] == 'index' && $_GET['cPath'] == '')){
		echo show_coupon_letter('web');
	}
}
?>

<script type="text/javascript">
$j(function(){
	$j('#phoneNote img').click(function(){
		$j('#phoneNote').hide();
	});
});
function setCookie(c_name,value,expiredays)
{
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}
function getCookie(c_name)
{
	if (document.cookie.length>0)
		{
			c_start=document.cookie.indexOf(c_name + "=")
		if (c_start!=-1)
	{ 
		c_start=c_start + c_name.length+1 
		c_end=document.cookie.indexOf(";",c_start)
		if (c_end==-1) c_end=document.cookie.length
		return unescape(document.cookie.substring(c_start,c_end))
		} 
		}
	return ""
}
function noteclose(){
	if($j('.announceClass').attr('id')){
		$j('.announceClass').hide();
		setCookie($j('.announceClass').attr('id'),"true",7);
	}
	/*if(document.getElementById('holidaynote')){
		document.getElementById('holidaynote').style.display = 'none';
		setCookie("noticetop","true",7);
	}

	if(document.getElementById('holidaynote1')){
		document.getElementById('holidaynote1').style.display = 'none';
		setCookie("noticetop1","true",7);
	}
	if(document.getElementById('holidaynote2')){
		document.getElementById('holidaynote2').style.display = 'none';
		setCookie("noticetop2","true",7);
	}
	if(document.getElementById('holidaynote3')){
		document.getElementById('holidaynote3').style.display = 'none';
		setCookie("noticetop3","true",7);
	}
	if(document.getElementById('holidaynote4')){
		document.getElementById('holidaynote4').style.display = 'none';
		setCookie("noticetop4","true",7);
	}*/
}
function generatepopup(){
	if (getCookie($j('.announceClass').attr('id'))) {$j('.announceClass').hide()};
	/*if(getCookie("noticetop")=="true"){
		if(document.getElementById('holidaynote')) document.getElementById('holidaynote').style.display = 'none';
	}

	if(getCookie("noticetop1")=="true"){
		if(document.getElementById('holidaynote1')) document.getElementById('holidaynote1').style.display = 'none';
	}
	if(getCookie("noticetop2")=="true"){
		if(document.getElementById('holidaynote2')) document.getElementById('holidaynote2').style.display = 'none';
	}
	if(getCookie("noticetop3")=="true"){
		if(document.getElementById('holidaynote3')) document.getElementById('holidaynote3').style.display = 'none';
	}
	if(getCookie("noticetop4")=="true"){
		if(document.getElementById('holidaynote4')) document.getElementById('holidaynote4').style.display = 'none';
	}*/
}
generatepopup();
</script>
