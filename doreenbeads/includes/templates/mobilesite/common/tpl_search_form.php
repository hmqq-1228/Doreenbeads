<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_header.php 4813 2006-10-23 02:13:53Z drbyte $
 */
?>
<script>
	function checkValue(){
		var inputtext = $('#inputString').val();
		inputtext = inputtext.replace(/(^\s*)|(\s*$)/g, "");
	    inputtext = inputtext.replace(/&/g, "");
	    $('#inputString').val(inputtext);
		if(inputtext == '' || $('#inputString').val()=='<?php echo TEXT_KEYWORDS_OR_PART;?>'){
			alert('<?php echo TEXT_KEYWORDS_OR_PART1;?>');
			 return false;
		}
	}
</script>
<div class="searchform">
	<?php
	$sData ['categories_id'] = (isset ( $_GET ['categories_id'] ) ? zen_output_string ( $_GET ['categories_id'] ) : 0);
	$sData ['inc_subcat'] = (isset ( $_GET ['inc_subcat'] ) ? zen_output_string ( $_GET ['inc_subcat'] ) : 1);
	$sData ['search_in_description'] = (isset ( $_GET ['search_in_description'] ) ? zen_output_string ( $_GET ['search_in_description'] ) : 1);
	$sData ['keyword'] = (isset ( $_GET ['keyword'] ) ? zen_output_string ( $_GET ['keyword'] ) : TEXT_KEYWORDS_OR_PART);
	echo zen_draw_form ( 'boxSearchFrm', zen_href_link ( FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false ), 'get', 'onsubmit="return checkValue()"' );
	echo zen_draw_hidden_field ( 'main_page', FILENAME_ADVANCED_SEARCH_RESULT );
	echo zen_hide_session_id ();
	?>
    <div>
	<?php
	echo zen_draw_input_field ( 'keyword', $keyword_input, 'id="inputString" autocomplete=off maxlength="100" value="' . TEXT_KEYWORDS_OR_PART . '" onfocus="clearTips(this,\'' . TEXT_KEYWORDS_OR_PART . '\'),$(this).addClass(\'writefocus\');" onblur="onkeynone(this.value,\'' . TEXT_KEYWORDS_OR_PART . '\');"  class="searchinput"', $type = 'text', $reinsert_value = false );
	?>
    </div>
	<input type="Submit" value="" />
	</form>
</div>