<?php
require($template->get_template_dir('tpl_livehelp.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_livehelp.php');
      $title =  '<label>Live Help</label>';
      $title_link = false;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
?>
