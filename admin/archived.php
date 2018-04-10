<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      if(!is_logged_in()){
     login_error_redirect();
 }
     include 'includes/head.php';
     include 'includes/navigation.php';
     $presults = $db->query("SELECT * FROM products WHERE deleted = 1");
     if(isset($_GET['reset'])){
          $id = sanitize($_GET['reset']);
          $db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
          header('Location: archived.php');
     }
?>
<!-- Table -->
<h2 class="text-center">Deleted Products</h2>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-condensed table-striped">
     <thead>
          <th></th>
          <th>Product</th>
          <th>Price</th>
          <th>Category</th>
     </thead>
     <tbody>
          <?php 
               while($product = mysqli_fetch_assoc($presults)) : 
               $childID = $product['categories'];
               $result = $db->query("SELECT * FROM categories WHERE id = '{$childID}'");
               $child = mysqli_fetch_assoc($result);
               $parentID = $child['parent'];
               $presult = $db->query("SELECT * FROM categories WHERE id = '$parentID'");
               $parent = mysqli_fetch_assoc($presult);
               $category = $parent['category'].' ~ '.$child['category'];
          ?>
          <tr>
               <td>
                    <a class="btn btn-xs btn-default" name="reset" href="archived.php?reset=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-retweet"></span></a>
               </td>
               <td><?php echo $product['title']; ?></td>
               <td><?php echo money($product['price']); ?></td>
               <td><?php echo $category; ?></td>
          </tr>
          <?php endwhile; ?>
     </tbody>
</table>


<?php
     include 'includes/footer.php'; ?>