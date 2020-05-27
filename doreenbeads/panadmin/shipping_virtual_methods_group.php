<?php
require('includes/application_top.php');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] :  '';

if(in_array($action, array('new', 'edit', 'country_change'))){
    $languages = zen_get_languages();
    $country_array = zen_get_countries_new();
    foreach ($country_array as $key => $country_info){
        if($key == 0){
            $first_country_code = $country_info['countries_iso_code_2'];
        }
        $country_pull[] = array('id' => $country_info['countries_iso_code_2'], 'text' => $country_info['countries_name']);
    }
    
    $virtual_shipping_method_query = 'SELECT shipping_id, shipping_erp_id, country_code FROM ' . TABLE_VIRTUAL_SHIPPING . ' WHERE shipping_status = 10';
    $virtual_shipping_method = $db->Execute($virtual_shipping_method_query);
    
    while (!$virtual_shipping_method->EOF){
        $country_code = $virtual_shipping_method->fields['country_code'];
        
        $virtual_shipping_method_array[$country_code][] = array('shipping_erp_id' => $virtual_shipping_method->fields['shipping_erp_id'], 'name' => strtoupper($virtual_shipping_method->fields['shipping_erp_id']));
            
        $virtual_shipping_method->MoveNext();
    }
    
}

$pageIndex = 1;
if($_GET['page'])
{
    $pageIndex = intval($_GET['page']);
}

$shipping_virtual_group_query = 'SELECT shipping_group_id, group_name, c.countries_name, country_code, shipping_erp_id_group, group_status from t_virtual_shipping_group tvsg INNER JOIN t_countries c on tvsg.country_code = c.countries_iso_code_2 ';
$shipping_virtual_group_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $shipping_virtual_group_query, $query_numrows);
$shipping_virtual_group = $db->Execute($shipping_virtual_group_query);

switch ($action){
    case 'country_change':
        $country_code = $_GET['country_code'];
        $shipping_str = '';
        
        if($country_code != '' && isset($virtual_shipping_method_array[$country_code])){
            foreach ($virtual_shipping_method_array[$country_code] as $virtual_shipping_method_detail){
                $shipping_str .= '<label style="font-size:15px; margin-right: 30px;">' . zen_draw_checkbox_field('method[]', $virtual_shipping_method_detail['shipping_erp_id'], false, '', 'class="method_class"') . '<span style="position: relative; bottom: 2px;">' . $virtual_shipping_method_detail['name'] . '</span>' . '</label>';
            }
        }
        
        echo $shipping_str;
        exit;
        break;
        
    case 'create':
        $group_name = zen_db_prepare_input($_POST['group_name']);
        $group_description = zen_db_prepare_input($_POST['description']);
        $country_code = zen_db_prepare_input($_POST['country_code']);
        $group_method = zen_db_prepare_input($_POST['method']);
        $group_status = zen_db_prepare_input($_POST['status']);
        
        $group_method_str = implode(',', $group_method);
        
        $group_info_array = array(
            'group_name' => $group_name,
            'country_code' => $country_code,
            'shipping_erp_id_group' => $group_method_str,
            'group_status' => $group_status,
            'create_admin' => $_SESSION['admin_email'],
            'create_datetime' => 'now()'
        );
        
        zen_db_perform(TABLE_VIRTUAL_SHIPPING_GROUP, $group_info_array);
        $shipping_group_id = $db->insert_ID();
        
        $i = 1;
        foreach ($group_description as $values){
            $group_description_data = array(
                'shipping_group_id' => $shipping_group_id,
                'language_id' => $i,
                'group_description' => $values
            );
            $i++;
            zen_db_perform(TABLE_VIRTUAL_SHIPPING_GROUP_DESCRIPTION, $group_description_data);
        }
       
        $messageStack->add_session('该虚拟海外仓运输方式新建成功！','success');
        zen_redirect(zen_href_link('shipping_virtual_methods_group', zen_get_all_get_params(array('action'))));
        break;
        
    case 'update':
        $group_name = zen_db_prepare_input($_POST['group_name']);
        $group_description = zen_db_prepare_input($_POST['description']);
        $country_code = zen_db_prepare_input($_POST['country_code']);
        $group_method = zen_db_prepare_input($_POST['method']);
        $group_status = zen_db_prepare_input($_POST['status']);
        $shipping_group_id = zen_db_prepare_input($_POST['shipping_group_id']);
        
        $group_method_str = implode(',', $group_method);
        
        $group_info_array = array(
            'group_name' => $group_name,
            'country_code' => $country_code,
            'shipping_erp_id_group' => $group_method_str,
            'group_status' => $group_status,
            'modify_admin' => $_SESSION['admin_email'],
            'modify_datetime' => 'now()'
        );
        
        zen_db_perform(TABLE_VIRTUAL_SHIPPING_GROUP, $group_info_array, 'update', 'shipping_group_id =' . $shipping_group_id);
        
        $i = 1;
        foreach ($group_description as $values){
            $group_description_data = array(
                'group_description' => $values
            );
            
            zen_db_perform(TABLE_VIRTUAL_SHIPPING_GROUP_DESCRIPTION, $group_description_data, 'update', ' shipping_group_id =' . $shipping_group_id . ' and language_id=' . $i);
            $i++;
        }
        
        $messageStack->add_session('该虚拟海外仓运输方式更新成功！','success');
        zen_redirect(zen_href_link('shipping_virtual_methods_group', zen_get_all_get_params(array('action'))));
        break;
}
?>

<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>虚拟海外仓运输方式组</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
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

  function check_form(form_name){
	  var error = false;
	  var group_name = $('input[name=group_name]').val();
	  var description = '';
	  $('.group_description').each(function(){
		 if($(this).val() != ''){
			 description = $(this).val();
		 }
	  });

	  if(group_name == ''){
		  error = true;
		$('.name_error').html('请填写虚拟海外仓小组名称！');
	  }

	  if(description == ''){
		  error = true;
		$('.descriprion_error').html('请填写名称！');
	  }

	  if($('.method_class:checked').length == 0){
		  error = true;
		$('.shipping_error').html('请选择至少一个运输方式！');
	  }

	  return !error;
  }
	function process_json(data){
		var returnInfo=eval('('+data+')');
		return returnInfo;
	}
  $(function(){
	  $('select[name=country_code]').change(function(){
		var country_code = $(this).val();

		$('.shipping_error').html('');
		
		$.ajax({
			'url'  :  'shipping_virtual_methods_group.php',
			'type' :  'get',
			'data' :  {'action':'country_change', 'country_code':country_code},
			'async':  false,
			'success' : function(data){
				$('.virtual_shipping_area').html(data);
				}
			});
		  });
	  });
</script>
<style>
 .info_red{
 	color:red;
 	margin: 5px;
 }
 .simple_button{
    background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;
 }
 .star_red{
    color:red;
 }
</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php');?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
  <tr>
  	<td colspan=2 style="text-align: left;"><div style="font-size: 20px;padding: 20px 0 20px 30px;font-style: inherit;font-weight: bold;">虚拟海外仓组</div></td>
  </tr>
  	<tr>
      	<td valign="top" width="70%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
          	<tr>
                <td valign="top" width='80%'>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr class="dataTableHeadingRow">
                        <td class="dataTableHeadingContent" align="left">ID</td> 
                        <td class="dataTableHeadingContent" align="center">虚拟海外仓小组名称</td>
                        <td class="dataTableHeadingContent" align="center">国家</td>
                        <td class="dataTableHeadingContent" align="center">虚拟海外仓运输方式</td>
                        <td class="dataTableHeadingContent" align="center">状态</td>
                        <td class="dataTableHeadingContent" align="right">操作</td>
                      </tr>
                      <?php
                      while(!$shipping_virtual_group->EOF){
                          $i = 1;
                          if ((!isset($_GET['gID']) || (isset($_GET['gID']) && ($_GET['gID'] == $shipping_virtual_group->fields['shipping_group_id']))) && !isset($gInfo)) {
                              $gInfo_array = $shipping_virtual_group->fields;
                              $gInfo = new objectInfo($gInfo_array);
                              $_GET['page'] = ceil($i / 20);
                          }
                          $i++;
                          $shipping_erp_group_array = explode(',' , $shipping_virtual_group->fields['shipping_erp_id_group']);
                          $temp_array = array_slice($shipping_erp_group_array, 0, 4);
                          $shipping_erp_group_str = implode(',', $temp_array);
                          if(sizeof($shipping_erp_group_array) > 4){
                              $shipping_erp_group_str .= '...';
                          }
                      	?>
        	              <tr class="dataTableRow">
        	                <td class="dataTableHeadingContent" align="left"><?php echo $shipping_virtual_group->fields['shipping_group_id'] ?></td> 
        	                <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_group->fields['group_name'] ?></td>
        	                 <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_group->fields['countries_name'] ?></td>
        	                <td class="dataTableHeadingContent" align="center"><?php echo $shipping_erp_group_str;?></td>
        	                <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_group->fields['group_status'] == 10 ? '开启' : '关闭' ?></td>
        	                <td class="dataTableContent" align="right">
                		<?php echo '<a href="' . zen_href_link('shipping_virtual_methods_group', zen_get_all_get_params(array('gID', 'action' )) . 'gID=' . $shipping_virtual_group->fields['shipping_group_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
                		<?php if ( (is_object($gInfo)) && ($shipping_virtual_group->fields['shipping_group_id'] == $gInfo->shipping_group_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link('shipping_virtual_methods_group', zen_get_all_get_params(array('action' , 'gID' , 'page' )) . 'page=' . $pageIndex . '&gID=' . $shipping_virtual_group->fields['shipping_group_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                	</td>
        	              </tr>
                     <?php 	$shipping_virtual_group->MoveNext();
                      }
                      ?>
                      </table>
                   	</td>
                  </tr>
                  <tr>
    	              <td style="padding-top: 10px;">
    		              <table border="0" width="100%" cellspacing="0" cellpadding="2">
    		              <tr>
    		             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $shipping_virtual_group_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
    		                <td class="dataTableHeadingContent" colspan="5" align="right"><?php echo $shipping_virtual_group_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'id')) . '&products_key=' . urlencode($_GET['products_key'])); ?></td>
    		              </tr>
    		              </table>
    	              </td>
                  </tr>
                  <tr>
                    <td align="right">
                    	<a href='<?php  echo zen_href_link('shipping_virtual_methods_group','action=new&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>新建</button></a>
                    </td>
                  </tr>
                </td>
            </tr>
          </tbody>
          </table>
    	</td>
    	<?php if($action == 'new'){?>
    	    <td valign="top" >
                <div class="infoBoxContent">
                	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          				<tbody>
          					<tr class="infoBoxHeading">
            					<td class="infoBoxHeading"><b>新建虚拟海外仓小组: </b></td>
          					</tr>
        				</tbody>
        			</table>
        			<?php echo zen_draw_form('create_form', 'shipping_virtual_methods_group', zen_get_all_get_params(array('action')), 'post', 'id="create_form"')?>
        			<?php echo zen_draw_hidden_field('action', 'create')?>
        			<table width="100%" border="0" cellspacing="0" cellpadding="2">
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%"><span class="star_red">*</span>虚拟海外仓小组名称 ：</td><td><?php echo zen_draw_input_field('group_name');?></td></tr>
        				<tr><td></td><td class="name_error info_red"></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">English : </td><td><?php echo zen_draw_input_field('description[]', '', 'class="group_description"')?></td></tr>
        				<tr><td></td><td class="descriprion_error info_red"></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">Deutsch : </td><td><?php echo zen_draw_input_field('description[]', '', 'class="group_description"')?></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">Русский : </td><td><?php echo zen_draw_input_field('description[]', '', 'class="group_description"')?></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">Français : </td><td><?php echo zen_draw_input_field('description[]', '', 'class="group_description"')?></td></tr>
        				<tr style="line-height: 40px;" ><td style="text-align: right;" width="50%">国家 ：</td><td><?php echo zen_draw_pull_down_menu('country_code', $country_pull)?></td></tr>
        				<tr >
        					<td style="text-align: right;vertical-align: top;" width="50%"><span class="star_red">*</span>虚拟海外仓运输方式 : </td>
        					<td class="virtual_shipping_area">
        						<?php 
        						if(isset($virtual_shipping_method_array[$first_country_code])){
    						        foreach ($virtual_shipping_method_array[$first_country_code] as $method_info){
    						            echo '<label style="font-size:15px; margin-right: 30px;">' . zen_draw_checkbox_field('method[]', $method_info['shipping_erp_id'], false, '', 'class="method_class"') . '<span style="position: relative; bottom: 2px;">' . $method_info['name'] . '</span>' . '</label>' ;
    						        }
        						}else{
        						    echo '<div class="info_red">此国家下没有虚拟海外仓运输方式！</div>';
        						}
        						?>
        					</td>
        				</tr>
        				<tr><td></td><td class="shipping_error info_red"></td></tr>
        				<tr>
        					<td style="text-align: right;" width="50%">状态 ： </td>
        					<td>
        						<label><?php echo zen_draw_radio_field('status', 10, true)?><span style="position: relative;bottom:2px;">开启</span></label>
        						<label><?php echo zen_draw_radio_field('status', 20, false)?><span style="position: relative;bottom:2px;">关闭</span></label>
        					</td>
        				</tr>
        				<tr height="50px">
        					<td style="text-align: right;" ><button class='simple_button' onclick='return check_form("create_form")'>Submit</button></td>
        					<td><a href="<?php echo zen_href_link('shipping_virtual_methods_group', zen_get_all_get_params(array('action')))?>"><button type="button" class='simple_button'>Cancel</button></a></td>
        				</tr>
        			</table>
        			<?php echo '</form>';?>
        		</div>
        	</td>
    	    
    	<?php }elseif($action == 'edit'){?>
    	<?php 
    	   if($gInfo->shipping_group_id > 0){
    	       $group_description_query = 'select group_description from ' . TABLE_VIRTUAL_SHIPPING_GROUP_DESCRIPTION . ' where shipping_group_id = ' . $gInfo->shipping_group_id . ' order by language_id asc';
        	    $group_description = $db->Execute($group_description_query);
        	    $group_description_array =  array();
        	    
        	    while(!$group_description->EOF){
        	        $group_description_array[] = $group_description->fields['group_description'];
        	        
        	        $group_description->MoveNext();
        	    }
        	    
           }
           
           $virtual_shipping_array =explode(',', $gInfo->shipping_erp_id_group);
    	?>
    	    <td valign="top" >
                <div class="infoBoxContent">
                	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          				<tbody>
          					<tr class="infoBoxHeading">
            					<td class="infoBoxHeading"><b>虚拟海外仓小组 ID: <?php echo $gInfo->shipping_group_id?></b></td>
          					</tr>
        				</tbody>
        			</table>
        			<?php echo zen_draw_form('update_form', 'shipping_virtual_methods_group', zen_get_all_get_params(array('action')), 'post', 'id="update_form"')?>
        			<?php echo zen_draw_hidden_field('action', 'update')?>
        			<?php echo zen_draw_hidden_field('shipping_group_id', $gInfo->shipping_group_id)?>
        			<table width="100%" border="0" cellspacing="0" cellpadding="2">
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%"><span class="star_red">*</span>虚拟海外仓小组名称 ：</td><td><?php echo zen_draw_input_field('group_name', $gInfo->group_name);?></td></tr>
        				<tr><td></td><td class="name_error info_red"></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">English : </td><td><?php echo zen_draw_input_field('description[]', $group_description_array[0], 'class="group_description"')?></td></tr>
        				<tr><td></td><td class="descriprion_error info_red"></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">Deutsch : </td><td><?php echo zen_draw_input_field('description[]', $group_description_array[1], 'class="group_description"')?></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">Русский : </td><td><?php echo zen_draw_input_field('description[]', $group_description_array[2], 'class="group_description"')?></td></tr>
        				<tr style="line-height: 40px;"><td style="text-align: right;" width="50%">Français : </td><td><?php echo zen_draw_input_field('description[]', $group_description_array[3], 'class="group_description"')?></td></tr>
        				<tr style="line-height: 40px;" ><td style="text-align: right;" width="50%">国家 ：</td><td><?php echo zen_draw_pull_down_menu('country_code', $country_pull, $gInfo->country_code)?></td></tr>
        				<tr >
        					<td style="text-align: right;vertical-align: top;" width="50%"><span class="star_red">*</span>虚拟海外仓运输方式 : </td>
        					<td class="virtual_shipping_area">
        						<?php 
        						foreach ($virtual_shipping_method_array[$gInfo->country_code] as $method_info){
        						    echo '<label style="font-size:15px; margin-right: 30px;">' . zen_draw_checkbox_field('method[]', $method_info['shipping_erp_id'], (in_array($method_info['shipping_erp_id'], $virtual_shipping_array) ? true : false), '', 'class="method_class"') . '<span style="position: relative; bottom: 2px;">' . $method_info['name'] . '</span>' . '</label>' ;
        						    }
        						?>
        					</td>
        				</tr>
        				<tr><td></td><td class="shipping_error info_red"></td></tr>
        				<tr>
        					<td style="text-align: right;" width="50%">状态 ： </td>
        					<td>
        						<label><?php echo zen_draw_radio_field('status', 10, ($gInfo->group_status == 10 ? true :false))?><span style="position: relative;bottom:2px;">开启</span></label>
        						<label><?php echo zen_draw_radio_field('status', 20, ($gInfo->group_status == 20 ? true :false))?><span style="position: relative;bottom:2px;">关闭</span></label>
        					</td>
        				</tr>
        				<tr height="50px">
        					<td style="text-align: right;" ><button class='simple_button' onclick='return check_form("update_form")'>Submit</button></td>
        					<td><a href="<?php echo zen_href_link('shipping_virtual_methods_group', zen_get_all_get_params(array('action')))?>"><button type="button" class='simple_button'>Cancel</button></a></td>
        				</tr>
        			</table>
        			<?php echo '</form>';?>
        		</div>
        	</td>
    	<?php }else{?>
    	    <td valign="top" >
                <div class="infoBoxContent">
                	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          				<tbody>
          					<tr class="infoBoxHeading">
            					<td class="infoBoxHeading"><b>虚拟海外仓小组 ID: <?php echo $gInfo->shipping_group_id;?></b></td>
          					</tr>
        				</tbody>
        			</table>
    				
    				<table width="100%" border="0" cellspacing="0" cellpadding="2">
    					<tr style="line-height: 20px;"><td style="text-align: right;" width="50%"><b>虚拟海外仓小组名称 : </b></td><td style="padding-left: 10px;"><?php echo $gInfo->group_name ? $gInfo->group_name : '/';?></td></tr>
    					<?php 
    					    if($gInfo->shipping_group_id > 0){
    					        $virtual_group_description_query = 'SELECT language_id, group_description FROM ' . TABLE_VIRTUAL_SHIPPING_GROUP_DESCRIPTION . ' WHERE shipping_group_id = ' . $gInfo->shipping_group_id . ' order by language_id asc';
    					        $virtual_group_description = $db->Execute($virtual_group_description_query);
//     					        $description_array = array(array('language_id' => 1, 'description' => '/'),array('language_id' => 2, 'description' => '/'),array('language_id' => 3, 'description' => '/'),array('language_id' => 4, 'description' => '/'));
    					        
    					        if($virtual_group_description->RecordCount() > 0){
    					            while (!$virtual_group_description->EOF){
    					                if($virtual_group_description->fields['group_description'] != ''){
    					                    echo '<tr><td style="text-align: right;">' . $languages[$virtual_group_description->fields['language_id']-1]['name'] . ' : </td><td style="padding-left: 10px;"> ' . $virtual_group_description->fields['group_description'] . '</td></tr>';
    					                }
    					                
    					                $virtual_group_description->MoveNext();
    					            }
    					        }
        					}
    					?>
    					
    					<tr style="line-height: 20px;"><td style="text-align: right;" width="50%"><b>国家  : </b></td><td style="padding-left: 10px;"><?php echo $gInfo->countries_name ? $gInfo->countries_name : '/';?></td></tr>
    					<tr style="line-height: 20px;"><td style="text-align: right;" width="50%"><b>虚拟海外仓运输方式 : </b></td><td style="padding-left: 10px;"><?php echo $gInfo->shipping_erp_id_group ? $gInfo->shipping_erp_id_group : '/';?></td></tr>
    					<tr style="line-height: 20px;"><td style="text-align: right;" width="50%"><b>状态 : </b></td><td style="padding-left: 10px;"><?php echo $gInfo->group_status == 10 ? '开启' : '关闭';?></td></tr>
    				</table>
    				<p class="listshow" style="text-align: center;margin-top:20px;">
    					<a href='<?php  echo zen_href_link('shipping_virtual_methods_group','action=edit&gID=' . $gInfo->shipping_group_id . '&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>编辑</button></a>
    				</p>
                </div>
             </td>
    	<?php }?>
    </tr>
  </tbody>
</table>









