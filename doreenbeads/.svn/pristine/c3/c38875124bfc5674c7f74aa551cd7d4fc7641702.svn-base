<?php
  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if(zen_not_null($action)){
  	switch ($action) {
  		case 'delete':
  			$pid = zen_db_prepare_input($_GET['pID']);		 			  			
  			$db->Execute("delete from " . TABLE_PROPERTY . " where property_id = '" . (int)$pid . "'");
  			$db->Execute("delete from " . TABLE_PROPERTY_DESCRIPTION . " where property_id = '" . (int)$pid . "'");
  			$messageStack->add_session('信息删除成功','success');
  			zen_redirect(zen_href_link(products_property_values, 'page=' . $_GET['page'].'&ppid='.$_GET['ppid']));
  			break;
  		case 'update':
  			$pro_value = $_POST['pro_value'];
  			$pro_en = $_POST['pro_en'];
  			$pro_de = $_POST['pro_de'];
  			$pro_ru = $_POST['pro_ru'];
  			$pro_fr = $_POST['pro_fr'];
  			$pro_es = $_POST['pro_es'];
  			$displayid = $_POST['displayid'];
  			
  			$sql_data_array = array('property_value' => $pro_value,
  									'property_display_id' => zen_db_prepare_input((int)$displayid)); 			  			
  			zen_db_perform(TABLE_PROPERTY, $sql_data_array, 'update', "property_id = '" . (int)$_GET['pID'] . "'"); 			
  			$db->Execute('update '.TABLE_PROPERTY_DESCRIPTION.' set property_name="'.$pro_en.'" where property_id="'.(int)$_GET['pID'].'" and languages_id=1');
  			$db->Execute('update '.TABLE_PROPERTY_DESCRIPTION.' set property_name="'.$pro_de.'" where property_id="'.(int)$_GET['pID'].'" and languages_id=2');
  			$db->Execute('update '.TABLE_PROPERTY_DESCRIPTION.' set property_name="'.$pro_ru.'" where property_id="'.(int)$_GET['pID'].'" and languages_id=3');
  			$db->Execute('update '.TABLE_PROPERTY_DESCRIPTION.' set property_name="'.$pro_fr.'" where property_id="'.(int)$_GET['pID'].'" and languages_id=4');
  			$property_es_query = $db->Execute('select * from '.TABLE_PROPERTY_DESCRIPTION. ' where property_id='.(int)$_GET['pID'].' and languages_id=5');
  			if($property_es_query->RecordCount() > 0 ) {
  				$db->Execute('update '.TABLE_PROPERTY_DESCRIPTION.' set property_name="'.$pro_es.'" where property_id="'.(int)$_GET['pID'].'" and languages_id=5');
  			} else {
  				//$iId=$db->insert_ID();
  				$property_data1_array = array('property_id' => (int)$_GET['pID'],'languages_id' => 5,'property_name' => $pro_es);
  				zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_data1_array, 'insert');
  			}
  			$messageStack->add_session('信息更新成功','success');
  			zen_redirect(zen_href_link('products_property_values', 'page=' . $_GET['page'].'&ppid='.$_GET['ppid'].'&pID='. (int)$_GET['pID'])."&search=".$_GET['search']);
  			break;
  			
  		case 'upload':
  			$property_group_list_query = $db->Execute("select property_group_id,group_code from " .TABLE_PROPERTY_GROUP);
  			$property_group_list = array();  		
  			while(!$property_group_list_query->EOF){
  				$key = $property_group_list_query->fields['group_code'];
  				$property_group_list[$key] = $property_group_list_query->fields['property_group_id'];
  				$property_group_list_query->MoveNext();
  			}  			
  			$property_list_query = $db->Execute("select property_id,property_code from " .TABLE_PROPERTY);
  			$property_list = array();
  			while(!$property_list_query->EOF){
  				$key = $property_list_query->fields['property_code'];
  				$property_list[$key] = $property_list_query->fields['property_id'];
  				$property_list_query->MoveNext();
  			} 
  				
  			$file=$_FILES['file'];  			
  			if($file['error']||empty($file)){
  				$messageStack->add_session('Fail: File upload unsuccessfully '.$file['name'],'error');
  				zen_redirect(zen_href_link('products_property_manger'));
  			}
  			$filename = basename($file['name']);
  			$file_ext = substr($filename, strrpos($filename, '.') + 1);
  			if($file_ext!='xlsx'&&$file_ext!='xls'){
  				$messageStack->add_session('文件格式有误，请上传xlsx或者xls格式的文件','error');
  				zen_redirect(zen_href_link('products_property_manger'));
  			}else{
  				$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');
  				$error_info_array=array();
  				$file_from=$file['tmp_name'];
  				$update_all=false;
  				if($_GET['area']=='all'){
  					$update_all=true;
  				}
  				set_include_path('../Classes/');
  				include 'PHPExcel.php';
  				if($file_ext=='xlsx'){
  					include 'PHPExcel/Reader/Excel2007.php';
  					$objReader = new PHPExcel_Reader_Excel2007;
  				}else{
  					include 'PHPExcel/Reader/Excel5.php';
  					$objReader = new PHPExcel_Reader_Excel5;
  				}
  				$count = 0;
  				$objPHPExcel = $objReader->load($file_from);
  				$sheet = $objPHPExcel->getActiveSheet();
  				for($j=3;$j<=$sheet->getHighestRow();$j++){
  					$error='';
  					$update_error=false;
  					$pgexsit = false;
  					$displayexsit = false;
  					//array_key_exists($orders_product->fields ['products_id'],$product_relation_list)
  					$propertyCode=$sheet->getCellByColumnAndRow(0,$j)->getValue();
  					$propertySort=$sheet->getCellByColumnAndRow(1,$j)->getValue();
  					$propertyGroupCode=$sheet->getCellByColumnAndRow(2,$j)->getValue();
  					$propertyName=$sheet->getCellByColumnAndRow(3,$j)->getValue();
  					$propertyCreateDate =$sheet->getCellByColumnAndRow(6,$j)->getValue();
  					$propertyEn =$sheet->getCellByColumnAndRow(10,$j)->getValue();
  					$propertyDe =$sheet->getCellByColumnAndRow(11,$j)->getValue();
  					$propertyRu =$sheet->getCellByColumnAndRow(12,$j)->getValue();
  					$propertyFr =$sheet->getCellByColumnAndRow(13,$j)->getValue();
  					$propertyEs =$sheet->getCellByColumnAndRow(14,$j)->getValue();
  					$displayId =$sheet->getCellByColumnAndRow(15,$j)->getValue();
  					$pCode = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$propertyCode);
  					$pgCode = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$propertyGroupCode);
  					if($propertyGroupCode =='' || $propertyCode=='' || $propertySort=='' ||$propertyName=='' || $propertyEn=='' ||
  						$propertyDe=='' ||  $propertyRu=='' ||  $propertyFr=='' ||$propertyEs=='' || $displayId==''){
  						$update_error=true;
  						$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，属性编号或属性值编号或名称或排序，或小语种翻译为空,或显示属性值不能为空。';
  					} else if(substr( $pCode, 0, 1 ) !='V'){
  						$update_error=true;
  						$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，属性编号需以V开头。';
  					} else if(!array_key_exists($pgCode,$property_group_list)){
  						$update_error=true;
  						$error_info_array[0]='属性' . $pgCode . '不存在！';
  					}else {						  										  
 						if(array_key_exists($pgCode,$property_group_list)) $pgexsit = true; 						
  						$select=$db->Execute("select property_code from ". TABLE_PROPERTY. " where property_code= '". $pCode ."' limit 1");
  						if($select->RecordCount()==0&&$pCode!=''&&$pgexsit){
  							if(array_key_exists($displayId,$property_list)){
	  							$property_data_array = array(
	  								'property_code' => $pCode,
	  								'property_value' => $propertyName,
	  								'property_group_id' => $property_group_list[$pgCode],
	  								'sort_order'=> $propertySort,
	  								'property_status' => 1,
	  								'property_create_date'=> $propertyCreateDate,
	  								'property_display_id' => $property_list[$displayId]);
	  							zen_db_perform(TABLE_PROPERTY, $property_data_array, 'insert');
	  							$iId=$db->insert_ID();
	  							$insert = true;
  							} else if($displayId == $propertyCode){
  								$property_data_array = array(
  										'property_code' => $pCode,
  										'property_value' => $propertyName,
  										'property_group_id' => $property_group_list[$pgCode],
  										'sort_order'=> $propertySort,
  										'property_status' => 1,
  										'property_create_date'=> $propertyCreateDate);
  								zen_db_perform(TABLE_PROPERTY, $property_data_array, 'insert');
  								$iId=$db->insert_ID();
  								$db->Execute('update '.TABLE_PROPERTY.' set property_display_id="'.$iId.'" where property_id="'.$iId.'"');
  								$insert = true;
  								$property_list[$displayId] = $iId;
  							}
  							if($insert){
	  							$property_des_data1_array = array('property_id' => $iId,'languages_id' => 1,'property_name' => $propertyEn);
	  							$property_des_data2_array = array('property_id' => $iId,'languages_id' => 2,'property_name' => $propertyDe);
	  							$property_des_data3_array = array('property_id' => $iId,'languages_id' => 3,'property_name' => $propertyRu);
	  							$property_des_data4_array = array('property_id' => $iId,'languages_id' => 4,'property_name' => $propertyFr);
	  							$property_des_data5_array = array('property_id' => $iId,'languages_id' => 5,'property_name' => $propertyEs);
	  							zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data1_array, 'insert');
	  							zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data2_array, 'insert');
	  							zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data3_array, 'insert');
	  							zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data4_array, 'insert');
	  							zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data5_array, 'insert');
	  							$count++;
  							}
  						}
  					}
  				}
  			}
  			if (!$update_error) {
	  			if(sizeof($error_info_array)>=1 || $count>0){
	  				$messageStack->add_session('部分属性值信息导入成功','caution');
	  				//$messageStack->add_session($count.'条商品对应关系已存在','caution');
	  				foreach($error_info_array as $val){
	  					$messageStack->add_session($val,'error');
	  				}
	  				zen_redirect(zen_href_link('products_property_values', 'ppid=' . $property_group_list[$pgCode]));
	  			}else{
	  				$messageStack->add_session('所有属性值信息导入成功','success');
	  				zen_redirect(zen_href_link('products_property_values', 'ppid=' . $property_group_list[$pgCode]));
	  			}
  			}else{
  				foreach($error_info_array as $val){
  					$messageStack->add_session($val,'error');
  				}
  				zen_redirect(zen_href_link('products_property_values'));
  			}
  			break;
  		case 'create':
  			$pro_code = $_POST['pro_code'];
  			$pro_value = $_POST['pro_value'];
  			$pro_en = $_POST['pro_en'];
  			$pro_de = $_POST['pro_de'];
  			$pro_ru = $_POST['pro_ru'];
  			$pro_fr = $_POST['pro_fr'];
  			$pro_es = $_POST['pro_es'];
  			$pro_group_id = $_GET['ppid'];
  			$sortorder = $_POST['sortorder'];
  			$displayid = $_POST['displayid']; 
  			$select=$db->Execute("select property_code from ". TABLE_PROPERTY. " where property_code= '". $pro_code ."' limit 1");
  			if($select->RecordCount()==0){
  				if($displayid !=0){
		  			$property_data_array = array('property_value' => zen_db_prepare_input($pro_value),
		  					'property_code' => zen_db_prepare_input($pro_code),
		  					'sort_order' => zen_db_prepare_input((int)$sortorder),		
		  					'property_status' => 1,
		  					'property_display_id' => zen_db_prepare_input((int)$displayid),
		  					'property_create_date' => "",
		  					'property_group_id' => $pro_group_id
		  			);
		  			zen_db_perform(TABLE_PROPERTY, $property_data_array, 'insert');
		  			$iId=$db->insert_ID();
  				} else {
  					$property_data_array = array('property_value' => zen_db_prepare_input($pro_value),
  							'property_code' => zen_db_prepare_input($pro_code),
  							'sort_order' => zen_db_prepare_input((int)$sortorder),
  							'property_status' => 1,
  							'property_create_date' => "",
  							'property_group_id' => $pro_group_id
  					);
  					zen_db_perform(TABLE_PROPERTY, $property_data_array, 'insert');
  					$iId=$db->insert_ID();
  					$db->Execute('update '.TABLE_PROPERTY.' set property_display_id="'.$iId.'" where property_id="'.$iId.'"');
  				}
	  			$property_des_data1_array = array('property_id' => $iId,'languages_id' => 1,'property_name' => $pro_en);
	  			$property_des_data2_array = array('property_id' => $iId,'languages_id' => 2,'property_name' => $pro_de);
	  			$property_des_data3_array = array('property_id' => $iId,'languages_id' => 3,'property_name' => $pro_ru);
	  			$property_des_data4_array = array('property_id' => $iId,'languages_id' => 4,'property_name' => $pro_fr);
	  			$property_des_data5_array = array('property_id' => $iId,'languages_id' => 5,'property_name' => $pro_es);
	  			zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data1_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data2_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data3_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data4_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_DESCRIPTION, $property_des_data5_array, 'insert');
	  			$messageStack->add_session('信息提交成功','success');
	  			zen_redirect(zen_href_link('products_property_values', 'page=' . $_GET['page'].'&ppid='.$_GET['ppid']));
	  			break;
  			} else {
  				$messageStack->add_session($pro_code.'编号已经存在','error');
  				zen_redirect(zen_href_link('products_property_values', 'page=' . $_GET['page'].'&ppid='.$_GET['ppid']));
  			}
  	  }
  }

?>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript">
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  function sureToDel(url,value){
	  if(confirm("你确定删除"+value+"这个属性值吗？")){
		  window.location.href=url;
	  }
  }
  function checkProperty(){	  
		var pro_value = $('.listshow input[name="pro_value"]').val();
		var pro_en = $('.listshow input[name="pro_en"]').val();
		var pro_de = $('.listshow input[name="pro_de"]').val();
		var pro_ru = $('.listshow input[name="pro_ru"]').val();
		var pro_fr = $('.listshow input[name="pro_fr"]').val();
		var error = false;
		var error_text = '';
		
	    if($('.listshow input[name="pro_code"]') ){
	    	var pro_code = $('.listshow input[name="pro_code"]').val()
			if(pro_code == '') {
				error_text += "请输入属性值编号\n"; 
				error = true;
			}else if(pro_code.charAt(0) != 'V'){
				error_text += "属性值需以V开头\n"; 
				error = true;
			}
		}
		if( pro_value == ''){			
			error_text += "请输入属性值名称\n"; 
			error = true;
		}
		if(pro_en == ''){
			error_text += "请输英语名称\n"; 
			error = true;
		}
		if(pro_de == ''){
			error_text += "请输德语名称\n"; 
			error = true;
		}
		if(pro_ru == ''){
			error_text += "请输入俄语名称\n"; 
			error = true;
		}
		if(pro_fr == ''){
			error_text += "请输入法语名称\n"; 
			error = true;
		}
		if($('.listshow input[name="sortorder"]') ){
	    	var sortorder = $('.listshow input[name="sortorder"]').val();
			if(sortorder == '') {				
				error_text += "请输入排序值\n"; 
				error = true;
			} else if(isNaN(sortorder.trim())){
				error_text += "排序值必须是数字\n"; 
				error = true;
			}
		}
		if(error) {alert(error_text);return false};	
	}
</script>
<style>
.simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;}
 .listshow{
	margin: 0;
    padding: 5px 10px;
 }
.listshow input[type="text"]{
	border-color:#888888 #CCCCCC #CCCCCC #888888;
 	height:20px; 
 	width:160px;
 	border-style: solid;
    border-width: 1px;
    line-height: 23px;
    padding: 0 2px;
 }
.listshow select{
 	width:50px;
    text-overflow:hidden;
 }
 #showpromotion{
 	margin-top: 20px;
 }
 #showpromotion th{
 	  background: none repeat scroll 0 0 #D6D6CC;
    font-size: 13px;
    padding: 6px 10px 6px 15px;
    text-align: left;
 }
  #showpromotion th .red{
  	color: #FF0000;
    font-weight: normal;
  }
 #showpromotion td{
 	border-bottom: 1px dashed #CCCCCC;
 }
 .actionBut{
 	 display: table-cell;
    margin-bottom: 5px;
    width: 80px;
 }
 .promotionInput{
 	border: 1px solid #888888;
    height: 20px;
    line-height: 20px;
    width: 160px;
 }
 .short{
 	margin: 0 5px 0 20px;
    width: 50px;
 height: 24px;
    line-height: 24px;
 }
 .promotionName{
 	float: right;
 }
 .promotionLang{
 	float: left;
    line-height: 20px;
 }
 .promotionDiv{
 	 margin: 2px 0;
    overflow: hidden;
 }
 #fileDown p{
	 font-size: 13px;
    font-weight: bold;
    margin: 5px 0;
 }
 #fileDown a{
 	 text-decoration: underline;
 }
 #fileDown a:hover{
	color:#ff6600;
 }
 #fileDown input{
	font-size:12px;cursor:pointer;
 }
 #promotion_total{
	 margin-top: 15px;
    padding: 10px;
 }
 #promotion_total h2{
 	font-size: 14px;
    margin: 8px 0;
 }
 .protecting .cal-TextBox{
	background: none repeat scroll 0 0 #FFFFFF;
    color: #6D6D6D;
 }
 #updatePro{
	font-weight:bold;
 }
</style>
</head>
<body onLoad="init()">
<div id="spiffycalendar" class="text"></div>
<?php require(DIR_WS_INCLUDES . 'header.php'); 
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
	  <tr>
	  	<td width="100%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
		    	<tbody>
		    	<tr>
		            <td class="pageHeading">属性值管理</td>
		            <td>
		            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	         				<tbody>
	         				<tr>
	         					<?php 
	         						$ppid = $_GET['ppid'] ? $_GET['ppid'] : 3;
	         						//$property_group_list_query_raw = "select pg.property_group_id,pg.group_code,pg.group_value，pg.sort_order from " . TABLE_PROPERTY_GROUP . " pg, ".TABLE_PROPERTY_GROUP_DESCRIPTION." pgd where pg.property_group_id=pgd.property_group_id  order by pg.property_group_id desc,pgd.languages_id ";	         				
	         						$keywords = '';
	         						if(trim($_GET['search']) != ''){
	         							$flag = strlen(trim($_GET['search']))==mb_strlen(trim($_GET['search']),"utf-8") ? true:false;
	         							if($flag){
	         								$searcharr = explode(',',trim($_GET['search']));
	         							}else{
	         								$searcharr = explode('，',trim($_GET['search']));
	         							}
	         							$searchstr='';
	         							foreach($searcharr as $search){
	         								$searchstr .= "'".trim($search)."',";
	         							}
	         							$keywords .= " and (property_code in (" . substr($searchstr,0,strlen($searchstr)-1) . ") or property_value in (" . substr($searchstr,0,strlen($searchstr)-1) . ") ) ";
	         							$keywords1 .= " where (property_code in (" . substr($searchstr,0,strlen($searchstr)-1) . ") or property_value in (" . substr($searchstr,0,strlen($searchstr)-1) . ") ) ";
	         							$search_list_query = $db->Execute('select property_group_id from ' . TABLE_PROPERTY . $keywords1);
	         							if($search_list_query->RecordCount() > 0){
	         								$ppid = $search_list_query->fields['property_group_id'];
	         							}
	         						}
	         						$property_value_list_query_raw = "select p.property_display_id,p.property_group_id,p.property_id,p.property_code,p.property_value,p.sort_order from " . TABLE_PROPERTY . " p where  p.property_group_id = ".$ppid." ".$keywords." order by p.property_id desc";
	         						$property_value_list_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $property_value_list_query_raw,$property_value_list_query_numrows);
	         						$property_value_list = $db->Execute($property_value_list_query_raw);
	         						
	         						$property_group_raw = $db->Execute("select pg.property_group_id,pg.group_code,pg.group_value,pg.sort_order,pg.is_basic,pg.sort_type from " . TABLE_PROPERTY_GROUP . " pg where pg.property_group_id=".$ppid);
	         					?>
	         					<form method="get" action='<?php echo zen_href_link('products_property_values',zen_get_all_get_params(array('action')).'action=search&ppid='.$ppid, 'NONSSL')?>' name="search">     
		         					<td align="right" class="pageHeading"><img width="1" height="40" border="0" alt="" src="images/pixel_trans.gif"><input type="hidden" name="action" value="search"/></td>
		            				<td align="right" class="smallText" colspan="2">属性值编号:  <input type="text"  name="search" value="<?php if (zen_not_null($_GET['search'])) echo $_GET['search']; ?>" /> <input type="submit" value="搜索"></td>
	          					</form>   
	          				</tr>
	        				</tbody>
	        			</table>
	        		</td>
		        </tr>
		        <tr>
		        	<td colspan="2" style="margin-bottom:0px;"><h3>属性值名称： <?php echo $property_group_raw->fields['group_value'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;属性编号：<?php echo $property_group_raw->fields['group_code'];?></h3></td>
		        </tr>
				</tbody>
			</table>
		</td>
	  </tr>	  
	  <tr>
	  	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <td valign="top" width='70%'>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left" width="25%">属性值编号</td>
                <td class="dataTableHeadingContent" align="center" width="25%">属性值名称</td>
                <td class="dataTableHeadingContent" align="center" width="25%">排序</td>
                <td class="dataTableHeadingContent" align="right" width="25%">操作</td>           
              </tr>
              <?php 
              while(!$property_value_list->EOF){
				if ((!isset($_GET['pID']) || (isset($_GET['pID']) && ($_GET['pID'] == $property_value_list->fields['property_id']))) && !isset($pInfo)) {
					
					$pInfo_array = $property_value_list->fields;
					$pInfo = new objectInfo($pInfo_array);
				}
				if (isset($pInfo) && is_object($pInfo) && ($property_value_list->fields['property_id'] == $pInfo->property_id)) {
					echo '<tr class="dataTableRowSelected">';
				}else{
					echo '<tr class="dataTableRow">';
				}
				?>
					<td class="dataTableContent" align="left"><b><?php echo $property_value_list->fields['property_code'];?></b></td>
               	 	<td class="dataTableContent" align="center"><?php echo $property_value_list->fields['property_value'];?></td>  
               	 	<td class="dataTableContent" align="center"><?php echo $property_value_list->fields['sort_order'];?></td>              	
                	<td class="dataTableContent" align="right">
                	<?php 
                		$deleteurl = "'".zen_href_link('products_property_values',   'pID='. $property_value_list->fields['property_id'] . '&ppid=' .  $property_value_list->fields['property_group_id'] . '&page='.$_GET['page'].'&action=delete', 'NONSSL')."'";
                		$value = "'".$property_value_list->fields['property_value']."'";
                	?>
                	<?php echo '<a href="' . zen_href_link('products_property_values',  'pID=' .  $property_value_list->fields['property_id'] . '&ppid=' .  $property_value_list->fields['property_group_id'] .'&page='.$_GET['page'].'&action=edit'.'&search='.$_GET['search'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
                	<?php echo '<a onclick="sureToDel('.$deleteurl.', '.$value.')" href="javascript:void(0)">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>'; ?>&nbsp;
                	<?php if ( (is_object($pInfo)) && ($property_value_list->fields['property_id'] == $pInfo->property_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link('products_property_values',  'pID=' .  $property_value_list->fields['property_id'] . '&ppid=' .  $property_value_list->fields['property_group_id'].'&page='.$_GET['page'] , 'NONSSL') .  '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?></td>
                	</tr>
				<?php
				$property_value_list->MoveNext();
				}
              ?>
              <tr>
				  <td colspan="4">
					   <table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td class="smallText" valign="top">
									<?php echo $property_value_list_split->display_count ( $property_value_list_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET ['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS );?>
								</td>
								<td class="smallText" align="left">
									<?php echo $property_value_list_split->display_links ( $property_value_list_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'pID', 'action')) );?>
								</td>
								<td colspan="2" align=right><a href='<?php echo zen_href_link('products_property_values','action=add&ppid='.$ppid.'&page='.$_GET['page'])?>'><button class='simple_button'>添加</button></a><td>
							</tr>
						</table>
					</td>							
			  </tr>	       
            </table>
            <p><a href='<?php echo zen_href_link('products_property_manger','page='.$_GET['ppage'])?>'><input  class="simple_button" type="button" value="返回" /></a> </p>
            <div id="fileDown">
				<form name="photo" enctype="multipart/form-data" action="<?php echo zen_href_link('products_property_values','action=upload')?>" method="post">
					<b>导入excel文件:&nbsp;&nbsp;</b> <input type="file" name="file" size="30" style="width: 180px;" /> <input type="submit" name="upload" value="上传" />
				</form>
				<br>
				<p style="color:red;">注：此处用于导入属性值表格</p>
				<!--<a href="./file/promotion_template.xlsx">Download table template</a>  -->
			</div>  
           </td>
           <?php
           	   if($property_value_list->RecordCount() > 0){
		           $property_value_des_query_raw = "select p.property_group_id, p.property_id, p.property_code, p.property_value, pgd.property_name, pgd.languages_id from " . TABLE_PROPERTY . " p, ".TABLE_PROPERTY_DESCRIPTION." pgd where p.property_id = ".$pInfo->property_id. " and p.property_id=pgd.property_id  order by pgd.languages_id ";
		           //$property_group_list_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $property_group_list_query_raw, $property_group_list_query_numrows);
		           $property_value_des_list = $db->Execute($property_value_des_query_raw);
		           $property_value_des_array = array();
		           while(!$property_value_des_list->EOF){
			           $key = $property_value_des_list->fields['languages_id'];
			           $property_group_des_array[$key] = $property_value_des_list->fields['property_name'];
			           $property_value_des_list->Movenext();
		           }
		           ksort($property_group_des_array);
		           $property_display_names_query_raw = "select p.property_value from " . TABLE_PROPERTY . " p, ".TABLE_PROPERTY_DESCRIPTION." pgd where p.property_id = ".$pInfo->property_display_id;
		           $property_display_names = $db->Execute($property_display_names_query_raw);		          		           
		           $property_categary_list_query = $db->Execute("select property_id,property_parents,property_value,  property_children from " .TABLE_PROPERTY .", ". TABLE_PROPERTY_SIMPLIFY. " where  property_parents = property_id group by property_parents");
		           $property_categary_list = array();
		           if($_GET['action'] == 'edit') {
						$key = $pInfo->property_id;	
						$property_categary_list[$key] = $pInfo->property_value;
				   }
		           if ($property_categary_list_query->RecordCount() > 0) {
		           	while(!$property_categary_list_query->EOF){
		           		$key = $property_categary_list_query->fields['property_id'];
		           		$property_categary_list[$key] = $property_categary_list_query->fields['property_value'];
		           		$property_categary_list_query->MoveNext();
		           	}
		           }
	           } else {
				    $property_categary_list_query = $db->Execute("select property_id,property_parents,property_value,  property_children from " .TABLE_PROPERTY .", ". TABLE_PROPERTY_SIMPLIFY. " where  property_parents = property_id group by property_parents");
					$property_categary_list = array();
					if($_GET['action'] == 'edit') {
						$key = $pInfo->property_id;
						$property_categary_list[$key] = $pInfo->property_value;
					}
					if ($property_categary_list_query->RecordCount() > 0) {
						while(!$property_categary_list_query->EOF){
							$key = $property_categary_list_query->fields['property_id'];
							$property_categary_list[$key] = $property_categary_list_query->fields['property_value'];
							$property_categary_list_query->MoveNext();
						}
					}
			   }
           	   if(!$action || $action == "search"){		           
		           ?>    
		           <td valign="top">
			            <div class="infoBoxContent">
			            <table width="100%" border="0" cellspacing="0" cellpadding="2">
			  				<tbody><tr class="infoBoxHeading">
			    				<td class="infoBoxHeading"><b> <?php if($property_value_list->RecordCount() > 0) echo $pInfo->property_value; else echo "无记录";?></b></td></tr>
							</tbody>
						</table>
						<?php if($property_value_list->RecordCount() > 0) { ?> 							
							<p class="listshow"><b>属性值编号:</b> <?php echo  $pInfo->property_code?$pInfo->property_code:'/';?></p>
							<p class="listshow"><b>排序:</b> <?php echo  $pInfo->sort_order?$pInfo->sort_order:'/';?></p>
							<p class="listshow"><b>属性值名称:</b> <?php echo  $pInfo->property_value?$pInfo->property_value:'/';?></p>
							<p class="listshow"><b>英语:</b> <?php echo  $property_group_des_array[1]?$property_group_des_array[1]:'/';?></p>
							<p class="listshow"><b>德语:</b> <?php echo  $property_group_des_array[2]?$property_group_des_array[2]:'/';?></p>
							<p class="listshow"><b>俄语:</b> <?php echo  $property_group_des_array[3]?$property_group_des_array[3]:'/';?></p>
							<p class="listshow"><b>法语:</b> <?php echo  $property_group_des_array[4]?$property_group_des_array[4]:'/';?></p>
							<p class="listshow"><b>西语:</b> <?php echo  $property_group_des_array[5]?$property_group_des_array[5]:'/';?></p>
							<p class="listshow"><b>显示属性值:</b> <?php echo  $property_display_names->fields['property_value']?$property_display_names->fields['property_value']:'/';?></p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6" style="padding-left:6px;">
								<tr><td width='60%' align='left'><a href="<?php echo zen_href_link('products_property_values', zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->property_id .'&ppID=' . $pInfo->property_group_id . '&action=edit', 'NONSSL')?>"><button class="simple_button">编辑</button></a>&nbsp;&nbsp;&nbsp;<button class="simple_button" onclick='sureToDel("<?php echo zen_href_link('products_property_values', zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->property_id . '&action=delete', 'NONSSL')?>","<?php echo $pInfo->property_value;?>")'>删除</button></td></tr>
							</table>
						<?php } ?>
						</div>
		           </td>
           		<?php } else if($action == 'edit'){ ?>
					<td valign="top">
			            <div class="infoBoxContent">
			            <table width="100%" border="0" cellspacing="0" cellpadding="2">
			  				<tbody><tr class="infoBoxHeading">
			    					<td class="infoBoxHeading"><b><?php echo $pInfo->property_value;?></b></td>
			  						</tr>
							</tbody>
						</table>
						<form name='relation_update' method="post" action="<?php echo zen_href_link('products_property_values','action=update&ppid='.$pInfo->property_group_id.'&page='.$_GET['page'].'&pID='.$pInfo->property_id.'&search='.$_GET['search'])?>" onSubmit="return checkProperty()">
							<p class="listshow"><b>属性值编号:</b><?php echo  $pInfo->property_code?$pInfo->property_code:'/';?></p>
							<p class="listshow"><b>排序:</b><?php echo  $pInfo->sort_order?$pInfo->sort_order:'/';?></p>
							<p class="listshow"><b>属性值名称 : </b><input type="text" name="pro_value" value="<?php echo  $pInfo->property_value?$pInfo->property_value:'/';?>"/></p>
							<p class="listshow"><b>英语 : </b><input type="text" name="pro_en" value="<?php echo  $property_group_des_array[1]?$property_group_des_array[1]:'/';?>"/></p>
							<p class="listshow"><b>德语 : </b><input type="text" name="pro_de" value="<?php echo  $property_group_des_array[2]?$property_group_des_array[2]:'/';?>"/></p>
							<p class="listshow"><b>俄语 : </b><input type="text" name="pro_ru" value="<?php echo  $property_group_des_array[3]?$property_group_des_array[3]:'/';?>"/></p>
							<p class="listshow"><b>法语 : </b><input type="text" name="pro_fr" value="<?php echo  $property_group_des_array[4]?$property_group_des_array[4]:'/';?>"/></p>
							<p class="listshow"><b>西语 : </b><input type="text" name="pro_es" value="<?php echo  $property_group_des_array[5]?$property_group_des_array[5]:'/';?>"/></p>
							<p class="listshow"><b>显示属性值: </b><select name="displayid">
								<?php
									foreach($property_categary_list as $key => $value) {
										if($value == $property_display_names->fields['property_value'])
										echo '<option value ="'.$key.'" selected>'.$value.'</option>';
										else echo '<option value ="'.$key.'">'.$value.'</option>';
									}
								?>
							</p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6" style="padding-left:6px;">
								<tr><td width='60%' align='left'><button class="simple_button">确认</button>&nbsp;&nbsp;&nbsp;<a href="<?php echo zen_href_link('products_property_values',  'pID=' . $pInfo->property_id . '&ppid='.$pInfo->property_group_id.'&page='.$_GET['page']."&search=".$_GET['search'], 'NONSSL')?>"><input type="button" value="取消" class="simple_button"></a></td></tr>
							</table>
						</form>
						</div>
		            </td>
               <?php } else if($action == 'add'){ ?>
               		<td valign="top">
		            <div class="infoBoxContent">
		            <table width="100%" border="0" cellspacing="0" cellpadding="2">
		  				<tbody><tr class="infoBoxHeading">
		    					<td class="infoBoxHeading"><b>新增</b></td>
		  						</tr>
						</tbody>
					</table>
					<form name='relation_add' method="post" action="<?php echo zen_href_link('products_property_values', zen_get_all_get_params(array('pID', 'action'))  . '&action=create', 'NONSSL')?>" onSubmit="return checkProperty()">
						<p class="listshow"><b>属性值编号 : </b><input type="text" name="pro_code" value=""/></p>
						<p class="listshow"><b>属性值名称 : </b><input type="text" name="pro_value" value=""/></p>
						<p class="listshow"><b>英语 : </b><input type="text" name="pro_en" value=""/></p>
						<p class="listshow"><b>德语 : </b><input type="text" name="pro_de" value=""/></p>
						<p class="listshow"><b>俄语 : </b><input type="text" name="pro_ru" value=""/></p>
						<p class="listshow"><b>法语 : </b><input type="text" name="pro_fr" value=""/></p>
						<p class="listshow"><b>西语 : </b><input type="text" name="pro_es" value=""/></p>
						<p class="listshow"><b>排序 : </b><input type="text" name="sortorder" value=""/></p>
						<p class="listshow"><b>显示属性值: </b><select name="displayid">
							<option value="0">默认</option>
							<?php
								foreach($property_categary_list as $key => $value) {
									echo '<option value ="'.$key.'">'.$value.'</option>';
								}
							?>
						</p>						
						<table width="60%" border="0" cellspacing="0" cellpadding="6" style="padding-left:6px;">
							<tr><td width='60%' align='left'><button class="simple_button">确认</button>&nbsp;&nbsp;&nbsp;<a href="<?php echo zen_href_link('products_property_values', '&ppid='.$ppid."&page=".$_GET['page'], 'NONSSL')?>"><input type="button" value="取消" class="simple_button"/></a></td></tr>
						</table>
					</form>
					</div>
		           </td>
               <?php } ?>
        </tr>
    	</tbody>
    </table>
</td>
</tr>
</tbody>
</table>
</body>
</html>