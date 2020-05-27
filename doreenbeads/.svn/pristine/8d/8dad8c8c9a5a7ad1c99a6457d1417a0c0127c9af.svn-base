<?php
/**
 * split_page_results Class.
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: split_page_results.php 3041 2006-02-15 21:56:45Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * Split Page Result Class
 * 
 * An sql paging class, that allows for sql reslt to be shown over a number of pages using  simple navigation system
 * Overhaul scheduled for subsequent release
 *
 * @package classes
 */
class splitPageResults extends base {
  var $sql_query, $number_of_rows, $current_page_number, $number_of_pages, $number_of_rows_per_page, $page_name;

 function splitPageResults($query, $max_rows, $count_key = '*', $page_holder = 'page', $debug = false, $xapian_data = '', $packing_slip_page = false) {
    global $db;

    $this->sql_query = $query;
    $this->page_name = $page_holder;

    if ($debug) {
      echo 'original_query=' . $query . '<br /><br />';
    }
    if (isset($_GET[$page_holder])) {
      $page = $_GET[$page_holder];
    } elseif (isset($_POST[$page_holder])) {
      $page = $_POST[$page_holder];
    } else {
      $page = '';
    }

    if (empty($page) || !is_numeric($page)) $page = 1;
    $this->current_page_number = $page;

    $this->number_of_rows_per_page = $max_rows;

    if(!$packing_slip_page){
		   if( strlen($xapian_data)>0 && is_numeric($xapian_data)){
		    	$this->number_of_rows = $xapian_data;
		    	$this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);
		   		if ($this->current_page_number > $this->number_of_pages) {
		      		$this->current_page_number = $this->number_of_pages;
		    	}
		    	if ($this->current_page_number < 1){
		    		$this->current_page_number = 1;
		    	}
		
		   }else{
		    $pos_to = strlen($this->sql_query);
		
		    $query_lower = strtolower($this->sql_query);
		    $pos_from = strpos($query_lower, ' from', 0);
		
		    $pos_group_by = strpos($query_lower, ' group by', $pos_from);
		    if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;
		
		    $pos_having = strpos($query_lower, ' having', $pos_from);
		    if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;
		
		    $pos_order_by = strpos($query_lower, ' order by', $pos_from);
		    if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;
		
		    if (strpos($query_lower, 'distinct') || strpos($query_lower, 'group by')) {
		      $count_string = 'distinct ' . zen_db_input($count_key);
		    } else {
		      $count_string = zen_db_input($count_key);
		    }
		    $count_query = "select count(" . $count_string . ") as total " .
		    substr($this->sql_query, $pos_from, ($pos_to - $pos_from));
		    if ($debug) {
		      echo 'count_query=' . $count_query . '<br /><br />';
		    }
		    $count = $db->Execute($count_query);
		
		    $this->number_of_rows = $count->fields['total'];
		    }
    }else{
    	$query_lower = strtolower($this->sql_query);
    	$count = $db->Execute($query_lower);
    
    	$this->number_of_rows = $count->RecordCount();
    }
     
    $this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);

    if ($this->current_page_number > $this->number_of_pages) {
      $this->current_page_number = $this->number_of_pages;
    }

    if ($this->current_page_number < 1){
    	$this->current_page_number = 1;
    }
    $offset = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

    // fix offset error on some versions
    if ($offset < 0) { $offset = 0; }

    $this->sql_query .= " limit " . $offset . ", " . $this->number_of_rows_per_page;
   }
  /* class functions */

  // display split-page-number-links
  function display_links($max_page_links, $parameters = '') {
    global $request_type;

    $display_links_string = '';

    $class = '';

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    // previous button - not displayed on first page
    if ($this->current_page_number > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;&nbsp;';

    // check if number_of_pages > $max_page_links
    $cur_window_num = intval($this->current_page_number / $max_page_links);
    if ($this->current_page_number % $max_page_links) $cur_window_num++;

    $max_window_num = intval($this->number_of_pages / $max_page_links);
    if ($this->number_of_pages % $max_page_links) $max_window_num++;

    // previous window of pages
    if ($cur_window_num > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>';

    // page nn button
    for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
      if ($jump_to_page == $this->current_page_number) {
        $display_links_string .= '&nbsp;<strong class="current">' . $jump_to_page . '</strong>&nbsp;';
      } else {
        $display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>&nbsp;';
      }
    }

    // next window of pages
    if ($cur_window_num < $max_window_num) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num) * $max_page_links + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>&nbsp;';

    // next button
    if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a>&nbsp;';

    if ($display_links_string == '&nbsp;<strong class="current">1</strong>&nbsp;') {
      return '&nbsp;';
    } else {
      return $display_links_string;
    }
  }

	// display split-page-number-links
	//	lvxiaoyong 1.30
	function display_links_new($max_page_links, $parameters = '') {
		global $request_type;
		$display_links_string = '';
		if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
		//bof 当前页大于1，显示Prev按钮
		if ($this->current_page_number > 1) {
			$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><ins class="left"></ins>' . TEXT_PREV . '</a>';
		}
		//eof
		//bof显示第一页
		if($this->current_page_number == 1){
			$display_links_string .= '<a rel="nofollow" class="current" href="javascript:void(0);">1</a>';
		}else{
			$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=1', $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, 1) . ' ">1</a>';
		}
		//eof
		
		if($this->number_of_pages <= 5){
			for ($jump_to_page = 2; $jump_to_page <= ($this->number_of_pages - 1); $jump_to_page++) {
				if ($jump_to_page == $this->current_page_number) {
					$display_links_string .= '<a rel="nofollow" class="current" href="javascript:void(0);">' . $jump_to_page . '</a>';
				} else {
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>';
				}
			}
		}else{
			if ($this->current_page_number > 3){
				if ($this->current_page_number == $this->number_of_pages){	//当前页 = 最后页
					$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 4), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 4)) . ' ">...</a>';
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 3), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 3)) . ' ">' . ($this->current_page_number - 3) . '</a>';
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 2)) . ' ">' . ($this->current_page_number - 2) . '</a>';
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 1)) . ' ">' . ($this->current_page_number - 1) . '</a>';					
				}elseif ($this->current_page_number == ($this->number_of_pages - 1)){	//当前页 = 倒数第二页
					$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 3), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 3)) . ' ">...</a>';
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 2)) . ' ">' . ($this->current_page_number - 2) . '</a>';
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 1)) . ' ">' . ($this->current_page_number - 1) . '</a>';					
				}else{
					$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 2)) . ' ">...</a>';
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 1)) . ' ">' . ($this->current_page_number - 1) . '</a>';
				}				
				if ($this->current_page_number < $this->number_of_pages){
					$display_links_string .= '<a rel="nofollow" class="current" href="javascript:void(0);">' . $this->current_page_number . '</a>';
				}
			}elseif ($this->current_page_number == 3){
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number - 1)) . ' ">' . ($this->current_page_number - 1) . '</a>';
				$display_links_string .= '<a rel="nofollow" class="current" href="javascript:void(0);">' . $this->current_page_number . '</a>';
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 1)) . ' ">' . ($this->current_page_number + 1) . '</a>';
				$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 2)) . ' ">...</a>';
			}elseif ($this->current_page_number == 2){
				$display_links_string .= '<a rel="nofollow" class="current" href="javascript:void(0);">' . $this->current_page_number . '</a>';
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 1)) . ' ">' . ($this->current_page_number + 1) . '</a>';
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 2)) . ' ">' . ($this->current_page_number + 2) . '</a>';
				$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 3), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 3)) . ' ">...</a>';
			}elseif ($this->current_page_number == 1){
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 1)) . ' ">' . ($this->current_page_number + 1) . '</a>';
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 2)) . ' ">' . ($this->current_page_number + 2) . '</a>';
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 3), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 3)) . ' ">' . ($this->current_page_number + 3) . '</a>';
				$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 4), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 4)) . ' ">...</a>';
			}
			if ($this->current_page_number <= ($this->number_of_pages - 3)){
				if ($this->current_page_number > 3){
					$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 1)) . ' ">' . ($this->current_page_number + 1) . '</a>';
					$display_links_string .= '<a rel="nofollow" style="border:0px solid #ff0000;" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 2)) . ' ">...</a>';
				}				
			}elseif ($this->current_page_number == ($this->number_of_pages - 2)){
				$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, ($this->current_page_number + 1)) . ' ">' . ($this->current_page_number + 1) . '</a>';
			}
		}
		//bof 显示最后页
		if($this->current_page_number == $this->number_of_pages){
			$display_links_string .= '<a rel="nofollow" class="current" href="javascript:void(0);">' . $this->number_of_pages . '</a>';
		}else{
			$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $this->number_of_pages) . ' ">' . $this->number_of_pages . '</a>';
		}
		//eof
		if ($this->current_page_number < $this->number_of_pages) {
			$display_links_string .= '<a rel="nofollow" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number + 1), $request_type) . '" title="' . PREVNEXT_TITLE_NEXT_PAGE . '">' . TEXT_NEXT . '<ins class="right"></ins></a>';
		}

		if ($this->number_of_pages <= 1) {
			return '&nbsp;';
		} else {
			return $display_links_string;
		}
	}

  // display number of total products found
  function display_count($text_output) {
    $to_num = ($this->number_of_rows_per_page * $this->current_page_number);
    if ($to_num > $this->number_of_rows) $to_num = $this->number_of_rows;

    $from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

    if ($to_num == 0) {
      $from_num = 0;
    } else {
      $from_num++;
    }

    if ($to_num <= 1) {
      // don't show count when 1
      return '';
    } else {
      return sprintf($text_output, $from_num, $to_num, $this->number_of_rows);
    }
  }
  
  function display_links_for_review($max_page_links, $parameters = '') {
  	global $request_type;
  
  	$display_links_string = '';
  	if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
  	
  	//bof 当前页大于1，显示Prev按钮
  	if ($this->current_page_number > 1) {
  		$display_links_string .= '<a pageid=' . ($this->current_page_number - 1) . ' href="javascript:void(0);"><ins class="left"></ins>' . TEXT_PREV . '</a>';
  	}
  	//eof
  	//bof显示第一页
  	if($this->current_page_number == 1){
  		$display_links_string .= '<a class="current" href="javascript:void(0);">1</a>';
  	}else{
  		$display_links_string .= '<a pageid=1 href="javascript:void(0);">1</a>';
  	}
  	//eof
  	
  	if($this->number_of_pages <= 5){
  		for ($jump_to_page = 2; $jump_to_page <= ($this->number_of_pages - 1); $jump_to_page++) {
  			if ($jump_to_page == $this->current_page_number) {
  				$display_links_string .= '<a class="current" href="javascript:void(0);">' . $jump_to_page . '</a>';
  			} else {
  				$display_links_string .= '<a pageid=' . $jump_to_page . ' href="javascript:void(0);">' . $jump_to_page . '</a>';
  			}
  		}
  	}else{
  		if ($this->current_page_number > 3){
  			if ($this->current_page_number == $this->number_of_pages){	//当前页 = 最后页
  				$display_links_string .= '<a style="border:0px solid #ff0000;" href="javascript:void(0);" pageid=' . ($this->current_page_number - 4) . '>...</a>';
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 3) . '>' . ($this->current_page_number - 3) . '</a>';
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 2) . '>' . ($this->current_page_number - 2) . '</a>';
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 1) . '>' . ($this->current_page_number - 1) . '</a>';
  			}elseif ($this->current_page_number == ($this->number_of_pages - 1)){	//当前页 = 倒数第二页
  				$display_links_string .= '<a style="border:0px solid #ff0000;"  href="javascript:void(0);" pageid=' . ($this->current_page_number - 3) . '>...</a>';
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 2) . '>' . ($this->current_page_number - 2) . '</a>';
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 1) . '>' . ($this->current_page_number - 1) . '</a>';
  			}else{
  				$display_links_string .= '<a style="border:0px solid #ff0000;"  href="javascript:void(0);" pageid=' . ($this->current_page_number - 2) . '>...</a>';
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 1) . '>' . ($this->current_page_number - 1) . '</a>';
  			}
  			if ($this->current_page_number < $this->number_of_pages){
  				$display_links_string .= '<a class="current" href="javascript:void(0);">' . $this->current_page_number . '</a>';
  			}
  		}elseif ($this->current_page_number == 3){
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number - 1) . '>' . ($this->current_page_number - 1) . '</a>';
  			$display_links_string .= '<a class="current" href="javascript:void(0);">' . $this->current_page_number . '</a>';
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 1) . '>' . ($this->current_page_number + 1) . '</a>';
  			$display_links_string .= '<a style="border:0px solid #ff0000;" href="javascript:void(0);" pageid=' . ($this->current_page_number + 2) . '>...</a>';
  		}elseif ($this->current_page_number == 2){
  			$display_links_string .= '<a class="current" href="javascript:void(0);">' . $this->current_page_number . '</a>';
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 1) . '>' . ($this->current_page_number + 1) . '</a>';
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 2) . '>' . ($this->current_page_number + 2) . '</a>';
  			$display_links_string .= '<a style="border:0px solid #ff0000;" href="javascript:void(0);" pageid=' . ($this->current_page_number + 3) . '>...</a>';
  		}elseif ($this->current_page_number == 1){
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 1) . '>' . ($this->current_page_number + 1) . '</a>';
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 2) . '>' . ($this->current_page_number + 2) . '</a>';
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 3) . '>' . ($this->current_page_number + 3) . '</a>';
  			$display_links_string .= '<a style="border:0px solid #ff0000;" href="javascript:void(0);" pageid=' . ($this->current_page_number + 4) . '>...</a>';
  		}
  		if ($this->current_page_number <= ($this->number_of_pages - 3)){
  			if ($this->current_page_number > 3){
  				$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 1) . '>' . ($this->current_page_number + 1) . '</a>';
  				$display_links_string .= '<a style="border:0px solid #ff0000;" href="javascript:void(0);" pageid=' . ($this->current_page_number + 2) . '>...</a>';
  			}  			
  		}elseif ($this->current_page_number == ($this->number_of_pages - 2)){
  			$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 1) . '>' . ($this->current_page_number + 1) . '</a>';
  		}
  	}
  	//bof 显示最后页
  	if($this->current_page_number == $this->number_of_pages){
  		$display_links_string .= '<a class="current" href="javascript:void(0);">' . $this->number_of_pages . '</a>';
  	}else{
  		$display_links_string .= '<a href="javascript:void(0);" pageid=' . $this->number_of_pages . '>' . $this->number_of_pages . '</a>';
  	}
  	//eof
  	if ($this->current_page_number < $this->number_of_pages) {
  		$display_links_string .= '<a href="javascript:void(0);" pageid=' . ($this->current_page_number + 1) . '>' . TEXT_NEXT . '<ins class="right"></ins></a>';
  	}
  	
  	if ($this->number_of_pages <= 1) {
  		return '&nbsp;';
  	} else {
  		return $display_links_string;
  	}
  }  
  
  function display_links_mobile($max_page_links, $parameters = '',$is_ajax_link = false) {
  	global $request_type;
  
  	$display_links_string = '';
  	
  	$ajax_link_class = $is_ajax_link ? ' ajax_page_link':'';
  	
  	$class = '';
  
  	if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
  
  	// previous button - not displayed on first page
  	if ($this->current_page_number > 1) {
  		$display_links_string .= '<a rel="nofollow" class="page_lt prev-page'.$ajax_link_class.'" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number - 1), $request_type) . '" title="' . PREVNEXT_TITLE_PREVIOUS_PAGE . '" page="'.($this->current_page_number - 1).'" ></a>';
  		//$display_links_string .= '<span class="splitPage">&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . zen_image(DIR_WS_TEMPLATE_IMAGES . "pre_page_arrow.png", "", "5", "8") . '&nbsp;' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;</span>';
  	}
  	if ($this->number_of_pages <= 1) {
  		return '&nbsp;';
  	}else{	//	1 < total page <= 5
  		//always show first page
  		//$display_links_string .= '<span class="orange">'.$this->current_page_number.'</span>/'.$this->number_of_pages;
  		$display_links_string .= '<span>'.$this->current_page_number.'/'.$this->number_of_pages.'</span>';
  	}
  
  	//next button
  	if ($this->current_page_number < $this->number_of_pages) {
  		$display_links_string .= '<a rel="nofollow" class="page_rt next-page'.$ajax_link_class.'" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' " page="'.($this->current_page_number + 1).'" ></a>';
  	}
  	return $display_links_string;
  
  }

    function display_links_mobile_for_shoppingcart($max_page_links, $parameters = '',$is_ajax_link = false) {
    global $request_type;
  
    $display_links_string = '';
    
    $ajax_link_class = $is_ajax_link ? ' ajax_page_link':'';
    
    $class = '';
  
    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
  
    // previous button - not displayed on first page
    if ($this->current_page_number > 1) {
      if ($ajax_link_class != '') {
        $display_links_string .= '<a pageid=' . ($this->current_page_number - 1) . ' rel="nofollow" class="page_lt'.$ajax_link_class.'" href="javascript:void(0);" title="' . PREVNEXT_TITLE_PREVIOUS_PAGE . '" page="'.($this->current_page_number - 1).'" ></a>';
      }else{
        $display_links_string .= '<a rel="nofollow" class="page_lt'.$ajax_link_class.'" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number - 1), $request_type) . '" title="' . PREVNEXT_TITLE_PREVIOUS_PAGE . '" page="'.($this->current_page_number - 1).'" ></a>';
      }
      
    }else{
      $display_links_string .= '<a rel="nofollow" class="page_lt page_grey'.$ajax_link_class.'" ></a>';
    }
    if ($this->number_of_pages <= 1) {
      return '&nbsp;';
    }else{  //  1 < total page <= 5
      //always show first page
      //$display_links_string .= '<span class="orange">'.$this->current_page_number.'</span>/'.$this->number_of_pages;
      $display_links_string .= '<span>'.$this->current_page_number.'/'.$this->number_of_pages.'</span><input type="hidden" name="thisPage" value="'.$this->current_page_number.'" />';
    }
  
    //next button
    if ($this->current_page_number < $this->number_of_pages) {
      if ($ajax_link_class != '') {
        $display_links_string .= '<a pageid=' . ($this->current_page_number + 1) . ' rel="nofollow" class="page_rt'.$ajax_link_class.'" href="javascript:void(0);" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' " page="'.($this->current_page_number + 1).'" ></a>';
      }else{
        $display_links_string .= '<a rel="nofollow" class="page_rt'.$ajax_link_class.'" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' " page="'.($this->current_page_number + 1).'" ></a>';
      }
      
    }else{
      $display_links_string .= '<a rel="nofollow" class="page_rt page_grey'.$ajax_link_class.'" ></a>';
    }
    return $display_links_string;
  
  }
}
?>