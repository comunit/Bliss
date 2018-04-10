<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      if(!is_logged_in()){
     login_error_redirect();
 }
     include 'includes/head.php';
     include 'includes/navigation.php';
     $presults = $db->query("SELECT * FROM categories WHERE hide = 1");
     if(isset($_GET['reset'])){
          $id = sanitize($_GET['reset']);
          $db->query("UPDATE categories SET hide = 0 WHERE id = '$id'");
          header('Location: hidden-categories.php');
     }
?>
<!-- Table -->
<h2 class="text-center">Hidden Categories</h2>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-condensed table-striped">
     <thead>
          <th></th>
          <th>Category</th>
          <th>Parent Category</th>
     </thead>
     <tbody>
          <?php 
               while($product = mysqli_fetch_assoc($presults)) : 
               $childID = $product['parent'];
               $result = $db->query("SELECT * FROM categories WHERE id = '{$childID}'");
               $child = mysqli_fetch_assoc($result);
               $parentID = $child['parent'];
               $presult = $db->query("SELECT * FROM categories WHERE id = '$parentID'");
               $parent = mysqli_fetch_assoc($presult);
               $category = $parent['category'].' ~ '.$child['category'];
          ?>
          <tr>
               <td>
                    <a class="btn btn-xs btn-default" name="reset" href="hidden-categories.php?reset=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-retweet"></span></a>
               </td>
               <td><?php echo $product['category']; ?></td>
               <td><?php echo $category; ?></td>
          </tr>
          <?php endwhile; ?>
     </tbody>
</table>


<?php
     include 'includes/footer.php'; ?>