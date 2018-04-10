<?php 
 require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';
 $name = sanitize($_POST['full_name1']);
 $street = sanitize($_POST['street1']);
 $street2 = sanitize($_POST['street21']);
 $city = sanitize($_POST['city1']);
 $county = sanitize($_POST['county1']);
 $country = sanitize($_POST['country1']);
 $postcode = sanitize($_POST['postcode1']);
 $errors = array();
 $required = array(
    'full_name1' => 'Full Name',
    'street1'    => 'Street Address',
    'city1'      => 'City',
    'county1'    => 'County',
    'postcode1'  => 'Post Code',
    'country1'   => 'Country',
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
        echo 'good';
    }
 ?>