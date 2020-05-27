<?php
/**
 * Override Template for common/tpl_main_page.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_main_page.php 3155 2006-03-10 23:19:39Z drbyte $
 */
?>

<body id="popupShippingEstimator">
<div class="shippingEstimatorWrapper biggerText">
<p><?php echo '<a href="javascript:window.close()">' . TEXT_CURRENT_CLOSE_WINDOW . '</a>'; ?></p><br/>
For most shipping methods, heavier parcel means higher shipping cost. But not all shipping methods are in this case. Take Normal DHL (KD Agent) for example, for parcels weighing 21kg, 
		it only cost US$137.63, which is much lower than US$153.62 charged for 17kg parcels. The reason is that when parcel reach 21kg, we could get better shipping price from post agent. <br/>
        <br/><b>Kind Suggestion:</b> When your parcel weighs more than 17kg but lower than 21kg, we recommend you to buy more items, in that case, for all extra items you add, you do not have to pay additional 
        shipping fee, and the shipping fee you have to pay may be lower. <br/><br/>Following is the detailed shipping information: <br/><br/><div style="margin:auto;width:60%;">
		<b><table border=1 style="text-align:center;width:100%;"><tr><td colSpan=2> Normal DHL (KD Agent) (5-7 Days to Worldwide)</td></tr><tr><td width="50%"> Shipping weight</td><td> Shipping fee</td></tr><tr><td> 17kg</td><td><font style="color:red">US $153.62</font></td></tr>
        <tr><td> 18kg</td><td> US $161.66</td></tr><tr><td> 19kg</td><td> US $169.70</td></tr><tr><td> 20kg</td><td> US $177.74</td></tr><tr><td>21kg</td><td><font style="color:red">US $137.63</font></td></tr></table></b></div>
<br/> 
<div style="width:60%;margin:auto;">
<table width="100%" align="center">
<tr>
<?php 
	//add back button if link is from shipping estimator page
     if(isset($_GET['reffer']) && $_GET['reffer']==1){
     	echo "<td align='right'><a href='".zen_href_link(FILENAME_POPUP_SHIPPING_ESTIMATOR)."'>".zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</td></a>'; 
     }
?>
</tr>
</table>
</div> 
</div>
</body>