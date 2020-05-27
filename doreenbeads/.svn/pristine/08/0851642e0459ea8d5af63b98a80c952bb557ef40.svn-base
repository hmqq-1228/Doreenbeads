<?php
/**
 * �����ļ�
 * �߿�����ʾ�˿͵�����
 * testimonial.php
 * jessa 2010-06-17
 */

  $show_testimonial = false;
  
  $testimonial_query = "Select tm_id
  						  From " . TABLE_TESTIMONIAL . "
  						 Where tm_status = 1
  					  Order By tm_date_added Desc, tm_id Desc
  					     Limit 0, 2";
  $testimonial = $db->Execute($testimonial_query);

  if ($testimonial->RecordCount() > 0){
  	$show_testimonial = true;
  	$show_testimonial_boxes_array = array();
  	while (!$testimonial->EOF){
	  	$testimonial_id = $testimonial->fields['tm_id'];
	  	$testimonial_info_boxes = zen_get_testimonial_info($testimonial_id);
	  	$show_testimonial_boxes_array[] = array('content' => $testimonial_info_boxes['content'],
	  											'customer_name' => $testimonial_info_boxes['customer_name']);
	  	$testimonial->MoveNext();
  	}
  	
  	require($template->get_template_dir('tpl_testimonial.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_testimonial.php');
  }
?>