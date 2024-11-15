<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) {
        header("Location: signin.php");
        exit;
    }
    $name = (isset($_POST['name']) &&!empty( $_POST['name']))? $_POST['name'] :"";
    $description = (isset($_POST['description']) &&!empty( $_POST['description']))? $_POST['description'] :"";
    $price = (isset($_POST['price']) &&!empty( $_POST['price']))? $_POST['price'] :"";
    if(!(is_integer( $price) || $price>0)){
        echo json_encode(array('status'=>false,"msg"=>"Price must be a positive integer."));
        exit;
    }
    if(!empty($name) && !empty($description) && !empty($price)){

        $query = "INSERT INTO products (name, description, price) VALUES ('$name','$description','$price')";
        $result = mysqli_query($conn, $query);
        if($result){
            echo json_encode(array("status" => true, "msg" => "Product is added"));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to register Product."));
            exit;
        }
    }else{
        echo json_encode(array('status'=>false,"msg"=>"Required fields are missing."));
        exit;
    }


}else {
    echo json_encode(array('status'=>false,"msg"=>"Un-authorized access."));
    exit;
}



?>