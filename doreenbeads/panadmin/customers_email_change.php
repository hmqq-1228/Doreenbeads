<?php
/** customers_email_change.php.php
  * jessa 2010-03-30
  */
require('includes/application_top.php');
//error_reporting(E_ALL);


$oem_id = zen_db_input($_GET['oem_id']);


$where = '1=1';
$email = (isset($_GET['email']) && $_GET['email'] != '') ? zen_db_input($_GET['email']) : '' ;
$from = (isset($_GET['from']) && $_GET['from'] != '') ? zen_db_input($_GET['from']) : '' ;
$customers_id = (isset($_GET['customers_id']) && $_GET['customers_id'] != '') ? zen_db_input($_GET['customers_id']) : '' ;

if ($email != '') {$where .= ' and (customers_email_address_old = "' . $email .'" or customers_email_address_new = "' . $email .'")';}
if ($from != '') {$where .= ' and website_code = ' . $from;}
if ($customers_id != ''){$where .= ' and customers_id = "' . $customers_id . '"';}

function getCustomersEmailChangeInfo($customers_email='', $where='1=1'){
  global $db;
  $orderby = '';
  if (empty($customers_email) || $customers_email == '') {
    $orderby = ' order by auto_id desc';
  }else{
    $where .= ' and (customers_email_address_old = "' . $customers_email .'" or customers_email_address_new = "' . $customers_email .'")';
  }
  $customers_email_address_sql = "select * from " . TABLE_CUSTOMERS_EMAIL_ADDRESS_CHANGE_LOG . ' where ' . $where . $orderby;
  //echo $customers_email_address_sql;
  $customers_email_address_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $customers_email_address_sql, $search_query_numrows);
  $customers_email_address_query = $db->Execute($customers_email_address_sql);
  //var_dump($customers_email_address_query);
  $customers_email_address_array = array();
  if ($customers_email_address_query->RecordCount() > 0){
      while (!$customers_email_address_query->EOF){
        $customers_email_address_array[] = $customers_email_address_query->fields;
        $customers_email_address_query->MoveNext();
      }
  }
  $return_array = array('sql'=>$customers_email_address_sql,'data'=>$customers_email_address_array);
  return $return_array;
}
//var_dump(getCustomersEmailChangeInfo());
$customers_email_address_function = $customers_email_address_array = array();
$customers_email_address_function = getCustomersEmailChangeInfo('', $where );
$customers_email_address_array = $customers_email_address_function['data'];
$customers_email_address_sql = $customers_email_address_function['sql'];
$customers_email_address_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $customers_email_address_sql, $search_query_numrows);

if (!isset($_GET['oem_id']) || (isset($_GET['oem_id']) && $_GET['oem_id'] == '')){
    $oem_id = $oem_sourcing_array[0]['oem_id'];
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/javascript/jscript_jquery.js"></script>
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

  function confirmDelete(){
   if(confirm('Are you sure to delete it?')){
     return true;
   }else{
      return false;
     }
    }
$(function(){
  $('#check_content').click(function(){
    var content = $('#content_info').val();
    if ($.trim(content).length <= 0) {
      alert('请输入处理结果');
      return false;
    }else{
      $('#add_content').submit();
    }
  });

  $('.show_content_textarea').click(function(){
    $('.content_textarea').show();
  });

  $('#cancel_content').click(function(){
    $('.content_textarea').hide();
  });
});

  // -->
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body bof -->
<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  <tr>
    <td class="pageHeading"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);?></td>
  </tr>
  <tr>
    <td class="pageHeading"><div style="float:left;">客户邮箱更换记录管理</div>

    <div style='float:right;font-size:12px;color:#000;text-align:right;'>
      <form action="customers_email_change.php" method="get" name="searchForm"> 
      状态：<select name='from' style="width:150px;">
          <option value="">所有</option>
          <option <?php echo isset($_GET['from'])&&$_GET['from']=='30' ? "selected='selected'" : ""; ?> value="30">W</option>
          <option <?php echo isset($_GET['from'])&&$_GET['from']=='40' ? "selected='selected'" : ""; ?> value="40">M</option>
        </select><br/><br/>
      
        邮箱：<input name="email" value="<?php echo $_GET['email']; ?>" placeholder="请输入客户邮箱"/ style="width:150px;"><br/><br/>
        
       客户ID：<input name="customers_id" value="<?php echo $_GET['customers_id']; ?>" placeholder="请输入客户ID"/ style="width:150px;"><br/>
        <input type="submit" value="提交" style="margin:7px 0;"  />
      </form>
    </div>

    </td>
</tr>
  <tr>
    <td>
    <?php 
    if ($action != 'addnew'){
  ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td style="width:75%; vertical-align:top">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" style="padding:5px 2px; width:5%;text-align:center;">ID</td>
              <td class="dataTableHeadingContent" style="padding:5px 2px; width:20%;text-align:center;">新邮箱</td>
              <td class="dataTableHeadingContent" style="padding:5px 2px; width:15%;text-align:center;">老邮箱</td>
              <td class="dataTableHeadingContent" style="padding:5px 2px; width:20%; text-align:center;">更改时间</td>
              <td class="dataTableHeadingContent" style="padding:5px 2px; width:5%; text-align:center;">更改环境（W OR M）</td>
            </tr>
            <?php
              for ($i = 0; $i < sizeof($customers_email_address_array); $i++){
            ?>
            <?php //if ($auto_id == $customers_email_address_array[$i]['auto_id']){ ?>
            <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
            <?php //} ?>
              <td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_email_address_array[$i]['auto_id']; ?></td>
              <td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_email_address_array[$i]['customers_email_address_new']; ?></td>
              <td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_email_address_array[$i]['customers_email_address_old']; ?></td>
              <td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_email_address_array[$i]['date_created']; ?></td>
              <td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_email_address_array[$i]['website_code'] == 30? 'W' : 'M' ; ?></td>
            </tr>
            <?php } ?>
          <td height="40" align="left" colspan="3"><?php echo $customers_email_address_split->display_count($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS);?></td>
          <td height="40" align="right" colspan="2"><?php echo $customers_email_address_split->display_links($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], $split_page_action);?></td>
          </table>
        </td>
      </tr>
    </table>
  <?php
    }
    ?>
    </td>
  </tr>
</table>
<!-- body eof -->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>