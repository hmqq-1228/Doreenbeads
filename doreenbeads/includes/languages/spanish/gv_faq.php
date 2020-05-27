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
   <a href="' .zen_href_link(FILENAME_GV_FAQ,'faq_item=1','NONSSL'). '">Compras ' . TEXT_GV_NAMES . '</a><br />
   <a href="' .zen_href_link(FILENAME_GV_FAQ,'faq_item=2','NONSSL'). '">Cómo enviar ' . TEXT_GV_NAMES . '</a><br />
   <a href="' .zen_href_link(FILENAME_GV_FAQ,'faq_item=3','NONSSL'). '">Comprando con ' . TEXT_GV_NAMES . '</a><br />
   <a href="' .zen_href_link(FILENAME_GV_FAQ,'faq_item=4','NONSSL'). '">Canjear ' . TEXT_GV_NAMES . '</a><br />
   <a href="' .zen_href_link(FILENAME_GV_FAQ,'faq_item=5','NONSSL'). '">Cuando hay problema</a><br />
 ');
switch ($_GET['faq_item']) {
  case '1':
define('SUB_HEADING_TITLE','Compras ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT', TEXT_GV_NAMES . ' se compran como cualquier otro artículo en nuestra tienda. Usted puede pagarlos utilizando forma de pago estándar de las tiendas.
   Una vez adquirido, el valor del ' . TEXT_GV_NAME . 'será añadido en su propia.
    ' . TEXT_GV_NAME . ' cuenta. Si usted tiene fondos en su ' . TEXT_GV_NAME . ' cuenta, te darás
   cuenta de que la cantidad ahora se muestra en la cesta de la compra, y también proporciona un enlace a una página donde podrá enviar el archivo ' . TEXT_GV_NAME . ' a alguien por email.');
  break;
  case '2':
define('SUB_HEADING_TITLE', 'Cómo enviar . TEXT_GV_NAMES');
define('SUB_HEADING_TEXT', 'Para enviar un archivo ' . TEXT_GV_NAME . ' usted tiene que ir a nuestra página ' . TEXT_GV_NAME . ' de Enviar. Usted puede encontrar el enlace a esta página en la caja cesta en la columna derecha de cada página.
   Cuando se envía un archivo' . TEXT_GV_NAME . ', es necesario especificar la siguiente.
   El nombre de la persona que está enviando el archivo ' . TEXT_GV_NAME . ' a.
   La dirección de correo electrónico de la persona que está enviando el archivo 'TEXT_GV_NAME . 'a.
   La cantidad que desea enviar. (Tenga en cuenta que usted no necesita enviar la cantidad total que está en su ' . TEXT_GV_NAME . ' cuenta.)
   Un mensaje corto que parecerá en el email.
   Por favor, asegúrese de ingresar toda la información correctamente,aunque se le dará la oportunidad de modificar esto tantas veces como desee antes de que el correo electrónico se envía realmente.'); 
  break;
  case '3':
  define('SUB_HEADING_TITLE','Buying with ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','If you have funds in your ' . TEXT_GV_NAME . ' Account, you can use those funds to
  purchase other items in our store. At the checkout stage, an extra box will
  appear. Enter the amount to apply from the funds in your ' . TEXT_GV_NAME . ' Account.
  Please note, you will still have to select another payment method if there
  is not enough in your ' . TEXT_GV_NAME . ' Account to cover the cost of your purchase.
  If you have more funds in your ' . TEXT_GV_NAME . ' Account than the total cost of
  your purchase the balance will be left in your ' . TEXT_GV_NAME . ' Account for the
  future.');
  break;
  case '4':
define('SUB_HEADING_TITLE', 'Comprar con ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT', 'Si usted tiene fondos en su ' . TEXT_GV_NAME . ' cuenta, Puede utilizar esos fondos para comprar otros artículos de nuestra tienda. cuando los paque. una caja adicional se aparecerá. Ingrese la cantidad a aplicar de los fondos en su ' . TEXT_GV_NAME . ' cuenta.
   Por favor tenga en cuenta de que tendrá que seleccionar otra forma de pago si no 
   es suficiente en su ' . TEXT_GV_NAME . ' cuenta para cubrir el costo de su compra.
   Si tiene más fondos en su ' . TEXT_GV_NAME . ' cuenta que el costo total de su compra, la diferencia será mantenida en su ' . TEXT_GV_NAME . ' cuenta para el futuro.');
define('SUB_HEADING_TITLE', 'Cambio . TEXT_GV_NAMES');
define('SUB_HEADING_TEXT', 'Si recibe un ' . TEXT_GV_NAME . ' por email,el cual contiene los detalles de quién le envió el ' . TEXT_GV_NAME . ', juntos con un posible pequeño mensaje. El correo también contendrá el ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' . Probablemente sea una buena idea impirmir este email para futuras refeerencias. ahora puede canjear el ' . TEXT_GV_NAME . ' en dos maneras.<br /><br />
   1. Al hacer clic en el enlace que contiene el email justo para este propósito.
   Esto le llevará a la página de' . TEXT_GV_NAME . ' Almacenamiendo de canje. A continuación, se le solicitará
   para crear una cuenta, antes de que el ' . TEXT_GV_NAME . ' sea válido y puesto en su
    ' . TEXT_GV_NAME . ' cuenta  lista para gastarlo en lo que quieras.<br /><br />
   2. Durante el pago, en la misma página en la que elije una forma de pago, habrá una caja para ingresar ' . TEXT_GV_REDEEM . ' . Ingrese el ' . TEXT_GV_REDEEM . ' aquí, haga clic en el botón de canjear. El código será validado y sumado a su' . TEXT_GV_NAME . ' cuenta. A continuación, puede usar esa cantidad para comprar cualquier artículo de nuestra tienda');

  break;
  case '5':
 define('SUB_HEADING_TITLE', 'Cuando hay problemas.');
define('SUB_HEADING_TEXT', 'Para cualquier pregunta relacionada con el ' . TEXT_GV_NAME . ' sistema, póngase en contacto con la tienda por correo electrónico a ' . STORE_OWNER_EMAIL_ADDRESS . ' . Por favor asegúrese de ofrecer tanta información como sea posible en el email.');

  break;
  default:
  define('SUB_HEADING_TITLE','');
  define('SUB_HEADING_TEXT', 'Por favor elija una de las preguntas de arriba.');
define('TEXT_GV_REDEEM_INFO', 'Por favor ingrese su ' . TEXT_GV_NAME . ' códiogo de redención:');
define('TEXT_GV_REDEEM_ID', 'Código de redención:');

?>