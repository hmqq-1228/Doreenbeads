<?php
/** shipping_display.php
  * 新增文件，找货
  * jessa 2010-03-30
  */
require('includes/application_top.php');
//error_reporting(E_ALL);
//var_dump($_SESSION['selected_shipping_new']);
//var_dump($_SESSION['selected_country_new']);

//unset($_SESSION['selected_shipping_new']);
//unset($_SESSION['selected_country_new']);

function getSelectedCountryAll(){
	global $db;

	$selected_country_array = array();

	$selected_country_query = $db->Execute('SELECT * FROM ' . TABLE_SHIPPING_DISPLAY);
	if ($selected_country_query->RecordCount() > 0) {
		while (!$selected_country_query->EOF){
			$selected_country_array[] = trim($selected_country_query->fields['country_ids'], ',');
			$selected_country_query->MoveNext();
		}
	}
	return $selected_country_array;
}

$id = zen_db_input($_GET['id']);
if ($id != '' || $_SERVER['QUERY_STRING'] == '') {
	unset($_SESSION['selected_shipping_new']);
	unset($_SESSION['selected_country_new']);
}
$action = zen_db_input($_GET['action']);

$where = '1=1';

if (isset($_GET['action']) && $_GET['action'] == 'new') {
	var_dump($_POST);
	$country_ids_new = zen_db_input(trim($_POST['country_ids_new'], ','));
	$country_name_new = zen_db_input(trim($_POST['country_name_new'], ','));
	$shipping_ids_new = zen_db_input(trim($_POST['shipping_ids_new'], ','));
    $virtual_shipping_ids_new = zen_db_input(trim($_POST['virtual_shipping_ids_new'], ','));
	$shipping_name_new = zen_db_input(trim($_POST['shipping_name_new'], ','));

	if ($country_ids_new == '') {
		$messageStack->add_session('国家为空，保存失败', 'error');
		zen_redirect(zen_href_link('shipping_display.php', zen_get_all_get_params(array('action,id')) . '&action=addnew'));
	}
	if ($shipping_ids_new == '' && $virtual_shipping_ids_new == '') {
		$messageStack->add_session('运输方式为空，保存失败', 'error');
		zen_redirect(zen_href_link('shipping_display.php', zen_get_all_get_params(array('action,id')) . '&action=addnew'));
	}

	$selected_country = explode(',', $country_ids_new);

	$isset_country = explode(',', implode(',', getSelectedCountryAll()));

	foreach ($selected_country as $selected_cty) {
		if (in_array($selected_cty, $isset_country)) {
			//unset($_SESSION['selected_shipping_new']);
			//unset($_SESSION['selected_country_new']);
			$messageStack->add_session(zen_get_country_name($selected_cty).'已经设置过显示运输方式的规则，保存失败', 'error');
			zen_redirect(zen_href_link('shipping_display.php', zen_get_all_get_params(array('action,id')) . '&action=addnew'));
		}
	}

	$sql_data_array = array('country_ids'=> ','.trim($country_ids_new, ',').',',
							'country_name'=>','.trim($country_name_new, ',').',',
							'shipping_ids'=>','.trim($shipping_ids_new, ',').',',
                            'virtual_shipping_ids'=>','.trim($virtual_shipping_ids_new, ',').',',
                            'shipping_name'=>','.trim($shipping_name_new, ',').',',
							'creat_admin_id'=>$_SESSION['admin_id'],
							'creat_admin'=>$_SESSION['admin_name'],
							'create_time'=>date('Y-m-d H:i:s')
							);

	zen_db_perform(TABLE_SHIPPING_DISPLAY, $sql_data_array);
	unset($_SESSION['selected_shipping_new']);
	unset($_SESSION['selected_country_new']);
	zen_redirect(zen_href_link('shipping_display.php', zen_get_all_get_params(array('page','id','mode','action'))));

	// /zen_redirect(zen_href_link('shipping_display.php'));
	
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$del_id = zen_db_input($_POST['del_id']);
	if ($del_id == '' || $del_id < 0) {
		$messageStack->add_session('系统错误，删除失败', 'error');
		zen_redirect(zen_href_link('shipping_display.php', zen_get_all_get_params(array('action,id'))));
	}
	$del_query =$db->Execute('DELETE FROM ' . TABLE_SHIPPING_DISPLAY . ' WHERE id = ' . $del_id);
	zen_redirect(zen_href_link('shipping_display.php', zen_get_all_get_params(array('page','id','mode','action'))));
}

function getShippingDisplayInfo($id=0, $where='1=1'){
	global $db;
	$orderby = '';
	if (empty($id) || $id == 0) {
		$orderby = ' order by id desc';
	}else{
		$where .= ' and id = ' . $id;
	}
	$shipping_display_sql = "SELECT * FROM " . TABLE_SHIPPING_DISPLAY . ' WHERE ' . $where . $orderby;
	//echo $shipping_display_sql;
	$shipping_display_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $shipping_display_sql, $search_query_numrows);
	$shipping_display_query = $db->Execute($shipping_display_sql);
	//var_dump($shipping_display_query);
	$shipping_display_array = array();
	if ($shipping_display_query->RecordCount() > 0){
	  	while (!$shipping_display_query->EOF){
	  		$shipping_display_array[] = $shipping_display_query->fields;
	  		$shipping_display_query->MoveNext();
  		}
	}
	$return_array = array('sql'=>$shipping_display_sql,'data'=>$shipping_display_array);
	return $return_array;
}
$shipping_display_function = $shipping_display_array = array();
$shipping_display_function = getShippingDisplayInfo(0, $where );
$shipping_display_array = $shipping_display_function['data'];
//print_r($shipping_display_array);

$shipping_display_sql = $shipping_display_function['sql'];
$shipping_display_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $shipping_display_sql, $search_query_numrows);

if (!isset($_GET['id']) || (isset($_GET['id']) && $_GET['id'] == '')){
	if ($action != 'addnew') {
		$id = $shipping_display_array[0]['id'];
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

function check_new_table(){
	var country_td = $('#country_td input').val();
	var shipping_td = $('#shipping_td input').val();
	if (country_td == '') {
		$('#country_td span').html('请选择国家');
		return false;
	};
	if (shipping_td == '') {
		$('#shipping_td span').html('请选择显示的运输方式');
		return false;
	};
	return true;
}
$(function(){
	$('#check_content').click(function(){
		var content = $('#content_info').val();
		if ($.trim(content).length <= 0) {
			alert('请输入处理结果');
			return false;
		}else{
			$('#add_content').submit();
		}
	});

	$('.show_content_textarea').click(function(){
		$('.content_textarea').show();
	});

	$('#cancel_content').click(function(){
		$('.content_textarea').hide();
	});
});

  // -->
</script>
<style>
	#country_td span, #shipping_td span{color:red;}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body bof -->
<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  	<tr>
  		<td class="pageHeading"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);?></td>
  	</tr>
  	<tr>
  		<td class="pageHeading"><div style="float:left;">运输方式显示设置</div></td>
	</tr>
  	<tr>
  		<td>
	  	
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:75%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	  	  <tr class="dataTableHeadingRow">
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">ID</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:25%;text-align:center;">国家</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:55%;text-align:center;">显示的运输方式</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 5px; width:10%; text-align:right;">操作</td>
	  	  	  </tr>
	  	  	  <?php
	  	  	    for ($i = 0; $i < sizeof($shipping_display_array); $i++){
	  	  	  ?>
	  	  	  <?php if ($id == $shipping_display_array[$i]['id']){ ?>
	  	  	  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link('shipping_display.php', 'id=' . $shipping_display_array[$i]['id'].'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id','action'))); ?>'">
	  	  	  <?php } else { ?>
	  	  	  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link('shipping_display.php', 'id=' . $shipping_display_array[$i]['id'].'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id','action'))); ?>'">
	  	  	  <?php } ?>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $shipping_display_array[$i]['id']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo trim($shipping_display_array[$i]['country_name'], ','); ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo trim($shipping_display_array[$i]['shipping_name'], ','); ?></td>
	  	  	  	
	  	  	  	<td class="dataTableContent" style="padding:5px 5px;" align="right">
	  	  	  	<?php 
	  	  	  	  if ($id == $shipping_display_array[$i]['id']){
	  	  	  	  	echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
	  	  	  	  } else {
	  	  	  	  	echo '<a href="' . zen_href_link('shipping_display.php',  'page='.$_GET['page'] . '&id=' . $shipping_display_array[$i]['id'].'&'.zen_get_all_get_params(array('page','id', 'action'))) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif') . '</a>';
	  	  	  	  }
	  	  	  	?>
	  	  	  	</td>
	  	  	  </tr>
	  	  	  <?php } ?>
	  	  	   <tr><td colspan="4" align="right"><a href="<?php echo zen_href_link('shipping_display.php',  'page='.$_GET['page'] . '&action=addnew&'.zen_get_all_get_params(array('page','id', 'action'))); ?>"><button style="width:100px;">新建</button></a></td></tr>
			  	<td height="40" align="left" colspan="2"><?php echo $shipping_display_split->display_count($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS);?></td>
			    <td height="40" align="right" colspan="2"><?php echo $shipping_display_split->display_links($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], $split_page_action);?></td>
	  	  	</table>
	  	  </td>
	  	  	<?php 
			  if ($action != 'addnew'){
			?>
	  	  <?php if ($id != 0 || $id != '') { ?>
	  	  <td style="width:25%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      <tr>
			  
	  	      	<td class="infoBoxHeading" style="padding:5px 5px;"><?php echo '#ID: ' . $id . '&nbsp;&nbsp;';?></td>
			 
	  	      </tr>
	  	      <tr>
	  	      	<td class="infoBoxContent" style="padding:5px;">
	  	      	<?php 
	  	      	$page = $_GET['page'];
	  	      	if ($id != 0 || $id != '') {
	  	      		# code...
	  	      	
	  	      		$shipping_display_function_info = getShippingDisplayInfo($id);
	  	      		$shipping_display_info = $shipping_display_function_info['data'][0];
	  	      		//var_dump($attachment_link);
	  	      	}
	  	      	?>
	  	      	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;width:35%;">国家:</td>
	  	      	  	  <td><a href="<?php echo zen_href_link('shipping_display_choose.php', 'id=' . $shipping_display_info['id'].'&mode=country&page='.$page.'&'.zen_get_all_get_params(array('page','id'))); ?>">编辑</a></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr><td colspan="2"><?php echo trim($shipping_display_info['country_name'],','); ?></td></tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">显示的运输方式:</td>
	  	      	  	  <td><a href="<?php echo zen_href_link('shipping_display_choose.php', 'id=' . $shipping_display_info['id'].'&mode=shipping&page='.$page.'&'.zen_get_all_get_params(array('page','id'))); ?>">编辑</a></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr><td colspan="2"><?php echo trim($shipping_display_info['shipping_name'], ','); ?></td></tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">创建人:</td>
	  	      	  	  <td><?php echo $shipping_display_info['creat_admin']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">创建时间:</td>
	  	      	  	  <td><?php echo $shipping_display_info['create_time']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<?php if($shipping_display_info['last_modify_admin']) { ?>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">修改人:</td>
	  	      	  	  <td><?php echo $shipping_display_info['last_modify_admin']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<?php } ?>
	  	      	  	<?php if($shipping_display_info['last_modify_time']) { ?>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">修改时间:</td>
	  	      	  	  <td><?php echo $shipping_display_info['last_modify_time']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<?php } ?>
	  	      	  	<tr>
	  	      	  		<td></td>
	  	      	  		<td>
		  	      	  		<form id="delete" action="shipping_display.php?action=delete" method="post" onsubmit=" return confirm('确定删除此条规则?');">
		  	      	  			<input type="hidden" name="del_id" value="<?php echo $id; ?>">
		  	      	  			<button style="width:100px;">删除</button>
		  	      	  		</form>
	  	      	  		</td>
	  	      	  	</tr>
	  	      	  </table>
	  	      	
	  	      	</td>
	  	      </tr>
	  	  	</table>
	  	  </td>
	  	  	<?php }}else{ ?>
				<td style="width:25%; vertical-align:top">
			  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
			  	      <tr>
					  
			  	      	<td class="infoBoxHeading" style="padding:5px 5px;"><?php echo '新建运输方式显示规则';?></td>
					 
			  	      </tr>
			  	      <tr>
			  	      	<td class="infoBoxContent" style="padding:5px;">
			  	      	<?php 
			  	      	if (!empty($_SESSION['selected_country_new'])) {
			  	      		$selected_country_new = $_SESSION['selected_country_new'];
			  	      		$country_ids_new = $selected_country_new['country_ids'];
			  	      		$country_name_new = implode($selected_country_new['country_name'], ',');
			  	      	}
			  	      	if (!empty($_SESSION['selected_shipping_new'])) {
			  	      		$selected_shipping_new = $_SESSION['selected_shipping_new'];
			  	      		$shipping_ids_new = $selected_shipping_new['shipping_ids'];
                            $virtual_shipping_ids_new = $selected_shipping_new['virtual_shipping_ids'];
			  	      		$shipping_name_new = trim($selected_shipping_new['shipping_name'], ',');
			  	      	}
			  	      	?>
			  	      	<form id="new_table" action="shipping_display.php?action=new" method="post" onsubmit=" return check_new_table();">
			  	      	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
			  	      	  	<tr>
			  	      	  	  <td style="font-weight:bold;width:35%;">国家:</td>
			  	      	  	  <td><a href="<?php echo zen_href_link('shipping_display_choose.php', '&mode=country&status=new&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id'))); ?>">选择国家</a></td>
			  	      	  	</tr>
			  	      	  	<tr><td><br/></td></tr>
			  	      	  	<tr><td colspan="2" id="country_td">
				  	      	  	<?php echo $country_name_new; ?>
				  	      	  	<input type="hidden" name="country_ids_new" value="<?php echo $country_ids_new; ?>" />
				  	      	  	<input type="hidden" name="country_name_new" value="<?php echo $country_name_new; ?>" />
				  	      	  	<span></span>
			  	      	  	</td></tr>
			  	      	  	<tr><td><br/></td></tr>
			  	      	  	<tr>
			  	      	  	  <td style="font-weight:bold;">运输方式:</td>
			  	      	  	  <td><a href="<?php echo zen_href_link('shipping_display_choose.php', '&mode=shipping&status=new&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id'))); ?>">选择运输方式</a></td>
			  	      	  	</tr>
			  	      	  	<tr><td><br/></td></tr>
			  	      	  	<tr><td colspan="2" id="shipping_td">
				  	      	  	<?php echo $shipping_name_new; ?>
				  	      	  	<input type="hidden" name="shipping_ids_new" value="<?php echo $shipping_ids_new; ?>" />
                                <input type="hidden" name="virtual_shipping_ids_new" value="<?php echo $virtual_shipping_ids_new; ?>" />
                                <input type="hidden" name="shipping_name_new" value="<?php echo $shipping_name_new; ?>" />
				  	      	  	<span></span>
			  	      	  	</td></tr>
			  	      	  	<tr><td><br/></td></tr>
			  	      	  	<tr>
			  	      	  	  <td><button type="submit">确认</button></td>
			  	      	  	  <td><a href="<?php echo zen_href_link('shipping_display.php', zen_get_all_get_params(array('page','id','mode','action'))); ?>"><button type="button">取消</button></a></td>
			  	      	  	</tr>
			  	      	  </table>
			  	      	</form>
			  	      	</td>
			  	      </tr>
			  	  	</table>
			  	  </td>
	  	  	<?php } ?>
	  	</tr>
	  </table>
  	</td>
  </tr>
</table>
<!-- body eof -->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>