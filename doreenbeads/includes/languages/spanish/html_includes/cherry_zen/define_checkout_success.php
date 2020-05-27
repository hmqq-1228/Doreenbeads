<p><br />
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
	<div style="background-color: rgb(204, 204, 255);" id="congratulation"><strong>Congratulations!</strong></div>
	<p class="importnat">Your order has been generated and listed in our back-end system.    You can also check the order details by go to &quot;My Account&quot;, which is on the top-right of this page.    <br />
	We also have sent an email with order detail to your registered email address.</p>
	<div style="background-color: rgb(204, 204, 255);" id="orderinformation"><strong>Your Order:Total Amount&amp;Shiping Method </strong></div>
	<p>Order Number:<br />
	Total Amount for this order:<br />
	Shipping Method for this order:<br />
	Now you need to send payment to us using PayPal manually!</p>
	<div style="background-color: rgb(204, 204, 255);" id="payment"><strong>Instructions for Payment by Paypal Manually</strong></div>
	<p class="importnat"><font color="red"><strong>Firstly</strong></font>, log into your paypal account at  	 <a color="" target="_blank" href="http://www.paypal.com"><font color="Green">www.paypal.com</font></a>. Click the button  	 <img width="77.5" height="18" alt="Send Money" src="/images/offline/send_money.bmp" />  	 in your account page.<br />
	<br />
	<img width="387.9" height="172.8" alt="Paypal Main Page" src="/images/offline/send_money_main.bmp" /></p>
	<p>&nbsp;</p>
	<p class="importnat"><font color="red"><strong>Secondly</strong></font>, you now come to the &quot;send money&quot; page.  	 Please put <strong>service@8seasons.com</strong> (Note: not supplies@8season<font color="red">s</font>.com) in the To (email) box and fill out your total amount.  	 Choose the &quot;Goods&quot; option in &quot;Send money for&quot; frame. And then hit &quot;Continue&quot;  	 to the next page.<br />
	<br />
	<img alt="Paypal-Send Money Page" src="/images/offline/send_money_content.jpg" /><br />
	<br />
	<font color="red"><strong>Thirdly</strong></font>, in this new page, please scroll your screen down to Email to recipient option. Input your order No. and our website in the Subject box (You can input the information here like this: Payment for my order No. -- on 8seasons.com ). Lastly click &quot;Send Money&quot; button to complete your payment. <br />
	<br />
	<img alt="Paypal-Email Content" src="/images/offline/send_money_email.jpg" /></p>
	<p>&nbsp;</p>
	<p class="importnat"><font color="red"><strong>Finally</strong></font>, after checking successfully, please advise us with an    email titled your subject information as soon as possible    (My email address: <strong><a href="mailto:service@8seasons.com">service@8seasons.com</a> (Note: not supplies@8season<font color="red">s</font>.com)</strong>).   Therefore we can arrange to send out your parcel promptly as our Finance Officer check the bill.</p>
	<p class="importnat"><strong>If you still meet some problems, please feel free to contact us at service@8seasons.com.    			We are happy to assist. </strong></p>
	<!--
	end
	-->
	
<?php
}else{
?>
	<p><br />
	If you choosed to pay us by Western Union Money Instant Transfer or Direct Bank Transfer(Wire Transfer), please do not forget to follow the instruction to send the payment.</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p><strong>Click here to check Payment Instructions again. </strong><a href="<?php echo HTTP_SERVER;?>/index.php?main_page=help_center&pagename=payment_method" target="_blank" title="8Season Payment Instructions"><font color="#0000cc"><strong>Payment Method</strong></font></a></p>
	<p>&nbsp;</p>
	<p>Note*: If you choose&nbsp; Western Union Money Instant Transfer or Direct Bank Transfer as payment method <font color="#0000ff"><strong>in mistake</strong></font>,</p>
	<p>or you <font color="#0000ff"><strong>meet problems</strong></font> when trying to pay us by PayPal in our website,</p>
	<p>just send email to service@8seasons.com for help. In your email, you should tell us your PayPal email address and your order No. Our billing department will help you to pay through PayPal!</p>
<?php
}
?>