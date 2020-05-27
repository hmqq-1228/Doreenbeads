<?php
/**
 * �����ļ� tpl_quick_columnar_display.php
 * 2010-04-16
 * jessa
 */
?>
<span style="font-size:14px;"><?php echo TEXT_SUBCATEGORY;?></span>
<div class="centerBoxWrapperContents" style="padding:5px;line-height:180%;">
<?php
if ($title) echo $title;
$quick_output_str = '';
if (is_array($list_box_contents) > 0){
	$quick_output_str .= '<table width="100%" border="0" cellspacing="0" cellpadding="2">' . "\n";
	for ($quick_row = 0; $quick_row < sizeof($list_box_contents); $quick_row++){
		$quick_output_str .= '	<tr>' . "\n";
		for ($quick_col = 0; $quick_col < sizeof($list_box_contents[$quick_row]); $quick_col++){
			$quick_output_str .= '		<td>' . $list_box_contents[$quick_row][$quick_col]['text'] . '</td>';
		}
		$quick_output_str .= '	</tr>' . "\n";
	}
	$quick_output_str .= '</table>' . "\n";
}
echo $quick_output_str;
?>
</div>