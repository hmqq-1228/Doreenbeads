<?php
include('includes/application_top.php');

$sql="select customers_info_avatar from ".TABLE_CUSTOMERS_INFO." where customers_info_id=".$_SESSION['customer_id']." ";
$res=$db->Execute($sql);
echo DIR_WS_USER_AVATAR.$res->fields['customers_info_avatar'];



