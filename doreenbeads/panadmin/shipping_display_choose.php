<?php
/** shipping_display_choose.php
  * 新增文件，找货
  * jessa 2010-03-30
  */
require('includes/application_top.php');
error_reporting(0);
function getSelectedCountry($id){
	global $db;
	if (!$id) {return false;}

	$selected_country_array = array();

	$selected_country_query = $db->Execute('SELECT * FROM ' . TABLE_SHIPPING_DISPLAY . ' WHERE id != ' . $id);
	if ($selected_country_query->RecordCount() > 0) {
		while (!$selected_country_query->EOF){
			$selected_country_array[] = trim($selected_country_query->fields['country_ids'], ',');
			$selected_country_query->MoveNext();
		}
	}

	return $selected_country_array;
}

function getShippingName($id){
	global $db;
	if (!$id) {return false;}

	$shipping_name_query = $db->Execute('SELECT name FROM ' . TABLE_SHIPPING . ' WHERE id = ' . $id .' LIMIT 1');

	if ($shipping_name_query->RecordCount() < 1) {
      return $id;
    } else {
      return $shipping_name_query->fields['name'];
    }
}

function getVirtualShippingName($id){
    global $db;
    if (!$id) {return false;}

    $virtual_shipping_name_query = $db->Execute('select shipping_name from ' . TABLE_VIRTUAL_SHIPPING . ' where shipping_id = ' . $id . ' limit 1');

    if($virtual_shipping_name_query->RecordCount() > 0){
        return $virtual_shipping_name_query->fields['shipping_name'];
    }else{
        return $id;
    }

}


$page = $_GET['page'];
if (isset($_GET['action']) && $_GET['action'] == 'check_country') {
	$shipping_display_id = zen_db_input($_POST['id']);
	$is_new = zen_db_input($_POST['new_id']);
	$selected_country = $_POST['cty'];

	$selected_country_name = array();

	if (empty($selected_country)) {
		$messageStack->add_session('请至少选择一个国家', 'error');
		if ($is_new) {
			zen_redirect(zen_href_link('shipping_display_choose.php',   'page='.$page. '&status=new&mode=country&'.zen_get_all_get_params(array('id', 'page'))));
		}else{
			zen_redirect(zen_href_link('shipping_display_choose.php',   'page='.$page. '&id=' . $shipping_display_id.'&mode=country'.zen_get_all_get_params(array('action', 'page'))));
		}
	}else{
		if ($is_new) {
			$selected_country_ids = ',' . implode(',', $selected_country) . ',';
			foreach ($selected_country as $selected_cty) {
				$selected_country_name[] = zen_get_country_name($selected_cty);
			}
			$_SESSION['selected_country_new'] = array('country_ids'=>$selected_country_ids,
								'country_name'=>$selected_country_name
								);
			zen_redirect(zen_href_link('shipping_display.php', 'page='.$_GET['page'] .'&action=addnew&'.zen_get_all_get_params(array('action','id', 'page'))));
		}else{
			$isset_country = explode(',', implode(',', getSelectedCountry($shipping_display_id)));
			foreach ($selected_country as $selected_cty) {
				if (in_array($selected_cty, $isset_country)) {
					$messageStack->add_session(zen_get_country_name($selected_cty).'已经设置过显示运输方式的规则，保存失败', 'error');
					zen_redirect(zen_href_link('shipping_display_choose.php',  'page='.$_GET['page']. '&id=' . $shipping_display_id.'&mode=country'.zen_get_all_get_params(array('action', 'page'))));
				}else{
					$selected_country_name[] = zen_get_country_name($selected_cty);
				}
			}
			$selected_country_ids = ',' . implode(',', $selected_country) . ',';
			$selected_country_name = ',' . implode(',', $selected_country_name) . ',';
			$update_sql_data = array('country_ids'=>$selected_country_ids,
								'country_name'=>$selected_country_name,
								'last_modify_admin_id'=>$_SESSION['admin_id'],
								'last_modify_admin'=>$_SESSION['admin_name'],
								'last_modify_time'=>date('Y-m-d H:i:s')
								);
			zen_db_perform(TABLE_SHIPPING_DISPLAY, $update_sql_data, 'update', "id = '" . $shipping_display_id . "'");
			zen_redirect(zen_href_link('shipping_display.php', 'page='.$page.'&id=' . $shipping_display_id . '&'.zen_get_all_get_params(array('page','id', 'action'))));

		}
		
	}
}

if (isset($_GET['action']) && $_GET['action'] == 'check_shipping') {
	$shipping_display_id = zen_db_input($_POST['id']);
	$selected_shipping = $_POST['ship'];
    $selected_virtual_shipping = $_POST['virtual_ship'];
	$is_new = zen_db_input($_POST['new_id']);

	$selected_country_name = array();

	if (empty($selected_shipping) && empty($selected_virtual_shipping)) {
		$messageStack->add_session('请至少选择一个运输方式', 'error');
		if ($is_new) {
			zen_redirect(zen_href_link('shipping_display_choose.php', 'page='.$page. '&status=new&mode=shipping&'.zen_get_all_get_params(array('id', 'page'))));
		}else{
			zen_redirect(zen_href_link('shipping_display_choose.php', 'page='.$page. '&id=' . $shipping_display_id.'&mode=shipping&'.zen_get_all_get_params(array('action')) ));
		}
	}else{
		foreach ($selected_shipping as $selected_ship) {
			$selected_shipping_name[] = getShippingName($selected_ship);
		}
        foreach ($selected_virtual_shipping as $selected_virtual_ship){
            $selected_shipping_name[] = getVirtualShippingName($selected_virtual_ship);
        }
		$selected_shipping_ids = ',' . implode(',', $selected_shipping) . ',';
        $selected_virtual_ids = ',' . implode(',', $selected_virtual_shipping) . ',';
		$selected_shipping_name = ',' . implode(',', $selected_shipping_name) . ',';
		if ($is_new) {
			$_SESSION['selected_shipping_new'] = array(
			        'shipping_ids'=>$selected_shipping_ids,
                    'virtual_shipping_ids' => $selected_virtual_ids,
                    'shipping_name'=>$selected_shipping_name
            );
			zen_redirect(zen_href_link('shipping_display.php', 'page='.$page.'&action=addnew&'.zen_get_all_get_params(array('action', 'id', 'page')) ));
		}else{
			$update_sql_data = array(
			        'shipping_ids'=>$selected_shipping_ids,
                    'virtual_shipping_ids' => $selected_virtual_ids,
                    'shipping_name'=>$selected_shipping_name,
                    'last_modify_admin_id'=>$_SESSION['admin_id'],
                    'last_modify_admin'=>$_SESSION['admin_name'],
                    'last_modify_time'=>date('Y-m-d H:i:s')
            );
			zen_db_perform(TABLE_SHIPPING_DISPLAY, $update_sql_data, 'update', "id = '" . $shipping_display_id . "'");
			zen_redirect(zen_href_link('shipping_display.php', 'page='.$_GET['page'].'&id=' . $shipping_display_id . '&'.zen_get_all_get_params(array('page','id', 'action'))));
		}
	}
}



$mode = '';
if (isset($_GET['mode']) && $_GET['mode'] != '') {
	$mode = zen_db_input($_GET['mode']);
}

if (isset($_GET['id']) && $_GET['id'] != '') {
	$shipping_display_id = zen_db_input($_GET['id']);
}

if (isset($_GET['status']) && $_GET['status'] != '') {
	$status = zen_db_input($_GET['status']);
}

$country_array = zen_get_countries();
$all_shipping_query = $db->Execute("SELECT * FROM " .TABLE_SHIPPING . " WHERE status=1 ");
if ($all_shipping_query->RecordCount() > 0) {
	while ( ! $all_shipping_query->EOF ) {
	  	$all_shipping_method [$all_shipping_query->fields ['id']] = array (
	  				'id' => $all_shipping_query->fields ['id'],
	  				'name' => $all_shipping_query->fields ['name']
	  				);
	  	$all_shipping_query->MoveNext();
	}
}

$virtual_shipping_query = $db->Execute("select shipping_id, shipping_erp_id, shipping_code, country_code, shipping_name from " . TABLE_VIRTUAL_SHIPPING . " where shipping_status = 10");
if($virtual_shipping_query->RecordCount() > 0){
    while(!$virtual_shipping_query->EOF){
        $virtual_shipping_array[$virtual_shipping_query->fields['shipping_id']] = array(
            'id' => $virtual_shipping_query->fields['shipping_id'],
            'name' => $virtual_shipping_query->fields['shipping_name']
        );
        $virtual_shipping_query->MoveNext();
    }
}

if ($shipping_display_id > 0) {
	$shipping_display_query = $db->Execute("SELECT * from " . TABLE_SHIPPING_DISPLAY . " WHERE id = " . $shipping_display_id . ' LIMIT 1');
	$shipping_display_info = $shipping_display_query->fields;
	$shipping_display_info_cty = explode(',', trim($shipping_display_info['country_ids'], ','));
	$shipping_display_info_ship = explode(',', trim($shipping_display_info['shipping_ids'], ','));
    $shipping_display_info['virtual_shipping_ids'] = trim($shipping_display_info['virtual_shipping_ids'], ',');
    $shipping_display_info_virtual_shipping = $shipping_display_info['virtual_shipping_ids'] != '' ? explode(',', $shipping_display_info['virtual_shipping_ids']) : array();
}else{
	if (!empty($_SESSION['selected_shipping_new'])) {
		$shipping_display_info_ship = explode(',', trim($_SESSION['selected_shipping_new']['shipping_ids'], ','));
        $shipping_display_info_virtual_shipping = $_SESSION['selected_shipping_new']['virtual_shipping_ids'] != '' ? explode(',', trim($_SESSION['selected_shipping_new']['virtual_shipping_ids'], ',')) : array();
	}
	if (!empty($_SESSION['selected_country_new'])) {
		$shipping_display_info_cty = explode(',', trim($_SESSION['selected_country_new']['country_ids'], ','));
	}
}


?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/javascript/jscript_jquery.js"></script>
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

  function confirmDelete(){
	 if(confirm('Are you sure to delete it?')){
		 return true;
	 }else{
			return false;
		 }
	  }
$(function(){
	
});

  // -->
</script>
<style>
	.country_table{font-size:12px; width:100%;}
	.country_table th{vertical-align: top; font-size: 14px;}
	.country_table td{vertical-align: top;}
	.country_table span{width:160px; display:inline-block; margin:0px 5px 10px 0; vertical-align: top; font-size: 12px;}
	#country_submit{margin-top: 35px;margin-right: 100px;width: 100px;}
	.cancel_button{width: 100px;}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<div style="margin-left:10px;">
<!-- body bof -->
<?php if ($mode == 'country') { ?>
	<h1>选择国家</h1>
	<form action="shipping_display_choose.php?action=check_country&page=<?php echo $_GET['page'] ?>" method="post">
		<table class="country_table">
			<tr>
				<th width="15%">已选择的国家</th>
				<td>
				<?php foreach ($shipping_display_info_cty as $selected) { ?>
					<span><label><input name="cty[]" type="checkbox" checked="checked" value="<?php echo $selected; ?>" /><?php echo zen_get_country_name($selected); ?></label></span>
				<?php } ?>
				</td>
			</tr>
			<tr>
				<th width="15%">未选择的国家</th>
				<td>
					<?php foreach ($country_array as $unselected) { ?>
						<?php if(in_array($unselected['id'], $shipping_display_info_cty)) continue; ?>
						<span><label><input name="cty[]" type="checkbox" value="<?php echo $unselected['id']; ?>" /><?php echo $unselected['text']; ?></label></span>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php if($status == 'new') { ?>
						<input type="hidden" name="new_id" value="1" />
					<?php }else{ ?>
						<input type="hidden" name="id" value="<?php echo $shipping_display_id; ?>" />
					<?php } ?>
					
					<button id="country_submit" type="submit">确认</button>
					<a href="<?php echo zen_href_link('shipping_display.php', 'id=' . $shipping_display_id.'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id','mode'))); ?>"><button class="cancel_button" type="button" >取消</button></a>
				</td>
			</tr>
		</table>
	</form>
<?php }elseif($mode == 'shipping'){ ?>
	<h1>选择运输方式</h1>
	<form action="shipping_display_choose.php?action=check_shipping&page=<?php echo $_GET['page'] ?>" method="post">
		<table class="country_table">
			<tr>
				<th width="15%">已选择的运输方式</th>
				<td>
                    <?php
                    if(sizeof($shipping_display_info_ship) > 0){
                        foreach ($shipping_display_info_ship as $selected) { ?>
                            <span><label><input name="ship[]" type="checkbox" checked="checked" value="<?php echo $selected; ?>" /><?php echo getShippingName($selected); ?></label></span>
                        <?php }
                    }?>
				</td>
			</tr>
            <tr>
                <td></td>
                <td>
                    <div style="font-weight: bold;margin-bottom: 10px;margin-top: 20px;">虚拟海外仓运输方式</div>
                    <div>
                        <?php
                        if(sizeof($shipping_display_info_virtual_shipping) > 0){
                            foreach ($shipping_display_info_virtual_shipping as $selected) { ?>
                                <span><label><input name="virtual_ship[]" type="checkbox" checked="checked" value="<?php echo $selected; ?>" /><?php echo getVirtualShippingName($selected); ?></label></span>
                            <?php }
                        }?>
                    </div>
                </td>
            </tr>
            <tr style="height: 30px;"><td></td><td></td></tr>
			<tr>
				<th width="15%">未选择的运输方式</th>
				<td>
					<?php foreach ($all_shipping_method as $unselected) { ?>
						<?php if(in_array($unselected['id'], $shipping_display_info_ship)) continue; ?>
						<span><label><input name="ship[]" type="checkbox" value="<?php echo $unselected['id']; ?>" /><?php echo $unselected['name']; ?></label></span>
					<?php } ?>
				</td>
			</tr>
            <tr>
                <td></td>
                <td>
                    <div style="color: #ff1719;font-weight: bold;margin-bottom: 10px;margin-top: 20px;">虚拟海外仓运输方式</div>
                    <div>
                        <?php foreach ($virtual_shipping_array as $unselected) {
                            if(in_array($unselected['id'], $shipping_display_info_virtual_shipping)) continue; ?>
                            <span><label><input name="virtual_ship[]" type="checkbox" value="<?php echo $unselected['id']; ?>" /><?php echo $unselected['name']; ?></label></span>
                        <?php } ?>
                    </div>
                </td>
            </tr>
			<tr>
				<td></td>
				<td>
					<?php if($status == 'new') { ?>
						<input type="hidden" name="new_id" value="1" />
					<?php }else{ ?>
						<input type="hidden" name="id" value="<?php echo $shipping_display_id; ?>" />
					<?php } ?>
					<button id="country_submit" type="submit">确认</button>
					<a href="<?php echo zen_href_link('shipping_display.php', 'id=' . $shipping_display_id.'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id','mode'))); ?>"><button class="cancel_button" type="button" >取消</button></a>
				</td>
			</tr>
		</table>
	</form>
<?php } ?>
<!-- body eof -->
</div>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>