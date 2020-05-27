<?php
/**
 * 
 * Page Template
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shopping_cart_default.php 5554 2s007-01-07 02:45:29Z drbyte $
 */
?>
<div class="centerColumn" id="shoppingCartDefault">

<?php if ($show_delete_products == true){ //即有删除选项时,下面为http://localhost/index.php?main_page=shopping_cart&action=delete时页面 ?>
<div id="allProductsDefault">
<h1 id="allProductsDefaultHeading"><?php echo HEADER_TITLE_DELETE_PRO; ?></h1>
<?php echo zen_draw_form('delete_confirm', zen_href_link(FILENAME_SHOPPING_CART, 'action=deleteconfirm')); ?>
<div style="">
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td colspan="4" style="padding:10px; background:#FAF5F9; color:#990000;"><?php echo TEXT_DELETE_CONFIRM_DESCRIPTION; ?></td>
    </tr>
  <?php for ($del_cnt = 0; $del_cnt < sizeof($prod_info_array); $del_cnt++){   
  		//echo $buy_num[$prod_info_array[$del_cnt]['id']];
  ?>
    <tr>
      <td style="padding:5px; width:10%;vertical-align:top;"><?php echo zen_draw_checkbox_field('delete[]', $prod_info_array[$del_cnt]['id'], true); ?></td>
      <td style="padding:5px; width:12%;vertical-align:top;"><?php echo '<b>' . $buy_num[$prod_info_array[$del_cnt]['id']] . '&nbsp;ea.&nbsp</b>' . '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prod_info_array[$del_cnt]['id']) . '" target="_blank">' . $prod_info_array[$del_cnt]['model'] . '</a>'; ?></td>
      <td style="padding:5px; width:13%;vertical-align:top;"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prod_info_array[$del_cnt]['id']) . '" target="_blank">' . zen_image(DIR_WS_IMAGES . $prod_info_array[$del_cnt]['image'], '', IMAGE_SHOPPING_CART_WIDTH, IMAGE_SHOPPING_CART_HEIGHT) . '</a>'; ?></td>
      <td style="padding:5px; width:65%;vertical-align:top;"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prod_info_array[$del_cnt]['id']) . '" target="_blank">' . $prod_info_array[$del_cnt]['name'] . '</a>'; ?></td>
    </tr>
  <?php } ?>
    <tr>
      <td colspan="4" style="padding:5px;vertical-align:bottom;"><?php echo '<div style="height:20px;padding:5px;float:left;">' . zen_image_submit(ICON_IMAGE_CONFIRM, ICON_CONFIRM_ALT) . '</div><div style="height:20px;padding:5px;padding-top:9px;float:left;"><a href="' . zen_href_link(FILENAME_SHOPPING_CART) . '">' . zen_image_button('buttion_cancel_cart.gif') . '</a></div>'; ?></td>
    </tr>
  </table>
</div>
</form>
</div>

<?php } else { //不是删除的情况 ?>
<?php
//购物车中有商品时的页面布局， 开始
  if ($flagHasCartContents) { //有商品内容时
?>

<?php
  if ($_SESSION['cart']->count_contents() > 0) {
?>
<div class="forward"><?php echo TEXT_VISITORS_CART; ?></div>
<?php
  }
?>

<h1 id="cartDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('shopping_cart') > 0) echo $messageStack->output('shopping_cart'); ?>

<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product' . ((isset($_GET['page']) && $_GET['page'] != '') ? '&page=' . $_GET['page'] : ''))); ?>
<?php echo TEXT_INFORMATION; ?>

<?php if (!empty($totalsDisplay)) { ?>
<div class="cartTotalsDisplay important">
<?php echo $totalsDisplay; //显示例如:Total Items: 10  Weight: 660 grams  Amount: US$20.50?>


<!--前面一个按钮-->
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_CONTINUE_SHOPPING, BUTTON_CONTINUE_SHOPPING_ALT) . '</a>'; 
?></div>
<!--eof jessa 2009-10-26-->


<!--后面一个按钮-->

<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a>'; ?></div>
<?php }// EOF MIN ORDER AMOUNT ?>
<!--eof jessa 2009-10-26-->

</div>
<br class="clearBoth" />

<!--jessa 2009-10-30 检查库存数量和顾客购买数量之间的关系-->
<?php  if ($flagAnyOutOfStock) { ?>

<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>

<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>

<?php    } else { ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>

<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?>

<table  border="0" width="100%" cellspacing="0" cellpadding="0" id="cartContentsDisplay">
<?php 
/**
 * haoran ; 下面的为 当有购物车中有商品时的页面布局
 */
?>
 <tr>
 	<td colspan="7">
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:90px; text-align:left;"><?php echo '<a href="javascript:" onclick="return selectall();">' . zen_image_button('button_select_all.jpg') . '</a>'; ?></td>
		  <td style="width:105px; font-weight:bold; text-align:left;"><?php echo '<a href="javascript:" onclick="return unselectall();">' . zen_image_button('button_unselect_all.jpg') . '</a>'; ?></td>
		  <td style="width:60px; text-align:center;"><?php echo zen_image_submit(ICON_IMAGE_DELETE, ICON_DELETE_ALT, 'onclick="return init_delete();"')?></td>
		  <td style="width:60px; text-align:center;"><?php echo zen_image_submit(ICON_IMAGE_UPDATE, ICON_UPDATE_ALT, 'onclick="return init_update();"'); ?></td>
		  <td style="text-align:right;">&nbsp;</td>
		</tr>
	  </table>
	</td>
 </tr>

 <tr>
 	<td colspan="7">
	  <?php
	  //分页
	  echo zen_split_show_info($start_num, $end_num, $total_num, $total_page, $_GET['page'], $href_link, 'no'); ?>
	</td>
 </tr>
<?php 
/**
 * ��� jessa 2010-06-22
 * 具体的内容
 */
?>
     <tr class="tableHeading">
	    <th scope="col" id="scSelectAll" width="3%">&nbsp;</th>
	 	<th scope="col" id="scQuantityHeading" width="10%"><?php echo '<a href="'.zen_href_link($_GET['main_page'],'&model_sort='.$model_sort).'">' .TEXT_MODEL.'&nbsp;'.zen_image($sort_pic).'</a>'; ?></th>
        <th scope="col" id="scQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>
<!--        <th scope="col" id="scUpdateQuantity">&nbsp;</th>-->
        <th scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
        <th scope="col" id="scUnitHeading"><?php echo TABLE_HEADING_PRICE; ?></th><!--
        <th scope="col" id="scTotalHeading"><?php //echo TABLE_HEADING_TOTAL; ?></th>
     --></tr>
         <!-- Loop through all products /-->
<?php
  //foreach ($productArray as $product) {
  for ($i = 0; $i < sizeof($productArray); $i++){
?>
     <tr class="<?php echo $productArray[$i]['rowClass']; ?>">
	   <td class="cartQuantity" width="10"><?php echo zen_draw_checkbox_field('delete[]', $productArray[$i]['id']) . zen_draw_hidden_field('buy_num[' . $productArray[$i]['id'] . ']', $productArray[$i]['product_quantity']); ?></td>
	   <td class="cartQuantity">
	   	<?php echo $productArray[$i]['model']; ?>
	   </td>
       <td class="cartQuantity">
<?php
  if ($productArray[$i]['flagShowFixedQuantity']) {
    echo $productArray[$i]['showFixedQuantityAmount'] . '<span class="alert bold">' . $productArray[$i]['flagStockCheck'] . '</span>' . $productArray[$i]['showMinUnits'];
  if ($productArray[$i]['buttonUpdate'] == '') {
    echo '' ;
  } else {
    echo "<br/>".$productArray[$i]['buttonUpdate'];
  }
  } else {
    echo $productArray[$i]['quantityField'] . '<span class="alert bold">' . $productArray[$i]['flagStockCheck'] . '</span>' . $productArray[$i]['showMinUnits'];
  if ($productArray[$i]['buttonUpdate'] == '') {
    echo '' ;
  } else {
    echo "<br/>".$productArray[$i]['buttonUpdate'];
  }
  }
?>
       </td>
       <td class="cartProductDisplay">
<a href="<?php echo $productArray[$i]['linkProductsName']; ?>">
	<?php $imgsrc = HTTP_IMG_SERVER. 'bmz_cache/images/' .  get_img_size($productArray[$i]['productsImage'],"130","130");?>
	
	<div id="cartImage" class=""><?php echo zen_image($imgsrc, $productArray[$i]['productsName'], 100, 100)?></div>
	<div id="cartProdTitle"><?php echo $productArray[$i]['productsName'] . '<span class="alert bold">' . $productArray[$i]['flagStockCheck'] . '</span>'; ?></div>
</a>
<br class="clearBoth" />


<?php
  echo $productArray[$i]['attributeHiddenField'];
  if (isset($productArray[$i]['attributes']) && is_array($productArray[$i]['attributes'])) {
  echo '<div class="cartAttribsList">';
  echo '<ul>';
    reset($productArray[$i]['attributes']);
    foreach ($productArray[$i]['attributes'] as $option => $value) {
?>

<li><?php echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']); ?></li>

<?php
    }
  echo '</ul>';
  echo '</div>';
  }
?>
       </td>
       <td class="cartUnitDisplay"><?php echo TABLE_HEADING_UNIT."<br>"?> <?php echo $productArray[$i]['productsPriceEach']; ?><br/><?php echo TABLE_HEADING_TOTAL."<br>";?> <?php echo $productArray[$i]['productsPrice']; ?></td>
<!--       <td class="cartTotalDisplay"></td>-->
	   
<?php
/*

       <td class="cartRemoveItemDisplay">
<?php
  if ($product['buttonDelete']) {
?>
           <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>"><?php echo zen_image($template->get_template_dir(ICON_IMAGE_TRASH, DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . ICON_IMAGE_TRASH, ICON_TRASH_ALT); ?></a>
<?php
  }
  if ($product['checkBoxDelete'] ) {
    echo zen_draw_checkbox_field('cart_delete[]', $product['id']);
  }
?>
</td>

*/
?>
     </tr>
<?php
  } // end foreach ($productArray as $product)
?>
       <!-- Finished loop through all products /-->
      </table>
      
      <!-- 下面为Sub-Total: 及其值 -->
<div id="cartSubTotal"><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $cartShowTotal; ?></div>
<?php 
//bof promotion discount, zale
echo '<div class="promotionDiscount">';
if ($_SESSION['customer_id'] and $promotion_discount <> 0) {
	echo $promotion_discount_title . ' : -' . $currencies->format($promotion_discount);
}
echo '</div>';
//eof
?>
<?php

	//robbie
	//��ʾVip Group Discount
	if ($_SESSION['customer_id'] and $li_group_percentage <> 0) {
?>
	<div id="cartSubTotal">
		<?php echo TEXT_VIP_GROUNP_DISCOUNT;?> [<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL')?>"> <?php echo $ls_customer_group ?></a>]: -<?php echo $ls_vip_amount; ?> 
	</div>

	<!--下面的这种写法尽管可以输出，但php语言并不推荐这种写法 <div id="cartSubTotal">
		VIP Group Discount [<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . $ls_customer_group . '</a>]: -' . $ls_vip_amount; ?>
	</div> -->
<?php } ?>
<div>
  <?php echo zen_split_show_info($start_num, $end_num, $total_num, $total_page, $_GET['page'], $href_link, 'bottom'); ?>
</div>
<div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:90px; text-align:left;"><?php echo '<a href="javascript:" onclick="return selectall();">' . zen_image_button('button_select_all.jpg') . '</a>'; ?></td>
		  <td style="width:105px; font-weight:bold; text-align:left;"><?php echo '<a href="javascript:" onclick="return unselectall();">' . zen_image_button('button_unselect_all.jpg') . '</a>'; ?></td>
		  <td style="width:60px; text-align:center;"><?php echo zen_image_submit(ICON_IMAGE_DELETE, ICON_DELETE_ALT, 'onclick="return init_delete();"')?></td>
		  <td style="width:60px; text-align:center;"><?php echo zen_image_submit(ICON_IMAGE_UPDATE, ICON_UPDATE_ALT, 'onclick="return init_update();"'); ?></td>
		  <td style="text-align:right;">&nbsp;</td>
		</tr>
	  </table>
</div>
<?php 
/**
 * ��� jessa 2010-06-22
 */
?>
<br class="clearBoth" />

<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a>'; ?></div>



<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_CONTINUE_SHOPPING, BUTTON_CONTINUE_SHOPPING_ALT) . '</a>'; ?></div>
<?php
// show update cart button
//Show on Shopping Cart Update Cart Button Location as:<br /><br />1= Next to each Qty Box<br />2= Below all Products<br />3= Both Next to each Qty Box and Below all Products
  if (SHOW_SHOPPING_CART_UPDATE == 2 or SHOW_SHOPPING_CART_UPDATE == 3) {
?>

<?php
  } else { // don't show update button below cart
?>
<?php
  } // show update button
?>
<!--eof shopping cart buttons-->
</form>

<br class="clearBoth" />
<?php
//SHOW_SHIPPING_ESTIMATOR_BUTTON：<br />0= Off<br />1= Display as Button on Shopping Cart<br />2= Display as Listing on Shopping Cart Page
    if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '1') {
?>

<!--  <div class="buttonRow back"><?php echo '<a href="javascript:popupWindow(\'' . zen_href_link(FILENAME_POPUP_SHIPPING_ESTIMATOR) . '\')">' .
 zen_image_button(BUTTON_IMAGE_SHIPPING_ESTIMATOR, BUTTON_SHIPPING_ESTIMATOR_ALT) . '</a>'; ?></div>-->
<?php
    }
?>

<!--jessa 2010-09-01 ���ӵ�wishlist������-->
<!-- <div class="buttonRow back"><?php echo '<a href="' . zen_href_link('wishlist') . '">' . zen_image_button('button_goto_wishlist.gif', TEXT_IMAGE_WISHLIST_ALT) . '</a>'; ?></div>-->
<!--jessa 2010-09-01 ����wishlist�������-->

<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
	//jessa 2010-05-11 ��ʱɾ�����paypal
  //include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
}
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
      if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2') {
/**
 * load the shipping estimator code if needed
 */
?>
      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>

<?php
      }
?>
<?php
  } else {
?>



<!-- 购物车为空时的页面布局 开始 -->
<h2 id="cartEmptyText"><?php echo TEXT_CART_EMPTY; ?></h2>

<?php
//返回查找到的键值
$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);

//把三个类别放在一个表单中
echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_DEFAULT, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data" id="addform"');


while (!$show_display_shopping_cart_empty->EOF) {
?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') { ?>
<?php
/**
 * display the Featured Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') { ?>
<?php
/**
 * display the Special Products Center Box
 */
?>
<?php 
//Great Discount Offers
require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php 
//新产品
require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
    include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
  }
?>
<?php
  $show_display_shopping_cart_empty->MoveNext();
}
?>
</form>

<?php 
// !EOF
  }
}
?>
</div>