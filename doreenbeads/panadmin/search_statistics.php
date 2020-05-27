<?php
/** search_statistics.php
 * 新增文件，搜索统计报表
 * jessa 2010-03-30
 */
require('includes/application_top.php');
function exportToExcel($fileName = '', $headArr = [], $data = [])
{
    ini_set('memory_limit', '1024M'); //设置程序运行的内存
    ini_set('max_execution_time', 0); //设置程序的执行时间,0为无上限
    @ob_end_clean();  //清除内存
    ob_start();
    @header("Content-Type: text/csv");
    @header("Content-Disposition:filename=" . $fileName . '.csv');
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($fp, $headArr);
    $index = 0;
    foreach ($data as $item) {
        if ($index == 1000) { //每次写入1000条数据清除内存
            $index = 0;
            ob_flush();//清除内存
            flush();
        }
        $index++;
        fputcsv($fp, $item);
    }

    @ob_flush();
    flush();
    ob_end_clean();
    return;
}

$ls_where = '1 = 1';
/*if (isset($_GET['categories_id']) && $_GET['categories_id'] != ''){
    $ls_where = " sk_categories = " . (int)(trim($_GET['categories_id']));
    $split_page_action = 'categories_id=' . $_GET['categories_id'];
}else{
    $ls_where = '1 = 1';
    $split_page_action = 'categories_id=';
}*/
if (isset($_GET['lang']) && $_GET['lang'] != 'all' && $_GET['lang'] != '') {
    $ls_where = " sk.languages_id = " . (int)(trim($_GET['lang']));
    $split_page_action = 'lang=' . $_GET['lang'];
} else {
    $ls_where = '1 = 1';
    $split_page_action = 'lang=';
}
if (isset($_GET['search_date_from']) && $_GET['search_date_from'] != '') {
    $date_from = trim($_GET['search_date_from']);
    $ls_where .= " And sk.sk_search_date >= '" . $date_from . " 00:00:00'";
    $split_page_action .= '&search_date_from=' . $date_from;
}
if (isset($_GET['search_date_to']) && $_GET['search_date_to'] != '') {
    $date_to = trim($_GET['search_date_to']);
    $ls_where .= " And sk.sk_search_date <= '" . $date_to . " 23:59:59'";
    $split_page_action .= '&search_date_to=' . $date_to;
}
if ($_GET['search_date_from'] == '' && $_GET['search_date_to'] == '') {
    $date_from = date('Y-m-d', strtotime("-3 months", time()));
    $date_to = date('Y-m-d', strtotime("-1 day"));
    $ls_where .= " And sk.sk_search_date >= '" . $date_from . " 00:00:00'";
    $ls_where .= " And sk.sk_search_date <= '" . $date_to . " 23:59:59'";
    $split_page_action .= '&search_date_from=' . $date_from;
    $split_page_action .= '&search_date_to=' . $date_to;
}
if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $keyword = trim($_GET['keyword']);
    $ls_where .= " And sk.sk_key_word like '%" . $keyword . "%'";
    $split_page_action .= '&keyword=' . $keyword;
}
if (isset($_GET['correct_keyword']) && $_GET['correct_keyword'] != '') {
    $correct_keyword = trim($_GET['correct_keyword']);
    $ls_where .= " And sk.sk_key_word = '" . $correct_keyword . "'";
    $split_page_action .= '&correct_keyword=' . $correct_keyword;
}
if (isset($_GET['customer_id']) && $_GET['customer_id'] != '') {
    $customer_id = $db_slave->Execute("Select customers_id 
									   From " . TABLE_CUSTOMERS . "
									  Where customers_email_address = '" . trim($_GET['customer_id']) . "'");
    if ($customer_id->EOF) {
        $customer_id->fields['customers_id'] = '99999999999';
    }
    $ls_where .= " And sk.sk_user_id = " . (int)($customer_id->fields['customers_id']);
    $split_page_action .= '&customer_id=' . $_GET['customer_id'];
}

if (isset($_GET['countries_name']) && trim($_GET['countries_name']) != '') {
    $ls_where .= " And sk.sk_country_name = '" . trim($_GET['countries_name']) . "'";
    $split_page_action .= '&countries_name=' . $_GET['countries_name'];
}
if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS_REPORTS - MAX_DISPLAY_SEARCH_RESULTS_REPORTS;
if (!isset($_GET['action'])) {
    $search_query = "Select distinct sk_key_word, Count(sk_word_id) as search_cnt
						   From t_search_keyword sk
						  Where 1 = 1
					   Group By sk_key_word
					   Order By Count(sk_word_id) Desc";
    if (isset($ls_where)) $search_query = str_replace('1 = 1', $ls_where, $search_query);
    $search_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $search_query, $search_query_numrows);
    $search_result = $db_slave->Execute($search_query);
} else {
    if ($_GET['action'] == 'export') {
        @set_time_limit(0);
        @ini_set('memory_limit', '1024M');
        $search_query = "Select distinct sk_key_word, " . $date_from . ", " . $date_to . ", languages_id,  Count(sk_word_id) as search_cnt
					   From t_search_keyword sk
					  Where 1 = 1
				   Group By sk_key_word, languages_id
				   Order By sk_key_word, languages_id asc";
        if (isset($ls_where)) $search_query = str_replace('1 = 1', $ls_where, $search_query);

        $data = $db->Execute($search_query);

        while (!$data->EOF) {
            $temp[strtolower($data->fields['sk_key_word'])][$data->fields['languages_id']] += $data->fields['search_cnt'];

            $data->MoveNext();
        }
        $file_name = $date_from . '--' . $date_to . '-search统计';

        $header = array(
            '关键字',
            '开始时间',
            '结束时间',
            '英语',
            '德语',
            '俄语',
            '法语',
            '西语',
            '日语',
            '意语',
            '总计'
        );

        $data = array();
        foreach ($temp as $key => $item) {
            $data[] = array(
                str_replace(',', ' ', $key),
                $date_from,
                $date_to,
                (isset($item[1]) ? $item[1] : 0),
                (isset($item[2]) ? $item[2] : 0),
                (isset($item[3]) ? $item[3] : 0),
                (isset($item[4]) ? $item[4] : 0),
                (isset($item[5]) ? $item[5] : 0),
                (isset($item[6]) ? $item[6] : 0),
                (isset($item[7]) ? $item[7] : 0),
                $item[1] + $item[2] + $item[3] + $item[4] + $item[5] + $item[6] + $item[7]
            );
        }

        exportToExcel($file_name, $header, $data);

        exit;
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
        <link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
        <script language="javascript" src="includes/menu.js"></script>
        <script language="javascript" src="includes/general.js"></script>
        <script language="javascript" src="includes/jquery.js"></script>
        <?php echo "<script> window.lang_wdate='" . $_SESSION['languages_code'] . "'; </script>"; ?>
        <script type="text/javascript"
                src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
        <!-- <script language="javascript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script> -->
        <!-- /*<script language="javascript">var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "search_date", "search_date_from","btnDate1","<?php echo $date_from; ?>",scBTNMODE_CUSTOMBLUE);
  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "search_date", "search_date_to","btnDate2","<?php echo $date_to; ?>",scBTNMODE_CUSTOMBLUE);
//</script>*/ -->
        <script type="text/javascript">
            <!--
            function init() {
                cssjsmenu('navbar');
                if (document.getElementById) {
                    var kill = document.getElementById('hoverJS');
                    kill.disabled = true;
                }
                if (typeof _editor_url == "string") HTMLArea.replaceAll();
            }

            $('.so-BtnLink img').live('click', function () {
                var _left = $(this).offset().left;
                var _top = $(this).offset().top + 17;
                if (_left > 1220) {
                    $('#spiffycalendar').css({left: '1220px', top: (_top + 'px')});
                }
                ;

            });

            function formSubmit(obj) {
                var email = $('input[name=customer_id]').val();
                if (email == '') {
                    alert('邮箱不能为空');
                    return;
                }
                ;
                var reg = /\w+[@]{1}\w+[.]\w+/;
                if (!reg.test(email)) {
                    alert('邮箱格式不合法');
                    return;
                }
                ;
                $('#' + obj).submit();

            }

            // -->
        </script>
    </head>
    <body onLoad="init()">
    <div id="spiffycalendar" class="text"></div>
    <?php require(DIR_WS_INCLUDES . 'header.php');
    $language = $db_slave->Execute("select * from t_languages order by sort_order");
    ?>
    <!--bof body-->
    <?php if (isset($_GET['action']) && $_GET['action'] == 'view_info') { ?>
        <?php
        $split_page_action .= '&action=' . $_GET['action'];
        if (isset($_GET['customers_status']) && $_GET['customers_status'] == 10) {
            $customers_status = 10;
            $ls_where .= " And sk.sk_user_id = 0";
            $split_page_action .= '&customers_status=' . $customers_status;
        } elseif ((isset($_GET['customers_status']) && $_GET['customers_status'] == 20) || (!isset($_GET['customers_status']) || empty($_GET['customers_status']))) {
            $customers_status = 20;
            $ls_where .= " And sk.sk_user_id > 0";
            $split_page_action .= '&customers_status=' . $customers_status;
        }

        if (isset($_GET['customers_status']) && trim($_GET['customers_status'] == 10)) {
            $keyword_info_query = "select distinct sk.sk_country_name, count(sk.sk_word_id) as `times` from " . TABLE_SEARCH_KEYWORD . " sk where 1 = 1 Group By sk.sk_country_name  ORDER BY times Desc ";
        } else {
            if (isset($_GET['customer_name']) && trim($_GET['customer_name']) != '') {
                $customer_name = trim($_GET['customer_name']);
                $ls_where .= " And (sk.customers_name like '%" . $customer_name . "%' or sk.customers_email_address like '%" . $customer_name . "%')";
                $split_page_action .= '&customer_name=' . $customer_name;
                $keyword_info_query = "Select distinct sk.sk_user_id, sk.customers_email_address, sk.customers_name, zc.countries_name, count(sk.sk_word_id) AS `times`, sk.sk_key_word
			   From " . TABLE_SEARCH_KEYWORD . " sk 
			   left JOIN  " . TABLE_CUSTOMERS . " c on c.customers_id = sk.sk_user_id
				LEFT JOIN " . TABLE_COUNTRIES . " zc on c.customers_country_id = zc.countries_id
			  Where 1 = 1 
		    Group By sk.sk_user_id
		    Order By Count(sk_word_id) Desc";
            } else {
                $keyword_info_query = "Select distinct sk.sk_user_id, c.customers_email_address, sk.customers_name, zc.countries_name, count(sk.sk_word_id) AS `times`, sk.sk_key_word
					   From " . TABLE_SEARCH_KEYWORD . " sk 
					   left JOIN " . TABLE_CUSTOMERS . " c on c.customers_id = sk.sk_user_id
						LEFT JOIN " . TABLE_COUNTRIES . " zc on c.customers_country_id = zc.countries_id
					  Where 1 = 1 and sk.sk_key_word LIKE '%" . $keyword . "%'
				    Group By sk.sk_user_id
				    Order By Count(sk_word_id) Desc";
            }

        }


        if (isset($ls_where)) $keyword_info_query = str_replace('1 = 1', $ls_where, $keyword_info_query);
        $keyword_info_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $keyword_info_query, $search_query_numrows);
        $keyword_info_result = $db_slave->Execute($keyword_info_query);
        ?>
        <?php echo zen_draw_form('search_date', 'search_statistics.php', 'action=view_info', 'get', 'id=info_table') ?>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style='margin-top:10px;'>
            <tr>
                <td colspan="<?php echo $_GET['customers_status'] == 10 ? 2 : 1 ?>" style="padding:5px 0px;"><h2>Search
                        Statistics >><?php echo $_GET['correct_keyword'] ?></h2><input type="hidden"
                                                                                       value="<?php echo $_GET['correct_keyword'] ?>"
                                                                                       name="correct_keyword"></td>
                <td>客户种类:
                    <select name="customers_status" onChange="document.getElementById('info_table').submit()">
                        <option value="20" <?php echo $_GET['customers_status'] == 20 ? 'selected' : '' ?>>已登录</option>
                        <option value="10" <?php echo $_GET['customers_status'] == 10 ? 'selected' : '' ?>>未登录</option>
                    </select>
                </td>
                <td colspan="2" align="right">
                    <p>语种: <select name="lang" id="lang" style="width:125px"
                                   onChange="document.getElementById('info_table').submit()">
                            <option value="all" <?php echo $_GET['lang'] == 'all' ? 'selected' : '' ?>>all</option>
                            <?php while (!$language->EOF) { ?>
                                <option value="<?php echo $language->fields['languages_id']; ?>" <?php echo $_GET['lang'] == $language->fields['languages_id'] ? 'selected' : '' ?>><?php echo $language->fields['name']; ?></option>
                                <?php $language->MoveNext();
                            } ?>
                        </select></p>
                    <p width="90%" style="font-weight:bold;">按日期筛选：from
                        <!-- <script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="yyyy-MM-dd";</script> to： <script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="yyyy-MM-dd";</script> -->
                        <?php
                        echo str_replace("<input", "<input class='Wdate' style='width:125px;'", zen_draw_input_field('search_date_from', (!isset($_GET['search_date_from']) && $_GET['search_date_from'] == '' && $_GET['search_date_to'] == '') ? date('Y-m-d', strtotime("-3 months")) : $_GET['search_date_from'], 'onClick="WdatePicker();"  '));
                        ?>
                        to
                        <?php
                        echo str_replace("<input", "<input class='Wdate' style='width:125px;'", zen_draw_input_field('search_date_to', (!isset($_GET['search_date_to']) && $_GET['search_date_to'] == '' && $_GET['search_date_from'] == '') ? date('Y-m-d', strtotime("-1 day")) : $_GET['search_date_to'], 'onClick="WdatePicker();"  '));
                        ?>
                    </p>
                    <?php if (isset($_GET['customers_status']) && trim($_GET['customers_status'] == 10)) { ?>
                        <p>
                            搜索:&nbsp;<?php echo zen_draw_input_field('countries_name', (isset($_GET['countries_name']) && $_GET['countries_name'] != '') ? $_GET['countries_name'] : '', 'size="18" placeholder="国家"'); ?></p>
                    <?php } else { ?>
                        <p>
                            搜索:&nbsp;<?php echo zen_draw_input_field('customer_name', (isset($_GET['customer_name']) && $_GET['customer_name'] != '') ? $_GET['customer_name'] : '', 'size="18" placeholder="客户姓名、邮箱"'); ?></p>
                    <?php } ?>
                    <p>
                        <button type="submit">submit</button>
                    </p>
                    <input type="hidden" value="view_info" name="action"/>
                </td>
            </tr>
            <?php if (isset($_GET['customers_status']) && trim($_GET['customers_status'] == 10)) { ?>
                <tr class="dataTableHeadingRow">
                    <td width="20%" height="25" class="dataTableHeadingContent">IP地址</td>
                    <td></td>
                    <td></td>
                    <td width="20%" height="25" class="dataTableHeadingContent">搜索次数</td>
                    <td></td>
                    <td></td>
                </tr>
                <?php while (!$keyword_info_result->EOF) { ?>
                    <tr class="dataTableRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)">
                        <td height="25"><?php echo $keyword_info_result->fields['sk_country_name'] != '' ? $keyword_info_result->fields['sk_country_name'] : '/'; ?></td>
                        <td></td>
                        <td></td>
                        <td height="25"><?php echo $keyword_info_result->fields['times']; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php $keyword_info_result->MoveNext();
                } ?>
            <?php } else { ?>
                <tr class="dataTableHeadingRow">
                    <td width="20%" height="25" class="dataTableHeadingContent">customers name</td>
                    <td width="20%" height="25" class="dataTableHeadingContent">customers email</td>
                    <td width="20%" height="25" class="dataTableHeadingContent">国家</td>
                    <td width="10%" height="25" class="dataTableHeadingContent">搜索次数</td>
                </tr>
                <?php while (!$keyword_info_result->EOF) { ?>
                    <tr class="dataTableRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)">
                        <td height="25"><?php echo $keyword_info_result->fields['customers_name'] != '' ? $keyword_info_result->fields['customers_name'] : '/'; ?></td>
                        <td height="25"><?php echo $keyword_info_result->fields['customers_email_address'] != '' ? $keyword_info_result->fields['customers_email_address'] : '/'; ?></td>
                        <td height="25"><?php echo $keyword_info_result->fields['countries_name'] != '' ? $keyword_info_result->fields['countries_name'] : '/'; ?></td>
                        <td height="25"><?php echo $keyword_info_result->fields['times']; ?></td>
                    </tr>
                    <?php $keyword_info_result->MoveNext();
                } ?>
            <?php } ?>


        </table>
        </form>
        <tr>
            <td height="40"
                align="left"><?php echo $keyword_info_split->display_count($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS); ?></td>
            <td height="40"
                align="right"><?php echo $keyword_info_split->display_links($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], $split_page_action); ?></td>
        </tr>
    <?php } else { ?>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" style="padding-top:15px; padding-bottom:8px;">
                    <?php echo zen_draw_form('search_date', 'search_statistics.php', 'action=filter_search', 'get', 'id=main_table') ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
                        <tr>
                            <?php if (!(isset($_GET['customer_id']) && $_GET['customer_id'] != '')) { ?>
                                <td colspan="3" class="pageHeading"
                                    style="padding:5px 0px;"><?php echo HEADING_TITLE; ?></td>
                            <?php } else { ?>
                                <td colspan="3" style="padding:5px 0px;"><h2>Search Statistics >></h2>
                                    <p><font size="4"><?php echo $_GET['customer_id'] ?></font></p><input type="hidden"
                                                                                                          value="<?php echo $_GET['customer_id'] ?>"
                                                                                                          name="customer_id">
                                </td>
                            <?php } ?>
                            <td align="right">
                                <p>语种: <select name="lang" id="lang" style="width:125px"
                                               onChange="document.getElementById('main_table').submit()">
                                        <option value="all" <?php echo $_GET['lang'] == 'all' ? 'selected' : '' ?>>all
                                        </option>
                                        <?php while (!$language->EOF) { ?>
                                            <option value="<?php echo $language->fields['languages_id']; ?>" <?php echo $_GET['lang'] == $language->fields['languages_id'] ? 'selected' : '' ?>><?php echo $language->fields['name']; ?></option>
                                            <?php $language->MoveNext();
                                        } ?>
                                    </select></p>
                                <p width="90%" style="font-weight:bold;">按日期筛选：from
                                    <!-- <script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="yyyy-MM-dd";</script> to： <script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="yyyy-MM-dd";</script> -->
                                    <?php
                                    echo str_replace("<input", "<input class='Wdate' style='width:125px;'", zen_draw_input_field('search_date_from', (!isset($_GET['search_date_from']) && $_GET['search_date_from'] == '' && $_GET['search_date_to'] == '') ? date('Y-m-d', strtotime("-3 months")) : $_GET['search_date_from'], 'onClick="WdatePicker();"  '));
                                    ?>
                                    to
                                    <?php
                                    echo str_replace("<input", "<input class='Wdate' style='width:125px;'", zen_draw_input_field('search_date_to', (!isset($_GET['search_date_to']) && $_GET['search_date_to'] == '' && $_GET['search_date_from'] == '') ? date('Y-m-d', strtotime("-1 day")) : $_GET['search_date_to'], 'onClick="WdatePicker();"  '));
                                    ?>
                                </p>
                                <p>
                                    keyword:&nbsp;<?php echo zen_draw_input_field('keyword', (isset($_GET['keyword']) && $_GET['keyword'] != '') ? $_GET['keyword'] : '', 'size="18"'); ?></p>

                                <p>
                                    <button type="submit" name="filter_submit" value="submit">submit</button>
                                </p>
                            </td>
                        </tr>
                    </table>
                    </form>
                    <?php if (!(isset($_GET['customer_id']) && $_GET['customer_id'] != '')) {
                        echo zen_draw_form('customer_submit', 'search_statistics.php', 'action=customer_search', 'get', 'id=customer_submit') ?>
                        <table align="right">
                            <tr align="right">
                                <td>
                                    <p>
                                        Customer:&nbsp;<?php echo zen_draw_input_field('customer_id', (isset($_GET['customer_id']) && $_GET['customer_id'] != '') ? $_GET['customer_id'] : '', 'size="18"'); ?></p>
                                    <p>
                                        <button onClick="formSubmit('customer_submit');return false;"
                                                name="customer_submit" value="customer_submit">搜索
                                        </button>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        </form>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"><a
                            href="<?php echo zen_href_link(FILENAME_SEARCH_STATISTIC, zen_get_all_get_params(array('action')) . '&action=export') ?>"><?php echo zen_image_button('button_export_cn.gif') ?></a>
                </td>
            </tr>
            <tr class="dataTableHeadingRow">
                <td width="35%" height="25" class="dataTableHeadingContent"><?php echo SEARCH_KEYWORDS; ?></td>
                <td width="25%" height="25" class="dataTableHeadingContent"><?php echo SEARCH_TIMES; ?></td>
                <?php if (!(isset($_GET['customer_id']) && $_GET['customer_id'] != '')) { ?>
                    <td class="dataTableHeadingContent" width="10%" align="left"><?php echo ACTION; ?></td>
                <?php } ?>
            </tr>
            <?php
            while (!$search_result->EOF) {
                ?>
                <tr class="dataTableRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)">
                    <td height="25"><strong><?php echo $search_result->fields['sk_key_word']; ?></strong></td>
                    <td height="25"><?php echo $search_result->fields['search_cnt']; ?></td>
                    <?php if (!(isset($_GET['customer_id']) && $_GET['customer_id'] != '')) { ?>
                        <td class="dataTableContent"
                            align="left"><?php echo '<a href="' . zen_href_link(FILENAME_SEARCH_STATISTIC, zen_get_all_get_params(array('page')) . 'page=&correct_keyword=' . $search_result->fields['sk_key_word']) . '&action=view_info&lang=' . $_GET['lang'] . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';; ?></td>
                    <?php } ?>
                </tr>
                <?php
                $search_result->MoveNext();
            }
            ?>
            <tr>
                <td height="40"
                    align="left"><?php echo $search_split->display_count($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS); ?></td>
                <td height="40"
                    align="right"><?php echo $search_split->display_links($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], $split_page_action); ?></td>
            </tr>
        </table>
    <?php } ?>
    <!--eof body-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <br>
    </body>
    </html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>