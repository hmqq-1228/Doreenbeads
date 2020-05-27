<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_reviews_write.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Comentarios');
define('SUB_TITLE_FROM', 'Escrito por: ');
define('SUB_TITLE_REVIEW', 'Por favor, díganos lo que piensa y comparta sus opiniones con otras personas. Asegúrese de enfocar sus comentarios en el producto.');
define('SUB_TITLE_RATING', 'Escoja un ranking para este artículo. 1 estrella es el peor y 5 estrellas es el mejor.');

define('TEXT_NO_HTML', '<strong>NOTA:</strong>  Etiquetas HTML no están permitidas.');
define('TEXT_BAD', 'El peor');
define('TEXT_GOOD', 'El mejor');
define('TEXT_PRODUCT_INFO', '');

//jessa 2009-10-25 add 'While reviews require prior aprroval before they will be displayed' ޸ĲƷ write views ʾ
define('TEXT_APPROVAL_REQUIRED', '<strong>NOTA:</strong>&nbsp;Los comentarios requieren de aprobación previa a su publicación.');
//eof jessa 2009-10-25

define('EMAIL_REVIEW_PENDING_SUBJECT', '¡El comentario del producto ha sido recibido!');
define('EMAIL_PRODUCT_REVIEW_CONTENT_INTRO', 'Un comentario para %s se ha presentado y requiere su aprobación. ' ."\n\n");
define('EMAIL_PRODUCT_REVIEW_CONTENT_DETAILS', 'Detalles del comentario: %s');

?>