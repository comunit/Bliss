<?php
 $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
 $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
 $min_price  = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
 $max_price  = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
 $b  = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
 $brandQ = $db->query("SELECT * FROM Categories WHERE category = 0'");
?>


<h3 class="text-centre" style="text-align: center;">Search By:</h3>
<h4 class="text-centre" style="text-align: center;">Price</h4>

<form action="search.php" method="post" style="text-align: center;">
  <input type="hidden" name="cat" value="<?=$cat_id;?>">
  <input type="hidden" name="price_sort" value="0">
  <input type="radio" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'');?>>Low to High<br>
  <input type="radio" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'');?>>High to Low<br><br>
  <input type="text" name="min_price" class="price-range" style="width: 55px" placeholder="Min £" value="<?=$min_price;?>" >To
  <input type="text" name="max_price" class="price-range" style="width: 55px" placeholder="Max £" value="<?=$max_price;?>"><br><br>
  <input type="submit" value="search" class="btn btn-xs btn-primary">
</form>