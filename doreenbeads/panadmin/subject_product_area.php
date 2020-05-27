<?php

require('includes/application_top.php');
//require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');

define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_METHODS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> results)');

$languages = zen_get_languages();
$language_count = sizeof($languages);

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$id = isset($_GET['id']) ? $_GET['id'] : 0;

global $db;
if(zen_not_null($action)){
	switch ($action){
		case 'save':
		case 'insert':
			$error = false;
			$name = array();
			foreach($languages as $l){
				if(isset($_POST['name_'.$l['id']])){
					$name[$l['id']] = $_POST['name_'.$l['id']];
				}
			}
			$sql_data_array= array(array('fieldName'=>'nameZh', 'value'=>zen_db_prepare_input($_POST['nameZh']), 'type'=>'string'),
                           		   array('fieldName'=>'name', 'value'=>zen_db_prepare_input(serialize($name)), 'type'=>'string'),
                           		   array('fieldName'=>'showIndex', 'value'=>zen_db_prepare_input($_POST['showIndex']), 'type'=>'integer'),
                    			   array('fieldName'=>'indexTypeWeb', 'value'=>zen_db_prepare_input($_POST['indexTypeWeb']), 'type'=>'integer'),
                    			   array('fieldName'=>'showIndexMobile', 'value'=>zen_db_prepare_input($_POST['showIndexMobile']), 'type'=>'integer'),
                    			   array('fieldName'=>'indexTypeMobile', 'value'=>zen_db_prepare_input($_POST['indexTypeMobile']), 'type'=>'integer'),
                           		   array('fieldName'=>'status', 'value'=>zen_db_prepare_input($_POST['status']), 'type'=>'integer')
			);
			if ($action == 'insert'){
				$extra_data = array(
						array('fieldName'=>'add_admin', 'value'=>zen_db_prepare_input($_SESSION['admin_name']), 'type'=>'string'),
						array('fieldName'=>'add_datetime', 'value'=>date('Y-m-d H:i:s'), 'type'=>'date')
				);
				$sql_data_array = array_merge($sql_data_array , $extra_data);
				$db->perform(TABLE_SUBJECT_AREAS, $sql_data_array);
				$id = $db->insert_ID();
			}else{
				$extra_data = array(
						array('fieldName'=>'modify_admin', 'value'=>zen_db_prepare_input($_SESSION['admin_name']), 'type'=>'string'),
						array('fieldName'=>'modify_datetime', 'value'=>date('Y-m-d H:i:s'), 'type'=>'date')
				);
				$sql_data_array = array_merge($sql_data_array , $extra_data);
				$where_clause = "id = :id";
				$where_clause = $db->bindVars($where_clause, ':id', $id, 'integer');
				$db->perform(TABLE_SUBJECT_AREAS, $sql_data_array, 'update', $where_clause);
			}
			//	首页内容保存到文件
			foreach($languages as $l){
			    if(isset($_POST['home_'.$l['id']]) && $_POST['home_'.$l['id']] != ''){
					$file_home = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . $l['directory'] . '/html_includes/subject_area/', 'subject_area_index_'.$id.'.php', 'false');
					file_put_contents($file_home, $_POST['home_'.$l['id']]);
				}
				
				if(isset($_POST['home_mobile_'.$l['id']])){
				    $description_data_array = array(
				        'subject_id' => $id,
				        'language_id' => $l['id'],
				        'area_index' => trim($_POST['home_mobile_'.$l['id']]),
				        'create_date' => 'now()'
				    );
				    
				    $check_index_query = $db->Execute('select id from ' . TABLE_SUBJECT_AREA_DESCRIPTION_MOBILE . ' where subject_id='.$id.' and language_id=' . $l['id']);
				    if($check_index_query->RecordCount() == 0){
				        zen_db_perform(TABLE_SUBJECT_AREA_DESCRIPTION_MOBILE, $description_data_array);
				    }else{
				        zen_db_perform(TABLE_SUBJECT_AREA_DESCRIPTION_MOBILE, $description_data_array, 'update', 'subject_id='.$id.' and language_id=' . $l['id']);
				    }
				}
				
			}

			zen_redirect(zen_href_link('subject_product_area', 'page=' . $_GET['page'] . '&id=' . $id));
			break;
		
		//	清空产品
		case 'empty_products':
			$id = zen_db_prepare_input($_POST['id']);		 			  			
  			$db->Execute("delete from ".TABLE_SUBJECT_AREAS_PRODUCTS." where areas_id = '" . (int)$id . "'");
			echo 1;
			exit;
			break;

		//	上传产品
		case 'upload':
  			$file = $_FILES['up_file'];
  			if($file['error']||empty($file)){
  				$messageStack->add_session('Fail: File upload unsuccessfully '.$file['name'],'error');
  				zen_redirect(zen_href_link('subject_product_area'));
  			}
  			$filename = basename($file['name']);
  			$file_ext = substr($filename, strrpos($filename, '.') + 1);
  			if($file_ext!='xlsx'&&$file_ext!='xls'){
  				$messageStack->add_session('文件格式有误，请上传xlsx或者xls格式的文件','error');
  				zen_redirect(zen_href_link('subject_product_area'));
  			}else{
  				set_time_limit(0);
				$aid = $_POST['up_area'];
  				$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');				
  				$error_info_array = array();
  				$file_from = $file['tmp_name'];
  				set_include_path('../Classes/'); 				
  				include 'PHPExcel.php';
  				if($file_ext=='xlsx'){
  					 include 'PHPExcel/Reader/Excel2007.php';
  					 $objReader = new PHPExcel_Reader_Excel2007;
  				}else{
  					include 'PHPExcel/Reader/Excel5.php';
  					$objReader = new PHPExcel_Reader_Excel5;
  				}
  				$objPHPExcel = $objReader->load($file_from);
  				$sheet = $objPHPExcel->getActiveSheet();
  				$success_num = 0;
  				for($j=2;$j<=$sheet->getHighestRow();$j++){
  					$a1=$sheet->getCellByColumnAndRow(0,$j)->getValue();
  					if(trim($a1)==''){
  						$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品编号不能为空。';
  					}else{
  						$select = $db->Execute('select products_id , products_status from  '.TABLE_PRODUCTS.' where products_model="'.$a1.'" limit 1');
  						$pid=$select->fields['products_id'];
  						if($select->RecordCount()>0 && $pid!='' && $pid!=0){
  							if($select->fields['products_status'] == 1){
  								$check_sap=$db->Execute('select areas_id from '.TABLE_SUBJECT_AREAS_PRODUCTS.' where products_id="'.$pid.'" and areas_id ="'.$aid.'" limit 1');
  								if($check_sap->RecordCount()>0){
  									if($check_sap->fields['areas_id'] == $aid){
										$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品 '.$a1.' 已经存在于 当前专区 中，请确认！';
									}else{
										$check_sa = $db->Execute('select nameZh from '.TABLE_SUBJECT_AREAS.' where id='.intval($check_sap->fields['areas_id']));
										$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品 '.$a1.' 已经存在于 '.$check_sa->fields['nameZh'].' 中，请重新上传！';
									}
								}else{
  									$sql_data_array= array( 
  									    'areas_id'=>$aid,
  									    'products_id'=>$pid,
  									    'add_datetime'=>'now()'
                      				);
									zen_db_perform(TABLE_SUBJECT_AREAS_PRODUCTS, $sql_data_array);
									$success_num++;
  								}
  							}else{
  								if($select->fields['products_status'] == 0){
  									$update_error = true;
  									$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品 '.$a1.' 已下架，上传失败！';
  								}else{
  									$update_error = true;
  									$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品 '.$a1.' 已删除，上传失败！';
  								}
  							}
  						}else{
  							$update_error = true;
  							$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品 '.$a1.' 不存在，请重新上传！';
  						}
  					}
  				}
  			}
  			if(sizeof($error_info_array)>=1){
				if(sizeof($error_info_array) == ($j-2)){
					$messageStack->add_session('所有商品导入失败','error');
				}else{
  					$messageStack->add_session($success_num . '个商品已成功上传','caution');
				}
  				foreach($error_info_array as $val){
  					$messageStack->add_session($val,'error');
  				}
  				zen_redirect(zen_href_link('subject_product_area'));
  			}else{
  				$messageStack->add_session('所有商品导入成功','success');
  				zen_redirect(zen_href_link('subject_product_area'));
  			}
  			exit;
  			break;

		case 'remove_products':
		    $file = $_FILES['remove_file'];
		    if($file['error']||empty($file)){
		        $messageStack->add_session('Fail: File upload unsuccessfully '.$file['name'],'error');
		        zen_redirect(zen_href_link('subject_product_area'));
		    }
		    $filename = basename($file['name']);
		    $file_ext = substr($filename, strrpos($filename, '.') + 1);
		    if($file_ext!='xlsx'&&$file_ext!='xls'){
		        $messageStack->add_session('文件格式有误，请上传xlsx或者xls格式的文件','error');
		        zen_redirect(zen_href_link('subject_product_area'));
		    }else{
		        set_time_limit(0);
		        $error_info_array = array();
		        $file_from = $file['tmp_name'];
		        
		        set_include_path('../Classes/');
		        include 'PHPExcel.php';
		        
		        if($file_ext=='xlsx'){
		            include 'PHPExcel/Reader/Excel2007.php';
		            $objReader = new PHPExcel_Reader_Excel2007;
		        }else{
		            include 'PHPExcel/Reader/Excel5.php';
		            $objReader = new PHPExcel_Reader_Excel5;
		        }
		        $objPHPExcel = $objReader->load($file_from);
		        $sheet = $objPHPExcel->getActiveSheet();
		        $success_num = 0;
		        
		        for($j=2;$j<=$sheet->getHighestRow();$j++){
		            $products_model = trim($sheet->getCellByColumnAndRow(0,$j)->getValue());
		            $area_id = (int)$sheet->getCellByColumnAndRow(1,$j)->getValue();
		            
		            if($products_model != '' && $area_id > 0){
    		            $check_products_id_query = $db->Execute('select products_id from ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '"');
    		            
    		            if($check_products_id_query->RecordCount() > 0){
    		                $products_id = $check_products_id_query->fields['products_id'];
		            
    		                $check_subject_products_query = $db->Execute('select id from ' . TABLE_SUBJECT_AREAS_PRODUCTS . ' where areas_id = ' . $area_id . ' and products_id = ' . $products_id);
    		                if($check_subject_products_query->RecordCount() > 0){
    		                    $db->Execute('delete from ' . TABLE_SUBJECT_AREAS_PRODUCTS . ' where areas_id = ' . $area_id . ' and products_id = ' . $products_id);
    		                    $success_num++;
    		                }else{
    		                    $error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不存在于该专区中，上传失败！';
    		                }
    		            }else{
    		                $error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不存在，上传失败！';
    		            }
		            }else{
		                $error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号或专区ID错误，上传失败！';
		            }
		        }
		    }
		    
		    $messageStack->add_session($success_num . '行移除成功！','success');
		    
		    if(sizeof($error_info_array) > 0){
		        foreach($error_info_array as $val){
		            $messageStack->add_session($val,'error');
		        }
		    }
		    zen_redirect(zen_href_link('subject_product_area'));
		    break;
		default:
			break;
	}
}

$filter_str = ' ';
if(isset($_GET['area_subject']) && $_GET['area_subject'] != 10){
	$filter_str .= 'and status = "' . (int)$_GET['area_subject']  . '" ';
}
if(isset($_GET['area_name']) && $_GET['area_name'] != '' && $_GET['area_name'] != '商品专区名称'){
	$filter_str .= 'and nameZh like "%' . (string)$_GET['area_name'] . '%" ';
}

$page_size = 20;
$sql = 'select * from '.TABLE_SUBJECT_AREAS.' where id > 0 ' . $filter_str . ' order by status desc, id desc';
$result = $db->Execute($sql);
$subject_areas_all = array();
if ($result->RecordCount() > 0) {
	$i = 1;
	while ( ! $result->EOF ) {
		if ( isset($_GET['id']) && $_GET['id'] == $result->fields['id']){
			$pinfo = new objectInfo($result->fields);
			$_GET['page'] = ceil($i / $page_size);
//			$result->EOF = true;
		}
		$i++;
		$subject_areas_all[$result->fields['id']] = array (
			'id' => $result->fields ['id'],
			'nameZh' => $result->fields['nameZh'],
			'status' => $result->fields['status']
	  	);
		$result->MoveNext();	
	}
}
$area_split = new splitPageResults($_GET['page'], $page_size, $sql, $query_numrows);
$result = $db->Execute($sql);
if ($result->RecordCount() > 0) {
	while ( ! $result->EOF ) {
	  	$subject_areas[$result->fields['id']] = array (
			'id' => $result->fields ['id'],
			'nameZh' => $result->fields['nameZh'],
			'name' => $result->fields['name'],
	  		'status' => $result->fields ['status'],
	  		'showIndex' => $result->fields ['showIndex'],
	  	    'indexTypeWeb' => $result->fields ['indexTypeWeb'],
	  	    'showIndexMobile' => $result->fields ['showIndexMobile'],
	  	    'indexTypeMobile' => $result->fields ['indexTypeMobile'],
	  		'add_admin' => $result->fields ['add_admin'],
  			'add_datetime' => $result->fields ['add_datetime'],
  			'modify_admin' => $result->fields ['modify_admin'],
  			'modify_datetime' => $result->fields ['modify_datetime']
	  	);
	  	$result->MoveNext();
	}
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>商品专区设置</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
$(function(){
	$("#empty_products").live('click', function(){
		$("div#show_tips").html('').hide();
		if(! confirm('确认要清空产品？')) return;
		var status = $(this).attr('data-status');
		if(status == 1){
			$("div#show_tips").html('当前专区为开启状态，不能清空产品。').show();
			return;
		}else{
			var id = $(this).attr('data-id');
			$.post('./subject_product_area.php?action=empty_products',{id:id},function(data){
				$("div#show_tips").html('清空分区产品成功。').show();
			});
			return;
		}
	});
	$("#get_url").live('click', function(){
		var url = $(this).attr('data-url');
		$("div#show_tips").html('').hide();
		$("div#show_tips").html('URL已复制到剪贴板。如浏览器限制，请手动复制：'+url).show();
		copyToClipboard(url);	
	});
	$(".language_title").click(function(){
	  	var lang = $(this).attr("language");
	  	$(this).siblings().removeClass("checked");
		$(this).addClass("checked");
		$('#'+lang+'_textarea').css("display","block").siblings(".index_area").css("display","none");
		
	});
  $(".language_mobile_title").click(function(){
	  	var lang = $(this).attr("language");
	  	$(this).siblings().removeClass("checked");
		$(this).addClass("checked");
		$('#'+lang+'_mobile_textarea').css("display","block").siblings(".mobile_index_area").css("display","none");
		
	});

	$('input[name=showIndex]').change(function(){
		var showIndex = $('input[name=showIndex]:checked').val();

		if(showIndex == 1){
			$('#indexTypeWeb').css('color', 'initial');
			$('.pDesc').attr('readonly', false).css('background-color', 'white');
		}else{
			$('#indexTypeWeb').css('color', 'gray');
			$('.pDesc').attr('readonly', 'readonly').css('background-color', '#eeeeee');
		}
	});

	$('input[name=showIndexMobile]').change(function(){
		var showIndex = $('input[name=showIndexMobile]:checked').val();

		if(showIndex == 1){
			$('#indexTypeMobile').css('color', 'initial');
			$('.pMobileDesc').attr('readonly', false).css('background-color', 'white');
		}else{
			$('#indexTypeMobile').css('color', 'gray');
			$('.pMobileDesc').attr('readonly', 'readonly').css('background-color', '#eeeeee');
		}
	});

	$('input[name=indexTypeWeb]').change(function(){
		var showIndex = $('input[name=showIndex]:checked').val();
		var indextype = $('input[name=indexTypeWeb]:checked').val();

		if(showIndex == 0){
			if(indextype == 10){
				$('input[name=indexTypeWeb][value=20]').attr("checked",'checked');
			}else{
				$('input[name=indexTypeWeb][value=10]').attr("checked",'checked');
			}

			return false;
		}
	});

	$('input[name=indexTypeMobile]').change(function(){
		var showIndex = $('input[name=showIndexMobile]:checked').val();
		var indextype = $('input[name=indexTypeMobile]:checked').val();

		if(showIndex == 0){
			if(indextype == 10){
				$('input[name=indexTypeMobile][value=20]').attr("checked",'checked');
			}else{
				$('input[name=indexTypeMobile][value=10]').attr("checked",'checked');
			}

			return false;
		}
	});

})
    function copyToClipboard(txt) {   
         if(window.clipboardData) {   
                 window.clipboardData.clearData();   
                 window.clipboardData.setData("Text", txt);   
         } else if(navigator.userAgent.indexOf("Opera") != -1) {   
              window.location = txt;   
         } else if (window.netscape) {   
              try {   
                   netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");   
              } catch (e) {   
                   alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");   
              }   
              var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);   
              if (!clip)   
                   return;   
              var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);   
              if (!trans)   
                   return;   
              trans.addDataFlavor('text/unicode');   
              var str = new Object();   
              var len = new Object();   
              var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);   
              var copytext = txt;   
              str.data = copytext;   
              trans.setTransferData("text/unicode",str,copytext.length*2);   
              var clipid = Components.interfaces.nsIClipboard;   
              if (!clip)   
                   return false;   
              clip.setData(trans,null,clipid.kGlobalClipboard);   
              alert("复制成功！")   
         }   
    }
function chk_showIndex(){
	if($("input[name=name_1]").val() == ''){
		alert('请输入英文名称！');
		return false;
	}

	var showIndex = $("input[name=showIndex]:checked").val();
	var showIndexMobile = $("input[name=showIndexMobile]:checked").val();
	var error = false;

	if(showIndex != 0 ){
		var flag = false;
		$(".pDesc").each(function(){
			if($.trim($(this).val()) != ''){
				flag = true;
			}
		});

		if(!flag){
			error = true;
			alert('请在<网站首页>中填入内容。');
		}
	}

	if(showIndexMobile != 0 ){
		var flag = false;
		$(".pMobileDesc").each(function(){
			if($.trim($(this).val()) != ''){
				flag = true;
			}
		});

		if(!flag){
			error = true;
			alert('请在<网站首页>中填入内容。');
		}
	}
	
	return !error;
}
function chk_upload(){
	var area = $("#up_area").val();
	var file = $("#up_file").val();

	var flag = true;
	if(area == ''){
		flag = false;
		$("#tip_area").html('*请选择一个专区再导入产品！');
	}else{
		$("#tip_area").html('*');
	}
	if(file == ''){
		flag = false;
		$("#tip_file").html('*请上传excel文件！');
	}else{
		$("#tip_file").html('*');
	}

	return flag;
}
</script>
<style>
td.td_name {
    width: 10%;
	font-size:14px;
	text-align: right;
}
td.td_name_new {
    width: 20%;
	font-size:14px;
	text-align: center;
}
td.td_value{
	font-size:14px;
}
span.langname{
	width:8%;
	float:left;
}
div.langdiv{
	padding-bottom:6px;
}
td.td_value input[type="text"],td.td_value select,td.td_value input[type="file"]{
	font-size:14px;
	height: 25px;
    width: 300px;
}
.simple_button{
	background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
	border: 1px solid #656462;
	border-radius: 3px 3px 3px 3px;
	cursor: pointer;
	padding: 3px 20px;
	font-size: 14px;
}
div#show_tips{
	color:red;
}
span#tip_area, span#tip_file{
	color:red;
}
 .language_title , .language_mobile_title{
	display: inline-block;
    border: 1px solid #D0CCCC;
    width: 54px;
    text-align: center;
    vertical-align: middle;
    line-height: 25px;
    cursor: pointer;
    position: relative;
    background: white;
    top: 1px;
 }
 .checked{
 	border-bottom:0px;
 	font-weight:bold;
 }
</style>
</head>
<body onLoad="init()">

<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php
if($action == 'new'){
?>
<form name="subject_product_area" action="subject_product_area.php?action=insert" method="post" onsubmit="return chk_showIndex();">
<table border="0" width="100%" cellspacing="2" cellpadding="2" style="width:100%;padding:20px;">
	<tr>
		<td class="pageHeading" colspan="2">营销功能设置 > 商品专区设置  > 新建专区<br/><br/></td>
	</tr>
	<tr>
		<td class="td_name_new">专区名称：</td>
		<td class="td_value">
			<div class="langdiv"><span class="langname">中文: </span><input type="text" name="nameZh" /></div>
<?php
	foreach($languages as $l){
		echo '<div class="langdiv"><span class="langname">'.$l['name'].': </span><input type="text" name="name_'.$l['id'].'" /></div>';
	}
?>
		</td>
	</tr>
	<tr style="line-height: 30px;">
		<td class="td_name_new">状态：</td>
		<td class="td_value"><label style="margin-right: 50px;"><input type="radio" name="status" value="1" checked="checked" />开启</label>&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />关闭</label></td>
	</tr>
	
	<tr style="line-height: 30px;">
		<td class="td_name_new">是否显示网站显示样式：</td>
		<td class="td_value"><label style="margin-right: 50px;"><input type="radio" name="showIndex" value="1" />是</label>&nbsp;&nbsp;<label><input type="radio" name="showIndex" value="0" checked="checked"/>否</label></td>
	</tr>
	
	<tr style="line-height: 30px;">
		<td class="td_name_new">网站显示类型：</td>
		<td class="td_value"  id="indexTypeWeb" style="color: gray;"><label style="margin-right: 50px;"><input type="radio" name="indexTypeWeb" value="10" checked="checked"  />专区首页</label>&nbsp;&nbsp;<label><input type="radio" name="indexTypeWeb" value="20" />商品列表上方内容</label></td>
	</tr>
	<tr>
		<td class="info_column_title" align="right" ></td>
		<td class="info_column_content" > 
			<div class="index_area">
				<div class="index_language"> 
					<div class="language_title checked" language="en" >英语</div><div class="language_title" language="de">德语</div><div class="language_title" language="ru">俄语</div><div class="language_title" language="fr">法语</div>
					<?php 
					for ($i = 0, $n = $language_count; $i < $n; $i++) { 
						$lang_id = $languages[$i]['id'];
					
						if($i == 0){
							echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">' ;
						}else{
							echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">';
						}
					?>
						<textarea style="background-color:#eeeeee;" readonly="readonly" rows="9" style="width:60%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pDesc" id = "pDesc<?php echo $lang_id?>" name = "home_<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"></textarea></div> 
					
					<?php }?> 
				</div>
			</div>  
		</td>
	</tr>
	
	<tr style="line-height: 30px;">
		<td class="td_name_new">是否显示手机站显示样式：</td>
		<td class="td_value"><label style="margin-right: 50px;"><input type="radio" name="showIndexMobile" value="1" />是</label>&nbsp;&nbsp;<label><input type="radio" name="showIndexMobile" value="0" checked="checked"/>否</label></td>
	</tr>
	
	<tr style="line-height: 30px;">
		<td class="td_name_new">手机站显示类型：</td>
		<td class="td_value" id="indexTypeMobile" style="color: gray;"><label style="margin-right: 50px;"><input type="radio" name="indexTypeMobile" value="10" checked="checked" />专区首页</label>&nbsp;&nbsp;<label><input type="radio" name="indexTypeMobile" value="20" />商品列表上方内容</label></td>
	</tr>
	<tr>
		<td class="info_column_title" align="right" ></td>
		<td class="info_column_content" > 
			<div class="index_area">
				<div class="index_language"> 
					<div class="language_mobile_title checked" language="en" >英语</div><div class="language_mobile_title" language="de">德语</div><div class="language_mobile_title" language="ru">俄语</div><div class="language_mobile_title" language="fr">法语</div>
					<?php
					$str_home = '';
					for ($i = 0, $n = $language_count; $i < $n; $i++) { 
						$lang_id = $languages[$i]['id'];
						
						if($i == 0){
							echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_mobile_textarea" class="mobile_index_area">' ;
						}else{
							echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_mobile_textarea" class="mobile_index_area">';
						}
					?>
						<textarea style="background-color:#eeeeee;" readonly="readonly" rows="9" style="width:60%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pMobileDesc" id = "pMobileDesc<?php echo $lang_id?>" name = "home_mobile_<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"></textarea></div> 
					
					<?php }?> 
				</div>
			</div>  
		</td>
	</tr>
	<td colspan="2"><button class="simple_button">提交</button>&nbsp;&nbsp;<a href="<?php echo zen_href_link('subject_product_area', zen_get_all_get_params(array('id', 'action')), 'NONSSL'); ?>"><input type="button" class="simple_button" value="取消" /></a></td>
</table>
</form>
<?php
}else if($action == 'edit'){
    ?>
<form name="subject_product_area" action="subject_product_area.php?action=save&id=<?php echo $id; ?>" method="post" onsubmit="return chk_showIndex();">
<table border="0" width="100%" cellspacing="2" cellpadding="2" style="width:100%;padding:20px;">
	<tr>
		<td class="pageHeading" colspan="2">营销功能设置 > 商品专区设置  > 修改专区<br/><br/></td>
	</tr>
	<tr>
		<td class="td_name_new">专区名称：</td>
		<td class="td_value">
			<div class="langdiv"><span class="langname">中文: </span><input type="text" name="nameZh" value="<?php echo $pinfo->nameZh; ?>" /></div>
<?php
	$name = unserialize($pinfo->name);
	foreach($languages as $l){
		echo '<div class="langdiv"><span class="langname">'.$l['name'].': </span><input type="text" name="name_'.$l['id'].'" value="'.$name[$l['id']].'" /></div>';
	}
?>
		</td>
	</tr>
	<tr>
		<td class="td_name_new">状态：</td>
		<td class="td_value"><label><input type="radio" name="status" value="1" <?php echo $pinfo->status ? 'checked="checked"' : ''; ?> />开启</label>&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo !$pinfo->status ? 'checked="checked"' : ''; ?> />关闭</label></td>
	</tr>
	<tr>
		<td class="td_name_new">是否显示网站显示样式：</td>
		<td class="td_value"><label><input type="radio" name="showIndex" value="1" <?php echo $pinfo->showIndex ? 'checked="checked"' : ''; ?> />是</label>&nbsp;&nbsp;<label><input type="radio" name="showIndex" value="0" <?php echo !$pinfo->showIndex ? 'checked="checked"' : ''; ?> />否</label></td>
	</tr>
		<tr style="line-height: 30px;">
		<td class="td_name_new">网站显示类型：</td>
		<td class="td_value"  id="indexTypeWeb" <?php echo !$pinfo->showIndex ? 'style="color: gray;"' : ''; ?>><label style="margin-right: 50px;"><input type="radio" name="indexTypeWeb" value="10" <?php echo $pinfo->indexTypeWeb == 10 ? 'checked="checked"' : ''?>  />专区首页</label>&nbsp;&nbsp;<label><input type="radio" name="indexTypeWeb" value="20" <?php echo $pinfo->indexTypeWeb == 20 ? 'checked="checked"' : ''?>/>商品列表上方内容</label></td>
	</tr>
	<tr>
		<td class="info_column_title" align="right" ></td>
		<td class="info_column_content" > 
			<div class="index_area">
				<div class="index_language"> 
					<div class="language_title checked" language="en" >英语</div><div class="language_title" language="de">德语</div><div class="language_title" language="ru">俄语</div><div class="language_title" language="fr">法语</div>
					<?php 
					for ($i = 0, $n = $language_count; $i < $n; $i++) { 
						$lang_id = $languages[$i]['id'];
						$file_home = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/html_includes/subject_area/', 'subject_area_index_'.$pinfo->id.'.php', 'false');
						
						$str_home = file_exists($file_home) ? file_get_contents($file_home) : '';
					
						if($i == 0){
							echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">' ;
						}else{
							echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">';
						}
					?>
						<textarea <?php echo !$pinfo->showIndex ? 'readonly="readonly" style="background-color:#eeeeee;"' : ''; ?>  rows="9" style="width:60%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pDesc" id = "pDesc<?php echo $lang_id?>" name = "home_<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"><?php echo $str_home;?></textarea></div> 
					
					<?php }?> 
				</div>
			</div>  
		</td>
	</tr>
	<tr style="line-height: 30px;">
		<td class="td_name_new">是否显示手机站显示样式：</td>
		<td class="td_value"><label style="margin-right: 50px;"><input type="radio" name="showIndexMobile" value="1" <?php echo $pinfo->showIndexMobile ? 'checked="checked"' : ''; ?> />是</label>&nbsp;&nbsp;<label><input type="radio" name="showIndexMobile" value="0" <?php echo !$pinfo->showIndexMobile ? 'checked="checked"' : ''; ?>/>否</label></td>
	</tr>
	
	<tr style="line-height: 30px;">
		<td class="td_name_new">手机站显示类型：</td>
		<td class="td_value" id="indexTypeMobile" <?php echo !$pinfo->showIndexMobile ? 'style="color: gray;"' : ''; ?>><label style="margin-right: 50px;"><input type="radio" name="indexTypeMobile" value="10" <?php echo $pinfo->indexTypeMobile == 10 ? 'checked="checked"' : ''?> />专区首页</label>&nbsp;&nbsp;<label><input type="radio" name="indexTypeMobile" value="20" <?php echo $pinfo->indexTypeMobile == 20 ? 'checked="checked"' : ''?>/>商品列表上方内容</label></td>
	</tr>
	<tr>
		<td class="info_column_title" align="right" ></td>
		<td class="info_column_content" > 
			<div class="index_area">
				<div class="index_language"> 
					<div class="language_mobile_title checked" language="en" >英语</div><div class="language_mobile_title" language="de">德语</div><div class="language_mobile_title" language="ru">俄语</div><div class="language_mobile_title" language="fr">法语</div>
					<?php
					$subject_mobile_index_query = $db->Execute('select language_id, area_index from ' . TABLE_SUBJECT_AREA_DESCRIPTION_MOBILE . ' where subject_id =' . $pinfo->id);
					if($subject_mobile_index_query->RecordCount() > 0){
					    while (!$subject_mobile_index_query->EOF){
					        $subject_index_array[$subject_mobile_index_query->fields['language_id']] = $subject_mobile_index_query->fields['area_index'];
					        
					        $subject_mobile_index_query->MoveNext();
					    }
					}
					for ($i = 0, $n = $language_count; $i < $n; $i++) { 
						$lang_id = $languages[$i]['id'];
						
						if($i == 0){
							echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_mobile_textarea" class="mobile_index_area">' ;
						}else{
							echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_mobile_textarea" class="mobile_index_area">';
						}
					?>
						<textarea  <?php echo !$pinfo->showIndexMobile ? 'readonly="readonly" style="background-color:#eeeeee;"' : ''; ?> rows="9" style="width:60%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pMobileDesc" id = "pMobileDesc<?php echo $lang_id?>" name = "home_mobile_<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"><?php echo $subject_index_array[$lang_id]?></textarea></div> 
					
					<?php }?> 
				</div>
			</div>  
		</td>
	</tr>
	<td colspan="2"><input type="submit" value="更新" class="simple_button" />&nbsp;&nbsp;<a href="<?php echo zen_href_link('subject_product_area', zen_get_all_get_params(array('id', 'action')) . 'id=' . $id, 'NONSSL'); ?>"><input type="button" class="simple_button" value="取消" /></a></td>
</table>
</form>
<?php
}else{
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
		<td width="100%" valign="top">
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tr>
					<td class="pageHeading" colspan="2">商品专区设置<br/><br/></td>
					<td><a href="<?php echo zen_href_link(FILENAME_SUBJECT_PRODUCT_AREA_PRODUCTS )?>"><button class='simple_button'>专区商品信息</button></a></td>
					<td style="float: right;">
						<?php echo zen_draw_form('search_form', 'subject_product_area' , '' , '')?>
						<table>
							<tr style="height: 30px;display: block;">
								<td><span>状态：</span><?php echo zen_draw_pull_down_menu('area_subject', array(array('id'=> 10 , 'text' => 'All') , array('id'=> 1 , 'text' => '开启') , array('id'=> 0 , 'text' => '关闭')), $_GET['area_subject'] != '' ? $_GET['area_subject'] : 10, 'style="width: 80px;height: 24px;"')?></td>
							</tr>
							<tr style="height: 30px;display: block;">
								<td><?php echo zen_draw_input_field('area_name' , $_GET['area_name'] ? $_GET['area_name'] : '商品专区名称' , 'style="height: 20px; width: 116px;color: darkgray;" onclick="if (this.value == \'商品专区名称\'){this.value=\'\';this.style.color=\'#000\';}"')?></td>
							</tr>
							<tr style="height: 30px;display: block;">
								<td><?php echo zen_image_submit('button_search_cn.png','搜索','style="width: 80px; height: 24px;"'); ?></td>
							</tr>
						</table>
						<?php echo '</form>';?>
					</td>
				</tr>
		</td>
		
	</tr>
</table>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
		<td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr class="dataTableHeadingRow">
						<td class="dataTableHeadingContent">ID</td>
						<td class="dataTableHeadingContent">专区名称</td>
						<td class="dataTableHeadingContent">状态</td>
						<td class="dataTableHeadingContent">是否设置网站显示样式</td>
						<td class="dataTableHeadingContent">是否设置手机站显示样式</td>
						<td class="dataTableHeadingContent">操作</td>
					</tr>
<?php
	if (!$id){
		$first_method = reset($subject_areas);
		$id = $first_method['id'];
	}
	foreach ($subject_areas as $key => $val){
		if ($id == $val['id']) {
			$mInfo = new objectInfo($val);
			echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('subject_product_area', zen_get_all_get_params(array('action', 'id')) . 'action=edit&id=' . $val['id'], 'NONSSL') . '\'">' . "\n";
		} else {
			echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('subject_product_area', zen_get_all_get_params(array('id', 'action')) . 'id=' . $val['id'], 'NONSSL') . '\'">' . "\n";
		}
?>
						<td class="dataTableHeadingContent"><?php echo $val['id']?></td>
						<td class="dataTableHeadingContent"><?php echo $val['nameZh']?></td>
						<td class="dataTableHeadingContent"><?php echo ($val['status'] ? '<img src="images/icon_green_on.gif">' : '<img src="images/icon_red_on.gif">')?></td>
						<td class="dataTableHeadingContent"><?php echo $val['showIndex'] ? '是' : '否';?></td>
						<td class="dataTableHeadingContent"><?php echo $val['showIndexMobile'] ? '是' : '否';?></td>
						<td class="dataTableHeadingContent">
							<a href="<?php echo zen_href_link('subject_product_area', zen_get_all_get_params(array('action', 'id')) . 'action=edit&id=' . $val['id']);?>"><?php echo zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT);?></a>
							<?php
								if (isset($mInfo) && is_object($mInfo) && ($val['id'] == $mInfo->id)) {
									echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
								} else {
									echo '<a href="' . zen_href_link('subject_product_area', zen_get_all_get_params(array('id')) . 'id=' . $val['id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
								}
							?>
						</td>
					</tr>
<?php } ?>
					<tr>
						<td class="smallText" valign="top" colspan="2"><?php echo $area_split->display_count($query_numrows, $page_size, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SHIPPING_METHODS); ?></td>
						<td class="smallText" align="right" colspan="3"><?php echo $area_split->display_links($query_numrows, $page_size, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'id'))); ?></td>
					</tr>
				</table></td>
			</tr>
			<tr><td align="right"><a href="<?php echo zen_href_link('subject_product_area', zen_get_all_get_params(array('action', 'id', 'page')) . 'action=new', 'NONSSL');?>"><?php echo zen_image_button('button_insert_cn.png');?></a></td></tr>
		</table></td>
<?php
	$heading = array();
	$contents = array();
	$heading[] = array('text' => '<b>ID:' . $mInfo->id . '</b>');
	$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
	$str_table .= '<tr><td>专区名称: </td><td>' . $mInfo->nameZh . '</td></tr>';
	$languages = zen_get_languages();
	$name = unserialize($mInfo->name);
	foreach($languages as $l){
		$str_table .= '<tr><td>'.$l['code'].': </td><td>' . $name[$l['id']] . '</td></tr>';
	}
	$str_table .= '<tr><td>状态: </td><td>' . ($mInfo->status ? '开启' : '关闭') . '</td></tr>';
	$str_table .= '<tr><td>是否设置网站显示样式: </td><td>' . ($mInfo->showIndex ? '是' : '否') . '</td></tr>';
	$str_table .= '<tr><td>网站显示类型: </td><td>' . ($mInfo->indexTypeWeb == 10 ? '专区首页' : '商品列表上方内容') . '</td></tr>';
	$str_table .= '<tr><td>是否设置手机站显示样式: </td><td>' . ($mInfo->showIndexMobile ? '是' : '否') . '</td></tr>';
	$str_table .= '<tr><td>手机站显示类型: </td><td>' . ($mInfo->indexTypeMobile == 10 ? '专区首页' : '商品列表上方内容') . '</td></tr>';
	$str_table .= '<tr><td>创建人: </td><td>' . ($mInfo->add_admin ? $mInfo->add_admin : '/') . '</td></tr>';
	$str_table .= '<tr><td>创建时间: </td><td>' . ($mInfo->add_datetime ? $mInfo->add_datetime : '/') . '</td></tr>';
	$str_table .= '<tr><td>修改人: </td><td>' . ($mInfo->modify_admin ? $mInfo->modify_admin : '/') . '</td></tr>';
	$str_table .= '<tr><td>修改时间: </td><td>' . ($mInfo->modify_datetime ? $mInfo->modify_datetime : '/') . '</td></tr>';
	$str_table .= '</table>';
	$contents[] = array('text' => $str_table);

	$contents[] = array('text' => '<div><a  href="' . zen_href_link('subject_product_area', zen_get_all_get_params(array('action', 'id')) . 'action=edit&id=' . $mInfo->id) . '"><button style="width: 98px; margin-right: 4px;" class="simple_button">编辑</button></a><a href="' . zen_href_link(FILENAME_MARKETING_URL,zen_get_all_get_params(array('pID', 'action','page')) . 'action=subject&pID=' . $mInfo->id , 'NONSSL') . '"><button class="simple_button" style="width: 98px; margin-right: 4px;" id="get_url" data-url="'.zen_catalog_href_link_seo('subject', 'aId='.$mInfo->id).'">获取URL</button> </a><br/><br/> <button class="simple_button" id="empty_products" data-status="'.$mInfo->status.'" data-id="'.$mInfo->id.'">清空产品</button> </div><div id="show_tips"></div>');

	if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
		echo '<td width="25%" valign="top">';
		$box = new box;
		echo $box->infoBox($heading, $contents);
		echo '</td>';
	}
?>
			</tr>
		</table></td>
	</tr>
</table>

<form name="subject_product_area" action="subject_product_area.php?action=upload" method="post" enctype="multipart/form-data" onsubmit="return chk_upload();">
<table border="0" width="100%" cellspacing="2" cellpadding="2" style="width:100%;padding:20px;">
	<tr>
		<td class="pageHeading" colspan="2">商品导入:<br/><br/></td>
	</tr>
	<tr>
		<td class="td_name">专区选择：</td>
		<td class="td_value">
			<select name="up_area" id="up_area">
				<option value="">请选择一个专区...</option>
<?php
	foreach($subject_areas_all as $subject_area){
		if($subject_area['status'] == 0){
			continue;
		}
		echo '<option value="'.$subject_area['id'].'">[ID ' . $subject_area['id'] . '] '.$subject_area['nameZh'].'</option>';
	}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="td_name">导入商品：</td>
		<td class="td_value">
			<a style="margin-right: 10px;" href="file/subject_products.xlsx">下载模板</a>
			<input type="file" name="up_file" id="up_file" />
			<button class="simple_button">上传</button>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>
</table>
</form>

<form name="subject_product_area_remove" action="subject_product_area.php?action=remove_products" method="post" enctype="multipart/form-data">
	<table border="0" width="100%" cellspacing="2" cellpadding="2" style="width:100%;padding:20px;">
		<tr>
    		<td class="pageHeading" colspan="2">商品移除:<br/><br/></td>
    	</tr>
    	<tr>
    		<td style="font-size: 14px;"><span style="margin-left: 40px;">从指定专区下批量移除商品：</span><a style="margin-right: 15px;margin-left:15px;" href="file/subject_products_remove.xlsx">下载模板</a><input type="file" name="remove_file" id="remove_file" /><button class="simple_button">上传</button></td>
    	</tr>
	</table>
</form>
<?php
}
?>

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>