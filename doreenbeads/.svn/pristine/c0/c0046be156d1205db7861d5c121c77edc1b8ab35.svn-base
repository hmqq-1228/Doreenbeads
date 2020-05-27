<?php
include ("includes/application_top.php");

if ($_POST['action'] == 'remove'){
	$product_id = $_POST['pid'];
	$_SESSION['cart']->remove($product_id);
	if($product_id==$_SESSION['gift_id']){
		$db->Execute("update ".TABLE_CUSTOMERS." set has_gift=0 where customers_id='".(int)$_SESSION['customer_id']."'");
		$_SESSION['customer_gift']=0;
	}
	if(isset($_SESSION ['customer_id']) && $_SESSION['customer_gift']){
		$_SESSION ['cart']->calculate();
		if($_SESSION ['cart']->show_total()<30) $_SESSION ['cart']->remove($_SESSION['gift_id']);
	}
	
}
//暂时屏蔽掉计算总价的影响性能，Tianwen.Wan2014
//$_SESSION ['cart']->calculate ();
$content = '';

$_SESSION['basket_product_orderby'] = true;
$show_num = 5;
$terms_total = (isset ( $_SESSION ['count_cart'] ) ? $_SESSION ['count_cart'] : $_SESSION ['cart']->get_products_items ());

$page = isset($_POST['page']) && $_POST['page'] != '' ? $_POST['page'] : 1;
$page = $page > $terms_total ? $terms_total : $page;
$_GET['page'] = $page;
$total_page = ceil($terms_total / $show_num);

$shopping_terms = $_SESSION ['cart']->get_products ( false, $show_num );
unset($_SESSION['basket_product_orderby']);
?>
<input type="hidden" value="<?php echo $terms_total;?>" id="minicart_total_terms" />
<input type="hidden" value="<?php echo $currencies->format($_SESSION['cart']->show_total());?>" id="minicart_total_amount" />
<?php 
if (sizeof($shopping_terms) > 0) {
	foreach($shopping_terms as $val){
?>
<dl>
  <?php if($val['id']==$_SESSION['gift_id']){?>
	<dd><a><img src="<?php echo HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($val['image'], 80, 80)?>" width="60" height="60"/></a></dd>
	<dt class="proinfo" style="color:#000;"><?php echo $val['name'];?></dt>
	<dt class="proprice"><span><?php echo $currencies->format($val['final_price']) . 'x' . $val['quantity'];?></span><p class="deletethis"><input type="hidden" value="<?php echo $val['id'];?>"></p></dt>
	<div class="clearfix"></div>
  <?php }else{?>
    <dd><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $val['id'])?>"><img src="<?php echo HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($val['image'], 80, 80)?>" width="60" height="60"/></a></dd>
	<dt class="proinfo"><a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $val['id'])?>"><?php echo $val['name'];?></a></dt>
	<dt class="proprice"><span><?php echo $currencies->format($val['final_price']) . 'x' . $val['quantity'];?></span><p class="deletethis"><input type="hidden" value="<?php echo $val['id'];?>"></p></dt>
	<div class="clearfix"></div>
  <?php }?>
</dl>
<?php } ?>
<div class="clearfix"></div>

<div class="checkbtnline">
	<?php if ($terms_total > 5) { ?>
	<p class="page">
		<a href="javascript:void(0);" class="previous <?php echo ($page > 1 ? 'hasprevious' : '');?>"><ins></ins><?php echo TEXT_PREV;?></a>
		<a href="javascript:void(0);" class="next <?php echo ($page < $total_page ? 'hasnext' : '')?>"><?php echo TEXT_NEXT;?><ins></ins></a>
		<input type="hidden" class="cart_current_page" value="<?php echo $page;?>">
	</p>
	<?php } ?>
	<p class="btn"><a rel="nofollow" href="javascript:void(0);" class="check"><?php echo HEADER_CART_PROCESS_TO_CHECKOUT;?></a><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>" class="view"><?php echo HEADER_CART_VIEW_CART;?><ins></ins></a></p>
	<div class="clearfix"></div>
</div>
<?php 
} else {
?>
<p class="cartnone"><?php echo HEADER_CART_YOUR_CART_EMPTY;?></p>
<?php 
} 
?>