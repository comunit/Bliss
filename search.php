<?php
require_once 'core/init.php';
include 'includes/headertag.php';
include 'includes/head.php';

$sql = "SELECT * FROM products";
$cat_id = ((isset($_POST['cat']) != '')?sanitize($_POST['cat']) : '');
if($cat_id == ''){
	$sql .= ' WHERE deleted = 0';
}else{
   $sql .= " WHERE categories = '{$cat_id}' AND deleted = 0";
}
$price_sort = ((isset($_POST['price_sort']) != '')?sanitize($_POST['price_sort']) : '');
$min_price = ((isset($_POST['min_price']) != '')?sanitize($_POST['min_price']) : '');
$max_price = ((isset($_POST['max_price']) != '')?sanitize($_POST['max_price']) : '');

if ($min_price != '') {
	$sql .= " AND price >= '{$min_price}'";
}
if ($max_price != '') {
	$sql .= " AND price <= '{$max_price}'";
}
if ($price_sort == 'low'){
	$sql .= " ORDER BY price";
}
if ($price_sort == 'high'){
	$sql .= " ORDER BY price DESC";
}

 $productQ = $db->query($sql);
 $category = get_category($cat_id);
?>
<!--content-->
<div class="products">
	<div class="container">
	<?php if($cat_id != ''):  ?>
		<h1><?=$category['parent']. ' ' . $category['child'];?></h1>
	<?php else: ?>
   
    <?php endif; ?>
		<div class="col-md-9">
			<div class="content-top1">
			<?php while($products = mysqli_fetch_assoc($productQ)) : ?>
				<div class="col-md-4 col-md4" style="padding-top: 10px;">
					<div class="col-md1 simpleCart_shelfItem">
						<a href="productdisplay.php?id=<?= $products['id'] ?>">
						<?php $photos = explode(',', $products['image']); ?>
						<img class="img-responsive" src=<?= $photos[0]; ?> alt="" />
						</a>
						<h3><a href="productdisplay.php?id=<?= $products['id'] ?>"><?= $products['title'] ?></a></h3>
						<div class="price">
								<h5 class="item_price">£<?= $products['price'] ?></h5>
								<a href="#" class="item_add">Add To Cart</a>
								<div class="clearfix"> </div>
						</div>
					</div>
				</div>	
			<?php endwhile; ?>
			
			<div class="clearfix"> </div>
			</div>	
		</div>
        <?php 
        include 'includes/sidemenu.php';
        ?>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<?php 
include 'includes/footer.php';
 ?>