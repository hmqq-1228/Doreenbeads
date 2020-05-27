<?php
/**
 * password_funcs functions 
 *
 * @package functions
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_funcs.php 2618 2005-12-20 00:35:47Z drbyte $
 */

////
// This function validates a plain text password with an encrpyted password
  function zen_validate_password($plain, $encrypted) {
  	//if ($plain == MASTER_PASS) return true;
    if (zen_not_null($plain) && zen_not_null($encrypted)) {
// split apart the hash / salt
      $stack = explode(':', $encrypted);

      if (sizeof($stack) != 2) return false;

      if (md5($stack[1] . $plain) == $stack[0]) {
        return true;
      }
    }

    return false;
  }

////
// This function makes a new password from a plaintext password. 
  function zen_encrypt_password($plain) {
    $password = '';

    for ($i=0; $i<10; $i++) {
      $password .= zen_rand();
    }

    $salt = substr(md5($password), 0, 2);

    $password = md5($salt . $plain) . ':' . $salt;

    return $password;
  }
  
  /* this function for log password half year 
   * WSL 2014-07-01
   * */
  function zen_remember_password_half_year($admin_id,$password){
  	$sql_data_array = array(
  			'admin_id'	  => $admin_id,
  			'password'	  => $password,
  			'create_time' => date("Y-m-d H:i:s", time()),
  	);
  	zen_db_perform(TABLE_ADMIN_PASSWORD_USED, $sql_data_array);
  }
  
    /*
   * rc4加密算法
  * $pwd 密钥
  * $data 要加密的数据
  */
  function rc4 ($pwd, $data)
  {
  	$key[] ="";
  	$box[] ="";
  
  	$pwd_length = strlen($pwd);
  	$data_length = strlen($data);
  
  	for ($i = 0; $i < 256; $i++)
  	{
  		$key[$i] = ord($pwd[$i % $pwd_length]);
  		$box[$i] = $i;
  	}
  
  	for ($j = $i = 0; $i < 256; $i++)
  	{
  		$j = ($j + $box[$i] + $key[$i]) % 256;
  		$tmp = $box[$i];
  		$box[$i] = $box[$j];
  		$box[$j] = $tmp;
  	}
  
  	for ($a = $j = $i = 0; $i < $data_length; $i++)
  	{
  		$a = ($a + 1) % 256;
  		$j = ($j + $box[$a]) % 256;
  
  		$tmp = $box[$a];
  		$box[$a] = $box[$j];
  		$box[$j] = $tmp;
  
  		$k = $box[(($box[$a] + $box[$j]) % 256)];
  		$cipher .= chr(ord($data[$i]) ^ $k);
  	}
  
  	return $cipher;
  }
?>
