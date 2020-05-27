<?php
  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if(zen_not_null($action)){
  	switch ($action) {
  		case 'delete':
  			$pid = zen_db_prepare_input($_GET['pID']);		 			  			
  			$db->Execute("delete from " . TABLE_PROPERTY_GROUP . " where property_group_id = '" . (int)$pid . "'");
  			$db->Execute("delete from " . TABLE_PROPERTY_GROUP_DESCRIPTION . " where property_group_id = '" . (int)$pid . "'");
  			$messageStack->add_session('信息删除成功','success');
  			zen_redirect(zen_href_link(products_property_manger, 'page=' . $_GET['page']));
  			break;  		
  		case 'update':
  			$group_value = $_POST['group_value'];
  			$pro_en = $_POST['pro_en'];
  			$pro_de = $_POST['pro_de'];
  			$pro_ru = $_POST['pro_ru'];
  			$pro_fr = $_POST['pro_fr'];
  			$pro_es = $_POST['pro_es'];
  			$isbasic = $_POST['isbasic'];
  			$sorttype = $_POST['sorttype'];
  			$sql_data_array = array('group_value' => $group_value,
  					'is_basic' => $isbasic,
  					'sort_type' => $sorttype
					);
  			zen_db_perform(TABLE_PROPERTY_GROUP, $sql_data_array, 'update', "property_group_id = '" . (int)$_GET['pID'] . "'");
  			$db->Execute('update '.TABLE_PROPERTY_GROUP_DESCRIPTION.' set property_group_name="'.$pro_en.'" where property_group_id="'.(int)$_GET['pID'].'" and languages_id=1');
  			$db->Execute('update '.TABLE_PROPERTY_GROUP_DESCRIPTION.' set property_group_name="'.$pro_de.'" where property_group_id="'.(int)$_GET['pID'].'" and languages_id=2');
  			$db->Execute('update '.TABLE_PROPERTY_GROUP_DESCRIPTION.' set property_group_name="'.$pro_ru.'" where property_group_id="'.(int)$_GET['pID'].'" and languages_id=3');
  			$db->Execute('update '.TABLE_PROPERTY_GROUP_DESCRIPTION.' set property_group_name="'.$pro_fr.'" where property_group_id="'.(int)$_GET['pID'].'" and languages_id=4');
  			$property_es_query = $db->Execute('select * from '.TABLE_PROPERTY_GROUP_DESCRIPTION. ' where property_group_id='.(int)$_GET['pID'].' and languages_id=5');
  			if($property_es_query->RecordCount() > 0 ) {
  				$db->Execute('update '.TABLE_PROPERTY_GROUP_DESCRIPTION.' set property_group_name="'.$pro_es.'" where property_group_id="'.(int)$_GET['pID'].'" and languages_id=5');
  			} else {
  				//$iId=$db->insert_ID();
  				$property_des_data1_array = array('property_group_id' => (int)$_GET['pID'],'languages_id' => 5,'property_group_name' => $pro_es);
  				zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data1_array, 'insert');
  			}
  			$messageStack->add_session('信息更新成功','success');
  			zen_redirect(zen_href_link('products_property_manger', 'page=' . $_GET['page']).'&pID='. (int)$_GET['pID'].'&search='.$_GET['search']);
  			break;
  			//echo "1111";exit;
  		case 'upload':
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
  					$propertyCode=$sheet->getCellByColumnAndRow(0,$j)->getValue();
  					$propertySort=$sheet->getCellByColumnAndRow(1,$j)->getValue();
  					$propertyName=$sheet->getCellByColumnAndRow(2,$j)->getValue();
  					$propertyCreateDate =$sheet->getCellByColumnAndRow(6,$j)->getValue();
  					$propertyEn =$sheet->getCellByColumnAndRow(10,$j)->getValue();
  					$propertyDe =$sheet->getCellByColumnAndRow(11,$j)->getValue();
  					$propertyRu =$sheet->getCellByColumnAndRow(12,$j)->getValue();
  					$propertyFr =$sheet->getCellByColumnAndRow(13,$j)->getValue(); 
  					$propertyEs =$sheet->getCellByColumnAndRow(14,$j)->getValue();
  					$pCode = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$propertyCode);
  					if($propertyCode=='' || $propertySort=='' ||$propertyName=='' || $propertyEn=='' ||  
  						$propertyDe=='' ||  $propertyRu=='' ||  $propertyFr=='' ||  $propertyEs==''){
  						$update_error=true;
  						$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，属性编号或名称或排序，或小语种翻译为空。';
  					} else if(substr( $pCode, 0, 1 ) !="P"){  						
  						$update_error=true;
  						$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，属性编号需以P开头。';
  					}else {
  						$select=$db->Execute("select group_code from ". TABLE_PROPERTY_GROUP. " where group_code= '". $pCode ."' limit 1");					  				
  						if($select->RecordCount()==0&&$pCode!=''){
  							$property_data_array = array(
  								'group_code' => $pCode,
  								'group_value' => $propertyName,
  								'group_status' => 1,
  								'sort_order'=> $propertySort,
  								'create_date' => $propertyCreateDate,
  								'is_basic'=> 1,
  								'sort_type' => 0);
  							zen_db_perform(TABLE_PROPERTY_GROUP, $property_data_array, 'insert');
  							$iId=$db->insert_ID();
  							$property_des_data1_array = array('property_group_id' => $iId,'languages_id' => 1,'property_group_name' => $propertyEn);
  							$property_des_data2_array = array('property_group_id' => $iId,'languages_id' => 2,'property_group_name' => $propertyDe);
  							$property_des_data3_array = array('property_group_id' => $iId,'languages_id' => 3,'property_group_name' => $propertyRu);
  							$property_des_data4_array = array('property_group_id' => $iId,'languages_id' => 4,'property_group_name' => $propertyFr);
  							$property_des_data5_array = array('property_group_id' => $iId,'languages_id' => 5,'property_group_name' => $propertyEs);
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data1_array, 'insert');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data2_array, 'insert');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data3_array, 'insert');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data4_array, 'insert');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data5_array, 'insert');
  							$count++;
  						}elseif ($select->RecordCount()>0){
  							$property_data_array = array(
  									'group_value' => $propertyName,
  									'group_status' => 1,
  									'sort_order'=> $propertySort,
  									'create_date' => $propertyCreateDate,
  									'is_basic'=> 1,
  									'sort_type' => 0);
  							zen_db_perform(TABLE_PROPERTY_GROUP, $property_data_array, 'update', 'group_code="' . $pCode . '"');
  							$iId_query=$db->Execute('select property_group_id from ' . TABLE_PROPERTY_GROUP . ' where group_code = "' . $pCode . '"');
  							$iId = $iId_query->fields['property_group_id'];
  							$property_des_data1_array = array('property_group_name' => $propertyEn);
  							$property_des_data2_array = array('property_group_name' => $propertyDe);
  							$property_des_data3_array = array('property_group_name' => $propertyRu);
  							$property_des_data4_array = array('property_group_name' => $propertyFr);
  							$property_des_data5_array = array('property_group_name' => $propertyEs);
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data1_array, 'update', 'property_group_id = ' . $iId . ' and languages_id = 1');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data2_array, 'update', 'property_group_id = ' . $iId . ' and languages_id = 2');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data3_array, 'update', 'property_group_id = ' . $iId . ' and languages_id = 3');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data4_array, 'update', 'property_group_id = ' . $iId . ' and languages_id = 4');
  							zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data5_array, 'update', 'property_group_id = ' . $iId . ' and languages_id = 5');
  							$count++;
  						}
  					}
  				}
  			}
  			if(sizeof($error_info_array)>=1 || $count>0){
  				$messageStack->add_session('部分属性信息导入成功','caution');
  				//$messageStack->add_session($count.'条商品对应关系已存在','caution');
  				foreach($error_info_array as $val){
  					$messageStack->add_session($val,'error');
  				}
  				zen_redirect(zen_href_link('products_property_manger'));
  			}else{
  				$messageStack->add_session('所有属性信息导入成功','success');
  				zen_redirect(zen_href_link('products_property_manger'));
  			}
  			exit;
  			break;
  		case 'create':
  			$group_code = $_POST['group_code'];
  			$group_value = $_POST['group_value'];
  			$pro_en = $_POST['pro_en'];
  			$pro_de = $_POST['pro_de'];
  			$pro_ru = $_POST['pro_ru'];
  			$pro_fr = $_POST['pro_fr'];
  			$pro_es = $_POST['pro_es'];
  			$sortorder = $_POST['sortorder'];
  			$isbasic = $_POST['isbasic'];
  			$sorttype = $_POST['sorttype'];
  			$select=$db->Execute("select group_code from ". TABLE_PROPERTY_GROUP. " where group_code= '". $group_code ."' limit 1");
  			if($select->RecordCount()==0){
	  			$property_data_array = array('group_value' => zen_db_prepare_input($group_value),
	  					'group_code' => $group_code,
	  					'sort_order' => zen_db_prepare_input((int)$sortorder),
	  					'is_basic' => zen_db_prepare_input($isbasic),
	  					'sort_type' => zen_db_prepare_input($sorttype),
	  					'creator' => 1,
	  					'create_date' => ""
	  			);
	  			zen_db_perform(TABLE_PROPERTY_GROUP, $property_data_array, 'insert');
	  			$iId=$db->insert_ID();
	  			$property_des_data1_array = array('property_group_id' => $iId,'languages_id' => 1,'property_group_name' => $pro_en);
	  			$property_des_data2_array = array('property_group_id' => $iId,'languages_id' => 2,'property_group_name' => $pro_de);
	  			$property_des_data3_array = array('property_group_id' => $iId,'languages_id' => 3,'property_group_name' => $pro_ru);
	  			$property_des_data4_array = array('property_group_id' => $iId,'languages_id' => 4,'property_group_name' => $pro_fr);
	  			$property_des_data5_array = array('property_group_id' => $iId,'languages_id' => 5,'property_group_name' => $pro_es);
	  			zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data1_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data2_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data3_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data4_array, 'insert');
	  			zen_db_perform(TABLE_PROPERTY_GROUP_DESCRIPTION, $property_des_data5_array, 'insert');
	  			$messageStack->add_session('信息提交成功','success');
	  			zen_redirect(zen_href_link('products_property_manger'));
  			} else {
  				$messageStack->add_session($group_code.'已经存在','error');
  				zen_redirect(zen_href_link('products_property_manger'));
  			}
  	}
  }

?>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<link rel="stylesheet" type="text/css"
	href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript"
	src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
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
	  if(confirm("你确定删除"+value+"这个属性吗？")){
		  window.location.href=url;
	  }
  }
  function checkProperty(){
		var group_value = $('.listshow input[name="group_value"]').val();
		var pro_en = $('.listshow input[name="pro_en"]').val();
		var pro_de = $('.listshow input[name="pro_de"]').val();
		var pro_ru = $('.listshow input[name="pro_ru"]').val();
		var pro_fr = $('.listshow input[name="pro_fr"]').val();
		var pro_es = $('.listshow input[name="pro_es"]').val();
		var error = false;
		var error_text = '';
		if($('.listshow input[name="group_code"]') ){
	    	var group_code = $('.listshow input[name="group_code"]').val();
			if(group_code == '') {				
				error_text += "请输入属性编号\n"; 
				error = true;
			} else if(group_code.charAt(0) != 'P'){
				error_text += "属性需以P开头\n"; 
				error = true;
			}
		}				
		if( group_value == ''){			
			error_text += "请输入属性名称\n"; 
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
		if(pro_es == ''){
			error_text += "请输入西语名称\n"; 
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
.simple_button {
	background: -moz-linear-gradient(center top, #FFFFFF, #CCCCCC) repeat
		scroll 0 0 #F2F2F2;
	border: 1px solid #656462;
	border-radius: 3px 3px 3px 3px;
	cursor: pointer;
	padding: 3px 20px;
}

.listshow {
	margin: 0;
	padding: 5px 10px;
}

.listshow input[type="text"] {
	border-color: #888888 #CCCCCC #CCCCCC #888888;
	height: 20px;
	width: 160px;
	border-style: solid;
	border-width: 1px;
	line-height: 23px;
	padding: 0 2px;
}

.listshow select {
	width: 50px;
}

#showpromotion {
	margin-top: 20px;
}

#showpromotion th {
	background: none repeat scroll 0 0 #D6D6CC;
	font-size: 13px;
	padding: 6px 10px 6px 15px;
	text-align: left;
}

#showpromotion th .red {
	color: #FF0000;
	font-weight: normal;
}

#showpromotion td {
	border-bottom: 1px dashed #CCCCCC;
}

.actionBut {
	display: table-cell;
	margin-bottom: 5px;
	width: 80px;
}

.promotionInput {
	border: 1px solid #888888;
	height: 20px;
	line-height: 20px;
	width: 160px;
}

.short {
	margin: 0 5px 0 20px;
	width: 50px;
	height: 24px;
	line-height: 24px;
}

.promotionName {
	float: right;
}

.promotionLang {
	float: left;
	line-height: 20px;
}

.promotionDiv {
	margin: 2px 0;
	overflow: hidden;
}

#fileDown {
	padding: 10px 0 0 0;
}

#fileDown p {
	font-size: 13px;
	font-weight: bold;
	margin: 5px 0;
}

#fileDown a {
	text-decoration: underline;
}

#fileDown a:hover {
	color: #ff6600;
}

#fileDown input {
	font-size: 12px;
	cursor: pointer;
}

#promotion_total {
	margin-top: 15px;
	padding: 10px;
}

#promotion_total h2 {
	font-size: 14px;
	margin: 8px 0;
}

.protecting .cal-TextBox {
	background: none repeat scroll 0 0 #FFFFFF;
	color: #6D6D6D;
}

#updatePro {
	font-weight: bold;
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
								<td class="pageHeading">属性和属性值管理</td>
								<td>
					            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
				         				<tbody>
				         				<tr>
				         					<form method="get" action='<?php echo zen_href_link('products_property_manger',zen_get_all_get_params(array('action')).'action=search', 'NONSSL')?>' name="search">         
				         					<td align="right" class="pageHeading"><img width="1" height="40" border="0" alt="" src="images/pixel_trans.gif"><input type="hidden" name="action" value="search"/></td>
				            				<td align="right" class="smallText" colspan="2">属性编号:  <input type="text"  name="search" value="<?php if (zen_not_null($_GET['search'])) echo $_GET['search']; ?>" /> <input type="submit" value="搜索"></td>
				          					</form>   
				          				</tr>
				        				</tbody>
				        			</table>
				        		</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>           
				<?php		
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
						$keywords .= " where (group_code in (" . substr($searchstr,0,strlen($searchstr)-1) . ") or group_value in (" . substr($searchstr,0,strlen($searchstr)-1) . ") ) ";
					}
					//$property_group_list_query_raw = "select pg.property_group_id,pg.group_code,pg.group_value，pg.sort_order from " . TABLE_PROPERTY_GROUP . " pg, ".TABLE_PROPERTY_GROUP_DESCRIPTION." pgd where pg.property_group_id=pgd.property_group_id  order by pg.property_group_id desc,pgd.languages_id ";
					$property_group_list_query_raw = "select pg.property_group_id,pg.group_code,pg.group_value,pg.sort_order,pg.is_basic,pg.sort_type from " . TABLE_PROPERTY_GROUP . " pg ".$keywords. " order by pg.property_group_id desc";
					$property_group_list_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $property_group_list_query_raw,$property_group_list_query_numrows);
					$property_group_list = $db->Execute($property_group_list_query_raw);			
				?>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td valign="top" width='70%'>
									<table border="0" width="100%" cellspacing="0" cellpadding="2">
										<tr class="dataTableHeadingRow">
											<td class="dataTableHeadingContent" align="left" width="25%">属性编号</td>
											<td class="dataTableHeadingContent" align="center"
												width="25%">属性名称</td>
											<td class="dataTableHeadingContent" align="center"
												width="25%">排序</td>
											<td class="dataTableHeadingContent" align="right" width="25%">操作</td>
										</tr>
              <?php 
              while(!$property_group_list->EOF){
				if ((!isset($_GET['pID']) || (isset($_GET['pID']) && ($_GET['pID'] == $property_group_list->fields['property_group_id']))) && !isset($pInfo)) {
					$pInfo_array = $property_group_list->fields;
					$pInfo = new objectInfo($pInfo_array);
				}
				if (isset($pInfo) && is_object($pInfo) && ($property_group_list->fields['property_group_id'] == $pInfo->property_group_id)) {
					echo '<tr class="dataTableRowSelected">';
				}else{
					echo '<tr class="dataTableRow">';
				}
				?>
					<td class="dataTableContent" align="left"><b><?php echo $property_group_list->fields['group_code'];?></b></td>
					<td class="dataTableContent" align="center"><?php echo $property_group_list->fields['group_value'];?></td>
					<td class="dataTableContent" align="center"><?php echo $property_group_list->fields['sort_order'];?></td>
					<td class="dataTableContent" align="right">
                	<?php 
                		$deleteurl = "'".zen_href_link('products_property_manger', zen_get_all_get_params(array("pID", "action")) . "pID=" . $property_group_list->fields['property_group_id'] . '&action=delete', 'NONSSL')."'";
                		$value = "'".$property_group_list->fields['group_value']."'";
                	?>
                	<?php echo '<a href="' . zen_href_link('products_property_manger', zen_get_all_get_params(array('pID', 'action')) . 'pID=' .  $property_group_list->fields['property_group_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
                	<?php echo '<a onclick="sureToDel('.$deleteurl.', '.$value.')" href="javascript:void(0)">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>'; ?>&nbsp;
                	<?php if ( (is_object($pInfo)) && ($property_group_list->fields['property_group_id'] == $pInfo->property_group_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' .zen_href_link('products_property_manger', zen_get_all_get_params(array('pID', 'action')) . 'pID=' .  $property_group_list->fields['property_group_id'] , 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?></td>
										</tr>
				<?php
				$property_group_list->MoveNext();
				}
              ?>
              <tr>
				  <td colspan="4">
					  <table border="0" width="100%" cellspacing="0" cellpadding="2">
						  <tr>
							  <td class="smallText" valign="top">
								  <?php echo $property_group_list_split->display_count ( $property_group_list_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET ['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS );?>
							  </td>
							  <td class="smallText" align="left">
									<?php echo $property_group_list_split->display_links ( $property_group_list_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']);?>
							  </td>
							  <td colspan="2" align=right><a href='<?php echo zen_href_link('products_property_manger','action=add&page='.$_GET['page'])?>'>
							  	  <button class='simple_button'>添加</button></a>
							  <td>
						  </tr>
					  </table>
                  </td>
			</tr>
		</table>
		<div id="fileDown">
			<form name="photo" enctype="multipart/form-data" action="<?php echo zen_href_link('products_property_manger','action=upload')?>" method="post">
				<b>导入excel文件:&nbsp;&nbsp;</b> <input type="file" name="file" size="30" style="width: 180px;" /> <input type="submit" name="upload" value="上传" />
			</form>
			<br>
			<p style="color:red;">注：此处用于导入属性表格</p>
			<!--<a href="./file/promotion_template.xlsx">Download table template</a>  -->
		</div>
		</td>
           <?php
               if($property_group_list->RecordCount() > 0){
		           $property_group_des_query_raw = "select pg.property_group_id,pg.group_code,pg.group_value,pgd.property_group_name, pgd.languages_id from " . TABLE_PROPERTY_GROUP . " pg, ".TABLE_PROPERTY_GROUP_DESCRIPTION." pgd where pg.property_group_id = ".$pInfo->property_group_id. " and pg.property_group_id=pgd.property_group_id  order by pgd.languages_id ";
		           //$property_group_list_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $property_group_list_query_raw, $property_group_list_query_numrows);
		           $property_group_des_list = $db->Execute($property_group_des_query_raw);
		           $property_group_des_array = array();
		           while(!$property_group_des_list->EOF){
			           $key = $property_group_des_list->fields['languages_id'];
			           $property_group_des_array[$key] = $property_group_des_list->fields['property_group_name'];
			           $property_group_des_list->Movenext();
		           }
		           ksort($property_group_des_array);
	           }
           	   if(!$action || $action == "search") {	           
		         ?>    
		         <td valign="top">
					<div class="infoBoxContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tbody>
								<tr class="infoBoxHeading">
									<td class="infoBoxHeading"><b><?php echo $property_group_list->RecordCount() > 0 ? $pInfo->group_value : "无记录";?></b></td>
								</tr>
							</tbody>
						</table>
						<?php if($property_group_list->RecordCount() > 0){ ?>
							<p class="listshow">
								<b>属性编号:</b> <?php echo  $pInfo->group_code?$pInfo->group_code:'/';?></p>
							<p class="listshow">
								<b>排序:</b> <?php echo  $pInfo->sort_order?$pInfo->sort_order:'/';?></p>
							<p class="listshow">
								<b>属性名称:</b> <?php echo  $pInfo->group_value?$pInfo->group_value:'/';?></p>
							<p class="listshow">
								<b>英语:</b> <?php echo  $property_group_des_array[1]?$property_group_des_array[1]:'/';?></p>
							<p class="listshow">
								<b>德语:</b> <?php echo  $property_group_des_array[2]?$property_group_des_array[2]:'/';?></p>
							<p class="listshow">
								<b>俄语:</b> <?php echo  $property_group_des_array[3]?$property_group_des_array[3]:'/';?></p>
							<p class="listshow">
								<b>法语:</b> <?php echo  $property_group_des_array[4]?$property_group_des_array[4]:'/';?></p>
							<p class="listshow">
								<b>西语:</b> <?php echo  $property_group_des_array[5]?$property_group_des_array[5]:'/';?></p>
							<p class="listshow">
								<b>是否为基本属性:</b> <?php echo  $pInfo->is_basic == 1 ? "是":'不是';?></p>
							<p class="listshow">
								<b>属性值排序方式:</b> <?php echo  $pInfo->sort_type == 1 ? "默认":'商品数';?></p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6"
								style="padding-left: 6px;">
								<tr>
									<td width='60%' align='left'><a
										href="<?php echo zen_href_link('products_property_manger', zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->property_group_id . '&action=edit', 'NONSSL')?>"><button
												class="simple_button">编辑</button></a>&nbsp;&nbsp;&nbsp;
										<button class="simple_button"
											onclick='sureToDel("<?php echo zen_href_link('products_property_manger', zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->property_group_id . '&action=delete', 'NONSSL')?>","<?php echo $pInfo->group_value;?>")'>删除</button></td>
								</tr>
								<tr>
									<td width='60%' align='left'><a
										href="<?php echo zen_href_link('products_property_values',  'ppid='.$pInfo->property_group_id."&ppage=".$_GET['page'], 'NONSSL')?>"><button
												class="simple_button">属性值管理</button></a></td>
								</tr>
							</table>
						<?php }?>
					</div>
				</td>
           		<?php }else if($action == 'edit'){ ?>
					<td valign="top">
					<div class="infoBoxContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tbody>
								<tr class="infoBoxHeading">
									<td class="infoBoxHeading"><b><?php echo $pInfo->group_value;?></b></td>
								</tr>
							</tbody>
						</table>
						<form name='relation_update' method="post"
							action="<?php echo zen_href_link('products_property_manger',zen_get_all_get_params(array('pID', 'action')).'action=update&page='.$_GET['page'].'&pID='.$pInfo->property_group_id."&search=".$_GET['search'])?>"
							onSubmit="return checkProperty()">
							<p class="listshow">
								<b>属性编号:</b><?php echo  $pInfo->group_code?$pInfo->group_code:'/';?></p>
							<p class="listshow">
								<b>排序:</b><?php echo  $pInfo->sort_order?$pInfo->sort_order:'/';?></p>
							<p class="listshow">
								<b>属性名称 : </b><input type="text" name="group_value"
									value="<?php echo  $pInfo->group_value?$pInfo->group_value:'/';?>" />
							</p>
							<p class="listshow">
								<b>英语 : </b><input type="text" name="pro_en"
									value="<?php echo  $property_group_des_array[1]?$property_group_des_array[1]:'/';?>" />
							</p>
							<p class="listshow">
								<b>德语 : </b><input type="text" name="pro_de"
									value="<?php echo  $property_group_des_array[2]?$property_group_des_array[2]:'/';?>" />
							</p>
							<p class="listshow">
								<b>俄语 : </b><input type="text" name="pro_ru"
									value="<?php echo  $property_group_des_array[3]?$property_group_des_array[3]:'/';?>" />
							</p>
							<p class="listshow">
								<b>法语 : </b><input type="text" name="pro_fr"
									value="<?php echo  $property_group_des_array[4]?$property_group_des_array[4]:'/';?>" />
							</p>
							<p class="listshow">
								<b>西语 : </b><input type="text" name="pro_es"
									value="<?php echo  $property_group_des_array[5]?$property_group_des_array[5]:'/';?>" />
							</p>
							<p class="listshow">
								<b>是否为基本属性 : </b> <input id="afterCheckBox" type="radio"
									name="isbasic" value="1"
									<?php echo  $pInfo->is_basic == 1 ? "checked":'' ?> /><label
									for="afterCheckBox">是</label><label><input type="radio"
									value="0" name="isbasic"
									<?php echo  $pInfo->is_basic == 0 ? "checked":'' ?>>否</label>
							</p>
							<p class="listshow">
								<b>属性值排序方式 : </b> <input id="afterCheckBox1" type="radio"
									value="1" name="sorttype"
									<?php echo  $pInfo->sort_type == 1  ? "checked":'' ?> /><label
									for="afterCheckBox1">默认</label><label><input type="radio"
									value="0" name="sorttype"
									<?php echo  $pInfo->sort_type == 0 ? "checked":'' ?>>商品数</label>
							</p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6"
								style="padding-left: 6px;">
								<tr>
									<td width='60%' align='left'><button class="simple_button">确认</button>&nbsp;&nbsp;&nbsp;</form>
										<a href="<?php echo zen_href_link('products_property_manger','page='.$_GET['page'].'&pID='.$pInfo->property_group_id."&search=".$_GET['search'])?>"><input type="button" class="simple_button" value="取消" /></a></td>
								</tr>
							</table>						
					</div>
				</td>
               <?php }else if($action == 'add'){ ?>
               		<td valign="top">
					<div class="infoBoxContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tbody>
								<tr class="infoBoxHeading">
									<td class="infoBoxHeading"><b>新增</b></td>
								</tr>
							</tbody>
						</table>
						<form name='relation_add' method="post" action="<?php echo zen_href_link('products_property_manger', zen_get_all_get_params(array('pID', 'action'))  . '&action=create', 'NONSSL')?>" onSubmit="return checkProperty()">
							<p class="listshow">
								<b>属性编号 : </b><input type="text" name="group_code" value="" />
							</p>
							<p class="listshow">
								<b>属性名称 : </b><input type="text" name="group_value" value="" />
							</p>
							<p class="listshow">
								<b>英语 : </b><input type="text" name="pro_en" value="" />
							</p>
							<p class="listshow">
								<b>德语 : </b><input type="text" name="pro_de" value="" />
							</p>
							<p class="listshow">
								<b>俄语 : </b><input type="text" name="pro_ru" value="" />
							</p>
							<p class="listshow">
								<b>法语 : </b><input type="text" name="pro_fr" value="" />
							</p>
							<p class="listshow">
								<b>西语 : </b><input type="text" name="pro_es" value="" />
							</p>
							<p class="listshow">
								<b>排序 : </b><input type="text" name="sortorder" value="" />
							</p>
							<p class="listshow">
								<b>是否为基本属性 : </b> <input id="afterCheckBox" value="1" type="radio"
									name="isbasic" checked /><label for="afterCheckBox">是</label><label><input
									type="radio" name="isbasic" value="0"/>否</label>
							</p>
							<p class="listshow">
								<b>属性值排序方式 : </b> <input id="afterCheckBox1" type="radio"
									name="sorttype" checked value="1"/><label for="afterCheckBox1">默认</label><label><input
									type="radio" name="sorttype" value="0"/>商品数</label>
							</p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6"
								style="padding-left: 6px;">
								<tr>
									<td width='60%' align='left'><button class="simple_button">确认</button>&nbsp;&nbsp;&nbsp;</form><a
										href="<?php echo zen_href_link('products_property_manger', '', 'NONSSL')?>"><input type="button" class="simple_button" value="取消" /></a></td>
								</tr>
							</table>						
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