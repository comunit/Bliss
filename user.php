<?php 
      ob_start();
      require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      include 'includes/headertag.php';
      include 'includes/head.php';
      if(!is_logged_in1()){
      login_error_redirect1();
       }
       $hashed = $user_data1['password'];

       $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
       $old_password = trim($old_password);
       $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
       $password = trim($password);
       $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
       $confirm = trim($confirm);
       $new_hashed = password_hash($password, PASSWORD_DEFAULT);
       $user_id = $user_data1['id'];
       $errors = array();
 ?>
 <?php  

 $userQuery = "SELECT * FROM transactions WHERE user_id = $user_id1";
     $txnResults = $db->query($userQuery);
    $count = mysqli_num_rows($txnResults);
 ?>

  <?php

     if ($_POST) {
      //form validation
      if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm']))  {
        $errors[] = 'You must fill out all fields.';
      }

      //Password is more than 6 characters
      if(strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
      }

        // if new password matched confirm
        if($password != $confirm){
            $errors[] = 'The new password and confirm new password does not match';
        }


      if (!password_verify($old_password, $hashed)) {
            $errors[] = 'Your old password does not match our records.';
      }

        //check for errors
        if(!empty($errors)) {
          echo display_errors($errors);
        }else {
          //change passsword
            $db->query("UPDATE users1 SET password = '$new_hashed' WHERE id = '$user_id1'");
            $_SESSION['success_flash'] = 'Your password has been updated!';
            header('Location: user.php');
        }
     }
  ?>
<style>
     .colorgraph {
  height: 5px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}

#sign_up i.glyphicon {
  font-size: 18px;
}

#check_pass2.valid .input-group-addon {
  background: rgb(177, 226, 177);
}

#check_pass2.not-valid .input-group-addon {
  background: rgb(231, 205, 205);
}
   </style><br>

<div class="container"><br>
  <div class="row">
      <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#a" data-toggle="tab">My Orders</a></li>
          <li><a href="#c" data-toggle="tab">Change Password</a></li>
        </ul>
        <div class="tab-content">
         <div class="tab-pane active" id="a">
           <?php if ($count > 0): ?>
            <div class="col-md-12"><br>
  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <th></th><th>Name</th><th>Description</th><th>Total</th><th>Date</th>
    </thead>
    <tbody>
    <?php while($order = mysqli_fetch_assoc($txnResults)): ?>
      <tr>
        <?php
         $orderid = $order['id'];
         $user_id2 = urlencode(encryptor('encrypt', $orderid));
         ?>
        <td><a href="orderdetails?txn_id=<?=$user_id2;?>"class="btn btn-xs btn-info">Details</a></td>
        <td><?=$order['full_name'];?></td>
        <td><?=$order['description'];?></td>
        <td><?=money($order['grand_total']);?></td>
        <td><?=pretty_date($order['txn_date']);?></td>
      </tr>
    <?php endwhile;?>
    </tbody>
  </table>
 </div>

 <?php else: ?>
         <br><div class="bg-danger">
          <p class="text-centre text-danger" style="text-align: center;">
            You have no orders!
          </p>
        </div>
         <?php endif; ?>
         </div><br>
         
         <div class="tab-pane" id="c">
           <div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="user.php" method="post">
      <h2 style="text-align: center;">Change Password</h2>
      <hr class="colorgraph">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="old_password" id="old_password" class="form-control input-lg" placeholder="Old Password" value="<?=$old_password?>" tabindex="1">
          </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="New Password" value="<?=$password;?>" tabindex="4">
      </div>
      </div>
      <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input type="password" name="confirm" id="confirm" class="form-control input-lg" placeholder="Confirm New Password" value="<?=$confirm;?>" tabindex="4">
      </div>

      <div class="row">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
      </div>
      <div class="row">
        <div class="col-xs-4 col-sm-3 col-md-3">
          
        </div>

      </div>

      <hr class="colorgraph">
      <div class="row">
        <div class="col-xs-6 col-md-6" style="float: right;"><input type="submit" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
      </div>
    </form>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><br>

         </div>
        </div>
      </div>
      
    </div>
  </div>
</div><br>
<?php include 'includes/footer.php';  
 ob_end_flush()
?>