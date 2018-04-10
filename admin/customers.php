<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      if(!is_logged_in()){
     login_error_redirect();
 }
     include 'includes/head.php';
     include 'includes/navigation.php';
     $presults = $db->query("SELECT * FROM users1 ORDER BY join_date DESC"); 
?>
    <h2 class="text-center">Customers List</h2>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-condensed table-striped">
     <thead>
          <th>Name</th>
          <th>Email</th>
          <th>Join Date</th>
          <th>Last Login</th>
     </thead>
     <tbody>
          <?php 
               while($product = mysqli_fetch_assoc($presults)) : ?>
          <tr>
               <td><?php echo $product['full_name']; ?></td>
               <td><?php echo $product['email']; ?> </td>
               <td><?=pretty_date($product['join_date']); ?></td>
               <td><?php echo (($product['last_login'] == '0000-00-00 00:00:00')?'Never':pretty_date($product['last_login']));?></td>
               
          </tr>
          <?php endwhile; ?>
     </tbody>
</table>



<?php include 'includes/footer.php';  ?>