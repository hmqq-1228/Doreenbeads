<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_reviews_default.php 2905 2006-01-28 01:25:36Z birdbrain $
 */

  //reviews ����Ҫ���뵽products_reviews_info���ҳ�������ˣ���ȫȥ��������ҳ��
?>
<div class="centerColumn" id="allProductsDefault">

<h1 id="allProductsDefaultHeading"><?php echo 'Read What Others Are Saying';  ?></h1>
<?php
  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>
<div style="padding:10px;">
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="">
		<?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?>
	</td>
    <td class="" align="right">
		<?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?>
	</td>
  </tr>
</table>
</div>
<!--<div id="reviewsDefaultListingTopNumber" class="navSplitPagesResult"><?php //echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>

<div id="reviewsDefaultListingTopLinks" class="navSplitPagesLinks"><?php //echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
-->
<?php
    }

    $reviews = $db->Execute($reviews_split->sql_query);
    while (!$reviews->EOF) {
    	//by zhouliang
    	$str_customers_name = $reviews->fields['customers_name'];
    	$arr_allname = explode(" ", $str_customers_name);
    	$str_customers_firstname = '';
    	for ($i=0;$i<sizeof($arr_allname)-1;$i++){
    		$str_customers_firstname .= $arr_allname[$i];
    	}
    	//end
    	$customer_info = zen_get_customers_info($reviews->fields['customers_id']);
    	$nameArray = explode(" ", $reviews->fields['customers_name']);
    	array_pop($nameArray);
    	$reviews->fields['customers_name'] = implode($nameArray);
?>
<hr />

<div class="smallProductImage back"><?php echo '<a onmouseover="showlargeimage(\''.HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($reviews->fields['products_image'], 500, 500).'\')" onmouseout="hidetrail();" href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $reviews->fields['products_id']) . '" target="_blank"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($reviews->fields['products_image'], 130, 130) . '" width="110" height="110"></a>'; ?></div>

<div class="forward">
<div class="buttonRow"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $reviews->fields['products_id']) . '" target="_blank">' . zen_image_button(BUTTON_IMAGE_READ_REVIEWS , BUTTON_READ_REVIEWS_ALT) . '</a>'; ?></div>
<div class="buttonRow"><?php echo '<a href="' . zen_href_link('product_info', 'products_id=' . $reviews->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_GOTO_PROD_DETAILS , BUTTON_GOTO_PROD_DETAILS_ALT) . '</a>'; ?></div>
</div>

<h2><?php echo '<a href="' . zen_href_link('product_info', 'products_id=' . $reviews->fields['products_id']) . '">'. $reviews->fields['products_name'] . '</a>'; ?></h2>

<div class="rating"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews->fields['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews->fields['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $reviews->fields['reviews_rating']); ?></div>

<div class="content"><?php echo zen_break_string(nl2br(zen_output_string_protected(stripslashes($reviews->fields['reviews_text']))), 60, '-<br />') . ((strlen($reviews->fields['reviews_text']) >= 100) ? '...' : ''); ?></div> 

<div><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, zen_date_short($reviews->fields['date_added'])); ?>&nbsp;by<?php echo '<b>' . sprintf(TEXT_REVIEW_BY, zen_output_string_protected($str_customers_firstname)) . ',&nbsp;' . $customer_info['default_country'] . '</b>'; ?></div>
<br class="clearBoth" />
<?php
      $reviews->MoveNext();
    }
?>
<?php
  } else {
?>
<div id="reviewsDefaultNoReviews" class="content"><?php echo TEXT_NO_REVIEWS; ?></div>
<?php
  }
?>
<?php
  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<hr />
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="">
		<?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?>
	</td>
    <td class="" align="right">
		<?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?>
	</td>
  </tr>
</table>
</div>
<!--<div id="reviewsDefaultListingBottomNumber" class="navSplitPagesResult"><?php //echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>

<div id="reviewsDefaultListingBottomLinks" class="navSplitPagesLinks"><?php //echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>-->
<br class="clearBoth" />
<?php
  }
?>
</div>
</div>
