<!-- bof holiday note -->
<?php 
$display_holiday_note = (date('Y-m-d H:i:s') <= '2013-10-03 23:59:59');
if ($display_holiday_note){
?>
<div id="holidaynote" style="font-family: Arial; font-size:14px; width:1000px; background:#fff; margin: 0px auto; border: 0; line-height:26px;">
<div  style="font-family: Arial; font-size:14px;   background:#feeaeb; margin: 0 0 10px; border: 1px solid #e0e8d6; line-height:26px; padding:10px;color:#333;" >
	<img src="includes/templates/cherry_zen/images/warmclose.gif" width="11" height="12" style="float:right;cursor:pointer;margin-left:10px;" onclick="noteclose();">	
    <?php echo TEXT_HEADER_HOLIDAY_NOTE; ?>
</div>
</div>
<!-- eof holiday note -->
<?php 
}elseif ($_GET['main_page'] != 'checkout_shipping' && isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '' && $_SESSION['customer_default_address_id'] != '') {
	$address_telephone = $db->Execute("select entry_telephone from " . TABLE_ADDRESS_BOOK . " where address_book_id = " . $_SESSION['customer_default_address_id']);
	if($address_telephone->RecordCount() > 0) {
		if($address_telephone->fields['entry_telephone'] == '') {
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
	document.getElementById('holidaynote').style.display = 'none';
	setCookie("generatepop","true",8);
}
function generatepopup(){
	if(getCookie("generatepop")=="true"){
		if(document.getElementById('holidaynote')) document.getElementById('holidaynote').style.display = 'none';
	}
}
generatepopup();
</script>

<!---- header_top start---->
 <div class="header_top">
 	<div class="header_top_cen">
 		<?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
 		<span style="width:390px;"><?php echo TEXT_HEADER_WELCOME;?>, <a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>"><?php echo $_SESSION['customer_first_name'];?></a> (<a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a>)</span>
 		<?php } else { ?>
 		<span style="width:390px;"><?php echo TEXT_HEADER_WELCOME;?>, <a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL');?>"><?php echo TEXT_HEADER_LOGIN_AND_REGISTER;?></span>
 		<?php } ?>
 		
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
			$lang_url = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type);
			if($value['id']==$_SESSION['languages_id']){
				$languages_html_head =  '<li><b><a href="' . $lang_url . '" title="'.$value['name'].'">'.$value['name'].'</a></b></li>';
			}else{
				$languages_html .= '<li> · <a href="' . $lang_url . '" title="'.$value['name'].'">'.$value['name'].'</a></li>';
			}
			$lng_cnt ++;
		}
		echo $languages_html_head . $languages_html;
		?>
		</ul>
		<input type="hidden" id="c_lan" value="<?php echo $_SESSION['language'];?>">
		
		<ul class="top_right">
			<?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
			<li id="myAccount" class="help"><a class="helpHover" href="<?php echo zen_href_link('myaccount', '', 'SSL');?>" title="<?php echo HEADER_TITLE_MY_ACCOUNT;?>"><?php echo HEADER_TITLE_MY_ACCOUNT;?><ins></ins></a>
				<div class="helpcont">
					<p class="helplist"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>" title="<?php echo HEADER_TITLE_MY_ORDERS;?>"><?php echo HEADER_TITLE_MY_ORDERS;?></a></p>
					<p class="helplist"><a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');?>" title="Address Book">Address Book</a></p>
				</div>
				<input type="hidden" class="isLogin" value="yes">
			</li>
			<?php } else {?>
			<li id="myAccount" class="help"><a class="helpHover" href="javascript:void(0);" title="<?php echo HEADER_TITLE_MY_ACCOUNT;?>"><?php echo HEADER_TITLE_MY_ACCOUNT;?></a><input type="hidden" class="isLogin" value="no"></li>
			<?php } ?>
			<li>|</li>
			
			<li id="myWishlist"><a href="javascript:void(0);" title="<?php echo HEADER_TITLE_WISHLIST;?>"><?php echo HEADER_TITLE_WISHLIST;?></a></li>
			<li>|</li>
			
			<li class="help" id="help"> <a href="<?php echo zen_href_link(FILENAME_CUSTOMER_SERVICE);?>" class="helpHover" title="<?php echo HEADER_TITLE_HELP;?>"><?php echo HEADER_TITLE_HELP;?><ins></ins></a>
				<div class="helpcont helpcen">
					<p class="helplist"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=15');?>" title="<?php echo HEADER_TITLE_PAYMENT_METHODS;?>"><?php echo HEADER_TITLE_PAYMENT_METHODS;?></a></p>
					<p class="helplist"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=65');?>" title="<?php echo HEADER_TITLE_DISCOUNT_POLICY;?>"><?php echo HEADER_TITLE_DISCOUNT_POLICY;?></a></p>
					<p class="helplist"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=18');?>" title="<?php echo HEADER_TITLE_LEARNING_CENTER;?>"><?php echo HEADER_TITLE_LEARNING_CENTER;?></a></p>
					<p class="helplist"><a href="page.html?id=69" title="<?php echo HEADER_TITLE_DOWNLOAD_PICTURES;?>"><?php echo HEADER_TITLE_DOWNLOAD_PICTURES;?></a></p>
				</div>
			</li>
      		<li>|</li>
      		<li class="pleft"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'pagename=shipping_calculator');?>" title="<?php echo HEADER_TITLE_SHIPPING_CALCULATOR;?>"><?php echo HEADER_TITLE_SHIPPING_CALCULATOR;?></a></li>
		</ul>
	</div>
</div>
<!---- header_top end  ---->
