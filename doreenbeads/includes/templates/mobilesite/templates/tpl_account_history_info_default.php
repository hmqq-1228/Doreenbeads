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

 * @version $Id: tpl_account_history_info_default.php 6524 2007-06-25 21:27:46Z drbyte $

 */

?>

<div class="centerColumn" id="accountHistInfo">
<?php if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered' ){ ?>
<div id="DownloadIntroduction" style="padding-left:10px;padding-top:10px;padding-bottom:10px;color:#fff;border:1px solid #4D74F3;font-size:15px;"><?php echo HEADING_DOWNLOAD_INTRODUCTION;?></div><br/>
<?php }?>
<div class="forward"><?php echo HEADING_ORDER_DATE . ' ' . zen_date_long($order->info['date_purchased']); ?></div>

<br class="clearBoth" />


<?php 
if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
	echo zen_draw_form('downloads', 'downloads.php?order_id='.$_GET['order_id'], 'POST', 'onsubmit="return checkselect();"');
}
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Itemized listing of previous order, includes number ordered, items and prices">

<caption><h2 id="orderHistoryDetailedOrder"><?php echo HEADING_TITLE . ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, $_GET['order_id']); ?></h2></caption>
<?php 
	//on 2010-10-31 �����״̬Ϊ Shipped ���� Processing ����Update ʱ������ÿͻ����ض�����ƷͼƬ�����ӣ��������.
	if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
    <tr class="">
      <td colspan="7" id="" align="right" style="padding:3px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>          
          <td width="50%" height="25"><?php echo '<strong>See Our <a href="' . zen_href_link(FILENAME_EZPAGES, 'id=97&chapter=0') . '" target="_blank">Picture Authorization>></a></strong>'; ?></td>
          <td height="25" align="right"><?php 
	  		echo '<a href="downloads.php?order_id=' . $_GET['order_id'] . '" target="_blank">' . zen_image_button('button_download_all_pic.gif', 'button_download_all_pic') . '</a>'; 
	  ?></td>
	     <td height="25" align="right"><?php 
	  		echo zen_image_submit('button_download_select_pic.gif', 'button_download_select_pic'); 
	  ?></td>
        </tr>
      </table>      </td>
    </tr>
<?php } //eof 2010-10-31?><!--
	<tr><td colspan="7"><a href="invoice.php?oID=<?php //echo $_GET['order_id'];?>" target="_blank"><?php //echo TEXT_VIEW_INVOICE;?></a></td></tr>
    --><tr class="tableHeading">
		<th scope="col"><?php echo '<a href="javascript:" onclick="return select();">' . zen_draw_checkbox_field('select') . zen_draw_hidden_field('buy_num') . '</a>';?></th> 
		<th scope="col" id="myAccountModel" width="12%"><?php echo HEADING_MODEL; ?></th>
        <th scope="col" id="myAccountQuantity" width="10%"><?php echo HEADING_QUANTITY; ?></th>
		<th scope="col" id="myAccountQuantity" width="10%"><?php echo HEADING_IMAGE; ?></th>
        <th scope="col" id="myAccountProducts" width="55%"><?php echo HEADING_PRODUCTS; ?></th>

<?php

  if (sizeof($order->info['tax_groups']) > 1) {

?>

        <th scope="col" id="myAccountTax" width="10%"><?php echo HEADING_TAX; ?></th>
		<th scope="col" id="WriteReviews" width="13%"><?php echo 'Write Reviews'; ?></th>
<?php

 }

?>

        <th scope="col" id="myAccountTotal" width="10%"><?php echo HEADING_TOTAL; ?></th>

<?php
	//on 2010-10-31 �����״̬ʱ Shipped ���� Processing ����Update ʱ������ÿͻ����ض�����ƷͼƬ�����ӣ��������.
	if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
		<th scope="col" id="downloadpic" align="center" width="10%"><?php echo DOWNLOAD_PIC; ?></th>
<?php } //eof 2010-10-31 ?>
    </tr>

<?php

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
  	if($i%2==0){
  		$rowClass="rowEven";
  	}else{
  		$rowClass="rowOdd";
  	}
  ?>

    <tr class="<?php echo $rowClass;?>">
		<td style="width:10px;text-align:center;"><?php echo zen_draw_checkbox_field('selectson[]', $order->products[$i]['id']); ?></td> 
		<td class="accountQuantityDisplay"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $order->products[$i]['id']) . '">' . $order->products[$i]['model'] . '</a>'; ?></td>
        <td class="accountQuantityDisplay"><?php  echo  $order->products[$i]['qty'] . QUANTITY_SUFFIX; ?></td>
		<td class="accountQuantityDisplay" style="padding:5px;">
		<?php
			$image = $db->Execute("select products_image from " . TABLE_PRODUCTS . " where products_id = " . $order->products[$i]['id']);
			echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $order->products[$i]['id']) . '">' . zen_image('images/' . $image->fields['products_image'], $order->products[$i]['name'], '50', '40') . '</a>';
		?>
		</td>
        <td class="accountProductDisplay"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $order->products[$i]['id']) . '">' . $order->products[$i]['name'] . '</a>';



    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {

      echo '<ul id="orderAttribsList">';

      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {

        echo '<li>' . $order->products[$i]['attributes'][$j]['option'] . TEXT_OPTION_DIVIDER . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])) . '</li>';

      }

        echo '</ul>';

    }

?>

        </td>

<?php

    if (sizeof($order->info['tax_groups']) > 1) {

?>

        <td class="accountTaxDisplay"><?php  echo zen_display_tax_value($order->products[$i]['tax']) . '%' ?></td>

<?php

    }

?>

        <td align="right"><?php  echo $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') ?></td>
	    <!--jessa 2010-07-30 ����write reviews��ť-->
<?php 
	//2010-10-31 �����״̬ʱ Shipped ���� Processing ���� Updateʱ������ÿͻ����ض�����ƷͼƬ�����ӣ��������.
	if (zen_get_order_status($_GET['order_id']) == 'Shipped' || zen_get_order_status($_GET['order_id']) == 'Processing' || zen_get_order_status($_GET['order_id']) == 'Update' || zen_get_order_status($_GET['order_id']) == 'Delivered'){
?>
		<td class="" align="center"><?php echo '<a href="downloads.php?product_id=' . $order->products[$i]['id'] . '" target="_blank" onmouseover="show_description(\'download_pic_description' . $i . '\', \''.TEXT_DOWNLOAD_PICTURE.'\', 760)" onmouseout="close_description(\'download_pic_description' . $i . '\')">' . zen_image_button('button_download_pic.gif', '') . '</a><br /><div id="download_pic_description' . $i . '" style="text-align:left;width:480px;color:#6f6d94;font-weight:bold; display:none; background:#e6e6f3; border:1px solid #6B6B63;"></div>'.
		'<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $order->products[$i]['id']) . '#reviewsWritemodule' . '" target="_blank">' . zen_image_button('reviews.jpg', '') . '</a>';?></td>
<?php } //eof��2010-10-31 ?>

    </tr>

<?php

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

<?php

  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {

?>

     <div class="amount larger forward"><?php echo $order->totals[$i]['text'] ?></div>

     <div class="lineTitle larger forward"><?php echo $order->totals[$i]['title'] ?></div>

<br class="clearBoth" />

<?php

  }

?>



</div>
<div class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO) .'">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_ADD_ADDRESS_ALT) . '</a>'; ?></div>
<div align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_QUICK_REORDER, 'order_id=' . $_GET['order_id'], 'SSL') . '"> ' . zen_image_button(BUTTON_QUICK_REORDER, BUTTON_QUICK_REORDER_ALT) . '</a>'; ?></div>

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

        <td><?php echo (empty($statuses['comments']) ? '&nbsp;' : nl2br($statuses['comments'])); ?></td> 

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

/*

paypal_offline_robbie_wei

2008-12-19

*/

if ($order->info['payment_module_code'] != 'paypalmanually') {

	//jessa 2010-03-11 ɾ���ҵ��˻����billing address

?>

<h3><?php //echo HEADING_BILLING_ADDRESS; ?></h3>

<address><?php //echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>

<?php } 

//eof robbie_wei?>

<h4><?php echo HEADING_PAYMENT_METHOD; ?></h4>

<div><?php 

/*

paypal_offline_robbie_wei

2008-12-19

*/

if ($order->info['payment_module_code'] == 'paypalmanually') {

	echo '<a href="page.html?chapter=0&id=5#P5" id="paypalmanual" target="_blank"><font color="Green">' 

			. $order->info['payment_method'] . '</font></a>';

}

else {

	echo $order->info['payment_method'];

}

//eof robbie_wei

?></div>

</div>

<br class="clearBoth" />

</div>