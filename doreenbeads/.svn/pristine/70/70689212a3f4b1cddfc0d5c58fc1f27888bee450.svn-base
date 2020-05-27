<?php
require('includes/application_top.php');
define('TEXT_DISPLAY_NUMBER_OF_TRENDS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> display area informations)');
$action = (isset($_GET['action']) ? $_GET['action'] : '');

$promotion_type_array = array(array('id' => '0' , 'text' => '请选择...'), array('id' => '10' , 'text' => '正常促销') , array('id' => '20' , 'text' => 'Deals活动') , array('id' => '30' , 'text' => '一口价Deals'));
$promotion_status_array = array(array('id' => '0' , 'text' => '全部'), array('id' => '10' , 'text' => '活动') , array('id' => '20' , 'text' => '未开始') , array('id' => '30' , 'text' => '已结束'), array('id' => '40' , 'text' => '已禁用'));
$sort_array = array(array('id' => '1' , 'text' => '按照ID由大到小排序'), array('id' => '2' , 'text' => '优先级由大到小排序'));
$languages = zen_get_languages();
$language_count = sizeof($languages);

switch ($action){
	case 'check_promotion_area':
		$promotion_type = $_GET['promotion_type'];
		$promotion_id = $_GET['promotion_id'];
		$error_info_array = array('is_error' => false , 'error_info' => '');
		
		if(in_array($promotion_type , array(10 , 20))){
			$check_promotion_area_query = $db->Execute('SELECT related_promotion_ids , promotion_area_status FROM ' . TABLE_PROMOTION_AREA . ' WHERE promotion_area_id = "' . $promotion_id . '" AND promotion_area_type = "' . intval($promotion_type)/10 . '"');
			
			if($check_promotion_area_query->RecordCount() > 0){
				if($check_promotion_area_query->fields['promotion_area_status'] != 0){
					$check_relate_area = $db->Execute('SELECT promotion_id , promotion_start_time , promotion_end_time  FROM ' . TABLE_PROMOTION . ' WHERE promotion_id in (' . $check_promotion_area_query->fields['related_promotion_ids'] . ') and promotion_end_time > now() and promotion_status = 1');
					
					if($check_relate_area->RecordCount() == 0){
						$error_info_array['is_error'] = true;
						$error_info_array['error_info'] = '该促销区下的所有折扣区状态均为“已结束”，请重新填写一个促销区ID。';
					}
				}else{
					$error_info_array['is_error'] = true;
					$error_info_array['error_info'] = '该促销区已禁用。';
				}
			}else{
				$error_info_array['is_error'] = true;
				$error_info_array['error_info'] = '该促销区ID不存在。';
			}
		}else{
			$check_promotion_area_query = $db->Execute('SELECT start_date , end_date , area_status FROM ' . TABLE_DAILYDEAL_AREA . ' WHERE dailydeal_area_id = "' . $promotion_id .'"');
		
			if($check_promotion_area_query->RecordCount() > 0){
				if($check_promotion_area_query->fields['area_status'] != 0){
					if(strtotime($check_promotion_area_query->fields['end_date']) < time()){
						$error_info_array['is_error'] = true;
						$error_info_array['error_info'] = '该一口价Deals区状态均为“已结束”，请重新填写一个一口价Deals区ID。';
					}
				}else{
					$error_info_array['is_error'] = true;
					$error_info_array['error_info'] = '该一口价Deals区状态均为“已结束”，请重新填写一个一口价Deals区ID。';
				}
			}else{
				$error_info_array['is_error'] = true;
				$error_info_array['error_info'] = '该一口价Deals区ID不存在。';
			}
		}
		
		echo json_encode($error_info_array);
		exit;
		break;
	case 'create':
		$promotion_type = intval($_GET['promotion_type']);
		$promotion_id = intval($_GET['promotion_id']);
		$display_level= intval($_GET['display_level']);
		
		for ($i = 0, $n = $language_count; $i < $n; $i++) {
			$lang_id = $languages[$i]['id'];
			$pName[$lang_id] = $_GET['pName'.$lang_id];
			$pDesc[$lang_id] = $_GET['pDesc'.$lang_id];
		}
		
		$display_area_data = array(
			'promotion_id' => $promotion_id,
			'promotion_type' => $promotion_type,
		    'display_level' => $display_level,
			'create_admin' => $_SESSION['admin_name'],
			'create_datetime' => 'now()'
		);
		
		zen_db_perform(TABLE_PROMOTION_DISPLAY_AREA, $display_area_data);
		$insert_id = $db->insert_ID();
		
		foreach ($pName as $key => $value){
			$display_area_description_data = array(
				'display_area_id' => $insert_id,
				'languages_id' => $key,
				'display_picture_url' => $value,
				'display_area_description' => $pDesc[$key]
			);
			
			zen_db_perform(TABLE_PROMOTION_DISPLAY_AREA_DESCRIPTION, $display_area_description_data);
		}
		
		zen_redirect(zen_href_link('promotion_display_area'));
		break;
	case 'update':
		$display_area_id = intval($_GET['display_area_id']);
		$promotion_type = intval($_GET['promotion_type']);
		$promotion_id = intval($_GET['promotion_id']);
		$display_level= intval($_GET['display_level']);
		$pre_link = $_GET['pre_link'];
		
		for ($i = 0, $n = $language_count; $i < $n; $i++) {
			$lang_id = $languages[$i]['id'];
			$pName[$lang_id] = $_GET['pName'.$lang_id];
			$pDesc[$lang_id] = $_GET['pDesc'.$lang_id];
		}
		
		$display_area_data = array(
				'promotion_id' => $promotion_id,
				'promotion_type' => $promotion_type,
		        'display_level' => $display_level,
				'modify_admin' => $_SESSION['admin_name'],
				'modify_datetime' => 'now()'
		);
		
		zen_db_perform(TABLE_PROMOTION_DISPLAY_AREA, $display_area_data , 'update' , 'display_area_id="' . $display_area_id . '"');
		
		foreach ($pName as $key => $value){
			$display_area_description_data = array(
					'display_picture_url' => $value,
					'display_area_description' => $pDesc[$key]
			);
			
			zen_db_perform(TABLE_PROMOTION_DISPLAY_AREA_DESCRIPTION, $display_area_description_data , 'update' , 'display_area_id="' . $display_area_id . '" and languages_id ="' . $key . '"');
		}
		
		zen_redirect($pre_link);
		break;
	case 'close_display':
		$area_id = (int)$_GET['id'];
	
		if($area_id != '' && $area_id > 0){
			$sql = 'update ' . TABLE_PROMOTION_DISPLAY_AREA . ' set display_status = 20, modify_admin="' . $_SESSION['admin_name'] . '", modify_datetime = now() where display_area_id = ' . $area_id;
				
			$db->Execute($sql);
		}
	
		zen_redirect(zen_href_link('promotion_display_area' , zen_get_all_get_params(array('action')) ));
		break;
}
?>
<!doctype html public"-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>Display Aera</title>
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
</script>
<script type="text/javascript">
	function process_json(data){
		var returnInfo=eval('('+data+')');
		return returnInfo;
	}
	function scale(num)  
    {  
     var reg = /^(0|[1-9]\d?|100)$/;  
     if(!num.match(reg)){  
      return false;  
     }else{  
      return true;  
     }  
    } 
	
	$(document).ready(function(){
		  $('#btnCancel').click(function(){
			  window.location.href = '<?php echo zen_href_link('promotion_display_area','page='.$_GET['page'].(isset($_GET['id'])?('&id='.$_GET['id']):'')) ?>';
			  return false;
		  });

		  $(".language_title").click(function(){
			  	var lang = $(this).attr("language");
			  	$(this).siblings().removeClass("checked");
				$(this).addClass("checked");
				$('#'+lang+'_textarea').css("display","block").siblings(".index_area").css("display","none");
				
			});

		$('#btnSubmit').click(function(){
			var formObj = $(this).parents('form');
			var promotion_type = $('select[name=promotion_type]').val();
			var promotion_id = $('input[name=promotion_id]').val();
			var en_pic_url = $('#pName1').val();
			var de_pic_url = $('#pName2').val();
			var ru_pic_url = $('#pName3').val();
			var fr_pic_url = $('#pName4').val();
			var error = false;

			$("#type_error").text('');
			$("#id_error").text('');
			$("#language_error_en").text('');
			$("#language_error_de").text('');
			$("#language_error_ru").text('');
			$("#language_error_fr").text('');

			if(promotion_type == 0 || promotion_type == null ){
				error = true;
				$("#type_error").text('请选择活动类型！');
			}else{
				if(!(promotion_id == 0 || promotion_id == '' || promotion_id == null)){
					$.ajax({
						'url':'promotion_display_area.php',
						'type':'get',
						'data':{'action':'check_promotion_area' , 'promotion_type' : promotion_type , 'promotion_id' : promotion_id},
						'async':false,
						'success':function(data){
							var returnInfo = process_json(data);
							
							if(returnInfo.is_error == true){
								$("#id_error").text(returnInfo.error_info);
								error = true;
							}
						}
					}); 
				}else{
					error = true;
					if(promotion_type == 10 || promotion_type == 20){
						$("#id_error").text('请填写促销区ID ！');
					}else{
						$("#id_error").text('填写一口价Deals区ID ！');
					}
				}
			}

			if(en_pic_url == '' || en_pic_url == null){
				error = true;
				$("#language_error_en").text('请填写英语站点的图片地址！');
			}
			if(de_pic_url == '' || de_pic_url == null){
				error = true;
				$("#language_error_de").text('请填写德语站点的图片地址！');
			}
			if(ru_pic_url == '' || ru_pic_url == null){
				error = true;
				$("#language_error_ru").text('请填写俄语站点的图片地址！');
			}
			if(fr_pic_url == '' || fr_pic_url == null){
				error = true;
				$("#language_error_fr").text('请填写法语站点的图片地址！');
			}

			if(!error){
				formObj.submit();
			}
			
			return !error;
		});
	});

	function close_confirm(){
		var confirm_result = false;

		if(confirm('禁用后该促销版本会在前台页面隐藏')){
			confirm_result = true;
		}

		return confirm_result;
	}
</script>
<style>
.inbok{
	display:inline-block;
}
 .language_title{
	display: inline-block;
    border: 1px solid #D0CCCC;
    width: 68px;
    text-align: center;
    vertical-align: middle;
    line-height: 25px;
    cursor: pointer;
    position: relative;
    background: white;
    top: 1px;
 }
 .checked{
 	border-bottom-color: white;
 	font-weight:bold;
 	background-color: blanchedalmond;
 }
 #title{
    padding: 25px 20px;
    font-size: 25px;
    font-weight: bold;
    color: #599659;
 }
 #form_body{
    margin-left: 60px;
    font-size: 13px;
    font-weight: bold;
 }
 #deals_span{
 	display: inline-block;
    width: 100px;
    line-height: 20px;
    position: relative;
    top: 10px;
 }
 .form_tr {
    line-height: 30px;
 }
 .info_column_title{
 	padding-right:5px; 
 	width:100px;
 }
 
 .info_column_content{
 	padding-left:5px; 
 }
 .info_red{
 	color:red;
 }
 .simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;
    margin: 10px;
    }
</style>
</head>
<body onload="init()">
<?php require(DIR_WS_INCLUDES.'header.php');?>

<?php 
	if(!($action == 'new' || $action == 'edit')){
		$display_area_data = array();
		
		/* if(isset($_GET['promotion_type']) && $_GET['promotion_type'] != 0){
			$filter_str = ' WHERE promotion_type = "' . (int)$_GET['promotion_type'] . '"';
			
			if(isset($_GET['search']) && $_GET['search'] != '活动名称' && $_GET['search'] != ''){
				if(in_array($_GET['promotion_type'], array(10 , 20))){
					$filter_str .= ' AND promotion_area_name like "%' . $_GET['search'] . '%"';
					
					$display_area_sql = 'SELECT zpda.display_area_id , zpda.promotion_id , zpda.display_status, zpda.promotion_type , zpda.create_admin , zpda.create_datetime , zpda.modify_admin , zpda.modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' zpda INNER JOIN ' . TABLE_PROMOTION_AREA . ' zpa on zpda.promotion_id = zpa.promotion_area_id ' . $filter_str . ' ORDER BY display_area_id DESC';
				}else{
					$filter_str .= ' AND area_name like "%' . $_GET['search'] . '%"';
					
					$display_area_sql = 'SELECT zpda.display_area_id , zpda.promotion_id , zpda.display_status, zpda.promotion_type , zpda.create_admin , zpda.create_datetime , zpda.modify_admin , zpda.modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' zpda INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zpda.promotion_id = zda.dailydeal_area_id ' . $filter_str . ' ORDER BY display_area_id DESC';
				}
			}else{
				$display_area_sql = 'SELECT display_area_id , promotion_id , display_status, promotion_type , create_admin ,create_datetime , modify_admin , modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA . $filter_str . ' ORDER BY display_area_id DESC';
			}
		}else{
			$display_area_sql = 'SELECT display_area_id , promotion_id , display_status, promotion_type , create_admin ,create_datetime , modify_admin , modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' ORDER BY display_area_id DESC';
		} */
		$type=zen_db_input($_GET['promotion_type']);
		$status=zen_db_input($_GET['promotion_statu']);
		$sort=zen_db_input($_GET['sort']);
		$search_key = zen_db_input($_GET['search']);
		
		function promotion_search($status="",$type="",$search_key="",$sort=""){
		    $search_condition ='';
		    $display_area_sql ='';
		    $filter_str='';
		    $order='';
		    if($search_key =='' || $search_key =='活动名称'){
		        if($type != '' && in_array($type,array(10,20,30))){
		            $search_condition .= ' WHERE promotion_type= '.$type;
		            if($status!='' && in_array($status,array(10,20,30))){
		                $search_condition .=' AND promotion_status= '.$status.' AND display_status <> 20';
		            }elseif($status!='' && $status==40){
		                $search_condition .=' AND display_status= 20';
		            }
		        }
		        if($status!='' && in_array($status,array(10,20,30)) && !in_array($type,array(10,20,30))){
		            $search_condition .=' WHERE promotion_status= '.$status.' AND display_status <> 20';
		        }elseif($status!='' && $status==40 && !in_array($type,array(10,20,30))){
		            $search_condition .=' WHERE display_status= 20';
		        }
		        if($sort=='2'){
		            $search_condition .=' ORDER BY display_level DESC';
		        }else{
		            $search_condition .=' ORDER BY display_area_id DESC';
		        }
		        $display_area_sql = 'SELECT display_area_id , display_status, display_level, promotion_id , promotion_type , create_admin ,create_datetime , modify_admin , modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA .$search_condition;
		    }elseif(isset($search_key) && $search_key !='' && $search_key !='活动名称'){
		
		        if($sort=='2'){
		            $order=' ORDER BY display_level DESC';
		        }else{
		            $order=' ORDER BY display_area_id DESC';
		        }
		        if($type != '' && in_array($type,array(10,20))){
		
		            if($status!='' && in_array($status,array(10,20,30))){
		                $search_condition .=' zpda.promotion_type= '.$type.' and zpda.promotion_status='.$status.' and zpda.display_status <>20 AND';
		            }elseif($status==40){
		                $search_condition .=' zpda.promotion_type= '.$type.' and zpda.display_status =20 AND';
		            }
		
		            $filter_str.= ' zpa.promotion_area_name like "%' .$search_key. '%"';
		            $display_area_sql = 'SELECT zpda.display_area_id , zpda.display_level, zpda.display_status, zpda.promotion_id , zpda.promotion_type , zpda.create_admin , zpda.create_datetime , zpda.modify_admin , zpda.modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' zpda INNER JOIN ' . TABLE_PROMOTION_AREA . ' zpa on zpda.promotion_id = zpa.promotion_area_id WHERE'.$search_condition.$filter_str.$order;
		        }elseif($type==30){
		
		            if($status!='' && in_array($status,array(10,20,30))){
		                $search_condition .=' zpda.promotion_type= '.$type.' and zpda.promotion_status='.$status.' and zpda.display_status <>20 AND';
		            }elseif($status==40){
		                $search_condition .=' zpda.promotion_type= '.$type.' and zpda.display_status =20 AND';
		            }
		
		            $filter_str.= ' zda.area_name like "%' .$search_key. '%"';
		            $display_area_sql = 'SELECT zpda.display_area_id , zpda.display_level, zpda.display_status, zpda.promotion_id , zpda.promotion_type , zpda.create_admin , zpda.create_datetime , zpda.modify_admin , zpda.modify_datetime FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' zpda INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zpda.promotion_id = zda.dailydeal_area_id WHERE'.$search_condition.$filter_str.$order;
		        }else{
		            if(in_array($status,array(10,20,30))){
		                $filter_str .='promotion_status= '.$status.' AND display_status <> 20 AND';
		            }elseif($status==40){
		                $filter_str .='display_status = 20 AND';
		            }
		
		            $display_area_sql .='SELECT display_area_id,display_level,display_status,promotion_id,promotion_type,create_admin,create_datetime, modify_admin,modify_datetime FROM ';
		            $display_area_sql .='((SELECT zpda.display_area_id , zpda.display_level, zpda.promotion_status, zpda.display_status, zpa.promotion_area_name AS promotion_name, zpda.promotion_id , zpda.promotion_type , zpda.create_admin , zpda.create_datetime , zpda.modify_admin , zpda.modify_datetime FROM '.TABLE_PROMOTION_DISPLAY_AREA.' AS zpda INNER JOIN ' . TABLE_PROMOTION_AREA . ' AS zpa on zpda.promotion_id = zpa.promotion_area_id WHERE zpda.promotion_type in(10,20))';
		            $display_area_sql .=' UNION ALL';
		            $display_area_sql .=' (SELECT zpda.display_area_id , zpda.display_level, zpda.promotion_status, zpda.display_status, zda.area_name AS promotion_name, zpda.promotion_id ,  zpda.promotion_type , zpda.create_admin , zpda.create_datetime , zpda.modify_admin , zpda.modify_datetime FROM  ' . TABLE_PROMOTION_DISPLAY_AREA . ' AS zpda INNER JOIN  ' . TABLE_DAILYDEAL_AREA . ' AS zda on zpda.promotion_id = zda.dailydeal_area_id WHERE zpda.promotion_type=30)) as temp_all ';
		            $display_area_sql .=' WHERE '.$filter_str.' promotion_name like "%'.$search_key.'%"'.$order;
		        }
		    }
		
		    return $display_area_sql;
		}
		$display_area_sql = promotion_search($status,$type,$search_key,$sort);
		$display_area_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS , $display_area_sql ,$display_area_query_numrows);
		$display_area = $db->Execute($display_area_sql);
		
		if($display_area->RecordCount() > 0){
			while(!$display_area->EOF){
				$display_area_id = (int)$display_area->fields['display_area_id'];
				
				switch ($display_area->fields['promotion_type']){
					case 10: $promotion_type_name = '正常促销';break;
					case 20: $promotion_type_name = 'Deals活动';break;
					case 30: $promotion_type_name = '一口价Deals';break;
				}
				$display_area_data[$display_area_id] = array(
						'display_area_id' => $display_area_id,
						'display_status'  => $display_area->fields['display_status'],
						'promotion_id' => $display_area->fields['promotion_id'],
						'promotion_type' => $display_area->fields['promotion_type'],
						'promotion_type_name' => $promotion_type_name,
						'promotion_name' => '/',
				        'display_level'=>$display_area->fields['display_level'],
						'display_area_status' => 20,//10活动 20未开始 30已结束
						'create_admin' => $display_area->fields['create_admin'],
						'create_datetime' => $display_area->fields['create_datetime'],
						'modify_admin' => $display_area->fields['modify_admin'],
						'modify_datetime' => $display_area->fields['modify_datetime'],
				        'promotion_display_status'=>1//1开启 0禁用
				);
				$promotion_status = 20;
				if(in_array($display_area->fields['promotion_type'], array(10 , 20))){
					$promotion_name_query = $db->Execute('select related_promotion_ids , promotion_area_name , promotion_area_status from ' . TABLE_PROMOTION_AREA . ' where promotion_area_id = ' . $display_area->fields['promotion_id'] . ' limit 1');
					$display_area_data[$display_area_id]['promotion_display_status']=$promotion_name_query->fields['promotion_area_status'];
					
					if($promotion_name_query->RecordCount() > 0){
						$promotion_name = $promotion_name_query->fields['promotion_area_name'];
						
						if($promotion_name_query->fields['promotion_area_status'] == 0){
							$promotion_status = 30;
						}else{
							$discount_area_query = $db->Execute('SELECT promotion_id , promotion_start_time , promotion_end_time  FROM ' . TABLE_PROMOTION . ' WHERE promotion_id in (' . $promotion_name_query->fields['related_promotion_ids'] . ') and promotion_end_time > now() and promotion_status = 1');
							
							if($discount_area_query->RecordCount() > 0){
								while(!$discount_area_query->EOF){
									if(strtotime($discount_area_query->fields['promotion_start_time']) < time()){
										$promotion_status = 10;
										break;
									}
									
									$discount_area_query->MoveNext();
								}
							}else{
								$promotion_status = 30;
							}
						}
					}else{
						$promotion_status = 30;
					}
				}else{
				    $deals_name_query = $db->Execute('SELECT area_name,area_status FROM ' . TABLE_DAILYDEAL_AREA . ' WHERE dailydeal_area_id = ' . $display_area->fields['promotion_id']);
				    $promotion_name=$deals_name_query->fields['area_name'];
				    $display_area_data[$display_area_id]['promotion_display_status']=$deals_name_query->fields['area_status'];
				    
					$deals_status_query = $db->Execute('SELECT area_name , start_date , end_date FROM ' . TABLE_DAILYDEAL_AREA . ' WHERE dailydeal_area_id = ' . $display_area->fields['promotion_id'] . ' and area_status = 1 and end_date > NOW() ');				
					if($deals_status_query->RecordCount() > 0){
												
						if(strtotime($deals_status_query->fields['start_date']) < time()){
							$promotion_status = 10;
						}else{
							$promotion_status = 20;
						}
					}else{
						$promotion_status = 30;
					}
					
				}
				
				$display_area_data[$display_area_id]['promotion_name'] = $promotion_name;
				$display_area_data[$display_area_id]['display_area_status'] = $promotion_status;
				$promotion_statu=$db->Execute('update ' . TABLE_PROMOTION_DISPLAY_AREA . ' set promotion_status = '.$display_area_data[$display_area_id]['display_area_status'].' where display_area_id = ' . $display_area_data[$display_area_id]['display_area_id']);			
				$display_area->MoveNext();
			}
		}
		?>
		<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr height="80px">
		<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
		<td class="pageHeading" width="70%" style="padding-left: 20px;">促销活动展示专区</td>
		<td style="float: right;">
		<?php echo zen_draw_form('search_form', 'promotion_display_area','','get');?>
			<table border="0" width="95%" cellspacing="0" cellpadding="2" align="center">
				<tr>
					<td align="right" width="300px;">
						<strong style="font-size: 13px;line-height: 25px;display: inline;">活动类型 : </strong><?php echo zen_draw_pull_down_menu('promotion_type' , $promotion_type_array , $_GET['promotion_type'] ? $_GET['promotion_type'] : '' , 'style="height: 20px;"')?><br>
						<strong style="font-size: 13px;line-height: 25px;display: inline;">状态 : </strong><?php echo zen_draw_pull_down_menu('promotion_statu' , $promotion_status_array, $_GET['promotion_statu'] ? $_GET['promotion_statu'] : '' , 'style="height: 20px;"')?><br>
						<strong style="font-size: 13px;line-height: 25px;display: inline;">排序 : </strong><?php echo zen_draw_pull_down_menu('sort' , $sort_array, $_GET['sort'] ? $_GET['sort'] : '' , 'style="height: 20px;"')?><br>
					</td>
				</tr>
				<tr>
					<td align="right" width="300px;">
					<?php 
						echo zen_draw_input_field('search', $_GET['search'], 'size="21px" style="color:#999;height: 25px;" value="活动名称" onfocus="if (this.value == \'活动名称\'){this.value=\'\';this.style.color=\'#000\';}"');
					?>
					</td>
				</tr>
				<tr>
					<td align="right">
						 <?php echo zen_image_submit('button_search_cn.png','搜索');?>
					</td>
				</tr>
			</table>
			<?php echo '</form>';?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td>
								<table border="0" width="100%" cellspacing="0" cellpadding="2">
									<tr class="dataTableHeadingRow">
										<td class="dataTableHeadingContent">ID</td>
										<td class="dataTableHeadingContent">促销区/一口价Deals区ID</td>
										<td class="dataTableHeadingContent">展示优先级</td>
										<td class="dataTableHeadingContent">活动名称-en</td>
										<td class="dataTableHeadingContent">活动类型</td>
										<td class="dataTableHeadingContent">是否展示</td>
										<td class="dataTableHeadingContent">操作</td>
									</tr>
									<?php 
								if (!isset($_GET['id']) ){
									$first_info = reset($display_area_data);
									$id = $first_info['display_area_id'];
								}else{
									$id = $_GET['id'];
								}
								
								foreach ($display_area_data as $shown_area){
									if ($id == $shown_area['display_area_id']){
										$mInfo = new objectInfo($shown_area);
									}
							?>
					
								<td class="dataTableHeadingContent"><?php echo ($shown_area['display_area_id'] != '' ? $shown_area['display_area_id'] : '/');?></td>
								<td class="dataTableHeadingContent"><?php echo ($shown_area['promotion_id'] != '' ? $shown_area['promotion_id'] : '/');?></td>
								<td class="dataTableHeadingContent"><?php echo $shown_area['display_level'];?></td>
								<td class="dataTableHeadingContent"><?php echo ($shown_area['promotion_name'] != '' ? $shown_area['promotion_name'] : '/');?></td>
								<td class="dataTableHeadingContent"><?php echo ($shown_area['promotion_type_name'] != '' ? $shown_area['promotion_type_name'] : '/');?></td>
								<td class="dataTableHeadingContent"><?php if($shown_area['promotion_display_status']==0){echo '<img src="images/icon_red_on.gif">';}elseif($shown_area['display_status'] == 20){echo '<img src="images/icon_red_on.gif">';}else{ echo '<img src="images/icon_green_on.gif">'; }?></td>
								<td class="dataTableHeadingContent">
								<?php if($shown_area['display_area_status'] != 30 && $shown_area['display_status'] == 10){?>
									<a href="<?php echo zen_href_link('promotion_display_area', zen_get_all_get_params(array('action', 'id')) . 'action=edit&id=' . $shown_area['display_area_id']);?>"><?php echo zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT);?></a>
								<?php }else{
									echo '<span style="width: 16px;display: inline-block;"></span>';
								}?>
								<?php
									if (isset($mInfo) && is_object($mInfo) && ($shown_area['display_area_id'] == $mInfo->display_area_id)) {
										echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
									} else {
										echo '<a href="' . zen_href_link('promotion_display_area', zen_get_all_get_params(array('action','id')) . 'id=' . $shown_area['display_area_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
									}
								?>
								 </td>
							</tr>
	  <?php }?>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" width="100%" cellspacing="0" cellpadding="2px">
						<tr>
							<td class="smallText" valign="top" colspan="5"><?php echo $display_area_split->display_count($display_area_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TRENDS,zen_get_all_get_params(array('page','id','action'))); ?></td>
							<td class="smallText" align="right" colspan="6"><?php echo $display_area_split->display_links($display_area_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page','id','action')) ); ?></td>
						</tr>
					</table>
				</td>
			</tr>
			
        
              
            <tr><td align="right"><a href="<?php echo zen_href_link('promotion_display_area', zen_get_all_get_params(array('action', 'id','search','page' , 'promotion_type')) . 'action=new', 'NONSSL');?>"><?php echo zen_image_button('button_insert_cn.png');?></a></td></tr>
		</table>
		
		</td>
		
	<?php 
	$promotion_status=$mInfo->display_area_status;
	if($mInfo->display_status==20){$promotion_status=40;}
	switch($promotion_status){
	    case 10:$promotion_status='活动';break;
	    case 20:$promotion_status='未开始'; break;
	    case 30:$promotion_status='已结束'; break;
	    case 40:$promotion_status='已禁用'; break;
	}	
	
	    $heading = array();
		$contents = array();
		switch ($action){
			default:
				$heading[] = array('text' => '<b>ID: '.$mInfo->display_area_id.'</b>');
				
				$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
				$str_table .= '<tr><td>促销区/一口价Deals区ID: </td><td>' . ($mInfo->promotion_id ? $mInfo->promotion_id : '/' )  . '</td></tr>';
				$str_table .= '<tr><td>活动名称-en: </td><td>' . ($mInfo->promotion_name != '' ? $mInfo->promotion_name : '/' ) . '</td></tr>';
				$str_table .= '<tr><td>活动类型: </td><td>' . ($mInfo->promotion_type_name != '' ? $mInfo->promotion_type_name : '/' )  . '</td></tr>';
				$str_table .= '<tr><td>状态:</td><td>' . $promotion_status . '</td></tr>';
				$str_table .= '<tr><td>创建人:</td><td>' . ($mInfo->create_admin != '' ? $mInfo->create_admin : '/' ) . '</td></tr>';
				$str_table .= '<tr><td>创建时间:</td><td>' . ($mInfo->create_datetime != '' ? $mInfo->create_datetime: '/' ) . '</td></tr>';
				$str_table .= '<tr><td>修改人:</td><td>' . ($mInfo->modify_admin != '' ? $mInfo->modify_admin : '/' ) . '</td></tr>';
				$str_table .= '<tr><td>修改时间:</td><td>' . ($mInfo->modify_datetime != '' ? $mInfo->modify_datetime : '/' ) . '</td></tr>';
				$str_table .= '</table>';
				$contents[] = array('text' => $str_table);
				if($mInfo->display_area_status != 30  && $mInfo->display_status == 10){
					$contents[] = array('align' => 'center', 'text' =>  '<a href="' . zen_href_link('promotion_display_area', zen_get_all_get_params(array('action','id')).'action=close_display&id='.$mInfo->display_area_id) . '"onclick="return close_confirm()"><input type="button" class="simple_button" value="禁用" ></a>'.'<a href="' . zen_href_link('promotion_display_area', zen_get_all_get_params(array('action','id')).'action=edit&id='.$mInfo->display_area_id) . '"><input type="button" class="simple_button" value="编辑" ></a> ');
				}
				break;
		}
		if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
			echo '<td width="25%" valign="top">';
			$box = new box;
			echo $box->infoBox($heading, $contents);
			echo '</td>';
		}
	?>
				</tr>
			</table>
		</td>
	</tr>

</table>
<?php 
	}else{
		if($action == 'edit' && (!isset($_GET['id']) || $_GET['id'] == 0)){
			zen_redirect(zen_href_link('promotion_display_area'));
		}
		$promotion_display_area_info_array = array();
		if($action == 'edit'){
			$display_area_info_query = $db->Execute('SELECT display_area_id , promotion_id , promotion_type,display_level FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' where display_area_id = "' . (int)$_GET['id'] . '"');
		
			if($display_area_info_query->RecordCount() > 0){
				$promotion_display_area_info_array['display_area_id'] = $display_area_info_query->fields['display_area_id'];
				$promotion_display_area_info_array['promotion_id'] = $display_area_info_query->fields['promotion_id'];
				$promotion_display_area_info_array['display_level'] = $display_area_info_query->fields['display_level'];
				$promotion_display_area_info_array['promotion_type'] = $display_area_info_query->fields['promotion_type'];
				
				$area_description_array = array();
				$area_dexcription_query = $db->Execute('SELECT display_area_id , languages_id , display_picture_url , display_area_description FROM ' . TABLE_PROMOTION_DISPLAY_AREA_DESCRIPTION . ' WHERE display_area_id = "' . (int)$_GET['id'] . '" order by languages_id asc');
				
				while (!$area_dexcription_query->EOF){
					$promotion_display_area_info_array['description']['picture_url'][$area_dexcription_query->fields['languages_id']] = $area_dexcription_query->fields['display_picture_url'];
					$promotion_display_area_info_array['description']['area_description'][$area_dexcription_query->fields['languages_id']] = $area_dexcription_query->fields['display_area_description'];
					
					$area_dexcription_query->MoveNext();
				}
				
				$type_edit_status = '';
				$id_edit_status = '';
				$url_edit_status = '';
				$desc_edit_status = '';
				
				if(in_array($display_area_info_query->fields['promotion_type'], array(10 , 20))){
						$promotion_name_query = $db->Execute('select related_promotion_ids , promotion_area_name , promotion_area_status from ' . TABLE_PROMOTION_AREA . ' where promotion_area_id = ' . $display_area_info_query->fields['promotion_id'] . ' AND promotion_area_type = "' . intval($display_area_info_query->fields['promotion_type'])/10 . '" limit 1');
						if($promotion_name_query->RecordCount() > 0){
							if($promotion_name_query->fields['promotion_area_status'] == 0){
								zen_redirect(zen_href_link('promotion_display_area'));
							}else{
								$discount_area_query = $db->Execute('SELECT promotion_id , promotion_start_time , promotion_end_time  FROM ' . TABLE_PROMOTION . ' WHERE promotion_id in (' . $promotion_name_query->fields['related_promotion_ids'] . ') and promotion_end_time > now() and promotion_status = 1');
								
								if($discount_area_query->RecordCount() > 0){
									while(!$discount_area_query->EOF){
										if(strtotime($discount_area_query->fields['promotion_start_time']) < time()){
											$type_edit_status = ' onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;"';
											$id_edit_status = 'readonly="readonly"';
											$url_edit_status = 'readonly="readonly"';
											$desc_edit_status = '';
											break;
										}
										
										$discount_area_query->MoveNext();
									}
								}else{
									zen_redirect(zen_href_link('promotion_display_area'));
								}
							}
						}else{
							zen_redirect(zen_href_link('promotion_display_area'));
						}
					}else{
						$deals_name_query = $db->Execute('SELECT area_name , start_date , end_date FROM ' . TABLE_DAILYDEAL_AREA . ' WHERE dailydeal_area_id = ' . $display_area_info_query->fields['promotion_id'] . ' and area_status = 1 and end_date > NOW() ');
						
						if($deals_name_query->RecordCount() > 0){
							$promotion_name = $deals_name_query->fields['area_name'];
							
							if(strtotime($deals_name_query->fields['start_date']) < time()){
								$type_edit_status = ' onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;"';
								$id_edit_status = 'readonly="readonly"';
								$url_edit_status = 'readonly="readonly"';
								$desc_edit_status = '';
							}else{
								$type_edit_status = '';
								$id_edit_status = '';
								$url_edit_status = '';
								$desc_edit_status = '';
							}
						}else{
							zen_redirect(zen_href_link('promotion_display_area'));
						}
					}
			}else{
				zen_redirect(zen_href_link('promotion_display_area'));
			}
		}
		
		?>
		<div id="edit_body">
			<div id="title"><?php echo $action == 'edit' ?  '编辑专区版块' : '新建专区版块'?></div>
			<?php echo zen_draw_form('create_form', 'promotion_display_area' , '' , 'get')?>
			<?php
			if($action == 'new'){
				echo zen_draw_hidden_field('action' , 'create');
			}else{
				echo zen_draw_hidden_field('action' , 'update');
				echo zen_draw_hidden_field('display_area_id' , $_GET['id']);
				echo zen_draw_hidden_field('pre_link' , zen_href_link('promotion_display_area' , zen_get_all_get_params(array('action'))));
			}
			
			?>
			<div id="form_body">
				<div class="form_tr"><span class="title2" ><span class="info_red">*</span>活动类型：</span><div class="inbok" style="margin-left: 70px;"><?php echo zen_draw_pull_down_menu('promotion_type' , $promotion_type_array , $promotion_display_area_info_array['promotion_type'] ? $promotion_display_area_info_array['promotion_type'] : '' , $type_edit_status);?></div><span id="type_error" class="info_red"></span></div>
				<div class="form_tr" ><span class="title2" id="deals_span"><span class="info_red">*</span>促销区/一口价Deals区ID：</span><div class="inbok" style="margin-bottom: 20px;margin-left: 45px;"><?php echo zen_draw_input_field('promotion_id' , $promotion_display_area_info_array['promotion_id'] ?$promotion_display_area_info_array['promotion_id'] : '' , 'style="width: 93px;" ' . $id_edit_status)?></div><span id="id_error" class="info_red"></span></div>
				<div class="form_tr"><span class="title2" >展示优先级：</span><div class="inbok" style="margin-left: 70px;"><input type="text" name="display_level" style="width: 93px; margin-bottom: 20px;" onkeyup="value=scale(value)?value:''" value="<?php echo $promotion_display_area_info_array['display_level'];?>"/></div><span id="type_error" class="info_red"></span></div>
				<div style="height: 130px;"><span class="title2" style="height: 170px;display: inline-block;vertical-align: middle;"><span class="info_red">*</span>图片地址：</span><div class="inbok" style="margin-left: 70px;">
				<?php   
					for ($i = 0, $n = $language_count; $i < $n; $i++) { 
						$lang_id = $languages[$i]['id'];
				?> 
						<div style="height: 25px;"> 
							<div style="width:70px;display: inline-block;" align="left"><?php echo $languages[$i]['directory']?> :</div>
							<div style="display: inline-block;"><input type="text" <?php echo $url_edit_status;?> id="pName<?php echo $lang_id?>" class="pName" data-lang-name="<?php echo $languages[$i]['name']?>" name="pName<?php echo $lang_id?>" maxlength="200" style="width:400px;" value="<?php echo $promotion_display_area_info_array['description']['picture_url'] && array_key_exists($lang_id, $promotion_display_area_info_array['description']['picture_url'])?$promotion_display_area_info_array['description']['picture_url'][$lang_id] : '' ?>" /></div> 
							<span id="language_error_<?php echo $languages[$i]['code']?>" class="info_red"></span>
						</div>
				<?php }?> 
				</div></div>
				<div><span class="title2" style="DISPLAY: inline-block;VERTICAL-ALIGN: top;">活动简介：</span><div class="inbok" style="margin-left: 70px;">
				<div class="index_language"> 
				<?php 
				for ($i = 0, $n = $language_count; $i < $n; $i++) {
					if($i == 0){
						echo '<div class="language_title checked" language="' . $languages[$i]['code'] . '" >' . $languages[$i]['directory'] . '</div>';
					}else{
						echo '<div class="language_title" language="' . $languages[$i]['code'] . '" >' . $languages[$i]['directory'] . '</div>';
					}
				}
				?>
				<?php 
				for ($i = 0, $n = $language_count; $i < $n; $i++) { 
					$lang_id = $languages[$i]['id'];
					
					if($i == 0){
						echo '<div style="display: block;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">' ;
					}else{
						echo '<div style="display: none;" id="' . $languages[$i]['code'] . '_textarea" class="index_area">';
					}
				?>
					<textarea rows="9" <?php echo $desc_edit_status;?> style="width:140%;" data-lang-name="<?php echo $languages[$i]['name']?>"  class="pDesc" id = "pDesc<?php echo $lang_id?>" name = "pDesc<?php echo $lang_id?>" data-id="<?php echo $lang_id;?>"><?php echo $promotion_display_area_info_array['description']['area_description'][$lang_id];?></textarea></div> 
				
				<?php }?> 
				</div>
				</div></div>
			</div>
			<div style="height: 40px;padding-top: 20px;margin-left: 100px;">
				<input type="button" class="simple_button" name="btnSubmit" id="btnSubmit" value="保存" /> &nbsp;
				<input type="button" class="simple_button" name="btnCancel" id="btnCancel" value="取消">
			</div>
			<?php echo '</form>';?>
		</div>
		
		<?php 
		
	}
	
?>


<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>