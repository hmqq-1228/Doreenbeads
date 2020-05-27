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
// $Id: jscript_main.php 1105 2005-04-04 22:05:35Z birdbrain $
//
?>
<script language="javascript"  type="text/javascript"><!--
function AddAction(){
  var _table=document.getElementById("prodcutList");
  var _tr=_table.insertRow(-1);
  var _td=new Array(2);
  for(var i=0;i<_td.length;i++)
  {
      _td[i]=_tr.insertCell(-1);
  }
      _td[0].innerHTML="<input type='text' name='products_id[]' value='' size='10' />";
      _td[1].innerHTML="<input type='text' name='cart_quantity[]' value='' size='4' />";
  }

//--></script> 
