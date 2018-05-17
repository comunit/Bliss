<?php
require_once 'core/init.php';
$productid = $_GET['id']; 
$sql = "SELECT * FROM products where ID='$productid'"; 
$product = $db->query($sql);
$products = mysqli_fetch_assoc($product);
$sql2 = "SELECT * FROM taka";
$takasql = $db->query($sql2);
$taka = mysqli_fetch_assoc($takasql);
$takaRate =  ($products['price'] * $taka['rate']);
?>

  <?php
  $sizestring = $products['sizes'];
  $sizestring = rtrim($sizestring, ',');
  $size_array = explode(',', $sizestring);
  ?>
    <div class="single">

      <div class="">
        <div class="col-md-3 hidden-xs hidden-sm">
          <?php include 'includes/sidecat.php'?>
        </div>
        <div class="col-md-9">
          <div class="col-md-5 ">
            <div class="flexslider">
              <ul class="slides">
                <?php $photos = explode(',',$products['image']);
                  foreach($photos as $photo):?>
                <li data-thumb="<?= $photo; ?>">
                  <div class="thumb-image" style="margin: 0 auto;">
                    <img src="<?= $photo; ?>" data-imagezoom="true" class="img-responsive"> </div>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="col-md-7 single-top-in">
            <div class="single-para simpleCart_shelfItem">
              <h1>
                <?= $products['title'] ?>
              </h1>
              <p>
                <?= html_entity_decode($products['description'])?>
              </p>
              <div class="star-on">

                <div class="review">

                </div>
                <div class="clearfix"> </div>
              </div>

              <label class="add-to item_price">Taka: 
                <?= number_format($takaRate, 2) ?>/-
              </label>

              <span id='model_errors' class="bg-danger"></span>
              <form action="add_cart" method="post" id="add_product_form">
                <input type="hidden" name="available" id="available" value="">
                <input type="hidden" name="product_id" value="<?=$productid?>">
                <div class="available">
                  <div class="form-group col-lg-6 make-inline">
                    <label>Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Available</label>
                    <ul>
                      <li>
                        <select name="size" id="size">
                          <option value=""></option>
                          <?php foreach($size_array as $string) {
                          $string_array = explode(':', $string);
                          $size = $string_array[0];
                          $available = $string_array[1];
                          echo '<option value="'.$size.'"data-available="'.$available.'">'.$size.' ('.$available.' available)</option>';
                        } ?>
                        </select>
                      </li>
                    </ul>
              </form>
              </div>
              <button class="btn btn-warning" onclick="add_to_cart();return false" style="float: right;">
                <span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
              </div>
            </div>

          </div>
          <div class="clearfix"> </div>
          <div class="content-top1">
            <div class="col-md-4 col-md3">
            </div>
            <div class="col-md-4 col-md3">

            </div>

            <div class="clearfix"> </div>
          </div>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
    <script>
      jQuery('#size').change(function () {
        var available = jQuery('#size option:selected').data("available");
        jQuery('#available').val(available);
      });
    </script>
    <link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
    <script>
      < script src = "js/jquery.min.js" >
    </script>
    <script src="js/imagezoom.js"></script>
    <script type="text/javascript" src="js/memenu.js"></script>
    <script src="js/simpleCart.min.js">
    </script>
    <script type="text/javascript">
      $(function () {
        var menu_ul = $('.menu-drop > li > ul'),
          menu_a = $('.menu-drop > li > a');
        menu_ul.hide();
        menu_a.click(function (e) {
          e.preventDefault();
          if (!$(this).hasClass('active')) {
            menu_a.removeClass('active');
            menu_ul.filter(':visible').slideUp('normal');
            $(this).addClass('active').next().stop(true, true).slideDown('normal');
          } else {
            $(this).removeClass('active');
            $(this).next().stop(true, true).slideUp('normal');
          }
        });

      });
    </script>
    <script defer src="js/jquery.flexslider.js"></script>
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

    <script>
      $(window).load(function () {
        $('.flexslider').flexslider({
          animation: "slide",
          controlNav: "thumbnails"
        });
      });
    </script>
    <link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
    <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
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
    </body>

    </html>