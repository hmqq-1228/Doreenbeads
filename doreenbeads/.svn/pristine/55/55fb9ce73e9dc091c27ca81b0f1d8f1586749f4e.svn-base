<?php
/**
 * @package Admin Profiles
 * @copyright Copyright 2006-2010 Kuroi Web Design
 * @copyright Portions Copyright 2003 Zen Cart Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: admin_control.php 362 2010-05-23 19:02:04Z kuroi $
 */

require('includes/application_top.php');

$admin_id = zen_db_prepare_input($_GET['adminID']);

$header_checked=$db->Execute("SELECT * FROM ".TABLE_ADMIN_VISIBLE_HEADERS." WHERE admin_id = '".$admin_id."'");
$page_checked=$db->Execute("SELECT * FROM ".TABLE_ADMIN_ALLOWED." WHERE admin_id = ".$admin_id);
if($header_checked->EOF && $page_checked->EOF){
    //该用户须继承角色的权限
    //导航栏权限
    $role_header_sql=
    'SELECT a.admin_id,rh.header_id FROM '. TABLE_ADMIN .' AS a JOIN '. TABLE_ADMIN_ROLE_HEADER_PRIVILEGE.
    ' AS rh ON a.role_id=rh.role_id WHERE a.admin_id='.$admin_id;
    $role_header=$db->Execute($role_header_sql);
    $allowed_header_sql='SELECT header_id,admin_id FROM '. TABLE_ADMIN_VISIBLE_HEADERS .' WHERE admin_id='.$admin_id;
    $allowed_header=$db->Execute($allowed_header_sql);
    while(!$allowed_header->EOF){
        $result_allowed_header[]=$allowed_header->fields;
        $allowed_header->MoveNext();
    }

    while(!$role_header->EOF){
        if (in_array($role_header->fields,$result_allowed_header)){ //防止重复添加
            $role_header->MoveNext();
        }else{
            $new_header_allowed_sql = "INSERT INTO ".TABLE_ADMIN_VISIBLE_HEADERS." SET header_id = ".$role_header->fields['header_id'].", admin_id = :adminId:";
            $new_header_allowed_sql = $db->bindVars($new_header_allowed_sql, ':adminId:', $admin_id, 'integer');
            $db->Execute($new_header_allowed_sql);
            $role_header->MoveNext();
        }
    }
    //页面权限
    $role_page_sql=
    'SELECT a.admin_id,rp.page_id FROM '. TABLE_ADMIN .' AS a JOIN '. TABLE_ADMIN_ROLE_PAGE_PRIVILEGE.
    ' AS rp ON a.role_id=rp.role_id WHERE a.admin_id='.$admin_id;
    $role_page=$db->Execute($role_page_sql);
    $allowed_pages_sql='SELECT page_id,admin_id FROM '. TABLE_ADMIN_ALLOWED .' WHERE admin_id='.$admin_id;
    $allowed_pages=$db->Execute($allowed_pages_sql);
    while(!$allowed_pages->EOF){
        $result_allowed_pages[]=$allowed_pages->fields;
        $allowed_pages->MoveNext();
    }

    while(!$role_page->EOF){
        if (in_array($role_page->fields,$result_allowed_pages)){
            $role_page->MoveNext();
        }else{
            $new_page_allowed_sql = "INSERT INTO ".TABLE_ADMIN_ALLOWED." SET page_id = ".$role_page->fields['page_id'].", admin_id = :adminId:";
            $new_page_allowed_sql = $db->bindVars($new_page_allowed_sql, ':adminId:', $admin_id, 'integer');
            $db->Execute($new_page_allowed_sql);
            $role_page->MoveNext();
        }
    }
}

if ($_GET['action'] == 'save'){ // if changes to adminID's profile are being saved

  // This section updates the dB as menu headers are turned on and off for this adminID
  $headers = $db->Execute("SELECT * FROM ".TABLE_ADMIN_MENU_HEADERS);
  while (!$headers->EOF){
    $field = $_POST[$headers->fields['header']];
    $sql = "SELECT * FROM ".TABLE_ADMIN_VISIBLE_HEADERS." WHERE header_id = ".$headers->fields['id']." AND admin_id = '".$admin_id."'";
    $althere = $db->Execute($sql);
    if ($field == 'on' || $field == 'off'){
      if ($althere->fields['header_id'] == '') {
        $sql = "INSERT INTO ".TABLE_ADMIN_VISIBLE_HEADERS." SET header_id = ".$headers->fields['id'].", admin_id = :adminId:";
        $sql = $db->bindVars($sql, ':adminId:', $admin_id, 'integer');
        $db->Execute($sql);
      }
    } else {
      if ($althere->fields['header_id'] != '') {
        $sql = "DELETE FROM ".TABLE_ADMIN_VISIBLE_HEADERS." WHERE header_id = ".$headers->fields['id']." AND admin_id = '".$admin_id."'";
        $db->Execute($sql);
      }
    }
    $headers->MoveNext();
  }

  // This section updates the dB for those pages who are being allowed or disallowed for adminID
  $pages = $db->Execute("SELECT * FROM ".TABLE_ADMIN_FILES);
  while (!$pages->EOF){
    $field = '';
    $field = $_POST[str_replace(' ', '_', $pages->fields['page'])];
    $sql = "SELECT * FROM ".TABLE_ADMIN_ALLOWED." WHERE page_id = ".$pages->fields['id']." AND admin_id = ".$admin_id;
    $althere = $db->Execute($sql);
    if ($field == 'on' || $field == 'off') {
      if ($althere->fields['page_id'] == '') {
        $sql = "INSERT INTO ".TABLE_ADMIN_ALLOWED." SET page_id = ".$pages->fields['id'].", admin_id = :adminId:";
        $sql = $db->bindVars($sql, ':adminId:', $admin_id, 'integer');
        $db->Execute($sql);
      }
    } else {
      if ($althere->fields['page_id'] != '') {
        $sql = "DELETE FROM ".TABLE_ADMIN_ALLOWED." WHERE page_id = '".$pages->fields['id']."' AND admin_id = '".$admin_id."'";
        $db->Execute($sql);
      }
    }
  $pages->MoveNext();
  }

  // reload page to display showing the revised user profile
  zen_redirect(zen_href_link(FILENAME_ADMIN_CONTROL, 'adminID='.$admin_id, 'SSL'));

} else {

 // read user name to display in Admin Profiles header
  $admin = $db->Execute("SELECT admin_name FROM " . TABLE_ADMIN . " WHERE admin_id = " . $admin_id);

  // read in list of all valid menu headers from dB ex. 3rd party mods and display headers and checkboxes for their pages
  $headers_defined = $db->Execute("SELECT * FROM " . TABLE_ADMIN_MENU_HEADERS . " WHERE id > 0 order by id");

  // read in name of header for 3rd party mods and display checkboxes for any relevant pages
  $headers_undefined = $db->Execute("SELECT * FROM " . TABLE_ADMIN_MENU_HEADERS . " WHERE id = 0");

// Display page allowing updates to user profiles
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
  <div id="profileName"><?php echo sprintf(HEADING_TITLE, $admin->fields['admin_name']) ?></div>
  <div id="profileFunctions"><a href="<?php echo zen_href_link(FILENAME_ADMIN)?>"><?php echo TEXT_UPDATE_MORE_USERS ?></a></div>
</div>
<?php echo zen_draw_form('profileBoxes', FILENAME_ADMIN_CONTROL, 'adminID=' . $admin_id . '&amp;action=save', 'post', 'id="profileBoxes"', 'true'); ?>
<div class="formButtons"><input type="submit" value="<?php echo BUTTON_TEXT_SAVE ?>"><input type="reset" value="<?php echo BUTTON_TEXT_CANCEL ?>"></div>

<?php
  display_profiles($headers_defined, $admin_id);
  display_profiles($headers_undefined, $admin_id);
?>

<p id="subPage"><?php echo TEXT_SUBPAGE_EXPLANATION ?></p>
<div class="formButtons"><input type="submit" value="<?php echo BUTTON_TEXT_SAVE ?>"><input type="reset" value="<?php echo BUTTON_TEXT_CANCEL ?>"></div>
</form>
</body>
</html>
<?php } ?>