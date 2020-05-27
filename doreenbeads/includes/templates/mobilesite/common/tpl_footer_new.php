<h1 class="back-to-top"><a href="javascript:void(0);"><?php echo TEXT_BACK_TO_TOP;?><ins></ins></a></h1>
<footer>
  <!-- <div class="facebookcont"><a href="https://www.facebook.com/Doreenbeadscom" target="_blank"><h3 class="facebook"><?php echo FOOTER_LINE2_LIKE_FACEBOOK;?></h3></a></div> -->

  <div class="newsletter">
    <div class="subscribeform">
    <form name="subscribeSubmitForm" id="subscribeSubmitForm" onsubmit="return false;" >
      <div><input type="text" name="email_address" placeholder="<?php echo TEXT_SUBSCRIBE_FOR;?>" value="" id="subscribeinput"/></div>
      <input type="hidden" value="subscribe" name="action" >
      <input type="Submit" value="<?php echo ENTRY_NEWSLETTER_TEXT ?>" class="subscribesubmit"/>
    </form>
    </div>
    <div class="subscribenotice"></div>
  </div>


	<?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
	<p class="login-register"><?php echo TEXT_HI . ', ' . $_SESSION['customer_first_name'] . '&nbsp;(<a href="index.php?main_page=logoff">' . HEADER_TITLE_LOGOFF . '</a>)';?></p>
	<input type="hidden" class="isLogin" value="yes">
	<?php } else {?>
	<p class="login-register"><a href="index.php?main_page=login"><?php echo TEXT_LOGIN;?></a> <?php echo TEXT_OR;?> <a href="index.php?main_page=register"><?php echo TEXT_REGISTER;?></a></p>
	<?php } ?>

  <nav>
  	<a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>"><?php echo TEXT_CONTACT;?></a> |
    <a href="<?php echo zen_href_link(FILENAME_DEFAULT).'page.html?id=215';?>"><?php echo FOOTER_LINE2_DROP_SHIPPING_SERVICE;?></a> |
  	<a href="<?php echo zen_href_link(FILENAME_ABOUT_US)?>"><?php echo TEXT_ABOUT;?></a> |
  	<a href="<?php echo zen_href_link(FILENAME_HELP_CENTER)?>"><?php echo HEADER_TITLE_HELP;?></a> |
  	<a href="<?php echo 'http://www.' . BASE_SITE . ($_SESSION['languages_code'] == 'en' ? '' :  '/'. $_SESSION['languages_code']) . '/index.php?currency='.$_SESSION['currency']?>&ifpc=1"><?php echo TEXT_FULL_SITE;?></a> |
  	<a href="<?php echo zen_href_link(FILENAME_TESTIMONIAL)?>"><?php echo TEXT_TESTIMONIAL;?></a> |
  	<a href="<?php echo zen_href_link(FILENAME_PRIVACY)?>"><?php echo TEXT_PRIVACY;?></a> |
  	<a href="<?php echo zen_href_link(FILENAME_TERMS)?>"><?php echo TEXT_TERMS_CONDITIONS?></a>
  	
  
  	
  </nav>
  <p class="footer-bot-txt"><?php echo TEXT_ALL_RIGHTS;?></p>
</footer>

<div class="windowbg" style="display:none;"></div>
<div class="mainmenu" style="display:none;">
	<div class="side-nav">
	   <ul>
	     <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT, '');?>"><?php echo TEXT_HOME;?><span>&nbsp;</span></a></li>     
	     <li><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=new');?>"><?php echo TEXT_NEW_ARRIVALS;?><span>&nbsp;</span></a></li>
	     <li><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=promotion');?>"><?php echo TEXT_PROMOTION;?><span>&nbsp;</span></a></li>
	     <li><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=best_seller');?>"><?php echo TEXT_TOP_SELLER;?><span>&nbsp;</span></a></li>
	     <li><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=feature');?>"><?php echo TEXT_FEATURED_PRODUCTS;?><span>&nbsp;</span></a></li>
	     <li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP);?>"><?php echo TEXT_ALL_CATEGORIES;?><span>&nbsp;</span></a></li>
	     <li><a href="<?php echo zen_href_link(FILENAME_MYACCOUNT);?>"><?php echo HEADER_TITLE_MY_ACCOUNT;?><span>&nbsp;</span></a></li>
	   </ul>
	</div>
	<span class="menuclose"><?php echo TEXT_HEADER_MENU;?><ins></ins></span>
</div>