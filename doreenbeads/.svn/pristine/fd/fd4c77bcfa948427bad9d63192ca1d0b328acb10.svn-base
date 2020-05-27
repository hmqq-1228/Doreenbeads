<?php

//  add by liu jian fang
require('includes/application_top.php');
$type_sql = "select * from ". TABLE_MESSAGE_TYPE ." order by auto_id desc";
$type_result = $db->Execute($type_sql);
$type_array = array();
while (!$type_result->EOF) {
	$type_array[] = $type_result -> fields;
	$type_result->MoveNext();
}

?>
<?php if ($_GET['action'] != 'save') { ?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
  <title><?php echo TITLE; ?></title>
  <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS" />
    <script language="javascript" src="includes/menu.js"></script>
    <script language="javascript" src="includes/general.js"></script>
    <script language="javascript" src="includes/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
    <script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
    <script language="javascript" src="includes/javascript/My97DatePicker/WdatePicker.js"></script>
  <script type="text/javascript">
    function init()
    {
      cssjsmenu('navbar');
      if (document.getElementById)
      {
        var kill = document.getElementById('hoverJS');
        kill.disabled = true;
    }
}
function submitForm(){
    if ($.trim($('#type_id').children('option:selected').val()) == '') {alert('请选择站内信类型！');return false;};
    if ($.trim($('#list_id').children('option:selected').val()) == '') {alert('请选择站内信名称！');return false;};
    if (!($("input[name='target_customer']:checked").val())) {alert('请选择目标客户！');return false;};
    if($("input[name='target_customer']:checked").val() == "appoint" && $('#customers_id_excel').val() == "") {
    	alert('请上传指定客户的Excel文件！');return false;
    }
    $("#save_form").submit();
}

</script>
<style>
  .table_info{font-size:12px; font-family: Arial;width: 80%} 
  .table_info tr{text-align: left;vertical-align: top;margin-bottom: 10px;line-height: 20px;}
  .table_info tr th{width:180px;}
  .table_info tr td br{}

  .table_desc{margin-left:30px;font-size: 12px;}
  .table_desc tr{height:50px;}
  .table_desc tr th{width:160px;text-align: left;}
  .buttondiv{width: 300px;margin-left: 150px;margin-top: 30px;}
  .buttondiv button{width:100px;}

  .normal_table tr td{text-align: center;}
   .info_column_title{
 	padding-right:5px; 
 	width:100px;
 }
 
 .info_column_content{
 	padding-left:5px; 
 	line-height:30px;
 }
  .info_column_content input {width:380px;}
</style>
</head>
<body onLoad="init()">
  <!-- header //-->
  <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
  <!-- header_eof //-->

  <!-- body //-->
<?php } ?>
  <!-- body_text // -->
    <?php   if ( isset($_GET['action'])&&('action=='.$_GET['action'])) { ?>
        <?php 
        if($_GET['action']=='create'){
        	//$languages = zen_get_languages();
            //if (isset($_GET['auto_id']) && $_GET['auto_id'] != '') {
                $auto_id = $_GET['auto_id'];
                $type_array = $list_array = array();
                $type_sql = "select auto_id, title from ".TABLE_MESSAGE_TYPE." where type_status = 10 order by auto_id desc";
                $type_result = $db->Execute($type_sql);
                while (!$type_result->EOF) { 
                    array_push($type_array, $type_result->fields);
                    $type_result->MoveNext();
                }
                
                $list_sql = "select ml.auto_id, ml.type_id, ml.title from ".TABLE_MESSAGE_LIST." ml inner join ".TABLE_MESSAGE_TYPE." mt on mt.auto_id=ml.type_id where mt.type_status=10 and ml.list_status = 10 order by ml.auto_id desc";
                $list_result = $db->Execute($list_sql);
                $index = 0;
                while (!$list_result->EOF) { 
                   $list_array[$list_result->fields['type_id']][$index] = $list_result->fields;
                    $index++;
                    $list_result->MoveNext();
                }
                foreach($list_array as $list_key => $list_value) {
                	$list_array[$list_key] = array_values($list_value);
                }
                $list_json = json_encode($list_array);
            //}
            ?>
            <?php if (trim($auto_id) != '') { ?>
                <h1 style="margin-left:20px;height:50px;">编辑站内信类型</h1>
                <form enctype="multipart/form-data" action="<?php echo zen_href_link(FILENAME_MESSAGE_SEND,'action=save')?>" method="post" id="save_form">
                <input type="hidden" name="auto_id" value="<?php echo $auto_id ?>" />
                <input type="hidden" name="update" value="1">
            <?php }else{ ?>
                <h1 style="margin-left:20px;height:50px;">新建发送任务</h1>
                <form enctype="multipart/form-data" action="<?php echo zen_href_link(FILENAME_MESSAGE_SEND,'action=save')?>" method="post" id="save_form">
            <?php } ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table_desc">                
                <tr>
                    <th valign="top"><font color='red'>*</font>站内信类型：</th>
                    <td valign="top">
						<select id="type_id" name="type_id">
							<option value="">请选择</option>
							<?php foreach($type_array as $type_value) {?>
							<option value="<?php echo $type_value['auto_id'];?>">[ID:<?php echo $type_value['auto_id'];?>]<?php echo $type_value['title'];?></option>
							<?php }?>
						</select>
					</td>
                </tr>
                <tr>
                    <th valign="top"><font color='red'>*</font>站内信名称：</th>
                    <td valign="top">
						<select id="list_id" name="list_id">
							<option value="">请选择</option>
						</select>
					</td>
                </tr>
                <tr>
                    <th valign="top"><font color='red'>*</font>目标客户：</th>
                    <td valign="top">
                        <label><input name="target_customer" type="radio" value="appoint" class="an_status" checked="checked"<?php if (!empty($auto_id)) {?> disabled="disabled"<?php }?> />指定客户</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="customers_id_excel" name="customers_id_excel" />&nbsp;<a href="file/template_message_send.xlsx" taget="_blank">下载模版</a>
                        <br/><br/>
                        <label><input name="target_customer" type="radio" value="all" class="an_status" <?php echo (isset($ann_result['type_status']) && $ann_result['type_status'] == 20 )? 'checked': '' ?><?php if (!empty($auto_id)) {?> disabled="disabled"<?php }?> />所有客户</label>
                    </td>
                </tr>
            </table>
            </form>
            <div class="buttondiv">
                <?php if (empty($auto_id)){ ?>
                <button id="submitbtn" style="cursor: pointer;" onclick="submitForm();return false;">提交</button>
                <?php }?>
                
                <?php if (!empty($auto_id)){ ?>
                <?php if($ann_result['type_status'] == 10) {?>
                <button id="submitbtn" style="cursor: pointer;" onclick="javascript:if(confirm('确认禁用吗?')) {window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action')) . "action=type_status&type_status=20");?>';}">禁用</button>
                <?php } else {?>
                <button id="submitbtn" style="cursor: pointer;" onclick="javascript:if(confirm('确认启用吗?')) {window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action')) . "action=type_status&type_status=10");?>';}" href="<?php echo zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action')) . "action=type_status&type_status=10");?>">启用</button>
                <?php }?>
                
                <?php }?>
                
                &nbsp;&nbsp;<button id="canbutton" onclick="window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action', 'auto_id')));?>';" style="cursor: pointer;">返回</button>
            </div>
        <?php  }else{  ?>
            <?php 
            if($_GET['action'] == 'type_status' && is_numeric($_GET['type_status'])) {
            	$type_status = zen_db_prepare_input($_GET['type_status']) == "10" ? "10" : "20";
            	$db->Execute("update ".TABLE_MESSAGE_TYPE." set type_status='".$type_status."' where auto_id=".$_GET['auto_id']);
            	$messageStack->add_session('设置成功!', 'success');
            	zen_redirect(zen_href_link(FILENAME_MESSAGE_SEND,zen_get_all_get_params(array('action', 'auto_id'))));
            }
            if($_GET['action'] == 'save'){
                $type_id = trim(zen_db_prepare_input($_POST['type_id']));
                $list_id = trim(zen_db_prepare_input($_POST['list_id']));
                $target_customer = trim(zen_db_prepare_input($_POST['target_customer']));
                
                if($target_customer == "appoint") {
                	
                	$file = $_FILES['customers_id_excel'];
		  			$filename = basename($file['name']);
		  			$file_ext = substr($filename, strrpos($filename, '.') + 1);
	                if($file_ext!='xlsx'&&$file_ext!='xls'){
		  				$messageStack->add_session('文件格式有误，请上传xlsx','error');
		  				zen_redirect(zen_href_link(FILENAME_MESSAGE_SEND,zen_get_all_get_params(array('auto_id'))));
		  			}else{		
		  				$file_from = $file['tmp_name'];
		  				set_include_path('../Classes/'); 				
		  				include 'PHPExcel.php';
		  				if($file_ext=='xlsx'){
		  					 include 'PHPExcel/Reader/Excel2007.php';
		  					 $objReader = new PHPExcel_Reader_Excel2007;
		  				}else{
		  					include 'PHPExcel/Reader/Excel5.php';
		  					$objReader = new PHPExcel_Reader_Excel5;
		  				}
		  				$objPHPExcel = $objReader->load($file_from);
		  				$sheet = $objPHPExcel->getActiveSheet();
		  				$customers_id_array = array();
		  				for($j=2;$j<=$sheet->getHighestRow();$j++){
		  					$customers_id = intval($sheet->getCellByColumnAndRow(0,$j)->getValue());
		  					if(!in_array($customers_id, $customers_id_array)) {
		  						array_push($customers_id_array, $customers_id);
		  					}
		  				}
		  				if(!empty($customers_id_array)) {
		  					$customers_id_list = implode(",", $customers_id_array);
		  				
			  				$customers_array = array();
			                $customers_sql = "select customers_info_id from ".TABLE_CUSTOMERS_INFO." where customers_info_id in(" . $customers_id_list . ") and (customers_info_message_receive_type=:customers_info_message_receive_type1 or (customers_info_message_receive_type=:customers_info_message_receive_type2 and instr(customers_info_message_receive_appoint, :type_id) > 0))";
			                $customers_sql=$db->bindVars($customers_sql,':customers_info_message_receive_type1', 30,'integer');
			                $customers_sql=$db->bindVars($customers_sql,':customers_info_message_receive_type2', 20,'integer');
			                $customers_sql=$db->bindVars($customers_sql,':type_id', ',' . $type_id . ',','string');
			                $customers_result = $db->Execute($customers_sql);
			                $success_index = 0;
			                while (!$customers_result->EOF) { 
			                    $save_array = array(
			                    	'customers_id' => $customers_result->fields['customers_info_id'],
			                    	'type_id' => $type_id,
			                    	'list_id' => $list_id,
			                    	'admin_name' => $_SESSION['admin_name'],
			                    	'date_created' => 'now()'
			                    );
			                    zen_db_perform(TABLE_MESSAGE_TO_CUSTOMERS, $save_array);
			                    $success_index++;
			                    $customers_result->MoveNext();
			                }
			                $messageStack->add_session('发送站内信成功' . $success_index . '条!','success');
		  					zen_redirect(zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action', 'auto_id'))));
		  					
		  				} else {
		  					$messageStack->add_session('发送站内信成功0条!','error');
		  					zen_redirect(zen_href_link(FILENAME_MESSAGE_SEND,zen_get_all_get_params(array('auto_id'))));
		  				}
		  				
                
	                }
                } else if($target_customer == "all") {
                	$save_array = array(
                    	'type_id' => $type_id,
                    	'list_id' => $list_id,
                    	'admin_name' => $_SESSION['admin_name'],
                    	'date_created' => 'now()'
                    );
                    zen_db_perform(TABLE_MESSAGE_TO_CUSTOMERS_ALL, $save_array);
                    $messageStack->add_session('发送站内信给【所有客户】成功!','success');
		  			zen_redirect(zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action', 'auto_id'))));
                }
                exit;
            }
            ?>
        <?php  } ?>
    
    <!-- 正常显示首页 -->
    <?php }else{ 
      $where = ' where 1=1';
      if(isset($_GET['type_id']) && trim($_GET['type_id']) != ''){
	    $type_id = intval($_GET['type_id']);
	    $where .= " and mtc.type_id=" . $type_id;
	  }
	  if(isset($_GET['customers_id']) && trim($_GET['customers_id']) != ''){
	    $customers_id = intval($_GET['customers_id']);
	    $where .= " and mtc.customers_id=" . $customers_id;
	  }
	  if(isset($_GET['is_read']) && trim($_GET['is_read']) != ''){
	    $is_read = intval($_GET['is_read']);
	    $where .= " and mtc.is_read=" . $is_read;
	  }
	  if(isset($_GET['is_ignore']) && trim($_GET['is_ignore']) != ''){
	    $is_ignore = intval($_GET['is_ignore']);
	    $where .= " and mtc.is_ignore=" . $is_ignore;
	  }
	  if(isset($_GET['is_delete']) && trim($_GET['is_delete']) != ''){
	    $is_delete = intval($_GET['is_delete']);
	    $where .= " and mtc.is_delete=" . $is_delete;
	  }
	  if(isset($_GET['keywords']) && trim($_GET['keywords']) != ''){
	    $keywords = zen_db_input(zen_db_prepare_input($_GET['keywords']));
	    $where .= " and ml.title like '%".$keywords."%'";
	  }	
    ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="normal_table">
        <tr>
          <td class="pageHeading" style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;站内信发送记录</td>
          <td align="right" height="100px;" style="text-align:right;" >
            <form action="<?php echo zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action', 'auto_id', 'keywords')));?>" method="get" name="searchForm" id="searchForm">
            <br/>站内信类型：<select name="type_id">
              	<option value=""<?php if(empty($_GET['type_id'])) {echo " selected='selected'";} ?>>所有</option>
              	<?php foreach($type_array as $type_value) {?>
            	<option value="<?php echo $type_value['auto_id'];?>"<?php if(isset($_GET['type_id']) && $_GET['type_id'] == $type_value['auto_id']) {echo " selected='selected'";} ?>><?php echo $type_value['title'];?></option>
            	<?php }?>
              </select><br/><br/>
              是否已读：<select name="is_read">
              	<option value="">所有</option>
              	<option value="1"<?php if($is_read == "1") {echo "selected='selected'";}?>>已读</option>
              	<option value="0"<?php if($is_read == "0") {echo "selected='selected'";}?>>未读</option>
              </select><br/><br/>
              是否忽略：<select name="is_ignore">
              	<option value="">所有</option>
              	<option value="1"<?php if($is_ignore == "1") {echo "selected='selected'";}?>>已忽略</option>
              	<option value="0"<?php if($is_ignore == "0") {echo "selected='selected'";}?>>未忽略</option>
              </select><br/><br/>
              是否删除：<select name="is_delete">
              	<option value="">所有</option>
              	<option value="1"<?php if($is_delete == "1") {echo "selected='selected'";}?>>已删除</option>
              	<option value="0"<?php if($is_delete == "0") {echo "selected='selected'";}?>>未删除</option>
              </select><br/><br/>
             关键字：<input name="keywords" value="<?php echo $_GET['keywords']; ?>" placeholder="站内信名称关键字" id="keywords" /><br/><br/>
             客户ID：<input name="customers_id" value="<?php echo $_GET['customers_id']; ?>" placeholder="客户ID" id="customers_id" />
             <br/><br/><input type="submit" value="搜索" />
            </form><br/><br/>
        </td>
        </tr>
    </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">              
                <td class="dataTableHeadingContent" width="5%" align="center">ID</td>
                <td class="dataTableHeadingContent" width="11%" align="left">名称</td>
                <td class="dataTableHeadingContent" width="10%" align="left">类型</td>
                <td class="dataTableHeadingContent" width="5%" align="left">客户ID</td>
                <td class="dataTableHeadingContent" width="8%" align="left">发送人</td>
                <td class="dataTableHeadingContent" width="10%" align="left">发送时间</td>
                <td class="dataTableHeadingContent" width="6%" align="center">已读</td>
                <td class="dataTableHeadingContent" width="6%" align="center">已忽略</td>
                <td class="dataTableHeadingContent" width="7%" align="center">已删除</td>
                <td class="dataTableHeadingContent" width="8%" align="left">最后操作时间</td>
              </tr>
              <?php

              if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS_REPORTS - MAX_DISPLAY_SEARCH_RESULTS_REPORTS;
              $rows = 0;
              
              /*$suggestion_query_raw = 'select a.auto_id, a.an_name,a.an_starttime,a.an_endtime,a.an_status,ad.an_language_name,ad.an_text from '.TABLE_ANNOUNCEMENT.' a, '.TABLE_ANNOUNCEMENT_DESCRIPTION.' ad '.$where.' order by suggestion_id DESC';*/
              $announecement_query_raw = "select mtc.auto_id, mt.title title_type, ml.title title_list, mtc.customers_id, mtc.is_read, mtc.is_ignore, mtc.is_delete, mtc.admin_name, mtc.date_created, mtc.customers_last_operation_time from " . TABLE_MESSAGE_TO_CUSTOMERS . " mtc left join " . TABLE_MESSAGE_TYPE . " mt on mt.auto_id=mtc.type_id left join " . TABLE_MESSAGE_LIST . " ml on ml.auto_id=mtc.list_id" . $where . " order by mtc.auto_id desc";
              $announcement_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $announecement_query_raw, $announecement_query_numrows);
              $announcement = $db->Execute($announecement_query_raw);
              if ($announcement->EOF) { ?>
                <script type="text/javascript">
                  $('#noSearch').html('无搜索结果').show();
                </script>
              <?php }else{ 
                while (!$announcement->EOF) {

                  ?>
                  <tr class="dataTableRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)">                
                    <td class="dataTableContent" align="center"><?php echo $announcement->fields['auto_id']; ?></td>               
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['title_list']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['title_type']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['customers_id']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['admin_name']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['date_created']; ?></td>
                    <td class="dataTableContent" align="center"><?php echo ($announcement->fields['is_read'] == "1" ? "已读" : "未读");?></td>
                    <td class="dataTableContent" align="center"><?php echo ($announcement->fields['is_ignore'] == "1" ? "已忽略" : "未忽略");?></td>
                    <td class="dataTableContent" align="center"><?php echo ($announcement->fields['is_delete'] == "1" ? "已删除" : "未删除");?></td>
                    <td class="dataTableContent" align="left"><?php if(!empty($announcement->fields['customers_last_operation_time'])) {echo $announcement->fields['customers_last_operation_time'];} else {echo "/";}; ?></td>
                  </tr>
                  <?php
                  $announcement->MoveNext();
                }
              }
              ?>
              <tr><td colspan="10" align="right"><a href="<?php echo zen_href_link(FILENAME_MESSAGE_SEND, zen_get_all_get_params(array('action')) . 'action=create', 'NONSSL');?>"><button>新建发送任务</button></a></td></tr>
        </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText" valign="top"><?php echo $announcement_split->display_count($announecement_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> results)'); ?></td>
            <td class="smallText" align="left"><?php echo $announcement_split->display_links($announecement_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page'))); ?></td>
          </tr>
        </table>

    <?php }?>
    <!-- body_text_eof //-->

    <!-- body_eof //-->

    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php');?>
    <!-- footer_eof //-->
<script language="javascript">
<?php 
if(!empty($list_json)) {
?>

$("#type_id").change(
	function() {
		var list_json = <?php echo $list_json;?>;
		var id = $(this).val();
		$("#list_id").empty();
		$("#list_id")[0].options.add(new Option("请选择", ""));
		if(id == "") {
			return;
		}
		var data = list_json[id];
		var len = typeof(data) == "undefined" ? 0 : data.length;
		for(var i = 0; i < len; i++) {
			$("#list_id")[0].options.add(new Option("[ID:" + data[i].auto_id + "]" + data[i].title, data[i].auto_id));
		}		
	}
);
<?php 
}
?>
</script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
