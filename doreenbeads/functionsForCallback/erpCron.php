<?php
	/**
	* auto send email;
	* the email read from file that has been created;
	* called by a crontab job;
	* author lvxiaoyong 20130916
	* @version 1.0
	*/
	define('TABLE_EMAIL_ERP', DB_PREFIX.'email_erp');

	class erpCron{
		public function __construct(){
			$this->dir = dirname(__FILE__);
		}

		/**
		* send emails from file of email template;
		* @return null
		*/
		public function cron(){
			global $db;

			$time = time() - 3600;		//	locked 1h ago
			$sql = 'select * from '.TABLE_EMAIL_ERP.' where email_stat = 0 or (email_stat = 1 and email_locked <= '.$time.') order by email_id limit 20';
			$result = $db->Execute($sql);
			while(! $result->EOF){
				$rs = $result->fields;

				//	用于邮件语言
				$lang_arr = $this->language($rs['email_to']);
				$_SESSION['language'] = $lang_arr[0];
				$_SESSION['languages_id'] = $lang_arr[1];
				$_SESSION['languages_code'] = $lang_arr[2];

				$file = $this->dir.'/email_orig/'.$rs['email_file'];

				if(! file_exists($file)){	//	file not exist
					$sql = 'update '.TABLE_EMAIL_ERP.' set email_stat = 3, email_finished = "'.date('Y-m-d H:i:s').'" where email_id = '.$rs['email_id'];
					$db->Execute($sql);
					$this->writeLog('File not exist: '.$rs['email_file']);
					//	do something	//	todo
				}else{
					//	lock job first
					$this->writeLog('Lock job '.$rs['email_id']);
					$sql = 'update '.TABLE_EMAIL_ERP.' set email_stat = 1, email_locked = "'.time().'" where email_id = '.$rs['email_id'];
					$db->Execute($sql);

					//	send mail
					$this->writeLog('Send mail '.$rs['email_id'].' from file '.$rs['email_file']);
					$html_msg_trace_modify['EMAIL_MESSAGE_TRACE_MODIFY'] = file_get_contents($file);
					$contentOrder = $html_msg_trace_modify['EMAIL_MESSAGE_TRACE_MODIFY'];
					$html_msg_trace_modify['EMAIL_MESSAGE_HTML'] = $html_msg_trace_modify['EMAIL_MESSAGE_TRACE_MODIFY'];
					$ret = zen_mail($rs['email_toname'], $rs['email_to'], $rs['email_subject'], $contentOrder, STORE_NAME, EMAIL_FROM, $html_msg_trace_modify, 'order_trace_modify');
					$this->writeLog('Finish job '.$rs['email_id'].'. '.$ret);

					if(trim($ret) == ''){	//	if success, move file to email_succ folder, and set email_stat to 2
						$dt = date("Ym");
						$dir = $this->dir.'/email_succ/'.$dt;
						if(! is_dir($dir)) mkdir($dir);
						copy($file, $dir."/".basename($rs['email_file']));
						unlink($file);

						$sql = 'update '.TABLE_EMAIL_ERP.' set email_stat = 2, email_finished = "'.date('Y-m-d H:i:s').'" where email_id = '.$rs['email_id'];
						$db->Execute($sql);
					}else{		//	if failed
						//	do nothing
					}
				}

				$result->MoveNext();
			}
		}

		private function language($email) {
			$sql = 'SELECT l.code as code FROM t_languages l JOIN t_customers c WHERE c.customers_email_address = "'.$email.'" AND c.lang_preference = l.languages_id LIMIT 1';
			$result = mysql_query($sql);
			while ($row = mysql_fetch_array($result)) {
				$code = $row['code'];
			}
			switch (true) {
				case $code == 'de':
					return array('german',2,'de');
					break;
				case $code == 'ru':
					return array('russian',3,'ru');
					break;
				case $code == 'fr':
					return array('french',4,'fr');
					break;
				case $code == 'es':
					return array('spanish',5,'es');
					break;
				case $code == 'jp':
					return array('japanese',6,'jp');
					break;
				case $code == 'it':
					return array('italian',7,'it');
					break;
				default:
					return array('english',1,'en');
					break;
			}
		}

		/**
		* write to log file
		* @return null
		*/
		protected function writeLog($p_str=''){
			$logFile = $this->dir.'/log/cron-'.date("Ym").".log";
			error_log(date("Y-m-d H:i:s")." : ".$p_str."\n", 3, $logFile);
		}
	}
?>