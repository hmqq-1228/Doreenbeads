<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_tell_a_friend_default.php 2894 2006-01-25 04:51:59Z birdbrain $
 */
?>
<div class="centerColumn" id="tellAFriendDefault">
<?php echo zen_draw_form('invite_firends', zen_href_link(FILENAME_INVITE_FRIENDS, 'action=process'));?>

<?php if ($messageStack->size('invitefriend') > 0) echo $messageStack->output('friend'); ?>

<fieldset>
<legend><?php echo 'Invite Friends';?></legend>
<div><?php echo 'Invite a Friend to visit Doreenbeads Beads & Supplies:'; ?></div><br/>
<div><?php echo '<font color="#FF0000">* Required information</font>'; ?></div>
<br class="clearBoth" />

<label class="inputLabel" for="your_name"><?php echo FORM_FIELD_CUSTOMER_NAME; ?></label>
<?php echo zen_draw_input_field('your_name',$ls_your_name,'id="your_name"') . '&nbsp;<span class="alert">' . ENTRY_FIRST_NAME_TEXT . '</span>'; ?>
<br class="clearBoth" />

<label class="inputLabel" for="friends_email"><?php echo FORM_FIELD_FRIEND_EMAIL; ?></label>
<?php echo zen_draw_input_field('friends_email',  $_GET['friends_email'], 'id="friends_email"') . '&nbsp;<span class="alert">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>'; ?>
<br class="clearBoth" />


<div><?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?></div>
<br class="clearBoth" />
</fieldset>
<div id="tellAFriendAdvisory" class="advisory"><?php echo EMAIL_ADVISORY_INCLUDED_WARNING . str_replace('-----', '', EMAIL_ADVISORY); ?></div>

</form>
</div>