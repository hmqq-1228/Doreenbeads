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
    .bottom_img img{ height:151px; width:230px; border:2px solid #CCC; margin-left:28px;}
    .bottom_img_left{ margin-left:0;}
    .bottom_img h3 {  border-bottom: 2px solid #914ba8;
        font-size: 16px;
        height: 30px;
        line-height: 30px; margin-bottom:15px;}
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
        <!--weekenddeals-->
        <li>
            <a href="https://www.doreenbeads.com/fr/mandala-collection-c-2066_2869.html">
                <img alt="Collection Mandala" height="292" src="https://img.doreenbeads.com/promotion_photo/fr/images/20170306/dbfr-mandala.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/fr/jewelry-packaging-display-c-1896.html">
                <img alt="Présentoirs à Bijoux"  height="292" src="https://img.doreenbeads.com/promotion_photo/fr/images/20170306/dbfr-presentoir.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/fr/sun-moon-collection-c-2066_2868.html">
                <img alt="Collection Soleil et Lune"  height="292" src="https://img.doreenbeads.com/promotion_photo/fr/images/20170227/dbfr-soleil.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/fr/crystal-dust-bracelets-c-2066_2865.html">
                <img alt="Bracelets de Cristaux"  height="292" src="https://img.doreenbeads.com/promotion_photo/fr/images/20170227/dbfr-cristaux.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/fr/birthstone-jewelry-c-2066_2867.html">
                <img alt=" Pierre de Naissance"  height="292" src="https://img.doreenbeads.com/promotion_photo/fr/images/20170227/dbfr-naissance.jpg" width="764px" />
            </a>
        </li>
    </ul>
    <a id="toLeft" class="link toLeft"><</a>
    <a id="toRight" class="link toRight">></a>
</div>
<ul class="numsolider" id="idnumsolider" style="width:200px;"> </ul>
<div class="product_index">
    <!-- Hot -->
    <h3>Hot Catégories </h3>
    <dl class="popularpro">
        <dd>
            <a href="https://www.doreenbeads.com/fr/origami-collection-c-2066_2818.html">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/216.gif" data-size="216" data-lazyload="https://img.doreenbeads.com/promotion_photo/fr/images/20170124/216-origami2.jpg" alt="Collection Origami" />
            </a>
        </dd>
        <dt>
            <ul>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=promotion&aId=18">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/fr/images/20170306/258-fr.jpg" alt="Promo de Bijoux Faits Main" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=promotion&aId=18" title="Bijoux Faits Main: -30%">
                            Bijoux Faits Main: -30%
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=promotion&aId=19">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/fr/images/20170301/258-fr2.jpg" alt="Promo Flottant Médaillon Support" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=promotion&aId=19" title="Flottant Médaillon Support: Jusqu'à -70%">
                            Flottant Médaillon: Jusqu'à -70%
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=products_common_list&pn=subject&aId=30">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/fr/images/20170124/258-francais.jpg" alt="Collection Gravée Mots Français" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=products_common_list&pn=subject&aId=30" title="Collection Gravée Mots Français">
                            Collection Gravée Mots Français
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=promotion&aId=20">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/fr/images/20170303/258-dbfr.jpg" alt="Promo de Tissu" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/fr/index.php?main_page=promotion&aId=20" title="Promo de Tissu Jusqu'à -35%">
                            Promo de Tissu Jusqu'à -35%
                        </a>
                    </p>
                </li>
            </ul>
        </dt>
    </dl>
    <!-- Featured -->
    <h3>Meilleures Ventes</h3>
    <ul class="new_arrivals">
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/crystal-glass-loose-beads-round-blue-silvery-faceted-about-4mm18-dia-hole-approx-1mm-489cm19-28-long-1-strand-approx-149-pcsstrand-p-64611.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B48356.jpg" alt="Perles en Verre">
                </a>
            </p>
            <p class="newtext">
                <a title="Perles en Verre" href="https://www.doreenbeads.com/fr/glass-beads-c-1729_1730_1741.html">
                    Perles en Verre
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/copper-ear-wire-hooks-earring-findings-wishbone-gold-plated-w-loop-44mm1-68-x-20mm-68-post-wire-size-20-gauge-10-pairs-p-115415.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0081867.jpg" alt="Crochets de Boucles d'Oreilles">
                </a>
            </p>
            <p class="newtext">
                <a title="Crochets de Boucles d'Oreilles" href="https://www.doreenbeads.com/fr/hook-earwire-c-1729_1777_1783.html">
                    Crochets de Boucles d'Oreilles
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/304-stainless-steel-pet-silhouette-charms-cat-animal-silver-tone-the-cat-has-my-heart-22mm-78-x-17mm-58-1-piece-p-116022.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0082305.jpg" alt="Pendentifs Silhouette d’Animal">
                </a>
            </p>
            <p class="newtext">
                <a title="Pendentifs Silhouette d’Animal" href="https://www.doreenbeads.com/fr/pet-silhouette-pendants-c-2066_2723.html">
                    Pendentifs Silhouette d’Animal
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/copper-druzy-drusy-ear-post-stud-earrings-round-silver-plated-silver-w-stoppers-16mm-58-x-14mm-48-post-wire-size-20-gauge-1-pair-p-112008.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B78274.jpg" alt="Collection Druzy">
                </a>
            </p>
            <p class="newtext">
                <a title="Collection Druzy" href="https://www.doreenbeads.com/fr/index.php?main_page=advanced_search_result&keyword=druzy&inc_subcat=1&search_in_description=1&add_report=1">
                    Collection Druzy
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/natural-beech-wood-handoperated-yarnfiberwoolstring-ball-skein-winder-61cm-x2cm24-x-68-145cm-x08cm5-68-x-38-1-piece-p-119487.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0085980.jpg" alt="Bobinoirs de Fil">
                </a>
            </p>
            <p class="newtext">
                <a title="Bobinoirs de Fil" href="https://www.doreenbeads.com/fr/yarn-winder-c-1909_1928_1938.html">
                    Bobinoirs de Fil
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/zinc-based-alloy-bookmark-halloween-owl-antique-silver-cabochon-settings-fit-20mm-dia-can-hold-ss6-rhinestone-86mm3-38-x-22mm-78-3-pcs-p-110360.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B76786.jpg" alt="Marque-Pages">
                </a>
            </p>
            <p class="newtext">
                <a title="Marque-Pages" href="https://www.doreenbeads.com/fr/bookmarks-c-1729_1753.html">
                    Marque-Pages
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/zinc-based-alloy-connectors-findings-lotus-flower-silver-tone-hollow-26mm1-x-14mm-48-5-pcs-p-116328.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0082697.jpg" alt=" Lotus">
                </a>
            </p>
            <p class="newtext">
                <a title=" Lotus" href="https://www.doreenbeads.com/fr/lotus-jewelry-c-2066_2827_2828.html">
                    Lotus
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/fr/zinc-based-alloy-charms-cone-silver-tone-14mm-48-x-7mm-28-20-pcs-p-117426.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0083989.jpg" alt="Collection Flèche">
                </a>
            </p>
            <p class="newtext">
                <a title="Collection Flèche" href="https://www.doreenbeads.com/fr/arrow-jewelry-c-2066_2845.html">
                    Collection Flèche
                </a>
            </p>
        </li>
    </ul>
    <!-- New -->
    <div class="product_index">
        <h3>
            <a class="productlink" href="index.php?main_page=products_common_list&pn=new">Nouveautés</a>
            <a class="productmore" href="index.php?main_page=products_common_list&pn=new">Voir Plus>></a>
        </h3>
        <ul class="new_arrivals">
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/grade-d-howlite-imitated-turquoise-gemstone-loose-beads-cross-peacock-green-about-20mm-68-x-20mm-68-hole-approx-15mm-41cm16-18-long-1-piece-approx-20-pcsstrand-p-119585.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086636.jpg" alt="Perles en Turquoise">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Perles en Turquoise" href="https://www.doreenbeads.com/fr/index.php?main_page=advanced_search_result&keyword=Perles%20en%20Turquoise&inc_subcat=1&search_in_description=1&add_report=1">
                        Perles en Turquoise
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/iron-based-alloy-ball-chain-necklace-antique-bronze-58cm22-78-long-chain-size-15mm-3-pcs-p-119574.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086640.jpg" alt="Colliers en Chaînes">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Colliers en Chaînes" href="https://www.doreenbeads.com/fr/chain-necklace-c-1729_1825_1826.html">
                        Colliers en Chaînes
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/zinc-based-alloy-3d-metal-beads-fish-animal-antique-silver-54mm2-18-x-21mm-78-hole-approx-35mm-2-pcs-p-119510.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086335.jpg" alt="Perles en Métal">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Perles en Métal" href="https://www.doreenbeads.com/fr/metal-beads-c-1729_1730_1743.html">
                        Perles en Métal
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/304-stainless-steel-buddhism-mandala-charms-round-silver-tone-filigree-22mm-78-x-20mm-68-10-pcs-p-119521.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086318.jpg" alt="Mandala Bouddhiste">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Mandala Bouddhiste" href="https://www.doreenbeads.com/fr/index.php?main_page=advanced_search_result&keyword=Mandala%20Bouddhiste&inc_subcat=1&search_in_description=1&add_report=1">
                        Mandala Bouddhiste
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/zinc-based-alloy-connectors-honeycomb-silver-tone-23mm-78-x-20mm-68-20-pcs-p-119605.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086560.jpg" alt="Abeille et Nid d'Abeille">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Abeille et Nid d'Abeille" href="https://www.doreenbeads.com/fr/bee-and-honeycomb-c-2066_2804.html">
                        Abeille et Nid d'Abeille
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/copper-connectors-round-rose-gold-cabochon-settings-fits-10mm-dia-19mm-68-x-12mm-48-10-pcs-p-119610.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086555.jpg" alt="Connecteurs Supports Cabochons">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Connecteurs Supports Cabochons" href="https://www.doreenbeads.com/fr/connectors-settings-c-1729_1768_1774.html">
                        Connecteurs Supports Cabochons
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/glass-butterfly-wing-dome-seals-cabochon-round-flatback-at-random-20mm-68-dia-10-pcs-p-119582.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086315.jpg" alt="Cabochons en Verre">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Cabochons en Verre" href="https://www.doreenbeads.com/fr/glass-dome-seals-c-1729_1762_1766.html">
                        Cabochons en Verre
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/fr/zinc-based-alloy-charms-scarab-antique-silver-27mm1-18-x-26mm1-10-pcs-p-119549.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/fr/edm/20170205/B0086306.jpg" alt="Pendentifs en Métal">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Pendentifs en Métal" href="https://www.doreenbeads.com/fr/metal-pendants-c-1729_1831_1834.html">
                        Pendentifs en Métal
                    </a>
                </p>
            </li>
        </ul>
    </div>
</div>
<div class="bottom_img">
    <h3>Recommandations pour Vous</h3>

    <a href="https://www.doreenbeads.com/fr/geometric-collection-c-2066_2858.html">
        <img style="margin-left:0px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170227/Geometric-Collection.jpg"/>
    </a>
    <a href="https://www.doreenbeads.com/fr/changeable-leather-bracelets-c-2066_2591.html">
        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/en/images/20170220/changeable-leather-bracelets.jpg"/>
    </a>
    <a href="https://www.doreenbeads.com/fr/resin-craft-mould-supplies-c-2066_2813.html">
        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/fr/images/20170124/230-silicone.jpg"/>
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
                    if(l>=0){l=0;$j('.arrowleft').removeClass('on');
                        $j('.arrowleft').removeClass('abled');
                    }
                    $j("ul.feproduct").animate({marginLeft:l+"px"},1000);
                }
            }
        })

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