<?php
/**
* 功能: 促销区管理
* 作者: phc
* 时间: 2015年8月7日
* 文件: deals_list.php
*/ 
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'language.php');
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $promotion_types = array(0=>"",1=>"正常促销",2=>"DEALS活动");
  $promotion_discounts = array(10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95);

  $languages = zen_get_languages();
  $language_count = sizeof($languages);
  
  if(zen_not_null($action)){
  	switch ($action) {
  		case 'delete':
  			$pid = zen_db_prepare_input($_GET['pID']);		 			  			
  			$db->Execute("delete from " . TABLE_PROMOTION_AREA_DESCRIPTION . " where promotion_area_id = '" . (int)$pid . "'");
  			$db->Execute("delete from " . TABLE_PROMOTION_AREA . " where promotion_area_id = '" . (int)$pid . "'"); 
  			zen_redirect(zen_href_link(FILENAME_PROMOTION_AREA, 'page=' . $_GET['page']));
  			break;   
  		case 'save':  
  			$saveType=$_POST['save_type'];
  			$actionType = "insert";
  			if($saveType == 'edit')
  			{
  				$actionType = "update";
  			}
  			$pid=$_POST['pId'];
  			$pType=$_POST['pType'];
  			$pDiscount=$_POST['pDiscount']; //array 
  			$pStatus=$_POST['pStatus'];
  			$planguage = $_POST['planguage']; //array 
  			$pShowIndex=$_POST['pShowIndex'];
  			$pShowMobileIndex = $_POST['pShowMobileIndex'];
  			$page=$_POST['page'];
  			$admin_name = $_SESSION['admin_name'];
  			
  			$lang_infos = array();
  			for ($i = 0, $n = $language_count; $i < $n; $i++) { 
				$lang_id = $languages[$i]['id']; 
				$lang_infos[$lang_id] = array(
						"lang_info"=>$languages[$i],
						"pName"=>isset($_POST['pName'.$lang_id]) ? $_POST['pName'.$lang_id] : '',
						"pDesc"=>isset($_POST['pDesc'.$lang_id]) ? $_POST['pDesc'.$lang_id] : '',
						"pMobileDesc"=>isset($_POST['pMobileDesc'.$lang_id]) ? $_POST['pMobileDesc'.$lang_id] : ''
						
				);
  			}
  			  			
  			$pDiscountStr = implode(',', $pDiscount);
  			$planguageStr = implode(',', $planguage);
  			
  			$promotion_data_array = array( 
  					'promotion_area_type'=>isset($pType) ? intval($pType): 1,
  					'related_promotion_ids' => zen_db_prepare_input($pDiscountStr),
  					'promotion_area_name'=>zen_db_prepare_input($_POST['pName1']), 
  					'promotion_area_status' => zen_db_prepare_input((int)$pStatus),
  					'promotion_area_languages'=>zen_db_prepare_input($planguageStr),
  					'show_index'  => zen_db_prepare_input((int)$pShowIndex),
  					'show_mobile_index' => zen_db_prepare_input((int)$pShowMobileIndex)
  			);
  			
  			//var_dump($lang_infos);die(); 
  			$return_url = zen_href_link(FILENAME_PROMOTION_AREA);
  			if($actionType=='insert'){ 
  				zen_db_perform(TABLE_PROMOTION_AREA, $promotion_data_array, $actionType);
  				$pid=$db->insert_ID();
  				
  			}else{ 
  				zen_db_perform(TABLE_PROMOTION_AREA, $promotion_data_array, $actionType,"promotion_area_id = " . $pid . "");
  				
  				remove_promotion_area_info_from_memcache($pid);
  				
  				
  				$return_url = zen_href_link(FILENAME_PROMOTION_AREA,'pID='.$pid.'&page='.$page);
  			}
  			
  			//多语言表保存
  			$db->Execute("delete from " . TABLE_PROMOTION_AREA_DESCRIPTION . " where promotion_area_id = '" . (int)$pid . "'");
  			
  			foreach ($lang_infos as $key=>$value) {
  				$promotion_area_desc = array(
  						'promotion_area_id'=>(int)$pid,
  						'languages_id'=>(int)$key,
  						'promotion_area_name'=>zen_db_prepare_input($value['pName']),
  						'promotion_area_desc'=>''//zen_db_prepare_input($value['pDesc']),
  				); 
  				
  				zen_db_perform(TABLE_PROMOTION_AREA_DESCRIPTION, $promotion_area_desc, 'insert');
  				
  				//主页文件
  				if($pShowIndex == 1){
	  				$file_home = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES .$value['lang_info']['directory'] . '/html_includes/promotion_area/', 'promotion_area_index_'.$pid.'.php', 'false'); 
	  				file_put_contents($file_home, $value['pDesc']);
  				}
  				if($pShowMobileIndex == 1){
  					$promotion_area_mobile_index_arr = array(
  							'promotion_area_id'=>(int)$pid,
  							'languages_id'=>(int)$key,
  							'index_content'=>zen_db_prepare_input($value['pMobileDesc']),
  							'admin_name' => $admin_name,
  							'create_datetime' => 'now()'
  							//'promotion_area_desc'=>zen_db_prepare_input($value['pDesc'])
  					);
  					
  					$check_index_result = $db->Execute('select promotion_index_id from ' . TABLE_PROMOTION_AREA_MOBILE_INDEX . ' where promotion_area_id =' . (int)$pid . ' and languages_id = ' . (int)$key );
  						
  					if($check_index_result->RecordCount() > 0){
  						zen_db_perform(TABLE_PROMOTION_AREA_MOBILE_INDEX, $promotion_area_mobile_index_arr, 'update' , 'promotion_area_id =' . (int)$pid . ' and languages_id = ' . (int)$key);
  					}else{
  						zen_db_perform(TABLE_PROMOTION_AREA_MOBILE_INDEX, $promotion_area_mobile_index_arr, 'insert');
  					}
  				}
  			}
  			
  			zen_redirect($return_url);
  			
  			exit;
  			break;
  	}
  }
  
?>

<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>促销区管理设置</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="includes/jquery.js"></script> 
<script language="javascript" src="includes/javascript/common.js"></script>
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

	function change_promotion_type(clickObj)
	{
		var promotion_type = clickObj.val();
				
		var selectedBox = $("#divDicountBox span[data-promotion_type][data-promotion_type='"+promotion_type+"']");
		var unSelectedBox = $("#divDicountBox span[data-promotion_type][data-promotion_type!='"+promotion_type+"']"); 

		$("#divDicountBox :checkbox[data-promotion_type]").prop("checked",false);
		selectedBox.show();
		unSelectedBox.hide(); 
		$("#chkPromotionDiscountAll").prop('checked',false);
	}

	function change_language_choose_all()
	{ 
		var chooseAllObj = $("#chkLanguageAll");
		var checkBoxOjb = $("#spnLanguageBox :checkbox[name='planguage[]']");
		
		checkBoxOjb.prop('checked',chooseAllObj.is(":checked")); 
	}

	function change_language_choose_all_status(currentObj)
	{
		  var chooseAllObj = $("#chkLanguageAll");
		  var allCheckBoxOjb = $("#spnLanguageBox :checkbox[name='planguage[]']");
		  var checkedBoxOjb = $("#spnLanguageBox :checkbox[name='planguage[]']:checked");
		  var allCheckBoxCount = allCheckBoxOjb.size();
		  var choosedcheckBoxCount = checkedBoxOjb.size();
		  		  
		  if(allCheckBoxCount == choosedcheckBoxCount && allCheckBoxCount>0)
		  {
			  chooseAllObj.prop('checked',true); 
		  }
		  else
		  {
			  chooseAllObj.prop('checked',false); 
		  }		   
	}
	
  	$(document).ready(function(){
	  $('#btnCancel').click(function(){
		  window.location.href = '<?php echo zen_href_link(FILENAME_PROMOTION_AREA,'page='.$_GET['page'].(isset($_GET['pID'])?('&pID='.$_GET['pID']):'')) ?>';
		  return false;
	  });

	  $("[name='pType']").click(function(){
		  change_promotion_type($(this)) 
	  });
 
	  $("#chkLanguageAll").click(function(){
		  change_language_choose_all();
	  });

	  $("#spnLanguageBox :checkbox[name='planguage[]']").click(function(){
		  change_language_choose_all_status($(this));
	  });

	  $("#frm_promotion_info [name='pStatus']").click(function(){
		  var formObj = $('#frm_promotion_info');
		  var spnLanguageBoxObj= $("#spnLanguageBox",formObj);
		  
		  if($(this).val() == '1')
		  {
			  spnLanguageBoxObj.show();
		  }else
		  {
			  spnLanguageBoxObj.hide();
		  }		  
	  });

	  $("#chkPromotionDiscountAll").click(function(){
		  var chooseAllObj = $("#chkPromotionDiscountAll");
		  var checkBoxOjb = $("#divDicountBox span[data-promotion_type]:visible :checkbox[name='pDiscount[]']");
		  
		  checkBoxOjb.prop('checked',chooseAllObj.is(":checked"));
		  $("#divDicountBox span[data-promotion_type]:hidden :checkbox[name='pDiscount[]']").prop('checked',false); 
	  });

	  $("#divDicountBox").on('click',"span[data-promotion_type]:visible :checkbox[name='pDiscount[]']",function(){
		  var chooseAllObj = $("#chkPromotionDiscountAll");
		  var checkBoxOjb = $("#divDicountBox span[data-promotion_type]:visible :checkbox[name='pDiscount[]']");
		  var checkBoxSelectedOjb = $("#divDicountBox span[data-promotion_type]:visible :checkbox[name='pDiscount[]']:checked");
		  if(checkBoxOjb.size() == checkBoxSelectedOjb.size())
		  {
			  chooseAllObj.prop('checked',true); 
		  }
		  else
		  {
			  chooseAllObj.prop('checked',false); 
		  }
		  
	  });

	  $("#btnSubmit").click(function(){
		  var formObj = $(this).parents('form');
		  var pTypeObj = $("[name='pType']:checked",formObj);
		  var pTypeValue = pTypeObj.val();
		  var pDiscountObj = $(":checkbox[data-promotion_type='"+pTypeValue+"'][name='pDiscount[]']:checked",formObj);
		  var pNameObj = $("input.pName",formObj);
		  var pStatusObj = $("[name='pStatus']:checked",formObj);
		  var planguageObj= $(":checkbox[name='planguage[]']:checked",formObj);
		  var pShowIndexObj = $("[name='pShowIndex']:checked",formObj);
		  var pDescObj = $("textarea.pDesc",formObj);
		  var pShowMobileIndexObj = $("[name='pShowMobileIndex']:checked",formObj);
		  var pMobileDescObj = $("textarea.pMobileDesc",formObj);

		  //数据验证 
		  if(pTypeValue.isEmpty())
		  {
			  alert("促销区类型必须选择");
			  return false;
		  }

		  if(pDiscountObj.size() <=0)
		  {
			  alert("促销折扣必须选择");
			  return false;
		  }

		  is_name_error = false;
		  pNameObj.each(function(index){
			   if($(this).val().isEmpty())
			   {
				   alert("名称-["+$(this).attr('data-lang-name')+"]不能为空");
				   $(this).focus();
				   is_name_error = true;
				   return false;
			   }
		  });

		  if(is_name_error)
		  {
			 return false;
		  }
		  
		  var pStatusValue = pStatusObj.val();
		  if(pStatusValue == '1')
		  {
			  if(planguageObj.size() <=0)
			  {
				  alert("请选择开启的语种");
				  return false;
			  }
		  }

		  //首页是否需要验证?
		  var pShowIndexValue = pShowIndexObj.val();
		  if(pShowIndexValue == '1' )
		  {
			  is_index_error = false;
			  pDescObj.each(function(index){
				   if($(this).val() == null || $(this).val() == '')
				   {
					   alert("网页端首页-["+$(this).attr('data-lang-name')+"]不能为空");
					   $(this).focus();
					   is_index_error = true;
					   return false;
				   }
			  });

			  if(is_index_error)
			  {
				 return false;
			  }
				  
		  }

		  var pShowMobileIndexValue = pShowMobileIndexObj.val();
		  if(pShowMobileIndexValue == '1' )
		  {
			  is_index_error = false;
			  pMobileDescObj.each(function(index){
				   if($(this).val() == null || $(this).val() == '')
				   {
					   alert("手机端首页-["+$(this).attr('data-lang-name')+"]不能为空");
					   $(this).focus();
					   is_index_error = true;
					   return false;
				   }
			  });

			  if(is_index_error)
			  {
				 return false;
			  }
				  
		  }

		  //提交
		  formObj.submit();
		  	  
		  return false;
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
	  
	  change_language_choose_all_status();
  })//end of jquery readay 
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
 #fileDown{
	padding: 0 0 0 10px;
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
 
 #promotion_info tr{
 	height:40px; 
 }
 
 .info_column_title{
 	padding-right:5px; 
 	width:80px;
 }
 
 .info_column_content{
 	padding-left:5px; 
 }
 .info_red{
 	color:red;
 }
 .Wdate{
 	width:150px;
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
            <td class="pageHeading">营销功能设置 > <?php echo $action=='add'?'促销区新增':($action=='edit'?'促销区编辑':'促销区管理');?></td>
            <td align="right" class="pageHeading"><img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif"></td>
        </tr>
		</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td>           
<?php
if(!$action){ 
	$promotion_area = json_decode(SHOW_PROMOTION_AREA_NAVIGATION);
	$pageIndex = 1;
	If($_GET['page'])
	{
		$pageIndex = intval($_GET['page']);
	}
	$promotion_list_query_raw = "select promotion_area_id,promotion_area_type,  related_promotion_ids,  promotion_area_name,  promotion_area_status,  promotion_area_languages,  show_index from " . TABLE_PROMOTION_AREA . " order by promotion_area_id desc ";
	$promotion_list_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $promotion_list_query_raw, $query_numrows);
	$promotion_list = $db->Execute($promotion_list_query_raw);
	
	?> 
	</td></tr>
	<tr><td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <td valign="top" width='80%'>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left">ID</td> 
                <td class="dataTableHeadingContent" align="center">类型</td>
                <td class="dataTableHeadingContent" align="center">名称-en</td> 
                <td class="dataTableHeadingContent" align="center">状态</td>
                <td class="dataTableHeadingContent" align="center">是否设置首页</td>
                <td class="dataTableHeadingContent" align="right">操作</td>
              </tr>
              <?php 
              while(!$promotion_list->EOF){
					if ((!isset($_GET['pID']) || (isset($_GET['pID']) && ($_GET['pID'] == $promotion_list->fields['promotion_area_id']))) && !isset($pInfo)) {
						$pInfo_array = $promotion_list->fields;
						$pInfo = new objectInfo($pInfo_array); 
					}
					if (isset($pInfo) && is_object($pInfo) && ($promotion_list->fields['promotion_area_id'] == $pInfo->promotion_area_id)) {
						echo '<tr class="dataTableRowSelected">';
					}else{
						echo '<tr class="dataTableRow">';
					} 
					?>
					<td class="dataTableContent" align="left"><b><?php echo $promotion_list->fields['promotion_area_id'];?></b></td>  
					<td class="dataTableContent" align="center"><?php echo $promotion_types[$promotion_list->fields['promotion_area_type']];?></td>
                	<td class="dataTableContent" align="center"><?php echo $promotion_list->fields['promotion_area_name'];?></td> 
                	<td class="dataTableContent" align="center"><?php echo $promotion_list->fields['promotion_area_status']==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
                	<td class="dataTableContent" align="center"><?php echo $promotion_list->fields['show_index'] ==1?'是':'否';?></td> 
                	<td class="dataTableContent" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_PROMOTION_AREA, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $promotion_list->fields['promotion_area_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;<?php if ( (is_object($pInfo)) && ($promotion_list->fields['promotion_area_id'] == $pInfo->promotion_area_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_PROMOTION_AREA, 'page=' . $_GET['page'] . '&pID=' . $promotion_list->fields['promotion_area_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?></td>
                	</tr>
					<?php
					$promotion_list->MoveNext();
				}
              ?>
              <tr>
             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $promotion_list_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                <td class="dataTableHeadingContent" colspan="5" align="right"><?php echo $promotion_list_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'id'))); ?></td>
              </tr>
            </table>
            <table border="0" width="100%" cellspacing="0" cellpadding="2" style="margin:10px 0px;">
              <tr>
                <td width="50%" align="left"> 
                </td> 
                <td width="50%" align="right">
                	<a href='<?php  echo zen_href_link(FILENAME_PROMOTION_AREA,'action=add&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>新建</button></a>
                </td>
              </tr>
            </table>  
           </td>    
            <td valign="top">   
            <div class="infoBoxContent">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
  				<tbody><tr class="infoBoxHeading">
    					<td class="infoBoxHeading"><b>ID <?php echo $pInfo->promotion_area_id;?></b></td>
  						</tr>
				</tbody>
			</table>	 
			<?php if($pInfo && $pInfo->promotion_area_id>0){?>
			<p class="listshow"><b>名称-en:</b> <?php echo $pInfo->promotion_area_name;?></p>
			<p class="listshow"><b>类型:</b> <?php echo $promotion_types[$pInfo->promotion_area_type];?></p>  
			<p class="listshow"><b>状态:</b> <?php echo $pInfo->promotion_area_status==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></p>
				
			<table width="100%" border="0" cellspacing="0" cellpadding="12">
				<tr>
					<td width='50%' align='center'><a href="<?php echo zen_href_link(FILENAME_PROMOTION_AREA, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->promotion_area_id . '&action=edit', 'NONSSL')?>"><button class="simple_button">编辑</button></a></td>
					<td align='center'><a href="<?php echo zen_href_link(FILENAME_MARKETING_URL,zen_get_all_get_params(array('pID', 'action','page')) . 'action='.($pInfo->promotion_area_type == 2 ? 'promotion_deals':'promotion').'&pID=' . $pInfo->promotion_area_id , 'NONSSL')?>"><button class="simple_button">营销URL获取</button></a></td>
			   </tr>
			</table>
			<?php }?>
			</div>
            </td>
        	</tr>
    	</tbody>
    </table>
	<?php
	}else{
		?>
		<?php  
		if($action=='edit'&&isset($_GET['pID'])){
			$promotion_query_raw = "select promotion_area_id,promotion_area_type,  related_promotion_ids,  promotion_area_name,  promotion_area_status,  promotion_area_languages,  show_index , show_mobile_index from " . TABLE_PROMOTION_AREA . "  where promotion_area_id=".intval($_GET['pID'])." order by promotion_area_id desc limit 1";
			$promotion_info=$db->Execute($promotion_query_raw);
			
			if (!$promotion_area_query_result->EOF) {
				$promotion_discount_info = $promotion_info->fields;
				$pinfo = new objectInfo($promotion_info->fields); 
			}
			
		}
		
		if(!$promotion_discount_info)
		{
			$promotion_discount_info = array(
					"promotion_area_id"=>$_GET['pID'],
					"promotion_area_type"=>"1",
					"related_promotion_ids"=>"",
					"promotion_area_name"=>"",
					"promotion_area_languages" =>"", 
					"show_index"=>0,
					'show_mobile_index' => 0,
					"promotion_area_status"=>1
			);
			
		}  
		
		if($promotion_discount_info["related_promotion_ids"])
		{ 
			$promotion_discount_info["related_promotion_ids_array"] = explode(",",$promotion_discount_info["related_promotion_ids"]);
		}else
		{
			$promotion_discount_info["related_promotion_ids_array"] = array();
		}
		
		if($promotion_discount_info["promotion_area_languages"])
		{
			$promotion_discount_info["promotion_area_languages_array"] = explode(",",$promotion_discount_info["promotion_area_languages"]);
		}else 
		{
			$promotion_discount_info["promotion_area_languages_array"] = array();
		}
		
		?> 
		
		<form id="frm_promotion_info" name="frm_promotion_info" action="<?php echo zen_href_link(FILENAME_PROMOTION_AREA,'action=save')?>" method="post">
			<input type="hidden" name="save_type" value="<?php echo $_GET['action']?>" />
			<input type="hidden" name="pId" value="<?php echo $promotion_discount_info['promotion_area_id']?>" />
			<input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="promotion_info"> 
				<?php if($action=='edit'){?>
				<tr>
					<td class="info_column_title" align="right">ID:</td>
					<td class="info_column_content" ><?php echo $promotion_discount_info['promotion_area_id'];?></td>
				</tr>
				<?php }?>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>类型:</td>
					<td class="info_column_content" >
						<input type="radio" id="pType1" name="pType" value="1" <?php echo $promotion_discount_info['promotion_area_type']==1?'checked="checked"':'' ?>/><label for="pType1"><?php echo $promotion_types[1]?></label>
						<input type="radio" id="pType2" name="pType" value="2" <?php echo $promotion_discount_info['promotion_area_type']==2?'checked="checked"':'' ?>/><label for="pType2"><?php echo $promotion_types[2]?></label>
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>折扣:</td>
					<td class="info_column_content" >
						<div id="divDicountBox">
							<span style="margin-right: 5px;">
								<input type="checkbox" name="chkPromotionDiscountAll" id="chkPromotionDiscountAll">
								<label for="chkDiscountAll">所有</label>
							</span>
						<?php 
							$promotion_discount_query_raw = "select promotion_id,promotion_discount,promotion_start_time,promotion_end_time,promotion_status,promotion_type from " . TABLE_PROMOTION . " p WHERE p.promotion_status = 1 AND p.promotion_end_time >=NOW() order by p.promotion_id desc ";
							$promotion_discount_result = $db->Execute($promotion_discount_query_raw);
							
							$promotion_discount_array = array();
							
							if($promotion_discount_result->RecordCount() >0)
							{
								while(!$promotion_discount_result->EOF){
									$promotion_discount_array[] = $promotion_discount_result->fields;
									
									$promotion_discount_result->MoveNext();
								}
							}
						?>
						
						<?php if($promotion_discount_array){
							foreach ($promotion_discount_array as $item) {  
						?>
							<span style="margin-right: 5px;<?php echo $item['promotion_type'] != $promotion_discount_info['promotion_area_type'] ? 'display:none;':'';?>" data-promotion_type="<?php echo $item['promotion_type']?>" >
								<input type="checkbox" data-promotion_type="<?php echo $item['promotion_type']?>" id="pDiscount<?php echo $item['promotion_id']?>" name="pDiscount[]" value="<?php echo $item['promotion_id']?>"  <?php echo $promotion_discount_info["related_promotion_ids_array"] && in_array($item['promotion_id'], $promotion_discount_info["related_promotion_ids_array"]) ? 'checked="checked"':'' ?> />
								<label for="pDiscount<?php echo $item['promotion_id']?>"><?php echo '[ID:'.$item['promotion_id'].'] '.round($item["promotion_discount"],2)?>% off</label>
							</span>
						<?php }
						}?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>名称:</td>
					<td class="info_column_content" > 
						<table width="100%" border="0" cellspacing="0" cellpadding="0" id="spnAvableDiscountBox" <?php echo $promotion_discount_info['show_index'] != 1?'display:none':''?>">
							<?php 
								$promotion_desc_query_raw = "select promotion_area_desc_id,promotion_area_id,languages_id, promotion_area_name, promotion_area_desc  from " . TABLE_PROMOTION_AREA_DESCRIPTION . " p WHERE p.promotion_area_id =:promotion_area_id";
								$promotion_desc_query_raw = $db->bindVars($promotion_desc_query_raw, ':promotion_area_id', $promotion_discount_info['promotion_area_id'], 'integer'); 
								$promotion_desc_result = $db->Execute($promotion_desc_query_raw);
								
								$promotion_desc_array = array();
								
								if($promotion_desc_result->RecordCount() >0)
								{
									while(!$promotion_desc_result->EOF){
										$promotion_desc_array[$promotion_desc_result->fields['languages_id']] = $promotion_desc_result->fields;
										
										$promotion_desc_result->MoveNext();
									}
								} 
							?>
							<?php   
							for ($i = 0, $n = $language_count; $i < $n; $i++) { 
								$lang_id = $languages[$i]['id'];
							?> 
							<tr style="height: 25px;"> 
								<td style="width:60px;" align="right"><?php echo $languages[$i]['name']?> :</td>
								<td><input type="text" id="pName<?php echo $lang_id?>" class="pName" data-lang-name="<?php echo $languages[$i]['name']?>" name="pName<?php echo $lang_id?>" maxlength="200" style="width:400px;" value="<?php echo $promotion_desc_array && array_key_exists($lang_id, $promotion_desc_array)?$promotion_desc_array[$lang_id]['promotion_area_name']:'' ?>" /></td> 
							</tr>
							<?php }?> 
						</table>     
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right" ><span class="info_red">*</span>开关:</td>
					<td class="info_column_content" >
						<input type="radio" id="pStatus0" name="pStatus" value="0"  <?php echo $promotion_discount_info['promotion_area_status']==0?'checked="checked"':'' ?>/><label for="pStatus0">关闭</label>
						<input type="radio" id="pStatus1" name="pStatus" value="1"  <?php echo $promotion_discount_info['promotion_area_status']==1?'checked="checked"':'' ?>/><label for="pStatus1">开启</label>
						<div id="spnLanguageBox" style="padding-left:10px;<?php echo $promotion_discount_info['promotion_area_status'] != 1?'display:none':''?>">
							<input type="checkbox" id="chkLanguageAll" name="chkLanguageAll" >全部</input>
							<?php   
							for ($i = 0, $n = $language_count; $i < $n; $i++) { 
								$lang_id = $languages[$i]['id'];
							?>
							<input type="checkbox" id="planguage<?php echo $lang_id?>" name="planguage[]" value="<?php echo $lang_id;?>" <?php echo $promotion_discount_info["promotion_area_languages_array"] && in_array($lang_id, $promotion_discount_info["promotion_area_languages_array"]) ? 'checked="checked"':'' ?> ><?php echo $languages[$i]['name']?></input>
							<?php }?> 
						</div>
						
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right" width="200">是否设置首页?:</td>
					<td class="info_column_content" >
						<span style="margin-right: 10px;">网页端：</span>
						<input type="radio" id="pShowIndex0" name="pShowIndex" value="0"  <?php echo $promotion_discount_info['show_index']==0?'checked="checked"':'' ?>/><label for="pShowIndex0">否</label>
						<input type="radio" id="pShowIndex1" name="pShowIndex" value="1"  <?php echo $promotion_discount_info['show_index']==1?'checked="checked"':'' ?>/><label for="pShowIndex1">是</label>
					</td>
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
									$file_home = zen_get_file_directory(DIR_FS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/html_includes/promotion_area/', 'promotion_area_index_'.$promotion_discount_info['promotion_area_id'].'.php', 'false');
									
									$str_home = file_exists($file_home) ? file_get_contents($file_home) : '';
								
									if($i == 0){
										echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">' ;
									}else{
										echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">';
									}
								?>
									<textarea rows="9" style="width:40%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pDesc" id = "pDesc<?php echo $lang_id?>" name = "pDesc<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"><?php echo $str_home;?></textarea></div> 
								
								<?php }?> 
							</div>
						</div>  
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right" width="200"></td>
					<td class="info_column_content" >
						<span style="margin-right: 10px;">手机端：</span>
						<input type="radio" id="pShowIndex3" name="pShowMobileIndex" value="0"  <?php echo $promotion_discount_info['show_mobile_index']==0?'checked="checked"':'' ?>/><label for="pShowIndex3">否</label>
						<input type="radio" id="pShowIndex4" name="pShowMobileIndex" value="1"  <?php echo $promotion_discount_info['show_mobile_index']==1?'checked="checked"':'' ?>/><label for="pShowIndex4">是</label>
					</td>
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
									
									if($promotion_discount_info['promotion_area_id'] != null && $promotion_discount_info['promotion_area_id'] != 0){
										$sql = 'select promotion_area_id , languages_id , index_content from ' . TABLE_PROMOTION_AREA_MOBILE_INDEX . ' where languages_id = ' . $lang_id . ' and promotion_area_id = ' . $promotion_discount_info['promotion_area_id'];
										$index_query = $db->Execute($sql);
										
										if($index_query->RecordCount() > 0){
											$str_home = $index_query->fields['index_content'];
										}
									
									}
									
									if($i == 0){
										echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_mobile_textarea" class="mobile_index_area">' ;
									}else{
										echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_mobile_textarea" class="mobile_index_area">';
									}
								?>
									<textarea rows="9" style="width:40%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pMobileDesc" id = "pMobileDesc<?php echo $lang_id?>" name = "pMobileDesc<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"><?php echo $str_home;?></textarea></div> 
								
								<?php }?> 
							</div>
						</div>  
					</td>
				</tr>
				<tr>
					<td width="100px" align="left" colspan="2" style="padding-left:50px;">
						<input type="button" class="simple_button" name="btnSubmit" id="btnSubmit" value="保存" /> &nbsp;
						<input type="button" class="simple_button" name="btnCancel" id="btnCancel" value="取消">
					</td> 
				</tr>
			</table>
		</form> 
		 
		<?php
}
?>
</td>
</tr>
</tbody>
</table>
</body>
</html>