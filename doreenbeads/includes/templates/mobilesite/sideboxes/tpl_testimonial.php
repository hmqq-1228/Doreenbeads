<?php 
/**
 * �����ļ�
 * �˿����۱߿���ʾ
 * tpl_testimonial.php
 * jessa 2010-06-17
 */
?>
<div class="rightBoxContainer" id="stock_on_hand" style="width:<?php echo BOX_WIDTH_RIGHT; ?>; text-align:center; padding:10px 0px;">
<a href="<?php echo zen_href_link(FILENAME_INVITE_FRIENDS); ?>"><img src="includes/templates/cherry_zen/images/invite_friends.jpg"></a>
</div>
<div class="rightBoxContainer" id="stock_on_hand" style="width:<?php echo BOX_WIDTH_RIGHT; ?>; text-align:center;">
<h3 class="rightBoxHeading"><a href="http://www.doreenbeads.com/index.php?main_page=testimonial">Testimonial</a></h3>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  	<td style="padding:0px; text-align:center;"><?php echo '<a href="' . zen_href_link(FILENAME_TESTIMONIAL) . '"><img src="includes/templates/cherry_zen/images/testimonial.jpg"></a>'; ?></td>
  </tr>
  <?php for ($testimonial_cnt = 0; $testimonial_cnt < sizeof($show_testimonial_boxes_array); $testimonial_cnt++){ ?>
  <tr>
  	<td style="padding:0px 5px 8px 5px; line-light:120%; text-align:left;">
  	<?php 
  		if (strlen($show_testimonial_boxes_array[$testimonial_cnt]['content']) > 300){
  			echo substr($show_testimonial_boxes_array[$testimonial_cnt]['content'], 0, 300) . '...';
  		} else {
  			echo $show_testimonial_boxes_array[$testimonial_cnt]['content'];
  		}
  	?>
  	</td>
  </tr>
  <tr>
  	<td style="text-align:right;font-weight:bold;padding:5px;border-bottom:1px solid #cccccc;"><?php echo $show_testimonial_boxes_array[$testimonial_cnt]['customer_name']; ?></td>
  </tr>
  <?php } ?>
  <tr>
  	<td style="padding:5px; text-align:right;"><?php echo '<a href="' .  zen_href_link(FILENAME_TESTIMONIAL) . '">More Testimonials>></a>'; ?></td>
  </tr>
  <tr>
  <?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){ ?>
  	<td style="padding:5px; text-align:right;"><?php echo '<a href="' .  zen_href_link(FILENAME_TESTIMONIAL) . '">Add Testimonials>></a>'; ?></td>
  <?php } else { ?>
  	<td style="padding:5px; text-align:right;"><?php echo '<a href="' .  zen_href_link(FILENAME_LOGIN) . '">Write A Testimonial>></a>'; ?></td>
  <?php } ?>
  </tr>
</table>
</div>