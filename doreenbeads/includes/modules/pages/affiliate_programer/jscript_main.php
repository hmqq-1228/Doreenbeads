<script language="javascript" type="text/javascript">

function copyUrl(){
	var url = document.getElementById('input');
	url.select();
	document.execCommand("Copy");
	alert("<?PHP echo TEXT_SUCCESS ;?>");
}

</script>