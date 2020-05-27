<?php
/**
* 读取代发送的邮件。供crm调用
*
* @author panduo tech
* @date 2015/08/17
* @version 1.0
*/

class regularlySendMailService{

	//	每次发送个数
	private $_loopNum = 10;

	/*
	* 构造函数
	*/
	public function regularlySendMailService($pageSize){
		if($pageSize) $this->_loopNum = $pageSize;
	}

	/*
	*服务入口，开始读取文件
	*/
	public function run(){
		global $conn1, $conn2;

		$ret = array();

		$sql = "SELECT * FROM t_email_to_crm WHERE `status` = 0 order by id limit " . $this->_loopNum;
		$result1 = mysql_query($sql, $conn1);
		while($row = mysql_fetch_array($result1,MYSQLI_ASSOC)) {
			$id = $row['id'];
			$file = $row['file'];
			
			$status = 1;
			//Tianwen.Wan20160317->文件不存在时修改成2
			if($file == '' || !file_exists($file)) {
				$status = 2;
			} else {
				$ret[] = file_get_contents($file);
			}
			mysql_query("update t_email_to_crm set `status` = " . $status . ", modified = now() where id = " . $id, $conn2);
		}

		return json_encode($ret);
	}

}
?>