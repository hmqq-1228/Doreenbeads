<?php
require('includes/application_top.php');

$role_id = zen_db_prepare_input($_GET['role_id']);

if(!is_numeric($role_id)){zen_redirect(zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT));}
$role_id_check=$db->Execute("SELECT * FROM ".TABLE_ADMIN_ROLE." WHERE role_id = ".$role_id);
if($role_id_check->EOF){zen_redirect(zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT));}

if ($_GET['action'] == 'save'){

  $headers = $db->Execute("SELECT * FROM ".TABLE_ADMIN_MENU_HEADERS);
  while (!$headers->EOF){
    $admin_id_sql="SELECT admin_id FROM ".TABLE_ADMIN." WHERE role_id=".$role_id;
    $admin_id=$db->Execute($admin_id_sql);
    $field = $_POST[$headers->fields['header']];
    $sql = "SELECT * FROM ".TABLE_ADMIN_ROLE_HEADER_PRIVILEGE." WHERE header_id = ".$headers->fields['id']." AND role_id = '".$role_id."'";
    $althere = $db->Execute($sql);
    if ($field == 'on' || $field == 'off'){
      if ($althere->fields['header_id'] == '') {
        $sql = "INSERT INTO ".TABLE_ADMIN_ROLE_HEADER_PRIVILEGE." SET modify_admin=".$_SESSION['admin_id'].",modify_datetime=now(),header_id = ".$headers->fields['id'].", role_id = :role_id:";        
        $sql = $db->bindVars($sql, ':role_id:', $role_id, 'integer');
        $db->Execute($sql);
      }
    } else {
      if ($althere->fields['header_id'] != '') {
        $sql = "DELETE FROM ".TABLE_ADMIN_ROLE_HEADER_PRIVILEGE." WHERE header_id = ".$headers->fields['id']." AND role_id = '".$role_id."'";
        $db->Execute($sql);
      }
    } 
    $headers->MoveNext();
  }

  $pages = $db->Execute("SELECT * FROM ".TABLE_ADMIN_FILES);
  while (!$pages->EOF){
    $admins_id_sql="SELECT admin_id FROM ".TABLE_ADMIN." WHERE role_id=".$role_id;
    $admins_id=$db->Execute($admin_id_sql);
    $field = '';
    $field = $_POST[str_replace(' ', '_', $pages->fields['page'])];
    $sql = "SELECT * FROM ".TABLE_ADMIN_ROLE_PAGE_PRIVILEGE." WHERE page_id = ".$pages->fields['id']." AND role_id = ".$role_id;
    $althere = $db->Execute($sql);
    if ($field == 'on' || $field == 'off') {
      if ($althere->fields['page_id'] == '') {                     
        $sql = "INSERT INTO ".TABLE_ADMIN_ROLE_PAGE_PRIVILEGE." SET  modify_admin=".$_SESSION['admin_id'].",modify_datetime=now(),page_id = ".$pages->fields['id'].", role_id = :role_id:";
        $sql = $db->bindVars($sql, ':role_id:', $role_id, 'integer');
        $db->Execute($sql);
      }
    } else {
      if ($althere->fields['page_id'] != '') {

        $sql = "DELETE FROM ".TABLE_ADMIN_ROLE_PAGE_PRIVILEGE." WHERE page_id = '".$pages->fields['id']."' AND role_id = '".$role_id."'";
        $db->Execute($sql);
      }
    }
  $pages->MoveNext();
  }
  
  //用户权限更新
  $admin_id_sql="SELECT admin_id FROM ".TABLE_ADMIN." WHERE role_id=".$role_id;
  $admin_id=$db->Execute($admin_id_sql);
  while(!$admin_id->EOF){
      $header = $db->Execute("SELECT * FROM ".TABLE_ADMIN_MENU_HEADERS);
      while (!$header->EOF){
          $header_name=$header->fields['header'];
          $field = $_POST[$header_name];
          $hd_sql = "SELECT * FROM ".TABLE_ADMIN_VISIBLE_HEADERS." WHERE header_id = ".$header->fields['id']." AND admin_id =".$admin_id->fields['admin_id'];
          $hd_althere = $db->Execute($hd_sql);
          if ($field == 'on' || $field == 'off'){
              if ($hd_althere->fields['header_id'] == '') {
                  $hd_add=array(
                      'header_id'=>$header->fields['id'],
                      'admin_id'=>$admin_id->fields['admin_id']
                  );                 
                  zen_db_perform ( TABLE_ADMIN_VISIBLE_HEADERS, $hd_add );
                }
           }else {
              if($hd_althere->fields['header_id'] != '') {
                  $hd_delete_sql = "DELETE FROM ".TABLE_ADMIN_VISIBLE_HEADERS." WHERE header_id = ".$header->fields['id']." AND admin_id =".$admin_id->fields['admin_id'];
                  $db->Execute($hd_delete_sql);
              }
           }
          $header->MoveNext();
      }
      
      
      $page = $db->Execute("SELECT * FROM ".TABLE_ADMIN_FILES);
       while (!$page->EOF){
             $fieldname = str_replace(' ', '_', $page->fields['page']);
             $fields = $_POST[$fieldname];
             $pg_sql = "SELECT * FROM ".TABLE_ADMIN_ALLOWED." WHERE page_id = ".$page->fields['id']." AND admin_id = ".$admin_id->fields['admin_id'];
             $pg_althere = $db->Execute($pg_sql);
           if ($fields == 'on' || $fields == 'off') {
               if ($pg_althere->fields['page_id'] == '') {
                  $pg_add=array(
                      'page_id'=>$page->fields['id'],
                      'admin_id'=>$admin_id->fields['admin_id']
                  );                 
                  zen_db_perform ( TABLE_ADMIN_ALLOWED, $pg_add );
                }
           } else {
              if ($pg_althere->fields['page_id'] != '') {
                  $pg_delete_sql = "DELETE FROM ".TABLE_ADMIN_ALLOWED." WHERE page_id = ".$page->fields['id']." AND admin_id = ".$admin_id->fields['admin_id'];
                  $db->Execute($pg_delete_sql);
              }
           }
           $page->MoveNext();
      }     
      $admin_id->MoveNext();
  }
  
  
  
  
 zen_redirect(zen_href_link(FILENAME_ROLE_CONTROL, 'role_id='.$role_id, 'SSL'));

} else {

  $role = $db->Execute("SELECT role_name FROM " . TABLE_ADMIN_ROLE . " WHERE role_id = " . $role_id);


  $headers_defined = $db->Execute("SELECT * FROM " . TABLE_ADMIN_MENU_HEADERS . " WHERE id > 0 order by id");


  $headers_undefined = $db->Execute("SELECT * FROM " . TABLE_ADMIN_MENU_HEADERS . " WHERE id = 0");


?><!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<link rel="stylesheet" type="text/css" href="includes/admin_profiles.css">
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript">
<!--
function init(){
  cssjsmenu('navbar');
  if (document.getElementById){
    var kill = document.getElementById('hoverJS');
    kill.disabled = true;
  }
}

function checkAll(form,header,value){
  for (var i = 0; i < form.elements.length; i++){
      if (form.elements[i].className == header){
      form.elements[i].checked = value;
    }
  }
}
// -->
</script>
</head>
<body onLoad="init()">
<?php
require(DIR_WS_INCLUDES . 'header.php');

?>

<div id="profileHeader">
  <div id="profileName"><?php echo sprintf(HEADING_TITLE, $role->fields['role_name']) ?></div>
  <div id="profileFunctions"><a href="<?php echo zen_href_link(FILENAME_PRIVILEGE_MANAGEMENT)?>"><?php echo TEXT_UPDATE_MORE_USERS ?></a></div>
</div>
<?php echo zen_draw_form('profileBoxes', FILENAME_ROLE_CONTROL, 'role_id=' . $role_id . '&amp;action=save', 'post', 'id="profileBoxes"', 'true'); ?>
<div class="formButtons"><input type="submit" value="<?php echo BUTTON_TEXT_SAVE ?>"><input type="reset" value="<?php echo BUTTON_TEXT_CANCEL ?>"></div>

<?php
  display_role_profiles($headers_defined, $role_id);
  display_role_profiles($headers_undefined, $role_id);
?>

<p id="subPage"><?php echo TEXT_SUBPAGE_EXPLANATION ?></p>
<div class="formButtons"><input type="submit" value="<?php echo BUTTON_TEXT_SAVE ?>"><input type="reset" value="<?php echo BUTTON_TEXT_CANCEL ?>"></div>
</form>
</body>
</html>
<?php } ?>