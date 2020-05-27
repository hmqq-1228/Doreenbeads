<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: jscript_main.php 5444 2006-12-29 06:45:56Z drbyte $
//
?>
<script language="javascript" src="includes/general.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript"> <!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=550,screenX=150,screenY=100,top=100,left=150')
}
//--></script>
<script language="javascript" type="text/javascript"> <!--

function init_addconfirm(){
    document.cart_quantity.setAttribute("action", "<?php echo zen_href_link(FILENAME_ACCOUNT_QUICK_REORDER) . '&action=addconfirm&order_id=' . $_GET['order_id']; ?>");
    document.cart_quantity.onsubmit();
}
function init_selectall(cart_quantity, v){
	for (var i = 0; i < document.cart_quantity.elements.length; i++){
		var e = document.cart_quantity.elements[i];
		if (e.type == "checkbox"){
			e.checked = v;
		}
	}
}
function selectall(){
	for (var i = 0; i < document.cart_quantity.elements.length; i++){
		var e = document.cart_quantity.elements[i];
		if (e.type == "checkbox"){
			e.checked = "checked";
		}else if(e.type == "text"){
			e.style.backgroundColor="#ffffff";
		}
	}
}
function unselectall(){
	for (var i = 0; i < document.cart_quantity.elements.length; i++){
		var e = document.cart_quantity.elements[i];
		if (e.type == "checkbox"){
			e.checked = "";
		}else if(e.type == "text"){
			e.style.backgroundColor="#dddddd";
		}
	}
}

function chaColor(chkBoxID,inputBoxID){
var oSel=document.getElementById(chkBoxID);
var oInBox=document.getElementById(inputBoxID);
if(oSel.checked){
  oInBox.style.backgroundColor="#ffffff"; //选中的背景颜色
}
else{
  oInBox.style.backgroundColor="#dddddd"; //非选中的背景颜色
}
}

//--></script>