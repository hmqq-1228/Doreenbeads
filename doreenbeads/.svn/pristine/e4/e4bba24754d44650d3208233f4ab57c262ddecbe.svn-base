<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_default.php 4086 2006-08-07 02:06:18Z ajeh $
 */
?>

<div class="centerColumn" id="accountDefault">
<div style="padding:8px;border:1px solid #9AACBA; color:blue;line-height:135%;"><?php echo TEXT_INVITED_WRITE_REVIEWS; ?></div>
<h1 id="accountDefaultHeading"><?php echo HEADING_TITLE; ?></h1>
<?php if ($messageStack->size('account') > 0) echo $messageStack->output('account'); ?>

<?php
    if (zen_count_customer_orders() > 0) {
  ?>
<p class="forward"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . OVERVIEW_SHOW_ALL_ORDERS . '</a>'; ?></p>
<br class="clearBoth" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="prevOrders">
<caption><h2><?php echo OVERVIEW_PREVIOUS_ORDERS; ?></h2></caption>
    <tr class="tableHeading">
    <th scope="col"><?php echo TABLE_HEADING_DATE; ?></th>
    <th scope="col"><?php echo TABLE_HEADING_ORDER_NUMBER; ?></th>
    <th scope="col"><?php echo TABLE_HEADING_SHIPPED_TO; ?></th>
    <th scope="col"><?php echo TABLE_HEADING_STATUS; ?></th>
    <th scope="col"><?php echo TABLE_HEADING_TOTAL; ?></th>
    <th scope="col"><?php echo TABLE_HEADING_VIEW; ?></th>
  </tr>
<?php
  foreach($ordersArray as $orders) {
?>
  <tr>
    <td width="70px"><?php echo zen_date_short($orders['date_purchased']); ?></td>
    <td width="30px"><?php echo TEXT_NUMBER_SYMBOL . $orders['orders_id']; ?></td>
    <td><address><?php echo zen_output_string_protected($orders['order_name']) . '<br />' . $orders['order_country']; ?></address></td>
    <td width="70px"><?php echo $orders['orders_status_name']; ?></td>
    <td width="70px" align="right"><?php echo $orders['order_total']; ?></td>
    <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '"> ' . zen_image_button(BUTTON_IMAGE_VIEW_SMALL, BUTTON_VIEW_SMALL_ALT) . '</a>'; ?></td>
  </tr>
  <tr>
  	<td colspan="6" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '"> ' . 'Quick Re-order this Order Products >>' . '</a>'; ?></td>
  </tr>
<?php
  }
?>
</table>
<?php
  }
?>
<!--vip_robbie-->
<hr class="clearBoth" />
<br />
<div align="left"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_ADD_MORE_ITEMS) . '">' . '<img src="includes/templates/template_default/buttons/english/button_products_no.jpg">'  . '</a>'; ?></div>
<?php if($credit_account_total!=0){ ?>

<br /><br /><?php echo sprintf(TEXT_CREDIT_ACCOUNT,$credit_account_code,$credit_account_total);?>
<?php }?>
<br /><br /><?php  echo sprintf(TEXT_CREDIT_ACCOUNT1,$customers_orders_total);?>
<?php if ($customers_group->RecordCount() > 0) { 
  	echo "<br/>".sprintf(TEXT_CREDIT_ACCOUNT2,$customers_group->fields['group_name'],$customers_group->fields['group_percentage'],((1 - ((1 - ((float)substr($customers_group->fields['group_percentage'], 0, -1) / 100)) * 0.97)) * 100));
	if($next_level>0){
		echo "<br/>".sprintf(TEXT_GROUP_ACCOUNT1, $next_level_min, $next_level_name, $next_level_discount);
	}
}else{
	echo "<br/>".sprintf(TEXT_GROUP_ACCOUNT2,$next_level_min-$customers_orders_total);
}
?>
<br class="clearBoth" />
<div id="accountLinksWrapper" class="back">
<h2><?php echo MY_ACCOUNT_TITLE; ?></h2>
<ul id="myAccountGen" class="list">
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . MY_ACCOUNT_INFORMATION . '</a>'; ?></li>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></li>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">' . MY_ACCOUNT_PASSWORD . '</a>'; ?></li>
<!--jessa 2010-09-01 添加wishlist链接-->
<li><?php echo ' <a href="' . zen_href_link('wishlist', '', 'SSL') . '">' . 'View My Wishlist Products</a>'; ?></li>
<!--jessa 2010-09-01 wishlist添加完成-->
<li><?php echo ' <a href="' . zen_href_link('cash_account', '', 'SSL') . '">View My Credit Account</a>'; ?></li>
</ul>


<?php
  if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK !='false' or CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS !='0') {
?>
<h2><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></h2>
<ul id="myAccountNotify" class="list">
<?php
  if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK=='true') {
?>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></li>
<?php } //endif newsletter unsubscribe ?>
<?php
  if (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1') {
?>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></li>

<?php } //endif product notification ?>
</ul>

<?php } // endif don't show unsubscribe or notification ?>
</div>

<?php
// only show when there is a GV balance
  if ($customer_has_gv_balance ) {
?>
<div id="sendSpendWrapper">
<?php require($template->get_template_dir('tpl_modules_send_or_spend.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_send_or_spend.php'); ?>
</div>
<?php
  }
?>
<br class="clearBoth" />
</div>
