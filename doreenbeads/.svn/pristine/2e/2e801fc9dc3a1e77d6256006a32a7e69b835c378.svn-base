<script type="text/javascript">
$j(document).ready(function(){
	$j('.image_down_arrow').live('click', function(){
		$j('.image_down_arrow').hide();
		$j('.image_up_arrow').show();
		$j('.price_sub').show();
	});
	$j('.image_up_arrow').live('click', function(){
		$j('.image_up_arrow').hide();
		$j('.image_down_arrow').show();
		$j('.price_sub').hide();
	});
	$j('.image_down_arrows').live('click', function(){
		$j('.image_down_arrows').hide();
		$j('.image_up_arrows').show();
		$j('.price_subs').show();
	});
	$j('.image_up_arrows').live('click', function(){
		$j('.image_up_arrows').hide();
		$j('.image_down_arrows').show();
		$j('.price_subs').hide();
	});
});
$j(function() {
	$j(".jq_products_invalid_one").live("click", function() {
		var $this = $j(this);
		var customers_basket_id = $this.data("id");
		$j.post('ajax/ajax_products_invalid.php',{action:'shopping_cart_delete_one', customers_basket_id:customers_basket_id},function(data){
			var returnInfo = process_json(data);
			if(returnInfo.error == 0) {
				$this.parents("td").filter(":first").parents("tr").filter(":first").remove();
				if($j(".jq_products_invalid_one").length <= 0) {
					$j(".shopping_cart_products_error").hide();
				}
			}
		});
	});
	$j(".jq_products_invalid_all").live("click", function() { 
		$j.confirm({
			'message'	: $lang.CartAreYouSureInvaild,
			'buttons'	: {
				'Yes'	: {
					'class'	: 'paynow_btn sureremove',
					'action': function(){
						var array = new Array();
						$j(".jq_products_invalid_one").each(function(index){
							array.push($j(this).data("id"));
						});
						var customers_basket_ids = array.join(",");
						$j.post('ajax/ajax_products_invalid.php',{action:'shopping_cart_delete_all', customers_basket_ids:customers_basket_ids},function(data){
							var returnInfo = process_json(data);
							if(returnInfo.error == 0) {
								$j(".shopping_cart_products_error").hide();
							}
						});
					}
				},
				'No'	: {
					'class'	: 'cancelremove',
					'action': function(){}
				}
			}
		});
	});
});
</script>