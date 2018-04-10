<?php 
      ob_start();
      require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      include 'includes/headertag.php';
      include 'includes/head.php';

  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $errors = array();
  if($_POST){
    $emailQuery =$db->query("SELECT * FROM users1 WHERE email = '$email'");
    $emailCount = mysqli_num_rows($emailQuery);
        
        if($emailCount != 0){
          $errors[] = 'That email already exists in our database.';
        }


    $required = array('name', 'email', 'password', 'confirm');
    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[] = 'You must fill out all fields';
        break;
      }
    }
    if(strlen($password) < 6){
      $errors[] = 'Your password must be atleast 6 characterss';
    }
    if($password != $confirm){
      $errors[] = 'Your password do not match';
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors[] = 'You must enter a valid email';
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //add user to database
    $hashed = password_hash($password,PASSWORD_DEFAULT);
      $db->query("INSERT INTO users1 (full_name,email,password,join_date) values('$name', '$email','$hashed',null)");
      $query1 = $db->query("SELECT * FROM users1 WHERE email = '$email'");
      $user = mysqli_fetch_assoc($query1);
      $user_id4 = $user['id'];
      login4($user_id4);
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
   <div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form action="adduser1" method="post">
      <h2 style="text-align: center;">Sign Up</h2>
      <hr class="colorgraph">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="name" id="name" class="form-control input-lg" placeholder="Full Name" value="<?=$name?>" tabindex="1">
          </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?=$email;?>" tabindex="4">
      </div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
      <div class="form-group">
        <div class="input-group" id="check_pass1">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" value="<?=$password?>" tabindex="5">
          </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
      <div class="form-group">
        <div class="input-group" id="check_pass2">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="confirm" id="confirm" class="form-control input-lg" placeholder="Confirm Password" value="<?=$confirm;?>" tabindex="6">
          </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 col-sm-3 col-md-3">
          
        </div>

      </div>

      <hr class="colorgraph">
      <div class="row">
        <div class="col-xs-6 col-md-6" style="float: right;"><input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
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
<?php include 'includes/footer.php';  
 ob_end_flush()
?>