<?php
/**
 * feedback_manage.php
 * feedback����
 */

  ob_start();
  require('includes/application_top.php');
  $action = ((isset($_GET['action']) && zen_not_null($_GET['action'])) ? $_GET['action'] : '');
  
  switch ($action){
  	case 'read':
	  	$feedback_id = $_GET['id'];
	  	$feedback_detail_query = "Select feedback_id, feedback_main_type, feedback_detail_type, feedback_comment, feedback_attach,
	  									 customer_id, customer_name, customer_email, feedback_date_added
	  							    From " . TABLE_CUSTOMER_FEEDBACK . "
	  							   Where feedback_id = " . (int)$feedback_id;
	  	$feedback_detail = $db->Execute($feedback_detail_query);
	  	$feedback_detail_array = array();
	  	
	  	if ($feedback_detail->fields['customer_id'] != '0'){
	  		$customer_info = zen_get_customer_info($feedback_detail->fields['customer_id']);
	  		$customer_name = $customer_info['name'];
	  		$customer_email = $customer_info['email'];
	  	} else {
	  		$customer_name = $feedback_detail->fields['customer_name'];
	  		$customer_email = $feedback_detail->fields['customer_email'];
	  	}
	  	
	  	$feedback_detail_array = array('id' => $feedback_detail->fields['feedback_id'],
	  								   'main_type' => $feedback_detail->fields['feedback_main_type'],
	  								   'detail_type' => $feedback_detail->fields['feedback_detail_type'],
	  								   'comment' => zen_db_output($feedback_detail->fields['feedback_comment']),
	  								   'attach' => $feedback_detail->fields['feedback_attach'],
	  								   'customer_name' => $customer_name,
	  								   'customer_email' => $customer_email,
	  								   'date_added' => $feedback_detail->fields['feedback_date_added']);
	break;
  	case 'download':
  		$feedback_extra_file_query = "select feedback_attach from " . TABLE_CUSTOMER_FEEDBACK . " where feedback_id = " . (int)$_GET['id'];
  		$feedback_extra_file = $db->Execute($feedback_extra_file_query);
  		$attach_file = $feedback_extra_file->fields['feedback_attach'];
  		
  		$attach_file_array = explode(',', $attach_file);
  		$pic_extension = array('.jpg', '.png', '.gif', '.bmp', '.JPG', '.PNG', '.GIF', '.BMP');
  		$extra_file_array = array();
  		for ($i = 0; $i < sizeof($attach_file_array); $i++){
  			if (!in_array(substr($attach_file_array[$i], strrpos($attach_file_array[$i], '.')), $pic_extension)){
  				$extra_file_array[] = $attach_file_array[$i];
  			}
  		}
  		echo $extra_file_array[0];
  		zen_download_order_pic($_GET['id'], $extra_file_array);
  	break; 
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
<?php
  if ( ($action == 'new') || ($action == 'edit') ) {
?>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<?php
  }
?>
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
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>


<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
            <?php if ($action == 'read'){ ?>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr class="dataTableHeadingRow">
                  <td class="dataTableHeadingContent" style="padding:5px;"><?php echo '#' . $feedback_detail_array['id'] . '&nbsp;&nbsp;&nbsp;&nbsp;' . $feedback_detail_array['main_type'] . (zen_not_null($feedback_detail_array['detail_type']) ? '>>' . $feedback_detail_array['detail_type'] : ''); ?>
                </tr>
                <tr class="dataTableRow">
                  <td class="dataTableContent" style="padding:5px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td height="30" width="150"><b>Main Tpye:</b> </td>
                        <td><?php echo $feedback_detail_array['main_type']; ?></td>
                      </tr>
                      <?php if (zen_not_null($feedback_detail_array['detail_type'])){ ?>
                      <tr>
                        <td height="30" width="150"><b>Detail Tpye:</b> </td>
                        <td><?php echo $feedback_detail_array['detail_type']; ?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td height="30" width="150"><b>Customer Name: </b> </td>
                        <td><?php echo $feedback_detail_array['customer_name']; ?></td>
                      </tr>
                      <tr>
                        <td height="30" width="150"><b>Customer Email: </b> </td>
                        <td><?php echo ($_SESSION['show_customer_email'] ? $feedback_detail_array['customer_email'] : strstr($feedback_detail_array['customer_email'], '@', true) . '@'); ?></td>
                      </tr>
                      <tr>
                        <td height="30" width="150"><b>Date Added: </b> </td>
                        <td><?php echo $feedback_detail_array['date_added']; ?></td>
                      </tr>
                      <tr>
                        <td valign="top" width="150" style="padding-top:5px;"><b>Comment: </b> </td>
                        <td valign="top" style="padding-top:5px;line-height:150%;"><?php echo $feedback_detail_array['comment']; ?></td>
                      </tr>
                      <?php if (zen_not_null($feedback_detail_array['attach'])){ ?>
                      <tr>
                        <td valign="top" width="150" style="padding-top:5px;"><b>Attach: </b> </td>
                        <td valign="top" style="padding-top:5px;line-height:150%;">
                          <?php
                          	$attach_file_array = explode(',', $feedback_detail_array['attach']);
                          	
                          	$attach_pic_array = array();
                          	$extra_attach_file = array();
                          	$pic_extension = array('.jpg', '.png', '.gif', '.bmp', '.JPG', '.PNG', '.GIF', '.BMP');
                          	for ($i = 0; $i < sizeof($attach_file_array); $i++){
                          		if (in_array(substr($attach_file_array[$i], strrpos($attach_file_array[$i], '.')), $pic_extension)){
                          			$attach_pic_array[] = $attach_file_array[$i];
                          		} else {
                          			$extra_attach_file[] = $attach_file_array[$i];
                          		}
                          	}
                          ?>
                          <table border="0" width="100%" cellpadding="0" cellspacing="0">
                            <?php 
                            	if (sizeof($attach_pic_array) > 0){ 
                            		for ($j = 0; $j < sizeof($attach_pic_array); $j++){
                            ?>
                            <tr>
                              <td style="padding:6px;"><img src="../<?php echo $attach_pic_array[$j]; ?>"></td>
                            </tr>
                            <?php 
                            		}
                            	}
                            ?>
                            
                          </table>
                        </td>
                      </tr>
                      <?php
                    	if (sizeof($extra_attach_file) > 0){
                      ?>
                      <tr>
                        <td width="150" style="padding-top:5px;">Extra Attach File:</td>
                        <td style="padding-top:5px;"><?php echo 'There Are <b>' . sizeof($extra_attach_file) . '</b> Extra File(s) <a href="' . zen_href_link(FILENAME_FEEDBACK_MANAGE, 'action=download&id=' . $_GET['id']) . '">download</a>';?>
                      </tr>
                      <?php
                    		//zen_download_order_pic($_GET['id'], $extra_attach_file);
                    	}
                      ?>
                      <?php } ?>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding:5px 0px;"><?php echo '<a href="' . zen_href_link(FILENAME_FEEDBACK_MANAGE) . '">' . zen_image_button('button_back.gif') . '</a>'; ?></td>
                </tr>
              </table>
            <?php } else { ?>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr class="dataTableHeadingRow">
              	  <td class="dataTableHeadingContent" width="15%" style="padding:5px;">Main Type</td>
              	  <td class="dataTableHeadingContent" width="25%">Sub Type</td>
              	  <td class="dataTableHeadingContent" width="13%">Customer Name</td>
              	  <td class="dataTableHeadingContent" width="18%">Customer Email</td>
              	  <td class="dataTableHeadingContent" width="14%" align="center">Have Attach File</td>
              	  <td class="dataTableHeadingContent" width="13%" align="center">Read</td>
              	</tr>
                <?php
              		$feedback_query = "Select feedback_id, feedback_main_type, feedback_detail_type, feedback_comment,
              								  feedback_attach, customer_id, customer_name, customer_email, feedback_date_added
              							 From " . TABLE_CUSTOMER_FEEDBACK . "
              						 Order By feedback_date_added Desc";
              		$feedback_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $feedback_query, $feedback_query_numrows);
              		$feedback = $db->Execute($feedback_query);
              		
              		$feedback_cnt = 0;
              		while (!$feedback->EOF){
              			if ($feedback_cnt % 2 == 0){
              				$row_class = 'dataTableRowSelected';
              			} else {
              				$row_class = 'dataTableRow';
              			}
              			
              			if ($feedback->fields['customer_id'] != '0'){
              				$customer_info = zen_get_customer_info($feedback->fields['customer_id']);
              				$customer_name = $customer_info['name'];
              				$customer_email = $customer_info['email'];
              			} else {
              				$customer_name = $feedback->fields['customer_name'];
              				$customer_email = $feedback->fields['customer_email'];
              			}
              	?>
              	<tr class="<?php echo $row_class; ?>">
              	  <td class="dataTableContent" style="padding:5px;"><b><?php echo $feedback->fields['feedback_main_type']; ?></b></td>
              	  <td class="dataTableContent"><?php echo $feedback->fields['feedback_detail_type']; ?></td>
              	  <td class="dataTableContent"><?php echo $customer_name; ?></td>
              	  <td class="dataTableContent"><?php echo ($_SESSION['show_customer_email'] ? $customer_email : strstr($customer_email, '@', true) . '@'); ?></td>
              	  <td class="dataTableContent" align="center"><?php echo (zen_not_null($feedback->fields['feedback_attach']) ? 'Yes' : 'No'); ?></td>
              	  <td class="dataTableContent" align="center" style="padding:3px;"><?php echo '<a href="' . zen_href_link(FILENAME_FEEDBACK_MANAGE, 'action=read&id=' . $feedback->fields['feedback_id']) . '">' . zen_image_button('button_read.gif', 'read') . '</a>'; ?></td>
              	</tr>
              	<?php	
              			$feedback_cnt++;
              			$feedback->MoveNext();
              		}
                ?>
              </table>
            <?php } ?>
            </td>
          </tr>
          <?php if ($action != 'read'){ ?>
		  <tr>
		  	<td>
		  	  <table border="0" width="100%" cellpadding="0" cellspacing="0">
		  	    <tr>
		  	      <td style="padding:5px 0px;width:50%"><?php echo $feedback_split->display_count($feedback_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES); ?></td>
		  	      <td style="padding:5px 0px;width:50%;text-align:right;"><?php echo $feedback_split->display_links($feedback_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
		  	    </tr>
		  	  </table>
		  	</td>
		  </tr>
		  <?php } ?>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<?php
  function zen_download_order_pic($id, $file_array){
  	global $db;
  	
  	$download_pic_dir = '../feedback_file/';
  	
	$zip_file_name = 'Feedback-Attach-File[#' . $id . '].zip';
	$new_folder_name = $download_pic_dir . $id;
  	
  	mkdir($new_folder_name, 0777);
  	$new_folder_dir = $new_folder_name;
	
  	$zip_file_array = array();
  	for ($i = 0; $i < sizeof($file_array); $i++){  		
		$download_pic_name = substr($file_array[$i], (strrpos($file_array[$i], '/') + 1));
		if (file_exists($download_pic_dir . $download_pic_name)){
			copy($download_pic_dir . $download_pic_name, $new_folder_dir . '/' . $download_pic_name);
			$zip_file_array[] = $new_folder_dir . '/' . $download_pic_name;
		}
  	}
  	
  	if (sizeof($zip_file_array) > 0){
  		zen_create_zip($zip_file_array, $new_folder_dir . '/' . $zip_file_name, true);
  		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
  			header('Content-type: application/octetstream');
  			header('Content-Disposition: attachment; filename=' . $zip_file_name);
  		} else {
  			header('Content-Type: application/x-octet-stream');
			header('Content-Disposition: attachment; filename=' . $zip_file_name);
  		}
  		
  		readfile($new_folder_dir . '/' . $zip_file_name);
  		unlink($new_folder_dir . '/' . $zip_file_name);
  	}
  	
  	zen_delete_file($new_folder_dir . '/');
  	rmdir($new_folder_dir);
  }
  
  function zen_delete_file($dir){
  	if ($delete_dir = @dir($dir)){
  		while ($delete_file = $delete_dir->read()){
  			if (substr($delete_file, -1) != '.') unlink($dir . $delete_file);
  		}
  		
  		$delete_dir->close();
  	}
  }
?>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>