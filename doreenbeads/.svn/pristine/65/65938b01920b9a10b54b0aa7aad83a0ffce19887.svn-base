<?php

//  add by liu jian fang
require('includes/application_top.php');

$languages = zen_get_languages();
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
    if ($.trim($('#title').val()) == '') {alert('请输入站内信类型名称！');return false;};
    if (!($("input[name='type_status']:checked").val())) {alert('请设置开启或禁用状态！');return false;};
    var text_str = '';
    $("input[class='jq_title']").each(function(){
        //arr.push(this.value); 
         text_str += $(this).val();
    }); 
    if ($.trim(text_str) == '') {alert('请至少填写一个站内信类型名称(用于前台展示)！');return false;};
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
  .buttondiv{width: 100%;margin-left: 150px;margin-top: 30px;}
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
    <?php   if ( isset($_GET['action'])) { ?>
        <?php 
        if($_GET['action']=='create'){
            if (isset($_GET['auto_id']) && $_GET['auto_id'] != '') {
                $auto_id = $_GET['auto_id'];
                $copy = $_GET['copy'];
                $ann_query_sql = "select * from ".TABLE_MESSAGE_TYPE." where auto_id = ".$auto_id .' limit 1';
                $ann_sql_result = $db->Execute($ann_query_sql);
                if (!$ann_sql_result->EOF) { 
                    $ann_result = ($ann_sql_result -> fields);
                }
                $ann_desc_sql = "select * from ". TABLE_MESSAGE_TYPE_DESCRIPTION ." where type_id = ".$auto_id;
                $ann_desc_result = $db->Execute($ann_desc_sql);
                while (!$ann_desc_result->EOF) {
                    $ann_desc[$ann_desc_result -> fields['languages_id']] = $ann_desc_result -> fields;
                    $ann_desc_result->MoveNext();
                }
            }
            ?>
            <?php if (trim($auto_id) != '' && empty($copy)) { ?>
                <h1 style="margin-left:20px;height:50px;">编辑站内信类型</h1>
                <form  action="<?php echo zen_href_link(FILENAME_MESSAGE_TYPE,'action=save')?>" method="post" id="save_form">
                <input type="hidden" name="auto_id" value="<?php echo $auto_id ?>" />
                <input type="hidden" name="update" value="1">
            <?php }else{ ?>
                <h1 style="margin-left:20px;height:50px;">新建站内信类型</h1>
                <form  action="<?php echo zen_href_link(FILENAME_MESSAGE_TYPE,'action=save')?>" method="post" id="save_form">
            <?php } ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table_desc">                
                <tr>
                    <th valign="top"><font color='red'>*</font>站内信类型名称：</th>
                    <td valign="top"><input type="text" name="title" placeholder="请输入站内信类型名称" id="title" value="<?php echo $ann_result['title'] ?>"<?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> /><br/></td>
                </tr>
                <tr>
                    <th valign="top"><font color='red'>*</font>启用/禁用：</th>
                    <td valign="top">
                        <label><input name="type_status" type="radio" value="10" class="an_status" <?php echo (isset($ann_result['type_status']) && $ann_result['type_status'] == 10 || !isset($ann_result['type_status']) || !empty($copy))? 'checked': '' ?><?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> />启用</label>
                        <label><input name="type_status" type="radio" value="20" class="an_status" <?php echo (isset($ann_result['type_status']) && $ann_result['type_status'] == 20 && empty($copy))? 'checked': '' ?><?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> />禁用</label>
                    </td>
                </tr>
                <tr>
                    <th valign="middle">站内信类型名称：</th>
					<td class="info_column_content" valign="top"> 
						<?php foreach($languages as $languages_key => $languages_value) {?>
						<?php echo $languages_value['chinese_name'];?>名称：<input class="jq_title" name="title_<?php echo $languages_value['id'];?>" type="text" value="<?php if(isset($ann_desc[$languages_value['id']])) {echo $ann_desc[$languages_value['id']]['title'];}?>" maxlength="100"<?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> /> 用于前台展示<br/>
						<?php }?>
					</td>
                </tr>
                <?php if($ann_result['type_status'] == 20 && !empty($ann_result['admin_name_forbidden']) && empty($copy)) {?>
                <tr>
                    <th valign="middle">禁用人：</th>
					<td valign="middle">
						<?php echo $ann_result['admin_name_forbidden'];?>
					</td>
                </tr>
                <tr>
                    <th valign="middle">禁用时间：</th>
					<td valign="middle">
						<?php echo $ann_result['date_forbidden'];?>
					</td>
                </tr>
                <?php }?>
            </table>
            </form>
            <div class="buttondiv">
                <?php if (empty($auto_id) || !empty($copy)){ ?>
                <button id="submitbtn" style="cursor: pointer;" onclick="submitForm();return false;">提交</button>&nbsp;&nbsp;
                <?php }?>
                
                <?php if (!empty($auto_id) && empty($copy)){ ?>
                <?php if($ann_result['type_status'] == 10) {?>
                <button id="submitbtn" style="cursor: pointer;" onclick="javascript:if(confirm('是否禁用此站内信类型，禁用后不能再用此类型新建站内信?')) {window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action')) . "action=type_status&type_status=20");?>';}">禁用</button>&nbsp;&nbsp;
                <?php } else {?>
                <button id="submitbtn" style="cursor: pointer;" onclick="javascript:if(confirm('确认启用吗?')) {window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action')) . "action=type_status&type_status=10");?>';}">启用</button>&nbsp;&nbsp;
                <?php }?>
                	<?php if(empty($copy)) {?>
                	<button id="submitbtn" style="cursor: pointer;" onclick="javascript:window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action', 'copy')) . "action=create&copy=1&auto_id=" . $auto_id);?>';">复制并新建</button>&nbsp;&nbsp;
                	<?php }?>
                <?php }?>
                
                <button id="canbutton" onclick="window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action', 'auto_id')));?>';" style="cursor: pointer;">返回</button>
            </div>
        <?php  }else{  ?>
            <?php 
            if($_GET['action'] == 'type_status' && is_numeric($_GET['type_status'])) {
            	$type_status = zen_db_prepare_input($_GET['type_status']) == "10" ? "10" : "20";
            	$db->Execute("update ".TABLE_MESSAGE_TYPE." set type_status='".$type_status."', admin_name_forbidden='" . $_SESSION['admin_name'] . "', date_forbidden=now() where auto_id=".$_GET['auto_id']);
            	$messageStack->add_session('设置成功!', 'success');
            	zen_redirect(zen_href_link(FILENAME_MESSAGE_TYPE,zen_get_all_get_params(array('action', 'type_status', 'auto_id'))));
            }
            if($_GET['action'] == 'save'){
                $title = trim(zen_db_prepare_input($_POST['title']));
                $type_status = zen_db_prepare_input($_POST['type_status']);
                if (empty($title) || empty($type_status)) {
                	$messageStack->add_session('带*号的为必填项!', 'error');
                    zen_redirect(zen_href_link(FILENAME_MESSAGE_TYPE,zen_get_all_get_params(array('action', 'auto_id'))));
                }
                $update = zen_db_prepare_input($_POST['update']);
                if ($update) {
                    $db->Execute("update ".TABLE_ANNOUNCEMENT." set an_name='".$an_name."',an_starttime='".$start_time."',an_endtime='".$end_time."',an_last_modify_time='".date('Y-m-d H:i:s',time())."',an_status=".(int)$status.",an_language= '".$lang_name."' where auto_id=".$_POST['auto_id']);
                    foreach ($an_text as $lang_id => $text) {
                        $lang_code = trim(substr(strstr($lang_id,"_"),1));
                        $lid = trim(substr($lang_id,0,1));
                        
                        if ($text != '' || $an_mobile_text[$lang_id] != '') {
                            $save_desc_array = array(
                                'auto_id' => $_POST['auto_id'] ,
                                'an_language' => $lid,
                                'an_language_name' => $lang_code,
                                'an_content' => addslashes($text),
                            	'an_mobile_content' => addslashes($an_mobile_text[$lang_id]),
                                'create_time' => date('Y-m-d H:i:s',time()),
                                'modify_time' => date('Y-m-d H:i:s',time()),
                                'admin_id' => $_SESSION['admin_id'],
                                'admin_email' => $admin_email
                                );
                            
                            $sql_str = "select * from ".TABLE_ANNOUNCEMENT_DESCRIPTION." where an_language = ".$lid." and auto_id=".$_POST['auto_id'];
                            if($db->Execute($sql_str)->RecordCount() > 0){
                                $db->Execute("update ".TABLE_ANNOUNCEMENT_DESCRIPTION." set an_language=".$lid.",an_language_name='".$lang_code."',an_content='".addslashes($text)."', an_mobile_content='" . addslashes($an_mobile_text[$lang_id]) . "', modify_time='".date('Y-m-d H:i:s',time())."',admin_id='".$_SESSION['admin_id']."',admin_email='".$admin_email."' where auto_id=".$_POST['auto_id'] ." and an_language= ".$lid);
                            }else{
                                zen_db_perform(TABLE_ANNOUNCEMENT_DESCRIPTION, $save_desc_array);
                            }
                            
                            //echo "update ".TABLE_ANNOUNCEMENT_DESCRIPTION." set an_language=".$lid.",an_language_name='".$lang_code."',an_content='".$text."' where auto_id=".$_POST['auto_id'] ." and an_language= ".$lid;exit();
                        }else{
                            $sql_str = "select * from ".TABLE_ANNOUNCEMENT_DESCRIPTION." where an_language = ".$lid." and auto_id=".$_POST['auto_id'];
                            if($db->Execute($sql_str)->RecordCount() > 0){
                                $db->Execute("delete from ".TABLE_ANNOUNCEMENT_DESCRIPTION." where auto_id=".$_POST['auto_id']." and an_language = ".$lid);
                            }
                        }
                    }
                }else{
                    $save_sql_array = array(
                              'title' => $title,
                              'type_status' => $type_status,
                              'admin_name' => $_SESSION['admin_name'],
                              'date_created' => date('Y-m-d H:i:s',time()),                              );
                    zen_db_perform(TABLE_MESSAGE_TYPE, $save_sql_array);
                    $auto_id = zen_db_insert_id();
                    foreach ($languages as $languages_key => $languages_value) {
                    	$title_desc = zen_db_prepare_input($_POST['title_' . $languages_value['id']]);
                        if (!empty($title_desc)) {
                            $save_desc_array = array(
                                'type_id' => $auto_id ,
                                'languages_id' => $languages_value['id'],
                                'title' => $title_desc
                                );
                            zen_db_perform(TABLE_MESSAGE_TYPE_DESCRIPTION, $save_desc_array);
                        }
                    }
                }
                
                zen_redirect(zen_href_link(FILENAME_MESSAGE_TYPE,zen_get_all_get_params(array('action', 'copy', 'auto_id'))));                
            }
            ?>
        <?php  } ?>
    
    <!-- 正常显示首页 -->
    <?php }else{ ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="normal_table">
        <tr>
          <td class="pageHeading" style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;站内信类型</td>
          <td align="right" height="100px;" style="text-align:right;" >
            <form action="<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action', 'auto_id', 'keywords')));?>" method="get" name="searchForm" id="searchForm">
              站内信类型状态：<select name="type_status">
              	<option value=""<?php if(empty($_GET['type_status'])) {echo " selected='selected'";} ?>>所有</option>
              	<option value="10"<?php if($_GET['type_status'] == "10") {echo " selected='selected'";}?>>启用</option>
              	<option value="20"<?php if($_GET['type_status'] == "20") {echo " selected='selected'";}?>>禁用</option>
              </select><br/><br/>
             关键字：<input name="keywords" value="<?php echo $_GET['keywords']; ?>" placeholder="站内信类型名称关键字" id="searchCondition" />
             <br/><br/><input type="submit" value="搜索" />
            </form><br/>
        </td>
        </tr>
    </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">              
                <td class="dataTableHeadingContent" width="10%" align="center">ID</td>
                <td class="dataTableHeadingContent" width="25%" align="left">名称</td>
                <td class="dataTableHeadingContent" width="15%" align="left">创建人</td>
                <td class="dataTableHeadingContent" width="25%" align="left">创建时间</td>
                <td class="dataTableHeadingContent" width="15%" align="center">状态</td>
                <td class="dataTableHeadingContent" width="10%" align="left">操作</td>
              </tr>
              <?php

              if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS_REPORTS - MAX_DISPLAY_SEARCH_RESULTS_REPORTS;
              $rows = 0;
              $where = ' where 1=1';
              if(isset($_GET['type_status']) && is_numeric($_GET['type_status'])){
                $type_status = zen_db_input(zen_db_prepare_input($_GET['type_status']));
                $where .= " and type_status=" . $type_status;
              }
              if(isset($_GET['keywords']) && trim($_GET['keywords']) != ''){
                $keywords = zen_db_input(zen_db_prepare_input($_GET['keywords']));
                $where .= " and title like '%".$keywords."%'";
              }
              /*$suggestion_query_raw = 'select a.auto_id, a.an_name,a.an_starttime,a.an_endtime,a.an_status,ad.an_language_name,ad.an_text from '.TABLE_ANNOUNCEMENT.' a, '.TABLE_ANNOUNCEMENT_DESCRIPTION.' ad '.$where.' order by suggestion_id DESC';*/
              $announecement_query_raw = "select * from ".TABLE_MESSAGE_TYPE . $where." order by auto_id DESC";
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
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['title']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['admin_name']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['date_created']; ?></td>
                    <td class="dataTableContent" align="center"><?php echo ($announcement->fields['type_status'] == 10) ? '启用' : '禁用'; ?></td>
                    <td class="dataTableContent" align="left">
                    <a href="<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action', 'copy', 'auto_id')) . 'action=create&auto_id=' . $announcement->fields['auto_id']);?>"><?php echo zen_image(DIR_WS_IMAGES . 'icon_info.gif', ICON_INFO);?></a>
                    </td>
                  </tr>
                  <?php
                  $announcement->MoveNext();
                }
              }
              ?>
              <tr><td colspan="6" align="right"><a href="<?php echo zen_href_link(FILENAME_MESSAGE_TYPE, zen_get_all_get_params(array('action')) . 'action=create', 'NONSSL');?>"><button>新建站内信类型</button></a></td></tr>
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
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
