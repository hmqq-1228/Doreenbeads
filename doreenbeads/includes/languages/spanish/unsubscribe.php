<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @copyright Originally Programmed By: Christopher Bradley (www.wizardsandwars.com) for OsCommerce
 * @copyright Modified by Jim Keebaugh for OsCommerce
 * @copyright Adapted for Zen Cart
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: unsubscribe.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Darse de Baja');
define('HEADING_TITLE', 'Darse de baja de nuestro boletín de noticias');

define('UNSUBSCRIBE_TEXT_INFORMATION', '<br />Lamentamos escuchar que desea darse de baja de nuestro boletín de noticias. Si siente alguna inquietud por su privacidad, por favor, lea nuestro <a href="' . zen_href_link(FILENAME_PRIVACY,'','NONSSL') . '"><span class="pseudolink">aviso de privacidad</span></a>.<br /><br />Las suscripciones a nuevo boletín se mantienen notificadas de nuevos productos, reducción de precios, y noticias de la web.<br /><br />Si aún no desea recibir el boletín, por favor haga clic en el botón de abajo. ');
define('UNSUBSCRIBE_TEXT_NO_ADDRESS_GIVEN', '<br />Lamentamos escuchar que desea darse de baja de nuestro boletín de noticias. Si siente alguna inquietud por su privacidad, por favor, lea nuestro <a href="' . zen_href_link(FILENAME_PRIVACY,'','NONSSL') . '"><span class="pseudolink">aviso de privacidad</span></a>.<br /><br />Las suscripciones a nuevo boletín se mantienen notificadas de nuevos productos, reducción de precios, y noticias de la web.<br /><br />Si aún no desea recibir el boletín, por favor haga clic en el botón de abajo. Usted se llevará a la página de preferencias de la cuenta, donde podrá editar sus suscripciones. Es posible que se le pida que inicie sesición primero.');
define('UNSUBSCRIBE_DONE_TEXT_INFORMATION', '<br />Según su petición, la dirección de correo electrónico de usted, que se enumera abajo, se ha eliminada de nuestra lista de suscripción de boletín de noticias. <br /><br />');
define('UNSUBSCRIBE_ERROR_INFORMATION', '<br />La dirección de correo electrónico especificada no se encuentra en nuestra base de datos de boletín de noticias, o ya ha sido eliminada de nuestra lista de suscripción al boletín.<br /><br />');
?>