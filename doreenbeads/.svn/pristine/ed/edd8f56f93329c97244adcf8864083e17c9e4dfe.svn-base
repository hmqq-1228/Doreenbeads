<?php 
include('includes/application_top.php');
?>
<script type="text/javascript">
$j(function(){
	$j('.consult').click(function(){
		$j('.windowbody').height($j(document).height()+'px').fadeIn();
		//re_pos('contactuscen');
		$j('#contactuscen').show();
	});

	$j('.contact_close, .windowbody').bind('click', function(){
		$j('#contactuscen, .windowbody').fadeOut();
	});
	$j('#float_searchinput').focus(function(){
		var va=$j(this).val();
		if(va == $lang.errEnterKeywords){
		  $j(this).val('');	
				}else{
		  $j(this).val();
			}	
    }).blur(function(){
		var va=$j(this).val();
		if(va == ""){
		  $j(this).val($lang.errEnterKeywords);	
				}else{
		  $j(this).val();
			}
		setTimeout("$j('.searchlist').hide();", 200);
    })

    function float_checkSearchForm(text){
		var input_text = $j.trim($j('#float_searchinput').val());
		input_text = inputtext.replace(/(^\s*)|(\s*$)/g, "");
	    input_text = inputtext.replace(/&/g, "");
		if(input_text == '' || inputtext == text){
			alert($lang.ErrorPleaseKeyword);
			return false;
		}
		$j('#float_searchinput').val(input_text);
		return true;
	}
});
</script>
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
    <!--<div id="logo">
		<?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'logo1.jpg', '', '', '', 'usemap="#logomap"' );?>
		<map id="logomap" name="logomap">
		 <area style="outline: none;" shape="rect" coords="3,3,243,46" href="<?php echo zen_href_link(FILENAME_DEFAULT);?>" />
          <area style="outline: none;" shape="rect" coords="5,51,243,69" href="/page.html?id=159" />

		</map>
	</div>-->
    <div id="logo_new">
        <div class="logo" style="float:left;">
            <a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'logo1.jpg' );?></a>
            <p class="font14"><a href="<?php echo HTTP_SERVER;?>/page.html?id=159"><?php echo TEXT_LOGO_TITLE;?></a></p>
            <!--WEBSITE_SUCCESS-->
        </div>
    </div>

    <div id="search">


        <form action="index.php?main_page=advanced_search_result" name="quick_find" method="get" onsubmit="return float_checkSearchForm('<?php echo HEADER_SEARCH_DEFAULT_TEXT; ?>')">
            <input type="hidden" name="main_page" value="<?php echo FILENAME_ADVANCED_SEARCH_RESULT;?>">
            <input style="width:290px;" type="text" id="float_searchinput" name="keyword" value="<?php echo (isset($_GET['keyword']) && $_GET['keyword'] != '' ? $_GET['keyword'] : HEADER_SEARCH_DEFAULT_TEXT);?>" onkeyup="lookup(this.value,event,<?php echo $_SESSION['languages_id'];?>);" autocomplete="off" />
            <ul class="searchlist" id="autoSuggestionsList"></ul>
            <?php
            //echo zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
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
        //$_SESSION['cart']->calculate();
        $shopping_cart_items = (isset($_SESSION['count_cart']) ? $_SESSION['count_cart'] : $_SESSION['cart']->get_products_items());
        ?>
        <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');?>">
            <div class="addcart <?php echo $shopping_cart_items>0 ? 'hasitem' : 'hasnoitem';?>"><span class="spanr" style="margin-top:11px;"><span id="count_cart"><?php echo $shopping_cart_items;?></span> <?php echo HEADER_CART_ITEM;?><br/><span id="header_cart_total"></span></span></div></a>
        <div class="addcartcontwrap">
            <div class="addcartcont">

            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    <!-- eof cart content -->

</div>
<!---- header_logo end ---->