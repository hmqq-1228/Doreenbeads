<!-- 从这里开始 -->
<style type="text/css">
    .feproductimg .discountbg{position:absolute;width:44px;height:39px;text-align:center;background:url(includes/templates/cherry_zen/images/discountbg.png);left:18px;color:#fff;padding-top:7px;font-weight:bold;}
    .img-scroll { position:relative; margin:0 auto;width:550px;}
    .img-scroll .arrowleft,.img-scroll .arrowright { position:absolute; display:block;top:0;}
    .img-scroll .arrowleft{ left:0;float:left;width:15px;height:22px;margin-top:35px;border:1px solid #f4eed6;display:none;outline:0;}
    .img-scroll .arrowright{ right:0;float:left;width:15px;height:22px;background:url(includes/templates/cherry_zen/images/icon.png) -76px -124px;margin-top:35px;border:1px solid transparent;outline:0;}
    .img-scroll .arrowright:hover{background:#faf7eb url(includes/templates/cherry_zen/images/icon.png) -76px -124px;border:1px solid #dfdbd0;text-decoration:none;}
    .img-scroll .arrowleft:hover{background:#faf7eb url(includes/templates/cherry_zen/images/icon.png) -28px -124px;border:1px solid #dfdbd0;text-decoration:none;}
    .arrowleft.abled{background:url(includes/templates/cherry_zen/images/icon.png) -61px -124px;display:block;border:1px solid transparent;}
    .arrowright.disabled{background:url(includes/templates/cherry_zen/images/icon.png) -42px -124px;display:none;}
    .img-list { position:relative; height:100px;width:510px;overflow:hidden;margin-left:20px;}
    .img-list ul {width:9999px;overflow:hidden;}
    .feproductimg {position: relative;text-align: center;z-index: 1;}
    .feproduct {height: auto;overflow: hidden;}
    .feproduct li {float: left;width: 128px;}
    .feproduct li img{border:1px solid #cbcaca;}
    .feproductimg a {display: block;}
    .banner_container{width:764px;height:292px;}
    .container, .container img {height:292px;overflow: hidden;position: relative;width:762px;}
    #idSlider{position: absolute;}
    #idSlider li {position: absolute;}
    .numsolider {bottom: 0;font: 12px/1.5 tahoma,arial;height: 18px;position: relative;}
    #idnumsolider {background: #EFEDEE;border: 1px solid #D7D7D7;height: 20px;line-height: 20px; margin: 2px 0 0;}
    .numsolider li {color: #000000;cursor: pointer;float: left;font-family: Arial;font-size: 12px;height: 20px;line-height: 20px;overflow: hidden;text-align: center;}
    .numsolider li a {border-left: 1px solid #DDDBDC;color: #9A9898;display: block;text-decoration: none;}
    .numsolider li:first-child a {border-left: 0 solid #000000;}
    .numsolider li.on {background-color: #FCFCFC;color: #333333;font-weight: bold;}
    .numsolider li.on a {color: #333333;}
    .newtext{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .bottom_img{width:766px;}
    .bottom_img img{ height:151px; width:230px; border:2px solid #CCC; margin-left:32px;}
    .bottom_img_left{ margin-left:0;}
    .bottom_img h3 {  border-bottom: 2px solid #914ba8;
        font-size: 16px;
        height: 30px;
        line-height: 30px; margin-bottom:15px;}
    .newtext1 {white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    #toLeft{position: relative; top:48%; display: none; height: 42px; width: 20px; background-color: #000; opacity: 0.3; color: #fff; text-align: center; font-size: 24px; line-height: 42px;cursor: pointer;}
    #toLeft:hover{color: #fff !important;text-decoration: none;opacity: 0.5;}
    #toRight{position: relative; top: 48%; display: none; height: 42px; width: 20px; background-color: #000; opacity: 0.3; color: #fff; text-align: center; font-size: 24px; line-height: 42px;float: right;cursor: pointer;}
    #toRight:hover{color: #fff !important;text-decoration: none;opacity: 0.5;}
</style>
<script type="text/javascript">
    $j(document).ready(function(){
        var t = n = 0, count;
        var time = 5000;//图片切换时间
        var time1 = 1000;//图片淡入淡出时间
        $j('#idnumsolider').html('');
        count=$j("#idSlider li").length;
        idSlider_li_width=Math.floor($j('#idContainer').width()/count);
        $j('#idnumsolider').css('width',(idSlider_li_width*count));
        $j("#idSlider li").each(function(){
            ahref=$j(this).find("a").attr('href');
            words=$j(this).find("img").attr('alt');
            num=$j("#idSlider li").index(this)+1;
            if(!words){
                words='输入第'+num+'张图片的alt文字';
            }
            $j("#idnumsolider").append("<li style='width:"+idSlider_li_width+"px'><a href='"+ahref+"'>"+words+"</a></li>");
        });
        $j("#idSlider li:not(:first-child)").hide();
        $j("#idnumsolider li:first-child").addClass("on");
        $j("#idnumsolider li").hover(function() {
            clearInterval(t);
            var i = $j("#idnumsolider li").index(this) ;
            if(n == i) return false;
            n = i;
            if (i >= count) return;
            $j("#idSlider li").stop(true,true);
            $j("#idSlider li").filter(":visible").fadeOut(time1).parent().children().eq(i).fadeIn(time1);
            $j(this).stop(true,true).addClass("on").siblings().removeClass("on");

        },function(){
            t = setInterval(showAuto, time);
        });
        t = setInterval(showAuto, time);
        $j('#idContainer').hover(function(){clearInterval(t);$j('#toLeft').css('display', 'inline-block');$j('#toRight').css('display', 'inline-block');}, function(){t = setInterval(showAuto, time);$j('#toLeft').hide();$j('#toRight').hide();});

        function showAuto() {
            n = n >=(count - 1) ? 0 : ++n;
            $j("#idSlider li").filter(":visible").fadeOut(time1).parent().children().eq(n).fadeIn(time1);
            $j("#idnumsolider li").eq(n).addClass("on").siblings().removeClass("on");
        }
        $j('#toRight').click(function(){
            clearInterval(t);
            var index_li = $j("#idnumsolider li.on");
            var index = $j("#idnumsolider li").index(index_li);
            if ((index+1) == count) {
                index = -1;
            }
            var next = index+1;
            var imglist = $j("#idSlider").find('li');
            var textlist = $j("#idnumsolider").find('li');
            $j("#idSlider li").filter(":visible").fadeOut(time1).parent().children().eq(next).fadeIn(time1);
            $j("#idnumsolider li").eq(next).addClass("on").siblings().removeClass("on");
        });
        $j('#toLeft').click(function(){
            clearInterval(t);
            var index_li = $j("#idnumsolider li.on");
            var index = $j("#idnumsolider li").index(index_li);
            if ((index) == -1) {
                index = count-1;
            }
            var next = index-1;
            var imglist = $j("#idSlider").find('li');
            var textlist = $j("#idnumsolider").find('li');
            $j("#idSlider li").filter(":visible").fadeOut(time1).parent().children().eq(next).fadeIn(time1);
            $j("#idnumsolider li").eq(next).addClass("on").siblings().removeClass("on");
        });
    })
</script>


<!-- banner -->
<div class="banner_container" id="idContainer">
    <ul id="idSlider">
        <li>
            <a href="https://www.doreenbeads.com/jewelry-packaging-display-c-1896.html">
                <img alt="Packaging & Displays"  height="292" src="https://img.doreenbeads.com/promotion_photo/en/images/20170306/displays-db.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/mandala-collection-c-2066_2869.html">
                <img alt="Mandala Collection"  height="292" src="https://img.doreenbeads.com/promotion_photo/en/images/20170306/mandala-db.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/birthstone-jewelry-c-2066_2867.html">
                <img alt="Birthstone Jewelry"  height="292" src="https://img.doreenbeads.com/promotion_photo/en/images/20170227/birthstone-db.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/sun-moon-collection-c-2066_2868.html">
                <img alt="Sun & Moon Collection"  height="292" src="https://img.doreenbeads.com/promotion_photo/en/images/20170227/sun-db.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/crystal-dust-bracelets-c-2066_2865.html">
                <img alt="Crystal Dust Bracelets"  height="292" src="https://img.doreenbeads.com/promotion_photo/en/images/20170227/crystaldust-db.jpg" width="764px" />
            </a>
        </li>
    </ul>
    <a id="toLeft" class="link toLeft"><</a>
    <a id="toRight" class="link toRight">></a>
</div>
<ul class="numsolider" id="idnumsolider" style="width:200px;"> </ul>
<div class="product_index">
    <!-- Hot -->
    <h3>Popular Categories</h3>
    <dl class="popularpro">
        <dd>
            <a href="https://www.doreenbeads.com/index.php?main_page=promotion&aId=18">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/216.gif" alt="Handmade Jewelry: 30% OFF" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170301/handmade-jewelry.jpg" data-size="216" />
            </a>
        </dd>
        <dt>
            <ul>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/beads-caps-c-1729_1791_1795.html">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170106/beads-caps.jpg" alt="Bead Caps" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/beads-caps-c-1729_1791_1795.html" title="Bead Caps">
                            Bead Caps
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/resin-craft-mould-supplies-c-2066_2813.html">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170123/resin-crafting.jpg" alt="Resin Crafting Supplies" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/resin-craft-mould-supplies-c-2066_2813.html" title="Resin Crafting Supplies">
                            Resin Crafting Supplies
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/index.php?main_page=promotion&aId=19">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170301/floating-sale.jpg" alt="Floating Supplies Sale" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/index.php?main_page=promotion&aId=19" title="Floating Supplies Sale">
                            Floating Supplies Sale
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/index.php?main_page=promotion&aId=20">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170302/fabric.jpg" alt="Fabric Sale" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/index.php?main_page=promotion&aId=20" title="Fabric Sale">
                            Fabric Sale
                        </a>
                    </p>
                </li>
            </ul>
        </dt>
    </dl>
    <!-- Featured -->
    <dl class="popularpro_bottom">
        <dd>
            <strong>Featured Products</strong>
            <p><span>Fantastic items we've picked for you</span></p>
        </dd>
        <dt style="padding-right:20px;">
            <div class="img-scroll">
                <a class="arrowleft" href="javascript:void(0);"> </a>
                <div class="img-list">
                    <ul class="feproduct">
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/zinc-based-alloy-charms-heart-antique-silver-butterfly-hollow-23mm-78-x-22mm-78-10-pcs-p-119744.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086347.jpg" alt="Heart Pendants" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/zinc-based-alloy-cabochon-settings-connectors-round-antique-silver-fits-12mm-dia-20mm-68-x-14mm-48-50-pcs-p-119525.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086297.jpg" alt="Connectors Settings" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/iron-based-alloy-spacer-beads-cylinder-silver-plated-rhombus-hollow-13mm-48-x-3mm-18-hole-approx-23mm-50-pcs-p-119572.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086430.jpg" alt="Metal Beads" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/silicone-resin-mold-for-jewelry-making-cat-animal-white-10mm-38-x-7mm-28-5-pcs-p-119622.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086538.jpg" alt="Silicone Mold" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/glass-butterfly-wing-dome-seals-cabochon-round-flatback-at-random-12mm-48-dia-20-pcs-p-119583.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086314.jpg" alt="Glass Dome Seals" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/zinc-based-alloy-prince-symbol-charms-heart-silver-plated-hollow-26mm1-x-24mm1-5-pcs-p-119527.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086293.jpg" alt="Prince Symbol Pendants" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/zinc-based-alloy-pendants-cross-celtic-knot-antique-silver-hollow-58cm2-28-x-36cm1-38-5-pcs-p-119546.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086309.jpg" alt="Cross Pendants" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/glass-beads-round-royal-blue-about-10mm-38-dia-hole-approx-08mm-83cm32-58-long-1-piece-approx-83-pcsstrand-p-119541.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086361.jpg" alt="Glass Beads" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/304-stainless-steel-buddhism-mandala-charms-round-silver-tone-filigree-22mm-78-x-20mm-68-10-pcs-p-119521.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086318.jpg" alt="Buddhism Mandala Charms" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/zinc-based-alloy-boho-chic-pendants-half-moon-antique-silver-blue-pentagram-star-imitation-turquoise-79mm3-18-x-31mm1-28-1-piece-p-119751.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086340.jpg" alt="Boho Chic Pendants" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/zinc-based-alloy-connectors-heartbeat-electrocardiogram-heart-silver-plated-39mm1-48-x-20mm-68-5-pcs-p-119532.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086286.jpg" alt="Medical Alert Connectors" />
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="feproductimg">
                                <a href="https://www.doreenbeads.com/sable-fur-pom-pom-balls-dark-gray-round-with-ring-50mm2-dia-1-piece-p-119557.html">
                                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/100.gif" data-size="100" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086272.jpg" alt="Pom Pom Balls" />
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <a class="arrowright" href="javascript:void(0);"> </a>
            </div>
        </dt>
    </dl>
</div>
<!-- New -->
<div class="product_index">
    <h3>Hot Products</h3>
    <ul class="new_arrivals">
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/plastic-selfseal-bags-rectangle-transparent-usable-space-5x5cm-7cm-x5cm2-68-x2-200-pcs-p-13542.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B03363.jpg" alt="Self-Seal Plastic Bags">
                </a>
            </p>
            <p class="newtext">
                <a title="Self-Seal Plastic Bags" href="https://www.doreenbeads.com/selfseal-plastic-bags-c-1896_1897_1900.html">
                    Self-Seal Plastic Bags
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/glass-beads-round-peacock-green-transparent-faceted-about-6mm-28-dia-hole-approx-1mm-444cm17-48-long-1-strand-approx-100-pcsstrand-p-117542.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0084357.jpg" alt="Glass Beads">
                </a>
            </p>
            <p class="newtext">
                <a title="Glass Beads" href="https://www.doreenbeads.com/glass-beads-c-1729_1730_1741.html">
                    Glass Beads
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/1rolls-40m-silver-tone-tiger-tail-beading-wire-05mm-p-11544.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B01400.jpg" alt="Wires">
                </a>
            </p>
            <p class="newtext">
                <a title="Wires" href="https://www.doreenbeads.com/wires-c-1729_1860_1862.html">
                    Wires
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/zinc-based-alloy-beads-caps-flower-antique-silver-dot-pattern-fits-10mm12mm-beads-8mm-38-x-8mm-38-200-pcs-p-38202.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B25874.jpg" alt="Beads Caps">
                </a>
            </p>
            <p class="newtext">
                <a title="Beads Caps" href="https://www.doreenbeads.com/beads-caps-c-1729_1791_1795.html">
                    Beads Caps
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/glass-bottles-cylinder-jewelry-vials-cork-stoppers-transparent-25mm1-x-22mm-78-13mm-x10mm-48-x-38-10-pcs-p-112884.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B79406.jpg" alt="Storage Containers">
                </a>
            </p>
            <p class="newtext">
                <a title="Storage Containers" href="https://www.doreenbeads.com/storage-containers-c-1896_1908.html">
                    Storage Containers
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/zinc-based-alloy-lobster-clasp-findings-14k-real-gold-plated-12mm-48-x-7mm-28-10-pcs-p-117789.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0083821.jpg" alt="Lobster Clasps">
                </a>
            </p>
            <p class="newtext">
                <a title="Lobster Clasps" href="https://www.doreenbeads.com/lobster-clasps-c-1729_1803_1804.html">
                    Lobster Clasps
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/iron-based-alloy-well-sorted-head-pins-silver-plated-3cm1-18-long-07mm-21-gauge-1-packet300-pcs-p-23435.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B13031.jpg" alt="Well Sorted Pins">
                </a>
            </p>
            <p class="newtext">
                <a title="Well Sorted Pins" href="https://www.doreenbeads.com/well-sorted-pins-c-1729_1848_1849.html">
                    Well Sorted Pins
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/silicone-resin-mold-for-jewelry-making-10-mixed-shape-white-75mm3-x-60mm2-38-1-piece-p-119614.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086546.jpg" alt="Silicone Mold">
                </a>
            </p>
            <p class="newtext">
                <a title="Silicone Mold" href="https://www.doreenbeads.com/silicone-mold-c-2066_2813_2814.html">
                    Silicone Mold
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/zinc-based-alloy-charms-zombie-human-antique-silver-26mm1-x-12mm-48-20-pcs-p-119595.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086570.jpg" alt="Metal Pendants">
                </a>
            </p>
            <p class="newtext">
                <a title="Metal Pendants" href="https://www.doreenbeads.com/metal-pendants-c-1729_1831_1834.html">
                    Metal Pendants
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/zinc-based-alloy-3d-pendants-sword-antique-silver-50mm2-x-8mm-38-10-pcs-p-119593.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086572.jpg" alt="Sword Charms">
                </a>
            </p>
            <p class="newtext">
                <a title="Sword Charms" href="https://www.doreenbeads.com/index.php?main_page=advanced_search_result&keyword=Sword+Pendants">
                    Sword Charms
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/zinc-based-alloy-charms-scarab-gold-tone-antique-gold-27mm1-18-x-26mm1-5-pcs-p-119792.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/en/edm/20170228/B0086601.jpg" alt="Gold Tone Pendants">
                </a>
            </p>
            <p class="newtext">
                <a title="Gold Tone Pendants" href="https://www.doreenbeads.com/metal-pendants-c-1729_1831_1834.html?pcount=1&disp_order=30&p1=13324">
                    Gold Tone Pendants
                </a>
            </p>
        </li>
    </ul>
</div>
<div class="bottom_img">
    <h3>Recommendations for you</h3>
    <a href="https://www.doreenbeads.com/changeable-leather-bracelets-c-2066_2591.html">
        <img style="margin-left:12px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170220/changeable-leather-bracelets.jpg"/>
    </a>
    <a href="https://www.doreenbeads.com/pine-cone-acorn-collection-c-2066_2852.html">
        <img style="margin-left:12px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170213/pine-cone.jpg"/>
    </a>
    <a href="https://www.doreenbeads.com/geometric-collection-c-2066_2858.html">
        <img style="margin-left:12px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170227/Geometric-Collection.jpg"/>
    </a>
</div>
<script type="text/javascript">
    $j(function(){
        $j('.arrowleft').click(function(){
            if($j('.arrowright').hasClass('off')){
                $j('.arrowright').removeClass('off');
                $j('.arrowright').removeClass('disabled');
            }
            if($j(this).hasClass('on')){
                var num=4;
                var w = parseInt($j(".img-scroll li").css("width"));
                var tw = w*$j(".img-scroll li").length;
                if(!$j("ul.feproduct").is(":animated")){
                    var marLeft = parseInt($j("ul.feproduct").css("margin-left"));
                    var l = marLeft + w * num;
                    if(l >= 0){
                        l = 0;
                        $j('.arrowleft').removeClass('on');
                        $j('.arrowleft').removeClass('abled');
                    }
                    $j("ul.feproduct").animate({marginLeft:l+"px"},1000);
                }
            }
        });

        $j('.arrowright').click(function(){
            if(!$j('.arrowleft').hasClass('on')){
                $j('.arrowleft').addClass('on');
                $j('.arrowleft').addClass('abled');
            }
            if(!$j(this).hasClass('off')){
                var num=4;
                var w = parseInt($j(".img-scroll li").css("width"));
                var tw = w*$j(".img-scroll li").length;
                if(!$j("ul.feproduct").is(":animated")){
                    var marLeft = parseInt($j("ul.feproduct").css("margin-left"));
                    var l = marLeft-w*num;
                    $j("ul.feproduct").animate({marginLeft:l+"px"},1000);
                    if(-marLeft>=tw-w*num*2){
                        $j('.arrowright').addClass('off');
                        $j('.arrowright').addClass('disabled');
                    }
                }
            }
        })
    })
</script>

<!-- 到这里结束 -->
