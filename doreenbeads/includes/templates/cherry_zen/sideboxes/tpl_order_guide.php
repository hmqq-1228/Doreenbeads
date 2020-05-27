<?php if($_SESSION['languages_id'] == 1){?>
<div class="sidesafe_icon">
	<a href="/page.html?id=202"><img alt="Post, Share and Win CASH!" src="https://img.doreenbeads.com/promotion_photo/en/images/20150602/win-cash.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a href="http://www.doreenbeads.com/handmade-jewelry-c-2066_2472.html"><img alt="Handmade Jewelry" src="https://img.doreenbeads.com/promotion_photo/en/images/20160222/en-handmade-jewelry.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a title="FREE Jewelry Maker's Catalog of Best Sellers 2015" href="http://www.doreenbeads.com/page.html?id=205"><img alt="Free Catalog" src="https://img.doreenbeads.com/promotion_photo/en/images/20160308/free-catalog-en.jpg"></a>
</div>
<?php }elseif($_SESSION['languages_id'] == 2){ ?>
<div class="sidesafe_icon">
	<a href="http://www.doreenbeads.com/de/page.html?id=202"><img alt="" src="https://img.doreenbeads.com/promotion_photo/de/images/20150605/de-post.jpg"></a>
	<?php if(!$_SESSION['customer_id']){ ?>
	<br/><br/><a href="https://www.doreenbeads.com/de/index.php?main_page=login"><img alt="" src="https://img.doreenbeads.com/promotion_photo/de/images/20151012/coupon-de.jpg"></a>
	<?php } ?>
</div>
<div class="sidesafe_icon">
	<a href="http://www.doreenbeads.com/de/handmade-jewelry-c-2066_2472.html"><img alt="Handgefertigter Schmuck" src="https://img.doreenbeads.com/promotion_photo/de/images/20160222/de-handmade-jewelry.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a title="Katalog von Bestseller 2015 für Schmuckmacher" href="http://www.doreenbeads.com/de/page.html?id=205"><img alt="Gratis Katalog" src="https://img.doreenbeads.com/promotion_photo/de/images/20160308/db-de.jpg"></a>
</div>
<?php }elseif($_SESSION['languages_id'] == 3){ ?>
<div style="margin-top:15px;">
	<a href="http://www.doreenbeads.com/ru/page.html?id=194"><img alt="dorabead safe guarantee" src="http://www.doreenbeads.com/promotion_photo/ru/images/20140325/xiadan.png"></a>
	<?php if(!$_SESSION['customer_id']){ ?>
	<br/><br/><a href="http://www.doreenbeads.com/ru/index.php?main_page=login"><img alt="Получите купон на $6.01" src="http://www.doreenbeads.com/promotion_photo/ru/images/20140424/db_coupon.jpg"></a>
	<?php } ?>
	<br/><br/><a href="http://www.doreenbeads.com/ru/page.html?id=202"><img src="https://img.doreenbeads.com/promotion_photo/ru/images/20150610/ru.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a href="http://www.doreenbeads.com/ru/handmade-jewelry-c-2066_2472.html"><img alt="Ювелирные изделия ручной работы" src="https://img.doreenbeads.com/promotion_photo/ru/images/20160222/ru-jewelry.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a title="2015 Ходовой каталог изготовлений ювелирных изделий" href="http://www.doreenbeads.com/ru/page.html?id=205"><img alt="Бесплатная Категория" src="https://img.doreenbeads.com/promotion_photo/fr/images/20160308/db-ru-catalog2.jpg"></a>
</div>
<?php }elseif($_SESSION['languages_id'] == 4){ ?>
<div class="sidesafe_icon">
	<a href="http://www.doreenbeads.com/fr/page.html?id=202"><img alt="" src="https://img.doreenbeads.com/promotion_photo/fr/images/20150605/fr-partager.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a href="http://www.doreenbeads.com/fr/handmade-jewelry-c-2066_2472.html"><img alt="Bijoux Faits Main" src="https://img.doreenbeads.com/promotion_photo/fr/images/20160222/fr-handmade-jewelry.jpg"></a>
</div>
<div class="sidesafe_icon">
	<a title="2015 Catalogue de Best-Sellers de Fabricants de Bijoux" href="http://www.doreenbeads.com/fr/page.html?id=205"><img alt="Catalogue" src="https://img.doreenbeads.com/promotion_photo/fr/images/20160308/dbfr-catalogue.jpg"></a>
</div>
<?php if(!$_SESSION['customer_id']){?>
<div class="sidesafe_icon" style="padding:0px">
	<a rel="nofollow" href="<?php echo zen_href_link(FILENAME_LOGIN);?>"><img src="<?php echo DIR_WS_LANGUAGE_IMAGES.'register_coupon.jpg';?>" alt="$ 6,01 Offerts pour Nouveau Client"/></a>
</div>
<?php }?>
<?php } ?>