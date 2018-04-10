<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
      if(!is_logged_in()){
     login_error_redirect();
 }
     include 'includes/head.php';
     include 'includes/navigation.php';

     //Delete Product
     if(isset($_GET['delete'])){
          $id = sanitize($_GET['delete']);
          $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
          header('Location: products.php');
     } 
     $dbpath = '';
     if(isset($_GET['add']) || isset($_GET['edit'])) {
          $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
          $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
          $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']) : '');
          $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']) : '');
          $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']) : '');
          $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']) : '');
          $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']) : '');
          $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']) : '');
          $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']) : '');
          $sizes = rtrim($sizes,',');
          $saved_image = '';
          if(isset($_GET['edit'])) {
               $edit_id = (int)$_GET['edit'];
               $productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
               $product = mysqli_fetch_assoc($productResults);
               if(isset($_GET['delete_image'])){
                    $imgi = (int)$_GET['imgi'] - 1;
                    $images = explode(',',$product['image']);
                    $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
                    unlink($image_url);
                    unset($images[$imgi]);
                    $imageString = implode(',',$images);
                    $db->query("UPDATE products SET Image = '$imageString' WHERE id = '$edit_id'");
                    header('Location: products?edit='.$edit_id);
               }
               
               $title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']) : $product['title']);
               $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']) : $product['brand']);
               $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']) : $product['categories']);
               $parentQ = $db->query("SELECT * FROM categories WHERE id = '{$category}'");
               $parentResult = mysqli_fetch_assoc($parentQ);
               $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']) : $parentResult['parent']);
               $price = ((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']) : $product['price']);
               $description = ((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']) : $product['description']);
               $sizes = ((isset($_POST['sizes']) && !empty($_POST['sizes']))?sanitize($_POST['sizes']) : $product['sizes']);
               $sizes = rtrim($sizes,',');
               $saved_image = (($product['image'] != '')?$product['image']:'');
               $dbpath = $saved_image;

          }
           if(!empty($sizes)) {
                    $sizeString = sanitize($sizes);
                    $sizeString = rtrim($sizeString,',');
                    $sizesArray = explode(',',$sizeString);
                    $sArray = array();
                    $qArray = array();
                    $tArray = array();
                    foreach($sizesArray as $ss) {
                         $s = explode(':', $ss);
                         $sArray[] = $s[0];
                         $qArray[] = $s[1];
                         $tArray[] = $s[2];
                    }
               } else {
                    $sizesArray = array();
               }
          if($_POST) {
               //$title = sanitize($_POST['title']);
               //$brand = sanitize($_POST['brand']);
               $categories = sanitize($_POST['child']);
               $price = sanitize($_POST['price']);
               $sizes = sanitize($_POST['sizes']);
               $photoName = array();
               $description = sanitize($_POST['description']);
               $errors = array();
               
               $required = array('title', 'price', 'parent', 'child', 'sizes');
               $allowed = array('png', 'jpg', 'jpeg', 'gif');
               $tmpLoc = array();
               $uploadPath = array();
               foreach($required as $field) {
                    if($_POST[$field] == '') {
                         $errors[] = 'All fields with an anterisk are required!';
                         break;
                    }
               }
               $photoCount = count($_FILES['photo']['name'] ); 
                if($photoCount > 0 && $_FILES['photo']['name'] )  {
                    for($i = 0;$i<$photoCount;$i++){
                      if ($_FILES['photo']['error'][$i] > 0) {
                      $errors[] .= 'Please choose a image.';
                      } else {
                     $name = $_FILES['photo']['name'][$i];
                     $nameArray = explode('.', $name);
                     $fileName = $nameArray[0];
                     $fileExt = $nameArray[1];
                     $mime = explode('/', $_FILES['photo']['type'][$i]);
                     $mimeType = $mime[0];
                     $mimeExt = $mime[1];
                     $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
                     $fileSize = $_FILES['photo']['size'][$i];
                     $uploadName = $name;
                     $uploadPath[] = BASEURL.'/admin/productimages/'.$uploadName;
                     if ($i != 0) {
                          $dbpath .= ',';
                     }
                     $dbpath .= '/admin/productimages/'.$uploadName;
            
                     if($mimeType != 'image') {
                          $errors[] .= 'The file must be an image.';
                     }
                     if(!in_array($fileExt, $allowed)) {
                          $errors[] .= 'The file extension must be a png, jpg, jpeg, or gif.';
                     }
                     if($fileSize > 15000000) {
                          $errors[] .= 'The file size must be under 15 megabytes.';
                     }
                     if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
                       $errors[] = 'File extension does not match the file';
                     }
                    }
                      }
                     
                }
               
               if(!empty($errors)) {
                    echo display_errors($errors);
               } else {
                     if($photoCount > 0){
                     /* Upload file and insert into database. */
                     for($i = 0;$i<$photoCount;$i++){
                     move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
                    }
                }
                    $insertSql = "INSERT INTO products (title, price, list_price, brand, categories, image, description, sizes) VALUES ('{$title}', '{$price}', '{$list_price}', '{$brand}', '{$category}', '{$dbpath}', '{$description}', '{$sizes}')";
                    if (isset($_GET['edit'])) {
                      $insertSql = "UPDATE products SET title = '$title', price = '$price', categories= '$category', sizes = '$sizes', image = '$dbpath', description = '$description' WHERE id ='$edit_id'";
                    }
                    $db->query($insertSql);
                    header("Location: products.php");
               }
          }
?>

<!-- Form -->
<h2 class="text-center"><?php echo ((isset($_GET['edit']))?'Edit' : 'Add A New'); ?> Product</h2>
<hr>

<form class="form" action="products.php?<?php echo ((isset($_GET['edit']))?'edit='.$edit_id : 'add=1'); ?>" method="post" enctype="multipart/form-data">
     <div class="form-group col-md-3">
          <label for="title">Title*:</label>
          <input class="form-control" type="text" name="title" id="title" value="<?php echo $title; ?>">
     </div>
     <div class="form-group col-md-3">
          <label for="parent">Parent Category*:</label>
          <select class="form-control" name="parent" id="parent">
               <option value=""<?=(($parent == '')?' selected' : ''); ?>></option>
               <?php while($p = mysqli_fetch_assoc($parentQuery)) : ?>
               <option value="<?=$p['id']; ?>"<?=(($parent == $p['id'])?' selected' : ''); ?>><?php echo $p['category']; ?></option>
               <?php endwhile; ?>
          </select>
     </div>
     <div class="form-group col-md-3">
          <label for="child">Child Category*:</label>
          <select class="form-control" name="child" id="child"></select>
     </div>
     <div class="form-group col-md-3">
          <label for="price">Price*:</label>
          <input class="form-control" type="text" name="price" id="price" value="<?=$price; ?>">
     </div>
     <div class="form-group col-md-3">
          <label>Quantity &amp; Sizes*:</label>
          <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity &amp; Sizes</button>
     </div>
     <div class="form-group col-md-3">
          <label for="sizes">Sizes &amp; Quantity Preview</label>
          <input class="form-control" type="text" name="sizes" id="sizes" value="<?=$sizes; ?>" readonly>
     </div>
     <div class="form-group col-md-6">
          <label for="description">Description</label>
          <textarea class="form-control" name="description" id="description" rows="6"><?=$description; ?></textarea>
     </div>
     <div class="form-group col-md-6">
     <?php if ($saved_image != ''):  ?>
          <?php
          $imgi = 1;
          $images = explode(',',$saved_image); ?>
          <?php foreach($images as $image) : ?>
               <div class="saved_image col-md-4" style="text-align: center;"><img src="<?=$image;?>" alt="saved_image" style="
    width: 200;
    height: auto;
    text-align: center;
"><br>
     <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
     </div>
<?php
$imgi++;
 endforeach; ?>
          <?php else: ?>
          <input class="form-control" type="file" name="photo[]" id="photo" multiple>
     <?php endif; ?>
     </div>
     <div class="form-group pull-right clearfix">
          <a class="btn btn-default" href="products.php">Cancel</a>
          <input class="btn btn-success" type="submit" value="<?php echo ((isset($_GET['edit']))?'Edit' : 'Add'); ?> Product">
     </div>
     <div class="clearfix"></div>
</form>


<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
     <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sizesModalLabel">Size &amp; Quantity</h4>
               </div>
               <div class="modal-body">
                    <div class="container-fluid">
                         <?php for($i = 1; $i <= 12; $i++) : ?>
                         <div class="form-group col-md-2">
                              <label for="size<?php echo $i; ?>">Size:</label>
                              <input class="form-control" type="text" name="size<?php echo $i; ?>" id="size<?php echo $i; ?>" value="<?php echo ((!empty($sArray[$i-1]))?$sArray[$i-1] : ''); ?>">
                         </div>
                         <div class="form-group col-md-2">
                              <label for="qty<?php echo $i; ?>">Quantity:</label>
                              <input class="form-control" type="number" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo ((!empty($qArray[$i-1]))?$qArray[$i-1] : ''); ?>" min="0">
                         </div>
                         <div class="form-group col-md-2">
                              <label for="threshold<?php echo $i; ?>">Threshold:</label>
                              <input class="form-control" type="number" name="threshold<?php echo $i; ?>" id="threshold<?php echo $i; ?>" value="<?php echo ((!empty($tArray[$i-1]))?$tArray[$i-1] : ''); ?>" min="0">
                         </div>
                         <?php endfor; ?>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
               </div>
          </div>
     </div>
</div>


<?php
     } else {
     $presults = $db->query("SELECT * FROM products WHERE deleted = 0");
     if(isset($_GET['featured'])) {
          $id = (int)$_GET['id'];
          $featured = (int)$_GET['featured'];
          $db->query("UPDATE products SET featured = '{$featured}' WHERE id = '{$id}'");
          header("Location: products.php");
     }
?>


<!-- Table -->
<h2 class="text-center">Products</h2>
<a class="btn btn-success pull-right" id="add-product-btn" href="products.php?add=1">Add Product</a>
<div class="clearfix"></div>
<hr>

<table class="table table-bordered table-condensed table-striped">
     <thead>
          <th></th>
          <th>Product</th>
          <th>Price</th>
          <th>Category</th>
          <th>Featured</th>
          <th>Sold</th>
     </thead>
     <tbody>
          <?php while($product = mysqli_fetch_assoc($presults)) : 
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
                    <a class="btn btn-xs btn-default" href="products.php?edit=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a class="btn btn-xs btn-default" href="products.php?delete=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
               </td>
               <td><?php echo $product['title']; ?></td>
               <td><?php echo money($product['price']); ?></td>
               <td><?php echo $category; ?></td>
               <td>
                    <a class="btn btn-xs btn-default" href="products.php?featured=<?php echo (($product['featured'] == 0)?'1' : '0'); ?>&id=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-<?php echo (($product['featured'] == 1)?'minus': 'plus'); ?>"></span></a>&nbsp; <?php echo (($product['featured'] == 1)?'Featured Product' : ''); ?>
               </td>
               <td>0</td>
          </tr>
          <?php endwhile; ?>
     </tbody>
</table>


<?php
     }
     include 'includes/footer.php'; ?>
<script>
     jQuery('document').ready(function(){
          get_child_options('<?=$category;?>');
     });
</script>