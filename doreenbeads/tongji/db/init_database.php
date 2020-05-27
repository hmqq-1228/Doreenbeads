<?php
defined ( 'IS_ADMIN_FLAG' ) or die ( 'Illegal Access' );
$db = new queryFactory ();
$db->connect ( 'localhost', 'root', '1159547578xx', 'test', 'false', false ) or die('连接数据库失败!');
?>