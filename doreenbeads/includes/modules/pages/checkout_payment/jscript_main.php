<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 4942 2006-11-17 06:21:37Z ajeh $
 */
?>
<script language="javascript" type="text/javascript"><!--
	<?php
	if(trim($_GET['auto_close'] == "true")) {
		echo "var paypalTimer = setInterval(function() {clearInterval(paypalTimer);window.close();}, 300);";
	}
	?>

//--></script>