<?php
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_ADMIN_TITLE', 'Linkpoint/YourPay API');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_CATALOG_TITLE', 'Tarjeta de Crédito');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_DESCRIPTION', '<a target="_blank" href="https://secure.linkpt.net/lpcentral/servlet/LPCLogin">Linkpoint/YourPay Merchant Login</a>' . (MODULE_PAYMENT_LINKPOINT_API_TRANSACTION_MODE_RESPONSE != 'LIVE: Production' ? '<br /><br /><strong>Linkpoint/YourPay API Test Card Numbers:</strong><br /><strong>Visa:</strong> 4111111111111111<br /><strong>MasterCard:</strong> 5419840000000003<br /><strong>Amex:</strong> 371111111111111<br /><strong>Discover:</strong> 6011111111111111' : ''));
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_DESCRIPTION', '<a target="_blank" href="http://www.zen-cart.com/index.php?main_page=infopages&pages_id=30">Haga clic aquí a registrarse para crear una cuenta</a><br /><br /><a target="_blank" href="https://secure.linkpt.net/lpcentral/servlet/LPCLogin">Linkpoint/YourPay API Merchant Area</a><br /><br /><strong>Requerimientos:</strong><br /><hr />
<p>*<strong>LinkPoint o Cuenta de YourPay</strong> (ver enlace anterior para el registro)<br />
  *<strong>Se requiere URL</strong>y deberá ser compilado en PHP por su empresa de alojamiento<br />
  *<strong>Puerto 1129</strong> se utiliza para la comunicación bidireccional con la puerta de acceso, por lo que debe estar abierto en el router/firewall de su anfitrión.<br />
  *<strong>PEM RSA Key File </strong>Certificado Digital:<br />
  Para obtener y cargar su clave de certificado digital(PEM):<br />
  - Ingrese a su cuenta de LinkPoint/Yourpay en su página web<br />
  - Haga clic en "Ayuda" en la barra de menú principal.<br />
  - Haga clic en la palabra "Centro de Descarga" bajo descargas en la Casilla de Menú.<br />
  - Haga clic en la palabra "deacargar" al lado de la sección "Store PEM File" en la parte derecha de la página.<br />
  - Ingrese la información necesaria para comenzar la descarga. Usted tendrá que proporcionar su actual SSN o identificación fiscal que presentó durante el proceso de embacar cuenta de comerciante.<br />
  - Cargar este archivo en incluye/módulos/pago/linkpoint_api/XXXXXX.pem (proporcionado por LinkPoint - xxxxxx es su identificación de tienda)</p>');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_TYPE', 'Tipo de Tarjeta de Crédito:');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_OWNER', 'Titular de la tarjeta de Crédito:');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_NUMBER', 'Número de Tarjeta de Crédito:');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_CVV', 'Número CVV:');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_EXPIRES', 'Fecha de Caducidad de Tarjeta de Crédito :');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_JS_CC_OWNER', '* El nombre del titular de la tarjeta debe tener al menos ' . CC_OWNER_MIN_LENGTH . ' caracteres.\n');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_JS_CC_NUMBER', '* El número de la tarjeta de crédito debe tener al menos ' . CC_NUMBER_MIN_LENGTH . ' caracteres.\n');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_JS_CC_CVV', '* Usted tiene que ingresar el número de 3 o 4 dígitos en el reverso de su tarjeta de crédito');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_ERROR', '¡Error de Tarjeta de Crédito!');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_DECLINED_MESSAGE', 'Su tarjeta ha sido declinada. Por favor vuelva a ingresar la información de su tarjeta, pruebe a usar otra tarjeta, o póngase en contacto con el dueño de la tienda para obtener la ayuda.');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_DECLINED_AVS_MESSAGE', 'Dirección de facturación no es válida. Por favor, vuelva a ingresar la información de su tarjeta, pruebe a usar otra tarjeta o póngase en contacto con el dueño de la tienda para obtener la ayuda.');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_DECLINED_GENERAL_MESSAGE', 'Su tarjeta ha sido declinada. Por favor vuelva a ingresar la información de su tarjeta, pruebe a usar otra tarjeta, o póngase en contacto con el dueño de la tienda para obtener la ayuda.');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_POPUP_CVV_LINK', '¿Qué es esto?');
define('ALERT_LINKPOINT_API_PREAUTH_TRANS', '***AUTOLIZACIÓN SÓLO -- LOS GARGOS SE LIQUIDARÁN MÁS TARDE POR EL ADMINISTRADOR.***');
define('ALERT_LINKPOINT_API_TEST_FORCED_SUCCESSFUL', 'NOTA: Esta fue una transacción de Prueba...obligado a devolver una respuesta de ÉXITO.');
define('ALERT_LINKPOINT_API_TEST_FORCED_DECLINED', 'NOTA: Esta fue una transacción de Prueba...obligado a devolver una respuesta RECHAZADA.');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(NOTA: El módulo todavía no está configurado.)</span>');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_ERROR_CURL_NOT_FOUND', 'Funciones CURL no encontrado - necesarios para el módulo de pago de Linkpoint API');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_FAILURE_MESSAGE', 'Disculpe por la inconveniencia, pero en este momento no podemos contactar con la compañía de tarjetas de crédito para la autoriazión. Por favor póngase en contacto con el propietario de la tienda para que organize métodos alternativos de pago.');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_GENERAL_ERROR', 'Lo sentimos. Hubo un error del sistema al procesar su tarjeta. Su información es segura. Por favor notifique al propietario de la tienda para organizar métodos alternativos de pago.');
define('MODULE_PAYMENT_LINKPOINT_API_LINKPOINT_ORDER_ID', 'Linkpoint ID de orden:');
define('MODULE_PAYMENT_LINKPOINT_API_AVS_RESPONSE', 'AVS Respuesta:');
define('MODULE_PAYMENT_LINKPOINT_API_MESSAGE', 'Mensaje de Respuesta:');
define('MODULE_PAYMENT_LINKPOINT_API_APPROVAL_CODE', 'Código de la Aprobación:');
define('MODULE_PAYMENT_LINKPOINT_API_TRANSACTION_REFERENCE_NUMBER', 'Número de Referencia:');
define('MODULE_PAYMENT_LINKPOINT_API_FRAUD_SCORE', 'Puntuación de Fraude:');
define('MODULE_PAYMENT_LINKPOINT_API_TEXT_TEST_MODE', '<span class="alert">&nbsp;(NOTA: El módulo está en el modo de pruebas)</span>');
?>