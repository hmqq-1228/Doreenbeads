<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_quantity_discounts.php 3291 2006-03-28 04:03:38Z ajeh $
 */

?>
<div id="productQuantityDiscounts" >
    <?php
    echo $products_id_current;
    if ($zc_hidden_discounts_on) {
        ?>

        <table border="1" cellspacing="2" cellpadding="2">
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
        <table border="1" cellspacing="2" cellpadding="2">
            <tr>
                <td colspan="<?php echo $columnCount + 1; ?>" align="center">
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
            // 2010-11-22 On  ��Ӳ�Ʒԭ�۸�
            if ($show_price != $origin_price){
            $product_id = $_GET['products_id'];
            global $currencies;
            //$currencies = new currencies();
            $products_query = new stdClass();
            $products_query->fields = get_products_info_memcache((int)$product_id);
            //$products_query = $db->Execute("select products_discount_type, products_discount_type_from, products_price from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");
            $display_normal_price = zen_get_products_base_price($product_id);
            $display_sale_price = zen_get_products_special_price($product_id, false);
            @$ldc_special_discount = $display_sale_price / $display_normal_price;
            $origin_price = $products_query->fields["products_price"];
            ?>
        <tr>
        <td align="center"><?php echo $show_qty . '<br />' . '<span class="normalprice">' . $currencies->display_price($origin_price, zen_get_tax_rate
                ($products_tax_class_id)) . '</span><br />' . '<span class="productSpecialPrice">' . $currencies->display_price($show_price, zen_get_tax_rate($products_tax_class_id)) .
                '</span>'; ?></td>

        <?php
        foreach ($quantityDiscounts

                 as $key => $quantityDiscount) {
        ?>
        <td align="center"><?php echo $quantityDiscount['show_qty'] . '<br />' . '<span class="normalprice">' . $currencies->display_price($quantityDiscount['discounted_price'] / $ldc_special_discount,
                    zen_get_tax_rate($products_tax_class_id)) . '</span><br />' . '<span class="productSpecialPrice">' . $currencies->display_price($quantityDiscount['discounted_price'],
                    zen_get_tax_rate($products_tax_class_id)) . '</span>'; ?></td>
        <?php
        $disc_cnt++;
        if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
        $disc_cnt = 0;
        ?>
        </tr><tr>
        <?php
        }
        }
        }else{
        ?>
        <tr>
        <td align="center"><?php echo $show_qty . '<br />' . $currencies->display_price($show_price, zen_get_tax_rate($products_tax_class_id)); ?></td>

        <?php var_dump($quantityDiscounts);exit;
        foreach ($quantityDiscounts as $key => $quantityDiscount) {
        ?>
        <td align="center"><?php echo $quantityDiscount['show_qty'] . '<br />' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)); ?></td>
        <?php
        $disc_cnt++;
        if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
        $disc_cnt = 0;
        ?>
        </tr>
            <tr>
                <?php
                }
                }
                }
                // eof 2010-11-22 On
                ?>
                <?php
                if ($disc_cnt < $columnCount) {
                    ?>
                    <td align="center" colspan="<?php echo ($columnCount + 1 - $disc_cnt) + 1; ?>"> &nbsp;</td>
                <?php } ?>
            </tr>
            <?php
            if (zen_has_product_attributes($products_id_current)) {
                ?>
                <tr>
                    <td colspan="<?php echo $columnCount + 1; ?>" align="center">
                        <?php echo TEXT_FOOTER_DISCOUNT_QUANTITIES; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } // hide discounts ?>
</div>