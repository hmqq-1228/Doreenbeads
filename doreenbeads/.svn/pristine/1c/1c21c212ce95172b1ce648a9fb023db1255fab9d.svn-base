<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 3505 2006-04-24 04:00:05Z drbyte $
 */
?>
<script language="javascript" type="text/javascript"><!--
var submitter = null;
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}

function couponpopupWindow(url) {
  window.open(url,'couponpopupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}

function submitFunction($gv,$total) {
   if ($gv >=$total) {
     submitter = 1;	
   }
}

//function submitonce(){
//	//robbie  fix the duplicate order error
////  if (document.checkout_confirmation.btn_submit) {
////	  document.checkout_confirmation.btn_submit.disabled = true;
////    setTimeout('button_timeout()', 4000);
//   /* document.checkout_confirmation.submit(); */
//   var button = document.getElementById("btn_submit"); 
//  button.disabled = true;
//  //button.style.color = "red";
//  setTimeout('button_timeout()', 4000);  
//  return false;
//  }
//}
//
//function button_timeout() {
////  document.checkout_confirmation.btn_submit.disabled = false;
//  var button = document.getElementById("btn_submit");
//  button.disabled = false;
//  //button.style.color = "black";
//}
function submitonce()
{
  var button = document.getElementById("btn_submit");
  button.style.cursor="wait";
  button.disabled = true;
  setTimeout('button_timeout()', 4000);
  return false;
}
function button_timeout() {
  var button = document.getElementById("btn_submit");
  button.style.cursor="pointer";
  button.disabled = false;
}
//bof haoran 2011.8.31
function show_description(divid, text, startX){
	/*startX = document.getElementById("mouseposX").value;
	startY = document.getElementById("mouseposY").value;*/
	document.getElementById(divid).innerHTML = text;
	document.getElementById(divid).className = "show_description";
	document.getElementById(divid).style.left = startX + "px";
	//document.getElementById("show_description").style.top = "-100px";
}

function close_description(divid){
	document.getElementById(divid).innerHTML = "";
	document.getElementById(divid).className = "close_description";
}
//eof
//--></script>
