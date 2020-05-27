<?php
if (isset ( $currencies ) && is_object ( $currencies )) {
	reset ( $currencies->currencies );
	$currencies_array = array ();
	
	while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
		$currencies_array [] = array (
				'id' => $key,
				'title' => $value ['title'] 
		);
	}
}
?>
<dl class="currency">
	<dd class=""><?php echo (isset($_SESSION['currency']) ? $_SESSION['currency'] : 'USD');?><span></span></dd>
	<dt>
		<ul id="currency_type">
			<?php 			
				foreach ( $currencies_array as $val ) {
					if($val['id'] == $_SESSION['currency']){
						echo "<li class='cur" . $val['id'] . "'><a rel='nofollow' href='" . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('currency')) . 'currency=' . $val['id'], $request_type)."' >" . $val['title'] . "</a></li>";
					}else{
						echo "<li class='cur" . $val['id'] . "'><a rel='nofollow' href='" . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('currency')) . 'currency=' . $val['id'], $request_type) . "'  >" . $val['title'] . "</a></li>";
					}
				}
			?>
		</ul>
	</dt>
</dl>