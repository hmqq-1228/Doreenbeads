<?php

//  add by liu jian fang
require('includes/application_top.php');
?>
<?php ?>
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

function formSubmit(){
    $('#searchForm').submit();
}

$(document).ready(function(){
    //绑定图片日期控件
    $(".Wdate").css({ cursor: "pointer" });
    $(".Wdate").die("click").live("click", function () { 
        if($(this).prop('disabled') || $(this).prop('readonly'))
        {
             return false;
        }
        var options = { skin: $(this).attr("skin") || 'whyGreen' };
        if ($(this).attr("dateFmt")) {
            options.dateFmt = $(this).attr("dateFmt");
        }
        
        if ($(this).attr("min-date")) {
            options.minDate = $(this).attr("min-date");
        }
        if ($(this).attr("max-date")) {
            if ($(this).attr("no-limit-max-date") == 'true') {
                options.maxDate = $(this).attr("max-date");
            } else {
                options.maxDate = $(this).attr("max-date") || '%y-%M-%d';
            }
        }
        WdatePicker(options);
    });
});
function submitForm(){
    if ($.trim($('#an_name').val()) == '') {alert('请输入标语标题！');return false;};
    if ($.trim($('#pStartTime').val()) == '') {alert('请指定开始时间！');return false;};
    if ($.trim($('#pEndTime').val()) == '') {alert('请指定结束时间！');return false;};
    if (!($("input[name='status']:checked").val())) {alert('请设置开启或禁用状态！');return false;};
    var text_str = '';
    $("textarea[class='an_text']").each(function(){
        //arr.push(this.value); 
         text_str += $(this).val();
    }); 
    //var text_str = arr.join(" ");
    if ($.trim(text_str) == '') {alert('请至少填写一个语言的标语！');return false;};

    $("#save_form").submit();

}

function formSubmit(){
    $('#searchForm').submit();
}

$('#canbutton').live("click",function(){
    //return false;
    window.location.href = 'announcement.php';
});
  // -->
</script>
<style>
  .table_info{font-size:12px; font-family: Arial;width: 80%} 
  .table_info tr{text-align: left;vertical-align: top;margin-bottom: 10px;line-height: 20px;}
  .table_info tr th{width:180px;}
  .table_info tr td br{}

  .table_desc{margin-left:30px;font-size: 12px;}
  .table_desc tr{height:50px;}
  .table_desc tr th{width:100px;text-align: left;}
  .buttondiv{width: 300px;margin-left: 150px;}
  .buttondiv button{width:100px;}

  .normal_table tr td{text-align: center;}
</style>
</head>
<body onLoad="init()">
  <!-- header //-->
  <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
  <!-- header_eof //-->

  <!-- body //-->
  <!-- body_text // -->
    <?php   if ( isset($_GET['action'])&&('action=='.$_GET['action'])) { ?>
        <?php 
        if($_GET['action']=='create'){
            if (isset($_GET['anId']) && $_GET['anId'] != '') {
                $anid = $_GET['anId'];
                $ann_query_sql = "select an_name,an_starttime,an_endtime,an_status from ".TABLE_ANNOUNCEMENT." where an_id = ".$anid .' limit 1';
                $ann_sql_result = $db->Execute($ann_query_sql);
                if (!$ann_sql_result->EOF) { 
                    $ann_result = ($ann_sql_result -> fields);
                }
                $ann_desc_sql = "select an_content,an_language,an_language_name from ". TABLE_ANNOUNCEMENT_DESCRIPTION ." where an_id = ".$anid;
                $ann_desc_result = $db->Execute($ann_desc_sql);
                while (!$ann_desc_result->EOF) {
                    $ann_desc[$ann_desc_result -> fields['an_language_name']] = ($ann_desc_result -> fields);
                    $ann_desc_result->MoveNext();
                }
                //var_dump($ann_desc);
            }
            ?>
            <script language="javascript">
                var StartDate = new ctlSpiffyCalendarBox("StartDate", "promotion_form", "start", "btnDate1","<?php echo isset($pinfo->promotion_start_time)?substr($pinfo->promotion_start_time,0,10):''?>",scBTNMODE_CUSTOMBLUE);
                StartDate.minYearChoice=2013;
                StartDate.maxYearChoice=2041;
                var EndDate = new ctlSpiffyCalendarBox("EndDate", "promotion_form", "end", "btnDate2","<?php echo isset($pinfo->promotion_start_time)?substr($pinfo->promotion_end_time,0,10):''?>",scBTNMODE_CUSTOMBLUE);
                EndDate.minYearChoice=2013;
                EndDate.maxYearChoice=2041;
            </script>
            <?php if (trim($anid) != '') { ?>
                <h1 style="margin-left:20px;height:50px;">编辑标语</h1>
                <form  action="<?php echo zen_href_link(announcement,'action=save')?>" method="post" id="save_form">
                <input type="hidden" name="an_id" value="<?php echo $anid ?>" />
                <input type="hidden" name="update" value="1">
            <?php }else{ ?>
                <h1 style="margin-left:20px;height:50px;">新建标语</h1>
                <form  action="<?php echo zen_href_link(announcement,'action=save')?>" method="post" id="save_form">
            <?php } ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table_desc">                
                <tr>
                    <th valign="top">标语名称：</th>
                    <td valign="top"><input type="text" name="an_name" placeholder="请输入标语名" id="an_name" value="<?php echo $ann_result['an_name'] ?>"><br/></td>
                </tr>
                <tr>
                    <th valign="top">开始时间：</th>
                    <td valign="top">
                        <input class="Wdate" <?php echo $promotion_active_state == '活动'?'':''?> type="text" id="pStartTime" name="pStartTime" min-date ="%y-%M-%d" max-date ="#F{$dp.$D(\'pEndTime\')}" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $ann_result['an_starttime'];?>" />
                    </td>
                </tr>
                <tr>
                    <th valign="top">结束时间：</th>
                    <td valign="top">
                        <input class="Wdate" type="text" id="pEndTime" name="pEndTime"  min-date ="#F{$dp.$D(\'pStartTime\')||%y-%M-%d}" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $ann_result['an_endtime'];?>" />
                    </td>
                </tr>
                <tr>
                    <th valign="top">启用/禁用：</th>
                    <td valign="top">
                        <label><input name="status" type="radio" value="20" class="an_status" <?php echo (isset($ann_result['an_status']) && $ann_result['an_status'] == 20 )? 'checked': '' ?> checked />启用</label>
                        <label><input name="status" type="radio" value="10" class="an_status" <?php echo (isset($ann_result['an_status']) && $ann_result['an_status'] == 10 )? 'checked': '' ?> />禁用</label>
                    </td>
                </tr>
                <tr>
                    <th valign="top">标语内容：</th>
                    <td valign="top">
                        <?php $languages = zen_get_languages(); 
                            foreach ($languages as $key => $value) { ?>
                            <?php echo  $value['name'] ?>：<br/>
                            <textarea rows="10" cols="80" name="<?php echo $value['code'] ?>" class="an_text" ><?php if ($ann_desc[$value['code']]) {echo $ann_desc[$value['code']]['an_content'];} ?></textarea><br/><br/>
                        <?php } ?>
                    </td>
                </tr>
               <!--  <tr>
                   <th></th>
                   <td>
                       <button id="submitbtn" onclick="submitForm();return false;">提交</button>
                       <button id="canbutton">取消</button>
                   </td>
               </tr> -->
            </table>
            </form>
            <div class="buttondiv">
                <button id="submitbtn" onclick="submitForm();return false;">提交</button>
                <button id="canbutton">取消</button>
            </div>
        <?php  }else{  ?>
            <?php 
            if($_GET['action'] == 'save'){//var_dump($_POST);
                $an_name = trim($_POST['an_name']);
                $start_time = $_POST['pStartTime'];
                $end_time = $_POST['pEndTime'];
                $status = $_POST['status'];
                $update = $_POST['update'];
                $an_text = array();
                $language_name = array();
                $langs = zen_get_languages();
                foreach ($langs as $lang) {
                    $key = $lang['id'].'_'.$lang['code'];
                    $an_text[$key] = $_POST[$lang['code']];
                    if (trim($_POST[$lang['code']]) != '' ) {
                       $language_name[] = $lang['name'];
                    }
                }
                //var_dump($an_text);exit();
                //var_dump($language_name);
                $lang_name = implode(',', $language_name);
                $admin_email_sql = "select admin_email from ".TABLE_ADMIN." where admin_id = ". $_SESSION['admin_id'] ." limit 1";
                if($db->Execute($admin_email_sql)->RecordCount() > 0){
                    $admin_email = $db->Execute($admin_email_sql)->fields['admin_email'];
                }
                if ($update) {
                    /*$save_sql_array = array(
                              'an_name' => $an_name,
                              'an_starttime' => $start_time,
                              'an_endtime' => $end_time,
                              'an_last_modify_time' => date('Y-m-d H:i:s',time()),
                              'an_status' => (int)$status,
                              'an_language' => $lang_name
                              );*/
                    $db->Execute("update ".TABLE_ANNOUNCEMENT." set an_name='".$an_name."',an_starttime='".$start_time."',an_endtime='".$end_time."',an_last_modify_time='".date('Y-m-d H:i:s',time())."',an_status=".(int)$status.",an_language= '".$lang_name."' where an_id=".$_POST['an_id']);
                    foreach ($an_text as $lang_id => $text) {
                        $lang_code = trim(substr(strstr($lang_id,"_"),1));
                        $lid = trim(substr($lang_id,0,1));
                        if ($text != '') {
                            $save_desc_array = array(
                                'an_id' => $_POST['an_id'] ,
                                'an_language' => $lid,
                                'an_language_name' => $lang_code,
                                'an_content' => $text,
                                'create_time' => date('Y-m-d H:i:s',time()),
                                'modify_time' => date('Y-m-d H:i:s',time()),
                                'admin_id' => $_SESSION['admin_id'],
                                'admin_email' => $admin_email
                                );
                            $sql_str = "select * from ".TABLE_ANNOUNCEMENT_DESCRIPTION." where an_language = ".$lid." and an_id=".$_POST['an_id'];
                            if($db->Execute($sql_str)->RecordCount() > 0){
                                $db->Execute("update ".TABLE_ANNOUNCEMENT_DESCRIPTION." set an_language=".$lid.",an_language_name='".$lang_code."',an_content='".$text."',modify_time='".date('Y-m-d H:i:s',time())."',admin_id='".$_SESSION['admin_id']."',admin_email='".$admin_email."' where an_id=".$_POST['an_id'] ." and an_language= ".$lid);
                            }else{
                                zen_db_perform(TABLE_ANNOUNCEMENT_DESCRIPTION, $save_desc_array);
                            }
                            
                            //echo "update ".TABLE_ANNOUNCEMENT_DESCRIPTION." set an_language=".$lid.",an_language_name='".$lang_code."',an_content='".$text."' where an_id=".$_POST['an_id'] ." and an_language= ".$lid;exit();
                        }else{
                            $sql_str = "select * from ".TABLE_ANNOUNCEMENT_DESCRIPTION." where an_language = ".$lid." and an_id=".$_POST['an_id'];
                            if($db->Execute($sql_str)->RecordCount() > 0){
                                $db->Execute("delete from ".TABLE_ANNOUNCEMENT_DESCRIPTION." where an_id=".$_POST['an_id']." and an_language = ".$lid);
                            }
                        }
                    }
                }else{
                    $save_sql_array = array(
                              'an_name' => $an_name,
                              'an_starttime' => $start_time,
                              'an_endtime' => $end_time,
                              'an_create_time' => date('Y-m-d H:i:s',time()),
                              'an_last_modify_time' => date('Y-m-d H:i:s',time()),
                              'admin_id' => $_SESSION['admin_id'],
                              'admin_email' => $admin_email,
                              'an_status' => (int)$status,
                              'an_language' => $lang_name
                              );
                    zen_db_perform(TABLE_ANNOUNCEMENT, $save_sql_array);
                    $an_id = zen_db_insert_id();
                    foreach ($an_text as $lang_id => $text) {
                        if ($text != '') {
                            $lang_code = trim(substr(strstr($lang_id,"_"),1));
                            $lid = trim(substr($lang_id,0,1));
                            $save_desc_array = array(
                                'an_id' => $an_id ,
                                'an_language' => $lid,
                                'an_language_name' => $lang_code,
                                'an_content' => $text,
                                'create_time' => date('Y-m-d H:i:s',time()),
                                'modify_time' => date('Y-m-d H:i:s',time()),
                                'admin_id' => $_SESSION['admin_id'],
                                'admin_email' => $admin_email
                                );
                            //var_dump($save_desc_array);
                            zen_db_perform(TABLE_ANNOUNCEMENT_DESCRIPTION, $save_desc_array);
                        }
                    }
                }
                
                zen_redirect(zen_href_link('announcement'));                
            }
            ?>
        <?php  } ?>
    
    <!-- 正常显示首页 -->
    <?php }else{ ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="normal_table">
        <tr>
          <td class="pageHeading" style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标语管理</td>
          <td align="right" height="100px;" style="text-align:right;" >
            <form action="announcement.php" method="get" name="searchForm" id="searchForm">
             搜索：<input name="k" value="<?php echo $_GET['k']; ?>" placeholder="请输入标语名称" id="searchCondition" /><input type="button" value="搜索" onclick="formSubmit();" />
            </form><br/>
        </td>
        </tr>
    </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">              
                <td class="dataTableHeadingContent" width="8%" align="center">ID</td>
                <td class="dataTableHeadingContent" width="12%" align="left">名称</td>
                <td class="dataTableHeadingContent" width="18%" align="left">开始时间</td>
                <td class="dataTableHeadingContent" width="18%" align="left">结束时间</td>
                <td class="dataTableHeadingContent" width="20%" align="left">应用站点</td>
                <td class="dataTableHeadingContent" width="8%" align="center">启用/禁用</td>
                <td class="dataTableHeadingContent" width="8%" align="center">状态</td>
                <td class="dataTableHeadingContent" width="8%" align="left">操作</td>
              </tr>
              <?php

              if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS_REPORTS - MAX_DISPLAY_SEARCH_RESULTS_REPORTS;
              $rows = 0;
              $where = '';
              if(isset($_GET['k']) && trim($_GET['k']) != ''){
                $keywords = zen_db_input(zen_db_prepare_input($_GET['k']));
                $where = " where an_name like '%".$keywords."%'";
              }
              /*$suggestion_query_raw = 'select a.an_id, a.an_name,a.an_starttime,a.an_endtime,a.an_status,ad.an_language_name,ad.an_text from '.TABLE_ANNOUNCEMENT.' a, '.TABLE_ANNOUNCEMENT_DESCRIPTION.' ad '.$where.' order by suggestion_id DESC';*/
              $announecement_query_raw = "select an_id, an_name,an_starttime,an_endtime,an_status,an_language from ".TABLE_ANNOUNCEMENT . $where." order by an_id DESC";
              $announcement_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $announecement_query_raw, $announecement_query_numrows);
              $announcement = $db->Execute($announecement_query_raw);
              if ($announcement->EOF) { ?>
                <script type="text/javascript">
                  $('#noSearch').html('无搜索结果').show();
                </script>
              <?php }else{ 
                while (!$announcement->EOF) {

                  ?>
                  <tr class="dataTableRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" ondblclick="window.location.href='<?php echo zen_href_link(FILENAME_CUSTOMER_SUGGESTION, 'page=' . $_GET['page'] . '&sID=' . $announcement->fields['an_id']). "&action=view_info";?>' ">                
                    <td class="dataTableContent" align="center"><?php echo $announcement->fields['an_id']; ?></td>               
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['an_name']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['an_starttime']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['an_endtime']; ?></td>
                    <td class="dataTableContent" align="left"><?php echo $announcement->fields['an_language']; ?></td>
                    <td class="dataTableContent" align="center"><?php echo ($announcement->fields['an_status'] == 20) ? '启用' : '禁用'; ?></td>
                    <td class="dataTableContent" align="center">
                        <?php
                        if(strtotime($announcement->fields['an_starttime']) > time()){
                                echo '未开始';
                            }elseif (strtotime($announcement->fields['an_endtime']) < time()) {
                                echo '已结束';
                            }elseif (strtotime($announcement->fields['an_endtime']) > strtotime($announcement->fields['an_starttime']) && strtotime($announcement->fields['an_starttime']) <time()) {
                                echo '活动';
                            } ?>
                        </td>
                    <td class="dataTableContent" align="left">
                    <a href="<?php echo zen_href_link('announcement', zen_get_all_get_params(array('action', 'id')) . 'action=create&anId=' . $announcement->fields['an_id']);?>"><?php echo zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT);?></a>
                    </td>
                  </tr>
                  <?php
                  $announcement->MoveNext();
                }
              }
              ?>
        </table>
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText" valign="top"><?php echo $announcement_split->display_count($announecement_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tags)'); ?></td>
            <td class="smallText" align="left"><?php echo $announcement_split->display_links($announecement_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page'))); ?></td>
          </tr>
          <tr><a href="<?php echo zen_href_link('announcement', zen_get_all_get_params(array('action')) . 'action=create', 'NONSSL');?>"><button>新建标语</button></a></tr>
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
