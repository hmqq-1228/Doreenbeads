<?php
  if ($zc_hidden_discounts_on) {
?>

  <table style="border-collapse:collapse;cellspacing:0;cellpadding:0;border:1px solid #aaa;font-size:14px;margin-bottom:10px;">
    <tr>
      <td colspan="1" align="center">
      <?php echo TEXT_HEADER_DISCOUNTS_OFF; ?>
      </td>
    </tr>
    <tr>
      <td colspan="1" align="center">
      <?php echo $zc_hidden_discounts_text; ?>
      </td>
    </tr>
  </table>
<?php } else { ?>
  <table style="border-collapse:collapse;cellspacing:0;cellpadding:0;border:1px solid #aaa;font-size:14px;margin-bottom:10px;">
    <tr>
      <td colspan="<?php echo $columnCount+1; ?>" align="center">
<?php
  switch ($products_discount_type) {
    case '1':
      echo TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
      break;
    case '2':
      echo TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
      break;
    case '3':
      echo TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
      break;
  }
 ?>
      </td>
    </tr>

<?php
	$ldc_special_discount = $show_price / $display_price;
	$origin_price = $ldc_product_price;
	if($show_price <> $origin_price){
?>
    <tr>
<?php
  $disc_cnt = 0;
  
  foreach((array)$quantityDiscounts as $key=>$quantityDiscount) {
?>
		<td align="center"><?php echo '<span>' . $quantityDiscount['show_qty'] . '</span><br />' . '<span class="linethrough">' . $currencies->display_price($quantityDiscount['discounted_price']/$ldc_special_discount, zen_get_tax_rate($products_tax_class_id)) .'</span><br />' . '<span class="nprice">' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</span>'; ?></td>
<?php
  }
}else{
?>
    <tr>
<?php
  $disc_cnt = 0;
  foreach($quantityDiscounts as $key=>$quantityDiscount) {
?>
		<td align="center"><?php echo $quantityDiscount['show_qty'] . '<br />' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)).''; ?></td>
<?php
  }
}
?>


<?php
  if ($disc_cnt < $columnCount) {
?>
    <td align="center" colspan="<?php echo ($columnCount+1 - $disc_cnt)+1; ?>"> &nbsp; </td>
<?php } ?>
    </tr>
  </table>
<?php } // hide discounts ?>