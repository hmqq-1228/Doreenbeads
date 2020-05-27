<!---- header_logo start ---->
<?php if(date('Y-m-d H:i:s') >= '2015-09-24 16:00:00' && date('Y-m-d H:i:s') < '2015-10-04 18:00:00') {?>
    <div id="holidaynote" style="font-family: Arial; font-size:14px; width:920px; background:#fff; margin: 0px auto; border: 0; line-height:26px;">
        <div style="float:left;width:10px">&nbsp;</div>
        <div  style="font-family: Arial; font-size:14px; width:905px;  background:#feeaeb; margin: 0px -33px; border: 1px solid #e0e8d6; line-height:26px; padding:20px 40px;color:#333;" >
            <img src="includes/templates/cherry_zen/images/warmclose.gif" width="11" height="12" style="float:right;cursor:pointer;margin-left:10px;" onclick="noteclose();">
            <?php
            if (date('Y-m-d H:i:s') >= '2015-09-24 16:00:00' && date('Y-m-d H:i:s') < '2015-09-29 18:00:00'){
                echo TEXT_NOTE_HOLIDAY_5;
            } else {
                echo TEXT_NOTE_HOLIDAY_6;
            }
            ?>
        </div>
    </div>
<?php }?>
<div class="header_logo">
    <div id="logo_new">
        <div class="logo" style="float:left;">
            <a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'logo1.png' );?></a>
            <p class="font14"><a href="<?php echo HTTP_SERVER;?>/page.html?id=159"><?php echo TEXT_LOGO_TITLE;?></a></p>
            <!--WEBSITE_SUCCESS-->
        </div>
    </div>

    <div id="search">
        <form action="index.php?main_page=advanced_search_result" name="quick_find" method="get" onsubmit="return checkSearchForm('<?php echo HEADER_SEARCH_DEFAULT_TEXT; ?>')">
            <input type="hidden" name="main_page" value="<?php echo FILENAME_ADVANCED_SEARCH_RESULT;?>">
            <input style="width:290px;" type="text" id="searchinput" name="keyword" value="<?php echo (isset($_GET['keyword']) && $_GET['keyword'] != '' ? $_GET['keyword'] : HEADER_SEARCH_DEFAULT_TEXT);?>" onkeyup="lookup(this.value,event,<?php echo $_SESSION['languages_id'];?>);" autocomplete="off" />
            <ul class="searchlist" id="autoSuggestionsList"></ul>
            <?php
            echo zen_draw_hidden_field('inc_subcat', '1');
            echo zen_draw_hidden_field('search_in_description', '1');
            echo zen_draw_hidden_field('add_report', '1');
            ?>
            <input type="submit" value="<?php echo BOX_HEADING_SEARCH;?>"/>
        </form>
    </div>

    <div class="consult">
        <a rel="nofollow" href="javascript:void(0);"><?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'help.png' );?></a>
    </div>
    <!-- bof cart content -->
    <div class="fright cartcontent">
        <?php
        $shopping_cart_items = ($_SESSION['count_cart'] > 999  ? '999+': $_SESSION['cart']->get_products_items());
        ?>
        <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');?>">
            <div class="addcart <?php echo $shopping_cart_items>0 ? 'hasitem' : 'hasnoitem';?>"><span class="spanr" style="margin-top:11px;"><span id="count_cart"><?php if($shopping_cart_items > 999){echo '999+';}else{
                            echo $shopping_cart_items; }?></span> <?php echo HEADER_CART_ITEM;?><br/><span id="header_cart_total"></span></span></div></a>
        <div class="addcartcontwrap">
            <div class="addcartcont">

            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <!-- eof cart content -->

</div>

<!---- header_logo end ---->

<!---- menuNav start   ---->
<div class="menuNav">
    <ul class="menuNavcen">
        <li class="<?php echo ($_GET['main_page'] == FILENAME_PRODUCTS_COMMON_LIST && $_GET['pn'] == 'new' ? 'current' : '');?>"><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=new&products_filter_in_stock=1');?>"><?php echo HEADER_MENU_NEW_ARRIVALS;?></a></li>

        <?php
        if(date('Y-m-d') < '2019-02-01' || date('Y-m-d') > '2019-02-10'){
            if($_SESSION['languages_id'] == 1){
                ?>
                <li class="<?php echo ($_GET['main_page'] == 'page' && $_GET['id'] == 221 ? 'current' : '');?>"><a href="<?php echo HTTP_SERVER.'/en/page.html?id=226'; ?>"><?php echo TEXT_SHIPPING_FROM_USA;?></a><span class="icon_head_hot"></li>
                <?php
            }
        }
        ?>
        <li class="clearancemore <?php echo $_GET['pn']=='subject'&&$_GET['aId']==1? 'current' : '';?>"><a href="<?php echo HTTP_SERVER.'/'.($_SESSION['languages_code'] == 'en' ? '' : $_SESSION['languages_code'] . '/')?>subject/small-packs-ai-1.html"><?php echo HEADER_SMALL_PACK;?></a></li>

        <?php if(false && date('Y-m-d H:i:s')<='2015-04-15 15:00:00' ){ ?>
            <li class="clearancemore <?php echo (in_array($_GET['cPath'], array('2066_2427')) ? 'current' : '');?>"><a href="<?php echo HTTP_SERVER.'/'?>small-packs-c-2066_2427.html"><?php echo HEADER_CLOTHING;?><!-- <img src="includes/templates/cherry_zen/images/sale.gif" class="clearsale"> --></a></li>
        <?php } ?>
        <?php if($_SESSION['languages_id'] != 1 && $_SESSION['languages_id'] != 4) { ?>
            <?php if($_SESSION['languages_id']==3) { ?>
                <li class="<?php echo ($_GET['main_page'] == 'page' || $_GET['main_page'] == 'help_center') && $_GET['id'] == 181 ? " current" : '';?>"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=181');?>">Доставка</a></li>
            <?php }else{ ?>
                <li class="<?php echo ($_GET['main_page'] == FILENAME_PRODUCTS_COMMON_LIST && $_GET['pn'] == 'mix' ? 'current' : '');?>"><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=mix');?>"><?php echo HEADER_MENU_MIX;?></a></li>
            <?php } ?>
        <?php } ?>
        <li <?php echo $_GET['main_page'] == 'help_center' && $_GET['id'] == 65 ? 'class="current"' : '';?>><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .($_SESSION['languages_code'] == 'en' ? '' : $_SESSION['languages_code'] . '/') . 'index.php?main_page=help_center&id=65">'; ?><?php echo HEADER_MENU_DISCOUNT_POLICY;?></a></li>

        <?php
        if(!$is_promotion_price_time || (date('Y-m-d',time()) != '2016-02-14') || (date('Y-m-d',time()) != '2016-02-15') ){?>
            <li style="display:none;" <?php echo $_GET['main_page'] == 'who_we_are' && $_GET['id'] == 162 ? 'class="current"' : '';?>><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=162">'; ?><?php echo HEADER_MENU_ABOUT_US;?></a></li>
        <?php } ?>
        <li class="<?php echo ($_GET['main_page'] == 'promotion_display_area' ? 'current' : '');?>"><a href="<?php echo zen_href_link(FILENAME_PROMOTION_DISPLAY_AREA);?>"><?php echo PROMOTION_DISPLAY_AREA;?></a></li>
        <!--<li class="<?php echo ($_GET['main_page'] == FILENAME_PROMOTION_PRICE ? ' class="current"' : '');?>""><a href="<?php echo zen_href_link(FILENAME_DEFAULT).'page.html?id=216';?>"><?php echo HEADER_CHRISTMAS;?></a></li>-->
        <li class="<?php echo ($_GET['main_page'] == 'page' && $_GET['id'] == 218 ? 'current' : '');?>"><a href="<?php echo HTTP_SERVER.'/'.($_SESSION['languages_code'] == 'en' ? '' : $_SESSION['languages_code'] . '/').'page.html?id=218'; ?>"><?php echo IMAGE_NEW_CATEGORY;?></a><span class="icon_head_new"></span></li>
        <li class=""><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .($_SESSION['languages_code'] == 'en' ? '' : $_SESSION['languages_code'] . '/') . 'index.php?main_page=products_common_list&pn=subject&aId=297">'; ?><?php echo IMAGE_ONEOFF_PRICE;?></a></li>
    </ul>
</div>
<!---- menuNav end     ---->

<?php

$countdown_info_query= " select * from ".TABLE_PROMOTION_COUNTDOWN." where languages_id=".$_SESSION['languages_id']." ";
$countdown_info= $db->Execute($countdown_info_query);
$prom_status = $countdown_info->fields['countdown_status'];
$prom_start_date = strtotime($countdown_info->fields['countdown_startdate_month']);
$prom_end_date = strtotime($countdown_info->fields['countdown_finishdate_month']);
$current_time=time();

if(!$this_is_home_page || ($this_is_home_page && $countdown_info->fields['show_in_homepage'])){
    if($prom_status  && $current_time>$prom_start_date && $current_time<$prom_end_date){
        require(DIR_WS_TEMPLATE.'/common/tpl_promotion_countdown.php');
    }else{
        if($countdown_info->fields['show_promotion_status']){
            $define_promotion_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PROMOTION, 'false');
            require($define_promotion_page);
        }
    }
}

?>