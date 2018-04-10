<?php 
 require_once $_SERVER['DOCUMENT_ROOT'].'/project/core/init.php';
 $name = sanitize($_POST['full_name']);
 $email = sanitize($_POST['email']);
 $street = sanitize($_POST['street']);
 $street2 = sanitize($_POST['street2']);
 $city = sanitize($_POST['city']);
 $county = sanitize($_POST['county']);
 $country = sanitize($_POST['country']);
 $postcode = sanitize($_POST['postcode']);
 $errors = array();
 $required = array(
 	'full_name' => 'full Name',
 	'email'     => 'Email',
 	'street'    => 'Street Address',
 	'city'      => 'City',
 	'county'    => 'County',
 	'postcode'  => 'Post Code',
 	'country'   => 'Country',
 	);

    //check if all required fields are filled out
    foreach($required as $f => $d){
    	if(empty($_POST[$f]) || $_POST[$f] == ''){
    		$errors[] = $d.' is required.';
    	}
    }

    if(!empty($errors)){
    	echo display_errors($errors);
    }else{
        echo 'passed';
    }
 ?>