<?php
/**
* deal with login & logout
* author: lvxiaoyong 20140307
* version: 1.0
*/

if($_GET['type'] == 'login'){
	$username = htmlspecialchars($_POST['username']);
	$password = md5($_POST['password']);
	$auth = md5(strtolower($_POST['auth']));

	if($_SESSION['auth_num'] != $auth){
		echo '0|Auth number is wrong!';
		exit;
	}

	$oldDir = dirname(__FILE__);
//	$root_str = 'root_8seasons';
//	chdir($$root_str);	//	important!!!
	chdir('..');		//	important!!!
	define('IS_ADMIN_FLAG',false);
	include('includes/configure.php');
	include('includes/classes/class.base.php');
	include('includes/classes/db/mysql/query_factory.php');
	global $db;
	if(! is_object($db)){
		$db = new queryFactory();
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, '', false);
	}
	if(!$db){
		echo '0|ERROR: Could not connect to the database.';
		exit;
	}
	chdir($oldDir);		//	important!!!

	$result = $db->Execute('select user_id from '.DB_PREFIX.'edmuser where user_name="'.$username.'" and user_pass="'.$password.'" limit 1');
	if($result->RecordCount() <= 0){
		echo '0|Login error! Please check your username or password and retry~';
	}else{
		$_SESSION['userid'] = $result->fields['user_id'];
		$_SESSION['username'] = $username;
		echo '1|index.php';
	}
}else if($_GET['type'] == 'logout'){
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	header('Location: index.php');
}else{
	echo '0|Access Denied!';
}
?>