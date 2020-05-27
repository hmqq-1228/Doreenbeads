<?php

/**
* 定时发送邮件服务
* 从代发送邮件目录中读取邮件XML文件；
* 调用发送邮件方法；
* 发送成功转移到成功目录；
* 发送失败转移到失败目录
*
* @author panduo tech
* @date 2015/05/29
* @version 1.0
*/
include ('includes/application_top.php');
include ('includes/access_ip_limit.php');
include ('includes/smtpauthConfig.php');
set_time_limit(0);
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

class regularlySendMailService {

	//	原始邮件目录
	private $_origDir = 'emailXml/orig/';
	//	成功邮件目录
	private $_succDir = 'emailXml/succ/';
	//	失败邮件目录
	private $_failDir = 'emailXml/fail/';
	//	附件目录
	private $_attaDir = 'emailXml/atta/';
	//	日志目录
	private $_logsDir = 'emailXml/logs/';
	//	每次发送个数
	private $_loopNum = 10;

	/*
	* 构造函数
	*/
	public function regularlySendMailService() {
	}

	/*
	*服务入口，开始读取文件
	*/
	public function readXml() {
		/*
		$handle = opendir($this->_origDir);
		$n = 0;
		while (false !== ($file = readdir($handle))) {
			if ($file == "." || $file == ".." || $file == ".svn") {
				continue;
			}

			$xmlFile = $this->_origDir . $file;
			if ($emailArr = $this->_parseXml($xmlFile)) {
				$ret = $this->_sendMail($emailArr);
				if (isset ($_SESSION['zen_mail_new_error']) && $_SESSION['zen_mail_new_error']) {
					$this->writeLog('发送邮件失败： ' . $xmlFile . '。原因：' . $_SESSION['zen_mail_new_error']);
				}
				$this->_moveXmml($xmlFile, $ret);
			} else {
				$this->_moveXmml($xmlFile, false);
			}

			if ($n++ >= $this->_loopNum)
				break; //	每次只执行$_loopNum个邮件
		}

		closedir($handle);
		*/
		$fileArray = $this->_dirSort($this->_origDir, $this->_origDir);
		foreach($fileArray as $xmlFile) {
			if ($emailArr = $this->_parseXml($xmlFile)) {
				$ret = $this->_sendMail($emailArr);
				if (isset ($_SESSION['zen_mail_new_error']) && $_SESSION['zen_mail_new_error']) {
					$this->writeLog('发送邮件失败： ' . $xmlFile . '。原因：' . $_SESSION['zen_mail_new_error']);
				}
				$this->_moveXmml($xmlFile, $ret);
			} else {
				$this->_moveXmml($xmlFile, false);
			}
		}
	}
	
	/*
	* 文件排序
	* @param string 文件夹路径		
	* @param tring 读取文件后的文件夹路径		
	* @return array 排序好的文件数组		
	*/
	private function _dirSort($dir, $url) {
		$dh = @opendir($dir); //打开目录，返回一个目录流
		$return = array ();
		$n = 0;
		while ($file = @readdir($dh)) { //循环读取目录下的文件
			if ($file != '.' and $file != '..' || $file == '.svn') {
				$path = $dir . '/' . $file; //设置目录，用于含有子目录的情况
				if (is_dir($path)) {
				}
				elseif (is_file($path)) {
					//$filesize[] = round((filesize($path) / 1024), 2); //获取文件大小
					//$filename[] = $path; //获取文件名称                     
					$filetime[] = date("Y-m-d H:i:s", filemtime($path)); //获取文件最近修改日期    

					$return[] = $url . '/' . $file;
				}
			}
			if ($n++ >= $this->_loopNum) {
				break; //	每次只执行$_loopNum个邮件
			}
		}
		@closedir($dh); //关闭目录流
		//array_multisort($filesize,SORT_DESC,SORT_NUMERIC, $return);//按大小排序
		//array_multisort($filename, SORT_ASC, SORT_STRING, $return); //按文件名称
		array_multisort($filetime, SORT_ASC, SORT_STRING, $return); //按时间排序
		return $return; //返回文件
	}

	/*
	* 解析xml文件成为邮件内容
	* @param	string		xml文件
	* @return	array		邮件所需参数
	*/
	private function _parseXml($p_file) {
		if ($p_file == '' || !file_exists($p_file))
			return false;

		$xml = simplexml_load_file($p_file);
		if (!$xml) {
			$this->writeLog('解析xml文件失败： ' . $p_file);
			return false;
		}
		$ret = array (
			'toName' => (string) $xml->to->to_name,
			'toEmail' => (string) $xml->to->to_address,
			'fromName' => (string) $xml->from->from_email_name,
			'fromEmail' => (string) $xml->from->from_email_address,
			'subject' => (string) $xml->email_subject,
			'text' => (string) $xml->email_text,
			'html' => (string) $xml->email_html,
			'module' => (string) $xml['module']
		);
		if (isset ($xml->reply)) {
			$ret['replyName'] = (string) $xml->reply->reply_to_name;
			$ret['replyEmail'] = (string) $xml->reply->reply_to_email;
		}
		if (isset ($xml->cc))
			foreach ($xml->cc->cc_address as $cc_address) {
				$ret['cc'][] = (string) $cc_address;
			}
		if (isset ($xml->attachments))
			foreach ($xml->attachments->attachment as $attachment) {
				$ret['attachment'][] = (string) $attachment;
			}

		return $ret;
	}

	/*
	* 发送邮件；调用发送邮件方法
	* @param	array		邮件所需参数
	* @return	bool		是否成功
	*/
	private function _sendMail($emailArr) {
		global $smtpauthConfig;

		if (!is_array($emailArr) || !$emailArr)
			return false;

		$auth = isset ($smtpauthConfig[$emailArr['fromEmail']]) ? $smtpauthConfig[$emailArr['fromEmail']] : $smtpauthConfig['default'];
		$emailArr['smtpUsername'] = $auth['username'];
		$emailArr['smtpPassword'] = $auth['password'];
		$emailArr['smtpHost'] = $auth['host'];
		$emailArr['smtpPort'] = $auth['port'];

		return zen_mail_new($emailArr);
	}

	/**
	* 转移xml文件
	* @param	string		xml文件
	* @param	bool		是否成功
	*/
	private function _moveXmml($p_file, $p_isSucc = true) {
		$dir = $p_isSucc ? $this->_succDir : $this->_failDir;
		$dt = date("Ymd");
		$dir = $dir . $dt;
		if (!is_dir($dir))
			mkdir($dir);
		if (!file_exists($p_file))
			return false;
		copy($p_file, $dir . "/" . basename($p_file));
		unlink($p_file);
	}

	/**
	* 写日志
	* @param	string		内容
	* @return	null
	*/
	private function writeLog($p_str = '') {
		$logFile = $this->_logsDir . 'mail-' . date("Ym") . ".log";
		error_log(date("Y-m-d H:i:s") . " : " . $p_str . "\n", 3, $logFile);
	}
}

$s = new regularlySendMailService();
$s->readXml();
echo 'success.';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);

?>