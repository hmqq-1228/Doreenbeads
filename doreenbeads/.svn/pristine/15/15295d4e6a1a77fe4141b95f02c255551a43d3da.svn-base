<?php
/** oem_sourcing.php
  * 新增文件，找货
  * jessa 2010-03-30
  */
require('includes/application_top.php');
//error_reporting(E_ALL);

if (!isset($_GET['oem_id']) || (isset($_GET['oem_id']) && $_GET['oem_id'] == '')){
  	$oem_id = $oem_sourcing_array[0]['oem_id'];
} else {
  	$oem_id = $_GET['oem_id'];
}

$where = '1=1';
$email = (isset($_GET['email']) && $_GET['email'] != '') ? zen_db_input($_GET['email']) : '' ;
$lang = (isset($_GET['l']) && $_GET['l'] != '') ? zen_db_input($_GET['l']) : '' ;
$type = (isset($_GET['t']) && $_GET['t'] != '') ? zen_db_input($_GET['t']) : '' ;
$status = (isset($_GET['status']) && $_GET['status'] != '') ? zen_db_input($_GET['status']) : '' ;

if ($email != '') {$where .= ' and customer_email like "%' . $email . '%"';}
if ($lang != '') {$where .= ' and languages_id = ' . $lang;}
if ($status != '') {$where .= ' and status = ' . $status;}
if ($type != '') {$where .= ' and oem_type = ' . $type;}

if (isset($_GET['action']) && $_GET['action'] == 'add_content') {
	$sql_data_array = array();
	$content = zen_db_input(trim($_POST['content_info']));
	$oem_id = zen_db_input($_POST['oem_id']);
	if ( isset($oem_id) && $oem_id > 0 ) {
		$sql_data_array['content'] = $content;
		$sql_data_array['oem_id'] = $oem_id;
		$sql_data_array['admin_id'] = $_SESSION['admin_id'];
		$sql_data_array['admin_email'] = $_SESSION['admin_email'];
		$sql_data_array['admin_name'] = $_SESSION['admin_name'];
		$sql_data_array['modify_time'] = date('Y-m-d H:i:s');
		$sql_data_array['status'] = 20;

		zen_db_perform(TABLE_OEM_SOURCING, $sql_data_array, 'update', "oem_id = " . $oem_id);
		zen_redirect(zen_href_link('oem_sourcing.php', zen_get_all_get_params(array('action')) . '&oem_id=' . $oem_id));
	}
	zen_redirect(zen_href_link('oem_sourcing.php'));
	
}

function getOemsourcingInfo($oem_id=0, $where='1=1'){
	global $db;
	$orderby = '';
	if (empty($oem_id) || $oem_id == 0) {
		$orderby = ' order by oem_id desc';
	}else{
		$where .= ' and oem_id = ' . $oem_id;
	}
	$oem_sourcing_sql = "select * from " . TABLE_OEM_SOURCING . ' where ' . $where . $orderby;
	//echo $oem_sourcing_sql;
	$oem_sourcing_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $oem_sourcing_sql, $search_query_numrows);
	$oem_sourcing_query = $db->Execute($oem_sourcing_sql);
	//var_dump($oem_sourcing_query);
	$oem_sourcing_array = array();
	if ($oem_sourcing_query->RecordCount() > 0){
	  	while (!$oem_sourcing_query->EOF){
	  		$oem_sourcing_array[] = array('oem_id' => $oem_sourcing_query->fields['oem_id'],
	  									 'title_link'=>$oem_sourcing_query->fields['title_link'],
	  									 'detail_content' => $oem_sourcing_query->fields['detail_content'],
	  									 'original_attachment_name' => $oem_sourcing_query->fields['original_attachment_name'],
	  									 'attachment_name' => $oem_sourcing_query->fields['attachment_name'],
	  									 'attachment_link' => $oem_sourcing_query->fields['attachment_link'],
	  									 'customer_email' => $oem_sourcing_query->fields['customer_email'],
	  									 'customer_name' => $oem_sourcing_query->fields['customer_name'],
	  									 'date_added' => $oem_sourcing_query->fields['date_added'],
	  									 'languages_id' => $oem_sourcing_query->fields['languages_id'],
	  									 'oem_type' => $oem_sourcing_query->fields['oem_type'],
	  									 'status' => $oem_sourcing_query->fields['status'],
	  									 'admin_id' => $oem_sourcing_query->fields['admin_id'],
	  									 'admin_email' => $oem_sourcing_query->fields['admin_email'],
	  									 'admin_name' => $oem_sourcing_query->fields['admin_name'],
	  									 'modify_time' => $oem_sourcing_query->fields['modify_time'],
	  									 'content' => $oem_sourcing_query->fields['content'],
	  									 );
	  		$oem_sourcing_query->MoveNext();
  		}
	}
	$return_array = array('sql'=>$oem_sourcing_sql,'data'=>$oem_sourcing_array);
	return $return_array;
}
$oem_sourcing_function = getOemsourcingInfo(0, $where );
$oem_sourcing_array = $oem_sourcing_function['data'];
$oem_sourcing_sql = $oem_sourcing_function['sql'];
$oem_sourcing_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $oem_sourcing_sql, $search_query_numrows);
if (!isset($_GET['oem_id']) || (isset($_GET['oem_id']) && $_GET['oem_id'] == '')){
  	$oem_id = $oem_sourcing_array[0]['oem_id'];
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="includes/menu.js"></script>

<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
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
  	<td class="pageHeading"><div style="float:left;">找货/定做信息</div>

		<div style='float:right;font-size:12px;color:#000;text-align:right;style="width:150px;"'>
			<form action="oem_sourcing.php" method="get" name="searchForm">	
			状态：<select name='status' style="width:150px;">
					<option value="">所有</option>
					<option <?php echo isset($_GET['status'])&&$_GET['status']=='10' ? "selected='selected'" : ""; ?> value="10">未处理</option>
					<option <?php echo isset($_GET['status'])&&$_GET['status']=='20' ? "selected='selected'" : ""; ?> value="20">已处理</option>
				</select><br/><br/>
			<?php
				$langs = zen_get_languages();
				echo "语言：<select name='l' style='width:150px;'>";
				echo "<option value=''>所有</option>";
				foreach($langs as $lang) {
					echo "<option ".(isset($_GET['l'])&&$_GET['l']==$lang['id'] ? "selected='selected'" : "")." value=".$lang['id'].">".$lang['name']."</option>"; 
			    }
				echo "</select><br/><br/>";
			?>
				类型：<select name='t' style="width:150px;">
					<option value="">所有</option>
					<option <?php echo isset($_GET['t'])&&$_GET['t']=='10' ? "selected='selected'" : ""; ?> value="10">找货服务</option>
					<option <?php echo isset($_GET['t'])&&$_GET['t']=='20' ? "selected='selected'" : ""; ?> value="20">定做服务</option>
				</select><br/><br/>
				<input name="email" value="<?php echo $_GET['email']; ?>" placeholder="请输入客户邮箱" style="width:150px;"/><br/>
				<input type="submit" value="提交" />
			</form>
		</div>

  	</td>
</tr>
  <tr>
  	<td>
  	<?php 
	  if ($action != 'addnew'){
	?>
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:75%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	  	  <tr class="dataTableHeadingRow">
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:5%;text-align:center;">ID</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:20%;text-align:center;">客户邮箱</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:15%;text-align:center;">提交时间</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:20%; text-align:center;">产品名称/链接</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:5%; text-align:center;">站点</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%; text-align:center;">类型</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 5px; width:5%; text-align:center;">状态</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 5px; width:10%; text-align:right;">操作</td>
	  	  	  </tr>
	  	  	  <?php
	  	  	    for ($i = 0; $i < sizeof($oem_sourcing_array); $i++){
	  	  	  ?>
	  	  	  <?php if ($oem_id == $oem_sourcing_array[$i]['oem_id']){ ?>
	  	  	  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link('oem_sourcing.php', 'oem_id=' . $oem_sourcing_array[$i]['oem_id'].'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','oem_id'))); ?>'">
	  	  	  <?php } else { ?>
	  	  	  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link('oem_sourcing.php', 'oem_id=' . $oem_sourcing_array[$i]['oem_id'].'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','oem_id'))); ?>'">
	  	  	  <?php } ?>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_array[$i]['oem_id']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_array[$i]['customer_email']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_array[$i]['date_added']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_array[$i]['title_link']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo zen_get_language_name($oem_sourcing_array[$i]['languages_id']); ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php if($oem_sourcing_array[$i]['oem_type'] == 10){ echo '找货服务';}elseif ($oem_sourcing_array[$i]['oem_type'] == 20) {echo '订做服务';}else{echo '/';}; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo ($oem_sourcing_array[$i]['status'] == 10 ? '未处理' : '已处理' ); ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 5px;" align="right">
	  	  	  	<?php 
	  	  	  	  if ($oem_id == $oem_sourcing_array[$i]['oem_id']){
	  	  	  	  	echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
	  	  	  	  } else {
	  	  	  	  	echo '<a href="' . zen_href_link('oem_sourcing.php',  (isset($_GET['lang'])?'lang='.$_GET['lang'].'&':'').'page='.$_GET['page'] . '&oem_id=' . $oem_sourcing_array[$i]['oem_id'].'&'.zen_get_all_get_params(array('page','oem_id', 'action'))) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif') . '</a>';
	  	  	  	  }
	  	  	  	?>
	  	  	  	</td>
	  	  	  </tr>
	  	  	  <?php } ?>
			  	<td height="40" align="left" colspan="3"><?php echo $oem_sourcing_split->display_count($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS);?></td>
			    <td height="40" align="right" colspan="2"><?php echo $oem_sourcing_split->display_links($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], $split_page_action);?></td>
	  	  	</table>
	  	  </td>
	  	  <?php if ($oem_id != 0 || $oem_id != '') { ?>
	  	  <td style="width:25%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      <tr>
			  <?php if ($action != 'new'){ ?>
	  	      	<td class="infoBoxHeading" style="padding:5px 5px;"><?php echo '#ID: ' . $oem_id . '&nbsp;&nbsp;';?></td>
			  <?php } else { ?>
			    <td class="infoBoxHeading" style="padding:5px 5px;"><?php echo 'Add New One'; ?></td>
			  <?php } ?>
	  	      </tr>
	  	      <tr>
	  	      	<td class="infoBoxContent" style="padding:5px;">
	  	      	<?php 
	  	      	if ($oem_id != 0 || $oem_id != '') {
	  	      		$oem_sourcing_function_info = getOemsourcingInfo($oem_id);
	  	      		$oem_sourcing_info = $oem_sourcing_function_info['data'][0];
	  	      		$attachment_link = unserialize($oem_sourcing_info['attachment_link']);
	  	      		//var_dump($attachment_link);
	  	      	}
	  	      	?>
	  	      	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;width:30%;">客户姓名:</td>
	  	      	  	  <td><?php echo $oem_sourcing_info['customer_name']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">客户邮箱:</td>
	  	      	  	  <td><?php echo $oem_sourcing_info['customer_email']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">提交时间:</td>
	  	      	  	  <td><?php echo $oem_sourcing_info['date_added']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">站点:</td>
	  	      	  	  <td><?php echo zen_get_language_name($oem_sourcing_info['languages_id']); ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">类型:</td>
	  	      	  	  <td><?php if($oem_sourcing_info['oem_type'] == 10){echo '找货服务';}elseif($oem_sourcing_info['oem_type'] == 20) {echo '定做服务';} ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">产品名称/链接:</td>
	  	      	  	  <td><?php echo $oem_sourcing_info['title_link']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;" valign="top">详细信息:</td>
	  	      	  	  <td><?php echo $oem_sourcing_info['detail_content']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<?php if($attachment_link != '') { ?>
	  	      	  	<tr>
	  	      	  	  <td style="font-weight:bold;">下载附件:</td>
	  	      	  	  <td>
	  	      	  	  	  <?php	foreach ($attachment_link as $key => $value) { ?>
	  	      	  	  	  	<?php if(!empty($value[0])) { ?>
	  	      	  	  	  		<a href="<?php echo HTTP_SERVER . '/' . $value[0] ?>" download="附件<?php echo $key+1; ?>">附件<?php echo $key+1; ?>
	  	      	  	  	  		</a>
	  	      	  	  	  	<?php }} ?>
	  	      	  	  </td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<?php } ?>
	  	      	  	<?php if($oem_sourcing_info['status'] == 10) { ?>
	  	      	  	<tr class="content_textarea" style="display:none;">
	  	      	  		<td colspan="2">
	  	      	  		<form action="oem_sourcing.php?action=add_content" method="post" name="add_content" id="add_content">
	  	      	  			<input type="hidden" name="oem_id" value="<?php echo $oem_sourcing_info['oem_id'] ?>">
	  	      	  			<textarea name="content_info" id="content_info" cols="40" rows="10" maxlength="500" placeholder="请输入处理结果"></textarea><br/>
	  	      	  			<button type="button" id="check_content">提交</button>
							<button type="button" id="cancel_content">取消</button>
	  	      	  		</form>	  	      	  			
	  	      	  		</td>
	  	      	  	</tr>
	  	      	  	<tr><td><br/></td></tr>
	  	      	  	<tr>
	  	      	  	 <td colspan="2" align="center"><button class="show_content_textarea">已处理</button></td>
	  	      	  	</tr>
	  	      	  	<?php }elseif($oem_sourcing_info['status'] == 20) { ?>
	  	      	  		<tr>
		  	      	  	  	<td style="font-weight:bold;">处理人:</td>
		  	      	  	  	<td><?php echo $oem_sourcing_info['admin_name']; ?></td>
		  	      	  	</tr>
		  	      	  	<tr><td><br/></td></tr>
		  	      	  	<tr>
		  	      	  	  	<td style="font-weight:bold;">处理时间:</td>
		  	      	  	  	<td><?php echo $oem_sourcing_info['modify_time']; ?></td>
		  	      	  	</tr>
		  	      	  	<tr><td><br/></td></tr>
		  	      	  	<tr>
		  	      	  	  	<td style="font-weight:bold;">处理结果:</td>
		  	      	  	  	<td><?php echo $oem_sourcing_info['content']; ?></td>
		  	      	  	</tr>
		  	      	  	<tr><td><br/></td></tr>
	  	      	  	<?php } ?>
	  	      	  </table>
	  	      	
	  	      	</td>
	  	      </tr>
	  	  	</table>
	  	  </td>
	  	  <?php } ?>
	  	</tr>
	  </table>
	<?php
	  }
  	?>
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