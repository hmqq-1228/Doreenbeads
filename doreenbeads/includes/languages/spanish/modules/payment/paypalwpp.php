<?php
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_EC', 'Pago exprés del Paypal');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_WPP', 'Pago Pro de PayPal');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PRO20', 'Pago Pro Payflow Edition');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_EC', 'PayPal Payflow Pro - Gateway');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_GATEWAY', 'Payflow Pro de PayPal +  Pago Exprés');

if (IS_ADMIN_FLAG === true) {
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_DESCRIPTION', '<p><strong>Pago Exprés de PayPal</strong>%s<br />
  ' . (substr(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE,0,7) == 'Payflow' ? '<a href="https://manager.paypal.com/loginPage.do?partner=ZenCart" target="_blank">Administrar su cuenta de PayPal.</a>' : '<a href="http://www.zen-cart.com/partners/paypal" target="_blank">Administrar su cuenta de PayPal.</a>') . '<br />
  <br />
  <font color="green">Instrucciones de Configuración:</font><br />
  <span class="alert">1. </span><a href="http://www.zen-cart.com/partners/paypal" target="_blank">Regístrese para obtener su cuenta de PayPal - haga clic aquí.</a><br />
  ' .   (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') ? '' : ' ... Y haga clic en "Instalar" para habilitar la compatibilidad con Pago Exprés.</br>
  ') .   (MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'PayPal' && (!defined('MODULE_PAYMENT_PAYPALWPP_APISIGNATURE') || MODULE_PAYMENT_PAYPALWPP_APISIGNATURE == '') ? '<span class="alert">2. </span><strong>Credenciales de API</strong> de la opción de Credenciales de API en su área de Configuración de Perfil de PayPal. Este módulo utiliza la opción de <strong>Firma API</strong> -- se necesita el nombre de usuario, contraseña y firma para entrar en el campo de abajo' : (substr(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE,0,7) == 'Payflow' && (!defined('MODULE_PAYMENT_PAYPALWPP_PFUSER') || MODULE_PAYMENT_PAYPALWPP_PFUSER == '') ? '<span class="alert">2. </span><strong>Credenciales de PAYFLOW</strong> Este módulo necesita la<strong>Socio de PAYFLOW+Vendedor+Usuario+Configuración de Contraseña</strong> introducidos en el 4 campos de abajo. Estos serán utilizados para comunicarse con el sistema de Payflow y autorizar las transacciones en su cuenta' : '<span class="alert">2. </span>Asegúrese de haber introducido los datos de seguridad adecuadas para el nombre de usuario/pwd etc, abajo. ') ) .   (MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'PayPal' ? '<br />
  <span class="alert">3. </span>En su cuenta de PayPal, active<strong>Notificación de Pago Instantánea</strong>:<br />
  en "Perfil", seleccione<em> Preferencia de Notificación de Pago Instantánea</em></p>
<ul style="margin-top: 0.5;"><li>Haga clic en el checkbox para activar IPN</li><li>Si no hay una URL especificada, establezca la dirección URL a:<br />' .str_replace('index.php?main_page=index','ipn_main_handler.php',zen_catalog_href_link(FILENAME_DEFAULT, '', 'SSL')) . '</li></ul>' : '') .   '<font color="green"><hr /><strong>Requisitos:</strong></font><br /><hr />
*<strong>CURL</strong> se utiliza para la comunicación bidireccional con la puerta de acceso, por eso debe estar activo en el servidor de hosting (Si usted necesita utilizar un proxy CURL, puede establecer la configuración de proxy CURL bajo Admin->Configuración->Mi Tienda.)<br />
<hr />');
}
define('MODULE_PAYMENT_PAYPALWPP_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_TITLE', 'Tarjeta de Crédito');
define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TYPE', 'Pago exprés de PayPal');
define('MODULE_PAYMENT_PAYPALWPP_DP_TEXT_TYPE', 'Pago Directo de PayPal');
define('MODULE_PAYMENT_PAYPALWPP_PF_TEXT_TYPE', 'Tarjeta de Crédito');
define('MODULE_PAYMENT_PAYPALWPP_ERROR_HEADING', 'Lo sentimos, perono hemos podido procesar su tarjeta de crédito.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CARD_ERROR', 'La información de su tarjeta de crédito que ha ingresado contiene un error. Por favor, verifíquelo e inténtelo de nuevo.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_FIRSTNAME', 'Nombre de Tarjeta de Crédito:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_LASTNAME', 'Apellido de Tarjeta de Crédito:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_OWNER', 'Nombre del Titular:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_TYPE', 'Tipo de Tarjeta de Crédito:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_NUMBER', 'Número de Tarjeta de Crédito:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_EXPIRES', 'Fecha de Caducidad de Tarjeta de Crédito:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_ISSUE', 'Fecha de Emisión de Tarjetas de Crédito:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER', 'Número CVV:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(en la parte posterior de la tarjeta de crédito');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_DECLINED', 'Su tarjeta de crédito ha sido rechazada. Por favor, pruebe con otra tarjeta o póngase en contacto con su banco para obtener más información.');
define('MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE', 'No podemos procesar su pedido. Por favor, inténtelo de nuevo, seleccione un método alternativo de pago, o póngase en contacto con el dueño de la tienda para obtener ayuda.');
define('MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE_ADDRESS', 'De acuerdo con los juicios de PayPal, esta transacción no se puede procesar, porque el envío del país no está permitido por el país de residencia del comprador. No te preocupes, por favor, póngase en contacto con nosotros por<a href="mailto:service_es@8seasons.com">service_es@8seasons.com</a> para procesar el pago.  Le contestaremos dentro de 24horas. Gracias');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_ERROR', 'Se ha producido un error cuando intentamos contactar con el procesador de pagos. Por favor, inténtelo de nuevo, seleccione un método alternativo de pago o póngase en contacto con el dueño de la tienda para obtener ayuda.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_MESSAGE', 'Estimado propietario de la tienda,' . "\n" . 'Se ha producido un error al intentar iniciar una transacción de PayPal Checkout Express. Como cortesía, sólo se demostrará el "número" error a su cliente. Los detalles del error se muestran a continuación. ' . "\n\n");
define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_SUBJECT', 'ALERTA: Error de  PayPal Express Checkout');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR', 'La información de la dirección que ha ingresado usted no parece ser válido o no puede ser igualada. Por favor, seleccione o agregue una dirección diferente y vuelva a intentarlo.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR_FOR_SHIPPING_ADDRESS', '10736 Dirección de envío válida Ciudad Código Postal Estado -Un partido de la ciudad de la dirección de envío, estado y código postal fracasado.<br/> Compruebe por favor amablemente su dirección del envío de nuevo y <a href="javascript:void(0');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CONFIRMEDADDR_ERROR', 'La dirección que ha seleccionado en PayPal no es una dirección confirmada. Por favor, regrese a PayPal y seleccione o agregue una dirección confirmada e inténtelo de nuevo.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'PayPal era incapaz de financiar con éxito esta transacción. Por favor elija otra opción de pago o las opciones de financiación de revvisión en su cuenta de PayPal antes de proceder.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ERROR', 'Se ha producido un error cuando intentamos procesar su tarjeta de crédito. Por favor, inténtelo de nuevo, seleccione un método alternativo de pago o póngase en contacto con el dueño de la tienda para obtener ayuda.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_CARD', 'Pedimos disculpas por las molestias. Pero la tarjeta de crédito que ha ingresado no es lo que acpetamos. Utilice una diferente tajeta de crédito.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_LOGIN', 'Hubo un problema al validar su cuenta. Por favor, inténtelo de nuevo.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_OWNER', '* El nombre del titular de la tarjeta debe tener al menos ' . CC_OWNER_MIN_LENGTH . ' caracteres.\n');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_NUMBER', '* El número de tarjeta de crédito debe ser al menos ' . CC_NUMBER_MIN_LENGTH . ' caracteres.\n');
define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVS_FAILURE_TEXT', 'ALERTA: El Fracaso de Verificación de Dirección.');
define('MODULE_PAYMENT_PAYPALWPP_ERROR_CVV_FAILURE_TEXT', 'ALERT: Fracaso de Tarjeta CVV Código de Verificación.');
define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVSCVV_PROBLEM_TEXT', 'El pedido está pendiente de edición por el propietario de la tienda.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_EC_HEADER', 'Pagar Rápido y Seguro con PayPal:');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_TEXT', 'Ahorrar tiempo. Hacer el pago de forma segura. Pagar sin compartir su información financiera.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_ALTTEXT', 'Haga clic aquí para pagar con PayPal Exprés');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_STATE_ERROR', 'El estado asignado a su cuenta no es válido. Por favor, vaya a la configuración de su cuenta a modificarlo.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'Pedimos disculpas por las molestias. El pago no se pudo iniciar porque la cuenta de PayPal configurada por el dueño de la tienda no es una cuenta de de Pago de PayPal Pro o serviciosde puerta de enlace de PayPal que no se han adquirido. Por favor, seleccione un método alternativo de pago para su pedido.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_SANDBOX_VS_LIVE_ERROR', 'Pedimos disculpas por las molestias. La cuenta de PayPal en este almacén está mal configurada actualmente para usar caja de arena mezclada y configuración en directo. No somos capaces de completar su transcción. Por favor notifique al dueño de la tienda para que puedan corregir este problema.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_WPP_BAD_COUNTRY_ERROR', 'Lo sentimos- la cuenta de PayPal configurada por el administrador de la tienda se basa en un país que no es compatible para el Pagos en sitio Web Pro en la actualidad. Por favor, elija otro método de pago para completar su pedido.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(NOTA: El módulo no está configurado aún)</span>');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_GETDETAILS_ERROR', 'Hubo un problema al recuperar detalles de la transacción.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_TRANSSEARCH_ERROR', 'Hubo un problema al localizar las transacciones que coinciden con los criterios especificados.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_ERROR', 'Hubo un problema al anular la transacción.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_ERROR', 'Hubo un problema de la devolución del importe de la operación especificada.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_ERROR', 'Hubo un problema al autorizar la transacción.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_ERROR', 'Hubo un problema al capturar la transacción.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUNDFULL_ERROR', 'Su solicitud de reembolso fue rechazada por PayPal.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_REFUND_AMOUNT', 'Ha solicitado un reembolso parcial pero no ha especificado la cantidad.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_ERROR', 'Ha solicitado un reembolso completo, pero no lo ha marcado la cesta de confirmación para vierificar su intención.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_AUTH_AMOUNT', 'Usted solicitó una autorización sin especificar la cantidad.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_CAPTURE_AMOUNT', 'Ha solicitado la captura pero no ha especificado la cantidad.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', 'Confirmar');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_ERROR', 'Ha solicitado a anular una transacción sin marcar la cesta de confirmación para verificar su intención.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', 'Confirmar');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_CONFIRM_ERROR', 'Usted solicitó una autorización sin marcar la cesta de confirmación para verificar su intención.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', 'Ha solicitado fondos de captura, pero no ha marcado la cesta de confirmación para verificar su intención.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_INITIATED', 'PayPal reembolso por%s iniciado. ID de Transacción: %s. Actualice la pantalla para ver los detalles de confirmación actualizadas en la sección de Historial del Estado del Pedido/Comentarios.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_INITIATED', 'PayPal reembolso por%s iniciado. Actualice la pantalla para ver los detalles de confirmación actualizadas en la sección de Historial del Estado del Pedido/Comentarios.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_INITIATED', 'PayPal reembolso por%s iniciado. ID de Recibo:% s. Actualice la pantalla para ver los detalles de confirmación actualizadas en la sección de Historial del Estado del Pedido/Comentarios.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_INITIATED', 'PayPal Solicitud Vacío iniciada. ID de Transacción: %s. Actualice la pantalla para ver los detalles de confirmación actualizadas en la sección de Historial del Estado del Pedido/Comentarios.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_API_ERROR', 'Hubo un error en el intento de transacción. Por favor consulte la guía de referencia de la API o de los registros de transacciones para obtener información detallada.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_ZONE_ERROR', 'Le pedimos disculpas por las molestias, sin embargo, en la actualidad, no podemos utilizar PayPal para procesar los pedidos de la región geográfica que ha seleccionado como su dirección de PayPal. Por favor, contiúe usando el pago normal y seleccione una de las formas de pago disponibles para finalizar su pedido.');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ORDER_ALREADY_PLACED_ERROR', 'Parece que su pedido fue presentado dos veces. Por favor, revise "Mi Cuenta" para ver los detalles reales del pedido. Utilice el formulario de contacto si su pedido no aparece aquí. Pero ya está pagado desde su cuenta de PayPal, por eso podemos comprobar nuestros registros y reconciliar esto con usted.');
define('MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_IMG', 'includes/templates/cherry_zen/buttons/english/btn_xpressCheckout.gif');
define('MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_SM_IMG', DIR_WS_CATALOG.DIR_WS_IMAGES.'payment/btn_xpressCheckoutsm.gif');
define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', DIR_WS_CATALOG.DIR_WS_IMAGES.'payment/PayPal_mark_37x23.gif');
define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', '<strong>Hacer pago con PayPal <br /></strong>');
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
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TITLE', '<strong>Reembolsos de Pedido</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_FULL', 'Si desea reembolsar esta orden en su totalidad, haga clic aquí:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_FULL', 'Hacer Reembolso Completo');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_PARTIAL', 'Hacer Devolución Parcial');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_FULL_OR', '<br />...o ingrese lo parcial');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PAYFLOW_TEXT', 'Ingresar el');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PARTIAL_TEXT', 'Reembolsará la cantidad aquí y haga clic en el reembolso parcial');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_SUFFIX', '*Un reembolso completo no puede funcionar después de un reembolso parcial se ha aplicado.<br />*Múltiples reembolsos parciales están permitidos hasta el saldo restante no reembolsado.');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Nota mostrada para el cliente:</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Devuelto por el Administrador de la Tienda');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_CHECK', 'Confirmar:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_TITLE', '<strong>Autorizaciones de Pedido</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_PARTIAL_TEXT', 'Si desea autorizar parte de este pedido, ingrese la cantidad aquí:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_BUTTON_TEXT_PARTIAL', 'Hacer Autorización');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_SUFFIX', '');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Nota mostrada para el cliente:</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Devuelto por el Administrador de la Tienda');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TITLE', '<strong>Captura de Autorización</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FULL', 'Si desea capturar la totalidad o parte de las cantidades autorizadas destacadas para este pedido, Ingrese la cantidad de captura y seleccione si esta es la captura final de este pedido.  Comprobar la cesta de confirmación antes de enviar su solicitud de captura.<br />');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_BUTTON_TEXT_FULL', 'Realizar una Captura');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_AMOUNT_TEXT', 'La Cantidad a Capturar:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FINAL_TEXT', '¿Es la captura final?');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_SUFFIX', '');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TEXT_COMMENTS', '<strong>Nota para mostrarse a los clientes:</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'Gracias por su pedido');
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_CHECK', 'Confirmar:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TITLE', '<strong>Anulación de autorización de orden</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID', 'Si desea anular una autorización, ingrese el ID de autorización de aquí y confirme por favor:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TEXT_COMMENTS', '<strong>Nota para mostrarse a los clientes:</strong>');
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_DEFAULT_MESSAGE', 'Gracias por su patrocinio. Deseamos que pueda volver nuevamente.');
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', 'Anularse');
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', '');
define('MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'Trans-estatal:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', 'Código de Autorización:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'AVS Dirección coincide:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'AVS ZIP coincide:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'CVV2 coincide:');
define('MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', 'Fecha de Liquidación:');
define('EMAIL_EC_ACCOUNT_INFORMATION', 'Los datos de acceso a su cuenta, que usted puede utilizar para revisar su compra, son los siguientes:');
?>