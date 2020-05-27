<?php if (sizeof($img_310_text) > 0) { ?>
<div id="productAdditionalImages">
	<div class="centerBoxWrapperContents">
		<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<?php 
					for ($i = 0; $i < 3; $i ++){
						echo '<td align="center">' . $img_310_text[$i] . '</td>';
					}
				?>
			</tr>
		</table>
	</div>
</div>
<?php } ?>