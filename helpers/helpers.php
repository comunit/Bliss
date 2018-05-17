<?php 
ob_start();
function display_errors($errors) {
	$display = '<ul class="bg-danger text-center">';
	foreach($errors as $error) {
		$display .= '<div class="text-danger">' . $error . '</div>';
	}
	$display .= '</ul>';
	return $display;
}
function sanitize($dirty) {
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}
function money($number) {
	return '৳' . number_format($number, 2);
}


function login($user_id){
	$_SESSION['SBUser'] = $user_id;
	global $db;
	$date = date("y-m-d h:i:s");
	$db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('location: index.php');
}
function login2($user_id1){
	$_SESSION['SBUser1'] = $user_id1;
	global $db;
	$date1 = date("y-m-d h:i:s");
	$db->query("UPDATE users1 SET last_login = '$date1' WHERE id = '$user_id1'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('location: user.php');
}
function login3($user_id3){
	$_SESSION['SBUser1'] = $user_id3;
	global $db;
	$date1 = date("y-m-d h:i:s");
	$db->query("UPDATE users1 SET last_login = '$date1' WHERE id = '$user_id3'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('location: checkout.php');
}
function login4($user_id4){
	$_SESSION['SBUser1'] = $user_id4;
	global $db;
	$date2 = date("d-m-y h:i:s");
	$db->query("UPDATE users1 SET last_login = '$date2' WHERE id = '$user_id4'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('location: checkout.php');
}
function is_logged_in1(){
	if(isset($_SESSION['SBUser1']) && $_SESSION['SBUser1'] > 0) {
		return true;
	}
	return false;
}
function is_logged_in(){
	if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0) {
		return true;
	}
	return false;
}
function login_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You must logged in to access this page';
	header('location: '.$url);
}
function login_error_redirect1($url = 'login.php'){
	$_SESSION['error_flash'] = 'You must logged in to access this page';
	header('location: '.$url);
}

function permission_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You do not have permission to access this page';
	header('location: '.$url);
}

function has_permission($permissions = 'admin'){
	global $user_data;
	$permission = explode(',', $user_data['permissions']);
	if(in_array($permissions,$permission,true)){
		return true;
	}
	    return false;
}
function pretty_date($date){
	return date("M d, Y h:i a",strtotime($date));
}

function get_category($child_id){
	global $db;
	$id = sanitize($child_id);
	$sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
	        FROM categories c
	        INNER JOIN categories p 
            ON c.parent = p.id
            WHERE c.id = '$id'";
$query = $db->query($sql);
$category = mysqli_fetch_assoc($query);
return $category;
}
function sizesToArray($string){
	$sizesArray = explode(',', $string);
	$returnArray = array();
	foreach($sizesArray as $size){
		$s = explode(':',$size);
	    $returnArray[] = array('size' => $s[0], 'quantity' => $s[1],'threshold' => $s[2]);
	}
	return $returnArray;    
}
function sizesToString($sizes){
	$sizeString = '';
	foreach($sizes as $size){
		$sizeString .= $size['size'].':'.$size['quantity'].':'.$size['threshold'].',';
	}
	$trimmed = rtrim($sizeString, ',');
	return $trimmed;
}
function encryptor($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    //pls set your unique hashing key
    $secret_key = 'app';
    $secret_iv = 'app123';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
    	//decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}