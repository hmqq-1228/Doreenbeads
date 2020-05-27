<script language="javascript" type="text/javascript">
$j(document).ready(function(){
	$j('.jq_message_setting_button').live('click', function(){
		var message_receive_type = $j("input[name='message_receive_type']:checked").val();
		if(typeof(message_receive_type) == "undefined" || message_receive_type == "") {
			$j(".jq_message_content").show().text("<?php echo addslashes(TEXT_PLEASE_CHOOSE_AT_LEAST_MESSAGE);?>");
			return false;
		} else if(message_receive_type == "10") {
			if(confirm("<?php echo addslashes(TEXT_YOU_WILL_NO_LONGER_MESSAGE);?>")) {
				$j('.jq_from_message_setting').submit();
			}
			return false;
		}
		$j('.jq_from_message_setting').submit();
	});
});
</script>