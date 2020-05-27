<?php
$prev_page = @trim($_GET['nddbc_page']);
if(!empty($prev_page)) {
	$prev_page = @urldecode($prev_page);
}

//Tianwen.Wan20161102->一分钟内跳转有效
$prev_unix = @intval($_GET['nddbc_unix']);
require ('includes/application_top.php');
$prev_page_full_info = sprintf(TEXT_NDDBC_INFO, sprintf(TEXT_NDDBC_INFO_PREVIOUS_PAGE, $prev_page));
if(empty($prev_page)) {
	$prev_page = zen_href_link(FILENAME_DEFAULT);
	$prev_page_full_info = sprintf(TEXT_NDDBC_INFO, sprintf(TEXT_NDDBC_INFO_OUR_WEBSITE, $prev_page));
}
if(!empty($prev_unix) && time() - $prev_unix < 60){
	define ( 'STORE_NAME', 'doreenbeads.com' );
	
	$prev_page = $_SERVER ['HTTP_REFERER'];
	$html_msg ['EMAIL_FIRST_NAME'] = 'qizan';
	$html_msg ['EMAIL_LAST_NAME'] = 'Wei';
	$html_msg ['EMAIL_MESSAGE_HTML'] = 'Dear qizan Wei:' . '<br /><strong>' . date('Y-m-d H:i:s') . ' </strong>' . '<span color="red"Doreenbeads Database Can Not be Connected</span>' . '<br />' . ' IP: ' . $customers_ip_address . ' Customers Id:' . $customers_id . ' Customers Name:' . $customers_name . '<br />' . ' Current Page:' . $current_page . ' Prev Page:' . $prev_page . '<br />' . 'Error Info:' . $errorinfo;
	$notify_email_text = 'Dear qizan Wei:' . "\n\n" . '<span color="red">Doreenbeads Database Can Not be Connected</span>' . "\n\n" . ' IP: ' . $customers_ip_address . ' Customers Id:' . $customers_id . ' Customers Name:' . $customers_name . "\n\n" . ' Current Page:' . $current_page . ' Prev Page:' . $prev_page . "\n\n" . ' Error Info:' . $errorinfo;
	// zen_mail('qizan' . 'Wei', 'tech.pandor@gmail.com', 'Doreenbeads Database Can
	// Not be Connected', 'Doreenbeads Database Can Not be Connected', STORE_NAME,
	// 'tech.pandor@gmail.com', $html_msg);
	zen_mail ( 'qizan' . 'Wei', 'tech.pandor@gmail.com', 'Doreenbeads Database Can Not be Connected', $notify_email_text, STORE_NAME, 'tech.pandor@gmail.com', $html_msg, 'EMAIL_MESSAGE_HTML' );
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<head>
<title>Connection Problem</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="authors" content="The dorabeads Team" />
<meta name="generator" content="shopping cart program by dorabeads, http://www.doreenbeads.com" />
<meta name="robots" content="noindex, nofollow" />
</head>
<body style="margin: 20px">
	<div style="width: 730px; background-color: #ffffff; margin: auto; padding: 10px; border: 1px solid #cacaca;">
		<a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><img src="includes/templates/cherry_zen/images/logo.jpg" alt="doreenbeads.com" title="doreenbeads.com" border="0" /></a>
		<?php echo $prev_page_full_info;?>
	</div>
</body>
</html>