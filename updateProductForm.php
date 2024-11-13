<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) {
        header("Location: signin.php");
        exit;
    }
    $id = (isset($_POST['id']) && !empty( $_POST['id'])) ? $_POST['id'] :"";
    $name = (isset($_POST['name']) &&!empty( $_POST['name']))? $_POST['name'] :"";
    $price = (isset($_POST['price']) &&!empty( $_POST['price']))? $_POST['price'] :"";
    $description = (isset($_POST['description']) &&!empty( $_POST['description']))? $_POST['description'] :"";
    if(!(is_integer( $price) || $price>0)){
        echo json_encode(array('status'=>false,"msg"=>"Price must be a positive integer."));
        exit;
    }
    if(!empty($id) &&!empty($name) && !empty($description) && !empty($price)){

        $query="update products set name='$name',price=$price,description='$description' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if($result){
            echo json_encode(array("status" => true, "msg" => "Product Updated Successfully", "data" => $result));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to update Product."));
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