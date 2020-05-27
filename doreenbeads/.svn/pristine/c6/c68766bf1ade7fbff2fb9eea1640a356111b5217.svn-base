<?php
/**
 * customers_group Class.
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: customers_group.php 3041 2006-02-15 21:56:45Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * customers_group Class.
 * Class to handle group
 *
 * @package classes
 */
class customers_group extends base {
	function get_new_group($customers_id){
		global $db;
		
		if (!zen_not_null($customers_id) or $customers_id == '') return -1;
		
		$order_total = $db->Execute('Select sum(value) as total
									   From ' . TABLE_ORDERS_TOTAL . ' as ot, ' . TABLE_ORDERS . " as o
									  Where ot.orders_id = o.orders_id
									    And class = 'ot_total'
									    And o.orders_status in (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
									    And o.customers_id = " . $customers_id);
		//if ($order_total->fields['total'] == 0) return 0;
		
		$declare_total = $db->Execute('Select sum(usd_order_total) as d_total
									   From ' . TABLE_DECLARE_ORDERS ."
									  Where status>0 and customer_id = " . $customers_id);
		
		$total_amt = $order_total->fields['total'] + $declare_total->fields['d_total'];
		
		if ($total_amt < 200) return 0;
		
		$group_id = $db->Execute('Select group_id
									From ' . TABLE_GROUP_PRICING . '
								   Where min_amt <= ' . $total_amt . '
								     And max_amt > ' . $total_amt);
		if ($group_id->RecordCount() > 0) return $group_id->fields['group_id'];
		
		$max_group = $db->Execute('Select max(group_id) as max_id
									 From ' . TABLE_GROUP_PRICING);
		if ($max_group->RecordCount() == 1)  return $max_group->fields['max_id'];
		
		return 0;
	}
	
	function correct_group($customers_id){
		global $db;

		if (!zen_not_null($customers_id)) return -1;
		$customers_group = $db->Execute('Select customers_group_pricing 
										   From ' . TABLE_CUSTOMERS . '
										  Where customers_id = ' . $customers_id);
		
		$old_group = $customers_group->fields['customers_group_pricing'];
		$new_group = $this->get_new_group($customers_id);
		
		//if ($new_group == 0) return 0;
		
		if ($old_group <> $new_group) {
			$db->Execute('Update ' . TABLE_CUSTOMERS . ' Set customers_group_pricing = ' . $new_group . ' Where customers_id = ' . (int)$customers_id);						
		}
		if($old_group < $new_group){
				$this->send_mail($customers_id, $old_group);
		}
		return $new_group;
	}
	
	
	function send_mail($customers_id = '', $group_id = ''){
		global $db;
		
		$customers_info = $db->Execute('Select customers_firstname, customers_lastname, customers_email_address, customers_group_pricing, 
											   group_percentage, group_name
										  From ' . TABLE_CUSTOMERS . ', ' . TABLE_GROUP_PRICING . '
										 Where customers_group_pricing = group_id
										   And customers_id = ' . (int)$customers_id);
		
		$order_total = $db->Execute('Select sum(value) as total
									   From ' . TABLE_ORDERS_TOTAL . ' as ot, ' . TABLE_ORDERS . " as o
									  Where ot.orders_id = o.orders_id
									    And class = 'ot_total'
									    And o.orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ")
									    And o.customers_id = " . (int)$customers_id);
		
		$declare_total = $db->Execute('Select sum(usd_order_total) as d_total
									   From ' . TABLE_DECLARE_ORDERS ."
									  Where status>0 and customer_id = " . (int)$customers_id);
		
		if ($customers_info->RecordCount() < 1) return -1;
		
		$html_msg=array();
		
		$ls_subject = 'Congratulations, Your VIP Level&Discount have been upgraded!';
		$ls_text_mail = 
		'Dear [%First Name%] [%Last Name%], 

Thanks for all of your great business on our website and we are really happy to have business relationship with you. 

Up to now, all of your previous purchases on our website amounted to US $[%Total Amount%]. Congratulations, your VIP level has been upgraded to [[%VIP Level%]] VIP along with [[%Conbined Discount%]] VIP discount based on your previous purchases. Please go ahead! You can start to enjoy this [[%Conbined Discount%]] discount on Latest Beads and Supplies for Jewelry Making[[%Server%]/products_new.html] and Weekly Specials[[%Server%]/specials.html] through our website: [%Server%] 
(Kindly note: Your VIP discount is allowed to combine with RCD discount for the Combination Discount)

Regarding to your current VIP level, you could login My Account on our website for the detailed information. 

Please feel free to check out the chart below for your next level and the discount you will get. 

You may check this link for detailed information about VIP policy on our website: 
[%VIP Page%]

Sincerely 
Hong (Lisa) &8season Team';
			if(zen_get_customer_create($customers_id)){
				$html_msg['EMAIL_MESSAGE_HTML'] = '<br />Dear [%First Name%] [%Last Name%], <br /><br />
				Thanks for all of your great business on our website and we are really happy to have business relationship with you. <br /><br />

				Up to now, all of your previous purchases on our website amounted to US $[%Total Amount%]. Congratulations, your VIP level has been upgraded to <b>[%VIP Level%]</b> along with <b>[%Conbined Discount%]</b> VIP discount based on your previous purchases. 
				<br />Please go ahead! You can start to enjoy this <b>[%Conbined Discount%]</b> discount on <a href="[%Server%]/products_new.html" target="_blank">Latest Beads and Supplies for Jewelry Making</a> and <a href="[%Server%]/specials.html" target="_blank">Weekly Specials</a> through our website: <a href="[%Server%]" target="_blank">[%Server%]</a><br />
				
				Regarding to your current VIP level, you could login My Account on our website for the detailed information. <br /><br />
				
				<b>Please feel free to check out the chart below for your next level and the discount you will get.</b><br /><br />
				<table bordercolor="#69006E" border="1" width="486">
			            <tr>
			                <td width="187" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Cumulative purchase</div>				</td>
			                <td width="100" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Member Level</div>				</td>
			                <td width="77" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">VIP <br />Discount</div>				</td>
			               
			            </tr>
			            <tr height="24">
			                <td bordercolor="#999999" align="right">
			              First order</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;/</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;$6.01               </td>
			               
			            </tr>
			      		<tr bgcolor="#F0F0F0">
			          		<td height="23" bordercolor="#999999" align="right">
			          		US $0-US $200   
			          		<div align="right"></div></td>
			          		<td bordercolor="#999999" align="center">&nbsp;Normal </td>
			          		<td bordercolor="#999999" align="center">0%</td>
			          		
			      		</tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $200-US $1000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Bronze              </td>
			                <td bordercolor="#999999" align="center">
			                3%                </td>
			               
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $1000-US $2000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Silver              </td>
			                <td bordercolor="#999999" align="center">
			                5%                </td>
			               
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $2000-US $5000</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Gold              </td>
			                <td bordercolor="#999999" align="center">
			                8%                </td>
			               
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $5000 or above                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Platinum              </td>
			                <td bordercolor="#999999" align="center">
			                10%                </td>
			               
			            </tr>
	  
						<tr>
			                <td bordercolor="#999999" colspan="4" align="left" height="20">
			                <p><font color="#0000ff" face="Arial"><strong>Kindly Note</strong>: the discount is only for goods cost not including postage&nbsp;</p>
			                </td>
			            </tr>
			</table>
				<br />
				You may have a check here for detailed VIP information on my website at your convenience:<br />
				<a href="[%VIP Page%]" target="_blank">[%VIP Page%]</a><br /><br />
				Sincerely yours <br />
				Hong (Lisa) & dorabeads Team';
			}else{
			$html_msg['EMAIL_MESSAGE_HTML'] = '<br />Dear [%First Name%] [%Last Name%], <br /><br />
				Thanks for all of your great business on our website and we are really happy to have business relationship with you. <br /><br />

				Up to now, all of your previous purchases on our website amounted to US $[%Total Amount%]. Congratulations, your VIP level has been upgraded to <b>[%VIP Level%]</b> along with <b>[%Conbined Discount%]</b> VIP discount based on your previous purchases. 
				<br />Please go ahead! You can start to enjoy this <b>[%Conbined Discount%]</b> discount on <a href="[%Server%]/products_new.html" target="_blank">Latest Beads and Supplies for Jewelry Making</a> and <a href="[%Server%]/specials.html" target="_blank">Weekly Specials</a> through our website: <a href="[%Server%]" target="_blank">[%Server%]</a><br />
				(Kindly note: Your VIP discount is allowed to combine with RCD discount for the Combination Discount)<br /><br />
				
				Regarding to your current VIP level, you could login My Account on our website for the detailed information. <br /><br />
				
				<b>Please feel free to check out the chart below for your next level and the discount you will get.</b><br /><br />
				<table bordercolor="#69006E" border="1" width="486">
			            <tr>
			                <td width="187" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Cumulative purchase</div>				</td>
			                <td width="100" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Member Level</div>				</td>
			                <td width="77" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">VIP <br />Discount</div>				</td>
			               
			            </tr>
			            <tr height="24">
			                <td bordercolor="#999999" align="right">
			              First order</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;/</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;$6.01               </td>
			               
			            </tr>
			      		<tr bgcolor="#F0F0F0">
			          		<td height="23" bordercolor="#999999" align="right">
			          		US $0-US $200   
			          		<div align="right"></div></td>
			          		<td bordercolor="#999999" align="center">&nbsp;Normal </td>
			          		<td bordercolor="#999999" align="center">0%</td>
			          		
			      		</tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $200-US $1000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Bronze              </td>
			                <td bordercolor="#999999" align="center">
			                3%                </td>
			               
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $1000-US $2000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Silver              </td>
			                <td bordercolor="#999999" align="center">
			                5%                </td>
			               
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $2000-US $5000</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Gold              </td>
			                <td bordercolor="#999999" align="center">
			                8%                </td>
			               
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $5000 or above                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Platinum              </td>
			                <td bordercolor="#999999" align="center">
			                10%                </td>
			               
			            </tr>
	  
						<tr>
			                <td bordercolor="#999999" colspan="4" align="left" height="20">
			                <p><font color="#0000ff" face="Arial"><strong>Kindly Note</strong>: the discount is only for goods cost not including postage&nbsp;</p>
			                </td>
			            </tr>
			</table>
				<br />
				You may have a check here for detailed VIP information on my website at your convenience:<br />
				<a href="[%VIP Page%]" target="_blank">[%VIP Page%]</a><br /><br />
				Sincerely yours <br />
				Hong (Lisa) & dorabeads Team';
			}

		$first_name = strtoupper(substr($customers_info->fields['customers_firstname'], 0, 1)) . substr($customers_info->fields['customers_firstname'], 1);
		$last_name = strtoupper(substr($customers_info->fields['customers_lastname'], 0, 1)) . substr($customers_info->fields['customers_lastname'], 1);
		$ls_text_mail = str_replace('[%First Name%]', $first_name, $ls_text_mail);
		$ls_text_mail = str_replace('[%Last Name%]', $last_name, $ls_text_mail);
		$ls_text_mail = str_replace('[%VIP Level%]', $customers_info->fields['group_name'], $ls_text_mail);
		$ls_text_mail = str_replace('[%Total Amount%]', number_format($order_total->fields['total']+$declare_total->fields['d_total'], 2), $ls_text_mail);
		$ls_text_mail = str_replace('[%Conbined Discount%]', $customers_info->fields['group_percentage'] . '%', $ls_text_mail);
		$ls_text_mail = str_replace('[%Server%]', HTTP_SERVER, $ls_text_mail);
		$ls_text_mail = str_replace('[%VIP Page%]', HTTP_SERVER . '/page.html?chapter=0&id=65', $ls_text_mail);
		
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%First Name%]', $first_name, $html_msg['EMAIL_MESSAGE_HTML']);
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%Last Name%]', $last_name, $html_msg['EMAIL_MESSAGE_HTML']);
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%Total Amount%]', number_format($order_total->fields['total']+$declare_total->fields['d_total'], 2), $html_msg['EMAIL_MESSAGE_HTML']);
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%VIP Level%]', $customers_info->fields['group_name'], $html_msg['EMAIL_MESSAGE_HTML']);
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%Conbined Discount%]', $customers_info->fields['group_percentage'] . '%', $html_msg['EMAIL_MESSAGE_HTML']);
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%Server%]', HTTP_SERVER, $html_msg['EMAIL_MESSAGE_HTML']);
		$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('[%VIP Page%]', HTTP_SERVER . '/page.html?chapter=0&id=65', $html_msg['EMAIL_MESSAGE_HTML']);
		
		zen_mail($first_name . ' ' . $last_name, 
			$customers_info->fields['customers_email_address'], $ls_subject, $ls_text_mail, STORE_NAME, EMAIL_FROM, $html_msg);
//		
	}
}
?>
