<?php

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  if (zen_not_null($action)) {
  		switch($action){
  			case 'set_status':
  				if(isset($_GET['status'])&&$_GET['status']!=''){
  					$upate_sql='update '.TABLE_PROMOTION_COUNTDOWN.' set show_promotion_status="'.$_GET['status'].'" where languages_id="'.$_SESSION['languages_id'].'" ';
  					$db->Execute($upate_sql);
  				}
  				zen_redirect(zen_href_link('countdown_setting'));
  				break;
  		}
  }

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
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript">
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "products_date_available","btnDate1","<?php echo $pInfo->products_date_available; ?>",scBTNMODE_CUSTOMBLUE);
</script>
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
<?php if ($_GET['action'] == 'new') { ?>
    if (typeof _editor_url == "string") HTMLArea.replaceAll();
<?php } else { ?>
    if (typeof _editor_url == "string") HTMLArea.replace('message_html');
<?php } ?>
  }
  // -->
</script>
<script language="javascript" type="text/javascript"><!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_select(field_name, field_default, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == field_default) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}
function check_message(msg) {
  if (form.elements['message'] && form.elements['message_html']) {
    var field_value1 = form.elements['message'].value;
    var field_value2 = form.elements['message_html'].value;

    if ((field_value1 == '' || field_value1.length < 3) && (field_value2 == '' || field_value2.length < 3)) {
      error_message = error_message + "* " + msg + "\n";
      error = true;
    }
  }
}
function check_input(field_name, field_size, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == '' || field_value.length < field_size) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_form(form_name) {
  if (submitted == true) {
    alert("<?php echo JS_ERROR_SUBMITTED; ?>");
    return false;
  }
  error = false;
  form = form_name;
  error_message = "<?php echo JS_ERROR; ?>";

  check_select('customers_email_address', '', "<?php echo ERROR_NO_CUSTOMER_SELECTED; ?>");
  check_message("<?php echo ENTRY_NOTHING_TO_SEND; ?>");
  check_input('subject','',"<?php echo ERROR_NO_SUBJECT; ?>");

  if (error == true) {
    alert(error_message);
    return false;
  } else {
    submitted = true;
    return true;
  }
}
//--></script>
<?php if ($editor_handler != '') include ($editor_handler); ?>
</head>
<body onLoad="init()">
<div id="spiffycalendar" class="text"></div>

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>

<?php 
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $language_id = $languages[$i]['id'];
    if(isset($_POST['countdown_desc'][$language_id])){
       // $db->Execute("update " . TABLE_CONFIGURATION . "
        //             set configuration_value = '" . zen_db_input(stripslashes($_POST['countdown_desc'][$language_id])) . "',
       //              last_modified = now() where configuration_key = 'PROMOTION_COUNTDOWN_INFORMATION_".$language_id . "'");
    	$desc_new[$language_id]=stripslashes($_POST['countdown_desc'][$language_id]);
    }
}



if(isset($_POST['countdown_desc'])){
	$countdown_info_query= " select * from ".TABLE_PROMOTION_COUNTDOWN." where languages_id=".$_SESSION['languages_id']." ";
$countdown_info= $db->Execute($countdown_info_query); 
if(isset($_POST['countdown_startdate_day']) && isset($_POST['countdown_startdate_month']) && isset($_POST['countdown_startdate_year']))
{
	$start_date=date('Y-m-d H:i:s', mktime($_POST['countdown_startdate_hour'], 0, 0, $_POST['countdown_startdate_month'],$_POST['countdown_startdate_day'] ,$_POST['countdown_startdate_year'] ));
}

if(isset($_POST['countdown_finishdate_day']) && isset($_POST['countdown_finishdate_month']) && isset($_POST['countdown_finishdate_year']))
{
	$finish_date=date('Y-m-d H:i:s', mktime($_POST['countdown_finishdate_hour'], 0, 0, $_POST['countdown_finishdate_month'],$_POST['countdown_finishdate_day'] ,$_POST['countdown_finishdate_year'] ));

}

	if($countdown_info->RecordCount()>0){

		$db->Execute("update " . TABLE_PROMOTION_COUNTDOWN . "
                     set countdown_content = '" . zen_db_input($_POST['countdown_desc']) . "',
                     countdown_startdate_month = '" . zen_db_input($start_date) . "',
                     countdown_finishdate_month = '" . zen_db_input($finish_date) . "',
                      countdown_status 	=   '".$_POST['countdown_status']."',
					  show_in_homepage =  '".$_POST['show_in_homepage']."' 
                      where languages_id = ".$_SESSION['languages_id']."  ");
	}else{		
		$sql_data_array = array(
			 'languages_id' 			 => $_SESSION['languages_id'],
			 'countdown_startdate_month' => $start_date,
			 'countdown_finishdate_month'=> $finish_date,
			 'countdown_status'			 => $_POST['countdown_status'],
			 'countdown_content'		 => $_POST['countdown_desc'],
			 'show_promotion_status'	 => '0',
			 'show_in_homepage'			 => $_POST['show_in_homepage']
		);
		zen_db_perform(TABLE_PROMOTION_COUNTDOWN, $sql_data_array);

	}	  		
}
$countdown_info_query= " select * from ".TABLE_PROMOTION_COUNTDOWN." where languages_id=".$_SESSION['languages_id']." ";
$countdown_info= $db->Execute($countdown_info_query);
?>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo 'Promotion Countdown'; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <td>
 
<?php

   echo zen_draw_form('countdown', 'countdown_setting.php');
?>
      <table border="0" width="80%" cellspacing="0" cellpadding="6">

	   <tr>
	   <td colspan=2>
	   <?php echo  zen_image(DIR_WS_CATALOG_LANGUAGES . $_SESSION['language'] . '/images/' . 'icon.gif'); ?>
	   </td>
	   </tr>
	   <tr>
        <td align="left" width="18%" valign="top" class="main">Count Down Description</td>
        <td align="left" valign="top">
        <?php 

        if ($_SESSION['html_editor_preference_status']=="FCKEDITOR") {
                $oFCKeditor = new FCKeditor('countdown_desc') ;
                //$oFCKeditor->Value = stripslashes(zen_get_configuration_key_value('PROMOTION_COUNTDOWN_INFORMATION_'.$language_id));
                $oFCKeditor->Value = stripslashes($countdown_info->fields['countdown_content']);
                $oFCKeditor->Width  = '120%' ;
                $oFCKeditor->Height = '250' ;
//                $oFCKeditor->Config['ToolbarLocation'] = 'Out:xToolbar' ;
//                $oFCKeditor->Create() ;
                $output = $oFCKeditor->CreateHtml() ; echo $output;
			} else { // using HTMLAREA or just raw "source"
				echo zen_draw_textarea_field('countdown_desc','physical','24','8', stripslashes($countdown_info->fields['countdown_content']));
          	}
        ?>
        </td>
       </tr>
        

      
<?php
    if (!$countdown_info->fields['countdown_startdate_month']) {
      $countdown_startdate = getdate();
    } else {
	  $ntime=strtotime($countdown_info->fields['countdown_startdate_month']);
	  $countdown_startdate=getdate($ntime);
    }
    if (!$countdown_info->fields['countdown_finishdate_month']) {
      $countdown_finishdate = getdate();
    } else {
	  $nbtime=strtotime($countdown_info->fields['countdown_finishdate_month']);
      $countdown_finishdate=getdate($nbtime);
    }
?>
        <td align="left" class="main"><?php echo 'Start Date'; ?></td>
        <td align="left"><?php echo zen_draw_date_selector('countdown_startdate', mktime($countdown_startdate['hours'],0,0, $countdown_startdate['mon'], $countdown_startdate['mday'], $countdown_startdate['year'], 0)); ?></td>
        
      </tr>
      <tr>
        <td align="left" class="main"><?php echo 'End Date'; ?></td>
        <td align="left"><?php echo zen_draw_date_selector('countdown_finishdate', mktime($countdown_finishdate['hours'],0,0, $countdown_finishdate['mon'], $countdown_finishdate['mday'], $countdown_finishdate['year'], 0)); ?></td>
        
      </tr>
      <tr>
        <td align="left" class="main"><?php echo 'Status'; ?></td>
        <td align="left" class="main">
        	<input name="countdown_status" type="radio" value="1" <?php if($countdown_info->fields['countdown_status']==1) echo 'CHECKED';?>>On<br/>
        	<input name="countdown_status" type="radio" value="0" <?php if($countdown_info->fields['countdown_status']==0) echo 'CHECKED';?>>Off
        </td>
      
      </tr>
      <tr>
        <td align="left" class="main">Show in homepage</td>
        <td align="left" class="main">
        	<input name="show_in_homepage" type="radio" value="1" <?php if($countdown_info->fields['show_in_homepage']==1) echo 'CHECKED';?>>Yes<br/>
        	<input name="show_in_homepage" type="radio" value="0" <?php if($countdown_info->fields['show_in_homepage']==0) echo 'CHECKED';?>>No
        </td>
      
      </tr>
      <tr>
        <td align="left"><?php echo zen_image_submit('button_confirm.gif',"Confirm"); ?></td>
        <td align="left"><?php echo '&nbsp;&nbsp;<a href="' . zen_href_link("countdown_setting.php"); ?>"><?php echo zen_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a></td>       
       
      </tr>
      </table></form>
      </tr>

      </table></td>

  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
