<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      if(!is_logged_in()){
     login_error_redirect();
 }
     include 'includes/head.php';
     include 'includes/navigation.php';
     $presults = $db->query("SELECT * FROM taka"); 
     $product = mysqli_fetch_assoc($presults);

     // saving new rate to database
     if(isset($_GET['taka'])){
      $taka = sanitize($_GET['taka']);
      $db->query("UPDATE taka SET rate = '$taka'");
      header('Location: taka-rate.php');
      }   
?>
  <h2 class="text-center">Taka rate list</h2>
  <div class="clearfix"></div>
  <hr>

  <div class="container text-center">
    <div class="row">
      <div class="col-md-6">
        <form>
          <div class="form-group">
            <label for="email">Reset the rate:</label>
            <input type="text" name="taka" id="taka" class="form-control">
          </div>
          <div class="form-group text-center">
            <input type="submit" value="Reset" class="btn btn-primary">
          </div>
        </form>
      </div>

      <div class="col-md-6">
          <div class="rate">
            <h2>Current Rate: ৳<?php echo $product['rate']; ?> </h2>
          </div>
      </div>
    </div>
  </div>
  <hr>
  <?php include 'includes/footer.php';  ?>