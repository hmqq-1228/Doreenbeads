<?php
/**
 * �����ļ�
 * �˿Ͷ���վ���۵Ĺ���
 * testimonial_manage.php
 * jessa 2010-06-17
 */

  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $languages = zen_get_languages();
  
  if (zen_not_null($action)){
  	switch ($action){
  		case 'update':
  			$testimonial_id = $_GET['id'];
//			$title = zen_db_input($_POST['title']);
//			$content = zen_db_input($_POST['content']);
			$reply = zen_db_input($_POST['reply']);
			$is_checked = true;
			$is_stick = zen_db_input($_POST['is_stick']);
			
			$check_stick_query = $db->Execute('select language_id, tm_status from ' . TABLE_TESTIMONIAL . ' where tm_id = ' . $testimonial_id . ' limit 1');
			
			if($check_stick_query->RecordCount() > 0 && $check_stick_query->fields['tm_status'] == 1){
			    $language_id = $check_stick_query->fields['language_id'];
			    
			    if($is_stick == 10){
    			    $check_language_stick_query = $db->Execute('select tm_id from ' .TABLE_TESTIMONIAL . ' where is_stick = 10 and tm_id != ' . $testimonial_id . ' and language_id = ' . $language_id );
    			    
    			    if($check_language_stick_query->RecordCount() > 0){
    			        $is_checked = false;
    			        $messageStack->add_session($languages[$language_id-1]['code'] . '站点已有其他评论设置了显示在首页，请先取消。','error');
    			    }
			    }
			}else{
			    if($is_stick == 10){
			        $is_checked = false;
			        $messageStack->add_session('该评论为关闭状态，无法显示在首页。','error');
			    }
			}
			
			if($is_checked == true){
			    $db->Execute("Update " . TABLE_TESTIMONIAL . " Set tm_title = '" . $title . "', tm_reply = '".$reply."', is_stick = " . $is_stick . ", modify_admin = '" . $_SESSION['admin_name'] . "', modify_datetime = now() Where tm_id = " . (int)$testimonial_id);
			}
			
			zen_redirect(zen_href_link(FILENAME_TESTIMONIAL_MANAGE,zen_get_all_get_params(array('action'))));
  		break;
  		case 'delete':
  			$testimonial_id = $_GET['id'];
  			$check_stick_query = $db->Execute('select language_id, tm_status, is_stick from ' . TABLE_TESTIMONIAL . ' where tm_id = ' . $testimonial_id . ' limit 1');
  			
  			if($check_stick_query->fields['is_stick'] == 10){
  			    $messageStack->add_session('该评论设置了展示在首页，无法删除。','error');
  			}else{
  			    $db->Execute("Delete From " . TABLE_TESTIMONIAL . " Where tm_id = " . (int)$testimonial_id);
  			}
  			zen_redirect(zen_href_link(FILENAME_TESTIMONIAL_MANAGE,zen_get_all_get_params(array('action','id'))));
  		break;
  		case 'set':
  			$testimonial_id = $_GET['id'];
  			$status = $_GET['status'];
  			$error = false;
  			if($status == 0){
  			    $check_stick_query = $db->Execute('select is_stick from ' . TABLE_TESTIMONIAL . ' where tm_id =' . $testimonial_id);
  			    
  			    if($check_stick_query->fields['is_stick'] == 10){
  			        $error = true;
  			        $messageStack->add_session('该评论设置了展示在首页，无法关闭。','error');
  			        
  			    }
  			}
  			
  			if(!$error){
  			    $db->Execute("Update " . TABLE_TESTIMONIAL . " Set tm_status = " . (int)$status . " Where tm_id = " . (int)$testimonial_id);
  			}
  			zen_redirect(zen_href_link(FILENAME_TESTIMONIAL_MANAGE,zen_get_all_get_params(array('action'))));
  		break;
  	}
  }
  
  if (isset($_POST['action']) && $_POST['action'] == 'insert'){
  	$title = zen_db_prepare_input(trim($_POST['title']));
  	$content = zen_db_prepare_input(trim($_POST['content']));
  	$name = zen_db_prepare_input(trim($_POST['name']));
  	$email = zen_db_prepare_input(trim($_POST['email']));
  	$db->Execute("insert into t_testimonial (tm_title, tm_content, tm_customer_email, tm_customer_name, tm_status, tm_date_added)
  				  values ('" . zen_db_input($title) . "', '" . zen_db_input($content) . "', '" . zen_db_input($email) . "', '" . zen_db_input($name) . "', 0, '" . date('Ymd') . "')");
  	zen_redirect(zen_href_link('testimonial_manage.php'));
  }
 // echo $_GET['testimonialLang'];
	$where = '';
	if(isset($_GET['k']) && trim($_GET['k']) != ''){
		$keywords = zen_db_input(zen_db_prepare_input($_GET['k']));
		$where = " where tm_customer_email like '%".$keywords."%' or tm_customer_name like '%".$keywords."%' ";
	}
	if(isset($_GET['l']) && $_GET['l'] != ''){
		$where = "  where language_id = ".$_GET['l'];  	
	}
	if(isset($_GET['s']) && $_GET['s'] != ''){
		$where .= ($where=='' ? ' where ' : ' and ')."tm_status = ".$_GET['s'];  	
	}
	if(isset($_GET['reply_status']) && $_GET['reply_status'] != ''){
	    if ($_GET['reply_status'] == 1){
	        $where .= ($where == '' ? ' where ' : ' and ') . "tm_reply != ''";
	    }else{
	        $where .= ($where == '' ? ' where ' : ' and ') . "tm_reply = ''";
	    }
	}
	
  $testimonial_query = "Select tm_id
  						  From t_testimonial".$where."
  					  Order By is_stick asc, tm_id Desc";
  
  $testimonial_split = new splitPageResults($_GET['page'], 30, $testimonial_query, $query_num_rows);
  $testimonial = $db->Execute($testimonial_query);
  
  $testimonial_array = array();
  if ($testimonial->RecordCount() > 0){
  	while (!$testimonial->EOF){
  		$testimonial_array[] = array('id' => zen_db_output($testimonial->fields['tm_id']));
  		$testimonial->MoveNext();
  	}
  }
  
  if (!isset($_GET['id']) || (isset($_GET['id']) && $_GET['id'] == '')){
  	$id = $testimonial_array[0]['id'];
  } else {
  	$id = $_GET['id'];
  }
 //echo $id;
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

<!-- body bof -->
<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  <tr>
  	<td class="pageHeading"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);?></td>
  </tr>
  <tr>
  	<td class="pageHeading"><div style="float:left;">Testimonial Manage</div>

<div style='float:right;font-size:12px;color:#000;text-align:right;'>
<form action="<?php echo FILENAME_TESTIMONIAL_MANAGE; ?>" method="get" name="searchForm">
	<input name="k" value="<?php echo $_GET['k']; ?>" /><input type="submit" value="搜索" />
</form>
<br/>
<form action="<?php echo FILENAME_TESTIMONIAL_MANAGE; ?>" method="get" name="languageForm">
是否回复：<select name='reply_status'>
		<option value="">所有</option>
		<option <?php echo isset($_GET['reply_status'])&&$_GET['reply_status']=='1' ? "selected='selected'" : ""; ?> value="1">已回复</option>
		<option <?php echo isset($_GET['reply_status'])&&$_GET['reply_status']=='0' ? "selected='selected'" : ""; ?> value="0">未回复</option>
	</select><br/>
<?php
	$langs = zen_get_languages();
	echo "语言：<select name='l'>";
	echo "<option value=''>所有</option>";
	foreach($langs as $lang) {
		echo "<option ".(isset($_GET['l'])&&$_GET['l']==$lang['id'] ? "selected='selected'" : "")." value=".$lang['id'].">".$lang['directory']."</option>"; 
    }
	echo "</select><br/>";
?>
	状态：<select name='s'>
		<option value="">所有</option>
		<option <?php echo isset($_GET['s'])&&$_GET['s']=='1' ? "selected='selected'" : ""; ?> value="1">开启</option>
		<option <?php echo isset($_GET['s'])&&$_GET['s']=='0' ? "selected='selected'" : ""; ?> value="0">关闭</option>
	</select><br/>
	<input type="submit" value="提交" />
</form>
</div>
	
	</td>
  </tr>
  <tr>
  	<td style="padding:10px 0px;">
  	<?php 
	  if ($action != 'addnew'){
	?>
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:75%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	  	  <tr class="dataTableHeadingRow">
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:8%;">ID</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:15%;">Customer Name</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:20%;">Customer Email</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:12%; text-align:center;">Status</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:15%; text-align:center;">Date Added</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:15%; text-align:center;">是否回复</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%; text-align:center;">是否显示在首页</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%; text-align:center;">语种</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 5px; width:10%; text-align:right;">Action</td>
	  	  	  </tr>
	  	  	  <?php
	  	  	    for ($i = 0; $i < sizeof($testimonial_array); $i++){
	  	  	    	$testimonial_info = zen_get_testimonial_info($testimonial_array[$i]['id']);
	  	  	  ?>
	  	  	  <?php if ($id == $testimonial_array[$i]['id']){ ?>
	  	  	  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link(FILENAME_TESTIMONIAL_MANAGE, (isset($_GET['testimonialLang'])?'testimonialLang='.$_GET['testimonialLang'].'&':'').'id=' . $testimonial_array[$i]['id'].'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id'))); ?>'">
	  	  	  <?php } else { ?>
	  	  	  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link(FILENAME_TESTIMONIAL_MANAGE, (isset($_GET['testimonialLang'])?'testimonialLang='.$_GET['testimonialLang'].'&':'').'id=' . $testimonial_array[$i]['id'].'&page='.$_GET['page'].'&'.zen_get_all_get_params(array('page','id'))); ?>'">
	  	  	  <?php } ?>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;"><?php echo $testimonial_array[$i]['id']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;"><?php echo $testimonial_info['customer_name']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;"><?php echo $testimonial_info['customer_email']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo ($testimonial_info['status'] == 1) ? '<a href="' . zen_href_link(FILENAME_TESTIMONIAL_MANAGE, 'action=set&status=0&id=' . $testimonial_array[$i]['id'].'&'.zen_get_all_get_params(array('page','id','action','status'))) .'&page='.$_GET['page'].(isset($_GET['testimonialLang'])?('&testimonialLang='.$_GET['testimonialLang']):'').'">' . zen_image(DIR_WS_IMAGES . 'icon_green_on.gif') . '</a>' : '<a href="' . zen_href_link(FILENAME_TESTIMONIAL_MANAGE, 'action=set&status=1&id=' . $testimonial_array[$i]['id'].'&'.zen_get_all_get_params(array('page','id','action','status'))) .(isset($_GET['testimonialLang'])?('&testimonialLang='.$_GET['testimonialLang']):''). '">' . zen_image(DIR_WS_IMAGES . 'icon_red_on.gif') . '</a>'; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $testimonial_info['date_added']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo ($testimonial_info['had_reply'] == 1) ? '已回复' : '未回复' ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo ($testimonial_info['is_stick'] == 10) ? '是' : '否' ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $languages[$testimonial_info['language_id']-1]['code']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 5px;" align="right">
	  	  	  	
	
	  	  	  	<?php 
	  	  	  	  if ($id == $testimonial_array[$i]['id']){

	  	  	  	  	echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
	  	  	  	  } else {


	  	  	  	  echo '<a href="' . zen_href_link(FILENAME_TESTIMONIAL_MANAGE, (isset($_GET['testimonialLang'])?'testimonialLang='.$_GET['testimonialLang'].'&':'').'page='.$_GET['page'] . '&id=' . $testimonial_array[$i]['id'].'&'.zen_get_all_get_params(array('page','id'))) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif') . '</a>';
	  	  	  	  }
	  	  	  	?>
	  	  	  	</td>
	  	  	  </tr>
	  	  	  <?php } ?>
			  <?php if (sizeof($testimonial_array) > 0){ ?>
			  <tr>
			  	<td colspan="6" style="padding:5px; text-align:right;"><?php echo $testimonial_split->display_count($query_num_rows, 30, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TESTIMONIAL) . '&nbsp;&nbsp;&nbsp;&nbsp;' . $testimonial_split->display_links($query_num_rows, 30, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'id'))); ?></td>
			  </tr>
			  <?php } ?>
			  <tr>
			    <td colspan="6" style="padding:5px; text-align:right;"><?php echo '<a href="' . zen_href_link('testimonial_manage', 'action=new') . '">' . zen_image_button('button_insert.gif', 'insert') . '</a>'; ?></td>
			  </tr>
	  	  	</table>
	  	  </td>
	  	  <?php
	  	  	$current_testimonial_info = zen_get_testimonial_info($id);
	  	  ?>
	  	  <td style="widht:25%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      <tr>
	  	      <?php if ($action != 'new'){ ?>
	  	      	<td class="infoBoxHeading" style="padding:5px 5px;"><?php echo '#ID: ' . $id . '&nbsp;&nbsp;' . $current_testimonial_info['customer_name']; ?></td>
	  	      <?php } else { ?>
	  	        <td class="infoBoxHeading" style="padding:5px 5px;"><?php echo 'Add New One'; ?></td>
	  	      <?php } ?>
	  	      </tr>
	  	      <tr>
	  	      	<td class="infoBoxContent" style="padding:5px;">
	  	      	<?php if ($action != 'edit' && $action != 'new'){ ?>
	  	      	  <table border="0" cellpadding="0" cellspacing="0" width="100%">

	  	      	  	<tr>
							<td style="font-weight: bold;">Testimonial:</td>
				  </tr>
				  <tr>
	  	      	  	  <td style="line-height:130%;padding:10px 5px;padding-left:20px;"><?php echo  $current_testimonial_info['content']; ?>
	  	      	  	</tr>
                  <tr>
							<td style="font-weight: bold;">Reply:</td>
							</tr>
				  <tr>
                    <td style="line-height:130%;padding:10px 5px;padding-left:20px;"><?php echo  $current_testimonial_info['reply']; ?>
                  </tr>
                  <tr>
	  	      	  	  <td style="padding:10px 0px;"><span style="font-weight:bold;">是否显示在首页：</span><?php echo $current_testimonial_info['is_stick'] == 10 ? '是' : '否'; ?></td>
	  	      	  	</tr>
	  	      	  	<tr>
	  	      	  	  <td style="padding:10px 0px;"><span style="font-weight:bold;">站点：</span><?php echo $languages[$current_testimonial_info['language_id']-1]['code']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr>
	  	      	  	  <td style="padding:10px 0px;"><span style="font-weight:bold;">修改人：</span><?php echo $current_testimonial_info['modify_admin']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr>
	  	      	  	  <td style="padding:10px 0px;"><span style="font-weight:bold;">修改时间：</span><?php echo $current_testimonial_info['modify_datetime']; ?></td>
	  	      	  	</tr>
	  	      	  	<tr>

	  	      	  	  <td style="padding:5px; text-align:left;"><?php echo '<a href="' . zen_href_link(FILENAME_TESTIMONIAL_MANAGE, zen_get_all_get_params(array('action' , 'id')).'id=' . $id . '&action=edit') . '">' . zen_image_submit('button_edit.gif', IMAGE_EDIT) . '</a>&nbsp;' . 
	  		  	      	  	  '<a href="' . zen_href_link(FILENAME_TESTIMONIAL_MANAGE, zen_get_all_get_params(array('action' , 'id')).'id=' . $id . '&action=delete') . '">' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '</a>'; ?></td>

					<!-- 
					<td style="padding:5px; text-align:left;" colspan="2"><?php echo zen_image_submit('button_update.gif', IMAGE_UPDATE). '&nbsp;' .'<a href="' . zen_href_link(FILENAME_TESTIMONIAL_MANAGE, 'id=' . $id . '&action=delete&page='.$_GET['page']) . '">' . zen_image_button('button_delete.gif') . '</a>'; ?>
	  	      	  	 -->	
	  	      	  	</tr>
	  	      	  </table>
						</form>
	  	      	<?php } else { ?>
	  	      	<?php if ($action == 'edit'){ ?>
	  	      	<?php echo zen_draw_form('update_testimonial', FILENAME_TESTIMONIAL_MANAGE, zen_get_all_get_params(array('action' , 'id')) . (isset($_GET['testimonialLang'])?'testimonialLang='.$_GET['testimonialLang'].'&':'').'action=update&id=' . $id.'&page='.$_GET['page']); ?>
	  	      	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
<!--
	  	      	    <tr>
	  	      	  	  <td style="padding:5px 0px; font-weight:bold;">Title:</td>
	  	      	  	</tr>
	  	      	  	<tr>
	  	      	  	  <td style="padding:5px 0px;"><?php echo zen_draw_input_field('title', $current_testimonial_info['title'], 'size="30"'); ?>
	  	      	  	</tr>
-->
	  	      	  	<tr>
	  	      	  	  <td style="padding:5px 0px; font-weight:bold;">Content:</td>
	  	      	  	</tr>
	  	      	  	<tr>
	  	      	  	  <td style="padding:5px 0px;"><?php echo $current_testimonial_info['content'].' '; ?>
	  	      	  	</tr>
                  <tr>
                    <td style="padding:5px 0px; font-weight:bold;">Reply:</td>
                  </tr>
                  <tr>
                    <td style="padding:5px 0px;"><?php echo '' . zen_draw_textarea_field('reply', '', '20', '15', $current_testimonial_info['reply']); ?>
                  </tr>
                  <tr>
	  	      	  		<td style="padding:5px 0px;"><span>是否展示在首页：</span><span><label><?php echo zen_draw_radio_field('is_stick', '10', $current_testimonial_info['is_stick'] == 10 ? true : false, '', 'style="position:relative;top:3px;"')?><span style="margin-left: 3px;">是</span></label><label style="margin-left: 10px;"><?php echo zen_draw_radio_field('is_stick', '20', $current_testimonial_info['is_stick'] == 20 ? true : false, '', 'style="position:relative;top:3px;"')?><span style="margin-left: 3px;">否</span></label></span></td>
	  	      	  	</tr>
	  	      	  	<tr>
	  	      	  	  <td style="padding:5px 0px; font-weight:bold;"><span style="margin: 5px;"><?php echo zen_image_submit('button_update.gif', IMAGE_UPDATE); ?></span><span style="margin: 5px;"><a href="<?php echo zen_href_link(FILENAME_TESTIMONIAL_MANAGE , zen_get_all_get_params(array('action')))?>"><?php echo  zen_image_button('button_cancel.gif', '取消');?></a></span></td>
	  	      	  	</tr>
	  	      	  </table>
	  	      	  </form>
	  	      	<?php } else {
	  	      		if ($action == 'new'){
	  	      	?>
	  	      	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      	  <?php echo zen_draw_form('testimonial', 'testimonial_manage.php') . zen_draw_hidden_field('action', 'insert');?>
	  	      	    <tr>
	  	      	      <td style="padding:5px 0px;"><b><?php echo 'Title:'; ?></b></td>
	  	      	      <td style="padding:5px 0px;"><?php echo zen_draw_input_field('title'); ?></td>
	  	      	    </tr>
	  	      	    <tr>
	  	      	      <td style="padding:5px 0px;"><b><?php echo 'Content:'; ?></b></td>
	  	      	      <td style="padding:5px 0px;"><?php echo zen_draw_textarea_field('content', '', '40', '15'); ?></td>
	  	      	    </tr>
	  	      	    <tr>
	  	      	      <td style="padding:5px 0px;"><b><?php echo 'Customer Name:'; ?></b></td>
	  	      	      <td style="padding:5px 0px;"><?php echo zen_draw_input_field('name'); ?></td>
	  	      	    </tr>
	  	      	    <tr>
	  	      	      <td style="padding:5px 0px;"><b><?php echo 'Customer Email:'; ?></b></td>
	  	      	      <td style="padding:5px 0px;"><?php echo zen_draw_input_field('email'); ?></td>
	  	      	    </tr>
	  	      	    <tr>
	  	      	      <td style="padding:5px 0px;">&nbsp;</td>
	  	      	      <td style="padding:5px 0px;"><?php echo zen_image_submit('button_insert.gif', IMAGE_INSERT); ?></td>
	  	      	    </tr>
	  	      	    </form>
	  	      	  </table>
	  	      	<?php 
	  	      		}
	  	      	  }
	  	      	} 
	  	      	?>
	  	      	</td>
	  	      </tr>
	  	  	</table>
	  	  </td>
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
