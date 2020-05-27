<?php
/**
 * tpl_categories_reviews_default.php
 * ��ʾҳ���ļ�
 */
?>
<div id="newProductsDefault">
<h2 class="centerBoxHeading"><?php echo $current_categories_name . ' ' . BOX_HEADING_REVIEWS; ?></h2>
<div style="margin:0px 10px;padding:5px 0px;"><?php echo zen_split_show_info($start_num, $end_num, $total_num, $total_page_num, $page, $current_links, 'bottom'); ?></div>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<?php for ($i = ($start_num - 1); $i < $end_num; $i++){ ?>
  <tr>
    <td style="width:20%;text-align:center;padding:8px;vertical-align:top"><?php echo $show_categories_reviews_array[$i]['image']; ?></td>
    <td style="width:80%;padding:8px;vertical-align:top;line-height:150%;"><?php echo $show_categories_reviews_array[$i]['text']; ?></td>
  </tr>
<?php } ?>
</table>
<div style="margin:0px 10px;padding:5px 0px;"><?php echo zen_split_show_info($start_num, $end_num, $total_num, $total_page_num, $page, $current_links, 'top'); ?></div>
</div>