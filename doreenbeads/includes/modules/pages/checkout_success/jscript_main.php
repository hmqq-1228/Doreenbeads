<script language="javascript" type="text/javascript">
<!--
	<?php
	if(trim($_GET['auto_close'] == "true")) {
		echo "var paypalTimer = setInterval(function() {clearInterval(paypalTimer);window.close();}, 300);";
	}
	?>
	
--></script>