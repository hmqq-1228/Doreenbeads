<?php
/**
 * tpl_modules_write_review.php
 * �����ļ�
 * �ͻ�д��Ʒreviews��ģ��
 */
?>
<div class="centerColumn" id="reviewsWritemodule" style="padding:8px;border:1px solid #9AACBA;line-height:135%;">
<h2 class="centerBoxHeading"><?php echo TEXT_WRITE_REVIEWS_TITLE; ?></h2>
<div style="clear:both; padding:10px 8px;">
<?php echo zen_draw_form('product_reviews_write', zen_href_link(FILENAME_PRODUCT_INFO, 'action=wirte_reviews&products_id=' . $_GET['products_id'], 'SSL'), 'post', 'onsubmit="return checkForm(product_reviews_write);"'); ?>
<!--on 2010-12-12 ���Ӳ�Ʒ��rating��ʾ-->
<?php if (zen_get_product_rating($_GET['products_id']) != 0){ ?>
  <div style="text-align:left; margin-top:0px; padding-left:8px;line-height:240%">
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td colspan="2" style="padding:0px 5px;"><?php echo '<span style="color:green;">Product Overall Rating:</span>'; ?></td>
      <td style="padding:0px;">
      <?php 
      	echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . ceil(zen_get_product_rating($_GET['products_id'])) . '.gif');
      ?>
      </td>
      <td style="padding:0px; width:90px;color:green;font-weight:bold;">
        <?php 
    	  echo number_format(zen_get_product_rating($_GET['products_id']), 1);
        ?>
      </td>
      <td colspan="2" style="padding:0px 15px;"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $_GET['products_id']) . '" target="_blank">' . ($flag_show_product_info_reviews_count == 1 ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : '').'</a>'; ?></td>
      <td colspan="2" style="padding:0px 15px;"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $_GET['products_id']) . '" target="_blank">' . 'Read All Reviews</a>'; ?></td>
    </tr>
  </table>
<br />
  </div>
<?php } ?>
<?php if ($messageStack->size('review_text') > 0) echo $messageStack->output('review_text'); ?>

<div id="reviewsWriteReviewsRate" class="center" ><?php echo SUB_TITLE_RATING; ?></div>

<div class="ratingRow">
<?php echo zen_draw_radio_field('rating', '1', '', 'id="rating-1"'); ?>
<?php echo '<label class="" for="rating-1">' . zen_image($template->get_template_dir(OTHER_IMAGE_REVIEWS_RATING_STARS_ONE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . OTHER_IMAGE_REVIEWS_RATING_STARS_ONE, OTHER_REVIEWS_RATING_STARS_ONE_ALT) . '</label> '; ?>

<?php echo zen_draw_radio_field('rating', '2', '', 'id="rating-2"'); ?>
<?php echo '<label class="" for="rating-2">' . zen_image($template->get_template_dir(OTHER_IMAGE_REVIEWS_RATING_STARS_TWO, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . OTHER_IMAGE_REVIEWS_RATING_STARS_TWO, OTHER_REVIEWS_RATING_STARS_TWO_ALT) . '</label>'; ?>

<?php echo zen_draw_radio_field('rating', '3', '', 'id="rating-3"'); ?>
<?php echo '<label class="" for="rating-3">' . zen_image($template->get_template_dir(OTHER_IMAGE_REVIEWS_RATING_STARS_THREE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . OTHER_IMAGE_REVIEWS_RATING_STARS_THREE, OTHER_REVIEWS_RATING_STARS_THREE_ALT) . '</label>'; ?>

<?php echo zen_draw_radio_field('rating', '4', '', 'id="rating-4"'); ?>
<?php echo '<label class="" for="rating-4">' . zen_image($template->get_template_dir(OTHER_IMAGE_REVIEWS_RATING_STARS_FOUR, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . OTHER_IMAGE_REVIEWS_RATING_STARS_FOUR, OTHER_REVIEWS_RATING_STARS_FOUR_ALT) . '</label>'; ?>

<?php echo zen_draw_radio_field('rating', '5', '', 'id="rating-5"'); ?>
<?php echo '<label class="" for="rating-5">' . zen_image($template->get_template_dir(OTHER_IMAGE_REVIEWS_RATING_STARS_FIVE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . OTHER_IMAGE_REVIEWS_RATING_STARS_FIVE, OTHER_REVIEWS_RATING_STARS_FIVE_ALT) . '</label>'; ?>
</div>

<div style="padding:8px 0px; padding-top:0px; text-align:center;"><?php echo SUB_TITLE_REVIEW; ?></div>
<div style="clear:both;"><?php echo zen_draw_textarea_field('review_text', 60, 3, '', 'id="review-text" style="float:none;"'); ?></div>
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></div>
</form>
<br /><br />
</div>
</div>