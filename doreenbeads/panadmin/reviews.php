<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: reviews.php 4737 2006-10-13 07:13:11Z drbyte $
 * @replace;
 */

  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $status_filter = (isset($_GET['status']) ? $_GET['status'] : '');
  $default_lang  = (isset($_GET['searchLang']) ? $_GET['searchLang']:'');
  $status_list[] = array('id' => 1, 'text' => TEXT_PENDING_APPROVAL);
  $status_list[] = array('id' => 2, 'text' => TEXT_APPROVED);
  $orderby_filter = (isset($_GET['orderby']) ? $_GET['orderby'] : '');
  $orderby_list[] = array('id' => 'products', 'text' => 'products');
  $orderby_list[] = array('id' => 'customer', 'text' => 'customer');
  $orderby_list[] = array('id' => 'rating', 'text' => 'rating');
  $orderby_list[] = array('id' => 'date', 'text' => 'date');
  
  if (zen_not_null($action)) {
    switch ($action) {
      case 'setflag':
        zen_set_reviews_status($_GET['id'], $_GET['flag']);

        zen_redirect(zen_href_link(FILENAME_REVIEWS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'rID=' . $_GET['id'], 'NONSSL'));
        break;
      case 'update':
      	$reviews_id = zen_db_prepare_input($_GET['rID']);
      	$reviews_reply_text = addslashes(zen_db_prepare_input($_POST['reviews_reply_text']));
      	
      	if (strlen($reviews_reply_text) > 0) {
      		$res_update_replay = $db->Execute("update " . TABLE_REVIEWS_DESCRIPTION . " set reviews_reply_text = '" . $reviews_reply_text . "' where reviews_id = " . $reviews_id);
      		$res_update_reviews = $db->Execute("update " . TABLE_REVIEWS . " set last_modified = now(), status = 1 where reviews_id = " . $reviews_id);
      		//用于返回数据修改的结果，用于提示操作是否成功   ************************************************************
      		/*if ($res_update_replay->RecordCount() > 0) {
      			//返回信息 用于提示操作是否成功
      		}*/
      		$messageStack->add_session(TEXT_UPDATE_REVIEWS_REPLY, 'success');      		
      	
	      	//发送邮件
	      	//根据reviews_id查找出 没有发送过邮件的评价顾客编号，名称，添加时间
	      	$res_reviews_customer = $db->Execute("select customers_id, customers_name, date_added, reviews_send_mail from " . TABLE_REVIEWS . " where reviews_id = " . $reviews_id);
	      	if ($res_reviews_customer->RecordCount() > 0 && $res_reviews_customer->fields['reviews_send_mail'] == 0) {
	      		$ls_customers_id = $res_reviews_customer->fields['customers_id'];
	      		$ls_customer_name = $res_reviews_customer->fields['customers_name'];
	      		$lt_reviews_date = $res_reviews_customer->fields['date_added'];
	      		
	      		//三表联合查询，指定顾客 过去24小时内，没有发送的邮件reviews，所有评价商品
	      		$res_reviews_porducts = $db->Execute("select rv.reviews_id, rv.products_id, pr.products_image, rvd.reviews_reply_text from " . TABLE_REVIEWS . ' as rv, ' . TABLE_PRODUCTS . " as pr, " . TABLE_REVIEWS_DESCRIPTION . " as rvd where rv.products_id = pr.products_id and rv.reviews_id = rvd.reviews_id and rv.reviews_send_mail = 0 and rv.customers_id = " . $ls_customers_id . " and rv.date_added <= '" . date('Y-m-d H:i:s', strtotime("$lt_reviews_date +12 hour")) . "' and rv.date_added > '" . date('Y-m-d H:i:s', strtotime("$lt_reviews_date -12 hour")) . "' order by rv.date_added");
	      		if ($res_reviews_porducts->RecordCount() > 0) {
	      			while (!$res_reviews_porducts->EOF){
	      				$ls_reviews_id_unite .= $res_reviews_porducts->fields['reviews_id'] . ',';
	      				
						$ls_reply_image_url_info .= '<br /><br /><div style="clear:both; float:right; width:100%;"><span style="float:left; padding-left:0px;">' . zen_image(DIR_WS_CATALOG_IMAGES . $res_reviews_porducts->fields['products_image'], zen_get_products_name($res_reviews_porducts->fields['products_id']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</span>' . (strlen($res_reviews_porducts->fields['reviews_reply_text']) > 0 ? 'Reply by 8Seasons:' . $res_reviews_porducts->fields['reviews_reply_text'] : '') . '<br /><a href="' . HTTP_SERVER . '/index.php?main_page=product_info&products_id=' . $res_reviews_porducts->fields['products_id'] . '">' . HTTP_SERVER . '/index.php?main_page=product_info&products_id=' . $res_reviews_porducts->fields['products_id'] . '</a></div>';
	      				$res_reviews_porducts->MoveNext();
	      			}
	      			$ls_reviews_id_unite = substr($ls_reviews_id_unite, 0, -1);
	      			
	      			//从订单表，中搜出指定活动用户，的最新订单
					$res_order_customers = $db->Execute("select od.orders_id from " . TABLE_ORDERS . " as od, " . TABLE_CUSTOMERS . " as cu where od.customers_id = cu.customers_id and cu.customers_authorization < 4 and od.customers_id = " . (int)$ls_customers_id . " order by od.date_purchased desc LIMIT 0, 1");	
					$ls_order_id = $res_order_customers->fields['orders_id'];
					
					$res_email_query = $db->Execute("select customers_email_address
						                      from " . TABLE_CUSTOMERS . "
						                     where customers_authorization < 4 and customers_id = " . (int)$ls_customers_id);
					$ls_email = $res_email_query->fields['customers_email_address'];
					
					if (isset($ls_order_id) && $ls_order_id != '') {
						$order_products_query = "select op.products_id, op.products_model, op.products_name, p.products_image 
									   from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p 
									  where o.orders_id = " . (int)$ls_order_id . "
									    and o.orders_id = op.orders_id 
									    and p.products_status = 1 
									    and op.products_id = p.products_id";
						$order_products = $db->Execute($order_products_query);
						$reviews_mail_array = array();
						$email_products_str = '';//用于记录该顾客最后一次订单中的商品信息
						
						if ($order_products->RecordCount() > 0){ 
							$email_products_str .= '<table class="product-details" border="0" width="100%" cellspacing="0" cellpadding="0">' . "\n";
							while (!$order_products->EOF){
								$email_products_str .= '  <tr>' . "\n";
								$email_products_str .= '	<td align="center" width="50" style="padding:5px;"><a href="' . HTTP_SERVER . '/index.php?main_page=product_info&products_id=' . $order_products->fields['products_id'] . '">' . zen_image(HTTP_SERVER  . '/' . DIR_WS_IMAGES . $order_products->fields['products_image'], '', 30) . '</a></td>' . "\n";
								$email_products_str .= '	<td class="product-details" valign="top" style="padding:5px;"><a href="' . HTTP_SERVER . '/index.php?main_page=product_info&products_id=' . $order_products->fields['products_id'] . '">' . $order_products->fields['products_model'] . '</a></td>' . "\n";
								$email_products_str .= '	<td class="product-details" valign="top" style="padding:5px;"><a href="' . HTTP_SERVER . '/index.php?main_page=product_info&products_id=' . $order_products->fields['products_id'] . '">' . $order_products->fields['products_name'] . '</a></td>' . "\n";
								$email_products_str .= '	<td class="product-details"><a href="' . HTTP_SERVER . '/index.php?main_page=product_info&products_id=' . $order_products->fields['products_id'] . '#reviewsWritemodule' . '" target="_blank"><img src="' . HTTP_SERVER . '/includes/templates/cherry_zen/buttons/english/button_write_review.gif" border="0"></a></td>' . "\n"; 
								$email_products_str .= '  </tr>' . "\n";
								$order_products->MoveNext();
							}
						$email_products_str .= '</table>' . "\n";
						}
					}
					
					//准备发邮件
					$html_msg['INTRO_STORE_NAME'] = STORE_NAME;
					$html_msg['REVIEWS_MAIL_CUSTOMER_NAME'] = $order_customer->fields['customers_name'];
					$html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_SHOPPING;
					$html_msg['REVIEWS_MAIL_DESCRIPTION'] = REVIEWS_MAIL_DESCRIPTION;
					$html_msg['REVIEWS_MAIL_PRODUCTS'] = $email_products_str;
					$html_msg['REVIEWS_MAIL_STR'] = $email_products_footer;
					$html_msg['REVIEWS_MAIL_FOOTER'] = $email_footer;
					if (!isset($ls_order_id) or $ls_order_id==''){
						$html_msg['EMAIL_MESSAGE_HTML'] = 'Dear ' . $ls_customer_name . '<br /><br />' . EMAIL_THANKS_FOR_SHOPPING . REVIEWS_MAIL_DESCRIPTION . ((isset($ls_reply_image_url_info) && $ls_reply_image_url_info != '') ? $ls_reply_image_url_info : '') . $email_products_str . REVIEWS_MAIL_FOOTER . $email_footer;
					}else{
				$html_msg['EMAIL_MESSAGE_HTML'] = 'Dear ' . $ls_customer_name . '<br /><br />' . EMAIL_THANKS_FOR_SHOPPING . REVIEWS_MAIL_DESCRIPTION . ((isset($ls_reply_image_url_info) && $ls_reply_image_url_info != '') ? $ls_reply_image_url_info : '') . '<br />' . '<div style="clear:both;">'
												  . REVIEWS_MAIL_STR . '</div><br /><br />' . $email_products_footer  . $email_products_str . REVIEWS_MAIL_FOOTER . $email_footer;
					}
					
					if (isset($ls_email) && $ls_email != '') {
						zen_mail($ls_customer_name, $ls_email, 'Thank You Very Much for Your Kindly Reviews on Doreenbeads!', 'Thank You Very Much for Your Kindly Reviews on Doreenbeads!', STORE_NAME, EMAIL_FROM, $html_msg, 'EMAIL_MESSAGE_HTML');
						//把已经发送邮件的reviews_id对应记录的 reviews_send_email状态改为1
						$db->Execute("update " . TABLE_REVIEWS . " set reviews_send_mail = 1 where reviews_id in (" . $ls_reviews_id_unite . ")");
						$messageStack->add_session(TEXT_REVIEWS_SEND_EAMIL_YES, 'success');
					}else{
						$messageStack->add_session(TEXT_REVIEWS_SEND_EAMIL_SQL_NO, 'error');
					}
					//zen_redirect(zen_href_link(FILENAME_REVIEWS, ((isset($_GET['page'])) ? ('page=' . $_GET['page']) : '')));
	      		}else{
	      			//没有记录，不发邮件
	      			$messageStack->add(TEXT_REVIEWS_SEND_EAMIL_SQL_NO, 'error');
	      		}
	      		
	      	}elseif ($res_reviews_customer->fields['reviews_send_mail'] == 1){
	      		//发过邮件，不再发(该条评论已经发送过email(当该条评论的reviews_send_mail=1时，就不需要再次去发邮件了),此处设计每条评论只能发一封email，但可以随时改变回复内容)
	      		//此处可以修改数据库的reviews_send_mail，以便再次发送邮件
	      		$messageStack->add(TEXT_REVIEWS_SEND_EAMIL_NO, 'caution');
	      	}else{
	      		$messageStack->add(TEXT_REVIEWS_SEND_EAMIL_SQL_NO, 'error');
	      	}
	      	zen_redirect(zen_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews_id));
      	}
      	break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td align="right"><form action="reviews.php" method="get" name="searchForm">
	<input name="k" value="<?php echo $_GET['k']; ?>" /><input type="submit" value="搜索" />
</form>
<br/>
<form action="reviews.php" method="get" name="languageForm">
<?php
	$langs = zen_get_languages();
	echo "语言：<select name='l'>";
	echo "<option value=''>所有</option>";
	foreach($langs as $lang) {
		echo "<option ".(isset($_GET['l'])&&$_GET['l']==$lang['id'] ? "selected='selected'" : "")." value=".$lang['id'].">".$lang['directory']."</option>"; 
    }
	echo "</select><br/>";
?>
	状态：<select name='s'>
		<option value="">所有</option>
		<option <?php echo isset($_GET['s'])&&$_GET['s']=='1' ? "selected='selected'" : ""; ?> value="1">开启</option>
		<option <?php echo isset($_GET['s'])&&$_GET['s']=='0' ? "selected='selected'" : ""; ?> value="0">关闭</option>
	</select><br/>
	<input type="submit" value="提交" />
</form>
                </td>
              </tr>
        </table></td>
      </tr>
<?php
  	if ($action == 'preview') {
  	//当action为预览状态时，页面呈现的内容 
    if (zen_not_null($_POST)) {
      $rInfo = new objectInfo($_POST);
    } else {
      $rID = zen_db_prepare_input($_GET['rID']);

      //把下面的多个sql语句合并，联合查询
      $reviews = $db->Execute("select r.reviews_id, r.customers_id,r.products_id, r.customers_name, r.date_added,
                                      r.last_modified, r.reviews_read, rd.reviews_text, r.reviews_rating, rd.reviews_reply_text 								from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                                where r.reviews_id = '" . (int)$rID . "'
                                  and r.reviews_id = rd.reviews_id
                             order by r.reviews_id asc");
      $products = $db->Execute("select products_image
                                  from " . TABLE_PRODUCTS . "
                                 where products_id = '" . (int)$reviews->fields['products_id'] . "'");

      $products_name = $db->Execute("select products_name
                                       from " . TABLE_PRODUCTS_DESCRIPTION . "
                                      where products_id = '" . (int)$reviews->fields['products_id'] . "'
                                        and language_id = '" . (int)$_SESSION['languages_id'] . "'");

      $rInfo_array = array_merge($reviews->fields, $products->fields, $products_name->fields);
      $rInfo = new objectInfo($rInfo_array);
    }
   
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->products_name; ?><br><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br><b><?php echo ENTRY_DATE; ?></b> <?php echo zen_date_short($rInfo->date_added); ?></td>
            <td class="main" align="right" valign="top"><?php echo zen_image(DIR_WS_CATALOG_IMAGES . $rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"'); ?></td>
          </tr>
        </table>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="main"><b><?php echo ENTRY_REVIEW; ?></b><br /><?php echo nl2br(zen_db_output(zen_break_string($rInfo->reviews_text, 15))); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><br /><b><?php echo TEXT_INFO_REVIEW_REPLY_BY_8SEASONS; ?></b><br /><?php echo nl2br(zen_db_output(zen_break_string($rInfo->reviews_reply_text, 15))); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_RATING; ?></b>&nbsp;<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $rInfo->reviews_rating . '.gif', sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating)); ?>&nbsp;<small>[<?php echo sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating); ?>]</small></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id, 'NONSSL') . '">' . zen_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
  } else {
  	//下面为action没有isset时，呈现的界面
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent"><?php echo 'Customers Email'; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMER_NAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_RATING; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo '语言' ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

// create search filter
    $order_by = " order by r.reviews_id desc";
	$where = '';
	if(isset($_GET['k']) && trim($_GET['k']) != ''){
		$keywords = zen_db_input(zen_db_prepare_input($_GET['k']));
		$where = " and (r.customers_name like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%' or p.products_model like '%" . $keywords . "%')";
	}
	if(isset($_GET['l']) && $_GET['l'] != ''){
		$where = "  and rd.languages_id = ".$_GET['l'];  	
	}
	if(isset($_GET['s']) && $_GET['s'] != ''){
		$where .= " and r.status = ".$_GET['s'];  	
	}
	
	$reviews_query_raw = ("select r.*, rd.*, pd.*, p.*, c.* from (" . TABLE_REVIEWS . " r 
							left join " . TABLE_CUSTOMERS . " c on r.customers_id = c.customers_id
							left join " . TABLE_REVIEWS_DESCRIPTION . " rd on r.reviews_id = rd.reviews_id
							left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on r.products_id = pd.products_id and pd.language_id ='" . (int)$_SESSION['languages_id'] . "' 
							left join " . TABLE_PRODUCTS . " p on p.products_id= r.products_id) " . " where r.products_id = p.products_id " . $where . $order_by);
    $reviews_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $reviews_query_raw, $reviews_query_numrows);
    $reviews = $db->Execute($reviews_query_raw);
    while (!$reviews->EOF) {
		$reviews_languages_code = $db->Execute("SELECT code FROM ".TABLE_LANGUAGES." WHERE languages_id = ".(int)$reviews->fields['languages_id']);

   if ((!isset($_GET['rID']) || (isset($_GET['rID']) && ($_GET['rID'] == $reviews->fields['reviews_id']))) && !isset($rInfo)) {
      	//haoran ; 下面的语句完全可以联合查询
        $reviews_text = $db->Execute("select r.reviews_read, r.customers_name,
                                             length(rd.reviews_text) as reviews_text_size, reviews_text, reviews_reply_text  
                                        from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                                       where r.reviews_id = '" . (int)$reviews->fields['reviews_id'] . "' 
                                       	 
                                         and r.reviews_id = rd.reviews_id");

        $products_image = $db->Execute("select products_image
                                          from " . TABLE_PRODUCTS . "
                                         where products_id = '" . (int)$reviews->fields['products_id'] . "'");


        $products_name = $db->Execute("select products_name
                                         from " . TABLE_PRODUCTS_DESCRIPTION . "
                                        where products_id = '" . (int)$reviews->fields['products_id'] . "'
                                          and language_id = '" . (int)$_SESSION['languages_id'] . "'");

        $reviews_average = $db->Execute("select (avg(reviews_rating) / 5 * 100) as average_rating
                                           from " . TABLE_REVIEWS . "
                                          where products_id = '" . (int)$reviews->fields['products_id'] . "'");
		$customers_id = $reviews_text->fields['customers_id'];
		$customers_email = $db->Execute("select customers_email_address
		                                   from " . TABLE_CUSTOMERS . "
		                                  where customers_id = '" . $customers_id . "'");

	
        $review_info = @array_merge($reviews_text->fields, $reviews_average->fields, $products_name->fields);
        $rInfo_array = @array_merge($reviews->fields, $review_info, $products_image->fields);
        $rInfo = new objectInfo($rInfo_array);
      }

      if (isset($rInfo) && is_object($rInfo) && ($reviews->fields['reviews_id'] == $rInfo->reviews_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] .(isset($_GET['searchLang']) ? '&searchLang='.$_GET['searchLang']:''). '&rID=' . $rInfo->reviews_id . '&action=preview') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] .(isset($_GET['searchLang']) ? '&searchLang='.$_GET['searchLang']:''). '&rID=' . $reviews->fields['reviews_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . zen_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews->fields['reviews_id'] . '&action=preview') . '">' . zen_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . zen_get_products_name($reviews->fields['products_id']) . '<font color="blue"> &nbsp;' . zen_get_products_model($reviews->fields['products_id']) . '</font>'; ?></td>
                <td class="dataTableContent"><?php echo ($_SESSION['show_customer_email'] ? $reviews->fields['customers_email_address'] : strstr($reviews->fields['customers_email_address'], '@', true) . '@'); ?></td>
                <td class="dataTableContent"><?php echo $reviews->fields['customers_name']; ?></td>
                <td class="dataTableContent" align="right"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews->fields['reviews_rating'] . '.gif'); ?></td>
                <td class="dataTableContent" align="right"><?php echo zen_date_short($reviews->fields['date_added']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $reviews_languages_code->fields['code']; ?></td>
                <td  class="dataTableContent" align="center">
<?php
      if ($reviews->fields['status'] == '1') {
        echo '<a href="' . zen_href_link(FILENAME_REVIEWS, 'action=setflag&flag=0&id=' . $reviews->fields['reviews_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON) . '</a>';
      } else {
        echo '<a href="' . zen_href_link(FILENAME_REVIEWS, 'action=setflag&flag=1&id=' . $reviews->fields['reviews_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF) . '</a>';
      }
?>
                </td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($rInfo)) && ($reviews->fields['reviews_id'] == $rInfo->reviews_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . zen_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'].(isset($_GET['searchLang']) ? '&searchLang='.$_GET['searchLang']:'') . '&rID=' . $reviews->fields['reviews_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
               </tr>
<?php
      $reviews->MoveNext();
    }
?>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $reviews_split->display_count($reviews_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                    <td class="smallText" align="right"><?php echo $reviews_split->display_links($reviews_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();

      if (isset($rInfo) && is_object($rInfo)) {
        $heading[] = array('text' => '<b>' . $rInfo->products_name . '</b>');
        
        $contents = array('form' => zen_draw_form('reviews_submit', FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=update', 'post'));
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_AUTHOR . ' ' . $rInfo->customers_name);
        $contents[] = array('text' => zen_info_image($rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT));
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . zen_date_short($rInfo->date_added));
        if (zen_not_null($rInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . zen_date_short($rInfo->last_modified));
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_RATING . ' ' . zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $rInfo->reviews_rating . '.gif'));
        $contents[] = array('text' => ENTRY_REVIEW . '<br />&nbsp;&nbsp;' . $rInfo->reviews_text);
        $contents[] = array('text' => TEXT_INFO_REVIEW_SIZE . ' ' . $rInfo->reviews_text_size . ' bytes');
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_REPLY . ' ' . zen_draw_textarea_field('reviews_reply_text', 'soft', '10', '5', stripslashes($rInfo->reviews_reply_text)));
       	
        $contents[] = array('align' => 'center', 'text' => zen_image_submit('button_update.gif', IMAGE_UPDATE));
        if ($rInfo->reviews_read > 0) $contents[] = array('text' => TEXT_INFO_REVIEW_READ . ' ' . $rInfo->reviews_read);
        $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_AVERAGE_RATING . ' ' . number_format($rInfo->average_rating, 2) . '%');
      }

    if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
