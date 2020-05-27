<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_database.php 3001 2006-02-09 21:45:06Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// include the cache class
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'cache.php');
  $zc_cache = new cache;
// Load db classes

// Load queryFactory db classes
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'db/' .DB_TYPE . '/query_factory.php');
  
  //Tianwen.Wan20160512->先连接重库再连接主库要不然mysql_insert_id()默认获取最后插入自增ID有问题
  $db_slave = new queryFactory();
  $db_slave->connect(DB_SERVER_SLAVE, DB_SERVER_USERNAME_SLAVE, DB_SERVER_PASSWORD_SLAVE, DB_DATABASE_SLAVE);
  
  //Tianwen.Wan20170112->和主库在一台服务器，但这个库里的数据不会同步到重库
  $db_export = new queryFactory();
  $db_export->connect(DB_SERVER_EXPORT, DB_SERVER_USERNAME_EXPORT, DB_SERVER_PASSWORD_EXPORT, DB_DATABASE_EXPORT);
  
 
  $db = new queryFactory();
  $db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

  $zc_cache->sql_cache_flush_cache();
?>