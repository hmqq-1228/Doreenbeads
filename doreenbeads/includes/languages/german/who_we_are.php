<?php
define('NAVBAR_TITLE', 'Wer wir sind');
define('PAGE_TITLE', 'Wer wir sind');
define('TEXT_TERMS_AND_CONDITIONS','Allgemeine Geschäftsbedingungen');
define('TEXT_OUR_TEAM','Unser Team');
define('TEXT_QUALITY_CONTROL','Qualitätskontrolle');
define('TEXT_SHIPPING_INFO','Versandinformationen');
define('TEXT_ABOUT_US','Über uns');
define('TEXT_CONTACT_US','Uns kontaktieren');
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
		define('NAVBAR_TITLE_1', TEXT_TERMS_CONDITIONS);
		break;
	case 9:
		define('NAVBAR_TITLE_1', TEXT_PRIVACY_POLICY);
		break;
	case 99999:
		define('NAVBAR_TITLE_1', TEXT_CONTACT_US);
		break;
	default:
		define('NAVBAR_TITLE_1', TEXT_ABOUT_US);
}
define ( 'TEXT_TESTIMONIALS', 'Bewertung');
define ( 'TEXT_HELP_CENTER', 'Hilfezentrum' );
define ( 'TEXT_CUSTOMER_SERVICE_HOURS', 'Kundenservice-Stunden' );
define ( 'TEXT_FOR_YOUR_CONTACTING', 'Wir arbeiten wöchentlich sechs Tage, jeden Tag von 8:30 bis 18:00  China Zeit (Montag bis Samstag). Für Ihren bequemen Kontakt, bitte achten darauf. Jetzt ist Zeit in China:' );
define ( 'TEXT_BEIJING_TIME', 'Zeit in China' );
define ( 'CUSTOMER_SERVICE_EMAIL', 'service_de@doreenbeads.com' );