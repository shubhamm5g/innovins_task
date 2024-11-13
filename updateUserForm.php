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
    $email = (isset($_POST['email']) &&!empty( $_POST['email']))? $_POST['email'] :"";
    if(!empty($id)&& !empty($name)&& !empty($email)){

        $query="update users set name='$name',email='$email' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if($result){
            echo json_encode(array("status" => true, "msg" => "User Updated Successfully", "data" => $result));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to update user."));
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