<?php
  require_once 'core/init.php';
$sql = 'SELECT * FROM products WHERE deleted = 0'; 
$men = $db->query($sql);
?>
<!--content-->
<div class="products">
	<div class="container">
		<h1>Products</h1>
		<div class="col-md-9">
			<div class="content-top1">
			<?php while($products = mysqli_fetch_assoc($men)) : ?>
				<div class="col-md-4 col-md4" style="padding-top: 10px;">
					<div class="col-md1 simpleCart_shelfItem">
						<a href="productdisplay.php?id=<?= $products['id'] ?>">
						<?php $photos = explode(',', $products['image']); ?>
						<img class="img-responsive" src=<?= $photos[0]; ?> alt="" />
						</a>
						<h3><a href="productdisplay.php?id=<?= $products['id'] ?>"><?= $products['title'] ?></a></h3>
						<div class="price">
								<h5 class="item_price" style="float: right;">£<?= $products['price'] ?></h5>
								
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