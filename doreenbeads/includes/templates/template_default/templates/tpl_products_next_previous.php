<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_products_next_previous.php 6912 2007-09-02 02:23:45Z drbyte $
 */

/*
 WebMakers.com Added: Previous/Next through categories products
 Thanks to Nirvana, Yoja and Joachim de Boer
 Modifications: Linda McGrath osCommerce@WebMakers.com
*/

?>
<div class="navNextPrevWrapper centeredContent">
<?php
// only display when more than 1
  if ($products_found_count > 1) {
?>
<!--jessa 2009-10-23 删除以下的php输出代码，目的是删除显示在类别上面的标识正在看第几个产品和总的产品书数目，如：2/26
<p class="navNextPrevCounter">
<?php //echo (PREV_NEXT_PRODUCT); ?>
<?php //echo ($position+1 . "/" . $counter); ?>
</p>
eof jessa 2009-10-23 -->
<div class="navNextPrevList"><a href="<?php echo zen_href_link('product_info', "cPath=$cPath&products_id=$previous"); ?>"><?php echo $previous_image . $previous_button; ?></a></div>

<div class="navNextPrevList"><a href="<?php echo zen_href_link(FILENAME_DEFAULT, "cPath=$cPath"); ?>"><?php echo zen_image_button(BUTTON_IMAGE_RETURN_TO_PROD_LIST, BUTTON_RETURN_TO_PROD_LIST_ALT); ?></a></div>

<div class="navNextPrevList"><a href="<?php echo zen_href_link('product_info', "cPath=$cPath&products_id=$next_item"); ?>"><?php echo  $next_item_button . $next_item_image; ?></a></div>
<?php
  }
?>
</div>