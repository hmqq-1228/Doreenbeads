<?php

//  add by liu jian fang
require('includes/application_top.php');

$languages = zen_get_languages();
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
    if ($.trim($('#type_id').val()) == '') {alert('请选择站内信类型！');return false;};
    if ($.trim($('#title').val()) == '') {alert('请输入站内信名称！');return false;};
    if ($.trim($('#message_expire_days').val()) == '') {alert('请设置站内信的有效期！');return false;}
    if ($.trim($('#message_expire_days').val()) <= 0) {alert('站内信有效期必须大于0！');return false;}
    if ($.trim($('#message_expire_days').val()) > 9999) {alert('站内信有效期不能大于9999！');return false;}
    if (!($("input[name='list_status']:checked").val())) {alert('请设置开启或禁用状态！');return false;};
    var text_str = '';
    $("input[class='jq_title']").each(function(){
        //arr.push(this.value); 
         text_str += $(this).val();
    }); 
    if ($.trim(text_str) == '') {alert('请至少填写一个站内信标题(用于前台展示)！');return false;};
    for(var index = 1; index <= <?php echo count($languages);?>; index++) {
    	if($.trim($("#title_" + index).val()) != "" && ($.trim($("#description_web_" + index).val()) == "" || $.trim($("#description_mobile_" + index).val()) == "")) {
    		alert("填写了" + $("#title_" + index).data("tip") + "标题必须填写对应语种内容!");
    		return false;
    	}
    	if($.trim($("#description_web_" + index).val()) != "" && ($.trim($("#title_" + index).val()) == "" || $.trim($("#description_mobile_" + index).val()) == "")) {
    		alert("填写了" + $("#description_web_" + index).data("tip") + "内容必须填写对应语种标题或内容!");
    		return false;
    	}
    	if($.trim($("#description_mobile_" + index).val()) != "" && ($.trim($("#description_web_" + index).val()) == "" || $.trim($("#title_" + index).val()) == "")) {
    		alert("填写了" + $("#description_mobile_" + index).data("tip") + "内容必须填写对应语种标题或内容!");
    		return false;
    	}
    }
    $("#save_form").submit();
}

$(document).ready(function(){
    $(".language_title").click(function(){
      	var lang = $(this).attr("language");
      	$("#languages_id_web").val($(this).data("id"));
      	$(this).siblings().removeClass("checked");
    	$(this).addClass("checked");
    	$('#'+lang+'_textarea').css("display","block").siblings(".index_area").css("display","none");
    	
    });
    $(".language_mobile_title").click(function(){
      	var lang = $(this).attr("language");
      	$("#languages_id_mobile").val($(this).data("id"));
      	$(this).siblings().removeClass("checked");
    	$(this).addClass("checked");
    	$('#'+lang+'_mobile_textarea').css("display","block").siblings(".mobile_index_area").css("display","none");
    	
    });
    
    $(".jq_preview_web").click(function() {
    	var id = $("#languages_id_web").val();
    	$("#message_description").val($("#description_web_" + id).val());
    	document.form_preview.action = "<?php echo HTTP_SERVER;?>/index.php?main_page=message_info";
    	document.form_preview.submit();
    });
    
    $(".jq_preview_mobile").click(function() {
    	var id = $("#languages_id_mobile").val();
    	$("#message_description").val($("#description_mobile_" + id).val());
    	document.form_preview.action = "<?php echo HTTP_MOBILESITE_SERVER;?>/index.php?main_page=message_info";
    	document.form_preview.submit();
    });
});
</script>
<style>
  .table_info{font-size:12px; font-family: Arial;width: 80%} 
  .table_info tr{text-align: left;vertical-align: top;margin-bottom: 10px;line-height: 20px;}
  .table_info tr th{width:180px;}
  .table_info tr td br{}

  .table_desc{margin-left:30px;font-size: 12px; width:70%;}
  .table_desc tr{height:50px;}
  .table_desc tr th{width:160px;text-align: left;}
  .buttondiv{width: 100%;margin-left: 150px;margin-top: 30px;}
  .buttondiv button{width:100px;}
  textarea{width:600px;}

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
  .language_title , .language_mobile_title{
	display: inline-block;
    border: 1px solid #D0CCCC;
    width: 64px;
    text-align: center;
    vertical-align: middle;
    line-height: 25px;
    cursor: pointer;
    position: relative;
    background: white;
    top: 1px;
 }
 .checked{
 	border-bottom:0px;
 	font-weight:bold;
 	background:gray;
 }
 .preview{color:#2E5887; cursor:pointer;}
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
                $ann_query_sql = "select * from ".TABLE_MESSAGE_LIST." where auto_id = ".$auto_id .' limit 1';
                $ann_sql_result = $db->Execute($ann_query_sql);
                if (!$ann_sql_result->EOF) { 
                    $ann_result = ($ann_sql_result -> fields);
                }
               
                
                $ann_desc_sql = "select * from ". TABLE_MESSAGE_LIST_DESCRIPTION ." where list_id = ".$auto_id;
                $ann_desc_result = $db->Execute($ann_desc_sql);
                while (!$ann_desc_result->EOF) {
                    $ann_desc[$ann_desc_result ->fields['languages_id']][$ann_desc_result ->fields['is_mobile']] = $ann_desc_result -> fields;
                    $ann_desc_result->MoveNext();
                }
            }
            ?>
            <?php if (trim($auto_id) && empty($copy) != '') { ?>
                <h1 style="margin-left:20px;height:50px;">编辑站内信</h1>
                <form  action="<?php echo zen_href_link(FILENAME_MESSAGE_LIST,'action=save')?>" method="post" id="save_form">
                <input type="hidden" name="auto_id" value="<?php echo $auto_id ?>" />
                <input type="hidden" name="update" value="1">
            <?php }else{ ?>
                <h1 style="margin-left:20px;height:50px;">新建站内信</h1>
                <form  action="<?php echo zen_href_link(FILENAME_MESSAGE_LIST,'action=save')?>" method="post" id="save_form">
            <?php } ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table_desc">                
                <tr>
                    <th valign="top"><font color='red'>*</font>站内信类型：</th>
                    <td valign="top">
                    <select id="type_id" name="type_id" <?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?>>
                    	<option value="">请选择</option>
                    	<?php foreach($type_array as $type_value) {
                    		if($type_value['type_status'] != 10) {
                    			continue;
                    		}
                    	?>
                    	<option value="<?php echo $type_value['auto_id'];?>"<?php if(isset($ann_result['type_id']) && $type_value['auto_id'] == $ann_result['type_id']) {echo " selected='selected'";} ?>><?php echo $type_value['title'];?></option>
                    	<?php }?>
                    </select>
                    <br/></td>
                </tr>
                <tr>
                    <th valign="top"><font color='red'>*</font>站内信名称：</th>
                    <td valign="top"><input type="text" name="title" placeholder="请输入站内信名称" id="title" value="<?php echo $ann_result['title'] ?>" maxlength="100" <?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> /><br/></td>
                </tr>
                <tr>
                    <th valign="top"><font color='red'>*</font>启用/禁用：</th>
                    <td valign="top">
                        <label><input name="list_status" type="radio" value="10" class="an_status" <?php echo ((isset($ann_result['list_status']) && $ann_result['list_status'] == 10) || !isset($ann_result['list_status']) || !empty($copy))? 'checked': '' ?><?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> />启用</label>
                        <label><input name="list_status" type="radio" value="20" class="an_status" <?php echo (isset($ann_result['list_status']) && $ann_result['list_status'] == 20  && empty($copy))? 'checked': '' ?><?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> />禁用</label>
                    </td>
                </tr>
                <tr>
                    <th valign="middle"><font color='red'>*</font>站内信标题：</th>
					<td class="info_column_content" valign="top"> 
						<?php foreach($languages as $languages_key => $languages_value) {?>
						<?php echo $languages_value['chinese_name'];?>标题：<input class="jq_title" id="title_<?php echo $languages_value['id'];?>" name="title_<?php echo $languages_value['id'];?>" data-tip="<?php echo $languages_value['chinese_name'];?>" type="text" value="<?php if(isset($ann_desc[$languages_value['id']])) {echo $ann_desc[$languages_value['id']][0]['title'];}?>" maxlength="100"<?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> /> 用于前台展示<br/>
						<?php }?>
					</td>
                </tr>
                <tr>
                    <th valign="middle"><font color='red'>*</font>站内信有效期：</th>
					<td> 
						<input type="text" id="message_expire_days" name="message_expire_days" style="width:50px;" onkeyup="value=value.replace(/[^\d\.]/g,'');" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d\.]/g,''));" value="<?php if(isset($ann_result['message_expire_days'])) {echo $ann_result['message_expire_days'];}?>" <?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?> /> 天
					</td>
                </tr>
                <tr height="30"><td colspan="2"></td></tr>
                <tr>
                    <th valign="top">网页端站内信内容：</th>
					<td class="info_column_content" > 
						<div class="index_area">
							<div class="index_language"> 
								<?php foreach ($languages as $key => $value) {?>
								<div class="language_title<?php if($key == 0) {?> checked<?php }?>" language="<?php echo $value['code'];?>" data-id="<?php echo $value['id'];?>"><?php echo $value['chinese_name'];?></div>
								<?php }?>
								
								<?php 
								$i = 0;
								foreach ($languages as $key => $value) {
									$lang_id = $value['id'];
									if($i == 0){
										echo '<div style="display: block;" id="' . $value['code'] . '_textarea" class="index_area">' ;
									}else{
										echo '<div style="display: none;" id="' . $value['code'] . '_textarea" class="index_area">';
									}
								?>
									<textarea rows="14" style="width:100%;" data-lang-name="<?php echo $value['name']?>"  class="description_web" id = "description_web_<?php echo $lang_id?>" name = "description_web_<?php echo $lang_id?>" data-tip="网页端<?php echo $value['chinese_name'];?>" data-id="<?php echo $lang_id;?>"<?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?>><?php if ($ann_desc[$lang_id][0]) {echo stripslashes($ann_desc[$lang_id][0]['description']);} ?></textarea></div> 
								
								<?php
								$i++;
								}?> 
								<span class="preview jq_preview_web">预览页面效果</span>
							</div>
						</div>  
					</td>
                </tr>
                <tr height="30"><td colspan="2"></td></tr>
                <tr>
                    <th valign="top">手机端站内信内容：</th>
					<td class="info_column_content" > 
						<div class="index_area">
							<div class="index_language"> 
								<?php foreach ($languages as $key => $value) {?>
								<div class="language_mobile_title<?php if($key == 0) {?> checked<?php }?>" language="<?php echo $value['code'];?>" data-id="<?php echo $value['id'];?>"><?php echo $value['chinese_name'];?></div>
								<?php }?>
								<?php 
								$i = 0;
								foreach ($languages as $key => $value) {
									$lang_id = $languages[$i]['id'];
								
									if($i == 0){
										echo '<div style="display: block;" id="' . $value['code'] . '_mobile_textarea" class="mobile_index_area">' ;
									}else{
										echo '<div style="display: none;" id="' . $value['code'] . '_mobile_textarea" class="mobile_index_area">';
									}
								?>
									<textarea rows="14" style="width:100%;" data-lang-name="<?php echo $value['name']?>"  class="description_mobile" id="description_mobile_<?php echo $lang_id?>" name = "description_mobile_<?php echo $lang_id?>" data-tip="手机端<?php echo $value['chinese_name'];?>" data-id="<?php echo $lang_id;?>"<?php if (!empty($auto_id) && empty($copy)) {?> disabled="disabled"<?php }?>><?php if ($ann_desc[$lang_id][0]) {echo stripslashes($ann_desc[$lang_id][1]['description']);} ?></textarea></div> 
								
								<?php
								$i++;
								}?>  
								<span class="preview jq_preview_mobile">预览页面效果</span>
							</div>
						</div>  
					</td>
                </tr>
                <?php if($ann_result['list_status'] == 20 && !empty($ann_result['admin_name_forbidden']) && empty($copy)) {?>
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
                <button id="submitbtn" style="cursor: pointer;" onclick="submitForm();return false;">提交</button>
                <?php }?>
                
                <?php if (!empty($auto_id)){ ?>
                <?php if($ann_result['list_status'] == 10) {?>
                <button id="submitbtn" style="cursor: pointer;" onclick="javascript:if(confirm('是否禁用此站内信模板，禁用后不能再用此模版发送通知?')) {window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action')) . "action=list_status&list_status=20");?>';}">禁用</button>
                
                <?php }?>
                	<?php if(empty($copy)) {?>
                	&nbsp;&nbsp;<button id="submitbtn" style="cursor: pointer;" onclick="javascript:window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action')) . "action=create&copy=1&auto_id=" . $auto_id);?>';">复制并新建</button>
                	<?php }?>
                <?php }?>
                
                &nbsp;&nbsp;<button id="canbutton" onclick="window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'auto_id')));?>';" style="cursor: pointer;">返回</button>
            </div>
        <?php  }else{  ?>
            <?php 
            if($_GET['action'] == 'list_status' && is_numeric($_GET['list_status'])) {
            	$list_status = zen_db_prepare_input($_GET['list_status']) == "10" ? "10" : "20";
            	$db->Execute("update ".TABLE_MESSAGE_LIST." set list_status='".$list_status."', admin_name_forbidden='" . $_SESSION['admin_name'] . "', date_forbidden=now() where auto_id=".$_GET['auto_id']);
            	$messageStack->add_session('设置成功!', 'success');
            	zen_redirect(zen_href_link(FILENAME_MESSAGE_LIST,zen_get_all_get_params(array('action', 'list_status', 'auto_id'))));
            }
            if($_GET['action'] == 'save'){
            	$type_id = intval(zen_db_prepare_input($_POST['type_id']));
                $title = trim(zen_db_prepare_input($_POST['title']));
                $message_expire_days = trim(zen_db_prepare_input($_POST['message_expire_days']));
                $list_status = zen_db_prepare_input($_POST['list_status']);
                if (empty($title) || empty($list_status) || empty($message_expire_days)) {
                	$messageStack->add_session('带*号的为必填项!', 'error');
                    zen_redirect(zen_href_link(FILENAME_MESSAGE_LIST,zen_get_all_get_params(array('action', 'auto_id'))));
                }
                if ($message_expire_days > 9999) {
                	$messageStack->add_session('站内信有效期不能大于9999!', 'error');
                    zen_redirect(zen_href_link(FILENAME_MESSAGE_LIST,zen_get_all_get_params(array('action', 'auto_id'))));
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
                              'type_id' => $type_id,
                              'title' => $title,
                              'list_status' => $list_status,
                              'message_expire_days' => $message_expire_days,
                              'admin_name' => $_SESSION['admin_name'],
                              'date_created' => date('Y-m-d H:i:s',time()),                              );
                    zen_db_perform(TABLE_MESSAGE_LIST, $save_sql_array);
                    $auto_id = zen_db_insert_id();
                    foreach ($languages as $languages_key => $languages_value) {
                    	$title_desc = zen_db_prepare_input($_POST['title_' . $languages_value['id']]);
                    	$description_web = zen_db_prepare_input($_POST['description_web_' . $languages_value['id']]);
                    	$description_mobile = zen_db_prepare_input($_POST['description_mobile_' . $languages_value['id']]);
                        if (!empty($title_desc) && !empty($description_web)) {
                            $save_desc_array = array(
                                'list_id' => $auto_id ,
                                'is_mobile' => 0,
                                'languages_id' => $languages_value['id'],
                                'title' => $title_desc,
                                'description' => $description_web
                                );
                            zen_db_perform(TABLE_MESSAGE_LIST_DESCRIPTION, $save_desc_array);
                        }
                        if (!empty($title_desc) && !empty($description_mobile)) {
                            $save_desc_array = array(
                                'list_id' => $auto_id ,
                                'is_mobile' => 1,
                                'languages_id' => $languages_value['id'],
                                'title' => $title_desc,
                                'description' => $description_mobile
                                );
                            zen_db_perform(TABLE_MESSAGE_LIST_DESCRIPTION, $save_desc_array);
                        }
                    }
                }
                $messageStack->add_session('添加成功!', 'success');
                zen_redirect(zen_href_link(FILENAME_MESSAGE_LIST,zen_get_all_get_params(array('action', 'copy', 'auto_id'))));                
            }
            ?>
        <?php  } ?>
    
    <!-- 正常显示首页 -->
    <?php }else{ ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="normal_table">
        <tr>
          <td class="pageHeading" style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;站内信设置</td>
          <td align="right" height="100px;" style="text-align:right;" >
            <form action="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'auto_id', 'keywords')));?>" method="get" name="searchForm" id="searchForm">
      <br/>站内信类型：<select name="type_id">
              	<option value=""<?php if(empty($_GET['type_id'])) {echo " selected='selected'";} ?>>所有</option>
              	<?php foreach($type_array as $type_value) {?>
            	<option value="<?php echo $type_value['auto_id'];?>"<?php if(isset($_GET['type_id']) && $_GET['type_id'] == $type_value['auto_id']) {echo " selected='selected'";} ?>><?php echo $type_value['title'];?></option>
            	<?php }?>
              </select><br/><br/>        
              站内信状态：<select name="list_status">
              	<option value=""<?php if(empty($_GET['list_status'])) {echo " selected='selected'";} ?>>所有</option>
              	<option value="10"<?php if($_GET['list_status'] == "10") {echo " selected='selected'";}?>>启用</option>
              	<option value="20"<?php if($_GET['list_status'] == "20") {echo " selected='selected'";}?>>禁用</option>
              </select><br/><br/>
             关键字：<input name="keywords" value="<?php echo $_GET['keywords']; ?>" placeholder="站内信名称关键字" id="keywords" />
             <br/><br/><input type="submit" value="搜索" />
            </form><br/><br/>
        </td>
        </tr>
    </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">              
                <td class="dataTableHeadingContent" width="10%" align="center">ID</td>
                <td class="dataTableHeadingContent" width="15%" align="left">名称</td>
                <td class="dataTableHeadingContent" width="15%" align="left">类型</td>
                <td class="dataTableHeadingContent" width="12%" align="left">有效期</td>
                <td class="dataTableHeadingContent" width="15%" align="left">创建人</td>
                <td class="dataTableHeadingContent" width="15%" align="left">创建时间</td>
                <td class="dataTableHeadingContent" width="10%" align="center">状态</td>
                <td class="dataTableHeadingContent" width="8%" align="left">操作</td>
              </tr>
              <?php

              if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS_REPORTS - MAX_DISPLAY_SEARCH_RESULTS_REPORTS;
              $rows = 0;
              $where = ' where 1=1';
              if(isset($_GET['list_status']) && is_numeric($_GET['list_status'])){
                $list_status = zen_db_input(zen_db_prepare_input($_GET['list_status']));
                $where .= " and ml.list_status=" . $list_status;
              }
              if(isset($_GET['type_id']) && is_numeric($_GET['type_id'])){
                $type_id = zen_db_input(zen_db_prepare_input($_GET['type_id']));
                $where .= " and mt.auto_id=" . $type_id;
              }
              if(isset($_GET['keywords']) && trim($_GET['keywords']) != ''){
                $keywords = zen_db_input(zen_db_prepare_input($_GET['keywords']));
                $where .= " and ml.title like '%".$keywords."%'";
              }
              /*$suggestion_query_raw = 'select a.auto_id, a.an_name,a.an_starttime,a.an_endtime,a.an_status,ad.an_language_name,ad.an_text from '.TABLE_ANNOUNCEMENT.' a, '.TABLE_ANNOUNCEMENT_DESCRIPTION.' ad '.$where.' order by suggestion_id DESC';*/
              $announecement_query_raw = "select ml.*, mt.title as title_type from " . TABLE_MESSAGE_LIST . " ml inner join  " . TABLE_MESSAGE_TYPE . " mt on mt.auto_id=ml.type_id" . $where." order by ml.auto_id DESC";
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
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['title_type']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['message_expire_days']; ?>天</td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['admin_name']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['date_created']; ?></td>
                    <td class="dataTableContent" align="center"><?php echo ($announcement->fields['list_status'] == 10) ? '启用' : '禁用'; ?></td>
                    <td class="dataTableContent" align="left">
                    <a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'copy', 'auto_id')) . 'action=create&auto_id=' . $announcement->fields['auto_id']);?>"><?php echo zen_image(DIR_WS_IMAGES . 'icon_info.gif', ICON_INFO);?></a>
                    </td>
                  </tr>
                  <?php
                  $announcement->MoveNext();
                }
              }
              ?>
              <tr><td colspan="8" align="right"><a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action')) . 'action=create', 'NONSSL');?>"><button>新建站内信</button></a></td></tr>
        </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText" valign="top"><?php echo $announcement_split->display_count($announecement_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> results)'); ?></td>
            <td class="smallText" align="left"><?php echo $announcement_split->display_links($announecement_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page'))); ?></td>
          </tr>
        </table>

    <?php }?>
    <form id="form_preview" name="form_preview" method="post" target="_blank" style="display:none;">
    	<input type="hidden" id="languages_id_web" value="1" />
    	<input type="hidden" id="languages_id_mobile" value="1" />
    	<input type="hidden" id="message_description" name="message_description" value="" />
    </from>
    <!-- body_text_eof //-->

    <!-- body_eof //-->

    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
