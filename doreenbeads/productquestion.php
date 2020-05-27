<?php
require('includes/application_top.php');
//if login,get customer's info
if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
	$sql = "select customers_firstname,customers_lastname,customers_email_address from t_customers 
			where customers_id = ".(int)$_SESSION['customer_id'];
    $customer_info = $db->Execute($sql);
	$customers_firstname =  $customer_info->fields['customers_firstname'];
	$customers_email_address =  $customer_info->fields['customers_email_address'];
	$customers_lastname =  $customer_info->fields['customers_lastname'];
	$customers_loginname = $customers_firstname." ".$customers_lastname;
  }	
  
  $wrong_str = "parameter wrong or missing!";
  //get product's info by pid	
	$products_id = zen_db_prepare_input($_GET['pid']);
	if (!zen_not_null($products_id)||!is_numeric($products_id)){
		echo $wrong_str;
		exit;
	}
	$product_sql = "select p.products_model,p.products_image,pd.products_name from t_products p,t_products_description pd
			where p.products_id = ".$products_id."
			and pd.language_id = ".(int)$_SESSION['languages_id']."
			and p.products_id = pd.products_id";	
    $products_info = $db->Execute($product_sql);
    if ($products_info->RecordCount() == 0){
    	echo $wrong_str;
		exit;
    }
    $products_image = "images/".$products_info->fields['products_image'];
    $products_model = $products_info->fields['products_model'];
    $products_name = $products_info->fields['products_name'];
	$str_product = "<div style=\"font-weight:bold;\">
    			<div style=\"float:left;margin:0 25px 25px 0;\">".zen_image($products_image, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT)."</div>
    			<div ><a href=".zen_href_link('product_info','products_id=' . $products_id).">".$products_name."</a></div><br /><br />
	    		<div>Part No. :  ".$products_model."</div>
    	</div> ";
?>
<style type="text/css">
html, body {
	font-family: Arial, Helvetica, sans-serif;
	margin:0;
	font-size: 12px;
	
}

a img {
	border:none;
}
INPUT,TEXTAREA {
font-size:12px;
color:navy;
border:thin solid Silver;
background-color:#FFF;
font-family:Arial, Helvetica, Geneva, Swiss, tahoma, Verdana, SunSans-Regular, sans-serif;
border-width:1px;
}
.inputtext02 {
font-size:12px;
font-weight:bold;
text-align:right;
margin-right:2px;
margin-top:3px;
width:138px;
float:left;
}
.inputtext03 {
margin-right:2px;
}
.hdr1 {
font-size:16px;
color:#003399;
font-weight:bold;
text-align:left;
}
.text01 {
clear:both;
font-size:12px;
font-style:normal;
text-align:left;
color:#000000;
margin-left:40px;
}
.text27 {
font-size:16px;
color:red;
font-weight:bold;
text-align:center;
}
.text10 {
font-size:16px;
color:#000000;
text-align:center;
}
.textinput{
border:0px solid red;
margin-top:15px;
}
</style>
<script type="text/javascript">
function validateFormInput() {
	   var strMsg = '';
	   with(document.theForm){
		  if (!isEmail(EmailAddress.value)){
	    	  strMsg = 'Please enter a valid e-mail address.';
		  }	         
	      else if(elements['first_name'].value.replace(/ /g,'').length <= 0){
	    	  strMsg = 'Please enter your first name.';
		  }	         
	      else if(elements['last_name'].value.replace(/ /g,'').length<=0){
			  strMsg = 'Please enter your last name.';
		  }
	      else if (MESSAGE.value.replace(/ /g,'').length <= 0){
	    	  strMsg = 'Please enter a question.';
		  }	 
	      else if (MESSAGE.value.replace(/ /g,'').length <= 0){
	    	  strMsg = 'Please enter a question.';
		  }	else{
              if(checkTextUrl(MESSAGE.value)){
                  strMsg = $lang.TEXT_CHECK_URL;
              }
          }
			      
	      if (strMsg.length > 0) {
	         alert(strMsg);
	         return false;
	      }	      
	   }
	   return true;
	}
 
function isEmail(inString) {
   if (inString.search(/^[a-z0-9A-Z_\-]+(\.[_a-zA-Z0-9\-]+)*@([_a-zA-Z0-9\-]+\.)+([a-zA-Z]{2,6})$/) != -1)
       return true;
   else
       return false;
}

</script>
<?php 
	if ($_GET['action'] == 'submit'){
		$customers_firstname = zen_db_prepare_input($_POST['first_name']);
		$customers_lastname = zen_db_prepare_input($_POST['last_name']);
		$customers_email = zen_db_prepare_input($_POST['EmailAddress']);
		$customers_question = zen_db_prepare_input($_POST['MESSAGE']);
		$question_topic = zen_db_prepare_input($_POST['question_topic']);
		$customer_name = $customers_firstname . ' ' . $customers_lastname;				
  		$email_subject = "Question for Details about the item (Question for ".$question_topic.")";   				
  		$email_top_description = "Your Question About Item ".$products_model." on dorabeads has been Received.";  
  		//mail send to customer					  				
		$html_msg['EMAIL_MESSAGE_HTML'] = $email_top_description."<br /><br />Dear Customer <br /><br />Have a nice day there!<br /><br />Thank you so much for contacting dorabeads.  We have received your question, one of our friendly Service Sales will get in touch with you as soon as possible within 24 hours. Please kindly wait in patience.<br /><br />If you need prompt assistance, please contact us via Live Chat or call our Customer Service Department at  86-57985154931 on our working hours: 8:30 AM to 6:30 PM (GMT +08:00) Beijing, China Sunday to Friday.<br /><br />Thank you for your time, we will be in touch with you soon!<br /><br />\n\n--------------------------------------Your Question---------------------------------------<br />".$customers_question."<br /><br />".$str_product."<br /><br /><div style='clear:both;'>Kind Regards to You<br />dorabeads Team<br /><a href=".HTTP_SERVER.">www.doreenbeads.com</a></div><br />";
  	zen_mail($customer_name, $customers_email, $email_subject, '', STORE_NAME, EMAIL_FROM, $html_msg, 'product_question');
  	//mail send to supplies	
  	$html_msg['CONTACT_US_OFFICE_FROM'] = "\n<span style='font-weight:bold;'>Email:</span>".$customers_email;
  	$extra_info = email_collect_extra_info($customer_name, $customers_email, $customers_loginname, $customers_email_address);
  	$html_msg['EXTRA_INFO'] = $extra_info['HTML'];
  	$html_msg['EMAIL_MESSAGE_HTML'] = $customers_question."<br /><br />".$str_product."<br />";
	//zen_mail('dorabeads-supplises', EMAIL_FROM, $email_subject, '', $customer_name, $customers_email, $html_msg, 'contact_us');
  	zen_mail('dorabeads-supplises', SALES_EMAIL_ADDRESS, $email_subject, '', $customer_name, $customers_email, $html_msg, 'contact_us', '', 'false', SALES_EMAIL_CC_TO);  	 
?>
<table width="300" align="center">
  <tr>
    <td class="hdr1"><div align="center">Product Question Confirmation</div></td>
  </tr>
	<tr><td class="text10"><br />Thank you !<br /><br />
        A Customer Service Representative will be in touch with you in about 1-2 business days.</td>
		</tr>

	<tr><td class="text10"><br />
      <a href=# OnClick="self.close();" class="text10">Click here to close this window.</a></td>
  </tr>
</table>
<?php }else {?>
<form action="<?php echo $_SERVER['PHP_SELF']?>?action=submit&pid=<?php echo $products_id;?>"  method="POST" onSubmit="return validateFormInput();" name="theForm">
    	<div class="hdr1">Product Question :</div><br />
    	<?php echo $str_product;?> 	
	    <div class="text01">
	    	Please send us your questions using the form below :
	    	<span style="margin-left:10px;font-size: 14px; color: #FF0000">* Required Information</span>
	    </div>
	    <div class="textinput">
		    <div class="inputtext02">Choose a topic :</div>
		    <div class="inputtext03">
		    	<select name="question_topic" id="question_topic" style="width:230px">
		    		<option>Details about the item</option>
		    		<option>Postage</option>
		    		<option>Payment</option>
		    		<option>Others</option>
		    	</select>
		    	<span class="text27">*</span>
		    </div>
	    </div>
	    <div class="textinput">
		    <div class="inputtext02">E-mail Address :</div>
		    <div class="inputtext03">
		    	<input name="EmailAddress" type="text" size="40" maxlength="100" value="<?php echo $customers_email_address;?>">
		    	<span class="text27">*</span>
		    </div>
	    </div>
	   <div class="textinput">
		    <div class="inputtext02">First Name :</div>
		    <div class="inputtext03">
		    	<input name="first_name" type="text" id="first_name" size="40" maxlength="100" value="<?php echo $customers_firstname;?>">
		    	<span class="text27">*</span>
		    </div>
	    </div>
	    <div class="textinput">
		    <div class="inputtext02">Last Name :</div>
		    <div class="inputtext03">
		    	<input name="last_name" type="text" id="last_name" size="40" maxlength="100" value="<?php echo $customers_lastname;?>">
		    	<span class="text27">*</span>
		   </div>
	   </div>
	   <div class="textinput">
		    <div class="inputtext02" valign="top">Question :</div>
		    <div class="inputtext03" style="float:left;">
		    	<textarea name="MESSAGE" cols="37" rows="7" id="MESSAGE" ></textarea> 		    		
		    </div>
		    <span class="text27" style="margin-left:3px;">*</span> 
	    </div>
	    <div style="clear:both;margin-left:320px;">
	    	<input type="submit" name="Submit" value="Submit" class="formbutton">
	    </div>
</form>
<?php }?>