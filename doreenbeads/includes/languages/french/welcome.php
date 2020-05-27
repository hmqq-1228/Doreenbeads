<?php

define('WELCOME_8SEASONS_OLD','<span style="color:#e4691b;font-size:36px;">Bienvenue à Doreenbeads </span>');
define('ACCOUNT_SUCCESS_DESCRIBES_SELECTED','
		<p>vous pouvez profiter des politiques préférentielles suivantes maintenant.:</p>
		<p>1. Merci de votre inscription de doreenbeads.com, nous vous avons offert un coupon comme le premier cadeau pour vous.<br>
			<div style="line-height:20px;font-weight:bold;"> 
				Valeur Nominale: US$ 6,01<br>
				Montant Minimum d’Utilisation: Coupon de US$ 6,01 pour la valeur des achats ≥ US $ 30<br>
				Date d’expiration: Le %s
			</div>
		</p>
		<p>2.Réduction de Commande Unique<br/>Il suffit de passer vos commandes librement; la réduction sera prise automatiquement lors de votre paiement.</p>
		<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
			<tr><td width="135"><strong>Prix Total d’Achat</strong><br>(Les articles en solde exclus)</td><th width="80">Réduction</th></tr>
			<tr><td>Plus de US $49</td><td><b>3%% </b></td></tr>
			<tr><td>Plus de US $199</td><td><b>5%% </b></td></tr>
			<tr><td>Plus de US $499</td><td><b>8%% </b></td></tr>
			<tr><td>Plus de US $999</td><td><b>10%% </b></td></tr>
		</table>
		<p>3. Lorsque le montant total de vos commandes précédentes sur notre site est jusqu’à $200, notre système vous ajoutera automatiquement à notre groupe VIP. La réduction de VIP sera appliquée selon notre <a style="color:#0786CB;" href="'.zen_href_link(FILENAME_HELP_CENTER,'id=65').'">Politique de VIP</a>.</p>
		<p>4. En savoir plus sur <a href="'.zen_href_link(FILENAME_HELP_CENTER,'id=15').'">les Méthodes de Paiement</a> ou <a href="'.zen_href_link(FILENAME_HELP_CENTER,'id=181').'">d\'Expédition.</a></p>
		');

define('ACCOUNT_SUCCESS_FRENCH','<p style="margin-bottom:10px;"><b>Votre compte a été créé avec succès. </b></p><b>En créant un compte sur notre site, vous pouvez acheter des articles préférés avec moins de tracas et plus rapidement. De plus, vous pourriez obtenir un bon de réduction de 20€ pour votre première commande.  Après avoir passé une commande, vous pouvez également télécharger des photos des produits que vous avez achetés.</b>');
define('NOW_YOU_CAN','<b>Maintenant, vous pouvez:</b>');
//define('LIST1','<font ><b>Envoyer votre profil</b></font>');
define('LIST1_DESCRIBES_SELECTED','<font><b>Mettre à jour votre profil</b></font>');
define('LIST1_DESCROBES_GIVEUP', '<font><b>Mettre à jour votre profil et gagner un coupon de <span style="color:#FF854A">%s</span></b></font>');
define('LIST2','<font ><b>Ajouter l’adresse d’expédition</b></font>');
define('LIST3','Apprendre <a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_HELP_CENTER,'&id=214') . '"><font ><b>Lire le guide de passer une commande</b></font></a>');
define('LIST4','Voir <a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_MYACCOUNT) . '" ><font ><b>Vérifier votre compte</b></font></a>');
define('LIST5','<font ><b>Retourner à la page d’accueil</b></font>');
define('LIST6','<font ><b>Voir la politique de VIP</b></font>');
define('NEW_ARRIVALS','Nouveautés');
define('SHIIPING_ON','<font style="color:#555;size:13px;"><b>Acheter sur </b></font><a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">' . NEW_ARRIVALS . '</a>');
define('FEATURED','Produits Spécifiques');
define('NAVBAR_TITLE','Mon 8seasons');
define('BEST_SELLER','Meilleures ventes');
define('MYACCOUNT_TIPS_MORE','<li style="margin-top:10px;color:#6fa4d2">'.zen_image(DIR_WS_LANGUAGE_IMAGES.'li_blue.jpg').'&nbsp;&nbsp;<b>Passer une commande supérieur à 100€  et profiter du bon de réduction de 20€</b></li><li style="margin-top:10px;color:#6fa4d2">'.zen_image(DIR_WS_LANGUAGE_IMAGES.'li_blue.jpg').'&nbsp;&nbsp;<b>Bien retenir que la date valide du bon de reduction de 20€ est d’aujourd’hui au premier octobre</b></a></li>');
define('LEARN', 'Apprendre');
define('TEXT_CART_RECENTLY_ADD_SUCCESSFULLY', 'Vous avez ajouté au panier avec succès');
define('TEXT_CART_RECENTLY_ITEMS_TOTALLY', 'article(s) au total');
define('TEXT_CART_RECENTLY_VIEW_CART', 'Voir le panier');
define('TEXT_CART_RECENTLY_CLOSE', 'Fermer');
?>