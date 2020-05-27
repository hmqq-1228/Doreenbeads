<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=contact_us.<br />
 * Displays contact us page form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_contact_us_default.php 4272 2006-08-26 03:10:49Z drbyte $
 */
?>
<div class="centerColumn" id="contactUsDefault">

<?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send')); ?>

<?php if (CONTACT_US_STORE_NAME_ADDRESS== '1') { ?>
<address><?php //echo nl2br(STORE_NAME_ADDRESS); ?></address>
<?php } ?>

<?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>

<p class="mainContent success" align="center">
<?php echo TEXT_SEND_SUCCESS;?> 
</p>

<div class="buttonRow"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

<?php
  } else {
?>
<div style="padding:6px; border:1px dashed #2C8C13;">
<?php echo TEXT_CONTACT_US_TIME_INFO;?>
<div style="text-align:center;padding:10px;">
<!--<embed width="180" height="180" type="application/x-shockwave-flash" wmode="transparent" src="http://www.worldtimeserver.com/clocks/wtsclock024.swf?color=6495ED&amp;wtsid=CN"><br />--><b><?php echo TEXT_BEIJING_TIME;?></b>
<br/><span style="font-size:28px; font-weight:bold;"><?php echo date("H:i:s")?></span>
</div>
</div>
<?php if (DEFINE_CONTACT_US_STATUS >= '1' and DEFINE_CONTACT_US_STATUS <= '2') { ?>
<div id="contactUsNoticeContent" class="content">
<?php
/**
 * require html_define for the contact_us page
 */
  require($define_page);
?>
</div>
<?php } ?>

<?php if ($messageStack->size('contact') > 0) echo $messageStack->output('contact'); ?>

<fieldset id="contactUsForm">
<legend><?php echo HEADING_TITLE; ?></legend>
<br class="clearBoth" />

<?php
// show dropdown if set
    if (CONTACT_US_LIST !=''){
?>
<label class="inputLabel" for="send-to"><?php echo SEND_TO_TEXT; ?></label>
<?php echo zen_draw_pull_down_menu('send_to',  $send_to_array, 0, 'id="send-to"') . '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
<br class="clearBoth" />
<?php
    }
?>

<?php echo ENTRY_NAME; ?>
<?php echo zen_draw_input_field('contactname', $name, ' size="30" id="contactname"') . '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
<br class="clearBoth" />

<?php echo ENTRY_EMAIL; ?>
<?php echo zen_draw_input_field('email', ($error ? $_POST['email'] : $email), ' size="30" id="email-address"') . '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
<br class="clearBoth" />

<label for="enquiry"><?php echo ENTRY_ENQUIRY . '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?></label>
<?php echo zen_draw_textarea_field('enquiry', '30', '7', '', 'id="enquiry"'); ?>

</fieldset>

<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?></div>
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

<br /><br /><br />
<?php 
 require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CONTACT_US_BELOW, 'false'));
?>


</div>
</form>
</div>
<?php
  }
?>