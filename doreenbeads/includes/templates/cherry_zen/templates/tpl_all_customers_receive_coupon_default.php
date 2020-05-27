<style type="text/css">
.coupon2019{
	width:766px; overflow:hidden;
	background:#f2ecf6;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#444;
}
.coupon2019 img{ border:none; vertical-align:top;}
.coupon2019 .icon{ background:url(images/img_03.gif) 20px 10px no-repeat;}
.coupon2019 .ny_warning{ border:#ddd9df 2px solid; background:#fff; padding:15px 20px 7px 20px; margin:0 33px 20px 33px;}
.coupon2019 .ny_warning h3{ font-size:16px; line-height:24px; font-weight:bold; padding:0px; margin:0px;}
.coupon2019 .icon h3,.coupon2019 .icon h4{ margin-left:45px; display:inline-block; float:left; margin-bottom:15px;}
.coupon2019 .icon h4{ font-size:14px;line-height:24px; font-weight:bold; padding:0px; margin-top:0px; margin-bottom:10px;}
.coupon2019 .icon p{ display:inline-block; float:left; color:#999; margin:0px; padding:0 0 0 10px; line-height:24px; margin-bottom:18px;}
.coupon2019 .icon img{ margin-left:45px; margin-top:-5px; margin-bottom:15px;}
.coupon2019 .ny_warning ol{font-size: 14px; list-style: decimal; list-style-position:outside; padding:0 0 0 20px; margin:0px;}
.coupon2019 .ny_warning li{line-height:18px; padding-bottom:8px;list-style: decimal; list-style-position:outside;}
.coupon2019 .ny_warning li span{color:#ef3a3b; font-weight:bold;}
.coupon2019 .clearfix{ clear:both;}
 .Anniversary-2018_error{
    width: 460px;
    border: 1px solid #666;
   position: fixed;
    top:280px;
    left:50% ;
    margin-left: -230px;
    border-radius: 5px;
   background-color: #fff;
    padding: 30px 20px;
    text-align: center;
    font-size: 20px;
}
 .Anniversary-2018_error .Close{
    background-image: url("/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/Close.png");
     display: inline-block;
     width: 18px;
     height: 17px;
     position: absolute;
     right:8px;
     top:8px;
     cursor: pointer;
 }
</style>
<div class="coupon2019">
<?php echo zen_draw_hidden_field('c_lan', $_SESSION['languages_code'])?>	
	<img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/all_customers_receive_coupon1.gif" />
	<img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/all_customers_receive_coupon2.gif" />
	<?php if($receivable){?>
	<img class="receive_button" src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/all_customers_receive_coupon3.gif" border="0" usemap="#Map"  />
    <?php }else{?>
    <img  class="receive_button" src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/all_customers_receive_coupon4.gif" border="0" usemap="#Map"   />	
    <?php }?>
	<map name="Map" id="Map">
		<area style="cursor: pointer;" shape="rect" coords="259,16,507,54"  alt="Get coupons now >" onclick="receive_coupon();" />
	</map>
	<div class="ny_warning">
		<?php echo TEXT_RECEIVE_COUPON_WARNINGS?>
	</div>
	<div class="Anniversary-2018_error" style="display: none">
      	<span class="Close"></span>
      	<p></p>
    </div>
</div>

