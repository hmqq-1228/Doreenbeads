
function copyUrl(){
	var url = document.getElementById('input');
	url.select();
	document.execCommand("Copy");
	alert(js_lang.TEXT_SUCCESS);
}



