<?php
if(isset($_GET['cat'])){
	$id = sanitize($_GET['cat']);
}else{
	$id = '';
}

$sql2 = "SELECT * FROM categories WHERE id = '$id' AND hide = 0";
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
  $sql3 = "SELECT * FROM categories WHERE id = '$parentId' AND hide = 0";
  $getCat = $db->query($sql3);
  $getCatName = mysqli_fetch_assoc($getCat);
 ?>
  <h3><?=$getCatName["category"];?></h3>
</div>
<div class="sidecat">
<?php 
  $sql4 = "SELECT * FROM categories WHERE parent = '$parentId' AND hide = 0";
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