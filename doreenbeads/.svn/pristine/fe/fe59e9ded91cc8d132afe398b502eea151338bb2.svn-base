<?php

/**

 * @package admin

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: countries.php 4280 2006-08-26 03:32:55Z drbyte $

 */



  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  $cID = zen_db_prepare_input($_GET['cID']);

  $error = false;

  $processed = false;


  if (zen_not_null($action)) {

    switch ($action) {
	  case 'insert':
		     $error_message = '';
			 $countries_name= zen_db_prepare_input($_POST['countries_name']);
			 $countries = $db->Execute("select c.countries_id from ".TABLE_COUNTRIES." c where c.countries_name = '".$countries_name."'");

			 if($countries->RecordCount() > 0){
				$gc = $db->Execute("select c.countries_id,c.countries_name,cw.create_time,operator from ".TABLE_CUSTOMERS_GC_COUNTRY." cw ,".TABLE_COUNTRIES." c where c.countries_id = cw.countries_id and  cw.countries_id = " . (int)$countries->fields['countries_id'] . "");
				if($gc->RecordCount() > 0){
					$error_message = '您所输入的国家已经存在于列表中';
				}else{
					  $sql_data_array = array('countries_id' => (int)$countries->fields['countries_id'],

                                'create_time' => 'now()',

                                'operator' => $_SESSION['admin_id']
                               
                                );
					  zen_db_perform(TABLE_CUSTOMERS_GC_COUNTRY, $sql_data_array);
					  zen_redirect(zen_href_link('customers_gc_country', 'NONSSL'));

				}

			 }else{
				$error_message = '系统中找不到该国家';
			 }
			
			break;
	  case 'insert_all':
		     
			 $countries = $db->Execute("select c.countries_id from ".TABLE_COUNTRIES." c");
			 $i = 0;
			 while(!$countries->EOF){
					if((int)$countries->fields['countries_id'] > 0){
						$sql_data_array = array('countries_id' => (int)$countries->fields['countries_id'],

                                'create_time' => 'now()',

                                'operator' => $_SESSION['admin_id']
                               
                                );
					  zen_db_perform(TABLE_CUSTOMERS_GC_COUNTRY, $sql_data_array);
					  $i++;
					}
					$countries->MoveNext();
			 }
			 echo $i;exit;
			
			break;
      case 'update':
			 $error_message = '';
			 $countries_name= zen_db_prepare_input($_POST['countries_name']);
			 $countries = $db->Execute("select c.countries_id from ".TABLE_COUNTRIES." c where c.countries_name = '".$countries_name."'");

			 if($countries->RecordCount() > 0){
				$gc = $db->Execute("select c.countries_id,c.countries_name,cw.create_time,operator from ".TABLE_CUSTOMERS_GC_COUNTRY." cw ,".TABLE_COUNTRIES." c where c.countries_id = cw.countries_id and  cw.countries_id = " . (int)$countries->fields['countries_id'] . "");
				if($gc->RecordCount() > 0){
					$error_message = '您所输入的国家已经存在于列表中';
				}else{
					  $sql_data_array = array('countries_id' => (int)$countries->fields['countries_id'],

                                'create_time' => 'now()',

                                'operator' => $_SESSION['admin_id']
                               
                                );
					  zen_db_perform(TABLE_CUSTOMERS_GC_COUNTRY, $sql_data_array,'update', "gc_country_id = '" . (int)$_POST['gc_country_id'] . "'");
					  zen_redirect(zen_href_link('customers_gc_country', 'cID=' . $_GET['cID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'NONSSL'));

				}

			 }else{
				$error_message = '系统中找不到该国家';
			 }
			
			break;
        
		case 'delete':

			if($db->Execute("delete from ".TABLE_CUSTOMERS_GC_COUNTRY."  where gc_country_id = '" . (int)$_POST['gc_country_id'] . "'")){
				$messageStack->add_session('删除成功', 'success');
				zen_redirect(zen_href_link('customers_gc_country', (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'NONSSL'));
				
			}

			
        break;

      default:
		if(isset($cID) && $cID > 0){
			$countries = $db->Execute("select c.countries_id,c.countries_name,cw.create_time,operator,cw.gc_country_id from ".TABLE_CUSTOMERS_GC_COUNTRY." cw ,".TABLE_COUNTRIES." c where c.countries_id = cw.countries_id and cw.gc_country_id = '" . (int)$cID . "' group by cw.countries_id  ");
			
			$cInfo = new objectInfo($countries->fields);
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
  var countries_name = document.gc.countries_name.value;
  if(countries_name == ''){
	alert('国家不能为空');
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

<!-- header //-->

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->



<!-- body //-->

<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>

<!-- body_text //-->

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">




<!--end-->

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr><?php echo zen_draw_form('search', FILENAME_countries, '', 'get', '', true); ?>

            <td class="pageHeading"><?php echo '默认不显示GC支付方式国家管理'; ?></td>

            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>

            <td class="smallText" align="right">

            </td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

<?php

// Sort Listing

          switch ($_GET['list_order']) {

              default:

              $disp_order = "cw.gc_country_id DESC";

          }

?>        
		

             <td valign="top"><table border="0" width="1050" cellspacing="0" cellpadding="2">
			<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method='post' id="customerForm" onsubmit="return changeAction()">
              <tr class="dataTableHeadingRow">
              
              <td class="specialCustomerTable">
              <ul>
               

                <li class="dataTableHeadingContent customer_id" style="width:230px;" align="left" valign="top">

                  <?php echo '国家'; ?>

                </li>

				<li class="dataTableHeadingContent customer_id" style="width:220px;" align="center" valign="top">

                  <?php echo '添加时间'; ?>

                </li>

				<li class="dataTableHeadingContent customer_id" style="width:200px;" align="center" valign="top">

                  <?php echo '操作人'; ?>

                </li>
				

                <li class="dataTableHeadingContent customer_info" style="width:190px;text-align: right;"><?php echo '操作'; ?>&nbsp;</li>
 				
</ul></td>
              </tr>

<?php


    $countries_query_raw = " select c.countries_id,c.countries_name,cw.create_time,operator,cw.gc_country_id from ".TABLE_CUSTOMERS_GC_COUNTRY." cw ,".TABLE_COUNTRIES." c where  c.countries_id = cw.countries_id group by cw.countries_id order by $disp_order";

//echo $countries_query_raw;exit;

// Split Page

// reset page when page is unknown
//echo $countries_query_raw;exit;
if (($_GET['page'] == '' or $_GET['page'] == '1') and $_GET['cID'] != '') {

  $check_page = $db->Execute($countries_query_raw);

  $check_count=1;

  if ($check_page->RecordCount() > MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER) {

    while (!$check_page->EOF) {

      if ($check_page->fields['gc_country_id'] == $_GET['cID']) {

        break;

      }

      $check_count++;

      $check_page->MoveNext();

    }

    $_GET['page'] = round((($check_count/MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER)+(fmod_round($check_count,MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER) !=0 ? .5 : 0)),0);

//    zen_redirect(zen_href_link(FILENAME_countries, 'cID=' . $_GET['cID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'NONSSL'));

  } else {

    $_GET['page'] = 1;

  }

}



    $countries_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $countries_query_raw, $countries_query_numrows);

    $countries = $db->Execute($countries_query_raw);

    while (!$countries->EOF) {
	 if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $countries->fields['gc_country_id']))) && !isset($cInfo)) {

        $cInfo = new objectInfo($countries->fields);
	 }
	 if (isset($cInfo) && is_object($cInfo) && ($countries->fields['gc_country_id'] == $cInfo->gc_country_id)) {

        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";

      } else {

        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";

      }
   
?>

<td class="specialCustomerTable">
<ul>
			

			<li class="dataTableContent customer_id" style="width:230px;" align="left" valign="top">

                  <?php echo $countries->fields['countries_name']; ?>

                </li>

				<li class="dataTableContent customer_id" style="width:220px;" align="center" valign="top">

                  <?php echo $countries->fields['create_time']; ?>

                </li>

				<li class="dataTableContent customer_id" style="width:200px;" align="center" valign="top">

                 

                </li>

				<li class="dataTableContent customer_id" style="width:200px;" align="center" valign="top">

                  <?php
					 
					$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $countries->fields['operator'] . "' order by admin_id desc");
					if ($admin->RecordCount() != 0) {
						echo $admin->fields['admin_email'];
					} ?>

                </li>
				

                <li class="dataTableHeadingContent customer_info" style="width:180px;text-align: right;"><?php echo '<a href="' . zen_href_link('customers_gc_country', zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $countries->fields['gc_country_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', '修改') . '</a>'; ?>
				<?php echo '<a href="' . zen_href_link('customers_gc_country', zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $countries->fields['gc_country_id'] . '&action=confirmdelete', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', '删除') . '</a>'; ?>
				<?php if (isset($cInfo) && is_object($cInfo) && ($countries->fields['gc_country_id'] == $cInfo->gc_country_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link('customers_gc_country', zen_get_all_get_params(array('cID','action')) . 'cID=' . $countries->fields['gc_country_id'] . ($_GET['page'] > 0 ? '&page=' . $_GET['page'] : ''), 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</li>

               
				       				
</ul></td>
              </tr>

<?php

      $countries->MoveNext();

    }

?>

			<tr>
			
			<td align='right'><input onclick="location.href='<?php echo zen_href_link('customers_gc_country','action=new');?>'" type="button" style="height: 30px;width: 80px;" value='<?php echo '新建';?>'/></div></td>
			</tr>
			</form> 
              <tr>

                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>

                    <td class="smallText" valign="top"><?php echo $countries_split->display_count($countries_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>

                    <td class="smallText" align="right"><?php echo $countries_split->display_links($countries_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>

                  </tr>

                </table></td>

              </tr>

            </table>
           
            </td>

<?php

// BOF Set variables for login_as_customer module



  $place_order_button = 'includes/languages/english/images/buttons/button_placeorder.gif';

  $login_as_customer = 'index.php?main_page=login_as_customer';

  if (ENABLE_SSL_CATALOG == 'true') {

$url = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;

} elseif (ENABLE_SSL_CATALOG == 'false') {

$url = HTTP_SERVER .  DIR_WS_CATALOG; 

}

  $p_url = $url;

  $p_url .= $login_as_customer;

//EOF Setf Variables for login_as_customer module

  $heading = array();

  $contents = array();



  switch ($action) {
      case 'new':

			$heading[] = array('text' => '<b>新建信息</b>');

			$contents = array('form' => zen_draw_form('gc', 'customers_gc_country', zen_get_all_get_params(array('action')) .  'action=insert', 'post', 'onsubmit="return check_form(gc)"', true));
			$contents[] = array('text' => '<br />国家：');

			

			$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="countries_name"/>');

			$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link('customers_gc_country').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');




			 break;
	  case 'edit':
		    if (isset($cInfo) && is_object($cInfo)) {
				$heading[] = array('text' => '<b>编辑信息</b>');

				$contents = array('form' => zen_draw_form('gc', 'customers_gc_country', zen_get_all_get_params(array('action')) .  'action=update', 'post', 'onsubmit="return check_form(gc)"', true));
				$contents[] = array('text' => '<br />国家：');

				

				$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="countries_name" value="'. $cInfo->countries_name.'"/>');

				$contents[] = array('text' => '<input type="hidden" name="gc_country_id" value="'. $cInfo->gc_country_id.'"/>');

				$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link('customers_gc_country').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');

			}

			 break;
	  
	  case 'update':
			
			if($error_message != ''){
				$heading[] = array('text' => '<b>编辑信息</b>');

				$contents = array('form' => zen_draw_form('gc', 'customers_gc_country', zen_get_all_get_params(array('action')) .  'action=update', 'post', 'onsubmit="return check_form(gc)"', true));
				$contents[] = array('text' => '<br />国家：');

				

				$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="countries_name" value="'. $countries_name.'"/>');
				
				$contents[] = array('text' => '<p style="margin-left: 10px;color:red;">'.$error_message.'</p>');
				$contents[] = array('text' => '<input type="hidden" name="gc_country_id" value="'. $_POST['gc_country_id'].'"/>');

				$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link('customers_gc_country').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');

			}else{

				if (isset($cInfo) && is_object($cInfo)) {
				//$countries_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where countries_id='" . $cInfo->countries_id . "' order by date_purchased desc");

				
				$heading[] = array('text' => '<b>编辑信息</b>');



				
				$contents[] = array('text' => '<br />国家： ' . $cInfo->countries_name);
				
				$contents[] = array('text' => '<br />添加时间: ' .$cInfo->create_time);
				
				if ($countries_orders->RecordCount() != 0) {

				  //$contents[] = array('text' => '<br />最后下单时间： ' . $countries_orders->fields['date_purchased']);

				}
				
				$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->operator . "' order by admin_id desc");
				if ($admin->RecordCount() != 0) {
					$contents[] = array('text' => '<br />操作人： ' . $admin->fields['admin_email']);
				}

			  }else{
				$heading[] = array('text' => '<b>编辑信息</b>');
				$contents[] = array('text' => '<br />暂无记录');
			  }
			 
			}
			break;

	  case 'insert':
			
			if($error_message != ''){
				$heading[] = array('text' => '<b>新建信息</b>');

				$contents = array('form' => zen_draw_form('gc', 'customers_gc_country', zen_get_all_get_params(array('action')) .  'action=insert', 'post', 'onsubmit="return check_form(gc)"', true));
				$contents[] = array('text' => '<br />国家：');

				$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="countries_name" value="'.$countries_name.'"/>');

				$contents[] = array('text' => '<p style="margin-left: 10px;color:red;">'.$error_message.'</p>');

				$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link('customers_gc_country').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');
			}else{

				if (isset($cInfo) && is_object($cInfo)) {
				//$countries_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where countries_id='" . $cInfo->countries_id . "' order by date_purchased desc");

				
				$heading[] = array('text' => '<b>编辑信息</b>');



				
				$contents[] = array('text' => '<br />国家： ' . $cInfo->countries_name);
				
				$contents[] = array('text' => '<br />添加时间: ' .$cInfo->create_time);
				
				//if ($countries_orders->RecordCount() != 0) {

				  //$contents[] = array('text' => '<br />最后下单时间： ' . $countries_orders->fields['date_purchased']);

				//}
				
				$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->operator . "' order by admin_id desc");
				if ($admin->RecordCount() != 0) {
					$contents[] = array('text' => '<br />操作人： ' . $admin->fields['admin_email']);
				}

			  }else{
				$heading[] = array('text' => '<b>编辑信息</b>');
				$contents[] = array('text' => '<br />暂无记录');
			  }
			 
			}
			break;

      case 'confirmdelete':
		  if (isset($cInfo) && is_object($cInfo)) {
				$heading[] = array('text' => '<b>删除信息</b>');

				$contents = array('form' => zen_draw_form('gc', 'customers_gc_country', zen_get_all_get_params(array('action')) .  'action=delete', 'post', 'onsubmit="return check_form(gc)"', true));
				$contents[] = array('text' => '<br />确认要删除该信息吗？');

				$contents[] = array('text' => '<p style="margin-left: 10px;margin-top: 10px;font-weight: bold;">'.$cInfo->countries_name.'</p>');
				
				$contents[] = array('text' => '<input type="hidden" name="gc_country_id" value="'. $cInfo->gc_country_id.'"/>');

				$contents[] = array('text' => '<br /><input style="margin-left: 80px;height: 30px;width: 60px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link('customers_gc_country').'\'" type="button" style="margin-left: 15px;height: 30px;width: 60px;" value="取消"/></form>');		
		   }
      break;

    default:
      if (isset($cInfo) && is_object($cInfo)) {
        //$countries_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where countries_id='" . $cInfo->countries_id . "' order by date_purchased desc");

		
        $heading[] = array('text' => '<b>编辑信息</b>');

		$contents[] = array('text' => '<br />
		<input onclick="location.href=\''.zen_href_link('customers_gc_country', zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->gc_country_id . '&action=edit', 'NONSSL').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="编辑"/>
		<input onclick="location.href=\''.zen_href_link('customers_gc_country', zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->gc_country_id . '&action=confirmdelete', 'NONSSL').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="删除"/>');

        
		$contents[] = array('text' => '<br />国家： ' . $cInfo->countries_name);
		
		$contents[] = array('text' => '<br />添加时间: ' .$cInfo->create_time);
		
		//if ($countries_orders->RecordCount() != 0) {

          //$contents[] = array('text' => '<br />最后下单时间： ' . $countries_orders->fields['date_purchased']);

       // }
		
		$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->operator . "' order by admin_id desc");
		if ($admin->RecordCount() != 0) {
			$contents[] = array('text' => '<br />操作人： ' . $admin->fields['admin_email']);
		}

      }else{
		$heading[] = array('text' => '<b>编辑信息</b>');
		$contents[] = array('text' => '<br />暂无记录');
	  }
      break;

  }



  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {

    echo '            <td width="25%" valign="top">' . "\n";



    $box = new box;

    echo $box->infoBox($heading, $contents);



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

