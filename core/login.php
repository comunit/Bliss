<?php 
      ob_start();
      require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      include 'includes/headertag.php';
      include 'includes/head.php';
      $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
      $email = trim($email);
      $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
      $password = trim($password);
      $errors = array();
?>   
    <?php
     if ($_POST) {
      //form validation
      if (empty($_POST['email']) || empty($_POST['password'])) {
        $errors[] = 'You must provide email and password.';
      }

      //Validate email
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = 'You must enter a valid email';
      }

      //Password is more than 6 characters
      if(strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
      }

      // check if email exits in the database
      $query = $db->query("SELECT * FROM users1 WHERE email = '$email'");
      $user = mysqli_fetch_assoc($query);
      $usercount = mysqli_num_rows($query);
      if($usercount < 1){
        $errors[] = 'That email does not exist in our database';
      }

      if (!password_verify($password, $user['password'])) {
            $errors[] = 'The password does not match our records. Please try again.';
      }

        //check for errors
        if(!empty($errors)) {
          echo display_errors($errors);
        }else {
          $user_id = $user['id'];
          login2($user_id);
        }
     }
  ?>
   <div class="account">
  <div class="container">
    <h1>Account</h1>
    <div class="account_grid">
         <div class="col-md-6 login-right">
        <form action="login" method="post">
       <div class="form-group">
         <label for="email">Email:</label>
         <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
       </div>
       <div class="form-group">
         <label for="password">Password:</label>
         <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
       </div>
       <div class="form-group text-center">
         <input type="submit" value="Login" class="btn btn-primary">
       </div>
     </form>
         </div> 
          <div class="col-md-6 login-left">
           <h4>NEW CUSTOMERS</h4>
         <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
         <a class="acount-btn" href="adduser.php">Create an Account</a>
         </div>
         <div class="clearfix"> </div>
       </div>
  </div>
</div>
<?php include 'includes/footer.php';  
 ob_end_flush()
?>