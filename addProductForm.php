<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) {
        header("Location: signin.php");
        exit;
    }
    $name = (isset($_POST['name']) &&!empty( $_POST['name']))? $_POST['name'] :"";
    $description = (isset($_POST['email']) &&!empty( $_POST['email']))? $_POST['email'] :"";
    $price = (isset($_POST['password']) &&!empty( $_POST['password']))? $_POST['password'] :"";
    if(!empty($name) && !empty($email) && !empty($password)){

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
        echo json_encode(array('status'=>false,"msg"=>"Id is required."));
        exit;
    }


}else {
    echo json_encode(array('status'=>false,"msg"=>"Un-authorized access."));
    exit;
}



?>