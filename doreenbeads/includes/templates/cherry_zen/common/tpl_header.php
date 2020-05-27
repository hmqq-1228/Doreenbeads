<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_header.php 4813 2006-10-23 02:13:53Z drbyte $
 */
?>
<script type="text/javascript">
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
	if(getCookie("generatepop")!="true"){
		if(document.getElementById('holidaynote')) document.getElementById('holidaynote').style.display = 'none';
	}
}
	$j(document).ready(function(){
		generatepopup();
		<?php 		
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false )
			{?>
			ieSix_select();
				<?php 
			}?>
		});
</script>
<!--<div id="holidaynote" style="background-color: rgb(254, 255, 239); font-size: 13px; font-family: Arial;  width: 1002px; margin: 5px auto; display: none;"><?php echo TEXT_NOTE_HOLIDAY_NOTE;?>
</div>-->

<div id="holidaynote" style="font-family: Arial; font-size:14px; width:920px; background:#fff; margin: 0px auto; border: 0; line-height:26px;display:none;">
<div style="float:left;width:10px">&nbsp;</div>
<div  style="font-family: Arial; font-size:14px; width:905px;  background:#feeaeb; margin: 0px -33px; border: 1px solid #e0e8d6; line-height:26px; padding:20px 40px;color:#333;" >
	<img src="includes/templates/cherry_zen/images/warmclose.gif" width="11" height="12" style="float:right;cursor:pointer;margin-left:10px;" onclick="noteclose();">	
    <h3 style="margin:0px; text-align:center; display:block;">Holiday Notice</h3>
    <strong style="color:#888;padding-left:20px">Dear Customer,</strong>
    <p style="margin:0px; padding:10px 10px 0 20px;">Happy Chinese New Year!</p>
<p style="margin:0px; padding:5px 10px 0 20px;">We are not in the office from <font color="#8c221a"> Feb.6th to Feb.16th (PST)</font>. During this period,<strong> you can place order as usual</strong>. The packages will be <br/>shipped as soon as we come back, following the rule of "first-in, first-out". 
Most of orders can be processed within 3-5 days.</p>
   <p style="margin:0px; padding:5px 10px 0 20px;"> If you have urgent question, you can always contact your old friend Linden via email or phone listed below:</p>
    
    <p style="margin:0px; padding:10px 10px 0 20px;"><font color="#e92219"><u>Linden.lin@8seasons.com</u><br/>(86)13615890272</font></p>
    <strong style="display:block; color:#888;padding:5px 20px">Best Regards,<br/>Doreenbeads Team</strong>
</div>
</div>

<!--bof-header logo and navigation display-->
<div id="LIZ_overlay" class=""><div id="show_image" class="calc_shipping_img"><img src="includes/templates/cherry_zen/images/zen_lightbox/loadings.gif"></div></div>
<iframe id="LIZ_iframelay" class="hidden_iframe" width="0" height="0"></iframe>
<?php
include(DIR_WS_MODULES . zen_get_module_directory('ezpages_bar_header.php'));
/*jessa 2009-08-17 add*/
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>
<!-- divs for drop shadow -->
<div id="nw"><div id="ne"><div id="se"><div id="sw"><div id="n"><div id="s"><div id="w"><div id="e"><div id="main">
<table id="workaround"><tr><td>

   <div id="headerWrapper">
      <!--bof-navigation display-->
      <div id="navMainWrapper">
<?php
/*jessa 2009-09-03 去掉这些代码
        <div id="navMainSearch">
          <?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?>
        </div>
eof jessa 2009-09-03
*/
?>
<!--jessa 2009-09-03 在网页顶端添加相关导航,2009-08-18日所改的导航不实用，现在重新改过-->
<div id="topnavMain">
        <ul>

		
<!--jessa 2009-09-07 添加下面的导航，根据supplies网站的导航添加相关的导航。此导航有待改进！！-->
		    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=162">'; ?><span>About Us</span></a></li>
			<li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=page&id=18">'; ?><span>Learning Center</span></a></li>
			<li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=testimonial">'; ?><span>Testimonials</span></a></li>
<!--eof jessa 2009-09-07-->


			<li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
			<li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US, '', 'SSL'); ?>" class="lasts"><?php echo 'Contact Us'; //jessa 2009-08-20 给contact us添加链接?></a></li>
		</ul>
</div>
<!-- eof jessa 2009-09-03 -->

<!--jessa 2009-08-12 删除了顶端的导航条内容，将其放在后面！-->
<?php
/*
<div id="navMain">
          <ul>
            <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><span><?php echo HEADER_TITLE_CATALOG; ?></span></a></li>
            <?php if ($_SESSION['customer_id']) { ?>
            <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><span><?php echo HEADER_TITLE_LOGOFF; ?></span></a></li>
            <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><span><?php echo HEADER_TITLE_MY_ACCOUNT; ?></span></a></li>
            <?php
      } else {
        if (STORE_STATUS == '0') {
?>
            <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><span><?php echo HEADER_TITLE_LOGIN; ?></span></a></li>
            <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><span><?php echo HEADER_TITLE_MY_ACCOUNT; ?></span></a></li>
            <?php } } ?>
            <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><span><?php echo HEADER_TITLE_CART_CONTENTS; ?></span></a></li>
            <li><a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><span class="last"><?php echo HEADER_TITLE_CHECKOUT; ?></span></a></li>
          </ul>
        </div>
eof jessa */
?>
<!--eof jessa-->
      </div>
      <!--eof-navigation display-->
      <!--bof-branding display-->
      <div id="logoWrapper" class="clearfix">
        <div id="logo"><?php echo '<a href="http://www.doreenbeads.com/page.html?id=159"><img src="http://www.doreenbeads.com/promotion_photo/images/20130704/logo.jpg" usemap="#Map" /><map name="Map" id="Map"><area shape="rect" coords="0,0,206,87" href="'.HTTP_SERVER.'" /></map></a>'; ?></div>
        <?php if (HEADER_SALES_TEXT != '' || (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2))) { ?>
        <div id="taglineWrapper">

          <?php
              if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
                if ($banner->RecordCount() > 0) {
?>
          <div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner);?></div>
          <?php
                }
              }
?>
        </div>
        <?php } // no HEADER_SALES_TEXT or SHOW_BANNERS_GROUP_SET2 ?>	
<!--jessa 2009-11-03 添加phplive代码-->
 <?php 
          if(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=''){
          	$get_email = $db->Execute('Select  	customers_email_address,customers_firstname,customers_lastname
								     From ' . TABLE_CUSTOMERS . ' 
								  Where  customers_id = ' . $_SESSION['customer_id']);
          	$url_email=$get_email->fields['customers_email_address'];
          	//$uname=$get_email->fields['customers_firstname'].' '.$get_email->fields['customers_lastname'];
          }else{
          	$url_email='';
          	//$uname='';
          }
        ?>
<div id="live_help_image"><!-- BEGIN PHP Live! code, (c) OSI Codes Inc. -->
<script>
function set_phplive(){
	var srcCode = '<script language="JavaScript"  src="<?php echo HTTP_LIVECHAT_URL;?>/js/status_image.php?langs=<?php echo $_SESSION["language"]?>&uname=<?php echo $_SESSION['customer_first_name'];?>&uemail=<?php echo $url_email;?>&base_url=http://72.14.190.244/dblivehelp&l=Doreenbeads.com&x=1&deptid=1&"><\/script>';
	document.write(srcCode);
	}

  document.ready=set_phplive();
</script>
<!-- END PHP Live! code : (c) OSI Codes Inc. -->
<br><span id="mailto_address">Email:<a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a></span>
<a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=104'); ?>" target="_blank">
					3% RCD Code
				</a></div>

<!--<div id="live_help_image"><script language="JavaScript" src="http://www.doreenbeads.com/phplivefinal/js/status_image.php?base_url=http://www.doreenbeads.com/phplivefinal&l=DoreenBeads.com&x=1&deptid=1&"><a href="http://www.phplivesupport.com"></a></script><br><span id="mailto_address">Email:<a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a></span></div>-->
<!--eof jessa 2009-11-03-->
<!--jessa 2009-08-18 将checkout用图片代替-->
<div id="checkoutimg"><a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"></a></div>
<!-- eof jessa 2009-08-18 -->

<!--jessa 2009-08-17 add the following code -->
<!--添加这段代码目的是为了将导航栏home后的导航目录放在logo后面，在home后面将会添加其它内容-->

<!--bof___________________________________________________________________________________________-->
<div id="logoright">
        <li style="list-style-position:outside; line-height:100%;">
			<?php if ($_SESSION['customer_id']) { ?>
			Welcome <a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><span><b><?php echo $_SESSION['customer_first_name'];?></b></span></a>
			<br />[<a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><span><?php echo HEADER_TITLE_LOGOFF; ?></span></a>]
			<?php }else{ ?>
				<a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><span>Log In/Register</span></a>
			<?php } ?>
		</li>
			 <?php 
			  	if ($_SESSION['customer_id']) {
		           		$customer_group = $db->Execute('Select group_name From ' . TABLE_GROUP_PRICING . ', ' . TABLE_CUSTOMERS . '
		           										Where customers_group_pricing = group_id 
		           										
		           										and customers_id = ' . $_SESSION['customer_id']);
		           		if ($customer_group->RecordCount() == 0) {
		           			$ls_customer_group = HEADER_TITLE_NORMAL;
		           		}
		           		else{
		           			$ls_customer_group = $customer_group->fields['group_name'];
		           		}
		           
		           echo '<li>'.HEADER_TITLE_VIP_LEVEL.' [<a href = "'.HTTP_SERVER.(($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/index.php?main_page=account">' . $ls_customer_group . '</a>]</li>';
			  	}
			  ?>
			 
		<li style="list-style-position:outside; line-height:100%;">
			<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL'); ?>"><span><?php echo HEADER_TITLE_CART_CONTENTS; ?></span></a>
			[<span id="count_cart"><?php echo $_SESSION['cart']->get_products_items(); ?></span>&nbsp;Items]
		</li>
		  <!--jessa 2010-09-01 在网站头部增加wishlist链接-->
		  <?php
			  $check_product_wishli_num = $db->Execute("select count(wl_products_id) as wishicount from ".TABLE_WISH." where  wl_customers_id = " . (int)$_SESSION['customer_id']." limit 1");
	   		  if(intval($check_product_wishli_num->fields["wishicount"]) > 0){
	   		  	 $wishlist_num = intval($check_product_wishli_num->fields["wishicount"]);
	   		  }else{
	   		  	$wishlist_num = 0;
	   		  }
		  echo '<li style="list-style-position:outside; line-height:130%;"><a href="' . zen_href_link('wishlist') . '">Wishlist Products</a><font style="font-weight:normal;">&nbsp;[<lable sytle="dispaly:black;" id="count_wishlist_new">'.$wishlist_num.'</lable>&nbsp;Items]</font></li>'; ?>
		  <!--jessa 2010-09-01 头部增加wishlist链接完成-->		   
		</div>
<!-- eof jessa -->

      </div>
      <!--eof-branding display-->
      <!--eof-header logo and navigation display-->
      <!--bof-optional categories tabs navigation display-->
      <?php //require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
      <!--eof-optional categories tabs navigation display-->
      <!--bof-header ezpage links-->
      <?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
      <?php require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
      <?php } ?>
      <!--eof-header ezpage links-->
    </div>
    <?php }?>
