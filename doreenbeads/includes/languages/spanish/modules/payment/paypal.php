<?php
define('MODULE_PAYMENT_PAYPAL_TEXT_ADMIN_TITLE', 'PayPal IPN');
define('MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_TITLE', 'PayPal IPN');

  if (IS_ADMIN_FLAG === true) {
define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal IPN</strong> (Servicio Bsico de PayPal)<br /><a href="https://www.paypal.com/mrb/mrb=R-6C7952342H795591R&pal=9E82WJBKKGPLQ" target="_blank">Administra su cuenta de PayPal.</a><br /><br /><font color="green">Instrucciones de Configuración:</font><br />
1. <a href="http://www.zen-cart.com/partners/paypal" target="_blank">Regístrese para obtener una cuenta de PayPal - haga clic aquí.</a><br />
2. En su cuenta de PayPal, en "Perfil",<ul><li>Configurar su <strong>Preferencias de Notificación de Pago Instantáneo</strong> por el URL:<br />' .str_replace('index.php?main_page=index','ipn_main_handler.php',zen_catalog_href_link(FILENAME_DEFAULT, '', 'SSL')) . '<br />(Si ya se ha utilizado el otro URL, puede usted dejarlo.)<br /><span class="alert">¡Asegúrese de que la casilla de verificación para activar IPN se ha comprobado!</span></li><li>en <strong>Preferencia de Pago en el Sitio Web</strong> establece su <strong>URL Automático de retorno</strong> en:<br />'. zen_catalog_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL',false). '</li>' . (defined('MODULE_PAYMENT_PAYPAL_STATUS') ? '' : '<li>... y haga clic en "instalar" para habilitar el soporte de PayPal... y en "editar" para decirle a Zen Carta su configuración de PayPal.</li>') . '</ul><font color="green"><hr /><strong>Requisitos:</strong></font><br /><hr />*<strong>Cuenta de PayPal</strong> (<a href="http://www.zen-cart.com/partners/paypal" target="_blank">haga clic para registrarse</a>)<br />*<strong>*<strong>El puerto 80</strong> se utiliza para la comunicación bidireccional con la puerta de entrada, por lo que debe estar abierto en el host del router / firewall<br />
*<strong>PHP allow_url_fopen()</strong> deben estar habilitado.<br />
*<strong>Ajustes</strong> deben configurarse como se describe anteriormente.');
  } else {
    define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
  }
define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', 'https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif');
define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT', 'Hacer pago con PayPal');
define('MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT', 'Ahorrar tiempo. Hacer pago de forma segura. <br /><div style="clear:both; padding-bottom:10px; padding-left:10px;">Usted puede pagar con tarjeta de crédito a través de PayPal, incluso sin cuenta de PayPal, <a href="http://www.8season-supplies.com/page.html?chapter=0&id=65">haga clic aquí para ver cómo>></a></div>');
define('MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT . '</span>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Nombre:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Apellido:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Nombre de la Empresa:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Nombre de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Calle de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Ciudad de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Estado de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'Postal de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'País de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'Email de Pagador:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'ID de Ebay:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'ID de Pagador:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Estado de Pagador:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Estado de Dirección:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Tipo de Pago:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Estado de Pago:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Razones Pendientes:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Factura:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Fecha de Pago:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Moneda:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Importe Total:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Cuota de Pago:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Tipo de Cambio:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Artículos en Cesta:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Tipo de Transacción:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'ID de Transacción:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'Parent Trans. ID:');
define('MODULE_PAYMENT_PAYPAL_PURCHASE_DECRIPTION_TITLE', STORE_NAME . ' Purchase');
?>
