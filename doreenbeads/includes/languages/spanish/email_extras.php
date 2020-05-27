<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>Desde:</strong>');
  define('OFFICE_EMAIL','<strong>Email:</strong>');

  define('OFFICE_SENT_TO','<strong>Enviado a:</strong>');
  define('OFFICE_EMAIL_TO','<strong>Email a:</strong>');

  define('OFFICE_USE', '<strong>Para uso oficial solamente:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>Nombre de usuario:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>Email de usuario:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>Teléfono:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>Fax:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>Dirección IP:</strong>');

  define('OFFICE_HOST_ADDRESS','<strong>Dirección Host:</strong>');
  define('OFFICE_DATE_TIME','<strong>Fecha y Tiempo:</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'Cerrar');

// email disclaimer
  define('EMAIL_DISCLAIMER', 'Esta dirección de correo electrónico fue dada a nosotros por usted o por uno de nuestros clientes. Si usted piensa que ha recibido este mensaje por error, por favor envíe un correo electrónico a %s ');
  define('EMAIL_SPAM_DISCLAIMER','ste email ha sido enviado de acuerdo con la ley de Us CAN-SPAM que entró en vigor en 01/01/2004. Las peticiones para darse de baja deberán ser enviadas a esta dirección, y serán cumplidas y respetadas.');
 define('EMAIL_FOOTER_COPYRIGHT', 'Copyright (c) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Basado en <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>');
  define('TEXT_UNSUBSCRIBE', "\n\nPara darse de baja del boletín y correos promocionales, siempre puede hacer clic en el siguiente enlace: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANTE:</strong> Para su protección y para prvenir usos maliciosos, todos los emails enviados a través de este sitio son registrados y sus contenidos son grabados y están disponibles para el dueño de la tienda. Si usted piensa que ha recibido este mensaje por error, por favor envíe un correo electrónico a ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>Este mensaje se incluye en todos los e-mails enviados desde esta página:</strong>');
define('TEXT_EMAIL_NEWSLETTER', '');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT', '[CREAR CUENTA]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT', '[COMPARTALO CON UN AMIGO]');
  define('SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT', '[VALES DE COMPRA]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT', '[NUEVO PEDIDO]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[INFO EXTRA DE PEDIDO CON TARJETA] #');

// Low Stock Emails
define('EMAIL_TEXT_SUBJECT_LOWSTOCK', 'Advertencia: Bajo Stock');
define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE', 'Aviso de stock bajo: ');


// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Discapacitado');
?>