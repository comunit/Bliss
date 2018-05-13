<?php
require_once 'core/init.php';
include 'includes/headertag.php';
include 'includes/head.php';

if(isset($_GET['cat'])){
	$cat_id = sanitize($_GET['cat']);
}else{
	$cat_id = '';
}

$sql = "SELECT * FROM products WHERE categories = '$cat_id' AND deleted = 0"; 
$productQ = $db->query($sql);
$category = get_category($cat_id);
$sql2 = "SELECT * FROM taka";
$takasql = $db->query($sql2);
$taka = mysqli_fetch_assoc($takasql);
?>
<!--content-->
<div class="products">
	<div class="container">
		<h1><?=$category['parent']. ' ' . $category['child'];?></h1>
		<div class="col-md-9">
			<div class="content-top1">
			<?php while($products = mysqli_fetch_assoc($productQ)) : ?>
				<div class="col-md-4 col-md4" style="padding-top: 10px;">
					<div class="col-md1 simpleCart_shelfItem">
						<a href="productdisplay?id=<?= $products['id'] ?>">
						<?php $photos = explode(',', $products['image']); ?>
						<img class="img-responsive" src=<?= $photos[0]; ?> alt="" />
						</a>
						<h3><a href="productdisplay?id=<?= $products['id'] ?>"><?= $products['title'] ?></a></h3>
						<div class="price">
						    <?php $takaRate =  ($products['price'] * $taka['rate']); ?>	
								<h5 class="item_price" style="float: right;">Taka: <?= number_format($takaRate, 2) ?>/-</h5>					
								<div class="clearfix"> </div>
						</div>
					</div>
				</div>	
			<?php endwhile; ?>
			
			<div class="clearfix"> </div>
			</div>	
		</div><br>
		<div class="col-md-3 hidden-xs hidden-sm">
        <?php include 'includes/sidecat2.php'?>
      </div>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<?php 
include 'includes/footer.php';
 ?>