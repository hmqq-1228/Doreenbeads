<div class="listmiancont">
<?php 
for($row = 0; $row < sizeof ( $list_box_contents ); $row ++) {
	echo '<dl ' . $list_box_contents [$row] ['params'] . '>';
	for($col = 0; $col < sizeof ( $list_box_contents [$row] ); $col ++) {
		$cell_type = ($col == 0) ? 'dd' : 'dt';
		if ($list_box_contents [$row] [$col] ['text'] != '') {
			echo '<' . $cell_type . ' ' . $list_box_contents [$row] [$col] ['params'] . '>' . $list_box_contents [$row] [$col] ['text'] . '</' . $cell_type . '>';
		}
	}
	echo '</dl>';
	if ($row > 0) {
		echo '<dl style="text-align:left;" id="' . $page_name . $list_box_contents [$row] [1] ['product_id'] . '"></dl>';
	}
}
?>
</div>