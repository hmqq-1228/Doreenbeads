<?php
  define('DB_PREFIX_SHAREACCOUNT', 'zen_');
  define('DB_SERVER_SHAREACCOUNT', '192.168.3.167');
  $db_user_array_shareaccount[] = '8season_user1';
  $db_user_array_shareaccount[] = '8season_user2';
  $db_user_array_shareaccount[] = '8season_user3';
  $db_user_array_shareaccount[] = '8season_user4';
  $db_user_array_shareaccount[] = '8season_user5';
  $db_user_shareaccount = array_rand($db_user_array_shareaccount);
  define('DB_SERVER_USERNAME_SHAREACCOUNT', 'root');
  define('DB_SERVER_PASSWORD_SHAREACCOUNT', 'pan195013');
  define('DB_DATABASE_SHAREACCOUNT', '8seasons_20160126');
  define('USE_PCONNECT_SHAREACCOUNT', 'false');