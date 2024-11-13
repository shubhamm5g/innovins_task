<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
        echo json_encode(array('status'=>false,"msg"=>"User is already logged in."));
        exit;
    }
    $name = (isset($_POST['name']) && !empty( $_POST['name'])) ? $_POST['name'] :"";
    $password = (isset($_POST['password']) && !empty( $_POST['password'])) ? $_POST['password'] :"";
    $email = (isset($_POST['email']) && !empty( $_POST['email'])) ? $_POST['email'] :"";
    if(!empty($name) && !empty($email) && !empty($password)){
        $query="SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        if(!empty($result)){
            echo json_encode(array('status'=>false,"msg"=>"Email already exists."));
            exit;
        }
        $password_hash = md5($password);

        $query = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password_hash')";
        $result = mysqli_query($conn, $query);
        if($result){
            echo json_encode(array("status" => true, "msg" => "User is registered"));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to register user."));
            exit;
        }
    }else{
        echo json_encode(array('status'=>false,"msg"=>"All fields are required."));
        exit;
    }


}else {
    echo json_encode(array('status'=>false,"msg"=>"Un-authorized access."));
    exit;
}



?>