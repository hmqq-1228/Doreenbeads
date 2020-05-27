<?php 
	require(DIR_WS_MODULES . zen_get_module_directory('clearance.php'));
?>
<?php 

if(sizeof($category_content)>0){
	
	foreach ($category_content as $name=>$vals){
		$category_info=explode('---', $name);
		echo "<div class='clearance_cate_div'>";
		echo '<div class="clearance_cate_title"><span class="clearance_cate_name">'.$category_info[0].'</span>'.'
		<span class="clearance_cate_href"><span>&gt;</span><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$category_info[1]).'">'.sprintf(TEXT_CLEARANCE_CATE_HREF,$category_info[0]).'</span></a></div>';
		
		?>
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="clear:both;">
	<?php 
	 for($row=0;$row<sizeof($vals);$row++) {
   // $params = "";
    //if (isset($vals[$row]['params'])) $params .= ' ' . $vals[$row]['params'];
?>
<tr>
<?php
    for($col=0;$col<sizeof($vals[$row]);$col++) {
		 //$col_width = str_replace("50", "48", $col_width);
	     //$col_width = str_replace("33", "31", $col_width);
     if (isset($vals[$row][$col]['text'])) {
    echo '<td width="'. $vals[$row][$col]['width'] .'" align="center" valign="top"><div style="position:relative;width:130px;">' . $vals[$row][$col]['text'] .  '</div><input type="hidden" id="hide_pid_'.$vals[$row][$col]['product_id'].'" value="'.$row.'"></td>' . "\n";
      }
    }
?>

</tr>
<tr><td width="100%" colspan="10"><div id="<?php echo $page_name.$row;?>" class="messageStackSuccess larger" style="display:none;"></div></td></tr>
<?php
  }
	?>
	</table>	
	</div>	<?php 
	}
	
}else{
	echo '<div style="text-align:center;">'.TEXT_NO_PRODUCTS_IN_CLEARANCE.'</div>';
}


?>
