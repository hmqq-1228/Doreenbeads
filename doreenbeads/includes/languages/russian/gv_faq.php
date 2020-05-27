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
// $Id: gv_faq.php 4155 2006-08-16 17:14:52Z ajeh $
//

define('NAVBAR_TITLE', TEXT_GV_NAME . ' FAQ');
define('HEADING_TITLE', TEXT_GV_NAME . ' FAQ');

define('TEXT_INFORMATION', '<a name="Top"></a>
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=1','NONSSL').'">Купить ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=2','NONSSL').'">Как отправить ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=3','NONSSL').'">Покупать с ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=4','NONSSL').'">Выкупать ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=5','NONSSL').'">Когда возникают проблемы</a><br />
');
switch ($_GET['faq_item']) {
  case '1':
define('SUB_HEADING_TITLE','Купить ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT', TEXT_GV_NAMES . ' Подарочные сертификаты покуплены точно так же, как и любой другой товар в нашем магазине. Вы можете оплатить за них с помощью стандартного(ых) способа (ов) оплаты магазина.
  Раз вы купили, ценность ' . TEXT_GV_NAME . ' будут добавлены в ваш ​​личный
   ' . TEXT_GV_NAME . ' Счёт. Если у вас есть средства в вашем ' . TEXT_GV_NAME . ' Счёте, вы заметите, что количество теперь показывается в корзине, а также обеспечивает
   ссылку на страницу, где вы можете отправить ' . TEXT_GV_NAME . ' кому-то через электронную почту.');
  break;
  case '2':
define('SUB_HEADING_TITLE','Как Отправить ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT','Чтобы отправить ' . TEXT_GV_NAME . ' Вы должны пойти на наш Отправить ' . TEXT_GV_NAME . ' страницу. Вы можете найти ссылку на эту страницу в корзине в правую колонку каждой страницы.
  Когда вы отправляете ' . TEXT_GV_NAME . ', вам надо указать следующее.
  Имя человека, которому вы посылаете ' . TEXT_GV_NAME . ' в.
  Адрес электронной почты человека, который вы отправляете ' . TEXT_GV_NAME . ' на.
  Сумма, которую вы хотите отправить. (Примечание вы не должны отправить обшую сумму, которая в вашем' . TEXT_GV_NAME . ' Счёте.)
  Короткое сообщение будет появляться на электронной почте.
  Прежде чем письмо будет послано, Пожалуйста, убедитесь, что вы ввели всю информацию правильно, хотя у вас будет возможность изменить это столько, сколько вы хотите.');
  break;
  case '3':
  define('SUB_HEADING_TITLE','Покупать с ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','Если у вас есть средства в вашем ' . TEXT_GV_NAME . ' Счёте, вы можете использовать эти средства для
   приобретения других товаров в нашем магазине. На стадии оформления заказа, дополнительная коробка будет
   появляться. Введите сумму, чтобы применять средство в вашем ' . TEXT_GV_NAME . ' Счёте.
  Пожалуйста, обратите внимание, вам всё равно придётся, чтобы выбрать другой способ оплаты, если нет достаточной суммы в вашем ' . TEXT_GV_NAME . ' счёте, чтобы покрыть расходы на покупку.
  Если у вас есть больше средств в вашем ' . TEXT_GV_NAME . ' Счёте, чем общей стоимости
   вашей покупки, остальные деньги остаются в вашем ' . TEXT_GV_NAME . ' Счёте для будущего.');
  break;
  case '4':
  define('SUB_HEADING_TITLE','Выкупать ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','Если вы получаете ' . TEXT_GV_NAME . ' по электронной почте, это будет содержать информацию о том, кто послал
   вам ' . TEXT_GV_NAME . ', наверное, наряду с коротким сообщениям от них. Это письмо также будет содержать ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . '. Это, вероятно, хорошая идея, чтобы напечатать
   это письмо для дальнейшего использования. Теперь вы можете выкупить ' . TEXT_GV_NAME . ' в течение двух дней.<br /><br />
  1. Нажав ссылку, содержающуюся в электронном письме для этой конкретной цели.
   Это позволяет вам перейти ' . TEXT_GV_NAME . ' на страницу "выкупать" нашего магазина. Вы будете требовать создать счёт, прежде чем ' . TEXT_GV_NAME . ' будет утвержден и помещен в ваш
   ' . TEXT_GV_NAME . ' Счёт, чтобы вы тратить его на что вы хотите.<br /><br />
  2. В процессе оформления заказа, на той же странице, на которой вы выбираете способ оплаты,
будет коробка, чтобы ввести ' . TEXT_GV_REDEEM . '. Введите ' . TEXT_GV_REDEEM . ' здесь, и
нажмите кнопку "Выкупать". Код будет
утверждён и сумма добавляется в ваш ' . TEXT_GV_NAME . ' Счёт. Затем вы можете использовать сумму для приобретения любого товара от нашего магазина');
  break;
  case '5':
  define('SUB_HEADING_TITLE','Когда возникают проблемы.');
  define('SUB_HEADING_TEXT','По любым вопросам, касающимся ' . TEXT_GV_NAME . ' Системы, пожалуйста, свяжитесь с магазином
   по электронной почте на '. STORE_OWNER_EMAIL_ADDRESS . '. Пожалуйста, убедитесь, что вы предоставите
   информацию как можно больше в письме. ');
  break;
  default:
  define('SUB_HEADING_TITLE','');
  define('SUB_HEADING_TEXT','Выбирайте один из вышеперечисленных вопросов, пожалуйста.');

  }

  define('TEXT_GV_REDEEM_INFO', 'Пожалуйста, введите ваш ' . TEXT_GV_NAME . ' код выкупа: ');
  define('TEXT_GV_REDEEM_ID', 'Код Выкупа:');
?>