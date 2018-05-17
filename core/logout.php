<?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
 unset($_SESSION['SBUser1']);
 header('Location: login.php');
?>