<?php
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_1', 'Realizar el módulo de pago transferencia bancaria(Banco de China)');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_2', '¿Quieres aceptar el pago de transferencia bancaria?(Banco de China)');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_1', 'Nombre de Cuenta:');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_2', 'Nombre del receptor de cuenta');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_1', 'Número de cuenta:');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_2', 'Número de cuenta del receptor');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_1', 'Receptor Telefónico:');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_2', 'Receptor Telefónico');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_1', 'Nombre del banco:');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_2', 'Nombre del banco');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_1', 'Sucursal del Banco:');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_2', 'Sucursal del Banco');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1', 'Código Swift:');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_2', 'Código Swift');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_1', 'Modificar orden de visualización.');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_2', 'Modificar orden de visualización. El más barato se muestra primero.');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_1', 'Establecer el estado del pedido');
define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_2', 'Establecer el estado de los pedidos realizados con este módulo de pago de este valor');
define('MODULE_PAYMENT_WIREBC_NOTES', 'Después de enviar el dinero, por favor envíenos un correo electrónico a service_es@8seasons.com con las siguientes informaciones:<br/>1) su nombre de usuario,<br/>2) número de orden, <br/>3) y el monto total que ha envidao<br/>');
define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_HEAD', '<strong>Transferencia Bancaria (Banco de China)</strong>');
define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_DISCOUNT', '&nbsp;(2% de descuento será ofrecido si el monto total llega a 2000$ dólares,<br/>
  La comisión debe ser pagada por el contribuyente. <a href="' .HTTP_SERVER. '/page.html?id=145" target="_blank">Haga clic aquí para más detalles>></a>)');
define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_END', '<br /><div style="clear:both; padding-bottom:10px;"><span style="color:#F47504"><strong>Asegúrese de leer esta importante nota antes de realizar el pago.</strong></span> <a href="' .HTTP_SERVER. '/page.html?chapter=0&id=95" target="_blank">Haga clic aquí>></a></div>');
define('MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK', 'Banco del beneficiario:');
define('MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE', 'Código SWIFT:');
define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME', 'Nombre del titular de la cuenta bancaria:');
define('MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER', 'Número de cuenta bancaria:');
define('MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS', 'Dirección del banco:');
define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE', 'Teléfono del titular de la cuenta bancaria:');
define('MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION',  '  <table cellpadding="0" cellspacing="0">
                     	<tr>
                         	<th width="135"><strong>' . MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK . '</strong></th>
                             <td> ' . MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK . '</td>
                         </tr>
                         <tr>
                         	<th><strong>' . MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE . '</strong></th>
                             <td> ' . MODULE_PAYMENT_WIREBC_SWIFT_CODE . '</td>
                         </tr>
                         <tr>
                         	<th><strong>' . MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME . '</strong></th>
                             <td> ' . MODULE_PAYMENT_WIREBC_HOLDER_NAME . '</td>
                         </tr>
                     </table>
                     <div class="borderbt"></div>
                     <table cellpadding="0" cellspacing="0">
                         <tr>
                         	<th width="135"><strong>' . MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER . '</strong></th>
                             <td>' . MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER . '</td>
                         </tr>
                         <tr>
                         	<th><strong>' . MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS . '</strong></th>
                             <td>' . MODULE_PAYMENT_WIREBC_BANK_ADDRESS . '</td>
                         </tr>
                         <tr>
                         	<th><strong>' . MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE . '</strong></th>
                             <td> ' . MODULE_PAYMENT_WIREBC_HOLDER_PHONE . '</td>
                         </tr>
                     </table>');
define('MODULE_PAYMENT_WIREBC_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION);
?>