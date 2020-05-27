<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'download') {
    $date_now = date("YmdH", time() - 3600);
    $extract_dir = "file/livechatemail/";
    $extract_filename = $date_now . ".txt";
    $error_info = array();
    
    if(!is_file($extract_dir . $extract_filename)) {
    	$filename = download_file(HTTP_LIVECHAT_URL . "/maillog/files/" . $extract_filename, $extract_dir, $extract_filename, false);
	    if(is_file($extract_dir . $extract_filename)) {
	    	//print_r(file_get_contents($extract_dir . $extract_filename));exit;
	        $eadyhours_content = file_get_contents($extract_dir . $extract_filename);
	        $eadyhours_array = explode("|~\r\n", $eadyhours_content);
	        
	        for ($index = 0; $index < count($eadyhours_array); $index++){
	        	if(empty($eadyhours_array[$index])) {
	        		continue;
	        	}
	            $row_info = explode('|^', $eadyhours_array[$index]);
	            $language_directory = strtolower(zen_db_prepare_input(trim($row_info[1])));
	            $langs_code = zen_db_prepare_input(trim($row_info[2]));
	            $langs_email = zen_db_prepare_input(trim($row_info[3]));
	            $langs_name = zen_db_prepare_input(trim($row_info[4]));
	            $from_email_name = zen_db_prepare_input(trim($row_info[5]));
	            $from_email_address = trim($row_info[6]);
	            $email_subject = zen_db_prepare_input(trim($row_info[7]));
	            $email_text = trim($row_info[8]);
	            $email_html = trim($row_info[9]);
	            $html_msg['EMAIL_MESSAGE_HTML'] = $email_html;
	            zen_mail($langs_name, $langs_email, $email_subject, $email_text, $from_email_name, $from_email_address , $html_msg , 'default', '', 'false', '', $langs_code);
	        }
	    }
    } else {
    	die('file already exist');
    }
    
    //unlink($extract_dir . "t_prod_readyday.txt");
}

echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n" . var_export($error_info, true) . "\r\n", FILE_APPEND);
?>