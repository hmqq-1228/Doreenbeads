<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_newsletters.<br />
 * Subscribe/Unsubscribe from General Newsletter
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_newsletters_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */
?>
<div class="centerColumn" id="acctNewslettersDefault">
	<?php echo zen_draw_form('account_newsletter', zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>
	<p class="ordertit">
	<strong><?php echo HEADING_TITLE; ?></strong>

          	<?php if ($messageStack->size('account') > 0) {
          				echo '<span class="updatedis">'.SUCCESS_NEWSLETTER_UPDATED.'</span>';      
          		  }elseif ($messageStack->size('unsubscribed') > 0){
          		  		echo '<span class="updatedis">'.SUCCESS_NEWSLETTER_UNSUBSCRIBED.'</span>';
          		  }elseif ($messageStack->size('warning') > 0){
          		  		echo '<span class="updatenone">'.WARNING_NEWSLETTER_UPDATE.'</span>';
          		  }
            ?>

	</p>
	<h4><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER; ?></h4>
	<p><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER_DESCRIPTION; ?></p>

	<?php echo zen_draw_checkbox_field('newsletter_general', '1', (($newsletter_status == '1') ? true : false), 'id="newsletter"'); ?>
	<label class="checkboxLabel" for="newsletter"><?php echo TEXT_WANT_TO_RECEIVE; ?></label>
	<br class="clearBoth" />
	<p class="filterbtn back"><button type="submit"><?php echo BUTTON_UPDATE_ALT;?></button><p>	
	</form>
</div>