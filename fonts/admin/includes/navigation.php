<?php
     $query = $db->query("SELECT * FROM `messages` WHERE `read` = 0");
     $messages = mysqli_num_rows($query);
?>
  <style>
    .badge1 {
   position:relative;
}
.badge1[data-badge]:after {
   content:attr(data-badge);
   position:absolute;
   top: 4px;
   right:-4px;
   font-size:.7em;
   background:green;
   color:white;
   width:18px;height:18px;
   text-align:center;
   line-height:18px;
   border-radius:50%;
   box-shadow:0 0 1px #333;
}
}
  </style>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ADMIN PANEL</a>
    </div>
    <ul class="nav navbar-nav">
      </li>
      <li><a href="index.php">My Dashboard</a></li>
      <li><a href="Categories.php">Categories</a></li>
      <li><a href="Products.php">Products</a></li>
      <li><a href="archived.php">Archived</a></li>
      <li><a href="customers.php">Customers List</a></li>
       <?php if ($messages > 0): ?>
      <li><a href="messages.php" class="badge1" data-badge="<?=$messages;?>">Messages</a></li>
       <?php else: ?>
      <li><a href="messages.php">Messages</a></li>
      <?php endif; ?>
       <?php if(has_permission('admin')): ?>
      <li><a href="users.php">Users</a></li>
       <?php endif; ?>
       <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>!
       <span class="caret"></span>
       </a>
       <ul class="dropdown-menu" role="menu"> 
       <li><a href="change_password.php">Change password</a></li>
       <li><a href="logout.php">Log Out</a></li>
    </ul>
  </div>
</nav>
    <?php 
     if(isset($_SESSION['success_flash'])){
  echo '<div class="bg-success"><p class="text-success text-centre" style="text-align: center;">'.$_SESSION['success_flash']. '</p></div>';
  unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
  echo '<div class="bg-danger"><p class="text-danger text-centre" style="text-align: center;">'.$_SESSION['error_flash']. '</p></div>';
  unset($_SESSION['error_flash']);
}

     ?>