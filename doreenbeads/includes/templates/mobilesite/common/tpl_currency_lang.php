<?php
$hidden_get_variables = '';
reset ( $_GET );
while ( list ( $key, $value ) = each ( $_GET ) ) {
	if (($key != 'currency') && ($key != 'language') && ($key != zen_session_name ()) && ($key != 'x') && ($key != 'y')) {
		$hidden_get_variables .= zen_draw_hidden_field ( $key, $value );
	}
}

if (isset ( $currencies ) && is_object ( $currencies )) {
	reset ( $currencies->currencies );
	$currencies_array = array ();
	while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
		$currencies_array [] = array (
				'id' => $key,
				//'text' => $value ['title']
				'text' => $key
		);
	}
}
echo zen_draw_form ( 'currencies_form', zen_href_link ( basename ( ereg_replace ( '.php', '', $PHP_SELF ) ), '', $request_type, false ), 'get', 'id="currencies_form"' );
//echo $_SESSION['currency']."<br/>";
//print_r($currencies_array);
echo zen_draw_pull_down_menu ( 'currency', $currencies_array, $_SESSION ['currency'], 'onchange="this.form.submit();"' ) . $hidden_get_variables . zen_hide_session_id () . '</form>';

if (! isset ( $lng ) || (isset ( $lng ) && ! is_object ( $lng ))) {
	$lng = new language ();
}
reset ( $lng->catalog_languages );
$lang_array = array ();
while ( list ( $key, $value ) = each ( $lng->catalog_languages ) ) {
	$lang_array [] = array (
			'id' => $key,
			'text' => $value ['name']
	);
}
//$lang_array[1] = $lang_array[2];
//$lang_array = array_slice($lang_array,0,2); //v1.0.1 only english and russian

echo zen_draw_form ( 'language_form', $PHP_SELF, 'get' );

echo $hidden_get_variables . zen_hide_session_id () . zen_draw_pull_down_menu ( 'language', $lang_array, $_SESSION ['languages_code'], 'onchange="this.form.submit();"' ) . '</form>';
echo '<input type="hidden" id="c_lan" value="' . $_SESSION ['language'] . '">';
echo '<input type="hidden" id="isLogin" value="' . $_SESSION ['customer_id'] . '">';
?>