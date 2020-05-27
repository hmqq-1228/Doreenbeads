<script type="text/javascript">
$j(function() {
	$j(".jq_products_invalid_one").live("click", function() {
		var $this = $j(this);
		var wl_id = $this.data("id");
		$j.post('ajax/ajax_products_invalid.php',{action:'wishlist_delete_one', wl_id:wl_id},function(data){
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
		if(confirm('<?php echo addslashes(TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS); ?>')){
			var array = new Array();
			$j(".jq_products_invalid_one").each(function(index){
				array.push($j(this).data("id"));
			});
			var wl_ids = array.join(",");
			$j.post('ajax/ajax_products_invalid.php',{action:'wishlist_delete_all', wl_ids:wl_ids},function(data){
				var returnInfo = process_json(data);
				if(returnInfo.error == 0) {
					$j(".shopping_cart_products_error").hide();
				}
			});
		}
	});
});
</script>