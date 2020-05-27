<?php
  require('includes/application_top.php');
  error_reporting(0);
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $cid = zen_db_prepare_input($_REQUEST['ID']);
  $selectId = $_GET['selectId'];
  
  if(zen_not_null($action)){
  	switch ($action) {
  		case 'delete':		 			  			
  			$db->Execute("delete from " . TABLE_CATEGORIES_RELATION . " where id = '" . (int)$cid . "'");
  			$messageStack->add_session('信息删除成功','success');
  			zen_redirect(zen_href_link(products_category_setting, 'page=' . $_GET['page']));
  			break;  		
  		case 'update':
                    
  			$categories_id = $_POST['categories_id'];
                        $recom_categories_ids = $_POST['recom_categories_id'];
                        $status = $_POST['status'];
                        
                        $data_array = array('common_categories_id' => $categories_id,
                                        'recommend_categories_id' => implode(',',$recom_categories_ids),
                                        'status' => $status,
                                        'modifier' => $_SESSION['admin_name'],
                                        'last_modify_at' => time(),
                        );
                        //var_dump($data_array);exit;
                        zen_db_perform(TABLE_CATEGORIES_RELATION, $data_array,'update','id='.$cid );

                        $messageStack->add_session('数据修改成功','success');
                        zen_redirect(zen_href_link('products_category_setting','page='.$_GET['page']));
  			break;
  		case 'create':
  			$categories_id = $_POST['categories_id'];
                        $recom_categories_ids = $_POST['recom_categories_id'];
                        $status = $_POST['status'];
                        
                        $sql_category  = "select common_categories_id from ". TABLE_CATEGORIES_RELATION. " where common_categories_id= '". $categories_id ."' limit 1";
 			$select=$db->Execute($sql_category);
//                        if(!$select->RecordCount()){ 
//                             $message_text = "常规类型数据错误!\n";
//                             zen_redirect(zen_href_link('products_category_setting'));
//                        }
                        if($select->RecordCount()==0){
	  			$data_array = array('common_categories_id' => $categories_id,
	  					'recommend_categories_id' => implode(',',$recom_categories_ids),
	  					'status' => $status,
	  					'founder' => $_SESSION['admin_name'],
	  					'create_at' => time(),
	  			);
	  			zen_db_perform(TABLE_CATEGORIES_RELATION, $data_array, 'insert');
	  			$insertId=$db->insert_ID();
                                
	  			$messageStack->add_session('数据提交成功','success');
  			} else {
  				$messageStack->add_session('此分类已经存在','error');
  			}
	  		zen_redirect(zen_href_link('products_category_setting'));
                        break;
                case 'ajaxcheck':
                        $category_id = $_GET['category_id'];
                        $whereStr = " categories_id = ".$category_id." and categories_code <> ''";
                        if(isset($_GET['flag']) && $_GET['flag'] == 'recommend'){
                            $whereStr = " categories_id = ".$category_id." and categories_code = ''";
                        }
                        
                        $result = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where {$whereStr}  limit 1");
                        if(!$result->RecordCount()){
                            exit('0');
                        }else{
                            if(isset($_GET['flag']) && $_GET['flag'] != 'recommend'){
                                $result_relation = $db->Execute("select 1 from ".TABLE_CATEGORIES_RELATION." where common_categories_id={$category_id}  limit 1");
                                if($result_relation->RecordCount()){
                                    exit('1');
                                }
                            }
                            exit('');
                        }
                        break;

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
  function checkSubmit(ddo='add'){
            var  category_id = $.trim($('input[name=categories_id]').val());
            var error = false;

            if(category_id == ''){ 
                if( !$('input[name=categories_id]').parent().find('.warn').length){
                    $('input[name=categories_id]').parent().append("<label class='warn'>请输入常规类别ID</label>");
                }
                error = true;
            }
            
            $('form[name=relation_add] > div[class=item]').each(function(){
                var thisid = $.trim($(this).find('input').val());
                var thisobj = $(this);
                if(thisid == ''){
                     var error_text = '请输入推荐类别ID';
                    if(!thisobj.find('.warn').length){
                        thisobj.append("<label class='warn'>"+error_text+"</label>"); 
                    }else{
                         thisobj.find('.warn').text(error_text);
                    }
                    error = true;
                }else{
                    //alert(isNaN(thisid));return false;
                    if(isNaN(thisid)){
                        var error_text = '请输入数字';
                        if(thisobj.find('.warn').length){
                            thisobj.find('.warn').text(error_text);
                        }else{
                            thisobj.append("<label class='warn'>"+error_text+"</label>");
                        }
                        error = true;
                    }
                }
            });
           //alert($('div').eq(0).data('islock'));return false;
           if(error || $('div').eq(0).data('islock')){
               return false;
           }else{
               $('div').eq(0).removeData('islock');
               return true;
           }
           
    }

 
function caterow_add(obj){
    var image_minus = 'images/minus.png';
    var p_obj =  $(obj).parent();
    if($('input[name=status]:checked').val() == 1){
        p_obj.after('<div class="item"><input name="recom_categories_id[]" type="text" onblur="check_categoryId(this,\'recommend\')"><img class="img " src="images/plus.png" onclick="caterow_add(this)"></div>');
        $(obj).attr('src',image_minus);
        $(obj).attr("onclick","caterow_del(this)");
    }
}

function caterow_del(obj){
	if($('input[name=status]:checked').val() == 1){
        if($(obj).parent().data('iserror')){
            var islock = $('div').eq(0).data('islock');
            $('div').eq(0).data('islock',islock-1);
        }
        $(obj).parent().remove();
	}
}

function check_categoryId(obj,flag='common',ddo='add'){
    var thisid = $.trim($(obj).val());
    var thisobj = $(obj).parent();
    var url = "<?php echo zen_href_link('products_category_setting','action=ajaxcheck' , 'NONSSL');?>";
    var islock = $('div').eq(0).data('islock');
    var temp  = new Array();
    if( islock == undefined){
         islock = 0;
    }
    //alert(islock+'//'+(islock == undefined));
    $.get(url,{flag:flag,category_id:thisid},function(data){ 
        if(data == '0'){
            if(flag == 'recommend'){
                error_text = '只能是推荐类别ID';
            }else{
                error_text = '只能是常规类别ID';
            }
            if(thisobj.find('.warn').length){
                thisobj.find('.warn').text(error_text);
            }else{
                thisobj.append("<label class='warn'>"+error_text+"</label>");
            }
            if(thisobj.data('iserror') == undefined){
                $('div').eq(0).data('islock',islock+1);
            }
            thisobj.data('iserror',1);
        }else if(data == '1'){
            error_text = '已存在该类别ID记录，请勿重复创建';
            if(thisobj.find('.warn').length){
                thisobj.find('.warn').text(error_text);
            }else{
                thisobj.append("<label class='warn'>"+error_text+"</label>");
            }
            if(thisobj.data('iserror') == undefined){
                $('div').eq(0).data('islock',islock+1);
            }
            thisobj.data('iserror',1);
        }else{
            if(thisobj.data('iserror')){
                thisobj.find('.warn').remove();
                $('div').eq(0).data('islock',islock-1);
            }
        }
    },'text');
}

function onRedioSelected(obj){
    if(obj.value == '0'){
        $('form[name=relation_add]  input[type=text]').each(function(){
            $(this).attr('disabled',true);
        });
    }else{
        $('form[name=relation_add]  input[type=text]').each(function(){
            $(this).attr('disabled',false);
        });
    }
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
.item img{cursor:pointer;display:inline-block;margin:0 0 0 5px;width:20px;height:20px;vertical-align:middle;}
.item,.item2 {margin:6px 0 0 15px;}
.item input{display:inline-block;height:22px;width:160px;}
.item2 input{display:inline-block;height:22px;width:160px;}
.dataTableRow{cursor:pointer;}
.warn{color:red;width:260px;margin-left:1.5em;}
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
								<td class="pageHeading">类别对应关系设置</td>
								<td>
					            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
				         				<tbody><form method="get" action='<?php echo zen_href_link('products_category_setting',zen_get_all_get_params(array('action')).'action=search', 'NONSSL')?>' name="search">         
				         					
				         				<tr>
				         					<td align="right" class="pageHeading"><img width="1" height="30" border="0" alt="" src="images/pixel_trans.gif"></td>
                                                                                <td align="right" class="smallText" colspan="2">状态:  <select name="status"><option value="2" <?php if(!isset($_GET['status']) || $_GET['status'] == '2')echo 'selected';?>>所有状态</option><option value="1" <?php if($_GET['status']==1)echo 'selected';?>>启用</option><option value="0" <?php if(
                                                                                        $_GET['status']=='0')echo 'selected';?>>禁用</option></select></td>
				          					   
				          				</tr>
                                                                        <tr>
				         					<td align="right" class="pageHeading"><img width="1" height="30" border="0" alt="" src="images/pixel_trans.gif"></td>
				            				<td align="right" class="smallText" colspan="2">类别ID:  <input type="text"  name="search_id" value="<?php if ($_GET['action'] == 'search') echo $_GET['search_id']; ?>" /></td>
				          					   
				          				</tr>
                                                                        <tr><td align="right" class="smallText" colspan="3"><input type="hidden" name="action" value="search"/> <input type="submit" value="搜索"></td></tr>
                                                                        </form>
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
					$whereStr = '1';
                                        $status = $_GET['status'];
                                        $search_id = zen_db_prepare_input($_GET['search_id']);
                                        
					if(!empty($status)){
                                                $condition_search = 1;
                                                if(!empty($search_id)){
                                                    $condition_search = "common_categories_id  = '{$search_id}'";
                                                 }
                                                 
                                                if($status == 2){
                                                    $whereStr .= " and status in (0,1) and  {$condition_search}";
                                                }else{
                                                    $whereStr .= " and status = {$status} and {$condition_search} ";
                                                }
                                           
					}
					$pageIndex = 1;
					if($_GET['page'])
					{
					    $pageIndex = intval($_GET['page']);
					}
					$category_relation_query = "select * from ".TABLE_CATEGORIES_RELATION." where {$whereStr} ORDER BY STATUS DESC,ID DESC";
					$category_relation_lists_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $category_relation_query,$query_numrows);
					$category_relation_lists = $db->Execute($category_relation_query);
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
											<td class="dataTableHeadingContent" align="left" width="10%">ID</td>
											<td class="dataTableHeadingContent" align="center"
												width="10%">类别ID</td>
											<td class="dataTableHeadingContent" align="center"
												width="35%">对应类别ID</td>
											<td class="dataTableHeadingContent" align="center"
												width="10%">状态</td>
											<td class="dataTableHeadingContent" align="center"
												width="10%">创建人</td>
											<td class="dataTableHeadingContent" align="center"
                                                                                            width="10%">修改人</td>
											<td class="dataTableHeadingContent" align="center" width="15%">操作</td>
										</tr>
              <?php 
              $ii = 0;
              $temp = array();
              while(!$category_relation_lists->EOF){
                                $recommend_categories_id = $category_relation_lists->fields['recommend_categories_id'];
                                $recommend_arr = explode(',',$recommend_categories_id);
                                if(count($recommend_arr) > 3)$recommend_str = implode(',',array_slice($recommend_arr,0,3)).'...';
                                else $recommend_str = $recommend_categories_id;
                                $url_select_row = zen_href_link('products_category_setting', zen_get_all_get_params(array('search_id','action','ID','status')).'&selectId='.$category_relation_lists->fields['id'] , 'NONSSL');
				if (($_GET['action'] =='edit' && $cid == $category_relation_lists->fields['id']) || (!$selectId &&empty($_GET['action'])&& $ii==0)||($_GET['action'] !=='edit' && $category_relation_lists->fields['id'] == $selectId)) {
					echo '<tr class="dataTableRowSelected">';
				}else{
					echo '<tr class="dataTableRow" onclick="location.href = \''.$url_select_row.'\';">';
				}
				?>
					<td class="dataTableContent" align="left"><b><?php echo $category_relation_lists->fields['id'];?></b></td>
					<td class="dataTableContent" align="center"><?php echo $category_relation_lists->fields['common_categories_id'];?></td>
					<td class="dataTableContent" align="center" style="width:25%;word-break:break-all;word-wrap:break-word;"><?php echo $recommend_str;?></td>
					<td class="dataTableContent" align="center"><?php echo $category_relation_lists->fields['status']?'启用':"<font color='#f00'>禁用</font>";?></td>
					<td class="dataTableContent" align="center"><?php echo $category_relation_lists->fields['founder'];?></td>
					<td class="dataTableContent" align="center"><?php echo $category_relation_lists->fields['modifier'];?></td>
					<td class="dataTableContent" align="center">
                	<?php 
                		$deleteurl = "'".zen_href_link('products_category_setting', zen_get_all_get_params(array("ID", "action")) . "ID=" . $category_relation_lists->fields['id'] . '&action=delete', 'NONSSL')."'";
                		$value = "'".$property_group_list->fields['group_value']."'";
                	?>
                	<?php echo '<a href="' . zen_href_link('products_category_setting', zen_get_all_get_params() . 'ID=' .  $category_relation_lists->fields['id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
                	<?php if (($_GET['action']=='edit' && $category_relation_lists->fields['id'] == $cid)||(!$selectId && empty($_GET['action']) && $ii==0)||($_GET['action'] !=='edit' && $category_relation_lists->fields['id'] == $selectId) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' .$url_select_row . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;&nbsp;</td>
				</tr>
				<?php
                                $temp[] = $category_relation_lists->fields;
				$category_relation_lists->MoveNext();
                                $ii++;
				}
              ?>
              <tr>
				  <td colspan="4">
					  <table border="0" width="100%" cellspacing="0" cellpadding="2">
						  <tr>
							  <td class="smallText" valign="top">
								  <?php echo $category_relation_lists_split->display_count ( $query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $pageIndex, TEXT_DISPLAY_NUMBER_OF_ORDERS );?>
							  </td>
							  <td class="smallText" align="left">
								 <?php echo $category_relation_lists_split->display_links ( $query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $pageIndex);?>
							  </td>
							  <td colspan="2" align=right><a href='<?php echo zen_href_link('products_category_setting','action=add&page='.$_GET['page'])?>'>
							  	  <button class='simple_button'>添加</button></a>
							  <td>
						  </tr>
					  </table>
                  </td>
			</tr>
		</table>
		</td>
           <?php
           	   if(!$action || $action == "search" || $action=='show') {
                       if(!$selectId){
                            $data_info = !empty($temp)?array_shift($temp):array();
                       }else{
                           $query_category_row     = "select * from ".TABLE_CATEGORIES_RELATION." where id = {$selectId} limit 1";
                            $query_category_result = $db->Execute($query_category_row);
                            $data_info = $query_category_result->fields;
                       }
                       ?>    
		         <td valign="top">
					<div class="infoBoxContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tbody>
								<tr class="infoBoxHeading">
									<td class="infoBoxHeading"><b><?php echo $category_relation_lists->RecordCount() > 0 ? $pInfo->group_value : "无记录";?></b></td>
								</tr>
							</tbody>
						</table>
						<?php if($category_relation_lists->RecordCount() > 0){ ?>
							<p class="listshow">
                                                            <b>类别ID : </b>
                                                        <div class="item2"><input type="text" value="<?php echo $data_info['common_categories_id'];?>" disabled="disabled"/></div>
							</p>
							<p class="listshow">
								
                                                            <label>对应类别ID : </label>
                                                            <?php $recommend_categories_ids = explode(',',$data_info['recommend_categories_id']);$cnt = count($recommend_categories_ids);foreach($recommend_categories_ids as $key=>$id){?>
                                                            <?php if($key == $cnt - 1){?>
                                                        <div class="item"><input name="recom_categories_id[]" type="text" value="<?php echo $id;?>" disabled="disabled"/><img class="img " src="images/gray_plus.png" style="cursor:default"/></div>
                                                          <?php }else{?>
                                                            <div class="item"><input name="recom_categories_id[]" type="text" value="<?php echo $id;?>" disabled="disabled"/><img class="img " src="images/gray_minus.png" style="cursor:default"/></div>
                                                          <?php }}?>
        </p>
							
							<p class="listshow">
								<b>状态 : </b> 
                                                                <input id="afterCheckBox" value="1" type="radio" name="status"  <?php echo $data_info['status'] == 1 ? 'checked' : ''?> /><label for="afterCheckBox">启用</label>
                                                                <input type="radio" name="status" value="0"  <?php echo $data_info['status'] == 0 ? 'checked' : ''?>/><label>禁用</label>
							</p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6" style="padding-left: 6px;">
								<tr>
                                                                    <td width='60%' align='left'><input type="hidden" name="ID" value="<?php echo $data_info['id'];?>"/><button class="simple_button" disabled="disabled">Save</button>&nbsp;&nbsp;&nbsp;
                                                                        <a href="javascript:void(0)', '', 'NONSSL')?>"><input type="button" class="simple_button" value="Cancel" disabled="disabled"/></a></td>
								</tr>
							</table>
                                                <?php }?>
					</div>
				</td>
           		<?php }else if($action == 'edit'){ 
                                      $query_category_row    = "select * from ".TABLE_CATEGORIES_RELATION." where id = {$cid} limit 1";
                                      $query_category_result = $db->Execute($query_category_row);
                                      $data_info = $query_category_result->fields;
                                      
                                      $recommend_categories_ids = explode(',',$data_info['recommend_categories_id']);
                                      
                                      ?>
					<td valign="top">
					<div class="infoBoxContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							<tbody>
								<tr class="infoBoxHeading">
									<td class="infoBoxHeading"><b><?php echo $cInfo->group_value;?></b></td>
								</tr>
							</tbody>
						</table>
						<form name='relation_edit' method="post" action="<?php echo zen_href_link('products_category_setting', zen_get_all_get_params(array('ID', 'action'))  . '&action=update', 'NONSSL')?>" onSubmit="return checkSubmit('edit')">
							<p class="listshow">
                                                            <b>常规类别ID : </b>
                                                        <div class="item2"><input type="text" name="categories_id" value="<?php echo $data_info['common_categories_id'];?>" readonly="readonly"/></div>
							</p>
							<p class="listshow">
								
                                                            <label>推荐类别ID : </label>
                                                            <?php $cnt = count($recommend_categories_ids);foreach($recommend_categories_ids as $key=>$id){?>
                                                            <?php if($key == $cnt - 1){?>
                                                            <div class="item"><input name="recom_categories_id[]" type="text" value="<?php echo $id;?>" onchange="check_categoryId(this,'recommend','edit')"/><img class="img " src="images/plus.png" onclick="caterow_add(this)"/></div>
                                                          <?php }else{?>
                                                            <div class="item"><input name="recom_categories_id[]" type="text" value="<?php echo $id;?>"  onchange="check_categoryId(this,'recommend','edit')"/><img class="img " src="images/minus.png" onclick="caterow_del(this)"/></div>
                                                          <?php }}?>
        </p>
							
							<p class="listshow">
								<b>状态 : </b> 
                        <input id="afterCheckBox" value="1" type="radio" name="status" <?php if($data_info['status'] == '1'){echo 'checked';}?> /><label for="afterCheckBox">启用</label>
                                                                <input type="radio" name="status" value="0" <?php if($data_info['status'] == '0'){echo 'checked';}?>/><label>禁用</label>
							</p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6" style="padding-left: 6px;">
								<tr>
                                                                    <td width='60%' align='left'><input type="hidden" name="ID" value="<?php echo $data_info['id'];?>"/><button class="simple_button">Save</button>&nbsp;&nbsp;&nbsp;
                                                                        <a href="<?php echo zen_href_link('products_category_setting', '', 'NONSSL')?>"><input type="button" class="simple_button" value="Cancel" /></a></td>
								</tr>
							</table>						
					</form>				
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
						<form name='relation_add' method="post" action="<?php echo zen_href_link('products_category_setting', zen_get_all_get_params(array('ID', 'action'))  . '&action=create', 'NONSSL')?>" onSubmit="return checkSubmit()">
							<p class="listshow">
                                                            <b>类别ID : </b>
                                                        <div class="item2"><input type="text" name="categories_id" value="" onchange="check_categoryId(this)"/></div>
							</p>
							<p class="listshow">
								
                                                            <b>对应类别ID : </b>
                                                        <div class="item"><input name="recom_categories_id[]" type="text"  onchange="check_categoryId(this,'recommend')"/><img class="img " src="images/plus.png" onclick="caterow_add(this)"/></div>
							</p>
							<p class="listshow">
								<b>状态 : </b> <input id="afterCheckBox" value="1" type="radio"
									name="status" checked onclick="onRedioSelected(this)"/><label for="afterCheckBox">启用</label><label>
                                                                    <input type="radio" name="status" value="0" onclick="onRedioSelected(this)"/>禁用</label>
							</p>
							<table width="60%" border="0" cellspacing="0" cellpadding="6" style="padding-left: 6px;">
								<tr>
									<td width='60%' align='left'><button class="simple_button" id="add_button">Save</button>&nbsp;&nbsp;&nbsp;
                                                                        <a href="<?php echo zen_href_link('products_category_setting', '', 'NONSSL')?>"><input type="button" class="simple_button" value="Cancel" /></a></td>
								</tr>
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