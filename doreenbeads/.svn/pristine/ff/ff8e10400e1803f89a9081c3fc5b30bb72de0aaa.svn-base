<div class="foot">
  <div class="foot_wrap">
    <div class="social_icons"> 
    	<a class="facebook" href="https://www.facebook.com/doreenbeads" rel="nofollow"></a> 
    	<a class="pinterest" href="https://www.pinterest.com/doreenbeads/" rel="nofollow"></a> 
    	<a class="twitter" href="https://www.youtube.com/c/Doreenbeadscom" rel="nofollow"></a> 
    	<a class="googleplus" href="https://plus.google.com/+Doreenbeadscom" rel="nofollow"></a>
      <div class="clearfix"></div>
    </div>
    <p><?php echo TEXT_SIGN_UP_FOR_NEW_ARRIVALS_AND_SALES;?></p>
    <div class="email_wrap">
      <form name="subscribeSubmitForm" id="subscribeSubmitForm" onsubmit="return false;" >
        <input type="Submit" class="mail_icon subscribesubmit" value="" name="submit" >
        <input type="hidden" value="subscribe" name="action" >
        <input type="email" value="" name="email_address" placeholder="<?php echo TEXT_SUBSCRIBE_FOR;?>" class="fgrey mail_input" id="subscribeinput">
      </form>
    </div>
  </div>
  <div style="height:50px;line-height:50px;margin:5px auto;border-bottom:1px solid #aaa;text-align:center;font-size:16px" class="jq_customer_info">
    <?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
      <p><?php echo TEXT_HI . ', ' . $_SESSION['customer_first_name'] . ' ! &nbsp;<a style="color: #3b5998;text-decoration: underline;" href="index.php?main_page=logoff">' . HEADER_TITLE_LOGOFF . '</a>';?></p>
    <?php }else{ ?>
      <p><a style="color: #3b5998;text-decoration: underline;" href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL');?>"><?php echo TEXT_SIGN_IN;?></a> <?php echo TEXT_OR;?> <a style="color: #3b5998;text-decoration: underline;" href="index.php?main_page=register"><?php echo TEXT_REGISTER;?></a></p>
    <?php } ?>
  </div>
  <div class="foot_site">
    <ul>
      <li><a href="<?php echo zen_href_link(FILENAME_ABOUT_US)?>"><?php echo TEXT_ABOUT;?></a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_MYACCOUNT)?>"><?php echo TEXT_MY_ACCOUNT;?></a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>"><?php echo TEXT_CONTACT;?></a></li>
	  <li><a href="<?php echo zen_href_link (FILENAME_WISHLIST); ?>"><?php echo TEXT_WISHLIST;?></a></li>
      <li><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER)?>"><?php echo TEXT_HELP_CENTER;?></a></li>
	  <!-- <li><a href="http://www.doreenbeads.com/index.php?main_page=invite_friends"><?php /* echo TEXT_INVITE_FRIENDS; */?></a></li> -->
      <li><a href="<?php echo 'http://www.'.  BASE_SITE . '/' . $_SESSION['languages_code'] . '/index.php?currency='.$_SESSION['currency']?>&ifpc=1"><?php echo TEXT_FULL_SITE;?></a></li>
      <div class="clearfix"></div>
    </ul>
    <p><?php echo FOOTER_LINE3_COMPANY_INFO;?></p>
  </div>
</div>
</div>

<div class="mobileDrawer">
	<a class="mobileDrawer_if bar_border" href="javascript:void(0);" id="footChangeLanguage"><p><?php echo $_SESSION ['lng']->language['name'];?></p></a>
 	<a class="mobileDrawer_if bar_border" href="javascript:void(0);" id="footChangeCuurency"><p><?php echo strtoupper($_SESSION ['currency']);?></p></a>
</div>

<a class="back_top back-to-top" href="javascript:void(0);"></a>

<?php 

/*
 <div class="side-nav">
   <ul>
     <li><a href="{$home_link.new_arrival}">{$smarty.const.TEXT_NEW_ARRIVALS}<span>&nbsp;</span></a></li>
     {if $home_link.promotion_status}
     <li><a href="{$home_link.promotion}">{$smarty.const.TEXT_PROMOTION}<span>&nbsp;</span></a></li>
     {/if}
     <li><a href="{$home_link.top_seller}">{$smarty.const.TEXT_TOP_SELLER}<span>&nbsp;</span></a></li>
    <!--  <li><a href="{$home_link.feature}">{$smarty.const.TEXT_FEATURED_PRODUCTS}<span>&nbsp;</span></a></li> -->
     <li><a href="{$home_link.site_map}">{$smarty.const.TEXT_ALL_CATEGORIES}<span>&nbsp;</span></a></li>
     <li><a href="{$home_link.my_account}">{$smarty.const.HEADER_TITLE_MY_ACCOUNT}<span>&nbsp;</span></a></li>
   </ul>
</div> 
 */
?>