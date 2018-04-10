<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      if(!is_logged_in()){
     login_error_redirect();
 }
     include 'includes/head.php';
     include 'includes/navigation.php';
     $presults = $db->query("SELECT * FROM messages ORDER BY DATE DESC"); 
     $count = $db->query("SELECT * FROM messages");
          $messages = mysqli_num_rows($count); 

     //Delete Product
     if(isset($_GET['delete'])){
          $id = sanitize($_GET['delete']);
          $db->query("DELETE FROM messages WHERE id = '$id'");
          header('Location: messages.php');
     }
          
?>
     <?php if ((isset($_GET['view']))): ?>
     <?php 
      if(isset($_GET['view'])){
          $id1 = sanitize($_GET['view']);
          $sms = $db->query("SELECT * FROM messages WHERE id = '$id1'");
          $db->query("UPDATE messages SET `read` = 1 WHERE id = '$id1'");         
     }
      ?>
    <div class="container">
      <?php while($sms1 = mysqli_fetch_assoc($sms)) : ?>
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">                        
            <h2 class="form-title">Message from <?=$sms1['name'];?></h2>
          </div>
      </div>

      <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

              <form id="contact-form" name="myForm" class="form" action="contact.php" method="POST" role="form">

                  <div class="form-group">
                      <label class="form-label" id="nameLabel" for="name"></label>
                      <div class=".col-md-4 text-center" style="background: rgba(158, 158, 158, 0.08); box-shadow: -4px 1px 15px #4a4242"><?=$sms1['message'];?></div>
                  </div>
               <?php endwhile; ?>
      
    </div><!-- End container -->
    
  </body><!-- End body --><br>
     <?php else: ?>
    <h2 class="text-center">Messages</h2>
<div class="clearfix"></div>
<hr>
<?php if ($messages == 0): ?>
         <div class="bg-danger">
          <p class="text-centre text-danger" style="text-align: center;">
            You have no messages!
          </p>
        </div>
        <?php else: ?>
<table class="table table-bordered table-condensed table-striped">
     <thead>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Date Received</th>
          <th></th>
     </thead>
     <tbody>
          <?php 
               while($product = mysqli_fetch_assoc($presults)) : ?>
                 <?php
                  $css = $product['read'];
                 ?>
                 <?php if ($css == 0): ?>
               <tr style="background: #dff0d8;">
               <?php else: ?>
               <tr style="background: #ffffff;">
               <?php endif; ?>
               <td>
                    <a class="btn btn-xs btn-default" href="messages.php?delete=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
               </td>
               <td><?php echo $product['name']; ?></td>
               <td><?php echo $product['email']; ?> </td>
               <td><?php echo $product['subject']; ?> </td>
               <td><?php echo $product['date']; ?> </td>
               <td>
                    <a href="messages.php?view=<?=$product['id'];?>" class="btn btn-default center-block" style="padding: 2px 12px;"><span class="glyphicon glyphicon-eye-open"></span> View Message</a>
               </td>
          </tr>
          <?php endwhile; ?>
     </tbody>
</table>
<?php endif; ?>
<?php endif; ?>

<?php include 'includes/footer.php';  ?>