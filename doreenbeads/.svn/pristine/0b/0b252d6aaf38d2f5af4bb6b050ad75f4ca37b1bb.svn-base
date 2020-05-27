<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  Original contrib by Vijay Immanuel for osCommerce, converted to zen by dave@open-operations.com - http://www.open-operations.com
//  $Id: links_manager.php 2006-12-22 Clyde Jones
//
  require('includes/application_top.php');

  $links_statuses = array();
  $links_status_array = array();
  $links_status = $db->Execute("select links_status_id, links_status_name from " . TABLE_LINKS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");
  while (!$links_status->EOF) {
    $links_statuses[] = array('id' => $links_status->fields['links_status_id'],
                               'text' => $links_status->fields['links_status_name']);
    $links_status_array[$links_status->fields['links_status_id']] = $links_status->fields['links_status_name'];
  $links_status->MoveNext();
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  $error = false;
  $processed = false;

  if (zen_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($_GET['flag'] == '1') || ($_GET['flag'] == '2') ) {
          zen_set_links_status($_GET['lID'], $_GET['flag']);
          $messageStack->add_session(SUCCESS_PAGE_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }
        zen_redirect(zen_href_link(FILENAME_LINKS, 'page=' . $_GET['page'] . '&amp;lID=' . $_GET['lID']));
        break;

      case 'insert':
      case 'update':
        $links_id = zen_db_prepare_input($_GET['lID']);
        $links_title = zen_db_prepare_input($_POST['links_title']);
        $links_url = zen_db_prepare_input($_POST['links_url']);
        $links_category = zen_db_prepare_input($_POST['links_category']);
        $links_description = zen_db_prepare_input($_POST['links_description']);
        $links_image_url = zen_db_prepare_input($_POST['links_image_url']);
        $links_contact_name = zen_db_prepare_input($_POST['links_contact_name']);
        $links_contact_email = zen_db_prepare_input($_POST['links_contact_email']);
        $links_reciprocal_url = zen_db_prepare_input($_POST['links_reciprocal_url']);
        $links_status = zen_db_prepare_input($_POST['links_status']);
        $links_rating = zen_db_prepare_input($_POST['links_rating']);

        if (strlen($links_title) < ENTRY_LINKS_TITLE_MIN_LENGTH) {
          $error = true;
          $entry_links_title_error = true;
        } else {
          $entry_links_title_error = false;
        }

        if (strlen($links_url) < ENTRY_LINKS_URL_MIN_LENGTH) {
          $error = true;
          $entry_links_url_error = true;
        } else {
          $entry_links_url_error = false;
        }

        if (strlen($links_description) < ENTRY_LINKS_DESCRIPTION_MIN_LENGTH) {
          $error = true;
          $entry_links_description_error = true;
        } else {
          $entry_links_description_error = false;
        }

        if (strlen($links_contact_name) < ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH) {
          $error = true;
          $entry_links_contact_name_error = true;
        } else {
          $entry_links_contact_name_error = false;
        }

        if (strlen($links_contact_email) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
          $error = true;
          $entry_links_contact_email_error = true;
        } else {
          $entry_links_contact_email_error = false;
        }

        if (!zen_validate_email($links_contact_email)) {
          $error = true;
          $entry_links_contact_email_check_error = true;
        } else {
          $entry_links_contact_email_check_error = false;
        }


 if (SUBMIT_LINK_REQUIRE_RECIPROCAL == 'true') { 
        if (strlen($links_reciprocal_url) < ENTRY_LINKS_URL_MIN_LENGTH) {
          $error = true;
          $entry_links_reciprocal_url_error = true;
        } else {
          $entry_links_reciprocal_url_error = false;
        }
}
        if ($error == false) {
          if (!zen_not_null($links_image_url) || ($links_image_url == 'http://')) {
            $links_image_url = '';
          }

          $sql_data_array = array('links_url' => $links_url,
                                  'links_image_url' => $links_image_url,
                                  'links_contact_name' => $links_contact_name,
                                  'links_contact_email' => $links_contact_email,
                                  'links_reciprocal_url' => $links_reciprocal_url, 
                                  'links_status' => $links_status, 
                                  'links_rating' => $links_rating);

          if ($action == 'update') {
            $sql_data_array['links_last_modified'] = 'now()';
          } else if($action == 'insert') {
            $sql_data_array['links_date_added'] = 'now()';
          }

          if ($action == 'update') {
            zen_db_perform(TABLE_LINKS, $sql_data_array, 'update', "links_id = '" . (int)$links_id . "'");
          } else if($action == 'insert') {
            zen_db_perform(TABLE_LINKS, $sql_data_array);

            $links_id = zen_db_insert_id();
          }

          $categories_query = "select link_categories_id from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_name = '" . $links_category . "' and language_id = '" . $_SESSION['languages_id'] . "'";

          $categories = $db->Execute($categories_query);
          $link_categories_id = $categories->fields['link_categories_id'];

          if ($action == 'update') {
            $db->Execute("update " . TABLE_LINKS_TO_LINK_CATEGORIES . " set link_categories_id = '" . (int)$link_categories_id . "' where links_id = '" . (int)$links_id . "'");
          } else if($action == 'insert') {
            $db->Execute("insert into " . TABLE_LINKS_TO_LINK_CATEGORIES . " ( links_id, link_categories_id) values ('" . (int)$links_id . "', '" . (int)$link_categories_id . "')");
          }

          $sql_data_array = array('links_title' => $links_title,
                                  'links_description' => $links_description);

          if ($action == 'update') {
            zen_db_perform(TABLE_LINKS_DESCRIPTION, $sql_data_array, 'update', "links_id = '" . (int)$links_id . "' and language_id = '" . $_SESSION['languages_id'] . "'");
          } else if($action == 'insert') {
            $insert_sql_data = array('links_id' => $links_id,
                                     'language_id' => $_SESSION['languages_id']);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            zen_db_perform(TABLE_LINKS_DESCRIPTION, $sql_data_array);
          }

          if (isset($_POST['links_notify']) && ($_POST['links_notify'] == 'on')) {
			$check_link_url = HTTP_SERVER . '/links-exchange-'. $links_category . '-l-' . $link_categories_id . '.html';
      		$check_link_url = str_replace(' ', '-', $check_link_url);
	  		$check_link_url = str_replace('"', '-', $check_link_url);
          	$email = sprintf(EMAIL_TEXT_STATUS_UPDATE, $links_contact_name, $links_status_array[$links_status]) . "\n\n" . STORE_OWNER . ' ' . STORE_OWNER_EMAIL_ADDRESS;

		  	$email_text = sprintf(EMAIL_GREET_NONE, $links_contact_name);
		  	$email_text .= '<br/><br/>' . EMAIL_TEXT.'<br/>';
		  	$email_text .='<br/><strong>'.ENTRY_LINKS_TITLE.'</strong>&nbsp;'.$links_title;
		  	$email_text .='<br/><strong>'.ENTRY_LINKS_URL.'</strong>&nbsp;'.$links_url;
		  	$email_text .='<br/><strong>'.ENTRY_LINKS_DESCRIPTION.'</strong>&nbsp;'.$links_description.'<br/>';
		  	$email_text .='<br/>'.EMAIL_TEXT_CHECK_URL.'<br/><a href="'.$check_link_url.'">'.$check_link_url.'</a><br/>';
		  	//$email_text .= sprintf(EMAIL_TEXT_NEW_STATUS, $links_status_array[$links_status]);		  
		  	$email_text .= '<br />' . EMAIL_TEXT_REPLY;
		  
          	$html_msg['EMAIL_MESSAGE_HTML'] =  str_replace('\n','',$email_text);
		  
          	zen_mail($links_contact_name, $links_contact_email, EMAIL_TEXT_SUBJECT, $email, STORE_NAME, STORE_OWNER_EMAIL_ADDRESS, $html_msg, 'link_exchange');
          }

          zen_redirect(zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $links_id));
        } else if ($error == true) {
          $lInfo = new objectInfo($_POST);
          $processed = true;
        }

        break;
      case 'deleteconfirm':
        $links_id = zen_db_prepare_input($_GET['lID']);

        zen_remove_link($links_id);

        $messageStack->add_session(SUCCESS_PAGE_REMOVED, 'success');		
		
        zen_redirect(zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action'))));
        break;
      default:
        $links_query = "select l.links_id, ld.links_title, l.links_url, ld.links_description, l.links_contact_email, l.links_status, l.links_image_url, l.links_contact_name, l.links_reciprocal_url, l.links_status, l.links_rating from " . TABLE_LINKS . " l left join " . TABLE_LINKS_DESCRIPTION . " ld on ld.links_id = l.links_id where ld.links_id = l.links_id and l.links_id = '" . (int)$_GET['lID'] . "' and ld.language_id = '" . $_SESSION['languages_id'] . "'";
        $links = $db->Execute($links_query);

        $categories_query = "select lcd.link_categories_name as links_category from " . TABLE_LINKS_TO_LINK_CATEGORIES . " l2lc left join " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd on lcd.link_categories_id = l2lc.link_categories_id where l2lc.links_id = '" . (int)$_GET['lID'] . "' and lcd.language_id = '" . $_SESSION['languages_id'] . "'";
        $category = $db->Execute($categories_query);

        $lInfo_array = array_merge((array)$links->fields, (array)$category->fields);
        $lInfo = new objectInfo($lInfo_array);
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
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
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
</script>
<?php
  if ($action == 'edit' || $action == 'update' || $action == 'new' || $action == 'insert') {
?>
<script language="javascript"><!--

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var links_title = document.links.links_title.value;
  var links_url = document.links.links_url.value;
  var links_category = document.links.links_category.value;
  var links_description = document.links.links_description.value;
  var links_image_url = document.links.links_image_url.value;
  var links_contact_name = document.links.links_contact_name.value;
  var links_contact_email = document.links.links_contact_email.value;
  var links_reciprocal_url = document.links.links_reciprocal_url.value;
  var links_rating = document.links.links_rating.value;

  if (links_title == "" || links_title.length < <?php echo ENTRY_LINKS_TITLE_MIN_LENGTH; ?>) {
    error_message = error_message + "* " + "<?php echo ENTRY_LINKS_TITLE_ERROR; ?>" + "\n";
    error = 1;
  }

  if (links_url == "" || links_url.length < <?php echo ENTRY_LINKS_URL_MIN_LENGTH; ?>) {
    error_message = error_message + "* " + "<?php echo ENTRY_LINKS_URL_ERROR; ?>" + "\n";
    error = 1;
  }

  if (links_description == "" || links_description.length < <?php echo ENTRY_LINKS_DESCRIPTION_MIN_LENGTH; ?>) {
    error_message = error_message + "* " + "<?php echo ENTRY_LINKS_DESCRIPTION_ERROR; ?>" + "\n";
    error = 1;
  }

  if (links_contact_name == "" || links_contact_name.length < <?php echo ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "* " + "<?php echo ENTRY_LINKS_CONTACT_NAME_ERROR; ?>" + "\n";
    error = 1;
  }

  if (links_contact_email == "" || links_contact_email.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo JS_EMAIL_ADDRESS; ?>";
    error = 1;
  }

<?php
if (SUBMIT_LINK_REQUIRE_RECIPROCAL == 'true') { ?>
  if (links_reciprocal_url == "" || links_reciprocal_url.length < <?php echo ENTRY_LINKS_URL_MIN_LENGTH; ?>) {
    error_message = error_message + "* " + "<?php echo ENTRY_LINKS_RECIPROCAL_URL_ERROR; ?>" + "\n";
    error = 1;
  }
<?php } ?>
  if (links_rating == "") {
    error_message = error_message + "* " + "<?php echo ENTRY_LINKS_RATING_ERROR; ?>" + "\n";
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
//--></script>
<?php
  }
?>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($action == 'edit' || $action == 'update' || $action == 'new' || $action == 'insert') {
    if ($action == 'edit' || $action == 'update') {
      $form_action = 'update';
      $contact_name_default = '';
      $contact_email_default = '';
    } else {
      $form_action = 'insert';
      $contact_name_default = STORE_OWNER;
      $contact_email_default = STORE_OWNER_EMAIL_ADDRESS;
    }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo zen_draw_form('links', FILENAME_LINKS, zen_get_all_get_params(array('action')) . 'action=' . $form_action, 'post', 'onSubmit="return check_form();"'); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_WEBSITE; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_TITLE; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_links_title_error == true) {
      echo zen_draw_input_field('links_title', $lInfo->links_title, 'maxlength="64"') . '&nbsp;' . ENTRY_LINKS_TITLE_ERROR;
    } else {
      echo $lInfo->links_title . zen_draw_hidden_field('links_title');
    }
  } else {
    echo zen_draw_input_field('links_title', $lInfo->links_title, 'maxlength="64"', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_URL; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_links_url_error == true) {
      echo zen_draw_input_field('links_url', $lInfo->links_url, 'maxlength="255"') . '&nbsp;' . ENTRY_LINKS_URL_ERROR;
    } else {
      echo $lInfo->links_url . zen_draw_hidden_field('links_url');
    }
  } else {
    echo zen_draw_input_field('links_url', zen_not_null($lInfo->links_url) ? $lInfo->links_url : 'http://', 'maxlength="255"', true);
  }
?></td>
          </tr>
<?php
    $categories_array = array();
    $categories_values = $db->Execute("select lcd.link_categories_id, lcd.link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd where language_id = '" . $_SESSION['languages_id'] . "' order by lcd.link_categories_name");
    while (!$categories_values->EOF) {
      $categories_array[] = array('id' => $categories_values->fields['link_categories_name'], 'text' => $categories_values->fields['link_categories_name']);
    $categories_values->MoveNext();
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_CATEGORY; ?></td>
            <td class="main">

<?php
  if ($error == true) {
    echo $lInfo->links_category . zen_draw_hidden_field('links_category');
  } else {
    echo zen_draw_pull_down_menu('links_category', $categories_array, $lInfo->links_category, '', true);
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_DESCRIPTION; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_links_description_error == true) {
      echo zen_draw_textarea_field('links_description', 'hard', 40, 5, $lInfo->links_description) . '&nbsp;' . ENTRY_LINKS_DESCRIPTION_ERROR;
    } else {
      echo $lInfo->links_description . zen_draw_hidden_field('links_description');
    }
  } else {
    echo zen_draw_textarea_field('links_description', 'hard', 40, 5, $lInfo->links_description) . TEXT_FIELD_REQUIRED;
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_IMAGE; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    echo $lInfo->links_image_url . zen_draw_hidden_field('links_image_url');
  } else {
    echo zen_draw_input_field('links_image_url', zen_not_null($lInfo->links_image_url) ? $lInfo->links_image_url : 'http://', 'maxlength="255"');
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_CONTACT_NAME; ?></td>
            <td class="main">
<?php
    if ($error == true) {
      if ($entry_links_contact_name_error == true) {
        echo zen_draw_input_field('links_contact_name', $lInfo->links_contact_name, 'maxlength="64"', true) . '&nbsp;' . ENTRY_LINKS_CONTACT_NAME_ERROR;
      } else {
        echo $lInfo->links_contact_name . zen_draw_hidden_field('links_contact_name');
      }
    } else {
      echo zen_draw_input_field('links_contact_name', zen_not_null($lInfo->links_contact_name) ? $lInfo->links_contact_name : $contact_name_default, 'maxlength="64"', true);
    }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_links_contact_email_error == true) {
      echo zen_draw_input_field('links_contact_email', $lInfo->links_contact_email, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR;
    } elseif ($entry_links_contact_email_check_error == true) {
      echo zen_draw_input_field('links_contact_email', $lInfo->links_contact_email, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
    } else {
      echo $lInfo->links_contact_email . zen_draw_hidden_field('links_contact_email');
    }
  } else {
    echo zen_draw_input_field('links_contact_email', zen_not_null($lInfo->links_contact_email) ? $lInfo->links_contact_email : $contact_email_default, 'maxlength="96"', true);
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

<?php if (SUBMIT_LINK_REQUIRE_RECIPROCAL == 'true') { ?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_RECIPROCAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_RECIPROCAL_URL; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_links_reciprocal_url_error == true) {
      echo zen_draw_input_field('links_reciprocal_url', $lInfo->links_reciprocal_url, 'maxlength="255"') . '&nbsp;' . ENTRY_LINKS_RECIPROCAL_URL_ERROR;
    } else {
      echo $lInfo->links_reciprocal_url . zen_draw_hidden_field('links_reciprocal_url');
    }
  } else {
    echo zen_draw_input_field('links_reciprocal_url', zen_not_null($lInfo->links_reciprocal_url) ? $lInfo->links_reciprocal_url : 'http://', 'maxlength="255"', true);
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php } ?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_STATUS; ?></td>
            <td class="main">
<?php 
  $link_statuses = array();
  $links_status_array = array();
  $links_status = $db->Execute("select links_status_id, links_status_name from " . TABLE_LINKS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");
  while (!$links_status->EOF) {
    $link_statuses[] = array('id' => $links_status->fields['links_status_id'],
                               'text' => $links_status->fields['links_status_name']);
    $links_status_array[$links_status->fields['links_status_id']] = $links_status->fields['links_status_name'];
    $links_status->MoveNext();
  }
	//jessa 2009-11-27 �޸�Ĭ�ϵ�ѡ��״̬
  echo zen_draw_pull_down_menu('links_status', $link_statuses, $lInfo->links_status); 
	//eof jessa 2009-11-27
  if ($action == 'edit' || $action == 'update') {
    echo '&nbsp;&nbsp;' . ENTRY_LINKS_NOTIFY_CONTACT;
    echo zen_draw_checkbox_field('links_notify');
  }
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LINKS_RATING; ?></td>
            <td class="main">
<?php
  if ($error == true) {
    if ($entry_links_rating_error == true) {
      echo zen_draw_input_field('links_rating', $lInfo->links_rating, 'size ="2" maxlength="2"') . '&nbsp;' . ENTRY_LINKS_RATING_ERROR;
    } else {
      echo $lInfo->links_rating . zen_draw_hidden_field('links_rating');
    }
  } else {
    echo zen_draw_input_field('links_rating', zen_not_null($lInfo->links_rating) ? $lInfo->links_rating : '0', 'size ="2" maxlength="2"', true);
  }
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo (($action == 'edit') ? zen_image_submit('button_update.gif', IMAGE_UPDATE) : zen_image_submit('button_insert.gif', IMAGE_INSERT)) . ' <a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('action'))) .'">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr></form>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo zen_draw_form('search', FILENAME_LINKS, '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . zen_draw_input_field('search'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TITLE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_URL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CLICKS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $search = '';
    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
      $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
      $search = " and ld.links_title like '%" . $keywords . "%'";
    }
    $links_query_raw = "select l.links_id, l.links_url, l.links_image_url, l.links_date_added, l.links_last_modified, l.links_status, l.links_clicked, ld.links_title, ld.links_description, l.links_contact_name, l.links_contact_email, l.links_reciprocal_url, l.links_status from " . TABLE_LINKS . " l left join " . TABLE_LINKS_DESCRIPTION . " ld on l.links_id = ld.links_id where ld.language_id = '" . $_SESSION['languages_id'] . "'" . $search . " order by l.links_date_added desc, ld.links_title, l.links_url";
    $links_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $links_query_raw, $links_query_numrows);
    $links = $db->Execute($links_query_raw);
      while (!$links->EOF) {
      if ((!isset($_GET['lID']) || (isset($_GET['lID']) && ($_GET['lID'] == $links->fields['links_id']))) && !isset($lInfo)) { 
        $categories_query = "select lcd.link_categories_name as links_category from " . TABLE_LINKS_TO_LINK_CATEGORIES . " l2lc left join " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd on lcd.link_categories_id = l2lc.link_categories_id where l2lc.links_id = '" . (int)$links->fields['links_id'] . "' and lcd.language_id = '" . $_SESSION['languages_id'] . "'";
        $category = $db->Execute($categories_query);

        $lInfo_array = array_merge((array)$links->fields, (array)$category->fields);
        $lInfo = new objectInfo($lInfo_array);
      }

      if (isset($lInfo) && is_object($lInfo) && ($links->fields['links_id'] == $lInfo->links_id)) {
        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID')) . 'lID=' . $links->fields['links_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $links->fields['links_title']; ?></td>
                <td class="dataTableContent"><?php echo $links->fields['links_url']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $links->fields['links_clicked']; ?></td>
                <td class="dataTableContent" align="center"><?php 
				if ($links->fields['links_status'] == '2') {
        echo zen_image(DIR_WS_IMAGES . 'icon_status_green.gif', 'Approved', 10, 10) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_LINKS, 'page=' . $_GET['page'] . '&amp;lID=' . $links->fields['links_id'] . '&amp;action=setflag&amp;flag=1') . '">' . zen_image(DIR_WS_IMAGES . 'icon_status_yellow_light.gif', 'Set Pending', 10, 10) . '</a>';
      } else {
        echo '<a href="' . zen_href_link(FILENAME_LINKS, 'page=' . $_GET['page'] . '&amp;lID=' . $links->fields['links_id'] . '&amp;action=setflag&amp;flag=2') . '">' . zen_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', 'Set Approved', 10, 10) . '</a>&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_yellow.gif', 'Pending', 10, 10);
}
	  ?>							
</td>
                <td class="dataTableContent" align="right"><?php if (isset($lInfo) && is_object($lInfo) && ($links->fields['links_id'] == $lInfo->links_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID')) . 'lID=' . $links->fields['links_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
 $links->MoveNext();

    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $links_split->display_count($links_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_LINKS); ?></td>
                    <td class="smallText" align="right"><?php echo $links_split->display_links($links_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'lID'))); ?></td>
                  </tr>
                  <tr>
<?php
    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
?>
                    <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_LINKS) . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
                    <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_LINKS, 'page=' . $_GET['page'] . '&action=new') . '">' . zen_image_button('button_new_link.gif', IMAGE_NEW_LINK) . '</a>'; ?></td>
<?php
    } else {
?>
                    <td align="right" colspan="2"><?php echo '<a href="' . zen_href_link(FILENAME_LINKS, 'page=' . $_GET['page'] . '&action=new') . '">' . zen_image_button('button_new_link.gif', IMAGE_NEW_LINK) . '</a>'; ?></td>
<?php
    }
?>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'confirm':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_LINK . '</b>');

      $contents = array('form' => zen_draw_form('links', FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO . '<br><br><b>' . $lInfo->links_url . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'check':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_CHECK_LINK . '</b>');

      $url = $lInfo->links_reciprocal_url;

      if (file($url)) {
        $file = fopen($url,'r');

        $link_check_status = false;

        while (!feof($file)) {
          $page_line = trim(fgets($file, 4096));

          if (eregi(LINKS_CHECK_PHRASE, $page_line)) {
            $link_check_status = true;
            break;
          }
        }

        fclose($file);

        if ($link_check_status == true) {
          $link_check_status_text = TEXT_INFO_LINK_CHECK_FOUND;
        } else {
          $link_check_status_text = TEXT_INFO_LINK_CHECK_NOT_FOUND;
        }
      } else {
        $link_check_status_text = TEXT_INFO_LINK_CHECK_ERROR;
      }

      $contents[] = array('text' => TEXT_INFO_LINK_CHECK_RESULT . ' ' . $link_check_status_text);
      $contents[] = array('text' => '<br><b>' . $lInfo->links_reciprocal_url . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br><a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($lInfo) && is_object($lInfo)) {
        $heading[] = array('text' => '<b>' . $lInfo->links_title . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id . '&action=confirm') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . zen_href_link(FILENAME_LINKS, zen_get_all_get_params(array('lID', 'action')) . 'lID=' . $lInfo->links_id . '&action=check') . '">' . zen_image_button('button_check_link.gif', IMAGE_CHECK_LINK) . '</a> <a href="' . zen_href_link(FILENAME_LINKS_CONTACT, 'link_partner=' . $lInfo->links_contact_email) . '">' . zen_image_button('button_email.gif', IMAGE_EMAIL) . '</a>');

        $contents[] = array('text' => '<br>' . TEXT_INFO_LINK_STATUS . ' '  . $links_status_array[$lInfo->links_status]);
        $contents[] = array('text' => '<br>' . TEXT_INFO_LINK_CATEGORY . ' '  . $lInfo->links_category);
        $contents[] = array('text' => '<br>' . zen_link_info_image($lInfo->links_image_url, $lInfo->links_title, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '<br>' . $lInfo->links_title);
        $contents[] = array('text' => '<br>' . TEXT_INFO_LINK_CONTACT_NAME . ' '  . $lInfo->links_contact_name);
        $contents[] = array('text' => '<br>' . TEXT_INFO_LINK_CONTACT_EMAIL . ' ' . $lInfo->links_contact_email);
        $contents[] = array('text' => '<br>' . TEXT_INFO_LINK_CLICK_COUNT . ' ' . $lInfo->links_clicked);
        $contents[] = array('text' => '<br>' . TEXT_INFO_LINK_DESCRIPTION . ' ' . $lInfo->links_description);
        $contents[] = array('text' => '<br>' . TEXT_DATE_LINK_CREATED . ' ' . zen_date_short($lInfo->links_date_added));

        if (zen_not_null($lInfo->links_last_modified)) {
          $contents[] = array('text' => '<br>' . TEXT_DATE_LINK_LAST_MODIFIED . ' ' . zen_date_short($lInfo->links_last_modified));
        }
      }
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>