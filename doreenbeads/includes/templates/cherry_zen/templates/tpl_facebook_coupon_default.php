<!--
	<div class="coupon1125">
    	<div class="banner">
        	<div class="banner_inner">
            	<div><?php echo TEXT_COUPON_CODE; ?><input id="coupon_code" type="text" value="FBCP20141126" /><a hef="javascript:;" id="copy_btn"><?php echo TEXT_COPY_CODE; ?></a></div>
            	<p class="noinline"><?php echo TEXT_SHARE_COUPON; ?></p>
            </div>
        </div>
        
        <div class="step">
        	<h3><?php echo TEXT_HOW_TO_ADD_AND_USE_THE_COUPON; ?></h3>
            <div id="step1_img"></div>
            <h3><?php echo TEXT_POLICIES; ?></h3>
            <p>
            	<?php echo TEXT_FACEBOOK_NOTICE; ?>      
                <?php echo TEXT_NEW_CUSTOMER_HERE; ?><a class="register" target="_blank" href="<?php echo zen_href_link(FILENAME_LOGIN)?>"><?php echo TEXT_REGISTER_NOW; ?></a><br />
                <?php echo TEXT_ALREADY_REGISTERED; ?><a class="addcoupon" target="_blank" href="<?php echo zen_href_link(FILENAME_MY_COUPON)?>"><?php echo TEXT_ADD_COUPON_NOW; ?></a><br />
            </p>
            <h3><?php echo TEXT_WARM_NOTICES; ?></h3>
            <p>
            	<?php echo TEXT_WARM_NOTICES_CONTENT; ?>
            </p>
        </div>
    </div>
-->
<?php
	$define_facebook_coupon = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', 'define_facebook_coupon.php', 'false');		
	require($define_facebook_coupon);
?>

