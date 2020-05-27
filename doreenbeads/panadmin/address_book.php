<?php

/**

 * address_book.php

 * user define

 */

require ('includes/application_top.php');

function check_remote_area_byTranstype($address_book_id,$type='dhl'){
	global $db;
	
	//bof mannually added remote addresses, zale
	$remote_address_info = $db->Execute('SELECT c.countries_iso_code_2, ab.entry_postcode, ab.entry_city, c.countries_name FROM t_address_book ab, t_countries c WHERE ab.address_book_id = ' . $address_book_id . ' AND ab.entry_country_id = c.countries_id');
	$r_iso = $remote_address_info->fields['countries_iso_code_2'];
	$r_postage = $remote_address_info->fields['entry_postcode'];
	$r_postage = preg_replace('/[\s-]/', '', $r_postage);
	$r_city = $remote_address_info->fields['entry_city'];
	$r_country = $remote_address_info->fields['countries_name'];
	
	if($type == 'dhl'){
		$r_postage = strtolower(trim($r_postage));
		$r_city = strtolower(trim(preg_replace('/[\s-]/', '', $r_city)));
	}
	
	$postcode_contition = ' AND instr( "' . $r_postage . '", `postage` ) = 1 AND `postage` != "" ';
	
	//bof ups remote	
	if ($type == 'ups' || $type == 'dhl'){
		if (in_array(strtoupper($r_postage), array('IV9', 'IV10', 'IV11', 'IV12')) && $r_iso == 'GB' && $type == 'ups'){
			return 1;
		}
		$postcode_contition = ' AND postage <= "' . $r_postage . '" 
								   AND postcode_high >= "' . $r_postage . '" 
								   AND ' . strlen($r_postage) . ' <= length( postcode_high ) 
								   AND ' . strlen($r_postage) . ' >= length( postage )
								   AND city = ""';
	}
	//eof
	
	$sql_m = 'SELECT * FROM t_remote_address 
					WHERE (countries_iso_code_2 = "' . $r_iso . '"
					' . $postcode_contition . '
					AND trans_type = "'. $type .'")				
					OR 
					(countries_iso_code_2 = "'.$r_iso.'"
					AND city = "'.$r_city.'"
					AND trans_type = "'. $type .'")';
	$remote_m = $db->Execute($sql_m);
	if ($remote_m->RecordCount() > 0){
		//bof kdups remote
		if ($type == 'ups' || $type == 'dhl'){
	  		$postage_low = $remote_m->fields['postage'];
	  		$postage_high = $remote_m->fields['postcode_high'];
	  		if ((strlen($postage_high) > strlen($postage_low)) && is_numeric($postage_high)){
	  			if (is_numeric($r_postage)){
	  				return 1;
	  			}else {
	  				return 0;
	  			}
	  		}
	  	}
	  	//eof
		return 1;
	}
	//eof
	
	$sql="select ra_remote from  t_remote_area where ra_address_book_id=".$address_book_id." and ra_trans_type='$type' and ra_remote=1";
	$remote =$db->Execute ($sql);
	if($remote->RecordCount()>0){
		return 1;
	}else
	return 0;
	
}
function  save_remote($address_book_id,$remote_value,$trans_type='dhl'){
	global $db;
		$sql = "select * from  " . TABLE_REMOTE_AREA . "  where ra_address_book_id=:ra_address_book_id and ra_trans_type=:trans_type";
		$sql = $db->bindVars ( $sql, ':ra_address_book_id', $address_book_id, 'integer' );
		
		$sql = $db->bindVars ( $sql, ':trans_type', $trans_type, 'string' );
		$record = $db->Execute ( $sql );
	
		if ($record->RecordCount () == 0) {
			if ($remote_value == 1) {
				$sql = "insert into  " . TABLE_REMOTE_AREA . "  values(:ra_address_book_id,:trans_type,:ra_remote,1,now(),:modify_operator)";
				$sql = $db->bindVars ( $sql, ':ra_address_book_id', $address_book_id, 'integer' );
				$sql = $db->bindVars ( $sql, ':ra_remote', $remote_value, 'integer' );
				$sql = $db->bindVars ( $sql, ':trans_type', $trans_type, 'string' );
				$sql = $db->bindVars ( $sql, ':modify_operator', $_SESSION['admin_email'], 'string' );
				$db->Execute ( $sql );				
			}
		} else {
			if ($remote_value == 0) {
				if ($record->RecordCount () > 0){
				$sql = "delete from  " . TABLE_REMOTE_AREA . "  where ra_address_book_id=:ra_address_book_id and ra_trans_type=:trans_type";
				$sql = $db->bindVars ( $sql, ':ra_address_book_id', $address_book_id, 'integer' );
				$sql = $db->bindVars ( $sql, ':trans_type', $trans_type, 'string' );
				$db->Execute ( $sql );
				}				
			}
		}
}
$action = (isset ( $_GET ['action'] ) ? $_GET ['action'] : '');
$error = false;
switch ($action) {
	case 'save' :	
		$address_book_id = zen_db_prepare_input ( $_GET ['abID'] );
		if(zen_db_prepare_input ( $_POST ['dhl'] )==1) 
		save_remote($address_book_id,1,'dhl');
		else
		save_remote($address_book_id,0,'dhl');
		if(zen_db_prepare_input ( $_POST ['ups'] )==1)
		save_remote($address_book_id,1,'ups');
		else
		save_remote($address_book_id,0,'ups');
		if(zen_db_prepare_input ( $_POST ['fedex'] )==1)
		save_remote($address_book_id,1,'fedex');
		else
		save_remote($address_book_id,0,'fedex');
		if(zen_db_prepare_input ( $_POST ['dpd'] )==1)
		save_remote($address_book_id,1,'dpd');
		else
		save_remote($address_book_id,0,'dpd');

		
}

if (isset ( $_GET ['search'] ) && $_GET ['search'] != '') {
	$search = zen_db_prepare_input ( $_GET ['search'] );
	$filter_search = " and (customers_email_address like '%" . $search . "%' or customers_lastname like '%" . $search . "%'or entry_city like '%" . $search . "%'or entry_postcode like '%" . $search . "%')";
	if(isset ($_GET ['status'] ) && $_GET ['status'] != ''){
		$status =zen_db_prepare_input ( $_GET ['status'] );
		switch($status){
			case 1:
				$filter_search .=" and ra_remote=1 ";
				break;
			default:
				break;
		}
		
} 
}
else {
	$search = '';
	$filter_search = '';
	if(isset ($_GET ['status'] ) && $_GET ['status'] != ''){
		$status =zen_db_prepare_input ( $_GET ['status'] );
		switch($status){
			case 1:
				$filter_search .=" and ra_remote=1 ";
				break;
			default:
				break;
		}
}
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php
echo HTML_PARAMS;
?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php
	echo CHARSET;
	?>">
<title><?php
echo TITLE;
?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">

  <!--

  function init() {
    cssjsmenu('navbar');
    if (document.getElementById) {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }

  }

  // -->

</script>
</head>
<body onLoad="init()">

<!-- header //-->

<?php
require (DIR_WS_INCLUDES . 'header.php');
?>

<!-- header_eof //-->

<!-- body //-->

<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>

		<!-- body_text //-->

		<td width="100%" valign="top">
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="pageHeading"><?php
						echo HEADING_TITLE;
						?></td>
						<td class="" align="right">

            <?php
												echo zen_draw_form ( 'address_book', address_book, '', 'get' );
												echo 'Search: ' . zen_draw_input_field ( 'search' );
												?>
            
						</td>
					</tr>
					<tr>
                <td colspan="2" class="smallText" align="right">
                  <?php
                    /*$remote_status = array (array ("id" => '2', 'text' => 'all' ),array ("id" => '1', 'text' => '1' ));
                    echo TABLE_HEADING_STATUS . ' ' . zen_draw_pull_down_menu('status', $remote_status, $_GET['status'], 'onChange="this.form.submit();"');
                    echo zen_hide_session_id();*/
                  ?>
                  <input type="submit" />
                </td>
              </form></tr>
				</table>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">

				</table>
				</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
						<table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr class="dataTableHeadingRow">
								<td class="dataTableHeadingContent" align="left"
									style="padding: 5px 3px; width: 5%;"><?php
									echo TABLE_HEADING_CUSTOMER_ID;
									?></td>
								<td class="dataTableHeadingContent" align="left"
									style="padding: 5px 3px; width: 15%"><?php
									echo TABLE_HEADING_CUSTOMER_NAME;
									?></td>
								<td class="dataTableHeadingContent" align="left"
									style="padding: 5px 3px; width: 15%;"><?php
									echo TABLE_HEADING_CUSTOMER_EMAIL;
									?></td>
								<td class="dataTableHeadingContent" align="left"
									style="padding: 5px 3px; width: 25%;"><?php
									echo TABLE_HEADING_ADDRESS;
									?></td>
								<td class="dataTableHeadingContent" align="center"
									style="padding: 5px 3px; width: 10%;">Status</td>
								<!-- <td class="dataTableHeadingContent" align="center"
									style="padding: 5px 3px; width: 10%;"><?php
									echo "Status for UPS";
									?></td>
								<td class="dataTableHeadingContent" align="center"
									style="padding: 5px 3px; width: 10%;"><?php
									echo "Status for FEDEX";
								?></td>
								<td class="dataTableHeadingContent" align="center"
									style="padding: 5px 3px; width: 10%;"><?php
									echo "Status for DPD";
									?></td> -->
								<td class="dataTableHeadingContent" align="right"
									style="width: 10%;"><?php
									echo TABLE_HEADING_ACTION;
									?>&nbsp;</td>
							</tr>

<?php

$address_book_query = "select customers_lastname,customers_firstname,customers_email_address, t_address_book.* ,t_countries.countries_name,
  						 ra.ra_trans_type, ra.create_time, ra.modify_operator from   " . TABLE_CUSTOMERS . "  left join  " . TABLE_ADDRESS_BOOK . " 
  						  on t_customers.customers_id = t_address_book.customers_id
						  left join  " . TABLE_COUNTRIES . " 
						  on t_address_book.entry_country_id = t_countries.countries_id 
						  left join " . TABLE_REMOTE_AREA . " ra on ra.ra_address_book_id = t_address_book.address_book_id where address_book_id!=''
						  " . $filter_search . "
						  order by t_customers.customers_id desc";
$address_book_split = new splitPageResults ( $_GET ['page'], MAX_DISPLAY_SEARCH_RESULTS, $address_book_query, $address_book_numrows );
$address_book = $db->Execute ( $address_book_query );
while ( ! $address_book->EOF ) {
	//echo $address_book->fields ['address_book_id'];
$address_book->fields ['dhl']= check_remote_area_byTranstype($address_book->fields ['address_book_id'],'dhl');
$address_book->fields ['ups']= check_remote_area_byTranstype($address_book->fields ['address_book_id'],'ups');
$address_book->fields ['fedex']= check_remote_area_byTranstype($address_book->fields ['address_book_id'],'fedex');
$address_book->fields ['dpd']= check_remote_area_byTranstype($address_book->fields ['address_book_id'],'dpd'); 
	$address_row = array ('name' => $address_book->fields ['entry_firstname'] . ' ' . $address_book->fields ['entry_lastname'], 'company' => $address_book->fields ['entry_company'], 'street_address' => $address_book->fields ['entry_street_address'], 'suburb' => $address_book->fields ['entry_suburb'], 'city' => $address_book->fields ['entry_city'], 'postcode' => $address_book->fields ['entry_postcode'], 'state' => $address_book->fields ['entry_state'], 'country' => $address_book->fields ['countries_name'], 'format_id' => '1' );
	if ((! isset ( $_GET ['abID'] ) || (isset ( $_GET ['abID'] ) && ($_GET ['abID'] == $address_book->fields ['address_book_id']))) && ! isset ( $cInfo ) && (substr ( $action, 0, 3 ) != 'new')) {
		$address_book->fields ['addressrow'] = $address_row;
		
		$cInfo = new objectInfo ( $address_book->fields );
	}
	//var_dump($cInfo);exit;
	if (isset ( $cInfo ) && is_object ( $cInfo ) && ($address_book->fields ['address_book_id'] == $cInfo->address_book_id)) {
		echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link (FILENAME_ADDRESS_BOOK, zen_get_all_get_params(array('abID','action','page','search','status'))) .'?page=' . $_GET ['page'] . '&abID=' . $cInfo->address_book_id . '&action=edit' . (($search != '') ? '&search=' . $search : '').(($status != '') ? '&status=' . $status : '').'\'">' . "\n";
	
	} else {
		echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link (FILENAME_ADDRESS_BOOK, zen_get_all_get_params(array('abID','action','page','search','status')) ) .'?page=' . $_GET ['page'] .'&abID=' . $address_book->fields ['address_book_id'] . (($search != '') ? '&search=' . $search : ''). (($status != '') ? '&status=' . $status : '').'\'">' . "\n";
	
	}
	
	//
	

	?>

                <td class="dataTableContent" style="padding: 5px 3px;"><?php
	echo $address_book->fields ['customers_id'];
	?></td>
							<td class="dataTableContent" style="padding: 5px 3px;"><?php
	echo $address_book->fields ['customers_firstname'] . ' ' . $address_book->fields ['customers_lastname'];
	?></td>
							<td class="dataTableContent" style="padding: 5px 3px;"><?php
	echo ($_SESSION['show_customer_email'] ? $address_book->fields ['customers_email_address'] : strstr($address_book->fields ['customers_email_address'], '@', true) . '@');
	?></td>
							<td class="dataTableContent" style="padding: 5px 3px;"><?php
	echo zen_address_format ( $address_row ['format_id'], $address_row, 1, '', '<br />' );
	?></td>
							<td class="dataTableContent" align="center"
								style="padding: 5px 3px;"><?php
	echo ($address_book->fields['ra_trans_type'] != '' ? 'Remote for '.$address_book->fields['ra_trans_type'] : 'Normal' );
	?></td><!-- 
	</td>
							<td class="dataTableContent" align="center"
								style="padding: 5px 3px;"><?php
	echo $address_book->fields['ups'];
	?></td>
							<td class="dataTableContent" align="center"
								style="padding: 5px 3px;"><?php
	echo $address_book->fields['fedex'];
	?></td>
							<td class="dataTableContent" align="center"
								style="padding: 5px 3px;"><?php
	echo $address_book->fields['dpd'];
	?></td> -->
							<td class="dataTableContent" align="right"><?php
	if (isset ( $cInfo ) && is_object ( $cInfo ) && ($address_book->fields ['address_book_id'] == $cInfo->address_book_id)) {
		echo zen_image ( DIR_WS_IMAGES . 'icon_arrow_right.gif', '' );
	} else {
		echo '<a href="' . zen_href_link (FILENAME_ADDRESS_BOOK, zen_get_all_get_params(array('abID','action','page'))) .'?page=' . $_GET ['page'] . '&abID=' . $address_book->fields ['address_book_id'] . '&action=edit' . '">' . zen_image ( DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO ) . '</a>';
	}
	?>&nbsp;</td>

							</tr>

<?php
	$address_book->MoveNext ();
}

?>

              <tr>

								<td colspan="8">
								<table border="0" width="100%" cellspacing="0" cellpadding="2">

									<tr>
										<td class="smallText" valign="top"><?php
										echo $address_book_split->display_count ( $address_book_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET ['page'], TEXT_DISPLAY_NUMBER_OF_ADDRESS_BOOK );
										?></td>
										<td class="smallText" align="right"><?php
										
										//global $PHP_SELF ;
										 //$PHP_SELF = $HTTP_SERVER_VARS['REQUEST_URI'];
										echo $address_book_split->display_links ( $address_book_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET ['page'],zen_get_all_get_params(array('page', 'abID', 'action')) );
										?></td>
									</tr>

<?php
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
?>
                  <tr>
                    <td class="smallText" align="right" colspan="2">
                      <?php
                        echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>';
                        if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
                          $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
                          echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
                        }
                      ?>                    </td>
                  </tr>
<?php
  }
?>
                </table>
								</td>

							</tr>

						</table>
						</td>

<?php

$heading = array ();
$contents = array ();
$currencies_array = array (array ("id" => 'dhl', 'text' => 'dhl' ) ,array("id" => 'ups', 'text' => 'ups'), array("id" => 'fedex', 'text' => 'fedex'), array("id" => 'dpd', 'text' => 'dpd')); 
$remote_value_array = array (array ("id" => '1', 'text' => '1' ), array ("id" => '0', 'text' => '0' ) );

switch ($action) {
	
	case 'edit' :
		//echo address_book.php;exit;
		//var_dump($cInfo);exit;
		$heading [] = array ('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ADDRESS . ' for customer <br />' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>' );
		$contents = array ('form' => zen_draw_form ( 'address_book', FILENAME_ADDRESS_BOOK, 'page=' . $_GET ['page'] . '&abID=' . $cInfo->address_book_id . '&action=save' . (($search != '') ? '&search=' . $search : '') . (($status != '') ? '&status=' . $status : '')) );
		$contents [] = array ('text' => TEXT_INFO_EDIT_INTRO );
		$contents[] = array('text' => '<br />Mark Remote for DHL'.zen_draw_checkbox_field('dhl', '1',$cInfo->dhl?true:false));
		$contents[] = array('text' => '<br />Mark Remote for UPS'.zen_draw_checkbox_field('ups', '1',$cInfo->ups?true:false));
		$contents[] = array('text' => '<br />Mark Remote for FEDEX'.zen_draw_checkbox_field('fedex', '1',$cInfo->fedex?true:false));
		$contents[] = array('text' => '<br />Mark Remote for DPD'.zen_draw_checkbox_field('dpd', '1',$cInfo->dpd?true:false)); 
		$contents [] = array ('align' => 'center', 'text' => '<br>' . zen_image_submit ( 'button_update.gif', IMAGE_UPDATE ) . '&nbsp;<a href="' . zen_href_link (FILENAME_ADDRESS_BOOK, 'page=' . $_GET ['page'] . '&abID=' . $cInfo->address_book_id ) . (($search != '') ? '&search=' . $search : '') .(($status != '') ? '&status=' . $status : '').'">' . zen_image_button ( 'button_cancel.gif', IMAGE_CANCEL ) . '</a>' );
		
		break;
	default :
		if (is_object ( $cInfo )) {
			$heading [] = array ('text' => '<b>' . $cInfo->customers_email_address . '</b>' );
			$contents [] = array ('align' => 'center', 'text' => '<a href="' . zen_href_link (FILENAME_ADDRESS_BOOK, 'page=' . $_GET ['page'] . '&abID=' . $cInfo->address_book_id . '&action=edit' ) . (($search != '') ? '&search=' . $search : '') . (($status != '') ? '&status=' . $status : '').'">' . zen_image_button ( 'button_edit.gif', IMAGE_EDIT ) . '</a>');
			$contents [] = array ('text' => '<br>' . TEXT_INFO_CUSTOMER_NAME . '<br><b>' . $cInfo->customers_firstname . '&nbsp;' . $cInfo->customers_lastname . '</b>' );
			$contents [] = array ('text' => '<br>' . TEXT_INFO_CUSTOMER_EMAIL . '<br><b>' . ($_SESSION['show_customer_email'] ? $cInfo->customers_email_address : strstr($cInfo->customers_email_address, '@', true) . '@') . '</b>' );
			$contents [] = array ('text' => '<br>' . TEXT_INFO_ADDRESS . ' <b>' . zen_address_format ( $cInfo->addressrow ['format_id'], $cInfo->addressrow, 1, '', '<br />' ) );
			$contents [] = array ('text' => '<br> 操作人: <b>' . $cInfo->modify_operator );
			$contents [] = array ('text' => '<br> 操作时间: <b>' . $cInfo->create_time );
		}
		
		break;

}

echo 'heading';
echo 'contets';

if ((zen_not_null ( $heading )) && (zen_not_null ( $contents ))) {
	
	echo '            <td width="25%" valign="top">' . "\n";
	
	$box = new box ();
	
	echo $box->infoBox ( $heading, $contents );
	
	echo '            </td>' . "\n";

}

?>

          </tr>

				</table>
				</td>

			</tr>

		</table>
		</td>

		<!-- body_text_eof //-->

	</tr>

</table>

<!-- body_eof //-->



<!-- footer //-->

<?php
require (DIR_WS_INCLUDES . 'footer.php');
?>

<!-- footer_eof //-->

<br>

</body>

</html>

<?php
require (DIR_WS_INCLUDES . 'application_bottom.php');
?>