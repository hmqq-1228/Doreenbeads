<?php
require('includes/application_top.php');

$role_id = zen_db_prepare_input($_GET['role_id']);
$sql_del = "delete from ".TABLE_ADMIN_ROLE." where role_id =".$role_id;
$result_del = $db->Execute($sql_del);
echo 'success';