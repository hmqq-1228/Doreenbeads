<br/>
<?php
////paypal_offline_robbie_wei
if ($ls_payment_module == 'paypalmanually'){
	global $db;
	$total_sql = "Select text from " . TABLE_ORDERS_TOTAL .
				 " Where orders_id = '" . $zv_orders_id . "' and class = 'ot_total'";
	$order_total = $db->Execute($total_sql);

	$ot_total_text = $order_total->fields['text'];
	
	$ship = "Select shipping_method from " . TABLE_ORDERS .
				 " Where orders_id = '" . $zv_orders_id . "'";
	$ship = $db->Execute($ship);
	
	$ship_method = $ship->fields['shipping_method'];
?>
<div id="congratulation" style="background-color:#CCCCFF;font:12px"><strong>Congratulations!</strong></div>
<p class="importnat">Your order has been generated and listed in our back-end system. 
  You can also check the order details by go to &quot;My Account&quot;, which is on the top-right of this page. 
  <br />
  We also have sent an email with order detail to your registered email address.<br />
  <br />
</p>
<div id="orderinformation" style="background-color:#CCCCFF;font:12px"><strong>Your Order:Total Amount&Shiping Method </strong></div>
<p>Total Amount for this order:<strong><font color="red"><?php echo $ot_total_text; ?></font></strong><br />
	Shipping Method for this order:<strong><font color="red"><?php echo $ship_method; ?></font></strong><br />
	Now you need to send payment to us using PayPal manually! <br /><br />
</p>
<div id="payment" style="background-color:#CCCCFF;font:12px"><strong>Instructions for Payment by Paypal Manually</strong></div>
<p class="importnat">
	<font color="red"><strong>Firstly</strong></font>, log into your paypal account at 
	 <a href="http://www.paypal.com" target="_blank" color><font color="Green">www.paypal.com</font></a>. Click the button 
	 <img src="/images/offline/send_money.bmp" alt="Send Money" width="77.5" height="18" /> 
	 in your account page.<br /><br />
	 <img src="/images/offline/send_money_main.bmp" alt="Paypal Main Page" 
			width="387.9" height="172.8" /></p>
	 <br /><p class="importnat"> <font color="red"><strong>Secondly</strong></font>, you now come to the &quot;send money&quot; page. 
	 Please put <strong>service@8seasons.com</strong> (Note: not supplies@8season<font color="red">s</font>.com) in the To (email) box and fill out your total amount. 
	 Choose the &quot;Goods&quot; option in &quot;Send money for&quot; frame. And then hit &quot;Continue&quot; 
	 to the next page.<br /><br />
  <img src="/images/offline/send_money_content.bmp" alt="Paypal-Send Money Page" width="299.7" 
  	height="421.2" /><br />
  <br /><font color="red"><strong>Thirdly</strong></font>, in this new page, please scroll your screen down to Email to recipient option. Input your order No. and our website in the Subject box (You can input the information here like this: Payment for my order No. ©l on service@8seasons.com ). Lastly click "Send Money" button to complete your payment. <br /><br />
  <img src="/images/offline/send_money_email.bmp" alt="Paypal-Email Content" 
  	width="565.2" height="238.5" /> 
  </p>
  <br /><p class="importnat"><font color="red"><strong>Finally</strong></font>, after checking successfully, please advise us with an 
  email titled your subject information as soon as possible 
  (My email address: <strong><a href="mailto:service@8seasons.com">service@8seasons.com</a> (Note: not supplies@8season<font color="red">s</font>.com)</strong>).
  Therefore we can arrange to send out your parcel promptly as our Finance Officer check the bill.
  <br /><p class="importnat">
  		<strong>If you still meet some problems, please feel free to contact us at service@8seasons.com. 
  			We are happy to assist. </strong><br /><br />
</p>
<!--
end
-->
<?php
}
else
{
?>
<p><strong>Checkout Success Sample Text?...</strong></p><p>A few words about the approximate shipping time or your processing policy would be put here. </p>
<p>This section of text is from the Define Pages Editor located under Tools in the Admin.</p>
<?php
}
?>