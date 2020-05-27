<?php
/**
 * tpl_feedback_default.php
 * 顾客写feedback的页面
 * 新增文件
 */
?>
<div class="centerColumn" id="allProductsDefault">
<?php if (!isset($_SESSION['write_feedback_success'])){ ?>
<h1 id="allProductsDefaultHeading"><?php echo PAGE_TITLE; ?></h1>
<div style="padding:5px 10px; background:#FCF8FC;">
<?php echo TEXT_FEEDBACK_DESCRIPTION; ?>
</div>
<?php } ?>

<div style="background:#FCF8FC;">
<h1 id="allProductsDefaultHeading"><?php echo TEXT_WRITE_FEEDBACK; ?></h1>
<?php 
if ($messageStack->size('error') > 0){
	echo '<div style="padding:5px 10px;background:#990000;color:#FFFFFF;"><b>' . $messageStack->output('error') . '</b></div>';
}
if ($success = true && $_SESSION['write_feedback_success']){
	echo '<div style="padding:5px 10px; background:#C4EC97;">' . $_SESSION['write_feedback_success'] . '</div>';
	unset($_SESSION['write_feedback_success']);
}
?>
<?php echo zen_draw_form('write_feedback', zen_href_link(FILENAME_FEEDBACK), 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('action', 'write_new') . "\n" . zen_draw_hidden_field('MAX_FILE_SIZE', '1048576') . "\n";; ?>
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td colspan="2" style="padding:5px 10px;text-align:right;"><?php echo TEXT_FEEDBACK_REQUIRED_INFO; ?></td>
    </tr>
    <tr>
      <td class="fields_description"><?php echo TEXT_FEEDBACK_REQUIRED . TEXT_TYPE; ?></td>
      <td class="fields_field" style="padding:8px 12px">
        <select id="main_type" name="main_type">
      	  <?php 
      	    reset($feedback_type_array);
      	    foreach ($feedback_type_array as $type_key => $type_value){
      	      if ($type_key != '--Select One--'){
      	      	echo '<option value="' . $type_key . '">' . $type_key . '</option>' . "\n";
      	      } else {
      	      	echo '<option value="">' . $type_key . '</option>' . "\n";
      	      }
      	    }
      	  ?>
        </select>&nbsp;
        <?php
        	reset($feedback_type_array);
        	foreach ($feedback_type_array as $type_key => $type_value){
        		if (is_array($type_value)){
        			if (sizeof($type_value) > 0){
        				echo '<select class="detail_type" name="' . $type_key . '">' . "\n";
	        			for ($value_cnt = 0; $value_cnt < sizeof($type_value); $value_cnt++){
	        				if ($type_value[$value_cnt] != '--Select One--'){
	        					echo '<option value="' . $type_value[$value_cnt] . '">' . $type_value[$value_cnt] . '</option>' . "\n";
	        				} else {
	        					echo '<option value="">' . $type_value[$value_cnt] . '</option>' . "\n";
	        				}
	        			}
	        			 echo '</select>' . "\n";
        			}
        		}
        	}
        ?>
      </td>
    </tr>
    <?php 
    	if (!isset($_SESSION['customer_id']) || (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == '')){
    ?>
    <tr>
      <td class="fields_description"><?php echo TEXT_FEEDBACK_REQUIRED . TEXT_CUSTOMER_NAME; ?></td>
      <td class="fields_field" style="padding:0px 5px"><?php echo zen_draw_input_field('customer_name'); ?></td>
    </tr>
    <tr>
      <td class="fields_description"><?php echo TEXT_FEEDBACK_REQUIRED . TEXT_CUSTOMER_EMAIL; ?></td>
      <td class="fields_field" style="padding:0px 5px"><?php echo zen_draw_input_field('customer_email') . TEXT_NO_PUBLISH; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td class="fields_description"><?php echo TEXT_FEEDBACK_REQUIRED . TEXT_COMMENT; ?></td>
      <td class="fields_field"><?php echo zen_draw_textarea_field('comment', '10', '8', '', '', false); ?></td>
    </tr>
    <tr>
      <td class="fields_description"><?php echo TEXT_ATTACHE; ?></td>
      <td class="fields_field" style="padding:8px 5px;">
      	<?php 
	      	for ($file_cnt = 0; $file_cnt < 2; $file_cnt++){
  			  echo '<div>' . zen_draw_file_field('attachfile_' . $file_cnt) . '</div>' . "\n";
	      	}
	      	echo '<div id="hiddenattach" style="display:none;">' . "\n";
	      	for ($file_cnt = 2; $file_cnt < 6; $file_cnt++){
	      		echo '<div>' . zen_draw_file_field('attachfile_' . $file_cnt) . '</div>' . "\n";
	      	}
	      	echo '</div>' . "\n";
      	?>
      </td>
    </tr>
    <tr>
      <td class="fields_description">&nbsp;</td>
      <td class="fields_field" style="padding:0px 12px; color:#990000;padding-bottom:8px;"><b>Note: there is a 1MB size limit on each file.</b></td>
    </tr>
    <tr>
      <td class="fields_description">&nbsp;</td>
      <td class="fields_field" style="padding:0px 12px"><div id="more_attach"><a href="javascript:" onclick="return adduploadfile();"><img src="includes/templates/cherry_zen/images/more_attach.gif"></a></div></td>
    </tr>
    <tr>
      <td class="fields_description" colspan="2"><input type="submit" value="submit"></td>
    </tr>
  </table>
</form>
</div>
</div>