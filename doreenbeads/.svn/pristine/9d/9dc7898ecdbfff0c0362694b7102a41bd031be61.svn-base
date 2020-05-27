<?php
/**
* set the session, header to the next step;
* author: lvxiaoyong 20140221
* version: 1.0
*/

//$site = trim($_POST['site']);
$site = trim($_SESSION['site']);
$lang = intval(trim($_POST['lang']));
$type = trim($_POST['type']);

if($site == '' || $lang == '' || $type == ''){
	$_SESSION['SLT'] = '';
	header('Location: index.php?step='.$steps[0]);
}else{
	$_SESSION['site'] = $site;		//	eg. 8seasons
	$_SESSION['lang'] = $lang;		//	eg. 1
	$_SESSION['type'] = $type;		//	eg. normal
	$_SESSION['SLT'] = $site.'_'.$langArr[$lang].'_'.$type;	//	eg. 8seasons_en_normal
	header('Location: index.php?step='.($steps[0]+1));
}
?>