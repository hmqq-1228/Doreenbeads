<?php
/**
 * Common Template - tpl_footer.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_footer.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_footer = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 4821 2006-10-23 10:54:15Z drbyte $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>
</td></tr></table></div></div></div></div></div></div></div></div></div>
<style type="text/css">
#bottom_keywords{
	list-style-type:none;	
}

.footer_key_word{
  color:#585550;
   font-size:9px;
   line-height:15px;
}
.footer_key_word a{
	color:#585550;
}

<!--

-->
</style>
<!--closting divs for drop shadow -->
<?php
if (!isset($flag_disable_footer) || !$flag_disable_footer) {
?>
<!--bof-navigation display -->
<?php
/*
<div id="navSuppWrapper">
<div id="navSupp">
<ul>
<li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
<?php if (EZPAGES_STATUS_FOOTER == '1' or (EZPAGES_STATUS_FOOTER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
<li><?php require($template->get_template_dir('tpl_ezpages_bar_footer.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_footer.php'); ?></li>
<?php } ?>
</ul>
</div>
</div>
<!--eof-navigation display -->
*/
?>

<!--bof-ip address display -->
<?php
//jessa 2009-08-09
//delete the following code between /* and */
/*if (SHOW_FOOTER_IP == '1') {
?>
<div id="siteinfoIP"><?php echo TEXT_YOUR_IP_ADDRESS . '  ' . $_SERVER['REMOTE_ADDR']; ?></div>
<?php
}
*/
//eof jessa
?>
<!--eof-ip address display -->

<!--bof-banner #5 display -->
<?php
  $back_top_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
  if (strstr($back_top_url, '?')){
  	$back_top_url = substr($back_top_url, 0, strpos($back_top_url, '?'));
  }
?>
<?php if ($this_is_home_page){ ?>
<?php } ?>
<?php
  if (SHOW_BANNERS_GROUP_SET5 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET5)) {
    if ($banner->RecordCount() > 0) {
?>
<div id="bannerFive" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
    }
  }
?>
<!--eof-banner #5 display -->
<div style="clear:both; width:800px; margin:8px auto; border:1px solid #B67DB0; padding:8px 10px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="18%"><p><strong>Company Info</strong></p>
      <ul style="padding:0px; margin:0px; list-style:inside circle;">
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=17'); ?>">About Us </a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=64'); ?>">Latest News</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=52'); ?>">QC Department</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=65'); ?>">Discount Policy</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=9'); ?>">Privacy Policy </a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_SITE_MAP); ?>">Site Map</a></li>
		<li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=106'); ?>">Intellectual Property Infringement Policy</a></li>
		<li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=157'); ?>">Terms and Conditions</a></li>
      </ul>
    </td>
    <td width="18%" valign="top"><p><strong> Help </strong></p>
      <ul style="padding:0px; margin:0px; list-style:inside circle;">
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=21'); ?>">FAQ</a> </li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>">Contact Us </a></li>
        <li style="padding-top:5px;"><a href="mailto:sale@doreenbeads.com">Email Us </a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=16'); ?>">How to order</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=54'); ?>">Shopping Guide </a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=18'); ?>">Learning Center</a></li>
      </ul>
    </td>
    <td width="18%" valign="top"> <p><strong>Ordering </strong></p>
      <ul style="padding:0px; margin:0px; list-style:inside circle;">
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_LOGIN); ?>">Login/Register</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT); ?>">My Account</a> </li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=46'); ?>">Track my order</a> </li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=15'); ?>">Payment Methods</a> </li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_SHIPPING); ?>">Shipping &amp; Return </a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_SHIPPING_CALCULATOR); ?>">Shipping Calculator </a></li>
      </ul>
    </td>
    <td width="18%" valign="top"><p><strong>Community </strong></p>
      <ul style="padding:0px; margin:0px; list-style:inside circle;">
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_TESTIMONIAL); ?>">Testimonial</a> </li>
        <li style="padding-top:5px;"><?php echo '<a href="' . HTTP_SERVER.'/'.'links-exchange-jewelry-directory.html' . '">'.'Links Exchange'.'</a>'; ?></li>
      </ul>
    </td>
    <td width="28%" valign="top"><p><strong>Featured Service</strong></p>
      <ul style="padding:0px; margin:0px; list-style:inside circle;">
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=79'); ?>">Business Card Printing</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=67'); ?>">Quick Browse Function</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=76'); ?>">Lead-Safe Guaranteed</a></li>
        <li style="padding-top:5px;"><a href="<?php echo zen_href_link(FILENAME_NO_WATERMARK_PICTURE); ?>">Free Non-watermarked Picture</a> </li>
      </ul>      
    </td>
  </tr>
</table>
</div>
<!--bof- site copyright display -->
<div id="siteinfoLegal" class="legalCopyright">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td width="20%" class="footer_address_left">
    
    
    </td>
    <td width="32%" class="footer_address">
		<strong>Address: </strong>#399 Jiang Bin Xi Road, Yiwu,Zhejiang 322000 P.R.C.<br /><br />
	    <strong>ZipCode: </strong> 322000	
    </td>
    <td width="30%" class="footer_tel">
		<strong>Tel:</strong> (+86) 579-85335690<br /><br />
		<strong>Fax:</strong>（+86）579-85261619<br /><br />
	    <strong>Mail:</strong> sale@doreenbeads.com	
	</td>
	 <td width="25%" class="hankers">
			</td>
    
  </tr>

   <tr id="foot_image">
    <td  colspan="4" align="center">
      
		<a class="paypal" onclick="javascript:window.open('https://www.paypal.com/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','olcwhatisPayPal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');" href="#this" title="PayPal">
        <img src="images/logos/paypal_243x40.png" style="vertical-align:middle;" height="40" /></a>
		<img src="<?php echo HTTP_SERVER . '/' . DIR_WS_IMAGES . 'logos/footer_wu.gif'; ?>" border="0"  height="40" width="120" style="vertical-align:middle;"/>
		<img src="<?php echo HTTP_SERVER . '/' . DIR_WS_IMAGES . 'logos/footer_boc.gif'; ?>" border="0"  height="39"  style="vertical-align:middle;"/>
		<img src="<?php echo HTTP_SERVER . '/' . DIR_WS_IMAGES . 'logos/ups.png'; ?>" border="0" height="40" style="vertical-align:middle;"/>
		<img src="<?php echo HTTP_SERVER . '/' . DIR_WS_IMAGES . 'logos/ems.png'; ?>" border="0" height="30" width="80" style="vertical-align:middle;"/>
	    <img src="<?php echo HTTP_SERVER . '/' . DIR_WS_IMAGES . 'logos/dhl.png'; ?>" border="0" height="30" width="90" style="vertical-align:middle;"/>
	    <img src="<?php echo HTTP_SERVER . '/' . DIR_WS_IMAGES . 'logos/as_audited_supplier_m.gif'; ?>" border="0" height="40" style="vertical-align:middle;"/>
	 
	</td>
  </tr>
  
  <tr>
  	<td colspan="4" align="center"> <br/><br/>CopyRight 2002 -2013 Yiwu Xiage Trading Co., Ltd. China Wholesale Beads. All rights reserved</td>  	  	
  </tr>

</table>
</div>
<!--eof- site copyright display -->
<style>

</style>
<SCRIPT language=JavaScript type=text/javascript>
$j(document).ready(function() {
	$j('<a href="<?php echo $_SERVER['REQUEST_URI']; ?>" id="gotop"></a>').appendTo('body').hide().click(function() {
		$j(document).scrollTop(0);
		$j(this).hide(200);
		return false
		});

	var gotops = $j('#gotop');
	function backTopLeft() {
	var btLeft = $j(window).width() / 2 + 495;
	if (btLeft <= 990) {
	gotops.css({
	'left': ($j(window).width()-45)
	})
	} else {
	gotops.css({
	'left': (btLeft+13)
	})
	}
	}
	backTopLeft();
	$j(window).resize(backTopLeft);
	$j(window).scroll(function() {
	if ($j(document).scrollTop() === 0) {
	gotops.hide(200)
	} else {
	gotops.show(200)
	}
	if ($j.browser.msie && $j.browser.version == 6.0 && $j(document).scrollTop() !== 0) {
	gotops.css({
	'opacity': 1
	})
	}
	});
})
</SCRIPT>
<?php
}// flag_disable_footer
$define_seo_part = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_SEO_PART, 'false'); 
?><div id="seopart"><?php //require($define_seo_part);?></div> 