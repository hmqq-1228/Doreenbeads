<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_new.<br />
 * Displays listing of New Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_new_listing.php 4629 2006-09-28 15:29:18Z ajeh $
 */
?>
<?php
  //$group_id = zen_get_configuration_key_value('PRODUCT_NEW_LIST_GROUP_ID');
  if ($products_new_split->number_of_rows > 0) {
    $products_new = $db->Execute($products_new_split->sql_query);
    while (!$products_new->EOF) {
    $product = array();
    $product['id'] = $products_new->fields['products_id'];
    $product['name'] = $products_new->fields['products_name'];
    $product['description'] = $products_new->fields['products_description'];
    $product['image'] = $products_new->fields['products_image'];
    $product['price'] = az_change_format( zen_get_products_display_price($products_new->fields['products_id']) );
    $btn = '<a href="'. zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $product['id']) .'">'. az_tep_image('',BUTTON_BUY_NOW) .'</a>';
    ?>
    <div class="az-product-wrapper">
    <div class="az_pbox_new ">
	<div class="az_pbox_top_new">
		<div class="az_pbox_top_l_new">
			<div class="az_pbox_top_r_new">
				<div class="az_pbox_top_m_new"></div>
			</div>
		</div>
	</div>
	<div class="az_pbox_cont_new">
		<div class="az_pbox_cont_l_new">
			<div class="az_pbox_cont_r_new">
				<div class="az_pbox_cont_m_new">
					<div class="boxContents">					
						
						<div class="image">
							<?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['id']) . '">' . zen_image(DIR_WS_IMAGES . $product['image'], $product['name'], 140, 160) . '</a>';?>
						</div>
						<div class="rightPane">
							<div class="name"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['id']) ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a></div>
							<div class="price"><?php echo $product['price'] ?></div>
						</div>						
						<div class="clear"></div>

						<div class="image">
							<div class="more"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['id']) ?>"><?php echo BUTTON_MORE_INFO; ?></a></div>
						</div>
						<div class="rightPane">
							<div class="buy">
                            <?php
                            echo zen_get_buy_now_button($product['id'], $btn );
                            ?>
                            </div>
						</div>
						<div class="clear"></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="az_pbox_bottom_new">
		<div class="az_pbox_bottom_l_new">
			<div class="az_pbox_bottom_r_new">
				<div class="az_pbox_bottom_m_new"></div>
			</div>
		</div>
	</div>
</div>
</div>
    <?php 
    	$products_new->MoveNext();
    }
  } else {
?>
         
            <div><?php echo TEXT_NO_NEW_PRODUCTS; ?></div>
          
<?php
  }
?>
