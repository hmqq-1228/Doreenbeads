<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_edit.<br />
 * Displays information related to a single specific order
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_history_info_default.php 6247 2007-04-21 21:34:47Z wilt $
 */
?>
<div class="centerColumn" id="accountHistInfo">
<?php if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){ ?>
<div id="DownloadIntroduction" style="padding-left:10px;padding-top:10px;padding-bottom:10px;color:#000000;border:1px solid #4D74F3;font-size:15px;"><?php echo HEADING_DOWNLOAD_INTRODUCTION;?></div><br/>
<?php }?>
<div class="forward"><?php //echo HEADING_ORDER_DATE . ' ' . zen_date_long($order->info['date_purchased']); ?></div>
<br class="clearBoth" />


<?php 
if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
	echo zen_draw_form('downloads', 'downloads.php?order_id='.$_GET['order_id'], 'POST', 'onsubmit="return checkselect();"');
}
?>


<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Itemized listing of previous order, includes number ordered, items and prices">
<caption><h2 id="orderHistoryDetailedOrder"><?php echo HEADING_TITLE . ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, $_GET['order_id']); ?></h2></caption>
<?php 
	//jessa 2010-05-10 �����״̬ʱ Shipped ���� Processing ʱ������ÿͻ����ض�����ƷͼƬ�����ӣ��������.
	if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
    <tr class="">
      <td colspan="7" id="" align="right" style="padding:3px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50%" height="25" align="left"><?php echo '<strong><a href="' . zen_href_link(FILENAME_EZPAGES, 'id=69') . '" target="_blank" class="pinglink">Picture Authorization>></a></strong>'; ?><br><strong><a class="pinglink" href="<?php echo HTTP_SERVER;?>/invoice.php?oID=<?php echo $_GET['order_id'];?>" target="_blank"><?php echo TEXT_VIEW_INVOICE;?></a></strong></td>
          <td width="25%" height="25" align="right"><?php 
	  		echo '<a href="downloads.php?order_id=' . $_GET['order_id'] . '" target="_blank">' . zen_image_button('button_download_all_pic.gif', 'button_download_all_pic') . '</a>'; 
	  ?></td>
	  	<td height="25" align="right"><?php 
	  		echo zen_image_submit('button_download_select_pic.gif', 'button_download_select_pic'); 
	  ?></td>
        </tr>
      </table>      </td>
    </tr>
<?php } //eof jessa 2010-05-10?>
    <tr class="tableHeading">
    	<th scope="col"><?php echo '<a href="javascript:" onclick="return select();">' . zen_draw_checkbox_field('select') . zen_draw_hidden_field('buy_num') . '</a>';?></th>
		<th scope="col" id="myAccountModel" width="10%"><?php echo HEADING_MODEL; ?></th>
        <th scope="col" id="myAccountQuantity" width="10%"><?php echo HEADING_QUANTITY; ?></th>
		<th scope="col" id="myAccountQuantity" width="10%"><?php echo HEADING_IMAGE; ?></th>
        <th scope="col" id="myAccountProducts" width="55%"><?php echo HEADING_PRODUCTS; ?></th>
<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>
        <th scope="col" id="myAccountTax"><?php echo HEADING_TAX; ?></th>
<?php
 }
?>
        <th scope="col" id="myAccountTotal" width="15%"><?php echo HEADING_TOTAL; ?></th>
		<?php
	//jessa 2010-05-10 �����״̬ʱ Shipped ���� Processing ʱ������ÿͻ����ض�����ƷͼƬ�����ӣ��������.
	if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
		<th scope="col" id="downloadpic" align="center" width="10%"><?php echo DOWNLOAD_PIC; ?></th>
<?php } //eof jessa 2010-05-10 ?>
    </tr>
<?php if ($products_split->number_of_pages > 1) { ?>    
<tr>
	<td colspan="7">
    	<div id="top_split_show">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    		<tr>
    			<td class="navSplitPagesResult_top"><?php echo $products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL); ?></td>
				<td class="navSplitPagesLinks_top"><?php echo TEXT_RESULT_PAGE . ' ' . $products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></td>
			</tr>
		</table>
		</div>
    </td>
</tr>
<?php } ?>
<?php

  $index = 0;
  while (!$products->EOF){
  	  	
  	   $subindex = 0;
      $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
                              options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                               where orders_id = '" . (int)$order_id . "'
                               and orders_products_id = '" . (int)$products->fields['orders_products_id'] . "'";

      $attributes = $db->Execute($attributes_query);
      if ($attributes->RecordCount()) {
        while (!$attributes->EOF) {
          $products->fields['attributes'][$index][$subindex] = array('option' => $attributes->fields['products_options'],
                                                                   'value' => $attributes->fields['products_options_values'],
                                                                   'prefix' => $attributes->fields['price_prefix'],
                                                                   'price' => $attributes->fields['options_values_price']);
          $subindex++;          
          $attributes->MoveNext();
        }
      }
      
      $product_status_query = $db->Execute('select products_status from ' . TABLE_PRODUCTS . ' where products_id = ' . $products->fields['products_id']);
      $product_status = $product_status_query->fields['products_status'];
  ?>
    <tr>
    	<td style="vertical-align:top;width:10px;"><?php echo zen_draw_checkbox_field('selectson[]', $products->fields['products_id']); ?></td>
		<td class="accountQuantityDisplay"><?php echo ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products->fields['products_id']) . '">' . $products->fields['products_model'] . '</a>' : $products->fields['products_model']); ?></td>
        <td class="accountQuantityDisplay"><?php echo  $products->fields['products_quantity'] . QUANTITY_SUFFIX; ?></td>
		<td class="accountQuantityDisplay" style="padding:5px;">
		<?php
			$image = $db->Execute("select products_image from " . TABLE_PRODUCTS . " where products_id = " . (int)$products->fields['products_id']);
			echo ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products->fields['products_id']) . '"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($image->fields['products_image'], 80, 80) . '" width="40" height="40"></a>' : '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($image->fields['products_image'], 80, 80) . '" width="40" height="40">');
		?>
		</td>
        <td class="accountProductDisplay"><?php echo ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products->fields['products_id']) . '">' . $products->fields['products_name'] . '</a>' : $products->fields['products_name']);
        
    if ( (isset($products->fields['attributes'][$index])) && (sizeof($products->fields['attributes'][$index]) > 0) ) {
      echo '<ul id="orderAttribsList">';
      for ($j=0, $n2=sizeof($products->fields['attributes'][$index]); $j<$n2; $j++) {
        echo '<li>' . $products->fields['attributes'][$index][$j]['option'] . TEXT_OPTION_DIVIDER . nl2br(zen_output_string_protected($products->fields['attributes'][$index][$j]['value'])) . '</li>';
      }
        echo '</ul>';
    }
    
?>
        </td>
<?php
    if (sizeof($order->info['tax_groups']) > 1) {
?>
        <td class="accountTaxDisplay"><?php echo zen_display_tax_value($products->fields['products_tax']) . '%' ?></td>
<?php
    }
?>		
        <td class="" style="padding-right:5px; text-align:right"><?php echo $currencies->format(zen_add_tax($products->fields['final_price'], $products->fields['products_tax']) * $products->fields['products_quantity'], true, $order->info['currency'], $order->info['currency_value']) . ($products->fields['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($products->fields['onetime_charges'], $products->fields['products_tax']), true, $order->info['currency'], $order->info['currency_value']) : '') ?></td>
		<?php 
	// 2010-05-10 �����״̬ʱ Shipped ���� Processing ʱ������ÿͻ����ض�����ƷͼƬ�����ӣ��������.
	if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
		<td class="" align="center"><?php echo '<a href="downloads.php?product_id=' . $products->fields['products_id'] . '" target="_blank" onmouseover="show_description(\'download_pic_description' . $index . '\', \'Download non-watermarked pictures. For mixes listing, separate pictures of each item (different color/style) will also be also downloaded.\', 350)" onmouseout="close_description(\'download_pic_description' . $index . '\')">' . zen_image_button('button_download_pic.gif', '') . '</a><br /><div id="download_pic_description' . $index . '" style="text-align:left;width:480px;color:#6f6d94;font-weight:bold; display:none; background:#e6e6f3; border:1px solid #6B6B63;"></div>'.
		'<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products->fields['products_id']) . '#reviewsWritemodule' . '" target="_blank">' . zen_image_button('reviews.jpg', '') . '</a>';?></td>
<?php } //eof��2010-10-31 ?>

    </tr>
<?php
	$index++;
	$products->MoveNext();
  }
?>
</table>

<?php 
if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
	echo '</form>';
}
?>



<hr />
<div id="orderTotals">
<table cellpadding=0 cellspacing=0 border=0 width='100%'>
<tr>
<td valign='top'>
<?php 
if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
<strong><a class="pinglink" href="<?php echo HTTP_SERVER;?>/invoice.php?oID=<?php echo $_GET['order_id'];?>" target="_blank"><?php echo TEXT_VIEW_INVOICE;?></a></strong>
<?php
}
?>
</td>
<td>
<?php
  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
?>
     <div class="amount larger forward"><?php echo $order->totals[$i]['text'] ?></div>
     <div class="lineTitle larger forward"><?php echo $order->totals[$i]['title'] ?></div>
<br class="clearBoth" />
<?php
  }
?>
</td>
</tr>
</table>
</div>
<div class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO) .'">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_ADD_ADDRESS_ALT) . '</a>'; ?></div>
<div align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_QUICK_REORDER, 'order_id=' . $_GET['order_id'], 'SSL') . '"> ' . zen_image_button(BUTTON_QUICK_REORDER, BUTTON_QUICK_REORDER) . '</a>'; ?></div>
<?php
/**
 * Used to display any downloads associated with the cutomers account
 */
  if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_downloads.php');
?>


<?php
/**
 * Used to loop thru and display order status information
 */
if (sizeof($statusArray)) {
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" id="myAccountOrdersStatus" summary="Table contains the date, order status and any comments regarding the order">
<caption><h2 id="orderHistoryStatus"><?php echo HEADING_ORDER_HISTORY; ?></h2></caption>
    <tr class="tableHeading">
        <th scope="col" id="myAccountStatusDate"><?php echo TABLE_HEADING_STATUS_DATE; ?></th>
        <th scope="col" id="myAccountStatus"><?php echo TABLE_HEADING_STATUS_ORDER_STATUS; ?></th>
        <th scope="col" id="myAccountStatusComments"><?php echo TABLE_HEADING_STATUS_COMMENTS; ?></th>
       </tr>
<?php
  foreach ($statusArray as $statuses) {
?>
    <tr>
        <td><?php echo zen_date_short($statuses['date_added']); ?></td>
        <td><?php echo $statuses['orders_status_name']; ?></td>
        <td><?php echo (empty($statuses['comments']) ? '&nbsp;' : nl2br(zen_output_string_protected($statuses['comments']))); ?></td> 
     </tr>
<?php
  }
?>
</table>
<?php } ?>

<hr />
<div id="myAccountShipInfo" class="floatingBox back">
<?php
  if ($order->delivery != false) {
?>
<h3><?php echo HEADING_DELIVERY_ADDRESS; ?></h3>
<address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
<?php
  }
?>

<?php
    if (zen_not_null($order->info['shipping_method'])) {
?>
<h4><?php echo HEADING_SHIPPING_METHOD; ?></h4>
<div><?php echo $order->info['shipping_method']; ?></div>
<?php } else { // temporary just remove these 4 lines ?>
<div>WARNING: Missing Shipping Information</div>
<?php
    }
?>

</div>

<div id="myAccountPaymentInfo" class="floatingBox forward">
<?php
//jessa 2010-02-05 ɾ��billing address��Ϣ
/*
?>
<h3><?php echo HEADING_BILLING_ADDRESS; ?></h3>
<address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>
<?php
*/
//eof jessa 2010-02-05
?>



<h4><?php echo HEADING_PAYMENT_METHOD; ?></h4>
<div><?php echo $order->info['payment_method']; ?></div>
</div>
<br class="clearBoth" />
</div>