<?php
  require_once 'core/init.php';
$sql = 'SELECT * FROM products WHERE Featured = 1'; 
$men = $db->query($sql);
$sql2 = "SELECT * FROM taka";
$takasql = $db->query($sql2);
$taka = mysqli_fetch_assoc($takasql);
?>
<div class="footer">
	<div class="content">
	<div class="container">
            <h1 style="text-align: center; padding-top: 28px; font-family: 'OleoScript-Regular'; font-size: 3em;">Featured Products</h1>
			<div class="content-top1">
			<?php while($products = mysqli_fetch_assoc($men)) : ?>
				<div class="col-md-3 col-md4" style="padding-top: 10px;">
					<div class="col-md1 simpleCart_shelfItem">
						<a href="productdisplay?id=<?= $products['id'] ?>">
						<?php $photos = explode(',', $products['image']); ?>
						<img class="img-responsive" src=<?= $photos[0]; ?> alt="" />
						</a>
						<h3><a href="productdisplay?id=<?= $products['id'] ?>"><?= $products['title'] ?></a></h3>
						<div class="price">
							<?php $takaRate =  ($products['price'] * $taka['rate']); ?>
								<h5 class="item_price" style="float: right;">£<?= $products['price'] ?></h5>
								<span class="label label-primary">Taka: <?= round($takaRate, 2) ?></span>
								<div class="clearfix"> </div>
						</div>
					</div><br>
				</div>
			<?php endwhile; ?>		
			<div class="clearfix"> </div>
			</div>		
		</div>
	</div>
</div>
	<div class="footer-bottom">
		<div class="container">
				<div class="col-sm-3 footer-bottom-cate">
					<h6>Shopping with us</h6>
					<ul>
						<li><a href="delivery.php">Delivery Info</a></li>
						<li><a href="size.php">Size Guides</a></li>
						<li><a href="sitemap.php">Site Map</a></li>
						
					</ul>
				</div>
				<div class="col-sm-3 footer-bottom-cate">
					<h6>Company</h6>
					<ul>
						<li><a href="factory.php">Bulk order information</a></li>
						<li><a href="press.php">Press Enquiries</a></li>
						<li><a href="aboutus.php">About us</a></li>
						
					</ul>
				</div>
				<div class="col-sm-3 footer-bottom-cate">
					<h6>Private & Legal</h6>
					<ul>
						<li><a href="privacy.php">Privacy Policy</a></li>
						<li><a href="cookies.php">Cookies</a></li>
						<li><a href="access.php">Accessibility Policy</a></li>
						
					</ul>
				</div>
				<div class="col-sm-3 footer-bottom-cate cate-bottom">
					<h6>Our Address</h6>
					<ul>
						<li>Unit-16</li>
						<li>Nelson Business Centre</li>
						<li>56-60 nelson Street,London</li>
						<li>E1 2DE</li>
					</ul>
				</div>
				<div class="clearfix"> </div>
				<p class="footer-class"> © 2018 Apparel Manufacturer. All Rights Reserved</p>
	        <script>
                function update_cart(mode,edit_id,edit_size){
                	var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
                	jQuery.ajax({
                		url : 'admin/parsers/update_cart',
                		method : "post",
                		data : data,
                		success : function(){location.reload();},
                		error : function(){alert("Something went wrong.");},
                	})
                }


	        	function add_to_cart(){
	        	 jQuery('#model_errors').html("");
	        	 var size = jQuery('#size').val();
	        	 var quantity = jQuery('#quantity').val();
	        	 var available = parseInt(jQuery('#available').val());
	        	 var error = '';
	        	 var data = jQuery('#add_product_form').serialize();
	        	 if(size == "" || quantity == "" || quantity == 0){
	        	 	error += '<p" class="text-danger text-centre">You must choose a size and quantity.</p>';
	        	 jQuery('#model_errors').html(error);
	        	 return;
	        	 } else if (quantity > available){
	        	 	error += '<p" class="text-danger text-centre">There are only ' + available +' available.</p>';
	        	 jQuery('#model_errors').html(error);
	        	 return;
	        	 }else{
	        	 	jQuery.ajax({
	        	 		url : 'admin/parsers/add_cart',
	        	 		method : 'post',
	        	 		data : data,
	        	 		success : function(){
	        	 			location.reload();
	        	 		},
	        	 		error : function(){alert("Something went wrong");}
	        	 	});
	        	 }
	        	}
	        </script>
			</div>
	</div>
</div>