<?php
define('NAVBAR_TITLE', 'Qui Sommes-Nous');
define('PAGE_TITLE', 'Qui Sommes-Nous');
define('TEXT_TERMS_AND_CONDITIONS','Termes & Conditions');
define('TEXT_OUR_TEAM','Notre Equipe');
define('TEXT_QUALITY_CONTROL','Contrôle-Qualité');
define('TEXT_SHIPPING_INFO',' Infos de Livraison');
define('TEXT_ABOUT_US','A propos de nous');
define('TEXT_CONTACT_US','Contacter nous');
switch($_GET['id']){
	case 1:
		define('NAVBAR_TITLE_1', BOX_INFORMATION_ABOUT_US);
		break;
	case 2:
		define('NAVBAR_TITLE_1', TEXT_TERMS_AND_CONDITIONS);
		break;
	case 3:
		define('NAVBAR_TITLE_1', BOTTOM_PRIVACY_POLICY);
		break;
	case 138:
		define('NAVBAR_TITLE_1', TEXT_OUR_TEAM);
		break;
	case 139:
		define('NAVBAR_TITLE_1', TEXT_QUALITY_CONTROL);
		break;
	case 140:
		define('NAVBAR_TITLE_1', TEXT_SHIPPING_INFO);
		break;
	case 157:
		define('NAVBAR_TITLE_1', TEXT_TERMS_AND_CONDITIONS);
		break;
	case 9:
		define('NAVBAR_TITLE_1', TEXT_PRIVACY_POLICY);
		break;
	case 163:
		define('NAVBAR_TITLE_1', TEXT_OUR_TEAM);
		break;
	case 164:
		define('NAVBAR_TITLE_1', TEXT_QUALITY_CONTROL);
		break;
	case 165:
		define('NAVBAR_TITLE_1', TEXT_SHIPPING_INFO);
		break;
	case 99999:
		define('NAVBAR_TITLE_1', TEXT_CONTACT_US);
		break;
	default:
		define('NAVBAR_TITLE_1', TEXT_ABOUT_US);
}
define ( 'TEXT_TESTIMONIALS', 'Avis' );
define ( 'TEXT_HELP_CENTER', 'Aide' );
define ( 'TEXT_CUSTOMER_SERVICE_HOURS', 'Heures de Service à la clientèle' );
define ( 'TEXT_FOR_YOUR_CONTACTING', 'Nous travaillons six jours par semaine, tous les jours de 8h30 à 18h00 l\'heure de Chine (lundi - samedi). Pour nous contacter facilement, veuillez le noter. Maintenant l\'heure de Chine est:' );
define ( 'TEXT_BEIJING_TIME', 'Heure en Chine' );
define ( 'CUSTOMER_SERVICE_EMAIL', 'service_fr@doreenbeads.com' );