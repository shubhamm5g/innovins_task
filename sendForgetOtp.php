<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
        echo json_encode(array('status'=>false,"msg"=>"User is already logged in."));
        exit;
    }
    $email = (isset($_POST['email']) && !empty( $_POST['email'])) ? $_POST['email'] :"";
    if(!empty($email)){
        $query="SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        if(empty($result)){
            echo json_encode(array('status'=>false,"msg"=>"Email not registered."));
            exit;
        }else{
            echo json_encode(array('status'=>true,"msg"=>"Please enter the otp 1234",'email'=>base64_encode($email)));
            exit;
        }

    }else{
        echo json_encode(array('status'=>false,"msg"=>"Email is are required."));
        exit;
    }
}else {
    echo json_encode(array('status'=>false,"msg"=>"Un-authorized access."));
    exit;
}



?>