<div class="foot">
<div class="clearfix"></div>
<div class="cart_footer">
    <p class="footer_login jq_customer_info">
        <?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') { ?>
        <?php echo TEXT_HI . ', ' . $_SESSION['customer_first_name'] . ' ! &nbsp;<a class="link_color" href="index.php?main_page=logoff">' . HEADER_TITLE_LOGOFF . '</a><br/>';?>
        <?php }else{ ?>
        <a class="link_color" href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL');?>"><?php echo TEXT_SIGN_IN;?></a> <?php echo TEXT_OR;?> <a class="link_color" href="index.php?main_page=register"><?php echo TEXT_REGISTER;?></a>
        <?php } ?>
    </p>
    <p class="conpany_info"><?php echo FOOTER_LINE3_COMPANY_INFO;?></p>
</div>

</div>
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