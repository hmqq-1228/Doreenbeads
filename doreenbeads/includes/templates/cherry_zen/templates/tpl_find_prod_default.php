<?php
/**
 * tpl_find_prod_default.php
 * 查找新产品和bestseller产品的显示页面
 * 每行显示四个产品，只显示图片和编号
 */
?>
<div style="padding:0px 10px;">
<?php 
  if ($show_new_products == true){
?>
  <table border="0" width="100%" cellpadding="0" cellspacing="0" style="background:url(includes/templates/cherry_zen/images/<?php echo $bg_img_array[$bg_select]; ?>) bottom repeat-x;">
    <tr>
      <td style="background:url(includes/templates/cherry_zen/images/title_bg.png) 10px center no-repeat; text-align:left; padding:15px; height:25px; font-weight:bold;">
      <?php echo $catg_name; ?>
      </td>
    </tr>
    <tr>
      <td style="text-align:center; padding:5px 0px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
          <?php for ($i = 0; $i < sizeof($find_new_prod_array); $i++){ ?>
          <tr>
            <?php for ($j = 0; $j <sizeof($find_new_prod_array[$i]); $j++){ ?>
            <td style="">
              <?php echo zen_image(DIR_WS_IMAGES . $find_new_prod_array[$i][$j]['image'], '', '80', '80') . '<br />' . $find_new_prod_array[$i][$j]['model'];?>  
            </td>
            <?php } ?>
          </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
  </table>
<?php
  } elseif ($show_bestseller_products == true){
?>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align:center; padding:5px 0px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <?php for ($i = 0; $i < sizeof($bestseller_prod_array); $i++){ ?>
          <tr>
            <?php for ($j = 0; $j <sizeof($bestseller_prod_array[$i]); $j++){ ?>
            <td style="text-align:center;">
            <?php echo zen_image(DIR_WS_IMAGES . $bestseller_prod_array[$i][$j]['image'], '', '65', '65') . '<br />' . $bestseller_prod_array[$i][$j]['model'] . '&nbsp;&nbsp;' . $bestseller_prod_array[$i][$j]['order_num']; ?>
            </td>
            <?php } ?>
          </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
  </table>
<?php
  }
?>
</div>