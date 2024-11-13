<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
        echo json_encode(array('status'=>false,"msg"=>"User is already logged in."));
        exit;
    }
    $password = (isset($_POST['password']) && !empty( $_POST['password'])) ? $_POST['password'] :"";
    $email = (isset($_POST['email']) && !empty( $_POST['email'])) ? $_POST['email'] :"";
    if(!empty($email) && !empty($password)){
        $query="SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        if(empty($result)){
            echo json_encode(array('status'=>false,"msg"=>"Email not registered."));
            exit;
        }
        $password_hash = md5($password);

        $query="SELECT * FROM users WHERE email = '$email' AND password = '$password_hash'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result,MYSQLI_ASSOC);

        if(empty($result)){
            echo json_encode(array('status'=>false,"msg"=>"Wrong password."));
            exit;
        }

        if(!empty($result)){
            $_SESSION['innovins']['email'] = $result[0]['email'];
            $_SESSION['innovins']['id'] = $result[0]['id'];
            $_SESSION['innovins']['name'] = $result[0]['name'];

            echo json_encode(array('status'=>true,"msg"=>"User is logged in successfully."));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to logged in."));
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