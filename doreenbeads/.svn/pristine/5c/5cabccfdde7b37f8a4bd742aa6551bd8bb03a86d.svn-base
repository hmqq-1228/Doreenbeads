<?php
require('includes/application_top.php');
$rolename=trim($_POST['rolename']);
$rolechecksql="SELECT role_id,role_name FROM ".TABLE_ADMIN_ROLE." WHERE role_name='".$rolename."'";
$rolecheck=$db->Execute($rolechecksql);
if(!$rolecheck->EOF || $rolename==''){
    echo 'false';
}else{
    echo 'success';
}