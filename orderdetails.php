<?php
     ob_start();
      require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      include 'includes/headertag.php';
      include 'includes/head.php';
      if(!is_logged_in1()){
      login_error_redirect1();
 }
    
    $txn_id = urldecode($_GET['txn_id']);
	$txn_id = encryptor('decrypt', $txn_id);
    $txnQuery = $db->query("SELECT * FROM transactions WHERE id = '{$txn_id}'");
    $txn = mysqli_fetch_assoc($txnQuery);
    $cart_id = $txn['cart_id'];
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $cart = mysqli_fetch_assoc($cartQ);
    $items = json_decode($cart['items'],true);
    $shipped = $cart['shipped'];
    $idArray = array();
    $products = array();
    foreach ($items as $item) {
    	$idArray[] = $item['id'];
    }
    $ids = implode(',',$idArray);
    $productQ = $db->query(
        "SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent'
            FROM products i
            LEFT JOIN categories c ON i.categories = c.id
            LEFT JOIN categories p ON c.parent = p.id
            WHERE i.id IN ({$ids})
            ");
    While($p = mysqli_fetch_assoc($productQ)){
    	foreach($items as $item){
    		if($item['id'] == $p['id']){
    			$x = $item;
    			continue;
    		}
    	}
    	$products[] = array_merge($x,$p);
    }
?>
<br><h2 class="text-centre" style="text-align: center;">Items Ordered</h2><br>
<table class="table table-condensed table-bordered table-striped">
	<thead>
		<th>Quantity</th>
		<th>Title</th>
		<th>Category</th>
		<th>Size</th>
	</thead>
	<tbody>
	<?php foreach($products as $product): ?>
		<tr>
			<td><?=$product['quantity'];?></td>
			<td><?=$product['title'];?></td>
			<td><?=$product['parent'].'~'.$product['child'];?></td>
			<td><?=$product['size'];?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<div class="row">
	<div class="col-md-6">
		<h3 class="text-centre" style="text-align: center;">Order Details</h3><br>
		<table class="table table-condensed table-striped table-bordered">
			<tbody>
			  <tr>
					<td>Order Ref number</td>
					<td><?=$txn['cart_id'];?></td>
				</tr>
				<tr>
					<td>Sub Total</td>
					<td><?=money($txn['sub_total']);?></td>
				</tr>
				<tr>
					<td>Delivery</td>
					<td><?=money($txn['tax']);?></td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td><?=money($txn['grand_total']);?></td>
				</tr>
				<tr>
					<td>Order Date</td>
					<td><?=pretty_date($txn['txn_date']);?></td>
				</tr>
                
                 <?php if($shipped == 0) : ?> 
				<tr>
					<td>Order Status</td>
					<td>Pending</td>
				</tr>
				<?php else : ?>
				 <tr>
					<td>Order Status</td>
					<td style="background: green;">Dispatched </td>
				</tr>
                <?php endif; ?>
                
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
	<h3 class="text-centre" style="text-align: center;">Shipping Address</h3><br>
	<address style="text-align: center; font-weight: bold; font-size: x-large;">
		<?=$txn['full_name'];?><br>
		<?=$txn['email'];?><br>
		<?=$txn['street'];?><br>
		<?=($txn['street2'] != '')?$txn['street2'].'<br>':'';?>
		<?=$txn['city'].' '.$txn['county'].' '.$txn['postcode'];?><br>
		<?=$txn['country'];?><br>
	</address>
</div>
</div>
</div><br>
<?php include 'includes/footer.php';  
 ob_end_flush()
?>
