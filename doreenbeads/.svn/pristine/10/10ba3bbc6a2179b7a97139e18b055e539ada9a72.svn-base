<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: admin.php 4701 2006-10-08 01:09:44Z drbyte $
//

require('includes/application_top.php');
?>

<?php
$action = (isset($_GET['action']) ? $_GET['action'] : '');

if (zen_not_null($action)) {

  switch ($action) {
    // demo active test
    case (zen_admin_demo()):
      $action='';
      $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
    	zen_redirect(zen_href_link(FILENAME_ADMIN));
      break;
    case 'check_admin_name':
        $admin_name = zen_db_prepare_input($_GET['admin_name']);
        $return_info = array('error' => false , 'error_info' => '');
        
        $check_admin_name_query = $db->Execute('select admin_name from ' . TABLE_ADMIN . ' where admin_name ="' . $admin_name . '"');
        
        if($check_admin_name_query->RecordCount() > 0){
            $return_info['error'] = true;
            $return_info['error_info'] = '该用户名已存在，请重新输入!';
        }
        echo json_encode($return_info);
        exit;
        break;
//-------------------------------------------------------------------------------------------------------------------------
    case 'insert':
    case 'save':
    case 'reset':
        if (isset($_GET['adminID'])) $admins_id = zen_db_prepare_input($_GET['adminID']);
        $admin_name = zen_db_prepare_input($_POST['admin_name']);
        $admin_email = zen_db_prepare_input($_POST['admin_email']);
        $password_new = zen_db_prepare_input($password_new);
        $admin_level = zen_db_prepare_input($_POST['admin_level']);
        $admin_show_customer_email = zen_db_prepare_input($_POST['admin_show_customer_email']);
        $role_id = zen_db_prepare_input($_POST['role_id']);
        $password_new = zen_db_prepare_input($password_new);
        $admin_status = zen_db_prepare_input($_POST['admin_status']);
        $error = false;

    if ( ($action == 'insert') || ($action == 'reset') ){
    	$password_new = zen_db_prepare_input($_POST['password_new']);
    	$password_confirmation = zen_db_prepare_input($_POST['password_confirmation']);
    
    	if (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
    		$error = true;
    		$messageStack->add_session(ENTRY_PASSWORD_NEW_ERROR, 'error');
    	}
    	if ($password_new != $password_confirmation) {
    		$error = true;
    		$messageStack->add_session(ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING, 'error');
    	}
    	
    	if($action == 'insert'){
        	if($admin_name != ''){
            	$admin_name_query = $db->Execute('select admin_name from ' . TABLE_ADMIN . ' where admin_name = "' . $admin_name . '"'); 
            	
            	if($admin_name_query->RecordCount() > 0){
            	    $error = true;
            	    $messageStack->add_session('该用户名已存在，请重新输入！', 'error');
            	}
        	}else{
        	    $error = true;
        	    $messageStack->add_session('用户名不能为空！', 'error');
        	}
    	}
    }
    
    if ($error == false) {
    	if ($action == 'insert') {
    	    $sql_data_array = array(
    	        'admin_name' => $admin_name,
    	        'admin_email' => $admin_email,
    	        'admin_level' => (int)$admin_level,
    	        'admin_show_customer_email' => (int)$admin_show_customer_email,
    	        'role_id'=>$role_id,
    	        'admin_status' => $admin_status
    	    );
    		$insert_sql_data = array('admin_pass' => zen_encrypt_password($password_new));
    		$sql_data_array = array_merge($sql_data_array, $insert_sql_data);
    		zen_db_perform(TABLE_ADMIN, $sql_data_array);
    		$new_admin_id = zen_db_insert_id();
            $admins_id = $new_admin_id;            
    		$operate_content= $new_admin_id.'用户被新建';
    		
    		if($_POST['role_id']!=0||$_POST['role_id']!=""){
    		    admin_update_or_add_role($admins_id, $role_id);
		    }
		
            zen_insert_operate_logs($_SESSION['admin_id'],$new_admin_id,$operate_content,4);					
				
    
    	} elseif ($action == 'save') {
    	    $check_orgin_status_query = $db->Execute('select admin_status from ' . TABLE_ADMIN . " where admin_id = '" . (int)$admins_id . "'");
    	    
    	    if(!($check_orgin_status_query->fields['admin_status'] == 20 && $admin_status == 20)){
    	        $sql_data_array = array(
    	            'admin_name' => $admin_name,
    	            'admin_email' => $admin_email,
    	            'admin_level' => (int)$admin_level,
    	            'admin_show_customer_email' => (int)$admin_show_customer_email,
    	            'admin_status' => $admin_status
    	        );
    	        zen_db_perform(TABLE_ADMIN, $sql_data_array, 'update', "admin_id = '" . (int)$admins_id . "'");
    	        
    	        $operate_content= $admins_id.'用户被编辑';
    	        
    	        if($_POST['role_id']!=0||$_POST['role_id']!=""){
    	            $admin_role_query = $db->Execute('select role_id from ' . TABLE_ADMIN . ' where admin_id = ' . (int)$admins_id);
    	            if($admin_role_query->RecordCount() > 0){
    	                if($admin_role_query->fields['role_id'] != $role_id){
    	                    admin_update_or_add_role($admins_id, $admin_role_query->fields['role_id'], true, $role_id);
    	                    $db->Execute('update ' . TABLE_ADMIN . ' set role_id = ' . $role_id . ' where admin_id = ' . (int)$admins_id);
    	                    $operate_content .= '用户角色被修改';
    	                }
    	            }
    	        }
    	        $db->Execute("UPDATE " . TABLE_CONFIGURATION . " set configuration_value='" . (int)$_POST['demo_status'] . "' where configuration_key='ADMIN_DEMO'");
    	        
    	        if($admin_status == 20){
    	            $operate_content .= '用户被禁用';
    	        }
    	        zen_insert_operate_logs($_SESSION['admin_id'],$admins_id,$operate_content,4);
    	    }
    	} elseif ($action == 'reset') {
    
    		$update_sql_data = array('admin_pass' => zen_encrypt_password($password_new));
    		
    		zen_db_perform(TABLE_ADMIN, $update_sql_data, 'update', "admin_id = '" . (int)$admins_id . "'");
    
    	} // end action check
    	if($_SESSION['admin_id']==$admins_id){
    		$_SESSION['show_customer_email'] = (int)$admin_show_customer_email;
    	}
    
    	zen_redirect(zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action'))));
    
    } // end error check
    
    
    //echo $action;
    zen_redirect(zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action'))));
    break;
    
/*-------------------------------------------------------------------------------------------------------------------------
    case 'deleteconfirm':
      $new_admin_id = zen_db_prepare_input($_GET['adminID']);
      $db->Execute("delete from " . TABLE_ADMIN . " where admin_id = '" . (int)$new_admin_id . "'");
      $operate_content= $_GET['adminID'].'用户被关闭';
      zen_insert_operate_logs($_SESSION['admin_id'],$_GET['adminID'],$operate_content,4);
    	zen_redirect(zen_href_link(FILENAME_ADMIN, 'page=' . $_GET['page']).(isset($_GET['search']) ? 'search=' . $_GET['search'] . '&' : '') . (isset($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&' : '') );
    break;
*/
  } // end switch
} // end zen_not_null
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

function process_json(data){
	var returnInfo=eval('('+data+')');
	return returnInfo;
}
function check_form(){
	var admin_name = $('input[name=admin_name]').val();
	var error = false;

	$.ajax({
		type:'GET',
		url:'admin.php',
		data:{action:'check_admin_name',admin_name:admin_name},
		async:false,
		success:function(data){
			var returnInfo = process_json(data);
			
			if(returnInfo.error == true){
				$('#admin_name_tip').html(returnInfo.error_info);
				error = true;
			}
		}
	});
	return !error;
}

$(document).ready(function(){
	$('input[name=admin_status]').change(function(){
		var orgin_status = $('input[name=orgin_status]').val();
        var current_status = $(this).val();
        
		if(orgin_status == 20){
			if(current_status == 10){
				$('input[name=admin_email]').removeAttr('readonly').css('color', 'black');
				$('select[name=role_id]').removeAttr('onfocus').removeAttr('onchange').css('background-color', '');
				$('input[name=admin_show_customer_email]').removeAttr('onclick').next('span').css('color','');
			}else{
				$('input[name=admin_email]').attr('readonly', 'readonly').css('color', 'grey');
				$('select[name=role_id]').attr('onfocus', 'this.defOpt=this.selectedIndex;').attr('onchange', 'this.selectedIndex=this.defOpt;').css('background-color', '#bdbbbb');
				$('input[name=admin_show_customer_email]').attr('onclick', 'return false;').next('span').css('color','grey');
			}
		}
	});
	
});
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
		<td width="100%" valign="top">


<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<?php echo zen_draw_form('search', FILENAME_ADMIN, '', 'get', 'id="search_form"', true); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
		<td align="right">
		<table border="0" width="35%" cellspacing="0" cellpadding="0">
			<tr style="height: 30px;">
				<td style="text-align: right;">账号类型：</td>
				<td>
					<?php
    					$role_display_sql="SELECT role_id,role_name FROM ".TABLE_ADMIN_ROLE;
    					$role_display=$db->Execute($role_display_sql);
    					
    					echo "<select name='role' style='width: 185px;'><option value='0'>--ALL--</option>";
    					while(!$role_display->EOF){
    					    echo "<option value=".$role_display->fields['role_id']." " . ($role_display->fields['role_id'] == $_GET['role'] ? 'selected' : '') . ">--".$role_display->fields['role_name']."--</option>";
    					    $role_display->MoveNext();
    					}
    					echo '</select>';
				    ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td style="text-align: right;">Account Status：</td>
				<td>
					<select name='admin_status' style='width: 185px;'>
						<option value='0'>--ALL--</option>
						<option value='10' <?php if($_GET['admin_status'] == 10){ echo 'selected';}?>>启用</option>
						<option value='20' <?php if($_GET['admin_status'] == 20){ echo 'selected';}?>>禁用</option>
					</select>
				</td>
			</tr>
    		<tr style="height: 30px;">
    			<td style="text-align: right;">搜索：</td>
    			<td>
    				<?php 
    				  echo zen_draw_input_field('search',((isset($_GET['search']) && zen_not_null($_GET['search']))?zen_db_input(zen_db_prepare_input($_GET['search'])):''),'style="width:185px;" id="search_text"') . zen_hide_session_id();
    				?>
    			</td>
    		</tr>
    		<tr style="height: 30px;">
    			<td colspan=2 style="text-align: right;padding-right: 30px;">
    				<?php   echo "<input type='submit' value='确定'>"; ?>
    		   </td>
    		</tr>
		</table>
		</td>
	</tr>
</table>
<?php echo '</form>';?>
<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr class="dataTableHeadingRow">
		<td width="10%" class="dataTableHeadingContent" ><?php echo TABLE_HEADING_ADMINS_ID; ?></td>
		<td width="20%" class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ADMINS_NAME; ?></td>
		<td width="20%" class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ADMINS_EMAIL; ?></td>
		<td width="20%" class="dataTableHeadingContent" align="center"><?php echo 'show customer email'; ?></td>
		<td width="20%" class="dataTableHeadingContent" align="center"><?php echo 'Account Status'; ?></td>
		<td width="10%" class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
</tr>

<?php
if(isset($_GET['role']) && $_GET['role'] != 0 && $_GET['role'] !== ''){
    $search_query = ' where role_id = "' . (int)$_GET['role'] . '"';
}

if(isset($_GET['admin_status']) && in_array($_GET['admin_status'], array(10, 20))){
    if($search_query == ''){
        $search_query = ' where admin_status = "' . (int)$_GET['admin_status'] . '"';
    }else{
        $search_query .= ' and admin_status = "' . (int)$_GET['admin_status'] . '"';
    }
}

if(isset($_GET['search']) && zen_not_null($_GET['search'])){
	$para_search = zen_db_input(zen_db_prepare_input($_GET['search']));
	if($search_query == ''){
	   $search_query = ' where admin_name like "%'.$para_search.'%" or admin_email like "%'.$para_search.'%"';
	}else{
	   $search_query .= ' and admin_name like "%'.$para_search.'%" or admin_email like "%'.$para_search.'%"';
	}
}



// if(isset($_GET['sort']) && zen_not_null($_GET['sort'])){
// 	switch($_GET['sort']){
// 		case 0:
// 			$para_sort = ' order by admin_name ASC';break;
// 		case 1:
// 			$para_sort = ' order by admin_name DESC';break;
// 		case 2:
// 			$para_sort = ' order by admin_id DESC';break;
// 		case 3:
// 			$para_sort = ' order by admin_id ASC';break;
// 	}
	
// }else{
	$para_sort = ' order by admin_name ASC';
// }

$admins_query_raw = "select admin_id, admin_name, admin_email, admin_pass, admin_level, admin_show_customer_email , admin_status, role_id from " . TABLE_ADMIN .$search_query. $para_sort;
$admins_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $admins_query_raw, $admins_query_numrows);
$admins = $db->Execute($admins_query_raw);

while (!$admins->EOF) {
  if ((!isset($_GET['adminID']) || (isset($_GET['adminID']) && ($_GET['adminID'] == $admins->fields['admin_id']))) && !isset($admin_info) && (substr($action, 0, 3) != 'new')) {
  	$admin_info = new objectInfo($admins->fields);
  }
  
  if (isset($admin_info) && is_object($admin_info) && ($admins->fields['admin_id'] == $admin_info->admin_id)) {
      echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action','adminID')) . 'adminID=' . $admins->fields['admin_id'] . '&action=edit') . '\'">' . "\n";
  } else {
      echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action', 'adminID')) .'adminID=' . $admins->fields['admin_id']) . '\'">' . "\n";
  }
?>

		<td class="dataTableContent"><?php echo $admins->fields['admin_id']; ?></td>
		<td class="dataTableContent" align="center"><?php echo $admins->fields['admin_name']; ?></td>
		<td class="dataTableContent" align="center"><?php echo $admins->fields['admin_email']; ?></td>
		<td class="dataTableContent" align="center"><?php echo $admins->fields['admin_show_customer_email']; ?></td>
		<td class="dataTableContent" align="center"><?php echo $admins->fields['admin_status'] == 10 ? '<span>启用</span>' : '<span style="color:red;">禁用</span>'; ?></td>
		<td class="dataTableContent" align="right">
<?php echo '<a href="' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action', 'adminID')) .'adminID=' . $admins->fields['admin_id'] . '&action=edit') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>
<?php /* echo '<a href="' . zen_href_link(FILENAME_ADMIN, 'page=' . $_GET['page'] . '&adminID=' . $admins->fields['admin_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>';*/ ?>
<?php echo '<a href="' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action', 'adminID')) .'adminID=' . $admins->fields['admin_id']. '&action=resetpassword') . '">' . zen_image(DIR_WS_IMAGES . 'icon_reset.gif', ICON_RESET) . '</a>'; ?>
		</td>
</tr>

<?php
  $admins->MoveNext();
}
?>

	<tr>
		<td colspan="2">

<table border="0" width="100%" cellspacing="0" cellpadding="4">
	<tr>
		<td class="smallText" valign="top"><?php echo $admins_split->display_count($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ADMINS); ?></td>
		<td class="smallText" align="right"><?php echo $admins_split->display_links($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],zen_get_all_get_params(array('page'))); ?></td>
	</tr>
</table>

		</td>
	</tr>

<?php
if (empty($action)) {
?>
	<tr>
		<td align="right" colspan="4" class="smallText">
<?php
  $button_sql="SELECT id,page FROM ".TABLE_ADMIN_FILES. " WHERE page='privilege_management'";
  $button=$db->Execute($button_sql);
  $show_button_sql = "SELECT * FROM ".TABLE_ADMIN_ALLOWED." WHERE page_id = ".$button->fields['id']. " AND admin_id = '".$_SESSION['admin_id']."'";
  $privilege_management=$db->Execute($show_button_sql);
  if(!$privilege_management->EOF){
      echo '<input type="button" value="角色管理"' . 'onclick="location=\'' . zen_href_link('privilege_management').'\'"> &nbsp';
  }  
  echo '<input type="button" value="insert"' . 'onclick="location=\'' . zen_href_link(FILENAME_ADMIN,  'action=new') . '\'"> &nbsp';
?>
		</td>
	</tr>
<?php
}
?>
</table>
		</td>

<?php
$heading = array();
$contents = array();

switch ($action) {
//-------------------------------------------------------------------------------------------------------------------------

  case 'new':
    $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_ADMIN . '</b>');
    $contents = array('form' => zen_draw_form('new_admin', FILENAME_ADMIN, zen_get_all_get_params(array('action')) . 'action=insert', 'post', 'enctype="multipart/form-data"'));
    $contents[] = array('text' => TEXT_NEW_INTRO);
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_NAME . '<br>' . zen_draw_input_field('admin_name', '', zen_set_field_length(TABLE_ADMIN, 'admin_name', $max=30)) . '<br><span id="admin_name_tip" style="color:red;"></span>' );
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_EMAIL . '<br>' . zen_draw_input_field('admin_email', '', zen_set_field_length(TABLE_ADMIN, 'admin_email', $max=30)) . '<br><span id="admin_email_tip" style="color:red;"></span>' );
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_PASSWORD . '<br>' . zen_draw_password_field('password_new', '', zen_set_field_length(TABLE_ADMIN, 'admin_pass', $max=20)) . '<br><span id="admin_password_tip" style="color:red;"></span>' );
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_CONFIRM_PASSWORD . '<br>' . zen_draw_password_field('password_confirmation', '', zen_set_field_length(TABLE_ADMIN, 'admin_pass', $max=20)) . '<br><span id="admin_password_confirm_tip" style="color:red;"></span>' );
    $contents[] = array('text' => zen_draw_hidden_field('admin_level', '1',  '<br><span id="admin_level_tip" style="color:red;"></span>') );
    $contents[] = array('text' => '<br>Show customer email address<br>0 not show;1 show<br>' . zen_draw_input_field('admin_show_customer_email', '0') . '<br><span id="admin_show_email_tip" style="color:red;"></span>');
    $contents[] = array('text' => '<br>账号类型</br>');    
    $role_display_sql="SELECT role_id,role_name FROM ".TABLE_ADMIN_ROLE;
    $role_display=$db->Execute($role_display_sql);
    while(!$role_display->EOF){
        $role[] = "<option value=".$role_display->fields['role_id'].">--".$role_display->fields['role_name']."--</option>";
        $role_display->MoveNext();
    }    
    if(isset($role)){
        $contents[] = array('text'=>"<select name='role_id' style='width: 185px;'><option value='NULL'>--请选择--</option>".implode(" ", $role)."</select>" . '<br><span id="admin_role_tip" style="color:red;"></span>');}
    else{
        $contents[] = array('text'=>"<select name='role_id' style='width: 185px;'><option value='NULL'>--请选择--</option></select>" . '<br><span id="admin_role_tip" style="color:red;"></span>');
    }
    $contents[] = array('text' => '<br>Account Status<br>' . '<input type="radio" name="admin_status" value="10" checked><span style="position: relative;top: -3px;margin-right: 10px;">启用</span><input type="radio" name="admin_status" value="20"  ><span style="position: relative;top: -3px;margin-right: 10px;">禁用</span>' . '<br><span id="admin_status_tip" style="color:red;"></span>');
    $contents[] = array('align' => 'center',
        'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE, 'onclick="return check_form();"') . '<a href="' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action'))) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
  break;
  
//-------------------------------------------------------------------------------------------------------------------------
  case 'edit':
    $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_ADMIN . '</b>');
    $contents = array('form' => zen_draw_form('edit_admin', FILENAME_ADMIN, zen_get_all_get_params(array('action','adminID')) . 'adminID=' . $admin_info->admin_id.'&action=save', 'post', 'enctype="multipart/form-data"'));
    $contents[] = array('text' => TEXT_EDIT_INTRO);
    $contents[] = array('text' => '<br><b>' . $admin_info->admin_id . '</b>&nbsp;-&nbsp;' . $admin_info->admin_name . '</b>'.zen_draw_hidden_field('orgin_status', $admin_info->admin_status));
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_NAME . '<br>' . zen_draw_input_field('admin_name', $admin_info->admin_name, zen_set_field_length(TABLE_ADMIN, 'admin_name', $max=30) . ' readonly=readonly style="color: grey;"')  . '<br><span id="admin_name_tip" style="color:red;"></span>');
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_EMAIL . '<br>' . zen_draw_input_field('admin_email', $admin_info->admin_email, zen_set_field_length(TABLE_ADMIN, 'admin_email', $max=30) . ($admin_info->admin_status == 20 ? ' readonly=readonly style="color: grey;"' : '')) . '<br><span id="admin_email_tip" style="color:red;"></span>' );
    $contents[] = array('text' => '<br>账号类型</br>');
    $role_display_sql="SELECT role_id,role_name FROM ".TABLE_ADMIN_ROLE;
    $role_display=$db->Execute($role_display_sql);
    while(!$role_display->EOF){
        $role[] = "<option value=".$role_display->fields['role_id']." " . ($role_display->fields['role_id'] == $admin_info->role_id ? 'selected' : '') . ">--".$role_display->fields['role_name']."--</option>";
        $role_display->MoveNext();
    }
    if(isset($role)){
        $contents[] = array('text'=>"<select name='role_id' style='width: 185px;" . ($admin_info->admin_status == 20 ? 'background-color: #bdbbbb;' : '') . "' " . ($admin_info->admin_status == 20 ? '  onfocus="this.defOpt=this.selectedIndex" onchange="this.selectedIndex=this.defOpt;"' : '') . "><option value='NULL'>--请选择--</option>".implode(" ", $role)."</select>" . '<br><span id="admin_role_tip" style="color:red;"></span>');}
    else{
        $contents[] = array('text'=>"<select name='role_id' style='width: 185px;" . ($admin_info->admin_status == 20 ? 'background-color: #bdbbbb;' : '') . "' " . ($admin_info->admin_status == 20 ? '  onfocus="this.defOpt=this.selectedIndex" onchange="this.selectedIndex=this.defOpt;"' : '') . "><option value='NULL'>--请选择--</option></select>" . '<br><span id="admin_role_tip" style="color:red;"></span>');
    }
        $contents[] = array('text' => '<br>Show customer email address<br>' . '<input type="radio" name="admin_show_customer_email" value="1" '.($admin_info->admin_show_customer_email == 0 ? '' : 'checked').' ' . ($admin_info->admin_status == 20 ? ' onclick="return false"' : '') . '><span style="position: relative;top: -3px;margin-right: 10px;' . ($admin_info->admin_status == 20 ? 'color:grey;' : '') . '">true</span><input type="radio" name="admin_show_customer_email" value="0" '.($admin_info->admin_show_customer_email == 0 ? 'checked' : '') . ' ' . ($admin_info->admin_status == 20 ? ' onclick="return false"' : '') . ' ><span style="position: relative;top: -3px;margin-right: 10px;' . ($admin_info->admin_status == 20 ? 'color:grey;' : '') . '">false</span>' . '<br><span id="admin_show_email_tip" style="color:red;"></span>');
        $contents[] = array('text' => '<br>Account Status<br>' . '<input type="radio" name="admin_status" value="10" '.($admin_info->admin_status == 20 ? '' : 'checked').' ><span style="position: relative;top: -3px;margin-right: 10px;">启用</span><input type="radio" name="admin_status" value="20" '.($admin_info->admin_status == 20 ? 'checked' : '').' ><span style="position: relative;top: -3px;margin-right: 10px;">禁用</span>' . '<br><span id="admin_status_tip" style="color:red;"></span>');
    $admin_current = $db->Execute("select admin_level from " . TABLE_ADMIN . " where admin_id='" . $_SESSION['admin_id'] . "'");
    /*
    if ($admin_current->fields['admin_level'] == '1') {
      $contents[] = array('text' => '<br>' . TEXT_ADMIN_LEVEL_INSTRUCTIONS);
      $contents[] = array(
    	  'text' => '<strong>' . TEXT_ADMINS_LEVEL . '</strong><br>' . zen_draw_input_field('admin_level', $admin_info->admin_level, zen_set_field_length(TABLE_ADMIN, 'admin_level'))
      );
    */
      $demo_status= zen_get_configuration_key_value('ADMIN_DEMO');
      switch ($demo_status) {
        case '0': $on_status = false; $off_status = true; break;
        case '1': $on_status = true; $off_status = false; break;
        default:  $on_status = false; $off_status = true; break;
      }
      if ($on_status == true) {
        $contents[] = array('text' => '<br>' . TEXT_ADMIN_DEMO);
        $contents[] = array('text' => '<strong>' . TEXT_DEMO_STATUS . '</strong><br>' . zen_draw_radio_field('demo_status', '1', $on_status) . '&nbsp;' . TEXT_DEMO_ON . '&nbsp;' . zen_draw_radio_field('demo_status', '0', $off_status) . '&nbsp;' . TEXT_DEMO_OFF);
      } else {
        $contents[] = array('text' => zen_draw_hidden_field('demo_status', 0) );
      }
    $button_sql="SELECT id,page FROM ".TABLE_ADMIN_FILES. " WHERE page='authorization_button'";
    $button=$db->Execute($button_sql);
    $show_botton_sql = "SELECT * FROM ".TABLE_ADMIN_ALLOWED." WHERE page_id = ".$button->fields['id']. " AND admin_id = '".$_SESSION['admin_id']."'";
    $privilege_management=$db->Execute($show_botton_sql);
    if(!$privilege_management->EOF){
    $contents[] = array('align' => 'center',
          'text' =>'<br><input type="button" ' . ($admin_info->admin_status == 20 ? ' style="color: grey;"' : '') . ' value="权限管理"' . 'onclick=' . ($admin_info->admin_status == 20 ? '"return false;"' : '"location=\'' . zen_href_link('admin_control','adminID=' . $admin_info->admin_id).'\'"') . '>');
    } 
    
    $contents[] = array('align' => 'center',
        'text' =>zen_image_submit('button_save.gif', IMAGE_SAVE, '') . '<a href="' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action'))) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
  
//-------------------------------------------------------------------------------------------------------------------------
  case 'resetpassword':
    $heading[] = array('text' => '<b>' . TEXT_HEADING_RESET_PASSWORD . '</b>');
    $contents = array('form' => zen_draw_form('reset_password', FILENAME_ADMIN, zen_get_all_get_params(array('action','adminID')) . 'adminID=' . $admin_info->admin_id. '&action=reset',
                      'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('admin_name', $admin_info->admin_name) . zen_draw_hidden_field('admin_email', $admin_info->admin_email) . zen_draw_hidden_field('admin_level', $admin_info->admin_level));
    $contents[] = array('text' => TEXT_EDIT_INTRO);
    $contents[] = array('text' => '<br><b>' . $admin_info->admin_id . '</b>&nbsp;-&nbsp;' . $admin_info->admin_name . '</b>');
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_PASSWORD . '<br>' . zen_draw_password_field('password_new', '', zen_set_field_length(TABLE_ADMIN, 'admin_pass', $max=25)) );
    $contents[] = array('text' => '<br>' . TEXT_ADMINS_CONFIRM_PASSWORD . '<br>' . zen_draw_password_field('password_confirmation', '', zen_set_field_length(TABLE_ADMIN, 'admin_pass', $max=25)) );
    $contents[] = array('align' => 'center',
        'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '<a href="' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action'))) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
  
  
/*-------------------------------------------------------------------------------------------------------------------------
    case 'delete':
    $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_ADMIN . '</b>');
    $contents = array('form' => zen_draw_form('delete_admin', FILENAME_ADMIN, 'page=' . $_GET['page'] . '&adminID=' . $admin_info->admin_id . '&action=deleteconfirm'));
    $contents[] = array('text' => TEXT_DELETE_INTRO);
    $contents[] = array('text' => '<br><b>' . $admin_info->admin_name . '</b>');
    $contents[] = array('align' => 'center',
                        'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '<a href="' . zen_href_link(FILENAME_ADMIN, 'page=' . $_GET['page'] . '&adminID=' . $admin_info->admin_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
  
*/
  default:
//-------------------------------------------------------------------------------------------------------------------------
    if (isset($admin_info) && is_object($admin_info)) {
    	$heading[] = array('text' => '<b>' . $admin_info->admin_name . '</b>');
    	$contents[] = array('align' => 'center',
    	    'text' => '<a href="' . zen_href_link(FILENAME_ADMIN,  zen_get_all_get_params(array('action','adminID')) . 'adminID=' . $admin_info->admin_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a><a href="' . zen_href_link(FILENAME_ADMIN, zen_get_all_get_params(array('action','adminID')) . 'adminID=' . $admin_info->admin_id . '&action=resetpassword') . '">' . zen_image_button('button_reset_pwd.gif', IMAGE_RESET) . '</a>');
    }
    
    break;
//-------------------------------------------------------------------------------------------------------------------------
} // end switch action

if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
  echo '<td width="25%" valign="top">' . "\n";
  $box = new box;
  echo $box->infoBox($heading, $contents);
  echo '</td>' . "\n";
}
?>

	</tr>
</table>


		</td>
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
