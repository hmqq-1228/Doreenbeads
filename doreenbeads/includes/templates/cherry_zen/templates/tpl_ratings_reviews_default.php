<?php
/**
 * tpl_ratings_reviews_default.php
 * ratings and reviews
 */
?>
<?php if ($show_reviews_products == true){ ?>
<div id="allProductsDefault" class="centerColumn">
<h2 class="centerBoxHeading">Top-Rated Products</h2>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php for ($i = 0; $i < sizeof($show_products_reviews_array); $i++){ ?>
  <tr>
  <?php for ($j = 0; $j < sizeof($show_products_reviews_array[$i]); $j++){ ?>
    <td style="padding:8px;text-align:center;width:33%;"><?php echo $show_products_reviews_array[$i][$j]['text']; ?></td>
  <?php } ?>
  </tr>
<?php } ?>
</table>
</div>
<?php } ?>
<div id="newProductsDefault" class="centerColumn">
<h2 class="centerBoxHeading">All Reviews</h2>
<?php
  if ($show_ratings_reviews == true){
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<?php for ($i = 0; $i < sizeof($show_reviews_array); $i++){ ?>
  <tr>
  <?php for ($j = 0; $j < sizeof($show_reviews_array[$i]); $j++){ ?>
    <td style="padding:6px 10px;width:50%;"><?php echo $show_reviews_array[$i][$j]['text']; ?></td>
  <?php } ?>
  </tr>
<?php } ?>
</table>
<?php
  } else {
?>
<div style="padding:10px; font-weight:bold;text-align:center;"><?php echo RATING_REVIEWS_HASNO_REVIEWS; ?></div>
<?php
  }
?>
</div>