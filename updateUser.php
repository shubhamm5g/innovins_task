<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    require_once('utils/db.php');
    if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) {
        header("Location: signin.php");
        exit;
    }
    $id = (isset($_POST['id']) && !empty( $_POST['id'])) ? $_POST['id'] :"";
    if(!empty($id)){
        $query="SELECT id,name,email from users WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        if($result){
            echo json_encode(array("status" => true, "msg" => "User Detials", "data" => $result));
            exit;
        }else{
            echo json_encode(array('status'=>false,"msg"=>"Failed to delete user."));
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