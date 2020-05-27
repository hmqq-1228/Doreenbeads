<?php

//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006 The zen-cart developers                           |
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
//  $Id: admin.php 4701 2006-10-08 01:09:44Z drbyte $
//
require ('includes/application_top.php');


$action = (isset ($_GET['action']) ? $_GET['action'] : '');
$date_now = date("Y-m-d H:i:s");

$cc_coupon_status = trim(zen_db_prepare_input($_GET['cc_coupon_status']));
$date_created_start = trim(zen_db_prepare_input($_GET['date_created_start']));
$date_created_end = trim(zen_db_prepare_input($_GET['date_created_end']));
$customers_email_address = trim(zen_db_prepare_input($_GET['customers_email_address']));
$admin_email_or_customers_email_address = trim(zen_db_prepare_input($_GET['admin_email_or_customers_email_address']));
$coupon_code = trim(zen_db_prepare_input($_GET['coupon_code']));

$temp_type = isset ($_GET['temp_type']) ? trim(zen_db_prepare_input($_GET['temp_type'])) : 'email';
$act_type = isset ($_GET['act_type']) ?  trim(zen_db_prepare_input($_GET['act_type']))  : 'email';

if (zen_not_null($action) && $action != "delete") {

    switch ($action) {
        case 'get_customers_coupon' :
            if($temp_type == 'id'){
                $download = 'file/template_coupon_customer_by_id.csv';
                $file_name = '通过ID给客户发送Coupon_' . date('Ymd') . '.csv';
            }else{
                $download = 'file/template_coupon_customer.csv';
                $file_name = '通过邮箱给客户发送Coupon_' . date('Ymd') . '.csv';
            }

            $file = fopen($download, "r");
            header("Content-type:text/html;charset=utf-8");
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: " . filesize($download));

            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-type: application/octetstream');
            } else {
                header('Content-Type: application/x-octet-stream');
            }
            header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
            echo fread($file, filesize($download));
            fclose($file);
            break;
        case 'send_customers_coupon' :
            if(!isset($_FILES['xls_file']) || (isset($_FILES['xls_file']) && empty($_FILES['xls_file']['name']))) {
                $messageStack->add_session('请选择文件!', 'error');
                zen_redirect(zen_href_link(FILENAME_COUPON_SEND, zen_get_all_get_params(array('action'))));
            }
            $xls_file = 'download/'.date("YmdHis").rand().'.csv';
            move_uploaded_file($_FILES['xls_file']['tmp_name'], $xls_file);

            $cnt=0;
            $n = 0;
            $coupon_data_str = '';
            $station_letter_customers = '';
            $admin_email = $_SESSION['admin_email'];
            $fp = fopen($xls_file, 'r');

            $error = "";
            while($data = fgetcsv($fp)){
                if($n++ == 0) continue;

                if($act_type == 'id'){
                    $customer_id = trim($data[0]);
                    if(empty($customer_id)) {
                        $error .=  '第' . $n . '行客户ID不能为空!<br/>';
                        continue;
                    }
                }else{
                    $email = trim($data[0]);
                    if(empty($email)) {
                        $error .=  '第' . $n . '行客户邮箱不能为空!<br/>';
                        continue;
                    }
                }



                $coupon = trim($data[1]);
                if(empty($coupon)) {
                    $error .=  '第' . $n . '行Coupon Code不能为空!<br/>';
                    continue;
                }

                if($act_type == 'id'){
                    $customer_query = $db->Execute('select customers_id from '.TABLE_CUSTOMERS.' where customers_id="'.intval(zen_db_prepare_input($customer_id)).'"');
                }else{
                    $customer_query = $db->Execute('select customers_id from '.TABLE_CUSTOMERS.' where customers_email_address="'.zen_db_prepare_input($email).'"');
                }

                if($customer_query->RecordCount()>0){
                    $coupon_query = $db->Execute('select coupon_id,coupon_type,coupon_amount,coupon_expire_date, coupon_number_of_times, day_after_add from '.TABLE_COUPONS.' where coupon_status=1 and coupon_code="'.zen_db_prepare_input($coupon).'"');
                    if($coupon_query->RecordCount()>0){
                        $cp_id = $coupon_query->fields['coupon_id'];
                        $insert = true;
                        if ($coupon_query->fields['coupon_number_of_times'] == 10) {
                            $coupon_customer = $db->Execute('select cc_id from ' . TABLE_COUPON_CUSTOMER . ' where cc_coupon_id='.$cp_id.' and cc_customers_id =' . $customer_query->fields['customers_id']);
                            if($coupon_customer->RecordCount() > 0){
                                $insert = false;
                                if($act_type == 'id'){
                                    $error .= '第' . $n . '行客户ID：' . $customer_id.' 已发送过 '. $coupon .'!<br/>';
                                }else{
                                    $error .= '第' . $n . '行客户邮箱：' . $email.' 已发送过 '. $coupon .'!<br/>';
                                }

                            }
                        }
                        if ($insert) {
                            if($coupon_query->fields['coupon_type'] == 'C'){
                                $coupon_data_str .= '(' . intval($coupon_query->fields['coupon_id']) . ' , ' . intval($customer_query->fields['customers_id']) . ' , ' . $coupon_query->fields['coupon_amount'] . ' , "' . date('Y-m-d H:i:s') . '" , "' . date('Y-m-d H:i:s', strtotime("+".intval($coupon_query->fields['day_after_add'])." day")) . '" , 10 , "' . $admin_email . '", now()) , ';
                            }else{
                                $coupon_data_str .= '( ' . intval($coupon_query->fields['coupon_id']) . ' , ' . intval($customer_query->fields['customers_id']) . ' , "" , null , null , 10 , "' . $admin_email . '", now() ) , ';
                            }

                            $station_letter_customers_str .= '( ' . intval($customer_query->fields['customers_id']) . ' , 1 , 10 , 10 , "' . $admin_email . '"  , now()) , ( ' . intval($customer_query->fields['customers_id']) . ' , 2 , 10 , 10 , "' . $admin_email . '"  , now()) , ';
                            $cnt++;
                        }

                    }else{
                        $error .=  '第' . $n . '行Coupon Code：' . $coupon.'不存在!<br/>';
                    }
                }else{
                    if($act_type == 'id'){
                        $error .=  '第' . $n . '行客户ID：' . $customer_id.'不存在!<br/>';
                    }else{
                        $error .=  '第' . $n . '行客户邮箱：' . $email.'不存在!<br/>';
                    }

                }
            }
            $coupon_data_str = substr($coupon_data_str, 0 , strlen($coupon_data_str) - 2);
            if($coupon_data_str != ''){
                $coupon_customer_sql = 'INSERT INTO ' . TABLE_COUPON_CUSTOMER . ' (cc_coupon_id , cc_customers_id , cc_amount , cc_coupon_start_time , cc_coupon_end_time , cc_coupon_status , admin_email_or_customers_email_address, date_created) VALUES ' . $coupon_data_str;
                $db->Execute($coupon_customer_sql);
            }
            $station_letter_customers_str = substr($station_letter_customers_str, 0 , strlen($station_letter_customers_str) - 2);
            if($station_letter_customers_str != ''){
                $station_letter_customers_sql = 'INSERT INTO ' . TABLE_STATION_LETTER_CUSTOMERS . ' ( customers_id , station_letter_id , station_letter_type , station_letter_status , admin_email , create_datetime ) VALUES ' . $station_letter_customers_str;
                $db->Execute($station_letter_customers_sql);
            }

            fclose($fp);
            unlink($xls_file);

            if(!empty($error)) {
                $messageStack->add_session($error, 'error');
            }
            if($cnt > 0) {
                $messageStack->add_session('成功发送条' . $cnt . '个Coupon!', 'success');
            }
            zen_redirect(zen_href_link(FILENAME_COUPON_SEND, zen_get_all_get_params(array('action'))));
            break;
        case 'delete_confirm' :
            $error = "";

            $cc_id = zen_db_prepare_input(trim($_GET['cc_id']));
            $sql = "select cc_coupon_status from " . TABLE_COUPON_CUSTOMER . " where cc_id= " . $cc_id;
            $query = $db->Execute($sql);
            if(!in_array($query->fields['cc_coupon_status'], array(10))) {
                $error .= '删除失败，只能删除未使用的Coupon!';
            }

            if(!empty($error)) {
                $messageStack->add_session($error, 'error');
                zen_redirect(zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action'))));
            }

            if ($error == false) {
                if (isset ($_GET['cc_id']))
                    $admins_id = zen_db_prepare_input($_GET['cc_id']);

                $sql_data_array = array (
                    'cc_coupon_status' => 40,
                    'admin_email_modified' => $_SESSION['admin_email'],
                    'date_modified' => 'now()'
                );

                zen_db_perform(TABLE_COUPON_CUSTOMER, $sql_data_array, 'update', "cc_id = '" . $cc_id . "'");

                zen_redirect(zen_href_link(FILENAME_COUPON_SEND, zen_get_all_get_params(array('action'))));

            } // end error check

            //echo $action;
            //	zen_redirect(zen_href_link(FILENAME_COUPON_SEND, (isset($_GET['page']) ? 'page=' . '&' : '') . 'cc_id=' . $admins_id));
            break;
        case 'save' :
            $coupon_discount = trim(zen_db_prepare_input($_GET['coupon_discount']));
            $coupon_name = trim(zen_db_prepare_input($_POST['coupon_name']));
            $coupon_code = str_replace(" ", "", zen_db_prepare_input($_POST['coupon_code']));
            $coupon_amount = trim(zen_db_prepare_input($_POST['coupon_amount']));
            $coupon_minimum_order = trim(zen_db_prepare_input($_POST['coupon_minimum_order']));
            $with_promotion = trim(zen_db_prepare_input($_POST['with_promotion']));
            $coupon_number_of_times = trim(zen_db_prepare_input($_POST['coupon_number_of_times']));
            $coupon_addable = trim(zen_db_prepare_input($_POST['coupon_addable']));
            $coupon_number_of_times_total = trim(zen_db_prepare_input($_POST['coupon_number_of_times_total']));
            $coupon_start_time_pickup = trim(zen_db_prepare_input($_POST['coupon_start_time_pickup']));
            $coupon_end_time_pickup = trim(zen_db_prepare_input($_POST['coupon_end_time_pickup']));
            $coupon_start_time = trim(zen_db_prepare_input($_POST['coupon_start_time']));
            $coupon_end_time = trim(zen_db_prepare_input($_POST['coupon_end_time']));
            $useful_life_type = trim(zen_db_prepare_input($_POST['useful_life_type']));
            $coupon_expire_date = trim(zen_db_prepare_input($_POST['coupon_expire_date']));
            $languages_id_str = trim(zen_db_prepare_input($_POST['languages_id_str']));

            $coupon_currency_code = $minimum_order_currency_code = "USD";
            $coupon_currency_value = $minimum_order_currency_value = $uses_per_user = $coupon_status = $with_vip = 1;
            $error = "";
            $coupon_vip = 0;
            $coupon_target = 3;
            if(empty($coupon_expire_date)) {
                $coupon_expire_date = 0;
            }
            if(empty($coupon_code)) {
                $error .= "请填写Coupon Code!<br/>";
            }
            if(empty($coupon_amount)) {
                $error .= "请填写Coupon面额!<br/>";
            }
            if(!is_numeric($coupon_amount)) {
                $error .= "Coupon面额只能是数字!<br/>";
            }
            if(empty($coupon_minimum_order)) {
                $error .= "请填写最低消费金额!<br/>";
            }
            if(!is_numeric($coupon_minimum_order)) {
                $error .= "最低消费金额只能是数字!<br/>";
            }
            if(empty($coupon_number_of_times)) {
                $error .= "请选择同一客户领取次数!<br/>";
            }
            if($coupon_addable == "") {
                $error .= "请选择是否允许外部领取!<br/>";
            }
            if($coupon_number_of_times_total == "") {
                $error .= "请填写总的领取次数!<br/>";
            }
            if(!empty($coupon_addable) && (empty($coupon_start_time_pickup) || empty($coupon_end_time_pickup))) {
                $error .= "选择允许外部领取后，请设置领取周期!<br/>";
            }
            if(empty($useful_life_type)) {
                $error .= "请选择有效期!<br/>";
            }
            $coupon_type = "C";
            if($useful_life_type == "10") {
                $coupon_type = "F";

                if(empty($coupon_start_time) || empty($coupon_end_time)) {
                    $error .= "选择时间范围，请设置开始时间和结束时间!<br/>";
                }
            }

            if($useful_life_type == "20") {
                if($coupon_expire_date == "") {
                    $error .= "请填写领取后多少天过期!<br/>";
                }
                $coupon_start_time = $coupon_end_time = "null";
            }

            $coupon_exist = $db->Execute('select cc_id from '. TABLE_COUPONS .' where coupon_code="'.$coupon_code.'" limit 1');
            if($coupon_exist->RecordCount() > 0){
                $error .= "Coupon Code已存在!<br/>";
            }

            if(!empty($error)) {
                $messageStack->add_session($error, 'error');
                zen_redirect(zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action', 'id')) . 'action=new'));
            } else {
                $save_sql_array = array(
                    'coupon_name' => $coupon_name,
                    'coupon_code' => $coupon_code,
                    'coupon_type' => $coupon_type,
                    'coupon_amount' => $coupon_amount,
                    'coupon_currency_code' => $coupon_currency_code,
                    'coupon_currency_value' => $coupon_currency_value,
                    'coupon_minimum_order' => $coupon_minimum_order,
                    'minimum_order_currency_code' => $minimum_order_currency_code,
                    'uses_per_user' => $uses_per_user,
                    'coupon_start_time' => $coupon_start_time,
                    'coupon_end_time' => $coupon_end_time,
                    'coupon_expire_date' => $coupon_expire_date,
                    'coupon_target' => $coupon_target,
                    'coupon_status' => $coupon_status,
                    'coupon_vip' => $coupon_vip,
                    'coupou_create_time' => 'now()',
                    'with_promotion' => $with_promotion,
                    'with_vip' => $with_vip,
                    'coupon_addable' => $coupon_addable,
                    'coupon_start_time_pickup' => $coupon_start_time_pickup,
                    'coupon_end_time_pickup' => $coupon_end_time_pickup,
                    'coupon_number_of_times' => $coupon_number_of_times,
                    'coupon_number_of_times_total' => $coupon_number_of_times_total,
                    'admin_email' => $_SESSION['admin_email']

                );
                //print_r($save_sql_array);exit;

                if ($cc_id > 0) {
                    $save_sql_array['admin_email_modified'] = $_SESSION['admin_email'];
                    $save_sql_array['date_modified'] = 'now()';
                    zen_db_perform(TABLE_COUPON_CUSTOMER, $save_sql_array, "update", "cc_id = " . $cc_id);

                }else{
                    //$save_sql_array['coupon_discount'] = $coupon_discount;
                    //$save_sql_array['activity_status'] =10;
                    //$save_sql_array['admin_email'] = $_SESSION['admin_email'];
                    //$save_sql_array['date_created'] = 'now()';
                    zen_db_perform(TABLE_COUPON, $save_sql_array);
                    $cc_id = zen_db_insert_id();
                    $languages_id_array = explode(",", $languages_id_str);
                    foreach($languages_id_array as $languages_value) {
                        $coupon_name = trim(zen_db_prepare_input($_POST['coupon_name_' . $languages_value]));
                        $coupon_description = trim(zen_db_prepare_input($_POST['coupon_description_' . $languages_value]));
                        if(!empty($coupon_name)) {
                            $description_sql_array = array(
                                'cc_id' => $cc_id,
                                'language_id' => $languages_value,
                                'coupon_name' => $coupon_name,
                                'coupon_description' => $coupon_description

                            );
                            zen_db_perform(TABLE_COUPON_DESCRIPTION, $description_sql_array);
                        }
                    }

                }

                $messageStack->add_session('保存成功!', 'success');
                zen_redirect(zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action', 'coupon_discount', 'id'))));
            }
            break;
    } // end switch
} else {

    $languages = zen_get_languages();
    $languages_plus = array(array('id' => '', 'text' => 'All'), array('id' => 999, 'text' => '全部站点'));

    $array_languages = array();
    $array_languages = array(array('id' => '', 'text' => 'All'), array('id' => 999, 'text' => '全部站点'));
    foreach($languages as $value) {
        array_push($array_languages, array('id' => $value['code'], 'text' => $value['name']));
    }

    $search_query = '';
    $search = zen_db_input(zen_db_prepare_input($_GET['search']));
    $activity_status = zen_db_input(zen_db_prepare_input($_GET['activity_status']));
    $coupon_discount = zen_db_input(zen_db_prepare_input($_GET['coupon_discount']));
    $activity_language = zen_db_input(zen_db_prepare_input($_GET['activity_language']));
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
        <script language="javascript" src="includes/jquery.js"></script>
        <script> window.lang_wdate='en'; </script><script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
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
                if (typeof _editor_url == "string") HTMLArea.replace('message_html');
            }
            // -->
            $(function() {
                $("#canbutton").click(function() {
                    window.history.back();
                });

                $(".jq_activity_amount_add").click(function() {
                    var row = $(".jq_activity_amount tr").eq(0).clone(true);
                    $(row).find("input").val("");
                    $(row).find(".jq_activity_amount_delete").show();
                    $(".jq_activity_amount").append(row);
                });

                $(".jq_activity_amount_delete").click(function() {
                    $(this).parent().parent().remove();
                });

                $(".jq_active_choose").click(function() {
                    var coupon_discount = $("#coupon_discount  option:selected").val();
                    if(coupon_discount == "0") {
                        alert("请选择要创建的Coupon类型!");
                    } else {
                        window.location.href = "<?php echo zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action', 'coupon_discount')) . 'action=new');?>&coupon_discount="+ coupon_discount;
                    }

                });

                $("input[type='checkbox']").click(
                    function(){
                        if($(this).attr("readonly") == "readonly") {
                            this.checked = !this.checked;}
                    }
                );

                $(".language_title").click(function(){
                    $(".jq_index_area").hide();
                    $("#jq_textarea_" + $(this).data("id")).show();

                    $(".language_title").removeClass("checked");
                    $(this).addClass("checked");

                });
            });

        </script>
        <style>

            .table_info{font-size:12px; font-family: Arial;width: 80%}
            .table_info tr{text-align: left;vertical-align: top;margin-bottom: 10px;line-height: 20px;}
            .table_info tr th{width:180px;}
            .table_info tr td br{}

            .table_desc{margin-left:30px;font-size: 12px; font-size:14px;}
            .table_desc tr{height:34px;}
            .table_desc tr th{width:150px;text-align: left;}
            .buttondiv{width: 300px;margin-left: 150px;}
            .buttondiv button{width:100px;}

            .normal_table tr td{text-align: center;}




            .simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
                border: 1px solid #656462;
                border-radius: 3px 3px 3px 3px;
                cursor: pointer;
                padding: 3px 20px;}
            .listshow{
                margin: 0;
                padding: 5px 10px;
            }
            #showpromotion{
                margin-top: 20px;
            }
            #showpromotion th{
                background: none repeat scroll 0 0 #D6D6CC;
                font-size: 13px;
                padding: 6px 10px 6px 15px;
                text-align: left;
            }
            #showpromotion th .red{
                color: #FF0000;
                font-weight: normal;
            }
            #showpromotion td{
                border-bottom: 1px dashed #CCCCCC;
            }
            .actionBut{
                display: table-cell;
                margin-bottom: 5px;
                width: 80px;
            }
            .promotionInput{
                border: 1px solid #888888;
                height: 20px;
                line-height: 20px;
                width: 160px;
            }
            .short{
                margin: 0 5px 0 20px;
                width: 50px;
                height: 24px;
                line-height: 24px;
            }
            .promotionName{
                float: right;
            }
            .promotionLang{
                float: left;
                line-height: 20px;
            }
            .promotionDiv{
                margin: 2px 0;
                overflow: hidden;
            }
            #fileDown{
                padding: 0 0 0 10px;
            }
            #fileDown p{
                font-size: 13px;
                font-weight: bold;
                margin: 5px 0;
            }
            #fileDown a{
                text-decoration: underline;
            }
            #fileDown a:hover{
                color:#ff6600;
            }
            #fileDown input{
                font-size:12px;cursor:pointer;
            }
            #promotion_total{
                margin-top: 15px;
                padding: 10px;
            }
            #promotion_total h2{
                font-size: 14px;
                margin: 8px 0;
            }
            .protecting .cal-TextBox{
                background: none repeat scroll 0 0 #FFFFFF;
                color: #6D6D6D;
            }
            #updatePro{
                font-weight:bold;
            }

            #promotion_info tr{
                height:40px;
            }

            .info_column_title{
                padding-right:5px;
                width:100px;
            }

            .info_column_content{
                padding-left:5px;
            }
            .info_red{
                color:red;
            }
            .Wdate{
                width:150px;
            }
            .language_title{
                display: inline-block;
                border: 1px solid #D0CCCC;
                width: 84px;
                text-align: center;
                vertical-align: middle;
                line-height: 25px;
                cursor: pointer;
                position: relative;
                background: white;
                top: 1px;
            }
            .checked{
                border-bottom:0px;
                font-weight:bold;
            }
        </style>
    </head>
    <body onLoad="init()">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->

    <?php if(empty($action) || $action == "delete") {?>
        <!-- body //-->
        <table border="0" width="100%" cellspacing="2" cellpadding="2">
            <tr>
                <!-- body_text //-->
                <td width="100%" valign="top">


                    <?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="pageHeading">Promotion > Coupon发送列表</td>
                            <td align="right">
                                <table border="0" width="40%" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="text-align:right; line-height:28px;">
                                            <?php

                                            echo zen_draw_form('search', FILENAME_COUPON_SEND, '', 'get', 'id="search_form"', true);
                                            echo '按Coupon状态筛选： ' . zen_draw_pull_down_menu('cc_coupon_status', array(array('id' => '', 'text' => 'All'), array('id' => '10', 'text' => '未使用'), array('id' => '20', 'text' => '已使用'), array('id' => '30', 'text' => '已过期'), array('id' => '40', 'text' => '已删除')), $cc_coupon_status) . '<br/>';
                                            echo '按创建时间筛选： <input class="Wdate" style="width:120px;" id="date_created_start" name="date_created_start" min-date="%y-%M-%d" datefmt="yyyy-MM-dd HH:mm:ss" value="' . $date_created_start . '" onclick="WdatePicker({startDate:\'%y-%M-%d 00:00:00\',dateFmt:\'yyyy-MM-dd HH:mm:ss\',alwaysUseStartDate:true});" type="text"> <input class="Wdate" style="width:120px;" id="date_created_end" name="date_created_end" min-date="%y-%M-%d" datefmt="yyyy-MM-dd HH:mm:ss" value="' . $date_created_end . '" onclick="WdatePicker({startDate:\'%y-%M-%d 00:00:00\',dateFmt:\'yyyy-MM-dd HH:mm:ss\',alwaysUseStartDate:true});" type="text"><br/>';
                                            echo zen_draw_input_field('customers_email_address', $customers_email_address, 'id="customers_email_address" placeholder="客户邮箱"') . '<br/>';
                                            echo zen_draw_input_field('admin_email_or_customers_email_address', $admin_email_or_customers_email_address, 'id="coupon_name" placeholder="操作人Email"') . '<br/>';
                                            echo zen_draw_input_field('coupon_code', $coupon_code, 'id="coupon_code" placeholder="Coupon Code"') . '<br/>';
                                            echo '<input type="submit" value="提交"><br/>';
                                            echo '</form>';

                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>

                    <?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td valign="top">

                                <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                    <tr class="dataTableHeadingRow">
                                        <td width="5%" class="dataTableHeadingContent">ID</td>
                                        <td width="20%" class="dataTableHeadingContent">客户姓名</td>
                                        <td width="20%" class="dataTableHeadingContent">客户ID</td>
                                        <td width="15%" class="dataTableHeadingContent">Coupon Code</td>
                                        <td width="7%" class="dataTableHeadingContent">面额</td>
                                        <td width="12%" class="dataTableHeadingContent">创建人</td>
                                        <td width="10%" class="dataTableHeadingContent">创建时间</td>
                                        <td width="6%" class="dataTableHeadingContent">状态</td>
                                        <td width="5%" class="dataTableHeadingContent" align="right">操作</td>
                                    </tr>

                                    <?php

                                    $search_query = '';
                                    $search_limit = ' and cc.date_created>=FROM_UNIXTIME(UNIX_TIMESTAMP()-(86400 * 90))';
                                    if(zen_not_null($cc_coupon_status)) {
                                        $search_query .= ' and cc.cc_coupon_status="' . $cc_coupon_status . '"';
                                    }

                                    if(zen_not_null($date_created_start)) {
                                        $search_query .= ' and cc.date_created>="' . $date_created_start . '"';
                                    }

                                    if(zen_not_null($date_created_end)) {
                                        $search_query .= ' and cc.date_created<="' . $date_created_end . '"';
                                    }

                                    if(zen_not_null($customers_email_address)) {
                                        $search_query .= ' and c.customers_email_address="' . $customers_email_address . '"';
                                        $search_limit = '';
                                    }

                                    if(zen_not_null($admin_email_or_customers_email_address)) {
                                        $search_query .= ' and cc.admin_email_or_customers_email_address="' . $admin_email_or_customers_email_address . '"';
                                        $search_limit = '';
                                    }

                                    if(zen_not_null($coupon_code)) {
                                        $search_query .= ' and co.coupon_code="' . $coupon_code . '"';
                                        $search_limit = '';
                                    }


                                    $para_sort = ' order by cc_id DESC';


                                    $admins_query_raw = "select cc.*, if(c.register_languages_id=6, concat(c.customers_lastname, ' ', c.customers_firstname), concat(c.customers_firstname, ' ', c.customers_lastname)) customers_name, customers_id, co.coupon_code, co.coupon_amount, co.coupon_minimum_order, co.with_promotion from " . TABLE_COUPON_CUSTOMER . " cc inner join " . TABLE_COUPONS . " co on co.coupon_id=cc.cc_coupon_id inner join " . TABLE_CUSTOMERS . " c on c.customers_id=cc.cc_customers_id where 1=1" . $search_limit . $search_query . $para_sort . "";
                                    $admins_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $admins_query_raw, $admins_query_numrows);
                                    $admins = $db->Execute($admins_query_raw);

                                    $date_now = date("Y-m-d H:i:s");

                                    while (!$admins->EOF) {
                                        if ((!isset ($_GET['cc_id']) || (isset ($_GET['cc_id']) && ($_GET['cc_id'] == $admins->fields['cc_id']))) && !isset ($adminInfo) && (substr($action, 0, 3) != 'new')) {
                                            $adminInfo = new objectInfo($admins->fields);
                                        }

                                        $likn_defail = zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action', 'cc_id')) . 'cc_id=' . $admins->fields['cc_id']);

                                        if (isset ($adminInfo) && is_object($adminInfo) && ($admins->fields['cc_id'] == $adminInfo->cc_id)) {
                                            echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseout="rowOutEffect(this)">' . "\n";
                                        } else {
                                            echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
                                        }

                                        $coupon_status = "未使用";
                                        if($admins->fields['cc_coupon_status'] == "20") {
                                            $coupon_status = "已使用";
                                        } else if($admins->fields['cc_coupon_status'] == "30") {
                                            $coupon_status = "已过期";
                                        } else if($admins->fields['cc_coupon_status'] == "40") {
                                            $coupon_status = "已删除";
                                        }


                                        ?>

                                        <td class="dataTableContent"><?php echo $admins->fields['cc_id']; ?></td>
                                        <td class="dataTableContent"><?php echo $admins->fields['customers_name']; ?></td>
                                        <td class="dataTableContent"><?php echo $admins->fields['customers_id']; ?></td>
                                        <td class="dataTableContent"><?php echo $admins->fields['coupon_code']; ?></td>
                                        <td class="dataTableContent"><?php echo "USD " . number_format($admins->fields['coupon_amount'], 2, ".", ""); ?></td>
                                        <td class="dataTableContent"><?php echo !empty($admins->fields['admin_email_or_customers_email_address']) ? $admins->fields['admin_email_or_customers_email_address'] : "/"; ?></td>
                                        <td class="dataTableContent"><?php echo $admins->fields['date_created']; ?></td>
                                        <td class="dataTableContent"><?php echo $coupon_status;?></td>
                                        <td class="dataTableContent" align="right">
                                            <?php echo $button_row_edit; ?>&nbsp;
                                            <?php
                                            /* echo '<a href="' . zen_href_link(FILENAME_COUPON_SEND, 'page=' . $_GET['page'] . 'cc_id=' . $admins->fields['cc_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>';*/
                                            ?>
                                            <?php if (isset($adminInfo) && is_object($adminInfo) && ($admins->fields['cc_id'] == $adminInfo->cc_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . $likn_defail . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?></td>
                                        </tr>

                                        <?php

                                        $admins->MoveNext();
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="9">

                                            <table border="0" width="100%" cellspacing="0" cellpadding="4">
                                                <tr>
                                                    <td class="smallText" valign="top"><?php echo $admins_split->display_count($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                                                    <td class="smallText" align="right"><?php echo $admins_split->display_links($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],zen_get_all_get_params(array('page'))); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="smallText" valign="top"></td>
                                                    <td class="smallText" align="right"></td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <?php

                            $heading = array ();
                            $contents = array ();

                            switch ($action) {
                                case 'delete' :
                                    $heading[] = array (
                                        'text' => '<b>ID:' . $adminInfo->cc_id . '</b>'
                                    );
                                    $contents[] = array (
                                        'text' => '确定要删除此条Coupon的发送记录？<br/>(删除后该Coupon在客户账户的状态将变为已删除)'
                                    );
                                    $contents[] = array (
                                        'text' => '<br><b>' . $adminInfo->coupon_name . '</b>'
                                    );
                                    $button_forbid = "";
                                    if(in_array($adminInfo->cc_coupon_status, array(10))) {
                                        $button_forbid = '<a href="' . zen_href_link(FILENAME_COUPON_SEND, zen_get_all_get_params(array('action', 'coupon_discount', 'cc_id')) . 'cc_id=' . $adminInfo->cc_id . '&action=delete_confirm') . '"><button style="width:96px;">确认删除</button></a>';
                                    }

                                    $button_cancel = '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_COUPON_SEND, zen_get_all_get_params(array('action', 'coupon_discount', 'cc_id')) . 'cc_id=' . $adminInfo->cc_id) . '"><button style="width:96px;">取消</button></a>';

                                    $contents[] = array (
                                        'align' => 'center',
                                        'text' => $button_forbid . $button_cancel
                                    );
                                    break;

                                /*-------------------------------------------------------------------------------------------------------------------------
                                    case 'delete':
                                    $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_ADMIN . '</b>');
                                    $contents = array('form' => zen_draw_form('delete_admin', FILENAME_COUPON_SEND, 'page=' . $_GET['page'] . '&cc_id=' . $adminInfo->cc_id . '&action=deleteconfirm'));
                                    $contents[] = array('text' => TEXT_DELETE_INTRO);
                                    $contents[] = array('text' => '<br><b>' . $adminInfo->keyword_chinese . '</b>');
                                    $contents[] = array('align' => 'center',
                                                        'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '<a href="' . zen_href_link(FILENAME_COUPON_SEND, 'page=' . $_GET['page'] . '&cc_id=' . $adminInfo->cc_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
                                    break;

                                */
                                default :
                                    //-------------------------------------------------------------------------------------------------------------------------
                                    if (isset ($adminInfo) && is_object($adminInfo)) {
                                        $activity_amount_section = json_decode($adminInfo->activity_amount_section, true);
                                        $activity_amount_section_str = "";
                                        if($adminInfo->coupon_discount == "20") {
                                            $activity_amount_section_str = $activity_amount_section[0]['amount'];
                                        } else {
                                            foreach($activity_amount_section as $activity_amount_section_value) {
                                                $activity_amount_section_str .= $activity_amount_section_value['discount'] . "% off " . $activity_amount_section_value['amount'] . ";";
                                            }
                                        }

                                        $coupon_status = "未使用";
                                        if($adminInfo->cc_coupon_status == "20") {
                                            $coupon_status = "已使用";
                                        } else if($adminInfo->cc_coupon_status == "30") {
                                            $coupon_status = "已过期";
                                        } else if($adminInfo->cc_coupon_status == "40") {
                                            $coupon_status = "已删除";
                                        }

                                        $heading[] = array (
                                            'text' => '<b>' . $adminInfo->customers_email_address . '</b>'
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>客户姓名:</b> ' . $adminInfo->customers_name
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>客户邮箱:</b> ' . $adminInfo->customers_email_address
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>Coupon Code:</b> ' . $adminInfo->coupon_code
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>面额:</b> USD ' . number_format($adminInfo->coupon_amount, 2, ".", "")
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>最低消费金额:</b> USD ' . number_format($adminInfo->coupon_minimum_order, 2, ".", "")
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>金额对象:</b> ' . (!empty($adminInfo->with_promotion) ? "商品总金额" : "正价商品总金额")
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>创建人:</b> ' . (!empty($adminInfo->admin_email_or_customers_email_address) ? $adminInfo->admin_email_or_customers_email_address : "/")
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>创建时间:</b> ' . $adminInfo->date_created
                                        );
                                        $contents[] = array (
                                            'text' => '<br/><b>状态:</b> ' . $coupon_status
                                        );

                                        if($adminInfo->cc_coupon_status == "40" && !empty($adminInfo->admin_email_modified)) {
                                            $contents[] = array (
                                                'text' => '<br/><b>删除人:</b> ' . $adminInfo->admin_email_modified
                                            );
                                            $contents[] = array (
                                                'text' => '<br/><b>删除时间:</b> ' . $adminInfo->date_modified
                                            );

                                        }

                                        $delete_button = "";
                                        if(in_array($adminInfo->cc_coupon_status, array(10))) {
                                            $button_forbid = '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_COUPON_SEND, zen_get_all_get_params(array('action', 'coupon_discount', 'cc_id')) . '&cc_id=' . $adminInfo->cc_id . '&action=delete') . '"><button style="width:96px;">删除</button></a>';
                                        }

                                        $contents[] = array (
                                            'align' => 'center',
                                            'text' => $button_edit . $button_forbid
                                        );
                                    }

                                    break;
                                //-------------------------------------------------------------------------------------------------------------------------
                            } // end switch action

                            if ((zen_not_null($heading)) && (zen_not_null($contents))) {
                                echo '<td width="25%" valign="top">' . "\n";
                                $box = new box;
                                echo $box->infoBox($heading, $contents);
                                echo '</td>' . "\n";
                            }
                            ?>

                        </tr>
                    </table>

                    <form enctype="multipart/form-data" method="post" action="<?php echo zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action')) . 'action=send_customers_coupon&act_type=email');?>">
            <tr style="line-height:38px; font-size:16px;">
                <td align="left" colspan="5" style="padding-left:26px;">
                    通过邮箱给客户发送Coupon：<input type="file" id="xls_file" name="xls_file"> <a href="<?php echo zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action')) . 'action=get_customers_coupon&temp_type=email');?>" target="_blank">下载EXCEL模板</a><br/>
                    <input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="提交" /><br/>
                </td>
            </tr>
            </form>

            <form enctype="multipart/form-data" method="post" action="<?php echo zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action')) . 'action=send_customers_coupon&act_type=id');?>">
                <tr style="line-height:38px; font-size:16px;">
                    <td align="left" colspan="5" style="padding-left:26px;">
                        通过ID给客户发送Coupon   ：<input type="file" id="xls_file" name="xls_file"> <a href="<?php echo zen_href_link(FILENAME_COUPON_SEND,zen_get_all_get_params(array('action')) . 'action=get_customers_coupon&temp_type=id');?>" target="_blank">下载EXCEL模板</a><br/>
                        <input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="提交" /><br/>
                    </td>
                </tr>
            </form>

            </td>
            <!-- body_text_eof //-->
            </tr>
        </table>
        <!-- body_eof //-->

    <?php }?>

    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <br>
    </body>
    </html>
    <?php require(DIR_WS_INCLUDES . 'application_bottom.php'); }?>