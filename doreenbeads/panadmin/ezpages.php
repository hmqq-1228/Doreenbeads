<?php

/**

 * @package admin

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: ezpages.php 4279 2006-08-26 03:31:29Z drbyte $

 */

  require('includes/application_top.php');
  $languages = zen_get_languages();
  $language_count = sizeof($languages);

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  if (zen_not_null($action)) {
	  switch ($action) {
	  	case 'add':
	  	case 'update':
	  		$page = zen_db_input($_POST['page']);
	  		$pages_id = zen_db_input($_POST['pages_id']);
	  		$pages_name = zen_db_input($_POST['pages_name']);
	  		$ez_breadcrumb = $_POST['ez_breadcrumb'];
	  		$ez_title = $_POST['ez_title'];
	  		$page_status_web = zen_db_input($_POST['ez_status_web']);
	  		$page_status_mobile = zen_db_input($_POST['ez_status_mobile']);
	  		$left_sidebox = zen_db_input($_POST['left_sidebox']);
	  		$right_sidebox = zen_db_input($_POST['right_sidebox']);
	  		$page_content_web = $_POST['pDesc'];
	  		$page_content_mobile = $_POST['pDesc_mobile'];
	  		$error_array = array();
	  		$simple_num = 0;
	  		$admin_email = zen_db_input($_SESSION['admin_email']);
	  		$current_date = date('Y-m-d H:i:s');
	  		
	  		// for ($i = 1 ; $i < sizeof($languages) ; $i++){
	  		// 	if($ez_breadcrumb[$i] != ''){
	  		// 		if($page_content_web[$i] == '' && $page_content_mobile[$i] == ''){
	  		// 			$error_array[] = "请填写" + $languages[$i-1]['name'] + "站点的网页端或手机端HTML Content代码！";
	  		// 		}
	  		// 	}else{
	  		// 		if($page_content_web[$i] != '' || $page_content_mobile[$i] != '' ){
	  		// 			$error_array[] = "请填写" + $languages[$i-1]['name'] + "站点的导航名称！";
	  		// 		}else{
	  		// 			$simple_num++;
	  		// 		}
	  		// 	}
	  		// }
	  		
	  		if($simple_num == 4){
	  			$error_array[] = '请填写活动页面的导航名称!';
	  		}
	  		
	 		if($page_status_web == false){
	  			$error_array[] = '请选择网页端页面的开启状态！';
	  		}
	  		
	  		if($page_status_mobile == false){
	  			$error_array[] = '请选择手机端页面的开启状态！';
	  		}
	  		
	  		if(sizeof($error_array) == 0){
	  			$page_data_arr = array(
	  				'pages_name' => $pages_name,
	  				'status_page_web' => $page_status_web,
	  				'status_page_mobile' => $page_status_mobile,
	  				'status_page_web' => $page_status_web,
	  				'status_left_sidebox' => $left_sidebox
	  			);
	  			
	  			if($action == 'add'){
	  				$extra_arr = array(
		  				'admin_email' => $admin_email,
		  				'create_datetime' => $current_date
	  				);
	  			}else{
	  				$extra_arr = array(
	  					'modify_admin' => $admin_email,
	  					'modify_datetime' => $current_date
	  				);
	  			}
	  			
	  			$page_data_arr = array_merge($page_data_arr , $extra_arr);
	  			
	  			if($action == 'add'){
	  				zen_db_perform(TABLE_EZPAGES, $page_data_arr);
	  				$pages_id = zen_db_insert_id();
	  			}else{
	  				zen_db_perform(TABLE_EZPAGES, $page_data_arr , 'update' , 'pages_id =' . $pages_id);
	  			}
	  			
	  			for ($i = 1 ; $i <= sizeof($languages) ; $i++){
	  				$page_description_arr = array(
	  					'pages_id' => $pages_id,
	  					'languages_id' => $i,
	  					'pages_title' => $ez_title[$i],
	  					'pages_breadcrumb' => $ez_breadcrumb[$i],
	  					'pages_html_text_web' => zen_db_prepare_input($page_content_web[$i]),
	  					'pages_html_text_mobile' => zen_db_prepare_input($page_content_mobile[$i])
	  				);
	  				
	  				if($action == 'add'){
	  					zen_db_perform(TABLE_EZPAGES_DESCRIPTION, $page_description_arr);
	  				}else{
	  					zen_db_perform(TABLE_EZPAGES_DESCRIPTION, $page_description_arr , 'update' , 'pages_id =' . $pages_id . ' and languages_id =' . $i);
	  				}
	  				$memcache->delete(md5(MEMCACHE_PREFIX . 'get_ezpages_display_style'));
	  			}
	  		}else{
	  			foreach ($error_array as $error){
	  				$messageStack->add_session($error,'error');
	  			}
	  		}
	  		zen_redirect(zen_href_link(FILENAME_EZPAGES_ADMIN , ((isset($page) && $page >1 && $action != 'add') ? 'page='.$page : '') .((isset($pages_id) && $pages_id > 0 ) ?('&eID='.$pages_id):'')));
	  	break;
	  }
  }
  $pageIndex = 1;
  if($_GET['page']){
  	  $pageIndex = intval($_GET['page']);
  }
  
  $ezpage_raw = 'SELECT ze.pages_id , ze.pages_name, ze.status_page_web , ze.status_page_mobile , admin_email , create_datetime , modify_admin , modify_datetime from ' . TABLE_EZPAGES . ' ze order by pages_id DESC';
  $ezpage_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $ezpage_raw, $query_numrows);
  $ezpage_list = $db->Execute($ezpage_raw);
  
  ?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="includes/menu.js"></script>

<script language="javascript" src="includes/general.js"></script>

<script language="javascript" src="includes/jquery.js"></script> 

<script language="javascript" src="includes/javascript/ZeroClipboard.min.js"></script>

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

  if (typeof _editor_url == "string") HTMLArea.replaceAll();

  }

  // -->
  function process_json(data){
	  var returnInfo=eval('('+data+')');
	  return returnInfo;
  }
  
$(document).ready(function(){
	if (window.clipboardData){
    	$(".copytoclipboard").click(function(){ 
			window.clipboardData.setData("Text",$('input[name="generate_url"]').val()); 
			alert('复制成功!');
		});
	}else{
		if($(".copytoclipboard").size()>0)
		{
			 ZeroClipboard.config({swfPath: "includes/javascript/ZeroClipboard.swf"});
			 
			$(".copytoclipboard").each(function(){ 
			     var client = new ZeroClipboard($(this));
			     
				 client.on("ready", function(readyEvent){ 
				    client.on("beforecopy", function(event){
				    	
					});
					client.on("aftercopy", function(event){
						//复制成功后事件
						alert('复制成功!');
					});
				 }); 
			});
		}
	}

	$("#btnGenerateSubjectUrl").click(function(){
		var website = $("select[name='website_code']").val();
		var link = $("select[name='link']>option:selected").attr('link_'+ website);

		$("input[name='generate_url']").val(link);
	});
	
	
	  $(".language_title").click(function(){
		  	var lang = $(this).attr("language");
		  	$(this).siblings().removeClass("checked");
			$(this).addClass("checked");
			$('#'+lang+'_textarea').css("display","block").siblings(".index_area").css("display","none");
			
		});

	  $(".language_title_mobile").click(function(){
		  	var lang = $(this).attr("language");
		  	$(this).siblings().removeClass("checked");
			$(this).addClass("checked");
			$('#'+lang+'_textarea_mobile').css("display","block").siblings(".index_area").css("display","none");
			
		});

	  $('#btnCancel').click(function(){
		  window.location.href = '<?php echo zen_href_link(FILENAME_EZPAGES_ADMIN,'page='.$_GET['page'].(isset($_GET['eID'])?('&eID='.$_GET['eID']):'')) ?>';
		  return false;
	  });

	  $("#btnSubmit").click(function(){
		  var formObj = $(this).parents('form');
		  var breadcrumb =  new Array();
		  var page_id = $("input[name='page_id']").val();
		  var status_web = $("input[name='ez_status_web']:checked").val();
		  var status_mobile = $("input[name='ez_status_mobile']:checked").val();
		  var web_content = new Array();
		  var mobile_content = new Array();
		  var languages = new Array("英语站","德语站","俄语站","法语站");
		  var error = false;
		  var action = $("input[name='stage']").val();
		  var left_sidexbox = $("input[name='left_sidebox']:checked").val();
		  var simple_num = 0;
		  var i = 0;
		  
		  $(".breadcrumb").each(function(){
			  breadcrumb[i] = $(this).val();
			  i++;
		  });
		  i = 0;
		  $(".pDesc").each(function(){
			  web_content[i] = $(this).val();
			  i++;
		  });
		  i = 0;
		  $(".pDesc_mobile").each(function(){
			  mobile_content[i] = $(this).val();
			  i++;
		  });
		  
		  // if(!error){
			 //  for(i = 0; i < 4;i++){
				//   if(breadcrumb[i] != ''){
				// 	  if(web_content[i] == '' && mobile_content[i] == ''){
				// 		    alert("请填写" + languages[i] + "站点的网页端或手机端HTML Content代码！");
							
				// 			error = true;
				// 		}
				// 	  }else{
				// 		  if(web_content[i] != '' || mobile_content[i] != ''){
				// 				alert("请填写" + languages[i] + "站点的导航名称！");
				// 				error = true;
				// 			}else{
				// 				simple_num++;
				// 			}
				// 	  }
			 //  }
		  // }

		  if(simple_num == 4 && !error){
			  alert("请填写活动页面的导航名称!");
		      error = true;
		  }

		  if((status_web == null || status_web == '' || status_web == 0) && !error){
			  alert("请选择网页端页面的开启状态！");
			  error = true;
		  }

		  if((status_mobile == null || status_mobile == '' || status_mobile == 0) && !error){
			  alert("请选择手机端页面的开启状态！");
			  error = true;
		  }

	  	  if((left_sidexbox == null || left_sidexbox == '') && !error){
			  alert("请选择左侧边栏显示情况！");
			  error = true;
		  }

		  if(error){
			return false;
		  }
		//提交
		formObj.submit();
	  });
	
	
});

</script>
<style type="text/css">
.listshow{
	margin-left:10px;
}
.index_area{
	display:inline-block;
}

.simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;
}

 .language_title , .language_title_mobile{
	display: inline-block;
    border: 1px solid #A9A9A9;
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
 	background-color: #AEAFB6;
	font-weight:bold;
 }
 .title{
 	width:200px;
 	font-size:25px;
 	font-weight: bold;
 	margin-left:30px;
 	line-height:60px;
 }
 
 .form_area{
	 line-height:25px;
	 margin-left:80px;
 }
 .ez_breadcrumb{
 	width: 250px;
    display: inline-block;
 }
 
 .secend_title{
 	display: inline-block;
    float: left;
    padding: 35px 15px;
    margin-right: 20px;
 }
 .mix_area{
 	margin-top:15px;
 	margin-bottom:15px;
 }
 .thr_title{
 	display: inline-block;
    width: 60px;
 }
 
 .info_red{
 	color:red;
 	position: relative;
    top: 3px;
    margin-right: 3px;
 }
 
 input[type=radio]{
 	position:relative;
 	top:3px;
 	margin-right: 3px;
 }
 
 .content_title{
    display: inline-block;
    float: left;
    margin-right: 15px;
 }
</style>
</head>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->
<?php if($action == 'new' || $action == 'edit'){ 
	if($action ==  "edit" && $_GET['eID'] != '' && $_GET['eID'] > 0){
		$edit_ezpage_query = $db->Execute('SELECT pages_id ,pages_name,  status_page_web ,status_page_mobile , status_left_sidebox  from ' . TABLE_EZPAGES . ' where pages_id = ' . zen_db_input($_GET['eID']));
		
		if($edit_ezpage_query->RecordCount() > 0){
			$ezpage_info = array();
			$pages_id = $edit_ezpage_query->fields['pages_id'];
		
			$ezpage_info['pages_id'] = $pages_id;
			$ezpage_info['pages_name'] = $edit_ezpage_query->fields['pages_name'];
			$ezpage_info['status_page_web'] = $edit_ezpage_query->fields['status_page_web'];
			$ezpage_info['status_page_mobile'] = $edit_ezpage_query->fields['status_page_mobile'];
			$ezpage_info['status_left_sidebox'] = $edit_ezpage_query->fields['status_left_sidebox'];
			
			$ezpage_info_query = $db->Execute('SELECT languages_id , pages_title , pages_breadcrumb , pages_html_text_web ,pages_html_text_mobile from ' . TABLE_EZPAGES_DESCRIPTION . ' where pages_id = ' . $pages_id . ' order by languages_id asc;');
			
			if($ezpage_info_query->RecordCount() > 0){
				while (!$ezpage_info_query->EOF){
					$languages_id = $ezpage_info_query->fields['languages_id'];
					
					$ezpage_info['description'][$languages_id]['pages_title'] = $ezpage_info_query->fields['pages_title'];
					$ezpage_info['description'][$languages_id]['pages_breadcrumb'] = $ezpage_info_query->fields['pages_breadcrumb'];
					$ezpage_info['description'][$languages_id]['pages_html_text_web'] = $ezpage_info_query->fields['pages_html_text_web'];
					$ezpage_info['description'][$languages_id]['pages_html_text_mobile'] = $ezpage_info_query->fields['pages_html_text_mobile'];
					
					$ezpage_info_query->MoveNext();
				}
			}
			
		}else{
			zen_redirect(zen_href_link(FILENAME_EZPAGES_ADMIN,'page='.$_GET['page'].(isset($_GET['eID'])?('&eID='.$_GET['eID']):'')));
		}
	}
	
?>
		<div class="create_area">
			<div class="area_title">
				<span class="title">EZ-Page编辑页面</span>
			</div>
			<?php echo zen_draw_form('create_ezpage', FILENAME_EZPAGES_ADMIN , 'action='. ($action == 'new' ? "add" : "update")  , 'post' , "enctype='multipart/form-data'")?>
				<div class="form_area">
					<div class="mix_area"><?php zen_draw_hidden_field('stage' , $action);echo zen_draw_hidden_field('page' , $_GET['page']);?>
						<div style="padding: 15px;margin-right: 20px;">
							<span>活动名称：</span>
							<?php echo zen_draw_input_field('pages_name' , $ezpage_info['pages_name'])?>
						</div>
						<div class="secend_title">
							<span class="info_red">*</span><span>导航名称：</span>
							<?php 
								if($action == 'edit'){
									echo zen_draw_hidden_field('pages_id' , $pages_id);
								}
							?>
						</div>
						<div class="ez_breadcrumb">
							<?php
							for ($i = 0, $n = $language_count; $i < $n; $i++) {
								echo '<span class="thr_title">' . $languages[$i]['name'] . ':</span>';
								echo zen_draw_input_field('ez_breadcrumb[' . $languages[$i]['id'] . ']' , $ezpage_info['description'][$i+1]['pages_breadcrumb'] , 'class="breadcrumb"');
								echo '<br/>';
							}
							 ?>
						</div>
					</div>
					<div class="mix_area">
						<div class="secend_title" style="margin-right: 30px;">
							<span>页面标题：</span>
						</div>
						<div class="ez_title">
							<?php 
							for ($i = 0, $n = $language_count; $i < $n; $i++) {
								echo '<span class="thr_title">' . $languages[$i]['name'] . ':</span>';
								echo zen_draw_input_field('ez_title[' . $languages[$i]['id'] . ']' , $ezpage_info['description'][$i+1]['pages_title'] , 'class="title_input"');
								echo '<br/>';
							}
							 ?>
						</div>
					</div>
					<div style="margin: 15px;">
					<div style="margin: 15px;">
						<div><span class="info_red">*</span><span>网页端状态：</span><span style="margin-right:10px;"><?php echo zen_draw_radio_field('ez_status_web' , 10 ,$action == 'edit' ? $ezpage_info['status_page_web'] == 10 : true , '' , 'id="ez_open_web"');?><label for="ez_open_web">开启</label></span><span style="margin-right:10px;"><?php echo zen_draw_radio_field('ez_status_web' , 20 ,$action == 'edit' ? $ezpage_info['status_page_web'] == 20 : false, '' , 'id="ez_close_web"');?><label for="ez_close_web">关闭</label></span></div>
						<div class="sidebox" ><span>隐藏网页端左侧边栏：</span><span style="margin-right:10px;"><?php echo zen_draw_radio_field('left_sidebox' , 10 , $action == 'edit' ? $ezpage_info['status_left_sidebox'] == 10 : true , '' , 'id="display_left_sidebox"');?><label for="display_left_sidebox">是</label></span><span style="margin-right:10px;"><?php echo zen_draw_radio_field('left_sidebox' , 20 ,$action == 'edit' ? $ezpage_info['status_left_sidebox'] == 20 : false , '' , 'id="none_left_sidebox"');?><label for="none_left_sidebox">否</label></span></div>
					</div>
					<div>
						<div class="content_title">
							<span class="info_red">*</span><span>网页端HTML Content:</span>
						</div>
						<div class="index_area">
							<div class="index_language"> 
							<?php 
							for ($i = 0, $n = $language_count; $i < $n; $i++) {
								if($i == 0){
									echo '<div class="language_title checked" language="' . $languages[$i][code] . '" >' . $languages[$i]['name'] . '</div>';
								}else{
									echo '<div class="language_title" language="' . $languages[$i][code] . '" >' . $languages[$i]['name'] . '</div>';
								}
							}
							
								for ($i = 0, $n = $language_count; $i < $n; $i++) {
									$lang_id = $languages[$i]['id'];
								
									if($i == 0){
										echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">' ;
									}else{
										echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">';
									}
								?>
									<textarea rows="9" style="width:200%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pDesc" id = "pDesc<?php echo $lang_id?>" name = "pDesc[<?php echo $languages[$i]['id']?>]" data-id="<?php echo $lang_id;?>"><?php echo htmlentities($ezpage_info['description'][$i+1]['pages_html_text_web']);?></textarea></div> 
								
								<?php }?> 
							</div>
						</div>
					</div>
					<div><span class="info_red">*</span><span>手机端状态：</span><span style="margin-right:10px;"><?php echo zen_draw_radio_field('ez_status_mobile' , 10 ,$action == 'edit' ? $ezpage_info['status_page_mobile'] == 10 : true , '' , 'id="ez_open_mobile"');?><label for="ez_open_mobile">开启</label></span><span style="margin-right:10px;"><?php echo zen_draw_radio_field('ez_status_mobile' , 20 ,$action == 'edit' ? $ezpage_info['status_page_mobile'] == 20 : false, '' , 'id="ez_close_mobile"');?><label for="ez_close_mobile">关闭</label></span></div>
						<div style="margin-top:20px;">
						<div class="content_title">
							<span class="info_red">*</span><span>手机端HTML Content:</span>
						</div>
						<div class="index_area">
							<div class="index_language"> 
							<?php 
							for ($i = 0, $n = $language_count; $i < $n; $i++) {
								if($i == 0){
									echo '<div class="language_title_mobile checked" language="' . $languages[$i][code] . '" >' . $languages[$i]['name'] . '</div>';
								}else{
									echo '<div class="language_title_mobile" language="' . $languages[$i][code] . '" >' . $languages[$i]['name'] . '</div>';
								}
							}
							
								for ($i = 0, $n = $language_count; $i < $n; $i++) {
									$lang_id = $languages[$i]['id'];
								
									if($i == 0){
										echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_textarea_mobile" class="index_area">' ;
									}else{
										echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_textarea_mobile" class="index_area">';
									}
								?>
									<textarea rows="9" style="width:200%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pDesc_mobile" id = "pDesc<?php echo $lang_id?>_mobile" name = "pDesc_mobile[<?php echo $languages[$i]['id']?>]" data-id="<?php echo $lang_id;?>"><?php echo htmlentities($ezpage_info['description'][$i+1]['pages_html_text_mobile']);?></textarea></div> 
								
								<?php }?> 
							</div>
						</div>
					</div>
					<div style="line-height: 50px;padding-left: 20%;">
						<input type="button" class="simple_button" name="btnSubmit" id="btnSubmit" value="保存" /> &nbsp;
						<input type="button" class="simple_button" name="btnCancel" id="btnCancel" value="取消">
					</div>
			<?php echo '</form>';?>
		</div>
	<?php 	
		
}else{?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr>
			<td><span class="title">EZ-Pages列表页面</span></td>
		</tr>
		<tr>
			<td valign="top" width="80%">
	<!-- 			<table width="100%" border="0" cellspacing="2" cellpadding="2"> -->
	<!-- 				<tr> -->
	<!-- 					<td> -->
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td >
										<table width="100%" border="0" cellspacing="0" cellpadding="2">
											<tr class="dataTableHeadingRow">
								                <td class="dataTableHeadingContent" align="center">Page_id</td>
								                <td class="dataTableHeadingContent" align="center">导航名称</td>
								                <td class="dataTableHeadingContent" align="center">活动名称</td>
								                <td class="dataTableHeadingContent" align="center">状态(W)</td>
								                <td class="dataTableHeadingContent" align="center">状态(M)</td>
								                <td class="dataTableHeadingContent" align="right"><span style="padding-right: 10px;">操作</span></td>
								              </tr>
										
											<?php 
												$ezpage_display_info = array();
												$n = 1;
												while (!$ezpage_list->EOF){
													$ezpage_display_info[$n] = $ezpage_list->fields;
													$ezpages_description_query = $db->Execute('SELECT  pages_title, pages_breadcrumb FROM ' . TABLE_EZPAGES_DESCRIPTION . ' where pages_id = ' . $ezpage_list->fields['pages_id'] . ' and pages_breadcrumb != "" ORDER BY languages_id ASC limit 1');
													if($ezpages_description_query->RecordCount() > 0){
														$ezpage_display_info[$n] = array_merge($ezpage_display_info[$n] , $ezpages_description_query->fields);
													}
													
													$n++;
													$ezpage_list->MoveNext();
												}
												
												for ($i = 1; $i <= sizeof($ezpage_display_info) ; $i++){
													if ((!isset($_GET['eID']) || (isset($_GET['eID']) && ($_GET['eID'] == $ezpage_display_info[$i]['pages_id']))) && !isset($pInfo)) {
														$pInfo_array = $ezpage_display_info[$i];
														
														$pInfo = new objectInfo($pInfo_array);
													}
													
													if (isset($pInfo) && is_object($pInfo) && ($ezpage_display_info[$i]['pages_id'] == $pInfo->pages_id)) {
														echo '<tr class="dataTableRowSelected">';
													}else{
														echo '<tr class="dataTableRow">';
													}
											?>
												<td class="dataTableContent" align="center"><?php echo $ezpage_display_info[$i]['pages_id'];?></td>
												<td class="dataTableContent" align="center"><b><?php echo $ezpage_display_info[$i]['pages_breadcrumb'] != '' ? $ezpage_display_info[$i]['pages_breadcrumb'] : '/';?></b></td> 
												<td class="dataTableContent" align="center"><?php echo $ezpage_display_info[$i]['pages_name'] != '' ? $ezpage_display_info[$i]['pages_name'] : '/';?></td>
												<td class="dataTableContent" align="center"><?php echo $ezpage_display_info[$i]['status_page_web'] == 10 ? zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON) : zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
												<td class="dataTableContent" align="center"><?php echo $ezpage_display_info[$i]['status_page_mobile'] == 10 ? zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON) : zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
												<td class="dataTableContent" align="right">
												<?php echo '<a href="' . zen_href_link(FILENAME_EZPAGES_ADMIN, zen_get_all_get_params(array('eID', 'action')) . 'eID=' . $ezpage_display_info[$i]['pages_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
												<?php if ( (is_object($pInfo)) && ($ezpage_display_info[$i]['pages_id'] == $pInfo->pages_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_EZPAGES_ADMIN, zen_get_all_get_params(array('action' , 'eID' , 'page')) . 'page=' . $pageIndex . '&eID=' . $ezpage_display_info[$i]['pages_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
												</td>
											</tr>
											<?php 
													
												}
											?>
											<tr><td> </td></tr>
											<tr>
								             	<td class="dataTableHeadingContent" colspan="2" align="left"><?php echo $ezpage_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
								                <td class="dataTableHeadingContent" colspan="4" align="right"><?php echo $ezpage_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'eID'))); ?></td>
								            </tr>
										</table>
									</td>
									<td>
									</td>
								</tr>
							</table>
							 <table border="0" width="100%" cellspacing="0" cellpadding="2" style="margin:10px 0px;">
				              	<tr>
				                	<td width="50%" align="left">
				                	&nbsp;&nbsp; 
				                	</td> 
				                	<td width="50%" align="right">
				                		<a href='<?php  echo zen_href_link(FILENAME_EZPAGES_ADMIN,'action=new&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>新建</button></a>
				                	</td>
				              </tr>
				            </table> 
	<!-- 					</td> -->
	<!-- 				</tr> -->
	<!-- 			</table> -->
			</td>
			<?php if($action == 'generate_url'){?>
				<td valign="top">
				<div class="infoBoxContent">
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  				<tbody>
		  					<tr class="infoBoxHeading">
		    					<td class="infoBoxHeading"><b>ID <?php echo $pInfo->pages_id;?></b></td>
		  					</tr>
						</tbody>
					</table>
					<div style="margin: 15px;">
						<div style="line-height:20px;margin-top:10px;margin-bottom:10px;">
							<?php
								$language_link = array();
								echo '<div>';
								echo '<span class="info_red">*</span><span style="margin-right: 32px;">语言:</span>';
								echo '<select rel="dropdown" name="link" style="margin-left: 25px;">';
								foreach ($languages as $l_values){
									echo '<option link_web="' . HTTP_SERVER  . '/' . ($l_values['code'] == 'en' ? '' :  $l_values['code'] . '/'  )  . 'page.html?id=' . $pInfo->pages_id . '" link_mobile = "' . 'https://m.' . BASE_SITE . '/' . ($l_values['code'] == 'en' ? '' :  $l_values['code'] . '/'  ) . 'page.html?id=' . $pInfo->pages_id . '">' . $l_values['name'] . '</option>';
								}
								echo '</select>';
								echo '</div>';
								
								$website_arr = array(array('id' => 'web' , 'text' => '网站' ) , array('id' => 'mobile' , 'text' => '手机') );
								echo '<div>';
								echo '<span class="info_red">*</span><span style="margin-right: 32px;">应用场景:</span>';
								echo zen_draw_pull_down_menu('website_code', $website_arr, '' , 'style="width: 73px;"');
								echo '</div>';
							?>
						</div>
						<div style="margin-left: 50px;"><input type="button" class="simple_button" name="btnGenerateSubjectUrl" id="btnGenerateSubjectUrl" value="生成URL" /></div>
						<div style="line-height:20px;margin-top:10px;margin-bottom:10px;">
							<span>生成的URL：</span><span ><input type="text" name="generate_url" value="" id="copy_content" class="url_style" readonly="readonly" style="width: 250px;line-height: 20px;"/><br />
								<span  class="info_red">（注：生成的URL不可修改，点击下方的“复制”按钮，即可将生成的URL复制到剪贴板。</span></span>
						</div>
						<table width="100%" border="0" cellspacing="0" cellpadding="12">
							<tr>
								<td width='50%' align='left'>
									<input type="button" class="simple_button copytoclipboard" data-clipboard-target="copy_content" name="btnCopyUrl"  value="复制" />
								</td>
								<td width='50%' align='center'>
									<a href="<?php echo zen_href_link(FILENAME_EZPAGES_ADMIN, zen_get_all_get_params(array('eID', 'action' , 'page')) . 'eID=' . $pInfo->pages_id .'&page=' . $pageIndex , 'NONSSL')?>"><button class="simple_button">取消</button></a>
								</td>
							</tr>
						</table>
				</div>
			</td>
			<?php 
			}else{
			?>
			<td valign="top">
				<div class="infoBoxContent">
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  				<tbody>
		  					<tr class="infoBoxHeading">
		    					<td class="infoBoxHeading"><b>ID <?php echo $pInfo->pages_id;?></b></td>
		  					</tr>
						</tbody>
					</table>
					<p class="listshow"><b>活动名称:</b> <?php echo $pInfo->pages_name != ''? $pInfo->pages_name : '/';?></p>
					<p class="listshow"><b>导航名称:</b> <?php echo $pInfo->pages_breadcrumb  != '' ? $pInfo->pages_breadcrumb : '/';?></p> 
					<p class="listshow"><b>页面标题:</b> <?php echo $pInfo->pages_title != '' ? $pInfo->pages_title : '/';?></p> 
					<p class="listshow"><b>创建人:</b> <?php echo $pInfo->admin_email ? $pInfo->admin_email : '/';?></p> 
					<p class="listshow"><b>创建时间:</b> <?php echo $pInfo->create_datetime ? $pInfo->create_datetime : '/';?></p> 
					<p class="listshow"><b>修改人:</b> <?php echo $pInfo->modify_admin ? $pInfo->modify_admin : '/';?></p> 
					<p class="listshow"><b>修改时间:</b> <?php echo $pInfo->modify_datetime ? $pInfo->modify_datetime : '/';?></p> 
					
					<table width="100%" border="0" cellspacing="0" cellpadding="12">
						<tr>
							<td width='50%' align='left'>
								<a href="<?php echo zen_href_link(FILENAME_EZPAGES_ADMIN, zen_get_all_get_params(array('eID', 'action')) . 'eID=' . $pInfo->pages_id . '&action=edit', 'NONSSL')?>"><button class="simple_button">编辑</button></a>
							</td>
							<?php if($pInfo->status_page_web == 10 || $pInfo->status_page_mobile == 10){?>
							<td width='50%' align='center'>
								<a href="<?php echo zen_href_link(FILENAME_EZPAGES_ADMIN, zen_get_all_get_params(array('eID', 'action')) . 'eID=' . $pInfo->pages_id . '&action=generate_url&page=' . $pageIndex, 'NONSSL')?>"><button class="simple_button">获取URL</button></a>
							</td>
							<?php }?>
						</tr>
					</table>
				</div>
			</td>
			<?php }?>
		</tr>
	</table>
<?php 
  }
?>
<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->



</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>