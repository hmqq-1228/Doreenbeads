<script language="javascript" type="text/javascript"><!--
$j(document).ready(function(){
//	change zone/state show
update_zone_c_shipping = function(theForm) {
	if (!theForm || !theForm.elements["zone_id"]) return;  
	var SelectedCountry = $j('#new_address_book #zone_country_id').val();
	var SelectedZone = theForm.elements["zone_id"].value;
	var NumState = theForm.zone_id.options.length;
	while(NumState > 0) {
		NumState = NumState - 1;
		theForm.zone_id.options[NumState] = null;
	}
	<?php echo $obj_info["zone_list"]; ?>
	if (SelectedZone != "") theForm.elements["zone_id"].value = SelectedZone;
}
});

	<?php
	if(trim($_GET['auto_close'] == "true")) {
		echo "var paypalTimer = setInterval(function() {clearInterval(paypalTimer);window.close();}, 300);";
	}
	?>

--></script>
