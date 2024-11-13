<?php
require_once('header.php');
if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
    header("Location: index.php");
    exit;
}

$email = $_GET['id'];

if(empty($email)){
    header("Location: forget-password.php");
    exit;
}
?>

<div class="container-fluid px-4 pt-2">
    <h2 class="text-center my-4">OTP Verification</h2>
    <div class="d-flex justify-content-center ">
        <div class="card p-2 w-50 ">
            <form id="verfiyOtp" >
                <input type="hidden" name="email" value="<?= $email ?>">
                <div class="row">
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="otp" class="form-control" id="otp" name="otp" placeholder="Enter OTP ">
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password ">
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter Confirm Password ">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-12 text-center">
                        <button type="submit" class="btn btn-primary">Forget Password</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

     $('#verfiyOtp').validate({
        rules: {
            otp: {
                required: true,
                maxlength: 4,
                minlength:4,
                number:true
            },
            password: {
                required: true,
                minlength: 5,
            },
            confirmPassword: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        messages: {

            otp: {
                required: "Please enter OTP",

                maxlength: "OTP should be 4 digits",
                number: "OTP should be a number",
                minlength: "OTP should be 4 digits"
            },
            password: {
                required: 'Please enter Password.',
                minlength: 'Password should be at least 5 characters long.'
            },
            confirmPassword: {
                required: 'Please enter Confirm Password.',
                minlength: 'Confirm Password should be at least 5 characters long.',
                equalTo: 'Confirm Password do not match with Password.'
            }
        },
        submitHandler: function (form) {
            $("#verfiyOtp").ajaxSubmit({
                url: "updatePassword.php",
                type: 'post',
                dataType: 'json',
                clearForm: false,
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        customtoater("success",response.msg);
                        setTimeout(function(){
                            window.location.href = "signin.php";
                        },1000);

                    }else{
                        $(".fulloverlay").fadeOut();
                        customtoater("error",response.msg);
                    }
                },
                error: function (error) {
                    $(".fulloverlay").fadeOut();
                    customtoater("error","Server error");
                }
            })
        }
    });
</script>