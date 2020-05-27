<?php
/**
 * Links Submit Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_page_3_default.php 3254 2006-03-25 17:34:04Z ajeh $
 */
?>

<div class="centerColumn" id="ezPageDefault">
<?php 
if(isset($_GET['lPath'])) {
      $static_submit_process=HTTP_SERVER . DIR_WS_CATALOG .'links-exchange-submit-your-site-ls-'.$_GET['lPath'].'-la-process.html';
}
else{
      $static_submit_process=HTTP_SERVER . DIR_WS_CATALOG .'links-exchange-submit-your-site-la-process.html';
}
echo zen_draw_form('submit_link', $static_submit_process, 'post', 'onSubmit="return check_error(submit_link);"') . zen_draw_hidden_field('action', 'process');
?>

<?php if (CONTACT_US_STORE_NAME_ADDRESS== '1' And 1 == 0) {   ////wqz?>
<address><?php echo nl2br(STORE_NAME_ADDRESS); ?></address>
<?php } ?>

<?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
  	$define_success_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_LINKS_SUCCESS, 'false');
 ?>
<div id="link_submit_page">
<br class="clearBoth" />
<div class="mainContent success">
<?php require($define_success_page); ?></div>
<br class="clearBoth" />
</div>
<div class="buttonRow back">
<?php 
   $static_back_links=(isset($_GET['lPath'])) ? $static_url : 'links-exchange-jewelry-directory.html';
   echo "<a href='".$static_back_links."'>".zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; 
?>
</div>   
<br class="clearBoth" />

<?php
  } else {
?>

<?php if (DEFINE_LINKS_STATUS >= '1' and DEFINE_LINKS_STATUS <= '2') { ?>
<div id="pageThreeMainContent">
<?php
require($define_page);
?>
</div>
<?php } ?>

<?php if ($messageStack->size('submit_link') > 0) echo $messageStack->output('submit_link'); ?>
<br class="clearBoth" />
<div class="alert forward"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
<br class="clearBoth" />
<div id="link_submit_page">
<table width="100%">

<tr>
<td width="18%"><label for="links_title"><?php echo ENTRY_LINKS_TITLE; ?></label></td>
<td>
<input type="text" id="links_title" name="links_title" onChange='check_text("links_title","title_error",<?php echo ENTRY_LINKS_TITLE_MIN_LENGTH.",".ENTRY_LINKS_TITLE_MAX_LENGTH; ?>);'/>
<span class="alert" id="title_error">*</span>
</td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
<td id="links_title_message">&nbsp;&nbsp;<?php echo LINKS_TITLE_TIPS; ?></td>
</tr>
<tr style="font-size:3px;">
<td>&nbsp;</td>
</tr>

<tr>
<td><label for="links_url"><?php echo ENTRY_LINKS_URL; ?></label></td>
<td>
<input type="text" id="links_url" name="links_url" value="http://" onChange='check_url("links_url","url_error",<?php echo ENTRY_LINKS_URL_MIN_LENGTH.",".'0'; ?>);'/>
<span class="alert" id="url_error">*</span>
</td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
<td id="links_url_message">&nbsp;&nbsp;<?php echo LINKS_URL_TIPS; ?></td>
</tr>
<tr style="font-size:5px;">
<td>&nbsp;</td>
</tr>
<?php
  //link category drop-down list
  $categories_array = array();
  $categories_values = $db->Execute("select lcd.link_categories_id, lcd.link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd, " . TABLE_LINK_CATEGORIES . " lc where lc.link_categories_id=lcd.link_categories_id and lc.link_categories_status=1 and lcd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by lc.link_categories_sort_order");
 while (!$categories_values->EOF) {
    $categories_array[] = array('id' => $categories_values->fields['link_categories_name'], 'text' => $categories_values->fields['link_categories_name']);
	$categories_values->MoveNext();
  }
  if (isset($_GET['lPath'])) {
    $current_categories_id = $_GET['lPath'];
    $categories = $db->Execute("select link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_id ='" . (int)$current_categories_id . "' and language_id ='" . (int)$_SESSION['languages_id'] . "'");
    $default_category = $categories->fields['link_categories_name'];
    } else {
      $default_category = '';
    }
?>
<tr>
<td><label for="links_category"><?php echo ENTRY_LINKS_CATEGORY; ?></label></td>
<td>&nbsp;&nbsp;<?php echo zen_draw_pull_down_menu('links_category', $categories_array, $default_category) . '&nbsp;' . (zen_not_null(ENTRY_LINKS_CATEGORY_TEXT) ? '<span class="alert">' . ENTRY_LINKS_CATEGORY_TEXT . '</span>': '');?></td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
</tr>

<tr>
<td><label for="links_description"><?php echo ENTRY_LINKS_DESCRIPTION; ?></label></td>
<td>&nbsp;&nbsp;<?php echo (zen_not_null(ENTRY_LINKS_DESCRIPTION_TEXT) ? '<span class="alert" id="description_error">' . ENTRY_LINKS_DESCRIPTION_TEXT . '</span>': ''); ?></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<textarea cols="40" rows="6" id="links_description" name="links_description" onChange='check_text("links_description","description_error",<?php echo ENTRY_LINKS_DESCRIPTION_MIN_LENGTH.",".ENTRY_LINKS_DESCRIPTION_MAX_LENGTH; ?>);'></textarea>
</td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
<td id="links_description_message">&nbsp;&nbsp;<?php echo LINKS_DESCRIPTION_TIPS;?></td>
</tr>
<tr style="font-size:3px;">
<td>&nbsp;</td>
</tr>
<tr>
<td><label for="links_contact_email"><?php echo ENTRY_EMAIL_ADDRESS; ?></label></td>
<td>
<input type="text" id="links_contact_email" name="links_contact_email" value="<?php echo $email ?>" onChange='check_email("links_contact_email","contact_email_error");'/>
<span class="alert" id="contact_email_error">*</span>
</td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
<td id="links_contact_email_message">&nbsp;&nbsp;<?php echo LINKS_EMAIL_TIPS;?></td>
</tr>
<tr style="font-size:3px;">
<td>&nbsp;</td>
</tr>

<tr>
<td><label for="links_contact_name"><?php echo ENTRY_LINKS_CONTACT_NAME; ?></label></td>
<td>
<input type="text" id="links_contact_name" name="links_contact_name" value="<?php echo $name ?>" onChange='check_text("links_contact_name","contact_name_error",<?php echo ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH.",".'0'; ?>);'/>
<span class="alert" id="contact_name_error">*</span>
</td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
<td id="links_contact_name_message">&nbsp;&nbsp;<?php echo LINKS_NAME_TIPS; ?><br/>&nbsp;</td>
</tr>

<?php if (SUBMIT_LINK_REQUIRE_RECIPROCAL == 'true') { ?>
<tr>
<td><label for="links_reciprocal_url"><?php echo ENTRY_LINKS_RECIPROCAL_URL; ?></label></td>
<td>
<input type="text" id="links_reciprocal_url" name="links_reciprocal_url" value="http://" onChange='check_url("links_reciprocal_url","reciprocal_url_error",<?php echo ENTRY_LINKS_URL_MIN_LENGTH.",".'0'; ?>);'/>
<span class="alert" id="reciprocal_url_error">*</span>
</td>
</tr>
<tr class="link_tips">
<td>&nbsp;</td>
<td id="links_reciprocal_url_message">&nbsp;&nbsp;<?php echo LINKS_RECIPROCAL_TIPS; ?><br/>&nbsp;</td>
</tr>

<?php
  }
?>

</table>

</div>
<div class="buttonRow forward">
<?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT) ;?>
</div>

<div class="buttonRow back">
<?php  
     $static_back_links=(isset($_GET['lPath'])) ? $static_url : 'links-exchange-jewelry-directory.html';
     echo "<a href='".$static_back_links."'>".zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; 
?>
     </div>   
     <br class="clearBoth" />
<?php
  }
?>
</form>
<br class="clearBoth" />
</div>
