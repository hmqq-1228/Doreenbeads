<?php
/**
* 功能: 营销URL获取
* 作者: phc
* 时间: 2015年8月7日
* 文件: deals_list.php
*/ 
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'language.php');
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $promotion_types = array(0=>"",1=>"正常促销",2=>"DEALS活动");  
  
  $languages = zen_get_languages();
  $language_count = sizeof($languages);
  
  $pid = (isset($_GET['pID']) ? $_GET['pID'] : '');
  
  if(zen_not_null($action)){
  	switch ($action) {
  		case 'delete':
  			
  			break;   
  	}
  } 
?>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>营销URL获取</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="includes/jquery.js"></script> 
<script language="javascript" src="includes/javascript/ZeroClipboard.min.js"></script>
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

	function load_subject_category()
	{
  		var targetBoxObj = $("#sel_category_subject");
        $("option:not(.please_choose)",targetBoxObj).remove();
        
		var selectBoxObj = $("#sel_id_subject");
		var chooseOptionObj =  $("option:selected",selectBoxObj);

		var subject_id = chooseOptionObj.val(); 
		if(!subject_id.isEmpty() && subject_id >0)
		{
			$.ajax({ 
	           type:"POST", 
	           url:"promotion_ajax.php", 
	           datatype: "json",    
	           data:{action:"subject_category_tree",sId:subject_id},   
	           success:function(data){
	                $("#sel_category_subject").append(data);
	           }, 
	           error: function(){
	           	alert("Ajax加载商品专区类别树发生错误");  
	           	return false;
	           }        
	        });
		}		
    }
 		
  	$(document).ready(function(){
	  $('#btnChooseUrl').click(function(){
		  var chooseUrlType = $('#selChooseUrlType option:selected').val();
		  
		  if(chooseUrlType.isEmpty())
		  {
			alert('请选择需要获取的URL类型');
			return false;
		  }
		  
		  window.location.href = '<?php echo zen_href_link(FILENAME_MARKETING_URL) ?>?action='+chooseUrlType;
		  
		  return false;
	  });

	  $("#sel_id_subject").change(function(){
		  load_subject_category();
	  });

// 	  $(".content_box [name='btnCopyUrl']").click(function(){
// 		  var boxObj = $(this).parents('.content_box');
// 		  var txtUrlObj = $("input[name='generate_url']",boxObj);

// 		  var url = txtUrlObj.val();
// 		  if(url.isEmpty())
// 		  {
// 			  alert('要复制的URL内容为空，请先选择基本属性生成对应的URL后再点击复制按钮!');
// 			  return false;
// 		  }	else
// 		  {
			  
// 		  }

// 		  return false;	  
// 	  });  
	  
	  $("#btnGenerateSubjectUrl").click(function(){
		  var boxObj = $(this).parents('.content_box');
		  var txtUrlObj = $("input[name='generate_url']",boxObj);
		  var selLangSubjectSelectedObj = $("#sel_Lang_subject option:selected",boxObj);
		  var selIdSubjectSelectedObj = $("#sel_id_subject option:selected",boxObj);
		  var selCategorySubjectSelectedObj = $("#sel_category_subject option:selected",boxObj);

		  if(selLangSubjectSelectedObj.val().isEmpty())
		  {
			  alert('请选择语言!');
			  return false;
		  }

		  var url = selLangSubjectSelectedObj.attr('data-href');

		  var aId = selIdSubjectSelectedObj.val();
		  if(aId.isEmpty())
		  {
			  alert('请选择商品专区!');
			  return false;
		  }

		  url = url + '&aId='+aId;

		  var cId = selCategorySubjectSelectedObj.val();
		  if(!cId.isEmpty())
		  {
			  url = url + '&cId='+cId;
		  }

		  txtUrlObj.val(url);
		  
		  return false;
	  });  

	  $("#sel_Lang_promotion_deals").change(function(){
		  var boxObj = $(this).parents('.content_box');
		  var lang_id = $('option:selected',$(this)).attr('data-lang-id');
		  
		  
		  $('#sel_id_promotion_deals option[data-bind-lang]',boxObj).each(function(){ 
				if($(this).attr('data-bind-lang').indexOf(lang_id)>=0)
				{
					$(this).show();
				}else
				{
					$(this).hide();
					$(this).prop('selected',false);
				}
		  });

		  return false;
	  });
	  
	  $("#btnGeneratePromotionDealsUrl").click(function(){
		  var boxObj = $(this).parents('.content_box');
		  var txtUrlObjWeb = $("input[name='generate_url_web']",boxObj);
		  var txtUrlObjMob = $("input[name='generate_url_mob']",boxObj);
		  var selLangSelectedObj = $("#sel_Lang_promotion_deals option:selected",boxObj);
		  var selIdSelectedObj = $("#sel_id_promotion_deals option:selected",boxObj); 

		  if(selLangSelectedObj.val().isEmpty())
		  {
			  alert('请选择语言!');
			  return false;
		  }

		  var url = selLangSelectedObj.attr('data-href');
		  var url_mob = selLangSelectedObj.attr('data-href-mob');

		  var aId = selIdSelectedObj.val();
		  if(aId.isEmpty())
		  {
			  alert('请选择Deals区!');
			  return false;
		  }

		  url = url + '&aId='+aId;
		  url_mob = url_mob + '&aId='+aId;
		  
		  txtUrlObjWeb.val(url);
		  txtUrlObjMob.val(url_mob);
		  
		  return false;
	  });  

	  $("#btnGenerateDailyDealsUrl").click(function(){
		  var boxObj = $(this).parents('.content_box');
		  var txtUrlObjWeb = $("input[name='generate_url_web']",boxObj);
		  var txtUrlObjMob = $("input[name='generate_url_mob']",boxObj);
		  var selLangSelectedObj = $("#sel_Lang_daily_deals option:selected",boxObj);
		  var selIdSelectedObj = $("#sel_id_daily_deals option:selected",boxObj); 

		  if(selLangSelectedObj.val().isEmpty())
		  {
			  alert('请选择语言!');
			  return false;
		  }

		  var url = selLangSelectedObj.attr('data-href');
		  var url_mob = selLangSelectedObj.attr('data-href-mob');

		  var aId = selIdSelectedObj.val();
		  if(aId.isEmpty())
		  {
			  alert('请选择一口价Deals区!');
			  return false;
		  }

		  url = url + '&g='+aId;
		  url_mob = url_mob + '&g='+aId;

		  txtUrlObjWeb.val(url);
		  txtUrlObjMob.val(url_mob);
		  
		  return false;
	  });  
	  

	  $("#sel_Lang_promotion").change(function(){
		  var boxObj = $(this).parents('.content_box');
		  var lang_id = $('option:selected',$(this)).attr('data-lang-id');
		  
		  
		  $('#sel_id_promotion option[data-bind-lang]',boxObj).each(function(){ 
				if($(this).attr('data-bind-lang').indexOf(lang_id)>=0)
				{
					$(this).show();
				}else
				{
					$(this).hide();
					$(this).prop('selected',false);
				}
		  });

		  return false;
	  });

	  $("#sel_id_promotion").change(function(){
		  var boxObj = $(this).parents('.content_box');
		  var promotion_area_id = $('option:selected',$(this)).val();
		  var related_promotion_id = $('option:selected',$(this)).attr('data-bind-discount');

		  $("#div_discount_box_promotion .discount_box",boxObj).remove();
		  $("#sel_category_promotion option[level]",boxObj).remove();
		  
		  if(!promotion_area_id.isEmpty() && promotion_area_id >0 && !related_promotion_id.isEmpty())
		  {
				$.ajax({ 
		           type:"POST", 
		           url:"promotion_ajax.php", 
		           datatype: "html",    
		           data:{action:"promotion_area_discount_info",aId:promotion_area_id,related_id:related_promotion_id},   
		           success:function(data){
	 		            var jsonData = parseToJson(data); 
	 	           		if(!jsonData.isSuccess)
	 	           		{ 
	 			        	alert(jsonData.errorMsg);
	 			        	return false;
	 			        } 

						$("#div_discount_box_promotion",boxObj).append(jsonData.discount_info);
						$("#sel_category_promotion",boxObj).append(jsonData.category_info);
		        	   
		           }, 
		           error: function(){
		           	alert("Ajax加载促销区折扣发生错误");  
		           	return false;
		           }        
		        });
			}	
		 		 
		  return false;
	  });

	  $("#chkPromotionDiscountAll").click(function(){
		  var chooseAllObj = $("#chkPromotionDiscountAll");
		  var checkBoxOjb = $("#div_discount_box_promotion :checkbox[name='pDiscount']");
			
		  checkBoxOjb.prop('checked',chooseAllObj.is(":checked")); 
	  });

	  $("#div_discount_box_promotion").on('click',":checkbox[name='pDiscount']",function(){
		  var chooseAllObj = $("#chkPromotionDiscountAll");
		  var checkBoxOjb = $("#div_discount_box_promotion :checkbox[name='pDiscount']");
		  var checkBoxSelectedOjb = $("#div_discount_box_promotion :checkbox[name='pDiscount']:checked");
		  if(checkBoxOjb.size() == checkBoxSelectedOjb.size())
		  {
			  chooseAllObj.prop('checked',true); 
		  }
		  else
		  {
			  chooseAllObj.prop('checked',false); 
		  }
		  
	  });
	  
	  
	  $("#btnGeneratePromotionsUrl").click(function(){
		  var boxObj = $(this).parents('.content_box');
		  var txtUrlObjWeb = $("input[name='generate_url_web']",boxObj);
		  var txtUrlObjMob = $("input[name='generate_url_mob']",boxObj);
		  var selLangSelectedObj = $("#sel_Lang_promotion option:selected",boxObj);
		  var selIdSelectedObj = $("#sel_id_promotion option:selected",boxObj); 
		  var chkSeletedObj = $("#div_discount_box_promotion :checkbox[name='pDiscount']:checked",boxObj); 
		  var selCategorySelectedObj = $("#sel_category_promotion option:selected",boxObj);
		  	
			
		  if(selLangSelectedObj.val().isEmpty())
		  {
			  alert('请选择语言!');
			  return false;
		  }

		  var url = selLangSelectedObj.attr('data-href');
		  var url_mob = selLangSelectedObj.attr('data-href-mob');

		  var aId = selIdSelectedObj.val();
		  if(aId.isEmpty())
		  {
			  alert('请选择促销区!');
			  return false;
		  }

		  url = url + '&aId='+aId;
		  url_mob = url_mob + '&aId='+aId;
		
		  var discounts = new Array();
		  chkSeletedObj.each(function(){
			  discounts.push($(this).val());
		  });
		  
		  if(discounts.length >0)
		  {
			  var discountStr = discounts.join('_');
			  url = url + '&off='+discountStr;
			  url_mob = url_mob + '&off='+discountStr;
		  }

		  var cId = selCategorySelectedObj.val();
		  if(!cId.isEmpty())
		  {
			  url = url + '&cId='+cId;
			  url_mob = url_mob + '&aId='+aId;
		  }
		  
		  txtUrlObjWeb.val(url);
		  txtUrlObjMob.val(url_mob);
		  
		  return false;
	  });  
	  
	  <?php if($action == 'subject') {?>
	  load_subject_category();
	  <?php }?>
  })//end of jquery readay 
</script>
<style>
.simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    margin-left: 20px;
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
 	width:90px;
 	height:40px; 
 }
 
 .info_column_content{
 	padding-left:5px; 
 	height:40px; 
 }
 .info_red{
 	color:red;
 }
 .info_select_style{
 	width:200px;
 }
 .url_style{
 	width:80%;
 	height:25px; 
 	background-color:#A7A8A4;
 }
</style>
</head>
<body onLoad="init()">
	<div id="spiffycalendar" class="text"></div>
	<?php require(DIR_WS_INCLUDES . 'header.php'); 
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border-collapse:collapse;">
	  <tbody>
		  <tr>
		  	<td width="100%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
			    	<tbody>
			    	<tr>
			            <td class="pageHeading">营销功能设置 > 营销URL获取</td>
			            <td align="right" class="pageHeading"><img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif"></td>
			        </tr>
					</tbody>
				</table>
			 </td>
		   </tr>  
			<tr style="border:1px;border-style:none none dashed none; ">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >  
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>请选择:</td>
							<td class="info_column_content" >
								<select id="selChooseUrlType" name="selChooseUrlType" class="info_select_style">   
									<option value="subject" <?php echo $_GET['action'] == 'subject'?'selected="selected"':'';?> >获取商品专区的URL</option>
									<option value="promotion" <?php echo $_GET['action'] == 'promotion'?'selected="selected"':'';?> >获取促销区的URL</option>
									<option value="promotion_deals" <?php echo $_GET['action'] == 'promotion_deals'?'selected="selected"':'';?> >获取折扣DEALS活动区的URL</option> 
									<option value="daily_deals" <?php echo $_GET['action'] == 'daily_deals'?'selected="selected"':'';?> >获取一口价DEALS区的URL</option> 
								</select> 
								&nbsp;&nbsp;
								<input type="button" class="simple_button" name="btnChooseUrl" id="btnChooseUrl" value="确定" />
							</td>
						</tr>
					</table>
				</td>
			</tr>  
		<?php
		if($action=='subject'){
		?> 
			<tr id="tr_box_subject">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="content_box">  
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>语言:</td>
							<td class="info_column_content" >
								<select id="sel_Lang_subject" name="sel_Lang_subject" class="info_select_style"> 
									<option value="" >请选择</option>
									<?php foreach ($languages as $lang) { 
									?>
									<option value="<?php echo $lang['code'];?>" data-href="<?php echo HTTP_SERVER.'/'.($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=products_common_list&pn=subject'?>"><?php echo $lang['name'];?></option>
									<?php }?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>商品专区:</td>
							<td class="info_column_content" >
								<select id="sel_id_subject" name="sel_id_subject" class="info_select_style"> 
									<option value="" class="please_choose">请选择</option>
									<?php 
									$sql_query_subject = "select `id`,`nameZh`,`name`,`status`  from " . TABLE_SUBJECT_AREAS . " WHERE `status` = 1 order by `id` desc";
									$sql_query_subject_result = $db->Execute($sql_query_subject);
									
									$query_subject_array = array();
									
									if($sql_query_subject_result->RecordCount() >0)
									{
										while(!$sql_query_subject_result->EOF){
											$query_subject_array[] = $sql_query_subject_result->fields;
									
											$sql_query_subject_result->MoveNext();
										}
									}
									
									if($query_subject_array)
									{
										foreach ($query_subject_array as $item) 
										{ 
										?>
										<option value="<?php echo $item['id'];?>" <?php echo $item['id'] == $pid ?'selected="selected"':'';?>  ><?php echo '[ID:'.$item['id'].']  '.$item['nameZh'];?></option>
										<?php 
										}
									}
									?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">类别:</td>
							<td class="info_column_content" >
								<select id="sel_category_subject" name="sel_category_subject" class="info_select_style"> 
									<option value="" class="please_choose">请选择</option> 
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
								<input type="button" class="simple_button" name="btnGenerateSubjectUrl" id="btnGenerateSubjectUrl" value="生成URL" />
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">生成的URL:</td>
							<td class="info_column_content" >
								<input type="text" id="txt_generate_url_<?php echo $action;?>" name="generate_url" value="" class="url_style" readonly="readonly" /><br />
								<span  class="info_red">（注：必须先选择基本信息并点击“生成URL”后才能获取对应的URL；此处不可修改）。</span>
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
								<input type="button" data-clipboard-target="txt_generate_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" />
							</td>
						</tr>
					</table>
				</td>
			</tr>  
		<?php
		}else if($action=='promotion'){
		?> 
			<tr id="tr_box_promotion">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="content_box">  
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>语言:</td>
							<td class="info_column_content" >
								<select id="sel_Lang_promotion" name="sel_Lang_promotion" class="info_select_style"> 
									<option value="" >请选择</option>
									<?php foreach ($languages as $lang) { 
									?>
									<option value="<?php echo $lang['code'];?>" data-lang-id="<?php echo $lang['id'];?>" data-href-mob="<?php echo HTTP_MOBILESITE_SERVER . '/' . ($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=promotion'?>" data-href="<?php echo HTTP_SERVER.'/'.($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=promotion'?>"><?php echo $lang['name'];?></option>
									<?php }?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>促销区:</td>
							<td class="info_column_content" >
								<select id="sel_id_promotion" name="sel_id_promotion" class="info_select_style"> 
									<option value="" class="please_choose">请选择</option>
									<?php 
									$sql_query_promotion_deals = "select promotion_area_id,promotion_area_name,  promotion_area_languages,related_promotion_ids from " . TABLE_PROMOTION_AREA . " where promotion_area_status = 1 and promotion_area_type = 1 order by promotion_area_id desc ";
									$sql_query_promotion_deals_result = $db->Execute($sql_query_promotion_deals);
									
									$querypromotion_deals_array = array();
									
									if($sql_query_promotion_deals_result->RecordCount() >0)
									{
										while(!$sql_query_promotion_deals_result->EOF){
											$querypromotion_deals_array[] = $sql_query_promotion_deals_result->fields;
									
											$sql_query_promotion_deals_result->MoveNext();
										}
									}
									
									if($querypromotion_deals_array)
									{
										foreach ($querypromotion_deals_array as $item) 
										{ 
										?>
										<option  value="<?php echo $item['promotion_area_id'];?>" style="display:none;" data-bind-lang="<?php echo $item['promotion_area_languages'];?>" data-bind-discount="<?php echo $item['related_promotion_ids'];?>" ><?php echo '[ID:'.$item['promotion_area_id'].']  '.$item['promotion_area_name'];?></option>
										<?php 
										}
									}
									?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">折扣:</td>
							<td class="info_column_content" >
								
								<div id="div_discount_box_promotion"> 	
									<span style="margin-right: 5px;">
										<input type="checkbox" name="chkPromotionDiscountAll" id="chkPromotionDiscountAll">
										<label for="chkDiscountAll">所有</label>
									</span>	
								</div>
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">类别:</td>
							<td class="info_column_content" >
								<select id="sel_category_promotion" name="sel_category_promotion" class="info_select_style"> 
									<option value="" class="please_choose">请选择</option> 
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
								<input type="button" class="simple_button" name="btnGeneratePromotionUrl" id="btnGeneratePromotionsUrl" value="生成URL" />
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">生成的URL:</td>
							<td class="info_column_content" >
								<div style="position: relative;top: 10px;">
									<div style="margin-bottom:10px;"><span style="margin-right: 35px;">网站URL:</span><input type="text" id="txt_generate_web_url_<?php echo $action;?>" name="generate_url_web" value="" class="url_style" readonly="readonly" /><input type="button" data-clipboard-target="txt_generate_web_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
									<div><span style="margin-right: 22px;">手机站URL:</span><input type="text" id="txt_generate_mob_url_<?php echo $action;?>" name="generate_url_mob" value="" class="url_style" readonly="readonly" /><input type="button" data-clipboard-target="txt_generate_mob_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
									<span  class="info_red">（注：必须先选择基本信息并点击“生成URL”后才能获取对应的URL；此处不可修改）。</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
							</td>
						</tr>
					</table>
				</td>
			</tr>  
			<?php
		}else if($action=='promotion_deals'){
		?> 
			<tr id="tr_box_promotion_deals">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="content_box">  
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>语言:</td>
							<td class="info_column_content" >
								<select id="sel_Lang_promotion_deals" name="sel_Lang_promotion_deals" class="info_select_style"> 
									<option value="" >请选择</option>
									<?php foreach ($languages as $lang) { 
									?>
									<option value="<?php echo $lang['code'];?>" data-lang-id="<?php echo $lang['id'];?>" data-href-mob="<?php echo HTTP_MOBILESITE_SERVER.'/'.($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=promotion_deals'?>" data-href="<?php echo HTTP_SERVER.'/'.($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=promotion_deals'?>"><?php echo $lang['name'];?></option>
									<?php }?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>折扣Deals区:</td>
							<td class="info_column_content" >
								<select id="sel_id_promotion_deals" name="sel_id_promotion_deals" class="info_select_style"> 
									<option value="" class="please_choose">请选择</option>
									<?php 
									$sql_query_promotion_deals = "select promotion_area_id,promotion_area_name,  promotion_area_languages,related_promotion_ids from " . TABLE_PROMOTION_AREA . " where promotion_area_status = 1 and promotion_area_type = 2 order by promotion_area_id desc ";
									$sql_query_promotion_deals_result = $db->Execute($sql_query_promotion_deals);
									
									$querypromotion_deals_array = array();
									
									if($sql_query_promotion_deals_result->RecordCount() >0)
									{
										while(!$sql_query_promotion_deals_result->EOF){
											$querypromotion_deals_array[] = $sql_query_promotion_deals_result->fields;
									
											$sql_query_promotion_deals_result->MoveNext();
										}
									}
									
									if($querypromotion_deals_array)
									{
										foreach ($querypromotion_deals_array as $item) 
										{ 
										?>
										<option  value="<?php echo $item['promotion_area_id'];?>" <?php echo $item['promotion_area_id'] == $pid ?'selected="selected"':'style="display:none;"';?> data-bind-lang="<?php echo $item['promotion_area_languages'];?>"  data-bind-discount="<?php echo $item['related_promotion_ids'];?>" ><?php echo '[ID:'.$item['promotion_area_id'].']  '.$item['promotion_area_name'];?></option>
										<?php 
										}
									}
									?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
								<input type="button" class="simple_button" name="btnGeneratePromotionDealsUrl" id="btnGeneratePromotionDealsUrl" value="生成URL" />
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">生成的URL:</td>
							<td class="info_column_content" >
								<div style="position: relative;top: 10px;">
									<div style="margin-bottom:10px;"><span style="margin-right: 35px;">网站URL:</span><input type="text" id="txt_generate_web_url_<?php echo $action;?>" name="generate_url_web" value="" class="url_style" readonly="readonly" /><input type="button" data-clipboard-target="txt_generate_web_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
									<div><span style="margin-right: 22px;">手机站URL:</span><input type="text" id="txt_generate_mob_url_<?php echo $action;?>" name="generate_url_mob" value="" class="url_style" readonly="readonly" /><input type="button" data-clipboard-target="txt_generate_mob_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
									<span  class="info_red">（注：必须先选择基本信息并点击“生成URL”后才能获取对应的URL；此处不可修改）。</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
							</td>
						</tr>
					</table>
				</td>
			</tr>  
		<?php
		}else if($action=='daily_deals'){
		?> 
			<tr id="tr_box_daily_deals">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="content_box">  
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>语言:</td>
							<td class="info_column_content" >
								<select id="sel_Lang_daily_deals" name="sel_Lang_daily_deals" class="info_select_style"> 
									<option value="" >请选择</option>
									<?php foreach ($languages as $lang) { 
									?>
									<option value="<?php echo $lang['code'];?>" data-lang-id="<?php echo $lang['id'];?>" data-href-mob="<?php echo HTTP_MOBILESITE_SERVER.'/'.($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=promotion_price'?>" data-href="<?php echo HTTP_SERVER.'/'.($lang['code']=='en'?'':$lang['code'].'/').'index.php?main_page=promotion_price'?>"><?php echo $lang['name'];?></option>
									<?php }?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right"><span class="info_red">*</span>一口价Deals区:</td>
							<td class="info_column_content" >
								<select id="sel_id_daily_deals" name="sel_id_daily_deals" class="info_select_style"> 
									<option value="" class="please_choose">请选择</option>
									<?php 
									$sql_query_dailydeal_deals_sql = "select `dailydeal_area_id`, `area_name`, `start_date`, `end_date`, `expire_interval`, `area_status` from " . TABLE_DAILYDEAL_AREA . " where area_status = 1 and `end_date` >=now() order by dailydeal_area_id desc ";
									$sql_query_dailydeal_deals_result = $db->Execute($sql_query_dailydeal_deals_sql);
									
									$sql_query_dailydeal_deals_array = array();
									if($sql_query_dailydeal_deals_result->RecordCount() >0)
									{
										while(!$sql_query_dailydeal_deals_result->EOF){
											$sql_query_dailydeal_deals_array[] = $sql_query_dailydeal_deals_result->fields;
									
											$sql_query_dailydeal_deals_result->MoveNext();
										}
									}
									
									if($sql_query_dailydeal_deals_array)
									{
										foreach ($sql_query_dailydeal_deals_array as $item) 
										{ 
										?>
										<option  value="<?php echo $item['dailydeal_area_id'];?>" <?php echo $item['dailydeal_area_id'] == $pid ?'selected="selected"':'';?> ><?php echo '[ID:'.$item['dailydeal_area_id'].']  '.$item['area_name'];?></option>
										<?php 
										}
									}
									?>
								</select> 
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
								<input type="button" class="simple_button" name="btnGenerateDailyDealsUrl" id="btnGenerateDailyDealsUrl" value="生成URL" />
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">生成的URL:</td>
							<td class="info_column_content" >
								<div style="position: relative;top: 10px;">
									<div style="margin-bottom:10px;"><span style="margin-right: 35px;">网站URL:</span><input type="text" id="txt_generate_web_url_<?php echo $action;?>" name="generate_url_web" value="" class="url_style" readonly="readonly" /><input type="button" data-clipboard-target="txt_generate_web_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
									<div><span style="margin-right: 22px;">手机站URL:</span><input type="text" id="txt_generate_mob_url_<?php echo $action;?>" name="generate_url_mob" value="" class="url_style" readonly="readonly" /><input type="button" data-clipboard-target="txt_generate_mob_url_<?php echo $action;?>" class="simple_button copytoclipboard" name="btnCopyUrl"  value="复制" /></div>
									<span  class="info_red">（注：必须先选择基本信息并点击“生成URL”后才能获取对应的URL；此处不可修改）。</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="info_column_title" align="right">&nbsp;</td>
							<td class="info_column_content" >
							</td>
						</tr>
					</table>
				</td>
			</tr>  
		<?php }?>
	  </tbody>
	</table>
</body>
</html>