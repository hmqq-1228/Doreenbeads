<?php
/**
 * jscript_main.php
 * user define
 */

?>
<script type="text/javascript">
  function changeAction(product_id){
  	var wishlistPage = "<?php echo zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=addToWishlist'); ?>" + "&pid=" + product_id;
  	var obj = document.getElementById("addform");
  	obj.action = wishlistPage;
  }
</script>