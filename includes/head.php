<?php
$sql = 'SELECT * FROM categories WHERE parent = 0 AND hide = 0'; 
$pquery = $db->query($sql);
?>
  <div class="header">
    <div class="header-top">
      <div class="container">
        <div class="col-sm-4 world">

        </div>
        <div class="col-sm-4 logo">
          <a href="index.php">
            <img src="images/logo.png" alt="">
          </a>
        </div>
        <?php if(is_logged_in1()) : ?>
        <div class="col-sm-4 header-left">
          <div class="dropdown">
            <a data-target="#" href="page.html" data-toggle="dropdown" class="dropdown-toggle">Hello
              <?=$user_data1['first'];?>!
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="user.php" style="color: black;">My Account</a>
              </li>
              <li>
                <a href="logout.php" style="color: black;">Log Out</a>
              </li>
            </ul>
          </div>
          <?php else : ?>
          <div class="col-md-4 header-left">
            <p class="log">
              <a href="login.php">Login</a>
              <span>or</span>
              <a href="adduser.php">Signup</a>
            </p>
            <div class="clearfix"> </div>
          </div>
          <?php endif; ?>
          <div class="cart box_1">
            <h3>
              <div class="total">
                <a href="checkout.php">
                  <span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a>
              </div>
              <div class="clearfix"> </div>
          </div>
          <div class="clearfix"> </div>
        </div>
      </div>
      <div class="container">
        <div class="head-top">
          <div class="col-sm-2 number">
          </div>

          <ul class="memenu skyblue">
            <li class=" grid">
              <a href="index.php">Home</a>
            </li>
            <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
            <?php 
              $parent_id = $parent['id']; 
              $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id' AND hide = 0";
              $cquery = $db->query($sql2);
              ?>
            <li>
              <a href="#">
                <?=$parent["category"];?>
              </a>
              <div class="mepanel">
                <div class="row">
                  <div class="col1">
                    <div class="h_nav">
                      <ul>
                        <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
                        <li class="subitem1">
                          <a href="category?cat=<?=$child['id'];?>">
                            <?=$child["category"];?>
                          </a>
                        </li>
                        <?php endwhile ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <?php endwhile; ?>
            <li>
              <a class="color6" href="contact.php">Contact</a>
            </li>
          </ul>
        </div>

        <div class="clearfix"> </div>
        <?php 
     if(isset($_SESSION['success_flash'])){
  echo '<div style="font-style: italic; text-align: -webkit-center; padding-top: 10px;"><p class="text-success text-centre bg-success">'.$_SESSION['success_flash']. '</p></div>';

  unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
  echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash']. '</p></div>';
  unset($_SESSION['error_flash']);
}

     ?>
        <!-- pop-up-box   -->
        <link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
        <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
        <!-- pop-up-box -->
        <div id="small-dialog" class="mfp-hide">
          <div class="search-top">
            <div class="login">
              <input type="submit" value="">
              <input type="text" value="Type something..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">
            </div>
            <p> Shopping</p>
          </div>
        </div>
        <script>
          $(document).ready(function () {
            $('.popup-with-zoom-anim').magnificPopup({
              type: 'inline',
              fixedContentPos: false,
              fixedBgPos: true,
              overflowY: 'auto',
              closeBtnInside: true,
              preloader: false,
              midClick: true,
              removalDelay: 300,
              mainClass: 'my-mfp-zoom-in'
            });

          });
        </script>
      </div>
    </div>
  </div>