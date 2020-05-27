<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create_account.<br />
 * Displays Create Account form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_create_account.php 4822 2006-10-23 11:11:36Z drbyte $
 */
?>
<?php if ($messageStack->size('create_account') > 0) echo $messageStack->output('create_account'); ?>
<div class="alert forward"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
<br class="clearBoth" />

<?php
  if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
?>
<fieldset>
<legend><?php echo TABLE_HEADING_PRIVACY_CONDITIONS; ?></legend>
<div class="information"><?php echo TEXT_PRIVACY_CONDITIONS_DESCRIPTION;?></div>
<?php echo zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy"');?>
<label class="checkboxLabel" for="privacy"><?php echo TEXT_PRIVACY_CONDITIONS_CONFIRM;?></label>
</fieldset>
<?php
  }
?>

<?php
  if (ACCOUNT_COMPANY == 'true') {
?>
<fieldset>
<legend><?php echo CATEGORY_COMPANY; ?></legend>
<label class="inputLabel" for="company"><?php echo ENTRY_COMPANY; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '25') . ' id="company"') . (zen_not_null(ENTRY_COMPANY_TEXT) ? '<span class="alert">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?>
</fieldset>
<?php
  }
?>

<fieldset>
<legend><?php echo TABLE_HEADING_ADDRESS_DETAILS; ?></legend>
<?php
  if (ACCOUNT_GENDER == 'true') {
?>
<?php echo zen_draw_radio_field('gender', 'm', '', 'id="gender-male"') . '<label class="radioButtonLabel" for="gender-male">' . MALE . '</label>' . zen_draw_radio_field('gender', 'f', '1', 'id="gender-female"') . '<label class="radioButtonLabel" for="gender-female">' . FEMALE . '</label>' . (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="alert">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php
  }
?>

<label class="inputLabel" for="firstname"><?php echo ENTRY_FIRST_NAME; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '25') . ' id="firstname"') . (zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="alert">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<label class="inputLabel" for="lastname"><?php echo ENTRY_LAST_NAME; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '25') . ' id="lastname"') . (zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="alert">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<label class="inputLabel" for="street-address"><?php echo ENTRY_STREET_ADDRESS; ?></label>
<br class="clearBoth" />
  <?php echo zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '25') . ' id="street-address"') . (zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="alert">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
<label class="inputLabel" for="suburb"><?php echo ENTRY_SUBURB; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '25') . ' id="suburb"') . (zen_not_null(ENTRY_SUBURB_TEXT) ? '<span class="alert">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php
  }
?>

<label class="inputLabel" for="city"><?php echo ENTRY_CITY; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '25') . ' id="city"') . (zen_not_null(ENTRY_CITY_TEXT) ? '<span class="alert">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
<br class="clearBoth" />



<label class="inputLabel" for="postcode"><?php echo ENTRY_POST_CODE; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '25') . ' id="postcode"') . (zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="alert">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<label class="inputLabel" for="country"><?php echo ENTRY_COUNTRY; ?></label>
<br class="clearBoth" />
<?php 
	$country_select_name='zone_country_id';
	echo zen_get_country_select($country_select_name, $select_country_id,$priority_country);
    ?>
    <script>
      	country_select_choose('<?php echo $country_select_name;?>','create_account');
    </script>
    <?php      	  
?>
<br class="clearBoth" />
<?php
  if (ACCOUNT_STATE == 'true') {
    if ($flag_show_pulldown_states == true) {
?>
	<label class="inputLabel" for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
	<br class="clearBoth" />
	<?php 
		echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($select_country_id), $zone_id, 'id="stateZone"'); 
	?>
	   <input type="hidden" name="state" value="" id="state"/>
	<?php echo zen_not_null(ENTRY_STATE_TEXT) ? '<span class="alert" id="stText">' . ENTRY_STATE_TEXT . '</span>': '';?>
	   <br class="clearBoth" id="stBreak" />    
	<?php 
	    }else{
	?>
	<label class="inputLabel" for="state" id="stateLabel"><?php echo $state_field_label; ?></label>
	<br class="clearBoth" />
	<?php
		echo zen_draw_input_field('state', zen_get_zone_name($entry->fields['entry_country_id'], $entry->fields['entry_zone_id'], $entry->fields['entry_state']), zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"'); 
		echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down(223), '', 'id="stateZone" class="hiddenField"');
		
	?>
<br class="clearBoth" />
    	<?php 
    }
  }
?>
</fieldset>

<fieldset>
<legend><?php echo TABLE_HEADING_PHONE_FAX_DETAILS; ?></legend>
<label class="inputLabel" for="telephone"><?php echo ENTRY_TELEPHONE_NUMBER; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('telephone', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '25') . ' id="telephone"') . (zen_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<div  style="margin-top:15px;" class="alert">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</div>': ''); ?>

<?php
  if (ACCOUNT_FAX_NUMBER == 'true') {
?>
<br class="clearBoth" />
<label class="inputLabel" for="fax"><?php echo ENTRY_FAX_NUMBER; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('fax', '', 'id="fax"') . (zen_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="alert">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?>
<?php
  }
?>
</fieldset>

<?php
  if (ACCOUNT_DOB == 'true') {
?>
<fieldset>
<legend><?php echo TABLE_HEADING_DATE_OF_BIRTH; ?></legend>
<label class="inputLabel" for="dob"><?php echo ENTRY_DATE_OF_BIRTH; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('dob','', 'id="dob"') . (zen_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="alert">' . FORM_REQUIRED . '</span>': ''); ?>
<br class="clearBoth" />
</fieldset>
<?php
  }
?>

<fieldset>
<legend><?php echo TABLE_HEADING_LOGIN_DETAILS; ?></legend>
<label class="inputLabel" for="email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '25') . ' id="email-address"') . (zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="alert">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<?php
  if ($phpBB->phpBB['installed'] == true) {
?>
<label class="inputLabel" for="nickname"><?php echo ENTRY_NICK; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('nick','','id="nickname"') . (zen_not_null(ENTRY_NICK_TEXT) ? '<span class="alert">' . ENTRY_NICK_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php
  }
?>

<label class="inputLabel" for="password-new"><?php echo ENTRY_PASSWORD; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '25') . ' id="password-new"') . (zen_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="alert">' . FORM_REQUIRED . '</span><br/><span class="alert">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<label class="inputLabel" for="password-confirm"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '25') . ' id="password-confirm"') . (zen_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="alert">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
</fieldset>

<fieldset>
<legend><?php echo ENTRY_EMAIL_PREFERENCE; ?></legend>
<?php
  if (ACCOUNT_NEWSLETTER_STATUS != 0) {
?>
<?php echo zen_draw_checkbox_field('newsletter', '1', $newsletter, 'id="newsletter-checkbox"') . '<label class="checkboxLabel" for="newsletter-checkbox">' . ENTRY_NEWSLETTER . '</label>' . (zen_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="alert">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php } ?>

<?php echo zen_draw_radio_field('email_format', 'HTML', ($email_format == 'HTML' ? true : false),'id="email-format-html"') . '<label class="radioButtonLabel" for="email-format-html">' . ENTRY_EMAIL_HTML_DISPLAY . '</label>' .  zen_draw_radio_field('email_format', 'TEXT', ($email_format == 'TEXT' ? true : false), 'id="email-format-text"') . '<label class="radioButtonLabel" for="email-format-text">' . ENTRY_EMAIL_TEXT_DISPLAY . '</label>'; ?>
<br class="clearBoth" />
</fieldset>

<?php
  if (CUSTOMERS_REFERRAL_STATUS == 2) {
?>
<fieldset>

<legend><?php echo TABLE_HEADING_REFERRAL_DETAILS; ?></legend>
<label class="inputLabel" for="customers_referral"><?php echo ENTRY_CUSTOMERS_REFERRAL; ?></label>
<br class="clearBoth" />
<?php echo zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', '15') . ' id="customers_referral"'); ?>
<br class="clearBoth" />
</fieldset>
<?php } ?>