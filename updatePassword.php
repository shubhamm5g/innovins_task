<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
        echo json_encode(array('status'=>false,"msg"=>"User is already logged in."));
        exit;
    }
    $email = (isset($_POST['email']) && !empty( $_POST['email'])) ? base64_decode($_POST['email']) :"";
    $otp = (isset($_POST['otp']) && !empty( $_POST['otp'])) ? $_POST['otp'] :"";
    $password = (isset($_POST['password']) && !empty( $_POST['password'])) ? $_POST['password'] :"";
    if($otp!='1234'){
        echo json_encode(array('status'=>false,"msg"=>"Invalid OTP."));
        exit;
    }
    if(!empty($email) && !empty($password)){
        $query="SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        if(empty($result)){
            echo json_encode(array('status'=>false,"msg"=>"Invalid Email alread"));
            exit;
        }
        $password_hash = md5($password);

        $query = "UPDATE users set  password = '$password_hash' WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if($result){
            echo json_encode(array("status" => true, "msg" => "Password changed"));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to change password."));
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