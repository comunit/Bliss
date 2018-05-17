<?php 
 require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
 $name = sanitize($_POST['full_name']);
 $number = sanitize($_POST['number']);
 $street = sanitize($_POST['street']);
 $street2 = sanitize($_POST['street2']);
 $city = sanitize($_POST['city']);
 $errors = array();
 $required = array(
 	'full_name' => 'Full Name',
 	'number'     => 'Contact Number',
 	'street'    => 'Street Address',
 	'city'      => 'City',
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