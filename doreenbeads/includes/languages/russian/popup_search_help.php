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

define('HEADING_SEARCH_HELP', 'Помощь для поиска');
define('TEXT_SEARCH_HELP', 'Ключевые слова могут быть разделены И и / или ИЛИ для лучшего контроля результатов поиска.<br /><br />Например, <span style="text-decoration:underline;">Microsoft И мышь</span>  будет получать результат, содержающий оба слова. Однако, для <u>мыши ИЛИ клавиатура</u>, результ будет содержать оба слова или одно из слов.<br /><br />Для точных матчей, можно искать слова, заключая их в двойные кавычки.<br /><br />Например, <span style="text-decoration:underline">"ноутбук"</span> будет генерировать результирующий набор, который совпадает с этой фразой целиком.<br /><br />Скобки могут использоваться, чтобы управлять порядком набора результатов.<br /><br />Например, <span style="text-decoration:underline;">Microsoft и (клавиатуры или мыши или "Visual Basic")</span>.');
define('TEXT_CLOSE_WINDOW', '<span class="pseudolink">Закрыть Окно</span> [x]');

?>