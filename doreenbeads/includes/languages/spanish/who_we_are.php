<?php
define ( 'NAVBAR_TITLE', 'Quiénes Somos' );
define ( 'PAGE_TITLE', 'Quiénes Somos' );
define ( 'TEXT_TERMS_AND_CONDITIONS', 'Términos y Condiciones' );
define ( 'TEXT_OUR_TEAM', 'Nuestro Equipo' );
define ( 'TEXT_QUALITY_CONTROL', 'Control de Calidad' );
define ( 'TEXT_SHIPPING_INFO', 'Información de Envío' );
define ( 'TEXT_ABOUT_US', 'Sobre Nosotros' );
define ( 'TEXT_CONTACT_US', 'Contáctenos' );
switch ($_GET ['id']) {
	case 1 :
		define ( 'NAVBAR_TITLE_1', BOX_INFORMATION_ABOUT_US );
		break;
	case 2 :
		define ( 'NAVBAR_TITLE_1', TEXT_TERMS_AND_CONDITIONS );
		break;
	case 3 :
		define ( 'NAVBAR_TITLE_1', BOTTOM_PRIVACY_POLICY );
		break;
	case 138 :
		define ( 'NAVBAR_TITLE_1', TEXT_OUR_TEAM );
		break;
	case 139 :
		define ( 'NAVBAR_TITLE_1', TEXT_QUALITY_CONTROL );
		break;
	case 140 :
		define ( 'NAVBAR_TITLE_1', TEXT_SHIPPING_INFO );
		break;
	case 157 :
		define ( 'NAVBAR_TITLE_1', TEXT_TERMS_CONDITIONS );
		break;
	case 9 :
		define ( 'NAVBAR_TITLE_1', TEXT_PRIVACY_POLICY );
		break;
	case 99999 :
		define ( 'NAVBAR_TITLE_1', TEXT_CONTACT_US );
		break;
	default :
		define ( 'NAVBAR_TITLE_1', TEXT_ABOUT_US );
}
define ( 'TEXT_TESTIMONIALS', 'Testimonios' );
define ( 'TEXT_HELP_CENTER', 'Centro de Ayuda' );
define ( 'TEXT_CUSTOMER_SERVICE_HOURS', 'Horario de Servicio al Cliente' );
define ( 'TEXT_FOR_YOUR_CONTACTING', 'Para que pueda contactarnos mejor, por favor recuerde nuestro horario de oficina. Trabajamos seis días a la semana. Todos los días de 8:30 a 18:00Horario Pekín(domingo a viernes). El tiempo de Pekín es:' );
define ( 'TEXT_BEIJING_TIME', 'Tiempo Pekín' );
