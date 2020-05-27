<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: download_time_out.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('NAVBAR_TITLE', 'Su descarga ...');
define('HEADING_TITLE', 'Su descarga ...');

define('TEXT_INFORMATION', 'Lo sentimos, pero el tiempo de su descarga ha expirado. <br /><br />Si tenía otras descargas y desea utilizarlas,por favor, diríjase a su página de<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mi Cuenta</a> para ver su pedido.<br /><br /> O, si piensa que existe algún problema con su pedido, por favor, <a href="' . zen_href_link(FILENAME_CONTACT_US) . '">pongáse en contacto con nosotros</a> <br /><br />¡Gracias!');
?>