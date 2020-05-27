<?php
if (!session_id()) session_start();
include('conf.php');

$step = $_GET['step'] ? $_GET['step'] : ($_POST['step'] ? $_POST['step'] : '');
$action = $_GET['action'] ? $_GET['action'] : ($_POST['action'] ? $_POST['action'] : '');

if((! isset($_SESSION['userid']) || $_SESSION['userid'] == '') && $action != 'login'){
	$gotoLogin = true;
}else{
	if($step != '' && $step != $steps[0] && !$_SESSION['SLT'])
		header('Location: index.php?step='.$steps[0]);

	if($action != ''){
		if(file_exists('ajax_'.$action.'.php')){
			header("Content-type: text/html; charset=utf-8"); 
			include('ajax_'.$action.'.php');
			exit;
		}else{
			header('Location: index.php?step='.$steps[0]);
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EDM 生成</title>
	<script language="JavaScript" src="lib/js/jquery-1.9.1.js"></script>
	<script language="JavaScript" src="lib/js/jquery.form.js"></script>
	<script language="JavaScript" src="lib/js/jquery-ui-1.10.3.custom.js"></script>
	<script language="JavaScript" src="lib/js/main.js"></script>
	<link rel="stylesheet" href="lib/css/jquery-ui-1.10.3.custom.css" />
	<link rel="stylesheet" href="lib/css/main.css" />
<?php
if($step != '' && file_exists('step'.$step.'.php')){
	if(file_exists('lib/js/step'.$step.'_js.js'))
		echo '<script language="JavaScript" src="lib/js/step'.$step.'_js.js"></script>';
	if(file_exists('lib/css/step'.$step.'_css.css'))
		echo '<link rel="stylesheet" href="lib/css/step'.$step.'_css.css" />';
}
?>
</head>
<body>
<div class="main">
<?php
if($gotoLogin){
	include('login.php');
}else{
	echo '<div style="text-align:right">Welcome, '.$_SESSION['username'].'. <a href="index.php?action=login&type=logout">Logout</a></div>';
	if($step != '' && file_exists('step'.$step.'.php')){
		if($step >= $steps[0] && $step <= $steps[1]){
			echo '<div class="nav">';
			if($step > $steps[0])
				echo '<a href="index.php?step='.($step-1).'">上一步</a> ';
			else
				echo '<a href="javascript:void(0)"></a> ';
			echo '<a href="index.php">返回首页</a> ';
			if($step < $steps[1])
				echo '<a href="index.php?step='.($step+1).'">下一步</a>';
			else
				echo '<a href="javascript:void(0)"></a> ';
			echo "</div>";
		}

		include('step'.$step.'.php');
	}else{
?>
	<div class="mainpage">
		<a href="index.php?step=1">Step1: 设置</a>
		<a href="index.php?step=2">Step2: 获取产品数据</a>
		<a href="index.php?step=3">Step3: 生成图片地址</a>
		<a href="index.php?step=4">Step4: 生成HTMLL</a>
	</div>
<?php
	}
}
?>
</div>
</body>
</html>