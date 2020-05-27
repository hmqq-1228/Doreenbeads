<?php
require ('includes/application_top.php');

define ( 'TEXT_DISPLAY_NUMBER_OF_PRICE_MANAGER', '当前显示 <b>%d</b> - <b>%d</b> (共 <b>%d</b> 条记录)' );

$action = (isset ( $_GET ['action'] ) ? $_GET ['action'] : '');

$cID = zen_db_prepare_input ( $_GET ['cID'] );

$error = false;

$processed = false;

if (zen_not_null ( $action )) {
	
	switch ($action) {
		case 'insert' :
			
			$sql_data_array = array (
					'price_manager_value' => ( float ) zen_db_prepare_input ( $_POST ['price_manager_value'] ),
					
					'price_manager_create_date' => 'now()',
					
					'price_manager_last_modified_date' => 'now()',
					
					'price_manager_operator' => $_SESSION ['admin_id'] 
			)
			;
			zen_db_perform ( TABLE_PRICE_MANAGER, $sql_data_array );
			$messageStack->add_session ( '添加成功', 'success' );
			zen_redirect ( zen_href_link ( 'price_manager', (isset ( $_GET ['page'] ) ? '&page=' . $_GET ['page'] : ''), 'NONSSL' ) );
			zen_redirect ( zen_href_link ( 'price_manager', 'NONSSL' ) );
			
			break;
		case 'update' :
			$sql_data_array = array (
					'price_manager_value' => ( float ) zen_db_prepare_input ( $_POST ['price_manager_value'] ),
					
					'price_manager_last_modified_date' => 'now()',
					
					'price_manager_operator' => $_SESSION ['admin_id'] 
			)
			;
			zen_db_perform ( TABLE_PRICE_MANAGER, $sql_data_array, 'update', "price_manager_id = '" . ( int ) $_POST ['price_manager_id'] . "'" );
			zen_redirect ( zen_href_link ( 'price_manager', 'cID=' . $_GET ['cID'] . (isset ( $_GET ['page'] ) ? '&page=' . $_GET ['page'] : ''), 'NONSSL' ) );
			
			break;
		
		case 'delete' :
			
			if ($db->Execute ( "delete from " . TABLE_PRICE_MANAGER . "  where price_manager_id = '" . ( int ) $_POST ['price_manager_id'] . "'" )) {
				$messageStack->add_session ( '删除成功', 'success' );
				zen_redirect ( zen_href_link ( 'price_manager', (isset ( $_GET ['page'] ) ? '&page=' . $_GET ['page'] : ''), 'NONSSL' ) );
			}
			
			break;
		
		default :
			if (isset ( $cID ) && $cID > 0) {
				$price_manager = $db->Execute ( "SELECT * FROM  " . TABLE_PRICE_MANAGER . " where price_manager_id = " . $cID . " order by price_manager_id desc " );
				
				$cInfo = new objectInfo ( $price_manager->fields );
			}
	}
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>

<?php

if ($action == 'edit' || $action == 'update' || $action == 'new') {
	
?>

<script language="javascript"><!--

function check_form() {
  var price_manager_value = document.channel.price_manager_value.value;
  if(price_manager_value == ''){
	alert('上浮比例不能为空');
	return false;
  }
  return true;

}

//--></script>

<?php
}

?>

<script type="text/javascript">

  <!--

  function init()

  {

    cssjsmenu('navbar');

    if (document.getElementById)

    {

      var kill = document.getElementById('hoverJS');

      kill.disabled = true;

    }

  }
 

  // -->

</script>
</head>
<body onLoad="init()">

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

	<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr>
			<td width="100%" valign="top">
				<table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><?php echo zen_draw_form('search', FILENAME_CUSTOMERS, '', 'get', '', true); ?>
									<td class="pageHeading"><?php echo '调价上浮比例管理'; ?></td>
									<td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
									<td class="smallText" align="right"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>

<?php

// Sort Listing

switch ($_GET ['list_order']) {
	
	default :
		
		$disp_order = "cn.channel_id DESC";
}

?>
<td valign="top">
	<table border="0" cellspacing="0" cellpadding="2" width="100%">
		<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method='post' id="customerForm" onsubmit="return changeAction()">
			<tr class="dataTableHeadingRow">
				<td class="specialCustomerTable">
					<ul>
						<li class="dataTableHeadingContent customer_id" style="width: 20%;" align="left" valign="top">上浮比例</li>
						<li class="dataTableHeadingContent customer_id" style="width: 20%;" align="center" valign="top">添加时间</li>
						<li class="dataTableHeadingContent customer_id" style="width: 30%;" align="center" valign="top">修改时间</li>
						<li class="dataTableHeadingContent customer_info" style="width: 30%; text-align: right;">操作</li>
					</ul>
				</td>
			</tr>

<?php

$price_manager_query_raw = "SELECT * FROM  " . TABLE_PRICE_MANAGER . " order by price_manager_id desc";

if (($_GET ['page'] == '' or $_GET ['page'] == '1') and $_GET ['cID'] != '') {
	
	$check_page = $db->Execute ( $price_manager_query_raw );
	
	$check_count = 1;
	
	if ($check_page->RecordCount () > MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER) {
		
		while ( ! $check_page->EOF ) {
			
			if ($check_page->fields ['price_manager_id'] == $_GET ['cID']) {
				
				break;
			}
			
			$check_count ++;
			
			$check_page->MoveNext ();
		}
		
		$_GET ['page'] = round ( (($check_count / MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER) + (fmod_round ( $check_count, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER ) != 0 ? .5 : 0)), 0 );
	} else {
		
		$_GET ['page'] = 1;
	}
}

$price_manager_split = new splitPageResults ( $_GET ['page'], MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $price_manager_query_raw, $customers_query_numrows );

$price_manager = $db->Execute ( $price_manager_query_raw );

while ( ! $price_manager->EOF ) {
	if ((! isset ( $_GET ['cID'] ) || (isset ( $_GET ['cID'] ) && ($_GET ['cID'] == $price_manager->fields ['price_manager_id']))) && ! isset ( $cInfo )) {
		
		$cInfo = new objectInfo ( $price_manager->fields );
	}
	if (isset ( $cInfo ) && is_object ( $cInfo ) && ($price_manager->fields ['price_manager_id'] == $cInfo->price_manager_id)) {
		
		echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
	} else {
		
		echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";
	}
	
	?>

	<td class="specialCustomerTable">
		<ul>
			<li class="dataTableContent customer_id" style="width: 20%;" align="left" valign="top">
			<?php echo $price_manager->fields['price_manager_value'].'%'; ?>
			</li>
			<li class="dataTableContent customer_id" style="width: 20%;" align="center" valign="top">
			<?php echo $price_manager->fields['price_manager_create_date']; ?>
			</li>
			<li class="dataTableContent customer_id" style="width: 30%;" align="center" valign="top">
			<?php echo $price_manager->fields['price_manager_last_modified_date']; ?>
			</li>
			<li class="dataTableHeadingContent customer_info" style="width: 30%; text-align: right;"><?php echo '<a href="' . zen_href_link('price_manager', zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $price_manager->fields['price_manager_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', '修改') . '</a>'; ?>
				<?php echo '<a href="' . zen_href_link('price_manager', zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $price_manager->fields['price_manager_id'] . '&action=confirmdelete', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', '删除') . '</a>'; ?>
				<?php if (isset($cInfo) && is_object($cInfo) && ($price_manager->fields['price_manager_id'] == $cInfo->price_manager_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link('price_manager', zen_get_all_get_params(array('cID','action')) . 'cID=' . $price_manager->fields['price_manager_id'] . ($_GET['page'] > 0 ? '&page=' . $_GET['page'] : ''), 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;
			</li>
		</ul>
	</td>
</tr>

<?php
	
	$price_manager->MoveNext ();
}

?>

			<tr>
			<td align='right'>
			<input onclick="location.href='<?php echo zen_href_link('price_manager','action=new');?>'" type="button" style="height: 30px;width: 80px;" value='<?php echo '添加';?>'/>
			</td>
			</tr>
			</form>
			<tr>
				<td colspan="2">
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="smallText" valign="top"><?php echo $price_manager_split->display_count($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRICE_MANAGER); ?></td>
							<td class="smallText" align="right"><?php echo $price_manager_split->display_links($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
						</tr>
					</table>
				</td>
			</tr>
			</table>
			</td>

<?php

$place_order_button = 'includes/languages/english/images/buttons/button_placeorder.gif';

$login_as_customer = 'index.php?main_page=login_as_customer';

if (ENABLE_SSL_CATALOG == 'true') {
	
	$url = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
} elseif (ENABLE_SSL_CATALOG == 'false') {
	
	$url = HTTP_SERVER . DIR_WS_CATALOG;
}

$p_url = $url;

$p_url .= $login_as_customer;

$heading = array ();

$contents = array ();

switch ($action) {
	case 'new' :
		
		$heading [] = array (
				'text' => '<b>添加记录</b>' 
		);
		
		$contents = array (
				'form' => zen_draw_form ( 'channel', 'price_manager', zen_get_all_get_params ( array (
						'action' 
				) ) . 'action=insert', 'post', 'onsubmit="return check_form(channel)"', true ) 
		);
		$contents [] = array (
				'text' => '<br />上浮比例：' 
		);
		
		$contents [] = array (
				'text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="price_manager_value"/>%' 
		);
		
		$contents [] = array (
				'text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\'' . zen_href_link ( 'price_manager' ) . '\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>' 
		);
		
		break;
	case 'edit' :
		if (isset ( $cInfo ) && is_object ( $cInfo )) {
			$heading [] = array (
					'text' => '<b>编辑记录</b>' 
			);
			
			$contents = array (
					'form' => zen_draw_form ( 'channel', 'price_manager', zen_get_all_get_params ( array (
							'action' 
					) ) . 'action=update', 'post', 'onsubmit="return check_form(channel)"', true ) 
			);
			$contents [] = array (
					'text' => '<br />上浮比例：' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="price_manager_value" value="' . $cInfo->price_manager_value . '"/>%' 
			);
			
			$contents [] = array (
					'text' => '<input type="hidden" name="price_manager_id" value="' . $cInfo->price_manager_id . '"/>' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\'' . zen_href_link ( 'price_manager' ) . '\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>' 
			);
		}
		
		break;
	
	case 'update' :
		
		if ($error_message != '') {
			$heading [] = array (
					'text' => '<b>编辑记录</b>' 
			);
			
			$contents = array (
					'form' => zen_draw_form ( 'channel', 'price_manager', zen_get_all_get_params ( array (
							'action' 
					) ) . 'action=update', 'post', 'onsubmit="return check_form(channel)"', true ) 
			);
			$contents [] = array (
					'text' => '<br />上浮比例：' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="customers_email" value="' . $customers_email . '"/>' 
			);
			
			$contents [] = array (
					'text' => '<p style="margin-left: 10px;color:red;">' . $error_message . '</p>' 
			);
			$contents [] = array (
					'text' => '<input type="hidden" name="channel_id" value="' . $_POST ['channel_id'] . '"/>' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\'' . zen_href_link ( 'price_manager' ) . '\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>' 
			);
		} else {
			
			if (isset ( $cInfo ) && is_object ( $cInfo )) {
				$customers_orders = $db->Execute ( "select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where customers_id='" . $cInfo->customers_id . "' order by date_purchased desc" );
				
				$heading [] = array (
						'text' => '<b>编辑记录</b>' 
				);
				
				$contents [] = array (
						'text' => '<br />上浮比例： ' . $cInfo->customers_email_address 
				);
				
				$contents [] = array (
						'text' => '<br />添加时间: ' . $cInfo->create_time 
				);
				
				if ($customers_orders->RecordCount () != 0) {
					
					$contents [] = array (
							'text' => '<br />最后下单时间： ' . $customers_orders->fields ['date_purchased'] 
					);
				}
				
				$admin = $db->Execute ( "select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->channel_operator . "' order by admin_id desc" );
				if ($admin->RecordCount () != 0) {
					$contents [] = array (
							'text' => '<br />操作人： ' . $admin->fields ['admin_email'] 
					);
				}
			} else {
				$heading [] = array (
						'text' => '<b>编辑信息</b>' 
				);
				$contents [] = array (
						'text' => '<br />暂无记录' 
				);
			}
		}
		break;
	
	case 'insert' :
		
		if ($error_message != '') {
			$heading [] = array (
					'text' => '<b>新建信息</b>' 
			);
			
			$contents = array (
					'form' => zen_draw_form ( 'channel', 'price_manager', zen_get_all_get_params ( array (
							'action' 
					) ) . 'action=insert', 'post', 'onsubmit="return check_form(channel)"', true ) 
			);
			$contents [] = array (
					'text' => '<br />上浮比例：' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="customers_email" value="' . $customers_email . '"/>' 
			);
			
			$contents [] = array (
					'text' => '<p style="margin-left: 10px;color:red;">' . $error_message . '</p>' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\'' . zen_href_link ( 'price_manager' ) . '\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>' 
			);
		} else {
			
			if (isset ( $cInfo ) && is_object ( $cInfo )) {
				$customers_orders = $db->Execute ( "select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where customers_id='" . $cInfo->customers_id . "' order by date_purchased desc" );
				
				$heading [] = array (
						'text' => '<b>编辑记录</b>' 
				);
				
				$contents [] = array (
						'text' => '<br />上浮比例： ' . $cInfo->customers_email_address 
				);
				
				$contents [] = array (
						'text' => '<br />添加时间: ' . $cInfo->create_time 
				);
				
				if ($customers_orders->RecordCount () != 0) {
					
					$contents [] = array (
							'text' => '<br />最后下单时间： ' . $customers_orders->fields ['date_purchased'] 
					);
				}
				
				$admin = $db->Execute ( "select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->channel_operator . "' order by admin_id desc" );
				if ($admin->RecordCount () != 0) {
					$contents [] = array (
							'text' => '<br />操作人： ' . $admin->fields ['admin_email'] 
					);
				}
			} else {
				$heading [] = array (
						'text' => '<b>编辑记录</b>' 
				);
				$contents [] = array (
						'text' => '<br />暂无记录' 
				);
			}
		}
		break;
	
	case 'confirmdelete' :
		if (isset ( $cInfo ) && is_object ( $cInfo )) {
			$heading [] = array (
					'text' => '<b>删除记录</b>' 
			);
			
			$contents = array (
					'form' => zen_draw_form ( 'channel', 'price_manager', zen_get_all_get_params ( array (
							'action' 
					) ) . 'action=delete', 'post', 'onsubmit="return check_form(channel)"', true ) 
			);
			$contents [] = array (
					'text' => '<br />确认删除该上浮比例吗？' 
			);
			
			$contents [] = array (
					'text' => '<p style="margin-left: 10px;margin-top: 10px;font-weight: bold;">' . $cInfo->price_manager_value . '%</p>' 
			);
			
			$contents [] = array (
					'text' => '<input type="hidden" name="price_manager_id" value="' . $cInfo->price_manager_id . '"/>' 
			);
			
			$contents [] = array (
					'text' => '<br /><input style="margin-left: 80px;height: 30px;width: 60px;" type="submit" value="确定"/>  <input onclick="location.href=\'' . zen_href_link ( 'price_manager' ) . '\'" type="button" style="margin-left: 15px;height: 30px;width: 60px;" value="取消"/></form>' 
			);
		}
		break;
	
	default :
		if (isset ( $cInfo ) && is_object ( $cInfo )) {
			
			$heading [] = array (
					'text' => '<b>编辑记录</b>' 
			);
			
			$contents [] = array (
					'text' => '<br />上浮比例： ' . $cInfo->price_manager_value . '%' 
			);
			
			$contents [] = array (
					'text' => '<br />添加时间: ' . $cInfo->price_manager_create_date 
			);
			
			$contents [] = array (
					'text' => '<br />修改时间: ' . $cInfo->price_manager_last_modified_date 
			);
			
			$contents [] = array (
					'text' => '<br />
		<input onclick="location.href=\'' . zen_href_link ( 'price_manager', zen_get_all_get_params ( array (
							'cID',
							'action' 
					) ) . 'cID=' . $cInfo->price_manager_id . '&action=edit', 'NONSSL' ) . '\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="编辑"/>
		<input onclick="location.href=\'' . zen_href_link ( 'price_manager', zen_get_all_get_params ( array (
							'cID',
							'action' 
					) ) . 'cID=' . $cInfo->price_manager_id . '&action=confirmdelete', 'NONSSL' ) . '\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="删除"/>' 
			);
		} else {
			$heading [] = array (
					'text' => '<b>编辑记录</b>' 
			);
			$contents [] = array (
					'text' => '<br />暂无记录' 
			);
		}
		break;
}

if ((zen_not_null ( $heading )) && (zen_not_null ( $contents ))) {
	
	echo '            <td width="25%" valign="top">' . "\n";
	
	$box = new box ();
	
	echo $box->infoBox ( $heading, $contents );
	
	echo '            </td>' . "\n";
}

?>

          </tr>
							</table></td>
					</tr>
				</table></td>
			<!-- body_text_eof //-->
		</tr>
	</table>
	<!-- body_eof //-->
	<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->
	<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

