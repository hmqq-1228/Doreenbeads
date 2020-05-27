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
    #toLeft{position: relative; top:48%; display: none; height: 42px; width: 20px; background-color: #000; opacity: 0.3; color: #fff; text-align: center; font-size: 24px; line-height: 42px;cursor: pointer;}
    #toLeft:hover{color: #fff !important;text-decoration: none;opacity: 0.5;}
    #toRight{position: relative; top: 48%; display: none; height: 42px; width: 20px; background-color: #000; opacity: 0.3; color: #fff; text-align: center; font-size: 24px; line-height: 42px;float: right;cursor: pointer;}
    #toRight:hover{color: #fff !important;text-decoration: none;opacity: 0.5;}
</style>
<script type="text/javascript">
    //
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
            <a href="https://www.doreenbeads.com/ru/jewelry-packaging-display-c-1896.html">
                <img alt=" Упаковки и Подставки для Бижутерии" height="292" src="https://img.doreenbeads.com/promotion_photo/ru/images/20170306/764-292.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/ru/mandala-collection-c-2066_2869.html">
                <img alt=" Серия Дурмана Вонючий"  height="292" src="https://img.doreenbeads.com/promotion_photo/ru/images/20170306/764X292ru.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/ru/birthstone-jewelry-c-2066_2867.html">
                <img alt=" Драгоценность для дня рождении"  height="292" src="https://img.doreenbeads.com/promotion_photo/ru/images/20170228/764-292.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/ru/sun-moon-collection-c-2066_2868.html">
                <img alt="  Солнце&Луна Собирание"  height="292" src="https://img.doreenbeads.com/promotion_photo/ru/images/20170227/764X292ru.jpg" width="764px" />
            </a>
        </li>
        <li>
            <a href="https://www.doreenbeads.com/ru/crystal-dust-bracelets-c-2066_2865.html">
                <img alt="    Crystal Dust Bracelets"  height="292" src="https://img.doreenbeads.com/promotion_photo/ru/images/20170227/db-banner-1.jpg" width="764px" />
            </a>
        </li>
    </ul>
    <a id="toLeft" class="link toLeft"><</a>
    <a id="toRight" class="link toRight">></a>
</div>
<ul class="numsolider" id="idnumsolider" style="width:200px;"> </ul>
<div class="product_index">
    <!-- Hot -->
    <h3>Популярные Категории </h3>
    <dl class="popularpro">
        <dd>
            <a href="https://www.doreenbeads.com/ru/index.php?main_page=promotion&aId=18">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/216.gif" data-size="216" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20170301/216-374.jpg" alt=" Драгоценность Ручного: 30% Скидка" />
            </a>
        </dd>
        <dt>
            <ul>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/ru/index.php?main_page=promotion&aId=19">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20170302/258-150.jpg" alt=" Скидка достигает 70% " />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/ru/index.php?main_page=promotion&aId=19" title=" Скидка достигает 70%">
                            Скидка достигает 70%
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/ru/ethereal-butterfly-c-2066_2835.html">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20161219/258X150-butterfly.jpg" alt="Эфирная Бабочка " />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/ru/ethereal-butterfly-c-2066_2835.html" title="Эфирная Бабочка">
                            Эфирная Бабочка
                        </a>
                    </p>
                </li>
                <li><p class="popularimg">
                        <a href="https://www.doreenbeads.com/ru/index.php?main_page=products_common_list&pn=subject&aId=37">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20170213/258X150.jpg" alt="Бусины Буквы и Цифры" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/ru/index.php?main_page=products_common_list&pn=subject&aId=37" title="Бусины Буквы и Цифры">
                            Бусины Буквы и Цифры
                        </a>
                    </p>
                </li>
                <li>
                    <p class="popularimg">
                        <a href="https://www.doreenbeads.com/ru/index.php?main_page=promotion&aId=20">
                            <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20170302/258X150-db.jpg" alt="  Ткань Продажа Скидка до -35%" />
                        </a>
                    </p>
                    <p class="protext">
                        <a href="https://www.doreenbeads.com/ru/index.php?main_page=promotion&aId=20" title="  Ткань Продажа Скидка до -35%">
                            Ткань Продажа Скидка до -35%
                        </a>
                    </p>
                </li>
            </ul>
        </dt>
    </dl>
    <!-- Featured -->
    <h3>
        <a class="productlink" href="index.php?main_page=products_common_list&pn=new">Новые Поступления</a>
        <a class="productmore" href="index.php?main_page=products_common_list&pn=new">Больше>></a>
    </h3>
    <ul class="new_arrivals">
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/resin-pendants-pentagram-star-glitter-multicolor-39mm1-48-x-37mm1-48-5-pcs-p-119651.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086449.jpg" alt="Подвески из Смолы">
                </a>
            </p>
            <p class="newtext">
                <a title="Подвески из Смолы" href="https://www.doreenbeads.com/ru/resin-pendants-c-1729_1831_1835.html">
                    Подвески из Смолы
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/zinc-based-alloy-steampunk-charms-gear-gold-plated-hollow-18mm-68-x-18mm-68-30-pcs-p-119656.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086444.jpg" alt="  Стимпанк Серия">
                </a>
            </p>
            <p class="newtext">
                <a title="  Стимпанк Серия" href="https://www.doreenbeads.com/ru/steampunk-series-c-2066_2634.html">
                    Стимпанк Серия
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/copper-beading-wire-thread-cord-round-antique-bronze-04mm-26-gauge-1-roll-approx-10-mroll-p-119602.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086563.jpg" alt="Проволоки">
                </a>
            </p>
            <p class="newtext">
                <a title="Проволоки" href="https://www.doreenbeads.com/ru/wires-c-1729_1860_1862.html">
                    Проволоки
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/silicone-resin-mold-for-jewelry-making-white-49mm1-78-x-16mm-58-1-piece-p-119630.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086530.jpg" alt="Другие Инструменты">
                </a>
            </p>
            <p class="newtext">
                <a title="Другие Инструменты" href="https://www.doreenbeads.com/ru/others-tools-c-1888_1895.html">
                    Другие Инструменты
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/grade-d-howlite-imitated-turquoise-gemstone-loose-beads-cross-peacock-green-about-20mm-68-x-20mm-68-hole-approx-15mm-41cm16-18-long-1-piece-approx-20-pcsstrand-p-119585.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086636.jpg" alt="Бусины из Драгоценных Камней">
                </a>
            </p>
            <p class="newtext">
                <a title="Бусины из Драгоценных Камней" href="https://www.doreenbeads.com/ru/gemstone-beads-c-1729_1730_1740.html">
                    Бусины из Драгоценных Камней
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/glass-butterfly-wing-dome-seals-cabochon-round-flatback-at-random-12mm-48-dia-20-pcs-p-119583.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086314.jpg" alt="Стеклянный Кабошон и Наклейка">
                </a>
            </p>
            <p class="newtext">
                <a title="Стеклянный Кабошон и Наклейка" href="https://www.doreenbeads.com/ru/glass-dome-seals-c-1729_1762_1766.html">
                    Стеклянный Кабошон и Наклейка
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/glass-beads-round-royal-blue-about-10mm-38-dia-hole-approx-08mm-83cm32-58-long-1-piece-approx-83-pcsstrand-p-119541.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086361.jpg" alt="Стеклянные Бусины">
                </a>
            </p>
            <p class="newtext">
                <a title="Стеклянные Бусины" href="https://www.doreenbeads.com/ru/glass-beads-c-1729_1730_1741.html">
                    Стеклянные Бусины
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/copper-octagon-prong-settings-black-fits-10mm-x-8mm-13mm-48-x-8mm-38-10-pcs-p-119597.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086568.jpg" alt="Рамка для Кабошона">
                </a>
            </p>
            <p class="newtext">
                <a title="Рамка для Кабошона" href="https://www.doreenbeads.com/ru/cabochon-settings-c-1729_1768_1771.html">
                    Рамка для Кабошона
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/velvet-faux-suede-safety-pin-earrings-gold-plated-pink-tassel-pentagram-star-59mm2-38-post-wire-size-21-gauge-1-pair-p-119474.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086220.jpg" alt="Другие Серьги">
                </a>
            </p>
            <p class="newtext">
                <a title="Другие Серьги" href="https://www.doreenbeads.com/ru/other-style-earrings-c-1869_1880_2675.html">
                    Другие Серьги
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/copper-connectors-round-rose-gold-cabochon-settings-fits-10mm-dia-19mm-68-x-12mm-48-10-pcs-p-119610.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086555.jpg" alt="Коннектор и Рамка для Кабошона">
                </a>
            </p>
            <p class="newtext">
                <a title="Коннектор и Рамка для Кабошона" href="https://www.doreenbeads.com/ru/connectors-settings-c-1729_1768_1774.html">
                    Коннектор и Рамка для Кабошона
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/iron-based-alloy-ball-chain-necklace-antique-bronze-58cm22-78-long-chain-size-15mm-3-pcs-p-119574.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086640.jpg" alt="Ожерелье из Цепочек">
                </a>
            </p>
            <p class="newtext">
                <a title="Ожерелье из Цепочек" href="https://www.doreenbeads.com/ru/chain-necklace-c-1729_1825_1826.html">
                    Ожерелье из Цепочек
                </a>
            </p>
        </li>
        <li>
            <p class="newimg">
                <a href="https://www.doreenbeads.com/ru/acrylic-spacer-beads-round-at-random-initial-alphabet-letter-about-10mm-38-dia-hole-approx-24mm-100-pcs-p-119519.html">
                    <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0086424.jpg" alt="Акриловые Бусины">
                </a>
            </p>
            <p class="newtext">
                <a title="Акриловые Бусины" href="https://www.doreenbeads.com/ru/acrylic-beads-c-1729_1730_1732.html">
                    Акриловые Бусины
                </a>
            </p>
        </li>
    </ul>
    <!-- New -->
    <div class="product_index">
        <h3><a class="productlink" >Бестселлер</a></h3>
        <ul class="new_arrivals">
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/iron-based-alloy-book-scrapbooking-albums-menus-folders-corner-protectors-rose-gold-30mm-x-21mm1-18x-78-50-pcs-p-34288.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B22602.jpg" alt="Уголки для Альбомов">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Уголки для Альбомов" href="https://www.doreenbeads.com/ru/book-corner-protectors-c-1909_1911_1915.html">
                        Уголки для Альбомов
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/diy-fabric-craft-leaf-garland-ribbon-trim-green-25mm1-10-m-p-83752.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B62297.jpg" alt="Ленты и Банты">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Ленты и Банты" href="https://www.doreenbeads.com/ru/ribbon-bows-c-1909_1941.html">
                        Ленты и Банты
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/glass-bottles-cylinder-jewelry-vials-cork-stoppers-transparent-79cm3-18-x-22cm-78-5-pcs-p-76717.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B80968.jpg" alt="Коробочка для Бусин">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Коробочка для Бусин" href="https://www.doreenbeads.com/ru/storage-containers-c-1896_1908.html">
                        Коробочка для Бусин
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/9ml-f6000-glue-white-for-jewelry-diy-contain-liquid-97cm3-78-x-32cm1-28-1-piece-p-116334.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0082704.jpg" alt="Другие Инструменты">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Другие Инструменты" href="https://www.doreenbeads.com/ru/others-tools-c-1888_1895.html">
                        Другие Инструменты
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/pvc-diy-craft-photo-corner-transparent-self-adhesive-147cm5-68-x-101cm4-5-sheets-p-104363.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B70763.jpg" alt="Кабошон и Наклейка">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Кабошон и Наклейка" href="https://www.doreenbeads.com/ru/embellishment-findings-c-1909_1911_1914.html">
                        Кабошон и Наклейка
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/crystal-glass-loose-beads-round-peacock-blue-faceted-transparent-about-8mm-38-dia-hole-approx-1mm-70-pcs-p-19372.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B09097.jpg" alt="Стеклянные Бусины">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Стеклянные Бусины" href="https://www.doreenbeads.com/ru/glass-beads-c-1729_1730_1741.html">
                        Стеклянные Бусины
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/6pcs-antiqued-bronze-bookmark-with-loop-123mm-findings-p-11373.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B01276.jpg" alt="Закладки для Книг">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Закладки для Книг" href="https://www.doreenbeads.com/ru/bookmarks-c-1729_1753.html">
                        Закладки для Книг
                    </a>
                </p>
            </li>
            <li>
                <p class="newimg">
                    <a href="https://www.doreenbeads.com/ru/zinc-based-alloy-charms-leaf-antique-silver-21mm-78-x-20mm-68-20-pcs-p-118383.html">
                        <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/edm/20170204/B0084825.jpg" alt="Металлические Подвески">
                    </a>
                </p>
                <p class="newtext">
                    <a title="Металлические Подвески" href="https://www.doreenbeads.com/ru/leaf-jewelry-c-2066_2850.html">
                        Металлические Подвески
                    </a>
                </p>
            </li>
        </ul>
    </div>
</div>
<div class="bottom_img">
    <h3></h3>
    <a href="https://www.doreenbeads.com/ru/doll-necklace-c-2066_2851.html">
        <img style="margin-left: 12px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img1.doreenbeads.com/promotion_photo/ru/images/20170122/230X151.jpg"/>
    </a>
    <a href="https://www.doreenbeads.com/ru/organza-jewelry-bags-c-1896_1897_1899.html">
        <img style="margin-left: 12px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20170106/230X151.jpg"/>
    </a>
    <a href="https://www.doreenbeads.com/ru/leaf-jewelry-c-2066_2850.html">
        <img style="margin-left: 12px;" class="lazy-img" src="/includes/templates/cherry_zen/images/loading/258.gif" data-size="258" data-lazyload="https://img.doreenbeads.com/promotion_photo/ru/images/20170122/230-151-leaf.jpg"/>
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
                    if(l>=0){l=0;$j('.arrowleft').removeClass('on')
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
</script><!-- 到这里结束 -->

