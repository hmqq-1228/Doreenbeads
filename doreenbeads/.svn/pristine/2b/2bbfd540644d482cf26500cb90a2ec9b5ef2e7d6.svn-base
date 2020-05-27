<?php
require('includes/application_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');

if (zen_not_null($action)) {
    
    if (isset($_GET['role_id'])) {$roles_id = zen_db_prepare_input($_GET['role_id']);}
    $role_name = trim(zen_db_prepare_input($_POST['role_name']));
    $sql_data_array = array(
        'role_name' => $role_name,
        'modify_admin' => zen_db_input($_SESSION['admin_id']),
		'modify_datetime' => 'now()'        
    );
    
    switch ($action) {
        case 'insert': 
            if($sql_data_array['role_name']=='')
            {
                zen_redirect(zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, (isset($_GET['role_id']) ? $_GET['role_id'] : '')));
            }
            $insert_sql_data = array('create_admin' => zen_db_input($_SESSION['admin_id']), 'create_datetime'=>'now()');
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);           
            zen_db_perform(TABLE_ADMIN_ROLE, $sql_data_array);
            $roles_id = zen_db_insert_id();
            zen_redirect(zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, (isset($_GET['role_id']) ? $_GET['role_id'] : '')));
            
            
        case 'save':
            if($sql_data_array['role_name']=='')
            { 
                zen_redirect(zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, (isset($_GET['role_id']) ? $_GET['role_id'] : '')));
            }
            zen_db_perform(TABLE_ADMIN_ROLE, $sql_data_array, 'update', "role_id = '" . (int)$roles_id . "'");
            zen_redirect(zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, (isset($_GET['role_id']) ? $_GET['role_id'] : '')));            
            break;
    }
}
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
$(function(){	
	$(".delete").click(function(){		
		var statu = confirm("禁用后该促销版本会在前台页面隐藏,是否删除该角色");
		if(!statu){
		    	return false;
		}
		else{
    		var role_id = $(this).find(':input').val();
    		$.ajax({
    		    type:'GET',
    		    url:'ajax_role_delete.php',
    		    data: 'role_id='+role_id,
    		    success:function(msg){
				if(msg=='success'){	
    			}else{
					alert('删除失败');
        			}
				  }			
			  });
    				alert('已删除');
		   }
		});
	$("input[name='role_name']").hover(function(){
		var rolename = $("input[name='role_name']").val();
    	$.ajax({
    	    type:'POST',
    	    url:'ajax_rolename_check.php',
    	    data:{rolename:rolename},
    	    success:function(msg){
  		    if(msg=='success'){	
    			$("input[name='role_name']").siblings().html("新角色可用");
    			$("input[type='image']").removeAttr("disabled");
    			$("input[name='role_name']").keypress(function(e){
                	if(e.keyCode==13){
                    return false;
            		}
    			});
    		}else{
    			$("input[name='role_name']").siblings().html("新角色不能为空或已存在");
    			$("input[type='image']").attr("disabled","disabled");
    			}
    	      }
    	  });
		});

	$("input[name='role_name']").blur(function(){
		var rolename = $("input[name='role_name']").val();
    	$.ajax({
    	    type:'POST',
    	    url:'ajax_rolename_check.php',
    	    data:{rolename:rolename},
    	    success:function(msg){
  		    if(msg=='success'){	
    			$("input[name='role_name']").siblings().html("新角色可用");
    			$("input[name!='role_name']").removeAttr("disabled");
    			$("input[name='role_name']").keypress(function(e){
                	if(e.keyCode==13){
                    return false;
            		}
    			}); 	
    		}else{	
    			$("input[name='role_name']").siblings().html("新角色不能为空或已存在");
    			$("input[name!='role_name']").attr("disabled","disabled");
    			}
    	      }
    	  });
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

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pageHeading"><?php echo '角色管理'; ?></td>
		<td align="right">
		</td>
	</tr>

</table>

<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr class="dataTableHeadingRow">
		<td width="10%" class="dataTableHeadingContent"><?php echo 'ID'; ?></td>
		<td width="35%" class="dataTableHeadingContent" align="center"><?php echo '角色名称'; ?></td>
		<td width="20%" class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
</tr>

<?php
$roles_query_raw = "select role_id, role_name from " . TABLE_ADMIN_ROLE .' order by role_id ASC';
$roles_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $roles_query_raw, $roles_query_numrows);
$roles = $db->Execute($roles_query_raw);
while (!$roles->EOF) {
  if ((!isset($_GET['role_id']) || (isset($_GET['role_id']) && ($_GET['role_id'] == $roles->fields['role_id']))) && !isset($role_info) && (substr($action, 0, 3) != 'new')) {
  	$role_info = new objectInfo($roles->fields);
  }
  
  if (isset($role_info) && is_object($role_info) && ($roles->fields['role_id'] == $role_info->role_id)) {
      echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, '&role_id=' . $roles->fields['role_id'] . '&action=edit') . '\'">' . "\n";
  } else {
      echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, 'role_id=' . $roles->fields['role_id'] . '') . '\'">' . "\n";
  }  
?>

		<td class="dataTableContent"><?php echo $roles->fields['role_id']; ?></td>
		<td class="dataTableContent" align="center"><?php echo $roles->fields['role_name']; ?></td>
		<td class="dataTableContent" align="right">
<?php echo '<a href="' . zen_href_link(FILENAME_ROLE_CONTROL, 'role_id=' . $roles->fields['role_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>
<span class="delete">
<?php echo zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE);?>
<?php echo zen_draw_hidden_field('roledelete',  $roles->fields['role_id']);?>
</span>
		</td>
</tr>

<?php
  $roles->MoveNext();
}
?>

	<tr>
		<td colspan="2">

<table border="0" width="100%" cellspacing="0" cellpadding="4">
	<tr>
		<td class="smallText" valign="top"><?php echo $roles_split->display_count($roles_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ROLES); ?></td>
		<td class="smallText" align="right"><?php echo $roles_split->display_links($roles_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],zen_get_all_get_params(array('page'))); ?></td>
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
  echo '<input type="button" value="Admin Setting"' . 'onclick="location=\'' . zen_href_link('admin').'\'"> &nbsp';
  echo '<input type="button" value="Insert"' . 'onclick="location=\'' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT,'role_id=' . $role_info->role_id . '&action=new').'\'"> &nbsp';
?>
		</td>
	</tr>
<?php
}
?>
</table>
		</td>

<?php
if(is_null($roles->fields)){
    $action='new';
}
$heading = array();
$contents = array();

switch ($action) {
//-------------------------------------------------------------------------------------------------------------------------

  case 'new':
    $heading[] = array('text' => '<b>添加新角色</b>');
    $contents = array('form' => zen_draw_form('new_role', FILENAME_PRIVILEGE_MANAGEMENT, 'action=insert', 'post', 'enctype="multipart/form-data"'));
    $contents[] = array('text' => '<br><b>角色名称</b><br>' . zen_draw_input_field('role_name', '', zen_set_field_length(TABLE_ADMIN_ROLE, 'role_name', $max=50)) );
    if(@in_array($_GET['role_id'],$roles->fields)){
    $contents[] = array('align' => 'center',
                        'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '<a href="' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT,'role_id=' . $_GET['role_id']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    }else{
        $contents[] = array('align' => 'center',
            'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '<a href="' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    }
   

  break;
  
//-------------------------------------------------------------------------------------------------------------------------
  case 'edit':
    $heading[] = array('text' => '<b>修改角色</b>');
    $contents = array('form' => zen_draw_form('edit_role', FILENAME_PRIVILEGE_MANAGEMENT,'role_id=' . $role_info->role_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
    $contents[] = array('text' => '<br><b>原角色:</b>&nbsp' . $role_info->role_id . '</b>&nbsp;-&nbsp;' . $role_info->role_name . '</b>');
    $contents[] = array('text' => '<br><b>新角色</b><br>' . zen_draw_input_field('role_name', $role_info->role_name, zen_set_field_length(TABLE_ADMIN_ROLE, 'role_name', $max=50)) );
    if(in_array($_GET['role_id'],$roles->fields)){
    $contents[] = array('align' => 'center',
                        'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '<a href="' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT,'role_id=' . $_GET['role_id']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    }else{
        $contents[] = array('align' => 'center',
            'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '<a href="' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    }
    
    break;

  default:
//-------------------------------------------------------------------------------------------------------------------------
    if (isset($role_info) && is_object($role_info)) {
    	$heading[] = array('text' => '<b>' . $role_info->role_name . '</b>');
    	$contents[] = array('align' => 'center',
                          'text' => '<a href="' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, 'role_id=' . $role_info->role_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a>');
    }else{
        if(!in_array($_GET['role_id'],$roles->fields)){
            $heading[] = array('text' => '<b>' . $roles->fields['role_name'] . '</b>');
            $contents[] = array('align' => 'center',
                'text' => '<a href="' . zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT, 'role_id=' . $roles->fields['role_id'] . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a>');
        }
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