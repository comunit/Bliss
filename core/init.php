<?php
session_start();
$db = mysqli_connect('localhost','root','','appareldatabase2');
if (mysqli_connect_errno()) {
	echo 'Data connection failed with following error:'. mysqli_connect_error();
	die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once BASEURL. '/helpers/helpers.php';
require BASEURL.'/vendor/autoload.php';
$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
	$cart_id = sanitize($_COOKIE[CART_COOKIE]);
}

if(isset($_SESSION['SBUser'])){
	$user_id = $_SESSION['SBUser'];
	$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fn[0];
	$user_data['last'] = $fn[1];
}
if(isset($_SESSION['SBUser1'])){
	$user_id1 = $_SESSION['SBUser1'];
	$query1 = $db->query("SELECT * FROM users1 WHERE id = '$user_id1'");
	$user_data1 = mysqli_fetch_assoc($query1);
	$fn = explode(' ', $user_data1['full_name']);
	$user_data1['first'] = $fn[0];
	$user_data1['last'] = $fn[1];
}



