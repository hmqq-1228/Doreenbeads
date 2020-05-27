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
// $Id: popup_search_help.php 2471 2005-11-29 01:14:18Z drbyte $
//

define('HEADING_SEARCH_HELP', 'Ayuda sobre Búsquedas');
define('TEXT_SEARCH_HELP', 'Las palabras clave pueden ser separadas por las declaraciones AND y/o OR para un mayor control de los resultados de la búsqueda.<br /><br />Por ejemplo, <span style="text-decoration:underline;"> Microsoft AND Ratón </span> generaría un conjunto de resultados que contengan ambas palabras. Sin embargo,  para <u>Ratón OR Teclado</u>, tel conjunto de resultados retornado podrían contener las dos o una sola palabra.<br /><br />Resultados exactos pueden buscarse encerrando las palabras entre comillas.<br /><br />Por ejemplo, <span style="text-decoration:underline"> "computadora notebook"</span> la búsqueda daría como resultado el conjunto que tenga exactamente esa cadena.<br /><br />BLos parentesis pueden ser utilizados para controlar el orden en el conjunto de resultados.<br /><br />Por ejemplo, <span style="text-decoration:underline;">Microsoft and (keyboard or mouse or "visual basic").</span>.');
define('TEXT_CLOSE_WINDOW', '<span class="pseudolink">Cerrar Ventana</span> [x]');


?>