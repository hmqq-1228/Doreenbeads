
<style type="text/css">
body{margin:0; padding:0;}
.fb_page table, .fb_page tr, .fb_page td, .fb_page a, .fb_page h3, .fb_page ul, .fb_page li, .fb_page img{margin:0; padding:0;}
.fb_page img{border:0; vertical-align:bottom;}
.fb_page ul{list-style-type:none;}
.fb_page a{text-decoration:none;}

.fb_page{width:766px; height:auto; margin:0 auto; font-size:14px; font-family:Arial; color:#333; line-height:20px;}
.fb_page .fb_like{width:764px; border:1px solid #ccc; margin-top:5px; padding-bottom:20px; position:relative; float:left;}
.fb_page .fb_like .fb_banner{width:764px; height:348px; background:url(http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_banner.jpg) no-repeat 0 0; border-bottom:1px solid #e0e0e0;}

/*-------- botton --------*/
.fb_page .fb_like .fb_banner a{display:block; float:right; width:115px; height:28px; text-align:center; line-height:28px; font-family:Arial; font-size:15px; font-weight:bold; margin:280px 20px 0 0; color:#fff; background:#b260cd -moz-linear-gradient(center top , #d476f3, #b260cd) repeat scroll 0 0; border:1px solid #974baf; }
.fb_page .fb_like .fb_banner a.gray{background:#ececec repeat scroll 0 0; color:#777; border:1px solid #bbb;}
/*-------- botton end --------*/

/*-------- pop --------*/
.fb_page .fb_like .successtips_add{
	background: #faf8e4 none repeat scroll 0 0;
	border: 1px solid #d0cfcf;
	font-size:12px;
	color: #666; 
	line-height: 20px;
	padding: 10px 5px;
	position: absolute;
	width: 160px;
	z-index: 1;
	right:20px;
	top: 320px;
}
.fb_page .fb_like .successtips_add span{font-size:0; height:0; overflow:hidden; position:absolute; width:0;}
.fb_page .fb_like .successtips_add span.bot{
	border-color: transparent transparent #d0cfcf;
	border-style: dashed dashed solid;
	border-width: 8px;
	top: -15px;
	right: 20px;
}
.fb_page .fb_like .successtips_add span.top{
	border-color: transparent transparent #faf8e4;
	border-style: dashed dashed solid;
	border-width: 8px;
	top: -14px;
	right: 20px;
}
.fb_page .fb_like .successtips_add a{color:#2321a9; display:inline-block; margin-right:20px;}
/*-------- pop end --------*/

.fb_page .fb_like h3{font-size:18px; font-weight:bold; padding:20px 0 10px 20px;}
.fb_page .fb_like ul{width:700px; list-style-type:decimal; padding:0 30px 30px 40px; list-style-position:outside;}
.fb_page .fb_like ul li{padding-bottom:5px; list-style-type:decimal;}

.fb_page .fb_like .fb_items{float:left; padding:0 12px 30px 12px;}
.fb_page .fb_like .fb_items a{display:block; float:left; width:138px; border:1px solid #ccc; margin:10px 10px 10px 0;}
.fb_page .fb_like .fb_items a.right{margin-right:0;}
.fb_page .fb_like .fb_items a:hover{border:1px solid #ec4383;}

.fb_page .fb_like .fb_sale{float:left; padding-left:12px;}
.fb_page .fb_like .fb_sale a{display:block; float:left; width:238px; border:1px solid #ccc; margin:10px 10px 0 0;}
.fb_page .fb_like .fb_sale a.right{margin-right:0;}
.fb_page .fb_like .fb_sale a:hover{border:1px solid #ec4383;}


.pop_facebook{
    background: #fff none repeat scroll 0 0;
    border: 1px solid #444;
    border-radius: 8px;
    box-shadow: 5px 5px 20px #797979;
    display: none;
    height: auto;
    left: 30%;
    padding: 15px 20px;
    position: fixed;
    top: 15%;
    width: 500px;
    z-index: 100002;
}
#closebtnfblike {
    color: #bbb;
    cursor: pointer;
    float: right;
    font-size: 16px;
    font-weight: bold;
}
.pop_facebook h4{ text-align:center; text-transform:capitalize; font-weight:normal; font-size:26px; padding:15px 0;}
.pop_facebook p{text-align:center; font-size:18px; padding-bottom:25px;}
.pop_facebook .btn_like{ background:url(http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/1436153310922_03.jpg); width:390px; height:60px; margin:0 auto;}
</style>

<div class="fb_page">

<?php if(!$isActiveTime) { ?>
  <table width="766" height="80" border="0" cellpadding="0" cellspacing="0" style="background:url(http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_top_bg.jpg) no-repeat 0 0; text-align:center;">
  <tr>
    <td colspan="3" height="5"></td>
    <td rowspan="4" width="221" style="font-size:22px; color:#f60716;">By <?php echo $endDate; ?></td>
  </tr>
  <tr>
    <td width="103" rowspan="2" style="border-right:1px solid #333;"><span class="fb-like" data-href="https://www.facebook.com/doreenbeads" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></span></td>
    <td width="221" style="font-size:16px; color:#333; border-right:1px dashed #333;">Page Likes now:</td>
    <td width="221" style="font-size:16px; color:#333; border-right:1px dashed #333;">Need more Likes:</td>
    </tr>
  <tr>
    <td width="221" style="font-size:22px; color:#000045; border-right:1px dashed #333;"><?php echo $likeCountNow; ?></td>
    <td width="221" style="font-size:22px; color:#000045; border-right:1px dashed #333;"><?php echo $likeCountLeft; ?></td>
  </tr>
  <tr>
    <td colspan="3" height="5"></td>
    </tr>
  </table>
<?php } ?>

  <div class="fb_like">
    <div class="fb_banner">
      <a href="javascript:void(0)" class="<?php echo !$isActiveTime ? 'gray' : ''; ?>">Add to Cart</a>
    </div>
    
 <!-- pop -->
    <div class="successtips_add" style="display:none">
      <span class="bot"></span>
      <span class="top"></span>
      <ins class="sh">
        Item Added Successfully into Your Shopping Cart!
        <br>
        <a href="index.php?main_page=shopping_cart">View Shopping Cart</a>
      </ins>
    </div>
 <!-- pop end -->
    
    <h3>Warmly notice：</h3>
    <ul>
      <li>Gift collection lasts from August 1st, 00:00 a.m. PDT to August 3rd, 11:59 p.m. PDT.  Please add the gift in your order before expiry.</li>
      <li>Each Facebook fan could only add 1pc free gift kit.</li>
      <li>Due to shipping area restrictions, we couldn’t offer shipping to certain countries. Normally it takes 18-30 days for international shipping.</li>
      <li>Please contact us for any questions.</li>
    </ul>
    <div class="fb_items">
      <img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items_title.jpg" width="740" height="20" />
      <a href="http://www.doreenbeads.com/grade-b-naturaldyed-agate-connectors-findings-irregular-blue-410mm1-58-x-210mm-78-1-piece-p-87311.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items01.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/200-pcs-mixed-crackle-glass-round-beads-6mm-dia-findings-p-15174.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items02.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/glass-loose-beads-round-pink-ab-color-transparent-faceted-about-140mm-48-dia-hole-approx-13mm-20-pcs-p-86798.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items03.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/grade-b-coral-naturaldyed-loose-beads-round-deep-pink-about-60mm-28-dia-hole-approx-06mm-400cm15-68-long-1-strand-approx-72-pcsstrand-p-87292.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items04.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/coconut-shell-spacer-beads-irregular-at-random-about-4cm-x-19cm-14cm-x-13cm-hole-approx-25mm30mm-200-grams-p-60592.html" target="_blank" class="right"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items05.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/toggle-clasps-butterfly-antique-silver-20mm-x19mm-68-x-68-26mm-x5mm1-x-28-50-sets-p-67788.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items06.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/antique-bronze-circle-flower-pendants-connectors-34x27mmcan-hold-rhinestone-sold-per-pack-of-30-p-23970.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items07.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/fashion-leather-wrist-watches-round-orange-pink-battery-included-243cm9-58-long-1-piece-p-87190.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items08.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/100-cotton-fabric-blue-at-random-pattern-30cm11-68-x-20cm7-78-1-packetapprox-9-piecepacket-p-86993.html" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items09.jpg" width="138" height="138" /></a>
      <a href="http://www.doreenbeads.com/1-box-mixed-silver-plated-open-jump-rings-3mm8mm1500-pcs-assorted-p-19252.html" target="_blank" class="right"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_items10.jpg" width="138" height="138" /></a>
    </div>
    <div class="fb_sale">
      <img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_sale_title.jpg" width="740" height="20" />
      <a href="http://www.doreenbeads.com/index.php?main_page=promotion_price&g=3&utm_source=facebook&utm_medium=dailydeals&utm_campaign=1" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_sale01.jpg" width="238" height="158" /></a>
      <a href="https://www.doreenbeads.com/index.php?main_page=login" target="_blank"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_sale02.jpg" width="238" height="158" /></a>
      <a href="http://www.doreenbeads.com/index.php?main_page=advanced_search_result&action=quick&inc_subcat=1&search_in_description=1&keyword=Fashion%20Jewelries&disp_order=30&cId=1869" target="_blank" class="right"><img src="http://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/fb_sale04.jpg" width="238" height="158" /></a>
    </div>
  </div>
</div>
<div class="pop_facebook" id="pop_fblike">
	<span id="closebtnfblike">X</span>
	<h4>Lob auf Facebook</h4>
    <p>um KOSTENLOS Probe-Kits zu bekommen!</p>
    <div class="btn_like"></div>
	<span class="fb-like" data-href="https://www.facebook.com/doreenbeads" data-layout="button" data-action="like" data-show-faces="false" data-share="false" style="position: absolute;left: 266px;top: 170px;"></span>
</div>