<?php
if(isset($_GET['id'])){
	$id = sanitize($_GET['id']);
}else{
	$id = '';
}

$sql = "SELECT * FROM products WHERE id = '$id'"; 
$pquery = $db->query($sql);
$categoryId = mysqli_fetch_assoc($pquery);
$getCatId = $categoryId['categories'];

$sql2 = "SELECT * FROM categories WHERE id = '$getCatId'";
$hquery = $db->query($sql2);
$getParentId = mysqli_fetch_assoc($hquery);
$parentId = $getParentId['parent'];
?>
<style>
  .sidecat {
    border: 1px solid #53d0c4;
    text-align: center;
  }

  .sidecat li {
    list-style-type: none;
    margin: 5px;
    background-color: #FFF8DC;
  }

  .sidecat li:hover {
    background-color: blanchedalmond;
    cursor: pointer;
    font-size: 1.1rem;
  }

  .catname h3 {
    background-color: #52d0c4;
    text-align: center;
  }

  .sidecat li a {
    color: black;
  }
</style>
<div class="catname">
 <?php
  $sql3 = "SELECT * FROM categories WHERE id = '$parentId'";
  $getCat = $db->query($sql3);
  $getCatName = mysqli_fetch_assoc($getCat);
 ?>
  <h3><?=$getCatName["category"];?></h3>
</div>
<div class="sidecat">
<?php 
  $sql4 = "SELECT * FROM categories WHERE parent = '$parentId'";
  $getChild = $db->query($sql4);
?>
  <ul>
  <?php while($child = mysqli_fetch_assoc($getChild)) : ?>
     <li class="subitem1">
          <a href="category?cat=<?=$child['id'];?>">
              <?=$child["category"];?>
          </a>
      </li>
  <?php endwhile ?>
  </ul>
</div>