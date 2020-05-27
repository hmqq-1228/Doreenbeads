<?php
/**
 * �����ļ�
 * �˿Ͷ���վ���۵Ĺ���
 * avatar_manage.php
 * jessa 2010-06-17
 */

  require('includes/application_top.php');  
  $action = (isset($_POST['action']) ? $_POST['action'] : '');
  if (zen_not_null($action)) {
    switch ($action) {
    	case 'update_status':
    		if(isset($_POST['update_id'])&&isset($_POST['set_avatar_status'])){
    			$if_accept=$_POST['set_avatar_status'];
    			if($if_accept==1){
    				$select_query="select customers_info_avatar_tmp,customers_info_avatar_check,customers_info_avatar,customers_email_address,customers_firstname,customers_lastname 	 from ".TABLE_CUSTOMERS_INFO." ci , ".TABLE_CUSTOMERS." c where ci.customers_info_id=c.customers_id and customers_info_id=".$_POST['update_id']." ";
    				$select=$db->Execute($select_query);
    				
    				
    				if(substr($select->fields['customers_info_avatar'],0,7)!='Default'){
    				unlink(DIR_WS_USER_AVATAR.$select->fields['customers_info_avatar']);
    				}
    				unlink(DIR_WS_USER_AVATAR.'tmp/'.$select->fields['customers_info_avatar_tmp']);
    				unlink(DIR_WS_USER_AVATAR.'tmp_s/'.$select->fields['customers_info_avatar_tmp']);
    				rename(DIR_WS_USER_AVATAR.$select->fields['customers_info_avatar_check'],DIR_WS_USER_AVATAR.'current/'.substr($select->fields['customers_info_avatar_check'], 6));
    				
    				$image_position=HTTP_SERVER.DIR_WS_ADMIN.'images/';
    				$avartar_position=HTTP_SERVER.'/images/Users/';
    				$to_name=$select->fields['customers_firstname'].' '.$select->fields['customers_lastname'];
    				$to_address=$select->fields['customers_email_address'];
    				$email_subject=TEXT_AVATAR_CHECKING_SUCCESSFULLY;
    				$email_text=TEXT_HEADER_CALL."\n";
					$html_msg['EMAIL_CONTENT_HEADER']=TEXT_HEADER_CALL;
					$email_text.=TEXT_CONTENT_INFO."\n";
					$email_text.=TEXT_CONTENT_END."\n";
					$html_msg['EMAIL_CONTENT_IMG_SHOW']="<table border=0 cellpadding=0 cellspacing=0 width='400' align=center><tr><td colspan=3 height='20'>&nbsp;</td></tr><tr>
					<td width='125' align='right' class='need'>".zen_image($image_position.'unkown.gif')."</td>
					<td width='150' align='center'>".zen_image($image_position.'check_right.gif')."</td>
					<td width='125' align='left' class='need'>".zen_image($avartar_position.'current/'.substr($select->fields['customers_info_avatar_check'], 6))."</td>
					</tr><tr><td colspan=3 height='30'>&nbsp;</td></tr><tr></table>";
					$html_msg['EMAIL_CONTENT_INFO']=TEXT_CONTENT_INFO."<div style='text-align:center'>".zen_image($image_position.'happiness.gif')."</div>";
					$html_msg['EMAIL_CONTENT_END']=TEXT_CONTENT_END;
					zen_mail($to_name,$to_address,$email_subject,$email_text,STORE_NAME,EMAIL_FROM,$html_msg,'avatar_checking_result');					
    				$update_query="update ".TABLE_CUSTOMERS_INFO." set customers_info_avatar='current/".substr($select->fields['customers_info_avatar_check'], 6)."', customers_info_avatar_tmp='', customers_info_avatar_check='', customers_info_avatar_check_status=1 , customers_info_avatar_date_updated='".date('Y-m-d H:i:s')."' where  customers_info_id=".$_POST['update_id']."  ";
    				$db->Execute($update_query);    				
    				zen_redirect(zen_href_link(FILENAME_AVATAR_MANAGE,'id='.$_POST['update_id']));
    			}else{
    				$select_query="select customers_info_avatar,customers_info_avatar_tmp,customers_info_avatar_check,customers_email_address,customers_firstname,customers_lastname  from ".TABLE_CUSTOMERS_INFO." ci , ".TABLE_CUSTOMERS." c where ci.customers_info_id=c.customers_id and  customers_info_id=".$_POST['update_id']." ";
    				$select=$db->Execute($select_query);
    				
    				unlink(DIR_WS_USER_AVATAR.$select->fields['customers_info_avatar_check']);
    				unlink(DIR_WS_USER_AVATAR.'tmp/'.$select->fields['customers_info_avatar_tmp']);
    				unlink(DIR_WS_USER_AVATAR.'tmp_s/'.$select->fields['customers_info_avatar_tmp']);
    				
    				$image_position=HTTP_SERVER.DIR_WS_ADMIN.'images/';
    				$avartar_position=HTTP_SERVER.'/images/Users/';
    				$to_name=$select->fields['customers_firstname'].' '.$select->fields['customers_lastname'];
    				$to_address=$select->fields['customers_email_address'];
    				$email_subject=TEXT_AVATAR_CHECKING_FAILURE;
    				$email_text=TEXT_HEADER_CALL."\n";
					$html_msg['EMAIL_CONTENT_HEADER']=TEXT_HEADER_CALL;
					$show_reason=trim($_POST['refuse_reason'])==''?'':('<br>'.TEXT_RUFUSED_REASON.'<br>'.$_POST['refuse_reason']."<br>");
					
					$email_text.=TEXT_REFUSED_FIRST."\n".$show_reason."\n".TEXT_REFUSED_LAST."\n";
					$email_text.=TEXT_CONTENT_END."\n";
					$html_msg['EMAIL_CONTENT_IMG_SHOW']="<table border=0 cellpadding=0 cellspacing=0 width='400' align=center><tr><td colspan=3 height='20'>&nbsp;</td></tr><tr>
					<td width='125' align='right' class='need'>".zen_image($avartar_position.$select->fields['customers_info_avatar'])."</td>
					<td width='150' align='center'>".zen_image($image_position.'check_wrong.gif')."</td>
					<td width='125' align='left' class='need'>".zen_image($image_position.'unkown.gif')."</td>
					</tr><tr><td colspan=3 height='30'>&nbsp;</td></tr><tr></table>";
					$html_msg['EMAIL_CONTENT_INFO']=TEXT_REFUSED_FIRST.$show_reason.TEXT_REFUSED_LAST."<div style='text-align:center'>".zen_image($image_position.'sadness.gif')."</div>";
					$html_msg['EMAIL_CONTENT_END']=TEXT_CONTENT_END;
					zen_mail($to_name,$to_address,$email_subject,$email_text,STORE_NAME,EMAIL_FROM,$html_msg,'avatar_checking_result');
					
    				$update_query="update ".TABLE_CUSTOMERS_INFO." set customers_info_avatar_tmp='', customers_info_avatar_check='', customers_info_avatar_check_status=1 , customers_info_avatar_date_updated='".date('Y-m-d H:i:s')."' where  customers_info_id=".$_POST['update_id']."  ";
    				$db->Execute($update_query);
    				zen_redirect(zen_href_link(FILENAME_AVATAR_MANAGE,'id='.$_POST['update_id']));
    			}
    		}
    	break;
    	case 'set_default':
    		$avatar_check_email_arr = array(
    				1 => 'sale@doreenbeads.com',
    				2 => 'service_de@doreenbeads.com',
    				3 => 'service_ru@doreenbeads.com',
    				4 => 'service_fr@doreenbeads.com'
    		);
    		if(isset($_POST['update_id'])){
    			$select_query="select customers_info_avatar_tmp,customers_info_avatar_check,customers_info_avatar ,register_languages_id, customers_firstname , customers_lastname , customers_email_address from ".TABLE_CUSTOMERS_INFO." ,  " . TABLE_CUSTOMERS . " where customers_info_id=".$_POST['update_id']." AND customers_id = " . $_POST['update_id'];
    			$select=$db->Execute($select_query);
    			$customers_language = $select->fields['register_languages_id'];
    			unlink(DIR_WS_USER_AVATAR.$select->fields['customers_info_avatar_check']);
    			unlink(DIR_WS_USER_AVATAR.'tmp/'.$select->fields['customers_info_avatar_tmp']);
    			unlink(DIR_WS_USER_AVATAR.'tmp_s/'.$select->fields['customers_info_avatar_tmp']);
    			if(substr($select->fields['customers_info_avatar'],0,7)!='Default'){
    				unlink(DIR_WS_USER_AVATAR.$select->fields['customers_info_avatar']);
    			}
    			$update_query="update ".TABLE_CUSTOMERS_INFO." set customers_info_avatar='Default/8seasons.jpg', customers_info_avatar_tmp='', customers_info_avatar_check='', customers_info_avatar_check_status=1 , customers_info_avatar_date_updated='".date('Y-m-d H:i:s')."' where  customers_info_id=".$_POST['update_id']."  ";
    			$db->Execute($update_query);
    			$html_text=sprintf('您好，由于客户（%s，%s）上传的头像不符合本网站的规定，现已被初始化，请您及时联系该客户进行修改，谢谢！', $select->fields['customers_email_address'] ,  $select->fields['customers_firstname'] . ' ' . $select->fields['customers_lastname'] );
    			
    			$html_msg['EMAIL_CONTENT_HEADER']='';
    			$html_msg['EMAIL_CONTENT_IMG_SHOW']="";
    			$html_msg['EMAIL_CONTENT_INFO']=sprintf('您好，由于客户（%s，%s）上传的头像不符合本网站的规定，现已被初始化，请您及时联系该客户进行修改，谢谢！', $select->fields['customers_email_address'] , $select->fields['customers_firstname'] . ' ' . $select->fields['customers_lastname'] );;
    			$html_msg['EMAIL_CONTENT_END']='';
    			zen_mail('',$avatar_check_email_arr[$customers_language],'有客户的头像被初始化',$html_text,STORE_NAME,'notification@8seasons.com',$html_msg,'avatar_checking_result');
    			zen_redirect(zen_href_link(FILENAME_AVATAR_MANAGE,'id='.$_POST['update_id']));
    		}
    	break;
    }
  }   
//  if(isset($_GET['avatarLang'])){
//  if($_GET['avatarLang']!=0){
//   $avatar_lang= "  where language_id = ".$_GET['avatarLang'];  	
//  }else{
//  	$avatar_lang='';
//  }
//  }else{
//  	$avatar_lang= '';
//  }
  $avatar_query = "Select c.customers_id,customers_email_address,customers_firstname,customers_lastname,customers_info_avatar,customers_info_avatar_check,customers_info_avatar_check_status,customers_info_avatar_date_updated
  						  From ".TABLE_CUSTOMERS_INFO." ci, ".TABLE_CUSTOMERS." c
  						  where ci.customers_info_id=c.customers_id
  					  Order By  customers_info_avatar_date_updated Desc,customers_info_avatar_check_status asc";
  $avatar_split = new splitPageResults($_GET['page'], 30, $avatar_query, $query_num_rows);
  $avatar = $db->Execute($avatar_query);
  
  $avatar_array = array();
  if ($avatar->RecordCount() > 0){
  	while (!$avatar->EOF){
  		$avatar_array[] = array('id' => zen_db_output($avatar->fields['customers_id']),
  								'name'=>zen_db_output($avatar->fields['customers_firstname']).' '.zen_db_output($avatar->fields['customers_lastname']),
  								'email' => zen_db_output($avatar->fields['customers_email_address']),
  								'date' => zen_db_output($avatar->fields['customers_info_avatar_date_updated']),
  								'status' => zen_db_output($avatar->fields['customers_info_avatar_check_status']),
  								'current' => zen_db_output($avatar->fields['customers_info_avatar']),
  								'check' => zen_db_output($avatar->fields['customers_info_avatar_check'])
  								);
  		$avatar->MoveNext();
  	}
  }
  if (!isset($_GET['id']) || (isset($_GET['id']) && $_GET['id'] == '')){
  	$id = $avatar_array[0]['id'];
  } else {
  	$id = $_GET['id'];
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
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
 
  function show_reasons(id){
	  show=document.getElementById('refuse_reason_div');
	  
  	if(id.value==0){
  		show.style.display='block';
  	  	}else{
			show.style.display='none';
  	  	  	}
  }

</script>
<style>
.avatar_img_div img{
	border:3px solid orange;
	margin:10px;
}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body bof -->

<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  <tr>
  	<td class="pageHeading"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);?></td>
  </tr><!--
  <tr>
  	<td class="pageHeading"><div style="float:left;">Avatar Manage</div>
  	<?php 
  	echo  zen_draw_form('search', FILENAME_AVATAR_MANAGE, '', 'get', '', true);
  	echo "<div style='float:right;font-size:12px;color:#000;'> ".BOX_LOCALIZATION_LANGUAGES.": ";
    $langs = zen_get_languages();
    $langs_array = array();
    echo "<select name='avatarLang'>";
    echo "<option value=0>".TEXT_ALL."</option>";
    for ($i = 0, $n = sizeof($langs); $i < $n; $i++) {
    	if(isset($_GET['avatarLang'])&&$_GET['avatarLang']==$langs[$i]['id']){
    	echo "<option selected='selected' value=".$langs[$i]['id'].">".$langs[$i]['directory']."</option>"; 
    	}
    	else{
    	echo "<option value=".$langs[$i]['id'].">".$langs[$i]['directory']."</option>";
    	}
    }
    echo "</select>
    <input type='submit' value='".IMAGE_SEARCH."'></div>
    </form>";?>
  	
  	</td>
  </tr>
  --><tr>
  	<td style="padding:10px 0px;">
  	<?php 
	  if ($action != 'addnew'){
	?>
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:75%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	  	  <tr class="dataTableHeadingRow">
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:12%;">Customer ID</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:24%;">Customer Name</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:24%;">Customer Email</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:14%; text-align:center;">Date Added</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 5px; width:12%; text-align:right;">Action</td>
	  	  	  </tr>
	  	  	  <?php
	  	  	    for ($i = 0; $i < sizeof($avatar_array); $i++){
	  	  	    	
	  	  	  ?>
	  	  	  <?php if ($id == $avatar_array[$i]['id']){ ?>
	  	  	  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link(FILENAME_AVATAR_MANAGE, (isset($_GET['avatarLang'])?'avatarLang='.$_GET['avatarLang'].'&':'').'id=' . $avatar_array[$i]['id'].'&page='.$_GET['page']); ?>'">
	  	  	  <?php } else { ?>
	  	  	  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo zen_href_link(FILENAME_AVATAR_MANAGE, (isset($_GET['avatarLang'])?'avatarLang='.$_GET['avatarLang'].'&':'').'id=' . $avatar_array[$i]['id'].'&page='.$_GET['page']); ?>'">
	  	  	  <?php } ?>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;"><?php echo $avatar_array[$i]['id']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;"><?php echo $avatar_array[$i]['name']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;"><?#php echo ($_SESSION['show_customer_email'] ? $avatar_array[$i]['email'] : $avatar_array[$i]['id']); ?><?php echo $avatar_array[$i]['email'];?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $avatar_array[$i]['date']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 5px;" align="right">
	  	  	  	<?php 
	  	  	  	  if ($id == $avatar_array[$i]['id']){
	  	  	  	  	$current_id=$i;
	  	  	  	  	echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
	  	  	  	  } else {
	  	  	  	  	echo '<a href="' . zen_href_link(FILENAME_AVATAR_MANAGE, (isset($_GET['avatarLang'])?'avatarLang='.$_GET['avatarLang'].'&':''). 'id=' . $avatar_array[$i]['id'].'&page='.$_GET['page']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif') . '</a>';
	  	  	  	  }
	  	  	  	?>
	  	  	  	</td>
	  	  	  </tr>
	  	  	  <?php } ?>
			  <?php if (sizeof($avatar_array) > 0){ ?>
			  <tr>
			  	<td colspan="6" style="padding:5px; text-align:right;"><?php echo $avatar_split->display_count($query_num_rows, 30, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS) . '&nbsp;&nbsp;&nbsp;&nbsp;' . $avatar_split->display_links($query_num_rows, 30, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'id'))); ?></td>
			  </tr>
			  <?php } ?>
	  	  	</table>
	  	  </td>
	  	  <?php
	  	  	$current_avatar_info = $avatar_array[$current_id];
	  	  ?>
	  	  <td style="widht:25%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	      <tr>
	  	      	<td class="infoBoxHeading" style="padding:5px 5px;"><?php echo '#ID: ' . $id . '&nbsp;&nbsp;' . $current_avatar_info['name']; ?></td>
	  	      </tr>
	  	      <tr>
	  	      	<td class="infoBoxContent" style="padding:5px;">
	  	      	Current Avatar:
	  	      	<div class="avatar_img_div">
	  	      	<style>
				.avatar_img_div img{
					max-height:100px;
max-width:100px;
					}
				</style>
	  	      	<?php 
	  	      	echo zen_image(DIR_WS_USER_AVATAR.$current_avatar_info['current']);
	  	      	?>
	  	      	</div>
	  	      	</td>
	  	      </tr>
	  	      <?php 
// 	  	      if($current_avatar_info['status']!='1'){
// 	  	      ?>
	  	      <tr><td class="infoBoxContent" style="padding:5px;">
<!-- 	  	      Avatar pending: -->
<!-- 	  	      	<div class="avatar_img_div" id="avatar_img_div"> -->
	  	      	
	  	      	<?php 
// 	  	      	echo zen_image(DIR_WS_USER_AVATAR.$current_avatar_info['check']);
// 	  	      	?>
<!-- 	  	      	</div> -->
	  	      	<form action="<?php echo zen_href_link(FILENAME_AVATAR_MANAGE);?>" method="post">
	  	      	<input type="hidden" name="update_id" value="<?php echo $id;?>">
<!-- 	  	      	<input type="hidden" name="action" value="update_status"> -->
<!-- 	  	      	<select name="set_avatar_status" onchange="show_reasons(this)"> -->
<!-- 	  	      		<option value="1" selected="selected">Accepted</option> -->
<!-- 	  	      		<option value="0">Refuse</option> -->
	  	      		
<!-- 	  	      	</select><br> -->
	  	      	<div id="refuse_reason_div" style="display:none">
<!-- 	  	      		Reason:<br> -->
<!-- 	  	      		<textarea name="refuse_reason"></textarea> -->
<!-- 	  	      	</div> -->
<!-- 	  	      	<input type="submit" value="update"> -->
<!-- 	  	      	</form> -->
<!-- 	  	      	</td></tr> -->
	  	      <?php
// 	  	      }
	  	      ?>
	  	      <tr>
	  	      <td  class="infoBoxContent" style="padding:5px;">
	  	      <br>  <br>  
	  	      <form action="<?php echo zen_href_link(FILENAME_AVATAR_MANAGE);?>" method="post">
	  	      	<input type="hidden" name="update_id" value="<?php echo $id;?>">
	  	      	<input type="hidden" name="action" value="set_default">
	  	      	<input type="submit" value="Set as Default">
	  	      	</form>
	  	      	<br><br>
	  	      	</td>
	  	      </tr>
	  	  	</table>
	  	  </td>
	  	</tr>
	  </table>
	<?php
	  }
  	?>
  	</td>
  </tr>
</table>
<!-- body eof -->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>