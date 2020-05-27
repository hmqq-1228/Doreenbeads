<?php
/**新增文件Jessa
 *tpl_download_new_products_default.php
 */
 $show_contents = '<div>' . "\n";
 $show_contents .= '  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">' . "\n";
 $show_contents .= '    <tr>' . "\n";
 $show_contents .= '	  <td colspan="3"><h2><a href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">New Products For ' . ucfirst(date('F')) . '</a></h2></td>' . "\n";
 $show_contents .= '	</tr>' . "\n";
 for ($i = 0; $i < sizeof($show_download_new_products); $i++){
 	$show_contents .= '    <tr>' . "\n";
	for ($j = 0; $j < sizeof($show_download_new_products[$i]); $j++){
		$show_contents .= '      <td style="width:33%; text-align:center; padding:10px;">' . $show_download_new_products[$i][$j]['text'] . '</td>' . "\n";
	}
	$show_contents .= '    </tr>' . "\n";
 }
 $show_contents .= '  </table>' . "\n";
 $show_contents .= '</div>' . "\n";
 
 echo $show_contents;
 
 echo '<textarea name="textarea" cols="" rows="30">' . $show_contents . '</textarea>'
?>
