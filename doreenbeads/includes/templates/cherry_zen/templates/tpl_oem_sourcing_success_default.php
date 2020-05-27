<div class="wrap sourcing">
	<!-- 头部开始 -->
	<div id="header" style="padding: 0;">
	<?php echo '<input type="hidden" id="c_lan" value="'.$_SESSION['language'].'">';?>
		<div id="logo_new">
          <div class="logo" style="float:left;">
            <a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'logo1.jpg' );?></a>
            <p class="font14"><a href="<?php echo HTTP_SERVER;?>/page.html?id=159"><?php echo TEXT_LOGO_TITLE;?></a></p>
            <!--WEBSITE_SUCCESS-->
          </div>
        </div>
		<div class="clearfix"></div>
		<p style="font-size:0.55em"></p>
	</div>	
	<!-- 头部结束 -->	
    <div class="sourcing_header <?php echo $_SESSION['languages_code'];?>">
    	<h2><?php echo TEXT_OEM_AND_SOURCING_PRO;?></h2>
    </div>
	<div class="success_info">
		<h2><ins></ins><p><strong><?php echo TEXT_SUBMIT_SUCCESS;?></strong><span><?php echo TEXT_TKS_FOR_YOUR_INQUIRY;?></span><span><?php echo TEXT_HAVE_QUESTION_CONTACT_US;?></span></p></h2>
		<h2 class="font_verdana next_choose"><p><strong><?php echo TEXT_NOW_YOU_CAN;?></strong><a class="fblue" href="<?php echo zen_href_link(FILENAME_OEM_SOURCING)?>"><i>-</i> <?php echo TEXT_ADD_ANOTHER_SOURCING;?></a><br /><a class="fblue" href="<?php echo zen_href_link(FILENAME_DEFAULT)?>"><i>-</i> <?php echo TEXT_GO_SHOPPING;?></a></p></h2>
	</div>
	<div class="recommend_window">
		<h3 class="font20"><?php echo TEXT_YOU_MAY_PREFER_TO_START_FROM_HERE;?></h3>
		<div class="search_error_banner">
			<?php require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_OEM_SOURCING_SUCCESS, 'false'));?>					
			<div class="clearfix"></div>
		</div>
	</div>
</div>
